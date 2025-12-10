<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base-layout','data' => ['scrollspy' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['scrollspy' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>

     <?php $__env->slot('pageTitle', null, []); ?> 
        <?php echo e($title); ?>

     <?php $__env->endSlot(); ?>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
     <?php $__env->slot('headerFiles', null, []); ?> 

     <?php $__env->endSlot(); ?>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->

    <!-- BREADCRUMB -->

    <?php
        $totalUsers = \App\Models\User::count();
       $activeDoctors = \App\Models\User::where('user_type', 'doctor')
                ->where('status', 'active')
                ->count();
        $adminUsers = \App\Models\User::role('admin')->count();
        $doctorUsers = \App\Models\User::role('doctor')->count();
        $patientUsers = \App\Models\Patient::count();
        $pendingDoctors = \App\Models\User::where('user_type', 'doctor')->where('approval_status', 'pending')->count();
        $approvedDoctors = \App\Models\User::where('user_type', 'doctor')->where('approval_status', 'approved')->count();
        $rejectedDoctors = \App\Models\User::where('user_type', 'doctor')->where('approval_status', 'rejected')->count();
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $todayUsers = \App\Models\User::whereDate('created_at', today())->count();
        $thisMonthUsers = \App\Models\User::whereMonth('created_at', now()->month)->count();
    ?>

    <div class="container-fluid mt-4">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-1">Welcome back, <?php echo e(auth()->user()->name); ?>!</h2>
                                <p class="text-muted mb-0">Here's what's happening with your Sugar Sight system today.</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="me-3">
                                        <h6 class="mb-0 text-muted">Last Login</h6>
                                        <small class="text-muted"><?php echo e(auth()->user()->updated_at->format('M d, Y H:i')); ?></small>
                                    </div>
                                    <div class="avatar avatar-lg">
                                        <?php if(auth()->user()->profile_image): ?>
                                            <img src="<?php echo e(url(auth()->user()->profile_image)); ?>" alt="Profile" class="rounded-circle">
                                        <?php else: ?>
                                            <div class="avatar-title bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                                <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Total Patients</h6>
                                <h3 class="mb-0 text-primary"><?php echo e(number_format($patientUsers)); ?></h3>
                                
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-primary bg-soft rounded">
                                    <i class="mdi mdi-account-group text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Active Doctors</h6>
                                <h3 class="mb-0 text-success"><?php echo e(number_format($activeDoctors)); ?></h3>
                                
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-success bg-soft rounded">
                                    <i class="mdi mdi-account-check text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Doctors</h6>
                                <h3 class="mb-0 text-info"><?php echo e(number_format($doctorUsers)); ?></h3>
                                
                                  
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-info bg-soft rounded">
                                    <i class="mdi mdi-doctor text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
                                
                            
        </div>

        <!-- Doctor Approval Status -->
        


    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/pages/dashboard/admin-dashboard.blade.php ENDPATH**/ ?>