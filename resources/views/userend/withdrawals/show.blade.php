@extends('userend.user_home')
@section('title', 'Withdrawal Details')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Withdrawal Details</h3>
                    <div class="nk-block-des text-soft">
                        <p>View withdrawal request information and status</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.withdrawals.index') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Withdrawals</span>
                    </a>
                    <a href="{{ route('user.withdrawals.index') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Withdrawal Status Card -->
        <div class="nk-block">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-inner">
                            <div class="row align-items-center">
                                <div class="col-sm-8">
                                    <div class="media media-lg">
                                        <div class="media-object">
                                            <div class="icon-circle icon-circle-lg 
                                                {{ $withdrawal->isPending() ? 'bg-warning' : '' }}
                                                {{ $withdrawal->isApproved() ? 'bg-info' : '' }}
                                                {{ $withdrawal->isProcessing() ? 'bg-primary' : '' }}
                                                {{ $withdrawal->isCompleted() ? 'bg-success' : '' }}
                                                {{ $withdrawal->isRejected() ? 'bg-danger' : '' }}
                                                {{ $withdrawal->isCancelled() ? 'bg-secondary' : '' }}">
                                                <em class="icon ni ni-
                                                    {{ $withdrawal->isPending() ? 'clock' : '' }}
                                                    {{ $withdrawal->isApproved() ? 'check' : '' }}
                                                    {{ $withdrawal->isProcessing() ? 'loader' : '' }}
                                                    {{ $withdrawal->isCompleted() ? 'check-circle' : '' }}
                                                    {{ $withdrawal->isRejected() ? 'cross-circle' : '' }}
                                                    {{ $withdrawal->isCancelled() ? 'na' : '' }}"></em>
                                            </div>
                                        </div>
                                        <div class="media-content">
                                            <h5 class="media-title">{{ ucfirst($withdrawal->status) }} Withdrawal</h5>
                                            <span class="media-sub-title">
                                                Withdrawal ID: <strong>{{ $withdrawal->withdrawal_id }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-sm-end mt-3 mt-sm-0">
                                    {!! $withdrawal->status_badge !!}
                                    @if($withdrawal->isPending())
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="cancelWithdrawal()">
                                                <em class="icon ni ni-cross me-1"></em>Cancel Request
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Information -->
        <div class="nk-block">
            <div class="row g-gs">
                <!-- Main Details -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Withdrawal Information</h6>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-soft">Withdrawal Amount</label>
                                        <div class="h4 text-primary">₦{{ number_format($withdrawal->amount, 2) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-soft">Processing Fee</label>
                                        <div class="h5 text-warning">₦{{ number_format($withdrawal->fee, 2) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-soft">Net Amount (You'll Receive)</label>
                                        <div class="h4 text-success">₦{{ number_format($withdrawal->net_amount, 2) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-soft">Payment Method</label>
                                        <div class="h6">{{ $withdrawal->payment_method_label }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label text-soft">Reason for Withdrawal</label>
                                        <div class="bg-light p-3 rounded">{{ $withdrawal->reason }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details (if applicable) -->
                    @if($withdrawal->payment_method === 'bank_transfer')
                        <div class="card mt-4">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Bank Account Details</h6>
                                    </div>
                                </div>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-soft">Bank Name</label>
                                            <div class="h6">{{ $withdrawal->bank_name }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label text-soft">Account Number</label>
                                            <div class="h6 font-monospace">{{ $withdrawal->account_number }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label text-soft">Account Name</label>
                                            <div class="h6">{{ $withdrawal->account_name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Admin Notes (if any) -->
                    @if($withdrawal->admin_notes || $withdrawal->rejection_reason)
                        <div class="card mt-4">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">
                                            @if($withdrawal->isRejected())
                                                Rejection Reason
                                            @else
                                                Admin Notes
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                                
                                <div class="alert {{ $withdrawal->isRejected() ? 'alert-danger' : 'alert-info' }}">
                                    {{ $withdrawal->rejection_reason ?? $withdrawal->admin_notes }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Timeline -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Status Timeline</h6>
                                </div>
                            </div>
                            
                            <div class="timeline">
                                <ul class="timeline-list">
                                    <!-- Request Submitted -->
                                    <li class="timeline-item">
                                        <div class="timeline-status bg-primary"></div>
                                        <div class="timeline-date">{{ $withdrawal->created_at->format('M d, Y') }}</div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">Request Submitted</h6>
                                            <div class="timeline-des">
                                                <p>Withdrawal request created</p>
                                                <span class="time">{{ $withdrawal->created_at->format('g:i A') }}</span>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Approval/Rejection -->
                                    @if($withdrawal->approved_at)
                                        <li class="timeline-item">
                                            <div class="timeline-status {{ $withdrawal->isRejected() ? 'bg-danger' : 'bg-info' }}"></div>
                                            <div class="timeline-date">{{ $withdrawal->approved_at->format('M d, Y') }}</div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">
                                                    {{ $withdrawal->isRejected() ? 'Request Rejected' : 'Request Approved' }}
                                                </h6>
                                                <div class="timeline-des">
                                                    <p>
                                                        {{ $withdrawal->isRejected() ? 'Rejected' : 'Approved' }} by admin
                                                        @if($withdrawal->approvedBy)
                                                            ({{ $withdrawal->approvedBy->name }})
                                                        @endif
                                                    </p>
                                                    <span class="time">{{ $withdrawal->approved_at->format('g:i A') }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    <!-- Processing -->
                                    @if($withdrawal->processed_at)
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-primary"></div>
                                            <div class="timeline-date">{{ $withdrawal->processed_at->format('M d, Y') }}</div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">Payment Processing</h6>
                                                <div class="timeline-des">
                                                    <p>Payment is being processed</p>
                                                    <span class="time">{{ $withdrawal->processed_at->format('g:i A') }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    <!-- Completion -->
                                    @if($withdrawal->completed_at)
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-success"></div>
                                            <div class="timeline-date">{{ $withdrawal->completed_at->format('M d, Y') }}</div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">Payment Completed</h6>
                                                <div class="timeline-des">
                                                    <p>Payment successfully delivered</p>
                                                    <span class="time">{{ $withdrawal->completed_at->format('g:i A') }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    <!-- Pending Status -->
                                    @if($withdrawal->isPending())
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-warning"></div>
                                            <div class="timeline-date">Pending</div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title">Awaiting Admin Approval</h6>
                                                <div class="timeline-des">
                                                    <p>Request is pending admin review</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mt-4">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Quick Actions</h6>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('user.withdrawals.index') }}" class="btn btn-outline-light">
                                    <em class="icon ni ni-histroy me-2"></em>View All Withdrawals
                                </a>
                                @if(!$withdrawal->isPending() && !$withdrawal->isProcessing())
                                    <a href="{{ route('user.withdrawals.create') }}" class="btn btn-primary">
                                        <em class="icon ni ni-plus me-2"></em>New Withdrawal
                                    </a>
                                @endif
                                <a href="{{ route('user.wallet.details') }}" class="btn btn-outline-primary">
                                    <em class="icon ni ni-wallet me-2"></em>View Wallet
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function cancelWithdrawal() {
    Swal.fire({
        title: 'Cancel Withdrawal Request?',
        text: "This action cannot be undone. The withdrawal request will be cancelled.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("user.withdrawals.cancel", $withdrawal->id) }}';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add method override
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Auto refresh status every 30 seconds for pending withdrawals
@if($withdrawal->isPending() || $withdrawal->isProcessing())
    setInterval(function() {
        window.location.reload();
    }, 30000);
@endif
</script>

@push('css')
<style>
.icon-circle-lg {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.media-lg .media-object {
    margin-right: 1.5rem;
}

.timeline {
    position: relative;
}

.timeline-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.timeline-item {
    position: relative;
    padding-left: 2rem;
    padding-bottom: 2rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 6px;
    top: 20px;
    bottom: -10px;
    width: 2px;
    background: #e5e9f2;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-status {
    position: absolute;
    left: 0;
    top: 0;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e5e9f2;
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

.font-monospace {
    font-family: 'Courier New', monospace;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 10px;
}

@media (max-width: 768px) {
    .timeline-item {
        padding-left: 1.5rem;
    }
    
    .icon-circle-lg {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}
</style>
@endpush

@endsection