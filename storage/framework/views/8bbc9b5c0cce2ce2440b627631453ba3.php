<?php $__env->startSection('title', __('categories.edit_title') . ' - ' . $category->getTranslation('name', app()->getLocale())); ?>

<?php $__env->startSection('page-style'); ?>
<style>
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
    .current-icon-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; padding: 5px; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                
                <h5 class="mb-0">
                    <?php echo e($category->parent_id ? __('categories.edit_sub') : __('categories.edit_main')); ?>

                </h5>
                <small class="text-muted float-end">
                    <?php echo e(__('categories.last_updated')); ?> <?php echo e($category->updated_at->diffForHumans()); ?>

                </small>
            </div>
            <div class="card-body pt-5">
                <form action="<?php echo e(route('categories.update', $category->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <?php if($category->parent_id): ?>
                        <input type="hidden" name="return_url" value="<?php echo e(route('categories.sub.index')); ?>">
                        <div class="row mb-6">
                            <label class="col-sm-2 col-form-label" for="parent_id"><?php echo e(__('categories.main_category_select')); ?></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-layer"></i></span>
                                    <select name="parent_id" id="parent_id" class="form-select <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($main->id); ?>" <?php echo e((old('parent_id', $category->parent_id) == $main->id) ? 'selected' : ''); ?>>
                                                <?php echo e($main->getTranslation('name', app()->getLocale())); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="return_url" value="<?php echo e(route('categories.main.index')); ?>">
                    <?php endif; ?>

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en"><?php echo e(__('categories.name_en')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                                <input type="text" name="name[en]" class="form-control <?php $__errorArgs = ['name.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="name_en" value="<?php echo e(old('name.en', $category->getTranslation('name', 'en'))); ?>" required />
                            </div>
                            <?php $__errorArgs = ['name.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_ar"><?php echo e(__('categories.name_ar')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="name[ar]" id="name_ar" 
                                    class="form-control <?php $__errorArgs = ['name.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    value="<?php echo e(old('name.ar', $category->getTranslation('name', 'ar'))); ?>" required />
                                <span class="input-group-text"><i class="bx bx-edit"></i></span>
                            </div>
                            <?php $__errorArgs = ['name.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label"><?php echo e(__('categories.icon_label')); ?></label>
                        <div class="col-sm-10">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <?php if($category->getFirstMediaUrl('Categories')): ?>
                                    <img src="<?php echo e($category->getFirstMediaUrl('Categories')); ?>" alt="current-icon" class="current-icon-preview" id="uploadedAvatar">
                                <?php else: ?>
                                    <div class="current-icon-preview d-flex align-items-center justify-content-center bg-label-secondary">
                                        <i class="bx bx-image-alt fs-2"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="button-wrapper">
                                    <input type="file" name="icon" class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category_icon" accept="image/*" />
                                    <div class="text-muted small mt-2"><?php echo e(__('categories.allowed_types')); ?></div>
                                    <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="isActive"><?php echo e(__('categories.status_label')); ?></label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" <?php echo e(old('isActive', $category->isActive) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="isActive"><?php echo e(__('categories.active_help')); ?></label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> <?php echo e(__('categories.update_category')); ?>

                            </button>
                            
                            <a href="<?php echo e($category->parent_id ? route('categories.sub.index') : route('categories.main.index')); ?>" class="btn btn-outline-secondary btn-lg ms-2">
                                <?php echo e(__('categories.cancel')); ?>

                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/categories/edit.blade.php ENDPATH**/ ?>