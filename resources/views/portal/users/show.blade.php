@extends('layouts.portal')

@section('title', 'User Details - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>User Details</h2>
    <div>
        @if(auth()->user()->role === 'owner' && auth()->user()->company_id === $user->company_id)
        <a href="{{ route('portal.users.edit', $user) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        @endif
        <a href="{{ route('portal.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>User Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Role:</strong>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'owner' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                        <p><strong>Company:</strong> {{ $user->company->name ?? 'N/A' }}</p>
                        <p><strong>Joined:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>
                        <p><strong>Last Login:</strong> {{ $user->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Status</h5>
            </div>
            <div class="card-body">
                <p><strong>Email Verified:</strong>
                    @if($user->email_verified_at)
                        <span class="text-success">Yes</span>
                    @else
                        <span class="text-danger">No</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection