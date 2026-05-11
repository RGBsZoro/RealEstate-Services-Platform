<?php

namespace App\Services\Api;

use App\Enum\StatusEnum;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Notifications\ServiceRequestStatusNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
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
        $service->businessAccount->user->notify(new ServiceRequestStatusNotification($serviceRequest));
    }

    public function updateStatus(string $newStatus, ServiceRequest $serviceRequest)
    {
        $this->authorizeOwner($serviceRequest, $this->user);

        DB::transaction(function () use ($newStatus, $serviceRequest) {

            $serviceRequest->update(['status' => $newStatus]);

            if ($newStatus === StatusEnum::APPROVED->value) {
                $service = $serviceRequest->service;

                if (!is_null($service->quantity)) {

                    if ($service->quantity >= $serviceRequest->quantity) {
                        $service->decrement('quantity', $serviceRequest->quantity);
                    } else {
                        throw ValidationException::withMessages([
                            'quantity' => ['Unfortunately, the quantity currently available is less than what is required.']
                        ]);
                    }
                }
            }
        });
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

    public function destroy(ServiceRequest $serviceRequest)
    {
        if ($this->user->id != $serviceRequest->user_id)
            throw new AuthorizationException();

        if ($serviceRequest->status != 'pending')
            throw ValidationException::withMessages(['status' => ['Only pending requests can be deleted.']]);

        $serviceRequest->delete();
    }

    private function authorizeOwner(ServiceRequest $serviceRequest, $user)
    {
        $isOwner = $user->businessAccounts()
            ->where('id', $serviceRequest->provider_business_account_id)
            ->exists();

        if (!$isOwner)
            throw new AuthorizationException();
    }
}
