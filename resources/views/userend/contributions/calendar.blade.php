@extends('userend.user_home')
@section('title', 'My Contribution Calendar')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">My Contribution Calendar</h3>
                    <div class="nk-block-des text-soft">
                        <p>Track your daily contributions and payment history</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Dashboard</span>
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <!-- Month Selector -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Select Month</label>
                                <input type="month" id="month_select" class="form-control" value="{{ $selectedMonth }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" id="loadCalendar" class="btn btn-primary d-block">
                                    <em class="icon ni ni-calendar"></em>
                                    <span>Load Calendar</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">Legend</label>
                                <div class="d-flex gap-3 flex-wrap">
                                    <div class="d-flex align-items-center">
                                        <div class="legend-dot bg-success me-2"></div>
                                        <span class="fw-bold text-success">Paid</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="legend-dot bg-danger me-2"></div>
                                        <span class="fw-bold text-danger">Unpaid</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="legend-dot bg-info me-2"></div>
                                        <span class="fw-bold text-info">Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($calendarData))
            <!-- Monthly Summary -->
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Total Amount</h6>
                                            @php
                                                $hasBreakdown = isset($monthlyStats['breakdown']);
                                                $netAdjustments = $hasBreakdown && isset($monthlyStats['breakdown']['net_adjustments']) 
                                                    ? $monthlyStats['breakdown']['net_adjustments'] : 0;
                                                $rawContributions = $hasBreakdown && isset($monthlyStats['breakdown']['raw_contributions']) 
                                                    ? $monthlyStats['breakdown']['raw_contributions'] : 0;
                                            @endphp
                                            @if($hasBreakdown && $netAdjustments != 0)
                                                <em class="card-hint-icon ni ni-help-fill ms-1" data-bs-toggle="tooltip" 
                                                    title="Raw: ₦{{ number_format($rawContributions, 2) }}, Net adjustments: ₦{{ number_format($netAdjustments, 2) }}"></em>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">₦{{ number_format($monthlyStats['total_amount'] ?? 0, 2) }}</div>
                                            @if($hasBreakdown && $netAdjustments != 0)
                                                <div class="amount-sm text-muted">
                                                    Raw: ₦{{ number_format($rawContributions, 2) }}
                                                    @if($netAdjustments > 0)
                                                        <span class="text-success">+₦{{ number_format($netAdjustments, 2) }}</span>
                                                    @elseif($netAdjustments < 0)
                                                        <span class="text-danger">₦{{ number_format($netAdjustments, 2) }}</span>
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

                    <div class="col-sm-6 col-lg-3">
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
                                            <div class="amount">{{ $monthlyStats['paid_days'] ?? 0 }}</div>
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
                                            <h6 class="title">Unpaid Days</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">{{ $monthlyStats['unpaid_days'] ?? 0 }}</div>
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

                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Completion Rate</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="data-group">
                                            <div class="amount">{{ number_format($monthlyStats['completion_rate'] ?? 0, 1) }}%</div>
                                        </div>
                                        <div class="info">
                                            @php $completionRate = $monthlyStats['completion_rate'] ?? 0; @endphp
                                            <span class="change {{ $completionRate >= 80 ? 'up text-success' : 'down text-warning' }}">
                                                <em class="icon ni ni-arrow-long-{{ $completionRate >= 80 ? 'up' : 'down' }}"></em>
                                                Performance
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Show adjustment breakdown if there were adjustments this month --}}
                @php
                    $omittedAdditions = $hasBreakdown && isset($monthlyStats['breakdown']['omitted_additions']) 
                        ? $monthlyStats['breakdown']['omitted_additions'] : 0;
                    $correctionsSubtracted = $hasBreakdown && isset($monthlyStats['breakdown']['corrections_subtracted']) 
                        ? $monthlyStats['breakdown']['corrections_subtracted'] : 0;
                @endphp
                
                @if($hasBreakdown && ($omittedAdditions > 0 || $correctionsSubtracted > 0))
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <em class="icon ni ni-info"></em>
                                    {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }} Adjustments Applied
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Raw Contributions:</strong><br>
                                        ₦{{ number_format($rawContributions, 2) }}
                                    </div>
                                    @if($omittedAdditions > 0)
                                        <div class="col-md-4">
                                            <strong class="text-success">+ Omitted Contributions:</strong><br>
                                            <span class="text-success">₦{{ number_format($omittedAdditions, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($correctionsSubtracted > 0)
                                        <div class="col-md-4">
                                            <strong class="text-danger">- Corrections/Refunds:</strong><br>
                                            <span class="text-danger">₦{{ number_format($correctionsSubtracted, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <hr class="my-2">
                                <div class="fw-bold">
                                    Final Monthly Total: ₦{{ number_format($monthlyStats['total_amount'] ?? 0, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Calendar Section -->
            <div class="nk-block">
                <div class="card">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">{{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }} Calendar</h6>
                            </div>
                            <div class="card-tools">
                                <ul class="btn-toolbar gx-1">
                                    <li>
                                        <a href="{{ route('user.contributions.history') }}" class="btn btn-icon btn-sm btn-outline-primary">
                                            <em class="icon ni ni-histroy"></em>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Simple Calendar Grid -->
                        <div class="calendar-container mt-3">
                            <!-- Calendar Days Header -->
                            <div class="calendar-grid">
                                <div class="calendar-row calendar-header-row">
                                    <div class="calendar-header-cell">Sun</div>
                                    <div class="calendar-header-cell">Mon</div>
                                    <div class="calendar-header-cell">Tue</div>
                                    <div class="calendar-header-cell">Wed</div>
                                    <div class="calendar-header-cell">Thu</div>
                                    <div class="calendar-header-cell">Fri</div>
                                    <div class="calendar-header-cell">Sat</div>
                                </div>

                                <!-- Calendar Days -->
                                @php
                                    $monthStart = Carbon\Carbon::parse($selectedMonth)->startOfMonth();
                                    $monthEnd = Carbon\Carbon::parse($selectedMonth)->endOfMonth();
                                    $calendarStart = $monthStart->copy()->startOfWeek();
                                    $calendarEnd = $monthEnd->copy()->endOfWeek();
                                    $currentDate = $calendarStart->copy();
                                @endphp

                                @while($currentDate <= $calendarEnd)
                                    <div class="calendar-row">
                                        @for($i = 0; $i < 7; $i++)
                                            @php
                                                $dateKey = $currentDate->format('Y-m-d');
                                                $dayData = $calendarData[$dateKey] ?? null;
                                                $isCurrentMonth = $currentDate->month == $monthStart->month;
                                                $isToday = $currentDate->isToday();
                                                $isWeekend = $currentDate->isWeekend();
                                                $isPaid = $dayData && $dayData['status'] === 'paid' && $dayData['amount'] > 0;
                                                $isUnpaid = $dayData && ($dayData['status'] === 'unpaid' || $dayData['amount'] == 0);
                                            @endphp
                                            
                                            <div class="calendar-cell 
                                                {{ !$isCurrentMonth ? 'other-month' : '' }}
                                                {{ $isToday ? 'today' : '' }}
                                                {{ $isWeekend ? 'weekend' : '' }}
                                                {{ $isPaid ? 'paid-day' : '' }}
                                                {{ $isUnpaid ? 'unpaid-day' : '' }}"
                                                data-date="{{ $dateKey }}"
                                                data-amount="{{ $dayData['amount'] ?? 0 }}"
                                                data-status="{{ $dayData['status'] ?? 'no-record' }}"
                                                data-transaction="{{ $dayData['transaction_id'] ?? '' }}"
                                                onclick="showDayDetails(this)">
                                                
                                                <div class="calendar-day">{{ $currentDate->day }}</div>
                                                
                                                @if($dayData && $isCurrentMonth && $dayData['has_contribution'])
                                                    <div class="calendar-amount">
                                                        @if($dayData['amount'] > 0)
                                                            ₦{{ number_format($dayData['amount'], 0) }}
                                                        @else
                                                            ₦0
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="calendar-status">
                                                        @if($isPaid)
                                                            <em class="icon ni ni-check-circle text-success"></em>
                                                        @elseif($isUnpaid)
                                                            <em class="icon ni ni-cross-circle text-danger"></em>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @php $currentDate->addDay(); @endphp
                                        @endfor
                                    </div>
                                @endwhile
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="nk-block">
                <div class="card">
                    <div class="card-inner text-center py-5">
                        <div class="empty-state">
                            <em class="icon ni ni-calendar" style="font-size: 4rem; color: #c4c4c4;"></em>
                            <h4 class="mt-3">No contribution data</h4>
                            <p class="text-soft">Select a month to view your contribution calendar</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Contribution Details Modal -->
<div class="modal fade" id="contributionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contribution Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="contributionModalContent">
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
$(document).ready(function() {
    // Load calendar when month changes
    $('#loadCalendar').on('click', function() {
        const month = $('#month_select').val();
        
        if (!month) {
            alert('Please select a month');
            return;
        }
        
        // Show loading state
        $(this).prop('disabled', true).html('<em class="icon ni ni-loader"></em><span>Loading...</span>');
        
        // Redirect to calendar page with selected month
        window.location.href = `{{ route('user.contributions.calendar') }}?month=${month}`;
    });

    // Auto-load when month input changes
    $('#month_select').on('change', function() {
        $('#loadCalendar').trigger('click');
    });
});

function showDayDetails(element) {
    const date = $(element).data('date');
    const amount = $(element).data('amount');
    const status = $(element).data('status');
    const transactionId = $(element).data('transaction');
    
    if (status === 'no-record') {
        return;
    }
    
    const formattedDate = new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    const isPaid = status === 'paid' && amount > 0;
    const statusBadge = isPaid 
        ? '<span class="badge bg-success">Paid</span>'
        : '<span class="badge bg-danger">Unpaid</span>';
    
    const content = `
        <div class="row">
            <div class="col-12 mb-3">
                <h6><em class="icon ni ni-calendar me-2"></em>Date</h6>
                <p class="mb-0 fw-medium">${formattedDate}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-money me-2"></em>Amount</h6>
                <p class="mb-0 fw-bold fs-5 ${isPaid ? 'text-success' : 'text-danger'}">
                    ₦${Number(amount).toLocaleString()}
                </p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><em class="icon ni ni-flag me-2"></em>Status</h6>
                <p class="mb-0">${statusBadge}</p>
            </div>
            ${transactionId ? `
                <div class="col-12 mb-3">
                    <h6><em class="icon ni ni-file-text me-2"></em>Transaction Reference</h6>
                    <p class="mb-0"><code>${transactionId}</code></p>
                </div>
            ` : ''}
        </div>
    `;
    
    $('#contributionModalContent').html(content);
    $('#contributionModal').modal('show');
}
</script>

@push('css')
<style>
.legend-dot {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.empty-state {
    padding: 3rem 1rem;
}

/* Calendar Styles */
.calendar-container {
    max-width: 100%;
    overflow-x: auto;
}

.calendar-grid {
    display: table;
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
}

.calendar-row {
    display: table-row;
}

.calendar-header-row {
    background-color: #f8f9fa;
}

.calendar-header-cell,
.calendar-cell {
    display: table-cell;
    border: 1px solid #dee2e6;
    padding: 0;
    vertical-align: top;
    width: 14.28%;
    height: 100px;
    position: relative;
}

.calendar-header-cell {
    text-align: center;
    font-weight: 600;
    padding: 10px;
    height: auto;
    background-color: #f8f9fa;
}

.calendar-cell {
    cursor: pointer;
    transition: all 0.2s ease;
}

.calendar-cell:hover {
    background-color: #f0f0f0;
    transform: scale(1.02);
}

.calendar-day {
    position: absolute;
    top: 5px;
    left: 8px;
    font-weight: 600;
    font-size: 14px;
}

.calendar-amount {
    position: absolute;
    bottom: 5px;
    left: 8px;
    font-size: 11px;
    font-weight: 600;
}

.calendar-status {
    position: absolute;
    top: 5px;
    right: 8px;
    font-size: 16px;
}

.paid-day {
    background-color: #d4edda;
    border-color: #28a745;
}

.unpaid-day {
    background-color: #f8d7da;
    border-color: #dc3545;
}

.weekend {
    background-color: #f8f9fa;
    color: #6c757d;
}

.today {
    background-color: #fff3cd;
    border-color: #ffc107;
    font-weight: bold;
}

.other-month {
    opacity: 0.3;
    color: #adb5bd;
}

.calendar-cell.paid-day .calendar-amount {
    color: #28a745;
    font-weight: bold;
}

.calendar-cell.unpaid-day .calendar-amount {
    color: #dc3545;
    font-weight: bold;
}

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

@media (max-width: 768px) {
    .calendar-container {
        font-size: 12px;
    }
    
    .calendar-cell {
        height: 80px;
    }
    
    .calendar-amount {
        font-size: 10px;
    }
    
    .nk-ecwg6 .amount {
        font-size: 1.25rem;
    }
}
</style>
@endpush

@endsection