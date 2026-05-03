

<?php $__env->startSection('title', isset($slider) ? __('sliders.edit') : __('sliders.add_new')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xl">
    <div class="card mb-4 rounded-4 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center border-bottom">
        <h5 class="mb-0"><?php echo e(isset($slider) ? __('sliders.edit') : __('sliders.add_new')); ?></h5>
        <a href="<?php echo e(route('sliders.index')); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('sliders.back')); ?></a>
      </div>
      <div class="card-body pt-4">
        <form action="<?php echo e(isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php if(isset($slider)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

          <div class="row">
            
            <div class="col-md-12 mb-4">
              <label class="form-label fw-bold"><?php echo e(__('sliders.upload_image')); ?></label>
              <input type="file" name="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
              <?php if(isset($slider) && $slider->hasMedia('slider_images')): ?>
              <div class="mt-2 text-muted small"><?php echo e(__('sliders.current_image')); ?>:</div>
              <img src="<?php echo e($slider->getFirstMediaUrl('slider_images')); ?>" class="rounded-3 mt-1" style="height: 100px;">
              <?php endif; ?>
              <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-md-6 mb-3">
              <label class="form-label"><?php echo e(__('sliders.title_ar') ?? 'العنوان (عربي)'); ?></label>
              <input type="text" name="title[ar]" class="form-control <?php $__errorArgs = ['title.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title.ar', isset($slider) ? $slider->getTranslation('title', 'ar') : '')); ?>">
              <?php $__errorArgs = ['title.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label"><?php echo e(__('sliders.title_en') ?? 'العنوان (إنكليزي)'); ?></label>
              <input type="text" name="title[en]" class="form-control <?php $__errorArgs = ['title.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title.en', isset($slider) ? $slider->getTranslation('title', 'en') : '')); ?>">
              <?php $__errorArgs = ['title.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-12 mb-3">
              <label class="form-label"><?php echo e(__('sliders.is_active')); ?></label>
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" <?php echo e((isset($slider) && $slider->is_active) || old('is_active') ? 'checked' : ''); ?>>
                <label class="form-check-label"><?php echo e(__('sliders.active_desc')); ?></label>
              </div>
            </div>

            
            <div class="col-md-6 mb-3">
              <label class="form-label"><?php echo e(__('sliders.description_ar') ?? 'الوصف (عربي)'); ?></label>
              <textarea name="description[ar]" class="form-control <?php $__errorArgs = ['description.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"><?php echo e(old('description.ar', isset($slider) ? $slider->getTranslation('description', 'ar') : '')); ?></textarea>
              <?php $__errorArgs = ['description.ar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label"><?php echo e(__('sliders.description_en') ?? 'الوصف (إنكليزي)'); ?></label>
              <textarea name="description[en]" class="form-control <?php $__errorArgs = ['description.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"><?php echo e(old('description.en', isset($slider) ? $slider->getTranslation('description', 'en') : '')); ?></textarea>
              <?php $__errorArgs = ['description.en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-md-6 mb-3">
              <label class="form-label"><?php echo e(__('sliders.start_date')); ?></label>
              <input type="date" name="start_date" class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(isset($slider) ? $slider->start_date->format('Y-m-d') : old('start_date')); ?>">
              <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><?php echo e(__('sliders.end_date')); ?></label>
              <input type="date" name="end_date" class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(isset($slider) ? $slider->end_date->format('Y-m-d') : old('end_date')); ?>">
              <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="col-12 mt-3 p-3 bg-lighter rounded-3">
              <h6 class="fw-bold mb-3"><i class="bx bx-link me-1"></i> <?php echo e(__('sliders.link_to')); ?></h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label"><?php echo e(__('sliders.link_type')); ?></label>
                  <select id="sliderable_type" name="sliderable_type" class="form-select">
                    <option value=""><?php echo e(__('sliders.no_link')); ?></option>
                    <option value="App\Models\Category" <?php echo e((isset($slider) && $slider->sliderable_type == 'App\Models\Category') ? 'selected' : ''); ?>><?php echo e(__('sliders.category')); ?></option>
                    <option value="App\Models\Service" <?php echo e((isset($slider) && $slider->sliderable_type == 'App\Models\Service') ? 'selected' : ''); ?>><?php echo e(__('sliders.service')); ?></option>
                  </select>
                </div>

                <div id="target_id_container" class="col-md-6 mb-3 <?php echo e((isset($slider) && $slider->sliderable_id) ? '' : 'd-none'); ?>">
                  <label class="form-label"><?php echo e(__('sliders.target_item')); ?></label>
                  <select id="sliderable_id" name="sliderable_id" class="form-select">
                    
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2 px-4"><?php echo e(__('sliders.save')); ?></button>
            <a href="<?php echo e(route('sliders.index')); ?>" class="btn btn-label-secondary"><?php echo e(__('sliders.cancel')); ?></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
  const sliderableType = document.getElementById('sliderable_type');
  const sliderableIdContainer = document.getElementById('target_id_container');
  const sliderableId = document.getElementById('sliderable_id');

  // البيانات من الـ Backend
  const dataSources = {
    'App\\Models\\Category': <?php echo json_encode($categories, 15, 512) ?>,
    'App\\Models\\Service': <?php echo json_encode($services, 15, 512) ?>
  };

  const currentId = "<?php echo e($slider->sliderable_id ?? ''); ?>";

  sliderableType.addEventListener('change', function() {
    const type = this.value;
    sliderableId.innerHTML = '';
    
    if (type && dataSources[type]) {
        sliderableIdContainer.classList.remove('d-none');
        
        // إضافة خيار فارغ أولاً
        const defaultOption = new Option("<?php echo e(__('sliders.select_item')); ?>", "");
        sliderableId.add(defaultOption);

        dataSources[type].forEach(item => {
            // هنا نستخدم display_name الذي جهزناه في الـ Controller
            const option = new Option(item.display_name, item.id);
            
            if (item.id == currentId) option.selected = true;
            sliderableId.add(option);
        });
    } else {
        sliderableIdContainer.classList.add('d-none');
    }
});

  // تشغيل الـ Script مرة عند التحميل في حالة الـ Edit
  if (sliderableType.value) {
    sliderableType.dispatchEvent(new Event('change'));
  }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/sliders/create_edit.blade.php ENDPATH**/ ?>