<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                HRMS
                            </li>
                            <li class="breadcrumb-item active">
                                Leaves Applications
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <section class="app-user-view-account">
                <div class="row">
                    <!-- User Sidebar -->
                    <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                        <div class="card border-0 top-radius bottom-radius">
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="demo-inline-spacing">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#addNewCard"
                                                    class="btn btn-primary bg-primary waves-effect">Apply Leave
                                                </button>
                                                <router-link to="/hr/leaves_dashbaord" type="button"
                                                    class="btn btn-success waves-effect">Leave Balances
                                                </router-link>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="demo-inline-spacing">
                                                <input autocomplete="off" type="text" style="min-width: 280px;"
                                                    v-model="keyword1" class="form-control"
                                                    placeholder="Search By Employee Code/Name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-2 user_role">
                                            <label class="form-label" for="UserRole"><img class="px-1"
                                                    :src="images.solar_filter_linear" alt="icon">Leave Type</label>
                                            <multiselect :show-labels="false"
                                                style="margin-right: 10px; font-size: 15px;" id="UserRole"
                                                placeholder="All Types" v-model="leave" :options="options">
                                            </multiselect>
                                        </div>
                                        <div class="col-md-3 user_status">
                                            <label class="form-label" for="FilterTransaction"><img class="px-1"
                                                    :src="images.solar_filter_linear" alt="icon">Department</label>
                                            <multiselect :show-labels="false"
                                                style="margin-right: 10px; font-size: 12px;" id="FilterTransaction"
                                                placeholder="All Departments" v-model="department" :options="options3">
                                            </multiselect>
                                        </div>
                                        <div class="col-md-3 user_role">
                                            <label class="form-label" for="UserRole"><img class="px-1"
                                                    :src="images.solar_filter_linear" alt="icon">Designation</label>
                                            <multiselect :show-labels="false"
                                                style="margin-right: 10px; font-size: 15px;" id="UserRole"
                                                placeholder="All Designations" v-model="designation"
                                                :options="options1"></multiselect>
                                        </div>
                                        <div class="col-md-2 user_plan">
                                            <label class="form-label" for="UserPlan"><img class="px-1"
                                                    :src="images.solar_filter_linear" alt="icon">Location</label>
                                            <multiselect :show-labels="false"
                                                style="margin-right: 10px; font-size: 15px;" id="UserPlan"
                                                placeholder="All Locations" v-model="location" :options="options2">
                                            </multiselect>
                                        </div>
                                        <div class="col-md-1 user_status d-flex align-items-center mt-4">
                                            <button @click="getbyfilter()"
                                                class="btn btn-primary bg-primary py-2 px-3">Search
                                            </button>
                                        </div>
                                        <div class="col-md-1 user_status">
                                            <a v-b-toggle.my-collapse
                                                style="margin-left:10px;background:transparent;font-weight:900">
                                                <i class="fa-solid fa-up-right-and-down-left-from-center"
                                                    style="padding-right:10px;font-size:28px;margin-top:30px"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <b-collapse id="my-collapse">
                                        <div style="min-height: 70px;" class="advanced">
                                            <div class="row">
                                                <div class="col-md-2 user_status">
                                                    <label class="form-label" id="FilterTransaction"
                                                        for="FilterTransaction"><img class="px-1"
                                                            :src="images.solar_filter_linear" alt="icon">Status</label>
                                                    <multiselect :show-labels="false"
                                                        style="margin-right: 10px; font-size: 12px;"
                                                        id="FilterTransaction" placeholder="Select Overall Status"
                                                        v-model="status1" :options="options4"></multiselect>
                                                </div>
                                                <div class="col-md-2 user_status">
                                                    <label class="form-label" id="FilterTransaction"
                                                        for="FilterTransaction"><img class="px-1"
                                                            :src="images.solar_filter_linear" alt="icon">Manager
                                                        Status</label>
                                                    <multiselect :show-labels="false"
                                                        style="margin-right: 10px; font-size: 12px;"
                                                        id="FilterTransaction" placeholder=" Manager Status"
                                                        v-model="ManagerStatus" :options="options4"></multiselect>
                                                </div>
                                                <div class="col-md-2 user_status">
                                                    <label class="form-label" id="FilterTransaction"
                                                        for="FilterTransaction"><img class="px-1"
                                                            :src="images.solar_filter_linear" alt="icon">HR
                                                        Status</label>
                                                    <multiselect :show-labels="false"
                                                        style="margin-right: 10px; font-size: 12px;"
                                                        id="FilterTransaction" placeholder="Select HR Status"
                                                        v-model="HRStatus" :options="options4"></multiselect>
                                                </div>
                                            </div>
                                        </div>
                                    </b-collapse>
                                </div>

                                <br>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="sticky-th-center">Emp. Code</th>
                                                <th class="sticky-th-center">Employee Name</th>
                                                <th class="sticky-th-center">Leave<br />Type</th>
                                                <th class="sticky-th-center">Date</th>
                                                <th class="sticky-th-center">Number<br />of days</th>
                                                <th class="sticky-th-center">Manager<br />Status</th>
                                                <th class="sticky-th-center">HR<br />Status</th>
                                                <th class="sticky-th-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="leaves2 in leaves" style="vertical-align: middle;">
                                                <td style="text-align: center;">{{ leaves2.EmployeeCode }}</td>
                                                <td>
                                                    <div @click="fetch_leave_upSts(leaves2.LeaveRQID, '')"
                                                        class="d-flex justify-content-left align-items-center"
                                                        style="cursor:pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#view_leave">
                                                        <div class="avatar-wrapper">
                                                            <div class="avatar  me-1">
                                                                <img v-bind:src="`public/images/profile_images/${leaves2.Photo}`"
                                                                    alt="Avatar" height="32" width="32">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column"><a
                                                                class="user_name text-truncate text-body"><span
                                                                    class="fw-bolder">{{ leaves2.Name
                                                                    }}</span></a><small class="emp_post text-muted">{{
                                                                        leaves2.Department }} -
                                                                {{ leaves2.Designation }}</small></div>
                                                    </div>
                                                </td>
                                                <td style="text-align: center;">{{ leaves2.Leavetype }}</td>
                                                <td style="text-align:center;">
                                                    <span>{{ leaves2.StartDate }}</span>
                                                    <span v-if="leaves2.NoOfDays != '1'"><br />to<br />{{
                                                        leaves2.EndDate
                                                    }}</span>
                                                </td>
                                                <td style="text-align:center;">{{ leaves2.NoOfDays }}</td>
                                                <td style="text-align: center;">
                                                    <span
                                                        v-if="user_access.hr_read == 'true' && leaves2.ManagerApproval == 'Pending' && leaves2.PendingLeaveStatus == 'P'"
                                                        @click="fetch_leave_upSts(leaves2.LeaveRQID, 'Manager')"
                                                        class="badge bg-gradient-warning" data-bs-toggle="modal"
                                                        data-bs-target="#updt_lv_sts"
                                                        style="cursor: pointer;">Pending</span>
                                                    <span v-else-if="leaves2.ManagerApproval == 'Pending'"
                                                        class="badge bg-gradient-warning">Pending</span>

                                                    <span v-else-if="leaves2.ManagerApproval == 'Rejected'"
                                                        class="badge bg-danger">Rejected</span>
                                                    <span v-else-if="leaves2.ManagerApproval == 'Approved'"
                                                        class="badge bg-success">Approved </span>
                                                    <span v-else-if="leaves2.ManagerApproval == 'OL'"
                                                        class="badge bg-primary">Limit exceeded</span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <span v-if="user_access.hr_overall == 'true'">
                                                        <span @click="fetch_leave_upSts(leaves2.LeaveRQID, 'HR')"
                                                            v-if="leaves2.HRApproval == 'Pending' && leaves2.PendingLeaveStatus == 'P'"
                                                            class="badge bg-gradient-warning" data-bs-toggle="modal"
                                                            data-bs-target="#updt_lv_sts"
                                                            style="cursor: pointer;">Pending</span>
                                                        <span
                                                            v-else-if="leaves2.HRApproval == 'Pending' && leaves2.PendingLeaveStatus != 'P'"
                                                            class="badge bg-gradient-warning">Pending</span>
                                                        <span v-else-if="leaves2.HRApproval == 'Rejected'"
                                                            class="badge bg-danger">Rejected</span>
                                                        <span v-else-if="leaves2.HRApproval == 'Approved'"
                                                            class="badge bg-success">Approved </span>
                                                        <span v-else-if="leaves2.HRApproval == 'OL'"
                                                            class="badge bg-primary">Limit exceeded</span>
                                                    </span>
                                                    <span v-else>
                                                        <span
                                                            v-if="leaves2.HRApproval == 'Pending' && leaves2.PendingLeaveStatus == 'P'"
                                                            class="badge bg-gradient-warning"
                                                            style="cursor: pointer;">Pending</span>
                                                        <span
                                                            v-else-if="leaves2.HRApproval == 'Pending' && leaves2.PendingLeaveStatus != 'P'"
                                                            class="badge bg-gradient-warning">Pending</span>
                                                        <span v-else-if="leaves2.HRApproval == 'Rejected'"
                                                            class="badge bg-danger">Rejected</span>
                                                        <span v-else-if="leaves2.HRApproval == 'Approved'"
                                                            class="badge bg-success">Approved </span>
                                                        <span v-else-if="leaves2.HRApproval == 'OL'"
                                                            class="badge bg-primary"> Limit exceeded</span>
                                                    </span>
                                                </td>
                                                <td style="text-align: center;">
                                                    <span v-if="leaves2.PendingLeaveStatus == 'P'"
                                                        class="badge bg-gradient-warning">Pending</span>
                                                    <span v-else-if="leaves2.PendingLeaveStatus == 'R'"
                                                        class="badge bg-danger">Rejected</span>
                                                    <span v-else-if="leaves2.PendingLeaveStatus == 'A'"
                                                        class="badge bg-success">Approved </span>
                                                    <span v-else-if="leaves2.PendingLeaveStatus == 'OL'"
                                                        class="badge bg-primary"> Limit exceeded</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center; padding-top:20px">
                                    <pagination v-if="pageN == '1'" :limit="limit" :data="leaves"
                                        @pagination-change-page="getbyfilter"></pagination>
                                    <pagination v-if="pageN == '2'" :limit="limit" :data="leaves"
                                        @pagination-change-page="getbyfilter1"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- View leave Modal -->
        <div class="modal fade" id="view_leave" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <thead style="float: left; width: 100%;">
                                        <h2 style="text-align:center;">{{ lv_type }} leave application</h2>
                                        <tr>
                                            <th>Employee code:</th>
                                            <td> {{ ind_lave_dtl.EmployeeCode }}</td>
                                            <th>Employee Name:</th>
                                            <td> {{ ind_lave_dtl.Name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department:</th>
                                            <td> {{ ind_lave_dtl.Department }}</td>
                                            <th>Designation:</th>
                                            <td> {{ ind_lave_dtl.Designation }}</td>
                                        </tr>
                                        <tr>
                                            <th>Number of days:</th>
                                            <td> {{ ind_lave_dtl.NoOfDays }}</td>
                                            <th>Leave type:</th>
                                            <td> {{ ind_lave_dtl.Leavetype }}</td>
                                        </tr>
                                        <tr>
                                            <th v-if="ind_lave_dtl.NoOfDays != '1'">Start date:</th>
                                            <th v-else>Date:</th>
                                            <td> {{ ind_lave_dtl.StartDate }}</td>
                                            <th v-if="ind_lave_dtl.NoOfDays != '1'">To date:</th>
                                            <td v-if="ind_lave_dtl.NoOfDays != '1'"> {{ ind_lave_dtl.EndDate }}</td>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong></strong></label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <div class="text-center" style="text-align:center; margin-top:30px;">
                                                <button type="submit" class="btn btn-outline-primary waves-effect"
                                                    data-bs-dismiss="modal" aria-label="Close">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ View leave Modal -->
        <!-- Update leave ststus Modal -->
        <div class="modal fade" id="updt_lv_sts" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <thead style="float: left; width: 100%;">
                                        <h2 style="text-align:center;">{{ lv_type }} leave application</h2>
                                        <tr>
                                            <th>Employee Name:</th>
                                            <td>{{ ind_lave_dtl.Name }}</td>
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Department:</th>
                                            <td> {{ ind_lave_dtl.Department }}</td>
                                            <th>Designation:</th>
                                            <td> {{ ind_lave_dtl.Designation }}</td>
                                        </tr>
                                        <tr>
                                            <th>Number of leaves:</th>
                                            <td> {{ ind_lave_dtl.NoOfDays }}</td>
                                            <th>Leave type:</th>
                                            <td> {{ ind_lave_dtl.Leavetype }}</td>
                                        </tr>
                                        <tr>
                                            <th v-if="ind_lave_dtl.NoOfDays != '1'">Start date:</th>
                                            <th v-else>Date:</th>
                                            <td> {{ ind_lave_dtl.StartDate }}</td>
                                            <th v-if="ind_lave_dtl.NoOfDays != '1'">To date:</th>
                                            <td v-if="ind_lave_dtl.NoOfDays != '1'"> {{ ind_lave_dtl.EndDate }}</td>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong></strong></label>
                                    </div>
                                    <div class="col-md-12">
                                        <strong>Change status</strong>
                                        <select class="form-select mb-md-0 mb-2" v-model="lv_status">
                                            <option value="" selected>Select</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="this.lv_status == ''">{{
                                            lv_status_error }}</span>
                                    </div>
                                    <div class="col-md-12">

                                        <div class="mb-2">

                                            <div class="text-center" style="text-align:center; margin-top:30px;">
                                                <button :disabled="disabled" @click="delay()" type="button"
                                                    class="btn btn-primary waves-effect waves-float waves-light"
                                                    data-bs-dismiss="modal" aria-label="Close">Update
                                                </button>
                                                <button type="submit" class="btn btn-outline-primary waves-effect"
                                                    data-bs-dismiss="modal" aria-label="Close">Cancle
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--/ Update leave status Modal -->

        <!-- Model apply leave-->
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Apply For Leave</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <table class="table" v-if="this.isLvEmpty != 'Empty'">
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
                                            <td>{{ leavesblnc1.TotalLeave - leavesblnc1.RemainingLeave }}</td>
                                            <td>{{ leavesblnc1.RemainingLeave }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Select Employee: <span style="color:red">*</span></label>
                                <multiselect :show-labels="false" @input="fetch_emp_leave()"
                                    style="margin-right: 10px; font-size: 12px;" placeholder="Select Employee"
                                    value="id" label="label" v-model="emp_emp_id" :options="options5"></multiselect>
                                <span style="color: #DB4437; font-size: 11px;" v-if="emp_emp_id.id == ''">{{
                                    emp_emp_id_error }}</span>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Leave Type: <span
                                        style="color:red">*</span></label>
                                <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                    id="FilterTransaction" placeholder="Select Type" v-model="emp_leave"
                                    :options="options">
                                </multiselect>
                                <span style="color: #DB4437; font-size: 11px;" v-if="emp_leave == ''">{{ emp_leave_error
                                }}</span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Date From: <span style="color:red">*</span></label>
                                <input v-model="emp_date_from" type="date" class="form-control" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="emp_date_from == ''">{{
                                    emp_date_from_error }}</span>
                            </div>
                            <div class="col-12 col-sm-12 mb-1">
                                <label class="form-label">Select Days</label>
                                <div class="row demo-inline-spacing" style="padding-left: 5%;">
                                    <div class="col-md-5 form-check form-check-inline" style="margin-top:0px">
                                        <input class="form-check-input" type="radio" v-model="days"
                                            name="inlineRadioOptions" id="inlineRadio1" value="One Day" checked="">
                                        <label class="form-check-label" for="inlineRadio1">One Day</label>
                                    </div>
                                    <div class=" col-md-5 form-check form-check-inline" style="margin-top:0px">
                                        <input class="form-check-input" type="radio" v-model="days"
                                            name="inlineRadioOptions" id="inlineRadio2" value="Multiple Days">
                                        <label class="form-check-label" for="inlineRadio2">Multiple Days</label>
                                    </div>
                                </div>
                            </div>
                            <div v-if="this.days == 'Multiple Days'" class="col-md-12">
                                <label class="form-label">Date To</label>
                                <input v-model="emp_date_to" type="date" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Reason</label>
                                <input v-model="emp_reason" type="text" class="form-control" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.emp_reason == ''">{{
                                    emp_reason_error }}</span>
                            </div>
                            <div class="col-12 text-center">
                                <button :disabled="disabled" @click="delay1()" type="submit"
                                    class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Apply Leave
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Model apply leave-->
    </div>

</template>
<script>
import Multiselect from 'vue-multiselect'
import MaskedInput from 'vue-masked-input'

export default {
    data() {
        return {
        images: {
                solar_filter_linear: "/images/solar_filter_linear.png",
                search_icon: "/images/search_icon.png",
            },
            limit: 10,
            leaveTypes: {},
            user_access: {},

            isLvEmpty: 'Empty',
            options: [],
            options1: [],
            options2: [],
            options3: [],
            options4: ['All', 'Approved', 'Pending', 'Rejected'],
            options5: [],
            status1: 'All',
            ManagerStatus: 'All',
            HRStatus: 'All',
            pageN: '',

            keyword1: '',

            department: 'All',
            location: 'All',
            designation: 'All',
            designations: {},
            locations: {},
            departments: {},
            leaves: {},
            leave: 'All',

            days: 'One Day',
            emp_leave: '',
            emp_date_from: '',
            emp_date_to: '',
            emp_reason: '',
            emp_emp_id: '',
            find_emp: {},

            lv_status: '',
            lv_status_error: '',

            lv_app_id: '',
            lv_app_date: '',
            lv_emp_id: '',
            lv_emp_name: '',
            ind_lave_dtl: [],//getting leave detail
            lv_emp_Fname: '',
            lv_dept: '',
            lv_designation: '',
            lv_type: '',
            lv_number: '',
            lv_from: '',
            lv_to: '',
            us_lv_type: '',
            who: 'HR',

            emp_date_from_error: '',
            emp_reason_error: '',
            emp_leave_error: '',
            disabled: false,
            timeout: null,
        }
    },
    components: {
        MaskedInput,
        Multiselect
    },
    watch: {
        keyword1(after, before) {
            this.getbyfilter1();
        },

    },
    methods: {
        delay1() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.submit_leave()
        },


        // apply leave method
        submit_emp_leave() {
            if (this.lv_emp_id.id == '' || this.lv_type == '' || this.lv_nmbr == '') {
                if (this.lv_emp_id.id == '') {
                    this.e_lv_emp_id = "Select employee";
                } else {
                    this.e_lv_emp_id = "";
                }
                if (this.lv_type == '') {
                    this.e_lv_type = "Select leave type";
                } else {
                    this.e_lv_type = "";
                }
                if (this.lv_nmbr == '') {
                    this.e_lv_nmbr = "Enter number of leave";
                } else {
                    this.e_lv_nmbr = "";
                }
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                axios.post('submit_emp_leaves', {
                    lv_emp_id: this.lv_emp_id.id,
                    lv_type: this.lv_type,
                    lv_nmbr: this.lv_nmbr,
                    // lv_id=this.
                })
                    .then(data => {
                        this.leavesblnc = data.data.data;
                        this.lv_emp_id = '';
                        this.lv_type = '';
                        this.lv_nmbr = '';
                        if (this.leavesblnc == '') {
                            this.isLvEmpty = "Empty";
                        } else {
                            this.isLvEmpty = "Not empty";
                        }
                    })
            }
        },
        fetch_emp_leave() {
            axios.get('selected_emp_leaves_blnc/' + this.emp_emp_id.id)
                .then(data => {
                    this.leavesblnc = data.data.data;
                    console.log(this.leavesblnc, "leave balance");

                    if (this.leavesblnc == '') {
                        this.isLvEmpty = "Empty";
                    } else {
                        this.isLvEmpty = "Not empty";
                    }
                })
                .catch(error => {
                });
        },

        // new leave submission
        submit_leave() {
            if (!this.emp_date_to == "") {
                if (this.emp_date_to < this.emp_date_from) {
                    this.$toastr.e("Date-To cannot be smaller then Date From!")
                }
            }
            if (this.emp_emp_id.id == '' || this.emp_date_from == '' || this.emp_reason == '') {
                if (this.emp_emp_id.id == '') {
                    this.emp_emp_id_error = "Select employee";
                } else {
                    this.emp_emp_id_error = "";
                }
                if (this.emp_leave == '') {
                    this.emp_leave_error = "Select leave type";
                } else {
                    this.emp_leave_error = "";
                }
                if (this.emp_date_from == '') {
                    this.emp_date_from_error = "Select date";
                } else {
                    this.emp_date_from_error = "";
                }
                if (this.emp_reason == '') {
                    this.emp_reason_error = "Type reson";
                } else {
                    this.emp_reason_error = "";
                }
                this.$toastr.e("Leave not applied", "Important Fields Missing!")
            } else {
                axios.post('submit_leave', {
                    emp_id: this.emp_emp_id.id,
                    days: this.days,
                    emp_date_from: this.emp_date_from,
                    emp_date_to: this.emp_date_to,
                    emp_reason: this.emp_reason,
                    emp_leave: this.emp_leave,
                })
                    .then(response => {
                        console.log(response.data, "submit laeve")
                        if (response.data.message == 'Leave applied') {
                            this.$toastr.s("Leave Applied Successfully!", "Congratulations!");
                            // console.log(this.emp_emp_id.id,this.days,this.emp_date_from,this.emp_leave)
                            console.log(response.data.data)
                            this.leaves.data.unshift(response.data.data);
                            console.log(this.leaves, "unshift data ");
                            // this.getbyfilter();
                        } else {
                            this.$toastr.e(data.data, "Caution!");
                        }
                    })
            }
        },
        async fetchRoles() {
            try {
                const data = await this.$apihelpers.fetchUserHrRoles()

                this.user_access = data;
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        async fetchDepartment() {
            try {

                this.departments = await this.$helpers.checkLocal('department_detail');
                // this.options3 = [];

                var $this = this;
                for (var i = 0; i < $this.departments.length; i++) {
                    this.options3.push($this.departments[i].Department);
                    // console.log(this.options3, "option 3 -----------");

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
                this.options1 = [];

                var $this = this;
                for (var i = 0; i < $this.designations.length; i++) {
                    this.options1.push($this.designations[i].designation_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        async fetchLocations() {
            try {
                this.locations = await this.$helpers.checkLocal('overall_location');
                this.options2 = [];
                var $this = this;
                for (var i = 0; i < $this.locations.length; i++) {
                    this.options2.push($this.locations[i].location_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        // use for search
        getbyfilter1(page = 1) {
            axios.get('./search_Employee_leave/' + this.keyword1 + '/?page=' + page)
                .then(data => {
                    this.leaves = data.data.data
                    console.log(this.leaves, "get by filter 1");

                })
                .catch(error => {
                    console.log("catch eroor");

                });
            this.pageN = '2';
            this.status1 = 'All';
            this.ManagerStatus = 'All';
            this.HRStatus = 'All';
            this.department = 'All';
            this.location = 'All';
            this.designation = 'All';
            this.leave = 'All';
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.update_leave_status()
        },
        // for fillter
        getbyfilter(page = 1) {
            axios.get('./filter_leaves_requisitions/' + this.leave + '/' + this.department + '/' + this.location + '/' + this.designation + '/' + this.status1 + '/' + this.ManagerStatus + '/' + this.HRStatus + '/?page=' + page)
                .then(data => {
                    this.leaves = data.data.data
                    console.log(this.leaves, "get by filter");
                })
                .catch(error => {
                    this.$toastr.e('Error Occur while filter leaves requistion of employee');
                });
            this.pageN = '1';
            this.keyword1 = '';
        },
        fetch_leave_upSts(id1, who) {
            this.lv_app_id = id1;
            console.log(this.lv_app_id, "lv app id");

            this.who = who;
            console.log(this.who, "who");
            axios.get('fetch_leave_upSts/' + this.lv_app_id)
                .then(responce => {
                    this.ind_lave_dtl = responce.data.data[0];
                    this.lv_emp_id = responce.data.data[0].EmployeeID;
                    this.lv_emp_name = responce.data.data[0].Name;
                    this.lv_type = responce.data.data[0].Leavetype;
                    this.lv_number = responce.data.data[0].NoOfDays;
                    this.lv_from = responce.data.data[0].StartDate;
                    this.lv_to = responce.data.data[0].EndDate
                })
                .catch(error => {
                    this.$toastr.e('Error Occur while fetch leaves status of employee');
                });
        },
        update_leave_status() {
            if (this.lv_status == '') {
                this.lv_status_error = "Select status";
                this.$toastr.e("Please select status to update!", "Caution!");
            } else {
                this.lv_status_error = "";
                axios.post('./update_leave_sts', {
                    lv_app_id: this.lv_app_id,
                    lv_status: this.lv_status,
                    who: this.who,
                })
                    .then(data => {
                        if (data.data.data == "Status updated") {
                            this.$toastr.s("Leave status updated successfully!", "Congratulations");
                            const updatedIndex = this.leaves.data.findIndex(record => record.LeaveRQID === this.lv_app_id);
                            console.log(updatedIndex)
                            if (updatedIndex !== -1) {
                                // If the record exists, update the specific values
                                if (this.who == "Manager") {
                                    this.leaves.data[updatedIndex].ManagerApproval = this.lv_status;
                                    this.leaves.data[updatedIndex].PendingLeaveStatus = this.lv_status.charAt(0);
                                }

                                if (this.who == "HR") {
                                    this.leaves.data[updatedIndex].HRApproval = this.lv_status;
                                    this.leaves.data[updatedIndex].PendingLeaveStatus = this.lv_status.charAt(0);
                                }


                            }
                            this.lv_status = '';
                            this.ind_lave_dtl = [];
                            // if (this.pageN == 2) {
                            //     // this.getbyfilter1();
                            // } else {
                            //     // this.getbyfilter();
                            // }
                        } else {
                            this.$toastr.e(data.data.data, "Error");
                        }
                    })
                    .catch(error => {
                        this.$toastr.e('Error Occur while update leaves  status of employee');
                    });
            }
        },
    },
    mounted() {
        // this.getbyfilter1();
        // this.getbyfilter();
        this.fetchDepartment();
        this.fetchRoles();
        this.fetchDesignation();
        this.fetchLocations();
        //give leave type
        axios.get('overall_leaves')
            .then(response => {

                this.leaves = response.data.data;
                // console.log(this.leave, "overall leaves");
                this.options = [];

                var $this = this;
                for (var i = 0; i < $this.leaves.length; i++) {
                    this.options.push($this.leaves[i].LeaveType);
                    // console.log(this.options, "leveassssss");

                }
            })
            .catch(error => {
                this.$toastr.e('Error Occur while getting overall leaves of employee!');
            });

        axios.get('registered_empcode')
            .then(data => {
                this.find_emp = data.data;
                // console.log(this.find_emp, "find employee");

                this.options5 = [];
                this.options5 = this.find_emp.map((obj) => ({
                    id: obj.EmployeeID,
                    label: `${obj.EmployeeCode}` + ' _ ' + `${obj.Name}`,
                }));
            })
            .catch(error => {
            });
    }
}

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
</style>
