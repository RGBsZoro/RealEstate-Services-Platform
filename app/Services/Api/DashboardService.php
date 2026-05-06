<?php

namespace App\Services\Api;

use App\Enum\StatusEnum;
use App\Models\BusinessAccount;
use App\Models\Service;
use App\Models\ServiceReport;
use App\Models\ServiceRequest;

class DashboardService
{
    public function getStatistics()
    {
        return [
            'pending_business_accounts' => BusinessAccount::where('status', StatusEnum::PENDING->value)->count(),
            'total_business_accounts' => BusinessAccount::where('status', StatusEnum::APPROVED->value)->count(),

            'pending_services' => Service::where('status', StatusEnum::PENDING->value)->count(),
            'total_services' => Service::where('status', StatusEnum::APPROVED->value)->count(),

            'total_service_requests' => ServiceRequest::count(),
            'pending_reports' => ServiceReport::where('status', 'pending')->count(),
        ];
    }
}
