<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('doctor.patients.index') }}">My Patients</a></li>
                <li class="breadcrumb-item active" aria-current="page">Physician Entries</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h4 class="mb-4">Physician Entries</h4>

                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{session()->get('error')}}</div>
                        @endif

                        @if(session()->has('success'))
                            <div class="alert alert-success">{{session()->get('success')}}</div>
                        @endif

                        <!-- Patient Information Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Patient Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-lg bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                                {{ substr($appointment->patient_name_snapshot, 0, 1) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $appointment->patient_name_snapshot }}</h6>
                                                <small class="text-muted">{{ $appointment->patient_email_snapshot ?? 'No email' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Mobile:</strong><br>
                                                <span class="text-muted">{{ $appointment->patient_mobile_number_snapshot }}</span>
                                            </div>
                                            <div class="col-6">
                                                <strong>SSSP ID:</strong><br>
                                                <span class="badge bg-info">{{ $appointment->patient_sssp_id_snapshot }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Age:</strong><br>
                                        <span class="text-muted">{{ $appointment->patient_age_snapshot }} years</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Sex:</strong><br>
                                        <span class="badge bg-secondary">{{ ucfirst($appointment->patient_sex_snapshot) }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Address:</strong><br>
                                        <span class="text-muted">{{ $appointment->patient_short_address_snapshot }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Physician Entries Form -->
                        <form method="POST" action="{{ route('doctor.medical.physician-entries.store', $appointment->id) }}" id="physicianEntriesForm" novalidate>
                            @csrf

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Physician Medical Entry</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Type of Diabetes -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="type_of_diabetes" class="form-label">Type of Diabetes <span class="text-danger">*</span></label>
                                            <select class="form-select" id="type_of_diabetes" name="type_of_diabetes" style="margin-bottom: 10px;">
                                                <option value="">Select Type</option>
                                                <option value="type1" {{ old('type_of_diabetes', $physicianRecord?->type_of_diabetes ?? $previousPhysicianRecord?->type_of_diabetes ?? '') == 'type1' ? 'selected' : '' }}>Type 1</option>
                                                <option value="type2" {{ old('type_of_diabetes', $physicianRecord?->type_of_diabetes ?? $previousPhysicianRecord?->type_of_diabetes ?? '') == 'type2' ? 'selected' : '' }}>Type 2</option>
                                                <option value="other" {{ old('type_of_diabetes', $physicianRecord?->type_of_diabetes ?? $previousPhysicianRecord?->type_of_diabetes ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('type_of_diabetes')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Family History of Diabetes <span class="text-danger">*</span></label>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="family_history_diabetes" id="family_history_yes" value="1"
                                                           {{ old('family_history_diabetes', $physicianRecord?->family_history_diabetes ?? $previousPhysicianRecord?->family_history_diabetes ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="family_history_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="family_history_diabetes" id="family_history_no" value="0"
                                                           {{ old('family_history_diabetes', $physicianRecord?->family_history_diabetes ?? $previousPhysicianRecord?->family_history_diabetes ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="family_history_no">No</label>
                                                </div>
                                            </div>
                                            @error('family_history_diabetes')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Current Treatment -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Current Treatment <span class="text-danger">*</span></label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="current_treatment[]" id="lifestyle" value="lifestyle"
                                                               {{ in_array('lifestyle', old('current_treatment', $physicianRecord?->current_treatment ?? $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="lifestyle">Lifestyle</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="current_treatment[]" id="oha" value="oha"
                                                               {{ in_array('oha', old('current_treatment', $physicianRecord?->current_treatment ?? $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="oha">OHA</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="current_treatment[]" id="insulin" value="insulin"
                                                               {{ in_array('insulin', old('current_treatment', $physicianRecord?->current_treatment ?? $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="insulin">Insulin</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="current_treatment[]" id="glp1" value="glp1"
                                                               {{ in_array('glp1', old('current_treatment', $physicianRecord?->current_treatment ?? $previousPhysicianRecord?->current_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="glp1">GLP 1</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('current_treatment')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Compliance -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Compliance <span class="text-danger">*</span></label>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="compliance" id="compliance_good" value="good"
                                                           {{ old('compliance', $physicianRecord?->compliance ?? $previousPhysicianRecord?->compliance ?? '') == 'good' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="compliance_good">Good</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="compliance" id="compliance_irregular" value="irregular"
                                                           {{ old('compliance', $physicianRecord?->compliance ?? $previousPhysicianRecord?->compliance ?? '') == 'irregular' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="compliance_irregular">Irregular</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="compliance" id="compliance_poor" value="poor"
                                                           {{ old('compliance', $physicianRecord?->compliance ?? $previousPhysicianRecord?->compliance ?? '') == 'poor' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="compliance_poor">Poor</label>
                                                </div>
                                            </div>
                                            @error('compliance')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Blood Sugar Value -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="blood_sugar_type" class="form-label">Blood Sugar Type <span class="text-danger">*</span></label>
                                            <select class="form-select" id="blood_sugar_type" name="blood_sugar_type">
                                                <option value="">Select Type</option>
                                                <option value="rbs" {{ old('blood_sugar_type', $physicianRecord?->blood_sugar_type ?? $previousPhysicianRecord?->blood_sugar_type ?? '') == 'rbs' ? 'selected' : '' }}>RBS</option>
                                                <option value="fbs" {{ old('blood_sugar_type', $physicianRecord?->blood_sugar_type ?? $previousPhysicianRecord?->blood_sugar_type ?? '') == 'fbs' ? 'selected' : '' }}>FBS</option>
                                                <option value="ppbs" {{ old('blood_sugar_type', $physicianRecord?->blood_sugar_type ?? $previousPhysicianRecord?->blood_sugar_type ?? '') == 'ppbs' ? 'selected' : '' }}>PPBS</option>
                                                <option value="hba1c" {{ old('blood_sugar_type', $physicianRecord?->blood_sugar_type ?? $previousPhysicianRecord?->blood_sugar_type ?? '') == 'hba1c' ? 'selected' : '' }}>HBA1C</option>
                                            </select>
                                            @error('blood_sugar_type')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="blood_sugar_value" class="form-label">Blood Sugar Value <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" max="999.99" class="form-control" id="blood_sugar_value" name="blood_sugar_value"
                                                   value="{{ old('blood_sugar_value', $physicianRecord?->blood_sugar_value ?? $previousPhysicianRecord?->blood_sugar_value ?? '') }}">
                                            @error('blood_sugar_value')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Use centralized component -->
                                    <x-physician-medical-entry field-prefix="" :physician-record="$physicianRecord ?? $previousPhysicianRecord" />

                                    <!-- Other Data -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="other_data" class="form-label">Any Other Data Specify</label>
                                            <textarea class="form-control" id="other_data" name="other_data" rows="3"
                                                      placeholder="Enter any additional information...">{{ old('other_data', $physicianRecord?->other_data ?? $previousPhysicianRecord?->other_data ?? '') }}</textarea>
                                            @error('other_data')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('doctor.patients.index') }}" class="btn btn-light me-3">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Save Entries
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
    <x-slot:footerFiles>
        <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>

        <script>
            $(document).ready(function() {
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

                // Function to show error for radio/checkbox groups
                function showGroupError(selector, message) {
                    const container = $(selector).closest('.form-group, .col-md-6, .col-12');
                    if (container.length) {
                        container.find('.field-error').remove();
                        container.append('<div class="field-error text-danger mt-1">' + message + '</div>');
                    }
                }

                // Clear errors on input
                $('input, select, textarea').on('input change', function() {
                    clearFieldError($(this).attr('id'));
                });

                // Clear errors on radio button and checkbox change
                $('input[type="radio"], input[type="checkbox"]').on('change', function() {
                    const container = $(this).closest('.form-group, .col-md-6, .col-12');
                    if (container.length) {
                        container.find('.field-error').remove();
                    }
                });

                // Handle "Other" checkbox functionality
                $('#other_condition').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#others_details_row').show();
                    } else {
                        $('#others_details_row').hide();
                        $('#others_details').val('');
                    }
                });

                // Check if "Other" is already selected on page load
                if ($('#other_condition').is(':checked')) {
                    $('#others_details_row').show();
                }

                // Form validation
                $('#physicianEntriesForm').on('submit', function(e) {
                    // Prevent browser default validation
                    e.preventDefault();

                    // Clear all previous errors
                    $('.field-error').remove();

                    const typeOfDiabetes = $('#type_of_diabetes').val();
                    const familyHistory = $('input[name="family_history_diabetes"]:checked').val();
                    const currentTreatment = $('input[name="current_treatment[]"]:checked').length;
                    const compliance = $('input[name="compliance"]:checked').val();
                    const bloodSugarType = $('#blood_sugar_type').val();
                    const bloodSugarValue = $('#blood_sugar_value').val();

                    let hasErrors = false;

                    // Validate required fields
                    if (!typeOfDiabetes) {
                        showFieldError('type_of_diabetes', 'Please select Type of Diabetes.');
                        hasErrors = true;
                    }

                    if (!familyHistory) {
                        showGroupError('input[name="family_history_diabetes"]', 'Please select Family History of Diabetes option.');
                        hasErrors = true;
                    }

                    if (currentTreatment === 0) {
                        showGroupError('input[name="current_treatment[]"]', 'Please select at least one Current Treatment option.');
                        hasErrors = true;
                    }

                    if (!compliance) {
                        showGroupError('input[name="compliance"]', 'Please select Compliance option.');
                        hasErrors = true;
                    }

                    if (!bloodSugarType) {
                        showFieldError('blood_sugar_type', 'Please select Blood Sugar Type.');
                        hasErrors = true;
                    }

                    if (!bloodSugarValue) {
                        showFieldError('blood_sugar_value', 'Please enter Blood Sugar Value.');
                        hasErrors = true;
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
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
