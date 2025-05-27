@extends('admin.admin_master')
@section('title', 'Withdrawal Details')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Withdrawal Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.withdrawals.index') }}">Withdrawals</a></li>
                    <li class="breadcrumb-item active">{{ $withdrawal->withdrawal_id }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Quick Actions Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ $withdrawal->withdrawal_id }}</h5>
                            <p class="text-muted mb-0">Status: {!! $withdrawal->status_badge !!}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline-secondary">
                                <i class="ri-arrow-left-line me-2"></i>Back to List
                            </a>
                            @if($withdrawal->isPending())
                                <button type="button" class="btn btn-success" onclick="approveWithdrawal('{{ $withdrawal->id }}')">
                                    <i class="ri-check-line me-2"></i>Approve
                                </button>
                                <button type="button" class="btn btn-danger" onclick="rejectWithdrawal('{{ $withdrawal->id }}')">
                                    <i class="ri-close-line me-2"></i>Reject
                                </button>
                            @elseif($withdrawal->isApproved())
                                <button type="button" class="btn btn-info" onclick="markProcessing('{{ $withdrawal->id }}')">
                                    <i class="ri-loader-line me-2"></i>Mark Processing
                                </button>
                                <button type="button" class="btn btn-success" onclick="markCompleted('{{ $withdrawal->id }}')">
                                    <i class="ri-check-double-line me-2"></i>Complete
                                </button>
                            @elseif($withdrawal->isProcessing())
                                <button type="button" class="btn btn-success" onclick="markCompleted('{{ $withdrawal->id }}')">
                                    <i class="ri-check-double-line me-2"></i>Complete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-user-line me-2"></i>User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $withdrawal->user->photo ? asset($withdrawal->user->photo) : asset('upload/no_image.jpg') }}" 
                             alt="User" class="rounded-circle me-3" width="60" height="60">
                        <div>
                            <h6 class="mb-1">{{ $withdrawal->user->name }}</h6>
                            <p class="text-muted mb-1">{{ $withdrawal->user->email }}</p>
                            @if($withdrawal->user->phone)
                                <small class="text-muted">{{ $withdrawal->user->phone }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted">Current Wallet Balance</small>
                            <div class="fw-bold text-success h5">₦{{ number_format($withdrawal->wallet->balance, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Total Contributions</small>
                            <div class="fw-bold h5">₦{{ number_format($withdrawal->wallet->getActualTotalContributions(), 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-money-dollar-circle-line me-2"></i>Withdrawal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <small class="text-muted">Withdrawal ID</small>
                            <div class="fw-bold font-monospace h6">{{ $withdrawal->withdrawal_id }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Requested Amount</small>
                            <div class="fw-bold text-success h4">₦{{ number_format($withdrawal->amount, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Status</small>
                            <div class="mt-1">{!! $withdrawal->status_badge !!}</div>
                        </div>
                        @if($withdrawal->fee > 0)
                            <div class="col-6">
                                <small class="text-muted">Processing Fee</small>
                                <div class="fw-bold text-warning">₦{{ number_format($withdrawal->fee, 2) }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Net Amount (After Fee)</small>
                                <div class="fw-bold text-primary">₦{{ number_format($withdrawal->net_amount, 2) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Payment Details -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-bank-card-line me-2"></i>Payment Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <small class="text-muted">Payment Method</small>
                            <div class="fw-bold">
                                <span class="badge bg-{{ $withdrawal->payment_method === 'cash' ? 'success' : 'info' }} me-2">
                                    {{ $withdrawal->payment_method_label }}
                                </span>
                            </div>
                        </div>
                        @if($withdrawal->payment_method === 'bank_transfer')
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading mb-2">Bank Transfer Details</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Bank Name:</strong><br>
                                            {{ $withdrawal->bank_name }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Account Number:</strong><br>
                                            <span class="font-monospace">{{ $withdrawal->account_number }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Account Name:</strong><br>
                                            {{ $withdrawal->account_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="ri-information-line me-2"></i>
                                    <strong>Cash Payment:</strong> User will collect payment directly from admin office.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Timeline -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-time-line me-2"></i>Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Request Submitted</h6>
                                <p class="timeline-text">{{ $withdrawal->created_at->format('M d, Y g:i A') }}</p>
                                <small class="text-muted">{{ $withdrawal->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @if($withdrawal->approved_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $withdrawal->status === 'rejected' ? 'danger' : 'success' }}"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">
                                        {{ $withdrawal->status === 'rejected' ? 'Rejected' : 'Approved' }}
                                    </h6>
                                    <p class="timeline-text">{{ $withdrawal->approved_at->format('M d, Y g:i A') }}</p>
                                    <small class="text-muted">By {{ $withdrawal->approvedBy->name ?? 'System' }}</small>
                                </div>
                            </div>
                        @endif
                        @if($withdrawal->processed_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Processing Started</h6>
                                    <p class="timeline-text">{{ $withdrawal->processed_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($withdrawal->completed_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Payment Completed</h6>
                                    <p class="timeline-text">{{ $withdrawal->completed_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reason and Notes -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-chat-3-line me-2"></i>Reason & Administrative Notes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">User's Reason for Withdrawal</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $withdrawal->reason }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($withdrawal->admin_notes)
                                <h6 class="text-muted mb-2">Admin Notes</h6>
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    {{ $withdrawal->admin_notes }}
                                </div>
                            @endif
                            @if($withdrawal->rejection_reason)
                                <h6 class="text-muted mb-2">Rejection Reason</h6>
                                <div class="bg-danger bg-opacity-10 p-3 rounded">
                                    {{ $withdrawal->rejection_reason }}
                                </div>
                            @endif
                            @if(!$withdrawal->admin_notes && !$withdrawal->rejection_reason)
                                <h6 class="text-muted mb-2">Administrative Notes</h6>
                                <div class="text-muted">
                                    <em>No administrative notes yet.</em>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Balance Impact -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-pie-chart-line me-2"></i>Balance Impact Analysis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Balance Before Request</h6>
                                <h4 class="text-info">₦{{ number_format($withdrawal->wallet_balance_before, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Withdrawal Amount</h6>
                                <h4 class="text-danger">-₦{{ number_format($withdrawal->amount, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Expected Balance After</h6>
                                <h4 class="text-warning">₦{{ number_format($withdrawal->wallet_balance_before - $withdrawal->amount, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted">Current Balance</h6>
                                <h4 class="text-success">₦{{ number_format($withdrawal->wallet->balance, 2) }}</h4>
                                @if($withdrawal->isCompleted())
                                    <small class="text-muted">✓ Deducted</small>
                                @else
                                    <small class="text-warning">⚠ Not yet deducted</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Information -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-shield-check-line me-2"></i>Security & Audit Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @if($withdrawal->ip_address)
                            <div class="col-md-4">
                                <small class="text-muted">Request IP Address</small>
                                <div class="fw-bold font-monospace">{{ $withdrawal->ip_address }}</div>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <small class="text-muted">Request Date</small>
                            <div class="fw-bold">{{ $withdrawal->created_at->format('l, F j, Y') }}</div>
                            <small class="text-muted">{{ $withdrawal->created_at->format('g:i:s A') }}</small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Days Since Request</small>
                            <div class="fw-bold">{{ $withdrawal->created_at->diffInDays(now()) }} days</div>
                            <small class="text-muted">{{ $withdrawal->created_at->diffForHumans() }}</small>
                        </div>
                        @if($withdrawal->user_agent)
                            <div class="col-12">
                                <small class="text-muted">User Agent</small>
                                <div class="small text-muted bg-light p-2 rounded">{{ $withdrawal->user_agent }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Copy the same JavaScript functions from the index page
function approveWithdrawal(withdrawalId) {
    Swal.fire({
        title: 'Approve Withdrawal?',
        html: `
            <p>This will deduct ₦{{ number_format($withdrawal->amount, 2) }} from the user's wallet immediately.</p>
            <div class="form-group mt-3">
                <label>Admin Notes (Optional):</label>
                <textarea id="admin-notes" class="form-control" rows="3" placeholder="Add any notes about this approval..."></textarea>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, approve it!',
        preConfirm: () => {
            return document.getElementById('admin-notes').value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('admin.withdrawals.approve', ':id') }}`.replace(':id', withdrawalId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    admin_notes: result.value
                },
                success: function(response) {
                    Swal.fire(
                        'Approved!',
                        'The withdrawal has been approved successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON?.error || 'Failed to approve withdrawal',
                        'error'
                    );
                }
            });
        }
    });
}

function rejectWithdrawal(withdrawalId) {
    Swal.fire({
        title: 'Reject Withdrawal?',
        html: `
            <div class="form-group">
                <label>Reason for rejection <span class="text-danger">*</span>:</label>
                <textarea id="rejection-reason" class="form-control" rows="3" placeholder="Please provide a detailed reason for rejecting this withdrawal..." required></textarea>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Reject',
        preConfirm: () => {
            const reason = document.getElementById('rejection-reason').value;
            if (!reason) {
                Swal.showValidationMessage('You need to provide a reason for rejection!');
            }
            return reason;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('admin.withdrawals.reject', ':id') }}`.replace(':id', withdrawalId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rejection_reason: result.value
                },
                success: function(response) {
                    Swal.fire(
                        'Rejected!',
                        'The withdrawal has been rejected.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON?.error || 'Failed to reject withdrawal',
                        'error'
                    );
                }
            });
        }
    });
}

function markProcessing(withdrawalId) {
    Swal.fire({
        title: 'Mark as Processing?',
        text: "This will update the status to indicate payment is being processed.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#17a2b8',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, mark as processing!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('admin.withdrawals.process', ':id') }}`.replace(':id', withdrawalId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Updated!',
                        'Withdrawal marked as processing.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON?.error || 'Failed to update status',
                        'error'
                    );
                }
            });
        }
    });
}

function markCompleted(withdrawalId) {
    Swal.fire({
        title: 'Mark as Completed?',
        text: "This confirms that the payment has been successfully delivered to the user.",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, mark as completed!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ route('admin.withdrawals.complete', ':id') }}`.replace(':id', withdrawalId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Completed!',
                        'Withdrawal marked as completed successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON?.error || 'Failed to complete withdrawal',
                        'error'
                    );
                }
            });
        }
    });
}
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -2.5rem;
    top: 0.5rem;
    width: 2px;
    height: calc(100% - 0.5rem);
    background-color: #dee2e6;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -3rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.timeline-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.font-monospace {
    font-family: 'Courier New', monospace;
}

.rounded-circle {
    object-fit: cover;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
@endpush

@endsection