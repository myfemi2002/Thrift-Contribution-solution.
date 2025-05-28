@extends('userend.user_home')
@section('title', 'Loan Details')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Loan Details</h3>
                    <div class="nk-block-des text-soft">
                        <p>Complete information about your loan application</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.loans.index') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Loans</span>
                    </a>
                    <a href="{{ route('user.loans.index') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-gs">
            <!-- Main Loan Information -->
            <div class="col-lg-8">
                <!-- Loan Overview Card -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Loan Overview</h6>
                            </div>
                            <div class="card-tools">
                                {!! $loan->status_badge !!}
                                @if($loan->credit_rating)
                                    {!! $loan->credit_rating_badge !!}
                                @endif
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-list">
                                    <div class="info-item">
                                        <div class="info-title">Loan ID</div>
                                        <div class="info-value">
                                            <code>{{ $loan->loan_id }}</code>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-title">Principal Amount</div>
                                        <div class="info-value text-success fw-bold">{{ $loan->formatted_amount }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-title">Interest Rate</div>
                                        <div class="info-value">
                                            {{ $loan->interest_rate }}%
                                            @if($loan->interest_overridden)
                                                <span class="badge bg-info badge-sm">Custom Rate</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-title">Interest Amount</div>
                                        <div class="info-value">₦{{ number_format($loan->interest_amount, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-list">
                                    <div class="info-item">
                                        <div class="info-title">Total Amount</div>
                                        <div class="info-value text-primary fw-bold">{{ $loan->formatted_total_amount }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-title">Amount Paid</div>
                                        <div class="info-value text-success">{{ $loan->formatted_amount_paid }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-title">Outstanding Balance</div>
                                        <div class="info-value {{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }} fw-bold">
                                            {{ $loan->formatted_outstanding_balance }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-title">Repayment Progress</div>
                                        <div class="info-value">
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: {{ $loan->repayment_progress }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ number_format($loan->repayment_progress, 1) }}% Complete</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loan Timeline -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Loan Timeline</h6>
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
    <div class="timeline-card">
        <div class="timeline-header">
            <div class="timeline-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="timeline-content">
                <h6 class="timeline-title mb-1">Application Date</h6>
                <div class="timeline-value">{{ $loan->created_at->format('M d, Y g:i A') }}</div>
                <small class="timeline-note text-muted">
                    <i class="fas fa-clock me-1"></i>{{ $loan->created_at->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>
</div>
                            @if($loan->approved_at)
                                <div class="col-md-6">
                                    <div class="timeline-item">
                                        <div class="timeline-title">Approval Date</div>
                                        <div class="timeline-value text-success">{{ $loan->approved_at->format('M d, Y g:i A') }}</div>
                                        <div class="timeline-note">{{ $loan->approved_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($loan->disbursed_at)
                                <div class="col-md-6">
                                    <div class="timeline-item">
                                        <div class="timeline-title">Disbursement Date</div>
                                        <div class="timeline-value text-primary">{{ $loan->disbursed_at->format('M d, Y g:i A') }}</div>
                                        <div class="timeline-note">{{ $loan->disbursed_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($loan->repayment_start_date)
                                <div class="col-md-6">
                                    <div class="timeline-item">
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
                                    <div class="timeline-item">
                                        <div class="timeline-title">Due Date</div>
                                        <div class="timeline-value {{ $loan->is_overdue ? 'text-danger' : ($loan->days_until_due <= 5 ? 'text-warning' : '') }}">
                                            {{ $loan->due_date->format('M d, Y') }}
                                        </div>
                                        <div class="timeline-note">
                                            @if($loan->days_until_due !== null)
                                                @if($loan->is_overdue)
                                                    <span class="text-danger">{{ abs($loan->days_until_due) }} days overdue</span>
                                                @else
                                                    <span class="{{ $loan->days_until_due <= 5 ? 'text-warning' : '' }}">{{ $loan->days_until_due }} days remaining</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($loan->completed_at)
                                <div class="col-md-6">
                                    <div class="timeline-item">
                                        <div class="timeline-title">Completion Date</div>
                                        <div class="timeline-value text-success">{{ $loan->completed_at->format('M d, Y g:i A') }}</div>
                                        <div class="timeline-note">{{ $loan->completed_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Loan Purpose -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Loan Purpose</h6>
                            </div>
                        </div>
                        <div class="purpose-content">
                            <p>{{ $loan->purpose }}</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($loan->admin_notes || $loan->rejection_reason)
                    <div class="card card-bordered mb-4">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">
                                        @if($loan->status === 'rejected')
                                            Rejection Details
                                        @else
                                            Admin Notes
                                        @endif
                                    </h6>
                                </div>
                            </div>
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
                    <div class="card card-bordered mb-4">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">Repayment History</h6>
                                </div>
                                <div class="card-tools">
                                    <span class="badge bg-info">{{ $loan->repayments->count() }} payments</span>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Outstanding After</th>
                                            <th>Reference</th>
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
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Quick Actions</h6>
                            </div>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-12">
                                <a href="{{ route('user.loans.history') }}" class="btn btn-outline-primary w-100">
                                    <em class="icon ni ni-histroy me-2"></em>
                                    <span>View All Loans</span>
                                </a>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-info w-100" onclick="copyLoanId()">
                                    <em class="icon ni ni-copy me-2"></em>
                                    <span>Copy Loan ID</span>
                                </button>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-success w-100" onclick="downloadLoanDetails()">
                                    <em class="icon ni ni-download me-2"></em>
                                    <span>Download Details</span>
                                </button>
                            </div>
                            @if($loan->status === 'pending')
                                <div class="col-12">
                                    <button type="button" class="btn btn-outline-secondary w-100" disabled>
                                        <em class="icon ni ni-clock me-2"></em>
                                        <span>Awaiting Approval</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Loan Summary -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Loan Summary</h6>
                            </div>
                        </div>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Principal Amount:</span>
                                <strong class="text-success">{{ $loan->formatted_amount }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Interest ({{ $loan->interest_rate }}%):</span>
                                <strong>₦{{ number_format($loan->interest_amount, 2) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom">
                                <span>Total Repayment:</span>
                                <strong class="text-primary">{{ $loan->formatted_total_amount }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Amount Paid:</span>
                                <strong class="text-success">{{ $loan->formatted_amount_paid }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Outstanding:</span>
                                <strong class="{{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }}">
                                    {{ $loan->formatted_outstanding_balance }}
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Credit Rating Info -->
                @if($loan->credit_rating || $loan->status === 'completed')
                    <div class="card card-bordered mb-4">
                        <div class="card-inner">
                            <div class="card-title-group mb-3">
                                <div class="card-title">
                                    <h6 class="title">Credit Rating</h6>
                                </div>
                            </div>
                            
                            @if($loan->credit_rating)
                                <div class="text-center">
                                    {!! $loan->credit_rating_badge !!}
                                    <h5 class="mt-2">{{ $loan->credit_rating }}</h5>
                                    <p class="text-muted">
                                        @switch($loan->credit_rating)
                                            @case('Gold Saver')
                                                You qualify for 7.5% interest on future loans
                                                @break
                                            @case('Silver Saver')
                                                You qualify for 8.5% interest on future loans
                                                @break
                                            @case('Bronze Saver')
                                                You qualify for 10% interest on future loans
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            @else
                                <div class="text-center">
                                    <em class="icon ni ni-trophy" style="font-size: 2rem; color: #ddd;"></em>
                                    <p class="text-muted mt-2">Credit rating will be assigned upon loan completion</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Interest Rate Info -->
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">💡 Interest Rate Guide</h6>
                            </div>
                        </div>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning text-dark me-2">🥇</span>
                                    <div>
                                        <div class="fw-medium">Gold Saver (5-15 days)</div>
                                        <small class="text-muted">7.5% interest rate</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-secondary me-2">🥈</span>
                                    <div>
                                        <div class="fw-medium">Silver Saver (16-25 days)</div>
                                        <small class="text-muted">8.5% interest rate</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-dark me-2">🥉</span>
                                    <div>
                                        <div class="fw-medium">Bronze Saver (26-30 days)</div>
                                        <small class="text-muted">10% interest rate</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                        <div class="alert alert-info mt-3 mb-0">
                            <small>💡 <strong>Tip:</strong> Pay early to earn better credit rating and lower interest rates on future loans!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function copyLoanId() {
    const loanId = '{{ $loan->loan_id }}';
    
    navigator.clipboard.writeText(loanId).then(function() {
        showAlert('success', 'Loan ID copied to clipboard');
    }).catch(function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = loanId;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showAlert('success', 'Loan ID copied to clipboard');
        } catch (err) {
            showAlert('error', 'Failed to copy Loan ID');
        }
        document.body.removeChild(textArea);
    });
}

function downloadLoanDetails() {
    // Create a simple text summary
    const loanDetails = `
LOAN DETAILS SUMMARY
==================
Loan ID: {{ $loan->loan_id }}
Status: {{ ucfirst($loan->status) }}
Principal Amount: {{ $loan->formatted_amount }}
Interest Rate: {{ $loan->interest_rate }}%
Total Amount: {{ $loan->formatted_total_amount }}
Amount Paid: {{ $loan->formatted_amount_paid }}
Outstanding: {{ $loan->formatted_outstanding_balance }}
Application Date: {{ $loan->created_at->format('M d, Y g:i A') }}
@if($loan->due_date)Due Date: {{ $loan->due_date->format('M d, Y') }}@endif

Purpose: {{ $loan->purpose }}

Generated on: ${new Date().toLocaleString()}
    `;
    
    const blob = new Blob([loanDetails], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'loan-{{ $loan->loan_id }}-details.txt';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('success', 'Loan details downloaded successfully');
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

.info-title {
    font-size: 0.875rem;
    color: #8094ae;
    font-weight: 500;
}

.info-value {
    font-weight: 600;
    color: #364a63;
}

.timeline-item {
    text-align: center;
    padding: 1rem;
    border: 1px solid #e3e7fe;
    border-radius: 8px;
    background: #f8f9ff;
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
    border-left: 4px solid #4e73df;
}

.progress {
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    margin-bottom: 0.25rem;
}

.progress-bar {
    border-radius: 4px;
}

.list-group-item {
    border: none;
    padding: 0.75rem 0;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 10px;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

code {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.3rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #526484;
    border-bottom: 2px solid #dee2e6;
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .timeline-item {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush

@endsection