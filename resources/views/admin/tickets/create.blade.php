@extends('admin.layouts.app')

@section('title', 'Create Support Ticket')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Create Support Ticket</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.tickets.index') }}">My Tickets</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Ticket</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-light me-2">
                    <i class="ti ti-arrow-left me-2"></i>Back to My Tickets
                </a>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-lg bg-primary-transparent me-3">
                                <i class="ti ti-ticket fs-24"></i>
                            </span>
                            <div>
                                <h4 class="mb-1">Submit a New Ticket</h4>
                                <p class="text-muted mb-0">Fill in the details below and our support team will get back to you</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="create-ticket-form" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Category Selection -->
                            <div class="mb-4">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select" name="category_id" id="category_id" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                            @if($category->description)
                                                - {{ $category->description }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger small" id="category_id-error"></span>
                            </div>

                            <!-- Priority Selection -->
                            <div class="mb-4">
                                <label class="form-label">Priority <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-low" value="low" checked>
                                        <label class="form-check-label" for="priority-low">
                                            <span class="badge badge-success">Low</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-medium" value="medium">
                                        <label class="form-check-label" for="priority-medium">
                                            <span class="badge badge-warning">Medium</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-high" value="high">
                                        <label class="form-check-label" for="priority-high">
                                            <span class="badge badge-danger">High</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="priority" id="priority-urgent" value="urgent">
                                        <label class="form-check-label" for="priority-urgent">
                                            <span class="badge bg-purple">Urgent</span>
                                        </label>
                                    </div>
                                </div>
                                <span class="text-danger small" id="priority-error"></span>
                            </div>

                            <!-- Subject -->
                            <div class="mb-4">
                                <label class="form-label">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="subject" id="subject" 
                                       placeholder="Brief description of your issue" 
                                       maxlength="255" required>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="text-danger small" id="subject-error"></span>
                                    <small class="text-muted"><span id="subject-count">0</span>/255</small>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" id="description" 
                                          rows="6" placeholder="Provide detailed information about your issue..." required></textarea>
                                <small class="text-muted d-block mt-1">
                                    <i class="ti ti-info-circle me-1"></i>Please include as much detail as possible to help us assist you better
                                </small>
                                <span class="text-danger small" id="description-error"></span>
                            </div>

                            <!-- Attachments -->
                            <div class="mb-4">
                                <label class="form-label">Attachments (Optional)</label>
                                <div class="border rounded p-3 bg-light-300">
                                    <input type="file" class="form-control" name="attachments[]" id="attachments" 
                                           multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.mp4,.mov,.avi">
                                    <div class="mt-2">
                                        <small class="text-muted d-block">
                                            <i class="ti ti-info-circle me-1"></i>
                                            Supported formats: Images (JPG, PNG, GIF), Documents (PDF, DOC, DOCX), Videos (MP4, MOV, AVI)
                                        </small>
                                        <small class="text-muted d-block">
                                            <i class="ti ti-alert-circle me-1"></i>
                                            Maximum file size: 20MB per file
                                        </small>
                                    </div>
                                    <span class="text-danger small d-block mt-1" id="attachments-error"></span>
                                    
                                    <!-- File Preview Area -->
                                    <div id="file-preview-area" class="mt-3" style="display: none;">
                                        <hr class="my-2">
                                        <h6 class="mb-2"><i class="ti ti-files me-1"></i>Selected Files:</h6>
                                        <div id="file-list" class="d-flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.tickets.index') }}" class="btn btn-light">
                                    <i class="ti ti-x me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <i class="ti ti-send me-2"></i>Create Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="card border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <span class="avatar avatar-lg bg-primary-transparent me-3">
                                <i class="ti ti-help fs-24"></i>
                            </span>
                            <div>
                                <h5 class="mb-2">Need Help?</h5>
                                <p class="text-muted mb-2">Before submitting a ticket, you might find answers in our:</p>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1"><i class="ti ti-circle-check text-success me-2"></i>Knowledge Base</li>
                                    <li class="mb-1"><i class="ti ti-circle-check text-success me-2"></i>FAQs Section</li>
                                    <li class="mb-1"><i class="ti ti-circle-check text-success me-2"></i>Community Forums</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Character counter for subject
    $('#subject').on('input', function() {
        const count = $(this).val().length;
        $('#subject-count').text(count);
        
        if (count > 255) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Priority badge visual feedback
    $('input[name="priority"]').on('change', function() {
        $('input[name="priority"]').parent().find('.badge').removeClass('badge-lg');
        $(this).parent().find('.badge').addClass('badge-lg');
    });

    // File selection preview
    $('#attachments').on('change', function() {
        const files = this.files;
        const fileList = $('#file-list');
        const previewArea = $('#file-preview-area');
        
        fileList.empty();
        
        if (files.length > 0) {
            previewArea.show();
            
            Array.from(files).forEach((file, index) => {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                const fileName = file.name;
                const fileType = file.type;
                
                let icon = 'ti-file';
                let bgColor = 'bg-secondary';
                
                if (fileType.startsWith('image/')) {
                    icon = 'ti-photo';
                    bgColor = 'bg-info';
                } else if (fileType.includes('pdf')) {
                    icon = 'ti-file-text';
                    bgColor = 'bg-danger';
                } else if (fileType.includes('video')) {
                    icon = 'ti-video';
                    bgColor = 'bg-warning';
                } else if (fileType.includes('document') || fileType.includes('word')) {
                    icon = 'ti-file-description';
                    bgColor = 'bg-primary';
                }
                
                const fileCard = `
                    <div class="border rounded p-2 d-flex align-items-center gap-2 bg-white" style="min-width: 200px;">
                        <span class="avatar avatar-sm ${bgColor}">
                            <i class="ti ${icon}"></i>
                        </span>
                        <div class="flex-fill">
                            <div class="fw-medium text-truncate" style="max-width: 120px;" title="${fileName}">
                                ${fileName}
                            </div>
                            <small class="text-muted">${fileSize} MB</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-icon btn-light remove-file" data-index="${index}">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                `;
                
                fileList.append(fileCard);
            });
        } else {
            previewArea.hide();
        }
    });

    // Remove file from selection
    $(document).on('click', '.remove-file', function() {
        const input = document.getElementById('attachments');
        const dt = new DataTransfer();
        const files = input.files;
        const indexToRemove = $(this).data('index');
        
        Array.from(files).forEach((file, index) => {
            if (index !== indexToRemove) {
                dt.items.add(file);
            }
        });
        
        input.files = dt.files;
        $('#attachments').trigger('change');
    });

    // Form submission with AJAX
    $('#create-ticket-form').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.text-danger.small').text('');
        $('.form-control, .form-select').removeClass('is-invalid');
        
        // Disable submit button
        const $submitBtn = $('#submit-btn');
        const originalBtnText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Creating Ticket...');
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("admin.tickets.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Show success toast
                showToast('success', response.message || 'Ticket created successfully!');
                
                // Redirect to ticket details page after a short delay
                setTimeout(function() {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else if (response.ticket_id) {
                        window.location.href = '{{ route("admin.tickets.index") }}';
                    }
                }, 1000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    
                    $.each(errors, function(field, messages) {
                        // Handle array field names like attachments.0
                        const fieldName = field.split('.')[0];
                        const errorElement = $('#' + fieldName + '-error');
                        const inputElement = $('#' + fieldName);
                        
                        if (errorElement.length) {
                            errorElement.text(messages[0]);
                        }
                        
                        if (inputElement.length) {
                            inputElement.addClass('is-invalid');
                        }
                    });
                    
                    showToast('error', 'Please fix the errors and try again.');
                    
                    // Scroll to first error
                    const firstError = $('.is-invalid:first');
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                } else if (xhr.status === 403) {
                    showToast('error', xhr.responseJSON?.message || 'You do not have permission to create tickets.');
                } else {
                    showToast('error', xhr.responseJSON?.message || 'An error occurred. Please try again.');
                }
            },
            complete: function() {
                // Re-enable submit button
                $submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });

    // Auto-focus on category on page load
    setTimeout(() => {
        $('#category_id').focus();
    }, 100);
});
</script>
@endpush
