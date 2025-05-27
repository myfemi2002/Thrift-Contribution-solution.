{{-- backend.user-dashboard.index --}}
@extends('userend.user_home')
@section('title', 'Dashboard')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Welcome Header -->
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Welcome back, {{ Auth::user()->name }}!</h3>
                    <div class="nk-block-des text-soft">
                        <p>Here's what's happening with your contributions today.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                            <em class="icon ni ni-menu-alt-r"></em>
                        </a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li class="nk-block-tools-opt">
                                    <a href="{{ route('user.contributions.history') }}" class="btn btn-primary">
                                        <em class="icon ni ni-reports"></em>
                                        <span>View History</span>
                                    </a>
                                </li>
                                <li class="nk-block-tools-opt">
                                    <a href="{{ route('user.wallet.details') }}" class="btn btn-white btn-dim btn-outline-primary">
                                        <em class="icon ni ni-wallet"></em>
                                        <span>Wallet Details</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview Cards -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Current Balance</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-wallet text-primary"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($walletSummary['current_balance'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">Available for withdrawal</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Contributions</h6>
                                    <em class="card-hint-icon icon ni ni-help-fill ms-1" data-bs-toggle="tooltip" 
                                        title="Actual total contributions excluding incorrect adjustments"></em>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-growth text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($walletSummary['total_contributions'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">All time actual contributions</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">This Month</h6>
                                    @if(isset($monthlyStats['breakdown']) && $monthlyStats['breakdown']['net_adjustments'] != 0)
                                        <em class="card-hint-icon icon ni ni-help-fill ms-1" data-bs-toggle="tooltip" 
                                            title="Raw: ₦{{ number_format($monthlyStats['breakdown']['raw_contributions'], 2) }}, Adjustments: ₦{{ number_format($monthlyStats['breakdown']['net_adjustments'], 2) }}"></em>
                                    @endif
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-calendar text-info"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($walletSummary['this_month_contributions'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">
                                    {{ $monthlyStats['month_name'] }} total
                                    @if(isset($monthlyStats['breakdown']) && $monthlyStats['breakdown']['net_adjustments'] != 0)
                                        @if($monthlyStats['breakdown']['net_adjustments'] > 0)
                                            <span class="text-success">(+adj)</span>
                                        @else
                                            <span class="text-warning">(-adj)</span>
                                        @endif
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Completion Rate</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-pie text-warning"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($walletSummary['completion_rate'], 1) }}%</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text {{ $walletSummary['completion_rate'] >= 80 ? 'text-success' : 'text-warning' }}">
                                    {{ $walletSummary['completion_rate'] >= 80 ? 'Excellent performance' : 'Room for improvement' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="nk-block">
            <div class="row g-gs">
                <!-- Recent Transactions -->
                <div class="col-xxl-8">
                    <div class="card card-bordered card-full">
                        <div class="card-inner border-bottom">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Recent Transactions</h6>
                                </div>
                                <div class="card-tools">
                                    <a href="{{ route('user.contributions.history') }}" class="link">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner p-0">
                            @if($recentTransactions->count() > 0)
                                <div class="nk-tb-list nk-tb-ulist">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col nk-tb-col-check">
                                            <span class="sub-text">#</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="sub-text">Transaction</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-mb">
                                            <span class="sub-text">Date</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <span class="sub-text">Amount</span>
                                        </div>
                                        <div class="nk-tb-col tb-col-lg">
                                            <span class="sub-text">Status</span>
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-tools text-end">
                                            <span class="sub-text">Action</span>
                                        </div>
                                    </div>

                                    @foreach($recentTransactions->take(6) as $transaction)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-col-check">
                                                <span class="tb-lead">#{{ substr($transaction['reference'], -4) }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-avatar sm bg-{{ $transaction['color'] }}">
                                                        <em class="icon ni {{ $transaction['icon'] ?? 'ni-wallet-fill' }}"></em>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $transaction['title'] }}</span>
                                                        <span class="fs-12px text-soft">{{ Str::limit($transaction['description'] ?? 'Daily contribution payment', 30) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-mb">
                                                <span class="tb-amount">{{ $transaction['date']->format('M d, Y') }}</span>
                                                <span class="tb-amount-sm">{{ $transaction['date']->format('h:i A') }}</span>
                                            </div>
                                            <div class="nk-tb-col tb-col-md">
                                                <span class="tb-amount {{ $transaction['amount'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $transaction['amount'] >= 0 ? '+' : '' }}₦{{ number_format(abs($transaction['amount']), 2) }}
                                                </span>
                                            </div>
                                            <div class="nk-tb-col tb-col-lg">
                                                <span class="badge badge-sm badge-dot has-bg bg-{{ $transaction['color'] }} d-none d-mb-inline-flex">
                                                    {{ ucfirst($transaction['status']) }}
                                                </span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-h"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li>
                                                                        <a href="{{ route('user.contributions.history') }}">
                                                                            <em class="icon ni ni-eye"></em>
                                                                            <span>View Details</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" onclick="copyReference('{{ $transaction['reference'] }}')">
                                                                            <em class="icon ni ni-copy"></em>
                                                                            <span>Copy Reference</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="card-inner">
                                    <div class="nk-tb-empty">
                                        <div class="nk-tb-empty-icon">
                                            <em class="icon ni ni-tranx"></em>
                                        </div>
                                        <div class="nk-tb-empty-title">
                                            <h5>No transactions found</h5>
                                        </div>
                                        <div class="nk-tb-empty-text">
                                            <p class="text-soft">You haven't made any contributions yet. Start contributing to see your transaction history here.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Activity & Quick Actions -->
                <div class="col-xxl-4">
                    <div class="row g-gs">
                        <!-- Recent Activity - Fixed and Limited -->
                        <div class="col-md-6 col-xxl-12">
                            <div class="card card-bordered">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Recent Activity</h6>
                                            @php
                                                $totalActivities = $notifications->count();
                                                $displayCount = min(4, $totalActivities);
                                            @endphp
                                            @if($totalActivities > 0)
                                                <span class="badge bg-light text-dark ms-2">{{ $totalActivities }}</span>
                                            @endif
                                        </div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-filter-alt"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#" data-filter="all" class="filter-btn active"><em class="icon ni ni-list"></em><span>All Activities</span></a></li>
                                                        <li><a href="#" data-filter="contribution" class="filter-btn"><em class="icon ni ni-coins"></em><span>Contributions</span></a></li>
                                                        <li><a href="#" data-filter="withdrawal" class="filter-btn"><em class="icon ni ni-wallet-out"></em><span>Withdrawals</span></a></li>
                                                        <li><a href="#" data-filter="adjustment" class="filter-btn"><em class="icon ni ni-edit"></em><span>Adjustments</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner">
                                    @if($notifications->count() > 0)
                                        <div class="timeline" id="activity-timeline">
                                            <ul class="timeline-list">
                                                @foreach($notifications->take(4) as $index => $notification)
                                                    @php
                                                        $activityType = explode('_', $notification['type'])[0];
                                                    @endphp
                                                    <li class="timeline-item activity-item" data-type="{{ $activityType }}" data-index="{{ $index }}">
                                                        <div class="timeline-status bg-{{ $notification['color'] }}">
                                                            <em class="icon ni {{ $notification['icon'] }}"></em>
                                                        </div>
                                                        <div class="timeline-date">{{ $notification['date']->format('M d') }}</div>
                                                        <div class="timeline-data">
                                                            <h6 class="timeline-title">{{ $notification['title'] }}</h6>
                                                            <div class="timeline-des">
                                                                <p>{{ Str::limit($notification['message'], 60) }}</p>
                                                                <span class="time">{{ $notification['time_ago'] }}</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                
                                                <!-- Hidden items for "Load More" functionality -->
                                                @if($notifications->count() > 4)
                                                    @foreach($notifications->slice(4)->take(6) as $index => $notification)
                                                        @php
                                                            $activityType = explode('_', $notification['type'])[0];
                                                        @endphp
                                                        <li class="timeline-item activity-item activity-hidden" data-type="{{ $activityType }}" data-index="{{ $index + 4 }}" style="display: none;">
                                                            <div class="timeline-status bg-{{ $notification['color'] }}">
                                                                <em class="icon ni {{ $notification['icon'] }}"></em>
                                                            </div>
                                                            <div class="timeline-date">{{ $notification['date']->format('M d') }}</div>
                                                            <div class="timeline-data">
                                                                <h6 class="timeline-title">{{ $notification['title'] }}</h6>
                                                                <div class="timeline-des">
                                                                    <p>{{ Str::limit($notification['message'], 60) }}</p>
                                                                    <span class="time">{{ $notification['time_ago'] }}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        
                                        <!-- Activity Controls -->
                                        <div class="activity-controls mt-3 pt-3 border-top">
                                            <div class="row g-2">
                                                @if($notifications->count() > 4)
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-outline-primary w-100" id="loadMoreBtn">
                                                            <em class="icon ni ni-plus"></em>
                                                            <span>Show More</span>
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="showLessBtn" style="display: none;">
                                                            <em class="icon ni ni-minus"></em>
                                                            <span>Show Less</span>
                                                        </button>
                                                    </div>
                                                @endif
                                                @if($notifications->count() > 10)
                                                    <div class="col-12">
                                                        <a href="{{ route('user.contributions.history') }}" class="btn btn-sm btn-primary w-100">
                                                            <em class="icon ni ni-arrow-right"></em>
                                                            <span>View All Activities ({{ $notifications->count() }})</span>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Activity Summary -->
                                        @php
                                            $contributionCount = $notifications->filter(function($n) { 
                                                return str_contains($n['type'], 'contribution'); 
                                            })->count();
                                            $withdrawalCount = $notifications->filter(function($n) { 
                                                return str_contains($n['type'], 'withdrawal'); 
                                            })->count();
                                            $adjustmentCount = $notifications->filter(function($n) { 
                                                return str_contains($n['type'], 'adjustment'); 
                                            })->count();
                                        @endphp
                                        
                                        @if($contributionCount > 0 || $withdrawalCount > 0 || $adjustmentCount > 0)
                                            <div class="activity-summary mt-3 pt-3 border-top">
                                                <div class="row g-2 text-center">
                                                    @if($contributionCount > 0)
                                                        <div class="col-4">
                                                            <div class="summary-item">
                                                                <span class="summary-count text-success">{{ $contributionCount }}</span>
                                                                <span class="summary-label">Contributions</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($withdrawalCount > 0)
                                                        <div class="col-4">
                                                            <div class="summary-item">
                                                                <span class="summary-count text-info">{{ $withdrawalCount }}</span>
                                                                <span class="summary-label">Withdrawals</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($adjustmentCount > 0)
                                                        <div class="col-4">
                                                            <div class="summary-item">
                                                                <span class="summary-count text-warning">{{ $adjustmentCount }}</span>
                                                                <span class="summary-label">Adjustments</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-4">
                                            <div class="icon-circle icon-circle-lg bg-gray-100 mx-auto mb-3">
                                                <em class="icon ni ni-bell text-gray-500"></em>
                                            </div>
                                            <h6 class="text-gray-600">No Recent Activity</h6>
                                            <p class="text-soft fs-12px">Your activities will appear here</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>

                    
                </div>

                                        <!-- Quick Actions -->
                        <div class="col-md-6 col-xxl-12">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title mt-3 mb-3">Quick Actions</h6>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <a href="{{ route('user.contributions.history') }}" class="btn btn-outline-primary btn-block">
                                                <em class="icon ni ni-reports"></em>
                                                <span>History</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('user.wallet.details') }}" class="btn btn-outline-success btn-block">
                                                <em class="icon ni ni-wallet"></em>
                                                <span>Wallet</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('user.contributions.calendar') }}" class="btn btn-outline-info btn-block">
                                                <em class="icon ni ni-calendar"></em>
                                                <span>Calendar</span>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary btn-block">
                                                <em class="icon ni ni-user"></em>
                                                <span>Profile</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>

        <!-- Monthly Overview -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner border-bottom">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">{{ $monthlyStats['month_name'] }} Overview</h6>
                            @if(isset($monthlyStats['breakdown']) && $monthlyStats['breakdown']['net_adjustments'] != 0)
                                <em class="card-hint-icon ni ni-help-fill ms-2" data-bs-toggle="tooltip" 
                                    title="Total includes adjustments: Net ₦{{ number_format($monthlyStats['breakdown']['net_adjustments'], 2) }}"></em>
                            @endif
                        </div>
                        <div class="card-tools">
                            <a href="{{ route('user.contributions.calendar') }}" class="btn btn-outline-primary btn-sm">
                                <em class="icon ni ni-calendar"></em>
                                <span>View Calendar</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-inner">
                    <div class="row text-center border-bottom g-4 py-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="profile-stats">
                                <div class="amount">{{ $monthlyStats['paid_days'] }}</div>
                                <div class="label">Days Paid</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="profile-stats">
                                <div class="amount text-warning">{{ $monthlyStats['unpaid_days'] }}</div>
                                <div class="label">Days Unpaid</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="profile-stats">
                                <div class="amount text-success">₦{{ number_format($monthlyStats['total_amount'], 0) }}</div>
                                <div class="label">
                                    Total Amount
                                    @if(isset($monthlyStats['breakdown']) && $monthlyStats['breakdown']['net_adjustments'] != 0)
                                        <small class="d-block text-muted" style="font-size: 10px;">
                                            (₦{{ number_format($monthlyStats['breakdown']['raw_contributions'], 0) }} 
                                            @if($monthlyStats['breakdown']['net_adjustments'] > 0)
                                                + ₦{{ number_format($monthlyStats['breakdown']['net_adjustments'], 0) }})
                                            @else
                                                - ₦{{ number_format(abs($monthlyStats['breakdown']['net_adjustments']), 0) }})
                                            @endif
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="profile-stats">
                                <div class="amount text-info">₦{{ number_format($monthlyStats['average_daily'], 0) }}</div>
                                <div class="label">Daily Average</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Show adjustment breakdown if there were adjustments this month --}}
                    @if(isset($monthlyStats['breakdown']) && 
                       ($monthlyStats['breakdown']['omitted_additions'] > 0 || 
                        $monthlyStats['breakdown']['corrections_subtracted'] > 0))
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    <h6 class="alert-heading">
                                        <em class="icon ni ni-info text-info"></em>
                                        Monthly Breakdown
                                    </h6>
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <div class="small">
                                                <strong>Raw Contributions</strong><br>
                                                <span class="text-primary">₦{{ number_format($monthlyStats['breakdown']['raw_contributions'], 2) }}</span>
                                            </div>
                                        </div>
                                        @if($monthlyStats['breakdown']['omitted_additions'] > 0)
                                            <div class="col-md-4">
                                                <div class="small">
                                                    <strong class="text-success">+ Omitted Contributions</strong><br>
                                                    <span class="text-success">₦{{ number_format($monthlyStats['breakdown']['omitted_additions'], 2) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($monthlyStats['breakdown']['corrections_subtracted'] > 0)
                                            <div class="col-md-4">
                                                <div class="small">
                                                    <strong class="text-danger">- Corrections</strong><br>
                                                    <span class="text-danger">₦{{ number_format($monthlyStats['breakdown']['corrections_subtracted'], 2) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if($monthlyStats['breakdown']['omitted_additions'] > 0 || $monthlyStats['breakdown']['corrections_subtracted'] > 0)
                                        <hr class="my-2">
                                        <div class="text-center">
                                            <strong>Final Total: ₦{{ number_format($monthlyStats['total_amount'], 2) }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="text-center pt-4">
                        <p class="text-soft">
                            You've completed <strong>{{ number_format($walletSummary['completion_rate'], 1) }}%</strong> of your contributions this month.
                            @if($walletSummary['completion_rate'] >= 80)
                                Keep up the excellent work! 🎉
                            @else
                                Let's aim for better consistency! 💪
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize dashboard functionality
    initializeDashboard();
    
    // Auto-refresh data every 30 seconds
    setInterval(function() {
        refreshDashboardData();
    }, 30000);

    // Refresh on page focus
    $(window).on('focus', function() {
        refreshDashboardData();
    });
});

function initializeDashboard() {
    // Activity filter functionality
    $('.filter-btn').on('click', function(e) {
        e.preventDefault();
        
        const filterType = $(this).data('filter');
        const $items = $('.activity-item');
        
        // Update active state
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        // Filter items with animation
        $items.each(function(index) {
            const itemType = $(this).data('type');
            const $item = $(this);
            
            if (filterType === 'all' || itemType === filterType) {
                $item.fadeIn(200 + (index * 50));
            } else {
                $item.fadeOut(200);
            }
        });
        
        // Update visible count
        setTimeout(function() {
            updateActivityCount();
        }, 300);
    });
    
    // Load more functionality
    $('#loadMoreBtn').on('click', function() {
        const $hiddenItems = $('.activity-hidden');
        const $btn = $(this);
        
        $btn.prop('disabled', true).html('<em class="icon ni ni-loader"></em><span>Loading...</span>');
        
        setTimeout(function() {
            $hiddenItems.fadeIn(300);
            $btn.hide();
            $('#showLessBtn').show();
        }, 500);
    });
    
    // Show less functionality
    $('#showLessBtn').on('click', function() {
        const $hiddenItems = $('.activity-hidden');
        
        $hiddenItems.fadeOut(300);
        $(this).hide();
        $('#loadMoreBtn').show().prop('disabled', false).html('<em class="icon ni ni-plus"></em><span>Show More</span>');
        
        // Scroll to activity section
        $('html, body').animate({
            scrollTop: $('#activity-timeline').offset().top - 100
        }, 300);
    });
}

function updateActivityCount() {
    const visibleCount = $('.activity-item:visible').length;
    const totalCount = $('.activity-item').length;
    
    $('.card-title .badge').text(visibleCount);
}

function refreshDashboardData() {
    $.get('{{ route("user.wallet.balance") }}', function(data) {
        if (data.success) {
            updateWalletBalance(data);
            updateMonthlyContributions(data);
            updateTotalContributions(data);
        }
    }).fail(function() {
        console.log('Failed to refresh dashboard data');
    });
}

function updateWalletBalance(data) {
    $('.card-amount .amount').eq(0).text('₦' + parseFloat(data.balance).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));
}

function updateTotalContributions(data) {
    $('.card-amount .amount').eq(1).text('₦' + parseFloat(data.actual_total_contributions).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));
}

function updateMonthlyContributions(data) {
    $('.card-amount .amount').eq(2).text('₦' + parseFloat(data.month_contributions).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));
}

