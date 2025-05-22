@php
    $assetBase = asset('backend/assets');
@endphp

<!DOCTYPE html>

<html lang="zxx">
    <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Links Of CSS File -->
		<link rel="stylesheet" href="{{ $assetBase }}/css/sidebar-menu.css">
		<link rel="stylesheet" href="{{ $assetBase }}/css/simplebar.css">
		<link rel="stylesheet" href="{{ $assetBase }}/css/apexcharts.css">
		<link rel="stylesheet" href="{{ $assetBase }}/css/prism.css">
		<link rel="stylesheet" href="{{ $assetBase }}/css/rangeslider.css">
		<link rel="stylesheet" href="{{ $assetBase }}/css/sweetalert.min.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/quill.snow.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/google-icon.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/remixicon.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/swiper-bundle.min.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/fullcalendar.main.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/jsvectormap.min.css">
        <link rel="stylesheet" href="{{ $assetBase }}/css/lightpick.css">
		<link rel="stylesheet" href="{{ $assetBase }}/css/style.css">
        
      <link rel="stylesheet" href="{{ asset('backend/assets/toaster/toastr.css') }}">
      <link rel="stylesheet" href="{{ asset('backend/assets/Font-Awesome/css/all.css') }}">
		
		<!-- Favicon -->
		<link rel="icon" type="image/png" href="{{ $assetBase }}/images/favicon.png">
		<!-- Title -->
		<title>Trezo - Bootstrap 5 Admin Dashboard Template</title>
    </head>
    <body class="boxed-size bg-white">
        <!-- Start Preloader Area -->
        <div class="preloader" id="preloader">
            <div class="preloader">
                <div class="waviy position-relative">
                    <span class="d-inline-block">T</span>
                    <span class="d-inline-block">R</span>
                    <span class="d-inline-block">E</span>
                    <span class="d-inline-block">Z</span>
                    <span class="d-inline-block">O</span>
                </div>
            </div>
        </div>
        <!-- End Preloader Area -->



        <div class="container">
    <div class="main-content d-flex flex-column p-0">
        <div class="m-auto m-1230">
            <div class="row align-items-center">
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ $assetBase }}/images/login.jpg" class="rounded-3" alt="login">
                </div>
                <div class="col-lg-6">
                    <div class="mw-480 ms-lg-auto">
                        <div class="d-inline-block mb-4">
                            <img src="{{ $assetBase }}/images/logo.svg" class="rounded-3 for-light-logo" alt="login">
                            <img src="{{ $assetBase }}/images/white-logo.svg" class="rounded-3 for-dark-logo" alt="login">
                        </div>
                        <h3 class="fs-28 mb-2">Welcome back!</h3>
                        <p class="fw-medium fs-16 mb-4">Sign In with social account or enter your details</p>
                        
                        <!-- Social Login Buttons -->
                        <div class="row justify-content-center mb-4">
                            <div class="col-lg-4 col-sm-4">
                                <a href="#" class="btn btn-outline-secondary bg-transparent w-100 py-2 hover-bg" style="border-color: #D6DAE1;">
                                    <img src="{{ $assetBase }}/images/google.svg" alt="google">
                                </a>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <a href="#" class="btn btn-outline-secondary bg-transparent w-100 py-2 hover-bg" style="border-color: #D6DAE1;">
                                    <img src="{{ $assetBase }}/images/facebook2.svg" alt="facebook2">
                                </a>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <a href="#" class="btn btn-outline-secondary bg-transparent w-100 py-2 hover-bg" style="border-color: #D6DAE1;">
                                    <img src="{{ $assetBase }}/images/apple.svg" alt="apple">
                                </a>
                            </div>
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email Address -->
                            <div class="form-group mb-4">
                                <label for="email" class="label text-secondary">{{ __('Email Address') }}</label>
                                <input type="email" 
                                       class="form-control h-55 @error('email') is-invalid @enderror" 
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       autocomplete="username"
                                       placeholder="example@domain.com">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-4">
                                <label for="password" class="label text-secondary">{{ __('Password') }}</label>
                                <input type="password" 
                                       class="form-control h-55 @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="remember_me"
                                           name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Forgot Password -->
                            <div class="form-group mb-4">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-semibold">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-primary fw-medium py-2 px-3 w-100">
                                    <div class="d-flex align-items-center justify-content-center py-1">
                                        <i class="material-symbols-outlined text-white fs-20 me-2">login</i>
                                        <span>{{ __('Log in') }}</span>
                                    </div>
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="form-group">
                                <p>Don't have an account? <a href="{{ route('register') }}" class="fw-medium text-primary text-decoration-none">Register</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








        <button class="theme-settings-btn p-0 border-0 bg-transparent position-absolute" style="right: 30px; bottom: 30px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
            <i class="material-symbols-outlined bg-primary wh-35 lh-35 text-white rounded-1" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Click On Theme Settings">settings</i>
        </button>

        <!-- Start Theme Setting Area -->
        <div class="offcanvas offcanvas-end bg-white" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
            <div class="offcanvas-header bg-body-bg py-3 px-4">
                <h5 class="offcanvas-title fs-18" id="offcanvasScrollingLabel">Theme Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-4">
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">RTL / LTR</h4>
                    <div class="settings-btn rtl-btn">
                        <label id="switch" class="switch">
                            <input type="checkbox" onchange="toggleTheme()" id="slider">
                            <span class="sliders round"></span>
                        </label>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Container Style Fluid / Boxed</h4>
                    <button class="boxed-style settings-btn fluid-boxed-btn" id="boxed-style">
                        Click To <span class="fluid">Fluid</span> <span class="boxed">Boxed</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Sidebar Light / Dark</h4>
                    <button class="sidebar-light-dark settings-btn sidebar-dark-btn" id="sidebar-light-dark">
                        Click To <span class="dark1">Dark</span> <span class="light1">Light</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Header Light / Dark</h4>
                    <button class="header-light-dark settings-btn header-dark-btn" id="header-light-dark">
                        Click To <span class="dark2">Dark</span> <span class="light2">Light</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Only Footer Light / Dark</h4>
                    <button class="footer-light-dark settings-btn footer-dark-btn" id="footer-light-dark">
                        Click To <span class="dark3">Dark</span> <span class="light3">Light</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style Radius / Square</h4>
                    <button class="card-radius-square settings-btn card-style-btn" id="card-radius-square">
                        Click To <span class="square">Square</span> <span class="radius">Radius</span>
                    </button>
                </div>
                <div class="mb-4 pb-2">
                    <h4 class="fs-15 fw-semibold border-bottom pb-2 mb-3">Card Style BG White / Gray</h4>
                    <button class="card-bg settings-btn card-bg-style-btn" id="card-bg">
                        Click To <span class="white">White</span> <span class="gray">Gray</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- End Theme Setting Area -->

        <button class="switch-toggle settings-btn dark-btn p-0 bg-transparent position-absolute top-0 d-none" id="switch-toggle">
            <span class="dark"><i class="material-symbols-outlined">light_mode</i></span> 
            <span class="light"><i class="material-symbols-outlined">dark_mode</i></span>
        </button>
     
        <!-- Link Of JS File -->
        <script src="{{ $assetBase }}/js/bootstrap.bundle.min.js"></script>
        <script src="{{ $assetBase }}/js/sidebar-menu.js"></script>
        <script src="{{ $assetBase }}/js/dragdrop.js"></script>
        <script src="{{ $assetBase }}/js/rangeslider.min.js"></script>
        <script src="{{ $assetBase }}/js/sweetalert.js"></script>
        <script src="{{ $assetBase }}/js/quill.min.js"></script>
        <script src="{{ $assetBase }}/js/data-table.js"></script>
        <script src="{{ $assetBase }}/js/prism.js"></script>
        <script src="{{ $assetBase }}/js/clipboard.min.js"></script>
        <script src="{{ $assetBase }}/js/feather.min.js"></script>
        <script src="{{ $assetBase }}/js/simplebar.min.js"></script>
        <script src="{{ $assetBase }}/js/apexcharts.min.js"></script>
        <script src="{{ $assetBase }}/js/echarts.js"></script>
        <script src="{{ $assetBase }}/js/swiper-bundle.min.js"></script>
        <script src="{{ $assetBase }}/js/fullcalendar.main.js"></script>
        <script src="{{ $assetBase }}/js/jsvectormap.min.js"></script>
        <script src="{{ $assetBase }}/js/world-merc.js"></script>
        <script src="{{ $assetBase }}/js/moment.min.js"></script>
        <script src="{{ $assetBase }}/js/lightpick.js"></script>
        <script src="{{ $assetBase }}/js/custom/apexcharts.js"></script>
        <script src="{{ $assetBase }}/js/custom/echarts.js"></script>
        <script src="{{ $assetBase }}/js/custom/custom.js"></script>

        
      {{-- Additional Scripts --}}
      <script src="{{ asset('backend/assets/validation/validate.min.js') }}"></script>
      <script src="{{ asset('backend/assets/handlebars/handlebars.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="{{ asset('backend/assets/sweetalert-code/code.js') }}"></script>
      <script src="{{ asset('backend/assets/Font-Awesome/js/all.js') }}"></script>
      <script src="{{ asset('backend/assets/toaster/toastr.min.js') }}"></script>


      {{-- Notifications --}}
      <script>
         @if (Session::has('message'))
         var type = "{{ Session::get('alert-type', 'info') }}";
         switch (type) {
            case 'info':
               toastr.info("{{ Session::get('message') }}");
               break;
            case 'success':
               toastr.success("{{ Session::get('message') }}");
               break;
            case 'warning':
               toastr.warning("{{ Session::get('message') }}");
               break;
            case 'error':
               toastr.error("{{ Session::get('message') }}");
               break;
         }
         @endif
      </script>


    </body>
</html>