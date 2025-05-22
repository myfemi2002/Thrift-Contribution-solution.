
@php

   $assetBase = asset('frontend/assets');
   
@endphp
<footer class="footer footer-style2" data-background="{{ $assetBase }}/images/footer/footer-bg2.png">
        <div class="container container-cus">
            <div class="row section gy-5 gy-xl-0">
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-2">
                    <div class="footer__contact ms-sm-4 ms-xl-0 wow fadeInUp" data-wow-duration="0.8s">
                        <h4 class="footer__title mb-4">Contact</h4>
                        <div class="footer__content">
                            <a href="tel:+1-234-567-891"> <span class="btn_theme social_box"> <i class="bi bi-telephone-plus"></i> </span> (316) 555-0116 <span></span> </a> 
                            <a href="/cdn-cgi/l/email-protection#31585f575e715449505c415d541f525e5c"> <span class="btn_theme social_box"> <i class="bi bi-envelope-open"></i> </span> <span class="__cf_email__" data-cfemail="d1b8bfb7be91b4a9b0bca1bdb4ffb2bebc">[email&#160;protected]</span> <span></span> </a> 
                            <a href="#"> <span class="btn_theme social_box"> <i class="bi bi-geo-alt"></i> </span> 31 Brandy Way, Sutton, SM2 6SE <span></span> </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-2">
                    <div class="quick-link ms-sm-4 ms-xl-0 wow fadeInRight" data-wow-duration="0.8s">
                        <h4 class="footer__title mb-4">Quick Link</h4>
                        <ul>
                            <li><a href="about.html">About us</a></li>
                            <li><a href="brokerage-reviews.html">Brokerage Reviews</a></li>
                            <li><a href="brokerage-reviews-details.html">Market Analysis</a></li>
                            <li><a href="brokerage-reviews-details2.html">Educate</a></li>
                            <li><a href="service-packages.html">Serve</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-2">
                    <div class="quick-link ms-sm-4 ms-xl-0 wow fadeInRight" data-wow-duration="0.8s">
                        <h4 class="footer__title mb-4">More Link</h4>
                        <ul>
                            <li><a href="video-tutorial.html">Video Tutorial</a></li>
                            <li><a href="faq.html">FAQs</a></li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="error.html">404 Pages</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2">
                    <div class="newsletter wow fadeInDown" data-wow-duration="0.8s">
                        <h4 class="footer__title mb-4">Newsletter</h4>
                        <p class="mb_32">Subscribe our newsletter to get our latest update & news</p>
                        <form method="POST" autocomplete="off" id="frmSubscribe" class="newsletter__content-form">
                            <div class="input-group">
                                <input type="email" class="form-control" id="sMail" name="sMail" placeholder="Email Address" required="">
                                <button type="submit" class="emailSubscribe btn_theme btn_theme_active" name="emailSubscribe" id="emailSubscribe"><i class="bi bi-cursor"></i> <span></span></button>
                            </div>
                            <span id="subscribeMsg"></span>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="about-company d-center tradexy-company-footer rounded-4 wow fadeInLeft" data-wow-duration="0.8s">
                        <div class="boxes">
                            <div class="footer__logo mb-4">
                                <a href="/">
                                    <img src="{{ $assetBase }}/images/logo/logo-light.png" alt="Logo">
                                </a>
                            </div>
                            <p>Tradexy is a comprehensive platform designed to empower traders</p>
                            <div class="social mt_32 justify-content-center">
                                <a href="#" class="btn_theme social_box"><i class="bi bi-facebook"></i><span></span></a>
                                <a href="#" class="btn_theme social_box"><i class="bi bi-pinterest"></i><span></span></a>
                                <a href="#" class="btn_theme social_box"><i class="bi bi-twitch"></i><span></span></a>
                                <a href="#" class="btn_theme social_box"><i class="bi bi-skype"></i><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer__copyright">
                        <p class="copyright text-center">Copyright &copy; <span id="copyYear"></span> <a href="/" class="secondary_color">Tredexy</a>. Designed By <a href="#" class="secondary_color">Pixelaxis</a></p>
                        <ul class="footer__copyright-conditions">
                            <li><a href="contact.html">Help & Support</a></li>
                            <li><a href="#">Privacy policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>