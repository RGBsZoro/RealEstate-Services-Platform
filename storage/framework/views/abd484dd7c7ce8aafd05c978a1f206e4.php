<?php $__env->startSection('title', __('fields.manage_fields_title', ['category' => $category->getTranslation('name', 'en')])); ?>

<?php $__env->startSection('content'); ?>
<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                <?php echo e(__('fields.manage_fields_title', ['category' => ''])); ?> 
                <span class="text-primary"><?php echo e($category->getTranslation('name', app()->getLocale())); ?></span>
            </h5>
            <div class="d-flex">  
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-dynamic-fields')): ?>
                    <a href="<?php echo e(route('categories.fields.create', $category->id)); ?>" class="btn btn-primary rounded-pill">
                        <i class="bx bx-plus-circle me-1"></i> <?php echo e(__('fields.add_new_field')); ?>

                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 35%"><?php echo e(__('fields.th_label')); ?></th>
                    <th style="width: 20%"><?php echo e(__('fields.th_type')); ?></th>
                    <th style="width: 15%"><?php echo e(__('fields.th_required')); ?></th>
                    <th style="width: 20%"><?php echo e(__('fields.th_options')); ?></th>
                    <?php if(auth()->user()->can('edit-dynamic-fields') || auth()->user()->can('delete-dynamic-fields')): ?>
                        <th style="width: 10%" class="text-center"><?php echo e(__('categories.th_actions')); ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php $__empty_1 = true; $__currentLoopData = $dynamicFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dynamicField): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="bx bx-list-check"></i>
                                </span>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-heading"><?php echo e($dynamicField->getTranslation('label', 'en')); ?></span>
                                <small class="text-muted small"><?php echo e($dynamicField->getTranslation('label', 'ar')); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-primary text-capitalize"><?php echo e($dynamicField->type); ?></span>
                    </td>
                    <td>
                        <?php if($dynamicField->is_required): ?>
                            <span class="badge bg-label-danger"><?php echo e(__('fields.required')); ?></span>
                        <?php else: ?>
                            <span class="badge bg-label-secondary"><?php echo e(__('fields.optional')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($dynamicField->options): ?>
                            <div class="d-flex flex-wrap gap-1">
                                <?php $__currentLoopData = $dynamicField->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-label-info badge-sm">
                                        <?php echo e(is_array($option) ? ($option[app()->getLocale()] ?? '') : $option); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <span class="text-muted small italic"><?php echo e(__('fields.no_options')); ?></span>
                        <?php endif; ?>
                    </td>
                    <?php if(auth()->user()->can('edit-dynamic-fields') || auth()->user()->can('delete-dynamic-fields')): ?>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-dynamic-fields')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('categories.fields.edit' , [$dynamicField->id, $category->id])); ?>">
                                            <i class="bx bx-edit-alt me-1"></i> <?php echo e(__('categories.edit')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-dynamic-fields')): ?>
                                        <div class="dropdown-divider"></div>
                                        <form action="<?php echo e(route('categories.fields.destroy', [$dynamicField->id, $category->id])); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('categories.confirm_delete')); ?>')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-1"></i> <?php echo e(__('fields.remove')); ?>

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
                            <i class="bx bx-customize mb-2" style="font-size: 2rem;"></i>
                            <p><?php echo e(__('fields.no_fields_found')); ?></p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/categories/fields/index.blade.php ENDPATH**/ ?>