@extends('frontend.master_home')
@section('title', 'Broker Analysis')
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

<!-- Broker Analysis Overview -->
<section class="section">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Independent Evaluation
                    </span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Scientific Broker Assessment
                    </h2>
                    <p class="section__header-content mb-4 wow fadeInDown" data-wow-duration="0.8s">
                        NexTrade's Broker Analysis delivers comprehensive, data-driven evaluations of trading platforms to help you select the optimal broker for your specific trading requirements.
                    </p>
                    <p class="wow fadeInDown" data-wow-duration="0.8s">
                        Our rigorous assessment methodology evaluates over 50 critical metrics across execution quality, platform reliability, fee structures, and regulatory compliance to provide truly objective broker comparisons.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="broker-overview-image position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s">
                    <img src="{{ $assetBase }}/images/about/broker-analysis.jpg" alt="NexTrade Broker Analysis" class="w-100" width="600" height="400">
                    <div class="overlay-stats position-absolute bottom-0 start-0 w-100 p-4 bg-gradient-dark">
                        <div class="row text-white text-center">
                            <div class="col-4">
                                <h3 class="mb-0">50+</h3>
                                <p class="mb-0 fs-small">Evaluation Metrics</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0">72</h3>
                                <p class="mb-0 fs-small">Brokers Analyzed</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0">Quarterly</h3>
                                <p class="mb-0 fs-small">Updates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Brokers Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Top-Rated Platforms
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Elite Broker Selection
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Discover our highest-rated brokers based on comprehensive performance evaluations and user experience metrics.
                    </p>
                </div>
            </div>
        </div>

        <div class="broker-review-wrap">
            <!-- Broker 1 -->
            <div class="broker-review-inner white-bg">
                <span class="badge fs-small">VERIFIED EXCELLENCE</span>
                <span class="interest-badge text-uppercase">
                    TOP RECOMMENDED
                </span>
                <div class="broker-review-item style1 style02 d-flex align-items-center position-relative wow fadeInUp" data-wow-duration="0.8s">
                    <div class="broker-thumb-area">
                        <div class="thumb rounded-circle">
                            <img src="{{ $assetBase }}/images/broker/ic-markets.png" alt="IC Markets logo" class="rounded-3" width="80" height="80">
                        </div>
                        <div class="cont">
                            <h3 class="mb-1 black-clr">IC Markets</h3>
                            <p class="black-clr">
                                Global liquidity provider with ECN connectivity, offering institutional-grade execution and ultra-tight spreads.
                            </p>
                        </div>
                    </div>
                    <div class="custom-line d-xl-block d-none"></div>
                    <ul class="d-grid gap-1">
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Ultra-Fast Execution (< 40ms)</li>
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Advanced MT4/MT5 Integration</li>
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Transparent Pricing Structure</li>
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Multi-Tier Security Protocols</li>
                    </ul>
                    <div class="broker-ratting-box d-inline-block border rounded-3 text-center py-4 px-3">
                        <div class="d-flex align-items-center justify-content-center gap-1 mb-xxl-3 mb-2">
                            <div class="star_review justify-content-center">
                                <i class="bi bi-star-fill secondary-clr2 headingFive"></i>
                            </div>
                            <h5 class="pra-clr mb-0">
                                97/100
                            </h5>
                        </div>
                        <p class="pra-clr customer-text text-center">
                            NexTrade <br> Rating Score
                        </p>
                    </div>
                    <div class="breoker-button-area text-center">
                        <span class="terms d-block mb-2">
                            · Trading involves risk · Terms Apply
                        </span>
                        <div class="text-center mb-3">
                            <a href="#" class="btn_theme d-flex btn_theme_active">Open Account<i class="bi bi-arrow-up-right"></i><span></span></a>
                        </div>
                        <div class="detail-btn text-center">
                            <a href="#" class="primary-clr m-auto d-flex align-items-center justify-content-center view-btn bg-transparent fw-semibold gap-2">
                                Full Analysis <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Broker 2 -->
            <div class="broker-review-inner white-bg">
                <span class="badge">ALGORITHMIC TRADING</span>
                <span class="interest-badge text-uppercase">
                    ADVANCED TOOLS
                </span>
                <div class="broker-review-item style1 style02 d-flex align-items-center position-relative wow fadeInUp" data-wow-duration="0.8s">
                    <div class="broker-thumb-area">
                        <div class="thumb rounded-circle">
                            <img src="{{ $assetBase }}/images/broker/robofores.png" alt="RoboForex logo" class="rounded-3" width="80" height="80">
                        </div>
                        <div class="cont">
                            <h3 class="mb-1 black-clr">RoboForex</h3>
                            <p class="black-clr">
                                Specialized in automated trading solutions with proprietary algorithm development tools and competitive fee structures.
                            </p>
                        </div>
                    </div>
                    <div class="custom-line d-xl-block d-none"></div>
                    <ul class="d-grid gap-1">
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Advanced API Connectivity</li>
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Custom Algorithm Development</li>
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Multiple Account Structures</li>
                        <li class="d-flex align-items-center gap-xxl-2 gap-1 pra-clr text-nowrap fs-small"><i class="bi bi-check2-circle primary-clr headingSix"></i>Competitive Leverage Options</li>
                    </ul>
                    <div class="broker-ratting-box d-inline-block border rounded-3 text-center py-4 px-3">
                        <div class="d-flex align-items-center justify-content-center gap-1 mb-xxl-3 mb-2">
                            <div class="star_review justify-content-center">
                                <i class="bi bi-star-fill secondary-clr2 headingFive"></i>
                            </div>
                            <h5 class="pra-clr mb-0">
                                93/100
                            </h5>
                        </div>
                        <p class="pra-clr customer-text text-center">
                            NexTrade <br> Rating Score
                        </p>
                    </div>
                    <div class="breoker-button-area text-center">
                        <span class="terms d-block mb-2">
                            · Trading involves risk · Terms Apply
                        </span>
                        <div class="text-center mb-3">
                            <a href="#" class="btn_theme d-flex btn_theme_active">Open Account<i class="bi bi-arrow-up-right"></i><span></span></a>
                        </div>
                        <div class="detail-btn text-center">
                            <a href="#" class="primary-clr m-auto d-flex align-items-center justify-content-center view-btn bg-transparent fw-semibold gap-2">
                                Full Analysis <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="mt-lg-5 mt-4 text-center">
                <a href="#" class="btn_theme">Compare All Brokers<i class="bi bi-arrow-up-right"></i><span></span></a>
            </div>
        </div>
    </div>
</section>

<!-- Evaluation Methodology -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Evaluation Process
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Our Broker Assessment Methodology
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Discover how NexTrade conducts thorough, unbiased evaluations of trading platforms to provide you with reliable broker recommendations.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Methodology Step 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="methodology-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <div class="methodology-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                        <h3 class="mb-0">1</h3>
                    </div>
                    <h4 class="mb-3">Initial Verification</h4>
                    <p class="mb-0">
                        We conduct thorough regulatory checks, verify licensing status, and examine company history, including financial stability and regulatory compliance record.
                    </p>
                </div>
            </div>

            <!-- Methodology Step 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="methodology-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="methodology-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                        <h3 class="mb-0">2</h3>
                    </div>
                    <h4 class="mb-3">Trading Conditions</h4>
                    <p class="mb-0">
                        We analyze spreads, fees, leverage options, margin requirements, and account types through actual trading across multiple instruments and market conditions.
                    </p>
                </div>
            </div>

            <!-- Methodology Step 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="methodology-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <div class="methodology-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                        <h3 class="mb-0">3</h3>
                    </div>
                    <h4 class="mb-3">Execution Quality</h4>
                    <p class="mb-0">
                        We measure execution speed, slippage statistics, order fill rates, and platform stability through algorithmic testing across various market conditions.
                    </p>
                </div>
            </div>

            <!-- Methodology Step 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="methodology-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                    <div class="methodology-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                        <h3 class="mb-0">4</h3>
                    </div>
                    <h4 class="mb-3">User Experience</h4>
                    <p class="mb-0">
                        We evaluate platform usability, feature set, mobile capabilities, and customer service responsiveness through direct testing and user feedback analysis.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="#" class="btn_theme btn_theme_active">View Full Methodology <i class="bi bi-arrow-up-right"></i><span></span></a>
            </div>
        </div>
    </div>
</section>

