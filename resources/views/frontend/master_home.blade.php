@php
    $assetBase = asset('frontend/assets');
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- required meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- #favicon -->
    <link rel="shortcut icon" href="{{ $assetBase }}/images/logo/favicons.png" type="image/x-icon">
    <!-- #title -->
    <title>Tradexy - Forex & Stock Broker Trading Signals, Review, Tutorial Website Template</title>
    <!-- #keywords -->
    <meta name="keywords" content="Forex & Stock Broker Trading Signals, Review, Tutorial">
    <!-- #description -->
    <meta name="description" content="Tradexy HTML5 Template">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Poppins:wght@200;300;400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Font Style -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }
        .btn, .nav-item {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }
        .light-text {
            font-weight: 200;
        }
        .bold-text {
            font-weight: 800;
        }
    </style>

    <!--  css dependencies start  -->

    <!-- bootstrap five css -->
    <link rel="stylesheet" href="{{ $assetBase }}/vendor/bootstrap/css/bootstrap.min.css">
    <!-- bootstrap-icons css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- nice select css -->
    <link rel="stylesheet" href="{{ $assetBase }}/vendor/nice-select/css/nice-select.css">
    <!-- magnific popup css -->
    <link rel="stylesheet" href="{{ $assetBase }}/vendor/magnific-popup/css/magnific-popup.css">
    <!-- slick css -->
    <link rel="stylesheet" href="{{ $assetBase }}/vendor/slick/css/slick.css">
    <!-- odometer css -->
    <link rel="stylesheet" href="{{ $assetBase }}/vendor/odometer/css/odometer.css">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ $assetBase }}/vendor/animate/animate.css">
    <!--  / css dependencies end  -->

    <!-- main css -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/style.css">
</head>

<body>

    <!--  Preloader  -->
    <div class="preloader">
        <span class="loader"></span>
    </div>

    <!--header-section start-->
    @include('frontend.partials.header')
    <!-- header-section end -->

    @yield('home_content')


    <!-- Footer Area Start -->
     @include('frontend.partials.footer')
    <!-- Footer Area End -->

    <!-- scroll to top -->
    <a href="#" class="scrollToTop"><i class="bi bi-chevron-double-up"></i></a>

      <!--  js dependencies start  -->

    <!-- jquery -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    
    <script src="{{ $assetBase }}/vendor/jquery/jquery-3.6.3.min.js"></script>
    <!-- bootstrap five js -->
    <script src="{{ $assetBase }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- nice select js -->
    <script src="{{ $assetBase }}/vendor/nice-select/js/jquery.nice-select.min.js"></script>
    <!-- magnific popup js -->
    <script src="{{ $assetBase }}/vendor/magnific-popup/js/jquery.magnific-popup.min.js"></script>
    <!-- circular-progress-bar -->
    <script
        src="https://cdn.jsdelivr.net/gh/tomik23/circular-progress-bar@latest/docs/circularProgressBar.min.js"></script>
    <!-- slick js -->
    <script src="{{ $assetBase }}/vendor/slick/js/slick.min.js"></script>
    <!-- odometer js -->
    <script src="{{ $assetBase }}/vendor/odometer/js/odometer.min.js"></script>
    <!-- viewport js -->
    <script src="{{ $assetBase }}/vendor/viewport/viewport.jquery.js"></script>
    <!-- jquery ui js -->
    <script src="{{ $assetBase }}/vendor/jquery-ui/jquery-ui.min.js"></script>
    <!-- wow js -->
    <script src="{{ $assetBase }}/vendor/wow/wow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <script src="{{ $assetBase }}/vendor/jquery-validate/jquery.validate.min.js"></script>

    <!--  / js dependencies end  -->
    <!-- plugins js -->
    <script src="{{ $assetBase }}/js/plugins.js"></script>
    <!-- main js -->
    <script src="{{ $assetBase }}/js/main.js"></script>
    <script>
       function createChartOptions(seriesValue, color) {
        return {
            series: [seriesValue],
            chart: {
            type: 'radialBar',
            offsetY: -0,
            sparkline: {
                enabled: true,
            }
            },
            plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                track: {
                background: "#074c3e0d",
                strokeWidth: '97%',
                margin: 5,
                dropShadow: {
                    enabled: true,
                    top: 2,
                    left: 0,
                    color: '#999',
                    opacity: 1,
                    blur: 2
                }
                },
                hollow: {
                    size: '65%',
                },
                dataLabels: {
                name: {
                    show: false
                },
                value: {
                    offsetY: -2,
                    fontSize: '22px',
                    fontWeight: '700'
                }
                }
            }
            },
            grid: {
            padding: {
                top: -10
            }
            },
            fill: {
            colors: [color], 
            type: 'solid',
            gradient: {
                shade: 'light',
                shadeIntensity: 0.4,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 53, 91]
            },
            },
            stroke: {
            lineCap: "round",
            },
            labels: ['Average Results'],
        };
        }

        // Initialize multiple charts with different series values and colors
        var chart1 = new ApexCharts(document.querySelector("#chart1"), createChartOptions(80, '#2660B5')); // Green color
        chart1.render();

        var chart2 = new ApexCharts(document.querySelector("#chart2"), createChartOptions(65, '#2660B5')); // Red color
        chart2.render();

        var chart3 = new ApexCharts(document.querySelector("#chart3"), createChartOptions(72, '#2660B5')); // Blue color
        chart3.render();

      </script>

</body>
</html>