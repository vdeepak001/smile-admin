<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                Question Details
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('questions.edit', $question) }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('questions.index') }}"
                    class="inline-flex items-center px-3 py-1 text-sm bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Question Text Card -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Question</h3>
                <p class="text-gray-900 text-lg">{{ $question->question_text }}</p>
            </div>

            <!-- Question Images -->
            @if($question->pic_1 || $question->pic_2 || $question->pic_3)
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Question Images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @if($question->pic_1)
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Picture 1</p>
                                <img src="{{ \Storage::url($question->pic_1) }}" alt="Question Picture 1"
                                    class="w-full h-48 object-cover rounded-lg shadow">
                            </div>
                        @endif
                        @if($question->pic_2)
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Picture 2</p>
                                <img src="{{ \Storage::url($question->pic_2) }}" alt="Question Picture 2"
                                    class="w-full h-48 object-cover rounded-lg shadow">
                            </div>
                        @endif
                        @if($question->pic_3)
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Picture 3</p>
                                <img src="{{ \Storage::url($question->pic_3) }}" alt="Question Picture 3"
                                    class="w-full h-48 object-cover rounded-lg shadow">
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Basic Information Card -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Question Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Course</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $question->course->course_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Topic</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $question->topic->topic_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Question Type</p>
                        <p class="text-lg font-semibold text-gray-900">
                            @php
                                $typeLabels = [
                                    'multiple_choice' => 'Multiple Choice',
                                    'true_false' => 'True/False',
                                    'short_answer' => 'Short Answer',
                                ];
                            @endphp
                            {{ $typeLabels[$question->question_type] ?? ucfirst(str_replace('_', ' ', $question->question_type)) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Difficulty Level</p>
                        <div class="flex items-center mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $question->level ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                            <span class="ml-2 text-gray-700 font-semibold">{{ $question->level }} / 5</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p class="mt-1">
                            @if ($question->active_status)
                                <span
                                    class="inline-flex px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                                    Active
                                </span>
                            @else
                                <span
                                    class="inline-flex px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Answer Choices Card -->
            @if($question->question_type === 'multiple_choice' && ($question->choice_1 || $question->choice_2 || $question->choice_3 || $question->choice_4))
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Answer Choices</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($question->choice_1)
                            <div class="border rounded-lg p-4 {{ $question->right_answer == $question->choice_1 ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-2">Choice 1</p>
                                        <p class="text-gray-900">{{ $question->choice_1 }}</p>
                                    </div>
                                    @if($question->right_answer == $question->choice_1)
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                @if($question->choice_pic_1)
                                    <img src="{{ \Storage::url($question->choice_pic_1) }}" alt="Choice 1" class="w-full h-32 object-cover rounded-lg mt-3">
                                @endif
                            </div>
                        @endif
                        @if($question->choice_2)
                            <div class="border rounded-lg p-4 {{ $question->right_answer == $question->choice_2 ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-2">Choice 2</p>
                                        <p class="text-gray-900">{{ $question->choice_2 }}</p>
                                    </div>
                                    @if($question->right_answer == $question->choice_2)
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                @if($question->choice_pic_2)
                                    <img src="{{ \Storage::url($question->choice_pic_2) }}" alt="Choice 2" class="w-full h-32 object-cover rounded-lg mt-3">
                                @endif
                            </div>
                        @endif
                        @if($question->choice_3)
                            <div class="border rounded-lg p-4 {{ $question->right_answer == $question->choice_3 ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-2">Choice 3</p>
                                        <p class="text-gray-900">{{ $question->choice_3 }}</p>
                                    </div>
                                    @if($question->right_answer == $question->choice_3)
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                @if($question->choice_pic_3)
                                    <img src="{{ \Storage::url($question->choice_pic_3) }}" alt="Choice 3" class="w-full h-32 object-cover rounded-lg mt-3">
                                @endif
                            </div>
                        @endif
                        @if($question->choice_4)
                            <div class="border rounded-lg p-4 {{ $question->right_answer == $question->choice_4 ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-2">Choice 4</p>
                                        <p class="text-gray-900">{{ $question->choice_4 }}</p>
                                    </div>
                                    @if($question->right_answer == $question->choice_4)
                                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                @if($question->choice_pic_4)
                                    <img src="{{ \Storage::url($question->choice_pic_4) }}" alt="Choice 4" class="w-full h-32 object-cover rounded-lg mt-3">
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Right Answer & Reasoning Card -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    @if($question->question_type === 'short_answer')
                        Explanation
                    @else
                        Answer & Reasoning
                    @endif
                </h3>
                <div class="space-y-4">
                    @if($question->question_type === 'multiple_choice')
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-2">Correct Answer</p>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-lg font-semibold text-green-900">{{ $question->right_answer ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    @endif
                    @if($question->reasoning)
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-2">Reasoning/Explanation</p>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-gray-900">{{ $question->reasoning }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Audit Information -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Audit Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $question->insertedBy?->name ?? 'System' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Created At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $question->inserted_on ? $question->inserted_on->format('M d, Y H:i A') : 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated By</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $question->updatedBy?->name ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Last Updated At</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $question->updated_on ? $question->updated_on->format('M d, Y H:i A') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
