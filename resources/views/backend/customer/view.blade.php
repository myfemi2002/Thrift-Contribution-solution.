@extends('admin.admin_master')
@section('title', 'Customer Details')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Customer Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Customer Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-between g-3">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">{{ $user->name }}</h3>
                        <div class="nk-block-des text-soft">
                            <ul class="list-inline">
                                <li>User ID: <span class="text-base">{{ $user->id }}</span></li>
                                <li>Last Login: <span class="text-base">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                            <em class="icon ni ni-arrow-left"></em><span>Back</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="card">
                    <div class="card-aside-wrap">
                        <div class="card-content">
                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1"><em class="icon ni ni-user-circle"></em><span>Personal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem2"><em class="icon ni ni-lock-alt"></em><span>Security</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tabItem3"><em class="icon ni ni-activity"></em><span>Activities</span></a>
                                </li>
                            </ul>
                            <div class="card-inner">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabItem1">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Personal Information</h5>
                                                <p>Basic info, like your name and address, that you use on our platform.</p>
                                            </div>
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Full Name</span>
                                                        <span class="profile-ud-value">{{ $user->name }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Username</span>
                                                        <span class="profile-ud-value">{{ $user->username ?? 'Not set' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Email Address</span>
                                                        <span class="profile-ud-value">{{ $user->email }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Phone Number</span>
                                                        <span class="profile-ud-value">{{ $user->phone ?? 'Not provided' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Address</span>
                                                        <span class="profile-ud-value">{{ $user->address ?? 'Not provided' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Status</span>
                                                        <span class="profile-ud-value">
                                                            <span class="badge badge-dim bg-outline-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                                                {{ ucfirst($user->status) }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Email Verification</span>
                                                        <span class="profile-ud-value">
                                                            @if($user->email_verified_at)
                                                                <span class="badge badge-dim bg-outline-success">Verified</span>
                                                            @else
                                                                <span class="badge badge-dim bg-outline-warning">Unverified</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Registration Date</span>
                                                        <span class="profile-ud-value">{{ $user->created_at->format('M d, Y h:i A') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem2">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Security Information</h5>
                                                <p>Settings and recommendations to help you keep your account secure.</p>
                                            </div>
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Last Password Change</span>
                                                        <span class="profile-ud-value">{{ $user->last_password_change ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Two Factor Auth</span>
                                                        <span class="profile-ud-value">
                                                            @if($user->two_factor_enabled)
                                                                <span class="badge badge-dim bg-outline-success">Enabled</span>
                                                            @else
                                                                <span class="badge badge-dim bg-outline-danger">Disabled</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Failed Login Attempts</span>
                                                        <span class="profile-ud-value">{{ $user->failed_login_attempts }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Last Failed Login</span>
                                                        <span class="profile-ud-value">{{ $user->last_failed_login_at ? $user->last_failed_login_at->format('M d, Y h:i A') : 'None' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Registration IP</span>
                                                        <span class="profile-ud-value">{{ $user->registration_ip ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabItem3">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Login Activities</h5>
                                                <p>Latest login information and device details.</p>
                                            </div>
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Last Login IP</span>
                                                        <span class="profile-ud-value">{{ $user->last_login_ip ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Last Login Time</span>
                                                        <span class="profile-ud-value">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Browser</span>
                                                        <span class="profile-ud-value">{{ $user->last_login_browser ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Device</span>
                                                        <span class="profile-ud-value">{{ $user->last_login_device ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Operating System</span>
                                                        <span class="profile-ud-value">{{ $user->last_login_os ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Location</span>
                                                        <span class="profile-ud-value">{{ $user->last_login_location ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Currently Logged In</span>
                                                        <span class="profile-ud-value">
                                                            @if($user->is_logged_in)
                                                                <span class="badge badge-dim bg-outline-success">Yes</span>
                                                            @else
                                                                <span class="badge badge-dim bg-outline-secondary">No</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">User Agent</span>
                                                        <span class="profile-ud-value text-break">{{ $user->user_agent ?? 'Not available' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="card-inner-group" data-simplebar>
                                <div class="card-inner">
                                    <div class="user-card">
                                        <div class="user-avatar bg-primary">
                                            @if($user->photo)
                                                <img src="{{ asset($user->photo) }}" alt="{{ $user->name }}">
                                            @else
                                                <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text">{{ $user->name }}</span>
                                            <span class="sub-text">{{ $user->email }}</span>
                                        </div>
                                        <div class="user-action">
                                            <div class="dropdown">
                                                <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#" onclick="editUser({{ $user->id }})"><em class="icon ni ni-edit-fill"></em><span>Edit User</span></a></li>
                                                        <li><a href="{{ route('admin.users.toggle-status', $user->id) }}"><em class="icon ni ni-shield-star"></em><span>Toggle Status</span></a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="{{ route('admin.users.delete', $user->id) }}" onclick="return confirm('Are you sure you want to delete this user?')"><em class="icon ni ni-na"></em><span>Delete User</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
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
                                                <span class="amount">{{ $user->email_verified_at ? 'Yes' : 'No' }}</span>
                                                <span class="sub-text">Verified</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="profile-stats">
                                                <span class="amount">{{ $user->is_logged_in ? 'Online' : 'Offline' }}</span>
                                                <span class="sub-text">Login Status</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner">
                                    <h6 class="overline-title mb-2">Additional Info</h6>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <span class="sub-text">User ID:</span>
                                            <span>#{{ $user->id }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="sub-text">Joined:</span>
                                            <span>{{ $user->created_at->format('M Y') }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="sub-text">Last Seen:</span>
                                            <span>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="sub-text">Language:</span>
                                            <span>English</span>
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

@endsection