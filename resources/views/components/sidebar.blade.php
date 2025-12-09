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

                   
                </div>
            @endif

            <!-- Divider -->
            <div class="my-4 border-t border-slate-700"></div>

            <!-- Settings Section -->
            <div class="mb-4">
                <p class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Settings</p>

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
