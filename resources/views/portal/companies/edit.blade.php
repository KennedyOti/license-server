@extends('layouts.portal')

@section('title', 'Edit Company - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Company</h2>
    <a href="{{ route('portal.companies.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Companies
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

<form method="POST" action="{{ route('portal.companies.update', $company) }}">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="webhook_url" class="form-label">Webhook URL</label>
                        <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ old('webhook_url', $company->webhook_url) }}">
                        <div class="form-text">URL to receive webhook notifications</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="webhook_secret" class="form-label">Webhook Secret</label>
                        <input type="text" name="webhook_secret" id="webhook_secret" class="form-control" value="{{ old('webhook_secret', $company->webhook_secret) }}">
                        <div class="form-text">Secret for webhook signature verification</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="metadata" class="form-label">Metadata (JSON)</label>
                        <textarea name="metadata" id="metadata" class="form-control" rows="3">{{ old('metadata', $company->metadata ? json_encode($company->metadata, JSON_PRETTY_PRINT) : '') }}</textarea>
                        <div class="form-text">Additional metadata in JSON format</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check"></i> Update Company
            </button>
        </div>
    </div>
</form>
@endsection