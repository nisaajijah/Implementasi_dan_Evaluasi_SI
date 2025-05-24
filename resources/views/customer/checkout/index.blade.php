<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <!-- Tambahkan CDN untuk Font Awesome (untuk icon yang lebih menarik) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="py-8 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md flex items-center shadow-sm">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                   

                    <div class="p-6 md:p-8">
                        <!-- Order Summary Section -->
                        <section class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-clipboard-list mr-2 text-green-600"></i>
                                Ringkasan Pesanan dari <span class="text-green-600 ml-1">{{ $tenant->name }}</span>
                            </h3>
                            
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <ul class="divide-y divide-gray-200">
                                    @foreach ($cartItems as $item)
                                    <li class="py-3 grid grid-cols-12 gap-2 items-center text-sm">
                                        <div class="col-span-1">
                                            @if ($item->options->has('image') && $item->options->image)
                                                <img src="{{ asset('storage/' . $item->options->image) }}" alt="{{ $item->name }}" class="h-12 w-12 object-cover rounded-md">
                                            @else
                                                <div class="h-12 w-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-utensils"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-span-7 sm:col-span-8">
                                            <span class="font-medium text-gray-900">{{ $item->name }}</span>
                                            <span class="text-gray-500"> (x{{ $item->qty }})</span>
                                        </div>
                                        <div class="col-span-4 sm:col-span-3 text-right">
                                            <span class="font-medium text-green-700">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Subtotal Produk</span>
                                    <span id="cart-subtotal-display">Rp {{ number_format((float) $cartSubtotal, 0, ',', '.') }}</span>
                                </div>
                                {{-- Tampilkan Ongkir jika Delivery --}}
                                <div id="delivery-fee-summary" class="flex justify-between text-sm text-gray-600 mt-1 {{ old('delivery_method', 'pickup') == 'delivery' ? '' : 'hidden' }}">
                                    <span>Ongkos Kirim</span>
                                    <span id="delivery-fee-display">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold text-green-700 mt-2 pt-2 border-t border-gray-200">
                                    <span>Total Pembayaran</span>
                                    <span id="grand-total-display">Rp {{ number_format((float) $cartTotal + (old('delivery_method', 'pickup') == 'delivery' ? $deliveryFee : 0), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </section>

                        <div class="h-px bg-gray-200 my-8"></div>

                        <!-- Delivery & Payment Section -->
                        <section>
                            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-truck mr-2 text-green-600"></i>
                                Detail Pengambilan & Pembayaran
                            </h3>

                            {{-- Metode Pengambilan --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Pengambilan <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label for="delivery_method_pickup" class="relative flex items-center p-4 border border-gray-300 rounded-md hover:border-green-500 cursor-pointer transition-all">
                                        <input type="radio" name="delivery_method" id="delivery_method_pickup" value="pickup" class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500" {{ old('delivery_method', 'pickup') == 'pickup' ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">Ambil Langsung</span>
                                            <span class="block text-xs text-gray-500 mt-1">Ambil pesanan Anda langsung di kantin</span>
                                        </div>
                                        <div class="absolute top-0 right-0 h-full flex items-center pr-3 pointer-events-none">
                                            <i class="fas fa-store text-green-500 opacity-70"></i>
                                        </div>
                                    </label>
                                    <label for="delivery_method_delivery" class="relative flex items-center p-4 border border-gray-300 rounded-md hover:border-green-500 cursor-pointer transition-all">
                                        <input type="radio" name="delivery_method" id="delivery_method_delivery" value="delivery" class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500" {{ old('delivery_method') == 'delivery' ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">Dikirim</span>
                                            <span class="block text-xs text-gray-500 mt-1">Pesanan akan dikirim ke alamat Anda</span>
                                        </div>
                                        <div class="absolute top-0 right-0 h-full flex items-center pr-3 pointer-events-none">
                                            <i class="fas fa-motorcycle text-green-500 opacity-70"></i>
                                        </div>
                                    </label>
                                </div>
                                @error('delivery_method') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Waktu Pengambilan (jika pickup) --}}
                            <div id="pickup_details" class="mb-6 p-4 bg-gray-50 rounded-lg {{ old('delivery_method', 'pickup') == 'pickup' ? '' : 'hidden' }}">
                                <label for="pickup_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="far fa-clock mr-1 text-green-600"></i>
                                    Waktu Pengambilan <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="pickup_time" id="pickup_time"
                                       value="{{ old('pickup_time', Carbon\Carbon::now()->addMinutes(30)->format('Y-m-d\TH:i')) }}"
                                       min="{{ Carbon\Carbon::now()->addMinutes(15)->format('Y-m-d\TH:i') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 @error('pickup_time') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Pilih waktu minimal 15 menit dari sekarang untuk memberikan waktu penjual menyiapkan pesanan Anda.</p>
                                @error('pickup_time') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Alamat Pengiriman (jika delivery) --}}
                            <div id="delivery_details" class="mb-6 p-4 bg-gray-50 rounded-lg {{ old('delivery_method') == 'delivery' ? '' : 'hidden' }}">
                                <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-1 text-green-600"></i>
                                    Alamat Pengiriman Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea name="delivery_address" id="delivery_address" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 @error('delivery_address') border-red-500 @enderror"
                                          placeholder="Contoh: Gedung Asrama Putra, Kamar 101, UIN Kampus 2">{{ old('delivery_address', Auth::user()->address ?? '') }}</textarea>
                                @error('delivery_address') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                             {{-- Catatan Pelanggan --}}
                            <div class="mb-6">
                                <label for="customer_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sticky-note mr-1 text-green-600"></i>
                                    Catatan untuk Penjual (Opsional)
                                </label>
                                <textarea name="customer_notes" id="customer_notes" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                                          placeholder="Misal: Tidak pakai bawang, sambal dipisah, dll.">{{ old('customer_notes') }}</textarea>
                                @error('customer_notes') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            {{-- Metode Pembayaran --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-credit-card mr-1 text-green-600"></i>
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($paymentMethods as $value => $label)
                                    <label for="payment_method_{{ $value }}" class="relative flex items-center p-4 border border-gray-300 rounded-md hover:border-green-500 cursor-pointer transition-all">
                                        <input type="radio" name="payment_method" id="payment_method_{{ $value }}" value="{{ $value }}" class="h-5 w-5 text-green-600 border-gray-300 focus:ring-green-500" {{ old('payment_method', 'cod') == $value ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">{{ $label }}</span>
                                            @if($value == 'cod')
                                                <span class="block text-xs text-gray-500 mt-1">Bayar langsung saat pesanan diterima</span>
                                            @elseif($value == 'transfer')
                                                <span class="block text-xs text-gray-500 mt-1">Transfer bank ke rekening yang tertera</span>
                                            @elseif($value == 'qris')
                                                <span class="block text-xs text-gray-500 mt-1">Scan kode QR untuk pembayaran</span>
                                            @endif
                                        </div>
                                        <div class="absolute top-0 right-0 h-full flex items-center pr-4 pointer-events-none">
                                            @if($value == 'cod')
                                                <i class="fas fa-hand-holding-usd text-green-500 opacity-70"></i>
                                            @elseif($value == 'transfer')
                                                <i class="fas fa-university text-green-500 opacity-70"></i>
                                            @elseif($value == 'qris')
                                                <i class="fas fa-qrcode text-green-500 opacity-70"></i>
                                            @endif
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                @error('payment_method') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>
                        </section>
                    </div>

                    <!-- Footer Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 sm:rounded-b-lg flex flex-col sm:flex-row justify-end items-center">
                        <a href="{{ route('cart.index') }}" class="w-full sm:w-auto mb-3 sm:mb-0 flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mr-3">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Keranjang
                        </a>
                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                            <i class="fas fa-check-circle mr-2"></i>
                            Buat Pesanan Sekarang
                        </button>
                    </div>
                </div>
            </form>
            
            <!-- Order Policy Information -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-md">
                <h4 class="font-medium text-gray-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle text-green-600 mr-2"></i>
                    Informasi Pesanan
                </h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                        Pembayaran COD hanya tersedia untuk pengambilan langsung
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                        Pesanan tidak dapat dibatalkan setelah diproses oleh penjual
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                        Waktu pengiriman sekitar 15-30 menit tergantung jarak dan kepadatan
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deliveryMethodRadios = document.querySelectorAll('input[name="delivery_method"]');
            const pickupDetails = document.getElementById('pickup_details');
            const deliveryDetails = document.getElementById('delivery_details');
            // Untuk Ongkir
            const deliveryFeeSummary = document.getElementById('delivery-fee-summary');
            const deliveryFeeDisplayValue = parseFloat('{{ $deliveryFee }}'); // Ambil nilai ongkir dari PHP
            const cartSubtotalValue = parseFloat('{{ (float) $cartSubtotal }}'); // Ambil subtotal dari PHP
            const grandTotalDisplay = document.getElementById('grand-total-display');
            
            // Add visual indication for selected radio options
            const allRadios = document.querySelectorAll('input[type="radio"]');
            function updateSelectedStyles() {
                allRadios.forEach(radio => {
                    const label = radio.closest('label');
                    if (radio.checked) {
                        label.classList.add('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-500', 'ring-opacity-50');
                    } else {
                        label.classList.remove('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-500', 'ring-opacity-50');
                    }
                });
            }

            function updateDeliveryFeeDisplay() {
                let currentGrandTotal = cartSubtotalValue;
                if (document.getElementById('delivery_method_delivery').checked) {
                    deliveryFeeSummary.classList.remove('hidden');
                    currentGrandTotal += deliveryFeeDisplayValue;
                } else {
                    deliveryFeeSummary.classList.add('hidden');
                }
                grandTotalDisplay.textContent = 'Rp ' + currentGrandTotal.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            }

            function toggleDetails() {
                if (document.getElementById('delivery_method_pickup').checked) {
                    pickupDetails.classList.remove('hidden');
                    deliveryDetails.classList.add('hidden');
                } else if (document.getElementById('delivery_method_delivery').checked) {
                    pickupDetails.classList.add('hidden');
                    deliveryDetails.classList.remove('hidden');
                }
                updateDeliveryFeeDisplay(); // Panggil update ongkir juga
                updateSelectedStyles();
            }

            deliveryMethodRadios.forEach(radio => radio.addEventListener('change', toggleDetails));
            allRadios.forEach(radio => radio.addEventListener('change', updateSelectedStyles));
            
            // Run on page load
            toggleDetails(); // Initial check
            updateDeliveryFeeDisplay(); // Initial calculation for grand total
            updateSelectedStyles();
        });
    </script>
</x-app-layout>