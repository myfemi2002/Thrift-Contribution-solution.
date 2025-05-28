@extends('admin.admin_master')
@section('title', 'Loan Management')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">@yield('title')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Loan Management</li>
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
                            <h4 class="text-white mb-1">{{ $stats['total_loans'] }}</h4>
                            <p class="text-white-50 mb-0">Total Loans</p>
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
                            <h4 class="text-white mb-1">{{ $stats['pending_loans'] }}</h4>
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
                            <h4 class="text-white mb-1">{{ $stats['active_loans'] }}</h4>
                            <p class="text-white-50 mb-0">Active Loans</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-check-line font-size-40"></i>
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
                            <h4 class="text-white mb-1">{{ $stats['overdue_loans'] }}</h4>
                            <p class="text-white-50 mb-0">Overdue Loans</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-alert-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">💰 Financial Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mt-3">
                                <h4 class="text-success">₦{{ number_format($stats['total_disbursed'], 2) }}</h4>
                                <p class="text-muted mb-0">Total Disbursed</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3">
                                <h4 class="text-warning">₦{{ number_format($stats['total_outstanding'], 2) }}</h4>
                                <p class="text-muted mb-0">Total Outstanding</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">🎯 Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-warning w-100" onclick="showPendingLoans()">
                                <i class="ri-notification-line me-2"></i>Pending ({{ $stats['pending_loans'] }})
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="showOverdueLoans()">
                                <i class="ri-alert-line me-2"></i>Overdue ({{ $stats['overdue_loans'] }})
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-success w-100" onclick="exportLoans()">
                                <i class="ri-download-line me-2"></i>Export Report
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-info w-100" onclick="checkOverdueLoans()">
                                <i class="ri-refresh-line me-2"></i>Check Overdue
                            </button>
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
                    <h5 class="card-title mb-0">🔍 Filter Loans</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.loans.index') }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="disbursed" {{ request('status') == 'disbursed' ? 'selected' : '' }}>Disbursed</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Name, Email, Loan ID..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>                                
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-search"></em>
                                        <span>Filter</span>
                                    </button>
                                    <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary ms-2">
                                        <em class="icon ni ni-reload"></em>
                                        <span>Reset</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loans Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Loan Applications</h5>
                            <small class="text-muted">All loan applications and their status</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">{{ $loans->total() }} records</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($loans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                        </th>
                                        <th>Loan ID</th>
                                        <th>Borrower</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Interest Rate</th>
                                        <th>Outstanding</th>
                                        <th>Due Date</th>
                                        <th>Applied Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="loan-checkbox" value="{{ $loan->id }}">
                                            </td>
                                            <td>
                                                <span class="font-monospace text-primary">{{ $loan->loan_id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $loan->user->photo ? asset($loan->user->photo) : asset('upload/no_image.jpg') }}" 
                                                         alt="User" class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium">{{ $loan->user->name }}</div>
                                                        <small class="text-muted">{{ $loan->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">{{ $loan->formatted_amount }}</div>
                                                <small class="text-muted">Total: {{ $loan->formatted_total_amount }}</small>
                                            </td>
                                            <td>
                                                {!! $loan->status_badge !!}
                                                @if($loan->credit_rating)
                                                    <div class="mt-1">{!! $loan->credit_rating_badge !!}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $loan->interest_rate }}%</span>
                                                @if($loan->interest_overridden)
                                                    <span class="badge bg-info badge-sm">Custom</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }}">
                                                    {{ $loan->formatted_outstanding_balance }}
                                                </span>
                                                @if($loan->outstanding_balance > 0)
                                                    <div class="progress mt-1" style="height: 3px;">
                                                        <div class="progress-bar bg-success" style="width: {{ $loan->repayment_progress }}%"></div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($loan->due_date)
                                                    <div class="{{ $loan->is_overdue ? 'text-danger' : ($loan->days_until_due <= 5 ? 'text-warning' : '') }}">
                                                        {{ $loan->due_date->format('M d, Y') }}
                                                    </div>
                                                    @if($loan->days_until_due !== null)
                                                        <small class="text-muted">
                                                            @if($loan->is_overdue)
                                                                {{ abs($loan->days_until_due) }} days overdue
                                                            @else
                                                                {{ $loan->days_until_due }} days left
                                                            @endif
                                                        </small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Not set</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $loan->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $loan->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.loans.show', $loan->id) }}">
                                                                <i class="ri-eye-line me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        @if($loan->status === 'pending')
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-success" href="#" onclick="approveLoan('{{ $loan->id }}')">
                                                                    <i class="ri-check-line me-2"></i>Approve
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#" onclick="rejectLoan('{{ $loan->id }}')">
                                                                    <i class="ri-close-line me-2"></i>Reject
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if($loan->status === 'approved')
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-primary" href="#" onclick="disburseLoan('{{ $loan->id }}')">
                                                                    <i class="ri-wallet-line me-2"></i>Disburse
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if(in_array($loan->status, ['disbursed', 'active', 'overdue']))
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-info" href="{{ route('admin.loans.repayment', $loan->id) }}">
                                                                    <i class="ri-money-dollar-circle-line me-2"></i>Record Repayment
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if($loan->status === 'pending' || $loan->status === 'approved')
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" onclick="editInterestRate('{{ $loan->id }}', '{{ $loan->interest_rate }}')">
                                                                    <i class="ri-percent-line me-2"></i>Edit Interest Rate
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

                        <!-- Bulk Actions -->
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="bulk-actions d-none">
                                        <button type="button" class="btn btn-success btn-sm" onclick="bulkApprove()">
                                            <i class="ri-check-line me-1"></i>Bulk Approve
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm ms-2" onclick="bulkReject()">
                                            <i class="ri-close-line me-1"></i>Bulk Reject
                                        </button>
                                        <span class="ms-3 text-muted" id="selectedCount">0 selected</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    {{ $loans->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-file-list-line display-4 text-muted"></i>
                            <h5 class="mt-3">No loans found</h5>
                            <p class="text-muted">No loan applications match your current filter criteria</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Loan Modal -->
<div class="modal fade" id="approveLoanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="approveLoanForm">
                    <!-- <div class="mb-3">
                        <label class="form-label">Custom Interest Rate (%)</label>
                        <input type="number" class="form-control" id="customInterestRate" 
                               placeholder="Leave empty to use default rate" min="0" max="50" step="0.1">
                        <small class="text-muted">Override the default interest rate for this loan</small>
                    </div> -->
                    <div class="mb-3">
                        <label class="form-label">Admin Notes</label>
                        <textarea class="form-control" id="adminNotes" rows="3" 
                                  placeholder="Optional notes about the approval..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="confirmApproveLoan()">
                    <i class="ri-check-line me-2"></i>Approve Loan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Loan Modal -->
<div class="modal fade" id="rejectLoanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="rejectLoanForm">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectionReason" rows="4" 
                                  placeholder="Please provide a clear reason for rejection..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmRejectLoan()">
                    <i class="ri-close-line me-2"></i>Reject Loan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Interest Rate Modal -->
<div class="modal fade" id="editInterestRateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Interest Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editInterestRateForm">
                    <div class="mb-3">
                        <label class="form-label">Interest Rate (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="newInterestRate" 
                               min="0" max="50" step="0.1" required>
                        <small class="text-muted">Enter the new interest rate for this loan</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmEditInterestRate()">
                    <i class="ri-save-line me-2"></i>Update Rate
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let currentLoanId = null;

// Checkbox functionality
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.loan-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.loan-checkbox:checked');
    const bulkActions = document.querySelector('.bulk-actions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (checkboxes.length > 0) {
        bulkActions.classList.remove('d-none');
        selectedCount.textContent = `${checkboxes.length} selected`;
    } else {
        bulkActions.classList.add('d-none');
    }
}

// Add event listeners to checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.loan-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});

// Loan Actions
function approveLoan(loanId) {
    currentLoanId = loanId;
    $('#approveLoanModal').modal('show');
}

function confirmApproveLoan() {
    const customRate = $('#customInterestRate').val();
    const notes = $('#adminNotes').val();
    
    $.ajax({
        url: `{{ url('admin/loans') }}/${currentLoanId}/approve`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            custom_interest_rate: customRate,
            admin_notes: notes
        },
        success: function(response) {
            $('#approveLoanModal').modal('hide');
            Swal.fire('Success!', response.message, 'success').then(() => {
                window.location.reload();
            });
        },
        error: function(xhr) {
            Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to approve loan', 'error');
        }
    });
}

function rejectLoan(loanId) {
    currentLoanId = loanId;
    $('#rejectLoanModal').modal('show');
}

function confirmRejectLoan() {
    const reason = $('#rejectionReason').val();
    
    if (!reason.trim()) {
        Swal.fire('Error!', 'Please provide a rejection reason', 'error');
        return;
    }
    
    $.ajax({
        url: `{{ url('admin/loans') }}/${currentLoanId}/reject`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            rejection_reason: reason
        },
        success: function(response) {
            $('#rejectLoanModal').modal('hide');
            Swal.fire('Success!', response.message, 'success').then(() => {
                window.location.reload();
            });
        },
        error: function(xhr) {
            Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to reject loan', 'error');
        }
    });
}

