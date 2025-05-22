@extends('admin.admin_master')
@section('title', 'Mother Wallet Management')
@section('admin')

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Mother Wallet Management</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Mother Wallets</li>
                </ul>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="{{ route('admin.wallets.mother.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Wallet
                </a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-md-12">
            <!-- Stats Cards Row -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <h3>{{ $motherWallets->total() }}</h3>
                                <span>Total Wallets</span>
                            </div>
                            <div class="dash-widget-icon">
                                <i class="fa fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <h3>{{ $motherWallets->where('is_active', 1)->count() }}</h3>
                                <span>Active Wallets</span>
                            </div>
                            <div class="dash-widget-icon bg-success">
                                <i class="fa fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dash-widget">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <h3>{{ $motherWallets->where('is_active', 0)->count() }}</h3>
                                <span>Inactive Wallets</span>
                            </div>
                            <div class="dash-widget-icon bg-danger">
                                <i class="fa fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Stats Cards Row -->

            <!-- Mother Wallets List -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title mb-0">TRON Wallet Addresses</h4>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('admin.wallets.mother.index') }}" method="GET">
                                <div class="form-group mb-0">
                                    <input type="text" name="search" class="form-control" placeholder="Search wallet address..." value="{{ request('search') }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="45%">Wallet Address</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Created At</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($motherWallets as $wallet)
                                <tr>
                                    <td>{{ $wallet->id }}</td>
                                    <td>
                                        <div class="wallet-address-container">
                                            <span class="wallet-text text-truncate" style="max-width: 250px;" title="{{ $wallet->wallet_address }}">
                                                {{ $wallet->wallet_address }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.wallets.mother.update', $wallet->id) }}" method="POST" class="status-form">
                                            @csrf
                                            <input type="hidden" name="wallet_address" value="{{ $wallet->wallet_address }}">
                                            <input type="hidden" name="is_active" value="{{ $wallet->is_active ? '0' : '1' }}">
                                            <button type="submit" class="btn btn-sm {{ $wallet->is_active ? 'btn-success' : 'btn-danger' }}">
                                                {{ $wallet->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $wallet->created_at->format('M d, Y') }}</td>
                                    
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.wallets.mother.edit', $wallet->id) }}" 
                                               class="btn btn-sm btn-primary me-2 text-white">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            
                                            <!-- Delete Button -->
                                            <a href="{{ route('admin.wallets.mother.delete', $wallet->id) }}" 
                                               class="btn btn-sm btn-danger text-white" id="delete">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="p-4 text-muted">
                                            <i class="fa fa-wallet fa-3x mb-3"></i>
                                            <p>No wallet addresses found</p>
                                            <a href="{{ route('admin.wallets.mother.create') }}" class="btn btn-sm btn-primary">
                                                Add New Wallet
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $motherWallets->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            <!-- /Mother Wallets List -->
        </div>
    </div>
</div>

@push('css')
<style>
    .wallet-address-container {
        position: relative;
    }
    
    .wallet-text {
        font-family: monospace;
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #e3e3e3;
        display: inline-block;
    }
    
    .dash-widget-icon {
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        background: #e9ecef;
        position: absolute;
        right: 15px;
        top: 15px;
    }
    
    .dash-widget-info {
        padding-right: 70px;
    }
    
    .dash-widget-info h3 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .dash-widget-info span {
        color: #6c757d;
        font-size: 16px;
    }
    
    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }
    
    .status-form button {
        min-width: 80px;
    }
</style>
@endpush

@endsection