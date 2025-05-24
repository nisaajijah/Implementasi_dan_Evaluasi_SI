<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 max-w-xl mx-auto">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- Nama --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full input-field @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full input-field @error('email') border-red-500 @enderror" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role Pengguna <span class="text-red-500">*</span></label>
                    <select name="role" id="role" class="mt-1 block w-full input-field @error('role') border-red-500 @enderror" required {{ $user->id === auth()->id() && User::where('role', 'admin')->count() <= 1 ? 'disabled' : '' }}>
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($user->id === auth()->id() && User::where('role', 'admin')->count() <= 1)
                        <p class="text-orange-500 text-xs mt-1">Role admin terakhir tidak dapat diubah.</p>
                        <input type="hidden" name="role" value="{{ $user->role }}"> {{-- Kirim role saat ini jika disabled --}}
                    @endif
                    @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password (Opsional) --}}
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full input-field @error('password') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi Password (Opsional) --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full input-field">
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin.users.index') }}" class="secondary-button mr-2">
                        Batal
                    </a>
                    <button type="submit" class="primary-button">
                        Update Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
