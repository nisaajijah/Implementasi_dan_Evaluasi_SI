<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon; // Untuk manipulasi tanggal

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistik Utama
        $totalCanteens = Canteen::count();
        $totalTenants = Tenant::count();
        $totalUsers = User::count();
        $totalAdminUsers = User::where('role', 'admin')->count();
        $totalTenantUsers = User::where('role', 'tenant')->count();
        $totalCustomerUsers = User::where('role', 'customer')->count();

        // Statistik Pesanan
        $ordersTodayCount = Order::whereDate('created_at', Carbon::today())->count();
        $pendingOrdersCount = Order::whereIn('status', ['paid', 'processing'])->count(); // Pesanan yang perlu perhatian tenant
        $revenueToday = Order::whereDate('created_at', Carbon::today())
                              ->whereIn('status', ['completed', 'delivered']) // Hanya yang sudah selesai
                              // ->where('payment_status', 'paid') // Jika ingin lebih ketat
                              ->sum('total_amount');
        $revenueThisMonth = Order::whereMonth('created_at', Carbon::now()->month)
                                 ->whereYear('created_at', Carbon::now()->year)
                                 ->whereIn('status', ['completed', 'delivered'])
                                 // ->where('payment_status', 'paid')
                                 ->sum('total_amount');

        // Data untuk Aktivitas Terbaru (Contoh)
        $recentOrders = Order::with(['customer', 'tenant'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'totalCanteens' => $totalCanteens,
            'totalTenants' => $totalTenants,
            'totalUsers' => $totalUsers,
            'totalAdminUsers' => $totalAdminUsers,
            'totalTenantUsers' => $totalTenantUsers,
            'totalCustomerUsers' => $totalCustomerUsers,
            'ordersTodayCount' => $ordersTodayCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'revenueToday' => $revenueToday,
            'revenueThisMonth' => $revenueThisMonth,
            'recentOrders' => $recentOrders,
            'recentUsers' => $recentUsers,
        ]);
    }
}