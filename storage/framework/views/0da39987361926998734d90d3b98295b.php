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


<div class="card">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 gap-3">
        <h5 class="card-title mb-0"><?php echo e(__('roles.management_title')); ?></h5>
        
        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
            <form action="<?php echo e(route('roles.index')); ?>" method="GET" class="d-flex w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('roles.search_placeholder')); ?>" aria-label="Search...">
                </div>
            </form>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-roles')): ?>
                <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary text-nowrap">
                    <i class="bx bx-plus-circle me-1"></i> <?php echo e(__('roles.add_new')); ?>

                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 20%"><?php echo e(__('roles.role_name')); ?></th>
                    <th style="width: 40%"><?php echo e(__('roles.permissions')); ?></th>
                    <th style="width: 15%"><?php echo e(__('roles.users_count')); ?></th>
                    <th style="width: 15%"><?php echo e(__('roles.created_at')); ?></th>
                    <?php if(auth()->user()->can('edit-roles') || auth()->user()->can('delete-roles')): ?>
                        <th style="width: 10%"><?php echo e(__('roles.actions')); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xs me-2">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-shield"></i></span>
                            </div>
                            <span class="fw-medium text-heading"><?php echo e(strtoupper($role->name)); ?></span>
                        </div>
                    </td>

                    <td>
                        <?php $mainPerms = $role->permissions->take(3); ?>
                        <?php $__empty_2 = true; $__currentLoopData = $mainPerms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge bg-label-secondary rounded-pill me-1" style="text-transform: none;">
                                <?php echo e(str_replace('-', ' ', $perm->name)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <small class="text-muted"><?php echo e(__('roles.no_perms')); ?></small>
                        <?php endif; ?>

                        <?php if($role->permissions->count() > 3): ?>
                            <small class="text-muted cursor-pointer" data-bs-toggle="tooltip" title="<?php echo e($role->permissions->skip(3)->pluck('name')->implode(', ')); ?>">
                                +<?php echo e($role->permissions->count() - 3); ?> <?php echo e(__('roles.more')); ?>

                            </small>
                        <?php endif; ?>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-list d-flex align-items-center">
                                <i class="bx bx-group me-2 text-muted"></i>
                                <span class="badge bg-label-info"><?php echo e($role->users_count); ?> <?php echo e(__('roles.users')); ?></span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="text-muted"><?php echo e($role->created_at->toFormattedDateString()); ?></span>
                    </td>
                    <?php if(auth()->user()->can('edit-roles') || auth()->user()->can('delete-roles')): ?>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-roles')): ?> 
                                    <a class="dropdown-item" href="<?php echo e(route('roles.edit', $role->id)); ?>"><i class="icon-base bx bx-edit-alt me-1"></i> <?php echo e(__('roles.edit')); ?></a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-roles')): ?> 
                                    <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('roles.delete_confirm')); ?>')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item" title="Delete">
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
                            <i class="bx bx-search mb-2" style="font-size: 2rem;"></i>
                            <p><?php echo e(__('roles.no_results')); ?> <?php echo e(request('search') ? __('roles.matching_search') : __('roles.in_database')); ?>.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($roles->hasPages() || $roles->total() > 0): ?>
        <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-muted small mb-3 mb-md-0">
                <?php echo e(__('roles.showing')); ?> <?php echo e($roles->firstItem()); ?> <?php echo e(__('roles.to')); ?> <?php echo e($roles->lastItem()); ?> <?php echo e(__('roles.of')); ?> <?php echo e($roles->total()); ?> <?php echo e(__('roles.results')); ?>

            </div>

            <div class="pagination-wrapper">
                <?php echo e($roles->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/roles/index.blade.php ENDPATH**/ ?>