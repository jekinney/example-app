<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Message;
use App\Notifications\NewMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessageEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(public Message $message)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        foreach (User::whereNot('id', $event->message->user_id)->cursor() as $user) {
            $user->notify(new NewMessage($event->message));
        }
    }
}
