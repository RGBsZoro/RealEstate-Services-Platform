<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profile) {}
    public function index()
    {
        return view('dashboard.profile.index');
    }

    public function security()
    {
        return view('dashboard.profile.security');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->profile->updatePassword(auth('web')->user(), $request->validated());

        return redirect()->route('profile.index');
    }

    public function updateAvatar(UpdateProfileRequest $request)
    {
        $this->profile->updateProfile(auth('web')->user(), $request->validated(), 'admin_avatars');

        return redirect()->back();
    }
}
