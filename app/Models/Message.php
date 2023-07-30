<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Events\NewMessageCreated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\LengthAwarePaginator;

class Message extends Model
{
    use HasFactory;

    // set up

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
    protected $dispatchesEvents = ['created' => NewMessageCreated::class];


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
     * Relationship to Comment model
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Queries and Helpers

    /**
     * Get the data required to show a message
     *
     * @return Collection
     */
    public function show()
    {
        return $this->load('comments');
    }

    /**
     * Get a list of messages
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function getList(Request $request): LengthAwarePaginator
    {
        // Set pagination amount
        $amount = $request->has('amount')? $request->amount:20;
        // Set filter variables with defaults incase it's missing
        $filterAuthor = $request->has('filter_author')? $request->filter_author:'all';
        $filterDirection = $request->has('filter_direction')? $request->filter_direction:'latest';
        // Start building query
        $query = $this->withCount('comments');
        // Check if user wants just their own messages or not
        // Default is all messages
        if ( $filterAuthor == 'mine') {
            $query = $query->where('user_id', $request->user()->id);
        } elseif ( $filterAuthor == 'other' ) {
            $query = $query->whereNot('user_id', $request->user()->id);
        }
        // Filter direction of oldest or latest messages.
        // Latest is default
        if ( $filterDirection == 'oldest' ) {
            $query = $query->oldest();
        } else {
            $query = $query->latest();
        }
        // Execute the query
        $query = $query->paginate($amount);
        // Add filter data to pagination collection
        $query->filter_author = $filterAuthor;
        $query->filter_direction = $filterDirection;
        // Return data
        return $query;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return Model
     */
    public function store(Request $request): Model
    {
        $request->validate(['body' => 'required|string|max:550']);

        return $this->create([
            'user_id' => $request->user()->id,
            'body' => $request->body
        ]);
    }

    public function renew(Request $request): bool
    {
        $request->validate(['body' => 'required|string|max:550']);

        return $this->update(['body' => $request->body]);
    }

    public function remove()
    {
        return $this->delete();
    }
}
