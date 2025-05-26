@extends('admin.admin_master')
@section('title', 'Wallet Adjustments')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">@yield('title')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Wallet Adjustments</li>
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
                            <h4 class="text-white mb-1">{{ $stats['total_adjustments'] }}</h4>
                            <p class="text-white-50 mb-0">Total Adjustments</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-settings-line font-size-40"></i>
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
                            <h4 class="text-white mb-1">{{ $stats['pending_adjustments'] }}</h4>
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
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">₦{{ number_format($stats['total_credits'], 2) }}</h4>
                            <p class="text-white-50 mb-0">Total Credits</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-arrow-up-circle-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">₦{{ number_format($stats['total_debits'], 2) }}</h4>
                            <p class="text-white-50 mb-0">Total Debits</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-arrow-down-circle-line font-size-40"></i>
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
                            <a href="{{ route('admin.wallet-adjustments.create') }}" class="btn btn-primary w-100">
                                <i class="ri-add-line me-2"></i>New Adjustment
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-warning w-100" onclick="showPendingApprovals()">
                                <i class="ri-notification-line me-2"></i>Pending Approvals ({{ $stats['pending_adjustments'] }})
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100" onclick="exportAdjustments()">
                                <i class="ri-download-line me-2"></i>Export Report
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.contributions.logs') }}" class="btn btn-outline-info w-100">
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
                    <h5 class="card-title mb-0">Filter Adjustments</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.wallet-adjustments.index') }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debit</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Reason</label>
                                <select name="reason" class="form-select">
                                    <option value="">All Reasons</option>
                                    <option value="omitted_contribution" {{ request('reason') == 'omitted_contribution' ? 'selected' : '' }}>Omitted Contribution</option>
                                    <option value="correction_error" {{ request('reason') == 'correction_error' ? 'selected' : '' }}>Correction Error</option>
                                    <option value="duplicate_payment" {{ request('reason') == 'duplicate_payment' ? 'selected' : '' }}>Duplicate Payment</option>
                                    <option value="admin_adjustment" {{ request('reason') == 'admin_adjustment' ? 'selected' : '' }}>Admin Adjustment</option>
                                    <option value="other" {{ request('reason') == 'other' ? 'selected' : '' }}>Other</option>
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
                                    <a href="{{ route('admin.wallet-adjustments.index') }}" class="btn btn-outline-secondary">
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

    <!-- Adjustments Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Wallet Adjustments</h5>
                            <small class="text-muted">All wallet credit and debit transactions</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">{{ $adjustments->total() }} records</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($adjustments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Adjustment ID</th>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Admin</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($adjustments as $adjustment)
                                        <tr>
                                            <td>
                                                <span class="font-monospace text-primary">{{ $adjustment->adjustment_id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $adjustment->user->photo ? asset($adjustment->user->photo) : asset('upload/no_image.jpg') }}" 
                                                         alt="User" class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium">{{ $adjustment->user->name }}</div>
                                                        <small class="text-muted">{{ $adjustment->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {!! $adjustment->type_badge !!}
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $adjustment->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                                    {{ $adjustment->formatted_amount }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $adjustment->reason_label }}</span>
                                            </td>
                                            <td>
                                                {!! $adjustment->status_badge !!}
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $adjustment->admin->name }}</div>
                                                <small class="text-muted">{{ $adjustment->created_at->format('H:i A') }}</small>
                                            </td>
                                            <td>
                                                <div>{{ $adjustment->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $adjustment->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="viewDetails('{{ $adjustment->id }}')">
                                                                <i class="ri-eye-line me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        @if($adjustment->status === 'pending')
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-success" href="#" onclick="approveAdjustment('{{ $adjustment->id }}')">
                                                                    <i class="ri-check-line me-2"></i>Approve
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#" onclick="rejectAdjustment('{{ $adjustment->id }}')">
                                                                    <i class="ri-close-line me-2"></i>Reject
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.wallet-adjustments.user-history', $adjustment->user_id) }}">
                                                                <i class="ri-history-line me-2"></i>User History
                                                            </a>
                                                        </li>
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
                            {{ $adjustments->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-settings-line display-4 text-muted"></i>
                            <h5 class="mt-3">No adjustments found</h5>
                            <p class="text-muted">No wallet adjustments match your current filter criteria</p>
                            <a href="{{ route('admin.wallet-adjustments.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Create First Adjustment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adjustment Details Modal -->
<div class="modal fade" id="adjustmentDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adjustment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="adjustmentDetailsContent">
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
function viewDetails(adjustmentId) {
    $('#adjustmentDetailsContent').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading adjustment details...</p>
        </div>
    `);
    
    $('#adjustmentDetailsModal').modal('show');
    
    // Simulate loading details (replace with actual AJAX call)
    setTimeout(function() {
        $('#adjustmentDetailsContent').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6>Adjustment Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Adjustment ID:</strong></td><td class="font-monospace">ADJ-${adjustmentId}</td></tr>
                        <tr><td><strong>Type:</strong></td><td><span class="badge bg-success">Credit</span></td></tr>
                        <tr><td><strong>Amount:</strong></td><td class="text-success fw-bold">+₦1,000.00</td></tr>
                        <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Completed</span></td></tr>
                        <tr><td><strong>Reason:</strong></td><td>Omitted Contribution</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>User Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Name:</strong></td><td>John Doe</td></tr>
                        <tr><td><strong>Email:</strong></td><td>john@example.com</td></tr>
                        <tr><td><strong>Balance Before:</strong></td><td>₦5,000.00</td></tr>
                        <tr><td><strong>Balance After:</strong></td><td>₦6,000.00</td></tr>
                    </table>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Description</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">User missed contribution for May 15, 2025. Adding missed amount to wallet as requested.</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <h6>Admin Details</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Processed By:</strong></td><td>Admin User</td></tr>
                        <tr><td><strong>Date:</strong></td><td>${new Date().toLocaleString()}</td></tr>
                        <tr><td><strong>IP Address:</strong></td><td class="font-monospace">192.168.1.1</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Reference</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Reference Number:</strong></td><td>REF-001</td></tr>
                        <tr><td><strong>Reference Date:</strong></td><td>May 15, 2025</td></tr>
                        <tr><td><strong>Approval Required:</strong></td><td>No</td></tr>
                    </table>
                </div>
            </div>
        `);
    }, 1000);
}

function approveAdjustment(adjustmentId) {
    Swal.fire({
        title: 'Approve Adjustment?',
        text: "This will update the user's wallet balance immediately.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, approve it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('wallet-adjustments/approve') }}/${adjustmentId}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Approved!',
                        'The adjustment has been approved successfully.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON?.error || 'Failed to approve adjustment',
                        'error'
                    );
                }
            });
        }
    });
}

