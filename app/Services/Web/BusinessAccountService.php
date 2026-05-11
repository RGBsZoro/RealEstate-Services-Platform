<?php

namespace App\Services\Web;

use App\Enum\StatusEnum;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Notifications\BusinessAccountStatusNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BusinessAccountService
{
    public function index(array $data)
    {
        $query = BusinessAccount::with(['user', 'activity', 'city']);


        $stats = [
            'pending'  => (clone $query)->where('status', StatusEnum::PENDING->value)->count(),
            'approved' => (clone $query)->where('status', StatusEnum::APPROVED->value)->count(),
            'rejected' => (clone $query)->where('status', StatusEnum::REJECTED->value)->count(),
            'inactive' => (clone $query)->where('status', StatusEnum::INACTIVE->value)->count(),
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
        $currentStatus = $businessAccount->status->value;

        if ($newStatus === StatusEnum::INACTIVE->value && $currentStatus !== StatusEnum::APPROVED->value) {
            throw ValidationException::withMessages([
                'status' => ['Only approved accounts can be deactivated.']
            ]);
        }

        if (in_array($newStatus, [StatusEnum::APPROVED->value, StatusEnum::REJECTED->value]) && $currentStatus !== StatusEnum::PENDING->value && $currentStatus !== StatusEnum::INACTIVE->value) {
            throw ValidationException::withMessages([
                'status' => ['Only pending accounts can be approved or rejected.']
            ]);
        }

        DB::transaction(function () use ($businessAccount, $newStatus) {
            $businessAccount->update(['status' => $newStatus]);

            if ($newStatus === StatusEnum::INACTIVE->value) {
                $businessAccount->services()
                    ->where('status', StatusEnum::APPROVED->value)
                    ->update(['status' => StatusEnum::INACTIVE->value]);

                $businessAccount->services()
                    ->where('status', StatusEnum::PENDING->value)
                    ->update(['status' => StatusEnum::REJECTED->value]);
            }

            if ($newStatus === StatusEnum::APPROVED->value) {
                $businessAccount->services()
                    ->where('status', StatusEnum::INACTIVE->value)
                    ->update(['status' => StatusEnum::APPROVED->value]);
            }
        });

        // send notification
        $businessAccount->user->notify(new BusinessAccountStatusNotification($businessAccount));
    }
}
