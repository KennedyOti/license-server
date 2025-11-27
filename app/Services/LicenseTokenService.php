<?php

namespace App\Services;

use App\Models\License;
use App\Models\RevocationList;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LicenseTokenService
{
    private string $privateKey;
    private string $publicKey;
    private int $ttl;

    public function __construct()
    {
        $this->privateKey = config('license.private_key', env('LICENSE_PRIVATE_KEY'));
        $this->publicKey = config('license.public_key', env('LICENSE_PUBLIC_KEY'));
        $this->ttl = config('license.token_ttl', 48 * 3600); // 48 hours
    }

    public function generateToken(License $license): string
    {
        $payload = [
            'iss' => config('app.url'),
            'iat' => time(),
            'exp' => time() + $this->ttl,
            'license_id' => $license->id,
            'company_id' => $license->company_id,
            'product_id' => $license->product_id,
            'external_user_id' => $license->external_user_id,
            'features' => $license->combined_features,
            'plan_id' => $license->plan_id,
        ];

        return JWT::encode($payload, $this->privateKey, 'RS256');
    }

    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->publicKey, 'RS256'));
            $payload = (array) $decoded;

            // Check if license is revoked
            if (isset($payload['license_id']) && RevocationList::where('license_id', $payload['license_id'])->exists()) {
                return null;
            }

            return $payload;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}