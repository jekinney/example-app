<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Message $message): View
    {
        return view('messages.index', [
            'messages' => $message->getList($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Message $message): RedirectResponse
    {
        $message = $message->store($request);

        return redirect()->route('messages.show', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message): View
    {
        return view('messages.show', [
            'message' => $message->show()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message): View
    {
        $this->authorize('update', $message);

        return view('messages.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message): RedirectResponse
    {
        $this->authorize('update', $message);

        $message->renew($request);

        return redirect()->route('messages.show', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message): RedirectResponse
    {
        $this->authorize('delete', $message);

        if( $message->remove() ) {
            return redirect()->route('messages.index');
        }
        return back();
    }
}
