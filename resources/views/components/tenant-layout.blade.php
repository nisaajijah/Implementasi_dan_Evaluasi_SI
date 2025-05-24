@props(['title' => null])

<x-layouts.tenant :title="$title">
    @isset($header)
        <x-slot name="header">
            {{ $header }}
        </x-slot>
    @endisset

    {{ $slot }}
</x-layouts.tenant>