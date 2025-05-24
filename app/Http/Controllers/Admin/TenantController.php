<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User; // Untuk membuat user baru bagi tenant
use App\Models\Canteen; // Untuk dropdown pilihan kantin
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash; // Untuk hashing password user
use Illuminate\Support\Facades\Storage; // Untuk manajemen file (logo)
use Illuminate\Validation\Rules; // Untuk aturan validasi password

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tenants = Tenant::with(['user', 'canteen'])->latest()->paginate(10);
        return view('admin.tenants.index', compact('tenants'), ['title' => 'Manajemen Tenant']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $canteens = Canteen::orderBy('name')->pluck('name', 'id'); // Ambil kantin untuk dropdown
        return view('admin.tenants.create', compact('canteens'), ['title' => 'Tambah Tenant Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Validasi untuk User baru
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Validasi untuk Tenant
            'tenant_name' => 'required|string|max:255',
            'canteen_id' => 'required|exists:canteens,id',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', // Max 1MB untuk logo
            'is_open' => 'sometimes|boolean',
        ]);

        // 1. Buat User baru untuk Tenant
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tenant', // Set role sebagai tenant
            'email_verified_at' => now(), // Langsung verifikasi email untuk tenant
        ]);

        // 2. Siapkan data untuk Tenant
        $tenantData = [
            'user_id' => $user->id,
            'canteen_id' => $request->canteen_id,
            'name' => $request->tenant_name,
            'description' => $request->description,
            'is_open' => $request->has('is_open') ? $request->boolean('is_open') : true, // default true jika tidak ada
        ];

        if ($request->hasFile('logo')) {
            $filePath = $request->file('logo')->store('tenants_logos', 'public');
            $tenantData['logo'] = $filePath;
        }

        Tenant::create($tenantData);

        return redirect()->route('admin.tenants.index')
                         ->with('success', 'Tenant berhasil ditambahkan beserta akun user-nya.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant): View
    {
        $tenant->load(['user', 'canteen', 'menuItems']); // Load relasi
        return view('admin.tenants.show', compact('tenant'), ['title' => 'Detail Tenant: ' . $tenant->name]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant): View
    {
        $canteens = Canteen::orderBy('name')->pluck('name', 'id');
        $tenant->load('user'); // Load user terkait
        return view('admin.tenants.edit', compact('tenant', 'canteens'), ['title' => 'Edit Tenant: ' . $tenant->name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $request->validate([
            // Validasi untuk User (email mungkin diupdate, nama)
            // Password diupdate terpisah jika diperlukan, untuk simplisitas tidak di sini
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$tenant->user_id], // ignore current user

            // Validasi untuk Tenant
            'tenant_name' => 'required|string|max:255',
            'canteen_id' => 'required|exists:canteens,id',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'is_open' => 'sometimes|boolean',
        ]);

        // 1. Update User terkait
        $tenant->user->update([
            'name' => $request->user_name,
            'email' => $request->email,
        ]);
        // Jika ingin ada opsi reset password tenant oleh admin, bisa ditambahkan di sini

        // 2. Siapkan data untuk Tenant
        $tenantData = [
            'canteen_id' => $request->canteen_id,
            'name' => $request->tenant_name,
            'description' => $request->description,
            'is_open' => $request->has('is_open') ? $request->boolean('is_open') : $tenant->is_open,
        ];

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($tenant->logo && Storage::disk('public')->exists($tenant->logo)) {
                Storage::disk('public')->delete($tenant->logo);
            }
            $filePath = $request->file('logo')->store('tenants_logos', 'public');
            $tenantData['logo'] = $filePath;
        }

        $tenant->update($tenantData);

        return redirect()->route('admin.tenants.index')
                         ->with('success', 'Data Tenant berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant): RedirectResponse
    {
        // Hapus logo terkait
        if ($tenant->logo && Storage::disk('public')->exists($tenant->logo)) {
            Storage::disk('public')->delete($tenant->logo);
        }

        // Hapus user terkait dengan tenant (opsional, tergantung kebijakan)
        // Jika user ini hanya untuk tenant dan tidak ada kegunaan lain, lebih baik dihapus.
        // Jika user bisa memiliki peran lain atau data lain, mungkin jangan dihapus.
        // Untuk kasus ini, kita anggap user dibuat khusus untuk tenant, jadi ikut dihapus.
        // Pastikan relasi user->tenantProfile() ada dan onDelete('cascade') tidak diset di profil tenant di user.
        // Atau jika tenant dihapus, user nya juga. Migrasi tenant kita user_id constrained('users')->onDelete('cascade')
        // Jadi jika User dihapus, Tenant akan terhapus. Sebaliknya, jika Tenant dihapus, User-nya tidak otomatis terhapus KECUALI
        // kita hapus User secara manual di sini.
        // User yang berelasi dengan tenant (user_id di tabel tenants) memiliki onDelete('cascade'),
        // artinya jika User dihapus, maka Tenant yang berelasi dengannya akan ikut terhapus.
        // Di sini kita menghapus Tenant, User nya tidak otomatis terhapus oleh database.
        // Jadi kita hapus User nya secara manual.
        if ($tenant->user) {
             $tenant->user->delete(); // Ini akan otomatis menghapus tenant juga karena cascade dari user.
                                     // Sebaiknya, hapus tenant dulu, baru user nya.
        }
        // Oleh karena itu, kita hapus tenant dulu, kemudian user-nya.
        $userAssociated = $tenant->user; // simpan referensi user
        $tenant->delete(); // Hapus tenant. Ini tidak akan menghapus user.

        if($userAssociated){ // jika usernya masih ada
            // Cek apakah user ini masih punya tenant lain (seharusnya tidak jika 1 user 1 tenant)
            // atau apakah user ini punya peran lain. Untuk kasus kita, tenant user adalah dedicated.
            $userAssociated->delete();
        }


        return redirect()->route('admin.tenants.index')
                         ->with('success', 'Tenant dan akun user terkait berhasil dihapus.');
    }
}