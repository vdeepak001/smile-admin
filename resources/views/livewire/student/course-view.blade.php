<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Course Header -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->course_name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $course->description }}</p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Course Code</span>
                    <p class="text-lg font-mono font-bold text-gray-900 dark:text-gray-100">{{ $course->course_code }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Tests Navigation -->
            <div class="col-span-1 space-y-6">
                
                <!-- Pre-Test Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative {{ $preTestEnabled ? '' : 'opacity-50 grayscale' }}">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Pre-Test</h3>
                        </div>
                         @if($preTestMark)
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                        @endif
                    </div>
                    <div class="p-6">
                         @if($preTestMark)
                             <div class="text-center mb-4">
                                <div class="text-3xl font-bold text-green-600">{{ $preTestMark->percentage }}%</div>
                                <div class="text-sm text-gray-500">Score Scored</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-center text-sm">
                                <div class="p-2 bg-green-50 rounded">
                                    <span class="block font-bold text-green-600">{{ $preTestMark->correct_answer }}</span>
                                    <span class="text-xs text-gray-500">Correct</span>
                                </div>
                                <div class="p-2 bg-red-50 rounded">
                                    <span class="block font-bold text-red-600">{{ $preTestMark->wrong_answer }}</span>
                                    <span class="text-xs text-gray-500">Wrong</span>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                Take the pre-test to unlock course topics.
                            </p>
                            @if($preTestEnabled)
                                <a href="{{ route('student.test.take', ['test_type' => 'pre', 'context_id' => $course->course_id]) }}" class="block w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 btn-primary">
                                    Start Pre-Test
                                </a>
                            @else
                                <button disabled class="block w-full text-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                                    Locked
                                </button>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Final Test Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative {{ $finalTestEnabled ? '' : 'opacity-50 grayscale' }}">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Final Test</h3>
                        </div>
                        @if($finalTestMark)
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                        @endif
                    </div>
                    <div class="p-6">
                        @if($finalTestMark)
                             <div class="text-center mb-4">
                                <div class="text-3xl font-bold text-purple-600">{{ $finalTestMark->percentage }}%</div>
                                <div class="text-sm text-gray-500">Final Score</div>
                            </div>
                             <div class="grid grid-cols-2 gap-4 text-center text-sm">
                                <div class="p-2 bg-green-50 rounded">
                                    <span class="block font-bold text-green-600">{{ $finalTestMark->correct_answer }}</span>
                                    <span class="text-xs text-gray-500">Correct</span>
                                </div>
                                <div class="p-2 bg-red-50 rounded">
                                    <span class="block font-bold text-red-600">{{ $finalTestMark->wrong_answer }}</span>
                                    <span class="text-xs text-gray-500">Wrong</span>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                Complete all topics to unlock the Final Test.
                            </p>
                             @if($finalTestEnabled)
                                <a href="{{ route('student.test.take', ['test_type' => 'final', 'context_id' => $course->course_id]) }}" class="block w-full text-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 btn-primary">
                                    Start Final Test
                                </a>
                            @else
                                <button disabled class="block w-full text-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                                    Locked
                                </button>
                            @endif
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Column: Topics List -->
            <div class="col-span-1 lg:col-span-2">
                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 flex items-center">
                            <span class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            Topic-wise Tests
                        </h3>
                    </div>
                    
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($topics as $topic)
                            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 {{ $topicsEnabled ? '' : 'opacity-50 pointer-events-none' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">{{ $topic->topic_name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $topic->description }}</p>
                                        
                                        @if($topic->mark)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Score: {{ $topic->mark->percentage }}%
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="ml-4">
                                        @if($topic->mark)
                                            <button disabled class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest shadow-sm disabled:opacity-75 disabled:cursor-not-allowed">
                                                Completed
                                            </button>
                                        @elseif($topicsEnabled)
                                             <a href="{{ route('student.test.take', ['test_type' => 'topic', 'context_id' => $topic->topic_id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Take Test
                                            </a>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 rounded text-xs font-medium">
                                                Locked
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                             <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                No topics found for this course.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
