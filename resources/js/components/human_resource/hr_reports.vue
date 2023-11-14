<template>
    <div class="app-content content "
       >
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                            Reports
                        </li>
                    </ol>
                </div>
            </div>
            <div class="content-body">
                <div class="card"  style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <br>
                    <div class="row" style="margin-left:5%;margin-right:5%;margin-top:20px;margin-bottom:20px ">
                        <div v-if="hasPermission('HRMS HR-Reports  Employee-Overview-Reports')" class="col-md-4"  style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"> <i class="fa-solid fa-address-card" style="padding-right:10px"></i> Employee Overview Reports</h6>
                            <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#modalToggle"><i class="fa-solid fa-star"
                                                                                           style="font-size:16px !important;padding-right:20px"></i><span> Employee Detail</span></a>
                                <a data-bs-toggle="modal" data-bs-target="#employeehire1"><i class="fa-solid fa-star"
                                                                                             style="font-size:16px !important;padding-right:20px"></i><span> Employee Hire</span></a>
                                <!-- <a data-bs-toggle="modal" data-bs-target="#employeeappraisal"><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span>Employee Appraisals</span></a> -->
                            </div>
                        </div>
                        <div v-if="hasPermission('HRMS HR-Reports  Employee-Attendance-Reports')" class="col-md-4" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"> <i class="fa-solid fa-address-card" style="padding-right:10px"></i> Employee Attendance Reports</h6>
                            <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#att_detail"><i class="fa-solid fa-star"
                                                                                          style="font-size:16px !important;padding-right:20px"></i><span>Employee attendance report</span></a>

                                <a data-bs-toggle="modal" data-bs-target="#employees_attendance"><i
                                    class="fa-solid fa-star"
                                    style="font-size:16px !important;padding-right:20px"></i><span>Custom attendance report</span></a>

                                <a data-bs-toggle="modal" data-bs-target="#ind_att_report"><i class="fa-solid fa-star"
                                                                                              style="font-size:16px !important;padding-right:20px"></i><span>Session Wise Individual</span></a>

                                <a data-bs-toggle="modal" data-bs-target="#att_summary" style="max-width:300px"><i
                                    class="fa-solid fa-star"
                                    style="font-size:16px !important;padding-right:20px"></i><span>Session Wise Summary</span></a>
                                <a data-bs-toggle="modal" data-bs-target="#att_payroll" style="max-width:300px"><i
                                    class="fa-solid fa-star"
                                    style="font-size:16px !important;padding-right:20px"></i><span>Session Wise Payrol Att.</span></a>
                            </div>
                        </div>
                        <div v-if="hasPermission('HRMS HR-Reports  Employee-Leave-Reports')" class="col-md-4" style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"> <i class="fa-solid fa-address-card" style="padding-right:10px"></i> Employee Leave Reports</h6>
                            <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#absent_summary"><i class="fa-solid fa-star"
                                                                                              style="font-size:16px !important;padding-right:20px"></i><span> Absent Summary</span></a>
                                <a data-bs-toggle="modal" data-bs-target="#leave_detail"><i class="fa-solid fa-star"
                                                                                            style="font-size:16px !important;padding-right:20px"></i><span>Employees Leaves Detail</span></a>
                                <a data-bs-toggle="modal" data-bs-target="#leave_summary"><i class="fa-solid fa-star"
                                                                                             style="font-size:16px !important;padding-right:20px"></i><span>Leave Balance Summary</span></a>

                            </div>
                        </div>
                        <!--                        <div v-if="user_access.hr_write=='true'" class="col-md-4" style="margin-top:30px">-->
                        <!--                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"> <i class="fa-solid fa-address-card" style="padding-right:10px"></i> Recruitment Reports</h6>-->
                        <!--                            <div class="ng-star-inserted">-->
                        <!--                                &lt;!&ndash; <a data-bs-toggle="modal" data-bs-target="#hiringReport"><i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 20px"></i><span>Hiring Report</span></a>-->

