@extends('admin.admin_master')
@section('title', 'Appeal Details')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Appeal Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.appeals') }}">Appeals</a></li>
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
        <!-- Left Column - Appeal Details -->
        <div class="col-lg-8">
            <!-- Appeal Info Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Appeal Information
                    </h4>
                    <div>
                        @if($appeal->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($appeal->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($appeal->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">Appeal ID</span>
                                <h5>#{{ $appeal->id }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">Deposit ID</span>
                                <h5>#{{ $appeal->deposit->id }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">Submitted Date</span>
                                <h5>{{ $appeal->created_at->format('M d, Y H:i:s') }}</h5>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex flex-column">
                                <span class="text-muted mb-1">User</span>
                                <h5>{{ $appeal->deposit->user->name }}</h5>
                                <span class="text-muted">{{ $appeal->deposit->user->email }}</span>
                            </div>
                        </div>
                    </div>

<!-- Update in admin-appeal-show-view.blade.php -->
<div class="mt-4">
    <h5 class="fw-bold mb-3">Fee Information</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>User Claimed Amount</th>
                <td>{{ number_format($appeal->deposit->amount, 6) }} USDT</td>
            </tr>
            <tr class="table-primary">
                <th>Actual Blockchain Amount</th>
                <td class="fw-bold">{{ number_format($actualAmount, 6) }} USDT</td>
            </tr>
            <tr>
                <th>Fee Amount (20% of Actual)</th>
                <td>{{ number_format($feeAmount, 6) }} USDT</td>
            </tr>
            <tr>
                <th>Amount to be Credited</th>
                <td class="text-success fw-bold">{{ number_format($creditedAmount, 6) }} USDT</td>
            </tr>
        </table>
    </div>
</div>

                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">User's Appeal Reason</h5>
                        <div class="bg-light p-3 rounded">
                            {{ $appeal->reason }}
                        </div>
                    </div>

                    @if($appeal->status !== 'pending')
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Admin Response</h5>
                        <div class="bg-light p-3 rounded">
                            {{ $appeal->admin_notes }}
                        </div>
                    </div>
                    @endif
                    
                    @if($appeal->status === 'pending')
                    <div class="mt-4" id="approve">
                        <h5 class="fw-bold mb-3">Review Appeal</h5>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                <i class="fa fa-check me-1"></i> Approve Appeal
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fa fa-ban me-1"></i> Reject Appeal
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Transaction Info Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">Transaction Details</h4>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                        <div class="mb-3">
                            <span class="text-muted d-block mb-1">Transaction ID</span>
                            <div class="d-flex align-items-center">
                                <span class="fw-medium" id="tx_id">{{ $appeal->deposit->tx_id }}</span>
                                <button class="btn btn-sm btn-link ms-2" onclick="window.navigator.clipboard.writeText('{{ $appeal->deposit->tx_id }}');alert('Transaction ID copied to clipboard');">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a href="https://tronscan.org/#/transaction/{{ $appeal->deposit->tx_id }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-external-link me-1"></i> View on Tronscan
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5 class="fw-bold mb-2">Deposit Rejection Reason</h5>
                        <div class="alert alert-danger">
                            {!! nl2br(e($appeal->deposit->notes)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - User Info -->
        <div class="col-lg-4">
            <!-- User Wallet Card -->
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-user-circle me-2"></i>User Information
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            <span class="initials">{{ substr($appeal->deposit->user->name, 0, 1) }}</span>
                        </div>
                        <h5 class="mb-1">{{ $appeal->deposit->user->name }}</h5>
                        <p class="text-muted">{{ $appeal->deposit->user->email }}</p>
                    </div>
                    
                    <div class="wallet-info">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Current Balance:</span>
                            <span class="fw-bold">{{ number_format($appeal->deposit->user->wallet->balance ?? 0, 6) }} USDT</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">User ID:</span>
                            <span>#{{ $appeal->deposit->user->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Screenshot Card (if available) -->
            @if($appeal->deposit->screenshot_path)
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-image me-2"></i>Transaction Screenshot
                    </h4>
                </div>
                <div class="card-body text-center p-2">
                    <div class="screenshot-container position-relative">
                        <img src="{{ asset($appeal->deposit->screenshot_path) }}" alt="Transaction Screenshot" class="img-fluid rounded">
                        <a href="{{ asset($appeal->deposit->screenshot_path) }}" target="_blank" class="btn btn-sm btn-light position-absolute" style="top: 10px; right: 10px;">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Appeal Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Confirm Appeal Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.deposits.appeals.approve', $appeal->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-success-light mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fa fa-check text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    
                    <p>Are you sure you want to approve this appeal? <strong> (after 20% fee deduction)</strong> .</p>
                    
                    <div class="alert alert-info">
                        <h6 class="alert-heading fw-bold">Fee Breakdown:</h6>
                        <ul class="mb-0">
                            <li>User Claimed Amount: {{ number_format($appeal->deposit->amount, 6) }} USDT</li>
                            <li>Actual Blockchain Amount: {{ number_format($actualAmount, 6) }} USDT <strong class="text-primary">(Used for fee calculation)</strong></li>
                            <li>Fee Amount (20%): {{ number_format($feeAmount, 6) }} USDT</li>
                            <li>Amount to be Credited: {{ number_format($creditedAmount, 6) }} USDT</li>
                        </ul>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_notes">Admin Notes</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">Appeal approved. 20% fee has been applied to the deposited amount.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check me-1"></i> Approve Appeal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Appeal Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Confirm Appeal Rejection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.deposits.appeals.reject', $appeal->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-danger-light mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fa fa-times text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                    
                    <p>Are you sure you want to reject this appeal? This action cannot be undone.</p>
                    
                    <div class="form-group">
                        <label for="admin_notes">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror" id="admin_notes" name="admin_notes" rows="3" required></textarea>
                        <small class="form-text text-muted">Please provide a clear reason for rejecting this appeal.</small>
                        @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-ban me-1"></i> Reject Appeal
                    </button>
                </div>
            </form>
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