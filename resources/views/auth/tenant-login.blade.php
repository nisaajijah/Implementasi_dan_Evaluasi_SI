{{-- resources/views/auth/tenant-login.blade.php --}}
<x-guest-layout>
    <div class="mb-4 text-center">
        {{-- Logo Aplikasi Anda atau Judul Admin Panel --}}
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 fill-current text-gray-500 mx-auto">
        </a>
        <h2 class="mt-6 text-2xl font-bold text-gray-700 dark:text-gray-200">
            Tenant Panel Login
        </h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('tenant.login.store') }}"> {{-- Pastikan action benar --}}
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- Tenant mungkin tidak perlu "Forgot Password" --}}
            <x-primary-button class="ml-3">
                {{ __('Log in as Tenant') }}
            </x-primary-button>
        </div>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Login sebagai User Biasa</a>
        <span class="mx-2 text-sm text-gray-400">|</span>
        <a href="{{ route('admin.login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Login sebagai Admin</a>
    </div>
</x-guest-layout>