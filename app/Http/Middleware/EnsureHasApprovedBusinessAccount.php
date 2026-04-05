<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasApprovedBusinessAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $hasApprovedAccount = $user->businessAccounts()
            ->where('status', 'approved')
            ->exists();

        if (!$hasApprovedAccount)
            return errorResponse('You must have an approved business account to access this resource.', 403);
        
        return $next($request);
    }
}
