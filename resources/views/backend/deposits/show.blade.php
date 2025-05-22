@extends('admin.admin_master')
@section('title', 'Deposit Details')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Deposit Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Alert Messages -->
    @if(session('message'))
    <div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Left Column - Deposit Details -->
        <div class="col-lg-8">
            <!-- Deposit Info Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Deposit Information
                    </h4>
                    <div>
                        @if($deposit->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($deposit->status === 'confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($deposit->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">Deposit ID</span>
                                <h5>#{{ $deposit->id }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">Amount</span>
                                <h5>{{ number_format($deposit->amount, 6) }} USDT</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">Date</span>
                                <h5>{{ $deposit->created_at->format('M d, Y H:i:s') }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">User</span>
                                <h5>{{ $deposit->user->name }}</h5>
                                <span class="text-muted">{{ $deposit->user->email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Transaction Details</h5>
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
                            <div>
                                <span class="text-muted d-block mb-1">Mother Wallet Address</span>
                                <span>{{ $deposit->user->wallet->motherWallet->wallet_address ?? 'Not assigned' }}</span>
                            </div>
                        </div>
                    </div>

                    @if($deposit->notes)
                    <div class="mt-4">
                        <h5 class="fw-bold mb-2">Notes</h5>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($deposit->notes)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($deposit->status === 'pending')
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Actions</h5>
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('admin.deposits.confirm-approve', $deposit->id) }}" class="btn btn-success me-2 mb-2">
                                <i class="fa fa-check me-1"></i> Approve
                            </a>
                            <a href="{{ route('admin.deposits.confirm-verify', $deposit->id) }}" class="btn btn-warning me-2 mb-2">
                                <i class="fa fa-refresh me-1"></i> Verify on Blockchain
                            </a>
                            <a href="{{ route('admin.deposits.confirm-reject', $deposit->id) }}" class="btn btn-danger mb-2">
                                <i class="fa fa-ban me-1"></i> Reject
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Blockchain Information Card -->
            @if(isset($blockchainInfo) && $blockchainInfo)
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">Blockchain Verification</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <i class="fa fa-info-circle me-2"></i>
                        Transaction details from the blockchain are displayed below.
                    </div>
                    <pre class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">{{ json_encode($blockchainInfo, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Right Column - User Info & Screenshot -->
        <div class="col-lg-4">
            <!-- User Wallet Card -->
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-user-circle me-2"></i>User Wallet
                    </h4>
                </div>
                <div class="card-body">
                    @if($deposit->user->wallet)
                    <div class="text-center mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            <span class="initials">{{ substr($deposit->user->name, 0, 1) }}</span>
                        </div>
                        <h5 class="mb-1">{{ $deposit->user->name }}</h5>
                        <p class="text-muted">{{ $deposit->user->email }}</p>
                    </div>
                    
                    <div class="wallet-info">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Current Balance:</span>
                            <span class="fw-bold">{{ number_format($deposit->user->wallet->balance, 6) }} USDT</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Wallet Created:</span>
                            <span>{{ $deposit->user->wallet->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-primary w-100">
                            <i class="fa fa-user me-1"></i> View User Profile
                        </a>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        This user does not have a wallet.
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Screenshot Card -->
            @if($deposit->screenshot_path)
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-image me-2"></i>Transaction Screenshot
                    </h4>
                </div>
                <div class="card-body text-center p-2">
                    <div class="screenshot-container position-relative">
                        <img src="{{ asset($deposit->screenshot_path) }}" alt="Transaction Screenshot" class="img-fluid rounded">
                        <a href="{{ asset($deposit->screenshot_path) }}" target="_blank" class="btn btn-sm btn-light position-absolute" style="top: 10px; right: 10px;">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Transaction History Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-history me-2"></i>Recent Deposits
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentDeposits) && count($recentDeposits) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDeposits as $recentDeposit)
                                <tr>
                                    <td>{{ $recentDeposit->created_at->format('M d') }}</td>
                                    <td>{{ number_format($recentDeposit->amount, 2) }}</td>
                                    <td>
                                        @if($recentDeposit->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($recentDeposit->status === 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($recentDeposit->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-3 text-center text-muted">
                        No recent deposits found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .avatar-circle {
        width: 60px;
        height: 60px;
        background-color: #f5f5f5;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .initials {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    
    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.2);
    }
    
    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.2);
    }
    
    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.2);
    }
    
    .screenshot-container {
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .wallet-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
    }
</style>
@endpush

@endsection