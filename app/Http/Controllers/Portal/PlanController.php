<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Plan;
use App\Models\Product;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && !$user->company) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            // Owners can see all plans
            $productId = $request->get('product_id');

            if ($productId) {
                $product = Product::findOrFail($productId);
                $plans = $product->plans;
            } else {
                $plans = Plan::all();
            }

            $products = Product::all();
        } else {
            $productId = $request->get('product_id');

            if ($productId) {
                $product = $user->company->products()->findOrFail($productId);
                $plans = $product->plans;
            } else {
                $plans = collect();
                foreach ($user->company->products as $product) {
                    $plans = $plans->merge($product->plans);
                }
            }

            $products = $user->company->products;
        }

        return view('portal.plans.index', compact('plans', 'products', 'productId'));
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

        return view('portal.plans.create', compact('products', 'selectedProductId'));
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
            'description' => 'nullable|string',
            'limits' => 'nullable|array',
        ]);

        if ($user->role === 'owner') {
            $product = Product::findOrFail($validated['product_id']);
        } else {
            $product = $user->company->products()->findOrFail($validated['product_id']);
        }

        $product->plans()->create($validated);

        return redirect()->route('portal.plans.index')->with('success', 'Plan created successfully');
    }

    public function show(Plan $plan)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $plan->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $availableFeatures = $plan->product->features()->whereNotIn('id', $plan->features->pluck('id'))->get();

        return view('portal.plans.show', compact('plan', 'availableFeatures'));
    }

    public function edit(Plan $plan)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $plan->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        if ($user->role === 'owner') {
            $products = Product::all();
        } else {
            $products = $user->company->products;
        }

        return view('portal.plans.edit', compact('plan', 'products'));
    }

    public function update(Request $request, Plan $plan)
    {
        $user = auth()->user();

        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $plan->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'limits' => 'nullable|array',
        ]);

        if ($user->role === 'owner') {
            $product = Product::findOrFail($validated['product_id']);
        } else {
            $product = $user->company->products()->findOrFail($validated['product_id']);
        }

        $plan->update($validated);

        return redirect()->route('portal.plans.index')->with('success', 'Plan updated successfully');
    }

    public function destroy(Plan $plan)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (!$user->company || $user->company_id !== $plan->product->company_id)) {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }
        $plan->delete();

        return redirect()->route('portal.plans.index')->with('success', 'Plan deleted successfully');
    }

    public function assignFeature(Request $request, Plan $plan)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && $user->company_id !== $plan->product->company_id) {
            abort(403);
        }

        $validated = $request->validate([
            'feature_id' => 'required|exists:features,id',
        ]);

        if ($user->role === 'owner') {
            $feature = Feature::findOrFail($validated['feature_id']);
        } else {
            $feature = $plan->product->features()->findOrFail($validated['feature_id']);
        }

        if (!$plan->features()->where('feature_id', $feature->id)->exists()) {
            $plan->features()->attach($feature);
        }

        return redirect()->back()->with('success', 'Feature assigned to plan successfully');
    }

    public function removeFeature(Plan $plan, Feature $feature)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && ($user->company_id !== $plan->product->company_id || $user->company_id !== $feature->product->company_id)) {
            abort(403);
        }

        $plan->features()->detach($feature);

        return redirect()->back()->with('success', 'Feature removed from plan successfully');
    }

    public function manage()
    {
        $user = auth()->user();

        if ($user->role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'You do not have access. Please contact system admin.');
        }

        $plans = Plan::with('product.company')->get();

        return view('portal.plans.manage_plans', compact('plans'));
    }
}
