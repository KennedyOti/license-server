@extends('layouts.portal')

@section('title', 'Edit Plan - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Plan</h2>
    <a href="{{ route('portal.plans.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Plans
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

<form method="POST" action="{{ route('portal.plans.update', $plan) }}">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $plan->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $plan->name) }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $plan->description) }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="limits" class="form-label">Limits (JSON)</label>
                        <textarea name="limits" id="limits" class="form-control" rows="3" placeholder='{"users": 10, "storage": "1GB"}'>{{ old('limits', json_encode($plan->limits)) }}</textarea>
                        <div class="form-text">Optional JSON object defining plan limits</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check"></i> Update Plan
            </button>
        </div>
    </div>
</form>
@endsection