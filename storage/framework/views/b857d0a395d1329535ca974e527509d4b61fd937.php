<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base-layout','data' => ['scrollspy' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['scrollspy' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>

     <?php $__env->slot('pageTitle', null, []); ?> 
        <?php echo e($title); ?>

     <?php $__env->endSlot(); ?>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
     <?php $__env->slot('headerFiles', null, []); ?> 
        <link rel="stylesheet" href="<?php echo e(asset('plugins/notification/snackbar/snackbar.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.css')); ?>">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/components/tabs.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/elements/alert.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss']); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    flex-direction: column;
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
             @media (max-width: 1400px) {
    .avatar, 
    .avatar-sm,
    .avatar img,
    .bg-primary.rounded-circle {
        width: 30px !important;
        height: 30px !important;
        min-width: 30px !important;
        min-height: 30px !important;
    }
    
    .avatar .bg-primary.rounded-circle {
        width: 100% !important;
        height: 100% !important;
    }
}
        </style>
     <?php $__env->endSlot(); ?>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
        <!-- Start Row -->
        <div class="row mt-3" style="margin-left: 0; margin-right: 0;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding-left: 0; padding-right: 0;">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Doctor Management</h4>
                                <div class="d-flex flex-wrap gap-2">
                            
                                </div>
                        </div>

                            <!-- Filter Form -->
                            <div class="filter-section">
                            <form method="GET" action="<?php echo e(route('user-management')); ?>">
                                    <div class="filter-row">
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Search</label>
                                            <input type="text" class="form-control" name="search" placeholder="Search by name, email, phone..." value="<?php echo e(request('search')); ?>">
                                    </div>
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="">All Status</option>
                                                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                                                <option value="deactive" <?php echo e(request('status') == 'deactive' ? 'selected' : ''); ?>>Deactive</option>
                                        </select>
                                    </div>
                                        
                                        <div class="filter-group">
                                            <label class="form-label small text-muted mb-1">Doctor Type</label>
                                        <select class="form-select" name="doctor_type">
                                            <option value="">All Types</option>
                                                <option value="diabetes_treating" <?php echo e(request('doctor_type') == 'diabetes_treating' ? 'selected' : ''); ?>>Diabetes Treating</option>
                                                <option value="ophthalmologist" <?php echo e(request('doctor_type') == 'ophthalmologist' ? 'selected' : ''); ?>>Ophthalmologist</option>
                                        </select>
                                    </div>
                                        <div class="filter-buttons">
                                            <button type="submit" class="btn btn-primary btn-filter">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search me-1">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="M21 21l-4.35-4.35"></path>
                                                </svg>
                                                Search
                                            </button>
                                            <?php if(request()->hasAny(['search', 'status', 'approval_status', 'doctor_type'])): ?>
                                                <a href="<?php echo e(route('user-management')); ?>" class="btn btn-outline-secondary btn-clear">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-1">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg>
                                                Clear
                                            </a>
                                            <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div id="doctors-table-container">
                            <?php if(session()->has('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <?php echo e(session()->get('error')); ?>

                                </div>
                            <?php endif; ?>

                            <?php if(session()->has('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <?php echo e(session()->get('success')); ?>

                                </div>
                            <?php endif; ?>

                            <?php if($doctors->count() > 0): ?>
                                <?php
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
                                        unset($params['page']);

                                        return request()->url() . '?' . http_build_query($params);
                                    }
                                ?>
                       <div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="sortable-header" data-sort-column="name">
                    Doctor
                    <span class="sort-arrows">
                        <span class="sort-arrow <?php echo e($sortBy === 'name' && $sortDirection === 'asc' ? 'active' : ''); ?>">▲</span>
                        <span class="sort-arrow <?php echo e($sortBy === 'name' && $sortDirection === 'desc' ? 'active' : ''); ?>">▼</span>
                    </span>
                </th>
                <th class="sortable-header" data-sort-column="email">
                    Contact
                    <span class="sort-arrows">
                        <span class="sort-arrow <?php echo e($sortBy === 'email' && $sortDirection === 'asc' ? 'active' : ''); ?>">▲</span>
                        <span class="sort-arrow <?php echo e($sortBy === 'email' && $sortDirection === 'desc' ? 'active' : ''); ?>">▼</span>
                    </span>
                </th>
                <th class="sortable-header" data-sort-column="hospital_name">
                    Hospital & Type
                    <span class="sort-arrows">
                        <span class="sort-arrow <?php echo e($sortBy === 'hospital_name' && $sortDirection === 'asc' ? 'active' : ''); ?>">▲</span>
                        <span class="sort-arrow <?php echo e($sortBy === 'hospital_name' && $sortDirection === 'desc' ? 'active' : ''); ?>">▼</span>
                    </span>
                </th>
                <th class="sortable-header" data-sort-column="status">
                    Status
                </th>
                <th class="sortable-header" data-sort-column="approval_status">
                    Approval
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3" style="width: 40px; height: 40px;">
                            <?php if($doctor->profile_image): ?>
                                <img src="<?php echo e(url($doctor->profile_image)); ?>" alt="avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; font-size: 16px; font-weight: bold;">
                                    <?php echo e(substr($doctor->name, 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h6 class="mb-0"><?php echo e($doctor->name ?? 'No Name'); ?></h6>
                            <small class="text-muted"><?php echo e($doctor->qualification ?? 'No qualification'); ?></small>
                        </div>
                    </div>
                </td>
                <td>
                    <div>
                        <p class="mb-0"><?php echo e($doctor->email ?? 'No email'); ?></p>
                        <small class="text-muted"><?php echo e($doctor->phone ?? 'No phone'); ?></small>
                    </div>
                </td>
                <td>
                    <div>
                        <p class="mb-0 text-truncate" style="max-width: 200px;" title="<?php echo e($doctor->hospital_name ?? ''); ?>">
                            <?php echo e($doctor->hospital_name ?? 'Not specified'); ?>

                        </p>
                        <?php if($doctor->doctor_type): ?>
                            <span class="badge badge-light-info badge-sm">
                                <?php echo e($doctor->doctor_type === 'diabetes_treating' ? 'Diabetes Treating' : 'Ophthalmologist'); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-muted small">Not specified</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle"
                               type="checkbox"
                               data-user-id="<?php echo e($doctor->id); ?>"
                               <?php echo e($doctor->status == 'active' ? 'checked' : ''); ?>>
                        <label class="form-check-label">
                            <?php echo e(ucfirst($doctor->status)); ?>

                        </label>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <?php if($doctor->approval_status == 'pending'): ?>
                            <span class="badge badge-light-warning">Pending</span>
                        <?php elseif($doctor->approval_status == 'approved'): ?>
                            <span class="badge badge-light-success">Approved</span>
                        <?php else: ?>
                            <span class="badge badge-light-danger">Rejected</span>
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('user-management.show', $doctor->id)); ?>" class="btn btn-sm btn-info" title="View Details" style="padding: 0.375rem 0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                        <button type="button" class="btn btn-sm btn-warning"
                                                                    title="Edit Doctor"
                                                                    onclick="window.location.href='<?php echo e(route('user-management.edit', $doctor->id)); ?>'"
                                                                    style="padding: 0.375rem 0.5rem;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="white" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path
                                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                        </path>
                                                                        <path
                                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                        </path>
                                                                    </svg>
                                                                </button>

                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    title="Delete Doctor"
                                                                    style="padding: 0.375rem 0.5rem;"
                                                                    onclick="confirmDeleteDoctor(<?php echo e($doctor->id); ?>)">
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

                        <!-- Pagination -->
                        <?php if($doctors->hasPages()): ?>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                            Showing <?php echo e($doctors->firstItem()); ?> to <?php echo e($doctors->lastItem()); ?> of <?php echo e($doctors->total()); ?> doctors
                            </div>
                            <div>
                                            <?php echo e($doctors->links('pagination::bootstrap-4')); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <h5 class="text-muted">No doctors found</h5>
                                        <p class="text-muted">No doctors match your current filters.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Rejection Reason Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectionModalLabel">Reject Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rejectionForm">
                        <input type="hidden" id="rejectUserId" name="user_id">
                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label">Rejection Reason</label>
                            <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="4" placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmRejection">Reject Doctor</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Approval Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">Bulk Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve all selected doctors?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmBulkApproval">Approve Selected</button>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
     <?php $__env->slot('footerFiles', null, []); ?> 
        <script src="<?php echo e(asset('plugins/notification/snackbar/snackbar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/sweetalerts2/sweetalerts2.min.js')); ?>"></script>

        <script>
            $(document).ready(function() {
                // CSRF token setup
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Auto-dismiss alert messages after 5 seconds
                const alerts = document.querySelectorAll('.alert-success, .alert-danger');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        $(alert).fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 5000);
                });

                // AJAX Sorting functionality - same as patients page
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

                            const ajaxUrl = '<?php echo e(route("user-management")); ?>?' + params.toString();

                            const container = document.getElementById('doctors-table-container');
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
                                const newContent = doc.getElementById('doctors-table-container');

                                if (newContent) {
                                    container.innerHTML = newContent.innerHTML;
                                    container.style.opacity = '1';
                                    container.style.pointerEvents = 'auto';

                                    const newUrl = currentUrl.pathname + '?' + params.toString();
                                    window.history.pushState({}, '', newUrl);

                                    setupAjaxSorting();

                                    // Reinitialize select all checkbox
                                    $('#selectAll').off('change').on('change', function() {
                                        $('.doctor-checkbox').prop('checked', $(this).is(':checked'));
                                    });

                                    // Reinitialize status toggles
                                    initializeStatusToggles();

                                    // Reinitialize approval actions
                                    initializeApprovalActions();
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

                setupAjaxSorting();

                // AJAX Pagination - handle pagination link clicks to preserve sort parameters
                $(document).on('click', '#doctors-table-container .pagination a', function(e) {
                    e.preventDefault();

                    const url = $(this).attr('href');
                    if (!url) return;

                    const container = document.getElementById('doctors-table-container');
                    if (!container) return;

                    container.style.opacity = '0.5';
                    container.style.pointerEvents = 'none';

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('doctors-table-container');

                        if (newContent) {
                            container.innerHTML = newContent.innerHTML;
                            container.style.opacity = '1';
                            container.style.pointerEvents = 'auto';

                            // Update URL without reload
                            window.history.pushState({}, '', url);

                            // Reinitialize sorting after pagination
                            setupAjaxSorting();

                            // Reinitialize select all checkbox
                            $('#selectAll').off('change').on('change', function() {
                                $('.doctor-checkbox').prop('checked', $(this).is(':checked'));
                            });

                            // Reinitialize status toggles
                            initializeStatusToggles();

                            // Reinitialize approval actions
                            initializeApprovalActions();

                            // Scroll to top of table
                            $('html, body').animate({
                                scrollTop: $('#doctors-table-container').offset().top - 100
                            }, 300);
                        } else {
                            console.error('Could not find doctors-table-container in response');
                            container.style.opacity = '1';
                            container.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        container.style.opacity = '1';
                        container.style.pointerEvents = 'auto';
                    });
                });

                // Initialize status toggles
                function initializeStatusToggles() {
                    $('.status-toggle').off('change').on('change', function() {
                    const userId = $(this).data('user-id');
                    const status = $(this).is(':checked') ? 'active' : 'deactive';
                    const $label = $(this).siblings('label');

                    $.ajax({
                        url: '<?php echo e(route("user-management.toggle-status")); ?>',
                        method: 'POST',
                        data: {
                            user_id: userId,
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                $label.text(response.new_status.charAt(0).toUpperCase() + response.new_status.slice(1));
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                // Revert toggle on error
                                $('.status-toggle[data-user-id="' + userId + '"]').prop('checked', !$('.status-toggle[data-user-id="' + userId + '"]').is(':checked'));
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            // Revert toggle on error
                            $('.status-toggle[data-user-id="' + userId + '"]').prop('checked', !$('.status-toggle[data-user-id="' + userId + '"]').is(':checked'));
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.'
                            });
                        }
                    });
                });
                }

                initializeStatusToggles();

                // Handle rejection modal - set user ID when modal is about to show
                $('#rejectionModal').on('show.bs.modal', function(e) {
                    // Get user ID from the button that triggered the modal
                    const button = $(e.relatedTarget);
                    const userId = button.data('user-id');

                    if (userId) {
                        $('#rejectUserId').val(userId);
                        $('#rejectionReason').val(''); // Clear previous reason
                    }
                });

                // Reset rejection modal when closed
                $('#rejectionModal').on('hidden.bs.modal', function() {
                    $('#rejectionForm')[0].reset();
                    $('#rejectUserId').val('');
                    $('#rejectionReason').val('');
                });

                // Initialize approval actions
                function initializeApprovalActions() {
                    $('.approval-action').off('click').on('click', function(e) {
                    const userId = $(this).data('user-id');
                    const status = $(this).data('status');
                    const $button = $(this);

                        // For rejected status, let Bootstrap handle modal opening
                        // The user ID will be set via the show.bs.modal event
                    if (status === 'rejected') {
                            // Don't prevent default - let Bootstrap open the modal
                        return;
                    }

                        // For approval, prevent default and handle manually
                        e.preventDefault();

                    // Show loading state for approval
                    showButtonLoading($button, 'Approving...');

                    // Direct approval
                    updateApprovalStatus(userId, status, null, function(success) {
                        if (success) {
                            hideButtonLoading($button, 'Approve');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Doctor approved successfully',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            hideButtonLoading($button, 'Approve');
                        }
                    });
                });
                }

                // Confirm rejection
                $('#confirmRejection').off('click').on('click', function() {
                    const userId = $('#rejectUserId').val();
                    const reason = $('#rejectionReason').val();
                    const $button = $(this);

                    if (!userId) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'User ID is missing. Please try again.'
                        });
                        return;
                    }

                    if (!reason || !reason.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'Please provide a rejection reason.'
                        });
                        return;
                    }

                    // Show loading state for rejection
                    showButtonLoading($button, 'Rejecting...');

                    updateApprovalStatus(userId, 'rejected', reason.trim(), function(success) {
                        if (success) {
                            hideButtonLoading($button, 'Reject Doctor');
                            $('#rejectionModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Doctor rejected successfully',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            hideButtonLoading($button, 'Reject Doctor');
                        }
                    });
                });


                // Select all functionality
                $('#selectAll').off('change').on('change', function() {
                    $('.doctor-checkbox').prop('checked', $(this).is(':checked'));
                });

                // Bulk approval
                $('#confirmBulkApproval').off('click').on('click', function() {
                    const selectedIds = $('.doctor-checkbox:checked').map(function() {
                        return $(this).val();
                    }).get();
                    const $button = $(this);

                    if (selectedIds.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'Please select at least one doctor.'
                        });
                        return;
                    }

                    // Show loading state for bulk approval
                    showButtonLoading($button, 'Approving...');

                    // Process each selected doctor
                    let completed = 0;
                    let errors = 0;

                    selectedIds.forEach(function(userId) {
                        updateApprovalStatus(userId, 'approved', null, function(success) {
                            completed++;
                            if (!success) errors++;

                            if (completed === selectedIds.length) {
                                hideButtonLoading($button, 'Approve Selected');

                                if (errors === 0) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'All selected doctors have been approved.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Partial Success!',
                                        text: `${selectedIds.length - errors} doctors approved, ${errors} failed.`
                                    });
                                }
                            }
                        });
                    });
                });

                function updateApprovalStatus(userId, status, reason = null, callback = null) {
                    $.ajax({
                        url: '<?php echo e(route("user-management.update-approval-status")); ?>',
                        method: 'POST',
                        data: {
                            user_id: userId,
                            approval_status: status,
                            rejection_reason: reason
                        },
                        success: function(response) {
                            if (response.success) {
                                if (callback) callback(true);
                                else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            } else {
                                if (callback) callback(false);
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message
                                    });
                                }
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Something went wrong. Please try again.';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                const errors = xhr.responseJSON.errors;
                                const firstError = Object.values(errors)[0];
                                if (Array.isArray(firstError) && firstError.length > 0) {
                                    errorMessage = firstError[0];
                                }
                            }

                            if (callback) callback(false);
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage
                                });
                            }
                        }
                    });
                }

                // Helper functions for button loading states
                function showButtonLoading($button, loadingText) {
                    $button.prop('disabled', true);
                    $button.data('original-text', $button.text());
                    $button.html(`
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        ${loadingText}
                    `);
                }

                function hideButtonLoading($button, originalText) {
                    $button.prop('disabled', false);
                    $button.text(originalText);
                }

                // Initialize approval actions on page load (after all functions are defined)
                initializeApprovalActions();
            });
            function confirmDeleteDoctor(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the doctor, all their patients, appointments, and medical records!",
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
                form.action = '<?php echo e(route("user-management.delete", ":id")); ?>'.replace(':id', id);

                form.style.display = 'none';

                // CSRF Token
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '<?php echo e(csrf_token()); ?>';
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
     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/pages/user-management/index.blade.php ENDPATH**/ ?>