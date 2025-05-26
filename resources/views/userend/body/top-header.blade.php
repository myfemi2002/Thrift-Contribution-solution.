                
               <div class="nk-header nk-header-fluid nk-header-fixed">
                  <div class="container-fluid">
                     <div class="nk-header-wrap">
                        <div class="nk-menu-trigger d-xl-none ms-n1"><a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a></div>
                        <div class="nk-header-brand d-xl-none"><a href="/" class="logo-link"><img class="logo-light logo-img" src="{{ $assetBase }}/images/logo-1.png" srcset="{{ $assetBase }}/images/logo2x-1.png 2x" alt="logo"><img class="logo-dark logo-img" src="{{ $assetBase }}/images/logo-dark-1.png" srcset="{{ $assetBase }}/images/logo-dark2x-1.png 2x" alt="logo-dark"><span class="nio-version">Loan</span></a></div>
                        
                        <div class="nk-header-news d-none d-xl-block">
                           <div class="nk-news-list">
                              <a class="nk-news-item" href="#">
                                    <div class="nk-news-icon"><em class="icon ni ni-wallet-alt"></em></div>
                                    <div class="nk-news-text">
                                       <p>Track your daily contributions and wallet balance. <span>View your contribution history and milestones</span></p>
                                       <em class="icon ni ni-external"></em>
                                    </div>
                              </a>
                           </div>
                        </div>

                        <div class="nk-header-tools">
                           <ul class="nk-quick-nav">


                              
                    
                    <!-- User Dropdown -->
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset(Auth::user()->photo) }}" alt="User Avatar">
                                    @else
                                        <em class="icon ni ni-user-alt"></em>
                                    @endif
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-status user-status-{{ Auth::user()->status === 'active' ? 'verified' : 'unverified' }}">
                                        {{ ucfirst(Auth::user()->status) }}
                                    </div>
                                    <div class="user-name dropdown-indicator">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        @if(Auth::user()->photo)
                                            <img src="{{ asset(Auth::user()->photo) }}" alt="User Avatar">
                                        @else
                                            <span>{{ substr(Auth::user()->name, 0, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ Auth::user()->name }}</span>
                                        <span class="sub-text">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if(Auth::user()->role === 'user' && Auth::user()->wallet)
                                <div class="dropdown-inner user-account-info">
                                    <h6 class="overline-title-alt">Contribution Wallet</h6>
                                    <div class="user-balance">
                                        <span id="dropdown-wallet-balance">₦ {{ number_format(Auth::user()->wallet->balance, 2) }}</span> 
                                    </div>
                                        <div class="user-balance-sub">
                                            Total Contributions 
                                            <span>
                                                <span id="dropdown-total-contributions">₦ {{ number_format(Auth::user()->wallet->getActualTotalContributions(), 2) }}</span> 
                                            </span>
                                        </div>
                                    <a href="#" class="link">
                                        <span>View Wallet Details</span> 
                                        <em class="icon ni ni-wallet-out"></em>
                                    </a>
                                </div>
                            @endif
                            
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li>
                                        <a href="{{ route('user.profile') }}">
                                            <em class="icon ni ni-user-alt"></em>
                                            <span>View Profile</span>
                                        </a>
                                    </li>
                                    @if(Auth::user()->role === 'user')
                                        <li>
                                            <a href="#">
                                                <em class="icon ni ni-histroy"></em>
                                                <span>Contribution History</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <em class="icon ni ni-wallet"></em>
                                                <span>My Wallet</span>
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="#">
                                            <em class="icon ni ni-setting-alt"></em>
                                            <span>Security Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    
                                    
                                     <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <em class="icon ni ni-signout"></em><span>Logout</span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    
                    <!-- Notifications -->
                    <li class="dropdown notification-dropdown me-n1">
                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                            <div class="icon-status icon-status-info">
                                <em class="icon ni ni-bell"></em>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                            <div class="dropdown-head">
                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                <a href="#">Mark All as Read</a>
                            </div>
                            <div class="dropdown-body">
                                <div class="nk-notification">
                                    @php
                                        // Get recent contribution-related notifications
                                        $notifications = Auth::user()->contributions()
                                            ->where('created_at', '>=', now()->subDays(7))
                                            ->orderBy('created_at', 'desc')
                                            ->take(5)
                                            ->get();
                                    @endphp
                                    
                                    @forelse($notifications as $notification)
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-icon">
                                                <em class="icon icon-circle bg-{{ $notification->amount > 0 ? 'success' : 'warning' }}-dim ni ni-{{ $notification->amount > 0 ? 'check' : 'alert' }}-circle"></em>
                                            </div>
                                            <div class="nk-notification-content">
                                                <div class="nk-notification-text">
                                                    @if($notification->amount > 0)
                                                        Daily contribution of <span>₦{{ number_format($notification->amount, 2) }}</span> recorded
                                                    @else
                                                        <span>Missed</span> daily contribution for {{ $notification->contribution_date->format('M d') }}
                                                    @endif
                                                </div>
                                                <div class="nk-notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="nk-notification-item dropdown-inner">
                                            <div class="nk-notification-content text-center">
                                                <div class="nk-notification-text">No recent notifications</div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="dropdown-foot center">
                                <a href="#">View All</a>
                            </div>
                        </div>
                    </li>



                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
