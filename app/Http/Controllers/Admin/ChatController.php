<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display chat interface
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get recipient user ID from query string (for starting new chat)
        $recipientId = $request->query('user');
        $selectedConversation = null;
        
        if ($recipientId) {
            $recipient = User::find($recipientId);
            if ($recipient) {
                $selectedConversation = ChatConversation::findOrCreateBetween($user->id, $recipientId);
            }
        }
        
        // Get all users for starting new conversations
        $allUsers = User::where('id', '!=', $user->id)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
        
        return view('admin.chat.index', compact('allUsers', 'selectedConversation'));
    }

    /**
     * Get list of conversations for current user
     */
    public function getConversations(Request $request)
    {
        $user = Auth::user();
        
        // Get all conversations where user is a participant
        $conversations = ChatConversation::where('participant_one_id', $user->id)
            ->orWhere('participant_two_id', $user->id)
            ->with(['participantOne', 'participantTwo', 'lastMessage'])
            ->active()
            ->latest()
            ->get()
            ->map(function ($conversation) use ($user) {
                $otherUser = $conversation->otherParticipant($user->id);
                
                return [
                    'id' => $conversation->id,
                    'user' => [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'email' => $otherUser->email,
                    ],
                    'last_message' => $conversation->lastMessage ? [
                        'message' => $conversation->lastMessage->message,
                        'created_at' => $conversation->lastMessage->created_at->diffForHumans(),
                    ] : null,
                    'unread_count' => $conversation->unreadCount($user->id),
                ];
            });
        
        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Get messages for a specific conversation
     */
    public function getMessages(Request $request, $conversationId)
    {
        $user = Auth::user();
        $conversation = ChatConversation::findOrFail($conversationId);
        
        // Authorization check - user must be a participant
        if (!$conversation->hasParticipant($user->id)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) use ($user) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender' => [
                        'id' => $message->sender->id,
                        'name' => $message->sender->name,
                    ],
                    'sender_type' => $message->sender_type,
                    'is_own' => $message->sender_id === $user->id,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at->format('h:i A'),
                    'created_at_full' => $message->created_at->format('M d, Y h:i A'),
                ];
            });
        
        // Mark messages as read (messages from other party)
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        $otherUser = $conversation->otherParticipant($user->id);
        
        return response()->json([
            'success' => true,
            'messages' => $messages,
            'conversation' => [
                'id' => $conversation->id,
                'user' => $otherUser->name,
            ],
        ]);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'nullable|exists:chat_conversations,id',
            'recipient_id' => 'required_without:conversation_id|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);
        
        $user = Auth::user();
        
        // Get or create conversation
        if ($request->conversation_id) {
            $conversation = ChatConversation::findOrFail($request->conversation_id);
            
            // Authorization check
            if (!$conversation->hasParticipant($user->id)) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        } else {
            // Create new conversation with recipient
            $conversation = ChatConversation::findOrCreateBetween($user->id, $request->recipient_id);
        }
        
        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'sender_type' => 'user', // Can be enhanced based on role
            'message' => $request->message,
            'is_read' => false,
        ]);
        
        // Update conversation last_message_at
        $conversation->update(['last_message_at' => now()]);
        
        // Broadcast message to other participant (will implement with Reverb)
        // broadcast(new MessageSent($message))->toOthers();
        
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'sender' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                'sender_type' => $message->sender_type,
                'is_own' => true,
                'created_at' => $message->created_at->format('h:i A'),
                'conversation_id' => $conversation->id,
            ],
        ]);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Request $request, $messageId)
    {
        $message = ChatMessage::findOrFail($messageId);
        $message->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
        ]);
    }
}
