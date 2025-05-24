@props(['title' => null]) <!-- Mendefinisikan prop title, bisa null -->

<x-layouts.admin :title="$title">
    @isset($header)
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endisset

    {{ $slot }}
</x-layouts.admin>