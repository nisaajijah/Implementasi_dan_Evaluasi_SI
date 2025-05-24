<x-admin-layout :title="$title">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $title }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="secondary-button">
                « Kembali ke Daftar Transaksi
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Pesanan & Customer --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">Detail Pesanan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Kode: {{ $order->order_code }}</p>

                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Tanggal Pesan:</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $order->created_at->format('d M Y, H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Status Pesanan:</p>
                        <p class="font-bold
                            @switch($order->status)
                                @case('pending_payment') text-yellow-600 dark:text-yellow-400 @break
                                @case('paid') text-blue-600 dark:text-blue-400 @break
                                @case('processing') text-indigo-600 dark:text-indigo-400 @break
                                @case('ready_for_pickup') text-purple-600 dark:text-purple-400 @break
                                @case('out_for_delivery') text-teal-600 dark:text-teal-400 @break
                                @case('delivered')
                                @case('completed') text-green-600 dark:text-green-400 @break
                                @case('cancelled') text-red-600 dark:text-red-400 @break
                                @default text-gray-600 dark:text-gray-400
                            @endswitch
                        ">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Metode Pengambilan:</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ ucfirst($order->delivery_method) }}</p>
                    </div>
                    @if($order->delivery_method == 'pickup' && $order->pickup_time)
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Waktu Pengambilan:</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($order->pickup_time)->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                </div>

                @if($order->delivery_method == 'delivery' && $order->delivery_address)
                <div class="mb-4 text-sm">
                    <p class="font-semibold text-gray-700 dark:text-gray-300">Alamat Pengiriman:</p>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $order->delivery_address }}</p>
                </div>
                @endif

                @if($order->customer_notes)
                <div class="mb-4 text-sm">
                    <p class="font-semibold text-gray-700 dark:text-gray-300">Catatan Pelanggan:</p>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $order->customer_notes }}</p>
                </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Item Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300">Menu</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-500 dark:text-gray-300">Harga Satuan</th>
                                <th class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300">Jumlah</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-500 dark:text-gray-300">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                    {{ $item->menuItem->name ?? 'Menu Dihapus' }}
                                    @if($item->menuItem && $item->menuItem->image)
                                        <img src="{{ asset('storage/' . $item->menuItem->image) }}" alt="{{ $item->menuItem->name }}" class="h-8 w-8 object-cover rounded inline-block ml-2">
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-400">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center text-gray-600 dark:text-gray-400">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right text-gray-600 dark:text-gray-400">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-right font-semibold text-gray-700 dark:text-gray-300">Total Keseluruhan:</td>
                                <td class="px-4 py-2 text-right font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Pembayaran, Customer & Tenant --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Pembayaran</h3>
                <div class="text-sm space-y-2">
                    <p><span class="font-semibold text-gray-700 dark:text-gray-300">Metode:</span> <span class="text-gray-600 dark:text-gray-400">{{ $order->payment_method ? Str::upper($order->payment_method) : '-' }}</span></p>
                    <p><span class="font-semibold text-gray-700 dark:text-gray-300">Status:</span>
                        <span class="font-bold
                            @switch($order->payment_status)
                                @case('unpaid') text-yellow-600 dark:text-yellow-400 @break
                                @case('paid') text-green-600 dark:text-green-400 @break
                                @case('failed') text-red-600 dark:text-red-400 @break
                                @case('refunded') text-blue-600 dark:text-blue-400 @break
                                @default text-gray-600 dark:text-gray-400
                            @endswitch
                        ">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    @if($order->payment_details)
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Detail Tambahan:</p>
                        <pre class="text-xs bg-gray-100 dark:bg-gray-700 p-2 rounded mt-1 overflow-x-auto">{{ json_encode($order->payment_details, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                </div>
            </div>

            @if($order->customer)
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Pelanggan</h3>
                 <div class="text-sm space-y-1">
                    <p><span class="font-semibold text-gray-700 dark:text-gray-300">Nama:</span> <span class="text-gray-600 dark:text-gray-400">{{ $order->customer->name }}</span></p>
                    <p><span class="font-semibold text-gray-700 dark:text-gray-300">Email:</span> <span class="text-gray-600 dark:text-gray-400">{{ $order->customer->email }}</span></p>
                    {{-- Tambahkan info lain jika ada, misal nomor telepon dari profil user --}}
                </div>
            </div>
            @endif

            @if($order->tenant)
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Tenant</h3>
                 <div class="text-sm space-y-1">
                    <p><span class="font-semibold text-gray-700 dark:text-gray-300">Nama Tenant:</span> <span class="text-gray-600 dark:text-gray-400">{{ $order->tenant->name }}</span></p>
                    <p><span class="font-semibold text-gray-700 dark:text-gray-300">Kantin:</span> <span class="text-gray-600 dark:text-gray-400">{{ $order->tenant->canteen->name ?? 'N/A' }}</span></p>
                    @if($order->tenant->logo)
                        <img src="{{ asset('storage/' . $order->tenant->logo) }}" alt="{{ $order->tenant->name }}" class="h-16 w-16 object-cover rounded mt-2">
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