<!--                                <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Today's Candidate</span></a>-->
<!--                                <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Candidate By Status</span></a>-->
<!--                                <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Interview vs User</span></a>-->
<!--                                <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Published Job Openings</span></a>-->
<!--                                <a style="max-width:300px"><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> JobOpenings vs Candidates</span></a> &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div v-if="user_access.hr_write=='true'" class="col-md-4" style="margin-top:30px">-->
<!--                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"> <i class="fa-solid fa-address-card" style="padding-right:10px"></i> Other Reports</h6>-->
<!--                            <div class="ng-star-inserted">-->
<!--                                &lt;!&ndash; <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Company Docs Expiry Detail</span></a>-->
<!--                                <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Employee Docs Expiry Detail</span></a> &ndash;&gt;-->
<!--                            </div>-->
<!--                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"> <i class="fa-solid fa-address-card" style="padding-right:10px"></i> Employee Performance Reports</h6>-->
<!--                            <div class="ng-star-inserted">-->
<!--                                &lt;!&ndash; <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Goals</span></a>-->
<!--                                <a><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span> Appraisals</span></a> &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
                        <div  v-if="hasPermission('HRMS HR-Reports  Employee-Payroll-Reports')"  class="col-md-4"  style="box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);margin-top:30px">
                            <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"><i class="fa-solid fa-address-card" style="padding-right:10px"></i> Employee Payroll Reports</h6>
                            <div  class="ng-star-inserted">
                                <a  data-bs-toggle="modal" data-bs-target="#loadvancereport"><i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 20px"></i><span>Loan Advance Report</span></a>
                                <a  data-bs-toggle="modal" data-bs-target="#arrearsreport"><i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 20px"></i><span>Arrears Report</span></a>
                                <a data-bs-toggle="modal" data-bs-target="#modalToggle9"><i class="fa-solid fa-star" style="font-size:16px !important;padding-right:20px"></i><span>Cash Distribution Report</span></a>
                            </div>
                        </div>
                        <div v-if="hasPermission('HRMS HR-Reports  Salary-&-Stipend-Reports')" class="col-md-4" style="margin-top:30px">
                            <div class="ng-star-inserted">
                                <h6 class="mb-25" style="font-weight:bold;padding-left:0px;padding-top:10px"><i
                                    class="fa-solid fa-address-card" style="padding-right:10px"></i>Salary & Stipend
                                    Reports</h6>
                                <a target="_blank" v-bind:href="`salary_detail_deptreport`">
                                    <i class="fa-solid fa-star"
                                       style="font-size:16px !important;padding-right:20px"></i><span>Department Stipend Report</span>
                                </a>
                                <a target="_blank" v-bind:href="`employee_stipend_report`">
                                    <i class="fa-solid fa-star"
                                       style="font-size:16px !important;padding-right:20px"></i><span>Employee Stipend Report</span>
                                </a>
                                <a target="_blank" v-bind:href="`salary_detail_deptsalaryreport`">
                                    <i class="fa-solid fa-star"
                                       style="font-size:16px !important;padding-right:20px"></i><span>Employee Salary Report</span>
                                </a>
                                <a target="_blank" v-bind:href="`company_salary_report`">
                                    <i class="fa-solid fa-star"
                                       style="font-size:16px !important;padding-right:20px"></i><span>Company Salary Report</span>
                                </a>
                                <a target="_blank" v-bind:href="`employee_stipend`">
                                    <i class="fa-solid fa-star"
                                       style="font-size:16px !important;padding-right:20px"></i><span>Overall Stipend Report</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cashdistributionReport" aria-labelledby="cashdistributionReport" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="emp_cash_distribution==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Cash Distribution Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Session</label>
                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Session" v-model="dist_session"
                                                 :options="optionssession">
                                    </multiselect>
                                    <span style="color: #DB4437; font-size: 11px;"
                                          v-if="dist_session==''">{{ e_dist_session }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Username</label>
                                    <select v-model="emp_location" class="form-control">
                                        <option value="All">All</option>
                                        <option value="husnain.malik@sagardens.net">husnain.malik@sagardens.net</option>
                                        <option value="muhammad.kamran@sagardens.net">muhammad.kamran@sagardens.net
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="cdist_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Employee Cash Distribution Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="cdist_report1()"></button>
                    </div>

                    <div class="modal-body" id="cash_distribution_id">
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <h5>Cashier Id:{{ this.emp_username }}</h5>
                            <h5>Cash Paid:{{ Number(sess_dist_sum).toLocaleString() }}</h5>
                            <h5>Bank Paid:{{ Number(sess_dist_sum1).toLocaleString() }}</h5>
                            <table class="table" id="Employees_Detail">
                                <thead>
                                <tr>
                                    <th scope="col">Emp Code</th>
                                    <th scope="col">Employmee Detail</th>
                                    <th scope="col">Payable Salary</th>
                                    <th scope="col">Received Date</th>
                                    <th scope="col">Received Through</th>
                                    <th scope="col">Cash Payable</th>
                                    <th scope="col">Bank Payable</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="getemployeecash1 in sess_dist_list">
                                    <td scope="col">{{ getemployeecash1.EmpCode }}</td>
                                    <td scope="col">{{ getemployeecash1.Name }}</td>
                                    <td scope="col">{{ getemployeecash1.PayableSalary }}</td>
                                    <td scope="col">{{ getemployeecash1.ReceivedTime }}</td>
                                    <td scope="col">{{ getemployeecash1.ReceivedThrough }}</td>
                                    <td scope="col">{{ getemployeecash1.CashAmount }}</td>
                                    <td scope="col">{{ getemployeecash1.BankAmount }}</td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','cash_distribution_id')"
                                class="btn btn-gradient-info">Excel
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="cdist_report1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalToggle9" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none"
             aria-hidden="true">
            <div v-if="emp_cash==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Session</label>
                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Session" v-model="dist_session"
                                                 :options="optionssession">
                                    </multiselect>
                                    <span style="color: #DB4437; font-size: 11px;"
                                          v-if="dist_session==''">{{ e_dist_session }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Department</label>
                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="emp_department" :options="options2">
                                    </multiselect>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Salary status</label>
                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" v-model="sal_status"
                                                 :options="optionssal_status">
                                    </multiselect>
                                </div>
                                <div class="col-md-12" v-if="sal_status=='Paid'">
                                    <label class="form-label" for="modalAddCardName">Distributed by</label>
                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Username" v-model="emp_user_sa"
                                                 :options="optionsusername">
                                    </multiselect>
                                </div>
                                <div class="col-md-12" v-else>
                                    <label class="form-label" for="modalAddCardName">Distributed by</label>
                                    <multiselect :disabled="true" :show-labels="false"
                                                 style="margin-right: 10px; font-size: 12px;" id="FilterTransaction"
                                                 placeholder="All Username" v-model="emp_user_sa"
                                                 :options="optionsusername">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="view_report9()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Employees Cash Distribution Report for session:
                            {{ dist_session }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="view_report91()"></button>
                    </div>

                    <div class="modal-body" id="Cash_Distribution_Report">
                        <div class="table-responsive" style="overflow-x: initial !important;">

                            <h5>Username:{{ emp_user_sa }} , Total Cash
                                Paid:{{ getemployeegetpayrollcashsum.toLocaleString() }}/- , Total Bank
                                Paid:{{ getemployeecashsum1.toLocaleString() }}/-</h5>
                            <table class="table" id="Employees_Detail">
                                <thead>
                                <tr>
                                    <th scope="col" class="reports-th-center">Employee Detail</th>
                                    <th scope="col" class="reports-th-center">Company &<br/>Department</th>
                                    <th scope="col" class="reports-th-center">Salary<br/>& Stip.</th>
                                    <th scope="col" class="reports-th-center">O.T<br/>& Ded.</th>
                                    <th scope="col" class="reports-th-center">Arrears<br/>& Bonus</th>
                                    <th scope="col" class="reports-th-center">Allow. <br/>& Fuel</th>
                                    <th scope="col" class="reports-th-center">Payable Sal.</th>
                                    <th scope="col" class="reports-th-center">Received Through</th>
                                    <th scope="col" class="reports-th-center">Received On</th>
                                    <th scope="col" class="reports-th-center">Total Cash Paid</th>
                                    <th scope="col" class="reports-th-center"> Cash<br/> Paid</th>
                                    <th scope="col" class="reports-th-center">Total Bank Paid</th>
                                    <th scope="col" class="reports-th-center">Total Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="getemployeecash1 in getemployeecash"
                                    v-if="toggle_payroll_distribution==false">
                                    <td scope="col" class="td-left">
                                        {{ getemployeecash1.Name }}<br/>{{ getemployeecash1.EmpCode }}
                                    </td>
                                    <td scope="col" class="td-center">
                                        <strong>{{
                                                getemployeecash1.Company
                                            }}</strong><br/>{{ getemployeecash1.Department }}
                                    </td>
                                    <td scope="col" class="td-right">
                                        {{
                                            Number(getemployeecash1.Salary).toLocaleString()
                                        }}/-<br/>{{ Number(getemployeecash1.StipendAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right">
                                        {{
                                            Number(getemployeecash1.OAmount).toLocaleString()
                                        }}/-<br/>{{ Number(getemployeecash1.DAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right">
                                        {{
                                            Number(getemployeecash1.ArrearsAmount).toLocaleString()
                                        }}/-<br/>{{ Number(getemployeecash1.BonusAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right">
                                        {{
                                            Number(getemployeecash1.AllowanceAmount).toLocaleString()
                                        }}/-<br/>{{ Number(getemployeecash1.FuelAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right">
                                        {{ Number(getemployeecash1.PayableSalary).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-center" v-if="getemployeecash1.Received!=null">
                                        {{ getemployeecash1.Received }}
                                    </td>
                                    <td scope="col" class="td-center" v-else>{{ getemployeecash1.ReceivedThrough }}</td>
                                    <td scope="col" class="td-center" v-if="getemployeecash1.ReceivedTi!=null">
                                        {{ getemployeecash1.ReceivedTi?.split(" ")[0] }}
                                    </td>
                                    <td scope="col" class="td-center" v-else>
                                        {{ getemployeecash1.ReceivedTime?.split(" ")[0] }}
                                    </td>
                                    <td scope="col" class="td-right" v-if="getemployeecash1.CCAmount !=null">
                                        {{ Number(getemployeecash1.CCAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-else>
                                        {{ Number(getemployeecash1.CashAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-if="getemployeecash1.currentpaying !=null">
                                        {{ Number(getemployeecash1.currentpaying).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-else>
                                        {{ Number(getemployeecash1.CurrentCashPaid).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-if="getemployeecash1.BAmount !=null">
                                        {{ Number(getemployeecash1.BAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-else>
                                        {{ Number(getemployeecash1.BankAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-if="getemployeecash1.PAmount !=null">
                                        {{ Number(getemployeecash1.PAmount).toLocaleString() }}/-
                                    </td>
                                    <td scope="col" class="td-right" v-else>
                                        {{ Number(getemployeecash1.PaidAmount).toLocaleString() }}/-
                                    </td>
                                </tr>
                                <tr v-if="toggle_payroll_distribution==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div hidden class="modal-body" id="Employees_Detail9">
                        <div class="table-responsive" style="overflow-x: initial !important;">

                            <h5>Username:{{emp_user_sa}} ,        Total Cash Paid:{{getemployeegetpayrollcashsum.toLocaleString()}}/- ,        Total Bank Paid:{{getemployeecashsum1.toLocaleString()}}/-</h5>
                            <table class="table" id="Employees_Detail">
                                <thead>
                                    <tr>
                                        <th scope="col" class="reports-th-center">Employee Detail</th>
                                        <th scope="col" class="reports-th-center">Company</th>
                                        <th scope="col" class="reports-th-center">Department</th>
                                        <th scope="col" class="reports-th-center">Salary</th>
                                        <th scope="col" class="reports-th-center">Stipend</th>
                                        <th scope="col" class="reports-th-center">O.T</th>
                                        <th scope="col" class="reports-th-center">Ded.</th>
                                        <th scope="col" class="reports-th-center">Arrears</th>
                                        <th scope="col" class="reports-th-center">Bonus</th>
                                        <th scope="col" class="reports-th-center">Allowance</th>
                                        <th scope="col" class="reports-th-center">Fuel</th>
                                        <th scope="col" class="reports-th-center">Payable Salary</th>
                                        <th scope="col" class="reports-th-center">Received On</th>
                                        <th scope="col" class="reports-th-center">Received Through</th>
                                        <th scope="col" class="reports-th-center">Cash Payable</th>
                                        <th scope="col" class="reports-th-center">Paid Cash</th>
                                        <th scope="col" class="reports-th-center">Bank Payable</th>
                                        <th scope="col" class="reports-th-center">Paid By Bank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="getemployeecash1 in getemployeecash" v-if="toggle_payroll_distribution==false">
                                        <td scope="col" class="td-left">{{getemployeecash1.Name}}<br />{{getemployeecash1.EmpCode}}</td>
                                        <td scope="col" class="td-center">{{getemployeecash1.Company}}</td>
                                        <td scope="col" class="td-center">{{getemployeecash1.Department}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.Salary).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.StipendAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.OAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.DAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.ArrearsAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.BonusAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.AllowanceAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.FuelAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.PayableSalary).toLocaleString()}}</td>
                                        <td scope="col" class="td-center" v-if="getemployeecash1.ReceivedTime!=null">{{getemployeecash1.ReceivedTime.split(" ")[0]}}</td>
                                        <td scope="col" class="td-center" v-else></td>
                                        <td scope="col" class="td-right">{{getemployeecash1.ReceivedThrough}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.CashAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.CashAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.BankAmount).toLocaleString()}}</td>
                                        <td scope="col" class="td-right">{{Number(getemployeecash1.BankAmount).toLocaleString()}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Cash_Distribution_Report')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="view_report91()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal 1-->
        <div class="modal fade" id="hiringReport" aria-labelledby="hiringReport" tabindex="-1" style="display: none"
             aria-hidden="true">
            <div v-if="hiring_employee_report==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Hiring Report Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="hiring_start_date" class="form-control"/>
                                    <span style="color: #db4437; font-size: 11px"
                                          v-if="hiring_start_date == ''">{{ e_hiring_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="hiring_end_date" type="date" class="form-control"/>
                                    <span style="color: #db4437; font-size: 11px"
                                          v-if="hiring_end_date == ''">{{ e_hiring_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Department</label>
                                    <multiselect style="margin-right: 10px;"
                                                 v-model="hiring_dept" :options="options2">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="hiring_rep()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Employee Hiring Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="hiring_rep1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true"
                                  :preview-modal="false" :paginate-elements-by-height="5000" filename="Hiring_Report"
                                  :pdf-quality="2" :manual-pagination="false" pdf-format="a4"
                                  pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)"
                                  ref="hiringpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.hiring_start_date }} To
                                        {{ this.hiring_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Employee Code</th>
                                            <th scope="col" style="    min-width: 100px;">Name</th>
                                            <th scope="col">Father Name</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Joining Date</th>
                                            <th scope="col">Job Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="hiring_list1 in hiring_list">
                                            <td>{{ hiring_list1.EmployeeCode }}</td>
                                            <td>{{ hiring_list1.Name }}</td>
                                            <td>{{ hiring_list1.FatherHusband }}</td>
                                            <td>{{ hiring_list1.Department }}</td>
                                            <td>{{ hiring_list1.JoiningDate }}</td>
                                            <td>{{ hiring_list1.JobStatus }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Hiring_Report_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.hiring_start_date }} To {{ this.hiring_end_date }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Employee Code</th>
                                    <th scope="col" style="    min-width: 100px;">Name</th>
                                    <th scope="col">Father Name</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Joining Date</th>
                                    <th scope="col">Job Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="hiring_list1 in hiring_list">
                                    <td>{{ hiring_list1.EmployeeCode }}</td>
                                    <td>{{ hiring_list1.Name }}</td>
                                    <td>{{ hiring_list1.FatherHusband }}</td>
                                    <td>{{ hiring_list1.Department }}</td>
                                    <td>{{ hiring_list1.JoiningDate }}</td>
                                    <td>{{ hiring_list1.JobStatus }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Hiring_Report_id')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generateEmployeeHiringReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="hiring_rep1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="loadvancereport" aria-labelledby="loadvancereport" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="loan_advance_report==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Loan Advance Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="la_start_date" class="form-control"/>
                                    <span style="color: #db4437; font-size: 11px"
                                          v-if="la_start_date == ''">{{ e_la_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="la_end_date" type="date" class="form-control"/>
                                    <span style="color: #db4437; font-size: 11px"
                                          v-if="la_end_date == ''">{{ e_la_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Department</label>
                                    <multiselect style="margin-right: 10px;"
                                                 v-model="la_dept" :options="options2">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Loan Type</label>
                                    <multiselect style="margin-right: 10px;"
                                                 v-model="la_type" :options="optionstype">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Req. Status</label>
                                    <multiselect style="margin-right: 10px;"
                                                 v-model="la_status" :options="optionstatus">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="la_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1200px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Loan Advance Report Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="la_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true"
                                  :preview-modal="false" :paginate-elements-by-height="5000" filename="Loan_Advance"
                                  :pdf-quality="2" :manual-pagination="false" pdf-format="a4"
                                  pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)"
                                  ref="loanadvancepdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.la_start_date }} To {{ this.la_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Apply Date</th>
                                            <th>Employee Code</th>
                                            <th scope="col" style="    min-width: 100px;">Name</th>

                                            <th scope="col">Department</th>
                                            <th scope="col">Loan Reason</th>
                                            <th scope="col">Loan Installments</th>
                                            <th scope="col">Loan Type</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="hiring_list1 in la_list">
                                            <td>{{ hiring_list1.ApplyDate }}</td>
                                            <td>{{ hiring_list1.EmployeeCode }}</td>
                                            <td>{{ hiring_list1.Name }}</td>

                                            <td>{{ hiring_list1.Department }}</td>
                                            <td>{{ hiring_list1.LoanReason }}</td>
                                            <td>{{ hiring_list1.LoanInstallments }}</td>
                                            <td>{{ hiring_list1.LoanType }}</td>
                                            <td>{{ hiring_list1.ReqStatus }}</td>
                                            <td>{{ Number(hiring_list1.LoanAmount) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="loan_Report_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.la_start_date }} To {{ this.la_end_date }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Apply Date</th>
                                    <th>Employee Code</th>
                                    <th scope="col" style="    min-width: 100px;">Name</th>

                                    <th scope="col">Department</th>
                                    <th scope="col">Loan Reason</th>
                                    <th scope="col">Loan Installments</th>
                                    <th scope="col">Loan Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="hiring_list1 in la_list" v-if="toggle_loan_advance==false">
                                    <td>{{ hiring_list1.ApplyDate }}</td>
                                    <td>{{ hiring_list1.EmployeeCode }}</td>
                                    <td>{{ hiring_list1.Name }}</td>

                                    <td>{{ hiring_list1.Department }}</td>
                                    <td>{{ hiring_list1.LoanReason }}</td>
                                    <td>{{ hiring_list1.LoanInstallments }}</td>
                                    <td>{{ hiring_list1.LoanType }}</td>
                                    <td>{{ hiring_list1.ReqStatus }}</td>
                                    <td>{{ Number(hiring_list1.LoanAmount) }}</td>
                                </tr>
                                <tr v-if="toggle_loan_advance==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','loan_Report_id')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generateLoanAdvanceReport()" class="btn btn-gradient-info">Pdf
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="la_report1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="arrearsreport" aria-labelledby="arrearsreport" tabindex="-1" style="display: none"
             aria-hidden="true">
            <div v-if="emp_arrears_report==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Arrears Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="arrears_start_date" class="form-control"/>
                                    <span style="color: #db4437; font-size: 11px"
                                          v-if="arrears_start_date == ''">{{ e_arrears_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="arrears_end_date" type="date" class="form-control"/>
                                    <span style="color: #db4437; font-size: 11px"
                                          v-if="arrears_end_date == ''">{{ e_arrears_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Department</label>
                                    <multiselect style="margin-right: 10px;"
                                                 v-model="arrears_dept" :options="options2">
                                    </multiselect>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="arrears_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1200px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Arrears Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="arrears_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true"
                                  :preview-modal="false" :paginate-elements-by-height="5000" filename="Arrears_Report"
                                  :pdf-quality="2" :manual-pagination="false" pdf-format="a4"
                                  pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)"
                                  ref="arrearspdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.arrears_start_date }} To
                                        {{ this.arrears_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th>Employee Code</th>
                                            <th scope="col" style="    min-width: 100px;">Name</th>

                                            <th scope="col">Department</th>
                                            <th scope="col">Descriptions</th>

                                            <th scope="col">Status</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="hiring_list1 in la_list">
                                            <td>{{ hiring_list1.ArrearsAmount }}</td>
                                            <td>{{ hiring_list1.EmployeeCode }}</td>
                                            <td>{{ hiring_list1.Name }}</td>

                                            <td>{{ hiring_list1.Department }}</td>
                                            <td>{{ hiring_list1.Descriptions }}</td>
                                            <td>{{ hiring_list1.Status }}</td>
                                            <td>{{ Number(hiring_list1.ArrearsAmount) }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="arrear_Report_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.arrears_start_date }} To {{ this.arrears_end_date }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th>Employee Code</th>
                                    <th scope="col" style="    min-width: 100px;">Name</th>

                                    <th scope="col">Department</th>
                                    <th scope="col">Descriptions</th>

                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="hiring_list1 in la_list" v-if="toggle_arrears==false">
                                    <td>{{ hiring_list1.ArrearsAmount }}</td>
                                    <td>{{ hiring_list1.EmployeeCode }}</td>
                                    <td>{{ hiring_list1.Name }}</td>

                                    <td>{{ hiring_list1.Department }}</td>
                                    <td>{{ hiring_list1.Descriptions }}</td>
                                    <td>{{ hiring_list1.Status }}</td>
                                    <td>{{ Number(hiring_list1.ArrearsAmount) }}</td>
                                </tr>
                                <tr v-if="toggle_arrears==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','arrear_Report_id')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generateArrearsReport()" class="btn btn-gradient-info">Pdf
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                @click="arrears_report1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none"
             aria-hidden="true">
            <div v-if="emp_detail==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All Locations"
                                                 v-model="emp_location" :options="options1">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="emp_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All Designations"
                                                 v-model="emp_designation" :options="options">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>
                                    <select v-model="emp_emp_id" class="form-control">
                                        <option value="All">All</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Type</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All"
                                                 v-model="emp_type" :options="options3">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Status</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All"
                                                 v-model="emp_status" :options="options4">
                                    </multiselect>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="view_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl" style="min-width:1200px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Employee Detail Report</h4>

                        <div style="margin-left:10%;">
                            <button type="button" @click="html_table_to_excel('xlsx','Employees_Detail')"
                                    class="btn btn-gradient-info">Download in Excel
                            </button>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="view_report1()"></button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Employment Detail</th>
                                    <th scope="col">Basic Info</th>
                                    <th scope="col">Contact Info</th>
                                    <th scope="col">Home Address</th>
                                    <th scope="col">Payment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!---->
                                <tr class="ng-star-inserted" v-for="getemployee1 in getemployee"
                                    v-if="toggle_employee_detail==false">
                                    <td rows="6">
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Name:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.EmployeeCode }} - {{
                                                            getemployee1.Name
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Department:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Department }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Designation:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Designation }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Location:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.PostingCity }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td rows="6">
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Gender:</strong>
                                                </div>
                                                <div>
                                                    <!----><span
                                                    class="ng-star-inserted">{{ getemployee1.Gender }}</span>
                                                    <!---->
                                                    <!---->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>DOB:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.DOB }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Hired:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.JoiningDate }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Job Shift:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.JobShift }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td rows="6">
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Email:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Mobile:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Mobile }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Job Status:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Status }}-{{ getemployee1.JobStatus }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Relation:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Relation }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Emergency Phone:</strong>
                                                </div>
                                                <div>
                                                    <span>{{ getemployee1.Phone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width:300px !important">
                                        <p rows="6" readonly>{{ getemployee1.Address }}, {{ getemployee1.City }}</p>
                                    </td>
                                    <td rows="6">
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Method:</strong> <span>{{ getemployee1.MethodType }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Salary:</strong><span>{{
                                                        (getemployee1.Salary).toLocaleString()
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <strong>Stipend:</strong><span
                                                    v-if="getemployee1.Stipend > 0">{{
                                                        getemployee1.Stipend
                                                    }}</span><span
                                                    v-else>0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    <strong>Job Description:</strong>
                                                </div>
                                                <div>
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="toggle_employee_detail==true">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            <table style="visibility: collapse;" class="table" id="Employees_Detail">
                                <thead>
                                <tr>
                                    <th>Emp. Code</th>
                                    <th scope="col" style="min-width: 100px;">Name</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Date of Joining</th>
                                    <th scope="col">Salary</th>
                                    <th scope="col">Stipend</th>
                                    <th scope="col">Emergency Phone</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Relation</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Job Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="getemployee1 in getemployee">
                                    <td>{{ getemployee1.EmployeeCode }}</td>
                                    <td>{{ getemployee1.Name }}</td>
                                    <td>{{ getemployee1.Department }}</td>
                                    <td>{{ getemployee1.Designation }}</td>
                                    <td>{{ getemployee1.Email }}</td>
                                    <td>{{ getemployee1.Mobile }}</td>
                                    <td>{{ getemployee1.JoiningDate }}</td>
                                    <td>{{ getemployee1.Salary }}</td>
                                    <td>{{ getemployee1.Stipend }}</td>
                                    <td>{{ getemployee1.Phone }}</td>
                                    <td>{{ getemployee1.PostingCity }}</td>
                                    <td>{{ getemployee1.Relation }}</td>
                                    <td>{{ getemployee1.Status }}</td>
                                    <td>{{ getemployee1.JobStatus }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Detail')"
                                class="btn btn-gradient-info">Download in Excel
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="view_report1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 1-->
        <div class="modal fade" id="employeehire1" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="emp_hire==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Hiring Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="hire_start_date" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="hire_end_date" type="date" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All Locations"
                                                 v-model="hire_location" :options="options1">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="hire_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All Designations"
                                                 v-model="hire_designation" :options="options">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>
                                    <select v-model="hire_emp_id" class="form-control">
                                        <option value="All">All</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="employee_hire_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span style="width:80%">Employee Hire Report </span>
                        </h4>
                        <span class="role-edit-modal"> {{ this.hire_start_date }} - {{ this.hire_end_date }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="employee_hire_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="5000"
                                  filename="Employee_Hiring_Report"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmlemphirePdf">
                        <div slot="pdf-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h4 class="modal-title" style="width:80%"><span
                                    style="width:80%">Employee Hire Report </span></h4>
                                <span
                                    class="role-edit-modal"> {{ this.hire_start_date }} - {{
                                        this.hire_end_date
                                    }}</span>

                            </div>
                            <div class="modal-body">
                                <div class="table-responsive EmployeeHireReport">
                                    <table class="table employeeHireReport" id="Employees_Hiring_Report">
                                        <thead style="">
                                        <tr>
                                            <th scope="col" style="width:20%;">Employment Detail</th>
                                            <th scope="col" style="width:80%; min-width: 500px;">
                                                <table style="width:100%;">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" style="width:50%;">Personal Detail</th>
                                                        <th scope="col" style="width:25%;">Hire Date</th>
                                                        <th scope="col" style="width:25%;">Job Detail</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tfoot style="">
                                        <tr>
                                            <th scope="col"></th>
                                            <!---->
                                            <!---->
                                            <th scope="col" class="ng-star-inserted">Total
                                                Employees:{{ this.gethireemplocount }}
                                            </th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <!---->
                                        <tr class="ng-star-inserted" v-for="gethireemplo1 in gethireemplo">
                                            <td style="width:20%;">
                                                <div class="row">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            Department:{{ gethireemplo1.Department }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            Designation:{{ gethireemplo1.Designation }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            Location:{{ gethireemplo1.PostingCity }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:80%;min-width: 500px;">
                                                <table style="width:100%;">
                                                    <tbody>
                                                    <!---->
                                                    <tr class="ng-star-inserted">
                                                        <td style="width:50%;">
                                                            <div class="row">
                                                                <div class="mt-display-flex">
                                                                    <div>
                                                                        <span>{{
                                                                                gethireemplo1.EmployeeCode
                                                                            }} - {{ gethireemplo1.Name }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span>Cnic:{{ gethireemplo1.CNIC }} </span>
                                                                    </div>
                                                                    <div>
                                                                        <span>Phone:{{ gethireemplo1.Mobile }} </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="width:25%;">
                                                            <div>
                                                                <span> {{ gethireemplo1.JoiningDate }}</span>
                                                            </div>
                                                            <div>
                                                                <span> {{ gethireemplo1.JobStatus }} </span>
                                                            </div>
                                                        </td>
                                                        <td style="width:25%;">
                                                            <div>
                                                                <span>Salary: {{ gethireemplo1.Salary }}/- </span>
                                                            </div>
                                                            <div>
                                                                <span v-html="gethireemplo1.JobDescription"> </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body">
                        <div class="table-responsive EmployeeHireReport">
                            <table class="table employeeHireReport">
                                <thead style="">
                                <tr>
                                    <th scope="col" style="width:20%;">Employment Detail</th>
                                    <th scope="col" style="width:80%; min-width: 500px;">
                                        <table style="width:100%;">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="width:50%;">Personal Detail</th>
                                                <th scope="col" style="width:25%;">Hire Date</th>
                                                <th scope="col" style="width:25%;">Job Detail</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </th>
                                </tr>
                                </thead>
                                <tfoot style="">
                                <tr>
                                    <th scope="col"></th>

                                    <th scope="col" class="ng-star-inserted">Total
                                        Employees:{{ this.gethireemplocount }}
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <!---->
                                <tr class="ng-star-inserted" v-for="gethireemplo1 in gethireemplo"
                                    v-if="toggle_employeehire==false">
                                    <td style="width:20%;">
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    Department:{{ gethireemplo1.Department }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    Designation:{{ gethireemplo1.Designation }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-display-flex">
                                                <div>
                                                    Location:{{ gethireemplo1.PostingCity }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width:80%;min-width: 500px;">
                                        <table style="width:100%;">
                                            <tbody>
                                            <tr class="ng-star-inserted">
                                                <td style="width:50%;">
                                                    <div class="row">
                                                        <div class="mt-display-flex">
                                                            <div>
                                                                <span>{{
                                                                        gethireemplo1.EmployeeCode
                                                                    }} - {{ gethireemplo1.Name }}</span>
                                                            </div>
                                                            <div>
                                                                <span>Cnic:{{ gethireemplo1.CNIC }} </span>
                                                            </div>
                                                            <div>
                                                                <span>Phone:{{ gethireemplo1.Mobile }} </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:25%;">
                                                    <div>
                                                        <span> {{ gethireemplo1.JoiningDate }}</span>
                                                    </div>
                                                    <div>
                                                        <span> {{ gethireemplo1.JobStatus }} </span>
                                                    </div>
                                                </td>
                                                <td style="width:25%;">
                                                    <div>
                                                        <span>Salary: {{ gethireemplo1.Salary }}/- </span>
                                                    </div>
                                                    <div>
                                                        <span v-html="gethireemplo1.JobDescription"> </span>
                                                    </div>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr v-if="toggle_employeehire==true">
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>


                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Hiring_Report')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="htmlemphirereport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="employee_hire_report1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="employeeappraisal" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="emp_appraisal==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Employee Appraisal Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input type="date" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="employee_appraisal_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span
                            style="width:80%">Employee Appraisal Report </span></h4>
                        <span class="role-edit-modal"> 01/01/2022 - 31/12/2022</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="employee_appraisal_report1()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive EmployeeHireReport">
                            <table class="table employeeHireReport">
                                <thead style="">
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Appraisal Amount</th>
                                    <th>Date</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gradient-info">Excel</button>
                        <button type="button" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="employee_appraisal_report1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="absent_summary" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="abs_summary==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Absent Summary Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="absent_from" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input type="date" v-model="absent_to" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All Locations"
                                                 v-model="abs_location" :options="options1">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="abs_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All Designations"
                                                 v-model="abs_designation" :options="options">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>
                                    <select v-model="abs_emp_id" class="form-control">
                                        <option value="All">All</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="absent_summary()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span style="width:80%">Absent Summary Report </span>
                        </h4>
                        <span class="role-edit-modal"> {{ this.absent_from }} - {{ this.absent_to }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="absent_summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1400"
                                  filename="Employee_Absent_Report"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="portrait"
                                  pdf-content-width="800px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmlempabsentPdf">
                        <div class="modal-body" slot="pdf-content">
                            <div class="table-responsive">
                                <table class="table attendancesummaryreport" id="Employees_Absent_Report">
                                    <thead style="">
                                    <tr>
                                        <th scope="col" colspan="6">Absent Report</th>
                                    </tr>
                                    </thead>
                                    <thead style="">
                                    <tr>
                                        <th scope="col">Emp. Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="absent_detail1 in absent_detail">
                                        <td>{{ absent_detail1.EmployeeCode }}</td>
                                        <td>{{ absent_detail1.Name }}</td>
                                        <td>{{ absent_detail1.Designation }}</td>
                                        <td>{{ absent_detail1.Department }}</td>
                                        <td>{{ absent_detail1.PostingCity }}</td>
                                        <td>{{ absent_detail1.ATTDate }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table attendancesummaryreport">
                                <thead style="">
                                <tr>
                                    <th scope="col">Emp. Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="absent_detail1 in absent_detail" v-if="toggle_absent_summary==false">
                                    <td>{{ absent_detail1.EmployeeCode }}</td>
                                    <td>{{ absent_detail1.Name }}</td>
                                    <td>{{ absent_detail1.Designation }}</td>
                                    <td>{{ absent_detail1.Department }}</td>
                                    <td>{{ absent_detail1.PostingCity }}</td>
                                    <td>{{ absent_detail1.ATTDate }}</td>
                                </tr>
                                <tr v-if="toggle_absent_summary==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Absent_Report')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="empabsentpdfreport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="absent_summary1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="employees_attendance" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="!this.isEmployeesCustomAttendance" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Custom Attendance Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Date Range</label>
                                    <date-range-picker
                                        ref="picker"
                                        minDate="'2022-01-01'"
                                        :maxDate="att_date"
                                        v-model="dateRange"
                                        :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy' }"
                                        style="width: 100%;"
                                    ></date-range-picker>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>
                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="custom_att_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Employee(s)</label>
                                <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                             value="id"
                                             label="label" placeholder="All Employees" v-model="employeesForAttendance"
                                             :options="registeredEmployees"
                                             :multiple="true"></multiselect>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="custom_attendance()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span
                            style="width:80%">Custom Attendance Report</span>
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="exitCustomAttendance()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1600"
                                  filename="CustomAttendance"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  :pdf-format="this.page"
                                  pdf-orientation="landscape"
                                  :pdf-content-width="pixel"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="customAttendancePDF">
                        <div class="modal-body" slot="pdf-content">
                            <div class="table-responsive">
                                <table border="1" class="table tableMain payrollSheetTable"
                                       style="font-family:Arial !important; font-size: 10px !important;margin-bottom:30px;">
                                    <thead class="grid-header">
                                    <tr>
                                        <th class="td-center"
                                            style="min-width: 70px; position: sticky; left: 0; z-index: 1;">Emp. Code
                                        </th>
                                        <th class="td-center" style="min-width: 200px;">Employee Name</th>
                                        <th class="td-center" style="min-width: 200px;">Department</th>
                                        <th class="td-center" style="min-width: 200px;">Designation</th>
                                        <th class="td-center" v-for='date in dateArray' style="min-width: 83px;">
                                            {{ date }}
                                        </th>
                                        <th class="td-center">GP</th>
                                        <th class="td-center">Late Instance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(employeeAttendance, index) in employeesCustomAttendance" :key="index">
                                        <td class="td-center"
                                            style="position: sticky; left: 0; background-color: white !important; z-index: 1;">
                                            {{ employeeAttendance['EmployeeCode'] }}
                                        </td>
                                        <td class="td-left">
                                            <div class="d-flex flex-column">
                                                <a class="user_name text-truncate text-body"><span
                                                    class="fw-bolder">{{ employeeAttendance['Employee Name'] }} </span></a>
                                            </div>
                                        </td>
                                        <td class="td-center">
                                            {{ employeeAttendance['Department'] }}
                                        </td>
                                        <td class="td-center">
                                            {{ employeeAttendance['Designation'] }}
                                        </td>
                                        <td class="td-center" v-for='date in dateArray'>
                                            {{ employeeAttendance[date] }}
                                        </td>
                                        <td class="td-center">
                                            {{ employeeAttendance['GracePeriod'] }}
                                        </td>
                                        <td class="td-center">
                                            {{ employeeAttendance['LateInstance'] }}
                                        </td>
                                        <!-- Add other date columns here -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body">
                        <div class="table-responsive" style="overflow-x: auto;" >
                            <table class="table table-bordered table-hover" style="width: 100%;" slot="pdf-content">
                                <thead class="grid-header">
                                <tr>
                                    <th class="td-center"
                                        style="min-width: 90px; position: sticky; left: 0; z-index: 1;">Emp. Code
                                    </th>
                                    <th class="td-center" style="min-width: 350px;">Employee Name</th>
                                    <th class="td-center" v-for='date in dateArray' style="min-width: 105px;">
                                        {{ date }}
                                    </th>
                                    <th class="td-center">GP</th>
                                    <th class="td-center">Late Instance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(employeeAttendance, index) in employeesCustomAttendance" :key="index">
                                    <td class="td-center"
                                        style="position: sticky; left: 0; background-color: white !important; z-index: 1;">
                                        {{ employeeAttendance['EmployeeCode'] }}
                                    </td>
                                    <td class="td-left">
                                        <div class="d-flex flex-column">
                                            <a class="user_name text-truncate text-body"><span
                                                class="fw-bolder">{{ employeeAttendance['Employee Name'] }} </span></a>
                                            <small class="emp_post text-muted">
                                                {{ employeeAttendance['Department'] }} -
                                                {{ employeeAttendance['Designation'] }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="td-center" v-for='date in dateArray'>
                                        {{ employeeAttendance[date] }}
                                    </td>
                                    <td class="td-center">
                                        {{ employeeAttendance['GracePeriod'] }}
                                    </td>
                                    <td class="td-center">
                                        {{ employeeAttendance['LateInstance'] }}
                                    </td>
                                    <!-- Add other date columns here -->
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive" style="overflow-x: auto; display: none;" id="customAttendance">
                            <table class="table table-bordered table-hover" style="width: 100%;" slot="pdf-content">
                                <thead class="grid-header">
                                <tr>
                                    <th class="td-center"
                                        style="min-width: 90px; position: sticky; left: 0; z-index: 1;">Emp. Code
                                    </th>
                                    <th class="td-center" style="min-width: 200px;">Employee Name</th>
                                    <th class="td-center" style="min-width: 200px;">Department</th>
                                    <th class="td-center" style="min-width: 200px;">Designation</th>
                                    <th class="td-center" v-for='date in dateArray' style="min-width: 105px;">
                                        {{ date }}
                                    </th>
                                    <th class="td-center">GP</th>
                                    <th class="td-center">Late Instance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(employeeAttendance, index) in employeesCustomAttendance" :key="index">
                                    <td class="td-center"
                                        style="position: sticky; left: 0; background-color: white !important; z-index: 1;">
                                        {{ employeeAttendance['EmployeeCode'] }}
                                    </td>
                                    <td class="td-left">
                                        <div class="d-flex flex-column">
                                            <a class="user_name text-truncate text-body"><span
                                                class="fw-bolder">{{ employeeAttendance['Employee Name'] }} </span></a>
                                        </div>
                                    </td>
                                    <td class="td-center">
                                        {{ employeeAttendance['Department'] }}
                                    </td>
                                    <td class="td-center">
                                        {{ employeeAttendance['Designation'] }}
                                    </td>
                                    <td class="td-center" v-for='date in dateArray'>
                                        {{ employeeAttendance[date] }}
                                    </td>
                                    <td class="td-center">
                                        {{ employeeAttendance['GracePeriod'] }}
                                    </td>
                                    <td class="td-center">
                                        {{ employeeAttendance['LateInstance'] }}
                                    </td>
                                    <!-- Add other date columns here -->
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xls','customAttendance')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" class="btn btn-gradient-info" @click="customAttendancePDF()">PDF
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="exitCustomAttendance()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="att_detail" aria-labelledby="employeehire1Label" tabindex="-1" style="display: none"
             aria-hidden="true">
            <div v-if="daily_att==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Daily Attendance Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input v-model="att_startingdate" type="date" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="att_closingdate" type="date" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All Locations"
                                                 v-model="att_location" :options="options1">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="att_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All Designations"
                                                 v-model="att_designation" :options="options">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>
                                    <select v-model="att_emp_id" class="form-control">
                                        <option value="All">All</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="daily_attendance()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span style="width:80%">Overall Attendance Detail Report </span>
                        </h4>
                        <span class="role-edit-modal"> {{ this.att_startingdate }}-{{ this.att_closingdate }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="daily_attendance1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1400"
                                  filename="Overall_att_Detail"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmloverallattPdf">
                        <div class="modal-body" slot="pdf-content">
                            <div class="table-responsive">
                                <table border="1" class="table tableMain payrollSheetTable"
                                       style="font-family:Arial !important; font-size: 10px !important;margin-bottom:30px;">
                                    <thead>
                                    <tr>
                                        <th>Emp Code</th>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody class="ng-star-inserted">
                                    <tr v-for="att_report1 in attendance_alldata">
                                        <td>{{ att_report1.EmpCode }}</td>
                                        <td>{{ att_report1.Name }}</td>
                                        <td>{{ att_report1.Designation }}</td>
                                        <td>{{ att_report1.Department }}</td>
                                        <td>{{ att_report1.ATTDate }}</td>
                                        <td>{{ att_report1.CheckIN }}</td>
                                        <td>{{ att_report1.CheckOut }}</td>
                                        <td>{{ att_report1.AttStatus }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body">
                        <div class="table-responsive" id="Employees_Overall_Attendance">
                            <table border="1" class="table tableMain payrollSheetTable"
                                   style="font-family:Arial !important; font-size: 10px !important;margin-bottom:30px;">
                                <thead>
                                <tr>
                                    <th>Emp Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody class="ng-star-inserted">
                                <tr v-for="att_report1 in attendance_alldata" v-if="toggle_overallattendance==false">
                                    <td>{{ att_report1.EmpCode }}</td>
                                    <td>{{ att_report1.Name }}</td>
                                    <td>{{ att_report1.Designation }}</td>
                                    <td>{{ att_report1.Department }}</td>
                                    <td>{{ att_report1.ATTDate }}</td>
                                    <td>{{ att_report1.CheckIN }}</td>
                                    <td>{{ att_report1.CheckOut }}</td>
                                    <td>{{ att_report1.AttStatus }}</td>
                                </tr>
                                <tr v-if="toggle_overallattendance==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Overall_Attendance')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" class="btn btn-gradient-info" @click="generateoverallattreport()">Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="daily_attendance1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="att_payroll" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="att_pay==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Attendance Payroll Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="attendance_payroll()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span
                            style="width:80%">Attendance Summary Report</span></h4>
                        <span>Session Name: {{ this.session_name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="attendance_payroll1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1400"
                                  filename="Sessionwise_Payroll_Employee_Attendance"
                                  :pdf-quality="2"
                                  :manual-pagination="true"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmlsessionpayrollPdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <table style="width: 100%;">
                                    <thead class="grid-header">
                                    <tr class="mat-header-row">
                                        <th>Emp. Code</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>T. Days</th>
                                        <th>Presents</th>
                                        <th>Absents</th>
                                        <th>Leaves</th>
                                        <th>Used GP</th>
                                        <th>Overtime</th>
                                        <th>Deduction</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="att_payroll_detail1 in att_payroll_detail">
                                        <td>{{ att_payroll_detail1.EmpCode }}</td>
                                        <td>{{ att_payroll_detail1.Name }}</td>
                                        <td>{{ att_payroll_detail1.Designation }}</td>
                                        <td>{{ att_payroll_detail1.Department }}</td>
                                        <td>{{ att_payroll_detail1.TotalDays }}</td>
                                        <td>{{ att_payroll_detail1.TotalPresent }}</td>
                                        <td>{{ att_payroll_detail1.TotalAbsent }}</td>
                                        <td>{{ att_payroll_detail1.TotalLeave }}</td>
                                        <td>{{ att_payroll_detail1.GP }}</td>
                                        <td>{{ att_payroll_detail1.OT }}</td>
                                        <td>{{ att_payroll_detail1.Deduction }}</td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body">
                        <table style="width: 100%;" id="Employees_Payroll_Attendance">
                            <thead class="grid-header">
                            <tr class="mat-header-row">
                                <th>Emp. Code</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>T. Days</th>
                                <th>Presents</th>
                                <th>Absents</th>
                                <th>Leaves</th>
                                <th>Used GP</th>
                                <th>Overtime</th>
                                <th>Deduction</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="att_payroll_detail1 in att_payroll_detail"
                                v-if="toggle_sessionwiseattendance==false">
                                <td>{{ att_payroll_detail1.EmpCode }}</td>
                                <td>{{ att_payroll_detail1.Name }}</td>
                                <td>{{ att_payroll_detail1.Designation }}</td>
                                <td>{{ att_payroll_detail1.Department }}</td>
                                <td>{{ att_payroll_detail1.TotalDays }}</td>
                                <td>{{ att_payroll_detail1.TotalPresent }}</td>
                                <td>{{ att_payroll_detail1.TotalAbsent }}</td>
                                <td>{{ att_payroll_detail1.TotalLeave }}</td>
                                <td>{{ att_payroll_detail1.GP }}</td>
                                <td>{{ att_payroll_detail1.OT }}</td>
                                <td>{{ att_payroll_detail1.Deduction }}</td>
                            </tr>
                            <tr v-if="toggle_sessionwiseattendance==true">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="loadingio-spinner-bars-0opevbvvjcw">
                                        <div class="ldio-qxxhsg5wen">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Payroll_Attendance')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generatesessionpayrollReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="attendance_payroll1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="att_summary" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="att_sum==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Attendance Summary Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 :options="options5">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="attendance_summary()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span
                            style="width:80%">Attendance Summary Report</span></h4>
                        <span>Session Name: {{ this.session_name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="attendance_summary1()"></button>
                    </div>


                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1400"
                                  filename="Sessionwise_Employee_Attendance"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmlsessionEmpPdf">
                        <table style="width: 100%;" slot="pdf-content">
                            <thead class="grid-header">
                            <tr class="mat-header-row">
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th v-for='attandance_header1 in attandance_header'>
                                    {{ attandance_header1.DT.substring(8, 10) }}
                                </th>
                            </tr>
                            </thead>
                            <tbody v-html="attandance_summary">
                            </tbody>
                        </table>

                    </vue-html2pdf>
                    <div class="modal-body">
                        <table style="width: 100%;" id="Employees_Attendance_Summary">
                            <thead class="grid-header">
                            <tr class="mat-header-row">
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th v-for='attandance_header1 in attandance_header'>
                                    {{ attandance_header1.DT.substring(8, 10) }}
                                </th>
                            </tr>
                            </thead>
                            <tbody v-html="attandance_summary" v-if="toggle_attsummary==false">
                            </tbody>
                            <tbody v-if="toggle_attsummary==true">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="loadingio-spinner-bars-0opevbvvjcw">
                                        <div class="ldio-qxxhsg5wen">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Attendance_Summary')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generatesessionReport()" class="btn btn-gradient-info">Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="attendance_summary1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leave_detail" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="lve_detail==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Employees Leaves Detail Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="l_date_from" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>

                                    <input type="date" v-model="l_date_end" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Leave Type</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All"
                                                 v-model="l_leave_type" :options="options6">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All Locations"
                                                 v-model="l_location" :options="options1">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="l_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All Designations"
                                                 v-model="l_designation" :options="options">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>
                                    <select v-model="l_emp_id" class="form-control">
                                        <option value="All">All</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="leave_detail_() ">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span style="width:80%">Leave Detail Report </span>
                        </h4>
                        <span class="role-edit-modal">{{ this.l_date_from }} - {{ this.l_date_end }} </span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="leave_detail_1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1400"
                                  filename="Leave_Employees"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmlleavedetailEmpPdf">
                        <div class="modal-body" slot="pdf-content">
                            <div class="table-responsive">
                                <table class="table attendancesummaryreport">
                                    <thead style="">
                                    <tr>
                                        <th scope="col">Employee Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">Period</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="getleavedetail1 in getleavedetail">
                                        <td>{{ getleavedetail1.EmployeeCode }}</td>
                                        <td>{{ getleavedetail1.Name }}</td>
                                        <td>{{ getleavedetail1.Designation }}</td>
                                        <td>{{ getleavedetail1.Department }}</td>
                                        <td>{{ getleavedetail1.PostingCity }}</td>
                                        <td>{{ getleavedetail1.Leavetype }}</td>
                                        <td>{{ getleavedetail1.StartDate }}-{{ getleavedetail1.EndDate }}</td>
                                        <td>{{ getleavedetail1.Reason }}</td>
                                        <td>{{ getleavedetail1.HRApproval }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" slot="pdf-content">
                        <div class="table-responsive">
                            <table class="table attendancesummaryreport" id="Employees_Leaves_Detail">
                                <thead style="">
                                <tr>
                                    <th scope="col">Employee Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Leave Type</th>
                                    <th scope="col">Period</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="getleavedetail1 in getleavedetail" v-if="toggle_leaves_summary==false">
                                    <td>{{ getleavedetail1.EmployeeCode }}</td>
                                    <td>{{ getleavedetail1.Name }}</td>
                                    <td>{{ getleavedetail1.Designation }}</td>
                                    <td>{{ getleavedetail1.Department }}</td>
                                    <td>{{ getleavedetail1.PostingCity }}</td>
                                    <td>{{ getleavedetail1.Leavetype }}</td>
                                    <td>{{ getleavedetail1.StartDate }}-{{ getleavedetail1.EndDate }}</td>
                                    <td>{{ getleavedetail1.Reason }}</td>
                                    <td>{{ getleavedetail1.HRApproval }}</td>
                                </tr>
                                <tr v-if="toggle_leaves_summary==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Leaves_Detail')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generateleavedetailReport()" class="btn btn-gradient-info">Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="leave_detail_1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leave_summary" aria-labelledby="employeehire1Label" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div v-if="lve_summary==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Leaves Summary Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Leave Type</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                 id="modalAddCardName" placeholder="All"
                                                 v-model="s_leave_type" :options="options6">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Work Location</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserPlan" placeholder="All Locations"
                                                 v-model="s_location" :options="options1">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Department</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="FilterTransaction" placeholder="All Departments"
                                                 v-model="s_department" :options="options2">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Designation</label>

                                    <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                 id="UserRole" placeholder="All Designations"
                                                 v-model="s_designation" :options="options">
                                    </multiselect>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Employee Id</label>
                                    <select v-model="s_emp_id" class="form-control">
                                        <option value="All">All</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="leave_summary()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:80%"><span style="width:80%">Leave Summary Report </span>
                        </h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="leave_summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
                                  :paginate-elements-by-height="1400"
                                  filename="Emp_Leaves_Detail"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmlleavesummaryEmpPdf">
                        <div class="modal-body" slot="pdf-content">
                            <div class="table-responsive">
                                <table class="table attendancesummaryreport">
                                    <thead style="">
                                    <tr>
                                        <th scope="col">Employee Code</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">Total Leaves</th>
                                        <th scope="col">Remaining Balance</th>

                                    </tr>
                                    </thead>
                                    <tbody v-for="getleavesummary1 in getleavesummary">
                                    <tr>
                                        <td>{{ getleavesummary1.EmployeeCode }}</td>
                                        <td>{{ getleavesummary1.Name }}</td>
                                        <td>{{ getleavesummary1.Designation }}</td>
                                        <td>{{ getleavesummary1.Department }}</td>
                                        <td>{{ getleavesummary1.PostingCity }}</td>
                                        <td>{{ getleavesummary1.LeaveType }}</td>
                                        <td>{{ getleavesummary1.TotalLeave }}</td>
                                        <td>{{ getleavesummary1.RemainingLeave }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </vue-html2pdf>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table attendancesummaryreport" id="Employees_Leaves_Summary">
                                <thead style="">
                                <tr>
                                    <th scope="col">Employee Code</th>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Leave Type</th>
                                    <th scope="col">Total Leaves</th>
                                    <th scope="col">Remaining Balance</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="getleavesummary1 in getleavesummary" v-if="toggle_leaves==false">
                                    <td>{{ getleavesummary1.EmployeeCode }}</td>
                                    <td>{{ getleavesummary1.Name }}</td>
                                    <td>{{ getleavesummary1.Designation }}</td>
                                    <td>{{ getleavesummary1.Department }}</td>
                                    <td>{{ getleavesummary1.PostingCity }}</td>
                                    <td>{{ getleavesummary1.LeaveType }}</td>
                                    <td>{{ getleavesummary1.TotalLeave }}</td>
                                    <td>{{ getleavesummary1.RemainingLeave }}</td>
                                </tr>
                                <tr v-if="toggle_leaves==true">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Employees_Leaves_Summary')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="empleavesummary()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="leave_summary1()">close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ind_att_report" aria-labelledby="ind_att_report" tabindex="-1" style="display: none"
             aria-hidden="true">
            <div v-if="ind_report==''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Session wise Individual Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">


                            <div class="row">

                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Employee Code</label>
                                    <select v-model="ind_emp_id" class="form-control">
                                        <option value="">Select Employee</option>
                                        <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                            {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                        </option>
                                    </select>
                                    <span style="color: #DB4437; font-size: 11px;"
                                          v-if="ind_emp_id==''">{{ e_ind_emp_id }}</span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="ind_attendance_re()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width:60%"><span
                            style="width:60%">Session Wise Indivdual Report </span></h4>
                        <span>Session Name: {{ this.session_name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click="ind_attendance_re1()"></button>
                    </div>

                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="true"
                                  :preview-modal="false"
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
                                  ref="html2Pdf">
                        <div slot="pdf-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h4 class="modal-title" style="width:60%"><span style="width:60%">Session Wise Indivdual Report </span>
                                </h4>
                            </div>
                            <div class="modal-body">

                                <div class="table-responsive">
                                    <table class="" style="width:100%">
                                        <tr>
                                            <td style="width:70%;font-size:bold"><strong>Employee
                                                Code: </strong>{{ att_individual_count.EmployeeCode }}
                                            </td>
                                            <td style="width:30%;font-size:bold"><strong>Total
                                                Days: </strong>{{ att_individual_count.totaldays }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:70%;font-size:bold">
                                                <strong>Name: </strong>{{ att_individual_count.Name }}
                                            </td>
                                            <td style="width:30%;font-size:bold"><strong>Present
                                                Days:</strong>{{ att_individual_count.present }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:70%;font-size:bold">
                                                <strong>Designation: </strong>{{ att_individual_count.Designation }}
                                            </td>
                                            <td style="width:30%;font-size:bold"><strong>Absent
                                                Days: </strong>{{ att_individual_count.absent }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:70%;font-size:bold">
                                                <strong>Department: </strong>{{ att_individual_count.Department }}
                                            </td>
                                            <td style="width:30%;font-size:bold">
                                                <strong>Leaves: </strong>{{ att_individual_count.leaves }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:70%;font-size:bold">
                                                <strong>Location: </strong>{{ att_individual_count.PostingCity }}
                                            </td>
                                            <td style="width:30%;font-size:bold"><strong>Deduction: </strong>__</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <table class="table attendancesummaryreport">
                                        <thead style="">
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">CheckIn</th>
                                            <th scope="col">CheckOut</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="att_individual_report1 in att_individual_report">
                                            <td>{{ att_individual_report1.ATTDate }}</td>
                                            <td>{{ att_individual_report1.CheckIN }}</td>
                                            <td>{{ att_individual_report1.CheckOut }}</td>
                                            <td>{{ att_individual_report1.AttStatus }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Individual_Employees_Attendance">

                        <div class="table-responsive">
                            <table class="" style="width:100%">
                                <tr>
                                    <td rows="2" style="width:70%;font-size:bold"><strong>Employee
                                        Code: </strong>{{ att_individual_count.EmployeeCode }}
                                    </td>
                                    <td rows="2" style="width:30%;font-size:bold"><strong>Total
                                        Days: </strong>{{ att_individual_count.totaldays }}
                                    </td>
                                </tr>
                                <tr>
                                    <td rows="2" style="width:70%;font-size:bold">
                                        <strong>Name: </strong>{{ att_individual_count.Name }}
                                    </td>
                                    <td rows="2" style="width:30%;font-size:bold"><strong>Present
                                        Days:</strong>{{ att_individual_count.present }}
                                    </td>
                                </tr>
                                <tr>
                                    <td rows="2" style="width:70%;font-size:bold">
                                        <strong>Designation: </strong>{{ att_individual_count.Designation }}
                                    </td>
                                    <td rows="2" style="width:30%;font-size:bold"><strong>Absent
                                        Days: </strong>{{ att_individual_count.absent }}
                                    </td>
                                </tr>
                                <tr>
                                    <td rows="2" style="width:70%;font-size:bold">
                                        <strong>Department: </strong>{{ att_individual_count.Department }}
                                    </td>
                                    <td rows="2" style="width:30%;font-size:bold">
                                        <strong>Leaves: </strong>{{ att_individual_count.leaves }}
                                    </td>
                                </tr>
                                <tr>
                                    <td rows="2" style="width:70%;font-size:bold">
                                        <strong>Location: </strong>{{ att_individual_count.PostingCity }}
                                    </td>
                                    <td rows="2" style="width:30%;font-size:bold"><strong>Deduction: </strong>__</td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table attendancesummaryreport">
                                <thead style="">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">CheckIn</th>
                                    <th scope="col">CheckOut</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="att_individual_report1 in att_individual_report"
                                    v-if="toggle_indattendance==false">
                                    <td>{{ att_individual_report1.ATTDate }}</td>
                                    <td>{{ att_individual_report1.CheckIN }}</td>
                                    <td>{{ att_individual_report1.CheckOut }}</td>
                                    <td>{{ att_individual_report1.AttStatus }}</td>
                                </tr>
                                <tr v-if="toggle_indattendance==true">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>


                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx','Individual_Employees_Attendance')"
                                class="btn btn-gradient-info">Excel
                        </button>
                        <button type="button" @click="generateReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal"
                                @click="ind_attendance_re1()">close
                        </button>
                    </div>


                </div>
            </div>
        </div>
        <div class="modal fade" id="employeesalary" aria-labelledby="employeesalarylabel" tabindex="-1"
             style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Departmentwise Session Salary Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                    </div>
                    <div class="modal-footer">
                        <a target="_blank" v-bind:href="`salary_report/`" class="btn btn-primary">
                            View Report
                        </a>

                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
import axios from 'axios'
import VueHtml2pdf from 'vue-html2pdf'
import Multiselect from 'vue-multiselect'

export default {
    data() {
        return {
            page: 'a4',
            pixel: '1122',
            employeesForAttendance: null,
            isEmployeesCustomAttendance: false,
            registeredEmployees: {},
            att_date: new Date().toISOString().substr(0, 10),
            dateRange: {
                startDate: new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().substr(0, 10),
                endDate: new Date().toISOString().substr(0, 10),
            },

            employeesCustomAttendance: {},
            dateArray: {},

            sal_status: 'All',
            toggle_absent_summary: true,
            optionssal_status: ['All', 'Paid', 'Unpaid'],
            toggle_sessionwiseattendance: true,
            session_date: '',
            abs_location: 'All',
            abs_department: 'All',
            abs_designation: 'All',
            abs_emp_id: 'All',
            absent_detail: {},
            session_name: '',
            lve_summary: '',
            lve_detail: '',
            att_sum: '',

            emp_user_sa: 'All',
            optionsusername: ['All', 'muhammad.kamran@sagardens.net', 'husnain.malik@sagardens.net', 'hira@sagardens.net'],
            toggle_employeehire: true,
            loan_advance_report: '',
            arrears_start_date: '',
            e_arrears_start_date: '',
            arrears_end_date: '',
            e_arrears_end_date: '',
            arrears_dept: 'All',
            arrear_lts: {},
            toggle_arrears: true,


            la_start_date: '',
            e_la_start_date: '',
            la_end_date: '',
            e_la_end_date: '',
            la_dept: 'All',
            la_type: 'All',
            la_status: 'All',
            la_list: {},
            optionstype: ['Loan', 'Advance'],
            optionstatus: ['Paid', 'Pending'],


            emp_detail: '',
            emp_hire: '',
            emp_appraisal: '',
            abs_summary: '',
            daily_att: '',
            test: '',
            ind_report: '',
            toggle_employee_detail: true,
            hiring_employee_report: '',
            hiring_start_date: '',
            e_hiring_start_date: '',
            e_hiring_end_date: '',
            hiring_end_date: '',
            hiring_dept: 'All',
            hiring_list: {},
            getemployeegetpayrollcashsum: 0,
            att_department: 'All',
            custom_att_department: 'All',
            att_startingdate: '',
            att_closingdate: '',
            att_designation: 'All',
            toggle_payroll_distribution: true,
            att_location: 'All',
            att_emp_id: 'All',
            attendance_alldata: {},
            att_report: {},
            attandance_summary: '',
            attandance_header: {},
            find_emp: {},
            locations: {},
            toggle_indattendance: true,
            designations: {},
            departments: {},
            ind_emp_id: '',
            att_individual_report: {},
            att_individual_count: {},
            absent_to: '',
            absent_from: '',
            toggle_loan_advance: true,
            getemployee: {},
            emp_department: 'All',
            emp_location: 'All',
            toggle_attsummary: true,
            emp_designation: 'All',
            emp_emp_id: 'All',
            emp_type: 'All',
            emp_status: 'All',
            hire_department: 'All',
            hire_location: 'All',
            hire_designation: 'All',
            hire_emp_id: 'All',
            toggle_leaves: true,
            hire_start_date: '',
            hire_end_date: '',
            gethireemplo: {},
            gethireemplocount: '',
            e_ind_emp_id: '',
            toggle_leaves_summary: true,
            options: [],
            options1: [],
            options2: [],
            options4: ["All", "Registered", "Terminated", "Suspended", "Resigned"],
            options3: ["All", "Permanent", "Probation", "Contract"],
            options5: ["All"],
            options6: [],
            emp_cash_distribution: '',
            dist_session: '',
            e_dist_session: '',
            optionssession: [],
            dist_session_list: {},
            sess_dist_list: {},
            sess_dist_sum: 0,
            sess_dist_sum1: 0,
            toggle_overallattendance: true,
            l_date_from: '',
            l_date_end: '',
            l_leave_type: 'All',
            l_department: 'All',
            l_location: 'All',
            l_designation: 'All',
            l_emp_id: 'All',
            getleavedetail: {},
            leaves: {},
            getleavesummary: {},
            s_leave_type: 'All',
            s_department: 'All',
            s_location: 'All',
            s_designation: 'All',
            s_emp_id: 'All',


            emp_arrears_report: '',


            att_pay: '',
            att_payroll_detail: {},
            emp_cash: '',
            emp_username: 'All',
            getemployeecash: {},
            getemployeecashsum: '',
            getemployeecashsum1: '',


            htmlToPdfOptions: {
                margin: 0,

                filename: `hehehe.pdf`,

                image: {
                    type: 'jpeg',
                    quality: 0.98
                },

                enableLinks: false,

                html2canvas: {
                    scale: 1,
                    useCORS: true
                },

                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            },
        }

    },
    components: {
        VueHtml2pdf,
        Multiselect,
        DateRangePicker
    },
    methods: {
        custom_attendance() {
            const startDate = new Date(this.dateRange.startDate);
            const formattedStartDate = `${startDate.getFullYear()}-${(startDate.getMonth() + 1).toString().padStart(2, '0')}-${startDate.getDate().toString().padStart(2, '0')}`;

            const endDate = new Date(this.dateRange.endDate);
            const formattedEndDate = `${endDate.getFullYear()}-${(endDate.getMonth() + 1).toString().padStart(2, '0')}-${endDate.getDate().toString().padStart(2, '0')}`;
//
            const dateArray = [];
            let currentDate = new Date(startDate);
            while (currentDate <= endDate) {
                // Format the current date as "YYYY-MM-DD" and push it to the array
                const formattedDate = `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${currentDate.getDate().toString().padStart(2, '0')}`;
                dateArray.push(formattedDate);

                // Move to the next day
                currentDate.setDate(currentDate.getDate() + 1);
            }
            this.dateArray = dateArray;
            axios.post("custom_attendance", {
                startdate: formattedStartDate,
                enddate: formattedEndDate,
                department_name: this.custom_att_department,
                employees: this.employeesForAttendance,
            })
                .then((data) => {
                    this.isEmployeesCustomAttendance = true;
                    this.employeesCustomAttendance = data.data;
                    if (this.dateArray.length > 0 && this.dateArray.length <= 6) {
                        this.page = 'a4';
                        this.pixel = '1122';
                    }
                    else if (this.dateArray.length > 6 && this.dateArray.length <= 11) {
                        this.page = 'a3';
                        this.pixel = '1587';
                    }
                    else if (this.dateArray.length > 11 && this.dateArray.length <= 18) {
                        this.page = 'a2';
                        this.pixel = '2245';
                    }
                    else if (this.dateArray.length > 18 && this.dateArray.length <= 24) {
                        this.page = 'a1';
                        this.pixel = '3178';
                    }
                    else if (this.dateArray.length > 24) {
                        this.page = 'a0';
                        this.pixel = '4078';
                    }
                })
        },

        customAttendancePDF() {
            this.$refs.customAttendancePDF.generatePdf()
        },

        exitCustomAttendance() {
            this.isEmployeesCustomAttendance = false;
            this.dateRange.startDate = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().substr(0, 10);
            this.dateRange.endDate =  new Date().toISOString().substr(0, 10);

            this.employeesForAttendance = null;
            this.isEmployeesCustomAttendance = false;
            this.custom_att_department = 'All';
            this.page = 'a4';
            this.pixel = '1122';
        },

        view_report9() {
            this.getemployeecashdetail();
            this.getemployeegetcashsum1();
        },
        view_report91() {
            this.toggle_payroll_distribution = true
            this.emp_cash = '';
            this.getemployeecash = {};
            this.getemployeecashsum = '';
            this.emp_department = 'All';
            this.emp_username = 'All';
            this.emp_user_sa = 'All';
            this.sal_status = 'All';
            this.dist_session = ''
        },
        getemployeecashdetail() {
            if (this.dist_session == '') {
                this.$toastr.e("Please Select Required Field", "Error!");
                this.e_dist_session = 'Select session'
            } else {
                this.emp_cash = 1;
                axios.get('./getemploycashdetail/' + this.emp_department + '/' + this.emp_user_sa + '/' + this.dist_session + '/' + this.sal_status)
                    .then(response => {
                        this.toggle_payroll_distribution = false
                        this.getemployeecash = response.data.data;
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting  employee cash details ');
                    });
            }

        },
        getemployeegetcashsum1() {
            if (this.dist_session == '') {
                this.e_dist_session = 'Select session'
            } else {
                axios.get('./getemployeecashsum/' + this.emp_department + '/' + this.emp_user_sa + '/' + this.dist_session + '/' + this.sal_status)
                    .then(response => {
                        this.getemployeegetpayrollcashsum = response.data.data;
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting  employee cash sum ');
                    });
                axios.get('./getemployeebanksum/' + this.emp_department + '/' + this.emp_user_sa + '/' + this.dist_session + '/' + this.sal_status)
                    .then(response => {
                        this.getemployeecashsum1 = response.data.data;
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting  employee bank sum ');
                    });
            }

        },
        generatesessionpayrollReport() {
            this.$refs.htmlsessionpayrollPdf.generatePdf()
        },
        empabsentpdfreport() {
            this.$refs.htmlempabsentPdf.generatePdf()
        },
        htmlemphirereport() {
            this.$refs.htmlemphirePdf.generatePdf()
        },
        generateReport() {
            this.$refs.html2Pdf.generatePdf()
        },
        generatesessionReport() {
            this.$refs.htmlsessionEmpPdf.generatePdf()
        },


        generateempdetailReport() {
            this.$refs.htmlempdetailPdf.generatePdf()
        },
        generateleavedetailReport() {
            this.$refs.htmlleavedetailEmpPdf.generatePdf()
        },
        empleavesummary() {
            this.$refs.htmlleavesummaryEmpPdf.generatePdf()
        },
        generateEmployeeHiringReport() {
            this.$refs.hiringpdf.generatePdf()
        },
        generateLoanAdvanceReport() {
            this.$refs.loanadvancepdf.generatePdf()
        },
        generateArrearsReport() {
            this.$refs.arrearspdf.generatePdf()
        },

        generateoverallattreport() {
            this.$refs.htmloverallattPdf.generatePdf()
        },
        getemployeedetail() {
            axios.get('./getemploydetail/' + this.emp_department + '/' + this.emp_location + '/' + this.emp_designation + '/' + this.emp_emp_id + '/' + this.emp_type + '/' + this.emp_status)
                .then(response => {
                    this.toggle_employee_detail = false
                    this.getemployee = response.data.data;

                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting  employee details report ');
                });
        },
        view_report() {
            this.emp_detail = 1;
            this.getemployeedetail();
        },

        view_report1() {
            this.toggle_employee_detail = true
            this.getemployee = {};
            this.emp_detail = '';
            this.emp_department = 'All';
            this.emp_location = 'All';
            this.emp_designation = 'All';
            this.emp_emp_id = 'All';
            this.emp_type = 'All';
            this.emp_status = 'All';
        },
        getleave_summary() {
            axios.get('./filter_leaves1/' + this.s_department + '/' + this.s_location + '/' + this.s_designation + '/' + this.s_emp_id + '/' + this.s_leave_type)
                .then(response => {
                    this.toggle_leaves = false
                    this.getleavesummary = response.data.data;

                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting leaves summary report');
                });
        },
        hiring_rep() {
            if (this.hiring_start_date == '' || this.hiring_end_date == '') {
                this.$toastr.e("Please Select Compulsory Field", "Caution!");
                if (this.hiring_start_date == '') {
                    this.e_hiring_start_date = "Please Select Start Date";
                }
                if (this.hiring_end_date == '') {
                    this.e_hiring_end_date = "Please Select End Date";
                }


            } else {
                this.hiring_employee_report = 1
                axios.get('employee_hiring_report/' + this.hiring_start_date + '/' + this.hiring_end_date + '/' + this.hiring_dept)
                    .then((response) => {
                        this.hiring_list = response.data
                    })
            }
        },
        arrears_report1() {
            this.toggle_arrears = true
            this.emp_arrears_report = ''
            this.arrear_lts = {}
            this.arrears_start_date = ''
            this.arrears_end_date = ''
            this.arrears_dept = 'All'
        },
        arrears_report() {
            const validation = this.$helpers.validateDateRange(this.arrears_start_date, this.arrears_end_date);
            if (!validation.isValid) {
                this.$toastr.e(validation.error, "Caution!");

                if (this.arrears_start_date == '') {
                    this.e_arrears_start_date = "Please Select Start Date";
                }
                if (this.arrears_end_date == '') {
                    this.e_arrears_end_date = "Please Select End Date";
                }


            } else {
                this.emp_arrears_report = 1
                axios.get('arrears_report/' + this.arrears_start_date + '/' + this.arrears_end_date + '/' + this.arrears_dept)
                    .then((response) => {
                        this.la_list = response.data.data;
                        this.toggle_arrears = false
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting arrears report ');
                    });
            }
        },
        la_report() {
            const validation = this.$helpers.validateDateRange(this.la_start_date, this.la_end_date);
            if (!validation.isValid) {
                this.$toastr.e(validation.error, "Caution!");

                if (this.la_start_date == '') {
                    this.e_la_start_date = "Please Select Start Date";
                }
                if (this.la_end_date == '') {
                    this.e_la_end_date = "Please Select End Date";
                }


            } else {
                this.loan_advance_report = 1
                axios.get('loan_advance_report/' + this.la_start_date + '/' + this.la_end_date + '/' + this.la_dept + '/' + this.la_type + '/' + this.la_status)
                    .then((response) => {
                        this.toggle_loan_advance = false
                        this.la_list = response.data.data
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting loan advance report ');
                    });
            }
        },
        hiring_rep1() {
            this.hiring_employee_report = ''
            this.hiring_start_date = ''
            this.hiring_end_date = ''
            this.hiring_dept = 'All'
        },
        la_report1() {
            this.toggle_loan_advance = true
            this.loan_advance_report = ''
            this.la_start_date = ''
            this.la_end_date = ''
            this.la_dept = 'All'
            this.la_type = 'All'
            this.la_status = 'All'
        },
        getleave_detail() {
            axios.get('./getleaveemploy/' + this.l_department + '/' + this.l_location + '/' + this.l_designation + '/' + this.l_emp_id + '/' + this.l_date_from + '/' + this.l_date_end + '/' + this.l_leave_type)
                .then(response => {
                    this.getleavedetail = response.data.data;
                    this.toggle_leaves_summary = false
                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting Leaves detailo report ');
                });
        },
        gethireemployee() {
            axios.get('./gethireemploy/' + this.hire_department + '/' + this.hire_location + '/' + this.hire_designation + '/' + this.hire_emp_id + '/' + this.hire_start_date + '/' + this.hire_end_date)
                .then(response => {
                    this.toggle_employeehire = false
                    this.gethireemplo = response.data.data;

                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting registered employee');
                });
            axios.get('./gethireemploycount/' + this.hire_department + '/' + this.hire_location + '/' + this.hire_designation + '/' + this.hire_emp_id + '/' + this.hire_start_date + '/' + this.hire_end_date)
                .then(response => {
                    this.gethireemplocount = response.data.data;

                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting registered employee count ');
                });


        },
        employee_hire_report() {
            const validation = this.$helpers.validateDateRange(this.hire_start_date, this.hire_end_date);
            if (!validation.isValid) {
                this.$toastr.e(validation.error, "Caution!");

            } else {
                this.gethireemployee();
                this.emp_hire = 1;
            }


        },
        cdist_report1() {
            this.dist_session = ''
            this.emp_cash_distribution = ''
        },
        cdist_report() {
            if (this.dist_session == '') {
                this.$toastr.e("Please Select Required Field", "Error!");
                this.e_dist_session = 'Select session'
            } else {
                this.emp_cash_distribution = 1
                axios.get("session_wise_cashdistribution/" + this.dist_session + '/' + this.emp_location)
                    .then((response) => {
                        this.sess_dist_list = response.data
                    })
                axios.get("session_wise_cashdistribution_count/" + this.dist_session + '/' + this.emp_location)
                    .then((response) => {
                        this.sess_dist_sum = response.data
                    })
                axios.get("session_wise_bankdistribution_count/" + this.dist_session + '/' + this.emp_location)
                    .then((response) => {
                        this.sess_dist_sum1 = response.data
                    })
            }
        },
        employee_hire_report1() {
            this.toggle_employeehire = true
            this.emp_hire = '';
            this.hire_department = 'All';
            this.hire_location = 'All';
            this.hire_designation = 'All';
            this.hire_emp_id = 'All';
            this.hire_start_date = '';
            this.hire_end_date = '';
            this.gethireemplo = {};
            this.gethireemplocount = '';
        },
        employee_appraisal_report() {
            this.emp_appraisal = 1;
        },
        employee_appraisal_report1() {
            this.emp_appraisal = '';
        },
        attendance_payroll() {
            this.att_pay = 1;
            this.getpayrollreport();
        },
        attendance_payroll1() {
            this.att_pay = '';
            this.toggle_sessionwiseattendance = true
        },
        absent_summary() {

            const validation = this.$helpers.validateDateRange(this.absent_from, this.absent_to);
            if (!validation.isValid) {
                this.$toastr.e(validation.error, "Caution!");
            } else {
                this.abs_summary = 1;
                axios.get('./get_absent_detail/' + this.absent_from + '/' + this.absent_to + '/' + this.abs_location + '/' + this.abs_department + '/' + this.abs_designation + '/' + this.abs_emp_id)
                    .then(response => {
                        this.toggle_absent_summary = false
                        this.absent_detail = response.data.data;
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting absent report ');
                    });
            }
        },
        absent_summary1() {
            this.toggle_absent_summary = true
            this.abs_summary = '';
            this.absent_to = '';
            this.absent_from = '';
            this.abs_location = 'All';
            this.abs_department = 'All';
            this.abs_designation = 'All';
            this.abs_emp_id = 'All';
            this.absent_detail = {};
        },
        daily_attendance() {
            const validation = this.$helpers.validateDateRange(this.att_startingdate, this.att_closingdate);
            if (!validation.isValid) {
                this.$toastr.e(validation.error, "Caution!");

            } else {
                this.daily_att = 1;
                this.getdailyattendancereport();
            }


        },


        daily_attendance1() {
            this.toggle_overallattendance = true
            this.daily_att = '';
            this.att_department = 'All';
            this.att_startingdate = '';
            this.att_closingdate = '';
            this.att_location = 'All';
            this.att_designation = 'All';
            this.att_emp_id = 'All';
            this.att_report = {};

        },
        attendance_summary() {
            this.att_sum = 1;
            this.getattendance_summary();
        },
        attendance_summary1() {
            this.att_sum = '';
            this.toggle_attsummary = true
            this.attandance_summary = '';
        },
        leave_detail_() {
            const validation = this.$helpers.validateDateRange(this.l_date_from, this.l_date_end);
            if (!validation.isValid) {
                this.$toastr.e(validation.error, "Caution!");

            } else {
                this.getleave_detail();
                this.lve_detail = 1;
            }

        },
        leave_detail_1() {
            this.toggle_leaves_summary = true
            this.lve_detail = '';
            this.l_date_from = '';
            this.l_date_end = '';
            this.l_leave_type = 'All';
            this.l_department = 'All';
            this.l_location = 'All';
            this.l_designation = 'All';
            this.l_emp_id = 'All';
            this.getleavedetail = {};
        },
        leave_summary() {

            if (this.s_leave_type == 'All') {
                this.$toastr.e("Please Select Leave Type First", "Error!");
            } else {
                this.getleave_summary();
                this.lve_summary = 1;
            }
        },
        leave_summary1() {
            this.toggle_leaves = true
            this.lve_summary = '';
            this.getleavesummary = {};
            this.s_leave_type = 'All';
            this.s_department = 'All';
            this.s_location = 'All';
            this.s_designation = 'All';
            this.s_emp_id = 'All';
        },
        ind_attendance_re() {

            ind_emp_id: '';

            this.getindattendance();

        },
        ind_attendance_re1() {
            this.toggle_indattendance = true
            this.ind_report = '';
            this.att_individual_report = {};
            this.att_individual_count = {};
        },
        test1() {
            this.test = 1;
        },
        getindattendance() {
            if (this.ind_emp_id == '') {
                this.e_ind_emp_id = 'Select Employee Code'
                this.$toastr.e("Some fields are empty", "Error!");

            } else {
                this.ind_report = 1;
                axios.get('./getindatt_count/' + this.ind_emp_id)
                    .then(response => {

                        this.att_individual_count = response.data.data;
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting  attendence count');
                    });


                axios.get('./getindatt_report/' + this.ind_emp_id)
                    .then(response => {
                        this.toggle_indattendance = false
                        this.att_individual_report = response.data.data;

                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while getting  ind attendence  report');
                    });
            }


        },
        getdailyattendancereport() {
            axios.get('./getattendance_report/' + this.att_department + '/' + this.att_location + '/' + this.att_designation + '/' + this.att_emp_id + '/' + this.att_startingdate + '/' + this.att_closingdate)
                .then(response => {
                    this.toggle_overallattendance = false
                    this.att_report = response.data.data;
                    this.attendance_alldata = response.data.data;

                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting attendence report ');
                });
        },
        getattendance_summary() {

            axios.get('./getattendance_summary/')
                .then(response => {
                    this.toggle_attsummary = false
                    this.attandance_summary = response.data.data;

                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting  attendence summary');
                });

            axios.get('./get_column_name')
                .then(response => {
                    this.attandance_header = response.data.data;
                })
        },
        getpayrollreport() {
            axios.get('./get_payroll_att_detail/')
                .then(response => {
                    this.toggle_sessionwiseattendance = false
                    this.att_payroll_detail = response.data.data;
                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting  payroll report');
                });
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
        async fetchLocations() {
            try {
                this.locations = await this.$helpers.checkLocal('overall_location');
                this.options1 = [];
                var $this = this;
                for (var i = 0; i < $this.locations.length; i++) {
                    this.options1.push($this.locations[i].location_name);
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
        this.fetchLocations()
        this.fetchDesignation()
        axios.get('overall_employees')
            .then(response => {
                let employees_detail = response.data;
                this.registeredEmployees = [];
                this.registeredEmployees = employees_detail.map((emp) => ({
                    id: emp.EmployeeID,
                    label: `${emp.EmployeeCode}, ${emp.Name}`,
                }));
            })

    

        let pdfJS = document.createElement('script')
        pdfJS.setAttribute('src', 'https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js')
        document.head.appendChild(pdfJS)

        axios.get('department_detail2')
            .then(data => {
                this.departments = data.data
                this.options2 = [];

                var $this = this;
                for (var i = 0; i < $this.departments.length; i++) {
                    this.options2.push($this.departments[i].department_name);
                }
            })
            .catch(error => {
            });
        axios.get('session_detail_dist')
            .then(data => {
                this.dist_session_list = data.data
                this.optionssession = [];

                var $this = this;
                for (var i = 0; i < $this.dist_session_list.length; i++) {
                    this.optionssession.push($this.dist_session_list[i].SessionName);
                }
            })

        axios.get('find_emp_id')
            .then(data => this.find_emp = data.data.data)
            .catch(error => {
            });

        axios.get('overall_leaves')
            .then(response => {
                this.leaves = response.data.data
                this.options6 = [];

                var $this = this;
                for (var i = 0; i < $this.leaves.length; i++) {
                    this.options6.push($this.leaves[i].LeaveType);
                }
            })
            .catch(error => {
            });

        axios.get('find_session')
            .then(response => {
                this.session_name = response.data;
            })
    

    }


}

</script>
<style scoped>

@keyframes ldio-qxxhsg5wen {
    0% {
        opacity: 1
    }
    50% {
        opacity: .5
    }
    100% {
        opacity: 1
    }
}

.ldio-qxxhsg5wen div {
    position: absolute;
    width: 20px;
    height: 80px;
    top: 60px;
    animation: ldio-qxxhsg5wen 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.ldio-qxxhsg5wen div:nth-child(1) {
    transform: translate(30px, 0);
    background: #e15b64;
    animation-delay: -0.6s;
}

.ldio-qxxhsg5wen div:nth-child(2) {
    transform: translate(70px, 0);
    background: #f47e60;
    animation-delay: -0.4s;
}

.ldio-qxxhsg5wen div:nth-child(3) {
    transform: translate(110px, 0);
    background: #f8b26a;
    animation-delay: -0.2s;
}

.ldio-qxxhsg5wen div:nth-child(4) {
    transform: translate(150px, 0);
    background: #abbd81;
    animation-delay: -1s;
}

.loadingio-spinner-bars-0opevbvvjcw {
    width: 200px;
    height: 200px;
    display: inline-block;
    overflow: hidden;
    background: #ffffff;
}

.ldio-qxxhsg5wen {
    width: 100%;
    height: 100%;
    position: relative;
    transform: translateZ(0) scale(1);
    backface-visibility: hidden;
    transform-origin: 0 0; /* see note above */
}

.reports-th-center {
    z-index: 1;
    position: sticky;
    top: 0px !important;
    text-align: center;
    vertical-align: middle !important;
}

.reports-th-left {
    z-index: 1;
    position: sticky;
    top: 94px;
    text-align: left;
    vertical-align: middle !important;
}

.ldio-qxxhsg5wen div {
    box-sizing: content-box;
}

/* generated by https://loading.io/ */
.ng-star-inserted > a {
    cursor: pointer;
    border-bottom: 1px dashed #ccc;
    padding-top: 5px;
    padding-bottom: 5px;
    display: block;
    max-width: 250px;
    margin-left: 20px;
    color: #2485e8;
    text-decoration: none;
}

.mt-HeaderDialouge .table-responsive {
    height: calc(80vh - 100px);
    overflow-y: auto;
}
</style>
