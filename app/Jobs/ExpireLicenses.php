<?php

namespace App\Jobs;

use App\Models\License;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExpireLicenses implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $expiredCount = License::where('status', 'active')
            ->where('end_date', '<', now())
            ->update(['status' => 'expired']);

        Log::info("Expired {$expiredCount} licenses");
    }
}
