<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats -->
            

            <!-- Filters & Actions -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="flex items-center gap-4 overflow-x-auto">
                    <!-- Search -->
                    <div class="w-[250px] flex-shrink-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Search by name, email, or enrollment no...">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 flex-shrink-0">
                        <!-- College Filter -->
                        <select wire:model.live="selectedCollege"
                            class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="">All Colleges</option>
                            @foreach ($colleges as $college)
                                <option value="{{ $college->college_id }}">{{ $college->college_name }}</option>
                            @endforeach
                        </select>

                        <!-- Status Filter -->
                        <select wire:model.live="filter"
                            class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <!-- Sort Dropdown -->
                        <div class="relative flex-shrink-0 flex items-center gap-2">
                            <select wire:model.live="sortField"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="created_at">Sort by Date</option>
                                <option value="enrollment_no">Sort by Enrollment</option>
                                <option value="active_status">Sort by Status</option>
                            </select>
                            <button wire:click="$set('sortDirection', '{{ $sortDirection === 'asc' ? 'desc' : 'asc' }}')"
                                class="p-2 text-gray-400 hover:text-gray-600 border border-gray-300 rounded-lg bg-white">
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

                        <!-- Action Buttons Group -->
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <!-- Add New Button -->
                            <!-- <a href="{{ route('students.create') }}"
                                class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg whitespace-nowrap">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                    </path>
                                </svg>
                                Add Student
                            </a> -->

                            <!-- Bulk Import Button -->
                            <a href="{{ route('students.import.form') }}"
                                class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg whitespace-nowrap">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                Bulk Import
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Cards Grid -->
            @if ($students->count() > 0)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name / Email
                                    </th>
                                    <!-- <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Enrollment No
                                    </th> -->
                                    <!-- <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        College
                                    </th> -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone No
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Degree
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Specialization
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Reg Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                                        {{ strtoupper(substr($student->user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $student->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $student->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-semibold">{{ $student->enrollment_no }}</div>
                                        </td> -->
                                        <!-- <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $student->user->college->college_name ?? 'N/A' }}</div>
                                        </td> -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $student->user->phone_number ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $student->degree->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $student->specialization ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $student->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($student->active_status)
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <button wire:click="viewCourses('{{ $student->student_id }}')"
                                                    class="text-purple-600 hover:text-purple-900" title="Course Assigned">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </button>
                                                <a href="{{ route('students.edit', $student) }}"
                                                    class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <button wire:click="toggleStatus({{ $student->student_id }})"
                                                    class="{{ $student->active_status ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}"
                                                    title="{{ $student->active_status ? 'Deactivate' : 'Activate' }}">
                                                    @if($student->active_status)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @endif
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $students->links('vendor.livewire.tailwind') }}
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">No students found.</p>
                    <a href="{{ route('students.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add Student
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- View Student Detail Modal -->
    <x-modal name="view-student-detail" focusable>
        @if($selectedStudent)
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 border-l-4 border-blue-600 pl-3">
                        Student Details
                    </h2>
                    <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- User Information -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">User Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Full Name</p>
                                <p class="font-medium text-gray-900">{{ $selectedStudent->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Status</p>
                                @if ($selectedStudent->active_status)
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
                                <p class="font-medium text-gray-900">{{ $selectedStudent->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Phone</p>
                                <p class="font-medium text-gray-900">{{ $selectedStudent->user->phone_number ?? 'N/A' }}</p>
                            </div>
                             <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">College</p>
                                <p class="font-medium text-gray-900">{{ $selectedStudent->user->college->college_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Student Information -->
                    <div>
                         <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Student Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Enrollment No</p>
                                <p class="font-medium text-gray-900">{{ $selectedStudent->enrollment_no }}</p>
                            </div>

                             <div>
                                <p class="text-xs text-gray-500 mb-1">Date of Birth</p>
                                <p class="font-medium text-gray-900">{{ $selectedStudent->date_of_birth ? $selectedStudent->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                            </div>

                        </div>
                    </div>

                    <!-- Meta Info -->
                    <div class="border-t border-gray-100 pt-4 text-xs text-gray-500 flex justify-between">
                         <span>Created: {{ $selectedStudent->created_at->format('M d, Y H:i') }}</span>
                         <span>By: {{ $selectedStudent->createdBy->name ?? 'System' }}</span>
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

    <!-- View Courses Modal -->
    <x-modal name="view-courses-modal" :show="false" maxWidth="2xl" focusable>
        @if($selectedStudent)
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 border-l-4 border-purple-600 pl-3">
                            Course Assignments
                        </h2>
                        <p class="text-sm text-gray-600 mt-2 pl-3">
                            Student: <span class="font-medium">{{ $selectedStudent->user->name }}</span> 
                            ({{ $selectedStudent->enrollment_no }})
                        </p>
                    </div>
                    <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Courses Table -->
                @if(count($assignedCourses) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course Code
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Assigned On
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Assigned By
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($assignedCourses as $index => $assignedCourse)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $assignedCourse->course->course_name ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-mono">{{ $assignedCourse->course->course_code ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'not_started' => 'bg-gray-100 text-gray-800',
                                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                ];
                                                $statusLabels = [
                                                    'not_started' => 'Not Started',
                                                    'in_progress' => 'In Progress',
                                                    'completed' => 'Completed',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusColors[$assignedCourse->completion_status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusLabels[$assignedCourse->completion_status] ?? ucfirst(str_replace('_', ' ', $assignedCourse->completion_status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $assignedCourse->assigned_on ? \Carbon\Carbon::parse($assignedCourse->assigned_on)->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $assignedCourse->assignedBy->name ?? 'System' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="text-gray-500 text-lg">No courses assigned to this student yet.</p>
                    </div>
                @endif

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
