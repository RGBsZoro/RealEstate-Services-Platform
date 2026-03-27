@extends('layouts/contentNavbarLayout')

@section('title', 'Roles Management')

@section('content')
<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">User Roles & Permissions</h5>
            <div class="d-flex">
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Add New Role
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 20%">Role Name</th>
                    <th style="width: 40%">Permissions</th>
                    <th style="width: 15%">Users Count</th>
                    <th style="width: 15%">Created At</th>
                    <th style="width: 10%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
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
                            <small class="text-muted">No Permissions Assigned</small>
                        @endforelse

                        @if($role->permissions->count() > 3)
                            <small class="text-muted" data-bs-toggle="tooltip" title="{{ $role->permissions->skip(3)->pluck('name')->implode(', ') }}">
                                +{{ $role->permissions->count() - 3 }} more
                            </small>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-list d-flex align-items-center">
                                <i class="bx bx-group me-2 text-muted"></i>
                                <span class="badge bg-label-info">{{ $role->users_count ?? $role->users->count() }} User(s)</span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted">{{ $role->created_at->toFormattedDateString() }}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Attention: Deleting this role will affect all assigned users. Continue?')">
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