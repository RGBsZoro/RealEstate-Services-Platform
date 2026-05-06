<?php $__env->startSection('title', __('admins.management_title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-primary"><?php echo e(__('admins.total_admins')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total']); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-user fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-success"><?php echo e(__('admins.last_30_days')); ?></h6>
                        <h4 class="mb-0 fw-black">+<?php echo e($stats['recent']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-user-check fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 62, 29, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <h6 class="mb-1 fw-bold text-danger"><?php echo e(__('admins.role_assignments')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['roles_count']); ?></h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2">
                        <i class="bx bx-shield-quarter fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between pb-3 gap-3">
        <h5 class="card-title mb-0"><?php echo e(__('admins.management_title')); ?></h5>
        
        <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
            <form action="<?php echo e(route('admins.index')); ?>" method="GET" class="d-flex w-100">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('admins.search_placeholder')); ?>" aria-label="Search..." aria-describedby="basic-addon-search31">
                </div>
            </form>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-admins')): ?>
                <a href="<?php echo e(route('admins.create')); ?>" class="btn btn-primary text-nowrap">
                    <i class="bx bx-user-plus me-1"></i> <?php echo e(__('admins.add_new')); ?>

                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 25%"><?php echo e(__('admins.column_admin')); ?></th>
                    <th style="width: 20%"><?php echo e(__('admins.column_roles')); ?></th>
                    <th style="width: 25%"><?php echo e(__('admins.column_permissions')); ?></th>
                    <th style="width: 15%"><?php echo e(__('admins.column_joined')); ?></th>
                    <?php if(auth()->user()->can('edit-admins') || auth()->user()->can('delete-admins')): ?>
                        <th style="width: 10%"><?php echo e(__('admins.column_actions')); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper me-3">
                                <div class="avatar avatar-sm">
                                    <?php if($admin->getFirstMediaUrl('admin_avatars')): ?>
                                        <img src="<?php echo e($admin->getFirstMediaUrl('admin_avatars')); ?>" alt="Avatar" class="rounded-circle">
                                    <?php else: ?>
                                        <span class="avatar-initial rounded-circle bg-label-info">
                                            <?php echo e(Str::upper(Str::substr($admin->name, 0, 2))); ?>

                                        </span>
                                    <?php endif; ?>                                
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading text-truncate"><?php echo e($admin->name); ?></span>
                                <small class="text-muted"><?php echo e($admin->email); ?></small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <?php $__empty_2 = true; $__currentLoopData = $admin->roles->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge bg-label-primary mb-1"><?php echo e($role->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <span class="text-muted small fst-italic"><?php echo e(__('admins.no_role')); ?></span>
                        <?php endif; ?>

                        <?php if($admin->roles->count() > 2): ?>
                            <small class="text-muted cursor-pointer" data-bs-toggle="tooltip" title="<?php echo e($admin->roles->skip(2)->pluck('name')->implode(', ')); ?>">
                                +<?php echo e($admin->roles->count() - 2); ?>

                            </small>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php 
                            $directPerms = $admin->getDirectPermissions()->take(2); 
                        ?>
                        
                        <?php $__empty_2 = true; $__currentLoopData = $directPerms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <span class="badge bg-label-warning rounded-pill mb-1" style="font-size: 0.7rem;">
                                <i class="bx bx-star me-1"></i><?php echo e($perm->name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <small class="text-muted small fst-italic"><?php echo e(__('admins.no_permissions')); ?></small>
                        <?php endif; ?>

                        <?php if($admin->getDirectPermissions()->count() > 2): ?>
                            <small class="text-muted cursor-pointer" data-bs-toggle="tooltip" title="<?php echo e($admin->getDirectPermissions()->skip(2)->pluck('name')->implode(', ')); ?>">
                                +<?php echo e($admin->getDirectPermissions()->count() - 2); ?>

                            </small>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="text-muted small"><?php echo e($admin->created_at->translatedFormat('M d, Y')); ?></span>
                    </td>
                    <?php if(auth()->user()->can('edit-admins') || auth()->user()->can('delete-admins')): ?>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-admins')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('admins.edit', $admin->id)); ?>"><i class="icon-base bx bx-edit-alt me-1"></i> <?php echo e(__('admins.edit')); ?></a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-admins')): ?>
                                        <form action="<?php echo e(route('admins.destroy', $admin->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('admins.confirm_delete')); ?>')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item" title="<?php echo e(__('admins.delete')); ?>">
                                                <i class="icon-base bx bx-trash me-1"></i> <?php echo e(__('admins.delete')); ?>

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
                            <p><?php echo e(request('search') ? __('admins.no_results_matching') : __('admins.no_results')); ?>.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($admins->hasPages() || $admins->total() > 0): ?>
        <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-muted small mb-3 mb-md-0">
                <?php echo e(__('admins.showing', [
                    'first' => $admins->firstItem(),
                    'last' => $admins->lastItem(),
                    'total' => $admins->total()
                ])); ?>

            </div>

            <div class="pagination-wrapper">
                <?php echo e($admins->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/admins/index.blade.php ENDPATH**/ ?>