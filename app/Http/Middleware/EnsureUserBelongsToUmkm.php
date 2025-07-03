<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserBelongsToUmkm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Pastikan user memiliki UMKM
        if (!$user->umkm_id) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda tidak terdaftar dengan UMKM manapun.'
            ]);
        }

        // Pastikan UMKM masih aktif
        if ($user->umkm && $user->umkm->status !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'UMKM Anda sedang tidak aktif. Silakan hubungi administrator.'
            ]);
        }

        // Pastikan user masih aktif
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang tidak aktif. Silakan hubungi administrator.'
            ]);
        }

        return $next($request);
    }
}
