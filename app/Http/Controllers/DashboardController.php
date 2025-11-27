<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Product;
use App\Models\License;

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
            'total_companies' => Company::count(),
            'total_users' => User::count(),
            'recent_licenses' => collect(),
        ];

        if ($user->role === 'owner') {
            $data['products_count'] = Product::count();
            $data['licenses_count'] = License::count();
            $data['active_licenses_count'] = License::where('status', 'active')->count();
            $data['recent_licenses'] = License::latest()->take(5)->get();
        } elseif ($company) {
            $data['products_count'] = $company->products()->count();
            $data['licenses_count'] = $company->licenses()->count();
            $data['active_licenses_count'] = $company->licenses()->where('status', 'active')->count();
            $data['recent_licenses'] = $company->licenses()->latest()->take(5)->get();
        }

        return view('portal.dashboard', $data);
    }
}