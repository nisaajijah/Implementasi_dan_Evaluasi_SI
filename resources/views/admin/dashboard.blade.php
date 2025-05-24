<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-green-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8 space-y-8">
        <!-- Kartu Statistik Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow-lg rounded-xl p-6 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10m0 0h12M4 7l4-4m0 0l4 4m-4-4v10m0 0h12m0 0l4-4m-4 4l-4-4m4 4V7" />
                        </svg>
                    </div>
                    <div class="ml-5 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Total Kantin</dt>
                            <dd class="text-3xl font-bold text-green-800">{{ $totalCanteens }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-6 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Total Tenant</dt>
                            <dd class="text-3xl font-bold text-green-800">{{ $totalTenants }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-6 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Total Pengguna</dt>
                            <dd class="text-3xl font-bold text-green-800">{{ $totalUsers }}</dd>
                            <dd class="text-xs text-green-500">
                                (Admin: {{ $totalAdminUsers }}, Tenant: {{ $totalTenantUsers }}, Customer: {{ $totalCustomerUsers }})
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl p-6 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="ml-5 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-green-600 truncate">Pesanan Hari Ini</dt>
                            <dd class="text-3xl font-bold text-green-800">{{ $ordersTodayCount }}</dd>
                            <dd class="text-xs text-green-500">
                                (Perlu Diproses: {{ $pendingOrdersCount }})
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik Pendapatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-green-50 border border-green-200 shadow-lg rounded-xl p-6 transform hover:scale-105 transition-transform duration-200">
                <dl>
                    <dt class="text-sm font-medium text-green-600 truncate">Pendapatan Hari Ini</dt>
                    <dd class="mt-1 text-3xl font-bold text-green-700">Rp {{ number_format($revenueToday, 0, ',', '.') }}</dd>
                </dl>
            </div>
            <div class="bg-green-50 border border-green-200 shadow-lg rounded-xl p-6 transform hover:scale-105 transition-transform duration-200">
                <dl>
                    <dt class="text-sm font-medium text-green-600 truncate">Pendapatan Bulan Ini</dt>
                    <dd class="mt-1 text-3xl font-bold text-green-700">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</dd>
                </dl>
            </div>
        </div>

        <!-- Shortcut ke Fungsi Utama -->
        <div class="bg-white shadow-md rounded-xl p-6">
            <h3 class="text-lg font-bold text-green-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <a href="{{ route('admin.canteens.index') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <svg class="h-8 w-8 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10m0 0h12M4 7l4-4m0 0l4 4m-4-4v10m0 0h12m0 0l4-4m-4 4l-4-4m4 4V7" />
                    </svg>
                    <span class="text-sm font-medium text-green-700 group-hover:text-green-800">Kantin</span>
                </a>
                <a href="{{ route('admin.tenants.index') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <svg class="h-8 w-8 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm font-medium text-green-700 group-hover:text-green-800">Tenant</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <svg class="h-8 w-8 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-sm font-medium text-green-700 group-hover:text-green-800">Pengguna</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <svg class="h-8 w-8 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="text-sm font-medium text-green-700 group-hover:text-green-800">Transaksi</span>
                </a>
                <a href="{{ route('admin.announcements.index') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <svg class="h-8 w-8 text-green-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.148-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3.418" />
                    </svg>
                    <span class="text-sm font-medium text-green-700 group-hover:text-green-800">Pengumuman</span>
                </a>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pesanan Terbaru -->
            <div class="bg-white shadow-md rounded-xl p-6">
                <h3 class="text-lg font-bold text-green-800 mb-4">Pesanan Terbaru</h3>
                @if($recentOrders->count() > 0)
                <ul class="divide-y divide-green-100">
                    @foreach($recentOrders as $order)
                    <li class="py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="block hover:bg-green-50 p-2 -m-2 rounded-md transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600">{{ $order->order_code }}</p>
                                    <p class="text-xs text-green-500">
                                        {{ $order->customer->name ?? 'N/A' }} → {{ $order->tenant->name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                    <p class="text-xs text-green-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-sm text-green-500">Tidak ada pesanan terbaru.</p>
                @endif
            </div>

            <!-- Pengguna Terbaru -->
            <div class="bg-white shadow-md rounded-xl p-6">
                <h3 class="text-lg font-bold text-green-800 mb-4">Pengguna Terbaru Terdaftar</h3>
                @if($recentUsers->count() > 0)
                <ul class="divide-y divide-green-100">
                    @foreach($recentUsers as $user)
                    <li class="py-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="block hover:bg-green-50 p-2 -m-2 rounded-md transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-800">{{ $user->name }}</p>
                                    <p class="text-xs text-green-500">{{ $user->email }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <p class="text-xs text-green-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-sm text-green-500">Tidak ada pengguna baru.</p>
                @endif
            </div>
        </div>

        
    </div>

    <!-- Chart.js CDN and Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: [12, 19, 3, 5, 2, 3, 7], // Placeholder data, replace with dynamic data from controller
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true },
                },
                plugins: {
                    legend: {
                        labels: {
                            font: { size: 14, family: 'Inter, sans-serif' },
                            color: '#166534'
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>