<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'owner') {
            $companies = Company::all();
        } else {
            $companies = collect([$user->company])->filter();
        }

        return view('portal.companies.index', compact('companies'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $user->role !== 'owner') {
            return redirect()->route('portal.companies.index')->with('error', 'Only admins and owners can create companies.');
        }

        return view('portal.companies.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $user->role !== 'owner') {
            return redirect()->route('portal.companies.index')->with('error', 'Only admins and owners can create companies.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        Company::create($validated);

        return redirect()->route('portal.companies.index')->with('success', 'Company created successfully');
    }

    public function show(Company $company)
    {
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'owner' && $user->company_id !== $company->id) {
            abort(403);
        }
        return view('portal.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'owner' && $user->company_id !== $company->id) {
            abort(403);
        }
        return view('portal.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'owner' && $user->company_id !== $company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        $company->update($validated);

        return redirect()->route('portal.companies.index')->with('success', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'owner') {
            abort(403);
        }
        $company->delete();

        return redirect()->route('portal.companies.index')->with('success', 'Company deleted successfully');
    }
}