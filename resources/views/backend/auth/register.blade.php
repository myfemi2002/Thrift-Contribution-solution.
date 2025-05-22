<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your NexTrade Account | Professional Trading Platform</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/logo/favicon.png') }}" type="image/x-icon">
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
            background-image: url('{{ asset('frontend/assets/images/backgrounds/finance-bg.jpg') }}');
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
        
        .auth-container {
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
        
        .auth-branding {
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
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .auth-logo {
            width: 180px;
            height: auto;
            margin-bottom: 30px;
            position: relative;
        }
        
        .auth-tagline {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
        }
        
        .auth-benefits {
            position: relative;
            text-align: left;
            margin-top: 30px;
        }
        
        .auth-benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .auth-benefit-icon {
            margin-right: 15px;
            min-width: 24px;
            font-size: 24px;
            color: var(--secondary);
        }
        
        .auth-benefit-text {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .auth-form-container {
            width: 100%;
            padding: 40px;
            max-height: 700px;
            overflow-y: auto;
        }
        
        @media (min-width: 992px) {
            .auth-form-container {
                width: 60%;
            }
        }
        
        .auth-form-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .auth-form-subtitle {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 30px;
        }
        
        .auth-mobile-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        @media (min-width: 992px) {
            .auth-mobile-logo {
                display: none;
            }
        }
        
        .auth-mobile-logo img {
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
        
        .auth-btn {
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
        }
        
        .auth-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .auth-divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--gray);
            font-size: 14px;
        }
        
        .auth-divider::before, 
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border);
        }
        
        .auth-divider::before {
            margin-right: 15px;
        }
        
        .auth-divider::after {
            margin-left: 15px;
        }
        
        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .social-btn:hover {
            background-color: #f9fafb;
        }
        
        .social-btn i {
            font-size: 20px;
            margin-right: 10px;
        }
        
        .social-btn.google i {
            color: #DB4437;
        }
        
        .social-btn.linkedin i {
            color: #0A66C2;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--gray);
        }
        
        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .form-text {
            font-size: 12px;
            color: var(--gray);
            margin-top: 5px;
        }
        
        .error {
            color: #e11d48;
            font-size: 12px;
            margin-top: 4px;
        }
        
        .required-label::after {
            content: "*";
            color: #e11d48;
            margin-left: 3px;
        }
        
        /* Fixed modal styling for scrolling */
        .modal-dialog-scrollable .modal-content {
            max-height: 100%;
            overflow: hidden;
        }
        
        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            max-height: 60vh; /* Adjust this value as needed */
        }
        
        .terms-content, .privacy-content {
            padding-right: 10px;
        }
        
        /* Custom scrollbar for modals */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Branding Side -->
        <div class="auth-branding">
            <div class="auth-branding-pattern"></div>
            <img src="{{ asset('frontend/assets/images/logo/logo-light.png') }}" alt="NexTrade Logo" class="auth-logo">
            <h2 class="auth-tagline">The Analytical Edge in Market Intelligence</h2>
            <p>Join over 66,000 traders worldwide</p>
            
            <div class="auth-benefits">
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="auth-benefit-text">
                        Access professional-grade trading signals with 67.4% accuracy
                    </div>
                </div>
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="auth-benefit-text">
                        Advanced risk management tools to protect your capital
                    </div>
                </div>
                <div class="auth-benefit-item">
                    <div class="auth-benefit-icon">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <div class="auth-benefit-text">
                        Real-time market analysis across 42 global markets
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-container">
            <div class="auth-mobile-logo">
                <img src="{{ asset('frontend/assets/images/logo/logo-dark.png') }}" alt="NexTrade Logo">
            </div>
            
            <h1 class="auth-form-title">Create Your Account</h1>
            <p class="auth-form-subtitle">Start your trading journey with NexTrade</p>
            
            <form method="POST" action="{{ route('auth.register.store') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label required-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label required-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label required-label">Password</label>
                            <div class="password-toggle">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                <span class="password-toggle-icon" onclick="togglePassword('password')">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            <div class="form-text">Must be at least 8 characters with letters, numbers and special characters</div>
                            @error('password')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label required-label">Confirm Password</label>
                            <div class="password-toggle">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                                <span class="password-toggle-icon" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check mt-4">
                                <input class="form-check-input @error('newsletter') is-invalid @enderror" type="checkbox" id="newsletter" name="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Subscribe to market updates and signals
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
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="auth-btn">Create Account</button>
                </div>
                              
                <div class="login-link">
                    <p>
                        Already have an account? 
                        <a href="{{ route('login') }}">Sign In</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Terms of Service -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="terms-content">
                        <h2>NexTrade Terms of Service</h2>
                        <p><strong>Last Updated: April 23, 2025</strong></p>
                        
                        <p>Please read these Terms of Service ("Terms") carefully before using the NexTrade platform, website, and services.</p>
                        
                        <h3>1. Acceptance of Terms</h3>
                        <p>By accessing or using NexTrade's services, you agree to be bound by these Terms. If you disagree with any part of the Terms, you may not access the service.</p>
                        
                        <h3>2. Description of Service</h3>
                        <p>NexTrade provides a market analysis and trading signals platform intended for informational and educational purposes only. Our services include but are not limited to algorithmic trading signals, market analysis, broker comparisons, and educational resources.</p>
                        
                        <h3>3. Registration and Account Security</h3>
                        <p>3.1. You must provide accurate, current, and complete information during the registration process.</p>
                        <p>3.2. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                        <p>3.3. NexTrade reserves the right to suspend or terminate accounts that violate these Terms or are inactive for an extended period.</p>
                        <p>3.4. You must notify NexTrade immediately of any unauthorized use of your account or any other breach of security.</p>
                        
                        <h3>4. Subscription and Payments</h3>
                        <p>4.1. Access to premium features requires a paid subscription.</p>
                        <p>4.2. You agree to pay all fees associated with your selected subscription plan.</p>
                        <p>4.3. Subscription fees are billed in advance on a recurring basis according to your chosen billing cycle.</p>
                        <p>4.4. NexTrade reserves the right to change subscription fees upon notice to subscribers.</p>
                        <p>4.5. No refunds or credits will be provided for partial subscription periods or unused services.</p>
                        
                        <h3>5. Risk Disclosure</h3>
                        <p>5.1. Trading in financial markets involves substantial risk of loss and is not suitable for all investors.</p>
                        <p>5.2. Past performance of signals, analysis, or educational content is not indicative of future results.</p>
                        <p>5.3. NexTrade does not guarantee accuracy, completeness, or timeliness of information provided.</p>
                        <p>5.4. You acknowledge that all trading decisions are made at your own risk.</p>
                        
                        <h3>6. Disclaimer of Warranties</h3>
                        <p>6.1. NexTrade services are provided on an "as is" and "as available" basis without warranties of any kind.</p>
                        <p>6.2. NexTrade disclaims all warranties, express or implied, including but not limited to merchantability, fitness for a particular purpose, and non-infringement.</p>
                        <p>6.3. NexTrade does not warrant that the service will be uninterrupted, secure, or error-free.</p>
                        
                        <h3>7. Limitation of Liability</h3>
                        <p>7.1. To the maximum extent permitted by law, NexTrade shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including lost profits, resulting from your use of or inability to use the service.</p>
                        <p>7.2. In no event shall NexTrade's total liability to you for all damages exceed the amount paid by you to NexTrade during the twelve (12) months preceding the claim.</p>
                        <p>7.3. NexTrade is not liable for any losses resulting from trading decisions made based on information provided through our services.</p>
                        
                        <h3>8. User Conduct</h3>
                        <p>8.1. You may not use the service for any illegal purpose or to violate any laws.</p>
                        <p>8.2. You may not access or attempt to access other users' accounts.</p>
                        <p>8.3. You may not interfere with or disrupt the service or servers connected to the service.</p>
                        <p>8.4. You may not reproduce, duplicate, copy, sell, resell, or exploit any portion of the service without express written permission from NexTrade.</p>
                        
                        <h3>9. Intellectual Property</h3>
                        <p>9.1. All content, features, and functionality of the NexTrade service are owned by NexTrade and are protected by copyright, trademark, and other intellectual property laws.</p>
                        <p>9.2. You may not modify, distribute, reproduce, publish, license, create derivative works from, transfer, or sell any information obtained from NexTrade.</p>
                        <p>9.3. NexTrade's algorithms, trading signals, analytical methodologies, and proprietary systems are exclusive intellectual property and trade secrets of NexTrade.</p>
                        
                        <h3>10. Termination</h3>
                        <p>10.1. NexTrade reserves the right to terminate or suspend your account and access to the service at any time, for any reason, without notice.</p>
                        <p>10.2. Upon termination, your right to use the service will immediately cease.</p>
                        <p>10.3. All provisions which by their nature should survive termination shall survive termination, including ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>
                        
                        <h3>11. Data Usage and Algorithm Protection</h3>
                        <p>11.1. NexTrade may collect and analyze user interaction data to improve service quality and algorithm performance.</p>
                        <p>11.2. Any attempt to reverse engineer, decompile, or extract NexTrade's proprietary algorithms or methodologies is strictly prohibited.</p>
                        <p>11.3. NexTrade maintains exclusive rights to all analytical outputs, signals, and trading recommendations generated by its systems.</p>
                        
                        <h3>12. Governing Law</h3>
                        <p>12.1. These Terms shall be governed by and construed in accordance with the laws of the State of New York, without regard to its conflict of law provisions.</p>
                        <p>12.2. Any dispute arising from these Terms shall be subject to the exclusive jurisdiction of the courts located in New York County, New York.</p>
                        
                        <h3>13. Indemnification</h3>
                        <p>You agree to indemnify, defend, and hold harmless NexTrade, its affiliates, officers, directors, employees, and agents from any claims, liabilities, damages, losses, costs, or expenses arising from your use of the service or violation of these Terms.</p>
                        
                        <h3>14. Amendments</h3>
                        <p>14.1. NexTrade reserves the right to modify these Terms at any time.</p>
                        <p>14.2. Continued use of the service after changes constitutes acceptance of the modified Terms.</p>
                        <p>14.3. It is your responsibility to review these Terms periodically for changes.</p>
                        
                        <h3>15. Severability</h3>
                        <p>If any provision of these Terms is found to be unenforceable or invalid, that provision will be limited or eliminated to the minimum extent necessary so that the Terms will otherwise remain in full force and effect.</p>
                        
                        <h3>16. Entire Agreement</h3>
                        <p>These Terms constitute the entire agreement between you and NexTrade regarding the service and supersede all prior agreements and understandings.</p>
                        
                        <h3>17. Contact Information</h3>
                        <p>For questions about these Terms, please contact us at legal@nextrade.com.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Privacy Policy -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2660B5; color: white;">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="privacy-content">
                        <h2>NexTrade Privacy Policy</h2>
                        <p><strong>Last Updated: April 23, 2025</strong></p>
                        
                        <p>This Privacy Policy explains how NexTrade collects, uses, and protects your personal information. By using our services, you consent to the data practices described in this policy.</p>
                        
                        <h3>1. Information We Collect</h3>
                        <p>1.1. <strong>Personal Information:</strong> We collect information you provide when registering for an account, subscribing to our service, or contacting us, including:</p>
                        <ul>
                            <li>Name, email address, phone number</li>
                            <li>Account credentials</li>
                            <li>Payment information</li>
                            <li>Communications with our support team</li>
                        </ul>
                        
                        <p>1.2. <strong>Usage Information:</strong> We collect information about how you interact with our services, including:</p>
                        <ul>
                            <li>Trading preferences and patterns</li>
                            <li>Features and content accessed</li>
                            <li>Time spent on the platform</li>
                            <li>Actions taken within the service</li>
                        </ul>
                        
                        <p>1.3. <strong>Technical Information:</strong> We automatically collect certain information when you visit our website or use our platform:</p>
                        <ul>
                            <li>IP address and device information</li>
                            <li>Browser type and settings</li>
                            <li>Operating system</li>
                            <li>Referring websites</li>
                            <li>Activity timestamps</li>
                        </ul>
                        
                        <h3>2. How We Use Your Information</h3>
                        <p>2.1. <strong>Service Provision and Improvement:</strong></p>
                        <ul>
                            <li>Providing and maintaining our services</li>
                            <li>Personalizing your experience</li>
                            <li>Improving our algorithms and trading signals</li>
                            <li>Enhancing platform features and user interface</li>
                            <li>Processing transactions and managing subscriptions</li>
                        </ul>
                        
                        <p>2.2. <strong>Communication and Support:</strong></p>
                        <ul>
                            <li>Sending service notifications and updates</li>
                            <li>Providing customer support</li>
                            <li>Responding to your inquiries</li>
                            <li>Sending marketing communications (with your consent)</li>
                        </ul>
                        
                        <p>2.3. <strong>Research and Analytics:</strong></p>
                        <ul>
                            <li>Analyzing usage patterns to improve our services</li>
                            <li>Developing new features and products</li>
                            <li>Monitoring and improving the effectiveness of our trading signals</li>
                            <li>Conducting market research and trend analysis</li>
                        </ul>
                        
                        <p>2.4. <strong>Security and Legal Compliance:</strong></p>
                        <ul>
                            <li>Protecting against unauthorized access and fraud</li>
                            <li>Enforcing our Terms of Service</li>
                            <li>Complying with legal obligations</li>
                            <li>Resolving disputes</li>
                        </ul>
                        
                        <h3>3. Information Sharing and Disclosure</h3>
                        <p>3.1. We do not sell your personal information to third parties.</p>
                        
                        <p>3.2. We may share your information with:</p>
                        <ul>
                            <li><strong>Service Providers:</strong> Third parties that help us operate our business and provide services (payment processors, hosting providers, analytics services)</li>
                            <li><strong>Business Partners:</strong> Selected broker partners when you explicitly request broker integration</li>
                            <li><strong>Legal Requirements:</strong> When required by law, legal process, or government requests</li>
                            <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
                        </ul>
                        
                        <p>3.3. <strong>Aggregated and Anonymized Data:</strong> We may share aggregated, anonymized data that cannot reasonably be used to identify you.</p>
                        
                        <h3>4. Algorithm and Signal Protection</h3>
                        <p>4.1. The data collected through your use of our services may be used to enhance our proprietary trading algorithms and signal generation systems.</p>
                        <p>4.2. User interaction patterns and performance metrics help refine our analytical models to improve accuracy and reliability.</p>
                        <p>4.3. This analytical improvement process does not expose your personal trading information to other users.</p>
                        
                        <h3>5. Data Retention</h3>
                        <p>5.1. We retain your personal information for as long as necessary to provide our services, comply with legal obligations, resolve disputes, and enforce our agreements.</p>
                        <p>5.2. You may request deletion of your account and personal information, subject to our legal retention requirements.</p>
                        <p>5.3. Trading history and interaction data may be retained in anonymized form for analytical purposes even after account deletion.</p>
                        
                        <h3>6. Your Rights and Choices</h3>
                        <p>Depending on your location, you may have rights regarding your personal information, including:</p>
                        <ul>
                            <li>Accessing and obtaining a copy of your data</li>
                            <li>Correcting inaccurate information</li>
                            <li>Requesting deletion of your data (subject to exceptions)</li>
                            <li>Restricting or objecting to certain processing activities</li>
                            <li>Data portability</li>
                            <li>Withdrawing consent (where processing is based on consent)</li>
                        </ul>
                        <p>To exercise these rights, please contact us at privacy@nextrade.com.</p>
                        
                        <h3>7. Security Measures</h3>
                        <p>7.1. We implement appropriate technical and organizational measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p>
                        <p>7.2. We use industry-standard encryption, secure server infrastructure, and regular security assessments.</p>
                        <p>7.3. While we strive to protect your personal information, no method of electronic transmission or storage is 100% secure.</p>
                        
                        <h3>8. Cookies and Tracking Technologies</h3>
                        <p>8.1. We use cookies and similar technologies to enhance your experience, analyze usage patterns, and deliver personalized content.</p>
                        <p>8.2. You can control cookies through your browser settings, but disabling certain cookies may limit your ability to use some features of our service.</p>
                        <p>8.3. We may use analytics services that collect data about your interactions with our platform to improve our services.</p>
                        
                        <h3>9. International Data Transfers</h3>
                        <p>9.1. Your information may be transferred to and processed in countries other than your country of residence.</p>
                        <p>9.2. We take steps to ensure that your information receives an adequate level of protection in the jurisdictions in which we process it.</p>
                        
                        <h3>10. Children's Privacy</h3>
                        <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children. If you become aware that a child has provided us with personal information, please contact us.</p>
                        
                        <h3>11. Changes to This Privacy Policy</h3>
                        <p>11.1. We may update this Privacy Policy from time to time to reflect changes in our practices or for other operational, legal, or regulatory reasons.</p>
                        <p>11.2. We will notify you of any material changes by posting the new Privacy Policy on this page and updating the "Last Updated" date.</p>
                        <p>11.3. Your continued use of the service after such modifications constitutes your acknowledgment of the modified Privacy Policy.</p>
                        
                        <h3>12. Contact Us</h3>
                        <p>If you have questions or concerns about this Privacy Policy or our data practices, please contact us at:</p>
                        <h5 class="card--small-title">Telegram Community</h5>
                                <div class="gap-1 flex-column">
                                    <a href="https://t.me/nextrade_community" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        Join Our Telegram Group <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <p class="mb-0 small text-muted">Get instant updates and connect with traders</p>
                                </div>
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
        
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };
        
        // Display Laravel validation errors with Toastr
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        
        // Modal functionality for Terms and Privacy
        document.addEventListener('DOMContentLoaded', function() {
            // Update the links to use these modal triggers
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