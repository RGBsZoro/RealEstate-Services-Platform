<?php

namespace App\Services\Web;

use App\Models\Admin;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $data)
    {
        if (Auth::attempt($data))
            return auth('web')->user();

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }
}
