@extends('layouts/contentNavbarLayout')

@section('title', __('admins.management_title'))

@section('content')

{{-- بطاقات الإحصائيات الملونة --}}
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

{{-- جدول عرض البيانات وجدول الإدارة --}}
<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        {{-- السطر العلوي: العنوان وزر الإضافة في الزاوية المقابلة --}}
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0">{{ __('admins.management_title') }}</h5>
            @can('create-admins')
                <a href="{{ route('admins.create') }}" class="btn btn-primary text-nowrap rounded-pill">
                    <i class="bx bx-user-plus me-1"></i> {{ __('admins.add_new') }}
                </a>
            @endcan
        </div>
        
        {{-- السطر السفلي: حقل البحث ممتد بالكامل على سطر منفرد --}}
        <form action="{{ route('admins.index') }}" method="GET" id="admins-filter-form">
            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text text-muted"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-admin-input" value="{{ request('search') }}" class="form-control" placeholder="{{ __('admins.search_placeholder') }}" autocomplete="off">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th style="width: 35%">{{ __('admins.column_admin') }}</th>
                    <th style="width: 25%">{{ __('admins.column_roles') }}</th>
                    <th style="width: 25%">{{ __('admins.column_joined') }}</th>
                    @if(auth()->user()->can('edit-admins') || auth()->user()->can('delete-admins'))
                        <th style="width: 15%" class="text-center">{{ __('admins.column_actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($admins as $admin)
                <tr>
                    <td>
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper me-3">
                                <div class="avatar avatar-sm">
                                    @if($admin->getFirstMediaUrl('admin_avatars'))
                                        <img src="{{ $admin->getFirstMediaUrl('admin_avatars') }}" alt="Avatar" class="rounded-circle" style="object-fit: cover;">
                                    @else
                                        <span class="avatar-initial rounded-circle bg-label-info">
                                            {{ Str::upper(Str::substr($admin->name, 0, 2)) }}
                                        </span>
                                    @endif                                 
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading text-truncate">{{ $admin->name }}</span>
                                <small class="text-muted small">{{ $admin->email }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        @forelse($admin->roles->take(2) as $role)
                            <span class="badge bg-label-primary rounded-pill mb-1">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted small fst-italic">{{ __('admins.no_role') }}</span>
                        @endforelse

                        @if($admin->roles->count() > 2)
                            <small class="text-muted cursor-pointer ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $admin->roles->skip(2)->pluck('name')->implode(', ') }}">
                                +{{ $admin->roles->count() - 2 }}
                            </small>
                        @endif
                    </td>

                    <td>
                        <span class="text-muted small">{{ $admin->created_at->translatedFormat('M d, Y') }}</span>
                    </td>
                    @if(auth()->user()->can('edit-admins') || auth()->user()->can('delete-admins'))
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="icon-base bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('edit-admins')
                                        <a class="dropdown-item" href="{{ route('admins.edit', $admin->id) }}">
                                            <i class="icon-base bx bx-edit-alt me-1"></i> {{ __('admins.edit') }}
                                        </a>
                                    @endcan
                                    @can('delete-admins')
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="delete-admin-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
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
                    <td colspan="4" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search mb-2" style="font-size: 3rem;"></i>
                            <p class="mb-0">{{ request('search') ? __('admins.no_results_matching') : __('admins.no_results') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admins->hasPages() || $admins->total() > 0)
        <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
            <div class="text-muted small mb-3 mb-md-0">
                {{ __('admins.showing', [
                    'first' => $admins->firstItem() ?? 0,
                    'last' => $admins->lastItem() ?? 0,
                    'total' => $admins->total()
                ]) }}
            </div>

            <div class="pagination-wrapper">
                {{ $admins->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection

@section('page-script')
<script>
    window.onload = function() {
        if (window.jQuery) {
            $(function() {
                const $form = $('#admins-filter-form');
                let searchAdminsTimeout;

                // 1. البحث التلقائي الفوري الموزون (Debounce 500ms)
                $(document).on('input', '#search-admin-input', function() {
                    clearTimeout(searchAdminsTimeout);
                    
                    searchAdminsTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });

                // 2. منع الـ Submit المباشر غير المقصود بضغط مفتاح الـ Enter
                $form.on('submit', function(e) {
                    if (e.originalEvent && e.originalEvent.submitter === undefined) {
                        e.preventDefault();
                    }
                });

                // 3. رسالة تأكيد الحذف الديناميكية
                $(document).on('submit', '.delete-admin-form', function(e) {
                    if(!confirm("{{ __('admins.confirm_delete') }}")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>
@endsection