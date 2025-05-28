@extends('userend.user_home')
@section('title', 'Edit Profile')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Edit Profile</h3>
                    <div class="nk-block-des text-soft">
                        <p>Update your account information and security settings</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.profile') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em>
                        <span>Back to Profile</span>
                    </a>
                    <a href="{{ route('user.profile') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                        <em class="icon ni ni-arrow-left"></em>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ !session('tab') || session('tab') == 'profile' ? 'active' : '' }}" 
                                        id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                                    <em class="icon ni ni-user me-2"></em>Personal Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ session('tab') == 'security' ? 'active' : '' }}" 
                                        id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                                    <em class="icon ni ni-shield-check me-2"></em>Security
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">
                                    <em class="icon ni ni-setting me-2"></em>Preferences
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-4" id="profileTabsContent">
                            <!-- Personal Information Tab -->
                            <div class="tab-pane fade {{ !session('tab') || session('tab') == 'profile' ? 'show active' : '' }}" 
                                 id="profile" role="tabpanel">
                                <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row gy-4">
                                        <!-- Profile Photo -->
<div class="col-12">
    <div class="form-group text-center">
        <label class="form-label d-block">Profile Photo</label>
        
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="position-relative mb-3" style="width: 150px; height: 150px;">
                <div class="rounded-circle overflow-hidden border border-secondary shadow-sm w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                    @if($user->photo)
                        <img src="{{ asset($user->photo) }}" alt="Profile Photo" id="preview-image" class="img-fluid w-100 h-100 object-fit-cover">
                    @else
                        <span id="preview-text" class="text-uppercase fw-bold fs-1 text-muted">{{ substr($user->name, 0, 2) }}</span>
                        <img src="" alt="" id="preview-image" style="display: none;" class="img-fluid w-100 h-100 object-fit-cover">
                    @endif
                </div>
            </div>

            <div class="mb-2">
                <label for="photo" class="btn btn-sm btn-primary">
                    <em class="icon ni ni-camera me-2"></em>Change Photo
                </label>
                <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
            </div>

            @error('photo')
                <div class="form-note text-danger">{{ $message }}</div>
            @enderror

            <div class="form-note">
                <span class="sub-text">Recommended size: 300x300px. Max file size: 2MB</span>
            </div>
        </div>
    </div>
