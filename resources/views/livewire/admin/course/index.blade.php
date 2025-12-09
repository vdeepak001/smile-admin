<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

           
            
            <!-- Stats -->
            

            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search, Filter, and Sort Controls -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <!-- Search Bar -->
                    <div class="flex-1 min-w-[200px]">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Search courses...">
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button wire:click="$set('filter', 'all')"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All ({{ $totalCount }})
                        </button>
                        <button wire:click="$set('filter', 'active')"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ $filter === 'active' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Active ({{ $activeCount }})
                        </button>
                        <button wire:click="$set('filter', 'inactive')"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap {{ $filter === 'inactive' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Inactive ({{ $inactiveCount }})
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative flex-shrink-0">
                        <select wire:model.live="sortField"
                            class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="course_name">Sort by Name</option>
                            <option value="inserted_on">Sort by Date</option>
                            <option value="active_status">Sort by Status</option>
                        </select>
                        <button wire:click="$set('sortDirection', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600">
                            @if ($sortDirection === 'asc')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </button>
                    </div>

                    <!-- Add New Course Button -->
                    <a href="{{ route('courses.create') }}"
                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg flex-shrink-0 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add New Course
                    </a>
                </div>
            </div>

            <!-- Course Cards Grid -->
            @if ($courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <div
                            class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                            @if ($course->course_pic)
                                <img src="{{ \Storage::url($course->course_pic) }}" alt="{{ $course->course_name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <!-- Header with Status -->
                                <div class="flex items-start justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate pr-2">
                                        {{ $course->course_name }}
                                    </h3>
                                    @if ($course->active_status)
                                        <span
                                            class="inline-flex px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full whitespace-nowrap">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full whitespace-nowrap">
                                            Inactive
                                        </span>
                                    @endif
                                </div>

                                <!-- Course Details -->
                                <div class="space-y-3 mb-4">
                                    @if ($course->description)
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $course->description }}</p>
                                    @endif



                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-bold text-gray-900">{{ $course->test_questions ?? 'N/A' }}</span>
                                        </div>

                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-bold text-gray-900">{{ $course->percent_require }}%</span>
                                        </div>
                                    </div>




                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                                    <button wire:click="viewCourse({{ $course->course_id }})"
                                        class="flex-1 text-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        View
                                    </button>
                                    <a href="{{ route('courses.edit', $course) }}"
                                        class="flex-1 text-center px-3 py-2 text-sm font-medium text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                        Edit
                                    </a>
                                    <button wire:click="toggleStatus({{ $course->course_id }})"
                                        class="flex-1 px-3 py-2 text-sm font-medium {{ $course->active_status ? 'text-orange-600 bg-orange-50 hover:bg-orange-100' : 'text-green-600 bg-green-50 hover:bg-green-100' }} rounded-lg transition-colors">
                                        {{ $course->active_status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                   

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $courses->links('vendor.livewire.tailwind') }}
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">No courses found.</p>
                    <a href="{{ route('courses.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Create one now
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- View Detail Modal -->
    <x-modal name="view-course-detail" focusable>
        @if($selectedCourse)
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-l-4 border-blue-600 pl-3">
                        Course Details
                    </h2>
                    <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Basic Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Course Name</p>
                                <p class="font-medium text-gray-900">{{ $selectedCourse->course_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status</p>
                                @if ($selectedCourse->active_status)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                         @if ($selectedCourse->description)
                            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Description</p>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $selectedCourse->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Course Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Requirements</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Test Questions</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCourse->test_questions }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Percent Required</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCourse->percent_require }}%</p>
                                </div>
                            </div>
                        </div>
                         <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Meta Info</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Inserted By</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCourse->insertedBy?->name ?? 'System' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Inserted On</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCourse->inserted_on ? $selectedCourse->inserted_on->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button x-on:click="$dispatch('close')" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        @endif
    </x-modal>
</div>
