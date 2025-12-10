<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report - <?php echo e($patient->name); ?></title>
    <script>
        // Auto-trigger print dialog when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 250);
        };
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.2;
            color: #333;
            background: #ffffff;
            font-size: 13px;
            padding: 8px;
        }

        .header {
    display: flex;
    align-items: left;
    justify-content: left;
    border-bottom: 2px solid #000;
    padding: 10px 0;
    margin-bottom: 10px;
}

.header img {
    height: 40px;
    width: auto;
    margin-right: 15px;
}

.header-text {
    text-align: left;
}

.header-text h1 {
    color: #000;
    margin: 0;
    font-size: 13px;
    font-weight: bold;
}

.header-text h2 {
    color: #666;
    margin: 5px 0 0;
    font-size: 13px;
    font-weight: normal;
}

        .report-info {
            background: #f5f5f5;
            padding: 5px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
        }

        .report-info .row {
            display: table;
            width: 100%;
            margin-bottom: 3px;
            table-layout: fixed;
        }

        .report-info .row:last-child {
            margin-bottom: 0;
        }

        .report-info .label {
            font-weight: bold;
            color: #495057;
            display: table-cell;
            width: 40%;
            vertical-align: top;
            padding-right: 10px;
        }

        .report-info .row > span:not(.label) {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .card {
            border: 1px solid #000;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }

        .card-header {
            background-color: #000;
            color: white;
            padding: 5px 8px;
            font-size: 13px;
            font-weight: bold;
        }

        .card-body {
            padding: 6px;
            background: #ffffff;
        }

        .row {
            width: 100%;
            margin-bottom: 3px;
            overflow: hidden;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        .col-md-3 {
            float: left;
            width: 25%;
            padding: 2px 6px;
            box-sizing: border-box;
        }

        .col-md-6 {
            float: left;
            width: 50%;
            padding: 2px 6px;
            box-sizing: border-box;
        }

        .col-md-9 {
            float: left;
            width: 75%;
            padding: 2px 6px;
            box-sizing: border-box;
        }

        .col-md-12, .col-12 {
            float: left;
            width: 100%;
            padding: 2px 6px;
            box-sizing: border-box;
        }

        /* Clear floats after rows */
        .row:has(.col-md-3):after,
        .row:has(.col-md-6):after,
        .row:has(.col-md-9):after,
        .row:has(.col-md-12):after,
        .row:has(.col-12):after {
            content: "";
            display: table;
            clear: both;
        }

        .mt-3 {
            margin-top: 4px;
        }

        .mt-4 {
            margin-top: 5px;
        }

        .mb-3 {
            margin-bottom: 3px;
        }

        .mb-2 {
            margin-bottom: 3px;
        }

        strong {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 1px;
            font-size: 13px;
        }

        .text-muted {
            color: #666;
            font-size: 13px;
            line-height: 1.1;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            border: 1px solid #000;
        }

        .bg-success, .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .bg-danger, .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .bg-warning, .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .bg-info, .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .bg-secondary {
            background: #6c757d;
            color: white;
        }

        h6 {
            font-size: 13px;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
            margin-top: 4px;
        }

        .signature-section {
            margin-top: 15px;
            display: table;
            width: 100%;
        }

        .signature-row {
            display: table-row;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 15px;
            vertical-align: top;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            height: 40px;
            margin-bottom: 10px;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-label {
            font-weight: bold;
            color: #000;
            font-size: 13px;
        }

        .footer {
            margin-top: 15px;
            padding: 10px;
            border-top: 1px solid #000;
            text-align: center;
            color: #000;
            font-size: 13px;
        }

        @page {
            margin: 0.3cm;
            size: A4;
        }

        @media print {
            /* Remove browser headers and footers */
            @page {
                margin: 0.3cm;
                size: A4;
            }

            body {
                margin: 0 !important;
                padding: 5px !important;
            }

            .card {
                page-break-inside: avoid;
                margin-bottom: 5px !important;
            }

            .card-header {
                padding: 4px 8px !important;
                font-size: 13px !important;
            }

            .card-body {
                padding: 5px !important;
            }

            .header {
                page-break-after: avoid;
                padding: 5px 0 !important;
                margin-bottom: 5px !important;
            }

            .header h1 {
                font-size: 13px !important;
                margin: 0 !important;
            }

            .header h2 {
                font-size: 13px !important;
                margin: 2px 0 0 0 !important;
            }

            .report-info {
                padding: 5px !important;
                margin-bottom: 5px !important;
            }

            .report-info .row {
                margin-bottom: 3px !important;
            }

            .row {
                margin-bottom: 3px !important;
            }

            strong {
                font-size: 13px !important;
                margin-bottom: 1px !important;
            }

            .text-muted {
                font-size: 13px !important;
                line-height: 1.1 !important;
            }

            .col-md-3, .col-md-6, .col-md-9, .col-md-12 {
                padding: 1px 4px !important;
            }

            h6 {
                font-size: 13px !important;
                margin-bottom: 3px !important;
                margin-top: 4px !important;
            }

            .badge {
                padding: 2px 6px !important;
                font-size: 13px !important;
            }

            .mt-3 {
                margin-top: 4px !important;
            }

            .mt-4 {
                margin-top: 5px !important;
            }

            .mb-3 {
                margin-bottom: 3px !important;
            }

            .signature-section {
                page-break-before: avoid;
                margin-top: 8px !important;
            }

            .footer {
                page-break-before: avoid;
                margin-top: 8px !important;
                padding: 5px !important;
                font-size: 13px !important;
            }

          .report-info .row {
    display: table;
    width: 100%;
    margin-bottom: 3px;
    table-layout: fixed;
}
.report-info .label {
    font-weight: bold;
    color: #495057;
    display: table-cell;
    width: 40%;
    vertical-align: top;
    padding-right: 10px;
    text-align: left; /* Ensure labels are left-aligned */
}
.report-info .row > span:not(.label) {
    display: table-cell;
    width: 60%;
    vertical-align: top;
    text-align: right; /* Ensure values are right-aligned */
}
        }


        /* COMMON STYLE FOR ALL BMI BUTTONS */
.bmi-btn {
    display: inline-block;
    padding: 4px 10px;
    font-size: 13px;
    border-radius: 4px;
    font-weight: bold;
    margin-left: 8px;
    border: 1px solid transparent;
}

/* INFO (Bootstrap .btn-info) */
.bmi-info {
    background-color: #0dcaf0;
    border-color: #0dcaf0;
    color: #000;
}

/* SUCCESS (Bootstrap .btn-success) */
.bmi-success {
    background-color: #198754;
    border-color: #198754;
    color: #fff;
}

/* WARNING (Bootstrap .btn-warning) */
.bmi-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #000;
}

/* DANGER (Bootstrap .btn-danger) */
.bmi-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}
.right-content {
    width: 40%;
    text-align: right;
    margin-left: auto; /* This pushes it to the right */
}

    </style>
</head>
<body>
    <!-- Header -->
<!-- Header -->
<div class="header">
    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo">
    <div class="header-text">
        <h1><?php echo e(strtoupper($medicalRecord->record_type)); ?>'S REPORT</h1>
        <h2 style="font-weight: bold;">Sugar Sight Saver Project</h2>
    </div>
    <div class="right-content">
        <div class="row">
            <span class="label">Report ID</span>
            <span><?php echo e($report_id); ?></span>
        </div>
        <div class="row">
            <span class="label">Generated On</span>
            <span><?php echo e($generated_at); ?></span>
        </div>
        <div class="row">
            <span class="label">Appointment Date</span>
            <span><?php echo e($appointment->visit_date_time->format('M d, Y H:i')); ?></span>
        </div>
    </div>
</div>

    <!-- Report Information -->
    

    <!-- Patient Information Card -->
    <div class="card">
        <div class="card-header">Patient Information</div>
        <div class="card-body">
            <!-- Appointment Details Row -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Appointment Date</strong>
                    <span class="text-muted"><?php echo e($appointment->visit_date_time->format('M d, Y H:i')); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Appointment Type</strong>
                    <span class="badge bg-info"><?php echo e(ucfirst($appointment->appointment_type)); ?></span>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
            </div>

            <!-- Patient Profile Row -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Name</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_name_snapshot ?? $patient->name); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Mobile</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_mobile_number_snapshot ?? $patient->mobile_number); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>SSSP ID</strong>
                    <span class="badge bg-info"><?php echo e($appointment->patient_sssp_id_snapshot ?? $patient->sssp_id); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Email</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_email_snapshot ?? $patient->email ?? 'N/A'); ?></span>
                </div>
            </div>

            <!-- Basic Details Row -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Diabetes From</strong>
                    <span class="text-muted"><?php echo e(($appointment->patient_diabetes_from_snapshot ?? $patient->diabetes_from) ? ($appointment->patient_diabetes_from_snapshot ?? $patient->diabetes_from)->format('M Y') : 'N/A'); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Diabetes Since</strong>
                    <span class="text-muted">
                        <?php
                            $diabetesFrom = $appointment->patient_diabetes_from_snapshot ?? $patient->diabetes_from;
                        ?>
                        <?php if($diabetesFrom): ?>
                            <?php
                                $today = now();
                                $years = $today->diffInYears($diabetesFrom);
                                $months = $today->diffInMonths($diabetesFrom) % 12;
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
                            ?>
                            <?php echo e($duration); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </span>
                </div>
                <div class="col-md-3">
                    <strong>Date Of Birth</strong>
                    <span class="text-muted"><?php echo e(($appointment->patient_date_of_birth_snapshot ?? $patient->date_of_birth) ? ($appointment->patient_date_of_birth_snapshot ?? $patient->date_of_birth)->format('M d, Y') : 'N/A'); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Age</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_age_snapshot ?? $patient->age); ?> years</span>
                </div>
            </div>

            <!-- Demographics Row -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Sex</strong>
                    <span class="badge bg-secondary"><?php echo e(ucfirst($appointment->patient_sex_snapshot ?? $patient->sex)); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Hospital ID</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_hospital_id_snapshot ?? $patient->hospital_id ?? 'N/A'); ?></span>
                </div>
                <div class="col-md-6">
                    <strong>Short Address</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_short_address_snapshot ?? $patient->short_address); ?></span>
                </div>
            </div>
                 <?php
