<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    public function log(Model $model, string $action, ?User $actor = null, ?array $oldValues = null, ?array $newValues = null): void
    {
        $entityType = class_basename($model);
        $entityId = $model->getKey();

        AuditLog::create([
            'company_id' => $this->getCompanyId($model),
            'actor_id' => $actor?->id,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'timestamp' => now(),
        ]);
    }

    private function getCompanyId(Model $model): ?int
    {
        if ($model instanceof \App\Models\Company) {
            return $model->id;
        }

        if (method_exists($model, 'company')) {
            return $model->company?->id;
        }

        if (method_exists($model, 'product')) {
            return $model->product?->company?->id;
        }

        return null;
    }
}