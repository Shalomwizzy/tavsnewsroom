<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOrWriterRoleChecker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('welcome');
        }

        $role = Auth::user()->role;
        if (!in_array($role, ['admin', 'writer'])) {
            return redirect()->route('errors.404');
        }

        return $next($request);
    }
}
