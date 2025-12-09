<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Student Management') }}
        </h2>
    </x-slot>

    <livewire:admin.student.index />
</x-app-layout>
