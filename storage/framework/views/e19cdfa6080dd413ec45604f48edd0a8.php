<?php $__env->startSection('title', __('activities.edit_title') . ' - ' . $activity->getTranslation('name', app()->getLocale())); ?>

<?php $__env->startSection('page-style'); ?>
<style>
    /* تنسيق الحقول لتدعم الـ RTL في العربي */
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
    
    /* تنسيق معاينة الصورة */
    .current-image-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; padding: 5px; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0"><?php echo e(__('activities.edit_title')); ?></h5>
                
                <small class="text-muted float-end"><?php echo e(__('activities.last_updated')); ?>: <?php echo e($activity->updated_at->diffForHumans()); ?></small>
            </div>
            
            <div class="card-body pt-5">
                <form action="<?php echo e(route('activities.update', $activity->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="name_en"><?php echo e(__('activities.label_name_en')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                <input type="text" name="name[en]" class="form-control <?php $__errorArgs = ['name.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="name_en" value="<?php echo e(old('name.en', $activity->getTranslation('name', 'en'))); ?>" required />
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
                        <label class="col-sm-2 col-form-label" for="name_ar"><?php echo e(__('activities.label_name_ar')); ?></label>
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
                                    value="<?php echo e(old('name.ar', $activity->getTranslation('name', 'ar'))); ?>" required />
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
                        <label class="col-sm-2 col-form-label"><?php echo e(__('activities.label_image')); ?></label>
                        <div class="col-sm-10">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <?php if($activity->hasMedia('Activities')): ?>
                                    <img src="<?php echo e($activity->getFirstMediaUrl('Activities')); ?>" alt="current-image" class="current-image-preview" id="uploadedAvatar">
                                <?php else: ?>
                                    <div class="current-image-preview d-flex align-items-center justify-content-center bg-label-secondary">
                                        <i class="bx bx-image-alt fs-2"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="button-wrapper">
                                    <input type="file" name="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="activity_image" accept="image/*" />
                                    <div class="text-muted small mt-2"><?php echo e(__('activities.image_constraints')); ?></div>
                                    <?php $__errorArgs = ['image'];
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
                        <label class="col-sm-2 col-form-label" for="is_active"><?php echo e(__('activities.label_status')); ?></label>
                        <div class="col-sm-10 d-flex align-items-center">
                            <div class="form-check form-switch mb-0">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="checkbox" name="is_active" id="is_active" value="1" <?php echo e(old('is_active', $activity->is_active) == '1' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active"><?php echo e(__('activities.status_active')); ?></label>
                            </div>
                            <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <hr class="my-6">
                    
                    
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-save me-1"></i> <?php echo e(__('activities.update_button')); ?>

                            </button>
                            <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-outline-secondary btn-lg ms-2">
                                <?php echo e(__('activities.cancel_button')); ?>

                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/activities/edit.blade.php ENDPATH**/ ?>