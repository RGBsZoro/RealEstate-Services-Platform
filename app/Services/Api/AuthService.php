<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\{Cache, DB, Hash};
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(protected OtpService $otp) {}

    public function register(array $data)
    {
        $registrationId = $this->otp->generateOtp($data, "registration");

        Cache::put("reg_data_{$registrationId}", [
            'phone' => $data['phone'],
            'name' => $data['name'],
            'password' => Hash::make($data['password'])
        ], now()->addMinutes(10));

        return $registrationId;
    }

    public function verifyRegister(array $data)
    {
        $this->otp->verifyOtp($data, "registration");

        $key = "reg_data_{$data['registration_id']}";

        $userDataCache = Cache::get($key);

        if (!$userDataCache)
            throw ValidationException::withMessages([
                'user' => ['Registration session expired or not found']
            ]);
        return DB::transaction(function () use ($userDataCache, $key) {

            $user = User::updateOrCreate(
                ['phone' => $userDataCache['phone']],
                [
                    'name' => $userDataCache['name'],
                    'password' => $userDataCache['password'],
                    'phone_verified_at' => now()
                ]
            );

            $token = $user->createToken('api_token')->accessToken;
        
            Cache::forget($key);

            return ['user' => $user, 'token' => $token];
        });
    }

    public function login(array $data)
    {
        $user = User::where('phone', $data['phone'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            throw new AuthenticationException();

        $token = $user->createToken('api_token')->accessToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout()
    {
        auth('api')->user()->token()->revoke();
    }
}
