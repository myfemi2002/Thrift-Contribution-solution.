
               <div class="nk-sidebar-element">
                  <div class="nk-sidebar-body" data-simplebar="">
                     <div class="nk-sidebar-content">

                       



                        <div class="nk-sidebar-menu">
                           <ul class="nk-menu">
                              <li class="nk-menu-heading">
                                 <h6 class="overline-title">Menu</h6>
                              </li>
                              <li class="nk-menu-item">
                                    <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                                        <span class="nk-menu-text">Dashboard</span>
                                    </a>
                                </li>
                              
                              <li class="nk-menu-item">
                                    <a href="{{ route('admin.users.index') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>
                                        <span class="nk-menu-text">All Customers</span>
                                    </a>
                                </li>

                                
                            <!-- Contribution Management Menu -->
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-wallet-alt"></em></span>
                                    <span class="nk-menu-text">Contributions</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.contributions.index') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.contributions.create') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Record Contribution</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.contributions.calendar') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Calendar View</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.contributions.logs') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Transaction Logs</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            

                            <!-- Wallet Adjustments Menu -->
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
                                    <span class="nk-menu-text">Wallet Adjustments</span>
                                    @php
                                        $pendingCount = \App\Models\WalletAdjustment::where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="nk-menu-badge badge badge-danger">{{ $pendingCount }}</span>
                                    @endif
                                </a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.wallet-adjustments.index') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">All Adjustments</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.wallet-adjustments.create') }}" class="nk-menu-link">
                                            <span class="nk-menu-text">Credit/Debit Wallet</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.wallet-adjustments.index') }}?status=pending" class="nk-menu-link">
                                            <span class="nk-menu-text">Pending Approvals</span>
                                            @if($pendingCount > 0)
                                                <span class="badge badge-sm badge-danger ms-1">{{ $pendingCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ route('admin.wallet-adjustments.index') }}?reason=omitted_contribution" class="nk-menu-link">
                                            <span class="nk-menu-text">Omitted Contributions</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            
                           <li class="nk-menu-item has-sub">
                              <a href="#" class="nk-menu-link nk-menu-toggle">
                                 <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                                 <span class="nk-menu-text">Withdrawals</span>
                                 @php $pendingWithdrawals = \App\Models\Withdrawal::pending()->count(); @endphp
                                 @if($pendingWithdrawals > 0)
                                       <span class="nk-menu-badge">{{ $pendingWithdrawals }}</span>
                                 @endif
                              </a>
                              <ul class="nk-menu-sub">
                                 <li class="nk-menu-item">
                                       <a href="{{ route('admin.withdrawals.index') }}" class="nk-menu-link">
                                          <span class="nk-menu-text">All Withdrawals</span>
                                       </a>
                                 </li>
                                 <li class="nk-menu-item">
                                       <a href="{{ route('admin.withdrawals.index') }}?status=pending" class="nk-menu-link">
                                          <span class="nk-menu-text">Pending Approval</span>
                                          @if($pendingWithdrawals > 0)
                                             <span class="nk-menu-badge badge-warning">{{ $pendingWithdrawals }}</span>
                                          @endif
                                       </a>
                                 </li>
                                 <li class="nk-menu-item">
                                       <a href="{{ route('admin.withdrawals.index') }}?status=approved" class="nk-menu-link">
                                          <span class="nk-menu-text">Approved</span>
                                       </a>
                                 </li>
                                 <li class="nk-menu-item">
                                       <a href="{{ route('admin.withdrawals.index') }}?status=completed" class="nk-menu-link">
                                          <span class="nk-menu-text">Completed</span>
                                       </a>
                                 </li>
                              </ul>
                           </li>

                           <!-- Loan Management Section for Admin -->
                           <li class="nk-menu-item has-sub">
                              <a href="#" class="nk-menu-link nk-menu-toggle">
                                 <span class="nk-menu-icon"><em class="icon ni ni-wallet-alt"></em></span>
                                 <span class="nk-menu-text">Loan Management</span>
                                 @php
                                    $pendingLoansCount = \App\Models\Loan::where('status', 'pending')->count();
                                 @endphp
                                 @if($pendingLoansCount > 0)
                                    <span class="nk-menu-badge">{{ $pendingLoansCount }}</span>
                                 @endif
                              </a>
                              <ul class="nk-menu-sub">
                                 <li class="nk-menu-item">
                                    <a href="{{ route('admin.loans.index') }}" class="nk-menu-link">
                                       <span class="nk-menu-text">All Loans</span>
                                    </a>
                                 </li>
                                 <li class="nk-menu-item">
                                    <a href="{{ route('admin.loans.index') }}?status=pending" class="nk-menu-link">
                                       <span class="nk-menu-text">Pending Approval</span>
                                       @if($pendingLoansCount > 0)
                                          <span class="badge badge-sm bg-warning ms-1">{{ $pendingLoansCount }}</span>
                                       @endif
                                    </a>
                                 </li>
                                 <li class="nk-menu-item">
                                    <a href="{{ route('admin.loans.index') }}?status=active" class="nk-menu-link">
                                       <span class="nk-menu-text">Active Loans</span>
                                    </a>
                                 </li>
                                 <li class="nk-menu-item">
                                    <a href="{{ route('admin.loans.index') }}?status=overdue" class="nk-menu-link">
                                       <span class="nk-menu-text">Overdue Loans</span>
                                    </a>
                                 </li>
                                 <li class="nk-menu-item">
                                    <a href="{{ route('admin.loans.index') }}?status=completed" class="nk-menu-link">
                                       <span class="nk-menu-text">Completed Loans</span>
                                    </a>
                                 </li>
                              </ul>
                           </li>

                              
                              <li class="nk-menu-item">
                                    <a href="#" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user-c"></em></span>
                                        <span class="nk-menu-text">My Account</span>
                                    </a>
                                </li>

                              <li class="nk-menu-item">
                                    <a href="#" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-wallet-alt"></em></span>
                                        <span class="nk-menu-text">Wallets</span>
                                    </a>
                                </li>

                           </ul>
                        </div>
                        
                        <!-- <div class="nk-sidebar-footer">
                           <ul class="nk-menu nk-menu-footer">
                              <li class="nk-menu-item"><a href="#" class="nk-menu-link"><span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span><span class="nk-menu-text">Support</span></a></li>
                              <li class="nk-menu-item ms-auto">
                                 <div class="dropup">
                                    <a href="" class="nk-menu-link dropdown-indicator has-indicator" data-bs-toggle="dropdown" data-offset="0,10"><span class="nk-menu-icon"><em class="icon ni ni-globe"></em></span><span class="nk-menu-text">English</span></a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                       <ul class="language-list">
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/english.png" alt="" class="language-flag"><span class="language-name">English</span></a></li>
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/spanish.png" alt="" class="language-flag"><span class="language-name">Español</span></a></li>
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/french.png" alt="" class="language-flag"><span class="language-name">Français</span></a></li>
                                          <li><a href="#" class="language-item"><img src="{{ $assetBase }}/images/flags/turkey.png" alt="" class="language-flag"><span class="language-name">Türkçe</span></a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                        </div> -->
                     </div>
                  </div>
               </div>