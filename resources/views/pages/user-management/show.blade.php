<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">

        <style>
            @media (max-width: 768px) {
                .table tbody tr td{
                    white-space: wrap !important;
                }
                .form-switch {
    padding-left: 1.5em;
}
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
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->
    {{-- <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user-management') }}">{{$breadcrumb}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
            </ol>
        </nav>
    </div> --}}
    <!-- BREADCRUMB -->

    <div class="container-fluid">

        <!-- Start Row -->
        <div class="row layout-top-spacing">

            <!-- Doctor Profile Card -->
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="text-center mb-4">
                        @if($doctor->profile_image)
                            <img src="{{ url($doctor->profile_image) }}" alt="avatar" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="avatar-initial bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; font-size: 3rem;">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                        @endif

                        <h4 class="mb-1">{{ $doctor->name }}</h4>
                        <p class="text-muted mb-3">{{ $doctor->qualification ?? 'No qualification provided' }}</p>

                        <!-- Status Badges -->
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            @if($doctor->status == 'active')
                                <span class="badge badge-light-success">Active</span>
                            @else
                                <span class="badge badge-light-danger">Deactive</span>
                            @endif

                            @if($doctor->approval_status == 'pending')
                                <span class="badge badge-light-warning">Pending Approval</span>
                            @elseif($doctor->approval_status == 'approved')
                                <span class="badge badge-light-success">Approved</span>
                            @else
                                <span class="badge badge-light-danger">Rejected</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-sm btn-outline-primary" onclick="window.history.back()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left me-1"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12,19 5,12 12,5"></polyline></svg>
                                Back
                            </button>

                            @if($doctor->approval_status == 'pending')
                                <button class="btn btn-sm btn-success" onclick="updateApprovalStatus({{ $doctor->id }}, 'approved')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check me-1"><polyline points="20,6 9,17 4,12"></polyline></svg>
                                    Approve
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectionModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-1"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    Reject
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor Details -->
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 layout-spacing">
               
                     <!-- Appointments and Medical Records Table -->
                        <div class="card" id="appointments-section">
                            <div class="card-header">
                                <h5 class="card-title">Doctor Information</h5>
                            </div>
                            
                          
                                    
                            <div class="card-body">
                                <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" style="width: 40%;">Full Name:</td>
                                    <td>{{ $doctor->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>
                                        <a href="mailto:{{ $doctor->email }}" class="text-decoration-none">{{ $doctor->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phone:</td>
                                    <td>
                                        @if($doctor->phone)
                                            <a href="tel:{{ $doctor->phone }}" class="text-decoration-none">{{ $doctor->phone }}</a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input status-toggle"
                                                   type="checkbox"
                                                   data-user-id="{{ $doctor->id }}"
                                                   {{ $doctor->status == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2">
                                                {{ ucfirst($doctor->status) }}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="fw-bold">Doctor Type:</td>
                                    <td>
                                        @if($doctor->doctor_type)
                                            <span class="badge badge-light-info">{{ $doctor->doctor_type_display }}</span>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Hospital:</td>
                                    <td>{{ $doctor->hospital_name ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Qualification:</td>
                                    <td>{{ $doctor->qualification ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Approval Status:</td>
                                    <td>
                                        @if($doctor->approval_status == 'pending')
                                            <span class="badge badge-light-warning">Pending</span>
                                        @elseif($doctor->approval_status == 'approved')
                                            <span class="badge badge-light-success">Approved</span>
                                        @else
                                            <span class="badge badge-light-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($doctor->address)
                                <tr>
                                    
                                        <td class="fw-bold">Address:</td>
                                    <td>{{ $doctor->address }}</td>
                                    
                                </tr>
                                @endif
                                @if($doctor->approval_status == 'rejected' && $doctor->rejection_reason)

                                <tr>
                                     <td class="fw-bold">Rejection Reason:</td>
                                    <td>{{ $doctor->rejection_reason }}</td>
                                    
                                </tr>
                                 @endif
                                <tr>
                                <td class="fw-bold">Registered On:</td>
                                <td>{{ $doctor->created_at->format('M d, Y \a\t h:i A') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Last Updated:</td>
                                <td>{{ $doctor->updated_at->format('M d, Y \a\t h:i A') }}</td>
                            </tr>

                            </table>
                        </div>

                        
                    </div>

                    

                   

                   
                                
                            </div>
                        </div>
              
            </div>
        </div>
        <!-- End Row -->

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
                        <input type="hidden" id="rejectUserId" name="user_id" value="{{ $doctor->id }}">
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

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script>
            $(document).ready(function() {
                // CSRF token setup
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Status toggle functionality
                $('.status-toggle').change(function() {
                    const userId = $(this).data('user-id');
                    const status = $(this).is(':checked') ? 'active' : 'deactive';
                    const $label = $(this).siblings('label');

                    $.ajax({
                        url: '{{ route("user-management.toggle-status") }}',
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

                // Confirm rejection
                $('#confirmRejection').click(function() {
                    const userId = $('#rejectUserId').val();
                    const reason = $('#rejectionReason').val();

                    if (!reason.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'Please provide a rejection reason.'
                        });
                        return;
                    }

                    updateApprovalStatus(userId, 'rejected', reason);
                });

                function updateApprovalStatus(userId, status, reason = null) {
                    $.ajax({
                        url: '{{ route("user-management.update-approval-status") }}',
                        method: 'POST',
                        data: {
                            user_id: userId,
                            approval_status: status,
                            rejection_reason: reason
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.'
                            });
                        }
                    });
                }

                // Make updateApprovalStatus available globally
                window.updateApprovalStatus = updateApprovalStatus;
            });
        </script>
    </x-slot>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</x-base-layout>
