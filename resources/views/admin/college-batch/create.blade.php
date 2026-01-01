<x-app-layout>
    <x-slot name="title">
        Create Batch
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create New Batch') }}
        </h2>
    </x-slot>

    <livewire:admin.college-batch.create :collegeId="$collegeId" />
</x-app-layout>
