<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\AuditService;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    protected AuditService $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function created(Product $product): void
    {
        $this->auditService->log($product, 'created', Auth::user());
    }

    public function updated(Product $product): void
    {
        $changes = $product->getChanges();
        $original = $product->getOriginal();

        $oldValues = [];
        $newValues = [];

        foreach ($changes as $field => $newValue) {
            if (isset($original[$field])) {
                $oldValues[$field] = $original[$field];
                $newValues[$field] = $newValue;
            }
        }

        $this->auditService->log($product, 'updated', Auth::user(), $oldValues, $newValues);
    }

    public function deleted(Product $product): void
    {
        $this->auditService->log($product, 'deleted', Auth::user());
    }
}
