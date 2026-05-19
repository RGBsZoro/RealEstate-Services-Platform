<?php $__env->startSection('title', __('categories.main_title')); ?>

<?php $__env->startSection('content'); ?>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary"><?php echo e(__('categories.total_main')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total']); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2"><i class="bx bx-grid-alt fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success"><?php echo e(__('categories.active_main')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['active']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-check-circle fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 62, 29, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-danger"><?php echo e(__('categories.inactive_main')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['inactive']); ?></h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2"><i class="bx bx-x-circle fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0"><?php echo e(__('categories.management_card')); ?></h5>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-categories')): ?>
                <a href="<?php echo e(route('categories.main.create')); ?>" class="btn btn-primary rounded-pill">
                    <i class="bx bx-plus me-1"></i> <?php echo e(__('categories.add_category')); ?>

                </a>
            <?php endif; ?>
        </div>
        
        <form action="<?php echo e(route('categories.main.index')); ?>" method="GET" id="categories-filter-form">
            <div class="row g-3">
                
                <div class="col-12 col-md-8">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text text-muted"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-category-input" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('categories.search_placeholder')); ?>" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <select name="status" class="form-select immediate-category-select">
                        <option value=""><?php echo e(__('categories.all_statuses')); ?></option>
                        <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>><?php echo e(__('categories.active_only')); ?></option>
                        <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>><?php echo e(__('categories.inactive_only')); ?></option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase small fw-bold">
                <tr>
                    <th style="width: 30%"><?php echo e(__('categories.th_name')); ?></th>
                    <th><?php echo e(__('categories.th_sub_count')); ?></th>
                    <th><?php echo e(__('categories.th_fields_count')); ?></th>
                    <th><?php echo e(__('categories.th_status')); ?></th>
                    <th><?php echo e(__('categories.th_date')); ?></th>
                    <?php if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields')): ?>
                        <th class="text-center"><?php echo e(__('categories.th_actions')); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if($category->getFirstMediaUrl('Categories')): ?>
                                <img src="<?php echo e($category->getFirstMediaUrl('Categories')); ?>" alt="icon" class="rounded-circle me-3 border" width="40" height="40" style="object-fit: cover;">
                            <?php else: ?>
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary">
                                        <i class="bx bx-category fs-5"></i>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading"><?php echo e($category->getTranslation('name', 'en')); ?></span>
                                <small class="text-muted small"><?php echo e($category->getTranslation('name', 'ar')); ?></small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="badge bg-label-secondary rounded-pill">
                            <i class="bx bx-git-repo-forked me-1"></i> <?php echo e($category->children_count); ?> <?php echo e(__('categories.sub_unit')); ?>

                        </span>
                    </td>

                    <td>
                        <span class="badge bg-label-info rounded-pill">
                            <i class="bx bx-list-check me-1"></i> <?php echo e($category->dynamic_fields_count); ?> <?php echo e(__('categories.fields_unit')); ?>

                        </span>
                    </td>

                    <td>
                        <?php if($category->isActive): ?>
                            <span class="badge bg-label-success rounded-pill"><?php echo e(__('categories.status_active')); ?></span>
                        <?php else: ?>
                            <span class="badge bg-label-danger rounded-pill"><?php echo e(__('categories.status_inactive')); ?></span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="text-muted small"><?php echo e($category->created_at->format('M d, Y')); ?></span>
                    </td>

                    <?php if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields')): ?>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-dynamic-fields')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('categories.fields.index', $category->id)); ?>">
                                            <i class="bx bx-cog me-2 text-info small"></i> <?php echo e(__('categories.manage_fields')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-categories')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('categories.edit', $category->id)); ?>">
                                            <i class="bx bx-edit-alt me-2 small"></i> <?php echo e(__('categories.edit')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-categories')): ?>
                                    <div class="dropdown-divider"></div>
                                        <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" class="delete-category-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2 small"></i> <?php echo e(__('categories.delete')); ?>

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
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bx bx-search-alt-2 mb-2 display-6"></i>
                            <p><?php echo e(__('categories.no_data')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($categories->total() > 0): ?>
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small mb-3 mb-md-0">
            <?php echo e(__('categories.showing')); ?> <strong><?php echo e($categories->firstItem() ?? 0); ?></strong> 
            <?php echo e(__('categories.to')); ?> <strong><?php echo e($categories->lastItem() ?? 0); ?></strong> 
            <?php echo e(__('categories.of')); ?> <strong><?php echo e($categories->total()); ?></strong> <?php echo e(__('categories.entries')); ?>

        </div>
        <div class="pagination-wrapper">
            <?php echo e($categories->appends(request()->query())->links('pagination::bootstrap-5')); ?>

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
                const $form = $('#categories-filter-form');
                let searchCategoriesTimeout;

                // 1. الفلترة الفورية بمجرد تغيير خيار قائمة الحالة
                $(document).on('change', '.immediate-category-select', function() {
                    $form.submit();
                });

                // 2. البحث التلقائي الفوري أثناء الكتابة بخاصية الـ Debounce (500ms) لمنع إرهاق الخادم
                $(document).on('input', '#search-category-input', function() {
                    clearTimeout(searchCategoriesTimeout);
                    
                    searchCategoriesTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });

                // 3. تأكيد الحذف
                $(document).on('submit', '.delete-category-form', function(e) {
                    if(!confirm("<?php echo e(__('categories.delete_confirm')); ?>")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/categories/main/index.blade.php ENDPATH**/ ?>