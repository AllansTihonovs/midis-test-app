<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Contracts\MessageServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param MessageServiceInterface $messageService
     * @return void
     */
    public function __construct(protected MessageServiceInterface $messageService) {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response {
        $messages = Message::orderBy(
                $request->get('sort', 'created_at'),
                $request->get('direction', 'desc')
            )
            ->paginate(10);

        return Inertia::render('Guestbook/MessageList', [
            'messages' => $messages,
            'filters' => $request->only(['sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response {
        return Inertia::render('Guestbook/CreateMessage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessageRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $this->messageService->createMessage($request);

        return redirect()->route('messages.index')->with('success', 'Message submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Message $message
     * @param Request $request
     * @return Response
     */
    public function edit(Message $message, Request $request): Response {
        $this->messageService->canManageMessage($message, $request);

        return Inertia::render('Guestbook/EditMessage', [
            'message' => $message
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Message $message
     * @param StoreMessageRequest $request
     * @return RedirectResponse
     */
    public function update(Message $message, StoreMessageRequest $request): RedirectResponse
    {
        $this->messageService->updateMessage($message, $request);

        return redirect()->route('messages.index')->with('success', 'Message updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param Message $message
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Message $message, Request $request): RedirectResponse
    {
        $this->messageService->deleteMessage($message, $request);

        return redirect()->route('messages.index')->with('success', 'Message deleted.');
    }
}
