<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Batch Students') }}
        </h2>
    </x-slot>

    @livewire('admin.college-batch.manage-students', ['collegeId' => $collegeId, 'batchId' => $batchId])
</x-app-layout>
