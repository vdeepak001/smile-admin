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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guest-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .guest-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            animation: slideUp 0.6s ease;
        }

        .guest-logo {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 3rem;
        }

        .guest-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 700;
            text-align: center;
        }

        .guest-subtitle {
            color: #666;
            font-size: 0.95rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .guest-container {
                padding: 1rem;
            }

            .guest-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="guest-container">
        <div class="guest-card">
            <div class="guest-logo">📚</div>
            <h1 class="guest-title">SMILE LMS</h1>
            <p class="guest-subtitle">Learning Management System</p>

            {{ $slot }}
        </div>
    </div>

    @include('partials.toast')
</body>

</html>