<!-- Broker Comparison Tool -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Comparison Tool
                    </span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Find Your Ideal Trading Platform
                    </h2>
                    <p class="section__header-content mb-4 wow fadeInDown" data-wow-duration="0.8s">
                        Our interactive comparison tool allows you to evaluate brokers side-by-side across dozens of key metrics tailored to your trading needs.
                    </p>
                    <p class="wow fadeInDown mb-4" data-wow-duration="0.8s">
                        Customize your comparison criteria based on your trading style, preferred asset classes, and specific platform requirements to find your perfect match.
                    </p>
                    <div class="wow fadeInUp" data-wow-duration="0.8s">
                        <a href="#" class="btn_theme mb-2 mb-sm-0 me-sm-2">Launch Comparison Tool <i class="bi bi-arrow-up-right"></i><span></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="comparison-tool-wrapper mt-5 mt-lg-0 position-relative wow fadeInUp" data-wow-duration="0.8s">
                    <img src="{{ $assetBase }}/images/tools/comparison-tool.jpg" alt="Broker Comparison Tool" class="img-fluid rounded-3" width="700" height="450">
                    <div class="tool-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <a href="#" class="video-btn bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-play-fill fs-1 text-primary"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Broker Categories -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Specialized Platforms
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Brokers By Trading Style
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Find the perfect trading platform based on your specific trading approach and requirements.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Scalping Category -->
            <div class="col-md-6 col-lg-3">
                <div class="category-card position-relative h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <img src="{{ $assetBase }}/images/categories/scalping.jpg" alt="Scalping Brokers" class="w-100 h-100" width="300" height="350" style="object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4">
                        <h3 class="text-white mb-2">Scalping Brokers</h3>
                        <p class="text-white mb-3">Ultra-fast execution and tight spreads for short-term traders</p>
                        <a href="#" class="btn_white_outline">Explore <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Algorithmic Category -->
            <div class="col-md-6 col-lg-3">
                <div class="category-card position-relative h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <img src="{{ $assetBase }}/images/categories/algo-trading.jpg" alt="Algorithmic Trading Brokers" class="w-100 h-100" width="300" height="350" style="object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4">
                        <h3 class="text-white mb-2">Algo Trading</h3>
                        <p class="text-white mb-3">Advanced API capabilities for automated strategy execution</p>
                        <a href="#" class="btn_white_outline">Explore <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Day Trading Category -->
            <div class="col-md-6 col-lg-3">
                <div class="category-card position-relative h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <img src="{{ $assetBase }}/images/categories/day-trading.jpg" alt="Day Trading Brokers" class="w-100 h-100" width="300" height="350" style="object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4">
                        <h3 class="text-white mb-2">Day Trading</h3>
                        <p class="text-white mb-3">Comprehensive analysis tools and efficient fee structures</p>
                        <a href="#" class="btn_white_outline">Explore <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Swing Trading Category -->
            <div class="col-md-6 col-lg-3">
                <div class="category-card position-relative h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                    <img src="{{ $assetBase }}/images/categories/swing-trading.jpg" alt="Swing Trading Brokers" class="w-100 h-100" width="300" height="350" style="object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4">
                        <h3 class="text-white mb-2">Swing Trading</h3>
                        <p class="text-white mb-3">Optimized for multi-day positions with superior charting</p>
                        <a href="#" class="btn_white_outline">Explore <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Common Questions
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Broker Selection FAQs
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Find answers to commonly asked questions about broker selection, account types, and platform features.
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="brokerFAQ">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item mb-3 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                How do you determine broker reliability and security?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#brokerFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    Our broker reliability assessment combines several verification steps. We check regulatory status across multiple jurisdictions, analyze financial stability through public records and annual reports, verify segregation of client funds, assess security infrastructure including encryption and authentication protocols, and conduct periodic stress tests of withdrawal processes. We also monitor ongoing regulatory compliance and incorporate user feedback regarding withdrawal experiences and customer service quality.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item mb-3 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                How do you measure execution quality and speed?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#brokerFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    We employ proprietary testing algorithms that execute thousands of trades across different market conditions to measure execution metrics. Key parameters include average execution speed (measured in milliseconds), slippage rates (both positive and negative), rejection rates, requote frequency, and order fill consistency. We test during both normal market conditions and high volatility periods to ensure consistent performance. Tests are conducted across multiple instruments and time frames to provide a comprehensive execution quality score that reflects real-world trading conditions.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item mb-3 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                What should I look for in a broker for my specific trading style?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#brokerFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    Different trading styles require specific broker capabilities. For scalping, prioritize ultra-fast execution (under 100ms) and tight spreads. Day traders should focus on platform stability, charting capabilities, and competitive day trading fees. Swing traders benefit from quality fundamental research and reliable overnight positions with reasonable swap rates. Algorithmic traders need robust API access, strategy backtesting tools, and reliable automation capabilities. Our comparison tool allows you to filter brokers based on your specific trading style and prioritize the features most relevant to your approach.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                How often do you update broker ratings and reviews?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#brokerFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    We maintain a comprehensive update schedule to ensure our broker evaluations remain accurate and relevant. All broker ratings undergo a complete reassessment quarterly to capture any changes in trading conditions, fee structures, or platform features. Additionally, we conduct spot checks monthly to verify critical metrics like execution quality and spreads remain consistent. Any significant regulatory events, company changes, or feature updates trigger immediate reviews outside our regular schedule. This approach ensures our users always have access to current, reliable broker information for their trading decisions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="#" class="btn_theme">View All FAQs <i class="bi bi-arrow-up-right"></i><span></span></a>
            </div>
        </div>
    </div>
