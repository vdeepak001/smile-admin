<div>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Create Batch</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-blue-600">
                    <h3 class="text-lg font-semibold text-white">Create New Batch</h3>
                    <p class="text-sm text-purple-100">Add a new batch for {{ $college->college_name }}</p>
                </div>

                <form wire:submit.prevent="save" class="p-6 space-y-6">
                    <!-- Year Selection -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                            Batch Year <span class="text-red-500">*</span>
                        </label>
                        <select id="year" wire:model.live="year"
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 5;
                                $endYear = $currentYear + 5;
                            @endphp
                            @for($y = $endYear; $y >= $startYear; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Select the year for this batch</p>
                        @error('year') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Batch ID (Auto-generated, Read-only) -->
                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Batch ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="batch_id" wire:model="batch_id" readonly
                            class="block w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500">Auto-generated based on college name initials and selected year (e.g., VU-2026-001)</p>
                        @error('batch_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Courses (Multi-select) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Courses <span class="text-red-500">*</span>
                        </label>
                        <div class="border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto bg-gray-50">
                            @if($availableCourses->count() > 0)
                                <div class="space-y-2">
                                    @foreach($availableCourses as $course)
                                        <label class="flex items-center p-2 hover:bg-white rounded cursor-pointer transition-colors">
                                            <input type="checkbox" wire:model="selectedCourses" value="{{ $course->course_id }}"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="ml-3 text-sm text-gray-700">{{ $course->course_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">No courses assigned to this college yet.</p>
                            @endif
                        </div>
                        @error('selectedCourses') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="start_date" wire:model="start_date"
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('start_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="end_date" wire:model="end_date"
                                class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Batch Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Batch Type <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                {{ $batch_type == 1 ? 'border-purple-600 bg-purple-50' : 'border-gray-300 hover:border-purple-300' }}">
                                <input type="radio" wire:model="batch_type" value="1" class="sr-only">
                                <div class="text-center">
                                    <div class="text-lg font-semibold {{ $batch_type == 1 ? 'text-purple-600' : 'text-gray-700' }}">Type 1</div>
                                </div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                {{ $batch_type == 2 ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300 hover:border-indigo-300' }}">
                                <input type="radio" wire:model="batch_type" value="2" class="sr-only">
                                <div class="text-center">
                                    <div class="text-lg font-semibold {{ $batch_type == 2 ? 'text-indigo-600' : 'text-gray-700' }}">Type 2</div>
                                </div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                {{ $batch_type == 3 ? 'border-pink-600 bg-pink-50' : 'border-gray-300 hover:border-pink-300' }}">
                                <input type="radio" wire:model="batch_type" value="3" class="sr-only">
                                <div class="text-center">
                                    <div class="text-lg font-semibold {{ $batch_type == 3 ? 'text-pink-600' : 'text-gray-700' }}">Type 3</div>
                                </div>
                            </label>
                        </div>
                        @error('batch_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('college-batches.index', $collegeId) }}"
                            class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            Create Batch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
