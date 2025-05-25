{{-- Blade name: backend.users.index --}}

@extends('admin.admin_master')
@section('title', 'Users Management')
@section('admin')

<div class="content container-fluid pb-0">
    <!-- Page Header -->
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Users Lists</h3>
                        <div class="nk-block-des text-soft">
                            <p>You have total {{ $users->total() }} users.</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li><a href="#" data-bs-toggle="modal"  data-bs-target="#addUserModal" class="btn btn-white btn-outline-light">
                                            <em class="icon ni ni-user-c"></em>
                                            <span>Add User</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="card card-stretch">
                    <div class="card-inner-group">
                        <div class="card-inner position-relative card-tools-toggle">
                            <div class="card-title-group">
                                <div class="card-tools">
                                    <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline flex-nowrap gx-3">
                                        <div class="form-wrap w-150px">
                                            <select name="status" class="form-select" onchange="this.form.submit()">
                                                <option value="">All Status</option>
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-wrap w-150px">
                                            <select name="verified" class="form-select" onchange="this.form.submit()">
                                                <option value="">All Verification</option>
                                                <option value="verified" {{ request('verified') == 'verified' ? 'selected' : '' }}>Verified</option>
                                                <option value="unverified" {{ request('verified') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-tools me-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li><a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('admin.users.index') }}">
                                        <div class="search-content">
                                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-transparent form-focus-none" placeholder="Search by name, email, username or phone">
                                            <button type="submit" class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner p-0">
                            <div class="nk-tb-list nk-tb-ulist is-compact">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"><span class="sub-text">User</span></div>
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">Email</span></div>
                                    <div class="nk-tb-col tb-col-sm"><span class="sub-text">Phone</span></div>
                                    <div class="nk-tb-col tb-col-lg"><span class="sub-text">Verified</span></div>
                                    <div class="nk-tb-col tb-col-xxl"><span class="sub-text">Last Login</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                    <div class="nk-tb-col nk-tb-col-tools text-end"></div>
                                </div>
                                
                                @forelse($users as $user)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid{{ $user->id }}">
                                            <label class="custom-control-label" for="uid{{ $user->id }}"></label>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-primary">
                                                @if($user->photo)
                                                    <img src="{{ asset($user->photo) }}" alt="{{ $user->name }}">
                                                @else
                                                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                @endif
                                            </div>
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $user->name }}</span>
                                                @if($user->username)
                                                    <div class="text-muted">@ {{ $user->username }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col tb-col-md"><span>{{ $user->email }}</span></div>
                                    <div class="nk-tb-col tb-col-sm"><span>{{ $user->phone ?? 'N/A' }}</span></div>
                                    <div class="nk-tb-col tb-col-lg">
                                        <ul class="list-status">
                                            @if($user->email_verified_at)
                                                <li><em class="icon text-success ni ni-check-circle"></em> <span>Email</span></li>
                                            @else
                                                <li><em class="icon text-warning ni ni-alarm-alt"></em> <span>Pending</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="nk-tb-col tb-col-xxl">
                                        <span>{{ $user->last_login_at ? $user->last_login_at->format('d M Y') : 'Never' }}</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <span class="tb-status text-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-2">
                                            <li class="nk-tb-action-hidden">
                                                <a href="{{ route('admin.users.view', $user->id) }}" class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                                    <em class="icon ni ni-eye"></em>
                                                </a>
                                            </li>
                                            <li class="nk-tb-action-hidden">
                                                <a href="{{ route('admin.users.toggle-status', $user->id) }}" class="btn btn-sm btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Toggle Status">
                                                    <em class="icon ni ni-{{ $user->status === 'active' ? 'user-cross' : 'user-check' }}-fill"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="{{ route('admin.users.view', $user->id) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                            <li><a href="#" onclick="editUser({{ $user->id }})"><em class="icon ni ni-edit"></em><span>Edit User</span></a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="{{ route('admin.users.toggle-status', $user->id) }}"><em class="icon ni ni-shield-star"></em><span>Toggle Status</span></a></li>
                                                            <li><a href="{{ route('admin.users.delete', $user->id) }}" onclick="return confirm('Are you sure you want to delete this user?')"><em class="icon ni ni-na"></em><span>Delete User</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @empty
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col text-center" style="width: 100%;">
                                        <div class="empty-state py-5">
                                            <div class="empty-state-icon">
                                                <div class="d-inline-block position-relative">
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; margin: 0 auto;">
                                                        <em class="icon ni ni-users" style="font-size: 3.5rem; color: #c4c4c4;"></em>
                                                    </div>
                                                    <div class="position-absolute" style="top: -5px; right: 10px;">
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <em class="icon ni ni-search" style="font-size: 0.875rem; color: white;"></em>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="empty-state-content mt-4">
                                                <h4 class="fw-bold text-dark mb-2">No Users Found</h4>
                                                <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">
                                                    @if(request()->has('search') || request()->has('status') || request()->has('verified'))
                                                        We couldn't find any users matching your current search criteria. Try adjusting your filters or search terms.
                                                    @else
                                                        You haven't added any users yet. Start by creating your first user account.
                                                    @endif
                                                </p>
                                                <div class="empty-state-actions">
                                                    @if(request()->has('search') || request()->has('status') || request()->has('verified'))
                                                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary me-2">
                                                            <em class="icon ni ni-reload"></em>
                                                            <span>Clear Filters</span>
                                                        </a>
                                                    @endif
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add New User</span>
                                                    </a>
                                                </div>
                                                @if(request()->has('search') || request()->has('status') || request()->has('verified'))
                                                <div class="mt-3">
                                                    <small class="text-muted">
                                                        <strong>Current filters:</strong>
                                                        @if(request('search'))
                                                            Search: "{{ request('search') }}"
                                                        @endif
                                                        @if(request('status'))
                                                            @if(request('search')) • @endif
                                                            Status: {{ ucfirst(request('status')) }}
                                                        @endif
                                                        @if(request('verified'))
                                                            @if(request('search') || request('status')) • @endif
                                                            Verification: {{ ucfirst(request('verified')) }}
                                                        @endif
                                                    </small>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-inner">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="edit_username" name="username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_password" class="form-label">Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" id="edit_password" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="edit_address" class="form-label">Address</label>
                                <textarea class="form-control" id="edit_address" name="address" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="edit_photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control" id="edit_photo" name="photo" accept="image/*">
                                <div id="current_photo_preview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editUser(userId) {
    console.log('Fetching user data for ID:', userId);
    
    fetch(`/users/edit/${userId}`)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(user => {
            console.log('User data received:', user);
            
            // Check if user data is valid
            if (!user || typeof user !== 'object') {
                throw new Error('Invalid user data received');
            }
            
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_username').value = user.username || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_phone').value = user.phone || '';
            document.getElementById('edit_address').value = user.address || '';
            document.getElementById('edit_status').value = user.status || 'active';
            
            // Set form action
            document.getElementById('editUserForm').action = `/users/update/${userId}`;
            
            // Show current photo if exists
            const photoPreview = document.getElementById('current_photo_preview');
            if (user.photo) {
                photoPreview.innerHTML = `<img src="/${user.photo}" alt="Current photo" style="max-width: 100px; max-height: 100px;" class="img-thumbnail">`;
            } else {
                photoPreview.innerHTML = '';
            }
            
            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        })
        .catch(error => {
            console.error('Detailed error:', error);
            console.error('Error message:', error.message);
            alert(`Error loading user data: ${error.message}`);
        });
}

// Test function to check routes
function testRoute() {
    console.log('Testing route...');
    fetch('/admin/users')
        .then(response => {
            console.log('Index route status:', response.status);
            return response.text();
        })
        .then(data => {
            console.log('Index route working');
        })
        .catch(error => {
            console.error('Index route error:', error);
        });
}

// Uncomment the line below to test routes when page loads
// testRoute();
</script>

@endsection

@push('css')
<style>
.empty-state {
    padding: 3rem 1rem;
}

.empty-state-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.empty-state-icon .bg-light {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.empty-state-icon:hover .bg-light {
    transform: scale(1.05);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.empty-state-actions .btn {
    transition: all 0.3s ease;
}

.empty-state-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.search-wrap {
    border-radius: 8px;
    overflow: hidden;
}

.nk-tb-list .nk-tb-item:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}

.user-avatar img {
    border-radius: 50%;
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}
</style>
@endpush