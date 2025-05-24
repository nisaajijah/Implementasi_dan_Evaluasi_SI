<x-app-layout :title="$title" :show-navigation="true"> {{-- Asumsi layout app.blade.php bisa handle navigasi --}}

    {{-- Hero Section --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-green-600 to-green-400">
        <!-- Animated background elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full animate-pulse"></div>
            <div class="absolute top-40 right-20 w-32 h-32 bg-white opacity-10 rounded-full animate-ping"
                style="animation-duration: 3s"></div>
            <div class="absolute bottom-10 left-1/4 w-24 h-24 bg-white opacity-10 rounded-full animate-pulse"
                style="animation-duration: 4s"></div>
            <div class="absolute bottom-20 right-1/3 w-16 h-16 bg-white opacity-10 rounded-full animate-ping"
                style="animation-duration: 5s"></div>
        </div>

        <div class="max-w-7xl mx-auto py-20 px-4 sm:py-28 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="text-left">
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-white">
                        <span class="block mb-2">E-Canteen UIN</span>
                        <span class="block text-green-100 text-3xl sm:text-4xl lg:text-5xl">Pesan Makan Kampus Jadi
                            Mudah!</span>
                    </h1>
                    <p class="mt-6 text-xl text-white leading-relaxed">
                        Nikmati berbagai pilihan menu lezat dari kantin favoritmu di lingkungan UIN. Tanpa antri, tanpa
                        ribet, pesan online, ambil langsung atau minta diantar ke lokasimu.
                    </p>
                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="{{ route('customer.canteens.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-semibold rounded-lg shadow-lg bg-white text-green-600 hover:bg-green-50 transform hover:-translate-y-1 transition-all duration-300">
                            Jelajahi Kantin
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>

                    </div>
                    <div class="mt-8 flex items-center text-white text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-200" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tersedia 3 kantin dengan beragam pilihan menu</span>
                    </div>
                </div>
                <div class="hidden lg:flex lg:justify-center lg:items-center">
                    <!-- Improved placeholder for cartoon illustration -->
                    <div class="relative w-full h-auto max-w-md">
                        <!-- Main image container with shadow and border -->
                        <div
                            class="w-full aspect-square rounded-full bg-white bg-opacity-10 p-4 border-2 border-white border-opacity-20 shadow-xl overflow-hidden flex items-center justify-center">
                            <img src="{{ asset('images/logo1.png') }}" alt="Cartoon"
                                class="object-contain h-full w-full">
                        </div>


                        <!-- Decorative elements around the main image -->
                        <div class="absolute -top-6 -right-6 w-12 h-12 bg-yellow-400 rounded-full animate-pulse"></div>
                        <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-green-300 rounded-full animate-ping"
                            style="animation-duration: 3s"></div>
                        <div class="absolute top-1/4 -left-8 w-16 h-16 bg-green-200 bg-opacity-50 rounded-full"></div>

                        <!-- Food icons floating around -->
                        <div class="absolute top-0 left-1/4 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center animate-bounce"
                            style="animation-duration: 2s">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                            </svg>
                        </div>
                        <div class="absolute bottom-0 right-1/4 transform translate-x-1/2 translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center animate-bounce"
                            style="animation-duration: 2.5s; animation-delay: 0.5s">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sekilas Tentang E-Canteen --}}
    <div class="py-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 space-y-12 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    <span class="block text-green-600">Kenapa E-Canteen UIN?</span>
                </h2>
                <p class="mt-4 text-xl text-gray-600">
                    Nikmati kemudahan memesan makanan di kampus tanpa antri.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-14">
                <div
                    class="bg-white p-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 border-t-4 border-green-500">
                    <div
                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 7v10m0 0h12M4 7l4-4m0 0l4 4m-4-4v10m0 0h12m0 0l4-4m-4 4l-4-4m4 4V7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Banyak Pilihan Kantin</h3>
                    <p class="mt-2 text-base text-gray-600">Akses semua kantin (3 kantin) melalui satu website. Cukup
                        sekali klik untuk melihat semua menu.</p>
                </div>
                <div
                    class="bg-white p-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 border-t-4 border-green-500">
                    <div
                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Pesan & Ambil Fleksibel</h3>
                    <p class="mt-2 text-base text-gray-600">Atur waktu pengambilan atau pilih opsi delivery. Tanpa
                        perlu antri dan menunggu lama.</p>
                </div>
                <div
                    class="bg-white p-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 border-t-4 border-green-500">
                    <div
                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Pembayaran Mudah</h3>
                    <p class="mt-2 text-base text-gray-600">Opsi COD, E-wallet, atau Transfer (simulasi). Pilih sesuai
                        kenyamanan Anda.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kantin Unggulan --}}
    @if ($canteens->count() > 0)
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        <span class="block text-green-600">Jelajahi Kantin Kami</span>
                    </h2>
                </div>

                {{-- INI BAGIAN PENTING UNTUK LAYOUT 3 KOLOM --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                    @foreach ($canteens as $canteen)
                        {{-- Struktur card yang memastikan tinggi konsisten --}}
                        <div class="group flex">
                            <a href="{{ route('customer.canteens.tenants.index', $canteen) }}" class="block w-full">
                                <div
                                    class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 group-hover:shadow-2xl group-hover:-translate-y-1 h-full flex flex-col">
                                    {{-- Gambar Kantin atau Placeholder --}}
                                    <div class="relative w-full h-56 sm:h-64 overflow-hidden">
                                        @if ($canteen->image)
                                            <img src="{{ asset('storage/' . $canteen->image) }}"
                                                alt="{{ $canteen->name }}"
                                                class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300">
                                            </div>
                                        @else
                                            <div class="w-full h-full bg-green-50 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-20 w-20 text-green-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                                                </svg>
                                            </div>
                                            <h3
                                                class="text-lg sm:text-xl font-semibold text-gray-800 group-hover:text-green-600 transition-colors duration-300 leading-tight">
                                                {{ $canteen->name }}
                                            </h3>
                                        </div>
                                        <p class="mt-3 text-sm text-gray-500 line-clamp-3 flex-grow">
                                            {{ $canteen->location_description ?: 'Deskripsi lokasi tidak tersedia.' }}
                                        </p>
                                        {{-- Tombol Aksi / Footer Card --}}
                                        <div class="mt-auto pt-4">
                                            <div
                                                class="flex items-center text-green-600 font-medium group-hover:text-green-700 transition-colors duration-300">
                                                <span>Lihat Menu</span>
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

                {{-- Tombol Lihat Semua Kantin --}}
                @if ($totalCanteenCount > $canteens->count())
                    <div class="text-center mt-12 sm:mt-16">
                        <a href="{{ route('customer.canteens.index') }}"
                            class="inline-flex items-center px-6 py-3 sm:px-8 sm:py-3.5 border border-transparent text-base font-medium rounded-lg shadow-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                            Lihat Semua Kantin
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 -mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Cara Kerja (How It Works) with Animation --}}
    <div class="py-20 bg-white relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute right-0 top-0 h-64 w-64 bg-green-50 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute left-0 bottom-0 h-64 w-64 bg-green-50 rounded-full -ml-32 -mb-32"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    <span class="block text-green-600">Cara Mudah Memesan</span>
                </h2>
                <p class="mt-4 text-xl text-gray-600 max-w-xl mx-auto">
                    Hanya dengan 3 langkah sederhana, nikmati makanan favoritmu dengan cepat dan praktis
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Connection line for desktop -->
                <div class="hidden md:block absolute top-20 left-0 right-0 h-0.5 bg-green-200"></div>

                <!-- Step 1 -->
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-40 h-40 bg-white p-4 rounded-full border-2 border-green-200 shadow-lg flex items-center justify-center mb-6 relative z-10">
                        <!-- Placeholder for step 1 illustration -->
                        <div class="w-32 h-32 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="absolute top-16 md:top-20 flex items-center justify-center h-8 w-8 rounded-full bg-green-600 text-white text-xl font-bold z-20">
                        1</div>
                    <h4 class="text-xl font-bold text-gray-900">Pilih Kantin & Tenant</h4>
                    <p class="mt-2 text-base text-gray-600">Jelajahi daftar kantin dan pilih tenant favoritmu dengan
                        mudah</p>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-40 h-40 bg-white p-4 rounded-full border-2 border-green-200 shadow-lg flex items-center justify-center mb-6 relative z-10">
                        <!-- Placeholder for step 2 illustration -->
                        <div class="w-32 h-32 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="absolute top-16 md:top-20 flex items-center justify-center h-8 w-8 rounded-full bg-green-600 text-white text-xl font-bold z-20">
                        2</div>
                    <h4 class="text-xl font-bold text-gray-900">Pilih Menu & Pesan</h4>
                    <p class="mt-2 text-base text-gray-600">Pilih makanan dan minuman yang diinginkan, lalu masukkan ke
                        keranjang</p>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center text-center">
                    <div
                        class="w-40 h-40 bg-white p-4 rounded-full border-2 border-green-200 shadow-lg flex items-center justify-center mb-6 relative z-10">
                        <!-- Placeholder for step 3 illustration -->
                        <div class="w-32 h-32 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="absolute top-16 md:top-20 flex items-center justify-center h-8 w-8 rounded-full bg-green-600 text-white text-xl font-bold z-20">
                        3</div>
                    <h4 class="text-xl font-bold text-gray-900">Ambil atau Tunggu Pesanan</h4>
                    <p class="mt-2 text-base text-gray-600">Selesaikan pembayaran, atur pengambilan atau tunggu
                        pesananmu diantar!</p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('customer.canteens.index') }}"
                    class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-all duration-300 hover:shadow-lg">
                    Pesan Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 animate-bounce" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Call to Action --}}
    <div class="bg-green-600 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <!-- Ganti placeholder dengan gambar PNG -->
                    <div class="h-64  bg-opacity-10 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo1.png') }}" alt="Deskripsi Gambar"
                            class="h-48 object-contain" />
                    </div>
                </div>

                <div class="text-white">
                    <h2 class="text-3xl font-bold">Ingin Makan Enak & Praktis?</h2>
                    <p class="mt-4 text-green-100 text-lg">Buruan pesan makanan dari kantin kampus favoritmu sekarang
                        juga!</p>
                    <div class="mt-8">
                        <a href="{{ route('customer.canteens.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-green-700 bg-white hover:bg-green-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
