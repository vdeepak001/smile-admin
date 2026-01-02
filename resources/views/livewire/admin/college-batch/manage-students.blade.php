<div>
    <div class="py-12">
        <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('college-info.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                Colleges
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('college-batches.index', $collegeId) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                    {{ $college->college_name }} - Batches
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Manage Students</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Batch Information Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-blue-600">
                    <h3 class="text-lg font-semibold text-white">Manage Students for Batch: {{ $batch->batch_id }}</h3>
                    <p class="text-sm text-purple-100">Assign students with start year {{ $batchYear }} to this batch</p>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Batch Year:</span>
                            <span class="ml-2 text-gray-900">{{ $batchYear }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Start Date:</span>
                            <span class="ml-2 text-gray-900">{{ $batch->start_date->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">End Date:</span>
                            <span class="ml-2 text-gray-900">{{ $batch->end_date->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Selection Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h4 class="text-md font-semibold text-gray-800">Available Students (Start Year: {{ $batchYear }})</h4>
                        <p class="text-sm text-gray-600">{{ $availableStudents->count() }} students found</p>
                    </div>
                    @if($availableStudents->count() > 0)
                        <button wire:click="toggleSelectAll" type="button"
                            class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            @if(count($selectedStudents) === $availableStudents->count())
                                Deselect All
                            @else
                                Select All
                            @endif
                        </button>
                    @endif
                </div>

                <form wire:submit.prevent="save" class="p-6">
                    @if($availableStudents->count() > 0)
                        <div class="space-y-2 max-h-96 overflow-y-auto mb-6">
                            @foreach($availableStudents as $student)
                                <label class="flex items-center p-4 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors border border-gray-200">
                                    <input type="checkbox" wire:model="selectedStudents" value="{{ $student->student_id }}"
                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ $student->user->first_name }} {{ $student->user->last_name }}
                                                </p>
                                                <p class="text-xs text-gray-600">
                                                    Enrollment: {{ $student->enrollment_no }}
                                                    @if($student->degree)
                                                        | {{ $student->degree->degree_name }}
                                                    @endif
                                                    @if($student->specialization)
                                                        - {{ $student->specialization }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500">Year {{ $student->year_of_study }}</p>
                                                @if($student->user->email)
                                                    <p class="text-xs text-gray-500">{{ $student->user->email }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Selected Count -->
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <span class="font-semibold">{{ count($selectedStudents) }}</span> student(s) selected
                            </p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('college-batches.index', $collegeId) }}"
                                class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                Save Assignments
                            </button>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No students found</h3>
                            <p class="mt-1 text-sm text-gray-500">No students with start year {{ $batchYear }} are available.</p>
                            <div class="mt-6">
                                <a href="{{ route('college-batches.index', $collegeId) }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Back to Batches
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
