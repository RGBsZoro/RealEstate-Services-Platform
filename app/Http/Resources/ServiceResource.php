<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'price_usd' => $this->price_usd,
            'main_image' => $this->getFirstMediaUrl('main_image_service') ?: null,

            'reviews_count' => $this->reviews_count ?? 0,
            'reviews_avg' => round($this->reviews_avg_rating ?? 0, 1),

            'is_favorite' => $this->handleIsFavorite(),

            'business_account' => [
                'id' => $this->businessAccount->id,
                'name' => $this->businessAccount->name,
            ],
            'created_at' => $this->created_at->format('Y-m-d'),
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
