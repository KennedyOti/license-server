@extends('layouts.portal')

@section('content')
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profile updated successfully.
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <!-- Profile Update Form -->
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control">
                            @if ($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture"
                                    class="img-thumbnail mt-2" width="150">
                            @endif
                            @error('profile_picture')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (Auth::user()->role == 'owner')
                            <div class="form-group mb-3">
                                <label for="role">Role</label>
                                <select name="role" class="form-control">
                                    <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>
                                        Owner</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="read_only" {{ old('role', $user->role) == 'read_only' ? 'selected' : '' }}>
                                        Read Only</option>
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @elseif (Auth::user()->role == 'admin')
                            <div class="form-group mb-3">
                                <label for="role">Role</label>
                                <select name="role" class="form-control">
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="read_only" {{ old('role', $user->role) == 'read_only' ? 'selected' : '' }}>
                                        Read Only</option>
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        @if (Auth::user()->role == 'admin')
                            <div class="form-group mb-3">
                                <label for="company_id">Company</label>
                                <select name="company_id" class="form-control">
                                    @foreach(\App\Models\Company::all() as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <input type="hidden" name="role" value="{{ old('role', $user->role) }}">
                            <input type="hidden" name="company_id" value="{{ old('company_id', $user->company_id) }}">
                        @endif

                        <button type="submit" class="btn btn-primary no-loading">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Password Update Form -->
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.updatePassword', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                            @error('new_password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection