
<div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{ route('user.dashboard') }}" id="site-logo-inner">
                            <img class="" id="logo_header" alt="" src="{{ $assetBase }}/images/logo/logo.svg" data-light="{{ $assetBase }}/images/logo/logo.svg" data-dark="{{ $assetBase }}/images/logo/logo-dark.svg" >
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-back"></i>
                        </div>
                    </div>
                    <div class="section-menu-left-wrap">
                        <div class="center">
                            <div class="center-item">
                                <div class="center-heading f14-regular text-Gray menu-heading mb-12">Navigation</div>
                            </div>
                            <div class="center-item">
                                <ul class="">

                                
                                    <li class="menu-item">
                                        <a href="{{ route('user.dashboard') }}" class="menu-item-button">
                                            <div class="icon">
                                                <i class="icon-category"></i>
                                            </div>
                                            <div class="text">Dashboard</div>
                                        </a>
                                    </li>

                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon">
                                                <i class="icon-wallet1"></i>
                                            </div>
                                            <div class="text">My Wallet</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="#" class="">
                                                    <div class="text">My Wallet</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('user.wallet.deposit') }}" class="">
                                                    <div class="text">Deposit</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="#" class="">
                                                    <div class="text">Withdraw</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="#" class="">
                                                    <div class="text">Transactions</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    
                                    <li class="menu-item">
                                        <a href="#" class="menu-item-button">
                                            <div class="icon">
                                                <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6.1428 8.50146V14.2182" stroke="#A4A4A9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10.0317 5.76562V14.2179" stroke="#A4A4A9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M13.8572 11.522V14.2178" stroke="#A4A4A9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9047 1.6665H6.0952C3.37297 1.6665 1.66663 3.59324 1.66663 6.3208V13.6789C1.66663 16.4064 3.36504 18.3332 6.0952 18.3332H13.9047C16.6349 18.3332 18.3333 16.4064 18.3333 13.6789V6.3208C18.3333 3.59324 16.6349 1.6665 13.9047 1.6665Z" stroke="#A4A4A9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div class="text">Transaction</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="crypto.html" class="menu-item-button">
                                            <div class="icon">
                                                <i class="icon-dash1"></i>
                                            </div>
                                            <div class="text">Crypto</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="exchange.html" class="menu-item-button">
                                            <div class="icon">
                                                <i class="icon-arrow-swap"></i>
                                            </div>
                                            <div class="text">Exchange</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="settings.html" class="menu-item-button">
                                            <div class="icon">
                                                <i class="icon-setting1"></i>
                                            </div>
                                            <div class="text">Settings</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="component.html" class="menu-item-button">
                                            <div class="icon">
                                                <i class="icon-search-normal1"></i>
                                            </div>
                                            <div class="text">Component</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="image">
                                <img src="{{ $assetBase }}/images/item/bot.png" alt="">
                            </div>
                            <div class="content">
                                <p class="f12-regular text-White">For more features</p>
                                <p class="f12-bold text-White">Upgrade to Pro</p>
                            </div>
                        </div>
                    </div>
                </div>