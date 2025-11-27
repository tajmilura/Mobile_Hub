<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        if (Setting::isMaintenanceMode()) {
            
            // Allow admin users to access the site normally
            if ($request->user() && $request->user()->role === 'admin') {
                // Add a warning message for admin
                if ($request->session()) {
                    $request->session()->flash('maintenance_warning', 'Maintenance mode is currently enabled. Regular users cannot access the site.');
                }
                return $next($request);
            }

            // Allow access to maintenance page itself and admin routes
            if ($request->is('maintenance') || 
                $request->is('admin/*') || 
                $request->is('login') || 
                $request->is('logout')) {
                return $next($request);
            }

            // Allow access to static assets (CSS, JS, images)
            if ($request->is('css/*') || 
                $request->is('js/*') || 
                $request->is('storage/*') || 
                $request->is('images/*')) {
                return $next($request);
            }

            // Redirect all other requests to maintenance page
            if (!$request->is('maintenance')) {
                return redirect()->route('maintenance.page');
            }
        }

        return $next($request);
    }
}