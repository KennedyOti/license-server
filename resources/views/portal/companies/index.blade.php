@extends('layouts.portal')

@section('title', 'Companies - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Companies</h2>
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'owner')
    <a href="{{ route('portal.companies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add Company
    </a>
    @endif
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>API Key</th>
                    <th>Webhook URL</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td><code>{{ $company->api_key }}</code></td>
                    <td>{{ $company->webhook_url ?: 'Not set' }}</td>
                    <td>{{ $company->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('portal.companies.show', $company) }}" class="btn btn-sm btn-outline-info">View</a>
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'owner' || auth()->user()->company_id === $company->id)
                        <a href="{{ route('portal.companies.edit', $company) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        @endif
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'owner')
                        <form method="POST" action="{{ route('portal.companies.destroy', $company) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No companies found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection