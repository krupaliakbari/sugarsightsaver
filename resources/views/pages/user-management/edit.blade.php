<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>{{ $title }}</x-slot>

    <!-- Header Files -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        <style>
            .text-danger {
                font-size: 0.875rem;
                margin-top: 0.25rem;
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
        </style>
    </x-slot>

    <!-- Breadcrumb -->
    {{-- <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user-management') }}">{{ $breadcrumb }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
    </div> --}}


    <div class="row layout-top-spacing">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Edit Doctor</h4>

                        </div>

                    <!-- Success/Error Alerts -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user-management.update', $doctor->id) }}" id="editdoctor"
                        onsubmit="return validateDoctorEditForm()">
                        @csrf
                        @method('PUT')

                        <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">General Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                            <!-- Full Name -->
                            <div class="col-md-4">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="doctorName" class="form-control"
                                    value="{{ old('name', $doctor->name) }}" placeholder="Enter full name">
                                <div id="doctorNameError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-4">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="doctorEmail" class="form-control"
                                    value="{{ old('email', $doctor->email) }}" placeholder="Enter email">
                                <div id="doctorEmailError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-4">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="doctorPhone" class="form-control"
                                    maxlength="10" oninput="validatePhoneInput(this)"
                                    value="{{ old('phone', $doctor->phone) }}"
                                    placeholder="Enter 10-digit phone number">
                                <div id="doctorPhoneError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- New Password (Optional) -->
                            <div class="col-md-4">
                                <label class="form-label">New Password <small class="text-muted">(Leave blank to keep
                                        current)</small></label>
                                <input type="password" name="password" id="doctorPassword" class="form-control"
                                    placeholder="Enter new password">
                                <div id="doctorPasswordError" class="text-danger" style="display: none;"></div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="doctorPasswordConfirm"
                                    class="form-control" placeholder="Confirm new password">
                                <div id="doctorPasswordConfirmError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Hospital Name -->
                            <div class="col-md-4">
                                <label class="form-label">Hospital Name <span class="text-danger">*</span></label>
                                <input type="text" name="hospital_name" id="hospitalName" class="form-control"
                                    value="{{ old('hospital_name', $doctor->hospital_name) }}">
                                <div id="hospitalNameError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Doctor Type -->
                            <div class="col-md-4">
                                <label class="form-label">Doctor Type <span class="text-danger">*</span></label>
                                <select name="doctor_type" id="doctorType" class="form-select">
                                    <option value="">Select Doctor Type</option>
                                    <option value="diabetes_treating"
                                        {{ old('doctor_type', $doctor->doctor_type) == 'diabetes_treating' ? 'selected' : '' }}>
                                        Diabetes-Treating Physician
                                    </option>
                                    <option value="ophthalmologist"
                                        {{ old('doctor_type', $doctor->doctor_type) == 'ophthalmologist' ? 'selected' : '' }}>
                                        Ophthalmologist
                                    </option>
                                </select>
                                <div id="doctorTypeError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Medical Council Reg Number -->
                            <div class="col-md-4">
                                <label class="form-label">Medical Council Reg. No. <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="medical_council_registration_number"
                                    id="medicalCouncilRegNumber" class="form-control"
                                    value="{{ old('medical_council_registration_number', $doctor->medical_council_registration_number) }}">
                                <div id="medicalCouncilRegNumberError" class="text-danger" style="display: none;">
                                </div>
                            </div>

                            <!-- State -->
                            <div class="col-md-4">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <select name="state" id="state" class="form-select">
                                    <option value="">Select State</option>
                                    @foreach (['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Jammu and Kashmir', 'Ladakh', 'Lakshadweep', 'Puducherry'] as $stateName)
                                        <option value="{{ $stateName }}"
                                            {{ old('state', $doctor->state) == $stateName ? 'selected' : '' }}>
                                            {{ $stateName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="stateError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" rows="3" class="form-control">{{ old('address', $doctor->address) }}</textarea>
                                <div id="addressError" class="text-danger" style="display: none;"></div>
                            </div>

                            <!-- Qualification -->
                            <div class="col-6">
                                <label class="form-label">Qualification <span class="text-danger">*</span></label>
                                <textarea name="qualification" id="qualification" rows="3" class="form-control">{{ old('qualification', $doctor->qualification) }}</textarea>
                                <div id="qualificationError" class="text-danger" style="display: none;"></div>
                            </div>

                        </div>

                              
                        

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('user-management') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Doctor
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <!-- Custom Validation Script -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script>
            // Hide error when user starts typing
            document.addEventListener('DOMContentLoaded', function() {
                const fields = ['doctorName', 'doctorEmail', 'doctorPhone', 'doctorPassword', 'doctorPasswordConfirm',
                    'hospitalName', 'doctorType', 'address', 'qualification', 'medicalCouncilRegNumber', 'state'
                ];

                fields.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.addEventListener('input', function() {
                            document.getElementById(id + 'Error').style.display = 'none';

                        });
                    }
                });
            });

            function validatePhoneInput(input) {
                input.value = input.value.replace(/\D/g, '').substring(0, 10);
            }

            function validateDoctorEditForm() {
                let isValid = true;

                // Reset all errors
                document.querySelectorAll('.text-danger').forEach(el => el.style.display = 'none');


                const name = document.getElementById('doctorName').value.trim();
                const email = document.getElementById('doctorEmail').value.trim();
                const phone = document.getElementById('doctorPhone').value.trim();
                const password = document.getElementById('doctorPassword').value;
                const passwordConfirm = document.getElementById('doctorPasswordConfirm').value;
                const hospitalName = document.getElementById('hospitalName').value.trim();
                const doctorType = document.getElementById('doctorType').value;
                const address = document.getElementById('address').value.trim();
                const qualification = document.getElementById('qualification').value.trim();
                const medicalReg = document.getElementById('medicalCouncilRegNumber').value.trim();
                const state = document.getElementById('state').value;

                // Required fields
                if (!name) {
                    showError('doctorName', 'Name is required');
                    isValid = false;
                }
                if (!email) {
                    showError('doctorEmail', 'Email is required');
                    isValid = false;
                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                    showError('doctorEmail', 'Enter a valid email');
                    isValid = false;
                }

                if (!phone) {
                    showError('doctorPhone', 'Phone Number is required');
                    isValid = false;
                } else if (phone.length !== 10) {
                    showError('doctorPhone', 'Phone must be exactly 10 digits');
                    isValid = false;
                }

                if (!hospitalName) {
                    showError('hospitalName', 'Hospital name is required');
                    isValid = false;
                }
                if (!doctorType) {
                    showError('doctorType', 'Doctor type is required');
                    isValid = false;
                }
                if (!address) {
                    showError('address', 'Address is required');
                    isValid = false;
                }
                if (!qualification) {
                    showError('qualification', 'Qualification is required');
                    isValid = false;
                }
                if (!medicalReg) {
                    showError('medicalCouncilRegNumber', 'Medical Council Registration Number is required');
                    isValid = false;
                }
                if (!state) {
                    showError('state', 'State is required');
                    isValid = false;
                }

                // Password validation only if user enters new password
                if (password) {
                    if (password.length < 8) {
                        showError('doctorPassword', 'Password must be at least 8 characters');
                        isValid = false;
                    }
                    if (password !== passwordConfirm) {
                        showError('doctorPasswordConfirm', 'Passwords do not match');
                        isValid = false;
                    }
                }

                return isValid;
            }

            function showError(fieldId, message) {
                const errorEl = document.getElementById(fieldId + 'Error');
                const inputEl = document.getElementById(fieldId);
                errorEl.textContent = message;
                errorEl.style.display = 'block';

            }
        </script>
    </x-slot>
</x-base-layout>
