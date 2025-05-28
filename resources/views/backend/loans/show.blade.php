{{-- backend.loans.show --}}

@extends('admin.admin_master')
@section('title', 'Loan Details')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">@yield('title')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.loans.index') }}">Loan Management</a></li>
                    <li class="breadcrumb-item active">Loan Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Loan Overview -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">💳 Loan Overview</h5>
                            <small class="text-muted">Complete loan information and status</small>
                        </div>
                        <div class="col-auto">
                            {!! $loan->status_badge !!}
                            @if($loan->credit_rating)
                                {!! $loan->credit_rating_badge !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="info-list">
                                <div class="info-item">
                                    <label>Loan ID:</label>
                                    <span class="value">
                                        <code>{{ $loan->loan_id }}</code>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyText('{{ $loan->loan_id }}')">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <label>Principal Amount:</label>
                                    <span class="value text-success fw-bold">{{ $loan->formatted_amount }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Interest Rate:</label>
                                    <span class="value">
                                        {{ $loan->interest_rate }}%
                                        @if($loan->interest_overridden)
                                            <span class="badge bg-info badge-sm ms-1">Custom Rate</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <label>Interest Amount:</label>
                                    <span class="value">₦{{ number_format($loan->interest_amount, 2) }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Duration:</label>
                                    <span class="value">{{ $loan->duration_days }} days</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="info-list">
                                <div class="info-item">
                                    <label>Total Amount:</label>
                                    <span class="value text-primary fw-bold">{{ $loan->formatted_total_amount }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Amount Paid:</label>
                                    <span class="value text-success">{{ $loan->formatted_amount_paid }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Outstanding Balance:</label>
                                    <span class="value {{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }} fw-bold">
                                        {{ $loan->formatted_outstanding_balance }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <label>Repayment Progress:</label>
                                    <span class="value">
                                        <div class="progress mb-1" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: {{ $loan->repayment_progress }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($loan->repayment_progress, 1) }}% Complete</small>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <label>Loan Wallet Balance:</label>
                                    <span class="value">{{ $loan->loanWallet->formatted_balance }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrower Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">👤 Borrower Information</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="{{ $loan->user->photo ? asset($loan->user->photo) : asset('upload/no_image.jpg') }}" 
                                 alt="User Photo" class="img-thumbnail rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Full Name:</label>
                                        <span class="value fw-medium">{{ $loan->user->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Email Address:</label>
                                        <span class="value">{{ $loan->user->email }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Phone Number:</label>
                                        <span class="value">{{ $loan->user->phone ?? 'Not provided' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>User Status:</label>
                                        <span class="value">
                                            <span class="badge bg-{{ $loan->user->status === 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($loan->user->status) }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <label>Member Since:</label>
                                        <span class="value">{{ $loan->user->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Total Loans:</label>
                                        <span class="value">{{ $loan->user->loans()->count() }} loans</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Timeline -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">⏰ Loan Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="timeline-card">
                                <div class="timeline-title">Application Date</div>
                                <div class="timeline-value">{{ $loan->created_at->format('M d, Y g:i A') }}</div>
                                <div class="timeline-note">{{ $loan->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @if($loan->approved_at)
                            <div class="col-md-6">
                                <div class="timeline-card success">
                                    <div class="timeline-title">Approval Date</div>
                                    <div class="timeline-value">{{ $loan->approved_at->format('M d, Y g:i A') }}</div>
                                    <div class="timeline-note">By {{ $loan->approvedBy->name ?? 'System' }}</div>
                                </div>
                            </div>
                        @endif
                        @if($loan->disbursed_at)
                            <div class="col-md-6">
                                <div class="timeline-card primary">
                                    <div class="timeline-title">Disbursement Date</div>
                                    <div class="timeline-value">{{ $loan->disbursed_at->format('M d, Y g:i A') }}</div>
                                    <div class="timeline-note">{{ $loan->disbursed_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif
                        @if($loan->repayment_start_date)
                            <div class="col-md-6">
                                <div class="timeline-card info">
                                    <div class="timeline-title">Repayment Start Date</div>
                                    <div class="timeline-value">{{ Carbon\Carbon::parse($loan->repayment_start_date)->format('M d, Y') }}</div>
                                    <div class="timeline-note">
                                        @if(Carbon\Carbon::parse($loan->repayment_start_date)->isFuture())
                                            Starts {{ Carbon\Carbon::parse($loan->repayment_start_date)->diffForHumans() }}
                                        @else
                                            Started {{ Carbon\Carbon::parse($loan->repayment_start_date)->diffForHumans() }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($loan->due_date)
                            <div class="col-md-6">
                                <div class="timeline-card {{ $loan->is_overdue ? 'danger' : ($loan->days_until_due <= 5 ? 'warning' : 'info') }}">
                                    <div class="timeline-title">Due Date</div>
                                    <div class="timeline-value">{{ $loan->due_date->format('M d, Y') }}</div>
                                    <div class="timeline-note">
                                        @if($loan->days_until_due !== null)
                                            @if($loan->is_overdue)
                                                <span class="text-danger">{{ abs($loan->days_until_due) }} days overdue</span>
                                            @else
                                                <span>{{ $loan->days_until_due }} days remaining</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($loan->completed_at)
                            <div class="col-md-6">
                                <div class="timeline-card success">
                                    <div class="timeline-title">Completion Date</div>
                                    <div class="timeline-value">{{ $loan->completed_at->format('M d, Y g:i A') }}</div>
                                    <div class="timeline-note">{{ $loan->completed_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Loan Purpose -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">📝 Loan Purpose</h5>
                </div>
                <div class="card-body">
                    <div class="purpose-content">
                        <p class="mb-0">{{ $loan->purpose }}</p>
                    </div>
                </div>
            </div>

            <!-- Admin Notes / Rejection Reason -->
            @if($loan->admin_notes || $loan->rejection_reason)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @if($loan->status === 'rejected')
                                🚫 Rejection Details
                            @else
                                📋 Admin Notes
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-{{ $loan->status === 'rejected' ? 'danger' : 'info' }}">
                            @if($loan->rejection_reason)
                                <h6 class="alert-heading">Reason for Rejection:</h6>
                                <p class="mb-0">{{ $loan->rejection_reason }}</p>
                            @endif
                            @if($loan->admin_notes)
                                @if($loan->rejection_reason)
                                    <hr>
                                    <h6>Admin Notes:</h6>
                                @endif
                                <p class="mb-0">{{ $loan->admin_notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Repayment History -->
            @if($loan->repayments->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="card-title mb-0">💳 Repayment History</h5>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-info">{{ $loan->repayments->count() }} payments</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Outstanding After</th>
                                        <th>Reference</th>
                                        <th>Recorded By</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan->repayments->sortByDesc('payment_date') as $repayment)
                                        <tr>
                                            <td>
                                                <div>{{ $repayment->payment_date->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $repayment->created_at->format('g:i A') }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">{{ $repayment->formatted_amount }}</span>
                                            </td>
                                            <td>{{ $repayment->payment_method_display }}</td>
                                            <td>
                                                <span class="{{ $repayment->outstanding_after > 0 ? 'text-warning' : 'text-success' }}">
                                                    {{ $repayment->formatted_outstanding_after }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($repayment->reference_number)
                                                    <code>{{ $repayment->reference_number }}</code>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $repayment->recordedBy->name ?? 'System' }}</td>
                                            <td>
                                                @if($repayment->notes)
                                                    <span data-bs-toggle="tooltip" title="{{ $repayment->notes }}">
                                                        {{ Str::limit($repayment->notes, 20) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">⚡ Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($loan->status === 'pending')
                            <button type="button" class="btn btn-success" onclick="approveLoan('{{ $loan->id }}')">
                                <i class="ri-check-line me-2"></i>Approve Loan
                            </button>
                            <button type="button" class="btn btn-danger" onclick="rejectLoan('{{ $loan->id }}')">
                                <i class="ri-close-line me-2"></i>Reject Loan
                            </button>
                        @endif
                        
                        @if($loan->status === 'approved')
                            <button type="button" class="btn btn-primary" onclick="disburseLoan('{{ $loan->id }}')">
                                <i class="ri-wallet-line me-2"></i>Disburse Loan
                            </button>
                        @endif
                        
                        @if(in_array($loan->status, ['disbursed', 'active', 'overdue']))
                            <a href="{{ route('admin.loans.repayment', $loan->id) }}" class="btn btn-info">
                                <i class="ri-money-dollar-circle-line me-2"></i>Record Repayment
                            </a>
                        @endif
                        
                        @if($loan->status === 'pending' || $loan->status === 'approved')
                            <button type="button" class="btn btn-warning" onclick="editInterestRate('{{ $loan->id }}', '{{ $loan->interest_rate }}')">
                                <i class="ri-percent-line me-2"></i>Edit Interest Rate
                            </button>
                        @endif
                        
                        <a href="{{ route('admin.loans.wallet', $loan->user_id) }}" class="btn btn-outline-secondary">
                            <i class="ri-wallet-3-line me-2"></i>View User Wallet
                        </a>
                        
                        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-primary">
                            <i class="ri-arrow-left-line me-2"></i>Back to Loans
                        </a>
                    </div>
                </div>
            </div>

            <!-- Loan Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">📊 Loan Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Principal:</span>
                            <strong class="text-success">{{ $loan->formatted_amount }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Interest ({{ $loan->interest_rate }}%):</span>
                            <strong>₦{{ number_format($loan->interest_amount, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 border-bottom-2">
                            <span>Total Amount:</span>
                            <strong class="text-primary">{{ $loan->formatted_total_amount }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Amount Paid:</span>
                            <strong class="text-success">{{ $loan->formatted_amount_paid }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Outstanding:</span>
                            <strong class="{{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }}">
                                {{ $loan->formatted_outstanding_balance }}
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Credit Rating -->
            @if($loan->credit_rating || $loan->status === 'completed')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">🏆 Credit Rating</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($loan->credit_rating)
                            {!! $loan->credit_rating_badge !!}
                            <h5 class="mt-2">{{ $loan->credit_rating }}</h5>
                            <p class="text-muted mb-0">
                                @switch($loan->credit_rating)
                                    @case('Gold Saver')
                                        Qualifies for 7.5% interest rate
                                        @break
                                    @case('Silver Saver')
                                        Qualifies for 8.5% interest rate
                                        @break
                                    @case('Bronze Saver')
                                        Qualifies for 10% interest rate
                                        @break
                                @endswitch
                            </p>
                        @else
                            <em class="icon ri-trophy-line" style="font-size: 3rem; color: #ddd;"></em>
                            <p class="text-muted mt-2 mb-0">Credit rating will be assigned upon completion</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Loan Metadata -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">🔍 Loan Metadata</h5>
                </div>
                <div class="card-body">
                    <div class="metadata-list">
                        <div class="metadata-item">
                            <small class="text-muted">Created:</small>
                            <span>{{ $loan->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="metadata-item">
                            <small class="text-muted">Updated:</small>
                            <span>{{ $loan->updated_at->format('M d, Y g:i A') }}</span>
                        </div>
                        @if($loan->metadata)
                            <div class="metadata-item">
                                <small class="text-muted">Additional Info:</small>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" data-bs-target="#metadataCollapse">
                                    View Details
                                </button>
                                <div class="collapse mt-2" id="metadataCollapse">
                                    <pre class="bg-light p-2 rounded"><code>{{ json_encode($loan->metadata, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the same modals from the admin loans index view -->
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
                    <div class="mb-3">
                        <label class="form-label">Custom Interest Rate (%)</label>
                        <input type="number" class="form-control" id="customInterestRate" 
                               placeholder="Leave empty to use default rate" min="0" max="50" step="0.1">
                        <small class="text-muted">Override the default interest rate for this loan</small>
                    </div>
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
let currentLoanId = {{ $loan->id }};

// Copy text functionality
function copyText(text) {
    navigator.clipboard.writeText(text).then(function() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Copied to clipboard',
            showConfirmButton: false,
            timer: 2000
        });
    });
}

// Loan Actions (same as in index view)
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

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f5f6fa;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item label {
    font-size: 0.875rem;
    color: #8094ae;
    font-weight: 500;
    margin-bottom: 0;
    min-width: 140px;
}

.info-item .value {
    font-weight: 600;
    color: #364a63;
    text-align: right;
}

.timeline-card {
    text-align: center;
    padding: 1rem;
    border: 2px solid #e3e7fe;
    border-radius: 8px;
    background: #f8f9ff;
    transition: all 0.3s ease;
}

.timeline-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.timeline-card.success {
    border-color: #28a745;
    background-color: #d4edda;
}

.timeline-card.primary {
    border-color: #007bff;
    background-color: #cce7ff;
}

.timeline-card.info {
    border-color: #17a2b8;
    background-color: #d1ecf1;
}

.timeline-card.warning {
    border-color: #ffc107;
    background-color: #fff3cd;
}

.timeline-card.danger {
    border-color: #dc3545;
    background-color: #f8d7da;
}

.timeline-title {
    font-size: 0.875rem;
    color: #8094ae;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.timeline-value {
    font-size: 1rem;
    font-weight: 600;
    color: #364a63;
    margin-bottom: 0.25rem;
}

.timeline-note {
    font-size: 0.75rem;
    color: #8094ae;
}

.purpose-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.metadata-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.metadata-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f5f6fa;
}

.metadata-item:last-child {
    border-bottom: none;
}

.progress {
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
}

.progress-bar {
    border-radius: 4px;
}

.list-group-item {
    border: none;
    padding: 0.75rem 0;
}

.border-bottom-2 {
    border-bottom: 2px solid #dee2e6 !important;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 10px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.table th {
    font-weight: 600;
    font-size: 14px;
    border-bottom: 2px solid #dee2e6;
}

.img-thumbnail {
    border: 2px solid #dee2e6;
}

code {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.3rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
}

.d-grid {
    display: grid !important;
}

@media (max-width: 768px) {
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .info-item label {
        min-width: auto;
    }
    
    .info-item .value {
        text-align: left;
    }
    
    .timeline-card {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection