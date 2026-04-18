@extends('layouts/contentNavbarLayout')

@section('title', __('services.title'))

@section('content')

{{-- الإحصائيات العلويّة --}}
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between text-nowrap">
                    <div>
                        <h6 class="mb-1 fw-bold text-warning">{{ __('services.pending_requests') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['pending'] }}</h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2"><i class="bx bx-time-five fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success">{{ __('services.approved_services') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['approved'] }}</h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-check-double fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary">{{ __('services.total_processed') }}</h6>
                        <h4 class="mb-0 fw-black">{{ $stats['approved'] + $stats['rejected'] }}</h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2"><i class="bx bx-list-ul fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- جدول البيانات مع التصفية --}}
<div class="card rounded-4 overflow-hidden shadow-sm">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-3">{{ __('services.management_card') }}</h5>
        <form action="{{ route('services.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('services.search_placeholder') }}">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select text-capitalize">
                        <option value="">{{ __('services.all_statuses') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('status.pending') }}</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('status.approved') }}</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('status.rejected') }}</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select name="type" class="form-select">
                        <option value="">{{ __('services.all_types') }}</option>
                        <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>{{ __('services.sale') }}</option>
                        <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>{{ __('services.rent') }}</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">{{ __('services.filter_btn') }}</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase small fw-bold">
                <tr>
                    <th>{{ __('services.th_title') }}</th>
                    <th>{{ __('services.th_business') }}</th>
                    <th>{{ __('services.th_category') }}</th>
                    <th>{{ __('services.th_type_price') }}</th>
                    <th>{{ __('services.th_status') }}</th>
                    <th>{{ __('services.th_date') }}</th>
                    <th class="text-center">{{ __('services.th_actions') }}</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($services as $service)
                <tr>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-heading">{{ Str::limit($service->title, 25) }}</span>
                            <small class="text-muted">{{ __('services.qty') }}: {{ $service->quantity }}</small>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-store me-2 text-primary"></i>
                            <span class="small">{{ $service->businessAccount->getTranslation('name', app()->getLocale()) ?? 'Unknown' }}</span>
                        </div>
                    </td>

                    <td>
                        <span class="badge bg-label-secondary rounded-pill small">
                            {{ $service->category->getTranslation('name', app()->getLocale()) ?? 'N/A' }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex flex-column">
                            <span class="badge bg-label-{{ $service->type == 'sale' ? 'success' : 'info' }} mb-1 rounded-pill">
                                {{ __('services.' . $service->type) }}
                            </span>
                            <small class="fw-bold text-dark">${{ number_format($service->price_usd, 2) }}</small>
                        </div>
                    </td>

                    <td>
                        <span class="badge {{ $service->status->badge() }} rounded-pill">
                            {{ $service->status->label() }}
                        </span>
                    </td>

                    <td>
                        <span class="text-muted small">{{ $service->created_at->format('d M, Y') }}</span>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bx bx-show me-1"></i> {{ __('services.view_details') }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search-alt-2 mb-2 fs-1"></i>
                            <p>{{ __('services.no_requests') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- الباجينيشن المعدل --}}
    @if($services->hasPages() || $services->total() > 0)
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            {{ __('categories.showing_count', [
                'first' => $services->firstItem() ?? 0,
                'last' => $services->lastItem() ?? 0,
                'total' => $services->total()
            ]) }}
        </div>
        <div class="pagination-wrapper">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection