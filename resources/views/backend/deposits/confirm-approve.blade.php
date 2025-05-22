@extends('admin.admin_master')
@section('title', 'Confirm Deposit Approval')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Confirm Deposit Approval</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.show', $deposit->id) }}">Details</a></li>
                    <li class="breadcrumb-item active">Confirm Approval</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="card-title mb-0">Confirm Deposit Approval</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle bg-success-light mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fa fa-check text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4>Confirm Approval</h4>
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="fa fa-info-circle me-2"></i>
                        You are about to approve the deposit #{{ $deposit->id }} for user {{ $deposit->user->name }}. This action will credit the user's wallet with the specified amount.
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
                                    <span class="text-muted mb-1">Amount</span>
                                    <h5 class="text-success">{{ number_format($deposit->amount, 6) }} USDT</h5>
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

                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('admin.deposits.show', $deposit->id) }}" class="btn btn-secondary me-3">
                            <i class="fa fa-arrow-left me-1"></i> Cancel
                        </a>
                        <form action="{{ route('admin.deposits.approve', $deposit->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check me-1"></i> Confirm Approval
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
    
    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.2);
    }
</style>
@endpush

@endsection