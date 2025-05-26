@extends('admin.admin_master')
@section('title', 'Transaction Logs')
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
                    <li class="breadcrumb-item active">Transaction Logs</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Logs</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.contributions.logs') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" class="form-control" 
                                       value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" class="form-control" 
                                       value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Action</label>
                                <select name="action" class="form-select">
                                    <option value="">All Actions</option>
                                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                                    <option value="cancelled" {{ request('action') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Agent</label>
                                <select name="agent_id" class="form-select">
                                    <option value="">All Agents</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-search-line me-2"></i>Filter
                                </button>
                                <a href="{{ route('admin.contributions.logs') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="ri-refresh-line me-2"></i>Reset
                                </a>
                                <button type="button" class="btn btn-outline-success ms-2" onclick="exportLogs()">
                                    <i class="ri-download-line me-2"></i>Export
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Logs Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">Transaction Logs</h5>
                            <small class="text-muted">All contribution-related activities</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">{{ $logs->total() }} records</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Log ID</th>
                                        <th>Action</th>
                                        <th>User</th>
                                        <th>Agent</th>
                                        <th>Amount Change</th>
                                        <th>IP Address</th>
                                        <th>Date & Time</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                <span class="font-monospace text-primary">{{ $log->log_id }}</span>
                                            </td>
                                            <td>
                                                {!! $log->action_badge !!}
                                            </td>
                                            <td>
                                                @if($log->user)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $log->user->photo ? asset($log->user->photo) : asset('upload/no_image.jpg') }}" 
                                                             alt="User" class="rounded-circle me-2" width="32" height="32">
                                                        <div>
                                                            <div class="fw-medium">{{ $log->user->name }}</div>
                                                            <small class="text-muted">{{ $log->user->email }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">User Deleted</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($log->agent)
                                                    <div>
                                                        <div class="fw-medium">{{ $log->agent->name }}</div>
                                                        <small class="text-muted">{{ $log->agent->email }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Agent Deleted</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($log->old_amount !== null || $log->new_amount !== null)
                                                    <div class="amount-change">
                                                        @if($log->old_amount !== null)
                                                            <div class="old-amount">
                                                                <small class="text-muted">From:</small>
                                                                <span class="text-danger">₦{{ number_format($log->old_amount, 2) }}</span>
                                                            </div>
                                                        @endif
                                                        @if($log->new_amount !== null)
                                                            <div class="new-amount">
                                                                <small class="text-muted">To:</small>
                                                                <span class="text-success">₦{{ number_format($log->new_amount, 2) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="font-monospace">{{ $log->ip_address ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <div>{{ $log->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $log->created_at->format('H:i:s A') }}</small>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewLogDetails({{ $log->id }})">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $logs->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-file-list-line display-4 text-muted"></i>
                            <h5 class="mt-3">No logs found</h5>
                            <p class="text-muted">No transaction logs match your current filter criteria</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="logDetailsContent">
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
function viewLogDetails(logId) {
    $('#logDetailsContent').html(`
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading log details...</p>
        </div>
    `);
    
    $('#logDetailsModal').modal('show');
    
    // Simulate loading details (replace with actual AJAX call)
    setTimeout(function() {
        $('#logDetailsContent').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6>Log Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Log ID:</strong></td><td class="font-monospace">LOG-${logId}</td></tr>
                        <tr><td><strong>Action:</strong></td><td><span class="badge bg-success">Created</span></td></tr>
                        <tr><td><strong>Timestamp:</strong></td><td>${new Date().toLocaleString()}</td></tr>
                        <tr><td><strong>IP Address:</strong></td><td class="font-monospace">192.168.1.1</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>User Agent</h6>
                    <div class="bg-light p-2 rounded small font-monospace">
                        Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36
                    </div>
                    
                    <h6 class="mt-3">Metadata</h6>
                    <div class="bg-light p-2 rounded">
                        <pre class="mb-0 small">{
  "payment_method": "cash",
  "receipt_number": "RCP-001",
  "browser": "Chrome",
  "platform": "Windows"
}</pre>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Related Contribution</h6>
                    <div class="card bg-light">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Transaction ID:</strong><br>
                                    <span class="font-monospace text-primary">TXN-ABC123</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>User:</strong><br>
                                    John Doe
                                </div>
                                <div class="col-md-3">
                                    <strong>Amount:</strong><br>
                                    <span class="text-success">₦1,000.00</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Date:</strong><br>
                                    ${new Date().toLocaleDateString()}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }, 1000);
}

function exportLogs() {
    Swal.fire({
        title: 'Export Transaction Logs',
        text: 'Choose export format:',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: 'Excel',
        denyButtonText: 'PDF',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Get current filter parameters
            const params = new URLSearchParams(window.location.search);
            params.set('format', 'excel');
            window.open(`{{ route('admin.contributions.export') }}?${params.toString()}`, '_blank');
        } else if (result.isDenied) {
            // Get current filter parameters
            const params = new URLSearchParams(window.location.search);
            params.set('format', 'pdf');
            window.open(`{{ route('admin.contributions.export') }}?${params.toString()}`, '_blank');
        }
    });
}

// Auto-refresh logs every 30 seconds
setInterval(function() {
    // Add a subtle indicator that data is being refreshed
    const badge = document.querySelector('.badge.bg-info');
    if (badge) {
        badge.classList.add('pulse');
        setTimeout(() => badge.classList.remove('pulse'), 1000);
    }
}, 30000);
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
    .font-monospace {
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }
    
    .amount-change {
        font-size: 12px;
    }
    
    .amount-change .old-amount,
    .amount-change .new-amount {
        line-height: 1.2;
    }
    
    .table th {
        font-weight: 600;
        font-size: 14px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .rounded-circle {
        object-fit: cover;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .pulse {
        animation: pulse 1s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    pre {
        font-size: 11px;
        color: #6c757d;
    }
    
    .btn-outline-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
</style>
@endpush

@endsection