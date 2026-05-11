<?php

namespace App\Services\Api;

use App\Models\Conversation;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public function getUserConversations(int $userId)
    {
        return Conversation::query()
            ->where('client_id', $userId)
            ->orWhere('provider_id', $userId)
            ->with([
                'service' => function ($query) {
                    $query->select('id', 'title')->with('media');
                },
                'client:id,name',
                'provider:id,name'
            ])
            ->withCount(['messages as unread_messages_count' => function ($query) use ($userId) {
                $query->where('sender_id', '!=', $userId)->where('is_read', false);
            }])
            ->orderByDesc('last_message_at')
            ->cursorPaginate(15);
    }

    public function sendMessage(int $userId, array $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            $service = Service::with('businessAccount')->findOrFail($data['service_id']);
            $providerId = $service->businessAccount->user_id;

            if ($userId === $providerId) {
                abort(403, 'You cannot start a chat with your own service.');
            }

            $conversation = Conversation::firstOrCreate([
                'service_id' => $service->id,
                'client_id' => $userId,
                'provider_id' => $providerId,
            ]);

            $message = $conversation->messages()->create([
                'sender_id' => $userId,
                'body' => $data['body'],
                'is_read' => false,
            ]);

            $conversation->update([
                'last_message_at' => now()
            ]);

            return $message;
        });
    }

    public function getConversationMessages(Conversation $conversation, int $userId)
    {
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return $conversation->messages()
            ->orderByDesc('created_at')
            ->cursorPaginate(30);
    }
}
