<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = $this->data;

        $title = isset($data['title_key'])
            ? __($data['title_key'], [], $request->header('Accept-Language'))
            : ($data['title'] ?? '');

        $body = isset($data['body_key'])
            ? __($data['body_key'], $data['body_args'] ?? [], $request->header('Accept-Language'))
            : ($data['body'] ?? '');

        return [
            'id'         => $this->id,
            'title'      => $title,
            'body'       => $body,
            'icon'       => $data['icon'] ?? 'bx-bell',
            'type'       => $data['data']['type'] ?? ($data['type'] ?? 'general'),
            'payload'    => [
                'id'   => $data['data']['id'] ?? null,
                'type' => $data['data']['type'] ?? 'general',
                'url'  => $data['data']['url'] ?? null,
                'reason' => $data['data']['reason'] ?? null,
            ],
            'read_at'    => $this->read_at ? $this->read_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
