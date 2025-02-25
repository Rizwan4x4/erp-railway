<!-- view single emploee detail from clicking humanresource_dashboard.vue-->
<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/hr/employees_detail" style="text-decoration: none;">Employees Detail 2
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active" v-for='emp_detail1 in emp_detail'>
                                {{ emp_detail1.Name }}
                            </li>
                        </ol>
                        <b-progress animated show-progress max="100" class="mb-3" :value="percent[0].profile_completion"
                                    variant="success"
                                    :label="`${Number(percent[0].profile_completion)}`">

                        </b-progress>
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
                                                <img v-if="emp_detail1.Photo==''" class="img-fluid rounded mt-3 mb-2"
                                                     src="public/images/profile_images/pro.png" height="110" width="110"
                                                     alt="User avatar"/>
                                                <img v-else class="img-fluid rounded mt-3 mb-2"
                                                     v-bind:src="`public/images/profile_images/${emp_detail1.Photo}`"
                                                     height="110" width="110" alt="User avatar"/>
                                                <div class="user-info text-center">
                                                    <h4>{{ emp_detail1.Name }}</h4>
                                                    <span
                                                        class="badge bg-light-secondary">{{
                                                            emp_detail1.Designation
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
                                                    <h4 class="mb-0" v-if="com_year!=''">{{ com_year }}</h4>
                                                    <h4 class="mb-0" v-else>0</h4>
                                                    <small>Year<label v-if="com_year>'1'">s</label> Completed</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <span class="badge bg-light-primary p-75 rounded">

                                                    <i class="fa-solid fa-bars-progress font-medium-2"
                                                       style="margin-right: 5px"></i>
                                                </span>
                                                <div class="ms-75">
                                                    <h4 class="mb-0">
                                                        {{
                                                            percent.address + percent.city + percent.cnic + percent.company_email + percent.department + percent.designation + percent.dob + percent.edu_status + percent.email + percent.emp_code + percent.exp_status + percent.father + percent.gender + percent.job_des + percent.marital + percent.mobile + percent.photo + percent.reporting
                                                        }}%</h4>
                                                    <small>Profile Completed</small>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Personal Details</h4>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                                <li class="mb-75">
                                                    <span class="fw-bolder me-25">Father Name:</span>
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
                                                    <span v-if="emp_detail1.Status == 'Suspended'"
                                                          class="badge bg-light-warning">{{ emp_detail1.Status }}</span>
                                                    <span v-if="emp_detail1.Status == 'Registered'"
                                                          class="badge bg-light-success">{{ emp_detail1.Status }}</span>
                                                    <span v-if="emp_detail1.Status == 'Resigned'"
                                                          class="badge bg-light-primary">{{ emp_detail1.Status }}</span>
                                                    <span v-if="emp_detail1.Status == 'Terminated'"
                                                          class="badge bg-light-danger">{{ emp_detail1.Status }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-center pt-2">
                                                <button :disabled="disabled"
                                                        v-if="emp_detail1.Status!='Registered' "
                                                        @click="registered(emp_detail1.EmployeeID)"
                                                        class="btn btn-outline-primary suspend-user me-1">Register
                                                </button>
                                                <button v-else-if="emp_detail1.Status=='Registered'"
                                                        class="btn btn-primary suspend-user me-1">Registered
                                                </button>

                                                <button :disabled="disabled"
                                                        v-if="emp_detail1.Status!='Resigned' && emp_detail1.Status!='Suspended'"
                                                        @click="get_id(emp_detail1.EmployeeID)"
                                                        class="btn btn-outline-secondary suspend-user me-1"
                                                        data-bs-toggle="modal" data-bs-target="#resign_emp">Resign
                                                </button>
                                                <button v-else-if="emp_detail1.Status=='Resigned'"
                                                        class="btn btn-secondary suspend-user me-1">Resigned
                                                </button>

                                                <button :disabled="disabled"
                                                        v-if="emp_detail1.Status=='Suspended' "
                                                        @click="get_id(emp_detail1.EmployeeID)" data-bs-toggle="modal"
                                                        data-bs-target="#terminate_emp"
                                                        class="btn btn-outline-danger suspend-user">Terminate
                                                </button>
                                                <button v-else-if="emp_detail1.Status=='Terminated'"
                                                        class="btn btn-danger suspend-user">Terminated
                                                </button>

                                                <button :disabled="disabled"
                                                        v-if="emp_detail1.Status!='Suspended' && emp_detail1.Status!='Terminated'"
                                                        class="btn btn-outline-warning suspend-user"
                                                        @click="get_id(emp_detail1.EmployeeID)" data-bs-toggle="modal"
                                                        data-bs-target="#suspend_emp">Suspend
                                                </button>
                                                <button v-else-if="emp_detail1.Status=='Suspended'"
                                                        class="btn btn-warning suspend-user">Suspended
                                                </button>
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
                                                <span class="fw-bolder display-5 mb-0 text-primary"
                                                      style="font-size:18px">{{
                                                        Math.floor(emp_detail1.Salary).toLocaleString()
                                                    }}</span>
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
                                                      style="font-size:18px">{{
                                                        Math.floor(allowance).toLocaleString()
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
                                                      style="font-size:18px">{{
                                                        Math.floor(stipend).toLocaleString()
                                                    }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                            </div>
                                        </div>
                                        <div v-if="fuel > 1" class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-success">Fuel</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-success mt-1 mb-0">Ltr.</sup>
                                                <span class="fw-bolder display-5 mb-0 text-success"
                                                      style="font-size:18px">{{
                                                        Math.floor(fuel).toLocaleString()
                                                    }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
                                            </div>
                                        </div>
                                        <div v-if="com_year > '1'"
                                             class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-light-danger">Gratuity</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h5 pricing-currency text-danger mt-1 mb-0">Rs</sup>
                                                <span class="fw-bolder display-5 mb-0 text-danger"
                                                      style="font-size:18px">{{
                                                        Math.floor((com_year) * emp_detail1.Salary).toLocaleString()
                                                    }}</span>
                                                <sub
                                                    class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/career</sub>
                                            </div>
                                        </div>
                                        <div style="font-size:18px;margin-top:20px">
                                            <span class="fw-bolder display-5 mb-0 text-primary" style="font-size:18px">Job Description</span>
                                        </div>
                                        <label v-html='emp_detail1.JobDescription'></label>
                                    </div>
                                </div>
                                <!-- /Plan Card -->
                            </div>
                            <!--/ User Sidebar -->
                            <!-- User Content -->
                            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                                <!-- User Pills -->
                                <ul class="nav nav-pills mb-2" style="padding-left:20px !important">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="empPersonal-tab" data-bs-toggle="tab" role="tab"
                                           href="#empPersonal" aria-selected="true">
                                            <i class="fa-solid fa-briefcase"></i>
                                            <span class="fw-bold">Employment</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " @click="leavedata()" id="empLeaves-tab" data-bs-toggle="tab" role="tab"
                                           href="#empLeaves" aria-selected="true">
                                            <i class="fa-solid fa-person-skiing-nordic"></i>
                                            <span class="fw-bold">Leaves</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "  @click="attendencedata()" id="empAttendance-tab" data-bs-toggle="tab" role="tab"
                                           href="#empAttendance" aria-selected="true">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <span class="fw-bold">Attendance</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link "  @click="financialdata()" id="empFinancialHistory-tab" data-bs-toggle="tab"
                                           role="tab" href="#empFinancialHistory" aria-selected="true">
                                            <i class="fa-solid fa-coins"></i>
                                            <span class="fw-bold">Financial History</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="empPersonal" aria-labelledby="empPersonal-tab"
                                         role="tabpanel">
                                        <!--/ User Pills -->
                                        <div v-for='emp_detail1 in emp_detail' class="card">
                                            <div class="card-header">
                                                <div style="float:left">
                                                    <h4 class="card-title mb-50">Employment Details</h4>
                                                </div>
                                                <div style="float:right">
                                                    <a title="You cannot change format"
                                                       v-if="percent.address+percent.city+percent.cnic+percent.company_email+percent.department+percent.designation+percent.dob+percent.edu_status+percent.email+percent.emp_code+percent.exp_status+percent.father+percent.gender+percent.job_des+percent.marital+percent.mobile+percent.photo+percent.reporting>89"
                                                       target="_blank"
                                                       v-bind:href="`${url}/cv_builder/${emp_detail1.EmployeeID}/${emp_detail1.EmployeeCode}/${emp_detail1.RegisterID}`"
                                                       class="btn btn-primary btn-sm edit-address waves-effect waves-float waves-light">
                                                        Build CV
                                                    </a>
                                                    <a v-else target="_blank"
                                                       title="Please complete employee Profile upto 90%" href="#"
                                                       class="btn btn-primary btn-sm edit-address waves-effect waves-float waves-light">
                                                        CV Builder
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-12">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-5 fw-bolder mb-1">Employee Code:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.EmployeeCode }}
                                                            </dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Reporting To:</dt>
                                                            <dd class="col-sm-7 mb-1">
                                                                <label>{{ rep_employees.rep1 }}</label></dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Posting City:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.PostingCity }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Com. Email:</dt>
                                                            <dd class="col-sm-7 mb-1" style="">
                                                                {{ emp_detail1.CompanyEmail }}
                                                            </dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">CNIC:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.CNIC }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Job Shift:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ shift_name }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Relation:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.Relation }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Salary Currency:</dt>
                                                            <dd class="col-sm-7 mb-1">
                                                                {{ emp_detail1.Salary_Currency }}
                                                            </dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Send Notification:</dt>
                                                            <dd v-if="emp_detail1.SendNotification==1"
                                                                class="col-sm-7 mb-1">Allowed
                                                            </dd>
                                                            <dd v-else class="col-sm-7 mb-1">Not Allowed</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">E-Portal Access:</dt>
                                                            <dd v-if="emp_detail1.EportalAccess==1"
                                                                class="col-sm-7 mb-1">Allow
                                                            </dd>
                                                            <dd v-else class="col-sm-7 mb-1">Not Allowed</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Team Attendance:</dt>
                                                            <dd v-if="emp_detail1.AllowEmployeesAttendance==1"
                                                                class="col-sm-7 mb-1">Allowed
                                                            </dd>
                                                            <dd v-else class="col-sm-7 mb-1">Not Allowed</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-xl-6 col-12">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-5 fw-bolder mb-1">Department:</dt>
                                                            <dd class="col-sm-7 mb-1">{{ emp_detail1.Department }}</dd>
                                                            <dt class="col-sm-5 fw-bolder mb-1">Second Rep. To:</dt>
                                                            <dd class="col-sm-7 mb-1">
                                                                <label>{{ rep_employees.rep2 }}</label></dd>
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
                                            <div class="table-responsive" v-if="edu_detail!=''">
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
                                                        <td style="text-align:left">{{ edu_detail1.InstituteName }}</td>
                                                        <td style="text-align:left">{{ edu_detail1.DegreeType }}</td>
                                                        <td style="text-align:left">{{ edu_detail1.DegreeName }}</td>
                                                        <td style="text-align:left">{{ edu_detail1.PassingYear }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-body pt-1" v-else-if="edu_detail==''">
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
                                                                <span
                                                                    class="timeline-event-time me-1">{{
                                                                        exp_detail1.StartingDate
                                                                    }} to {{ exp_detail1.LeavingDate }}</span>
                                                            </div>
                                                            <p>{{ exp_detail1.CompanyName }}</p>
                                                            <div class="d-flex flex-row align-items-center mb-50">
                                                                <div style="margin-left:30px" class="avatar me-50">
                                                                </div>
                                                                <div class="user-info">
                                                                    <h6 class="mb-0">Reference Name</h6>
                                                                    <p class="mb-0" v-if="exp_detail1.Refrence!='NULL'">
                                                                        {{ exp_detail1.Refrence }}</p>
                                                                    <p class="mb-0" v-else>No reference</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <label v-if="exp_detail==''">No work experiance yet</label>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <h4 class="card-header">Issued Warnings</h4>
                                            <div class="table" style="overflow-x: initial !important;">
                                                <table class="table" style="max-width:40%;">
                                                    <tbody>
                                                    <tr class="odd">
                                                        <td v-if="emp_warning == ''">
                                                            <span
                                                                class="badge badge-glow bg-success">No warning Issued</span>
                                                        </td>
                                                        <td v-else v-for="emp_warning1 in emp_warning">
                                                            <div class="demo-inline-spacing">
                                                                <router-link
                                                                    :title="'Issued on '+emp_warning1.DateIssued+'\nClick to view Details'"
                                                                    :to="{ name: 'warning_view', params: { id: emp_warning1.LetterID }}"
                                                                    class="badge"
                                                                    v-if="emp_warning1.WarningType =='First'"
                                                                    style="cursor:pointer;">
                                                                    <span
                                                                        class="badge badge-glow bg-info">First-{{
                                                                            emp_warning1.ReasonSubject
                                                                        }}</span>
                                                                </router-link>
                                                                <router-link
                                                                    :title="'Issued on '+emp_warning1.DateIssued+'\nClick to view Details'"
                                                                    :to="{ name: 'warning_view', params: { id: emp_warning1.LetterID }}"
                                                                    class="badge"
                                                                    v-if="emp_warning1.WarningType =='Second'"
                                                                    style="cursor:pointer;">
                                                                    <span
                                                                        class="badge badge-glow bg-warning">Second-{{
                                                                            emp_warning1.ReasonSubject
                                                                        }}</span>
                                                                </router-link>
                                                                <router-link
                                                                    :title="'Issued on '+emp_warning1.DateIssued+'\nClick to view Details'"
                                                                    :to="{ name: 'warning_view', params: { id: emp_warning1.LetterID }}"
                                                                    class="badge"
                                                                    v-if="emp_warning1.WarningType =='Terminated'"
                                                                    style="cursor:pointer;">
                                                                    <span class="badge badge-glow bg-danger">Terminated-{{
                                                                            emp_warning1.ReasonSubject
                                                                        }}</span>
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
                                                       v-if="emp_detail1.remarks!=null && emp_detail1.remarks!=''"></label>
                                                <label v-else>No Remarks</label>
                                            </div>
                                        </div>
                                        <!-- /Activity Timeline -->
                                    </div>
                                    <div class="tab-pane" id="empLeaves" aria-labelledby="empLeaves-tab"
                                         role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Leavess Balances</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table text-nowrap text-center">
                                                    <thead>
                                                    <tr>
                                                        <th>Types</th>
                                                        <th>Granted</th>
                                                        <th>Used</th>
                                                        <th>Balance</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="leavesblnc1 in leavesblnc">
                                                        <td>{{ leavesblnc1.LeaveType }}</td>
                                                        <td>{{ leavesblnc1.TotalLeave }}</td>
                                                        <td>{{ leavesblnc1.TotalLeave - leavesblnc1.RemainingLeave }}
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
                                                <table class="table text-nowrap text-center">
                                                    <thead>
                                                    <tr class="central-text-align">
                                                        <th>Leave Type</th>
                                                        <th>Days</th>
                                                        <th>Start Date</th>
                                                        <th>Reason</th>
                                                        <th>Manager<br/>Approval</th>
                                                        <th>HR<br/>Approval</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="leaves1 in leaves">
                                                        <td>{{ leaves1.Leavetype }}</td>
                                                        <td>{{ leaves1.NoOfDays }}</td>
                                                        <td class="text-center">{{ leaves1.StartDate }}<br/><span
                                                            v-if="leaves1.NoOfDays > 1">to<br/>{{
                                                                leaves1.EndDate
                                                            }}</span>
                                                        </td>
                                                        <td style="max-width:100px; overflow:hidden;">
                                                            {{ leaves1.Reason }}
                                                        </td>
                                                        <td v-if="leaves1.ManagerApproval=='Approved'"
                                                            class="text-center"><span class="badge bg-gradient-success">Approved</span>
                                                        </td>

                                                        <td v-else-if="leaves1.ManagerApproval=='Rejected'"
                                                            class="text-center"><span class="badge bg-gradient-danger">Rejected</span>
                                                        </td>
                                                        <td v-else class="text-center"><span
                                                            class="badge bg-gradient-warning">Pending</span></td>
                                                        <td v-if="leaves1.HRApproval=='Approved'" class="text-center">
                                                            <span class="badge bg-gradient-success">Approved</span></td>
                                                        <td v-else-if="leaves1.HRApproval=='Rejected'"
                                                            class="text-center"><span class="badge bg-gradient-danger">Rejected</span>
                                                        </td>

                                                        <td v-else class="text-center"><span
                                                            class="badge bg-gradient-warning">pending</span></td>
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
                                                <table class="table">
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
                                                        :class="[attendance1.AttStatus=='H' ? activeClass : '', attendance1.AttStatus=='LE' ? primaryClass : '']">
                                                        <td class="text-center">{{ attendance1.ATTDate }}</td>
                                                        <td class="text-center">{{ dayname(attendance1.ATTDate) }}</td>

                                                        <td class="text-center"
                                                            v-if="attendance1.AttStatus=='P' || attendance1.AttStatus=='L'">
                                                            {{ attendance1.CheckIN | formatTime }}
                                                        </td>
                                                        <td class="text-center" v-else-if="attendance1.AttStatus=='H'">
                                                            Holiday
                                                        </td>
                                                        <td class="text-center" v-else-if="attendance1.AttStatus=='LE'">
                                                            Leave
                                                        </td>
                                                        <td class="text-center" v-else>-</td>

                                                        <td class="text-danger text-center"
                                                            v-if="attendance1.AttStatus=='L' && attendance1.instatus > 0">
                                                            {{ attendance1.instatus }} minuts late
                                                        </td>
                                                        <td class="text-success text-center"
                                                            v-else-if="attendance1.AttStatus=='L' && attendance1.instatus < 0">
                                                            {{ attendance1.instatus * -1 }} minut<span
                                                            v-if="attendance1.instatus * -1 !=1">es</span> early
                                                        </td>
                                                        <td class="text-success text-center"
                                                            v-else-if="attendance1.AttStatus=='P'">On time
                                                        </td>
                                                        <td class="text-center" v-else>-</td>

                                                        <td class="text-center"
                                                            v-if="attendance1.AttStatus=='P' || attendance1.AttStatus=='L'">
                                                            {{ attendance1.CheckOut | formatTime }}
                                                        </td>
                                                        <td class="text-center" v-else>-</td>

                                                        <td class="text-success text-center"
                                                            v-if="attendance1.AttStatus=='L' && attendance1.outstatus > 0">
                                                            {{ attendance1.outstatus }} minuts Excess
                                                        </td>
                                                        <td class="text-danger text-center"
                                                            v-else-if="attendance1.AttStatus=='L' && attendance1.outstatus < 0">
                                                            {{ attendance1.outstatus * -1 }} minut<span
                                                            v-if="attendance1.outstatus * -1 !=1">es</span> early
                                                        </td>
                                                        <td class="text-success text-center"
                                                            v-else-if="attendance1.AttStatus=='P'">On time
                                                        </td>
                                                        <td class="text-center" v-else>-</td>

                                                        <td class="text-center"
                                                            v-if="attendance1.CheckInBy=='Manual_Attendance'">MIS
                                                        </td>
                                                        <td class="text-center"
                                                            v-else-if="attendance1.CheckInBy=='Machine_Checkin'">Machine
                                                        </td>
                                                        <td class="text-center" v-else>-</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Office Time Table<small class="text-muted">
                                                    ({{ shift_name }})</small></h4>
                                            </div>
                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                <table class="table table-borderless">
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
                                                        <td v-if="u_sun_in!=''">{{ u_sun_in }}</td>
                                                        <td v-if="u_sun_out!=''">{{ u_sun_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>
                                                    </tr>
                                                    <tr class="central-text-align ">
                                                        <td>Monday</td>
                                                        <td v-if="u_mon_in!=''">{{ u_mon_in }}</td>
                                                        <td v-if="u_mon_out!=''">{{ u_mon_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>
                                                    </tr>
                                                    <tr class="central-text-align ">
                                                        <td>Tuesday</td>
                                                        <td v-if="u_tue_in!=''">{{ u_tue_in }}</td>
                                                        <td v-if="u_tue_out!=''">{{ u_tue_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>
                                                    </tr>
                                                    <tr class="central-text-align ">
                                                        <td>Wednesday</td>
                                                        <td v-if="u_wed_in!=''">{{ u_wed_in }}</td>
                                                        <td v-if="u_wed_out!=''">{{ u_wed_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>
                                                    </tr>
                                                    <tr class="central-text-align ">
                                                        <td>Thursday</td>
                                                        <td v-if="u_thu_in!=''">{{ u_thu_in }}</td>
                                                        <td v-if="u_thu_out!=''">{{ u_thu_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>
                                                    </tr>
                                                    <tr class="central-text-align bgc-red-50">
                                                        <td>Friday</td>
                                                        <td v-if="u_fri_in!=''">{{ u_fri_in }}</td>
                                                        <td v-if="u_fri_out!=''">{{ u_fri_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>

                                                    </tr>
                                                    <tr class="central-text-align ">
                                                        <td>Saturday</td>
                                                        <td v-if="u_sat_in!=''">{{ u_sat_in }}</td>
                                                        <td v-if="u_sat_out!=''">{{ u_sat_out }}</td>
                                                        <td v-else colspan="2" class="central-text-align">Weekend</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="empFinancialHistory"
                                         aria-labelledby="empFinancialHistory-tab" role="tabpanel">
                                        <!-- Project table -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Salary History</h4>
                                            </div>
                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                <table class="table table-hover">
                                                    <thead style="text-align:center">
                                                    <tr>
                                                        <th class="sticky-th-center">Sr.#</th>
                                                        <th class="sticky-th-center">Month</th>
                                                        <th class="sticky-th-center">Method <br/>Type</th>
                                                        <th class="sticky-th-center">Salary</th>
                                                        <th class="sticky-th-center">Toatl <br/>Addition</th>
                                                        <th class="sticky-th-center">Total<br/>Deduction</th>
                                                        <th class="sticky-th-center">Payable<br/> Salary</th>
                                                        <th class="sticky-th-center">Status</th>
                                                        <th class="sticky-th-center">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="text-align:center">
                                                    <tr v-for="(all_sals1, index) in all_sals.data">
                                                        <td class="td-center">{{ (index + 1) + ((page1 - 1) * 5) }}</td>
                                                        <td class="td-center">{{ all_sals1.SessionName }}</td>
                                                        <td class="td-center">{{ all_sals1.MethodType }}</td>
                                                        <td class="td-right">
                                                            {{ Math.floor(all_sals1.Salary).toLocaleString() }}
                                                        </td>
                                                        <td class="td-right">
                                                            {{
                                                                Math.floor(parseInt(all_sals1.BonusAmount) + parseInt(all_sals1.StipendAmount) + parseInt(all_sals1.OAmount) + parseInt(all_sals1.FuelAmount)).toLocaleString()
                                                            }}
                                                        </td>
                                                        <td class="td-right">
                                                            {{
                                                                Math.floor(parseInt(all_sals1.Fine) + parseInt(all_sals1.DAmount) + parseInt(all_sals1.TaxAmount) + parseInt(all_sals1.AdvanceAmount) + parseInt(all_sals1.InstallmentAmount)).toLocaleString()
                                                            }}
                                                        </td>
                                                        <td class="td-right">
                                                            {{ Math.floor(all_sals1.PayableSalary).toLocaleString() }}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-gradient-warning"
                                                                  v-if="all_sals1.SalaryStatus == 'Not Received'">Not Received</span>
                                                            <span class="badge bg-gradient-success"
                                                                  v-else>{{ all_sals1.SalaryStatus }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="dropdown-item"
                                                               v-if="all_sals1.SalaryStatus != 'Not Received'"
                                                               target="_blank"
                                                               v-bind:href="`${url}/generate_slip/${all_sals1.EmployeeID}/${all_sals1.DistributionID}/${all_sals1.EmpCode}`"
                                                               title="Download slip">
                                                                <i class="fa-solid fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div style="text-align:center; padding-top:20px">
                                                <pagination :limit="limit" :data="all_sals"
                                                            @pagination-change-page="employee_salaries"></pagination>
                                            </div>
                                        </div>
                                        <!-- /Project table -->
                                        <!-- Project table -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Loan History</h4>
                                            </div>
                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th class="sticky-th-center">Emp. Code<br/>Loan ID</th>

                                                        <th class="sticky-th-center">Created at</th>
                                                        <th class="sticky-th-center">Manager<br/>Approval</th>
                                                        <th class="sticky-th-center">HR<br/>Approval</th>
                                                        <th class="sticky-th-center">Inst.</th>
                                                        <th class="sticky-th-center">Total<br/>Amount</th>
                                                        <th class="sticky-th-center">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr :class="[loans1.ReqStatus=='Pending' ? 'table-warning' : '', loans1.ReqStatus=='Rejected' ? 'table-danger' : '', loans1.ReqStatus=='Approved' ? 'table-success' : '']"
                                                        :title="[loans1.ReqStatus=='Approved' ? 'This '+loans1.LoanType+' is ready to pay' : '']"
                                                        v-for="loans1 in loans" :key="loans1.LoanId"
                                                        :id="'headingBorder'+loans1.LoanId">
                                                        <td colspan="8" style="vertical-align:middle !important">
                                                            <div>
                                                                <div class="accordion-header d-flex">
                                                                    <div class="col-md-1" style="text-align:center;">
                                                                        <div
                                                                            class="d-flex justify-content-left align-items-center">
                                                                            <div class="d-flex flex-column">
                                                                                <a class="user_name text-truncate text-body"><span
                                                                                    class="fw-bolder">{{
                                                                                        loans1.EmployeeCode
                                                                                    }} </span></a>
                                                                                <small class="emp_post text-muted">
                                                                                    <span>{{ loans1.LoanId }}</span>
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3" style="text-align:center;">
                                                                        {{ loans1.ApplyDate }}
                                                                    </div>
                                                                    <div class="col-md-2" style="text-align:center;">
                                                                        <span class="badge bg-gradient-warning"
                                                                              @click="fetch_emp_upSts(loans1.LoanId, 'man')"
                                                                              v-if="loans1.ManagerApproval=='Pen'"
                                                                              data-bs-toggle="modal"
                                                                              data-bs-target="#updateloanstatus">Pending</span>
                                                                        <span class="badge bg-gradient-success"
                                                                              v-if="loans1.ManagerApproval=='App'">Approved</span>
                                                                        <span class="badge bg-gradient-danger"
                                                                              v-if="loans1.ManagerApproval=='Rej'">Rejected</span>
                                                                    </div>
                                                                    <div class="col-md-2" style="text-align:center;">
                                                                        <span
                                                                            @click="fetch_emp_upSts(loans1.LoanId, 'hr')"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#updateloanstatus"
                                                                            class="badge bg-gradient-warning"
                                                                            v-if="loans1.HrApproval=='Pen'">Pending</span>
                                                                        <span class="badge bg-gradient-success"
                                                                              v-if="loans1.HrApproval=='App'">Approved</span>
                                                                        <span class="badge bg-gradient-danger"
                                                                              v-if="loans1.HrApproval=='Rej'">Rejected</span>
                                                                    </div>
                                                                    <div class="col-md-1" style="text-align:center;">
                                                                        {{ loans1.LoanInstallments }}
                                                                    </div>
                                                                    <div class="col-md-2" style="text-align:center;">
                                                                        {{
                                                                            Math.floor(loans1.LoanAmount).toLocaleString()
                                                                        }}/-
                                                                    </div>
                                                                    <div class="col-md-1" style="text-align:center;">
                                                                        <div class="btn-group">
                                                                            <button class="collapsed"
                                                                                    v-if="loans1.ReqStatus == 'Paid' || loans1.ReqStatus == 'Returned'"
                                                                                    style="border: none;"
                                                                                    @click="installmentDetails(loans1.LoanId)"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    :data-bs-target="'#accordionBorder'+loans1.LoanId"
                                                                                    aria-expanded="false"
                                                                                    :aria-controls="'accordionBorder'+loans1.LoanId">
                                                                                <i class="fa-solid fa-circle-plus"></i>
                                                                            </button>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div :id="'accordionBorder'+loans1.LoanId"
                                                                     class="accordion-collapse collapse"
                                                                     :aria-labelledby="'headingBorder'+loans1.LoanId"
                                                                     :data-bs-parent="'#accordionBorder'+loans1.LoanId">
                                                                    <div class="table-responsive"
                                                                         style="overflow-x: initial !important;">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="sticky-th-center">Inst.<br/>No
                                                                                </th>
                                                                                <th class="sticky-th-center">Installment<br/>Session
                                                                                </th>
                                                                                <th class="sticky-th-center">Installment<br/>Amount
                                                                                </th>
                                                                                <th class="sticky-th-center">Installment<br/>Status
                                                                                </th>

                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr v-for="(get_reqdata11, index) in install_list"
                                                                                :class="[get_reqdata11.InstallmentStatus=='waivedoff' ? 'table-primary' : '', get_reqdata11.InstallmentStatus=='Skipped' ? 'table-secondary' : '']">
                                                                                <td class="td-center">
                                                                                    <p class="card-text mb-25">
                                                                                        {{ index + 1 }}</p>
                                                                                </td>
                                                                                <td class="td-center">
                                                                                    <span>{{
                                                                                            get_reqdata11.InstallmentSession
                                                                                        }}</span>
                                                                                </td>
                                                                                <td class="td-center">
                                                                                    <span>{{
                                                                                            Math.floor(get_reqdata11.InstallmentAmount).toLocaleString()
                                                                                        }}/-</span>
                                                                                </td>
                                                                                <td class="td-center">
                                                                                    <span
                                                                                        v-if="get_reqdata11.InstallmentStatus=='Unpaid'"
                                                                                        class="badge bg-gradient-warning">Unpaid</span>
                                                                                    <span
                                                                                        v-else-if="get_reqdata11.InstallmentStatus=='waivedoff'"
                                                                                        class="badge bg-gradient-primary">Waived Off</span>
                                                                                    <span
                                                                                        v-else-if="get_reqdata11.InstallmentStatus=='Returned'"
                                                                                        class="badge bg-gradient-danger">Returned</span>
                                                                                    <span
                                                                                        v-else-if="get_reqdata11.InstallmentStatus=='Skipped'"
                                                                                        class="badge bg-gradient-secondary">Skipped</span>
                                                                                </td>

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
                                                <!-- <div style="display: flex;">
                                                    <pagination :data="loans" :limit="limit" @pagination-change-page="view_loans"></pagination>
                                                </div> -->
                                            </div>

                                        </div>
                                        <!-- /Project table -->
                                        <!-- Project table -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Fine & Dues</h4>
                                            </div>
                                            <div class="table-responsive" v-if="fine!=''">
                                                <table class="table">
                                                    <thead style="text-align:center">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Amount</th>
                                                        <th>Apply Date</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="text-align:center">
                                                    <tr v-for="fine1 in fine">
                                                        <td>{{ fine1.FineSession }}</td>
                                                        <td>{{ fine1.FineAmount }}</td>
                                                        <td>{{ fine1.FineDate }}</td>
                                                        <td>Fine</td>
                                                        <td>{{ fine1.Status }}</td>
                                                    </tr>
                                                    <tr v-for="dues1 in dues">
                                                        <td>{{ dues1.SessionName }}</td>
                                                        <td>{{ dues1.DuesAmount }}</td>
                                                        <td>{{ dues1.DuesDate }}</td>
                                                        <td>Dues</td>
                                                        <td>{{ dues1.Status }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="card-body pt-1" v-else-if="fine==''">
                                                <label>No fine or dues added yet</label>
                                            </div>
                                        </div>
                                        <!-- /Project table -->
                                        <!-- Project table -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Arrears, Bonuses & Allowances</h4>
                                            </div>
                                            <div v-if="arrears!='' || bonuses!='' || allowances!=''"
                                                 class="table-responsive">
                                                <table class="table">
                                                    <thead style="text-align:center">
                                                    <tr>
                                                        <th>Session</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="text-align:center">
                                                    <tr v-for="arrears1 in arrears">
                                                        <td>{{ arrears1.SessionName }}</td>
                                                        <td>{{ arrears1.ArrearsAmount }}</td>
                                                        <td>{{ arrears1.ArrearDate }}</td>
                                                        <td>Arrears</td>
                                                        <td>
                                                            <span class="badge bg-gradient-warning"
                                                                  v-if="arrears1.Status =='Pending'">Pending</span>
                                                            <span class="badge bg-gradient-success"
                                                                  v-else-if="arrears1.Status =='Approved'">Approved</span>
                                                            <span class="badge bg-gradient-primary"
                                                                  v-else>{{ arrears1.ReqStatus }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr v-for="bonuses1 in bonuses">
                                                        <td>{{ bonuses1.SessionName }}</td>
                                                        <td>{{ bonuses1.BonusAmount }}</td>
                                                        <td>{{ bonuses1.BonusDate }}</td>
                                                        <td>Bonuse</td>
                                                        <td>
                                                            <span class="badge bg-gradient-warning"
                                                                  v-if="bonuses1.Status =='Pending'">Pending</span>
                                                            <span class="badge bg-gradient-success"
                                                                  v-else-if="bonuses1.Status =='Approved'">Approved</span>
                                                            <span class="badge bg-gradient-primary"
                                                                  v-else>{{ bonuses1.ReqStatus }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr v-for="allowances1 in allowances">
                                                        <td>{{ allowances1.StartSession }}</td>
                                                        <td>{{ allowances1.AllowanceAmount }}</td>
                                                        <td>{{ allowances1.ApplyDate }}</td>
                                                        <td>Allowance</td>
                                                        <td>
                                                            <span class="badge bg-gradient-warning"
                                                                  v-if="allowances1.Status =='Pending'">Pending</span>
                                                            <span class="badge bg-gradient-success"
                                                                  v-else-if="allowances1.Status =='Approved'">Approved</span>
                                                            <span class="badge bg-gradient-primary"
                                                                  v-else>{{ allowances1.ReqStatus }}</span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-responsive" v-else>No Arrears, Bonuses or Allowances
                                                history
                                            </div>
                                        </div>
                                        <!-- /Project table -->
                                    </div>
                                </div>
                            </div>
                            <!--/ User Content -->
                            <div class="modal fade" id="suspend_emp" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                    <div class="modal-content">
                                        <div class="modal-header bg-transparent">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-5 px-sm-5 pt-50">
                                            <div class="text-center mb-2">
                                                <h1 class="fw-bolder">Confirmation</h1>
                                                <h5>Do you want to suspend the employee till following date?</h5>
                                                <div class="text-center">
                                                    <div class="col-md-3">
                                                        <strong>Status change date: </strong><span
                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                        <input type="date" class="form-control" v-model="sdate"
                                                               placeholder="Name"/>
                                                        <span style="color: #DB4437; font-size: 11px;" v-if="sdate==''">{{
                                                                e_sdate
                                                            }}</span>
                                                    </div>
                                                    <button v-if="sdate!=''" type="button" @click="suspend(employeeid)"
                                                            class="btn btn-warning waves-effect waves-float waves-light"
                                                            data-bs-dismiss="modal" aria-label="Close">Yes
                                                    </button>
                                                    <button v-else type="button" @click="suspend(employeeid)"
                                                            class="btn btn-danger waves-effect waves-float waves-light">
                                                        Yes
                                                    </button>
                                                    <button type="submit" class="btn btn-outline-primary waves-effect"
                                                            data-bs-dismiss="modal" aria-label="Close">No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="terminate_emp" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                    <div class="modal-content">
                                        <div class="modal-header bg-transparent">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-5 px-sm-5 pt-50">
                                            <div class="text-center mb-2">
                                                <h1 class="fw-bolder">Confirmation</h1>
                                                <h5>Do you want to terminate the employee till following date?</h5>
                                                <div class="text-center">
                                                    <div class="col-md-3">
                                                        <strong>Status change date: </strong><span
                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                        <input type="date" class="form-control" v-model="tdate"
                                                               placeholder="Name"/>
                                                        <span style="color: #DB4437; font-size: 11px;" v-if="tdate==''">{{
                                                                e_tdate
                                                            }}</span>
                                                    </div>
                                                    <button v-if="tdate!=''" type="button"
                                                            @click="terminate(employeeid)"
                                                            class="btn btn-warning waves-effect waves-float waves-light"
                                                            data-bs-dismiss="modal" aria-label="Close">Yes
                                                    </button>
                                                    <button v-else type="button" @click="terminate(employeeid)"
                                                            class="btn btn-danger waves-effect waves-float waves-light">
                                                        Yes
                                                    </button>
                                                    <button type="submit" class="btn btn-outline-primary waves-effect"
                                                            data-bs-dismiss="modal" aria-label="Close">No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="resign_emp" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                    <div class="modal-content">
                                        <div class="modal-header bg-transparent">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-5 px-sm-5 pt-50">
                                            <div class="text-center mb-2">
                                                <h1 class="fw-bolder">Confirmation</h1>
                                                <h5>Do you want to resign the employee on following date?</h5>
                                                <div class="text-center">
                                                    <div class="col-md-3">
                                                        <strong>Status change date: </strong><span
                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                        <input type="date" class="form-control" v-model="rdate"
                                                               placeholder="Name"/>
                                                        <span style="color: #DB4437; font-size: 11px;" v-if="rdate==''">{{
                                                                e_rdate
                                                            }}</span>
                                                    </div>
                                                    <button v-if="rdate!=''" type="button" @click="resigned(employeeid)"
                                                            class="btn btn-warning waves-effect waves-float waves-light"
                                                            data-bs-dismiss="modal" aria-label="Close">Yes
                                                    </button>
                                                    <button v-else type="button" @click="resigned(employeeid)"
                                                            class="btn btn-danger waves-effect waves-float waves-light">
                                                        Yes
                                                    </button>
                                                    <button type="submit" class="btn btn-outline-primary waves-effect"
                                                            data-bs-dismiss="modal" aria-label="Close">No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
Vue.filter('formatTime', function (value) {
    if (value) {
        const parts = value.split(":");
        return +parts[0] + ":" + +parts[1];
    } else {
        return ""
    }
});
export default {
    data() {
        return {
            limit: 10,
            page1: 1,
            fuel: '',
            stipend: '',
            allowance: '',
            activeClass: 'table-secondary',
            primaryClass: 'table-primary',

            url: process.env.MIX_APP_URL,
            tdate: '',
            e_tdate: '',
            rdate: '',
            e_rdate: '',
            sdate: '',
            e_sdate: '',
            employeeid: '',
            emp_warning: {},
            datefrom: '',
            e_datefrom: '',
            dateto: '',
            e_dateto: '',
            emp_id: '',

            id: this.$route.params.id,

            rep1: '',
            rep2: '',
            emp_detail: {},
            edu_detail: {},
            exp_detail: {},
            rep_employees: {},

            com_year: '',
            percent: {},
            disabled: false,
            timeout: null,

            value: '100',

            leaves: {},
            leavesblnc: {},

            shift_name: '',
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
            install_list: {},
            attendance: {},
            pay_loanID: '',
            all_sals: {},
            fine: {},
            dues: {},
            loans: {},
            arrears: {},
            bonuses: {},
            allowances: {},
            leavesLoaded: false,      // Flag to track if leaves data has been loaded
        leavesblncLoaded: false   ,
        timetableLoaded: false,      // Flag to track if timetable data has been loaded
        attendanceLoaded: false ,
        arrearsLoaded: false,
        bonusesLoaded: false,
        allowancesLoaded: false,
        loansLoaded: false,
        fineLoaded: false,
        duesLoaded: false
        }
    },
    methods: {


        dayname(dateS) {
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var d = new Date(dateS);
            return days[d.getDay()];
        },
        get_id(id) {
            this.employeeid = id;
        },
        registered(id) {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            axios.get('./registered/' + id)
                .then((response) => {
                    this.emp_detail = response.data.data
                    this.$toastr.s("Registered Employee Successfully", "Congratulations!");

                })
                .catch(error => {
                    this.$toastr.e('error Occur while Regintering employee');
                });
        },
        resigned(id) {
            if (this.rdate == "") {
                this.e_rdate = 'Select date';
                this.$toastr.e("Select resigned date!", "Error!");
            } else {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                axios.get('./resigned_emp/' + id + '/' + this.rdate)
                    .then((response) => {
                        this.emp_detail = response.data
                        this.$toastr.s("Resigned Employee Successfully", "Congratulations!");
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while resign  Timetabel');
                    });
            }
        },
        suspend(id) {
            if (this.sdate == "") {
                this.e_sdate = 'Select date';
                this.$toastr.e("Select suspension end date!", "Error!");
            } else {
                this.e_sdate = '';
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                axios.get('./suspend_emp/' + id + '/' + this.sdate)
                    .then((response) => {
                        this.emp_detail = response.data;
                        this.$toastr.s("Employee Suspended Successfully", "Congratulations!");
                        this.sdate = '';
                    })
                    .catch(error => {
                        this.$toastr.e('error Occur while suspend employee');
                    });
            }
        },
        leavedata() {
        // Check if leaves data has not been loaded
        if (!this.leavesLoaded) {
            axios.get('selected_emp_leaves/' + this.id)
                .then(data => {
                    this.leaves = data.data.data;
                    this.leavesLoaded = true;  // Mark leaves data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee leaves');
                });
        }

        // Check if leavesblnc data has not been loaded
        if (!this.leavesblncLoaded) {
            axios.get('selected_emp_leaves_blnc/' + this.id)
                .then(data => {
                    this.leavesblnc = data.data.data;
                    this.leavesblncLoaded = true;  // Mark leavesblnc data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee leaves balance');
                });
        }
    },
    attendencedata(){
        if (!this.timetableLoaded) {
        axios.get('selected_emp_timeTable/' + this.id)
            .then(response => {
                this.shift_name = response.data.data[0].RosterName;
                var u_mon = response.data.data[0].Mon.split('-');
                this.u_mon_in = u_mon[0];
                this.u_mon_out = u_mon[1];

                var u_tue = response.data.data[0].Tue.split('-');
                this.u_tue_in = u_tue[0];
                this.u_tue_out = u_tue[1];

                var u_wed = response.data.data[0].Wed.split('-');
                this.u_wed_in = u_wed[0];
                this.u_wed_out = u_wed[1];

                var u_thu = response.data.data[0].Thu.split('-');
                this.u_thu_in = u_thu[0];
                this.u_thu_out = u_thu[1];

                var u_fri = response.data.data[0].Fri.split('-');
                this.u_fri_in = u_fri[0];
                this.u_fri_out = u_fri[1];

                var u_sat = response.data.data[0].Sat.split('-');
                this.u_sat_in = u_sat[0];
                this.u_sat_out = u_sat[1];

                var u_sat = response.data.data[0].Sun.split('-');
                this.u_sun_in = u_sat[0];
                this.u_sun_out = u_sat[1];

                this.timetableLoaded = true;
            })
            .catch(error => {
                this.$toastr.e('error Occur while getting employee Timetabel');
            });
        }
        if (!this.attendanceLoaded)  {
        axios.get('this_user_attendence/' + this.id)
            .then(data =>{ this.attendance = data.data.data
                this.attendanceLoaded = true;
            })
            .catch(error => {
                this.$toastr.e('error Occur while getting employee attendence');
            });
        }
    },
    financialdata() {
        // Check if arrears data has not been loaded
        if (!this.arrearsLoaded) {
            axios.get('fetch_emp_arrears/' + this.id)
                .then(response => {
                    this.arrears = response.data.data;
                    this.arrearsLoaded = true;  // Mark arrears data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee arrears');
                });
        }

        // Check if bonuses data has not been loaded
        if (!this.bonusesLoaded) {
            axios.get('fetch_emp_bonuses/' + this.id)
                .then(data => {
                    this.bonuses = data.data.data;
                    this.bonusesLoaded = true;  // Mark bonuses data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee bonuses');
                });
        }

        // Check if allowances data has not been loaded
        if (!this.allowancesLoaded) {
            axios.get('fetch_emp_allowances/' + this.id)
                .then(data => {
                    this.allowances = data.data.data;
                    this.allowancesLoaded = true;  // Mark allowances data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee allowances');
                });
        }

        // Check if loans data has not been loaded
        if (!this.loansLoaded) {
            axios.get('fetch_employee_loans/' + this.id)
                .then(data => {
                    this.loans = data.data.data;
                    this.loansLoaded = true;  // Mark loans data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee loans');
                });
        }

        // Check if fine data has not been loaded
        if (!this.fineLoaded) {
            axios.get('fetch_emp_fine/' + this.id)
                .then(data => {
                    this.fine = data.data.data;
                    this.fineLoaded = true;  // Mark fine data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee fine');
                });
        }

        // Check if dues data has not been loaded
        if (!this.duesLoaded) {
            axios.get('fetch_emp_dues/' + this.id)
                .then(data => {
                    this.dues = data.data.data;
                    this.duesLoaded = true;  // Mark dues data as loaded
                })
                .catch(error => {
                    this.$toastr.e('Error occurred while getting employee dues');
                });
        }
    },
        terminate(id) {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            axios.get('./terminate_emp/' + id + '/' + this.tdate)
                .then((response) => {
                    this.emp_detail = response.data
                    this.$toastr.s("Employee terminated Successfully!", "Congratulations!");
                })
                .catch(error => {
                    this.$toastr.e('error Occur while terminated employee');
                });
        },
        installmentDetails(id) {
            axios.get("installments_detail/" + id)
                .then((response) => {
                    this.install_list = response.data;
                })
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
                    this.pay_loanID = this.usid;
                    this.pay_type = responce.data[0].LoanType;
                    this.pay_emp_id = responce.data[0].EmployeeID;
                    this.us_reason = responce.data[0].LoanReason;
                    this.us_c_name = responce.data[0].Name;
                    this.us_amount = Number(responce.data[0].LoanAmount);
                    this.fix_amount = Number(responce.data[0].LoanAmount);
                    this.us_installments = responce.data[0].LoanInstallments;
                    this.us_type = responce.data[0].LoanType;
                    this.us_date = responce.data[0].ApplyDate;
                    this.us_m_sts = responce.data[0].ManagerApproval;
                    this.us_hr_sts = responce.data[0].HrApproval;
                })
        },
        employee_salaries(page = 1){
this.page1 = page;
            axios.get('salaries_history/' + this.id + '?page=' + page)
                .then(response => this.all_sals = response.data.data)
                .catch(error => {
                    this.$toastr.e('Error Occur while getting employee history!', 'Error!');
                });
        }
    },
    mounted() {


        this.employee_salaries();

        axios.get('getindemployee_detail/' + this.id)
            .then(data => {
                this.emp_detail = data.data.data;
            }).catch(error => {
            this.$toastr.e('error Occur while getting employee');
        });

        axios.get('getemployee_education/' + this.id)
            .then(data => {
                this.edu_detail = data.data.data;
            }).catch(error => {
            this.$toastr.e('Error occur while getting employee Eduaction');
        });

        axios.get('fetch_employee_amount/' + this.id)
            .then(data => {
                this.stipend = data.data.data.stipend;
                this.com_year = data.data.data.years;
                this.allowance = data.data.data.allowance;
                this.fuel = data.data.data.fuel;

            })
            .catch(error => {
                this.$toastr.e('error Occur while getting employee amount');
            });

        axios.get('getwarnig_emp/' + this.id)
            .then(data => {

                this.emp_warning = data.data.data;
                if (this.emp_warning == '') {
                    this.emp_warning = [];
                }
            }).catch(error => {
            this.$toastr.e('error Occur while getting employee warning');
        });

        axios.get('getemployee_exp/' + this.id)
            .then(data => {
                this.exp_detail = data.data.data;
            }).catch(error => {
            this.$toastr.e('error Occur while getting employee experence');
        });

        axios.get('reporting_employees/' + this.id)
            .then(data => {
                this.rep_employees = data.data.data;
            }).catch(error => {
            this.$toastr.e('error Occur while getting reporting employee ');
        });

        axios.get('./success_array/' + this.id)
            .then((response) => this.percent = response.data.data)
            .catch(error => {
                this.$toastr.e('Error Occur while getting success arrary');
            });






    },
}

</script>
