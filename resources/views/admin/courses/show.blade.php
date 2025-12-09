<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $course->course_name }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('courses.edit', $course) }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('courses.index') }}"
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
            <!-- Course Picture -->
            @if ($course->course_pic)
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <img src="{{ \Storage::url($course->course_pic) }}" alt="{{ $course->course_name }}"
                        class="w-full max-w-md mx-auto h-64 object-cover rounded-lg">
                </div>
            @endif

            <!-- Basic Information Card -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $course->course_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p class="mt-1">
                            @if ($course->active_status)
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
                    @if ($course->description)
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-600">Description</p>
                            <p class="text-lg text-gray-900 mt-1">{{ $course->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Details -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-sm font-medium text-gray-600">Test Questions</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $course->test_questions }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Percent Required</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $course->percent_require }}%</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Topics Count</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $course->topics->count() }}</p>
                    </div>
                </div>
            </div>



            <!-- Audit Information -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Audit Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $course->insertedBy?->name ?? 'System' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $course->inserted_on ? $course->inserted_on->format('M d, Y H:i A') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $course->updatedBy?->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $course->updated_on ? $course->updated_on->format('M d, Y H:i A') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
          
        </div>
    </div>
</x-app-layout>
