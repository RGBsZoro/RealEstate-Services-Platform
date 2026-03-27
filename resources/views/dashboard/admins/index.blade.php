@extends('layouts/contentNavbarLayout')

@section('title', 'Administrators Management')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">System Administrators</h5>
            <div class="d-flex">
                <a href="{{ route('admins.create') }}" class="btn btn-primary">
                    <i class="bx bx-user-plus me-1"></i> Add New Admin
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 25%">Admin</th>
                    <th style="width: 20%">Assigned Roles</th>
                    <th style="width: 25%">Extra Permissions</th>
                    <th style="width: 15%">Joined Date</th>
                    <th style="width: 10%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
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
                            <span class="text-muted small italic">No Role Assigned</span>
                        @endforelse

                        @if($admin->roles->count() > 2)
                            <small class="text-muted" data-bs-toggle="tooltip" title="{{ $admin->roles->skip(2)->pluck('name')->implode(', ') }}">
                                +{{ $admin->roles->count() - 2 }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @php 
                            $directPerms = $admin->getDirectPermissions()->take(2); 
                        @endphp
                        
                        @forelse($directPerms->take(2) as $perm)
                            <span class="badge bg-label-warning rounded-pill mb-1" style="font-size: 0.7rem;">
                                <i class="bx bx-star me-1"></i>{{ $perm->name }}
                            </span>
                        @empty
                            <small class="text-muted">No Permissions Assigned</small>
                        @endforelse

                        @if($directPerms->count() > 2)
                            <small class="text-muted" data-bs-toggle="tooltip" title="{{ $directPerms->skip(2)->pluck('name')->implode(', ') }}">
                                +{{ $directPerms->count() - 2 }}
                            </small>
                        @endif
                    </td>

                    <td>
                        <span class="text-muted small">{{ $admin->created_at->format('M d, Y') }}</span>
                    </td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admins.edit', $admin->id) }}"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Attention: are you sure yo delete this admin. Continue?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" title="Delete">
                                    <i class="icon-base bx bx-trash me-1"></i> Delete
                                </button>
                            </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection