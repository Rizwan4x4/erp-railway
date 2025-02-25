<template>
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <!-- <div :class="menuClass" data-scroll-to-active="true"> -->
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item me-auto">
                        <router-link class="navbar-brand" to="/">
                            <span class="brand-logo">
                                <img v-bind:src="`public/images/${session_detail.company_logo}`" class="me-75"
                                    height="40" width="40" />
                            </span>
                            <h2 class="brand-text"
                                style="padding-left:5px; font-size: 18px;width: 130px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                {{ session_detail.company_name }}
                            </h2>
                        </router-link>
                    </li>
                    <li class="nav-item nav-toggle"><a style="margin-top: 35px;" class="nav-link modern-nav-toggle pe-0"
                            data-bs-toggle="collapse"><i
                                class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                                class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary"
                                data-feather="disc" data-ticon="disc"></i></a></li>
                </ul>
            </div>
            <div class="shadow-bottom"></div>
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li v-if="hasPermission('Dashboard')" class="nav-item has-sub">
                        <a class="d-flex align-items-center"><i class="fa-solid fa-gauge"></i><span
                                class="menu-title text-truncate">Dashboards</span></a>
                        <ul class="menu-content">
                            <li @click="activate(1)" :class="{ active: active_el == 1 }"
                                v-if="hasPermission('Recuriment Dashboard overall-view')">
                                <router-link to="/recruitment/recDashboard" class="d-flex align-items-center">
                                    <i data-feather="circle"></i>
                                    <span class="menu-item text-truncate">Recuritment</span>
                                </router-link>
                            </li>
                            <li @click="activate(2)" :class="{ active: active_el == 2 }"
                                v-if="hasPermission('Human Resource Dashboard overall-view')">
                                <router-link to="/hr/dashboard" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Human
                                        Resource</span></router-link>
                            </li>
                            <li @click="activate(3)" :class="{ active: active_el == 3 }"
                                v-if="hasPermission('Payroll Dashboard overall-view')">
                                <router-link to="/payroll" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Payroll</span></router-link>
                            </li>
                            <li @click="activate(4)" :class="{ active: active_el == 4 }"
                                v-if="hasPermission('Accounts Dashboard overall-view')">
                                <router-link to="/accounts" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Accounts</span>
                                </router-link>
                            </li>
                            <li @click="activate(76)" :class="{ active: active_el == 76 }"
                                v-if="hasPermission('Procurement Dashboard overall-view')">
                                <router-link to="/dashboards/procurement" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Procurement</span></router-link>
                            </li>
                        </ul>
                    </li>
                    <li class=" navigation-header">
                        <span>Human Resource </span><i data-feather="more-horizontal"></i>
                    </li>
                    <li class="nav-item has-sub" v-if="hasPermission('Recruitment')">
                        <a class="d-flex align-items-center">
                            <i class="fa-solid fa-user-check"></i>
                            <span class="menu-title text-truncate">Recruitment</span>
                        </a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('Recruitment job opening view')" @click="activate(6)"
                                :class="{ active: active_el == 6 }">
                                <router-link class="d-flex align-items-center" to="/recruitment/jobs">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate">Job openings</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Recruitment Candidates view')" @click="activate(7)"
                                :class="{ active: active_el == 7 }">
                                <router-link class="d-flex align-items-center" to="/recruitment/candidates">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate">Candidates</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Recruitment Interview view')" @click="activate(8)"
                                :class="{ active: active_el == 8 }">
                                <router-link class="d-flex align-items-center" to="/recruitment/interviews">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate">Interviews</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-sub">
                        <a v-if="hasPermission('HRMS')" class="d-flex align-items-center"><i
                                class="fa-solid fa-user-group"></i><span
                                class="menu-title text-truncate">HRMS</span></a>
                        <ul class="menu-content">
                            <li @click="activate(5)" :class="{ active: active_el == 5 }"
                                v-if="hasPermission('HRMS employees_detail overall-view')">
                                <router-link class="d-flex align-items-center" to="/hr/employees_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">Employees Detail</span>
                                </router-link>
                            </li>
                            <li @click="activate(9)" :class="{ active: active_el == 9 }"
                                v-if="hasPermission('HRMS warning_detail overall-view')">
                                <router-link to="/hr/warning_detail" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Warning
                                        Detail</span></router-link>
                            </li>
                            <!--                        <li @click="activate(10)" :class="{ active : active_el ==10 }"-->
                            <!--                            v-if="session_detail.hr_write=='true' && session_detail.company_hr_status=='true'">-->
                            <!--                            <router-link to="/hr/leaves_dashbaord" class="d-flex align-items-center"><i-->
                            <!--                                class="fa-regular fa-circle"></i><span-->
                            <!--                                class="menu-item text-truncate">Leaves Detail</span></router-link>-->
                            <!--                        </li>-->
                            <li @click="activate(75)" :class="{ active: active_el == 75 }"
                                v-if="hasPermission('HRMS Attendance overall-view')">
                                <router-link @click="activate(75)" class="d-flex align-items-center"
                                    to="/hr/live_attendance">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    <span class="menu-item text-truncate" data-i18n="Account Settings">Attendance</span>
                                </router-link>
                                <!-- <ul class="menu-content">
                                 <li @click="activate(75)" :class="{ active : active_el == 75}">
                                     <router-link class="d-flex align-items-center" to="/hr/live_attendance"><i class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Attendance Details</span></router-link>
                                 </li>
                             </ul>
                             <ul class="menu-content" v-if="session_detail.hr_write=='true' && session_detail.company_hr_status=='true'">
                                 <li @click="activate(11)" :class="{ active : active_el == 11}">
                                     <router-link class="d-flex align-items-center" to="/hr/live_devices"><i class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Devices</span></router-link>
                                 </li>
                             </ul>-->
                            </li>
                            <li @click="activate(75)" :class="{ active: active_el == 75 }" v-else>
                                <router-link v-if="hasPermission('HRMS Attendance overall-view')" @click="activate(75)"
                                    class="d-flex align-items-center" to="/hr/all_attendance">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    <span class="menu-item text-truncate" data-i18n="Account Settings">Attendance</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('HRMS leaves_detail overall-view')" @click="activate(10)"
                                :class="{ active: active_el == 10 }">
                                <router-link to="/hr/employee_all_leaves" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Leaves
                                        Detail</span></router-link>
                            </li>
                            <li @click="activate(12)" :class="{ active: active_el == 12 }"
                                v-if="hasPermission('HRMS HR-Reports  view')">
                                <router-link to="/hr/reports" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">HR
                                        Reports</span>
                                </router-link>
                            </li>
                            <li @click="activate(71)" :class="{ active: active_el == 71 }"
                                v-if="hasPermission('HRMS Organization_Cart  view')">
                                <router-link to="/hr/organization_cart" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Organization Chart</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="hasPermission('Payroll')" class="nav-item has-sub">
                        <a class="d-flex align-items-center">
                            <i class="fa-solid fa-money-check-dollar"></i><span class="menu-title text-truncate"
                                data-i18n="Invoice">Payroll</span>
                        </a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('Payroll Salary Management')" class="has-sub">
                                <a class="d-flex align-items-center" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    <span class="menu-item text-truncate" data-i18n="Account Settings">Salary
                                        Management</span></a>
                                <ul class="menu-content">
                                    <li v-if="hasPermission('Payroll Salary Processsing')" @click="activate(101)"
                                        :class="{ active: active_el == 101 }">
                                        <router-link class="d-flex align-items-center"
                                            to="/payroll/salary_generation"><i class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate">Salary Processing</span>
                                        </router-link>
                                    </li>
                                    <li v-if="hasPermission('Payroll employee Salary Details')" @click="activate(13)"
                                        :class="{ active: active_el == 13 }">
                                        <router-link class="d-flex align-items-center" to="/payroll/employees_detail"><i
                                                class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate">Emp. Salaries</span>
                                        </router-link>
                                    </li>
                                    <li v-if="hasPermission('Payroll employee Stipend Details')" @click="activate(66)"
                                        :class="{ active: active_el == 66 }">
                                        <router-link class="d-flex align-items-center" to="/pyroll/stipends"><i
                                                class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate">Emp. Stipend</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <!--                        <li @click="activate(13)" :class="{ active : active_el ==13 }">-->
                            <!--                            <router-link class="d-flex align-items-center" to="/payroll/salary_generation">-->
                            <!--                                <i class="fa-regular fa-circle"></i>-->
                            <!--                                <span class="menu-item text-truncate" data-i18n="List">Salaries</span>-->
                            <!--                            </router-link>-->
                            <!--                        </li>-->
                            <li v-if="hasPermission('Payroll Loan and Advance')" @click="activate(14)"
                                :class="{ active: active_el == 14 }">
                                <router-link class="d-flex align-items-center" to="/payroll/loans">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="List">Loan & Advance</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Payroll Dues Details')" @click="activate(63)"
                                :class="{ active: active_el == 63 }">
                                <router-link class="d-flex align-items-center" to="/payroll/dues">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate" data-i18n="List">Dues and Taxes</span>
                                </router-link>
                            </li>


                            <li v-if="hasPermission('Payroll Incentives')" class="has-sub">
                                <a class="d-flex align-items-center" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-circle">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    <span class="menu-item text-truncate"
                                        data-i18n="Account Settings">Incentives</span></a>
                                <ul class="menu-content">
                                    <li v-if="hasPermission('Payroll Arrears')" @click="activate(15)"
                                        :class="{ active: active_el == 15 }">
                                        <router-link class="d-flex align-items-center" to="/payroll/arrears">
                                            <i class="fa-regular fa-circle"></i>
                                            <span class="menu-item text-truncate">Arrears</span>
                                        </router-link>
                                    </li>
                                    <li v-if="hasPermission('Payroll Bonuses')" @click="activate(104)"
                                        :class="{ active: active_el == 104 }">
                                        <router-link class="d-flex align-items-center" to="/payroll/bonuses"><i
                                                class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate">Bonuses</span>
                                        </router-link>
                                    </li>
                                    <li v-if="hasPermission('Payroll Allowances')" @click="activate(69)"
                                        :class="{ active: active_el == 69 }">
                                        <router-link class="d-flex align-items-center" to="/payroll/allowance"><i
                                                class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate">Allowances</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <!--                        <li @click="activate(15)" :class="{ active : active_el ==15 }">-->
                            <!--                            <router-link class="d-flex align-items-center" to="/payroll/arrears">-->
                            <!--                                <i class="fa-regular fa-circle"></i>-->
                            <!--                                <span class="menu-item text-truncate">Incentives</span>-->
                            <!--                            </router-link>-->
                            <!--                        </li>-->
                            <li v-if="hasPermission('Payroll Final Settlement')" @click="activate(59)"
                                :class="{ active: active_el == 59 }">
                                <router-link class="d-flex align-items-center" to="/FinalSettlement">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate">Final Settlement</span>
                                </router-link>
                            </li>

                            <!--                        <li @click="activate(63)" :class="{ active : active_el ==63 }">-->
                            <!--                            <router-link class="d-flex align-items-center" to="/payroll/taxholding">-->
                            <!--                                <i class="fa-regular fa-circle"></i>-->
                            <!--                                <span class="menu-item text-truncate">Tax Holding</span>-->
                            <!--                            </router-link>-->
                            <!--                        </li>-->
                            <!--                        <li @click="activate(66)" :class="{ active : active_el ==66 }">-->
                            <!--                            <router-link class="d-flex align-items-center" to="/pyroll/stipends">-->
                            <!--                                <i class="fa-regular fa-circle"></i>-->
                            <!--                                <span class="menu-item text-truncate">Stipend</span>-->
                            <!--                            </router-link>-->
                            <!--                        </li>-->
                            <!--                        <li @click="activate(69)" :class="{ active : active_el ==69 }">-->
                            <!--                            <router-link class="d-flex align-items-center" to="/payroll/py_welfare_allowance">-->
                            <!--                                <i class="fa-regular fa-circle"></i>-->
                            <!--                                <span class="menu-item text-truncate">Welfare Allowance</span>-->
                            <!--                            </router-link>-->
                            <!--                        </li>-->
                        </ul>
                    </li>
                    <li v-if="hasPermission('Fuel')" class="nav-item has-sub">
                        <a class="d-flex align-items-center">
                            <i class="fa-solid fa-gas-pump"></i><span class="menu-title text-truncate"
                                data-i18n="Invoice">Fuel</span>
                        </a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('Fuel Setting')" @click="activate(65)"
                                :class="{ active: active_el == 65 }">
                                <router-link to="/payroll/allowances/fuel" class="d-flex align-items-center">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate">Fuel Settings</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Fuel bills')" @click="activate(64)"
                                :class="{ active: active_el == 64 }">
                                <router-link class="d-flex align-items-center" to="/payroll/fuelbills">
                                    <i class="fa-regular fa-circle"></i>
                                    <span class="menu-item text-truncate">Fuel Bills</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="hasPermission('HR Configuration')" class="nav-item has-sub">
                        <a class="d-flex align-items-center">
                            <i class="fa-solid fa-sliders"></i><span class="menu-title text-truncate">HR
                                Configurations</span>
                        </a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('HR Controller overall-view')" @click="activate(72)"
                                :class="{ active: active_el == 72 }">
                                <router-link to="/hr/configuration" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">HR
                                        Controller</span></router-link>
                            </li>
                            <li v-if="hasPermission('Department overall-view')" @click="activate(73)"
                                :class="{ active: active_el == 73 }">
                                <router-link to="/hr/departments" class="d-flex align-items-center"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Departments</span></router-link>
                            </li>
                            <li v-if="hasPermission('Designantion overall-view')" @click="activate(40)"
                                :class="{ active: active_el == 40 }">
                                <router-link class="d-flex align-items-center" to="/settings/designation_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">Designations</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Work Location overall-view')" @click="activate(39)"
                                :class="{ active: active_el == 39 }">
                                <router-link class="d-flex align-items-center" to="/settings/location_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">Work Locations</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="hasPermission('Purchase')" class=" navigation-header">
                        <span>Procurement</span><i data-feather="more-horizontal"></i>
                    </li>
                    <li v-if="hasPermission('Purchase')" class="nav-item has-sub">
                        <a class="d-flex align-items-center"><i class="fa-solid fa-basket-shopping"></i><span
                                class="menu-title text-truncate">Purchase</span></a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('Demand Requisition view')" @click="activate(70)"
                                :class="{ active: active_el == 70 }">
                                <router-link class="d-flex align-items-center" to="/purchase/demand_requisition"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Demand
                                        Requisition</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Purchase Requisition view')" @click="activate(27)"
                                :class="{ active: active_el == 27 }">
                                <router-link class="d-flex align-items-center" to="/purchase/requistion_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Purch.
                                        Requisition</span>
                                </router-link>
                            </li>
                            <!--<li v-if="(session_detail.UserType=='Owner' || session_detail.dept=='Procurement'||session_detail.dept=='Software Development') && (session_detail.accounts_write=='true' && session_detail.company_accounts_plan=='true')" @click="activate(63)" :class="{ active : active_el ==63}">
                                <router-link class="d-flex align-items-center" to="/ServiceBill"><i class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Service Bill</span></router-link>
                            </li>-->
                            <li v-if="hasPermission('Purchase Orders View')" @click="activate(22)"
                                :class="{ active: active_el == 22 }">
                                <router-link class="d-flex align-items-center" to="/purchase/detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Purchase
                                        Order</span></router-link>
                            </li>

                            <li @click="activate(51)" v-if="hasPermission('Services Invoice View')"
                                :class="{ active: active_el == 51 }">
                                <router-link class="d-flex align-items-center" to="/purchase_invoice/detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Services
                                        Invoice</span></router-link>
                            </li>
                            <li v-if="hasPermission('GRN View')" @click="activate(44)"
                                :class="{ active: active_el == 44 }">
                                <router-link class="d-flex align-items-center" to="/Inventory/GRN"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">GRN
                                        Detail</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Purchase Returns View')" @click="activate(46)"
                                :class="{ active: active_el == 46 }">
                                <router-link class="d-flex align-items-center" to="/purchase/return"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Purchase
                                        Return</span></router-link>
                            </li>
                        </ul>
                    </li>
                    <!-- <li v-if="(session_detail.dept=='Sales'||session_detail.dept=='Software Development') && (session_detail.accounts_write=='true' && session_detail.company_accounts_plan=='true')"
                    class="nav-item has-sub">
                    <a class="d-flex align-items-center"><i class="fa-solid fa-shop"></i><span
                        class="menu-title text-truncate">Sales</span></a>
                    <ul class="menu-content">

                        <li @click="activate(16)" :class="{ active : active_el ==16 }">
                            <router-link class="d-flex align-items-center" to="/sales/invoice_detail"><i
                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Invoices</span>
                            </router-link>
                        </li>
                        <li @click="activate(45)" :class="{ active : active_el ==45}">
                            <router-link class="d-flex align-items-center" to="/sales/return"><i
                                class="fa-regular fa-circle"></i><span
                                class="menu-item text-truncate">Sales Return</span></router-link>
                        </li>
                        <li @click="activate(20)" :class="{ active : active_el ==20}">
                            <router-link class="d-flex align-items-center" to="/sales/customer_details"><i
                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Customers</span>
                            </router-link>
                        </li>
                        <li @click="activate(21)" :class="{ active : active_el ==21}">
                            <router-link class="d-flex align-items-center" to="/sales/quotation_detail"><i
                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Quotation</span>
                            </router-link>
                        </li>
                    </ul>
                </li> -->

                    <li class="nav-item has-sub">
                        <a v-if="hasPermission('Inventory')" class="d-flex align-items-center"><i
                                class="fa-solid fa-warehouse"></i><span
                                class="menu-title text-truncate">Inventory</span></a>
                        <ul class="menu-content">
                            <li @click="activate(47)" :class="{ active: active_el == 47 }"
                                v-if="this.$helpers.hasPermission('Inventory StockDetail overall-view')">
                                <router-link class="d-flex align-items-center" to="/Inventory/Detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Stock
                                        Detail</span></router-link>
                            </li>
                            <li @click="activate(44)" :class="{ active: active_el == 44 }"
                                v-if="this.$helpers.hasPermission('Inventory Grn overall-view')">
                                <router-link class="d-flex align-items-center" to="/Inventory/GRN"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">GRN
                                        Detail</span>
                                </router-link>
                            </li>
                            <li @click="activate(48)" :class="{ active: active_el == 48 }"
                                v-if="this.$helpers.hasPermission('Inventory Issuance overall-view')">
                                <router-link class="d-flex align-items-center" to="/Inventory/Issuance"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Issuance
                                        Detail</span></router-link>
                            </li>
                            <li @click="activate(67)" :class="{ active: active_el == 67 }"
                                v-if="this.$helpers.hasPermission('Inventory Depreciation Assets-Depreciation')">
                                <router-link class="d-flex align-items-center" to="/Accounts/assets_depresciassion"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Assets
                                        Depreciation</span>
                                </router-link>
                            </li>
                            <li @click="activate(68)" :class="{ active: active_el == 68 }"
                                v-if="this.$helpers.hasPermission('Inventory Depreciation Assets-Book')">
                                <router-link class="d-flex align-items-center" to="/Accounts/assets_book"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Assets
                                        Book</span></router-link>
                            </li>
                            <li @click="activate(69)" :class="{ active: active_el == 69 }"
                                v-if="this.$helpers.hasPermission('Inventory Depreciation Assets-Retirement')">
                                <router-link class="d-flex align-items-center" to="/Accounts/assets_retirement"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Assets
                                        Retirement</span></router-link>
                            </li>

                            <li @click="activate(53)" :class="{ active: active_el == 53 }">
                                <router-link class="d-flex align-items-center" to="/Inventory/Issuance_return"
                                    v-if="this.$helpers.hasPermission('Inventory Issuance-return overall-view')"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Issuance
                                        Return</span></router-link>
                            </li>
                            <li @click="activate(19)" :class="{ active: active_el == 19 }"
                                v-if="this.$helpers.hasPermission('Inventory Products readOnly')">
                                <router-link class="d-flex align-items-center" to="/products_detail"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Products</span>
                                </router-link>
                            </li>
                            <li @click="activate(36)" :class="{ active: active_el == 36 }"
                                v-if="this.$helpers.hasPermission('Inventory Product-Categories readyOnly')">
                                <router-link class="d-flex align-items-center" to="/accounts/product_categories"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Product
                                        Categories</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="this.$helpers.hasPermission('Inventory Assets readyOnly')" @click="activate(52)"
                        :class="{ active: active_el == 52 }">
                        <router-link class="d-flex align-items-center" to="/accounts/assets_detail"><i
                                class="fa-solid fa-car"></i><span class="menu-item text-truncate">Assets Detail</span>
                        </router-link>
                    </li>

                    <li v-if="hasPermission('Inventory Account-Reports overall')" @click="activate(29)"
                        :class="{ active: active_el == 29 }">
                        <router-link to="/accounts/report" class="d-flex align-items-center"><i
                                class="fa-solid fa-chart-pie"></i><span class="menu-item text-truncate">Pro..
                                Reports</span>
                        </router-link>
                    </li>
                    <li v-if="hasPermission('Procurement Configurations')" class="nav-item has-sub">
                        <a class="d-flex align-items-center"><i class="fa-solid fa-sliders"></i><span
                                class="menu-title text-truncate">Pro.. Configurations</span></a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('Accounting procurement-configuration Delivery')"
                                @click="activate(50)" :class="{ active: active_el == 50 }">
                                <router-link class="d-flex align-items-center" to="/accounts/delivery"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Delivery</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Accounting procurement-configuration general')"
                                @click="activate(43)" :class="{ active: active_el == 43 }">
                                <router-link class="d-flex align-items-center" to="/accounts/config"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">General</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Accounting procurement-configuration vendors')"
                                @click="activate(26)" :class="{ active: active_el == 26 }">
                                <router-link class="d-flex align-items-center" to="/purchase/vendor_detail"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Vendors</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class=" navigation-header">
                        <span>Accounts</span><i data-feather="more-horizontal"></i>
                    <li class="nav-item has-sub">
                    <li v-if="hasPermission('Accounting')" class="nav-item has-sub">
                        <a class="d-flex align-items-center"><i class="fa-solid fa-receipt"></i><span
                                class="menu-title text-truncate">Accounting</span></a>
                        <ul class="menu-content">


                            <li @click="activate(28)" :class="{ active: active_el == 28 }"
                                v-if="this.$helpers.hasPermission('Accounting journal_voucher overall-view')">
                                <router-link class="d-flex align-items-center" to="/accounting/journal_voucher"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Journals</span></router-link>
                            </li>
                            <li @click="activate(18)" :class="{ active: active_el == 18 }"
                                v-if="this.$helpers.hasPermission('Accounting Receipt-voucher overall-view')">
                                <router-link class="d-flex align-items-center" to="/sales/received_voucher_detail">
                                    <i class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Receipt
                                        Voucher</span>
                                </router-link>
                            </li>
                            <li @click="activate(24)" :class="{ active: active_el == 24 }"
                                v-if="this.$helpers.hasPermission('Accounting Payment-voucher overall-view')">
                                <router-link class="d-flex align-items-center" to="/purchase/payment_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Payments
                                        Voucher</span>
                                </router-link>
                            </li>

                            <li @click="activate(55)" :class="{ active: active_el == 55 }"
                                v-if="this.$helpers.hasPermission('Accounting pettycash_access overall-view')">
                                <router-link class="d-flex align-items-center" to="/Accounts/PettyCash"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">PettyCash
                                        Access</span>
                                </router-link>
                            </li>
                            <li @click="activate(57)" :class="{ active: active_el == 57 }"
                                v-if="this.$helpers.hasPermission('Accounting petty-cash overall-view')">
                                <router-link class="d-flex align-items-center" to="/petty_cash/detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Petty
                                        Cash</span>
                                </router-link>
                            </li>
                            <li @click="activate(69)" :class="{ active: active_el == 69 }"
                                v-if="this.$helpers.hasPermission('Accounting debit-notes overall-view')">
                                <router-link class="d-flex align-items-center" to="/purchase/debit_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Debit
                                        Notes</span>
                                </router-link>
                            </li>

                        </ul>
                    </li>
                    </li>
                    </li>
                    <li class="has-sub " v-if="hasPermission('Units-Management units-data readOnly')">

                        <a class="d-flex align-items-center"><i class="fa-solid fa-receipt"></i><span
                                class="menu-title text-truncate">Units data</span></a>
                        <ul class="menu-content">
                            <li @click="activate(62)" :class="{ active: active_el == 62 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/cash_counter"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Daily
                                        Counter</span>
                                </router-link>
                            </li>
                            <li @click="activate(58)" :class="{ active: active_el == 58 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/booking"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Units
                                        Booking</span>
                                </router-link>
                            </li>
                            <li @click="activate(59)" :class="{ active: active_el == 59 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/dealer_voucher"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Units
                                        Dealer Voucher</span>
                                </router-link>
                            </li>
                            <li @click="activate(60)" :class="{ active: active_el == 60 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/pending_services"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Units
                                        Services</span>
                                </router-link>
                            </li>
                            <li @click="activate(61)" :class="{ active: active_el == 61 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/pending_electricity"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Units
                                        Electricity</span>
                                </router-link>
                            </li>
                            <li @click="activate(63)" :class="{ active: active_el == 63 }">
                                <router-link class="d-flex align-items-center" to="/purchase/units_refund">
                                    <i class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Refund /
                                        Cancellation</span>
                                </router-link>
                            </li>
                            <li @click="activate(56)" :class="{ active: active_el == 56 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/units_controller"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Units
                                        Configurations</span>
                                </router-link>
                            </li>
                            <li @click="activate(71)" :class="{ active: active_el == 71 }">
                                <router-link class="d-flex align-items-center" to="/accounts/land_payment_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Land
                                        Payment Module</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="hasPermission('Inventory Account-Reports overall')" @click="activate(74)"
                        :class="{ active: active_el == 74 }">
                        <router-link to="/accounts/report" class="d-flex align-items-center"><i
                                class="fa-solid fa-chart-pie"></i><span class="menu-item text-truncate">Accounts
                                Reports</span>
                        </router-link>
                    </li>
                    <li v-if="hasPermission('Accounts Configurations')" class="nav-item has-sub">
                        <a class="d-flex align-items-center"><i class="fa-solid fa-sliders"></i><span
                                class="menu-title text-truncate">Acc.. Configurations</span></a>
                        <ul class="menu-content">
                            <li v-if="hasPermission('Accounts Configurations bank-detail')" @click="activate(31)"
                                :class="{ active: active_el == 31 }">
                                <router-link class="d-flex align-items-center" to="/accounts/banksdetail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Banks
                                        Detail</span></router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations COA')" @click="activate(32)"
                                :class="{ active: active_el == 32 }">
                                <router-link class="d-flex align-items-center" to="/accounts/chart_of_accounts"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">COA</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations payment terms')" @click="activate(30)"
                                :class="{ active: active_el == 30 }">
                                <router-link class="d-flex align-items-center" to="/accounts/payment_terms"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Payment
                                        Terms</span></router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations  taxes')" @click="activate(33)"
                                :class="{ active: active_el == 33 }">
                                <router-link class="d-flex align-items-center" to="/accounts/taxes"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Taxes</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations Accounts heads')" @click="activate(34)"
                                :class="{ active: active_el == 34 }">
                                <router-link class="d-flex align-items-center" to="/accounts/heads_types"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate">Acc.
                                        Heads/Types</span></router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations  session')" @click="activate(37)"
                                :class="{ active: active_el == 37 }">
                                <router-link class="d-flex align-items-center" to="/accounts/sessions"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Session</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations  general')" @click="activate(43)"
                                :class="{ active: active_el == 43 }">
                                <router-link class="d-flex align-items-center" to="/accounts/config"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">General</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Accounts Configurations  department access')" @click="activate(54)"
                                :class="{ active: active_el == 54 }">
                                <router-link class="d-flex align-items-center" to="/Accounts/user_base_access"><i
                                        class="fa-regular fa-circle"></i><span
                                        class="menu-item text-truncate">Departments Access</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class=" navigation-header">
                        <span>Admin Settings</span><i data-feather="more-horizontal"></i>
                    </li>
                    <li v-if="hasPermission('Settings')" class="nav-item has-sub">
                        <a class="d-flex align-items-center"><i class="fa-solid fa-gear"></i><span
                                class="menu-title text-truncate" data-i18n="Settings">Settings</span></a>
                        <ul class="menu-content">

                            <li v-if="hasPermission('User Details oervall-view')" @click="activate(38)"
                                :class="{ active: active_el == 38 }">
                                <router-link class="d-flex align-items-center" to="/settings/users"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">Users Detail</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('AC Department oervall-view')" @click="activate(41)"
                                :class="{ active: active_el == 41 }">
                                <router-link class="d-flex align-items-center" to="/settings/department_detail"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">AC. Departments</span>
                                </router-link>
                            </li>
                            <li v-if="hasPermission('Activity Log oervall-view')" @click="activate(42)"
                                :class="{ active: active_el == 42 }">
                                <router-link class="d-flex align-items-center" to="/settings/activity_log"><i
                                        class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                        data-i18n="List">Activity Logs</span>
                                </router-link>
                            </li>
                        </ul>

                    </li>


                    <li v-if="hasPermission('Admin')" class="nav-item has-sub">
                        <a v-if="hasPermission('Admin')" class="d-flex align-items-center mb-2"><i
                                class="fas fa-user-shield"></i><span class="menu-title text-truncate"
                                data-i18n="Settings">Admin</span></a>

                        <ul class="menu-content">
                            <li v-if="hasPermission('Admin Club Management View ClubManagement Tab')"
                                class="nav-item has-sub">
                                <a v-if="hasPermission('Admin Club Management View ClubManagement Tab')"
                                    class="d-flex align-items-center"><i class="fas fa-user-shield"></i><span
                                        class="menu-title text-truncate" data-i18n="Settings">Club Management</span></a>

                                <ul class="menu-content">
                                    <li v-if="hasPermission('Admin Club Management View Create Club Tab')"
                                        @click="activate(77)" :class="{ active: active_el == 77 }">
                                        <router-link class="d-flex align-items-center" to="/admin/clubRegister"><i
                                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                                data-i18n="List">Create Club</span></router-link>
                                    </li>
                                    <li v-if="hasPermission('Admin Club Management View Register Member Tab')"
                                        @click="activate(78)" :class="{ active: active_el == 78 }">
                                        <router-link class="d-flex align-items-center" to="/admin/memberRegister"><i
                                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                                data-i18n="List">Register Member</span></router-link>
                                    </li>
                                    <li v-if="hasPermission('Admin Club Management View Club Member Fees Tab')"
                                        @click="activate(79)" :class="{ active: active_el == 79 }">
                                        <router-link class="d-flex align-items-center" to="/admin/clubMembersFee"><i
                                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                                data-i18n="List">Club Members Fee</span></router-link>
                                    </li>

                                    <li v-if="hasPermission('Admin Club Management View Member Fees Tab')"
                                        @click="activate(80)" :class="{ active: active_el == 80 }">
                                        <router-link class="d-flex align-items-center" to="/admin/membersFees"><i
                                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate"
                                                data-i18n="List">Members Fee</span></router-link>
                                    </li>
                                    <!-- <li v-if="session_detail.dept=='Software Development'" class="nav-item has-sub">
                    <a class="d-flex align-items-center"><i class="fa-solid fa-gear"></i><span
                        class="menu-title text-truncate" data-i18n="Settings">Create Roles & permissions</span></a>
                    <ul class="menu-content">
                        <li @click="activate(43)" :class="{ active : active_el ==43}">
                            <router-link class="d-flex align-items-center" to="/settings/rolesPermissions"><i
                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate" data-i18n="List">Roles & Permissions</span>
                            </router-link>
                        </li>
                        <li @click="activate(99)" :class="{ active : active_el ==99}">
                            <router-link class="d-flex align-items-center" to="/settings/CreateRoles"><i
                                class="fa-regular fa-circle"></i><span class="menu-item text-truncate" data-i18n="List">Create Roles</span>
                            </router-link>
                        </li>

                    </ul>

                </li> -->

                                </ul>
                            <li class="nav-item has-sub">
                                <a class="d-flex align-items-center mb-2"><i class="fas fa-user-shield"></i><span
                                        class="menu-title text-truncate" data-i18n="Settings">Roles &
                                        Permission</span></a>
                                <ul class="menu-content">


                                    <li @click="activate(43)" :class="{ active: active_el == 43 }">
                                        <router-link class="d-flex align-items-center"
                                            to="/settings/rolesPermissions"><i class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate" data-i18n="List">List Roles</span>
                                        </router-link>
                                    </li>
                                    <li @click="activate(99)" :class="{ active: active_el == 99 }">
                                        <router-link class="d-flex align-items-center mb-2"
                                            to="/settings/CreateRoles"><i class="fa-regular fa-circle"></i><span
                                                class="menu-item text-truncate" data-i18n="List">Create Roles</span>
                                        </router-link>
                                    </li>

                                </ul>


                            </li>
                        </ul>

                    </li>
                </ul>
            </div>
        </div>
        <!-- END: Main Menu-->
</template>

<script>

export default {


    data() {
        return {
            menuClass: 'main-menu menu-fixed menu-accordion menu-shadow expanded menu-light',
            active_el: 0,
            session_detail: {},
        }
    },
    computed: {
        //     hasPermission(permission) {
        //   return hasPermission(permission);
        // },
    },
    methods: {
        activate: function (el) {
            this.active_el = el;
        }
    },
    mounted() {
        const cachedData = localStorage.getItem('session_detail');

        if (cachedData) {
            // Use the cached data
            this.session_detail = JSON.parse(cachedData);
        } else {
            // Fetch the data from the API
            axios.get('./session_check')
                .then((response) => {
                    // Set the data in your component
                    this.session_detail = response.data;

                    // Store the data in local storage for future use
                    localStorage.setItem('session_detail', JSON.stringify(response.data));
                })
                .catch((error) => console.log(error));
        }
    }

}
</script>
<style>
.menu-dark {
    background-color: #283046;
}
</style>
