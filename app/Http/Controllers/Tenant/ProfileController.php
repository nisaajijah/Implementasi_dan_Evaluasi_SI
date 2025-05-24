<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Tenant; // Model Tenant

class ProfileController extends Controller
{
    /**
     * Show the form for editing the tenant's profile.
     */
    public function edit(): View
    {
        $tenant = Auth::user()->tenantProfile; // Mengambil profil tenant yang sedang login
        if (!$tenant) {
            // Seharusnya tidak terjadi jika middleware tenant bekerja dengan benar
            abort(404, 'Profil tenant tidak ditemukan.');
        }
        return view('tenant.profile.edit', compact('tenant'), ['title' => 'Pengaturan Profil Toko']);
    }

    /**
     * Update the tenant's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $tenant = Auth::user()->tenantProfile;
        if (!$tenant) {
            abort(404, 'Profil tenant tidak ditemukan.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', // Max 1MB
            'is_open' => 'sometimes|boolean',
            // Tambahkan validasi untuk jam operasional jika ada fieldnya
            // 'operating_hours' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name', 'description' /*, 'operating_hours' */]);
        $data['is_open'] = $request->has('is_open') ? $request->boolean('is_open') : false;

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($tenant->logo && Storage::disk('public')->exists($tenant->logo)) {
                Storage::disk('public')->delete($tenant->logo);
            }
            // Simpan logo baru
            $filePath = $request->file('logo')->store('tenants_logos', 'public');
            $data['logo'] = $filePath;
        }

        $tenant->update($data);

        return redirect()->route('tenant.profile.edit')
                         ->with('success', 'Profil toko berhasil diperbarui.');
    }
}