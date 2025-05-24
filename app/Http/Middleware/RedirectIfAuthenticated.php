<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Jika mencoba akses login admin tapi sudah login
                if ($request->routeIs('admin.login')) {
                    if ($user->role === 'admin') return redirect(RouteServiceProvider::HOME_ADMIN);
                    // Jika bukan admin, biarkan (controller login admin akan handle) atau redirect ke dashboardnya
                    // atau bahkan logout dulu user saat ini
                }
                // Jika mencoba akses login tenant tapi sudah login
                elseif ($request->routeIs('tenant.login')) {
                    if ($user->role === 'tenant' && $user->tenantProfile()->exists()) {
                        return redirect(RouteServiceProvider::HOME_TENANT);
                    }
                    // Jika bukan tenant yang valid, biarkan (controller login tenant akan handle)
                }
                // Untuk halaman login customer standar (misal, route('login') dari Breeze)
                elseif ($request->routeIs('login')) { // Asumsi route login customer bernama 'login'
                    if ($user->role === 'admin') return redirect(RouteServiceProvider::HOME_ADMIN);
                    if ($user->role === 'tenant' && $user->tenantProfile()->exists()) return redirect(RouteServiceProvider::HOME_TENANT);
                    // Untuk customer atau user tanpa role spesifik, arahkan ke HOME_CUSTOMER
                    return redirect(RouteServiceProvider::HOME_CUSTOMER);
                }
            }
        }
        return $next($request);
    }
}