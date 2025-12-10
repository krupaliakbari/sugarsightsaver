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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            
            /* Filter Section Styles */
            .filter-section {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .filter-row {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
                align-items: end;
            }
            
            .filter-group {
                flex: 1;
                min-width: 200px;
            }
            
            .filter-buttons {
                display: flex;
                gap: 0.5rem;
                align-items: end;
            }
            
            .btn-filter {
                white-space: nowrap;
                min-width: 120px;
                font-size: 1rem;
                padding: 0.75rem 1rem;
                height: 48px;
            }
            
            .btn-clear {
                white-space: nowrap;
                min-width: 100px;
                font-size: 1rem;
                padding: 0.75rem 1rem;
                height: 48px;
            }
            
            /* Sortable column headers */
            .sortable-header {
                cursor: pointer;
                user-select: none;
                position: relative;
                padding-right: 20px !important;
            }
            
            .sortable-header:hover {
                background-color: rgba(0, 0, 0, 0.05);
            }
            
            .sort-arrows {
                display: inline-flex;
                flex-direction: column;
                margin-left: 5px;
                font-size: 10px;
                line-height: 8px;
                vertical-align: middle;
            }
            
            .sort-arrow {
                color: #ccc;
                transition: color 0.2s;
            }
            
            .sort-arrow.active {
                color: #4361ee;
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
                            <h4 class="mb-0">Appointments Detail</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?php echo e(route('admin.patients.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back 
                                </a>
                            </div>
                        </div>
                        
                        <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger"><?php echo e(session()->get('error')); ?></div>
                        <?php endif; ?>

                        <?php if(session()->has('success')): ?>
                            <div class="alert alert-success"><?php echo e(session()->get('success')); ?></div>
                        <?php endif; ?>

                        <!-- Patient Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Patient Information</h5>
                            </div>
                            <div class="card-body">
                                <!-- Name, Mobile, SSSP ID, Email Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Name</strong><br>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <?php echo e(substr($patient->name, 0, 1)); ?>

                                            </div>
                                            <span class="text-muted"><?php echo e($patient->name); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Mobile</strong><br>
                                        <span class="text-muted"><?php echo e($patient->mobile_number); ?></span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>SSSP ID</strong><br>
                                        <span class="badge bg-info"><?php echo e($patient->sssp_id); ?></span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Email</strong><br>
                                        <span class="text-muted"><?php echo e($patient->email ?? 'N/A'); ?></span>
                                    </div>
                                </div>

                                <!-- Diabetes From, Diabetes Since Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Diabetes From</strong><br>
                                        <span class="text-muted"><?php echo e($patient->diabetes_from ? $patient->diabetes_from->format('M Y') : 'N/A'); ?></span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Diabetes Since</strong><br>
                                        <span class="text-muted" id="diabetes_duration_display">
                                            <?php if($patient->diabetes_from): ?>
                                                <span data-diabetes-from="<?php echo e($patient->diabetes_from->format('Y-m-d')); ?>"></span>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Date of Birth</strong><br>
                                        <span class="text-muted"><?php echo e($patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A'); ?></span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Age</strong><br>
                                        <span class="text-muted"><?php echo e($patient->age); ?> years</span>
                                    </div>
                                </div>

                                <!-- Sex, Hospital ID, Short Address Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Sex</strong><br>
                                        <span class="badge bg-secondary"><?php echo e(ucfirst($patient->sex)); ?></span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Hospital ID</strong><br>
                                        <span class="text-muted"><?php echo e($patient->hospital_id ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Short Address</strong><br>
                                        <span class="text-muted"><?php echo e($patient->short_address); ?></span>
                                    </div>
                                </div>

                                <?php
                                    $showSpecifyOther = false;
                                    $otherTreatment = '';
                                    
                                    // First, check most recent appointment's physician record for current_treatment_other
                                    $mostRecentAppointment = $appointments->first(); // Appointments are ordered by date desc
                                    if ($mostRecentAppointment) {
                                        $physicianRec = $mostRecentAppointment->medicalRecords
                                            ->where('record_type', 'physician')
                                            ->first()?->physicianRecord;
                                        
                                        if ($physicianRec && $physicianRec->exists) {
                                            // Get directly from database using raw query
                                            $rawValue = \Illuminate\Support\Facades\DB::table('physician_medical_records')
                                                ->where('id', $physicianRec->id)
                                                ->value('current_treatment_other');
                                            
                                            if($rawValue !== null && $rawValue !== '') {
                                                $trimmedValue = trim($rawValue);
                                                if($trimmedValue !== '') {
                                                    $otherTreatment = $trimmedValue;
                                                    $showSpecifyOther = true;
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Fallback to patient's type_of_treatment_other
                                    if (!$showSpecifyOther || $otherTreatment === '') {
                                        if ($patient->type_of_treatment_other) {
                                            $patientTreatmentOther = trim($patient->type_of_treatment_other);
                                            if($patientTreatmentOther !== '') {
                                                $otherTreatment = $patientTreatmentOther;
                                                $showSpecifyOther = true;
                                            }
                                        }
                                    }
                                ?>


                                <!-- Treatment Information Section -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Treatment Information</h6>
                                    </div>
                                </div>

                                <!-- Treatment Information Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>On Treatment</strong><br>
                                        <span class="badge <?php echo e($patient->on_treatment ? 'bg-success' : 'bg-danger'); ?>">
                                            <?php echo e($patient->on_treatment ? 'Yes' : 'No'); ?>

                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Type of Treatment</strong><br>
                                        <span class="text-muted">
                                            <?php if($patient->type_of_treatment && count($patient->type_of_treatment) > 0): ?>
                                                <?php echo e(implode(', ', array_map('ucfirst', str_replace('_', ' ', $patient->type_of_treatment)))); ?>

                                            <?php else: ?>
                                                Not specified
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                       <?php if($showSpecifyOther && $otherTreatment !== ''): ?>
                                <!-- Specify Other Treatment Row -->
                                
                                    <div class="col-md-3">
                                        <strong>Specify Other Treatment</strong><br>
                                        <span class="text-muted"><?php echo e($otherTreatment); ?></span>
                                    </div>
                                    
                                
                                
                                <?php endif; ?>

                                    
                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-3">
                                        <strong>BP</strong><br>
                                        <span class="badge <?php echo e($patient->bp ? 'bg-success' : 'bg-danger'); ?>">
                                            <?php echo e($patient->bp ? 'Yes' : 'No'); ?>

                                        </span>
                                    </div>
                                    <?php if($patient->bp): ?>
                                    <div class="col-md-3">
                                        <strong>BP Since</strong><br>
                                        <span class="text-muted"><?php echo e($patient->bp_since ? $patient->bp_since->format('M Y') : 'N/A'); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($patient->bp && $patient->bp_since): ?>
                                    <div class="col-md-3">
                                        <strong>BP Duration</strong><br>
                                        <span class="text-muted" id="bp_duration_display">
                                            <span data-bp-since="<?php echo e($patient->bp_since->format('Y-m-d')); ?>"></span>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Specify Other Treatment Row - Check appointment-specific first, then patient-level -->
                                
                             
                                <!-- Other Diseases Section -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Other Diseases</h6>
                                    </div>
                                </div>

                                <!-- Other Diseases Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Any Other Diseases</strong><br>
                                        <span class="text-muted">
                                            <?php if($patient->other_diseases && count($patient->other_diseases) > 0): ?>
                                                <?php echo e(implode(', ', array_map('ucfirst', str_replace('_', ' ', $patient->other_diseases)))); ?>

                                            <?php else: ?>
                                                None
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php if($patient->other_diseases && in_array('others', $patient->other_diseases) && $patient->other_diseases_other): ?>
                                    <div class="col-md-3">
                                        <strong>Specify Other Disease</strong><br>
                                        <span class="text-muted"><?php echo e($patient->other_diseases_other); ?></span>
                                    </div>
                                    <?php endif; ?>

                                    <div class="col-md-3">
                                        <strong>Any Other Input</strong><br>
                                        <span class="text-muted"><?php echo e($patient->other_input ?? 'N/A'); ?></span>
                                    </div>
                                </div>

                               

                                <!-- Physical Measurements Section -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Physical Measurements</h6>
                                    </div>
                                </div>

                                <!-- Physical Measurements Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Height (In Meter)</strong><br>
                                        <span class="text-muted"><?php echo e($patient->height ? $patient->height . ' m' : 'N/A'); ?></span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Weight (In Kg)</strong><br>
                                        <span class="text-muted"><?php echo e($patient->weight ? $patient->weight . ' kg' : 'N/A'); ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>BMI</strong><br>
                                        <span class="text-muted" id="bmi-value" data-bmi="<?php echo e($latestBmi ?? $patient->bmi ?? ''); ?>"><?php echo e($latestBmi ?? $patient->bmi ?? 'N/A'); ?></span>
                                        <button type="button" id="bmi-btn-underweight" class="btn btn-sm btn-outline-secondary ms-2" style="display: none; pointer-events: none;">Underweight</button>
                                        <button type="button" id="bmi-btn-normal" class="btn btn-sm btn-outline-secondary ms-2" style="display: none; pointer-events: none;">Normal Weight</button>
                                        <button type="button" id="bmi-btn-overweight" class="btn btn-sm btn-outline-secondary ms-2" style="display: none; pointer-events: none;">Overweight</button>
                                        <button type="button" id="bmi-btn-obesity1" class="btn btn-sm btn-outline-secondary ms-2" style="display: none; pointer-events: none;">Obesity Grade 1</button>
                                        <button type="button" id="bmi-btn-obesity2" class="btn btn-sm btn-outline-secondary ms-2" style="display: none; pointer-events: none;">Obesity Grade 2</button>
                                        <button type="button" id="bmi-btn-obesity3" class="btn btn-sm btn-outline-secondary ms-2" style="display: none; pointer-events: none;">Obesity Grade 3</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointments and Medical Records Table -->
                        <div class="card" id="appointments-section">
                            <div class="card-header">
                                <h5 class="card-title">Manage Appointments</h5>
                            </div>
                            
                            <!-- Filter Controls -->
                                    <div class="filter-section" style="margin: 0; border-radius: 0; border-bottom: 1px solid rgba(0,0,0,0.125);">
                                        <form method="GET" action="<?php echo e(route('admin.patients.show', $patient->id)); ?>#appointments-section">
                                            <div class="filter-row">
                                                <div class="filter-group">
                                                    <label class="form-label small text-muted mb-1">From Date</label>
                                                    <input type="text" class="form-control flatpickr-input" id="date_from" name="date_from" placeholder="From Date" value="<?php echo e(request('date_from')); ?>">
                                                </div>
                                                <div class="filter-group">
                                                    <label class="form-label small text-muted mb-1">To Date</label>
                                                    <input type="text" class="form-control flatpickr-input" id="date_to" name="date_to" placeholder="To Date" value="<?php echo e(request('date_to')); ?>">
                                                </div>
                                                <div class="filter-buttons">
                                                    <button type="submit" class="btn btn-primary btn-filter">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-1">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <path d="M21 21l-4.35-4.35"></path>
                                                        </svg>
                                                        Search
                                                    </button>
                                                    <?php if(request()->hasAny(['date_from', 'date_to'])): ?>
                                                        <a href="<?php echo e(route('admin.patients.show', $patient->id)); ?>#appointments-section" class="btn btn-outline-secondary btn-clear">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-1">
                                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                                            </svg>
                                                            Clear
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                            <div class="card-body">
                                <div id="appointments-table-container">
                                <?php if(session()->has('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo e(session()->get('error')); ?>

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if(session()->has('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo e(session()->get('success')); ?>

                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <?php if($appointments->count() > 0): ?>
                                    <?php
                                        $sortBy = request('sort_by', 'visit_date_time');
                                        $sortDirection = request('sort_direction', 'desc');
                                        
                                        // Determine the primary doctor type from appointments
                                        $primaryDoctorType = 'diabetes_treating';
                                        if($appointments->count() > 0) {
                                            $firstAppointment = $appointments->first();
                                            $primaryDoctorType = $firstAppointment->doctor->doctor_type ?? 'diabetes_treating';
                                        }
                                    ?>
                                    <!-- Desktop Table View -->
                                        <div class="d-none d-lg-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="sortable-header" data-sort-column="date">
                                                                Visit Date
                                                                <span class="sort-arrows">
                                                                    <span class="sort-arrow <?php echo e((request('sort_by') == 'date' || request('sort_by') == 'visit_date_time') && request('sort_direction') == 'asc' ? 'active' : ''); ?>">▲</span>
                                                                    <span class="sort-arrow <?php echo e((request('sort_by') == 'date' || request('sort_by') == 'visit_date_time') && request('sort_direction') == 'desc' ? 'active' : ''); ?>">▼</span>
                                                                </span>
                                                            </th>
                                                            
                                                                <th>Type of Diabetes</th>
                                                                <th>Current Treatment</th>
                                                                <th>Retinopathy</th>
                                                                <th>Diabetic Retinopathy (DR)</th>
                                                                <th>Diabetic Macular Edema (DME)</th>
                                                                <th>Type of DR</th>
                                                           
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <strong><?php echo e($appointment->visit_date_time->format('M d, Y')); ?></strong>
                                                                    <small class="text-muted"> <?php echo e($appointment->visit_date_time->format('H:i')); ?></small>
                                                                </div>
                                                            </td>
                                                            <?php
                                                                $physicianRecord = $appointment->medicalRecords->where('record_type', 'physician')->first()?->physicianRecord;
                                                                $ophthalmologistRecord = $appointment->medicalRecords->where('record_type', 'ophthalmologist')->first()?->ophthalmologistRecord;
                                                            ?>
                                                            
                                                           
                                                           
                                                                <td>
                                                                    <?php if($physicianRecord): ?>
                                                                        <span class="badge bg-primary"><?php echo e($physicianRecord->formatted_diabetes_type); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($physicianRecord && $physicianRecord->current_treatment): ?>
                                                                        <span class="small"><?php echo e($physicianRecord->formatted_current_treatment); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($physicianRecord && $physicianRecord->retinopathy): ?>
                                                                        <span class="small"><?php echo e($physicianRecord->formatted_retinopathy); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                     <td>
                                                                    <?php if($ophthalmologistRecord): ?>
                                                                        <span class="badge <?php echo e($ophthalmologistRecord->diabetic_retinopathy ? 'bg-success' : 'bg-danger'); ?>">
                                                                            <?php echo e($ophthalmologistRecord->diabetic_retinopathy ? 'Yes' : 'No'); ?>

                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($ophthalmologistRecord): ?>
                                                                        <span class="badge <?php echo e($ophthalmologistRecord->diabetic_macular_edema ? 'bg-success' : 'bg-danger'); ?>">
                                                                            <?php echo e($ophthalmologistRecord->diabetic_macular_edema ? 'Yes' : 'No'); ?>

                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($ophthalmologistRecord && $ophthalmologistRecord->type_of_dr): ?>
                                                                        <span class="small"><?php echo e($ophthalmologistRecord->formatted_dr_type); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                           
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <?php if($appointment->medicalRecords->count() > 0): ?>
                                                                        <?php $__currentLoopData = $appointment->medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicalRecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <a href="<?php echo e(route('admin.patients.medical-record', [$patient->id, $medicalRecord->id])); ?>" 
                                                                               class="btn btn-sm btn-info" 
                                                                               title="View Medical Record"
                                                                               style="padding: 0.375rem 0.5rem;">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                                </svg>
                                                                            </a>
                                                                            <button type="button" 
                                                                                    class="btn btn-sm btn-danger" 
                                                                                    title="Delete Appointment"
                                                                                    style="padding: 0.375rem 0.5rem;"
                                                                                    onclick="deleteMedicalRecord(<?php echo e($patient->id); ?>, <?php echo e($medicalRecord->id); ?>)">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                </svg>
                                                                            </button>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php else: ?>
                                                                        <span class="text-muted small">No records</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Mobile Table View -->
                                    <div class="d-lg-none">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="sortable-header" data-sort-column="date">
                                                            Visit Date
                                                            <span class="sort-arrows">
                                                                <span class="sort-arrow <?php echo e((request('sort_by') == 'date' || request('sort_by') == 'visit_date_time') && request('sort_direction') == 'asc' ? 'active' : ''); ?>">▲</span>
                                                                <span class="sort-arrow <?php echo e((request('sort_by') == 'date' || request('sort_by') == 'visit_date_time') && request('sort_direction') == 'desc' ? 'active' : ''); ?>">▼</span>
                                                            </span>
                                                        </th>
                                                        
                                                           
                                                       
                                                            <th>Type of Diabetes</th>
                                                            <th>Current Treatment</th>
                                                            <th>Retinopathy</th>
                                                             <th>Diabetic Retinopathy (DR)</th>
                                                            <th>Diabetic Macular Edema (DME)</th>
                                                            <th>Type of DR</th>
                                                        
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <strong><?php echo e($appointment->visit_date_time->format('M d, Y')); ?></strong>
                                                                    <small class="text-muted"> <?php echo e($appointment->visit_date_time->format('H:i')); ?></small>
                                                                </div>
                                                            </td>
                                                            <?php
                                                                $physicianRecord = $appointment->medicalRecords->where('record_type', 'physician')->first()?->physicianRecord;
                                                                $ophthalmologistRecord = $appointment->medicalRecords->where('record_type', 'ophthalmologist')->first()?->ophthalmologistRecord;
                                                            ?>
                                                           
                                                                
                                                          
                                                                <td>
                                                                    <?php if($physicianRecord): ?>
                                                                        <span class="badge bg-primary"><?php echo e($physicianRecord->formatted_diabetes_type); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($physicianRecord && $physicianRecord->current_treatment): ?>
                                                                        <span class="small"><?php echo e($physicianRecord->formatted_current_treatment); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($physicianRecord && $physicianRecord->retinopathy): ?>
                                                                        <span class="small"><?php echo e($physicianRecord->formatted_retinopathy); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($ophthalmologistRecord): ?>
                                                                        <span class="badge <?php echo e($ophthalmologistRecord->diabetic_retinopathy ? 'bg-success' : 'bg-danger'); ?>">
                                                                            <?php echo e($ophthalmologistRecord->diabetic_retinopathy ? 'Yes' : 'No'); ?>

                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($ophthalmologistRecord): ?>
                                                                        <span class="badge <?php echo e($ophthalmologistRecord->diabetic_macular_edema ? 'bg-success' : 'bg-danger'); ?>">
                                                                            <?php echo e($ophthalmologistRecord->diabetic_macular_edema ? 'Yes' : 'No'); ?>

                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($ophthalmologistRecord && $ophthalmologistRecord->type_of_dr): ?>
                                                                        <span class="small"><?php echo e($ophthalmologistRecord->formatted_dr_type); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                           
                                                            <td>
                                                                <div class="d-flex gap-1">
                                                                    <?php if($appointment->medicalRecords->count() > 0): ?>
                                                                        <?php $__currentLoopData = $appointment->medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicalRecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <a href="<?php echo e(route('admin.patients.medical-record', [$patient->id, $medicalRecord->id])); ?>" 
                                                                               class="btn btn-sm btn-info" 
                                                                               title="View Medical Record"
                                                                               style="padding: 0.375rem 0.5rem;">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                                </svg>
                                                                            </a>
                                                                            <button type="button" 
                                                                                    class="btn btn-sm btn-danger" 
                                                                                    title="Delete Appointment"
                                                                                    style="padding: 0.375rem 0.5rem;"
                                                                                    onclick="deleteMedicalRecord(<?php echo e($patient->id); ?>, <?php echo e($medicalRecord->id); ?>)">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                </svg>
                                                                            </button>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php else: ?>
                                                                        <span class="text-muted small">No records</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div class="text-muted">
                                            Showing <?php echo e($appointments->firstItem()); ?> to <?php echo e($appointments->lastItem()); ?> of <?php echo e($appointments->total()); ?> appointments
                                        </div>
                                        <div>
                                            <?php echo e($appointments->appends(request()->query())->links('pagination::bootstrap-4')); ?>

                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php
                                        $sortBy = request('sort_by', 'visit_date_time');
                                        $sortDirection = request('sort_direction', 'desc');
                                        
                                        // Determine the primary doctor type from appointments
                                        $primaryDoctorType = 'diabetes_treating';
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sortable-header" data-sort-column="date">
                                                        Visit Date
                                                        <span class="sort-arrows">
                                                            <span class="sort-arrow <?php echo e(($sortBy === 'date' || $sortBy === 'visit_date_time') && $sortDirection === 'asc' ? 'active' : ''); ?>">▲</span>
                                                            <span class="sort-arrow <?php echo e(($sortBy === 'date' || $sortBy === 'visit_date_time') && $sortDirection === 'desc' ? 'active' : ''); ?>">▼</span>
                                                        </span>
                                                    </th>
                                                    <?php if($primaryDoctorType === 'ophthalmologist'): ?>
                                                        <th>Diabetic Retinopathy (DR)</th>
                                                        <th>Diabetic Macular Edema (DME)</th>
                                                        <th>Type of DR</th>
                                                    <?php else: ?>
                                                        <th>Type of Diabetes</th>
                                                        <th>Current Treatment</th>
                                                        <th>Retinopathy</th>
                                                    <?php endif; ?>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="<?php echo e($primaryDoctorType === 'ophthalmologist' ? '5' : '5'); ?>" class="text-center text-muted">No appointments found</td>
                                                </tr>
                                            </tbody>
                                        </table>
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

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
     <?php $__env->slot('footerFiles', null, []); ?> 
        <script src="<?php echo e(asset('plugins/notification/snackbar/snackbar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/flatpickr/flatpickr.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/flatpickr/custom-flatpickr.js')); ?>"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Calculate and display Diabetes Duration
                const diabetesDurationDisplay = document.getElementById('diabetes_duration_display');
                if (diabetesDurationDisplay) {
                    const diabetesFromSpan = diabetesDurationDisplay.querySelector('[data-diabetes-from]');
                    if (diabetesFromSpan) {
                        const diabetesFromDate = diabetesFromSpan.getAttribute('data-diabetes-from');
                        if (diabetesFromDate) {
                            const duration = calculateDuration(diabetesFromDate);
                            diabetesDurationDisplay.textContent = duration;
                        }
                    }
                }
                
                // Calculate and display BP Duration
                const bpDurationDisplay = document.getElementById('bp_duration_display');
                if (bpDurationDisplay) {
                    const bpSinceSpan = bpDurationDisplay.querySelector('[data-bp-since]');
                    if (bpSinceSpan) {
                        const bpSinceDate = bpSinceSpan.getAttribute('data-bp-since');
                        if (bpSinceDate) {
                            const duration = calculateDuration(bpSinceDate);
                            bpDurationDisplay.textContent = duration;
                        }
                    }
                }
                
                // Function to calculate duration from a date
                function calculateDuration(fromDateStr) {
                    const today = new Date();
                    const fromDate = new Date(fromDateStr);
                    
                    // Calculate the difference in years and months
                    let years = today.getFullYear() - fromDate.getFullYear();
                    let months = today.getMonth() - fromDate.getMonth();
                    
                    // Adjust if months difference is negative
                    if (months < 0) {
                        years--;
                        months += 12;
                    }
                    
                    // Build the duration string
                    let durationText = '';
                    if (years > 0) {
                        durationText = `Last ${years} year${years > 1 ? 's' : ''}`;
                        if (months > 0) {
                            durationText += ` and ${months} month${months > 1 ? 's' : ''}`;
                        }
                    } else if (months > 0) {
                        durationText = `Last ${months} month${months > 1 ? 's' : ''}`;
                    } else {
                        durationText = 'Less than a month';
                    }
                    
                    return durationText;
                }
                
                // Initialize Flatpickr for date filters
                const dateFrom = document.getElementById('date_from');
                if (dateFrom) {
                    flatpickr(dateFrom, {
                        dateFormat: "Y-m-d"
                    });
                }
                
                const dateTo = document.getElementById('date_to');
                if (dateTo) {
                    flatpickr(dateTo, {
                        dateFormat: "Y-m-d"
                    });
                }

                // Auto-dismiss alert messages after 5 seconds
                const alerts = document.querySelectorAll('.alert-success, .alert-danger');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000); // 5 seconds
                });

                // AJAX Sorting functionality
                function setupAjaxSorting() {
                    const sortableHeaders = document.querySelectorAll('.sortable-header');
                    
                    sortableHeaders.forEach(function(header) {
                        header.addEventListener('click', function(e) {
                            e.preventDefault();
                            
                            const column = this.getAttribute('data-sort-column');
                            const currentUrl = new URL(window.location.href);
                            const params = new URLSearchParams(currentUrl.search);
                            
                            // Get current sort
                            const currentSortBy = params.get('sort_by') || 'visit_date_time';
                            const currentDirection = params.get('sort_direction') || 'desc';
                            
                            // Toggle direction
                            let newDirection = 'asc';
                            if (column === currentSortBy || (column === 'date' && (currentSortBy === 'date' || currentSortBy === 'visit_date_time'))) {
                                newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                            }
                            
                            // Update params
                            params.set('sort_by', column);
                            params.set('sort_direction', newDirection);
                            params.delete('page'); // Reset to first page when sorting
                            
                            // Build URL
                            const ajaxUrl = '<?php echo e(route("admin.patients.show", $patient->id)); ?>?' + params.toString();
                            
                            // Show loading state
                            const container = document.getElementById('appointments-table-container');
                            container.style.opacity = '0.5';
                            container.style.pointerEvents = 'none';
                            
                            // Make AJAX request
                            fetch(ajaxUrl, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.text())
                            .then(html => {
                                // Parse the HTML response
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContent = doc.getElementById('appointments-table-container');
                                
                                if (newContent) {
                                    // Replace content
                                    container.innerHTML = newContent.innerHTML;
                                    container.style.opacity = '1';
                                    container.style.pointerEvents = 'auto';
                                    
                                    // Update URL without reload
                                    const newUrl = currentUrl.pathname + '?' + params.toString();
                                    window.history.pushState({}, '', newUrl);
                                    
                                    // Reinitialize sorting on new content
                                    setupAjaxSorting();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                container.style.opacity = '1';
                                container.style.pointerEvents = 'auto';
                            });
                        });
                    });
                }
                
                // Initialize AJAX sorting
                setupAjaxSorting();
                
                // Scroll to appointments section if coming from filter/search
                const urlParams = new URLSearchParams(window.location.search);
                const hasFilterParams = urlParams.has('date_from') || urlParams.has('date_to');
                
                if (window.location.hash === '#appointments-section' || hasFilterParams) {
                    setTimeout(function() {
                        const element = document.getElementById('appointments-section');
                        if (element) {
                            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }, 100);
                }
            });
            
            // BMI Interpretation on page load
            const bmiValueElement = document.getElementById('bmi-value');
            const bmiValue = bmiValueElement ? parseFloat(bmiValueElement.getAttribute('data-bmi')) : null;
            
            // Hide all BMI buttons first
            const bmiButtons = [
                'bmi-btn-underweight',
                'bmi-btn-normal',
                'bmi-btn-overweight',
                'bmi-btn-obesity1',
                'bmi-btn-obesity2',
                'bmi-btn-obesity3'
            ];
            
            bmiButtons.forEach(btnId => {
                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.style.display = 'none';
                    btn.classList.remove('btn-info', 'btn-success', 'btn-warning', 'btn-danger');
                    btn.classList.add('btn-outline-secondary');
                }
            });
            
            if (bmiValue && !isNaN(bmiValue)) {
                // BMI interpretation based on provided ranges
                let activeButton = null;
                let buttonClass = '';
                
                if (bmiValue < 18.5) {
                    activeButton = document.getElementById('bmi-btn-underweight');
                    buttonClass = 'btn-info';
                } else if (bmiValue >= 18.5 && bmiValue <= 22.9) {
                    activeButton = document.getElementById('bmi-btn-normal');
                    buttonClass = 'btn-success';
                } else if (bmiValue >= 23.0 && bmiValue <= 24.9) {
                    activeButton = document.getElementById('bmi-btn-overweight');
                    buttonClass = 'btn-warning';
                } else if (bmiValue >= 25.0 && bmiValue <= 29.9) {
                    activeButton = document.getElementById('bmi-btn-obesity1');
                    buttonClass = 'btn-danger';
                } else if (bmiValue >= 30.0 && bmiValue <= 34.9) {
                    activeButton = document.getElementById('bmi-btn-obesity2');
                    buttonClass = 'btn-danger';
                } else if (bmiValue > 35) {
                    activeButton = document.getElementById('bmi-btn-obesity3');
                    buttonClass = 'btn-danger';
                }
                
                // Show and style the active button
                if (activeButton) {
                    activeButton.style.display = 'inline-block';
                    activeButton.classList.remove('btn-outline-secondary');
                    activeButton.classList.add(buttonClass);
                }
            }

            function deleteMedicalRecord(patientId, medicalRecordId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the entire appointment and all associated medical records. You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete appointment!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form and submit it
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/siteadmin/patients/${patientId}/medical-record/${medicalRecordId}`;
                        
                        // Add CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '<?php echo e(csrf_token()); ?>';
                        form.appendChild(csrfToken);
                        
                        // Add method override for DELETE
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
        </script>
     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?><?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/pages/admin/patients/show.blade.php ENDPATH**/ ?>