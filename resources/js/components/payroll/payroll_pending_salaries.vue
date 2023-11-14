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
                                    Pending Salaries
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
                                                <span class="fw-bold">Generated Salaries</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_hr_approval" class="nav-link">
                                                <i class="fa-solid fa-address-card"></i>
                                                <span class="fw-bold">HR Approval</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_finance_approval" class="nav-link">
                                                <i class="fa-solid fa-coins"></i>
                                                <span class="fw-bold">Finance Approval</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/distribution" class="nav-link">
                                                <i class="fa-solid fa-money-bill-wave"></i><span class="fw-bold">Distribution</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link active" to="/payroll/payroll_pending_salaries">
                                                <i class="fa-solid fa-rotate-left"></i><span class="fw-bold">Pending Salaries</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="basic-table">
                        <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                            <div class="card">
                                <div class="row" style="margin-top:2px">
                                    <div class="col-md-4 col-12 mb-2">
                                        <h5 style="padding-left:10px;padding-top:10px">Current Session: {{session_name}}</h5>
                                    </div>
                                    <div class="col-md-4 col-12 mb-2" style="margin-top:8px">
                                        <input type="text" v-model="keyword1" class="form-control" placeholder="Search By Emp. Name/Code/CNIC">

                                    </div>
                                    <div class="col-md-1 col-12 mb-2" style="margin-top:8px">
                                        <button @click="getResults()" class="btn btn-secondary">Search</button>
                                    </div>
                                    <div class="col-md-1 col-12 mb-2">
                                    </div>
                                    <div class="col-md-2 col-12 mb-2" style="margin-top:8px;">
                                        <a v-if="hasPermission('Payroll Download Salary Slip') " data-bs-target="#payloan2" data-bs-toggle="modal" class="btn btn-primary"><i class="fa-solid fa-download"></i> Download Slip<span></span></a>
                                    </div>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="sticky-th-center">Emp. Code</th>
                                                <th class="sticky-th-center">Employee Name</th>
                                                <th class="sticky-th-center">Session</th>
                                                <th class="sticky-th-center">Basic Sal.<br>Allow.</th>
                                                <th class="sticky-th-center">Ded.<br>OT</th>
                                                <th class="sticky-th-center">Loan</th>
                                                <th class="sticky-th-center">Fine + Dues<br>Arr. + Bon.</th>
                                                <th class="sticky-th-center">Payable</th>
                                                <th class="sticky-th-center">Remaining</th>
                                                <th class="sticky-th-center" colspan="2">Status & Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in all_sals.data" :key="all_sals1">
                                                <td class="td-center">{{all_sals1.EmpCode}}</td>
                                                <td class="td-left" style="max-width: 225px;">
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
                                                <td class="td-center">{{all_sals1.SessionName}}</td>
                                                <td class="td-center">{{all_sals1.Salary}}<br>{{all_sals1.AllowanceAmount}}</td>
                                                <td class="td-center">{{Math.round(all_sals1.DAmount)}}<br>{{Math.round(all_sals1.OAmount)}}</td>
                                                <td class="td-center">{{all_sals1.InstallmentAmount}}</td>
                                                <td class="td-center">{{ sumStats(all_sals1.Fine, all_sals1.DuesAmount) }} <br>
                                                    {{ sumStats(all_sals1.ArrearsAmount, all_sals1.BonusAmount) }}
                                                </td>
                                                <td class="td-center">{{all_sals1.PayableSalary}}</td>
                                                <td class="td-center">{{Number(all_sals1.RemainingAmount)}}</td>
                                                <td class="td-center">
                                                    Rs.{{ sumStats(all_sals1.ArrearsAmount, all_sals1.BonusAmount) }}
                                                </td>
                                                <td class="td-center">Rs. {{all_sals1.AllowanceAmount}} </td>
                                                <td class="td-center">Rs. {{all_sals1.PayableSalary}}</td>
                                                <td class="td-center">Rs. {{Number(all_sals1.RemainingAmount)}}</td>
                                                <td v-if="hasPermission('Payroll Change Status/Pay Salary') && all_sals1.ReceivedThrough==null" class="td-center">
                                                    <a @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmployeeID,all_sals1.EmpCode,all_sals1.SessionName)" data-bs-toggle="modal" data-bs-target="#editpayroll">
                                                        <span class="badge badge-glow bg-info">Not Received</span>
                                                    </a>
                                                </td>
                                                <td v-else-if="hasPermission('Payroll Change Status/Pay Salary') && all_sals1.SalaryStatus=='Partially Received'" @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmployeeID,all_sals1.EmpCode,all_sals1.SessionName)" data-bs-toggle="modal" data-bs-target="#editpayroll" class="td-center">
                                                    <span class="badge badge-glow bg-warning">Partially Received</span>
                                                </td>
                                                <td v-else class="td-center">
                                                    <span class="badge badge-glow bg-success">Fully Received</span>
                                                    <span v-if="all_sals1.SalaryStatus=='Not Received'" @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmployeeID,all_sals1.EmpCode,all_sals1.SessionName)" data-bs-toggle="modal" data-bs-target="#editpayroll">
                                                        <span class="badge badge-glow bg-info">Not Received</span>
                                                    </span>
                                                    <span v-else-if="all_sals1.SalaryStatus=='Partially Received'" @click="fetch_stipend_detail(all_sals1.DistributionID,all_sals1.Name,all_sals1.RemainingAmount,all_sals1.Department,all_sals1.EmployeeID,all_sals1.EmpCode,all_sals1.SessionName)" data-bs-toggle="modal" data-bs-target="#editpayroll" class="badge badge-glow bg-warning">Partially Rec.</span>
                                                    <span v-else class="badge bg-danger">{{ all_sals1.SalaryStatus}}</span>
                                                </td>
                                                <td class="td-center">
                                                    <a v-if="hasPermission('Payroll View Salary Slip')" data-bs-target="#viewcandidate" @click="fetch_emp_payroll(all_sals1.DistributionID)" data-bs-toggle="modal"><i style="color:#0d6efd" class="fa-solid fa-eye"></i><span></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div style="text-align:center; padding-top:20px">
                                        <pagination :limit="limit" :data="all_sals" @pagination-change-page="getResults"></pagination>
                                    </div>
                                </div>
                                </div>
                            </div>
                    </div>
                    <!-- modal table -->

                    <div class="modal fade" id="payloan2" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Download Salary Slip</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                    <div class="col-md-12">
                                        <label class="form-label mx-5" for="modalAddCardName">Select Session:</label>
                                        <multiselect class="mx-5" style="margin-right: 10px;" v-model="session_name1" :options="options1" @input="getEmpCode()"> </multiselect>
                                        <span style="color: #db4437; font-size: 11px" v-if="session_name1== ''">{{ e_session_name1 }}</span>
                                    </div>
                                </div>
                                <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                    <div class="col-md-12">
                                        <label class="form-label mx-5" for="modalAddCardName">Employee Name</label>
                                        <multiselect class="mx-5" style="margin-right: 10px;" value="id" label="label" v-model="emp_sal_code" :options="options2" @input="getEmpDetail()"> </multiselect>
                                        <span style="color: #db4437; font-size: 11px" v-if="emp_sal_code== ''">{{ e_emp_sal_code }}</span>
                                    </div>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                            <div class="col-12 text-center">
                                                <a v-if="emp_sal_code=='' || emp_sal_code==null" class="btn btn-danger me-1 mt-2">Download Slip</a>
                                                <a v-else class="btn btn-primary me-1 mt-2" target="_blank" v-bind:href="`../${url_s1[3]}/generate_slip1/${emp_sal_empid}/${emp_sal_distid}/${emp_sal_code.id}/${session_name1}`">Download Slip</a>
                                            </div>
                                    </div>
                                </div>
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
                                                            <span class="fw-bolder me-25">Salary Month</span>
                                                        </td>
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
                                                            <span class="fw-bolder me-25">Department</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            {{view_employee_slip1.Department}}
                                                        </td>
                                                        <td class="col-md-3" style="padding-left:30px">
                                                            <span class="fw-bolder me-25">Stipend</span>
                                                        </td>
                                                        <td class="col-md-3">
                                                            Rs. {{view_employee_slip1.StipendAmount.toLocaleString()}}/-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Posting City</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            {{view_employee_slip1.PostingCity}}
                                                        </td>
                                                        <td class="col-md-3" style="background: lightgray;padding-left:30px" colspan="2">
                                                            <span class="fw-bolder me-25" style="">Arrears And Allowance</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Date Of Birth</span>
                                                        </td>
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
                                                            <span class="fw-bolder me-25">Employee Code</span>
                                                        </td>
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
                                                            <span class="fw-bolder me-25">CNIC</span>
                                                        </td>
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
                                                            <span class="fw-bolder me-25">Phone No</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            {{view_employee_slip1.Mobile}}
                                                        </td>
                                                        <td class="col-md-3" style="padding-left:30px">
                                                            <span class="fw-bolder me-25">Allowance</span>
                                                        </td>
                                                        <td class="col-md-3" style="text-align: right;">
                                                            Rs. {{sumStats(view_employee_slip1.AllowanceAmount, view_employee_slip1.FuelAmount)}}/-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Prepared By</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            HR Department
                                                        </td>
                                                        <td class="col-md-3" style="background: lightgray;padding-left:30px" colspan="2">
                                                            <span class="fw-bolder me-25" style="">Deduction & Loans</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Job Status</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            {{view_employee_slip1.JobStatus}}
                                                        </td>
                                                        <td class="col-md-3" style="padding-left:30px">
                                                            <span class="fw-bolder me-25">Installment {{view_employee_slip1.InstallmentNo}}</span>
                                                        </td>
                                                        <td class="col-md-3" style="text-align: right;">
                                                            Rs. {{sumStats(view_employee_slip1.InstallmentAmount, view_employee_slip1.AdvanceAmount)}}/-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Date Of Joining</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            {{view_employee_slip1.JoiningDate}}
                                                        </td>
                                                        <td class="col-md-3" style="padding-left:30px">
                                                            <span class="fw-bolder me-25">Fine & Tax</span>
                                                        </td>
                                                        <td class="col-md-3" style="text-align: right;">
                                                            Rs. {{sumStats(view_employee_slip1.Fine, view_employee_slip1.TaxAmount)}}/-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Payment Method</span>
                                                        </td>
                                                        <td class="col-md-3" style="border-right: 1px solid lightgray;">
                                                            {{view_employee_slip1.MethodType}}
                                                        </td>
                                                        <td class="col-md-3" style="padding-left:30px">
                                                            <span class="fw-bolder me-25">Dues</span>
                                                        </td>
                                                        <td class="col-md-3" style="text-align: right;">
                                                            Rs. {{sumStats(view_employee_slip1.DuesAmount, view_employee_slip1.FuelReceivable)}}/-
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <span class="fw-bolder me-25">Address</span>
                                                        </td>
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
                                                            <th style="padding-top:5px;padding-bottom:5px;font-size:16px;color:red" scope="col" class="ng-star-inserted">Net Payable:</th>
                                                            <th style="text-align:right;padding-top:5px;padding-bottom:5px;font-size:16px;color:red" scope="col"> Rs. {{view_employee_slip1.PayableSalary}}/-</th>
                                                            <th scope="col">Bank: Rs. {{view_employee_slip1.BankAmount}}/-</th>
                                                            <th scope="col">Cash: Rs. {{view_employee_slip1.CashAmount}}/-</th>
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
                                    <h5>Pay salary to employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-8">
                                            <label class="form-label" for="modalAddCardNumber">Employee Name</label>
                                            <input v-model="emp_name" type="text" readonly class="form-control" />
                                            <input v-model="dist_id" type="text" readonly hidden class="form-control" />
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label" for="modalAddCardNumber">Total Remaining Salary</label>
                                            <input v-model="emp_payable" type="number" readonly class="form-control" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="modalAddCardName">Cash Ledger</label>

                                            <input type="text" readonly v-model="cash_type" class="form-control">
                                            <span style="color: #db4437; font-size: 11px" v-if="cash_type== ''">{{ e_cash_type }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="modalAddCardName">Cash Amount</label>
                                            <input v-model="cash_amount" type="number" class="form-control" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="modalAddCardName">Bank Ledger</label>
                                            <multiselect style="margin-right: 10px;" v-model="bank_type" :options="options"> </multiselect>
                                            <span style="color: #db4437; font-size: 11px" v-if="bank_type== ''">{{ e_bank_type }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="modalAddCardName">Bank Amount</label>
                                            <input v-model="bank_amount" type="number" class="form-control" />
                                        </div>
                                        <div class="col-12 text-center">
                                            <button v-if="(Number(cash_amount) > 0 || Number(bank_amount) > 0) && ((Number(cash_amount) + Number(bank_amount)) <= Number(emp_payable))" type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Pay Salary</button>
                                            <button v-else type="submit" :disabled="disabled1" class="btn btn-danger me-1 mt-1">Pay Salary</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </form>
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
    import axios from "axios";
    import Multiselect from 'vue-multiselect'
    export default {
        components: {
            Multiselect,
        },
        data() {
            return {
                limit: 10,
                url: process.env.MIX_APP_URL,
                url_s1: '',
                url_s2: '',
                session_name: '',
                m_salarypayable: '',
                m_bankpayable: '',
                m_cashpayable: '',
                dist_id: '',
                cash_type: "101001001001_Cash in Hand",
                e_cash_type: '',
                emp_name: '',
                emp_payable: '',
                dept_nam: '',
                cash_amount: 0,
                bank_amount: 0,
                all_sals: {},
                find_emp: {},
                designations: {},
                departments: {},
                emp_id: 'All',
                designation: 'All',
                department: 'All',
                status: 'All',
                keyword1: '',
                session_name1: '',
                e_session_name1: '',
                view_employee_slip: {},
                m_emp_id: '',
                m_name: '',
                methods1: {},
                disabled1: false,
                pen_emp_id: '',
                pen_Emp_code: '',
                pen_Emp_session: '',
                bank_type: '',
                e_bank_type: '',
                m_emp_code: '',
                m_ApprovalID: '',
                m_salary_status: '',
                options: [],
                options1: [],
                options2: [],
                emp_sal_code: '',
                e_emp_sal_code: '',
                emp_sal_distid: '',
                emp_sal_empid: '',
                session_list: {},
                session_list1: {},
            }
        },
        methods: {
            get_ip() {
                this.url_s1 = this.url.split('/');
                this.url_s2 = this.url_s1[0] + '//' + this.url_s1[2] + '/' + this.url_s1[3];
            },
            getEmpCode() {
                axios.get('accounts/fetch_distpending_salaries1/' + this.session_name1)
                    .then(response => {
                        this.session_list1 = response.data
                        this.options2 = [];
                        this.options2 = this.session_list1.map((emp) => ({
                            id: emp.EmpCode,
                            label: `${emp.Name}` + '_' + `${emp.EmpCode}`,
                        }));
                    })
            },
            getEmpDetail() {
                axios.get('accounts/fetch_distpending_salaries2/' + this.emp_sal_code.id + '/' + this.session_name1)
                    .then(response => {
                        this.emp_sal_distid = response.data[0].DistributionID
                        this.emp_sal_empid = response.data[0].EmployeeID
                    })
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.updatesalarystatus()
            },
            updatesalarystatus() {
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
                        if (data.data == 'submitted') {
                            this.$toastr.s("Paid Salary Successfully!", "Congratulations");
                            window.open(this.url + "/generate_slip1/" + this.pen_emp_id + "/" + this.dist_id + "/" + this.pen_Emp_code + '/' + this.pen_Emp_session, '_blank');

                            this.getResult(this.dept_nam);
                            this.dist_id = '';

                            this.emp_name = '';
                            this.emp_payable = '';
                            this.cash_type = this.cash_type;
                            this.cash_amount = '0';
                            this.bank_amount = '0';
                            this.bank_type = '';

                        }
                        else if (data.data == 'error') {
                            this.$toastr.e("Your Amount Does Not Match with Payable Salary!", "Cautions");
                        } else if (data.data == 'Salary Not Found') {
                            this.$toastr.e("Salary Detail Not found", "Cautions");

                        }
                        else if (data.data == 'Not Suficient Balance') {
                            this.$toastr.e("Not Suficient Balance", "Cautions");
                        }
                        else if (data.data == 'Remaining Payable is Incorrect') {
                                this.$toastr.e("Remaining Payable is Incorrect!", "Cautions");
                            }
                        else if (data.data == 'Salary Not Found') {
                                this.$toastr.e("Salary Detail Not found", "Cautions");
                            }
                        else if (data.data == 'error2') {
                            this.$toastr.e("Bank Detail Invalid!", "Cautions");
                        }
                    })
            },
            fetch_emp_payroll(id) {
                axios.get('view_emp_salary_slip/' + id)
                    .then(response => this.view_employee_slip = response.data)
                    .catch(error => { });
            },
            fetch_stipend_detail(stipend, emp_nam, emp_payable, dept, id, code, session) {
                this.dist_id = stipend;
                this.emp_name = emp_nam;
                this.emp_payable = Number(emp_payable);
                this.cash_amount = Number(emp_payable);

                this.dept_nam = dept;
                this.pen_emp_id = id
                this.pen_Emp_code = code
                this.pen_Emp_session = session
            },
            update_emp_payroll() {
                if (Number(this.m_bankpayable) + Number(this.m_cashpayable) != Number(this.m_salarypayable)) {
                    this.$toastr.e("Payables are not matching with total payable salary", "Error");
                }
                else {
                    axios.post('update_payroll_ind_status_financeapproval', {
                        m_ApprovalID: this.m_ApprovalID,
                        m_salary_status: this.m_salary_status,
                        m_name: this.m_name,
                        m_bankpayable: this.m_bankpayable,
                        m_cashpayable: this.m_cashpayable,
                    })
                        .then(data => {
                            this.getResults();
                            this.$toastr.s("Updated Employee Salary Detail Successfully!", "Congratulations");
                        })
                }
            },
            sumStats(num1, num2) {
                return parseInt(num1) + parseInt(num2);
            },
            getResults(page = 1) {
                axios.get('./pendingdist_byName?page=' + page, { params: { keyword1: this.keyword1 } })
                    .then(response => {
                        this.all_sals = response.data;
                    })
                    .catch(error => console.log(error));
            },
        },
        mounted() {
            this.getResults();
            this.get_ip();

            axios.get('find_emp_id')
                .then(data => this.find_emp = data.data.data)
                .catch(error => { });

            axios.get('department_detail2')
                .then(data => this.departments = data.data)
                .catch(error => { });

            axios.get('overall_designation')
                .then(response => {
                    this.designations = response.data;
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

            axios.get('accounts/fetch_distpending_salaries')
                .then(response => {
                    this.session_list = response.data
                    this.options1 = [];

                    var $this = this;
                    for (var j = 0; j < $this.session_list.length; j++) {
                        this.options1.push($this.session_list[j].SessionName);
                    }
                })
            axios.get('find_session')
                .then(response => {
                    this.session_name = response.data;
                })

          
        },

    }

</script>
