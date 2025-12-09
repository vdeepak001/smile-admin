<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Course Assignments') }}
            </h2>
            <a href="{{ route('students.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Student Info Card -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16">
                            <div class="h-16 w-16 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 flex items-center justify-center text-white font-bold text-2xl">
                                {{ strtoupper(substr($student->user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $student->user->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $student->user->email }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-sm font-medium text-gray-700">
                                    <span class="text-gray-500">Enrollment:</span> {{ $student->enrollment_no }}
                                </span>
                                <span class="text-sm font-medium text-gray-700">
                                    <span class="text-gray-500">College:</span> {{ $student->user->college->college_name ?? 'N/A' }}
                                </span>
                                @if($student->degree)
                                    <span class="text-sm font-medium text-gray-700">
                                        <span class="text-gray-500">Degree:</span> {{ $student->degree->degree_name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($student->active_status)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <!-- Assigned Courses -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-blue-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Assigned Courses ({{ $assignedCourses->count() }})
                    </h3>
                </div>

                @if($assignedCourses->count() > 0)
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
                                        Completion Status
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
                        <p class="text-gray-500 text-lg mb-4">No courses assigned to this student yet.</p>
                        <a href="{{ route('students.edit', $student) }}" 
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Assign Courses
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
