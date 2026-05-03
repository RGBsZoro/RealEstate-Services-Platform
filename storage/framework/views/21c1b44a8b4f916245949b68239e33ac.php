<?php $__env->startSection('title', __('sliders.title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4 bg-label-primary">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold"><?php echo e(__('sliders.total_reports')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total']); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2"><i class="bx bx-images fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4 bg-label-success">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold"><?php echo e(__('sliders.live_now')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['live']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2"><i class="bx bx-broadcast fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4 bg-label-danger">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold"><?php echo e(__('sliders.expired_reports')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['expired']); ?></h4>
                    </div>
                    <span class="badge bg-danger rounded-circle p-2"><i class="bx bx-time-five fs-3"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4 rounded-4 overflow-hidden shadow-sm">
    <div class="card-header border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <h5 class="mb-0 fw-bold"><?php echo e(__('sliders.management_card')); ?></h5>
        <div class="d-flex flex-column flex-sm-row gap-3 w-100 w-md-auto">
            <form action="<?php echo e(route('sliders.index')); ?>" method="GET" class="d-flex gap-2 flex-grow-1">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('sliders.search_placeholder')); ?>">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value=""><?php echo e(__('sliders.all_statuses')); ?></option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>><?php echo e(__('sliders.live_now')); ?></option>
                    <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>><?php echo e(__('sliders.scheduled')); ?></option>
                    <option value="expired" <?php echo e(request('status') == 'expired' ? 'selected' : ''); ?>><?php echo e(__('sliders.expired')); ?></option>
                </select>
            </form>
            
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-sliders')): ?>
            <a href="<?php echo e(route('sliders.create')); ?>" class="btn btn-primary text-nowrap">
                <i class="bx bx-plus me-1"></i> <?php echo e(__('sliders.add_new')); ?>

            </a>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative hover-shadow-lg transition">
            <div class="position-absolute top-0 start-0 m-3 z-index-2">
                <?php
                    // نوحد التاريخ للصيغة YYYY-MM-DD لتجنب أي مشاكل متعلقة بالساعات
                    $todayDate = now()->toDateString();
                    $startDate = $slider->start_date ? $slider->start_date->toDateString() : null;
                    $endDate   = $slider->end_date ? $slider->end_date->toDateString() : null;
                ?>

                <?php if($endDate && $endDate < $todayDate): ?>
                    <span class="badge bg-danger rounded-pill shadow-sm"><?php echo e(__('sliders.expired')); ?></span>
                    
                <?php elseif($startDate && $startDate > $todayDate): ?>
                    <span class="badge bg-warning rounded-pill shadow-sm"><?php echo e(__('sliders.scheduled')); ?></span>
                    
                <?php elseif($slider->is_active): ?>
                    <span class="badge bg-success rounded-pill shadow-sm"><?php echo e(__('sliders.active')); ?></span>
                    
                <?php else: ?>
                    <span class="badge bg-secondary rounded-pill shadow-sm"><?php echo e(__('sliders.not_active')); ?></span>
                <?php endif; ?>
            </div>

            <div class="card-img-wrapper" style="height: 200px; overflow: hidden;">
                <img class="card-img-top w-100 h-100" 
                     src="<?php echo e($slider->getFirstMediaUrl('slider_images') ?: asset('assets/img/elements/18.jpg')); ?>" 
                     style="object-fit: cover;"
                     alt="<?php echo e($slider->title); ?>">
            </div>
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title text-primary fw-bold mb-0 text-truncate" style="max-width: 80%;">
                        <?php echo e($slider->title ?: __('sliders.no_title')); ?>

                    </h5>
                    
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-sliders')): ?>
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" 
                               data-id="<?php echo e($slider->id); ?>" <?php echo e($slider->is_active ? 'checked' : ''); ?>>
                    </div>
                    <?php endif; ?>
                </div>
                <p class="card-text text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px;">
                    <?php echo e($slider->description ?: __('sliders.no_description')); ?>

                </p>
                
                <div class="bg-light p-2 rounded-3 mb-3 d-flex justify-content-around text-center">
                    <div class="small">
                        <span class="d-block text-muted" style="font-size: 0.7rem;"><?php echo e(__('sliders.start_date')); ?></span>
                        <span class="fw-bold"><?php echo e($slider->start_date?->format('Y-m-d') ?? '---'); ?></span>
                    </div>
                    <div class="vr mx-2"></div>
                    <div class="small">
                        <span class="d-block text-muted" style="font-size: 0.7rem;"><?php echo e(__('sliders.end_date')); ?></span>
                        <span class="fw-bold"><?php echo e($slider->end_date?->format('Y-m-d') ?? '---'); ?></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="badge bg-label-secondary small px-2">
                        <i class="bx bx-link-alt me-1"></i>
                        <?php if($slider->sliderable_type): ?>
                            <?php echo e(class_basename($slider->sliderable_type) == 'Category' ? __('sliders.category') : __('sliders.service')); ?>

                        <?php else: ?>
                            <?php echo e(__('sliders.no_link')); ?>

                        <?php endif; ?>
                    </span>

                    
                    <?php if(auth()->user()->can('edit-sliders') || auth()->user()->can('delete-sliders')): ?>
                    <div class="dropdown">
                        <button class="btn p-0" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded fs-4"></i></button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-sliders')): ?>
                            <a class="dropdown-item" href="<?php echo e(route('sliders.edit', $slider->id)); ?>">
                                <i class="bx bx-edit me-1 text-info"></i> <?php echo e(__('sliders.edit')); ?>

                            </a>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('edit-sliders') && auth()->user()->can('delete-sliders')): ?>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-sliders')): ?>
                            <form action="<?php echo e(route('sliders.destroy', $slider->id)); ?>" method="POST" class="d-inline delete-form">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bx bx-trash me-1"></i> <?php echo e(__('sliders.delete')); ?>

                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12 text-center py-5">
        <div class="mb-3">
            <i class="bx bx-image-add text-muted" style="font-size: 5rem;"></i>
        </div>
        <h5 class="text-muted"><?php echo e(__('sliders.no_results')); ?></h5>
        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-sliders')): ?>
        <a href="<?php echo e(route('sliders.create')); ?>" class="btn btn-primary mt-2">
            <?php echo e(__('sliders.add_new')); ?>

        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>


