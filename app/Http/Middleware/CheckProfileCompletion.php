<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {
            if (!$user->is_profile_completed && $user->is_profile_deadline_passed) {
                if ($user->hasRole('ustadz') && !$request->routeIs('ustadz.profile*', 'ustadzah.profile*', 'logout')) {
                    $prefix = $user->teacher_route_prefix;
                    return redirect()->route("{$prefix}.profile")
                        ->with('error', '⛔ Batas waktu 3 hari pengisian biodata KTP & KK telah berakhir. Silakan lengkapi biodata resmi Anda di bawah ini terlebih dahulu.');
                }

                if ($user->hasRole('wali') && !$request->routeIs('wali.profile*', 'logout')) {
                    return redirect()->route('wali.profile')
                        ->with('error', '⛔ Batas waktu 3 hari pengisian biodata Kartu Keluarga (KK) / KTP Wali telah berakhir. Silakan lengkapi biodata di bawah ini terlebih dahulu.');
                }
            }
        }

        return $next($request);
    }
}
