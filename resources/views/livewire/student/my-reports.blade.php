<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
            {{ __('My Reports') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($courses as $course)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                     @if($course->course_pic)
                        <img src="{{ asset('storage/' . $course->course_pic) }}" alt="{{ $course->course_name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-green-400 to-teal-600 flex items-center justify-center">
                            <span class="text-white text-4xl">📊</span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $course->course_name }}</h3>
                            <span class="px-2 py-1 bg-{{ $course->course_type === 'open' ? 'purple' : 'blue' }}-100 text-{{ $course->course_type === 'open' ? 'purple' : 'blue' }}-800 text-xs font-bold rounded-full uppercase">
                                {{ $course->course_type }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ $course->course_code }}
                        </p>

                        @if(!($course->latest_completion_at && $course->latest_completion_at->diffInHours(now()) < 1))
                            <!-- Statistics -->
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                    <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $course->total_tests }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Tests</div>
                                </div>
                                <div class="text-center p-2 bg-green-50 dark:bg-green-900/20 rounded">
                                    <div class="text-lg font-bold text-green-600">{{ $course->average_score }}%</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Avg</div>
                                </div>
                                <div class="text-center p-2 bg-blue-50 dark:bg-blue-900/20 rounded">
                                    <div class="text-lg font-bold text-blue-600">{{ $course->highest_score }}%</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Best</div>
                                </div>
                            </div>
                        @endif

                        @if($course->latest_completion_at && $course->latest_completion_at->diffInHours(now()) < 1)
                             <div class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                                {{ __('You can see result after 1 hour') }}
                            </div>
                        @else
                            <a href="{{ route('student.course-report', $course->course_id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('View Report') }}
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500 dark:text-gray-400">
                        {{ __('No test reports available yet. Complete a test to see your reports here.') }}
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
