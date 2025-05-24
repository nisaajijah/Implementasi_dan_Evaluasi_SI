<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <!-- Tambahkan link untuk AOS library di bagian head -->
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    @endpush

    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Salam Pembuka dan CTA Utama -->
            <div data-aos="fade-up" data-aos-duration="800"
                class="bg-white overflow-hidden shadow-xl rounded-xl border-l-4 border-green-500 mb-8 transform transition hover:scale-[1.01]">
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        <div class="md:col-span-8">
                            <h3
                                class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-500 bg-clip-text text-transparent">
                                Selamat Datang Kembali, {{ $user->name }}!
                            </h3>
                            <p class="mt-3 text-gray-600 text-lg">
                                Siap untuk memesan makanan favoritmu hari ini?
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('customer.canteens.index') }}"
                                    class="inline-flex items-center px-6 py-3 font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                    </svg>
                                    Pesan Makan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid Layout untuk Konten Utama -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Ringkasan Pesanan Aktif -->
                <div class="lg:col-span-2">
                    <div data-aos="fade-up" data-aos-delay="200"
                        class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 transition-all hover:shadow-xl">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Pesanan Aktif Anda
                                </h4>
                                <a href="{{ route('customer.orders.index') }}"
                                    class="text-sm font-medium text-green-600 hover:text-green-700 flex items-center group">
                                    Lihat Semua
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-1 transition-transform duration-200 transform group-hover:translate-x-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($activeOrders->count() > 0)
                                <ul class="divide-y divide-gray-100">
                                    @foreach ($activeOrders as $order)
                                        <li
                                            class="py-4 first:pt-0 last:pb-0 transform transition hover:bg-gray-50 rounded-lg px-3 -mx-3">
                                            <a href="{{ route('customer.orders.show', $order) }}" class="block">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        @if ($order->delivery_method == 'pickup')
                                                            <span
                                                                class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                                                <svg class="h-6 w-6 text-green-600"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100">
                                                                <svg class="h-6 w-6 text-emerald-600"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                                    aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                                    </path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            Pesanan <span
                                                                class="text-green-600 font-bold">{{ $order->order_code }}</span>
                                                        </p>
                                                        <p class="text-sm text-gray-500 truncate">
                                                            Dari: {{ $order->tenant->name }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span
                                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @switch($order->status)
                                                        @case('pending_payment') bg-yellow-100 text-yellow-800 @break
                                                        @case('paid') bg-blue-100 text-blue-800 @break
                                                        @case('processing') bg-green-100 text-green-800 @break
                                                        @case('ready_for_pickup') bg-emerald-100 text-emerald-800 @break
                                                        @case('out_for_delivery') bg-teal-100 text-teal-800 @break
                                                        @default bg-gray-100 text-gray-800
                                                    @endswitch
                                                ">
                                                            {{ $orderStatuses[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status)) }}
                                                        </span>
                                                        <p class="text-xs text-gray-500 mt-1 font-medium">Rp
                                                            {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-4 text-lg font-medium text-gray-700">Anda tidak memiliki pesanan aktif
                                        saat ini.</p>
                                    <p class="mt-2 text-gray-500">Pesan makanan favorit Anda sekarang!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengumuman Terbaru -->
            @if ($announcements->count() > 0)
                <div data-aos="fade-up" data-aos-delay="500" class="mt-8">
                    <div
                        class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 transition-all hover:shadow-xl">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                                Pengumuman Terbaru
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($announcements as $announcement)
                                    <div
                                        class="p-5 border border-gray-200 rounded-xl hover:shadow-md transition-all hover:border-green-200 bg-white group">
                                        <h5
                                            class="font-bold text-green-600 text-lg group-hover:text-green-700 transition-colors">
                                            {{ $announcement->title }}</h5>
                                        <p class="text-xs text-gray-500 mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $announcement->published_at ? $announcement->published_at->format('d M Y, H:i') : $announcement->created_at->format('d M Y, H:i') }}
                                        </p>
                                        <div class="prose prose-sm max-w-none text-gray-600">
                                            {!! \Illuminate\Support\Str::markdown(Str::limit($announcement->content, 250)) !!}
                                        </div>
                                        @if (strlen(strip_tags(\Illuminate\Support\Str::markdown($announcement->content))) > 250)
                                            <div class="mt-3">
                                                <button
                                                    class="text-sm text-green-600 hover:text-green-700 font-medium flex items-center">
                                                    Baca Selengkapnya
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

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
