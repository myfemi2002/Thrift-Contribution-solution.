@extends('userend.user_home')
@section('title', 'Deposit USDT')
@section('user_content')


<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Deposit USDT</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Wallet</a></li>
                    <li class="breadcrumb-item active">Deposit USDT</li>
                </ul>
            </div>
        </div>
    </div>


    
    <div class="row">
        <!-- Left Column - QR Code and Address -->
        <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-qrcode mr-2"></i>USDT Wallet Address</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="qr-code-container bg-white p-3 border rounded mb-4">
                        {!! QrCode::size(200)->generate($walletAddress) !!}
                    </div>
                    
                    <div class="wallet-address-container w-100">
                        <label class="font-weight-bold text-muted small mb-1">TRC20 USDT Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $walletAddress }}" id="wallet-address" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" id="copyAddressBtn" onclick="copyAddress()">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div id="copySuccess" class="text-success small mt-2 d-none">
                            <i class="fa fa-check-circle"></i> Address copied!
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-4 w-100">
                        <h6 class="alert-heading font-weight-bold"><i class="fa fa-exclamation-triangle mr-1"></i> Important!</h6>
                        <p class="mb-0 small">Only send USDT (TRC20) to this address. Other tokens may be permanently lost.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Deposit Form -->
        <div class="col-lg-8">
            <!-- Steps Guide -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fa fa-info-circle mr-2"></i>How to Deposit</h5>
                </div>
                <div class="card-body">
                    <div class="deposit-steps">
                        <div class="row">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <div class="step-item text-center">
                                    <div class="step-icon mb-2">
                                        <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fa fa-wallet fa-lg"></i>
                                        </span>
                                    </div>
                                    <h6 class="step-title">Copy Address</h6>
                                    <p class="step-desc small text-muted">Copy the TRC20 wallet address</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <div class="step-item text-center">
                                    <div class="step-icon mb-2">
                                        <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fa fa-paper-plane fa-lg"></i>
                                        </span>
                                    </div>
                                    <h6 class="step-title">Send USDT</h6>
                                    <p class="step-desc small text-muted">Send USDT from your wallet</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <div class="step-item text-center">
                                    <div class="step-icon mb-2">
                                        <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fa fa-receipt fa-lg"></i>
                                        </span>
                                    </div>
                                    <h6 class="step-title">Get TXID</h6>
                                    <p class="step-desc small text-muted">Copy transaction hash</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="step-item text-center">
                                    <div class="step-icon mb-2">
                                        <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fa fa-check-circle fa-lg"></i>
                                        </span>
                                    </div>
                                    <h6 class="step-title">Confirm</h6>
                                    <p class="step-desc small text-muted">Submit transaction details</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Deposit Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-file-invoice mr-2"></i>Transaction Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.wallet.verify-deposit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="tx_id">Transaction Hash (TXID) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tx_id') is-invalid @enderror" id="tx_id" name="tx_id" value="{{ old('tx_id') }}" placeholder="Enter the transaction hash/ID from your wallet" required>
                            <small class="form-text text-muted"><i class="fa fa-info-circle"></i> This is the unique identifier for your transaction</small>
                            @error('tx_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="amount">Amount Sent (USDT) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.000001" min="10" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" placeholder="0.00" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">USDT</span>
                                </div>
                            </div>
                            <small class="form-text text-muted"><i class="fa fa-info-circle"></i> Enter the exact amount you transferred</small>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="screenshot">Transaction Screenshot (Optional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('screenshot') is-invalid @enderror" id="screenshot" name="screenshot">
                                <label class="custom-file-label" for="screenshot">Choose file</label>
                            </div>
                            <small class="form-text text-muted"><i class="fa fa-info-circle"></i> Accepted formats: JPEG, PNG, JPG (Max: 2MB)</small>
                            @error('screenshot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fa fa-check-circle mr-2"></i> Submit Deposit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    @if(count($recentDeposits) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa fa-history mr-2"></i>Recent Deposits</h5>
                        @if(count($recentDeposits) > 5)
                            <a href="{{ route('user.wallet.transactions') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        @endif
                           
    <!-- Add the Transaction History button here -->
    <div class="text-end mb-3">
        <a href="{{ route('user.wallet.deposit.transaction-logs') }}" class="btn btn-outline-primary">
            <i class="fa fa-history mr-1"></i> View Transaction History
        </a>
    </div>
                    </div> 
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDeposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $deposit->tx_id }}">
                                            {{ Str::limit($deposit->tx_id, 15) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($deposit->amount, 6) }} USDT</td>
                                    <td>
                                        @if($deposit->status === 'pending')
                                            <span style="background-color: #ffc107; color: #212529; padding: 0.25em 0.6em; border-radius: 0.25rem;">Pending</span>
                                        @elseif($deposit->status === 'confirmed')
                                            <span style="background-color: #28a745; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem;">Confirmed</span>
                                        @elseif($deposit->status === 'rejected')
                                            <span style="background-color: #dc3545; color: #fff; padding: 0.25em 0.6em; border-radius: 0.25rem;">Rejected</span>
                                        @endif
                                    </td>

                                                                        <!-- In your deposit list view -->
                                    <td>
                                        @if($deposit->status === 'rejected')
                                            @if(empty($deposit->appeal_status))
                                                @php
                                                    $canAppeal = false;
                                                    $amountKeywords = ['amount mismatch', 'actual amount', 'claimed', 'actual', 'different amount'];
                                                    foreach ($amountKeywords as $keyword) {
                                                        if (stripos($deposit->notes, $keyword) !== false) {
                                                            $canAppeal = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                
                                                @if($canAppeal)
                                                    <a href="{{ route('user.wallet.deposit.appeal.form', $deposit->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-file-alt mr-1"></i> Appeal
                                                    </a>
                                                @endif
                                            @elseif($deposit->appeal_status === 'pending')
                                                <a href="{{ route('user.wallet.deposit.appeal.view', $deposit->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa fa-eye mr-1"></i> View Appeal
                                                </a>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $recentDeposits->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('css')
<style>
    .qr-code-container {
        border: 1px dashed #ddd;
    }
    
    .deposit-steps .step-item {
        position: relative;
    }
    
    .deposit-steps .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 25px;
        right: -50%;
        width: 100%;
        height: 2px;
        background-color: #e9ecef;
        z-index: 0;
    }
    
    @media (max-width: 767px) {
        .deposit-steps .step-item:not(:last-child)::after {
            display: none;
        }
    }
    
    .custom-file-label::after {
        content: "Browse";
    }
</style>
@endpush

@push('scripts')

<script>
    function copyAddress() {
        var walletAddress = document.getElementById('wallet-address');
        walletAddress.select();
        walletAddress.setSelectionRange(0, 99999); // For mobile devices
        
        navigator.clipboard.writeText(walletAddress.value).then(function() {
            // Show success message
            var copySuccess = document.getElementById('copySuccess');
            copySuccess.classList.remove('d-none');
            
            // Change button text
            var copyBtn = document.getElementById('copyAddressBtn');
            copyBtn.innerHTML = '<i class="fa fa-check"></i>';
            copyBtn.classList.remove('btn-outline-primary');
            copyBtn.classList.add('btn-success');
            
            // Reset after 3 seconds
            setTimeout(function() {
                copySuccess.classList.add('d-none');
                copyBtn.innerHTML = '<i class="fa fa-copy"></i>';
                copyBtn.classList.remove('btn-success');
                copyBtn.classList.add('btn-outline-primary');
            }, 3000);
        }, function() {
            alert('Failed to copy wallet address. Please copy it manually.');
        });
    }
    
    // For custom file input
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush

@endsection