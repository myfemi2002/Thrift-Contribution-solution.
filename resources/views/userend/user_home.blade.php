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
                        <div class="nk-sidebar-widget d-none d-xl-block">
                           <div class="user-account-info between-center">
                              <div class="user-account-main">
                                 <h6 class="overline-title-alt">Total Loan</h6>
                                 <div class="user-balance"> 45,750.385 <small class="currency">USD</small></div>
                                 <div class="user-account-label"></div>
                              </div>
                              <a href="#" class="btn btn-white btn-icon btn-light"><em class="icon ni ni-line-chart"></em></a>
                           </div>
                           <ul class="user-account-data gy-1">
                              <li>
                                 <div class="user-account-label"><span class="overline-title-alt">Interest</span></div>
                                 <div class="user-account-value"><span class="sub-title text-base">15K <span class="currency">USD</span></span></div>
                              </li>
                           </ul>
                           <div class="user-account-actions">
                              <ul class="g-3">
                                 <li><a href="loan-details.html" class="btn btn-lg btn-primary"><span>Details</span></a></li>
                                 <li><a href="apply-application.html" class="btn btn-lg btn-outline-primary"><span>Apply Loan</span></a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="nk-sidebar-widget nk-sidebar-widget-full d-xl-none pt-0">
                           <a class="nk-profile-toggle toggle-expand" data-target="sidebarProfile" href="#">
                              <div class="user-card-wrap">
                                 <div class="user-card">
                                    <div class="user-avatar"><span>AB</span></div>
                                    <div class="user-info"><span class="lead-text">Abu Bin Ishtiyak</span><span class="sub-text">info@softnio.com</span></div>
                                    <div class="user-action"><em class="icon ni ni-chevron-down"></em></div>
                                 </div>
                              </div>
                           </a>
                           <div class="nk-profile-content toggle-expand-content" data-content="sidebarProfile">
                              <div class="user-account-info between-center">
                                 <div class="user-account-main">
                                    <h6 class="overline-title-alt">Total Loan</h6>
                                    <div class="user-balance">10.8 Lac <small class="currency currency-btc">USD</small></div>
                                    <div class="user-account-label"><span class="sub-text">Business Purpose</span></div>
                                 </div>
                                 <a href="#" class="btn btn-icon btn-light"><em class="icon ni ni-line-chart"></em></a>
                              </div>
                              <ul class="user-account-data">
                                 <li>
                                    <div class="user-account-label"><span class="sub-text">Interest</span></div>
                                    <div class="user-account-value"><span class="sub-text text-base">15K <span class="currency currency-btc">USD</span></span></div>
                                 </li>
                              </ul>
                              <ul class="user-account-links">
                                 <li><a href="/demo5/loan/loan-history.html" class="link"><span>Details</span> <em class="icon ni ni-wallet-out"></em></a></li>
                                 <li><a href="apply-application.html" class="link"><span>Apply Loan</span> <em class="icon ni ni-wallet-in"></em></a></li>
                              </ul>
                              <ul class="link-list">
                                 <li><a href="#"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                              </ul>
                           </div>
                        </div>

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
