<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('College Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-2">
                        {{ __("Welcome, " . (auth()->user()->collegeAccount->college_name ?? auth()->user()->name) . "!") }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Manage your college students and view their progress
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Students Management -->
                <a href="{{ route('college.students.index') }}" class="block group">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide opacity-90">Students</p>
                                <h3 class="text-2xl font-bold mt-1">
                                    {{ \App\Models\Student::whereHas('user', function($q) {
                                        $q->where('college_id', auth()->user()->collegeAccount->college_id);
                                    })->count() }}
                                </h3>
                                <p class="text-xs mt-1 opacity-90">Total Students</p>
                            </div>
                            <div class="text-white opacity-75">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-white text-xs font-semibold group-hover:translate-x-1 transition-transform">
                            View All Students
                            <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Active Students -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide opacity-90">Active</p>
                            <h3 class="text-2xl font-bold mt-1">
                                {{ \App\Models\Student::whereHas('user', function($q) {
                                    $q->where('college_id', auth()->user()->collegeAccount->college_id);
                                })->where('active_status', true)->count() }}
                            </h3>
                            <p class="text-xs mt-1 opacity-90">Active Students</p>
                        </div>
                        <div class="text-white opacity-75">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Inactive Students -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-4">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide opacity-90">Inactive</p>
                            <h3 class="text-2xl font-bold mt-1">
                                {{ \App\Models\Student::whereHas('user', function($q) {
                                    $q->where('college_id', auth()->user()->collegeAccount->college_id);
                                })->where('active_status', false)->count() }}
                            </h3>
                            <p class="text-xs mt-1 opacity-90">Inactive Students</p>
                        </div>
                        <div class="text-white opacity-75">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Course Assign -->
                <a href="#" class="block group">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide opacity-90">Courses</p>
                                <h3 class="text-2xl font-bold mt-1">
                                    {{ \App\Models\Course::whereHas('colleges', function($q) {
                                        $q->where('college_course.college_id', auth()->user()->collegeAccount->college_id);
                                    })->count() }}
                                </h3>
                                <p class="text-xs mt-1 opacity-90">Assigned Courses</p>
                            </div>
                            <div class="text-white opacity-75">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-white text-xs font-semibold group-hover:translate-x-1 transition-transform">
                            <!-- Manage Courses -->
                            <!-- <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg> -->
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
