@extends('admin.admin_master')
@section('title', 'Confirm Blockchain Verification')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Confirm Blockchain Verification</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.show', $deposit->id) }}">Details</a></li>
                    <li class="breadcrumb-item active">Confirm Verification</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Confirm Blockchain Verification</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-info-light mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fa fa-refresh text-info" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4>Verify Transaction on Blockchain</h4>
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="fa fa-info-circle me-2"></i>
                        This will verify the transaction on the TRON blockchain and automatically approve or reject the deposit based on the verification results.
                    </div>

                    <div class="deposit-details mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex flex-column">
                                    <span class="text-muted mb-1">Deposit ID</span>
                                    <h5>#{{ $deposit->id }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex flex-column">
                                    <span class="text-muted mb-1">User</span>
                                    <h5>{{ $deposit->user->name }}</h5>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex flex-column">
                                    <span class="text-muted mb-1">Amount (Declared)</span>
                                    <h5>{{ number_format($deposit->amount, 6) }} USDT</h5>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex flex-column">
                                    <span class="text-muted mb-1">Date</span>
                                    <h5>{{ $deposit->created_at->format('M d, Y H:i') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="transaction-details mb-4">
                        <h5 class="mb-3">Transaction Details</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="mb-3">
                                <span class="text-muted d-block mb-1">Transaction ID</span>
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium">{{ $deposit->tx_id }}</span>
                                    <button class="btn btn-sm btn-link ms-2" onclick="window.navigator.clipboard.writeText('{{ $deposit->tx_id }}');alert('Transaction ID copied to clipboard');">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <a href="https://tronscan.org/#/transaction/{{ $deposit->tx_id }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-external-link me-1"></i> View on Tronscan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="verification-note mb-4">
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle me-2"></i>
                            <strong>Note:</strong> The system will verify the following:
                            <ul class="mb-0 mt-2">
                                <li>Transaction exists on the blockchain</li>
                                <li>Transaction was successful</li>
                                <li>Funds were sent to the correct wallet address</li>
                                <li>The amount matches the declared amount</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('admin.deposits.show', $deposit->id) }}" class="btn btn-secondary me-3">
                            <i class="fa fa-arrow-left me-1"></i> Cancel
                        </a>
                        <form action="{{ route('admin.deposits.verify-blockchain', $deposit->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-refresh me-1"></i> Proceed with Verification
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .avatar-circle {
        background-color: #f5f5f5;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.2);
    }
</style>
@endpush

@endsection