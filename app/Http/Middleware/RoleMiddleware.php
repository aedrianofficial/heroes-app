<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role, string $agency = null)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['login' => 'You must be logged in.']);
        }

        $user = Auth::user();

        // Check role
        if ($user->role->name !== $role) {
            return redirect('/login')->withErrors(['login' => 'Unauthorized access.']);
        }

        // Check agency if provided
        if ($agency && $user->agency->name !== $agency) {
            return redirect('/login')->withErrors(['login' => 'You are not authorized for this agency.']);
        }

        return $next($request);
    }
}
