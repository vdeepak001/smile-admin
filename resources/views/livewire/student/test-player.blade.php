<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                
                @if(!$isFinished)
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
                                        
                                        $isThisSelected = (int)$selectedOption === (int)$option;
                                        $bgClass = 'bg-white dark:bg-gray-800';
                                        $borderClass = 'border-gray-200 dark:border-gray-700';
                                        $iconClass = 'bg-gray-100 text-gray-500';
                                        
                                        if ($selectedOption) {
                                            if ($isThisSelected) {
                                                if ($optionStatus === 'correct') {
                                                    $bgClass = 'bg-green-50 dark:bg-green-900/20';
                                                    $borderClass = 'border-green-500';
                                                    $iconClass = 'bg-green-500 text-white';
                                                } else {
                                                    $bgClass = 'bg-red-50 dark:bg-red-900/20';
                                                    $borderClass = 'border-red-500';
                                                    $iconClass = 'bg-red-500 text-white';
                                                }
                                            } elseif ((int)$option === (int)$currentQuestion->right_answer) {
                                                // Highlight correct answer even if not selected
                                                $bgClass = 'bg-green-50 dark:bg-green-900/10';
                                                $borderClass = 'border-green-300';
                                                $iconClass = 'bg-green-300 text-white';
                                            } else {
                                                $bgClass = 'bg-gray-50 dark:bg-gray-800 opacity-50';
                                            }
                                        }
                                    @endphp
                                    @if($choiceText)
                                        <button 
                                            wire:key="option-{{ $currentQuestion->question_id }}-{{ $option }}"
                                            wire:click="submitAnswer({{ $currentQuestion->question_id }}, {{ $option }})" 
                                            @if($selectedOption) disabled @endif
                                            wire:loading.attr="disabled"
                                            class="p-4 text-left border-2 {{ $borderClass }} {{ $bgClass }} rounded-xl transition-all duration-200 flex items-center group
                                                   @if(!$selectedOption) hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer @else cursor-default @endif">
                                            <span class="w-10 h-10 flex items-center justify-center rounded-full font-bold mr-4 shrink-0 {{ $iconClass }}">
                                                {{ chr(64 + $option) }}
                                            </span>
                                            <span class="text-gray-700 dark:text-gray-300 font-medium text-lg">{{ $choiceText }}</span>
                                            
                                            <div wire:loading wire:target="submitAnswer({{ $currentQuestion->question_id }}, {{ $option }})" class="ml-auto">
                                                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                        </button>
                                    @endif
                                @endforeach
                            </div>

                            @if($selectedOption)
                                <div class="mt-8 flex justify-center">
                                    <button wire:click="nextQuestion" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                                        Next Question
                                    </button>
                                </div>
                            @endif
                        </div>
                    @else
                       <div class="text-center py-10">
                           <p>Loading Question...</p>
                       </div>
                    @endif

                    <script>
                        document.addEventListener('livewire:init', () => {
                           Livewire.on('answer-submitted', (event) => {
                               setTimeout(() => {
                                   @this.nextQuestion();
                               }, 2000);
                           });
                        });
                    </script>
                @else
                    <!-- Results Screen -->
                    <div class="text-center py-10">
                        <div class="mb-6 inline-flex p-4 rounded-full bg-green-100 text-green-600">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Test Completed!</h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-8">You have successfully completed the {{ $testType }} test.</p>
                        
                        <div class="max-w-md mx-auto bg-gray-50 dark:bg-gray-700 rounded-xl p-6 mb-8">
                             <div class="text-4xl font-bold text-blue-600 mb-2">{{ $score }}%</div>
                             <div class="text-sm text-gray-500 dark:text-gray-400 mb-6 uppercase tracking-wide">Final Score</div>
                             
                             <div class="grid grid-cols-2 gap-4 border-t border-gray-200 dark:border-gray-600 pt-6">
                                 <div>
                                     <span class="block text-2xl font-bold text-green-600">{{ $correctAnswersCount }}</span>
                                     <span class="text-xs text-gray-500">Correct</span>
                                 </div>
                                 <div class="border-l border-gray-200 dark:border-gray-600">
                                     <span class="block text-2xl font-bold text-red-600">{{ $wrongAnswersCount }}</span>
                                     <span class="text-xs text-gray-500">Wrong</span>
                                 </div>
                             </div>
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
