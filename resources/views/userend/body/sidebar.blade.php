<!-- Desktop Sidebar Widget -->
<div class="nk-sidebar-widget d-none d-xl-block">
    <div class="user-account-info between-center">
        <div class="user-account-main">
            <h6 class="overline-title-alt">Wallet Balance</h6>
            <div class="user-balance">₦ {{ number_format(Auth::user()->wallet->balance, 2) }}</div>
            <div class="user-account-label">
                <span class="sub-text">Total Contributions: ₦{{ number_format(Auth::user()->wallet->getActualTotalContributions(), 2) }}</span>
            </div>
        </div>
        <a href="{{ route('user.wallet.details') }}" class="btn btn-white btn-icon btn-light">
            <em class="icon ni ni-wallet"></em>
        </a>
    </div>

    <ul class="user-account-data gy-1">
        <li>
            <div class="user-account-label">
                <span class="overline-title-alt">This Month</span>
            </div>
            <div class="user-account-value">
                @php
                    $currentMonthContributions = Auth::user()->contributions()
                        ->whereMonth('contribution_date', now()->month)
                        ->whereYear('contribution_date', now()->year)
                        ->where('status', 'paid')
                        ->sum('amount');
                    
                    $currentMonthAdjustments = Auth::user()->wallet->adjustments()
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->where('status', 'completed')
                        ->get();
                        
                    $omitted = $currentMonthAdjustments->where('type', 'credit')->where('reason', 'omitted_contribution')->sum('amount');
                    $corrections = $currentMonthAdjustments->where('type', 'debit')->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])->sum('amount');
                    
                    $correctedMonthTotal = $currentMonthContributions + $omitted - $corrections;
                @endphp
                
                <span class="sub-title text-base">
                    ₦{{ number_format($correctedMonthTotal, 0) }}
                    @if($omitted > 0 || $corrections > 0)
                        @if(($omitted - $corrections) > 0)
                            <small class="text-success">(+adj)</small>
                        @elseif(($omitted - $corrections) < 0)
                            <small class="text-warning">(-adj)</small>
                        @endif
                    @endif
                    <span class="currency">NGN</span>
                </span>
            </div>
        </li>
        <li>
            <div class="user-account-label">
                <span class="overline-title-alt">Completion Rate</span>
            </div>
            <div class="user-account-value">
                @php
                    $monthlyContributions = Auth::user()->contributions()
                        ->whereMonth('contribution_date', now()->month)
                        ->whereYear('contribution_date', now()->year)
                        ->get();
                    $paidDays = $monthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count();
                    $totalDays = $monthlyContributions->count();
                    $completionRate = $totalDays > 0 ? ($paidDays / $totalDays) * 100 : 0;
                @endphp
                <span class="sub-title text-base {{ $completionRate >= 80 ? 'text-success' : 'text-warning' }}">
                    {{ number_format($completionRate, 1) }}% 
                    <span class="currency">Rate</span>
                </span>
            </div>
        </li>
    </ul>
    
    <div class="user-account-actions">
        <ul class="g-3">
            <li>
                <a href="#" class="btn btn-lg btn-primary">
                    <span>Apply Loan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.contributions.history') }}" class="btn btn-lg btn-outline-primary">
                    <span>History</span>
                </a>
            </li>
        </ul>
    </div>
</div>



