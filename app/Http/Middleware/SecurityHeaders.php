<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach HTTP security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Protect against Clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Protect against MIME-type sniffing attacks
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable cross-site scripting filter in browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Restrict referrer information sent with requests
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Limit browser capabilities to authorized functions
        $response->headers->set('Permissions-Policy', 'geolocation=(self), camera=(), microphone=()');

        // Content Security Policy (CSP)
        $csp = "default-src 'self'; "
             . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com https://cdn.tailwindcss.com; "
             . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net https://unpkg.com https://cdnjs.cloudflare.com; "
             . "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com; "
             . "img-src 'self' data: blob: https://* http://*; "
             . "media-src 'self' data: blob: https://res.cloudinary.com https://* http://*; "
             . "connect-src 'self' https://* http://* ws: wss:; "
             . "frame-src 'self' https://* http://*;";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
