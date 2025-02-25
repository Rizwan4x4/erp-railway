<template>
    <div>
        <loader v-if="!myData" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="17" speed="2" bg="#343a40"
            objectbg="#999793" opacity="80" disableScrolling="false" name="loading"></loader>
        <div v-else>
            <div v-if="this.fetchempcode != 'a'" class="app-content content ">
                <div class="content-overlay"></div>
                <div class="header-navbar-shadow"></div>
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">
                                    Employee's Dashboard
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="content-body">
                        <section class="app-user-list">
                            <div class="row match-height">
                                <!-- Statistics Card -->
                                <div class="col-xl-10 col-md-12 col-12">
                                    <div data-v-step="4" class="card card-statistics border-0 top-radius bottom-radius">
                                        <div class="card-header top-radius">
                                            <h4 class=" fw-bolder">Custom Date Range Attendance Statistics</h4>
                                            <date-range-picker ref="picker" minDate="'2022-07-03'" :maxDate="att_date"
                                                v-model="dateRange" :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy' }"
                                                @update="get_attendance_count()">
                                            </date-range-picker>
                                        </div>
                                        <div class="card-body statistics-body"
                                            style="padding-top: 5px !important; padding-bottom: 10px !important;">
                                            <div class="row pb-4 ">
                                                <div class="col-xl-2 col-sm-6 col-12 p-2">
                                                    <div class="rounded-4 bg-custom shadow-sm">
                                                        <div class="d-flex flex-row justify-content-center  px-1 py-3">
                                                            <div class=" me-2">
                                                                <div class="avatar-content">
                                                                    <img src="../../../../public/images/date_range.png"
                                                                        alt="Total-days">
                                                                </div>
                                                            </div>
                                                            <div class="my-auto ">

                                                                <p class="card-text fw-bold font-small-3 mb-0">Total
                                                                    Days
                                                                </p>
                                                                <h4 class="fw-bolder mb-0">{{ ct_att.totalDays }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-6 col-12 p-2">
                                                    <div class=" rounded-4 bg-custom shadow-sm">
                                                        <div class="d-flex flex-row justify-content-center  px-1 py-3">
                                                            <div class=" me-2">
                                                                <div class="avatar-content">
                                                                    <img src="../../../../public/images/present.png"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <div class="my-auto">
                                                                <p class="card-text fw-bold font-small-3 mb-0">Present
                                                                </p>
                                                                <h4 class="fw-bolder mb-0">{{ ct_att.present }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-6 col-12 p-2">
                                                    <div class=" rounded-4 bg-custom shadow-sm">
                                                        <div class="d-flex flex-row justify-content-center  px-1 py-3">
                                                            <div class=" me-2">
                                                                <div class="avatar-content">
                                                                    <img src="../../../../public/images/do_not_touch.png"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <div class="my-auto">
                                                                <p class="card-text fw-bold font-small-3 mb-0">Holiday
                                                                </p>
                                                                <h4 class="fw-bolder mb-0">{{ ct_att.holiday }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-6 col-12 p-2">
                                                    <div class=" rounded-4 bg-custom shadow-sm">
                                                        <div class="d-flex flex-row justify-content-center  px-1 py-3">
                                                            <div class=" me-2">
                                                                <div class="avatar-content">
                                                                    <img src="../../../../public/images/time.png"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <div class="my-auto">
                                                                <p class="card-text fw-bold font-small-3 mb-0">Late</p>
                                                                <h4 class="fw-bolder mb-0">{{ ct_att.late }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-6 col-12 p-2">
                                                    <div class=" rounded-4 bg-custom shadow-sm">
                                                        <div class="d-flex flex-row justify-content-center  px-1 py-3">
                                                            <div class=" me-2">
                                                                <div class="avatar-content">
                                                                    <img src="../../../../public/images/leave.png"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <div class="my-auto">
                                                                <p class="card-text fw-bold font-small-3 mb-0">Leave</p>
                                                                <h4 class="fw-bolder mb-0">{{ ct_att.leave }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-6 col-12 p-2">
                                                    <div class=" rounded-4 bg-custom shadow-sm">
                                                        <div class="d-flex flex-row justify-content-center  px-1 py-3">
                                                            <div class=" me-2">
                                                                <div class="avatar-content">
                                                                    <img src="../../../../public/images/absent.png"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <div class="my-auto">
                                                                <p class="card-text fw-bold font-small-3 mb-0">Absent
                                                                </p>
                                                                <h4 class="fw-bolder mb-0">{{ ct_att.absent }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-12 col-12">
                                    <div class="card card-statistics text-center border-0 top-radius bottom-radius">
                                        <div
                                            class="card-body d-flex flex-column align-items-center justify-content-center">
                                            <router-link to="/hr/emp_detail"
                                                class="text-decoration-none d-flex flex-column align-items-center">
                                                <!-- Circular Image -->
                                                <img src="../../../../public/images/logo/sagroup.png" alt="Profile-img"
                                                    class="rounded-circle img-fluid"
                                                    style="width: 60px; height: 60px; object-fit: cover;">

                                                <!-- Clickable Text -->
                                                <span class="mt-2 fw-bold text-primary">View Profile</span>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!--/ Statistics Card -->


                            <div class="row match-height">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div data-v-step="4" class="card card-statistics border-0 top-radius bottom-radius">
                                        <div class="card-header top-radius">
                                            <h4 class=" fw-bolder">Leave data</h4>
                                            <button
                                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center px-4 py-2 rounded-3 shadow position-relative"
                                                style="width: 130px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
                                                    <path fill-rule="evenodd"
                                                        d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z" />
                                                </svg>
                                                <span class="flex-grow-1 text-center">Apply</span>
                                            </button>


                                        </div>
                                        <div class="card-body statistics-body"
                                            style="padding-top: 5px !important; padding-bottom: 10px !important;">
                                            <div class="row pb-4 ">
                                                <div class="col-xl-3 col-sm-6 col-12 ">
                                                    <div class="card card-statistics rounded-4 shadow-sm">
                                                        <div class="d-flex flex-column px-1 py-3">
                                                            <!-- First Row: Single Full-Width Column -->
                                                            <div class="row">
                                                                <div class="col-12 clearfix px-3 rounded">
                                                                    <h6
                                                                        class="my-1 fw-bold float-start text-primary mb-0">
                                                                        Annual Leaves</h6>
                                                                    <span class="float-end "><a
                                                                            @click="leaves_details('Annual')"
                                                                            data-v-step="9" data-bs-toggle="modal"
                                                                            data-bs-target="#emp_leaves"
                                                                            class="role-edit-modal"
                                                                            style="text-decoration:none;">
                                                                            <small class="fw-bolder">View
                                                                                Detail</small></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- Second Row: Two Columns (Responsive) -->
                                                            <div class="row mt-1 pl-2">
                                                                <div class="col-12 col-md-6  p-0 text-center rounded">
                                                                    <apexchart :options="chartOptions1"
                                                                        :series="series1[0]" type="radialBar"
                                                                        height="450">
                                                                    </apexchart>
                                                                </div>
                                                                <div
                                                                    class=" col-md-6 col-12 pr-3 d-flex flex-column align-items-center  justify-content-center text-end rounded">
                                                                    <span class="text-truncate text-primary">Used - {{
                                                                        leaves_dtl.ttl_annual - leaves_dtl.rem_annual }}
                                                                    </span>
                                                                    <small>Available - {{
                                                                        leaves_dtl.ttl_annual }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-sm-6 col-12 ">
                                                    <div class="card card-statistics rounded-4 shadow-sm">
                                                        <div class="d-flex flex-column px-1 py-3">
                                                            <!-- First Row: Single Full-Width Column -->
                                                            <div class="row">
                                                                <div class="col-12 clearfix px-3 rounded">
                                                                    <h6
                                                                        class="my-1 fw-bold float-start text-danger mb-0">
                                                                        Sick Leaves</h6>
                                                                    <span class="float-end "><a
                                                                            @click="leaves_details('Sick')"
                                                                            data-v-step="10" data-bs-toggle="modal"
                                                                            data-bs-target="#emp_leaves"
                                                                            class="role-edit-modal"
                                                                            style="text-decoration:none;">
                                                                            <small class="fw-bolder">View
                                                                                Detail</small></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- Second Row: Two Columns (Responsive) -->
                                                            <div class="row mt-1 pl-2">
                                                                <div class="col-12 col-md-6  p-0 text-center rounded">
                                                                    <apexchart :options="chartOptions2"
                                                                        :series="series1[1]" type="radialBar"
                                                                        height="450">
                                                                    </apexchart>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-md-6 pr-3 d-flex flex-column align-items-center justify-content-center text-end rounded">
                                                                    <span class="text-truncate text-danger">Used - {{
                                                                        leaves_dtl.ttl_sick - leaves_dtl.rem_sick
                                                                        }}
                                                                    </span>
                                                                    <small>Available - {{
                                                                        leaves_dtl.ttl_sick }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-sm-6 col-12 ">
                                                    <div class="card card-statistics rounded-4 shadow-sm">
                                                        <div class="d-flex flex-column px-1 py-3">
                                                            <!-- First Row: Single Full-Width Column -->
                                                            <div class="row">
                                                                <div class="col-12 clearfix px-3 rounded">
                                                                    <h6
                                                                        class="my-1 fw-bold float-start text-warning mb-0">
                                                                        Casual Leaves</h6>
                                                                    <span class="float-end "><a
                                                                            @click="leaves_details('Casual')"
                                                                            data-v-step="11" data-bs-toggle="modal"
                                                                            data-bs-target="#emp_leaves"
                                                                            class="role-edit-modal"
                                                                            style="text-decoration:none;">
                                                                            <small class="fw-bolder">View
                                                                                Detail</small></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- Second Row: Two Columns (Responsive) -->
                                                            <div class="row mt-1 pl-2">
                                                                <div class="col-12 col-md-6  p-0 text-center rounded">
                                                                    <apexchart :options="chartOptions3"
                                                                        :series="series1[2]" type="radialBar"
                                                                        height="450">
                                                                    </apexchart>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-md-6 pr-3 d-flex flex-column align-items-center justify-content-center text-end rounded">
                                                                    <span class="text-truncate text-warning">Used - {{
                                                                        leaves_dtl.ttl_casual - leaves_dtl.rem_casual
                                                                        }}
                                                                    </span>
                                                                    <small>Available - {{
                                                                        leaves_dtl.ttl_casual }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-sm-6 col-12 ">
                                                    <div class="card card-statistics rounded-4 shadow-sm">
                                                        <div class="d-flex flex-column px-1 py-3">
                                                            <!-- First Row: Single Full-Width Column -->
                                                            <div class="row">
                                                                <div class="col-12 clearfix px-3 rounded">
                                                                    <h6
                                                                        class="my-1 fw-bold float-start text-success mb-0">
                                                                        Other Leaves</h6>
                                                                    <span class="float-end "><a
                                                                            @click="leaves_details('Other')"
                                                                            data-v-step="11" data-bs-toggle="modal"
                                                                            data-bs-target="#emp_leaves"
                                                                            class="role-edit-modal"
                                                                            style="text-decoration:none;color:#0d6efd">
                                                                            <small class="fw-bolder">View
                                                                                Detail</small></a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- Second Row: Two Columns (Responsive) -->
                                                            <div class="row mt-1 pl-2">
                                                                <div class="col-12 col-md-6  p-0 text-center rounded">
                                                                    <apexchart :options="chartOptions4"
                                                                        :series="series1[3]" type="radialBar"
                                                                        height="450">
                                                                    </apexchart>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-md-6 pr-3 d-flex flex-column align-items-center justify-content-center text-end rounded">
                                                                    <span class="text-truncate text-success">Used - {{
                                                                        leaves_dtl.other_used }}
                                                                    </span>
                                                                    <small>Available - {{
                                                                        leaves_dtl.ttl_other }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--                                <div class="col-lg-3 col-md-3 col-12">-->
                                <!--                                    <div class="card" data-v-step="7">-->
                                <!--                                        <div class="card-body pb-50" style="position: relative;">-->
                                <!--                                            <h6>Apply</h6>-->
                                <!--                                            <h3 class="fw-bolder mb-1" style="padding-bottom: 15px;">Leave</h3>-->
                                <!--                                            <a data-bs-toggle="modal" style="width:100%;" data-bs-target="#addNewCard"-->
                                <!--                                               class="btn btn-primary waves-effect waves-float waves-light">Apply-->
                                <!--                                                Now</a>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->


                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="card card-tiny-line-stats" data-v-step="8">
                                        <div class="card-body pb-50" style="position: relative;">
                                            <h6>My</h6>
                                            <h3 class="fw-bolder mb-1" style="padding-bottom: 15px;">
                                                Profile</h3>
                                            <router-link style="width:100%;" to="/hr/emp_detail"
                                                class="btn btn-primary waves-effect waves-float waves-light">
                                                View
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="card" data-v-step="7">
                                        <div class="card-body pb-50" style="position: relative;">
                                            <h6>
                                                Mark mannual
                                            </h6>
                                            <h3 class="fw-bolder mb-1" style="padding-bottom: 15px;">
                                                Attendance</h3>
                                            <a data-bs-toggle="modal" data-bs-target="#markAttendance"
                                                style="width:100%;"
                                                class="btn btn-primary waves-effect waves-float waves-light">Mark
                                                Now</a>
                                            <!-- <a v-else @click="not_Att_access()" style="width:100%;"
                                               class="btn btn-danger waves-effect waves-float waves-light">Mark
                                                Now</a> -->
                                        </div>
                                    </div>
                                </div>
                                <!--                                <div class="col-lg-3 col-md-3 col-12">-->
                                <!--                                    <div class="card card-tiny-line-stats" data-v-step="7">-->
                                <!--                                        <div class="card-body pb-50" style="position: relative;">-->
                                <!--                                            <h6>Apply</h6>-->
                                <!--                                            <h3 class="fw-bolder mb-1" style="padding-bottom: 15px;">Loan</h3>-->
                                <!--                                            <a data-bs-toggle="modal" style="width:100%;" data-bs-target="#addNewLoan"-->
                                <!--                                               class="btn btn-primary waves-effect waves-float waves-light">Apply-->
                                <!--                                                Now</a>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="card" data-v-step="7">
                                        <div class="card-body pb-50" style="position: relative;">
                                            <h6>Time</h6>
                                            <h3 class="fw-bolder mb-1" style="padding-bottom: 15px;">Adjustment</h3>
                                            <a data-bs-toggle="modal" style="width:100%;" data-bs-target="#timeAdj"
                                                class="btn btn-primary waves-effect waves-float waves-light">Apply
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row match-height">
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="card shadow-none border cursor-pointer">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <img src="public/app-assets/images/icons/annual.png" alt="google drive"
                                                    height="38" />
                                                <a @click="leaves_details('Annual')" data-v-step="9"
                                                    data-bs-toggle="modal" data-bs-target="#emp_leaves"
                                                    class="role-edit-modal" style="text-decoration:none;color:#0d6efd">
                                                    <small class="fw-bolder">View Detail</small></a>
                                            </div>
                                            <div class="my-1">
                                                <h5>Annual Leaves</h5>
                                            </div>
                                            <div class="d-flex justify-content-between mb-50">
                                                <span class="text-truncate">{{
                                                    leaves_dtl.ttl_annual - leaves_dtl.rem_annual
                                                }} Used</span>
                                                <small class="text-muted">Out of {{ leaves_dtl.ttl_annual }}</small>
                                            </div>
                                            <b-progress :max="`${leaves_dtl.ttl_annual}`">
                                                <b-progress-bar
                                                    :value="`${(leaves_dtl.ttl_annual - leaves_dtl.rem_annual)}`"
                                                    :label="`${((1 - (leaves_dtl.rem_annual / leaves_dtl.ttl_annual)) * 100).toFixed(0)}%`"></b-progress-bar>
                                            </b-progress>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="card shadow-none border cursor-pointer">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <img src="public/app-assets/images/icons/fever.png" alt="google drive"
                                                    height="38" />
                                                <a @click="leaves_details('Sick')" data-v-step="10"
                                                    data-bs-toggle="modal" data-bs-target="#emp_leaves"
                                                    class="role-edit-modal" style="text-decoration:none;color:#0d6efd">
                                                    <small class="fw-bolder">View Detail</small></a>
                                            </div>
                                            <div class="my-1">
                                                <h5>Sick Leaves</h5>
                                            </div>
                                            <div class="d-flex justify-content-between mb-50">
                                                <span class="text-truncate">{{
                                                    leaves_dtl.ttl_sick - leaves_dtl.rem_sick
                                                }} Used</span>
                                                <small class="text-muted">Out of {{ leaves_dtl.ttl_sick }}</small>
                                            </div>
                                            <b-progress :max="`${leaves_dtl.ttl_sick}`">
                                                <b-progress-bar
                                                    :value="`${(leaves_dtl.ttl_sick - leaves_dtl.rem_sick)}`"
                                                    :label="`${((1 - (leaves_dtl.rem_sick / leaves_dtl.ttl_sick)) * 100).toFixed(0)}%`"></b-progress-bar>
                                            </b-progress>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="card shadow-none border cursor-pointer">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <img src="public/app-assets/images/icons/casual.png" alt="google drive"
                                                    height="38" />
                                                <a @click="leaves_details('Casual')" data-v-step="11"
                                                    data-bs-toggle="modal" data-bs-target="#emp_leaves"
                                                    class="role-edit-modal" style="text-decoration:none;color:#0d6efd">
                                                    <small class="fw-bolder">View Detail</small></a>
                                            </div>
                                            <div class="my-1">
                                                <h5>Casual Leaves</h5>
                                            </div>
                                            <div class="d-flex justify-content-between mb-50">
                                                <span class="text-truncate">{{
                                                    leaves_dtl.ttl_casual - leaves_dtl.rem_casual
                                                }} Used</span>
                                                <small class="text-muted">Out of {{ leaves_dtl.ttl_casual }}</small>
                                            </div>
                                            <b-progress :max="`${leaves_dtl.ttl_casual}`">
                                                <b-progress-bar
                                                    :value="`${(leaves_dtl.ttl_casual - leaves_dtl.rem_casual)}`"
                                                    :label="`${((1 - (leaves_dtl.rem_casual / leaves_dtl.ttl_casual)) * 100).toFixed(0)}%`"></b-progress-bar>
                                            </b-progress>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="card shadow-none border cursor-pointer">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <img src="public/app-assets/images/icons/other.png" alt="google drive"
                                                    height="38" />
                                                <a @click="leaves_details('Other')" data-v-step="11"
                                                    data-bs-toggle="modal" data-bs-target="#emp_leaves"
                                                    class="role-edit-modal" style="text-decoration:none;color:#0d6efd">
                                                    <small class="fw-bolder">View Detail</small></a>
                                            </div>
                                            <div class="my-1">
                                                <h5>Other Leaves</h5>
                                            </div>
                                            <div class="d-flex justify-content-between mb-50">
                                                <span class="text-truncate">{{ leaves_dtl.other_used }} Used</span>
                                                <small class="text-muted">Out of {{ leaves_dtl.ttl_other }}</small>
                                            </div>
                                            <b-progress :max="`${leaves_dtl.ttl_other}`">
                                                <b-progress-bar :value="`${(leaves_dtl.other_used)}`"
                                                    :label="`${((1 - ((leaves_dtl.ttl_other - leaves_dtl.other_used) / leaves_dtl.ttl_other)) * 100).toFixed(0)}%`"></b-progress-bar>
                                            </b-progress>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Company Table Card -->
                            <!-- <div class="col-lg-12 col-12">
                                <div class="row breadcrumbs-top">
                                    <div class="col-md-3" style="border-right: 1px solid #D6DCE1;">
                                        <p >Avg Check In Time: {{avg_times.AvgCheckINTime}}comented</p>
                                        <p>Avg Check In Time: {{ formatTime(avg_times?.AvgCheckINTime) }}</p>
                                        <p>Official Time: {{ avg_times?.OpeningTime }}:00</p>
                                    </div>
                                    <div class="col-md-3" style="border-right: 1px solid #D6DCE1;">
                                        <p >Avg Check Out Time: {{avg_times.AvgCheckOutTime}}comented</p>
                                        <p>Avg Check Out Time: {{ formatTime(avg_times?.AvgCheckOutTime) }}</p>

                                        <p>Official Time: {{ avg_times?.ClosingTime }}:00</p>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-lg-12 col-12">
                                <div>
                                    <div class="col-lg-12 col-12 d-flex flex-wrap card-header border-bottom top-radius py-2 align-items-center">
    <div class="flex-grow-1">
        <h5 class="fw-semibold">Attendance Sheet</h5>
        <span class="text-primary">View all
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
            </svg>
        </span>
    </div>

    <!-- Button container with responsive flex -->
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <div data-v-step="7">
            <div class="card-body pb-50 text-center">
                <a data-bs-toggle="modal" data-bs-target="#timeAdj"
                    class="btn btn-sm btn-primary waves-effect waves-float waves-light d-flex align-items-center justify-content-center w-100">
                    <img class="px-2" src="/images/vector.png" alt="Absent">
                    Adjustment
                </a>
            </div>
        </div>

        <div data-v-step="7">
            <div class="card-body pb-50 text-center">
                <a data-bs-toggle="modal" data-bs-target="#markAttendance"
                    class="btn btn-sm btn-primary waves-effect waves-float waves-light d-flex align-items-center justify-content-center w-100">
                    <img class="px-2" src="/images/mark_attendance.png" alt="Absent">
                    Mark Attendance
                </a>
            </div>
        </div>
    </div>
</div>

                                    <!-- <div class="col-lg-6 card-header border-bottom top-radius">
                                        <div class="">
                                        <button
                                                class="btn btn-primary d-flex align-items-center justify-content-center px-4 py-2 rounded-3 shadow position-relative"
                                                style="width: 150px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
                                                    <path fill-rule="evenodd"
                                                        d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z" />
                                                </svg>
                                                <span class="flex-grow-1 text-center">Apply</span>
                                            </button>
                                            <button
                                                class="btn btn-primary d-flex align-items-center justify-content-center px-4 py-2 rounded-3 shadow position-relative"
                                                style="width: 150px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383" />
                                                    <path fill-rule="evenodd"
                                                        d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z" />
                                                </svg>
                                                <span class="flex-grow-1 text-center">Apply</span>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="">
                                    <div class="table-responsive" style="overflow-x: initial !important;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sticky-th-center">Date</th>
                                                    <th class="sticky-th-center">Check-In</th>
                                                    <!-- <th class="sticky-th-center">Check-In<br />Deviation</th> -->
                                                    <th class="sticky-th-center">Check-Out</th>
                                                    <!-- <th class="sticky-th-center">Check-Out<br />Deviation</th> -->
                                                    <th class="sticky-th-center">Total Office<br />Hours</th>
                                                    <th class="sticky-th-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="attendance1 in attendance"
                                                    :class="[attendance1.AttStatus == 'H' ? activeClass : '', attendance1.AttStatus == 'LE' ? primaryClass : '']">
                                                    <td class="td-right">
                                                        <label style="margin-left: -20px;">{{
                                                            dayname(attendance1.ATTDate)
                                                        }}, {{ attendance1.ATTDate }} </label>
                                                    </td>
                                                    <td class="text-center"
                                                        v-if="attendance1?.AttStatus == 'P' || attendance1.AttStatus == 'L'">
                                                        {{ attendance1?.CheckIN | formatTime }}
                                                        <svg v-if="attendance1.CheckInBy == 'Manual_Attendance'"
                                                            xmlns="http://www.w3.org/2000/svg" height="1.2em"
                                                            viewBox="0 0 640 512">
                                                            <title>Mannual Check-In</title>
                                                            <path
                                                                d="M128 32C92.7 32 64 60.7 64 96V352h64V96H512V352h64V96c0-35.3-28.7-64-64-64H128zM19.2 384C8.6 384 0 392.6 0 403.2C0 445.6 34.4 480 76.8 480H563.2c42.4 0 76.8-34.4 76.8-76.8c0-10.6-8.6-19.2-19.2-19.2H19.2z" />
                                                        </svg>
                                                        <svg v-else-if="attendance1.CheckInBy == 'Machine_Attendance'"
                                                            xmlns="http://www.w3.org/2000/svg" height="1.2em"
                                                            viewBox="0 0 512 512">
                                                            <title>Machine Check-In</title>
                                                            <path
                                                                d="M48 256C48 141.1 141.1 48 256 48c63.1 0 119.6 28.1 157.8 72.5c8.6 10.1 23.8 11.2 33.8 2.6s11.2-23.8 2.6-33.8C403.3 34.6 333.7 0 256 0C114.6 0 0 114.6 0 256v40c0 13.3 10.7 24 24 24s24-10.7 24-24V256zm458.5-52.9c-2.7-13-15.5-21.3-28.4-18.5s-21.3 15.5-18.5 28.4c2.9 13.9 4.5 28.3 4.5 43.1v40c0 13.3 10.7 24 24 24s24-10.7 24-24V256c0-18.1-1.9-35.8-5.5-52.9zM256 80c-19 0-37.4 3-54.5 8.6c-15.2 5-18.7 23.7-8.3 35.9c7.1 8.3 18.8 10.8 29.4 7.9c10.6-2.9 21.8-4.4 33.4-4.4c70.7 0 128 57.3 128 128v24.9c0 25.2-1.5 50.3-4.4 75.3c-1.7 14.6 9.4 27.8 24.2 27.8c11.8 0 21.9-8.6 23.3-20.3c3.3-27.4 5-55 5-82.7V256c0-97.2-78.8-176-176-176zM150.7 148.7c-9.1-10.6-25.3-11.4-33.9-.4C93.7 178 80 215.4 80 256v24.9c0 24.2-2.6 48.4-7.8 71.9C68.8 368.4 80.1 384 96.1 384c10.5 0 19.9-7 22.2-17.3c6.4-28.1 9.7-56.8 9.7-85.8V256c0-27.2 8.5-52.4 22.9-73.1c7.2-10.4 8-24.6-.2-34.2zM256 160c-53 0-96 43-96 96v24.9c0 35.9-4.6 71.5-13.8 106.1c-3.8 14.3 6.7 29 21.5 29c9.5 0 17.9-6.2 20.4-15.4c10.5-39 15.9-79.2 15.9-119.7V256c0-28.7 23.3-52 52-52s52 23.3 52 52v24.9c0 36.3-3.5 72.4-10.4 107.9c-2.7 13.9 7.7 27.2 21.8 27.2c10.2 0 19-7 21-17c7.7-38.8 11.6-78.3 11.6-118.1V256c0-53-43-96-96-96zm24 96c0-13.3-10.7-24-24-24s-24 10.7-24 24v24.9c0 59.9-11 119.3-32.5 175.2l-5.9 15.3c-4.8 12.4 1.4 26.3 13.8 31s26.3-1.4 31-13.8l5.9-15.3C267.9 411.9 280 346.7 280 280.9V256z" />
                                                        </svg>
                                                    </td>
                                                    <td v-else class="text-center">
                                                        {{ getAttendanceStatus(attendance1.AttStatus) }}
                                                    </td>

                                                    <td class="text-center text-danger"
                                                        v-if="attendance1.AttStatus == 'L' && attendance1?.OpeningTime != '-'"
                                                        title="Late">
                                                        {{ attendance1.CheckIN, attendance1?.OpeningTime | moment - ago
                                                        }}
                                                    </td>
                                                    <td class="text-center "
                                                        v-else-if="attendance1.AttStatus != 'P' && attendance1.AttStatus != 'L'">
                                                        -
                                                    </td>
                                                    <td class="text-center text-success"
                                                        v-else-if="attendance1.AttStatus == 'P' && attendance1.CheckIN != attendance1?.OpeningTime"
                                                        title="Early">
                                                        {{ attendance1.CheckIN, attendance1?.OpeningTime | moment - ago
                                                        }}
                                                    </td>
                                                    <td class="text-center text-success"
                                                        v-else-if="attendance1.AttStatus == 'P' && attendance1.CheckIN == attendance1?.OpeningTime">
                                                        On time
                                                    </td>
                                                    <td v-else class="text-center text-success">
                                                        -
                                                    </td>
                                                    <td class="text-center"
                                                        v-if="attendance1.AttStatus == 'P' || attendance1.AttStatus == 'L'">
                                                        {{ attendance1.CheckOut | formatTime }}
                                                        <svg v-if="attendance1.CheckOutBy == 'Manual_Attendance' && attendance1.CheckOut"
                                                            xmlns="http://www.w3.org/2000/svg" height="1.2em"
                                                            viewBox="0 0 640 512">
                                                            <title>Mannual Check-Out</title>
                                                            <path
                                                                d="M128 32C92.7 32 64 60.7 64 96V352h64V96H512V352h64V96c0-35.3-28.7-64-64-64H128zM19.2 384C8.6 384 0 392.6 0 403.2C0 445.6 34.4 480 76.8 480H563.2c42.4 0 76.8-34.4 76.8-76.8c0-10.6-8.6-19.2-19.2-19.2H19.2z" />
                                                        </svg>
                                                        <svg v-else-if="attendance1.CheckOutBy == 'Auto_CheckOut' && attendance1.CheckOut"
                                                            xmlns="http://www.w3.org/2000/svg" height="1.2em"
                                                            title="Auto Checkout" viewBox="0 0 512 512">
                                                            <title>Auto Check-Out</title>
                                                            <path
                                                                d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                                        </svg>
                                                        <svg v-else-if="attendance1.CheckOutBy == 'Machine_Attendance' && attendance1.CheckOut"
                                                            xmlns="http://www.w3.org/2000/svg" height="1.2em"
                                                            viewBox="0 0 512 512">
                                                            <title>Machine Check-Out</title>
                                                            <path
                                                                d="M48 256C48 141.1 141.1 48 256 48c63.1 0 119.6 28.1 157.8 72.5c8.6 10.1 23.8 11.2 33.8 2.6s11.2-23.8 2.6-33.8C403.3 34.6 333.7 0 256 0C114.6 0 0 114.6 0 256v40c0 13.3 10.7 24 24 24s24-10.7 24-24V256zm458.5-52.9c-2.7-13-15.5-21.3-28.4-18.5s-21.3 15.5-18.5 28.4c2.9 13.9 4.5 28.3 4.5 43.1v40c0 13.3 10.7 24 24 24s24-10.7 24-24V256c0-18.1-1.9-35.8-5.5-52.9zM256 80c-19 0-37.4 3-54.5 8.6c-15.2 5-18.7 23.7-8.3 35.9c7.1 8.3 18.8 10.8 29.4 7.9c10.6-2.9 21.8-4.4 33.4-4.4c70.7 0 128 57.3 128 128v24.9c0 25.2-1.5 50.3-4.4 75.3c-1.7 14.6 9.4 27.8 24.2 27.8c11.8 0 21.9-8.6 23.3-20.3c3.3-27.4 5-55 5-82.7V256c0-97.2-78.8-176-176-176zM150.7 148.7c-9.1-10.6-25.3-11.4-33.9-.4C93.7 178 80 215.4 80 256v24.9c0 24.2-2.6 48.4-7.8 71.9C68.8 368.4 80.1 384 96.1 384c10.5 0 19.9-7 22.2-17.3c6.4-28.1 9.7-56.8 9.7-85.8V256c0-27.2 8.5-52.4 22.9-73.1c7.2-10.4 8-24.6-.2-34.2zM256 160c-53 0-96 43-96 96v24.9c0 35.9-4.6 71.5-13.8 106.1c-3.8 14.3 6.7 29 21.5 29c9.5 0 17.9-6.2 20.4-15.4c10.5-39 15.9-79.2 15.9-119.7V256c0-28.7 23.3-52 52-52s52 23.3 52 52v24.9c0 36.3-3.5 72.4-10.4 107.9c-2.7 13.9 7.7 27.2 21.8 27.2c10.2 0 19-7 21-17c7.7-38.8 11.6-78.3 11.6-118.1V256c0-53-43-96-96-96zm24 96c0-13.3-10.7-24-24-24s-24 10.7-24 24v24.9c0 59.9-11 119.3-32.5 175.2l-5.9 15.3c-4.8 12.4 1.4 26.3 13.8 31s26.3-1.4 31-13.8l5.9-15.3C267.9 411.9 280 346.7 280 280.9V256z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-center" v-else>-</td>
                                                    <td class=" text-center text -danger"
                                                        v-if="attendance1.CheckOut < attendance1?.ClosingTime"
                                                        title="Early">
                                                        {{ attendance1.CheckOut, attendance1?.ClosingTime | moment - ago
                                                        }}
                                                    </td>
                                                    <td class=" text-center text-success"
                                                        v-else-if="attendance1.CheckOut > (attendance1?.ClosingTime + ':00.0000000')"
                                                        title="Excess">
                                                        {{ attendance1.CheckOut, attendance1?.ClosingTime | moment - ago
                                                        }}
                                                    </td>
                                                    <td class="text-center text-danger"
                                                        v-else-if="(attendance1.CheckOut == '' || attendance1.CheckOut == null) && (attendance1.AttStatus == 'P' || attendance1.AttStatus == 'L')">
                                                        Un-marked
                                                    </td>
                                                    <td class="text-center"
                                                        v-else-if="attendance1.AttStatus != 'P' && attendance1.AttStatus != 'L'">
                                                        -
                                                    </td>
                                                    <td class="text-center" v-else>On time</td>
                                                    <td class="text-center fw-bold"
                                                        v-if="attendance1.CheckIN && attendance1.CheckOut && (attendance1.AttStatus == 'P' || attendance1.AttStatus == 'L')">
                                                        {{
                                                            calculateTimeDifference(attendance1.CheckIN,
                                                                attendance1.CheckOut)
                                                        }}
                                                    </td>
                                                    <td class="text-center" v-else>-</td>
                                                    <td class="text-center">
                                                        <div
                                                            class="d-flex align-items-center col-actions justify-content-center">
                                                            <div
                                                                v-if="attendance1.AttStatus == 'P' || attendance1.AttStatus == 'L'">
                                                                <a @click="get_date(attendance1.ATTDate)"
                                                                    data-bs-toggle="modal" data-bs-target="#timeAdj"
                                                                    class="badge badge-glow bg-success">
                                                                    <!-- <i class="fa-brands fa-creative-commons-sa"></i> -->
                                                                    Time adjustment
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div v-else-if="this.fetchempcode == 'a'" class="app-content content ">
                <div class="content-overlay"></div>
                <div class="header-navbar-shadow"></div>
                <div class="content-wrapper container-xxl p-0">
                    <div class="content-header row">
                        <div class=" breadcrumb-wrapper">
                            <div class="col-12">
                                <h2 class="content-header-title float-start mb-0">Dashboard</h2>
                            </div>
                        </div>
                    </div>
                    <!-- Main content body-->
                    <div class="content-body">
                        <!--/ Edit User Modal -->
                        <div class="row match-height">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div>
                                            <h2 class="fw-bolder mb-0">2000</h2>
                                            <p class="card-text">Total Companies</p>
                                        </div>
                                        <div class="avatar bg-light-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-user avatar-icon">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div>
                                            <h2 class="fw-bolder mb-0">400</h2>
                                            <p class="card-text">Active</p>
                                        </div>
                                        <div class="avatar bg-light-primary me-2">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div>
                                            <h2 class="fw-bolder mb-0">7</h2>
                                            <p class="card-text">Suspended</p>
                                        </div>
                                        <div class="avatar bg-light-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <i data-feather="alert-octagon" class="font-medium-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div>
                                            <h2 class="fw-bolder mb-0">2.38k</h2>
                                            <p class="card-text">Earnings</p>
                                        </div>
                                        <div class="avatar bg-light-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <i data-feather="activity" class="font-medium-5"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row match-height">
                            <!-- Sales Line Chart Card -->
                            <div class="col-8">
                                <div class="card" style="height: 400px">
                                    <div class="card-header align-items-start">
                                        <div>
                                            <h4 class="card-title mb-25">Sales</h4>
                                            <p class="card-text mb-0">2022 Total Sales: 12.84k</p>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-settings font-medium-3 text-muted cursor-pointer">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path
                                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="card-body pb-0" style="position: relative;">
                                        <div id="sales-line-chart" style="min-height: 255px;">
                                            <div id="apexchartsprawomrai"
                                                class="apexcharts-canvas apexchartsprawomrai apexcharts-theme-light"
                                                style="width: 674px; height: 240px;">
                                                <svg id="SvgjsSvg2046" width="674" height="240"
                                                    xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                    xmlns:data="ApexChartsNS" transform="translate(-10, 0)"
                                                    style="background: transparent;">
                                                    <g id="SvgjsG2048" class="apexcharts-inner apexcharts-graphical"
                                                        transform="translate(57.60058403015137, 10)">
                                                        <defs id="SvgjsDefs2047">
                                                            <clipPath id="gridRectMaskprawomrai">
                                                                <rect id="SvgjsRect2054" width="601.2350635528564"
                                                                    height="190.0296284866333" x="-4" y="-2" rx="0"
                                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                                    stroke-dasharray="0" fill="#fff"></rect>
                                                            </clipPath>
                                                            <clipPath id="gridRectMarkerMaskprawomrai">
                                                                <rect id="SvgjsRect2055" width="597.2350635528564"
                                                                    height="190.0296284866333" x="-2" y="-2" rx="0"
                                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                                    stroke-dasharray="0" fill="#fff"></rect>
                                                            </clipPath>
                                                            <linearGradient id="SvgjsLinearGradient2060" x1="0" y1="1"
                                                                x2="1" y2="1">
                                                                <stop id="SvgjsStop2061" stop-opacity="1"
                                                                    stop-color="rgba(223,135,242,1)" offset="0"></stop>
                                                                <stop id="SvgjsStop2062" stop-opacity="1"
                                                                    stop-color="rgba(115,103,240,1)" offset="1"></stop>
                                                                <stop id="SvgjsStop2063" stop-opacity="1"
                                                                    stop-color="rgba(115,103,240,1)" offset="1"></stop>
                                                                <stop id="SvgjsStop2064" stop-opacity="1"
                                                                    stop-color="rgba(223,135,242,1)" offset="1"></stop>
                                                            </linearGradient>
                                                            <filter id="SvgjsFilter2066" filterUnits="userSpaceOnUse"
                                                                width="200%" height="200%" x="-50%" y="-50%">
                                                                <feFlood id="SvgjsFeFlood2067" flood-color="#000000"
                                                                    flood-opacity="0.2" result="SvgjsFeFlood2067Out"
                                                                    in="SourceGraphic"></feFlood>
                                                                <feComposite id="SvgjsFeComposite2068"
                                                                    in="SvgjsFeFlood2067Out" in2="SourceAlpha"
                                                                    operator="in" result="SvgjsFeComposite2068Out">
                                                                </feComposite>
                                                                <feOffset id="SvgjsFeOffset2069" dx="2" dy="18"
                                                                    result="SvgjsFeOffset2069Out"
                                                                    in="SvgjsFeComposite2068Out"></feOffset>
                                                                <feGaussianBlur id="SvgjsFeGaussianBlur2070"
                                                                    stdDeviation="5 "
                                                                    result="SvgjsFeGaussianBlur2070Out"
                                                                    in="SvgjsFeOffset2069Out"></feGaussianBlur>
                                                                <feMerge id="SvgjsFeMerge2071"
                                                                    result="SvgjsFeMerge2071Out" in="SourceGraphic">
                                                                    <feMergeNode id="SvgjsFeMergeNode2072"
                                                                        in="SvgjsFeGaussianBlur2070Out"></feMergeNode>
                                                                    <feMergeNode id="SvgjsFeMergeNode2073"
                                                                        in="[object Arguments]"></feMergeNode>
                                                                </feMerge>
                                                                <feBlend id="SvgjsFeBlend2074" in="SourceGraphic"
                                                                    in2="SvgjsFeMerge2071Out" mode="normal"
                                                                    result="SvgjsFeBlend2074Out"></feBlend>
                                                            </filter>
                                                        </defs>
                                                        <line id="SvgjsLine2053" x1="0" y1="0" x2="0"
                                                            y2="186.0296284866333" stroke="#b6b6b6" stroke-dasharray="3"
                                                            class="apexcharts-xcrosshairs" x="0" y="0" width="1"
                                                            height="186.0296284866333" fill="#b1b9c4" filter="none"
                                                            fill-opacity="0.9" stroke-width="1"></line>
                                                        <g id="SvgjsG2075" class="apexcharts-xaxis"
                                                            transform="translate(0, 0)">
                                                            <g id="SvgjsG2076" class="apexcharts-xaxis-texts-g"
                                                                transform="translate(0, 1)">
                                                                <text id="SvgjsText2078"
                                                                    font-family="Helvetica, Arial, sans-serif" x="0"
                                                                    y="220.0296284866333" text-anchor="middle"
                                                                    dominant-baseline="auto" font-size="0.857rem"
                                                                    font-weight="400" fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2079">Jan</tspan>
                                                                    <title>Jan</title>
                                                                </text>
                                                                <text id="SvgjsText2081"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="53.930460322986946" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2082">Feb</tspan>
                                                                    <title>Feb</title>
                                                                </text>
                                                                <text id="SvgjsText2084"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="107.86092064597389" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2085">Mar</tspan>
                                                                    <title>Mar</title>
                                                                </text>
                                                                <text id="SvgjsText2087"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="161.79138096896085" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2088">Apr</tspan>
                                                                    <title>Apr</title>
                                                                </text>
                                                                <text id="SvgjsText2090"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="215.7218412919478" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2091">May</tspan>
                                                                    <title>May</title>
                                                                </text>
                                                                <text id="SvgjsText2093"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="269.65230161493474" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2094">Jun</tspan>
                                                                    <title>Jun</title>
                                                                </text>
                                                                <text id="SvgjsText2096"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="323.5827619379217" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2097">July</tspan>
                                                                    <title>July</title>
                                                                </text>
                                                                <text id="SvgjsText2099"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="377.51322226090866" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2100">Aug</tspan>
                                                                    <title>Aug</title>
                                                                </text>
                                                                <text id="SvgjsText2102"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="431.4436825838956" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2103">Sep</tspan>
                                                                    <title>Sep</title>
                                                                </text>
                                                                <text id="SvgjsText2105"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="485.3741429068826" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2106">Oct</tspan>
                                                                    <title>Oct</title>
                                                                </text>
                                                                <text id="SvgjsText2108"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="539.3046032298696" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2109">Nov</tspan>
                                                                    <title>Nov</title>
                                                                </text>
                                                                <text id="SvgjsText2111"
                                                                    font-family="Helvetica, Arial, sans-serif"
                                                                    x="593.2350635528566" y="220.0296284866333"
                                                                    text-anchor="middle" dominant-baseline="auto"
                                                                    font-size="0.857rem" font-weight="400"
                                                                    fill="#b9b9c3"
                                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                                    <tspan id="SvgjsTspan2112">Dec</tspan>
                                                                    <title>Dec</title>
                                                                </text>
                                                            </g>
                                                        </g>
                                                        <g id="SvgjsG2127" class="apexcharts-grid">
                                                            <g id="SvgjsG2128" class="apexcharts-gridlines-horizontal">
                                                                <line id="SvgjsLine2130" x1="0" y1="0"
                                                                    x2="593.2350635528564" y2="0" stroke="#ebe9f1"
                                                                    stroke-dasharray="0" class="apexcharts-gridline">
                                                                </line>
                                                                <line id="SvgjsLine2131" x1="0" y1="37.20592569732666"
                                                                    x2="593.2350635528564" y2="37.20592569732666"
                                                                    stroke="#ebe9f1" stroke-dasharray="0"
                                                                    class="apexcharts-gridline"></line>
                                                                <line id="SvgjsLine2132" x1="0" y1="74.41185139465333"
                                                                    x2="593.2350635528564" y2="74.41185139465333"
                                                                    stroke="#ebe9f1" stroke-dasharray="0"
                                                                    class="apexcharts-gridline"></line>
                                                                <line id="SvgjsLine2133" x1="0" y1="111.61777709197999"
                                                                    x2="593.2350635528564" y2="111.61777709197999"
                                                                    stroke="#ebe9f1" stroke-dasharray="0"
                                                                    class="apexcharts-gridline"></line>
                                                                <line id="SvgjsLine2134" x1="0" y1="148.82370278930665"
                                                                    x2="593.2350635528564" y2="148.82370278930665"
                                                                    stroke="#ebe9f1" stroke-dasharray="0"
                                                                    class="apexcharts-gridline"></line>
                                                                <line id="SvgjsLine2135" x1="0" y1="186.02962848663333"
                                                                    x2="593.2350635528564" y2="186.02962848663333"
                                                                    stroke="#ebe9f1" stroke-dasharray="0"
                                                                    class="apexcharts-gridline"></line>
                                                            </g>
                                                            <g id="SvgjsG2129" class="apexcharts-gridlines-vertical">
                                                            </g>
                                                            <line id="SvgjsLine2137" x1="0" y1="186.0296284866333"
                                                                x2="593.2350635528564" y2="186.0296284866333"
                                                                stroke="transparent" stroke-dasharray="0"></line>
                                                            <line id="SvgjsLine2136" x1="0" y1="1" x2="0"
                                                                y2="186.0296284866333" stroke="transparent"
                                                                stroke-dasharray="0"></line>
                                                        </g>
                                                        <g id="SvgjsG2056"
                                                            class="apexcharts-line-series apexcharts-plot-series">
                                                            <g id="SvgjsG2057" class="apexcharts-series"
                                                                seriesName="Sales" data:longestSeries="true" rel="1"
                                                                data:realIndex="0">
                                                                <path id="SvgjsPath2065"
                                                                    d="M 0 156.26488792877197C 18.87566111304543 156.26488792877197 35.05479920994152 126.50014737091064 53.93046032298695 126.50014737091064C 72.80612143603238 126.50014737091064 88.98525953292847 148.82370278930665 107.8609206459739 148.82370278930665C 126.73658175901933 148.82370278930665 142.91571985591543 107.89718452224733 161.79138096896085 107.89718452224733C 180.66704208200628 107.89718452224733 196.8461801789024 141.3825176498413 215.7218412919478 141.3825176498413C 234.59750240499324 141.3825176498413 250.77664050188932 40.92651826705932 269.65230161493474 40.92651826705932C 288.5279627279802 40.92651826705932 304.70710082487625 167.42666563796996 323.5827619379217 167.42666563796996C 342.45842305096716 167.42666563796996 358.6375611478632 70.69125882492065 377.51322226090866 70.69125882492065C 396.3888833739541 70.69125882492065 412.56802147085017 107.89718452224733 431.4436825838956 107.89718452224733C 450.319343696941 107.89718452224733 466.49848179383713 33.485333127594004 485.3741429068825 33.485333127594004C 504.249804019928 33.485333127594004 520.428942116824 81.85303653411864 539.3046032298695 81.85303653411864C 558.1802643429149 81.85303653411864 574.359402439811 40.92651826705932 593.2350635528564 40.92651826705932"
                                                                    fill="none" fill-opacity="1"
                                                                    stroke="url(#SvgjsLinearGradient2060)"
                                                                    stroke-opacity="1" stroke-linecap="butt"
                                                                    stroke-width="4" stroke-dasharray="0"
                                                                    class="apexcharts-line" index="0"
                                                                    clip-path="url(#gridRectMaskprawomrai)"
                                                                    filter="url(#SvgjsFilter2066)"
                                                                    pathTo="M 0 156.26488792877197C 18.87566111304543 156.26488792877197 35.05479920994152 126.50014737091064 53.93046032298695 126.50014737091064C 72.80612143603238 126.50014737091064 88.98525953292847 148.82370278930665 107.8609206459739 148.82370278930665C 126.73658175901933 148.82370278930665 142.91571985591543 107.89718452224733 161.79138096896085 107.89718452224733C 180.66704208200628 107.89718452224733 196.8461801789024 141.3825176498413 215.7218412919478 141.3825176498413C 234.59750240499324 141.3825176498413 250.77664050188932 40.92651826705932 269.65230161493474 40.92651826705932C 288.5279627279802 40.92651826705932 304.70710082487625 167.42666563796996 323.5827619379217 167.42666563796996C 342.45842305096716 167.42666563796996 358.6375611478632 70.69125882492065 377.51322226090866 70.69125882492065C 396.3888833739541 70.69125882492065 412.56802147085017 107.89718452224733 431.4436825838956 107.89718452224733C 450.319343696941 107.89718452224733 466.49848179383713 33.485333127594004 485.3741429068825 33.485333127594004C 504.249804019928 33.485333127594004 520.428942116824 81.85303653411864 539.3046032298695 81.85303653411864C 558.1802643429149 81.85303653411864 574.359402439811 40.92651826705932 593.2350635528564 40.92651826705932"
                                                                    pathFrom="M -1 260.4414798812866L -1 260.4414798812866L 53.93046032298695 260.4414798812866L 107.8609206459739 260.4414798812866L 161.79138096896085 260.4414798812866L 215.7218412919478 260.4414798812866L 269.65230161493474 260.4414798812866L 323.5827619379217 260.4414798812866L 377.51322226090866 260.4414798812866L 431.4436825838956 260.4414798812866L 485.3741429068825 260.4414798812866L 539.3046032298695 260.4414798812866L 593.2350635528564 260.4414798812866">
                                                                </path>
                                                                <g id="SvgjsG2058"
                                                                    class="apexcharts-series-markers-wrap"
                                                                    data:realIndex="0">
                                                                    <g class="apexcharts-series-markers">
                                                                        <circle id="SvgjsCircle2143" r="0" cx="0" cy="0"
                                                                            class="apexcharts-marker wm6hvs4wn no-pointer-events"
                                                                            stroke="#ffffff" fill="#df87f2"
                                                                            fill-opacity="1" stroke-width="2"
                                                                            stroke-opacity="0.9"
                                                                            default-marker-size="0"></circle>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g id="SvgjsG2059" class="apexcharts-datalabels"
                                                                data:realIndex="0"></g>
                                                        </g>
                                                        <line id="SvgjsLine2138" x1="0" y1="0" x2="593.2350635528564"
                                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0"
                                                            stroke-width="1" class="apexcharts-ycrosshairs"></line>
                                                        <line id="SvgjsLine2139" x1="0" y1="0" x2="593.2350635528564"
                                                            y2="0" stroke-dasharray="0" stroke-width="0"
                                                            class="apexcharts-ycrosshairs-hidden"></line>
                                                        <g id="SvgjsG2140" class="apexcharts-yaxis-annotations"></g>
                                                        <g id="SvgjsG2141" class="apexcharts-xaxis-annotations"></g>
                                                        <g id="SvgjsG2142" class="apexcharts-point-annotations"></g>
                                                    </g>
                                                    <rect id="SvgjsRect2052" width="0" height="0" x="0" y="0" rx="0"
                                                        ry="0" opacity="1" stroke-width="0" stroke="none"
                                                        stroke-dasharray="0" fill="#fefefe"></rect>
                                                    <g id="SvgjsG2113" class="apexcharts-yaxis" rel="0"
                                                        transform="translate(19.600584030151367, 0)">
                                                        <g id="SvgjsG2114" class="apexcharts-yaxis-texts-g">
                                                            <text id="SvgjsText2115"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="11.5" text-anchor="end" dominant-baseline="auto"
                                                                font-size="0.857rem" font-weight="400" fill="#b9b9c3"
                                                                class="apexcharts-text apexcharts-yaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan2116">350</tspan>
                                                            </text>
                                                            <text id="SvgjsText2117"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="48.70592569732666" text-anchor="end"
                                                                dominant-baseline="auto" font-size="0.857rem"
                                                                font-weight="400" fill="#b9b9c3"
                                                                class="apexcharts-text apexcharts-yaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan2118">300</tspan>
                                                            </text>
                                                            <text id="SvgjsText2119"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="85.91185139465333" text-anchor="end"
                                                                dominant-baseline="auto" font-size="0.857rem"
                                                                font-weight="400" fill="#b9b9c3"
                                                                class="apexcharts-text apexcharts-yaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan2120">250</tspan>
                                                            </text>
                                                            <text id="SvgjsText2121"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="123.11777709197999" text-anchor="end"
                                                                dominant-baseline="auto" font-size="0.857rem"
                                                                font-weight="400" fill="#b9b9c3"
                                                                class="apexcharts-text apexcharts-yaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan2122">200</tspan>
                                                            </text>
                                                            <text id="SvgjsText2123"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="160.32370278930665" text-anchor="end"
                                                                dominant-baseline="auto" font-size="0.857rem"
                                                                font-weight="400" fill="#b9b9c3"
                                                                class="apexcharts-text apexcharts-yaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan2124">150</tspan>
                                                            </text>
                                                            <text id="SvgjsText2125"
                                                                font-family="Helvetica, Arial, sans-serif" x="20"
                                                                y="197.52962848663333" text-anchor="end"
                                                                dominant-baseline="auto" font-size="0.857rem"
                                                                font-weight="400" fill="#b9b9c3"
                                                                class="apexcharts-text apexcharts-yaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan2126">100</tspan>
                                                            </text>
                                                        </g>
                                                    </g>
                                                    <g id="SvgjsG2049" class="apexcharts-annotations"></g>
                                                </svg>
                                                <div class="apexcharts-legend" style="max-height: 120px;"></div>
                                                <div class="apexcharts-tooltip apexcharts-theme-light">
                                                    <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                        <span class="apexcharts-tooltip-marker"
                                                            style="background-color: rgb(223, 135, 242);"></span>
                                                        <div class="apexcharts-tooltip-text"
                                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                            <div class="apexcharts-tooltip-y-group"><span
                                                                    class="apexcharts-tooltip-text-label"></span><span
                                                                    class="apexcharts-tooltip-text-value"></span></div>
                                                            <div class="apexcharts-tooltip-z-group"><span
                                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                                    class="apexcharts-tooltip-text-z-value"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
                                                    <div class="apexcharts-xaxistooltip-text"
                                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                    </div>
                                                </div>
                                                <div
                                                    class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                                    <div class="apexcharts-yaxistooltip-text"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="resize-triggers">
                                            <div class="expand-trigger">
                                                <div style="width: 717px; height: 256px;"></div>
                                            </div>
                                            <div class="contract-trigger"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sales Line Chart Card -->
                            <!-- Product Order Card -->
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4 class="card-title">Product Orders</h4>
                                        <div class="dropdown chart-dropdown">
                                            <button class="btn btn-sm border-0 dropdown-toggle px-50" type="button"
                                                id="dropdownItem2" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Last 7 Days
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownItem2">
                                                <a class="dropdown-item" href="#">Last 28 Days</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Last Year</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="product-order-chart"></div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <i data-feather="circle" class="font-medium-1 text-primary"></i>
                                                <span class="fw-bold ms-75">Finished</span>
                                            </div>
                                            <span>23043</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <div class="d-flex align-items-center">
                                                <i data-feather="circle" class="font-medium-1 text-warning"></i>
                                                <span class="fw-bold ms-75">Pending</span>
                                            </div>
                                            <span>14658</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i data-feather="circle" class="font-medium-1 text-danger"></i>
                                                <span class="fw-bold ms-75">Rejected</span>
                                            </div>
                                            <span>4758</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Product Order Card -->
                        </div>
                        <div class="row match-height">
                            <!-- Plan Card -->
                            <div class="col-4">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                        </div>
                                        <ul class="ps-1 mb-2">
                                            <li class="mb-50">50 Users</li>
                                        </ul>
                                        <div class="d-flex justify-content-between align-items-center fw-bolder mb-50">
                                            <span>Users</span>
                                            <span>4 of 50 Used</span>
                                        </div>
                                        <div class="progress mb-50" style="height: 8px">
                                            <div class="progress-bar" role="progressbar" style="width: 80%"
                                                aria-valuenow="65" aria-valuemax="100" aria-valuemin="80"></div>
                                        </div>
                                        <span>4 are active</span>
                                        <div class="d-grid w-100 mt-2">
                                            <button class="btn btn-primary" data-bs-target="#upgradePlanModal"
                                                data-bs-toggle="modal">
                                                Total Users
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Plan Card -->
                            <!-- Plan Card -->
                            <div class="col-4">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                        </div>
                                        <ul class="ps-1 mb-2">
                                            <li class="mb-50">10 Modules</li>
                                        </ul>
                                        <div class="d-flex justify-content-between align-items-center fw-bolder mb-50">
                                            <span>Modules</span>
                                            <span>4 of 10 Used</span>
                                        </div>
                                        <div class="progress mb-50" style="height: 8px">
                                            <div class="progress-bar" role="progressbar" style="width: 80%"
                                                aria-valuenow="65" aria-valuemax="100" aria-valuemin="80"></div>
                                        </div>
                                        <span>4 are active</span>
                                        <div class="d-grid w-100 mt-2">
                                            <button class="btn btn-primary" data-bs-target="#upgradePlanModal"
                                                data-bs-toggle="modal">
                                                Total Modules
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Plan Card -->
                            <!-- Plan Card -->
                            <div class="col-4">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                        </div>
                                        <ul class="ps-1 mb-2">
                                            <li class="mb-50">30 Companies</li>
                                        </ul>
                                        <div class="d-flex justify-content-between align-items-center fw-bolder mb-50">
                                            <span>Companies</span>
                                            <span>10 of 30</span>
                                        </div>
                                        <div class="progress mb-50" style="height: 8px">
                                            <div class="progress-bar" role="progressbar" style="width: 80%"
                                                aria-valuenow="65" aria-valuemax="100" aria-valuemin="80"></div>
                                        </div>
                                        <span>10 are active</span>
                                        <div class="d-grid w-100 mt-2">
                                            <button class="btn btn-primary" data-bs-target="#upgradePlanModal"
                                                data-bs-toggle="modal">
                                                Total Companies
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Plan Card -->
                        </div>
                        <div class="row match-height">
                            <!-- Company Table Card -->
                            <div class="col-lg-8 col-12">
                                <div class="card card-company-table">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Company</th>
                                                        <th>Category</th>
                                                        <th>Views</th>
                                                        <th>Revenue</th>
                                                        <th>Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/toolbox.svg"
                                                                            alt="Toolbar svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Dixons</div>
                                                                    <div class="font-small-2 text-muted">meguc@ruj.io
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="monitor"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Technology</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">23.4k</span>
                                                                <span class="font-small-2 text-muted">in 24 hours</span>
                                                            </div>
                                                        </td>
                                                        <td>$891.2</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">68%</span>
                                                                <i data-feather="trending-down"
                                                                    class="text-danger font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/parachute.svg"
                                                                            alt="Parachute svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Motels</div>
                                                                    <div class="font-small-2 text-muted">
                                                                        vecav@hodzi.co.uk
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-success me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="coffee"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Grocery</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">78k</span>
                                                                <span class="font-small-2 text-muted">in 2 days</span>
                                                            </div>
                                                        </td>
                                                        <td>$668.51</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">97%</span>
                                                                <i data-feather="trending-up"
                                                                    class="text-success font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/brush.svg"
                                                                            alt="Brush svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Zipcar</div>
                                                                    <div class="font-small-2 text-muted">davcilse@is.gov
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-warning me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="watch"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Fashion</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">162</span>
                                                                <span class="font-small-2 text-muted">in 5 days</span>
                                                            </div>
                                                        </td>
                                                        <td>$522.29</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">62%</span>
                                                                <i data-feather="trending-up"
                                                                    class="text-success font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/star.svg"
                                                                            alt="Star svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Owning</div>
                                                                    <div class="font-small-2 text-muted">us@cuhil.gov
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="monitor"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Technology</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">214</span>
                                                                <span class="font-small-2 text-muted">in 24 hours</span>
                                                            </div>
                                                        </td>
                                                        <td>$291.01</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">88%</span>
                                                                <i data-feather="trending-up"
                                                                    class="text-success font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/book.svg"
                                                                            alt="Book svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Cafés</div>
                                                                    <div class="font-small-2 text-muted">pudais@jife.com
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-success me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="coffee"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Grocery</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">208</span>
                                                                <span class="font-small-2 text-muted">in 1 week</span>
                                                            </div>
                                                        </td>
                                                        <td>$783.93</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">16%</span>
                                                                <i data-feather="trending-down"
                                                                    class="text-danger font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/rocket.svg"
                                                                            alt="Rocket svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Kmart</div>
                                                                    <div class="font-small-2 text-muted">bipri@cawiw.com
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-warning me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="watch"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Fashion</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">990</span>
                                                                <span class="font-small-2 text-muted">in 1 month</span>
                                                            </div>
                                                        </td>
                                                        <td>$780.05</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">78%</span>
                                                                <i data-feather="trending-up"
                                                                    class="text-success font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar rounded">
                                                                    <div class="avatar-content">
                                                                        <img src="public/app-assets/images/icons/speaker.svg"
                                                                            alt="Speaker svg" />
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder">Payers</div>
                                                                    <div class="font-small-2 text-muted">luk@izug.io
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-warning me-1">
                                                                    <div class="avatar-content">
                                                                        <i data-feather="watch"
                                                                            class="font-medium-3"></i>
                                                                    </div>
                                                                </div>
                                                                <span>Fashion</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">12.9k</span>
                                                                <span class="font-small-2 text-muted">in 12 hours</span>
                                                            </div>
                                                        </td>
                                                        <td>$531.49</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="fw-bolder me-1">42%</span>
                                                                <i data-feather="trending-up"
                                                                    class="text-success font-medium-1"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Company Table Card -->
                            <!-- Transaction Card -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="card card-transaction">
                                    <div class="card-header">
                                        <h4 class="card-title">Summary</h4>
                                        <div class="dropdown chart-dropdown">
                                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"
                                                data-bs-toggle="dropdown"></i>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Last 28 Days</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Last Year</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="transaction-item">
                                            <div class="d-flex">
                                                <div class="avatar bg-light-primary rounded float-start">
                                                    <div class="avatar-content">
                                                        <i data-feather="pocket" class="avatar-icon font-medium-3"></i>
                                                    </div>
                                                </div>
                                                <div class="transaction-percentage">
                                                    <h6 class="transaction-title">Hr-Module</h6>
                                                    <small>Total-Users</small>
                                                </div>
                                            </div>
                                            <div class="fw-bolder text-danger">74</div>
                                        </div>
                                        <div class="transaction-item">
                                            <div class="d-flex">
                                                <div class="avatar bg-light-success rounded float-start">
                                                    <div class="avatar-content">
                                                        <i data-feather="check" class="avatar-icon font-medium-3"></i>
                                                    </div>
                                                </div>
                                                <div class="transaction-percentage">
                                                    <h6 class="transaction-title">Recruitment Module</h6>
                                                    <small>Total-Users</small>
                                                </div>
                                            </div>
                                            <div class="fw-bolder text-success">40</div>
                                        </div>
                                        <div class="transaction-item">
                                            <div class="d-flex">
                                                <div class="avatar bg-light-danger rounded float-start">
                                                    <div class="avatar-content">
                                                        <i data-feather="dollar-sign"
                                                            class="avatar-icon font-medium-3"></i>
                                                    </div>
                                                </div>
                                                <div class="transaction-percentage">
                                                    <h6 class="transaction-title">Payroll Module</h6>
                                                    <small>Total-Users</small>
                                                </div>
                                            </div>
                                            <div class="fw-bolder text-success">10</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Transaction Card -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- View annual leave modal -->
            <div class="modal fade" id="emp_leaves" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pb-5 px-sm-5 pt-50">
                            <div class="text-center mb-2">
                                <h1 class="mb-1">
                                    Your {{ lvtype }} Leaves Detail
                                </h1>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="vertical-align:middle !important">For Date
                                            </th>
                                            <th class="text-center" style="vertical-align:middle !important">
                                                Leave<br />Type
                                            </th>
                                            <th style="vertical-align:middle !important">Reason</th>
                                            <th class="text-center" style="vertical-align:middle !important">
                                                Manager<br />status
                                            </th>
                                            <th class="text-center" style="vertical-align:middle !important">HR<br />
                                                status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="this_m_lvs1 in this_m_lvs">
                                            <td class="text-center" style="vertical-align:middle;">
                                                {{ this_m_lvs1.StartDate }}<br /><label
                                                    v-if="this_m_lvs1.NoOfDays > 1">to<br />{{ this_m_lvs1.EndDate
                                                    }}</label>
                                            </td>
                                            <td class="text-center" style="vertical-align:middle;">
                                                {{ this_m_lvs1.Leavetype }}
                                            </td>
                                            <td style="vertical-align:middle;">{{ this_m_lvs1.Reason }}</td>
                                            <td v-if="this_m_lvs1.ManagerApproval == 'Approved'" class="text-center">
                                                <span class="badge bg-gradient-success">Approved</span>
                                            </td>

                                            <td v-else-if="this_m_lvs1.ManagerApproval == 'Rejected'"
                                                class="text-center">
                                                <span class="badge bg-gradient-danger">Rejected</span>
                                            </td>
                                            <td v-else class="text-center"><span
                                                    class="badge bg-gradient-warning">Pending</span></td>
                                            <td v-if="this_m_lvs1.HRApproval == 'Approved'" class="text-center"><span
                                                    class="badge bg-gradient-success">Approved</span></td>
                                            <td v-else-if="this_m_lvs1.HRApproval == 'Rejected'" class="text-center">
                                                <span class="badge bg-gradient-danger">Rejected</span>
                                            </td>

                                            <td v-else class="text-center"><span
                                                    class="badge bg-gradient-warning">pending</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ View annual leave modal -->
            <!--/ View Casual leave modal -->
            <!-- Apply for leave modal  -->
            <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <div class="text-center mb-2">
                                <h1 class="mb-1">Apply for leave</h1>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-sm-5 mx-50 pb-5">
                            <!-- form -->
                            <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                <div class="col-12">
                                    <table class="table" v-if="this.isLvEmpty != 'Empty'">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Leave Type</th>
                                                <th class="text-center">Granted</th>
                                                <th class="text-center">Used</th>
                                                <th class="text-center">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="leavesblnc1 in leavesblnc">
                                                <td class="text-center">{{ leavesblnc1.LeaveType }}</td>
                                                <td class="text-center">{{ leavesblnc1.TotalLeave }}</td>
                                                <td class="text-center">
                                                    {{ leavesblnc1.TotalLeave - leavesblnc1.RemainingLeave }}
                                                </td>
                                                <td class="text-center">{{ leavesblnc1.RemainingLeave }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="modalAddCardNumber">Leave Types <span
                                            style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <select v-model="type" class="form-control">

                                        <option v-for='leavetypes1 in leavetypes' :value='leavetypes1.LeaveType'>
                                            {{ leavetypes1.LeaveType }}
                                        </option>
                                    </select>
                                    <span style="color: #DB4437; font-size: 11px;" v-if="type == ''">{{ type_error
                                        }}</span>
                                </div>
                                <div class="col-12 col-sm-12 mb-1">
                                    <label class="form-label" for="basicSelect">Number of days</label>
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
                                <div class="col-md-02">
                                    <label class="form-label" for="modalAddCardName">Date</label>
                                    <label class="form-label" v-if="this.days == 'Multiple Days'"
                                        for="modalAddCardName">
                                        From</label>
                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                    <input type="date" v-model="d_from" id="modalAddCardName" class="form-control" />
                                    <span style="color: #DB4437; font-size: 11px;" v-if="d_from == ''">{{ d_from_error
                                        }}</span>
                                </div>
                                <div class="col-md-02" v-if="this.days == 'Multiple Days'">
                                    <label class="form-label" for="modalAddCardName">Date To<span
                                            style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="date" v-model="d_to" id="modalAddCardName" class="form-control" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Reason <span
                                            style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="text" v-model="reason" id="modalAddCardName" class="form-control"
                                        placeholder="Reason of leave" />
                                    <span style="color: #DB4437; font-size: 11px;" v-if="reason == ''">{{ reason_error
                                        }}</span>
                                </div>
                                <div class="col-12 text-center" style="margin-top:6%">
                                    <button
                                        v-if="type == '' || d_from == '' || reason == '' || (days == 'Multiple Days' && d_to == '')"
                                        type="submit" :disabled="disabled" @click="delay()"
                                        class="btn btn-danger me-1 mt-1">Apply
                                    </button>
                                    <button v-else type="submit" :disabled="disabled" @click="delay()"
                                        class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal"
                                        aria-label="Close">Apply
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
            <!--/ Apply for leave modal  -->
            <!-- Apply for loan modal  -->
            <div class="modal fade" id="addNewLoan" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pb-5 px-sm-3 mx-50">
                            <h1 class="address-title text-center mb-1">Apply for Loan or Advance Salary</h1>
                            <p class="address-subtitle text-center mb-2 pb-75">Input Details</p>
                            <form style="text-align:left;" class="row gy-1 gx-2">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" disabled :value="emp_name" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label">Date Of Joining</label>
                                    <input type="text" class="form-control" disabled v-model="doj" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label">Salary</label>
                                    <input type="text" class="form-control" disabled
                                        :value='Number(salary) + Number(stipend)' />
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label">Deductions</label>
                                    <input type="text" class="form-control" disabled
                                        :value='Number(tax) + Number(installment)' />
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Maximum Limit</label>
                                    <input type="text" class="form-control" disabled v-model="max_advance" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label">Select Type</label>
                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                    <multiselect style="margin-right: 10px;" @input="count_max_limit()" v-model="type1"
                                        :show-labels="false" placeholder="Select" :options="options4"></multiselect>
                                    <span style="color: #DB4437; font-size: 11px;" v-if="type1 == ''">{{ type_error1
                                        }}</span>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label">Amount<span
                                            style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="number" class="form-control" v-model="amount" placeholder="Amount" />
                                    <span style="color: #DB4437; font-size: 11px;" v-if="amount == ''">{{ amount_error
                                        }}</span>
                                    <span style="color: #DB4437; font-size: 11px;" v-if="amount > max_advance">Ammount
                                        is too much</span>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label">Number of installments</label>
                                    <span v-if="type1 == 'Loan'" style="color: #DB4437; font-size: 11px;">*</span>
                                    <select v-if="type1 == 'Loan' && amount != ''" v-model="no_of_inst"
                                        class="form-select">
                                        <option value="0" selected>Select</option>
                                        <option value="1" selected>1</option>
                                        <option value="2" selected>2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4" selected>4</option>
                                        <option value="5" selected>5</option>
                                        <option value="6" selected>6</option>
                                        <option value="7" selected>7</option>
                                        <option value="8" selected>8</option>
                                        <option value="9" selected>9</option>
                                        <option value="10" selected>10</option>
                                        <!--<option :value="index" v-for="index in Number(config_ins)">{{index}}</option>-->
                                    </select>
                                    <select v-else disabled class="select2 form-select"
                                        title="Advance installments could not be changed">
                                        <option>1</option>
                                    </select>
                                    <span style="color: #DB4437; font-size: 11px;"
                                        v-if="no_of_inst == '0' && type1 == 'Loan'">{{ installments_error }}</span>
                                </div>
                                <div class="col-12 col-md-12">
                                    <label class="form-label" v-if="type1 == 'Loan'">Reason of Loan</label>
                                    <label class="form-label" v-else>Reason of Advance</label>
                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                    <label v-if="type1 == 'Loan' && no_of_inst > 0 && amount > 0"
                                        style="float:right;">Each
                                        installments will be of Rs.
                                        <label>{{ Math.round(this.amount / this.no_of_inst) }}</label></label>
                                    <input type="text" class="form-control" v-model="reason"
                                        placeholder="Type reason here" />
                                    <span style="color: #DB4437; font-size: 11px;" v-if="reason == ''">{{ reason_error
                                        }}</span>
                                </div>
                                <div class="col-12 text-center">
                                    <button
                                        v-if="amount == '' || amount > max_advance || type1 == '' || reason == '' || (type1 == 'Loan' && no_of_inst == '0') || (type1 == 'Loan' && (this.no_of_inst < ((amount / salary) + 1)))"
                                        :disabled="disabled" @click="delay1()" type="submit" class="btn btn-danger">
                                        Apply
                                    </button>
                                    <button v-else :disabled="disabled" @click="delay1()" type="submit"
                                        class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Apply
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="markAttendance" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pb-5 px-sm-3 mx-50">
                            <h1 class="address-title text-center mb-1" id="addNewAddressTitle">Mark Mannual
                                Attendance</h1>
                            <form id="addNewAddressForm" style="text-align:left;" class="row gy-1 gx-2"
                                onsubmit="return false">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" disabled :value="emp_name" />
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" disabled v-model="date" />
                                </div>
                                <div hidden class="col-12 col-md-3">
                                    <label class="form-label">Check in time</label><span
                                        style="color: #DB4437; font-size: 11px;">*</span>
                                    <input type="time" class="form-control" v-model="check_in" />
                                    <span style="color: #DB4437; font-size: 11px;" v-if="check_in == ''">{{ e_check_in
                                        }}</span>
                                </div>
                                <div hidden class="col-12 col-md-3">
                                    <label class="form-label">Check out time</label>
                                    <input type="time" class="form-control" v-model="check_out" />
                                </div>
                                <div hidden class="col-12 col-md-6">
                                    <label class="form-label">Today's roaster timing</label>
                                    <input type="text" class="form-control" disabled v-model="show_roaster" />
                                </div>
                                <div class="col-12 text-center">
                                    <button :disabled="disabled1" @click="delay2()" type="submit"
                                        class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">Mark
                                        Attendance
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <v-tour name="myTour" :steps="steps"></v-tour>
        </div>
        <div class="modal fade" id="timeAdj" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-3 mx-50">
                        <h1 class="address-title text-center mb-1">Apply Time Adjustment</h1>
                        <form style="text-align:left;" class="row gy-1 gx-2" onsubmit="return false">
                            <div class="row">
                                <label class=" form-label" style="margin-left: 2%; font-size: 15px;">
                                    Request For:
                                </label>
                                <div class="col-md-2" style="margin-left: 4%;">
                                    <input class="form-check-input" type="radio" checked v-model="check1"
                                        name="inlineRadioOptions" @click="setself()" id="inlineRadio1" value="Self">
                                    <label class="form-check-label" for="inlineRadio1">Self</label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-check-input" type="radio" v-model="check1"
                                        name="inlineRadioOptions" id="inlineRadio1" value="Team">
                                    <label class="form-check-label" for="inlineRadio1">Team Meamber</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6" v-if="check1 == 'Team'">
                                <label class="form-label">Select Team Member</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <select @click="Set_TM_id(Team)" v-model="Team" class="form-select mb-md-0 mb-2">
                                    <option value="" selected>Select team member</option>
                                    <option v-for="team1 in teammembers" :value='team1.EmployeeID'>
                                        {{ team1.EmployeeCode }} - {{ team1.Name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6" v-else>
                                <label class="form-label">Employee code - Name</label>
                                <input type="text" class="form-control" disabled :value="empcode + ' - ' + Empname" />
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" disabled v-model="tm_id" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Attandance Date</label>
                                <input disabled type="date" class="form-control" v-model="att_date" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.att_date == ''">{{
                                    att_date_error }}</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Adjust For</label>
                                <select v-model="AdjustFor" value="AdjustFor" class="form-control">
                                    <option value="">Select</option>
                                    <option value="CheckIn">Check In Time</option>
                                    <option value="CheckOut">Check Out Time</option>
                                </select>
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.AdjustFor == ''">{{
                                    AdjustFor_error }}</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Adjust Hours:</label>
                                <input type="number" class="form-control" v-model="Hours" placeholder="Enter hours" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.Hours == ''">{{ Hours_error
                                    }}</span>
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.Hours > 23">Houres cannot more
                                    then 23</span>
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.Hours < 0">Houres cannot less
                                    then 0</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Adjust Minutes:</label>
                                <input type="number" class="form-control" v-model="Minutes"
                                    placeholder="Enter minuts" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.Minutes == ''">{{
                                    Minutes_error
                                }}</span>
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.Minutes > 59">Minutes cannot
                                    more then 59</span>
                                <span style="color: #DB4437; font-size: 11px;" v-if="this.Minutes < 0">Minutes cannot
                                    less
                                    then 0</span>
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label">Reason:</label>
                                <input type="text" class="form-control" v-model="Reason"
                                    placeholder="Enter reason here" />
                                <span style="color: #DB4437; font-size: 11px;" v-if="Reason == ''">{{ Reason_error
                                    }}</span>
                            </div>
                            <div class="col-12 text-center">
                                <button :disabled="disabled3" @click="delay3()" type="submit"
                                    class="btn btn-primary me-1 mt-2"
                                    v-if="att_date == '' || AdjustFor == '' || Hours == '' || Minutes == '' || parseInt(Hours) > 24 || parseInt(Minutes) > 59 || parseInt(Hours) < 0 || parseInt(Minutes) < 0 || Reason == ''"
                                    aria-label="Close">Apply
                                </button>
                                <button :disabled="disabled3" @click="delay3()" type="submit"
                                    class="btn btn-primary me-1 mt-2" v-else data-bs-dismiss="modal"
                                    aria-label="Close">Apply
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
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
import VueApexCharts from 'vue-apexcharts';
import { color } from 'chart.js/helpers';
import axios from 'axios';
import Multiselect from 'vue-multiselect';
import moment from 'moment';
import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

Vue.filter('moment-ago', function (value, value1) {
    if (value && value1) {
        var startTime = moment(value1 + ':00', 'HH:mm:ss a');
        var endTime = moment(value.split("."), 'HH:mm:ss a');

        // duration in hours
        var hours = (Math.floor(Math.abs(moment.duration(endTime.diff(startTime)).asHours()))).toString().padStart(2, '0');
        // duration in minutes
        var minutes = (Math.floor(Math.abs(moment.duration(endTime.diff(startTime)).asMinutes())) % 60).toString().padStart(2, '0');
        return (hours + ':' + minutes);
    } else {
        return "-";
    }
});
Vue.filter('moment-ago1', function (value, value1) {
    if (value && value1) {
        var startTime = moment(value1 + ':00', 'HH:mm:ss a');
        var endTime = moment(value.split("."), 'HH:mm:ss a');

        // duration in hours
        var hours = (Math.floor(Math.abs(moment.duration(endTime.diff(startTime)).asHours()))).toString().padStart(2, '0');
        // duration in minutes
        var minutes = (Math.floor(Math.abs(moment.duration(endTime.diff(startTime)).asMinutes())) % 60).toString().padStart(2, '0');
        return (hours + ':' + minutes);
    } else {
        return "-";
    }
});
Vue.filter('formatTime', function (value) {
    if (value) {
        const parts = value?.split(":");
        var hour = parts[0]?.toString().padStart(2, '0');
        var minuts = parts[1]?.toString().padStart(2, '0');
        var seconds1 = parts[2]?.split(".");
        var seconds = seconds1[0]?.toString().padStart(2, '0');
        return hour + ":" + minuts;
    } else {
        return "";
    }
});
export default {
    name: 'my-tour',
    components: {
        apexchart: VueApexCharts,
    },
    data: function () {
        return {
            FirstDayOfMonth: '',
            dateRange: {
                endDate: new Date().toISOString().substr(0, 10),//null
            },

            moment: moment,
            avg_times: {},
            emp_name: '',

            tax: '',
            installment: '',
            stipend: '',

            activeClass: 'table-secondary',
            primaryClass: 'table-primary',
            isActive: true,
            adj_date: '',

            userType: '',
            empid: '',
            Empname: '',
            empcode: '',
            check1_error: '',
            tm_id: '',
            check1: 'Self',
            att_date: new Date().toISOString().substr(0, 10),
            att_date_error: '',
            AdjustFor: '',
            AdjustFor_error: '',
            Hours: '',
            Hours_error: '',
            Minutes: '',
            Minutes_error: '',
            Reason: '',
            Team: '',
            disabled3: false,
            timeout3: null,
            teammembers: {},
            date: new Date().toJSON().slice(0, 10),
            check_in: '', //new Date().toLocaleTimeString().slice(0, 5),
            check_out: '',
            e_check_in: '',
            roaster: {},
            show_roaster: '',
            canmarkAttendance: '',

            config_loan: 0,
            config_ins: 0,
            configurations: {},
            lvtype: '',
            Reason_error: '',

            myData: null,
            steps: [{
                target: '#v-step-0', // We're using document.querySelector() under the hood
                header: {
                    title: 'Get Started',
                },
                content: `Discover <strong>Application Tour</strong>!`,
                params: {
                    placement: 'top'
                }
            },
            {
                target: '.v-step-1',
                content: '<strong>Left MenuBar</strong><br> You Can Visit Complete Menu Bar<br> And Explore Application'
            },
            {
                target: '[data-v-step="2"]',
                content: '<strong>Top LeftNavbar</strong><br> Explore Live Chat,Task Manager <br>and Search Bar from here.',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="3"]',
                content: '<strong>Top Right Navbar</strong><br>Explore Profile Setting From Top <br> Right Navbar. If you need any help,Please Visit FAQ(s) From Here.',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="4"]',
                content: '<strong>Current Session Attendance</strong><br>Check your Monthly Attendance Summary ',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="5"]',
                content: 'Please Visit <strong>Team Leaves </strong> For Leaves Approval Or Apply Leave Of Your Reporting Employees',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="6"]',
                content: 'Explore <strong>Team Attendance</strong> For Update And View Attendance Of Your Team',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="7"]',
                content: '<strong>For Personal Leave</strong>, Please Click on Apply Now Button',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="8"]',
                content: 'If You Need To Visit Your Profile.Please on View Profile Button',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="9"]',
                content: 'You Can Check Your Annual Leaves by Clicking on View Detail Link .',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="10"]',
                content: 'You Can Check Your Sick Leaves by Clicking on View Detail Link .',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="11"]',
                content: 'You Can Check Your Casual Leaves by Clicking on View Detail Link .',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="12"]',
                content: '<strong>Current Session Attendance</strong><br>Check your Date Wise Monthly Attendance Detail',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            },
            {
                target: '[data-v-step="13"]',
                content: 'Developed By <strong> SA Systems</strong> <br>Any Kind Of Support.Please Visit our Website Or Contact Us',
                params: {
                    placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                }
            }

            ],
            fetchempcode: '',
            days: 'One Day',
            attendance: {},
            ct_att: {},
            this_m_lvs: {},
            leaves_dtl: {},
            leavesblnc: {},

            type: '',
            isLvEmpty: 'Empty',
            d_from: '',
            d_to: '',
            reason: '',
            type_error: '',
            d_from_error: '',
            reason_error: '',
            leavetypes: {},
            value: 1,
            max: 14,
            max_cas: '',
            max_sick: '',
            max_annual: '',
            fetchtour: '',
            disabled: false,
            timeout: null,
            disabled1: false,
            timeout1: null,
            no_of_inst: 0,
            name: '',
            max_advance: '0',
            salary: '',
            emp_id1: '',
            doj: '',
            type1: 'Select',
            options4: ["Select", "Advance", "Loan"],
            amount: '',
            amount_error: '',
            type_error1: '',
            installments_error: '',
            years: '0',

            // chart data

            // annual_total: this.leaves_dtl.ttl_annual,
            // annual_rem: this.leaves_dtl.rem_annual,
            // sick_total: this.leaves_dtl.ttl_sick,
            // sick_rem: this.leaves_dtl.rem_sick,
            // casual_total: this.leaves_dtl.ttl_casual,
            // casual_rem: this.leaves_dtl.rem_casual,
            // other_total: this.leaves_dtl.ttl_other,
            // other_used: this.leaves_dtl.other_used,

            annual_total: 12,
            annual_rem: 4,
            sick_total: 13,
            sick_rem: 8,
            casual_total: 19,
            casual_rem: 10,
            other_total: 16,
            other_used: 7,
            series1: [
                {
                },
                {
                },
                {
                },
                {
                }
            ],


        }
    },
    computed: {

        // Annual Leave Chart
        chartOptions1() {
            return {
                chart: {
                    height: 450,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '50%',
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                fontSize: '14px',
                                color: '#333',
                                fontWeight: 'bold',
                                offsetY: 10
                            },
                            value: {
                                show: false
                            }
                        },
                        stroke: {
                            lineCap: 'butt'
                        }
                    }
                },

                labels: [`${this.annual_rem}/${this.annual_total}`]
            };
        },
        chartOptions2() {
            return {
                chart: {
                    height: 450,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '50%',
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                fontSize: '14px',
                                color: '#333',
                                fontWeight: 'bold',
                                offsetY: 10
                            },
                            value: {
                                show: false
                            }
                        }
                    }
                },
                labels: [`${this.sick_rem}/${this.sick_total}`],
                colors: ['#dc3545']
            };
        },
        chartOptions3() {
            return {
                chart: {
                    height: 450,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '50%',
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                fontSize: '14px',
                                color: '#333',
                                fontWeight: 'bold',
                                offsetY: 10
                            },
                            value: {
                                show: false
                            }
                        }
                    }
                },
                labels: [`${this.casual_rem}/${this.casual_total}`],
                colors: ['#ff9800']
            };
        },
        chartOptions4() {
            return {
                chart: {
                    height: 450,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '50%',
                        },
                        dataLabels: {
                            name: {
                                show: true,
                                fontSize: '14px',
                                color: '#333',
                                fontWeight: 'bold',
                                offsetY: 10
                            },
                            value: {
                                show: false
                            }
                        }
                    }
                },
                labels: [`${this.other_used}/${this.other_total}`],
                colors: ['#28a745']

            };
        },
        // Annual Leave Chart END
        // Define a computed property to handle the attendance status
        getAttendanceStatus() {
            return (status) => {
                switch (status) {
                    case 'H':
                        return 'Holiday';
                    case 'LE':
                        return 'Leave';
                    case 'A':
                        return 'Absent';
                    default:
                        return '-';
                }
            };
        }
    },
    watch: {
        annual_total() {
            this.updateSeries();
        },
        annual_rem() {
            this.updateSeries();
        },
        sick_total() {
            this.updateSeries();
        },
        sick_rem() {
            this.updateSeries();
        },
        casual_total() {
            this.updateSeries();
        },
        casual_rem() {
            this.updateSeries();
        },
        other_total() {
            this.updateSeries();
        },
        other_used() {
            this.updateSeries();
        }
    },

    components: {
        Multiselect,
        DateRangePicker,
        moment
    },

    methods: {
        // updating leaves
        updateSeries() {
            this.series1[0] = [Math.round((this.annual_rem / this.annual_total) * 100)];
            this.series1[1] = [Math.round((this.sick_rem / this.sick_total) * 100)];
            this.series1[2] = [Math.round((this.casual_rem / this.casual_total) * 100)];
            this.series1[3] = [Math.round((this.other_used / this.other_total) * 100)];
        },
        get_attendance_count() {
            const startDate = new Date(this.dateRange.startDate);
            const formattedStartDate = `${startDate.getFullYear()}-${(startDate.getMonth() + 1).toString().padStart(2, '0')}-${startDate.getDate().toString().padStart(2, '0')}`;

            const endDate = new Date(this.dateRange.endDate);
            const formattedEndDate = `${endDate.getFullYear()}-${(endDate.getMonth() + 1).toString().padStart(2, '0')}-${endDate.getDate().toString().padStart(2, '0')}`;

            axios.get('Attendance_count/' + formattedStartDate + '/' + formattedEndDate) //Count current month attendance details
                .then(data => this.ct_att = data.data)
                .catch(error => {
                });
        },
        calculateTimeDifference(time1, time2) {
            const format = 'HH:mm:ss.SSSSSSS';
            const diffInMilliseconds = moment(time2, format).diff(moment(time1, format));
            const duration = moment.duration(diffInMilliseconds);
            const hours = Math.floor(duration.asHours());
            const minutes = duration.minutes();
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        },
        get_date(date) {
            this.att_date = date;
        },
        leaves_details(lvtype1) {
            axios.get('m_lv_dtl_rt/' + lvtype1) //Get leaves details
                .then(data => {
                    this.this_m_lvs = data.data;
                    this.lvtype = data.data[0].Leavetype;
                })
                .catch(error => {
                });
        },
        delay1() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.apply_loan()
        },
        delay2() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.mark_attendance();
        },
        not_Att_access() {
            this.$toastr.e('You do not have access to mark attendance!', "Caution!");
        },
        mark_attendance() {
            axios.post('./mark_attendance', {
                //check_in: this.check_in,
                //check_out: this.check_out,
                emp_id: this.name,
            })
                .then(data => {
                    if (data.data == 'Done') {
                        this.$toastr.s('Your attendance has been marked!', "Success!");
                    } else {
                        this.$toastr.e(data.data, "Error!");
                    }
                })
        },
        apply_loan() {
            if (this.amount == '' || this.amount > this.max_advance || this.type1 == '' || this.reason == '' || (this.type1 == 'Loan' && this.no_of_inst == '0') || (this.type1 == 'Loan' && (this.no_of_inst < ((this.amount / this.salary) + 1)))) {
                if (this.amount == '') {
                    this.amount_error = "Enter amount";
                } else {
                    this.amount_error = "";
                }
                if (this.type1 == '') {
                    this.type_error1 = "Select type";
                } else {
                    this.type_error1 = "";
                }
                if (this.reason == '') {
                    this.reason_error = "Type reason";
                } else {
                    this.reason_error = "";
                }
                if (this.no_of_inst == '0') {
                    this.installments_error = "Select number of installments";
                } else {
                    this.installments_error = "";
                }
                this.$toastr.e("Loan not added.", "Error!");

            } else {
                //Add loan
                axios.post('./loan', {
                    type1: this.type1,
                    amount: this.amount,
                    reason: this.reason,
                    installments: this.no_of_inst,
                    installmentPrice: this.installmentPrice,
                    emp_id1: this.name,
                })
                    .then(data => {
                        if (data.data == 'Loan added Successfully!') {
                            this.$toastr.s("Loan added successfully!", "Congratulations!");

                            this.name = '';
                            this.salary = '';
                            this.max_advance = '0';
                            this.doj = '';
                            this.emp_id1 = '';
                            this.type = "Advance";
                            this.amount = "";
                            this.reason = "";
                            this.no_of_inst = "0";
                            this.installmentPrice = "";

                            axios.get('fetch_all_loans')
                                .then(data => this.loans = data.data)
                                .catch(error => {
                                });

                            axios.get('fetch_filtered_loans/' + this.check)
                                .then(data => this.loans = data.data)
                                .catch(error => {
                                });
                        } else {
                            this.$toastr.e("You are not elligible for loan & advance.", "Error!");
                        }
                    })
            }
        },
        count_max_limit() {
            if (this.type1 == 'Advance') {
                this.max_advance = Number(this.salary) - Number(this.tax) - Number(this.installment) + Number(this.stipend);
            } else {
                this.max_advance = this.years * (Number(this.salary) + Number(this.stipend));
            }
        },
        fetch_emp_detail() {
            axios.get('fetch_employee_amount/' + 0)
                .then(data => {
                    this.tax = data.data.data.tax;
                    this.installment = data.data.data.installment;
                    this.stipend = data.data.data.stipend;
                    this.years = data.data.data.years;
                })
                .catch(error => {
                });

            axios.get('fetch_employee_dtl/' + 0)
                .then(responce => {
                    this.name = responce.data[0].EmployeeID;
                    this.emp_name = responce.data[0].Name;
                    this.salary = responce.data[0].Salary;
                    this.doj = responce.data[0].JoiningDate;
                    this.emp_id1 = responce.data[0].EmployeeID;
                    this.canmarkAttendance = responce.data[0].AllowAttendance;
                })
                .catch(error => {
                });
            this.count_max_limit();
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.leave_request()
        },
        leave_request() {
            if (this.type == '' || this.d_from == '' || this.reason == '' || (this.days == 'Multiple Days' && this.d_to == '')) {
                if (this.type == '') {
                    this.type_error = 'Selest leave type';
                } else {
                    this.type_error = '';
                }
                if (this.d_from == '') {
                    this.d_from_error = 'Select date';
                } else {
                    this.d_from_error = '';
                }
                if (this.reason == '') {
                    this.reason_error = 'Type reason';
                } else {
                    this.reason_error = '';
                }
                this.$toastr.e("Please fill required fields", "Error!")
            } else {
                if (this.days == 'One Day') {
                    this.d_to = null;
                } else {
                    this.d_to = this.d_to;
                }
                //axios.post('./leave_request_rt', {
                axios.post('./submit_leave', {
                    emp_id: 0,
                    days: this.days,
                    emp_date_from: this.d_from,
                    emp_date_to: this.d_to,
                    emp_reason: this.reason,
                    emp_leave: this.type,
                })
                    .then(data => {
                        if (data.data == 'Leave applied') {
                            this.$toastr.s("Leave Applied successfully!", "Congratulations!");
                            this.type = '';
                            this.d_from = '';
                            this.d_to = '';
                            this.reason = '';
                            this.days = '';
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                    })
            }
        },
        Set_TM_id(id) {
            this.tm_id = id;
        },
        setself() {
            this.tm_id = this.name;
        },
        submit_adjustment() {
            if (this.AdjustFor == '' || this.Hours == '' || this.Minutes == '' || parseInt(this.Hours) > 24 || parseInt(this.Minutes) > 59 || this.Reason == '' || this.att_date == '') {
                if (this.att_date == '') {
                    this.att_date_error = 'Select Date ';
                } else {
                    this.att_date_error = '';
                }
                if (this.AdjustFor == '') {
                    this.AdjustFor_error = "Select Adjust For";
                } else {
                    this.AdjustFor_error = '';
                }
                if (this.Hours == '') {
                    this.Hours_error = "Enter Hours";
                } else {
                    this.Hours_error = '';
                }
                if (this.Minutes == '') {
                    this.Minutes_error = "Enter Minutes";
                } else {
                    this.Minutes_error = '';
                }
                if (this.Reason == '') {
                    this.Reason_error = "Enter Reason";
                } else {
                    this.Reason_error = '';
                }
                this.$toastr.e("Please fill require fields properly!", "Error!");
            } else {
                axios.post('./time_adjustment', {
                    id: this.tm_id,
                    att_date: this.att_date,
                    adjustmentfor: this.AdjustFor,
                    hours: this.Hours,
                    minutes: this.Minutes,
                    Reason: this.Reason,
                })
                    .then(data => {
                        if (data.data == 'time adjustment submitted') {
                            this.$toastr.s('Time adjustment has been submitted!', "Congratulations!");
                            this.tm_id = '';
                            this.att_date = '';
                            this.Reason = '';
                            this.Minutes = '';
                            this.Hours = '';
                            this.AdjustFor = '';
                            this.Reason = '';
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                    })
            }
        },
        dayname(dateS) {
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var d = new Date(dateS);
            return days[d.getDay()];
        },
        delay3() {
            this.disabled3 = true
            this.timeout3 = setTimeout(() => {
                this.disabled3 = false
            }, 5000)
            this.submit_adjustment();
        },
        formatTime(time) {
            return time?.substring(0, 8); // Output: "12:21:56"
        },
    },
    mounted() {
        this.updateSeries();
        this.fetch_emp_detail();

        const currentDate = new Date();
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        this.dateRange.startDate = `${firstDayOfMonth.getFullYear()}-${(firstDayOfMonth.getMonth() + 1).toString().padStart(2, '0')}-01`;

        axios.get('avg_attendance_times/' + 0)
            .then(data => {
                this.avg_times = data.data[0];
                // this.formatTime();
            })
            .catch(error => {
            });

        axios.get('view_hr_configuration')
            .then(data => {
                this.configurations = data.data;
                this.config_ins = data.data[0].MaxInstallment;
                this.config_loan = data.data[0].MaxLoan;
            })
            .catch(error => {
            });

        setTimeout(() => {
            this.myData = 'Example Data';
        }, 500);

        axios.get('fetch_tour_status')
            .then(data => {
                if (data.data != '1') {
                    this.$tours['myTour'].start();
                }
            })

        axios.get('fetch_emp_code')
            .then(data => this.fetchempcode = data.data)

        axios.get('overall_leaves')
            .then(response => {
                this.leavetypes = response.data.data;
            })
            .catch(error => {
            });

        axios.get('selected_emp_leaves_blnc/' + 0)
            .then(data => {
                this.leavesblnc = data.data.data;
                if (this.leavesblnc == '') {
                    this.isLvEmpty = "Empty";
                } else {
                    this.isLvEmpty = "Not empty";
                }
            })
            .catch(error => {
            });

        axios.get('att_time/' + 0)
            .then(data => {
                this.check_in = data.data[0]?.OpeningTime;
                this.check_out = data.data[0]?.ClosingTime;
                this.show_roaster = this.check_in + ' to ' + this.check_out
            })
            .catch(error => {
            });

        axios.get('this_user_attendence/' + 0) //Get attendance of logged in employee
            .then(response => this.attendance = response.data.data)
            .catch(error => {
            });

        axios.get('leaves_dtl') //Count leaves detail
            .then(data => this.leaves_dtl = data.data)
            .catch(error => {
            });

        axios.get('update_tour_status')
            .then(data => {

            })
        axios.get('ind_team_att')
            .then(response => this.teammembers = response.data)
            .catch(error => {
            });

        axios.get('fetch_emp_id')
            .then(response => {
                this.empid = response.data[0].EmployeeID;
                this.Empname = response.data[0].Name
                this.empcode = response.data[0].EmployeeCode;
                this.tm_id = this.empid;
            })
            .catch(error => {
            });



        this.get_attendance_count();
    }
}

</script>
<style>
#v-step-46f34eda {
    transform: none !important;
}

#v-step-3b771d9f>.v-step__arrow {
    transform: translate(-5px, 40px) !important;
}

@media (max-width: 576px) {
    .full_div {
        width: 100% !important;
    }
}

.sticky-th-center {
    z-index: 1;
    position: sticky;
    top: 94px;
    text-align: center;
    vertical-align: middle !important;
}

.sticky-th-left {
    z-index: 1;
    position: sticky;
    top: 94px;
    text-align: left;
    vertical-align: middle !important;
}

.td-center {
    text-align: center;
    vertical-align: middle !important;
}

.td-left {
    text-align: left;
    vertical-align: middle !important;
}

.td-right {
    text-align: right;
    vertical-align: middle !important;
}
</style>
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
