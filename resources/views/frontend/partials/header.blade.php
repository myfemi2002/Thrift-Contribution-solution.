@php
   $assetBase = asset('frontend/assets');
@endphp

<header class="header-section header-version3 header-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-xl nav-shadow" id="navbar">
                    <!-- Logo -->
                    <a class="navbar-brand" href="/"><img src="{{ $assetBase }}/images/logo/logo-light.png" class="logo" alt="logo"></a>
                    
                    <!-- Mobile Toggle -->
                    <a class="navbar-toggler text-white" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="bi bi-list"></i>
                    </a>

                    <!-- Main Menu -->
                    <div class="collapse navbar-collapse" id="navbar-content">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="/">Home</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white " href="{{ route('trading-solutions.index') }}">Trading Solutions</a> 
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('financial-insights.index') }}">Financial Insights</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('broker-analysis.index')}}">Broker Analysis</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('about-us.index') }}">About Us</a>
                            </li>

                            <li class="nav-item nav-cus-item px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('contact-us.index') }}">Contact</a>
                            </li>

                            @auth
                            <!-- Only show in mobile when logged in -->
                            <li class="nav-item nav-cus-item d-xl-none px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('user.dashboard') }}">My Dashboard</a>
                            </li>
                            <li class="nav-item nav-cus-item d-xl-none px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('user.profile') }}">My Profile</a>
                            </li>
                            <li class="nav-item nav-cus-item d-xl-none px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   Sign Out
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @else
                            <!-- Only show in mobile when logged out -->
                            <li class="nav-item nav-cus-item d-xl-none px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('login') }}">Sign In</a>
                            </li>
                            <li class="nav-item nav-cus-item d-xl-none px-2">
                                <a class="nav-link text-white fw-bold" href="{{ route('auth.register') }}">Sign Up</a>
                            </li>
                            @endauth
                        </ul>
                    </div>
                    
                    <!-- Right Nav Buttons - Desktop only -->
                    <div class="nav-right d-none d-xl-flex align-items-center">
                        @auth
                        <!-- User is logged in - show user menu -->
                        <div class="dropdown">
                            <a class="nav-link text-white dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                My Account
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('desktop-logout-form').submit();">
                                       Sign Out
                                    </a>
                                </li>
                            </ul>
                            <form id="desktop-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        @else
                        <!-- User is logged out - show sign in/up buttons -->
                        <a href="{{ route('login') }}" class="nav-link text-white me-4">Sign In</a>
                        <a href="{{ route('auth.register') }}" class="btn_theme text-white">Sign Up <i class="bi bi-arrow-up-right"></i><span></span></a>
                        @endauth
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- Offcanvas Mobile Menu -->
@include('frontend.partials.mobile_header')