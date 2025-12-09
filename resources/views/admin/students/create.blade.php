<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Create Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- College Selection -->
                    <div>
                        <label for="college_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Select College') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="college_id" name="college_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('college_id') border-red-500 @enderror" required>
                            <option value="">Select College</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->college_id }}" {{ old('college_id') == $college->college_id ? 'selected' : '' }}>
                                    {{ $college->college_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('college_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Degree Selection -->
                    <div>
                        <label for="degree_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Select Degree') }}
                        </label>
                        <select id="degree_id" name="degree_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('degree_id') border-red-500 @enderror">
                            <option value="">Select Degree (Optional)</option>
                            @foreach($degrees as $degree)
                                <option value="{{ $degree->id }}" {{ old('degree_id') == $degree->id ? 'selected' : '' }}>
                                    {{ $degree->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('degree_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Specialization -->
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Specialization') }}
                        </label>
                        <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('specialization') border-red-500 @enderror" 
                               placeholder="e.g., Computer Science, Information Technology">
                        @error('specialization')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year of Study -->
                    <div>
                        <label for="year_of_study" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Year of Study') }}
                        </label>
                        <input type="number" id="year_of_study" name="year_of_study" value="{{ old('year_of_study') }}" 
                               min="1" max="10"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('year_of_study') border-red-500 @enderror" 
                               placeholder="e.g., 1, 2, 3">
                        @error('year_of_study')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">User Details</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('First Name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror" required />
                                    @error('first_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Last Name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror" required />
                                    @error('last_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Email') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" required />
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Phone Number') }}
                                    </label>
                                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number') border-red-500 @enderror" />
                                    @error('phone_number')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>


                            </div>
                        </div>

                        <!-- Student Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Student Details</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="enrollment_no" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Enrollment No') }}
                                    </label>
                                    <input type="text" id="enrollment_no" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed text-gray-500" value="Auto-generated" disabled readonly />
                                    <p class="mt-1 text-sm text-gray-500">will be automatically generated as ENRO_{College ID}_{User ID} (Preview based on next ID: {{ $nextUserId }})</p>
                                </div>



                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Date of Birth') }}
                                    </label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_of_birth') border-red-500 @enderror" />
                                    @error('date_of_birth')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="course_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Assign Courses') }}
                                    </label>
                                    <select 
                                        id="course_ids" 
                                        name="course_ids[]" 
                                        multiple 
                                        size="5"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('course_ids') border-red-500 @enderror"
                                    >
                                        @foreach($courses as $course)
                                            <option value="{{ $course->course_id }}" {{ in_array($course->course_id, old('course_ids', [])) ? 'selected' : '' }}>
                                                {{ $course->course_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple courses</p>
                                    @error('course_ids')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="flex items-center mt-6">
                                    <input type="hidden" name="active_status" value="0">
                                    <input type="checkbox" id="active_status" name="active_status" value="1" {{ old('active_status', 1) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                    <label for="active_status" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">Active Status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('students.index') }}" class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            {{ __('Create Student') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collegeSelect = document.getElementById('college_id');
            const enrollmentInput = document.getElementById('enrollment_no');
            const nextUserId = {{ $nextUserId }};

            function updateEnrollmentNo() {
                const collegeId = collegeSelect.value;
                if (collegeId) {
                    enrollmentInput.value = `ENRO_${collegeId}_${nextUserId}`;
                } else {
                    enrollmentInput.value = 'Auto-generated';
                }
            }

            collegeSelect.addEventListener('change', updateEnrollmentNo);
            updateEnrollmentNo();
        });
    </script>
</x-app-layout>
