<aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white overflow-y-auto shadow-lg">
    <!-- Logo Section -->
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-lg flex items-center justify-center font-bold text-lg">
                S
            </div>
            <div>
                <h1 class="text-xl font-bold">SMILE LMS</h1>
                @php
                    $panelLabel = 'Panel';
                    if (Auth::user()?->isAdmin()) {
                        $panelLabel = 'Admin Panel';
                    } elseif (Auth::user()?->isCollege()) {
                        $panelLabel = 'College Panel';
                    } elseif (Auth::user()?->isStudent()) {
                        $panelLabel = 'Student Panel';
                    }
                @endphp
                <p class="text-xs text-slate-400">{{ $panelLabel }}</p>
            </div>
        </div>
    </div>

    @php
        $dashboardRoute = Auth::user()?->dashboardRouteName();
        $dashboardUrl = $dashboardRoute && Route::has($dashboardRoute) ? route($dashboardRoute) : url('/');
        $isAdmin = Auth::user()?->isAdmin();
        $isCollege = Auth::user()?->isCollege();
    @endphp

    <!-- Navigation Menu -->
    <nav class="p-4">
        <div class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ $dashboardUrl }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                {{ request()->url() === $dashboardUrl ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Divider -->
            <div class="my-4 border-t border-slate-700"></div>

            <!-- College Students Section (College Users Only) -->
            @if ($isCollege)
                <div class="mb-4">
                    <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Management</p>

                    <a href="{{ route('college.students.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                        {{ Route::currentRouteName() === 'college.students.index' || Route::currentRouteName() === 'college.students.edit' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        <span class="font-medium">College Students</span>
                    </a>

                    <a href="{{ route('college.course-reports.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                        {{ Route::currentRouteName() === 'college.course-reports.index' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="font-medium">Course Reports</span>
                    </a>
                </div>

                <!-- Divider -->
                <div class="my-4 border-t border-slate-700"></div>
            @endif

            <!-- College Info Section -->
            @if ($isAdmin)
                <div class="mb-4">
                    <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Management</p>

                    <a href="{{ route('college-info.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                        {{ Route::currentRouteName() === 'college-info.index' || Route::currentRouteName() === 'college-info.create' || Route::currentRouteName() === 'college-info.edit' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m5 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="font-medium">Colleges</span>
                    </a>

                     <a href="{{ route('students.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                    {{ Route::currentRouteName() === 'students.index' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        <span class="font-medium">Students</span>
                    </a>

                   

                       <a href="{{ route('users.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                    {{ Route::currentRouteName() === 'users.index' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a9 9 0 00-9 9v2h18v-2a9 9 0 00-9-9z">
                            </path>
                        </svg>
                        <span class="font-medium">Users</span>
                    </a>
                      <!-- Divider -->
            <div class="my-4 border-t border-slate-700"></div>

                     <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Course Details</p>

                      <a href="{{ route('courses.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                    {{ Route::currentRouteName() === 'courses.index' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z">
                            </path>
                        </svg>
                        <span class="font-medium">Courses</span>
                    </a>

                    <a href="{{ route('course-topics.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                    {{ Route::currentRouteName() === 'course-topics.index' || Route::currentRouteName() === 'course-topics.create' || Route::currentRouteName() === 'course-topics.edit' || Route::currentRouteName() === 'course-topics.show' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="font-medium">Topics</span>
                    </a>

                     <a href="{{ route('questions.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                    {{ Route::currentRouteName() === 'questions.index' || Route::currentRouteName() === 'questions.create' || Route::currentRouteName() === 'questions.edit' || Route::currentRouteName() === 'questions.show' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span class="font-medium">Questions</span>
                    </a>

                      

                

                   

                

                 

                   
                </div>
            @endif

            <!-- Divider -->
            <div class="my-4 border-t border-slate-700"></div>

            <!-- Settings Section -->
            <div class="mb-4">
                <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Settings</p>

                @if ($isAdmin)
                    <a href="{{ route('degrees.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200
                    {{ Route::currentRouteName() === 'degrees.index' || Route::currentRouteName() === 'degrees.create' || Route::currentRouteName() === 'degrees.edit' ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="font-medium">Degrees</span>
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 text-slate-300 hover:bg-red-600 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</aside>
