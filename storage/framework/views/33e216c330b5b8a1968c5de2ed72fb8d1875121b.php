

<?php
    $isBoxed = layoutConfig()['boxed'];
    $isAltMenu = layoutConfig()['alt-menu']; 
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo e($pageTitle); ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(Vite::asset('resources/images/logo.png')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/custom.css')); ?>">
    <style>
        .btn-greencls{
    background-color: #634299 !important;
    font-size: 18px;
    line-height: 18px;
    border-radius: 8px !important;
    padding: 15px !important;
  }
  .swal2-icon.swal2-warning{
    border-color: #ff0000ba !important;
  color: #ff0000c7 !important;
  }
  .swal2-styled.swal2-confirm{
    background-color: #634299 !important;
    font-size: 18px;
    line-height: 18px;
    border-radius: 8px !important;
    padding: 15px !important;
  }
  .form-check-input.readonly{
    pointer-events: none;
        filter: none;
        opacity: .5;
    }
    </style>
    <script src="<?php echo e(asset('plugins/jquery-ui/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/alert-config.js')); ?>"></script>
    <script>
        // Simple auto-hide alerts function
        function autoHideAlerts() {
            const alerts = document.querySelectorAll('.alert:not(.alert-dismissible)');
            alerts.forEach((alert) => {
                // Check if it's a success or error alert
                if (alert.classList.contains('alert-success') || 
                    alert.classList.contains('alert-danger') || 
                    alert.classList.contains('alert-warning') || 
                    alert.classList.contains('alert-info')) {
                    
                    // Add dismissible functionality
                    alert.classList.add('alert-dismissible', 'fade', 'show');
                    
                    // Add close button
                    if (!alert.querySelector('.btn-close')) {
                        const closeButton = document.createElement('button');
                        closeButton.type = 'button';
                        closeButton.className = 'btn-close';
                        closeButton.setAttribute('data-bs-dismiss', 'alert');
                        closeButton.setAttribute('aria-label', 'Close');
                        alert.appendChild(closeButton);
                    }
                    
                    // Auto-hide after 5 seconds
                    setTimeout(() => {
                        if (alert && alert.parentNode) {
                            try {
                                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                                    const bsAlert = new bootstrap.Alert(alert);
                                    bsAlert.close();
                                } else {
                                    // Fallback: manually hide
                                    alert.style.opacity = '0';
                                    alert.style.transition = 'opacity 0.5s ease';
                                    setTimeout(() => {
                                        if (alert && alert.parentNode) {
                                            alert.parentNode.removeChild(alert);
                                        }
                                    }, 500);
                                }
                            } catch (error) {
                                // Fallback: manually hide
                                alert.style.opacity = '0';
                                alert.style.transition = 'opacity 0.5s ease';
                                setTimeout(() => {
                                    if (alert && alert.parentNode) {
                                        alert.parentNode.removeChild(alert);
                                    }
                                }, 500);
                            }
                        }
                    }, 5000);
                }
            });
        }
        
        // Run when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(autoHideAlerts, 100);
        });
        
        // Also run on window load
        window.addEventListener('load', function() {
            setTimeout(autoHideAlerts, 100);
        });
    </script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/layouts/siteadmin/light/loader.scss']); ?>

    <?php if(Request::is('siteadmin/*')): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/siteadmin/loader.js']); ?>
        
    <?php elseif((Request::is('modern-dark-menu/*'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/modern-dark-menu/loader.js']); ?>
    <?php elseif((Request::is('collapsible-menu/*'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/collapsible-menu/loader.js']); ?>
    <?php elseif((Request::is('horizontal-light-menu/*'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/horizontal-light-menu/loader.js']); ?>
    <?php elseif((Request::is('horizontal-dark-menu/*'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/horizontal-dark-menu/loader.js']); ?>
    <?php else: ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/siteadmin/loader.js']); ?>
    <?php endif; ?>
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap/bootstrap.min.css')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/main.scss', 'resources/scss/dark/assets/main.scss']); ?>

    <?php if(
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('doctor.login') &&
            !Request::routeIs('doctor.register') &&
            !Request::routeIs('doctor.register.show') &&
            !Request::routeIs('doctor.forgot-password') &&
            !Request::routeIs('doctor.reset-password') &&
            !Request::routeIs('doctor.logout') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('admin-login') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        ): ?>
        
        <?php if($scrollspy == 1): ?> 
            <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/scrollspyNav.scss', 'resources/scss/dark/assets/scrollspyNav.scss']); ?> 
        <?php endif; ?>
        
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/waves/waves.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/highlight/styles/monokai-sublime.css')); ?>">
        <?php echo app('Illuminate\Foundation\Vite')([ 'resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss']); ?>


        <?php if(Request::is('siteadmin/*')): ?>

            <?php echo app('Illuminate\Foundation\Vite')([
                'resources/scss/layouts/siteadmin/light/structure.scss',
                'resources/scss/layouts/siteadmin/dark/structure.scss',
            ]); ?>
        
        <?php elseif((Request::is('modern-dark-menu/*'))): ?>
        
            <?php echo app('Illuminate\Foundation\Vite')([
                'resources/scss/layouts/modern-dark-menu/light/structure.scss',
                'resources/scss/layouts/modern-dark-menu/dark/structure.scss',
            ]); ?>
        
        <?php elseif((Request::is('collapsible-menu/*'))): ?>
        
            <?php echo app('Illuminate\Foundation\Vite')([
                'resources/scss/layouts/collapsible-menu/light/structure.scss',
                'resources/scss/layouts/collapsible-menu/dark/structure.scss',
            ]); ?>

        <?php elseif(Request::is('horizontal-light-menu/*')): ?>

            <?php echo app('Illuminate\Foundation\Vite')([
                'resources/scss/layouts/horizontal-light-menu/light/structure.scss',
                'resources/scss/layouts/horizontal-light-menu/dark/structure.scss',
            ]); ?>

        <?php elseif(Request::is('horizontal-dark-menu/*')): ?>

            <?php echo app('Illuminate\Foundation\Vite')([
                'resources/scss/layouts/horizontal-dark-menu/light/structure.scss',
                'resources/scss/layouts/horizontal-dark-menu/dark/structure.scss',
            ]); ?>

        <?php else: ?>

            <?php echo app('Illuminate\Foundation\Vite')([
                'resources/scss/layouts/siteadmin/light/structure.scss',
                'resources/scss/layouts/siteadmin/dark/structure.scss',
            ]); ?>
        
        <?php endif; ?>

    <?php endif; ?>
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <?php echo e($headerFiles); ?>

    <!-- END GLOBAL MANDATORY STYLES -->
</head>
<body class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        // 'layout-dark' => $isDark,
        'layout-boxed' => $isBoxed,
        'alt-menu' => ($isAltMenu || Request::routeIs('collapsibleMenu') ? true : false),
        'error' => (Request::routeIs('404') ? true : false),
        'maintanence' => (Request::routeIs('maintenance') ? true : false),
    ]) ?>" 
    <?php if($scrollspy == 1): ?> 
        <?php echo e($scrollspyConfig); ?> 
    <?php else: ?> 
        <?php echo e(''); ?> 
    <?php endif; ?>   
    <?php if(Request::routeIs('fullWidth')): ?> 
        layout="full-width"  
    <?php endif; ?> 
>

    <!-- BEGIN LOADER -->
    <?php if (isset($component)) { $__componentOriginal0800e6988afd7d5f81e6d1cbc047e89ffc16d781 = $component; } ?>
<?php $component = App\View\Components\LayoutLoader::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout-loader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\LayoutLoader::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0800e6988afd7d5f81e6d1cbc047e89ffc16d781)): ?>
<?php $component = $__componentOriginal0800e6988afd7d5f81e6d1cbc047e89ffc16d781; ?>
<?php unset($__componentOriginal0800e6988afd7d5f81e6d1cbc047e89ffc16d781); ?>
<?php endif; ?>
    <!--  END LOADER -->

    

    <?php if(
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('doctor.login') &&
            !Request::routeIs('doctor.register') &&
            !Request::routeIs('doctor.register.show') &&
            !Request::routeIs('doctor.forgot-password') &&
            !Request::routeIs('doctor.reset-password') &&
            !Request::routeIs('doctor.logout') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('admin-login') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        ): ?>

        <?php if(!Request::routeIs('blank')): ?>

            <?php if(Request::is('siteadmin/*')): ?>

                <!--  BEGIN NAVBAR  -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar.style-vertical-menu','data' => ['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar.style-vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!--  END NAVBAR  -->
            
            <?php elseif((Request::is('modern-dark-menu/*'))): ?>

                <!--  BEGIN NAVBAR  -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar.style-vertical-menu','data' => ['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar.style-vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!--  END NAVBAR  -->
            
            <?php elseif((Request::is('collapsible-menu/*'))): ?>

                <!--  BEGIN NAVBAR  -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar.style-vertical-menu','data' => ['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar.style-vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!--  END NAVBAR  -->

            <?php elseif(Request::is('horizontal-light-menu/*')): ?>

                <!--  BEGIN NAVBAR  -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar.style-horizontal-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar.style-horizontal-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!--  END NAVBAR  -->
            
            <?php elseif(Request::is('horizontal-dark-menu/*')): ?>

                <!--  BEGIN NAVBAR  -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar.style-horizontal-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar.style-horizontal-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!--  END NAVBAR  -->

            <?php else: ?>

                <!--  BEGIN NAVBAR  -->
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar.style-vertical-menu','data' => ['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('navbar.style-vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['classes' => ''.e(($isBoxed ? 'container-xxl' : '')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <!--  END NAVBAR  -->
                
            <?php endif; ?>
        
        <?php endif; ?>

        <!--  BEGIN MAIN CONTAINER  -->
        <div class="main-container " id="container">
            
            <!--  BEGIN LOADER  -->
            <?php if (isset($component)) { $__componentOriginal8144c93769301dcdfd69c0a4ac144249a9501088 = $component; } ?>
<?php $component = App\View\Components\LayoutOverlay::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\LayoutOverlay::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8144c93769301dcdfd69c0a4ac144249a9501088)): ?>
<?php $component = $__componentOriginal8144c93769301dcdfd69c0a4ac144249a9501088; ?>
<?php unset($__componentOriginal8144c93769301dcdfd69c0a4ac144249a9501088); ?>
<?php endif; ?>
            <!--  END LOADER  -->

            <?php if(!Request::routeIs('blank')): ?> 

                <?php if(Request::is('siteadmin/*')): ?>

                    <!--  BEGIN SIDEBAR  -->
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu.vertical-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu.vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <!--  END SIDEBAR  --> 
                
                <?php elseif((Request::is('modern-dark-menu/*'))): ?>

                    <!--  BEGIN SIDEBAR  -->
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu.vertical-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu.vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <!--  END SIDEBAR  --> 
                
                <?php elseif((Request::is('collapsible-menu/*'))): ?>

                    <!--  BEGIN SIDEBAR  -->
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu.vertical-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu.vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <!--  END SIDEBAR  --> 

                <?php elseif(Request::is('horizontal-light-menu/*')): ?>

                    <!--  BEGIN SIDEBAR  -->
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu.horizontal-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu.horizontal-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <!--  END SIDEBAR  --> 
                
                <?php elseif(Request::is('horizontal-dark-menu/*')): ?>

                    <!--  BEGIN SIDEBAR  -->
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu.horizontal-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu.horizontal-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <!--  END SIDEBAR  --> 
                
                <?php else: ?>
                
                    <!--  BEGIN SIDEBAR  -->
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu.vertical-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('menu.vertical-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <!--  END SIDEBAR  --> 
                    
                <?php endif; ?>
              
            <?php endif; ?>

            
            
            <!--  BEGIN CONTENT AREA  -->
            <div id="content" class="main-content <?php echo e((Request::routeIs('blank') ? 'ms-0 mt-0' : '')); ?>">

                <?php if($scrollspy == 1): ?>
                    <div class="container">
                        <div class="container">
                            <?php echo e($slot); ?>

                        </div>
                    </div>                
                <?php else: ?>
                    <div class="layout-px-spacing">
                        <div class="middle-content <?php echo e(($isBoxed ? 'container-xxl' : '')); ?> p-0">
                            <?php echo e($slot); ?>

                        </div>
                    </div>
                <?php endif; ?>

                <!--  BEGIN FOOTER  -->
                <?php if (isset($component)) { $__componentOriginalc0f60b7ea7a830244b5c337bb1aea5348a11046a = $component; } ?>
<?php $component = App\View\Components\LayoutFooter::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\LayoutFooter::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc0f60b7ea7a830244b5c337bb1aea5348a11046a)): ?>
<?php $component = $__componentOriginalc0f60b7ea7a830244b5c337bb1aea5348a11046a; ?>
<?php unset($__componentOriginalc0f60b7ea7a830244b5c337bb1aea5348a11046a); ?>
<?php endif; ?>
                <!--  END FOOTER  -->
                
            </div>
            <!--  END CONTENT AREA  -->

        </div>
        <!--  END MAIN CONTAINER  -->
        
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>

    <?php if(
            !Request::routeIs('404') &&
            !Request::routeIs('maintenance') &&
            !Request::routeIs('signin') &&
            !Request::routeIs('doctor.login') &&
            !Request::routeIs('doctor.register') &&
            !Request::routeIs('doctor.register.show') &&
            !Request::routeIs('doctor.forgot-password') &&
            !Request::routeIs('doctor.reset-password') &&
            !Request::routeIs('doctor.logout') &&
            !Request::routeIs('signup') &&
            !Request::routeIs('admin-login') &&
            !Request::routeIs('lockscreen') &&
            !Request::routeIs('password-reset') &&
            !Request::routeIs('2Step') &&

            // Real Logins
            !Request::routeIs('login')
        ): ?>
        
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <script src="<?php echo e(asset('plugins/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/mousetrap/mousetrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/waves/waves.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/highlight/highlight.pack.js')); ?>"></script>
        
        <?php if($scrollspy == 1): ?> 
            <?php echo app('Illuminate\Foundation\Vite')(['resources/assets/js/scrollspyNav.js']); ?> 
        <?php endif; ?>

        <?php if(Request::is('siteadmin/*')): ?>
            <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/siteadmin/app.js']); ?>
        <?php elseif((Request::is('modern-dark-menu/*'))): ?>
            <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/modern-dark-menu/app.js']); ?>
        <?php elseif((Request::is('collapsible-menu/*'))): ?>
            <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/collapsible-menu/app.js']); ?>
        <?php elseif(Request::is('horizontal-light-menu/*')): ?>
            <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/horizontal-light-menu/app.js']); ?>
        <?php elseif(Request::is('horizontal-dark-menu/*')): ?>
            <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/horizontal-dark-menu/app.js']); ?>
        <?php else: ?> 
            <?php echo app('Illuminate\Foundation\Vite')(['resources/layouts/siteadmin/app.js']); ?>
        <?php endif; ?>
        <!-- END GLOBAL MANDATORY STYLES -->

    <?php endif; ?>
         
        <?php echo e($footerFiles ?? ''); ?>

</body>
</html><?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/components/base-layout.blade.php ENDPATH**/ ?>