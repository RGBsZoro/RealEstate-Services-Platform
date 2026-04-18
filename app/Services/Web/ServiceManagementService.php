<?php

namespace App\Services\Web;

use App\Models\Service;
use App\Notifications\ServiceRequestStatusNotification;
use Illuminate\Validation\ValidationException;

class ServiceManagementService
{
    public function index(array $data)
    {
        $baseQuery = Service::where('status', '!=', 'draft');

        $stats = [
            'pending'  => (clone $baseQuery)->where('status', 'pending')->count(),
            'approved' => (clone $baseQuery)->where('status', 'approved')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
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
        if ($service->status->value != 'pending')
            throw ValidationException::withMessages([
                'status' => ['Only pending accounts can be approved or rejected.']
            ]);

        $service->update(['status' => $newStatus]);
    }
}
