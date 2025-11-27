<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Company;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // If user is owner, redirect to manage page
        if ($user->role === 'owner') {
            return redirect()->route('portal.audit_logs.manage');
        }

        $query = $user->company->auditLogs()->with('actor');

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->latest('timestamp')->paginate(20);

        return view('portal.audit_logs.index', compact('logs'));
    }

    public function manage(Request $request)
    {
        $query = AuditLog::with('actor', 'company');

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $logs = $query->latest('timestamp')->paginate(20);
        $companies = Company::all();

        return view('portal.audit_logs.manage_auditlogs', compact('logs', 'companies'));
    }
}
