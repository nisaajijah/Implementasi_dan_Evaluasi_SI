<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.canteens.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Nama Kantin --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kantin <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                           required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi Lokasi --}}
                <div class="mb-4">
                    <label for="location_description" class="block text-sm font-medium text-gray-700">Deskripsi Lokasi</label>
                    <textarea name="location_description" id="location_description" rows="3"
                              class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('location_description') border-red-500 @enderror">{{ old('location_description') }}</textarea>
                    @error('location_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Jam Operasi --}}
                <div class="mb-4">
                    <label for="operating_hours" class="block text-sm font-medium text-gray-700">Jam Operasi</label>
                    <input type="text" name="operating_hours" id="operating_hours" value="{{ old('operating_hours') }}" placeholder="Contoh: 08:00 - 17:00 Senin-Jumat"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('operating_hours') border-red-500 @enderror">
                    @error('operating_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Gambar Kantin --}}
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Kantin</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('image') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500" id="file_input_help">PNG, JPG, JPEG, WEBP (MAX. 2MB).</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin.canteens.index') }}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>