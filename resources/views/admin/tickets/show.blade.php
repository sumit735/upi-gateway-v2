@extends('admin.layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="mb-2">
                <h6 class="fw-medium d-flex align-items-center">
                    <a href="{{ route('admin.tickets.index') }}"><i class="ti ti-arrow-left me-2"></i>Back to Tickets</a>
                </h6>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>Create New Ticket
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="row">
            <div class="col-xl-9 col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5 class="fw-medium" style="color: {{ $ticket->category->color }}">{{ $ticket->category->name }}</h5>
                        <div class="d-flex align-items-center">
                            @if($ticket->priority === 'low')
                                <span class="badge badge-success me-3"><i class="ti ti-circle-filled fs-5 me-1"></i>Low</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="badge badge-warning me-3"><i class="ti ti-circle-filled fs-5 me-1"></i>Medium</span>
                            @elseif($ticket->priority === 'high')
                                <span class="badge badge-danger me-3"><i class="ti ti-circle-filled fs-5 me-1"></i>High</span>
                            @else
                                <span class="badge bg-danger me-3"><i class="ti ti-circle-filled fs-5 me-1"></i>Urgent</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <!-- Ticket Header -->
                            <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-3 pb-3">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="mb-3">
                                        <span class="badge badge-info rounded-pill mb-2 fs-13">{{ $ticket->ticket_number }}</span>
                                        <div class="d-flex align-items-center mb-2">
                                            <h4 class="fw-semibold me-2 mb-0">{{ $ticket->subject }}</h4>
                                            @if($ticket->status === 'open')
                                                <span class="badge bg-outline-pink d-flex align-items-center ms-1"><i class="ti ti-circle-filled fs-5 me-1"></i>Open</span>
                                            @elseif($ticket->status === 'in_progress')
                                                <span class="badge bg-outline-warning d-flex align-items-center ms-1"><i class="ti ti-circle-filled fs-5 me-1"></i>In Progress</span>
                                            @elseif($ticket->status === 'resolved')
                                                <span class="badge bg-outline-success d-flex align-items-center ms-1"><i class="ti ti-circle-filled fs-5 me-1"></i>Resolved</span>
                                            @else
                                                <span class="badge bg-outline-secondary d-flex align-items-center ms-1"><i class="ti ti-circle-filled fs-5 me-1"></i>Closed</span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center flex-wrap row-gap-2">
                                            @if($ticket->assignedTo)
                                            <p class="d-flex align-items-center mb-0 me-3 text-muted">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->assignedTo->name) }}&size=24&background=667eea&color=fff" 
                                                     class="avatar avatar-xs rounded-circle me-2" alt="img"> 
                                                Assigned to <span class="text-dark ms-1">{{ $ticket->assignedTo->name }}</span>
                                            </p>
                                            @endif
                                            <p class="d-flex align-items-center mb-0 me-3 text-muted">
                                                <i class="ti ti-calendar-bolt me-1"></i>Updated {{ $ticket->updated_at->diffForHumans() }}
                                            </p>
                                            <p class="d-flex align-items-center mb-0 text-muted">
                                                <i class="ti ti-message-circle-share me-1"></i><span class="comment-count">{{ $ticket->replies->count() }}</span> Comments
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <a href="#reply-form" class="btn btn-primary">
                                        <i class="ti ti-arrow-forward-up me-1"></i>Post a Reply
                                    </a>
                                </div>
                            </div>

                            <!-- Original Message -->
                            <div class="border-bottom mb-3 pb-3">
                                <div class="mb-3">
                                    <p class="mb-0 fs-14" style="white-space: pre-wrap;">{{ $ticket->description }}</p>
                                </div>
                                
                                <!-- Attachments -->
                                @php
                                    $ticketAttachments = $ticket->attachments->where('reply_id', null);
                                @endphp
                                @if($ticketAttachments->count() > 0)
                                <div class="mt-3 p-3 bg-light-300 rounded">
                                    <h6 class="mb-2"><i class="ti ti-paperclip me-1"></i>Attachments ({{ $ticketAttachments->count() }})</h6>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        @foreach($ticketAttachments as $attachment)
                                            @if($attachment->isImage())
                                                <div class="position-relative attachment-preview" style="cursor: pointer;" onclick='showAttachmentPreview(@json($attachment->fileUrl), "{{ $attachment->file_name }}", "image")'>
                                                    <img src="{{ $attachment->fileUrl }}" 
                                                         alt="{{ $attachment->file_name }}" 
                                                         class="rounded border"
                                                         style="width: 120px; height: 120px; object-fit: cover;">
                                                    <div class="position-absolute top-0 end-0 m-1">
                                                        <span class="badge bg-dark bg-opacity-75"><i class="ti ti-eye"></i></span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="border rounded p-3 d-flex align-items-center gap-2 bg-white" style="min-width: 200px; cursor: pointer;" onclick='showAttachmentPreview(@json($attachment->fileUrl), "{{ $attachment->file_name }}", "{{ $attachment->file_type }}")'>
                                                    <i class="ti ti-file-text fs-24 text-primary"></i>
                                                    <div class="flex-fill">
                                                        <div class="fw-medium text-truncate" style="max-width: 150px;">{{ $attachment->file_name }}</div>
                                                        <small class="text-muted">{{ $attachment->formattedSize }}</small>
                                                    </div>
                                                    <a href="{{ $attachment->fileUrl }}" download class="btn btn-sm btn-icon btn-light" onclick="event.stopPropagation()">
                                                        <i class="ti ti-download"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="mt-4">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->creatorName) }}&size=48&background=667eea&color=fff" alt="Img">
                                        </span>
                                        <div>
                                            <h6 class="fw-medium mb-1">{{ $ticket->creatorName }}</h6>
                                            <p class="mb-0 text-muted small"><i class="ti ti-calendar-bolt me-1"></i>{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Replies -->
                            <div id="replies-container">
                                @foreach($ticket->replies as $reply)
                                <div class="border-bottom mb-3 pb-3">
                                    <div class="d-flex align-items-start mb-3">
                                        <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&size=48&background={{ $reply->is_admin_reply ? 'f5222d' : '52c41a' }}&color=fff" alt="Img">
                                        </span>
                                        <div class="flex-fill">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">
                                                        {{ $reply->user->name }}
                                                        @if($reply->is_admin_reply)
                                                            <span class="badge badge-danger badge-xs ms-1">Admin</span>
                                                        @endif
                                                    </h6>
                                                    <p class="mb-0 text-muted small"><i class="ti ti-calendar-bolt me-1"></i>{{ $reply->created_at->format('M d, Y h:i A') }}</p>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <p class="mb-0 fs-14" style="white-space: pre-wrap;">{{ $reply->message }}</p>
                                            </div>
                                            @if($reply->attachments && $reply->attachments->count() > 0)
                                            <div class="mt-2">
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    @foreach($reply->attachments as $attachment)
                                                    <span class="badge bg-light text-dark border fs-12 p-2" style="cursor: pointer;" onclick='showAttachmentPreview(@json($attachment->fileUrl), "{{ $attachment->file_name }}", "{{ $attachment->file_type }}")'>
                                                        <i class="ti ti-paperclip me-1"></i>{{ Str::limit($attachment->file_name, 20) }}
                                                    </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Reply Form -->
                            <div id="reply-form" class="mt-4">
                                <h5 class="mb-3 fw-semibold">Add Your Reply</h5>
                                <form id="reply-form-element" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Message <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="message" id="reply-message" rows="4" placeholder="Type your message here..." required></textarea>
                                        <span class="text-danger small" id="message-error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Attachments (Optional)</label>
                                        <input type="file" class="form-control" name="attachments[]" id="reply-attachments" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.mp4,.mov,.avi">
                                        <small class="text-muted">Max 20MB per file. Allowed: Images, Videos, PDF, DOC</small>
                                        <span class="text-danger small d-block" id="attachments-error"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="reply-submit-btn">
                                        <i class="ti ti-send me-2"></i>Send Reply
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-xl-3 col-md-4">
                <div class="card">
                    <div class="card-header p-3">
                        <h4 class="mb-0">Ticket Actions</h4>
                    </div>
                    <div class="card-body p-0">
                        <!-- Change Priority -->
                        <div class="border-bottom p-3">
                            <form action="{{ route('admin.tickets.priority', $ticket) }}" method="POST" class="priority-form">
                                @csrf
                                <label class="form-label fw-semibold">Change Priority</label>
                                <select name="priority" class="form-select" onchange="this.form.submit()">
                                    <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </form>
                        </div>

                        <!-- Assign To -->
                        <div class="border-bottom p-3">
                            <form action="{{ route('admin.tickets.assign', $ticket) }}" method="POST" class="assign-form">
                                @csrf
                                <label class="form-label fw-semibold">Assign To</label>
                                <select name="assigned_to" class="form-select" onchange="this.form.submit()">
                                    <option value="">Unassigned</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- Ticket Status -->
                        <div class="border-bottom p-3">
                            <form action="{{ route('admin.tickets.status', $ticket) }}" method="POST" class="status-form">
                                @csrf
                                <label class="form-label fw-semibold">Ticket Status</label>
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Ticket Information -->
                <div class="card">
                    <div class="card-header p-3">
                        <h4 class="mb-0">Ticket Information</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center border-bottom p-3">
                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->creatorName) }}&size=40&background=667eea&color=fff" class="rounded-circle" alt="Img">
                            </span>
                            <div>
                                <span class="fs-12 text-muted">Created By</span>
                                <p class="text-dark mb-0 fw-medium">{{ $ticket->creatorName }}</p>
                            </div>
                        </div>
                        @if($ticket->assignedTo)
                        <div class="d-flex align-items-center border-bottom p-3">
                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->assignedTo->name) }}&size=40&background=667eea&color=fff" class="rounded-circle" alt="Img">
                            </span>
                            <div>
                                <span class="fs-12 text-muted">Support Agent</span>
                                <p class="text-dark mb-0 fw-medium">{{ $ticket->assignedTo->name }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="border-bottom p-3">
                            <span class="fs-12 text-muted d-block mb-2">Category</span>
                            <span class="badge fs-13" style="background-color: {{ $ticket->category->color }}">{{ $ticket->category->name }}</span>
                        </div>
                        <div class="border-bottom p-3">
                            <span class="fs-12 text-muted d-block mb-2">Created On</span>
                            <p class="text-dark mb-0">{{ $ticket->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @if($ticket->resolved_at)
                        <div class="p-3">
                            <span class="fs-12 text-muted d-block mb-2">Resolved On</span>
                            <p class="text-dark mb-0">{{ $ticket->resolved_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @else
                        <div class="p-3">
                            <span class="fs-12 text-muted d-block mb-2">Last Updated</span>
                            <p class="text-dark mb-0">{{ $ticket->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Attachment Preview Modal -->
<div class="modal fade" id="attachmentPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attachment-filename"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center" id="attachment-preview-body">
                <!-- Preview content will be inserted here -->
            </div>
            <div class="modal-footer">
                <a href="#" id="attachment-download-btn" download class="btn btn-primary">
                    <i class="ti ti-download me-2"></i>Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Attachment Preview Function
function showAttachmentPreview(url, filename, type) {
    $('#attachment-filename').text(filename);
    $('#attachment-download-btn').attr('href', url);
    
    const previewBody = $('#attachment-preview-body');
    previewBody.html('');
    
    if (type === 'image') {
        previewBody.html(`<img src="${url}" class="img-fluid rounded" alt="${filename}">`);
    } else if (type === 'document' && filename.toLowerCase().endsWith('.pdf')) {
        previewBody.html(`<embed src="${url}" type="application/pdf" width="100%" height="600px">`);
    } else {
        previewBody.html(`
            <div class="text-center py-5">
                <i class="ti ti-file-text" style="font-size: 80px; color: #ccc;"></i>
                <p class="mt-3 text-muted">Preview not available for this file type.</p>
                <p class="text-muted">Click download to view the file.</p>
            </div>
        `);
    }
    
    new bootstrap.Modal(document.getElementById('attachmentPreviewModal')).show();
}

$(document).ready(function() {
    // Handle reply form submission with AJAX
    $('#reply-form-element').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('#message-error').text('');
        $('#attachments-error').text('');
        
        // Disable submit button
        const $submitBtn = $('#reply-submit-btn');
        const originalBtnText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...');
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("admin.tickets.reply", $ticket) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Show toast notification
                showToast('success', response.message || 'Reply added successfully!');
                
                // Clear form
                $('#reply-message').val('');
                $('#reply-attachments').val('');
                
                // Add new reply to the conversation
                if (response.reply) {
                    // Build attachments HTML if any
                    let attachmentsHtml = '';
                    if (response.reply.attachments && response.reply.attachments.length > 0) {
                        attachmentsHtml = '<div class="mt-2"><div class="d-flex align-items-center gap-2 flex-wrap">';
                        response.reply.attachments.forEach(attachment => {
                            attachmentsHtml += `
                                <span class="badge bg-light text-dark border fs-12 p-2" style="cursor: pointer;" 
                                      onclick='showAttachmentPreview("${attachment.file_url}", "${attachment.file_name}", "${attachment.file_type}")'>
                                    <i class="ti ti-paperclip me-1"></i>${attachment.file_name.substring(0, 20)}${attachment.file_name.length > 20 ? '...' : ''}
                                </span>
                            `;
                        });
                        attachmentsHtml += '</div></div>';
                    }
                    
                    const replyHtml = `
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex align-items-start mb-3">
                                <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                    <img src="${response.reply.avatar}" alt="Img">
                                </span>
                                <div class="flex-fill">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">
                                                ${response.reply.user_name}
                                                ${response.reply.is_admin ? '<span class="badge badge-danger badge-xs ms-1">Admin</span>' : ''}
                                            </h6>
                                            <p class="mb-0 text-muted small"><i class="ti ti-calendar-bolt me-1"></i>${response.reply.created_at}</p>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <p class="mb-0 fs-14" style="white-space: pre-wrap;">${response.reply.message}</p>
                                    </div>
                                    ${attachmentsHtml}
                                </div>
                            </div>
                        </div>
                    `;
                    $('#replies-container').append(replyHtml);
                    
                    // Update comment count
                    const currentCount = parseInt($('.comment-count').text());
                    $('.comment-count').text(currentCount + 1);
                }
                
                // Scroll to new reply
                $('html, body').animate({
                    scrollTop: $('#replies-container').children().last().offset().top - 100
                }, 500);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    if (errors.message) {
                        $('#message-error').text(errors.message[0]);
                    }
                    if (errors['attachments.0'] || errors.attachments) {
                        $('#attachments-error').text(errors['attachments.0'] ? errors['attachments.0'][0] : errors.attachments[0]);
                    }
                    showToast('error', 'Please fix the errors and try again.');
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

    // Handle form submissions with AJAX for status, priority, assign
    $('.status-form, .priority-form, .assign-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const formData = new FormData(this);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                showToast('success', response.message || 'Updated successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(xhr) {
                showToast('error', xhr.responseJSON?.message || 'An error occurred.');
            }
        });
    });
});
</script>
@endpush
