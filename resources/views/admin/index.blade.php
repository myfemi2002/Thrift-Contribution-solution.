@extends('admin.admin_master')
@section('title', 'Dashboard')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Dashboard</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Summary Cards Row -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">{{ number_format($stats['total_users']) }}</h3>
                            <h6 class="text-muted">Total Users</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="progress-box mt-4">
                        <div class="progress-status">
                            <span class="text-muted">Active: {{ number_format($stats['active_users']) }}</span>
                            <span class="text-success ml-auto">
                                <i class="fa fa-arrow-up"></i> {{ $growthMetrics['user_growth'] }}%
                            </span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                 style="width: {{ $stats['total_users'] > 0 ? ($stats['active_users'] / $stats['total_users']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">₦{{ number_format($stats['total_contributions_month'], 2) }}</h3>
                            <h6 class="text-muted">Monthly Contributions</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <i class="fas fa-coins fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="progress-box mt-4">
                        <div class="progress-status">
                            <span class="text-muted">Today: ₦{{ number_format($stats['total_contributions_today'], 2) }}</span>
                            <span class="text-success ml-auto">
                                <i class="fa fa-arrow-up"></i> {{ $growthMetrics['contribution_growth'] }}%
                            </span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">{{ number_format($stats['total_loans']) }}</h3>
                            <h6 class="text-muted">Total Loans</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <i class="fas fa-money-bill fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="progress-box mt-4">
                        <div class="progress-status">
                            <span class="text-muted">Active: {{ number_format($stats['active_loans']) }}</span>
                            <span class="text-info ml-auto">
                                <i class="fa fa-arrow-up"></i> {{ $growthMetrics['loan_growth'] }}%
                            </span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" 
                                 style="width: {{ $stats['total_loans'] > 0 ? ($stats['active_loans'] / $stats['total_loans']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card board1 fill">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <div>
                            <h3 class="card_widget_header">₦{{ number_format($stats['total_wallet_balance'], 2) }}</h3>
                            <h6 class="text-muted">Total Wallet Balance</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <i class="fas fa-wallet fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="progress-box mt-4">
                        <div class="progress-status">
                            <span class="text-muted">Wallets: {{ number_format($stats['active_wallets']) }}</span>
                            <span class="text-warning ml-auto">
                                <i class="fa fa-chart-line"></i> Active
                            </span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Trends Chart -->
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Monthly Financial Trends</h4>
                    <small class="text-muted">Overview of contributions, loans, and withdrawals</small>
                </div>
                <div class="card-body">
                    <div id="monthly_trends_chart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>

        <!-- Loan Status Pie Chart -->
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Loan Status Distribution</h4>
                    <small class="text-muted">Current loan status breakdown</small>
                </div>
                <div class="card-body">
                    <div id="loan_status_pie" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-money-check-alt fa-3x text-warning"></i>
                    </div>
                    <h3 class="text-dark">{{ $pendingItems['pending_loans'] }}</h3>
                    <h6 class="text-muted mb-3">Pending Loans</h6>
                    <a href="{{ route('admin.loans.index') }}?status=pending" class="btn btn-warning btn-sm">
                        <i class="fas fa-eye"></i> Review
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-hand-holding-usd fa-3x text-info"></i>
                    </div>
                    <h3 class="text-dark">{{ $pendingItems['pending_withdrawals'] }}</h3>
                    <h6 class="text-muted mb-3">Pending Withdrawals</h6>
                    <a href="{{ route('admin.withdrawals.index') }}?status=pending" class="btn btn-info btn-sm">
                        <i class="fas fa-cogs"></i> Process
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-adjust fa-3x text-primary"></i>
                    </div>
                    <h3 class="text-dark">{{ $pendingItems['pending_adjustments'] }}</h3>
                    <h6 class="text-muted mb-3">Pending Adjustments</h6>
                    <a href="{{ route('admin.wallet-adjustments.index') }}?status=pending" class="btn btn-primary btn-sm">
                        <i class="fas fa-check"></i> Approve
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-lg-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                    </div>
                    <h3 class="text-dark">{{ $pendingItems['overdue_loans'] }}</h3>
                    <h6 class="text-muted mb-3">Overdue Loans</h6>
                    <a href="{{ route('admin.loans.index') }}?status=overdue" class="btn btn-danger btn-sm">
                        <i class="fas fa-search"></i> Review
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Table -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Activities</h4>
                    <small class="text-muted">Latest transactions and updates</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td>
                                        <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }} me-2"></i>
                                        <span class="font-weight-medium">{{ $activity['title'] }}</span>
                                    </td>
                                    <td>{{ $activity['user'] }}</td>
                                    <td>
                                        <span class="font-weight-medium">₦{{ number_format($activity['amount'], 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $activity['color'] }}">{{ ucfirst($activity['status']) }}</span>
                                    </td>
                                    <td class="text-muted">{{ $activity['time']->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-clock fa-2x text-muted mb-2 d-block"></i>
                                        <p class="text-muted">No recent activities found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Contributors and Financial Summary -->
    <div class="row">
        <!-- Top Contributors -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top Contributors This Month</h4>
                    <small class="text-muted">Users with highest contributions</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contribution</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topContributors as $index => $contributor)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <span class="font-weight-medium">{{ $contributor->name }}</span>
                                    </td>
                                    <td>{{ $contributor->email }}</td>
                                    <td>
                                        <span class="font-weight-medium text-success">₦{{ number_format($contributor->monthly_contribution, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-users fa-2x text-muted mb-2 d-block"></i>
                                        <p class="text-muted">No contributors found for this month</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Financial Summary</h4>
                    <small class="text-muted">Key financial metrics</small>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Disbursed</span>
                            <span class="font-weight-medium">₦{{ number_format($stats['total_disbursed'], 2) }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Outstanding Balance</span>
                            <span class="font-weight-medium text-warning">₦{{ number_format($stats['total_outstanding'], 2) }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" 
                                 style="width: {{ $stats['total_disbursed'] > 0 ? ($stats['total_outstanding'] / $stats['total_disbursed']) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Withdrawn</span>
                            <span class="font-weight-medium text-info">₦{{ number_format($stats['total_withdrawn'], 2) }}</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-info" style="width: 75%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Platform Health Score</span>
                            <span class="font-weight-medium text-success">{{ $stats['platform_health_score'] }}%</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: {{ $stats['platform_health_score'] }}%"></div>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary">{{ number_format($stats['new_users_this_month']) }}</h4>
                            <small class="text-muted">New Users</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">₦{{ number_format($stats['total_revenue'], 2) }}</h4>
                            <small class="text-muted">Revenue</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Alerts -->
    @if($pendingItems['high_priority_items']['loans_pending_over_24h'] > 0 || 
        $pendingItems['high_priority_items']['large_withdrawals_pending'] > 0 || 
        $pendingItems['high_priority_items']['overdue_loans_over_7_days'] > 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Attention Required!</h5>
                <ul class="mb-0">
                    @if($pendingItems['high_priority_items']['loans_pending_over_24h'] > 0)
                    <li>{{ $pendingItems['high_priority_items']['loans_pending_over_24h'] }} loan(s) pending for over 24 hours</li>
                    @endif
                    @if($pendingItems['high_priority_items']['large_withdrawals_pending'] > 0)
                    <li>{{ $pendingItems['high_priority_items']['large_withdrawals_pending'] }} large withdrawal(s) pending approval</li>
                    @endif
                    @if($pendingItems['high_priority_items']['overdue_loans_over_7_days'] > 0)
                    <li>{{ $pendingItems['high_priority_items']['overdue_loans_over_7_days'] }} loan(s) overdue for more than 7 days</li>
                    @endif
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Google Charts Script -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load Google Charts
    google.charts.load("current", {packages:["corechart", "line"]});
    google.charts.setOnLoadCallback(drawCharts);
    
    function drawCharts() {
        // Monthly Trends Line Chart
        var trendsData = google.visualization.arrayToDataTable({!! json_encode($monthlyTrendsData) !!});
        
        var trendsOptions = {
            title: 'Monthly Financial Trends (₦)',
            titleTextStyle: {
                fontSize: 16,
                bold: true,
                color: '#333'
            },
            curveType: 'function',
            legend: { 
                position: 'bottom',
                textStyle: {fontSize: 12}
            },
            colors: ['#28a745', '#007bff', '#ffc107'],
            backgroundColor: 'transparent',
            chartArea: {
                left: 80,
                top: 50,
                width: '85%',
                height: '70%'
            },
            hAxis: {
                title: 'Month',
                titleTextStyle: {fontSize: 12, bold: true},
                textStyle: {fontSize: 11}
            },
            vAxis: {
                title: 'Amount (₦)',
                titleTextStyle: {fontSize: 12, bold: true},
                textStyle: {fontSize: 11},
                format: '#,###'
            },
            series: {
                0: {lineWidth: 3, pointSize: 6},
                1: {lineWidth: 3, pointSize: 6},
                2: {lineWidth: 3, pointSize: 6}
            },
            tooltip: {
                textStyle: {fontSize: 12},
                showColorCode: true
            }
        };
        
        var trendsChart = new google.visualization.LineChart(document.getElementById('monthly_trends_chart'));
        trendsChart.draw(trendsData, trendsOptions);
        
        // Loan Status Pie Chart
        var loanData = google.visualization.arrayToDataTable({!! json_encode($loanStatusData) !!});
        
        var loanOptions = {
            title: 'Loan Status Distribution',
            titleTextStyle: {
                fontSize: 16,
                bold: true,
                color: '#333'
            },
            is3D: true,
            colors: ['#ffc107', '#17a2b8', '#007bff', '#28a745', '#dc3545', '#6c757d'],
            backgroundColor: 'transparent',
            chartArea: {
                left: 20,
                top: 50,
                width: '90%',
                height: '75%'
            },
            legend: {
                position: 'bottom',
                textStyle: {fontSize: 11}
            },
            tooltip: {
                textStyle: {fontSize: 12},
                showColorCode: true
            }
        };
        
        var loanChart = new google.visualization.PieChart(document.getElementById('loan_status_pie'));
        loanChart.draw(loanData, loanOptions);
    }
    
    // Make charts responsive
    window.addEventListener('resize', function() {
        drawCharts();
    });

    // Refresh dashboard data every 5 minutes
    setInterval(function() {
        location.reload();
    }, 300000);
</script>

@push('css')
<style>
    .card_widget_header {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .progress-box {
        margin-top: 1rem;
    }
    
    .progress-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .board1.fill {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .alert-heading {
        margin-bottom: 1rem;
    }
    
    .alert ul {
        padding-left: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .card_widget_header {
            font-size: 1.5rem;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@endsection