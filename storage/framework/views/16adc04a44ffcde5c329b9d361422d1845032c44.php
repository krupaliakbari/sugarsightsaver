<?php if (isset($component)) { $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a = $component; } ?>
<?php $component = App\View\Components\BaseLayout::resolve(['scrollspy' => false] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\BaseLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

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
    $doctorId = Auth::id();
    
    $totalAppointments = \App\Models\PatientAppointment::where('doctor_id', $doctorId)->count();
    
    // Get patient IDs from this doctor's appointments, then count unique patients
    $patientIds = \App\Models\PatientAppointment::where('doctor_id', $doctorId)
                 ->pluck('patient_id')
                 ->unique();
    $totalPatients = $patientIds->count();
    
    $todayAppointments = \App\Models\PatientAppointment::where('doctor_id', $doctorId)
                        ->whereDate('visit_date_time', today())
                        ->count();
?>



    <!-- Status Cards -->
    <div class="row mt-3">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="status-card approved">
                 <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Total Patients</h6>
                                <h3 class="mb-0 text-success"><?php echo e(number_format($totalPatients)); ?></h3>
                                
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

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="info-card">
                 <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Total Appointments</h6>
                                <h3 class="mb-0 text-primary"><?php echo e(number_format($totalAppointments)); ?></h3>
                                
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

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="info-card">
                <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Today’s Appointments </h6>
                                <h3 class="mb-0 text-info"><?php echo e(number_format($todayAppointments)); ?></h3>
                                
                                  
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

    <!-- Profile Information Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="padding: 0.5rem 1rem;">
                    <h4 style="margin: 0; font-size: 1rem;"><i class="fas fa-user-circle me-2"></i>Profile Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Full Name</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->name); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Email Address</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->email); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Phone Number</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->phone); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Address</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->address); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-certificate text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Qualification</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->qualification); ?></p>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-certificate text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Hospital</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->hospital_name); ?></p>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-certificate text-primary"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold mb-1">Specialization</label>
                                    <p class="mb-0 text-muted"><?php echo e(Auth::user()->doctor_type_display); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Alerts -->
    <?php if(Auth::user()->isPending()): ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert-card warning">
                <div class="alert-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="alert-content">
                    <h4>Account Pending Approval</h4>
                    <p>Your account is currently pending approval from the administrator. You will be notified once your account is approved and you can access all features.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(Auth::user()->approval_status === 'rejected'): ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert-card danger">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <h4>Account Rejected</h4>
                    <p>Your account has been rejected. Reason: <?php echo e(Auth::user()->rejection_reason ?? 'No reason provided'); ?></p>
                    <p>Please contact the administrator for more information.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a)): ?>
<?php $component = $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a; ?>
<?php unset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ANZO-KRUPALI\Desktop\sugarsightsaver1\resources\views/doctor/dashboard.blade.php ENDPATH**/ ?>