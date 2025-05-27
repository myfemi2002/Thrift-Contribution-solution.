{{-- backend.withdrawals.show-modal --}}

<div class="withdrawal-details">
    <div class="row">
        <!-- User Information -->
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent">
                    <h6 class="card-title mb-0">
                        <i class="ri-user-line me-2"></i>User Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $withdrawal->user->photo ? asset($withdrawal->user->photo) : asset('upload/no_image.jpg') }}" 
                             alt="User" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-1">{{ $withdrawal->user->name }}</h6>
                            <p class="text-muted mb-0 small">{{ $withdrawal->user->email }}</p>
                            @if($withdrawal->user->phone)
                                <small class="text-muted">{{ $withdrawal->user->phone }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted">Wallet Balance</small>
                            <div class="fw-bold text-success">₦{{ number_format($withdrawal->wallet->balance, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Total Contributions</small>
                            <div class="fw-bold">₦{{ number_format($withdrawal->wallet->getActualTotalContributions(), 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Information -->
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent">
                    <h6 class="card-title mb-0">
                        <i class="ri-money-dollar-circle-line me-2"></i>Withdrawal Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <small class="text-muted">Withdrawal ID</small>
                            <div class="fw-bold font-monospace text-primary">{{ $withdrawal->withdrawal_id }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Amount</small>
                            <div class="fw-bold text-success h5">₦{{ number_format($withdrawal->amount, 2) }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Status</small>
                            <div>{!! $withdrawal->status_badge !!}</div>
                        </div>
                        @if($withdrawal->fee > 0)
                            <div class="col-6">
                                <small class="text-muted">Processing Fee</small>
                                <div class="fw-bold text-warning">₦{{ number_format($withdrawal->fee, 2) }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Net Amount</small>
                                <div class="fw-bold text-primary">₦{{ number_format($withdrawal->net_amount, 2) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Payment Details -->
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent">
                    <h6 class="card-title mb-0">
                        <i class="ri-bank-card-line me-2"></i>Payment Method
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge bg-{{ $withdrawal->payment_method === 'cash' ? 'success' : 'info' }} me-2">
                            {{ $withdrawal->payment_method_label }}
                        </span>
                    </div>
                    @if($withdrawal->payment_method === 'bank_transfer')
                        <div class="row g-2">
                            <div class="col-12">
                                <small class="text-muted">Bank Name</small>
                                <div class="fw-bold">{{ $withdrawal->bank_name }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Account Number</small>
                                <div class="fw-bold font-monospace">{{ $withdrawal->account_number }}</div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Account Name</small>
                                <div class="fw-bold">{{ $withdrawal->account_name }}</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning alert-sm mb-0">
                            <i class="ri-information-line me-2"></i>
                            Cash payment - User will collect from admin
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent">
                    <h6 class="card-title mb-0">
                        <i class="ri-time-line me-2"></i>Status Timeline
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline-sm">
                        <div class="timeline-item-sm">
                            <div class="timeline-marker-sm bg-primary"></div>
                            <div class="timeline-content-sm">
                                <div class="fw-bold small">Request Submitted</div>
                                <div class="text-muted small">{{ $withdrawal->created_at->format('M d, Y g:i A') }}</div>
                            </div>
                        </div>
                        @if($withdrawal->approved_at)
                            <div class="timeline-item-sm">
                                <div class="timeline-marker-sm bg-{{ $withdrawal->status === 'rejected' ? 'danger' : 'success' }}"></div>
                                <div class="timeline-content-sm">
                                    <div class="fw-bold small">
                                        {{ $withdrawal->status === 'rejected' ? 'Rejected' : 'Approved' }}
                                    </div>
                                    <div class="text-muted small">{{ $withdrawal->approved_at->format('M d, Y g:i A') }}</div>
                                    <div class="text-muted small">By {{ $withdrawal->approvedBy->name ?? 'System' }}</div>
                                </div>
                            </div>
                        @endif
                        @if($withdrawal->processed_at)
                            <div class="timeline-item-sm">
                                <div class="timeline-marker-sm bg-info"></div>
                                <div class="timeline-content-sm">
                                    <div class="fw-bold small">Processing</div>
                                    <div class="text-muted small">{{ $withdrawal->processed_at->format('M d, Y g:i A') }}</div>
                                </div>
                            </div>
                        @endif
                        @if($withdrawal->completed_at)
                            <div class="timeline-item-sm">
                                <div class="timeline-marker-sm bg-success"></div>
                                <div class="timeline-content-sm">
                                    <div class="fw-bold small">Completed</div>
                                    <div class="text-muted small">{{ $withdrawal->completed_at->format('M d, Y g:i A') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Balance Impact -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent">
                    <h6 class="card-title mb-0">
                        <i class="ri-pie-chart-line me-2"></i>Balance Impact
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center g-2">
                        <div class="col-3">
                            <div class="p-2 border rounded">
                                <div class="small text-muted">Before</div>
                                <div class="fw-bold text-info">₦{{ number_format($withdrawal->wallet_balance_before, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded">
                                <div class="small text-muted">Withdrawal</div>
                                <div class="fw-bold text-danger">-₦{{ number_format($withdrawal->amount, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded">
                                <div class="small text-muted">Expected</div>
                                <div class="fw-bold text-warning">₦{{ number_format($withdrawal->wallet_balance_before - $withdrawal->amount, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded">
                                <div class="small text-muted">Current</div>
                                <div class="fw-bold text-success">₦{{ number_format($withdrawal->wallet->balance, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reason and Notes -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-header bg-transparent">
                    <h6 class="card-title mb-0">
                        <i class="ri-chat-3-line me-2"></i>Reason & Notes
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted fw-bold">User's Reason</small>
                            <div class="bg-white p-2 rounded border small">
                                {{ $withdrawal->reason }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($withdrawal->admin_notes)
                                <small class="text-muted fw-bold">Admin Notes</small>
                                <div class="bg-info bg-opacity-10 p-2 rounded border small">
                                    {{ $withdrawal->admin_notes }}
                                </div>
                            @endif
                            @if($withdrawal->rejection_reason)
                                <small class="text-muted fw-bold">Rejection Reason</small>
                                <div class="bg-danger bg-opacity-10 p-2 rounded border small">
                                    {{ $withdrawal->rejection_reason }}
                                </div>
                            @endif
                            @if(!$withdrawal->admin_notes && !$withdrawal->rejection_reason)
                                <small class="text-muted fw-bold">Admin Notes</small>
                                <div class="text-muted small">
                                    <em>No notes available</em>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions (if withdrawal is pending) -->
    @if($withdrawal->isPending())
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-0 bg-primary bg-opacity-10">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Quick Actions</h6>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success btn-sm" onclick="approveWithdrawal('{{ $withdrawal->id }}')">
                                <i class="ri-check-line me-1"></i>Approve
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="rejectWithdrawal('{{ $withdrawal->id }}')">
                                <i class="ri-close-line me-1"></i>Reject
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($withdrawal->isApproved())
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-0 bg-info bg-opacity-10">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Next Actions</h6>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="markProcessing('{{ $withdrawal->id }}')">
                                <i class="ri-loader-line me-1"></i>Processing
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="markCompleted('{{ $withdrawal->id }}')">
                                <i class="ri-check-double-line me-1"></i>Complete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($withdrawal->isProcessing())
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-0 bg-success bg-opacity-10">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Final Action</h6>
                        <button type="button" class="btn btn-success btn-sm" onclick="markCompleted('{{ $withdrawal->id }}')">
                            <i class="ri-check-double-line me-1"></i>Mark Completed
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-{{ $withdrawal->isCompleted() ? 'success' : ($withdrawal->isRejected() ? 'danger' : 'secondary') }} mb-0">
                    <div class="d-flex align-items-center">
                        <i class="ri-{{ $withdrawal->isCompleted() ? 'check-double' : ($withdrawal->isRejected() ? 'close-circle' : 'information') }}-line me-2"></i>
                        <strong>Status:</strong> 
                        @if($withdrawal->isCompleted())
                            This withdrawal has been successfully completed.
                        @elseif($withdrawal->isRejected())
                            This withdrawal was rejected.
                        @else
                            This withdrawal is {{ $withdrawal->status }}.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Security Info (Collapsed by default) -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="accordion" id="securityAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#securityInfo">
                            <i class="ri-shield-check-line me-2"></i>Security Information
                        </button>
                    </h2>
                    <div id="securityInfo" class="accordion-collapse collapse" data-bs-parent="#securityAccordion">
                        <div class="accordion-body">
                            <div class="row g-2">
                                @if($withdrawal->ip_address)
                                    <div class="col-md-6">
                                        <small class="text-muted">IP Address</small>
                                        <div class="font-monospace small">{{ $withdrawal->ip_address }}</div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <small class="text-muted">Request Time</small>
                                    <div class="small">{{ $withdrawal->created_at->format('l, F j, Y g:i:s A') }}</div>
                                </div>
                                @if($withdrawal->user_agent)
                                    <div class="col-12">
                                        <small class="text-muted">User Agent</small>
                                        <div class="small text-muted">{{ Str::limit($withdrawal->user_agent, 120) }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-sm {
    position: relative;
    padding-left: 1.5rem;
}

.timeline-item-sm {
    position: relative;
    padding-bottom: 1rem;
}

.timeline-item-sm:before {
    content: '';
    position: absolute;
    left: -1.25rem;
    top: 0.375rem;
    width: 1px;
    height: calc(100% - 0.375rem);
    background-color: #dee2e6;
}

.timeline-item-sm:last-child:before {
    display: none;
}

.timeline-marker-sm {
    position: absolute;
    left: -1.5rem;
    top: 0.1875rem;
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    border: 1px solid #fff;
    box-shadow: 0 0 0 1px #dee2e6;
}

.timeline-content-sm .fw-bold {
    font-size: 0.8rem;
}

.timeline-content-sm .text-muted {
    font-size: 0.7rem;
}

.font-monospace {
    font-family: 'Courier New', monospace;
}

.rounded-circle {
    object-fit: cover;
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
</style>

