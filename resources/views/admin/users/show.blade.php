@extends('admin.admin_master')
@section('title', 'User Details')
@section('admin')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Back
        </a>
    </div>

    <div class="row">
        <!-- User Information Card -->
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($user->photo)
                            <img class="img-profile rounded-circle mb-3" width="100" src="{{ asset($user->photo) }}" alt="User">
                        @else
                            <div class="avatar-placeholder mb-3">{{ substr($user->name, 0, 1) }}</div>
                        @endif
                        <h5 class="mb-0">{{ $user->name }}</h5>
                        <div class="text-muted mb-2">{{ $user->email }}</div>
                        
                        @if($user->wallet)
                        <a href="{{ route('admin.wallets.show', $user->wallet->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-wallet fa-sm"></i> View Wallet
                        </a>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="user-details">
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">User ID:</div>
                            <div class="col-md-8">{{ $user->id }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Email:</div>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Role:</div>
                            <div class="col-md-8">{{ ucfirst($user->role) }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Status:</div>
                            <div class="col-md-8">
                                @if($user->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Joined:</div>
                            <div class="col-md-8">{{ $user->created_at->format('M d, Y') }}</div>
                        </div>
                        
                        @if($user->last_login_at)
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Last Login:</div>
                            <div class="col-md-8">
                                {{ $user->last_login_at->format('M d, Y H:i:s') }}
                                @if($user->last_login_ip)
                                <div class="small text-muted">{{ $user->last_login_ip }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional info could go here -->
    </div>
</div>

@endsection

@push('css')
<style>
    .avatar-placeholder {
        width: 100px;
        height: 100px;
        background-color: #4e73df;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 2rem;
        margin: 0 auto;
    }
</style>
@endpush