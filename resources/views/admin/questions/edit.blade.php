<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('questions.update', $question) }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

                        <!-- Course -->
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Course <span class="text-red-500">*</span>
                            </label>
                            <select id="course_id" name="course_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('course_id') border-red-500 @enderror"
                                required>
                                <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->course_id }}" @selected(old('course_id', $question->course_id) == $course->course_id)>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Topic -->
                        <div>
                            <label for="topic_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic <span class="text-red-500">*</span>
                            </label>
                            <select id="topic_id" name="topic_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('topic_id') border-red-500 @enderror"
                                required>
                                <option value="">Select a topic</option>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->topic_id }}" @selected(old('topic_id', $question->topic_id) == $topic->topic_id)>
                                        {{ $topic->topic_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('topic_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Question Type -->
                        <div>
                            <label for="question_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Question Type <span class="text-red-500">*</span>
                            </label>
                            <select id="question_type" name="question_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('question_type') border-red-500 @enderror"
                                required>
                                <option value="">Select type</option>
                                <option value="multiple_choice" @selected(old('question_type', $question->question_type) == 'multiple_choice')>Multiple Choice</option>
                                <option value="short_answer" @selected(old('question_type', $question->question_type) == 'short_answer')>Short Answer</option>
                            </select>
                            @error('question_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Difficulty Level -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                                Difficulty Level <span class="text-red-500">*</span>
                            </label>
                            <select id="level" name="level"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('level') border-red-500 @enderror"
                                required>
                                <option value="">Select level</option>
                                <option value="1" @selected(old('level', $question->level) == '1')>Level 1 (Easy)</option>
                                <option value="2" @selected(old('level', $question->level) == '2')>Level 2</option>
                                <option value="3" @selected(old('level', $question->level) == '3')>Level 3 (Medium)</option>
                                <option value="4" @selected(old('level', $question->level) == '4')>Level 4</option>
                                <option value="5" @selected(old('level', $question->level) == '5')>Level 5 (Hard)</option>
                            </select>
                            @error('level')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Question Text <span class="text-red-500">*</span>
                        </label>
                        <textarea id="question_text" name="question_text" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('question_text') border-red-500 @enderror"
                            placeholder="Enter the question text" required>{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Question Images -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="pic_1" class="block text-sm font-medium text-gray-700 mb-2">
                                Question Picture 1
                            </label>
                            @if($question->pic_1)
                                <div class="mb-2">
                                    <img src="{{ \Storage::url($question->pic_1) }}" alt="Question Pic 1" class="w-32 h-32 object-cover rounded">
                                    <p class="text-xs text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" id="pic_1" name="pic_1" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pic_1') border-red-500 @enderror">
                            @error('pic_1')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="pic_2" class="block text-sm font-medium text-gray-700 mb-2">
                                Question Picture 2
                            </label>
                            @if($question->pic_2)
                                <div class="mb-2">
                                    <img src="{{ \Storage::url($question->pic_2) }}" alt="Question Pic 2" class="w-32 h-32 object-cover rounded">
                                    <p class="text-xs text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" id="pic_2" name="pic_2" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pic_2') border-red-500 @enderror">
                            @error('pic_2')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="pic_3" class="block text-sm font-medium text-gray-700 mb-2">
                                Question Picture 3
                            </label>
                            @if($question->pic_3)
                                <div class="mb-2">
                                    <img src="{{ \Storage::url($question->pic_3) }}" alt="Question Pic 3" class="w-32 h-32 object-cover rounded">
                                    <p class="text-xs text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" id="pic_3" name="pic_3" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pic_3') border-red-500 @enderror">
                            @error('pic_3')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Answer Choices -->
                    <div id="answer-choices-section" class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Answer Choices</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Choice 1 -->
                            <div class="space-y-3">
                                <div>
                                    <label for="choice_1" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 1
                                    </label>
                                    <input type="text" id="choice_1" name="choice_1"
                                        value="{{ old('choice_1', $question->choice_1) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_1') border-red-500 @enderror"
                                        placeholder="Enter choice 1">
                                    @error('choice_1')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="choice_pic_1" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 1 Picture
                                    </label>
                                    @if($question->choice_pic_1)
                                        <div class="mb-2">
                                            <img src="{{ \Storage::url($question->choice_pic_1) }}" alt="Choice 1" class="w-32 h-32 object-cover rounded">
                                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                                        </div>
                                    @endif
                                    <input type="file" id="choice_pic_1" name="choice_pic_1" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_pic_1') border-red-500 @enderror">
                                    @error('choice_pic_1')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Choice 2 -->
                            <div class="space-y-3">
                                <div>
                                    <label for="choice_2" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 2
                                    </label>
                                    <input type="text" id="choice_2" name="choice_2"
                                        value="{{ old('choice_2', $question->choice_2) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_2') border-red-500 @enderror"
                                        placeholder="Enter choice 2">
                                    @error('choice_2')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="choice_pic_2" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 2 Picture
                                    </label>
                                    @if($question->choice_pic_2)
                                        <div class="mb-2">
                                            <img src="{{ \Storage::url($question->choice_pic_2) }}" alt="Choice 2" class="w-32 h-32 object-cover rounded">
                                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                                        </div>
                                    @endif
                                    <input type="file" id="choice_pic_2" name="choice_pic_2" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_pic_2') border-red-500 @enderror">
                                    @error('choice_pic_2')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Choice 3 -->
                            <div class="space-y-3">
                                <div>
                                    <label for="choice_3" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 3
                                    </label>
                                    <input type="text" id="choice_3" name="choice_3"
                                        value="{{ old('choice_3', $question->choice_3) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_3') border-red-500 @enderror"
                                        placeholder="Enter choice 3">
                                    @error('choice_3')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="choice_pic_3" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 3 Picture
                                    </label>
                                    @if($question->choice_pic_3)
                                        <div class="mb-2">
                                            <img src="{{ \Storage::url($question->choice_pic_3) }}" alt="Choice 3" class="w-32 h-32 object-cover rounded">
                                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                                        </div>
                                    @endif
                                    <input type="file" id="choice_pic_3" name="choice_pic_3" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_pic_3') border-red-500 @enderror">
                                    @error('choice_pic_3')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Choice 4 -->
                            <div class="space-y-3">
                                <div>
                                    <label for="choice_4" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 4
                                    </label>
                                    <input type="text" id="choice_4" name="choice_4"
                                        value="{{ old('choice_4', $question->choice_4) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_4') border-red-500 @enderror"
                                        placeholder="Enter choice 4">
                                    @error('choice_4')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="choice_pic_4" class="block text-sm font-medium text-gray-700 mb-2">
                                        Choice 4 Picture
                                    </label>
                                    @if($question->choice_pic_4)
                                        <div class="mb-2">
                                            <img src="{{ \Storage::url($question->choice_pic_4) }}" alt="Choice 4" class="w-32 h-32 object-cover rounded">
                                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                                        </div>
                                    @endif
                                    <input type="file" id="choice_pic_4" name="choice_pic_4" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('choice_pic_4') border-red-500 @enderror">
                                    @error('choice_pic_4')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Answer -->
                    <div id="right-answer-section">
                        <label for="right_answer" class="block text-sm font-medium text-gray-700 mb-2">
                            Right Answer
                        </label>
                        <select id="right_answer" name="right_answer"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('right_answer') border-red-500 @enderror">
                            <option value="">Select correct answer</option>
                            <option value="1" @selected(old('right_answer', $question->right_answer) == '1')>Choice 1</option>
                            <option value="2" @selected(old('right_answer', $question->right_answer) == '2')>Choice 2</option>
                            <option value="3" @selected(old('right_answer', $question->right_answer) == '3')>Choice 3</option>
                            <option value="4" @selected(old('right_answer', $question->right_answer) == '4')>Choice 4</option>
                        </select>
                        @error('right_answer')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reasoning -->
                    <div>
                        <label for="reasoning" class="block text-sm font-medium text-gray-700 mb-2">
                            Reasoning/Explanation
                        </label>
                        <textarea id="reasoning" name="reasoning" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reasoning') border-red-500 @enderror"
                            placeholder="Explain why this is the correct answer">{{ old('reasoning', $question->reasoning) }}</textarea>
                        @error('reasoning')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input type="hidden" name="active_status" value="0">
                        <input type="checkbox" id="active_status" name="active_status" value="1"
                            @checked(old('active_status', $question->active_status))
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                        <label for="active_status" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                            Active Status
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('questions.index') }}"
                            class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            Update Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionTypeSelect = document.getElementById('question_type');
            const answerChoicesSection = document.getElementById('answer-choices-section');
            const rightAnswerSection = document.getElementById('right-answer-section');

            function toggleSections() {
                const selectedType = questionTypeSelect.value;
                
                if (selectedType === 'multiple_choice') {
                    answerChoicesSection.style.display = 'block';
                    rightAnswerSection.style.display = 'block';
                } else {
                    answerChoicesSection.style.display = 'none';
                    rightAnswerSection.style.display = 'none';
                }
            }

            // Initial check on page load
            toggleSections();

            // Listen for changes
            questionTypeSelect.addEventListener('change', toggleSections);
        });
    </script>
</x-app-layout>
