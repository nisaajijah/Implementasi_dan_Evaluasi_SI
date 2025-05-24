<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Logika Redirect Berdasarkan Role
        $user = Auth::user();
        $redirectPath = '';

        if ($user->role === 'admin') {
            $redirectPath = RouteServiceProvider::HOME_ADMIN;
        } elseif ($user->role === 'tenant') {
            // Pastikan tenant memiliki profil, jika tidak, mungkin logout atau arahkan ke halaman setup
            if (!$user->tenantProfile()->exists()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Profil tenant Anda belum lengkap. Hubungi admin.');
            }
            $redirectPath = RouteServiceProvider::HOME_TENANT;
        } else { // Default untuk 'customer' atau role lain
            $redirectPath = RouteServiceProvider::HOME_CUSTOMER;
        }

        return redirect()->intended($redirectPath);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
