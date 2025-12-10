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
        <link rel="stylesheet" href="<?php echo e(asset('plugins/notification/snackbar/snackbar.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/flatpickr/flatpickr.css')); ?>">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/components/tabs.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/elements/alert.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss']); ?>

        <style>
            /* Flatpickr input styling */
            .flatpickr-input {
                cursor: pointer;
            }

            /* Compact card headers */
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

            /* Make form labels same size as card title */
            .form-label {
                font-size: 0.9rem !important;
            }
        </style>
     <?php $__env->endSlot(); ?>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h4 class="mb-4">
                            <?php echo e($title); ?>

                        </h4>

                        <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger"><?php echo e(session()->get('error')); ?></div>
                        <?php endif; ?>

                        <?php if(session()->has('success')): ?>
                            <div class="alert alert-success"><?php echo e(session()->get('success')); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('doctor.patients.store-patient')); ?>" id="addPatientForm">
                            <?php echo csrf_field(); ?>

                            <!-- Visit Date and Time -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Visit Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="visit_date_time" class="form-label">Visit Date And Time <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control flatpickr-input" id="visit_date_time" name="visit_date_time"
                                                       value="<?php echo e(old('visit_date_time', now()->format('d-m-Y H:i'))); ?>" placeholder="Select Date & Time">
                                                <?php $__errorArgs = ['visit_date_time'];
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
                                </div>
                            </div>

                            <!-- Basic Profile Details -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Basic Profile Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                                       value="<?php echo e(old('mobile_number', $mobileNumber)); ?>" pattern="[0-9]*" inputmode="numeric" maxlength="10">
                                                <?php $__errorArgs = ['mobile_number'];
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
                                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="<?php echo e(old('name')); ?>">
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
                                                <label for="diabetes_from" class="form-label">Diabetes Since </label>
                                                <input type="text" class="form-control flatpickr-input" id="diabetes_from" name="diabetes_from"
                                                       value="<?php echo e(old('diabetes_from')); ?>" placeholder="Select Month & Year">
                                                <?php $__errorArgs = ['diabetes_from'];
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
                                                <label class="form-label">Diabetes Duration<span class="text-danger">*</span></label>
                                                
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="diabetes_years" name="diabetes_years"
                                                               value="<?php echo e(old('diabetes_years')); ?>" placeholder="Years" min="0" max="100">
                                                               <?php $__errorArgs = ['diabetes_years'];
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
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="diabetes_months" name="diabetes_months"
                                                               value="<?php echo e(old('diabetes_months')); ?>" placeholder="Months" min="0" max="11">
                                                                <?php $__errorArgs = ['diabetes_months'];
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
                                                <small class="text-muted">Enter number of years and months since diabetes diagnosis</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="date_of_birth" class="form-label">Date Of Birth </label>
                                                <input type="text" class="form-control flatpickr-input" id="date_of_birth" name="date_of_birth"
                                                       value="<?php echo e(old('date_of_birth')); ?>" placeholder="Select Date of Birth">
                                                <?php $__errorArgs = ['date_of_birth'];
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
                                                <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="age" name="age"
                                                       value="<?php echo e(old('age')); ?>" min="1" max="120">
                                                <?php $__errorArgs = ['age'];
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
                                                <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                                <select class="form-select" id="sex" name="sex">
                                                    <option value="">Select Sex</option>
                                                    <option value="male" <?php echo e(old('sex') == 'male' ? 'selected' : ''); ?>>Male</option>
                                                    <option value="female" <?php echo e(old('sex') == 'female' ? 'selected' : ''); ?>>Female</option>
                                                    <option value="other" <?php echo e(old('sex') == 'other' ? 'selected' : ''); ?>>Other</option>
                                                </select>
                                                <?php $__errorArgs = ['sex'];
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
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="short_address" class="form-label">Short Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="short_address" name="short_address" rows="2"><?php echo e(old('short_address')); ?></textarea>
                                                <?php $__errorArgs = ['short_address'];
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
                                                <label for="hospital_id" class="form-label">Hospital ID</label>
                                                <input type="text" class="form-control" id="hospital_id" name="hospital_id"
                                                       value="<?php echo e(old('hospital_id')); ?>">
                                                <?php $__errorArgs = ['hospital_id'];
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
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       value="<?php echo e(old('email')); ?>">
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
                                                <div class="text-danger" id="email-error" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Treatment Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Treatment Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="row">
    <!-- On Treatment -->
 <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">On Treatment? <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="on_treatment" id="on_treatment_yes" value="1" <?php echo e(old('on_treatment') == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="on_treatment_yes">On Treatment</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="on_treatment" id="on_treatment_no" value="0" <?php echo e(old('on_treatment') == '0' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="on_treatment_no">Not On Treatment</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['on_treatment'];
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
                                        <div class="col-md-6" id="type_of_treatment_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Type Of Treatment <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="allopathic" value="allopathic" <?php echo e(in_array('allopathic', old('type_of_treatment', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="allopathic">Allopathic</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="diet_control" value="diet_control" <?php echo e(in_array('diet_control', old('type_of_treatment', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="diet_control">Diet Control</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="ayurvedic" value="ayurvedic" <?php echo e(in_array('ayurvedic', old('type_of_treatment', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="ayurvedic">Ayurvedic</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="others_treatment" value="others" <?php echo e(in_array('others', old('type_of_treatment', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="others_treatment">Others</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['type_of_treatment'];
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
                                        <div class="col-md-6" id="type_of_treatment_other_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label for="type_of_treatment_other" class="form-label">Specify Other Treatment <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="type_of_treatment_other" name="type_of_treatment_other"
                                                       value="<?php echo e(old('type_of_treatment_other')); ?>" placeholder="Enter other treatment type">
                                                <?php $__errorArgs = ['type_of_treatment_other'];
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
                                                <label class="form-label">BP <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bp" id="bp_yes" value="1" <?php echo e(old('bp') == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="bp_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bp" id="bp_no" value="0" <?php echo e(old('bp') == '0' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="bp_no">No</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['bp'];
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
                                        <div class="col-md-6" id="bp_since_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label for="bp_since" class="form-label">BP Since </label>
                                                <input type="text" class="form-control flatpickr-input" id="bp_since" name="bp_since"
                                                       value="<?php echo e(old('bp_since')); ?>" placeholder="Select Month & Year">
                                                <?php $__errorArgs = ['bp_since'];
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
                                        <div class="col-md-6" id="bp_duration_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label class="form-label">BP Duration <span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="bp_years" name="bp_years"
                                                               value="<?php echo e(old('bp_years')); ?>" placeholder="Years" min="0" max="100">
                                                                <?php $__errorArgs = ['bp_years'];
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
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="bp_months" name="bp_months"
                                                               value="<?php echo e(old('bp_months')); ?>" placeholder="Months" min="0" max="11">
                                                                <?php $__errorArgs = ['bp_months'];
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
                                                
                                                <small class="text-muted">Enter number of years and months since BP diagnosis</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Diseases -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Other Diseases</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Any Other Diseases</label>
                                                <div class="mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="heart_disease" value="heart_disease" <?php echo e(in_array('heart_disease', old('other_diseases', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="heart_disease">Heart Disease</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="cholesterol" value="cholesterol" <?php echo e(in_array('cholesterol', old('other_diseases', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="cholesterol">Cholesterol</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="thyroid" value="thyroid" <?php echo e(in_array('thyroid', old('other_diseases', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="thyroid">Thyroid</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="stroke" value="stroke" <?php echo e(in_array('stroke', old('other_diseases', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="stroke">Stroke</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="others_diseases" value="others" <?php echo e(in_array('others', old('other_diseases', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="others_diseases">Others</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['other_diseases'];
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
                                        <div class="col-md-12" id="other_diseases_other_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label for="other_diseases_other" class="form-label">Specify Other Disease <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="other_diseases_other" name="other_diseases_other"
                                                       value="<?php echo e(old('other_diseases_other')); ?>" placeholder="Enter other disease">
                                                <?php $__errorArgs = ['other_diseases_other'];
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
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="other_input" class="form-label">Any Other Input</label>
                                                <textarea class="form-control" id="other_input" name="other_input" rows="2"><?php echo e(old('other_input')); ?></textarea>
                                                <?php $__errorArgs = ['other_input'];
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
                                </div>
                            </div>

                            <!-- Physical Measurements -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Physical Measurements</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-2">
    <div class="form-group mb-3">
        <label class="form-label d-block">Choose Unit</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="height_unit" id="unit_meter" value="meter" 
                   <?php echo e(old('height_unit', 'meter') == 'meter' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="unit_meter">Meter</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="height_unit" id="unit_feet" value="feet"
                   <?php echo e(old('height_unit', 'meter') == 'feet' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="unit_feet">Feet</label>
        </div>
        <?php $__errorArgs = ['height_unit'];
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

<div class="col-md-2">
    <div class="form-group mb-3">
        <label for="height" class="form-label">
            Height
            <span id="height-unit-display">(in <?php echo e(old('height_unit', 'meter') == 'feet' ? 'Feet' : 'Meters'); ?>)</span>
        </label>
        <input type="number"
               class="form-control"
               id="height"
               name="height"
               value="<?php echo e(old('height')); ?>"
               step="0.01"
               placeholder="<?php echo e(old('height_unit', 'meter') == 'feet' ? 'e.g., 5.9' : 'e.g., 1.75'); ?>"
               min="<?php echo e(old('height_unit', 'meter') == 'feet' ? '2.0' : '0.5'); ?>"
               max="<?php echo e(old('height_unit', 'meter') == 'feet' ? '9.0' : '3.0'); ?>">
        <small class="text-muted" id="height-hint">
            <?php echo e(old('height_unit', 'meter') == 'feet' ? 'Range: 2.0 – 9.0 feet' : 'Range: 0.5 – 3.0 meters'); ?>

        </small>
        <?php $__errorArgs = ['height'];
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
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label for="weight" class="form-label">Weight (In Kg)</label>
                                                <input type="number" class="form-control" id="weight" name="weight"
                                                       value="<?php echo e(old('weight')); ?>" step="0.01" min="10" max="500">
                                                <?php $__errorArgs = ['weight'];
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
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label for="bmi" class="form-label">BMI</label>
                                                <input type="text" class="form-control" id="bmi" name="bmi" readonly>
                                                <div class="mt-2">
                                                    <button type="button" id="bmi-btn-underweight" class="btn btn-sm btn-outline-secondary" style="display: none; pointer-events: none;">Underweight</button>
                                                    <button type="button" id="bmi-btn-normal" class="btn btn-sm btn-outline-secondary" style="display: none; pointer-events: none;">Normal Weight</button>
                                                    <button type="button" id="bmi-btn-overweight" class="btn btn-sm btn-outline-secondary" style="display: none; pointer-events: none;">Overweight</button>
                                                    <button type="button" id="bmi-btn-obesity1" class="btn btn-sm btn-outline-secondary" style="display: none; pointer-events: none;">Obesity Grade 1</button>
                                                    <button type="button" id="bmi-btn-obesity2" class="btn btn-sm btn-outline-secondary" style="display: none; pointer-events: none;">Obesity Grade 2</button>
                                                    <button type="button" id="bmi-btn-obesity3" class="btn btn-sm btn-outline-secondary" style="display: none; pointer-events: none;">Obesity Grade 3</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">BMI Range Interpretation</label>
                                                <table class="table table-bordered table-sm mb-0" style="font-size: 0.75rem; margin-bottom: 0;">
                                                    <thead>
                                                        <tr style="line-height: 1.2;">
                                                            <th style="padding: 0.25rem 0.5rem;">BMI Range</th>
                                                            <th style="padding: 0.25rem 0.5rem;">Interpretation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="line-height: 1.2;">
                                                            <td style="padding: 0.25rem 0.5rem;">&lt; 18.5</td>
                                                            <td style="padding: 0.25rem 0.5rem;">Underweight</td>
                                                        </tr>
                                                        <tr style="line-height: 1.2;">
                                                            <td style="padding: 0.25rem 0.5rem;">18.5 – 22.9</td>
                                                            <td style="padding: 0.25rem 0.5rem;">Normal Weight</td>
                                                        </tr>
                                                        <tr style="line-height: 1.2;">
                                                            <td style="padding: 0.25rem 0.5rem;">23.0 – 24.9</td>
                                                            <td style="padding: 0.25rem 0.5rem;">Overweight</td>
                                                        </tr>
                                                        <tr style="line-height: 1.2;">
                                                            <td style="padding: 0.25rem 0.5rem;">25.0 – 29.9</td>
                                                            <td style="padding: 0.25rem 0.5rem;">Obesity Grade 1</td>
                                                        </tr>
                                                        <tr style="line-height: 1.2;">
                                                            <td style="padding: 0.25rem 0.5rem;">30.0 – 34.9</td>
                                                            <td style="padding: 0.25rem 0.5rem;">Obesity Grade 2</td>
                                                        </tr>
                                                        <tr style="line-height: 1.2;">
                                                            <td style="padding: 0.25rem 0.5rem;">&gt; 35</td>
                                                            <td style="padding: 0.25rem 0.5rem;">Obesity Grade 3</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="<?php echo e(route('doctor.patients.add-appointment')); ?>" class="btn btn-light">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Save and Continue
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
     <?php $__env->slot('footerFiles', null, []); ?> 
        <script src="<?php echo e(asset('plugins/notification/snackbar/snackbar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/flatpickr/flatpickr.js')); ?>"></script>

        <script>
            // BMI Calculation
            // Height unit conversion and BMI calculation for Add Patient
const heightInput = document.getElementById('height');
const weightInput = document.getElementById('weight');
const bmiInput = document.getElementById('bmi');
const unitMeter = document.getElementById('unit_meter');
const unitFeet = document.getElementById('unit_feet');
const unitDisplay = document.getElementById('height-unit-display');
const heightHint = document.getElementById('height-hint');

function updateHeightConstraints() {
    if (unitFeet.checked) {
        // Feet configuration
        heightInput.setAttribute('min', '2.0');
        heightInput.setAttribute('max', '9.0');
        heightInput.setAttribute('step', '0.1');
        heightInput.setAttribute('placeholder', 'e.g., 5.9');
        unitDisplay.textContent = '(in Feet)';
        heightHint.textContent = 'Range: 2.0 – 9.0 feet';
    } else {
        // Meter configuration
        heightInput.setAttribute('min', '0.5');
        heightInput.setAttribute('max', '3.0');
        heightInput.setAttribute('step', '0.01');
        heightInput.setAttribute('placeholder', 'e.g., 1.75');
        unitDisplay.textContent = '(in Meters)';
        heightHint.textContent = 'Range: 0.5 – 3.0 meters';
    }
    calculateBMI();
}

function calculateBMI() {
    const height = parseFloat(heightInput.value);
    const weight = parseFloat(weightInput.value);
    const unit = document.querySelector('input[name="height_unit"]:checked')?.value || 'meter';

    // Hide all BMI category buttons
    document.querySelectorAll('[id^="bmi-btn-"]').forEach(btn => {
        btn.style.display = 'none';
        btn.classList.remove('btn-info', 'btn-success', 'btn-warning', 'btn-danger');
        btn.classList.add('btn-outline-secondary');
    });

    if (!height || !weight || height <= 0 || weight <= 0) {
        bmiInput.value = '';
        return;
    }

    // Convert height to meters for BMI calculation (SAME as PHP calculation)
    let heightInMeters = unit === 'feet' ? height * 0.3048 : height;

    // Calculate BMI (SAME formula as PHP)
    const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(2);
    bmiInput.value = bmi;

    // Show correct BMI category
    let btnId = '';
    let btnClass = '';

    if (bmi < 18.5) {
        btnId = 'bmi-btn-underweight';
        btnClass = 'btn-info';
    } else if (bmi <= 22.9) {
        btnId = 'bmi-btn-normal';
        btnClass = 'btn-success';
    } else if (bmi <= 24.9) {
        btnId = 'bmi-btn-overweight';
        btnClass = 'btn-warning';
    } else if (bmi <= 29.9) {
        btnId = 'bmi-btn-obesity1';
        btnClass = 'btn-danger';
    } else if (bmi <= 34.9) {
        btnId = 'bmi-btn-obesity2';
        btnClass = 'btn-danger';
    } else {
        btnId = 'bmi-btn-obesity3';
        btnClass = 'btn-danger';
    }

    const btn = document.getElementById(btnId);
    if (btn) {
        btn.style.display = 'inline-block';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add(btnClass);
    }
}

// Event listeners for unit change
if (unitMeter) {
    unitMeter.addEventListener('change', updateHeightConstraints);
}

if (unitFeet) {
    unitFeet.addEventListener('change', updateHeightConstraints);
}

// Event listeners for BMI calculation
if (heightInput) {
    heightInput.addEventListener('input', calculateBMI);
}

if (weightInput) {
    weightInput.addEventListener('input', calculateBMI);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateHeightConstraints();
    calculateBMI();
});
            // BP Since field toggle
            function toggleBPSince() {
                const bpYes = document.getElementById('bp_yes');
                const bpSinceContainer = document.getElementById('bp_since_container');
                const bpDurationContainer = document.getElementById('bp_duration_container');

                if (bpYes && bpYes.checked) {
                    if (bpSinceContainer) bpSinceContainer.style.display = 'block';
                    if (bpDurationContainer) bpDurationContainer.style.display = 'block';
                } else {
                    if (bpSinceContainer) bpSinceContainer.style.display = 'none';
                    if (bpDurationContainer) bpDurationContainer.style.display = 'none';
                    // Clear BP fields when hidden
                    const bpSinceField = document.getElementById('bp_since');
                    const bpYearsField = document.getElementById('bp_years');
                    const bpMonthsField = document.getElementById('bp_months');
                    if (bpSinceField) bpSinceField.value = '';
                    if (bpYearsField) bpYearsField.value = '';
                    if (bpMonthsField) bpMonthsField.value = '';
                }
            }

            // Type of Treatment "Others" field toggle
            function toggleTypeOfTreatmentOther() {
                const othersCheckbox = document.getElementById('others_treatment');
                const otherContainer = document.getElementById('type_of_treatment_other_container');
                const otherInput = document.getElementById('type_of_treatment_other');

                if (othersCheckbox && othersCheckbox.checked) {
                    otherContainer.style.display = 'block';
                } else {
                    otherContainer.style.display = 'none';
                    if (otherInput) otherInput.value = '';
                }
            }

            // Other Diseases "Others" field toggle
            function toggleOtherDiseasesOther() {
                const othersCheckbox = document.getElementById('others_diseases');
                const otherContainer = document.getElementById('other_diseases_other_container');
                const otherInput = document.getElementById('other_diseases_other');

                if (othersCheckbox && othersCheckbox.checked) {
                    otherContainer.style.display = 'block';
                } else {
                    otherContainer.style.display = 'none';
                    if (otherInput) otherInput.value = '';
                }
            }

            // Add event listeners for BP radio buttons
            document.addEventListener('DOMContentLoaded', function() {
                const bpYes = document.getElementById('bp_yes');
                const bpNo = document.getElementById('bp_no');

                if (bpYes) {
                    bpYes.addEventListener('change', toggleBPSince);
                }

                if (bpNo) {
                    bpNo.addEventListener('change', toggleBPSince);
                }

                // Check on page load if BP is already selected
                toggleBPSince();

                // Add event listener for type of treatment "Others" checkbox
                const othersTreatment = document.getElementById('others_treatment');
                if (othersTreatment) {
                    othersTreatment.addEventListener('change', toggleTypeOfTreatmentOther);
                    // Check on page load
                    toggleTypeOfTreatmentOther();
                }

                // Add event listener for other diseases "Others" checkbox
                const othersDiseases = document.getElementById('others_diseases');
                if (othersDiseases) {
                    othersDiseases.addEventListener('change', toggleOtherDiseasesOther);
                    // Check on page load
                    toggleOtherDiseasesOther();
                }
            });

            // Clear validation errors when user interacts with fields
            document.addEventListener('DOMContentLoaded', function() {
                // Get all form inputs, selects, and textareas
                const formFields = document.querySelectorAll('#addPatientForm input, #addPatientForm select, #addPatientForm textarea');

                formFields.forEach(function(field) {
                    // Add event listeners for input, change, and blur events
                    field.addEventListener('input', function() {
                        clearFieldError(this);
                    });

                    field.addEventListener('change', function() {
                        clearFieldError(this);
                    });
                });

                // Function to clear error message for a specific field
                function clearFieldError(field) {
                    const formGroup = field.closest('.form-group');
                    if (formGroup) {
                        const errorMessage = formGroup.querySelector('div.text-danger');
                        if (errorMessage && field.value.trim() !== '') {
                            errorMessage.style.display = 'none';
                        }
                    }
                }

                // Special handling for radio buttons and checkboxes
                const radioCheckboxes = document.querySelectorAll('#addPatientForm input[type="radio"], #addPatientForm input[type="checkbox"]');
                radioCheckboxes.forEach(function(field) {
                    field.addEventListener('change', function() {
                        const formGroup = this.closest('.form-group');
                        if (formGroup) {
                            const errorMessage = formGroup.querySelector('div.text-danger');
                            if (errorMessage) {
                                errorMessage.style.display = 'none';
                            }
                        }
                    });
                });

                // Email validation
                const emailField = document.getElementById('email');
                const emailError = document.getElementById('email-error');

                if (emailField && emailError) {
                    emailField.addEventListener('input', function() {
                        validateEmail();
                    });

                    emailField.addEventListener('blur', function() {
                        validateEmail();
                    });

                    function validateEmail() {
                        const email = emailField.value.trim();

                        // Only validate if email is not empty
                        if (email !== '') {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            if (!emailRegex.test(email)) {
                                emailError.textContent = 'Valid email address is required.';
                                emailError.style.display = 'block';
                                emailError.style.fontSize = '0.875rem';
                                emailError.style.marginTop = '0.25rem';
                            } else {
                                emailError.style.display = 'none';
                            }
                        } else {
                            emailError.style.display = 'none';
                        }
                    }
                }
            });

            // Flatpickr initialization
            flatpickr("#visit_date_time", {
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                minDate: "today"
            });

            flatpickr("#date_of_birth", {
                dateFormat: "d-m-Y",
                maxDate: "today",
               
            });

            // Function to calculate age from date of birth
            function calculateAge(birthDate) {
                const today = new Date();
                const birth = new Date(birthDate);
                let age = today.getFullYear() - birth.getFullYear();
                const monthDiff = today.getMonth() - birth.getMonth();

                // Adjust age if birthday hasn't occurred yet this year
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                    age--;
                }

                // Set the age in the age field
                const ageField = document.getElementById('age');
                ageField.value = age;

                // Trigger input event to clear error
                const event = new Event('input', { bubbles: true });
                ageField.dispatchEvent(event);
            }

            // Calculate age on page load if date of birth is already set
          

                // Flag to prevent infinite loops when updating fields
                let isUpdatingFromDuration = false;
                let isUpdatingFromDate = false;

                // Function to calculate Diabetes From date from years and months
                function calculateDiabetesFrom() {
                    if (isUpdatingFromDate) return; // Prevent loop

                    const years = parseInt(document.getElementById('diabetes_years').value) || 0;
                    const months = parseInt(document.getElementById('diabetes_months').value) || 0;
                    const diabetesFromField = document.getElementById('diabetes_from');

                    if (years === 0 && months === 0) {
                        if (!diabetesFromField.value) {
                            diabetesFromField.value = '';
                        }
                        return;
                    }

                    isUpdatingFromDuration = true;

                    // Calculate the date by subtracting years and months from today
                    const today = new Date();
                    const calculatedDate = new Date(today);

                    // Subtract years
                    calculatedDate.setFullYear(today.getFullYear() - years);

                    // Subtract months
                    calculatedDate.setMonth(today.getMonth() - months);

                    // Format as YYYY-MM (first day of the month)
                    const year = calculatedDate.getFullYear();
                    const month = String(calculatedDate.getMonth() + 1).padStart(2, '0');
                    const dateValue = `${month}-${year}`;

                    // Update flatpickr instance if it exists (without triggering calendar)
                    if (window.diabetesFromFlatpickr) {
                        window.diabetesFromFlatpickr.setDate(dateValue, false);
                        // Also update the input value directly to ensure sync
                        diabetesFromField.value = dateValue;
                    } else {
                        diabetesFromField.value = dateValue;
                    }

                    setTimeout(() => {
                        isUpdatingFromDuration = false;
                    }, 100);
                }

                // Function to calculate Diabetes Since (years and months) from date
