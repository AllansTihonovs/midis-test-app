<?php

namespace App\Services;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Contracts\MessageServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageService implements MessageServiceInterface
{
    public function createMessage(StoreMessageRequest $request)
    {
        $imagePath = $this->handleImageUpload($request);

        return Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'image_path' => $imagePath,
            'ip_address' => $request->ip(),
        ]);
    }

    public function updateMessage(Message $message, StoreMessageRequest $request)
    {
        $this->canManageMessage($message, $request);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        if ($newImage = $this->handleImageUpload($request)) {
            $data['image_path'] = $newImage;
        }

        $message->update($data);
    }

    public function deleteMessage(Message $message, Request $request): RedirectResponse {
        $this->canManageMessage($message, $request);
        $message->delete();

        return redirect()->back()->with('success', 'Message deleted.');
    }

    public function canManageMessage(Message $message, Request $request): void
    {
        if ($request->user()) {
            return;
        }

        if ($request->ip() === $message->ip_address && now()->diffInMinutes($message->created_at) <= 5) {
            return;
        }

        abort(403);
    }

    protected function handleImageUpload(Request $request): ?string
    {
        return $request->hasFile('image')
            ? $request->file('image')->store('messages', 'public')
            : null;
    }
}