<div class="card shadow-sm border-0 rounded-4 overflow-hidden mt-4">
    <?php if($sliders->total() > 0): ?>
    <div class="card-footer bg-white border-0 d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            <?php echo e(__('sliders.showing_count', [
                'first' => $sliders->firstItem() ?? 0,
                'last' => $sliders->lastItem() ?? 0,
                'total' => $sliders->total()
            ])); ?>

        </div>
        <div class="pagination-wrapper mt-3 mt-md-0">
            <?php echo e($sliders->appends(request()->query())->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
    window.onload = function() {
        if (window.jQuery) {
            $(function() {
                // تحديث الحالة AJAX (فقط إذا كان للمستخدم صلاحية التعديل، والـ HTML يضمن ذلك بعدم وجود الـ Checkbox أصلاً)
                $(document).on('change', '.status-toggle', function() {
                    const checkbox = $(this);
                    const id = checkbox.data('id');
                    const isActive = checkbox.is(':checked');
                    const url = "<?php echo e(url('sliders')); ?>/" + id + "/toggle-status";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: { _token: '<?php echo e(csrf_token()); ?>' },
                    });
                });

                // تأكيد الحذف
                $(document).on('submit', '.delete-form', function(e) {
                    if(!confirm("<?php echo e(__('sliders.confirm_delete')); ?>")) {
                        e.preventDefault();
                    }
                });
            });
        }
    };
</script>

<style>
    .hover-shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .transition {
        transition: all 0.3s ease-in-out;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/sliders/index.blade.php ENDPATH**/ ?>