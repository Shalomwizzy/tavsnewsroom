<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleChecker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('welcome');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('errors.404');
        }

        return $next($request);
    }
}
