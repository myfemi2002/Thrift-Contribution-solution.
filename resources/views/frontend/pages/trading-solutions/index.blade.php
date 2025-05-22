@extends('frontend.master_home')
@section('title', 'Trading Solutions')
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

<!-- Solutions Overview Section -->
<section class="section">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="frontend/assets/images/element/section-badge1.png" alt="vector">Trading Ecosystem
                    </span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Institutional-Grade Tools for Today's Trader
                    </h2>
                    <p class="section__header-content mb-4 wow fadeInDown" data-wow-duration="0.8s">
                        NexTrade delivers a comprehensive suite of trading solutions designed to provide both professional and retail traders with enterprise-level market analysis, signal generation, and risk management capabilities.
                    </p>
                    <p class="wow fadeInDown" data-wow-duration="0.8s">
                        Our algorithmic approach to market analysis processes millions of data points to identify high-probability trading opportunities across multiple asset classes and timeframes.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="solutions-overview-image position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s">
                    <img src="{{ $assetBase }}/images/trade/3.png" alt="NexTrade Trading Platform" class="w-100">
                    <div class="overlay-stats position-absolute bottom-0 start-0 w-100 p-4 bg-gradient-dark">
                        <div class="row text-white text-center">
                            <div class="col-4">
                                <h3 class="mb-0 text-white">67.4%</h3>
                                <p class="mb-0 fs-small">Signal Accuracy</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 text-white">14ms</h3>
                                <p class="mb-0 fs-small">Execution Speed</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 text-white">1.2M+</h3>
                                <p class="mb-0 fs-small">Data Points Daily</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trading Solutions Features -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Engineered for Trading Excellence
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Our integrated solution suite combines advanced analytics, real-time signal generation, and comprehensive risk management tools in one powerful platform.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Signal Generation -->
            <div class="col-lg-4">
                <div class="feature-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <div class="feature-icon p-3 rounded-circle primary-bg d-inline-flex mb-4">
                        <i class="bi bi-graph-up-arrow text-white fs-4"></i>
                    </div>
                    <h3 class="mb-3">Algorithmic Signal Generation</h3>
                    <p class="mb-3">
                        Our proprietary algorithms analyze market patterns, momentum indicators, and volatility profiles to identify high-probability trading opportunities.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Pattern recognition across multiple timeframes</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Real-time signal delivery with precise parameters</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Multi-target approach with optimal exit points</span>
                        </li>
                    </ul>
                    <a href="#" class="btn_read_more">Explore Signals <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Advanced Analytics -->
            <div class="col-lg-4">
                <div class="feature-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="feature-icon p-3 rounded-circle primary-bg d-inline-flex mb-4">
                        <i class="bi bi-bar-chart-line text-white fs-4"></i>
                    </div>
                    <h3 class="mb-3">Advanced Market Analytics</h3>
                    <p class="mb-3">
                        Access institutional-grade market analysis tools offering deep insights into price action, trend strength, and market correlations.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>120+ technical indicators and drawing tools</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Custom indicator builder for proprietary strategies</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Multi-timeframe analysis with correlated views</span>
                        </li>
                    </ul>
                    <a href="#" class="btn_read_more">Explore Analytics <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Risk Management -->
            <div class="col-lg-4">
                <div class="feature-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <div class="feature-icon p-3 rounded-circle primary-bg d-inline-flex mb-4">
                        <i class="bi bi-shield-check text-white fs-4"></i>
                    </div>
                    <h3 class="mb-3">Intelligent Risk Management</h3>
                    <p class="mb-3">
                        Sophisticated risk control systems help protect capital and optimize position sizing for consistent trading performance.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Dynamic position sizing based on volatility</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Portfolio-level correlation protection</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Drawdown monitoring with risk alerts</span>
                        </li>
                    </ul>
                    <a href="#" class="btn_read_more">Explore Risk Tools <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <!-- Platform Integration -->
            <div class="col-lg-4">
                <div class="feature-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                    <div class="feature-icon p-3 rounded-circle primary-bg d-inline-flex mb-4">
                        <i class="bi bi-link-45deg text-white fs-4"></i>
                    </div>
                    <h3 class="mb-3">Seamless Broker Integration</h3>
                    <p class="mb-3">
                        Connect directly to your preferred broker for instant trade execution and comprehensive position management.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>One-click trading from analysis interface</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Support for 27+ global brokers</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Secure API connections with tokenized authentication</span>
                        </li>
                    </ul>
                    <a href="#" class="btn_read_more">Explore Integration <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Education & Research -->
            <div class="col-lg-4">
                <div class="feature-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
                    <div class="feature-icon p-3 rounded-circle primary-bg d-inline-flex mb-4">
                        <i class="bi bi-mortarboard text-white fs-4"></i>
                    </div>
                    <h3 class="mb-3">Education & Research</h3>
                    <p class="mb-3">
                        Comprehensive learning resources and market research to develop your trading skills and market understanding.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Structured learning paths for all experience levels</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Weekly market analysis webinars</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Interactive trading simulations and strategy testing</span>
                        </li>
                    </ul>
                    <a href="#" class="btn_read_more">Explore Education <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Mobile Trading -->
            <div class="col-lg-4">
                <div class="feature-card white-bg h-100 rounded-3 p-4 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.6s">
                    <div class="feature-icon p-3 rounded-circle primary-bg d-inline-flex mb-4">
                        <i class="bi bi-phone text-white fs-4"></i>
                    </div>
                    <h3 class="mb-3">Mobile Trading Solutions</h3>
                    <p class="mb-3">
                        Access your trading tools anywhere with our powerful mobile applications for iOS and Android devices.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Full-featured charting and analysis on mobile</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Real-time alerts and notifications</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Biometric security and synchronized preferences</span>
                        </li>
                    </ul>
                    <a href="#" class="btn_read_more">Explore Mobile <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trading Solutions Comparison -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector">Solution Packages
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Choose the Perfect Plan for Your Trading
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Select from our tiered subscription plans designed to match your specific trading needs and experience level.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Essential Plan -->
            <div class="col-lg-4">
                <div class="pricing-card white-bg h-100 rounded-3 p-4 position-relative wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <div class="pricing-header text-center mb-4 pb-4 border-bottom">
                        <h3 class="mb-3">Essential</h3>
                        <div class="pricing">
                            <span class="currency">$</span>
                            <span class="amount">49</span>
                            <span class="period">/month</span>
                        </div>
                        <p class="mb-0">Perfect for beginning traders</p>
                    </div>
                    <div class="pricing-features mb-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Basic signal generation (5 asset classes)</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>40+ technical indicators</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Standard risk management tools</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Integration with 10+ brokers</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Mobile app with basic features</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Email support (24-hour response)</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Access to educational library</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-footer text-center">
                        <a href="#" class="btn_theme">Get Started <i class="bi bi-arrow-up-right"></i><span></span></a>
                    </div>
                </div>
            </div>

            <!-- Professional Plan -->
            <div class="col-lg-4">
                <div class="pricing-card white-bg h-100 rounded-3 p-4 position-relative wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="popular-badge position-absolute top-0 end-0 bg-primary text-white py-1 px-3 rounded-end">Most Popular</div>
                    <div class="pricing-header text-center mb-4 pb-4 border-bottom">
                        <h3 class="mb-3">Professional</h3>
                        <div class="pricing">
                            <span class="currency">$</span>
                            <span class="amount">99</span>
                            <span class="period">/month</span>
                        </div>
                        <p class="mb-0">For active traders seeking an edge</p>
                    </div>
                    <div class="pricing-features mb-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Advanced signal generation (All asset classes)</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>120+ technical indicators</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Enhanced risk management suite</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Integration with 20+ brokers</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Full-featured mobile application</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Priority email & chat support</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Weekly webinars & market analysis</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-footer text-center">
                        <a href="#" class="btn_theme btn_theme_active">Get Started <i class="bi bi-arrow-up-right"></i><span></span></a>
                    </div>
                </div>
            </div>

            <!-- Elite Plan -->
            <div class="col-lg-4">
                <div class="pricing-card white-bg h-100 rounded-3 p-4 position-relative wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <div class="pricing-header text-center mb-4 pb-4 border-bottom">
                        <h3 class="mb-3">Elite</h3>
                        <div class="pricing">
                            <span class="currency">$</span>
                            <span class="amount">249</span>
                            <span class="period">/month</span>
                        </div>
                        <p class="mb-0">For professional and institutional traders</p>
                    </div>
                    <div class="pricing-features mb-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Institutional-grade signal generation</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Custom indicator development</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Complete risk management ecosystem</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Integration with all supported brokers</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Ultra-low latency execution (14ms)</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>24/7 dedicated account manager</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                                <span>Private strategy consultations</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-footer text-center">
                        <a href="#" class="btn_theme">Get Started <i class="bi bi-arrow-up-right"></i><span></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="enterprise-cta p-5 rounded-3 bg-light wow fadeInUp" data-wow-duration="0.8s">
                    <h3 class="mb-3">Need a Custom Enterprise Solution?</h3>
                    <p class="mb-4">
                        We offer tailored solutions for institutional clients, fund managers, and trading firms with specific requirements.
                    </p>
                    <a href="#" class="btn_theme">Contact Sales <i class="bi bi-arrow-up-right"></i><span></span></a>
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
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector">Take The Next Step
                    </span>
                    <h2 class="section__header-title my-4 wow fadeInUp" data-wow-duration="0.8s">
                        Start Trading With Precision Today
                    </h2>
                    <p class="section__header-content wow fadeInDown mb-4" data-wow-duration="0.8s">
                        Experience the power of NexTrade's professional trading solutions with our 14-day risk-free trial. No credit card required.
                    </p>
                    <div class="cta-buttons d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a href="#" class="btn_theme btn_theme_active">Start Free Trial <i class="bi bi-arrow-up-right"></i><span></span></a>
                        <a href="#" class="btn_theme">Schedule Demo <i class="bi bi-calendar-check"></i><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection