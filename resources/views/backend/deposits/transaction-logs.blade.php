@extends('admin.admin_master')
@section('title', 'Deposit Transaction Logs')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Deposit Transaction Logs</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                    <li class="breadcrumb-item active">Transaction Logs</li>
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
            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.deposits.transaction-logs') }}" method="GET" class="form">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="user_id" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="user_id" name="user_id" value="{{ request('user_id') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="action_type" class="form-label">Action Type</label>
                                <select class="form-control" id="action_type" name="action_type">
                                    <option value="all" {{ request('action_type') === 'all' ? 'selected' : '' }}>All Actions</option>
                                    @foreach($actionTypes as $type)
                                        <option value="{{ $type }}" {{ request('action_type') === $type ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_from" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_to" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.deposits.transaction-logs') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh me-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Filters -->

            <!-- Transaction Logs List -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transaction Logs</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Deposit ID</th>
                                    <th>Action</th>
                                    <th>Amount</th>
                                    <th>Fee</th>
                                    <th>Credited</th>
                                    <th>Date & Time</th>
                                    <th>Performed By</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>
                                        <a href="#">{{ $log->user->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.deposits.show', $log->deposit_id) }}">#{{ $log->deposit_id }}</a>
                                    </td>
                                    <td>
                                        @if($log->action_type === 'approved' || $log->action_type === 'appeal_approved')
                                            <span class="badge bg-success">{{ $log->formatted_action }}</span>
                                        @elseif($log->action_type === 'rejected' || $log->action_type === 'appeal_rejected')
                                            <span class="badge bg-danger">{{ $log->formatted_action }}</span>
                                        @elseif($log->action_type === 'verified')
                                            <span class="badge bg-info">{{ $log->formatted_action }}</span>
                                        @elseif($log->action_type === 'appealed')
                                            <span class="badge bg-warning text-dark">{{ $log->formatted_action }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $log->formatted_action }}</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($log->amount, 6) }} USDT</td>
                                    <td>{{ number_format($log->fee_amount, 6) }} USDT</td>
                                    <td>{{ number_format($log->credited_amount, 6) }} USDT</td>
                                    <td>{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                                    <td>
                                        @if($log->performed_by)
                                            {{ $log->admin->name ?? 'Admin #' . $log->performed_by }}
                                        @else
                                            {{ $log->user->name }} (User)
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info view-notes" data-bs-toggle="modal" data-bs-target="#viewNotesModal" data-notes="{{ $log->notes }}">
                                            <i class="fa fa-eye me-1"></i> View
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No transaction logs found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $logs->appends(request()->all())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            <!-- /Transaction Logs List -->
        </div>
    </div>
</div>

<!-- View Notes Modal -->
<div class="modal fade" id="viewNotesModal" tabindex="-1" aria-labelledby="viewNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNotesModalLabel">Transaction Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="notesContent" class="p-3 bg-light rounded"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // View Notes Modal
        $('.view-notes').on('click', function() {
            var notes = $(this).data('notes');
            $('#notesContent').text(notes || 'No notes available');
        });
    });
</script>
@endpush

@endsection