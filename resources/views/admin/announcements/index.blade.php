<x-admin-layout :title="$title">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-green-800 leading-tight">
                {{ $title }}
            </h2>
            <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200">
                Buat Pengumuman
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Judul</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Author</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Tgl Publish</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            @forelse ($announcements as $announcement)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-800">{{ Str::limit($announcement->title, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $announcement->author->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($announcement->is_active && (!$announcement->published_at || $announcement->published_at->isPast()))
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif/Published</span>
                                    @elseif ($announcement->is_active && $announcement->published_at && $announcement->published_at->isFuture())
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Dijadwalkan</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Draft/Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                    {{ $announcement->published_at ? $announcement->published_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-green-600 hover:text-green-800 mr-3 transition-colors duration-150">Edit</a>
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-150">Hapus</button>
                                    </form>
                                    <a href="{{ route('admin.announcements.show', $announcement) }}" class="text-green-600 hover:text-green-800 ml-3 transition-colors duration-150">Lihat</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-green-500">
                                    Belum ada data pengumuman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $announcements->links('') }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>