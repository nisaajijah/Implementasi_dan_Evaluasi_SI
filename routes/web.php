<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CanteenController as AdminCanteenController;
use App\Http\Controllers\Admin\TenantController as AdminTenantController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\MenuItemController as TenantMenuItemController;
use App\Http\Controllers\Tenant\OrderController as TenantOrderController;
use App\Http\Controllers\Tenant\ProfileController as TenantProfileController;
use App\Http\Controllers\Customer\PageController as CustomerPageController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CheckoutController as CustomerCheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Auth\AdminLoginController; 
use App\Http\Controllers\Auth\TenantLoginController; 

// Daftar Kantin
    Route::get('/canteens', [CustomerPageController::class, 'listCanteens'])->name('customer.canteens.index');
    // Daftar Tenant per Kantin
    Route::get('/canteens/{canteen}/tenants', [CustomerPageController::class, 'listTenants'])->name('customer.canteens.tenants.index');
    // Menu Tenant
    Route::get('/tenants/{tenant}/menu', [CustomerPageController::class, 'showTenantMenu'])->name('customer.tenants.menu');
    
Route::prefix('tenant')->name('tenant.')->group(function () { // Menggunakan prefix 'tenant-area' agar tidak konflik dengan route resource 'tenants' milik admin
    Route::get('login', [TenantLoginController::class, 'create'])->name('login');     // Menampilkan form login tenant
    Route::post('login', [TenantLoginController::class, 'store'])->name('login.store'); // Memproses login tenant
    Route::post('logout', [TenantLoginController::class, 'destroy'])->name('logout');   // Logout khusus tenant
});

// Route untuk Login Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');     // Menampilkan form login admin
    Route::post('login', [AdminLoginController::class, 'store'])->name('login.store'); // Memproses login admin
    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');   // Logout khusus admin (jika diperlukan terpisah)
});

// Halaman utama (landing page) - bisa diakses publik
Route::get('/', [CustomerPageController::class, 'home'])->name('home');

// Grup Route untuk admin
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Route untuk Manajemen Kantin 
    Route::resource('canteens', AdminCanteenController::class);
    Route::resource('tenants', AdminTenantController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('announcements', AdminAnnouncementController::class);

    // Rute untuk Monitoring Order oleh Admin
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index'); // TAMBAHKAN INI
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show'); // TAMBAHKAN INI

});

// Grup Route untuk Tenant
Route::middleware(['auth', 'verified', 'tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');

    // Route untuk manajemen menu oleh tenant 
    Route::resource('menu-items', TenantMenuItemController::class);

    // Route untuk manajemen order oleh tenant 
    Route::get('orders', [TenantOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [TenantOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [TenantOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Rute untuk Pengaturan Profil Tenant
    Route::get('profile', [TenantProfileController::class, 'edit'])->name('profile.edit'); // TAMBAHKAN INI
    Route::patch('profile', [TenantProfileController::class, 'update'])->name('profile.update'); // TAMBAHKAN INI
});

// Route untuk Customer (membutuhkan login)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Customer (default Breeze, bisa kita override atau gunakan)
    Route::get('/dashboard', [CustomerPageController::class, 'dashboard'])->name('dashboard'); // Override dashboard Breeze jika perlu

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

    // Route untuk Keranjang Belanja
    Route::get('/cart', [CustomerCartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{menuItem}', [CustomerCartController::class, 'add'])->name('cart.add'); // {menuItem} untuk route model binding
    Route::patch('/cart/update/{itemId}', [CustomerCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CustomerCartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CustomerCartController::class, 'clear'])->name('cart.clear');

    // Route untuk Checkout
    Route::get('/checkout', [CustomerCheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CustomerCheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CustomerCheckoutController::class, 'success'])->name('checkout.success'); // Menampilkan halaman sukses setelah order

    // Route untuk Pesanan Saya (Customer)
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/my-orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');

    // Route untuk Simulasi Pembayaran E-Wallet
    Route::get('/checkout/payment-simulation/{order}', [CustomerCheckoutController::class, 'showPaymentSimulationPage'])->name('checkout.payment.simulation'); // TAMBAHKAN INI
    Route::post('/checkout/payment-simulation/{order}/process', [CustomerCheckoutController::class, 'processPaymentSimulation'])->name('checkout.payment.simulation.process'); // TAMBAHKAN INI

    
});



require __DIR__ . '/auth.php';
