<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterServicesRequest;
use App\Http\Requests\Api\StoreServiceStep1Request;
use App\Http\Requests\Api\StoreServiceStep2Request;
use App\Http\Requests\Api\StoreServiceStep3Request;
use App\Http\Requests\Api\StoreServiceStep4Request;
use App\Http\Requests\Api\StoreServiceStep5Request;
use App\Http\Requests\Api\UpdateServiceRequest;
use App\Http\Resources\DynamicFieldResource;
use App\Http\Resources\ServiceDetailsResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Services\Api\ServiceManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function index(FilterServicesRequest $request)
    {
        $services = $this->service->getAllServices($request->validated());

        return successResponse(ServiceResource::collection($services)->response()->getData(true));
    }

    public function getMyServices(FilterServicesRequest $request)
    {
        $businessAccountId = auth('api')->user()->businessAccount->id;

        $services = $this->service->getAllServices($request->validated(), $businessAccountId);

        return successResponse(ServiceResource::collection($services)->response()->getData(true));
    }

    public function show(Service $service)
    {
        $service = $this->service->showServiceDetails($service);

        return successResponse(ServiceDetailsResource::make($service));
    }

    public function showMyService(Service $service)
    {
        $businessAccountId = auth('api')->user()->businessAccount->id;

        $service = $this->service->showServiceDetails($service, $businessAccountId);

        return successResponse(ServiceDetailsResource::make($service));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $updatedService = $this->service->updateService($service, $request->validated());

        return successResponse(ServiceDetailsResource::make($updatedService));
    }

    public function deleteMedia(Service $service, $mediaId)
    {
        $this->service->deleteMedia($service, $mediaId);

        return successResponse();
    }

    public function destroy(Service $service)
    {
        $this->service->deleteService($service);

        return successResponse();
    }
}