function calculateDiabetesSince(diabetesFromDate) {
    if (isUpdatingFromDuration) return; // Prevent loop

    if (!diabetesFromDate) {
        document.getElementById('diabetes_years').value = '';
        document.getElementById('diabetes_months').value = '';
        return;
    }

    isUpdatingFromDate = true;

    const today = new Date();
    let fromDate;

    // CORRECTED: Properly handle Date objects from flatpickr
    if (diabetesFromDate instanceof Date) {
        // It's already a Date object from flatpickr
        fromDate = diabetesFromDate;
    } else if (typeof diabetesFromDate === 'string') {
        // If it's a string in "m-Y" format (fallback)
        const [month, year] = diabetesFromDate.split('-');
        fromDate = new Date(parseInt(year), parseInt(month) - 1, 1);
    } else {
        // Invalid date
        document.getElementById('diabetes_years').value = '';
        document.getElementById('diabetes_months').value = '';
        isUpdatingFromDate = false;
        return;
    }

    // Validate that fromDate is not in the future
    if (fromDate > today) {
        document.getElementById('diabetes_years').value = '';
        document.getElementById('diabetes_months').value = '';
        isUpdatingFromDate = false;
        return;
    }

    // Calculate the difference in years and months
    let years = today.getFullYear() - fromDate.getFullYear();
    let months = today.getMonth() - fromDate.getMonth();

    // Adjust if months difference is negative
    if (months < 0) {
        years--;
        months += 12;
    }

    // Ensure values are not negative (safety check)
    years = Math.max(0, years);
    months = Math.max(0, months);

    // Set the values
    document.getElementById('diabetes_years').value = years;
    document.getElementById('diabetes_months').value = months;

    setTimeout(() => {
        isUpdatingFromDate = false;
    }, 100);
}

                // Initialize flatpickr for diabetes_from
                window.diabetesFromFlatpickr = flatpickr("#diabetes_from", {
                    dateFormat: "m-Y",
                    maxDate: "today",
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length > 0) {
                            calculateDiabetesSince(selectedDates[0]);
                        } else {
                            document.getElementById('diabetes_years').value = '';
                            document.getElementById('diabetes_months').value = '';
                        }
                    }
                });

                // Add event listeners to years and months fields
                document.addEventListener('DOMContentLoaded', function() {
                    const diabetesYearsField = document.getElementById('diabetes_years');
                    const diabetesMonthsField = document.getElementById('diabetes_months');

                    if (diabetesYearsField) {
                        diabetesYearsField.addEventListener('input', calculateDiabetesFrom);
                        diabetesYearsField.addEventListener('change', calculateDiabetesFrom);
                    }

                    if (diabetesMonthsField) {
                        diabetesMonthsField.addEventListener('input', calculateDiabetesFrom);
                        diabetesMonthsField.addEventListener('change', calculateDiabetesFrom);

                        // Validate months (0-11)
                        diabetesMonthsField.addEventListener('input', function() {
                            const months = parseInt(this.value);
                            if (months > 11) {
                                this.value = 11;
                            } else if (months < 0) {
                                this.value = 0;
                            }
                            calculateDiabetesFrom();
                        });

                        // Prevent calendar from opening on blur
                        diabetesMonthsField.addEventListener('blur', function() {
                            // Close calendar if it's open
                            if (window.diabetesFromFlatpickr) {
                                window.diabetesFromFlatpickr.close();
                            }
                            // Ensure diabetes_from field doesn't get focus
                            const diabetesFromField = document.getElementById('diabetes_from');
                            if (diabetesFromField && document.activeElement === diabetesFromField) {
                                diabetesFromField.blur();
                            }
                        });
                    }

                    // Calculate on page load if values are already set
                    const diabetesFromField = document.getElementById('diabetes_from');
                    if (diabetesFromField && diabetesFromField.value) {
                        // Parse the YYYY-MM format
                        const dateValue = diabetesFromField.value;
                        if (dateValue) {
                            const dateParts = dateValue.split('-');
                            if (dateParts.length === 2) {
                                const year = parseInt(dateParts[0]);
                                const month = parseInt(dateParts[1]) - 1; // Months are 0-indexed
                                const date = new Date(year, month, 1);
                                calculateDiabetesSince(date);
                            }
                        }
                    } else if ((diabetesYearsField && diabetesYearsField.value) || (diabetesMonthsField && diabetesMonthsField.value)) {
                        calculateDiabetesFrom();
                    }
                });

                // Flag to prevent infinite loops when updating BP fields
                let isUpdatingBPFromDuration = false;
                let isUpdatingBPFromDate = false;

                // Function to calculate BP Since date from years and months
                function calculateBPFrom() {
                    if (isUpdatingBPFromDate) return; // Prevent loop

                    const years = parseInt(document.getElementById('bp_years').value) || 0;
                    const months = parseInt(document.getElementById('bp_months').value) || 0;
                    const bpSinceField = document.getElementById('bp_since');

                    if (!bpSinceField) return;

                    if (years === 0 && months === 0) {
                        if (!bpSinceField.value) {
                            bpSinceField.value = '';
                        }
                        return;
                    }

                    isUpdatingBPFromDuration = true;

                    // Calculate the date by subtracting years and months from today
                    const today = new Date();
                    const calculatedDate = new Date(today);

                    // Subtract years
                    calculatedDate.setFullYear(today.getFullYear() - years);

                    // Subtract months
                    calculatedDate.setMonth(today.getMonth() - months);

                    // Format as YYYY-MM (first day of the month)
                    const year = calculatedDate.getFullYear();
                    const month = String(calculatedDate.getMonth() + 1).padStart(2, '0');
                    const dateValue = `${month}-${year}`;

                    // Update flatpickr instance if it exists (without triggering calendar)
                    if (window.bpSinceFlatpickr) {
                        window.bpSinceFlatpickr.setDate(dateValue, false);
                        // Also update the input value directly to ensure sync
                        bpSinceField.value = dateValue;
                    } else {
                        bpSinceField.value = dateValue;
                    }

                    setTimeout(() => {
                        isUpdatingBPFromDuration = false;
                    }, 100);
                }

                // Function to calculate BP Duration (years and months) from date
function calculateBPDuration(bpSinceDate) {
    if (isUpdatingBPFromDuration) return; // Prevent loop

    if (!bpSinceDate) {
        const bpYearsField = document.getElementById('bp_years');
        const bpMonthsField = document.getElementById('bp_months');
        if (bpYearsField) bpYearsField.value = '';
        if (bpMonthsField) bpMonthsField.value = '';
        return;
    }

    isUpdatingBPFromDate = true;

    const today = new Date();
    let fromDate;

    // CORRECTED: Properly handle Date objects from flatpickr
    if (bpSinceDate instanceof Date) {
        // It's already a Date object from flatpickr
        fromDate = bpSinceDate;
    } else if (typeof bpSinceDate === 'string') {
        // If it's a string in "m-Y" format (fallback)
        const [month, year] = bpSinceDate.split('-');
        fromDate = new Date(parseInt(year), parseInt(month) - 1, 1);
    } else {
        // Invalid date
        const bpYearsField = document.getElementById('bp_years');
        const bpMonthsField = document.getElementById('bp_months');
        if (bpYearsField) bpYearsField.value = '';
        if (bpMonthsField) bpMonthsField.value = '';
        isUpdatingBPFromDate = false;
        return;
    }

    // Validate that fromDate is not in the future
    if (fromDate > today) {
        const bpYearsField = document.getElementById('bp_years');
        const bpMonthsField = document.getElementById('bp_months');
        if (bpYearsField) bpYearsField.value = '';
        if (bpMonthsField) bpMonthsField.value = '';
        isUpdatingBPFromDate = false;
        return;
    }

    // Calculate the difference in years and months
    let years = today.getFullYear() - fromDate.getFullYear();
    let months = today.getMonth() - fromDate.getMonth();

    // Adjust if months difference is negative
    if (months < 0) {
        years--;
        months += 12;
    }

    // Ensure values are not negative (safety check)
    years = Math.max(0, years);
    months = Math.max(0, months);

    // Set the values
    const bpYearsField = document.getElementById('bp_years');
    const bpMonthsField = document.getElementById('bp_months');
    if (bpYearsField) bpYearsField.value = years;
    if (bpMonthsField) bpMonthsField.value = months;

    setTimeout(() => {
        isUpdatingBPFromDate = false;
    }, 100);
}

                // Initialize flatpickr for bp_since
               // Initialize flatpickr for bp_since with clear handling
