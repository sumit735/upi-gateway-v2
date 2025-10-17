@extends('admin.layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="mb-2">
                <h6 class="fw-medium d-flex align-items-center">
                    <a href="{{ route('tickets.index') }}"><i class="ti ti-arrow-left me-2"></i>Ticket Details</a>
                </h6>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                <div class="mb-2">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary d-flex align-items-center">
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
                            <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom mb-3">
                                <div class="d-flex align-items-center flex-wrap">
                                    <div class="mb-3">
                                        <span class="badge badge-info rounded-pill mb-2">{{ $ticket->ticket_number }}</span>
                                        <div class="d-flex align-items-center mb-2">
                                            <h5 class="fw-semibold me-2">{{ $ticket->subject }}</h5>
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
                                            <p class="d-flex align-items-center mb-0 me-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->assignedTo->name) }}&size=24&background=667eea&color=fff" 
                                                     class="avatar avatar-xs rounded-circle me-2" alt="img"> 
                                                Assigned to <span class="text-dark ms-1">{{ $ticket->assignedTo->name }}</span>
                                            </p>
                                            @endif
                                            <p class="d-flex align-items-center mb-0 me-2">
                                                <i class="ti ti-calendar-bolt me-1"></i>Updated {{ $ticket->updated_at->diffForHumans() }}
                                            </p>
                                            <p class="d-flex align-items-center mb-0">
                                                <i class="ti ti-message-circle-share me-1"></i>{{ $ticket->replies->count() }} Comments
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if($ticket->isOpen())
                                <div class="mb-3">
                                    <a href="#reply-form" class="btn btn-primary">
                                        <i class="ti ti-arrow-forward-up me-1"></i>Post a Reply
                                    </a>
                                </div>
                                @endif
                            </div>

                            <!-- Original Message -->
                            <div class="border-bottom mb-3 pb-3">
                                <div>
                                    <p class="mb-3" style="white-space: pre-wrap;">{{ $ticket->description }}</p>
                                </div>
                                @if($ticket->attachments->count() > 0)
                                <div class="mt-3">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        @foreach($ticket->attachments as $attachment)
                                            @if($attachment->isImage())
                                                <a href="{{ $attachment->fileUrl }}" target="_blank">
                                                    <img src="{{ $attachment->fileUrl }}" 
                                                         alt="{{ $attachment->file_name }}" 
                                                         class="rounded"
                                                         style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                                </a>
                                            @else
                                                <span class="badge bg-light text-dark fw-normal">
                                                    {{ Str::limit($attachment->file_name, 15) }}
                                                    <a href="{{ $attachment->fileUrl }}" target="_blank" class="text-primary">
                                                        <i class="ti ti-download ms-1"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="mt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->creatorName) }}&size=48&background=667eea&color=fff" alt="Img">
                                        </span>
                                        <div>
                                            <h6 class="fw-medium mb-1">{{ $ticket->creatorName }}</h6>
                                            <p class="mb-0"><i class="ti ti-calendar-bolt me-1"></i>{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Replies -->
                            @foreach($ticket->replies as $reply)
                            <div class="border-bottom mb-3 pb-3">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->name) }}&size=48&background={{ $reply->is_admin_reply ? 'f5222d' : '52c41a' }}&color=fff" alt="Img">
                                        </span>
                                        <div>
                                            <h6 class="mb-1">
                                                {{ $reply->user->name }}
                                                @if($reply->is_admin_reply)
                                                    <span class="badge badge-danger badge-xs ms-1">Admin</span>
                                                @endif
                                            </h6>
                                            <p class="mb-0"><i class="ti ti-calendar-bolt me-1"></i>{{ $reply->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mb-3">
                                            <p style="white-space: pre-wrap;">{{ $reply->message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Reply Form -->
                            @if($ticket->isOpen())
                            <div id="reply-form">
                                <h5 class="mb-3">Add Your Reply</h5>
                                <div id="reply-success" class="alert alert-success d-none mb-3">
                                    <i class="ti ti-check me-2"></i><span></span>
                                </div>
                                <div id="reply-error" class="alert alert-danger d-none mb-3">
                                    <i class="ti ti-x me-2"></i><span></span>
                                </div>
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
                            @else
                            <div class="alert alert-warning mb-0">
                                <i class="ti ti-info-circle me-2"></i>This ticket is {{ $ticket->status }}. You cannot add new replies.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-4">
                <div class="card">
                    <div class="card-header p-3">
                        <h4>Ticket Information</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center border-bottom p-3">
                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->creatorName) }}&size=40&background=667eea&color=fff" class="rounded-circle" alt="Img">
                            </span>
                            <div>
                                <span class="fs-12 text-muted">Created By</span>
                                <p class="text-dark mb-0">{{ $ticket->creatorName }}</p>
                            </div>
                        </div>
                        @if($ticket->assignedTo)
                        <div class="d-flex align-items-center border-bottom p-3">
                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->assignedTo->name) }}&size=40&background=667eea&color=fff" class="rounded-circle" alt="Img">
                            </span>
                            <div>
                                <span class="fs-12 text-muted">Support Agent</span>
                                <p class="text-dark mb-0">{{ $ticket->assignedTo->name }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="border-bottom p-3">
                            <span class="fs-12 text-muted d-block mb-1">Category</span>
                            <span class="badge" style="background-color: {{ $ticket->category->color }}">{{ $ticket->category->name }}</span>
                        </div>
                        <div class="border-bottom p-3">
                            <span class="fs-12 text-muted d-block mb-1">Priority</span>
                            @if($ticket->priority === 'low')
                                <span class="badge badge-success">Low</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="badge badge-warning">Medium</span>
                            @elseif($ticket->priority === 'high')
                                <span class="badge badge-danger">High</span>
                            @else
                                <span class="badge bg-danger">Urgent</span>
                            @endif
                        </div>
                        <div class="border-bottom p-3">
                            <span class="fs-12 text-muted d-block mb-1">Status</span>
                            <p class="text-dark mb-0">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</p>
                        </div>
                        <div class="border-bottom p-3">
                            <span class="fs-12 text-muted d-block mb-1">Created On</span>
                            <p class="text-dark mb-0">{{ $ticket->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @if($ticket->resolved_at)
                        <div class="p-3">
                            <span class="fs-12 text-muted d-block mb-1">Resolved On</span>
                            <p class="text-dark mb-0">{{ $ticket->resolved_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @else
                        <div class="p-3">
                            <span class="fs-12 text-muted d-block mb-1">Last Updated</span>
                            <p class="text-dark mb-0">{{ $ticket->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                        @endif
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
    // Handle reply form submission
    $('#reply-form-element').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('#message-error').text('');
        $('#attachments-error').text('');
        $('#reply-success').addClass('d-none');
        $('#reply-error').addClass('d-none');
        
        // Disable submit button
        const $submitBtn = $('#reply-submit-btn');
        const originalBtnText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Sending...');
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Send AJAX request
        $.ajax({
            url: '{{ route("tickets.reply", $ticket) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Show success message
                $('#reply-success span').text(response.message || 'Reply added successfully!');
                $('#reply-success').removeClass('d-none');
                
                // Clear form
                $('#reply-message').val('');
                $('#reply-attachments').val('');
                
                // Add new reply to the conversation
                if (response.reply) {
                    const replyHtml = `
                        <div class="border-bottom mb-3 pb-3">
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-lg avatar-rounded me-2 flex-shrink-0">
                                        <img src="${response.reply.avatar}" alt="Img">
                                    </span>
                                    <div>
                                        <h6 class="mb-1">
                                            ${response.reply.user_name}
                                            ${response.reply.is_admin ? '<span class="badge badge-danger badge-xs ms-1">Admin</span>' : ''}
                                        </h6>
                                        <p class="mb-0"><i class="ti ti-calendar-bolt me-1"></i>${response.reply.created_at}</p>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <p style="white-space: pre-wrap;">${response.reply.message}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#reply-form').before(replyHtml);
                    
                    // Update comment count
                    const currentCount = parseInt($('.ti-message-circle-share').parent().text().trim().split(' ')[0]);
                    $('.ti-message-circle-share').parent().html(`<i class="ti ti-message-circle-share me-1"></i>${currentCount + 1} Comments`);
                }
                
                // Scroll to success message
                $('html, body').animate({
                    scrollTop: $('#reply-success').offset().top - 100
                }, 500);
                
                // Hide success message after 5 seconds
                setTimeout(function() {
                    $('#reply-success').addClass('d-none');
                }, 5000);
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
                } else {
                    // Other errors
                    $('#reply-error span').text(xhr.responseJSON?.message || 'An error occurred. Please try again.');
                    $('#reply-error').removeClass('d-none');
                }
                
                // Scroll to error
                $('html, body').animate({
                    scrollTop: $('#reply-form').offset().top - 100
                }, 500);
            },
            complete: function() {
                // Re-enable submit button
                $submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });
});
</script>
@endpush
