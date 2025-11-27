<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;

        return view('portal.settings.index', compact('user', 'company'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        $validated = $request->validate([
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        $company->update($validated);

        return redirect()->route('portal.settings.index')->with('success', 'Settings updated successfully');
    }
}