const bpSince = document.getElementById('bp_since');
if (bpSince) {
    window.bpSinceFlatpickr = flatpickr(bpSince, {
        dateFormat: "m-Y",
        maxDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                calculateBPDuration(selectedDates[0]);
            } else {
                // When BP since is cleared, also clear duration fields
                const bpYearsField = document.getElementById('bp_years');
                const bpMonthsField = document.getElementById('bp_months');
                if (bpYearsField) bpYearsField.value = '';
                if (bpMonthsField) bpMonthsField.value = '';
            }
        }
    });
}

                // Add event listeners to BP years and months fields
                document.addEventListener('DOMContentLoaded', function() {
                    const bpYearsField = document.getElementById('bp_years');
                    const bpMonthsField = document.getElementById('bp_months');

                    if (bpYearsField) {
                        bpYearsField.addEventListener('input', calculateBPFrom);
                        bpYearsField.addEventListener('change', calculateBPFrom);
                    }

                    if (bpMonthsField) {
                        bpMonthsField.addEventListener('input', calculateBPFrom);
                        bpMonthsField.addEventListener('change', calculateBPFrom);

                        // Validate months (0-11)
                        bpMonthsField.addEventListener('input', function() {
                            const months = parseInt(this.value);
                            if (months > 11) {
                                this.value = 11;
                            } else if (months < 0) {
                                this.value = 0;
                            }
                            calculateBPFrom();
                        });

                        // Prevent calendar from opening on blur
                        bpMonthsField.addEventListener('blur', function() {
                            // Close calendar if it's open
                            if (window.bpSinceFlatpickr) {
                                window.bpSinceFlatpickr.close();
                            }
                            // Ensure bp_since field doesn't get focus
                            const bpSinceField = document.getElementById('bp_since');
                            if (bpSinceField && document.activeElement === bpSinceField) {
                                bpSinceField.blur();
                            }
                        });
                    }

                    // Calculate on page load if values are already set
                    if (bpSince && bpSince.value) {
                        // Parse the YYYY-MM format
                        const dateValue = bpSince.value;
                        if (dateValue) {
                            const dateParts = dateValue.split('-');
                            if (dateParts.length === 2) {
                                const month = parseInt(dateParts[0]) - 1; // Months are 0-indexed
                                const year = parseInt(dateParts[1]);
                                const date = new Date(year, month, 1);
                                calculateBPDuration(date);
                            }
                        }
                    } else if ((bpYearsField && bpYearsField.value) || (bpMonthsField && bpMonthsField.value)) {
                        calculateBPFrom();
                    }
                });

