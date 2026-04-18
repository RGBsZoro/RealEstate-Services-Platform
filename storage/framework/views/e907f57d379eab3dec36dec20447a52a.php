<?php $__env->startSection('title', __('fields.edit_field', ['label' => $dynamicField->getTranslation('label', 'en')])); ?>

<?php $__env->startSection('page-style'); ?>
<style>
    .input-group-merge[dir="rtl"] .form-control { border-left: 0; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 15px; }
    .input-group-merge[dir="rtl"] .input-group-text { border-right: 0; border-top-right-radius: 0; border-bottom-right-radius: 0; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xxl">
        <div class="card mb-6 rounded-4 shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between border-bottom">
                <h5 class="mb-0"><?php echo e(__('fields.edit_field', ['label' => ''])); ?> <span class="text-primary"><?php echo e($dynamicField->getTranslation('label', app()->getLocale())); ?></span></h5>
            </div>
            <div class="card-body pt-5">
                <form action="<?php echo e(route('categories.fields.update', [$dynamicField->id, $category->id])); ?>" method="POST" id="editFieldForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label"><?php echo e(__('fields.field_label_en')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                                <input type="text" name="label[en]" class="form-control <?php $__errorArgs = ['label.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    value="<?php echo e(old('label.en', $dynamicField->getTranslation('label', 'en'))); ?>" required />
                            </div>
                            <?php $__errorArgs = ['label.en'];
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
                        <label class="col-sm-2 col-form-label"><?php echo e(__('fields.field_label_ar')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" dir="rtl">
                                <input type="text" name="label[ar]" class="form-control <?php $__errorArgs = ['label.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    value="<?php echo e(old('label.ar', $dynamicField->getTranslation('label', 'ar'))); ?>" required />
                                <span class="input-group-text"><i class="bx bx-tag"></i></span>
                            </div>
                            <?php $__errorArgs = ['label.ar'];
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
                        <label class="col-sm-2 col-form-label"><?php echo e(__('fields.input_type')); ?></label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-category"></i></span>
                                <select name="type" id="typeSelect" class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__currentLoopData = $fieldTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php echo e(old('type', $dynamicField->type) == $value ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row mb-6 <?php echo e(old('type', $dynamicField->type) !== 'select' ? 'd-none' : ''); ?>" id="optionsWrapper">
                        <label class="col-sm-2 col-form-label"><?php echo e(__('fields.selection_options')); ?></label>
                        <div class="col-sm-10">
                            <textarea name="options_input" id="options_input" class="form-control" rows="2" 
                                placeholder="<?php echo e(__('fields.options_help')); ?>"><?php echo e(old('options_input', $optionsString)); ?></textarea>
                            <small class="text-muted"><?php echo e(__('fields.options_help')); ?></small>
                        </div>
                    </div>

                    
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label"><?php echo e(__('fields.is_required')); ?></label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_required" value="1" 
                                    id="reqCheck" <?php echo e(old('is_required', $dynamicField->is_required) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="reqCheck"><?php echo e(__('fields.mark_as_mandatory')); ?></label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6">
                    <div class="row justify-content-end">
                        <div class="col-sm-10 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bx bx-refresh me-1"></i> <?php echo e(__('categories.update_category')); ?>

                            </button>
                            <a href="<?php echo e(route('categories.fields.index', $category->id)); ?>" class="btn btn-outline-secondary btn-lg ms-2">
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

<?php $__env->startSection('page-script'); ?>
<script>
    const typeSelect = document.getElementById('typeSelect');
    const optionsWrapper = document.getElementById('optionsWrapper');

    typeSelect.addEventListener('change', function() {
        this.value === 'select' ? optionsWrapper.classList.remove('d-none') : optionsWrapper.classList.add('d-none');
    });

    document.getElementById('editFieldForm').addEventListener('submit', function(e) {
        const type = typeSelect.value;
        const input = document.getElementById('options_input').value;
        
        // تنظيف أي Inputs مخفية قديمة قبل الإرسال الجديد
        this.querySelectorAll('input[name="options[]"]').forEach(el => el.remove());

        if (type === 'select' && input.trim() !== '') {
            const options = input.split(',').map(i => i.trim()).filter(i => i !== "");
            
            options.forEach(opt => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'options[]';
                hidden.value = opt;
                this.appendChild(hidden);
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/categories/fields/edit.blade.php ENDPATH**/ ?>