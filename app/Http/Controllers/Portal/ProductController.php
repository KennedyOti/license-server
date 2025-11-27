<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'owner') {
            // Owners see all products
            $products = Product::all();
        } elseif (!$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        } else {
            $products = $user->company->products;
        }

        return view('portal.products.index', compact('products'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        return view('portal.products.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'metadata' => 'nullable|array',
        ]);

        if ($user->role === 'owner') {
            // For owners, perhaps require company selection, but for now, if they have company, use it
            if (!$user->company) {
                return redirect()->route('portal.products.index')->with('error', 'You must be associated with a company to create products.');
            }
        }

        $user->company->products()->create($validated);

        return redirect()->route('portal.products.index')->with('success', 'Product created successfully');
    }
    public function show(Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        return view('portal.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        return view('portal.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'metadata' => 'nullable|array',
        ]);

        $product->update($validated);

        return redirect()->route('portal.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $product->delete();

        return redirect()->route('portal.products.index')->with('success', 'Product deleted successfully');
    }
}
