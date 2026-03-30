@extends('layouts/contentNavbarLayout')

@section('title', 'Edit City - Real Estate Platform')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-4">
                <h5 class="mb-0">Edit City: {{ $city->getTranslation('name', 'en') }}</h5>
                <small class="text-muted float-end">Update Service Coverage</small>
            </div>

            <div class="card-body">
                <form action="{{ route('cities.update', $city->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label" for="name_en">City Name (English) <span class="text-danger">*</span></label>
                            <input type="text" id="name_en" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" 
                                value="{{ old('name.en', $city->getTranslation('name', 'en')) }}" required>
                            @error('name.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="name_ar">City Name (Arabic) <span class="text-danger">*</span></label>
                            <input type="text" id="name_ar" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror" 
                                value="{{ old('name.ar', $city->getTranslation('name', 'ar')) }}" dir="rtl" required>
                            @error('name.ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label text-primary fw-bold">
                                <i class="bx bx-map-pin me-1"></i> Update City Center & Radius
                            </label>
                            <div class="input-group mb-2">
                                <input type="text" id="map-search" class="form-control" placeholder="Search for a new location...">
                                <button type="button" class="btn btn-outline-primary" id="search-btn"><i class="bx bx-search"></i> Search</button>
                            </div>
                            <div id="map" style="height: 450px; width: 100%; border-radius: 8px; border: 1px solid #d9dee3;"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" id="lat_input" name="latitude" class="form-control bg-light" 
                                value="{{ old('latitude', $city->latitude) }}" readonly required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" id="lng_input" name="longitude" class="form-control bg-light" 
                                value="{{ old('longitude', $city->longitude) }}" readonly required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Radius (Kilometers)</label>
                            <div class="input-group">
                                <input type="number" id="radius_input" name="radius" class="form-control" 
                                    value="{{ old('radius', $city->radius) }}" step="0.5" min="1" required>
                                <span class="input-group-text">KM</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-4">
                        <button type="submit" class="btn btn-success px-5">
                            <i class="bx bx-save me-1"></i> Update Changes
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
    // جلب البيانات من السيرفر (PHP to JS)
    var savedLat = {{ $city->latitude }};
    var savedLng = {{ $city->longitude }};
    var savedRadius = {{ $city->radius }} * 1000; // تحويل إلى متر

    // 1. Initialize Map at saved location
    var map = L.map('map').setView([savedLat, savedLng], 12); 

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // 2. Draggable Marker at saved location
    var marker = L.marker([savedLat, savedLng], { draggable: true }).addTo(map);

    // 3. Visualization Circle with saved radius
    var circle = L.circle([savedLat, savedLng], {
        color: '#696cff',
        fillColor: '#696cff',
        fillOpacity: 0.2,
        radius: savedRadius
    }).addTo(map);

    function updateFields(lat, lng) {
        document.getElementById('lat_input').value = lat.toFixed(7);
        document.getElementById('lng_input').value = lng.toFixed(7);
    }

    // 4. Sync Marker & Circle
    marker.on('drag', function(e) {
        var pos = marker.getLatLng();
        circle.setLatLng(pos);
        updateFields(pos.lat, pos.lng);
    });

    // 5. Reverse Geocoding (بصورة اختيارية للتعديل)
    marker.on('dragend', function(e) {
        var pos = marker.getLatLng();
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${pos.lat}&lon=${pos.lng}&accept-language=en,ar`, {
            headers: { 'User-Agent': 'RealEstateApp/1.0' }
        })
        .then(res => res.json())
        .then(data => {
            // ملاحظة: لا نغير الاسم تلقائياً في التعديل إلا إذا كان الحقل فارغاً لكي لا نمسح تعديلات المستخدم اليدوية
        });
    });

    // 6. Search
    document.getElementById('search-btn').onclick = function(e) {
        e.preventDefault(); 
        var query = document.getElementById('map-search').value;
        if(query.length < 3) return;

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
            }
        });
    };

    // 7. Sync Radius
    document.getElementById('radius_input').oninput = function() {
        circle.setRadius(this.value * 1000);
    };
</script>
@endsection