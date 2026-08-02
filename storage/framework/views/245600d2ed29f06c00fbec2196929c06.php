<?php $__env->startSection('title', __('activities.page_title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: #dbdee0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold"><?php echo e(__('activities.total_activities')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total_activities']); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-category fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: #dbdee0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold"><?php echo e(__('activities.utilized_activities')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['active_usage']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-check-circle fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: #dbdee0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold"><?php echo e(__('activities.total_assignments')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total_assignments']); ?></h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-list-check fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0"><?php echo e(__('activities.management_header')); ?></h5>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-activities')): ?>
                <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary text-nowrap rounded-pill">
                    <i class="bx bx-plus-circle me-1"></i> <?php echo e(__('activities.add_activity')); ?>

                </a>
            <?php endif; ?>
        </div>
        
        
        <form action="<?php echo e(route('activities.index')); ?>" method="GET" id="activities-filter-form">
            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text text-muted"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-activity-input" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('activities.search_placeholder')); ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th style="width: 35%"><?php echo e(__('activities.column_name')); ?></th>
                    <th style="width: 20%"><?php echo e(__('activities.column_accounts')); ?></th>
                    <th style="width: 15%"><?php echo e(__('activities.column_status')); ?></th>
                    <th style="width: 15%"><?php echo e(__('activities.column_date')); ?></th>
                    <?php if(auth()->user()->can('edit-activities') || auth()->user()->can('delete-activities')): ?>
                        <th style="width: 15%" class="text-center"><?php echo e(__('activities.column_actions')); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if($activity->hasMedia('Activities')): ?>
                                <img src="<?php echo e($activity->getFirstMediaUrl('Activities')); ?>" alt="Icon" class="rounded-circle me-3 border" width="40" height="40" style="object-fit: cover;">
                            <?php else: ?>
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary">
                                        <i class="bx bx-briefcase fs-5"></i>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading"><?php echo e($activity->getTranslation('name', 'en')); ?></span>
                                <small class="text-muted small"><?php echo e($activity->getTranslation('name', 'ar')); ?></small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-info rounded-pill">
                                <i class="bx bx-store-alt me-1"></i>
                                <?php echo e($activity->business_accounts_count); ?> <?php echo e(__('activities.accounts_count')); ?>

                            </span>
                        </div>
                    </td>

                    <td>
                        <?php if($activity->is_active): ?>
                            <span class="badge bg-label-success rounded-pill"><?php echo e(__('activities.status_enabled')); ?></span>
                        <?php else: ?>
                            <span class="badge bg-label-secondary rounded-pill"><?php echo e(__('activities.status_disabled')); ?></span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="text-muted small"><?php echo e($activity->created_at->translatedFormat('M d, Y')); ?></span>
                    </td>
                    <?php if(auth()->user()->can('edit-activities') || auth()->user()->can('delete-activities')): ?>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-activities')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('activities.edit', $activity->id)); ?>">
                                            <i class="bx bx-edit-alt me-1"></i> <?php echo e(__('activities.edit')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-activities')): ?>
                                        <div class="dropdown-divider"></div>
                                        <form action="<?php echo e(route('activities.destroy', $activity->id)); ?>" method="POST" class="delete-activity-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> <?php echo e(__('activities.remove')); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search-alt-2 mb-2" style="font-size: 3rem;"></i>
                            <p class="mb-0"><?php echo e(__('activities.no_results')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($activities->hasPages() || $activities->total() > 0): ?>
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small mb-3 mb-md-0">
            <?php echo e(__('activities.showing')); ?> <strong><?php echo e($activities->firstItem() ?? 0); ?></strong> <?php echo e(__('activities.to')); ?> <strong><?php echo e($activities->lastItem() ?? 0); ?></strong> <?php echo e(__('activities.of')); ?> <strong><?php echo e($activities->total()); ?></strong> <?php echo e(__('activities.results')); ?>

        </div>
        <div class="pagination-wrapper">
            <?php echo e($activities->appends(request()->query())->links('pagination::bootstrap-5')); ?>

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
                const $form = $('#activities-filter-form');
                let searchActivitiesTimeout;

                // 1. البحث الفوري أثناء الكتابة (Debounce 500ms)
                $(document).on('input', '#search-activity-input', function() {
                    clearTimeout(searchActivitiesTimeout);
                    
                    searchActivitiesTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });

                // 2. منع الـ Submit العشوائي عند ضغط Enter داخل حقل البحث
                $form.on('submit', function(e) {
                    if (e.originalEvent && e.originalEvent.submitter === undefined) {
                        e.preventDefault();
                    }
                });

                // 3. تأكيد الحذف
                $(document).on('submit', '.delete-activity-form', function(e) {
                    if(!confirm("<?php echo e(__('activities.delete_confirmation')); ?>")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/activities/index.blade.php ENDPATH**/ ?>