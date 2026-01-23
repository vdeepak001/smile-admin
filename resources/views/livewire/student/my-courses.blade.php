<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- College Courses Section -->
        @if($collegeCourses->count() > 0)
            <div class="mb-8">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                    {{ __('My College Courses') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($collegeCourses as $assigned)
                        @php
                            $course = $assigned->course;
                            $preTestMark = $course->marks->where('test_type', 'pre')->first();
                        @endphp
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                             @if($course->course_pic)
                                <img src="{{ asset('storage/' . $course->course_pic) }}" alt="{{ $course->course_name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400 text-4xl">📚</span>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $course->course_name }}</h3>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ $course->description }}
                                </p>


                                <a href="{{ route('student.course.show', $course->course_id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('View Course') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Open Courses Section -->
        @if($openCourses->count() > 0)
            <div class="mb-8" id="open-courses">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                    {{ __('Open Courses') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($openCourses as $assigned)
                        @php
                            $course = $assigned->course;
                            $preTestMark = $course->marks->where('test_type', 'pre')->first();
                            $practiceTestMark = $course->marks->where('test_type', 'practice')->first();
                            $mock1TestMark = $course->marks->where('test_type', 'mock1')->first();
                            $mock2TestMark = $course->marks->where('test_type', 'mock2')->first();
                            $finalTestMark = $course->marks->where('test_type', 'final')->first();
                            
                            // Calculate progress
                            $totalTests = 5;
                            $completedTests = 0;
                            if($preTestMark) $completedTests++;
                            if($practiceTestMark) $completedTests++;
                            if($mock1TestMark) $completedTests++;
                            if($mock2TestMark) $completedTests++;
                            if($finalTestMark) $completedTests++;
                            $progressPercentage = ($completedTests / $totalTests) * 100;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                             @if($course->course_pic)
                                <img src="{{ asset('storage/' . $course->course_pic) }}" alt="{{ $course->course_name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-indigo-600 flex items-center justify-center">
                                    <span class="text-white text-4xl">🎓</span>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $course->course_name }}</h3>
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-full">OPEN</span>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ $course->description }}
                                </p>

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Progress</span>
                                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $completedTests }}/{{ $totalTests }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('student.open-course.show', $course->course_id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('View Course') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- No Courses Message -->
        @if($collegeCourses->count() === 0 && $openCourses->count() === 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                {{ __('No courses assigned yet.') }}
            </div>
        @endif
    </div>
</div>
