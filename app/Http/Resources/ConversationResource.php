<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = auth('api')->id();

        $isClient = $this->client_id === $userId;
        $otherParty = $isClient ? $this->provider : $this->client;

        return [
            'id' => $this->id,
            'service' => [
                'id' => $this->service->id,
                'title' => $this->service->title,
                'image' => $this->service->getFirstMediaUrl('main_image_service') ?: null,
            ],
            'other_party' => [
                'id' => $otherParty->id,
                'name' => $otherParty->name,
                'avatar' => $otherParty->getFirstMediaUrl('user-avatars') ?: null,
            ],
            'unread_messages_count' => $this->unread_messages_count ?? 0,
            'last_message_at' => $this->last_message_at ? $this->last_message_at->diffForHumans() : null,
            'last_message' => $this->messages->last()->body ?? null,
        ];
    }
}
