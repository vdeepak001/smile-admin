<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Bulk Import Students') }}
            </h2>
            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    @if(session('success_count'))
                        <p class="mt-2">Total students imported: <strong>{{ session('success_count') }}</strong></p>
                    @endif
                </div>
            @endif

            @if(session('errors_list') && count(session('errors_list')) > 0)
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Validation Errors:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach(session('errors_list') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Instructions and CSV Template Download -->
                    <div class="mb-6 flex items-center justify-between bg-blue-50 border-l-4 border-blue-500 p-4">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-700 mb-2">Instructions</h3>
                            <ul class="list-disc list-inside text-sm text-blue-600 space-y-1">
                                <li>Upload a CSV file containing student data</li>
                                <li>Passwords will be auto-generated and sent via email</li>
                            </ul>
                        </div>
                        <div>
                            <a href="data:text/csv;charset=utf-8,first_name,last_name,email,phone_number,degree_id,specialization,year_of_study,start_year,end_year,date_of_birth,active_status%0AJohn,Doe,john.doe@example.com,1234567890,1,Computer Science,2,2020,2024,2000-01-15,1" 
                               download="student_import_template.csv"
                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download CSV Template
                            </a>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- College and Course Selection -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">College & Course Assignment</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- College Selection (Left) -->
                                <div>
                                    <label for="college_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Select College <span class="text-red-500">*</span>
                                    </label>
                                    <select id="college_id" 
                                            name="college_id" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('college_id') border-red-500 @enderror"
                                            required>
                                        <option value="">-- Select a College --</option>
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

                                <!-- Course Selection (Right) -->
                                <div>
                                    <label for="course_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Courses <span class="text-red-500">*</span>
                                        <span id="selected-count" class="text-xs text-gray-500 font-normal"></span>
                                    </label>
                                    <div id="course-list-container" class="border border-gray-300 rounded-lg @error('course_ids') border-red-500 @enderror" style="max-height: 200px; overflow-y: auto;">
                                        @if($courses->count() > 0)
                                            <div class="p-2 space-y-1">
                                                @foreach($courses as $course)
                                                    <label class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer">
                                                        <input type="checkbox" 
                                                               name="course_ids[]" 
                                                               value="{{ $course->course_id }}"
                                                               class="course-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                               {{ in_array($course->course_id, old('course_ids', [])) ? 'checked' : '' }}>
                                                        <span class="ml-2 text-sm text-gray-700">
                                                            {{ $course->course_name }} 
                                                            <span class="text-xs text-gray-500">({{ $course->course_code }})</span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="p-4 text-sm text-gray-500 text-center">No courses available</p>
                                        @endif
                                    </div>
                                    @error('course_ids')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple courses. At least one course is required.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                                CSV File <span class="text-red-500">*</span>
                            </label>
                            <input type="file" 
                                   id="csv_file" 
                                   name="csv_file" 
                                   accept=".csv,.txt"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('csv_file') border-red-500 @enderror" 
                                   required>
                            @error('csv_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Maximum file size: 5MB</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('students.index') }}" class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                Import Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collegeDropdown = document.getElementById('college_id');
            const courseListContainer = document.getElementById('course-list-container');
            const selectedCount = document.getElementById('selected-count');
            
            // Function to update selected count
            function updateCount() {
                const checkedCount = document.querySelectorAll('.course-checkbox:checked').length;
                if (checkedCount > 0) {
                    selectedCount.textContent = `(${checkedCount} selected)`;
                } else {
                    selectedCount.textContent = '';
                }
            }
            
            // Function to load courses for selected college
            function loadCourses(collegeId) {
                if (!collegeId) {
                    courseListContainer.innerHTML = '<p class="p-4 text-sm text-gray-500 text-center">Please select a college first</p>';
                    updateCount();
                    return;
                }
                
                // Show loading state
                courseListContainer.innerHTML = '<p class="p-4 text-sm text-gray-500 text-center">Loading courses...</p>';
                
                // Fetch courses via AJAX
                fetch(`{{ route('courses.by-college') }}?college_id=${collegeId}`)
                    .then(response => response.json())
                    .then(courses => {
                        if (courses.length === 0) {
                            courseListContainer.innerHTML = '<p class="p-4 text-sm text-gray-500 text-center">No courses available for this college</p>';
                        } else {
                            let html = '<div class="p-2 space-y-1">';
                            courses.forEach(course => {
                                html += `
                                    <label class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer">
                                        <input type="checkbox" 
                                               name="course_ids[]" 
                                               value="${course.course_id}"
                                               class="course-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                               checked>
                                        <span class="ml-2 text-sm text-gray-700">
                                            ${course.course_name} 
                                            <span class="text-xs text-gray-500">(${course.course_code})</span>
                                        </span>
                                    </label>
                                `;
                            });
                            html += '</div>';
                            courseListContainer.innerHTML = html;
                            
                            // Re-attach event listeners to new checkboxes
                            document.querySelectorAll('.course-checkbox').forEach(checkbox => {
                                checkbox.addEventListener('change', updateCount);
                            });
                        }
                        updateCount();
                    })
                    .catch(error => {
                        console.error('Error loading courses:', error);
                        courseListContainer.innerHTML = '<p class="p-4 text-sm text-red-500 text-center">Error loading courses. Please try again.</p>';
                    });
            }
            
            // Handle college dropdown change
            collegeDropdown.addEventListener('change', function() {
                loadCourses(this.value);
            });
            
            // Initial setup: load courses if college is already selected (e.g., old() values)
            const initialCollegeId = collegeDropdown.value;
            if (initialCollegeId) {
                loadCourses(initialCollegeId);
            } else {
                courseListContainer.innerHTML = '<p class="p-4 text-sm text-gray-500 text-center">Please select a college first</p>';
            }
            
            // Initial count update for any pre-checked boxes
            updateCount();
        });
    </script>
</x-app-layout>
