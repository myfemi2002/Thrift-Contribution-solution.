@php
$assetBase = asset('backend/assets');
@endphp
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard Login">
    <meta name="author" content="Admin Dashboard">
    
    <title>@yield('title', 'Login - Admin Dashboard')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $assetBase }}/img/favicon.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/bootstrap.min.css">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/Font-Awesome/css/all.css') }}">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/style.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/toaster/toastr.css') }}">

    <!-- Custom Styling -->
    <style>
        :root {
            --primary: #2660B5;
            --primary-dark: #1a4a8f;
            --secondary: #EB7A23;
            --dark: #1E293B;
            --light: #F8FAFC;
            --gray: #64748B;
            --border: #E2E8F0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            color: var(--dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ $assetBase }}/img/background.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        
        .login-container {
            position: relative;
            z-index: 2;
            display: flex;
            width: 1000px;
            max-width: 95%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .login-branding {
            display: none;
            background-color: var(--primary);
            color: white;
            width: 40%;
            padding: 30px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        
        @media (min-width: 992px) {
            .login-branding {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        }
        
        .login-branding-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .login-logo {
            width: 180px;
            height: auto;
            margin-bottom: 30px;
            position: relative;
        }
        
        .login-tagline {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
        }
        
        .login-benefits {
            position: relative;
            text-align: left;
            margin-top: 30px;
        }
        
        .login-benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .login-benefit-icon {
            margin-right: 15px;
            min-width: 24px;
            font-size: 24px;
            color: var(--secondary);
        }
        
        .login-benefit-text {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .login-form-container {
            width: 100%;
            padding: 40px;
        }
        
        @media (min-width: 992px) {
            .login-form-container {
                width: 60%;
            }
        }
        
        .login-form-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .login-form-subtitle {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 30px;
        }
        
        .login-mobile-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        @media (min-width: 992px) {
            .login-mobile-logo {
                display: none;
            }
        }
        
        .login-mobile-logo img {
            height: 40px;
            width: auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(38, 96, 181, 0.2);
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
        }
        
        .login-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .login-btn i {
            margin-right: 10px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--gray);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .invalid-feedback {
            color: #e11d48;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <!-- Main Wrapper -->
    <div class="login-container">
        <!-- Branding Side -->
        <div class="login-branding">
            <div class="login-branding-pattern"></div>
            <img src="{{ asset('frontend/assets/images/logo/logo-light.png') }}" alt="Admin Dashboard Logo" class="login-logo">
            <h2 class="login-tagline">Welcome to Admin Dashboard</h2>
            <p>Manage your business with ease</p>
            
            <div class="login-benefits">
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="login-benefit-text">
                        Access comprehensive analytics and reporting tools
                    </div>
                </div>
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="login-benefit-text">
                        Secure platform with advanced data protection
                    </div>
                </div>
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="login-benefit-text">
                        Effortlessly manage users and permissions
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="login-form-container">
            <div class="login-mobile-logo bg-primary">
            <img src="{{ asset('frontend/assets/images/logo/logo-light.png') }}" alt="NexTrade Logo" class="auth-logo">
            </div>
            
            <h1 class="login-form-title">Sign In</h1>
            <p class="login-form-subtitle">Enter your credentials to access your account</p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-info mb-4">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="your.email@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-toggle">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your password">
                        <span class="password-toggle-icon" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="remember_me"
                                       name="remember">
                                <label class="form-check-label" for="remember_me">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <button class="login-btn" type="submit">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign In</span>
                </button>
                
                @if (Route::has('register'))
                    <div class="register-link">
                        <p>
                            Don't have an account? 
                            <a href="{{ route('register') }}">Create Account</a>
                        </p>
                    </div>
                @endif
            </form>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="{{ $assetBase }}/js/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap Core JS -->
    <script src="{{ $assetBase }}/js/bootstrap.bundle.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="{{ asset('backend/assets/toaster/toastr.min.js') }}"></script>
    
    <!-- Custom JS -->
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.password-toggle-icon i');
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        
        // Toastr notifications
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>
</body>
</html>