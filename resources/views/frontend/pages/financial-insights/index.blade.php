@extends('frontend.master_home')
@section('title', 'Financial Insights')
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

<!-- Insights Overview Section -->
<section class="section">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector">Market Intelligence
                    </span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Data-Driven Market Analysis
                    </h2>
                    <p class="section__header-content mb-4 wow fadeInDown" data-wow-duration="0.8s">
                        NexTrade provides institutional-grade financial insights powered by advanced algorithms and expert analysis. Our research team processes vast datasets to deliver actionable intelligence across all major asset classes.
                    </p>
                    <p class="wow fadeInDown" data-wow-duration="0.8s">
                        From macroeconomic trends to sector-specific opportunities, our insights help traders make informed decisions backed by comprehensive data and expert interpretation.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="insights-overview-image position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s">
                    <img src="{{ $assetBase }}/images/trade/2.png" alt="NexTrade Market Analysis" class="w-100">
                    <div class="overlay-stats position-absolute bottom-0 start-0 w-100 p-4 bg-gradient-dark">
                        <div class="row text-white text-center">
                            <div class="col-4">
                                <h3 class="mb-0 text-white ">24/7</h3>
                                <p class="mb-0 fs-small">Market Coverage</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 text-white ">12+</h3>
                                <p class="mb-0 fs-small">Expert Analysts</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 text-white ">94%</h3>
                                <p class="mb-0 fs-small">Forecast Accuracy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Insights Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src=" {{ $assetBase }}/images/hero/breadcrumb-banner1.png" alt="vector" style="height: 24px; width:24px;">Latest Analysis
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Featured Market Insights
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Explore our latest market research and analysis covering global trends, emerging opportunities, and strategic forecasts.
                    </p>
                </div>
            </div>
        </div>

        
        <div class="row mt-5 text-center">
            <div class="col-12">
                <a href="#" class="btn_theme">View All Insights <i class="bi bi-arrow-up-right"></i><span></span></a>
            </div>
        </div>
    </div>
</section>

<!-- Research Categories Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector">Research Categories
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Specialized Market Analysis
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Our research team delivers in-depth analysis across multiple market categories to support your trading decisions.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Technical Analysis -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                    <img src="{{ $assetBase }}/images/trade/4.png" alt="Technical Analysis" class="w-100">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4 bg-gradient-dark text-white">
                        <h3 class="mb-2 text-white">Technical Analysis</h3>
                        <p class="mb-3">Advanced chart patterns, indicator signals, and price action studies for precise trade timing.</p>
                    </div>
                </div>
            </div>

            <!-- Fundamental Analysis -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <img  src="{{ $assetBase }}/images/trade/5.png" alt="Fundamental Analysis" class="w-100">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4 bg-gradient-dark text-white">
                        <h3 class="mb-2 text-white">Fundamental Analysis</h3>
                        <p class="mb-3">Economic indicators, earnings reports, and central bank policies impact assessment.</p>
                        <a href="#" class="text-white">Explore <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Market Sentiment -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                    <img src="{{ $assetBase }}/images/trade/sentiment-analysis.png" alt="Sentiment Analysis" class="w-100">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4 bg-gradient-dark text-white">
                        <h3 class="mb-2 text-white">Sentiment Analysis</h3>
                        <p class="mb-3">Institutional positioning, retail sentiment metrics, and contrarian indicators assessment.</p>
                    </div>
                </div>
            </div>

            <!-- Macro Trends -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                    <img src="{{ $assetBase }}/images/trade/Macroeconomic-Trends.png" alt="Macroeconomic Trends" class="w-100">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4 bg-gradient-dark text-white">
                        <h3 class="mb-2 text-white">Macroeconomic Trends</h3>
                        <p class="mb-3">Global economic cycles, inflation dynamics, and monetary policy impact analysis.</p>
                    </div>
                </div>
            </div>

            <!-- Sector Analysis -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
                    <img src="{{ $assetBase }}/images/trade/sector-analysis.png" alt="Sector Analysis" class="w-100">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4 bg-gradient-dark text-white">
                        <h3 class="mb-2 text-white">Sector Analysis</h3>
                        <p class="mb-3">Industry-specific trends, sector rotation strategies, and targeted investment opportunities.</p>
                    </div>
                </div>
            </div>

            <!-- Risk Assessment -->
            <div class="col-lg-4 col-md-6">
                <div class="category-card position-relative rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.6s">
                    <img src="{{ $assetBase }}/images/trade/risk-assessment.png" alt="Risk Assessment" class="w-100">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4 bg-gradient-dark text-white">
                        <h3 class="mb-2">Risk Assessment</h3>
                        <p class="mb-3">Volatility forecasting, correlation analysis, and market stress testing for portfolio protection.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Economic Calendar Section -->
