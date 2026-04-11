<?php

namespace App\Services;

class FCMService
{
    public function store(array $data, string $guardName)
    {
        auth($guardName)->user()->devices()->updateOrCreate(
            ['fcm_token' => $data['token']],
            [
                'device_type' => $data['device_type'] ?? null 
            ]
        );
    }
}