//                 document.addEventListener('DOMContentLoaded', function() {
//     function toggleTreatmentType() {
//         const onTreatmentYes = document.getElementById('on_treatment_yes');
//         const container = document.getElementById('type_of_treatment_container');
//         container.style.display = onTreatmentYes.checked ? 'block' : 'none';
//     }

//     // Run on load
//     toggleTreatmentType();

//     // Add change listener
//     document.querySelectorAll('input[name="on_treatment"]').forEach(input => {
//         input.addEventListener('change', toggleTreatmentType);
//     });
// });


document.addEventListener('DOMContentLoaded', function() {
    const treatmentContainer = document.getElementById('type_of_treatment_container');
    const otherTreatmentContainer = document.getElementById('type_of_treatment_other_container');
    const othersCheckbox = document.getElementById('others_treatment');
    const otherTreatmentInput = document.getElementById('type_of_treatment_other');

    function toggleTreatmentFields() {
        const onTreatmentYes = document.getElementById('on_treatment_yes').checked;

        if (onTreatmentYes) {
            treatmentContainer.style.display = 'block';
        } else {
            treatmentContainer.style.display = 'none';
            
            // Critical: Fully reset "Others" section when "Not On Treatment"
            if (othersCheckbox) othersCheckbox.checked = false;
            if (otherTreatmentInput) otherTreatmentInput.value = '';
            if (otherTreatmentContainer) otherTreatmentContainer.style.display = 'none';
            
            // Optional: Uncheck all treatment checkboxes
            document.querySelectorAll('input[name="type_of_treatment[]"]').forEach(cb => {
                cb.checked = false;
            });
        }
    }

    // Initial state on page load
    toggleTreatmentFields();

    // Listen to both radio buttons
    document.querySelectorAll('input[name="on_treatment"]').forEach(radio => {
        radio.addEventListener('change', toggleTreatmentFields);
    });

    // Keep the "Others" field toggle working when inside "On Treatment"
    if (othersCheckbox) {
        othersCheckbox.addEventListener('change', function() {
            if (this.checked && document.getElementById('on_treatment_yes').checked) {
                otherTreatmentContainer.style.display = 'block';
            } else {
                otherTreatmentContainer.style.display = 'none';
                if (otherTreatmentInput) otherTreatmentInput.value = '';
            }
        });
    }
});

// Add this function to handle clearing BP since when duration fields are cleared
function handleBPDurationClear() {
    const bpYearsField = document.getElementById('bp_years');
    const bpMonthsField = document.getElementById('bp_months');
    const bpSinceField = document.getElementById('bp_since');
    
    if (bpYearsField && bpMonthsField && bpSinceField) {
        // Check if both duration fields are empty
        const yearsEmpty = !bpYearsField.value || bpYearsField.value === '0';
        const monthsEmpty = !bpMonthsField.value || bpMonthsField.value === '0';
        
        if (yearsEmpty && monthsEmpty && bpSinceField.value) {
            // Clear BP since field when both duration fields are empty
            if (window.bpSinceFlatpickr) {
                window.bpSinceFlatpickr.clear();
            } else {
                bpSinceField.value = '';
            }
        }
    }
}

// Update your existing calculateBPFrom function to include the clear logic
function calculateBPFrom() {
    if (isUpdatingBPFromDate) return; // Prevent loop

    const years = parseInt(document.getElementById('bp_years').value) || 0;
    const months = parseInt(document.getElementById('bp_months').value) || 0;
    const bpSinceField = document.getElementById('bp_since');

    if (!bpSinceField) return;

    // Check if both fields are empty or zero
    if ((years === 0 && months === 0)) {
        if (bpSinceField.value) {
            // Clear BP since field when duration is cleared
            if (window.bpSinceFlatpickr) {
                window.bpSinceFlatpickr.clear();
            } else {
                bpSinceField.value = '';
            }
        }
        return;
    }

    isUpdatingBPFromDuration = true;

    // Calculate the date by subtracting years and months from today
    const today = new Date();
    const calculatedDate = new Date(today);

    // Subtract years
    calculatedDate.setFullYear(today.getFullYear() - years);

    // Subtract months
    calculatedDate.setMonth(today.getMonth() - months);

    // Format as YYYY-MM (first day of the month)
    const year = calculatedDate.getFullYear();
    const month = String(calculatedDate.getMonth() + 1).padStart(2, '0');
    const dateValue = `${month}-${year}`;

    // Update flatpickr instance if it exists (without triggering calendar)
    if (window.bpSinceFlatpickr) {
        window.bpSinceFlatpickr.setDate(dateValue, false);
        // Also update the input value directly to ensure sync
        bpSinceField.value = dateValue;
    } else {
        bpSinceField.value = dateValue;
    }

    setTimeout(() => {
        isUpdatingBPFromDuration = false;
    }, 100);
}

