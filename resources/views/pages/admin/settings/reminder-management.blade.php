<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Reminder Management
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
                <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reminder Management</li>
            </ol>
        </nav>
    </div>
    <!-- BREADCRUMB -->

    <div class="container-fluid">
        
        <!-- Start Row -->
        <div class="row layout-top-spacing">
            
            <!-- Reminder Statistics -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">Reminder Statistics</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $stats['total_patients'] }}</h3>
                                    <p class="mb-0">Total Patients</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $stats['patients_due_six_month'] }}</h3>
                                    <p class="mb-0">Due for 6-Month Follow-up</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $stats['patients_due_three_month'] }}</h3>
                                    <p class="mb-0">Due for 3-Month Report</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Reminder Sending -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">Send Reminders</h4>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">6-Month Follow-up</h5>
                                    <p class="card-text">Send reminders to patients who haven't visited in 6 months</p>
                                    <form method="POST" action="{{ route('admin.settings.reminders.send') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="type" value="six-month">
                                        <button type="submit" class="btn btn-warning" onclick="return confirm('Send 6-month reminders to {{ $stats['patients_due_six_month'] }} patients?')">
                                            Send Reminders
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">3-Month Report</h5>
                                    <p class="card-text">Send reminders to patients for report collection</p>
                                    <form method="POST" action="{{ route('admin.settings.reminders.send') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="type" value="three-month">
                                        <button type="submit" class="btn btn-info" onclick="return confirm('Send 3-month report reminders to {{ $stats['patients_due_three_month'] }} patients?')">
                                            Send Reminders
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">All Reminders</h5>
                                    <p class="card-text">Send all pending reminders at once</p>
                                    <form method="POST" action="{{ route('admin.settings.reminders.send') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="type" value="all">
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Send all reminders to {{ $stats['patients_due_six_month'] + $stats['patients_due_three_month'] }} patients?')">
                                            Send All
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cron Job Information -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">Automated Reminder Setup</h4>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">Cron Job Setup</h6>
                        <p>To set up automated reminders, add the following cron jobs to your server:</p>
                        <div class="bg-dark text-light p-3 rounded mb-3">
                            <code>
                                # Send 6-month reminders daily at 9 AM<br>
                                0 9 * * * cd {{ base_path() }} && php artisan reminders:send six-month<br><br>
                                
                                # Send 3-month report reminders daily at 10 AM<br>
                                0 10 * * * cd {{ base_path() }} && php artisan reminders:send three-month<br><br>
                                
                                # Send all reminders weekly on Monday at 8 AM<br>
                                0 8 * * 1 cd {{ base_path() }} && php artisan reminders:send all
                            </code>
                        </div>
                        <p class="mb-0"><strong>Note:</strong> Make sure your server has proper email and WhatsApp API configuration for automated sending.</p>
                    </div>
                </div>
            </div>

            <!-- Reminder Logs -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">Recent Reminder Activity</h4>
                    </div>

                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Reminder Logs</h6>
                        <p>Check your Laravel logs for detailed information about sent reminders:</p>
                        <ul class="mb-0">
                            <li><strong>Log File:</strong> <code>storage/logs/laravel.log</code></li>
                            <li><strong>Search for:</strong> "reminder sent to patient" or "Failed to send"</li>
                            <li><strong>WhatsApp URLs:</strong> Logged for manual sending or API integration</li>
                        </ul>
                    </div>
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
