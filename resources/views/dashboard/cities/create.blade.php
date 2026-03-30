@extends('layouts/contentNavbarLayout')

@section('title', 'Add New City - Real Estate Platform')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-4">
                <h5 class="mb-0">Create New City (Coverage Area)</h5>
                <small class="text-muted float-end">Real Estate Service Zones</small>
            </div>

            <div class="card-body">
                <form action="{{ route('cities.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label" for="name_en">City Name (English) <span class="text-danger">*</span></label>
                            <input type="text" id="name_en" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                placeholder="e.g. Damascus" value="{{ old('name.en') }}" required>
                            @error('name.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="name_ar">City Name (Arabic) <span class="text-danger">*</span></label>
                            <input type="text" id="name_ar" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror" 
                                placeholder="مثلاً: دمشق" value="{{ old('name.ar') }}" dir="rtl" required>
                            @error('name.ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label text-primary fw-bold">
                                <i class="bx bx-map-pin me-1"></i> Locate City Center & Define Radius
                            </label>
                            <div class="input-group mb-2">
                                <input type="text" id="map-search" class="form-control" placeholder="Search for a city or district (Min 3 chars)...">
                                <button type="button" class="btn btn-outline-primary" id="search-btn">
                                    <i class="bx bx-search"></i> Search
                                </button>
                            </div>
                            <div id="map" style="height: 450px; width: 100%; border-radius: 8px; border: 1px solid #d9dee3;"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" id="lat_input" name="latitude" class="form-control bg-light" 
                                value="{{ old('latitude') }}" readonly required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" id="lng_input" name="longitude" class="form-control bg-light" 
                                value="{{ old('longitude') }}" readonly required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Radius (Kilometers)</label>
                            <div class="input-group">
                                <input type="number" id="radius_input" name="radius" class="form-control" 
                                    value="{{ old('radius', 15) }}" step="0.5" min="1" required>
                                <span class="input-group-text">KM</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-4">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bx bx-check-circle me-1"></i> Confirm & Save City
                        </button>
                        <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // 1. Initialize Map
    var map = L.map('map').setView([33.5138, 36.2765], 11); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // 2. Draggable Marker
    var marker = L.marker([33.5138, 36.2765], { draggable: true }).addTo(map);

    // 3. Visualization Circle
    var circle = L.circle([33.5138, 36.2765], {
        color: '#696cff',
        fillColor: '#696cff',
        fillOpacity: 0.2,
        radius: 10000 // default 10km
    }).addTo(map);

    function updateFields(lat, lng) {
        document.getElementById('lat_input').value = lat.toFixed(7);
        document.getElementById('lng_input').value = lng.toFixed(7);
    }

    // Initialize fields with default marker position
    updateFields(33.5138, 36.2765);

    // 4. Sync Marker & Circle during drag
    marker.on('drag', function(e) {
        var pos = marker.getLatLng();
        circle.setLatLng(pos);
        updateFields(pos.lat, pos.lng);
    });

    // 5. Reverse Geocoding on drag end
    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${pos.lat}&lon=${pos.lng}&accept-language=en,ar`, {
            headers: { 'User-Agent': 'RealEstateApp/1.0' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.address) {
                const city = data.address.city || data.address.town || data.address.state || "";
                if(!document.getElementById('name_en').value) {
                    document.getElementById('name_en').value = city;
                }
            }
        });
    });

    // 6. Fix Search Functionality (Prevent Form Submission & White Screen)
    document.getElementById('search-btn').onclick = function(e) {
        e.preventDefault(); 
        var query = document.getElementById('map-search').value;
        
        if(query.length < 3) {
            alert("Please enter at least 3 characters to search.");
            return;
        }

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`, {
            headers: { 'User-Agent': 'RealEstateApp/1.0' } 
        })
        .then(res => res.json())
        .then(data => {
            if(data.length > 0) {
                var location = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                map.setView(location, 13);
                marker.setLatLng(location);
                circle.setLatLng(location);
                updateFields(location[0], location[1]);
            } else {
                alert("Location not found, please try another name.");
            }
        })
        .catch(err => {
            console.error("Search Error:", err);
            alert("An error occurred while searching. Please try again.");
        });
    };

    // 7. Sync Radius Input
    document.getElementById('radius_input').oninput = function() {
        var meters = this.value * 1000;
        circle.setRadius(meters);
    };
</script>
@endsection