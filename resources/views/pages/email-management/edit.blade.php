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
            #body {
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
                                <h4 class="mb-0">Edit Email Template</h4>
                                <a href="{{ route('admin.email-management.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back to List
                                </a>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="template-info">
                                <h6 class="mb-2">Template Information</h6>
                                <p class="mb-1"><strong>Name:</strong> {{ $template->name }}</p>
                                <p class="mb-1"><strong>Key:</strong> <code>{{ $template->template_key }}</code></p>
                                @if($template->description)
                                    <p class="mb-1"><strong>Description:</strong> {{ $template->description }}</p>
                                @endif
                                @if($template->variables && count($template->variables) > 0)
                                    <p class="mb-1"><strong>Available Variables:</strong></p>
                                    <div>
                                        @foreach($template->variables as $variable)
                                            <span class="variable-badge">{ {{ $variable }} }</span>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 mb-0 text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Use these variables in your subject and body. They will be replaced with actual values when the email is sent.
                                    </p>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('admin.email-management.update', $template->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject', $template->subject) }}" required>
                                    <small class="text-muted">You can use variables like {site_name}, {doctor_name}, etc.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="body" name="body" required>{{ old('body', $template->body) }}</textarea>
                                    <small class="text-muted">HTML is supported. You can use variables like {site_name}, {doctor_name}, etc. Use the Source button in the toolbar to edit raw HTML.</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $template->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                    <small class="text-muted">Inactive templates will not be used when sending emails.</small>
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Update Template
                                    </button>
                                    <a href="{{ route('admin.email-management.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
    <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
    <!-- CKEditor 4 for better HTML email support -->
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('body', {
            height: 500,
            toolbar: [
                { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'ExportPdf', 'Preview', 'Print', '-', 'Templates'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                '/',
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                '/',
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                { name: 'about', items: ['About'] }
            ],
            extraPlugins: 'colorbutton,font,justify,print,format,forms,pagebreak,iframe',
            allowedContent: true, // Allow all HTML tags and attributes
            fullPage: false,
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            // Preserve HTML structure for email templates
            htmlEncodeOutput: false,
            entities: false,
            basicEntities: false
        });
        
        // Update textarea before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    </script>

</x-base-layout>

