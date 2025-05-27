@extends('userend.user_home')
@section('title', 'Withdrawal History')
@section('user_content')

<div class="container-xl wide-xll">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Withdrawal History</h3>
                    <div class="nk-block-des text-soft">
                        <p>View and manage your withdrawal requests</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.withdrawals.create') }}" class="btn btn-primary d-none d-sm-inline-flex">
                        <em class="icon ni ni-plus"></em>
                        <span>New Withdrawal</span>
                    </a>
                    <a href="{{ route('user.withdrawals.create') }}" class="btn btn-icon btn-primary d-inline-flex d-sm-none">
                        <em class="icon ni ni-plus"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Wallet Balance</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount text-primary">₦{{ number_format($summary['wallet_balance'], 2) }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change up text-success">
                                            <em class="icon ni ni-wallet"></em>
                                            Available
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
                                        <h6 class="title">Total Withdrawn</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount text-success">₦{{ number_format($summary['total_withdrawn'], 2) }}</div>
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
                                        <h6 class="title">Pending Requests</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount text-warning">{{ $summary['pending_withdrawals'] }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change down text-warning">
                                            <em class="icon ni ni-clock"></em>
                                            Awaiting Approval
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
                                        <h6 class="title">Total Requests</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="data-group">
                                        <div class="amount text-info">{{ $summary['total_withdrawals'] }}</div>
                                    </div>
                                    <div class="info">
                                        <span class="change up text-info">
                                            <em class="icon ni ni-histroy"></em>
                                            All Time
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <form method="GET" action="{{ route('user.withdrawals.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Filter by Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Payment Method</label>
                                    <select name="payment_method" class="form-select">
                                        <option value="">All Methods</option>
                                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-search"></em>
                                        <span>Filter</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a href="{{ route('user.withdrawals.index') }}" class="btn btn-outline-light">
                                        <em class="icon ni ni-reload"></em>
                                        <span>Reset</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Withdrawal List -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Withdrawal Requests</h6>
                        </div>
                        <div class="card-tools">
                            <span class="d-none d-sm-inline-block">
                                <span class="sub-text">Total: {{ $withdrawals->total() }} requests</span>
                            </span>
                        </div>
                    </div>

                    @if($withdrawals->count() > 0)
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Withdrawal ID</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Method</span></div>
                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Action</span></div>
                            </div>

                            @foreach($withdrawals as $withdrawal)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <span class="tb-lead font-monospace">{{ $withdrawal->withdrawal_id }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div>
                                            <span class="tb-amount fw-bold">₦{{ number_format($withdrawal->amount, 2) }}</span>
                                            @if($withdrawal->fee > 0)
                                                <div class="sub-text">Fee: ₦{{ number_format($withdrawal->fee, 2) }}</div>
                                                <div class="sub-text text-success">Net: ₦{{ number_format($withdrawal->net_amount, 2) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <span class="badge bg-light text-dark">{{ $withdrawal->payment_method_label }}</span>
                                        @if($withdrawal->payment_method === 'bank_transfer' && $withdrawal->bank_name)
                                            <div class="sub-text">{{ $withdrawal->bank_name }}</div>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-lg">
                                        {!! $withdrawal->status_badge !!}
                                        @if($withdrawal->approved_at)
                                            <div class="sub-text">{{ $withdrawal->approved_at->format('M d, Y') }}</div>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span>{{ $withdrawal->created_at->format('M d, Y') }}</span>
                                        <div class="sub-text">{{ $withdrawal->created_at->format('g:i A') }}</div>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                    data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('user.withdrawals.show', $withdrawal->id) }}">
                                                        <em class="icon ni ni-eye me-2"></em>View Details
                                                    </a>
                                                </li>
                                                @if($withdrawal->isPending())
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" 
                                                           onclick="cancelWithdrawal('{{ $withdrawal->id }}')">
                                                            <em class="icon ni ni-cross me-2"></em>Cancel Request
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="card-inner">
                            {{ $withdrawals->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <em class="icon ni ni-file-text" style="font-size: 3rem; color: #c4c4c4;"></em>
                            <h5 class="mt-3">No withdrawal requests found</h5>
                            <p class="text-soft">
                                @if(request()->hasAny(['status', 'payment_method']))
                                    Try adjusting your filters to find withdrawal requests.
                                @else
                                    You haven't made any withdrawal requests yet.
                                @endif
                            </p>
                            @if(!request()->hasAny(['status', 'payment_method']))
                                <a href="{{ route('user.withdrawals.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus me-2"></em>Make First Withdrawal
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function cancelWithdrawal(withdrawalId) {
    Swal.fire({
        title: 'Cancel Withdrawal Request?',
        text: "This action cannot be undone. The withdrawal request will be cancelled.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/user/withdrawals/${withdrawalId}/cancel`;
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add method override
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Auto refresh page every 30 seconds to check for status updates
setInterval(function() {
    // Only refresh if there are pending withdrawals
    const hasPending = document.querySelector('.badge.bg-warning');
    if (hasPending) {
        window.location.reload();
    }
}, 30000);
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

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 12px;
}

.nk-tb-item:hover {
    background-color: rgba(28, 208, 172, 0.02);
    transition: background-color 0.2s ease;
}

.dropdown-toggle::after {
    margin-left: 0.5em;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .nk-ecwg6 .amount {
        font-size: 1.25rem;
    }
    
    .nk-tb-list {
        overflow-x: auto;
    }
}
</style>
@endpush

@endsection