{{-- userend.loans.history --}}

@extends('userend.user_home')
@section('title', 'Loan History')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Loan History</h3>
                    <div class="nk-block-des text-soft">
                        <p>Complete history of all your loan applications and repayments</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.loans.index') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Loans</span>
                    </a>
                    <a href="{{ route('user.loans.index') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Loan Wallet Summary -->
        @if($loanWallet)
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Available Balance</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">{{ $loanWallet->formatted_balance }}</div>
                                        </div>
                                        <div class="info">
                                            <span class="change up text-success">
                                                <em class="icon ni ni-wallet"></em>
                                                Current Balance
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
                                            <h6 class="title">Total Borrowed</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">{{ $loanWallet->formatted_total_borrowed }}</div>
                                        </div>
                                        <div class="info">
                                            <span class="change up text-info">
                                                <em class="icon ni ni-growth"></em>
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
                                            <h6 class="title">Total Repaid</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">{{ $loanWallet->formatted_total_repaid }}</div>
                                        </div>
                                        <div class="info">
                                            <span class="change up text-success">
                                                <em class="icon ni ni-check-circle"></em>
                                                Paid Back
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
                                            <h6 class="title">Outstanding</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">₦{{ number_format($loanWallet->total_outstanding, 2) }}</div>
                                        </div>
                                        <div class="info">
                                            <span class="change {{ $loanWallet->total_outstanding > 0 ? 'down text-warning' : 'up text-success' }}">
                                                <em class="icon ni ni-{{ $loanWallet->total_outstanding > 0 ? 'alert-circle' : 'check-circle' }}"></em>
                                                {{ $loanWallet->total_outstanding > 0 ? 'Pending' : 'All Clear' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <form method="GET" action="{{ route('user.loans.history') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Filter by Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="disbursed" {{ request('status') == 'disbursed' ? 'selected' : '' }}>Disbursed</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Date From</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Date To</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-search"></em>
                                        <span>Filter</span>
                                    </button>
                                    <a href="{{ route('user.loans.history') }}" class="btn btn-outline-secondary ms-2">
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

        <!-- Loan History List -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Your Loan Applications</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <span class="d-none d-sm-inline-block">
                                        <span class="sub-text">Total Records: {{ $loans instanceof \Illuminate\Pagination\LengthAwarePaginator ? $loans->total() : $loans->count() }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if($loans->count() > 0)
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Loan Details</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Progress</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Due Date</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Action</span></div>
                            </div>

                            @foreach($loans as $loan)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead">
                                                    <code class="text-primary">{{ $loan->loan_id }}</code>
                                                    @if($loan->credit_rating)
                                                        {!! $loan->credit_rating_badge !!}
                                                    @endif
                                                </span>
                                                <span class="sub-text">Applied {{ $loan->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <div class="amount-wrap">
                                            <span class="tb-amount fw-bold text-success">{{ $loan->formatted_amount }}</span>
                                            <div class="sub-text">Total: {{ $loan->formatted_total_amount }}</div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        {!! $loan->status_badge !!}
                                        @if($loan->interest_overridden)
                                            <div class="mt-1">
                                                <span class="badge bg-info badge-sm">Custom Rate</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        @if(in_array($loan->status, ['disbursed', 'active', 'completed', 'overdue']))
                                            <div class="progress-wrap">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" style="width: {{ $loan->repayment_progress }}%"></div>
                                                </div>
                                                <div class="progress-text">
                                                    <span class="sub-text">{{ number_format($loan->repayment_progress, 1) }}% paid</span>
                                                </div>
                                                <div class="amount-sm text-muted">
                                                    Outstanding: {{ $loan->formatted_outstanding_balance }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        @if($loan->due_date)
                                            <div class="{{ $loan->is_overdue ? 'text-danger' : ($loan->days_until_due <= 5 ? 'text-warning' : '') }}">
                                                {{ $loan->due_date->format('M d, Y') }}
                                            </div>
                                            @if($loan->days_until_due !== null)
                                                <div class="sub-text">
                                                    @if($loan->is_overdue)
                                                        {{ abs($loan->days_until_due) }} days overdue
                                                    @elseif($loan->status !== 'completed')
                                                        {{ $loan->days_until_due }} days left
                                                    @else
                                                        Completed
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <a href="{{ route('user.loans.show', $loan->id) }}" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                            <em class="icon ni ni-eye"></em>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($loans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <div class="card-inner">
                                {{ $loans->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <em class="icon ni ni-file-text" style="font-size: 3rem; color: #c4c4c4;"></em>
                            <h5 class="mt-3">No loan history found</h5>
                            <p class="text-soft">
                                @if(request()->hasAny(['status', 'date_from', 'date_to']))
                                    Try adjusting your filters to find loan records.
                                @else
                                    You haven't applied for any loans yet.
                                @endif
                            </p>
                            @if(!request()->hasAny(['status', 'date_from', 'date_to']))
                                <a href="{{ route('user.loans.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus me-2"></em>Apply for Your First Loan
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

<script>
$(document).ready(function() {
    // Initialize tooltips
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

.amount-wrap {
    text-align: left;
}

.tb-amount {
    font-size: 1.1rem;
    display: block;
}

.progress-wrap {
    min-width: 120px;
}

.progress {
    height: 6px;
    background-color: #e9ecef;
    border-radius: 3px;
    margin-bottom: 0.25rem;
}

.progress-bar {
    border-radius: 3px;
}

.progress-text {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.amount-sm {
    font-size: 0.75rem;
}

.nk-tb-item:hover {
    background-color: rgba(28, 208, 172, 0.02);
    transition: background-color 0.2s ease;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.badge-sm {
    font-size: 0.75em;
    padding: 0.25em 0.5em;
}

code {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

@media (max-width: 768px) {
    .nk-ecwg6 .amount {
        font-size: 1.25rem;
    }
    
    .nk-tb-list {
        overflow-x: auto;
    }
    
    .progress-wrap {
        min-width: 100px;
    }
    
    .tb-amount {
        font-size: 1rem;
    }
}
</style>
@endpush

@endsection