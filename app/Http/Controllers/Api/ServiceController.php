<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceStep1Request;
use App\Http\Requests\Api\StoreServiceStep2Request;
use App\Http\Requests\Api\StoreServiceStep3Request;
use App\Http\Requests\Api\StoreServiceStep4Request;
use App\Http\Requests\Api\StoreServiceStep5Request;
use App\Http\Resources\DynamicFieldResource;
use App\Models\Service;
use App\Services\Api\ServiceManagementService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(protected ServiceManagementService $service) {}

    public function initialize(StoreServiceStep1Request $request)
    {
        $service = $this->service->initialize($request->validated());

        return successResponse(['service_id' => $service->id]);
    }

    public function updateDetails(StoreServiceStep2Request $request, Service $service)
    {
        $this->service->updateDetails($request->validated(), $service);

        return successResponse();
    }

    public function updateMedia(StoreServiceStep3Request $request, Service $service)
    {
        $dynamicFields = $this->service->updateMedia($request->validated(), $service);

        return successResponse(DynamicFieldResource::collection($dynamicFields));
    }

    public function syncDynamicFields(StoreServiceStep4Request $request, Service $service)
    {
        $this->service->syncDynamicFields($request->validated(), $service);

        return successResponse();
    }

    public function submitService(StoreServiceStep5Request $request, Service $service)
    {
        $this->service->submitService($request->validated(), $service);

        return successResponse();
    }
}
