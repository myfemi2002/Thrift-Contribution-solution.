@extends('admin.admin_master')
@section('title', 'Contribution Dashboard')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">@yield('title')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item active">Contributions</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">{{ $monthlyStats['total_contributions'] }}</h4>
                            <p class="text-white-50 mb-0">Total Contributions</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-wallet-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">₦{{ number_format($monthlyStats['total_amount'], 2) }}</h4>
                            <p class="text-white-50 mb-0">Total Amount</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-money-dollar-circle-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">{{ $monthlyStats['paid_contributions'] }}</h4>
                            <p class="text-white-50 mb-0">Paid Contributions</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-checkbox-circle-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">{{ $monthlyStats['unpaid_contributions'] }}</h4>
                            <p class="text-white-50 mb-0">Unpaid/Skipped</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-close-circle-line font-size-40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.contributions.create') }}" class="btn btn-primary w-100">
                                <i class="ri-add-line me-2"></i>Record Contribution
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.contributions.calendar') }}" class="btn btn-outline-info w-100">
                                <i class="ri-calendar-line me-2"></i>Calendar View
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.contributions.logs') }}" class="btn btn-outline-warning w-100">
                                <i class="ri-file-list-line me-2"></i>Transaction Logs
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100" onclick="exportReport()">
                                <i class="ri-download-line me-2"></i>Export Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Month Selection -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.contributions.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Select Month</label>
                                <input type="month" name="month" class="form-control" value="{{ $selectedMonth }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-search-line me-2"></i>Filter
                                </button>
                                <a href="{{ route('admin.contributions.index') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="ri-refresh-line me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Contributions Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Recent Contributions</h5>
                            <small class="text-muted">{{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }} contributions</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-primary">{{ $recentContributions->total() }} records</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentContributions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Agent</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentContributions as $contribution)
                                        <tr>
                                            <td>
                                                <span class="font-monospace text-primary">{{ $contribution->transaction_id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $contribution->user->photo ? asset($contribution->user->photo) : asset('upload/no_image.jpg') }}" 
                                                         alt="User" class="rounded-circle me-2" width="32" height="32">
                                                    <div>
                                                        <div class="fw-medium">{{ $contribution->user->name }}</div>
                                                        <small class="text-muted">{{ $contribution->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $contribution->contribution_date->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $contribution->contribution_date->format('l') }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $contribution->amount > 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $contribution->formatted_amount }}
                                                </span>
                                            </td>
                                            <td>
                                                {!! $contribution->status_badge !!}
                                            </td>
                                            <td>
                                                <span class="text-capitalize">{{ str_replace('_', ' ', $contribution->payment_method) }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $contribution->agent->name }}</div>
                                                <small class="text-muted">{{ $contribution->created_at->format('H:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="viewDetails({{ $contribution->id }})">
                                                                <i class="ri-eye-line me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.contributions.wallet', $contribution->user_id) }}">
                                                                <i class="ri-wallet-line me-2"></i>View Wallet
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" onclick="deleteContribution({{ $contribution->id }})">
                                                                <i class="ri-delete-bin-line me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $recentContributions->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-file-list-line display-4 text-muted"></i>
                            <h5 class="mt-3">No contributions found</h5>
                            <p class="text-muted">No contributions recorded for {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</p>
                            <a href="{{ route('admin.contributions.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Record First Contribution
                            </a>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function viewDetails(contributionId) {
    // You would implement an AJAX call to fetch contribution details
    // For now, show a placeholder
    $('#contributionDetailsContent').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading contribution details...</p>
        </div>
    `);
    
    $('#contributionDetailsModal').modal('show');
    
    // Simulate loading details
    setTimeout(function() {
        $('#contributionDetailsContent').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6>Transaction Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>ID:</strong></td><td>TXN-${contributionId}</td></tr>
                        <tr><td><strong>Amount:</strong></td><td>₦1,000.00</td></tr>
                        <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Paid</span></td></tr>
                        <tr><td><strong>Method:</strong></td><td>Cash</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>User Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Name:</strong></td><td>John Doe</td></tr>
                        <tr><td><strong>Email:</strong></td><td>john@example.com</td></tr>
                        <tr><td><strong>Phone:</strong></td><td>+234 123 456 7890</td></tr>
                    </table>
                </div>
            </div>
        `);
    }, 1000);
}

function deleteContribution(contributionId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implement deletion logic here
            Swal.fire(
                'Deleted!',
                'Contribution has been deleted.',
                'success'
            ).then(() => {
                window.location.reload();
            });
        }
    });
}

function exportReport() {
    const month = '{{ $selectedMonth }}';
    Swal.fire({
        title: 'Export Report',
        text: 'Choose export format:',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'Excel',
        denyButtonText: 'PDF',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.open(`{{ route('admin.contributions.export') }}?format=excel&month=${month}`, '_blank');
        } else if (result.isDenied) {
            window.open(`{{ route('admin.contributions.export') }}?format=pdf&month=${month}`, '_blank');
        }
    });
}
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
    .font-size-40 {
        font-size: 40px;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .table th {
        font-weight: 600;
        font-size: 14px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .rounded-circle {
        object-fit: cover;
    }
    
    .font-monospace {
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }
    
    .dropdown-toggle::after {
        margin-left: 0.5em;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .btn-outline-primary:hover,
    .btn-outline-info:hover,
    .btn-outline-warning:hover,
    .btn-outline-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@endsection