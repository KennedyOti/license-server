<?php

namespace App\Observers;

use App\Jobs\DeliverWebhook;
use App\Models\License;
use App\Models\RevocationList;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;

class LicenseObserver
{
    protected AuditService $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Handle the License "created" event.
     */
    public function created(License $license): void
    {
        $this->auditService->log($license, 'created', Auth::user());

        // Trigger webhook
        DeliverWebhook::dispatch($license->company, 'license.created', [
            'license_id' => $license->id,
            'company_id' => $license->company_id,
            'product_id' => $license->product_id,
            'external_user_id' => $license->external_user_id,
            'status' => $license->status,
            'start_date' => $license->start_date->toISOString(),
            'end_date' => $license->end_date->toISOString(),
            'plan_id' => $license->plan_id,
            'features' => $license->combined_features,
            'created_at' => $license->created_at->toISOString(),
        ]);
    }

    /**
     * Handle the License "updated" event.
     */
    public function updated(License $license): void
    {
        $changes = $license->getChanges();
        $original = $license->getOriginal();

        $oldValues = [];
        $newValues = [];

        foreach ($changes as $field => $newValue) {
            if (isset($original[$field])) {
                $oldValues[$field] = $original[$field];
                $newValues[$field] = $newValue;
            }
        }

        $this->auditService->log($license, 'updated', Auth::user(), $oldValues, $newValues);

        // Trigger webhook if status changed
        if (isset($changes['status'])) {
            $event = match($changes['status']) {
                'revoked' => 'license.revoked',
                default => 'license.updated'
            };

            // Add to revocation list if revoked
            if ($changes['status'] === 'revoked') {
                RevocationList::create([
                    'license_id' => $license->id,
                    'revoked_at' => now(),
                ]);
            }

            DeliverWebhook::dispatch($license->company, $event, [
                'license_id' => $license->id,
                'company_id' => $license->company_id,
                'product_id' => $license->product_id,
                'external_user_id' => $license->external_user_id,
                'status' => $license->status,
                'start_date' => $license->start_date->toISOString(),
                'end_date' => $license->end_date->toISOString(),
                'plan_id' => $license->plan_id,
                'features' => $license->combined_features,
                'updated_at' => $license->updated_at->toISOString(),
            ]);
        }
    }

    /**
     * Handle the License "deleted" event.
     */
    public function deleted(License $license): void
    {
        $this->auditService->log($license, 'deleted', Auth::user());
    }
}
