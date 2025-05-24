<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule; // Untuk Rule::in

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::with('tenantProfile')->latest()->paginate(10); // Eager load tenantProfile jika ada
        return view('admin.users.index', compact('users'), ['title' => 'Manajemen Pengguna']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = ['admin' => 'Admin', 'tenant' => 'Tenant', 'customer' => 'Customer']; // Definisikan role yang bisa dipilih
        return view('admin.users.create', compact('roles'), ['title' => 'Tambah Pengguna Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', Rule::in(['admin', 'tenant', 'customer'])],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Admin yang membuat user, anggap langsung verified
        ]);

        // Jika role adalah 'tenant', mungkin perlu redirect ke halaman pembuatan detail tenant
        // atau memberikan notifikasi untuk melengkapi profil tenant.
        // Untuk saat ini, kita biarkan sederhana. Pembuatan profil tenant terpisah.

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Biasanya tidak terlalu dibutuhkan jika ada edit, tapi bisa untuk detail view)
     */
    public function show(User $user): View
    {
        $user->load('tenantProfile', 'ordersAsCustomer', 'announcementsAuthored'); // Load relasi yang mungkin relevan
        return view('admin.users.show', compact('user'), ['title' => 'Detail Pengguna: ' . $user->name]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Admin tidak boleh mengedit dirinya sendiri melalui form ini untuk mencegah self-lockout role
        // if ($user->id === auth()->id()) {
        //     return redirect()->route('admin.users.index')
        //                      ->with('error', 'Anda tidak dapat mengedit profil Anda sendiri melalui halaman ini. Gunakan halaman profil.');
        // }
        // Namun, untuk latihan ini, kita biarkan bisa. Hati-hati saat mengedit role user admin yang sedang login.

        $roles = ['admin' => 'Admin', 'tenant' => 'Tenant', 'customer' => 'Customer'];
        return view('admin.users.edit', compact('user', 'roles'), ['title' => 'Edit Pengguna: ' . $user->name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Admin tidak boleh mengubah role dirinya sendiri menjadi non-admin jika hanya ada satu admin
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->back()
                                 ->with('error', 'Tidak dapat mengubah role admin terakhir. Buat admin lain terlebih dahulu.');
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'role' => ['required', 'string', Rule::in(['admin', 'tenant', 'customer'])],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password opsional saat update
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Jika role diubah dari/ke tenant, mungkin ada logika tambahan terkait TenantProfile
        // Misal: jika user menjadi tenant, buatkan TenantProfile kosong
        // Jika user tidak lagi tenant, hapus TenantProfile nya (jika ada dan kosong)
        // Ini bisa jadi kompleks, untuk saat ini kita fokus pada perubahan role User saja.
        // Asumsi: Jika role diubah menjadi 'tenant', admin harus membuat profil Tenant secara manual via CRUD Tenant.

        $user->update($userData);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Mencegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Mencegah penghapusan admin terakhir
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                 return redirect()->route('admin.users.index')
                                 ->with('error', 'Tidak dapat menghapus admin terakhir. Buat admin lain atau ubah role admin ini terlebih dahulu.');
            }
        }

        // Jika user adalah tenant, profil tenant dan menu-itemnya akan otomatis terhapus
        // karena onDelete('cascade') pada tenant.user_id dan menu_item.tenant_id
        // Jika user adalah customer, ordernya juga akan otomatis terhapus karena onDelete('cascade') pada order.user_id
        // Jika user adalah author announcement, announcementnya juga akan otomatis terhapus.

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', "Pengguna '{$userName}' dan data terkait berhasil dihapus.");
    }
}