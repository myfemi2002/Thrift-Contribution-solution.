@extends('userend.user_home')
@section('title', 'Request Withdrawal')
@section('user_content')



<style>
/* Enhanced Payment Method Styles */
.payment-methods-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 1rem;
}

.payment-method-item {
    position: relative;
}

.payment-radio {
    position: absolute;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.payment-method-label {
    cursor: pointer;
    margin: 0;
    display: block;
    width: 100%;
}

.payment-method-card {
    display: flex;
    align-items: flex-start;
    padding: 24px 20px;
    border: 2px solid #e5e9f2;
    border-radius: 16px;
    background: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    min-height: 140px;
}

.payment-method-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: transparent;
    transition: all 0.3s ease;
}

.payment-method-card:hover {
    border-color: #007bff;
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 123, 255, 0.12);
}

.payment-icon-wrapper {
    margin-right: 16px;
    flex-shrink: 0;
}

.payment-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    transition: all 0.3s ease;
}

.bg-success-soft {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.bg-primary-soft {
    background: rgba(0, 123, 255, 0.1);
    border: 1px solid rgba(0, 123, 255, 0.2);
}

.payment-info {
    flex: 1;
    min-width: 0;
}

.payment-title {
    font-size: 16px;
    font-weight: 600;
    color: #1a202c;
    margin: 0 0 6px 0;
    line-height: 1.3;
}

.payment-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0 0 12px 0;
    line-height: 1.4;
}

.payment-features {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.feature-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #475569;
    font-weight: 500;
}

.feature-badge .icon {
    font-size: 14px;
    color: #10b981;
}

.payment-selector {
    margin-left: 12px;
    flex-shrink: 0;
    align-self: flex-start;
    margin-top: 4px;
}

.radio-indicator {
    width: 24px;
    height: 24px;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    transition: all 0.3s ease;
    font-size: 12px;
    color: #ffffff;
}

/* Selected State Styles */
.payment-radio:checked + .payment-method-label .payment-method-card {
    border-color: #007bff;
    background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
    box-shadow: 0 8px 32px rgba(0, 123, 255, 0.15);
    transform: translateY(-2px);
}

.payment-radio:checked + .payment-method-label .payment-method-card::before {
    background: linear-gradient(90deg, #007bff, #0056b3);
}

.payment-radio:checked + .payment-method-label .radio-indicator {
    background: #007bff;
    border-color: #007bff;
    transform: scale(1.1);
}

.payment-radio:checked + .payment-method-label .payment-title {
    color: #007bff;
}

.payment-radio:checked + .payment-method-label .payment-icon {
    transform: scale(1.05);
}

.payment-radio:checked + .payment-method-label .bg-success-soft {
    background: rgba(34, 197, 94, 0.15);
    border-color: rgba(34, 197, 94, 0.3);
}

.payment-radio:checked + .payment-method-label .bg-primary-soft {
    background: rgba(0, 123, 255, 0.15);
    border-color: rgba(0, 123, 255, 0.3);
}

/* Focus State */
.payment-radio:focus + .payment-method-label .payment-method-card {
    outline: 2px solid #007bff;
    outline-offset: 2px;
}

/* Loading State */
.payment-method-card.loading {
    pointer-events: none;
    opacity: 0.7;
}

.payment-method-card.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #e5e9f2;
    border-radius: 50%;
    border-top-color: #007bff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-methods-wrapper {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .payment-method-card {
        padding: 20px 16px;
        min-height: 120px;
    }
    
    .payment-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
    
    .payment-icon-wrapper {
        margin-right: 14px;
    }
}

@media (max-width: 576px) {
    .payment-method-card {
        padding: 18px 14px;
        min-height: 110px;
    }
    
    .payment-title {
        font-size: 15px;
    }
    
    .payment-subtitle {
        font-size: 13px;
    }
    
    .feature-badge {
        font-size: 11px;
    }
    
    .payment-features {
        gap: 4px;
    }
}

/* Animation Enhancements */
@media (prefers-reduced-motion: no-preference) {
    .payment-method-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .payment-icon {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .radio-indicator {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .payment-method-card {
        border-width: 3px;
    }
    
    .payment-radio:checked + .payment-method-label .payment-method-card {
        border-width: 4px;
    }
}

/* Dark mode ready (if needed in future) */
@media (prefers-color-scheme: dark) {
    .payment-method-card {
        background: #1f2937;
        border-color: #374151;
    }
    
    .payment-title {
        color: #f9fafb;
    }
    
    .payment-subtitle {
        color: #9ca3af;
    }
    
    .feature-badge {
        color: #d1d5db;
    }
}
</style>

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Request Withdrawal</h3>
                    <div class="nk-block-des text-soft">
                        <p>Withdraw funds from your contribution wallet</p>
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

        <!-- Balance Overview -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-md-4">
                    <div class="card bg-primary">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle text-white">Available Balance</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-wallet text-white"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount text-white display-6">₦{{ number_format($availableBalance, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle text-white">Pending Withdrawals</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-clock text-white"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount text-white display-6">₦{{ number_format($pendingWithdrawals, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle text-white">Withdrawable Amount</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-money text-white"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount text-white display-6">₦{{ number_format($effectiveBalance, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Form -->
        <div class="nk-block">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <form action="{{ route('user.withdrawals.store') }}" method="POST" id="withdrawalForm">
                                @csrf
                                
                                <!-- Amount Section -->
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Withdrawal Amount <span class="text-danger">*</span></label>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">₦</span>
                                                    </div>
                                                    <input type="number" 
                                                           class="form-control form-control-lg @error('amount') is-invalid @enderror" 
                                                           name="amount" 
                                                           id="amount"
                                                           value="{{ old('amount') }}" 
                                                           placeholder="0.00" 
                                                           min="100" 
                                                           max="{{ $effectiveBalance }}"
                                                           step="0.01" 
                                                           required>
                                                </div>
                                                @error('amount')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                                <div class="form-note">
                                                    <span class="text-soft">Minimum: ₦100 | Maximum: ₦{{ number_format($effectiveBalance, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Method Section -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                                            <div class="payment-methods-wrapper mt-3">
                                                
                                                <!-- Cash Payment Option -->
                                                <div class="payment-method-item">
                                                    <input type="radio" 
                                                        class="payment-radio" 
                                                        name="payment_method" 
                                                        value="cash" 
                                                        id="payment-cash" 
                                                        {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }}
                                                        required>
                                                    <label class="payment-method-label" for="payment-cash">
                                                        <div class="payment-method-card">
                                                            <div class="payment-icon-wrapper">
                                                                <div class="payment-icon bg-success-soft">
                                                                    <em class="icon ni ni-money text-success"></em>
                                                                </div>
                                                            </div>
                                                            <div class="payment-info">
                                                                <h6 class="payment-title">Cash Payment</h6>
                                                                <p class="payment-subtitle">Receive cash directly from admin</p>
                                                                <div class="payment-features">
                                                                    <span class="feature-badge">
                                                                        <em class="icon ni ni-check-circle-fill"></em>
                                                                        Instant Processing
                                                                    </span>
                                                                    <span class="feature-badge">
                                                                        <em class="icon ni ni-shield-check-fill"></em>
                                                                        No Fees
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="payment-selector">
                                                                <div class="radio-indicator">
                                                                    <em class="icon ni ni-check"></em>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>

                                                <!-- Bank Transfer Option -->
                                                <div class="payment-method-item">
                                                    <input type="radio" 
                                                        class="payment-radio" 
                                                        name="payment_method" 
                                                        value="bank_transfer" 
                                                        id="payment-bank" 
                                                        {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                                    <label class="payment-method-label" for="payment-bank">
                                                        <div class="payment-method-card">
                                                            <div class="payment-icon-wrapper">
                                                                <div class="payment-icon bg-primary-soft">
                                                                    <em class="icon ni ni-building text-primary"></em>
                                                                </div>
                                                            </div>
                                                            <div class="payment-info">
                                                                <h6 class="payment-title">Bank Transfer</h6>
                                                                <p class="payment-subtitle">Receive payment via bank transfer</p>
                                                                <div class="payment-features">
                                                                    <span class="feature-badge">
                                                                        <em class="icon ni ni-clock-fill"></em>
                                                                        1-3 Business Days
                                                                    </span>
                                                                    <span class="feature-badge">
                                                                        <em class="icon ni ni-shield-check-fill"></em>
                                                                        No Fees
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="payment-selector">
                                                                <div class="radio-indicator">
                                                                    <em class="icon ni ni-check"></em>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Details Section (Hidden by default) -->
                                    <div class="col-12" id="bank-details" style="display: none;">
                                        <div class="card bg-light">
                                            <div class="card-inner">
                                                <h6 class="card-title mb-3">Bank Account Details</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bank Name</label>
                                                            <input type="text" 
                                                                   class="form-control @error('bank_name') is-invalid @enderror" 
                                                                   name="bank_name" 
                                                                   id="bank_name"
                                                                   value="{{ old('bank_name') }}" 
                                                                   placeholder="Bank Name">
                                                            @error('bank_name')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Account Number</label>
                                                            <input type="text" 
                                                                   class="form-control @error('account_number') is-invalid @enderror" 
                                                                   name="account_number" 
                                                                   id="account_number"
                                                                   value="{{ old('account_number') }}" 
                                                                   placeholder="1234567890" 
                                                                   maxlength="10">
                                                            @error('account_number')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Account Name</label>
                                                            <input type="text" 
                                                                   class="form-control @error('account_name') is-invalid @enderror" 
                                                                   name="account_name" 
                                                                   id="account_name"
                                                                   value="{{ old('account_name') }}" 
                                                                   placeholder="Account holder name">
                                                            @error('account_name')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reason Section -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Reason for Withdrawal <span class="text-danger">*</span></label>
                                            <textarea class="form-control form-control-lg @error('reason') is-invalid @enderror" 
                                                      name="reason" 
                                                      rows="3" 
                                                      placeholder="Please provide a reason for this withdrawal request..." 
                                                      required>{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Fee Information -->
                                    <div class="col-12" id="fee-info">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">
                                                <em class="icon ni ni-info"></em>
                                                Fee Information
                                            </h6>
                                            <div id="fee-details">
                                                <p class="mb-0">Cash withdrawals have no processing fee</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="terms" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I understand that withdrawal requests require admin approval and may take 1-3 business days to process. 
                                                I confirm that the information provided is accurate.
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary w-100" id="submitBtn">
                                                <em class="icon ni ni-send"></em>
                                                <span>Submit Withdrawal Request</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Form initialized');
    
    // Toggle bank details based on payment method
    $('input[name="payment_method"]').on('change', function() {
        console.log('Payment method changed to:', $(this).val());
        
        const paymentMethod = $(this).val();
        const bankDetails = $('#bank-details');
        const feeDetails = $('#fee-details');
        
        if (paymentMethod === 'bank_transfer') {
            bankDetails.slideDown();
            // Make bank fields required
            $('#bank_name, #account_number, #account_name').prop('required', true);
            feeDetails.html('<p class="mb-0">Bank transfer withdrawals have no processing fee</p>');
        } else {
            bankDetails.slideUp();
            // Remove required from bank fields
            $('#bank_name, #account_number, #account_name').prop('required', false);
            feeDetails.html('<p class="mb-0">Cash withdrawals have no processing fee</p>');
        }
    });

    // Calculate and display estimated fee and net amount
    $('#amount, input[name="payment_method"]').on('input change', function() {
        const amount = parseFloat($('#amount').val()) || 0;
        const paymentMethod = $('input[name="payment_method"]:checked').val();
        
        if (amount > 0) {
            let fee = 0; // No fees for both methods as per your requirement
            const netAmount = amount - fee;
            const feeInfo = $('#fee-info');
            
            feeInfo.find('#fee-details').html(`
                <div class="row">
                    <div class="col-md-4">
                        <strong>Withdrawal Amount:</strong><br>
                        ₦${amount.toLocaleString('en-US', {minimumFractionDigits: 2})}
                    </div>
                    <div class="col-md-4">
                        <strong>Processing Fee:</strong><br>
                        ₦${fee.toLocaleString('en-US', {minimumFractionDigits: 2})}
                    </div>
                    <div class="col-md-4">
                        <strong>You'll Receive:</strong><br>
                        <span class="text-success">₦${netAmount.toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                    </div>
                </div>
            `);
        }
    });

    // Form validation and submission
    $('#withdrawalForm').on('submit', function(e) {
        console.log('Form submit triggered');
        
        const amount = parseFloat($('#amount').val()) || 0;
        const effectiveBalance = {{ $effectiveBalance }};
        const reason = $('#reason').val().trim();
        const termsChecked = $('#terms').is(':checked');
        const paymentMethod = $('input[name="payment_method"]:checked').val();
        
        console.log('Form validation:', {
            amount: amount,
            effectiveBalance: effectiveBalance,
            reason: reason,
            termsChecked: termsChecked,
            paymentMethod: paymentMethod
        });
        
        // Basic validation
        if (amount < 100) {
            e.preventDefault();
            alert('Minimum withdrawal amount is ₦100');
            return false;
        }
        
        if (amount > effectiveBalance) {
            e.preventDefault();
            alert('Withdrawal amount exceeds available balance');
            return false;
        }
        
        if (!reason) {
            e.preventDefault();
            alert('Please provide a reason for withdrawal');
            return false;
        }
        
        if (!termsChecked) {
            e.preventDefault();
            alert('Please accept the terms and conditions');
            return false;
        }
        
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method');
            return false;
        }
        
        // Bank transfer specific validation
        if (paymentMethod === 'bank_transfer') {
            const bankName = $('#bank_name').val().trim();
            const accountNumber = $('#account_number').val().trim();
            const accountName = $('#account_name').val().trim();
            
            if (!bankName || !accountNumber || !accountName) {
                e.preventDefault();
                alert('Please fill in all bank details for bank transfer');
                return false;
            }
            
            if (accountNumber.length < 10) {
                e.preventDefault();
                alert('Account number must be 10 digits');
                return false;
            }
        }
        
        console.log('Form validation passed, submitting...');
        
        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');
        
        // Allow form to submit
        return true;
    });

    // Account number validation (only numbers, max 10 digits)
    $('#account_number').on('input', function() {
        let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        $(this).val(value);
    });

    // Trigger initial payment method change to set up form correctly
    $('input[name="payment_method"]:checked').trigger('change');
    
    // Debug: Log form data before submission
    $('#withdrawalForm').on('submit', function() {
        const formData = new FormData(this);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });
});
</script>

@push('css')
<style>
/* Payment Method Styles */
.payment-method-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.payment-option {
    position: relative;
}

.payment-radio {
    position: absolute;
    opacity: 0;
    visibility: hidden;
}

.payment-label {
    cursor: pointer;
    margin-bottom: 0;
    display: block;
}

.payment-card {
    display: flex;
    align-items: center;
    padding: 20px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    background: #ffffff;
    transition: all 0.3s ease;
    position: relative;
}

.payment-card:hover {
    border-color: #007bff;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    transform: translateY(-2px);
}

.payment-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: #f8f9fa;
    margin-right: 15px;
    font-size: 20px;
}

.payment-content {
    flex: 1;
}

.payment-title {
    font-weight: 600;
    color: #495057;
    font-size: 16px;
}

.payment-description {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.4;
}

.payment-check {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #e9ecef;
    color: #ffffff;
    font-size: 14px;
    transition: all 0.3s ease;
}

/* Selected State */
.payment-radio:checked + .payment-label .payment-card {
    border-color: #007bff;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.2);
}

.payment-radio:checked + .payment-label .payment-check {
    background: #007bff;
    color: #ffffff;
}

.payment-radio:checked + .payment-label .payment-title {
    color: #007bff;
}

.payment-radio:checked + .payment-label .payment-icon {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #ffffff;
}

/* Focus State */
.payment-radio:focus + .payment-label .payment-card {
    outline: 2px solid #007bff;
    outline-offset: 2px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-method-container {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}

@media (max-width: 576px) {
    .payment-card {
        padding: 15px;
    }
    
    .payment-icon {
        width: 40px;
        height: 40px;
        margin-right: 12px;
        font-size: 18px;
    }
    
    .payment-title {
        font-size: 15px;
    }
    
    .payment-description {
        font-size: 13px;
    }
}

.display-6 {
    font-size: 2rem;
    font-weight: 600;
}

.card-amount .amount {
    font-weight: 700;
}

.input-group-lg .input-group-text {
    font-size: 1.125rem;
    font-weight: 600;
}

.alert-info {
    background-color: #e7f3ff;
    border-color: #b8daff;
    color: #0c5460;
}

.visually-hidden {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}
</style>
@endpush

@endsection