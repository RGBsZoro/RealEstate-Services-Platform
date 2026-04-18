@extends('layouts/contentNavbarLayout')

@section('title', __('roles.management_title'))

@section('content')

{{-- Stats Cards --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-primary">{{ __('roles.total_roles') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total_roles'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-key fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-warning">{{ __('roles.system_permissions') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total_perms'] }}</h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-lock-alt fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(3, 195, 236, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-info">{{ __('roles.authorized_admins') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['assigned_admins'] }}</h4>
                    </div>
                    <span class="badge bg-info rounded-circle p-2">
                        <i class="bx bx-user-check fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Roles Table Card --}}
<div class="card">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 gap-3">
        <h5 class="card-title mb-0">{{ __('roles.management_title') }}</h5>
        
        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
            <form action="{{ route('roles.index') }}" method="GET" class="d-flex w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('roles.search_placeholder') }}" aria-label="Search...">
                </div>
            </form>
            @can('create-roles')
                <a href="{{ route('roles.create') }}" class="btn btn-primary text-nowrap">
                    <i class="bx bx-plus-circle me-1"></i> {{ __('roles.add_new') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 20%">{{ __('roles.role_name') }}</th>
                    <th style="width: 40%">{{ __('roles.permissions') }}</th>
                    <th style="width: 15%">{{ __('roles.users_count') }}</th>
                    <th style="width: 15%">{{ __('roles.created_at') }}</th>
                    @if(auth()->user()->can('edit-roles') || auth()->user()->can('delete-roles'))
                        <th style="width: 10%">{{ __('roles.actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-shield"></i></span>
                            </div>
                            <span class="fw-medium text-heading">{{ strtoupper($role->name) }}</span>
                        </div>
                    </td>

                    <td>
                        @php $mainPerms = $role->permissions->take(3); @endphp
                        @forelse($mainPerms as $perm)
                            <span class="badge bg-label-secondary rounded-pill me-1" style="text-transform: none;">
                                {{ str_replace('-', ' ', $perm->name) }}
                            </span>
                        @empty
                            <small class="text-muted">{{ __('roles.no_perms') }}</small>
                        @endforelse

                        @if($role->permissions->count() > 3)
                            <small class="text-muted cursor-pointer" data-bs-toggle="tooltip" title="{{ $role->permissions->skip(3)->pluck('name')->implode(', ') }}">
                                +{{ $role->permissions->count() - 3 }} {{ __('roles.more') }}
                            </small>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-list d-flex align-items-center">
                                <i class="bx bx-group me-2 text-muted"></i>
                                <span class="badge bg-label-info">{{ $role->users_count }} {{ __('roles.users') }}</span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted">{{ $role->created_at->toFormattedDateString() }}</span>
                    </td>
                    @if(auth()->user()->can('edit-roles') || auth()->user()->can('delete-roles'))
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                @can('edit-roles') {{-- تصحيح: الصلاحية كانت edit-admins --}}
                                    <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i class="icon-base bx bx-edit-alt me-1"></i> {{ __('roles.edit') }}</a>
                                @endcan
                                @can('delete-roles') {{-- تصحيح: الصلاحية كانت delete-admins --}}
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ __('roles.delete_confirm') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" title="Delete">
                                            <i class="icon-base bx bx-trash me-1"></i> {{ __('roles.delete') }}
                                        </button>
                                    </form>
                                @endcan
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search mb-2" style="font-size: 2rem;"></i>
                            <p>{{ __('roles.no_results') }} {{ request('search') ? __('roles.matching_search') : __('roles.in_database') }}.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($roles->hasPages() || $roles->total() > 0)
        <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-muted small mb-3 mb-md-0">
                {{ __('roles.showing') }} {{ $roles->firstItem() }} {{ __('roles.to') }} {{ $roles->lastItem() }} {{ __('roles.of') }} {{ $roles->total() }} {{ __('roles.results') }}
            </div>

            <div class="pagination-wrapper">
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection