@extends('layouts.portal')

@section('title', 'Create License - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create License</h2>
    <a href="{{ route('portal.licenses.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Licenses
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

<form method="POST" action="{{ route('portal.licenses.store') }}">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="external_user_id" class="form-label">External User ID <span class="text-danger">*</span></label>
                        <input type="text" name="external_user_id" id="external_user_id" class="form-control" value="{{ old('external_user_id') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="revoked" {{ old('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="plan_id" class="form-label">Plan</label>
                        <select name="plan_id" id="plan_id" class="form-select">
                            <option value="">Select Plan (Optional)</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="feature_overrides" class="form-label">Feature Overrides (JSON)</label>
                        <textarea name="feature_overrides" id="feature_overrides" class="form-control" rows="3">{{ old('feature_overrides') }}</textarea>
                        <div class="form-text">Optional JSON array for feature overrides</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="metadata" class="form-label">Metadata (JSON)</label>
                        <textarea name="metadata" id="metadata" class="form-control" rows="3">{{ old('metadata') }}</textarea>
                        <div class="form-text">Optional JSON object for additional metadata</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check"></i> Create License
            </button>
        </div>
    </div>
</form>
@endsection