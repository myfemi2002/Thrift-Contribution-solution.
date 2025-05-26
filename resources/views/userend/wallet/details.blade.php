{{-- userend.wallet.details --}}

@extends('userend.user_home')
@section('title', 'My Wallet')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">My Wallet</h3>
                    <div class="nk-block-des text-soft">
                        <p>Manage your wallet balance and view transaction history</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Dashboard</span>
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Wallet Overview -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-lg-8">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-3">
                                <div class="card-title">
                                    <h6 class="title">Wallet Overview</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon ni ni-help-fill" data-bs-toggle="tooltip" 
                                        title="Current wallet balance and total contributions"></em>
                                </div>
                            </div>
                            <div class="nk-ck">
                                <div class="row g-4">
                                    <div class="col-sm-6">
                                        <div class="amount-wrap text-center p-4 bg-light rounded">
                                            <div class="amount h3 text-primary mb-2">
                                                ₦{{ number_format($user->wallet->balance, 2) }}
                                            </div>
                                            <div class="amount-sm text-muted">Current Balance</div>
                                            <div class="mt-2">
                                                <em class="icon ni ni-wallet text-primary fs-3"></em>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="amount-wrap text-center p-4 bg-light rounded">
                                            <div class="amount h3 text-success mb-2">
                                                ₦{{ number_format($user->wallet->getActualTotalContributions(), 2) }}
                                            </div>
                                            <div class="amount-sm text-muted">Total Contributions</div>
                                            <div class="mt-2">
                                                <em class="icon ni ni-coins text-success fs-3"></em>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>{{-- userend.wallet.details - Updated This Month Stats Section --}}

<div class="col-lg-4">
    <div class="card card-bordered h-100">
        <div class="card-inner">
            <div class="card-title-group align-start mb-3">
                <div class="card-title">
                    <h6 class="title">This Month Stats</h6>
                </div>
                <div class="card-tools">
                    <em class="card-hint-icon ni ni-help-fill" data-bs-toggle="tooltip" 
                        title="Monthly statistics excluding incorrect adjustments"></em>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="amount-wrap text-center p-3 bg-info-light rounded">
                        <div class="amount h4 text-info">₦{{ number_format($monthlyStats['total_amount'], 2) }}</div>
                        <div class="amount-sm">Monthly Total</div>
                        @if(isset($monthlyStats['monthly_adjustments']) && ($monthlyStats['monthly_adjustments']['net_adjustments'] != 0))
                            <small class="text-muted d-block mt-1" data-bs-toggle="tooltip" 
                                   title="Raw contributions: ₦{{ number_format($monthlyStats['raw_contributions'], 2) }} + Adjustments: ₦{{ number_format($monthlyStats['monthly_adjustments']['net_adjustments'], 2) }}">
                                <em class="icon ni ni-info-circle"></em> Includes adjustments
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="amount-wrap text-center p-3 bg-success-light rounded">
                        <div class="amount h5 text-success">{{ $monthlyStats['paid_days'] }}</div>
                        <div class="amount-sm">Paid Days</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="amount-wrap text-center p-3 bg-danger-light rounded">
                        <div class="amount h5 text-danger">{{ $monthlyStats['unpaid_days'] }}</div>
                        <div class="amount-sm">Unpaid Days</div>
                    </div>
                </div>
                
                {{-- Additional breakdown if there were adjustments this month --}}
                @if(isset($monthlyStats['monthly_adjustments']) && 
                   ($monthlyStats['monthly_adjustments']['omitted_contributions'] > 0 || 
                    $monthlyStats['monthly_adjustments']['corrections'] > 0))
                    <div class="col-12">
                        <hr class="my-2">
                        <div class="small text-muted">
                            <div class="d-flex justify-content-between">
                                <span>Raw Contributions:</span>
                                <span>₦{{ number_format($monthlyStats['raw_contributions'], 2) }}</span>
                            </div>
                            @if($monthlyStats['monthly_adjustments']['omitted_contributions'] > 0)
                                <div class="d-flex justify-content-between text-success">
                                    <span>+ Omitted Contributions:</span>
                                    <span>₦{{ number_format($monthlyStats['monthly_adjustments']['omitted_contributions'], 2) }}</span>
                                </div>
                            @endif
                            @if($monthlyStats['monthly_adjustments']['corrections'] > 0)
                                <div class="d-flex justify-content-between text-danger">
                                    <span>- Corrections/Refunds:</span>
                                    <span>₦{{ number_format($monthlyStats['monthly_adjustments']['corrections'], 2) }}</span>
                                </div>
                            @endif
                            <hr class="my-1">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Net Total:</span>
                                <span>₦{{ number_format($monthlyStats['total_amount'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group mb-3">
                        <div class="card-title">
                            <h6 class="title">Quick Actions</h6>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('user.contributions.calendar') }}" class="btn btn-outline-primary btn-block">
                                <em class="icon ni ni-calendar me-2"></em>
                                <span>View Calendar</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('user.contributions.history') }}" class="btn btn-outline-info btn-block">
                                <em class="icon ni ni-histroy me-2"></em>
                                <span>Transaction History</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <button type="button" class="btn btn-outline-success btn-block" onclick="refreshWallet()">
                                <em class="icon ni ni-reload me-2"></em>
                                <span>Refresh Balance</span>
                            </button>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <button type="button" class="btn btn-outline-secondary btn-block" onclick="downloadStatement()">
                                <em class="icon ni ni-download me-2"></em>
                                <span>Download Statement</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Recent Transactions</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <a href="{{ route('user.contributions.history') }}" class="btn btn-icon btn-sm btn-outline-primary">
                                        <em class="icon ni ni-external"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    @if($recentTransactions->count() > 0)
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Type</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Description</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Amount</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Reference</span></div>
                            </div>

                            @foreach($recentTransactions as $transaction)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-{{ $transaction['color'] }}">
                                                <em class="icon ni {{ $transaction['icon'] }}"></em>
                                            </div>
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $transaction['type'] === 'contribution' ? 'Contribution' : 'Adjustment' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span>{{ $transaction['title'] }}</span>
                                        <div class="sub-text">{{ $transaction['description'] }}</div>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <span class="tb-amount {{ $transaction['amount'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction['amount'] >= 0 ? '+' : '' }}₦{{ number_format(abs($transaction['amount']), 2) }}
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        @if($transaction['status'] === 'paid')
                                            <span class="tb-status text-success">
                                                <em class="icon ni ni-check-circle"></em> Paid
                                            </span>
                                        @elseif($transaction['status'] === 'unpaid')
                                            <span class="tb-status text-danger">
                                                <em class="icon ni ni-cross-circle"></em> Unpaid
                                            </span>
                                        @else
                                            <span class="tb-status text-info">
                                                <em class="icon ni ni-check-circle"></em> {{ ucfirst($transaction['status']) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span>{{ $transaction['date']->format('M d, Y') }}</span>
                                        <div class="sub-text">{{ $transaction['date']->format('g:i A') }}</div>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <span class="text-soft">
                                            <code>{{ Str::limit($transaction['reference'], 12) }}</code>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Show More Button -->
                        @if($recentTransactions->count() >= 10)
                            <div class="card-inner text-center">
                                <a href="{{ route('user.contributions.history') }}" class="btn btn-outline-light">
                                    <em class="icon ni ni-forward-ios"></em>
                                    <span>View All Transactions</span>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <em class="icon ni ni-file-text" style="font-size: 3rem; color: #c4c4c4;"></em>
                            <h5 class="mt-3">No transactions yet</h5>
                            <p class="text-soft">Your transaction history will appear here once you start making contributions.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Wallet Information -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group mb-3">
                        <div class="card-title">
                            <h6 class="title">Wallet Information</h6>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Wallet Status</label>
                                <div class="form-control-wrap">
                                    <span class="badge badge-lg bg-{{ $user->wallet->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($user->wallet->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Account Holder</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <div class="form-control-wrap">
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="{{ $user->phone ?? 'Not provided' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Wallet Created</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" 
                                           value="{{ $user->wallet->created_at->format('M d, Y g:i A') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Last Updated</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" 
                                           value="{{ $user->wallet->updated_at->format('M d, Y g:i A') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refresh Balance Modal -->
<div class="modal fade" id="refreshModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5>Refreshing Balance...</h5>
                <p class="text-muted">Please wait while we update your wallet balance.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});

function refreshWallet() {
    $('#refreshModal').modal('show');
    
    $.ajax({
        url: "{{ route('user.wallet.balance') }}",
        method: 'GET',
        success: function(response) {
            if (response.success) {
                // Update balance display
                $('.amount.h3.text-primary').text('₦' + Number(response.balance).toLocaleString('en-US', {minimumFractionDigits: 2}));
                $('.amount.h3.text-success').text('₦' + Number(response.actual_total_contributions).toLocaleString('en-US', {minimumFractionDigits: 2}));
                $('.amount.h4.text-info').text('₦' + Number(response.month_contributions).toLocaleString('en-US', {minimumFractionDigits: 2}));
                
                showAlert('success', 'Wallet balance refreshed successfully');
            } else {
                showAlert('error', 'Failed to refresh wallet balance');
            }
        },
        error: function() {
            showAlert('error', 'Error occurred while refreshing balance');
        },
        complete: function() {
            $('#refreshModal').modal('hide');
        }
    });
}

function downloadStatement() {
    // Get current month for statement
    const currentMonth = new Date().toISOString().slice(0, 7);
    
    // Create form and submit for download
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = "{{ route('user.contributions.history') }}";
    form.target = '_blank';
    
    const monthInput = document.createElement('input');
    monthInput.type = 'hidden';
    monthInput.name = 'month';
    monthInput.value = currentMonth;
    
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'export';
    formatInput.value = 'pdf';
    
    form.appendChild(monthInput);
    form.appendChild(formatInput);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    showAlert('info', 'Preparing your statement for download...');
}

function showAlert(type, message) {
    // Simple alert for now - you can replace with your preferred notification system
    const alertClass = type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info');
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto-dismiss after 3 seconds
    setTimeout(() => {
        $('.alert').alert('close');
    }, 3000);
}
</script>

@push('css')
<style>
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 15px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.amount-wrap {
    transition: all 0.3s ease;
}

.amount-wrap:hover {
    transform: scale(1.02);
}

.bg-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

.bg-info-light {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
}

.bg-success-light {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
}

.bg-danger-light {
    background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%) !important;
}

.card-hint-icon {
    font-size: 1.2rem;
    color: #8091a7;
    cursor: help;
}

.btn-block {
    width: 100%;
    padding: 12px 20px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-block:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.tb-amount {
    font-size: 1.1rem;
    font-weight: 600;
}

.tb-status {
    font-weight: 600;
}

.user-avatar.xs {
    width: 32px;
    height: 32px;
    font-size: 12px;
}

.modal-content {
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.badge-lg {
    padding: 8px 16px;
    font-size: 0.875rem;
    font-weight: 600;
}

code {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.3rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

.nk-tb-item:hover {
    background-color: rgba(28, 208, 172, 0.02);
    transition: background-color 0.2s ease;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

@media (max-width: 768px) {
    .amount.h3 {
        font-size: 1.5rem;
    }
    
    .amount.h4 {
        font-size: 1.25rem;
    }
    
    .btn-block {
        padding: 10px 16px;
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection