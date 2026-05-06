<?php $__env->startSection('title', __('dashboard.page_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl-8 mb-6 order-0">
        <div class="card h-100">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3"><?php echo e(__('dashboard.welcome_title')); ?></h5>
                        <p class="mb-6">
                            <?php echo e(__('dashboard.tasks_summary')); ?>

                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-business-accounts')): ?>
                            <a href="<?php echo e(route('business-accounts.index')); ?>" class="btn btn-sm btn-outline-warning">
                                <?php echo e(__('dashboard.review_business_accounts')); ?> <span class="badge bg-warning ms-2"><?php echo e($stats['pending_business_accounts']); ?></span>
                            </a>
                            <?php endif; ?>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-services')): ?>
                            <a href="<?php echo e(route('services.index')); ?>" class="btn btn-sm btn-outline-info">
                                <?php echo e(__('dashboard.review_services')); ?> <span class="badge bg-info ms-2"><?php echo e($stats['pending_services']); ?></span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="<?php echo e(asset('assets/img/illustrations/man-with-laptop.png')); ?>" height="175" alt="<?php echo e(__('dashboard.welcome_admin_alt')); ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-business-accounts')): ?>
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-store"></i></span>
                            </div>
                        </div>
                        <p class="mb-1"><?php echo e(__('dashboard.business_accounts')); ?></p>
                        <h4 class="card-title mb-3"><?php echo e($stats['total_business_accounts']); ?></h4>
                        <small class="text-success fw-medium"><?php echo e(__('dashboard.approved_active')); ?></small>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-services')): ?>
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-buildings"></i></span>
                            </div>
                        </div>
                        <p class="mb-1"><?php echo e(__('dashboard.real_estate_services')); ?></p>
                        <h4 class="card-title mb-3"><?php echo e($stats['total_services']); ?></h4>
                        <small class="text-info fw-medium"><?php echo e(__('dashboard.listed_on_platform')); ?></small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
        <div class="row">
             <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-transfer-alt"></i></span>
                            </div>
                        </div>
                        <p class="mb-1"><?php echo e(__('dashboard.service_requests_completed')); ?></p>
                        <h4 class="card-title mb-3"><?php echo e($stats['total_service_requests']); ?></h4>
                        <small class="text-primary fw-medium"><?php echo e(__('dashboard.between_users')); ?></small>
                    </div>
                </div>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reports')): ?>
            <div class="col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-error-circle"></i></span>
                            </div>
                        </div>
                        <p class="mb-1"><?php echo e(__('dashboard.open_reports')); ?></p>
                        <h4 class="card-title mb-3"><?php echo e($stats['pending_reports']); ?></h4>
                        <small class="text-danger fw-medium"><?php echo e(__('dashboard.requires_intervention')); ?></small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/content/dashboard/dashboards-analytics.blade.php ENDPATH**/ ?>