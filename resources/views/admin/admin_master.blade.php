@php
    $assetBase = asset('userend/assets');
@endphp

<!DOCTYPE html>
<html lang="zxx" class="js">
   <head>
      <meta charset="utf-8">
      <meta name="author" content="Softnio">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
      <link rel="shortcut icon" href="{{ $assetBase }}/images/favicon.png">
      <title>Crypto Dashboard |  Admin</title>
      <link rel="stylesheet" href="{{ $assetBase }}/css/dashlite.css?ver=3.3.0">
      <link id="skin-default" rel="stylesheet" href="{{ $assetBase }}/css/theme.css?ver=3.3.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
      <script async="" src="{{ $assetBase }}/gtag/js?id=UA-91615293-4"></script><script>window.dataLayer = window.dataLayer || [];function gtag() {dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-91615293-4');</script> 
   </head>
   <body class="nk-body npc-crypto bg-white has-sidebar ">
      <div class="nk-app-root">
         <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
               <div class="nk-sidebar-element nk-sidebar-head">
                  <div class="nk-sidebar-brand">
   <a class="navbar-brand nk-sidebar-logo fs-3" href="#hero">
      <i class="fas fa-piggy-bank me-2 fs-2"></i>EagleSave
   </a>
</div>
                  <div class="nk-menu-trigger me-n2"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a></div>
               </div>
                @include('admin.body.sidebar')

            </div>




            <div class="nk-wrap ">

                @include('admin.body.top-header')


               <div class="nk-content nk-content-fluid">
                   @yield('admin')
               </div>

               
               <div class="nk-footer">
                    @include('admin.body.footer')
               </div>

            </div>
         </div>
      </div>


      <script src="{{ $assetBase }}/js/bundle.js?ver=3.3.0"></script>
      <script src="{{ $assetBase }}/js/scripts.js?ver=3.3.0"></script>
      <script src="{{ $assetBase }}/js/demo-settings.js?ver=3.3.0"></script>
      <script src="{{ $assetBase }}/js/libs/fullcalendar.js?ver=3.3.0"></script>
      <script src="{{ $assetBase }}/js/apps/calendar.js?ver=3.3.0"></script>
      
   </body>
</html>