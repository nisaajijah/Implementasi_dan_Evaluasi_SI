<x-app-layout :title="$title">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-white text-center mb-2">Kantin Tersedia</h1>
            <p class="text-white text-center text-lg">Pilih kantin favorit Anda dan nikmati berbagai pilihan makanan</p>
        </div>
    </div>

<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($canteens->count() > 0)
            {{-- INI BAGIAN YANG MENGATUR 3 KOLOM PADA LAYAR MEDIUM KE ATAS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                @foreach($canteens as $canteen)
                <div class="group flex">
                    <a href="{{ route('customer.canteens.tenants.index', $canteen) }}" class="block w-full">
                        <div
                            class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 group-hover:shadow-2xl group-hover:-translate-y-1 h-full flex flex-col">

                            {{-- Gambar Kantin atau Placeholder --}}
                            <div class="relative w-full h-56 sm:h-64 overflow-hidden">
                                @if($canteen->image)
                                    <img src="{{ asset('storage/' . $canteen->image) }}" alt="{{ $canteen->name }}"
                                        class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300">
                                    </div>
                                @else
                                    <div class="w-full h-full bg-green-50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-green-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Konten Card --}}
                            <div class="p-5 sm:p-6 flex-grow flex flex-col">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center mr-3 sm:mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800 group-hover:text-green-600 transition-colors duration-300 leading-tight">
                                        {{ $canteen->name }}
                                    </h3>
                                </div>

                                <p class="mt-3 text-sm text-gray-500 line-clamp-3">
                                    {{ $canteen->location_description ?: 'Deskripsi lokasi tidak tersedia.' }}
                                </p>

                                @if($canteen->operating_hours)
                                <div class="mt-2 flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $canteen->operating_hours }}</span>
                                </div>
                                @endif

                                <div class="mt-auto pt-4">
                                    <div class="flex items-center text-green-600 font-medium group-hover:text-green-700 transition-colors duration-300">
                                        <span>Lihat Tenant</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 ml-1.5 transform group-hover:translate-x-1 transition-transform duration-300"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                <div class="p-10 sm:p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Kantin</h3>
                    <p class="text-gray-500">Saat ini belum ada kantin yang tersedia. Silakan periksa kembali nanti.</p>
                </div>
            </div>
        @endif
    </div>
</div>

    <!-- Add Alpine.js for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.min.js" defer></script>
</x-app-layout>
