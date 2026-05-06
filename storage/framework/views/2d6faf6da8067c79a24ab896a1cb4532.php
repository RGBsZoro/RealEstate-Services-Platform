<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
?>

<style>
    /* تأثير النبض للجرس في حال وجود إشعارات */
    .bell-shake { animation: bell-ring 2s infinite; }
    @keyframes bell-ring {
        0%, 100% { transform: rotate(0); }
        10%, 30%, 50%, 70%, 90% { transform: rotate(10deg); }
        20%, 40%, 60%, 80% { transform: rotate(-10deg); }
    }
    
    .unread-dot {
        width: 8px;
        height: 8px;
        background-color: #ff3e1d;
        border-radius: 50%;
        display: inline-block;
        margin-left: 5px;
    }

    .notification-item {
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .notification-item:hover {
        background-color: #f8f9fa !important;
        border-left-color: #696cff;
    }

    .notification-item.unread {
        background-color: rgba(105, 108, 255, 0.05);
    }

    /* تنسيق محسن لحقل البحث */
    .search-wrapper {
        background-color: #f5f5f9;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        width: 350px;
    }

    .search-wrapper:focus-within {
        background-color: #fff;
        border-color: #696cff;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.1);
    }

    .search-input {
        background: transparent !important;
        font-size: 0.9375rem;
    }

    [lang="ar"] .search-wrapper i { margin-left: 0.5rem; margin-right: 0.75rem; }
    [lang="en"] .search-wrapper i { margin-right: 0.5rem; margin-left: 0.75rem; }
    
    [dir="rtl"] .form-select {
        background-position: left 0.75rem center !important;
        padding-left: 2.25rem !important;
        padding-right: 0.875rem !important;
    }

    .dropdown-notifications-list {
        max-height: 400px; 
        overflow-y: auto;
        position: relative;
    }

    .dropdown-notifications-list::-webkit-scrollbar {
        width: 5px;
    }
    .dropdown-notifications-list::-webkit-scrollbar-thumb {
        background: #dbdade;
        border-radius: 10px;
    }
</style>

<?php if(isset($navbarFull)): ?>
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
        <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
        <span class="app-brand-text demo menu-text fw-bold text-heading"><?php echo e(config('variables.templateName')); ?></span>
    </a>
</div>
<?php endif; ?>

<?php if(!isset($navbarHideToggle)): ?>
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 <?php echo e(isset($contentNavbar) ? 'd-xl-none' : ''); ?>">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base bx bx-menu icon-md"></i>
    </a>
</div>
<?php endif; ?>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <div class="search-wrapper d-flex align-items-center px-2">
                <i class="bx bx-search fs-4 lh-0 text-muted"></i>
                <input 
                    type="text" 
                    class="form-control border-0 shadow-none ps-2 search-input" 
                    placeholder="<?php echo e(__('header.search')); ?>" 
                    aria-label="Search..."
                >
            </div>
        </div>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto">
        
        <li class="nav-item dropdown-language dropdown">
            <a class="nav-link dropdown-toggle hide-arrow position-relative p-2" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="bx bx-globe" style="font-size: 1.6rem;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                <li>
                    <a class="dropdown-item <?php echo e(app()->getLocale() === 'en' ? 'active' : ''); ?>" href="<?php echo e(route('locale', 'en')); ?>">
                        <i class="bx bx-flag me-2"></i> English
                    </a>
                </li>
                <li>
                    <a class="dropdown-item <?php echo e(app()->getLocale() === 'ar' ? 'active' : ''); ?>" href="<?php echo e(route('locale', 'ar')); ?>">
                        <i class="bx bx-flag me-2"></i> العربية
                    </a>
                </li>
            </ul>
        </li>

        
        <?php
            $unreadCount = $unreadNotificationsCount ?? 0;
            // هنا قمنا بإضافة take(5) لضمان عدم عرض أكثر من 5 إشعارات
            $notifications = ($latestNotifications ?? collect())->take(5);
        ?>

        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3">
            <a class="nav-link dropdown-toggle hide-arrow position-relative p-2" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <i class="bx bx-bell <?php echo e($unreadCount > 0 ? 'bell-shake' : ''); ?>" style="font-size: 1.6rem;"></i>
                <?php if($unreadCount > 0): ?>
                    <span class="badge bg-danger badge-dot badge-notifications position-absolute top-0 start-100 translate-middle mt-2 ms-n2 border border-2 border-white"></span>
                <?php endif; ?>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end py-0 shadow-lg border-0" style="width: 360px;">
                <li class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="text-body mb-0 me-auto fw-bold"><?php echo e(__('header.notifications')); ?></h6>
                        <?php if($unreadCount > 0): ?>
                            <span class="badge bg-label-primary fs-tiny me-2"><?php echo e($unreadCount); ?> <?php echo e(__('header.new')); ?></span>
                        <?php endif; ?>
                        <form action="<?php echo e(route('notifications.readAll')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-icon btn-sm btn-label-secondary" data-bs-toggle="tooltip" title="<?php echo e(__('header.mark_all_read')); ?>">
                                <i class="bx bx-envelope-open"></i>
                            </button>
                        </form>
                    </div>
                </li>
                
                <li class="dropdown-notifications-list"> 
                    <ul class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $data = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);
                                
                                // استخدام نظام الترجمة الديناميكي الذي اعتمدناه
                                $title = isset($data['title_key']) ? __($data['title_key']) : ($data['title'] ?? 'System Notice');
                                $bodyArgs = $data['body_args'] ?? [];
                                $body = isset($data['body_key']) ? __($data['body_key'], $bodyArgs) : ($data['body'] ?? '');
                                
                                $icon = $data['icon'] ?? 'bx-bell';
                            ?>
                            <li class="list-group-item list-group-item-action notification-item p-3 <?php echo e($notification->read_at ? '' : 'unread'); ?>">
                                <a href="<?php echo e(route('notifications.readAndRedirect', $notification->id)); ?>" class="d-flex text-decoration-none">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-md">
                                            <span class="avatar-initial rounded-circle <?php echo e($notification->read_at ? 'bg-label-secondary' : 'bg-label-primary'); ?>">
                                                <i class="bx <?php echo e($icon); ?>"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 small fw-bold text-dark"><?php echo e($title); ?></h6>
                                            <?php if(!$notification->read_at): ?> <span class="unread-dot"></span> <?php endif; ?>
                                        </div>
                                        <p class="mb-1 text-muted small lh-sm"><?php echo e(Str::limit($body, 65)); ?></p>
                                        <small class="text-muted d-block mt-1">
                                            <i class="bx bx-time-five me-1"></i><?php echo e($notification->created_at->diffForHumans()); ?>

                                        </small>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="list-group-item text-center p-5">
                                <i class="bx bx-bell-off fs-1 text-muted mb-2"></i>
                                <h6 class="text-muted"><?php echo e(__('header.no_notifications')); ?></h6>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                
                <li class="dropdown-menu-footer border-top">
                    <a href="<?php echo e(route('notifications.index')); ?>" class="dropdown-item d-flex justify-content-center p-3 text-primary fw-semibold">
                        <?php echo e(__('header.view_all_activity')); ?> <i class="bx bx-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </li>
        
        
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online avatar-md">
                    <?php if(auth('web')->user()->getFirstMediaUrl('admin_avatars')): ?>
                        <img src="<?php echo e(auth('web')->user()->getFirstMediaUrl('admin_avatars')); ?>" alt class="rounded-circle border border-2 border-primary p-1">
                    <?php else: ?>
                        <span class="avatar-initial rounded-circle bg-label-primary border border-2 border-primary">
                            <?php echo e(Str::upper(Str::substr(auth('web')->user()->name, 0, 2))); ?>

                        </span>
                     <?php endif; ?>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                <li>
                    <a class="dropdown-item py-3" href="javascript:void(0);">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online avatar-md">
                                    <?php if(auth('web')->user()->getFirstMediaUrl('admin_avatars')): ?>
                                        <img src="<?php echo e(auth('web')->user()->getFirstMediaUrl('admin_avatars')); ?>" alt class="rounded-circle border border-2 border-primary p-1">
                                    <?php else: ?>
                                        <span class="avatar-initial rounded-circle bg-label-primary border border-2 border-primary">
                                            <?php echo e(Str::upper(Str::substr(auth('web')->user()->name, 0, 2))); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold"><?php echo e(Auth::user()->name ?? 'Admin'); ?></h6>
                                <small class="text-muted"><?php echo e(__('header.system_manager')); ?></small>
                            </div>
                        </div>
                    </a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>
                <li>
                    <a class="dropdown-item" href="<?php echo e(route('profile.index')); ?>"><i class="bx bx-user me-2"></i> <?php echo e(__('header.my_profile')); ?></a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bx bx-power-off me-2"></i> <?php echo e(__('header.logout')); ?>

                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/layouts/sections/navbar/navbar-partial.blade.php ENDPATH**/ ?>