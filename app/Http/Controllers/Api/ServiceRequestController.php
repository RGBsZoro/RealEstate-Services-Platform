<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequestOrder;
use App\Http\Requests\Api\UpdateServiceRequestOrderRequest;
use App\Http\Resources\ServiceRequestResource;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Services\Api\ServiceRequestService;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function __construct(protected ServiceRequestService $serviceRequest) {}

    public function index()
    {
        $requests = $this->serviceRequest->getAllMyRequests();

        return successResponse([
            'sent_requests' => ServiceRequestResource::collection($requests['sent'])->response()->getData(true),
            'received_requests' => ServiceRequestResource::collection($requests['received'])->response()->getData(true),
        ]);
    }

    public function getBookedTimeSlots(Service $service)
    {
        $timeSlots = $this->serviceRequest->getBookedTimeSlots($service);

        return successResponse($timeSlots);
    }

    public function getMyCalendarEvents(Request $request)
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        $calender = $this->serviceRequest->getMyCalendarEvents($startDate, $endDate);

        return successResponse($calender);
    }

    public function store(StoreServiceRequestOrder $request)
    {
        $this->serviceRequest->store($request->validated());

        return successResponse();
    }

    public function update(UpdateServiceRequestOrderRequest $request, ServiceRequest $serviceRequest)
    {
        $this->serviceRequest->update($request->validated(), $serviceRequest);

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


    public function cancel(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest->cancel($serviceRequest);

        return successResponse();
    }
}
