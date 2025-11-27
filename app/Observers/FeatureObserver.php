<?php

namespace App\Observers;

use App\Models\Feature;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;

class FeatureObserver
{
    protected AuditService $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function created(Feature $feature): void
    {
        $this->auditService->log($feature, 'created', Auth::user());
    }

    public function updated(Feature $feature): void
    {
        $changes = $feature->getChanges();
        $original = $feature->getOriginal();

        $oldValues = [];
        $newValues = [];

        foreach ($changes as $field => $newValue) {
            if (isset($original[$field])) {
                $oldValues[$field] = $original[$field];
                $newValues[$field] = $newValue;
            }
        }

        $this->auditService->log($feature, 'updated', Auth::user(), $oldValues, $newValues);
    }

    public function deleted(Feature $feature): void
    {
        $this->auditService->log($feature, 'deleted', Auth::user());
    }
}
