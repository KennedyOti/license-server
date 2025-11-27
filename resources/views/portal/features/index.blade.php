@extends('layouts.portal')

@section('title', 'Features - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Features</h2>
    @if(in_array(Auth::user()->role, ['admin', 'owner']))
    <a href="{{ route('portal.features.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add Feature
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
                    <th>Code</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($features as $feature)
                <tr>
                    <td>{{ $feature->name }}</td>
                    <td>{{ $feature->code }}</td>
                    <td>{{ $feature->product->name }}</td>
                    <td>{{ $feature->description }}</td>
                    <td>
                        @if(in_array(Auth::user()->role, ['admin', 'owner']))
                        <a href="{{ route('portal.features.edit', $feature) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form method="POST" action="{{ route('portal.features.destroy', $feature) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No features found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection