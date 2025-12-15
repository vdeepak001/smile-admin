<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Course Topic') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('course-topics.update', $courseTopic) }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course -->
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select id="course_id" name="course_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('course_id') border-red-500 @enderror"
                                required>
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->course_id }}" @selected(old('course_id', $courseTopic->course_id) == $course->course_id)>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Topic Name -->
                        <div>
                            <label for="topic_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="topic_name" name="topic_name"
                                value="{{ old('topic_name', $courseTopic->topic_name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('topic_name') border-red-500 @enderror"
                                placeholder="Enter topic name" required>
                            @error('topic_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                placeholder="Enter topic description">{{ old('description', $courseTopic->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attachments (Multiple) -->
                        <div>
                            <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">
                                Attachments (Multiple Files)
                            </label>
                            <input type="file" id="attachments" name="attachments[]" multiple
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('attachments') border-red-500 @enderror @error('attachments.*') border-red-500 @enderror">
                            @error('attachments')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('attachments.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Accepted: PDF, DOC, DOCX, PPT, PPTX, TXT, ZIP (Max: 10MB per file)</p>
                            
                            @if($courseTopic->attachment)
                                @php
                                    $attachments = json_decode($courseTopic->attachment, true);
                                @endphp
                                @if(is_array($attachments) && count($attachments) > 0)
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Current Attachments:</p>
                                        <div class="space-y-1">
                                            @foreach($attachments as $file)
                                                <a href="{{ \Storage::url($file['path']) }}" target="_blank" 
                                                   class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    {{ $file['original_name'] ?? basename($file['path']) }}
                                                </a>
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Note: Uploading new files will replace all existing attachments</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="hidden" name="active_status" value="0">
                        <input type="checkbox" id="active_status" name="active_status" value="1"
                            @checked(old('active_status', $courseTopic->active_status))
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                        <label for="active_status" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                            Active Status
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('course-topics.index') }}"
                            class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Update Topic
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
