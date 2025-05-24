<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Tenant Panel {{ $title ?? '' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Tenant Navigation Menu -->
        <nav x-data="{ open: false }" class="bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-12 gap-4 items-center h-16">
                    <!-- Logo Section -->
                    <div class="col-span-3 flex items-center">
                        <a href="{{ route('tenant.dashboard') }}" class="flex items-center space-x-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="block h-9 w-auto">
                            <span class="font-semibold text-lg text-gray-800">
                                {{ Auth::user()->tenantProfile->name ?? Auth::user()->name }}
                            </span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="col-span-6 hidden md:flex items-center justify-center space-x-6">
                        <x-nav-link :href="route('tenant.dashboard')" :active="request()->routeIs('tenant.dashboard')"
                            class="text-gray-600 hover:text-green-600 transition duration-150">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tenant.menu-items.index')" :active="request()->routeIs('tenant.menu-items.*')"
                            class="text-gray-600 hover:text-green-600 transition duration-150">
                            {{ __('Menu Saya') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tenant.orders.index')" :active="request()->routeIs('tenant.orders.*')"
                            class="text-gray-600 hover:text-green-600 transition duration-150">
                            {{ __('Pesanan Masuk') }}
                        </x-nav-link>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="col-span-3 hidden md:flex items-center justify-end">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-green-600 rounded-md transition duration-150">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('tenant.profile.edit')" class="hover:bg-green-50 hover:text-green-600">
                                    {{ __('Pengaturan Toko') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('tenant.logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('tenant.logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="hover:bg-green-50 hover:text-green-600">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Hamburger for Mobile -->
                    <div class="col-span-9 md:hidden flex justify-end items-center">
                        <button @click="open = !open" class="p-2 text-gray-600 hover:text-green-600 rounded-md">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="md:hidden bg-white border-t border-gray-200">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('tenant.dashboard')" :active="request()->routeIs('tenant.dashboard')"
                        class="block py-2 text-gray-600 hover:text-green-600">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tenant.menu-items.index')" :active="request()->routeIs('tenant.menu-items.*')"
                        class="block py-2 text-gray-600 hover:text-green-600">
                        {{ __('Menu Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tenant.orders.index')" :active="request()->routeIs('tenant.orders.*')"
                        class="block py-2 text-gray-600 hover:text-green-600">
                        {{ __('Pesanan Masuk') }}
                    </x-responsive-nav-link>
                    <div class="pt-4 border-t border-gray-200">
                        <div class="px-4 py-2">
                            <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <x-responsive-nav-link :href="route('tenant.profile.edit')" class="block py-2 text-gray-600 hover:text-green-600">
                            {{ __('Pengaturan Toko') }}
                        </x-responsive-nav-link>
                        <form method="POST" action="{{ route('tenant.logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('tenant.logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block py-2 text-gray-600 hover:text-green-600">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header -->
        @if (isset($header))
            <header class="bg-white shadow-sm">
                <div class="container mx-auto py-6 px-4">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main>
            <div class="py-12">
                <div class="container mx-auto px-4">
                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-md">
                            <div class="font-bold">Oops! Ada beberapa kesalahan:</div>
                            <ul class="list-disc list-inside mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
