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
       <style>
    /* Filter section styling */
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
        align-items: flex-start; /* Always align to top */
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .btn-search {
        white-space: nowrap;
        min-width: 120px;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        height: 48px;
        margin-top: 24px; /* This aligns the button with the input field */
    }

    /* Remove the has-error class since we're always top-aligned */
</style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0"style="
    margin-right: 10px;
">Add Appointment</h4>
                            @if(request()->has('from'))
                                @php
                                    $from = request('from');
                                    $backRoute = $from === 'appointments' ? route('doctor.my-appointments') : route('doctor.patients.index');
                                    $backText = $from === 'appointments' ? 'Back to My Appointments' : 'Back to Patient List';
                                @endphp
                                <a href="{{ $backRoute }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ $backText }}
                                </a>
                            @endif
                        </div>

                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{session()->get('error')}}</div>
                        @endif

                        @if(session()->has('success'))
                            <div class="alert alert-success">{{session()->get('success')}}</div>
                        @endif

                         <!-- Mobile Number Search Form -->
                        <div class="filter-section">
                            <form id="searchPatientForm" novalidate>
                                @csrf
                                <div class="filter-row" id="searchFilterRow">
                                    <div class="filter-group">
                                        <label for="mobile_number" class="form-label small text-muted mb-1">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                               placeholder="Enter patient's mobile number">
                                        <div class="invalid-feedback" id="mobile_error"></div>
                                    </div>
                                    <div class="filter-group" style="flex: 0 0 auto;">
                                        <label class="form-label small text-muted mb-1" style="visibility: hidden;">Action</label>
                                        <button type="submit" class="btn btn-primary btn-search">
                                            <i class="fas fa-search me-2"></i>Search Patient
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Search Results -->
                        <div id="searchResults" class="mt-4" style="display: none;">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Your Patients Found</h5>
                                    <p class="text-muted mb-0">Showing only patients created by you</p>
                                </div>
                                <div class="card-body">
                                    <div id="searchResultsContent">
                                        <!-- Results will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- No Results Message -->
                        <div id="noResults" class="mt-4" style="display: none;">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-user-plus fa-3x text-muted"></i>
                                    </div>
                                    <h5>No patients found with this mobile number</h5>
                                    <p class="text-muted">You don't have any patients with this mobile number. You can add this number as a new patient.</p>
                                    <button type="button" class="btn btn-primary" id="addNewPatientBtn">
                                        <i class="fas fa-plus me-2"></i>Add New Patient
                                    </button>
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
        <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>

        <script>
             $(document).ready(function() {
        // Restrict mobile number input to digits only
        $('#mobile_number').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Search patient form submission
        $('#searchPatientForm').on('submit', function(e) {
            e.preventDefault();

            const mobileNumber = $('#mobile_number').val().trim();
            if (!mobileNumber) {
                $('#mobile_number').addClass('is-invalid');
                $('#mobile_error').text('Mobile number is required.');
                return;
            }

            // Validate mobile number format (exactly 10 digits, only numbers)
            if (!/^\d{10}$/.test(mobileNumber)) {
                $('#mobile_number').addClass('is-invalid');
                $('#mobile_error').text('Mobile number must be exactly 10 digits.');
                return;
            }

            // Clear previous errors
            $('#mobile_number').removeClass('is-invalid');
            $('#mobile_error').text('');

            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Searching...');

            $.ajax({
                url: '{{ route("doctor.patients.search") }}',
                type: 'POST',
                data: {
                    mobile_number: mobileNumber,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        displaySearchResults(response.patients, mobileNumber);
                    } else {
                        showNoResults(mobileNumber);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.mobile_number) {
                            $('#mobile_number').addClass('is-invalid');
                            $('#mobile_error').text(errors.mobile_number[0]);
                        }
                    } else {
                        Snackbar.show({
                            text: 'An error occurred while searching. Please try again.',
                            pos: 'top-right',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Add new patient button
        $('#addNewPatientBtn').on('click', function() {
            const mobileNumber = $('#mobile_number').val().trim();
            window.location.href = '{{ route("doctor.patients.add-patient") }}?mobile_number=' + encodeURIComponent(mobileNumber);
        });
    });

            function displaySearchResults(patients, mobileNumber) {
                let html = '<div class="table-responsive"><table class="table table-striped">';
                html += '<thead><tr><th>Name</th><th>Mobile</th><th>SSSP ID</th><th>Last Visit</th><th>Actions</th></tr></thead>';
                html += '<tbody>';

                patients.forEach(function(patient) {
                    const lastAppointment = patient.appointments && patient.appointments.length > 0
                        ? new Date(patient.appointments[0].visit_date_time).toLocaleDateString()
                        : 'No visits';

                    html += '<tr>';
                    html += '<td>' + patient.name + '</td>';
                    html += '<td>' + patient.mobile_number + '</td>';
                    html += '<td>' + patient.sssp_id + '</td>';
                    html += '<td>' + lastAppointment + '</td>';
                    html += '<td>';
                    html += '<a href="{{ route("doctor.patients.add-appointment-existing") }}?patient_id=' + patient.id + '" class="btn btn-sm btn-primary me-2">';
                    html += '<i class="fas fa-plus me-1"></i>Add Appointment</a>';
                    html += '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table></div>';

                // Check if we can add more patients (max 3 per mobile number per doctor)
                const baseMobile = mobileNumber.replace(/_[ABC]$/, '');
                const existingCount = patients.filter(p => p.mobile_number.startsWith(baseMobile)).length;

                if (existingCount < 3) {
                    html += '<div class="mt-3 text-center">';
                    html += '<button type="button" class="btn btn-outline-primary" onclick="addNewPatient(\'' + baseMobile + '\')">';
                    html += '<i class="fas fa-plus me-2"></i>Add New Patient';
                    html += '</button>';
                    html += '<p class="text-muted mt-2">You can create up to 3 patients with the same mobile number</p>';
                    html += '</div>';
                } else {
                    html += '<div class="mt-3 text-center">';
                    html += '<p class="text-muted">You have reached the maximum limit of 3 patients for this mobile number</p>';
                    html += '</div>';
                }

                $('#searchResultsContent').html(html);
                $('#searchResults').show();
                $('#noResults').hide();
            }

            function showNoResults(mobileNumber) {
                $('#searchResults').hide();
                $('#noResults').show();
                $('#addNewPatientBtn').off('click').on('click', function() {
                    window.location.href = '{{ route("doctor.patients.add-patient") }}?mobile_number=' + encodeURIComponent(mobileNumber);
                });
            }

            function addNewPatient(mobileNumber) {
                window.location.href = '{{ route("doctor.patients.add-patient") }}?mobile_number=' + encodeURIComponent(mobileNumber);
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
