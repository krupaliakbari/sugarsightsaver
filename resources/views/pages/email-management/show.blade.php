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
            .template-info {
                background-color: #f8f9fa;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-bottom: 1.5rem;
            }
            .variable-badge {
                background-color: #e9ecef;
                color: #495057;
                padding: 0.25rem 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.75rem;
                font-family: monospace;
                margin: 0.25rem;
                display: inline-block;
            }
            .preview-box {
                background-color: #ffffff;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                padding: 1.5rem;
                margin-top: 1rem;
            }
            .preview-box iframe {
                width: 100%;
                border: none;
                min-height: 500px;
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
                                <h4 class="mb-0">Email Template Preview</h4>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.email-management.edit', $template->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.email-management.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Back to List
                                    </a>
                                </div>
                            </div>

                            <div class="template-info">
                                <h6 class="mb-2">Template Information</h6>
                                <p class="mb-1"><strong>Name:</strong> {{ $template->name }}</p>
                                <p class="mb-1"><strong>Key:</strong> <code>{{ $template->template_key }}</code></p>
                                @if($template->description)
                                    <p class="mb-1"><strong>Description:</strong> {{ $template->description }}</p>
                                @endif
                                <p class="mb-1">
                                    <strong>Status:</strong> 
                                    @if($template->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </p>
                                @if($template->variables && count($template->variables) > 0)
                                    <p class="mb-1"><strong>Available Variables:</strong></p>
                                    <div>
                                        @foreach($template->variables as $variable)
                                            <span class="variable-badge">{ {{ $variable }} }</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <h6>Subject (with variables replaced):</h6>
                                <div class="alert alert-info">
                                    {{ $processed['subject'] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Body Preview (with variables replaced):</h6>
                                <div class="preview-box">
                                    {!! $processed['body'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
    <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>

</x-base-layout>

