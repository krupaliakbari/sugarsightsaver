<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])

        <style>
            /* Compact card headers */
            .card-header {
                padding: 0.5rem 1rem !important;
                background-color: #6366f1 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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

            @media (max-width: 768px) {
                .col-md-3 {
                    margin-top: 5px;
                }
            }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h4 class="mb-4">Appointment Summary</h4>

                        @if (session()->has('error'))
                            <div class="alert alert-danger">{{ session()->get('error') }}</div>
                        @endif

                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session()->get('success') }}</div>
                        @endif

                        <!-- Patient Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Patient Information</h5>
                            </div>
                            <div class="card-body">
                                <!-- Appointment Details Row -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Appointment Date</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->visit_date_time->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Appointment Type</strong><br>
                                        <span
                                            class="badge bg-info">{{ ucfirst($patientMedicalRecord->appointment->appointment_type) }}</span>
                                    </div>
                                </div>

                                <!-- Patient Profile Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Name</strong><br>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                {{ substr($patientMedicalRecord->appointment->patient_name_snapshot, 0, 1) }}
                                            </div>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->appointment->patient_name_snapshot }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Mobile</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_mobile_number_snapshot }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>SSSP ID</strong><br>
                                        <span
                                            class="badge bg-info">{{ $patientMedicalRecord->appointment->patient_sssp_id_snapshot }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Email</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_email_snapshot ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <!-- Basic Details Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Diabetes From</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_diabetes_from_snapshot ? $patientMedicalRecord->appointment->patient_diabetes_from_snapshot->format('M Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Diabetes Since</strong><br>
                                        <span class="text-muted">
                                            @if ($patientMedicalRecord->appointment->patient_diabetes_from_snapshot)
                                                @php
                                                    $today = now();
                                                    $diabetesFrom =
                                                        $patientMedicalRecord->appointment
                                                            ->patient_diabetes_from_snapshot;
                                                    $years = $today->diffInYears($diabetesFrom);
                                                    $months = $today->diffInMonths($diabetesFrom) % 12;
                                                    $duration = '';
                                                    if ($years > 0) {
                                                        $duration = "Last {$years} year" . ($years > 1 ? 's' : '');
                                                        if ($months > 0) {
                                                            $duration .=
                                                                " and {$months} month" . ($months > 1 ? 's' : '');
                                                        }
                                                    } elseif ($months > 0) {
                                                        $duration = "Last {$months} month" . ($months > 1 ? 's' : '');
                                                    } else {
                                                        $duration = 'Less than a month';
                                                    }
                                                @endphp
                                                {{ $duration }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Date of Birth</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_date_of_birth_snapshot ? $patientMedicalRecord->appointment->patient_date_of_birth_snapshot->format('M d, Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Age</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_age_snapshot }}
                                            years</span>
                                    </div>
                                </div>

                                <!-- Demographics Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Sex</strong><br>
                                        <span
                                            class="badge bg-secondary">{{ ucfirst($patientMedicalRecord->appointment->patient_sex_snapshot) }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Hospital ID</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_hospital_id_snapshot ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Short Address</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_short_address_snapshot }}</span>
                                    </div>
                                </div>

                                <!-- Treatment Information Section -->

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Treatment Information</h6>
                                    </div>
                                </div>

                                @php
                                    // This is for "Type Of Treatment" - use current appointment snapshot only
                                    $showTypeOfTreatmentOther = false;
                                    $typeOfTreatmentOtherValue = '';

                                    $appointment = $patientMedicalRecord->appointment ?? null;
                                    $isOnTreatment =
                                        $patientMedicalRecord->appointment->patient_on_treatment_snapshot ?? false;

                                    // Only show if patient is on treatment AND "others" is in the treatment array AND there's a value
if (
    $isOnTreatment &&
    $appointment &&
    in_array('others', $appointment->patient_type_of_treatment_snapshot ?? [])
) {
    if ($appointment->patient_type_of_treatment_other_snapshot) {
        $snapshotTreatmentOther = trim(
            $appointment->patient_type_of_treatment_other_snapshot,
        );
        if ($snapshotTreatmentOther !== '') {
                                                $typeOfTreatmentOtherValue = $snapshotTreatmentOther;
                                                $showTypeOfTreatmentOther = true;
                                            }
                                        }
                                    }
                                @endphp

                                <!-- Treatment Information Row -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>On Treatment</strong><br>
                                        <span class="badge {{ $isOnTreatment ? 'bg-success' : 'bg-danger' }}">
                                            {{ $isOnTreatment ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Type of Treatment</strong><br>
                                        <span class="text-muted">
                                            @if ($isOnTreatment)
                                                @if (
                                                    $patientMedicalRecord->appointment->patient_type_of_treatment_snapshot &&
                                                        count($patientMedicalRecord->appointment->patient_type_of_treatment_snapshot) > 0)
                                                    {{ implode(', ', array_map('ucfirst', str_replace('_', ' ', $patientMedicalRecord->appointment->patient_type_of_treatment_snapshot))) }}
                                                @else
                                                    Not specified
                                                @endif
                                            @else
                                                Not specified
                                            @endif
                                        </span>
                                    </div>
                                    @if ($showTypeOfTreatmentOther)
                                        <div class="col-md-3">
                                            <strong>Specify Other Treatment</strong><br>
                                            <span class="text-muted">
                                                @if ($typeOfTreatmentOtherValue !== '' && is_string($typeOfTreatmentOtherValue))
                                                    {{ $typeOfTreatmentOtherValue }}
                                                @else
                                                    Not specified
                                                @endif
                                            </span>
                                        </div>

                                </div>



                                <div class="row mb-3">
                                    

                                    @if (
                                        $patientMedicalRecord->appointment->patient_bp_snapshot &&
                                            $patientMedicalRecord->appointment->patient_bp_since_snapshot)

                                            <div class="col-md-3">
                                        <strong>BP</strong><br>
                                        <span
                                            class="badge {{ $patientMedicalRecord->appointment->patient_bp_snapshot ? 'bg-success' : 'bg-danger' }}">
                                            {{ $patientMedicalRecord->appointment->patient_bp_snapshot ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    @if ($patientMedicalRecord->appointment->patient_bp_snapshot)
                                        <div class="col-md-3">
                                            <strong>BP Since</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->appointment->patient_bp_since_snapshot ? $patientMedicalRecord->appointment->patient_bp_since_snapshot->format('M Y') : 'N/A' }}</span>
                                        </div>
                                    @endif
                                        <div class="col-md-3">
                                            <strong>BP Duration</strong><br>
                                            <span class="text-muted">
                                                @php
                                                    $today = now();
                                                    $bpSince =
                                                        $patientMedicalRecord->appointment->patient_bp_since_snapshot;
                                                    $years = $today->diffInYears($bpSince);
                                                    $months = $today->diffInMonths($bpSince) % 12;
                                                    $duration = '';
                                                    if ($years > 0) {
                                                        $duration = "Last {$years} year" . ($years > 1 ? 's' : '');
                                                        if ($months > 0) {
                                                            $duration .=
                                                                " and {$months} month" . ($months > 1 ? 's' : '');
                                                        }
                                                    } elseif ($months > 0) {
                                                        $duration = "Last {$months} month" . ($months > 1 ? 's' : '');
                                                    } else {
                                                        $duration = 'Less than a month';
                                                    }
                                                @endphp
                                                {{ $duration }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @elseif(
                                $patientMedicalRecord->appointment->patient_bp_snapshot &&
                                    $patientMedicalRecord->appointment->patient_bp_since_snapshot)
                                <!-- BP Duration Row (when no other treatment) -->
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-3">
                                        <strong>BP</strong><br>
                                        <span
                                            class="badge {{ $patientMedicalRecord->appointment->patient_bp_snapshot ? 'bg-success' : 'bg-danger' }}">
                                            {{ $patientMedicalRecord->appointment->patient_bp_snapshot ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    @if ($patientMedicalRecord->appointment->patient_bp_snapshot)
                                        <div class="col-md-3">
                                            <strong>BP Since</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->appointment->patient_bp_since_snapshot ? $patientMedicalRecord->appointment->patient_bp_since_snapshot->format('M Y') : 'N/A' }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-3">
                                        <strong>BP Duration</strong><br>
                                        <span class="text-muted">
                                            @php
                                                $today = now();
                                                $bpSince =
                                                    $patientMedicalRecord->appointment->patient_bp_since_snapshot;
                                                $years = $today->diffInYears($bpSince);
                                                $months = $today->diffInMonths($bpSince) % 12;
                                                $duration = '';
                                                if ($years > 0) {
                                                    $duration = "Last {$years} year" . ($years > 1 ? 's' : '');
                                                    if ($months > 0) {
                                                        $duration .= " and {$months} month" . ($months > 1 ? 's' : '');
                                                    }
                                                } elseif ($months > 0) {
                                                    $duration = "Last {$months} month" . ($months > 1 ? 's' : '');
                                                } else {
                                                    $duration = 'Less than a month';
                                                }
                                            @endphp
                                            {{ $duration }}
                                        </span>
                                    </div>
                                </div>
                                @endif

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
                                            @if (
                                                $patientMedicalRecord->appointment->patient_other_diseases_snapshot &&
                                                    count($patientMedicalRecord->appointment->patient_other_diseases_snapshot) > 0)
                                                {{ implode(', ', array_map('ucfirst', str_replace('_', ' ', $patientMedicalRecord->appointment->patient_other_diseases_snapshot))) }}
                                            @else
                                                None
                                            @endif
                                        </span>
                                    </div>
                                    @php
                                        // Use appointment snapshot only (not patient master record)
                                        // Only show if "others" is in the diseases array AND there's a value
$appointment = $patientMedicalRecord->appointment ?? null;
$otherDisease = null;
$showOtherDisease = false;
if (
    $appointment &&
    in_array('others', $appointment->patient_other_diseases_snapshot ?? [])
) {
    if ($appointment->patient_other_diseases_other_snapshot) {
        $otherDisease = trim(
            $appointment->patient_other_diseases_other_snapshot,
        );
        if ($otherDisease !== '') {
                                                    $showOtherDisease = true;
                                                }
                                            }
                                        }
                                    @endphp
                                    @if ($showOtherDisease)
                                        <div class="col-md-3">
                                            <strong>Specify Other Disease</strong><br>
                                            <span class="text-muted">
                                                @if (!empty($otherDisease) && is_string($otherDisease))
                                                    {{ trim($otherDisease) }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    <div class="col-md-3">
                                        <strong>Any Other Input</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_other_input_snapshot ?? 'N/A' }}</span>
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
                                        <strong>Height</strong><br>
                                        <span class="text-muted">
                                            @if ($patientMedicalRecord->appointment->patient_height)
                                                {{ $patientMedicalRecord->appointment->patient_height }}
                                                {{ $patientMedicalRecord->appointment->patient_height_unit == 'feet' ? 'feet' : 'm' }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Weight (In Kg)</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->appointment->patient_weight_snapshot ? $patientMedicalRecord->appointment->patient_weight_snapshot . ' kg' : 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>BMI</strong><br>
                                        <span class="text-muted" id="bmi-value"
                                            data-bmi="{{ $patientMedicalRecord->appointment->patient_bmi_snapshot ?? '' }}">{{ $patientMedicalRecord->appointment->patient_bmi_snapshot ?? 'N/A' }}</span>
                                        <button type="button" id="bmi-btn-underweight"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            style="display: none; pointer-events: none;">Underweight</button>
                                        <button type="button" id="bmi-btn-normal"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            style="display: none; pointer-events: none;">Normal Weight</button>
                                        <button type="button" id="bmi-btn-overweight"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            style="display: none; pointer-events: none;">Overweight</button>
                                        <button type="button" id="bmi-btn-obesity1"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            style="display: none; pointer-events: none;">Obesity Grade 1</button>
                                        <button type="button" id="bmi-btn-obesity2"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            style="display: none; pointer-events: none;">Obesity Grade 2</button>
                                        <button type="button" id="bmi-btn-obesity3"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            style="display: none; pointer-events: none;">Obesity Grade 3</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Entries Summary -->
                    @php
                        // This is for "Current Treatment" - use physician record's current_treatment_other
$physicianRec = $patientMedicalRecord->physicianRecord ?? null;
$showCurrentTreatmentOther = false;
$currentTreatmentOtherValue = '';

if ($physicianRec && $physicianRec->exists) {
    // Get directly from database using raw query
    $rawValue = \Illuminate\Support\Facades\DB::table('physician_medical_records')
        ->where('id', $physicianRec->id)
        ->value('current_treatment_other');

    // Check if "others" is in current_treatment
    $hasCurrentOthers =
        $physicianRec->current_treatment &&
        is_array($physicianRec->current_treatment) &&
        in_array('others', $physicianRec->current_treatment);

    if ($rawValue !== null && $rawValue !== '') {
        $trimmedValue = trim($rawValue);
        if ($trimmedValue !== '') {
                                    $currentTreatmentOtherValue = $trimmedValue;
                                    $showCurrentTreatmentOther = true;
                                } elseif ($hasCurrentOthers) {
                                    $showCurrentTreatmentOther = true;
                                }
                            } elseif ($hasCurrentOthers) {
                                $showCurrentTreatmentOther = true;
                            }
                        }
                    @endphp

                    @if ($patientMedicalRecord->record_type === 'physician' && $patientMedicalRecord->physicianRecord)
                        <!-- Physician Entries Summary -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Physician Entry</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Type of Diabetes</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_diabetes_type }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Family History of Diabetes</strong><br>
                                        <span
                                            class="badge {{ $patientMedicalRecord->physicianRecord->family_history_diabetes ? 'bg-success' : 'bg-danger' }}">
                                            {{ $patientMedicalRecord->physicianRecord->family_history_diabetes ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Current Treatment</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_current_treatment }}</span>
                                    </div>
                                    @if ($showCurrentTreatmentOther)
                                        <!-- Specify Other Treatment for Current Treatment (Physician Entry) -->

                                        <div class="col-md-3">
                                            <strong>Specify Other Treatment</strong><br>
                                            <span class="text-muted">
                                                @if ($currentTreatmentOtherValue !== '' && is_string($currentTreatmentOtherValue))
                                                    {{ $currentTreatmentOtherValue }}
                                                @else
                                                    Not specified
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>


                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <strong>Compliance</strong><br>
                                        <span
                                            class="badge
                                                @if ($patientMedicalRecord->physicianRecord->compliance === 'good') bg-success
                                                @elseif($patientMedicalRecord->physicianRecord->compliance === 'irregular') bg-warning
                                                @elseif($patientMedicalRecord->physicianRecord->compliance === 'poor') bg-danger
                                                @else bg-secondary @endif">
                                            {{ $patientMedicalRecord->physicianRecord->formatted_compliance }}
                                        </span>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <strong>Blood Sugar Type</strong><br>
                                        <span class="text-muted">
                                            {{ $patientMedicalRecord->physicianRecord->formatted_blood_sugar_type ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Blood Sugar Value</strong><br>
                                        <span class="text-muted">
                                            {{ $patientMedicalRecord->physicianRecord->blood_sugar_value ?? 'N/A' }}
                                        </span>
                                    </div>

                                </div>

                                <!-- New Medical Fields -->
                                <div class="row">
                                    <div class="col-12 mb-2 mt-2">
                                        <h6 class="text-primary" style="margin-top: 15px;">Additional Medical
                                            Information</h6>
                                    </div>
                                </div>
                                <!-- Hypertension and Dyslipidemia -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Hypertension</strong><br>
                                        <span class="text-muted">
                                            {{ $patientMedicalRecord->physicianRecord->hypertension ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Dyslipidemia</strong><br>
                                        <span class="text-muted">
                                            {{ $patientMedicalRecord->physicianRecord->dyslipidemia ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    @if ($patientMedicalRecord->physicianRecord->retinopathy)
                                        <div class="col-md-3">
                                            <strong>Retinopathy</strong><br>
                                            <span
                                                class="badge {{ $patientMedicalRecord->physicianRecord->formatted_retinopathy === 'Yes'
                                                    ? 'bg-success'
                                                    : ($patientMedicalRecord->physicianRecord->formatted_retinopathy === 'No'
                                                        ? 'bg-danger'
                                                        : 'bg-warning') }}">
                                                {{ $patientMedicalRecord->physicianRecord->formatted_retinopathy }}
                                            </span>
                                        </div>
                                    @endif


                                    <div class="col-md-3">
                                        <strong>Neuropathy</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_neuropathy }}</span>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong>Nephropathy</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_nephropathy }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Cardiovascular</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_cardiovascular }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Foot Disease</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_foot_disease }}</span>
                                    </div>
                                    @if ($patientMedicalRecord->physicianRecord->others && !empty($patientMedicalRecord->physicianRecord->others))
                                        <div class="col-md-3">
                                            <strong>Others</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_others }}</span>

                                        </div>
                                    @endif
                                </div>


                                <!-- HBA1C Range -->
                                <div class="row">
                                    @if ($patientMedicalRecord->physicianRecord->others_details)
                                        <div class="col-md-3">
                                            <strong>Other Details</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->physicianRecord->others_details }}</span>
                                        </div>
                                    @endif
                                    <div class="col-md-3">
                                        <strong>HBA1C Range</strong><br>
                                        <span
                                            class="text-muted">{{ $patientMedicalRecord->physicianRecord->formatted_hba1c_range ?? 'N/A' }}</span>
                                    </div>
                                    @if ($patientMedicalRecord->physicianRecord->other_data)
                                        <div class="col-md-3">
                                            <strong>Other Data</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->physicianRecord->other_data }}</span>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    @endif

                    @if ($patientMedicalRecord->record_type === 'ophthalmologist' && $patientMedicalRecord->ophthalmologistRecord)
                        <!-- Ophthalmologist Entry Summary -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Ophthalmologist Entry</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row mt-3">

                                        <div class="col-md-3">
                                            <strong>UCVA RE</strong><br>
                                            <span
                                                class="text-muted ">{{ $patientMedicalRecord->ophthalmologistRecord->ucva_re }}</span>
                                        </div>
                                        <div class="col-md-3" style="
    margin-bottom: 1rem;
">
                                            <strong>UCVA LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->ucva_le }}</span>
                                        </div>

                                        <div class="col-md-3">
                                            <strong>BCVA RE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->bcva_re }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>BCVA LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->bcva_le }}</span>
                                        </div>


                                        <div class="col-md-3">
                                            <strong>Anterior Segment RE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->anterior_segment_re }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Anterior Segment LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->anterior_segment_le }}</span>
                                        </div>


                                        <div class="col-md-3">
                                            <strong>IOP RE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->iop_re }}</span>
                                        </div>
                                        <div class="col-md-3" style="
    margin-bottom: 1rem;
">
                                            <strong>IOP LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->iop_le }}</span>
                                        </div>



                                        <div class="col-md-3">
                                            <strong>Diabetic Retinopathy (DR) RE</strong><br>
                                            <span
                                                class="badge {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_retinopathy_re ? 'bg-success' : 'bg-danger' }}">
                                                {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_retinopathy_re ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Diabetic Retinopathy (DR) LE</strong><br>
                                            <span
                                                class="badge {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_retinopathy ? 'bg-success' : 'bg-danger' }}">
                                                {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_retinopathy ? 'Yes' : 'No' }}
                                            </span>
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Diabetic Macular Edema (DME) RE</strong><br>
                                            <span
                                                class="badge {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_macular_edema_re ? 'bg-success' : 'bg-danger' }}">
                                                {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_macular_edema_re ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Diabetic Macular Edema (DME) LE</strong><br>
                                            <span
                                                class="badge {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_macular_edema ? 'bg-success' : 'bg-danger' }}">
                                                {{ $patientMedicalRecord->ophthalmologistRecord->diabetic_macular_edema ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">

                                        <div class="col-md-3">
                                            <strong>Type of DR RE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_dr_type_re }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Type of DR LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_dr_type }}</span>
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Type of DME RE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_dme_type_re }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Type of DME LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_dme_type }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <strong>Investigations</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_investigations }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Advised RE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_advised_re }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Advised LE</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->formatted_advised }}</span>
                                        </div>

                                    </div>










                                </div>

                                <div class="row mt-3">
                                    @if (
                                        $patientMedicalRecord->ophthalmologistRecord->treatment_done_date ||
                                            $patientMedicalRecord->ophthalmologistRecord->review_date)
                                        <div class="col-md-3">
                                            <strong>Treatment Done Date</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->treatment_done_date ? $patientMedicalRecord->ophthalmologistRecord->treatment_done_date->format('M d, Y') : 'Not specified' }}</span>
                                        </div>
                                        <div class="col-md-3" style="
    padding-left: 6px;">
                                            <strong>Review Date</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->review_date ? $patientMedicalRecord->ophthalmologistRecord->review_date->format('M d, Y') : 'Not specified' }}</span>
                                        </div>
                                    @endif
                                    @if ($patientMedicalRecord->ophthalmologistRecord->other_remarks)
                                        <div class="col-md-3">
                                            <strong>Other Remarks</strong><br>
                                            <span
                                                class="text-muted">{{ $patientMedicalRecord->ophthalmologistRecord->other_remarks }}</span>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-primary" onclick="printDetails()">
                                            <i class="fas fa-print me-2"></i>Print Details
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="generatePDF()">
                                            <i class="fas fa-file-pdf me-2"></i>Generate PDF
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="sendWhatsApp()"
                                            disabled>
                                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                        </button>
                                        <a href="{{ route('doctor.patients.medical-records', $patientMedicalRecord->patient->id) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            function printDetails() {
                // Open print-friendly version in new window and trigger print
                const printUrl = '{{ route('doctor.medical.summary.print', $patientMedicalRecord->id) }}';
                const printWindow = window.open(printUrl, '_blank', 'width=800,height=600');

                // Wait for the page to load, then trigger print
                printWindow.onload = function() {
                    setTimeout(function() {
                        printWindow.print();
                    }, 250);
                };
            }

            function generatePDF() {
                // Show loading
                Swal.fire({
                    title: 'Generating PDF...',
                    text: 'Please wait while we generate your medical report.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Generate PDF
                const pdfUrl = '{{ route('doctor.medical.summary.pdf', $patientMedicalRecord->id) }}';
                window.location.href = pdfUrl;

                // Close loading after a short delay
                setTimeout(() => {
                    Swal.close();
                }, 2000);
            }

            function sendWhatsApp() {
                Swal.fire({
                    title: 'Send WhatsApp',
                    html: `
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" placeholder="Enter phone number (e.g., 9876543210)" maxlength="10" pattern="[0-9]{10}">
                            <small class="form-text text-muted">Enter 10-digit phone number without country code</small>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const phoneNumber = document.getElementById('phone_number').value.trim();
                        if (!phoneNumber) {
                            Swal.showValidationMessage('Please enter a phone number');
                            return false;
                        }
                        // Validate 10 digits
                        if (!/^[0-9]{10}$/.test(phoneNumber)) {
                            Swal.showValidationMessage('Please enter a valid 10-digit phone number');
                            return false;
                        }
                        return phoneNumber;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Sending WhatsApp...',
                            text: 'Please wait while we send your message with PDF attachment.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Send WhatsApp request
                        fetch('{{ route('doctor.medical.summary.whatsapp', $patientMedicalRecord->id) }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    phone_number: result.value
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: data.message ||
                                            'Failed to send WhatsApp message. Please try again.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'An error occurred while sending WhatsApp message. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            }

            // BMI Interpretation on page load
            document.addEventListener('DOMContentLoaded', function() {
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
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
