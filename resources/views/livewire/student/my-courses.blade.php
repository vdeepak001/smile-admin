<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
            {{ __('My Courses') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($assignedCourses as $assigned)
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

                        @if($preTestMark)
                            <div class="mb-4 bg-green-50 dark:bg-green-900/20 p-2 rounded-md border border-green-100 dark:border-green-800">
                                <p class="text-sm text-green-700 dark:text-green-400 font-medium">
                                    Pre-Test Score: {{ $preTestMark->percentage }}%
                                </p>
                            </div>
                        @endif

                        <a href="{{ route('student.course.show', $course->course_id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('View Course') }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                        {{ __('No courses assigned yet.') }}
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
