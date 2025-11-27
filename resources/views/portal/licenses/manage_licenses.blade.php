@extends('layouts.portal')

@section('title', 'Manage Licenses - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Licenses</h2>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Product</th>
                    <th>License ID</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($licenses as $license)
                <tr>
                    <td>{{ $license->company->name }}</td>
                    <td>{{ $license->product->name }}</td>
                    <td>{{ $license->id }}</td>
                    <td>{{ $license->external_user_id }}</td>
                    <td>
                        <span class="status-badge status-{{ $license->status }}">
                            {{ ucfirst($license->status) }}
                        </span>
                    </td>
                    <td>{{ $license->start_date->format('Y-m-d') }}</td>
                    <td>{{ $license->end_date->format('Y-m-d') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No licenses found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($licenses, 'links'))
    {{ $licenses->links() }}
    @endif
</div>
@endsection