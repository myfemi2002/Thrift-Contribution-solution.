@extends('userend.user_home')
@section('title', 'Apply for Loan')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Apply for Loan</h3>
                    <div class="nk-block-des text-soft">
                        <p>Fill out the form below to apply for a loan</p>
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

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Loan Information -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Loan Information</h6>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-title">Interest Rate</div>
                                    <div class="info-value text-primary">
                                        {{ number_format($interestRate, 1) }}% 
                                        @if($creditRating)
                                            <span class="badge bg-warning text-dark ms-2">{{ $creditRating }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-title">Loan Duration</div>
                                    <div class="info-value">30 Days</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-title">Minimum Amount</div>
                                    <div class="info-value">₦1,000</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-title">Maximum Amount</div>
                                    <div class="info-value">₦500,000</div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <div class="alert-cta">
                                <h6>📋 Loan Terms & Conditions</h6>
                                <ul class="list-disc ps-3 mb-0">
                                    <li>Repayment begins 2 working days after disbursement</li>
                                    <li>Full repayment must be made within 30 days</li>
                                    <li>Early repayment earns you better credit rating</li>
                                    <li>Gold Saver (5-15 days): 7.5% interest rate</li>
                                    <li>Silver Saver (16-25 days): 8.5% interest rate</li>
                                    <li>Bronze Saver (26-30 days): 10% interest rate</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loan Application Form -->
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group mb-4">
                            <div class="card-title">
                                <h6 class="title">Loan Application Form</h6>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('user.loans.store') }}" id="loanApplicationForm">
                            @csrf
                            
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="amount">Loan Amount (₦) <span class="text-danger">*</span></label>
                                        <div class="form-control-wrap">
                                            <input type="number" 
                                                   class="form-control form-control-lg @error('amount') is-invalid @enderror" 
                                                   id="amount" 
                                                   name="amount" 
                                                   placeholder="Enter loan amount"
                                                   min="1000" 
                                                   max="500000" 
                                                   step="100"
                                                   value="{{ old('amount') }}"
                                                   required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-note">
                                            <span class="sub-text">Minimum: ₦1,000 | Maximum: ₦500,000</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="purpose">Loan Purpose <span class="text-danger">*</span></label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control @error('purpose') is-invalid @enderror" 
                                                      id="purpose" 
                                                      name="purpose" 
                                                      placeholder="Please describe what you need this loan for..."
                                                      rows="4"
                                                      required>{{ old('purpose') }}</textarea>
                                            @error('purpose')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-note">
                                            <span class="sub-text">Be specific about how you plan to use the loan</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Loan Calculation Preview -->
                                <div class="col-12" id="loanPreview" style="display: none;">
                                    <div class="alert alert-light border">
                                        <h6 class="alert-heading">💰 Loan Calculation Preview</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="preview-item">
                                                    <span class="preview-label">Principal Amount:</span>
                                                    <span class="preview-value fw-bold" id="previewPrincipal">₦0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="preview-item">
                                                    <span class="preview-label">Interest ({{ number_format($interestRate, 1) }}%):</span>
                                                    <span class="preview-value fw-bold text-info" id="previewInterest">₦0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="preview-item">
                                                    <span class="preview-label">Total Repayment:</span>
                                                    <span class="preview-value fw-bold text-primary" id="previewTotal">₦0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="preview-item">
                                                    <span class="preview-label">Due Date:</span>
                                                    <span class="preview-value fw-bold text-warning" id="previewDueDate">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-3">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <small class="text-muted">
                                                    <strong>Disbursement:</strong><br>
                                                    <span id="previewDisbursement">-</span>
                                                </small>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">
                                                    <strong>Repayment Starts:</strong><br>
                                                    <span id="previewRepaymentStart">-</span>
                                                </small>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-success">
                                                    <strong>💡 Tip:</strong><br>
                                                    Pay early for better rates!
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="agreeTerms" required>
                                            <label class="custom-control-label" for="agreeTerms">
                                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">loan terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">
                                            <em class="icon ni ni-send"></em>
                                            <span>Submit Loan Application</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Loan Wallet Status -->
                <div class="card card-bordered mb-4">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">Loan Wallet Status</h6>
                            </div>
                        </div>
                        
                        <div class="user-account-info">
                            <div class="user-account-main">
                                <div class="user-balance">{{ $loanWallet->formatted_balance }}</div>
                                <div class="user-account-label">Current Balance</div>
                            </div>
                        </div>
                        
                        <ul class="user-account-data gy-1">
                            <li>
                                <div class="user-account-label"><span class="overline-title-alt">Total Borrowed</span></div>
                                <div class="user-account-value">{{ $loanWallet->formatted_total_borrowed }}</div>
                            </li>
                            <li>
                                <div class="user-account-label"><span class="overline-title-alt">Total Repaid</span></div>
                                <div class="user-account-value">{{ $loanWallet->formatted_total_repaid }}</div>
                            </li>
                            <li>
                                <div class="user-account-label"><span class="overline-title-alt">Wallet Status</span></div>
                                <div class="user-account-value">{!! $loanWallet->status_badge !!}</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group mb-3">
                            <div class="card-title">
                                <h6 class="title">💡 Quick Tips</h6>
                            </div>
                        </div>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <div class="media">
                                    <div class="media-object">
                                        <em class="icon ni ni-check-circle text-success"></em>
                                    </div>
                                    <div class="media-content ms-2">
                                        <h6 class="media-title">Fast Approval</h6>
                                        <span class="media-text">Most loans are approved within 24 hours</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="media">
                                    <div class="media-object">
                                        <em class="icon ni ni-wallet text-primary"></em>
                                    </div>
                                    <div class="media-content ms-2">
                                        <h6 class="media-title">Instant Disbursement</h6>
                                        <span class="media-text">Approved loans are disbursed immediately</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="media">
                                    <div class="media-object">
                                        <em class="icon ni ni-growth text-info"></em>
                                    </div>
                                    <div class="media-content ms-2">
                                        <h6 class="media-title">Build Credit Rating</h6>
                                        <span class="media-text">Early repayment improves your credit score</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0">
                                <div class="media">
                                    <div class="media-object">
                                        <em class="icon ni ni-shield-check text-success"></em>
                                    </div>
                                    <div class="media-content ms-2">
                                        <h6 class="media-title">Secure Process</h6>
                                        <span class="media-text">All transactions are secure and encrypted</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📋 Loan Terms & Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="terms-content">
                    <h6>1. Loan Agreement</h6>
                    <p>By applying for this loan, you agree to repay the full amount plus interest within the agreed timeframe.</p>
                    
                    <h6>2. Interest Rates & Credit Rating</h6>
                    <ul>
                        <li><strong>Gold Saver (5-15 days):</strong> 7.5% interest rate</li>
                        <li><strong>Silver Saver (16-25 days):</strong> 8.5% interest rate</li>
                        <li><strong>Bronze Saver (26-30 days):</strong> 10% interest rate</li>
                    </ul>
                    
                    <h6>3. Repayment Terms</h6>
                    <ul>
                        <li>Repayment begins 2 working days after disbursement</li>
                        <li>Full repayment must be completed within 30 days</li>
                        <li>Early repayment is encouraged and rewarded</li>
                    </ul>
                    
                    <h6>4. Disbursement</h6>
                    <p>Approved loans will be disbursed to your loan wallet immediately after approval.</p>
                    
                    <h6>5. Default & Overdue</h6>
                    <p>Failure to repay within the agreed timeframe may result in additional charges and impact your credit rating.</p>
                    
                    <h6>6. Privacy & Security</h6>
                    <p>Your personal and financial information will be kept secure and confidential.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="acceptTerms()">I Understand & Accept</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    const interestRate = {{ $interestRate }};
    
    // Calculate loan preview when amount changes
    $('#amount').on('input', function() {
        const amount = parseInt($(this).val()) || 0;
        
        if (amount >= 1000) {
            calculateLoanPreview(amount);
            $('#loanPreview').slideDown();
        } else {
            $('#loanPreview').slideUp();
        }
    });
    
    // Form validation
    $('#loanApplicationForm').on('submit', function(e) {
        const amount = parseInt($('#amount').val()) || 0;
        const purpose = $('#purpose').val().trim();
        const termsAccepted = $('#agreeTerms').is(':checked');
        
        if (amount < 1000 || amount > 500000) {
            e.preventDefault();
            showAlert('error', 'Loan amount must be between ₦1,000 and ₦500,000');
            return false;
        }
        
        if (purpose.length < 10) {
            e.preventDefault();
            showAlert('error', 'Please provide a detailed loan purpose (minimum 10 characters)');
            return false;
        }
        
        if (!termsAccepted) {
            e.preventDefault();
            showAlert('error', 'Please accept the terms and conditions to proceed');
            return false;
        }
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true)
               .html('<em class="icon ni ni-loader"></em><span>Processing Application...</span>');
    });
});

