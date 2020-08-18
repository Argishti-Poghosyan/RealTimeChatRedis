<?php

namespace App\Broadcasting;

use App\User;

class ConversationChannel
{
    
    public function join(User $user, $chat)
    {
        return $chat->users->contains($user);
    }
}