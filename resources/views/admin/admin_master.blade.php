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
      <script async="" src="{{ $assetBase }}/gtag/js?id=UA-91615293-4"></script><script>window.dataLayer = window.dataLayer || [];function gtag() {dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-91615293-4');</script> 
   </head>
   <body class="nk-body npc-crypto bg-white has-sidebar ">
      <div class="nk-app-root">
         <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
               <div class="nk-sidebar-element nk-sidebar-head">
                  <div class="nk-sidebar-brand"><a href="/" class="logo-link nk-sidebar-logo"><img class="logo-light logo-img" src="{{ $assetBase }}/images/logo.png" srcset="{{ $assetBase }}/images/logo2x.png 2x" alt="logo"><img class="logo-dark logo-img" src="{{ $assetBase }}/images/logo-dark.png" srcset="{{ $assetBase }}/images/logo-dark2x.png 2x" alt="logo-dark"><span class="nio-version">Crypto</span></a></div>
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
      <script src="{{ $assetBase }}/js/charts/chart-crypto.js?ver=3.3.0"></script>
   </body>
</html>