{{-- userend.contributions.history --}}

@extends('userend.user_home')
@section('title', 'Contribution History')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Contribution History</h3>
                    <div class="nk-block-des text-soft">
                        <p>View your complete contribution history and payment records</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.contributions.calendar') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-calendar"></em>
                        <span>Calendar View</span>
                    </a>
                    <a href="{{ route('user.contributions.calendar') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-calendar"></em>
                    </a>
                </div>
            </div>
        </div>



<!-- Monthly Summary -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Total Amount</h6>
                                @if(isset($monthlySummary['adjustments']) && $monthlySummary['adjustments']['net'] != 0)
                                    <em class="card-hint-icon ni ni-help-fill" data-bs-toggle="tooltip" 
                                        title="Includes adjustments: +₦{{ number_format($monthlySummary['adjustments']['omitted'], 2) }} omitted, -₦{{ number_format($monthlySummary['adjustments']['corrections'], 2) }} corrections"></em>
                                @endif
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">₦{{ number_format($monthlySummary['total_amount'], 2) }}</div>
                                @if(isset($monthlySummary['adjustments']) && $monthlySummary['adjustments']['net'] != 0)
                                    <div class="amount-sm text-muted">
                                        Raw: ₦{{ number_format($monthlySummary['raw_contributions'], 2) }}
                                        @if($monthlySummary['adjustments']['net'] > 0)
                                            <span class="text-success">+₦{{ number_format($monthlySummary['adjustments']['net'], 2) }}</span>
                                        @elseif($monthlySummary['adjustments']['net'] < 0)
                                            <span class="text-danger">₦{{ number_format($monthlySummary['adjustments']['net'], 2) }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="info">
                                <span class="change up text-success">
                                    <em class="icon ni ni-arrow-long-up"></em>
                                    {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Paid Days</h6>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">{{ $monthlySummary['paid_days'] }}</div>
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

        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Unpaid Days</h6>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">{{ $monthlySummary['unpaid_days'] }}</div>
                            </div>
                            <div class="info">
                                <span class="change down text-danger">
                                    <em class="icon ni ni-alert-circle"></em>
                                    Missed
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Optional: Show adjustment breakdown if there were adjustments --}}
    @if(isset($monthlySummary['adjustments']) && 
       ($monthlySummary['adjustments']['omitted'] > 0 || $monthlySummary['adjustments']['corrections'] > 0))
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <em class="icon ni ni-info"></em>
                        Monthly Adjustments Applied
                    </h6>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Raw Contributions:</strong><br>
                            ₦{{ number_format($monthlySummary['raw_contributions'], 2) }}
                        </div>
                        @if($monthlySummary['adjustments']['omitted'] > 0)
                            <div class="col-md-4">
                                <strong class="text-success">+ Omitted Contributions:</strong><br>
                                <span class="text-success">₦{{ number_format($monthlySummary['adjustments']['omitted'], 2) }}</span>
                            </div>
                        @endif
                        @if($monthlySummary['adjustments']['corrections'] > 0)
                            <div class="col-md-4">
                                <strong class="text-danger">- Corrections/Refunds:</strong><br>
                                <span class="text-danger">₦{{ number_format($monthlySummary['adjustments']['corrections'], 2) }}</span>
                            </div>
                        @endif
                    </div>
                    <hr class="my-2">
                    <div class="fw-bold">
                        Final Total: ₦{{ number_format($monthlySummary['total_amount'], 2) }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

        <!-- Filters -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <form method="GET" action="{{ route('user.contributions.history') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Filter by Month</label>
                                    <input type="month" name="month" class="form-control" 
                                           value="{{ request('month', $selectedMonth) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <a href="{{ route('user.contributions.history') }}" class="btn btn-outline-light">
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

        <!-- Contribution List -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Contribution Records</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="btn-toolbar gx-1">
                                <li>
                                    <span class="d-none d-sm-inline-block">
                                        <span class="sub-text">Total Records: {{ $contributions->total() }}</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if($contributions->count() > 0)
                        <div class="nk-tb-list nk-tb-ulist">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Date</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Status</span></div>
                                <div class="nk-tb-col tb-col-lg"><span class="sub-text">Payment Method</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Recorded By</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Reference</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">Action</span></div>
                            </div>

                            @foreach($contributions as $contribution)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $contribution->contribution_date->format('M d, Y') }}</span>
                                                <span class="sub-text">{{ $contribution->contribution_date->format('l') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="tb-amount fw-bold {{ $contribution->amount > 0 ? 'text-success' : 'text-danger' }}">
                                            ₦{{ number_format($contribution->amount, 2) }}
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        @if($contribution->status === 'paid' && $contribution->amount > 0)
                                            <span class="tb-status text-success">
                                                <em class="icon ni ni-check-circle"></em> Paid
                                            </span>
                                        @else
                                            <span class="tb-status text-danger">
                                                <em class="icon ni ni-cross-circle"></em> Unpaid
                                            </span>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-lg">
                                        <span>{{ $contribution->payment_method ? ucfirst(str_replace('_', ' ', $contribution->payment_method)) : 'N/A' }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span>{{ $contribution->agent ? $contribution->agent->name : 'System' }}</span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="text-soft">
                                            <code>{{ $contribution->transaction_id }}</code>
                                        </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-sm">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary" 
                                                onclick="viewContributionDetails('{{ $contribution->id }}')" 
                                                data-bs-toggle="tooltip" title="View Details">
                                            <em class="icon ni ni-eye"></em>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="card-inner">
                            {{ $contributions->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <em class="icon ni ni-file-text" style="font-size: 3rem; color: #c4c4c4;"></em>
                            <h5 class="mt-3">No contribution records found</h5>
                            <p class="text-soft">
                                @if(request()->hasAny(['month', 'status']))
                                    Try adjusting your filters to find contribution records.
                                @else
                                    You haven't made any contributions yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contribution Details Modal -->
<div class="modal fade" id="contributionDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contribution Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="contributionDetailsContent">
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
function viewContributionDetails(contributionId) {
    // Find the contribution data from the page
    const contributionRow = $(`[onclick="viewContributionDetails('${contributionId}')"]`).closest('.nk-tb-item');
    
    const date = contributionRow.find('.tb-lead').text();
    const dayName = contributionRow.find('.sub-text').first().text();
    const amount = contributionRow.find('.tb-amount').text();
    const status = contributionRow.find('.tb-status').text().trim();
    const paymentMethod = contributionRow.find('.nk-tb-col:nth-child(4) span').text();
    const recordedBy = contributionRow.find('.nk-tb-col:nth-child(5) span').text();
    const reference = contributionRow.find('code').text();
    
    const isAmountPositive = contributionRow.find('.tb-amount').hasClass('text-success');
    
    const content = `
        <div class="row">
            <div class="col-12 mb-3">
                <h6><em class="icon ni ni-calendar me-2"></em>Contribution Date</h6>
                <p class="mb-0 fw-medium">${date} (${dayName})</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-money me-2"></em>Amount</h6>
                <p class="mb-0 fw-bold fs-5 ${isAmountPositive ? 'text-success' : 'text-danger'}">
                    ${amount}
                </p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-flag me-2"></em>Status</h6>
                <p class="mb-0">${status}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-credit-card me-2"></em>Payment Method</h6>
                <p class="mb-0">${paymentMethod}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-user me-2"></em>Recorded By</h6>
                <p class="mb-0">${recordedBy}</p>
            </div>
            <div class="col-12 mb-3">
                <h6><em class="icon ni ni-file-text me-2"></em>Transaction Reference</h6>
                <p class="mb-0"><code>${reference}</code></p>
            </div>
        </div>
    `;
    
    $('#contributionDetailsContent').html(content);
    $('#contributionDetailsModal').modal('show');
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

.tb-status {
    font-weight: 600;
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
    
    .nk-tb-list {
        overflow-x: auto;
    }
}
</style>
@endpush

@endsection