{{-- backend.withdrawals.index --}}

@extends('admin.admin_master')
@section('title', 'Withdrawal Management')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">@yield('title')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Withdrawal Management</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">{{ $stats['total_requests'] }}</h4>
                            <p class="text-white-50 mb-0">Total Requests</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-file-list-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">{{ $stats['pending_requests'] }}</h4>
                            <p class="text-white-50 mb-0">Pending Approval</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-time-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">₦{{ number_format($stats['total_amount_pending'], 2) }}</h4>
                            <p class="text-white-50 mb-0">Pending Amount</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-money-dollar-circle-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">₦{{ number_format($stats['total_completed'], 2) }}</h4>
                            <p class="text-white-50 mb-0">Total Processed</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-check-double-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-warning w-100" onclick="showPendingApprovals()">
                                <i class="ri-notification-line me-2"></i>Pending Approvals ({{ $stats['pending_requests'] }})
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100" onclick="exportWithdrawals()">
                                <i class="ri-download-line me-2"></i>Export Report
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info w-100" onclick="refreshPendingCount()">
                                <i class="ri-refresh-line me-2"></i>Refresh Status
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.contributions.logs') }}" class="btn btn-outline-secondary w-100">
                                <i class="ri-file-list-line me-2"></i>Activity Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Withdrawals</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.withdrawals.index') }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select">
                                    <option value="">All Methods</option>
                                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-search-line me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline-secondary">
                                        <i class="ri-refresh-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdrawals Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Withdrawal Requests</h5>
                            <small class="text-muted">Manage user withdrawal requests</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">{{ $withdrawals->total() }} records</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($withdrawals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Withdrawal ID</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdrawals as $withdrawal)
                                        <tr class="{{ $withdrawal->isPending() ? 'table-warning' : '' }}">
                                            <td>
                                                <span class="font-monospace text-primary">{{ $withdrawal->withdrawal_id }}</span>
                                                @if($withdrawal->fee > 0)
                                                    <br><small class="text-muted">Fee: ₦{{ number_format($withdrawal->fee, 2) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $withdrawal->user->photo ? asset($withdrawal->user->photo) : asset('upload/no_image.jpg') }}" 
                                                         alt="User" class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium">{{ $withdrawal->user->name }}</div>
                                                        <small class="text-muted">{{ $withdrawal->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">₦{{ number_format($withdrawal->amount, 2) }}</div>
                                                @if($withdrawal->fee > 0)
                                                    <small class="text-muted">Net: ₦{{ number_format($withdrawal->net_amount, 2) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $withdrawal->payment_method_label }}</span>
                                                @if($withdrawal->payment_method === 'bank_transfer')
                                                    <br><small class="text-muted">{{ $withdrawal->bank_name }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {!! $withdrawal->status_badge !!}
                                                @if($withdrawal->approved_at)
                                                    <br><small class="text-muted">{{ $withdrawal->approved_at->format('M d, H:i') }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $withdrawal->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $withdrawal->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="viewDetails('{{ $withdrawal->id }}')">
                                                                <i class="ri-eye-line me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        @if($withdrawal->isPending())
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-success" href="#" onclick="approveWithdrawal('{{ $withdrawal->id }}')">
                                                                    <i class="ri-check-line me-2"></i>Approve
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#" onclick="rejectWithdrawal('{{ $withdrawal->id }}')">
                                                                    <i class="ri-close-line me-2"></i>Reject
                                                                </a>
                                                            </li>
                                                        @elseif($withdrawal->isApproved())
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-info" href="#" onclick="markProcessing('{{ $withdrawal->id }}')">
                                                                    <i class="ri-loader-line me-2"></i>Mark Processing
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-success" href="#" onclick="markCompleted('{{ $withdrawal->id }}')">
                                                                    <i class="ri-check-double-line me-2"></i>Mark Completed
                                                                </a>
                                                            </li>
                                                        @elseif($withdrawal->isProcessing())
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-success" href="#" onclick="markCompleted('{{ $withdrawal->id }}')">
                                                                    <i class="ri-check-double-line me-2"></i>Mark Completed
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $withdrawals->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-money-dollar-circle-line display-4 text-muted"></i>
                            <h5 class="mt-3">No withdrawal requests found</h5>
                            <p class="text-muted">No withdrawal requests match your current filter criteria</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Withdrawal Details Modal -->
<div class="modal fade" id="withdrawalDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Withdrawal Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="withdrawalDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function viewDetails(withdrawalId) {
    console.log('Loading details for withdrawal ID:', withdrawalId);
    
    $('#withdrawalDetailsContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading withdrawal details...</p>
        </div>
    `);
    
    $('#withdrawalDetailsModal').modal('show');
    
    // AJAX call to get withdrawal details
    $.ajax({
        url: `{{ url('admin/withdrawals') }}/${withdrawalId}`,
        method: 'GET',
        success: function(response) {
            console.log('Details loaded successfully');
            $('#withdrawalDetailsContent').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error loading details:', error);
            console.error('XHR:', xhr);
            
            let errorMessage = 'Failed to load withdrawal details';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Withdrawal not found';
            } else if (xhr.status === 403) {
                errorMessage = 'Access denied';
            }
            
            $('#withdrawalDetailsContent').html(`
                <div class="alert alert-danger">
                    <h6 class="alert-heading">Error</h6>
                    <p class="mb-0">${errorMessage}</p>
                    <hr>
                    <small class="text-muted">Status: ${xhr.status} - ${error}</small>
                </div>
            `);
        }
    });
}

function approveWithdrawal(withdrawalId) {
    Swal.fire({
        title: 'Approve Withdrawal?',
        html: `
            <p>This will deduct the amount from the user's wallet immediately.</p>
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
                url: `{{ url('admin/withdrawals/approve') }}/${withdrawalId}`,
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
                <textarea id="rejection-reason" class="form-control" rows="3" placeholder="Please provide a reason for rejecting this withdrawal..." required></textarea>
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
                url: `{{ url('admin/withdrawals/reject') }}/${withdrawalId}`,
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
                url: `{{ url('admin/withdrawals/process') }}/${withdrawalId}`,
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
                url: `{{ url('admin/withdrawals/complete') }}/${withdrawalId}`,
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

function showPendingApprovals() {
    window.location.href = "{{ route('admin.withdrawals.index') }}?status=pending";
}

function exportWithdrawals() {
    const params = new URLSearchParams(window.location.search);
    window.open(`{{ route('admin.withdrawals.export') }}?${params.toString()}`, '_blank');
}

function refreshPendingCount() {
    $.get('{{ route("admin.withdrawals.pending-count") }}', function(data) {
        const button = document.querySelector('.btn-warning');
        if (button) {
            button.innerHTML = `<i class="ri-notification-line me-2"></i>Pending Approvals (${data.count})`;
        }
    });
}

// Auto-refresh pending count every 30 seconds
setInterval(refreshPendingCount, 30000);

// Debug console logging
$(document).ready(function() {
    console.log('Admin withdrawal page loaded');
    console.log('Available routes:', {
        show: '{{ url("admin/withdrawals") }}',
        approve: '{{ url("admin/withdrawals/approve") }}',
        reject: '{{ url("admin/withdrawals/reject") }}'
    });
});
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
.font-size-40 {
    font-size: 40px;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 12px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.table th {
    font-weight: 600;
    font-size: 14px;
    border-bottom: 2px solid #dee2e6;
}

.rounded-circle {
    object-fit: cover;
}

.dropdown-toggle::after {
    margin-left: 0.5em;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1);
}

.display-4 {
    font-size: 2.5rem;
}

.badge.bg-light {
    color: #495057 !important;
    border: 1px solid #dee2e6;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-xl {
    max-width: 1140px;
}
</style>
@endpush

@endsection