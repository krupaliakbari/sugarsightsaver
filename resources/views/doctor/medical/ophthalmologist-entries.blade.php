<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('doctor.patients.index') }}">My Patients</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ophthalmologist Entry</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <div class="row layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h4 class="mb-4">Ophthalmologist Entry</h4>

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

                        <!-- DEBUG INFO (REMOVE AFTER TESTING) -->
                        @if(config('app.debug'))
                        <div class="alert alert-info mb-3">
                            <strong>Debug Info:</strong><br>
                            Current Record Exists: {{ $ophthalmologistRecord ? 'YES (ID: '.$ophthalmologistRecord->id.')' : 'NO' }}<br>
                            Previous Record Exists: {{ $previousOphthalmologistRecord ? 'YES (ID: '.$previousOphthalmologistRecord->id.')' : 'NO' }}<br>
                            @if($previousOphthalmologistRecord)
                                Previous DR Value: {{ $previousOphthalmologistRecord->diabetic_retinopathy ? '1 (YES)' : '0 (NO)' }}<br>
                                Previous Type of DR: {{ $previousOphthalmologistRecord->type_of_dr ?? 'NULL' }}<br>
                                Previous DME Value: {{ $previousOphthalmologistRecord->diabetic_macular_edema ? '1 (YES)' : '0 (NO)' }}<br>
                                Previous Investigations: {{ json_encode($previousOphthalmologistRecord->investigations ?? []) }}<br>
                            @endif
                        </div>
                        @endif
                        <!-- END DEBUG -->

                        <!-- Ophthalmologist Entry Form -->
                        <form method="POST" action="{{ route('doctor.medical.ophthalmologist-entries.store', $appointment->id) }}" id="ophthalmologistEntriesForm">
                            @csrf

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Ophthalmologist Medical Entry</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Diabetic Retinopathy (DR) and Macular Edema -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Diabetic Retinopathy (DR) <span class="text-danger">*</span></label>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="diabetic_retinopathy" id="dr_yes" value="1"
                                                           {{ old('diabetic_retinopathy', $ophthalmologistRecord?->diabetic_retinopathy ?? $previousOphthalmologistRecord?->diabetic_retinopathy ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="dr_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="diabetic_retinopathy" id="dr_no" value="0"
                                                           {{ old('diabetic_retinopathy', $ophthalmologistRecord?->diabetic_retinopathy ?? $previousOphthalmologistRecord?->diabetic_retinopathy ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="dr_no">No</label>
                                                </div>
                                            </div>
                                            @error('diabetic_retinopathy')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Diabetic Macular Edema (DME) <span class="text-danger">*</span></label>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="diabetic_macular_edema" id="dme_yes" value="1"
                                                           {{ old('diabetic_macular_edema', $ophthalmologistRecord?->diabetic_macular_edema ?? $previousOphthalmologistRecord?->diabetic_macular_edema ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="dme_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="diabetic_macular_edema" id="dme_no" value="0"
                                                           {{ old('diabetic_macular_edema', $ophthalmologistRecord?->diabetic_macular_edema ?? $previousOphthalmologistRecord?->diabetic_macular_edema ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="dme_no">No</label>
                                                </div>
                                            </div>
                                            @error('diabetic_macular_edema')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Type of DR -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="type_of_dr" class="form-label">Type of DR (ETDRS) <span class="text-danger">*</span></label>
                                            <select class="form-select" id="type_of_dr" name="type_of_dr">
                                                <option value="">Select Type</option>
                                                <optgroup label="NPDR">
                                                    <option value="npdr_mild" {{ old('type_of_dr', $ophthalmologistRecord?->type_of_dr ?? $previousOphthalmologistRecord?->type_of_dr ?? '') == 'npdr_mild' ? 'selected' : '' }}>Mild</option>
                                                    <option value="npdr_moderate" {{ old('type_of_dr', $ophthalmologistRecord?->type_of_dr ?? $previousOphthalmologistRecord?->type_of_dr ?? '') == 'npdr_moderate' ? 'selected' : '' }}>Moderate</option>
                                                    <option value="npdr_severe" {{ old('type_of_dr', $ophthalmologistRecord?->type_of_dr ?? $previousOphthalmologistRecord?->type_of_dr ?? '') == 'npdr_severe' ? 'selected' : '' }}>Severe</option>
                                                    <option value="npdr_very_severe" {{ old('type_of_dr', $ophthalmologistRecord?->type_of_dr ?? $previousOphthalmologistRecord?->type_of_dr ?? '') == 'npdr_very_severe' ? 'selected' : '' }}>Very Severe</option>
                                                </optgroup>
                                                <optgroup label="PDR">
                                                    <option value="pdr_non_high_risk" {{ old('type_of_dr', $ophthalmologistRecord?->type_of_dr ?? $previousOphthalmologistRecord?->type_of_dr ?? '') == 'pdr_non_high_risk' ? 'selected' : '' }}>Non-High Risk</option>
                                                    <option value="pdr_high_risk" {{ old('type_of_dr', $ophthalmologistRecord?->type_of_dr ?? $previousOphthalmologistRecord?->type_of_dr ?? '') == 'pdr_high_risk' ? 'selected' : '' }}>High Risk</option>
                                                </optgroup>
                                            </select>
                                            @error('type_of_dr')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="type_of_dme_status" class="form-label">Type Of DME <span class="text-danger">*</span></label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <select class="form-select" id="type_of_dme_status" name="dme_status">
                                                        <option value="">Select Type</option>
                                                        <option value="nil_absent" {{ old('dme_status', in_array(old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? ''), ['nil_absent']) ? 'nil_absent' : (in_array(old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '')) == 'nil_absent' ? 'selected' : '' }}>Nil/Absent</option>
                                                        <option value="present" {{ old('dme_status', in_array(old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'present' : '') == 'present' ? 'selected' : '' }}>Present</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <!-- Sub-options for Present (shown conditionally) -->
                                                    <div id="dme_severity_container" style="display: {{ in_array(old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'block' : 'none' }};">
                                                        <select class="form-select" id="dme_severity" name="type_of_dme">
                                                            <option value="">Select DME</option>
                                                            <option value="mild" {{ old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? '') == 'mild' ? 'selected' : '' }}>Mild</option>
                                                            <option value="moderate" {{ old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? '') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                                            <option value="severe" {{ old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? '') == 'severe' ? 'selected' : '' }}>Severe (Based On Inv Of Fovea)</option>
                                                        </select>
                                                    </div>
                                                    <!-- Placeholder when severity container is hidden -->
                                                    <div id="dme_severity_placeholder" style="display: {{ in_array(old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? ''), ['present', 'mild', 'moderate', 'severe']) ? 'none' : 'block' }};">
                                                        <select class="form-select" disabled>
                                                            <option>Select DME</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hidden input for Nil/Absent value -->
                                            <input type="hidden" name="type_of_dme" id="dme_hidden_nil_absent" value="nil_absent"
                                                   {{ old('type_of_dme', $ophthalmologistRecord?->type_of_dme ?? $previousOphthalmologistRecord?->type_of_dme ?? '') == 'nil_absent' ? '' : 'disabled' }}>

                                            @error('type_of_dme')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Investigations and Advised -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Investigations</label>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="investigations[]" id="fundus_pic" value="fundus_pic"
                                                               {{ in_array('fundus_pic', old('investigations', $ophthalmologistRecord?->investigations ?? $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="fundus_pic">Fundus pic</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="investigations[]" id="oct" value="oct"
                                                               {{ in_array('oct', old('investigations', $ophthalmologistRecord?->investigations ?? $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="oct">Oct</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="investigations[]" id="octa" value="octa"
                                                               {{ in_array('octa', old('investigations', $ophthalmologistRecord?->investigations ?? $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="octa">Octa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="investigations[]" id="ffa" value="ffa"
                                                               {{ in_array('ffa', old('investigations', $ophthalmologistRecord?->investigations ?? $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ffa">Ffa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="investigations[]" id="others" value="others"
                                                               {{ in_array('others', old('investigations', $ophthalmologistRecord?->investigations ?? $previousOphthalmologistRecord?->investigations ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="others">Others</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2" id="investigations_others_container" style="display: {{ in_array('others', old('investigations', $ophthalmologistRecord?->investigations ?? $previousOphthalmologistRecord?->investigations ?? [])) ? 'block' : 'none' }};">
                                                <div class="col-md-6">
                                                    <label for="investigations_others" class="form-label">Specify Other Investigations <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('investigations_others') is-invalid @enderror" id="investigations_others" name="investigations_others"
                                                           value="{{ old('investigations_others', $ophthalmologistRecord?->investigations_others ?? $previousOphthalmologistRecord?->investigations_others ?? '') }}"
                                                           placeholder="Enter other investigations...">
                                                    @error('investigations_others')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @error('investigations')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="advised" class="form-label">Advised</label>
                                            <select class="form-select" id="advised" name="advised">
                                                <option value="">Select Treatment</option>
                                                <option value="no_treatment" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'no_treatment' ? 'selected' : '' }}>No treatment</option>
                                                <option value="close_watch" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'close_watch' ? 'selected' : '' }}>Close watch</option>
                                                <option value="drops" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'drops' ? 'selected' : '' }}>Any other drops</option>
                                                <option value="medications" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'medications' ? 'selected' : '' }}>Medications</option>
                                                <option value="focal_laser" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'focal_laser' ? 'selected' : '' }}>Focal laser</option>
                                                <option value="prp_laser" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'prp_laser' ? 'selected' : '' }}>PRP laser</option>
                                                <option value="intravit_inj" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'intravit_inj' ? 'selected' : '' }}>Intravit inj antivefg</option>
                                                <option value="steroid" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'steroid' ? 'selected' : '' }}>Steroid</option>
                                                <option value="surgery" {{ old('advised', $ophthalmologistRecord?->advised ?? $previousOphthalmologistRecord?->advised ?? '') == 'surgery' ? 'selected' : '' }}>Surgery</option>
                                            </select>
                                            @error('advised')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Treatment Dates -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="treatment_done_date" class="form-label">Treatment Done Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="treatment_done_date" name="treatment_done_date"
                                                   value="{{ old('treatment_done_date', $ophthalmologistRecord?->treatment_done_date ?? $previousOphthalmologistRecord?->treatment_done_date ?? '') }}" placeholder="Select Treatment Date">
                                            @error('treatment_done_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="review_date" class="form-label">Review Date</label>
                                            <input type="text" class="form-control flatpickr-input" id="review_date" name="review_date"
                                                   value="{{ old('review_date', $ophthalmologistRecord?->review_date ?? $previousOphthalmologistRecord?->review_date ?? '') }}" placeholder="Select Review Date">
                                            @error('review_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Other Remarks -->
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="other_remarks" class="form-label">Other Remarks</label>
                                            <textarea class="form-control" id="other_remarks" name="other_remarks" rows="3"
                                                      placeholder="Enter any additional remarks...">{{ old('other_remarks', $ophthalmologistRecord?->other_remarks ?? $previousOphthalmologistRecord?->other_remarks ?? '') }}</textarea>
                                            @error('other_remarks')
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
        <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
        <script src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>

        <script>
            // Handle "Others" checkbox for Investigations
            document.addEventListener('DOMContentLoaded', function() {
                const othersCheckbox = document.getElementById('others');
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

            // Form validation
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
                $('#ophthalmologistEntriesForm').on('submit', function(e) {
                    const othersCheckbox = document.getElementById('others');
                    const othersInput = document.getElementById('investigations_others');

                    if (othersCheckbox && othersCheckbox.checked) {
                        if (!othersInput || !othersInput.value || !othersInput.value.trim()) {
                            e.preventDefault();
                            showFieldError('investigations_others', 'Please specify other investigations.');
                            Snackbar.show({
                                text: 'Please fill in all required fields.',
                                pos: 'top-right',
                                showAction: false,
                                duration: 5000,
                                textColor: '#fff',
                                backgroundColor: '#e7515a'
                            });
                            return false;
                        }
                    }
                });
            });

            $(document).ready(function() {
                // Initialize Flatpickr for date pickers
                flatpickr("#treatment_done_date", {
                    dateFormat: "Y-m-d",
                    maxDate: "today"
                });

                flatpickr("#review_date", {
                    dateFormat: "Y-m-d",
                    minDate: "today"
                });
                // Form validation
                $('#ophthalmologistEntriesForm').on('submit', function(e) {
                    const diabeticRetinopathy = $('input[name="diabetic_retinopathy"]:checked').length;
                    const diabeticMacularEdema = $('input[name="diabetic_macular_edema"]:checked').length;

                    if (!diabeticRetinopathy || !diabeticMacularEdema) {
                        e.preventDefault();
                        Snackbar.show({
                            text: 'Please fill in all required fields.',
                            pos: 'top-right',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                        return false;
                    }
                });
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
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
