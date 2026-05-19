<?php

namespace App\Console\Commands;

use App\Enum\ServiceRequestStatusEnum;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateServiceRequestStatuses extends Command
{
    protected $signature = 'service-requests:update-status';
    protected $description = 'Auto-complete or expire service requests based on time';

    public function handle()
    {
        $now = Carbon::now();

        $completedCount = ServiceRequest::where('status', ServiceRequestStatusEnum::APPROVED->value)
            ->where('required_at', '<', $now)
            ->update(['status' => ServiceRequestStatusEnum::COMPLETED->value]);

        $expiredCount = ServiceRequest::where('status', ServiceRequestStatusEnum::PENDING->value)
            ->where('required_at', '<', $now)
            ->update(['status' => ServiceRequestStatusEnum::EXPIRED->value]);

        $this->info("Successfully completed {$completedCount} and expired {$expiredCount} requests.");
    }
}
