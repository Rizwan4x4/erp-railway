<template>
      <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Salary Distribution
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body" style="min-height: 55px;margin-bottom: 10px;">
                                    <ul class="nav nav-pills mb-2">
                                        <li class="nav-item">
                                            <router-link to="/payroll/salary_generation" class="nav-link">
                                                <i class="fa-solid fa-cash-register"></i>
                                                <span class="fw-bold">Generated Salaries <span class="red-dot"
                                                                                               v-if="salary_state.gen === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_hr_approval" class="nav-link">
                                                <i class="fa-solid fa-address-card"></i>
                                                <span class="fw-bold">HR Approval <span class="red-dot"
                                                                                        v-if="salary_state.hr === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_finance_approval" class="nav-link">
                                                <i class="fa-solid fa-coins"></i>
                                                <span class="fw-bold">Finance Approval <span class="red-dot"
                                                                                             v-if="salary_state.fin === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/distribution" class="nav-link active">
                                                <i class="fa-solid fa-money-bill-wave"></i><span class="fw-bold">Distribution <span
                                                class="red-dot" v-if="salary_state.dis === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/payroll/payroll_pending_salaries">
                                                <i class="fa-solid fa-rotate-left"></i><span class="fw-bold">Pending Salaries</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="basic-table">
                        <div class="col-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 col-12" style=" width: 27%;">
                                        <h5 style="padding-left:10px;padding-top:10px;">Session: {{ session_name }}</h5>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                                            <li v-if=" hasPermission('Payroll Generate Salary Slip') "  class="nav-item">
                                                <a class="nav-link active" id="homeIcon-tab" data-bs-toggle="tab"
                                                   href="#homeIcon" aria-controls="home" role="tab"
                                                   aria-selected="true"><i data-feather="home"></i>Generate Slip</a>
                                            </li>
                                            <li v-if=" hasPermission('Payroll Bank Distribution List') "  class="nav-item">
                                                <a class="nav-link" id="profileIcon-tab" data-bs-toggle="tab"
                                                   href="#profileIcon" aria-controls="profile" role="tab"
                                                   aria-selected="false"><i data-feather="tool"></i>Bank Distribution
                                                    List</a>
                                            </li>
                                            <li v-if=" hasPermission('Payroll Cash Distribution List') " class="nav-item">
                                                <a class="nav-link" id="aboutIcon-tab" @click="salary_received()"
                                                   data-bs-toggle="tab" href="#aboutIcon" aria-controls="about"
                                                   role="tab" aria-selected="false"><i data-feather="user"></i>Cash
                                                    Distribution List</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab"
                                         role="tabpanel">
                                        <div class="d-flex">
                                            <div class="col-md-1 col-12 mb-2">
                                            </div>
                                            <div class="col-md-3 col-12 mb-2">
                                                <input type="text" id="EmployeeName" v-model="keyword4"
                                                       class="form-control" placeholder="Search By Employee Name, Code or CNIC">
                                            </div>
                                            <div class="col-md-1 col-12 mb-2">
                                                <button @click="getResults4()" class="btn btn-primary">Search</button>
                                            </div>
                                            <div class="col-md-1 col-12 mb-2">
                                            </div>
                                            <div class="col-md-3 col-12 mb-2">
                                                <input type="text" v-model="keyword2" class="form-control"
                                                       placeholder="Write department name and press enter">
                                            </div>
                                            <div class="col-md-3 col-12 mb-2 mx-2">
                                                <h6>Rs: {{ Number(tSalary).toLocaleString() }} is Remaining Payable
                                                    <br/> of {{ tEmp }} employees</h6>
                                            </div>
                                        </div>
                                        <div class="accordion-body" v-if="is_data=='1'">
                                            <div class="table-responsive" id="SalaryDist">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th style="font-size:10px !important;">Emp. Code</th>
                                                        <th style="font-size:10px !important;width:150px">Employee
                                                            Name
                                                        </th>
                                                        <th style="font-size:10px !important;">Basic<br/>Salary</th>
                                                        <th style="font-size:10px !important;">Ded..</th>
                                                        <th style="font-size:10px !important;">OT</th>
                                                        <th style="font-size:10px !important;">Loan Inst.</th>
                                                        <th style="font-size:10px !important;">Fine & Dues</th>
                                                        <th style="font-size:10px !important;">Arrears<br/>& Bonus</th>
                                                        <th style="font-size:10px !important;">Allowance</th>
                                                        <th style="font-size:10px !important;">Payable<br/>Salary</th>
                                                        <th style="font-size:10px !important;">Remaining<br/>Salary</th>
                                                        <th style="font-size:10px !important;">Method</th>
                                                        <th style="font-size:10px !important;">Status</th>
                                                        <th style="font-size:10px !important;"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="all_sals1 in emp_data">
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals1.EmpCode }}
                                                        </td>
                                                        <td style="font-size:10px !important;border-right:1px solid lightgrey">
                                                            <div class="d-flex justify-content-left align-items-center">
                                                                <div class="avatar-wrapper">
                                                                    <div class="avatar  me-1">
                                                                        <img
                                                                            v-if="all_sals1.Photo=='' || all_sals1.Photo==null"
                                                                            src="public/images/profile_images/pro.png"
                                                                            alt="Avatar" height="32" width="32">
                                                                        <img v-else
                                                                             v-bind:src="`public/images/profile_images/${all_sals1.Photo}`"
                                                                             alt="Avatar" height="32" width="32">
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a class="user_name text-truncate text-body"><span
                                                                        class="fw-bolder">{{ all_sals1.Name }} </span></a><small
                                                                    class="emp_post text-muted">
                                                                    <span
                                                                        v-if="all_sals1.PostingCity!=null">{{ all_sals1.PostingCity }} - </span>
                                                                    <span v-else></span>
                                                                    <span
                                                                        v-if="all_sals1.Department!=null">{{ all_sals1.Department }} - </span>
                                                                    <span v-else></span>
                                                                    <span
                                                                        v-if="all_sals1.Designation!=null">{{ all_sals1.Designation }}</span>
                                                                    <span v-else></span>
                                                                </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals1.Salary }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ Math.round(all_sals1.DAmount) }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ Math.round(all_sals1.OAmount) }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals1.InstallmentAmount }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ sumStats(all_sals1.Fine, all_sals1.DuesAmount) }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{
                                                                sumStats(all_sals1.ArrearsAmount, all_sals1.BonusAmount)
                                                            }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals1.AllowanceAmount }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ Math.floor(all_sals1.PayableSalary).toLocaleString() }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ Math.floor(all_sals1.RemainingAmount).toLocaleString() }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals1.MethodType }}
                                                        </td>
                                                        <td v-if="all_sals1.SalaryStatus=='Not Received'"
                                                            style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            <a @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmpCode,all_sals1.EmployeeID)"
                                                               data-bs-toggle="modal" data-bs-target="#editpayroll">
                                                                <span
                                                                    class="badge badge-glow bg-info">Not Received</span>
                                                            </a>
                                                        </td>
                                                        <td v-else-if="all_sals1.SalaryStatus=='Partially Received'"
                                                            @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmpCode,all_sals1.EmployeeID)"
                                                            data-bs-toggle="modal" data-bs-target="#editpayroll"
                                                            style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            <span
                                                                class="badge badge-glow bg-warning">Partially Received</span>
                                                        </td>
                                                        <td v-else
                                                            style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            <span
                                                                class="badge badge-glow bg-success">Fully Received</span>
                                                        </td>
                                                        <td>
                                                            <a v-if=" hasPermission('Payroll View Salary Slip')" data-bs-target="#viewcandidate"
                                                               @click="fetch_emp_payroll(all_sals1.DistributionID)"
                                                               data-bs-toggle="modal"><i style="color:#0d6efd"
                                                                                         class="fa-solid fa-eye"></i></a>
                                                            <a v-if=" hasPermission('Payroll Generate Salary Slip') && all_sals1.ReceivedThrough!=null" target="_blank"
                                                               v-bind:href="`${url}/generate_slip/${all_sals1.EmployeeID}/${all_sals1.DistributionID}/${all_sals1.EmpCode}`"><i
                                                                class="fa-solid fa-download"></i></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <p>
                                            <div class="accordion accordion-border" id="accordionBorder">
                                                <div class="accordion-item" v-for="adsdata1 in adsdata">
                                                    <h2 class="accordion-header" :id="'headingBorder'+adsdata1.id">
                                                        <button @click="getResult(adsdata1.department_name)"
                                                                class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                :data-bs-target="'#accordionBorder'+adsdata1.id"
                                                                aria-expanded="false"
                                                                :aria-controls="'accordionBorder'+adsdata1.id">
                                                            {{ adsdata1.department_name }}
                                                        </button>
                                                    </h2>
                                                    <div :id="'accordionBorder'+adsdata1.id"
                                                         class="accordion-collapse collapse"
                                                         :aria-labelledby="'headingBorder'+adsdata1.id"
                                                         data-bs-parent="#accordionBorder">
                                                        <div class="accordion-body">
                                                            <div class="table-responsive">
                                                                <table class="table" id="SalaryDist">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="font-size:10px !important;">Emp.
                                                                            Code
                                                                        </th>
                                                                        <th style="font-size:10px !important;width:150px">
                                                                            Employee Name
                                                                        </th>
                                                                        <th style="font-size:10px !important;">
                                                                            Basic<br/>Salary
                                                                        </th>
                                                                        <th style="font-size:10px !important;">Ded..
                                                                        </th>
                                                                        <th style="font-size:10px !important;">OT</th>
                                                                        <th style="font-size:10px !important;">Loan
                                                                            Inst.
                                                                        </th>
                                                                        <th style="font-size:10px !important;">Fine &
                                                                            Dues
                                                                        </th>
                                                                        <th style="font-size:10px !important;">
                                                                            Arrears<br/>& Bonus
                                                                        </th>
                                                                        <th style="font-size:10px !important;">
                                                                            Allowance
                                                                        </th>
                                                                        <th style="font-size:10px !important;">
                                                                            Payable<br/>Salary
                                                                        </th>
                                                                        <th style="font-size:10px !important;">Remaining<br/>Salary
                                                                        </th>
                                                                        <th style="font-size:10px !important;">Method
                                                                        </th>
                                                                        <th style="font-size:10px !important;">Status
                                                                        </th>
                                                                        <th style="font-size:10px !important;"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr v-for="all_sals1 in all_sals">
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ all_sals1.EmpCode }}
                                                                        </td>
                                                                        <td style="font-size:10px !important;border-right:1px solid lightgrey">
                                                                            <div
                                                                                class="d-flex justify-content-left align-items-center">
                                                                                <div class="avatar-wrapper">
                                                                                    <div class="avatar  me-1">
                                                                                        <img
                                                                                            v-if="all_sals1.Photo=='' || all_sals1.Photo==null"
                                                                                            src="public/images/profile_images/pro.png"
                                                                                            alt="Avatar" height="32"
                                                                                            width="32">
                                                                                        <img v-else
                                                                                             v-bind:src="`public/images/profile_images/${all_sals1.Photo}`"
                                                                                             alt="Avatar" height="32"
                                                                                             width="32">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex flex-column">
                                                                                    <a class="user_name text-truncate text-body"><span
                                                                                        class="fw-bolder">{{ all_sals1.Name }} </span></a><small
                                                                                    class="emp_post text-muted">
                                                                                    <span
                                                                                        v-if="all_sals1.PostingCity!=null">{{ all_sals1.PostingCity }} - </span>
                                                                                    <span v-else></span>
                                                                                    <span
                                                                                        v-if="all_sals1.Department!=null">{{ all_sals1.Department }} - </span>
                                                                                    <span v-else></span>
                                                                                    <span
                                                                                        v-if="all_sals1.Designation!=null">{{ all_sals1.Designation }}</span>
                                                                                    <span v-else></span>
                                                                                </small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ all_sals1.Salary }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ Math.round(all_sals1.DAmount) }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ Math.round(all_sals1.OAmount) }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ all_sals1.InstallmentAmount }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{
                                                                                sumStats(all_sals1.Fine, all_sals1.DuesAmount)
                                                                            }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{
                                                                                sumStats(all_sals1.ArrearsAmount, all_sals1.BonusAmount)
                                                                            }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ all_sals1.AllowanceAmount }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ Math.floor(all_sals1.PayableSalary).toLocaleString() }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ Math.floor(all_sals1.RemainingAmount).toLocaleString() }}
                                                                        </td>

                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            {{ all_sals1.MethodType }}
                                                                        </td>
                                                                        <td v-if="all_sals1.SalaryStatus=='Not Received'"
                                                                            style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            <a @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmpCode,all_sals1.EmployeeID)"
                                                                               data-bs-toggle="modal"
                                                                               data-bs-target="#editpayroll">
                                                                                <span class="badge badge-glow bg-info">Not Received</span>
                                                                            </a>
                                                                        </td>

                                                                        <td v-else-if="all_sals1.SalaryStatus=='Partially Received'"
                                                                            style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey"
                                                                            @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmpCode,all_sals1.EmployeeID)"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editpayroll">
                                                                            <span class="badge badge-glow bg-warning">Partially Received</span>
                                                                        </td>
                                                                        <td v-else
                                                                            style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            <span class="badge badge-glow bg-success">Fully Received</span>
                                                                        </td>
                                                                        <td>
                                                                            <a data-bs-target="#viewcandidate"
                                                                               @click="fetch_emp_payroll(all_sals1.DistributionID)"
                                                                               data-bs-toggle="modal">
                                                                                <i style="color:#0d6efd"
                                                                                   class="fa-solid fa-eye"></i>
                                                                            </a>
                                                                            <a v-if="all_sals1.ReceivedThrough!=null"
                                                                               target="_blank"
                                                                               v-bind:href="`${url}/generate_slip/${all_sals1.EmployeeID}/${all_sals1.DistributionID}/${all_sals1.EmpCode}`"><i
                                                                                class="fa-solid fa-download"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="profileIcon" aria-labelledby="profileIcon-tab"
                                         role="tabpanel">
                                        <p>
                                            <div v-if=" hasPermission('Payroll Bank Distribution List')" class="table-responsive">
                                                <table class="table" id="bank_distribution_list">
                                                    <thead>
                                                    <tr>
                                                        <th style="font-size:10px !important;">Emp. Code</th>
                                                        <th style="font-size:10px !important;width:150px">Name</th>
                                                        <th style="font-size:10px !important;">Total Payable</th>
                                                        <th style="font-size:10px !important;">Bank Name</th>
                                                        <th style="font-size:10px !important;">Account Name</th>
                                                        <th style="font-size:10px !important;">Account Number</th>
                                                        <th style="font-size:10px !important;">Bank Tranfer Amount</th>
                                                        <th>
                                                            <button type="button"
                                                                    @click="html_table_to_excel('xlsx','bank_distribution_list')"
                                                                    class="btn btn-gradient-info">Excel
                                                            </button>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="all_sals11 in all_sals10">
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals11.EmpCode }}
                                                        </td>
                                                        <td style="font-size:10px !important;border-right:1px solid lightgrey">
                                                            <div class="d-flex justify-content-left align-items-center">
                                                                <div class="avatar-wrapper">
                                                                    <div class="avatar  me-1">
                                                                        <img
                                                                            v-if="all_sals11.Photo=='' || all_sals11.Photo==null"
                                                                            src="public/images/profile_images/pro.png"
                                                                            alt="Avatar" height="32" width="32">
                                                                        <img v-else
                                                                             v-bind:src="`public/images/profile_images/${all_sals11.Photo}`"
                                                                             alt="Avatar" height="32" width="32">
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <a class="user_name text-truncate text-body"><span
                                                                        class="fw-bolder">{{ all_sals11.Name }} </span></a><small
                                                                    class="emp_post text-muted">
                                                                    <span
                                                                        v-if="all_sals11.PostingCity!=null">{{ all_sals11.PostingCity }} - </span>
                                                                    <span v-else></span>
                                                                    <span
                                                                        v-if="all_sals11.Department!=null">{{ all_sals11.Department }} - </span>
                                                                    <span v-else></span>
                                                                    <span
                                                                        v-if="all_sals11.Designation!=null">{{ all_sals11.Designation }}</span>
                                                                    <span v-else></span>
                                                                </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals11.PayableSalary }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals11.bank_name }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals11.account_name }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals11.BankAccount }}
                                                        </td>
                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                            {{ all_sals11.BankAmount }}
                                                        </td>
                                                        <td>
                                                            <a data-bs-target="#viewcandidate"
                                                               @click="fetch_emp_payroll(all_sals11.DistributionID)"
                                                               data-bs-toggle="modal"><i style="color:#0d6efd"
                                                                                         class="fa-solid fa-eye"></i><span></span></a>
                                                            <a 
                                                               target="_blank"
                                                               v-bind:href="`${url}/generate_slip/${all_sals11.EmployeeID}/${all_sals11.DistributionID}/${all_sals11.EmpCode}`"><i
                                                                class="fa-solid fa-download"></i></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </p>
                                    </div>
                                    <div class="tab-pane active" id="aboutIcon" aria-labelledby="aboutIcon-tab"
                                         role="tabpanel">
                                        <div class="accordion accordion-border accordion-flush" id="accordionBorder">
                                            <div class="accordion-item" v-for="date_list1 in date_list">
                                                <h2 class="accordion-header" :id="('headingBorder'+date_list1)">
                                                    <button @click="getReceivedSalary(date_list1)"
                                                            class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            :data-bs-target="('#accordionBorder'+date_list1)"
                                                            aria-expanded="false"
                                                            :aria-controls="('accordionBorder'+date_list1)">
                                                        {{ date_list1 }}
                                                    </button>
                                                </h2>
                                                <div :id="('accordionBorder'+date_list1)"
                                                     class="accordion-collapse collapse"
                                                     :aria-labelledby="'headingBorder'+date_list1"
                                                     data-bs-parent="#accordionBorder">
                                                    <div class="accordion-body">
                                                        <h6>Rs: {{ Number(total_deduct).toLocaleString() }} Cash has been
                                                            distributed among {{ received_list.length }} Employees Today: {{date_list1}}</h6>
                                                            <button type="button"
                                                                    @click="html_table_to_excel('xlsx','cash_distribution_list')"
                                                                    class="btn btn-gradient-info">Download Excel
                                                            </button>
                                                        <div class="table-responsive"
                                                             style="overflow-x: initial !important;" >
                                                            <table class="table table-hover" id="cash_distribution_list">
                                                                <thead>
                                                                <tr>
                                                                    <th class="sticky-th-center">Emp. Code</th>
                                                                    <th class="sticky-th-center">Name</th>
                                                                    <th class="sticky-th-center">Received<br/>Through
                                                                    </th>

                                                                    <th class="sticky-th-center">Total Cash Paid</th>
                                                                    <th class="sticky-th-center">Last Cash Paid</th>
                                                                    <th class="sticky-th-center">Total Paid</th>
                                                                    <th class="sticky-th-center">Last Paid</th>
                                                                    <th class="sticky-th-center">Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="all_sals1 in received_list">
                                                                    <td class="td-center">{{ all_sals1.EmpCode }}</td>
                                                                    <td class="td-center">
                                                                        <div
                                                                            class="d-flex justify-content-left align-items-center">
                                                                            <div class="avatar-wrapper">
                                                                                <div class="avatar  me-1">
                                                                                    <img
                                                                                        v-if="all_sals1.Photo=='' || all_sals1.Photo==null"
                                                                                        src="public/images/profile_images/pro.png"
                                                                                        alt="Avatar" height="32"
                                                                                        width="32">
                                                                                    <img v-else
                                                                                         v-bind:src="`public/images/profile_images/${all_sals1.Photo}`"
                                                                                         alt="Avatar" height="32"
                                                                                         width="32">
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex flex-column">
                                                                                <p>{{ all_sals1.Name }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="td-center">
                                                                        {{ all_sals1.ReceivedThrough }}
                                                                    </td>
                                                                  <td class="td-center">
                                                                        {{ Number(all_sals1.CashAmount).toLocaleString() }}
                                                                    </td>
                                                                    <td class="td-center">
                                                                        {{ Number(all_sals1.CurrentCashPaid).toLocaleString() }}
                                                                    </td>
                                                                    <td class="td-center">{{  Number(all_sals1.PaidAmount).toLocaleString() }}</td>
                                                                    <td class="td-center">{{  Number(all_sals1.CurrentPaidAmount).toLocaleString() }}</td>

                                                                    <td class="td-center">
                                                                        <a data-bs-target="#viewcandidate"
                                                                           @click="fetch_emp_payroll(all_sals1.DistributionID)"
                                                                           data-bs-toggle="modal"><i
                                                                            style="color:#0d6efd"
                                                                            class="fa-solid fa-eye"></i></a>
                                                                        <a v-if="all_sals1.ReceivedThrough!=null"
                                                                           target="_blank"
                                                                           v-bind:href="`../sag_app1.1/generate_slip1/${all_sals1.EmployeeID}/${all_sals1.DistributionID}/${all_sals1.EmpCode}/${all_sals1.SessionName}`"><i
                                                                            class="fa-solid fa-download"></i></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal table -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewcandidate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div v-for="view_employee_slip1 in view_employee_slip" class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <div class="justify-content-start align-items-center mb-1">
                                <!-- avatar -->
                                <div class="avatar">
                                    <img v-if="view_employee_slip1.Photo=='' || view_employee_slip1.Photo==null"
                                         src="public/images/profile_images/pro.png" alt="Avatar" height="60" width="60">
                                    <img v-else v-bind:src="`public/images/profile_images/${view_employee_slip1.Photo}`"
                                         alt="Avatar" height="60" width="60">
                                </div>
                                <!--/ avatar -->
                                <div class="profile-user-info">
                                    <h5 class="mb-0">{{ view_employee_slip1.Name }}</h5>
                                    <small class="text-muted">
                                        {{ view_employee_slip1.Designation }}
                                    </small>
                                </div>
                            </div>
                            <center>
                                <div class="table-responsive">
                                    <table class="" style="width:100%">
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Salary Month</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ sesss_date }}
                                            </td>
                                            <td class="col-md-3"
                                                style="padding-left:30px;border-bottom:1px dotted lightgray;">
                                                <span class="fw-bolder me-25">Basic Salary</span>
                                            </td>
                                            <td class="col-md-3"
                                                style="text-align: right;border-bottom:1px dotted lightgray;">
                                                Rs. {{ view_employee_slip1.Salary }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Department</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.Department }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Stipend</span>
                                            </td>
                                            <td class="col-md-3">
                                                Rs. {{ view_employee_slip1.StipendAmount.toLocaleString() }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Posting City</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.PostingCity }}
                                            </td>
                                            <td class="col-md-3" style="background: lightgray;padding-left:30px"
                                                colspan="2">
                                                <span class="fw-bolder me-25" style="">Arrears And Allowance</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Date Of Birth</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.DOB }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25" style="">OT</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{ view_employee_slip1.OAmount }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Employee Code</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.EmpCode }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Arrears</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{ view_employee_slip1.ArrearsAmount }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">CNIC</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.CNIC }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Bonus</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{ view_employee_slip1.BonusAmount }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Phone No</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.Mobile }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Allowance</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">

                                                Rs.
                                                {{ sumStats(view_employee_slip1.AllowanceAmount, view_employee_slip1.FuelAmount) }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Prepared By</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                HR Department
                                            </td>
                                            <td class="col-md-3" style="background: lightgray;padding-left:30px"
                                                colspan="2">
                                                <span class="fw-bolder me-25" style="">Deduction & Loans</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Job Status</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.JobStatus }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span
                                                    class="fw-bolder me-25">Installment {{ view_employee_slip1.InstallmentNo }}</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs.
                                                {{ sumStats(view_employee_slip1.InstallmentAmount, view_employee_slip1.AdvanceAmount) }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Date Of Joining</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.JoiningDate }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Fine & Tax</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs.
                                                {{ sumStats(view_employee_slip1.Fine, view_employee_slip1.TaxAmount) }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Payment Method</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.MethodType }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Dues</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs.
                                                {{ sumStats(view_employee_slip1.DuesAmount, view_employee_slip1.FuelReceivable) }}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Address</span>
                                            </td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{ view_employee_slip1.Address }}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Att. Deduction</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{ view_employee_slip1.DAmount }}/-
                                            </td>
                                        </tr>
                                        <tfoot style="">
                                        <tr style="background: lightgray;">
                                            <th style="padding-top:5px;padding-bottom:5px;font-size:16px;color:red"
                                                scope="col" class="ng-star-inserted">Net Payable:
                                            </th>
                                            <th style="text-align:right;padding-top:5px;padding-bottom:5px;font-size:16px;color:red"
                                                scope="col"> Rs. {{ view_employee_slip1.PayableSalary }}/-
                                            </th>
                                            <th scope="col">Bank: Rs.
                                                {{ Math.floor(view_employee_slip1.BankAmount).toLocaleString() }}/-
                                            </th>
                                            <th scope="col">Cash: Rs.
                                                {{ Math.floor(view_employee_slip1.CashAmount).toLocaleString() }}/-
                                            </th>

                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editpayroll" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h5>Paying Salary To {{ emp_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <form class="row gy-1 gx-2 mt-75">
                            <div class="col-md-6">
                                <label class="form-label">Employee Name</label>
                                <input v-model="emp_name" type="text" readonly class="form-control"/>
                                <input hidden v-model="dist_id" type="text" readonly class="form-control"/>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Employee Code</label>
                                <input v-model="emp_co" type="text" readonly class="form-control"/>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Remaining Salary</label>
                                <input v-model="emp_payable" type="number" readonly class="form-control"/>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Department</label>
                                <input v-model="dept_nam" type="text" readonly class="form-control"/>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cash Ledger</label>
                                <input type="text" readonly v-model="cash_type" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cash Amount</label>
                                <input v-model="cash_amount" type="number" class="form-control"/>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Bank Ledger</label>
                                <multiselect style="margin-right: 10px;" v-model="bank_type"
                                             :options="options"></multiselect>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bank Amount</label>
                                <input v-model="bank_amount" type="number" class="form-control"/>
                            </div>
                            <div class="col-12 text-center">
                                <button v-if="hasPermission('Payroll Update Status by Paying Salary')" type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary"
                                        data-bs-dismiss="modal" aria-label="Close">Pay Salary
                                </button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import axios from "axios";

export default {
    data() {
        return {
            url: process.env.MIX_APP_URL,
            is_data: '0',
            emp_data: {},
            all_sals: {},
            all_sals10: {},
            adsdata: {},
            emp_id: 'All',
            designation: 'All',
            dept_search: '',
            department: 'All',
            tEmp: '',
            tSalary: '',
            status: 'All',
            emp_code: '',
            keyword2: '',
            keyword4: '',
            session_name: '',
            view_employee_slip: {},
            salary_state: {},
            date_list: {},
            dist_id: '',
            emp_name: '',
            emp_payable: '',
            cash_type: "101001001001_Cash in Hand",
            cash_amount: 0,
            bank_amount: 0,
            bank_type: "",
            options: [],
            methods: {},
            methods1: {},
            received_list: {},
            disabled1: false,
            timeout1: null,
            dept_nam: '',
            fix_amount: 0,
            total_deduct: 0,
            sess_n: '',
            sesss_date: '',
            emp_co: '',
            empl_id: '',
        }
    },
    components: {
        Multiselect,
    },
    methods: {
        handleGlobalKeyDown(event){
            if (event.keyCode === 13 || event.keyCode === 8 || event.keyCode === 46) {
                    this.getResults1();
            }
        },
        getReceivedSalary(date) {
            for (let x = 0; x < this.date_list.length; x++) {
                let z = document.getElementById("accordionBorder" + this.date_list[x])
                z.classList.remove("show")
            }

            axios.get('cash_distributionlist_detail1/' + date)
                .then(response => {
                    this.received_list = response.data;
                })
                .catch(error => console.log(error));

            axios.get("cash_distribution_totalamount/" + date)
                .then((response) => {
                    let liaS = response.data.map((curEle) => {
                        return curEle.CurrentCashPaid
                    }).reduce((accu, curr) => {
                        return Number(accu) + Number(curr)
                    }, 0)

                    this.total_deduct = liaS
                })
        },
        salary_received() {
            axios.get("cash_distributionlist_detail_date")
                .then((response) => {
                    let date_checking = [...new Set(response.data)]
                    this.date_list = date_checking
                })
        },
        getResults1() {
            axios.get('search_payroll_distributiondept', {params: {keyword1: this.keyword2}})
                .then(response => {
                    this.is_data = '0';
                    this.adsdata = response.data;

                })
                .catch(error => console.log(error));
        },
        getResults4() {
            axios.get('dist_byName', {params: {keyword4: this.keyword4}})
                .then(response => {
                    this.is_data = '1';
                    this.emp_data = response.data;

                })
                .catch(error => console.log(error));
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 500)
            this.updatesalarystatus()
        },
        updatesalarystatus() {
            if (this.bank_amount == '' && this.bank_amount != '') {
                this.$toastr.e("Please enter bank amount!", "Caution!");
            } else {
                axios.post('update_emp_dist_salary', {
                    dist_id: this.dist_id,
                    emp_name: this.emp_name,
                    emp_payable: this.emp_payable,
                    cash_type: this.cash_type,
                    cash_amount: this.cash_amount,
                    bank_amount: this.bank_amount,
                    bank_type: this.bank_type,
                })
                    .then(data => {
                            if (data.data == 'error') {
                                this.$toastr.e("Your Amount cannot be greater then Remaining Salary!", "Cautions");
                            } else if (data.data == 'error2') {
                                this.$toastr.e("Bank Detail Invalid!", "Cautions");
                            } else if (data.data == 'Remaining Payable is Incorrect') {
                                this.$toastr.e("Remaining Payable is Incorrect!", "Cautions");
                            } else if (data.data == 'Salary Not Found') {
                                this.$toastr.e("Salary Detail Not found", "Cautions");
                            } else if (data.data == 'Not Sufficient Balance') {
                                this.$toastr.e("Not Sufficient Balance", "Cautions");
                            } else if (data.data == 'submitted') {
                                this.$toastr.s("Paid Salary Successfully!", "Congratulations");
                                this.getResult(this.dept_nam);
                                window.open(this.url + "/generate_slip/" + this.empl_id + "/" + this.dist_id + "/" + this.emp_co, '_blank');
                                this.dist_id = '';
                                this.emp_name = '';
                                this.emp_payable = '';
                                this.cash_type = this.cash_type;
                                this.cash_amount = '0';
                                this.bank_amount = '0';
                                this.bank_type = '';
                            }

                        }
                    ).catch(error => {
                    if (error.response.data.message == 'Payroll dist Already Exists.') {
                        this.$toastr.e("", "Error!");
                    }
                })
            }
        },
        fetch_stipend_detail(stipend, emp_nam, emp_payable, dept, emp_code, emp_id) {
            this.dist_id = stipend;
            this.emp_name = emp_nam;
            this.emp_payable = Number(emp_payable);
            this.cash_amount = Number(emp_payable);
            this.dept_nam = dept;
            this.fix_amount = this.emp_payable;
            this.emp_co = emp_code;
            this.empl_id = emp_id;
        },
        fetch_emp_payroll(id) {
            axios.get('view_emp_salary_slip/' + id)
                .then(response => {
                    this.view_employee_slip = response.data;
                    this.sess_n = response.data[0].SessionName;
                    axios.get('find_sess_date/' + this.sess_n)
                        .then(response => this.sesss_date = response.data)
                })
                .catch(error => {
                });
        },
        getResult(department_name) {
            this.is_data = '0';
            axios.get('fetch_distribution_cash_payabale/' + department_name)
                .then(response => this.all_sals = response.data)
                .catch(error => {
                });
        },
        sumStats(num1, num2) {
            return parseInt(num1) + parseInt(num2);
        },
        html_table_to_excel(type, tableID) {
            var uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table border="1">{table}</table></body></html>',
                base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function (s, c) {
                    return s.replace(/{(\w+)}/g, function (m, p) {
                        return c[p];
                    })
                }
            var data = document.getElementById(tableID).innerHTML;
            var ctx = {
                worksheet: name || '',
                table: data
            };
            var link = document.createElement("a");
            link.download = tableID + ".xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        },
    },
    watch: {
        keyword2(after, before) {
            this.getResults1();
        },
    },
    mounted() {
        document.addEventListener('keydown', this.handleGlobalKeyDown);

        axios.get('salary_state')
            .then(data => this.salary_state = data.data)
            .catch(error => {
            });

        axios.get('hr/totalEmp_SalaryCount')
            .then(response => {
                this.tEmp = response.data[0].TotalEmployess;
                this.tSalary = response.data[0].TotalPayableSalary;
            })

        axios.get('accounts/fetch_methods1')
            .then(response => {
                this.methods1 = response.data
                this.options = [];
                var $this = this;
                for (var j = 0; j < $this.methods1.length; j++) {
                    this.options.push($this.methods1[j].ID + '_' + $this.methods1[j].AccountName);
                }
            })

        axios.get('fetch_distribution_bank_payabale/')
            .then(response => this.all_sals10 = response.data)
            .catch(error => {
            });

        axios.get('department_detail2')
            .then(data => {
                this.adsdata = data.data
            })
            .catch(error => {
            });

        axios.get('session_pre_dis')
            .then(response => {
                this.session_name = response.data;
            })

    

     
    },

    beforeDestroy() {
        // Remove the event listener when the component is destroyed to prevent memory leaks
        document.removeEventListener('keydown', this.handleGlobalKeyDown);
    },
}
</script>


