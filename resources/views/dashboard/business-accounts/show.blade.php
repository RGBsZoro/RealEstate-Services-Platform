@extends('layouts/contentNavbarLayout')

@section('title', 'Account Request Details')

@section('page-style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 300px; border-radius: 0.5rem; z-index: 1; }
    /* تنسيق خاص لعرض التفاصيل بشكل أوضح */
    .detail-item { margin-bottom: 1rem; border-bottom: 1px solid #ebedf0; padding-bottom: 0.5rem; }
    .detail-label { color: #8592a3; font-weight: 500; }
    .detail-value { font-weight: 500; color: #566a7f; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
        <span class="text-muted fw-light">Business Accounts /</span> Request Details
    </h4>
    <span class="badge {{ $businessAccount->status->badge() }} fs-6 px-3 py-2">
        {{ $businessAccount->status->label() }}
    </span>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 mb-4">
        
        <div class="card mb-4">
            <h5 class="card-header border-bottom">Full Account Information</h5>
            <div class="card-body mt-3">
                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Account Name (EN)</div>
                    <div class="col-sm-8 detail-value">{{ $businessAccount->getTranslation('name', 'en') ?? 'N/A' }}</div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Account Name (AR)</div>
                    <div class="col-sm-8 detail-value text-start">{{ $businessAccount->getTranslation('name', 'ar') ?? 'غير متوفر' }}</div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">License Number</div>
                    <div class="col-sm-8 detail-value"><span class="badge bg-label-dark">{{ $businessAccount->license_number ?? 'Not Provided' }}</span></div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Main Activity</div>
                    <div class="col-sm-8 detail-value"><i class="bx bx-briefcase me-1 text-secondary"></i> {{ $businessAccount->activity->name ?? 'N/A' }}</div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label">Primary City</div>
                    <div class="col-sm-8 detail-value"><i class="bx bx-map me-1 text-danger"></i> {{ $businessAccount->city->name ?? 'N/A' }}</div>
                </div>

                <div class="row detail-item border-bottom-0 mb-0">
                    <div class="col-sm-4 detail-label">Applicant (User)</div>
                    <div class="col-sm-8 detail-value">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-user me-2 text-primary"></i>
                            <div>
                                {{ $businessAccount->user->name ?? 'Unknown' }}<br>
                                <small class="text-muted">{{ $businessAccount->user->email ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header border-bottom">Description & Activities (Detailed)</h5>
            <div class="card-body mt-3">
                <h6 class="text-muted mb-2">Detailed Activities Text (`activities` field)</h6>
                <div class="bg-light p-3 rounded mb-4">
                    {{ $businessAccount->activities ?? 'No activities described.' }}
                </div>

                <h6 class="text-muted mb-2">Additional Details (`details` field)</h6>
                <div class="bg-light p-3 rounded mb-0">
                    {{ $businessAccount->details ?? 'No additional details provided.' }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-lg-5 col-md-12">
        
        <div class="card mb-4">
            <h5 class="card-header border-bottom">Business Location (Map)</h5>
            <div class="card-body mt-3">
                <div class="mb-3 detail-value">
                    <i class="bx bx-map text-danger me-1"></i> <strong>City:</strong> {{ $businessAccount->city->name ?? 'N/A' }}
                </div>
                @if($businessAccount->latitude && $businessAccount->longitude)
                    <div class="mb-2 text-muted small">Coordinates: {{ $businessAccount->latitude }}, {{ $businessAccount->longitude }}</div>
                    <div id="map"></div>
                @else
                    <div class="alert alert-warning mb-0">No GPS coordinates provided for this business.</div>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header border-bottom">License & Attachments (Spatie Media)</h5>
            <div class="card-body mt-3">
                @php
                    $mediaItems = $businessAccount->getMedia('*');
                @endphp

                @if($mediaItems->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($mediaItems as $media)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-file text-primary fs-4 me-2"></i>
                                    <div>
                                        <p class="mb-0 fw-medium text-break">{{ $media->file_name }}</p>
                                        <small class="text-muted">{{ $media->human_readable_size }}</small>
                                    </div>
                                </div>
                                <a href="{{ $media->getUrl() }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">
                                    <i class="bx bx-download"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No files or licenses attached to this request.</p>
                @endif
            </div>
        </div>

        @if($businessAccount->status->value === 'pending')
        <div class="card bg-transparent shadow-none border-0">
            <div class="card-body p-0 d-flex gap-2">
                <form action="{{ route('business-accounts.approve', $businessAccount->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    <button type="submit" class="btn btn-success w-100 btn-lg" onclick="return confirm('Are you sure you want to approve this account?')">
                        <i class="bx bx-check-circle me-1"></i> Approve Request
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
                <h5 class="modal-title text-danger" id="exampleModalLabel1">Reject Account Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('business-accounts.reject', $businessAccount->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="rejection_reason" class="form-label">Reason for Rejection (Optional)</label>
                            <textarea id="rejection_reason" name="rejection_reason" class="form-control" rows="3" placeholder="Explain why this request is rejected..."></textarea>
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
@if($businessAccount->latitude && $businessAccount->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = {{ $businessAccount->latitude }};
        var lng = {{ $businessAccount->longitude }};
        var map = L.map('map').setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b>{{ $businessAccount->getTranslation("name", "en") }}</b><br>Business Location.')
            .openPopup();
    });
</script>
@endif
@endsection