<?php $__env->startSection('title', __('categories.add_title')); ?>

<?php $__env->startSection('page-style'); ?>
<style>
    /* تحسين مظهر الحقول التي تدعم اتجاه اليمين لليسار داخل مجموعات الإدخال */
    .input-group-merge[dir="rtl"] .form-control { 
        border-left: 0; 
        border-top-left-radius: 0; 
        border-bottom-left-radius: 0; 
        padding-right: 15px; 
    }
    .input-group-merge[dir="rtl"] .input-group-text { 
        border-right: 0; 
        border-top-right-radius: 0; 
        border-bottom-right-radius: 0; 
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0"><?php echo e(__('categories.add_title')); ?></h5>
            </div>
            <div class="card-body pt-5">
                <form action="<?php echo e(route('categories.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <input type="hidden" name="return_url" value="<?php echo e(route('categories.main.index')); ?>">

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en"><?php echo e(__('categories.name_en')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-category"></i></span>
                                <input type="text" name="name[en]" class="form-control <?php $__errorArgs = ['name.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="name_en" placeholder="<?php echo e(__('categories.placeholder_en')); ?>" value="<?php echo e(old('name.en')); ?>" required />
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
                                    placeholder="<?php echo e(__('categories.placeholder_ar')); ?>" value="<?php echo e(old('name.ar')); ?>" required />
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
                        <label class="col-sm-2 col-form-label" for="category_icon"><?php echo e(__('categories.icon_label')); ?></label>
                        <div class="col-sm-10">
                            <input type="file" name="icon" class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category_icon" accept="image/*" />
                            <small class="text-muted"><?php echo e(__('categories.icon_help')); ?></small>
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

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="isActive"><?php echo e(__('categories.status_label')); ?></label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" <?php echo e(old('isActive') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="isActive"><?php echo e(__('categories.active_help')); ?></label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check-circle me-1"></i> <?php echo e(__('categories.save_category')); ?>

                            </button>
                            <a href="<?php echo e(route('categories.main.index')); ?>" class="btn btn-outline-secondary btn-lg ms-2">
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
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/categories/main/create.blade.php ENDPATH**/ ?>