{{-- backend.contributions.calendar --}}

@extends('admin.admin_master')
@section('title', 'Contribution Calendar')
@section('admin')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="fs-18 mb-0">@yield('title')</h4>
                        <small class="text-muted">View monthly contribution calendar for users</small>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.contributions.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-2"></i>Record Contribution
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Select User</label>
                        <select id="user_select" class="form-select">
                            <option value="">Choose a user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $selectedUserId == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Select Month</label>
                        <input type="month" id="month_select" class="form-control" value="{{ $selectedMonth }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" id="loadCalendar" class="btn btn-primary d-block">
                            <i class="ri-calendar-line me-2"></i>Load Calendar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" id="exportCalendar" class="btn btn-outline-success d-block" 
                                {{ !$selectedUserId ? 'disabled' : '' }}>
                            <i class="ri-download-line me-2"></i>Export
                        </button>
                    </div>
                </div>

                @if($selectedUserId && !empty($calendarData))
                    <!-- User Info Card -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            @php
                                                $user = $users->find($selectedUserId);
                                                $monthlyTotal = collect($calendarData)->where('has_contribution', true)->sum('amount');
                                                $paidDays = collect($calendarData)->where('has_contribution', true)->where('status', 'paid')->where('amount', '>', 0)->count();
                                                $unpaidDays = collect($calendarData)->where('has_contribution', true)->where('amount', '<=', 0)->count();
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->photo ? asset($user->photo) : asset('upload/no_image.jpg') }}" 
                                                     alt="User" class="rounded-circle me-3" width="50" height="50">
                                                <div>
                                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                                    <p class="text-muted mb-0">{{ $user->email }} | {{ $user->phone }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="stat-card bg-success text-white p-3 rounded">
                                                        <div class="fs-3 fw-bold">₦{{ number_format($monthlyTotal, 0) }}</div>
                                                        <div class="small fw-medium">Monthly Total</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="stat-card bg-primary text-white p-3 rounded">
                                                        <div class="fs-3 fw-bold">{{ $paidDays }}</div>
                                                        <div class="small fw-medium">Paid Days</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="stat-card bg-danger text-white p-3 rounded">
                                                        <div class="fs-3 fw-bold">{{ $unpaidDays }}</div>
                                                        <div class="small fw-medium">Unpaid Days</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }} Calendar</h5>
                                    <div class="calendar-legend d-flex gap-4">
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
                                <div class="card-body p-0">
                                    <div id="contribution-calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="ri-calendar-line display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Select a user to view their contribution calendar</h4>
                            <p class="text-muted">Choose a user from the dropdown above to see their monthly contribution pattern</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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
                <button type="button" id="addContributionBtn" class="btn btn-success">Add Contribution</button>
            </div>
        </div>
    </div>
</div>

<!-- Include FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.css" rel="stylesheet">

<!-- Include FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let calendar;

$(document).ready(function() {
    // Initialize calendar if we have data
    @if($selectedUserId && !empty($calendarData))
        initializeCalendar();
    @endif

    // Load calendar when filters change
    $('#loadCalendar').on('click', function() {
        const userId = $('#user_select').val();
        const month = $('#month_select').val();
        
        if (!userId) {
            Swal.fire('Error', 'Please select a user first', 'error');
            return;
        }
        
        if (!month) {
            Swal.fire('Error', 'Please select a month', 'error');
            return;
        }
        
        window.location.href = `{{ route('admin.contributions.calendar') }}?user_id=${userId}&month=${month}`;
    });

    // Export calendar
    $('#exportCalendar').on('click', function() {
        const userId = $('#user_select').val();
        const month = $('#month_select').val();
        
        if (!userId) {
            Swal.fire('Error', 'Please select a user first', 'error');
            return;
        }
        
        window.open(`{{ route('admin.contributions.export') }}?user_id=${userId}&month=${month}&format=excel`, '_blank');
    });

    // Enable/disable export button based on user selection
    $('#user_select').on('change', function() {
        $('#exportCalendar').prop('disabled', !$(this).val());
    });
});

