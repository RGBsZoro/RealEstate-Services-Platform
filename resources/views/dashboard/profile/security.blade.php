@extends('layouts.contentNavbarLayout')

@section('title', __('profile.security_title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ __('profile.account') }} /</span> {{ __('profile.security') }}
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ __('profile.change_password_header') }}</h5>
                <div class="card-body">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- كلمة المرور الحالية -->
                            <div class="mb-3 col-md-12 form-password-toggle">
                                <label class="form-label" for="current_password">{{ __('profile.current_password') }}</label>
                                <div class="input-group input-group-merge @error('current_password') is-invalid @enderror">
                                    <input type="password" name="current_password" id="current_password" 
                                           class="form-control" 
                                           placeholder="{{ __('profile.current_password_placeholder') }}" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <!-- كلمة المرور الجديدة -->
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="new_password">{{ __('profile.new_password') }}</label>
                                <div class="input-group input-group-merge @error('new_password') is-invalid @enderror">
                                    <input type="password" name="new_password" id="new_password" 
                                           class="form-control" 
                                           placeholder="{{ __('profile.new_password_placeholder') }}" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- تأكيد كلمة المرور الجديدة -->
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="new_password_confirmation">{{ __('profile.confirm_new_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                           class="form-control" 
                                           placeholder="{{ __('profile.confirm_password_placeholder') }}" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">{{ __('general.save_changes') }}</button>
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">{{ __('general.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection