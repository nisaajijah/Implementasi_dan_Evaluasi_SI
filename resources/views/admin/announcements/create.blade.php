<x-admin-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                {{-- Judul --}}
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Pengumuman <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="mt-1 block w-full input-field @error('title') border-red-500 @enderror" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konten --}}
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Isi Pengumuman <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="10"
                              class="mt-1 block w-full input-field @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Anda bisa menggunakan Markdown sederhana untuk formatting.</p>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    {{-- Untuk Rich Text Editor (CKEditor/Trix), perlu setup tambahan --}}
                </div>

                {{-- Tanggal Publikasi --}}
                <div class="mb-4">
                    <label for="published_at" class="block text-sm font-medium text-gray-700">Tanggal Publikasi (Opsional)</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                           class="mt-1 block w-full input-field @error('published_at') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika ingin dipublish segera saat diaktifkan, atau simpan sebagai draft.</p>
                    @error('published_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="mb-6">
                    <label for="is_active" class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Aktifkan Pengumuman</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">Jika dicentang, pengumuman akan terlihat oleh publik (sesuai tanggal publikasi jika diisi).</p>
                    @error('is_active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin.announcements.index') }}" class="secondary-button mr-2">
                        Batal
                    </a>
                    <button type="submit" class="primary-button">
                        Simpan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>