{{-- resources/views/customer/tenants/_menu_item_card.blade.php --}}
<div class="bg-white overflow-hidden shadow-lg rounded-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.01] flex flex-col h-full group">
    <div class="relative overflow-hidden">
        @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="w-full h-52 bg-gradient-to-br from-green-100 to-green-300 flex items-center justify-center text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 transform transition-transform duration-500 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
        @endif
        <div class="absolute top-0 right-0 m-3">
            @if($item->is_available && ($item->stock == -1 || $item->stock > 0))
                <span class="bg-green-500 text-white text-xs font-bold px-2 py-1.5 rounded-full inline-flex items-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Tersedia
                </span>
            @else
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1.5 rounded-full inline-flex items-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Habis
                </span>
            @endif
        </div>
    </div>
    
    <div class="p-5 flex-grow flex flex-col justify-between border-t border-green-100">
        <div>
            <h4 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300">{{ $item->name }}</h4>
            <p class="text-sm text-gray-600 mt-2 line-clamp-2 h-10">{{ $item->description ?: 'Tidak ada deskripsi.' }}</p>
            
            <div class="flex justify-between items-center mt-4">
                <p class="text-green-600 font-bold text-xl">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                @if($item->stock !== -1)
                    <span class="text-xs px-2.5 py-1.5 bg-green-100 text-green-800 rounded-full font-medium">
                        Stok: {{ $item->stock > 0 ? $item->stock : 'Habis' }}
                    </span>
                @endif
            </div>
        </div>
        
        <div class="mt-5 pt-3 border-t border-green-100">
            @if($item->is_available && ($item->stock == -1 || $item->stock > 0))
                @auth {{-- Jika user sudah login --}}
                    <form action="{{ route('cart.add', $item->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="name" value="{{ $item->name }}">
                        <input type="hidden" name="price" value="{{ $item->price }}">
                        <input type="hidden" name="quantity" value="1"> {{-- Default quantity 1 --}}
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2.5 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 cart-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else {{-- Jika user belum login (guest) --}}
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-4 rounded-lg transition-all duration-300 flex items-center justify-center shadow-md">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                             <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                         </svg>
                        Login untuk Pesan
                    </a>
                @endauth
            @else
                <button type="button" class="w-full bg-gray-300 text-gray-600 font-medium py-2.5 px-4 rounded-lg cursor-not-allowed flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Stok Habis
                </button>
            @endif
        </div>
    </div>
</div>

<style>
/* Import Google Font - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* Animasi untuk tombol Tambah ke Keranjang */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

/* Perbaikan animasi ikon keranjang */
.cart-icon {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Override primary-button dan secondary-button dengan tema hijau */
.primary-button {
  @apply bg-green-500 hover:bg-green-600 text-white font-medium py-2.5 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-1 shadow-md;
}

.secondary-button {
  @apply bg-gray-500 hover:bg-gray-600 text-white font-medium py-2.5 px-4 rounded-lg shadow-md;
}

/* Style untuk button yang tidak aktif */
.disabled-button {
  @apply bg-gray-300 text-gray-600 font-medium py-2.5 px-4 rounded-lg cursor-not-allowed shadow-sm;
}

/* Tambahan untuk line clamp */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Gaya tambahan untuk konsistensi */
body {
  font-family: 'Poppins', sans-serif;
}

/* Memastikan tombol memiliki warna yang tepat */
.bg-green-500 {
  background-color: #10b981 !important;
}

.bg-gray-500 {
  background-color: #6b7280 !important;
}

/* Memastikan teks tombol terlihat dengan jelas */
.text-white {
  color: #ffffff !important;
}
</style>