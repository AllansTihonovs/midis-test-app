<?php

namespace App\Contracts;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface MessageServiceInterface
{
    /**
     * Create a new message
     *
     * @param StoreMessageRequest $request
     * @return Message
     */
    public function createMessage(StoreMessageRequest $request);

    /**
     * Update an existing message
     *
     * @param Message $message
     * @param StoreMessageRequest $request
     * @return Message
     */
    public function updateMessage(Message $message, StoreMessageRequest $request);

    /**
     * Delete an existing message
     *
     * @param Message $message
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteMessage(Message $message, Request $request): RedirectResponse;

    /**
     * @param Message $message
     * @param Request $request
     * @return mixed
     */
    public function canManageMessage(Message $message, Request $request): void;

}
