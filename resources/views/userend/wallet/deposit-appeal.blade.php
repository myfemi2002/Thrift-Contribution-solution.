@extends('userend.user_home')
@section('title', 'Appeal Deposit Rejection')
@section('user_content')

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Appeal Deposit Rejection</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.wallet.deposit') }}">Wallet</a></li>
                    <li class="breadcrumb-item active">Appeal Rejection</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-file-alt mr-2"></i>Deposit Appeal Form</h5>
                </div>
                <div class="card-body">
                    <!-- Alert about fee -->
                    <!-- Update the fee notice section -->
                    <div class="alert alert-warning mb-4">
                        <h6 class="alert-heading font-weight-bold"><i class="fa fa-exclamation-triangle mr-1"></i> Important Fee Notice</h6>
                        <p class="mb-1">If your appeal is approved, a <strong>20% fee</strong> will be charged on the verified amount from the blockchain.</p>
                        <ul class="mb-0">
                            <li>Amount You Claimed: <strong>{{ number_format($deposit->amount, 6) }} USDT</strong></li>
                            <li>Actual Amount (From Blockchain): <strong>{{ number_format($actualAmount, 6) }} USDT</strong></li>
                            <li>Fee Amount (20%): <strong>{{ number_format($feeAmount, 6) }} USDT</strong></li>
                            <li>You Will Receive: <strong>{{ number_format($creditedAmount, 6) }} USDT</strong></li>
                        </ul>
                    </div>
                    
                    <!-- Deposit Information -->
                    <div class="mb-4">
                        <h6 class="text-primary font-weight-bold mb-3">Deposit Information</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Deposit ID</th>
                                    <td>#{{ $deposit->id }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction ID</th>
                                    <td>{{ $deposit->tx_id }}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ number_format($deposit->amount, 6) }} USDT</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Rejection Reason</th>
                                    <td>
                                        <div class="rejection-details">
                                            @php
                                                $notes = $deposit->notes;
                                                $claimedAmount = $deposit->amount;
                                                $actualAmount = $claimedAmount;
                                                
                                                // Extract actual amount from notes
                                                if (preg_match('/actual\s+(\d+(\.\d+)?)/i', $notes, $matches)) {
                                                    $actualAmount = floatval($matches[1]);
                                                }
                                                
                                                // Format the rejection reason for better display
                                                $formattedReason = "Amount mismatch detected during verification";
                                            @endphp
                                            
                                            <div class="text-danger mb-2">{{ $formattedReason }}</div>
                                            
                                            <div class="amounts-comparison">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="amount-card bg-light p-2 rounded border">
                                                            <div class="text-muted small">You Claimed:</div>
                                                            <div class="font-weight-bold">{{ number_format($claimedAmount, 6) }} USDT</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="amount-card bg-light p-2 rounded border">
                                                            <div class="text-muted small">Blockchain Verified:</div>
                                                            <div class="font-weight-bold">{{ number_format($actualAmount, 6) }} USDT</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($deposit->appeal_status === 'approved')
                                                <div class="appeal-result mt-2 p-2 bg-success-light rounded">
                                                    <div class="mb-1"><i class="fa fa-check-circle text-success mr-1"></i> <span class="font-weight-bold">Appeal Approved</span></div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="text-muted small">Actual Amount:</div>
                                                            <div>{{ number_format($actualAmount, 6) }} USDT</div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-muted small">Fee (20%):</div>
                                                            <div>{{ number_format($actualAmount * 0.2, 6) }} USDT</div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-muted small">Credited:</div>
                                                            <div class="font-weight-bold">{{ number_format($actualAmount * 0.8, 6) }} USDT</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Appeal Form -->
                    <form action="{{ route('user.wallet.deposit.appeal.submit', $deposit->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="reason">Appeal Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="5" placeholder="Please explain why you believe this deposit should be approved..." required>{{ old('reason') }}</textarea>
                            <small class="form-text text-muted">Provide clear and concise information about why you believe this deposit should be approved.</small>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input @error('acknowledge_fee') is-invalid @enderror" id="acknowledge_fee" name="acknowledge_fee" required>
                                <label class="custom-control-label" for="acknowledge_fee">
                                    I acknowledge that a 20% fee ({{ number_format($feeAmount, 6) }} USDT) will be charged if my appeal is approved.
                                </label>
                                @error('acknowledge_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group mt-4 text-center">
                            <a href="{{ route('user.wallet.deposit') }}" class="btn btn-secondary mr-2">
                                <i class="fa fa-arrow-left mr-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane mr-1"></i> Submit Appeal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection