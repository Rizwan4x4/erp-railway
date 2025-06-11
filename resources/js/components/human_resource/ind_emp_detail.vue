<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/" style="text-decoration: none;">Employee Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                Personal Profile
                            </li>
                        </ol>
                        <!-- <b-progress
                            animated show-progress max="100" class="mb-3"
                            :value="percent[0].profile_completion"
                            variant="success"
                            :label="`${percent[0].profile_completion}`">
                        </b-progress> -->
                    </div>
                </div>
                <div class="content-body">
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
                                                <img v-if="emp_detail1.Photo == ''" class="img-fluid rounded mt-3 mb-2"
                                                    src="public/images/profile_images/pro.png" height="110" width="110"
                                                    alt="User avatar" />
                                                <img v-else class="img-fluid rounded mt-3 mb-2"
                                                    v-bind:src="`public/images/profile_images/${emp_detail1.Photo}`"
                                                    height="110" width="110" alt="User avatar" />
                                                <div class="user-info text-center">
                                                    <h4>{{ emp_detail1.Name }}</h4>
                                                    <span class="badge bg-light-secondary">{{ emp_detail1.Designation
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around my-2 pt-75">
                                            <div class="d-flex align-items-start me-2">
                                                <span class="badge bg-light-primary p-75 rounded">

                                                    <i class="font-medium-2 fa-solid fa-check"
                                                        style="margin-right: 5px"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <h4 class="mb-0" v-if="com_year != ''">{{ com_year }}</h4>
                                                    <h4 class="mb-0" v-else>0</h4>
                                                    <small>Year<label v-if="com_year > '1'">s</label> Completed</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <span class="badge bg-light-primary p-75 rounded">
                                                    <i class="fa-solid fa-bars-progress font-medium-2"
                                                        style="margin-right: 5px"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <h4 class="mb-0">
                                                        {{ percent.address + percent.city + percent.cnic +
                                                            percent.company_email + percent.department + percent.designation
                                                            + percent.dob + percent.edu_status + percent.email +
                                                        percent.emp_code + percent.exp_status + percent.father +
                                                        percent.gender + percent.job_des + percent.marital +
                                                        percent.mobile + percent.photo + percent.reporting }}%</h4>
                                                    <small>Profile Completed</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Personel Details</h4>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Father<span
                                                            v-if="emp_detail1.Gender != 'Male' || emp_detail1.MaritalStatus != 'Single'">/Husband</span>
                                                        Name:</span>
                                                    <span>{{ emp_detail1.FatherHusband }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Email:</span>
                                                    <span>{{ emp_detail1.Email }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Date Of Birth:</span>
                                                    <span>{{ emp_detail1.DOB }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Gender:</span>
                                                    <span>{{ emp_detail1.Gender }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Religion:</span>
                                                    <span>{{ emp_detail1.Religion }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Contact:</span>
                                                    <span>{{ emp_detail1.Mobile }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">City:</span>
                                                    <span>{{ emp_detail1.City }}</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Country:</span>
                                                    <span>Pakistan</span>
                                                </li>
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Status:</span>
                                                    <span class="badge bg-light-success">{{ emp_detail1.Status }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                                <!-- Plan Card -->
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div v-if="emp_detail1.Salary != null && emp_detail1.Salary != 0"
                                            class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-primary">Salary</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-primary mt-1 mb-0">Rs.</sup>
                                                <span class="fw-bolder display-5 mb-0 text-primary"
                                                    style="font-size:18px">{{
                                                    Math.floor(emp_detail1.Salary).toLocaleString() }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                            </div>
                                        </div>
                                        <div v-if="allowance > '0'"
                                            class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-secondary">Allowance</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-secondary mt-1 mb-0">Rs.</sup>
                                                <span class="fw-bolder display-5 mb-0 text-secondary"
                                                    style="font-size:18px">{{ Math.floor(allowance).toLocaleString()
                                                    }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                            </div>
                                        </div>
                                        <div v-if="stipend != '0'"
                                            class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-success">Stipend</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-success mt-1 mb-0">Rs.</sup>
                                                <span class="fw-bolder display-5 mb-0 text-success"
                                                    style="font-size:18px">{{ Math.floor(stipend).toLocaleString()
                                                    }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                            </div>
                                        </div>
                                        <div v-if="com_year > '1'"
                                            class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-danger">Gratuity</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-danger mt-1 mb-0">Rs.</sup>
                                                <span class="fw-bolder display-5 mb-0 text-danger"
                                                    style="font-size:18px">{{ Math.floor((com_year - 1) *
                                                    emp_detail1.Salary).toLocaleString() }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/career</sub>
                                            </div>
                                        </div>
                                        <div style="font-size:18px;margin-top:20px">
                                            <span class="fw-bolder display-5 mb-0 text-primary"
                                                style="font-size:18px">Job Description</span>
                                        </div>
                                        <label v-html='emp_detail1.JobDescription'></label>
                                    </div>
                                </div>
                                <!-- /Plan Card -->
                            </div>
                            <!--/ User Sidebar -->
                            <!-- User Content -->
                            <!-- User Pills -->
                            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                                <div>
                                    <ul class="nav nav-pills mb-2" style="padding-left:20px !important">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="empdetails-tab" data-bs-toggle="tab"
                                                role="tab" href="#empdetails" aria-selected="true">
                                                <i class="fa-solid fa-briefcase"></i>
                                                <span class="fw-bold">Employment</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="empLeaves-tab" data-bs-toggle="tab" role="tab"
                                                href="#empLeaves" aria-selected="true">
                                                <i class="fa-solid fa-person-skiing-nordic"></i>
                                                <span class="fw-bold">Leaves</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="empAttendance-tab" data-bs-toggle="tab" role="tab"
                                                href="#empAttendance" aria-selected="true">
                                                <i class="fa-solid fa-calendar-days"></i>
                                                <span class="fw-bold">Attendance</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="empFinancialHistory-tab" data-bs-toggle="tab"
                                                role="tab" href="#empFinancialHistory" aria-selected="true">
                                                <i class="fa-solid fa-coins"></i>
                                                <span class="fw-bold">Financial History</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!--/ User Pills -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="empdetails" aria-labelledby="empdetails-tab"
                                        role="tabpanel">
                                        <div v-for='emp_detail1 in emp_detail' class="card">
                                            <div class="card-header">
                                                <div style="float:left">
                                                    <h4 class="card-title mb-50">Employment Details</h4>
                                                </div>
                                                <div style="float:right">
                                                    <a title="You cannot change format"
                                                        v-if="percent.address + percent.city + percent.cnic + percent.company_email + percent.department + percent.designation + percent.dob + percent.edu_status + percent.email + percent.emp_code + percent.exp_status + percent.father + percent.gender + percent.job_des + percent.marital + percent.mobile + percent.photo + percent.reporting > 89"
                                                        target="_blank"
                                                        v-bind:href="`${url_s2}/cv_builder/${emp_detail1.EmployeeID}/${emp_detail1.EmployeeCode}/${emp_detail1.RegisterID}`"
                                                        class="btn btn-primary btn-sm edit-address waves-effect waves-float waves-light">CV
                                                        Builder</a>
                                                    <a title="Please complete your Profile upto 90%" v-else
                                                        target="_blank" href="#"
                                                        class="btn btn-primary btn-sm edit-address waves-effect waves-float waves-light">Build
                                                        CV</a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-12">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-6 fw-bolder mb-1">Employee Code:</dt>
                                                            <dd class="col-sm-6 mb-1">{{ emp_detail1.EmployeeCode }}
                                                            </dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Reporting To:</dt>
                                                            <dd class="col-sm-6 mb-1">
                                                                <label>
                                                                    {{ rep_employees.rep1 }}
                                                                </label>
                                                            </dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Posting City:</dt>
                                                            <dd class="col-sm-6 mb-1">{{ emp_detail1.PostingCity }}</dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Com. Email:</dt>
                                                            <dd class="col-sm-6 mb-1">{{ emp_detail1.CompanyEmail }}
                                                            </dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">CNIC:</dt>
                                                            <dd class="col-sm-6 mb-1">{{ emp_detail1.CNIC }}</dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Job Shift:</dt>
                                                            <dd class="col-sm-6 mb-1">{{ emp_detail1.JobShift }}</dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Relation:</dt>
                                                            <dd class="col-sm-6 mb-1">{{ emp_detail1.Relation }}</dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Send Notification:</dt>
                                                            <dd v-if="emp_detail1.SendNotification == 1"
                                                                class="col-sm-6 mb-1">Allow
                                                            </dd>
                                                            <dd v-else class="col-sm-6 mb-1">Not Allow</dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Eportal Access:</dt>
                                                            <dd v-if="emp_detail1.EportalAccess == 1"
                                                                class="col-sm-6 mb-1">Allow
                                                            </dd>
                                                            <dd v-else class="col-sm-6 mb-1">Not Allow</dd>
                                                            <dt class="col-sm-6 fw-bolder mb-1">Team Attendance:</dt>
                                                            <dd v-if="emp_detail1.AllowEmployeesAttendance == 1"
                                                                class="col-sm-6 mb-1">Yes
                                                            </dd>
                                                            <dd v-else class="col-sm-6 mb-1">No</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-xl-6 col-12">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-5 fw-bolder mb-1">Department:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.Department }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Second Rep. To:</dt>
                                                            <dd class="col-sm-7 mb-1">
                                                                <label>
                                                                    {{ rep_employees.rep2 }}
                                                                </label>
                                                            </dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Joining Date:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.JoiningDate }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Probation End:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.ProbationEnd }}
                                                            </dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Blood Group:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.BloodGroup }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">CNIC Expiry:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.CnicExpiry }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Job Status:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.JobStatus }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Phone Number:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.Phone }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Complete Address:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.Address }},
                                                                {{ emp_detail1.City }}
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Project table -->
                                        <div class="card">
                                            <h4 class="card-header">Qualification List</h4>
                                            <div class="table-responsive" v-if="edu_detail != ''">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Institute Name</th>
                                                            <th>Degree Type</th>
                                                            <th>Degree Name</th>
                                                            <th>Passing Year</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="text-align:center">
                                                        <tr v-for='edu_detail1 in edu_detail'>
                                                            <td></td>
                                                            <td style="text-align:left">{{ edu_detail1.InstituteName }}
                                                            </td>
                                                            <td style="text-align:left">{{ edu_detail1.DegreeType }}
                                                            </td>
                                                            <td style="text-align:left">{{ edu_detail1.DegreeName }}
                                                            </td>
                                                            <td style="text-align:left">{{ edu_detail1.PassingYear }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-body pt-1" v-else-if="edu_detail == ''">
                                                <label>No qualification added yet</label>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <h4 class="card-header">Work Experience</h4>
                                            <div class="card-body pt-1">
                                                <ul v-for='exp_detail1 in exp_detail' class="timeline ms-50">
                                                    <li class="timeline-item">
                                                        <span
                                                            class="timeline-point timeline-point-info timeline-point-indicator"></span>
                                                        <div class="timeline-event">
                                                            <div
                                                                class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>{{ exp_detail1.JobTitle }}</h6>
                                                                <span class="timeline-event-time me-1">{{
                                                                    exp_detail1.StartingDate | formatDate1 }} to {{
                                                                    exp_detail1.LeavingDate | formatDate1 }}</span>
                                                            </div>
                                                            <p>{{ exp_detail1.CompanyName }}</p>
                                                            <div class="d-flex flex-row align-items-center mb-50">
                                                                <div style="margin-left:30px" class="avatar me-50">

                                                                </div>
                                                                <div class="user-info">
                                                                    <h6 class="mb-0">Reference Name</h6>
                                                                    <p class="mb-0">{{ exp_detail1.Refrence }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <label v-if="exp_detail == ''">No work experiance yet</label>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <h4 class="card-header">Issued Warnings</h4>
                                            <div class="table" style="overflow-x: initial !important;">
                                                <table class="table" style="max-width:40%;">
                                                    <tbody>
                                                        <tr class="odd">
                                                            <td v-if="emp_warning == ''">
                                                                <span class="badge badge-glow bg-success">No warning
                                                                    Issued</span>
                                                            </td>
                                                            <td v-else v-for="emp_warning1 in emp_warning">
                                                                <div class="demo-inline-spacing">
                                                                    <router-link
                                                                        :title="'Issued on ' + emp_warning1.DateIssued + '\nClick to view Details'"
                                                                        :to="{ name: 'warning_view', params: { id: emp_warning1.LetterID } }"
                                                                        class="badge"
                                                                        v-if="emp_warning1.WarningType == 'First'"
                                                                        style="cursor:pointer;">
                                                                        <span class="badge badge-glow bg-info">First-{{
                                                                            emp_warning1.ReasonSubject }}</span>
                                                                    </router-link>
                                                                    <router-link
                                                                        :title="'Issued on ' + emp_warning1.DateIssued + '\nClick to view Details'"
                                                                        :to="{ name: 'warning_view', params: { id: emp_warning1.LetterID } }"
                                                                        class="badge"
                                                                        v-if="emp_warning1.WarningType == 'Second'"
                                                                        style="cursor:pointer;">
                                                                        <span
                                                                            class="badge badge-glow bg-warning">Second-{{
                                                                            emp_warning1.ReasonSubject }}</span>
                                                                    </router-link>
                                                                    <router-link
                                                                        :title="'Issued on ' + emp_warning1.DateIssued + '\nClick to view Details'"
                                                                        :to="{ name: 'warning_view', params: { id: emp_warning1.LetterID } }"
                                                                        class="badge"
                                                                        v-if="emp_warning1.WarningType == 'Terminated'"
                                                                        style="cursor:pointer;">
                                                                        <span
                                                                            class="badge badge-glow bg-danger">Terminated-{{
                                                                            emp_warning1.ReasonSubject }}</span>
                                                                    </router-link>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <h4 class="card-header">Remarks</h4>
                                            <div class="card-body pt-1" v-for="emp_detail1 in emp_detail">
                                                <label v-html='emp_detail1.remarks'
                                                    v-if="emp_detail1.remarks != null && emp_detail1.remarks != ''"></label>
                                                <label v-else>No Remarks</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="empLeaves" aria-labelledby="empLeaves-tab"
                                        role="tabpanel">

                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Leaves Balances</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Granted</th>
                                                            <th>Used</th>
                                                            <th>Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="leavesblnc1 in leavesblnc">
                                                            <td>{{ leavesblnc1.LeaveType }}</td>
                                                            <td>{{ leavesblnc1.TotalLeave }}</td>
                                                            <td>{{ leavesblnc1.TotalLeave - leavesblnc1.RemainingLeave
                                                                }}
                                                            </td>
                                                            <td>{{ leavesblnc1.RemainingLeave }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Leaves History</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="central-text-align">
                                                            <th>Leave Type</th>
                                                            <th>Days</th>
                                                            <th>Date</th>
                                                            <th>Reason</th>
                                                            <th>HR Approval</th>
                                                            <th>Manager Approval</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="leaves1 in leaves">
                                                            <td>{{ leaves1.Leavetype }}</td>
                                                            <td>{{ leaves1.NoOfDays }}</td>
                                                            <td class="text-center">{{ leaves1.StartDate }}<br /><span
                                                                    v-if="leaves1.NoOfDays > 1">to<br />{{
                                                                    leaves1.EndDate }}</span>
                                                            </td>
                                                            <td style="max-width:100px; overflow:hidden;">
                                                                {{ leaves1.Reason }}
                                                            </td>
                                                            <td v-if="leaves1.ManagerApproval == 'Approved'"
                                                                class="text-center"><span
                                                                    class="badge bg-gradient-success">Approved</span>
                                                            </td>

                                                            <td v-else-if="leaves1.ManagerApproval == 'Rejected'"
                                                                class="text-center"><span
                                                                    class="badge bg-gradient-danger">Rejected</span>
                                                            </td>
                                                            <td v-else class="text-center"><span
                                                                    class="badge bg-gradient-warning">Pending</span>
                                                            </td>
                                                            <td v-if="leaves1.HRApproval == 'Approved'"
                                                                class="text-center">
                                                                <span class="badge bg-gradient-success">Approved</span>
                                                            </td>
                                                            <td v-else-if="leaves1.HRApproval == 'Rejected'"
                                                                class="text-center"><span
                                                                    class="badge bg-gradient-danger">Rejected</span>
                                                            </td>

                                                            <td v-else class="text-center"><span
                                                                    class="badge bg-gradient-warning">pending</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="empAttendance" aria-labelledby="empAttendance-tab"
                                        role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Current Session Attendance</h4>
                                            </div>
                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                <table class="table table-hover">
                                                    <thead style="text-align:center">
                                                        <tr>
                                                            <th class="sticky-th-center">Date</th>
                                                            <th class="sticky-th-center">Day</th>
                                                            <th class="sticky-th-center">Check In</th>
                                                            <th class="sticky-th-center">Late</th>
                                                            <th class="sticky-th-center">Check Out</th>
                                                            <th class="sticky-th-center">Excess</th>
                                                            <th class="sticky-th-center">Marked By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="text-align:center">
                                                        <tr v-for="attendance1 in attendance"
                                                            :class="[attendance1.AttStatus == 'H' ? activeClass : '', attendance1.AttStatus == 'LE' ? primaryClass : '']">
                                                            <td class="text-center">{{ attendance1.ATTDate }}</td>
                                                            <td class="text-center">{{ dayname(attendance1.ATTDate) }}
                                                            </td>

                                                            <td class="text-center"
                                                                v-if="attendance1.AttStatus == 'P' || attendance1.AttStatus == 'L'">
                                                                {{ attendance1.CheckIN | formatTime }}
                                                            </td>
                                                            <td class="text-center"
                                                                v-else-if="attendance1.AttStatus == 'H'">
                                                                Holiday
                                                            </td>
                                                            <td class="text-center"
                                                                v-else-if="attendance1.AttStatus == 'LE'">
                                                                Leave
                                                            </td>
                                                            <td class="text-center" v-else>-</td>

                                                            <td class="text-danger text-center"
                                                                v-if="attendance1.AttStatus == 'L' && attendance1.instatus > 0">
                                                                {{ attendance1.instatus }} minuts late
                                                            </td>
                                                            <td class="text-success text-center"
                                                                v-else-if="attendance1.AttStatus == 'L' && attendance1.instatus < 0">
                                                                {{ attendance1.instatus * -1 }} minut<span
                                                                    v-if="attendance1.instatus * -1 != 1">es</span> early
                                                            </td>
                                                            <td class="text-success text-center"
                                                                v-else-if="attendance1.AttStatus == 'P'">On time
                                                            </td>
                                                            <td class="text-center" v-else>-</td>

                                                            <td class="text-center"
                                                                v-if="attendance1.AttStatus == 'P' || attendance1.AttStatus == 'L'">
                                                                {{ attendance1.CheckOut | formatTime }}
                                                            </td>
                                                            <td class="text-center" v-else>-</td>

                                                            <td class="text-success text-center"
                                                                v-if="attendance1.AttStatus == 'L' && attendance1.outstatus > 0">
                                                                {{ attendance1.outstatus }} minuts Excess
                                                            </td>
                                                            <td class="text-danger text-center"
                                                                v-else-if="attendance1.AttStatus == 'L' && attendance1.outstatus < 0">
                                                                {{ attendance1.outstatus * -1 }} minut<span
                                                                    v-if="attendance1.outstatus * -1 != 1">es</span>
                                                                early
                                                            </td>
                                                            <td class="text-success text-center"
                                                                v-else-if="attendance1.AttStatus == 'P'">On time
                                                            </td>
                                                            <td class="text-center" v-else>-</td>

                                                            <td class="text-center"
                                                                v-if="attendance1.CheckInBy == 'Manual_Attendance'">MIS
                                                            </td>
                                                            <td class="text-center"
                                                                v-else-if="attendance1.CheckInBy == 'Machine_Checkin'">
                                                                Machine
                                                            </td>
                                                            <td class="text-center" v-else>-</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Office Time Table</h4>
                                            </div>
                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="sticky-th-center">Week Day</th>
                                                            <th class="sticky-th-center">Check In Time</th>
                                                            <th class="sticky-th-center">Check Out Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="central-text-align">
                                                            <td>Sunday</td>
                                                            <td v-if="this.u_sun_in != ''">{{ u_sun_in }}</td>
                                                            <td v-if="this.u_sun_out != ''">{{ u_sun_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                        <tr class="central-text-align ">
                                                            <td>Monday</td>
                                                            <td v-if="this.u_mon_in != ''">{{ u_mon_in }}</td>
                                                            <td v-if="this.u_mon_out != ''">{{ u_mon_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                        <tr class="central-text-align ">
                                                            <td>Tuesday</td>
                                                            <td v-if="this.u_tue_in != ''">{{ u_tue_in }}</td>
                                                            <td v-if="this.u_tue_out != ''">{{ u_tue_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                        <tr class="central-text-align ">
                                                            <td>Wednesday</td>
                                                            <td v-if="this.u_wed_in != ''">{{ u_wed_in }}</td>
                                                            <td v-if="this.u_wed_out != ''">{{ u_wed_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                        <tr class="central-text-align ">
                                                            <td>Thursday</td>
                                                            <td v-if="this.u_thu_in != ''">{{ u_thu_in }}</td>
                                                            <td v-if="this.u_thu_out != ''">{{ u_thu_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                        <tr class="central-text-align bgc-red-50">
                                                            <td>Friday</td>
                                                            <td v-if="this.u_fri_in != ''">{{ u_fri_in }}</td>
                                                            <td v-if="this.u_fri_out != ''">{{ u_fri_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                        <tr class="central-text-align ">
                                                            <td>Saturday</td>
                                                            <td v-if="this.u_sat_in != ''">{{ u_sat_in }}</td>
                                                            <td v-if="this.u_sat_out != ''">{{ u_sat_out }}</td>
                                                            <td v-else colspan="2" class="central-text-align">Weekend
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="empFinancialHistory"
                                        aria-labelledby="empFinancialHistory-tab" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Salary History</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Session Name</th>
                                                            <th>Method <br />Type</th>
                                                            <th>Salary</th>
                                                            <th>Toatl <br />Addition</th>
                                                            <th>Total<br />Detection</th>
                                                            <th>Payable<br /> Salary</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="text-align:center">
                                                        <tr v-for='Sal_detail1 in Sal_detail'>
                                                            <td style="text-align:left">{{ Sal_detail1.SessionName }}
                                                            </td>
                                                            <td style="text-align:left">{{ Sal_detail1.MethodType }}
                                                            </td>
                                                            <td style="text-align:left">
                                                                {{ Math.floor(Sal_detail1.Salary).toLocaleString() }}
                                                            </td>
                                                            <td style="text-align:left">
                                                                {{ Number(Sal_detail1.BonusAmount) +
                                                                    Number(Sal_detail1.AllowanceAmount) +
                                                                Number(Sal_detail1.StipendAmount) +
                                                                Number(Sal_detail1.OAmount) }}
                                                            </td>
                                                            <td style="text-align:left">
                                                                {{ Number((Sal_detail1.Fine) +
                                                                    Number(Sal_detail1.DAmount) +
                                                                Number(Sal_detail1.InstallmentAmount)).toLocaleString()
                                                                }}
                                                            </td>
                                                            <td style="text-align:left">
                                                                {{
                                                                Math.floor(Sal_detail1.PayableSalary).toLocaleString()
                                                                }}
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-gradient-warning"
                                                                    v-if="Sal_detail1.ReceivedThrough == null">Pending</span>
                                                                <span class="badge bg-gradient-success"
                                                                    v-else>Received</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex align-items-center col-actions">
                                                                    <a class="btn btn-sm dropdown-toggle hide-arrow"
                                                                        data-bs-toggle="dropdown">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item"
                                                                            v-if="Sal_detail1.ReceivedThrough != null"
                                                                            target="_blank"
                                                                            v-bind:href="`${url_s2}/generate_slip/${Sal_detail1.EmployeeID}/${Sal_detail1.DistributionID}/${Sal_detail1.EmpCode}`">
                                                                            <i class="fa-solid fa-download"></i>
                                                                            Download Slip
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Loan History</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <div style="text-align:left;">Created at</div>
                                                            </th>
                                                            <th>
                                                                <div style="text-align:left;">Manager<br />Approval
                                                                </div>
                                                            </th>
                                                            <th>
                                                                <div style="text-align:left;">HR<br />Approval</div>
                                                            </th>
                                                            <th>
                                                                <div style="text-align:left;">Install<br />ments</div>
                                                            </th>
                                                            <th>
                                                                <div style="text-align:left;">Amount</div>
                                                            </th>
                                                            <th>
                                                                <div style="text-align:left;">Actions</div>
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <!--  -->
                                                    <tbody v-for="loans1 in Loan_detail">
                                                        <td colspan="8">
                                                            <div class="accordion accordion-border"
                                                                id="accordionBorder">
                                                                <div class="accordion-item">
                                                                    <div class="accordion-header  d-flex"
                                                                        :id="'headingBorder' + loans1.LoanId">
                                                                        <div class="col-md-2  mb-3 position-relative mx-1"
                                                                            style="text-align:center;">
                                                                            {{ loans1.ApplyDate }}
                                                                        </div>
                                                                        <div class="col-md-2  mb-3 position-relative mx-1"
                                                                            style="text-align:center;">
                                                                            <span v-if="loans1.ManagerApproval == 'Pen'"
                                                                                class="badge bg-gradient-warning">Pending</span>
                                                                            <span class="badge bg-gradient-success"
                                                                                v-if="loans1.ManagerApproval == 'App'">Approved</span>
                                                                            <span class="badge bg-gradient-danger"
                                                                                v-if="loans1.ManagerApproval == 'Rej'">Rejected</span>
                                                                        </div>
                                                                        <div class="col-md-2  mb-3 position-relative mx-1"
                                                                            style="text-align:center;">
                                                                            <span class="badge bg-gradient-warning"
                                                                                v-if="loans1.HrApproval == 'Pen'">Pending</span>
                                                                            <span class="badge bg-gradient-success"
                                                                                v-if="loans1.HrApproval == 'App'">Approved</span>
                                                                            <span class="badge bg-gradient-danger"
                                                                                v-if="loans1.HrApproval == 'Rej'">Rejected</span>
                                                                        </div>
                                                                        <div class="col-md-2  mb-3 position-relative mx-1"
                                                                            style="text-align:center;">
                                                                            {{ loans1.LoanInstallments }}
                                                                        </div>
                                                                        <div class="col-md-1  mb-3 position-relative mx-1"
                                                                            style="text-align:center;">
                                                                            {{
                                                                            Math.floor(loans1.LoanAmount).toLocaleString()
                                                                            }}/-
                                                                        </div>
                                                                        <div class="col-md-1 mb-3 position-relative mx-1"
                                                                            style="text-align:center;">

                                                                            <button
                                                                                v-if="loans1.ReqStatus == 'Paid' || loans1.ReqStatus == 'Returned'"
                                                                                class="collapsed" style="border: none;"
                                                                                type="button"
                                                                                @click="installmentDetails(loans1.LoanId)"
                                                                                data-bs-toggle="collapse"
                                                                                :data-bs-target="'#accordionBorder' + loans1.LoanId"
                                                                                aria-expanded="false"
                                                                                :aria-controls="'accordionBorder' + loans1.LoanId">
                                                                                <i class="fa-solid fa-circle-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div :id="'accordionBorder' + loans1.LoanId"
                                                                        class="accordion-collapse collapse"
                                                                        :aria-labelledby="'headingBorder' + loans1.LoanId"
                                                                        :data-bs-parent="'#accordionBorder' + loans1.LoanId">
                                                                        <div class="accordion-body">

                                                                            <h5 class="card-header"
                                                                                style="padding:0px !important;">
                                                                                Installments
                                                                                detail</h5>
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="py-1">No</th>
                                                                                        <th class="py-1">Session</th>
                                                                                        <th class="py-1">Amount</th>
                                                                                        <th class="py-1">Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr
                                                                                        v-for="(get_reqdata11, index) in install_list">
                                                                                        <td class="py-1">
                                                                                            <p class="card-text mb-25">
                                                                                                {{ index + 1 }}</p>
                                                                                        </td>
                                                                                        <td class="py-1">
                                                                                            <span>{{
                                                                                                get_reqdata11.InstallmentSession
                                                                                                }}</span>
                                                                                        </td>
                                                                                        <td class="py-1">
                                                                                            <span>{{
                                                                                                Math.floor(get_reqdata11.InstallmentAmount).toLocaleString()
                                                                                                }}/-</span>
                                                                                        </td>
                                                                                        <td class="py-1">
                                                                                            <span
                                                                                                v-if="get_reqdata11.InstallmentStatus == 'Unpaid'"
                                                                                                class="badge bg-gradient-warning">Unpaid</span>
                                                                                            <span
                                                                                                v-else-if="get_reqdata11.InstallmentStatus == 'waivedoff'"
                                                                                                class="badge bg-gradient-success">Waived
                                                                                                Off</span>
                                                                                            <span
                                                                                                v-else-if="get_reqdata11.InstallmentStatus == 'Paid'"
                                                                                                class="badge bg-gradient-danger">Paid</span>
                                                                                            <span
                                                                                                v-else-if="get_reqdata11.InstallmentStatus == 'Skipped'"
                                                                                                class="badge bg-gradient-secondary">Skipped</span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tbody>
                                                    <!--  -->
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
            url_s2: '',
            url: window.location.href,
            stipend: '',
            allowance: '',
            activeClass: 'table-secondary',
            primaryClass: 'table-primary',

            Sal_detail: {},
            Loan_detail: {},
            install_list: {},

            emp_warning: {},
            id: this.$route.params.id,
            attendance: {},
            emp_detail: {},
            edu_detail: {},
            exp_detail: {},
            rep_employees: {},
            com_year: '',
            max: 100,
            percent: {},

            value: '100',

            leaves: {},
            leavesblnc: {},

            u_sun_in: '',
            u_sun_out: '',
            u_mon_in: '',
            u_mon_out: '',
            u_tue_in: '',
            u_tue_out: '',
            u_wed_in: '',
            u_wed_out: '',
            u_thu_in: '',
            u_thu_out: '',
            u_fri_in: '',
            u_fri_out: '',
            u_sat_in: '',
            u_sat_out: '',
        }
    },
    methods: {
        get_ip() {
            const url_s1 = this.url.split('/');
            this.url_s2 = url_s1[0] + '//' + url_s1[2] + '/' + url_s1[3];
        },
        installmentDetails(id) {
            this.Loan_detail.map((curEle) => {
                return document.getElementById("accordionBorder" + curEle.LoanId).classList.remove("show")
            })
            axios.get("installments_detail/" + id)
                .then((response) => {
                    this.install_list = response.data
                })
        },
        dayname(dateS) {
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var d = new Date(dateS);
            return days[d.getDay()];
        },
    },
    mounted() {
        this.get_ip();

        axios.get('getindemployee_detail/' + 0)
            .then(response => {
                if (response.data && response.data.data) {
                    this.emp_detail = response.data.data;
                    console.log(this.emp_detail, "single employee profile view");
                } else {
                    console.warn("No employee detail found.");
                }
            })

        axios.get('fetch_employee_amount/' + 0)
            .then(data => {
                this.stipend = data.data.data.stipend;
                this.com_year = data.data.data.years;
                this.allowance = data.data.data.allowance;

            })
            .catch(error => {
            });

        axios.get('getemployee_Saldetails/' + 0)
            .then(data => {
                this.Sal_detail = data.data;
            })

        axios.get('getemployee_Loandetails/' + 0)
            .then(data => {
                this.Loan_detail = data.data;
            })

        axios.get('this_user_attendence/' + 0)
            .then(data => this.attendance = data.data.data)
            .catch(error => {
            });

        axios.get('selected_emp_leaves/' + 0)
            .then(data => this.leaves = data.data.data)
            .catch(error => {
            });

        axios.get('selected_emp_leaves_blnc/' + 0)
            .then(data => this.leavesblnc = data.data.data)
            .catch(error => {
            });

        axios.get('selected_emp_timeTable/' + 0)
            .then(response => {
                var u_mon = response.data[0].Mon.split('-');
                this.u_mon_in = u_mon[0];
                this.u_mon_out = u_mon[1];

                var u_tue = response.data[0].Tue.split('-');
                this.u_tue_in = u_tue[0];
                this.u_tue_out = u_tue[1];

                var u_wed = response.data[0].Wed.split('-');
                this.u_wed_in = u_wed[0];
                this.u_wed_out = u_wed[1];

                var u_thu = response.data[0].Thu.split('-');
                this.u_thu_in = u_thu[0];
                this.u_thu_out = u_thu[1];

                var u_fri = response.data[0].Fri.split('-');
                this.u_fri_in = u_fri[0];
                this.u_fri_out = u_fri[1];

                var u_sat = response.data[0].Sat.split('-');
                this.u_sat_in = u_sat[0];
                this.u_sat_out = u_sat[1];

                var u_sat = response.data[0].Sun.split('-');
                this.u_sun_in = u_sat[0];
                this.u_sun_out = u_sat[1];
            })
            .catch(error => {
            });

        axios.get('getemployee_education/' + 0)
            .then(data => {
                this.edu_detail = data.data.data;
            })

        axios.get('getwarnig_emp/' + 0)
            .then(data => {
                this.emp_warning = data.data;
            })

        axios.get('getemployee_exp/' + 0)
            .then(data => {
                this.exp_detail = data.data.data;
            })

        axios.get('reporting_employees/' + 0)
            .then(data => {
                this.rep_employees = data.data.data;
            })

        axios.get('./success_array/' + 0)
            .then((response) => this.percent = response.data.data)
    },
}

</script>
