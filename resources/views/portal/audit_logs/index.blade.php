@extends('layouts.portal')

@section('title', 'Audit Logs - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Audit Logs</h2>
</div>

<div class="card">
    <div class="card-header">
        <h5>Activity Log</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <form method="GET" action="{{ route('portal.audit_logs.index') }}">
                    <label for="entity_type" class="form-label">Filter by Entity Type</label>
                    <select name="entity_type" id="entity_type" class="form-select" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="license" {{ request('entity_type') === 'license' ? 'selected' : '' }}>License</option>
                        <option value="product" {{ request('entity_type') === 'product' ? 'selected' : '' }}>Product</option>
                        <option value="plan" {{ request('entity_type') === 'plan' ? 'selected' : '' }}>Plan</option>
                        <option value="feature" {{ request('entity_type') === 'feature' ? 'selected' : '' }}>Feature</option>
                        <option value="user" {{ request('entity_type') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </form>
            </div>
            <div class="col-md-4">
                <form method="GET" action="{{ route('portal.audit_logs.index') }}">
                    <label for="action" class="form-label">Filter by Action</label>
                    <select name="action" id="action" class="form-select" onchange="this.form.submit()">
                        <option value="">All Actions</option>
                        <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                        <option value="issued" {{ request('action') === 'issued' ? 'selected' : '' }}>Issued</option>
                        <option value="revoked" {{ request('action') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Entity</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->timestamp->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $log->actor ? $log->actor->name : 'System' }}</td>
                        <td>
                            <span class="badge bg-{{ $log->action === 'created' ? 'success' : ($log->action === 'updated' ? 'warning' : ($log->action === 'deleted' ? 'danger' : 'info')) }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($log->entity_type) }} #{{ $log->entity_id }}</td>
                        <td>
                            @if($log->old_values || $log->new_values)
                                <button class="btn btn-sm btn-outline-info" onclick="showDetails({{ $log->id }})">View Details</button>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No audit logs found.</td>
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

<!-- Modal for details -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detailsContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(logId) {
    // In a real implementation, you might fetch details via AJAX
    // For now, we'll show a placeholder
    document.getElementById('detailsContent').innerHTML = '<p>Detailed changes would be shown here.</p>';
    new bootstrap.Modal(document.getElementById('detailsModal')).show();
}
</script>
@endsection