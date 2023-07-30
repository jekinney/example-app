<?php

namespace App\Policies;

use App\Models\{
    User,
    Message
};

class MessagePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Message $message): bool
    {
        return $message->author()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        return $this->update($user, $message);
    }
}
