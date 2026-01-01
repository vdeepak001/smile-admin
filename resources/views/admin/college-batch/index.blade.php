<x-app-layout>
    <x-slot name="title">
        Batches - {{ $collegeId }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('College Batches') }}
        </h2>
    </x-slot>

    <livewire:admin.college-batch.index :collegeId="$collegeId" />
</x-app-layout>
