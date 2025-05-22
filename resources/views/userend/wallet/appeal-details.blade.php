@extends('userend.user_home')
@section('title', 'Appeal Details')
@section('user_content')

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Appeal Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.wallet.deposit') }}">Wallet</a></li>
                    <li class="breadcrumb-item active">Appeal Details</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa fa-file-alt mr-2"></i>Appeal Status</h5>
                        @if($deposit->appeal->status === 'pending')
                            <span class="badge badge-warning">Pending Review</span>
                        @elseif($deposit->appeal->status === 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($deposit->appeal->status === 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
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
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 300px;">
                                            {{ $deposit->tx_id }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ number_format($deposit->amount, 6) }} USDT</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                                </tr> <tr>
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
                    
                    <!-- Appeal Information -->
                    <div class="mb-4">
                        <h6 class="text-primary font-weight-bold mb-3">Appeal Information</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Appeal Date</th>
                                    <td>{{ $deposit->appeal->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($deposit->appeal->status === 'pending')
                                            <span class="badge badge-warning">Pending Review</span>
                                        @elseif($deposit->appeal->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($deposit->appeal->status === 'rejected')
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Your Reason</th>
                                    <td>{{ $deposit->appeal->reason }}</td>
                                </tr>
                                @if($deposit->appeal->status !== 'pending')
                                <tr>
                                    <th>Admin Response</th>
                                    <td>{{ $deposit->appeal->admin_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    <!-- Fee Information -->
                    <div class="mb-4">
                        <h6 class="text-primary font-weight-bold mb-3">Fee Information</h6>
                        <div class="alert alert-info">
                            <p class="mb-1">If your appeal is approved, a 20% fee will be deducted:</p>
                            <ul class="mb-0">
                                <li>Original Amount: <strong>{{ number_format($deposit->amount, 6) }} USDT</strong></li>
                                <li>Fee Amount (20%): <strong>{{ number_format($deposit->appeal->fee_amount, 6) }} USDT</strong></li>
                                <li>Amount to be Credited: <strong>{{ number_format($deposit->appeal->credited_amount, 6) }} USDT</strong></li>
                            </ul>
                        </div>
                    </div>
                    
                    @if($deposit->appeal->status === 'approved')
                    <div class="alert alert-success">
                        <h6 class="alert-heading font-weight-bold"><i class="fa fa-check-circle mr-1"></i> Appeal Approved</h6>
                        <p class="mb-0">Your appeal has been approved and <strong>{{ number_format($deposit->appeal->credited_amount, 6) }} USDT</strong> has been credited to your wallet after deducting the 20% fee.</p>
                    </div>
                    @elseif($deposit->appeal->status === 'rejected')
                    <div class="alert alert-danger">
                        <h6 class="alert-heading font-weight-bold"><i class="fa fa-times-circle mr-1"></i> Appeal Rejected</h6>
                        <p class="mb-0">Your appeal has been rejected. Please contact support if you have any questions.</p>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <h6 class="alert-heading font-weight-bold"><i class="fa fa-clock mr-1"></i> Appeal Under Review</h6>
                        <p class="mb-0">Your appeal is currently under review. We will notify you once a decision has been made.</p>
                    </div>
                    @endif
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('user.wallet.deposit') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-left mr-1"></i> Back to Deposits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection