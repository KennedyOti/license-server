<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $licenses = $request->company->licenses;

        return response()->json($licenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'external_user_id' => 'required|string',
            'status' => 'in:draft,active,suspended,revoked,expired',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'plan_id' => 'nullable|exists:plans,id',
            'feature_overrides' => 'nullable|array',
            'metadata' => 'nullable|array',
        ]);

        // Ensure product belongs to company
        $request->company->products()->findOrFail($validated['product_id']);

        $license = $request->company->licenses()->create($validated);

        return response()->json($license, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $license = $request->company->licenses()->findOrFail($id);

        return response()->json($license);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $license = $request->company->licenses()->findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'external_user_id' => 'required|string',
            'status' => 'in:draft,active,suspended,revoked,expired',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'plan_id' => 'nullable|exists:plans,id',
            'feature_overrides' => 'nullable|array',
            'metadata' => 'nullable|array',
        ]);

        // Ensure product belongs to company
        $request->company->products()->findOrFail($validated['product_id']);

        $license->update($validated);

        return response()->json($license);
    }

    /**
     * Revoke the license.
     */
    public function revoke(Request $request, string $id)
    {
        $license = $request->company->licenses()->findOrFail($id);

        $license->update(['status' => 'revoked']);

        return response()->json(['message' => 'License revoked successfully']);
    }

    /**
     * Suspend the license.
     */
    public function suspend(Request $request, string $id)
    {
        $license = $request->company->licenses()->findOrFail($id);

        $license->update(['status' => 'suspended']);

        return response()->json(['message' => 'License suspended successfully']);
    }
}
