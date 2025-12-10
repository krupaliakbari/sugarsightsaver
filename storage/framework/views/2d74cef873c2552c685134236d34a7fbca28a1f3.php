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
                @media (max-width: 576px) {
        .oph-form tr {

            gap: 5px;
            align-items: center;
        }

        .oph-form td {
            width: auto !important;
        }

        .oph-form input.form-control {
            width: 100% !important;
        }
        .form-control{
            padding: 6px 6px !important;
        }
    }
            </style>
         <?php $__env->endSlot(); ?>
        <!-- END GLOBAL MANDATORY STYLES -->

        <div class="row mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="widget-content widget-content-area br-8">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0">Edit Appointment</h4>
                                    <a href="<?php echo e(route('doctor.patients.medical-records', $appointment->patient_id)); ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back
                                    </a>
                                </div>

                                <?php if(session()->has('error')): ?>
                                    <div class="alert alert-danger"><?php echo e(session()->get('error')); ?></div>
                                <?php endif; ?>

                                <?php if(session()->has('success')): ?>
                                    <div class="alert alert-success"><?php echo e(session()->get('success')); ?></div>
                                <?php endif; ?>

                                <!-- Edit Appointment Form -->
                                <form method="POST" action="<?php echo e(route('doctor.patients.appointments.update-with-patient', $appointment->id)); ?>" id="editAppointmentForm">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <!-- Basic Appointment Details -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title">Appointment Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="visit_date_time" class="form-label">Visit Date & Time <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control flatpickr-input <?php $__errorArgs = ['visit_date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            id="visit_date_time"
                                                            name="visit_date_time"
                                                            value="<?php echo e(old('visit_date_time', $appointment->visit_date_time->format('d-m-Y H:i'))); ?>"
                                                            placeholder="Select Date & Time"
                                                            required>
                                                        <?php $__errorArgs = ['visit_date_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 d-none">
                                                        <label for="appointment_type" class="form-label">Appointment Type <span class="text-danger">*</span></label>
                                                        <select class="form-select <?php $__errorArgs = ['appointment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="appointment_type"
                                                                name="appointment_type"
                                                                required>
                                                            <option value="">Select appointment type</option>
                                                            <option value="new" <?php echo e(old('appointment_type', $appointment->appointment_type) == 'new' ? 'selected' : ''); ?>>New Visit</option>
                                                            <option value="follow_up" <?php echo e(old('appointment_type', $appointment->appointment_type) == 'follow_up' ? 'selected' : ''); ?>>Follow up</option>
                                                        </select>
                                                        <?php $__errorArgs = ['appointment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
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
                                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                        value="<?php echo e(old('name', $appointment->patient_name_snapshot)); ?>">
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
                                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                                    value="<?php echo e($appointment->patient_mobile_number_snapshot); ?>" readonly>
                                                <small class="text-muted">Mobile number cannot be changed</small>
                                                <input type="hidden" name="sssp_id" value="<?php echo e($appointment->patient_sssp_id_snapshot); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                <label for="diabetes_from" class="form-label">Diabetes Since <span class="text-danger"></span></label>
                                                <input type="text" class="form-control flatpickr-input" id="diabetes_from" name="diabetes_from"
                                                        value="<?php echo e(old('diabetes_from', $appointment->patient_diabetes_from_snapshot ? $appointment->patient_diabetes_from_snapshot->format('m-Y') : '')); ?>" placeholder="Select Month & Year">
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
                                                                value="<?php echo e(old('diabetes_years', '')); ?>" placeholder="Years" min="0" max="100">
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
                                                                value="<?php echo e(old('diabetes_months', '')); ?>" placeholder="Months" min="0" max="11">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="date_of_birth" class="form-label">Date Of Birth </label>
                                                <input type="text" class="form-control flatpickr-input" id="date_of_birth" name="date_of_birth"
                                                        value="<?php echo e(old('date_of_birth', $appointment->patient_date_of_birth_snapshot ? $appointment->patient_date_of_birth_snapshot->format('d-m-Y') : '')); ?>" placeholder="Select Date of Birth">
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
                                                        value="<?php echo e(old('age', $appointment->patient_age_snapshot)); ?>" min="1" max="120">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="sex" name="sex">
                                                    <option value="">Select Sex</option>
                                                    <option value="male" <?php echo e(old('sex', $appointment->patient_sex_snapshot) == 'male' ? 'selected' : ''); ?>>Male</option>
                                                    <option value="female" <?php echo e(old('sex', $appointment->patient_sex_snapshot) == 'female' ? 'selected' : ''); ?>>Female</option>
                                                    <option value="other" <?php echo e(old('sex', $appointment->patient_sex_snapshot) == 'other' ? 'selected' : ''); ?>>Other</option>
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label for="short_address" class="form-label">Short Address <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="short_address" name="short_address" rows="2"><?php echo e(old('short_address', $appointment->patient_short_address_snapshot)); ?></textarea>
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="hospital_id" class="form-label">Hospital ID</label>
                                                    <input type="text" class="form-control" id="hospital_id" name="hospital_id"
                                                        value="<?php echo e(old('hospital_id', $appointment->patient_hospital_id_snapshot)); ?>">
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
                                                        value="<?php echo e(old('email', $appointment->patient_email_snapshot)); ?>">
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
                                                <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label">On Treatment? <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="on_treatment" id="on_treatment_yes" value="1"
                                                            <?php echo e(old('on_treatment', $appointment->patient_on_treatment_snapshot) == '1' ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="on_treatment_yes">On Treatment</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="on_treatment" id="on_treatment_no" value="0"
                                                            <?php echo e(old('on_treatment', $appointment->patient_on_treatment_snapshot) == '0' ? 'checked' : ''); ?>>
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
                                                            <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="allopathic" value="allopathic"
                                                                <?php echo e(in_array('allopathic', old('type_of_treatment', $appointment->patient_type_of_treatment_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="allopathic">Allopathic</label>
                                                        </div>  
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="diet_control" value="diet_control"
                                                                <?php echo e(in_array('diet_control', old('type_of_treatment', $appointment->patient_type_of_treatment_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="diet_control">Diet Control</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="ayurvedic" value="ayurvedic"
                                                                <?php echo e(in_array('ayurvedic', old('type_of_treatment', $appointment->patient_type_of_treatment_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="ayurvedic">Ayurvedic</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="others_treatment" value="others"
                                                                <?php echo e(in_array('others', old('type_of_treatment', $appointment->patient_type_of_treatment_snapshot ?? [])) ? 'checked' : ''); ?>>
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
                                           <?php
    $typeOfTreatmentOtherValue = '';
    $hasOthersInTreatment = false;

    // Check old input first - this reflects the current form submission state
    $oldTypeOfTreatment = old('type_of_treatment', []);
    $hasOthersInTreatment = in_array('others', $oldTypeOfTreatment);

    // Only populate the value if "others" is actually selected in the current form
    if ($hasOthersInTreatment) {
        if (old('type_of_treatment_other') !== null && old('type_of_treatment_other') !== '') {
            $typeOfTreatmentOtherValue = trim(old('type_of_treatment_other'));
        } else {
            // Only get from snapshot if we're not in a form submission context
            // and "others" is selected in the current data
            $currentTypeOfTreatment = $appointment->patient_type_of_treatment_snapshot ?? [];
            if (in_array('others', $currentTypeOfTreatment)) {
                $snapshotValue = $appointment->patient_type_of_treatment_other_snapshot;
                if($snapshotValue !== null && $snapshotValue !== '') {
                    $typeOfTreatmentOtherValue = trim((string)$snapshotValue);
                }
            }
        }
    }
    // If "others" is not selected, ensure the value is empty
    else {
        $typeOfTreatmentOtherValue = '';
    }
?>
                                            <div class="row">
                                            <div class="col-md-6" id="type_of_treatment_other_container" style="display: <?php echo e($hasOthersInTreatment ? 'block' : 'none'); ?>;">
                                                <div class="form-group mb-3">
                                                    <label for="type_of_treatment_other" class="form-label">Specify Other Treatment <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="type_of_treatment_other" name="type_of_treatment_other"
                                                        value="<?php echo e(htmlspecialchars($typeOfTreatmentOtherValue, ENT_QUOTES, 'UTF-8')); ?>" placeholder="Enter other treatment type" autocomplete="off">
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
                                                        <input class="form-check-input" type="radio" name="bp" id="bp_yes" value="1"
                                                            <?php echo e(old('bp', $appointment->patient_bp_snapshot) == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="bp_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bp" id="bp_no" value="0"
                                                            <?php echo e(old('bp', $appointment->patient_bp_snapshot) == '0' ? 'checked' : ''); ?>>
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
                                                <label for="bp_since" class="form-label">BP Since</label>
                                                <input type="text" class="form-control flatpickr-input" id="bp_since" name="bp_since"
                                                        value="<?php echo e(old('bp_since', $appointment->patient_bp_since_snapshot ? $appointment->patient_bp_since_snapshot->format('m-Y') : '')); ?>" placeholder="Select Month & Year">
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
                                                            <input class="form-check-input" type="checkbox" name="other_diseases[]" id="heart_disease" value="heart_disease"
                                                                <?php echo e(in_array('heart_disease', old('other_diseases', $appointment->patient_other_diseases_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="heart_disease">Heart Disease</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="other_diseases[]" id="cholesterol" value="cholesterol"
                                                                <?php echo e(in_array('cholesterol', old('other_diseases', $appointment->patient_other_diseases_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="cholesterol">Cholesterol</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="other_diseases[]" id="thyroid" value="thyroid"
                                                                <?php echo e(in_array('thyroid', old('other_diseases', $appointment->patient_other_diseases_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="thyroid">Thyroid</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="other_diseases[]" id="stroke" value="stroke"
                                                                <?php echo e(in_array('stroke', old('other_diseases', $appointment->patient_other_diseases_snapshot ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="stroke">Stroke</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="other_diseases[]" id="others_diseases" value="others"
                                                                <?php echo e(in_array('others', old('other_diseases', $appointment->patient_other_diseases_snapshot ?? [])) ? 'checked' : ''); ?>>
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
                                            <?php
                                                // Get other_diseases_other value - prioritize old input, then current appointment snapshot only
                                                $otherDiseasesOtherValue = '';

                                                // Check if "others" is selected in the current appointment
                                                $hasOthersInDiseases = in_array('others', old('other_diseases', $appointment->patient_other_diseases_snapshot ?? []));

                                                if(old('other_diseases_other') !== null && old('other_diseases_other') !== '') {
                                                    $otherDiseasesOtherValue = trim(old('other_diseases_other'));
                                                } else {
                                                    // Get from appointment snapshot only (no patient fallback)
                                                    $snapshotValue = $appointment->patient_other_diseases_other_snapshot;
                                                    if($snapshotValue !== null && $snapshotValue !== '') {
                                                        $otherDiseasesOtherValue = trim((string)$snapshotValue);
                                                    }
                                                }
                                            ?>
                                            <div class="col-md-12" id="other_diseases_other_container" style="display: <?php echo e($hasOthersInDiseases ? 'block' : 'none'); ?>;">
                                                <div class="form-group mb-3">
                                                    <label for="other_diseases_other" class="form-label">Specify Other Disease <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="other_diseases_other" name="other_diseases_other"
                                                        value="<?php echo e(htmlspecialchars($otherDiseasesOtherValue, ENT_QUOTES, 'UTF-8')); ?>" placeholder="Enter other disease" autocomplete="off">
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
                                                    <textarea class="form-control" id="other_input" name="other_input" rows="2"><?php echo e(old('other_input', $appointment->patient_other_input_snapshot)); ?></textarea>
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
                                <?php echo e(old('height_unit', $appointment->patient_height_unit) == 'meter' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="unit_meter">Meter</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="height_unit" id="unit_feet" value="feet"
                                <?php echo e(old('height_unit', $appointment->patient_height_unit) == 'feet' ? 'checked' : ''); ?>>
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
                            <span id="height-unit-display">(in <?php echo e(old('height_unit', $appointment->patient_height_unit) == 'feet' ? 'Feet' : 'Meters'); ?>)</span>
                        </label>
                        <input type="number"
                            class="form-control"
                            id="height"
                            name="height"
                            value="<?php echo e(old('height', $appointment->patient_height)); ?>"
                            step="0.01"
                            placeholder="<?php echo e(old('height_unit', $appointment->patient_height_unit) == 'feet' ? 'e.g., 5.9' : 'e.g., 1.75'); ?>">
                        <small class="text-muted" id="height-hint">
                            <?php echo e(old('height_unit', $appointment->patient_height_unit) == 'feet' ? 'Range: 2.0 – 9.0 feet' : 'Range: 0.5 – 3.0 meters'); ?>

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
                            value="<?php echo e(old('weight', $appointment->patient_weight)); ?>" step="0.01" min="1" max="500">
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
                        <div class="">
                            <input type="text" class="form-control" id="bmi1" name="bmi"
                                value="<?php echo e(old('bmi', $appointment->patient_bmi)); ?>" readonly style="max-width: 100px;margin-bottom:10px;">
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


                                    <?php
                                        $physicianRecord = $appointment->medicalRecords->where('record_type', 'physician')->first()?->physicianRecord;
                                        $ophthalmologistRecord = $appointment->medicalRecords->where('record_type', 'ophthalmologist')->first()?->ophthalmologistRecord;
                                        $currentDoctorType = Auth::user()->doctor_type;
                                    ?>

                                    <!-- Physician Medical Entry -->
                                    <?php if($physicianRecord || ($currentDoctorType === 'diabetes_treating' && !$physicianRecord)): ?>
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title">Physician Medical Entry</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Type of Diabetes -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="type_of_diabetes" class="form-label">Type of Diabetes <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="type_of_diabetes" name="physician_record[type_of_diabetes]" style="margin-bottom: 10px;">
                                                            <option value="">Select Type</option>
                                                            <option value="type1" <?php echo e(old('physician_record.type_of_diabetes', $physicianRecord?->type_of_diabetes) == 'type1' ? 'selected' : ''); ?>>Type 1</option>
                                                            <option value="type2" <?php echo e(old('physician_record.type_of_diabetes', $physicianRecord?->type_of_diabetes) == 'type2' ? 'selected' : ''); ?>>Type 2</option>
                                                            <option value="other" <?php echo e(old('physician_record.type_of_diabetes', $physicianRecord?->type_of_diabetes) == 'other' ? 'selected' : ''); ?>>Other</option>
                                                        </select>
                                                        <?php $__errorArgs = ['physician_record.type_of_diabetes'];
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
                                                    <div class="col-md-6">
                                                        <label class="form-label">Family History of Diabetes <span class="text-danger">*</span></label>
                                                        <div class="mt-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="physician_record[family_history_diabetes]" id="family_history_yes" value="1"
                                                                    <?php echo e(old('physician_record.family_history_diabetes', ($physicianRecord?->family_history_diabetes ? '1' : '0')) == '1' ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="family_history_yes">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="physician_record[family_history_diabetes]" id="family_history_no" value="0"
                                                                    <?php echo e(old('physician_record.family_history_diabetes', ($physicianRecord?->family_history_diabetes ? '1' : '0')) == '0' ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="family_history_no">No</label>
                                                            </div>
                                                        </div>
                                                        <?php $__errorArgs = ['physician_record.family_history_diabetes'];
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

                                                <!-- Current Treatment -->
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label class="form-label">Current Treatment <span class="text-danger">*</span></label>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="lifestyle" value="lifestyle"
                                                                        <?php echo e(in_array('lifestyle', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="lifestyle">Lifestyle</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="oha" value="oha"
                                                                        <?php echo e(in_array('oha', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="oha">OHA</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="insulin" value="insulin"
                                                                        <?php echo e(in_array('insulin', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="insulin">Insulin</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="glp1" value="glp1"
                                                                        <?php echo e(in_array('glp1', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="glp1">GLP 1</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="ayurvedic_homeopathy" value="ayurvedic_homeopathy"
                                                                        <?php echo e(in_array('ayurvedic_homeopathy', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="ayurvedic_homeopathy">Ayurvedic/Homeopathy</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="physician_others_treatment" value="others"
                                                                        <?php echo e(in_array('others', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label" for="physician_others_treatment">Others</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <!-- ADD THIS ERROR DISPLAY -->
        <?php $__errorArgs = ['physician_record.current_treatment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger mt-2"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        
                                                        <?php
                                                            $hasOthersChecked = in_array('others', old('physician_record.current_treatment', $physicianRecord?->current_treatment ?? []));
                                                            $currentTreatmentOtherValue = '';

                                                            // Get value - prioritize old input, then database
                                                            if(old('physician_record.current_treatment_other') !== null && old('physician_record.current_treatment_other') !== '') {
                                                                $currentTreatmentOtherValue = trim(old('physician_record.current_treatment_other'));
                                                            } elseif($physicianRecord && $physicianRecord->exists) {
                                                                // Get directly from database using raw query to ensure we get exact value
                                                                $rawValue = \Illuminate\Support\Facades\DB::table('physician_medical_records')
                                                                    ->where('id', $physicianRecord->id)
                                                                    ->value('current_treatment_other');
                                                                if($rawValue !== null && trim($rawValue) !== '') {
                                                                    $currentTreatmentOtherValue = trim($rawValue);
                                                                }
                                                            }
                                                        ?>
                                                        <div class="row mt-2" id="current_treatment_other_container" style="display: <?php echo e($hasOthersChecked ? 'block' : 'none'); ?>;">
                                                            <div class="col-md-6">
                                                                <label for="current_treatment_other" class="form-label">Specify Other Treatment <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="current_treatment_other" name="physician_record[current_treatment_other]"
                                                                    value="<?php echo e(htmlspecialchars($currentTreatmentOtherValue, ENT_QUOTES, 'UTF-8')); ?>"
                                                                    placeholder="Enter other treatment"
                                                                    autocomplete="off">
                                                                <?php $__errorArgs = ['physician_record.current_treatment_other'];
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

                                                <!-- Compliance -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Compliance <span class="text-danger">*</span></label>
                                                        <div class="mt-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="physician_record[compliance]" id="compliance_good" value="good"
                                                                    <?php echo e(old('physician_record.compliance', $physicianRecord?->compliance) == 'good' ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="compliance_good">Good</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="physician_record[compliance]" id="compliance_irregular" value="irregular"
                                                                    <?php echo e(old('physician_record.compliance', $physicianRecord?->compliance) == 'irregular' ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="compliance_irregular">Irregular</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="physician_record[compliance]" id="compliance_poor" value="poor"
                                                                    <?php echo e(old('physician_record.compliance', $physicianRecord?->compliance) == 'poor' ? 'checked' : ''); ?>>
                                                                <label class="form-check-label" for="compliance_poor">Poor</label>
                                                            </div>
                                                        </div>
                                                        <?php $__errorArgs = ['physician_record.compliance'];
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

                                                <!-- Blood Sugar Value -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label for="blood_sugar_type" class="form-label">Blood Sugar Type <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="blood_sugar_type" name="physician_record[blood_sugar_type]">
                                                            <option value="">Select Type</option>
                                                            <option value="rbs" <?php echo e(old('physician_record.blood_sugar_type', $physicianRecord?->blood_sugar_type) == 'rbs' ? 'selected' : ''); ?>>RBS</option>
                                                            <option value="fbs" <?php echo e(old('physician_record.blood_sugar_type', $physicianRecord?->blood_sugar_type) == 'fbs' ? 'selected' : ''); ?>>FBS</option>
                                                            <option value="ppbs" <?php echo e(old('physician_record.blood_sugar_type', $physicianRecord?->blood_sugar_type) == 'ppbs' ? 'selected' : ''); ?>>PPBS</option>
                                                            <option value="hba1c" <?php echo e(old('physician_record.blood_sugar_type', $physicianRecord?->blood_sugar_type) == 'hba1c' ? 'selected' : ''); ?>>HBA1C</option>
                                                        </select>
                                                        <?php $__errorArgs = ['physician_record.blood_sugar_type'];
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
                                                    <div class="col-md-6">
                                                        <label for="blood_sugar_value" class="form-label">Blood Sugar Value <span class="text-danger">*</span></label>
                                                        <input type="number" step="0.01" min="0" max="999.99" class="form-control" id="blood_sugar_value" name="physician_record[blood_sugar_value]"
                                                            value="<?php echo e(old('physician_record.blood_sugar_value', $physicianRecord?->blood_sugar_value)); ?>">
                                                        <?php $__errorArgs = ['physician_record.blood_sugar_value'];
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

                                                <!-- Use centralized component -->
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.physician-medical-entry','data' => ['fieldPrefix' => 'physician_record','physicianRecord' => $physicianRecord]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('physician-medical-entry'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field-prefix' => 'physician_record','physician-record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($physicianRecord)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                                <!-- Other Data -->
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label for="other_data" class="form-label">Other Data</label>
                                                        <textarea class="form-control" id="other_data" name="physician_record[other_data]" rows="3"
                                                                placeholder="Enter any additional information"><?php echo e(old('physician_record.other_data', $physicianRecord?->other_data)); ?></textarea>
                                                        <?php $__errorArgs = ['physician_record.other_data'];
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
                                    <?php endif; ?>

                                    <!-- Ophthalmologist Medical Record -->
                                    <?php if($ophthalmologistRecord || ($currentDoctorType === 'ophthalmologist' && !$ophthalmologistRecord)): ?>
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title text-success">Ophthalmologist Medical Record</h5>
                                            </div>
                                            <div class="card-body">
    <div class="row mb-3">
                                                <div class="col-md-12">
                                                    
                                                    <div class="table-responsive">
                                                        
                                                        <table class="table table-bordered align-middle">
                                                            <thead class="table-light text-center">
                                                                <tr>
                                                                    <th style="border: none;"></th>
                                                                    <th style="border: none;font-weight: bold; padding-left: 0">RE (Right
                                                                        Eye)</th>
                                                                    <th style="border: none;font-weight: bold;">LE (Left
                                                                        Eye)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="border: none; width: 25%;">
                                                                        <label
                                                                            class="form-label mb-0 fw-semibold">UCVA</label>
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[ucva_re]"
                                                                            value="<?php echo e(old('ophthalmologist_record.ucva_re', $ophthalmologistRecord?->ucva_re ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter RE value">
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[ucva_le]"
                                                                            value="<?php echo e(old('ophthalmologist_record.ucva_le', $ophthalmologistRecord?->ucva_le ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter LE value">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none;">
                                                                        <label
                                                                            class="form-label mb-0 fw-semibold">BCVA</label>
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[bcva_re]"
                                                                            value="<?php echo e(old('ophthalmologist_record.bcva_re', $ophthalmologistRecord?->bcva_re ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter RE value">
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[bcva_le]"
                                                                            value="<?php echo e(old('ophthalmologist_record.bcva_le', $ophthalmologistRecord?->bcva_le ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter LE value">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none;">
                                                                        <label class="form-label mb-0 fw-semibold">Anterior<br>
                                                                            Segment</label>
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[anterior_segment_re]"
                                                                            value="<?php echo e(old('ophthalmologist_record.anterior_segment_re', $ophthalmologistRecord?->anterior_segment_re ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter RE value">
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[anterior_segment_le]"
                                                                            value="<?php echo e(old('ophthalmologist_record.anterior_segment_le', $ophthalmologistRecord?->anterior_segment_le ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter LE value">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none;">
                                                                        <label
                                                                            class="form-label mb-0 fw-semibold">IOP</label>
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[iop_re]"
                                                                            value="<?php echo e(old('ophthalmologist_record.iop_re', $ophthalmologistRecord?->iop_re ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter RE value">
                                                                    </td>
                                                                    <td style="border: none;">
                                                                        <input type="text"
                                                                            name="ophthalmologist_record[iop_le]"
                                                                            value="<?php echo e(old('ophthalmologist_record.iop_le', $ophthalmologistRecord?->iop_le ?? '')); ?>"
                                                                            class="form-control shadow-none"
                                                                            placeholder="Enter LE value">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                    <div class="row mb-3">




                                            <div class="col-md-6">
                                                <label class="form-label">Diabetic Retinopathy (DR) RE <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy_re]" id="dr_yes_re" value="1"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_retinopathy_re', $ophthalmologistRecord?->diabetic_retinopathy_re) == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dr_yes_re">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy_re]" id="dr_no_re" value="0"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_retinopathy_re', $ophthalmologistRecord?->diabetic_retinopathy_re) == '0' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dr_no_re">No</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['ophthalmologist_record.diabetic_retinopathy_re'];
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
                                            <div class="col-md-6">
                                                <label class="form-label">Type of DR (ETDRS) RE<span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <select class="form-select" id="dr_category_re">
                                                            <option value="">Select Category</option>
                                                            <option value="npdr">NPDR</option>
                                                            <option value="pdr">PDR</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-select" id="type_of_dr_re" name="ophthalmologist_record[type_of_dr_re]">
                                                            <option value="">Select Type</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['ophthalmologist_record.type_of_dr_re'];
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
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Diabetic Retinopathy (DR) LE <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy]" id="dr_yes" value="1"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_retinopathy', $ophthalmologistRecord?->diabetic_retinopathy) == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dr_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy]" id="dr_no" value="0"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_retinopathy', $ophthalmologistRecord?->diabetic_retinopathy) == '0' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dr_no">No</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['ophthalmologist_record.diabetic_retinopathy'];
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
                                            <div class="col-md-6">
                                                <label class="form-label">Type of DR (ETDRS) LE <span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <select class="form-select" id="dr_category">
                                                            <option value="">Select Category</option>
                                                            <option value="npdr">NPDR</option>
                                                            <option value="pdr">PDR</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-select" id="type_of_dr" name="ophthalmologist_record[type_of_dr]">
                                                            <option value="">Select Type</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['ophthalmologist_record.type_of_dr'];
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

    <div class="row mb-3">





                                            <div class="col-md-6">
                                                <label class="form-label">Diabetic Macular Edema (DME) RE<span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema_re]" id="dme_yes_re" value="1"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_macular_edema_re', $ophthalmologistRecord?->diabetic_macular_edema_re) == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dme_yes_re">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema_re]" id="dme_no_re" value="0"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_macular_edema_re', $ophthalmologistRecord?->diabetic_macular_edema_re) == '0' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dme_no_re">No</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['ophthalmologist_record.diabetic_macular_edema'];
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

    <div class="col-md-6">
                                                <label for="type_of_dme_status_re" class="form-label">Type Of DME RE <span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <select class="form-select" id="type_of_dme_status_re" name="dme_status_re">
                                                            <option value="">Select Type</option>
                                                            <option value="nil_absent" <?php echo e(old('dme_status_re', in_array(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme_re ?? ''), ['nil_absent']) ? 'nil_absent' : (in_array(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '')) == 'nil_absent' ? 'selected' : ''); ?>>Nil/Absent</option>
                                                            <option value="present" <?php echo e(old('dme_status', in_array(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '') == 'present' ? 'selected' : ''); ?>>Present</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <!-- Sub-options for Present (shown conditionally) -->
                                                        <div id="dme_severity_container_re" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'block' : 'none'); ?>;">
                                                            <select class="form-select" id="dme_severity_re" name="ophthalmologist_record[type_of_dme_re]">
                                                                <option value="">Select DME</option>
                                                                <option value="mild" <?php echo e(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme_re ?? '') == 'mild' ? 'selected' : ''); ?>>Mild</option>
                                                                <option value="moderate" <?php echo e(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme_re ?? '') == 'moderate' ? 'selected' : ''); ?>>Moderate</option>
                                                                <option value="severe" <?php echo e(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme_re ?? '') == 'severe' ? 'selected' : ''); ?>>Severe (Based On Inv Of Fovea)</option>
                                                            </select>
                                                        </div>
                                                        <!-- Placeholder when severity container is hidden -->
                                                        <div id="dme_severity_placeholder_re" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'none' : 'block'); ?>;">
                                                            <select class="form-select" disabled>
                                                                <option>Select DME</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hidden input for Nil/Absent value -->
                                                <input type="hidden" name="ophthalmologist_record[type_of_dme_re]" id="dme_hidden_nil_absent_re" value="nil_absent"
                                                    <?php echo e(old('ophthalmologist_record.type_of_dme_re', $ophthalmologistRecord?->type_of_dme ?? '') == 'nil_absent' ? '' : 'disabled'); ?>>

                                                <?php $__errorArgs = ['ophthalmologist_record.type_of_dme_re'];
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
                        <div class="row mb-3">







                                            <div class="col-md-6">
                                                <label class="form-label">Diabetic Macular Edema (DME) LE <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema]" id="dme_yes" value="1"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_macular_edema', $ophthalmologistRecord?->diabetic_macular_edema) == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dme_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema]" id="dme_no" value="0"
                                                            <?php echo e(old('ophthalmologist_record.diabetic_macular_edema', $ophthalmologistRecord?->diabetic_macular_edema) == '0' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="dme_no">No</label>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['ophthalmologist_record.diabetic_macular_edema'];
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

    <div class="col-md-6">
                                                <label for="type_of_dme_status" class="form-label">Type Of DME LE<span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <select class="form-select" id="type_of_dme_status" name="dme_status">
                                                            <option value="">Select Type</option>
                                                            <option value="nil_absent" <?php echo e(old('dme_status', in_array(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? ''), ['nil_absent']) ? 'nil_absent' : (in_array(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '')) == 'nil_absent' ? 'selected' : ''); ?>>Nil/Absent</option>
                                                            <option value="present" <?php echo e(old('dme_status', in_array(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '') == 'present' ? 'selected' : ''); ?>>Present</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <!-- Sub-options for Present (shown conditionally) -->
                                                        <div id="dme_severity_container" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'block' : 'none'); ?>;">
                                                            <select class="form-select" id="dme_severity" name="ophthalmologist_record[type_of_dme]">
                                                                <option value="">Select DME</option>
                                                                <option value="mild" <?php echo e(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? '') == 'mild' ? 'selected' : ''); ?>>Mild</option>
                                                                <option value="moderate" <?php echo e(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? '') == 'moderate' ? 'selected' : ''); ?>>Moderate</option>
                                                                <option value="severe" <?php echo e(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? '') == 'severe' ? 'selected' : ''); ?>>Severe (Based On Inv Of Fovea)</option>
                                                            </select>
                                                        </div>
                                                        <!-- Placeholder when severity container is hidden -->
                                                        <div id="dme_severity_placeholder" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'none' : 'block'); ?>;">
                                                            <select class="form-select" disabled>
                                                                <option>Select DME</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hidden input for Nil/Absent value -->
                                                <input type="hidden" name="ophthalmologist_record[type_of_dme]" id="dme_hidden_nil_absent" value="nil_absent"
                                                    <?php echo e(old('ophthalmologist_record.type_of_dme', $ophthalmologistRecord?->type_of_dme ?? '') == 'nil_absent' ? '' : 'disabled'); ?>>

                                                <?php $__errorArgs = ['ophthalmologist_record.type_of_dme'];
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



                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Investigations</label>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="edit_fundus_pic" value="fundus_pic"
                                                                            <?php echo e(in_array('fundus_pic', old('ophthalmologist_record.investigations', $ophthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label" for="edit_fundus_pic">Fundus pic</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="edit_oct" value="oct"
                                                                            <?php echo e(in_array('oct', old('ophthalmologist_record.investigations', $ophthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label" for="edit_oct">Oct</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="edit_octa" value="octa"
                                                                            <?php echo e(in_array('octa', old('ophthalmologist_record.investigations', $ophthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label" for="edit_octa">Octa</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="edit_ffa" value="ffa"
                                                                            <?php echo e(in_array('ffa', old('ophthalmologist_record.investigations', $ophthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label" for="edit_ffa">Ffa</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="edit_others_inv" value="others"
                                                                            <?php echo e(in_array('others', old('ophthalmologist_record.investigations', $ophthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                                        <label class="form-check-label" for="edit_others_inv">Others</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2" id="edit_investigations_others_container" style="display: <?php echo e(in_array('others', old('ophthalmologist_record.investigations', $ophthalmologistRecord?->investigations ?? [])) ? 'block' : 'none'); ?>;">
                                                                <div class="col-md-6">
                                                                    <label for="edit_investigations_others" class="form-label">Specify Other Investigations <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control <?php $__errorArgs = ['ophthalmologist_record.investigations_others'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="edit_investigations_others" name="ophthalmologist_record[investigations_others]"
                                                                        value="<?php echo e(old('ophthalmologist_record.investigations_others', $ophthalmologistRecord?->investigations_others ?? '')); ?>"
                                                                        placeholder="Enter other investigations...">
                                                                    <?php $__errorArgs = ['ophthalmologist_record.investigations_others'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>
                                                            <?php $__errorArgs = ['ophthalmologist_record.investigations'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                <label for="advised_re" class="form-label">Advised RE</label>
                                                <select class="form-select" id="advised_re" name="ophthalmologist_record[advised_re]">
                                                    <option value="">Select Treatment</option>
                                                    <option value="no_treatment" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'no_treatment' ? 'selected' : ''); ?>>No treatment</option>
                                                    <option value="close_watch" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'close_watch' ? 'selected' : ''); ?>>Close watch</option>
                                                    <option value="drops" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'drops' ? 'selected' : ''); ?>>Any other drops</option>
                                                    <option value="medications" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'medications' ? 'selected' : ''); ?>>Medications</option>
                                                    <option value="focal_laser" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'focal_laser' ? 'selected' : ''); ?>>Focal laser</option>
                                                    <option value="prp_laser" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'prp_laser' ? 'selected' : ''); ?>>PRP laser</option>
                                                    <option value="intravit_inj" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'intravit_inj' ? 'selected' : ''); ?>>Intravit inj antivefg</option>
                                                    <option value="steroid" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'steroid' ? 'selected' : ''); ?>>Steroid</option>
                                                    <option value="surgery" <?php echo e(old('ophthalmologist_record.advised_re', $ophthalmologistRecord?->advised_re) == 'surgery' ? 'selected' : ''); ?>>Surgery</option>
                                                </select>
                                                <?php $__errorArgs = ['ophthalmologist_record.advised_re'];
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
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="ophthalmologist_advised" class="form-label">Advised LE</label>
                                                            <select class="form-select <?php $__errorArgs = ['ophthalmologist_record.advised'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    id="ophthalmologist_advised"
                                                                    name="ophthalmologist_record[advised]">
                                                                <option value="">Select Treatment</option>
                                                                <option value="no_treatment" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'no_treatment' ? 'selected' : ''); ?>>No treatment</option>
                                                                <option value="close_watch" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'close_watch' ? 'selected' : ''); ?>>Close watch</option>
                                                                <option value="drops" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'drops' ? 'selected' : ''); ?>>Any other drops</option>
                                                                <option value="medications" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'medications' ? 'selected' : ''); ?>>Medications</option>
                                                                <option value="focal_laser" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'focal_laser' ? 'selected' : ''); ?>>Focal laser</option>
                                                                <option value="prp_laser" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'prp_laser' ? 'selected' : ''); ?>>PRP laser</option>
                                                                <option value="intravit_inj" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'intravit_inj' ? 'selected' : ''); ?>>Intravit inj antivefg</option>
                                                                <option value="steroid" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'steroid' ? 'selected' : ''); ?>>Steroid</option>
                                                                <option value="surgery" <?php echo e(old('ophthalmologist_record.advised', $ophthalmologistRecord?->advised) == 'surgery' ? 'selected' : ''); ?>>Surgery</option>
                                                            </select>
                                                            <?php $__errorArgs = ['ophthalmologist_record.advised'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="ophthalmologist_treatment_done_date" class="form-label">Treatment Done Date</label>
                                                            <input type="text"
                                                                class="form-control flatpickr-input <?php $__errorArgs = ['ophthalmologist_record.treatment_done_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="ophthalmologist_treatment_done_date"
                                                                name="ophthalmologist_record[treatment_done_date]"
                                                                value="<?php echo e(old('ophthalmologist_record.treatment_done_date', $ophthalmologistRecord?->treatment_done_date?->format('d-m-Y') ?? '')); ?>"
                                                                placeholder="Select Treatment Date">
                                                            <?php $__errorArgs = ['ophthalmologist_record.treatment_done_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="ophthalmologist_review_date" class="form-label">Review Date</label>
                                                            <input type="text"
                                                                class="form-control flatpickr-input <?php $__errorArgs = ['ophthalmologist_record.review_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                id="ophthalmologist_review_date"
                                                                name="ophthalmologist_record[review_date]"
                                                                value="<?php echo e(old('ophthalmologist_record.review_date', $ophthalmologistRecord?->review_date?->format('d-m-Y') ?? '')); ?>"
                                                                placeholder="Select Review Date">
                                                            <?php $__errorArgs = ['ophthalmologist_record.review_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="ophthalmologist_other_remarks" class="form-label">Other Remarks</label>
                                                            <textarea class="form-control <?php $__errorArgs = ['ophthalmologist_record.other_remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                    id="ophthalmologist_other_remarks"
                                                                    name="ophthalmologist_record[other_remarks]"
                                                                    rows="3"><?php echo e(old('ophthalmologist_record.other_remarks', $ophthalmologistRecord?->other_remarks)); ?></textarea>
                                                            <?php $__errorArgs = ['ophthalmologist_record.other_remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Action Buttons -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-end">
                                                
                                                <div>
                                                    <a href="<?php echo e(route('doctor.patients.medical-records', $appointment->patient_id)); ?>"
                                                    class="btn btn-secondary me-2 my-1">
                                                        Cancel
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-2 my-1"></i>Update
                                                    </button>
                                                </div>
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
            <script src="<?php echo e(asset('plugins/flatpickr/custom-flatpickr.js')); ?>"></script>
            <script src="<?php echo e(asset('js/bmi-interpretation.js')); ?>"></script>

            <script>
                $(document).ready(function() {
                    // BMI interpretation is now handled by the centralized script

                    // Initialize Flatpickr for date/time pickers
                    flatpickr("#visit_date_time", {
                        enableTime: true,
                        dateFormat: "d-m-Y H:i",
                        time_24hr: true
                    });

                    // Flag to prevent infinite loops when updating fields
                    let isUpdatingFromDuration = false;
                    let isUpdatingFromDate = false;

                    // Function to calculate Diabetes From date from years and months
                    // Function to calculate Diabetes From date from years and months
function calculateDiabetesFrom() {
    if (isUpdatingFromDate) return; // Prevent loop

    const years = parseInt(document.getElementById('diabetes_years').value) || 0;
    const months = parseInt(document.getElementById('diabetes_months').value) || 0;
    const diabetesFromField = document.getElementById('diabetes_from');

    if (years === 0 && months === 0) {
        // Clear the diabetes_from field when both years and months are empty/zero
        if (diabetesFromField.value) {
            diabetesFromField.value = '';
            // Also update flatpickr instance if it exists
            if (window.diabetesFromFlatpickr) {
                window.diabetesFromFlatpickr.clear();
            }
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
        if (typeof diabetesFromDate === 'string') {
            // If it's a string in "m-Y" format
            const [month, year] = diabetesFromDate.split('-');
            fromDate = new Date(year, month - 1, 1); // month is 0-indexed
        } else {
            // If it's already a Date object
            fromDate = diabetesFromDate;
        }

                        // Calculate the difference in years and months
                        let years = today.getFullYear() - fromDate.getFullYear();
                        let months = today.getMonth() - fromDate.getMonth();

                        // Adjust if months difference is negative
                        if (months < 0) {
                            years--;
                            months += 12;
                        }

                        // Set the values
                        document.getElementById('diabetes_years').value = years;
                        document.getElementById('diabetes_months').value = months;

                        setTimeout(() => {
                            isUpdatingFromDate = false;
                        }, 100);
                    }

                    // Initialize flatpickr for diabetes_from
                    const diabetesFrom = document.getElementById('diabetes_from');
                    if (diabetesFrom) {
                        window.diabetesFromFlatpickr = flatpickr(diabetesFrom, {
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
                    }

                    // Add event listeners to years and months fields
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
                    if (diabetesFrom && diabetesFrom.value) {
                        // Parse the YYYY-MM format
                        const dateValue = diabetesFrom.value;
                        if (dateValue) {
                            const dateParts = dateValue.split('-');
                            if (dateParts.length === 2) {
                                const month = parseInt(dateParts[0]) - 1; // Months are 0-indexed
                                const year = parseInt(dateParts[1]);
                                const date = new Date(year, month, 1);
                                calculateDiabetesSince(date);
                            }
                        }
                    } else if ((diabetesYearsField && diabetesYearsField.value) || (diabetesMonthsField && diabetesMonthsField.value)) {
                        calculateDiabetesFrom();
                    }

                    flatpickr("#date_of_birth", {
                        dateFormat: "d-m-Y",
                        maxDate: "today",

                    });

                    // Flag to prevent infinite loops when updating BP fields
                    let isUpdatingBPFromDuration = false;
                    let isUpdatingBPFromDate = false;

                    // Function to calculate BP Since date from years and months
                    // Function to calculate BP Since date from years and months
function calculateBPFrom() {
    if (isUpdatingBPFromDate) return; // Prevent loop

    const years = parseInt(document.getElementById('bp_years').value) || 0;
    const months = parseInt(document.getElementById('bp_months').value) || 0;
    const bpSinceField = document.getElementById('bp_since');

    if (!bpSinceField) return;

    if (years === 0 && months === 0) {
        // Clear the bp_since field when both years and months are empty/zero
        if (bpSinceField.value) {
            bpSinceField.value = '';
            // Also update flatpickr instance if it exists
            if (window.bpSinceFlatpickr) {
                window.bpSinceFlatpickr.clear();
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
                        // Parse the m-Y format
        let fromDate;
        if (typeof bpSinceDate === 'string') {
            // If it's a string in "m-Y" format
            const [month, year] = bpSinceDate.split('-');
            fromDate = new Date(year, month - 1, 1); // month is 0-indexed
        } else {
            // If it's already a Date object
            fromDate = bpSinceDate;
        }

                        // Calculate the difference in years and months
                        let years = today.getFullYear() - fromDate.getFullYear();
                        let months = today.getMonth() - fromDate.getMonth();

                        // Adjust if months difference is negative
                        if (months < 0) {
                            years--;
                            months += 12;
                        }

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
                    const bpSince = document.getElementById('bp_since');
                    if (bpSince) {
                        window.bpSinceFlatpickr = flatpickr(bpSince, {
                            dateFormat: "m-Y",
                            maxDate: "today",
                            onChange: function(selectedDates, dateStr, instance) {
                                if (selectedDates.length > 0) {
                                    calculateBPDuration(selectedDates[0]);
                                } else {
                                    const bpYearsField = document.getElementById('bp_years');
                                    const bpMonthsField = document.getElementById('bp_months');
                                    if (bpYearsField) bpYearsField.value = '';
                                    if (bpMonthsField) bpMonthsField.value = '';
                                }
                            }
                        });
                    }

                    // Add event listeners to BP years and months fields
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

                    flatpickr("#ophthalmologist_treatment_done_date", {
                        dateFormat: "d-m-Y",
                        maxDate: "today"
                    });

                    flatpickr("#ophthalmologist_review_date", {
                        dateFormat: "d-m-Y",
                        minDate: "today"
                    });

                    // Toggle "Others" textbox visibility for physician record
                    const othersCheckbox = document.getElementById('physician_others_treatment');
                    const othersContainer = document.getElementById('current_treatment_other_container');
                    const othersInput = document.getElementById('current_treatment_other');

                    if (othersCheckbox && othersContainer && othersInput) {
                        // Handle initial state
                        const isChecked = othersCheckbox.checked;
                        othersContainer.style.display = isChecked ? 'block' : 'none';

                        // Handle checkbox change
                        othersCheckbox.addEventListener('change', function() {
                            const checked = this.checked;
                            othersContainer.style.display = checked ? 'block' : 'none';
                            if (!checked) {
                                othersInput.value = '';
                            }
                        });
                    }
                });

                // Handle "Others" checkbox for Investigations
                document.addEventListener('DOMContentLoaded', function() {
                    const othersCheckbox = document.getElementById('edit_others_inv');
                    const othersContainer = document.getElementById('edit_investigations_others_container');
                    const othersInput = document.getElementById('edit_investigations_others');

                    if (othersCheckbox && othersContainer && othersInput) {
                        // Handle checkbox change
                        othersCheckbox.addEventListener('change', function() {
                            if (this.checked) {
                                othersContainer.style.display = 'block';
                            } else {
                                othersContainer.style.display = 'none';
                                othersInput.value = '';
                                // Clear any error messages
                                $(othersInput).siblings('.field-error').remove();
                            }
                        });

                        // Initial state check
                        if (othersCheckbox.checked) {
                            othersContainer.style.display = 'block';
                        }
                    }
                });

                // Populate Type of DR options based on category for edit form
                document.addEventListener('DOMContentLoaded', function() {
                    const categoryEl = document.getElementById('dr_category');
                    const typeEl = document.getElementById('type_of_dr');
                    if (!categoryEl || !typeEl) return;

                    const NPDR_OPTIONS = [
                        { value: 'npdr_mild', label: 'Mild' },
                        { value: 'npdr_moderate', label: 'Moderate' },
                        { value: 'npdr_severe', label: 'Severe' },
                        { value: 'npdr_very_severe', label: 'Very Severe' },
                    ];
                    const PDR_OPTIONS = [
                        { value: 'pdr_non_high_risk', label: 'Non-High Risk' },
                        { value: 'pdr_high_risk', label: 'High Risk' },
                    ];

                    function populateTypeOptions(category) {
                        const current = typeEl.value;
                        typeEl.innerHTML = '<option value="">Select type</option>';
                        const options = category === 'npdr' ? NPDR_OPTIONS : category === 'pdr' ? PDR_OPTIONS : [];
                        options.forEach(opt => {
                            const o = document.createElement('option');
                            o.value = opt.value;
                            o.textContent = opt.label;
                            typeEl.appendChild(o);
                        });
                        if (current && [...typeEl.options].some(o => o.value === current)) {
                            typeEl.value = current;
                        }
                    }

                    const oldValue = '<?php echo e(old('ophthalmologist_record.type_of_dr', $ophthalmologistRecord?->type_of_dr ?? '')); ?>';
                    if (oldValue && oldValue.trim() !== '') {
                    if (oldValue.startsWith('npdr')) {
                        categoryEl.value = 'npdr';
                        populateTypeOptions('npdr');
                            // Set the value after options are populated
                            setTimeout(() => {
                        typeEl.value = oldValue;
                            }, 0);
                    } else if (oldValue.startsWith('pdr')) {
                        categoryEl.value = 'pdr';
                        populateTypeOptions('pdr');
                            // Set the value after options are populated
                            setTimeout(() => {
                        typeEl.value = oldValue;
                            }, 0);
                        }
                    }

                    categoryEl.addEventListener('change', function() {
                        populateTypeOptions(this.value);
                    });
                });


                    document.addEventListener('DOMContentLoaded', function() {
                    const categoryEl = document.getElementById('dr_category_re');
                    const typeEl = document.getElementById('type_of_dr_re');
                    if (!categoryEl || !typeEl) return;

                    const NPDR_OPTIONS = [
                        { value: 'npdr_mild', label: 'Mild' },
                        { value: 'npdr_moderate', label: 'Moderate' },
                        { value: 'npdr_severe', label: 'Severe' },
                        { value: 'npdr_very_severe', label: 'Very Severe' },
                    ];
                    const PDR_OPTIONS = [
                        { value: 'pdr_non_high_risk', label: 'Non-High Risk' },
                        { value: 'pdr_high_risk', label: 'High Risk' },
                    ];

                    function populateTypeOptions(category) {
                        const current = typeEl.value;
                        typeEl.innerHTML = '<option value="">Select type</option>';
                        const options = category === 'npdr' ? NPDR_OPTIONS : category === 'pdr' ? PDR_OPTIONS : [];
                        options.forEach(opt => {
                            const o = document.createElement('option');
                            o.value = opt.value;
                            o.textContent = opt.label;
                            typeEl.appendChild(o);
                        });
                        if (current && [...typeEl.options].some(o => o.value === current)) {
                            typeEl.value = current;
                        }
                    }

                    const oldValue = '<?php echo e(old('ophthalmologist_record.type_of_dr_re', $ophthalmologistRecord?->type_of_dr_re ?? '')); ?>';
                    if (oldValue && oldValue.trim() !== '') {
                    if (oldValue.startsWith('npdr')) {
                        categoryEl.value = 'npdr';
                        populateTypeOptions('npdr');
                            // Set the value after options are populated
                            setTimeout(() => {
                        typeEl.value = oldValue;
                            }, 0);
                    } else if (oldValue.startsWith('pdr')) {
                        categoryEl.value = 'pdr';
                        populateTypeOptions('pdr');
                            // Set the value after options are populated
                            setTimeout(() => {
                        typeEl.value = oldValue;
                            }, 0);
                        }
                    }

                    categoryEl.addEventListener('change', function() {
                        populateTypeOptions(this.value);
                    });
                });

                // DME Type conditional logic with dropdowns for edit appointment
                document.addEventListener('DOMContentLoaded', function() {
                    const dmeStatusSelect = document.getElementById('edit_type_of_dme_status');
                    const dmeSeverityContainer = document.getElementById('edit_dme_severity_container');
                    const dmeSeveritySelect = document.getElementById('edit_dme_severity');
                    const dmeHiddenNilAbsent = document.getElementById('edit_dme_hidden_nil_absent');

                    if (!dmeStatusSelect || !dmeSeverityContainer || !dmeHiddenNilAbsent) return;

                    const dmeSeverityPlaceholder = document.getElementById('edit_dme_severity_placeholder');

                    function updateDMEFields() {
                        const selectedStatus = dmeStatusSelect ? dmeStatusSelect.value : '';

                        if (selectedStatus === 'nil_absent') {
                            // Nil/Absent selected
                            dmeSeverityContainer.style.display = 'none';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'block';
                            }
                            // Disable and clear severity dropdown
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = true;
                                dmeSeveritySelect.value = '';
                            }
                            // Enable hidden input for nil_absent
                            dmeHiddenNilAbsent.disabled = false;
                        } else if (selectedStatus === 'present') {
                            // Present selected
                            dmeSeverityContainer.style.display = 'block';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'none';
                            }
                            // Enable severity dropdown
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = false;
                            }
                            // Disable hidden input
                            dmeHiddenNilAbsent.disabled = true;
                        } else {
                            // Nothing selected
                            dmeSeverityContainer.style.display = 'none';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'block';
                            }
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = true;
                                dmeSeveritySelect.value = '';
                            }
                            dmeHiddenNilAbsent.disabled = true;
                        }
                    }

                    // Handle status dropdown change
                    dmeStatusSelect.addEventListener('change', updateDMEFields);

                    // Initial state
                    updateDMEFields();
                });

                function confirmDelete() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this! This will permanently delete the appointment and any associated medical records.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form to submit the delete request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '<?php echo e(route("doctor.patients.appointments.delete", $appointment->id)); ?>';

                            // Add CSRF token
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '<?php echo e(csrf_token()); ?>';
                            form.appendChild(csrfToken);

                            // Add method override
                            const methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = 'DELETE';
                            form.appendChild(methodField);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }

            // Height unit conversion and BMI calculation
    const heightInput = document.getElementById('height');
    const weightInput = document.getElementById('weight');
    const bmiInput = document.getElementById('bmi1');
    const unitMeter = document.getElementById('unit_meter');
    const unitFeet = document.getElementById('unit_feet');
    const unitDisplay = document.getElementById('height-unit-display');
    const heightHint = document.getElementById('height-hint');

    function updateHeightConstraints() {
        if (unitFeet.checked) {
            // Feet configuration
            heightInput.setAttribute('min', '2');
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
        console.log(height,weight,heightInMeters,bmi);

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
    unitMeter?.addEventListener('change', function() {
        heightInput.dataset.converted = 'false';
        updateHeightConstraints();
    });

    unitFeet?.addEventListener('change', function() {
        heightInput.dataset.converted = 'false';
        updateHeightConstraints();
    });

    // Event listeners for BMI calculation
    heightInput?.addEventListener('input', calculateBMI);
    weightInput?.addEventListener('input', calculateBMI);

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateHeightConstraints();
        calculateBMI();
    });


                // Age Auto-calculation from Date of Birth
                function calculateAge() {
                    const dateOfBirth = $('#date_of_birth').val();

                    if (dateOfBirth) {
                        const today = new Date();
                        const birthDate = new Date(dateOfBirth);
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();

                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }

                        if (age >= 0 && age <= 120) {
                            $('#age').val(age);

                            // Clear validation error for age field
                            $('#age').closest('.form-group').find('.text-danger').remove();
                        } else {
                            $('#age').val('');
                        }
                    } else {
                        $('#age').val('');
                    }
                }

                // Calculate age on page load if date of birth is already set


                // BMI calculation is now handled by the centralized script


                // BP Since field visibility control
                function toggleBpSinceField() {
                    const bpValue = $('input[name="bp"]:checked').val();
                    const bpSinceContainer = $('#bp_since_container');
                    const bpDurationContainer = $('#bp_duration_container');

                    if (bpValue === '1') {
                        bpSinceContainer.show();
                        // Show BP Duration if BP Since has a value
                        const bpSince = $('#bp_since').val();
                        if (bpSince) {
                            bpDurationContainer.show();
                            // Calculate BP Duration from date if it exists
                            if (bpSince) {
                                const dateParts = bpSince.split('-');
                                if (dateParts.length === 2) {
                                    const year = parseInt(dateParts[0]);
                                    const month = parseInt(dateParts[1]) - 1;
                                    const date = new Date(year, month, 1);
                                    if (window.calculateBPDuration) {
                                        window.calculateBPDuration(date);
                                    }
                                }
                            }
                        } else {
                            bpDurationContainer.show();
                        }
                    } else {
                        bpSinceContainer.hide();
                        bpDurationContainer.hide();
                        $('#bp_since').val(''); // Clear the value when hidden
                        $('#bp_years').val(''); // Clear years when hidden
                        $('#bp_months').val(''); // Clear months when hidden
                    }
                }

                // Initialize BP Since field visibility on page load
                toggleBpSinceField();

                // Toggle BP Since field when BP radio buttons change
                $('input[name="bp"]').on('change', toggleBpSinceField);

                // Email validation
                const emailField = $('#email');
                const emailError = $('#email-error');

                if (emailField.length && emailError.length) {
                    emailField.on('input blur', function() {
                        validateEmail();
                    });

                    function validateEmail() {
                        const email = emailField.val().trim();

                        // Only validate if email is not empty
                        if (email !== '') {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            if (!emailRegex.test(email)) {
                                emailError.text('Valid email address is required.');
                                emailError.css({
                                    'display': 'block',
                                    'font-size': '0.875rem',
                                    'margin-top': '0.25rem'
                                });
                            } else {
                                emailError.hide();
                            }
                        } else {
                            emailError.hide();
                        }
                    }
                }

                // Function to show error message under field
                function showFieldError(fieldId, message) {
                    // Remove existing error message
                    $('#' + fieldId).siblings('.field-error').remove();
                    // Add new error message
                    $('#' + fieldId).after('<div class="field-error text-danger mt-1">' + message + '</div>');
                }

                // Function to clear field error
                function clearFieldError(fieldId) {
                    $('#' + fieldId).siblings('.field-error').remove();
                }

                // Clear errors on input
                $('input, select, textarea').on('input change', function() {
                    clearFieldError($(this).attr('id'));
                });

                // Clear error on investigations_others input
                $('#edit_investigations_others').on('input', function() {
                    clearFieldError('edit_investigations_others');
                });

                // Clear errors on radio button and checkbox change
                $('input[type="radio"], input[type="checkbox"]').on('change', function() {
                    const container = $(this).closest('.form-group');
                    if (container.length) {
                        container.find('.field-error').remove();
                    }
                });

                // Type of Treatment "Others" field - show/hide and manage required attribute
                function toggleTypeOfTreatmentOther() {
                    const othersCheckbox = document.getElementById('others_treatment');
                    const otherContainer = document.getElementById('type_of_treatment_other_container');
                    const otherInput = document.getElementById('type_of_treatment_other');

                    if (othersCheckbox && otherContainer && otherInput) {
                        if (othersCheckbox.checked) {
                            otherContainer.style.display = 'block';
            
                        } else {
                            otherContainer.style.display = 'none';
                    
                            otherInput.value = ''; // Clear value when hidden
                        }
                    }
                }

                // Other Diseases "Others" field - show/hide and manage required attribute
                function toggleOtherDiseasesOther() {
                    const othersCheckbox = document.getElementById('others_diseases');
                    const otherContainer = document.getElementById('other_diseases_other_container');
                    const otherInput = document.getElementById('other_diseases_other');

                    if (othersCheckbox && otherContainer && otherInput) {
                        if (othersCheckbox.checked) {
                            otherContainer.style.display = 'block';
                        
                        } else {
                            otherContainer.style.display = 'none';
                        
                            otherInput.value = ''; // Clear value when hidden
                        }
                    }
                }
                

                // Initialize toggle functions on page load
                $(document).ready(function() {
                    const othersTreatment = document.getElementById('others_treatment');
                    if (othersTreatment) {
                        othersTreatment.addEventListener('change', toggleTypeOfTreatmentOther);
                        // Check on page load - initialize visibility
                        toggleTypeOfTreatmentOther();
                    }

                    const othersDiseases = document.getElementById('others_diseases');
                    if (othersDiseases) {
                        othersDiseases.addEventListener('change', toggleOtherDiseasesOther);
                        // Check on page load - initialize visibility
                        toggleOtherDiseasesOther();
                    }

                    // Also listen to all checkboxes in case "others" gets unchecked via other checkboxes
                    const typeOfTreatmentCheckboxes = document.querySelectorAll('input[name="type_of_treatment[]"]');
                    typeOfTreatmentCheckboxes.forEach(function(checkbox) {
                        checkbox.addEventListener('change', toggleTypeOfTreatmentOther);
                    });

                    const otherDiseasesCheckboxes = document.querySelectorAll('input[name="other_diseases[]"]');
                    otherDiseasesCheckboxes.forEach(function(checkbox) {
                        checkbox.addEventListener('change', toggleOtherDiseasesOther);
                    });
                });

                // Handle "Other" checkbox functionality for physician record
                $('#physician_other_condition').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#physician_others_details_row').show();
                    } else {
                        $('#physician_others_details_row').hide();
                        $('#physician_others_details').val('');
                    }
                });

                // Check if "Other" is already selected on page load
                if ($('#physician_other_condition').is(':checked')) {
                    $('#physician_others_details_row').show();
                }

                // Form validation
                $('#editAppointmentForm').on('submit', function(e) {
                    // Prevent browser default validation
                    e.preventDefault();

                    // Clear all previous errors
                    $('.field-error').remove();

                    const name = $('#name').val().trim();
                    const diabetesFrom = $('#diabetes_from').val();
                    const dateOfBirth = $('#date_of_birth').val();
                    const age = $('#age').val();
                    const sex = $('#sex').val();
                    const shortAddress = $('#short_address').val().trim();
                    const onTreatment = $('input[name="on_treatment"]:checked').val();
                    const typeOfTreatment = $('input[name="type_of_treatment[]"]:checked').length;
                    console.log('typeOfTreatment:', typeOfTreatment ,'onTreatment:', onTreatment);
                    const bp = $('input[name="bp"]:checked').length;
                    const bpValue = $('input[name="bp"]:checked').val();
                    const bpSince = $('#bp_since').val();

                    // Medical record fields
                    // const physicianTypeOfDiabetes = $('#physician_type_of_diabetes').val();
                    const physicianFamilyHistory = $('#physician_family_history').val();
                    const physicianCompliance = $('input[name="physician_record[compliance]"]:checked').val();
                    const physicianBloodSugarType = $('#blood_sugar_type').val();
                    const physicianBloodSugarValue = $('#blood_sugar_value').val();

                    const ophthalmologistDR = $('#ophthalmologist_diabetic_retinopathy').val();
                    const ophthalmologistDME = $('#ophthalmologist_diabetic_macular_edema').val();
                    const ophthalmologistTypeOfDR = $('#ophthalmologist_type_of_dr').val();
                    const ophthalmologistAdvised = $('#ophthalmologist_advised').val();

                    // Your existing validation variables...
    const physicianTypeOfDiabetes = $('#type_of_diabetes').val(); // Add this line
                    

                    let hasErrors = false;

                    // Check individual required fields and show specific error messages
                    if (!name) {
                        showFieldError('name', 'Please enter Name.');
                        hasErrors = true;
                    }



                    if (!age) {
                        showFieldError('age', 'Please enter Age.');
                        hasErrors = true;
                    }

                    if (!sex) {
                        showFieldError('sex', 'Please select Sex.');
                        hasErrors = true;
                    }

                    if (!shortAddress) {
                        showFieldError('short_address', 'Please enter Short Address.');
                        hasErrors = true;
                    }

                    if (!onTreatment) {
                        // Find the parent container and show error there
                        const onTreatmentContainer = $('input[name="on_treatment"]').closest('.form-group');
                        if (onTreatmentContainer.length) {
                            onTreatmentContainer.find('.field-error').remove();
                            onTreatmentContainer.append('<div class="field-error text-danger mt-1">Please select On Treatment option.</div>');
                        }
                        hasErrors = true;
                    }

                    if (typeOfTreatment === 0 && onTreatment === '1') {
                        // Find the parent container and show error there
                        const treatmentContainer = $('input[name="type_of_treatment[]"]').closest('.form-group');
                        if (treatmentContainer.length) {
                            treatmentContainer.find('.field-error').remove();
                            treatmentContainer.append('<div class="field-error text-danger mt-1">Please select at least one Type Of Treatment.</div>');
                        }
                        hasErrors = true;
                    }

                    if (!bp) {
                        // Find the parent container and show error there
                        const bpContainer = $('input[name="bp"]').closest('.form-group');
                        if (bpContainer.length) {
                            bpContainer.find('.field-error').remove();
                            bpContainer.append('<div class="field-error text-danger mt-1">Please select BP option.</div>');
                        }
                        hasErrors = true;
                    }


                    // Validate physician record fields if they exist
                    if ($('#physician_type_of_diabetes').length && !physicianTypeOfDiabetes) {
                        showFieldError('physician_type_of_diabetes', 'Please select Type of Diabetes.');
                        hasErrors = true;
                    }

                     // Validate physician current treatment
    const physicianCurrentTreatment = $('input[name="physician_record[current_treatment][]"]:checked').length;
    const physicianOthersCheckbox = document.getElementById('physician_others_treatment');
    const physicianOtherInput = document.getElementById('current_treatment_other');
    
    if ($('#physician_type_of_diabetes').length && physicianCurrentTreatment === 0) {
        const treatmentContainer = $('input[name="physician_record[current_treatment][]"]').closest('.form-group');
        if (treatmentContainer.length) {
            treatmentContainer.find('.field-error').remove();
            treatmentContainer.append('<div class="field-error text-danger mt-1">Please select at least one Current Treatment option.</div>');
        }
        hasErrors = true;
    }

     // Validate physician "Specify Other Treatment" when "Others" is checked
    if (physicianOthersCheckbox && physicianOthersCheckbox.checked) {
        if (!physicianOtherInput || !physicianOtherInput.value || !physicianOtherInput.value.trim()) {
            showFieldError('current_treatment_other', 'Please specify other treatment.');
            hasErrors = true;
        }
    }

                    if ($('#physician_family_history').length && !physicianFamilyHistory) {
                        showFieldError('physician_family_history', 'Please select Family History of Diabetes.');
                        hasErrors = true;
                    }

                    if ($('input[name="physician_record[compliance]"]').length && !physicianCompliance) {
                        const complianceContainer = $('input[name="physician_record[compliance]"]').closest('.form-group').length ? $('input[name="physician_record[compliance]"]').closest('.form-group') : $('input[name="physician_record[compliance]"]').parent().parent();
                        complianceContainer.find('.field-error').remove();
                        complianceContainer.append('<div class="field-error text-danger mt-1">Please select Compliance.</div>');
                        hasErrors = true;
                    }

                    // Add Type of Diabetes validation - SAME PATTERN AS BLOOD SUGAR TYPE
    if ($('#type_of_diabetes').length && !physicianTypeOfDiabetes) {
        showFieldError('type_of_diabetes', 'Please select Type of Diabetes.');
        hasErrors = true;
    }

                    if ($('#blood_sugar_type').length && !physicianBloodSugarType) {
                        showFieldError('blood_sugar_type', 'Please select Blood Sugar Type.');
                        hasErrors = true;
                    }

                    if ($('#blood_sugar_value').length && !physicianBloodSugarValue) {
                        showFieldError('blood_sugar_value', 'Please enter Blood Sugar Value.');
                        hasErrors = true;
                    }

                    // Validate ophthalmologist record fields if they exist
                    if ($('#ophthalmologist_diabetic_retinopathy').length && !ophthalmologistDR) {
                        showFieldError('ophthalmologist_diabetic_retinopathy', 'Please select Diabetic Retinopathy (DR).');
                        hasErrors = true;
                    }

                    if ($('#ophthalmologist_diabetic_macular_edema').length && !ophthalmologistDME) {
                        showFieldError('ophthalmologist_diabetic_macular_edema', 'Please select Diabetic Macular Edema (DME).');
                        hasErrors = true;
                    }

                    if ($('#ophthalmologist_type_of_dr').length && !ophthalmologistTypeOfDR) {
                        showFieldError('ophthalmologist_type_of_dr', 'Please select Type of DR.');
                        hasErrors = true;
                    }

                    

                    // Validate investigations_others when "others" is selected
                    const editOthersCheckbox = document.getElementById('edit_others_inv');
                    const editOthersInput = document.getElementById('edit_investigations_others');
                    if (editOthersCheckbox && editOthersCheckbox.checked) {
                        if (!editOthersInput || !editOthersInput.value || !editOthersInput.value.trim()) {
                            showFieldError('edit_investigations_others', 'Please specify other investigations.');
                            hasErrors = true;
                        }
                    }

                    // If no errors, submit the form
                    if (!hasErrors) {
                        this.submit();
                    } else {
                        // Scroll to the first error field
                        const firstErrorField = $('.field-error').first().prev();
                        if (firstErrorField.length) {
                            $('html, body').animate({
                                scrollTop: firstErrorField.offset().top - 100
                            }, 500);
                        }
                    }
                });

                document.addEventListener("DOMContentLoaded", function () {

        // ---------------------------------------------------
        // Initialize sections on page load based on old values
        // ---------------------------------------------------
        initializeSection("ophthalmologist_record[diabetic_retinopathy]", "dr_category");
        initializeSection("ophthalmologist_record[diabetic_retinopathy_re]", "dr_category_re");
        initializeSection("ophthalmologist_record[diabetic_macular_edema]", "type_of_dme_status");
        initializeSection("ophthalmologist_record[diabetic_macular_edema_re]", "type_of_dme_status_re");

        // ---------------------------------------------------
        // Add change listeners to show/hide when user selects
        // ---------------------------------------------------
        addChangeListener("ophthalmologist_record[diabetic_retinopathy]", "dr_category");
        addChangeListener("ophthalmologist_record[diabetic_retinopathy_re]", "dr_category_re");
        addChangeListener("ophthalmologist_record[diabetic_macular_edema]", "type_of_dme_status");
        addChangeListener("ophthalmologist_record[diabetic_macular_edema_re]", "type_of_dme_status_re");

        // ---------------------------------------------------
        // Helper: Initialize based on previous (old()) values
        // ---------------------------------------------------
        function initializeSection(radioName, sectionId) {
            const selected = document.querySelector(`input[name="${radioName}"]:checked`);

            if (selected && selected.value === "1") {
                toggleSection(sectionId, true);
            } else {
                toggleSection(sectionId, false);
                clearInputs(sectionId);
            }
        }

        // ---------------------------------------------------
        // Helper: Add change listener for each radio group
        // ---------------------------------------------------
        function addChangeListener(radioName, sectionId) {
            document.querySelectorAll(`input[name="${radioName}"]`).forEach(radio => {
                radio.addEventListener("change", function () {
                    const show = this.value === "1";
                    toggleSection(sectionId, show);
                    if (!show) {
                        clearInputs(sectionId);
                    }
                });
            });
        }

        // ---------------------------------------------------
        // Helper: Show / Hide wrapper col
        // ---------------------------------------------------
        function toggleSection(id, show) {
            const el = document.getElementById(id);
            if (el) {
                el.closest(".col-md-6").style.display = show ? "block" : "none";
            }
        }

        // ---------------------------------------------------
        // Helper: Clear all inputs inside the section
        // ---------------------------------------------------
        function clearInputs(id) {
            const section = document.getElementById(id);
            if (!section) return;

            section.querySelectorAll("input, select, textarea").forEach(field => {
                field.value = "";
                if (field.type === "checkbox" || field.type === "radio") {
                    field.checked = false;
                }
            });
        }

    });

    document.addEventListener('DOMContentLoaded', function() {
                    const dmeStatusSelect = document.getElementById('type_of_dme_status');
                    const dmeSeverityContainer = document.getElementById('dme_severity_container');
                    const dmeSeveritySelect = document.getElementById('dme_severity');
                    const dmeHiddenNilAbsent = document.getElementById('dme_hidden_nil_absent');

                    if (!dmeStatusSelect || !dmeSeverityContainer || !dmeHiddenNilAbsent) return;

                    const dmeSeverityPlaceholder = document.getElementById('dme_severity_placeholder');

                    function updateDMEFields() {
                        const selectedStatus = dmeStatusSelect ? dmeStatusSelect.value : '';

                        if (selectedStatus === 'nil_absent') {
                            // Nil/Absent selected
                            dmeSeverityContainer.style.display = 'none';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'block';
                            }
                            // Disable and clear severity dropdown
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = true;
                                dmeSeveritySelect.value = '';
                            }
                            // Enable hidden input for nil_absent
                            dmeHiddenNilAbsent.disabled = false;
                        } else if (selectedStatus === 'present') {
                            // Present selected
                            dmeSeverityContainer.style.display = 'block';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'none';
                            }
                            // Enable severity dropdown
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = false;
                            }
                            // Disable hidden input
                            dmeHiddenNilAbsent.disabled = true;
                        } else {
                            // Nothing selected
                            dmeSeverityContainer.style.display = 'none';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'block';
                            }
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = true;
                                dmeSeveritySelect.value = '';
                            }
                            dmeHiddenNilAbsent.disabled = true;
                        }
                    }

                    // Handle status dropdown change
                    dmeStatusSelect.addEventListener('change', updateDMEFields);

                    // Initial state
                    updateDMEFields();
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const dmeStatusSelect = document.getElementById('type_of_dme_status_re');
                    const dmeSeverityContainer = document.getElementById('dme_severity_container_re');
                    const dmeSeveritySelect = document.getElementById('dme_severity_re');
                    const dmeHiddenNilAbsent = document.getElementById('dme_hidden_nil_absent_re');

                    if (!dmeStatusSelect || !dmeSeverityContainer || !dmeHiddenNilAbsent) return;

                    const dmeSeverityPlaceholder = document.getElementById('dme_severity_placeholder_re');

                    function updateDMEFields() {
                        const selectedStatus = dmeStatusSelect ? dmeStatusSelect.value : '';

                        if (selectedStatus === 'nil_absent') {
                            // Nil/Absent selected
                            dmeSeverityContainer.style.display = 'none';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'block';
                            }
                            // Disable and clear severity dropdown
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = true;
                                dmeSeveritySelect.value = '';
                            }
                            // Enable hidden input for nil_absent
                            dmeHiddenNilAbsent.disabled = false;
                        } else if (selectedStatus === 'present') {
                            // Present selected
                            dmeSeverityContainer.style.display = 'block';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'none';
                            }
                            // Enable severity dropdown
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = false;
                            }
                            // Disable hidden input
                            dmeHiddenNilAbsent.disabled = true;
                        } else {
                            // Nothing selected
                            dmeSeverityContainer.style.display = 'none';
                            if (dmeSeverityPlaceholder) {
                                dmeSeverityPlaceholder.style.display = 'block';
                            }
                            if (dmeSeveritySelect) {
                                dmeSeveritySelect.disabled = true;
                                dmeSeveritySelect.value = '';
                            }
                            dmeHiddenNilAbsent.disabled = true;
                        }
                    }

                    // Handle status dropdown change
                    dmeStatusSelect.addEventListener('change', updateDMEFields);

                    // Initial state
                    updateDMEFields();
                });
    document.addEventListener('DOMContentLoaded', function() {
        const treatmentContainer = document.getElementById('type_of_treatment_container');
        const otherTreatmentContainer = document.getElementById('type_of_treatment_other_container');
        const othersCheckbox = document.getElementById('others_treatment');
        const otherTreatmentInput = document.getElementById('type_of_treatment_other');

        function toggleTreatmentFields() {
            const onTreatmentYes = document.getElementById('on_treatment_yes');
            
            if (onTreatmentYes && onTreatmentYes.checked) {
                if (treatmentContainer) treatmentContainer.style.display = 'block';
            } else {
                if (treatmentContainer) treatmentContainer.style.display = 'none';
                
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
                    if (otherTreatmentContainer) otherTreatmentContainer.style.display = 'block';
                } else {
                    if (otherTreatmentContainer) otherTreatmentContainer.style.display = 'none';
                    if (otherTreatmentInput) otherTreatmentInput.value = '';
                }
            });
        }
    });
    // Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const othersCheckbox = document.getElementById('others_treatment');
    const otherInput = document.getElementById('type_of_treatment_other');
    
    if (othersCheckbox && otherInput) {
        othersCheckbox.addEventListener('change', function() {
            if (!this.checked) {
                otherInput.value = '';
            }
        });
        
        // Also clear when all checkboxes are unchecked via "Not On Treatment"
        const onTreatmentNo = document.getElementById('on_treatment_no');
        if (onTreatmentNo) {
            onTreatmentNo.addEventListener('change', function() {
                if (this.checked) {
                    otherInput.value = '';
                }
            });
        }
    }
});

// Handle physician "Others" checkbox functionality
document.addEventListener('DOMContentLoaded', function() {
    const physicianOthersCheckbox = document.getElementById('physician_others_treatment');
    const physicianOtherContainer = document.getElementById('current_treatment_other_container');
    const physicianOtherInput = document.getElementById('current_treatment_other');

    function togglePhysicianOtherField() {
        if (physicianOthersCheckbox && physicianOtherContainer && physicianOtherInput) {
            if (physicianOthersCheckbox.checked) {
                physicianOtherContainer.style.display = 'block';
            } else {
                physicianOtherContainer.style.display = 'none';
                physicianOtherInput.value = ''; // Clear value when hidden
            }
        }
    }

    // Initial state
    togglePhysicianOtherField();

    // Listen for changes
    if (physicianOthersCheckbox) {
        physicianOthersCheckbox.addEventListener('change', togglePhysicianOtherField);
    }

    // Also listen to all physician current treatment checkboxes
    const physicianTreatmentCheckboxes = document.querySelectorAll('input[name="physician_record[current_treatment][]"]');
    physicianTreatmentCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // If "others" gets unchecked, clear the field
            if (checkbox.id === 'physician_others_treatment' && !checkbox.checked) {
                if (physicianOtherInput) {
                    physicianOtherInput.value = '';
                }
            }
            togglePhysicianOtherField();
        });
    });
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
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/doctor/patients/edit-appointment.blade.php ENDPATH**/ ?>