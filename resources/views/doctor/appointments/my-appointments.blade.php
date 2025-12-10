<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        <style>
            /* Pagination Styles */
.pagination {
    margin-bottom: 0;
    flex-wrap: wrap;
}

.page-link {
    color: #4361ee;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.page-item.active .page-link {
    background-color: #4361ee;
    border-color: #4361ee;
    color: white;
}

.page-link:hover {
    color: #4361ee;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Responsive pagination */
@media (max-width: 576px) {
    .pagination {
        justify-content: center;
    }

    .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.8rem;
    }

    .d-flex.justify-content-between.align-items-center.mt-4 {
        flex-direction: column;
        text-align: center;
        gap: 1rem !important;
    }

    .text-muted {
        order: 2;
    }

    nav {
        order: 1;
    }
}
            .table-responsive {
                overflow-x: auto;
            }
            .table td {
                white-space: nowrap;
                vertical-align: middle;
            }
            .table td:first-child {
                white-space: normal;
            }
            .avatar img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover;
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

            /* Filter section */
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
                flex-wrap: wrap;
            }

            .btn-filter {
                white-space: nowrap;
                min-width: 80px;
                font-size: 1rem;
                padding: 0.75rem 1rem;
                height: 48px;
            }

            .btn-clear {
                white-space: nowrap;
                min-width: 70px;
                font-size: 1rem;
                padding: 0.75rem 1rem;
                height: 48px;
            }

            /* Button text protection */
            .btn {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .btn-sm {
                font-size: 0.8rem;
                padding: 0.375rem 0.75rem;
            }

            /* Action buttons */
            .action-buttons {
                display: flex;
                gap: 0.25rem;
                flex-wrap: nowrap;
            }

            @media (max-width: 1200px) {
                .table th, .table td {
                    padding: 0.5rem;
                    font-size: 0.875rem;
                }

                .btn-sm {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.75rem;
                }
            }

            @media (max-width: 992px) {
                .filter-row {
                    flex-direction: column;
                    align-items: stretch;
                }

                .filter-group {
                    min-width: 100%;
                }

                .filter-buttons {
                    justify-content: center;
                }
            }
             @media (max-width: 768px) {
                 .btn-responsive{
                     white-space: wrap !important;
                     width: 131px;
                 }
             }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
        <!-- Start Row -->
        <div class="row mt-3" style="margin-left: 0; margin-right: 0;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding-left: 0; padding-right: 0;">
                <div class="widget-content widget-content-area br-8">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">My Appointments</h4>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('doctor.patients.add-appointment', ['from' => 'appointments']) }}" class="btn btn-primary btn-responsive">
                                        New Appointment
                                    </a>
                                </div>
                            </div>

                            <!-- Filter Form -->
                            <div class="filter-section">
                                <form method="GET" action="{{ route('doctor.my-appointments') }}">
                                    <div class="filter-row">
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Search</label>
                                            <input type="text" class="form-control" name="search" placeholder="Search by name, mobile, email..." value="{{ request('search') }}">
                                        </div>
                                        <div class="filter-group">
    <label class="form-label small text-muted mb-1">Date</label>
    <input type="text" class="form-control" id="appointment_date" name="appointment_date"
           placeholder="Select Date" value="{{ request('appointment_date') }}">
</div>

                                        <div class="filter-buttons">
                                            <button type="submit" class="btn btn-primary btn-filter">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-1">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="M21 21l-4.35-4.35"></path>
                                                </svg>
                                                Search
                                            </button>
                                            @if(request()->hasAny(['search', 'appointment_date']))
                                                <a href="{{ route('doctor.my-appointments') }}" class="btn btn-outline-secondary btn-clear">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-1">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    Clear
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="appointments-table-container">
                                @if(session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        {{session()->get('error')}}
                                    </div>
                                @endif

                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        {{session()->get('success')}}
                                    </div>
                                @endif

                                @if($appointments->count() > 0)
                                    @php
                                        $sortBy = request('sort_by', 'visit_date_time');
                                        $sortDirection = request('sort_direction', 'desc');

                                        function getSortUrl($column, $currentSortBy, $currentDirection) {
                                            $direction = 'asc';
                                            if ($column === $currentSortBy) {
                                                $direction = $currentDirection === 'asc' ? 'desc' : 'asc';
                                            }

                                            $params = array_merge(request()->all(), [
                                                'sort_by' => $column,
                                                'sort_direction' => $direction
                                            ]);
                                            unset($params['page']);

                                            return request()->url() . '?' . http_build_query($params);
                                        }
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sortable-header" data-sort-column="visit_date_time">
                                                        Date
                                                        <span class="sort-arrows">
                                                            <span class="sort-arrow {{ $sortBy === 'visit_date_time' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span class="sort-arrow {{ $sortBy === 'visit_date_time' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="name">
                                                        Patient
                                                        <span class="sort-arrows">
                                                            <span class="sort-arrow {{ $sortBy === 'name' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span class="sort-arrow {{ $sortBy === 'name' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="mobile_number">
                                                        Contact
                                                        <span class="sort-arrows">
                                                            <span class="sort-arrow {{ $sortBy === 'mobile_number' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span class="sort-arrow {{ $sortBy === 'mobile_number' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="sssp_id">
                                                        SSSP ID
                                                        <span class="sort-arrows">
                                                            <span class="sort-arrow {{ $sortBy === 'sssp_id' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span class="sort-arrow {{ $sortBy === 'sssp_id' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    @if(Auth::user()->doctor_type === 'ophthalmologist')
                                                        <th>Diabetic Retinopathy (DR)</th>
                                                        <th>Diabetic Macular Edema (DME)</th>
                                                    @else
                                                        <th>Retinopathy</th>
                                                    @endif
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appointments as $appointment)
                                                    @php
                                                        $medicalRecord = $appointment->medicalRecords->first();
                                                        $physicianRecord = $medicalRecord ? $medicalRecord->physicianRecord : null;
                                                        $ophthalmologistRecord = $medicalRecord ? $medicalRecord->ophthalmologistRecord : null;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <span class="text-success">{{ $appointment->visit_date_time->format('M d, Y') }}</span>
                                                            <br>
                                                            <small class="text-muted">{{ $appointment->visit_date_time->format('h:i A') }}</small>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <h6 class="mb-0">{{ $appointment->patient_name_snapshot }}</h6>
                                                                <small class="text-muted">{{ $appointment->patient_email_snapshot ?? 'No email' }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p class="mb-0">{{ $appointment->patient_mobile_number_snapshot }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($appointment->patient_sssp_id_snapshot)
                                                                <span class="badge bg-info">{{ $appointment->patient_sssp_id_snapshot }}</span>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>

                                                        @if(Auth::user()->doctor_type === 'ophthalmologist')
                                                            <td>
                                                                @if($ophthalmologistRecord)
                                                                    <span class="badge {{ $ophthalmologistRecord->diabetic_retinopathy ? 'bg-success' : 'bg-danger' }}">
                                                                        {{ $ophthalmologistRecord->diabetic_retinopathy ? 'Yes' : 'No' }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($ophthalmologistRecord)
                                                                    <span class="badge {{ $ophthalmologistRecord->diabetic_macular_edema ? 'bg-success' : 'bg-danger' }}">
                                                                        {{ $ophthalmologistRecord->diabetic_macular_edema ? 'Yes' : 'No' }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td>
                                                                @if($physicianRecord && $physicianRecord->retinopathy)
                                                                    {{ $physicianRecord->formatted_retinopathy }}
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                        @endif

                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                @if($medicalRecord)
                                                                    <button type="button" class="btn btn-sm btn-info" title="View Summary" onclick="viewSummary({{ $medicalRecord->id }})" style="padding: 0.375rem 0.5rem;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                        </svg>
                                                                    </button>
                                                                @endif

                                                                <button type="button" class="btn btn-sm btn-warning" title="Edit Appointment" onclick="editAppointment({{ $appointment->id }})" style="padding: 0.375rem 0.5rem;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                    </svg>
                                                                </button>



                                                                <!-- Hidden delete form -->
                                                                <form id="delete-appointment-form-{{ $appointment->id }}"
                                                                      action="{{ route('doctor.patients.appointments.delete', $appointment->id) }}"
                                                                      method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->




                                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
    <div class="text-muted">
        Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
    </div>

    <!-- Custom Pagination Styling -->
    @if($appointments->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if($appointments->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $appointments->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
                    @if($page == $appointments->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($appointments->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $appointments->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>




                                @else
                                    <div class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <h5 class="text-muted">No appointments found</h5>
                                            <p class="text-muted">No appointments match your current filters.</p>
                                        </div>
                                    </div>
                                @endif
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
        <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>

        <script>
            // Initialize Flatpickr for date inputs
   flatpickr("#appointment_date", {
    mode: "single",
    dateFormat: "d-m-Y",
    allowInput: true,
});

            // Sort table function
            document.querySelectorAll('.sortable-header').forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.getAttribute('data-sort-column');
                    const url = new URL(window.location.href);
                    const currentSort = url.searchParams.get('sort_by');
                    const currentDirection = url.searchParams.get('sort_direction') || 'desc';

                    url.searchParams.set('sort_by', column);

                    if (currentSort === column) {
                        url.searchParams.set('sort_direction', currentDirection === 'asc' ? 'desc' : 'asc');
                    } else {
                        url.searchParams.set('sort_direction', 'desc');
                    }

                    window.location.href = url.toString();
                });
            });

            // View summary function
            function viewSummary(medicalRecordId) {
                window.location.href = '{{ url("doctor/medical/summary") }}/' + medicalRecordId;
            }

            // Edit appointment function
            function editAppointment(appointmentId) {
                window.location.href = '{{ url("doctor/patients/appointments") }}/' + appointmentId + '/edit';
            }

            // Delete appointment function
            function confirmDeleteAppointment(appointmentId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this appointment?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-appointment-form-' + appointmentId).submit();
                    }
                });
            }

            // Show success/error messages
            @if(session('success'))
                Snackbar.show({
                    text: "{{ session('success') }}",
                    actionTextColor: '#fff',
                    backgroundColor: '#00ab55',
                    pos: 'top-right',
                    duration: 3000
                });
            @endif

            @if(session('error'))
                Snackbar.show({
                    text: "{{ session('error') }}",
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-right',
                    duration: 3000
                });
            @endif
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
