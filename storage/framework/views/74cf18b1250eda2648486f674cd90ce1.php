<?php
use Illuminate\Support\Facades\Route;
?>

<ul class="menu-sub">
  <?php if(isset($menu)): ?>
    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    
    <?php
        $hasPermission = true;
        if (isset($submenu->permission)) {
            $hasPermission = auth()->user()->can($submenu->permission);
        }
    ?>

    <?php if($hasPermission): ?>
        
        <?php
          $activeClass = '';
          $currentRouteName = Route::currentRouteName() ?? '';

          // المنطق الجديد: الابن يأخذ كلاس active فقط وليس active open (إلا لو كان هو نفسه لديه أبناء)
          if (is_array($submenu->slug)) {
              foreach($submenu->slug as $slug){
                  if (str_starts_with($currentRouteName, $slug)) {
                      $activeClass = isset($submenu->submenu) ? 'active open' : 'active';
                      break;
                  }
              }
          } else {
              if (str_starts_with($currentRouteName, $submenu->slug)) {
                  $activeClass = isset($submenu->submenu) ? 'active open' : 'active';
              }
          }
        ?>

        <li class="menu-item <?php echo e($activeClass); ?>">
            <a href="<?php echo e(isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)'); ?>" class="<?php echo e(isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link'); ?>" <?php if(isset($submenu->target) and !empty($submenu->target)): ?> target="_blank" <?php endif; ?>>
              <?php if(isset($submenu->icon)): ?>
              <i class="<?php echo e($submenu->icon); ?>"></i>
              <?php endif; ?>
              <div>
                  <?php
                      $translationKey = 'sidebar.' . $submenu->name;
                      $translatedName = __($translationKey);
                  ?>
                  
                  <?php echo e($translatedName !== $translationKey ? $translatedName : $submenu->name); ?>

              </div>
              <?php if(isset($submenu->badge)): ?>
                <div class="badge rounded-pill bg-<?php echo e($submenu->badge[0]); ?> text-uppercase ms-auto"><?php echo e($submenu->badge[1]); ?></div>
              <?php endif; ?>
            </a>

            
            <?php if(isset($submenu->submenu)): ?>
              <?php echo $__env->make('layouts.sections.menu.submenu',['menu' => $submenu->submenu], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>
</ul><?php /**PATH C:\laragon\www\RealEstate-Services-Platform\resources\views/layouts/sections/menu/submenu.blade.php ENDPATH**/ ?>