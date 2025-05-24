<x-app-layout :title="$title">
    <x-slot name="header">
         <div class="flex items-center">
            <a href="{{ route('customer.canteens.tenants.index', $tenant->canteen) }}" class="text-green-600 hover:text-green-700 mr-3 transition-all duration-300 transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div class="flex items-center">
                @if($tenant->logo)
                    <img src="{{ asset('storage/' . $tenant->logo) }}" alt="{{ $tenant->name }}" class="h-12 w-12 object-cover rounded-full mr-3 shadow-md border-2 border-green-100">
                @else
                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        Menu dari <span class="text-green-600">{{ $tenant->name }}</span>
                    </h2>
                    <span class="text-sm text-gray-500 block flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $tenant->canteen->name }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div id="flash-success" class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-md relative animate__animated animate__fadeIn" role="alert">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline ml-1">{{ session('success') }}</span>
                        </div>
                    </div>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg onclick="document.getElementById('flash-success').style.display='none'" class="fill-current h-6 w-6 text-green-500 cursor-pointer hover:text-green-600 transition-colors duration-300" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif

            @if($tenant->menuItems->count() > 0)
                @if($categories->count() > 0)
                    {{-- Tampilkan menu per kategori --}}
                    <div class="space-y-10">
                        @foreach($categories as $category)
                            <div class="category-section">
                                <div class="flex items-center mb-6">
                                    <h3 class="text-2xl font-bold text-gray-800 border-b-2 border-green-500 pb-2">{{ $category }}</h3>
                                    <div class="ml-3 pl-3 border-l-2 border-gray-200 text-gray-500 text-sm">
                                        {{ $tenant->menuItems->where('category', $category)->count() }} menu
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate__animated animate__fadeIn">
                                    @foreach($tenant->menuItems->where('category', $category) as $item)
                                        @include('customer.tenants._menu_item_card', ['item' => $item])
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        {{-- Tampilkan menu tanpa kategori (jika ada) --}}
                        @if($tenant->menuItems->where('category', null)->count() > 0)
                        <div class="category-section">
                            <div class="flex items-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 border-b-2 border-green-500 pb-2">Lainnya</h3>
                                <div class="ml-3 pl-3 border-l-2 border-gray-200 text-gray-500 text-sm">
                                    {{ $tenant->menuItems->where('category', null)->count() }} menu
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate__animated animate__fadeIn">
                                @foreach($tenant->menuItems->where('category', null) as $item)
                                    @include('customer.tenants._menu_item_card', ['item' => $item])
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    {{-- Tampilkan semua menu jika tidak ada kategori --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate__animated animate__fadeIn">
                        @foreach($tenant->menuItems as $item)
                            @include('customer.tenants._menu_item_card', ['item' => $item])
                        @endforeach
                    </div>
                @endif
            @else
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-10 text-gray-900 text-center">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <p class="text-lg">Tenant ini belum memiliki item menu yang tersedia.</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Floating Cart Button --}}
            @if(Cart::instance('default')->count() > 0)
            <a href="{{ route('cart.index') }}" class="fixed bottom-6 right-6 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-5 rounded-full shadow-lg z-50 flex items-center transition-all duration-300 transform hover:scale-105 animate-bounce-subtle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Lihat Keranjang <span class="ml-1 bg-white text-green-600 rounded-full h-6 w-6 flex items-center justify-center font-bold text-sm">{{ Cart::instance('default')->count() }}</span>
            </a>
            @endif
        </div>
    </div>

    <style>
        /* Import Animate.css untuk animasi */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
        
        /* Animasi untuk tombol keranjang */
        @keyframes bounce-subtle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        .animate-bounce-subtle {
            animation: bounce-subtle 3s infinite;
        }
        
        /* Animasi untuk section kategori */
        .category-section {
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Animasi untuk card saat scroll */
        .category-section:nth-child(1) { animation-delay: 0.1s; }
        .category-section:nth-child(2) { animation-delay: 0.2s; }
        .category-section:nth-child(3) { animation-delay: 0.3s; }
        .category-section:nth-child(4) { animation-delay: 0.4s; }
        .category-section:nth-child(5) { animation-delay: 0.5s; }
    </style>
    
    <script>
        // Script untuk animasi saat scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Tunggu dokumen selesai dimuat
            setTimeout(function() {
                const sections = document.querySelectorAll('.category-section');
                sections.forEach(section => {
                    section.style.opacity = '1';
                });
            }, 100);
        });
    </script>
</x-app-layout>