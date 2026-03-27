@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Admin Account')

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
                <h5 class="mb-0">Edit Admin: <span class="text-primary">{{ $admin->name }}</span></h5>
                <small class="text-muted float-end">Update account details and permissions</small>
            </div>
            <div class="card-body">
                <form action="{{ route('admins.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="full-name">Full Name</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="full-name" value="{{ old('name', $admin->name) }}" />
                            </div>
                            @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="email">Email Address</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" />
                            </div>
                            @error('email') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Assign Roles</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-4 mb-3">
                                        <div class="role-item">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="roles[]" 
                                                    value="{{ $role->name }}" 
                                                    id="role_{{ $role->id }}" 
                                                    {{ (in_array($role->name, old('roles', $adminRoles))) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="role_{{ $role->id }}">
                                                    <i class="bx bx-shield-quarter me-1"></i> {{ $role->name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Direct Permissions</label>
                        <div class="col-sm-10">
                            <div class="permissions-container">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                    value="{{ $permission->name }}" 
                                                    id="perm_{{ $permission->id }}" 
                                                    {{ (in_array($permission->name, old('permissions', $adminDirectPermissions))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="password">New Password</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Leave blank to keep current password" />
                            </div>
                            <div class="form-text">Only fill this if you want to change the admin's password.</div>
                            @error('password') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="password_confirmation">Confirm Password</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="············" />
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end mt-8">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check me-1"></i> Update Admin Account
                            </button>
                            <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection