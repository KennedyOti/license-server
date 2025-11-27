@extends('layouts.portal')

@section('title', 'Webhooks - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Webhooks</h2>
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
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Webhook Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('portal.webhooks.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="webhook_url" class="form-label">Webhook URL</label>
                        <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ old('webhook_url', $company->webhook_url) }}">
                        <div class="form-text">URL to receive webhook notifications</div>
                    </div>

                    <div class="mb-3">
                        <label for="webhook_secret" class="form-label">Webhook Secret</label>
                        <input type="text" name="webhook_secret" id="webhook_secret" class="form-control" value="{{ old('webhook_secret', $company->webhook_secret) }}">
                        <div class="form-text">Secret for webhook signature verification</div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Save Settings
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Webhook Delivery Logs</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Status</th>
                                <th>Attempted At</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->event_type }}</td>
                                <td>
                                    @if($log->status === 'success')
                                        <span class="badge bg-success">Success</span>
                                    @elseif($log->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-warning">{{ ucfirst($log->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $log->attempted_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if($log->response_code)
                                        <code>{{ $log->response_code }}</code>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No webhook deliveries yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection