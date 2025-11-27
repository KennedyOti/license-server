@extends('layouts.portal')

@section('title', 'Users - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Users</h2>
    @if(auth()->user()->role === 'owner')
    <a href="{{ route('portal.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Add User
    </a>
    @endif
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Company</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'owner' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->company->name ?? 'N/A' }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('portal.users.show', $user) }}" class="btn btn-sm btn-outline-info">View</a>
                        @if(auth()->user()->role === 'owner' && auth()->user()->company_id === $user->company_id)
                        <a href="{{ route('portal.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        @endif
                        @if(auth()->user()->role === 'owner' && auth()->user()->company_id === $user->company_id && !in_array($user->role, ['admin', 'owner']))
                        <form method="POST" action="{{ route('portal.users.destroy', $user) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection