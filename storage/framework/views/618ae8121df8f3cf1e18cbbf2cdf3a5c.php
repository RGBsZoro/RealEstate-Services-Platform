<?php $__env->startSection('title', __('business.requests_title')); ?>

<?php $__env->startSection('content'); ?>



<div class="row g-4 mb-4">
    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-warning"><?php echo e(__('business.pending_req')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['pending']); ?></h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-time-five fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success"><?php echo e(__('business.approved_acc')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['approved']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-check-double fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(133, 146, 163, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-secondary"><?php echo e(__('status.inactive')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['inactive'] ?? 0); ?></h4>
                    </div>
                    <span class="badge bg-secondary rounded-circle p-2">
                        <i class="bx bx-power-off fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 62, 29, 0.08);"> 
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-danger"><?php echo e(__('business.rejected_acc')); ?></h6> 
                        <h4 class="mb-0 fw-black"><?php echo e($stats['rejected']); ?></h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2"> <i class="bx bx-x-circle fs-3"></i> </span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-3"><?php echo e(__('business.management_card')); ?></h5>
        <form action="<?php echo e(route('business-accounts.index')); ?>" method="GET">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('business.search_placeholder')); ?>">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select text-capitalize">
                        <option value=""><?php echo e(__('business.all_statuses')); ?></option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('status.pending')); ?></option>
                        <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>><?php echo e(__('status.approved')); ?></option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>><?php echo e(__('status.inactive')); ?></option>
                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>><?php echo e(__('status.rejected')); ?></option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select name="city_id" class="form-select">
                        <option value=""><?php echo e(__('business.all_cities')); ?></option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($city->id); ?>" <?php echo e(request('city_id') == $city->id ? 'selected' : ''); ?>>
                                <?php echo e($city->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
                        <?php echo e(__('business.filter_btn')); ?>

                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th><?php echo e(__('business.acc_name')); ?></th>
                    <th><?php echo e(__('business.owner')); ?></th>
                    <th><?php echo e(__('business.activity_city')); ?></th>
                    <th><?php echo e(__('business.status')); ?></th>
                    <th><?php echo e(__('business.date_applied')); ?></th>
                    <th class="text-center"><?php echo e(__('business.actions')); ?></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $__empty_1 = true; $__currentLoopData = $business_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-heading"><?php echo e($account->getTranslation('name', 'en')); ?></span>
                            <small class="text-muted"><?php echo e($account->getTranslation('name', 'ar')); ?></small>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-user me-2 text-primary"></i>
                            <span class="small"><?php echo e($account->user->name ?? __('business.unknown')); ?></span>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex flex-column small">
                            <span><i class="bx bx-briefcase me-1 text-secondary"></i> <?php echo e($account->activity->name ?? __('business.na')); ?></span>
                            <span class="text-muted"><i class="bx bx-map me-1"></i> <?php echo e($account->city->name ?? __('business.na')); ?></span>
                        </div>
                    </td>

                    <td>
                        <span class="badge <?php echo e($account->status->badge()); ?> rounded-pill">
                            <?php echo e($account->status->label()); ?>

                        </span>
                    </td>

                    <td>
                        <span class="text-muted small"><?php echo e($account->created_at->format('d M, Y')); ?></span>
                    </td>

                    <td class="text-center">
                        <a href="<?php echo e(route('business-accounts.show', $account->id)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-show me-1"></i> <?php echo e(__('business.view_details')); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search-alt-2 mb-2 fs-1"></i>
                            <p><?php echo e(__('business.no_results')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($business_accounts->hasPages() || $business_accounts->total() > 0): ?>
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            <?php echo e(__('business.showing')); ?> <strong><?php echo e($business_accounts->firstItem() ?? 0); ?></strong> <?php echo e(__('business.to')); ?> <strong><?php echo e($business_accounts->lastItem() ?? 0); ?></strong> <?php echo e(__('business.of')); ?> <strong><?php echo e($business_accounts->total()); ?></strong> <?php echo e(__('business.requests')); ?>

        </div>
        <div class="pagination-wrapper">
            <?php echo e($business_accounts->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/business-accounts/index.blade.php ENDPATH**/ ?>