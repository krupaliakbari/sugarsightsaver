<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>

    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BREADCRUMB -->

    <!-- BREADCRUMB -->

    @php
        $totalUsers = \App\Models\User::count();
       $activeDoctors = \App\Models\User::where('user_type', 'doctor')
                ->where('status', 'active')
                ->count();
        $adminUsers = \App\Models\User::role('admin')->count();
        $doctorUsers = \App\Models\User::role('doctor')->count();
        $patientUsers = \App\Models\Patient::count();
        $pendingDoctors = \App\Models\User::where('user_type', 'doctor')->where('approval_status', 'pending')->count();
        $approvedDoctors = \App\Models\User::where('user_type', 'doctor')->where('approval_status', 'approved')->count();
        $rejectedDoctors = \App\Models\User::where('user_type', 'doctor')->where('approval_status', 'rejected')->count();
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $todayUsers = \App\Models\User::whereDate('created_at', today())->count();
        $thisMonthUsers = \App\Models\User::whereMonth('created_at', now()->month)->count();
    @endphp

    <div class="container-fluid mt-4">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
                                <p class="text-muted mb-0">Here's what's happening with your Sugar Sight system today.</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="me-3">
                                        <h6 class="mb-0 text-muted">Last Login</h6>
                                        <small class="text-muted">{{ auth()->user()->updated_at->format('M d, Y H:i') }}</small>
                                    </div>
                                    <div class="avatar avatar-lg">
                                        @if(auth()->user()->profile_image)
                                            <img src="{{ url(auth()->user()->profile_image) }}" alt="Profile" class="rounded-circle">
                                        @else
                                            <div class="avatar-title bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                                {{ substr(auth()->user()->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Total Patients</h6>
                                <h3 class="mb-0 text-primary">{{ number_format($patientUsers) }}</h3>
                                {{-- <small class="text-success">
                                    <i class="mdi mdi-arrow-up"></i> +{{ $todayUsers }} today
                                </small> --}}
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-primary bg-soft rounded">
                                    <i class="mdi mdi-account-group text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Active Doctors</h6>
                                <h3 class="mb-0 text-success">{{ number_format($activeDoctors) }}</h3>
                                {{-- <small class="text-muted">
                                    {{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}% of total
                                </small> --}}
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-success bg-soft rounded">
                                    <i class="mdi mdi-account-check text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Doctors</h6>
                                <h3 class="mb-0 text-info">{{ number_format($doctorUsers) }}</h3>
                                {{-- <small class="text-muted">
                                    {{ $approvedDoctors }} approved

                                </small> --}}
                                  {{-- {{ $pendingDoctors }} pending --}}
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-info bg-soft rounded">
                                    <i class="mdi mdi-doctor text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-2">Patients</h6>
                                <h3 class="mb-0 text-warning">{{ number_format($patientUsers) }}</h3> --}}
                                {{-- <small class="text-muted">
                                    {{ $thisMonthUsers }} this month
                                </small> --}}
                            {{-- </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-warning bg-soft rounded">
                                    <i class="mdi mdi-account-heart text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Doctor Approval Status -->
        {{-- <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="avatar-sm bg-success bg-soft rounded-circle mx-auto mb-3">
                            <i class="mdi mdi-check-circle text-success"></i>
                        </div>
                        <h4 class="text-success mb-1">{{ $approvedDoctors }}</h4>
                        <p class="text-muted mb-0">Approved Doctors</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="avatar-sm bg-warning bg-soft rounded-circle mx-auto mb-3">
                            <i class="mdi mdi-clock text-warning"></i>
                        </div>
                        <h4 class="text-warning mb-1">{{ $pendingDoctors }}</h4>
                        <p class="text-muted mb-0">Pending Approval</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="avatar-sm bg-danger bg-soft rounded-circle mx-auto mb-3">
                            <i class="mdi mdi-close-circle text-danger"></i>
                        </div>
                        <h4 class="text-danger mb-1">{{ $rejectedDoctors }}</h4>
                        <p class="text-muted mb-0">Rejected Applications</p>
                    </div>
                </div>
            </div>
        </div> --}}


    </div>

</x-base-layout>
