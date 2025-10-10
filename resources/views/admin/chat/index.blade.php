@extends('admin.layouts.app')

@section('title', 'Chat')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Breadcrumb -->
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
            <!-- /Breadcrumb -->


            <div class="chat-wrapper">
                <!-- Chats sidebar -->
                <div class="sidebar-group">
                    <div id="chats" class="sidebar-content active slimscroll">
                        <div class="d-flex align-items-center chat-header">
                            <h5>Chats</h5>
                            <ul class="list-inline ms-auto mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#newChatModal">
                                        <i class="ti ti-circle-plus"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="search-section">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-conversations" placeholder="Search here">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                            </div>
                        </div>
                        <h6 class="user-title mb-0">All Chats</h6>
                        <ul class="user-list" id="conversations-list">
                            <li class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- / Chats sidebar -->

                <!-- Chat -->
                <div class="chat chat-messages show" id="middle">
                    <div class="chat-header">
                        <div class="user-details" id="user-details">
                            <div class="d-lg-none">
                                <a class="text-muted me-2 back_user_list" href="javascript:void(0);">
                                    <i class="ti ti-arrow-left"></i>
                                </a>
                            </div>
                            <figure class="avatar ms-1">
                                <img src="{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}" class="rounded-circle" alt="image">
                            </figure>
                            <div class="mt-1">
                                <h5 id="chat-user-name">Select a conversation</h5>
                                <small class="last-seen" id="chat-user-status">
                                    Click a chat to start messaging
                                </small>
                            </div>
                        </div>
                        <div class="chat-options">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="javascript:void(0)" class="btn btn-outline-light" data-bs-toggle="dropdown">
                                        <i class="ti ti-search"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn btn-outline-light no-bg" href="#" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            <span><i class="ti ti-user-circle"></i></span>Profile
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            <span><i class="ti ti-volume-off"></i></span>Mute
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            <span><i class="ti ti-trash"></i></span>Delete
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="chat-body slimscroll" id="chat-body">
                        <div class="messages text-center py-5">
                            <p class="text-muted">Select a conversation to view messages</p>
                        </div>
                    </div>

                    <div class="chat-footer" id="chat-footer" style="display: none;">
                        <form class="footer-form" id="chat-form">
                            @csrf
                            <input type="hidden" id="conversation-id" name="conversation_id">
                            <div class="smile-col">
                                <a href="javascript:void(0);"><i class="ti ti-mood-smile"></i></a>
                            </div>
                            <div class="attach-col">
                                <a href="javascript:void(0);"><i class="ti ti-paperclip"></i></a>
                            </div>
                            <input type="text" class="form-control chat_form" id="message-input" name="message"
                                placeholder="Enter Message....." autocomplete="off" required>
                            <div class="form-buttons">
                                <button class="btn send-btn" type="submit">
                                    <i class="ti ti-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Chat -->
            </div>

            <!-- New Chat Modal -->
            <div class="modal fade" id="newChatModal" tabindex="-1" aria-labelledby="newChatModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newChatModalLabel">Start New Conversation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="user-select" class="form-label">Select User</label>
                                <select class="form-select" id="user-select">
                                    <option value="">Loading users...</option>
                                </select>
                            </div>
                            <div id="user-search-error" class="alert alert-danger d-none"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="start-chat-btn">Start Chat</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentConversationId = null;
        let currentChannel = null;

        // Initialize Echo (already loaded via app.js)
        if (typeof window.Echo === 'undefined') {
            console.error('Laravel Echo not loaded. Make sure you have run npm run build');
        }

        // Load conversations on page load
        $(document).ready(function () {
            loadConversations();
            loadUsers();
        });

        // Load users for new chat
        function loadUsers() {
            $.ajax({
                url: '{{ route('admin.chat.users') }}',
                method: 'GET',
                success: function (response) {
                    const userSelect = $('#user-select');
                    userSelect.html('<option value="">Select a user...</option>');

                    if (response.success && response.users && response.users.length > 0) {
                        response.users.forEach(user => {
                            userSelect.append(`<option value="${user.id}">${user.name} (${user.email})</option>`);
                        });
                    } else {
                        userSelect.html('<option value="">No users available</option>');
                    }
                },
                error: function (xhr) {
                    console.error('Error loading users:', xhr);
                    $('#user-select').html('<option value="">Error loading users</option>');
                }
            });
        }

        // Start new chat
        $('#start-chat-btn').on('click', function () {
            const userId = $('#user-select').val();

            if (!userId) {
                $('#user-search-error').removeClass('d-none').text('Please select a user');
                return;
            }

            $('#user-search-error').addClass('d-none');

            // Create new conversation
            $.ajax({
                url: '{{ route('admin.chat.send') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    recipient_id: userId,
                    message: 'Hi!'
                },
                success: function (response) {
                    if (response.success) {
                        // Close modal
                        $('#newChatModal').modal('hide');
                        // Reload conversations
                        loadConversations();
                        // Open the new conversation
                        selectConversation(response.conversation_id);
                    }
                },
                error: function (xhr) {
                    console.error('Error starting chat:', xhr);
                    $('#user-search-error').removeClass('d-none').text('Failed to start conversation');
                }
            });
        });

        // Load conversations list
        function loadConversations() {
            $.ajax({
                url: '{{ route('admin.chat.conversations') }}',
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                        renderConversations(response.conversations);
                    }
                },
                error: function (xhr) {
                    console.error('Error loading conversations:', xhr);
                }
            });
        }

        // Render conversations in sidebar
        function renderConversations(conversations) {
            const list = $('#conversations-list');

            if (conversations.length === 0) {
                list.html(`
                    <li class="text-center py-5">
                        <div class="mb-3">
                            <i class="ti ti-message-off" style="font-size: 3rem; color: #dee2e6;"></i>
                        </div>
                        <p class="text-muted mb-2">No conversations yet</p>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newChatModal">
                            <i class="ti ti-plus"></i> Start New Chat
                        </button>
                    </li>
                `);
                return;
            }

            let html = '';
            conversations.forEach(conversation => {
                const isActive = currentConversationId === conversation.id ? 'active' : '';
                const unreadBadge = conversation.unread_count > 0
                    ? `<span class="badge badge-success badge-pill">${conversation.unread_count}</span>`
                    : '';

                const otherUser = conversation.other_user;
                const lastMessage = conversation.last_message;
                
                const messagePreview = lastMessage 
                    ? (lastMessage.message.length > 30 ? lastMessage.message.substring(0, 30) + '...' : lastMessage.message)
                    : 'No messages yet';

                const messageTime = lastMessage ? lastMessage.created_at : '';

                html += `
                <li class="user-list-item ${isActive}" data-conversation-id="${conversation.id}">
                    <a href="javascript:void(0);">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}" class="rounded-circle" alt="${otherUser.name}">
                        </div>
                        <div class="users-list-body">
                            <div>
                                <h5>${otherUser.name}</h5>
                                <p>${messagePreview}</p>
                            </div>
                            <div class="last-chat-time">
                                <small class="text-muted">${messageTime}</small>
                                ${unreadBadge}
                            </div>
                        </div>
                    </a>
                </li>
            `;
            });

            list.html(html);
        }

        // Select a conversation and load messages
        $(document).on('click', '.user-list-item', function () {
            const cid = $(this).data('conversation-id');
            selectConversation(cid);
        });

        function selectConversation(conversationId) {
            currentConversationId = conversationId;

            // Leave previous channel
            if (currentChannel) {
                window.Echo.leave(`chat.${currentChannel}`);
            }

            // Update active state
            $('.user-list-item').removeClass('active');
            $(`.user-list-item[data-conversation-id="${conversationId}"]`).addClass('active');

            // Load messages
            loadMessages(conversationId);

            // Show chat footer
            $('#chat-footer').show();
            $('#conversation-id').val(conversationId);

            // Subscribe to this conversation's channel
            currentChannel = conversationId;
            window.Echo.private(`chat.${conversationId}`)
                .listen('.message.sent', (e) => {
                    console.log('New message received:', e);
                    appendMessage(e);
                    loadConversations(); // Refresh conversation list
                });
        }

        // Load messages for a conversation
        function loadMessages(conversationId) {
            const messagesUrl = "{{ route('admin.chat.messages', ['conversation' => '__ID__']) }}".replace('__ID__', conversationId);
            $.ajax({
                url: messagesUrl,
                method: 'GET',
                success: function (response) {
                    if (response.success) {
                        renderMessages(response.messages);
                        updateChatHeader(response.conversation);
                    }
                },
                error: function (xhr) {
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
                        <i class="ti ti-message-circle" style="font-size: 3rem; color: #dee2e6;"></i>
                        <p class="text-muted mt-3">No messages yet. Start the conversation!</p>
                    </div>
                `);
                return;
            }

            let html = '<div class="messages">';
            
            messages.forEach(message => {
                const isMine = message.is_own;
                const avatar = isMine
                    ? '{{ asset('admin/assets/img/profiles/avatar-01.jpg') }}'
                    : '{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}';

                const readStatus = message.is_read 
                    ? '<span class="msg-read success"><i class="ti ti-checks"></i></span>'
                    : '<span class="msg-read"><i class="ti ti-check"></i></span>';

                if (isMine) {
                    // Sent message (right aligned)
                    html += `
                    <div class="chats chats-right">
                        <div class="chat-content">
                            <div class="chat-info">
                                <div class="chat-actions">
                                    <a class="#" href="#" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-2"></i>Copy</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>   
                                <div class="message-content">
                                    ${escapeHtml(message.message)}
                                </div>   
                            </div>
                            <div class="chat-profile-name text-end">
                                <h6>You<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${message.created_at}</span>${readStatus}</h6>
                            </div>
                        </div>
                        <div class="chat-avatar">
                            <img src="${avatar}" class="rounded-circle dreams_chat" alt="image">
                        </div>
                    </div>
                    `;
                } else {
                    // Received message (left aligned)
                    html += `
                    <div class="chats">
                        <div class="chat-avatar">
                            <img src="${avatar}" class="rounded-circle" alt="image">
                        </div>
                        <div class="chat-content">
                            <div class="chat-info">
                                <div class="message-content">
                                    ${escapeHtml(message.message)}
                                </div>
                                <div class="chat-actions">
                                    <a class="#" href="#" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-2"></i>Copy</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>   
                            </div>
                            <div class="chat-profile-name">
                                <h6>${message.sender.name}<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${message.created_at}</span></h6>
                            </div>
                        </div>
                    </div>
                    `;
                }
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

        // Append a single message to the chat (real-time)
        function appendMessage(messageData) {
            let chatBody = $('#chat-body .messages');
            if (chatBody.length === 0) {
                $('#chat-body').html('<div class="messages"></div>');
                chatBody = $('#chat-body .messages');
            }

            const isOwn = messageData.sender_id === {{ auth()->id() }};
            const avatar = isOwn
                ? '{{ asset('admin/assets/img/profiles/avatar-01.jpg') }}'
                : '{{ asset('admin/assets/img/profiles/avatar-02.jpg') }}';

            const messageTime = new Date(messageData.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            let messageHtml = '';

            if (isOwn) {
                messageHtml = `
                <div class="chats chats-right">
                    <div class="chat-content">
                        <div class="chat-info">
                            <div class="chat-actions">
                                <a class="#" href="#" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-2"></i>Copy</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>   
                            <div class="message-content">
                                ${escapeHtml(messageData.message)}
                            </div>   
                        </div>
                        <div class="chat-profile-name text-end">
                            <h6>You<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${messageTime}</span><span class="msg-read"><i class="ti ti-check"></i></span></h6>
                        </div>
                    </div>
                    <div class="chat-avatar">
                        <img src="${avatar}" class="rounded-circle dreams_chat" alt="image">
                    </div>
                </div>
                `;
            } else {
                messageHtml = `
                <div class="chats">
                    <div class="chat-avatar">
                        <img src="${avatar}" class="rounded-circle" alt="image">
                    </div>
                    <div class="chat-content">
                        <div class="chat-info">
                            <div class="message-content">
                                ${escapeHtml(messageData.message)}
                            </div>
                            <div class="chat-actions">
                                <a class="#" href="#" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li><a class="dropdown-item" href="#"><i class="ti ti-file-export me-2"></i>Copy</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>   
                        </div>
                        <div class="chat-profile-name">
                            <h6>${messageData.sender.name}<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${messageTime}</span></h6>
                        </div>
                    </div>
                </div>
                `;
            }

            chatBody.append(messageHtml);

            // Scroll to bottom
            const chatBodyContainer = $('#chat-body');
            chatBodyContainer.scrollTop(chatBodyContainer[0].scrollHeight);
        }

        // Send message
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            const messageInput = $('#message-input');
            const message = messageInput.val().trim();

            if (!message) return;

            const conversationId = $('#conversation-id').val();

            $.ajax({
                url: '{{ route('admin.chat.send') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    conversation_id: conversationId,
                    message: message
                },
                success: function (response) {
                    if (response.success) {
                        messageInput.val('');
                        // Message will be added via broadcast
                    }
                },
                error: function (xhr) {
                    console.error('Error sending message:', xhr);
                    alert('Failed to send message');
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
        $('#search-conversations').on('input', function () {
            const searchTerm = $(this).val().toLowerCase();
            $('.user-list-item').each(function () {
                const name = $(this).find('h5').text().toLowerCase();
                const message = $(this).find('p').text().toLowerCase();
                if (name.includes(searchTerm) || message.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>
@endpush
