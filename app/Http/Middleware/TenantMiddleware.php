<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah user adalah tenant DAN memiliki profil tenant yang terhubung
        if ($user->role == 'tenant' && $user->tenantProfile()->exists()) {
            return $next($request);
        }

        // Jika bukan tenant atau tidak punya profil tenant, bisa diarahkan ke dashboard umum atau logout
        // Untuk sekarang, kita arahkan ke dashboard default Breeze jika ada, atau logout dengan pesan.
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Anda adalah Admin, bukan Tenant.');
        }

        // Jika user adalah tenant tapi belum ada profil (seharusnya tidak terjadi jika admin membuat dengan benar)
        if ($user->role == 'tenant' && !$user->tenantProfile()->exists()) {
            Auth::logout(); // Logout user
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Akun tenant Anda belum dikonfigurasi dengan benar. Hubungi Admin.');
        }

        // Untuk role lain (misal customer)
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke area tenant.');
    }
}