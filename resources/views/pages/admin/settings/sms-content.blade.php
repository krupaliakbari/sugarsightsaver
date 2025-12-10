<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        SMS Content Management
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">SMS Content Management</li>
            </ol>
        </nav>
    </div>
    <!-- BREADCRUMB -->

    <div class="container-fluid">
        
        <!-- Start Row -->
        <div class="row layout-top-spacing">
            
            <!-- SMS Content Management -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">SMS Content Management</h4>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.sms-content.update') }}">
                        @csrf
                        
                        <!-- Patient Registration SMS -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Patient Registration SMS Template</h6>
                                <p class="text-muted">This SMS will be sent when a new patient is registered by a doctor.</p>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">SMS Content</label>
                                    <textarea class="form-control" name="patient_registration_sms" rows="4" required>{{ session('patient_registration_sms', 'Welcome to Sugar Sight Saver! Your patient registration is complete. SSSP ID: {sssp_id}. For any queries, contact us at {site_phone}.') }}</textarea>
                                    <small class="form-text text-muted">Available variables: {patient_name}, {sssp_id}, {doctor_name}, {site_phone}</small>
                                </div>
                            </div>
                        </div>

                        <!-- 6-Month Reminder SMS -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">6-Month Reminder SMS Template</h6>
                                <p class="text-muted">This SMS will be sent to patients for 6-month follow-up reminders.</p>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">SMS Content</label>
                                    <textarea class="form-control" name="six_month_reminder_sms" rows="4" required>{{ session('six_month_reminder_sms', 'Dear {patient_name}, it\'s been 6 months since your last visit. Please schedule your follow-up appointment for better diabetes management. Contact: {site_phone}') }}</textarea>
                                    <small class="form-text text-muted">Available variables: {patient_name}, {sssp_id}, {doctor_name}, {site_phone}</small>
                                </div>
                            </div>
                        </div>

                        <!-- 3-Month Report Reminder SMS -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">3-Month Report Reminder SMS Template</h6>
                                <p class="text-muted">This SMS will be sent to patients for 3-month report reminders.</p>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">SMS Content</label>
                                    <textarea class="form-control" name="three_month_report_reminder_sms" rows="4" required>{{ session('three_month_report_reminder_sms', 'Dear {patient_name}, your 3-month diabetes report is ready. Please collect it from your doctor. SSSP ID: {sssp_id}. Contact: {site_phone}') }}</textarea>
                                    <small class="form-text text-muted">Available variables: {patient_name}, {sssp_id}, {doctor_name}, {site_phone}</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Update SMS Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- End Row -->

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.js')}}"></script>
    </x-slot>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</x-base-layout>