<section class="section cmn-bg2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="section__header text-start mb-0">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector">Event Tracking
                    </span>
                    <h2 class="section__header-title mb-3 wow fadeInUp" data-wow-duration="0.8s">
                        Economic Calendar
                    </h2>
                    <p class="section__header-content mb-4 wow fadeInDown" data-wow-duration="0.8s">
                        Stay ahead of market-moving events with our comprehensive economic calendar. Track key releases, central bank announcements, and geopolitical developments.
                    </p>
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-3 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Real-time event notifications and alerts</span>
                        </li>
                        <li class="d-flex align-items-center mb-3 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Impact analysis and volatility forecasts</span>
                        </li>
                        <li class="d-flex align-items-center mb-3 wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Historical data comparison and trend analysis</span>
                        </li>
                        <li class="d-flex align-items-center wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                            <i class="bi bi-check-circle-fill primary-clr me-2"></i>
                            <span>Customizable filters by region, impact, and asset class</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="economic-calendar-preview p-4 rounded-3 white-bg mt-5 mt-lg-0 wow fadeInUp" data-wow-duration="0.8s">
                    <div class="calendar-header d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Upcoming Events</h4>
                        <div class="calendar-controls">
                            <button class="btn btn-sm btn-outline-primary me-2">Today</button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-sliders"></i> Filter</button>
                        </div>
                    </div>
                    <div class="calendar-events">
                        <!-- Event 1 -->
                        <div class="calendar-event d-flex align-items-center p-3 border-bottom">
                            <div class="event-time me-3">
                                <span class="time d-block fw-bold">08:30 ET</span>
                                <span class="date d-block fs-small text-muted">May 21</span>
                            </div>
                            <div class="event-details flex-grow-1">
                                <h5 class="mb-1">US Retail Sales m/m</h5>
                                <div class="event-meta d-flex align-items-center">
                                    <span class="country me-2"><i class="bi bi-globe2"></i> United States</span>
                                    <span class="impact high-impact px-2 rounded-pill">High Impact</span>
                                </div>
                            </div>
                            <div class="event-forecast text-end">
                                <span class="forecast d-block fw-bold">0.4%</span>
                                <span class="previous d-block fs-small text-muted">Prev: 0.2%</span>
                            </div>
                        </div>
                        
                        <!-- Event 2 -->
                        <div class="calendar-event d-flex align-items-center p-3 border-bottom">
                            <div class="event-time me-3">
                                <span class="time d-block fw-bold">10:00 ET</span>
                                <span class="date d-block fs-small text-muted">June 18</span>
                            </div>
                            <div class="event-details flex-grow-1">
                                <h5 class="mb-1">Fed Chair Powell Speech</h5>
                                <div class="event-meta d-flex align-items-center">
                                    <span class="country me-2"><i class="bi bi-globe2"></i> United States</span>
                                    <span class="impact high-impact px-2 rounded-pill">High Impact</span>
                                </div>
                            </div>
                            <div class="event-forecast text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary">Analysis <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        
                        <!-- Event 3 -->
                        <div class="calendar-event d-flex align-items-center p-3 border-bottom">
                            <div class="event-time me-3">
                                <span class="time d-block fw-bold">02:00 ET</span>
                                <span class="date d-block fs-small text-muted">July 07</span>
                            </div>
                            <div class="event-details flex-grow-1">
                                <h5 class="mb-1">German PPI m/m</h5>
                                <div class="event-meta d-flex align-items-center">
                                    <span class="country me-2"><i class="bi bi-globe2"></i> Germany</span>
                                    <span class="impact medium-impact px-2 rounded-pill">Medium Impact</span>
                                </div>
                            </div>
                            <div class="event-forecast text-end">
                                <span class="forecast d-block fw-bold">0.2%</span>
                                <span class="previous d-block fs-small text-muted">Prev: 0.1%</span>
                            </div>
                        </div>
                        
                        <!-- Event 4 -->
                        <div class="calendar-event d-flex align-items-center p-3">
                            <div class="event-time me-3">
                                <span class="time d-block fw-bold">19:50 ET</span>
                                <span class="date d-block fs-small text-muted">Aug 18</span>
                            </div>
                            <div class="event-details flex-grow-1">
                                <h5 class="mb-1">Japan Trade Balance</h5>
                                <div class="event-meta d-flex align-items-center">
                                    <span class="country me-2"><i class="bi bi-globe2"></i> Japan</span>
                                    <span class="impact medium-impact px-2 rounded-pill">Medium Impact</span>
                                </div>
                            </div>
                            <div class="event-forecast text-end">
                                <span class="forecast d-block fw-bold">-0.98T</span>
                                <span class="previous d-block fs-small text-muted">Prev: -1.03T</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection