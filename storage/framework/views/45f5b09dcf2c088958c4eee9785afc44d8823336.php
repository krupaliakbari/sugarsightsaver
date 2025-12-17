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
            /* .form-label {
                font-size: 0.6rem !important;
            } */
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
                            <?php if(Auth::user()->doctor_type === 'diabetes_treating'): ?>
                                <h4 class="mb-0">Physician Entry</h4>
                            <?php else: ?>
                                <h4 class="mb-0">Ophthalmologist Entry</h4>
                            <?php endif; ?>
                        </div>
                        <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger"><?php echo e(session()->get('error')); ?></div>
                        <?php endif; ?>

                        <?php if(session()->has('success')): ?>
                            <div class="alert alert-success"><?php echo e(session()->get('success')); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('doctor.patients.store-medical-entry', $appointment->id)); ?>" id="medicalEntryForm">
                            <?php echo csrf_field(); ?>

                            <!-- Medical Entry Form - Conditional based on Doctor Type -->
                            <?php if(Auth::user()->doctor_type === 'diabetes_treating'): ?>
                                <!-- Physician Medical Entry -->
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
                                                    <option value="type1" <?php echo e(old('physician_record.type_of_diabetes', $previousPhysicianRecord?->type_of_diabetes) == 'type1' ? 'selected' : ''); ?>>Type 1</option>
                                                    <option value="type2" <?php echo e(old('physician_record.type_of_diabetes', $previousPhysicianRecord?->type_of_diabetes) == 'type2' ? 'selected' : ''); ?>>Type 2</option>
                                                    <option value="other" <?php echo e(old('physician_record.type_of_diabetes', $previousPhysicianRecord?->type_of_diabetes) == 'other' ? 'selected' : ''); ?>>Other</option>
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
                                                               <?php echo e(old('physician_record.family_history_diabetes', $previousPhysicianRecord?->family_history_diabetes) == '1' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="family_history_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="physician_record[family_history_diabetes]" id="family_history_no" value="0"
                                                               <?php echo e(old('physician_record.family_history_diabetes', $previousPhysicianRecord?->family_history_diabetes) == '0' ? 'checked' : ''); ?>>
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
                                                                   <?php echo e(in_array('lifestyle', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="lifestyle">Lifestyle</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="oha" value="oha"
                                                                   <?php echo e(in_array('oha', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="oha">OHA</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="insulin" value="insulin"
                                                                   <?php echo e(in_array('insulin', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="insulin">Insulin</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="glp1" value="glp1"
                                                                   <?php echo e(in_array('glp1', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="glp1">GLP 1</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="ayurvedic_homeopathy" value="ayurvedic_homeopathy"
                                                                   <?php echo e(in_array('ayurvedic_homeopathy', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="ayurvedic_homeopathy">Ayurvedic/Homeopathy</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="physician_record[current_treatment][]" id="others_treatment" value="others"
                                                                   <?php echo e(in_array('others', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="others_treatment">Others</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" id="current_treatment_other_container" style="display: <?php echo e(in_array('others', old('physician_record.current_treatment', $previousPhysicianRecord?->current_treatment ?? [])) ? 'block' : 'none'); ?>;">
                                                    <div class="col-md-6">
                                                        <label for="current_treatment_other" class="form-label">Specify Other Treatment <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="current_treatment_other" name="physician_record[current_treatment_other]"
                                                               value="<?php echo e(old('physician_record.current_treatment_other', $previousPhysicianRecord?->current_treatment_other ?? '')); ?>"
                                                               placeholder="Enter other treatment">
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
                                                <?php $__errorArgs = ['physician_record.current_treatment'];
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

                                        <!-- Compliance -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Compliance <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="physician_record[compliance]" id="compliance_good" value="good"
                                                               <?php echo e(old('physician_record.compliance', $previousPhysicianRecord?->compliance) == 'good' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="compliance_good">Good</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="physician_record[compliance]" id="compliance_irregular" value="irregular"
                                                               <?php echo e(old('physician_record.compliance', $previousPhysicianRecord?->compliance) == 'irregular' ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="compliance_irregular">Irregular</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="physician_record[compliance]" id="compliance_poor" value="poor"
                                                               <?php echo e(old('physician_record.compliance', $previousPhysicianRecord?->compliance) == 'poor' ? 'checked' : ''); ?>>
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
                                                    <option value="rbs" <?php echo e(old('physician_record.blood_sugar_type', $previousPhysicianRecord?->blood_sugar_type) == 'rbs' ? 'selected' : ''); ?>>RBS</option>
                                                    <option value="fbs" <?php echo e(old('physician_record.blood_sugar_type', $previousPhysicianRecord?->blood_sugar_type) == 'fbs' ? 'selected' : ''); ?>>FBS</option>
                                                    <option value="ppbs" <?php echo e(old('physician_record.blood_sugar_type', $previousPhysicianRecord?->blood_sugar_type) == 'ppbs' ? 'selected' : ''); ?>>PPBS</option>
                                                    <option value="hba1c" <?php echo e(old('physician_record.blood_sugar_type', $previousPhysicianRecord?->blood_sugar_type) == 'hba1c' ? 'selected' : ''); ?>>HBA1C</option>
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
                                                       value="<?php echo e(old('physician_record.blood_sugar_value', $previousPhysicianRecord?->blood_sugar_value)); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.physician-medical-entry','data' => ['fieldPrefix' => 'physician_record','physicianRecord' => $previousPhysicianRecord]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('physician-medical-entry'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field-prefix' => 'physician_record','physician-record' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($previousPhysicianRecord)]); ?>
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
                                                          placeholder="Enter any additional information"><?php echo e(old('physician_record.other_data', $previousPhysicianRecord?->other_data)); ?></textarea>
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
                            <?php else: ?>
                                <!-- Ophthalmologist Medical Entry -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Ophthalmologist Medical Entry</h5>
                                    </div>
                                    <div class="card-body">
                                         <div class="row mb-3">
                                            <div class="col-md-12">
                                                
                                                <div class="table-responsive">
                                                    
                                                    <table class="table table-bordered align-middle oph-form">
                                                        <thead class="table-light text-center">
                                                            <tr>
                                                                <th style="border: none;"></th>
                                                                <th style="border: none;font-weight: bold;padding-left: 0">RE (Right
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
                                                                        value="<?php echo e(old('ophthalmologist_record.ucva_re', $previousOphthalmologistRecord?->ucva_re ?? '')); ?>"
                                                                        class="form-control shadow-none"
                                                                        placeholder="Enter RE value">
                                                                </td>
                                                                <td style="border: none;">
                                                                    <input type="text"
                                                                        name="ophthalmologist_record[ucva_le]"
                                                                        value="<?php echo e(old('ophthalmologist_record.ucva_le', $previousOphthalmologistRecord?->ucva_le ?? '')); ?>"
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
                                                                        value="<?php echo e(old('ophthalmologist_record.bcva_re', $previousOphthalmologistRecord?->bcva_re ?? '')); ?>"
                                                                        class="form-control shadow-none"
                                                                        placeholder="Enter RE value">
                                                                </td>
                                                                <td style="border: none;">
                                                                    <input type="text"
                                                                        name="ophthalmologist_record[bcva_le]"
                                                                        value="<?php echo e(old('ophthalmologist_record.bcva_le', $previousOphthalmologistRecord?->bcva_le ?? '')); ?>"
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
                                                                        value="<?php echo e(old('ophthalmologist_record.anterior_segment_re', $previousOphthalmologistRecord?->anterior_segment_re ?? '')); ?>"
                                                                        class="form-control shadow-none"
                                                                        placeholder="Enter RE value">
                                                                </td>
                                                                <td style="border: none;">
                                                                    <input type="text"
                                                                        name="ophthalmologist_record[anterior_segment_le]"
                                                                        value="<?php echo e(old('ophthalmologist_record.anterior_segment_le', $previousOphthalmologistRecord?->anterior_segment_le ?? '')); ?>"
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
                                                                        value="<?php echo e(old('ophthalmologist_record.iop_re', $previousOphthalmologistRecord?->iop_re ?? '')); ?>"
                                                                        class="form-control shadow-none"
                                                                        placeholder="Enter RE value">
                                                                </td>
                                                                <td style="border: none;">
                                                                    <input type="text"
                                                                        name="ophthalmologist_record[iop_le]"
                                                                        value="<?php echo e(old('ophthalmologist_record.iop_le', $previousOphthalmologistRecord?->iop_le ?? '')); ?>"
                                                                        class="form-control shadow-none"
                                                                        placeholder="Enter LE value">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- Diabetic Retinopathy (DR) and Macular Edema -->
                                     <div class="row mb-3">




                                        <!-- 1. Diabetic Retinopathy (DR) RE -->
<div class="col-md-6">
    <label class="form-label">Diabetic Retinopathy (DR) RE <span class="text-danger">*</span></label>
    <div class="mt-2">
        <!-- Hidden default to force field submission -->
        <input type="radio" name="ophthalmologist_record[diabetic_retinopathy_re]" value="" style="display:none"
               <?php echo e(old('ophthalmologist_record.diabetic_retinopathy_re', $previousOphthalmologistRecord?->diabetic_retinopathy_re ?? '') === null || old('ophthalmologist_record.diabetic_retinopathy_re', $previousOphthalmologistRecord?->diabetic_retinopathy_re ?? '') === '' ? 'checked' : ''); ?>>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy_re]" id="dr_yes_re" value="1"
                   <?php echo e(old('ophthalmologist_record.diabetic_retinopathy_re', $previousOphthalmologistRecord?->diabetic_retinopathy_re) == '1' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dr_yes_re">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy_re]" id="dr_no_re" value="0"
                   <?php echo e(old('ophthalmologist_record.diabetic_retinopathy_re', $previousOphthalmologistRecord?->diabetic_retinopathy_re) == '0' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dr_no_re">No</label>
        </div>
    </div>
    <?php $__errorArgs = ['ophthalmologist_record.diabetic_retinopathy_re'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                        <!-- 2. Diabetic Retinopathy (DR) LE -->
<div class="col-md-6">
    <label class="form-label">Diabetic Retinopathy (DR) LE <span class="text-danger">*</span></label>
    <div class="mt-2">
        <!-- Hidden default -->
        <input type="radio" name="ophthalmologist_record[diabetic_retinopathy]" value="" style="display:none"
               <?php echo e(old('ophthalmologist_record.diabetic_retinopathy', $previousOphthalmologistRecord?->diabetic_retinopathy ?? '') === null || old('ophthalmologist_record.diabetic_retinopathy', $previousOphthalmologistRecord?->diabetic_retinopathy ?? '') === '' ? 'checked' : ''); ?>>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy]" id="dr_yes" value="1"
                   <?php echo e(old('ophthalmologist_record.diabetic_retinopathy', $previousOphthalmologistRecord?->diabetic_retinopathy) == '1' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dr_yes">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_retinopathy]" id="dr_no" value="0"
                   <?php echo e(old('ophthalmologist_record.diabetic_retinopathy', $previousOphthalmologistRecord?->diabetic_retinopathy) == '0' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dr_no">No</label>
        </div>
    </div>
    <?php $__errorArgs = ['ophthalmologist_record.diabetic_retinopathy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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





                                         <!-- 3. Diabetic Macular Edema (DME) RE -->
<div class="col-md-6">
    <label class="form-label">Diabetic Macular Edema (DME) RE <span class="text-danger">*</span></label>
    <div class="mt-2">
        <!-- Hidden default -->
        <input type="radio" name="ophthalmologist_record[diabetic_macular_edema_re]" value="" style="display:none"
               <?php echo e(old('ophthalmologist_record.diabetic_macular_edema_re', $previousOphthalmologistRecord?->diabetic_macular_edema_re ?? '') === null || old('ophthalmologist_record.diabetic_macular_edema_re', $previousOphthalmologistRecord?->diabetic_macular_edema_re ?? '') === '' ? 'checked' : ''); ?>>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema_re]" id="dme_yes_re" value="1"
                   <?php echo e(old('ophthalmologist_record.diabetic_macular_edema_re', $previousOphthalmologistRecord?->diabetic_macular_edema_re) == '1' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dme_yes_re">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema_re]" id="dme_no_re" value="0"
                   <?php echo e(old('ophthalmologist_record.diabetic_macular_edema_re', $previousOphthalmologistRecord?->diabetic_macular_edema_re) == '0' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dme_no_re">No</label>
        </div>
    </div>
    <?php $__errorArgs = ['ophthalmologist_record.diabetic_macular_edema_re'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                                        <option value="nil_absent" <?php echo e(old('dme_status_re', in_array(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme_re ?? ''), ['nil_absent']) ? 'nil_absent' : (in_array(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '')) == 'nil_absent' ? 'selected' : ''); ?>>Nil/Absent</option>
                                                        <option value="present" <?php echo e(old('dme_status', in_array(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '') == 'present' ? 'selected' : ''); ?>>Present</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <!-- Sub-options for Present (shown conditionally) -->
                                                    <div id="dme_severity_container_re" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'block' : 'none'); ?>;">
                                                        <select class="form-select" id="dme_severity_re" name="ophthalmologist_record[type_of_dme_re]">
                                                            <option value="">Select DME</option>
                                                            <option value="mild" <?php echo e(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme_re ?? '') == 'mild' ? 'selected' : ''); ?>>Mild</option>
                                                            <option value="moderate" <?php echo e(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme_re ?? '') == 'moderate' ? 'selected' : ''); ?>>Moderate</option>
                                                            <option value="severe" <?php echo e(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme_re ?? '') == 'severe' ? 'selected' : ''); ?>>Severe (Based On Inv Of Fovea)</option>
                                                        </select>
                                                    </div>
                                                    <!-- Placeholder when severity container is hidden -->
                                                    <div id="dme_severity_placeholder_re" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme_re ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'none' : 'block'); ?>;">
                                                        <select class="form-select" disabled>
                                                            <option>Select DME</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hidden input for Nil/Absent value -->
                                            <input type="hidden" name="ophthalmologist_record[type_of_dme_re]" id="dme_hidden_nil_absent_re" value="nil_absent"
                                                   <?php echo e(old('ophthalmologist_record.type_of_dme_re', $previousOphthalmologistRecord?->type_of_dme ?? '') == 'nil_absent' ? '' : 'disabled'); ?>>

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







                                        <!-- 4. Diabetic Macular Edema (DME) LE -->
<div class="col-md-6">
    <label class="form-label">Diabetic Macular Edema (DME) LE <span class="text-danger">*</span></label>
    <div class="mt-2">
        <!-- Hidden default -->
        <input type="radio" name="ophthalmologist_record[diabetic_macular_edema]" value="" style="display:none"
               <?php echo e(old('ophthalmologist_record.diabetic_macular_edema', $previousOphthalmologistRecord?->diabetic_macular_edema ?? '') === null || old('ophthalmologist_record.diabetic_macular_edema', $previousOphthalmologistRecord?->diabetic_macular_edema ?? '') === '' ? 'checked' : ''); ?>>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema]" id="dme_yes" value="1"
                   <?php echo e(old('ophthalmologist_record.diabetic_macular_edema', $previousOphthalmologistRecord?->diabetic_macular_edema) == '1' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dme_yes">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="ophthalmologist_record[diabetic_macular_edema]" id="dme_no" value="0"
                   <?php echo e(old('ophthalmologist_record.diabetic_macular_edema', $previousOphthalmologistRecord?->diabetic_macular_edema) == '0' ? 'checked' : ''); ?>>
            <label class="form-check-label" for="dme_no">No</label>
        </div>
    </div>
    <?php $__errorArgs = ['ophthalmologist_record.diabetic_macular_edema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger mt-1"><?php echo e($message); ?></div>
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
                                                        <option value="nil_absent" <?php echo e(old('dme_status', in_array(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? ''), ['nil_absent']) ? 'nil_absent' : (in_array(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '')) == 'nil_absent' ? 'selected' : ''); ?>>Nil/Absent</option>
                                                        <option value="present" <?php echo e(old('dme_status', in_array(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '') == 'present' ? 'selected' : ''); ?>>Present</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <!-- Sub-options for Present (shown conditionally) -->
                                                    <div id="dme_severity_container" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'block' : 'none'); ?>;">
                                                        <select class="form-select" id="dme_severity" name="ophthalmologist_record[type_of_dme]">
                                                            <option value="">Select DME</option>
                                                            <option value="mild" <?php echo e(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? '') == 'mild' ? 'selected' : ''); ?>>Mild</option>
                                                            <option value="moderate" <?php echo e(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? '') == 'moderate' ? 'selected' : ''); ?>>Moderate</option>
                                                            <option value="severe" <?php echo e(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? '') == 'severe' ? 'selected' : ''); ?>>Severe (Based On Inv Of Fovea)</option>
                                                        </select>
                                                    </div>
                                                    <!-- Placeholder when severity container is hidden -->
                                                    <div id="dme_severity_placeholder" style="display: <?php echo e(in_array(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'none' : 'block'); ?>;">
                                                        <select class="form-select" disabled>
                                                            <option>Select DME</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hidden input for Nil/Absent value -->
                                            <input type="hidden" name="ophthalmologist_record[type_of_dme]" id="dme_hidden_nil_absent" value="nil_absent"
                                                   <?php echo e(old('ophthalmologist_record.type_of_dme', $previousOphthalmologistRecord?->type_of_dme ?? '') == 'nil_absent' ? '' : 'disabled'); ?>>

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


                                    <!-- Type of DR -->

                                    <!-- Investigations and Advised -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Investigations</label>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="fundus_pic" value="fundus_pic"
                                                               <?php echo e(in_array('fundus_pic', old('ophthalmologist_record.investigations', $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="fundus_pic">Fundus pic</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="oct" value="oct"
                                                               <?php echo e(in_array('oct', old('ophthalmologist_record.investigations', $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="oct">Oct</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="octa" value="octa"
                                                               <?php echo e(in_array('octa', old('ophthalmologist_record.investigations', $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="octa">Octa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="ffa" value="ffa"
                                                               <?php echo e(in_array('ffa', old('ophthalmologist_record.investigations', $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="ffa">Ffa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="ophthalmologist_record[investigations][]" id="others_inv" value="others"
                                                               <?php echo e(in_array('others', old('ophthalmologist_record.investigations', $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="others_inv">Others</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2" id="investigations_others_container" style="display: <?php echo e(in_array('others', old('ophthalmologist_record.investigations', $previousOphthalmologistRecord?->investigations ?? [])) ? 'block' : 'none'); ?>;">
                                                <div class="col-md-6">
                                                    <label for="investigations_others" class="form-label">Specify Other Investigations <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control <?php $__errorArgs = ['ophthalmologist_record.investigations_others'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="investigations_others" name="ophthalmologist_record[investigations_others]"
                                                           value="<?php echo e(old('ophthalmologist_record.investigations_others', $previousOphthalmologistRecord?->investigations_others ?? '')); ?>"
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
                                                <div class="text-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="advised_re" class="form-label">Advised RE</label>
                                            <select class="form-select" id="advised_re" name="ophthalmologist_record[advised_re]">
                                                <option value="">Select Treatment</option>
                                                <option value="no_treatment" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'no_treatment' ? 'selected' : ''); ?>>No treatment</option>
                                                <option value="close_watch" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'close_watch' ? 'selected' : ''); ?>>Close watch</option>
                                                <option value="drops" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'drops' ? 'selected' : ''); ?>>Any other drops</option>
                                                <option value="medications" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'medications' ? 'selected' : ''); ?>>Medications</option>
                                                <option value="focal_laser" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'focal_laser' ? 'selected' : ''); ?>>Focal laser</option>
                                                <option value="prp_laser" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'prp_laser' ? 'selected' : ''); ?>>PRP laser</option>
                                                <option value="intravit_inj" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'intravit_inj' ? 'selected' : ''); ?>>Intravit inj antivefg</option>
                                                <option value="steroid" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'steroid' ? 'selected' : ''); ?>>Steroid</option>
                                                <option value="surgery" <?php echo e(old('ophthalmologist_record.advised_re', $previousOphthalmologistRecord?->advised_re) == 'surgery' ? 'selected' : ''); ?>>Surgery</option>
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
                                            <label for="advised" class="form-label">Advised LE</label>
                                            <select class="form-select" id="advised" name="ophthalmologist_record[advised]">
                                                <option value="">Select Treatment</option>
                                                <option value="no_treatment" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'no_treatment' ? 'selected' : ''); ?>>No treatment</option>
                                                <option value="close_watch" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'close_watch' ? 'selected' : ''); ?>>Close watch</option>
                                                <option value="drops" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'drops' ? 'selected' : ''); ?>>Any other drops</option>
                                                <option value="medications" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'medications' ? 'selected' : ''); ?>>Medications</option>
                                                <option value="focal_laser" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'focal_laser' ? 'selected' : ''); ?>>Focal laser</option>
                                                <option value="prp_laser" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'prp_laser' ? 'selected' : ''); ?>>PRP laser</option>
                                                <option value="intravit_inj" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'intravit_inj' ? 'selected' : ''); ?>>Intravit inj antivefg</option>
                                                <option value="steroid" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'steroid' ? 'selected' : ''); ?>>Steroid</option>
                                                <option value="surgery" <?php echo e(old('ophthalmologist_record.advised', $previousOphthalmologistRecord?->advised) == 'surgery' ? 'selected' : ''); ?>>Surgery</option>
                                            </select>
                                            <?php $__errorArgs = ['ophthalmologist_record.advised'];
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

                                    <!-- Treatment Dates -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="treatment_done_date" class="form-label">Treatment Done Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="treatment_done_date" name="ophthalmologist_record[treatment_done_date]"
                                                   value="<?php echo e(old('ophthalmologist_record.treatment_done_date', $previousOphthalmologistRecord?->treatment_done_date)); ?>" placeholder="Select Treatment Date">
                                            <?php $__errorArgs = ['ophthalmologist_record.treatment_done_date'];
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
                                            <label for="review_date" class="form-label">Review Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="review_date" name="ophthalmologist_record[review_date]"
                                                   value="<?php echo e(old('ophthalmologist_record.review_date', $previousOphthalmologistRecord?->review_date)); ?>" placeholder="Select Review Date">
                                            <?php $__errorArgs = ['ophthalmologist_record.review_date'];
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

                                    <!-- Other Remarks -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="other_remarks" class="form-label">Other Remarks</label>
                                            <textarea class="form-control" id="other_remarks" name="ophthalmologist_record[other_remarks]" rows="3"
                                                      placeholder="Enter any additional remarks..."><?php echo e(old('ophthalmologist_record.other_remarks', $previousOphthalmologistRecord?->other_remarks)); ?></textarea>
                                            <?php $__errorArgs = ['ophthalmologist_record.other_remarks'];
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

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="<?php echo e(route('doctor.patients.index')); ?>" class="btn btn-light">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Save
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
            $(document).ready(function() {
                // Initialize Flatpickr for date pickers (for ophthalmologist)
                flatpickr("#treatment_done_date", {
                    dateFormat: "Y-m-d",
                    maxDate: "today"
                });

                flatpickr("#review_date", {
                    dateFormat: "Y-m-d",
                    maxDate: "today"
                });
            });

            // Clear validation errors when user interacts with fields
            document.addEventListener('DOMContentLoaded', function() {
                // Get all form inputs, selects, and textareas
                const formFields = document.querySelectorAll('#medicalEntryForm input, #medicalEntryForm select, #medicalEntryForm textarea');

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
                    // For text inputs, selects, textareas
                    if (field.type !== 'radio' && field.type !== 'checkbox') {
                        // Find the parent container (col-md-6, col-12, etc.)
                        const parentDiv = field.closest('div[class*="col-"]');
                        if (parentDiv) {
                            const errorMessage = parentDiv.querySelector('div.text-danger');
                            if (errorMessage && field.value.trim() !== '') {
                                errorMessage.style.display = 'none';
                            }
                        }
                    }
                }

                // Special handling for radio buttons and checkboxes
                const radioCheckboxes = document.querySelectorAll('#medicalEntryForm input[type="radio"], #medicalEntryForm input[type="checkbox"]');
                radioCheckboxes.forEach(function(field) {
                    field.addEventListener('change', function() {
                        // For radio buttons, find the parent that contains all radio options
                        const parentContainer = this.closest('div[class*="col-"]');
                        if (parentContainer) {
                            const errorMessage = parentContainer.querySelector('div.text-danger');
                            if (errorMessage) {
                                errorMessage.style.display = 'none';
                            }
                        }

                        // For checkboxes that are part of a group
                        if (this.type === 'checkbox') {
                            const checkboxName = this.getAttribute('name');
                            // Find parent row or col that contains the error
                            const parentRow = this.closest('.row');
                            if (parentRow) {
                                const errorMessage = parentRow.querySelector('div.text-danger');
                                if (errorMessage) {
                                    // Check if at least one checkbox is checked
                                    const checkboxes = document.querySelectorAll(`input[name="${checkboxName}"]`);
                                    let anyChecked = false;
                                    checkboxes.forEach(cb => {
                                        if (cb.checked) anyChecked = true;
                                    });
                                    if (anyChecked) {
                                        errorMessage.style.display = 'none';
                                    }
                                }
                            }
                        }
                    });
                });

                // Toggle "Others" textbox visibility
                const othersCheckbox = document.getElementById('others_treatment');
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
            // Populate Type of DR based on category
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
                    typeEl.innerHTML = '<option value="">Select Type</option>';
                    const options = category === 'npdr' ? NPDR_OPTIONS : category === 'pdr' ? PDR_OPTIONS : [];
                    options.forEach(opt => {
                        const o = document.createElement('option');
                        o.value = opt.value;
                        o.textContent = opt.label;
                        typeEl.appendChild(o);
                    });
                    // Try to preserve previously selected value
                    if (current && [...typeEl.options].some(o => o.value === current)) {
                        typeEl.value = current;
                    }
                }

                // Initialize from old value
                const oldValue = typeEl.getAttribute('value') || typeEl.value || '<?php echo e(old('ophthalmologist_record.type_of_dr', $previousOphthalmologistRecord?->type_of_dr)); ?>';
                if (oldValue.startsWith('npdr')) {
                    categoryEl.value = 'npdr';
                    populateTypeOptions('npdr');
                    typeEl.value = oldValue;
                } else if (oldValue.startsWith('pdr')) {
                    categoryEl.value = 'pdr';
                    populateTypeOptions('pdr');
                    typeEl.value = oldValue;
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
                    typeEl.innerHTML = '<option value="">Select Type</option>';
                    const options = category === 'npdr' ? NPDR_OPTIONS : category === 'pdr' ? PDR_OPTIONS : [];
                    options.forEach(opt => {
                        const o = document.createElement('option');
                        o.value = opt.value;
                        o.textContent = opt.label;
                        typeEl.appendChild(o);
                    });
                    // Try to preserve previously selected value
                    if (current && [...typeEl.options].some(o => o.value === current)) {
                        typeEl.value = current;
                    }
                }

                // Initialize from old value
                const oldValue = typeEl.getAttribute('value') || typeEl.value || '<?php echo e(old('ophthalmologist_record.type_of_dr_re', $previousOphthalmologistRecord?->type_of_dr)); ?>';
                if (oldValue.startsWith('npdr')) {
                    categoryEl.value = 'npdr';
                    populateTypeOptions('npdr');
                    typeEl.value = oldValue;
                } else if (oldValue.startsWith('pdr')) {
                    categoryEl.value = 'pdr';
                    populateTypeOptions('pdr');
                    typeEl.value = oldValue;
                }

                categoryEl.addEventListener('change', function() {
                    populateTypeOptions(this.value);
                });
            });

            // Handle "Others" checkbox for Investigations
            document.addEventListener('DOMContentLoaded', function() {
                const othersCheckbox = document.getElementById('others_inv');
                const othersContainer = document.getElementById('investigations_others_container');
                const othersInput = document.getElementById('investigations_others');

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

            // Form validation for investigations_others
            $(document).ready(function() {
                // Function to show error message under field
                function showFieldError(fieldId, message) {
                    $('#' + fieldId).siblings('.field-error').remove();
                    $('#' + fieldId).after('<div class="field-error text-danger mt-1">' + message + '</div>');
                }

                // Function to clear field error
                function clearFieldError(fieldId) {
                    $('#' + fieldId).siblings('.field-error').remove();
                }

                // Clear errors on input
                $('#investigations_others').on('input', function() {
                    clearFieldError('investigations_others');
                });

                // Validate investigations_others when form is submitted
                $('#medicalEntryForm').on('submit', function(e) {
                    const othersCheckbox = document.getElementById('others_inv');
                    const othersInput = document.getElementById('investigations_others');

                    if (othersCheckbox && othersCheckbox.checked) {
                        if (!othersInput || !othersInput.value || !othersInput.value.trim()) {
                            e.preventDefault();
                            showFieldError('investigations_others', 'Please specify other investigations.');
                            return false;
                        }
                    }
                });
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


            // DME Type conditional logic with dropdowns
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
        </script>
     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a)): ?>
<?php $component = $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a; ?>
<?php unset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a); ?>
<?php endif; ?>

<?php /**PATH C:\Users\ANZO-KRUPALI\Desktop\sugarsightsaver1\resources\views/doctor/patients/add-medical-entry.blade.php ENDPATH**/ ?>