<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAccountResource extends JsonResource
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
            'activity_name' => $this->activity->name ?? null,
            'status' => $this->status->value ?? $this->status,
            'current_step' => $this->current_step,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
