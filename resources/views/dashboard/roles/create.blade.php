@extends('layouts/contentNavbarLayout')

@section('title', 'Create New Role')

@section('page-style')
<style>
    /* صندوق الصلاحيات مع سكرول */
    .permissions-container {
        max-height: 350px;
        overflow-y: auto;
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        padding: 20px;
        background-color: #f8f9fa;
    }

    /* تحسين شكل الـ Checkbox عند الاختيار */
    .perm-card {
        transition: all 0.2s ease;
        border: 1px solid transparent;
        border-radius: 5px;
        padding: 5px 10px;
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
                <h5 class="mb-0">Create New Security Role</h5>
                <small class="text-muted float-end">Step 1: Define permissions</small>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="role-name">Role Name</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-shield-quarter"></i></span>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="role-name" placeholder="e.g. Manager, Editor, Moderator" value="{{ old('name') }}" />
                            </div>
                            <div class="form-text">Use lowercase and hyphens (e.g., 'content-manager') or plain text.</div>
                            @error('name') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="my-6">

                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label">Assign Permissions</label>
                        <div class="col-sm-10">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-body fw-bold">Select all permissions that apply to this role:</span>
                            </div>
                            
                            <div class="permissions-container">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check perm-card">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}" {{ (collect(old('permissions'))->contains($permission->name)) ? 'checked':'' }}>
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('permissions') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end mt-8">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check-shield me-1"></i> Save Role & Permissions
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection