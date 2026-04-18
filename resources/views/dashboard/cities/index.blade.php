@extends('layouts/contentNavbarLayout')

@section('title', __('cities.title'))

@section('content')

<div class="row g-4 mb-4">
    {{-- Total Cities --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3"> 
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-primary">{{ __('cities.total_cities') }}</h6>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2 fw-black">{{ $stats['total_cities'] }}</h4>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-buildings fs-3"></i> 
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Coverage Area --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(3, 195, 236, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-info">{{ __('cities.coverage_area') }}</h6>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2 fw-black">{{ number_format($stats['total_radius']) }}</h4>
                            <small class="text-muted">{{ __('cities.km') }}</small>
                        </div>
                    </div>
                    <span class="badge bg-info rounded-circle p-2">
                        <i class="bx bx-radar fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Business Accounts --}}
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-warning">{{ __('cities.business_accounts') }}</h6>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0 me-2 fw-black">{{ $stats['total_accounts'] }}</h4>
                        </div>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-store-alt fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card rounded-4 overflow-hidden"> 
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 gap-3">
        <h5 class="card-title mb-0">{{ __('cities.title') }}</h5>
        
        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
            <form action="{{ route('cities.index') }}" method="GET" class="d-flex w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('cities.search_placeholder') }}">
                </div>
            </form>
            @can('create-cities')
                <a href="{{ route('cities.create') }}" class="btn btn-primary text-nowrap rounded-pill">
                    <i class="bx bx-plus-circle me-1"></i> {{ __('cities.add_city') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th>{{ __('cities.th_city_name') }}</th>
                    <th>{{ __('cities.th_coordinates') }}</th>
                    <th>{{ __('cities.th_coverage') }}</th>
                    <th>{{ __('cities.th_accounts') }}</th>
                    <th>{{ __('cities.th_date') }}</th>
                    @if(auth()->user()->can('edit-cities') || auth()->user()->can('delete-cities'))
                        <th class="text-center">{{ __('cities.th_actions') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($cities as $city)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="bx bx-buildings fs-5"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading">{{ $city->getTranslation('name', 'en') }}</span>
                                <small class="text-muted">{{ $city->getTranslation('name', 'ar') }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column small">
                            <span><i class="bx bx-map-pin text-primary me-1"></i>{{ number_format($city->latitude, 5) }}</span>
                            <span><i class="bx bx-map-pin text-primary me-1"></i>{{ number_format($city->longitude, 5) }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-info rounded-pill">
                            {{ $city->radius }} {{ __('cities.km') }}
                        </span>
                    </td>
                    <td>
                        <span class="fw-medium">{{ $city->business_accounts_count }}</span> <small class="text-muted">{{ __('cities.users_unit') }}</small>
                    </td>
                    <td>
                        <span class="text-muted small">{{ $city->created_at->format('d M y') }}</span>
                    </td>
                    @if(auth()->user()->can('edit-cities') || auth()->user()->can('delete-cities'))
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @can('edit-cities')
                                        <a class="dropdown-item" href="{{ route('cities.edit', $city->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> {{ __('cities.edit') }}
                                        </a>
                                    @endcan
                                <div class="dropdown-divider"></div>
                                    @can('delete-cities')
                                        <form action="{{ route('cities.destroy', $city->id) }}" method="POST" onsubmit="return confirm('{{ __('cities.delete_confirm') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> {{ __('cities.delete') }}
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
                            <i class="bx bx-search-alt-2 mb-2" style="font-size: 3rem;"></i>
                            <p class="mb-0">{{ __('cities.no_results') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($cities->hasPages() || $cities->total() > 0)
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small mb-3 mb-md-0">
            {{ __('cities.showing') }} <strong>{{ $cities->firstItem() ?? 0 }}</strong> {{ __('cities.to') }} <strong>{{ $cities->lastItem() ?? 0 }}</strong> {{ __('cities.of') }} <strong>{{ $cities->total() }}</strong> {{ __('cities.results') }}
        </div>
        <div class="pagination-wrapper">
            {{ $cities->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection