<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceReportRequest;
use App\Models\Service;
use App\ServiceReportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ServiceReportController extends Controller
{
    public function __construct(protected ServiceReportService $report) {}
    public function store(StoreServiceReportRequest $request, Service $service)
    {
        $this->report->store($request->validated(), $service);
        return successResponse();
    }
}
