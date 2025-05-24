<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kolom Kiri: Info Akun User Tenant --}}
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Informasi Akun Login Tenant</h3>
                        {{-- Nama User --}}
                        <div class="mb-4">
                            <label for="user_name" class="block text-sm font-medium text-gray-700">Nama Pemilik Tenant <span class="text-red-500">*</span></label>
                            <input type="text" name="user_name" id="user_name" value="{{ old('user_name') }}"
                                   class="mt-1 block w-full input-field @error('user_name') border-red-500 @enderror" required>
                            @error('user_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Email User --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Login Tenant <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   class="mt-1 block w-full input-field @error('email') border-red-500 @enderror" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Password User --}}
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password"
                                   class="mt-1 block w-full input-field @error('password') border-red-500 @enderror" required>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Konfirmasi Password User --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="mt-1 block w-full input-field" required>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Info Detail Tenant --}}
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Informasi Detail Tenant</h3>
                        {{-- Nama Tenant --}}
                        <div class="mb-4">
                            <label for="tenant_name" class="block text-sm font-medium text-gray-700">Nama Kios/Tenant <span class="text-red-500">*</span></label>
                            <input type="text" name="tenant_name" id="tenant_name" value="{{ old('tenant_name') }}"
                                   class="mt-1 block w-full input-field @error('tenant_name') border-red-500 @enderror" required>
                            @error('tenant_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Kantin --}}
                        <div class="mb-4">
                            <label for="canteen_id" class="block text-sm font-medium text-gray-700">Pilih Kantin <span class="text-red-500">*</span></label>
                            <select name="canteen_id" id="canteen_id" class="mt-1 block w-full input-field @error('canteen_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Kantin --</option>
                                @foreach ($canteens as $id => $name)
                                    <option value="{{ $id }}" {{ old('canteen_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('canteen_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Deskripsi Tenant --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Tenant</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full input-field @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Logo Tenant --}}
                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo Tenant</label>
                            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('logo') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG, WEBP (MAX. 1MB).</p>
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        {{-- Status Buka/Tutup --}}
                        <div class="mb-4">
                            <label for="is_open" class="flex items-center">
                                <input type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Tenant Sedang Buka</span>
                            </label>
                            @error('is_open') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.tenants.index') }}" class="secondary-button mr-2">
                        Batal
                    </a>
                    <button type="submit" class="primary-button">
                        Simpan Tenant
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- Helper class untuk input field (tambahkan di resources/css/app.css jika belum ada styling yang mirip) --}}
    <style>
        .input-field {
            py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm;
        }
        .primary-button {
            px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500;
        }
        .secondary-button {
            px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
        }
    </style>
</x-admin-layout>