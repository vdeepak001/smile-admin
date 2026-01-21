<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Course Header -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->course_name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Test Reports</p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Course Code</span>
                    <p class="text-lg font-mono font-bold text-gray-900 dark:text-gray-100">{{ $course->course_code }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Pre-Test Report -->
            @if($preTestMark)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Pre-Test</h3>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                    </div>
                    <div class="p-6">
                         <div class="text-center mb-4">
                            <div class="text-3xl font-bold text-yellow-600">{{ $preTestMark->percentage }}%</div>
                            <div class="text-sm text-gray-500">Score</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center text-sm mb-4">
                            <div class="p-2 bg-green-50 rounded">
                                <span class="block font-bold text-green-600">{{ $preTestMark->correct_answer }}</span>
                                <span class="text-xs text-gray-500">Correct</span>
                            </div>
                            <div class="p-2 bg-red-50 rounded">
                                <span class="block font-bold text-red-600">{{ $preTestMark->wrong_answer }}</span>
                                <span class="text-xs text-gray-500">Wrong</span>
                            </div>
                        </div>
                        <a href="{{ route('student.test-report', ['course' => $course->course_id, 'test_type' => 'pre']) }}" 
                           class="block w-full text-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500">
                            View Details
                        </a>
                    </div>
                </div>
            @endif

            <!-- Topic Tests (College Courses) -->
            @if($course->course_type === 'college')
                @foreach($topicMarks as $topicData)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                             <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $topicData['topic']->topic_name }}</h3>
                                    <p class="text-xs text-gray-500">Topic Test</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                        </div>
                        <div class="p-6">
                             <div class="text-center mb-4">
                                <div class="text-3xl font-bold text-blue-600">{{ $topicData['mark']->percentage }}%</div>
                                <div class="text-sm text-gray-500">Score</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-center text-sm mb-4">
                                <div class="p-2 bg-green-50 rounded">
                                    <span class="block font-bold text-green-600">{{ $topicData['mark']->correct_answer }}</span>
                                    <span class="text-xs text-gray-500">Correct</span>
                                </div>
                                <div class="p-2 bg-red-50 rounded">
                                    <span class="block font-bold text-red-600">{{ $topicData['mark']->wrong_answer }}</span>
                                    <span class="text-xs text-gray-500">Wrong</span>
                                </div>
                            </div>
                            <a href="{{ route('student.test-report', ['course' => $course->course_id, 'test_type' => 'topic', 'topic_id' => $topicData['topic']->topic_id]) }}" 
                               class="block w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Practice Test (Open Courses) -->
            @if($course->course_type === 'open' && $practiceTestMark)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Practice Questions</h3>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                    </div>
                    <div class="p-6">
                         <div class="text-center mb-4">
                            <div class="text-3xl font-bold text-blue-600">{{ $practiceTestMark->percentage }}%</div>
                            <div class="text-sm text-gray-500">Score</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center text-sm mb-4">
                            <div class="p-2 bg-green-50 rounded">
                                <span class="block font-bold text-green-600">{{ $practiceTestMark->correct_answer }}</span>
                                <span class="text-xs text-gray-500">Correct</span>
                            </div>
                            <div class="p-2 bg-red-50 rounded">
                                <span class="block font-bold text-red-600">{{ $practiceTestMark->wrong_answer }}</span>
                                <span class="text-xs text-gray-500">Wrong</span>
                            </div>
                        </div>
                        <a href="{{ route('student.test-report', ['course' => $course->course_id, 'test_type' => 'practice']) }}" 
                           class="block w-full text-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                            View Details
                        </a>
                    </div>
                </div>
            @endif

            <!-- Mock Test 1 (Open Courses) -->
            @if($course->course_type === 'open' && $mock1TestMark)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Mock Test 1</h3>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                    </div>
                    <div class="p-6">
                         <div class="text-center mb-4">
                            <div class="text-3xl font-bold text-indigo-600">{{ $mock1TestMark->percentage }}%</div>
                            <div class="text-sm text-gray-500">Score</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center text-sm mb-4">
                            <div class="p-2 bg-green-50 rounded">
                                <span class="block font-bold text-green-600">{{ $mock1TestMark->correct_answer }}</span>
                                <span class="text-xs text-gray-500">Correct</span>
                            </div>
                            <div class="p-2 bg-red-50 rounded">
                                <span class="block font-bold text-red-600">{{ $mock1TestMark->wrong_answer }}</span>
                                <span class="text-xs text-gray-500">Wrong</span>
                            </div>
                        </div>
                        <a href="{{ route('student.test-report', ['course' => $course->course_id, 'test_type' => 'mock1']) }}" 
                           class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            View Details
                        </a>
                    </div>
                </div>
            @endif

            <!-- Mock Test 2 (Open Courses) -->
            @if($course->course_type === 'open' && $mock2TestMark)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-pink-100 text-pink-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Mock Test 2</h3>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                    </div>
                    <div class="p-6">
                         <div class="text-center mb-4">
                            <div class="text-3xl font-bold text-pink-600">{{ $mock2TestMark->percentage }}%</div>
                            <div class="text-sm text-gray-500">Score</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center text-sm mb-4">
                            <div class="p-2 bg-green-50 rounded">
                                <span class="block font-bold text-green-600">{{ $mock2TestMark->correct_answer }}</span>
                                <span class="text-xs text-gray-500">Correct</span>
                            </div>
                            <div class="p-2 bg-red-50 rounded">
                                <span class="block font-bold text-red-600">{{ $mock2TestMark->wrong_answer }}</span>
                                <span class="text-xs text-gray-500">Wrong</span>
                            </div>
                        </div>
                        <a href="{{ route('student.test-report', ['course' => $course->course_id, 'test_type' => 'mock2']) }}" 
                           class="block w-full text-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-500">
                            View Details
                        </a>
                    </div>
                </div>
            @endif

            <!-- Final Test Report -->
            @if($finalTestMark)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                         <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Final Test</h3>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Completed</span>
                    </div>
                    <div class="p-6">
                         <div class="text-center mb-4">
                            <div class="text-3xl font-bold text-purple-600">{{ $finalTestMark->percentage }}%</div>
                            <div class="text-sm text-gray-500">Final Score</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center text-sm mb-4 max-w-md mx-auto">
                            <div class="p-2 bg-green-50 rounded">
                                <span class="block font-bold text-green-600">{{ $finalTestMark->correct_answer }}</span>
                                <span class="text-xs text-gray-500">Correct</span>
                            </div>
                            <div class="p-2 bg-red-50 rounded">
                                <span class="block font-bold text-red-600">{{ $finalTestMark->wrong_answer }}</span>
                                <span class="text-xs text-gray-500">Wrong</span>
                            </div>
                        </div>
                        <div class="max-w-md mx-auto">
                            <a href="{{ route('student.test-report', ['course' => $course->course_id, 'test_type' => 'final']) }}" 
                               class="block w-full text-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
