<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAccountDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'license_number' => $this->license_number,
            'activities' => $this->activities,
            'details' => $this->details,
            'status' => $this->status->value ?? $this->status,
            'current_step' => $this->current_step,

            'location' => [
                'city_id' => $this->city_id,
                'city_name' => $this->city->name ?? null,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],

            'activity' => [
                'id' => $this->activity_id,
                'name' => $this->activity->name ?? null,
                'icon' => $this->activity->getFirstMediaUrl('Activities') ?? null,
            ],

            'documents' => $this->getMedia('documents')->map(fn($media) => [
                'id' => $media->id,
                'url' => $media->getUrl()
            ]),

            'images' => $this->getMedia('images')->map(fn($media) => [
                'id' => $media->id,
                'url' => $media->getUrl()
            ]),

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
