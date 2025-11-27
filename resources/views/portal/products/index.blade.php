@extends('layouts.portal')

@section('title', 'Products - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Products</h2>
    <a href="{{ route('portal.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add Product
    </a>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('portal.products.show', $product) }}" class="btn btn-sm btn-outline-info">View</a>
                        <a href="{{ route('portal.products.edit', $product) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form method="POST" action="{{ route('portal.products.destroy', $product) }}" style="display: inline;" id="delete-form-{{ $product->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection