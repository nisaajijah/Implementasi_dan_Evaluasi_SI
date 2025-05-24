<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            {{ $title }}
        </h2>
    </x-slot>

    <!-- Tambahkan link untuk AOS library di bagian head -->
    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    @endpush

    <div class="py-8 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="800" class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
                <div class="p-6">
                    @if($orders->count() > 0)


                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pesanan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 hover:text-green-800">
                                            <a href="{{ route('customer.orders.show', $order) }}" class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                </svg>
                                                {{ $order->order_code }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                                    @if(isset($order->tenant) && isset($order->tenant->logo_path))
                                                    <img src="{{ asset('storage/' . $order->tenant->logo_path) }}" alt="{{ $order->tenant->name }}" class="h-6 w-6 rounded-full">
                                                    @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    @endif
                                                </div>
                                                {{ $order->tenant->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @switch($order->status)
                                                    @case('pending_payment') bg-yellow-100 text-yellow-800 @break
                                                    @case('paid') bg-blue-100 text-blue-800 @break
                                                    @case('processing') bg-green-100 text-green-800 @break
                                                    @case('ready_for_pickup') bg-emerald-100 text-emerald-800 @break
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <a href="{{ route('customer.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination dengan Style Yang Lebih Modern -->
                        <div class="mt-6">
                            <div class="pagination-wrapper">
                                {{ $orders->links() }}
                            </div>
                            
                            <!-- Override style pagination dengan CSS yang lebih modern -->
                            <style>
                                .pagination-wrapper nav div:first-child {
                                    display: none;
                                }
                                .pagination-wrapper nav div:last-child span, 
                                .pagination-wrapper nav div:last-child a {
                                    border-radius: 0.5rem !important;
                                    margin: 0 0.15rem;
                                    min-width: 36px;
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                }
                                .pagination-wrapper nav div:last-child span.bg-blue-50,
                                .pagination-wrapper nav div:last-child a.bg-white {
                                    background-color: #f9fafb !important;
                                }
                                .pagination-wrapper nav div:last-child span.border-gray-300,
                                .pagination-wrapper nav div:last-child a.border-gray-300 {
                                    border-color: #e5e7eb !important;
                                }
                                .pagination-wrapper nav div:last-child span.text-gray-500:hover,
                                .pagination-wrapper nav div:last-child a.text-gray-500:hover {
                                    background-color: #f3f4f6 !important;
                                }
                                .pagination-wrapper nav div:last-child span.bg-blue-50 {
                                    background-color: #ecfdf5 !important;
                                    color: #047857 !important;
                                    border-color: #d1fae5 !important;
                                }
                            </style>
                        </div>
                    @else
                        <div data-aos="fade-up" class="text-center py-16">
                            <div class="h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-xl font-bold text-gray-900">Belum Ada Pesanan</h3>
                            <p class="mt-2 text-base text-gray-500">Anda belum pernah melakukan pemesanan apapun.</p>
                            <div class="mt-8">
                                <a href="{{ route('customer.canteens.index') }}" class="inline-flex items-center px-6 py-3 font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Mulai Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Tambahan di Bawah -->
            <div data-aos="fade-up" data-aos-delay="200" class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tips Pemesanan -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="rounded-full w-12 h-12 bg-green-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">Tips Pemesanan</h3>
                    <p class="text-gray-600 text-sm">Pesan makanan minimal 30 menit sebelum waktu makan untuk memastikan pesanan Anda diproses tepat waktu.</p>
                </div>
                
                <!-- Bantuan -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="rounded-full w-12 h-12 bg-blue-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">Butuh Bantuan?</h3>
                    <p class="text-gray-600 text-sm">Jika ada kendala dengan pesanan Anda, silakan hubungi tim dukungan pelanggan kami di nomor 0800-123-4567.</p>
                </div>
                
                <!-- Pembayaran -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="rounded-full w-12 h-12 bg-yellow-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800 mb-2">Opsi Pembayaran</h3>
                    <p class="text-gray-600 text-sm">Kami menerima berbagai metode pembayaran termasuk transfer bank, e-wallet, dan pembayaran tunai saat pengambilan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Load AOS Library Scripts -->
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                duration: 800,
                easing: 'ease-out-cubic'
            });
        });
    </script>
    @endpush
</x-app-layout>