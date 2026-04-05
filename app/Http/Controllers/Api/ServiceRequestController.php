<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequestOrder;
use App\Http\Resources\ServiceRequestResource;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Services\Api\ServiceRequestService;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function __construct(protected ServiceRequestService $serviceRequest) {}

    public function store(StoreServiceRequestOrder $request)
    {
        $this->serviceRequest->store($request->validated());

        return successResponse();
    }
    public function approve(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest->updateStatus('approved', $serviceRequest);

        return successResponse();
    }

    public function reject(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest->updateStatus('rejected', $serviceRequest);

        return successResponse();
    }

    public function sentRequest()
    {
        $sentRequest = $this->serviceRequest->sentRequest();

        return successResponse(ServiceRequestResource::collection($sentRequest));
    }

    public function recivedRequest()
    {
        $recivedRequest = $this->serviceRequest->recivedRequest();

        return successResponse(ServiceRequestResource::collection($recivedRequest));
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest->destroy($serviceRequest);

        return successResponse();
    }
}
