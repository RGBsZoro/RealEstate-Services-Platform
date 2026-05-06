<?php $__env->startSection('title', __('profile.security_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><?php echo e(__('profile.account')); ?> /</span> <?php echo e(__('profile.security')); ?>

    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header"><?php echo e(__('profile.change_password_header')); ?></h5>
                <div class="card-body">
                    <form action="<?php echo e(route('profile.password.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <!-- كلمة المرور الحالية -->
                            <div class="mb-3 col-md-12 form-password-toggle">
                                <label class="form-label" for="current_password"><?php echo e(__('profile.current_password')); ?></label>
                                <div class="input-group input-group-merge <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <input type="password" name="current_password" id="current_password" 
                                           class="form-control" 
                                           placeholder="<?php echo e(__('profile.current_password_placeholder')); ?>" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <!-- كلمة المرور الجديدة -->
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="new_password"><?php echo e(__('profile.new_password')); ?></label>
                                <div class="input-group input-group-merge <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <input type="password" name="new_password" id="new_password" 
                                           class="form-control" 
                                           placeholder="<?php echo e(__('profile.new_password_placeholder')); ?>" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- تأكيد كلمة المرور الجديدة -->
                            <div class="mb-3 col-md-6 form-password-toggle">
                                <label class="form-label" for="new_password_confirmation"><?php echo e(__('profile.confirm_new_password')); ?></label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                           class="form-control" 
                                           placeholder="<?php echo e(__('profile.confirm_password_placeholder')); ?>" required>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2"><?php echo e(__('general.save_changes')); ?></button>
                            <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('general.cancel')); ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/profile/security.blade.php ENDPATH**/ ?>