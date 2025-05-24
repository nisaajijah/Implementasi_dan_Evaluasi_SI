<x-tenant-layout :title="$title">
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight mb-1">
                    {{ $title }}
                </h2>
                <p class="text-sm text-gray-500">Kelola dan pantau detail pesanan</p>
            </div>
            <a href="{{ route('tenant.orders.index') }}" 
               class="group inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        {{-- Status Banner --}}
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-sm animate-slide-up">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Pesanan #{{ $order->order_code }}</h3>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i:s') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @switch($order->status)
                            @case('pending_payment') bg-yellow-100 text-yellow-800 @break
                            @case('paid') bg-blue-100 text-blue-800 @break
                            @case('processing') bg-indigo-100 text-indigo-800 @break
                            @case('ready_for_pickup') bg-purple-100 text-purple-800 @break
                            @case('out_for_delivery') bg-teal-100 text-teal-800 @break
                            @case('delivered')
                            @case('completed') bg-green-100 text-green-800 @break
                            @case('cancelled') bg-red-100 text-red-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch">
                        @php
                            $statuses = [
                                'pending_payment' => 'Menunggu Pembayaran',
                                'paid' => 'Dibayar',
                                'processing' => 'Diproses',
                                'ready_for_pickup' => 'Siap Diambil',
                                'out_for_delivery' => 'Dikirim',
                                'delivered' => 'Terkirim',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <div class="w-2 h-2 bg-current rounded-full mr-2 animate-pulse"></div>
                        {{ $statuses[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status)) }}
                    </div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Order Details Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden animate-slide-up-delay-1">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-white">Detail Pesanan</h3>
                            {{-- Status Update Dropdown --}}
                            @if (!empty($availableNextStatuses))
                                <div class="relative">
                                    <form action="{{ route('tenant.orders.updateStatus', $order) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Anda yakin ingin mengubah status pesanan ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <select name="new_status" id="new_status" 
                                            class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-white/50 hover:bg-white/30 transition-all duration-200"
                                            onchange="this.form.submit()">
                                            <option value="" class="text-gray-900">-- Ubah Status --</option>
                                            @foreach ($availableNextStatuses as $statusValue => $statusLabel)
                                                <option value="{{ $statusValue }}" class="text-gray-900">{{ $statusLabel }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8v2m-4-6h8m-8 0a2 2 0 00-2 2v4a2 2 0 002 2h8a2 2 0 002-2v-4a2 2 0 00-2-2"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Metode Pengambilan</p>
                                        <p class="text-base font-semibold text-gray-900 capitalize">{{ $order->delivery_method }}</p>
                                    </div>
                                </div>
                                
                                @if ($order->delivery_method == 'pickup' && $order->pickup_time)
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Waktu Pengambilan</p>
                                        <p class="text-base font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($order->pickup_time)->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="space-y-4">
                                @if ($order->delivery_method == 'delivery' && $order->delivery_address)
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Alamat Pengiriman</p>
                                        <p class="text-base text-gray-900 whitespace-pre-line">{{ $order->delivery_address }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if ($order->customer_notes)
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Catatan Pelanggan</p>
                                        <p class="text-base text-gray-900 whitespace-pre-line">{{ $order->customer_notes }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden animate-slide-up-delay-2">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Item Pesanan
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($order->items as $index => $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms;">
                                    <div class="flex items-center space-x-4">
                                        @if ($item->menuItem && $item->menuItem->image)
                                            <img src="{{ asset('storage/' . $item->menuItem->image) }}"
                                                alt="{{ $item->menuItem->name }}"
                                                class="h-12 w-12 object-cover rounded-lg shadow-sm">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $item->menuItem->name ?? 'Menu Dihapus' }}</h4>
                                            <p class="text-sm text-gray-500">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }} × {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                            {{ $item->quantity }}x
                                        </div>
                                        <p class="text-lg font-bold text-gray-900 mt-1">
                                            Rp {{ number_format($item->sub_total, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-700">Total Keseluruhan</span>
                                <span class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Payment Details --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden animate-slide-up-delay-3">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Detail Pembayaran
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Metode</span>
                            <span class="text-sm font-semibold text-gray-900 uppercase">
                                {{ $order->payment_method ?? '-' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Status</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                @switch($order->payment_status)
                                    @case('unpaid') bg-yellow-100 text-yellow-800 @break
                                    @case('paid') bg-green-100 text-green-800 @break
                                    @case('failed') bg-red-100 text-red-800 @break
                                    @case('refunded') bg-blue-100 text-blue-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                <div class="w-1.5 h-1.5 bg-current rounded-full mr-1.5"></div>
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        
                        @if ($order->payment_details)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-500 mb-2">Detail Tambahan</p>
                            <div class="bg-gray-50 rounded-lg p-3 max-h-32 overflow-y-auto">
                                <pre class="text-xs text-gray-600 whitespace-pre-wrap">{{ json_encode($order->payment_details, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Customer Info --}}
                @if ($order->customer)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden animate-slide-up-delay-4">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informasi Pelanggan
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">
                                    {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $order->customer->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $order->customer->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .animate-slide-up {
            animation: slide-up 0.6s ease-out;
        }
        
        .animate-slide-up-delay-1 {
            animation: slide-up 0.6s ease-out 0.1s both;
        }
        
        .animate-slide-up-delay-2 {
            animation: slide-up 0.6s ease-out 0.2s both;
        }
        
        .animate-slide-up-delay-3 {
            animation: slide-up 0.6s ease-out 0.3s both;
        }
        
        .animate-slide-up-delay-4 {
            animation: slide-up 0.6s ease-out 0.4s both;
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.4s ease-out both;
        }
    </style>
</x-tenant-layout>