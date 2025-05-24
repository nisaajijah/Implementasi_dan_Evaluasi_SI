<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index(): View
    {
        $orders = Auth::user()->ordersAsCustomer() // Menggunakan relasi yang sudah ada di model User
                        ->with(['tenant', 'items']) // Eager load tenant dan items
                        ->latest() // Urutkan terbaru
                        ->paginate(10);

        // Array untuk mapping status ke label yang lebih ramah (jika diperlukan di view)
        $statuses = [
            'pending_payment' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'processing' => 'Sedang Diproses',
            'ready_for_pickup' => 'Siap Diambil',
            'out_for_delivery' => 'Sedang Dikirim',
            'delivered' => 'Terkirim (Sampai)',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return view('customer.orders.index', compact('orders', 'statuses'), ['title' => 'Pesanan Saya']);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View // Route Model Binding
    {
        // Pastikan order ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat pesanan ini.');
        }

        $order->load(['tenant', 'items.menuItem', 'customer']); // Eager load relasi yang dibutuhkan

        $statuses = [
            'pending_payment' => 'Menunggu Pembayaran', 'paid' => 'Dibayar', 'processing' => 'Sedang Diproses',
            'ready_for_pickup' => 'Siap Diambil', 'out_for_delivery' => 'Sedang Dikirim',
            'delivered' => 'Terkirim (Sampai)', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
        ];

        return view('customer.orders.show', compact('order', 'statuses'), ['title' => 'Detail Pesanan: ' . $order->order_code]);
    }
}