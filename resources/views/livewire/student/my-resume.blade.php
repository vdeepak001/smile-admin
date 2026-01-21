<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
            {{ __('My Resume') }}
        </h2>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Upload Resume Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Upload Resume</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Upload your resume in PDF, DOC, or DOCX format (Max 5MB)
                    </p>
                </div>

                <div class="p-6">
                    @if($uploadedResume)
                        <!-- Existing Resume -->
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-green-900 dark:text-green-100">Resume Uploaded</p>
                                        <p class="text-xs text-green-700 dark:text-green-300">{{ basename($uploadedResume) }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $uploadedResume) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                        View
                                    </a>
                                    <button wire:click="deleteResume" wire:confirm="Are you sure you want to delete your resume?"
                                            class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Upload Form -->
                    <form wire:submit.prevent="uploadResume">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Choose Resume File
                            </label>
                            <input type="file" wire:model="resume" accept=".pdf,.doc,.docx"
                                   class="block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:outline-none">
                            @error('resume')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            @if($resume)
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    Selected: {{ $resume->getClientOriginalName() }}
                                </p>
                            @endif
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Upload Resume</span>
                            <span wire:loading>Uploading...</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- DuhamiCV Online Resume Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">DuhamiCV Online Resume</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Create a professional online resume with DuhamiCV
                    </p>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Features:</h4>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Professional templates</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Easy to customize</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Share with employers</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Download as PDF</span>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ $duhamiCvUrl }}" target="_blank"
                       class="block w-full text-center px-4 py-3 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <span class="flex items-center justify-center">
                            Create Online Resume
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </span>
                    </a>

                    <p class="mt-4 text-xs text-center text-gray-500 dark:text-gray-400">
                        Opens in a new window
                    </p>
                </div>
            </div>

        </div>

        <!-- Tips Section -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 dark:text-blue-100 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                Resume Tips
            </h3>
            <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                <li>• Keep your resume updated with your latest skills and experiences</li>
                <li>• Use a professional format and clear, concise language</li>
                <li>• Highlight your achievements and quantify results when possible</li>
                <li>• Tailor your resume for each job application</li>
                <li>• Proofread carefully for spelling and grammar errors</li>
            </ul>
        </div>
    </div>
</div>
