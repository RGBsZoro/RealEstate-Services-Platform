<?php

namespace App\Services\Api;

use App\Models\Service;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }
    public function store(array $data, Service $service)
    {
        $hasValidRequest = $this->user->serviceRequests()
            ->where('service_id', $service->id)
            ->where('status', 'approved')
            ->where('required_at', '<', now())
            ->where('required_at', '>=', now()->subDay())
            ->exists();

        if (!$hasValidRequest)
            throw ValidationException::withMessages(['service_request' => 'You must have an approved request in the last 24 hours to rate this service.']);

        $this->user->reviews()->updateOrCreate(
            ['service_id' => $service->id],
            [
                'service_id' => $service->id,
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null
            ]
        );
    }

    public function allReviewsOnService(Service $service)
    {
        return $service->reviews()->with('user')->latest()->cursorPaginate(15);
    }
}
