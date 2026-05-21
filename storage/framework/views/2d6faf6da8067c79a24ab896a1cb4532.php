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
    
    /* تنسيق للترحيب الجديد */
    .navbar-greeting {
        font-size: 1.05rem;
        font-weight: 500;
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
    
    
    <div class="navbar-nav align-items-center d-none d-sm-flex">
        <div class="nav-item d-flex align-items-center">
            <span class="navbar-greeting text-muted">
                👋 <?php echo e(app()->getLocale() === 'ar' ? 'مرحباً بك،' : 'Welcome back,'); ?> 
                <span class="fw-bold text-primary ms-1"><?php echo e(Auth::user()->name ?? 'Admin'); ?></span>
            </span>
        </div>
    </div>

    <ul class="navbar-nav flex-row align-items-center ms-auto gap-1">
        

    
    <li class="nav-item dropdown-language dropdown">
        <a class="nav-link dropdown-toggle hide-arrow position-relative d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown" title="<?php echo e(__('header.language') ?? 'Language'); ?>" style="padding: 16px 16px !important; margin-top: -4px;">
        <?php if(app()->getLocale() === 'ar'): ?>
            
            <img src="data:image/png;base64,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" alt="Syria" class="rounded-1 shadow-sm border" style="width: 32px; height: 22px; object-fit: cover;">
        <?php else: ?>
            
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Flag_of_the_United_States.svg" alt="English" class="rounded-1 shadow-sm border" style="width: 32px; height: 22px; object-fit: cover;">
        <?php endif; ?>
    </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2">
            <li>
                <a class="dropdown-item <?php echo e(app()->getLocale() === 'en' ? 'active bg-label-primary' : ''); ?>" href="<?php echo e(route('locale', 'en')); ?>">
                    <span class="fi fi-us fs-5 me-2 rounded-1"></span> 
                    <span class="align-middle">English</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item <?php echo e(app()->getLocale() === 'ar' ? 'active bg-label-primary' : ''); ?>" href="<?php echo e(route('locale', 'ar')); ?>">
                    <img src="data:image/png;base64,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" alt="Syria" class="me-2 rounded-1" style="width: 22px; height: 15px; object-fit: cover; vertical-align: middle;">
                    <span class="align-middle">العربية</span>
                </a>
            </li>
        </ul>
    </li>

        
        <?php
            $unreadCount = $unreadNotificationsCount ?? 0;
            $notifications = ($latestNotifications ?? collect())->take(5);
        ?>

        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-4">
            <a class="nav-link dropdown-toggle hide-arrow position-relative p-2" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <i class="bx bx-bell <?php echo e($unreadCount > 0 ? 'bell-shake text-primary' : ''); ?>" style="font-size: 1.5rem;"></i>
                <?php if($unreadCount > 0): ?>
                    <span class="badge bg-danger badge-dot badge-notifications position-absolute top-0 start-100 translate-middle mt-2 ms-n2 border border-2 border-white"></span>
                <?php endif; ?>
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end py-0 shadow-lg border-0 rounded-4 mt-2" style="width: 360px;">
                <li class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="text-body mb-0 me-auto fw-bold"><?php echo e(__('header.notifications')); ?></h6>
                        <?php if($unreadCount > 0): ?>
                            <span class="badge bg-label-primary fs-tiny me-2"><?php echo e($unreadCount); ?> <?php echo e(__('header.new')); ?></span>
                        <?php endif; ?>
                        <form action="<?php echo e(route('notifications.readAll')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-icon btn-sm btn-label-secondary rounded-circle" data-bs-toggle="tooltip" title="<?php echo e(__('header.mark_all_read')); ?>">
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
                                <div class="avatar avatar-md mx-auto mb-3">
                                    <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-bell-off fs-4"></i></span>
                                </div>
                                <h6 class="text-muted mb-0"><?php echo e(__('header.no_notifications')); ?></h6>
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
                        <img src="<?php echo e(auth('web')->user()->getFirstMediaUrl('admin_avatars')); ?>" alt class="rounded-circle border border-2 border-primary p-1" style="object-fit: cover;">
                    <?php else: ?>
                        <span class="avatar-initial rounded-circle bg-label-primary border border-2 border-primary">
                            <?php echo e(Str::upper(Str::substr(auth('web')->user()->name, 0, 2))); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2">
                <li>
                    <a class="dropdown-item py-3" href="<?php echo e(route('profile.index')); ?>">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online avatar-md">
                                    <?php if(auth('web')->user()->getFirstMediaUrl('admin_avatars')): ?>
                                        <img src="<?php echo e(auth('web')->user()->getFirstMediaUrl('admin_avatars')); ?>" alt class="rounded-circle border border-2 border-primary p-1" style="object-fit: cover;">
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
                    <a class="dropdown-item rounded-2 mx-1" style="width: 95%" href="<?php echo e(route('profile.index')); ?>">
                        <i class="bx bx-user me-2"></i> <?php echo e(__('header.my_profile')); ?>

                    </a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item text-danger rounded-2 mx-1 mb-1" style="width: 95%">
                            <i class="bx bx-power-off me-2"></i> <?php echo e(__('header.logout')); ?>

                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/layouts/sections/navbar/navbar-partial.blade.php ENDPATH**/ ?>