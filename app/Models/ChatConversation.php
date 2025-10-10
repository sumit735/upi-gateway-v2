<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    protected $fillable = [
        'participant_one_id',
        'participant_two_id',
        'last_message_at',
        'status',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the first participant
     */
    public function participantOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_one_id');
    }

    /**
     * Get the second participant
     */
    public function participantTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_two_id');
    }

    /**
     * Get the other participant in the conversation (not the current user)
     */
    public function otherParticipant(int $currentUserId): ?User
    {
        if ($this->participant_one_id === $currentUserId) {
            return $this->participantTwo;
        }
        return $this->participantOne;
    }

    /**
     * Check if user is a participant in this conversation
     */
    public function hasParticipant(int $userId): bool
    {
        return $this->participant_one_id === $userId || $this->participant_two_id === $userId;
    }

    /**
     * Get conversation between two users
     */
    public static function findByParticipants(int $userIdOne, int $userIdTwo): ?self
    {
        return self::where(function ($query) use ($userIdOne, $userIdTwo) {
            $query->where('participant_one_id', $userIdOne)
                  ->where('participant_two_id', $userIdTwo);
        })->orWhere(function ($query) use ($userIdOne, $userIdTwo) {
            $query->where('participant_one_id', $userIdTwo)
                  ->where('participant_two_id', $userIdOne);
        })->first();
    }

    /**
     * Create or get conversation between two users
     */
    public static function findOrCreateBetween(int $userIdOne, int $userIdTwo): self
    {
        $conversation = self::findByParticipants($userIdOne, $userIdTwo);
        
        if (!$conversation) {
            // Always store smaller ID first for consistency
            [$participantOne, $participantTwo] = $userIdOne < $userIdTwo 
                ? [$userIdOne, $userIdTwo] 
                : [$userIdTwo, $userIdOne];
                
            $conversation = self::create([
                'participant_one_id' => $participantOne,
                'participant_two_id' => $participantTwo,
                'last_message_at' => now(),
            ]);
        }
        
        return $conversation;
    }

    /**
     * Get all messages in this conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    /**
     * Get the last message
     */
    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'conversation_id')->latestOfMany();
    }

    /**
     * Get unread messages count for a specific user
     */
    public function unreadCount(int $userId): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Scope for active conversations
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for conversations ordered by latest message
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('last_message_at', 'desc');
    }
}
