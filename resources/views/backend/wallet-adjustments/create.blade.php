@extends('admin.admin_master')
@section('title', 'Wallet Credit/Debit')
@section('admin')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card bg-white border-0 rounded-3 mb-4">
            <div class="card-header bg-light py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="fs-18 mb-0">@yield('title')</h4>
                        <small class="text-muted">Credit omitted contributions or debit incorrect amounts</small>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.wallet-adjustments.index') }}" class="btn btn-outline-primary">
                            <i class="ri-arrow-left-line me-2"></i>Back to Adjustments
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- Search Section -->
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8">
                        <div class="search-wrapper bg-light p-4 rounded-3">
                            <form id="searchForm">
                                @csrf
                                <div class="form-group">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-search-2-line me-2 text-primary fs-20"></i>
                                        <label class="text-dark mb-0 fs-16">Search User</label>
                                    </div>
                                    <small class="d-block text-muted mb-3">Search by name, phone, email or username</small>
                                    <div class="input-group input-group-lg">
                                        <input type="text" id="search_query" name="search_query" 
                                               class="form-control border-primary" 
                                               placeholder="Start typing to search user...">
                                        <button type="button" id="searchBtn" class="btn btn-primary px-4">
                                            <i class="ri-search-line me-2"></i>Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- User Details Section -->
                <div id="user-details" style="display:none;">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center border-end">
                                            <div class="mb-4">
                                                <img id="user-photo" src="" alt="User Photo" 
                                                     class="img-thumbnail mb-3" style="max-width: 150px; height: auto;">
                                                <h5 id="user-name" class="mb-1"></h5>
                                                <span id="user-email" class="text-muted d-block"></span>
                                                <span id="user-phone" class="text-muted d-block"></span>
                                            </div>
                                            
                                            <!-- Wallet Info -->
                                            <div class="wallet-info mt-3">
                                                <div class="card bg-light">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title">Current Wallet</h6>
                                                        <h4 id="wallet-balance" class="text-success mb-0">₦0.00</h4>
                                                        <small id="total-contributions" class="text-muted">Total: ₦0.00</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Recent Adjustments -->
                                            <div class="recent-adjustments mt-3" id="recent-adjustments" style="display:none;">
                                                <h6 class="text-muted">Recent Adjustments</h6>
                                                <div id="adjustments-list">
                                                    <!-- Recent adjustments will be displayed here -->
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8">
                                            <div class="ps-md-4">
                                                <!-- Adjustment Form -->
                                                <div id="adjustment-form">
                                                    <form id="createAdjustmentForm">
                                                        @csrf
                                                        <input type="hidden" id="user_id" name="user_id">
                                                        
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <div class="alert alert-info">
                                                                    <i class="ri-information-line me-2"></i>
                                                                    <strong>Credit:</strong> Add money to user's wallet | 
                                                                    <strong>Debit:</strong> Remove money from user's wallet<br>
                                                                    <strong>Important:</strong> All adjustments require approval from another admin for security.
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Adjustment Type <span class="text-danger">*</span></label>
                                                                <select name="type" id="adjustment_type" class="form-select" required>
                                                                    <option value="">Select Type</option>
                                                                    <option value="credit">Credit (Add Money)</option>
                                                                    <option value="debit">Debit (Remove Money)</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <label class="form-label">Amount (₦) <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">₦</span>
                                                                    <input type="number" name="amount" id="amount" 
                                                                           class="form-control" step="0.01" min="0.01" 
                                                                           placeholder="0.00" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Reason <span class="text-danger">*</span></label>
                                                                <select name="reason" class="form-select" required>
                                                                    <option value="">Select Reason</option>
                                                                    <option value="omitted_contribution">Omitted Contribution</option>
                                                                    <option value="correction_error">Correction Error</option>
                                                                    <option value="duplicate_payment">Duplicate Payment</option>
                                                                    <option value="system_error">System Error</option>
                                                                    <option value="refund">Refund</option>
                                                                    <option value="bonus">Bonus</option>
                                                                    <option value="penalty">Penalty</option>
                                                                    <option value="admin_adjustment">Admin Adjustment</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Reference Date</label>
                                                                <input type="date" name="reference_date" class="form-control">
                                                                <small class="text-muted">Date related to this adjustment (e.g., omitted contribution date)</small>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Reference Number</label>
                                                                <input type="text" name="reference_number" class="form-control" 
                                                                       placeholder="e.g., Receipt #, Transaction ID, Ticket #">
                                                                <small class="text-muted">Any external reference (receipt, transaction ID, support ticket, etc.)</small>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mt-4">
                                                                    <div class="alert alert-warning mb-0">
                                                                        <i class="ri-shield-check-line me-2"></i>
                                                                        <strong>Security Notice:</strong><br>
                                                                        This adjustment will be pending until approved by another admin.
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                                                <textarea name="description" class="form-control" rows="3" 
                                                                          placeholder="Detailed description of why this adjustment is needed..." required></textarea>
                                                            </div>

                                                            <!-- Preview Section -->
                                                            <div class="col-12" id="adjustment-preview" style="display:none;">
                                                                <hr class="my-3">
                                                                <div class="alert alert-warning">
                                                                    <h6 class="alert-heading">Adjustment Preview</h6>
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <strong>Current Balance:</strong><br>
                                                                            <span id="preview-current-balance">₦0.00</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <strong>Adjustment:</strong><br>
                                                                            <span id="preview-adjustment">₦0.00</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <strong>New Balance:</strong><br>
                                                                            <span id="preview-new-balance" class="fw-bold">₦0.00</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <hr class="my-3">
                                                                <div class="d-flex gap-2">
                                                                    <button type="submit" class="btn btn-warning btn-lg flex-fill">
                                                                        <i class="ri-send-plane-line me-2"></i>Submit for Approval
                                                                    </button>
                                                                    <button type="button" id="resetForm" class="btn btn-outline-secondary">
                                                                        <i class="ri-refresh-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Card -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('admin.wallet-adjustments.index') }}" class="btn btn-outline-primary w-100">
                            <i class="ri-list-check-line me-2"></i>View All Adjustments
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.contributions.create') }}" class="btn btn-outline-info w-100">
                            <i class="ri-add-line me-2"></i>Record Contribution
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-success w-100" onclick="exportAdjustments()">
                            <i class="ri-file-excel-line me-2"></i>Export Report
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.contributions.logs') }}" class="btn btn-outline-warning w-100">
                            <i class="ri-file-list-line me-2"></i>Transaction Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let searchTimeout;
    let currentWalletBalance = 0;

    // Search input handling
    $('#search_query').on('input', function() {
        clearTimeout(searchTimeout);
        if ($(this).val() !== '') {
            searchTimeout = setTimeout(submitSearchForm, 800);
        }
    });

    $('#searchBtn').on('click', submitSearchForm);

    $('#search_query').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            submitSearchForm();
        }
    });

    // Form submissions
    $('#createAdjustmentForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        const type = $('#adjustment_type').val();
        const amount = parseFloat($('#amount').val());
        
        if (!type || !amount || amount <= 0) {
            showAlert('error', 'Please fill in all required fields');
            return;
        }

        // Check debit limit
        if (type === 'debit' && amount > currentWalletBalance) {
            showAlert('error', `Debit amount (₦${amount.toLocaleString()}) exceeds wallet balance (₦${currentWalletBalance.toLocaleString()})`);
            return;
        }

        $.ajax({
            url: "{{ route('admin.wallet-adjustments.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Success response:', response);
                showAlert('success', response.message);
                $('#search_query').val('').focus();
                $('#user-details').fadeOut();
                $('#createAdjustmentForm')[0].reset();
                updatePreview();
            },
            error: function(xhr) {
                console.log('Error response:', xhr.responseJSON);
                console.log('Status:', xhr.status);
                console.log('Full response:', xhr);
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors || {};
                    let errorMessage = Object.values(errors).flat().join('\n');
                    showAlert('error', 'Validation Error: ' + errorMessage);
                } else if (xhr.status === 400) {
                    showAlert('error', xhr.responseJSON.error || 'Bad Request');
                } else if (xhr.status === 500) {
                    let errorMsg = xhr.responseJSON?.error || 'Internal Server Error';
                    let debugInfo = xhr.responseJSON?.debug_info || {};
                    console.log('Debug Info:', debugInfo);
                    showAlert('error', errorMsg);
                } else {
                    showAlert('error', 'Failed to process adjustment. Check console for details.');
                }
            }
        });
    });

    // Reset form
    $('#resetForm').on('click', function() {
        $('#search_query').val('').focus();
        $('#user-details').fadeOut();
        $('#createAdjustmentForm')[0].reset();
        updatePreview();
    });

    // Update preview when form changes
    $('#adjustment_type, #amount').on('input change', updatePreview);

    function submitSearchForm() {
        let search_query = $('#search_query').val().trim();
        if (search_query !== '') {
            $('#searchBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-2"></i>Searching...');
            
            $.ajax({
                url: "{{ route('admin.wallet-adjustments.search-user') }}",
                method: 'POST',
                data: {
                    search_query: search_query,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.user) {
                        updateUserDetails(response.user, response.recent_adjustments);
                    }
                },
                error: function(xhr) {
                    showAlert('error', 'User not found');
                    $('#user-details').fadeOut();
                },
                complete: function() {
                    $('#searchBtn').prop('disabled', false).html('<i class="ri-search-line me-2"></i>Search');
                }
            });
        }
    }

    function updateUserDetails(user, recentAdjustments) {
        $('#user-details').fadeIn();
        
        // Update basic details
        $('#user-name').text(user.name);
        $('#user-email').text(user.email || 'N/A');
        $('#user-phone').text(user.phone || 'N/A');
        $('#user_id').val(user.id);
        
        // Update photo
        $('#user-photo').attr('src', user.photo ? 
            `/${user.photo}` : 
            "/upload/no_image.jpg");

        // Update wallet info
        if (user.wallet) {
            currentWalletBalance = parseFloat(user.wallet.balance);
            $('#wallet-balance').text('₦' + currentWalletBalance.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#total-contributions').text('Total: ₦' + parseFloat(user.wallet.total_contributions).toLocaleString('en-US', {minimumFractionDigits: 2}));
        }

        // Show recent adjustments
        if (recentAdjustments && recentAdjustments.length > 0) {
            let adjustmentsHtml = '';
            recentAdjustments.forEach(adj => {
                const typeClass = adj.type === 'credit' ? 'text-success' : 'text-danger';
                const typeSymbol = adj.type === 'credit' ? '+' : '-';
                adjustmentsHtml += `
                    <div class="small mb-1">
                        <span class="${typeClass}">${typeSymbol}₦${parseFloat(adj.amount).toLocaleString()}</span>
                        <span class="text-muted">(${adj.reason_label})</span>
                    </div>
                `;
            });
            $('#adjustments-list').html(adjustmentsHtml);
            $('#recent-adjustments').show();
        } else {
            $('#recent-adjustments').hide();
        }

        updatePreview();
    }

    function updatePreview() {
        const type = $('#adjustment_type').val();
        const amount = parseFloat($('#amount').val()) || 0;
        
        if (type && amount > 0 && currentWalletBalance > 0) {
            const newBalance = type === 'credit' 
                ? currentWalletBalance + amount 
                : currentWalletBalance - amount;
            
            $('#preview-current-balance').text('₦' + currentWalletBalance.toLocaleString('en-US', {minimumFractionDigits: 2}));
            
            const adjustmentText = (type === 'credit' ? '+' : '-') + '₦' + amount.toLocaleString('en-US', {minimumFractionDigits: 2});
            $('#preview-adjustment').text(adjustmentText);
            $('#preview-adjustment').removeClass('text-success text-danger').addClass(type === 'credit' ? 'text-success' : 'text-danger');
            
            $('#preview-new-balance').text('₦' + newBalance.toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#preview-new-balance').removeClass('text-success text-danger').addClass(newBalance >= 0 ? 'text-success' : 'text-danger');
            
            $('#adjustment-preview').show();
        } else {
            $('#adjustment-preview').hide();
        }
    }

    function showAlert(type, message) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 3000
        });
    }

    // Focus on search input when page loads
    $('#search_query').focus();
});

function exportAdjustments() {
    window.open(`{{ route('admin.wallet-adjustments.export') }}`, '_blank');
}
</script>

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
<style>
    .search-wrapper {
        border: 2px dashed #e3e6f0;
        transition: all 0.3s ease;
    }
    
    .search-wrapper:hover {
        border-color: #4e73df;
        background-color: #f8f9fc;
    }
    
    .wallet-info .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .img-thumbnail {
        border-radius: 50%;
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #f4b942 100%);
        border: none;
        color: #fff;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #f4b942 0%, #e2a441 100%);
        color: #fff;
    }

    .recent-adjustments .small {
        border-bottom: 1px solid #eee;
        padding-bottom: 2px;
    }

    .recent-adjustments .small:last-child {
        border-bottom: none;
    }

    #adjustment-preview {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }
</style>
@endpush

@endsection