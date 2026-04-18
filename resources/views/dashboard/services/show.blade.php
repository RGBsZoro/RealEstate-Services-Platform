@extends('layouts/contentNavbarLayout')

@section('title', __('services.request_details'))

@section('page-style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 300px; border-radius: 0.5rem; z-index: 1; }
    .detail-item { margin-bottom: 1rem; border-bottom: 1px solid #ebedf0; padding-bottom: 0.5rem; }
    .detail-label { color: #8592a3; font-weight: 500; }
    .detail-value { font-weight: 500; color: #566a7f; }
    .gallery-img { width: 100%; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #ebedf0; transition: transform 0.2s; }
    .gallery-img:hover { transform: scale(1.05); }
    .main-img { width: 100%; height: 250px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #ebedf0; }
    
    /* تنسيق أزرار الرفض والقبول المخصص */
    .btn-approve { background-color: #28c76f !important; border-color: #28c76f !important; color: #fff !important; }
    .btn-approve:hover { background-color: #24b364 !important; box-shadow: 0 8px 25px -8px #28c76f; }
    .btn-reject { background-color: #ea5455 !important; border-color: #ea5455 !important; color: #fff !important; }
    .btn-reject:hover { background-color: #e03e3e !important; box-shadow: 0 8px 25px -8px #ea5455; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
        <span class="text-muted fw-light">{{ __('services.title') }} /</span> {{ __('services.request_details') }}
    </h4>
    <span class="badge {{ $service->status->badge() ?? 'bg-label-warning' }} fs-6 px-3 py-2 rounded-pill shadow-sm">
        {{ $service->status->label() ?? ucfirst($service->status) }}
    </span>
</div>

<div class="row">
    {{-- القسم الأيمن: البيانات --}}
    <div class="col-xl-7 col-lg-7 col-md-12 mb-4">
        <div class="card mb-4 shadow-sm rounded-4">
            <h5 class="card-header border-bottom bg-transparent fw-bold">{{ __('services.service_info') }}</h5>
            <div class="card-body mt-3">
                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">{{ __('services.th_title') }}</div>
                    <div class="col-sm-8 detail-value">{{ $service->title }}</div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">{{ __('services.th_business') }}</div>
                    <div class="col-sm-8 detail-value text-primary fw-bold">
                        <i class="bx bx-store me-1"></i> 
                        {{ $service->businessAccount?->getTranslation('name', app()->getLocale()) ?? 'N/A' }}
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">{{ __('services.th_category') }}</div>
                    <div class="col-sm-8 detail-value">
                        <i class="bx bx-category me-1 text-secondary"></i> 
                        {{ $service->category?->getTranslation('name', app()->getLocale()) ?? 'N/A' }}
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">{{ __('fields.input_type') }}</div>
                    <div class="col-sm-8">
                        <span class="badge bg-label-{{ $service->type == 'sale' ? 'success' : 'info' }} rounded-pill">
                            {{ __('services.' . $service->type) }}
                        </span>
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">{{ __('services.th_type_price') }} (USD)</div>
                    <div class="col-sm-8 detail-value text-success fw-bold">${{ number_format($service->price_usd, 2) }}</div>
                </div>

                <div class="row detail-item border-bottom-0">
                    <div class="col-sm-4 detail-label">{{ __('services.qty') }}</div>
                    <div class="col-sm-8 detail-value">{{ $service->quantity }}</div>
                </div>
            </div>
        </div>

        {{-- الحقول الديناميكية مع حل مشكلة الـ Null --}}
        @if($service->fieldValues->isNotEmpty())
        <div class="card mb-4 shadow-sm rounded-4 border-0">
            <h5 class="card-header border-bottom bg-transparent fw-bold">{{ __('services.dynamic_features') }}</h5>
            <div class="card-body mt-3">
                <div class="row">
                    @foreach($service->fieldValues as $field)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column bg-light p-3 rounded-3 border border-gray-100">
                                <span class="text-muted small mb-1">
                                    {{-- استخدام الـ Safe Navigation لتجنب الإيرور --}}
                                    {{ $field->field?->getTranslation('label', app()->getLocale()) ?? 'Field Not Found' }}
                                </span>
                                <span class="fw-bold text-heading">{{ $field->value }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="card mb-4 shadow-sm rounded-4">
            <h5 class="card-header border-bottom bg-transparent fw-bold">{{ __('services.description') }}</h5>
            <div class="card-body mt-3">
                <div class="bg-light p-3 rounded-3 text-secondary" style="white-space: pre-line; min-height: 100px;">
                    {{ $service->description ?? __('services.no_description') }}
                </div>
            </div>
        </div>
    </div>

    {{-- القسم الأيسر: ميديا وموقع وأزرار --}}
    <div class="col-xl-5 col-lg-5 col-md-12">
        <div class="card mb-4 shadow-sm rounded-4">
            <h5 class="card-header border-bottom bg-transparent fw-bold">{{ __('services.media_gallery') }}</h5>
            <div class="card-body mt-3">
                @php
                    $mainImage = $service->getFirstMediaUrl('main_image_service');
                    $gallery = $service->getMedia('gallery_services');
                @endphp
                <div class="mb-4 text-center">
                    @if($mainImage)
                        <a href="{{ $mainImage }}" target="_blank">
                            <img src="{{ $mainImage }}" alt="Main Image" class="main-img shadow-sm border">
                        </a>
                    @else
                        <div class="alert alert-secondary mb-0 small">{{ __('services.no_media') }}</div>
                    @endif
                </div>

                @if($gallery->count() > 0)
                    <div class="row g-2">
                        @foreach($gallery as $media)
                            <div class="col-4">
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl() }}" alt="Gallery Image" class="gallery-img border">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-4 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bx bx-map me-1"></i>{{ __('services.location') }}</h6>
                @if($service->latitude && $service->longitude)
                    <div id="map" class="border shadow-sm"></div>
                @else
                    <div class="alert alert-warning mb-0 small">{{ __('services.no_location') }}</div>
                @endif
            </div>
        </div>

        {{-- أزرار التحكم بالتنسيق الجديد --}}
        @if($service->status->value === 'pending')
            @can('manage-services')
                <div class="card shadow-none bg-transparent border-0 mt-4">
                    <div class="card-body p-0">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <form action="{{ route('services.approve', $service->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-approve w-100 btn-lg rounded-3 shadow-sm py-3 fw-bold" 
                                        onclick="return confirm('{{ __('services.confirm_approve') }}')">
                                        <i class="bx bx-check-circle fs-4 me-2"></i> {{ __('services.approve') }}
                                    </button>
                                </form>
                            </div>
                            <div class="col-12 col-md-6">
                                <button type="button" class="btn btn-reject w-100 btn-lg rounded-3 shadow-sm py-3 fw-bold" 
                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="bx bx-x-circle fs-4 me-2"></i> {{ __('services.reject') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endif
    </div>
</div>

{{-- مودال الرفض بنفس التنسيق القوي --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title text-danger fw-bold fs-4">{{ __('services.reject_modal_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('services.reject', $service->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <label class="form-label fw-bold mb-2">{{ __('services.rejection_reason') }}</label>
                    <textarea name="rejection_reason" class="form-control border-2" rows="5" 
                        placeholder="{{ __('services.rejection_reason') }}..."></textarea>
                </div>
                <div class="modal-footer border-top p-4">
                    <button type="button" class="btn btn-label-secondary px-4 py-2" data-bs-dismiss="modal">{{ __('categories.cancel') }}</button>
                    <button type="submit" class="btn btn-danger px-4 py-2 fw-bold">{{ __('services.confirm_rejection') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-script')
{{-- كود الخريطة يبقى كما هو --}}
@if($service->latitude && $service->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = {{ $service->latitude }};
        var lng = {{ $service->longitude }};
        var map = L.map('map', { scrollWheelZoom: false }).setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup('<b>{{ addslashes($service->title) }}</b>').openPopup();
    });
</script>
@endif
@endsection