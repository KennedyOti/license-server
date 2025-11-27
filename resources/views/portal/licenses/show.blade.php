@extends('layouts.portal')

@section('title', 'License Details - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>License Details</h2>
    <div>
        @if(in_array(Auth::user()->role, ['admin', 'owner']))
        <a href="{{ route('portal.licenses.edit', $license) }}" class="btn btn-secondary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        @endif
        <a href="{{ route('portal.licenses.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Licenses
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">License Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">License ID</label>
                            <p class="mb-0">{{ $license->id }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Product</label>
                            <p class="mb-0">{{ $license->product->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">External User ID</label>
                            <p class="mb-0">{{ $license->external_user_id }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="mb-0">
                                <span class="status-badge status-{{ $license->status }}">
                                    {{ ucfirst($license->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Start Date</label>
                            <p class="mb-0">{{ $license->start_date->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">End Date</label>
                            <p class="mb-0">{{ $license->end_date->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>

                @if($license->plan)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Plan</label>
                            <p class="mb-0">{{ $license->plan->name }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($license->feature_overrides)
                <div class="mb-3">
                    <label class="form-label fw-bold">Feature Overrides</label>
                    <pre class="bg-light p-2 rounded">{{ json_encode($license->feature_overrides, JSON_PRETTY_PRINT) }}</pre>
                </div>
                @endif

                @if($license->metadata)
                <div class="mb-3">
                    <label class="form-label fw-bold">Metadata</label>
                    <pre class="bg-light p-2 rounded">{{ json_encode($license->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                @if(in_array(Auth::user()->role, ['admin', 'owner']))
                @if($license->status === 'active')
                <form method="POST" action="{{ route('portal.licenses.suspend', $license) }}" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="bi bi-pause"></i> Suspend License
                    </button>
                </form>

                <form method="POST" action="{{ route('portal.licenses.revoke', $license) }}" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to revoke this license?')">
                        <i class="bi bi-x-circle"></i> Revoke License
                    </button>
                </form>
                @endif

                <form method="POST" action="{{ route('portal.licenses.destroy', $license) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to delete this license?')">
                        <i class="bi bi-trash"></i> Delete License
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection