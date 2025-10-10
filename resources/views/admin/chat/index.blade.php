@extends('admin.layouts.app')

@section('title', 'Chat')

@section('content')
<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
    <div class="my-auto mb-2">
        <h2 class="mb-1">Chat</h2>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}"><i class="ti ti-smart-home"></i></a>
                </li>
                <li class="breadcrumb-item">
                    Application
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chat</li>
            </ol>
        </nav>
    </div>
</div>

<div class="chat-wrapper">
    <!-- Chats sidebar -->
    <div class="sidebar-group">
        <div id="chats" class="sidebar-content active slimscroll">
            <div class="slimscroll">
                
                <!-- Chat List Header -->
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="mb-0">Chats</h5>
                </div>

                <!-- Search -->
                <div class="p-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" id="search-conversations" class="form-control border-start-0" placeholder="Search For Contacts or Messages">
                    </div>
                </div>

                <!-- Chat List Title -->
                <div class="px-3">
                    <h6 class="fw-semibold">All Chats</h6>
                </div>

                <!-- Conversations List -->
                <ul class="user-list mb-3" id="conversations-list">
                    <li class="text-center py-4">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <!-- / Chats sidebar -->

    <!-- Chat -->
    <div class="chat chat-messages" id="middle">
        <div>
            <!-- Chat Header -->
            <div class="chat-header">
                <div class="user-details">
                    <div class="d-xl-none">
                        <a class="text-muted chat-close me-2" href="javascript:void(0);">
                            <i class="ti ti-arrow-left"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg online flex-shrink-0">
                            <img src="{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}" class="rounded-circle" alt="image">
                        </div>
                        <div class="ms-2 overflow-hidden">
                            <h6 id="chat-user-name">Select a conversation</h6>
                            <p class="text-truncate mb-0" id="chat-user-status">Click a chat to start messaging</p>
                        </div>
                    </div>
                </div>
                <div class="chat-options">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Refresh">
                                <i class="ti ti-refresh"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Chat Header -->

            <!-- Chat Body -->
            <div class="chat-body chat-page-group slimscroll" id="chat-body">
                <div class="messages text-center py-5">
                    <i class="ti ti-message-circle fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Select a conversation to start chatting</p>
                </div>
            </div>
            <!-- /Chat Body -->

        </div>

        <!-- Chat Footer -->
        <div class="chat-footer" id="chat-footer" style="display: none;">
            <form id="chat-form" class="footer-form">
                @csrf
                <input type="hidden" id="conversation-id" name="conversation_id">
                
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <input type="text" id="message-input" name="message" class="form-control" placeholder="Type Your Message" autocomplete="off" required>
                    </div>
                    <div class="ms-2">
                        <button type="submit" class="btn btn-primary btn-icon">
                            <i class="ti ti-send"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Chat Footer -->
    </div>
    <!-- /Chat -->
</div>
@endsection

@push('scripts')
<script>
let currentConversationId = null;
let messagePolling = null;
const isAdmin = {{ $isAdmin ? 'true' : 'false' }};

// Load conversations on page load
$(document).ready(function() {
    loadConversations();
    
    // Poll for new messages every 5 seconds
    setInterval(loadConversations, 5000);
});

// Load conversations list
function loadConversations() {
    $.ajax({
        url: '{{ route('admin.chat.conversations') }}',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                renderConversations(response.conversations);
                
                // Auto-select first conversation for regular users
                if (!isAdmin && response.conversations.length > 0 && !currentConversationId) {
                    selectConversation(response.conversations[0].id);
                }
            }
        },
        error: function(xhr) {
            console.error('Error loading conversations:', xhr);
        }
    });
}

// Render conversations in sidebar
function renderConversations(conversations) {
    const list = $('#conversations-list');
    
    if (conversations.length === 0) {
        list.html('<li class="text-center py-4 text-muted">No conversations yet</li>');
        return;
    }
    
    let html = '';
    conversations.forEach(conversation => {
        const isActive = currentConversationId === conversation.id ? 'active' : '';
        const unreadBadge = conversation.unread_count > 0 
            ? `<span class="badge bg-danger rounded-pill">${conversation.unread_count}</span>` 
            : '';
        
        html += `
            <li class="chat-user-list ${isActive}" data-conversation-id="${conversation.id}" onclick="selectConversation(${conversation.id})">
                <a href="javascript:void(0);" class="d-flex align-items-center">
                    <div class="avatar avatar-md online flex-shrink-0">
                        <img src="{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}" class="rounded-circle" alt="User">
                    </div>
                    <div class="ms-2 overflow-hidden flex-grow-1">
                        <h6 class="text-truncate mb-0">${conversation.user.name}</h6>
                        <p class="text-truncate text-muted mb-0">
                            ${conversation.last_message ? conversation.last_message.message : 'No messages yet'}
                        </p>
                    </div>
                    <div class="chat-time ms-2 text-end flex-shrink-0">
                        <span class="text-muted fs-10 d-block mb-1">
                            ${conversation.last_message ? conversation.last_message.created_at : ''}
                        </span>
                        ${unreadBadge}
                    </div>
                </a>
            </li>
        `;
    });
    
    list.html(html);
}

// Select a conversation and load messages
function selectConversation(conversationId) {
    currentConversationId = conversationId;
    
    // Update active state
    $('.chat-user-list').removeClass('active');
    $(`.chat-user-list[data-conversation-id="${conversationId}"]`).addClass('active');
    
    // Load messages
    loadMessages(conversationId);
    
    // Show chat footer
    $('#chat-footer').show();
    $('#conversation-id').val(conversationId);
    
    // Start polling for new messages
    if (messagePolling) {
        clearInterval(messagePolling);
    }
    messagePolling = setInterval(() => loadMessages(conversationId), 3000);
}

// Load messages for a conversation
function loadMessages(conversationId) {
    $.ajax({
        url: `/chat/${conversationId}/messages`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                renderMessages(response.messages);
                updateChatHeader(response.conversation);
            }
        },
        error: function(xhr) {
            console.error('Error loading messages:', xhr);
        }
    });
}

// Render messages in chat body
function renderMessages(messages) {
    const chatBody = $('#chat-body');
    
    if (messages.length === 0) {
        chatBody.html(`
            <div class="messages text-center py-5">
                <i class="ti ti-message-circle fs-1 text-muted"></i>
                <p class="text-muted mt-2">No messages yet. Start the conversation!</p>
            </div>
        `);
        return;
    }
    
    let html = '<div class="messages">';
    messages.forEach(message => {
        const messageClass = message.is_own ? 'chat-msg-right' : 'chat-msg-left';
        const avatar = message.is_own 
            ? '{{ asset('admin/assets/img/profiles/avatar-01.jpg') }}' 
            : '{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}';
        
        html += `
            <div class="chats ${messageClass}">
                <div class="chat-avatar">
                    <img src="${avatar}" class="rounded-circle" alt="User">
                </div>
                <div class="chat-content">
                    <div class="chat-profile-name">
                        <h6>${message.sender.name}<span class="ms-2 fs-10">${message.created_at}</span></h6>
                    </div>
                    <div class="message-content">${escapeHtml(message.message)}</div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    chatBody.html(html);
    
    // Scroll to bottom
    chatBody.scrollTop(chatBody[0].scrollHeight);
}

// Update chat header with conversation info
function updateChatHeader(conversation) {
    $('#chat-user-name').text(conversation.user);
    $('#chat-user-status').text('Online');
}

// Send message
$('#chat-form').on('submit', function(e) {
    e.preventDefault();
    
    const messageInput = $('#message-input');
    const message = messageInput.val().trim();
    
    if (!message) return;
    
    $.ajax({
        url: '{{ route('admin.chat.send') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            conversation_id: currentConversationId,
            message: message
        },
        success: function(response) {
            if (response.success) {
                messageInput.val('');
                loadMessages(currentConversationId);
                loadConversations();
            }
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr);
            alert('Failed to send message. Please try again.');
        }
    });
});

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Search conversations
$('#search-conversations').on('input', function() {
    const searchTerm = $(this).val().toLowerCase();
    $('.chat-user-list').each(function() {
        const name = $(this).find('h6').text().toLowerCase();
        const message = $(this).find('p').text().toLowerCase();
        
        if (name.includes(searchTerm) || message.includes(searchTerm)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});
</script>

<style>
.chat-wrapper {
    display: flex;
    height: calc(100vh - 200px);
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.sidebar-group {
    width: 350px;
    border-right: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.chat {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-body {
    flex: 1;
    padding: 1.5rem;
    overflow-y: auto;
}

.chat-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.chat-user-list {
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: background 0.2s;
    border-bottom: 1px solid #f3f4f6;
}

.chat-user-list:hover {
    background: #f9fafb;
}

.chat-user-list.active {
    background: #eff6ff;
    border-left: 3px solid #3b82f6;
}

.chats {
    display: flex;
    margin-bottom: 1.5rem;
}

.chat-msg-right {
    flex-direction: row-reverse;
}

.chat-msg-right .chat-content {
    align-items: flex-end;
}

.chat-msg-right .message-content {
    background: #3b82f6;
    color: #fff;
}

.chat-avatar {
    margin: 0 0.75rem;
}

.chat-avatar img {
    width: 40px;
    height: 40px;
}

.message-content {
    background: #f3f4f6;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    max-width: 500px;
    word-wrap: break-word;
}

.chat-profile-name h6 {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

@media (max-width: 768px) {
    .sidebar-group {
        width: 100%;
    }
    
    .chat {
        display: none;
    }
    
    .chat.show {
        display: flex;
    }
}
</style>
@endpush
