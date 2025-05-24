{{-- Nama Menu --}}
<div class="mb-6">
    <label for="name" class="block text-sm font-semibold text-green-700 mb-2">Nama Menu <span class="text-red-500">*</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $menuItem->name ?? '') }}"
           class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('name') border-red-500 @enderror" required>
    @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
</div>

{{-- Deskripsi --}}
<div class="mb-6">
    <label for="description" class="block text-sm font-semibold text-green-700 mb-2">Deskripsi</label>
    <textarea name="description" id="description" rows="4"
              class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('description') border-red-500 @enderror">{{ old('description', $menuItem->description ?? '') }}</textarea>
    @error('description') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Harga --}}
    <div class="mb-6">
        <label for="price" class="block text-sm font-semibold text-green-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
        <input type="number" name="price" id="price" value="{{ old('price', $menuItem->price ?? '') }}" step="100" min="0"
               class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('price') border-red-500 @enderror" required>
        @error('price') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
    </div>

    {{-- Kategori --}}
    <div class="mb-6">
        <label for="category" class="block text-sm font-semibold text-green-700 mb-2">Kategori</label>
        <select name="category" id="category" class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('category') border-red-500 @enderror">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{ (old('category', $menuItem->category ?? '') == $category) ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
        </select>
        @error('category') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Stok --}}
    <div class="mb-6">
        <label for="stock" class="block text-sm font-semibold text-green-700 mb-2">Stok</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $menuItem->stock ?? '-1') }}" min="-1"
               class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('stock') border-red-500 @enderror">
        <p class="mt-2 text-xs text-green-600">Isi -1 untuk stok tak terbatas. Kosongkan jika tidak ingin mengubah atau default tak terbatas.</p>
        @error('stock') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
    </div>

    {{-- Status Tersedia --}}
    <div class="mb-6">
        <label for="is_available" class="flex items-center">
            <input type="hidden" name="is_available" value="0">
            <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $menuItem->is_available ?? true) ? 'checked' : '' }}
                   class="rounded border-green-200 text-green-600 shadow-sm focus:ring-2 focus:ring-green-400 transition duration-200 ease-in-out">
            <span class="ml-3 text-sm text-green-600">Tersedia untuk dipesan</span>
        </label>
        @error('is_available') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
    </div>
</div>

{{-- Gambar Menu --}}
<div class="mb-6">
    <label for="image" class="block text-sm font-semibold text-green-700 mb-2">Gambar Menu</label>
    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
           class="block w-full text-sm text-green-900 border border-green-200 rounded-lg cursor-pointer bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-200 ease-in-out @error('image') border-red-500 @enderror">
    <p class="mt-2 text-xs text-green-600" id="file_input_help">PNG, JPG, JPEG, WEBP (MAX. 2MB). {{ isset($menuItem) && $menuItem->image ? 'Kosongkan jika tidak ingin mengganti gambar.' : '' }}</p>
    @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror

    @if (isset($menuItem) && $menuItem->image)
        <div class="mt-4">
            <p class="text-sm font-semibold text-green-700">Gambar Saat Ini:</p>
            <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="mt-2 h-40 w-40 object-cover rounded-lg shadow-sm">
        </div>
    @endif
</div>