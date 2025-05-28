@extends('userend.user_home')
@section('title', 'My Loans')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">My Loans</h3>
                    <div class="nk-block-des text-soft">
                        <p>Manage your loans and repayment history</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    @if($eligibility['eligible'])
                        <a href="{{ route('user.loans.create') }}" class="btn btn-primary d-none d-sm-inline-flex">
                            <em class="icon ni ni-plus"></em>
                            <span>Apply for Loan</span>
                        </a>
                        <a href="{{ route('user.loans.create') }}" class="btn btn-icon btn-primary d-inline-flex d-sm-none">
                            <em class="icon ni ni-plus"></em>
                        </a>
                    @else
                        <button class="btn btn-outline-secondary" disabled>
                            <em class="icon ni ni-info"></em>
                            <span>{{ $eligibility['reason'] }}</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Loan Statistics -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Available Balance</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-wallet text-primary"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($loanStats['current_balance'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">Loan wallet balance</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Borrowed</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-growth text-info"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($loanStats['total_borrowed'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">All time borrowing</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Repaid</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-check-circle text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($loanStats['total_repaid'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">Total payments made</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Outstanding</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-alert-circle text-warning"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">₦{{ number_format($loanStats['total_outstanding'], 2) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="sub-text">{{ $loanStats['active_loans'] }} active loan{{ $loanStats['active_loans'] != 1 ? 's' : '' }}</span>
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
                        @if($eligibility['eligible'])
                            <div class="col-sm-6 col-lg-3">
                                <a href="{{ route('user.loans.create') }}" class="btn btn-outline-primary btn-block">
                                    <em class="icon ni ni-plus me-2"></em>
                                    <span>Apply for Loan</span>
                                </a>
                            </div>
                        @endif
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('user.loans.history') }}" class="btn btn-outline-info btn-block">
                                <em class="icon ni ni-histroy me-2"></em>
                                <span>Loan History</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <button type="button" class="btn btn-outline-success btn-block" onclick="refreshBalance()">
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

        <!-- Recent Loans -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Recent Loans</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <a href="{{ route('user.loans.history') }}" class="btn btn-icon btn-sm btn-outline-primary">
                                        <em class="icon ni ni-external"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    @if($recentLoans->count() > 0)
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Loan ID</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Outstanding</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Due Date</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Action</span></div>
                            </div>

                            @foreach($recentLoans as $loan)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead font-monospace">{{ $loan->loan_id }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-amount fw-bold">{{ $loan->formatted_amount }}</span>
                                        @if($loan->interest_overridden)
                                            <span class="badge badge-sm bg-info">Custom Rate</span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        {!! $loan->status_badge !!}
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-amount {{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }}">
                                            {{ $loan->formatted_outstanding_balance }}
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        @if($loan->due_date)
                                            <span class="{{ $loan->is_overdue ? 'text-danger' : ($loan->days_until_due <= 5 ? 'text-warning' : '') }}">
                                                {{ $loan->due_date->format('M d, Y') }}
                                            </span>
                                            @if($loan->days_until_due !== null)
                                                <div class="sub-text">
                                                    @if($loan->is_overdue)
                                                        {{ abs($loan->days_until_due) }} days overdue
                                                    @else
                                                        {{ $loan->days_until_due }} days left
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <a href="{{ route('user.loans.show', $loan->id) }}" class="btn btn-sm btn-icon btn-outline-primary">
                                            <em class="icon ni ni-eye"></em>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <em class="icon ni ni-file-text" style="font-size: 3rem; color: #c4c4c4;"></em>
                            <h5 class="mt-3">No loans yet</h5>
                            <p class="text-soft">You haven't applied for any loans yet.</p>
                            @if($eligibility['eligible'])
                                <a href="{{ route('user.loans.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus me-2"></em>Apply for Your First Loan
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Notifications -->
        @if($notifications->count() > 0)
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Recent Updates</h6>
                            </div>
                        </div>
                        
                        <div class="timeline">
                            <ul class="timeline-list">
                                @foreach($notifications->take(5) as $notification)
                                    <li class="timeline-item">
                                        <div class="timeline-status bg-{{ $notification->color }}"></div>
                                        <div class="timeline-date">{{ $notification->created_at->format('M d') }}</div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">{{ $notification->title }}</h6>
                                            <div class="timeline-des">
                                                <p>{{ Str::limit($notification->message, 80) }}</p>
                                                <span class="time">{{ $notification->time_ago }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Popup Notification Modal -->
<div class="modal fade" id="loanNotificationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div id="notificationContent">
                    <!-- Notification content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it!</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Check for popup notifications on page load
    checkPopupNotifications();
    
    // Set interval to check for notifications every 30 seconds
    setInterval(checkPopupNotifications, 30000);
});

function checkPopupNotifications() {
    $.get('{{ route("user.loans.popup-notifications") }}', function(data) {
        if (data.success && data.notifications.length > 0) {
            showPopupNotifications(data.notifications);
        }
    }).fail(function() {
        console.log('Failed to fetch popup notifications');
    });
}

function showPopupNotifications(notifications) {
    notifications.forEach(function(notification, index) {
        setTimeout(function() {
            showNotificationPopup(notification);
        }, index * 1000); // Show each notification 1 second apart
    });
}

function showNotificationPopup(notification) {
    const content = `
        <div class="icon-circle icon-circle-lg bg-${notification.color}-light mx-auto mb-3">
            <em class="icon ni ${notification.icon} text-${notification.color}"></em>
        </div>
        <h4 class="title">${notification.title}</h4>
        <p class="text-soft">${notification.message}</p>
    `;
    
    $('#notificationContent').html(content);
    $('#loanNotificationModal').modal('show');
    
    // Mark notification as read
    $.post(`{{ url('user/loans/notifications') }}/${notification.id}/read`);
}

function refreshBalance() {
    const btn = $('[onclick="refreshBalance()"]');
    const originalText = btn.html();
    
    btn.prop('disabled', true).html('<em class="icon ni ni-loader"></em><span>Refreshing...</span>');
    
    // Reload the page to refresh data
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function downloadStatement() {
    // Implementation for downloading loan statement
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = "{{ route('user.loans.history') }}";
    form.target = '_blank';
    
    const exportInput = document.createElement('input');
    exportInput.type = 'hidden';
    exportInput.name = 'export';
    exportInput.value = 'pdf';
    
    form.appendChild(exportInput);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    showAlert('info', 'Preparing your loan statement for download...');
}

function showAlert(type, message) {
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

.btn-block {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 0.5rem;
    text-decoration: none;
}

.btn-block .icon {
    font-size: 1rem;
}

.timeline-item {
    position: relative;
    padding-left: 2rem;
    padding-bottom: 1rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-status {
    position: absolute;
    left: 0;
    top: 0.25rem;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-date {
    font-size: 0.75rem;
    color: #8094ae;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.timeline-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #364a63;
}

.timeline-des p {
    font-size: 0.875rem;
    color: #526484;
    margin-bottom: 0.25rem;
}

.timeline-des .time {
    font-size: 0.75rem;
    color: #8094ae;
}

.icon-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.icon-circle-lg {
    width: 4rem;
    height: 4rem;
}

.bg-primary-light {
    background-color: rgba(78, 115, 223, 0.1);
}

.bg-success-light {
    background-color: rgba(28, 200, 138, 0.1);
}

.bg-info-light {
    background-color: rgba(54, 185, 204, 0.1);
}

.bg-warning-light {
    background-color: rgba(246, 194, 62, 0.1);
}

.bg-danger-light {
    background-color: rgba(231, 74, 59, 0.1);
}

.modal-content {
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .card-amount .amount {
        font-size: 1.5rem;
    }
    
    .btn-block {
        padding: 0.5rem 0.25rem;
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection