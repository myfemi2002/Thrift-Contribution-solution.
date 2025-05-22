@extends('userend.user_home')
@section('title', 'Dashboard')
@section('user_content')
@php
$assetBase = asset('backend/assets/');
@endphp

<div class="container-fluid">
    <!-- Stats Overview Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Balance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($dashboardData['balance'], 2) }} USDT</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Deposits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($dashboardData['totalDeposits'], 2) }} USDT</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Deposits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($dashboardData['pendingDeposits'], 2) }} USDT</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Wallet Address</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800 text-truncate" title="{{ $dashboardData['walletAddress'] }}">
                                {{ Str::limit($dashboardData['walletAddress'], 15) }}
                                <button class="btn btn-sm btn-link p-0 ml-1" onclick="copyAddress('{{ $dashboardData['walletAddress'] }}')">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-qrcode fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Summary Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Account Summary</h6>
                    <div class="account-status">
                        <span class="badge bg-primary">Free member</span>
                        <a href="#" class="btn btn-sm btn-warning ms-2">
                            <i class="fas fa-crown me-1"></i> UPGRADE NOW
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Account Details</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Join date:</span>
                                            <span class="text-dark">{{ $dashboardData['joinDate'] }}</span>
                                        </li>
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Last login:</span>
                                            <span class="text-dark">{{ $dashboardData['lastLogin'] }}</span>
                                        </li>
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>IP Address:</span>
                                            <span class="text-dark">{{ $dashboardData['ipAddress'] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Financial Overview</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Balance:</span>
                                            <span class="fw-bold text-primary">${{ number_format($dashboardData['balance'], 2) }} USDT</span>
                                        </li>
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Total deposits:</span>
                                            <span class="text-success">${{ number_format($dashboardData['totalDeposits'], 2) }} USDT</span>
                                        </li>
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Pending deposits:</span>
                                            <span class="text-warning">${{ number_format($dashboardData['pendingDeposits'], 2) }} USDT</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Wallet Information</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Wallet Address:</span>
                                            <span class="text-dark">{{ $dashboardData['walletAddress'] }}</span>
                                        </li>
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Wallet status:</span>
                                            @if($dashboardData['wallet'])
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Not assigned</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item bg-light d-flex justify-content-between px-0">
                                            <span>Created:</span>
                                            <span class="text-dark">{{ $dashboardData['wallet'] ? $dashboardData['wallet']->created_at->format('d/m/Y') : 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Chart -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Deposits Overview</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="depositChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Deposit Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="depositStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Confirmed
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Pending
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Rejected
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="{{ route('user.wallet.deposit') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center py-4">
                                        <div class="icon-circle bg-primary text-white mb-3 mx-auto">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <h6 class="card-title mb-1">Deposit Funds</h6>
                                        <p class="card-text small text-muted">Add USDT to your wallet</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center py-4">
                                        <div class="icon-circle bg-info text-white mb-3 mx-auto">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <h6 class="card-title mb-1">Transaction History</h6>
                                        <p class="card-text small text-muted">View all transactions</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center py-4">
                                        <div class="icon-circle bg-success text-white mb-3 mx-auto">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                        <h6 class="card-title mb-1">Withdraw</h6>
                                        <p class="card-text small text-muted">Cash out funds</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="card-body text-center py-4">
                                        <div class="icon-circle bg-warning text-white mb-3 mx-auto">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <h6 class="card-title mb-1">Account Settings</h6>
                                        <p class="card-text small text-muted">Update your profile</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Deposits</h6>
                    <div>
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye fa-sm"></i> View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDeposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $deposit->tx_id }}">
                                            {{ Str::limit($deposit->tx_id, 15) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($deposit->amount, 6) }} USDT</td>
                                    <td>
                                        @if($deposit->status === 'pending')
                                            <span style="background-color: #ffc107; color: #212529; padding: 0.25em 0.6em; border-radius: 0.25rem;">Pending</span>
                                        @elseif($deposit->status === 'confirmed')
                                            <span style="background-color: #28a745; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem;">Confirmed</span>
                                        @elseif($deposit->status === 'rejected')
                                            <span style="background-color: #dc3545; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem;">Rejected</span>
                                            @if($deposit->appeal_status === 'pending')
                                                <span style="background-color: #17a2b8; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem; font-size: 0.75em; margin-left: 5px;">Appeal Pending</span>
                                            @elseif($deposit->appeal_status === 'approved')
                                                <span style="background-color: #28a745; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem; font-size: 0.75em; margin-left: 5px;">Appeal Approved</span>
                                            @elseif($deposit->appeal_status === 'rejected')
                                                <span style="background-color: #dc3545; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem; font-size: 0.75em; margin-left: 5px;">Appeal Rejected</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($deposit->status === 'rejected' && $deposit->isEligibleForAppeal())
                                            <a href="{{ route('user.wallet.deposit.appeal.form', $deposit->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-file-alt mr-1"></i> Appeal
                                            </a>
                                        @elseif($deposit->appeal_status === 'pending')
                                            <a href="{{ route('user.wallet.deposit.appeal.view', $deposit->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fa fa-eye mr-1"></i> View Appeal
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($recentDeposits->hasPages())
                        <div class="mt-3">
                            {{ $recentDeposits->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Card hover effect */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Icon circles */
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Card border accents */
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    
    .border-left-info {
        border-left: 4px solid #36b9cc !important;
    }
    
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    
    /* Table styles */
    .table {
        font-size: 0.85rem;
    }
    
    .table td, .table th {
        vertical-align: middle;
    }
    
    /* Badge styles */
    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .account-status {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .account-status .btn {
            margin-top: 0.5rem;
            margin-left: 0 !important;
        }
    }
    
    /* Chart container */
    .chart-area {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .chart-pie {
        position: relative;
        height: 240px;
        width: 100%;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Copy wallet address function
    function copyAddress(address) {
        navigator.clipboard.writeText(address).then(function() {
            // Show toast or notification
            alert('Wallet address copied to clipboard');
        }, function(err) {
            console.error('Could not copy address: ', err);
            alert('Failed to copy wallet address. Please try manually.');
        });
    }
    
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Line Chart for Deposits
        var ctx = document.getElementById("depositChart");
        var months = {!! $dashboardData['chartMonths'] !!};
        var values = {!! $dashboardData['chartValues'] !!};
        
        if (months.length === 0) {
            // Add dummy data if no deposits
            months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun"];
            values = [0, 0, 0, 0, 0, 0];
        }
        
        var depositChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: "Deposits",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: values,
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toFixed(2) + ' USDT';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        ticks: {
                            callback: function(value) {
                                return '$' + value + ' USDT';
                            }
                        },
                        grid: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }
                }
            }
        });
        
        // Pie Chart for Deposit Status
        var ctxPie = document.getElementById("depositStatusChart");
        var depositStatusChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ["Confirmed", "Pending", "Rejected"],
                datasets: [{
                    data: [
                        {{ $dashboardData['totalDeposits'] ?: 0 }}, 
                        {{ $dashboardData['pendingDeposits'] ?: 0 }}, 
                        {{ $dashboardData['rejectedDeposits'] ?: 0 }}
                    ],
                    backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                    hoverBackgroundColor: ['#17a673', '#e8bc4a', '#d13d2d'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': $' + context.parsed.toFixed(2) + ' USDT';
                            }
                        }
                    }
                }
            },
        });
    });
</script>
@endpush