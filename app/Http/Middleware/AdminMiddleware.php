<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login');
        }

        // 2. Cek apakah user yang login memiliki role 'admin'
        if (Auth::user()->role == 'admin') {
            // Jika user adalah admin, lanjutkan request ke controller/route berikutnya
            return $next($request);
        }

        // 3. Jika user login tetapi bukan admin
        // Anda bisa redirect ke halaman utama dengan pesan error, atau tampilkan halaman 403 (Forbidden)
        // Opsi 1: Redirect ke halaman utama dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        // Catatan: '/dashboard' adalah route default Breeze setelah login.
        // Anda mungkin ingin menggantinya dengan route homepage jika berbeda.

        // Opsi 2: Tampilkan halaman error 403 (Unauthorize Action)
        // abort(403, 'Unauthorized action.');
    }
}