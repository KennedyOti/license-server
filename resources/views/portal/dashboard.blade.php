@extends('layouts.portal')

@section('title', 'License Server - Dashboard')

@section('content')
<!-- Dashboard Stats -->
<div class="row">
    @if(in_array($role, ['admin', 'owner']))
    <div class="col-md-3 col-sm-6">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-number">{{ $products_count ?? 0 }}</div>
            <div class="stat-label">Products</div>
        </div>
    </div>
    @endif

    <div class="col-md-3 col-sm-6">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="bi bi-key"></i>
            </div>
            <div class="stat-number">{{ $licenses_count ?? 0 }}</div>
            <div class="stat-label">Total Licenses</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-number">{{ $active_licenses_count ?? 0 }}</div>
            <div class="stat-label">Active Licenses</div>
        </div>
    </div>

    @if($role === 'owner' && $company)
    <div class="col-md-3 col-sm-6">
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="stat-number">{{ $company->api_key ? 'Active' : 'Inactive' }}</div>
            <div class="stat-label">API Status</div>
        </div>
    </div>
    @endif
</div>

<!-- Recent Licenses Table -->
@if($recent_licenses && $recent_licenses->count() > 0)
<div class="table-container">
    <h3 class="table-title">
        <i class="bi bi-key"></i>
        Recent Licenses
    </h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>License ID</th>
                    <th>Product</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_licenses as $license)
                <tr>
                    <td>{{ $license->id }}</td>
                    <td>{{ $license->product->name }}</td>
                    <td>{{ $license->external_user_id }}</td>
                    <td>
                        <span class="status-badge status-{{ $license->status }}">
                            {{ ucfirst($license->status) }}
                        </span>
                    </td>
                    <td>{{ $license->end_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('portal.licenses.show', $license) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Recent Activity and System Status -->
<div class="row">
    <div class="col-lg-8">
        <div class="table-container">
            <h3 class="table-title">
                <i class="bi bi-clock-history"></i>
                Recent Activity
            </h3>
            <div class="text-center py-4">
                <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-2">No recent activity to display</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="table-container">
            <h3 class="table-title">
                <i class="bi bi-graph-up"></i>
                System Status
            </h3>
            <div class="text-center py-4">
                <i class="bi bi-graph-up text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-2">System status information will be displayed here</p>
            </div>
        </div>
    </div>
</div>
@endsection