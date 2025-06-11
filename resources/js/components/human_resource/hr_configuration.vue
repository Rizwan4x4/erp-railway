<template>
    <div >
        <!-- BEGIN: Content-->
        <div class="app-content content ">
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
                                HR Configurations
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <section id="accordion-with-border">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">Sessions Detail</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Session Name</th>
                                                                                <th>Start</th>
                                                                                <th>End</th>
                                                                                <th>Status</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="odd" v-for="adsdata1 in adsdata.data">
                                                                                <td>{{adsdata1.SessionName}}</td>
                                                                                <td>{{adsdata1.StartDate}}</td>
                                                                                <td>{{adsdata1.EndDate}}</td>
                                                                                <td>
                                                                                    <span class="badge bg-gradient-success" v-if="adsdata1.CurrentSession==1">Running</span>
                                                                                    <span v-if="hasPermission('HR Controller Session Detail Status') ">
                                                                                        <a v-if="adsdata1.AttClosedPayrollStart=='Open'">
                                                                                            <span @click="fetch_session_id(adsdata1.SessionID)" data-bs-toggle="modal" data-bs-target="#hireinterview" v-if="adsdata1.EndDate <= date" class="badge bg-gradient-info" style="cursor: pointer;">Open</span>
                                                                                            <span v-else class="badge bg-gradient-info" style="cursor: pointer;">Open</span>
                                                                                        </a>
                                                                                        <a v-else>
                                                                                            <span class="badge bg-gradient-warning">Closed</span>
                                                                                        </a>
                                                                                    </span>
                                                                                    <span v-else>
                                                                                        <a v-if="adsdata1.AttClosedPayrollStart=='Open'">
                                                                                            <span class="badge bg-gradient-info">Open</span>
                                                                                        </a>
                                                                                        <a v-else>
                                                                                            <span class="badge bg-gradient-warning">Closed</span>
                                                                                        </a>
                                                                                    </span>
                                                                                </td>
                                                                                <td >
                                                                                    <a @click="delete_session(adsdata1.SessionID)" class="text-danger">
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                                <!-- <td v-else>
                                                                                    <a class="text-danger">
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                    </a>
                                                                                </td> -->
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div style="text-align:center;padding-top:20px">
                                                                    <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-body">
                                        <section id="accordion-with-border">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">Warning Reasons Detail</h4>
                                                                <a v-if="hasPermission('HR Controller warning reason add new')"  data-bs-toggle="modal" data-bs-target="#addWarnReas" class="btn btn-outline-primary waves-effect">+ Add new</a>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Warning Reason</th>
                                                                                <th>Description</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="odd" v-for="warning_reason1 in warning_reason.data">
                                                                                <td>{{warning_reason1.ReasonName}}</td>
                                                                                <td v-html="warning_reason1.ReasonContent"></td>

                                                                                <td class="td-center">
                                                <div  class="btn-group">
                                                    <a v-if="hasPermission('HR Controller warning reason actions')" data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <a @click="delete_warn_reason(warning_reason1.ReasonID)" class="dropdown-item" >
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                        Delete Warning
                                                                                    </a>
                                                                                    <a  class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditWarning" @click="Edit_warn_reason(warning_reason1.ReasonID)">
                                                                                        <i class="fa-solid fa-pen"></i>
                                                                                        Update Warning
                                                                                    </a>



                                                    </div>
                                                </div>
                                            </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div style="text-align:center;padding-top:20px">
                                                                    <pagination :data="warning_reason" @pagination-change-page="getResult5"></pagination>
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
                        </div>
                        <!-- User Sidebar -->
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-body">
                                        <section id="accordion-with-border">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">Holidays Detail</h4>
                                                                <a v-if="hasPermission('HR Controller inchlude holiday')" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect">Include Holiday</a>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive" style="overflow-x: initial !important;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Holiday Name</th>
                                                                                <th>Start</th>
                                                                                <th>End</th>
                                                                                <th>No.of days</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="odd" v-for="holiday_data1 in holiday_data.data">
                                                                                <td>{{holiday_data1.HolidayName}}</td>
                                                                                <td>{{holiday_data1.holidaystartDate}}</td>
                                                                                <td>{{holiday_data1.HolidayEndDate}}</td>
                                                                                <td>{{holiday_data1.NoOfDays}}</td>
                                                                                <td>
                                                                                    <a v-if="hasPermission('HR Controller delete holiday')" @click="delete_holiday(holiday_data1.HolidayID)" class="me-25">
                                                                                        <i style="color:#d42f2f" class="fa-solid fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div style="text-align:center;padding-top:20px">
                                                                    <pagination :data="holiday_data" @pagination-change-page="getResult2"></pagination>
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
                            <!--/ User Sidebar -->
                            <div class="modal fade" id="EditWarning" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h5>Update Warning Template</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Warning Reason</label>
                                <input disabled v-model="edit_warning_reason" type="text" class="form-control" />
                            </div>


                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Description</label>
                                <vue-editor  v-model="edit_warning_description" class="form-control" placeholder="Reason Description"></vue-editor>

                            </div>
                            <div class="col-12 text-center">

                                <button type="submit" :disabled="disabled1" @click="update_Warning()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <section id="accordion-with-border">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title">Leave Types</h4>
                                                                <a v-if="hasPermission('HR Controller Add leave type')" data-bs-toggle="modal" data-bs-target="#leavetype" class="btn btn-outline-primary waves-effect">Add Leave Type</a>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive" style="overflow-x: initial !important; min-height:271px">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Leave Type</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="odd" v-for="l_types1 in l_types.data">
                                                                                <td>{{l_types1.LeaveType}}</td>
                                                                                <td>
                                                                                    <a v-if="hasPermission('HR Controller delete leave type')" @click="delete_leave(l_types1.LeaveID)" class="me-25">
                                                                                        <i style="color:#d42f2f" class="fa-solid fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div style="text-align:center;padding-top:20px">
                                                                    <pagination :data="l_types" @pagination-change-page="getResult3"></pagination>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card">
                                <div class="card-body">
                                    <section id="accordion-with-border">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">HR Configuration</h4>

                                                        </div>
                                                        <div class="card-body">

                                                            <div class="row">
                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Gratuty Start From (Days)</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="gratuty_start">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.gratuty_start==''">{{e_gratuty_start}}</span>
                                                                </div>
                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Max Loan Allowed (Times of salary)</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="max_loan">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.max_loan==''">{{e_max_loan}}</span>
                                                                </div>
                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Minutes Per Deducation</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="days_deduction">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.days_deduction==''">{{e_days_deduction}}</span>
                                                                </div>
                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Maximium Installment</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="max_installment">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.max_installment==''">{{e_max_installment}}</span>
                                                                </div>
                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Annual Leaves (after probation end)</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="annual_leaves">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.annual_leaves==''">{{e_annual_leaves}}</span>
                                                                </div>
                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Sick Leaves (per fiscal year)</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="sick_leaves">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.sick_leaves==''">{{e_sick_leaves}}</span>
                                                                </div>

                                                                <div class="col-12 col-sm-3 mb-1">
                                                                    <label class="form-label" for="accountFirstName">Casual Leaves (per fiscal year)</label>
                                                                    <label style="color: #d93025">*</label>
                                                                    <input type="number" class="form-control" id="accountFirstName" v-model="casual_start">
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="this.casual_start==''">{{e_casual_start}}</span>
                                                                </div>
                                                                <div  class="col-12 col-sm-3 mb-1" style="padding-top: 25px;">
                                                                    <button v-if="hasPermission('HR Controller hr configuration update')" type="submit" :disabled="disabled3" @click="delay3()" style="width:100%" class="btn btn-primary me-1 mt-1">Update</button>
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
                            <!-- /User Card -->
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card">
                                <div class="card-body">
                                    <section id="accordion-with-border">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">Fine Detail</h4>
                                                            <a v-if="hasPermission('HR Controller add new fine')" data-bs-toggle="modal" data-bs-target="#finemodal" class="btn btn-outline-primary waves-effect">Add New Fine</a>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive" style="overflow-x: initial !important;">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Emp.Code</th>
                                                                            <th>Name</th>
                                                                            <th>Fine Session</th>

                                                                            <th>Amount</th>
                                                                            <th>Fine Date</th>
                                                                            <th>Remarks</th>
                                                                            <th>Issued</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="odd" v-for="finedetail1 in finedetail.data">
                                                                            <td>{{finedetail1.EmployeeCode}}</td>
                                                                            <td>{{finedetail1.Name}}</td>
                                                                            <td>{{finedetail1.FineSession}}</td>
                                                                            <td>{{finedetail1.FineAmount}}</td>
                                                                            <td>{{finedetail1.FineDate}}</td>
                                                                            <td>{{finedetail1.Remarks}}</td>
                                                                            <td>{{finedetail1.CreatedBy}}</td>
                                                                            <td>
                                                                                <a @click="delete_fine(finedetail1.FineId)" class="me-25">
                                                                                    <i style="color:#d42f2f" class="fa-solid fa-trash"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div style="text-align:center;padding-top:20px">
                                                                <pagination :data="finedetail" @pagination-change-page="getResult4"></pagination>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <!-- /User Card -->
                        </div>

                    </section>
                    <!-- Add warning reason model-->
                    <div class="modal fade" id="addWarnReas" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Add Warning Reason</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Reason Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="reason_name" class="form-control" placeholder="Reason Name">
                                            <span style="color: #DB4437; font-size: 11px;" v-if="reason_name==''">{{e_reason_name}}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Reason Description</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <vue-editor  v-model="reason_desc" class="form-control" placeholder="Reason Description"></vue-editor>

                                            <span style="color: #DB4437; font-size: 11px;" v-if="reason_desc==''">{{e_reason_desc}}</span>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled5" @click="delay5()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Add warning reason model-->
                    <!-- Add holiday model-->
                    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Include Holiday</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Holiday Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="h_holiday_name" class="form-control" placeholder="Holiday Name">
                                            <span style="color: #DB4437; font-size: 11px;" v-if="h_holiday_name==''">{{e_holiday_name}}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Date From</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input v-model="h_date_from" type="date" id="modalAddCardName" class="form-control" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="h_date_from==''">{{e_date_from}}</span>
                                        </div>
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="basicSelect">Select Days</label>
                                            <div class="row demo-inline-spacing" style="padding-left: 5%;">
                                                <div class="col-md-5 form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="days" name="inlineRadioOptions" id="inlineRadio1" value="One Day" checked="">
                                                    <label class="form-check-label" for="inlineRadio1">One Day</label>
                                                </div>
                                                <div class=" col-md-5 form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="days" name="inlineRadioOptions" id="inlineRadio2" value="Multiple Days">
                                                    <label class="form-check-label" for="inlineRadio2">Multiple Days</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="this.days=='Multiple Days'" class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Date To</label>
                                            <input v-model="h_date_to" type="date" id="modalAddCardName" class="form-control" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Description</label>
                                            <input v-model="h_description" type="text" id="modalAddCardName" class="form-control" />
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Add holiday model-->

                </div>
            </div>
        </div>
        <div class="modal fade" id="leavetype" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Add leave type</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Leave Type</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <input type="text" v-model="l_type" class="form-control" placeholder="Leave type">
                                <span style="color: #DB4437; font-size: 11px;" v-if="l_type==''">{{e_l_type}}</span>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled2" @click="delay2()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="hireinterview" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                np
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="fw-bolder">Confirmation</h1>
                            <h5>Do you want to Close this session and move employees attendance to payroll?</h5>
                            <div class="text-center" style="text-align:center">
                                <button type="button" @click="update_session_payroll()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add fine model-->
        <div class="modal fade" id="finemodal" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Issued Fine To Employee</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Employee Id</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <select v-model="emp_emp_id" class="form-control">
                                    <option value="">Select Employee</option>
                                    <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>{{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}</option>
                                </select>
                                <span style="color: #DB4437; font-size: 11px;" v-if="emp_emp_id==''">{{e_emp_id}}</span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Fine Amount</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <input v-model="emp_amount" type="number" id="modalAddCardName" class="form-control" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="emp_amount==''">{{e_emp_amount}}</span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Reason</label>
                                <input v-model="emp_reason" type="text" id="modalAddCardName" class="form-control" />

                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled4" @click="delay4()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Add fine model-->
    </div>
</template>
<script>
    export default {
        data() {
            let currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 5);
            return {
                date: currentDate.toJSON().slice(0, 10),
                //date: new Date().toJSON().slice(0, 10),
                edit_warning_description:'',
                edit_warning_reason:'',
                adsdata: {},
                days: 'One Day',
                h_holiday_name: '',
                h_date_from: '',
                e_holiday_name: '',
                e_date_from: '',
                h_date_to: '',
                h_description: '',
                holiday_data: {},
                warning_reason: {},
                l_type: '',
                e_l_type: '',
                l_types: {},
                gratuty_start: '',
                max_loan: '',
                days_deduction: '',
                max_installment: '',
                annual_leaves: '',
                sick_leaves: '',
                casual_start: '',

                e_gratuty_start: '',
                e_max_loan: '',
                e_days_deduction: '',
                e_max_installment: '',
                e_annual_leaves: '',
                e_sick_leaves: '',
                e_casual_start: '',

                fetch_sessoin_id: '',

                e_emp_id: '',
                e_emp_amount: '',

                reason_name: '',
                reason_desc: '',

                e_reason_name: '',
                e_reason_desc: '',

                finedetail: {},
                find_emp: {},
                emp_emp_id: '',
                emp_amount: '',
                emp_reason: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,

                disabled2: false,
                timeout2: null,

                disabled3: false,
                timeout3: null,

                disabled4: false,
                timeout4: null,

            disabled5: false,
            timeout5: null,
            warn_id: '',
        }
    },

    methods: {
        update_Warning() {
            axios.post('update_warningdetail', {
                warnReasonName: this.edit_warning_reason,
                warnReasonDesc: this.edit_warning_description,
                warnReasonID: this.warn_id,
            })
                .then(data => {
                    if (data.data == 'Warning Updated')
                    this.$toastr.s(data.data, "Congratulations");
                        const updatedIndex = this.warning_reason.data.findIndex(item => item.ReasonID === this.warn_id);
            if (updatedIndex !== -1) {

                this.warning_reason.data[updatedIndex].ReasonName = this.edit_warning_reason;
                this.warning_reason.data[updatedIndex].ReasonContent = this.edit_warning_description;




                // Update other properties as needed
            }
                });
        },
        Edit_warn_reason(id) {
            axios.get('get_warningreason_byId/' + id)
                .then(response => {
                    console.log("warning reason by id ", response.data[0].ReasonContent)
                    this.edit_warning_description = response.data[0].ReasonContent;
                    this.edit_warning_reason = response.data[0].ReasonName;
                    this.warn_id = response.data[0].ReasonID;
                })
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.submit_holiday()
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
            this.submit_leave()
        },
        delay3() {
            this.disabled3 = true
            this.timeout3 = setTimeout(() => {
                this.disabled3 = false
            }, 5000)
            this.submit_configuration()
        },
        delay4() {
            this.disabled4 = true
            this.timeout4 = setTimeout(() => {
                this.disabled4 = false
            }, 5000)
            this.submit_fine()
        },
        delay5() {
            this.disabled5 = true
            this.timeout5 = setTimeout(() => {
                this.disabled5 = false
            }, 5000)
            this.submit_warning_reason()
        },
        fetch_session_id(id) {
            this.fetch_sessoin_id = id;
        },
        update_session_payroll() {
            axios.get('update_payroll_status/' + this.fetch_sessoin_id)
                .then(response => {
                    if (response.data == 'session closed') {
                        this.getResult();
                        this.$toastr.s("Session Closed and Salaries process started!", "Information!");
                    }
                })
            // this.$router.go(0);
        },

            submit_warning_reason() {
                if (this.reason_name == '' || this.reason_desc == '') {
                    if (this.reason_name == '') {
                        this.e_reason_name = "Enter reason name";
                    }
                    else {
                        this.e_reason_name = "";
                    }
                    if (this.reason_desc == '') {
                        this.e_reason_desc = "Enter reason description";
                    }
                    else {
                        this.e_reason_desc = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {


                    axios.post('submit_warn_reas', {
                        reason_name: this.reason_name,
                        reason_desc: this.reason_desc,
                    })
                        .then(data => {
                            if (data.data == 'Warning reason added') {
                                this.$toastr.s("Warning reason has been added!", "Congratulations!");
                                this.e_reason_name = "";
                                this.e_reason_desc = "";
                                this.reason_name = "";
                                this.reason_desc = "";

                                this.getResult5();
                            }
                        })
                }
            },
            submit_configuration() {
                if (this.gratuty_start == '' || this.max_loan == '' || this.days_deduction == '' || this.max_installment == '' || this.annual_leaves == '' || this.sick_leaves == '' || this.casual_start == '') {
                    if (this.gratuty_start == '') {
                        this.e_gratuty_start = "Number of days required";
                    }
                    else {
                        this.e_gratuty_start = "";
                    }
                    if (this.max_loan == '') {
                        this.e_max_loan = "Salary multiple required";
                    }
                    else {
                        this.e_max_loan = "";
                    }
                    if (this.days_deduction == '') {
                        this.e_days_deduction = "Minuts required";
                    }
                    else {
                        this.e_days_deduction = "";
                    }
                    if (this.max_installment == '') {
                        this.e_max_installment = "Number of installments required";
                    }
                    else {
                        this.e_max_installment = "";
                    }
                    if (this.annual_leaves == '') {
                        this.e_annual_leaves = "Number of leaves required";
                    }
                    else {
                        this.e_annual_leaves = "";
                    }
                    if (this.sick_leaves == '') {
                        this.e_sick_leaves = "Number of leaves required";
                    }
                    else {
                        this.e_sick_leaves = "";
                    }
                    if (this.casual_start == '') {
                        this.e_casual_start = "Number of leaves required";
                    }
                    else {
                        this.e_casual_start = "";
                    }
                    this.$toastr.e("All fields required to update Configuration!", "Warning");
                }
                else {

                    axios.post('submit_config', {
                        gratuty_start: this.gratuty_start,
                        max_loan: this.max_loan,
                        days_deduction: this.days_deduction,
                        max_installment: this.max_installment,
                        annual_leaves: this.annual_leaves,
                        sick_leaves: this.sick_leaves,
                        casual_start: this.casual_start,
                    })
                        .then(data => {
                            this.$toastr.s("Updated Configuration Successfully!", "Congratulations");
                        })
                }
            },
            submit_leave() {
                if (this.l_type == '') {
                    this.e_l_type = "Defile leave type";
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    // console.log("empty data");

                }
                else {
                    this.e_l_type = "";
                    // console.log("Submitting leave type:", this.l_type);
                    axios.post('submit_l', {
                        l_type: this.l_type
                    })
                        .then(data => {
                            // console.log("we are in done condition   ", this.l_type);
                            this.l_types = data.data;
                            this.l_type = "";
                            this.$toastr.s("Add Leave Type Successfully!", "Congratulations");
                        })
                }
            },
            submit_holiday() {
                if (!this.h_date_to == "") {
                    if (this.h_date_to < this.h_date_from) {

                        this.$toastr.e("Date To cannat be smaller then Date From!", "Caution!");
                    }
                }
                if (this.h_holiday_name == '' || this.h_date_from == '') {
                    if (this.h_holiday_name == '') {
                        this.e_holiday_name = "Enter holiday name";
                    }
                    else {
                        this.e_holiday_name = "";
                    }
                    if (this.h_date_from == '') {
                        this.e_date_from = "Enter date";
                    }
                    else {
                        this.e_date_from = "";
                    }

                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {

                    axios.post('submit_holidays', {
                        h_holiday_name: this.h_holiday_name,
                        h_date_from: this.h_date_from,
                        h_date_to: this.h_date_to,
                        h_description: this.h_description,
                        h_days: this.days,
                    })
                        .then(data => {

                            this.$toastr.s("Holiday Added Successfully!", "Holiday");
                            this.h_holiday_name = "";
                            this.h_date_from = "";
                            this.h_date_to = "";
                            this.h_description = "";
                            this.getResult2();

                        })
                }
            },
            delete_leave(id) {
                axios.get('delete_leave_type/' + id)
                    .then(response => {
                        this.$toastr.s("Delete Record Successfully!", "Deleted");
                        this.l_types = response.data

                    })
                    .catch(error => { });

            },
            delete_holiday(id) {
                axios.get('delete_holiday/' + id)
                    .then(response => {
                        this.$toastr.s("Delete Record Successfully!", "Deleted");
                        this.holiday_data = response.data

                    })
                    .catch(error => { });

            },
            delete_warn_reason(id) {
                axios.get('delete_warn_reas/' + id)
                    .then(response => {
                        this.$toastr.s("Warning Reason Deleted Successfully!", "Deleted");
                        this.warning_reason = response.data

                    })
                    .catch(error => { });

            },

            delete_session(id) {
                axios.get('delete_session/' + id)
                    .then(response => {
                        this.$toastr.s("Delete Record Successfully!", "Deleted");
                        this.adsdata = response.data

                    })
                    .catch(error => { });

            },
            delete_fine(id) {
                axios.get('delete_fine/' + id)
                    .then(response => {
                        this.$toastr.s("Delete Record Successfully!", "Deleted");
                        this.finedetail = response.data

                    })
                    .catch(error => { });

            },
            getResult(page = 1) {
                axios.get('session_detail/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
            getResult2(page = 1) {

                axios.get('holiday_detail/?page=' + page)
                    .then(response => this.holiday_data = response.data)
                    .catch(error => { });
            },
            getResult3(page = 1) {

                axios.get('view_leave_type/?page=' + page)
                    .then(response => this.l_types = response.data)
                    .catch(error => { });
            },
            getResult4(page = 1) {

                axios.get('view_fine_detail/?page=' + page)
                    .then(response => this.finedetail = response.data)
                    .catch(error => { });
            },
            getResult5(page = 1) {

                axios.get('warning_reason/?page=' + page)
                    .then(response => this.warning_reason = response.data)
                    .catch(error => { });
            },
            submit_fine() {
                if (this.emp_emp_id == '' || this.emp_amount == '') {
                    if (this.emp_emp_id == '') {
                        this.e_emp_id = "Select employee id";
                    }
                    else {
                        this.e_emp_id = "";
                    }
                    if (this.emp_amount == '') {
                        this.e_emp_amount = "Enter amount";
                    }
                    else {
                        this.e_emp_amount = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post('submit_fine', {
                        emp_emp_id: this.emp_emp_id,
                        emp_amount: this.emp_amount,
                        emp_reason: this.emp_reason,
                    })
                        .then(data => {
                            this.finedetail = data.data
                            this.$toastr.s("Applied Fine Successfully!", "Congratulations");
                            this.emp_emp_id = "";
                            this.emp_amount = "";
                            this.emp_reason = "";

                        })
                        .catch(error => { });
                }
            },
        },
        mounted() {



            this.getResult();
            this.getResult2();
            this.getResult3();
            this.getResult4();
            this.getResult5();
            axios.get('view_hr_configuration')
                .then(response => {
                    this.gratuty_start = response.data[0].GratutyStart;
                    this.max_loan = response.data[0].MaxLoan;
                    this.days_deduction = response.data[0].MinutesDeduction;
                    this.max_installment = response.data[0].MaxInstallment;
                    this.annual_leaves = response.data[0].AnnualLeaves;
                    this.sick_leaves = response.data[0].SickLeaves;
                    this.casual_start = response.data[0].CasualLeaves;

                })
                .catch(error => { });
            axios.get('find_emp_id')
                .then(data => this.find_emp = data.data.data)
                .catch(error => { });
        }
    }

</script>
