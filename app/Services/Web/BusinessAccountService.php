<?php

namespace App\Services\Web;

use App\Enum\StatusEnum;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Notifications\BusinessAccountStatusNotification;
use Illuminate\Validation\ValidationException;

class BusinessAccountService
{
    public function index(array $data)
    {
        $query = BusinessAccount::with(['user', 'activity', 'city'])
            ->where('status', '!=', StatusEnum::DRAFT->value);


        $stats = [
            'pending'  => (clone $query)->where('status', StatusEnum::PENDING->value)->count(),
            'approved' => (clone $query)->where('status', StatusEnum::APPROVED->value)->count(),
            'rejected' => (clone $query)->where('status', StatusEnum::REJECTED->value)->count(),
        ];

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (!empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name->en', 'like', "%{$search}%")
                    ->orWhere('name->ar', 'like', "%{$search}%");
            });
        }

        $cities = cache()->remember('cities_all', 3600, fn() => City::all());

        return [
            'business_accounts' => $query->latest()->paginate(10),
            'stats'             => $stats,
            'cities'            => $cities,
        ];
    }

    public function actions(BusinessAccount $businessAccount, $newStatus)
    {
        if ($businessAccount->status->value != 'pending')
            throw ValidationException::withMessages([
                'status' => ['Only pending services can be approved or rejected.']
            ]);

        // send notification
        $businessAccount->user->notify(new BusinessAccountStatusNotification($businessAccount));

        $businessAccount->update(['status' => $newStatus]);
    }
}
