<template>
    <div>
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Loans & Advances
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- Full calendar start -->
                <section>
                    <div class="row g-0">
                        <!-- Calendar -->
                        <div class="col position-relative">
                            <div class="card shadow-none border-0 mb-0 rounded-0">
                                <div class="card-body pb-0">
                                    <!-- Hoverable rows start -->
                                    <div class="row" id="table-hover-row">
                                        <div class="col-12">
                                            <div class="col-12">
                                                <div class="card-body border-bottom">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="form-label">From date</label>
                                                            <input type="date" id="datepicker" v-model="from_date" class="form-control" placeholder="Name" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">End date</label>
                                                            <input type="date" v-model="to_date" class="form-control" placeholder="Name" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Department</label>
                                                            <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction" placeholder="All Departments" :show-labels="false" v-model="department" :options="options2">
                                                            </multiselect>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Designation</label>
                                                            <multiselect style="margin-right: 10px;" :show-labels="false" v-model="designation" :options="options">
                                                            </multiselect>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Name or id</label>
                                                            <input type="text" v-model="search_name" class="form-control" placeholder="Name" />
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div style="height:27px;"></div>
                                                            <button @click="getbyfilter()" class="btn btn-primary" tabindex="0" type="button"><span>Search</span></button>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <a title="Click to see extra search filters" v-b-toggle.my-collapse>
                                                                <i aria-hidden="true" class="fa-solid fa-up-right-and-down-left-from-center" style="margin-top:30px"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <b-collapse id="my-collapse">
                                                        <div style="min-height: 80px;" class="advanced">
                                                            <div class="container">
                                                                <div class="row" style=" display: block; padding-top:10px;padding-bottom:10px">
                                                                    <div class="col-md-4" style="float:left">
                                                                        <label class="form-label">Filter by</label>
                                                                        <multiselect style="margin-right: 10px;" @input="view_loans()" v-model="m_check" :show-labels="false" placeholder="Dept. & HR Manager" :options="options3">
                                                                        </multiselect>
                                                                    </div>
                                                                    <div class="col-md-2" style="float:left">
                                                                        <div class="form-check form-check-success mb-1" style="margin-top: 14px;">
                                                                            <input type="checkbox" @change="view_loans()" v-model="check_approved" id="holiday" class="form-check-input input-filter" />
                                                                            <label class="form-check-label" for="holiday">Approved</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2" style="float:left">
                                                                        <div class="form-check form-check-warning mb-1" style="margin-top: 14px;">
                                                                            <input type="checkbox" @change="view_loans()" v-model="check_pending" id="family" class="form-check-input input-filter" />
                                                                            <label class="form-check-label" for="family">Pending</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1" style="float:left">
                                                                        <div class="form-check form-check-danger mb-1" style="margin-top: 14px;">
                                                                            <input type="checkbox" @change="view_loans()" v-model="check_rejected" id="personal" class="form-check-input input-filter" />
                                                                            <label class="form-check-label" for="personal">Rejected</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1" style="float:left">
                                                                    </div>
                                                                    <div class="col-md-2" style="float:left">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </b-collapse>
                                                </div>
                                                <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                                    <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                                        <div class="dt-action-buttons justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <button v-if="hasPermission('Payroll Apply for loan')" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emploan">
                                                                        + Apply for loan
                                                                    </button>
                                                                    <button v-else class="btn btn-danger" >
                                                                        + Apply for loan
                                                                    </button>
                                                                </div>
<!--                                                                <div class="col-md-2">-->
<!--                                                                    <router-link to="/payroll/dues" class="btn btn-primary">-->
<!--                                                                        Dues Detail-->
<!--                                                                    </router-link>-->
<!--                                                                </div>-->
                                                                <div class="col-md-10">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="sticky-th-center">Emp. Code<br />Loan ID</th>
                                                                <th class="sticky-th-center" style="min-width: 217px;">Employee Name</th>
                                                                <th class="sticky-th-center">Created at</th>
                                                                <th class="sticky-th-center">Manager<br />Approval</th>
                                                                <th class="sticky-th-center">HR<br />Approval</th>
                                                                <th class="sticky-th-center">Inst.</th>
                                                                <th class="sticky-th-center">Total<br />Amount</th>
                                                                <th class="sticky-th-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr :class="[loans1.ReqStatus=='Pending' ? 'table-warning' : '', loans1.ReqStatus=='Rejected' ? 'table-danger' : '', loans1.ReqStatus=='Approved' ? 'table-success' : '']" :title="[loans1.ReqStatus=='Approved' ? 'This '+loans1.LoanType+' is ready to pay' : '']" v-for="loans1 in loans.data" :key="loans1.LoanId" :id="'headingBorder'+loans1.LoanId">
                                                                <td colspan="8" style="vertical-align:middle !important">
                                                                    <div>
                                                                        <div class="accordion-header d-flex">
                                                                            <div class="col-md-1" style="text-align:center;">
                                                                                <div class="d-flex justify-content-left align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{loans1.EmployeeCode}} </span></a>
                                                                                        <small class="emp_post text-muted">
                                                                                            <span>{{loans1.LoanId}}</span>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4" style="text-align:left;">
                                                                                <div @click="fetch_emp_upSts(loans1.LoanId)" class="d-flex justify-content-left align-items-center">
                                                                                    <div class="d-flex flex-column">
                                                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{loans1.Name}} </span></a>
                                                                                        <small class="emp_post text-muted">
                                                                                            <span>{{loans1.Department}}-{{loans1.Designation}}</span>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-1" style="text-align:center;">{{loans1.ApplyDate}} </div>
                                                                            <div class="col-md-2" style="text-align:center;">
                                                                                <span class="badge bg-gradient-warning" @click="fetch_emp_upSts(loans1.LoanId, 'man')" v-if="loans1.ManagerApproval=='Pen'" data-bs-toggle="modal" data-bs-target="#updateloanstatus">Pending</span>
                                                                                <span class="badge bg-gradient-success" v-if="loans1.ManagerApproval=='App'">Approved</span>
                                                                                <span class="badge bg-gradient-danger" v-if="loans1.ManagerApproval=='Rej'">Rejected</span>
                                                                            </div>
                                                                            <div class="col-md-1" style="text-align:center;">
                                                                                <span @click="fetch_emp_upSts(loans1.LoanId, 'hr')" data-bs-toggle="modal" data-bs-target="#updateloanstatus" class="badge bg-gradient-warning" v-if="loans1.HrApproval=='Pen'">Pending</span>
                                                                                <span class="badge bg-gradient-success" v-if="loans1.HrApproval=='App'">Approved</span>
                                                                                <span class="badge bg-gradient-danger" v-if="loans1.HrApproval=='Rej'">Rejected</span>
                                                                            </div>
                                                                            <div class="col-md-1" style="text-align:center;">{{loans1.LoanInstallments}}</div>
                                                                            <div class="col-md-1" style="text-align:center;">
                                                                                {{Math.floor(loans1.LoanAmount).toLocaleString()}}/-
                                                                            </div>
                                                                            <div  class="col-md-1" style="text-align:center;">
                                                                                <div class="btn-group">
                                                                                    <button class="collapsed" v-if="loans1.ReqStatus == 'Paid' || loans1.ReqStatus == 'Returned'" style="border: none;" @click="installmentDetails(loans1.LoanId)" type="button" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder'+loans1.LoanId" aria-expanded="false" :aria-controls="'accordionBorder'+loans1.LoanId">
                                                                                        <i class="fa-solid fa-circle-plus"></i>
                                                                                    </button>
                                                                                    <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow">
                                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                                    </a>
                                                                                    <div v-if="hasPermission('Payroll Actions for loan')" class="dropdown-menu dropdown-menu-end">
                                                                                        <a @click="fetch_emp_upSts(loans1.LoanId)" data-bs-toggle="modal" data-bs-target="#viewLoan" class="dropdown-item">
                                                                                            <i class="fa-solid fa-eye"></i>
                                                                                            View details
                                                                                        </a>
                                                                                        <a v-if="loans1.ReqStatus == 'Pending'" @click="fetch_emp_upSts(loans1.LoanId); get_emp_id(loans1.EmployeeID)" data-bs-toggle="modal" data-bs-target="#updateloan" class="dropdown-item">
                                                                                            <i class="fa-solid fa-pencil-square-o"></i>
                                                                                            Edit details
                                                                                        </a>
                                                                                        <a target="_blank" v-bind:href="`employee_loan/${loans1.LoanId}`" v-if="loans1.LoanType == 'Loan' && (loans1.ReqStatus == 'Paid' || loans1.ReqStatus == 'Returned')" class="dropdown-item">
                                                                                            <i class="fa-solid fa-print"></i>
                                                                                            Loan Slip
                                                                                        </a>
                                                                                        <a target="_blank" v-bind:href="`employee_loan1/${loans1.LoanId}`" v-if="loans1.LoanType == 'Advance' && (loans1.ReqStatus == 'Paid' || loans1.ReqStatus == 'Returned')" class="dropdown-item">
                                                                                            <i class="fa-solid fa-print"></i>
                                                                                            Advance Slip
                                                                                        </a>
                                                                                        <a @click="fetch_emp_upSts(loans1.LoanId)" data-bs-toggle="modal" data-bs-target="#payloan" class="dropdown-item" v-if="loans1.ReqStatus == 'Approved'">
                                                                                            <i class="fa-brands fa-amazon-pay"></i>
                                                                                            Pay
                                                                                        </a>
                                                                                        <a target="_blank" v-if="loans1.ReqStatus == 'Paid' || loans1.ReqStatus == 'Returned'" v-bind:href="`loan_report/${loans1.LoanId}`" class="btn btn-sm">
                                                                                            <i class="fa-solid fa-print"></i>Installments
                                                                                        </a>
                                                                                        <a @click="fetch_emp_upSts(loans1.LoanId)" class="dropdown-item" v-if="loans1.ReqStatus == 'Paid'" data-bs-toggle="modal" data-bs-target="#returnLoan">
                                                                                            <i class="fa-solid fa-right-left"></i>
                                                                                            Return loan
                                                                                        </a>
                                                                                        <a class="dropdown-item" @click="getid(loans1.LoanId)" data-bs-toggle="modal" data-bs-target="#delete_loan" v-if="loans1.ReqStatus == 'Pending'">
                                                                                            <i class="fa-regular fa-trash-can"></i>
                                                                                            Delete
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div :id="'accordionBorder'+loans1.LoanId" class="accordion-collapse collapse" :aria-labelledby="'headingBorder'+loans1.LoanId" :data-bs-parent="'#accordionBorder'+loans1.LoanId">
                                                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                                                <table class="table table-hover">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="sticky-th-center">Inst.<br />No</th>
                                                                                            <th class="sticky-th-center">Installment<br />Session</th>
                                                                                            <th class="sticky-th-center">Installment<br />Amount</th>
                                                                                            <th class="sticky-th-center">Installment<br />Status</th>
                                                                                            <th class="sticky-th-center">Actions</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr v-for="(get_reqdata11, index) in install_list" :class="[get_reqdata11.InstallmentStatus=='waivedoff' ? 'table-primary' : '', get_reqdata11.InstallmentStatus=='Skipped' ? 'table-secondary' : '']">
                                                                                            <td class="td-center">
                                                                                                <p class="card-text mb-25">{{index+1}}</p>
                                                                                            </td>
                                                                                            <td class="td-center">
                                                                                                <span>{{get_reqdata11.InstallmentSession}}</span>
                                                                                            </td>
                                                                                            <td class="td-center">
                                                                                                <span>{{Math.floor(get_reqdata11.InstallmentAmount).toLocaleString()}}/-</span>
                                                                                            </td>
                                                                                            <td class="td-center">
                                                                                                <span v-if="get_reqdata11.InstallmentStatus=='Unpaid'" class="badge bg-gradient-warning">Unpaid</span>
                                                                                                <span v-else-if="get_reqdata11.InstallmentStatus=='waivedoff'" class="badge bg-gradient-primary">Waived Off</span>
                                                                                                <span v-else-if="get_reqdata11.InstallmentStatus=='Returned'" class="badge bg-gradient-danger">Returned</span>
                                                                                                <span v-else-if="get_reqdata11.InstallmentStatus=='Skipped'" class="badge bg-gradient-secondary">Skipped</span>
                                                                                            </td>
                                                                                            <td v-if=" get_reqdata11.InstallmentStatus=='Unpaid'" class="td-center">
                                                                                                <div class="btn-group">
                                                                                                    <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow">
                                                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                                                    </a>
                                                                                                    <div v-if="hasPermission('Payroll Actions for installment')" class="dropdown-menu dropdown-menu-end">
                                                                                                        <a @click="get_loanid(get_reqdata11.LoanId,get_reqdata11.DetailId)" data-bs-toggle="modal" data-bs-target="#payloan1" class="dropdown-item">
                                                                                                            <i class="fa-solid fa-ship"></i>
                                                                                                            Skip Installment
                                                                                                        </a>
                                                                                                        <a @click="get_loanid(get_reqdata11.LoanId,get_reqdata11.DetailId)" data-bs-toggle="modal" data-bs-target="#payloan2" class="dropdown-item">
                                                                                                            <i class="fa-solid fa-file-waveform"></i>
                                                                                                            Waive off Installment
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td v-else class="td-center"></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="display: flex;">
                                                        <pagination :data="loans" :limit="limit" @pagination-change-page="view_loans"></pagination>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hoverable rows end -->
                                </div>
                            </div>
                        </div>
                        <!-- /Calendar -->
                        <div class="body-content-overlay"></div>
                    </div>
                </section>
                <!-- Full calendar end -->
                <div class="modal fade" id="delete_loan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        np
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="fw-bolder">Confirmation</h1>
                                    <h5>Do you want to delete the loan?</h5>
                                    <div class="text-center">
                                        <button type="button" @click="delete_loan(d_loanid)" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                        <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--Apply loan model-->
                <div class="modal fade" id="emploan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-3 mx-50">
                                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Apply for Loan or Advance</h1>
                                <p class="address-subtitle text-center mb-2 pb-75">Input Details</p>
                                <form style="text-align:left;" class="row gy-1 gx-2" onsubmit="return false">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Employee code - Name</label>
                                        <span style="color: #DB4437; font-size: 11px;">*</span>
                                        <multiselect :show-labels="false" @input="find_id(emp_name)" style="margin-right: 10px; font-size: 12px;" placeholder="Select Employee" v-model="emp_name" :options="options6"></multiselect>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="emp_name=='' || emp_name==null">{{e_emp_name}}</span>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Stipend</label>
                                        <input type="text" class="form-control" disabled v-model="stipend" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Basic Salary</label>
                                        <input type="text" class="form-control" disabled v-model="salary" />
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <label class="form-label">Deductions</label>
                                        <input type="text" class="form-control" disabled :value="Number(tax) + Number(installment)" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Maximum Limit</label>
                                        <input type="text" class="form-control" disabled v-model="max_advance" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Select Type</label>
                                        <span style="color: #DB4437; font-size: 11px;">*</span>
                                        <multiselect style="margin-right: 10px;" @input="fetch_emp_detail()" v-model="type" :show-labels="false" placeholder="Select" :options="options4"></multiselect>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="type=='Select'">{{type_error}}</span>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Amount</label>
                                        <span style="color: #DB4437; font-size: 11px;">*</span>
                                        <input type="number" class="form-control" v-model="amount" placeholder="Amount" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="amount==''">{{amount_error}}</span>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="amount > max_advance">Amount is too much</span>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" v-if="type=='Loan'">Number of installments</label>
                                        <label class="form-label" v-else-if="type=='Advance'">For Month</label>
                                        <label class="form-label" v-else> First Select Type</label>
                                        <span v-if="type=='Loan'" style="color: #DB4437; font-size: 11px;">*</span>
                                        <select v-if="type=='Loan'" v-model="no_of_inst" class="form-select">
                                            <option value="0" selected>Select</option>
                                            <option :value="index" v-for="index in Number(config_ins)">{{index}}</option>
                                        </select>
                                        <select v-else-if="type=='Advance'" disabled class="form-select" title="Advance Month">
                                            <option>{{session_name}}</option>
                                        </select>
                                        <select v-else disabled class="form-select" title="Advance Month">
                                            <option>First Select Type</option>
                                        </select>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="this.no_of_inst=='0' && type=='Loan'">{{installments_error}}</span>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <label class="form-label">Reason</label>
                                        <label class="form-label" v-if="type=='Loan'">of Loan</label>
                                        <label class="form-label" v-else-if="type=='Advance'">of Advance</label>
                                        <span style="color: #DB4437; font-size: 11px;"> *</span>
                                        <label v-if="type=='Loan' && no_of_inst>0 && amount > 0" style="float:right;">Each installments will be of Rs. <label>{{Math.round(amount/no_of_inst).toLocaleString()}}</label></label>
                                        <input type="text" class="form-control" v-model="reason" placeholder="Type reason here" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="this.reason==''">{{reason_error}}</span>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button v-if="(emp_name == '' || emp_name == null)|| amount == '' || amount > max_advance || type == 'Select' || type == null || reason == '' || (type == 'Loan' && no_of_inst == '0')" :disabled="disabled" @click="delay()" type="submit" class="btn btn-danger"> Apply<span v-if="type=='Loan'"> Loan</span><span v-else-if="type=='Advance'"> Advance</span></button>
                                        <button v-else :disabled="disabled" @click="delay()" type="submit" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Apply</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Apply loan model-->
                <!-- View loan Modal -->
                <div class="modal fade" id="viewLoan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <center>
                                        <div class="col-md-12">
                                            <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Return loan</h1>
                                            <p class="address-subtitle text-center mb-2 pb-75">Input Details</p>
                                            <form id="addNewAddressForm" style="text-align:left;" class="row gy-1 gx-2" onsubmit="return false">
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label">Employee Name</label>
                                                    <input type="text" disabled class="form-control" v-model="us_c_name" />
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <label class="form-label">Applied date</label>
                                                    <input type="date" disabled class="form-control" v-model="us_date" />
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <label class="form-label">Loan type</label>
                                                    <input type="text" disabled class="form-control" v-model="us_type" />
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <label class="form-label">Reason</label>
                                                    <input type="text" disabled class="form-control" v-model="us_reason" />
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <label class="form-label">Total Installments</label>
                                                    <input type="number" disabled class="form-control" v-model="us_installments" />
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <label class="form-label">Total amount</label>
                                                    <input type="text" disabled class="form-control" v-model="us_amount" />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                                Close
                                            </button>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ View loan Modal -->
                <!-- Update Loan status Modal -->
                <div class="modal fade" id="payloan2" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="col-md-11  mt-3 mx-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label for="note" class="form-label fw-bold">Remarks:</label>
                                            <textarea v-model="narration" class="form-control" rows="2" id="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <center>
                                        <div class="col-md-12">
                                            <h6>Are You Sure To Waive Off the Installment?</h6>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" @click="WaiveoffInstallment()" class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                                No
                                            </button>
                                        </div>
                                    </center>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="payloan1" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="col-md-11  mt-3 mx-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label for="note" class="form-label fw-bold">Remarks:</label>
                                            <textarea v-model="narration1" class="form-control" rows="2" id="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <center>
                                        <div class="col-md-12">
                                            <h6>Are You Sure To Skip the Installment?</h6>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" @click="SkipInstallment()" class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </center>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="updateloanstatus" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="mb-1">Update {{pay_type}} Status</h1>
                                </div>
                                <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Employee name</label>
                                        <input type="text" disabled class="form-control" v-model="us_c_name" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Loan applied</label>
                                        <input type="text" disabled class="form-control" v-model="us_amount" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Number of installments</label>
                                        <input type="text" disabled class="form-control" v-model="us_installments" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Type</label>
                                        <input type="text" disabled class="form-control" v-model="us_type" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Date Applied</label>
                                        <input type="text" disabled class="form-control" v-model="us_date" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Manager Status</label>
                                        <input type="text" disabled class="form-control" v-model="us_m_sts" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">HR Status</label>
                                        <input type="text" disabled class="form-control" v-model="us_hr_sts" />
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Reason</label>
                                        <textarea type="text" disabled class="form-control" v-model="us_reason"></textarea>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Update status</label>
                                        <select v-model="us_man_status" class="form-select">
                                            <option value="" selected>Select</option>
                                            <option value="App">Approve</option>
                                            <option value="Pen">Pending</option>
                                            <option value="Rej">Reject</option>
                                        </select>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="us_man_status==''">{{us_man_status_error}}</span>
                                    </div>
                                    <div class="col-12 text-center mt-2 pt-50">
                                        <button v-if="us_man_status == ''" type="button" :disabled="disabled1" @click="delay1()" class="btn btn-primary waves-effect waves-float waves-light">Update</button>
                                        <button v-else type="button" :disabled="disabled1" @click="delay1()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Update Loan status Modal -->
                <!-- Update Loan status Modal -->
                <div class="modal fade" id="updateloan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="mb-1">Update {{pay_type}}</h1>
                                </div>
                                <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Employee name</label>
                                        <input type="text" disabled class="form-control" v-model="us_c_name" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Type</label>
                                        <input type="text" disabled class="form-control" v-model="us_type" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Date Applied</label>
                                        <input type="text" disabled class="form-control" v-model="us_date" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Maximum Limit <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                        <input disabled type="number" class="form-control" v-model="max_advance" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">{{pay_type}} amount <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                        <input type="number" class="form-control" v-model="us_amount" />
                                        <span style="color: #DB4437; font-size: 11px;" v-if="us_amount==''">{{e_us_amount}}</span>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="us_amount > max_advance">Amount is too much</span>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Number of installments </label>
                                        <span v-if="pay_type=='Loan'" style="color: #DB4437; font-size: 11px;">*</span>
                                        <select v-if="pay_type=='Loan'" v-model="us_installments" class="form-select">
                                            <option value="0" selected>Select</option>
                                            <option :value="index" v-for="index in Number(config_ins)">{{index}}</option>
                                        </select>
                                        <select v-else disabled class="form-select" title="Advance installments could not be changed">
                                            <option>1</option>
