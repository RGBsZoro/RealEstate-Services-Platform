<?php

namespace App;

use App\Models\Service;
use App\Models\ServiceReport;

class ServiceReportService
{
    public function store(array $data, Service $service)
    {
        $service->reports()->create([
            'user_id' => auth('api')->id(),
            'description' => $data['description'] ?? null,
            'reason' => $data['reason'],
        ]);
    }

    public function index(array $data)
    {
        $reports = ServiceReport::with(['service', 'user'])
            ->when($data['search'] ?? null, function ($q, $search) {
                $q->where('reason', 'like', "%{$search}%")
                    ->orWhereHas('service', function ($s) use ($search) {
                        $s->where('name', 'like', "%{$search}%");
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
