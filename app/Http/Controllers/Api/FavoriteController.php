<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFavoriteRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Services\Api\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(protected FavoriteService $favoriteService) {}

    public function index()
    {
        $favorites = $this->favoriteService->getUserFavorites(auth('api')->user());

        return successResponse(ServiceResource::collection($favorites));
    }

    public function store(StoreFavoriteRequest $request)
    {
        $this->favoriteService->addFavorite(auth('api')->user(), $request->validated());

        return successResponse();
    }

    public function destroy(Service $service)
    {
        $this->favoriteService->removeFavorite(auth('api')->user(), $service);

        return successResponse();
    }
}
