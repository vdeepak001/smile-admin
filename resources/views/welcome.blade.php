<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMILE LMS - Learning Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
            font-family: 'Inter', sans-serif;
            background: #0a0a0f;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Gradient Background */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0.9;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(252, 70, 107, 0.3), transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(99, 102, 241, 0.3), transparent 50%);
            animation: morphGradient 15s ease infinite;
        }

        @keyframes morphGradient {
            0%, 100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.1) translateY(-20px);
            }
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: float-particle linear infinite;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 0;
            }
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.2rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            filter: drop-shadow(0 2px 8px rgba(255, 255, 255, 0.2));
        }

        .logo-icon {
            font-size: 2.5rem;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
            animation: pulse-icon 2s ease-in-out infinite;
        }

        @keyframes pulse-icon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            border-radius: 12px;
        }

        .nav-links a:hover::before {
            transform: scaleX(1);
        }

        .nav-links a:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.85rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            display: inline-block;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.85rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.2);
        }

        /* Hero Section */
        .hero {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
            color: white;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 0.8s ease both;
            letter-spacing: -2px;
        }

        .hero-content .subtitle {
            font-size: 1.4rem;
            margin-bottom: 3rem;
            opacity: 0.95;
            line-height: 1.7;
            animation: fadeInUp 0.8s ease 0.2s both;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.95);
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease 0.4s both;
            margin-bottom: 4rem;
        }

        /* Feature Cards */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease 0.6s both;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 1.8rem;
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.2rem;
            transition: transform 0.4s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-text h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: white;
        }

        .feature-text p {
            font-size: 0.95rem;
            opacity: 0.85;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Hero Illustration */
        .hero-visual {
            position: relative;
            animation: float 4s ease-in-out infinite;
        }

        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: pulse 3s ease-in-out infinite;
            z-index: -1;
        }

        .orb-1 {
            width: 300px;
            height: 300px;
            background: rgba(99, 102, 241, 0.4);
            top: -50px;
            right: -50px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 250px;
            height: 250px;
            background: rgba(236, 72, 153, 0.4);
            bottom: -30px;
            left: -30px;
            animation-delay: 1.5s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: rgba(168, 85, 247, 0.4);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 3s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        .visual-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .visual-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .illustration {
            width: 100%;
            max-width: 500px;
            opacity: 0.95;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-30px);
            }
        }

        /* Stats Section */
        .stats-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 80px;
            position: relative;
            z-index: 1;
        }

        .stats-container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            padding: 4rem 3rem;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .stats-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), transparent);
            pointer-events: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .stat-item {
            padding: 2rem 1rem;
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-8px);
        }

        .stat-item h3 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 60px 2rem;
                gap: 4rem;
            }

            .hero-content h1 {
                font-size: 3.5rem;
            }

            .hero-visual {
                order: -1;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 1.5rem;
            }

            .logo {
                font-size: 1.5rem;
            }

            .logo-icon {
                font-size: 2rem;
            }

            .nav-links {
                gap: 0.5rem;
            }

            .nav-links a {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }

            .btn-primary, .btn-secondary {
                padding: 0.65rem 1.2rem;
                font-size: 0.9rem;
            }

            .hero {
                padding: 40px 1.5rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                letter-spacing: -1px;
            }

            .hero-content .subtitle {
                font-size: 1.1rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-item h3 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="gradient-bg"></div>

    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle" style="left: 10%; width: 4px; height: 4px; animation-duration: 15s; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; width: 6px; height: 6px; animation-duration: 20s; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; width: 3px; height: 3px; animation-duration: 18s; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; width: 5px; height: 5px; animation-duration: 22s; animation-delay: 1s;"></div>
        <div class="particle" style="left: 50%; width: 4px; height: 4px; animation-duration: 19s; animation-delay: 5s;"></div>
        <div class="particle" style="left: 60%; width: 6px; height: 6px; animation-duration: 21s; animation-delay: 3s;"></div>
        <div class="particle" style="left: 70%; width: 3px; height: 3px; animation-duration: 17s; animation-delay: 6s;"></div>
        <div class="particle" style="left: 80%; width: 5px; height: 5px; animation-duration: 23s; animation-delay: 2s;"></div>
        <div class="particle" style="left: 90%; width: 4px; height: 4px; animation-duration: 16s; animation-delay: 7s;"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span class="logo-icon">📚</span>
                <a href="{{ url('/') }}"><span>SMILE LMS</span></a>
            </div>
            <ul class="nav-links">
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="btn-secondary">Login</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1>Transform Learning Excellence</h1>
            <p class="subtitle">Experience the future of education with SMILE LMS. Empower students and educators with intuitive, AI-powered tools for seamless and engaging learning journeys.</p>

            <div class="hero-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                @endauth
            </div>

            <div id="features" class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👨‍🎓</div>
                    <div class="feature-text">
                        <h3>Student Management</h3>
                        <p>Track progress & performance effortlessly</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📖</div>
                    <div class="feature-text">
                        <h3>Course Creation</h3>
                        <p>Build engaging, interactive content</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <div class="feature-text">
                        <h3>Analytics</h3>
                        <p>Real-time performance insights</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="glow-orb orb-1"></div>
            <div class="glow-orb orb-2"></div>
            <div class="glow-orb orb-3"></div>
            
            <div class="visual-card">
                <svg class="illustration" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:rgba(255,255,255,0.4);stop-opacity:1" />
                            <stop offset="100%" style="stop-color:rgba(255,255,255,0.2);stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="grad2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:0.8" />
                            <stop offset="100%" style="stop-color:#764ba2;stop-opacity:0.8" />
                        </linearGradient>
                    </defs>

                    <!-- Main Circle -->
                    <circle cx="250" cy="250" r="200" fill="url(#grad1)" stroke="rgba(255,255,255,0.3)" stroke-width="3">
                        <animate attributeName="r" values="200;210;200" dur="3s" repeatCount="indefinite"/>
                    </circle>

                    <!-- Book Stack -->
                    <g opacity="0.9">
                        <rect x="140" y="140" width="90" height="130" rx="8" fill="rgba(255,255,255,0.25)" stroke="rgba(255,255,255,0.5)" stroke-width="3" />
                        <rect x="160" y="160" width="50" height="90" fill="url(#grad2)" opacity="0.6"/>
                        <line x1="160" y1="180" x2="210" y2="180" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
                        <line x1="160" y1="200" x2="210" y2="200" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
                    </g>

                    <g opacity="0.9">
                        <rect x="270" y="140" width="90" height="130" rx="8" fill="rgba(255,255,255,0.3)" stroke="rgba(255,255,255,0.5)" stroke-width="3" />
                        <rect x="290" y="160" width="50" height="90" fill="url(#grad2)" opacity="0.7"/>
                        <line x1="290" y1="180" x2="340" y2="180" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
                        <line x1="290" y1="200" x2="340" y2="200" stroke="rgba(255,255,255,0.6)" stroke-width="2"/>
                    </g>

                    <!-- Chart -->
                    <g opacity="0.9">
                        <rect x="140" y="300" width="220" height="120" rx="12" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        
                        <!-- Chart bars -->
                        <rect x="160" y="360" width="30" height="40" rx="4" fill="url(#grad2)" opacity="0.8">
                            <animate attributeName="height" values="40;60;40" dur="2s" repeatCount="indefinite"/>
                            <animate attributeName="y" values="360;340;360" dur="2s" repeatCount="indefinite"/>
                        </rect>
                        <rect x="210" y="340" width="30" height="60" rx="4" fill="url(#grad2)" opacity="0.8">
                            <animate attributeName="height" values="60;50;60" dur="2s" begin="0.5s" repeatCount="indefinite"/>
                            <animate attributeName="y" values="340;350;340" dur="2s" begin="0.5s" repeatCount="indefinite"/>
                        </rect>
                        <rect x="260" y="330" width="30" height="70" rx="4" fill="url(#grad2)" opacity="0.8">
                            <animate attributeName="height" values="70;80;70" dur="2s" begin="1s" repeatCount="indefinite"/>
                            <animate attributeName="y" values="330;320;330" dur="2s" begin="1s" repeatCount="indefinite"/>
                        </rect>
                        <rect x="310" y="350" width="30" height="50" rx="4" fill="url(#grad2)" opacity="0.8">
                            <animate attributeName="height" values="50;65;50" dur="2s" begin="1.5s" repeatCount="indefinite"/>
                            <animate attributeName="y" values="350;335;350" dur="2s" begin="1.5s" repeatCount="indefinite"/>
                        </rect>
                    </g>

                    <!-- Floating elements -->
                    <circle cx="100" cy="100" r="8" fill="rgba(255,255,255,0.6)">
                        <animate attributeName="cy" values="100;80;100" dur="3s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="400" cy="150" r="6" fill="rgba(255,255,255,0.5)">
                        <animate attributeName="cy" values="150;130;150" dur="4s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="420" cy="350" r="10" fill="rgba(255,255,255,0.6)">
                        <animate attributeName="cy" values="350;330;350" dur="3.5s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div id="about" class="stats-section">
        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Active Students</p>
                </div>
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Quality Courses</p>
                </div>
                <div class="stat-item">
                    <h3>98%</h3>
                    <p>Satisfaction Rate</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>Expert Support</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
