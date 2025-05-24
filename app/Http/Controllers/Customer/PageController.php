<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; 
use App\Models\Announcement; 

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page).
     */
    // app/Http/Controllers/Customer/PageController.php
    public function home(): View
    {
        $canteensForDisplay = Canteen::whereHas('tenants', function ($q) { // Hanya tampilkan kantin yg punya tenant
            $q->where('is_open', true)->has('menuItems');
        })
            ->inRandomOrder() // Atau orderBy('name')
            ->take(3)->get();
        $totalCanteenCount = Canteen::count();
        // $announcements = ...

        return view('customer.home', [
            'canteens' => $canteensForDisplay,
            'totalCanteenCount' => $totalCanteenCount,
            // 'announcements' => $announcements,
            'title' => 'Selamat Datang di E-Canteen UIN' // Judul lebih deskriptif
        ]);
    }

    /**
     * Menampilkan dashboard customer.
     * Bisa menampilkan ringkasan pesanan terakhir, pengumuman, dll.
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        // 1. Ambil beberapa pesanan aktif/terbaru milik customer
        $activeOrders = $user->ordersAsCustomer()
                            ->with(['tenant', 'items']) // Eager load untuk info singkat
                            ->whereNotIn('status', ['completed', 'cancelled', 'delivered']) // Status yang masih berjalan
                            ->orderBy('created_at', 'desc')
                            ->take(3) // Ambil 3 pesanan terbaru yang aktif
                            ->get();

        // 2. Ambil beberapa pengumuman terbaru yang aktif dan sudah publish
        $announcements = Announcement::where('is_active', true)
                                     ->where(function($query) {
                                         $query->whereNull('published_at') // Langsung publish jika null
                                               ->orWhere('published_at', '<=', now()); // Atau sudah melewati tanggal publish
                                     })
                                     ->orderByRaw('ISNULL(published_at) DESC, published_at DESC') // Prioritaskan yang null (langsung publish), lalu terbaru
                                     ->take(3)
                                     ->get();
        // Status pesanan untuk mapping di view
        $orderStatuses = [
            'pending_payment' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'processing' => 'Sedang Diproses',
            'ready_for_pickup' => 'Siap Diambil',
            'out_for_delivery' => 'Sedang Dikirim',
            'delivered' => 'Terkirim (Sampai)',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];


        return view('customer.dashboard', compact('user', 'activeOrders', 'announcements', 'orderStatuses'), ['title' => 'Dashboard Saya']);
    }


    /**
     * Menampilkan daftar semua kantin.
     */
    public function listCanteens(): View
    {
        $canteens = Canteen::orderBy('name')->get();
        return view('customer.canteens.index', compact('canteens'), ['title' => 'Pilih Kantin']);
    }

    /**
     * Menampilkan daftar tenant dalam satu kantin.
     */
    public function listTenants(Canteen $canteen): View // Route Model Binding
    {
        // Eager load tenants yang sedang buka dan memiliki menu item
        $canteen->load(['tenants' => function ($query) {
            $query->where('is_open', true)->has('menuItems')->orderBy('name');
        }]);
        return view('customer.canteens.tenants', compact('canteen'), ['title' => 'Pilih Tenant di ' . $canteen->name]);
    }

    /**
     * Menampilkan menu dari satu tenant.
     */
    public function showTenantMenu(Tenant $tenant): View|RedirectResponse // <--- PERUBAHAN DI SINI
    {
        // Pastikan tenant buka
        if (!$tenant->is_open) {
            // Redirect atau tampilkan pesan bahwa tenant tutup
            return redirect()->route('customer.canteens.tenants.index', $tenant->canteen_id)
                ->with('error', 'Maaf, tenant ' . $tenant->name . ' sedang tutup.');
        }

        // Eager load menu items yang tersedia dan canteen
        $tenant->load(['menuItems' => function ($query) {
            $query->where('is_available', true)->orderBy('category')->orderBy('name');
        }, 'canteen']);

        // Ambil juga kategori unik dari menu tenant tersebut
        $categories = $tenant->menuItems->pluck('category')->unique()->filter()->sort();

        return view('customer.tenants.menu', compact('tenant', 'categories'), ['title' => 'Menu ' . $tenant->name]);
    }
}
