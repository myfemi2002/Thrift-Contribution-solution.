@extends('frontend.master_home')
@section('title', 'Contact Us')
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

<!-- Contact Section start -->
<section class="sign-up contact section">
    <div class="container">
        <div class="row gy-5 gy-xl-0 justify-content-center justify-content-lg-between">
            <div class="col-12 col-lg-7 col-xxl-8">
                <form method="POST" autocomplete="off" id="frmContactus" class="sign-up__form white-bg rounded-4 wow fadeInDown" data-wow-duration="0.8s">
                    @csrf
                    <h3 class="contact__title wow fadeInDown" data-wow-duration="0.8s">Get in touch with our team</h3>
                    <p class="mb-4 text-muted">Our support specialists will respond within 24 hours to address your trading and platform questions.</p>
                    
                    <div class="sign-up__form-part">
                        <div class="input-group mb-xxl-4 mb-3">
                            <div class="input-single">
                                <label class="label" for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" required="">
                            </div>
                            <div class="input-single">
                                <label class="label" for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" required="">
                            </div>
                        </div>
                        <div class="input-group mb-xxl-4 mb-3">
                            <div class="input-single">
                                <label class="label" for="phone">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number">
                            </div>
                            <div class="input-single">
                                <label class="label">Subject</label>
                                <select class="form-control cus-sel-active" name="subject" required>
                                    <option value="" selected disabled>Select your inquiry type...</option>
                                    <option value="Platform Support">Platform Support</option>
                                    <option value="Trading Questions">Trading Questions</option>
                                    <option value="Account Issues">Account Issues</option>
                                    <option value="Broker Integration">Broker Integration</option>
                                    <option value="Billing Inquiries">Billing Inquiries</option>
                                    <option value="Partnership Opportunities">Partnership Opportunities</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-single mb-3">
                            <label class="label" for="message">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" placeholder="Please describe your inquiry in detail..." required=""></textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="newsletter" name="newsletter">
                            <label class="form-check-label" for="newsletter">
                                Subscribe to our weekly market insights newsletter
                            </label>
                        </div>
                    </div>
                    <span id="msg"></span> 
                    <button type="submit" class="btn_theme btn_theme_active mt_30" name="submit" id="submit">Send Message <i class="bi bi-arrow-up-right"></i><span></span></button>
                </form>
            </div>
            <div class="col-12 col-lg-5 col-xxl-4">
                <div class="more-help wow fadeInUp" data-wow-duration="0.8s">
                    <h3 class="contact__title wow fadeInUp" data-wow-duration="0.8s">Connect With Us</h3>
                    <div class="more-help__content">
                        <div class="card card--small mb-4">
                            <div class="card--small-icon primary-bg text-white">
                                <i class="bi bi-headset"></i> 
                            </div>
                            <div class="card--small-content">
                                <h5 class="card--small-title">24/7 Trading Support</h5>
                                <div class="gap-1 flex-column">
                                    <a href="tel:+18005551212" class="card--small-call">(800) 555-1212</a>
                                    <p class="mb-0 small text-muted">Premium & Elite plans only</p>
                                </div>
                            </div>
                        </div>
                        <div class="card card--small mb-4">
                            <div class="card--small-icon primary-bg text-white">
                                <i class="bi bi-envelope-open"></i> 
                            </div>
                            <div class="card--small-content">
                                <h5 class="card--small-title">Email Support</h5>
                                <div class="gap-1 flex-column">
                                    <a href="mailto:support@nextrade.com" class="card--small-call">support@nextrade.com</a>
                                    <a href="mailto:info@nextrade.com" class="card--small-call">info@nextrade.com</a>
                                </div>
                            </div>
                        </div>
                        <div class="card card--small mb-4">
                            <div class="card--small-icon primary-bg text-white">
                                <i class="bi bi-telegram"></i> 
                            </div>
                            <div class="card--small-content">
                                <h5 class="card--small-title">Telegram Community</h5>
                                <div class="gap-1 flex-column">
                                    <a href="https://t.me/nextrade_community" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                        Join Our Telegram Group <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <p class="mb-0 small text-muted">Get instant updates and connect with traders</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section end -->

<!-- FAQ Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section__header">
                    <span class="section__header-sub-title headingFour wow fadeInDown" data-wow-duration="0.8s">
                        <img src="{{ $assetBase }}/images/element/section-badge1.png" alt="vector" width="24" height="24">Support FAQs
                    </span>
                    <h2 class="section__header-title wow fadeInUp" data-wow-duration="0.8s">
                        Frequently Asked Support Questions
                    </h2>
                    <p class="section__header-content wow fadeInDown" data-wow-duration="0.8s">
                        Find quick answers to common support inquiries before contacting our team.
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="supportFAQ">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item mb-3 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                What are your support hours?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#supportFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    Our standard support hours are Monday-Friday, 9am-5pm EST for all users. Premium and Elite subscribers receive extended support hours (Monday-Friday, 8am-8pm EST), while Elite subscribers also have access to 24/7 emergency trading support for critical issues affecting active positions.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item mb-3 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                How quickly can I expect a response to my inquiry?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#supportFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    Our standard response time is within 24 hours for all submitted inquiries. Premium users receive priority support with responses typically within 8 business hours, while Elite users can expect responses within 4 business hours. For urgent trading-related issues, Elite users can access our emergency support line for immediate assistance.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item mb-3 white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                How do I reset my password or recover my account?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#supportFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    To reset your password, click the "Forgot Password" link on the login page and follow the instructions sent to your registered email address. If you cannot access your email or have other account recovery issues, please contact support@nextrade.com with your username and the email address you used during registration. For security purposes, we may require additional verification of your identity.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item white-bg rounded-3 overflow-hidden wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.4s">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                How do I connect my broker account to NexTrade?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#supportFAQ">
                            <div class="accordion-body">
                                <p class="mb-0">
                                    To connect your broker account, log in to your NexTrade dashboard and navigate to "Settings > Broker Connections". Select your broker from our list of supported providers and follow the secure authentication process. If you encounter any issues during integration or if your broker isn't listed, please contact our support team for assistance. We currently support integration with 27 major brokers and regularly add new ones based on user demand.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="#" class="btn_theme">View Support Center <i class="bi bi-arrow-up-right"></i><span></span></a>
            </div>
        </div>
    </div>
</section>

@endsection