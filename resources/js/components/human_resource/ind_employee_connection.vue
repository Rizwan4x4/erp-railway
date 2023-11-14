<template>
 <div>
   <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                                    </li>
                                    <li class="breadcrumb-item">
                                    <router-link to="/hr/employees_detail" style="text-decoration: none;">Employees Detail</router-link>
                                    </li>
                                    <li class="breadcrumb-item active">Employee Performance
                                    </li>
                                </ol>
            <b-progress :value="value" variant="success" :striped="striped" animated class="mb-3"></b-progress>
            </div>
            <div class="content-body">
                <section class="app-user-view-account">
                    <div class="row">
                        <!-- User Sidebar -->
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            <img class="img-fluid rounded mt-3 mb-2" src="public/app-assets/images/portrait/small/avatar-s-2.jpg" height="110" width="110" alt="User avatar" />
                                            <div class="user-info text-center">
                                                <h4>Full Name</h4>
                                                <span class="badge bg-light-secondary">Designation</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-around my-2 pt-75">
                                        <div class="d-flex align-items-start me-2">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather="check" class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">4</h4>
                                                <small>Years Completed</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather="briefcase" class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">90%</h4>
                                                <small>Progress</small>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                                    <div class="info-container">
                                        <ul class="list-unstyled">
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Username:</span>
                                                <span>violet.dev</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Billing Email:</span>
                                                <span>vafgot@vultukir.org</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Status:</span>
                                                <span class="badge bg-light-success">Active</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Role:</span>
                                                <span>Author</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Tax ID:</span>
                                                <span>Tax-8965</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Contact:</span>
                                                <span>+1 (609) 933-44-22</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Language:</span>
                                                <span>English</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Country:</span>
                                                <span>Wake Island</span>
                                            </li>
                                        </ul>
                                        <div class="d-flex justify-content-center pt-2">
                                            <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser" data-bs-toggle="modal">
                                              Warning
                                            </a>
                                            <a href="javascript:;" class="btn btn-outline-danger suspend-user">Suspend</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /User Card -->
                            <!-- Plan Card -->
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <span class="badge bg-light-primary">Salary</span>
                                        <div class="d-flex justify-content-center">
                                            <sup class="h5 pricing-currency text-primary mt-1 mb-0" >Rs.</sup>
                                            <span class="fw-bolder display-5 mb-0 text-primary" style="font-size:18px">50,000</span>
                                            <sub class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                        </div>
                                    </div>
                                    <div style="font-size:18px;margin-top:20px"><span class="fw-bolder display-5 mb-0 text-primary" style="font-size:18px" >Job Description</span>
                                    </div>
                                    <ul class="ps-1 mb-2" style="padding-left:20px !important">
                                        <li class="mb-50">10 Users</li>
                                        <li class="mb-50">Up to 10 GB storage</li>
                                        <li>Front End Development</li>
                                         <li>Front End Development</li>
                                          <li>Office Assistant</li>
                                           <li>Basic Support</li>
                                            <li>Basic Support</li>
                                             <li>Basic Support</li>
                                    </ul>
                                    
                                </div>
                            </div>
                            <!-- /Plan Card -->
                        </div>
                        <!--/ User Sidebar -->

                        <!-- User Content -->
                        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                            <!-- User Pills -->
                            <!-- User Pills -->
                            <ul class="nav nav-pills mb-2" style="padding-left:20px !important">
                                <li class="nav-item">
                                    <router-link to="/hr/employee_detail"  class="nav-link" >
                                        <i class="fa-solid fa-person"></i>
                                        <span class="fw-bold">Personal</span></router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/hr/employee_leaves" class="nav-link" >
                                       <i class="fa-solid fa-candy-cane"></i>
                                        <span class="fw-bold">Leaves</span>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/hr/employee_attendance" class="nav-link" >
                                      <i class="fa-solid fa-file-powerpoint"></i>
                                        <span class="fw-bold">Attendance</span>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/hr/employee_financial" class="nav-link" >
                                       <i class="fa-solid fa-receipt"></i><span class="fw-bold">Financial History</span>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link active" to="/hr/employee_perfomance">
                                        <i class="fa-solid fa-link"></i><span class="fw-bold">Performance</span>
                                    </router-link>
                                </li>
                            </ul>
                            <!--/ User Pills -->
                         <!-- Project table -->
                            <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title">Connections</h4>
                                    </div>
                                    <div class="card-body pt-2">
                                        
                                        <!-- Social Accounts -->
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0">
                                                <img src="public/app-assets/images/icons/social/facebook.png" alt="facebook" class="me-1" height="38" width="38">
                                            </div>
                                            <div class="d-flex justify-content-between flex-grow-1">
                                                <div class="me-1">
                                                    <p class="fw-bolder mb-0">Facebook</p>
                                                    <span>Not Connected</span>
                                                </div>
                                                <div class="mt-50 mt-sm-0">
                                                    <button type="button" class="btn btn-icon btn-outline-secondary waves-effect">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link font-medium-3"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start mt-2">
                                            <div class="flex-shrink-0">
                                                <img src="public/app-assets/images/icons/social/twitter.png" alt="twitter" class="me-1" height="38" width="38">
                                            </div>
                                            <div class="d-flex justify-content-between flex-grow-1">
                                                <div class="me-1">
                                                    <p class="fw-bolder mb-0">Twitter</p>
                                                    <a href="https://twitter.com/pixinvent" target="_blank">@pixinvent</a>
                                                </div>
                                                <div class="mt-50 mt-sm-0">
                                                    <button type="button" class="btn btn-icon btn-outline-secondary waves-effect">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x font-medium-3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0">
                                                <img src="public/app-assets/images/icons/social/linkedin.png" alt="instagram" class="me-1" height="38" width="38">
                                            </div>
                                            <div class="d-flex justify-content-between flex-grow-1">
                                                <div class="me-1">
                                                    <p class="fw-bolder mb-0">Linkedin</p>
                                                    <a href="https://www.linkedin.com/company/pixinvent" target="_blank"> @pixinvent </a>
                                                </div>
                                                <div class="mt-50 mt-sm-0">
                                                    <button type="button" class="btn btn-icon btn-outline-secondary waves-effect">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x font-medium-3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0">
                                                <img src="public/app-assets/images/icons/social/dribbble.png" alt="dribbble" class="me-1" height="38" width="38">
                                            </div>
                                            <div class="d-flex justify-content-between flex-grow-1">
                                                <div class="me-1">
                                                    <p class="fw-bolder mb-0">Dribbble</p>
                                                    <span>Not Connected</span>
                                                </div>
                                                <div class="mt-50 mt-sm-0">
                                                    <button type="button" class="btn btn-icon btn-outline-secondary waves-effect">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link font-medium-3"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <div class="flex-shrink-0">
                                                <img src="public/app-assets/images/icons/social/behance.png" alt="behance" class="me-1" height="38" width="38">
                                            </div>
                                            <div class="d-flex justify-content-between flex-grow-1">
                                                <div class="me-1">
                                                    <p class="fw-bolder mb-0">Behance</p>
                                                    <span>Not Connected</span>
                                                </div>
                                                <div class="mt-50 mt-sm-0">
                                                    <button type="button" class="btn btn-icon btn-outline-secondary waves-effect">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link font-medium-3"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Social Accounts -->
                                    </div>
                                </div>
                            <!-- /Project table -->
                          
                             
                        </div>
                        <!--/ User Content -->
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
   
   </div>
</template>

<script>
    export default {
    data() {
        return {
       value: 75,
       striped:true,
        }
        },
        methods:{
            
        },
        mounted() {
        
        }
    }
</script>