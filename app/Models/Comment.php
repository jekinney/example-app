<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Events\NewCommentCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    // Set up

    /**
     * Always eager load relationship
     *
     * @var array
     */
    protected $with = ['author'];

    /**
     * Guarded columns from mass assignment
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Dispatch events on model events
     *
     * @var array
     */
    protected $dispatchesEvents = ['created' => NewCommentCreated::class];

    // relationships

    /**
     * Relationship to User model
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship to Message model
     *
     * @return BelongsTo
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    // Queries

    /**
     * Create a new comment attached to a message
     *
     * @param Request $request
     * @param Message $message
     * @return Message
     */
    public function store(Request $request, Message $message): Message
    {
        $request->validate([
            'body' => 'required|string|max:550'
        ]);

        $this->create([
            'body' => $request->body,
            'user_id' => $request->user()->id,
            'message_id' => $message->id,
        ]);

        return $message;
    }

    /**
     * Create a new comment attached to a message
     *
     * @param Request $request
     * @return bool
     */
    public function renew(Request $request): bool
    {
        $request->validate([
            'body' => 'required|string|max:550'
        ]);

        return $this->update([
            'body' => $request->body,
        ]);
    }

    /**
     * Attempt to remove a comment
     *
     * @return boolean
     */
    public function remove(): bool
    {
        return $this->delete();
    }
}
