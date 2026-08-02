<?php $__env->startSection('title', __('login.login_title') . ' - ' . __('sidebar.app_name')); ?>

<?php $__env->startSection('page-style'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/scss/pages/page-auth.scss']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    
                    <div class="app-brand justify-content-center mb-6">
                        <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
                            
                            <span class="app-brand-text demo text-heading fw-bold"><?php echo e(__('sidebar.app_name')); ?></span>
                        </a>
                    </div>

                    
                    <div class="text-center mb-6">
                        <h4 class="mb-1"><?php echo e(__('login.admin_dashboard')); ?> 👋</h4>
                        <p class="mb-0 text-muted"><?php echo e(__('login.login_subtitle')); ?></p>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="formAuthentication" class="mb-6" action="<?php echo e(route('login')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-6">
                            <label for="email" class="form-label"><?php echo e(__('login.email')); ?></label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('login.email_placeholder')); ?>" autofocus required />
                        </div>

                        
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password"><?php echo e(__('login.password')); ?></label>
                            <div class="input-group input-group-merge <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
                        </div>
                        
                        
                        <div class="mt-8">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                <?php echo e(__('login.sign_in')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/blankLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/auth/login.blade.php ENDPATH**/ ?>