// On Treatment
$onTreatment = $appointment->patient_on_treatment_snapshot ?? $patient->on_treatment;

// Type of Treatment
$typeTreatment = $appointment->patient_type_of_treatment_snapshot ?? $patient->type_of_treatment ?? [];
$typeOthers = is_array($typeTreatment) && in_array('others', $typeTreatment);

$treatmentOtherValue = $patient->type_of_treatment_other ?? '';
$showOtherTreatment = $typeOthers || !empty($treatmentOtherValue);

// BP Logic
$bp = $appointment->patient_bp_snapshot ?? $patient->bp;
$bpSince = $appointment->patient_bp_since_snapshot ?? $patient->bp_since;

// Duration
$bpDuration = null;
if ($bp && $bpSince) {
    $today = now();
    $years = $today->diffInYears($bpSince);
    $months = $today->diffInMonths($bpSince) % 12;

    if ($years > 0) {
        $bpDuration = "Last {$years} year" . ($years > 1 ? 's' : '');
        if ($months > 0) {
            $bpDuration .= " and {$months} month" . ($months > 1 ? 's' : '');
        }
    } elseif ($months > 0) {
        $bpDuration = "Last {$months} month" . ($months > 1 ? 's' : '');
    } else {
        $bpDuration = "Less than a month";
    }
}
?>

                <!-- Treatment Information Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Treatment Information</h6>
                    </div>
                </div>

                <!-- Treatment Information Row -->
                
                    <div class="row mb-3">

    <!-- On Treatment -->
    <div class="col-md-3">
        <strong>On Treatment</strong>
        <span class="badge <?php echo e($onTreatment ? 'bg-success' : 'bg-danger'); ?>">
            <?php echo e($onTreatment ? 'Yes' : 'No'); ?>

        </span>
    </div>

    <!-- Type of Treatment -->
    <div class="col-md-3">
        <strong>Type Of Treatment</strong>
        <span class="text-muted">
            <?php if(!empty($typeTreatment)): ?>
                <?php echo e(implode(', ', array_map('ucfirst', str_replace('_', ' ', $typeTreatment)))); ?>

            <?php else: ?>
                Not specified
            <?php endif; ?>
        </span>
    </div>

    <!-- Specify Other Treatment -->
    <div class="col-md-3">
        <strong>Specify Other Treatment</strong>
        <span class="text-muted">
            <?php if($showOtherTreatment): ?>
                <?php echo e($treatmentOtherValue ?: 'Not specified'); ?>

            <?php else: ?>
                Not applicable
            <?php endif; ?>
        </span>
    </div>

    <!-- EMPTY col -->
    <div class="col-md-3"></div>

</div>

                
                <div class="row mb-3">

    <!-- BP -->
    <div class="col-md-3">
        <strong>BP</strong>
        <span class="badge <?php echo e($bp ? 'bg-success' : 'bg-danger'); ?>">
            <?php echo e($bp ? 'Yes' : 'No'); ?>

        </span>
    </div>

    <!-- BP Since -->
    <div class="col-md-3">
        <strong>BP Since</strong>
        <span class="text-muted">
            <?php echo e($bp && $bpSince ? $bpSince->format('M Y') : 'N/A'); ?>

        </span>
    </div>

    <!-- BP Duration -->
    <div class="col-md-3">
        <strong>BP Duration</strong>
        <span class="text-muted">
            <?php echo e($bpDuration ?? 'N/A'); ?>

        </span>
    </div>

    <!-- EMPTY col -->
    <div class="col-md-3"></div>

</div>


            <!-- Other Diseases Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <h6>Other Diseases</h6>
                </div>
            </div>

            <!-- Other Diseases Row -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Any Other Diseases</strong>
                    <span class="text-muted">
                        <?php
                            $diseases = $appointment->patient_other_diseases_snapshot ?? $patient->other_diseases;
                        ?>
                        <?php if($diseases && count($diseases) > 0): ?>
                            <?php echo e(implode(', ', array_map('ucfirst', str_replace('_', ' ', $diseases)))); ?>

                        <?php else: ?>
                            None
                        <?php endif; ?>
                    </span>
                </div>
                <?php
                    $diseases = $appointment->patient_other_diseases_snapshot ?? $patient->other_diseases;
                ?>
                <?php if($diseases && in_array('others', $diseases)): ?>
                <div class="col-md-3">
                    <strong>Specify Other Disease</strong>
                    <span class="text-muted">
                        <?php
                            $otherDisease = $patient->getOriginal('other_diseases_other');
                            if ($otherDisease === null) {
                                $otherDisease = $patient->other_diseases_other;
                            }
                        ?>
                        <?php if(!empty($otherDisease) && is_string($otherDisease)): ?>
                            <?php echo e(trim($otherDisease)); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </span>
                </div>
                <div class="col-md-3">
                    <strong>Any Other Input</strong>
                    <span class="text-muted"><?php echo e($appointment->patient_other_input_snapshot ?? $patient->other_input ?? 'N/A'); ?></span>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <?php else: ?>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <?php endif; ?>
            </div>

            <!-- Other Input Row -->
            <div class="row mb-3">
                
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
            </div>

            <!-- Physical Measurements Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <h6>Physical Measurements</h6>
                </div>
            </div>
   <?php
    $bmi = $appointment->patient_bmi_snapshot ?? null;

    $bmiLabel = null;
    $bmiColorClass = null;

    if ($bmi) {
        if ($bmi < 18.5) {
            $bmiLabel = "Underweight";
            $bmiColorClass = "bmi-info";
        } elseif ($bmi >= 18.5 && $bmi <= 22.9) {
            $bmiLabel = "Normal Weight";
            $bmiColorClass = "bmi-success";
        } elseif ($bmi >= 23.0 && $bmi <= 24.9) {
            $bmiLabel = "Overweight";
            $bmiColorClass = "bmi-warning";
        } elseif ($bmi >= 25.0 && $bmi <= 29.9) {
            $bmiLabel = "Obesity Grade 1";
            $bmiColorClass = "bmi-danger";
        } elseif ($bmi >= 30.0 && $bmi <= 34.9) {
            $bmiLabel = "Obesity Grade 2";
            $bmiColorClass = "bmi-danger";
        } elseif ($bmi > 35) {
            $bmiLabel = "Obesity Grade 3";
            $bmiColorClass = "bmi-danger";
        }
    }
