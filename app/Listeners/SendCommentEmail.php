<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NewCommentCreated;
use App\Notifications\NewComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewCommentCreated $event): void
    {
        foreach (User::whereNot('id', $event->comment->user_id)->cursor() as $user) {
            $user->notify(new NewComment($event->comment));
        }
    }
}
