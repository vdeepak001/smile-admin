<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMILE LMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind fallback so layout/cards/sidebar keep styling even if Vite hasn't built -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css">

    @livewireStyles

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            width: 100%;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #f8fafc;
        }

        .app-container {
            display: flex;
            flex-direction: row;
            height: 100vh;
            width: 100%;
        }

        .sidebar-wrapper {
            width: 256px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .sidebar-wrapper aside {
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: calc(100% - 256px);
            min-width: 0;
        }

        .sidebar-wrapper:not(.show)~.main-content {
            width: 100%;
        }

        .app-main {
            flex: 1;
            background: linear-gradient(135deg, #f0f4ff 0%, #f5f0ff 100%);
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .sidebar-wrapper {
                display: none !important;
            }

            .main-content {
                width: 100%;
            }

            .app-main {
                padding: 1rem;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="app-container">
        @auth
            <div class="sidebar-wrapper show">
                <x-sidebar />
            </div>
        @endauth

        <div class="main-content">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gradient-to-r from-slate-900 to-slate-800 text-white shadow-md border-b border-slate-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-3xl font-bold tracking-tight">
                            {{ $header }}
                        </h1>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="app-main">
                {{ $slot }}
            </main>
        </div>
    </div>

    @include('partials.toast')

    @livewireScripts
</body>

</html>
