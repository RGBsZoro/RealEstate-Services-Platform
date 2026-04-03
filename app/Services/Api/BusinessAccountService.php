<?php

namespace App\Services\Api;

use App\Models\BusinessAccount;
use App\Models\City;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Bus;

class BusinessAccountService
{
    public function store()
    {
        return auth('api')->user()->businessAccounts()->create(['current_step' => 1]);
    }

    public function step1(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(1, $businessAccount);
        $businessAccount->update([
            'activity_id' => $data['activity_id'],
            'current_step' => 2
        ]);
    }

    public function step2(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(2, $businessAccount);
        $businessAccount->update([
            'license_number' => $data['license_number'],
            'name' => $data['name'],
            'activities' => $data['activities'],
            'details' => $data['details'],
            'current_step' => 3
        ]);
    }

    public function step3(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(3, $businessAccount);

        $this->validateLocation(
            $data['city_id'],
            $data['latitude'],
            $data['longitude']
        );

        $businessAccount->update([
            'city_id' => $data['city_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'current_step' => 4
        ]);
    }

    public function step4(array $data, BusinessAccount $businessAccount)
    {
        $this->ensureStep(4, $businessAccount);

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

        $businessAccount->update([
            'status' => 'pending',
            'current_step' => null
        ]);
    }

    private function ensureStep($current_step, BusinessAccount $businessAccount)
    {
        if ($businessAccount->current_step != $current_step) {
            throw new AuthorizationException();
        }
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
}
