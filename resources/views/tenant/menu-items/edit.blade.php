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
                    <form action="{{ route('tenant.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('tenant.menu-items._form', ['menuItem' => $menuItem]) {{-- Include partial form dengan data --}}
                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-green-100">
                            <a href="{{ route('tenant.menu-items.index') }}"
                               class="bg-gray-200 text-green-800 text-sm font-medium rounded-lg py-2 px-6 hover:bg-gray-300 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                                Batal
                            </a>
                            <button type="submit"
                                    class="ml-4 bg-green-600 text-white text-sm font-medium rounded-lg py-2 px-6 hover:bg-green-700 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                                Update Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-tenant-layout>