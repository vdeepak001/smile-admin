<x-app-layout>
    <x-slot name="title">
        Edit College Information
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit College Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('college-info.update', $collegeInfo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">College Information</h3>
                            
                            <div class="space-y-6">
                                <!-- College Name -->
                                <div>
                                    <label for="college_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        College Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="college_name" name="college_name"
                                        value="{{ old('college_name', $collegeInfo->college_name) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('college_name') border-red-500 @enderror"
                                        placeholder="Enter college name" required>
                                    @error('college_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- College Number -->
                                <div>
                                    <label for="college_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        College Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="college_number" name="college_number"
                                        value="{{ old('college_number', $collegeInfo->college_number) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('college_number') border-red-500 @enderror"
                                        placeholder="Enter college number (max 3 digits)" maxlength="3" pattern="[0-9]*" required>
                                    <p class="mt-1 text-sm text-gray-500">Enter a unique 3-digit number (e.g., 001, 002)</p>
                                    @error('college_number')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email ID -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $collegeInfo->user->email ?? '') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                        placeholder="Enter email address" required>
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Contact Person -->
                                <div>
                                    <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">
                                        Contact Person <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="contact_person" name="contact_person"
                                        value="{{ old('contact_person', $collegeInfo->contact_person) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_person') border-red-500 @enderror"
                                        placeholder="Enter contact person name" required>
                                    @error('contact_person')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                  <!-- Active Status -->
                                <div class="flex items-center pt-2">
                                    <input type="hidden" name="active_status" value="0">
                                    <input type="checkbox" id="active_status" name="active_status" value="1"
                                        @checked(old('active_status', $collegeInfo->active_status))
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                    <label for="active_status" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                                        Active Status
                                    </label>
                                </div>

                              
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Additional Details</h3>
                            
                            <div class="space-y-6">
                                <!-- Max Students -->
                                <div>
                                    <label for="max_students" class="block text-sm font-medium text-gray-700 mb-2">
                                        Maximum Students <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="max_students" name="max_students"
                                        value="{{ old('max_students', $collegeInfo->max_students) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_students') border-red-500 @enderror"
                                        placeholder="Enter maximum number of students" min="1" max="10000" required>
                                    @error('max_students')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Valid From -->
                                <div>
                                    <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-2">
                                        Valid From <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="valid_from" name="valid_from"
                                        value="{{ old('valid_from', $collegeInfo->valid_from->format('Y-m-d')) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('valid_from') border-red-500 @enderror"
                                        required>
                                    @error('valid_from')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Valid Until -->
                                <div>
                                    <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-2">
                                        Valid Until <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="valid_until" name="valid_until"
                                        value="{{ old('valid_until', $collegeInfo->valid_until->format('Y-m-d')) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('valid_until') border-red-500 @enderror"
                                        required>
                                    @error('valid_until')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Courses -->
                                <div>
                                    <label for="course_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                        Courses <span class="text-red-500">*</span>
                                    </label>
                                    <select id="course_ids" name="course_ids[]" multiple
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('course_ids') border-red-500 @enderror"
                                        required>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->course_id }}" @selected(in_array($course->course_id, old('course_ids', $collegeInfo->courses->pluck('course_id')->toArray())))>
                                                {{ $course->course_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple
                                        options.</p>
                                    @error('course_ids')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-200">
                        <a href="{{ route('college-info.index') }}"
                            class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Update College
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
