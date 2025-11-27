<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\WebhookDeliveryLog;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;
        $logs = $company->webhookDeliveryLogs()->latest()->paginate(20);

        return view('portal.webhooks.index', compact('company', 'logs'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        $validated = $request->validate([
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
        ]);

        $company->update($validated);

        return redirect()->back()->with('success', 'Webhook settings updated successfully');
    }
}
