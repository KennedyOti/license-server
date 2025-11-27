<?php

namespace App\Jobs;

use App\Jobs\DeliverWebhook;
use App\Models\License;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifyExpiringLicenses implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $expiringSoon = License::where('status', 'active')
            ->where('end_date', '>', now())
            ->where('end_date', '<=', now()->addDays(3))
            ->get();

        foreach ($expiringSoon as $license) {
            DeliverWebhook::dispatch($license->company, 'license.expiring', [
                'license_id' => $license->id,
                'company_id' => $license->company_id,
                'product_id' => $license->product_id,
                'external_user_id' => $license->external_user_id,
                'end_date' => $license->end_date->toISOString(),
                'days_until_expiry' => now()->diffInDays($license->end_date),
            ]);
        }

        Log::info("Notified about {$expiringSoon->count()} expiring licenses");
    }
}
