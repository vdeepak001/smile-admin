<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Course Topic') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Topic Picture -->
                        <div>
                            <label for="topic_pic" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic Picture
                            </label>
                            @if($courseTopic->topic_pic)
                                <div class="mb-2">
                                    <img src="{{ \Storage::url($courseTopic->topic_pic) }}" alt="Topic Picture" class="w-32 h-32 object-cover rounded">
                                    <p class="text-xs text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" id="topic_pic" name="topic_pic" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('topic_pic') border-red-500 @enderror">
                            @error('topic_pic')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attachment -->
                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                                Attachment
                            </label>
                            @if($courseTopic->attachment)
                                <div class="mb-2">
                                    <a href="{{ \Storage::url($courseTopic->attachment) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        📎 Current attachment
                                    </a>
                                </div>
                            @endif
                            <input type="file" id="attachment" name="attachment"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('attachment') border-red-500 @enderror">
                            @error('attachment')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
