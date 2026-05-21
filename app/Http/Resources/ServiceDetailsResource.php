<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailsResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'type' => $this->type,
            'price_syp' => $this->price_syp,
            'price_usd' => $this->price_usd,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status->value ?? $this->status,

            'main_image' => $this->getFirstMediaUrl('main_image_service') ?: null,
            'gallery' => $this->getMedia('gallery_services')->map(fn($media) => [
                'id' => $media->id,
                'url' => $media->getUrl()
            ]),

            'reviews_count' => $this->reviews_count ?? 0,
            'reviews_avg' => round($this->reviews_avg_rating ?? 0, 1),

            'is_favorite' => $this->handleIsFavorite(),

            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'icon' => $this->category->GetFirstMediaUrl('Categories') ?? null,
            ],

            'business_account' => [
                'id' => $this->businessAccount->id,
                'name' => $this->businessAccount->name,
                'avatar' => $this->businessAccount->user->getFirstMediaUrl('user-avatars') ?: null,
            ],

            'dynamic_fields' => $this->fieldValues->map(function ($fieldValue) {
                return [
                    'id' => $fieldValue->field->id,
                    'name' => $fieldValue->field->label,
                    'value' => $fieldValue->value,
                ];
            }),

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

    protected function handleIsFavorite(): bool
    {
        if (isset($this->is_favorite_exists)) {
            return (bool) $this->is_favorite_exists;
        }
        return false;
    }
}
