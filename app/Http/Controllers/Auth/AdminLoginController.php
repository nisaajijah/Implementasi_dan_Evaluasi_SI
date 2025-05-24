<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Kita bisa re-use LoginRequest dari Breeze
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function create(): View
    {
        // Pastikan admin yang sudah login tidak bisa akses halaman login admin lagi
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
        }
        // Jika user lain yang login, redirect ke dashboard mereka atau logout dulu
        if (Auth::check() && Auth::user()->role !== 'admin') {
            // Pilihan: logout user saat ini atau redirect ke dashboard mereka
            // Auth::logout();
            // request()->session()->invalidate();
            // request()->session()->regenerateToken();
            // return redirect()->route('admin.login')->with('message', 'Anda telah logout untuk login sebagai admin.');
            // atau redirect ke dashboard mereka
            if (Auth::user()->role === 'tenant') return redirect(RouteServiceProvider::HOME_TENANT);
            return redirect(RouteServiceProvider::HOME_CUSTOMER);

        }

        return view('auth.admin-login'); // View baru yang akan kita buat
    }

    /**
     * Handle an incoming admin authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Coba autentikasi dengan guard default 'web'
        // Kita akan menambahkan pengecekan role setelah autentikasi berhasil
        $request->authenticate(); // Ini menggunakan kredensial email & password

        // PENTING: Cek Role setelah autentikasi kredensial berhasil
        if (Auth::user()->role !== 'admin') {
            Auth::logout(); // Logout user jika bukan admin
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                             ->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
    }

    /**
     * Destroy an authenticated session for admin.
     * Jika Anda ingin logout admin terpisah dan mengarahkannya ke login admin.
     * Jika tidak, admin bisa logout menggunakan route logout standar Breeze.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Pastikan hanya logout dari guard 'web' jika tidak menggunakan guard khusus admin
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login'); // Arahkan ke login admin
    }
}