<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMessageRequest;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Services\Api\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService) {}

    public function index()
    {
        $conversations = $this->chatService->getUserConversations(auth('api')->id());
        return successResponse(ConversationResource::collection($conversations)->response()->getData(true));
    }

    public function show(Conversation $conversation)
    {
        $messages = $this->chatService->getConversationMessages($conversation, auth('api')->id());
        return successResponse(MessageResource::collection($messages)->response()->getData(true));
    }

    public function store(StoreMessageRequest $request)
    {
        $message = $this->chatService->sendMessage(auth('api')->id(), $request->validated());
        return successResponse(MessageResource::make($message));
    }
}
