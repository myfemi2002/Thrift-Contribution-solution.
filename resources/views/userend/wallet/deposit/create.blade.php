@extends('userend.user_home')
@section('title', 'Fund Wallet')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Fund Your Wallet</h3>
                    <div class="nk-block-des text-soft">
                        <p>Add money to your wallet using secure payment gateways</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.wallet.details') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Wallet</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Current Balance -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">Current Wallet Balance</h5>
                                <div class="nk-block-des">
                                    <h2 class="text-primary mb-1">₦{{ number_format(Auth::user()->wallet->balance, 2) }}</h2>
                                    <p class="text-soft">Available for withdrawal or contributions</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="nk-block-head-content text-end">
                                <ul class="nk-list-plain">
                                    <li><strong>Total Contributions:</strong> ₦{{ number_format(Auth::user()->wallet->getActualTotalContributions(), 2) }}</li>
                                    <li><strong>Last Deposit:</strong> 
                                        @php
                                            $lastDeposit = method_exists(Auth::user(), 'walletDeposits') ? Auth::user()->walletDeposits()->where('status', 'completed')->latest()->first() : null;
                                        @endphp
                                        {{ $lastDeposit ? $lastDeposit->created_at->format('M d, Y') : 'None' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coming Soon Notice -->
        <div class="nk-block">
            <div class="row g-gs justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-inner text-center py-5">
                            <div class="nk-block-head-content">
                                <em class="icon ni ni-wallet-in" style="font-size: 4rem; color: #6366f1; margin-bottom: 1rem;"></em>
                                <h4 class="nk-block-title">Wallet Funding Coming Soon!</h4>
                                <div class="nk-block-des">
                                    <p class="lead">We're working on integrating secure payment gateways to allow you to fund your wallet directly.</p>
                                    <p class="text-soft">This feature will support:</p>
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-4">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="feature-item">
                                        <em class="icon ni ni-cc-visa text-primary fs-2"></em>
                                        <h6 class="mt-2">Debit Cards</h6>
                                        <span class="text-soft">Visa & Mastercard</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="feature-item">
                                        <em class="icon ni ni-building text-info fs-2"></em>
                                        <h6 class="mt-2">Bank Transfer</h6>
                                        <span class="text-soft">Direct bank transfers</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="feature-item">
                                        <em class="icon ni ni-mobile text-success fs-2"></em>
                                        <h6 class="mt-2">USSD</h6>
                                        <span class="text-soft">Mobile banking</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="feature-item">
                                        <em class="icon ni ni-wallet text-warning fs-2"></em>
                                        <h6 class="mt-2">E-Wallets</h6>
                                        <span class="text-soft">Digital wallets</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <p class="text-soft mb-3">For now, your contributions are managed by administrators.</p>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('user.contributions.history') }}" class="btn btn-outline-primary">
                                        <em class="icon ni ni-histroy me-2"></em>
                                        View Contributions
                                    </a>
                                    <a href="{{ route('user.wallet.details') }}" class="btn btn-primary">
                                        <em class="icon ni ni-wallet me-2"></em>
                                        Wallet Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Temporary Info -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-inner">
                            <h6 class="card-title">Current Process</h6>
                            <ul class="list list-sm list-checked">
                                <li>Make daily contributions through agents</li>
                                <li>Wallet balance updates automatically</li>
                                <li>Track all transactions in real-time</li>
                                <li>Request adjustments when needed</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-inner">
                            <h6 class="card-title">Need Help?</h6>
                            <p class="text-soft">Contact our support team for any wallet-related questions or assistance.</p>
                            <a href="#" class="btn btn-outline-primary btn-block">
                                <em class="icon ni ni-chat me-2"></em>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
.feature-item {
    padding: 1rem;
    border: 1px solid #e3e7fe;
    border-radius: 0.5rem;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #6366f1;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 10px;
}

.fs-2 {
    font-size: 2rem;
}

@media (max-width: 768px) {
    .feature-item {
        text-align: center;
        padding: 0.75rem 0.5rem;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
@endpush

@endsection