// Update your existing event listeners for BP years and months fields
document.addEventListener('DOMContentLoaded', function() {
    const bpYearsField = document.getElementById('bp_years');
    const bpMonthsField = document.getElementById('bp_months');

    if (bpYearsField) {
        bpYearsField.addEventListener('input', function() {
            calculateBPFrom();
            handleBPDurationClear(); // Add clear handler
        });
        bpYearsField.addEventListener('change', function() {
            calculateBPFrom();
            handleBPDurationClear(); // Add clear handler
        });
        
        // Add blur event for immediate clearing
        bpYearsField.addEventListener('blur', function() {
            handleBPDurationClear();
        });
    }

    if (bpMonthsField) {
        bpMonthsField.addEventListener('input', function() {
            calculateBPFrom();
            handleBPDurationClear(); // Add clear handler
        });
        bpMonthsField.addEventListener('change', function() {
            calculateBPFrom();
            handleBPDurationClear(); // Add clear handler
        });

        // Validate months (0-11)
        bpMonthsField.addEventListener('input', function() {
            const months = parseInt(this.value);
            if (months > 11) {
                this.value = 11;
            } else if (months < 0) {
                this.value = 0;
            }
            calculateBPFrom();
            handleBPDurationClear(); // Add clear handler
        });

        // Add blur event for immediate clearing
        bpMonthsField.addEventListener('blur', function() {
            handleBPDurationClear();
        });

        // Prevent calendar from opening on blur
        bpMonthsField.addEventListener('blur', function() {
            // Close calendar if it's open
            if (window.bpSinceFlatpickr) {
                window.bpSinceFlatpickr.close();
            }
            // Ensure bp_since field doesn't get focus
            const bpSinceField = document.getElementById('bp_since');
            if (bpSinceField && document.activeElement === bpSinceField) {
                bpSinceField.blur();
            }
        });
    }

    // Calculate on page load if values are already set
    const bpSince = document.getElementById('bp_since');
    if (bpSince && bpSince.value) {
        // Parse the YYYY-MM format
        const dateValue = bpSince.value;
        if (dateValue) {
            const dateParts = dateValue.split('-');
            if (dateParts.length === 2) {
                const month = parseInt(dateParts[0]) - 1; // Months are 0-indexed
                const year = parseInt(dateParts[1]);
                const date = new Date(year, month, 1);
                calculateBPDuration(date);
            }
        }
    } else if ((bpYearsField && bpYearsField.value) || (bpMonthsField && bpMonthsField.value)) {
        calculateBPFrom();
    }
});