function disburseLoan(loanId) {
    Swal.fire({
        title: 'Disburse Loan?',
        text: 'This will credit the loan amount to the user\'s loan wallet immediately.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, disburse it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('admin/loans') }}/${loanId}/disburse`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Disbursed!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to disburse loan', 'error');
                }
            });
        }
    });
}

function editInterestRate(loanId, currentRate) {
    currentLoanId = loanId;
    $('#newInterestRate').val(currentRate);
    $('#editInterestRateModal').modal('show');
}

function confirmEditInterestRate() {
    const newRate = $('#newInterestRate').val();
    
    if (!newRate || newRate < 0 || newRate > 50) {
        Swal.fire('Error!', 'Please enter a valid interest rate (0-50%)', 'error');
        return;
    }
    
    $.ajax({
        url: `{{ url('admin/loans') }}/${currentLoanId}/interest-rate`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            interest_rate: newRate
        },
        success: function(response) {
            $('#editInterestRateModal').modal('hide');
            Swal.fire('Success!', response.message, 'success').then(() => {
                window.location.reload();
            });
        },
        error: function(xhr) {
            Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to update interest rate', 'error');
        }
    });
}

// Quick Actions
function showPendingLoans() {
    window.location.href = "{{ route('admin.loans.index') }}?status=pending";
}

