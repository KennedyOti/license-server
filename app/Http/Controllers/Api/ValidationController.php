<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Services\LicenseTokenService;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validate(Request $request, LicenseTokenService $tokenService)
    {
        $validated = $request->validate([
            'company_id' => 'required|integer',
            'external_user_id' => 'required|string',
            'product_id' => 'required|integer',
        ]);

        $license = License::where('company_id', $validated['company_id'])
            ->where('external_user_id', $validated['external_user_id'])
            ->where('product_id', $validated['product_id'])
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();

        if (!$license) {
            return response()->json([
                'license_valid' => false,
                'status' => 'invalid',
                'expiry' => null,
                'plan_features' => [],
                'feature_overrides' => null,
                'combined_feature_entitlements' => [],
            ]);
        }

        $token = $tokenService->generateToken($license);

        return response()->json([
            'license_valid' => true,
            'status' => $license->status,
            'expiry' => $license->end_date->toISOString(),
            'plan_features' => $license->plan ? $license->plan->features->pluck('code')->toArray() : [],
            'feature_overrides' => $license->feature_overrides,
            'combined_feature_entitlements' => $license->combined_features->toArray(),
            'jwt_token' => $token,
        ]);
    }

    public function publicKey(LicenseTokenService $tokenService)
    {
        return response($tokenService->getPublicKey())
            ->header('Content-Type', 'text/plain');
    }
}
