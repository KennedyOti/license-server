<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('x-api-key');

        if (!$apiKey) {
            return response()->json(['error' => 'API key required'], 401);
        }

        $company = Company::where('api_key', $apiKey)->first();

        if (!$company) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        // Add company to request for use in controllers
        $request->merge(['company' => $company]);

        return $next($request);
    }
}
