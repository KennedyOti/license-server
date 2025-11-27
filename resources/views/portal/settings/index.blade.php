@extends('layouts.portal')

@section('title', 'Settings - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Settings</h2>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <form method="POST" action="{{ route('portal.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header">
                    <h5>Company Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="webhook_url" class="form-label">Webhook URL</label>
                                <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ old('webhook_url', $company->webhook_url) }}">
                                <div class="form-text">URL to receive webhook notifications for license events</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="webhook_secret" class="form-label">Webhook Secret</label>
                                <input type="text" name="webhook_secret" id="webhook_secret" class="form-control" value="{{ old('webhook_secret', $company->webhook_secret) }}">
                                <div class="form-text">Secret for webhook signature verification</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="metadata" class="form-label">Metadata (JSON)</label>
                                <textarea name="metadata" id="metadata" class="form-control" rows="4">{{ old('metadata', $company->metadata ? json_encode($company->metadata, JSON_PRETTY_PRINT) : '') }}</textarea>
                                <div class="form-text">Additional metadata in JSON format</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>API Information</h5>
            </div>
            <div class="card-body">
                <p><strong>API Key:</strong></p>
                <code class="d-block mb-2">{{ $company->api_key }}</code>
                <p><strong>Base URL:</strong></p>
                <code class="d-block">{{ url('/') }}/api</code>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Quick Links</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('portal.api_docs.index') }}" class="btn btn-outline-primary btn-sm d-block mb-2">
                    <i class="bi bi-file-earmark-text"></i> API Documentation
                </a>
                <a href="/api/docs" target="_blank" class="btn btn-outline-secondary btn-sm d-block">
                    <i class="bi bi-box-arrow-up-right"></i> OpenAPI Spec
                </a>
            </div>
        </div>
    </div>
</div>
@endsection