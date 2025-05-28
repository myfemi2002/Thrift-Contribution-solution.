@extends('admin.admin_master')
@section('title', 'User Loan Wallet')
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
                    <li class="breadcrumb-item active">User Loan Wallet</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Profile Section -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">👤 User Profile</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $user->photo ? asset($user->photo) : asset('upload/no_image.jpg') }}" 
                         alt="User Photo" class="img-thumbnail rounded-circle mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    
                    <h5 class="mb-2">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="user-info">
                        <div class="info-row">
                            <span class="label">Phone:</span>
                            <span class="value">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Status:</span>
                            <span class="value">
                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="label">Member Since:</span>
                            <span class="value">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Total Loans:</span>
                            <span class="value">{{ $user->loans()->count() }} loans</span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.contributions.wallet', $user->id) }}" class="btn btn-outline-info btn-sm me-2">
                            <i class="ri-wallet-line me-1"></i>Contribution Wallet
                        </a>
                        <a href="mailto:{{ $user->email }}" class="btn btn-outline-primary btn-sm">
                            <i class="ri-mail-line me-1"></i>Email User
                        </a>
                    </div>
                </div>
            </div>

            <!-- Loan Wallet Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">💳 Loan Wallet Summary</h5>
                </div>
                <div class="card-body">
                    <div class="wallet-stats">
                        <div class="stat-item">
                            <div class="stat-label">Available Balance</div>
                            <div class="stat-value text-primary">{{ $loanWallet->formatted_balance }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Total Borrowed</div>
                            <div class="stat-value text-info">{{ $loanWallet->formatted_total_borrowed }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Total Repaid</div>
                            <div class="stat-value text-success">{{ $loanWallet->formatted_total_repaid }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Outstanding</div>
                            <div class="stat-value {{ $loanWallet->total_outstanding > 0 ? 'text-warning' : 'text-success' }}">
                                ₦{{ number_format($loanWallet->total_outstanding, 2) }}
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Wallet Status</div>
                            <div class="stat-value">{!! $loanWallet->status_badge !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Eligibility Status -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">✅ Loan Eligibility</h5>
                </div>
                <div class="card-body">
                    @php
                        $eligibility = $loanWallet->getEligibilityStatus();
                    @endphp
                    
                    <div class="eligibility-status">
                        <div class="alert alert-{{ $eligibility['eligible'] ? 'success' : 'warning' }}">
                            <div class="d-flex align-items-center">
                                <i class="ri-{{ $eligibility['eligible'] ? 'check-circle' : 'alert-circle' }}-line me-2 fs-4"></i>
                                <div>
                                    <strong>{{ $eligibility['eligible'] ? 'Eligible' : 'Not Eligible' }}</strong><br>
                                    <small>{{ $eligibility['reason'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="loan-limits">
                        <h6 class="mb-2">📊 Loan Limits</h6>
                        <div class="info-row">
                            <span class="label">Active Loans:</span>
                            <span class="value">{{ $loanWallet->activeLoans()->count() }}/3</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Min Amount:</span>
                            <span class="value">₦1,000</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Max Amount:</span>
                            <span class="value">₦500,000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loans Section -->
        <div class="col-lg-8">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3 class="text-white">{{ $loans->where('status', 'pending')->count() }}</h3>
                            <p class="text-white-50 mb-0">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3 class="text-white">{{ $loans->whereIn('status', ['disbursed', 'active'])->count() }}</h3>
                            <p class="text-white-50 mb-0">Active</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h3 class="text-white">{{ $loans->where('status', 'overdue')->count() }}</h3>
                            <p class="text-white-50 mb-0">Overdue</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h3 class="text-white">{{ $loans->where('status', 'completed')->count() }}</h3>
                            <p class="text-white-50 mb-0">Completed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">⚡ Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary w-100" onclick="createLoanForUser()">
                                <i class="ri-add-line me-2"></i>Create Loan
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100" onclick="exportUserLoans()">
                                <i class="ri-download-line me-2"></i>Export Loans
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info w-100" onclick="viewUserContributions()">
                                <i class="ri-coin-line me-2"></i>Contributions
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="ri-arrow-left-line me-2"></i>Back to Loans
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans List -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">📋 User Loans History</h5>
                            <small class="text-muted">All loans for {{ $user->name }}</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">{{ $loans->total() }} loans</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($loans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Loan ID</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Due Date</th>
                                        <th>Applied Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loans as $loan)
                                        <tr>
                                            <td>
                                                <span class="font-monospace text-primary">{{ $loan->loan_id }}</span>
                                                @if($loan->credit_rating)
                                                    <div class="mt-1">{!! $loan->credit_rating_badge !!}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">{{ $loan->formatted_amount }}</div>
                                                <small class="text-muted">Total: {{ $loan->formatted_total_amount }}</small>
                                            </td>
                                            <td>
                                                {!! $loan->status_badge !!}
                                                @if($loan->interest_overridden)
                                                    <div class="mt-1">
                                                        <span class="badge bg-info badge-sm">Custom Rate</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if(in_array($loan->status, ['disbursed', 'active', 'completed', 'overdue']))
                                                    <div class="progress mb-1" style="height: 6px;">
                                                        <div class="progress-bar bg-success" style="width: {{ $loan->repayment_progress }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ number_format($loan->repayment_progress, 1) }}% paid</small>
                                                    <div class="fw-bold {{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }}">
                                                        {{ $loan->formatted_outstanding_balance }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">N/A</span>
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
                                                            @elseif($loan->status !== 'completed')
                                                                {{ $loan->days_until_due }} days left
                                                            @else
                                                                Completed
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
                            {{ $loans->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-file-list-line display-4 text-muted"></i>
                            <h5 class="mt-3">No loans found</h5>
                            <p class="text-muted">{{ $user->name }} hasn't applied for any loans yet</p>
                            <button type="button" class="btn btn-primary" onclick="createLoanForUser()">
                                <i class="ri-add-line me-2"></i>Create First Loan
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function createLoanForUser() {
    Swal.fire({
        title: 'Create Loan for {{ $user->name }}',
        html: `
            <div class="text-start">
                <div class="form-group mb-3">
                    <label class="form-label">Loan Amount (₦)</label>
                    <input type="number" id="loanAmount" class="form-control" min="1000" max="500000" step="100" placeholder="Enter amount">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Interest Rate (%)</label>
                    <input type="number" id="interestRate" class="form-control" min="0" max="50" step="0.1" value="10" placeholder="Enter rate">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Loan Purpose</label>
                    <textarea id="loanPurpose" class="form-control" rows="3" placeholder="Enter loan purpose"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Create Loan',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const amount = document.getElementById('loanAmount').value;
            const rate = document.getElementById('interestRate').value;
            const purpose = document.getElementById('loanPurpose').value;
            
            if (!amount || amount < 1000) {
                Swal.showValidationMessage('Please enter a valid amount (minimum ₦1,000)');
                return false;
            }
            
            if (!rate || rate < 0) {
                Swal.showValidationMessage('Please enter a valid interest rate');
                return false;
            }
            
            if (!purpose.trim()) {
                Swal.showValidationMessage('Please enter loan purpose');
                return false;
            }
            
            return { amount, rate, purpose };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Here you would typically send an AJAX request to create the loan
            // For now, we'll show a success message
            Swal.fire(
                'Feature Coming Soon!',
                'Admin loan creation functionality will be implemented in the next update.',
                'info'
            );
        }
    });
}

function exportUserLoans() {
    const url = `{{ route('admin.loans.export') }}?user_id={{ $user->id }}`;
    window.open(url, '_blank');
}

function viewUserContributions() {
    window.location.href = `{{ route('admin.contributions.wallet', $user->id) }}`;
}

// Loan action functions (same as in loans index)
function approveLoan(loanId) {
    // Implementation similar to admin.loans.index
    Swal.fire({
        title: 'Approve Loan?',
        text: 'This loan will be approved and ready for disbursement.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, approve it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to approve loan
            $.ajax({
                url: `/admin/loans/${loanId}/approve`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    Swal.fire('Approved!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to approve loan', 'error');
                }
            });
        }
    });
}

function rejectLoan(loanId) {
    Swal.fire({
        title: 'Reject Loan?',
        input: 'textarea',
        inputLabel: 'Reason for rejection',
        inputPlaceholder: 'Enter reason for rejecting this loan...',
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
                url: `/admin/loans/${loanId}/reject`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rejection_reason: result.value
                },
                success: function(response) {
                    Swal.fire('Rejected!', response.message, 'success').then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.error || 'Failed to reject loan', 'error');
                }
            });
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
                url: `/admin/loans/${loanId}/disburse`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
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
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
.user-info {
    text-align: left;
    margin-top: 1rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f5f6fa;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-size: 0.875rem;
    color: #8094ae;
    font-weight: 500;
}

.info-row .value {
    font-weight: 600;
    color: #364a63;
}

.wallet-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.stat-label {
    font-size: 0.875rem;
    color: #8094ae;
    font-weight: 500;
}

.stat-value {
    font-weight: 700;
    font-size: 1.125rem;
}

.eligibility-status .alert {
    margin-bottom: 1rem;
}

.loan-limits {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #28a745;
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

.img-thumbnail {
    border: 2px solid #dee2e6;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 12px;
}

.progress {
    height: 6px;
    background-color: #e9ecef;
    border-radius: 3px;
}

.progress-bar {
    border-radius: 3px;
}

.table th {
    font-weight: 600;
    font-size: 14px;
    border-bottom: 2px solid #dee2e6;
}

.dropdown-toggle::after {
    margin-left: 0.5em;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.display-4 {
    font-size: 2.5rem;
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25em 0.5em;
}

@media (max-width: 768px) {
    .stat-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection