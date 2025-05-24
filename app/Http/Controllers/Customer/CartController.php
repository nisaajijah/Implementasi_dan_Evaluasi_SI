<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem; // Untuk type-hinting dan mengambil detail menu
use App\Models\Tenant;   // Untuk memastikan semua item di cart dari tenant yang sama
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index(): View
    {
        $cartItems = Cart::instance('default')->content(); // Mengambil semua item dari instance 'default'
        $cartTotal = Cart::instance('default')->total(2, '.', ''); // Ambil total tanpa format, 2 desimal
        $cartSubtotal = Cart::instance('default')->subtotal(2, '.', ''); // Ambil subtotal tanpa format, 2 desimal
        // Anda bisa menambahkan perhitungan pajak atau biaya lain di sini jika perlu
        // $cartTax = Cart::instance('default')->tax(2, '.', '');

        // Ambil informasi tenant dari item pertama di keranjang (jika ada)
        // Ini penting untuk logika bahwa 1 keranjang hanya untuk 1 tenant.
        $currentCartTenant = null;
        if ($cartItems->isNotEmpty()) {
            $firstCartItem = $cartItems->first();
            if (isset($firstCartItem->options['tenant_id'])) {
                $currentCartTenant = Tenant::find($firstCartItem->options['tenant_id']);
            }
        }

        return view('customer.cart.index', compact('cartItems', 'cartTotal', 'cartSubtotal', 'currentCartTenant'), ['title' => 'Keranjang Belanja']);
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request, MenuItem $menuItem): RedirectResponse
    {
        // Validasi dasar
        $request->validate([
            'quantity' => 'sometimes|integer|min:1|max:10', // Max 10 per item, bisa disesuaikan
        ]);

        // Pastikan item tersedia dan stok mencukupi
        if (!$menuItem->is_available || ($menuItem->stock != -1 && $menuItem->stock < ($request->input('quantity', 1)))) {
            return redirect()->back()->with('error', 'Maaf, item ini tidak tersedia atau stok tidak mencukupi.');
        }

        // LOGIKA: 1 Keranjang Hanya Untuk 1 Tenant
        // Cek apakah keranjang sudah ada isinya
        $cartInstance = Cart::instance('default');
        $cartContent = $cartInstance->content();

        if ($cartContent->isNotEmpty()) {
            $firstItemTenantId = $cartContent->first()->options->get('tenant_id');
            // Jika item yang baru mau dimasukkan berasal dari tenant yang berbeda,
            // beri opsi untuk menghapus keranjang lama atau batalkan.
            if ($firstItemTenantId != $menuItem->tenant_id) {
                // Opsi 1: Redirect dengan pesan error dan opsi clear cart
                // return redirect()->route('customer.tenants.menu', $menuItem->tenant)
                //                  ->with('error_different_tenant', 'Anda hanya bisa memesan dari satu tenant dalam satu waktu. Kosongkan keranjang untuk memesan dari tenant ini?')
                //                  ->with('clear_cart_option_for_tenant', $menuItem->tenant_id);

                // Opsi 2 (Lebih simpel untuk sekarang): Hapus keranjang lama secara otomatis
                $cartInstance->destroy(); // Hapus semua isi keranjang lama
                // Tambahkan pesan bahwa keranjang lama dikosongkan
                // session()->flash('warning', 'Keranjang Anda telah dikosongkan karena Anda memesan dari tenant yang berbeda.');
            }
        }
        // Akhir Logika 1 Keranjang 1 Tenant

        $quantity = $request->input('quantity', 1);
        
        // Siapkan array options
        $options = [
            'image' => $menuItem->image,
            'tenant_id' => $menuItem->tenant_id,
            'tenant_name' => $menuItem->tenant->name,
            // 'slug' => $menuItem->slug // Jika Anda punya slug dan ingin menyimpannya
        ];
        
        // Tambahkan item ke keranjang menggunakan 5 argumen
        // Cart::add(id, name, qty, price, optionsArray);
        $cartInstance->add(
            $menuItem->id,      // Argumen 1: id
            $menuItem->name,    // Argumen 2: name
            $quantity,          // Argumen 3: qty
            $menuItem->price,   // Argumen 4: price
            $options            // Argumen 5: options (array)
        );

        return redirect()->back()->with('success', "'{$menuItem->name}' berhasil ditambahkan ke keranjang!");
        // Alternatif: redirect ke halaman keranjang
        // return redirect()->route('cart.index')->with('success', "'{$menuItem->name}' berhasil ditambahkan ke keranjang!");
    }


    /**
     * Update the quantity of an item in the cart.
     */
    public function update(Request $request, $itemId): RedirectResponse // $itemId adalah rowId dari cart item
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10', // Max 10, bisa disesuaikan
        ]);

        // Dapatkan item dari keranjang untuk cek stok sebelum update
        $cartItem = Cart::instance('default')->get($itemId);
        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $menuItem = MenuItem::find($cartItem->id);
        if ($menuItem && $menuItem->stock != -1 && $menuItem->stock < $request->quantity) {
            return redirect()->route('cart.index')->with('error', "Stok untuk '{$menuItem->name}' tidak mencukupi (tersisa {$menuItem->stock}).");
        }

        Cart::instance('default')->update($itemId, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Kuantitas item di keranjang berhasil diperbarui.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($itemId): RedirectResponse // $itemId adalah rowId dari cart item
    {
        Cart::instance('default')->remove($itemId);
        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Clear all items from the cart.
     */
    public function clear(): RedirectResponse
    {
        Cart::instance('default')->destroy(); // Menghapus semua item
        return redirect()->route('cart.index')->with('success', 'Semua item berhasil dihapus dari keranjang.');
    }
}