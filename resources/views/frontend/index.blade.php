@php
   $assetBase = asset('frontend/assets');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EagleSave Thrift | Secure Your Financial Future</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="EagleSave is a premier thrift contribution platform helping you save for your future goals. Join our community for financial freedom and security.">
    <meta name="keywords" content="thrift contribution, saving platform, financial freedom, cooperative savings, EagleSave, investment">
    <meta name="author" content="EagleSave">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="EagleSave Thrift | Building Financial Security Together">
    <meta property="og:description" content="Join our thrift contribution platform to achieve your financial goals with disciplined saving and community support.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://eaglesave.com">
    <meta property="og:image" content="https://eaglesave.com/images/og-image.jpg">
    
    <!-- Favicon -->
    <link rel="icon" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.0/collection/components/icon/svg/logo-buffer.svg" type="image/svg+xml">
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <style>
        :root {
            --primary-color: #1d3557;
            --secondary-color: #457b9d;
            --accent-color: #e63946;
            --light-color: #f1faee;
            --dark-color: #1d3557;
            --gray-color: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        
        /* Navbar Styles */
        .navbar {
            padding: 20px 0;
            transition: all 0.4s ease;
        }
        
        .navbar-scrolled {
            padding: 10px 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 600;
            position: relative;
            margin: 0 10px;
            color: var(--dark-color) !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            left: 0;
            bottom: -5px;
            transition: width 0.3s;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .nav-link.active:after {
            width: 100%;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* Hero Section */
        .hero-slider .slick-slide {
            height: 600px;
            position: relative;
            overflow: hidden;
        }
        
        .slider-item {
            position: relative;
            height: 600px;
            background-size: cover;
            background-position: center;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        
        .slider-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        
        .slider-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            padding: 0 20px;
        }
        
        .slider-content h1 {
            color: white;
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            animation-delay: 0.3s;
        }
        
        .slider-content p {
            color: white;
            font-size: 18px;
            margin-bottom: 30px;
            animation-delay: 0.5s;
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
            animation-delay: 0.7s;
        }
        
        .btn-primary:hover {
            background-color: transparent;
            border-color: white;
        }
        
        .btn-outline-light {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
            margin-left: 15px;
            animation-delay: 0.9s;
        }
        
        /* Section Styles */
        section {
            padding: 100px 0;
        }
        
        .section-heading {
            margin-bottom: 60px;
            text-align: center;
        }
        
        .section-heading h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
            color: var(--primary-color);
        }
        
        .section-heading h2:after {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background: var(--accent-color);
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
        }
        
        .section-heading p {
            font-size: 18px;
            max-width: 700px;
            margin: 20px auto 0;
            color: #6c757d;
        }
        
        /* About Section */
        .about-box {
            margin-bottom: 30px;
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            transition: all 0.3s;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .about-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .about-icon {
            font-size: 40px;
            margin-bottom: 20px;
            color: var(--accent-color);
        }
        
        .about-box h3 {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .about-box p {
            color: #6c757d;
            font-size: 16px;
        }
        
        /* Services Section */
        #services {
            background-color: var(--gray-color);
        }
        
        .service-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            background-color: white;
            transition: all 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .service-img {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .service-content {
            padding: 25px;
        }
        
        .service-content h3 {
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .service-content p {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .btn-outline-primary {
            color: var(--accent-color);
            border-color: var(--accent-color);
            padding: 8px 20px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--accent-color);
            color: white;
        }
        
        /* Stats Section */
        .stats-section {
            background-color: var(--primary-color);
            padding: 80px 0;
            color: white;
        }
        
        .stat-box {
            text-align: center;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--light-color);
        }
        
        .stat-text {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Team Section */
        .team-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            background-color: white;
            transition: all 0.3s;
        }
        
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .team-img {
            position: relative;
            overflow: hidden;
        }
        
        .team-img img {
            width: 100%;
            transition: all 0.5s;
        }
        
        .team-card:hover .team-img img {
            transform: scale(1.1);
        }
        
        .team-social {
            position: absolute;
            bottom: -60px;
            left: 0;
            width: 100%;
            padding: 15px 0;
            background-color: rgba(29, 53, 87, 0.8);
            transition: all 0.3s;
            text-align: center;
        }
        
        .team-card:hover .team-social {
            bottom: 0;
        }
        
        .team-social a {
            display: inline-block;
            color: white;
            margin: 0 10px;
            font-size: 18px;
            transition: all 0.3s;
        }
        
        .team-social a:hover {
            transform: translateY(-5px);
            color: var(--accent-color);
        }
        
        .team-content {
            padding: 25px;
            text-align: center;
        }
        
        .team-content h3 {
            font-size: 22px;
            margin-bottom: 5px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .team-content span {
            color: var(--secondary-color);
            font-size: 15px;
        }

        /* Testimonials Section */
        #testimonials {
            background-color: var(--gray-color);
        }
        
        .testimonial-card {
            padding: 30px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin: 15px;
            text-align: center;
        }
        
        .testimonial-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            border: 5px solid var(--gray-color);
        }
        
        .testimonial-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            color: #6c757d;
        }
        
        .testimonial-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .testimonial-position {
            font-size: 14px;
            color: var(--secondary-color);
        }
        
        .testimonial-rating {
            color: #ffc107;
            margin-bottom: 15px;
        }
        
        /* FAQ Section */
        .faq-item {
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .faq-header {
            padding: 20px;
            background-color: white;
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
        }
        
        .faq-header h3 {
            font-size: 18px;
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .faq-header:after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s;
        }
        
        .faq-header.active:after {
            transform: translateY(-50%) rotate(180deg);
        }
        
        .faq-content {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            background-color: white;
            transition: max-height 0.3s ease-out;
        }
        
        .faq-text {
            padding: 0 0 20px;
            color: #6c757d;
        }
        
        /* Contact Section */
        .contact-info {
            padding: 30px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        
        .contact-info h3 {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--primary-color);
            position: relative;
            padding-bottom: 10px;
        }
        
        .contact-info h3:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 2px;
            background: var(--accent-color);
            left: 0;
            bottom: 0;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        
        .contact-icon {
            min-width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .contact-text h5 {
            font-size: 16px;
            margin-bottom: 5px;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .contact-text p {
            color: #6c757d;
        }
        
        .contact-form {
            padding: 30px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .form-control {
            height: 50px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: none;
        }
        
        textarea.form-control {
            height: 150px;
            resize: none;
        }
        
        .btn-submit {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
            width: 100%;
            color: white;
        }
        
        .btn-submit:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-color);
            padding: 80px 0 0;
            color: white;
        }
        
        .footer-logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
            display: inline-block;
        }
        
        .footer-about p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
        }
        
        .footer-social a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            text-align: center;
            line-height: 40px;
            transition: all 0.3s;
        }
        
        .footer-social a:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
        }
        
        .footer-heading {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-heading:after {
            content: '';
            position: absolute;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
            left: 0;
            bottom: 0;
        }
        
        .footer-links li {
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .footer-links a:hover {
            color: var(--accent-color);
            padding-left: 5px;
        }
        
        .footer-links i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .contact-links li {
            display: flex;
            margin-bottom: 20px;
        }
        
        .contact-icon-footer {
            min-width: 30px;
            color: var(--accent-color);
        }
        
        .contact-text-footer {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .newsletter-form {
            position: relative;
            margin-top: 20px;
        }
        
        .newsletter-input {
            height: 50px;
            border-radius: 50px;
            padding: 10px 20px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
        }
        
        .newsletter-input:focus {
            outline: none;
        }
        
        .newsletter-btn {
            position: absolute;
            right: 5px;
            top: 5px;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            border: none;
            color: white;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .newsletter-btn:hover {
            background-color: white;
            color: var(--accent-color);
        }
        
        .copyright {
            padding: 25px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 50px;
            text-align: center;
        }
        
        .copyright p {
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }
        
        .copyright a {
            color: var(--accent-color);
            transition: all 0.3s;
        }
        
        .copyright a:hover {
            color: white;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background-color: var(--primary-color);
        }
        
        /* Responsive Styles */
        @media (max-width: 991px) {
            .navbar-collapse {
                background-color: white;
                padding: 20px;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                margin-top: 15px;
            }
            
            .nav-link {
                margin: 10px 0;
            }
            
            .slider-content h1 {
                font-size: 36px;
            }
            
            .slider-content p {
                font-size: 16px;
            }
            
            section {
                padding: 80px 0;
            }
            
            .section-heading h2 {
                font-size: 30px;
            }
            
            .section-heading p {
                font-size: 16px;
            }
        }
        
        @media (max-width: 767px) {
            .slider-content h1 {
                font-size: 28px;
            }
            
            .slider-content p {
                font-size: 14px;
            }
            
            .btn-primary, .btn-outline-light {
                padding: 10px 20px;
                font-size: 14px;
            }
            
            section {
                padding: 60px 0;
            }
            
            .section-heading h2 {
                font-size: 26px;
            }
            
            .section-heading p {
                font-size: 14px;
            }
            
            .stat-number {
                font-size: 36px;
            }
            
            .stat-text {
                font-size: 14px;
            }
        }
        
        @media (max-width: 575px) {
            .slider-content h1 {
                font-size: 24px;
            }
            
            .slider-content p {
                font-size: 13px;
                margin-bottom: 20px;
            }
            
            .btn-primary, .btn-outline-light {
                padding: 8px 15px;
                font-size: 13px;
            }
            
            .section-heading h2 {
                font-size: 22px;
            }
            
            .about-box h3, .service-content h3, .team-content h3 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    
    <!-- Header -->
    <header id="header" class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="#hero">
                    <i class="fas fa-piggy-bank me-2"></i>EagleSave
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#hero">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#team">Our Team</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonials">Testimonials</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>
                    <div class="auth-btn ms-3">
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <a href="javascript:void(0)" onclick="event.preventDefault(); this.closest('form').submit();" 
                                class="custom-btn logout-btn">
                                    Logout <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="custom-btn login-btn">
                                Login <i class="fas fa-sign-in-alt"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Hero Section with Slider -->
    <section id="hero" class="hero-section">
        <div class="hero-slider">
            <div class="slider-item" style="background-image: url('{{ asset('frontend/assets/image/img1.png') }}');">

                <div class="slider-overlay"></div>
                <div class="slider-content">
                    <h1 class="animate__animated animate__fadeInDown">Secure Your Financial Future</h1>
                    <p class="animate__animated animate__fadeInUp">Join our thrift contribution platform and start saving for your dreams with a community that supports your financial goals.</p>
                    <div>
                        <a href="#" class="btn btn-primary animate__animated animate__fadeInLeft">Get Started</a>
                        <a href="#about" class="btn btn-outline-light animate__animated animate__fadeInRight">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="slider-item" style="background-image: url('{{ asset('frontend/assets/image/img2.png') }}');">
                <div class="slider-overlay"></div>
                <div class="slider-content">
                    <h1 class="animate__animated animate__fadeInDown">Building Wealth Together</h1>
                    <p class="animate__animated animate__fadeInUp">Our thrift contribution platform helps you develop financial discipline and achieve your long-term financial goals.</p>
                    <div>
                        <a href="#" class="btn btn-primary animate__animated animate__fadeInLeft">Join Today</a>
                        <a href="#services" class="btn btn-outline-light animate__animated animate__fadeInRight">Our Services</a>
                    </div>
                </div>
            </div>
            <div class="slider-item" style="background-image: url('{{ asset('frontend/assets/image/img4.png') }}');">
                <div class="slider-overlay"></div>
                <div class="slider-content">
                    <h1 class="animate__animated animate__fadeInDown">Smart Savings, Better Future</h1>
                    <p class="animate__animated animate__fadeInUp">Experience the power of collective saving with our transparent and secure thrift contribution system.</p>
                    <div>
                        <a href="#" class="btn btn-primary animate__animated animate__fadeInLeft">Start Saving</a>
                        <a href="#testimonials" class="btn btn-outline-light animate__animated animate__fadeInRight">Success Stories</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-heading">
                <h2>About EagleSave</h2>
                <p>We are a premier thrift contribution platform dedicated to helping individuals achieve financial freedom through disciplined saving and community support.</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="about-box">
                        <div class="about-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p>To empower individuals to build wealth through disciplined saving habits and collaborative financial practices that ensure long-term prosperity.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-box">
                        <div class="about-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Our Vision</h3>
                        <p>To become the leading thrift contribution platform in Nigeria, known for reliability, transparency, and excellence in helping people achieve their financial goals.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="about-box">
                        <div class="about-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Our Values</h3>
                        <p>Integrity, transparency, security, and community are the core values that guide our operations and ensure we maintain our members' trust.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="about-box">
                        <div class="about-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Community First</h3>
                        <p>We believe in the power of community and collective effort in achieving financial goals through mutual support and accountability.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="about-box">
                        <div class="about-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3>Secure Platform</h3>
                        <p>Your contributions are secured with state-of-the-art encryption and protected by our robust financial management systems.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="about-box">
                        <div class="about-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Our History</h3>
                        <p>Founded in 2020, EagleSave has helped over 10,000 members save effectively and achieve their financial dreams through consistent contributions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-box">
                        <div class="stat-number" data-count="10245">0</div>
                        <div class="stat-text">Active Members</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-box">
                        <div class="stat-number" data-count="578">0</div>
                        <div class="stat-text">Thrift Groups</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-box">
                        <div class="stat-number" data-count="95">0</div>
                        <div class="stat-text">Percentage Success</div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-box">
                        <div class="stat-number" data-count="125">0</div>
                        <div class="stat-text">Million ₦ Saved</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-heading">
                <h2>Our Services</h2>
                <p>We offer comprehensive thrift contribution services designed to help you save effectively and achieve your financial goals.</p>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-img" style="background-image: url('frontend/assets/image/8.png');"></div>
                        <div class="service-content">
                            <h3>Personal Thrift</h3>
                            <p>Start your personal savings journey with our flexible personal thrift plans that adapt to your income level and financial goals.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-card">
                       <div class="service-img" style="background-image: url('frontend/assets/image/10.png');"></div>
                        <div class="service-content">
                            <h3>Goal-Based Saving</h3>
                            <p>Set specific financial goals like buying a car, paying for education, or starting a business, and we'll help you achieve them.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-img" style="background-image: url('frontend/assets/image/7.png');"></div>
                        <div class="service-content">
                            <h3>Emergency Loans</h3>
                            <p>Access emergency loans based on your contribution history and credit score to handle unforeseen financial situations.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>
    
    <!-- Team Section -->
    <section id="team" class="team-section">
        <div class="container">
            <div class="section-heading">
                <h2>Our Team</h2>
                <p>Meet our dedicated team of professionals committed to helping you achieve your financial goals.</p>
            </div>
            
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="{{ asset('frontend/assets/image/ceo.png') }}" alt="Team Member">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="team-content">
                            <h3>John Adewale</h3>
                            <span>Chief Executive Officer</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="{{ asset('frontend/assets/image/fin.png') }}" alt="Team Member">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="team-content">
                            <h3>Sarah Okonkwo</h3>
                            <span>Chief Financial Officer</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="{{ asset('frontend/assets/image/operation.png') }}" alt="Team Member">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="team-content">
                            <h3>David Olawale</h3>
                            <span>Operations Manager</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-card">
                        <div class="team-img">
                            <img src="{{ asset('frontend/assets/image/customer_relation.png') }}" alt="Team Member">
                            <div class="team-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="team-content">
                            <h3>Amina Ibrahim</h3>
                            <span>Customer Relations</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="section-heading">
                <h2>Testimonials</h2>
                <p>Hear what our satisfied members have to say about their experience with EagleSave.</p>
            </div>
            
            <div class="testimonial-slider">
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-img">
                        <img src="{{ asset('frontend/assets/image/t1.png') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"EagleSave has completely transformed how I save money. Their personal thrift plan helped me save enough for my dream car in just 18 months."</p>
                    <h4 class="testimonial-name">Chioma Nwosu</h4>
                    <p class="testimonial-position">Business Owner</p>
                </div>
                
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-img">
                        <img src="{{ asset('frontend/assets/image/t2.png') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="testimonial-text">"The group contribution feature helped our office team save collectively for our end-of-year vacation. The platform is user-friendly and secure."</p>
                    <h4 class="testimonial-name">Oluwaseun Adekunle</h4>
                    <p class="testimonial-position">HR Manager</p>
                </div>
                
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-img">
                        <img src="{{ asset('frontend/assets/image/t3.png') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"As a student, EagleSave's goal-based saving helped me save for my tuition fees. Their financial education resources also improved my money management skills."</p>
                    <h4 class="testimonial-name">Ibrahim Mohammed</h4>
                    <p class="testimonial-position">University Student</p>
                </div>
                
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="testimonial-img">
                        <img src="{{ asset('frontend/assets/image/t4.png') }}" alt="Testimonial">
                    </div>
                    <div class="testimonial-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The emergency loan feature saved me during a family emergency. The process was fast, and the interest rate was fair. Thank you, EagleSave!"</p>
                    <h4 class="testimonial-name">Grace Okafor</h4>
                    <p class="testimonial-position">Teacher</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section id="faq" class="faq-section">
        <div class="container">
            <div class="section-heading">
                <h2>Frequently Asked Questions</h2>
                <p>Find answers to commonly asked questions about our thrift contribution services.</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-accordion">
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                            <div class="faq-header">
                                <h3>How does the thrift contribution system work?</h3>
                            </div>
                            <div class="faq-content">
                                <div class="faq-text">
                                    Our thrift contribution system allows members to make regular contributions to their personal savings account or group thrift. The platform manages the collection, safekeeping, and disbursement of funds according to the agreed terms and schedule.
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="faq-header">
                                <h3>How secure is my money with EagleSave?</h3>
                            </div>
                            <div class="faq-content">
                                <div class="faq-text">
                                    We employ bank-grade security measures to protect your funds. Your contributions are held in secure trust accounts with our partner banks, and all transactions are encrypted. We also have insurance coverage for added protection.
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                            <div class="faq-header">
                                <h3>What is the minimum contribution amount?</h3>
                            </div>
                            <div class="faq-content">
                                <div class="faq-text">
                                    The minimum contribution amount is ₦5,000 per month for individual contributions. For group thrifts, the minimum can be set by the group administrator but cannot be less than ₦3,000 per person per month.
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="faq-header">
                                <h3>How do I withdraw my savings?</h3>
                            </div>
                            <div class="faq-content">
                                <div class="faq-text">
                                    Withdrawals can be made at the end of your contribution cycle. Simply log into your account, navigate to the withdrawal section, specify the amount, and follow the prompts. Funds are typically transferred to your registered bank account within 24-48 hours.
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                            <div class="faq-header">
                                <h3>What happens if I miss a contribution?</h3>
                            </div>
                            <div class="faq-content">
                                <div class="faq-text">
                                    If you miss a contribution, you'll receive a notification and have a grace period of 3 days to make the payment. After the grace period, a late payment fee of 5% of your contribution amount will be applied. Consistent missed payments may affect your eligibility for loans.
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                            <div class="faq-header">
                                <h3>How do I qualify for an emergency loan?</h3>
                            </div>
                            <div class="faq-content">
                                <div class="faq-text">
                                    To qualify for an emergency loan, you must have been an active member for at least 6 months with a consistent contribution record. Loan amounts are typically up to 50% of your total savings, and the approval process takes 24-72 hours.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-heading">
                <h2>Contact Us</h2>
                <p>Have questions or need assistance? Reach out to our friendly support team.</p>
            </div>
            
            <div class="row">
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-info">
                        <h3>Get In Touch</h3>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Our Location</h5>
                                <p>123 Savings Avenue, Mowe, Ogun State, Nigeria</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Phone Number</h5>
                                <p>+234 803 123 4567</p>
                                <p>+234 905 678 9012</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Email Address</h5>
                                <p>info@eaglesave.com</p>
                                <p>support@eaglesave.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Working Hours</h5>
                                <p>Monday - Friday: 8:00 AM - 6:00 PM</p>
                                <p>Saturday: 9:00 AM - 1:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-form">
                        <form id="contactForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control" placeholder="Your Phone">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Subject">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" placeholder="Your Message" required></textarea>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-about">
                        <a href="#" class="footer-logo"><i class="fas fa-piggy-bank me-2"></i>EagleSave</a>
                        <p>EagleSave is a premier thrift contribution platform dedicated to helping individuals achieve financial freedom through disciplined saving and community support.</p>
                        <div class="footer-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h4 class="footer-heading">Quick Links</h4>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#hero"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                        <li><a href="#team"><i class="fas fa-chevron-right"></i> Our Team</a></li>
                        <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Testimonials</a></li>
                        <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-heading">Our Services</h4>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Personal Thrift</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Group Contributions</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Emergency Loans</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Financial Education</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Goal-Based Saving</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Investment Opportunities</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer-heading">Newsletter</h4>
                    <p class="text-light opacity-75">Subscribe to our newsletter to receive updates and financial tips.</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Your Email" required>
                        <button type="submit" class="newsletter-btn"><i class="fas fa-paper-plane"></i></button>
                    </form>
                    <ul class="contact-links list-unstyled mt-4">
                        <li>
                            <div class="contact-icon-footer">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-text-footer">
                                +234 803 123 4567
                            </div>
                        </li>
                        <li>
                            <div class="contact-icon-footer">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text-footer">
                                info@eaglesave.com
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <div class="container">
                <p>&copy; 2025 <span>EagleSave</span>. All Rights Reserved. Designed by <a href="#">YourName</a></p>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>
    
    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <!-- Main JavaScript -->
    <script>
        $(document).ready(function() {
            // Preloader
            $(window).on('load', function() {
                $('#preloader').fadeOut('slow');
            });
            
            // Initialize AOS
            AOS.init({
                duration: 1000,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
            
            // Sticky Navbar
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('#header .navbar').addClass('navbar-scrolled');
                    $('.back-to-top').addClass('active');
                } else {
                    $('#header .navbar').removeClass('navbar-scrolled');
                    $('.back-to-top').removeClass('active');
                }
            });
            
            // Back to top button
            $('.back-to-top').click(function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
            
            // Smooth scroll for links with hashes
            $('a.nav-link').on('click', function(e) {
                if (this.hash !== '') {
                    e.preventDefault();
                    const hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top - 80
                    }, 800);
                    
                    // Add active class to navigation items
                    $('a.nav-link').removeClass('active');
                    $(this).addClass('active');
                    
                    // Close mobile navigation
                    $('.navbar-collapse').collapse('hide');
                }
            });
            
            // Add active class to navigation based on scroll position
            $(window).scroll(function() {
                const scrollDistance = $(window).scrollTop() + 100;
                
                $('section').each(function(i) {
                    if ($(this).position().top <= scrollDistance) {
                        $('a.nav-link.active').removeClass('active');
                        $('a.nav-link').eq(i).addClass('active');
                    }
                });
            });
            
            // Hero Slider
            $('.hero-slider').slick({
                autoplay: true,
                autoplaySpeed: 5000,
                dots: true,
                fade: true,
                arrows: false,
                pauseOnHover: false,
                pauseOnFocus: false
            });
            
            // Testimonial Slider
            $('.testimonial-slider').slick({
                autoplay: true,
                autoplaySpeed: 4000,
                dots: true,
                arrows: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                pauseOnHover: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
            
            // FAQ Accordion
            $('.faq-header').click(function() {
                $(this).toggleClass('active');
                const content = $(this).next('.faq-content');
                
                if (content.css('max-height') !== '0px') {
                    content.css('max-height', '0px');
                } else {
                    content.css('max-height', content.prop('scrollHeight') + 'px');
                }
                
                // Close other open FAQs
                $('.faq-header').not(this).removeClass('active');
                $('.faq-content').not(content).css('max-height', '0px');
            });
            
            // Counter Animation
            function startCounter() {
                $('.stat-number').each(function() {
                    const $this = $(this);
                    const countTo = $this.attr('data-count');
                    
                    $({ countNum: 0 }).animate({
                        countNum: countTo
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
                });
            }
            
            // Start counter when stats section is in viewport
            const statsSection = document.querySelector('.stats-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        startCounter();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            if (statsSection) {
                observer.observe(statsSection);
            }
            
            // Contact Form Validation
            $('#contactForm').submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const name = form.find('input[type="text"]').val();
                
                // Simple form validation
                if (form[0].checkValidity() === false) {
                    e.stopPropagation();
                    form.addClass('was-validated');
                } else {
                    // Show success message (in a real application, this would be an AJAX call)
                    form.html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle me-2"></i>Thank you ' + name + '! Your message has been sent successfully. We will contact you soon.</div>');
                }
            });
            
            // Newsletter Form
            $('.newsletter-form').submit(function(e) {
                e.preventDefault();
                const email = $(this).find('.newsletter-input').val();
                
                if (email) {
                    // Show success message (in a real application, this would be an AJAX call)
                    $(this).html('<p class="text-light mt-3"><i class="fas fa-check-circle me-2"></i>Thank you! You have been subscribed to our newsletter.</p>');
                }
            });
        });
    </script>
    
    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "EagleSave",
        "url": "https://www.eaglesave.com",
        "logo": "https://www.eaglesave.com/images/logo.png",
        "description": "EagleSave is a premier thrift contribution platform helping you save for your future goals. Join our community for financial freedom and security.",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Savings Avenue",
            "addressLocality": "Mowe",
            "addressRegion": "Ogun State",
            "postalCode": "110001",
            "addressCountry": "Nigeria"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+234-803-123-4567",
            "contactType": "customer service",
            "availableLanguage": ["English"]
        },
        "sameAs": [
            "https://www.facebook.com/eaglesave",
            "https://www.twitter.com/eaglesave",
            "https://www.instagram.com/eaglesave",
            "https://www.linkedin.com/company/eaglesave"
        ]
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "How does the thrift contribution system work?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Our thrift contribution system allows members to make regular contributions to their personal savings account or group thrift. The platform manages the collection, safekeeping, and disbursement of funds according to the agreed terms and schedule."
                }
            },
            {
                "@type": "Question",
                "name": "How secure is my money with EagleSave?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "We employ bank-grade security measures to protect your funds. Your contributions are held in secure trust accounts with our partner banks, and all transactions are encrypted. We also have insurance coverage for added protection."
                }
            },
            {
                "@type": "Question",
                "name": "What is the minimum contribution amount?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "The minimum contribution amount is ₦5,000 per month for individual contributions. For group thrifts, the minimum can be set by the group administrator but cannot be less than ₦3,000 per person per month."
                }
            },
            {
                "@type": "Question",
                "name": "How do I withdraw my savings?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Withdrawals can be made at the end of your contribution cycle. Simply log into your account, navigate to the withdrawal section, specify the amount, and follow the prompts. Funds are typically transferred to your registered bank account within 24-48 hours."
                }
            },
            {
                "@type": "Question",
                "name": "What happens if I miss a contribution?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "If you miss a contribution, you'll receive a notification and have a grace period of 3 days to make the payment. After the grace period, a late payment fee of 5% of your contribution amount will be applied. Consistent missed payments may affect your eligibility for loans."
                }
            },
            {
                "@type": "Question",
                "name": "How do I qualify for an emergency loan?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "To qualify for an emergency loan, you must have been an active member for at least 6 months with a consistent contribution record. Loan amounts are typically up to 50% of your total savings, and the approval process takes 24-72 hours."
                }
            }
        ]
    }
    </script>
</body>
</html>