<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdatePhoneRequest;
use App\Http\Requests\Api\VerifyPhoneRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\Api\OtpService;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profile,
        protected OtpService $otp
    ) {}

    public function show()
    {
        return successResponse(UserResource::make(auth('api')->user()));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->profile->updateProfile(auth('api')->user(), $request->validated(), 'user-avatars');

        return successResponse(UserResource::make(auth('api')->user()->refresh()));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->profile->updatePassword($request->user(), $request->validated());

        return successResponse();
    }

    public function requestPhoneUpdate(UpdatePhoneRequest $request)
    {
        $registrationId = $this->otp->generateOtp($request->only('phone'), 'phone_update');

        return successResponse(['registration_id' => $registrationId]);
    }

    public function verifyPhoneUpdate(VerifyPhoneRequest $request)
    {
        $this->profile->verifyPhoneUpdate(auth('api')->user(), $request->validated());

        return successResponse(UserResource::make(auth('api')->user()->refresh()));
    }
}
