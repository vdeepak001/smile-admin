<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Course Topics Management') }}
        </h2>
    </x-slot>

    @livewire('admin.course-topic.index')
</x-app-layout>
