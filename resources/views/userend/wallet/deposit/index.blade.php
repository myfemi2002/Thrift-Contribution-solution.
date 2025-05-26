@extends('userend.user_home')
@section('title', 'Deposit History')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Deposit History</h3>
                    <div class="nk-block-des text-soft">
                        <p>Track all your wallet funding transactions</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.wallet.deposit.create') }}" class="btn btn-primary d-none d-sm-inline-flex">
                        <em class="icon ni ni-plus"></em>
                        <span>Fund Wallet</span>
                    </a>
                    <a href="{{ route('user.wallet.deposit.create') }}" class="btn btn-icon btn-primary d-inline-flex d-sm-none">
                        <em class="icon ni ni-plus"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Total Deposits</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        @php
                                            $totalDeposits = isset($deposits) ? Auth::user()->walletDeposits()->where('status', 'completed')->sum('amount') : 0;
                                        @endphp
                                        <div class="amount">₦{{ number_format($totalDeposits, 2) }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change up text-success">
                                            <em class="icon ni ni-arrow-long-up"></em>
                                            All Time
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">This Month</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        @php
                                            $monthlyDeposits = isset($deposits) ? Auth::user()->walletDeposits()
                                                ->where('status', 'completed')
                                                ->whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)
                                                ->sum('amount') : 0;
                                        @endphp
                                        <div class="amount">₦{{ number_format($monthlyDeposits, 2) }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change up text-info">
                                            <em class="icon ni ni-calendar"></em>
                                            {{ now()->format('F Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Successful</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        @php
                                            $successfulCount = isset($deposits) ? Auth::user()->walletDeposits()->where('status', 'completed')->count() : 0;
                                        @endphp
                                        <div class="amount">{{ $successfulCount }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change up text-success">
                                            <em class="icon ni ni-check-circle"></em>
                                            Completed
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Pending</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        @php
                                            $pendingCount = isset($deposits) ? Auth::user()->walletDeposits()->whereIn('status', ['pending', 'processing'])->count() : 0;
                                        @endphp
                                        <div class="amount">{{ $pendingCount }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change {{ $pendingCount > 0 ? 'down text-warning' : 'neutral text-muted' }}">
                                            <em class="icon ni ni-clock"></em>
                                            In Progress
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposits List -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Deposit Transactions</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <span class="d-none d-sm-inline-block">
                                        <span class="sub-text">Total Records: {{ isset($deposits) ? $deposits->total() : 0 }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if(isset($deposits) && $deposits->count() > 0)
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Deposit ID</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Gateway</span></div>
                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Action</span></div>
                            </div>

                            @foreach($deposits as $deposit)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $deposit->deposit_id }}</span>
                                                <span class="sub-text">{{ $deposit->gateway_reference }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-amount fw-bold">₦{{ number_format($deposit->amount, 2) }}</span>
                                        @if($deposit->fee_amount > 0)
                                            <span class="sub-text d-block">Fee: ₦{{ number_format($deposit->fee_amount, 2) }}</span>
                                            <span class="sub-text d-block text-success">Credited: ₦{{ number_format($deposit->credited_amount, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <span class="text-primary">
                                            {{ ucfirst($deposit->payment_gateway) }}
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-lg">
                                        {!! $deposit->status_badge !!}
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span>{{ $deposit->created_at->format('M d, Y') }}</span>
                                        <span class="sub-text d-block">{{ $deposit->created_at->format('h:i A') }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary" 
                                                onclick="viewDepositDetails('{{ $deposit->id }}')" 
                                                data-bs-toggle="tooltip" title="View Details">
                                            <em class="icon ni ni-eye"></em>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="card-inner">
                            {{ $deposits->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <em class="icon ni ni-wallet" style="font-size: 3rem; color: #c4c4c4;"></em>
                            <h5 class="mt-3">No deposits yet</h5>
                            <p class="text-soft">You haven't made any wallet deposits yet.</p>
                            <a href="{{ route('user.wallet.deposit.create') }}" class="btn btn-primary">
                                <em class="icon ni ni-plus me-2"></em>
                                Make Your First Deposit
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deposit Details Modal -->
<div class="modal fade" id="depositDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="depositDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function viewDepositDetails(depositId) {
    // Find the deposit data from the page
    const depositRow = $(`[onclick="viewDepositDetails('${depositId}')"]`).closest('.nk-tb-item');
    
    const depositID = depositRow.find('.tb-lead').text();
    const reference = depositRow.find('.sub-text').first().text();
    const amount = depositRow.find('.tb-amount').text();
    const gateway = depositRow.find('.badge').text();
    const status = depositRow.find('.nk-tb-col:nth-child(4)').html();
    const date = depositRow.find('.nk-tb-col:nth-child(5) span').first().text();
    const time = depositRow.find('.nk-tb-col:nth-child(5) .sub-text').text();
    
    const content = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-file-text me-2"></em>Deposit ID</h6>
                <p class="mb-0 fw-medium">${depositID}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-shield-check me-2"></em>Gateway Reference</h6>
                <p class="mb-0"><code>${reference}</code></p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-money me-2"></em>Amount</h6>
                <p class="mb-0 fw-bold fs-5">${amount}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-credit-card me-2"></em>Gateway</h6>
                <p class="mb-0">${gateway}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-flag me-2"></em>Status</h6>
                <div>${status}</div>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-calendar me-2"></em>Date & Time</h6>
                <p class="mb-0">${date} at ${time}</p>
            </div>
        </div>
    `;
    
    $('#depositDetailsContent').html(content);
    $('#depositDetailsModal').modal('show');
}

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

@push('css')
<style>
.nk-ecwg6 .amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #364a63;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.08);
    border-radius: 10px;
}

.tb-amount {
    font-size: 1.1rem;
}

.modal-content {
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

code {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.4rem 0.6rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

.nk-tb-item:hover {
    background-color: rgba(28, 208, 172, 0.02);
    transition: background-color 0.2s ease;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .nk-ecwg6 .amount {
        font-size: 1.25rem;
    }
}
</style>
@endpush

@endsection