</section>

<!-- Broker Resources Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Educational Resources
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Broker Selection Guides
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Comprehensive resources to help you make informed decisions when choosing a trading platform.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Resource 1 -->
            <div class="col-lg-4">
                <div class="resource-card white-bg h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <div class="resource-image">
                        <img src="{{ $assetBase }}/images/resources/broker-selection.jpg" alt="Essential Broker Selection Guide" class="w-100" width="400" height="240">
                    </div>
                    <div class="resource-content p-4">
                        <h3 class="resource-title mb-3">The Essential Broker Selection Guide</h3>
                        <p class="resource-excerpt mb-4">
                            A comprehensive walkthrough of key factors to consider when selecting a broker, including regulatory considerations, account types, and fee structures.
                        </p>
                        <a href="#" class="btn_theme">Download Guide <i class="bi bi-download"></i><span></span></a>
                    </div>
                </div>
            </div>

            <!-- Resource 2 -->
            <div class="col-lg-4">
                <div class="resource-card white-bg h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="resource-image">
                        <img src="{{ $assetBase }}/images/resources/execution-quality.jpg" alt="Understanding Execution Quality" class="w-100" width="400" height="240">
                    </div>
                    <div class="resource-content p-4">
                        <h3 class="resource-title mb-3">Understanding Execution Quality</h3>
                        <p class="resource-excerpt mb-4">
                            Learn how to evaluate broker execution quality, including latency, slippage, order types, and how these factors impact your trading profitability.
                        </p>
                        <a href="#" class="btn_theme">Download Guide <i class="bi bi-download"></i><span></span></a>
                    </div>
                </div>
            </div>

            <!-- Resource 3 -->
            <div class="col-lg-4">
                <div class="resource-card white-bg h-100 rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <div class="resource-image">
                        <img src="{{ $assetBase }}/images/resources/trading-platforms.jpg" alt="Trading Platform Comparison" class="w-100" width="400" height="240">
                    </div>
                    <div class="resource-content p-4">
                        <h3 class="resource-title mb-3">Trading Platform Comparison</h3>
                        <p class="resource-excerpt mb-4">
                            A detailed analysis of major trading platforms including MT4, MT5, cTrader and proprietary solutions with feature breakdowns and compatibility guides.
                        </p>
                        <a href="#" class="btn_theme">Download Guide <i class="bi bi-download"></i><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="cta-wrapper py-5">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Find Your Match
                    </span>
                    <h2 class="section__header-title my-4 wow fadeInUp" data-wow-duration="0.8s">
                        Start Your Broker Comparison Today
                    </h2>
                    <p class="section__header-content wow fadeInDown mb-4" data-wow-duration="0.8s">
                        Use our interactive broker comparison tool to find the perfect trading platform for your specific needs from our database of 72 thoroughly analyzed brokers.
                    </p>
                    <div class="cta-buttons d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a href="#" class="btn_theme btn_theme_active">Compare Brokers <i class="bi bi-arrow-up-right"></i><span></span></a>
                        <a href="#" class="btn_theme">Get Personalized Recommendations <i class="bi bi-star"></i><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection