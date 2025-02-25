<template>
    <nav
        class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl rounded-4">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle is-active" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-menu ficon">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                    <li class="nav-item dropdown dropdown-user">

                        <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="avatar">
                                <img class="round" v-if="this.fetchimage == ''" src="public/images/profile_images/pro.png"
                                    alt="avatar" height="40" width="40">
                                <img class="round" v-else v-bind:src="`public/images/profile_images/${this.fetchimage}`"
                                    alt="avatar" height="40" width="40">

                                <span v-if="checkConnection" class="avatar-status-online" title="You are online"></span>
                                <span v-else class="avatar-status-busy" title="You are offline"></span>
                            </span>
                            <div class="user-nav d-sm-flex d-none align-items-baseline p-1">
                                <span class="user-name fw-bolder text-start">{{ user_session.first_name }} {{
                                    user_session.last_name }}</span><span class="user-status">{{ user_session.user_role
                                    }}</span>
                            </div>
                            <!-- <span class="avatar">
                                <img class="round" v-if="this.fetchimage == ''" src="public/images/profile_images/pro.png"
                                    alt="avatar" height="40" width="40">
                                <img class="round" v-else v-bind:src="`public/images/profile_images/${this.fetchimage}`"
                                    alt="avatar" height="40" width="40">

                                <span v-if="checkConnection" class="avatar-status-online" title="You are online"></span>
                                <span v-else class="avatar-status-busy" title="You are offline"></span>
                            </span> -->
                        </a>
                        <div style="width:230px;" class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="dropdown-user">
                            <a v-b-modal.modal-profile class="dropdown-item"><i class="me-50" data-feather="user"></i>
                                Profile</a>
                            <a class="dropdown-item" href="app-email.html"><i class="me-50" data-feather="mail"></i>
                                Inbox</a>
                            <router-link class="dropdown-item" to="/calander"><i class="me-50"
                                    data-feather="check-square"></i> Task
                            </router-link>
                            <router-link to="/chat" class="dropdown-item"><i class="me-50"
                                    data-feather="message-square"></i> Chats
                            </router-link>
                            <div class="dropdown-divider"></div>
                            <a @click="send_update()" class="dropdown-item"><i class="me-50"
                                    data-feather="message-square"></i>Send
                                update notification</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" v-b-modal.modal-pass><i class="me-50" data-feather="settings"></i>
                                Change Password</a>
                            <router-link class="dropdown-item" to="/FAQs"><i class="me-50"
                                    data-feather="help-circle"></i>
                                FAQs
                            </router-link>
                            <button @click="logout()" style="width:100%" class="dropdown-item"><i class="me-50"
                                    data-feather="power"></i>
                                Logout
                            </button>
                        </div>
                    </li>
                    <!-- <li class="nav-item d-none d-lg-block"><router-link to="/chat" class="nav-link" href="app-chat.html"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Chat"
                            aria-label="Chat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-message-square ficon">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </router-link></li>
                    <li class="nav-item d-none d-lg-block"><router-link to="/calander" class="nav-link"
                            href="app-calendar.html" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                            data-bs-original-title="Calendar" aria-label="Calendar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-calendar ficon">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </router-link></li> -->
                </ul>
            </div>
            <!--            <div class="bookmark-wrapper d-flex align-items-center">-->
            <!--                <ul class="nav navbar-nav d-xl-none">-->
            <!--                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>-->
            <!--                </ul>-->
            <!--                <ul class="nav navbar-nav bookmark-icons">-->
            <!--                    <li class="nav-item d-none d-lg-block">-->
            <!--                        <h4 style="font-family: 'Share Tech Mono', monospace; background: url('public/images/clock-frame.png'); background-repeat: no-repeat; background-size: 95px 26px; opacity:0.6;" class="fw-bolder"><span style="font-size: 17px; margin-left: 9px; padding-right: 10px">{{time}}</span></h4>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </div>-->
            <ul class="nav navbar-nav align-items-center ms-auto ">
                <li class="nav-item d-none d-lg-block"><a @click="setLayout()" class="nav-link nav-link-style"><i
                            class="ficon" data-feather="moon"></i></a></li>

                <!-- <li class="nav-item" :title="'Wind: '+windspeed+', Humidity: '+humidity">
                    <a class="nav-link nav-link-style">
                        <img class="img-fluid" :src="`https://openweathermap.org/img/wn/${icon}`" height="30"
                             width="30"/>
                        {{ Math.floor(temp - 273.15) }}°C, {{ desc }}
                    </a>
                </li> -->
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link nav-link-style">
                        <i class="fa-solid fa-location-dot"></i> {{ city }}, {{ country }}
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-notification me-25">
                    <a class="nav-link" href="#" data-bs-toggle="dropdown">
                        <i class="ficon" data-feather="bell"></i>
                        <span v-if="notifications.status == 3" class="badge rounded-pill bg-danger badge-up">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                        <li class="dropdown-menu-header">
                            <div class="dropdown-header d-flex">
                                <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                                <div v-if="notifications.status == 3" class="badge rounded-pill badge-light-primary">1
                                    New
                                </div>
                                <div v-else class="badge rounded-pill badge-light-primary">0 New</div>
                            </div>
                        </li>
                        <li v-if="notifications.status == 3" class="scrollable-container media-list">
                            <a class="d-flex" href="#">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar" v-for='emp_detail1 in emp_detail'>
                                            <img v-bind:src="`public/images/profile_images/${notifications.sender}`"
                                                alt="avatar" width="32" height="32">
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">Application updated
                                                🎉</span>yahooo!
                                        </p><small>Hi {{ user_session.first_name }} {{ user_session.last_name }}, I just
                                            made an update, Please clear your cache to install this update</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li v-if="notifications.status == 3" class="dropdown-menu-footer row">
                            <button @click="delay2()" :disabled="disabled2" class="btn btn-success w-75">I have cleared
                                my cache
                            </button>
                            <button @click="delay3()" :disabled="disabled2" class="btn btn-warning w-25">Skip</button>
                        </li>
                    </ul>
                </li>
                <!-- <li class="nav-item dropdown dropdown-user">

                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span
                            class="user-name fw-bolder">{{ user_session.first_name }} {{ user_session.last_name }}</span><span
                            class="user-status">{{ user_session.user_role }}</span></div>
                        <span class="avatar">
                            <img class="round" v-if="this.fetchimage==''" src="public/images/profile_images/pro.png"
                                 alt="avatar" height="40" width="40">
                            <img class="round" v-else v-bind:src="`public/images/profile_images/${this.fetchimage}`"
                                 alt="avatar" height="40" width="40">

                            <span v-if="checkConnection" class="avatar-status-online" title="You are online"></span>
                            <span v-else class="avatar-status-busy" title="You are offline"></span>
                        </span>
                    </a>
                    <div style="width:230px;" class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a v-b-modal.modal-profile class="dropdown-item"><i class="me-50" data-feather="user"></i>
                            Profile</a>
                        <a class="dropdown-item" href="app-email.html"><i class="me-50" data-feather="mail"></i>
                            Inbox</a>
                        <router-link class="dropdown-item" to="/calander"><i class="me-50"
                                                                             data-feather="check-square"></i> Task
                        </router-link>
                        <router-link to="/chat" class="dropdown-item"><i class="me-50"
                                                                         data-feather="message-square"></i> Chats
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a @click="send_update()" class="dropdown-item"
                          ><i class="me-50"
                                                                               data-feather="message-square"></i>Send
                            update notification</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" v-b-modal.modal-pass><i class="me-50" data-feather="settings"></i>
                            Change Password</a>
                        <router-link class="dropdown-item" to="/FAQs"><i class="me-50" data-feather="help-circle"></i>
                            FAQs
                        </router-link>
                        <button @click="logout()" style="width:100%" class="dropdown-item"><i class="me-50"
                                                                                              data-feather="power"></i>
                            Logout
                        </button>
                    </div>
                </li> -->
                <li class="nav-item d-none d-lg-block"><router-link to="/calander" class="nav-link"
                        href="app-calendar.html" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                        data-bs-original-title="Calendar" aria-label="Calendar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-calendar ficon">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </router-link></li>
                <li class="nav-item d-none d-lg-block"><router-link to="/chat" class="nav-link" href="app-chat.html"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Chat"
                        aria-label="Chat">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-message-square ficon">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </router-link></li>

            </ul>
            <b-modal id="modal-pass" size="md" title="Change your Password" hide-footer>
                <div class="auth-login-form mt-2">
                    <div v-if="this.old_success == '0'">
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Old Password</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input v-bind:type="[showPassword1 ? 'text' : 'password']" v-model="oldPass"
                                    type="password" class="form-control form-control-merge"
                                    placeholder="Type Password Here" />
                                <span class="input-group-text cursor-pointer" @click="showPassword1 = !showPassword1">
                                    <i v-if="this.showPassword1 == false" class="fa-regular fa-eye"></i>
                                    <i v-else class="fa-regular fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div v-if="this.e_oldPass == 'Password must not be empty'"
                            style="margin-top:5px;margin-bottom:5px;">
                            <p class="alert alert-danger"
                                style="padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px">
                                {{ e_oldPass }}</p>
                        </div>
                        <div v-if="this.e_oldPass == 'Password not exist!'" style="margin-top:5px;margin-bottom:5px;">
                            <p class="alert alert-danger"
                                style="padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px">
                                {{ e_oldPass }}</p>
                        </div>
                        <button :disabled="disabled" @click="delay()" v-if="this.old_success == '0'"
                            class="btn btn-primary w-100" tabindex="4">Confirm
                        </button>
                    </div>

                    <div v-if="this.old_success == '1'">
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">New Password</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input v-bind:type="[showPassword2 ? 'text' : 'password']" v-model="newPass1"
                                    type="password" class="form-control form-control-merge"
                                    placeholder="Type Password Here" />
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Confirm New Password</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input v-bind:type="[showPassword2 ? 'text' : 'password']" v-model="newPass2"
                                    type="password" class="form-control form-control-merge"
                                    placeholder="Type Password Here" />
                                <span class="input-group-text cursor-pointer" @click="showPassword2 = !showPassword2">
                                    <i v-if="this.showPassword2 == false" class="fa-regular fa-eye"></i>
                                    <i v-else class="fa-regular fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div v-if="this.e_newPass1 == 'New password must not be empty'"
                            style="margin-top:5px;margin-bottom:5px;">
                            <p class="alert alert-danger"
                                style="padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px">
                                {{ e_newPass1 }}</p>
                        </div>
                        <div v-if="this.newPass1 != '' && this.e_newPass2 == 'Confirm with same password'"
                            style="margin-top:5px;margin-bottom:5px;">
                            <p class="alert alert-danger"
                                style="padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px">
                                {{ e_newPass2 }}</p>
                        </div>
                        <b-button :disabled="disabled1" @click="delay1()" v-if="this.old_success == '1'"
                            class="btn btn-primary w-100" tabindex="4" data-bs-dismiss="b-modal"
                            style="background-color: #6258cc !important ">Change
                        </b-button>
                    </div>
                </div>
            </b-modal>
            <b-modal id="modal-profile" size="xl" title="Your Personal Profile" ok-only>
                <div class="content-wrapper container-xxl p-0"
                    style="height:500px; overflow-y:scroll; overflow-x:hidden;">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <b-progress
                                :value="percent.address + percent.city + percent.cnic + percent.company_email + percent.department + percent.designation + percent.dob + percent.edu_status + percent.email + percent.emp_code + percent.exp_status + percent.father + percent.gender + percent.job_des + percent.marital + percent.mobile + percent.photo + percent.reporting"
                                variant="success"
                                :label="`${(((percent.address + percent.city + percent.cnic + percent.company_email + percent.department + percent.designation + percent.dob + percent.edu_status + percent.email + percent.emp_code + percent.exp_status + percent.father + percent.gender + percent.job_des + percent.marital + percent.mobile + percent.photo + percent.reporting) / max) * 100).toFixed(0)}%`"
                                :striped="striped" animated class="mb-3">
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
                                                    <img v-if="emp_detail1.Photo == ''"
                                                        class="img-fluid rounded mt-3 mb-2"
                                                        src="public/images/profile_images/pro.png" height="110"
                                                        width="110" alt="User avatar" />
                                                    <img v-else class="img-fluid rounded mt-3 mb-2"
                                                        v-bind:src="`public/images/profile_images/${emp_detail1.Photo}`"
                                                        height="110" width="110" alt="User avatar" />
                                                    <div class="user-info text-center">
                                                        <h4>{{ emp_detail1.Name }}</h4>
                                                        <span class="badge bg-light-secondary">{{
                                                            emp_detail1.Designation }}</span>
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
                                                        <h4 class="mb-0">{{ com_year }}</h4>
                                                        <small>Years Completed</small>
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
                                                                percent.company_email + percent.department +
                                                                percent.designation + percent.dob + percent.edu_status +
                                                                percent.email + percent.emp_code + percent.exp_status +
                                                                percent.father + percent.gender + percent.job_des +
                                                                percent.marital + percent.mobile + percent.photo +
                                                                percent.reporting }}%</h4>
                                                        <small>Profile</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
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
                                                        <span class="badge bg-light-success">{{ emp_detail1.Status
                                                            }}</span>
                                                    </li>
                                                </ul>
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
                                                    <sup class="h5 pricing-currency text-primary mt-1 mb-0">Rs.</sup>
                                                    <span class="fw-bolder display-5 mb-0 text-primary"
                                                        style="font-size:18px">{{ emp_detail1.Salary }}</span>
                                                    <sub
                                                        class="pricing-duration font-small-4 ms-25 mt-auto mb-2">/month</sub>
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
                                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

                                    <div v-for='emp_detail1 in emp_detail' class="card">
                                        <div class="card-header">
                                            <div style="float:left">
                                                <h4 class="card-title mb-50">Complete Details</h4>
                                            </div>
                                            <div style="float:right">
                                                <a v-if="percent.address + percent.city + percent.cnic + percent.company_email + percent.department + percent.designation + percent.dob + percent.edu_status + percent.email + percent.emp_code + percent.exp_status + percent.father + percent.gender + percent.job_des + percent.marital + percent.mobile + percent.photo + percent.reporting > 89"
                                                    target="_blank"
                                                    v-bind:href="`../sa_sass1.1/cv_builder/${emp_detail1.EmployeeID}/${emp_detail1.EmployeeCode}/${emp_detail1.RegisterID}`"
                                                    class="btn btn-primary btn-sm edit-address waves-effect waves-float waves-light">
                                                    CV Builder
                                                </a>
                                                <a v-else target="_blank" href="#"
                                                    class="btn btn-primary btn-sm edit-address waves-effect waves-float waves-light">
                                                    CV Builder
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-6 col-12">
                                                    <dl class="row mb-0">
                                                        <dt class="col-sm-6 fw-bolder mb-1">Employee Code:</dt>
                                                        <dd class="col-sm-6 mb-1">{{ emp_detail1.EmployeeCode }}</dd>
                                                        <dt class="col-sm-6 fw-bolder mb-1">Reporting To:</dt>
                                                        <dd class="col-sm-6 mb-1">
                                                            <label>
                                                                {{ rep_employees.rep1 }}
                                                            </label>
                                                        </dd>
                                                        <dt class="col-sm-6 fw-bolder mb-1">Posting City:</dt>
                                                        <dd class="col-sm-6 mb-1">{{ emp_detail1.PostingCity }}</dd>
                                                        <dt class="col-sm-6 fw-bolder mb-1">Com. Email:</dt>
                                                        <dd class="col-sm-6 mb-1">{{ emp_detail1.CompanyEmail }}</dd>
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
                                                        <dd v-if="emp_detail1.EportalAccess == 1" class="col-sm-6 mb-1">
                                                            Allow
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
                                                        <dd class="col-sm-7 mb-1">{{ emp_detail1.ProbationEnd }}</dd>
                                                        <dt class="col-sm-5 fw-bolder mb-1">Blood Group:</dt>
                                                        <dd class="col-sm-7 mb-1">{{ emp_detail1.BloodGroup }}</dd>
                                                        <dt class="col-sm-5 fw-bolder mb-1">CNIC Expiry:</dt>
                                                        <dd class="col-sm-7 mb-1">{{ emp_detail1.CnicExpiry }}</dd>
                                                        <dt class="col-sm-5 fw-bolder mb-1">Job Status:</dt>
                                                        <dd class="col-sm-7 mb-1">{{ emp_detail1.JobStatus }}</dd>
                                                        <dt class="col-sm-5 fw-bolder mb-1">Phone Number:</dt>
                                                        <dd class="col-sm-7 mb-1">{{ emp_detail1.Mobile }}</dd>
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
                                        <div class="table-responsive">
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
                                                                exp_detail1.StartingDate }} to {{
                                                                    exp_detail1.LeavingDate }}</span>
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
                                        </div>
                                    </div>
                                    <div class="card">
                                        <h4 class="card-header">Remarks</h4>
                                        <div class="card-body pt-1" v-for="emp_detail1 in emp_detail">
                                            <label v-html='emp_detail1.remarks'></label>
                                        </div>
                                    </div>
                                    <!-- /Activity Timeline -->
                                </div>
                                <!--/ User Content -->
                            </div>
                        </section>
                    </div>
                </div>
            </b-modal>
        </div>
    </nav>
