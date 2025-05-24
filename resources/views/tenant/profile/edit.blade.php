<x-tenant-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-green-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="bg-gray-50 min-h-screen p-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('tenant.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Nama Kios/Tenant --}}
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-semibold text-green-700 mb-2">Nama Kios/Tenant <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}"
                                   class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('name') border-red-500 @enderror" required>
                            @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Deskripsi Tenant --}}
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-semibold text-green-700 mb-2">Deskripsi Tenant</label>
                            <textarea name="description" id="description" rows="4"
                                      class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('description') border-red-500 @enderror">{{ old('description', $tenant->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Logo Tenant --}}
                        <div class="mb-6">
                            <label for="logo" class="block text-sm font-semibold text-green-700 mb-2">Logo Tenant (Opsional: Ganti)</label>
                            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="block w-full text-sm text-green-900 border border-green-200 rounded-lg cursor-pointer bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-200 ease-in-out @error('logo') border-red-500 @enderror">
                            <p class="mt-2 text-xs text-green-600">PNG, JPG, JPEG, WEBP (MAX. 1MB). Kosongkan jika tidak ingin mengganti logo.</p>
                            @error('logo') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror

                            @if ($tenant->logo)
                                <div class="mt-4">
                                    <p class="text-sm font-semibold text-green-700">Logo Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $tenant->logo) }}" alt="{{ $tenant->name }}" class="mt-2 h-40 w-40 object-cover rounded-lg shadow-sm">
                                </div>
                            @endif
                        </div>

                        {{-- Status Buka/Tutup --}}
                        <div class="mb-6">
                            <label for="is_open" class="flex items-center">
                                <input type="hidden" name="is_open" value="0">
                                <input type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', $tenant->is_open) ? 'checked' : '' }}
                                       class="rounded border-green-200 text-green-600 shadow-sm focus:ring-2 focus:ring-green-400 transition duration-200 ease-in-out">
                                <span class="ml-3 text-sm text-green-600">Toko Sedang Buka</span>
                            </label>
                            @error('is_open') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        {{-- Optional Operating Hours (Commented Out) --}}
                        {{-- 
                        <div class="mb-6">
                            <label for="operating_hours" class="block text-sm font-semibold text-green-700 mb-2">Jam Operasional</label>
                            <input type="text" name="operating_hours" id="operating_hours" value="{{ old('operating_hours', $tenant->operating_hours ?? '') }}"
                                   class="block w-full border border-green-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm py-2 px-4 transition duration-200 ease-in-out @error('operating_hours') border-red-500 @enderror" placeholder="Contoh: 08:00 - 17:00 Senin-Jumat">
                            @error('operating_hours') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                        --}}

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-green-100">
                            <button type="submit"
                                    class="bg-green-600 text-white text-sm font-medium rounded-lg py-2 px-6 hover:bg-green-700 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                                Simpan Perubahan Profil Toko
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>
