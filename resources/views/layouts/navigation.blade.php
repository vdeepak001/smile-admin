<nav x-data="{ open: false }"
    class="bg-gradient-to-r from-slate-900 to-slate-800 text-white shadow-lg border-b border-slate-700">
    @php
        $dashboardRoute = Auth::user()?->dashboardRouteName();
        $dashboardUrl = $dashboardRoute && Route::has($dashboardRoute) ? route($dashboardRoute) : url('/');
        $dashboardIsActive = $dashboardRoute ? request()->routeIs($dashboardRoute) : false;
    @endphp

    <style>
        .nav-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #e2e8f0;
        }

        .nav-link {
            color: #cbd5f5;
            font-weight: 600;
            transition: all 0.25s ease;
            padding: 0.55rem 1rem;
            border-radius: 10px;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.35), rgba(99, 102, 241, 0.5));
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
        }

        .user-menu-btn {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            color: white;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .user-menu-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(99, 102, 241, 0.35);
        }

        .fullscreen-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #cbd5f5;
            padding: 0.5rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .fullscreen-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        }

        .fullscreen-btn svg {
            width: 20px;
            height: 20px;
        }
    </style>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $dashboardUrl }}" class="nav-logo">
                        📚 SMILE LMS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:flex">
                    <a href="{{ $dashboardUrl }}" class="nav-link {{ $dashboardIsActive ? 'active' : '' }}">
                        {{ __('Dashboard') }}
                    </a>
                </div>
            </div>

            <!-- Right Side: Fullscreen & Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3 sm:ms-6">
                <!-- Fullscreen Toggle Button -->
                <button id="fullscreenToggle" class="fullscreen-btn" title="Toggle Fullscreen">
                    <svg id="fullscreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <svg id="fullscreenExitIcon" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M15 9h4.5M15 9V4.5M15 9l5.25-5.25M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                    </svg>
                </button>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48"
                    contentClasses="py-1 bg-slate-900 border border-slate-700 text-slate-100">
                    <x-slot name="trigger">
                        <button class="user-menu-btn">
                            <div>{{ Auth::user()->isCollege() ? (Auth::user()->collegeAccount->college_name ?? Auth::user()->name) : Auth::user()->name }}</div>

                            <div class="ms-1 inline-block">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-200 hover:text-white hover:bg-slate-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-slate-900 border-t border-slate-700 text-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ $dashboardUrl }}"
                class="block px-4 py-2 text-slate-200 hover:text-white hover:bg-slate-800 rounded">
                {{ __('Dashboard') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-800">
            <div class="px-4 py-2">
                <div class="font-medium text-base text-white">{{ Auth::user()->isCollege() ? (Auth::user()->collegeAccount->college_name ?? Auth::user()->name) : Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-slate-200 hover:text-white hover:bg-slate-800 rounded">
                    {{ __('Profile') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block px-4 py-2 text-slate-200 hover:text-white hover:bg-slate-800 rounded">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Fullscreen Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullscreenToggle = document.getElementById('fullscreenToggle');
            const fullscreenIcon = document.getElementById('fullscreenIcon');
            const fullscreenExitIcon = document.getElementById('fullscreenExitIcon');

            if (fullscreenToggle) {
                // Toggle fullscreen function
                fullscreenToggle.addEventListener('click', function() {
                    if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.mozFullScreenElement && !document.msFullscreenElement) {
                        // Enter fullscreen
                        const elem = document.documentElement;
                        if (elem.requestFullscreen) {
                            elem.requestFullscreen();
                        } else if (elem.webkitRequestFullscreen) { /* Safari */
                            elem.webkitRequestFullscreen();
                        } else if (elem.mozRequestFullScreen) { /* Firefox */
                            elem.mozRequestFullScreen();
                        } else if (elem.msRequestFullscreen) { /* IE11 */
                            elem.msRequestFullscreen();
                        }
                    } else {
                        // Exit fullscreen
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                        } else if (document.webkitExitFullscreen) { /* Safari */
                            document.webkitExitFullscreen();
                        } else if (document.mozCancelFullScreen) { /* Firefox */
                            document.mozCancelFullScreen();
                        } else if (document.msExitFullscreen) { /* IE11 */
                            document.msExitFullscreen();
                        }
                    }
                });

                // Update icon when fullscreen state changes
                function updateFullscreenIcon() {
                    if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
                        fullscreenIcon.style.display = 'none';
                        fullscreenExitIcon.style.display = 'block';
                    } else {
                        fullscreenIcon.style.display = 'block';
                        fullscreenExitIcon.style.display = 'none';
                    }
                }

                // Listen for fullscreen changes
                document.addEventListener('fullscreenchange', updateFullscreenIcon);
                document.addEventListener('webkitfullscreenchange', updateFullscreenIcon);
                document.addEventListener('mozfullscreenchange', updateFullscreenIcon);
                document.addEventListener('MSFullscreenChange', updateFullscreenIcon);
            }
        });
    </script>
</nav>
