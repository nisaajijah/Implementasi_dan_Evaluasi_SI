<nav x-data="{ open: false }" class="bg-white border-b border-green-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="block h-9 w-auto">
                    </a>
                </div>


                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                        class="text-gray-700 hover:text-green-600 hover:border-green-500">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('customer.canteens.index')" :active="request()->routeIs('customer.canteens.*') || request()->routeIs('customer.tenants.*')"
                        class="text-gray-700 hover:text-green-600 hover:border-green-500">
                        {{ __('Lihat Menu Kantin') }}
                    </x-nav-link>

                    @auth
                        @if (Auth::user()->role === 'customer' || Auth::user()->role === null)
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="text-gray-700 hover:text-green-600 hover:border-green-500">
                                {{ __('Dashboard Saya') }}
                            </x-nav-link>
                            <x-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')"
                                class="text-gray-700 hover:text-green-600 hover:border-green-500">
                                {{ __('Pesanan Saya') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Navigation (Login/Register or User Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    {{-- Cart Link for customer --}}
                    @if (Auth::user()->role === 'customer' || Auth::user()->role === null)
                        <a href="{{ route('cart.index') }}"
                            class="mr-4 inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('cart.index') ? 'border-green-500 text-gray-800' : 'border-transparent text-gray-600 hover:text-green-600 hover:border-green-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @if (class_exists('Cart') && Cart::instance('default')->count() > 0)
                                <span
                                    class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-green-600 rounded-full">
                                    {{ Cart::instance('default')->count() }}
                                </span>
                            @endif
                            <span class="ml-1 hidden lg:inline-block">Keranjang</span>
                        </a>
                    @endif

                    <!-- Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-green-600 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-green-50 hover:text-green-600">
                                {{ __('Profil Akun') }}
                            </x-dropdown-link>
                            {{-- Logika redirect berdasarkan role jika ada halaman profil khusus --}}
                            @if (Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')" class="hover:bg-green-50 hover:text-green-600">Pindah ke
                                    Panel Admin</x-dropdown-link>
                            @elseif(Auth::user()->role === 'tenant' && Auth::user()->tenantProfile()->exists())
                                <x-dropdown-link :href="route('tenant.dashboard')" class="hover:bg-green-50 hover:text-green-600">Pindah ke
                                    Panel Tenant</x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="hover:bg-green-50 hover:text-green-600">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-600 transition duration-150 ease-in-out">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm font-medium px-4 py-2 rounded-md bg-green-500 text-white hover:bg-green-600 transition duration-150 ease-in-out">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:bg-green-50 focus:text-green-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')"
                class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('customer.canteens.index')" :active="request()->routeIs('customer.canteens.*') || request()->routeIs('customer.tenants.*')"
                class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                {{ __('Lihat Menu Kantin') }}
            </x-responsive-nav-link>

            @auth
                @if (Auth::user()->role === 'customer' || Auth::user()->role === null)
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                        {{ __('Dashboard Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                        Keranjang @if (class_exists('Cart') && Cart::instance('default')->count() > 0)
                            <span
                                class="ml-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-green-600 rounded-full">
                                {{ Cart::instance('default')->count() }}
                            </span>
                        @endif
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('customer.orders.index')" :active="request()->routeIs('customer.orders.*')"
                        class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                        {{ __('Pesanan Saya') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                        {{ __('Profil Akun') }}
                    </x-responsive-nav-link>

                    {{-- Logika redirect berdasarkan role jika ada halaman profil khusus --}}
                    @if (Auth::user()->role === 'admin')
                        <x-responsive-nav-link :href="route('admin.dashboard')"
                            class="text-gray-700 hover:text-green-600 hover:bg-green-50">Pindah ke Panel
                            Admin</x-responsive-nav-link>
                    @elseif(Auth::user()->role === 'tenant' && Auth::user()->tenantProfile()->exists())
                        <x-responsive-nav-link :href="route('tenant.dashboard')"
                            class="text-gray-700 hover:text-green-600 hover:bg-green-50">Pindah ke Panel
                            Tenant</x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="py-3 border-t border-gray-200">
                <x-responsive-nav-link :href="route('login')" class="text-gray-700 hover:text-green-600 hover:bg-green-50">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')"
                        class="mt-2 block text-center mx-4 py-2 rounded-md bg-green-500 text-white hover:bg-green-600">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>
