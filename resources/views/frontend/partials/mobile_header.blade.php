@php

$assetBase = asset('frontend/assets');

@endphp

    <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-body custom-nevbar">
            <div class="row">
                <div class="col-md-7 col-xl-8">
                    <div class="custom-nevbar__left">
                        <button type="button" class="close-icon d-md-none ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x"></i></button>
                        <ul class="custom-nevbar__nav mb-lg-0">
                            
                        
                       
                            
                        
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">Home</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">Trading Solutions</a> 
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">Financial Insights</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">Broker Analysis</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">About Us</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">Resources</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="#">Contact</a>
                            </li>

                            <li class="nav-item nav-cus-item d-xl-none px-2">
                                <a class="nav-link text-white fw-bold" href="#">Sign In</a>
                            </li>




                        </ul>
                    </div>
                </div>


                <div class="col-md-5 col-xl-4">
                    <div class="custom-nevbar__right">
                        <div class="custom-nevbar__top d-none d-md-block">
                            <button type="button" class="close-icon ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x"></i></button>
                            <div class="custom-nevbar__right-thumb mb-auto">
                                <img src="{{ $assetBase }}/images/logo/logo-light.png" alt="logo">
                            </div>
                        </div>
                        <ul class="custom-nevbar__right-location">
                            <li>
                                <p class="mb-2">Phone: </p>
                                <a href="tel:+123456789" class="fs-4 contact">+123 456 789</a>
                            </li>
                            <li class="location">
                                <p class="mb-2">Email: </p>
                                <a href="/cdn-cgi/l/email-protection#7831161e17381f15191114561b1715" class="fs-4 contact"><span class="__cf_email__" data-cfemail="f2bb9c949db2959f939b9edc919d9f">[email&#160;protected]</span></a>
                            </li>
                            <li class="location">
                                <p class="mb-2">Location: </p>
                                <p class="fs-4 contact">6391 Celina, Delaware 10299</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>