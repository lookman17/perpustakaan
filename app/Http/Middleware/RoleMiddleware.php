<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('failed', 'Silahkan login terlebih dahulu');
        }

        // Ambil informasi pengguna yang login
        $user = Auth::user();

        // Periksa level pengguna berdasarkan parameter
        if ($user->user_level !== $role) {
            abort(404, 'Unauthorized'); // Tampilkan error 404 jika level tidak sesuai
        }

        // Lanjutkan permintaan
        return $next($request);
    }

}
