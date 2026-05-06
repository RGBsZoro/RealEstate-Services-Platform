<?php $__env->startSection('title', __('admins.edit_title')); ?>

<?php $__env->startSection('page-style'); ?>
<style>
    .permissions-container {
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #d9dee3;
        border-radius: 0.5rem;
        padding: 15px;
        background-color: #f8f9fa;
    }
    .form-check-input:checked {
        background-color: #696cff;
        border-color: #696cff;
    }
    .role-item {
        transition: all 0.3s ease;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid transparent;
    }
    .role-item:has(.form-check-input:checked) {
        background-color: rgba(105, 108, 255, 0.08);
        border-color: rgba(105, 108, 255, 0.2);
    }
    .invalid-feedback {
        display: block;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><?php echo e(__('admins.edit_title')); ?>: <span class="text-primary"><?php echo e($admin->name); ?></span></h5>
                <small class="text-muted float-end"><?php echo e(__('admins.edit_subtitle')); ?></small>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admins.update', $admin->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="full-name"><?php echo e(__('admins.full_name')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="full-name" value="<?php echo e(old('name', $admin->name)); ?>" />
                            </div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="email"><?php echo e(__('admins.email_address')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $admin->email)); ?>" />
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <hr class="my-6">

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label"><?php echo e(__('admins.assign_roles')); ?></label>
                        <div class="col-sm-10">
                            <div class="row">
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="role-item">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="roles[]" 
                                                    value="<?php echo e($role->name); ?>" 
                                                    id="role_<?php echo e($role->id); ?>" 
                                                    <?php echo e((in_array($role->name, old('roles', $adminRoles))) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-bold" for="role_<?php echo e($role->id); ?>">
                                                    <i class="bx bx-shield-quarter me-1"></i> <?php echo e($role->name); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    
                    

                    <hr class="my-6">

                    
                    <div class="row mb-6 form-password-toggle">
                        <label class="col-sm-2 col-form-label" for="password"><?php echo e(__('admins.new_password')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="············" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <div class="form-text text-muted"><?php echo e(__('admins.password_help')); ?></div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-6 form-password-toggle">
                        <label class="col-sm-2 col-form-label" for="password_confirmation"><?php echo e(__('admins.confirm_password')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-check-shield"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="············" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end mt-8">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-check me-1"></i> <?php echo e(__('admins.update_button')); ?>

                            </button>
                            <a href="<?php echo e(route('admins.index')); ?>" class="btn btn-outline-secondary btn-lg ms-2">
                                <?php echo e(__('admins.cancel')); ?>

                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // نبحث عن كل حاويات كلمة المرور في الصفحة
    const passwordToggles = document.querySelectorAll('.form-password-toggle');

    passwordToggles.forEach(container => {
      const input = container.querySelector('input');
      const toggleBtn = container.querySelector('.cursor-pointer');
      const icon = toggleBtn.querySelector('i');

      toggleBtn.addEventListener('click', () => {
        if (input.type === 'text') {
          icon.classList.replace('bx-hide', 'bx-show');
        } else {
          icon.classList.replace('bx-show', 'bx-hide');
        }
      });
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/admins/edit.blade.php ENDPATH**/ ?>