<x-app-layout>
    <x-slot name="title">
        {{ $collegeInfo->college_name }}
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $collegeInfo->college_name }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('college-info.edit', $collegeInfo) }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('college-info.index') }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">College Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->college_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">College Code</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->college_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Email Address</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Contact Person</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->contact_person }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">College Package</p>
                        <p class="text-lg font-semibold text-gray-900">
                            @if($collegeInfo->college_package)
                                Package {{ $collegeInfo->college_package }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p class="mt-1">
                            @if ($collegeInfo->active_status)
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
                </div>
            </div>

            <!-- Course & Capacity Information -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Course & Capacity</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Assigned Courses</p>
                        <p class="text-lg font-semibold text-gray-900">
                            @if($collegeInfo->courses->isNotEmpty())
                                {{ $collegeInfo->courses->pluck('course_name')->join(', ') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Maximum Students</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->max_students }}</p>
                    </div>
                </div>
            </div>

            <!-- Validity Period -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Validity Period</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Valid From</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->valid_from->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Valid Until</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $collegeInfo->valid_until->format('M d, Y') }}
                        </p>
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
                            {{ $collegeInfo->createdBy?->name ?? 'System' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $collegeInfo->created_at->format('M d, Y H:i A') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $collegeInfo->updatedBy?->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $collegeInfo->updated_at->format('M d, Y H:i A') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
          
        </div>
    </div>
</x-app-layout>
