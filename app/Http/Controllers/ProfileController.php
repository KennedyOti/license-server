<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, string $id): View
    {
        $user = User::findOrFail($id);

        // Check if the authenticated user can edit this profile
        if ($id != auth()->id() && !in_array(auth()->user()->role, ['admin', 'owner'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('portal.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Check if the authenticated user can update this profile
        if ($id != auth()->id() && !in_array(auth()->user()->role, ['admin', 'owner'])) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the input fields
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Conditionally add role validation based on the authenticated user's role
        if (in_array(auth()->user()->role, ['admin', 'owner'])) {
            $allowedRoles = [];
            if (auth()->user()->role === 'owner') {
                $allowedRoles = ['owner', 'admin', 'read_only'];
            } elseif (auth()->user()->role === 'admin') {
                $allowedRoles = ['admin', 'read_only'];
            }
            $rules['role'] = 'required|in:' . implode(',', $allowedRoles);
            $rules['company_id'] = 'required|exists:companies,id';
        }

        $validatedData = $request->validate($rules);

        // Fill the user model with validated data
        $user->fill($validatedData);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists in storage
            if ($user->profile_picture && Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }
            // Store the new profile picture
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // If the email has changed, set email_verified_at to null
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the user data
        $user->save();

        // Redirect back with success message
        return back()->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Check if the authenticated user can update this password
        if ($id != auth()->id() && !in_array(auth()->user()->role, ['admin', 'owner'])) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the current and new password fields
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update the password and save the user
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect back with success message
        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Check if the authenticated user can delete this account
        if ($id != auth()->id() && !in_array(auth()->user()->role, ['admin', 'owner'])) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the user is trying to delete their own account (additional check)
        if ($request->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Log the user out and delete their account
        Auth::logout();
        $user->delete();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to home page
        return Redirect::to('/');
    }
}
