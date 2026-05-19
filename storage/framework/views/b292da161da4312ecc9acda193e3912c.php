<?php $__env->startSection('title', __('services.title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between text-nowrap">
                    <div>
                        <h6 class="mb-1 fw-bold text-warning"><?php echo e(__('services.pending_requests')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['pending']); ?></h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2"><i class="bx bx-time-five fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success"><?php echo e(__('services.approved_services')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['approved']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-check-double fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(133, 146, 163, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-secondary"><?php echo e(__('services.inactive_services')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['inactive'] ?? 0); ?></h4>
                    </div>
                    <span class="badge bg-secondary rounded-circle p-2"><i class="bx bx-power-off fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary"><?php echo e(__('services.total_services')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e(array_sum($stats)); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2"><i class="bx bx-list-ul fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card rounded-4 overflow-hidden shadow-sm">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-3"><?php echo e(__('services.management_card')); ?></h5>
        
        
        <form action="<?php echo e(route('services.index')); ?>" method="GET" id="services-filter-form">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-service-input" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('services.search_placeholder')); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <select name="status" class="form-select text-capitalize immediate-select">
                        <option value=""><?php echo e(__('services.all_statuses')); ?></option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('status.pending')); ?></option>
                        <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>><?php echo e(__('status.approved')); ?></option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>><?php echo e(__('status.inactive')); ?></option>
                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>><?php echo e(__('status.rejected')); ?></option>
                    </select>
                </div>
                <div class="col-6 col-md-4">
                    <select name="type" class="form-select immediate-select">
                        <option value=""><?php echo e(__('services.all_types')); ?></option>
                        <option value="sale" <?php echo e(request('type') == 'sale' ? 'selected' : ''); ?>><?php echo e(__('services.sale')); ?></option>
                        <option value="rent" <?php echo e(request('type') == 'rent' ? 'selected' : ''); ?>><?php echo e(__('services.rent')); ?></option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase small fw-bold">
                <tr>
                    <th><?php echo e(__('services.th_title')); ?></th>
                    <th><?php echo e(__('services.th_business')); ?></th>
                    <th><?php echo e(__('services.th_category')); ?></th>
                    <th><?php echo e(__('services.th_type_price')); ?></th>
                    <th><?php echo e(__('services.th_status')); ?></th>
                    <th><?php echo e(__('services.th_date')); ?></th>
                    <th class="text-center"><?php echo e(__('services.th_actions')); ?></th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-heading"><?php echo e(Str::limit($service->title, 25)); ?></span>
                            <small class="text-muted"><?php echo e(__('services.qty')); ?>: <?php echo e($service->quantity); ?></small>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-store me-2 text-primary"></i>
                            <span class="small"><?php echo e($service->businessAccount->getTranslation('name', app()->getLocale()) ?? 'Unknown'); ?></span>
                        </div>
                    </td>

                    <td>
                        <span class="badge bg-label-secondary rounded-pill small">
                            <?php echo e($service->category->getTranslation('name', app()->getLocale()) ?? 'N/A'); ?>

                        </span>
                    </td>

                    <td>
                        <div class="d-flex flex-column">
                            <span class="badge bg-label-<?php echo e($service->type == 'sale' ? 'success' : 'info'); ?> mb-1 rounded-pill">
                                <?php echo e(__('services.' . $service->type)); ?>

                            </span>
                            <small class="fw-bold text-dark">$<?php echo e(number_format($service->price_usd, 2)); ?></small>
                        </div>
                    </td>

                    <td>
                        <span class="badge <?php echo e($service->status->badge()); ?> rounded-pill">
                            <?php echo e($service->status->label()); ?>

                        </span>
                    </td>

                    <td>
                        <span class="text-muted small"><?php echo e($service->created_at->format('d M, Y')); ?></span>
                    </td>

                    <td class="text-center">
                        <a href="<?php echo e(route('services.show', $service->id)); ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bx bx-show me-1"></i> <?php echo e(__('services.view_details')); ?>

                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search-alt-2 mb-2 fs-1"></i>
                            <p><?php echo e(__('services.no_requests')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($services->hasPages() || $services->total() > 0): ?>
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            <?php echo e(__('categories.showing_count', [
                'first' => $services->firstItem() ?? 0,
                'last' => $services->lastItem() ?? 0,
                'total' => $services->total()
            ])); ?>

        </div>
        <div class="pagination-wrapper">
            <?php echo e($services->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
    window.onload = function() {
        if (window.jQuery) {
            $(function() {
                const $form = $('#services-filter-form');
                let searchFilterTimeout;

                // 1. الفلترة الفورية بمجرد تغيير القوائم المنسدلة (الحالة / نوع الخدمة)
                $(document).on('change', '.immediate-select', function() {
                    $form.submit();
                });

                // 2. الفلترة الفورية أثناء الكتابة في حقل البحث بعد التوقف بـ 500 ملي ثانية
                $(document).on('input', '#search-service-input', function() {
                    clearTimeout(searchFilterTimeout);
                    
                    searchFilterTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });
            });
        }
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/services/index.blade.php ENDPATH**/ ?>