@php
    $assetBase = asset('backend/assets');
@endphp

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NextTrade - A comprehensive trading platform for market analysis, trading signals, and financial intelligence.">
    <meta name="keywords" content="trading platform, financial markets, trading signals, market analysis, investment tools, algorithmic trading, risk management, financial intelligence">
    <meta name="author" content="NextTrade">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NextTrade - Professional Trading Platform">
    <meta name="twitter:description" content="Advanced trading platform with professional-grade signals, market analysis, and risk management tools.">
    <meta name="twitter:image" content="{{ asset('images/nextrade-banner.jpg') }}">
    <meta name="twitter:image:alt" content="NextTrade Trading Platform">

    <!-- Facebook/OG Meta Tags -->
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="NextTrade - Professional Trading Platform">
    <meta property="og:description" content="Advanced trading platform with professional-grade signals, market analysis, and risk management tools.">
    <meta property="og:image" content="{{ asset('images/nextrade-banner.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <title>@yield('title', 'NextTrade') | Professional Trading Platform</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Custom Font Style -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
		
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $assetBase }}/img/favicon-1.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/bootstrap.min-1.css">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/plugins/fontawesome/css/fontawesome.min-1.css">
    <link rel="stylesheet" href="{{ $assetBase }}/plugins/fontawesome/css/all.min-1.css">

    <!-- Feather CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/plugins/feather/feather-1.css">

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/bootstrap-datetimepicker.min-1.css">
    
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/plugins/datatables/datatables.min-1.css">
            
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/plugins/select2/css/select2.min-1.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ $assetBase }}/css/style-1.css">
    
    <!-- trix css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.12/dist/trix.min.css">

    <!-- Additional CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/toaster/toastr.css') }}"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    
    <!-- Layout JS -->
    <script src="{{ $assetBase }}/js/layout-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>

</head>
<body>
    
    <!-- Main Wrapper -->
    <div class="main-wrapper">
    
        <!-- Header -->
        @include('admin.body.header')
        <!-- /Header -->
        
        <!-- Sidebar -->
        @include('admin.body.sidebar')
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <div class="content container-fluid">
            @yield('admin')

            </div>

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->


    <!-- /Theme Setting -->
    <!-- jQuery -->
    <script src="{{ $assetBase }}/js/jquery-3.7.1.min-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>
    
    <!-- Bootstrap Core JS -->
    <script src="{{ $assetBase }}/js/bootstrap.bundle.min-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>
    
    <!-- Feather Icon JS -->
    <script src="{{ $assetBase }}/js/feather.min-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>
    
    <!-- Slimscroll JS -->
    <script src="{{ $assetBase }}/plugins/slimscroll/jquery.slimscroll.min-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>

    <!-- Chart JS -->
    <script src="{{ $assetBase }}/plugins/apexchart/apexcharts.min-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>
    <script src="{{ $assetBase }}/plugins/apexchart/chart-data-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>

    <!-- Theme Settings JS -->
    <script src="{{ $assetBase }}/js/theme-settings-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>
    <script src="{{ $assetBase }}/js/greedynav-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>
    
    <!-- Custom JS -->
    <script src="{{ $assetBase }}/js/script-1.js" type="09fabb0c03675186ee0b56ff-text/javascript"></script>

    <script src="{{ $assetBase }}/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min-1.js" data-cf-settings="09fabb0c03675186ee0b56ff-|49" defer=""></script>
        
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