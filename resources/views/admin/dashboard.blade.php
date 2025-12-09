<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-8">
                <x-dashboard-card title="Total Colleges" value="{{ $totalColleges ?? 0 }}" icon="building" color="blue"
                    :trend="5" />

                <x-dashboard-card title="Active Courses" value="{{ $activeCourses ?? 0 }}" icon="book" color="green"
                    :trend="12" />

                <x-dashboard-card title="Total Users" value="{{ $totalUsers ?? 0 }}" icon="users" color="purple"
                    :trend="8" />

                <x-dashboard-card title="Completed Courses" value="{{ $completedCourses ?? 0 }}" icon="check"
                    color="yellow" :trend="3" />

                <x-dashboard-card title="Total Students" value="{{ $totalStudents ?? 0 }}" icon="academic-cap"
                    color="indigo" :trend="10" />
            </div>

            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        You're logged in as an Administrator. Use the sidebar to navigate to different sections of the
                        application.
                    </p>

                    <!-- Quick Links -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('college-info.index') }}"
                            class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m5 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Manage Colleges</h4>
                                <p class="text-sm text-gray-600">View and manage college information</p>
                            </div>
                        </a>

                        <a href="{{ route('courses.index') }}"
                            class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z">
                                </path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Manage Courses</h4>
                                <p class="text-sm text-gray-600">Create and manage courses</p>
                            </div>
                        </a>

                        <a href="{{ route('users.index') }}"
                            class="flex items-center p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a9 9 0 00-9 9v2h18v-2a9 9 0 00-9-9z">
                                </path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Manage Users</h4>
                                <p class="text-sm text-gray-600">View and manage user accounts</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
