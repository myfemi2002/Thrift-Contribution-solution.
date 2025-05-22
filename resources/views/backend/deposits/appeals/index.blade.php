@extends('admin.admin_master')
@section('title', 'Deposit Appeals')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Deposit Appeals Management</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                    <li class="breadcrumb-item active">Appeals</li>
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
        <div class="col-md-12">
            <!-- Appeal Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.deposits.appeals') }}" method="GET" class="form-inline">
                        <div class="form-group me-3">
                            <label for="status" class="me-2">Filter by Status:</label>
                            <select class="form-control" id="status" name="status" onchange="this.form.submit()">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Appeals</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Appeal Filters -->

            <!-- Appeals List -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Deposit Appeals</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive"><!-- In admin-appeals-index-view.blade.php, update the table -->
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Claimed Amount</th>
                                    <th>Actual Amount</th>
                                    <th>Fee (20%)</th>
                                    <th>Credit Amount</th>
                                    <th>Date Submitted</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appeals as $appeal)
                                <tr>
                                    <td>#{{ $appeal->id }}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="#">{{ $appeal->deposit->user->name }} <span>{{ $appeal->deposit->user->email }}</span></a>
                                        </h2>
                                    </td>
                                    <td>{{ number_format($appeal->deposit->amount, 6) }} USDT</td>
                                    @php
                                        $actualAmount = $appeal->deposit->amount;
                                        $notes = $appeal->deposit->notes;
                                        if (preg_match('/actual\s+(\d+(\.\d+)?)/i', $notes, $matches) || preg_match('/actual:\s*(\d+(\.\d+)?)/i', $notes, $matches)) {
                                            $actualAmount = floatval($matches[1]);
                                        }
                                        $feeAmount = $actualAmount * 0.2;
                                        $creditedAmount = $actualAmount - $feeAmount;
                                    @endphp
                                    <td class="fw-bold">{{ number_format($actualAmount, 6) }} USDT</td>
                                    <td>{{ number_format($feeAmount, 6) }} USDT</td>
                                    <td>{{ number_format($creditedAmount, 6) }} USDT</td>
                                    <td>{{ $appeal->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        @if($appeal->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($appeal->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($appeal->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- View Details Button -->
                                            <a href="{{ route('admin.deposits.appeals.show', $appeal->id) }}" 
                                                class="btn btn-sm btn-info me-2">
                                                <i class="fa fa-eye me-1"></i> View
                                            </a>
                                            
                                            @if($appeal->status === 'pending')
                                                <!-- Approve Button -->
                                                <a href="{{ route('admin.deposits.appeals.show', $appeal->id) }}#approve" 
                                                    class="btn btn-sm btn-success me-2">
                                                    <i class="fa fa-check me-1"></i> Review
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No appeals found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $appeals->appends(['status' => $status])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            <!-- /Appeals List -->
        </div>
    </div>
</div>

@push('css')
<style>
    /* Ensure buttons don't wrap on smaller screens */
    .d-flex.justify-content-center {
        flex-wrap: wrap;
        gap: 5px;
    }
    
    /* Improve font sizes for better readability */
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    /* Add some responsive adjustments */
    @media (max-width: 768px) {
        .table th, .table td {
            white-space: nowrap;
        }
    }
    
    /* Improve badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@endsection