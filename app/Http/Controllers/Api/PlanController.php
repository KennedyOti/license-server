<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Product;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $productId)
    {
        $product = $request->company->products()->findOrFail($productId);
        $plans = $product->plans;

        return response()->json($plans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        $product = $request->company->products()->findOrFail($productId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'limits' => 'nullable|array',
        ]);

        $plan = $product->plans()->create($validated);

        return response()->json($plan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $productId, string $id)
    {
        $product = $request->company->products()->findOrFail($productId);
        $plan = $product->plans()->findOrFail($id);

        return response()->json($plan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId, string $id)
    {
        $product = $request->company->products()->findOrFail($productId);
        $plan = $product->plans()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'limits' => 'nullable|array',
        ]);

        $plan->update($validated);

        return response()->json($plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $productId, string $id)
    {
        $product = $request->company->products()->findOrFail($productId);
        $plan = $product->plans()->findOrFail($id);

        $plan->delete();

        return response()->json(['message' => 'Plan deleted successfully']);
    }
}
