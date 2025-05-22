@extends('admin.admin_master')
@section('title', 'Deposit Management')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Deposit Management</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Deposits</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-md-12">
            <!-- Deposit Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.deposits.index') }}" method="GET" class="form-inline">
                        <div class="form-group me-3">
                            <label for="status" class="me-2">Filter by Status:</label>
                            <select class="form-control" id="status" name="status" onchange="this.form.submit()">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Deposits</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Deposit Filters -->

<!-- Deposits List -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">TRON Deposits</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->id }}</td>
                        <td>
                            <h2 class="table-avatar">
                                <a href="#">{{ $deposit->user->name }} <span>{{ $deposit->user->email }}</span></a>
                            </h2>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="text-truncate" style="max-width: 150px;">{{ $deposit->tx_id }}</span>
                                <button type="button" class="btn btn-sm btn-link ms-2" onclick="navigator.clipboard.writeText('{{ $deposit->tx_id }}'); alert('Transaction ID copied to clipboard');">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                        </td>
                        <td>{{ number_format($deposit->amount, 6) }} USDT</td>
                        <td>
                            @if($deposit->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($deposit->status === 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($deposit->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $deposit->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <!-- View Details Button -->
                                <a href="{{ route('admin.deposits.show', $deposit->id) }}" 
                                   class="btn btn-sm btn-info me-2">
                                    <i class="fa fa-eye me-1"></i> View
                                </a>
                                
                                @if($deposit->status === 'pending')
                                    <!-- Approve Button -->
                                    <a href="{{ route('admin.deposits.confirm-approve', $deposit->id) }}" 
                                       class="btn btn-sm btn-success me-2">
                                        <i class="fa fa-check me-1"></i> Approve
                                    </a>
                                    
                                    <!-- Verify Button -->
                                    <a href="{{ route('admin.deposits.confirm-verify', $deposit->id) }}" 
                                       class="btn btn-sm btn-warning me-2">
                                        <i class="fa fa-refresh me-1"></i> Verify
                                    </a>
                                    
                                    <!-- Reject Button -->
                                    <a href="{{ route('admin.deposits.confirm-reject', $deposit->id) }}" 
                                       class="btn btn-sm btn-danger">
                                        <i class="fa fa-ban me-1"></i> Reject
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No deposits found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $deposits->appends(['status' => $status])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
<!-- /Deposits List -->


        </div>
    </div>
</div>

<!-- Approve Deposit Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Confirm Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this deposit? The user's wallet will be credited with the specified amount.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="approveForm" method="POST" action="">
                    @csrf
                    <button type="submit" class="btn btn-success">Approve Deposit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reject Deposit Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Confirm Rejection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reject this deposit?</p>
                    <div class="form-group">
                        <label for="reason" class="form-label">Reason for rejection</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Deposit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Verify Blockchain Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifyModalLabel">Verify on Blockchain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>This will verify the transaction on the TRON blockchain and automatically approve or reject the deposit based on the verification results.</p>
                <p>Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="verifyForm" method="POST" action="">
                    @csrf
                    <button type="submit" class="btn btn-primary">Verify Transaction</button>
                </form>
            </div>
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle Approve Deposit
        $('.approve-deposit').on('click', function() {
            var depositId = $(this).data('id');
            var approveUrl = "{{ route('admin.deposits.approve', ':id') }}";
            approveUrl = approveUrl.replace(':id', depositId);
            
            $('#approveForm').attr('action', approveUrl);
        });
        
        // Handle Reject Deposit
        $('.reject-deposit').on('click', function() {
            var depositId = $(this).data('id');
            var rejectUrl = "{{ route('admin.deposits.reject', ':id') }}";
            rejectUrl = rejectUrl.replace(':id', depositId);
            
            $('#rejectForm').attr('action', rejectUrl);
        });
        
        // Handle Verify on Blockchain
        $('.verify-blockchain').on('click', function() {
            var depositId = $(this).data('id');
            var verifyUrl = "{{ route('admin.deposits.verify-blockchain', ':id') }}";
            verifyUrl = verifyUrl.replace(':id', depositId);
            
            $('#verifyForm').attr('action', verifyUrl);
        });
        
        // Copy to clipboard function
        $('.copy-tx-id').on('click', function() {
            var txId = $(this).data('tx-id');
            navigator.clipboard.writeText(txId).then(function() {
                // Show toast or notification
                alert('Transaction ID copied to clipboard');
            }, function() {
                alert('Failed to copy Transaction ID');
            });
        });
    });
</script>
@endpush

@endsection