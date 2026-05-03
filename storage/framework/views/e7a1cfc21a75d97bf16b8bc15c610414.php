<?php $__env->startSection('title', __('reports.title')); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(105, 108, 255, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-primary"><?php echo e(__('reports.total_reports')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['total']); ?></h4>
                    </div>
                    <span class="badge bg-primary rounded-circle p-2">
                        <i class="bx bx-list-ul fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(255, 171, 0, 0.08);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-warning"><?php echo e(__('reports.pending_reports')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['pending']); ?></h4>
                    </div>
                    <span class="badge bg-warning rounded-circle p-2">
                        <i class="bx bx-time-five fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card shadow-none border-0 rounded-4" style="background-color: rgba(113, 221, 55, 0.08);">
            <div class="card-body p-3 text-nowrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-success"><?php echo e(__('reports.resolved_reports')); ?></h6>
                        <h4 class="mb-0 fw-black"><?php echo e($stats['resolved']); ?></h4>
                    </div>
                    <span class="badge bg-success rounded-circle p-2">
                        <i class="bx bx-check-shield fs-3"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card rounded-4 overflow-hidden">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-3"><?php echo e(__('reports.management_card')); ?></h5>
        <form action="<?php echo e(route('reports.index')); ?>" method="GET">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(__('reports.search_placeholder')); ?>">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <select name="status" class="form-select text-capitalize">
                        <option value=""><?php echo e(__('reports.all_statuses')); ?></option>
                        <?php $__currentLoopData = \App\Enum\ReportStatusEnum::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status->value); ?>" <?php echo e(request('status') == $status->value ? 'selected' : ''); ?>>
                                <?php echo e($status->label()); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
                        <?php echo e(__('reports.filter_btn')); ?>

                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive text-nowrap">
    <table class="table table-hover mb-0">
        <thead class="table-light text-uppercase">
            <tr>
                <th><?php echo e(__('reports.service_info')); ?></th>
                <th><?php echo e(__('reports.reporter')); ?></th>
                <th><?php echo e(__('reports.status')); ?></th>
                <th><?php echo e(__('reports.date_reported')); ?></th>
                <?php if(auth()->user()->can('manage-reports') || auth()->user()->can('delete-reports')): ?>
                    <th class="text-center"><?php echo e(__('reports.actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3">
                            <span class="avatar-initial rounded-circle bg-label-secondary">
                                <i class="bx bx-flag fs-5"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-heading"><?php echo e($report->service->title ?? __('reports.unknown')); ?></span>
                            <small class="text-muted text-truncate" style="max-width: 200px;"><?php echo e($report->reason); ?></small>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user me-2 text-primary"></i>
                        <span class="small"><?php echo e($report->user->name ?? __('reports.unknown')); ?></span>
                    </div>
                </td>

                <td>
                    <span class="badge <?php echo e($report->status === \App\Enum\ReportStatusEnum::Resolved ? 'bg-label-success' : 'bg-label-warning'); ?> rounded-pill">
                        <?php echo e($report->status->label()); ?>

                    </span>
                </td>

                <td>
                    <span class="text-muted small"><?php echo e($report->created_at->format('d M y')); ?></span>
                </td>

                <?php if(auth()->user()->can('manage-reports') || auth()->user()->can('delete-reports')): ?>
                <td class="text-center">
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded fs-4"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal<?php echo e($report->id); ?>">
                                <i class="bx bx-show-alt me-1"></i> <?php echo e(__('reports.view_details')); ?>

                            </button>

                            <?php if($report->status !== \App\Enum\ReportStatusEnum::Resolved): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-reports')): ?>
                                <form action="<?php echo e(route('reports.resolve', $report->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-success">
                                        <i class="bx bx-check-circle me-1"></i> <?php echo e(__('reports.mark_resolved')); ?>

                                    </button>
                                </form>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-reports')): ?>
                            <div class="dropdown-divider"></div>
                            <form action="<?php echo e(route('reports.destroy', $report->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('reports.confirm_delete')); ?>')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bx bx-trash me-1"></i> <?php echo e(__('reports.delete')); ?>

                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <?php endif; ?>
            </tr>
            
            <?php echo $__env->make('dashboard.reports.details_modal', ['report' => $report], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="text-muted">
                        <i class="bx bx-search-alt-2 mb-2" style="font-size: 3rem;"></i>
                        <p class="mb-0"><?php echo e(__('reports.no_results')); ?></p>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

    <?php if($reports->hasPages() || $reports->total() > 0): ?>
    <div class="card-footer border-top d-flex flex-column flex-md-row align-items-center justify-content-between py-3">
        <div class="text-muted small">
            <?php echo e(__('reports.showing')); ?> <strong><?php echo e($reports->firstItem() ?? 0); ?></strong> <?php echo e(__('reports.to')); ?> <strong><?php echo e($reports->lastItem() ?? 0); ?></strong> <?php echo e(__('reports.of')); ?> <strong><?php echo e($reports->total()); ?></strong> <?php echo e(__('reports.records')); ?>

        </div>
        <div class="pagination-wrapper">
            <?php echo e($reports->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/reports/index.blade.php ENDPATH**/ ?>