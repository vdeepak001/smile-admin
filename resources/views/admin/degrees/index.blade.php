<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Degree Management') }}
        </h2>
    </x-slot>

    <livewire:admin.degree.index />
</x-app-layout>
