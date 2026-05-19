<?php

namespace App\Services\Api;

use App\Enum\ServiceRequestStatusEnum;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Notifications\ServiceRequestStatusNotification;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ServiceRequestService
{
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function store(array $data)
    {
        $service = Service::findOrFail($data['service_id']);

        $existing = $service->requests()->where('user_id', $this->user->id)
            ->where('status', 'pending')
            ->exists();

        if ($existing)
            throw ValidationException::withMessages(
                ['service_id' => ['You already have a pending request for this service.']]
            );

        $serviceRequest = $service->requests()->create([
            'user_id' => $this->user->id,
            'provider_business_account_id' => $service->business_account_id,
            'requester_business_account_id' => $data['requester_business_account_id'],
            'required_at' => $data['required_at'],
            'quantity' => $data['quantity'] ?? null,
            'details' => $data['details'] ?? null,
            'price_usd_at_request' => $service->price_usd,
            'price_syp_at_request' => $service->price_syp,
        ]);

        // send notification
        $service->businessAccount->user->notify(new ServiceRequestStatusNotification($serviceRequest, 'created'));
    }

    public function update(array $data, ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status != ServiceRequestStatusEnum::PENDING->value)
            throw ValidationException::withMessages(['status' => ['This request has already been processed and cannot be changed.']]);

        $serviceRequest->update([
            'requester_business_account_id' => $data['requester_business_account_id'],
            'required_at' => $data['required_at'],
            'quantity' => $data['quantity'] ?? null,
            'details' => $data['details'] ?? null,
        ]);

        // send notification
        $serviceRequest->service->businessAccount->user->notify(new ServiceRequestStatusNotification($serviceRequest, 'updated'));
    }

    public function updateStatus(string $newStatus, ServiceRequest $serviceRequest)
    {
        $this->authorizeOwner($serviceRequest, $this->user);

        if ($serviceRequest->status != ServiceRequestStatusEnum::PENDING->value)
            throw ValidationException::withMessages(['status' => ['This request has already been processed and cannot be changed.']]);

        DB::transaction(function () use ($newStatus, $serviceRequest) {
            $serviceRequest->lockForUpdate();

            if ($newStatus === ServiceRequestStatusEnum::APPROVED->value) {

                $service = $serviceRequest->service()->lockForUpdate()->first();

                if (!is_null($service->quantity)) {
                    if ($service->quantity < $serviceRequest->quantity) {
                        throw ValidationException::withMessages(['quantity' => 'Unfortunately, the quantity currently available is less than what is required.']);
                    }
                    $service->decrement('quantity', $serviceRequest->quantity);
                }

                $this->rejectConflictingRequests($serviceRequest);
            }

            $serviceRequest->update(['status' => $newStatus]);
        });
        // send notification
        $action = $newStatus === ServiceRequestStatusEnum::APPROVED->value ? 'approved' : 'rejected';
        $serviceRequest->user->notify(new ServiceRequestStatusNotification($serviceRequest, $action));
    }

    public function getAllMyRequests()
    {
        return [
            'sent' => $this->user->serviceRequests()
                ->with(['service:id,title', 'providerBusinessAccount:id,name'])
                ->latest()
                ->cursorPaginate(15, ['*'], 'sent_cursor'),

            'received' => $this->user->receivedServiceRequests()
                ->with(['service:id,title', 'requesterBusinessAccount:id,name'])
                ->latest()
                ->cursorPaginate(15, ['*'], 'received_cursor'),
        ];
    }

    public function cancel(ServiceRequest $serviceRequest)
    {
        Gate::authorize('update', $serviceRequest);

        if ($serviceRequest->status != ServiceRequestStatusEnum::PENDING->value)
            throw ValidationException::withMessages(['status' => ['You can only cancel pending requests.']]);

        $serviceRequest->update(['status' => ServiceRequestStatusEnum::CANCELLED->value]);

        // send notification
        $serviceRequest->service->businessAccount->user->notify(new ServiceRequestStatusNotification($serviceRequest, 'cancelled'));
    }

    public function getBookedTimeSlots(Service $service)
    {
        return $service->requests()
            ->where('status', ServiceRequestStatusEnum::APPROVED->value)
            ->where('required_at', '>=', now())
            ->pluck('required_at')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d H:i'));
    }

    public function getMyCalendarEvents($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $sent = $this->user->serviceRequests()
            ->whereIn('status', [ServiceRequestStatusEnum::APPROVED->value, ServiceRequestStatusEnum::PENDING->value])
            ->whereBetween('required_at', [$start, $end])
            ->with('service:id,title')
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'title' => 'Issued request: ' . $request->service->title,
                    'date' => $request->required_at,
                    'type' => 'sent',
                    'status' => $request->status,
                ];
            });

        $received = $this->user->receivedServiceRequests()
            ->whereIn('status', [ServiceRequestStatusEnum::APPROVED->value])
            ->whereBetween('required_at', [$start, $end])
            ->with('service:id,title')
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'title' => 'Incoming request: ' . $request->service->title,
                    'date' => $request->required_at,
                    'type' => 'received',
                    'status' => $request->status,
                ];
            });

        return $sent->merge($received);
    }

    private function authorizeOwner(ServiceRequest $serviceRequest, $user)
    {
        $isOwner = $user->businessAccounts()
            ->where('id', $serviceRequest->provider_business_account_id)
            ->exists();

        if (!$isOwner)
            throw new AuthorizationException();
    }

    private function rejectConflictingRequests(ServiceRequest $approvedRequest)
    {
        $conflictingRequests = ServiceRequest::where('service_id', $approvedRequest->service_id)
            ->where('id', '!=', $approvedRequest->id)
            ->where('status', ServiceRequestStatusEnum::PENDING->value)
            ->where('required_at', $approvedRequest->required_at)
            ->get();

        foreach ($conflictingRequests as $request) {
            $request->update(['status' => ServiceRequestStatusEnum::REJECTED->value]);

            // send notification to requester about rejection due to conflict with approved request
            $request->user->notify(new ServiceRequestStatusNotification($request, 'rejected'));
        }
    }
}