function initializeCalendar() {
    const calendarEl = document.getElementById('contribution-calendar');
    
    // Prepare events from calendar data
    const events = [];
    const calendarData = @json($calendarData);
    
    Object.keys(calendarData).forEach(date => {
        const dayData = calendarData[date];
        
        if (dayData.has_contribution) {
            const isPaid = dayData.amount > 0 && dayData.status === 'paid';
            const isToday = dayData.is_today;
            
            events.push({
                id: dayData.contribution_id || date,
                title: isPaid ? `₦${Number(dayData.amount).toLocaleString()}` : '₦0',
                start: date,
                allDay: true,
                backgroundColor: 'transparent',
                borderColor: isToday ? '#17a2b8' : (isPaid ? '#28A745' : '#DC3545'),
                textColor: isToday ? '#17a2b8' : (isPaid ? '#28A745' : '#DC3545'),
                color: isToday ? '#17a2b8' : (isPaid ? '#28A745' : '#DC3545'),
                classNames: ['contribution-event'],
                extendedProps: {
                    amount: dayData.amount,
                    status: dayData.status,
                    transaction_id: dayData.transaction_id,
                    payment_method: dayData.payment_method,
                    is_today: isToday,
                    is_paid: isPaid
                }
            });
        }
    });

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: '{{ $selectedMonth }}-01',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        height: 'auto',
        events: events,
        eventDisplay: 'block',
        dayMaxEvents: 1,
        fixedWeekCount: false,
        showNonCurrentDates: false,
        eventClick: function(info) {
            showContributionDetails(info.event);
        },
        dateClick: function(info) {
            const selectedDate = info.dateStr;
            const today = new Date().toISOString().split('T')[0];
            const futureDate = selectedDate > today;
            
            // Check if there's already a contribution for this date
            const existingEvent = calendar.getEvents().find(event => event.startStr === selectedDate);
            
            if (existingEvent) {
                showContributionDetails(existingEvent);
            } else if (!futureDate) {
                showAddContributionModal(selectedDate);
            } else {
                Swal.fire('Info', 'Cannot add contributions for future dates', 'info');
            }
        },
        eventDidMount: function(info) {
            // Add tooltip
            info.el.title = `${info.event.title} - ${info.event.extendedProps.status}`;
            
            // Add custom styling for better visibility
            if (info.event.extendedProps.is_today) {
                info.el.classList.add('today-event');
            }
        }
    });

    calendar.render();
}

function showContributionDetails(event) {
    const props = event.extendedProps;
    const date = new Date(event.start).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    const statusBadge = props.is_paid 
        ? '<span class="badge bg-success">Paid</span>'
        : '<span class="badge bg-danger">Unpaid</span>';
    
    const content = `
        <div class="row">
            <div class="col-12 mb-3">
                <h6><i class="ri-calendar-line me-2"></i>Date</h6>
                <p class="mb-0 fw-medium">${date}</p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><i class="ri-money-dollar-circle-line me-2"></i>Amount</h6>
                <p class="mb-0 fw-bold fs-5 ${props.is_paid ? 'text-success' : 'text-danger'}">
                    ₦${Number(props.amount).toLocaleString()}
                </p>
            </div>
            <div class="col-md-6 mb-3">
                <h6><i class="ri-flag-line me-2"></i>Status</h6>
                <p class="mb-0">${statusBadge}</p>
            </div>
            ${props.transaction_id ? `
                <div class="col-md-6 mb-3">
                    <h6><i class="ri-file-text-line me-2"></i>Transaction ID</h6>
                    <p class="mb-0"><code>${props.transaction_id}</code></p>
                </div>
            ` : ''}
            ${props.payment_method ? `
                <div class="col-md-6 mb-3">
                    <h6><i class="ri-bank-card-line me-2"></i>Payment Method</h6>
                    <p class="mb-0 text-capitalize">${props.payment_method.replace('_', ' ')}</p>
                </div>
            ` : ''}
        </div>
    `;
    
    $('#contributionModalContent').html(content);
    $('#editContributionBtn').data('date', event.startStr).show();
    $('#addContributionBtn').hide();
    $('#contributionModal').modal('show');
}

function showAddContributionModal(date) {
    const formattedDate = new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    const content = `
        <div class="text-center py-4">
            <i class="ri-add-circle-line display-4 text-primary mb-3"></i>
            <h5>Add Contribution</h5>
            <p class="text-muted">No contribution recorded for <strong>${formattedDate}</strong></p>
            <p class="text-muted">Would you like to add a contribution for this date?</p>
        </div>
    `;
    
    $('#contributionModalContent').html(content);
    $('#editContributionBtn').hide();
    $('#addContributionBtn').data('date', date).show();
    $('#contributionModal').modal('show');
}

