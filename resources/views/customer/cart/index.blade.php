<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <!-- Tambahkan CDN untuk Heroicons (untuk icon yang lebih baik) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/heroicons/1.0.6/outline.min.js"></script>
    
    <div class="py-8 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-md flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-md flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-md flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ session('warning') }}
                </div>
            @endif

            <!-- Card Container -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                @if ($cartItems->count() > 0)
                    <!-- Current Tenant Info -->
                    @if($currentCartTenant)
                    <div class="bg-green-50 p-4 border-b border-green-100">
                        <div class="flex items-center text-sm text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            Anda sedang memesan dari:
                            <a href="{{ route('customer.tenants.menu', $currentCartTenant) }}" class="ml-1 font-semibold text-green-700 hover:text-green-900 hover:underline">
                                {{ $currentCartTenant->name }}
                            </a>
                            <span class="mx-1">•</span>
                            <span class="text-green-600">Kantin: {{ $currentCartTenant->canteen->name }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Cart Items List -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Pesanan Anda</h3>
                        <div class="grid gap-4">
                            @foreach ($cartItems as $item)
                            <div class="p-4 border border-gray-100 rounded-lg hover:shadow-md transition duration-200 ease-in-out grid md:grid-cols-4 gap-4 items-center">
                                <!-- Product Image -->
                                <div class="md:col-span-1">
                                    @if ($item->options->has('image') && $item->options->image)
                                        <img src="{{ asset('storage/' . $item->options->image) }}" alt="{{ $item->name }}" class="h-24 w-full object-cover rounded-md">
                                    @else
                                        <div class="h-24 w-full bg-gray-100 rounded-md flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="md:col-span-2">
                                    <h4 class="font-medium text-gray-900 text-base">{{ $item->name }}</h4>
                                    <p class="mt-1 text-sm text-gray-500">Harga Satuan: <span class="text-green-600 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</span></p>
                                    <p class="mt-1 text-sm text-gray-500">Total: <span class="text-green-700 font-bold">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span></p>
                                </div>
                                
                                <!-- Actions -->
                                <div class="md:col-span-1 flex flex-col space-y-2">
                                    <form action="{{ route('cart.update', $item->rowId) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                                            <button type="button" onclick="decrementQuantity('{{ $item->rowId }}')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" id="quantity-{{ $item->rowId }}" value="{{ $item->qty }}"
                                                   min="1" max="10">
                                            <button type="button" onclick="incrementQuantity('{{ $item->rowId }}')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="submit" class="text-xs px-2 py-1 bg-green-50 text-green-600 hover:bg-green-100 rounded-md font-medium">
                                            Update
                                        </button>
                                    </form>

                                    <form action="{{ route('cart.remove', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs w-full flex items-center justify-center px-2 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-md font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Checkout Summary -->
                    <div class="border-t border-gray-200 bg-gray-50 p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Order Summary -->
                            <div class="space-y-3">
                                <h3 class="text-lg font-semibold text-gray-800">Ringkasan Pesanan</h3>
                                <div class="flex justify-between text-base text-gray-700">
                                    <p>Subtotal</p>
                                    <p>Rp {{ number_format((float) $cartSubtotal, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex justify-between text-lg font-bold text-green-800 pt-2 border-t border-gray-200">
                                    <p>Total</p>
                                    <p>Rp {{ number_format((float) $cartTotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="space-y-3 flex flex-col justify-between">
                                <a href="{{ route('checkout.index') }}"
                                   class="w-full flex items-center justify-center rounded-md border border-transparent bg-green-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-700 transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    Lanjut ke Pembayaran
                                </a>
                                
                                <div class="flex justify-between items-center">
                                    <a href="{{ $currentCartTenant ? route('customer.tenants.menu', $currentCartTenant) : route('customer.canteens.index') }}" class="inline-flex items-center font-medium text-green-600 hover:text-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Lanjut Belanja
                                    </a>
                                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengosongkan keranjang?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center font-medium text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Kosongkan Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Empty Cart View -->
                    <div class="p-12 text-center">
                        <div class="inline-block p-6 rounded-full bg-green-50 text-green-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Keranjang belanja Anda masih kosong</h3>
                        <p class="text-gray-500 mb-6">Ayo mulai pilih menu favoritmu dan nikmati pengalaman kuliner yang lezat!</p>
                        <a href="{{ route('customer.canteens.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script untuk increment/decrement pada input kuantitas -->
    <script>
        function incrementQuantity(rowId) {
            const input = document.getElementById('quantity-' + rowId);
            const currentValue = parseInt(input.value);
            if (currentValue < 10) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity(rowId) {
            const input = document.getElementById('quantity-' + rowId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
</x-app-layout>