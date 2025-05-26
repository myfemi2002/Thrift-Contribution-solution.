@extends('userend.user_home')
@section('title', 'Fund Wallet')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Fund Your Wallet</h3>
                    <div class="nk-block-des text-soft">
                        <p>Add money to your wallet using secure payment gateways</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.wallet.details') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Wallet</span>
                    </a>
                    <a href="{{ route('user.wallet.details') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Current Balance -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Current Wallet Balance</h5>
                                <div class="nk-block-des">
                                    <h2 class="text-primary mb-1">₦{{ number_format(Auth::user()->wallet->balance, 2) }}</h2>
                                    <p class="text-soft">Available for withdrawal or contributions</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="nk-block-head-content text-end">
                                <ul class="nk-list-plain">
                                    <li><strong>Total Contributions:</strong> ₦{{ number_format(Auth::user()->wallet->getActualTotalContributions(), 2) }}</li>
                                    <li><strong>Last Deposit:</strong> 
                                        @php
                                            $lastDeposit = Auth::user()->walletDeposits()->where('status', 'completed')->latest()->first();
                                        @endphp
                                        {{ $lastDeposit ? $lastDeposit->created_at->format('M d, Y') : 'None' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit Form -->
        <div class="nk-block">
            <div class="row g-gs justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Fund Wallet</h5>
                                <p class="card-text">Choose your preferred payment method and amount</p>
                            </div>
                            
                            <form id="depositForm">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Deposit Amount <span class="text-danger">*</span></label>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">₦</span>
                                                    </div>
                                                    <input type="number" name="amount" id="amount" class="form-control form-control-lg" 
                                                           placeholder="0.00" min="100" max="1000000" step="0.01" required>
                                                </div>
                                                <small class="form-text text-muted">Minimum: ₦100, Maximum: ₦1,000,000</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Amount Buttons -->
                                    <div class="col-12">
                                        <label class="form-label">Quick Amount Selection</label>
                                        <div class="btn-group-wrap">
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="1000">₦1,000</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="5000">₦5,000</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="10000">₦10,000</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="25000">₦25,000</button>
                                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="50000">₦50,000</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Gateway Selection -->
<div class="col-12">
    <div class="form-group">
        <label class="form-label">Payment Gateway <span class="text-danger">*</span></label>
        
        <div class="payment-gateways mt-3">
            <!-- Paystack Option -->
            <div class="gateway-card">
                <input type="radio" 
                       id="paystack" 
                       name="payment_gateway" 
                       value="paystack" 
                       class="gateway-radio" 
                       checked>
                <label for="paystack" class="gateway-label">
                    <div class="gateway-header">
                        <div class="gateway-icon paystack-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="gateway-info">
                            <h6 class="gateway-name">Paystack</h6>
                            <p class="gateway-description">Most popular choice</p>
                        </div>
                        <div class="gateway-check">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="gateway-details">
                        <div class="payment-methods">
                            <span class="method-tag">
                                <i class="fab fa-cc-visa"></i> Cards
                            </span>
                            <span class="method-tag">
                                <i class="fas fa-university"></i> Transfer
                            </span>
                            <span class="method-tag">
                                <i class="fas fa-mobile-alt"></i> USSD
                            </span>
                        </div>
                        <div class="gateway-fee">
                            <span class="fee-label">Transaction Fee:</span>
                            <span class="fee-amount">1.5% + ₦100</span>
                        </div>
                    </div>
                </label>
            </div>

            <!-- Flutterwave Option -->
            <div class="gateway-card mt-3">
                <input type="radio" 
                       id="flutterwave" 
                       name="payment_gateway" 
                       value="flutterwave" 
                       class="gateway-radio">
                <label for="flutterwave" class="gateway-label">
                    <div class="gateway-header">
                        <div class="gateway-icon flutterwave-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="gateway-info">
                            <h6 class="gateway-name">Flutterwave</h6>
                            <p class="gateway-description">Lower fees available</p>
                        </div>
                        <div class="gateway-check">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="gateway-details">
                        <div class="payment-methods">
                            <span class="method-tag">
                                <i class="fab fa-cc-mastercard"></i> Cards
                            </span>
                            <span class="method-tag">
                                <i class="fas fa-university"></i> Transfer
                            </span>
                            <span class="method-tag">
                                <i class="fas fa-wallet"></i> Mobile Money
                            </span>
                        </div>
                        <div class="gateway-fee">
                            <span class="fee-label">Transaction Fee:</span>
                            <span class="fee-amount">1.4%</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>



                                    <!-- Fee Calculation -->
                                    <div class="col-12" id="feeCalculation" style="display: none;">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">Transaction Summary</h6>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <strong>Amount:</strong><br>
                                                    <span id="summaryAmount">₦0.00</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <strong>Gateway Fee:</strong><br>
                                                    <span id="summaryFee">₦0.00</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <strong>You'll Receive:</strong><br>
                                                    <span id="summaryCredit" class="text-success fw-bold">₦0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block" id="proceedBtn">
                                                <em class="icon ni ni-wallet-in"></em>
                                                <span>Proceed to Payment</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-inner">
                            <h6 class="card-title">Security Notice</h6>
                            <ul class="list list-sm list-checked">
                                <li>All transactions are secured with SSL encryption</li>
                                <li>We never store your card details</li>
                                <li>Funds are credited instantly upon successful payment</li>
                                <li>You'll receive email confirmation for all transactions</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-inner">
                            <h6 class="card-title">Supported Payment Methods</h6>
                            <div class="payment-methods">
                                <div class="pm-item">
                                    <em class="icon ni ni-cc-visa"></em>
                                    <span>Visa</span>
                                </div>
                                <div class="pm-item">
                                    <em class="icon ni ni-cc-mastercard"></em>
                                    <span>Mastercard</span>
                                </div>
                                <div class="pm-item">
                                    <em class="icon ni ni-building"></em>
                                    <span>Bank Transfer</span>
                                </div>
                                <div class="pm-item">
                                    <em class="icon ni ni-mobile"></em>
                                    <span>USSD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Quick amount selection
    $('.quick-amount').on('click', function() {
        const amount = $(this).data('amount');
        $('#amount').val(amount);
        calculateFees();
        $(this).addClass('active').siblings().removeClass('active');
    });

    // Calculate fees when amount or gateway changes
    $('#amount, input[name="payment_gateway"]').on('input change', calculateFees);

    function calculateFees() {
        const amount = parseFloat($('#amount').val()) || 0;
        const gateway = $('input[name="payment_gateway"]:checked').val();
        
        if (amount >= 100) {
            let feeRate = gateway === 'paystack' ? 0.015 : 0.014;
            let fixedFee = gateway === 'paystack' ? 100 : 0;
            let fee = (amount * feeRate) + fixedFee;
            let credited = amount - fee;
            
            $('#summaryAmount').text('₦' + amount.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#summaryFee').text('₦' + fee.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#summaryCredit').text('₦' + credited.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#feeCalculation').show();
        } else {
            $('#feeCalculation').hide();
        }
    }

    // Form submission
    $('#depositForm').on('submit', function(e) {
        e.preventDefault();
        
        const amount = parseFloat($('#amount').val());
        
        if (amount < 100) {
            Swal.fire('Error', 'Minimum deposit amount is ₦100', 'error');
            return;
        }
        
        if (amount > 1000000) {
            Swal.fire('Error', 'Maximum deposit amount is ₦1,000,000', 'error');
            return;
        }

        // Show loading
        $('#proceedBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

        $.ajax({
            url: "{{ route('user.wallet.deposit.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Redirect to payment gateway
                    window.location.href = response.payment_url;
                } else {
                    Swal.fire('Error', response.message || 'Failed to initialize payment', 'error');
                }
            },
            error: function(xhr) {
                let message = 'An error occurred';
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire('Error', message, 'error');
            },
            complete: function() {
                $('#proceedBtn').prop('disabled', false).html('<em class="icon ni ni-wallet-in"></em><span>Proceed to Payment</span>');
            }
        });
    });
});
</script>

@push('css')
<style>
.payment-methods {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.pm-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem;
    border: 1px solid #e3e7fe;
    border-radius: 0.375rem;
    background: #f8f9fa;
}

.pm-item .icon {
    font-size: 1.25rem;
    color: #526484;
}

.quick-amount.active {
    background-color: #6366f1;
    color: white;
    border-color: #6366f1;
}

.btn-group-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.custom-control-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
}

.custom-control-input {
    position: absolute;
    left: 0;
    z-index: -1;
    width: 1rem;
    height: 1.25rem;
    opacity: 0;
}

.custom-control-label {
    position: relative;
    margin-bottom: 0;
    vertical-align: top;
}

.custom-control-label::before {
    position: absolute;
    top: 0.25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    pointer-events: none;
    content: "";
    background-color: #fff;
    border: #adb5bd solid 1px;
}

.custom-radio .custom-control-label::before {
    border-radius: 50%;
}

.custom-control-input:checked ~ .custom-control-label::after {
    opacity: 1;
}

.custom-control-label::after {
    position: absolute;
    top: 0.25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    content: "";
    background: no-repeat 50%/50% 50%;
    opacity: 0;
}

.custom-radio .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #007bff;
    border-color: #007bff;
}

.custom-radio .custom-control-input:checked ~ .custom-control-label::after {
    background-image: radial-gradient(circle, #fff 50%, transparent 50%);
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 10px;
}

.btn-block {
    width: 100%;
}

.list-checked li {
    position: relative;
    padding-left: 1.5rem;
}

.list-checked li::before {
    position: absolute;
    left: 0;
    top: 0.125rem;
    content: "✓";
    color: #28a745;
    font-weight: bold;
}

.alert-heading {
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .payment-methods {
        grid-template-columns: 1fr;
    }
    
    .quick-amount {
        flex: 1;
        min-width: 80px;
    }
    
    .text-end {
        text-align: left !important;
    }
}
</style>
@endpush

@endsection