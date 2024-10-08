<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // If the user is not authenticated, redirect to the welcome page
            return redirect()->route('welcome');
        }
        
        $role = Auth::user()->role;
        if ($role === 'admin' || $role === 'writer') {
            // If the user has the required role, proceed with the request
            return $next($request);
        }
        
        // If the user is authenticated but does not have the required role, redirect to the 404 error page
        return redirect()->route('errors.404');
    }
}