function showOverdueLoans() {
    window.location.href = "{{ route('admin.loans.index') }}?status=overdue";
}

function exportLoans() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'true');
    window.open(`{{ route('admin.loans.export') }}?${params.toString()}`, '_blank');
}

function checkOverdueLoans() {
    Swal.fire({
        title: 'Checking Overdue Loans...',
        text: 'Please wait while we check for overdue loans',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: '{{ route("admin.loans.check-overdue") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            Swal.fire('Success!', response.message, 'success').then(() => {
                window.location.reload();
            });
        },
        error: function() {
            Swal.fire('Error!', 'Failed to check overdue loans', 'error');
        }
    });
}

// Bulk Actions
function bulkApprove() {
    const selectedLoans = Array.from(document.querySelectorAll('.loan-checkbox:checked')).map(cb => cb.value);
    
    if (selectedLoans.length === 0) {
        Swal.fire('Error!', 'Please select loans to approve', 'error');
        return;
    }
    
    Swal.fire({
        title: 'Bulk Approve Loans?',
        text: `This will approve ${selectedLoans.length} selected loans`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, approve them!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.loans.bulk-approve") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    loan_ids: selectedLoans
                },
                success: function(response) {
                    Swal.fire('Success!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to bulk approve loans', 'error');
                }
            });
        }
    });
}

function bulkReject() {
    const selectedLoans = Array.from(document.querySelectorAll('.loan-checkbox:checked')).map(cb => cb.value);
    
    if (selectedLoans.length === 0) {
        Swal.fire('Error!', 'Please select loans to reject', 'error');
        return;
    }
    
    Swal.fire({
        title: 'Bulk Reject Loans?',
        input: 'textarea',
        inputLabel: 'Rejection reason',
        inputPlaceholder: 'Enter reason for rejecting these loans...',
        inputAttributes: {
            'aria-label': 'Rejection reason'
        },
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Reject All',
        inputValidator: (value) => {
            if (!value) {
                return 'You need to provide a rejection reason!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementation for bulk reject would go here
            Swal.fire('Info', 'Bulk reject functionality would be implemented here', 'info');
        }
    });
}
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

.progress {
    background-color: #e9ecef;
}

.display-4 {
    font-size: 2.5rem;
}

.bulk-actions {
    display: flex;
    align-items: center;
}

.badge-sm {
    font-size: 0.75em;
}
</style>
@endpush

@endsection