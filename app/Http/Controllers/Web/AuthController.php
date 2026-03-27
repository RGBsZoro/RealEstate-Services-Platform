<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\StoreAdminRequest;
use App\Services\Web\AuthService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function __construct(protected AuthService $auth) {}

    public function loginForm()
    {
        return view('dashboard.auth.login');
    }

    public function login(LoginRequest $reqeust)
    {
        $admin = $this->auth->login($reqeust->validated());

        return redirect()->route('dashboard-analytics');
    }
}
