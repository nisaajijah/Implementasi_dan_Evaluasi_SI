<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 max-w-xl mx-auto">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                {{-- Nama --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="mt-1 block w-full input-field @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="mt-1 block w-full input-field @error('email') border-red-500 @enderror" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full input-field @error('password') border-red-500 @enderror" required>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full input-field" required>
                </div>

                {{-- Role --}}
                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role Pengguna <span class="text-red-500">*</span></label>
                    <select name="role" id="role" class="mt-1 block w-full input-field @error('role') border-red-500 @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-gray-500">Jika memilih 'Tenant', Anda perlu membuat profil tenant terpisah melalui menu Manajemen Tenant.</p>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin.users.index') }}" class="secondary-button mr-2">
                        Batal
                    </a>
                    <button type="submit" class="primary-button">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>