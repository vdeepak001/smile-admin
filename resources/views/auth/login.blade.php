<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMILE LMS - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

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

        .login-container {
            width: 100%;
            max-width: 900px;
            padding: 2rem;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease;
        }

        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 4rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .login-logo {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .login-left h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .login-left p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .login-features {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            text-align: left;
        }

        .feature {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .feature-icon {
            font-size: 1.5rem;
            min-width: 30px;
        }

        .feature-text h3 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .feature-text p {
            font-size: 0.85rem;
            opacity: 0.85;
        }

        .login-right {
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .login-right>p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .remember-me label {
            cursor: pointer;
            color: #666;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .signup-link {
            text-align: center;
            color: #666;
            font-size: 0.95rem;
        }

        .signup-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #764ba2;
        }

        .status-message {
            background: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid #a7f3d0;
            font-size: 0.9rem;
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

        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .login-left {
                display: none;
            }

            .login-right {
                padding: 2rem;
            }

            .login-right h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Left Side - Branding -->
            <div class="login-left">
                <div class="login-logo">📚</div>
                <h2>Welcome to SMILE LMS</h2>
                <p>Transform your educational journey with our comprehensive learning management system</p>

                <div class="login-features">
                    <div class="feature">
                        <div class="feature-icon">🎯</div>
                        <div class="feature-text">
                            <h3>Personalized Learning</h3>
                            <p>Adaptive learning paths tailored to your pace</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📊</div>
                        <div class="feature-text">
                            <h3>Track Progress</h3>
                            <p>Real-time analytics and performance insights</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🤝</div>
                        <div class="feature-text">
                            <h3>Collaborate</h3>
                            <p>Connect with peers and instructors seamlessly</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📚</div>
                        <div class="feature-text">
                            <h3>Rich Content</h3>
                            <p>Access diverse learning materials anytime</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-right">
                <h1>Sign In</h1>
                <p>Access your account to continue learning</p>

                @if ($errors->any())
                    <div class="status-message" style="background: #fee2e2; color: #991b1b; border-color: #fecaca;">
                        <strong>Login Failed</strong>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')"
                            placeholder="your@email.com" required autofocus autocomplete="username" />
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="••••••••" required
                            autocomplete="current-password" />
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <div class="remember-me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <label for="remember_me">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">Sign In</button>
                </form>

                <!-- Sign Up Link -->
                {{--  @if (Route::has('register'))
                    <div class="signup-link">
                        Don't have an account?
                        <a href="{{ route('register') }}">Create one here</a>
                    </div>
                @endif  --}}
            </div>
        </div>
    </div>
</body>

</html>
