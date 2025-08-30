@php
$assetBase = asset('backend/assets');
@endphp
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ThriftSave - Secure login to manage your thrift contributions, track savings, and achieve your financial goals">
    <meta name="author" content="ThriftSave">
    <meta name="keywords" content="thrift login, savings account, contribution management, secure login, financial platform">
    
    <title>@yield('title', 'Login - ThriftSave | Smart Thrift Contributions Platform')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $assetBase }}/img/thriftsave-favicon.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/bootstrap.min.css">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/style.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/toaster/toastr.css') }}">

    <!-- Custom Styling -->
    <style>
        :root {
            --primary: #28a745;
            --primary-dark: #1e7e34;
            --secondary: #17a2b8;
            --accent: #ffc107;
            --dark: #1E293B;
            --light: #F8FAFC;
            --gray: #64748B;
            --border: #E2E8F0;
            --success: #28a745;
            --info: #17a2b8;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: var(--dark);
            margin: 0;
            padding: 20px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }
        
        .login-container {
            position: relative;
            z-index: 2;
            display: flex;
            width: 900px;
            max-width: 95%;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-height: 85vh;
        }
        
        .login-branding {
            display: none;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            width: 40%;
            padding: 25px;
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
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M20 20c0-11.046-8.954-20-20-20v20h20zM0 20v20h20c0-11.046-8.954-20-20-20z'/%3E%3C/g%3E%3C/svg%3E");
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-left: auto;
            margin-right: auto;
        }
        
        .login-tagline {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
        }
        
        .login-subtitle {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 20px;
            line-height: 1.4;
        }
        
        .login-benefits {
            position: relative;
            text-align: left;
            margin-top: 15px;
        }
        
        .login-benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            backdrop-filter: blur(10px);
        }
        
        .login-benefit-icon {
            margin-right: 10px;
            min-width: 20px;
            font-size: 16px;
            color: var(--accent);
        }
        
        .login-benefit-text {
            font-size: 12px;
            opacity: 0.95;
            line-height: 1.3;
        }
        
        .login-form-container {
            width: 100%;
            padding: 30px;
        }
        
        @media (min-width: 992px) {
            .login-form-container {
                width: 60%;
                padding: 35px;
            }
        }
        
        .login-form-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
            display: flex;
            align-items: center;
        }
        
        .login-form-title i {
            margin-right: 8px;
            color: var(--primary);
        }
        
        .login-form-subtitle {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 25px;
            line-height: 1.4;
        }
        
        .login-mobile-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 8px;
        }
        
        @media (min-width: 992px) {
            .login-mobile-logo {
                display: none;
            }
        }
        
        .login-mobile-logo i {
            font-size: 30px;
            color: white;
        }
        
        .form-group {
            margin-bottom: 18px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 6px;
            color: var(--primary);
            width: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.15);
            background-color: white;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 10;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
        }
        
        .password-toggle-icon:hover {
            color: var(--primary);
            background-color: rgba(40, 167, 69, 0.1);
        }
        
        .password-toggle-icon:active {
            transform: translateY(-50%) scale(0.95);
        }
        
        .password-field {
            padding-right: 50px !important;
        }
        
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .login-btn:active {
            transform: translateY(0);
        }
        
        .login-btn i {
            margin-right: 10px;
            font-size: 16px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            margin-right: 10px;
            transform: scale(1.2);
        }
        
        .form-check-label {
            font-size: 14px;
            color: var(--gray);
            cursor: pointer;
        }
        
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.2s;
        }
        
        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 14px;
            color: var(--gray);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }
        
        .register-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }
        
        .invalid-feedback i {
            margin-right: 5px;
        }
        
        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
        }
        
        .security-note {
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 18px;
            font-size: 12px;
            color: #2e7d32;
            display: flex;
            align-items: flex-start;
        }
        
        .security-note i {
            margin-right: 8px;
            margin-top: 1px;
            color: var(--success);
        }
    </style>
