@extends('layouts/contentNavbarLayout')

@section('title', __('categories.main_title'))

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary">{{ __('categories.total_main') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2"><i class="bx bx-grid-alt fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success">{{ __('categories.active_main') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['active'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-check-circle fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 62, 29, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-danger">{{ __('categories.inactive_main') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['inactive'] }}</h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2"><i class="bx bx-x-circle fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0">{{ __('categories.management_card') }}</h5>
            @can('create-categories')
                <a href="{{ route('categories.main.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bx bx-plus me-1"></i> {{ __('categories.add_category') }}
                </a>
            @endcan
        </div>
        
        <form action="{{ route('categories.main.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text text-muted"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('categories.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <select name="status" class="form-select">
                        <option value="">{{ __('categories.all_statuses') }}</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('categories.active_only') }}</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('categories.inactive_only') }}</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
                        {{ __('categories.filter_btn') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase small fw-bold">
                <tr>
                    <th style="width: 30%">{{ __('categories.th_name') }}</th>
                    <th>{{ __('categories.th_sub_count') }}</th>
                    <th>{{ __('categories.th_fields_count') }}</th>
                    <th>{{ __('categories.th_status') }}</th>
                    <th>{{ __('categories.th_date') }}</th>
                    @if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields'))
                        <th class="text-center">{{ __('categories.th_actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($category->getFirstMediaUrl('Categories'))
                                <img src="{{ $category->getFirstMediaUrl('Categories') }}" alt="icon" class="rounded-circle me-3 border" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary">
                                        <i class="bx bx-category fs-5"></i>
                                    </span>
                                </div>
                            @endif
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading">{{ $category->getTranslation('name', 'en') }}</span>
                                <small class="text-muted small">{{ $category->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="badge bg-label-secondary rounded-pill">
                            <i class="bx bx-git-repo-forked me-1"></i> {{ $category->children_count }} {{ __('categories.sub_unit') }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-label-info rounded-pill">
                            <i class="bx bx-list-check me-1"></i> {{ $category->dynamic_fields_count }} {{ __('categories.fields_unit') }}
                        </span>
                    </td>

                    <td>
                        @if($category->isActive)
                            <span class="badge bg-label-success rounded-pill">{{ __('categories.status_active') }}</span>
                        @else
                            <span class="badge bg-label-danger rounded-pill">{{ __('categories.status_inactive') }}</span>
                        @endif
                    </td>

                    <td>
                        <span class="text-muted small">{{ $category->created_at->format('M d, Y') }}</span>
                    </td>

                    @if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields'))
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('view-dynamic-fields')
                                        <a class="dropdown-item" href="{{ route('categories.fields.index', $category->id) }}">
                                            <i class="bx bx-cog me-2 text-info small"></i> {{ __('categories.manage_fields') }}
                                        </a>
                                    @endcan
                                    @can('edit-categories')
                                        <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                            <i class="bx bx-edit-alt me-2 small"></i> {{ __('categories.edit') }}
                                        </a>
                                    @endcan
                                    @can('delete-categories')
                                    <div class="dropdown-divider"></div>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ __('categories.delete_confirm') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2 small"></i> {{ __('categories.delete') }}
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
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search-alt-2 mb-2 display-6"></i>
                            <p>{{ __('categories.no_data') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->total() > 0)
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small mb-3 mb-md-0">
            {{ __('categories.showing') }} <strong>{{ $categories->firstItem() ?? 0 }}</strong> 
            {{ __('categories.to') }} <strong>{{ $categories->lastItem() ?? 0 }}</strong> 
            {{ __('categories.of') }} <strong>{{ $categories->total() }}</strong> {{ __('categories.entries') }}
        </div>
        <div class="pagination-wrapper">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection