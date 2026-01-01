<x-app-layout>
    <x-slot name="title">
        Edit Batch
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Batch') }}
        </h2>
    </x-slot>

    <livewire:admin.college-batch.edit :collegeId="$collegeId" :batchId="$batchId" />
</x-app-layout>
