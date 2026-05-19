<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Service;
use App\Models\ServiceReport;
use App\Notifications\NewServiceReportNotification;
use Illuminate\Support\Facades\Notification;

class ServiceReportService
{
    public function store(array $data, Service $service)
    {
        $report = $service->reports()->create([
            'user_id' => auth('api')->id(),
            'description' => $data['description'] ?? null,
            'reason' => $data['reason'],
        ]);

        $admins = Admin::permission('manage-reports')->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewServiceReportNotification($report));
        }
    }

    public function index(array $data)
    {
        $reports = ServiceReport::with(['service', 'user'])
            ->when($data['search'] ?? null, function ($q, $search) {
                $q->where('reason', 'like', "%{$search}%")
                    ->orWhereHas('service', function ($s) use ($search) {
                        $s->where('title', 'like', "%{$search}%");
                    });
            })
            ->when($data['status'] ?? null, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => ServiceReport::count(),
            'pending' => ServiceReport::where('status', 'pending')->count(),
            'resolved' => ServiceReport::where('status', 'resolved')->count(),
        ];

        return [
            'reports' => $reports,
            'stats' => $stats,
        ];
    }
}
