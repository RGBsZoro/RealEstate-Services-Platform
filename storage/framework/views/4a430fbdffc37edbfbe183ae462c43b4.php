<?php $__env->startSection('title', __('categories.sub_title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(3, 195, 236, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-info"><?php echo e(__('categories.total_sub')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total']); ?></h4>
                    </div>
                    <span class="badge bg-info rounded-circle p-2"><i class="bx bx-subdirectory-right fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success"><?php echo e(__('categories.active_sub')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['active']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-check-double fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(133, 146, 163, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-secondary"><?php echo e(__('categories.inactive_sub')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['inactive']); ?></h4>
                    </div>
                    <span class="badge bg-secondary rounded-circle p-2"><i class="bx bx-hide fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0"><?php echo e(__('categories.sub_title')); ?></h5>
            <a href="<?php echo e(route('categories.sub.create')); ?>" class="btn btn-primary rounded-pill">
                <i class="bx bx-plus me-1"></i> <?php echo e(__('categories.add_sub')); ?>

            </a>
        </div>

        <form action="<?php echo e(route('categories.sub.index')); ?>" method="GET" id="sub-categories-filter-form">
            <div class="row g-3">
                
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-sub-category-input" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('categories.search_placeholder')); ?>" autocomplete="off">
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-3">
                    <select name="parent_id" class="form-select immediate-sub-select">
                        <option value=""><?php echo e(__('categories.all_parents')); ?></option>
                        <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($main->id); ?>" <?php echo e(request('parent_id') == $main->id ? 'selected' : ''); ?>>
                                <?php echo e($main->getTranslation('name', app()->getLocale())); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="col-12 col-sm-6 col-md-3">
                    <select name="status" class="form-select immediate-sub-select">
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
                    <th style="width: 30%"><?php echo e(__('categories.column_sub')); ?></th>
                    <th><?php echo e(__('categories.column_parent')); ?></th>
                    <th><?php echo e(__('categories.column_fields')); ?></th>
                    <th><?php echo e(__('categories.status_label')); ?></th>
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
                                <img src="<?php echo e($category->getFirstMediaUrl('Categories')); ?>" alt="icon" width="38" height="38" class="rounded-circle me-3 border" style="object-fit: cover;">
                            <?php else: ?>
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-subdirectory-right fs-4"></i></span>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-heading"><?php echo e($category->getTranslation('name', 'en')); ?></span>
                                <small class="text-muted small"><?php echo e($category->getTranslation('name', 'ar')); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-primary rounded-pill">
                            <i class="bx bx-layer me-1"></i> <?php echo e($category->parent->getTranslation('name', app()->getLocale()) ?? 'N/A'); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge bg-label-info rounded-pill">
                            <i class="bx bx-list-check me-1"></i> <?php echo e(__('categories.fields_count', ['count' => $category->dynamic_fields_count])); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge <?php echo e($category->isActive ? 'bg-label-success' : 'bg-label-danger'); ?> rounded-pill">
                            <?php echo e($category->isActive ? __('categories.status_active') : __('categories.status_inactive')); ?>

                        </span>
                    </td>
                    <td><span class="text-muted small"><?php echo e($category->created_at->format('M d, Y')); ?></span></td>

                    <?php if(auth()->user()->can('edit-categories') || auth()->user()->can('delete-categories') || auth()->user()->can('view-dynamic-fields')): ?>
                    <td class="text-center">
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded fs-4"></i></button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-dynamic-fields')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('categories.fields.index', $category->id)); ?>"><i class="bx bx-cog me-2 text-info"></i> <?php echo e(__('categories.manage_fields')); ?></a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-categories')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('categories.edit', $category->id)); ?>"><i class="bx bx-edit-alt me-2"></i> <?php echo e(__('categories.edit')); ?></a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-categories')): ?>
                                    <div class="dropdown-divider"></div>
                                    <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" class="delete-sub-category-form">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash me-2"></i> <?php echo e(__('categories.delete')); ?></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bx bx-search-alt-2 display-6 mb-2"></i>
                        <p><?php echo e(__('categories.no_sub_found')); ?></p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($categories->hasPages() || $categories->total() > 0): ?>
    <div class="card-footer border-top d-flex align-items-center justify-content-between py-3">
        <span class="text-muted small">
            <?php echo e(__('categories.showing_count', ['first' => $categories->firstItem() ?? 0, 'last' => $categories->lastItem() ?? 0, 'total' => $categories->total()])); ?>

        </span>
        <div>
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
                const $form = $('#sub-categories-filter-form');
                let searchSubCategoriesTimeout;

                // 1. الفلترة الفورية بمجرد تغيير خيارات الـ Select
                $(document).on('change', '.immediate-sub-select', function() {
                    $form.submit();
                });

                // 2. البحث التلقائي الفوري أثناء الكتابة بخاصية الـ Debounce (500ms)
                $(document).on('input', '#search-sub-category-input', function() {
                    clearTimeout(searchSubCategoriesTimeout);
                    
                    searchSubCategoriesTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });

                // 3. تأكيد الحذف
                $(document).on('submit', '.delete-sub-category-form', function(e) {
                    if(!confirm("<?php echo e(__('categories.confirm_delete')); ?>")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/categories/sub/index.blade.php ENDPATH**/ ?>