<?php $__env->startSection('title', __('dashboard.page_title')); ?>

<?php $__env->startPush('vendor-style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css" />
<style>
    .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, 0.4); transition: transform 0.2s; }
    .table thead th { text-transform: none; letter-spacing: 0; font-weight: 700; font-size: 0.85rem; }
    .avatar-initial { font-weight: 600; }
    .border-dashed { border-style: dashed !important; }
    .stat-card:hover { transform: translateY(-3px); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="row mb-4">
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card h-100 bg-label-primary border-0 shadow-none">
            <div class="d-flex align-items-center row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h4 class="card-title text-primary mb-3"><?php echo e(__('dashboard.welcome_title')); ?> 🎉</h4>
                        <p class="mb-4 text-dark" style="opacity: 0.8"><?php echo e(__('dashboard.tasks_summary')); ?></p>
                        <div class="d-flex gap-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-business-accounts')): ?>
                            <a href="<?php echo e(route('business-accounts.index')); ?>" class="btn btn-primary btn-sm">
                                <?php echo e(__('dashboard.review_accounts')); ?> (<?php echo e($stats['pending_business_accounts']); ?>)
                            </a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-services')): ?>
                            <a href="<?php echo e(route('services.index')); ?>" class="btn btn-outline-primary btn-sm">
                                <?php echo e(__('dashboard.services')); ?> (<?php echo e($stats['pending_services']); ?>)
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="<?php echo e(asset('assets/img/illustrations/man-with-laptop.png')); ?>" height="140" alt="Welcome">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="row g-4 h-100">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-business-accounts')): ?>
            <div class="col-6">
                <div class="card h-100 stat-card text-center">
                    <div class="card-body">
                        <div class="avatar mx-auto mb-2"><span class="avatar-initial rounded bg-label-success"><i class="bx bx-check-shield fs-4"></i></span></div>
                        <span class="d-block mb-1 text-muted small"><?php echo e(__('dashboard.active_accounts')); ?></span>
                        <h4 class="card-title mb-0"><?php echo e($stats['total_business_accounts']); ?></h4>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-reports')): ?>
            <div class="col-6">
                <div class="card h-100 stat-card text-center">
                    <div class="card-body">
                        <div class="avatar mx-auto mb-2"><span class="avatar-initial rounded bg-label-danger"><i class="bx bx-error-alt fs-4"></i></span></div>
                        <span class="d-block mb-1 text-muted small"><?php echo e(__('dashboard.open_reports')); ?></span>
                        <h4 class="card-title mb-0 text-danger"><?php echo e($stats['pending_reports']); ?></h4>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mb-4 g-4">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cities')): ?>
    <div class="col-lg-3 col-md-4 col-6">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="avatar me-3"><span class="avatar-initial rounded bg-label-info"><i class="bx bx-map-pin fs-4"></i></span></div>
                <div><h5 class="mb-0"><?php echo e($stats['total_cities']); ?></h5><span class="text-muted small"><?php echo e(__('dashboard.cities')); ?></span></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-activities')): ?>
    <div class="col-lg-3 col-md-4 col-6">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="avatar me-3"><span class="avatar-initial rounded bg-label-warning"><i class="bx bx-briefcase fs-4"></i></span></div>
                <div><h5 class="mb-0"><?php echo e($stats['total_activities']); ?></h5><span class="text-muted small"><?php echo e(__('dashboard.activities')); ?></span></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-categories')): ?>
    <div class="col-lg-3 col-md-4 col-6">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="avatar me-3"><span class="avatar-initial rounded bg-label-primary"><i class="bx bx-category fs-4"></i></span></div>
                <div><h5 class="mb-0"><?php echo e($stats['total_categories']); ?></h5><span class="text-muted small"><?php echo e(__('dashboard.categories')); ?></span></div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-sliders')): ?>
    <div class="col-lg-3 col-md-4 col-6">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="avatar me-3"><span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-images fs-4"></i></span></div>
                <div><h5 class="mb-0"><?php echo e($stats['total_sliders']); ?></h5><span class="text-muted small"><?php echo e(__('dashboard.sliders')); ?></span></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row mb-4">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-business-accounts')): ?>
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('dashboard.pending_business_accounts')); ?></h5>
                <a href="<?php echo e(route('business-accounts.index')); ?>" class="btn btn-sm btn-label-primary"><?php echo e(__('dashboard.view_all')); ?></a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo e(__('dashboard.name_user')); ?></th>
                            <th><?php echo e(__('dashboard.date')); ?></th>
                            <th><?php echo e(__('dashboard.action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stats['latest_pending_accounts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3"><img src="<?php echo e($account->getFirstMediaUrl('images') ?: asset('assets/img/avatars/1.png')); ?>" class="rounded-circle"></div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium small"><?php echo e($account->getTranslation('name', app()->getLocale())); ?></span>
                                        <small class="text-muted" style="font-size: 0.7rem;"><?php echo e($account->user->name); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="small text-muted"><?php echo e($account->created_at->format('Y-m-d')); ?></span></td>
                            <td><a href="<?php echo e(route('business-accounts.show', $account->id)); ?>" class="btn btn-icon btn-sm btn-outline-secondary"><i class="bx bx-show"></i></a></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-services')): ?>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('dashboard.latest_pending_services')); ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-sm align-middle">
                    <thead>
                        <tr class="text-muted small border-bottom">
                            <th class="ps-4"><?php echo e(__('dashboard.property')); ?></th>
                            <th class="text-end pe-4"><?php echo e(__('dashboard.price')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stats['latest_pending_services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-bottom">
                            <td class="py-3 ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo e($service->getFirstMediaUrl('main_image_service') ?: asset('assets/img/elements/1.jpg')); ?>" width="40" height="40" class="rounded me-3 object-fit-cover">
                                    <span class="fw-medium small"><?php echo e($service->title); ?></span>
                                </div>
                            </td>
                            <td class="text-end pe-4 fw-bold text-dark"><?php echo e(number_format($service->price_syp)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-services')): ?>
<div class="row">
    <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h5 class="card-title mb-0"><?php echo e(__('dashboard.property_analytics')); ?></h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-around mt-4 mb-4 py-2 border rounded border-dashed">
                    <div class="text-center border-end w-50">
                        <h6 class="mb-1 small"><?php echo e(__('dashboard.for_sale')); ?></h6>
                        <p class="mb-0 fw-bold text-primary"><?php echo e($stats['charts']['services_type']['sale']); ?></p>
                    </div>
                    <div class="text-center w-50">
                        <h6 class="mb-1 small"><?php echo e(__('dashboard.for_rent')); ?></h6>
                        <p class="mb-0 fw-bold text-info"><?php echo e($stats['charts']['services_type']['rent']); ?></p>
                    </div>
                </div>
                <div id="servicesChart"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0"><?php echo e(__('dashboard.weekly_interaction_rate')); ?></h5>
                <span class="badge bg-label-success"><?php echo e(__('dashboard.active')); ?></span>
            </div>
            <div class="card-body">
                <div id="weeklyRequestsChart"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('page-script'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-services')): ?>
    const servicesChartEl = document.querySelector('#servicesChart');
    if (servicesChartEl) {
        new ApexCharts(servicesChartEl, {
            chart: { height: 260, type: 'donut' },
            labels: ["<?php echo e(__('dashboard.sale')); ?>", "<?php echo e(__('dashboard.rent')); ?>"],
            series: [<?php echo e($stats['charts']['services_type']['sale']); ?>, <?php echo e($stats['charts']['services_type']['rent']); ?>],
            colors: ['#696cff', '#03c3ec'],
            stroke: { width: 5, colors: ['#ffffff'] },
            dataLabels: { enabled: false },
            legend: { show: true, position: 'bottom' },
            plotOptions: { pie: { donut: { size: '75%', labels: { show: true, total: { show: true, label: "<?php echo e(__('dashboard.total')); ?>", formatter: function () { return <?php echo e($stats['total_services']); ?>; } } } } } }
        }).render();
    }

    const weeklyChartEl = document.querySelector('#weeklyRequestsChart');
    if (weeklyChartEl) {
        new ApexCharts(weeklyChartEl, {
            chart: { height: 280, type: 'area', toolbar: { show: false } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            series: [{ name: "<?php echo e(__('dashboard.requests')); ?>", data: <?php echo json_encode($stats['charts']['weekly_requests']['data'], 15, 512) ?> }],
            xaxis: { categories: <?php echo json_encode($stats['charts']['weekly_requests']['labels'], 15, 512) ?> },
            colors: ['#71dd37'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1, stops: [0, 90, 100] } }
        }).render();
    }
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/content/dashboard/dashboards-analytics.blade.php ENDPATH**/ ?>