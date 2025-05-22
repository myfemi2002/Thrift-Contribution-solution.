@php
    $assetBase = asset('userend/assets');
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>NextTrade - Professional Trading Platform</title>

    <meta name="author" content="nextrade.com">
    <meta name="description" content="NextTrade - A comprehensive trading platform for market analysis, trading signals, and financial intelligence.">
    <meta name="keywords" content="trading platform, financial markets, trading signals, market analysis, investment tools, algorithmic trading, risk management, financial intelligence">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Social Media Meta Tags -->
    <meta property="og:title" content="NextTrade - Professional Trading Platform">
    <meta property="og:description" content="Advanced trading platform with professional-grade signals, market analysis, and risk management tools.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $assetBase }}/images/nextrade-banner.jpg">
    
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NextTrade - Professional Trading Platform">
    <meta name="twitter:description" content="Advanced trading platform with professional-grade signals, market analysis, and risk management tools.">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="{{ $assetBase }}/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetBase }}/css/animation.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetBase }}/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetBase }}/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetBase }}/css/styles.css">

    <!-- Font -->
    <link rel="stylesheet" href="{{ $assetBase }}/font/fonts.css">

    <!-- Icon -->
    <link rel="stylesheet" href="{{ $assetBase }}/icon/style.css">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ $assetBase }}/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="{{ $assetBase }}/images/favicon.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


       <!-- trix css -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.12/dist/trix.min.css">

<!-- Additional CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/toaster/toastr.css') }}"> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

</head>

<body class="counter-scroll">

    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page -->
        <div id="page" class="">
            <!-- layout-wrap -->
            <div class="layout-wrap loader-off">
                <!-- preload -->
                <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div>
                <!-- /preload -->


                <!-- section-menu-left -->
                 @include('userend.body.sidebar')
                <!-- /section-menu-left -->


                <!-- section-content-right -->
                <div class="section-content-right">


                    <!-- header-dashboard -->
                     @include('userend.body.header-dashboard')
                    <!-- /header-dashboard -->


                    <!-- main-content -->
                    <div class="main-content">
                        <!-- main-content-wrap -->
                            @yield('user_content')

                        <!-- /main-content-wrap -->
                        
                    </div>
                    <!-- /main-content -->


                </div>
                <!-- /section-content-right -->
            </div>
            <!-- /layout-wrap -->
        </div>
        <!-- /#page -->
    </div>
    <!-- /#wrapper -->
z
    <!-- Javascript -->
    <script src="{{ $assetBase }}/js/jquery.min.js"></script>
    <script src="{{ $assetBase }}/js/countto.js"></script>
    <script src="{{ $assetBase }}/js/bootstrap.min.js"></script>
    <script src="{{ $assetBase }}/js/bootstrap-select.min.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/apexcharts.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/small-chart-1.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/small-chart-2.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/small-chart-3.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/small-chart-4.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/line-chart-twoline.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/candlestick-1.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/candlestick-4.js"></script>
    <script src="{{ $assetBase }}/js/apexcharts/candlestick-5.js"></script>
    <script src="{{ $assetBase }}/js/switcher.js"></script>
    <script defer src="{{ $assetBase }}/js/theme-settings.js"></script>
    <script src="{{ $assetBase }}/js/main.js"></script>

            
    <!-- Additional Scripts -->
    <script src="{{ asset('backend/assets/validation/validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/handlebars/handlebars.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend/assets/sweetalert-code/code.js') }}"></script>
    <script src="{{ asset('backend/assets/Font-Awesome/js/all.js') }}"></script>
    <script src="{{ asset('backend/assets/toaster/toastr.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/trix@2.1.12/dist/trix.umd.min.js"></script>

    <!-- Notifications -->
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type) {
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

    <script>
    // Delete confirmation
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });
    </script>

</body>

</html>