<?php

namespace App\Http\Controllers;

use App\Models\{
    Message,
    Comment
};
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class CommentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Message $message): View
    {
        return view('comments.create', compact('message'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Message $message, Comment $comment): RedirectResponse
    {
        $comment->store($request, $message);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment): View
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $comment->renew($request);

        return redirect()->route('messages.show', $comment->message_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->remove();

        return back();
    }
}