</template>
<script>
export default {
    data() {
        return {
            status: '',
            checkConnection: '',
            time: '',

            weather: [],
            city: '',
            desc: '',
            temp: '',
            humidity: '',
            country: '',
            sunrise: '',
            sunset: '',
            windspeed: '',
            icon: '',

            url: window.location.href,
            url_s1: '',
            url_s2: '',

            any_notification: '',
            notifications: {},
            online: {},
            timer: null,

            user_session: {},
            exp_detail: {},
            edu_detail: {},
            emp_detail: {},
            rep_employees: {},
            percent: {},
            com_year: '',
            fetchimage: '',
            com_year: '',
            striped: true,

            max: 100,
            oldPass: '',
            newPass1: '',
            newPass2: '',
            e_oldPass: '',
            e_newPass1: '',
            e_newPass2: '',
            showPassword1: false,
            showPassword2: false,

            old_success: '0',

            disabled: false,
            timeout: null,

            disabled1: false,
            timeout1: null,

            disabled2: false,
            timeout2: null,
            timeout4: null,
        }
    },
    methods: {
        online_fn() {
            this.checkConnection = navigator.onLine;
            this.timeout = setTimeout(() => {
                this.online_fn();
            }, 1000)
        },
        updateTime() {
            var cd = new Date();
            this.time = this.zeroPadding(cd.getHours(), 2) + ':' + this.zeroPadding(cd.getMinutes(), 2) + ':' + this.zeroPadding(cd.getSeconds(), 2);
            this.delay4();
        },
        zeroPadding(num, digit) {
            var zero = '';
            for (var i = 0; i < digit; i++) {
                zero += '0';
            }
            return (zero + num).slice(-digit);
        },
        delay4() {
            this.timeout4 = setTimeout(() => {
                this.updateTime();
            }, 1000)
        },
        get_ip() {
            this.url_s1 = this.url.split('/');
            this.url_s2 = this.url_s1[0] + '//' + this.url_s1[2] + '/' + this.url_s1[3];
        },
        delay() {
            this.disabled = true
            this.confirm_old_pass()
            if (this.old_success == '0') {
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
            } else if (this.old_success == '1') {
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
            }
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.change_pass()
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)

            axios.post('./cache_cleared', {})
                .then(data => {
                    axios.get('./is_cleared')
                        .then((response) => this.notifications = response.data)
                    this.$toastr.s(data.data, "Success!");
                })
        },
        delay3() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
        },
        send_update() {

            axios.post('./send_update', {})
                .then(data => {
                    this.$toastr.s(data.data, "Success!");
                })
        },
        change_pass() {
            if (this.newPass1 == '' || this.newPass1 != this.newPass2) {
                if (this.newPass1 == '') {
                    this.e_newPass1 = "New password must not be empty";
                } else {
                    this.e_newPass1 = "";
                }
                if (this.newPass1 != this.newPass2) {
                    this.e_newPass2 = "Confirm with same password";
                } else {
                    this.e_oldPass = "";
                }
                this.$toastr.e("Please enter password properly!", "Caution!");
            } else {

                axios.post('./change_Pass', {
                    newPass1: this.newPass1,
                    newPass2: this.newPass2,
                })
                    .then(data => {
                        if (data.data == 'Password changed!') {

                            this.logout();

                        } else {
                            this.$toastr.e("Password not changed!", "Caution!");
                        }
                    })


            }
        },
        confirm_old_pass() {
            if (this.oldPass == '') {
                this.e_oldPass = "Password must not be empty";
            } else {
                this.e_oldPass = "";
                axios.post('./confirm_oldPass', {
                    oldPass: this.oldPass,
                })
                    .then(data => {
                        if (data.data == 'Password exist!') {
                            this.$toastr.s("Old password is matched!", "Success!");
                            this.oldPass = "";
                            this.old_success = "1";
                        } else if (data.data == 'Password not exist!') {
                            this.$toastr.e("Invalid old password!", "Caution!");
                            this.e_oldPass = data.data;
                            this.old_success = "0";
                        }
                    })


            }

        },
        logout() {
            axios.get('./logout')
                .then(
                    response => {
                        // Clear the local storage
                        localStorage.clear();

                        window.location.reload();

                        this.$toastr.i("Logout Successfully");

                    })
                .catch((error) => console.log(error));
        },
        locator() {
            var lat = '31.7247';
            var lon = '74.2668';
            fetch('https://api.openweathermap.org/data/2.5/weather?lat=' + lat + '&lon=' + lon + '&appid=3c2628d86ecd093a44e4d450b2c22df9', {
                method: 'GET'
            })
                .then((responce) => responce.json())
                .then((data) => {
                    this.weather = data;
                    this.city = data.name;
                    this.country = data.sys.country;
                    this.desc = data.weather[0].main;
                    this.temp = data.main.temp;
                    this.humidity = data.main.humidity + '%';
                    this.windspeed = ((data.wind.speed) * (3.6)).toFixed(0) + 'km/h';
                    this.icon = data.weather[0].icon + '.png';
                },
                    error => {
                        console.log(error.message);
                    },
                )
        },
    },
    mounted() {
        this.online_fn();
        this.locator();
        this.get_ip();
        this.delay4();
        axios.get('./is_cleared')
            .then((response) => this.notifications = response.data)

        axios.get('getindemployee_detail/' + 0)
            .then(data => {
                this.emp_detail = data.data.data;
                var g = data.data.data[0].JoiningDate.split('-');
                this.com_year = new Date().getFullYear() - new Date(g[0] + "-" + g[1] + "-" + g[2]).getFullYear()
            })
        axios.get('getemployee_education/' + 0)
            .then(data => {
                this.edu_detail = data.data.data;
            })
        axios.get('getemployee_exp/' + 0)
            .then(data => {
                this.exp_detail = data.data.data;
            })

        axios.get('reporting_employees/' + 0)
            .then(data => {
                this.rep_employees = data.data.data;
            })
        const cachedData = localStorage.getItem('user_session');

        if (cachedData) {
            // Use the cached data
            this.user_session = JSON.parse(cachedData);
        } else {
            axios.get('./user_session')
                .then((response) => {
                    this.user_session = response.data

                    localStorage.setItem('user_session', JSON.stringify(response.data));

                })

                .catch((error) => console.log(error));
        }
        axios.get('./fetch_image')
            .then((response) => this.fetchimage = response.data)

        axios.get('./success_array/' + 0)
            .then((response) => this.percent = response.data.data)
    }
}

</script>
