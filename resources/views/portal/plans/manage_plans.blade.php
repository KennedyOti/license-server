@extends('layouts.portal')

@section('title', 'Manage Plans - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Plans</h2>
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
                    <th>Plan Name</th>
                    <th>Description</th>
                    <th>Limits</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->product->company->name }}</td>
                    <td>{{ $plan->product->name }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->description }}</td>
                    <td>
                        @if($plan->limits)
                        <ul class="list-unstyled mb-0">
                            @foreach($plan->limits as $key => $value)
                            <li><small>{{ ucfirst($key) }}: {{ $value }}</small></li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-muted">No limits</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No plans found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection