<x-admin-layout :title="$title">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-green-800 leading-tight">
                {{ $title }}
            </h2>
            <a href="{{ route('admin.tenants.create') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200">
                Tambah Tenant
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Logo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Nama Tenant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Pemilik (User)</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Kantin</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            @forelse ($tenants as $tenant)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-800">
                                    @if ($tenant->logo)
                                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="{{ $tenant->name }}" class="h-10 w-10 object-cover rounded-full shadow-sm">
                                    @else
                                        <span class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-xs text-green-600 font-medium">No Logo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-800">{{ $tenant->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $tenant->user->name ?? 'N/A' }} ({{ $tenant->user->email ?? 'N/A' }})</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $tenant->canteen->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($tenant->is_open)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Buka</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tutup</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.tenants.edit', $tenant) }}" class="text-green-600 hover:text-green-800 mr-3 transition-colors duration-150">Edit</a>
                                    <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tenant ini beserta akun user terkait? Menu item tenant ini juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-150">Hapus</button>
                                    </form>
                                    <a href="{{ route('admin.tenants.show', $tenant) }}" class="text-green-600 hover:text-green-800 ml-3 transition-colors duration-150">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-green-500">
                                    Belum ada data tenant.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                {{ $tenants->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>