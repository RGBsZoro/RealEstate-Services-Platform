<?php

namespace App\Console\Commands;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Console\Command;

class CleanUnverifiedAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired OTPs, used OTPs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cleanup OTP Table
        $deletedOtps = OtpCode::where('expires_at', '<', now())
            ->orWhere('is_used', true)
            ->delete();

        $this->info("Deleted {$deletedOtps} expired or used OTP records.");
    }
}
