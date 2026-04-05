<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Service;
use App\Services\Api\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(protected ReviewService $review) {}

    public function store(StoreReviewRequest $request, Service $service)
    {
        $this->review->store($request->validated(), $service);

        return successResponse();
    }

    public function allReviewsOnService(Service $service)
    {
        $reviews = $this->review->allReviewsOnService($service);

        return successResponse(ReviewResource::collection($reviews));
    }
}
