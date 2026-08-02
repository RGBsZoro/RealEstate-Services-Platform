<?php $__env->startSection('title', __('cities.create_title')); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom mb-4">
                <h5 class="mb-0"><?php echo e(__('cities.card_header')); ?></h5>
                <small class="text-muted float-end"><?php echo e(__('cities.service_zones')); ?></small>
            </div>

            <div class="card-body">
                <form action="<?php echo e(route('cities.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label" for="name_en"><?php echo e(__('cities.th_city_name')); ?> (EN) <span class="text-danger">*</span></label>
                            <input type="text" id="name_en" name="name[en]" class="form-control <?php $__errorArgs = ['name.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                placeholder="<?php echo e(__('cities.placeholder_en')); ?>" value="<?php echo e(old('name.en')); ?>" required>
                            <?php $__errorArgs = ['name.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="name_ar"><?php echo e(__('cities.th_city_name')); ?> (AR) <span class="text-danger">*</span></label>
                            <input type="text" id="name_ar" name="name[ar]" class="form-control <?php $__errorArgs = ['name.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                placeholder="<?php echo e(__('cities.placeholder_ar')); ?>" value="<?php echo e(old('name.ar')); ?>" dir="rtl" required>
                            <?php $__errorArgs = ['name.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label text-primary fw-bold">
                                <i class="bx bx-map-pin me-1"></i> <?php echo e(__('cities.map_instruction')); ?>

                            </label>
                            <div class="input-group mb-2">
                                <input type="text" id="map-search" class="form-control" placeholder="<?php echo e(__('cities.map_search_placeholder')); ?>">
                                <button type="button" class="btn btn-outline-primary" id="search-btn">
                                    <i class="bx bx-search"></i> <?php echo e(__('cities.map_search_btn')); ?>

                                </button>
                            </div>
                            <div id="map" style="height: 450px; width: 100%; border-radius: 8px; border: 1px solid #d9dee3;"></div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('cities.latitude')); ?></label>
                            <input type="text" id="lat_input" name="latitude" class="form-control bg-light" 
                                value="<?php echo e(old('latitude')); ?>" readonly required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('cities.longitude')); ?></label>
                            <input type="text" id="lng_input" name="longitude" class="form-control bg-light" 
                                value="<?php echo e(old('longitude')); ?>" readonly required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('cities.radius_label')); ?></label>
                            <div class="input-group">
                                <input type="number" id="radius_input" name="radius" class="form-control" 
                                    value="<?php echo e(old('radius', 15)); ?>" step="0.5" min="1" required>
                                <span class="input-group-text"><?php echo e(__('cities.km')); ?></span>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3 d-flex flex-column justify-content-center pt-md-4">
                            <div class="form-check form-switch mb-0">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" name="is_active" id="is_active" value="1" <?php echo e(old('is_active', '1') == '1' ? 'checked' : ''); ?>>
                                <label class="form-check-label fw-semibold" for="is_active"><?php echo e(__('cities.status_active')); ?></label>
                            </div>
                            <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-4">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bx bx-check-circle me-1"></i> <?php echo e(__('cities.save_city')); ?>

                        </button>
                        <a href="<?php echo e(route('cities.index')); ?>" class="btn btn-outline-secondary ms-2"><?php echo e(__('cities.cancel')); ?></a>
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

    var marker = L.marker([33.5138, 36.2765], { draggable: true }).addTo(map);

    var circle = L.circle([33.5138, 36.2765], {
        color: '#696cff',
        fillColor: '#696cff',
        fillOpacity: 0.2,
        radius: 15000 // default 15km matching input default
    }).addTo(map);

    function updateFields(lat, lng) {
        document.getElementById('lat_input').value = lat.toFixed(7);
        document.getElementById('lng_input').value = lng.toFixed(7);
    }

    updateFields(33.5138, 36.2765);

    marker.on('drag', function(e) {
        var pos = marker.getLatLng();
        circle.setLatLng(pos);
        updateFields(pos.lat, pos.lng);
    });

    // 6. Fix Search Functionality
    document.getElementById('search-btn').onclick = function(e) {
        e.preventDefault(); 
        var query = document.getElementById('map-search').value;
        
        if(query.length < 3) {
            alert("<?php echo e(__('cities.js_min_chars')); ?>");
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
                alert("<?php echo e(__('cities.js_not_found')); ?>");
            }
        })
        .catch(err => {
            console.error("Search Error:", err);
            alert("<?php echo e(__('cities.js_error')); ?>");
        });
    };

    document.getElementById('radius_input').oninput = function() {
        var meters = this.value * 1000;
        circle.setRadius(meters);
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/cities/create.blade.php ENDPATH**/ ?>