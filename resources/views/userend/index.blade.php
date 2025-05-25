@extends('userend.user_home')
@section('title', 'Dashboard')
@section('user_content')



                  <div class="container-xl wide-lg">
                     <div class="nk-content-body">
                        <div class="nk-block-head">
                           <div class="nk-block-head-sub"><span>Welcome!</span></div>
                           <div class="nk-block-between-md g-4">
                              <div class="nk-block-head-content">
                                 <h2 class="nk-block-title fw-normal">Abu Bin Ishityak</h2>
                                 <div class="nk-block-des">
                                    <p>At a glance summary of your account. Have fun!</p>
                                 </div>
                              </div>
                              <div class="nk-block-head-content">
                                 <ul class="nk-block-tools gx-3">
                                    <li><a href="profile.html" class="btn btn-primary"><span>Profile</span> <em class="icon ni ni-arrow-long-right"></em></a></li>
                                    <li><a href="security-settings.html" class="btn btn-white btn-light btn-icon"><em class="icon ni ni-setting"></em></a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="nk-block">
                           <div class="row gy-gs">
                              <div class="col-12 col-xxl-8">
                                 <div class="card card-bordered h-100">
                                    <div class="card-inner border-bottom">
                                       <div class="card-title-group">
                                          <div class="card-title">
                                             <h6 class="title">Transaction History</h6>
                                          </div>
                                          <div class="card-tools"><a href="#" class="link">See Details</a></div>
                                       </div>
                                    </div>
                                    <div class="card-inner p-0">
                                       <table class="table table-tranx">
                                          <thead>
                                             <tr class="tb-tnx-head">
                                                <th class="tb-tnx-id"><span class="">#</span></th>
                                                <th class="tb-tnx-info"><span class="tb-tnx-desc d-none d-sm-inline-block"><span>Loan Type</span></span><span class="tb-tnx-date d-md-inline-block d-none"><span class="d-md-none">Date</span><span class="d-none d-md-block"><span>Date</span></span></span></th>
                                                <th class="tb-tnx-amount is-alt"><span class="tb-tnx-total">Amount</span><span class="tb-tnx-status d-none d-md-inline-block">Status</span></th>
                                                <th class="tb-tnx-action"><span>&nbsp;</span></th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <tr class="tb-tnx-item">
                                                <td class="tb-tnx-id"><a href="#"><span>4947</span></a></td>
                                                <td class="tb-tnx-info">
                                                   <div class="tb-tnx-desc"><span class="title">Credit Card Payment</span></div>
                                                   <div class="tb-tnx-date"><span class="date">10-05-2021</span></div>
                                                </td>
                                                <td class="tb-tnx-amount is-alt">
                                                   <div class="tb-tnx-total"><span>$2599.00</span></div>
                                                   <div class="tb-tnx-status"><span class="badge badge-dot text-warning">Pending</span></div>
                                                </td>
                                                <td class="tb-tnx-action">
                                                   <div class="dropdown">
                                                      <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                         <ul class="link-list-plain">
                                                            <li><a href="#">View</a></li>
                                                            <li><a href="#">Remove</a></li>
                                                         </ul>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr class="tb-tnx-item">
                                                <td class="tb-tnx-id"><a href="#"><span>5763</span></a></td>
                                                <td class="tb-tnx-info">
                                                   <div class="tb-tnx-desc"><span class="title">Cash Payment</span></div>
                                                   <div class="tb-tnx-date"><span class="date">18-06-2021</span></div>
                                                </td>
                                                <td class="tb-tnx-amount is-alt">
                                                   <div class="tb-tnx-total"><span>$1200.70</span></div>
                                                   <div class="tb-tnx-status"><span class="badge badge-dot text-success">Completed</span></div>
                                                </td>
                                                <td class="tb-tnx-action">
                                                   <div class="dropdown">
                                                      <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                         <ul class="link-list-plain">
                                                            <li><a href="#">View</a></li>
                                                            <li><a href="#">Remove</a></li>
                                                         </ul>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr class="tb-tnx-item">
                                                <td class="tb-tnx-id"><a href="#"><span>4893</span></a></td>
                                                <td class="tb-tnx-info">
                                                   <div class="tb-tnx-desc"><span class="title">Insurance Payment Check</span></div>
                                                   <div class="tb-tnx-date"><span class="date">07-04-2021</span></div>
                                                </td>
                                                <td class="tb-tnx-amount is-alt">
                                                   <div class="tb-tnx-total"><span>$1500.50</span></div>
                                                   <div class="tb-tnx-status"><span class="badge badge-dot text-success">Completed</span></div>
                                                </td>
                                                <td class="tb-tnx-action">
                                                   <div class="dropdown">
                                                      <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                         <ul class="link-list-plain">
                                                            <li><a href="#">View</a></li>
                                                            <li><a href="#">Remove</a></li>
                                                         </ul>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                             <tr class="tb-tnx-item">
                                                <td class="tb-tnx-id"><a href="#"><span>5687</span></a></td>
                                                <td class="tb-tnx-info">
                                                   <div class="tb-tnx-desc"><span class="title">Patient Financing Payment</span></div>
                                                   <div class="tb-tnx-date"><span class="date">12-08-2021</span></div>
                                                </td>
                                                <td class="tb-tnx-amount is-alt">
                                                   <div class="tb-tnx-total"><span>$1999.00</span></div>
                                                   <div class="tb-tnx-status"><span class="badge badge-dot text-warning">Panding</span></div>
                                                </td>
                                                <td class="tb-tnx-action">
                                                   <div class="dropdown">
                                                      <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                      <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                         <ul class="link-list-plain">
                                                            <li><a href="#">View</a></li>
                                                            <li><a href="#">Remove</a></li>
                                                         </ul>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6 col-xxl-4">
                                 <div class="card card-bordered h-100">
                                    <div class="card-inner pb-0">
                                       <div class="card-title-group pt-1">
                                          <div class="card-title">
                                             <h6 class="title">EMI Overview</h6>
                                          </div>
                                          <div class="card-tools"><a href="loan-details.html" class="link">See Details</a></div>
                                       </div>
                                    </div>
                                    <div class="card-inner pt-0">
                                       <div class="invest-ov gy-1">
                                          <div class="subtitle">Activated Loan EMI</div>
                                          <div class="invest-ov-details">
                                             <div class="invest-ov-stats">
                                                <div><span class="amount d-flex align-items-end text-primary">52<span class="sub-text ps-1"> Weeks</span></span></div>
                                                <div class="title">Total EMI</div>
                                             </div>
                                             <div class="invest-ov-info">
                                                <div class="amount">3560.395 <span class="currency currency-usd">USD</span></div>
                                                <div class="title">Amount</div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="invest-ov gy-1">
                                          <div class="subtitle">EMI Status</div>
                                          <div class="invest-ov-details">
                                             <div class="invest-ov-info">
                                                <div><span class="amount text-success">39</span></div>
                                                <div class="title">Paid</div>
                                             </div>
                                             <div class="invest-ov-info">
                                                <div><span class="amount text-warning">13</span></div>
                                                <div class="title">Due</div>
                                             </div>
                                             <div class="invest-ov-info">
                                                <div><span class="date">13-05-2021</span></div>
                                                <div class="title">Next EMI Date</div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="invest-ov">
                                          <div class="subtitle">EMI Status</div>
                                          <div class="progress progress-lg mt-3">
                                             <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" data-progress="65">65%</div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6 col-xxl-4">
                                 <div class="card card-bordered h-100">
                                    <div class="pricing recommend">
                                       <span class="pricing-badge badge bg-success">Popular</span>
                                       <div class="pricing-head">
                                          <div class="pricing-title">
                                             <h4 class="card-title title">Pro</h4>
                                             <p class="sub-text">Enjoy entry level of loan.</p>
                                          </div>
                                          <div class="card-text">
                                             <div class="row">
                                                <div class="col-6"><span class="h4 fw-500">0.75%</span><span class="sub-text">Weekly Interest</span></div>
                                                <div class="col-6"><span class="h4 fw-500">2500 USD</span><span class="sub-text">Amount</span></div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="pricing-body">
                                          <ul class="pricing-features">
                                             <li><span class="w-50">Min Amount</span> - <span class="ms-auto">2500 USD</span></li>
                                             <li><span class="w-50">Loan Tenure</span> - <span class="ms-auto">Max 2 years</span></li>
                                             <li><span class="w-50">Interest Rates</span> - <span class="ms-auto">Competitive</span></li>
                                          </ul>
                                          <ul class="pricing-action">
                                             <li><a href="loan-package.html" class="btn btn-primary">Learn Details</a></li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6 col-xxl-4">
                                 <div class="card card-bordered h-100">
                                    <div class="card-inner pb-0">
                                       <div class="card-title-group pt-1">
                                          <div class="card-title">
                                             <h6 class="title">Notifications</h6>
                                          </div>
                                          <div class="card-tools"><a href="/demo5/loan/accounts.html" class="link">View All</a></div>
                                       </div>
                                    </div>
                                    <div class="card-inner">
                                       <div class="timeline">
                                          <ul class="timeline-list">
                                             <li class="timeline-item">
                                                <div class="timeline-status bg-primary is-outline"></div>
                                                <div class="timeline-date">9 Sept <em class="icon ni ni-alarm-alt"></em></div>
                                                <div class="timeline-data">
                                                   <h6 class="timeline-title">Updated loan documents</h6>
                                                   <div class="timeline-des">
                                                      <p>Applicant documents updated</p>
                                                      <span class="time">10:30am</span>
                                                   </div>
                                                </div>
                                             </li>
                                             <li class="timeline-item">
                                                <div class="timeline-status bg-primary"></div>
                                                <div class="timeline-date">2 Sept <em class="icon ni ni-alarm-alt"></em></div>
                                                <div class="timeline-data">
                                                   <h6 class="timeline-title">Added new package</h6>
                                                   <div class="timeline-des">
                                                      <p>Package updated with discount</p>
                                                      <span class="time">09:50am</span>
                                                   </div>
                                                </div>
                                             </li>
                                             <li class="timeline-item">
                                                <div class="timeline-status bg-pink"></div>
                                                <div class="timeline-date">22 Aug <em class="icon ni ni-alarm-alt"></em></div>
                                                <div class="timeline-data">
                                                   <h6 class="timeline-title">Approved loan application</h6>
                                                   <div class="timeline-des">
                                                      <p>Application approved.</p>
                                                      <span class="time">11:20am</span>
                                                   </div>
                                                </div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6 col-xxl-4">
                                 <div class="card card-bordered h-100">
                                    <div class="card-inner card-inner-lg">
                                       <div class="align-center flex-wrap g-4">
                                          <div class="nk-block-image w-120px flex-shrink-0">
                                             <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 120 118">
                                                <path d="M8.916,94.745C-.318,79.153-2.164,58.569,2.382,40.578,7.155,21.69,19.045,9.451,35.162,4.32,46.609.676,58.716.331,70.456,1.845,84.683,3.68,99.57,8.694,108.892,21.408c10.03,13.679,12.071,34.71,10.747,52.054-1.173,15.359-7.441,27.489-19.231,34.494-10.689,6.351-22.92,8.733-34.715,10.331-16.181,2.192-34.195-.336-47.6-12.281A47.243,47.243,0,0,1,8.916,94.745Z" transform="translate(0 -1)" fill="#f6faff"></path>
                                                <rect x="18" y="32" width="84" height="50" rx="4" ry="4" fill="#fff"></rect>
                                                <rect x="26" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe"></rect>
                                                <rect x="50" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe"></rect>
                                                <rect x="74" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe"></rect>
                                                <rect x="38" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe"></rect>
                                                <rect x="62" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe"></rect>
                                                <path d="M98,32H22a5.006,5.006,0,0,0-5,5V79a5.006,5.006,0,0,0,5,5H52v8H45a2,2,0,0,0-2,2v4a2,2,0,0,0,2,2H73a2,2,0,0,0,2-2V94a2,2,0,0,0-2-2H66V84H98a5.006,5.006,0,0,0,5-5V37A5.006,5.006,0,0,0,98,32ZM73,94v4H45V94Zm-9-2H54V84H64Zm37-13a3,3,0,0,1-3,3H22a3,3,0,0,1-3-3V37a3,3,0,0,1,3-3H98a3,3,0,0,1,3,3Z" transform="translate(0 -1)" fill="#798bff"></path>
                                                <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="#6576ff"></path>
                                                <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="none" stroke="#6576ff" stroke-miterlimit="10" stroke-width="2"></path>
                                                <line x1="40" y1="22" x2="57" y2="22" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                <line x1="40" y1="27" x2="57" y2="27" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                <line x1="40" y1="32" x2="50" y2="32" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line>
                                                <line x1="30.5" y1="87.5" x2="30.5" y2="91.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round"></line>
                                                <line x1="28.5" y1="89.5" x2="32.5" y2="89.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round"></line>
                                                <line x1="79.5" y1="22.5" x2="79.5" y2="26.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round"></line>
                                                <line x1="77.5" y1="24.5" x2="81.5" y2="24.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round"></line>
                                                <circle cx="90.5" cy="97.5" r="3" fill="none" stroke="#9cabff" stroke-miterlimit="10"></circle>
                                                <circle cx="24" cy="23" r="2.5" fill="none" stroke="#9cabff" stroke-miterlimit="10"></circle>
                                             </svg>
                                          </div>
                                          <div class="nk-block-content">
                                             <div class="nk-block-content-head">
                                                <h5>We’re here to help you!</h5>
                                                <p class="text-soft">Ask a question or file a support ticket, manage request, report an issues. Our team support team will get back to you by email.</p>
                                             </div>
                                          </div>
                                          <div class="nk-block-content flex-shrink-0"><a href="#" class="btn btn-lg btn-outline-primary">Get Support Now</a></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>



@endsection
