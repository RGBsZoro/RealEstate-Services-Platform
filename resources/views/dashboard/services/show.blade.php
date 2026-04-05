@extends('layouts/contentNavbarLayout')

@section('title', 'Service Details')

@section('page-style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 300px; border-radius: 0.5rem; z-index: 1; }
    .detail-item { margin-bottom: 1rem; border-bottom: 1px solid #ebedf0; padding-bottom: 0.5rem; }
    .detail-label { color: #8592a3; font-weight: 500; }
    .detail-value { font-weight: 500; color: #566a7f; }
    .gallery-img { width: 100%; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #ebedf0; }
    .main-img { width: 100%; height: 250px; object-fit: cover; border-radius: 0.5rem; border: 1px solid #ebedf0; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
        <span class="text-muted fw-light">Services /</span> Request Details
    </h4>
    <span class="badge {{ $service->status->badge() ?? 'bg-label-warning' }} fs-6 px-3 py-2">
        {{ $service->status->label() ?? ucfirst($service->status) }}
    </span>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 mb-4">
        
        <div class="card mb-4">
            <h5 class="card-header border-bottom">Service Information</h5>
            <div class="card-body mt-3">
                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Title</div>
                    <div class="col-sm-8 detail-value">{{ $service->title }}</div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Business Account</div>
                    <div class="col-sm-8 detail-value">
                        <i class="bx bx-store me-1 text-primary"></i> 
                        {{ $service->businessAccount->getTranslation('name', 'en') ?? $service->businessAccount->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Category</div>
                    <div class="col-sm-8 detail-value">
                        <i class="bx bx-category me-1 text-secondary"></i> 
                        {{ $service->category->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Type</div>
                    <div class="col-sm-8 detail-value">
                        <span class="badge bg-label-{{ $service->type == 'sale' ? 'success' : 'info' }}">
                            {{ ucfirst($service->type) }}
                        </span>
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Price (USD)</div>
                    <div class="col-sm-8 detail-value text-success fw-bold">${{ number_format($service->price_usd, 2) }}</div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Price (SYP)</div>
                    <div class="col-sm-8 detail-value">{{ number_format($service->price_syp, 2) }} SYP</div>
                </div>

                <div class="row detail-item border-bottom-0 mb-0">
                    <div class="col-sm-4 detail-label">Quantity</div>
                    <div class="col-sm-8 detail-value">{{ $service->quantity }}</div>
                </div>
            </div>
        </div>

        @if($service->fieldValues->isNotEmpty())
        <div class="card mb-4">
            <h5 class="card-header border-bottom">Dynamic Features</h5>
            <div class="card-body mt-3">
                <div class="row">
                    @foreach($service->fieldValues as $field)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column bg-light p-2 rounded border border-gray-200">
                                <span class="text-muted small">{{ $field->dynamicField->label ?? 'Unknown Field' }}</span>
                                <span class="fw-bold text-heading">{{ $field->value }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <h5 class="card-header border-bottom">Description</h5>
            <div class="card-body mt-3">
                <div class="bg-light p-3 rounded">
                    {{ $service->description ?? 'No description provided.' }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-lg-5 col-md-12">
        
        <div class="card mb-4">
            <h5 class="card-header border-bottom">Media & Gallery</h5>
            <div class="card-body mt-3">
                @php
                    $mainImage = $service->getFirstMediaUrl('main_image_service');
                    $gallery = $service->getMedia('gallery_services');
                @endphp

                <div class="mb-3">
                    <h6 class="text-muted mb-2">Main Image</h6>
                    @if($mainImage)
                        <a href="{{ $mainImage }}" target="_blank">
                            <img src="{{ $mainImage }}" alt="Main Image" class="main-img">
                        </a>
                    @else
                        <div class="alert alert-secondary mb-0">No main image uploaded.</div>
                    @endif
                </div>

                @if($gallery->count() > 0)
                    <h6 class="text-muted mb-2 mt-4">Gallery</h6>
                    <div class="row g-2">
                        @foreach($gallery as $media)
                            <div class="col-4">
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    <img src="{{ $media->getUrl() }}" alt="Gallery Image" class="gallery-img">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header border-bottom">Service Location</h5>
            <div class="card-body mt-3">
                @if($service->latitude && $service->longitude)
                    <div class="mb-2 text-muted small">Coordinates: {{ $service->latitude }}, {{ $service->longitude }}</div>
                    <div id="map"></div>
                @else
                    <div class="alert alert-warning mb-0">No GPS coordinates provided for this service.</div>
                @endif
            </div>
        </div>

        @if($service->status === 'pending' || (is_object($service->status) && $service->status->value === 'pending'))
        <div class="card bg-transparent shadow-none border-0">
            <div class="card-body p-0 d-flex gap-2">
                <form action="{{ route('services.approve', $service->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 btn-lg" onclick="return confirm('Are you sure you want to approve this service?')">
                        <i class="bx bx-check-circle me-1"></i> Approve
                    </button>
                </form>

                <button type="button" class="btn btn-danger w-100 btn-lg" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bx bx-x-circle me-1"></i> Reject
                </button>
            </div>
        </div>
        @endif

    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel1">Reject Service Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('services.reject', $service->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="rejection_reason" class="form-label">Reason for Rejection (Optional)</label>
                            <textarea id="rejection_reason" name="rejection_reason" class="form-control" rows="3" placeholder="Explain why this service is rejected..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page-script')
@if($service->latitude && $service->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = {{ $service->latitude }};
        var lng = {{ $service->longitude }};
        var map = L.map('map').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b>{{ addslashes($service->title) }}</b><br>Service Location.')
            .openPopup();
    });
</script>
@endif
@endsection