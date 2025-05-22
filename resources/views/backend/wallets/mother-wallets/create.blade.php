@extends('admin.admin_master')
@section('title', 'Add Mother Wallet')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Add Mother Wallet</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.wallets.mother.index') }}">Mother Wallets</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add New TRON Wallet Address</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.wallets.mother.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="wallet_address">TRON Wallet Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('wallet_address') is-invalid @enderror" id="wallet_address" name="wallet_address" value="{{ old('wallet_address') }}" required>
                            <small class="form-text text-muted">Enter a valid TRON wallet address (starts with 'T')</small>
                            @error('wallet_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Wallet Address</button>
                            <a href="{{ route('admin.wallets.mother.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection