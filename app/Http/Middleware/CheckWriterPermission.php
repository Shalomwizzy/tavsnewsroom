<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWriterPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Admins always pass through
        if (!$user || $user->role === 'admin') {
            return $next($request);
        }

        // Writers: check the current route against their permissions
        $routeName = $request->route()?->getName() ?? '';
        $section   = $this->resolveSection($routeName);

        // Route doesn't belong to any section → allow (e.g. dashboard, profile)
        if ($section === null) {
            return $next($request);
        }

        $allowed = $user->permissions ?? [];

        if (!in_array($section, $allowed, true)) {
            abort(403, 'You do not have permission to access this section.');
        }

        return $next($request);
    }

    private function resolveSection(string $routeName): ?string
    {
        foreach (config('writer_permissions.sections') as $section => $def) {
            foreach ($def['routes'] as $prefix) {
                if (str_starts_with($routeName, $prefix) || $routeName === $prefix) {
                    return $section;
                }
            }
        }

        return null;
    }
}
