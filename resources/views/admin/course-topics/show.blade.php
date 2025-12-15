<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $courseTopic->topic_name }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('course-topics.edit', $courseTopic) }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('course-topics.index') }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Basic Information Card -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Topic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Topic Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $courseTopic->topic_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $courseTopic->course->course_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p class="mt-1">
                            @if ($courseTopic->active_status)
                                <span
                                    class="inline-flex px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Questions Count</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $courseTopic->questions->count() }}</p>
                    </div>
                    @if ($courseTopic->description)
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-600">Description</p>
                            <p class="text-lg text-gray-900 mt-1">{{ $courseTopic->description }}</p>
                        </div>
                    @endif
                    @if ($courseTopic->attachment)
                        @php
                            $attachments = json_decode($courseTopic->attachment, true);
                        @endphp
                        @if(is_array($attachments) && count($attachments) > 0)
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-600 mb-2">Attachments</p>
                                <div class="space-y-2">
                                    @foreach($attachments as $file)
                                        <a href="{{ \Storage::url($file['path']) }}" target="_blank"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mr-2 mb-2">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ $file['original_name'] ?? basename($file['path']) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Audit Information -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Audit Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $courseTopic->insertedBy?->name ?? 'System' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $courseTopic->inserted_on ? $courseTopic->inserted_on->format('M d, Y H:i A') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $courseTopic->updatedBy?->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $courseTopic->updated_on ? $courseTopic->updated_on->format('M d, Y H:i A') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