</div>


                                        <!-- Full Name -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                </div>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Username -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="username">Username</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                                           id="username" name="username" value="{{ old('username', $user->username) }}">
                                                </div>
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-note">
                                                    <span class="sub-text">Choose a unique username (optional)</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                </div>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Phone Number</label>
                                                <div class="form-control-wrap">
                                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                                </div>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="address">Address</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                                              id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                                </div>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">
                                                    <em class="icon ni ni-save me-2"></em>Update Profile
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-pane fade {{ session('tab') == 'security' ? 'show active' : '' }}" 
                                 id="security" role="tabpanel">
                                <form method="POST" action="{{ route('user.profile.change-password') }}">
                                    @csrf
                                    
                                    <div class="row gy-4">
                                        <div class="col-12">
                                            <h6 class="overline-title">Change Password</h6>
                                            <p class="text-soft">Update your account password for better security</p>
                                        </div>

                                        <!-- Current Password -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="current_password">Current Password <span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                                           id="current_password" name="current_password" required>
                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="current_password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                </div>
                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- New Password -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="new_password">New Password <span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                                           id="new_password" name="new_password" required>
                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="new_password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                </div>
                                                @error('new_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-note">
                                                    <span class="sub-text">Password must be at least 8 characters long</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="new_password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <input type="password" class="form-control" 
                                                           id="new_password_confirmation" name="new_password_confirmation" required>
                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="new_password_confirmation">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">
                                                    <em class="icon ni ni-shield-check me-2"></em>Change Password
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Account Info -->
                                <hr class="my-5">
                                <div class="row gy-3">
                                    <div class="col-12">
                                        <h6 class="overline-title">Account Information</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Last Password Change</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" 
                                                       value="{{ $user->last_password_change ?? 'Never' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Two Factor Authentication</label>
                                            <div class="form-control-wrap">
                                                <span class="badge {{ $user->two_factor_enabled ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $user->two_factor_enabled ? 'Enabled' : 'Disabled' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Tab -->
                            <div class="tab-pane fade" id="settings" role="tabpanel">
                                <form method="POST" action="{{ route('user.profile.settings') }}">
                                    @csrf
                                    
                                    <div class="row gy-4">
                                        <div class="col-12">
                                            <h6 class="overline-title">Notification Preferences</h6>
                                            <p class="text-soft">Choose how you want to receive notifications</p>
                                        </div>

                                        <!-- Email Notifications -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="email_notifications" 
                                                           name="email_notifications" 
                                                           {{ $user->getProfileField('settings.email_notifications', true) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="email_notifications">Email Notifications</label>
                                                </div>
                                                <div class="form-note">
                                                    <span class="sub-text">Receive notifications via email</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SMS Notifications -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="sms_notifications" 
                                                           name="sms_notifications"
                                                           {{ $user->getProfileField('settings.sms_notifications', false) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="sms_notifications">SMS Notifications</label>
                                                </div>
                                                <div class="form-note">
                                                    <span class="sub-text">Receive notifications via SMS</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Push Notifications -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="push_notifications" 
                                                           name="push_notifications"
                                                           {{ $user->getProfileField('settings.push_notifications', true) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="push_notifications">Push Notifications</label>
                                                </div>
                                                <div class="form-note">
                                                    <span class="sub-text">Receive browser push notifications</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Newsletter -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="newsletter_subscription" 
                                                           name="newsletter_subscription"
                                                           {{ $user->getProfileField('settings.newsletter_subscription', false) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="newsletter_subscription">Newsletter</label>
                                                </div>
                                                <div class="form-note">
                                                    <span class="sub-text">Subscribe to our newsletter</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12"><hr></div>

                                        <div class="col-12">
                                            <h6 class="overline-title">Display Preferences</h6>
                                        </div>

                                        <!-- Language -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="language">Language</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" id="language" name="language">
                                                        <option value="en" {{ $user->getProfileField('settings.language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                                                        <option value="es" {{ $user->getProfileField('settings.language', 'en') == 'es' ? 'selected' : '' }}>Spanish</option>
                                                        <option value="fr" {{ $user->getProfileField('settings.language', 'en') == 'fr' ? 'selected' : '' }}>French</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Timezone -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="timezone">Timezone</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" id="timezone" name="timezone">
                                                        <option value="UTC" {{ $user->getProfileField('settings.timezone', 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                        <option value="America/New_York" {{ $user->getProfileField('settings.timezone', 'UTC') == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                                        <option value="America/Chicago" {{ $user->getProfileField('settings.timezone', 'UTC') == 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                                        <option value="America/Denver" {{ $user->getProfileField('settings.timezone', 'UTC') == 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                                        <option value="America/Los_Angeles" {{ $user->getProfileField('settings.timezone', 'UTC') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                                        <option value="Africa/Lagos" {{ $user->getProfileField('settings.timezone', 'UTC') == 'Africa/Lagos' ? 'selected' : '' }}>West Africa Time</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dark Mode -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="dark_mode" 
                                                           name="dark_mode"
                                                           {{ $user->getProfileField('settings.dark_mode', false) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="dark_mode">Dark Mode</label>
                                                </div>
                                                <div class="form-note">
                                                    <span class="sub-text">Enable dark theme for better viewing in low light</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary">
                                                    <em class="icon ni ni-save me-2"></em>Save Preferences
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Handle photo preview
    $('#photo').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select a valid image file');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result).show();
                $('#preview-text').hide();
            };
            reader.readAsDataURL(file);
        }
    });

    // Password visibility toggle
    $('.passcode-switch').on('click', function(e) {
        e.preventDefault();
        const target = $(this).data('target');
        const input = $('#' + target);
        const showIcon = $(this).find('.icon-show');
        const hideIcon = $(this).find('.icon-hide');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            showIcon.hide();
            hideIcon.show();
        } else {
            input.attr('type', 'password');
            showIcon.show();
            hideIcon.hide();
        }
    });

    // Form validation feedback
    $('form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
        
        // Re-enable button after 10 seconds as fallback
        setTimeout(() => {
            submitBtn.prop('disabled', false).html(originalText);
        }, 10000);
    });

    // Password strength indicator
    $('#new_password').on('input', function() {
        const password = $(this).val();
        const strength = calculatePasswordStrength(password);
        updatePasswordStrengthIndicator(strength);
    });

    // Password confirmation validation
    $('#new_password_confirmation').on('input', function() {
        const password = $('#new_password').val();
        const confirmation = $(this).val();
        
        if (confirmation && password !== confirmation) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Passwords do not match</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Auto-save preferences on change (optional)
    $('#settings input[type="checkbox"], #settings select').on('change', function() {
        // Show unsaved changes indicator
        if (!$('#unsaved-changes').length) {
            $('#settings').prepend('<div id="unsaved-changes" class="alert alert-warning alert-sm">You have unsaved changes</div>');
        }
    });

    // Remove unsaved changes indicator on form submit
    $('#settings form').on('submit', function() {
        $('#unsaved-changes').remove();
    });
});

function calculatePasswordStrength(password) {
    let strength = 0;
    
    // Length check
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    
    // Character variety checks
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return Math.min(strength, 5);
}

function updatePasswordStrengthIndicator(strength) {
    const colors = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997'];
    const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    
    let indicator = $('#password-strength');
    if (!indicator.length) {
        $('#new_password').after('<div id="password-strength" class="form-note mt-1"></div>');
        indicator = $('#password-strength');
    }
    
    if (strength > 0) {
        indicator.html(`
            <div class="progress" style="height: 4px;">
                <div class="progress-bar" style="width: ${(strength/5)*100}%; background-color: ${colors[strength-1]}"></div>
            </div>
            <small style="color: ${colors[strength-1]}">${labels[strength-1]}</small>
        `);
    } else {
        indicator.empty();
    }
}
</script>

@push('css')
<style>
.user-avatar-upload {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar-upload .user-avatar {
    width: 120px;
    height: 120px;
    font-size: 2.5rem;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
    border-radius: 50%;
    border: 4px solid #e3e7fe;
}

.user-avatar-upload .user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-avatar-upload-btn {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.nav-tabs {
    border-bottom: 2px solid #e3e7fe;
}

.nav-tabs .nav-link {
    border: none;
    color: #526484;
    font-weight: 500;
    padding: 1rem 1.5rem;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    color: #4e73df;
    border-bottom-color: #4e73df;
    background: none;
}

.nav-tabs .nav-link:hover {
    color: #4e73df;
    border-color: transparent;
}

.custom-control-label {
    font-weight: 500;
    color: #364a63;
    padding-left: 0.5rem;
}

.custom-switch .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #4e73df;
    border-color: #4e73df;
}

.form-icon.form-icon-right {
    right: 12px;
    cursor: pointer;
    color: #8094ae;
    transition: color 0.2s ease;
}

.form-icon.form-icon-right:hover {
    color: #526484;
}

.passcode-icon.icon-hide {
    display: none;
}

.overline-title {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #8094ae;
    margin-bottom: 1rem;
}

.card-bordered {
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border-radius: 12px;
}

.form-control:focus,
.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #224abe 0%, #1e3a8a 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
}

.alert-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

.progress {
    background-color: #e9ecef;
    border-radius: 4px;
}

.form-note {
    margin-top: 0.5rem;
}

.form-note .sub-text {
    color: #8094ae;
    font-size: 0.875rem;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #dc3545;
    margin-top: 0.25rem;
}

.tab-content {
    min-height: 400px;
}

.tab-pane {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .user-avatar-upload {
        flex-direction: column;
        text-align: center;
    }
    
    .user-avatar-upload .user-avatar {
        width: 100px;
        height: 100px;
        font-size: 2rem;
    }
    
    .nav-tabs .nav-link {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .nav-tabs .nav-link .icon {
        display: none;
    }
}

@media (max-width: 576px) {
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    
    .nav-tabs .nav-link {
        white-space: nowrap;
        flex: 0 0 auto;
    }
}
</style>
@endpush

@endsection