<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Assign Topics') }}
        </h2>
    </x-slot>

    @livewire('admin.college-batch.manage-course-topics', ['collegeId' => $collegeId, 'batchId' => $batchId, 'courseId' => $courseId])
</x-app-layout>
