<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role !== 'owner') {
            abort(403);
        }

        // Owners can see all users
        $users = User::all();

        return view('portal.users.index', compact('users'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'owner') {
            abort(403);
        }

        // Owners can assign to any company
        $companies = Company::all();

        return view('portal.users.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:read-only,owner,admin',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Owners can create users for any company and any role except other owners
        if ($validated['role'] === 'owner') {
            return redirect()->route('portal.users.index')->with('error', 'You cannot create owner users.');
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('portal.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        $authUser = auth()->user();
        if ($authUser->role !== 'owner') {
            abort(403);
        }
        // Owners can view any user
        return view('portal.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();
        if ($authUser->role !== 'owner') {
            abort(403);
        }

        // Owners can edit any user and assign to any company
        $companies = Company::all();

        return view('portal.users.edit', compact('user', 'companies'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();
        if ($authUser->role !== 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:read-only,owner,admin',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Owners can update any user, assign to any company, and change roles except to owner
        if ($validated['role'] === 'owner' && $user->role !== 'owner') {
            return redirect()->route('portal.users.index')->with('error', 'You cannot change user roles to owner.');
        }

        $user->update($validated);

        return redirect()->route('portal.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $authUser = auth()->user();
        if ($authUser->role !== 'owner') {
            abort(403);
        }

        // Owners can delete any user except other owners
        if ($user->role === 'owner') {
            return redirect()->route('portal.users.index')->with('error', 'You cannot delete owner users.');
        }

        $user->delete();

        return redirect()->route('portal.users.index')->with('success', 'User deleted successfully');
    }
}