function copyReference(reference) {
    navigator.clipboard.writeText(reference).then(function() {
        showToast('Reference copied to clipboard', 'success');
    }).catch(function() {
        const textArea = document.createElement('textarea');
        textArea.value = reference;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showToast('Reference copied to clipboard', 'success');
        } catch (err) {
            showToast('Failed to copy reference', 'error');
        }
        document.body.removeChild(textArea);
    });
}

function showToast(message, type = 'info', duration = 3000) {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-left: 4px solid ${type === 'success' ? '#27ae60' : '#e74c3c'};
        padding: 1rem;
        max-width: 300px;
        animation: slideInRight 0.3s ease;
    `;
    
    toast.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <em class="icon ni ni-${type === 'success' ? 'check' : 'alert'}-circle"></em>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, duration);
}
</script>
@endpush

@push('css')
<style>
/* Dashboard Styles */
.card-amount .amount {
    font-size: 1.75rem;
    font-weight: 700;
    color: #364a63;
    line-height: 1.2;
}

.card-hint-icon {
    font-size: 1.25rem;
    opacity: 0.8;
}

.profile-stats .amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #364a63;
    margin-bottom: 0.25rem;
}

.profile-stats .label {
    font-size: 0.875rem;
    color: #8094ae;
    font-weight: 500;
}

.btn-block {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem 0.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-block .icon {
    font-size: 1.125rem;
    margin-bottom: 0.25rem;
}

.btn-block span {
    font-size: 0.875rem;
    font-weight: 500;
}

/* Timeline Styles */
.timeline-item {
    position: relative;
    padding-left: 2rem;
    padding-bottom: 1rem;
    transition: all 0.3s ease;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item:hover {
    transform: translateX(2px);
}

.timeline-status {
    position: absolute;
    left: 0;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-status .icon {
    font-size: 6px;
    color: #fff;
}

.timeline-date {
    font-size: 0.7rem;
    color: #8094ae;
    font-weight: 600;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timeline-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #364a63;
}

.timeline-des p {
    font-size: 0.8rem;
    color: #526484;
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.timeline-des .time {
    font-size: 0.7rem;
    color: #8094ae;
    font-weight: 500;
}

/* Activity Controls */
.activity-controls .btn {
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.activity-controls .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Activity Summary */
.activity-summary {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    padding: 0.75rem;
}

.summary-item {
    text-align: center;
}

.summary-count {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
}

.summary-label {
    display: block;
    font-size: 0.7rem;
    text-transform: uppercase;
    font-weight: 600;
    opacity: 0.8;
    margin-top: 0.25rem;
}

/* Filter Styles */
.filter-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    border-radius: 4px;
}

.filter-btn:hover {
    background: #f8f9fa;
    transform: translateX(2px);
}

.filter-btn.active {
    background: #e3f2fd;
    color: #1976d2;
    font-weight: 600;
}

/* Icon Styles */
.icon-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.icon-circle-lg {
    width: 3rem;
    height: 3rem;
}

.bg-gray-100 {
    background-color: #f5f6fa;
}

.text-gray-500 {
    color: #8094ae;
}

.text-gray-600 {
    color: #526484;
}

/* Card Styles */
.card-bordered {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card-bordered:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.card-full {
    height: 100%;
}

/* Toast Animations */
@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOutRight {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}

/* Table Styles */
.nk-tb-empty {
    text-align: center;
    padding: 2rem 1rem;
}

.nk-tb-empty-icon {
    margin-bottom: 1rem;
}

.nk-tb-empty-icon .icon {
    font-size: 3rem;
    color: #c4c4c4;
}

.nk-tb-empty-title h5 {
    color: #364a63;
    margin-bottom: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-amount .amount {
        font-size: 1.5rem;
    }
    
    .profile-stats .amount {
        font-size: 1.25rem;
    }
    
    .btn-block {
        padding: 0.5rem 0.25rem;
    }
    
    .btn-block .icon {
        font-size: 1rem;
    }
    
    .btn-block span {
        font-size: 0.75rem;
    }
    
    .timeline-item {
        padding-left: 1.5rem;
    }
    
    .timeline-status {
        width: 10px;
        height: 10px;
    }
    
    .timeline-status .icon {
        font-size: 5px;
    }
}

@media (max-width: 576px) {
    .nk-block-head-content h3 {
        font-size: 1.25rem;
    }
    
    .activity-controls .row {
        gap: 0.5rem;
    }
    
    .activity-controls .btn {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
    }
}

/* Smooth Transitions */
.activity-item {
    transition: all 0.3s ease;
}

.activity-hidden {
    opacity: 0;
    transform: translateY(10px);
}

.activity-hidden.show {
    opacity: 1;
    transform: translateY(0);
}

/* Badge Styles */
.badge {
    font-weight: 600;
    border-radius: 12px;
}

.bg-light {
    background-color: #f8f9fa !important;
    border: 1px solid #dee2e6;
}
</style>
@endpush

@endsection