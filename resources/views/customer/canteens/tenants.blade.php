<x-app-layout :title="$title">
    <!-- Header dengan tema hijau -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-500 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center">
                <a href="{{ route('customer.canteens.index') }}" class="text-white hover:text-green-100 mr-3 transition duration-300 transform hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-bold text-xl text-white leading-tight">
                    Tenant di <span class="text-green-100 underline decoration-2 decoration-white underline-offset-2">{{ $canteen->name }}</span>
                </h2>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r shadow-md animate-bounce">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Intro section -->
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Pilih Tenant Favorit Anda</h3>
                <p class="text-gray-600 mt-2">Temukan berbagai pilihan tenant di kantin {{ $canteen->name }}</p>
            </div>

            @if($canteen->tenants->count() > 0)
                <div x-data="{}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($canteen->tenants as $tenant)
                    <a href="{{ route('customer.tenants.menu', $tenant) }}" class="block group" 
                       x-data="{}" 
                       x-on:mouseenter="$el.querySelector('.tenant-card').classList.add('scale-105')"
                       x-on:mouseleave="$el.querySelector('.tenant-card').classList.remove('scale-105')">
                        <div class="tenant-card bg-white overflow-hidden rounded-xl shadow-md border-b-4 border-green-500 transition-all duration-300 ease-in-out transform hover:shadow-xl">
                            <div class="relative">
                                @if($tenant->logo)
                                    <div class="relative overflow-hidden h-48">
                                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="{{ $tenant->name }}" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="text-lg font-medium text-green-600 mt-2">Tenant</span>
                                    </div>
                                @endif
                                
                                @if(!$tenant->is_open)
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            TUTUP
                                        </span>
                                    </div>
                                @else
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            BUKA
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-5">
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                    </svg>
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300">{{ $tenant->name }}</h3>
                                </div>
                                
                                <p class="text-gray-600 mb-4 line-clamp-2 min-h-[3rem]">{{ $tenant->description ?: 'Tidak ada deskripsi tersedia untuk tenant ini.' }}</p>
                                
                                <div class="flex justify-end">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                                        Lihat Menu
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden rounded-xl shadow-md border border-gray-100">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Tenant</h3>
                        <p class="text-gray-600 mb-6">Belum ada tenant yang tersedia atau buka di kantin ini.</p>
                        <a href="{{ route('customer.canteens.index') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-medium rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            Kembali ke Daftar Kantin
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Alpine.js for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
    <!-- Add line-clamp plugin for Tailwind -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss-line-clamp/2.0.0/tailwindcss-line-clamp.min.js"></script>
</x-app-layout>