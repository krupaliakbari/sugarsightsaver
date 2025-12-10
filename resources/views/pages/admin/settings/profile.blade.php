<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        My Account - Profile Management
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
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </nav>
    </div>
    <!-- BREADCRUMB -->

    <div class="container-fluid">
        
        <!-- Start Row -->
        <div class="row layout-top-spacing">
            
            <!-- Profile Information -->
            <div class="col-xl-8 col-lg-8 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">Profile Information</h4>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.profile.update') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" value="{{ auth()->user()->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Hospital Name</label>
                                    <input type="text" class="form-control" name="hospital_name" value="{{ auth()->user()->hospital_name }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="col-xl-4 col-lg-4 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="table-header">Change Password</h4>
                    </div>

                    <form method="POST" action="{{ route('admin.settings.password.update') }}">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password" required minlength="8">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation" required minlength="8">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">
                                Change Password
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
