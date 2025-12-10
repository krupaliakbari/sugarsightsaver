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
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <h4 class="mb-4">Edit Patient - {{ $patient->name }}</h4>

                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{session()->get('error')}}</div>
                        @endif

                        @if(session()->has('success'))
                            <div class="alert alert-success">{{session()->get('success')}}</div>
                        @endif

                        <!-- Patient Edit Form -->
                        <form method="POST" action="{{ route('doctor.patients.update', $patient->id) }}" id="editPatientForm">
                            @csrf
                            @method('PUT')

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
                                                       value="{{ old('name', $patient->name) }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                            <label for="mobile_number" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                                   value="{{ $patient->mobile_number }}" readonly>
                                            <small class="text-muted">Mobile number cannot be changed</small>
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                            <label for="diabetes_from" class="form-label">Diabetes Since </label>
                                            <input type="text" class="form-control flatpickr-input" id="diabetes_from" name="diabetes_from"
                                                       value="{{ old('diabetes_from', $patient->diabetes_from ? $patient->diabetes_from->format('m-Y') : '') }}" placeholder="Select Month & Year">
                                            @error('diabetes_from')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Diabetes Duration<span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="diabetes_years" name="diabetes_years"
                                                               value="{{ old('diabetes_years') }}" placeholder="Years" min="0" max="100">
                                                               @error('diabetes_years')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="diabetes_months" name="diabetes_months"
                                                               value="{{ old('diabetes_months') }}" placeholder="Months" min="0" max="11">
                                                                @error('diabetes_months')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                    </div>
                                                </div>
                                                <small class="text-muted">Enter number of years and months since diabetes diagnosis</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="date_of_birth" class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control flatpickr-input" id="date_of_birth" name="date_of_birth"
                                                       value="{{ old('date_of_birth', $patient->date_of_birth ? $patient->date_of_birth->format('d-m-Y') : '') }}" placeholder="Select Date of Birth">
                                            @error('date_of_birth')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                            <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="age" name="age"
                                                       value="{{ old('age', $patient->age) }}" min="1" max="120">
                                            @error('age')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                            <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                                                <select class="form-select" id="sex" name="sex">
                                                <option value="">Select Sex</option>
                                                <option value="male" {{ old('sex', $patient->sex) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('sex', $patient->sex) == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('sex', $patient->sex) == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('sex')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="short_address" class="form-label">Short Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="short_address" name="short_address" rows="2">{{ old('short_address', $patient->short_address) }}</textarea>
                                                @error('short_address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                            <label for="hospital_id" class="form-label">Hospital ID</label>
                                            <input type="text" class="form-control" id="hospital_id" name="hospital_id"
                                                   value="{{ old('hospital_id', $patient->hospital_id) }}">
                                            @error('hospital_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       value="{{ old('email', $patient->email) }}">
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
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
                                                           {{ old('on_treatment', $patient->on_treatment) == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="on_treatment_yes">On Treatment</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="on_treatment" id="on_treatment_no" value="0"
                                                           {{ old('on_treatment', $patient->on_treatment) == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="on_treatment_no">Not On Treatment</label>
                                                </div>
                                            </div>
                                            @error('on_treatment')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="type_of_treatment_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Type Of Treatment <span class="text-danger">*</span></label>
                                                <div class="mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="allopathic" value="allopathic"
                                                               {{ in_array('allopathic', old('type_of_treatment', $patient->type_of_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="allopathic">Allopathic</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="diet_control" value="diet_control"
                                                               {{ in_array('diet_control', old('type_of_treatment', $patient->type_of_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="diet_control">Diet Control</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="ayurvedic" value="ayurvedic"
                                                               {{ in_array('ayurvedic', old('type_of_treatment', $patient->type_of_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ayurvedic">Ayurvedic</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="type_of_treatment[]" id="others_treatment" value="others"
                                                               {{ in_array('others', old('type_of_treatment', $patient->type_of_treatment ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="others_treatment">Others</label>
                                                    </div>
                                                </div>
                                                @error('type_of_treatment')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                        <div class="col-md-6" id="type_of_treatment_other_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label for="type_of_treatment_other" class="form-label">Specify Other Treatment <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="type_of_treatment_other" name="type_of_treatment_other"
                                                       value="{{ old('type_of_treatment_other', $patient->type_of_treatment_other) }}" placeholder="Enter other treatment type">
                                                @error('type_of_treatment_other')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">BP <span class="text-danger">*</span></label>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="bp" id="bp_yes" value="1"
                                                           {{ old('bp', $patient->bp) == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="bp_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="bp" id="bp_no" value="0"
                                                           {{ old('bp', $patient->bp) == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="bp_no">No</label>
                                                </div>
                                            </div>
                                            @error('bp')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-md-6" id="bp_since_container" style="display: none;">
                                            <div class="form-group mb-3">
                                            <label for="bp_since" class="form-label">BP Since </label>
                                             <input type="text" class="form-control flatpickr-input" id="bp_since" name="bp_since"
                                                       value="{{ old('bp_since', $patient->bp_since ? $patient->bp_since->format('m-Y') : '') }}" placeholder="Select Month & Year">
                                            @error('bp_since')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="bp_duration_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label class="form-label">BP Duration <span class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="bp_years" name="bp_years"
                                                               value="{{ old('bp_years') }}" placeholder="Years" min="0" max="100">
                                                               @error('bp_years')
            <div class="text-danger">{{ $message }}</div>
        @enderror
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" class="form-control" id="bp_months" name="bp_months"
                                                               value="{{ old('bp_months') }}" placeholder="Months" min="0" max="11">
                                                                @error('bp_months')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
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
                                                               {{ in_array('heart_disease', old('other_diseases', $patient->other_diseases ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="heart_disease">Heart Disease</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="cholesterol" value="cholesterol"
                                                               {{ in_array('cholesterol', old('other_diseases', $patient->other_diseases ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="cholesterol">Cholesterol</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="thyroid" value="thyroid"
                                                               {{ in_array('thyroid', old('other_diseases', $patient->other_diseases ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="thyroid">Thyroid</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="stroke" value="stroke"
                                                               {{ in_array('stroke', old('other_diseases', $patient->other_diseases ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="stroke">Stroke</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="other_diseases[]" id="others_diseases" value="others"
                                                               {{ in_array('others', old('other_diseases', $patient->other_diseases ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="others_diseases">Others</label>
                                                    </div>
                                                </div>
                                                @error('other_diseases')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="other_diseases_other_container" style="display: none;">
                                            <div class="form-group mb-3">
                                                <label for="other_diseases_other" class="form-label">Specify Other Disease <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="other_diseases_other" name="other_diseases_other"
                                                       value="{{ old('other_diseases_other', $patient->other_diseases_other) }}" placeholder="Enter other disease">
                                                @error('other_diseases_other')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="other_input" class="form-label">Any Other Input</label>
                                                <textarea class="form-control" id="other_input" name="other_input" rows="2">{{ old('other_input', $patient->other_input) }}</textarea>
                                                @error('other_input')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
                               {{ old('height_unit', $patient->height_unit) == 'meter' ? 'checked' : '' }}>
                        <label class="form-check-label" for="unit_meter">Meter</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="height_unit" id="unit_feet" value="feet"
                               {{ old('height_unit', $patient->height_unit) == 'feet' ? 'checked' : '' }}>
                        <label class="form-check-label" for="unit_feet">Feet</label>
                    </div>
                    @error('height_unit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label for="height" class="form-label">
                        Height
                        <span id="height-unit-display">(in {{ old('height_unit', $patient->height_unit) == 'feet' ? 'Feet' : 'Meters' }})</span>
                    </label>
                    <input type="number"
                           class="form-control"
                           id="height"
                           name="height"
                           value="{{ old('height', $patient->height) }}"
                           step="0.01"
                           placeholder="{{ old('height_unit', $patient->height_unit) == 'feet' ? 'e.g., 5.9' : 'e.g., 1.75' }}">
                    <small class="text-muted" id="height-hint">
                        {{ old('height_unit', $patient->height_unit) == 'feet' ? 'Range: 2.0 – 9.0 feet' : 'Range: 0.5 – 3.0 meters' }}
                    </small>
                    @error('height')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label for="weight" class="form-label">Weight (In Kg)</label>
                    <input type="number" class="form-control" id="weight" name="weight"
                           value="{{ old('weight', $patient->weight) }}" step="0.01" min="1" max="500">
                    @error('weight')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label for="bmi" class="form-label">BMI</label>
                    <div class="">
                        <input type="text" class="form-control" id="bmi" name="bmi"
                               value="{{ old('bmi', $patient->bmi) }}" readonly style="max-width: 100px; margin-bottom: 10px;">
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
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('doctor.patients.index') }}" class="btn btn-light me-3">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Patient
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
        <script src="{{asset('js/bmi-interpretation.js')}}"></script>

        <script>
            $(document).ready(function() {
                console.log('Document is ready');
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
        if (diabetesFromField.value) {
            // Clear diabetes from field immediately when duration is cleared
            if (window.diabetesFromFlatpickr) {
                window.diabetesFromFlatpickr.clear();
            } else {
                diabetesFromField.value = '';
            }
        }
        return; // Stop further processing
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

    // CORRECTED: Properly handle m-Y format from flatpickr
    if (diabetesFromDate instanceof Date) {
        // It's already a Date object from flatpickr
        fromDate = diabetesFromDate;
    } else if (typeof diabetesFromDate === 'string') {
        // If it's a string in "m-Y" format (e.g., "01-2020")
        const [month, year] = diabetesFromDate.split('-');
        if (month && year) {
            fromDate = new Date(parseInt(year), parseInt(month) - 1, 1); // month is 0-indexed
        } else {
            // Invalid format
            document.getElementById('diabetes_years').value = '';
            document.getElementById('diabetes_months').value = '';
            isUpdatingFromDate = false;
            return;
        }
    } else {
        // Invalid date
        document.getElementById('diabetes_years').value = '';
        document.getElementById('diabetes_months').value = '';
        isUpdatingFromDate = false;
        return;
    }

    // Validate that fromDate is a valid date and not in the future
    if (isNaN(fromDate.getTime()) || fromDate > today) {
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

               // Initialize flatpickr for diabetes_from with enhanced clearing
window.diabetesFromFlatpickr = flatpickr("#diabetes_from", {
    dateFormat: "m-Y",
    maxDate: "today",
    onChange: function(selectedDates, dateStr, instance) {
        if (selectedDates.length > 0) {
            calculateDiabetesSince(selectedDates[0]);
        } else {
            // When diabetes from is cleared, also clear duration fields
            document.getElementById('diabetes_years').value = '';
            document.getElementById('diabetes_months').value = '';
        }
    }
});

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
                const diabetesFromValue = $('#diabetes_from').val();
                if (diabetesFromValue) {
                    const dateParts = diabetesFromValue.split('-');
                    if (dateParts.length === 2) {
                        const month = parseInt(dateParts[0]) - 1; // Months are 0-indexed
                        const year = parseInt(dateParts[1]);
                        const date = new Date(year, month, 1);
                        calculateDiabetesSince(date);
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
              function calculateBPFrom() {
    if (isUpdatingBPFromDate) return; // Prevent loop

    const years = parseInt(document.getElementById('bp_years').value) || 0;
    const months = parseInt(document.getElementById('bp_months').value) || 0;
    const bpSinceField = document.getElementById('bp_since');

    if (!bpSinceField) return;

    // Check if both fields are empty or zero - clear immediately
    if (years === 0 && months === 0) {
        if (bpSinceField.value) {
            // Clear BP since field immediately when duration is cleared
            if (window.bpSinceFlatpickr) {
                window.bpSinceFlatpickr.clear();
            } else {
                bpSinceField.value = '';
            }
        }
        return; // Stop further processing
    }

    // Only proceed with calculation if we have valid values
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

    // CORRECTED: Properly handle m-Y format from flatpickr
    if (bpSinceDate instanceof Date) {
        // It's already a Date object from flatpickr
        fromDate = bpSinceDate;
    } else if (typeof bpSinceDate === 'string') {
        // If it's a string in "m-Y" format (e.g., "01-2020")
        const [month, year] = bpSinceDate.split('-');
        if (month && year) {
            fromDate = new Date(parseInt(year), parseInt(month) - 1, 1); // month is 0-indexed
        } else {
            // Invalid format
            const bpYearsField = document.getElementById('bp_years');
            const bpMonthsField = document.getElementById('bp_months');
            if (bpYearsField) bpYearsField.value = '';
            if (bpMonthsField) bpMonthsField.value = '';
            isUpdatingBPFromDate = false;
            return;
        }
    } else {
        // Invalid date
        const bpYearsField = document.getElementById('bp_years');
        const bpMonthsField = document.getElementById('bp_months');
        if (bpYearsField) bpYearsField.value = '';
        if (bpMonthsField) bpMonthsField.value = '';
        isUpdatingBPFromDate = false;
        return;
    }

    // Validate that fromDate is a valid date and not in the future
    if (isNaN(fromDate.getTime()) || fromDate > today) {
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

                // Initialize flatpickr for bp_since with enhanced clearing
window.bpSinceFlatpickr = flatpickr("#bp_since", {
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

           // Height unit conversion and BMI calculation
const heightInput = document.getElementById('height');
const weightInput = document.getElementById('weight');
const bmiInput = document.getElementById('bmi');
const unitMeter = document.getElementById('unit_meter');
const unitFeet = document.getElementById('unit_feet');
const unitDisplay = document.getElementById('height-unit-display');
const heightHint = document.getElementById('height-hint');

// Track if this is the initial page load
let isInitialLoad = true;

function updateHeightConstraints() {
    if (unitFeet.checked) {
        // Feet configuration
        heightInput.setAttribute('min', '2');
        heightInput.setAttribute('max', '9.0');
        heightInput.setAttribute('step', '0.1');
        heightInput.setAttribute('placeholder', 'e.g., 5.9');
        unitDisplay.textContent = '(in Feet)';
        heightHint.textContent = 'Range: 2.0 – 9.0 feet';

        // Convert existing meter value to feet if needed and not already converted
        if (heightInput.value && !heightInput.dataset.converted) {
            const meters = parseFloat(heightInput.value);
            if (meters > 0) {
                heightInput.value = (meters / 0.3048).toFixed(1);
                heightInput.dataset.converted = 'true';
            }
        }
    } else {
        // Meter configuration
        heightInput.setAttribute('min', '0.5');
        heightInput.setAttribute('max', '3.0');
        heightInput.setAttribute('step', '0.01');
        heightInput.setAttribute('placeholder', 'e.g., 1.75');
        unitDisplay.textContent = '(in Meters)';
        heightHint.textContent = 'Range: 0.5 – 3.0 meters';

        // Convert existing feet value to meters if needed and not already converted
        if (heightInput.value && !heightInput.dataset.converted) {
            const feet = parseFloat(heightInput.value);
            if (feet > 0) {
                heightInput.value = (feet * 0.3048).toFixed(2);
                heightInput.dataset.converted = 'true';
            }
        }
    }

    // Only calculate BMI if not initial load (to avoid hiding existing BMI category)
    if (!isInitialLoad) {
        calculateBMI();
    }
}
  calculateBMI();
function showBMICategory(bmiValue) {
    // Hide all BMI category buttons first
    document.querySelectorAll('[id^="bmi-btn-"]').forEach(btn => {
        btn.style.display = 'none';
        btn.classList.remove('btn-info', 'btn-success', 'btn-warning', 'btn-danger');
        btn.classList.add('btn-outline-secondary');
    });

    if (!bmiValue || bmiValue <= 0) {
        return;
    }

    // Show correct BMI category
    let btnId = '';
    let btnClass = '';

    if (bmiValue < 18.5) {
        btnId = 'bmi-btn-underweight';
        btnClass = 'btn-info';
    } else if (bmiValue <= 22.9) {
        btnId = 'bmi-btn-normal';
        btnClass = 'btn-success';
    } else if (bmiValue <= 24.9) {
        btnId = 'bmi-btn-overweight';
        btnClass = 'btn-warning';
    } else if (bmiValue <= 29.9) {
        btnId = 'bmi-btn-obesity1';
        btnClass = 'btn-danger';
    } else if (bmiValue <= 34.9) {
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

function calculateBMI() {
    const height = parseFloat(heightInput.value);
    const weight = parseFloat(weightInput.value);
    const unit = document.querySelector('input[name="height_unit"]:checked')?.value || 'meter';

    if (!height || !weight || height <= 0 || weight <= 0) {
        bmiInput.value = '';
        showBMICategory(null);
        return;
    }

    // Convert height to meters for BMI calculation (SAME as PHP calculation)
    let heightInMeters = unit === 'feet' ? height * 0.3048 : height;

    // Calculate BMI (SAME formula as PHP)
    const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(2);
    bmiInput.value = bmi;

    // Show BMI category
    console.log('Calculated BMI:', bmi); // Debug log
    showBMICategory(parseFloat(bmi));
}

// Show initial BMI category on page load
function showInitialBMICategory() {
    const initialBMI = parseFloat(bmiInput.value);
    console.log('Initial BMI:', initialBMI); // Debug log

    if (initialBMI && initialBMI > 0) {
        showBMICategory(initialBMI);
    } else {
        // If no BMI in input field, try to calculate from height/weight
        const height = parseFloat(heightInput.value);
        const weight = parseFloat(weightInput.value);

        if (height && weight && height > 0 && weight > 0) {
            calculateBMI();
        }
    }
}

// Event listeners for unit change
unitMeter?.addEventListener('change', function() {
    heightInput.dataset.converted = 'false';
    isInitialLoad = false;
    updateHeightConstraints();
});

unitFeet?.addEventListener('change', function() {
    heightInput.dataset.converted = 'false';
    isInitialLoad = false;
    updateHeightConstraints();
});

// Event listeners for BMI calculation
heightInput?.addEventListener('input', function() {
    isInitialLoad = false;
    calculateBMI();
});

weightInput?.addEventListener('input', function() {
    isInitialLoad = false;
    calculateBMI();
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // First show the initial BMI category
    showInitialBMICategory();

    // Then update height constraints (but don't recalculate BMI on initial load)
    updateHeightConstraints();

    // Mark initial load as complete
    isInitialLoad = false;

    console.log('DOM loaded - BMI value:', bmiInput.value); // Debug log
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


                // BP Since field visibility control
                function toggleBpSinceField() {
                    const bpValue = $('input[name="bp"]:checked').val();
                    if (bpValue === '1') {
                        $('#bp_since_container').show();
                        $('#bp_duration_container').show();
                    } else {
                        $('#bp_since_container').hide();
                        $('#bp_duration_container').hide();
                        $('#bp_since').val(''); // Clear the value when hidden
                        $('#bp_years').val(''); // Clear years when hidden
                        $('#bp_months').val(''); // Clear months when hidden
                    }
                }

                // Initialize BP Since field visibility on page load
                toggleBpSinceField();

                // Toggle BP Since field when BP radio buttons change
                $('input[name="bp"]').on('change', toggleBpSinceField);

                // Type of Treatment "Others" field toggle
                function toggleTypeOfTreatmentOther() {
                    const othersCheckbox = $('#others_treatment');
                    const otherContainer = $('#type_of_treatment_other_container');
                    const otherInput = $('#type_of_treatment_other');

                    if (othersCheckbox.is(':checked')) {
                        otherContainer.show();
                    } else {
                        otherContainer.hide();
                        otherInput.val('');
                    }
                }

                // Other Diseases "Others" field toggle
                function toggleOtherDiseasesOther() {
                    const othersCheckbox = $('#others_diseases');
                    const otherContainer = $('#other_diseases_other_container');
                    const otherInput = $('#other_diseases_other');

                    if (othersCheckbox.is(':checked')) {
                        otherContainer.show();
                    } else {
                        otherContainer.hide();
                        otherInput.val('');
                    }
                }

                // Initialize and add event listeners
                $('#others_treatment').on('change', toggleTypeOfTreatmentOther);
                $('#others_diseases').on('change', toggleOtherDiseasesOther);

                // Check on page load
                toggleTypeOfTreatmentOther();
                toggleOtherDiseasesOther();

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

                // Clear errors on radio button and checkbox change
                $('input[type="radio"], input[type="checkbox"]').on('change', function() {
                    const container = $(this).closest('.form-group');
                    if (container.length) {
                        container.find('.field-error').remove();
                    }
                });

                // Form validation
                $('#editPatientForm').on('submit', function(e) {
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
                    const bp = $('input[name="bp"]:checked').length;
                    const bpValue = $('input[name="bp"]:checked').val();
                    const bpSince = $('#bp_since').val();

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


                    // Validate Type of Treatment Other field when Others is selected
                    const othersCheckbox = $('#others_treatment');
                    const typeOfTreatmentOther = $('#type_of_treatment_other').val();
                    if (othersCheckbox.is(':checked') && !typeOfTreatmentOther) {
                        showFieldError('type_of_treatment_other', 'Please specify other treatment type.');
                        hasErrors = true;
                    }

                    // Validate Other Diseases Other field when Others is selected
                    const othersDiseasesCheckbox = $('#others_diseases');
                    const otherDiseasesOther = $('#other_diseases_other').val();
                    if (othersDiseasesCheckbox.is(':checked') && !otherDiseasesOther) {
                        showFieldError('other_diseases_other', 'Please specify other disease.');
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
//                                         document.addEventListener('DOMContentLoaded', function() {
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



document.addEventListener('DOMContentLoaded', function () {
    const treatmentContainer         = document.getElementById('type_of_treatment_container');
    const otherTreatmentContainer    = document.getElementById('type_of_treatment_other_container');
    const othersCheckbox             = document.getElementById('others_treatment');
    const otherTreatmentInput        = document.getElementById('type_of_treatment_other');

    function updateTreatmentVisibility() {
        const onTreatmentYes = document.getElementById('on_treatment_yes').checked;

        if (onTreatmentYes) {
            // Show the whole treatment section
            treatmentContainer.style.display = 'block';

            // Show "Specify Other" only if "Others" checkbox is checked
            if (othersCheckbox && othersCheckbox.checked) {
                otherTreatmentContainer.style.display = 'block';
            } else {
                otherTreatmentContainer.style.display = 'none';
            }
        } else {
            // "Not On Treatment" → hide everything and reset
            treatmentContainer.style.display = 'none';
            otherTreatmentContainer.style.display = 'none';

            // Reset all treatment checkboxes and the "other" text field
            document.querySelectorAll('input[name="type_of_treatment[]"]').forEach(cb => {
                cb.checked = false;
            });
            if (othersCheckbox) othersCheckbox.checked = false;
            if (otherTreatmentInput) otherTreatmentInput.value = '';
        }
    }

    // Initial state
    updateTreatmentVisibility();

    // Listen to "On Treatment" radio buttons
    document.querySelectorAll('input[name="on_treatment"]').forEach(radio => {
        radio.addEventListener('change', updateTreatmentVisibility);
    });

    // Listen to the "Others" checkbox (only matters when "On Treatment" is selected)
    if (othersCheckbox) {
        othersCheckbox.addEventListener('change', function () {
            if (document.getElementById('on_treatment_yes').checked) {
                otherTreatmentContainer.style.display = this.checked ? 'block' : 'none';
            }
        });
    }
});

// Add these functions for bidirectional clearing

// Function to handle clearing diabetes since when duration fields are cleared
function handleDiabetesDurationClear() {
    const diabetesYearsField = document.getElementById('diabetes_years');
    const diabetesMonthsField = document.getElementById('diabetes_months');
    const diabetesFromField = document.getElementById('diabetes_from');
    
    if (diabetesYearsField && diabetesMonthsField && diabetesFromField) {
        // Check if both duration fields are empty or zero
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

// Function to handle clearing BP since when duration fields are cleared
function handleBPDurationClear() {
    const bpYearsField = document.getElementById('bp_years');
    const bpMonthsField = document.getElementById('bp_months');
    const bpSinceField = document.getElementById('bp_since');
    
    if (bpYearsField && bpMonthsField && bpSinceField) {
        // Check if both duration fields are empty or zero
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

// Update your existing calculateDiabetesFrom function to include clear logic
function calculateDiabetesFrom() {
    if (isUpdatingFromDate) return; // Prevent loop

    const years = parseInt(document.getElementById('diabetes_years').value) || 0;
    const months = parseInt(document.getElementById('diabetes_months').value) || 0;
    const diabetesFromField = document.getElementById('diabetes_from');

    // Check if both fields are empty or zero - clear immediately
    if (years === 0 && months === 0) {
        if (diabetesFromField.value) {
            // Clear diabetes from field immediately when duration is cleared
            if (window.diabetesFromFlatpickr) {
                window.diabetesFromFlatpickr.clear();
            } else {
                diabetesFromField.value = '';
            }
        }
        return; // Stop further processing
    }

    // Only proceed with calculation if we have valid values
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

// Update your existing calculateBPFrom function to include clear logic
function calculateBPFrom() {
    if (isUpdatingBPFromDate) return; // Prevent loop

    const years = parseInt(document.getElementById('bp_years').value) || 0;
    const months = parseInt(document.getElementById('bp_months').value) || 0;
    const bpSinceField = document.getElementById('bp_since');

    if (!bpSinceField) return;

    // Check if both fields are empty or zero
    if (years === 0 && months === 0) {
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

// Update your diabetes duration event listeners
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
        
        // Add blur event for immediate clearing
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

        // Add blur event for immediate clearing
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

    // Update your BP duration event listeners
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

    // Update flatpickr initializations to handle clearing
    if (window.diabetesFromFlatpickr) {
        // Update diabetes from flatpickr to clear duration fields when date is cleared
        window.diabetesFromFlatpickr.config.onChange.push(function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 0) {
                // When diabetes from is cleared, also clear duration fields
                document.getElementById('diabetes_years').value = '';
                document.getElementById('diabetes_months').value = '';
            }
        });
    }

    if (window.bpSinceFlatpickr) {
        // Update BP since flatpickr to clear duration fields when date is cleared
        window.bpSinceFlatpickr.config.onChange.push(function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 0) {
                // When BP since is cleared, also clear duration fields
                document.getElementById('bp_years').value = '';
                document.getElementById('bp_months').value = '';
            }
        });
    }

    // Calculate initial values on page load
    const diabetesFromValue = $('#diabetes_from').val();
    if (diabetesFromValue) {
        const dateParts = diabetesFromValue.split('-');
        if (dateParts.length === 2) {
            const month = parseInt(dateParts[0]) - 1; // Months are 0-indexed
            const year = parseInt(dateParts[1]);
            const date = new Date(year, month, 1);
            calculateDiabetesSince(date);
        }
    } else if ((diabetesYearsField && diabetesYearsField.value) || (diabetesMonthsField && diabetesMonthsField.value)) {
        calculateDiabetesFrom();
    }

    const bpSince = document.getElementById('bp_since');
    if (bpSince && bpSince.value) {
        const dateValue = bpSince.value;
        if (dateValue) {
            const dateParts = dateValue.split('-');
            if (dateParts.length === 2) {
                const month = parseInt(dateParts[0]) - 1;
                const year = parseInt(dateParts[1]);
                const date = new Date(year, month, 1);
                calculateBPDuration(date);
            }
        }
    } else if ((bpYearsField && bpYearsField.value) || (bpMonthsField && bpMonthsField.value)) {
        calculateBPFrom();
    }
});
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
