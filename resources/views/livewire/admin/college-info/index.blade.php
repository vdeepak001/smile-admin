<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

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
                                placeholder="Search colleges...">
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
                            <option value="college_name">Sort by Name</option>
                            <option value="created_at">Sort by Date</option>
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

                    <!-- Add New College Button -->
                    <a href="{{ route('college-info.create') }}"
                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg flex-shrink-0 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add New College
                    </a>
                </div>
            </div>

            <!-- College Cards Grid -->
            @if ($collegeInfos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($collegeInfos as $college)
                        <div
                            class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                            <div class="p-6">
                                <!-- Header with Status -->
                                <div class="flex items-start justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate pr-2">
                                        {{ $college->college_name }}
                                    </h3>
                                    @if ($college->active_status)
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

                                <!-- College Details -->
                                <div class="space-y-3 mb-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $college->user->email ?? 'N/A' }}</span>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $college->contact_person }}</span>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-gray-600">Max Students:
                                            {{ $college->max_students }}</span>
                                    </div>

                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-gray-600">Valid Until:
                                            {{ $college->valid_until->format('M d, Y') }}</span>
                                    </div>
                                </div>

                            <!-- Action Buttons -->
                                <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                                    <button wire:click="viewCollege('{{ $college->college_id }}')"
                                        class="flex-1 text-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        View
                                    </button>
                                    <a href="{{ route('college-info.edit', $college) }}"
                                        class="flex-1 text-center px-3 py-2 text-sm font-medium text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                        Edit
                                    </a>
                                    <button wire:click="toggleStatus('{{ $college->college_id }}')"
                                        class="flex-1 px-3 py-2 text-sm font-medium {{ $college->active_status ? 'text-orange-600 bg-orange-50 hover:bg-orange-100' : 'text-green-600 bg-green-50 hover:bg-green-100' }} rounded-lg transition-colors">
                                        {{ $college->active_status ? 'Deactivate' : 'Activate' }}
                                    </button>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $collegeInfos->links('vendor.livewire.tailwind') }}
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m5 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">No college information found.</p>
                    <a href="{{ route('college-info.create') }}"
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
    <x-modal name="view-college-detail" focusable>
        @if($selectedCollege)
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-l-4 border-blue-600 pl-3">
                        College Details
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
                                <p class="text-xs text-gray-500 mb-1">College Name</p>
                                <p class="font-medium text-gray-900">{{ $selectedCollege->college_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status</p>
                                @if ($selectedCollege->active_status)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <p class="font-medium text-gray-900 break-all">{{ $selectedCollege->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Contact Person</p>
                                <p class="font-medium text-gray-900">{{ $selectedCollege->contact_person }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Course & Capacity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Capacity & Validity</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Max Students</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCollege->max_students }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Joined Students</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCollege->students_count }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Valid Until</p>
                                    <p class="font-medium text-gray-900">{{ $selectedCollege->valid_until->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Assigned Courses</h3>
                            <div class="bg-gray-50 rounded-lg p-4 h-full">
                                @if($selectedCollege->courses->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($selectedCollege->courses as $course)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $course->course_name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">No courses assigned</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Meta Info -->
                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Created: {{ $selectedCollege->created_at->format('M d, Y') }}</span>
                            <span>By: {{ $selectedCollege->createdBy?->name ?? 'System' }}</span>
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
