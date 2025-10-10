<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatConversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = ChatConversation::find($conversationId);
    return $conversation && $conversation->hasParticipant($user->id);
});
