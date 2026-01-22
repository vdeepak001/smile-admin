<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6" @if(!$isFinished) wire:poll.1s="calculateTimeRemaining" @endif>
                
                @if(!$isFinished)
                    <!-- Timer Display -->
                    <div class="mb-4 text-center">
                        @php
                            $minutes = floor($timeRemaining / 60);
                            $seconds = $timeRemaining % 60;
                            $timerColor = $timeRemaining > 300 ? 'text-green-600' : ($timeRemaining > 60 ? 'text-yellow-600' : 'text-red-600');
                            $bgColor = $timeRemaining > 300 ? 'bg-green-50 border-green-200' : ($timeRemaining > 60 ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200');
                        @endphp
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 {{ $bgColor }}">
                            <svg class="w-5 h-5 {{ $timerColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-bold text-lg {{ $timerColor }}">
                                {{ sprintf('%02d:%02d', $minutes, $seconds) }}
                            </span>
                            <span class="text-sm text-gray-600">remaining</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6 text-center">
                        <div class="flex justify-between text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                            <span>Question {{ $currentQuestionIndex + 1 }} of {{ $totalQuestionsCount }}</span>
                            <span>{{ round((($currentQuestionIndex) / $totalQuestionsCount) * 100) }}% Completed</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ (($currentQuestionIndex) / $totalQuestionsCount) * 100 }}%"></div>
                        </div>
                    </div>

                    @if($currentQuestion)
                        <div class="mb-8">
                             <div class="inline-block px-3 py-1 mb-4 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">
                                {{ ucfirst($testType) }} Test
                            </div>
                            
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 font-primary">
                                {{ $currentQuestion->question_text }}
                            </h2>
                            
                            @if($currentQuestion->pic_1)
                                <img src="{{ asset('storage/' . $currentQuestion->pic_1) }}" class="mb-6 max-h-64 rounded-lg shadow-md mx-auto">
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach([1, 2, 3, 4] as $option)
                                    @php 
                                        $choiceKey = 'choice_' . $option;
                                        $choiceText = $currentQuestion->$choiceKey;
                                        
                                        // Check if this option is selected for the current question
                                        $isSelected = isset($answers[$currentQuestion->question_id]) && 
                                                      (int)$answers[$currentQuestion->question_id] === (int)$option;
                                        
                                        $bgClass = $isSelected ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800';
                                        $borderClass = $isSelected ? 'border-blue-500' : 'border-gray-200 dark:border-gray-700';
                                        $iconClass = $isSelected ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-500';
                                    @endphp
                                    @if($choiceText)
                                        <button 
                                            wire:key="option-{{ $currentQuestion->question_id }}-{{ $option }}"
                                            wire:click="selectAnswer({{ $currentQuestion->question_id }}, {{ $option }})" 
                                            wire:loading.attr="disabled"
                                            class="p-4 text-left border-2 {{ $borderClass }} {{ $bgClass }} rounded-xl transition-all duration-200 flex items-center group hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer">
                                            <span class="w-10 h-10 flex items-center justify-center rounded-full font-bold mr-4 shrink-0 {{ $iconClass }}">
                                                {{ chr(64 + $option) }}
                                            </span>
                                            <span class="text-gray-700 dark:text-gray-300 font-medium text-lg">{{ $choiceText }}</span>
                                        </button>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between items-center gap-4">
                                <!-- Previous Button -->
                                <button 
                                    wire:click="previousQuestion" 
                                    @if($currentQuestionIndex === 0) disabled @endif
                                    class="px-6 py-3 bg-gray-500 text-white rounded-lg font-bold hover:bg-gray-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    ← Previous
                                </button>

                                <!-- Next or Submit Button -->
                                @if($currentQuestionIndex < $totalQuestionsCount - 1)
                                    <button 
                                        wire:click="nextQuestion" 
                                        class="px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                                        Next →
                                    </button>
                                @else
                                    <button 
                                        wire:click="submitTest" 
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition">
                                        <span wire:loading.remove wire:target="submitTest">Submit Test</span>
                                        <span wire:loading wire:target="submitTest">Submitting...</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @else
                       <div class="text-center py-10">
                           <p>Loading Question...</p>
                       </div>
                    @endif
                @else
                    <!-- Results Screen -->
                    <div class="text-center py-10">
                        <div class="mb-6 inline-flex p-4 rounded-full bg-green-100 text-green-600">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Test Completed!</h2>
                        
                        <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                            <p class="text-gray-600 dark:text-gray-400 mb-2">You have successfully completed the {{ $testType }} test.</p>
                        </div>

                        <a href="{{ route('student.course.show', $course->course_id) }}" 
                           class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Back to Course
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
