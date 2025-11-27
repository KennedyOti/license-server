@extends('layouts.portal')

@section('title', 'API Documentation - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>API Documentation</h2>
    <a href="/api/docs" target="_blank" class="btn btn-primary">
        <i class="bi bi-box-arrow-up-right"></i> Open Full Documentation
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Interactive API Documentation</h5>
            </div>
            <div class="card-body">
                <p>Explore and test our API endpoints using the interactive Swagger documentation.</p>
                <div class="d-flex gap-2">
                    <a href="/api/docs" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-text"></i> View API Docs
                    </a>
                    <a href="/openapi.json" target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-download"></i> Download OpenAPI Spec
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Authentication</h5>
            </div>
            <div class="card-body">
                <p>All API requests require authentication using your company's API key.</p>
                <p><strong>Header:</strong> <code>X-API-Key: your-api-key</code></p>
                <p><strong>Your API Key:</strong></p>
                <code class="d-block p-2 bg-light">{{ auth()->user()->company->api_key }}</code>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Base URL</h5>
            </div>
            <div class="card-body">
                <p><strong>Production:</strong></p>
                <code class="d-block p-2 bg-light">{{ url('/') }}/api</code>
                <p><strong>Version:</strong> v1</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>SDK Examples</h5>
            </div>
            <div class="card-body">
                <p>Coming soon: Auto-generated SDK examples for popular programming languages.</p>
                <div class="alert alert-info">
                    <strong>Note:</strong> SDK generation and integration guides are planned for future releases.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection