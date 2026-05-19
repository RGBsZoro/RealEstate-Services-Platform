<?php $__env->startSection('title', __('roles.management_title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-primary"><?php echo e(__('roles.total_roles')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total_roles']); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-key fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-warning"><?php echo e(__('roles.system_permissions')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total_perms']); ?></h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-lock-alt fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(3, 195, 236, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-info"><?php echo e(__('roles.authorized_admins')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['assigned_admins']); ?></h4>
                    </div>
                    <span class="badge bg-info rounded-circle p-2">
                        <i class="bx bx-user-check fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="card-title mb-0"><?php echo e(__('roles.management_title')); ?></h5>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-roles')): ?>
                <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary text-nowrap rounded-pill">
                    <i class="bx bx-plus-circle me-1"></i> <?php echo e(__('roles.add_new')); ?>

                </a>
            <?php endif; ?>
        </div>
        
        
        <form action="<?php echo e(route('roles.index')); ?>" method="GET" id="roles-filter-form">
            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text text-muted"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" id="search-role-input" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('roles.search_placeholder')); ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light text-uppercase">
                <tr>
                    <th style="width: 25%"><?php echo e(__('roles.role_name')); ?></th>
                    <th style="width: 40%"><?php echo e(__('roles.permissions')); ?></th>
                    <th style="width: 15%"><?php echo e(__('roles.users_count')); ?></th>
                    <th style="width: 10%"><?php echo e(__('roles.created_at')); ?></th>
                    <?php if(auth()->user()->can('edit-roles') || auth()->user()->can('delete-roles')): ?>
                        <th style="width: 10%" class="text-center"><?php echo e(__('roles.actions')); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-shield"></i></span>
                            </div>
                            <span class="fw-bold text-heading"><?php echo e(strtoupper($role->name)); ?></span>
                        </div>
                    </td>

                    <td>
                        <?php $mainPerms = $role->permissions->take(3); ?>
                        <?php $__empty_2 = true; $__currentLoopData = $mainPerms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge bg-label-secondary rounded-pill me-1" style="text-transform: none;">
                                <?php echo e(str_replace('-', ' ', $perm->name)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <small class="text-muted small"><?php echo e(__('roles.no_perms')); ?></small>
                        <?php endif; ?>

                        <?php if($role->permissions->count() > 3): ?>
                            <small class="text-muted cursor-pointer ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($role->permissions->skip(3)->pluck('name')->implode(', ')); ?>">
                                +<?php echo e($role->permissions->count() - 3); ?> <?php echo e(__('roles.more')); ?>

                            </small>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-list d-flex align-items-center">
                                <i class="bx bx-group me-2 text-muted"></i>
                                <span class="badge bg-label-info rounded-pill"><?php echo e($role->users_count); ?> <?php echo e(__('roles.users')); ?></span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted small"><?php echo e($role->created_at->translatedFormat('M d, Y')); ?></span>
                    </td>
                    <?php if(auth()->user()->can('edit-roles') || auth()->user()->can('delete-roles')): ?>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="icon-base bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-roles')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('roles.edit', $role->id)); ?>">
                                            <i class="icon-base bx bx-edit-alt me-1"></i> <?php echo e(__('roles.edit')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-roles')): ?>
                                        <div class="dropdown-divider"></div>
                                        <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" class="delete-role-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="icon-base bx bx-trash me-1"></i> <?php echo e(__('roles.delete')); ?>

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
                            <i class="bx bx-search mb-2" style="font-size: 3rem;"></i>
                            <p class="mb-0"><?php echo e(__('roles.no_results')); ?> <?php echo e(request('search') ? __('roles.matching_search') : __('roles.in_database')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($roles->hasPages() || $roles->total() > 0): ?>
        <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
            <div class="text-muted small mb-3 mb-md-0">
                <?php echo e(__('roles.showing')); ?> <strong><?php echo e($roles->firstItem() ?? 0); ?></strong> <?php echo e(__('roles.to')); ?> <strong><?php echo e($roles->lastItem() ?? 0); ?></strong> <?php echo e(__('roles.of')); ?> <strong><?php echo e($roles->total()); ?></strong> <?php echo e(__('roles.results')); ?>

            </div>

            <div class="pagination-wrapper">
                <?php echo e($roles->appends(request()->query())->links('pagination::bootstrap-5')); ?>

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
                const $form = $('#roles-filter-form');
                let searchRolesTimeout;

                // 1. البحث التلقائي الفوري الموزون (Debounce 500ms)
                $(document).on('input', '#search-role-input', function() {
                    clearTimeout(searchRolesTimeout);
                    
                    searchRolesTimeout = setTimeout(function() {
                        $form.submit();
                    }, 500);
                });

                // 2. منع الـ Submit التلقائي غير المقصود عند ضغط مفتاح Enter داخل حقل البحث
                $form.on('submit', function(e) {
                    if (e.originalEvent && e.originalEvent.submitter === undefined) {
                        e.preventDefault();
                    }
                });

                // 3. تأكيد عملية الحذف
                $(document).on('submit', '.delete-role-form', function(e) {
                    if(!confirm("<?php echo e(__('roles.delete_confirm')); ?>")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/roles/index.blade.php ENDPATH**/ ?>