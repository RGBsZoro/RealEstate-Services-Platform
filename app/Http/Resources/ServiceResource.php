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
            'business_account_id' => $this->business_account_id,
            'name' => $this->name,
            'description' => $this->description,
            'price_usd' => $this->price_usd,
            'price_syp' => $this->price_syp,
        ];
    }
}
