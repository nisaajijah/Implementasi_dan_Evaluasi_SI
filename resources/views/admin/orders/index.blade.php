<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-green-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <div class="p-6">
                <!-- Filter dan Pencarian -->
                <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="search" class="block text-sm font-medium text-green-700">Cari (Kode, Customer, Tenant)</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   class="mt-1 block w-full rounded-lg border-green-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 shadow-sm"
                                   placeholder="Masukkan kata kunci...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-green-700">Filter Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-lg border-green-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 shadow-sm">
                                <option value="all">Semua Status</option>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col md:flex-row gap-2">
                            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200 w-full md:w-auto">Terapkan Filter</button>
                            @if(request('search') || request('status'))
                                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-800 font-semibold rounded-lg transition-colors duration-200 w-full md:w-auto">Reset Filter</a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-100">
                        <thead class="bg-green-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Kode Order</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Tenant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Status Pesanan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Metode Bayar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Tgl Order</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            @forelse ($orders as $order)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-800">{{ $order->order_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $order->customer->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $order->tenant->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
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
                                        @endswitch
                                    ">
                                        {{ $statuses[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $order->payment_method ? Str::upper($order->payment_method) : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-green-600 hover:text-green-800 transition-colors duration-150">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-center text-green-500">
                                    Belum ada data transaksi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $orders->links('') }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>