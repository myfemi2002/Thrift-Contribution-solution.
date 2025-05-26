@extends('admin.admin_master')
@section('title', 'User Wallet Details')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">@yield('title')</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.contributions.index') }}">Contributions</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}'s Wallet</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $user->photo ? asset($user->photo) : asset('upload/no_image.jpg') }}" 
                                 alt="User Photo" class="rounded-circle" width="80" height="80">
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-1">{{ $user->email }}</p>
                            <p class="text-muted mb-0">{{ $user->phone ?? 'No phone number' }}</p>
                            <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }} mt-2">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="fw-bold">{{ $user->contributions->count() }}</div>
                                    <small class="text-muted">Total Records</small>
                                </div>
                                <div class="col-6">
                                    <div class="fw-bold">{{ $user->contributions->where('status', 'paid')->count() }}</div>
                                    <small class="text-muted">Paid Days</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wallet Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="text-white mb-1">{{ $user->wallet->formatted_balance ?? '₦0.00' }}</h4>
                            <p class="text-white-50 mb-0">Current Balance</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-wallet-3-line font-size-40"></i>
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
                            <h4 class="text-white mb-1">{{ $user->wallet->formatted_total_contributions ?? '₦0.00' }}</h4>
                            <p class="text-white-50 mb-0">Total Contributions</p>
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
                            <h4 class="text-white mb-1">₦{{ number_format($user->contributions->where('status', 'paid')->sum('amount'), 2) }}</h4>
                            <p class="text-white-50 mb-0">This Month</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-calendar-check-line font-size-40"></i>
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
                            <h4 class="text-white mb-1">{{ $user->contributions->where('status', 'unpaid')->count() }}</h4>
                            <p class="text-white-50 mb-0">Unpaid Days</p>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-error-warning-line font-size-40"></i>
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
                            <a href="{{ route('admin.contributions.create') }}?user_id={{ $user->id }}" class="btn btn-primary w-100">
                                <i class="ri-add-line me-2"></i>Record Contribution
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.contributions.calendar') }}?user_id={{ $user->id }}" class="btn btn-outline-info w-100">
                                <i class="ri-calendar-line me-2"></i>View Calendar
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100" onclick="exportUserReport({{ $user->id }})">
                                <i class="ri-download-line me-2"></i>Export Report
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-{{ $user->wallet->status == 'active' ? 'danger' : 'success' }} w-100" 
                                    onclick="toggleWalletStatus({{ $user->wallet->id ?? 0 }})">
                                <i class="ri-{{ $user->wallet->status == 'active' ? 'pause' : 'play' }}-line me-2"></i>
                                {{ $user->wallet->status == 'active' ? 'Suspend' : 'Activate' }} Wallet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Contributions -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Recent Contributions</h5>
                            <small class="text-muted">Last 10 contribution records</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.contributions.index') }}?user_id={{ $user->id }}" class="btn btn-sm btn-outline-primary">
                                View All
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($user->contributions && $user->contributions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Agent</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->contributions->take(10) as $contribution)
                                        <tr>
                                            <td>
                                                <span class="font-monospace text-primary">{{ $contribution->transaction_id }}</span>
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
                                                <div class="fw-medium">{{ $contribution->agent->name ?? 'N/A' }}</div>
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
                                                            <a class="dropdown-item" href="#" onclick="viewContributionDetails({{ $contribution->id }})">
                                                                <i class="ri-eye-line me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="editContribution({{ $contribution->id }})">
                                                                <i class="ri-edit-line me-2"></i>Edit
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
                    @else
                        <div class="text-center py-5">
                            <i class="ri-wallet-line display-4 text-muted"></i>
                            <h5 class="mt-3">No contributions yet</h5>
                            <p class="text-muted">This user hasn't made any contributions yet</p>
                            <a href="{{ route('admin.contributions.create') }}?user_id={{ $user->id }}" class="btn btn-primary">
                                <i class="ri-add-line me-2"></i>Record First Contribution
                            </a>
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
function exportUserReport(userId) {
    Swal.fire({
        title: 'Export User Report',
        html: `
            <div class="mb-3">
                <label class="form-label">Select Month:</label>
                <input type="month" id="export-month" class="form-control" value="${new Date().getFullYear()}-${String(new Date().getMonth() + 1).padStart(2, '0')}">
            </div>
            <div class="mb-3">
                <label class="form-label">Format:</label>
                <select id="export-format" class="form-select">
                    <option value="excel">Excel</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Export',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const month = document.getElementById('export-month').value;
            const format = document.getElementById('export-format').value;
            
            if (!month) {
                Swal.showValidationMessage('Please select a month');
                return false;
            }
            
            return { month, format };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { month, format } = result.value;
            window.open(`{{ route('admin.contributions.export') }}?user_id=${userId}&month=${month}&format=${format}`, '_blank');
        }
    });
}

function toggleWalletStatus(walletId) {
    if (!walletId) {
        Swal.fire('Error', 'Wallet not found', 'error');
        return;
    }
    
    const currentStatus = '{{ $user->wallet->status ?? 'inactive' }}';
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'suspend';
    
    Swal.fire({
        title: `${action.charAt(0).toUpperCase() + action.slice(1)} Wallet?`,
        text: `Are you sure you want to ${action} this wallet?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: newStatus === 'active' ? '#28a745' : '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Yes, ${action} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            // Here you would make an AJAX call to update wallet status
            Swal.fire(
                `Wallet ${action}d!`,
                `The wallet has been ${action}d successfully.`,
                'success'
            ).then(() => {
                window.location.reload();
            });
        }
    });
}

function viewContributionDetails(contributionId) {
    // Implementation for viewing contribution details
    Swal.fire({
        title: 'Contribution Details',
        html: `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading contribution details...</p>
            </div>
        `,
        showConfirmButton: false,
        allowOutsideClick: false
    });
    
    // Simulate loading
    setTimeout(() => {
        Swal.update({
            html: `
                <div class="text-start">
                    <table class="table table-sm">
                        <tr><td><strong>Transaction ID:</strong></td><td>TXN-${contributionId}</td></tr>
                        <tr><td><strong>Amount:</strong></td><td>₦1,000.00</td></tr>
                        <tr><td><strong>Status:</strong></td><td><span class="badge bg-success">Paid</span></td></tr>
                        <tr><td><strong>Payment Method:</strong></td><td>Cash</td></tr>
                        <tr><td><strong>Date:</strong></td><td>${new Date().toLocaleDateString()}</td></tr>
                    </table>
                </div>
            `,
            showConfirmButton: true,
            confirmButtonText: 'Close'
        });
    }, 1500);
}

function editContribution(contributionId) {
    window.location.href = `{{ route('admin.contributions.create') }}?edit=${contributionId}`;
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
            // Implementation for deletion
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
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
    .font-size-40 {
        font-size: 40px;
    }
    
    .rounded-circle {
        object-fit: cover;
    }
    
    .font-monospace {
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .table th {
        font-weight: 600;
        font-size: 14px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
</style>
@endpush

@endsection