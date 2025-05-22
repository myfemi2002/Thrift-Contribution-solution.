<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                <!-- Main -->
                <li class="menu-title"><span>Main</span></li>
                <li>
                    <a href="#"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                </li>


                <!-- USDT Wallet -->
               

                <li>
                    
                    <a href="{{ route('admin.wallets.mother.index') }}">
                        <i class="fe fe-credit-card"></i> <span>Mother Wallets</span>
                    </a>
                </li>

                <!-- USDT Wallet -->
                <li class="submenu">
                    <a href="#"><i class="fe fe-sidebar"></i> <span>Deposit </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('admin.deposits.index') }}">Deposits</a></li>
                        <li>
                            <a href="{{ route('admin.deposits.appeals') }}">
                                Deposit Appeals
                                @if($pendingAppealsCount > 0)
                                    <span class="badge bg-warning text-dark rounded-pill ms-2">{{ $pendingAppealsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('admin.deposits.transaction-logs') }}">Transaction Logs</a></li>
                    </ul>
                </li>

                <!-- Users -->
                <li class="submenu">
                    <a href="#"><i class="fe fe-users"></i> <span>Users</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="#">All Users</a></li>
                        <li><a href="#">Add User</a></li>
                    </ul>
                </li>



                <!-- Content Management -->
                <!-- <li class="menu-title"><span>Website Content</span></li>
                <li><a href="#"><i class="fe fe-sliders"></i> <span>Slider</span></a></li>
                <li><a href="#"><i class="fe fe-info"></i> <span>About Us</span></a></li>
                <li><a href="#"><i class="fe fe-briefcase"></i> <span>Services</span></a></li>
                <li><a href="#"><i class="fe fe-message-circle"></i> <span>Testimonials</span></a></li>
                <li><a href="#"><i class="fe fe-layers"></i> <span>Property Types</span></a></li>
                <li><a href="#"><i class="fe fe-home"></i> <span>Properties</span></a></li>
                <li><a href="#"><i class="fe fe-clipboard"></i> <span>Projects</span></a></li>
                <li><a href="#"><i class="fe fe-pie-chart"></i> <span>Counter Section</span></a></li>
                <li><a href="#"><i class="fe fe-file"></i> <span>Blog All Posts</span></a></li>
                <li><a href="#"><i class="fe fe-book"></i> <span>Blog Categories</span></a></li>
                <li><a href="#"><i class="fe fe-edit"></i> <span>FAQ Management</span></a></li>
                <li><a href="#"><i class="fe fe-shield"></i> <span>Privacy Policy</span></a></li>
                <li><a href="#"><i class="fe fe-briefcase"></i> <span>Partnership Applications</span></a></li>
                <li><a href="#"><i class="fe fe-mail"></i> <span>Contact Messages</span></a></li>
                <li><a href="#"><i class="fe fe-message-square"></i> <span>WhatsApp Settings</span></a></li> -->

                <!-- Settings -->
                <li class="menu-title"><span>Account</span></li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-power"></i> <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>