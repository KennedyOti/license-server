<?php

namespace App\Observers;

use App\Models\Plan;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;

class PlanObserver
{
    protected AuditService $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function created(Plan $plan): void
    {
        $this->auditService->log($plan, 'created', Auth::user());
    }

    public function updated(Plan $plan): void
    {
        $changes = $plan->getChanges();
        $original = $plan->getOriginal();

        $oldValues = [];
        $newValues = [];

        foreach ($changes as $field => $newValue) {
            if (isset($original[$field])) {
                $oldValues[$field] = $original[$field];
                $newValues[$field] = $newValue;
            }
        }

        $this->auditService->log($plan, 'updated', Auth::user(), $oldValues, $newValues);
    }

    public function deleted(Plan $plan): void
    {
        $this->auditService->log($plan, 'deleted', Auth::user());
    }
}
