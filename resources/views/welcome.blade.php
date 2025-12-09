<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMILE LMS - Learning Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Inline Tailwind CSS v4.0.7 would go here */
        </style>
    @endif

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
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        .nav-links a:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #667eea;
            cursor: pointer;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
            animation: fadeInUp 0.8s ease;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
            opacity: 0.9;
        }

        .feature-item {
            display: flex;
            gap: 1rem;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .feature-text h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-text p {
            font-size: 0.9rem;
            opacity: 0.85;
        }

        .hero-image {
            animation: float 3s ease-in-out infinite;
        }

        .illustration {
            width: 100%;
            max-width: 500px;
            opacity: 0.9;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .stats-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 3rem 2rem;
            margin-top: 4rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
            color: white;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            font-size: 1rem;
            opacity: 0.85;
        }

        @media (max-width: 768px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 40px 1rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .nav-links {
                gap: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">📚 SMILE LMS</div>
            <ul class="nav-links">
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="btn-secondary">Login</a></li>
                        {{--  @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn-primary">Register</a></li>
                        @endif  --}}
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to SMILE LMS</h1>
            <p>Transform education with our modern Learning Management System. Empower students and educators with
                intuitive tools for seamless learning experiences.</p>

            <div class="hero-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                    {{--  @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    @endif  --}}
                @endauth
            </div>

            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">👨‍🎓</div>
                    <div class="feature-text">
                        <h3>Student Management</h3>
                        <p>Organize and track student progress</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📖</div>
                    <div class="feature-text">
                        <h3>Course Creation</h3>
                        <p>Build engaging learning content</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📊</div>
                    <div class="feature-text">
                        <h3>Analytics</h3>
                        <p>Detailed performance insights</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <svg class="illustration" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                <!-- Decorative illustration -->
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:rgba(255,255,255,0.3);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" />
                    </linearGradient>
                </defs>

                <!-- Background circle -->
                <circle cx="250" cy="250" r="200" fill="url(#grad1)" stroke="rgba(255,255,255,0.2)"
                    stroke-width="2" />

                <!-- Books -->
                <rect x="150" y="150" width="80" height="120" rx="5" fill="rgba(255,255,255,0.2)"
                    stroke="rgba(255,255,255,0.4)" stroke-width="2" />
                <rect x="170" y="170" width="40" height="80" fill="rgba(255,255,255,0.3)" />

                <rect x="270" y="150" width="80" height="120" rx="5" fill="rgba(255,255,255,0.25)"
                    stroke="rgba(255,255,255,0.4)" stroke-width="2" />
                <rect x="290" y="170" width="40" height="80" fill="rgba(255,255,255,0.35)" />

                <!-- Chart lines -->
                <line x1="150" y1="320" x2="350" y2="320" stroke="rgba(255,255,255,0.3)"
                    stroke-width="2" />
                <line x1="150" y1="310" x2="200" y2="280" stroke="rgba(255,255,255,0.4)"
                    stroke-width="2" />
                <line x1="200" y1="280" x2="250" y2="300" stroke="rgba(255,255,255,0.4)"
                    stroke-width="2" />
                <line x1="250" y1="300" x2="300" y2="260" stroke="rgba(255,255,255,0.4)"
                    stroke-width="2" />
                <line x1="300" y1="260" x2="350" y2="290" stroke="rgba(255,255,255,0.4)"
                    stroke-width="2" />

                <!-- Circles for data points -->
                <circle cx="200" cy="280" r="5" fill="rgba(255,255,255,0.6)" />
                <circle cx="250" cy="300" r="5" fill="rgba(255,255,255,0.6)" />
                <circle cx="300" cy="260" r="5" fill="rgba(255,255,255,0.6)" />
            </svg>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>1000+</h3>
                <p>Active Students</p>
            </div>
            <div class="stat-item">
                <h3>500+</h3>
                <p>Courses</p>
            </div>
            <div class="stat-item">
                <h3>98%</h3>
                <p>Satisfaction</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Support</p>
            </div>
        </div>
    </div>
</body>

</html>
