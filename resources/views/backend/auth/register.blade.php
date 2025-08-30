<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Your Savings Journey | ThriftSave - Smart Thrift Contributions Platform</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Join ThriftSave today and start your smart thrift contribution journey. Manage group savings, track contributions, and achieve your financial goals with our secure platform.">
    <meta name="keywords" content="thrift registration, savings account, group savings signup, thrift contributions, financial planning, cooperative savings">
    <meta name="author" content="ThriftSave">
    <meta name="robots" content="index, follow">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/logo/thriftsave-favicon.png') }}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
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
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--dark);
            margin: 0;
            padding: 15px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
        
        .auth-container {
            position: relative;
            z-index: 2;
            display: flex;
            width: 950px;
            max-width: 95%;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            max-height: 90vh;
        }
        
        .auth-branding {
            display: none;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            width: 35%;
            padding: 25px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        
        @media (min-width: 992px) {
            .auth-branding {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        }
        
        .auth-branding-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M20 20c0-11.046-8.954-20-20-20v20h20zM0 20v20h20c0-11.046-8.954-20-20-20z'/%3E%3C/g%3E%3C/svg%3E");
        }
        
        .auth-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            position: relative;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            margin-left: auto;
            margin-right: auto;
        }
        
        .auth-tagline {
            font-family: 'Montserrat', sans-serif;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
        }
        
        .auth-tagline-sub {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        .auth-benefits {
            position: relative;
            text-align: left;
            margin-top: 15px;
        }
        
        .auth-benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            padding: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            backdrop-filter: blur(10px);
        }
        
        .auth-benefit-icon {
            margin-right: 10px;
            min-width: 18px;
            font-size: 16px;
            color: var(--accent);
        }
        
        .auth-benefit-text {
            font-size: 11px;
            opacity: 0.95;
            line-height: 1.3;
        }
        
        .auth-form-container {
            width: 100%;
            padding: 25px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        @media (min-width: 992px) {
            .auth-form-container {
                width: 65%;
                padding: 30px;
            }
        }
        
        .auth-form-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
            display: flex;
            align-items: center;
        }
        
        .auth-form-title i {
            margin-right: 8px;
            color: var(--primary);
        }
        
        .auth-form-subtitle {
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 20px;
            line-height: 1.4;
        }
        
        .auth-mobile-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 8px;
        }
        
        @media (min-width: 992px) {
            .auth-mobile-logo {
                display: none;
            }
        }
        
        .auth-mobile-logo i {
            font-size: 28px;
            color: white;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 6px;
            color: var(--primary);
            width: 14px;
            font-size: 12px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
            background-color: white;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray);
            font-size: 14px;
        }
        
        .auth-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .auth-btn i {
            margin-right: 8px;
            font-size: 16px;
        }
        
        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: var(--gray);
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }
        
        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .form-text {
            font-size: 11px;
            color: var(--gray);
            margin-top: 4px;
        }
        
        .error {
            color: #e11d48;
            font-size: 11px;
            margin-top: 4px;
            display: flex;
            align-items: center;
        }
        
        .error i {
            margin-right: 4px;
        }
        
        .required-label::after {
            content: "*";
            color: #e11d48;
            margin-left: 3px;
        }
        
        .form-check {
            margin-bottom: 10px;
        }
        
        .form-check-input {
            transform: scale(1.1);
            margin-right: 8px;
        }
        
        .form-check-label {
            font-size: 12px;
            color: var(--dark);
            cursor: pointer;
        }
        
        .security-note {
            background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
            border: 1px solid #c8e6c9;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 11px;
            color: #2e7d32;
            display: flex;
            align-items: flex-start;
        }
        
        .security-note i {
            margin-right: 8px;
            margin-top: 1px;
            color: var(--success);
        }
        
        /* Modal styling optimizations */
        .modal-dialog-scrollable .modal-content {
            max-height: 85vh;
            overflow: hidden;
        }
        
        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            max-height: 60vh;
        }
        
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        
        /* Custom scrollbar for form container */
        .auth-form-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .auth-form-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .auth-form-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Branding Side -->
        <div class="auth-branding">
            <div class="auth-branding-pattern"></div>
            <div class="auth-logo">
                <i class="bi bi-piggy-bank"></i>
            </div>
            <h2 class="auth-tagline">ThriftSave Community</h2>
            <p class="auth-tagline-sub">Join thousands building their financial future</p>
            
            <div class="auth-benefits">
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <strong>Bank-Level Security:</strong> Your contributions protected with 256-bit encryption
                    </div>
                </div>
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <strong>Group Savings:</strong> Join cooperative thrift groups in your community
                    </div>
                </div>
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <strong>Smart Analytics:</strong> Track progress with detailed savings insights
                    </div>
                </div>
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <div class="auth-benefit-text">
                        <strong>Goal Achievement:</strong> Set and reach your financial milestones faster
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-container">
            <div class="auth-mobile-logo">
                <i class="bi bi-piggy-bank"></i>
            </div>
            
            <h1 class="auth-form-title">
                <i class="bi bi-person-plus"></i>
                Start Your Savings Journey
            </h1>
            <p class="auth-form-subtitle">Create your ThriftSave account and begin building your financial future with smart thrift contributions</p>
            
            <!-- Security Note -->
            <div class="security-note">
                <i class="bi bi-shield-lock"></i>
                <div>
                    Your account will be secured with advanced encryption. We never share your personal information with third parties.
                </div>
            </div>
            
            <form method="POST" action="{{ route('auth.register.store') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label required-label">
                                <i class="bi bi-person"></i>
                                Full Name
                            </label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter your full name">
                            @error('name')
                                <div class="error"><i class="bi bi-exclamation-triangle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label required-label">
                                <i class="bi bi-envelope"></i>
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="your.email@example.com">
                            @error('email')
                                <div class="error"><i class="bi bi-exclamation-triangle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label required-label">
                                <i class="bi bi-lock"></i>
                                Password
                            </label>
                            <div class="password-toggle">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Create a secure password">
                                <span class="password-toggle-icon" onclick="togglePassword('password')">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            <div class="form-text">Minimum 8 characters with letters, numbers & symbols</div>
                            @error('password')
                                <div class="error"><i class="bi bi-exclamation-triangle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label required-label">
                                <i class="bi bi-lock-fill"></i>
                                Confirm Password
                            </label>
                            <div class="password-toggle">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Confirm your password">
                                <span class="password-toggle-icon" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="error"><i class="bi bi-exclamation-triangle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="bi bi-phone"></i>
                                Phone Number
                            </label>
                            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Your phone number">
                            @error('phone')
                                <div class="error"><i class="bi bi-exclamation-triangle"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check mt-4">
                                <input class="form-check-input @error('newsletter') is-invalid @enderror" type="checkbox" id="newsletter" name="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    <i class="bi bi-bell me-1"></i>
                                    Subscribe to savings tips and updates
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" data-target="terms">Terms of Service</a> and <a href="#" data-target="privacy">Privacy Policy</a>
                        </label>
                        @error('terms')
                            <div class="error"><i class="bi bi-exclamation-triangle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="auth-btn">
                        <i class="bi bi-piggy-bank"></i>
                        Create My Savings Account
                    </button>
                </div>
                              
                <div class="login-link">
                    <p>
                        <i class="bi bi-arrow-left me-1"></i>
                        Already have an account? 
                        <a href="{{ route('login') }}">Sign In to Your Savings</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Terms of Service -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #17a2b8); color: white;">
                    <h5 class="modal-title" id="termsModalLabel"><i class="bi bi-shield-check me-2"></i>ThriftSave Terms of Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="terms-content">
                        <h2>ThriftSave Terms of Service</h2>
                        <p><strong>Last Updated: August 30, 2025</strong></p>
                        
                        <p>This Privacy Policy explains how ThriftSave collects, uses, and protects your personal information. By using our services, you consent to the data practices described in this policy.</p>
                        
                        <h3>1. Information We Collect</h3>
                        <p>1.1. <strong>Personal Information:</strong> We collect information you provide when registering, including:</p>
                        <ul>
                            <li>Name, email address, phone number</li>
                            <li>Account credentials and profile information</li>
                            <li>Payment information for subscription services</li>
                            <li>Communications with our support team</li>
                        </ul>
                        
                        <p>1.2. <strong>Financial Data:</strong> We collect information about your thrift contributions and savings:</p>
                        <ul>
                            <li>Contribution amounts and schedules</li>
                            <li>Savings goals and progress tracking</li>
                            <li>Group participation and coordination data</li>
                            <li>Financial planning preferences</li>
                        </ul>
                        
                        <p>1.3. <strong>Usage Information:</strong> We collect information about how you interact with our services:</p>
                        <ul>
                            <li>Features and tools accessed</li>
                            <li>Time spent on the platform</li>
                            <li>User preferences and settings</li>
                            <li>Platform interaction patterns</li>
                        </ul>
                        
                        <h3>2. How We Use Your Information</h3>
                        <p>2.1. <strong>Service Provision:</strong></p>
                        <ul>
                            <li>Managing your thrift contribution tracking</li>
                            <li>Facilitating group savings coordination</li>
                            <li>Providing personalized financial insights</li>
                            <li>Processing subscription payments</li>
                        </ul>
                        
                        <p>2.2. <strong>Communication:</strong></p>
                        <ul>
                            <li>Sending contribution reminders and updates</li>
                            <li>Providing customer support</li>
                            <li>Sharing savings tips and financial education</li>
                            <li>Notifying about platform updates</li>
                        </ul>
                        
                        <p>2.3. <strong>Platform Improvement:</strong></p>
                        <ul>
                            <li>Analyzing usage patterns to enhance features</li>
                            <li>Developing new savings tools and calculators</li>
                            <li>Improving user experience and interface</li>
                            <li>Ensuring platform security and reliability</li>
                        </ul>
                        
                        <h3>3. Information Sharing</h3>
                        <p>3.1. We do not sell your personal or financial information to third parties.</p>
                        <p>3.2. We may share information with:</p>
                        <ul>
                            <li><strong>Service Providers:</strong> Payment processors, hosting services, and analytics providers</li>
                            <li><strong>Group Members:</strong> Limited contribution data when you participate in group savings (with your consent)</li>
                            <li><strong>Legal Requirements:</strong> When required by law or legal process</li>
                        </ul>
                        
                        <h3>4. Data Security</h3>
                        <p>4.1. We implement bank-level security measures including 256-bit SSL encryption.</p>
                        <p>4.2. Your financial data is stored securely and access is strictly limited.</p>
                        <p>4.3. We regularly update our security protocols and conduct security audits.</p>
                        <p>4.4. We never store sensitive payment information on our servers.</p>
                        
                        <h3>5. Your Rights</h3>
                        <p>You have the right to:</p>
                        <ul>
                            <li>Access and download your contribution data</li>
                            <li>Correct inaccurate information</li>
                            <li>Delete your account and associated data</li>
                            <li>Opt out of non-essential communications</li>
                            <li>Export your savings data in portable formats</li>
                        </ul>
                        
                        <h3>6. Data Retention</h3>
                        <p>6.1. We retain your data for as long as your account is active.</p>
                        <p>6.2. Financial records may be retained for legal compliance purposes.</p>
                        <p>6.3. You can request data deletion at any time through your account settings.</p>
                        
                        <h3>7. Cookies and Tracking</h3>
                        <p>7.1. We use cookies to enhance your experience and provide personalized features.</p>
                        <p>7.2. You can control cookie settings through your browser preferences.</p>
                        <p>7.3. We use analytics to improve our service quality.</p>
                        
                        <h3>8. Children's Privacy</h3>
                        <p>Our services are designed for adults managing their own finances. We do not knowingly collect information from children under 18.</p>
                        
                        <h3>9. International Users</h3>
                        <p>9.1. Your information may be processed in countries with different privacy laws.</p>
                        <p>9.2. We ensure adequate protection regardless of processing location.</p>
                        
                        <h3>10. Policy Updates</h3>
                        <p>10.1. We may update this Privacy Policy periodically.</p>
                        <p>10.2. Material changes will be communicated via email or platform notification.</p>
                        <p>10.3. Continued use after updates constitutes acceptance of changes.</p>
                        
                        <h3>11. Contact Us</h3>
                        <p>For privacy-related questions or to exercise your rights, contact us at:</p>
                        <ul>
                            <li><strong>Email:</strong> privacy@thriftsave.com</li>
                            <li><strong>Support:</strong> Available through your account dashboard</li>
                            <li><strong>Community:</strong> Join our savings community for tips and support</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Password visibility toggle function
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
        
        // Enhanced form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            // Real-time password matching
            function checkPasswordMatch() {
                if (confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Passwords do not match');
                    confirmPasswordInput.style.borderColor = '#e11d48';
                } else {
                    confirmPasswordInput.setCustomValidity('');
                    confirmPasswordInput.style.borderColor = '#28a745';
                }
            }
            
            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            
            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                if (password.length === 0) {
                    this.style.borderColor = '#E2E8F0';
                } else if (password.length < 8) {
                    this.style.borderColor = '#ffc107';
                } else if (password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/)) {
                    this.style.borderColor = '#28a745';
                } else {
                    this.style.borderColor = '#17a2b8';
                }
            });
        });
        
        // Toastr configuration for thrift-themed notifications
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "showEasing": "swing",
            "hideEasing": "linear"
        };
        
        // Display Laravel validation messages
        @if(session('success'))
            toastr.success("{{ session('success') }}", '🎉 Welcome to ThriftSave!');
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}", '❌ Registration Error');
        @endif
        
        // Modal functionality for Terms and Privacy
        document.addEventListener('DOMContentLoaded', function() {
            const termsLinks = document.querySelectorAll('a[data-target="terms"]');
            const privacyLinks = document.querySelectorAll('a[data-target="privacy"]');
            
            termsLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
                    termsModal.show();
                });
            });
            
            privacyLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const privacyModal = new bootstrap.Modal(document.getElementById('privacyModal'));
                    privacyModal.show();
                });
            });
        });
    </script>
</body>
</html>