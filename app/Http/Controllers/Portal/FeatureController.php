<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Product;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            // Owners can see all features
            $productId = $request->get('product_id');

            if ($productId) {
                $product = Product::findOrFail($productId);
                $features = $product->features;
            } else {
                $features = Feature::all();
            }

            $products = Product::all();
        } else {
            $productId = $request->get('product_id');

            if ($productId) {
                $product = $user->company->products()->findOrFail($productId);
                $features = $product->features;
            } else {
                $features = collect();
                foreach ($user->company->products as $product) {
                    $features = $features->merge($product->features);
                }
            }

            $products = $user->company->products;
        }

        return view('portal.features.index', compact('features', 'products', 'productId'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            $products = Product::all();
        } else {
            $products = $user->company->products;
        }

        $selectedProductId = $request->get('product_id');

        return view('portal.features.create', compact('products', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:features,code',
            'description' => 'nullable|string',
        ]);

        if ($user->role === 'owner') {
            $product = Product::findOrFail($validated['product_id']);
        } else {
            $product = $user->company->products()->findOrFail($validated['product_id']);
        }

        $product->features()->create($validated);

        return redirect()->route('portal.features.index')->with('success', 'Feature created successfully');
    }

    public function edit(Feature $feature)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $feature->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            $products = Product::all();
        } else {
            $products = $user->company->products;
        }

        return view('portal.features.edit', compact('feature', 'products'));
    }

    public function update(Request $request, Feature $feature)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $feature->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:features,code,' . $feature->id,
            'description' => 'nullable|string',
        ]);

        if ($user->role === 'owner') {
            $product = Product::findOrFail($validated['product_id']);
        } else {
            $product = $user->company->products()->findOrFail($validated['product_id']);
        }

        $feature->update($validated);

        return redirect()->route('portal.features.index')->with('success', 'Feature updated successfully');
    }

    public function destroy(Feature $feature)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $feature->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $feature->delete();

        return redirect()->route('portal.features.index')->with('success', 'Feature deleted successfully');
    }

    public function manage()
    {
        $user = auth()->user();

        if ($user->role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $features = Feature::with('product.company')->get();

        return view('portal.features.manage_features', compact('features'));
    }
}