function rejectAdjustment(adjustmentId) {
    Swal.fire({
        title: 'Reject Adjustment?',
        input: 'textarea',
        inputLabel: 'Reason for rejection',
        inputPlaceholder: 'Enter reason for rejecting this adjustment...',
        inputAttributes: {
            'aria-label': 'Reason for rejection'
        },
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Reject',
        inputValidator: (value) => {
            if (!value) {
                return 'You need to provide a reason for rejection!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('wallet-adjustments/reject') }}/${adjustmentId}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    reason: result.value
                },
                success: function(response) {
                    Swal.fire(
                        'Rejected!',
                        'The adjustment has been rejected.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON?.error || 'Failed to reject adjustment',
                        'error'
                    );
                }
            });
        }
    });
}

function showPendingApprovals() {
    window.location.href = "{{ route('admin.wallet-adjustments.index') }}?status=pending";
}

function exportAdjustments() {
    Swal.fire({
        title: 'Export Adjustments',
        text: 'Choose export format:',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'Excel',
        denyButtonText: 'PDF',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Get current filter parameters
            const params = new URLSearchParams(window.location.search);
            params.set('format', 'excel');
            window.open(`{{ route('admin.wallet-adjustments.export') }}?${params.toString()}`, '_blank');
        } else if (result.isDenied) {
            // Get current filter parameters
            const params = new URLSearchParams(window.location.search);
            params.set('format', 'pdf');
            window.open(`{{ route('admin.wallet-adjustments.export') }}?${params.toString()}`, '_blank');
        }
    });
}

// Auto-refresh pending count every 30 seconds
setInterval(function() {
    // Only refresh if on the main adjustments page
    if (window.location.pathname.includes('/wallet-adjustments') && !window.location.search.includes('status=')) {
        const badge = document.querySelector('.badge.bg-info');
        if (badge) {
            badge.classList.add('pulse');
            setTimeout(() => badge.classList.remove('pulse'), 1000);
        }
    }
}, 30000);
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
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
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
    
    .pulse {
        animation: pulse 1s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .badge.bg-light {
        color: #495057 !important;
        border: 1px solid #dee2e6;
    }
</style>
@endpush

@endsection