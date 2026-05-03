<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(protected SliderService $slider) {}

    public function index()
    {
        $sliders = $this->slider->getAllSlidersForApi();

        return successResponse(SliderResource::collection($sliders));
    }
}
