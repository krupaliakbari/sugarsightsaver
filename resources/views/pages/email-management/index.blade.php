<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])        
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
        <style>
            .table-responsive {
                overflow-x: auto;
            }
            .table {
                width: 100%;
                margin-bottom: 0;
            }
            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
                padding: 0.75rem;
            }
            .table td {
                vertical-align: middle;
                padding: 0.75rem;
            }
            .table-hover tbody tr:hover {
                background-color: #f8f9fa;
            }
            .btn-sm {
                white-space: nowrap;
            }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
        <div class="row mt-3" style="margin-left: 0; margin-right: 0;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding-left: 0; padding-right: 0;">
                <div class="widget-content widget-content-area br-8">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Email Management</h4>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($templates->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Subject</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($templates as $template)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $template->name }}</strong>
                                                    </td>
                                                    <td>
                                                        <span>{{ $template->subject }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('admin.email-management.edit', $template->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                           
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No email templates found. Please run the seeder to populate email templates.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
    <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>

</x-base-layout>

