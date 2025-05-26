{{-- backend.contributions.create --}}

@extends('admin.admin_master')
@section('title', 'Record Daily Contribution')
@section('admin')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card bg-white border-0 rounded-3 mb-4">
            <div class="card-header bg-light py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="fs-18 mb-0">@yield('title')</h4>
                        <small class="text-muted">Search user and record their daily contribution</small>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.contributions.index') }}" class="btn btn-outline-primary">
                            <i class="ri-arrow-left-line me-2"></i>Back to Dashboard
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
                                                        <h6 class="card-title">Wallet Balance</h6>
                                                        <h4 id="wallet-balance" class="text-success mb-0">₦0.00</h4>
                                                        <small id="total-contributions" class="text-muted">Total: ₦0.00</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8">
                                            <div class="ps-md-4">
                                                <!-- Existing Contribution Alert -->
                                                <div id="existing-contribution-alert" style="display:none;" class="alert alert-warning mb-4">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-error-warning-line fs-24 me-2"></i>
                                                        <div>
                                                            <div class="fw-medium">Contribution Already Recorded</div>
                                                            <div class="small" id="existing-contribution-details"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contribution Form -->
                                                <div id="contribution-form">
                                                    <form id="recordContributionForm">
                                                        @csrf
                                                        <input type="hidden" id="user_id" name="user_id">
                                                        
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Contribution Date <span class="text-danger">*</span></label>
                                                                <input type="date" name="contribution_date" id="contribution_date" 
                                                                       class="form-control" value="{{ date('Y-m-d') }}" required>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <label class="form-label">Amount (₦) <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">₦</span>
                                                                    <input type="number" name="amount" id="amount" 
                                                                           class="form-control" step="0.01" min="0" 
                                                                           placeholder="0.00" required>
                                                                </div>
                                                                <small class="text-muted">Enter 0 for unpaid/skipped day</small>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                                                <select name="payment_method" class="form-select" required>
                                                                    <option value="">Select Payment Method</option>
                                                                    <option value="cash">Cash</option>
                                                                    <option value="bank_transfer">Bank Transfer</option>
                                                                    <option value="mobile_money">Mobile Money</option>
                                                                    <option value="card">Card</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-label">Receipt Number</label>
                                                                <input type="text" name="receipt_number" class="form-control" 
                                                                       placeholder="Optional receipt reference">
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label">Notes</label>
                                                                <textarea name="notes" class="form-control" rows="3" 
                                                                          placeholder="Optional notes about this contribution"></textarea>
                                                            </div>

                                                            <div class="col-12">
                                                                <hr class="my-3">
                                                                <div class="d-flex gap-2">
                                                                    <button type="submit" class="btn btn-success btn-lg flex-fill">
                                                                        <i class="ri-save-line me-2"></i>Record Contribution
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
                        <a href="{{ route('admin.contributions.calendar') }}" class="btn btn-outline-primary w-100">
                            <i class="ri-calendar-line me-2"></i>Calendar View
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.contributions.logs') }}" class="btn btn-outline-info w-100">
                            <i class="ri-file-list-line me-2"></i>Transaction Logs
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-success w-100" onclick="exportData('excel')">
                            <i class="ri-file-excel-line me-2"></i>Export Excel
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-danger w-100" onclick="exportData('pdf')">
                            <i class="ri-file-pdf-line me-2"></i>Export PDF
                        </button>
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
    $('#recordContributionForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate amount for payment method
        const amount = parseFloat($('#amount').val());
        const paymentMethod = $('select[name="payment_method"]').val();
        
        if (amount > 0 && !paymentMethod) {
            showAlert('error', 'Please select a payment method for paid contributions');
            return;
        }

        $.ajax({
            url: "{{ route('admin.contributions.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Contribution recorded successfully');
                $('#search_query').val('').focus();
                $('#user-details').fadeOut();
                $('#recordContributionForm')[0].reset();
                $('#contribution_date').val('{{ date('Y-m-d') }}');
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    showAlert('error', xhr.responseJSON.error);
                    if (xhr.responseJSON.existing_contribution) {
                        showExistingContribution(xhr.responseJSON.existing_contribution);
                    }
                } else if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = Object.values(errors).flat().join('\n');
                    showAlert('error', errorMessage);
                } else {
                    showAlert('error', 'Failed to record contribution');
                }
            }
        });
    });

    // Reset form
    $('#resetForm').on('click', function() {
        $('#search_query').val('').focus();
        $('#user-details').fadeOut();
        $('#recordContributionForm')[0].reset();
        $('#contribution_date').val('{{ date('Y-m-d') }}');
    });

    // Amount input change
    $('#amount').on('input', function() {
        const amount = parseFloat($(this).val());
        const paymentMethodSelect = $('select[name="payment_method"]');
        
        if (amount === 0) {
            paymentMethodSelect.prop('required', false);
            paymentMethodSelect.closest('.col-md-6').find('.text-danger').hide();
        } else {
            paymentMethodSelect.prop('required', true);
            paymentMethodSelect.closest('.col-md-6').find('.text-danger').show();
        }
    });

    function submitSearchForm() {
        let search_query = $('#search_query').val().trim();
        if (search_query !== '') {
            $('#searchBtn').prop('disabled', true).html('<i class="ri-loader-4-line me-2"></i>Searching...');
            
            $.ajax({
                url: "{{ route('admin.contributions.search-user') }}",
                method: 'POST',
                data: {
                    search_query: search_query,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.user) {
                        updateUserDetails(response.user, response.existing_contribution);
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

    function updateUserDetails(user, existingContribution) {
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
            $('#wallet-balance').text('₦' + parseFloat(user.wallet.balance).toLocaleString('en-US', {minimumFractionDigits: 2}));
            $('#total-contributions').text('Total: ₦' + parseFloat(user.wallet.total_contributions).toLocaleString('en-US', {minimumFractionDigits: 2}));
        }

        // Handle existing contribution
        if (existingContribution) {
            showExistingContribution(existingContribution);
        } else {
            $('#existing-contribution-alert').hide();
            $('#contribution-form').show();
        }
    }

    function showExistingContribution(contribution) {
        const contributionDate = new Date(contribution.contribution_date).toLocaleDateString();
        const amount = parseFloat(contribution.amount).toLocaleString('en-US', {minimumFractionDigits: 2});
        
        $('#existing-contribution-details').html(`
            <strong>Date:</strong> ${contributionDate} | 
            <strong>Amount:</strong> ₦${amount} | 
            <strong>Status:</strong> ${contribution.status} |
            <strong>Method:</strong> ${contribution.payment_method}
        `);
        
        $('#existing-contribution-alert').show();
        $('#contribution-form').hide();
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

function exportData(format) {
    const month = prompt('Enter month (YYYY-MM):', '{{ date('Y-m') }}');
    if (month) {
        window.open(`{{ route('admin.contributions.export') }}?format=${format}&month=${month}`, '_blank');
    }
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
    
    .btn-success {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        border: none;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #17a673 0%, #138f5a 100%);
    }
</style>
@endpush

@endsection