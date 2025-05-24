<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Models\MenuItem; // Untuk validasi stok
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Untuk database transaction
use Illuminate\Support\Facades\Config; // Untuk mengambil dari config
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(): View|RedirectResponse // Gunakan Union Type
    {
        $cartItems = Cart::instance('default')->content();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Silakan tambahkan item terlebih dahulu.');
        }

        // Ambil informasi tenant dari item pertama di keranjang
        $firstCartItem = $cartItems->first();
        $tenant = null;
        if (isset($firstCartItem->options['tenant_id'])) {
            $tenant = Tenant::find($firstCartItem->options['tenant_id']);
        }

        if (!$tenant) {
            // Seharusnya tidak terjadi jika keranjang memiliki item
            Cart::instance('default')->destroy();
            return redirect()->route('home')->with('error', 'Terjadi kesalahan dengan keranjang Anda. Silakan coba lagi.');
        }

        $cartTotal = Cart::instance('default')->total(2, '.', '');
        $cartSubtotal = Cart::instance('default')->subtotal(2, '.', '');

        // Ambil biaya ongkir dari config
        $deliveryFee = (float) Config::get('e_canteen.delivery_fee', 5000);

        // Opsi metode pembayaran (bisa dari database atau hardcode untuk awal)
        $paymentMethods = [
            'cod' => 'Bayar di Tempat (COD)',
            'e_wallet_simulation' => 'E-Wallet (Simulasi)',
            // 'transfer_simulation' => 'Transfer Bank (Simulasi)',
        ];

        return view(
            'customer.checkout.index',
            compact('cartItems', 'cartTotal', 'cartSubtotal', 'tenant', 'paymentMethods', 'deliveryFee'), // Tambahkan deliveryFee
            ['title' => 'Proses Checkout']
        );
    }

    /**
     * Process the checkout and create the order.
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        $cartItems = Cart::instance('default')->content();
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate([
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_time' => 'nullable|required_if:delivery_method,pickup|date_format:Y-m-d\TH:i|after_or_equal:' . Carbon::now()->addMinutes(15)->format('Y-m-d\TH:i'),
            'delivery_address' => 'nullable|required_if:delivery_method,delivery|string|max:1000',
            'customer_notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:cod,e_wallet_simulation', // Sesuaikan dengan $paymentMethods
        ], [
            'pickup_time.required_if' => 'Waktu pengambilan wajib diisi jika memilih Ambil Langsung.',
            'pickup_time.after_or_equal' => 'Waktu pengambilan minimal 15 menit dari sekarang.',
            'delivery_address.required_if' => 'Alamat pengiriman wajib diisi jika memilih Delivery.',
        ]);

        // Ambil tenant_id dari item pertama di keranjang
        $firstCartItem = $cartItems->first();
        $tenantId = $firstCartItem->options->get('tenant_id');
        if (!$tenantId) {
            Cart::instance('default')->destroy(); // Safety clear
            return redirect()->route('home')->with('error', 'Terjadi kesalahan pada data tenant di keranjang.');
        }

        // Hitung delivery fee
        $deliveryFee = 0;
        if ($request->delivery_method === 'delivery') {
            $deliveryFee = (float) Config::get('e_canteen.delivery_fee', 5000);
        }

        $subtotalProducts = (float) Cart::instance('default')->total(2, '.', ''); // Total produk
        $grandTotal = $subtotalProducts + $deliveryFee;

        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Validasi stok sekali lagi sebelum membuat order
            foreach ($cartItems as $cartItem) {
                $menuItem = MenuItem::find($cartItem->id);
                if (!$menuItem || !$menuItem->is_available || ($menuItem->stock != -1 && $menuItem->stock < $cartItem->qty)) {
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', "Stok untuk '{$cartItem->name}' tidak mencukupi atau item tidak tersedia lagi.");
                }
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'tenant_id' => $tenantId,
                'order_code' => 'ECUIN-' . strtoupper(Auth::user()->role[0] ?? 'C') . '-' . now()->format('YmdHis') . rand(100, 999),
                'total_amount' => $subtotalProducts,
                'delivery_fee' => $deliveryFee,
                'status' => 'pending_payment', // SEMUA METODE PEMBAYARAN AWALNYA PENDING PAYMENT
                'delivery_method' => $request->delivery_method,
                'pickup_time' => ($request->delivery_method == 'pickup') ? Carbon::parse($request->pickup_time) : null,
                'delivery_address' => ($request->delivery_method == 'delivery') ? $request->delivery_address : null,
                'customer_notes' => $request->customer_notes,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $cartItem->id,
                    'quantity' => $cartItem->qty,
                    'price_at_purchase' => $cartItem->price,
                    'sub_total' => $cartItem->qty * $cartItem->price,
                ]);

                // Kurangi stok
                $menuItem = MenuItem::find($cartItem->id);
                if ($menuItem && $menuItem->stock != -1) { // Jika stok bukan tak terbatas
                    $menuItem->decrement('stock', $cartItem->qty);
                }
            }

            DB::commit(); // Commit transaksi jika semua berhasil

            // Hapus Cart Setelah Order Berhasil Dibuat
            Cart::instance('default')->destroy();

            // Logika Pengarahan Berdasarkan Metode Pembayaran
            if ($request->payment_method == 'e_wallet_simulation') {
                // Arahkan ke halaman simulasi pembayaran E-Wallet
                return redirect()->route('checkout.payment.simulation', $order); // Route baru
            } elseif ($request->payment_method == 'cod') {
                // Untuk COD, status bisa langsung update ke 'processing'
                $order->update(['status' => 'processing']);
                return redirect()->route('checkout.success', $order)->with('success_message', 'Pesanan COD Anda berhasil dibuat dan sedang diproses!');
            }

            // Default (jika ada metode lain yang belum dihandle)
            return redirect()->route('checkout.success', $order)->with('success_message', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada error
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi. ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman simulasi pembayaran.
     */
    public function showPaymentSimulationPage(Order $order): View|RedirectResponse
    {
        // Pastikan order ini milik user yang login dan statusnya pending payment
        if ($order->user_id !== Auth::id() || $order->status !== 'pending_payment' || $order->payment_method !== 'e_wallet_simulation') {
            // Jika tidak sesuai, arahkan ke detail pesanan atau halaman error
            if($order->user_id !== Auth::id()) abort(403);
            return redirect()->route('customer.orders.show', $order)->with('error', 'Pesanan ini tidak dapat diproses untuk simulasi pembayaran.');
        }

        $order->load('tenant'); // Load tenant untuk info
        return view('customer.checkout.payment_simulation', compact('order'), ['title' => 'Simulasi Pembayaran E-Wallet']);
    }

    /**
     * Memproses hasil simulasi pembayaran.
     */
    public function processPaymentSimulation(Request $request, Order $order): RedirectResponse
    {
        // Pastikan order ini milik user yang login dan statusnya pending payment
        if ($order->user_id !== Auth::id() || $order->status !== 'pending_payment' || $order->payment_method !== 'e_wallet_simulation') {
            if($order->user_id !== Auth::id()) abort(403);
            return redirect()->route('customer.orders.show', $order)->with('error', 'Gagal memproses simulasi pembayaran.');
        }

        // Di aplikasi nyata, di sini akan ada validasi token/callback dari payment gateway
        // Untuk simulasi, kita anggap selalu berhasil jika tombol "Bayar" diklik.

        // Update status order dan payment_status
        $order->update([
            'status' => 'paid',         // Pesanan sudah dibayar, siap diproses tenant
            'payment_status' => 'paid',
            // Anda bisa menambahkan 'payment_details' jika ada info dari "gateway" simulasi
            // 'payment_details' => ['transaction_id' => 'SIM-' . strtoupper(Str::random(10)), 'paid_at' => now()]
        ]);

        // TODO: Kirim notifikasi ke tenant bahwa ada pesanan baru yang sudah dibayar

        return redirect()->route('checkout.success', $order)->with('success_message', 'Pembayaran E-Wallet (Simulasi) berhasil! Pesanan Anda akan segera diproses.');
    }

    /**
     * Display the order success page.
     */
    public function success(Order $order): View // Route Model Binding
    {
        // Pastikan order ini milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        $order->load('tenant', 'items.menuItem');
        return view('customer.checkout.success', compact('order'), ['title' => 'Pesanan Berhasil']);
    }
}