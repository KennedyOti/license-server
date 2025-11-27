@extends('layouts.portal')

@section('title', 'Company Details - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Company Details</h2>
    <div>
        @if(auth()->user()->role === 'admin' || auth()->user()->company_id === $company->id)
        <a href="{{ route('portal.companies.edit', $company) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        @endif
        <a href="{{ route('portal.companies.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Companies
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Company Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $company->name }}</p>
                        <p><strong>API Key:</strong> <code>{{ $company->api_key }}</code></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Webhook URL:</strong> {{ $company->webhook_url ?: 'Not set' }}</p>
                        <p><strong>Created:</strong> {{ $company->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                @if($company->metadata)
                <div class="mt-3">
                    <strong>Metadata:</strong>
                    <pre class="bg-light p-2 rounded">{{ json_encode($company->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Statistics</h5>
            </div>
            <div class="card-body">
                <p><strong>Users:</strong> {{ $company->users->count() }}</p>
                <p><strong>Products:</strong> {{ $company->products->count() }}</p>
                <p><strong>Licenses:</strong> {{ $company->licenses->count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection