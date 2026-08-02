<?php $__env->startSection('title', __('profile.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><?php echo e(__('profile.account')); ?> /</span> <?php echo e(__('profile.view')); ?>

    </h4>

    <div class="row">
        <div class="col-md-12">
            <!-- التبويبات (Tabs) -->
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> <?php echo e(__('profile.tab_profile')); ?></a>
                </li>
            </ul>

            <div class="card mb-4">
                <h5 class="card-header"><?php echo e(__('profile.profile_details')); ?></h5>
                
                <!-- قسم تحديث الصورة -->
                <div class="card-body">
                    <form action="<?php echo e(route('profile.avatar.update')); ?>" method="POST" enctype="multipart/form-data" id="avatarForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="<?php echo e(auth('web')->user()->getFirstMediaUrl('admin_avatars') ?: 'https://ui-avatars.com/api/?name='.urlencode(auth('web')->user()->name).'&color=696cff&background=f8f9fa'); ?>" 
                                alt="user-avatar" 
                                class="d-block rounded" 
                                height="100" 
                                width="100" 
                                id="uploadedAvatar" />
                            
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block"><?php echo e(__('profile.upload_new_photo')); ?></span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="avatar" class="account-file-input" hidden accept="image/png, image/jpeg" onchange="previewImage(this)" />
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4" onclick="resetImage()">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block"><?php echo e(__('profile.reset')); ?></span>
                                </button>
                                <p class="text-muted mb-0 small"><?php echo e(__('profile.upload_requirements')); ?></p>
                            </div>
                        </div>
                        <div class="mt-3" id="saveAvatarBtn" style="display: none;">
                            <button type="submit" class="btn btn-success btn-sm"><i class="bx bx-check me-1"></i><?php echo e(__('profile.save_image')); ?></button>
                        </div>
                    </form>
                </div>
                <hr class="my-0">

                <div class="card-body">
                    <div class="row mt-2">
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted small uppercase"><?php echo e(__('profile.full_name')); ?></label>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-user me-2 text-primary"></i>
                                <div class="fw-bold fs-5 text-dark"><?php echo e(auth('web')->user()->name); ?></div>
                            </div>
                        </div>

                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted small uppercase"><?php echo e(__('profile.email')); ?></label>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-envelope me-2 text-primary"></i>
                                <div class="fw-bold fs-5 text-dark"><?php echo e(auth('web')->user()->email); ?></div>
                            </div>
                        </div>

                        
                        <div class="col-md-12 mb-4">
                            <label class="form-label text-muted small uppercase"><?php echo e(__('profile.user_roles')); ?></label>
                            <div class="d-flex flex-wrap gap-2 pt-1">
                                <?php $__empty_1 = true; $__currentLoopData = auth('web')->user()->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <span class="badge bg-label-primary fs-6 px-3 py-2">
                                        <i class="bx bx-shield-alt-2 me-1"></i> <?php echo e($role); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <span class="badge bg-label-secondary"><?php echo e(__('general.no_roles')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mt-4 border-top pt-4">
                        <p class="mb-3 mb-sm-0 text-muted small">
                            <i class="bx bx-info-circle me-1 text-info"></i> <?php echo e(__('profile.security_notice')); ?>

                        </p>
                        
                        <a href="<?php echo e(route('profile.security')); ?>" class="btn btn-outline-danger shadow-sm">
                            <i class="bx bx-lock-open-alt me-1"></i> 
                            <span class="fw-bold"><?php echo e(__('profile.change_password_btn')); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('uploadedAvatar').src = e.target.result;
                document.getElementById('saveAvatarBtn').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage() {
        document.getElementById('upload').value = "";
        document.getElementById('uploadedAvatar').src = "<?php echo e(auth('web')->user()->getFirstMediaUrl('admin_avatars') ?: 'https://ui-avatars.com/api/?name='.urlencode(auth('web')->user()->name).'&color=696cff&background=f8f9fa'); ?>";
        document.getElementById('saveAvatarBtn').style.display = 'none';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/profile/index.blade.php ENDPATH**/ ?>