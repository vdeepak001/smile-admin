<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('College Information') }}
        </h2>
    </x-slot>

    <livewire:admin.college-info.index />
</x-app-layout>
