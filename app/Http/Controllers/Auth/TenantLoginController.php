<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Re-use LoginRequest dari Breeze
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TenantLoginController extends Controller
{
    /**
     * Display the tenant login view.
     */
    public function create(): View
    {
        // Pastikan tenant yang sudah login tidak bisa akses halaman login tenant lagi
        if (Auth::check() && Auth::user()->role === 'tenant' && Auth::user()->tenantProfile()->exists()) {
            return redirect()->intended(RouteServiceProvider::HOME_TENANT);
        }

        // Jika user lain yang login, redirect ke dashboard mereka atau logout dulu
        if (Auth::check() && Auth::user()->role !== 'tenant') {
            if (Auth::user()->role === 'admin') return redirect(RouteServiceProvider::HOME_ADMIN);
            return redirect(RouteServiceProvider::HOME_CUSTOMER);
        }

        // Jika role tenant tapi belum ada profil (seharusnya ditangani saat Admin membuat Tenant)
        if (Auth::check() && Auth::user()->role === 'tenant' && !Auth::user()->tenantProfile()->exists()) {
             Auth::logout();
             request()->session()->invalidate();
             request()->session()->regenerateToken();
             return redirect()->route('tenant.login')->withErrors(['email' => 'Profil tenant Anda tidak lengkap. Hubungi Admin.']);
        }


        return view('auth.tenant-login'); // View baru yang akan kita buat
    }

    /**
     * Handle an incoming tenant authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Autentikasi kredensial email & password

        $user = Auth::user();

        // PENTING: Cek Role dan Profil Tenant setelah autentikasi kredensial berhasil
        if ($user->role !== 'tenant' || !$user->tenantProfile()->exists()) {
            Auth::logout(); // Logout user jika bukan tenant atau tidak punya profil tenant
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $errorMessage = 'Akun ini tidak memiliki akses tenant.';
            if ($user->role === 'tenant' && !$user->tenantProfile()->exists()) {
                $errorMessage = 'Profil tenant Anda belum diaktifkan atau tidak lengkap. Hubungi Admin.';
            }

            return redirect()->route('tenant.login')
                             ->withErrors(['email' => $errorMessage]);
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME_TENANT);
    }

    /**
     * Destroy an authenticated session for tenant.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.login'); // Arahkan ke login tenant
    }
}