?>
            <!-- Physical Measurements Row -->
            <div class="row mb-3">
                <div class="col-md-3">
    <strong>Height</strong>
    <span class="text-muted">
        <?php if($height = $appointment->patient_height_snapshot ?? $patient->height): ?>
            <?php echo e($height); ?> 
            <?php echo e(($appointment->patient_height_unit_snapshot ?? $patient->height_unit) == 'feet' ? 'feet' : 'm'); ?>

        <?php else: ?>
            N/A
        <?php endif; ?>
    </span>
</div>
                <div class="col-md-3">
                    <strong>Weight (In Kg)</strong>
                    <span class="text-muted"><?php echo e(($appointment->patient_weight_snapshot ?? $patient->weight) ? ($appointment->patient_weight_snapshot ?? $patient->weight) . ' kg' : 'N/A'); ?></span>
                </div>
                   <div class="col-md-3">
    <strong>BMI</strong>
    <span class="text-muted"><?php echo e($bmi ?? 'N/A'); ?></span>

    <?php if($bmiLabel): ?>
        <span class="bmi-btn <?php echo e($bmiColorClass); ?>">
            <?php echo e($bmiLabel); ?>

        </span>
    <?php endif; ?>
</div>
            </div>
        </div>
    </div>

    <!-- Medical Entries Summary -->
    <?php if($medicalRecord->record_type === 'physician' && $physicianRecord): ?>
    <!-- Physician Entry Summary -->
    <div class="card">
        <div class="card-header">Physician Entry</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Type of Diabetes</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_diabetes_type); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Family History of Diabetes</strong>
                    <span class="badge <?php echo e($physicianRecord->family_history_diabetes ? 'bg-success' : 'bg-danger'); ?>">
                        <?php echo e($physicianRecord->family_history_diabetes ? 'Yes' : 'No'); ?>

                    </span>
                </div>
                 <div class="col-md-3">
                    <strong>Current Treatment</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_current_treatment); ?></span>
                </div>
                 <!-- Specify Other Treatment for Current Treatment (Physician Entry) -->
            <?php
                // This is for "Current Treatment" - use physician record's current_treatment_other
                $physicianRecForCurrent = $medicalRecord->physicianRecord ?? null;
                $showCurrentTreatmentOther = false;
                $currentTreatmentOtherValue = '';

                if ($physicianRecForCurrent && $physicianRecForCurrent->exists) {
                    // Get directly from database using raw query
                    $rawValue = \Illuminate\Support\Facades\DB::table('physician_medical_records')
                        ->where('id', $physicianRecForCurrent->id)
                        ->value('current_treatment_other');

                    // Check if "others" is in current_treatment
                    $hasCurrentOthers = $physicianRecForCurrent->current_treatment && is_array($physicianRecForCurrent->current_treatment) && in_array('others', $physicianRecForCurrent->current_treatment);

                    if($rawValue !== null && $rawValue !== '') {
                        $trimmedValue = trim($rawValue);
                        if($trimmedValue !== '') {
                            $currentTreatmentOtherValue = $trimmedValue;
                            $showCurrentTreatmentOther = true;
                        } elseif ($hasCurrentOthers) {
                            $showCurrentTreatmentOther = true;
                        }
                    } elseif ($hasCurrentOthers) {
                        $showCurrentTreatmentOther = true;
                    }
                }
            ?>
            <?php if($showCurrentTreatmentOther): ?>
            
                <div class="col-md-3">
                    <strong>Specify Other Treatment</strong>
                    <span class="text-muted">
                        <?php if($currentTreatmentOtherValue !== '' && is_string($currentTreatmentOtherValue)): ?>
                            <?php echo e($currentTreatmentOtherValue); ?>

                        <?php else: ?>
                            Not specified
                        <?php endif; ?>
                    </span>
                </div>
                <?php endif; ?>
                
            </div>
                 <div class="row">
                 <div class="col-md-3">
                    <strong>Compliance</strong>
                        <span class="badge
                        <?php if($physicianRecord->compliance === 'good'): ?> bg-success
                        <?php elseif($physicianRecord->compliance === 'irregular'): ?> bg-warning
                        <?php elseif($physicianRecord->compliance === 'poor'): ?> bg-danger
                        <?php else: ?> bg-secondary <?php endif; ?>">
                            <?php echo e($physicianRecord->formatted_compliance); ?>

                        </span>
                </div>
                 <div class="col-md-3">
                    <strong>Blood Sugar Type</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_blood_sugar_type ?? 'N/A'); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Blood Sugar Value</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->blood_sugar_value ?? 'N/A'); ?></span>
                </div>
            </div>
            


            <!-- New Medical Fields -->
            <div class="row">
                <div class="col-12 mb-2">
                    <h6>Additional Medical Information</h6>
                </div>
            </div>
            <!-- Hypertension and Dyslipidemia -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Hypertension</strong>
                    <span class="text-muted">
                            <?php echo e($physicianRecord->hypertension ? 'Yes' : 'No'); ?>

                        </span>
                </div>
                <div class="col-md-3">
                    <strong>Dyslipidemia</strong>
                    <span class="text-muted">
                            <?php echo e($physicianRecord->dyslipidemia ? 'Yes' : 'No'); ?>

                        </span>
                </div>
                 <!-- Retinopathy -->
           <?php if($physicianRecord->retinopathy): ?>
    <div class="col-md-3">
        <strong>Retinopathy</strong>
        <span class="badge <?php echo e($physicianRecord->formatted_retinopathy === 'Yes' ? 'bg-success' :
            ($physicianRecord->formatted_retinopathy === 'No' ? 'bg-danger' : 'bg-warning')); ?>">
            <?php echo e($physicianRecord->formatted_retinopathy ?? 'Unknown'); ?>

        </span>
    </div>
