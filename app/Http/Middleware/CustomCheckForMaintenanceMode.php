<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class CustomCheckForMaintenanceMode extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Secret key for accessing the site during maintenance mode
        $secretKey = 'temitopemi';

        // Check if the application is in maintenance mode
        if ($this->app->isDownForMaintenance()) {
            // Allow access for admins
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Allow access using the secret key
            if ($request->has('secret') && $request->input('secret') === $secretKey) {
                return $next($request);
            }

            // Fetch site name and email from settings
            $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Default Site Name');
            $siteEmail = \App\Models\WebsiteSetting::getValue('site_email', 'default@example.com');

            // Respond with a 503 Service Unavailable and Retry-After header
            return response()->view('errors.503', compact('siteName', 'siteEmail'), 503)
                ->header('Retry-After', 86400); // Retry after 1 day (86400 seconds)
        }

        return $next($request);
    }
}
