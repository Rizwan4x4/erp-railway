<template>
    <div>
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Final Settlements
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- Full calendar start -->
                    <section class="app-user-list">
                        <div class="card border-0 top-radius bottom-radius shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-12  p-2">
                                        <div class="card m-0 border-0 top-radius bottom-radius ">
                                            <div class="card-body d-flex align-items-center justify-content-between top-radius bottom-radius shadow-sm">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_setts.settls }}</h3>
                                                    <span>Total</span>
                                                </div>
                                                <div class="avatar bg-light-primary p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-users"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12  p-2">
                                        <div class="card m-0 border-0 top-radius bottom-radius ">
                                            <div class="card-body d-flex align-items-center justify-content-between top-radius bottom-radius shadow-sm">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_setts.pend }}</h3>
                                                    <span>Pending</span>
                                                </div>
                                                <div class="avatar bg-light-warning p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-shield"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12  p-2">
                                        <div class="card m-0 border-0 top-radius bottom-radius ">
                                            <div class="card-body d-flex align-items-center justify-content-between top-radius bottom-radius shadow-sm">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_setts.appr }}</h3>
                                                    <span>Approved</span>
                                                </div>
                                                <div class="avatar bg-light-success p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-large-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12 p-2">
                                        <div class="card m-0 border-0 top-radius bottom-radius ">
                                            <div class="card-body d-flex align-items-center justify-content-between top-radius bottom-radius shadow-sm">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_setts.paid }}</h3>
                                                    <span>Paid</span>
                                                </div>
                                                <div class="avatar bg-light-primary p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-large-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12 p-1 p-2">
                                        <div class="card m-0 border-0 top-radius bottom-radius ">
                                            <div class="card-body d-flex align-items-center justify-content-between top-radius bottom-radius shadow-sm">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_setts.rejected }}</h3>
                                                    <span>Rejected</span>
                                                </div>
                                                <div class="avatar bg-light-danger p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-large-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12 p-2">
                                        <div class="card m-0 border-0 top-radius bottom-radius ">
                                            <div class="card-body d-flex align-items-center justify-content-between top-radius bottom-radius shadow-sm">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_setts.deleted }}</h3>
                                                    <span>Deleted</span>
                                                </div>
                                                <div class="avatar bg-light-danger p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-large-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 top-radius bottom-radius">
                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">Start date</label>
                                        <input type="date" v-model="from_date" class="form-control p-2" />
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">End date</label>
                                        <input type="date" v-model="to_date" class="form-control p-2" />
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">Department</label>
                                        <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction"
                                            placeholder="All Departments" :show-labels="false" v-model="department"
                                            :options="options2">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">Designation</label>
                                        <multiselect style="margin-right: 10px;" :show-labels="false"
                                            v-model="designation" :options="options">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Name</label>
                                        <input type="text" v-model="search_name" class="form-control p-2 mt-1"
                                            placeholder="Employee Name" />
                                    </div>
                                    <div class="col-md-1">
                                        <div style="height:27px;"></div>
                                        <button @click="getbyfilter()" class="dt-button add-new btn btn-primary"
                                            tabindex="0" type="button">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Emp. Code</th>
                                            <th class="sticky-th-center">Employee Name</th>
                                            <th class="sticky-th-center">Leaving Date</th>
                                            <th class="sticky-th-center">Total<br />Payable</th>
                                            <th class="sticky-th-center">Overall<br />Status</th>
                                            <th class="sticky-th-center">HR<br />Status</th>
                                            <th class="sticky-th-center">Finance<br />Status</th>
                                            <th class="sticky-th-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="settlements1 in settlements.data">
                                            <td class="td-center">{{ settlements1.EmployeeCode }}</td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar  me-1">
                                                            <img v-if="settlements1.Photo == '' || settlements1.Photo == null"
                                                                src="public/images/profile_images/pro.png" alt="Avatar"
                                                                height="32" width="32">
                                                            <img v-else
                                                                v-bind:src="`public/images/profile_images/${settlements1.Photo}`"
                                                                alt="Avatar" height="32" width="32">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body"><span
                                                                class="fw-bolder">{{ settlements1.Name }} </span></a>
                                                        <small class="emp_post text-muted">
                                                            <small>{{ settlements1.Department }}-{{
                                                                settlements1.Designation }}</small>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">{{ settlements1.ResignOn }}</td>
                                            <td class="td-center">
                                                {{ Math.floor(settlements1.PayableSalary).toLocaleString() }}</td>
                                            <td class="td-center">
                                                <span v-if="settlements1.Status == 'Pending'"
                                                    class="badge bg-gradient-warning">Pending</span>
                                                <span v-if="settlements1.Status == 'Approved'"
                                                    class="badge bg-gradient-success">Approved</span>
                                                <span v-if="settlements1.Status == 'Paid'"
                                                    class="badge bg-gradient-primary">Paid</span>
                                                <span v-if="settlements1.Status == 'Rejected'"
                                                    class="badge bg-gradient-danger">Rejected</span>
                                            </td>
                                            <!--HR status-->
                                            <td class="td-center">
                                                <span v-if="settlements1.HrStatus == 'Approved'"
                                                    class="badge bg-gradient-success">Approved</span>
                                                <span @click="fetch_upSts('hr', settlements1.ID)" data-bs-toggle="modal"
                                                    data-bs-target="#viewLoan"
                                                    v-if="settlements1.PayableSalary > 0 && settlements1.HrStatus == 'Pending'"
                                                    class="badge bg-gradient-warning">Pending</span>
                                                <span v-else-if="settlements1.HrStatus == 'Pending'"
                                                    class="badge bg-gradient-warning">Pending</span>
                                                <span v-if="settlements1.HrStatus == 'Rejected'"
                                                    class="badge bg-gradient-danger">Rejected</span>
                                            </td>
                                            <!--Finance status-->
                                            <td class="td-center">
                                                <span v-if="settlements1.FStatus == 'Approved'"
                                                    class="badge bg-gradient-success">Approved</span>
                                                <span @click="fetch_upSts('finance', settlements1.ID)"
                                                    data-bs-toggle="modal" data-bs-target="#viewLoan"
                                                    v-if="settlements1.HrStatus == 'Approved' && settlements1.FStatus == 'Pending'"
                                                    class="badge bg-gradient-warning">Pending</span>
                                                <span v-else-if="settlements1.FStatus == 'Pending'"
                                                    class="badge bg-gradient-warning">Pending</span>
                                                <span v-if="settlements1.FStatus == 'Rejected'"
                                                    class="badge bg-gradient-danger">Rejected</span>
                                            </td>
                                            <td class="td-center">
                                                <div class="btn-group">
                                                    <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-more-vertical font-small-4">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="12" cy="5" r="1"></circle>
                                                            <circle cx="12" cy="19" r="1"></circle>
                                                        </svg></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a @click="fetch_settlement(settlements1.EmployeeID, settlements1.ID)"
                                                            v-if="settlements1.Status != 'Rejected' && settlements1.FStatus != 'Approved'"
                                                            data-bs-toggle="modal" data-bs-target="#emploan"
                                                            class="dropdown-item">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                            Edit details
                                                        </a>
                                                        <a @click="fetch_upSts('view', settlements1.ID)"
                                                            data-bs-toggle="modal" data-bs-target="#viewLoan"
                                                            class="dropdown-item">
                                                            <i class="fa-solid fa-eye"></i>
                                                            View details
                                                        </a>
                                                        <a v-if="settlements1.PayableSalary <= 0"
                                                            @click="fetch_upSts('view', settlements1.ID)"
                                                            data-bs-toggle="modal" data-bs-target="#delete_setl"
                                                            class="dropdown-item">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                            Delete
                                                        </a>
                                                        <a @click="fetch_upSts('pay', settlements1.ID)"
                                                            data-bs-toggle="modal" data-bs-target="#viewLoan"
                                                            class="dropdown-item"
                                                            v-if="settlements1.Status == 'Approved'">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-check-circle" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                                <path
                                                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                                            </svg>
                                                            Pay
                                                        </a>
                                                        <a v-bind:href="`settlement_slip/${settlements1.ID}`"
                                                            class="dropdown-item" v-if="settlements1.Status == 'Paid'">
                                                            <i class="fa-solid fa-print"></i>
                                                            Generate Slip
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :limit="limit" :data="settlements" @pagination-change-page="getbyfilter">
                                </pagination>
                            </div>
                            <!-- Hoverable rows end -->

                        </div>
                    </section>
                    <!-- Full calendar end -->
                    <!-- View loan Modal -->
                </div>
                <div class="modal fade text-start show" id="viewLoan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user" style="min-width:75%">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <center>
                                        <div class="content-wrapper container-xxl p-0">
                                            <section class="app-user-view-account">
                                                <div class="row">
                                                    <!-- User Sidebar -->
                                                    <div v-for='emp_detail1 in emp_detail'
                                                        class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                                                        <!-- User Card -->
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="user-avatar-section">
                                                                    <div class="d-flex align-items-center flex-column">
                                                                        <img v-if="emp_detail1.Photo == ''"
                                                                            class="img-fluid rounded mt-3 mb-2"
                                                                            src="public/images/profile_images/pro.png"
                                                                            height="110" width="110"
                                                                            alt="User avatar" />
                                                                        <img v-else class="img-fluid rounded mt-3 mb-2"
                                                                            v-bind:src="`public/images/profile_images/${emp_detail1.Photo}`"
                                                                            height="110" width="110"
                                                                            alt="User avatar" />
                                                                        <div class="user-info text-center">
                                                                            <h4>{{ emp_detail1.Name }}</h4>
                                                                            <span class="badge bg-light-secondary">{{
                                                                                emp_detail1.Designation }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-around my-2 pt-75">
                                                                    <div class="d-flex align-items-start me-2">
                                                                    </div>
                                                                    <div class="d-flex align-items-start">
                                                                    </div>
                                                                </div>
                                                                <h4 class="fw-bolder border-bottom pb-50 mb-1">Details
                                                                </h4>
                                                                <div class="info-container">
                                                                    <ul class="list-unstyled">
                                                                        <li class="mb-75">
                                                                            <span
                                                                                class="fw-bolder me-25">Department:</span>
                                                                            <span>{{ emp_detail1.Department }}</span>
                                                                        </li>
                                                                        <li class="mb-75">
                                                                            <span class="fw-bolder me-25">Employee
                                                                                Code:</span>
                                                                            <span>{{ emp_detail1.EmployeeCode }}</span>
                                                                        </li>
                                                                        <li class="mb-75">
                                                                            <span class="fw-bolder me-25">Father
                                                                                Name:</span>
                                                                            <span>{{ emp_detail1.FatherHusband }}</span>
                                                                        </li>
                                                                        <li class="mb-75">
                                                                            <span class="fw-bolder me-25">Phone:</span>
                                                                            <span>{{ emp_detail1.Phone }}</span>
                                                                        </li>
                                                                        <li class="mb-75">
                                                                            <span class="fw-bolder me-25">Employeement
                                                                                Status:</span>
                                                                            <span class="badge bg-light-success">{{
                                                                                emp_detail1.Status }}</span>
                                                                        </li>
                                                                        <li class="mb-75"
                                                                            v-for="final_settlementid1 in final_settlementid">
                                                                            <span class="fw-bolder me-25">Resigned
                                                                                On:</span>
                                                                            <span>{{ final_settlementid1.ResignOn
                                                                                }}</span>
                                                                        </li>
                                                                        <li class="mb-75"
                                                                            v-for="final_settlementid1 in final_settlementid">
                                                                            <span class="fw-bolder me-25">Resigned
                                                                                By:</span>
                                                                            <span>{{ rep_employees.created_by }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /User Card -->
                                                    </div>
                                                    <!--/ User Sidebar -->
                                                    <!-- User Content -->
                                                    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                                                        <div v-for='emp_detail1 in emp_detail' v-if="man != 'pay'"
                                                            class="card">
                                                            <div class="card-header">
                                                                <div style="float:left">
                                                                    <h4 class="card-title mb-50">Personal Details</h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-12">
                                                                        <dl class="row mb-0">
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Joining
                                                                                Date:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{ emp_detail1.JoiningDate }}</dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">
                                                                                Probation End:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{ emp_detail1.ProbationEnd }}</dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Salary:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(emp_detail1.Salary).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Stipend:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(emp_detail1.Stipend).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                        </dl>
                                                                    </div>
                                                                    <div class="col-xl-6 col-12">
                                                                        <dl class="row mb-0">
                                                                            <dt class="col-sm-5 fw-bolder mb-1">
                                                                                Reporting To:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                <label>{{ rep_employees.rep1 }}</label>
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Address:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{ emp_detail1.Address }},
                                                                                {{ emp_detail1.City }}</dd>
                                                                        </dl>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-for='final_settlementid1 in final_settlementid'
                                                            class="card">
                                                            <div class="card-header">
                                                                <div style="float:left">
                                                                    <h4 class="card-title mb-50">Settlement details</h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-12">
                                                                        <dl class="row mb-0">
                                                                            <dt class="col-sm-5 fw-bolder mb-1">
                                                                                Settlement amount:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.SettlementAmount).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Loan:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.LoanAmount).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Dues:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.DuesAmount).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">
                                                                                Allowance:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.AllowanceAmount).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Total
                                                                                Payable:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                <label>{{
                                                                                    Math.floor(final_settlementid1.PayableSalary).toLocaleString()
                                                                                    }}</label>
                                                                            </dd>
                                                                        </dl>
                                                                    </div>
                                                                    <div class="col-xl-6 col-12">
                                                                        <dl class="row mb-0">
                                                                            <dt class="col-sm-5 fw-bolder mb-1">
                                                                                Gratuity:</dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.Gratuity).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Fine:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.Fine).toLocaleString()
                                                                                }}
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Arrears:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                <label>{{
                                                                                    Math.floor(final_settlementid1.ArrearsAmount).toLocaleString()
                                                                                    }}</label>
                                                                            </dd>
                                                                            <dt class="col-sm-5 fw-bolder mb-1">Bonus:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{
                                                                                Math.floor(final_settlementid1.BonusAmount).toLocaleString()
                                                                                }}
                                                                            </dd>

                                                                            <dt class="col-sm-5 fw-bolder mb-1">Remarks:
                                                                            </dt>
                                                                            <dd class="col-sm-7 mb-1">
                                                                                {{ final_settlementid1.Remarks }}</dd>
                                                                        </dl>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="man == 'pay'" class="card">
                                                            <div class="card-header">
                                                                <div style="float:left">
                                                                    <h4 class="card-title mb-50">Personal Details</h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body" style="text-align:left;">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <label class="form-label">Cash Ledger</label>
                                                                        <input type="text" readonly v-model="cash_type"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Cash Amount</label>
                                                                        <input readonly v-model="cash_amount"
                                                                            type="number" class="form-control" />
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <label class="form-label">Bank Ledger</label>
                                                                        <multiselect dis style="margin-right: 10px;"
                                                                            v-model="bank_type" :options="options3">
                                                                        </multiselect>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Bank Amount</label>
                                                                        <input v-model="bank_amount" type="text"
                                                                            class="form-control"
                                                                            @input="amount_filter()" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6 col-12 row"
                                                            v-if="man != 'view' && man != 'pay'" style="float:left;">
                                                            <dt class="col-sm-5 fw-bolder mb-1">Update status:</dt>
                                                            <dd class="col-sm-7 mb-1">
                                                                <select v-model="us_man" class="form-select">
                                                                    <option value="" selected>Select</option>
                                                                    <option value="Approved">Approve</option>
                                                                    <option value="Rejected">Reject</option>
                                                                </select>
                                                            </dd>
                                                        </div>
                                                        <div class="col-xl-6 col-12 row" v-if="man == 'pay'"
                                                            style="float:left;">
                                                            <dt class="col-sm-5 fw-bolder mb-1">Pay settlement:</dt>
                                                            <dd class="col-sm-7 mb-1">
                                                                <select v-model="us_man" class="form-select">
                                                                    <option value="" selected>Select</option>
                                                                    <option value="Paid">Pay</option>
                                                                </select>
                                                            </dd>
                                                        </div>
                                                        <!-- Project table -->
                                                    </div>
                                                    <!--/ User Content -->
                                                </div>
                                            </section>
                                        </div>
                                    </center>
                                </div>
                                <div class="col-12 text-center mt-2 pt-50">
                                    <button v-if="man != 'view' && man != 'pay' && man != ''" type="button"
                                        :disabled="disabled1" @click="delay1()"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal" aria-label="Close">Update</button>
                                    <button v-if="man == 'pay' && man != '' && us_man == 'Paid'" type="button"
                                        :disabled="disabled1" @click="delay()"
                                        class="btn btn-success waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">Pay Settlement</button>
                                    <button v-else-if="man == 'pay' && man != '' && us_man != 'Paid'" type="button"
                                        :disabled="disabled1" @click="delay()"
                                        class="btn btn-success waves-effect waves-float waves-light">Pay
                                        Settlement</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="emploan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-3 mx-50">
                                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Add final settlement
                                </h1>
                                <p class="address-subtitle text-center mb-2 pb-75">Input Details</p>
                                <form id="addNewAddressForm" style="text-align:left;" class="row gy-1 gx-2"
                                    onsubmit="return false">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Employee Name - Code</label>
                                        <select disabled v-model="name" class="form-select mb-md-0 mb-2">
                                            <option value="">Select</option>
                                            <option v-for="employees1 in employees" :value='employees1.EmployeeID'>
                                                {{ employees1.Name }} - {{ employees1.EmployeeCode }}</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Date Of Joining</label>
                                        <input type="date" class="form-control" disabled v-model="doj" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label"><span
                                                v-if="status == 'Resigned'">Resignation</span><span
                                                v-else-if="status == 'Terminated'">Termination</span> Date</label>
                                        <input type="date" class="form-control" disabled v-model="doR" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Salary + Stipend</label>
                                        <input type="number" class="form-control" disabled v-model="sal_stipSum" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Loan & Advance</label>
                                        <input type="number" class="form-control" v-model="loan"
                                            placeholder="Loan amount" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Arrears</label>
                                        <input type="number" class="form-control" v-model="arrears"
                                            placeholder="Arrears" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Allowance</label>
                                        <input type="number" class="form-control" v-model="allowance"
                                            placeholder="Allowance" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="allowance == ''">{{
                                            e_allowance }}</span>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Gratuity</label>
                                        <input type="number" class="form-control" v-model="graduaty"
                                            placeholder="Graduaty" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="graduaty == ''">{{
                                            e_graduaty }}</span>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Bonus</label>
                                        <input type="number" class="form-control" v-model="bonus" placeholder="Bonus" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="bonus == ''">{{ e_bonus
                                            }}</span>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Fine</label>
                                        <input type="number" class="form-control" v-model="fine" placeholder="Fine" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Settlement amount</label>
                                        <input type="number" class="form-control" v-model="set_amount"
                                            placeholder="Settlement" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="set_amount == ''">{{
                                            e_set_amount }}</span>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <label class="form-label">Remarks</label>
                                        <input type="text" class="form-control" v-model="remarks"
                                            placeholder="Type remarks here" />
                                    </div>
                                    <div class="col-12 text-center">
                                        <button :disabled="disabled2" @click="delay2()" type="submit"
                                            class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal"
                                            aria-label="Close">Apply</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-2"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ View loan Modal -->
                <div class="modal fade" id="delete_setl" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        np
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="fw-bolder">Confirmation</h1>
                                    <h5>Do you want to delete the Final Settlement?</h5>
                                    <div class="text-center">
                                        <button type="button" @click="delete_settlement(usid)"
                                            class="btn btn-primary waves-effect waves-float waves-light"
                                            data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                        <button type="submit" class="btn btn-outline-primary waves-effect"
                                            data-bs-dismiss="modal" aria-label="Close">No</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
    data() {
        return {
            images: {
                solar_filter_linear: "/images/solar_filter_linear.png",
                search_icon: "/images/search_icon.png",
            },
            cash_amount: '',
            cash_type: "101001001001_Cash in Hand",
            fix_amount: 0,
            bank_type: '',
            bank_amount: 0,


            count_setts: {},
            limit: 8,
            status: '',
            doR: '',
            set_id: '',
            employees: {},
            name: '',
            sal_stipSum: '',
            doj: '',
            last_date: '',
            e_last_date: '',
            set_amount: '',
            e_set_amount: '',
            allowance: '',
            e_allowance: '',
            graduaty: '',
            e_graduaty: '',
            bonus: '',
            e_bonus: '',
            fine: '',

            deduction: '',
            e_deduction: '',
            loan: '',
            arrears: '',
            remarks: '',


            final_settlementid: {},
            emp_detail: {},
            rep_employees: {},
            settlements: {},
            departments: {},
            designations: {},

            us_man_error: '',
            man: '',
            us_man: '',
            //Search filter
            from_date: '',
            to_date: '',
            from_date1: '',
            to_date1: '',
            department: 'All',
            designation: 'All',
            search_name: '',
            search_name1: '',
            //

            options: [],
            options2: [],
            options3: [],
            methods1: {},
            disabled: false,
            timeout: null,
            disabled1: false,
            timeout1: null,
            disabled2: false,
            timeout2: null,
        }
    },
    components: {
        Multiselect
    },
    methods: {
        amount_filter() {
            if (this.bank_amount > 0) {
                let x = this.fix_amount - this.bank_amount;
                if (x >= 0) {
                    this.cash_amount = x;
                }
            }
            else {
                this.cash_amount = this.fix_amount;
            }
        },

        delete_settlement(id) {
            axios.get('delete_settlement/' + id)
                .then(data => {
                    if (data.data == 'settlement deleted') {
                        this.$toastr.s('Final settlement has been deleted!', "Success!");

                        const updatedIndex = this.settlements.data.findIndex(item => item.ID === id);
                        if (updatedIndex !== -1) {

                            this.settlements.data.splice(updatedIndex, 1);

                            this.usid = '';




                            // Update other properties as needed
                        }
                        this.count_settlements();
                    }
                    else {
                        this.$toastr.e(data.data, "Error!");
                    }
                })
                .catch(error => { });
        },
        fetch_settlement(empid, setid) {
            this.name = empid;
            this.set_id = setid;
            axios.get('fetch_employee_dtl/' + this.name)
                .then(responce => {
                    this.sal_stipSum = Number(responce.data[0].Salary) + Number(responce.data[0].Stipend);
                    this.doj = responce.data[0].JoiningDate;
                    this.doR = responce.data[0].ResignDate;
                    this.status = responce.data[0].Status;
                })
                .catch(error => { });

            axios.get('fetch_pending_loan/' + this.name)
                .then(responce => {
                    this.loan = responce.data;
                })
                .catch(error => { });
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.pay_settlement()
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.update_set_status()
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
            this.apply_settlement()
        },
        apply_settlement() {
            if (this.arrears < 0 || this.allowance < 0 || this.graduaty < 0 || this.bonus < 0 || this.set_amount < 0 || this.fine < 0) {
                this.$toastr.w('Please enter positive values!', "Warning!");
            }
            else {
                axios.post('./add_settlement', {
                    set_id: this.set_id,
                    emp_id: this.name,
                    salary: this.sal_stipSum,
                    loan: this.loan,
                    fine: this.fine,
                    arrears: this.arrears,
                    allowance: this.allowance,
                    graduaty: this.graduaty,
                    bonus: this.bonus,
                    set_amount: this.set_amount,
                    remarks: this.remarks,
                })
                    .then(data => {
                        if (data.data == "Final settlement added") {
                            this.$toastr.s('Final settlement has been added!', "Congratulations");

                            const updatedIndex = this.settlements.data.findIndex(item => item.ID === this.set_id);
                            console.log(updatedIndex);
                            if (updatedIndex !== -1) {

                                this.settlements.data[updatedIndex].settlements = this.loan;
                                this.settlements.data[updatedIndex].Fine = this.fine;
                                this.settlements.data[updatedIndex].ArrearsAmount = this.arrears;
                                this.settlements.data[updatedIndex].AllowanceAmount = this.allowance;
                                this.settlements.data[updatedIndex].Gratuity = this.graduaty;
                                this.settlements.data[updatedIndex].BonusAmount = this.bonus;
                                this.settlements.data[updatedIndex].SettlementAmount = this.set_amount;
                                this.settlements.data[updatedIndex].Remarks = this.remarks;




                                this.set_id = '';
                                this.name = '';
                                this.sal_stipSum = '';
                                this.loan = '';
                                this.arrears = '';
                                this.graduaty = '';
                                this.bonus = '';
                                this.allowance = '';
                                this.set_amount = '';
                                this.remarks = '';





                                // Update other properties as needed
                            }

                        }
                        else {
                            this.$toastr.s(data.data, "Congratulations");
                        }
                    })
            }
        },
        pay_settlement() {
            if (this.fix_amount < (Number(this.cash_amount) + Number(this.bank_amount))) {
                this.$toastr.e('Please enter valid amount to pay!', "Caution!");
            }
            else {
                axios.post('./pay_settlement', {
                    usid: this.usid,
                    man: this.man,
                    us_man: this.us_man,
                    cash_type: this.cash_type,
                    cash_amount: this.cash_amount,
                    bank_type: this.bank_type,
                    bank_amount: this.bank_amount,
                })
                    .then(data => {
                        if (data.data == "Final settlement has been paid successfully!") {
                            this.$toastr.s(data.data, "Congratulations!");
                            this.us_man = '';
                            this.man = '';
                            this.usid = '';
                            this.cash_amount = '';
                            this.bank_type = '';
                            this.bank_amount = 0;
                            this.getbyfilter();
                        }
                        else {
                            this.$toastr.e(data.data, "Caution!");
                        }
                    })
            }
        },
        fetch_upSts(man, id) {
            this.man = man;
            this.usid = id;
            axios.get('fetch_set_upSts/' + this.usid)
                .then(responce => {
                    this.final_settlementid = responce.data;
                    this.cash_amount = Math.floor(responce.data[0].PayableSalary);
                    this.fix_amount = Math.floor(responce.data[0].PayableSalary);
                    this.bank_amount = 0;
                    this.us_man = '';
                    this.bank_type = '';
                })

            axios.get('emp_set_detail/' + this.usid)
                .then(data => {
                    this.emp_detail = data.data;
                })

            axios.get('set_rep/' + this.usid)
                .then(data => {
                    this.rep_employees = data.data;
                })
        },
        update_set_status() {
            axios.post('./update_sett_sts', {
                usid: this.usid,
                man: this.man,
                us_man: this.us_man,
            })
                .then(data => {
                    if (data.data == "Final settlement's status not updated!") {
                        this.$toastr.e(data.data, "Caution");
                    }
                    else {
                        this.$toastr.s(data.data, "Congratulations");
                        this.us_man = '';
                        this.man = '';
                        this.usid = '';
                        this.getbyfilter();
                        this.count_settlements();
                    }
                })
        },
        count_settlements() {
            axios.get('./count_settlements')
                .then(response => this.count_setts = response.data)
                .catch(error => { });
        },
        getbyfilter(page = 1) {
            if (this.from_date == '' || this.from_date == null) {
                this.from_date1 = '0000-00-00';
            }
            else {
                this.from_date1 = this.from_date;
            }
            if (this.to_date == '' || this.to_date == null) {
                this.to_date1 = '9999-12-31';
            }
            else {
                this.to_date1 = this.to_date;
            }
            if (this.search_name == '' || this.search_name == null) {
                this.search_name1 = 'All';
            }
            else {
                this.search_name1 = this.search_name;
            }
            if (this.department == '' || this.department == null) {
                this.department = 'All';
            }
            else {
                this.department = this.department;
            }
            if (this.designation == '' || this.designation == null) {
                this.designation = 'All';
            }
            else {
                this.designation = this.designation;
            }
            axios.get('./settlement_by_filter/' + this.from_date1 + '/' + this.to_date1 + '/' + this.department + '/' + this.designation + '/' + this.search_name1 + '?page=' + page)
                .then(response => {
                    this.settlements = response.data
                })
                .catch(error => { });
        },
        async fetchDepartment() {
            try {

                this.departments = await this.$helpers.checkLocal('department_detail');
                this.options2 = [];

                var $this = this;
                for (var i = 0; i < $this.departments.length; i++) {
                    this.options2.push($this.departments[i].Department);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        async fetchDesignation() {
            try {
                this.designations = await this.$helpers.checkLocal('overall_designation');
                this.options = [];

                var $this = this;
                for (var i = 0; i < $this.designations.length; i++) {
                    this.options.push($this.designations[i].designation_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
    },
    mounted() {
        this.getbyfilter();
        this.count_settlements();
        this.fetchDesignation();
        this.fetchDepartment()

        axios.get('accounts/fetch_methods1')
            .then(response => {
                this.methods1 = response.data
                this.options3 = [];

                var $this = this;
                for (var j = 0; j < $this.methods1.length; j++) {
                    this.options3.push($this.methods1[j].ID + '_' + $this.methods1[j].AccountName);
                }
            })

        axios.get('overall_employees_pr')
            .then(response => this.employees = response.data)
            .catch(error => { });




    },

};
</script>
<style scoped>
.border-0 {
    border: 0;
}

.top-radius {
    border-top-left-radius: 12px !important;
    border-top-right-radius: 12px !important;
}

.bottom-radius {
    border-bottom-left-radius: 12px !important;
    border-bottom-right-radius: 12px !important;
}

.bg-custom {
    background-color: #F9F9F9 !important;
}
.mb-75 {
    text-align: left;
}

.mb-1 {
    text-align: left;
}
</style>

