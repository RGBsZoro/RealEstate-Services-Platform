<?php $__env->startSection('title', __('business.req_details')); ?>

<?php $__env->startSection('page-style'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 300px; border-radius: 0.5rem; z-index: 1; }
    .detail-item { margin-bottom: 1rem; border-bottom: 1px solid #ebedf0; padding-bottom: 0.5rem; }
    .detail-label { color: #8592a3; font-weight: 500; }
    .detail-value { font-weight: 500; color: #566a7f; }
    [dir="rtl"] .detail-value { text-align: right; }

    /* التنسيق الموحد للأزرار القوية */
    .btn-approve { background-color: #28c76f !important; border-color: #28c76f !important; color: #fff !important; }
    .btn-approve:hover { background-color: #24b364 !important; box-shadow: 0 8px 25px -8px #28c76f; }
    .btn-reject { background-color: #ea5455 !important; border-color: #ea5455 !important; color: #fff !important; }
    .btn-reject:hover { background-color: #e03e3e !important; box-shadow: 0 8px 25px -8px #ea5455; }
    
    .card { border-radius: 0.75rem; border: none; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold py-3 mb-0">
        <span class="text-muted fw-light"><?php echo e(__('business.requests_title')); ?> /</span> <?php echo e(__('business.req_details')); ?>

    </h4>
    
    <span class="badge <?php echo e($businessAccount->status->badge()); ?> fs-6 px-3 py-2 rounded-pill shadow-sm">
        <?php echo e($businessAccount->status->label()); ?>

    </span>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-7 col-md-12 mb-4">
        
        <div class="card mb-4 shadow-sm">
            <h5 class="card-header border-bottom bg-transparent fw-bold"><?php echo e(__('business.full_info')); ?></h5>
            <div class="card-body mt-3">
                <div class="row detail-item">
                    <div class="col-sm-4 detail-label"><?php echo e(__('business.acc_name_en')); ?></div>
                    <div class="col-sm-8 detail-value"><?php echo e($businessAccount->getTranslation('name', 'en') ?? __('business.na')); ?></div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label"><?php echo e(__('business.acc_name_ar')); ?></div>
                    <div class="col-sm-8 detail-value"><?php echo e($businessAccount->getTranslation('name', 'ar') ?? __('business.na')); ?></div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label"><?php echo e(__('business.license_no')); ?></div>
                    <div class="col-sm-8">
                        <span class="badge bg-label-dark rounded-pill"><?php echo e($businessAccount->license_number ?? __('business.not_provided')); ?></span>
                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label"><?php echo e(__('business.main_activity')); ?></div>
                    <div class="col-sm-8 detail-value">
                        <i class="bx bx-briefcase me-1 text-primary"></i> 
                        <?php echo e($businessAccount->activity?->name ?? __('business.na')); ?>

                    </div>
                </div>

                <div class="row detail-item">
                    <div class="col-sm-4 detail-label"><?php echo e(__('business.primary_city')); ?></div>
                    <div class="col-sm-8 detail-value">
                        <i class="bx bx-map me-1 text-danger"></i> 
                        <?php echo e($businessAccount->city?->name ?? __('business.na')); ?>

                    </div>
                </div>

                <div class="row detail-item border-bottom-0 mb-0">
                    <div class="col-sm-4 detail-label"><?php echo e(__('business.applicant')); ?></div>
                    <div class="col-sm-8 detail-value">
                        <div class="d-flex align-items-center bg-light p-2 rounded-3">
                            <i class="bx bx-user-circle fs-3 me-2 text-primary"></i>
                            <div>
                                <div class="fw-bold"><?php echo e($businessAccount->user?->name ?? __('business.unknown')); ?></div>
                                <small class="text-muted"><?php echo e($businessAccount->user?->email ?? ''); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card mb-4 shadow-sm">
            <h5 class="card-header border-bottom bg-transparent fw-bold"><?php echo e(__('business.desc_activities')); ?></h5>
            <div class="card-body mt-3">
                <h6 class="text-muted small text-uppercase fw-bold mb-2"><?php echo e(__('business.detailed_text')); ?></h6>
                <div class="bg-light p-3 rounded-3 mb-4 text-secondary" style="white-space: pre-line;">
                    <?php echo e($businessAccount->activities ?? __('business.na')); ?>

                </div>

                <h6 class="text-muted small text-uppercase fw-bold mb-2"><?php echo e(__('business.additional_details')); ?></h6>
                <div class="bg-light p-3 rounded-3 mb-0 text-secondary" style="white-space: pre-line;">
                    <?php echo e($businessAccount->details ?? __('business.na')); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-lg-5 col-md-12">
        
        <div class="card mb-4 shadow-sm">
            <h5 class="card-header border-bottom bg-transparent fw-bold"><?php echo e(__('business.location_map')); ?></h5>
            <div class="card-body mt-3">
                <?php if($businessAccount->latitude && $businessAccount->longitude): ?>
                    <div class="mb-3 d-flex align-items-center text-muted small">
                        <i class="bx bx-current-location me-1 text-danger"></i>
                        <?php echo e($businessAccount->latitude); ?>, <?php echo e($businessAccount->longitude); ?>

                    </div>
                    <div id="map" class="shadow-sm border"></div>
                <?php else: ?>
                    <div class="alert alert-warning mb-0 small"><?php echo e(__('business.no_gps')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="card mb-4 shadow-sm">
            <h5 class="card-header border-bottom bg-transparent fw-bold"><?php echo e(__('business.attachments')); ?></h5>
            <div class="card-body mt-3">
                <?php $mediaItems = $businessAccount->getMedia('*'); ?>
                <?php if($mediaItems->count() > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $mediaItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom-dashed">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-file"></i></span>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="mb-0 fw-medium text-truncate" style="max-width: 200px;"><?php echo e($media->file_name); ?></p>
                                        <small class="text-muted"><?php echo e($media->human_readable_size); ?></small>
                                    </div>
                                </div>
                                <a href="<?php echo e($media->getUrl()); ?>" target="_blank" class="btn btn-sm btn-icon btn-outline-primary">
                                    <i class="bx bx-download"></i>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-3">
                        <i class="bx bx-folder-open fs-2 text-muted mb-2"></i>
                        <p class="text-muted small mb-0"><?php echo e(__('business.no_attachments')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($businessAccount->status === \App\Enum\StatusEnum::PENDING): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-business-accounts')): ?> 
                <div class="card bg-transparent shadow-none border-0 mt-4">
                    <div class="card-body p-0">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <form action="<?php echo e(route('business-accounts.approve', $businessAccount->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-approve w-100 btn-lg rounded-3 py-3 fw-bold shadow-sm" 
                                        onclick="return confirm('<?php echo e(__("business.approve_confirm_msg") ?? "Are you sure?"); ?>')">
                                        <i class="bx bx-check-circle fs-4 me-2"></i> <?php echo e(__('business.approve_req')); ?>

                                    </button>
                                </form>
                            </div>
                            <div class="col-12 col-md-6">
                                <button type="button" class="btn btn-reject w-100 btn-lg rounded-3 py-3 fw-bold shadow-sm" 
                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="bx bx-x-circle fs-4 me-2"></i> <?php echo e(__('business.reject_req')); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title text-danger fw-bold fs-4"><?php echo e(__('business.reject_req')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('business-accounts.reject', $businessAccount->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <label for="rejection_reason" class="form-label fw-bold mb-2"><?php echo e(__('business.rejection_reason')); ?></label>
                    <textarea id="rejection_reason" name="rejection_reason" class="form-control border-2" rows="5" 
                        placeholder="<?php echo e(__('business.rejection_placeholder')); ?>"></textarea>
                </div>
                <div class="modal-footer border-top p-4">
                    <button type="button" class="btn btn-label-secondary px-4 py-2" data-bs-dismiss="modal"><?php echo e(__('business.cancel')); ?></button>
                    <button type="submit" class="btn btn-danger px-4 py-2 fw-bold shadow-sm"><?php echo e(__('business.confirm_rejection')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<?php if($businessAccount->latitude && $businessAccount->longitude): ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lat = <?php echo e($businessAccount->latitude); ?>;
        var lng = <?php echo e($businessAccount->longitude); ?>;
        var map = L.map('map', { scrollWheelZoom: false }).setView([lat, lng], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b><?php echo e(addslashes($businessAccount->getTranslation("name", app()->getLocale()))); ?></b>')
            .openPopup();
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/business-accounts/show.blade.php ENDPATH**/ ?>