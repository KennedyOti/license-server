@extends('layouts.portal')

@section('title', 'Edit Product - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Product</h2>
    <a href="{{ route('portal.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('portal.products.update', $product) }}">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        <div class="form-text">Enter a descriptive name for your product</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="metadata" class="form-label">Metadata (JSON)</label>
                        <textarea name="metadata" id="metadata" class="form-control" rows="4" placeholder='{"version": "1.0", "description": "Product description"}'>{{ old('metadata', json_encode($product->metadata, JSON_PRETTY_PRINT)) }}</textarea>
                        <div class="form-text">Optional JSON metadata for additional product information</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check"></i> Update Product
            </button>
        </div>
    </div>
</form>
@endsection