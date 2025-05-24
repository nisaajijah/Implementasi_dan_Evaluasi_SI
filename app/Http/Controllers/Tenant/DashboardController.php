<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Order; // Import Order model
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class DashboardController extends Controller
{
    public function index(): View
    {
        $tenant = Auth::user()->tenantProfile;
        $tenantId = $tenant->id;

        // 1. Jumlah Pesanan Hari Ini (yang statusnya bukan pending_payment atau cancelled)
        $todayOrdersCount = Order::where('tenant_id', $tenantId)
                                 ->whereDate('created_at', Carbon::today())
                                 ->whereNotIn('status', ['pending_payment', 'cancelled'])
                                 ->count();

        // 2. Pendapatan Hari Ini (HANYA dari pesanan yang sudah 'completed' atau 'delivered')
        $todayRevenue = Order::where('tenant_id', $tenantId)
                             ->whereDate('created_at', Carbon::today())
                             ->whereIn('status', ['completed', 'delivered']) // PERUBAHAN DI SINI
                             // Opsional: Tambahkan filter payment_status jika perlu
                             // ->where('payment_status', 'paid')
                             ->sum('total_amount');

        // 3. Jumlah Total Menu Aktif
        $activeMenuItemsCount = $tenant->menuItems()->where('is_available', true)->count();

        // 4. Pesanan yang Perlu Diproses (status 'paid')
        $pendingProcessOrdersCount = Order::where('tenant_id', $tenantId)
                                        ->where('status', 'paid')
                                        ->count();

        return view('tenant.dashboard', [
            'title' => 'Dashboard Tenant',
            'tenantName' => $tenant->name,
            'todayOrdersCount' => $todayOrdersCount,
            'todayRevenue' => $todayRevenue,
            'activeMenuItemsCount' => $activeMenuItemsCount,
            'pendingProcessOrdersCount' => $pendingProcessOrdersCount,
        ]);
    }
}