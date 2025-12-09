<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('courses.store') }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Course Name -->
                    <div>
                        <label for="course_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="course_name" name="course_name"
                            value="{{ old('course_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('course_name') border-red-500 @enderror"
                            placeholder="Enter course name" required>
                        @error('course_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Enter course description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Course Picture -->
                    <div>
                        <label for="course_pic" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Picture
                        </label>
                        <input type="file" id="course_pic" name="course_pic" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('course_pic') border-red-500 @enderror">
                        @error('course_pic')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB).</p>
                    </div>



                    <!-- Test Questions -->
                    <div>
                        <label for="test_questions" class="block text-sm font-medium text-gray-700 mb-2">
                            Test Questions <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="test_questions" name="test_questions"
                            value="{{ old('test_questions') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('test_questions') border-red-500 @enderror"
                            placeholder="Enter number of test questions" min="0" max="1000" required>
                        @error('test_questions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Percent Required -->
                    <div>
                        <label for="percent_require" class="block text-sm font-medium text-gray-700 mb-2">
                            Percent Required <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="percent_require" name="percent_require"
                            value="{{ old('percent_require') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('percent_require') border-red-500 @enderror"
                            placeholder="Enter percent required (0-100)" min="0" max="100" required>
                        @error('percent_require')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="hidden" name="active_status" value="0">
                        <input type="checkbox" id="active_status" name="active_status" value="1"
                            @checked(old('active_status', true))
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                        <label for="active_status" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                            Active Status
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('courses.index') }}"
                            class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
