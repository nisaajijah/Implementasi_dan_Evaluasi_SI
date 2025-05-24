<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule; // Untuk validasi unique yang scoped

class MenuItemController extends Controller
{
    private function getTenantId()
    {
        // Mendapatkan ID tenant dari user yang sedang login
        return Auth::user()->tenantProfile->id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tenantId = $this->getTenantId();
        $menuItems = MenuItem::where('tenant_id', $tenantId)
                             ->latest()
                             ->paginate(10);

        return view('tenant.menu-items.index', compact('menuItems'), ['title' => 'Manajemen Menu Saya']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Kategori bisa diambil dari database jika ada tabel kategori, atau hardcode
        $categories = ['Makanan Berat', 'Makanan Ringan', 'Minuman Dingin', 'Minuman Panas', 'Snack', 'Lainnya'];
        return view('tenant.menu-items.create', compact('categories'), ['title' => 'Tambah Menu Baru']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $tenantId = $this->getTenantId();
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_items')->where(function ($query) use ($tenantId) {
                    return $query->where('tenant_id', $tenantId);
                }),
                // Nama menu harus unik per tenant
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'stock' => 'nullable|integer|min:-1', // -1 bisa berarti tak terbatas
            'is_available' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // Max 2MB
        ]);

        $data = $request->only(['name', 'description', 'price', 'category', 'stock']);
        $data['tenant_id'] = $tenantId;
        $data['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : true;
        if ($data['stock'] === null) $data['stock'] = -1; // Set default stock jika null

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('menu_items_images', 'public');
            $data['image'] = $filePath;
        }

        MenuItem::create($data);

        return redirect()->route('tenant.menu-items.index')
                         ->with('success', 'Menu item berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Biasanya tidak diperlukan jika ada edit, tapi bisa untuk preview)
     */
    public function show(MenuItem $menuItem): View // Route model binding
    {
        // Pastikan menu item ini milik tenant yang login
        if ($menuItem->tenant_id !== $this->getTenantId()) {
            abort(403, 'Akses ditolak.');
        }
        return view('tenant.menu-items.show', compact('menuItem'), ['title' => 'Detail Menu: ' . $menuItem->name]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem): View
    {
        if ($menuItem->tenant_id !== $this->getTenantId()) {
            abort(403, 'Akses ditolak.');
        }
        $categories = ['Makanan Berat', 'Makanan Ringan', 'Minuman Dingin', 'Minuman Panas', 'Snack', 'Lainnya'];
        return view('tenant.menu-items.edit', compact('menuItem', 'categories'), ['title' => 'Edit Menu: ' . $menuItem->name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $tenantId = $this->getTenantId();
        if ($menuItem->tenant_id !== $tenantId) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_items')->where(function ($query) use ($tenantId) {
                    return $query->where('tenant_id', $tenantId);
                })->ignore($menuItem->id),
            ],
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'stock' => 'nullable|integer|min:-1',
            'is_available' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category', 'stock']);
        $data['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : $menuItem->is_available;
        if ($data['stock'] === null && $menuItem->stock === null) $data['stock'] = -1;
        elseif ($data['stock'] === null) $data['stock'] = $menuItem->stock;


        if ($request->hasFile('image')) {
            if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $filePath = $request->file('image')->store('menu_items_images', 'public');
            $data['image'] = $filePath;
        }

        $menuItem->update($data);

        return redirect()->route('tenant.menu-items.index')
                         ->with('success', 'Menu item berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        if ($menuItem->tenant_id !== $this->getTenantId()) {
            abort(403, 'Akses ditolak.');
        }

        if ($menuItem->image && Storage::disk('public')->exists($menuItem->image)) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()->route('tenant.menu-items.index')
                         ->with('success', 'Menu item berhasil dihapus.');
    }
}