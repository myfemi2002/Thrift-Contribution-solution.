@extends('userend.user_home')
@section('title', 'My Profile')
@section('user_content')

<div class="container-xl wide-xxl">
    <div class="nk-content-body">
        <!-- Page Header -->
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">My Profile</h3>
                    <div class="nk-block-des text-soft">
                        <p>Manage your account information and preferences</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary d-none d-sm-inline-flex">
                        <em class="icon ni ni-edit"></em>
                        <span>Edit Profile</span>
                    </a>
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-icon btn-primary d-inline-flex d-sm-none">
                        <em class="icon ni ni-edit"></em>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-gs">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="user-card user-card-s2">
                                <div class="user-avatar lg bg-primary">
                                    @if($user->photo)
                                        <img src="{{ asset($user->photo) }}" alt="Profile Photo">
                                    @else
                                        <span>{{ substr($user->name, 0, 2) }}</span>
                                    @endif
                                </div>
                                <div class="user-info">
                                    <div class="badge badge-outline-light badge-pill ucap">{{ ucfirst($user->role) }}</div>
                                    <h5>{{ $user->name }}</h5>
                                    <span class="sub-text">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="profile-stats">
                                        <span class="amount">{{ $user->status === 'active' ? 'Active' : 'Inactive' }}</span>
                                        <span class="sub-text">Status</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="profile-stats">
                                        <span class="amount">{{ $user->created_at->format('M Y') }}</span>
                                        <span class="sub-text">Joined</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="profile-stats">
                                        <span class="amount">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                                        <span class="sub-text">Last Login</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($user->credit_rating)
                            <div class="card-inner">
                                <div class="profile-stats border rounded-2 p-3 text-center">
                                    <h6 class="overline-title">Credit Rating</h6>
                                    <div class="mt-2">
                                        {!! $user->credit_rating_badge !!}
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-primary fw-bold">{{ $user->loan_interest_rate }}%</span>
                                        <span class="sub-text">Interest Rate</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="col-lg-8">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Personal Information</h6>
                            </div>
                            <div class="card-tools">
                                <a href="{{ route('user.profile.edit') }}" class="btn btn-icon btn-sm btn-outline-primary">
                                    <em class="icon ni ni-edit"></em>
                                </a>
                            </div>
                        </div>
                        
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" value="{{ $user->username ?? 'Not set' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" value="{{ $user->phone ?? 'Not provided' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" readonly>{{ $user->address ?? 'Not provided' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="card card-bordered mt-4">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Account Security</h6>
                            </div>
                        </div>
                        
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" value="••••••••••" readonly>
                                    </div>
                                    <div class="form-note">
                                        <span class="sub-text">Last changed: {{ $user->last_password_change ?? 'Never' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Two Factor Auth</label>
                                    <div class="form-control-wrap">
                                        <span class="badge {{ $user->two_factor_enabled ? 'bg-success' : 'bg-warning' }}">
                                            {{ $user->two_factor_enabled ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('user.profile.edit') }}#security" class="btn btn-outline-primary">
                                <em class="icon ni ni-shield-check me-2"></em>Change Password
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Loan Statistics (if available) -->
                @if(!empty($loanStats))
                    <div class="card card-bordered mt-4">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">💳 Loan Statistics</h6>
                                </div>
                                <div class="card-tools">
                                    <a href="{{ route('user.loans.index') }}" class="btn btn-icon btn-sm btn-outline-primary">
                                        <em class="icon ni ni-external"></em>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="profile-stats text-center border rounded p-3">
                                        <span class="amount text-primary">{{ $loanStats['total_loans'] ?? 0 }}</span>
                                        <span class="sub-text">Total Loans</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="profile-stats text-center border rounded p-3">
                                        <span class="amount text-success">{{ $loanStats['completed_loans'] ?? 0 }}</span>
                                        <span class="sub-text">Completed</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="profile-stats text-center border rounded p-3">
                                        <span class="amount text-warning">{{ $loanStats['active_loans'] ?? 0 }}</span>
                                        <span class="sub-text">Active</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="profile-stats text-center border rounded p-3">
                                        <span class="amount text-info">₦{{ number_format($loanStats['total_borrowed'] ?? 0, 2) }}</span>
                                        <span class="sub-text">Total Borrowed</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="profile-stats text-center border rounded p-3">
                                        <span class="amount text-success">₦{{ number_format($loanStats['total_repaid'] ?? 0, 2) }}</span>
                                        <span class="sub-text">Total Repaid</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Activity -->
                <div class="card card-bordered mt-4">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Recent Activity</h6>
                            </div>
                        </div>
                        
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-status bg-primary"></div>
                                <div class="timeline-date">{{ now()->format('M d') }}</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Profile Viewed</h6>
                                    <div class="timeline-des">
                                        <p>You viewed your profile information</p>
                                        <span class="time">{{ now()->format('g:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            @if($user->last_login_at)
                                <div class="timeline-item">
                                    <div class="timeline-status bg-success"></div>
                                    <div class="timeline-date">{{ $user->last_login_at->format('M d') }}</div>
                                    <div class="timeline-data">
                                        <h6 class="timeline-title">Login Activity</h6>
                                        <div class="timeline-des">
                                            <p>Logged in from {{ $user->last_login_location ?? 'Unknown location' }}</p>
                                            <span class="time">{{ $user->last_login_at->format('g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="timeline-item">
                                <div class="timeline-status bg-info"></div>
                                <div class="timeline-date">{{ $user->created_at->format('M d') }}</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Account Created</h6>
                                    <div class="timeline-des">
                                        <p>Welcome to our platform!</p>
                                        <span class="time">{{ $user->created_at->format('g:i A') }}</span>
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

@push('css')
<style>
.user-card-s2 {
    text-align: center;
    padding: 2rem 1rem;
}

.user-avatar.lg {
    width: 120px;
    height: 120px;
    font-size: 2.5rem;
    margin: 0 auto 1rem;
}

.profile-stats .amount {
    display: block;
    font-size: 1.125rem;
    font-weight: 600;
    color: #364a63;
    margin-bottom: 0.25rem;
}

.profile-stats .sub-text {
    font-size: 0.75rem;
    color: #8094ae;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 1.5rem;
    bottom: -1.5rem;
    width: 2px;
    background: #e3e7fe;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-status {
    position: absolute;
    left: -2.5rem;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e3e7fe;
}

.timeline-date {
    font-size: 0.75rem;
    color: #8094ae;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.timeline-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #364a63;
}

.timeline-des p {
    font-size: 0.875rem;
    color: #526484;
    margin-bottom: 0.25rem;
}

.timeline-des .time {
    font-size: 0.75rem;
    color: #8094ae;
}

.card-bordered {
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
}

@media (max-width: 768px) {
    .user-avatar.lg {
        width: 80px;
        height: 80px;
        font-size: 1.75rem;
    }
    
    .profile-stats .amount {
        font-size: 1rem;
    }
}
</style>
@endpush

@endsection