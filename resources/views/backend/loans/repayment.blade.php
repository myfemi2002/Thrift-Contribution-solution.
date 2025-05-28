{{-- backend.loans.repayment --}}

@extends('admin.admin_master')
@section('title', 'Record Loan Repayment')
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.loans.show', $loan->id) }}">Loan Details</a></li>
                    <li class="breadcrumb-item active">Record Repayment</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Loan Summary Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">💳 Loan Summary</h5>
                            <small class="text-muted">Current loan status and repayment information</small>
                        </div>
                        <div class="col-auto">
                            {!! $loan->status_badge !!}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Borrower Info -->
                        <div class="col-md-4">
                            <div class="borrower-card text-center">
                                <img src="{{ $loan->user->photo ? asset($loan->user->photo) : asset('upload/no_image.jpg') }}" 
                                     alt="User Photo" class="img-thumbnail rounded-circle mb-3" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                <h6 class="mb-1">{{ $loan->user->name }}</h6>
                                <p class="text-muted mb-0">{{ $loan->user->email }}</p>
                                <code class="text-primary">{{ $loan->loan_id }}</code>
                            </div>
                        </div>
                        
                        <!-- Loan Details -->
                        <div class="col-md-4">
                            <div class="loan-details">
                                <div class="detail-item">
                                    <label>Total Loan Amount:</label>
                                    <span class="fw-bold text-primary">{{ $loan->formatted_total_amount }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Interest Rate:</label>
                                    <span>{{ $loan->interest_rate }}%</span>
                                </div>
                                <div class="detail-item">
                                    <label>Due Date:</label>
                                    <span class="{{ $loan->is_overdue ? 'text-danger' : ($loan->days_until_due <= 5 ? 'text-warning' : '') }}">
                                        @if($loan->due_date)
                                            {{ $loan->due_date->format('M d, Y') }}
                                            @if($loan->days_until_due !== null)
                                                <br>
                                                <small>
                                                    @if($loan->is_overdue)
                                                        ({{ abs($loan->days_until_due) }} days overdue)
                                                    @else
                                                        ({{ $loan->days_until_due }} days left)
                                                    @endif
                                                </small>
                                            @endif
                                        @else
                                            Not set
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Status -->
                        <div class="col-md-4">
                            <div class="payment-status">
                                <div class="detail-item">
                                    <label>Amount Paid:</label>
                                    <span class="fw-bold text-success">{{ $loan->formatted_amount_paid }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Outstanding Balance:</label>
                                    <span class="fw-bold {{ $loan->outstanding_balance > 0 ? 'text-warning' : 'text-success' }}">
                                        {{ $loan->formatted_outstanding_balance }}
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <label>Progress:</label>
                                    <div>
                                        <div class="progress mb-1" style="height: 8px;">
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

            <!-- Repayment Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">💰 Record New Repayment</h5>
                </div>
                <div class="card-body">
                    <form id="repaymentForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Repayment Amount (₦) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₦</span>
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="amount" 
                                               name="amount"
                                               step="0.01" 
                                               min="1" 
                                               max="{{ $loan->outstanding_balance }}"
                                               placeholder="0.00" 
                                               required>
                                    </div>
                                    <small class="text-muted">Maximum: ₦{{ number_format($loan->outstanding_balance, 2) }}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-lg" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash">Cash Payment</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="mobile_money">Mobile Money</option>
                                        <option value="card">Card Payment</option>
                                        <option value="deduction">Wallet Deduction</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Payment Date</label>
                                    <input type="date" 
                                           class="form-control" 
                                           name="payment_date" 
                                           value="{{ now()->toDateString() }}"
                                           max="{{ now()->toDateString() }}"
                                           required>
                                    <small class="text-muted">Date when payment was received</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Reference Number</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="reference_number" 
                                           placeholder="e.g., Receipt #, Transaction ID">
                                    <small class="text-muted">Optional: Receipt number, transaction ID, etc.</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" 
                                              name="notes" 
                                              rows="3" 
                                              placeholder="Optional notes about this repayment..."></textarea>
                                </div>
                            </div>

                            <!-- Calculation Preview -->
                            <div class="col-12" id="calculationPreview" style="display: none;">
                                <div class="alert alert-info">
                                    <h6 class="alert-heading">💡 Repayment Preview</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Current Outstanding:</strong><br>
                                            <span id="currentOutstanding">₦{{ number_format($loan->outstanding_balance, 2) }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Payment Amount:</strong><br>
                                            <span id="paymentAmount" class="text-success">₦0.00</span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>New Outstanding:</strong><br>
                                            <span id="newOutstanding" class="fw-bold">₦{{ number_format($loan->outstanding_balance, 2) }}</span>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div id="completionMessage" class="text-success fw-bold" style="display: none;">
                                        🎉 This payment will complete the loan!
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-3">
                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="ri-money-dollar-circle-line me-2"></i>Record Repayment
                                    </button>
                                    <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="ri-arrow-left-line me-2"></i>Back to Loan Details
                                    </a>
                                    <!-- <button type="button" class="btn btn-outline-primary btn-lg" onclick="fillFullAmount()">
                                        <i class="ri-wallet-line me-2"></i>Pay Full Outstanding
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Repayments -->
            @if($loan->repayments->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="card-title mb-0">📋 Recent Repayments</h5>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($loan->repayments->sortByDesc('payment_date')->take(5) as $repayment)
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($loan->repayments->count() > 5)
                            <div class="card-footer text-center">
                                <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-outline-primary btn-sm">
                                    View All {{ $loan->repayments->count() }} Repayments
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    const outstandingBalance = {{ $loan->outstanding_balance }};
    
    // Update calculation preview when amount changes
    $('#amount').on('input', function() {
        const amount = parseFloat($(this).val()) || 0;
        
        if (amount > 0) {
            updateCalculationPreview(amount);
            $('#calculationPreview').slideDown();
        } else {
            $('#calculationPreview').slideUp();
        }
    });
    
    // Form submission
    $('#repaymentForm').on('submit', function(e) {
        e.preventDefault();
        
        const amount = parseFloat($('#amount').val()) || 0;
        const paymentMethod = $('select[name="payment_method"]').val();
        
        if (!amount || amount <= 0) {
            Swal.fire('Error!', 'Please enter a valid repayment amount', 'error');
            return;
        }
        
        if (amount > outstandingBalance) {
            Swal.fire('Error!', `Repayment amount cannot exceed outstanding balance of ₦${outstandingBalance.toLocaleString()}`, 'error');
            return;
        }
        
        if (!paymentMethod) {
            Swal.fire('Error!', 'Please select a payment method', 'error');
            return;
        }
        
        // Show confirmation
        const newOutstanding = Math.max(0, outstandingBalance - amount);
        const isComplete = newOutstanding === 0;
        
        Swal.fire({
            title: 'Confirm Repayment',
            html: `
                <div class="text-start">
                    <p><strong>Payment Amount:</strong> ₦${amount.toLocaleString()}</p>
                    <p><strong>New Outstanding:</strong> ₦${newOutstanding.toLocaleString()}</p>
                    ${isComplete ? '<p class="text-success"><strong>🎉 This will complete the loan!</strong></p>' : ''}
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Record Repayment'
        }).then((result) => {
            if (result.isConfirmed) {
                submitRepayment();
            }
        });
    });
});

function updateCalculationPreview(amount) {
    const outstandingBalance = {{ $loan->outstanding_balance }};
    const newOutstanding = Math.max(0, outstandingBalance - amount);
    const isComplete = newOutstanding === 0;
    
    $('#paymentAmount').text('₦' + amount.toLocaleString());
    $('#newOutstanding').text('₦' + newOutstanding.toLocaleString());
    
    if (isComplete) {
        $('#newOutstanding').removeClass('text-warning').addClass('text-success');
        $('#completionMessage').show();
    } else {
        $('#newOutstanding').removeClass('text-success').addClass('text-warning');
        $('#completionMessage').hide();
    }
}

function fillFullAmount() {
    const outstandingBalance = {{ $loan->outstanding_balance }};
    $('#amount').val(outstandingBalance.toFixed(2)).trigger('input');
    $('select[name="payment_method"]').focus();
}

function submitRepayment() {
    const formData = {
        _token: '{{ csrf_token() }}',
        amount: $('#amount').val(),
        payment_method: $('select[name="payment_method"]').val(),
        payment_date: $('input[name="payment_date"]').val(),
        reference_number: $('input[name="reference_number"]').val(),
        notes: $('textarea[name="notes"]').val()
    };
    
    // Disable form
    $('#repaymentForm button[type="submit"]').prop('disabled', true)
        .html('<i class="ri-loader-4-line me-2"></i>Processing...');
    
    $.ajax({
        url: '{{ route("admin.loans.record-repayment", $loan->id) }}',
        method: 'POST',
        data: formData,
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: response.message,
                icon: 'success',
                confirmButtonText: 'View Loan Details'
            }).then(() => {
                window.location.href = '{{ route("admin.loans.show", $loan->id) }}';
            });
        },
        error: function(xhr) {
            console.log('Error response:', xhr.responseJSON);
            
            let errorMessage = 'Failed to record repayment';
            
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors || {};
                errorMessage = Object.values(errors).flat().join('\n');
            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            
            Swal.fire('Error!', errorMessage, 'error');
            
            // Re-enable form
            $('#repaymentForm button[type="submit"]').prop('disabled', false)
                .html('<i class="ri-money-dollar-circle-line me-2"></i>Record Repayment');
        }
    });
}
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
.borrower-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    border: 1px solid #e3e7fe;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f5f6fa;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item label {
    font-size: 0.875rem;
    color: #8094ae;
    font-weight: 500;
    margin-bottom: 0;
    min-width: 120px;
}

.progress {
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
}

.progress-bar {
    border-radius: 4px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 10px;
}

.card-header {
    border-bottom: 1px solid #dee2e6;
}

.form-control:focus,
.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
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

.alert-info {
    background-color: #e7f3ff;
    border-color: #bee5eb;
    color: #055160;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
    font-weight: 600;
}

.form-control-lg,
.form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1.125rem;
    border-radius: 0.5rem;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.125rem;
    border-radius: 0.5rem;
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.35em 0.65em;
}

.card-title {
    color: #364a63;
    font-weight: 600;
}

.text-primary {
    color: #4e73df !important;
}

.text-success {
    color: #1cc88a !important;
}

.text-warning {
    color: #f6c23e !important;
}

.text-danger {
    color: #e74a3b !important;
}

.bg-primary {
    background-color: #4e73df !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.fw-bold {
    font-weight: 700 !important;
}

.gap-3 {
    gap: 1rem !important;
}

.d-flex {
    display: flex !important;
}

.alert-heading {
    color: inherit;
    font-weight: 600;
}

@media (max-width: 768px) {
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .detail-item label {
        min-width: auto;
    }
    
    .borrower-card {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    
    .d-flex {
        flex-direction: column;
    }
    
    .gap-3 {
        gap: 0.5rem !important;
    }
    
    .form-control-lg,
    .form-select-lg {
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
    }
}
</style>
@endpush

@endsection