<x-tenant-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Tenant') }} - <span class="text-green-600">{{ $tenantName }}</span>
        </h2>
    </x-slot>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pesanan Hari Ini</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-800">{{ $todayOrdersCount }}</p>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pendapatan Hari Ini</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-6 text-center">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Menu Aktif</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-800">{{ $activeMenuItemsCount }}</p>
        </div>
        <div class="bg-green-50 shadow-sm rounded-lg p-6 text-center">
            <h3 class="text-sm font-medium text-green-600 uppercase tracking-wider">Perlu Diproses</h3>
            <p class="mt-2 text-3xl font-semibold text-green-700">{{ $pendingProcessOrdersCount }}</p>
            @if($pendingProcessOrdersCount > 0)
                <a href="{{ route('tenant.orders.index', ['status_filter' => 'paid']) }}" class="mt-2 inline-block text-sm text-green-500 hover:text-green-600 hover:underline">Lihat Pesanan</a>
            @endif
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800">{{ __("Selamat datang di panel tenant Anda!") }}</h3>
        <p class="mt-2 text-gray-600">Dari sini Anda dapat mengelola menu makanan, melihat pesanan masuk, dan mengatur status pesanan.</p>
        <div class="mt-6 flex flex-wrap gap-4">
            <a href="{{ route('tenant.menu-items.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Kelola Menu Saya
            </a>
            <a href="{{ route('tenant.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Lihat Pesanan Masuk
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    @php
        $recentPendingOrders = \App\Models\Order::where('tenant_id', Auth::user()->tenantProfile->id)
                                ->where('status', 'paid')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
    @endphp
    @if($recentPendingOrders->count() > 0)
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pesanan Terbaru (Perlu Diproses)</h3>
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @foreach($recentPendingOrders as $order)
                        <li>
                            <a href="{{ route('tenant.orders.show', $order) }}" class="block hover:bg-green-50 transition duration-150">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <p class="text-sm font-medium text-green-600 truncate">{{ $order->order_code }}</p>
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-semibold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-600">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $order->customer->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-600 sm:mt-0">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <p>Dipesan pada <time datetime="{{ $order->created_at->toIso8601String() }}">{{ $order->created_at->format('d M Y, H:i') }}</time></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</x-tenant-layout>