@extends('layouts.portal')

@section('title', 'Plans - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Plans</h2>
    @if(in_array(Auth::user()->role, ['admin', 'owner']))
    <a href="{{ route('portal.plans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add Plan
    </a>
    @endif
</div>

@if($products->count() > 0)
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="product_id" class="form-label">Filter by Product</label>
                <select name="product_id" id="product_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Products</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $productId == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>
@endif

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
                    <th>Name</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Limits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->product->name }}</td>
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
                    <td>
                        <a href="{{ route('portal.plans.show', $plan) }}" class="btn btn-sm btn-outline-info">View</a>
                        @if(in_array(Auth::user()->role, ['admin', 'owner']))
                        <a href="{{ route('portal.plans.edit', $plan) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form method="POST" action="{{ route('portal.plans.destroy', $plan) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
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