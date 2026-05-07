@extends('layouts/contentNavbarLayout')

@section('title', __('dashboard.page_title'))

@push('vendor-style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css" />
<style>
    /* تحسينات بصرية احترافية */
    .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, 0.4); transition: transform 0.2s; }
    .table thead th { text-transform: none; letter-spacing: 0; font-weight: 700; font-size: 0.85rem; }
    .avatar-initial { font-weight: 600; }
    .border-dashed { border-style: dashed !important; }
    /* لضمان تناسق ارتفاع الجداول مع المخططات */
    .table-responsive { min-height: 300px; }
</style>
@endpush

@section('content')

<div class="row mb-6">
    <div class="col-lg-8">
        <div class="card h-100 bg-label-primary border-0 shadow-none">
            <div class="d-flex align-items-center row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3">{{ __('dashboard.welcome_title') }} 🎉</h4>
                        <p class="mb-4 text-dark" style="opacity: 0.8">{{ __('dashboard.tasks_summary') }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('business-accounts.index') }}" class="btn btn-primary btn-sm">
                                {{ __('dashboard.review_accounts') }} ({{ $stats['pending_business_accounts'] }})
                            </a>
                            <a href="{{ route('services.index') }}" class="btn btn-outline-primary btn-sm">
                                {{ __('dashboard.services') }} ({{ $stats['pending_services'] }})
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 text-center">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}" height="140" alt="Dashboard Welcome">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row g-4 h-100">
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="avatar mx-auto mb-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-shield fs-4"></i></span>
                        </div>
                        <span class="d-block mb-1 text-muted small">{{ __('dashboard.active_accounts') }}</span>
                        <h4 class="card-title mb-0">{{ $stats['total_business_accounts'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="avatar mx-auto mb-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-error-alt fs-4"></i></span>
                        </div>
                        <span class="d-block mb-1 text-muted small">{{ __('dashboard.open_reports') }}</span>
                        <h4 class="card-title mb-0 text-danger">{{ $stats['pending_reports'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-6">
    <div class="col-md-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('dashboard.pending_business_accounts') }}</h5>
                <a href="{{ route('business-accounts.index') }}" class="btn btn-sm btn-label-primary">{{ __('dashboard.view_all') }}</a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('dashboard.name_user') }}</th>
                            <th>{{ __('dashboard.business_activity') }}</th>
                            <th>{{ __('dashboard.date') }}</th>
                            <th>{{ __('dashboard.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['latest_pending_accounts'] as $account)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <img src="{{ $account->getFirstMediaUrl('images') ?: asset('assets/img/avatars/1.png') }}" class="rounded-circle">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium small">{{ $account->getTranslation('name', app()->getLocale()) }}</span>
                                        <small class="text-muted" style="font-size: 0.7rem;">{{ $account->user->name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-info">{{ $account->activity->getTranslation('name', app()->getLocale()) }}</span></td>
                            <td><span class="small text-muted">{{ $account->created_at->format('Y-m-d') }}</span></td>
                            <td>
                                <a href="{{ route('business-accounts.show', $account->id) }}" class="btn btn-icon btn-sm btn-outline-secondary"><i class="bx bx-show"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">{{ __('dashboard.property_analytics') }}</h5>
                    <small class="text-muted">{{ __('dashboard.total_activity') }}</small>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-around align-items-center mt-4 mb-6 py-3 border rounded border-dashed">
                    <div class="text-center border-end w-50">
                        <h6 class="mb-1 small">{{ __('dashboard.for_sale') }}</h6>
                        <p class="mb-0 fw-bold text-primary">{{ $stats['charts']['services_type']['sale'] }}</p>
                    </div>
                    <div class="text-center w-50">
                        <h6 class="mb-1 small">{{ __('dashboard.for_rent') }}</h6>
                        <p class="mb-0 fw-bold text-info">{{ $stats['charts']['services_type']['rent'] }}</p>
                    </div>
                </div>
                <div id="servicesChart"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-1">{{ __('dashboard.latest_pending_services') }}</h5>
                <p class="card-subtitle text-muted small">{{ __('dashboard.requires_approval') }}</p>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-sm align-middle">
                    <thead>
                        <tr class="text-muted small border-bottom">
                            <th class="ps-4">{{ __('dashboard.property') }}</th>
                            <th>{{ __('dashboard.office') }}</th>
                            <th class="text-end pe-4">{{ __('dashboard.price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['latest_pending_services'] as $service)
                        <tr class="border-bottom">
                            <td class="py-3 ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $service->getFirstMediaUrl('main_image_service') ?: asset('assets/img/elements/1.jpg') }}" width="45" height="45" class="rounded me-3 object-fit-cover">
                                    <span class="fw-medium small">{{ $service->title }}</span>
                                </div>
                            </td>
                            <td class="small">{{ $service->businessAccount->getTranslation('name', app()->getLocale()) }}</td>
                            <td class="text-end pe-4 fw-bold text-dark">{{ number_format($service->price_syp) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">{{ __('dashboard.weekly_interaction_rate') }}</h5>
                <span class="badge bg-label-success">{{ __('dashboard.active') }}</span>
            </div>
            <div class="card-body">
                <div id="weeklyRequestsChart"></div>
                <div class="mt-4 text-center">
                    <p class="text-muted small mb-0">{{ __('dashboard.chart_description') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. إعدادات مخطط الدائرة (Donut Chart)
    const servicesChartEl = document.querySelector('#servicesChart');
    if (servicesChartEl) {
        const servicesChart = new ApexCharts(servicesChartEl, {
            chart: { height: 280, type: 'donut' },
            labels: ["{{ __('dashboard.sale') }}", "{{ __('dashboard.rent') }}"],
            series: [{{ $stats['charts']['services_type']['sale'] }}, {{ $stats['charts']['services_type']['rent'] }}],
            colors: ['#696cff', '#03c3ec'],
            stroke: { width: 5, colors: ['#ffffff'] },
            dataLabels: { enabled: false },
            legend: { show: true, position: 'bottom', fontFamily: 'Public Sans' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: { fontSize: '1.5rem', fontWeight: 500, color: '#566a7f', offsetY: -10 },
                            name: { offsetY: 20 },
                            total: {
                                show: true,
                                label: "{{ __('dashboard.total') }}",
                                color: '#a1acb8',
                                formatter: function (w) { return {{ $stats['total_services'] }}; }
                            }
                        }
                    }
                }
            }
        });
        servicesChart.render();
    }

    // 2. إعدادات مخطط المساحة (Weekly Interaction Area Chart)
    const weeklyChartEl = document.querySelector('#weeklyRequestsChart');
    if (weeklyChartEl) {
        const weeklyChart = new ApexCharts(weeklyChartEl, {
            chart: { height: 250, type: 'area', toolbar: { show: false } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [{ 
                name: "{{ __('dashboard.requests') }}", 
                data: @json($stats['charts']['weekly_requests']['data']) 
            }],
            xaxis: { 
                categories: @json($stats['charts']['weekly_requests']['labels']),
                labels: { style: { colors: '#a1acb8', fontSize: '12px' } }
            },
            yaxis: { labels: { show: false } },
            grid: { borderColor: '#f1f1f1', strokeDashArray: 5 },
            colors: ['#71dd37'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1, stops: [0, 90, 100] }
            }
        });
        weeklyChart.render();
    }
});
</script>
@endpush