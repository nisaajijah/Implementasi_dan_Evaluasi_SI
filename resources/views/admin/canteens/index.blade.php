<x-admin-layout :title="$title">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-green-800 leading-tight">
                {{ $title }}
            </h2>
            <a href="{{ route('admin.canteens.create') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200">
                Tambah Kantin
            </a>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-100">
                        <thead class="bg-green-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Gambar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Lokasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Jam Operasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            @forelse ($canteens as $canteen)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-800">{{ $loop->iteration + $canteens->firstItem() - 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-800">
                                    @if ($canteen->image)
                                        <img src="{{ asset('storage/' . $canteen->image) }}" alt="{{ $canteen->name }}" class="h-16 w-16 object-cover rounded-lg shadow-sm">
                                    @else
                                        <span class="text-green-500 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-800">{{ $canteen->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ Str::limit($canteen->location_description, 50) ?: '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $canteen->operating_hours ?: '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.canteens.edit', $canteen) }}" class="text-green-600 hover:text-green-800 mr-3 transition-colors duration-150">Edit</a>
                                    <form action="{{ route('admin.canteens.destroy', $canteen) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kantin ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-150">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-green-500">
                                    Belum ada data kantin.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                {{ $canteens->links() }} {{-- Tampilkan link paginasi --}}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
