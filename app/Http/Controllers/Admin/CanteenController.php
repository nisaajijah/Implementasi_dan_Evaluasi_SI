<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Canteen; // Import model Canteen
use Illuminate\Http\Request;
use Illuminate\View\View; // Untuk return type View
use Illuminate\Http\RedirectResponse; // Untuk return type RedirectResponse
use Illuminate\Support\Facades\Storage; // Untuk manajemen file (gambar)

class CanteenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $canteens = Canteen::latest()->paginate(10); // Ambil semua kantin, urutkan terbaru, paginasi 10 per halaman
        return view('admin.canteens.index', compact('canteens'), ['title' => 'Manajemen Kantin']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.canteens.create', ['title' => 'Tambah Kantin Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:canteens,name',
            'location_description' => 'nullable|string|max:1000',
            'operating_hours' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Max 2MB
        ]);

        $data = $request->only(['name', 'location_description', 'operating_hours']);

        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/canteens
            // Nama file akan di-generate unik oleh Laravel
            $filePath = $request->file('image')->store('canteens', 'public');
            $data['image'] = $filePath;
        }

        Canteen::create($data);

        return redirect()->route('admin.canteens.index')
                         ->with('success', 'Kantin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Opsional untuk admin, biasanya tidak langsung digunakan jika ada halaman edit)
     */
    public function show(Canteen $canteen): View
    {
        // Jika Anda ingin halaman detail khusus (read-only)
        return view('admin.canteens.show', compact('canteen'), ['title' => 'Detail Kantin: ' . $canteen->name]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Canteen $canteen): View // Route model binding
    {
        return view('admin.canteens.edit', compact('canteen'), ['title' => 'Edit Kantin: ' . $canteen->name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Canteen $canteen): RedirectResponse // Route model binding
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:canteens,name,' . $canteen->id, // Abaikan unique check untuk record saat ini
            'location_description' => 'nullable|string|max:1000',
            'operating_hours' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'location_description', 'operating_hours']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($canteen->image && Storage::disk('public')->exists($canteen->image)) {
                Storage::disk('public')->delete($canteen->image);
            }
            // Simpan gambar baru
            $filePath = $request->file('image')->store('canteens', 'public');
            $data['image'] = $filePath;
        }

        $canteen->update($data);

        return redirect()->route('admin.canteens.index')
                         ->with('success', 'Kantin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Canteen $canteen): RedirectResponse // Route model binding
    {
        // Hapus gambar terkait jika ada
        if ($canteen->image && Storage::disk('public')->exists($canteen->image)) {
            Storage::disk('public')->delete($canteen->image);
        }

        $canteen->delete();

        return redirect()->route('admin.canteens.index')
                         ->with('success', 'Kantin berhasil dihapus.');
    }
}