@extends('frontend.master_home')
@section('title', 'About Us')
@section('home_content')

@php
   $assetBase = asset('frontend/assets');
@endphp
    
    <!-- Banner Start -->
    <section class="breadcrumb-bannner bg-fixed style1" data-background="{{ $assetBase }}/images/hero/breadcrumb-banner1.png">
        <div class="container ">
            <div class="banner__content">
                <h1 class="banner__title mb-3 display-4 text-white wow fadeInLeft" data-wow-duration="0.8s">@yield('title')</h1> 
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb wow fadeInRight" data-wow-duration="0.8s">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Banner End -->

<!-- Our Story Section -->
<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">Our Story</span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Revolutionizing Financial Analysis Since 2019
                    </h2>
                    <div class="section__content-text wow fadeInDown" data-wow-duration="0.8s">
                        <p class="mb-4">
                            NexTrade was founded in 2019 by a team of financial analysts, data scientists, and professional traders united by a common vision: to democratize access to institutional-grade trading tools and market intelligence.
                        </p>
                        <p class="mb-4">
                            What began as a specialized signal generation system for a select group of professional traders has evolved into a comprehensive trading ecosystem serving over 66,000 traders worldwide. Our journey has been driven by continuous innovation, rigorous testing, and an unwavering commitment to trading excellence.
                        </p>
                        <p>
                            Today, NexTrade stands at the intersection of advanced technology and financial expertise, providing traders of all levels with the analytical edge needed to navigate global markets with confidence.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-stats p-4 p-lg-5 rounded-3 cmn-bg2 mt-5 mt-lg-0 wow fadeInUp" data-wow-duration="0.8s">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="stat-item text-center p-3 white-bg rounded-3">
                                <h2 class="mb-1 primary-clr">2019</h2>
                                <p class="mb-0">Founded</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item text-center p-3 white-bg rounded-3">
                                <h2 class="mb-1 primary-clr">66K+</h2>
                                <p class="mb-0">Active Traders</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item text-center p-3 white-bg rounded-3">
                                <h2 class="mb-1 primary-clr">42</h2>
                                <p class="mb-0">Global Markets</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item text-center p-3 white-bg rounded-3">
                                <h2 class="mb-1 primary-clr">24/7</h2>
                                <p class="mb-0">Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">Our Mission</span>
                    <h2 class="section__header-title mb-4 wow fadeInUp" data-wow-duration="0.8s">
                        Empowering Traders Through Technology & Education
                    </h2>
                    <div class="mission-statement p-4 p-md-5 white-bg rounded-3 wow fadeInUp" data-wow-duration="0.8s">
                        <p class="fs-5 mb-0">
                            "Our mission is to level the playing field in financial markets by providing traders with institutional-quality analytical tools, unbiased market intelligence, and comprehensive educational resources. We believe that by combining advanced technology with accessible knowledge, we can empower traders of all levels to make more informed decisions and achieve sustainable trading success."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">Core Values</span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        The Principles That Drive Us
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Our company culture and product development are guided by these fundamental values.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Value 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="value-card text-center h-100 white-bg rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <div class="value-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-graph-up-arrow fs-2"></i>
                    </div>
                    <h3 class="value-title mb-3">Data-Driven Precision</h3>
                    <p class="mb-0">
                        We base all our analytics, signals, and recommendations on rigorous quantitative analysis rather than opinion or speculation.
                    </p>
                </div>
            </div>

            <!-- Value 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="value-card text-center h-100 white-bg rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="value-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-check fs-2"></i>
                    </div>
                    <h3 class="value-title mb-3">Absolute Integrity</h3>
                    <p class="mb-0">
                        We maintain strict independence in our broker evaluations and market analysis, ensuring unbiased information for our users.
                    </p>
                </div>
            </div>

            <!-- Value 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="value-card text-center h-100 white-bg rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <div class="value-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-lightning-charge fs-2"></i>
                    </div>
                    <h3 class="value-title mb-3">Relentless Innovation</h3>
                    <p class="mb-0">
                        We continuously refine our algorithms, expand our analytical capabilities, and develop new tools to stay ahead of market evolution.
                    </p>
                </div>
            </div>

            <!-- Value 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="value-card text-center h-100 white-bg rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                    <div class="value-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="bi bi-mortarboard fs-2"></i>
                    </div>
                    <h3 class="value-title mb-3">Educational Excellence</h3>
                    <p class="mb-0">
                        We believe in empowering traders through knowledge, providing comprehensive resources to build sustainable trading skills.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">Our Team</span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Meet Our Leadership
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Our diverse team combines decades of experience in finance, data science, and technology.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Team Member 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="team-card text-center h-100 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <div class="team-info p-4">
                        <h3 class="team-name mb-4">Alexander Chen</h3>
                        <p class="team-bio mb-4">
                            Former quantitative analyst at Goldman Sachs with 15+ years of market experience and a passion for algorithmic trading systems.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Team Member 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="team-card text-center h-100 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="team-info p-4">
                        <h3 class="team-name mb-4">Emma Johnston</h3>
                        <p class="team-bio mb-4">
                            Computer science PhD with specialization in machine learning and 10+ years developing high-frequency trading systems.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Team Member 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="team-card text-center h-100 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <div class="team-info p-4">
                        <h3 class="team-name mb-4">Marcus Johnson</h3>
                        <p class="team-bio mb-4">
                            Former hedge fund analyst with expertise in global macro strategies and 12+ years of institutional trading experience.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Team Member 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="team-card text-center h-100 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                    <div class="team-info p-4">
                        <h3 class="team-name mb-4">Ananya Patel</h3>
                        <p class="team-bio mb-4">
                            UX specialist with background in behavioral economics, focused on making complex trading tools accessible to all skill levels.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">Our Achievements</span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Milestones That Define Our Journey
                    </h2>
                    <div class="achievement-timeline mb-4">
                        <div class="timeline-item d-flex mb-4 wow fadeInUp" data-wow-duration="0.8s">
                            <div class="timeline-year primary-clr fw-bold me-4">2019</div>
                            <div class="timeline-content">
                                <h4 class="mb-2">Company Founded</h4>
                                <p class="mb-0">Launched with proprietary signal generation algorithm serving 500 beta users</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex mb-4 wow fadeInUp" data-wow-duration="0.8s">
                            <div class="timeline-year primary-clr fw-bold me-4">2020</div>
                            <div class="timeline-content">
                                <h4 class="mb-2">Platform Expansion</h4>
                                <p class="mb-0">Released comprehensive technical analysis suite and broker integration capabilities</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex mb-4 wow fadeInUp" data-wow-duration="0.8s">
                            <div class="timeline-year primary-clr fw-bold me-4">2021</div>
                            <div class="timeline-content">
                                <h4 class="mb-2">Series A Funding</h4>
                                <p class="mb-0">Secured $12M investment to accelerate development and market expansion</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex mb-4 wow fadeInUp" data-wow-duration="0.8s">
                            <div class="timeline-year primary-clr fw-bold me-4">2022</div>
                            <div class="timeline-content">
                                <h4 class="mb-2">Global Expansion</h4>
                                <p class="mb-0">Reached 25,000 active users across 65 countries with multi-language support</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex mb-4 wow fadeInUp" data-wow-duration="0.8s">
                            <div class="timeline-year primary-clr fw-bold me-4">2023</div>
                            <div class="timeline-content">
                                <h4 class="mb-2">Algorithm 2.0</h4>
                                <p class="mb-0">Released next-generation signal system with 37% improved accuracy</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex wow fadeInUp" data-wow-duration="0.8s">
                            <div class="timeline-year primary-clr fw-bold me-4">2024</div>
                            <div class="timeline-content">
                                <h4 class="mb-2">FinTech Award Winner</h4>
                                <p class="mb-0">Recognized as "Most Innovative Trading Technology" by Financial Markets Association</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="achievements-right mt-5 mt-lg-0">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="achievement-card white-bg rounded-3 p-4 h-100 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-award-fill primary-clr fs-2 me-3"></i>
                                    <h3 class="mb-0">Recognition</h3>
                                </div>
                                <p class="mb-0">
                                    Named among the "Top 10 FinTech Innovators" for three consecutive years by Financial Technology Review.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="achievement-card white-bg rounded-3 p-4 h-100 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-graph-up primary-clr fs-2 me-3"></i>
                                    <h3 class="mb-0">Growth</h3>
                                </div>
                                <p class="mb-0">
                                    Achieved 185% year-over-year user growth with industry-leading 92% retention rate.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="achievement-card white-bg rounded-3 p-4 h-100 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-patch-check-fill primary-clr fs-2 me-3"></i>
                                    <h3 class="mb-0">Quality</h3>
                                </div>
                                <p class="mb-0">
                                    Maintained 99.98% platform uptime with signal accuracy exceeding industry benchmarks by 42%.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="achievement-card white-bg rounded-3 p-4 h-100 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-people-fill primary-clr fs-2 me-3"></i>
                                    <h3 class="mb-0">Community</h3>
                                </div>
                                <p class="mb-0">
                                    Built a thriving community of 66,000+ traders across 82 countries worldwide.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Contact CTA Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="cta-wrapper py-5">
                    <h2 class="section__header-title mb-4 wow fadeInUp" data-wow-duration="0.8s">
                        Join the NexTrade Community
                    </h2>
                    <p class="section__header-content wow fadeInDown mb-4" data-wow-duration="0.8s">
                        Experience the difference that professional-grade trading tools and analysis can make in your trading journey.
                    </p>
                    <div class="cta-buttons d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a href="#" class="btn_theme btn_theme_active">Get Started <i class="bi bi-arrow-up-right"></i><span></span></a>
                        <a href="#" class="btn_theme">Contact Us <i class="bi bi-envelope"></i><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection