<?php

namespace App\Services\Api;

use App\Enum\StatusEnum;
use App\Models\Admin;
use App\Models\BusinessAccount;
use App\Models\City;
use App\Notifications\BusinessAccountRequestNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class BusinessAccountService
{
    public function step1(array $data)
    {
        return auth('api')->user()->businessAccounts()->updateOrCreate(
            [
                'status' => StatusEnum::DRAFT->value,
            ],
            [
                'activity_id' => $data['activity_id'],
                'current_step' => 1
            ]
        );
    }

    public function step2(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(1, $businessAccount);
        $businessAccount->update([
            'license_number' => $data['license_number'],
            'name' => $data['name'],
            'activities' => $data['activities'],
            'details' => $data['details'],
            'current_step' => 2
        ]);
    }

    public function step3(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(2, $businessAccount);

        $this->validateLocation(
            $data['city_id'],
            $data['latitude'],
            $data['longitude']
        );

        $businessAccount->update([
            'city_id' => $data['city_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'current_step' => 3
        ]);
    }

    public function step4(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(3, $businessAccount);

        if (!empty($data['documents'])) {
            foreach ($data['documents'] as $file) {
                $businessAccount->addMedia($file)->toMediaCollection('documents');
            }
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $file) {
                $businessAccount->addMedia($file)->toMediaCollection('images');
            }
        }

        // send notification
        $admins = Admin::permission('manage-business-accounts')->get();
        Notification::send($admins, new BusinessAccountRequestNotification($businessAccount));

        $businessAccount->update([
            'status' => StatusEnum::PENDING->value,
            'current_step' => null
        ]);
    }

    private function ensureStep($current_step, BusinessAccount $businessAccount)
    {
        if ($businessAccount->current_step < $current_step)
            throw new AuthorizationException();
    }

    private function validateLocation($cityId, $lat, $lng)
    {
        $city = City::findOrFail($cityId);

        $distance = $this->haversineDistance(
            $city->latitude,
            $city->longitude,
            $lat,
            $lng
        );
        if ($distance > $city->radius) {
            throw new \Exception('Location is outside selected city.');
        }
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) *
                pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
    }

    public function getMyAccounts($perPage = 10)
    {
        return auth('api')->user()->businessAccounts()
            ->with(['activity'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getAccountDetails(BusinessAccount $businessAccount)
    {
        Gate::allows('update', $businessAccount) || throw new AuthorizationException();

        $businessAccount->load(['activity', 'city', 'media']);
        return $businessAccount;
    }

    public function updateAccount(BusinessAccount $businessAccount, array $data)
    {
        DB::transaction(function () use ($businessAccount, $data) {
            if (isset($data['city_id']) && isset($data['latitude']) && isset($data['longitude'])) {
                $this->validateLocation($data['city_id'], $data['latitude'], $data['longitude']);
            }

            $businessAccount->update([
                'name' => $data['name'] ?? $businessAccount->name,
                'activity_id' => $data['activity_id'] ?? $businessAccount->activity_id,
                'license_number' => $data['license_number'] ?? $businessAccount->license_number,
                'activities' => $data['activities'] ?? $businessAccount->activities,
                'details' => $data['details'] ?? $businessAccount->details,
                'city_id' => $data['city_id'] ?? $businessAccount->city_id,
                'latitude' => $data['latitude'] ?? $businessAccount->latitude,
                'longitude' => $data['longitude'] ?? $businessAccount->longitude,
                'status' => StatusEnum::PENDING->value,
            ]);

            if (!empty($data['documents'])) {
                foreach ($data['documents'] as $file) {
                    $businessAccount->addMedia($file)->toMediaCollection('documents');
                }
            }

            if (!empty($data['images'])) {
                foreach ($data['images'] as $file) {
                    $businessAccount->addMedia($file)->toMediaCollection('images');
                }
            }
        });

        return $businessAccount->refresh();
    }

    public function deleteMedia(BusinessAccount $businessAccount, int $mediaId)
    {
        Gate::allows('update', $businessAccount) || throw new AuthorizationException();

        $media = $businessAccount->media()
            ->whereIn('collection_name', ['documents', 'images'])
            ->findOrFail($mediaId);

        $media->delete();
    }

    public function deleteAccount(BusinessAccount $businessAccount)
    {
        Gate::allows('update', $businessAccount) || throw new AuthorizationException();

        $businessAccount->delete();
    }
}
