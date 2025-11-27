<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = $user->company;

        $data = [
            'user' => $user,
            'company' => $company,
            'role' => $user->role,
            'products_count' => 0,
            'licenses_count' => 0,
            'active_licenses_count' => 0,
            'recent_licenses' => collect(),
        ];

        if ($company) {
            $data['products_count'] = $company->products()->count();
            $data['licenses_count'] = $company->licenses()->count();
            $data['active_licenses_count'] = $company->licenses()->where('status', 'active')->count();
            $data['recent_licenses'] = $company->licenses()->latest()->take(5)->get();
        }

        return view('portal.dashboard', $data);
    }
}