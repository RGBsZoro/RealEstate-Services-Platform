@extends('layouts/contentNavbarLayout')

@section('title', __('admins.add_title'))

@section('page-style')
<style>
    .permissions-container {
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        padding: 15px;
        background-color: #f8f9fa;
    }
    .form-check-input:checked {
        background-color: #696cff;
        border-color: #696cff;
    }
    .role-item {
        transition: all 0.3s ease;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid transparent;
    }
    .role-item:has(.form-check-input:checked) {
        background-color: rgba(105, 108, 255, 0.08);
        border-color: rgba(105, 108, 255, 0.2);
    }
    .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ __('admins.add_title') }}</h5>
                <small class="text-muted float-end">{{ __('admins.system_subtitle') }}</small>
            </div>
            <div class="card-body">
                <form action="{{ route('admins.store') }}" method="POST">
                    @csrf
                    
                    {{-- Full Name --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="full-name">{{ __('admins.full_name') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="full-name" placeholder="{{ __('admins.placeholders.name') }}" value="{{ old('name') }}" />
                            </div>
                            @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="email">{{ __('admins.email_address') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('admins.placeholders.email') }}" value="{{ old('email') }}" />
                            </div>
                            @error('email') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">

                    {{-- Roles --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('admins.assign_roles') }}</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-4 mb-3">
                                        <div class="role-item">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ (collect(old('roles'))->contains($role->name)) ? 'checked':'' }}>
                                                <label class="form-check-label fw-bold" for="role_{{ $role->id }}">
                                                    <i class="bx bx-shield-quarter me-1"></i> {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Permissions --}}
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">{{ __('admins.direct_permissions') }}</label>
                        <div class="col-sm-10">
                            <div class="permissions-container">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}" {{ (collect(old('permissions'))->contains($permission->name)) ? 'checked':'' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('permissions') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">

                    {{-- Password --}}
                    <div class="row mb-6 form-password-toggle">
                        <label class="col-sm-2 col-form-label" for="password">{{ __('admins.password') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="············" />
                                <span class="input-group-text cursor-pointer" id="toggle-password"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Password Confirmation --}}
                    <div class="row mb-6 form-password-toggle">
                        <label class="col-sm-2 col-form-label" for="password_confirmation">{{ __('admins.confirm_password') }}</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="············" />
                                <span class="input-group-text cursor-pointer" id="toggle-confirm-password"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end mt-8">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> {{ __('admins.create_button') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // نبحث عن كل حاويات كلمة المرور في الصفحة
    const passwordToggles = document.querySelectorAll('.form-password-toggle');

    passwordToggles.forEach(container => {
      const input = container.querySelector('input');
      const toggleBtn = container.querySelector('.cursor-pointer');
      const icon = toggleBtn.querySelector('i');

      toggleBtn.addEventListener('click', () => {
        if (input.type === 'text') {
          icon.classList.replace('bx-hide', 'bx-show');
        } else {
          icon.classList.replace('bx-show', 'bx-hide');
        }
      });
    });
  });
</script>
@endsection