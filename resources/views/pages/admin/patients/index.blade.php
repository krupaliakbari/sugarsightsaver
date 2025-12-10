<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Patient Management - Admin
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
        <style>
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

            /* Table responsive improvements */
            @media (max-width: 1200px) {

                .table th,
                .table td {
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

                .table th,
                .table td {
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
            }

            /* Pagination styling */
            .pagination {
                margin-bottom: 0;
            }

            .pagination .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                line-height: 1.5;
                color: #4361ee;
                background-color: #fff;
                border: 1px solid #dee2e6;
            }

            .pagination .page-link:hover {
                color: #2c3fb1;
                background-color: #e9ecef;
                border-color: #dee2e6;
            }

            .pagination .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #4361ee;
                border-color: #4361ee;
            }

            .pagination .page-item.disabled .page-link {
                color: #6c757d;
                pointer-events: none;
                cursor: auto;
                background-color: #fff;
                border-color: #dee2e6;
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
                                <h4 class="mb-0">Patient Management</h4>
                                <div class="d-flex flex-wrap gap-2">
                                   
                                    @if (request()->hasAny(['search', 'doctor_id', 'sex', 'age','sort_by','sort_direction']))
                                     
                                        <a href="{{ route('admin.patients.export.filtered') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                                            class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-download me-1">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7,10 12,15 17,10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3">
                                                </line>
                                            </svg>
                                            Export Patients
                                        </a>
                                    @else
                                        <a href="{{ route('admin.patients.export') }}" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-download me-1">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7,10 12,15 17,10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3">
                                                </line>
                                            </svg>
                                            Export Patients
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Filter Form -->
                            <div class="filter-section">
                                <form method="GET" action="{{ route('admin.patients.index') }}">
                                    <div class="filter-row">
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Search</label>
                                            <input type="text" class="form-control" name="search"
                                                placeholder="Search by name, mobile, email, SSSP ID..."
                                                value="{{ request('search') }}">
                                        </div>
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Doctor</label>
                                            <select class="form-select" name="doctor_id">
                                                <option value="">All Doctors</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                        {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                        {{ $doctor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Gender</label>
                                            <select class="form-select" name="sex">
                                                <option value="">All Genders</option>
                                                <option value="male"
                                                    {{ request('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female"
                                                    {{ request('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Age</label>
                                            <input type="number" class="form-control" name="age" placeholder="Age"
                                                value="{{ request('age') }}">
                                        </div>
                                        <div class="filter-buttons">
                                            <button type="submit" class="btn btn-primary btn-filter">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-search me-1">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="M21 21l-4.35-4.35"></path>
                                                </svg>
                                                Search
                                            </button>
                                            @if (request()->hasAny(['search', 'doctor_id', 'sex', 'age']))
                                                <a href="{{ route('admin.patients.index') }}"
                                                    class="btn btn-outline-secondary btn-clear">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-x me-1">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg>
                                                    Clear
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="patients-table-container">
                                @if (session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        {{ session()->get('error') }}
                                    </div>
                                @endif

                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        {{ session()->get('success') }}
                                    </div>
                                @endif

                                @if ($patients->count() > 0)
                                    @php
                                        $sortBy = request('sort_by', 'created_at');
                                        $sortDirection = request('sort_direction', 'desc');

                                        function getSortUrl($column, $currentSortBy, $currentDirection)
                                        {
                                            $direction = 'asc';
                                            if ($column === $currentSortBy) {
                                                $direction = $currentDirection === 'asc' ? 'desc' : 'asc';
                                            }

                                            $params = array_merge(request()->all(), [
                                                'sort_by' => $column,
                                                'sort_direction' => $direction,
                                            ]);
                                            unset($params['page']);

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
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'name' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'name' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="mobile_number">
                                                        Contact
                                                        <span class="sort-arrows">
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'mobile_number' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'mobile_number' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="sssp_id">
                                                        SSSP ID
                                                        <span class="sort-arrows">
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'sssp_id' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'sssp_id' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th>Hospital & Doctor</th>
                                                    <th class="sortable-header" data-sort-column="age">
                                                        Age & Gender
                                                        <span class="sort-arrows">
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'age' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'age' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="last_visit">
                                                        Last Visit
                                                        <span class="sort-arrows">
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'last_visit' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'last_visit' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th class="sortable-header" data-sort-column="total_appointments">
                                                        Total Appointments
                                                        <span class="sort-arrows">
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'total_appointments' && $sortDirection === 'asc' ? 'active' : '' }}">▲</span>
                                                            <span
                                                                class="sort-arrow {{ $sortBy === 'total_appointments' && $sortDirection === 'desc' ? 'active' : '' }}">▼</span>
                                                        </span>
                                                    </th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($patients as $patient)
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                <h6 class="mb-0">{{ $patient->name }}</h6>
                                                                <small
                                                                    class="text-muted">{{ $patient->email ?? 'No email' }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p class="mb-0">{{ $patient->mobile_number }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($patient->sssp_id)
                                                                <span
                                                                    class="badge bg-info">{{ $patient->sssp_id }}</span>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p class="mb-0 text-truncate"
                                                                    style="max-width: 200px;"
                                                                    title="{{ $patient->createdByDoctor->hospital_name ?? 'Not specified' }}">
                                                                    {{ $patient->createdByDoctor->hospital_name ?? 'Not specified' }}
                                                                </p>
                                                                <small
                                                                    class="text-muted">{{ $patient->createdByDoctor->name ?? 'Unknown Doctor' }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <span class="text-primary">{{ $patient->age }}
                                                                    years</span>
                                                                <br>
                                                                <small
                                                                    class="text-muted">{{ ucfirst($patient->sex) }}</small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($patient->appointments->count() > 0)
                                                                <span
                                                                    class="text-success">{{ $patient->appointments->sortByDesc('visit_date_time')->first()->visit_date_time->format('M d, Y') }}</span>
                                                            @else
                                                                <span class="text-muted">No visits</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-primary">{{ $patient->appointments->count() }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('admin.patients.show', $patient->id) }}"
                                                                    class="btn btn-sm btn-info" title="View Details"
                                                                    style="padding: 0.375rem 0.5rem;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path
                                                                            d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                        </path>
                                                                        <circle cx="12" cy="12" r="3">
                                                                        </circle>
                                                                    </svg>
                                                                </a>



                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    style="padding: 0.375rem 0.5rem;"
                                                                    title="Delete Patient"
                                                                    onclick="confirmDeletePatient({{ $patient->id }})">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                        </path>
                                                                        <line x1="10" y1="11"
                                                                            x2="10" y2="17"></line>
                                                                        <line x1="14" y1="11"
                                                                            x2="14" y2="17"></line>
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
                                    @if ($patients->hasPages())
                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <div class="text-muted">
                                                Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of
                                                {{ $patients->total() }} patients
                                            </div>
                                            <div>
                                                {{ $patients->links('pagination::bootstrap-4') }}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <h5 class="text-muted">No patients found</h5>
                                            <p class="text-muted">No patients match your current filters.</p>
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
        <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Auto-dismiss alert messages after 5 seconds
                const alerts = document.querySelectorAll('.alert-success, .alert-danger');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        $(alert).fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000);
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

                            const currentSortBy = params.get('sort_by') || 'created_at';
                            const currentDirection = params.get('sort_direction') || 'desc';

                            let newDirection = 'asc';
                            if (column === currentSortBy) {
                                newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
                            }

                            params.set('sort_by', column);
                            params.set('sort_direction', newDirection);
                            params.delete('page');

                            const ajaxUrl = '{{ route('admin.patients.index') }}?' + params.toString();

                            const container = document.getElementById('patients-table-container');
                            container.style.opacity = '0.5';
                            container.style.pointerEvents = 'none';

                            fetch(ajaxUrl, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newContent = doc.getElementById(
                                        'patients-table-container');

                                    if (newContent) {
                                        container.innerHTML = newContent.innerHTML;
                                        container.style.opacity = '1';
                                        container.style.pointerEvents = 'auto';

                                        const newUrl = currentUrl.pathname + '?' + params
                                    .toString();
                                        window.history.pushState({}, '', newUrl);

                                        setupAjaxSorting();
                                    }
                                    window.location.reload();
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    container.style.opacity = '1';
                                    container.style.pointerEvents = 'auto';
                                });
                        });
                    });
                }

                setupAjaxSorting();
            });



            function confirmDeletePatient(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will permanently delete the patient and ALL their medical records, appointments, and reports!",
                    icon: 'warning',
                    showCancelButton: true,

                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create form dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';

                        // This is the key fix: correctly generate URL with ID
                        form.action = '{{ route('admin.patients.delete', ':id') }}'.replace(':id', id);

                        form.style.display = 'none';

                        // CSRF Token
                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = '{{ csrf_token() }}';
                        form.appendChild(token);

                        // Method Spoofing (Laravel expects DELETE)
                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
