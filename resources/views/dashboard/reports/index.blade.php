@extends('layouts/contentNavbarLayout')

@section('title', __('reports.title'))

@section('content')

{{-- Stats Summary --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary">{{ __('reports.total_reports') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['total'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-list-ul fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-warning">{{ __('reports.pending_reports') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['pending'] }}</h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-time-five fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success">{{ __('reports.resolved_reports') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['resolved'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-check-shield fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Management Card --}}
<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-3">{{ __('reports.management_card') }}</h5>
        <form action="{{ route('reports.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('reports.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <select name="status" class="form-select text-capitalize">
                        <option value="">{{ __('reports.all_statuses') }}</option>
                        @foreach(\App\Enum\ReportStatusEnum::cases() as $status)
                            <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
                        {{ __('reports.filter_btn') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
    <table class="table table-hover mb-0">
        <thead class="table-light text-uppercase">
            <tr>
                <th>{{ __('reports.service_info') }}</th>
                <th>{{ __('reports.reporter') }}</th>
                <th>{{ __('reports.status') }}</th>
                <th>{{ __('reports.date_reported') }}</th>
                @if(auth()->user()->can('manage-reports') || auth()->user()->can('delete-reports'))
                    <th class="text-center">{{ __('reports.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @forelse($reports as $report)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3">
                            <span class="avatar-initial rounded-circle bg-label-secondary">
                                <i class="bx bx-flag fs-5"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-heading">{{ $report->service->title ?? __('reports.unknown') }}</span>
                            <small class="text-muted text-truncate" style="max-width: 200px;">{{ $report->reason }}</small>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user me-2 text-primary"></i>
                        <span class="small">{{ $report->user->name ?? __('reports.unknown') }}</span>
                    </div>
                </td>

                <td>
                    <span class="badge {{ $report->status === \App\Enum\ReportStatusEnum::Resolved ? 'bg-label-success' : 'bg-label-warning' }} rounded-pill">
                        {{ $report->status->label() }}
                    </span>
                </td>

                <td>
                    <span class="text-muted small">{{ $report->created_at->format('d M y') }}</span>
                </td>

                @if(auth()->user()->can('manage-reports') || auth()->user()->can('delete-reports'))
                <td class="text-center">
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded fs-4"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal{{ $report->id }}">
                                <i class="bx bx-show-alt me-1"></i> {{ __('reports.view_details') }}
                            </button>

                            @if($report->status !== \App\Enum\ReportStatusEnum::Resolved)
                                @can('manage-reports')
                                <form action="{{ route('reports.resolve', $report->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-success">
                                        <i class="bx bx-check-circle me-1"></i> {{ __('reports.mark_resolved') }}
                                    </button>
                                </form>
                                @endcan
                            @endif

                            @can('delete-reports')
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('{{ __('reports.confirm_delete') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bx bx-trash me-1"></i> {{ __('reports.delete') }}
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </td>
                @endif
            </tr>
            
            @include('dashboard.reports.details_modal', ['report' => $report])
            
            @empty
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="text-muted">
                        <i class="bx bx-search-alt-2 mb-2" style="font-size: 3rem;"></i>
                        <p class="mb-0">{{ __('reports.no_results') }}</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

    @if($reports->hasPages() || $reports->total() > 0)
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            {{ __('reports.showing') }} <strong>{{ $reports->firstItem() ?? 0 }}</strong> {{ __('reports.to') }} <strong>{{ $reports->lastItem() ?? 0 }}</strong> {{ __('reports.of') }} <strong>{{ $reports->total() }}</strong> {{ __('reports.records') }}
        </div>
        <div class="pagination-wrapper">
            {{ $reports->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection