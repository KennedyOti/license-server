@extends('layouts.portal')

@section('title', 'Plan Details - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>{{ $plan->name }}</h2>
    <div>
        <a href="{{ route('portal.plans.edit', $plan) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('portal.plans.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Plans
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Plan Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Name:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $plan->name }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Product:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $plan->product->name }}
                    </div>
                </div>
                @if($plan->description)
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $plan->description }}
                    </div>
                </div>
                @endif
                @if($plan->limits)
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Limits:</strong>
                    </div>
                    <div class="col-sm-8">
                        <pre class="bg-light p-2 rounded">{{ json_encode($plan->limits, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Created:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $plan->created_at->format('M j, Y \a\t g:i A') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Last Updated:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ $plan->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                </div>
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
                    <span class="badge bg-primary">{{ $plan->features->count() }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <span>Licenses:</span>
                    <span class="badge bg-info">{{ $plan->licenses->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Assigned Features</h5>
            </div>
            <div class="card-body">
                @forelse($plan->features as $feature)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>{{ $feature->name }}</strong>
                        <br><small class="text-muted">{{ $feature->code }}</small>
                    </div>
                    <form method="POST" action="{{ route('portal.plans.remove_feature', [$plan, $feature]) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this feature from the plan?')">Remove</button>
                    </form>
                </div>
                @if(!$loop->last)
                <hr>
                @endif
                @empty
                <p class="text-muted mb-0">No features assigned yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Available Features</h5>
            </div>
            <div class="card-body">
                @forelse($availableFeatures as $feature)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>{{ $feature->name }}</strong>
                        <br><small class="text-muted">{{ $feature->code }}</small>
                    </div>
                    <form method="POST" action="{{ route('portal.plans.assign_feature', $plan) }}" style="display: inline;">
                        @csrf
                        <input type="hidden" name="feature_id" value="{{ $feature->id }}">
                        <button type="submit" class="btn btn-sm btn-outline-success">Assign</button>
                    </form>
                </div>
                @if(!$loop->last)
                <hr>
                @endif
                @empty
                <p class="text-muted mb-0">All features are already assigned.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection