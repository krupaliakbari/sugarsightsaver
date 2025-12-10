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
        Account Settings
     <?php $__env->endSlot(); ?>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
     <?php $__env->slot('headerFiles', null, []); ?> 
        <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.css')); ?>">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/elements/alert.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss']); ?>
        <style>
            .widget-content-area {
                padding: 1.5rem;
            }
            .section-divider {
                border-bottom: 1px solid #e0e6ed;
                margin: 2rem 0;
                padding-bottom: 1rem;
            }
            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #3b3f5c;
                margin-bottom: 1.5rem;
            }
            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
                color: #3b3f5c;
            }
            .form-control, .form-select {
                border: 1px solid #d3d3d3;
                border-radius: 6px;
                padding: 0.75rem;
                font-size: 14px;
            }
            .form-control:focus, .form-select:focus {
                border-color: #4361ee;
                box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
            }
            .text-danger {
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
            .profile-image-preview {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid #e0e6ed;
            }
            .card-header {
                padding: 0.5rem 1rem !important;
                background-color: #6366f1 !important;
                border-bottom: 1px solid rgba(255,255,255,0.1);
                min-height: auto !important;
            }

            .card-header .card-title {
                margin-bottom: 0 !important;
                font-size: 0.9rem !important;
                font-weight: 600;
                color: #ffffff;
                line-height: 1.2 !important;
            }
        </style>
     <?php $__env->endSlot(); ?>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
        <!-- Start Row -->
        <div class="row mt-3" style="margin-left: 0; margin-right: 0;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding-left: 0; padding-right: 0;">
                <div class="widget-content widget-content-area br-8">

                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Account Settings</h4>
                    </div>

                    <!-- Alert Messages -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Profile Information Section -->
                    <div class="section-divider">

                         <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Profile Information</h5>
                                    </div>
                                    <div class="card-body">
                                            <form method="POST" action="<?php echo e(route('update-user-profile')); ?>" enctype="multipart/form-data" class="profileForm">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $userDetail->name ?? '')); ?>" placeholder="Enter full name">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" maxlength="10"
       oninput="validatePhoneInput(this)" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone', $userDetail->phone ?? '')); ?>" placeholder="Enter phone number">
                                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo e(old('email', $userDetail->email ?? '')); ?>" placeholder="Enter email address">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <?php if(Auth::user()->isDoctor()): ?>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="hospital_name" class="form-label">Hospital Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="hospital_name" name="hospital_name" value="<?php echo e(old('hospital_name', $userDetail->hospital_name ?? '')); ?>" placeholder="Enter hospital name">
                                            <?php $__errorArgs = ['hospital_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="doctor_type" class="form-label">Doctor Type</label>
                                            <select class="form-select" id="doctor_type" name="doctor_type" disabled>
                                                <option value="">Select Doctor Type</option>
                                                <option value="diabetes_treating" <?php echo e(($userDetail->doctor_type ?? '') == 'diabetes_treating' ? 'selected' : ''); ?>>Diabetes-Treating Physician</option>
                                                <option value="ophthalmologist" <?php echo e(($userDetail->doctor_type ?? '') == 'ophthalmologist' ? 'selected' : ''); ?>>Ophthalmologist</option>
                                            </select>
                                            <small class="form-text text-muted d-block mt-1">Doctor type cannot be changed after registration.</small>
                                            <?php $__errorArgs = ['doctor_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address"><?php echo e(old('address', $userDetail->address ?? '')); ?></textarea>
                                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="qualification" class="form-label">Qualification <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="qualification" name="qualification" rows="3" placeholder="Enter qualification"><?php echo e(old('qualification', $userDetail->qualification ?? '')); ?></textarea>
                                            <?php $__errorArgs = ['qualification'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="medical_council_registration_number" class="form-label">Medical Council Registration Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="medical_council_registration_number" name="medical_council_registration_number" value="<?php echo e(old('medical_council_registration_number', $userDetail->medical_council_registration_number ?? '')); ?>" placeholder="Enter registration number">
                                            <?php $__errorArgs = ['medical_council_registration_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                            <select class="form-select" id="state" name="state">
                                                <option value="">Select State</option>
                                                <option value="Andhra Pradesh" <?php echo e(old('state', $userDetail->state ?? '') == 'Andhra Pradesh' ? 'selected' : ''); ?>>Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh" <?php echo e(old('state', $userDetail->state ?? '') == 'Arunachal Pradesh' ? 'selected' : ''); ?>>Arunachal Pradesh</option>
                                                <option value="Assam" <?php echo e(old('state', $userDetail->state ?? '') == 'Assam' ? 'selected' : ''); ?>>Assam</option>
                                                <option value="Bihar" <?php echo e(old('state', $userDetail->state ?? '') == 'Bihar' ? 'selected' : ''); ?>>Bihar</option>
                                                <option value="Chhattisgarh" <?php echo e(old('state', $userDetail->state ?? '') == 'Chhattisgarh' ? 'selected' : ''); ?>>Chhattisgarh</option>
                                                <option value="Goa" <?php echo e(old('state', $userDetail->state ?? '') == 'Goa' ? 'selected' : ''); ?>>Goa</option>
                                                <option value="Gujarat" <?php echo e(old('state', $userDetail->state ?? '') == 'Gujarat' ? 'selected' : ''); ?>>Gujarat</option>
                                                <option value="Haryana" <?php echo e(old('state', $userDetail->state ?? '') == 'Haryana' ? 'selected' : ''); ?>>Haryana</option>
                                                <option value="Himachal Pradesh" <?php echo e(old('state', $userDetail->state ?? '') == 'Himachal Pradesh' ? 'selected' : ''); ?>>Himachal Pradesh</option>
                                                <option value="Jharkhand" <?php echo e(old('state', $userDetail->state ?? '') == 'Jharkhand' ? 'selected' : ''); ?>>Jharkhand</option>
                                                <option value="Karnataka" <?php echo e(old('state', $userDetail->state ?? '') == 'Karnataka' ? 'selected' : ''); ?>>Karnataka</option>
                                                <option value="Kerala" <?php echo e(old('state', $userDetail->state ?? '') == 'Kerala' ? 'selected' : ''); ?>>Kerala</option>
                                                <option value="Madhya Pradesh" <?php echo e(old('state', $userDetail->state ?? '') == 'Madhya Pradesh' ? 'selected' : ''); ?>>Madhya Pradesh</option>
                                                <option value="Maharashtra" <?php echo e(old('state', $userDetail->state ?? '') == 'Maharashtra' ? 'selected' : ''); ?>>Maharashtra</option>
                                                <option value="Manipur" <?php echo e(old('state', $userDetail->state ?? '') == 'Manipur' ? 'selected' : ''); ?>>Manipur</option>
                                                <option value="Meghalaya" <?php echo e(old('state', $userDetail->state ?? '') == 'Meghalaya' ? 'selected' : ''); ?>>Meghalaya</option>
                                                <option value="Mizoram" <?php echo e(old('state', $userDetail->state ?? '') == 'Mizoram' ? 'selected' : ''); ?>>Mizoram</option>
                                                <option value="Nagaland" <?php echo e(old('state', $userDetail->state ?? '') == 'Nagaland' ? 'selected' : ''); ?>>Nagaland</option>
                                                <option value="Odisha" <?php echo e(old('state', $userDetail->state ?? '') == 'Odisha' ? 'selected' : ''); ?>>Odisha</option>
                                                <option value="Punjab" <?php echo e(old('state', $userDetail->state ?? '') == 'Punjab' ? 'selected' : ''); ?>>Punjab</option>
                                                <option value="Rajasthan" <?php echo e(old('state', $userDetail->state ?? '') == 'Rajasthan' ? 'selected' : ''); ?>>Rajasthan</option>
                                                <option value="Sikkim" <?php echo e(old('state', $userDetail->state ?? '') == 'Sikkim' ? 'selected' : ''); ?>>Sikkim</option>
                                                <option value="Tamil Nadu" <?php echo e(old('state', $userDetail->state ?? '') == 'Tamil Nadu' ? 'selected' : ''); ?>>Tamil Nadu</option>
                                                <option value="Telangana" <?php echo e(old('state', $userDetail->state ?? '') == 'Telangana' ? 'selected' : ''); ?>>Telangana</option>
                                                <option value="Tripura" <?php echo e(old('state', $userDetail->state ?? '') == 'Tripura' ? 'selected' : ''); ?>>Tripura</option>
                                                <option value="Uttar Pradesh" <?php echo e(old('state', $userDetail->state ?? '') == 'Uttar Pradesh' ? 'selected' : ''); ?>>Uttar Pradesh</option>
                                                <option value="Uttarakhand" <?php echo e(old('state', $userDetail->state ?? '') == 'Uttarakhand' ? 'selected' : ''); ?>>Uttarakhand</option>
                                                <option value="West Bengal" <?php echo e(old('state', $userDetail->state ?? '') == 'West Bengal' ? 'selected' : ''); ?>>West Bengal</option>
                                                <option value="Andaman and Nicobar Islands" <?php echo e(old('state', $userDetail->state ?? '') == 'Andaman and Nicobar Islands' ? 'selected' : ''); ?>>Andaman and Nicobar Islands</option>
                                                <option value="Chandigarh" <?php echo e(old('state', $userDetail->state ?? '') == 'Chandigarh' ? 'selected' : ''); ?>>Chandigarh</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu" <?php echo e(old('state', $userDetail->state ?? '') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : ''); ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                                                <option value="Delhi" <?php echo e(old('state', $userDetail->state ?? '') == 'Delhi' ? 'selected' : ''); ?>>Delhi</option>
                                                <option value="Jammu and Kashmir" <?php echo e(old('state', $userDetail->state ?? '') == 'Jammu and Kashmir' ? 'selected' : ''); ?>>Jammu and Kashmir</option>
                                                <option value="Ladakh" <?php echo e(old('state', $userDetail->state ?? '') == 'Ladakh' ? 'selected' : ''); ?>>Ladakh</option>
                                                <option value="Lakshadweep" <?php echo e(old('state', $userDetail->state ?? '') == 'Lakshadweep' ? 'selected' : ''); ?>>Lakshadweep</option>
                                                <option value="Puducherry" <?php echo e(old('state', $userDetail->state ?? '') == 'Puducherry' ? 'selected' : ''); ?>>Puducherry</option>
                                            </select>
                                            <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>

                                        <div class="mb-3">
                                            <img src="<?php echo e($profilePath); ?>" alt="Profile Image" class="profile-image-preview" id="profileImagePreview">
                                        </div>

                                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/png,image/jpeg,image/jpg,image/gif">
                                        <small class="form-text text-muted d-block mt-1">Allowed file format: jpeg, jpg, png, gif.</small>
                                        <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save me-1">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                                    </div>
                                </div>

                     
                    <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                         <form method="POST" action="<?php echo e(route('user-update-password')); ?>" class="changepasswordForm">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password">
                                        <small class="form-text text-muted d-block mt-1">Password must be at least 8 characters long</small>
                                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password">
                                        <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save me-1">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Update Password
                                </button>
                            </div>
                        </form>
                                    </div>
                                </div>
                   

                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
     <?php $__env->slot('footerFiles', null, []); ?> 
        <script src="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.min.js')); ?>"></script>

        <script>
            // Auto-hide alerts after 3 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 3000);
                });

                // Hide validation errors on input
                const inputs = document.querySelectorAll('.form-control, .form-select, textarea');
                inputs.forEach(function(input) {
                    input.addEventListener('input', function() {
                        const formGroup = this.closest('.form-group');
                        if (formGroup) {
                            const errorElement = formGroup.querySelector('div.text-danger');
                            if (errorElement) {
                                errorElement.style.display = 'none';
                            }
                        }
                    });
                });

                // Profile image preview
                const profileImageInput = document.getElementById('profile_image');
                if (profileImageInput) {
                    profileImageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('profileImagePreview').src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });

                function validatePhoneInput(input) {
    // Remove non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, '');

    // Limit to 10 digits
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}
        </script>

     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/pages/user/account-settings.blade.php ENDPATH**/ ?>