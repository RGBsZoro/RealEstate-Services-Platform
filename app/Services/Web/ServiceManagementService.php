<?php

namespace App\Services\Web;

use App\Enum\StatusEnum;
use App\Models\Service;
use App\Notifications\ServiceRequestStatusNotification;
use Illuminate\Validation\ValidationException;

class ServiceManagementService
{
    public function index(array $data)
    {
        $baseQuery = Service::all();

        $stats = [
            'pending'  => (clone $baseQuery)->where('status', StatusEnum::PENDING->value)->count(),
            'approved' => (clone $baseQuery)->where('status', StatusEnum::APPROVED->value)->count(),
            'rejected' => (clone $baseQuery)->where('status', StatusEnum::REJECTED->value)->count(),
            'inactive' => (clone $baseQuery)->where('status', StatusEnum::INACTIVE->value)->count(),

        ];

        $query = Service::with(['businessAccount', 'category'])
            ->where('status', '!=', 'draft');

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (!empty($data['type'])) {
            $query->where('type', $data['type']);
        }

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('businessAccount', function ($sub) use ($search) {
                        $sub->where('name->en', 'like', "%{$search}%")
                            ->orWhere('name->ar', 'like', "%{$search}%");
                    });
            });
        }

        return [
            'services' => $query->latest()->paginate(10),
            'stats'    => $stats,
        ];
    }

    public function actions(Service $service, $newStatus)
    {
        $currentStatus = $service->status->value;

        if ($newStatus === StatusEnum::INACTIVE->value && $currentStatus !== StatusEnum::APPROVED->value) {
            throw ValidationException::withMessages([
                'status' => ['Only approved services can be deactivated.']
            ]);
        }

        if (in_array($newStatus, [StatusEnum::APPROVED->value, StatusEnum::REJECTED->value]) && $currentStatus !== StatusEnum::PENDING->value && $currentStatus !== StatusEnum::INACTIVE->value) {
            throw ValidationException::withMessages([
                'status' => ['Only pending services can be approved or rejected.']
            ]);
        }

        $service->update(['status' => $newStatus]);
    }
}
