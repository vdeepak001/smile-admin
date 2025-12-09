<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Courses Management') }}
        </h2>
    </x-slot>

    <livewire:admin.course.index />
</x-app-layout>
