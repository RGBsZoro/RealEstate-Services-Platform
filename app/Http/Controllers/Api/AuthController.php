<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\VerifyForgotPasswordOtpRequest;
use App\Http\Requests\Api\VerifyRegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $auth) {}
    public function register(RegisterRequest $request)
    {
        $registrationId = $this->auth->register($request->validated());
        return successResponse(['regstraiton_id' => $registrationId]);
    }

    public function verifyRegister(VerifyRegisterRequest $request)
    {
        $data = $this->auth->verifyRegister($request->validated());

        return successResponse([
            'user' => UserResource::make($data['user']),
            'token' => $data['token']
        ]);
    }
    public function login(LoginRequest $request)
    {
        $data = $this->auth->login($request->validated());

        return successResponse([
            'user' => UserResource::make($data['user']),
            'token' => $data['token']
        ]);
    }

    public function logout()
    {
        $this->auth->logout();

        return successResponse();
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $resetId = $this->auth->forgotPassword($request->validated());
        return successResponse(['reset_id' => $resetId]);
    }

    public function verifyForgotPasswordOtp(VerifyForgotPasswordOtpRequest $request)
    {
        $tempToken = $this->auth->verifyForgotPasswordOtp($request->validated());
        return successResponse(['reset_token' => $tempToken]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->auth->resetPassword($request->validated());
        return successResponse(['message' => 'Password has been reset successfully.']);
    }
}
