<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('customer.orders.index') }}" class="text-green-600 hover:text-green-800 mr-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ $title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Order Summary Card -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">

                <div class="p-6">
                    <!-- Order Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Tenant Information -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Informasi Tenant
                            </h4>
                            <p class="text-gray-700">{{ $order->tenant->name }}</p>
                        </div>

                        <!-- Delivery Information -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Detail Pengambilan/Pengiriman
                            </h4>
                            <div class="text-gray-700">
                                <p class="mb-1"><span class="font-medium">Metode:</span> {{ ucfirst($order->delivery_method) }}</p>
                                @if($order->delivery_method == 'pickup' && $order->pickup_time)
                                    <p class="mb-1"><span class="font-medium">Waktu Pengambilan:</span> {{ \Carbon\Carbon::parse($order->pickup_time)->format('d M Y, H:i') }}</p>
                                @elseif($order->delivery_method == 'delivery' && $order->delivery_address)
                                    <p class="mb-1"><span class="font-medium">Alamat:</span> <span class="whitespace-pre-line">{{ $order->delivery_address }}</span></p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Customer Notes (if any) -->
                    @if($order->customer_notes)
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">Catatan dari Customer</h3>
                                <div class="mt-1 text-sm text-green-700">
                                    <p>{{ $order->customer_notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-800 text-lg mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Item yang Dipesan
                        </h4>
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
                            <ul class="divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        @if ($item->menuItem && $item->menuItem->image)
                                            <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-lg overflow-hidden">
                                                <img src="{{ asset('storage/' . $item->menuItem->image) }}" alt="{{ $item->menuItem->name }}" class="h-full w-full object-cover">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <h5 class="font-medium text-gray-900">{{ $item->menuItem->name ?? 'Item Dihapus' }}</h5>
                                            <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden mb-8">
                        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Detail Pembayaran
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <!-- Payment Status and Method -->
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 mb-6">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($order->payment_status)
                                                @case('unpaid') bg-yellow-100 text-yellow-800 @break
                                                @case('paid') bg-green-100 text-green-800 @break
                                                @case('failed') bg-red-100 text-red-800 @break
                                                @case('refunded') bg-blue-100 text-blue-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch
                                        ">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ Str::upper(str_replace('_', ' ', $order->payment_method)) }}</dd>
                                </div>
                            </dl>

                            <!-- Payment Breakdown -->
                            <div class="border-t border-gray-200 pt-6 text-sm">
                                <h4 class="font-semibold text-gray-700 mb-3">Rincian Pembayaran:</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal Produk</span>
                                        <span class="text-gray-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                    @if($order->delivery_fee > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Ongkos Kirim</span>
                                        <span class="text-gray-700">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Total Payment -->
                                <div class="flex justify-between items-center font-bold text-gray-900 text-lg mt-4 pt-3 border-t border-gray-200">
                                    <span>Total Pembayaran</span>
                                    <span class="text-2xl text-green-600">Rp {{ number_format($order->grand_total ?? ($order->total_amount + ($order->delivery_fee ?? 0)), 0, ',', '.') }}</span>
                                </div>
                                
                                <!-- Additional Payment Info -->
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">Metode Pembayaran: {{ Str::upper(str_replace('_', ' ', $order->payment_method)) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Status Pembayaran:
                                        <span class="font-medium
                                            @switch($order->payment_status)
                                                @case('unpaid') text-yellow-600 @break
                                                @case('paid') text-green-600 @break
                                                @case('failed') text-red-600 @break
                                                @case('refunded') text-blue-600 @break
                                                @default text-gray-600
                                            @endswitch
                                        ">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center">
                        @if($order->status == 'pending_payment' && $order->payment_method == 'e_wallet_simulation' && $order->payment_status == 'unpaid')
                            <a href="{{ route('checkout.payment.simulation', $order) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Lanjutkan Pembayaran E-Wallet
                            </a>
                        @elseif($order->status == 'pending_payment' && $order->payment_method != 'cod')
                            <button type="button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-400 cursor-not-allowed transition-colors" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Menunggu Pembayaran
                            </button>
                        @elseif($order->status == 'delivered' || ($order->status == 'ready_for_pickup' && $order->delivery_method == 'pickup'))
                            <button type="button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Pesanan Diterima
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="mt-8 bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gradient-to-r from-green-500 to-green-600">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Status Pesanan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-green-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-900">Pesanan dibuat</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>{{ $order->created_at->format('d M Y, H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Additional timeline items can be added here based on order status -->
                            @if($order->payment_status == 'paid')
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-green-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-900">Pembayaran diterima</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>{{ $order->updated_at->format('d M Y, H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            
                            <!-- Processing status -->
                            @if(in_array($order->status, ['processing', 'ready_for_pickup', 'out_for_delivery', 'delivered', 'completed']))
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-green-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-900">Pesanan sedang diproses</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>{{ $order->updated_at->format('d M Y, H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            
                            <!-- End state -->
                            @if(in_array($order->status, ['completed', 'delivered']))
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-900">Pesanan selesai</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>{{ $order->updated_at->format('d M Y, H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add for icons and animations (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js"></script>
</x-app-layout>