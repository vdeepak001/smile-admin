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

            <!-- Resume Builder Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ activeTab: 'basics' }">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">Resume Builder</h3>
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="saveBuilderData" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                Save
                            </button>
                            <button wire:click="generatePdf" class="inline-flex items-center px-3 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500">
                                Download PDF
                            </button>
                        </div>
                    </div>

                    <!-- Builder Tabs -->
                    <div class="flex border-b border-gray-200 dark:border-gray-700">
                        <button @click="activeTab = 'basics'" :class="{'border-blue-500 text-blue-600': activeTab === 'basics'}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors">
                            Basics
                        </button>
                        <button @click="activeTab = 'education'" :class="{'border-blue-500 text-blue-600': activeTab === 'education'}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors">
                            Education
                        </button>
                        <button @click="activeTab = 'work'" :class="{'border-blue-500 text-blue-600': activeTab === 'work'}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors">
                            Work
                        </button>
                        <button @click="activeTab = 'projects'" :class="{'border-blue-500 text-blue-600': activeTab === 'projects'}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors">
                            Projects
                        </button>
                        <button @click="activeTab = 'skills'" :class="{'border-blue-500 text-blue-600': activeTab === 'skills'}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors">
                            Skills
                        </button>
                        <button @click="activeTab = 'more'" :class="{'border-blue-500 text-blue-600': activeTab === 'more'}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors">
                            Other
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Basics Tab -->
                    <div x-show="activeTab === 'basics'" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                <input type="text" wire:model="basics.name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title / Label</label>
                                <input type="text" wire:model="basics.label" placeholder="e.g. Software Developer" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" wire:model="basics.email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <input type="text" wire:model="basics.phone" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex-shrink-0 relative group">
                                @php
                                    $photoUrl = null;
                                    if ($resumePhoto) {
                                        $photoUrl = $resumePhoto->temporaryUrl();
                                    } elseif (!empty($basics['image'])) {
                                        $photoUrl = Storage::url($basics['image']);
                                    } elseif (auth()->user()->avatar) {
                                        $photoUrl = Storage::url(auth()->user()->avatar);
                                    }
                                @endphp

                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" class="w-12 h-12 rounded-full object-cover border-2 border-blue-500">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 text-sm font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <label for="resumePhoto" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                                <input type="file" id="resumePhoto" x-ref="photoInput" wire:model="resumePhoto" class="hidden" accept="image/*">
                            </div>
                            <div class="flex-grow">
                                <label class="text-sm font-medium text-gray-900 dark:text-gray-100">Resume Photo</label>
                                <div class="flex items-center space-x-2">
                                    <button type="button" @click="$refs.photoInput.click()" class="text-xs text-blue-600 hover:text-blue-500 font-medium">Select Photo</button>
                                    <span class="text-gray-300">|</span>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="basics.show_image" class="sr-only peer">
                                        <div class="relative w-7 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        <span class="ms-2 text-xs font-medium text-gray-500">Show in PDF</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional Summary</label>
                            <textarea wire:model="basics.summary" rows="3" placeholder="Aspiring to join a IT team to design and develop..." class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City, Country</label>
                                <input type="text" wire:model="basics.location.city" placeholder="Ujjain, India" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">LinkedIn Username</label>
                                <input type="text" wire:model="basics.profiles.linkedin" placeholder="shiksha-shukla-61a58a259" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">GitHub Username</label>
                                <input type="text" wire:model="basics.profiles.github" placeholder="Shikshashukla" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Education Tab -->
                    <div x-show="activeTab === 'education'" class="space-y-6">
                        @foreach($education as $index => $item)
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg relative">
                            <button @click.prevent="window.confirm('Are you sure?') ? $wire.removeEducation({{ $index }}) : null" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Degree / Qualification</label>
                                    <input type="text" wire:model="education.{{ $index }}.studyType" placeholder="Master Of Computer Application" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution</label>
                                    <input type="text" wire:model="education.{{ $index }}.institution" placeholder="Vikram University , Ujjain" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">GPA / Score</label>
                                    <input type="text" wire:model="education.{{ $index }}.score" placeholder="7.98 or 67" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Field / Area</label>
                                    <input type="text" wire:model="education.{{ $index }}.area" placeholder="Computer application" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="text" wire:model="education.{{ $index }}.startDate" placeholder="08/2021" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="text" wire:model="education.{{ $index }}.endDate" placeholder="07/2023" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <button wire:click="addEducation" class="w-full py-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 hover:text-gray-700 hover:border-gray-400 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Education
                        </button>
                    </div>

                    <!-- Work Tab -->
                    <div x-show="activeTab === 'work'" class="space-y-6">
                        @foreach($work as $index => $item)
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg relative">
                            <button @click.prevent="window.confirm('Are you sure?') ? $wire.removeWork({{ $index }}) : null" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                                    <input type="text" wire:model="work.{{ $index }}.company" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                                    <input type="text" wire:model="work.{{ $index }}.position" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                    <input type="text" wire:model="work.{{ $index }}.startDate" placeholder="Jan 2020" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                    <input type="text" wire:model="work.{{ $index }}.endDate" placeholder="Present" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea wire:model="work.{{ $index }}.summary" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        @endforeach
                        <button wire:click="addWork" class="w-full py-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 hover:text-gray-700 hover:border-gray-400 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Experience
                        </button>
                    </div>

                    <!-- Projects Tab -->
                    <div x-show="activeTab === 'projects'" class="space-y-6">
                        @foreach($projects as $index => $item)
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg relative">
                            <button @click.prevent="window.confirm('Are you sure?') ? $wire.removeProject({{ $index }}) : null" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name</label>
                                    <input type="text" wire:model="projects.{{ $index }}.name" placeholder="Online Quick Card System" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start</label>
                                        <input type="text" wire:model="projects.{{ $index }}.startDate" placeholder="10/2023" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End</label>
                                        <input type="text" wire:model="projects.{{ $index }}.endDate" placeholder="08/2024" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea wire:model="projects.{{ $index }}.description" rows="3" placeholder="Developed a full-stack..." class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                            </div>
                        </div>
                        @endforeach
                        <button wire:click="addProject" class="w-full py-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 hover:text-gray-700 hover:border-gray-400 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Personal Project
                        </button>
                    </div>

                    <!-- Skills Tab -->
                    <div x-show="activeTab === 'skills'" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($skills as $index => $item)
                            <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-lg relative">
                                <button @click.prevent="window.confirm('Are you sure?') ? $wire.removeSkill({{ $index }}) : null" class="absolute top-1 right-1 text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill Category</label>
                                    <input type="text" wire:model="skills.{{ $index }}.name" placeholder="e.g. Programming" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    Enter comma-separated keywords:
                                </div>
                                <input type="text" 
                                       x-data="{ value: @entangle('skills.' . $index . '.keywords') }"
                                       x-on:change="value = $event.target.value.split(',').map(s => s.trim())"
                                       :value="Array.isArray(value) ? value.join(', ') : ''"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                       placeholder="e.g. PHP, Laravel, MySQL">
                            </div>
                            @endforeach
                        </div>
                        <button wire:click="addSkill" class="w-full py-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 hover:text-gray-700 hover:border-gray-400 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Skill Category
                        </button>
                    </div>

                    <!-- More Tab (Achievements, Certs, Languages, Interests) -->
                    <div x-show="activeTab === 'more'" class="space-y-8">
                        <!-- Achievements -->
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Achievements</h4>
                            @foreach($achievements as $index => $item)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" wire:model="achievements.{{ $index }}" placeholder="e.g. Winner of Hackathon" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <button @click.prevent="$wire.removeAchievement({{ $index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            @endforeach
                            <button wire:click="addAchievement" class="mt-2 text-sm text-blue-600 hover:text-blue-500">+ Add Achievement</button>
                        </div>

                        <!-- Certificates -->
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Certificates</h4>
                            @foreach($certificates as $index => $item)
                            <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-lg mb-2 relative">
                                <button @click.prevent="$wire.removeCertificate({{ $index }})" class="absolute top-1 right-1 text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" wire:model="certificates.{{ $index }}.name" placeholder="HackerRank- Java Advance" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <input type="text" wire:model="certificates.{{ $index }}.date" placeholder="05/2025" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                            @endforeach
                            <button wire:click="addCertificate" class="mt-2 text-sm text-blue-600 hover:text-blue-500">+ Add Certificate</button>
                        </div>

                        <!-- Languages -->
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Languages</h4>
                            @foreach($languages as $index => $item)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" wire:model="languages.{{ $index }}.language" placeholder="English" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <input type="text" wire:model="languages.{{ $index }}.fluency" placeholder="Native" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <button @click.prevent="$wire.removeLanguage({{ $index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            @endforeach
                            <button wire:click="addLanguage" class="mt-2 text-sm text-blue-600 hover:text-blue-500">+ Add Language</button>
                        </div>

                        <!-- Interests -->
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Interests</h4>
                            @foreach($interests as $index => $item)
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="text" wire:model="interests.{{ $index }}" placeholder="Artificial Intelligence" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <button @click.prevent="$wire.removeInterest({{ $index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            @endforeach
                            <button wire:click="addInterest" class="mt-2 text-sm text-blue-600 hover:text-blue-500">+ Add Interest</button>
                        </div>
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
