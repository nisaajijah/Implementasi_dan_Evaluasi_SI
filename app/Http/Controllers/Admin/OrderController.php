<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['customer', 'tenant', 'items.menuItem'])
                      ->latest(); // Urutkan berdasarkan terbaru

        // Contoh Fitur Pencarian Sederhana (bisa dikembangkan)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('tenant', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Contoh Filter berdasarkan Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString(); // withQueryString agar parameter filter/search tetap ada di link paginasi

        // Data untuk filter dropdown (jika diperlukan)
        $statuses = [
            'pending_payment' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'processing' => 'Diproses',
            'ready_for_pickup' => 'Siap Diambil',
            'out_for_delivery' => 'Dikirim',
            'delivered' => 'Terkirim (Sampai)',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];


        return view('admin.orders.index', compact('orders', 'statuses'), ['title' => 'Monitoring Transaksi']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View // Menggunakan Route Model Binding
    {
        // Eager load relasi yang dibutuhkan untuk detail view
        $order->load(['customer', 'tenant', 'items.menuItem']);
        return view('admin.orders.show', compact('order'), ['title' => 'Detail Pesanan: ' . $order->order_code]);
    }
}