function calculateLoanPreview(amount) {
    $.post('{{ route("user.loans.calculate") }}', {
        amount: amount,
        _token: '{{ csrf_token() }}'
    }, function(data) {
        if (data.success) {
            const calc = data.calculation;
            
            $('#previewPrincipal').text('₦' + Number(calc.principal_amount).toLocaleString());
            $('#previewInterest').text('₦' + Number(calc.interest_amount).toLocaleString());
            $('#previewTotal').text('₦' + Number(calc.total_amount).toLocaleString());
            $('#previewDueDate').text(calc.due_date);
            $('#previewDisbursement').text(calc.disbursement_date);
            $('#previewRepaymentStart').text(calc.repayment_start_date);
        }
    }).fail(function() {
        console.log('Failed to calculate loan preview');
    });
}

function acceptTerms() {
    $('#agreeTerms').prop('checked', true);
    $('#termsModal').modal('hide');
    showAlert('success', 'Terms and conditions accepted');
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
    
    // Auto-dismiss after 4 seconds
    setTimeout(() => {
        $('.alert').alert('close');
    }, 4000);
}
</script>

@push('css')
<style>
.info-item {
    text-align: center;
    padding: 1rem;
    border: 1px solid #e3e7fe;
    border-radius: 8px;
    background: #f8f9ff;
}

.info-title {
    font-size: 0.875rem;
    color: #8094ae;
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1.125rem;
    font-weight: 600;
    color: #364a63;
}

.preview-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.preview-label {
    font-size: 0.875rem;
    color: #526484;
}

.preview-value {
    font-size: 1rem;
}

.list-group-item {
    border: none;
    padding: 0.75rem 0;
}

.media {
    display: flex;
    align-items: flex-start;
}

.media-object {
    flex-shrink: 0;
    margin-right: 0.75rem;
}

.media-content {
    flex: 1;
}

.media-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #364a63;
}

.media-text {
    font-size: 0.8125rem;
    color: #8094ae;
}

.user-account-info {
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid #e3e7fe;
    margin-bottom: 1rem;
}

.user-balance {
    font-size: 1.75rem;
    font-weight: 700;
    color: #364a63;
    margin-bottom: 0.5rem;
}

.user-account-label {
    font-size: 0.875rem;
    color: #8094ae;
}

.user-account-data {
    list-style: none;
    padding: 0;
    margin: 0;
}

.user-account-data li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f5f6fa;
}

.user-account-data li:last-child {
    border-bottom: none;
}

.user-account-value {
    font-weight: 600;
    color: #364a63;
}

.terms-content h6 {
    color: #364a63;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.terms-content h6:first-child {
    margin-top: 0;
}

.terms-content ul {
    margin-bottom: 1rem;
}

.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-block {
    width: 100%;
}

@media (max-width: 768px) {
    .info-item {
        margin-bottom: 1rem;
    }
    
    .user-balance {
        font-size: 1.5rem;
    }
    
    .preview-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>
@endpush

@endsection