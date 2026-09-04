<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSppLock
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->hasRole('wali')) {
            // Check if wali has overdue SPP payment >= 1 month
            if ($user->has_overdue_spp) {
                // Allow payment routes, profile routes, and logout
                if (!$request->routeIs('wali.payments*', 'wali.profile*', 'logout')) {
                    return redirect()->route('wali.payments.index')
                        ->with('error', '⛔ Akses Portal Terkunci: Terdapat tunggakan SPP (>= 1 bulan) yang belum diverifikasi. Silakan selesaikan pembayaran SPP melalui halaman ini.');
                }
            }
        }

        return $next($request);
    }
}
