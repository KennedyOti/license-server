<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Get current company info
     */
    public function me(Request $request)
    {
        $company = $request->company;

        return response()->json([
            'id' => $company->id,
            'name' => $company->name,
            'webhook_url' => $company->webhook_url,
            'metadata' => $company->metadata,
        ]);
    }

    /**
     * Update current company info
     */
    public function updateMe(Request $request)
    {
        $company = $request->company;

        $validated = $request->validate([
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        $company->update($validated);

        return response()->json([
            'message' => 'Company updated successfully',
            'company' => $company->only(['id', 'name', 'webhook_url', 'metadata']),
        ]);
    }
}
