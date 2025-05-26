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
      <link rel="shortcut icon" href="{{ $assetBase }}/images/favicon-1.png">
      <title>Dashboard | Loan Management | Admin </title>
      <link rel="stylesheet" href="{{ $assetBase }}/css/dashlite-1.css?ver=3.3.0">
      <link id="skin-default" rel="stylesheet" href="{{ $assetBase }}/css/theme-1.css?ver=3.3.0">
      <script async="" src="{{ $assetBase }}/gtag/js-1?id=UA-91615293-4"></script>
      <script>window.dataLayer = window.dataLayer || [];function gtag() {dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-91615293-4');</script> 
   </head>
   <body class="nk-body npc-crypto bg-lighter has-sidebar ">
      <div class="nk-app-root">
         <div class="nk-main ">
            <div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
               <div class="nk-sidebar-element nk-sidebar-head">
                  <div class="nk-sidebar-brand"><a href="/" class="logo-link nk-sidebar-logo">
                    <img class="logo-light logo-img" src="{{ $assetBase }}/images/logo-1.png" srcset="{{ $assetBase }}/images/logo2x-1.png 2x" alt="logo">
                    <img class="logo-dark logo-img" src="{{ $assetBase }}/images/logo-dark-1.png" srcset="{{ $assetBase }}/images/logo-dark2x-1.png 2x" alt="logo-dark"><span class="nio-version">Loan</span></a></div>
                  <div class="nk-menu-trigger me-n2"><a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a></div>
               </div>
               <div class="nk-sidebar-element">
                  <div class="nk-sidebar-body" data-simplebar="">
                     <div class="nk-sidebar-content">




                            @include('userend.body.sidebar')


                        <div class="nk-sidebar-footer">
                           <ul class="nk-menu nk-menu-footer">
                              <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span><span class="nk-menu-text">Support</span></a></li>
                              <li class="nk-menu-item ms-auto">
                                 <div class="dropup">
                                    <a href="#" class="nk-menu-link dropdown-indicator has-indicator" data-bs-toggle="dropdown" data-bs-offset="0,10"><span class="nk-menu-icon"><em class="icon ni ni-globe"></em></span><span class="nk-menu-text">English</span></a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                       <ul class="language-list">
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/english-1.png" alt="" class="language-flag"><span class="language-name">English</span></a></li>
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/spanish-1.png" alt="" class="language-flag"><span class="language-name">Español</span></a></li>
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/french-1.png" alt="" class="language-flag"><span class="language-name">Français</span></a></li>
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/turkey-1.png" alt="" class="language-flag"><span class="language-name">Türkçe</span></a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>


        
            <div class="nk-wrap ">

            @include('userend.body.top-header')

               <div class="nk-content nk-content-fluid">

                        @yield('user_content')


               </div>




               <div class="nk-footer">
                    @include('userend.body.footer')
               </div>


            </div>
         </div>
      </div>
      
      <script src="{{ $assetBase }}/js/bundle-1.js?ver=3.3.0"></script>
      <script src="{{ $assetBase }}/js/scripts-1.js?ver=3.3.0"></script>
      <script src="{{ $assetBase }}/js/demo-settings-1.js?ver=3.3.0"></script>
   </body>
</html>