// Add this function for diabetes duration clearing
function handleDiabetesDurationClear() {
    const diabetesYearsField = document.getElementById('diabetes_years');
    const diabetesMonthsField = document.getElementById('diabetes_months');
    const diabetesFromField = document.getElementById('diabetes_from');
    
    if (diabetesYearsField && diabetesMonthsField && diabetesFromField) {
        // Check if both duration fields are empty
        const yearsEmpty = !diabetesYearsField.value || diabetesYearsField.value === '0';
        const monthsEmpty = !diabetesMonthsField.value || diabetesMonthsField.value === '0';
        
        if (yearsEmpty && monthsEmpty && diabetesFromField.value) {
            // Clear diabetes from field when both duration fields are empty
            if (window.diabetesFromFlatpickr) {
                window.diabetesFromFlatpickr.clear();
            } else {
                diabetesFromField.value = '';
            }
        }
    }
}

// Update your existing diabetes duration event listeners
document.addEventListener('DOMContentLoaded', function() {
    const diabetesYearsField = document.getElementById('diabetes_years');
    const diabetesMonthsField = document.getElementById('diabetes_months');

    if (diabetesYearsField) {
        diabetesYearsField.addEventListener('input', function() {
            calculateDiabetesFrom();
            handleDiabetesDurationClear(); // Add clear handler
        });
        diabetesYearsField.addEventListener('change', function() {
            calculateDiabetesFrom();
            handleDiabetesDurationClear(); // Add clear handler
        });
        
        diabetesYearsField.addEventListener('blur', function() {
            handleDiabetesDurationClear();
        });
    }

    if (diabetesMonthsField) {
        diabetesMonthsField.addEventListener('input', function() {
            calculateDiabetesFrom();
            handleDiabetesDurationClear(); // Add clear handler
        });
        diabetesMonthsField.addEventListener('change', function() {
            calculateDiabetesFrom();
            handleDiabetesDurationClear(); // Add clear handler
        });

        // Validate months (0-11)
        diabetesMonthsField.addEventListener('input', function() {
            const months = parseInt(this.value);
            if (months > 11) {
                this.value = 11;
            } else if (months < 0) {
                this.value = 0;
            }
            calculateDiabetesFrom();
            handleDiabetesDurationClear(); // Add clear handler
        });

        diabetesMonthsField.addEventListener('blur', function() {
            handleDiabetesDurationClear();
        });

        // Prevent calendar from opening on blur
        diabetesMonthsField.addEventListener('blur', function() {
            // Close calendar if it's open
            if (window.diabetesFromFlatpickr) {
                window.diabetesFromFlatpickr.close();
            }
            // Ensure diabetes_from field doesn't get focus
            const diabetesFromField = document.getElementById('diabetes_from');
            if (diabetesFromField && document.activeElement === diabetesFromField) {
                diabetesFromField.blur();
            }
        });
    }
});


        </script>
     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/doctor/patients/add-patient.blade.php ENDPATH**/ ?>