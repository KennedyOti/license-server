<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Product;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $productId)
    {
        $product = $request->company->products()->findOrFail($productId);
        $features = $product->features;

        return response()->json($features);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        $product = $request->company->products()->findOrFail($productId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:features,code',
            'description' => 'nullable|string',
        ]);

        $feature = $product->features()->create($validated);

        return response()->json($feature, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $productId, string $id)
    {
        $product = $request->company->products()->findOrFail($productId);
        $feature = $product->features()->findOrFail($id);

        return response()->json($feature);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $productId, string $id)
    {
        $product = $request->company->products()->findOrFail($productId);
        $feature = $product->features()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:features,code,' . $id,
            'description' => 'nullable|string',
        ]);

        $feature->update($validated);

        return response()->json($feature);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $productId, string $id)
    {
        $product = $request->company->products()->findOrFail($productId);
        $feature = $product->features()->findOrFail($id);

        $feature->delete();

        return response()->json(['message' => 'Feature deleted successfully']);
    }
}
