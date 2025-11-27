<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Owners have full system access, even without company association
        if ($user->role === 'owner') {
            return $next($request);
        }

        // For other roles, require company association
        if (!$user->company_id) {
            abort(403, 'User not associated with a company.');
        }

        $roleHierarchy = ['read-only' => 1, 'admin' => 2, 'owner' => 3];
        $userRoleLevel = $roleHierarchy[$user->role] ?? 0;

        $requiredLevel = PHP_INT_MAX;
        foreach ($roles as $role) {
            $requiredLevel = min($requiredLevel, $roleHierarchy[$role] ?? PHP_INT_MAX);
        }

        if ($userRoleLevel < $requiredLevel) {
            abort(403, 'Insufficient permissions.');
        }

        return $next($request);
    }
}
