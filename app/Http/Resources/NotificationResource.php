<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->data['title'] ?? null,
            'body'       => $this->data['body'] ?? null,
            'payload'    => $this->data['data'] ?? [], 
            'type'       => $this->data['data']['type'] ?? 'general',
            'read_at'    => $this->read_at ? $this->read_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
