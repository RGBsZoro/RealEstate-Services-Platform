<?php

namespace App\Services;

use App\Services\Api\OtpService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\HasMedia;

class ProfileService
{
    public function __construct(protected OtpService $otp) {}
    public function updatePassword(Authenticatable $user, array $data)
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('auth.password_mismatch'),
            ]);
        }

        $user->update([
            'password' => $data['new_password']
        ]);
    }

    public function updateProfile(Authenticatable $user, array $data, string $collectionName = 'avatar')
    {
        if (isset($data['name']))
            $user->update(['name' => $data['name']]);

        if (isset($data['avatar'])) {
            $user->clearMediaCollection($collectionName);
            $user->addMedia($data['avatar'])->toMediaCollection($collectionName);
        }
    }

    public function verifyPhoneUpdate(Authenticatable $user, array $data)
    {
        $this->otp->verifyOtp($data, 'phone_update');
        $user->update(['phone' => $data['phone']]);
    }
}
