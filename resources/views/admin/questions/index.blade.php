<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Questions Management') }}
        </h2>
    </x-slot>

    @livewire('admin.question.index')
</x-app-layout>
