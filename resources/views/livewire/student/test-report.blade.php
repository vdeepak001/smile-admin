<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Test Header -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ ucfirst($testType) }} Test Report
                            @if($topic)
                                - {{ $topic->topic_name }}
                            @endif
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $course->course_name }}</p>
                    </div>
                    <a href="{{ route('student.course-report', $course->course_id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                        Back to Course
                    </a>
                </div>

                <!-- Test Summary -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ $mark->percentage }}%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Score</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">{{ $mark->correct_answer }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Correct</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-red-600">{{ $mark->wrong_answer }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Wrong</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600">{{ $mark->total_questions }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Questions</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Review -->
        <div class="space-y-6">
            @foreach($this->visibleQuestions as $index => $answered)
                @php
                    $question = $answered->question;
                    $isCorrect = $answered->answered_status === 'correct';
                @endphp
                
                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div @click="open = !open" class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 flex-1 mr-4 line-clamp-1">
                            {{ $question->question_text }}
                        </h3>
                        <div class="flex items-center space-x-3 shrink-0">
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div x-show="open" x-cloak>
                        <div class="p-6">
                            <!-- Question Images/Options -->
                            <div class="mb-6">
                                @if($question->pic_1 || $question->pic_2 || $question->pic_3)
                                    <div class="flex space-x-2 mb-4">
                                        @if($question->pic_1)
                                            <img src="{{ asset('storage/' . $question->pic_1) }}" alt="Question Image 1" class="max-w-xs rounded">
                                        @endif
                                        @if($question->pic_2)
                                            <img src="{{ asset('storage/' . $question->pic_2) }}" alt="Question Image 2" class="max-w-xs rounded">
                                        @endif
                                        @if($question->pic_3)
                                            <img src="{{ asset('storage/' . $question->pic_3) }}" alt="Question Image 3" class="max-w-xs rounded">
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Answer Choices -->
                            <div class="space-y-3">
                                @for($i = 1; $i <= 4; $i++)
                                    @php
                                        $choiceText = $question->{'choice_' . $i};
                                        $choicePic = $question->{'choice_pic_' . $i};
                                        $isStudentAnswer = $answered->answered_choice == $i;
                                        $isCorrectAnswer = $question->right_answer == $i;
                                        
                                        $bgClass = '';
                                        $borderClass = 'border-gray-300';
                                        $textClass = 'text-gray-900 dark:text-gray-100';
                                        
                                        if ($isCorrectAnswer) {
                                            $bgClass = 'bg-green-50 dark:bg-green-900/20';
                                            $borderClass = 'border-green-500';
                                            $textClass = 'text-green-900 dark:text-green-100';
                                        } elseif ($isStudentAnswer && !$isCorrect) {
                                            $bgClass = 'bg-red-50 dark:bg-red-900/20';
                                            $borderClass = 'border-red-500';
                                            $textClass = 'text-red-900 dark:text-red-100';
                                        }
                                    @endphp
                                    
                                    @if($choiceText)
                                        <div class="p-4 border-2 rounded-lg {{ $bgClass }} {{ $borderClass }} relative">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <span class="font-semibold {{ $textClass }}">{{ chr(64 + $i) }}.</span>
                                                    <span class="{{ $textClass }} ml-2">{{ $choiceText }}</span>
                                                    
                                                    @if($choicePic)
                                                        <img src="{{ asset('storage/' . $choicePic) }}" alt="Choice {{ chr(64 + $i) }}" class="mt-2 max-w-xs rounded">
                                                    @endif
                                                </div>
                                                
                                                <div class="ml-4 flex flex-col items-end space-y-1">
                                                    @if($isCorrectAnswer)
                                                        <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded">
                                                            Correct Answer
                                                        </span>
                                                    @endif
                                                    @if($isStudentAnswer)
                                                        <span class="px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded">
                                                            Your Answer
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>

                            <!-- Reasoning -->
                            @if($question->reasoning)
                                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <h4 class="font-bold text-blue-900 dark:text-blue-100 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                        Explanation
                                    </h4>
                                    <p class="text-blue-800 dark:text-blue-200">{{ $question->reasoning }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More Button -->
        @if($this->hasMoreQuestions)
            <div class="mt-8 text-center">
                <button wire:click="loadMore" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    Load More Questions ({{ $answeredQuestions->count() - $questionsToShow }} remaining)
                </button>
            </div>
        @endif
    </div>
</div>
