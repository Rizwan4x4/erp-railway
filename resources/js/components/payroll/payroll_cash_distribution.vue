<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Financial Approval
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body" style="min-height: 55px;margin-bottom: 10px;">
                                    <ul class="nav nav-pills mb-2" style="width:80%; float:left">
                                        <li class="nav-item">
                                            <router-link to="/payroll/salary_generation" class="nav-link ">
                                                <i class="fa-solid fa-person"></i>
                                                <span class="fw-bold">HR Salary Generation</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_hr_approval" class="nav-link">
                                                <i class="fa-solid fa-candy-cane"></i>
                                                <span class="fw-bold">HR Approval</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_finance_approval" class="nav-link">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Finance Approval</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/distribution" class="nav-link active">
                                                <i class="fa-solid fa-receipt"></i><span class="fw-bold">Distribution</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/payroll/archive">
                                                <i class="fa-solid fa-link"></i><span class="fw-bold">Archive</span>
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
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <h5 style="padding-left:10px;padding-top:10px">Session Name: {{this.session_name}}</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Tabs with Icon starts -->
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs justify-content-center" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="homeIcon-tab" data-bs-toggle="tab" href="#homeIcon" aria-controls="home" role="tab" aria-selected="true"><i data-feather="home"></i> Cash Payable</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="profileIcon-tab" data-bs-toggle="tab" href="#profileIcon" aria-controls="profile" role="tab" aria-selected="false"><i data-feather="tool"></i> Bank Payable</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="aboutIcon-tab" data-bs-toggle="tab" href="#aboutIcon" aria-controls="about" role="tab" aria-selected="false"><i data-feather="user"></i> Distribution List</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                                                        <p>
                                                            <div class="accordion accordion-border" id="accordionBorder">
                                                                <div class="accordion-item" v-for="adsdata1 in adsdata">
                                                                    <h2 class="accordion-header" :id="'headingBorder'+adsdata1.id">
                                                                        <button @click="getResult(adsdata1.department_name)" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder'+adsdata1.id" aria-expanded="false" :aria-controls="'accordionBorder'+adsdata1.id">
                                                                            {{adsdata1.department_name}}
                                                                        </button>
                                                                    </h2>
                                                                    <div :id="'accordionBorder'+adsdata1.id" class="accordion-collapse collapse" :aria-labelledby="'headingBorder'+adsdata1.id" data-bs-parent="#accordionBorder">
                                                                        <div class="accordion-body">
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="font-size:10px !important;">Emp. Code</th>
                                                                                            <th style="font-size:10px !important;width:150px">Name</th>
                                                                                            <th style="font-size:10px !important;">Basic</th>
                                                                                            <th style="font-size:10px !important;">Deduction</th>
                                                                                            <th style="font-size:10px !important;">Overtime</th>
                                                                                            <th style="font-size:10px !important;">Loan Inst.</th>
                                                                                            <th style="font-size:10px !important;">Fine & Dues</th>
                                                                                            <th style="font-size:10px !important;">Arrears & Bonus</th>
                                                                                            <th style="font-size:10px !important;">Allowance</th>
                                                                                            <th style="font-size:10px !important;">Payable Salary</th>
                                                                                            <th style="font-size:10px !important;">Method</th>
                                                                                            <th style="font-size:10px !important;"></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr v-for="all_sals1 in all_sals">
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">{{all_sals1.EmpCode}}</td>
                                                                                            <td style="font-size:10px !important;border-right:1px solid lightgrey">
                                                                                                <div class="d-flex justify-content-left align-items-center">
                                                                                                    <div class="avatar-wrapper">
                                                                                                        <div class="avatar  me-1">
                                                                                                            <img v-if="all_sals1.Photo=='' || all_sals1.Photo==null" src="public/images/profile_images/pro.png" alt="Avatar" height="32" width="32">
                                                                                                            <img v-else v-bind:src="`public/images/profile_images/${all_sals1.Photo}`" alt="Avatar" height="32" width="32">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="d-flex flex-column">
                                                                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals1.Name}} </span></a><small class="emp_post text-muted">
                                                                                                            <span v-if="all_sals1.PostingCity!=null">{{all_sals1.PostingCity}} - </span>
                                                                                                            <span v-else></span>
                                                                                                            <span v-if="all_sals1.Department!=null">{{all_sals1.Department}} - </span>
                                                                                                            <span v-else></span>
                                                                                                            <span v-if="all_sals1.Designation!=null">{{all_sals1.Designation}}</span>
                                                                                                            <span v-else></span>
                                                                                                        </small>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals1.Salary}}</td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{Math.round(all_sals1.DAmount)}}</td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{Math.round(all_sals1.OAmount)}}</td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals1.InstallmentAmount}}</td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs.{{ sumStats(all_sals1.Fine, all_sals1.DuesAmount) }} </td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                                                Rs.{{ sumStats(all_sals1.ArrearsAmount, all_sals1.BonusAmount) }}
                                                                                            </td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals1.AllowanceAmount}} </td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals1.PayableSalary}}</td>
                                                                                            <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">{{all_sals1.MethodType}}</td>
                                                                                            <td>
                                                                                                <a data-bs-target="#viewcandidate" @click="fetch_emp_payroll(all_sals1.EmployeeID)" data-bs-toggle="modal"><i style="color:#0d6efd" class="fa-solid fa-eye"></i><span></span></a>

                                                                                                <a target="_blank" v-bind:href="`${url}/generate_slip/${all_sals1.EmployeeID}/${all_sals1.DistributionID}/${all_sals1.EmpCode}`"><i class="fa-solid fa-download"></i></a>
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
                                                    <div class="tab-pane" id="profileIcon" aria-labelledby="profileIcon-tab" role="tabpanel">
                                    <p>
                                        <div class="accordion accordion-border" id="accordionBorder">
                                            <div class="accordion-item" v-for="adsdata111 in adsdata11">
                                                <h2 class="accordion-header" :id="'headingBorder'+adsdata111.id">
                                                    <button @click="getResultbank(adsdata111.department_name)" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder'+adsdata111.id" aria-expanded="false" :aria-controls="'accordionBorder'+adsdata111.id">
                                                        {{adsdata111.department_name}}
                                                    </button>
                                                </h2>
                                                <div :id="'accordionBorder'+adsdata111.id" class="accordion-collapse collapse" :aria-labelledby="'headingBorder'+adsdata111.id" data-bs-parent="#accordionBorder">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="font-size:10px !important;">Emp. Code</th>
                                                                        <th style="font-size:10px !important;width:150px">Name</th>
                                                                        <th style="font-size:10px !important;">Basic</th>
                                                                        <th style="font-size:10px !important;">Deduction</th>
                                                                        <th style="font-size:10px !important;">Overtime</th>
                                                                        <th style="font-size:10px !important;">Loan Inst.</th>
                                                                        <th style="font-size:10px !important;">Fine & Dues</th>
                                                                        <th style="font-size:10px !important;">Arrears & Bonus</th>
                                                                        <th style="font-size:10px !important;">Allowance</th>
                                                                        <th style="font-size:10px !important;">Payable Salary</th>
                                                                        <th style="font-size:10px !important;">Method</th>
                                                                        <th style="font-size:10px !important;"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="all_sals11 in all_sals10">
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">{{all_sals11.EmpCode}}</td>
                                                                        <td style="font-size:10px !important;border-right:1px solid lightgrey">
                                                                            <div class="d-flex justify-content-left align-items-center">
                                                                                <div class="avatar-wrapper">
                                                                                    <div class="avatar  me-1">
                                                                                        <img v-if="all_sals11.Photo=='' || all_sals11.Photo==null" src="public/images/profile_images/pro.png" alt="Avatar" height="32" width="32">
                                                                                        <img v-else v-bind:src="`public/images/profile_images/${all_sals11.Photo}`" alt="Avatar" height="32" width="32">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex flex-column">
                                                                                    <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals11.Name}} </span></a><small class="emp_post text-muted">
                                                                                        <span v-if="all_sals11.PostingCity!=null">{{all_sals11.PostingCity}} - </span>
                                                                                        <span v-else></span>
                                                                                        <span v-if="all_sals11.Department!=null">{{all_sals11.Department}} - </span>
                                                                                        <span v-else></span>
                                                                                        <span v-if="all_sals11.Designation!=null">{{all_sals11.Designation}}</span>
                                                                                        <span v-else></span>
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals11.Salary}}</td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{Math.round(all_sals11.DAmount)}}</td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{Math.round(all_sals11.OAmount)}}</td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals11.InstallmentAmount}}</td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs.{{ sumStats(all_sals11.Fine, all_sals11.DuesAmount) }} </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">
                                                                            Rs.{{ sumStats(all_sals11.ArrearsAmount, all_sals11.BonusAmount) }}
                                                                        </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals11.AllowanceAmount}} </td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">Rs. {{all_sals11.PayableSalary}}</td>
                                                                        <td style="text-align:center;font-size:10px !important;border-right:1px solid lightgrey">{{all_sals11.MethodType}}</td>
                                                                        <td>
                                                                            <a data-bs-target="#viewcandidate" @click="fetch_emp_payroll(all_sals11.EmployeeID)" data-bs-toggle="modal"><i style="color:#0d6efd" class="fa-solid fa-eye"></i><span></span></a>
                                                                            <a target="_blank" v-bind:href="`${url}/generate_slip/${all_sals11.EmployeeID}/${all_sals11.DistributionID}/${all_sals11.EmpCode}`"><i class="fa-solid fa-download"></i></a>
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
                                                    <div class="tab-pane" id="aboutIcon" aria-labelledby="aboutIcon-tab" role="tabpanel">
                                                        <p>
                                                            Gingerbread cake cheesecake lollipop topping bonbon chocolate sesame snaps. Dessert macaroon bonbon
                                                            carrot cake biscuit. Lollipop lemon drops cake gingerbread liquorice. Sweet gummies dragée. Donut bear
                                                            claw pie halvah oat cake cotton candy sweet roll. Cotton candy sweet roll donut ice cream.
                                                        </p>
                                                        <p>
                                                            Halvah bonbon topping halvah ice cream cake candy. Wafer gummi bears chocolate cake topping powder.
                                                            Sweet marzipan cheesecake jelly-o powder wafer lemon drops lollipop cotton candy.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tabs with Icon ends -->
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
                                    <img v-if="view_employee_slip1.Photo=='' || view_employee_slip1.Photo==null" src="public/images/profile_images/pro.png" alt="Avatar" height="60" width="60">
                                    <img v-else v-bind:src="`public/images/profile_images/${view_employee_slip1.Photo}`" alt="Avatar" height="60" width="60">
                                </div>
                                <!--/ avatar -->
                                <div class="profile-user-info">
                                    <h5 class="mb-0">{{view_employee_slip1.Name}}</h5>
                                    <small class="text-muted">
                                        {{view_employee_slip1.Designation}}
                                    </small>
                                </div>
                            </div>
                            <center>
                                <div class="table-responsive">
                                    <table class="" style="width:100%">
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Salary Month</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.SessionName}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px;border-bottom:1px dotted lightgray;">
                                                <span class="fw-bolder me-25">Basic Salary</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;border-bottom:1px dotted lightgray;">
                                                Rs. {{view_employee_slip1.Salary}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Department</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.Department}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25"></span>
                                            </td>
                                            <td class="col-md-3">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Posting City</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.PostingCity}}
                                            </td>
                                            <td class="col-md-3" style="background: lightgray;padding-left:30px" colspan="2">
                                                <span class="fw-bolder me-25" style="">Arrears And Allowance</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Date Of Birth</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.DOB}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25" style="">Overtime</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.OAmount}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Employee Code</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.EmpCode}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Arrears</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.ArrearsAmount}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">CNIC</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.CNIC}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Bonus</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.BonusAmount}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Phone No</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.Mobile}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Allowance</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.AllowanceAmount}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Prepared By</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                HR Department
                                            </td>
                                            <td class="col-md-3" style="background: lightgray;padding-left:30px" colspan="2">
                                                <span class="fw-bolder me-25" style="">Deduction & Loans</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Job Status</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.JobStatus}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Installment {{view_employee_slip1.InstallmentNo}}</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.InstallmentAmount}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Date Of Joining</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.JoiningDate}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Fine</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.Fine}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Payment Method</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.MethodType}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Dues</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.DuesAmount}}/-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-3">
                                                <span class="fw-bolder me-25">Address</span></td>
                                            <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                {{view_employee_slip1.Address}}
                                            </td>
                                            <td class="col-md-3" style="padding-left:30px">
                                                <span class="fw-bolder me-25">Att. Deduction</span>
                                            </td>
                                            <td class="col-md-3" style="text-align: right;">
                                                Rs. {{view_employee_slip1.DAmount}}/-
                                            </td>
                                        </tr>
                                        <tfoot style="">
                                            <tr style="background: lightgray;">
                                                <th scope="col"></th>
                                                <th scope="col"></th>
                                                <th style="padding-top:5px;padding-bottom:5px;font-size:16px;color:red" scope="col" class="ng-star-inserted">Net Payable:</th>
                                                <th style="text-align:right;padding-top:5px;padding-bottom:5px;font-size:16px;color:red" scope="col"> Rs. {{view_employee_slip1.PayableSalary}}/-</th>
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
    </div>