// Modal button handlers
$(document).on('click', '#editContributionBtn', function() {
    const date = $(this).data('date');
    const userId = '{{ $selectedUserId }}';
    window.location.href = `{{ route('admin.contributions.create') }}?date=${date}&user_id=${userId}`;
});

$(document).on('click', '#addContributionBtn', function() {
    const date = $(this).data('date');
    const userId = '{{ $selectedUserId }}';
    window.location.href = `{{ route('admin.contributions.create') }}?date=${date}&user_id=${userId}`;
});
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
    .legend-dot {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-card {
        transition: transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    
    .empty-state {
        padding: 3rem 1rem;
    }
    
    .rounded-circle {
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* FullCalendar Customizations */
    .fc-event.contribution-event {
        border-radius: 6px !important;
        font-weight: 900 !important;
        font-size: 12px !important;
        padding: 3px 5px !important;
        margin: 1px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        border-width: 2px !important;
        background: transparent !important;
        min-height: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .fc-daygrid-event {
        margin: 1px !important;
        background: transparent !important;
    }
    
    .fc-daygrid-event .fc-event-title {
        font-weight: 900 !important;
        font-size: 11px !important;
    }
    
    .fc-event-title {
        font-weight: 900 !important;
    }
    
    .fc-day-today {
        background-color: rgba(23, 162, 184, 0.08) !important;
        border: 2px solid #17a2b8 !important;
    }
    
    .today-event {
        box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.5) !important;
        animation: pulse-blue 2s infinite;
        background: transparent !important;
    }
    
    .today-event .fc-event-title {
        color: #17a2b8 !important;
    }
    
    @keyframes pulse-blue {
        0% { box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.5); }
        50% { box-shadow: 0 0 0 4px rgba(23, 162, 184, 0.3); }
        100% { box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.5); }
    }
    
    .fc-toolbar-title {
        font-size: 1.75rem !important;
        font-weight: 700 !important;
        color: #2C3E50 !important;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    
    .fc-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border: none !important;
        color: white !important;
        font-weight: 600 !important;
        border-radius: 6px !important;
        padding: 8px 16px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .fc-button:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
    }
    
    .fc-button:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25) !important;
    }
    
    .fc-button-active {
        background: linear-gradient(135deg, #4c51bf 0%, #5a67d8 100%) !important;
    }
    
    .fc-day {
        cursor: pointer;
        transition: background-color 0.2s ease;
        font-weight: 600;
    }
    
    .fc-day:hover {
        background-color: rgba(102, 126, 234, 0.05) !important;
    }
    
    .fc-daygrid-day-number {
        font-weight: 700 !important;
        font-size: 14px !important;
        color: #2C3E50 !important;
    }
    
    .fc-col-header-cell {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        font-weight: 700 !important;
        color: #495057 !important;
        border-bottom: 2px solid #dee2e6 !important;
        padding: 12px 8px !important;
    }
    
    .fc-scrollgrid {
        border: 2px solid #e9ecef !important;
        border-radius: 10px !important;
        overflow: hidden;
    }
    
    .fc-day-other {
        opacity: 0.3 !important;
    }
    
    /* Force text visibility in all event elements */
    .fc-event, .fc-event:hover, .fc-event:focus {
        background: transparent !important;
    }
    
    .fc-event .fc-event-main, 
    .fc-event .fc-event-main-frame,
    .fc-event .fc-event-title-container,
    .fc-event .fc-event-title {
        background: transparent !important;
        font-weight: 900 !important;
    }
    
    /* Ensure proper contrast for event text */
    .fc-daygrid-event-harness .fc-event {
        background: transparent !important;
        border-width: 2px !important;
        border-style: solid !important;
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
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
        border-radius: 12px 12px 0 0;
    }
    
    .modal-header .btn-close {
        filter: invert(1);
    }
    
    .modal-title {
        font-weight: 700;
    }
    
    code {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid #dee2e6;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .btn-outline-success {
        border: 2px solid #28a745;
        font-weight: 600;
        color: #28a745;
    }
    
    .btn-outline-success:hover {
        background: #28a745;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }
    
    .form-select, .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-weight: 500;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }
</style>
@endpush

@endsection