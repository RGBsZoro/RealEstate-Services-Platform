<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
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
            'user_id' => $this->user_id,
            'service_id' => $this->service_id,
            
            'service' => $this->whenLoaded('service', function () {
                return [
                    'id' => $this->service->id,
                    'title' => $this->service->title
                ];
            }),

            'requester_business_account_id' => $this->requester_business_account_id,
            
            'requesterBusinessAccount' => $this->whenLoaded('requesterBusinessAccount', function () {
                return [
                    'id' => $this->requesterBusinessAccount->id,
                    'name' => $this->requesterBusinessAccount->name
                ];
            }),

            'provider_business_account_id' => $this->provider_business_account_id,
            
            'providerBusinessAccount' => $this->whenLoaded('providerBusinessAccount', function () {
                return [
                    'id' => $this->providerBusinessAccount->id,
                    'name' => $this->providerBusinessAccount->name
                ];
            }),

            'required_at' => $this->required_at,
            'price_syp'   => $this->price_syp_at_request,
            'price_usd'   => $this->price_usd_at_request,
            'details'     => $this->details,
            'quantity'    => $this->quantity,
            'status'      => $this->status
        ];
    }
}
