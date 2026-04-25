<div class="modal fade" id="reportModal<?php echo e($report->id); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('reports.details')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary"><?php echo e(__('reports.service')); ?>:</label>
                    <p class="mb-0"><?php echo e($report->service->title ?? __('reports.unknown')); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary"><?php echo e(__('reports.reason')); ?>:</label>
                    <p class="text-break mb-0"><?php echo e($report->reason); ?></p>
                </div>
                
                <?php if($report->description): ?>
                <div class="mb-3 p-3 bg-lighter rounded">
                    <label class="form-label fw-bold text-primary"><?php echo e(__('reports.description')); ?>:</label>
                    <p class="text-break mb-0"><?php echo e($report->description); ?></p>
                </div>
                <?php endif; ?>
                
                <hr>
                <div class="d-flex justify-content-between text-muted small">
                    <span><strong><?php echo e(__('reports.reporter')); ?>:</strong> <?php echo e($report->user->name ?? __('reports.unknown')); ?></span>
                    <span><strong><?php echo e(__('reports.date')); ?>:</strong> <?php echo e($report->created_at->format('Y-m-d')); ?></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo e(__('reports.close')); ?></button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/dashboard/reports/details_modal.blade.php ENDPATH**/ ?>