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

            /* Responsive filter improvements */
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

            /* Table responsive improvements */
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
                    /* flex-direction: column; */
                    align-items: stretch;
                }

                .filter-group {
                    min-width: 100%;
                }

                .filter-buttons {
                    justify-content: center;
                }

                .table th, .table td {
                    padding: 0.375rem;
                    font-size: 0.8rem;
                }

                .btn-sm {
                    padding: 0.2rem 0.4rem;
                    font-size: 0.7rem;
                }

                .d-flex.gap-1 {
                    /* flex-direction: column; */
                    gap: 0.25rem !important;
                }
            }

            @media (max-width: 768px) {
                .filter-section {
                    padding: 1rem;
                }

                .table-responsive {
                    font-size: 0.8rem;
                }

                .btn-sm {
                    padding: 0.15rem 0.3rem;
                    font-size: 0.65rem;
                }

                .avatar {
                    width: 30px !important;
                    height: 30px !important;
                }

                .badge {
                    font-size: 0.65rem;
                }
            }

            /* Action buttons responsive */
            .action-buttons {
                display: flex;
                gap: 0.25rem;
                flex-wrap: wrap;
            }

            @media (max-width: 576px) {
                .action-buttons {
                    flex-direction: column;
                }

                .btn-sm {
                    width: 100%;
                    margin-bottom: 0.25rem;
                }
            }

            /* Dropdown improvements */
            .dropdown-menu {
                min-width: 120px;
            }

            .dropdown-item {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            /* Status toggle improvements */
            .form-check-label {
                font-size: 0.8rem;
                margin-left: 0.5rem;
            }

            @media (max-width: 768px) {
                .form-check-label {
                    font-size: 0.7rem;
                    margin-left: 0.25rem;
                }
                 .col-md-3 {
        margin-top: 5px;
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
    <h4 class="mb-0">My Patients</h4>

    <div class="d-flex flex-wrap gap-2 flex-sm-row flex-column align-items-sm-center">
        <a href="{{ route('doctor.export.patients') }}?{{ http_build_query(request()->query()) }}"
           class="btn btn-success {{ $patients->count() == 0 ? 'disabled' : '' }}"
           @if($patients->count() == 0) onclick="return false;" @endif>
            Export Patients
        </a>

        <a href="{{ route('doctor.patients.add-appointment', ['from' => 'patients']) }}" class="btn btn-primary">
            New Appointment
        </a>
    </div>
</div>

                          <!-- Filter Form -->
<div class="filter-section">
    <form method="GET" action="{{ route('doctor.patients.index') }}">
        <div class="filter-row">
            <div class="filter-group">
                <label class="form-label small text-muted mb-1">Search</label>
                <input type="text" class="form-control" name="search" placeholder="Search by name, mobile, email..." value="{{ request('search') }}">
            </div>

            <div class="filter-group">
                <label class="form-label small text-muted mb-1">Age</label>
                <input type="number" class="form-control" name="age" placeholder="Age" value="{{ request('age') }}">
            </div>
            
           <div class="filter-group">
    <label class="form-label small text-muted mb-1">Last Visit</label>
    <input type="text" class="form-control" id="last_visit_date" name="last_visit_date" 
       placeholder="Select Date" 
       value="{{ request('last_visit_date') }}">
</div>
            
            <div class="filter-buttons">
                <button type="submit" class="btn btn-primary btn-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-1">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                    Search
                </button>
                @if(request()->hasAny(['search', 'age', 'last_visit_date']))
                    <a href="{{ route('doctor.patients.index') }}" class="btn btn-outline-secondary btn-clear">
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

                            <div id="patients-table-container">
                            @if(session()->has('error'))
                                <div class="alert alert-danger">{{session()->get('error')}}</div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success">{{session()->get('success')}}</div>
                            @endif

                            @if($patients->count() > 0)
                                @php
                                    $sortBy = request('sort_by', 'created_at');
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
                                        unset($params['page']); // Reset to first page when sorting

                                        return request()->url() . '?' . http_build_query($params);
                                    }
                                @endphp
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
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
                                                <th class="sortable-header" data-sort-column="age">
                                                    Age & Gender
                                                    <span class="sort-arrows">
                                                        <span class="sort-arrow {{ $sortBy === 'age' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                        <span class="sort-arrow {{ $sortBy === 'age' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                    </span>
                                                </th>
                                                <th class="sortable-header" data-sort-column="last_visit">
                                                    Last Visit
                                                    <span class="sort-arrows">
                                                        <span class="sort-arrow {{ $sortBy === 'last_visit' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                        <span class="sort-arrow {{ $sortBy === 'last_visit' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                    </span>
                                                </th>
                                                <th class="sortable-header" data-sort-column="total_appointments">
                                                    Total Appointments
                                                    <span class="sort-arrows">
                                                        <span class="sort-arrow {{ $sortBy === 'total_appointments' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                        <span class="sort-arrow {{ $sortBy === 'total_appointments' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                    </span>
                                                </th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patients as $patient)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-0">{{ $patient->name }}</h6>
                                                            <small class="text-muted">{{ $patient->email ?? 'No email' }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p class="mb-0">{{ $patient->mobile_number }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $patient->sssp_id }}</span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="text-primary">{{ $patient->age }} years</span>
                                                            <br>
                                                            <small class="text-muted">{{ ucfirst($patient->sex) }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($patient->appointments->count() > 0)
                                                            <span class="text-success">{{ $patient->appointments->sortByDesc('visit_date_time')->first()->visit_date_time->format('M d, Y') }}</span>
                                                        @else
                                                            <span class="text-muted">No visits</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $patient->appointments->count() }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('doctor.patients.add-appointment-existing') }}?patient_id={{ $patient->id }}&from=patients"
                                                            class="btn btn-sm btn-primary" title="Add Appointment" style="padding: 0.375rem 0.5rem;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                                    <polyline points="7 3 7 8 15 8"></polyline>
                                                                </svg>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-info" title="View Appointment Summary" onclick="viewPatientDetails({{ $patient->id }})" style="padding: 0.375rem 0.5rem;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                </svg>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-warning" title="Edit Patient" onclick="editPatient({{ $patient->id }})" style="padding: 0.375rem 0.5rem;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                </svg>
                                                            </button>

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
        Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} patients
    </div>

    <!-- Custom Pagination Styling -->
    @if($patients->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if($patients->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $patients->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach($patients->getUrlRange(1, $patients->lastPage()) as $page => $url)
                    @if($page == $patients->currentPage())
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
                @if($patients->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $patients->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
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
                                        <h5 class="text-muted">No patients found</h5>
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
          // Initialize Flatpickr for last visit date filter with proper range selection
  flatpickr("#last_visit_date", {
    mode: "single",
    dateFormat: "d-m-Y",
    allowInput: true,
    
});
     // Initialize Flatpickr for last visit date filter
            const urlParams = new URLSearchParams(window.location.search);
        const hasFilterParams = urlParams.has('search') || urlParams.has('age') || urlParams.has('last_visit_date');
        
        // You can use hasFilterParams for any conditional logic you need
        if (hasFilterParams) {
            // Example: Scroll to table or show loading state
            console.log('Filters are active');
        }

            $(document).ready(function() {
                // Auto-dismiss alert messages after 5 seconds
                const alerts = document.querySelectorAll('.alert-success, .alert-danger');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        $(alert).fadeOut('slow', function() {
                            $(this).remove();
                        });
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
                            const currentSortBy = params.get('sort_by') || 'created_at';
                            const currentDirection = params.get('sort_direction') || 'desc';

                            // Toggle direction
                            let newDirection = 'asc';
                            if (column === currentSortBy) {
                                newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                            }

                            // Update params
                            params.set('sort_by', column);
                            params.set('sort_direction', newDirection);
                            params.delete('page'); // Reset to first page

                            // Build URL
                            const ajaxUrl = '{{ route("doctor.patients.index") }}?' + params.toString();

                            // Show loading state
                            const container = document.getElementById('patients-table-container');
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
                                const newContent = doc.getElementById('patients-table-container');

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
                                    window.location.reload();
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
            });

            function viewPatientDetails(patientId) {
                // Redirect to patient's latest medical record summary
                window.location.href = `/doctor/patients/${patientId}/medical-records`;
            }

            function editPatient(patientId) {
                // Redirect to patient edit form
                window.location.href = `/doctor/patients/${patientId}/edit`;
            }

            function confirmDeletePatient(patientId, patientName) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: `This will permanently delete patient "${patientName}" and all associated appointments and medical records. You won't be able to revert this!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form to submit the delete request
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("doctor.patients.delete", ":id") }}'.replace(':id', patientId);

                        // Add CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        // Add method override
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
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