<!--                                            great-->
                                        </select>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="us_installments=='0' && pay_type=='Loan'">{{installments_error}}</span>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label v-if="us_type=='Loan' && us_installments>0 && us_amount > 0" style="float:right;">Each installments will be of Rs. <label>{{Math.round(us_amount/us_installments).toLocaleString()}}</label></label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">Reason <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                        <textarea type="text" class="form-control" v-model="us_reason"></textarea>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="us_reason==''">{{e_us_reason}}</span>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">Manager Status</label>
                                        <input type="text" disabled class="form-control" v-model="us_m_sts" />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label">HR Status</label>
                                        <input type="text" disabled class="form-control" v-model="us_hr_sts" />
                                    </div>
                                    <div class="col-12 text-center mt-2 pt-50">
                                        <button v-if="(pay_type == 'Loan' && us_installments == '0') || us_reason=='' || us_amount=='' || us_amount > max_advance" type="button" :disabled="disabled3" @click="delay3()" class="btn btn-danger waves-effect waves-float waves-light">Update</button>
                                        <button v-else type="button" :disabled="disabled3" @click="delay3()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Update Loan status Modal -->
                <!-- Pay loan Modal -->
                <div class="modal fade" id="payloan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <center>
                                        <div class="col-md-12">
                                            <table style="width:100%;">
                                                <thead style="float:left; width:100%;" v-for="emp_loan1 in emp_loan">
                                                    <h2 style="text-align:center;">Pay {{emp_loan1.LoanType}} to employee</h2>
                                                    <tr>
                                                        <th style="width:18%;">Loan ID: </th>
                                                        <td style="width:25%;">{{emp_loan1.LoanId}}</td>
                                                        <th style="width:25%;">Application date: </th>
                                                        <td style="width:32%;">{{emp_loan1.ApplyDate}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Employee ID: </th>
                                                        <td>{{emp_loan1.EmployeeID}}</td>
                                                        <th>Applicant name: </th>
                                                        <td>{{emp_loan1.Name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Department: </th>
                                                        <td>{{emp_loan1.Department}}</td>
                                                        <th>Designation: </th>
                                                        <td>{{emp_loan1.Designation}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Amount: </th>
                                                        <td> {{Math.floor(emp_loan1.LoanAmount).toLocaleString()}}/-</td>
                                                        <th>Installments: </th>
                                                        <td> {{emp_loan1.LoanInstallments}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Reason: </th>
                                                        <td> {{emp_loan1.LoanReason}}</td>
                                                        <th>Received by: </th>
                                                        <td>{{emp_loan1.ReceivedBy}}</td>
                                                    </tr>
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Received by:  </strong><span style="color: #DB4437; font-size: 11px;">*</span>
                                                                <input type="text" class="form-control" v-model="rcvBy" placeholder="Name" />
                                                                <span style="color: #DB4437; font-size: 11px;" v-if="rcvBy==''">{{rcvBy_error}}</span>
                                                            </div>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>{{emp_loan1.LoanType !== 'Advance' ? 'Installment start from ' : 'For Month' }}</strong>
                                                                <select  class="form-select" v-if="emp_loan1.LoanType !== 'Advance'">
                                                                    <option  v-for="(sessions1, index) in sessions" :value="index">{{ sessions1 }}</option>
                                                                </select>
                                                                <select  class="form-select" readonly v-else>
                                                                    <option >{{ session_name }}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Cash Ledger</strong>
                                                                <input type="text" readonly v-model="cash_type" class="form-control">
                                                            </div>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Cash amount:  </strong>
                                                                <input readonly type="number" class="form-control" v-model="us_amount" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Bank Ledger</strong>
                                                                <multiselect dis style="margin-right: 10px;" v-model="bank_type" :options="options5"> </multiselect>
                                                            </div>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Bank Amount:  </strong>
                                                                <input v-model="bank_amount" type="text" class="form-control" @input="amount_filter()" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button v-if="rcvBy == ''" type="submit" :disabled="disabled2" @click="delay2()" class="btn btn-primary me-1 mt-2">Pay Loan Amount</button>
                                            <button v-else type="submit" :disabled="disabled2" @click="delay2()" class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" aria-label="Close">Pay Loan Amount</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Pay loan Modal -->
                <!-- Return loan Modal -->
                <div class="modal fade" id="returnLoan" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-sm-5 mx-50 pb-5">
                                <div class="text-center mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Return {{us_type}}</h1>
                                            <p class="address-subtitle text-center mb-2 pb-75">{{us_type}} Details</p>
                                            <form id="addNewAddressForm" style="text-align:left;" class="row gy-1 gx-2" onsubmit="return false">
                                                <div class="col-md-9">
                                                    <label class="form-label">Employee Name</label>
                                                    <input type="text" disabled class="form-control" v-model="us_c_name" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Type</label>
                                                    <input type="text" disabled class="form-control" v-model="us_type" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Applied date</label>
                                                    <input type="date" disabled class="form-control" v-model="us_date" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Total Installments</label>
                                                    <input type="number" disabled class="form-control" v-model="us_installments" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Total amount</label>
                                                    <input type="text" disabled class="form-control" v-model="us_amount" />
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Reason</label>
                                                    <textarea rows="3" type="text" disabled class="form-control" v-model="us_reason"></textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Return Amount</label>
                                                    <input type="text" class="form-control" v-model="return_amount" />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="return_amount == '0'">{{e_ret_installment}}</span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="accordion-body">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="py-1">Session</th>
                                                            <th class="py-1">Amount</th>
                                                            <th class="py-1">Return<br />Amount</th>
                                                            <th class="py-1">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(get_reqdata11,index) in install_list">
                                                            <td>{{get_reqdata11.InstallmentSession}}</td>
                                                            <td>{{Math.floor(get_reqdata11.InstallmentAmount).toLocaleString()}}/-</td>
                                                            <td v-if="get_reqdata11.InstallmentStatus=='Unpaid'">
                                                                <input class="form-check-input" type="checkbox" name="second[]" @change="sum_total()" id="inlineRadio1" />  Return
                                                                <input hidden type="text" :value="get_reqdata11.InstallmentAmount" name="ins_amt[]" class="form-control" />
                                                            </td>
                                                            <td v-else></td>
                                                            <td class="py-1">
                                                                <span v-if="get_reqdata11.InstallmentStatus=='Unpaid'" class="badge bg-gradient-warning">Unpaid</span>
                                                                <span v-else-if="get_reqdata11.InstallmentStatus=='waivedoff'" class="badge bg-gradient-success">Waived Off</span>
                                                                <span v-else-if="get_reqdata11.InstallmentStatus=='Returned'" class="badge bg-gradient-danger">Returned</span>
                                                                <span v-else-if="get_reqdata11.InstallmentStatus=='Skipped'" class="badge bg-gradient-secondary">Skipped</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button v-if="return_amount != '0'" type="submit" @click="return_loan(pay_loanID)" class="btn btn-primary">Return loan</button>
                                                <button v-else type="submit" @click="return_loan(pay_loanID)" class="btn btn-danger">Return loan</button>
                                                <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Return loan Modal -->
            </div>
        </div>
        <vue-html2pdf :show-layout="false"
                      :float-layout="true"
                      :enable-download="false"
                      :preview-modal="true"
                      :paginate-elements-by-height="1400"
                      filename="Ind_Employee_Attendance"
                      :pdf-quality="2"
                      :manual-pagination="false"
                      pdf-format="a4"
                      pdf-orientation="portrait"
                      pdf-content-width="800px"
                      @progress="onProgress($event)"
                      @hasStartedGeneration="hasStartedGeneration()"
                      @hasGenerated="hasGenerated($event)"
                      ref="htmlloanPdf">
            <div slot="pdf-content">
                <div class="modal-header d-flex justify-content-between">
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table style="width:100%;">
                            <thead style="float:left; width:100%;" v-for="emp_loan1 in emp_loan">
                                <h2 style="text-align:center;"> Slip of {{emp_loan1.LoanType}}</h2>
                                <tr>
                                    <th style="width:18%;">Loan ID: </th>
                                    <td style="width:25%;">{{emp_loan1.LoanId}}</td>
                                    <th style="width:25%;">Application date: </th>
                                    <td style="width:32%;">{{emp_loan1.ApplyDate}}</td>
                                </tr>
                                <tr>
                                    <th>Employee ID: </th>
                                    <td>{{emp_loan1.EmployeeID}}</td>
                                    <th>Applicant name: </th>
                                    <td>{{emp_loan1.Name}}</td>
                                </tr>
                                <tr>
                                    <th>Department: </th>
                                    <td>{{emp_loan1.Department}}</td>
                                    <th>Designation: </th>
                                    <td>{{emp_loan1.Designation}}</td>
                                </tr>
                                <tr>
                                    <th>Amount: </th>
                                    <td> {{Math.floor(emp_loan1.LoanAmount).toLocaleString()}}/-</td>
                                    <th>Installments: </th>
                                    <td> {{emp_loan1.LoanInstallments}}</td>
                                </tr>
                                <tr>
                                    <th>Reason: </th>
                                    <td> {{emp_loan1.LoanReason}}</td>
                                    <th>Received by: </th>
                                    <td>{{emp_loan1.ReceivedBy}}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </vue-html2pdf>
    </div>
</template>
<script>
    import axios from 'axios';
    import VueHtml2pdf from 'vue-html2pdf'
    import Multiselect from 'vue-multiselect';
    export default {
        data() {
            return {
                sessions: [],
                session_name: '',
                e_us_amount: '',
                e_us_reason: '',
                find_emp: {},
                emp_name: '',
                e_emp_name: '',
                cash_type: "101001001001_Cash in Hand",
                bank_type: '',
                bank_amount: 0,
                fix_amount: 0,
                methods1: {},

                d_loanid: '',
                emp_loan: {},
                config_loan: 0,
                config_ins: 0,
                installment_id: '',
                loan_skipid: '',
                search_name: '',
                search_name1: '',
                from_date: '2019-07-18',
                to_date: new Date().toJSON().slice(0, 10),
                from_date1: '',
                to_date1: '',
                department: 'All',
                designation: 'All',
                options: [],
                options1: [],
                options2: [],
                options3: ["Dept. & HR Manager", "Dept. Manager", "HR Manager"],
                options4: ["Select", "Advance", "Loan"],
                options5: [],
                options6: [],

                name: '',
                emp_id1: '',
                narration: '',
                narration1: '',
                salary: '',
                max_advance: '0',
                amount: '',
                type: "Select",
                reason: '',
                no_of_inst: '0',
                installmentPrice: '',

                check_approved: true,
                check_pending: true,
                check_rejected: false,
                m_check: "Dept. & HR Manager",
                amount_error: '',
                type_error: '',
                reason_error: '',
                installments_error: '',

                check: '',
                limit: 8,
                loans: {},
                installments: {},
                departments: {},
                designations: {},
                usid: '',

                us_c_name: '',
                us_amount: '',
                us_installments: '',
                us_type: '',
                us_reason: '',
                us_date: '',
                us_m_sts: '',
                us_hr_sts: '0',
                us_man_status: '',
                us_man_status_error: '',
                man_hr: '',

                return_amount: '0',
                e_ret_installment: '',
                loanid: '',
                rcvBy: '',
                rcvBy_error: '',
                ins_start: '0',
                pay_type: '',
                pay_emp_id: '',
                pay_loanID: '',
                empId: '',

                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,
                disabled2: false,
                timeout2: null,
                disabled3: false,
                timeout3: null,
                install_list: {},
                html2canvas: {
                    scale: 1,
                    useCORS: true
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                },
                tax: '',
                installment: '',
                stipend: '',
                Seesion: ''
            }
        },
        components: {
            VueHtml2pdf,
            Multiselect
        },
        methods: {
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
            get_emp_id(emp_id) {
                this.name = emp_id;
                this.timeout3 = setTimeout(() => {
                    this.fetch_emp_detail();
                }, 1000)
            },
            amount_filter() {
                if (this.bank_amount > 0 && this.bank_amount <= this.fix_amount) {
                    let x = this.fix_amount - this.bank_amount;
                    if (x >= 0) {
                        this.us_amount = x;
                    }
                }
                else {
                    this.us_amount = this.fix_amount;
                    this.bank_amount = '';
                }
            },
            getid(id) {
                this.d_loanid = id;
            },
            update_loan_status() {
                if (this.us_man_status == '') {
                    this.us_man_status_error = "Select status to change";
                    this.$toastr.e("Status not changed", "Error!");
                }
                else {
                    this.us_man_status_error = "";

                    if (this.man_hr == "man") {
                    axios.post('./update_loan_m_sts', {
                        usid: this.usid,
                        status: this.us_man_status,
                        pay_emp_id: this.pay_emp_id,
                        man_hr: this.man_hr,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s(this.pay_type + " status updated successfully!", "Congratulations");


                                this.m_check = "Manager";
                                this.check_approved = true;
                                this.check_pending = true;
                                this.check_rejected = false;
                                const loanIndex = this.loans.data.findIndex(loan => loan.LoanId === this.usid);
                                if (loanIndex !== -1) {
            // Update the status in the array
            this.loans.data[loanIndex].ManagerApproval = this.us_man_status;
        }
                                // this.getbyfilter();
                                this.us_man_status = "";
                                this.us_hr_sts = "";
                            } else {
                                this.$toastr.e(data.data, "Error!");
                            }
                        })
                } else if (this.man_hr == "hr") {
                    axios.post('./update_loan_m_sts', {
                        usid: this.usid,
                        status: this.us_man_status,
                        pay_emp_id: this.pay_emp_id,
                        man_hr: this.man_hr,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s(this.pay_type + " status updated successfully!", "Congratulations");
                                this.m_check = "HR Manager";
                                this.check_approved = true;
                                this.check_pending = true;
                                this.check_rejected = false;
                                const loanIndex = this.loans.data.findIndex(loan => loan.LoanId === this.usid);
                                if (loanIndex !== -1) {
            // Update the status in the array
            this.loans.data[loanIndex].HrApproval = this.us_man_status;
        }
                                // this.getbyfilter();
                                this.us_man_status = "";
                                this.us_hr_sts = "";
                            } else {
                                this.$toastr.e(data.data, "Error!");
                            }
                        })
                }
            }
        },
        delete_loan(id) {
            axios.get('delete_loan/' + id)
                .then(data => {
                    if (data.data == 'loan deleted') {
                        this.$toastr.s("Loan Deleted Successfully!", "Success");
                        this.d_loanid = '';
                        this.getbyfilter();
                    } else {
                        this.$toastr.e("Loan Not Deleted!", "Error");
                        }
                    })
                    .catch(error => { });
            },
            get_loanid(id, instid) {
                this.loan_skipid = id
                this.installment_id = instid
            },
            fetch_loan_slip(id) {
                axios.get('fetch_loan_slip/' + id)
                    .then(data => {
                    })
            },
            SkipInstallment() {
                axios.post("skip_installment", {
                    id: this.loan_skipid,
                    remarks: this.narration1,
                    installment_id: this.installment_id
                }).then((response) => {
                    if (response.data == 'Success') {
                        this.$toastr.s("Installment Skipped Successfully!", "Success");
                        this.installmentDetails(this.loan_skipid)
                    }
                    else {
                        this.$toastr.e(response.data, "Error");
                    }
                })
            },
            WaiveoffInstallment() {
                axios.post("waiveoff_installment", {
                    id: this.loan_skipid,
                    remarks: this.narration,
                    installment_id: this.installment_id
                }).then((response) => {
                    if (response.data == 'Success') {
                        this.$toastr.s("Installment Waived Off Successfully!", "Success");
                        this.installmentDetails(this.loan_skipid)
                    }
                    else {
                        this.$toastr.e("Loan Not Waive off!", "Error");
                    }
                })
            },
            installmentDetails(id) {
                this.loans.data.map((curEle) => {
                    return document.getElementById("accordionBorder" + curEle.LoanId).classList.remove("show")
                })
                axios.get("installments_detail/" + id)
                    .then((response) => {
                        this.install_list = response.data
                    })
            },
            htmlloanreport(id) {
                this.fetch_loan_slip(id);
                this.$refs.htmlloanPdf.generatePdf()
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.apply_loan()
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_loan_status()
            },
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.update_loan();
            },
            delay2() {
                this.disabled2 = true
                this.timeout2 = setTimeout(() => {
                    this.disabled2 = false
                }, 5000)
                this.pay_loan()
            },
            sum_total() {
                var ins_amt = document.getElementsByName('ins_amt[]');
                var second = document.getElementsByName('second[]');
                var m = 0;
                for (var g = 0; g < ins_amt.length; g++) {
                    var c = ins_amt[g];
                    var added = second[g];
                    if (added.checked == true) {
                        m = Number(m) + Number(c.value);
                    }
                }
                this.return_amount = Number(m);
            },
            return_loan(loanid) {
                this.loanid = loanid;
                if (this.return_amount == '0') {
                    this.e_ret_installment = "Select installment";
                    this.$toastr.e("Select installment to return", "Caution!");
                }
                else {
                    this.e_ret_installment = "";
                    var added = document.getElementsByName('second[]');
                    var addreturn = '';
                    for (var g = 0; g < added.length; g++) {
                        var fnn = added[g];
                        addreturn = addreturn + "|" + fnn.checked;
                    }

                    axios.post('./return_loan', {
                        loanid: this.loanid,
                        pay_emp_id: this.pay_emp_id,
                        pay_type: this.us_type,
                        return_amount: this.return_amount,
                        addreturn: addreturn,
                    })
                        .then(data => {
                            if (data.data == "Loan returned!") {
                                this.$toastr.s("Loan returned successfully!", "Congratulations");
                                axios.get("installments_detail/" + this.loanid)
                                    .then((response) => {
                                        this.install_list = response.data
                                    })
                                this.return_amount = '0';
                                this.view_loans();
                                window.open('./employee_loan/' + this.loanid, '_blank');

                            }
                            else {
                                this.$toastr.e(data.data, "Error!");
                            }
                        })
                }
            },
            getbyfilter() {
                if (this.department == '' && this.designation == '' && this.search_name == '') {
                    this.$toastr.e("Please Select Filter First", "Important Fields Missing!")
                }
                else {
                    if (this.search_name == '' || this.search_name == null) {
                        this.search_name1 = "All";
                    }
                    else {
                        this.search_name1 = this.search_name;
                    }
                    if (this.department == '' || this.department == null) {
                        this.department = "All";
                    }
                    else {
                        this.department = this.department;
                    }

                    if (this.designation == '' || this.designation == null) {
                        this.designation = "All";
                    }
                    else {
                        this.designation = this.designation;
                    }

                    if (this.check_approved == true) {
                        this.check_approved1 = "1";
                    }
                    else {
                        this.check_approved1 = "0";
                    }
                    if (this.from_date == '') {
                        this.from_date1 = '0000-00-00';
                    }
                    else {
                        this.from_date1 = this.from_date;
                    }
                    if (this.to_date == '') {
                        this.to_date1 = '9999-99-99';
                    }
                    else {
                        this.to_date1 = this.to_date;
                    }
                    axios.get('./filter_loans/' + this.from_date1 + '/' + this.to_date1 + '/' + this.department + '/' + this.designation + '/' + this.search_name1)
                        .then(data => this.loans = data.data)
                        .catch(error => { });
                }
            },
            find_id(code_name) {
                var code = code_name.split('_');


                axios.get('id_by_code/' + code[0])
                    .then(responce => {
                        this.name = responce.data;
                        this.fetch_emp_detail();
                    })
            },
            fetch_emp_detail() {
                this.empId = this.name;
                if (this.name != "") {
                    axios.get('fetch_employee_dtl/' + this.empId)
                        .then(responce => {
                            this.name = responce.data[0].EmployeeID;
                            this.salary = responce.data[0].Salary;
                            this.emp_id1 = responce.data[0].EmployeeID;
                            this.count_max_limit();
                        })
                        .catch(error => { });
                }
                else {
                    this.name = '';
                    this.salary = '';
                    this.max_advance = '0';
                    this.emp_id1 = '';
                }
            },
            count_max_limit() {
                axios.get('fetch_employee_amount/' + this.empId)
                    .then(data => {
                        this.tax = data.data.data.tax;
                        this.installment = data.data.data.installment;
                        this.stipend = data.data.data.stipend;
                        console.log('s 2');
                        if (this.type == 'Advance') {
                            this.max_advance = Number(this.salary) - Number(this.tax) - Number(this.installment) + Number(this.stipend);
                        }
                        else {
                            this.max_advance = ((Number(this.salary) - (Number(this.tax) + Number(this.installment))) + Number(this.stipend)) * this.config_loan;
                        }
                    })
                    .catch(error => { });
            },
            apply_loan() {
                if ((this.emp_name == '' || this.emp_name == null) || this.amount == '' || this.amount > this.max_advance || this.type == 'Select' || this.type == null || this.reason == '' || (this.type == 'Loan' && this.no_of_inst == '0')) {
                    if (this.amount == '') {
                        this.amount_error = "Enter amount";
                    }
                    else {
                        this.amount_error = "";
                    }
                    if (this.type == 'Select') {
                        this.type_error = "Select type";
                    }
                    else {
                        this.type_error = "";
                    }
                    if (this.reason == '') {
                        this.reason_error = "Type reason";
                    }
                    else {
                        this.reason_error = "";
                    }
                    if (this.no_of_inst == '0') {
                        this.installments_error = "Select number of installments";
                    }
                    else {
                        this.installments_error = "";
                    }
                    if (this.emp_name == '' || this.emp_name == null) {
                        this.e_emp_name = 'Select employee';
                    }
                    else {
                        this.e_emp_name = '';
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    //Add loan
                    axios.post('./loan', {
                        type1: this.type,
                        amount: this.amount,
                        reason: this.reason,
                        installments: this.no_of_inst,
                        installmentPrice: this.installmentPrice,
                        emp_id1: this.emp_id1,
                    })
                        .then(data => {
                            if (data.data.message == 'Loan added Successfully!') {
                            this.emp_name = '';
                            this.name = '';
                            this.salary = '';
                            this.max_advance = '0';
                            this.emp_id1 = '';
                            this.empId = '';
                            this.type = "Advance";
                            this.amount = "";
                            this.reason = "";
                            this.no_of_inst = "0";
                            this.installmentPrice = "";
                            this.tax = '';
                            this.installment = '';
                            this.stipend = '';
                            this.wished_deduction = '';
                    
                            this.loans.data.unshift(data.data.data);
                            this.$toastr.s("Loan added successfully!", "Congratulations!");

                            // this.getbyfilter();
                        } else {
                            this.$toastr.e(data.data, "Error!");
                            }
                        })
                }
            },
            fetch_emp_upSts(id, man) {
                this.man_hr = man;
                this.usid = id;
                axios.get('fetch_emp_upSts/' + this.usid)
                    .then(responce => {
                        this.pay_loanID = this.usid;
                    })

                axios.get("installments_detail/" + this.usid)
                    .then((response) => {
                        this.install_list = response.data
                    })

                axios.get('fetch_emp_upSts/' + this.usid)
                    .then(responce => {
                        this.emp_loan = responce.data;
                        console.log(this.emp_loan)
                        this.pay_loanID = this.usid;
                        this.pay_type = responce.data[0].LoanType;
                        this.pay_emp_id = responce.data[0].EmployeeID;
                        this.us_reason = responce.data[0].LoanReason;
                        this.us_c_name = responce.data[0].Name;
                        this.us_amount = Number(responce.data[0].LoanAmount);
                        this.bank_amount = 0;
                        this.fix_amount = Number(responce.data[0].LoanAmount);
                        this.us_installments = responce.data[0].LoanInstallments;
                        this.us_type = responce.data[0].LoanType;
                        this.us_date = responce.data[0].ApplyDate;
                        this.us_m_sts = responce.data[0].ManagerApproval;
                        this.us_hr_sts = responce.data[0].HrApproval;
                    })
            },
            pay_loan() {
                if (this.rcvBy == '') {
                    this.rcvBy_error = "Enter name of receiver";
                    this.$toastr.e("Please Enter name of receiver", "Caution!");
                }
                else {
                    this.rcvBy_error = "";
                    axios.post('./pay_loan', {
                        pay_loanID: this.pay_loanID,
                        cash_amount: this.us_amount,
                        //
                        bank_amount: this.bank_amount,
                        bank_type: this.bank_type,
                        cash_type: this.cash_type,
                        //
                        pay_emp_id: this.pay_emp_id,
                        pay_installments: this.us_installments,
                        pay_type: this.pay_type,
                        rcvBy: this.rcvBy,
                        ins_start: this.ins_start,
                    })
                        .then(data => {
                            if (data.data == "Loan paid!") {
                                this.$toastr.s("Loan paid! successfully!", "Congratulations");

                                this.pay_loanID = "";
                                this.us_amount = "";
                                this.us_installments = "";
                                this.pay_type = "";
                                this.rcvBy = "";
                                this.bank_type = "";
                                this.bank_amount = "";
                                this.view_loans();
                            }
                            else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                        })
                }
            },
            update_loan() {
                if ((this.pay_type == 'Loan' && this.us_installments == '0') || this.us_installments == '' || this.us_reason == '' || this.us_amount == '' || this.us_amount > this.max_advance) {
                    if (this.pay_type == 'Loan' && (this.us_installments == '0' || this.us_installments == '')) {
                        this.installments_error = 'Select installments';
                    }
                    else {
                        this.installments_error = '';
                    }
                    if (this.us_reason == '') {
                        this.e_us_reason = 'Enter reason';
                    }
                    else {
                        this.e_us_reason = '';
                    }
                    if (this.us_amount == '') {
                        this.e_us_amount = 'Enter amount';
                    }
                    else {
                        this.e_us_amount = '';
                    }
              
                this.e_us_wished_deduction = (this.pay_type == 'Loan' && !this.us_wished_deduction) ? 'Select deduction month' : '';
                this.$toastr.e("Please fill required fields properly!", "Caution!");
            } else {
                this.e_us_amount = '';
                this.installments_error = '';
                this.e_us_reason = '';
                this.us_wished_deduction = this.pay_type === 'Advance' ? this.session_name : this.us_wished_deduction;
                axios.post('./update_loan', {
                    usid: this.usid,
                    us_installments: this.us_installments,
                    us_amount: this.us_amount,
                    us_reason: this.us_reason,
                    us_wished_deduction: this.us_wished_deduction,
                })
                    .then(data => {
                        if (data.data == "Loan updated!") {
                            const loanIndex = this.loans.data.findIndex(loan => loan.LoanId === this.usid);
console.log(loanIndex);

                            if (loanIndex !== -1) {
            // Update properties of the loan in the array
            this.loans.data[loanIndex].LoanInstallments = this.us_installments;
            this.loans.data[loanIndex].LoanAmount = this.us_amount;
            this.loans.data[loanIndex].LoanReason = this.us_reason;
            this.loans.data[loanIndex].LoanSession = this.us_wished_deduction;

            // Show success message
            this.$toastr.s("Loan updated successfully!", "Congratulations");

            // Clear input values
            this.pay_type = '';
            this.us_installments = '';
            this.us_reason = '';
            this.us_amount = '';
            this.us_wished_deduction = '';
        } else {
            // Loan not found in the array
            this.$toastr.e('Loan not found in the array', 'Caution!');
        }
                        } else {
                            this.$toastr.e(data.data, "Caution!");
                        }
                    })
                        .then(data => {
                            if (data.data == "Loan updated!") {
                                this.$toastr.s("Loan updated successfully!", "Congratulations");
                                this.pay_type = '';
                                this.us_installments = '';
                                this.us_reason = '';
                                this.us_amount = '';
                            }
                            else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                            this.view_loans();
                        })
                }
            },
            view_loans(page = 1) {
                if (this.check_approved == false && this.check_pending == false && this.check_rejected == false && this.m_check == "Dept. & HR Manager") {
                    this.check = 0;
                }
                else if (this.check_approved == true && this.check_pending == false && this.check_rejected == false && this.m_check == "Dept. & HR Manager") {
                    this.check = 1;
                }
                else if (this.check_approved == true && this.check_pending == true && this.check_rejected == false && this.m_check == "Dept. & HR Manager") {
                    this.check = 2;
                }
                else if (this.check_approved == true && this.check_pending == true && this.check_rejected == true && this.m_check == "Dept. & HR Manager") {
                    this.check = 3;
                }
                else if (this.check_approved == true && this.check_pending == false && this.check_rejected == true && this.m_check == "Dept. & HR Manager") {
                    this.check = 4;
                }
                else if (this.check_approved == false && this.check_pending == true && this.check_rejected == true && this.m_check == "Dept. & HR Manager") {
                    this.check = 5;
                }
                else if (this.check_approved == false && this.check_pending == true && this.check_rejected == false && this.m_check == "Dept. & HR Manager") {
                    this.check = 6;
                }
                else if (this.check_approved == false && this.check_pending == false && this.check_rejected == true && this.m_check == "Dept. & HR Manager") {
                    this.check = 7;
                }
                //Department manager filter

                else if (this.check_approved == false && this.check_pending == false && this.check_rejected == false && this.m_check == "Dept. Manager") {
                    this.check = 10;
                }
                else if (this.check_approved == true && this.check_pending == false && this.check_rejected == false && this.m_check == "Dept. Manager") {
                    this.check = 11;
                }
                else if (this.check_approved == true && this.check_pending == true && this.check_rejected == false && this.m_check == "Dept. Manager") {
                    this.check = 12;
                }
                else if (this.check_approved == true && this.check_pending == true && this.check_rejected == true && this.m_check == "Dept. Manager") {
                    this.check = 13;
                }
                else if (this.check_approved == true && this.check_pending == false && this.check_rejected == true && this.m_check == "Dept. Manager") {
                    this.check = 14;
                }
                else if (this.check_approved == false && this.check_pending == true && this.check_rejected == true && this.m_check == "Dept. Manager") {
                    this.check = 15;
                }
                else if (this.check_approved == false && this.check_pending == true && this.check_rejected == false && this.m_check == "Dept. Manager") {
                    this.check = 16;
                }
                else if (this.check_approved == false && this.check_pending == false && this.check_rejected == true && this.m_check == "Dept. Manager") {
                    this.check = 17;
                }

                //HR manager filter

                else if (this.check_approved == false && this.check_pending == false && this.check_rejected == false && this.m_check == "HR Manager") {
                    this.check = 20;
                }
                else if (this.check_approved == true && this.check_pending == false && this.check_rejected == false && this.m_check == "HR Manager") {
                    this.check = 21;
                }
                else if (this.check_approved == true && this.check_pending == true && this.check_rejected == false && this.m_check == "HR Manager") {
                    this.check = 22;
                }
                else if (this.check_approved == true && this.check_pending == true && this.check_rejected == true && this.m_check == "HR Manager") {
                    this.check = 23;
                }
                else if (this.check_approved == true && this.check_pending == false && this.check_rejected == true && this.m_check == "HR Manager") {
                    this.check = 24;
                }
                else if (this.check_approved == false && this.check_pending == true && this.check_rejected == true && this.m_check == "HR Manager") {
                    this.check = 25;
                }
                else if (this.check_approved == false && this.check_pending == true && this.check_rejected == false && this.m_check == "HR Manager") {
                    this.check = 26;
                }
                else if (this.check_approved == false && this.check_pending == false && this.check_rejected == true && this.m_check == "HR Manager") {
                    this.check = 27;
                }

                axios.get('fetch_filtered_loans/' + this.check + '/?page=' + page)
                    .then(data => this.loans = data.data)
                    .catch(error => { });
            },

            session_list() {
                this.timeout = setTimeout(() => {
                    const date = new Date(this.session_name);
                    //console.log(this.session_name);
                    for (let a = 0; a <= 20; a++) {
                        const nextMonth = new Date(date.getFullYear(), date.getMonth() + a);
                        const monthName = nextMonth.toLocaleString('default', { month: 'long' });
                        const year = nextMonth.getFullYear();
                        const session = `${monthName}-${year}`;
                        this.sessions.push(session);
                    }
                }, 2000)

            },
            async fetchHrSession(){
                await this.$apihelpers.getHrSeesion();
                this.session_name = this.$helpers.getItem('hr_session');
            },

        },

        mounted() {
            this.fetchDepartment();
            this.fetchDesignation();
            this.view_loans();

            axios.get('find_emp_id')
                .then(data => {
                    this.find_emp = data.data.data;
                    this.options6 = [];
                    var $this = this;
                    for (var i = 0; i < $this.find_emp.length; i++) {
                        this.options6.push($this.find_emp[i].EmployeeCode + '_' + $this.find_emp[i].Name);
                    }

                })
                .catch(error => { });

            axios.get('accounts/fetch_methods1')
                .then(response => {
                    this.methods1 = response.data
                    this.options5 = [];

                    var $this = this;
                    for (var j = 0; j < $this.methods1.length; j++) {
                        this.options5.push($this.methods1[j].ID + '_' + $this.methods1[j].AccountName);
                    }
                })

            axios.get('view_hr_configuration')
                .then(data => {
                    this.config_ins = data.data[0].MaxInstallment;
                    this.config_loan = data.data[0].MaxLoan;
                })
                .catch(error => { });

            axios.get('fetch_all_installments')
                .then(data => this.installments = data.data)
                .catch(error => { });

            this.session_name = this.$helpers.getItem('hr_session')
            if(this.session_name == null || this.session_name == undefined || this.session_name == ''){
                this.session_name = this.fetchHrSession()
            }
  
            this.session_list();
        },
    }
</script>
