<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    private function getTenantId()
    {
        return Auth::user()->tenantProfile->id;
    }

    /**
     * Display a listing of the resource specific to the logged-in tenant.
     */
    public function index(Request $request): View
    {
        $tenantId = $this->getTenantId();
        $query = Order::where('tenant_id', $tenantId)
                      ->with(['customer', 'items']) // Eager load customer dan items
                      ->latest();

        // Filter berdasarkan Status
        if ($request->filled('status_filter') && $request->status_filter !== 'all') {
            $query->where('status', $request->status_filter);
        } else {
            // Default filter: Tampilkan pesanan yang belum selesai atau dibatalkan
            $query->whereNotIn('status', ['completed', 'cancelled']);
        }


        // Pencarian
        if ($request->filled('search_order')) {
            $search = $request->input('search_order');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        // Status yang bisa di-filter oleh tenant (mungkin tidak semua status relevan untuk tenant)
        $filterableStatuses = [
            'paid' => 'Baru (Dibayar)',
            'processing' => 'Sedang Diproses',
            'ready_for_pickup' => 'Siap Diambil',
            'out_for_delivery' => 'Sedang Dikirim',
            'delivered' => 'Terkirim (Sampai)',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            // 'pending_payment' => 'Menunggu Pembayaran', // Mungkin tidak perlu ditampilkan ke tenant
        ];

        return view('tenant.orders.index', compact('orders', 'filterableStatuses'), ['title' => 'Pesanan Masuk']);
    }

    /**
     * Display the specified resource specific to the logged-in tenant.
     */
    public function show(Order $order): View
    {
        $tenantId = $this->getTenantId();
        if ($order->tenant_id !== $tenantId) {
            abort(403, 'Akses ditolak. Pesanan ini bukan milik Anda.');
        }

        $order->load(['customer', 'items.menuItem']); // Eager load relasi

        // Status yang bisa diubah oleh tenant
        $availableNextStatuses = [];
        switch ($order->status) {
            case 'paid':
                $availableNextStatuses = ['processing' => 'Proses Pesanan', 'cancelled' => 'Batalkan Pesanan'];
                break;
            case 'processing':
                if ($order->delivery_method == 'pickup') {
                    $availableNextStatuses = ['ready_for_pickup' => 'Siap Diambil', 'cancelled' => 'Batalkan Pesanan'];
                } else { // delivery
                    $availableNextStatuses = ['out_for_delivery' => 'Kirim Pesanan', 'cancelled' => 'Batalkan Pesanan'];
                }
                break;
            case 'ready_for_pickup':
                 // Tenant tidak mengubah status ini, customer yang "menyelesaikan" saat mengambil, atau sistem otomatis
                 // Tapi kita bisa tambahkan 'completed' jika tenant mau menandai manual
                $availableNextStatuses = ['completed' => 'Tandai Selesai (Diambil)'];
                break;
            case 'out_for_delivery':
                // Sama seperti ready_for_pickup, tenant bisa menandai manual jika perlu
                $availableNextStatuses = ['delivered' => 'Tandai Terkirim (Sampai)'];
                break;
            // Untuk status delivered, completed, cancelled, tidak ada aksi status lagi dari tenant
        }


        return view('tenant.orders.show', compact('order', 'availableNextStatuses'), ['title' => 'Detail Pesanan: ' . $order->order_code]);
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $tenantId = $this->getTenantId();
        if ($order->tenant_id !== $tenantId) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'new_status' => [
                'required',
                'string',
                Rule::in(['processing', 'ready_for_pickup', 'out_for_delivery', 'delivered', 'completed', 'cancelled']), // Status yang valid bisa diubah tenant
            ],
        ]);

        $newStatus = $request->input('new_status');

        // Validasi transisi status (opsional tapi baik)
        // Contoh: tidak bisa dari 'paid' langsung ke 'delivered'
        $allowedTransitions = [
            'paid' => ['processing', 'cancelled'],
            'processing' => ['ready_for_pickup', 'out_for_delivery', 'cancelled'],
            'ready_for_pickup' => ['completed'], // Atau customer yg konfirmasi
            'out_for_delivery' => ['delivered'], // Atau customer yg konfirmasi
            'delivered' => ['completed'], // Jika ada langkah konfirmasi dari tenant
        ];

        if (isset($allowedTransitions[$order->status]) && !in_array($newStatus, $allowedTransitions[$order->status])) {
             if ($order->status === 'ready_for_pickup' && $newStatus === 'completed' && $order->delivery_method === 'pickup') {
                // Izinkan
            } elseif ($order->status === 'out_for_delivery' && $newStatus === 'delivered' && $order->delivery_method === 'delivery') {
                // Izinkan
            } elseif ($newStatus === 'cancelled' && in_array($order->status, ['paid', 'processing'])) {
                // Izinkan pembatalan dari paid atau processing
            }
             else {
                return redirect()->back()->with('error', 'Transisi status tidak valid.');
            }
        }


        // Logika khusus saat membatalkan
        if ($newStatus === 'cancelled') {
            // TODO: Pertimbangkan logika refund jika pembayaran sudah dilakukan dan bukan COD
            // TODO: Kembalikan stok item jika perlu
            // foreach($order->items as $item) {
            //     if($item->menuItem && $item->menuItem->stock !== -1) { // Jika stok bukan tak terbatas
            //         $item->menuItem->increment('stock', $item->quantity);
            //     }
            // }
        }

        // Logika khusus saat menyelesaikan
        if ($newStatus === 'completed' || $newStatus === 'delivered') {
            // TODO: Mungkin trigger notifikasi ke customer
        }


        $order->status = $newStatus;
        // Jika status menjadi 'completed' atau 'delivered', mungkin update juga payment_status jika COD
        if (($newStatus === 'completed' || $newStatus === 'delivered') && $order->payment_method === 'cod' && $order->payment_status === 'unpaid') {
            $order->payment_status = 'paid';
        }

        $order->save();

        return redirect()->route('tenant.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}