</head>
<body>
    <!-- Main Wrapper -->
    <div class="login-container">
        <!-- Branding Side -->
        <div class="login-branding">
            <div class="login-branding-pattern"></div>
            <div class="login-logo">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <h2 class="login-tagline">ThriftSave Platform</h2>
            <p class="login-subtitle">Your trusted partner for smart thrift contributions and secure savings management</p>
            
            <div class="login-benefits">
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="login-benefit-text">
                        <strong>Track Contributions:</strong> Monitor your thrift contributions in real-time with detailed analytics
                    </div>
                </div>
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="login-benefit-text">
                        <strong>Bank-Level Security:</strong> Your savings data is protected with advanced encryption
                    </div>
                    </div>
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="login-benefit-text">
                        <strong>Group Savings:</strong> Participate in cooperative thrift groups and community savings
                    </div>
                </div>
                <div class="login-benefit-item">
                    <div class="login-benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="login-benefit-text">
                        <strong>Financial Goals:</strong> Set and achieve your savings targets with smart planning tools
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="login-form-container">
            <div class="login-mobile-logo">
                <i class="fas fa-piggy-bank"></i>
            </div>
            
            <h1 class="login-form-title">
                <i class="fas fa-sign-in-alt"></i>
                Welcome Back
            </h1>
            <p class="login-form-subtitle">Sign in to access your thrift contributions dashboard and manage your savings securely.</p>
            
            <!-- Security Note -->
            <div class="security-note">
                <i class="fas fa-lock"></i>
                <div>
                    Your login is secured with 256-bit SSL encryption. We never store your password in plain text.
                </div>
            </div>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="Enter your registered email address">
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-key"></i>
                        Password
                    </label>
                    <div class="password-toggle">
                        <input type="password" 
                               class="form-control password-field @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your secure password">
                        <span class="password-toggle-icon" onclick="togglePassword()" title="Show/Hide Password">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="remember_me"
                                       name="remember">
                                <label class="form-check-label" for="remember_me">
                                    Keep me signed in
                                </label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    <i class="fas fa-question-circle me-1"></i>
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <button class="login-btn" type="submit">
                    <i class="fas fa-piggy-bank"></i>
                    <span>Access My Savings</span>
                </button>
                
                @if (Route::has('register'))
                    <div class="register-link">
                        <p>
                            <i class="fas fa-user-plus me-1"></i>
                            New to ThriftSave? 
                            <a href="{{ route('register') }}">Start Your Savings Journey</a>
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
        // Enhanced toggle password visibility function
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('password-eye');
            const toggleBtn = document.querySelector('.password-toggle-icon');
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
                toggleBtn.setAttribute('title', 'Hide Password');
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
                toggleBtn.setAttribute('title', 'Show Password');
            }
        }
        
        // Enhanced form validation and interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.querySelector('.password-toggle-icon');
            
            // Add focus/blur effects for password toggle visibility
            passwordInput.addEventListener('focus', function() {
                passwordToggle.style.opacity = '1';
            });
            
            passwordInput.addEventListener('blur', function() {
                if (this.value === '') {
                    passwordToggle.style.opacity = '0.6';
                }
            });
            
            // Real-time email validation
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            
            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                if (password.length > 0 && password.length < 6) {
                    this.style.borderColor = '#ffc107';
                } else if (password.length >= 6) {
                    this.style.borderColor = '#28a745';
                } else {
                    this.style.borderColor = '#E2E8F0';
                }
            });
            
            // Keyboard shortcut for password toggle (Ctrl + Shift + P)
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                    e.preventDefault();
                    if (passwordInput === document.activeElement) {
                        togglePassword();
                    }
                }
            });
        });
        
        // Toastr notifications with thrift-themed messages
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        var message = "{{ Session::get('message') }}";
        
        // Configure toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "showEasing": "swing",
            "hideEasing": "linear"
        };
        
        switch(type) {
            case 'info':
                toastr.info(message, '💡 Information');
                break;
            case 'success':
                toastr.success(message, '🎉 Success');
                break;
            case 'warning':
                toastr.warning(message, '⚠️ Warning');
                break;
            case 'error':
                toastr.error(message, '❌ Error');
                break;
        }
        @endif
    </script>
</body>
</html>