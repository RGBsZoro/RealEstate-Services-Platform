<?php
use Illuminate\Support\Facades\Route;
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="<?php echo e(url('/')); ?>" class="app-brand-link">
            <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size: 1.8rem; white-space: nowrap;"><?php echo e(__('sidebar.app_name')); ?></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="icon-base bx bx-chevron-left icon-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php $__currentLoopData = $menuData[0]->menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            
            <?php
                $hasPermission = true;
                if (isset($menu->permission)) {
                    $hasPermission = auth()->user()->can($menu->permission);
                }
            ?>

            <?php if($hasPermission): ?>
                
                <?php if(isset($menu->menuHeader)): ?>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text"><?php echo e(__('sidebar.' . $menu->menuHeader)); ?></span>
                    </li>
                <?php else: ?>

                    
                    <?php
                    $activeClass = '';
                    $currentRouteName = Route::currentRouteName() ?? '';

                    // المنطق الجديد: نتحقق إذا كان الراوت الحالي يبدأ بالـ slug
                    // هذا يضمن أن الراوتات مثل admins.index أو admins.create ستفعل التبويبة الرئيسية admins
                    if (is_array($menu->slug)) {
                        foreach($menu->slug as $slug){
                            if (str_starts_with($currentRouteName, $slug)) {
                                $activeClass = isset($menu->submenu) ? 'active open' : 'active';
                                break;
                            }
                        }
                    } else {
                        if (str_starts_with($currentRouteName, $menu->slug)) {
                            $activeClass = isset($menu->submenu) ? 'active open' : 'active';
                        }
                    }
                    ?>

                    
                    <li class="menu-item <?php echo e($activeClass); ?>">
                        <a href="<?php echo e(isset($menu->url) ? url($menu->url) : 'javascript:void(0);'); ?>" class="<?php echo e(isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link'); ?>">
                            <?php if(isset($menu->icon)): ?>
                                <i class="<?php echo e($menu->icon); ?>"></i>
                            <?php endif; ?>
                            
                            <div><?php echo e(isset($menu->name) ? __('sidebar.' . $menu->name) : ''); ?></div>
                            
                            <?php if(isset($menu->badge)): ?>
                                <div class="badge rounded-pill bg-<?php echo e($menu->badge[0]); ?> text-uppercase ms-auto"><?php echo e($menu->badge[1]); ?></div>
                            <?php endif; ?>
                        </a>
                        
                        
                        <?php if(isset($menu->submenu)): ?>
                            <?php echo $__env->make('layouts.sections.menu.submenu',['menu' => $menu->submenu], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

</aside><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/layouts/sections/menu/verticalMenu.blade.php ENDPATH**/ ?>