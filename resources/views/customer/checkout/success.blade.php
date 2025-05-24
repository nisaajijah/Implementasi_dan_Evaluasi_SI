<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    <!-- Success Icon -->
                    <div class="flex justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none" 
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <!-- Main Message -->
                    <h3 class="text-3xl font-bold text-gray-900 text-center mb-4">
                        Pesanan Berhasil Dibuat!
                    </h3>
                    
                    @if (session('success_message'))
                        <p class="text-gray-600 text-center mb-3">
                            {{ session('success_message') }}
                        </p>
                    @endif
                    @if (session('payment_simulation_message'))
                        <p class="text-sm text-green-600 text-center mb-4 font-medium">
                            {{ session('payment_simulation_message') }}
                        </p>
                    @endif

                    <!-- Order Info -->
                    <div class="text-center mb-8">
                        <p class="text-gray-700">
                            Nomor Pesanan Anda: 
                            <strong class="text-green-600 font-semibold">{{ $order->order_code }}</strong>
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Pesanan Anda akan segera diproses oleh 
                            <span class="font-medium text-gray-700">{{ $order->tenant->name }}</span>.
                        </p>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-3">Ringkasan Pesanan:</h4>
                        <ul class="text-left text-sm space-y-1 mb-2">
                            @foreach($order->items as $item)
                                <li class="flex justify-between">
                                    <span class="text-gray-700">{{ $item->menuItem->name ?? 'Item Dihapus' }} (x{{ $item->quantity }})</span>
                                    <span class="text-gray-900">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="border-t border-gray-100 pt-2 space-y-1 text-sm">
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
                        <div class="flex justify-between font-bold text-gray-900 text-lg border-t border-gray-200 pt-2 mt-2">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Metode Pembayaran: {{ Str::upper(str_replace('_', ' ', $order->payment_method)) }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('customer.orders.show', $order->id) }}" 
                           class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg 
                           transition duration-300 text-center">
                            Lihat Detail Pesanan
                        </a>
                        <a href="{{ route('customer.canteens.index') }}" 
                           class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg 
                           transition duration-300 text-center">
                            Pesan Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>