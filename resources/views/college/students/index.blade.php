<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('College Students') }}
        </h2>
    </x-slot>

    <livewire:college.student.index />
</x-app-layout>
