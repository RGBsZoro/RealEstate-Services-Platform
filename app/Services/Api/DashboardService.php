<?php

namespace App\Services\Api;

use App\Enum\StatusEnum;
use App\Models\BusinessAccount;
use App\Models\Service;
use App\Models\ServiceReport;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStatistics()
    {
        $counts = [
            'pending_business_accounts' => BusinessAccount::where('status', StatusEnum::PENDING->value)->count(),
            'total_business_accounts' => BusinessAccount::where('status', StatusEnum::APPROVED->value)->count(),
            'pending_services' => Service::where('status', StatusEnum::PENDING->value)->count(),
            'total_services' => Service::where('status', StatusEnum::APPROVED->value)->count(),
            'total_service_requests' => ServiceRequest::count(),
            'pending_reports' => ServiceReport::where('status', 'pending')->count(),
        ];

        $latestPendingServices = Service::with(['businessAccount', 'category'])
            ->where('status', StatusEnum::PENDING->value)
            ->latest()->take(5)->get();

        $latestPendingAccounts = BusinessAccount::with(['user', 'activity'])
            ->where('status', StatusEnum::PENDING->value)
            ->latest()->take(5)->get();

        // توزيع الخدمات
        $servicesTypeChart = Service::select('type', DB::raw('count(*) as total'))
            ->where('status', StatusEnum::APPROVED->value)
            ->groupBy('type')->pluck('total', 'type')->toArray();

        // منطق متطور لجلب آخر 7 أيام حتى لو كانت البيانات صفرية لضمان ظهور المخطط
        $days = collect(range(6, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $rawWeeklyRequests = ServiceRequest::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')->pluck('total', 'date')->toArray();

        $weeklyRequests = $days->mapWithKeys(function ($date) use ($rawWeeklyRequests) {
            return [$date => $rawWeeklyRequests[$date] ?? 0];
        });

        return array_merge($counts, [
            'latest_pending_accounts' => $latestPendingAccounts,
            'latest_pending_services' => $latestPendingServices,
            'charts' => [
                'services_type' => [
                    'sale' => $servicesTypeChart['sale'] ?? 0,
                    'rent' => $servicesTypeChart['rent'] ?? 0,
                ],
                'weekly_requests' => [
                    'labels' => $weeklyRequests->keys()->toArray(),
                    'data' => $weeklyRequests->values()->toArray(),
                ]
            ]
        ]);
    }
}
