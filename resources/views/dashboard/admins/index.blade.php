@extends('layouts/contentNavbarLayout')

@section('title', __('admins.management_title'))

@section('content')

{{-- الإحصائيات --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-primary">{{ __('admins.total_admins') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-user fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-success">{{ __('admins.last_30_days') }}</h6>
                        <h4 class="mb-0 fw-black">+{{ $stats['recent'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-user-check fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 62, 29, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-danger">{{ __('admins.role_assignments') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['roles_count'] }}</h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2">
                        <i class="bx bx-shield-quarter fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 gap-3">
        <h5 class="card-title mb-0">{{ __('admins.management_title') }}</h5>
        
        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
            <form action="{{ route('admins.index') }}" method="GET" class="d-flex w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('admins.search_placeholder') }}" aria-label="Search..." aria-describedby="basic-addon-search31">
                </div>
            </form>
            @can('create-admins')
                <a href="{{ route('admins.create') }}" class="btn btn-primary text-nowrap">
                    <i class="bx bx-user-plus me-1"></i> {{ __('admins.add_new') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 25%">{{ __('admins.column_admin') }}</th>
                    <th style="width: 20%">{{ __('admins.column_roles') }}</th>
                    <th style="width: 25%">{{ __('admins.column_permissions') }}</th>
                    <th style="width: 15%">{{ __('admins.column_joined') }}</th>
                    @if(auth()->user()->can('edit-admins') || auth()->user()->can('delete-admins'))
                        <th style="width: 10%">{{ __('admins.column_actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper me-3">
                                <div class="avatar avatar-sm">
                                    <span class="avatar-initial rounded-circle bg-label-info">{{ strtoupper(substr($admin->name, 0, 2)) }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading text-truncate">{{ $admin->name }}</span>
                                <small class="text-muted">{{ $admin->email }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        @forelse($admin->roles->take(2) as $role)
                            <span class="badge bg-label-primary mb-1">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted small fst-italic">{{ __('admins.no_role') }}</span>
                        @endforelse

                        @if($admin->roles->count() > 2)
                            <small class="text-muted cursor-pointer" data-bs-toggle="tooltip" title="{{ $admin->roles->skip(2)->pluck('name')->implode(', ') }}">
                                +{{ $admin->roles->count() - 2 }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @php 
                            $directPerms = $admin->getDirectPermissions()->take(2); 
                        @endphp
                        
                        @forelse($directPerms as $perm)
                            <span class="badge bg-label-warning rounded-pill mb-1" style="font-size: 0.7rem;">
                                <i class="bx bx-star me-1"></i>{{ $perm->name }}
                            </span>
                        @empty
                            <small class="text-muted small fst-italic">{{ __('admins.no_permissions') }}</small>
                        @endforelse

                        @if($admin->getDirectPermissions()->count() > 2)
                            <small class="text-muted cursor-pointer" data-bs-toggle="tooltip" title="{{ $admin->getDirectPermissions()->skip(2)->pluck('name')->implode(', ') }}">
                                +{{ $admin->getDirectPermissions()->count() - 2 }}
                            </small>
                        @endif
                    </td>

                    <td>
                        <span class="text-muted small">{{ $admin->created_at->translatedFormat('M d, Y') }}</span>
                    </td>
                    @if(auth()->user()->can('edit-admins') || auth()->user()->can('delete-admins'))
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    @can('edit-admins')
                                        <a class="dropdown-item" href="{{ route('admins.edit', $admin->id) }}"><i class="icon-base bx bx-edit-alt me-1"></i> {{ __('admins.edit') }}</a>
                                    @endcan
                                    @can('delete-admins')
                                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('{{ __('admins.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" title="{{ __('admins.delete') }}">
                                                <i class="icon-base bx bx-trash me-1"></i> {{ __('admins.delete') }}
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
                            <p>{{ request('search') ? __('admins.no_results_matching') : __('admins.no_results') }}.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admins->hasPages() || $admins->total() > 0)
        <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-muted small mb-3 mb-md-0">
                {{ __('admins.showing', [
                    'first' => $admins->firstItem(),
                    'last' => $admins->lastItem(),
                    'total' => $admins->total()
                ]) }}
            </div>

            <div class="pagination-wrapper">
                {{ $admins->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection