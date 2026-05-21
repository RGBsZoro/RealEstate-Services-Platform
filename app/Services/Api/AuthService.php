<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\{Cache, DB, Hash};
use Illuminate\Support\Str;
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

    public function forgotPassword(array $data)
    {
        $user = User::where('phone', $data['phone'])->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'phone' => ['your data is not correct']
            ]);
        }

        $resetId = $this->otp->generateOtp($data, "password_reset");

        return $resetId;
    }

    public function verifyForgotPasswordOtp(array $data)
    {
        $data['registration_id'] = $data['reset_id'];

        $this->otp->verifyOtp($data, "password_reset");

        $tempToken = Str::random(60);

        Cache::put("password_reset_token_{$tempToken}", [
            'phone' => $data['phone']
        ], now()->addMinutes(10));

        return $tempToken;
    }

    public function resetPassword(array $data)
    {
        $key = "password_reset_token_{$data['reset_token']}";
        $tokenDataCache = Cache::get($key);

        if (!$tokenDataCache) {
            throw ValidationException::withMessages([
                'token' => ['The password reset token is invalid or has expired.']
            ]);
        }

        $user = User::where('phone', $tokenDataCache['phone'])->firstOrFail();

        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        Cache::forget($key);
    }
}
