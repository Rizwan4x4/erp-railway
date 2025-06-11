<template>

    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">
                                HR Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="row match-height">
                        <!-- Birthday Banner -->
                        <div class="container mt-2">
                            <div class="row justify-content-center align-items-center">

                                <!-- Check birthdays -->
                                <div v-if="birthdaysToday && birthdaysToday.length > 0">
                                    <div v-for="emp in birthdaysToday" :key="emp.EmployeeID"
                                        class="col-xl-12 col-lg-10 col-md-12 mb-2">
                                        <div class="card bg-image p-4 border-0">
                                            <div
                                                class="d-flex  align-items-center  justify-content-between">

                                                <!-- Left Side: Profile Info -->
                                                <div
                                                    class="d-flex align-items-center justify-content-end gap-2 col-md-4 me-3">
                                                    <span class="avatar">
                                                        <img :src="emp.photo || images.profileImage" alt="avatar"
                                                            height="40" width="40" class="rounded-circle">
                                                        <span title="Online" class="avatar-status-online"></span>
                                                    </span>
                                                    <div class="user-nav d-flex flex-column">
                                                        <span class="user-name fw-bold">{{ emp.Name }}</span>
                                                        <span class="user-status text-muted">{{ emp.Designation ||
                                                            'Employee' }}</span>
                                                    </div>
                                                </div>

                                                <!-- Center: Birthday Message -->
                                                <div class="col-md-4 text-center px-4">
                                                    <h6 class="mb-0">🎂 Happy Birthday Today!</h6>
                                                </div>

                                                <!-- Right Side: Button -->
                                                <div class="col-md-4 justify-content-start ms-3">
                                                    <button class="btn birth-btn rounded-3 w-md-auto">Wish {{ emp.Gender
                                                        === 'Male' ? 'Him' : 'Her' }}</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- If no birthday -->
                                <div v-else class="text-center text-muted py-4">
                                    <h5>🎉 Today no birthday</h5>
                                </div>

                            </div>
                        </div>





                        <!-- Medal Card  -->
                        <!-- <div class="col-xl-12 col-md-6 col-12 col-xs-12">
                            <div class="card card-congratulation-medal">
                                <div class="card-body">
                                    <h5>Welcome Back 🎉</h5>
                                    <p class="card-text font-small-3">View your overall report </p>
                                    <h3 class="mb-75 mt-2 pt-50">
                                    </h3>
                                    <router-link to="/hr/employee_dashboard"
                                                 class="btn btn-primary waves-effect waves-float waves-light">View
                                        Profile
                                    </router-link>
                                    <img src="public/app-assets/images/illustration/badge.svg"
                                         class="congratulation-medal" alt="Medal Pic">
                                </div>
                            </div>
                        </div> -->
                        <!--/ Medal Card
                         Statistics Card -->
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="card card-statistics rounded-4 shadow-sm border-0">
                                <div class="card-header top-radius">
                                    <h4 class="p-1 pt-0 pb-0 fw-semibold">Today's Employee Attendance</h4>

                                </div>
                                <div class="card-body statistics-body pb-2 ">
                                    <div class="row  justify-content-around g-2">
                                        <div
                                            class="col-xl-2 col-sm-5 col-12 mb-xl-0 bg-custom  shadow-sm text-muted rounded-4 p-4 mb-2 ">
                                            <div class="d-flex flex-row justify-content-center">
                                                <div class="my-auto ">
                                                    <h4 class="fw-bolder mb-0 text-center">{{ att_daily_count.total }}
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Total Employees</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-xl-2 col-sm-5 col-12 mb-2 mb-xl-0 bg-custom shadow-sm text-success rounded-4 p-4 mb-2">
                                            <div class="d-flex flex-row justify-content-center">
                                                <!-- <div class="avatar bg-custom me-2">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-check"></i>
                                                    </div>
                                                </div> -->
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 text-center">{{ att_daily_count.present }}
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Present</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-xl-2 col-sm-5 col-12 mb-2 mb-xl-0 bg-custom shadow-sm text-primary rounded-4 p-4 mb-2">
                                            <div class="d-flex flex-row justify-content-center">
                                                <!-- <div class="avatar bg-light-success me-2">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-litecoin-sign"></i>
                                                    </div>
                                                </div> -->
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 text-center">{{ att_daily_count.late }}
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Late</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="col-xl-2 col-sm-5 col-12 mb-2 mb-sm-0  bg-custom shadow-sm text-danger rounded-4 p-4 mb-2">
                                            <div class="d-flex flex-row justify-content-center">
                                                <!-- <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </div>
                                                </div> -->
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 text-center">{{ att_daily_count.absent }}
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Absent</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-xl-2 col-sm-5 col-12 mb-2 mb-sm-0 bg-custom shadow-sm text-warning rounded-4 p-4 mb-2">
                                            <div class="d-flex flex-row justify-content-center">
                                                <!-- <div class="avatar bg-light-danger me-2">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </div>
                                                </div> -->
                                                <div class="my-auto">
                                                    <h4 class="fw-bolder mb-0 text-center">{{ att_daily_count.absent }}
                                                    </h4>
                                                    <p class="card-text font-small-3 mb-0">Leave</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    </div>
                    <div class="row match-height">

                        <!-- employee composition -->
                        <div class="col-xl-4 col-md-4 col-12">
                            <div class="card card-developer-meetup rounded-4 shadow-sm border-0">
                                <h4 class="p-4 pb-0 fw-semibold">Employee Composition</h4>
                                <div>
                                    <apexchart type="donut" height="220" :options="chartOptions9" :series="series9">
                                    </apexchart>
                                </div>
                                <p class="text-center">
                                    <!-- <strong>{{Department_data.reduce((sum, dept) => sum + (dept.TotalEmp || 0), 0)}}</strong> -->
                                    <strong>{{ emp_count.all }}</strong> Total Employees
                                </p>
                            </div>
                        </div>
                        <!--/ employee composition -->
                        <!-- Employee Details -->
                        <div class="col-xl-8 col-md-8 col-12">
                            <div class="card card-developer-meetup rounded-4 border-0">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 p-4">
                                        <h4 class=" fw-semibold">Employee Details</h4>
                                        <div class="p-4">
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-square fs-5 text-primary "></i>
                                                    <span class="fw-bold ms-75">Total Employees</span>
                                                </div>
                                                <span>{{ (Math.floor(this.count_users.data.all_users)).toLocaleString()
                                                    }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-square fs-5 text-success"></i>
                                                    <span class="fw-bold ms-75">Registered</span>
                                                </div>
                                                <span>{{
                                                    (Math.floor(this.count_users.data.active_users)).toLocaleString()
                                                }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-square fs-5 text-info"></i>
                                                    <span class="fw-bold ms-75">Contractual</span>
                                                </div>
                                                <span>{{
                                                    (Math.floor(this.count_users.data.contractual_users)).toLocaleString()
                                                }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-square fs-5 text-danger"></i>
                                                    <span class="fw-bold ms-75">Terminated</span>
                                                </div>
                                                <span>{{ this.count_users.data.terminated_users }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-square fs-5 text-warning"></i>
                                                    <span class="fw-bold ms-75">Resigned</span>
                                                </div>
                                                <span>{{ this.count_users.data.inactive_users }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-solid fa-square fs-5 text-secondary"></i>
                                                    <span class="fw-bold ms-75">Suspended</span>
                                                </div>
                                                <span>{{ this.count_users.data.suspended_users }}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-sm-12 p-3 ">
                                        <div>
                                            <apexchart type="donut" height="280" :options="chartOptions10"
                                                :series="series10">
                                            </apexchart>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Employee Details -->

                        <!-- Department-wise Today’s attendance -->

                        <div class="col-lg-12 col-12  rounded-top-4">
                            <div class="card-header border-bottom top-radius">
                                <h4 class=" fw-semibold">Department-wise Today’s attendance</h4>
                            </div>
                            <div class="card card-company-table rounded-bottom-4 border-0">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table  text-center">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="border-e" style="width:20%">Department</th>
                                                    <th>Employees</th>
                                                    <th class="text-success">Present</th>
                                                    <th class="text-danger">Absent</th>
                                                    <th class="text-primary">Late</th>
                                                    <th class=" text-warning">Leave </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="card-body" style="height: 290px; overflow-y: scroll;">
                                            <table class="table  text-center">
                                                <tbody>
                                                    <tr v-for="attendance1 in attendance">
                                                        <td class="border-end-dashed" style="width:18%">
                                                            <div class="d-flex align-items-center">
                                                                <!-- <div class="avatar bg-custom me-1">
                                                                    <div class="avatar-content">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="14" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-monitor font-medium-3">
                                                                            <rect x="2" y="3" width="20" height="14"
                                                                                rx="2" ry="2"></rect>
                                                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                                                            <line x1="12" y1="17" x2="12" y2="21">
                                                                            </line>
                                                                        </svg>
                                                                    </div>
                                                                </div> -->
                                                                <span>{{ attendance1.Department }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap border-end-dashed" style="width: 21%;">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">{{
                                                                    attendance1.TotalEmployee }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="border-end-dashed" style="width: 17%;">{{
                                                            attendance1.Present }}</td>
                                                        <td class="border-end-dashed" style="width: 16%;">{{
                                                            attendance1.Absent }}</td>
                                                        <!-- Here need to change late the absent nessessry -->
                                                        <td class="border-end-dashed" style="width: 10%;">{{
                                                            attendance1.Absent }}</td>
                                                        <td class="border-end-dashed" style="width: 10%;">{{
                                                            attendance1.Leave }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Department-wise Today’s attendance -->

                        <!-- Medal Card -->
                        <!-- <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-developer-meetup rounded-4 shadow-sm border-0">
                                <div class="meetup-img-wrapper rounded-top text-center">
                                    <img src="public/app-assets/images/illustration/email.svg" alt="Meeting Pic"
                                        height="170">
                                </div>
                                <div class="card-body" style="height:200px; overflow-y:scroll;">
                                    <div class="meetup-header d-flex align-items-center">
                                        <div class="meetup-day">
                                            <h6 class="mb-0">THU</h6>
                                            <h3 class="mb-0">24</h3>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="card-title mb-25">HR Events</h4>
                                            <p class="card-text mb-0">View your scheduled events</p>
                                        </div>
                                    </div>
                                    <div class="mt-0" style="margin-bottom:10px; cursor:pointer;"
                                        v-for="events1 in events" data-bs-toggle="modal" data-bs-target="#viewevents">
                                        <div class="avatar float-start bg-custom rounded me-1"
                                            @click="fetch_events(events1.event_id)">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-calendar"></i>
                                            </div>
                                        </div>
                                        <div class="more-info" @click="fetch_events(events1.event_id)">
                                            <h6 class="mb-0">{{ events1.title }}</h6>
                                            <small>{{ events1.start | formatDate }} <label
                                                    v-if="events1.start_time != null">(</label>{{ events1.start_time }}
                                                <label v-if="events1.end_time != null">to</label><label v-else> </label>
                                                {{ events1.end_time }}<label
                                                    v-if="events1.start_time != null">)</label></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!--/ Medal Card -->

                        <!-- Statistics Card  Month-wise Employees Report-->
                        <div class="col-xl-12  col-sm-12 col-12">
                            <div class="card card-statistics border-0 shadow rounded-4">
                                <div class="card-header top-radius">
                                    <h4 class="fw-semibold">Monthly Employee’s Report</h4>
                                </div>
                                <div class="chart-container">
                                    <div class="card-body statistics-body">
                                        <apexchart type="bar" height="320px" :options="options" :series="series">
                                        </apexchart>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Department-wise Employees status -->
                        <div class="col-lg-12 col-sm-12 col-12 ">
                            <div class="card-header border-bottom top-radius">
                                <h4 class="fw-semibold">Department-wise Employees status
                                </h4>
                            </div>
                            <div class="card card-company-table border-0 rounded-bottom-4 shadow">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-center">
                                                <tr>
                                                    <th style="width: 20%;">Department Name</th>
                                                    <th style="width: 15%;">Total Employees</th>
                                                    <th class="text-success" style="width: 13%;">Registered</th>
                                                    <th class="text-warning" style="width: 13%;">Contracts</th>
                                                    <th class="text-primary" style="width: 13%;">Probation</th>
                                                    <th class="text-danger" style="width: 13%;">Resigned</th>
                                                    <th class="text-danger" style="width: 13%;">Terminated</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="card-body" style="height: 290px; overflow-y: scroll;">
                                            <table class="table">
                                                <tbody>
                                                    <tr v-for="dept_data in Department_data">
                                                        <td class="sorting_1 border-end-dashed" style="width: 20%;">
                                                            {{ dept_data.Department }}
                                                        </td>
                                                        <td class="text-center border-end-dashed" style="width: 15%;">
                                                            {{ dept_data.TotalEmp }}
                                                        </td>
                                                        <td class="text-center border-end-dashed" style="width: 14%;">
                                                            {{ dept_data.RegisteredCount }}
                                                        </td>
                                                        <td class="text-center border-end-dashed" style="width: 13%;">
                                                            {{ dept_data.ContractsCount }}
                                                        </td>
                                                        <td class="text-center border-end-dashed" style="width: 14%;">
                                                            {{ dept_data.ProbationCount }}
                                                        </td>
                                                        <td class="text-center border-end-dashed" style="width: 13%;">
                                                            {{ dept_data.ResignedCount }}
                                                        </td>
                                                        <td class="text-center border-end-dashed" style="width: 13%;">
                                                            {{ dept_data.TerminatedCount }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Annual Leaves Data -->
                        <!-- <div class="col-lg-5 col-md-6 col-12">
                            <div class="card-header">
                                <h4 style="font-size:14px">Annual Leaves Data</h4>
                            </div>
                            <div class="card">
                                <apexchart type="bar" height="400" :options="chartOptions5" :series="series5">
                                </apexchart>
                            </div>
                        </div> -->

                        <!--/ Statistics Card -->
                    </div>
                    <div class="row match-height">
                        <!-- Company Table Card for Event-->
                        <!-- <div class="col-lg-8 col-12">
                            <div class="card-header">
                                <h4 style="font-size:14px">Today's Attendance Of All
                                    Departments</h4>
                            </div>
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table text-center">
                                            <thead>
                                                <tr>
                                                    <th style="width:40%">Department</th>
                                                    <th>Employees</th>
                                                    <th>Present</th>
                                                    <th>Absent</th>
                                                    <th style="width:13%; text-align:left !important">Late</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="card-body" style="height: 233px; overflow-y: scroll;">
                                            <table class="table text-center">
                                                <tbody>
                                                    <tr v-for="attendance1 in attendance">
                                                        <td style="width:38%">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-custom me-1">
                                                                    <div class="avatar-content">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="14" height="14" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="feather feather-monitor font-medium-3">
                                                                            <rect x="2" y="3" width="20" height="14"
                                                                                rx="2" ry="2"></rect>
                                                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                                                            <line x1="12" y1="17" x2="12" y2="21">
                                                                            </line>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <span>{{ attendance1.Department }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="fw-bolder mb-25">{{
                                                                    attendance1.TotalEmployee }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ attendance1.Present }}</td>
                                                        <td>{{ attendance1.Absent }}</td>
                                                        <td>{{ attendance1.Leave }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!--/ Company Table Card -->

                        <!-- Developer Meetup Card -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="row match-height">
                                <!-- Bar Chart - Orders for males-->
                                <!-- <div class="col-lg-6 col-md-3 col-6">
                                    <div class="card">
                                        <div class="card-body pb-50" style="position: relative;">
                                            <h6>Males</h6>
                                            <h2 class="fw-bolder mb-1">{{ emp_count.males }}</h2>
                                            <div id="statistics-order-chart" style="min-height: 65px;">
                                                <div id="apexchartsscen1q2n"
                                                    class="apexcharts-canvas apexchartsscen1q2n apexcharts-theme-light"
                                                    styzle="width: 135px; height: 70px;">
                                                    <svg id="SvgjsSvg6020" width="135" height="70"
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        xmlns:svgjs="http://svgjs.com/svgjs"
                                                        class="apexcharts-svg apexcharts-zoomable"
                                                        xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                        style="background: transparent;">
                                                        <g id="SvgjsG6022" class="apexcharts-inner apexcharts-graphical"
                                                            transform="translate(13.5, 15)">
                                                            <defs id="SvgjsDefs6021">
                                                                <linearGradient id="SvgjsLinearGradient6025" x1="0"
                                                                    y1="0" x2="0" y2="1">
                                                                    <stop id="SvgjsStop6026" stop-opacity="0.4"
                                                                        stop-color="rgba(216,227,240,0.4)" offset="0">
                                                                    </stop>
                                                                    <stop id="SvgjsStop6027" stop-opacity="0.5"
                                                                        stop-color="rgba(190,209,230,0.5)" offset="1">
                                                                    </stop>
                                                                    <stop id="SvgjsStop6028" stop-opacity="0.5"
                                                                        stop-color="rgba(190,209,230,0.5)" offset="1">
                                                                    </stop>
                                                                </linearGradient>
                                                                <clipPath id="gridRectMaskscen1q2n">
                                                                    <rect id="SvgjsRect6030" width="139" height="55"
                                                                        x="-11.5" y="0" rx="0" ry="0" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#fff"></rect>
                                                                </clipPath>
                                                                <clipPath id="gridRectMarkerMaskscen1q2n">
                                                                    <rect id="SvgjsRect6031" width="120" height="59"
                                                                        x="-2" y="-2" rx="0" ry="0" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#fff">
                                                                    </rect>
                                                                </clipPath>
                                                            </defs>
                                                            <rect id="SvgjsRect6029" width="5.8" height="55" x="0" y="0"
                                                                rx="0" ry="0" opacity="1" stroke-width="0"
                                                                stroke-dasharray="3"
                                                                fill="url(#SvgjsLinearGradient6025)"
                                                                class="apexcharts-xcrosshairs" y2="55" filter="none"
                                                                fill-opacity="0.9"></rect>
                                                            <g id="SvgjsG6045" class="apexcharts-xaxis"
                                                                transform="translate(0, 0)">
                                                                <g id="SvgjsG6046" class="apexcharts-xaxis-texts-g"
                                                                    transform="translate(0, -4)"></g>
                                                            </g>
                                                            <g id="SvgjsG6048" class="apexcharts-grid">
                                                                <g id="SvgjsG6049"
                                                                    class="apexcharts-gridlines-horizontal"
                                                                    style="display: none;">
                                                                    <line id="SvgjsLine6051" x1="-9.5" y1="0" x2="125.5"
                                                                        y2="0" stroke="#e0e0e0" stroke-dasharray="0"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6052" x1="-9.5" y1="11"
                                                                        x2="125.5" y2="11" stroke="#e0e0e0"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6053" x1="-9.5" y1="22"
                                                                        x2="125.5" y2="22" stroke="#e0e0e0"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6054" x1="-9.5" y1="33"
                                                                        x2="125.5" y2="33" stroke="#e0e0e0"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6055" x1="-9.5" y1="44"
                                                                        x2="125.5" y2="44" stroke="#e0e0e0"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6056" x1="-9.5" y1="55"
                                                                        x2="125.5" y2="55" stroke="#e0e0e0"
                                                                        stroke-dasharray="0"
                                                                        class="apexcharts-gridline"></line>
                                                                </g>
                                                                <g id="SvgjsG6050" class="apexcharts-gridlines-vertical"
                                                                    style="display: none;"></g>
                                                                <line id="SvgjsLine6058" x1="0" y1="55" x2="116" y2="55"
                                                                    stroke="transparent" stroke-dasharray="0"></line>
                                                                <line id="SvgjsLine6057" x1="0" y1="1" x2="0" y2="55"
                                                                    stroke="transparent" stroke-dasharray="0"></line>
                                                            </g>
                                                            <g id="SvgjsG6032"
                                                                class="apexcharts-bar-series apexcharts-plot-series">
                                                                <g id="SvgjsG6033" class="apexcharts-series"
                                                                    seriesName="2020" rel="1" data:realIndex="0">
                                                                    <rect id="SvgjsRect6035" width="5.8" height="55"
                                                                        x="-2.9" y="0" rx="5" ry="5" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#f3f3f3"
                                                                        class="apexcharts-backgroundBar">
                                                                    </rect>
                                                                    <path id="SvgjsPath6036"
                                                                        d="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z"
                                                                        fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                        stroke-opacity="1" stroke-linecap="square"
                                                                        stroke-width="0" stroke-dasharray="0"
                                                                        class="apexcharts-bar-area" index="0"
                                                                        clip-path="url(#gridRectMaskscen1q2n)"
                                                                        pathTo="M -2.9 53.55L -2.9 30.25L 2.9 30.25L 2.9 30.25L 2.9 53.55Q 0 56.449999999999996 -2.9 53.55z"
                                                                        pathFrom="M -2.9 53.55L -2.9 55L 2.9 55L 2.9 55L 2.9 55L -2.9 55"
                                                                        cy="30.25" cx="2.9000000000000012" j="0"
                                                                        val="45" barHeight="24.75" barWidth="5.8">
                                                                    </path>
                                                                    <rect id="SvgjsRect6037" width="5.8" height="55"
                                                                        x="26.1" y="0" rx="5" ry="5" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#f3f3f3"
                                                                        class="apexcharts-backgroundBar">
                                                                    </rect>
                                                                    <path id="SvgjsPath6038"
                                                                        d="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z"
                                                                        fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                        stroke-opacity="1" stroke-linecap="square"
                                                                        stroke-width="0" stroke-dasharray="0"
                                                                        class="apexcharts-bar-area" index="0"
                                                                        clip-path="url(#gridRectMaskscen1q2n)"
                                                                        pathTo="M 26.1 53.55L 26.1 8.25L 31.900000000000002 8.25L 31.900000000000002 8.25L 31.900000000000002 53.55Q 29 56.449999999999996 26.1 53.55z"
                                                                        pathFrom="M 26.1 53.55L 26.1 55L 31.900000000000002 55L 31.900000000000002 55L 31.900000000000002 55L 26.1 55"
                                                                        cy="8.25" cx="31.900000000000002" j="1" val="85"
                                                                        barHeight="46.75" barWidth="5.8"></path>
                                                                    <rect id="SvgjsRect6039" width="5.8" height="55"
                                                                        x="55.1" y="0" rx="5" ry="5" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#f3f3f3"
                                                                        class="apexcharts-backgroundBar">
                                                                    </rect>
                                                                    <path id="SvgjsPath6040"
                                                                        d="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z"
                                                                        fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                        stroke-opacity="1" stroke-linecap="square"
                                                                        stroke-width="0" stroke-dasharray="0"
                                                                        class="apexcharts-bar-area" index="0"
                                                                        clip-path="url(#gridRectMaskscen1q2n)"
                                                                        pathTo="M 55.1 53.55L 55.1 19.25L 60.9 19.25L 60.9 19.25L 60.9 53.55Q 58 56.449999999999996 55.1 53.55z"
                                                                        pathFrom="M 55.1 53.55L 55.1 55L 60.9 55L 60.9 55L 60.9 55L 55.1 55"
                                                                        cy="19.25" cx="60.89999999999999" j="2" val="65"
                                                                        barHeight="35.75" barWidth="5.8"></path>
                                                                    <rect id="SvgjsRect6041" width="5.8" height="55"
                                                                        x="84.1" y="0" rx="5" ry="5" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#f3f3f3"
                                                                        class="apexcharts-backgroundBar">
                                                                    </rect>
                                                                    <path id="SvgjsPath6042"
                                                                        d="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z"
                                                                        fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                        stroke-opacity="1" stroke-linecap="square"
                                                                        stroke-width="0" stroke-dasharray="0"
                                                                        class="apexcharts-bar-area" index="0"
                                                                        clip-path="url(#gridRectMaskscen1q2n)"
                                                                        pathTo="M 84.1 53.55L 84.1 30.25L 89.89999999999999 30.25L 89.89999999999999 30.25L 89.89999999999999 53.55Q 87 56.449999999999996 84.1 53.55z"
                                                                        pathFrom="M 84.1 53.55L 84.1 55L 89.89999999999999 55L 89.89999999999999 55L 89.89999999999999 55L 84.1 55"
                                                                        cy="30.25" cx="89.89999999999999" j="3" val="45"
                                                                        barHeight="24.75" barWidth="5.8"></path>
                                                                    <rect id="SvgjsRect6043" width="5.8" height="55"
                                                                        x="113.1" y="0" rx="5" ry="5" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#f3f3f3"
                                                                        class="apexcharts-backgroundBar">
                                                                    </rect>
                                                                    <path id="SvgjsPath6044"
                                                                        d="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z"
                                                                        fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                        stroke-opacity="1" stroke-linecap="square"
                                                                        stroke-width="0" stroke-dasharray="0"
                                                                        class="apexcharts-bar-area" index="0"
                                                                        clip-path="url(#gridRectMaskscen1q2n)"
                                                                        pathTo="M 113.1 53.55L 113.1 19.25L 118.89999999999999 19.25L 118.89999999999999 19.25L 118.89999999999999 53.55Q 116 56.449999999999996 113.1 53.55z"
                                                                        pathFrom="M 113.1 53.55L 113.1 55L 118.89999999999999 55L 118.89999999999999 55L 118.89999999999999 55L 113.1 55"
                                                                        cy="19.25" cx="118.89999999999999" j="4"
                                                                        val="65" barHeight="35.75" barWidth="5.8">
                                                                    </path>
                                                                </g>
                                                                <g id="SvgjsG6034" class="apexcharts-datalabels"
                                                                    data:realIndex="0"></g>
                                                            </g>
                                                            <line id="SvgjsLine6059" x1="-9.5" y1="0" x2="125.5" y2="0"
                                                                stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                                class="apexcharts-ycrosshairs"></line>
                                                            <line id="SvgjsLine6060" x1="-9.5" y1="0" x2="125.5" y2="0"
                                                                stroke-dasharray="0" stroke-width="0"
                                                                class="apexcharts-ycrosshairs-hidden"></line>
                                                            <g id="SvgjsG6061" class="apexcharts-yaxis-annotations"></g>
                                                            <g id="SvgjsG6062" class="apexcharts-xaxis-annotations"></g>
                                                            <g id="SvgjsG6063" class="apexcharts-point-annotations"></g>
                                                            <rect id="SvgjsRect6064" width="0" height="0" x="0" y="0"
                                                                rx="0" ry="0" opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#fefefe"
                                                                class="apexcharts-zoom-rect"></rect>
                                                            <rect id="SvgjsRect6065" width="0" height="0" x="0" y="0"
                                                                rx="0" ry="0" opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#fefefe"
                                                                class="apexcharts-selection-rect"></rect>
                                                        </g>
                                                        <g id="SvgjsG6047" class="apexcharts-yaxis" rel="0"
                                                            transform="translate(-18, 0)"></g>
                                                        <g id="SvgjsG6023" class="apexcharts-annotations"></g>
                                                    </svg>
                                                    <div class="apexcharts-legend" style="max-height: 35px;"></div>
                                                    <div class="apexcharts-tooltip apexcharts-theme-light">
                                                        <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                            <span class="apexcharts-tooltip-marker"
                                                                style="background-color: rgb(255, 159, 67);"></span>
                                                            <div class="apexcharts-tooltip-text"
                                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                                <div class="apexcharts-tooltip-y-group"><span
                                                                        class="apexcharts-tooltip-text-label"></span><span
                                                                        class="apexcharts-tooltip-text-value"></span>
                                                                </div>
                                                                <div class="apexcharts-tooltip-z-group"><span
                                                                        class="apexcharts-tooltip-text-z-label"></span><span
                                                                        class="apexcharts-tooltip-text-z-value"></span>
                                                                </div>
                                                            </div>
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
                                                    <div style="width: 178px; height: 181px;"></div>
                                                </div>
                                                <div class="contract-trigger"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!--/ Bar Chart - Orders -->
                                <!-- Line Chart - Profit for females-->
                                <!-- <div class="col-lg-6 col-md-3 col-6">
                                    <div class="card card-tiny-line-stats">
                                        <div class="card-body pb-50" style="position: relative;">
                                            <h6>Female</h6>
                                            <h2 class="fw-bolder mb-1">{{ emp_count.females }}</h2>
                                            <div id="statistics-profit-chart" style="min-height: 65px;">
                                                <div id="apexchartsrpjmi0ko"
                                                    class="apexcharts-canvas apexchartsrpjmi0ko apexcharts-theme-light"
                                                    style="width: 135px; height: 70px;">
                                                    <svg id="SvgjsSvg6066" width="135" height="70"
                                                        xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                                        xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                        xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                        style="background: transparent;">
                                                        <g id="SvgjsG6068" class="apexcharts-inner apexcharts-graphical"
                                                            transform="translate(12, 0)">
                                                            <defs id="SvgjsDefs6067">
                                                                <clipPath id="gridRectMaskrpjmi0ko">
                                                                    <rect id="SvgjsRect6073" width="120" height="68"
                                                                        x="-3.5" y="-1.5" rx="0" ry="0" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#fff"></rect>
                                                                </clipPath>
                                                                <clipPath id="gridRectMarkerMaskrpjmi0ko">
                                                                    <rect id="SvgjsRect6074" width="125" height="77"
                                                                        x="-6" y="-6" rx="0" ry="0" opacity="1"
                                                                        stroke-width="0" stroke="none"
                                                                        stroke-dasharray="0" fill="#fff">
                                                                    </rect>
                                                                </clipPath>
                                                            </defs>
                                                            <line id="SvgjsLine6072" x1="0" y1="0" x2="0" y2="65"
                                                                stroke="#b6b6b6" stroke-dasharray="3"
                                                                class="apexcharts-xcrosshairs" x="0" y="0" width="1"
                                                                height="65" fill="#b1b9c4" filter="none"
                                                                fill-opacity="0.9" stroke-width="1"></line>
                                                            <g id="SvgjsG6091" class="apexcharts-xaxis"
                                                                transform="translate(0, 0)">
                                                                <g id="SvgjsG6092" class="apexcharts-xaxis-texts-g"
                                                                    transform="translate(0, -4)">
                                                                    <text id="SvgjsText6094"
                                                                        font-family="Helvetica, Arial, sans-serif" x="0"
                                                                        y="94" text-anchor="middle"
                                                                        dominant-baseline="auto" font-size="0px"
                                                                        font-weight="400" fill="#373d3f"
                                                                        class="apexcharts-text apexcharts-xaxis-label "
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        <tspan id="SvgjsTspan6095">1</tspan>
                                                                        <title>1</title>
                                                                    </text>
                                                                    <text id="SvgjsText6097"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="22.600000000000005" y="94"
                                                                        text-anchor="middle" dominant-baseline="auto"
                                                                        font-size="0px" font-weight="400" fill="#373d3f"
                                                                        class="apexcharts-text apexcharts-xaxis-label "
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        <tspan id="SvgjsTspan6098">2</tspan>
                                                                        <title>2</title>
                                                                    </text>
                                                                    <text id="SvgjsText6100"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="45.2" y="94" text-anchor="middle"
                                                                        dominant-baseline="auto" font-size="0px"
                                                                        font-weight="400" fill="#373d3f"
                                                                        class="apexcharts-text apexcharts-xaxis-label "
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        <tspan id="SvgjsTspan6101">3</tspan>
                                                                        <title>3</title>
                                                                    </text>
                                                                    <text id="SvgjsText6103"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="67.80000000000001" y="94"
                                                                        text-anchor="middle" dominant-baseline="auto"
                                                                        font-size="0px" font-weight="400" fill="#373d3f"
                                                                        class="apexcharts-text apexcharts-xaxis-label "
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        <tspan id="SvgjsTspan6104">4</tspan>
                                                                        <title>4</title>
                                                                    </text>
                                                                    <text id="SvgjsText6106"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="90.40000000000002" y="94"
                                                                        text-anchor="middle" dominant-baseline="auto"
                                                                        font-size="0px" font-weight="400" fill="#373d3f"
                                                                        class="apexcharts-text apexcharts-xaxis-label "
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        <tspan id="SvgjsTspan6107">5</tspan>
                                                                        <title>5</title>
                                                                    </text>
                                                                    <text id="SvgjsText6109"
                                                                        font-family="Helvetica, Arial, sans-serif"
                                                                        x="113.00000000000001" y="94"
                                                                        text-anchor="middle" dominant-baseline="auto"
                                                                        font-size="0px" font-weight="400" fill="#373d3f"
                                                                        class="apexcharts-text apexcharts-xaxis-label "
                                                                        style="font-family: Helvetica, Arial, sans-serif;">
                                                                        <tspan id="SvgjsTspan6110">6</tspan>
                                                                        <title>6</title>
                                                                    </text>
                                                                </g>
                                                            </g>
                                                            <g id="SvgjsG6112" class="apexcharts-grid">
                                                                <g id="SvgjsG6113"
                                                                    class="apexcharts-gridlines-horizontal">
                                                                </g>
                                                                <g id="SvgjsG6114"
                                                                    class="apexcharts-gridlines-vertical">
                                                                    <line id="SvgjsLine6115" x1="0" y1="0" x2="0"
                                                                        y2="65" stroke="#ebebeb" stroke-dasharray="5"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6116" x1="22.6" y1="0" x2="22.6"
                                                                        y2="65" stroke="#ebebeb" stroke-dasharray="5"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6117" x1="45.2" y1="0" x2="45.2"
                                                                        y2="65" stroke="#ebebeb" stroke-dasharray="5"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6118" x1="67.80000000000001"
                                                                        y1="0" x2="67.80000000000001" y2="65"
                                                                        stroke="#ebebeb" stroke-dasharray="5"
                                                                        class="apexcharts-gridline">
                                                                    </line>
                                                                    <line id="SvgjsLine6119" x1="90.4" y1="0" x2="90.4"
                                                                        y2="65" stroke="#ebebeb" stroke-dasharray="5"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine6120" x1="113" y1="0" x2="113"
                                                                        y2="65" stroke="#ebebeb" stroke-dasharray="5"
                                                                        class="apexcharts-gridline"></line>
                                                                </g>
                                                                <line id="SvgjsLine6122" x1="0" y1="65" x2="113" y2="65"
                                                                    stroke="transparent" stroke-dasharray="0"></line>
                                                                <line id="SvgjsLine6121" x1="0" y1="1" x2="0" y2="65"
                                                                    stroke="transparent" stroke-dasharray="0"></line>
                                                            </g>
                                                            <g id="SvgjsG6075"
                                                                class="apexcharts-line-series apexcharts-plot-series">
                                                                <g id="SvgjsG6076" class="apexcharts-series"
                                                                    seriesName="seriesx1" data:longestSeries="true"
                                                                    rel="1" data:realIndex="0">
                                                                    <path id="SvgjsPath6090"
                                                                        d="M 0 65L 22.6 39L 45.2 58.5L 67.8 26L 90.4 45.5L 113 6.5"
                                                                        fill="none" fill-opacity="1"
                                                                        stroke="rgba(0,207,232,0.85)" stroke-opacity="1"
                                                                        stroke-linecap="butt" stroke-width="3"
                                                                        stroke-dasharray="0" class="apexcharts-line"
                                                                        index="0" clip-path="url(#gridRectMaskrpjmi0ko)"
                                                                        pathTo="M 0 65L 22.6 39L 45.2 58.5L 67.8 26L 90.4 45.5L 113 6.5"
                                                                        pathFrom="M -1 65L -1 65L 22.6 65L 45.2 65L 67.8 65L 90.4 65L 113 65">
                                                                    </path>
                                                                    <g id="SvgjsG6077"
                                                                        class="apexcharts-series-markers-wrap"
                                                                        data:realIndex="0">
                                                                        <g id="SvgjsG6079"
                                                                            class="apexcharts-series-markers"
                                                                            clip-path="url(#gridRectMarkerMaskrpjmi0ko)">
                                                                            <circle id="SvgjsCircle6080" r="2" cx="0"
                                                                                cy="65"
                                                                                class="apexcharts-marker no-pointer-events wq2gd821d"
                                                                                stroke="#00cfe8" fill="#00cfe8"
                                                                                fill-opacity="1" stroke-width="2"
                                                                                stroke-opacity="1" rel="0" j="0"
                                                                                index="0" default-marker-size="2">
                                                                            </circle>
                                                                            <circle id="SvgjsCircle6081" r="2" cx="22.6"
                                                                                cy="39"
                                                                                class="apexcharts-marker no-pointer-events w7yjz4r7lk"
                                                                                stroke="#00cfe8" fill="#00cfe8"
                                                                                fill-opacity="1" stroke-width="2"
                                                                                stroke-opacity="1" rel="1" j="1"
                                                                                index="0" default-marker-size="2">
                                                                            </circle>
                                                                        </g>
                                                                        <g id="SvgjsG6082"
                                                                            class="apexcharts-series-markers"
                                                                            clip-path="url(#gridRectMarkerMaskrpjmi0ko)">
                                                                            <circle id="SvgjsCircle6083" r="2" cx="45.2"
                                                                                cy="58.5"
                                                                                class="apexcharts-marker no-pointer-events wt8vo4vstj"
                                                                                stroke="#00cfe8" fill="#00cfe8"
                                                                                fill-opacity="1" stroke-width="2"
                                                                                stroke-opacity="1" rel="2" j="2"
                                                                                index="0" default-marker-size="2">
                                                                            </circle>
                                                                        </g>
                                                                        <g id="SvgjsG6084"
                                                                            class="apexcharts-series-markers"
                                                                            clip-path="url(#gridRectMarkerMaskrpjmi0ko)">
                                                                            <circle id="SvgjsCircle6085" r="2" cx="67.8"
                                                                                cy="26"
                                                                                class="apexcharts-marker no-pointer-events w837vaxksk"
                                                                                stroke="#00cfe8" fill="#00cfe8"
                                                                                fill-opacity="1" stroke-width="2"
                                                                                stroke-opacity="1" rel="3" j="3"
                                                                                index="0" default-marker-size="2">
                                                                            </circle>
                                                                        </g>
                                                                        <g id="SvgjsG6086"
                                                                            class="apexcharts-series-markers"
                                                                            clip-path="url(#gridRectMarkerMaskrpjmi0ko)">
                                                                            <circle id="SvgjsCircle6087" r="2" cx="90.4"
                                                                                cy="45.5"
                                                                                class="apexcharts-marker no-pointer-events w879hv5e"
                                                                                stroke="#00cfe8" fill="#00cfe8"
                                                                                fill-opacity="1" stroke-width="2"
                                                                                stroke-opacity="1" rel="4" j="4"
                                                                                index="0" default-marker-size="2">
                                                                            </circle>
                                                                        </g>
                                                                        <g id="SvgjsG6088"
                                                                            class="apexcharts-series-markers"
                                                                            clip-path="url(#gridRectMarkerMaskrpjmi0ko)">
                                                                            <circle id="SvgjsCircle6089" r="5" cx="113"
                                                                                cy="6.5"
                                                                                class="apexcharts-marker no-pointer-events wpht4qkyn"
                                                                                stroke="#00cfe8" fill="#ffffff"
                                                                                fill-opacity="1" stroke-width="2"
                                                                                stroke-opacity="1" rel="5" j="5"
                                                                                index="0" default-marker-size="5">
                                                                            </circle>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g id="SvgjsG6078" class="apexcharts-datalabels"
                                                                    data:realIndex="0"></g>
                                                            </g>
                                                            <line id="SvgjsLine6123" x1="0" y1="0" x2="113" y2="0"
                                                                stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                                                class="apexcharts-ycrosshairs"></line>
                                                            <line id="SvgjsLine6124" x1="0" y1="0" x2="113" y2="0"
                                                                stroke-dasharray="0" stroke-width="0"
                                                                class="apexcharts-ycrosshairs-hidden"></line>
                                                            <g id="SvgjsG6125" class="apexcharts-yaxis-annotations"></g>
                                                            <g id="SvgjsG6126" class="apexcharts-xaxis-annotations"></g>
                                                            <g id="SvgjsG6127" class="apexcharts-point-annotations"></g>
                                                        </g>
                                                        <rect id="SvgjsRect6071" width="0" height="0" x="0" y="0" rx="0"
                                                            ry="0" opacity="1" stroke-width="0" stroke="none"
                                                            stroke-dasharray="0" fill="#fefefe"></rect>
                                                        <g id="SvgjsG6111" class="apexcharts-yaxis" rel="0"
                                                            transform="translate(-18, 0)"></g>
                                                        <g id="SvgjsG6069" class="apexcharts-annotations"></g>
                                                    </svg>
                                                    <div class="apexcharts-legend" style="max-height: 35px;"></div>
                                                    <div class="apexcharts-tooltip apexcharts-theme-light">
                                                        <div class="apexcharts-tooltip-series-group" style="order: 1;">
                                                            <span class="apexcharts-tooltip-marker"
                                                                style="background-color: rgb(0, 207, 232);"></span>
                                                            <div class="apexcharts-tooltip-text"
                                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                                <div class="apexcharts-tooltip-y-group"><span
                                                                        class="apexcharts-tooltip-text-label"></span><span
                                                                        class="apexcharts-tooltip-text-value"></span>
                                                                </div>
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
                                                    <div style="width: 178px; height: 181px;"></div>
                                                </div>
                                                <div class="contract-trigger"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!--/ Line Chart - Profit -->
                                <!-- Earnings Card   employee details-->

                                <!-- <div class="col-xl-12 col-md-6 col-12">

                                    <div class="card card-developer-meetup">
                                        <div class="card-body" style="">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4 class="card-title">Employee Detail</h4>
                                            </div>
                                            <div id="chart">
                                                <apexchart type="radialBar" height="220" :options="chartOptions2"
                                                    :series="series2"></apexchart>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-circle text-success "></i>
                                                    <span class="fw-bold ms-75">Total Employees</span>
                                                </div>
                                                <span>{{ (Math.floor(this.count_users.all_users)).toLocaleString()
                                                    }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-circle text-primary"></i>
                                                    <span class="fw-bold ms-75">Registered</span>
                                                </div>
                                                <span>{{ (Math.floor(this.count_users.active_users)).toLocaleString()
                                                    }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-circle text-danger"></i>
                                                    <span class="fw-bold ms-75">Contractual</span>
                                                </div>
                                                <span>{{
                                                    (Math.floor(this.count_users.contractual_users)).toLocaleString()
                                                    }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-circle text-warning"></i>
                                                    <span class="fw-bold ms-75">Terminated</span>
                                                </div>
                                                <span>{{ this.count_users.terminated_users }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-circle text-warning"></i>
                                                    <span class="fw-bold ms-75">Resigned</span>
                                                </div>
                                                <span>{{ this.count_users.inactive_users }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa-regular fa-circle text-warning"></i>
                                                    <span class="fw-bold ms-75">Suspended</span>
                                                </div>
                                                <span>{{ this.count_users.suspended_users }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!--/ Earnings Card -->
                            </div>
                        </div>
                        <!--/ Developer Meetup Card -->
                    </div>
                </div>
                <div class="row match-height">
                    <!-- Company Table Card -->
                    <div class="col-lg-8 col-12">
                        <div class="card-header border-bottom top-radius">
                            <h4 class="fw-semibold">Employee Job status/ Expiry details
                                ({{ emp_count.status_exp_cnt }})</h4>
                        </div>
                        <div class="card card-company-table border-0 rounded-bottom-4 shadow">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table rounded-4">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="width: 30%;"> Name</th>
                                                <th style="width: 21%;">Department</th>
                                                <th style="width: 21%;">Position</th>
                                                <th style="width: 26%;">Status Expiry Date</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div class="card-body" style="height: 402px; overflow-y: scroll;">
                                        <table class="table rounded-4">
                                            <tbody>
                                                <tr v-for="exp_emp1 in exp_emp">
                                                    <td class="sorting_1 border-end-solid" style="width: 50%;">
                                                        <div class="d-flex justify-content-left align-items-center">
                                                            <div class="avatar-wrapper">
                                                                <div class="avatar  me-1">
                                                                    <img src="public/images/profile_images/pro.png"
                                                                        alt="Avatar" height="32" width="32">

                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <a class="user_name text-truncate text-body">
                                                                    <span class="fw-bolder">{{ exp_emp1.Name }}</span>
                                                                </a>
                                                                <small class="emp_post text-muted">
                                                                    <span>{{ exp_emp1.Designation }}-{{
                                                                        exp_emp1.EmployeeCode }} ({{ exp_emp1.Status
                                                                        }})</span>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center border-end-solid" style="width: 28%;">{{
                                                        exp_emp1.Department
                                                    }}
                                                    </td>
                                                    <td class="border-end-solid" style="text-align:right; width: 22%;">
                                                        {{ exp_emp1.ProbationEnd
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Company Table Card -->
                    <!-- chart for Annual Leaves Data -->
                    <div class="col-lg-4  col-12">
                        <div class="card-header border-bottom top-radius">
                            <h4 class="fw-bolder">Annual Leaves Data</h4>
                        </div>
                        <div class="card border-0 rounded-bottom-4">
                            <apexchart type="bar" height="400" :options="chartOptions5" :series="series5">
                            </apexchart>
                        </div>
                    </div>
                    <!--// chart for Annual Leaves Data -->

                    <!-- Developer Meetup Card -->
                    <!-- <div class="col-lg-6 col-md-6 col-12">
                        <div class="card-header">
                            <h4 style="font-size:14px">Employees CNIC Expiry Detail
                                ({{ emp_count.cnic_exp_cnt }})</h4>
                        </div>
                        <div class="card card-company-table">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th style="width: 53%;"> Name</th>
                                                <th style="width: 21%;">Department</th>
                                                <th style="width: 26%;">CNIC Expiry</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div class="card-body" style="height: 402px; overflow-y: scroll;">
                                        <table class="table">
                                            <tbody>
                                                <tr v-for="exp_cnic1 in exp_cnic">
                                                    <td class="sorting_1" style="width: 50%;">
                                                        <div class="d-flex justify-content-left align-items-center">
                                                            <div class="avatar-wrapper">
                                                                <div class="avatar  me-1">
                                                                    <img src="public/images/profile_images/pro.png"
                                                                        alt="Avatar" height="32" width="32">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <a class="user_name text-truncate text-body"><span
                                                                        class="fw-bolder">{{ exp_cnic1.Name
                                                                        }}</span></a><small class="emp_post text-muted">
                                                                    <span>{{ exp_cnic1.Designation }}-{{
                                                                        exp_cnic1.EmployeeCode }} ({{ exp_cnic1.Status
                                                                        }})</span>

                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" style="width: 28%;">{{ exp_cnic1.Department
                                                        }}
                                                    </td>
                                                    <td style="text-align: right; width: 22%;">{{ exp_cnic1.CnicExpiry
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div>
                        <div class="card-header top-radius">
                            <h4 class="fw-semibold">Employees Age Wise Data</h4>
                        </div>
                        <apexchart type="bar" height="400" :options="chartOptions" :series="chartSeries1"></apexchart>
                    </div>
                </div>
            </div>
        </div>


        <!-- View loan Modal -->
        <div class="modal fade" id="viewevents" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12">
                                    <h2 style="text-align:center;"> Details of event</h2>
                                    <table style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:25%;">Event ID:</th>
                                                <td style="width:25%;">{{ event_id }}</td>
                                                <th style="width:25%;">Start date:</th>
                                                <td style="width:25%;">{{ start_date | formatDate }}</td>
                                            </tr>
                                            <tr>
                                                <th>Event title:</th>
                                                <td>{{ ev_title }}</td>
                                                <th>End date:</th>
                                                <td>{{ end_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Description:</th>
                                                <td> {{ ev_description }}</td>
                                                <th>Start time:</th>
                                                <td>{{ start_time }}</td>
                                            </tr>
                                            <tr>
                                                <th>URL:</th>
                                                <td> {{ ev_url }}</td>
                                                <th>End time:</th>
                                                <td> {{ end_time }}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                                        aria-label="Close">
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

    </div>
</template>
<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
<script>

import axios from 'axios';
import { color } from 'chart.js/helpers';
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';


Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('ddd MMM DD,YYYY')
    }
})

export default {

    components: {
        apexchart: VueApexCharts,
    },
    data: function () {
        return {
            Department_data: {},
            series2: [100, 0, 0, 0, 0, 0],
            count_users: {},
            att_daily_count: {},
            attendance: {},
            emp_count: {},
            exp_emp: {},
            exp_cnic: {},
            birthdaysToday: [],
            events: {},


            // images path
            images: {
                profileImage: "/images/profile_images/pro.png",
            },


            // Employeee Details
            series10: [],
            chartOptions10: {
                chart: {
                    type: "donut",
                },
                labels: ["Registered", "Contractual", "Terminated", "Resigned", "Suspended"],
                colors: ["#198754", "#0dcaf0", "#dc3545", "#ffc107", "#6c757d"],
                legend: {
                    show: false,
                },
            },



            series9: [],  //Will be populated with API data Employee Composition
            //  chartKey: 0,
            chartOptions9: {
                pie: {
                    donut: {
                        size: '100%'  // Smaller inner circle = thicker donut
                    }
                },
                chart: {
                    type: "donut",
                },
                labels: ["Men", "Women"],
                colors: ["#0070F2", "#FF6900"],
                dataLabels: {
                    style: {
                        fontSize: '11px',
                    }
                },
                legend: {
                    show: false,
                },
                stroke: {
                    width: 0
                }
            },


            chartOptions2: {
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {

                                    return
                                }
                            }
                        }
                    }
                },
                colors: ['#026440', '#0084ff', '#FF00FF', '#FFA500', '#808080', '#FF0000'],
                labels: ['Total Employee', 'Registered', 'Contractual', 'Terminated', 'Resigned', 'Suspended'],
            },

            EmpAge: {},

            event_id: '',
            start_date: '',
            ev_title: '',
            end_date: '',
            start_time: '',
            end_time: '',
            ev_description: '',
            ev_url: '',

            chartSeries: [
                {
                    name: '',
                    data: []
                }
            ],





            // chartOptions: {
            //     chart: {
            //         type: 'bar',
            //         height: 350
            //     },
            //     xaxis: {
            //         categories: [], // Initially empty, will be updated dynamically
            //         title: {
            //             text: 'Age Group'
            //         }
            //     },
            //     yaxis: {
            //         title: {
            //             text: 'Employees Count'
            //         }
            //     },
            //     plotOptions: {
            //         bar: {
            //             horizontal: false,
            //             columnWidth: '55%',
            //             endingShape: 'rounded'
            //         }
            //     },
            //     legend: {
            //         position: 'top',
            //         horizontalAlign: 'right',
            //         offsetX: 10
            //     },
            //     fill: {
            //         opacity: 1
            //     }
            // },





            chartOptions: {
                chart: {
                    type: 'bar',
                },
                xaxis: {
                    categories: ['0-20', '21-30', '31-40', '41-50', '51+'],
                    title: {
                        text: 'Age Group'
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,  // Set the border radius
                        borderRadiusApplication: 'around', // Options: 'end', 'around'
                        borderRadiusWhenStacked: 'all', // Options: 'all', 'last'
                        columnWidth: '55%',
                        distributed: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Employees Count'
                    }
                }
            },
            chartSeries1: [
                {
                    // name: 'Employees',
                    // data: [5, 20, 35, 25, 10]
                }
            ],
            chartDataLoaded: false,

            dde: [],
            ddf: [],
            series5: [
                // {
                //     name: '',
                //     data: [28, 10, 8, 62, 8, 41]
                // }
            ],
            chartOptions5: {
                chart: {
                    type: 'bar',
                    height: 400
                },
                // labels: [
                //     'Annual', 'Casual', 'Sick', 'Maternity', 'Paternity', 'Hajj/Ziarat'
                // ],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: [],
                },

            },


            series: [//{
                //     name: 'Hiring',
                //     data: [44, 55, 41, 67, 22, 43]
                // }, {
                //     name: 'Resign',
                //     data: [11, 17, 15, 15, 21, 14]
                // }, {
                //   name: 'Terminate',
                //       data: [21, 7, 25, 13, 22, 8]
                //      }
            ],
            options: {
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -20,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        borderRadiusApplication: 'end', // 'around', 'end'
                        borderRadiusWhenStacked: 'last', // 'all', 'last'
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    //   type: 'datetime',
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    formatter: function (seriesName) {
                        return '<span style="margin-right: 30px;">' + seriesName + '</span>';
                    }
                }
                ,
                fill: {
                    opacity: 1
                }
            },

            optionstt: {
                chart: {
                    type: 'bar',
                    id: 'vuechart-example',
                    height: 150,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }
            },
            seriestt: [{
                name: 'Hiring',
                data: [0, 0, 0, 0, 7, 0, 9, 0, 1, 0, 0, 0]
            }, {
                name: 'Firing',
                data: [0, 0, 0, 0, 0, 0, 8, 0, 0, 0, 0, 0]
            },

            ]
        }
    },

    methods: {
        fetchChartData() {


            // axios.get('CompanyWise_EmpAge')
            //     .then(response => {
            //         const responseData = response.data;
            //         console.log("okokokokok");

            //         console.log(responseData);
            //         const ageGroups = responseData.map(item => item.AgeGroup);
            //         const employeeCounts = responseData.map(item => parseInt(item.EmployeeCount, 10));
            //         // console.log("employee Counts",employeeCounts);

            //         this.chartOptions.xaxis.categories = ageGroups;
            //         this.chartSeries1 = [
            //             {
            //                 name: 'Employee Count',
            //                 data: employeeCounts,
            //             },
            //         ];
            //         this.chartDataLoaded = true;
            //     })
            //     .catch(error => {
            //         console.error('Error fetching chart data:', error);
            //     });
        },

        fetch_events(id) {
            axios.get('fetch_this_event/' + id)
                .then(responce => {

                    this.ev_title = responce.data[0].title;
                    this.event_id = responce.data[0].event_id;
                    this.start_date = responce.data[0].start;
                    this.end_date = responce.data[0].end;
                    this.start_time = responce.data[0].start_time;
                    this.end_time = responce.data[0].end_time;
                    this.ev_description = responce.data[0].description;
                    this.ev_url = responce.data[0].url;
                })
        },


    },

    mounted() {
        this.fetchChartData();

        axios.get('./count_employees')
            .then(response => {
                // console.log("Api response",response.data);

                this.count_users = response.data;
                // console.log(this.count_users);

                // console.log(this.count_users.data.all_users); just for testing
                //Registered
                // Contractual
                // Terminated
                if (this.count_users.data && this.count_users.data.all_users) {

                    this.series10 = [
                        this.count_users.data.active_users,
                        this.count_users.data.contractual_users,
                        this.count_users.data.terminated_users,
                        this.count_users.data.inactive_users,
                        this.count_users.data.suspended_users
                    ];

                } else {
                    this.series10 = [100, 0, 0, 0, 0, 0]; // Default values if data is not available
                }
            })
            .catch(error => {
            });
        axios.get('./fetch_event_thisweek')
            .then(data => this.events = data.data)
            .catch(error => {
            });

        axios.get('./get_count_dailyatt/')
            .then(response => {
                this.att_daily_count = response.data;
            })

        axios.get('./count_hiring_d/') //use for getting register
            .then(response => {
                this.dde = response.data;
                axios.get('./count_firing_d/') //use for getting terminate
                    .then(data => {
                        this.ddf = data.data;
                        axios.get('./count_resign_d') //use for getting resigned
                            .then(data1 => {
                                this.ddr = data1.data;
                                this.series = [
                                    {
                                        name: 'Hiring',
                                        color: '#198754',
                                        data: this.dde
                                    },
                                    {
                                        name: 'Resign',
                                        color: '#FE6900',
                                        data: this.ddr
                                    },
                                    {
                                        name: 'Terminate',
                                        color: '#D92727',
                                        data: this.ddf
                                    }

                                ]
                            })



                    })
            });



        axios.get('CompanyWise_EmpAge')
            .then(response => {
                // console.log('Birthdays:', response.data.birthdaysToday);
                const responseData = response.data;
                this.birthdaysToday = responseData.birthdaysToday;
                // console.log(birthdaysToday,"birthday");




                // age wise data chart
                const ageGroups = responseData.ageGroups.map(item => item.AgeGroup);
                const employeeCounts = responseData.ageGroups.map(item => parseInt(item.EmployeeCount, 10));
                this.chartOptions = {
                    ...this.chartOptions,
                    xaxis: {
                        ...this.chartOptions.xaxis,
                        categories: ageGroups,
                    },
                    labels: ageGroups,
                };
                this.chartSeries1 = [
                    {
                        name: 'Employee',
                        data: employeeCounts,
                    },
                ];
                this.chartDataLoaded = true;
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
            });


        axios.get('./count_leaves_d/')
            .then(response => {
                this.series5Data = response.data;
                console.log(this.series5Data);

                this.chartOptions5 = {
                    ...this.chartOptions5,
                    labels: Object.keys(this.series5Data),
                };

                this.series5 = [
                    {
                        name: 'Leaves',
                        data: Object.values(this.series5Data)
                    }
                ];
            })
            .catch(error => {
                console.error("Error fetching leave data:", error);
            });



        axios.get('DepartmentWise_EmpStatus')
            .then(response => {
                this.Department_data = response.data;
                console.log(this.Department_data, "DepartmentWise_EmpStatus");

            })
            .catch(error => {
            });
        axios.get('./session_att')
            .then(response => {
                this.attendance = response.data;
                // console.log("atendus depart wise", this.attendance);
            })
            .catch(error => {
            });

        // axios.get('./hrdb_employee_count')
        //     .then(data => this.emp_count = data.data)

        //     .catch(error => {
        //     });

        axios.get('./hrdb_employee_count')
            .then(response => {
                this.emp_count = response.data; // Assign API response to emp_count
                console.log(this.emp_count, "hrdb_employee_count");

                // Update the chart series dynamically
                this.series9 = [this.emp_count.males, this.emp_count.females];

            })
            .catch(error => {
                console.error("Error fetching employee count:", error);
            });

        axios.get('./job_exp_employee')
            .then(response => {
                this.exp_emp = response.data;
                console.log("Job Experience", this.exp_emp);

            })
            .catch(error => {
            });

        axios.get('./cnic_exp_employee')
            .then(data => this.exp_cnic = data.data)
            .catch(error => {
            });

    }
}
</script>
<style scoped>
.table:not(.table-dark):not(.table-light) thead:not(.table-dark) th,
.table:not(.table-dark):not(.table-light) tfoot:not(.table-dark) th {
    background-color: transparent !important;
    border-bottom: 0;
}

.border-end-dashed {
    border-right: 2px dashed #303030;
}

.border-end-solid {
    border-right: 2px solid #303030;
}

.table td:last-child,
.table th:last-child {
    border-right: none;
}

.table> :not(caption)>*>* {
    border-bottom-width: 0px !important;
}



.apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
.apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
    margin-right: 20px !important;
    justify-content: flex-end;
}

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



.card-statistics .statistics-body {
    padding: 15px 30px !important;
}

.bg-image {
    background-image: url('../../../../public/images/birthday-bg.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 20px;
}

.birth-btn {
    background: linear-gradient(95deg, #FF6900 0%, #FFFFFF 50%, #FD7313 100%);

}
</style>
