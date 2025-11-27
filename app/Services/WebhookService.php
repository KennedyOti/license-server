<?php

namespace App\Services;

use App\Models\Company;
use App\Models\WebhookDeliveryLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public function deliver(Company $company, string $event, array $payload): void
    {
        if (!$company->webhook_url || !$company->webhook_secret) {
            return;
        }

        $maxRetries = 5;
        $retryDelay = 1; // seconds

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $response = Http::timeout(30)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'X-Signature' => $this->generateSignature($payload, $company->webhook_secret),
                        'User-Agent' => 'License-Server/1.0',
                    ])
                    ->post($company->webhook_url, $payload);

                $log = WebhookDeliveryLog::create([
                    'company_id' => $company->id,
                    'event_type' => $event,
                    'payload' => $payload,
                    'success' => $response->successful(),
                    'retries' => $attempt - 1,
                    'response_code' => $response->status(),
                    'timestamp' => now(),
                ]);

                if ($response->successful()) {
                    Log::info("Webhook delivered successfully", [
                        'company_id' => $company->id,
                        'event' => $event,
                        'attempt' => $attempt
                    ]);
                    return;
                } else {
                    Log::warning("Webhook delivery failed", [
                        'company_id' => $company->id,
                        'event' => $event,
                        'attempt' => $attempt,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                }

            } catch (\Exception $e) {
                Log::error("Webhook delivery exception", [
                    'company_id' => $company->id,
                    'event' => $event,
                    'attempt' => $attempt,
                    'error' => $e->getMessage()
                ]);

                WebhookDeliveryLog::create([
                    'company_id' => $company->id,
                    'event_type' => $event,
                    'payload' => $payload,
                    'success' => false,
                    'retries' => $attempt - 1,
                    'response_code' => null,
                    'timestamp' => now(),
                ]);
            }

            if ($attempt < $maxRetries) {
                sleep($retryDelay * $attempt); // Exponential backoff
            }
        }

        Log::error("Webhook delivery failed after all retries", [
            'company_id' => $company->id,
            'event' => $event
        ]);
    }

    private function generateSignature(array $payload, string $secret): string
    {
        $jsonPayload = json_encode($payload);
        return hash_hmac('sha256', $jsonPayload, $secret);
    }
}