</template>
<script>
import axios from "axios";
export default {
    data() {
        return {
                url: process.env.MIX_APP_URL,
            all_sals: {},
            all_sals10: {},
            find_emp: {},
            designations: {},
            adsdata: {},
            adsdata11:{},
            emp_id: 'All',
            designation: 'All',
            department: 'All',
            status: 'All',

            session_name: '',
            view_employee_slip: {},
        }
    },

    methods: {

        fetch_emp_payroll(id) {
            axios.get('view_emp_salary_slip/' + id)
                .then(response => this.view_employee_slip = response.data)
                .catch(error => {});


        },



        getResult(department_name) {

            axios.get('fetch_distribution_cash_payabale/' + department_name)
                .then(response => this.all_sals = response.data)
                .catch(error => {});
        },
        getResultbank(department_name) {
            this.all_sals10={ };
            axios.get('fetch_distribution_bank_payabale/' + department_name)
                .then(response => this.all_sals10 = response.data)
                .catch(error => {});
        },
        sumStats(num1, num2) {
            return parseInt(num1) + parseInt(num2);

        },

    },
    mounted() {

        axios.get('find_emp_id')
            .then(data => this.find_emp = data.data.data)
            .catch(error => {});
        axios.get('department_detail2')
            .then(data => this.adsdata = data.data)
            .catch(error => {});
axios.get('department_detail2')
            .then(data => this.adsdata11 = data.data)
            .catch(error => {});
        axios.get('overall_designation')
            .then(response => {
                this.designations = response.data;

            })
        axios.get('find_session')
            .then(response => {
                this.session_name = response.data;
            })




    },

}

</script>
