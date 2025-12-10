<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        General Settings
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <style>
            /* Compact card headers */
            .card-header {
                padding: 0.5rem 1rem !important;
                background-color: #6366f1 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">General Settings</li>
            </ol>
        </nav>
    </div> --}}
    <!-- BREADCRUMB -->

    <div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="widget-content widget-content-area br-8">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">General Settings</h4>

                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.settings.update') }}">
                            @csrf

                            <!-- Site Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Site Information</h5>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Site Name</label>
                                                <input type="text" class="form-control" name="site_name"
                                                    value="{{ $settings['site_name'] ?? 'Sugar Sight Saver' }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Site Email</label>
                                                <input type="email" class="form-control" name="site_email"
                                                    value="{{ $settings['site_email'] ?? 'admin@sugarsight.com' }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Site Phone</label>
                                                <input type="text" class="form-control" name="site_phone"
                                                    value="{{ $settings['site_phone'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Site Address</label>
                                                <textarea class="form-control" name="site_address" rows="2">{{ $settings['site_address'] ?? '' }}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <!-- SMTP Configuration -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">SMTP Configuration</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">SMTP Host</label>
                                            <input type="text" class="form-control" name="smtp_host"
                                                value="{{ $settings['smtp_host'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">SMTP Port</label>
                                            <input type="number" class="form-control" name="smtp_port"
                                                value="{{ $settings['smtp_port'] ?? '587' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">SMTP Username</label>
                                            <input type="text" class="form-control" name="smtp_username"
                                                value="{{ $settings['smtp_username'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">SMTP Password</label>
                                            <input type="password" class="form-control" name="smtp_password"
                                                value="{{ $settings['smtp_password'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">SMTP Encryption</label>
                                            <select class="form-select" name="smtp_encryption">
                                                <option value="">None</option>
                                                <option value="tls"
                                                    {{ ($settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>
                                                    TLS</option>
                                                <option value="ssl"
                                                    {{ ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>
                                                    SSL</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                                    
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{-- <button type="button" class="btn btn-outline-info" onclick="testSmtp()"
                                id="testSmtpBtn">
                                Test SMTP Configuration
                            </button> --}}
                                <button type="submit" class="btn btn-primary">
                                    Update Settings
                                </button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <x-slot:footerFiles>
        <script>
            function testSmtp() {
                const btn = document.getElementById('testSmtpBtn');
                const originalText = btn.innerHTML;

                // Disable button and show loading
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Testing...';

                // Check if SweetAlert2 is available
                if (typeof Swal === 'undefined') {
                    // Fallback: show loading state without SweetAlert2
                    console.log('SweetAlert2 not available, using fallback');
                } else {
                    Swal.fire({
                        title: 'Testing SMTP Configuration...',
                        text: 'Please wait while we test your SMTP settings.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }

                fetch('{{ route('admin.settings.test-smtp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Restore button state
                        btn.disabled = false;
                        btn.innerHTML = originalText;

                        if (typeof Swal !== 'undefined') {
                            Swal.close();
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        } else {
                            // Fallback to regular alert
                            alert(data.status === 'success' ? 'Success: ' + data.message : 'Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        // Restore button state
                        btn.disabled = false;
                        btn.innerHTML = originalText;

                        if (typeof Swal !== 'undefined') {
                            Swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while testing SMTP configuration.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Fallback to regular alert
                            alert('Error: An error occurred while testing SMTP configuration.');
                        }
                    });
            }
        </script>
    </x-slot>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</x-base-layout>
