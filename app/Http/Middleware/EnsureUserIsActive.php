<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && strtolower((string) $user->status) !== 'aktif') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akun pengguna tidak aktif. Silakan hubungi administrator.',
                ], 403);
            }

            return redirect()->route('login')->withErrors([
                'username' => 'Akun Anda tidak aktif. Silakan hubungi administrator SIPD.',
            ]);
        }

        return $next($request);
    }
}
