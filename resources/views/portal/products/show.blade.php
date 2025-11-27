@extends('layouts.portal')

@section('title', 'Product Details - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ $product->name }}</h2>
    <div>
        <a href="{{ route('portal.products.edit', $product) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('portal.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Name:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $product->name }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Created:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $product->created_at->format('M j, Y \a\t g:i A') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Last Updated:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $product->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                </div>
                @if($product->metadata)
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Metadata:</strong>
                    </div>
                    <div class="col-sm-8">
                        <pre class="bg-light p-2 rounded">{{ json_encode($product->metadata, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Features:</span>
                    <span class="badge bg-primary">{{ $product->features->count() }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <span>Plans:</span>
                    <span class="badge bg-success">{{ $product->plans->count() }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <span>Licenses:</span>
                    <span class="badge bg-info">{{ $product->licenses->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Features</h5>
                <a href="{{ route('portal.features.create') }}?product_id={{ $product->id }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus"></i> Add Feature
                </a>
            </div>
            <div class="card-body">
                @forelse($product->features as $feature)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>{{ $feature->name }}</strong>
                        <br><small class="text-muted">{{ $feature->code }}</small>
                    </div>
                    <a href="{{ route('portal.features.edit', $feature) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                @if(!$loop->last)
                <hr>
                @endif
                @empty
                <p class="text-muted mb-0">No features added yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Plans</h5>
                <a href="{{ route('portal.plans.create') }}?product_id={{ $product->id }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus"></i> Add Plan
                </a>
            </div>
            <div class="card-body">
                @forelse($product->plans as $plan)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>{{ $plan->name }}</strong>
                        <br><small class="text-muted">{{ $plan->features->count() }} features</small>
                    </div>
                    <a href="{{ route('portal.plans.edit', $plan) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                @if(!$loop->last)
                <hr>
                @endif
                @empty
                <p class="text-muted mb-0">No plans added yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection