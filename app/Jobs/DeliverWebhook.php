<?php

namespace App\Jobs;

use App\Models\Company;
use App\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeliverWebhook implements ShouldQueue
{
    use Queueable;

    protected Company $company;
    protected string $event;
    protected array $payload;

    /**
     * Create a new job instance.
     */
    public function __construct(Company $company, string $event, array $payload)
    {
        $this->company = $company;
        $this->event = $event;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(WebhookService $webhookService): void
    {
        $webhookService->deliver($this->company, $this->event, $this->payload);
    }
}