<!-- Mobile Sidebar Widget -->
<div class="nk-sidebar-widget nk-sidebar-widget-full d-xl-none pt-0">
    <a class="nk-profile-toggle toggle-expand" data-target="sidebarProfile" href="#">
        <div class="user-card-wrap">
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
                <div class="user-action"><em class="icon ni ni-chevron-down"></em></div>
            </div>
        </div>
    </a>
    
    <div class="nk-profile-content toggle-expand-content" data-content="sidebarProfile">
        <div class="user-account-info between-center">
            <div class="user-account-main">
                <h6 class="overline-title-alt">Wallet Balance</h6>
                <div class="user-balance">
                    ₦{{ number_format(Auth::user()->wallet->balance, 2) }} 
                    <small class="currency">NGN</small>
                </div>
                <div class="user-account-label">
                    <span class="sub-text">Total Contributions: ₦{{ number_format(Auth::user()->wallet->getActualTotalContributions(), 2) }}</span>
                </div>
            </div>
            <a href="{{ route('user.wallet.details') }}" class="btn btn-icon btn-light">
                <em class="icon ni ni-wallet"></em>
            </a>
        </div>
        
        <ul class="user-account-data">
            <li>
                <div class="user-account-label">
                    <span class="sub-text">This Month Total</span>
                </div>
                <div class="user-account-value">
                    @php
                        $mobileMonthContributions = Auth::user()->contributions()
                            ->whereMonth('contribution_date', now()->month)
                            ->whereYear('contribution_date', now()->year)
                            ->where('status', 'paid')
                            ->sum('amount');
                        
                        $mobileMonthAdjustments = Auth::user()->wallet->adjustments()
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->where('status', 'completed')
                            ->get();
                            
                        $mobileOmitted = $mobileMonthAdjustments->where('type', 'credit')->where('reason', 'omitted_contribution')->sum('amount');
                        $mobileCorrections = $mobileMonthAdjustments->where('type', 'debit')->whereIn('reason', ['correction_error', 'refund', 'penalty', 'duplicate_payment'])->sum('amount');
                        
                        $mobileCorrectedTotal = $mobileMonthContributions + $mobileOmitted - $mobileCorrections;
                    @endphp
                    <span class="sub-text text-base">
                        ₦{{ number_format($mobileCorrectedTotal, 0) }}
                        @if($mobileOmitted > 0 || $mobileCorrections > 0)
                            @if(($mobileOmitted - $mobileCorrections) > 0)
                                <small class="text-success">(+adj)</small>
                            @elseif(($mobileOmitted - $mobileCorrections) < 0)
                                <small class="text-warning">(-adj)</small>
                            @endif
                        @endif
                        <span class="currency">NGN</span>
                    </span>
                </div>
            </li>
            <li>
                <div class="user-account-label">
                    <span class="sub-text">Completion Rate</span>
                </div>
                <div class="user-account-value">
                    @php
                        $mobileMonthlyContributions = Auth::user()->contributions()
                            ->whereMonth('contribution_date', now()->month)
                            ->whereYear('contribution_date', now()->year)
                            ->get();
                        $mobilePaidDays = $mobileMonthlyContributions->where('status', 'paid')->where('amount', '>', 0)->count();
                        $mobileTotalDays = $mobileMonthlyContributions->count();
                        $mobileCompletionRate = $mobileTotalDays > 0 ? ($mobilePaidDays / $mobileTotalDays) * 100 : 0;
                    @endphp
                    <span class="sub-text text-base {{ $mobileCompletionRate >= 80 ? 'text-success' : 'text-warning' }}">
                        {{ number_format($mobileCompletionRate, 1) }}%
                    </span>
                </div>
            </li>
        </ul>
        
        <ul class="user-account-links">
            <li>
                <a href="{{ route('user.wallet.details') }}" class="link">
                    <span>Wallet Details</span> 
                    <em class="icon ni ni-wallet-out"></em>
                </a>
            </li>
            <li>
                <a href="{{ route('user.contributions.history') }}" class="link">
                    <span>Contribution History</span> 
                    <em class="icon ni ni-histroy"></em>
                </a>
            </li>
            <li>
                <a href="{{ route('user.contributions.calendar') }}" class="link">
                    <span>Calendar View</span> 
                    <em class="icon ni ni-calendar"></em>
                </a>
            </li>
        </ul>
        
        <ul class="link-list">
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                    <em class="icon ni ni-signout"></em>
                    <span>Sign out</span>
                </a>
                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>





<div class="nk-sidebar-menu">
   <ul class="nk-menu">
      <li class="nk-menu-heading">
         <h6 class="overline-title">Menu</h6>
      </li>
      <li class="nk-menu-item">
         <a href="{{ route('user.dashboard') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
            <span class="nk-menu-text">Dashboard</span>
         </a>
      </li>

      <li class="nk-menu-item">
         <a href="{{ route('user.wallet.deposit.index') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-wallet-in"></em></span>
            <span class="nk-menu-text">Fund Wallet</span>
         </a>
      </li>
      
      
      <li class="nk-menu-item">
         <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-coin-alt"></em></span>
            <span class="nk-menu-text">Loan Details</span>
         </a>
      </li>
      
      <li class="nk-menu-item has-sub">
         <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-property"></em></span><span class="nk-menu-text">Properties</span></a>
         <ul class="nk-menu-sub">
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Loan Types</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Classification</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Property Details</span></a></li>
         </ul>
      </li>

      <li class="nk-menu-item has-sub">
         <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-package"></em></span><span class="nk-menu-text">Package</span></a>
         <ul class="nk-menu-sub">
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Loan Package</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Package Documents</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Loan Application</span></a></li>
         </ul>
      </li>

      <li class="nk-menu-item">
         <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-calc"></em></span
            span class="nk-menu-text">EMI Calculator</span>
         </a>
      </li>
      
      <li class="nk-menu-item">
         <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-growth"></em></span>
            <span class="nk-menu-text">Report</span>
         </a>
      </li>
      
      <li class="nk-menu-item">
         <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-view-col2"></em></span>
            <span class="nk-menu-text">Branches</span>
         </a>
      </li>
      
      <li class="nk-menu-item">
         <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-account-setting"></em></span>
            <span class="nk-menu-text">My Profile</span>
         </a>
      </li>
      
      <li class="nk-menu-item has-sub">
         <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-icon"><em class="icon ni ni-files"></em></span><span class="nk-menu-text">Additional Pages</span></a>
         <ul class="nk-menu-sub">
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Awaiting Disbursement</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Archive Loans</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Overdue Repayments</span></a></li>
            <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-text">Application List</span></a></li>
         </ul>
      </li>

    </ul>
</div>
