<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OrganizationSetting;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     * If maintenance mode is on, show the 503 page.
     * Admin users are always allowed through.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isMaintenance = (bool) OrganizationSetting::get('maintenance_mode', '0');

        if ($isMaintenance) {
            // Allow admin users to bypass maintenance mode
            if (auth()->check() && auth()->user()->hasRole('admin')) {
                return $next($request);
            }

            // Allow admin login page and logout
            $allowedPaths = [
                'login',
                'logout',
                'admin/login',
            ];

            foreach ($allowedPaths as $path) {
                if ($request->is($path)) {
                    return $next($request);
                }
            }

            // Return 503 maintenance view
            $message = OrganizationSetting::get('maintenance_message', null);
            return response()->view('errors.503', [
                'maintenance_message' => $message,
            ], 503);
        }

        return $next($request);
    }
}
