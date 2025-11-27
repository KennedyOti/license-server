@extends('layouts.portal')

@section('title', 'Licenses - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Licenses</h2>
    @if(in_array(Auth::user()->role, ['admin', 'owner']))
    <a href="{{ route('portal.licenses.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Issue License
    </a>
    @endif
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($licenses as $license)
                <tr>
                    <td>{{ $license->id }}</td>
                    <td>{{ $license->product->name }}</td>
                    <td>{{ $license->external_user_id }}</td>
                    <td>
                        <span class="status-badge status-{{ $license->status }}">
                            {{ ucfirst($license->status) }}
                        </span>
                    </td>
                    <td>{{ $license->start_date->format('Y-m-d') }}</td>
                    <td>{{ $license->end_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('portal.licenses.show', $license) }}" class="btn btn-sm btn-outline-info">View</a>
                        @if(in_array(Auth::user()->role, ['admin', 'owner']))
                        <a href="{{ route('portal.licenses.edit', $license) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        @if($license->status === 'active')
                        <form method="POST" action="{{ route('portal.licenses.suspend', $license) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-warning">Suspend</button>
                        </form>
                        <form method="POST" action="{{ route('portal.licenses.revoke', $license) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Revoke</button>
                        </form>
                        @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No licenses found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($licenses, 'links'))
    {{ $licenses->links() }}
    @endif
</div>
@endsection