<?php endif; ?>
            <div class="col-md-3">
                    <strong>Neuropathy</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_neuropathy); ?></span>
                </div>
            </div>

           

            <div class="row mb-3">
                
                <div class="col-md-3">
                    <strong>Nephropathy</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_nephropathy); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Cardiovascular</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_cardiovascular); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Foot Disease</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_foot_disease); ?></span>
                </div>
                <?php if($physicianRecord->others && !empty($physicianRecord->others)): ?>
            
                <div class="col-md-3">
                    <strong>Others</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_others); ?></span>
                </div>
            <?php endif; ?>

            </div>



            
            <?php if($physicianRecord->others_details): ?>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Other Details</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->others_details); ?></span>
                </div>
                 <div class="col-md-3">
                    <strong>HBA1C Range</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->formatted_hba1c_range ?? 'N/A'); ?></span>
                </div>
                 <?php if($physicianRecord->other_data): ?>
                    <div class="col-md-3">
                    <strong>Other Data</strong>
                    <span class="text-muted"><?php echo e($physicianRecord->other_data); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

           
            
        </div>
    </div>
    <?php endif; ?>

    <?php if($medicalRecord->record_type === 'ophthalmologist' && $ophthalmologistRecord): ?>
    <!-- Ophthalmologist Entry Summary -->
<div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Ophthalmologist Entry</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                            <strong>UCVA RE</strong>
                                            <span class="text-muted "><?php echo e($ophthalmologistRecord->ucva_re); ?></span>
                                            </div>
                                        <div class="col-md-3">
                                            <strong>UCVA LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->ucva_le); ?></span>
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <strong>BCVA RE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->bcva_re); ?></span>
                                            </div>
                                                                                    <div class="col-md-3">
                                            <strong>BCVA LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->bcva_le); ?></span>
                                            </div>
                                        <div class="col-md-3">
                                            <strong>IOP RE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->iop_re); ?></span>
                                            </div>
                                            <div class="col-md-3">
                                            <strong>IOP LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->iop_le); ?></span>
                                            </div>

                                        <div class="col-md-3">
                                            <strong>Anterior Segment RE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->anterior_segment_re); ?></span>
                                            </div>
                                            <div class="col-md-3">
                                            <strong>Anterior Segment LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->anterior_segment_le); ?></span>
                                            </div>

                                    </div>
                                        
                                        <div class="col-md-3">
                                            <strong>Diabetic Retinopathy (DR) RE</strong>
                                            <span class="badge <?php echo e($ophthalmologistRecord->diabetic_retinopathy_re ? 'bg-success' : 'bg-danger'); ?>">
                                                <?php echo e($ophthalmologistRecord->diabetic_retinopathy_re ? 'Yes' : 'No'); ?>

                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Diabetic Retinopathy (DR) LE</strong>
                                            <span class="badge <?php echo e($ophthalmologistRecord->diabetic_retinopathy ? 'bg-success' : 'bg-danger'); ?>">
                                                <?php echo e($ophthalmologistRecord->diabetic_retinopathy ? 'Yes' : 'No'); ?>

                                            </span>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <strong>Diabetic Macular Edema (DME) RE</strong>
                                            <span class="badge <?php echo e($ophthalmologistRecord->diabetic_macular_edema_re ? 'bg-success' : 'bg-danger'); ?>">
                                                <?php echo e($ophthalmologistRecord->diabetic_macular_edema_re ? 'Yes' : 'No'); ?>

                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Diabetic Macular Edema (DME) LE</strong>
                                            <span class="badge <?php echo e($ophthalmologistRecord->diabetic_macular_edema ? 'bg-success' : 'bg-danger'); ?>">
                                                <?php echo e($ophthalmologistRecord->diabetic_macular_edema ? 'Yes' : 'No'); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        
                                               <div class="col-md-3">
                                            <strong>Type of DR RE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_dr_type_re); ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Type of DR LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_dr_type); ?></span>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <strong>Type of DME RE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_dme_type_re); ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Type of DME LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_dme_type); ?></span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <strong>Investigations</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_investigations); ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Advised RE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_advised_re); ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Advised LE</strong>
                                            <span class="text-muted"><?php echo e($ophthalmologistRecord->formatted_advised); ?></span>
                                        </div>
                                          
                                    </div>

                                   
                                        <div class="row mt-3">
                                             <?php if($ophthalmologistRecord->treatment_done_date || $ophthalmologistRecord->review_date): ?>
                                            <div class="col-md-3">
                                                <strong>Treatment Done Date</strong>
                                                <span class="text-muted"><?php echo e($ophthalmologistRecord->treatment_done_date ? $ophthalmologistRecord->treatment_done_date->format('M d, Y') : 'Not specified'); ?></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Review Date</strong>
                                                <span class="text-muted"><?php echo e($ophthalmologistRecord->review_date ? $ophthalmologistRecord->review_date->format('M d, Y') : 'Not specified'); ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if($ophthalmologistRecord->other_remarks): ?>
                                            <div class="col-md-3">
                                                <strong>Other Remarks</strong>
                                                <span class="text-muted"><?php echo e($ophthalmologistRecord->other_remarks); ?></span>
                                            </div>
                                        
                                    
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
    <?php endif; ?>

    <!-- Doctor Information -->
    <div class="card">
        <div class="card-header">Doctor Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Doctor Name</strong>
                    <span class="text-muted"><?php echo e($doctor->name); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Hospital</strong>
                    <span class="text-muted"><?php echo e($doctor->hospital_name ?? 'Not specified'); ?></span>
                </div>
                <div class="col-md-3">
                    <strong>Specialist</strong>
                    <span class="text-muted"><?php echo e(ucfirst(str_replace('_', ' ', $doctor->doctor_type))); ?></span>
                </div>
            </div>

        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-row">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Doctor's Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">Date</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    
</body>
</html>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/reports/medical-report-print.blade.php ENDPATH**/ ?>