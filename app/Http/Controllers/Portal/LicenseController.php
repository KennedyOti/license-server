<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Product;
use App\Models\Plan;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            $licenses = License::with(['product', 'plan'])->paginate(20);
        } else {
            $licenses = $user->company->licenses()->with(['product', 'plan'])->paginate(20);
        }

        return view('portal.licenses.index', compact('licenses'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            $products = Product::all();
            $plans = Plan::all();
        } else {
            $products = $user->company->products;
            $plans = collect();
            foreach ($products as $product) {
                $plans = $plans->merge($product->plans);
            }
        }

        return view('portal.licenses.create', compact('products', 'plans'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'external_user_id' => 'required|string',
            'status' => 'required|in:draft,active,suspended,revoked,expired',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'plan_id' => 'nullable|exists:plans,id',
            'feature_overrides' => 'nullable|array',
            'metadata' => 'nullable|array',
        ]);

        if ($user->role === 'owner') {
            Product::findOrFail($validated['product_id']);
            $license = License::create($validated);
        } else {
            $user->company->products()->findOrFail($validated['product_id']);
            $license = $user->company->licenses()->create($validated);
        }

        return redirect()->route('portal.licenses.index')->with('success', 'License created successfully');
    }

    public function show(License $license)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $license->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $license->load(['product', 'plan']);

        return view('portal.licenses.show', compact('license'));
    }

    public function edit(License $license)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $license->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            $products = Product::all();
            $plans = Plan::all();
        } else {
            $products = $user->company->products;
            $plans = collect();
            foreach ($products as $product) {
                $plans = $plans->merge($product->plans);
            }
        }

        return view('portal.licenses.edit', compact('license', 'products', 'plans'));
    }

    public function update(Request $request, License $license)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $license->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'external_user_id' => 'required|string',
            'status' => 'required|in:draft,active,suspended,revoked,expired',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'plan_id' => 'nullable|exists:plans,id',
            'feature_overrides' => 'nullable|array',
            'metadata' => 'nullable|array',
        ]);

        if ($user->role === 'owner') {
            Product::findOrFail($validated['product_id']);
        } else {
            $user->company->products()->findOrFail($validated['product_id']);
        }

        $license->update($validated);

        return redirect()->route('portal.licenses.index')->with('success', 'License updated successfully');
    }

    public function destroy(License $license)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $license->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $license->delete();

        return redirect()->route('portal.licenses.index')->with('success', 'License deleted successfully');
    }

    public function revoke(License $license)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $license->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $license->update(['status' => 'revoked']);

        return redirect()->back()->with('success', 'License revoked successfully');
    }

    public function suspend(License $license)
    {
        $user = auth()->user();
        if (!$user->company || $user->company_id !== $license->company_id) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $license->update(['status' => 'suspended']);

        return redirect()->back()->with('success', 'License suspended successfully');
    }

    public function manage()
    {
        $user = auth()->user();

        if ($user->role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $licenses = License::with(['product.company'])->paginate(50);

        return view('portal.licenses.manage_licenses', compact('licenses'));
    }
}
