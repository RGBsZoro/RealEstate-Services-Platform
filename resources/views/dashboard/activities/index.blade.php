@extends('layouts/contentNavbarLayout')

@section('title', __('activities.page_title'))

@section('content')

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-primary">{{ __('activities.total_activities') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total_activities'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-category fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-success">{{ __('activities.utilized_activities') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['active_usage'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-check-circle fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-warning">{{ __('activities.total_assignments') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total_assignments'] }}</h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-list-check fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 gap-3">
        <h5 class="card-title mb-0">{{ __('activities.management_header') }}</h5>
        
        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
            <form action="{{ route('activities.index') }}" method="GET" class="d-flex w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('activities.search_placeholder') }}">
                </div>
            </form>
            @can('create-activities')
                <a href="{{ route('activities.create') }}" class="btn btn-primary text-nowrap rounded-pill">
                    <i class="bx bx-plus-circle me-1"></i> {{ __('activities.add_activity') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th style="width: 40%">{{ __('activities.column_name') }}</th>
                    <th style="width: 25%">{{ __('activities.column_accounts') }}</th>
                    <th style="width: 20%">{{ __('activities.column_date') }}</th>
                    @if(auth()->user()->can('edit-activities') || auth()->user()->can('delete-activities'))
                        <th style="width: 15%" class="text-center">{{ __('activities.column_actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($activities as $activity)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($activity->hasMedia('Activities'))
                                <img src="{{ $activity->getFirstMediaUrl('Activities') }}" alt="Icon" class="rounded-circle me-3 border" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary">
                                        <i class="bx bx-briefcase fs-5"></i>
                                    </span>
                                </div>
                            @endif
                            
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading">{{ $activity->getTranslation('name', 'en') }}</span>
                                <small class="text-muted">{{ $activity->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-info rounded-pill">
                                <i class="bx bx-store-alt me-1"></i>
                                {{ $activity->business_accounts_count }} {{ __('activities.accounts_count') }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted small">{{ $activity->created_at->translatedFormat('M d, Y') }}</span>
                    </td>
                    @if(auth()->user()->can('edit-activities') || auth()->user()->can('delete-activities'))
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('edit-activities')
                                        <a class="dropdown-item" href="{{ route('activities.edit', $activity->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> {{ __('activities.edit') }}
                                        </a>
                                    @endcan
                                    <div class="dropdown-divider"></div>
                                    @can('delete-activities')
                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('{{ __('activities.delete_confirmation') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> {{ __('activities.remove') }}
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
                            <i class="bx bx-search-alt-2 mb-2" style="font-size: 3rem;"></i>
                            <p class="mb-0">{{ __('activities.no_results') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($activities->hasPages() || $activities->total() > 0)
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small mb-3 mb-md-0">
            {{ __('activities.showing') }} <strong>{{ $activities->firstItem() ?? 0 }}</strong> {{ __('activities.to') }} <strong>{{ $activities->lastItem() ?? 0 }}</strong> {{ __('activities.of') }} <strong>{{ $activities->total() }}</strong> {{ __('activities.results') }}
        </div>
        <div class="pagination-wrapper">
            {{ $activities->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection