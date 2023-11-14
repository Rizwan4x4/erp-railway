<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/recruitment/recDashboard" style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Interviews
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Search & Filter</h4>
                        <div class="row">
                            <div class="col-md-2" style="margin-top:16px;">
                                <label class="form-label" for="FilterTransaction">Name</label>
                                <input type="text" @change="search_interview()" v-model="srch_name" class="form-control" placeholder="First name" />
                            </div>
                            <div class="col-md-2" style="margin-top:16px;">
                                <label class="form-label" for="UserRole">Designation</label>
                                <!-- <select @change="search_interview()" v-model="designation" class="form-select mb-md-0 mb-2">
                                    <option value="" selected>Any</option>
                                    <option v-for="jobs1 in jobs" :value='jobs1.PostTitle'>{{jobs1.PostTitle}}</option>
                                </select> -->
                                <multiselect  @input="search_interview()" style="margin-right: 10px;" :show-labels="false" placeholder="Any"
                                        v-model="designation" :options="options">
                                          </multiselect>
                            </div>
                            <div class="col-md-1" style="width: 11%; text-align:center;">
                                <label class="form-label" for="UserPlan">1st interview status</label>
                                <!-- <select @change="search_interview()" v-model="status1" class="form-select mb-md-0 mb-2">
                                    <option value="" selected>Any</option>
                                    <option value="Not scheduled">Not scheduled</option>
                                    <option value="Scheduled">Scheduled</option>
                                    <option value="Passed">Passed</option>
                                    <option value="Skip">Skip</option>
                                    <option>Failed</option>
                                </select> -->
                                <multiselect @input="search_interview()" style="margin-right: 10px;" :show-labels="false" placeholder="Any"
                                        v-model="status1" :options="options1">
                                          </multiselect>
                            </div>
                            <div class="col-md-1" style="width: 11%; text-align: center;">
                                <label class="form-label" for="UserPlan">2nd interview status</label>
                                <!-- <select @change="search_interview()" v-model="status2" class="form-select mb-md-0 mb-2">
                                    <option value="" selected>Any</option>
                                    <option value="Not scheduled">Not scheduled</option>
                                    <option value="Scheduled">Scheduled</option>
                                    <option value="Passed">Passed</option>
                                    <option value="Skip">Skip</option>
                                    <option>Failed</option>
                                </select> -->
                                <multiselect @input="search_interview()" style="margin-right: 10px;" :show-labels="false" placeholder="Any"
                                        v-model="status2" :options="options1">
                                          </multiselect>
                            </div>
                            <div class="col-md-1" style="width: 11%; text-align: center;">
                                <label class="form-label" for="UserPlan">3rd interview status</label>
                                <!-- <select @change="search_interview()" v-model="status3" class="form-select mb-md-0 mb-2">
                                    <option value="" selected>Any</option>
                                    <option value="Not scheduled">Not scheduled</option>
                                    <option value="Scheduled">Scheduled</option>
                                    <option value="Passed">Passed</option>
                                    <option value="Skip">Skip</option>
                                    <option>Failed</option>
                                </select> -->
                                <multiselect @input="search_interview()" style="margin-right: 10px;" :show-labels="false" placeholder="Any"
                                        v-model="status3" :options="options1">
                                          </multiselect>
                            </div>
                            <div class="col-md-2" style="margin-top:16px;">
                                <label class="form-label" for="UserPlan">Rating</label>
                                <b-form-rating class="col-12 col-md-6" variant="primary" v-model="s_rate" show-clear></b-form-rating>
                            </div>
                            <div class="col-md-1 user_plan">
                                <div style="height:27px; margin-top:10px;"></div>
                                <button class="dt-button add-new btn btn-primary" @click="search_interview()">Search</button>
                            </div>

                            <div class="col-md-2 user_plan">
                                <div style="margin-top:7px; margin-right:8px ;text-align:center">
                                    <span style="color: #DB4437; font-size:12px;" v-if="designation=='' && location=='' && status=='' && srch_wrd==''">{{srch_error}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="user-list-table table" ref="exportable_table" id="mytable">
                        <thead class="table-light">
                            <tr>
                                <th style="width:150px; text-align:center;">Applicant Name</th>
                                <th style="width:150px; text-align:center;">Post applied</th>
                                <th style="width:115px; text-align:center;">1st Interview Status</th>
                                <th style="width:115px; text-align:center;">2nd Interview Status</th>
                                <th style="width:115px; text-align:center;">Final Interview Status</th>
                                <th style="width:100px; text-align:center;">Action</th>
                                <th style="width:20px; text-align:center;">Rating</th>
                                <th style="width:65px; text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='interviews1 in interviews'>
                                <td style="vertical-align: middle;">
                                    <div class="d-flex justify-content-start align-items-center mt-2">
                                        <div class="avatar me-75">
                                            <img src="public/app-assets/images/portrait/small/avatar-s-9.jpg" alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">{{interviews1.CandName}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">{{interviews1.PostTitle}}</td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <span class="badge bg-gradient-info" style="cursor: pointer;" v-if="interviews1.firstInterviewstatus=='Passed' && interviews1.hire_sts!='1'">Passed</span>
                                    <span class="badge bg-gradient-secondary" style="cursor: pointer;" v-if="interviews1.firstInterviewstatus=='Skip' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'firstsdld')" data-bs-toggle="modal" data-bs-target="#updateinterviewstatus">Skipped</span>
                                    <span class="badge bg-gradient-danger" style="cursor: pointer;" v-if="interviews1.firstInterviewstatus=='Failed'">Failed</span>

                                    <span class="badge bg-gradient-success" style="cursor: pointer;" v-if="interviews1.firstInterviewstatus=='Scheduled' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'firstsdld')" data-bs-toggle="modal" data-bs-target="#updateinterviewstatus">Scheduled</span>

                                    <span class="badge bg-gradient-warning" v-if="interviews1.firstInterviewstatus=='Not scheduled' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'firstns')" data-bs-toggle="modal" data-bs-target="#editinterview" style="cursor: pointer;">Not scheduled</span>
                                    <span class="badge bg-dark" v-if="interviews1.hire_sts=='1'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star me-25"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span>Hired</span>
                                    </span>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <span class="badge bg-gradient-info" style="cursor: pointer;" v-if="interviews1.secondInterviewstatus=='Passed' && interviews1.hire_sts!='1'">Passed</span>
                                    <span class="badge bg-gradient-secondary" style="cursor: pointer;" v-if="interviews1.secondInterviewstatus=='Skip' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'secondsdld')" data-bs-toggle="modal" data-bs-target="#updateinterviewstatus">Skipped</span>
                                    <span class="badge bg-gradient-danger" style="cursor: pointer;" v-if="interviews1.secondInterviewstatus=='Failed'">Failed</span>
                                    <span class="badge bg-gradient-success" style="cursor: pointer;" v-if="interviews1.secondInterviewstatus=='Scheduled' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'secondsdld')" data-bs-toggle="modal" data-bs-target="#updateinterviewstatus">Scheduled</span>
                                    <span class="badge bg-gradient-warning" v-if="interviews1.secondInterviewstatus=='Not scheduled' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'secondns')" data-bs-toggle="modal" data-bs-target="#editinterview" style="cursor: pointer;">Not scheduled</span>
                                    <span class="badge bg-dark" v-if="interviews1.hire_sts=='1'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star me-25"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span>Hired</span>
                                    </span>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <span class="badge bg-gradient-info" style="cursor: pointer;" v-if="interviews1.finalInterviewstatus=='Passed' && interviews1.hire_sts!='1'">Passed</span>
                                    <span class="badge bg-gradient-secondary" style="cursor: pointer;" v-if="interviews1.finalInterviewstatus=='Skip' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'finalsdld')" data-bs-toggle="modal" data-bs-target="#updateinterviewstatus">Skipped</span>
                                    <span class="badge bg-gradient-danger" style="cursor: pointer;" v-if="interviews1.finalInterviewstatus=='Failed'">Failed</span>
                                    <span class="badge bg-gradient-success" style="cursor: pointer;" v-if="interviews1.finalInterviewstatus=='Scheduled' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'finalsdld')" data-bs-toggle="modal" data-bs-target="#updateinterviewstatus">Scheduled</span>
                                    <span class="badge bg-gradient-warning" v-if="interviews1.finalInterviewstatus=='Not scheduled' && interviews1.hire_sts!='1'" @click="fetch_interview_detail(interviews1.InterviewID, 'finalns')" data-bs-toggle="modal" data-bs-target="#editinterview" style="cursor: pointer;">Not scheduled</span>
                                    <span class="badge bg-dark" v-if="interviews1.hire_sts=='1'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star me-25"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span>Hired</span>
                                    </span>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-float waves-light" v-if="interviews1.hire_sts==1">Offer letter</button>
                                    <div class="form-check form-switch" v-if="interviews1.hire_sts!=1">
                                        <span v-if="interviews1.hire_sts==1">
                                            <input type="checkbox" class="form-check-input" disabled style="width:45px" checked="" id="clientNotes">
                                        </span>
                                        <span v-else>
                                            <input type="checkbox" class="form-check-input" style="width:45px" @click="fetch_interview_detail(interviews1.InterviewID, 'hire')" id="clientNotes" data-bs-toggle="modal" data-bs-target="#hireinterview">
                                            Hire
                                        </span>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="interviews1.rating==0" v-model="s0" show-clear></b-form-rating>
                                    <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="interviews1.rating==1" v-model="s1" show-clear></b-form-rating>
                                    <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="interviews1.rating==2" v-model="s2" show-clear></b-form-rating>
                                    <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="interviews1.rating==3" v-model="s3" show-clear></b-form-rating>
                                    <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="interviews1.rating==4" v-model="s4" show-clear></b-form-rating>
                                    <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="interviews1.rating==5" v-model="s5" show-clear></b-form-rating>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <div class="btn-group">
                                        <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" @click="fetch_interview_detail(interviews1.InterviewID)" data-bs-target="#viewinterview" data-bs-toggle="modal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                </svg> View details
                                            </a>
                                            <a data-bs-toggle="modal" data-bs-target="#editinterview" @click="fetch_interview_detail(interviews1.InterviewID)" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg> Edit
                                            </a>
                                            <a v-if="interviews1.hire_sts=='1'" data-bs-toggle="modal" data-bs-target="#update_int_sts" @click="fetch_interview_detail(interviews1.InterviewID)" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                                </svg> Update Status
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Add interview User Modal -->
                    <div class="modal fade" id="addinterview" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Schedule Interview</h1>
                                        <p>Adding interview details</p>
                                    </div>
                                    <form class="row gy-1 pt-75" onsubmit="return false">

                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Candidate Name</label>
                                            <input type="text" v-model="i_c_name" class="form-control" disabled />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Posting Title</label>
                                            <input type="text" disabled="disabled" v-model="i_post_title" name="modalEditUserLastName" class="form-control" placeholder="Doe" value="Barton" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Interviewer Name</label>
                                            <input type="text" v-model="i_name" name="modalEditUserLastName" class="form-control" placeholder="Interviewer Name" value="Barton" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Online link</label>
                                            <input type="text" v-model="i_link" name="modalEditUserLastName" class="form-control" placeholder="Online Link" value="Barton" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserLastName">Interview Location</label>
                                            <input type="text" v-model="i_location" name="modalEditUserLastName" class="form-control" placeholder="Interview Location" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Assesment Name</label>
                                            <input type="text" v-model="assesment_name" text="abc" class="form-control" disabled />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Interview Comments</label>
                                            <input type="text" v-model="i_comment" class="form-control" placeholder="Add comments" maxlength="30" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserName">Date</label>
                                            <input type="date" v-model="i_date" class="form-control" placeholder="00-00-0000" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="i_date==''">{{date_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label" for="modalEditUserEmail">From</label>
                                            <input type="time" v-model="i_from" class="form-control" placeholder="11:00 am" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="i_from==''">{{time_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label" for="modalEditUserEmail">To</label>
                                            <input type="time" v-model="i_to" class="form-control" placeholder="12:30 pm" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" @click="add_interview()" class="btn btn-primary me-1">Schedule</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Add interview Modal -->
                    <!-- View interview Modal -->
                    <div class="modal fade" id="viewinterview" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <div class="justify-content-start align-items-center mb-1">
                                            <!-- avatar -->
                                            <div class="avatar">
                                                <img src="public/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar img" height="50" width="50" />
                                            </div>
                                            <!--/ avatar -->
                                            <div class="profile-user-info">
                                                <h3 class="mb-0">{{this.ed_i_c_name}}</h3>
                                            </div>
                                        </div>
                                        <center>
                                            <table>
                                                <tr>
                                                    <td class="col-md-4"><span class="fw-bolder me-25">Status:</span></td>
                                                    <td class="col-md-4">
                                                        <span class="badge badge-light-danger" v-if="this.hire_sts==1">Hired</span>
                                                        <span class="badge badge-light-danger" v-else>Not hired</span>
                                                    </td>
                                                </tr>
                                                <tr><td><span class="fw-bolder me-25">Designation:</span></td><td><span>{{this.ed_i_post_title}}</span></td></tr>

                                                <tr v-if="hire_sts!=1"><td><span class="fw-bolder me-25">First interview status:</span></td><td><span>{{this.Status1}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">First interview comments:</span></td><td><span>{{this.com1}}</span></td></tr>
                                                <tr v-if="Status1=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">First interview date:</span></td><td><span>{{this.ed_i_date}}</span></td></tr>
                                                <tr v-if="Status1=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">First interview start time:</span></td><td><span>{{this.ed_i_from}}</span></td></tr>
                                                <tr v-if="Status1=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">First interview end time:</span></td><td><span>{{this.ed_i_to}}</span></td></tr>
                                                <tr v-if="Status1=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">First interview location:</span></td><td><span>{{this.ed_i_location}}</span></td></tr>

                                                <tr v-if="hire_sts!=1"><td><span class="fw-bolder me-25">Second interview status:</span></td><td><span>{{this.Status2}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Second nterview comments:</span></td><td><span>{{this.com2}}</span></td></tr>
                                                <tr v-if="Status2=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Second nterview date:</span></td><td><span>{{this.ed_i_date}}</span></td></tr>
                                                <tr v-if="Status2=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Second nterview start time:</span></td><td><span>{{this.ed_i_from}}</span></td></tr>
                                                <tr v-if="Status2=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Second nterview end time:</span></td><td><span>{{this.ed_i_to}}</span></td></tr>
                                                <tr v-if="Status2=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Second nterview location:</span></td><td><span>{{this.ed_i_location}}</span></td></tr>

                                                <tr v-if="hire_sts!=1"><td><span class="fw-bolder me-25">Third interview status:</span></td><td><span>{{this.Status3}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Third interview comments:</span></td><td><span>{{this.com3}}</span></td></tr>
                                                <tr v-if="Status3=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Third interview date:</span></td><td><span>{{this.ed_i_date}}</span></td></tr>
                                                <tr v-if="Status3=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Third interview start time:</span></td><td><span>{{this.ed_i_from}}</span></td></tr>
                                                <tr v-if="Status3=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Third interview end time:</span></td><td><span>{{this.ed_i_to}}</span></td></tr>
                                                <tr v-if="Status3=='Scheduled' && hire_sts!=1"><td><span class="fw-bolder me-25">Third interview location:</span></td><td><span>{{this.ed_i_location}}</span></td></tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Rating:</span></td>
                                                    <td>
                                                        <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-if="this.ratings==0" v-model="s0" show-clear></b-form-rating>
                                                        <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-else-if="this.ratings==1" v-model="s1" show-clear></b-form-rating>
                                                        <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-else-if="this.ratings==2" v-model="s2" show-clear></b-form-rating>
                                                        <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-else-if="this.ratings==3" v-model="s3" show-clear></b-form-rating>
                                                        <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-else-if="this.ratings==4" v-model="s4" show-clear></b-form-rating>
                                                        <b-form-rating class="col-12 col-md-6" variant="primary" readonly v-else-if="this.ratings==5" v-model="s5" show-clear></b-form-rating>
                                                        <span class="badge badge-light-danger" v-else>Not rated</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ View interview Modal -->
                    <!-- Update interview status Modal -->
                    <div class="modal fade" id="updateinterviewstatus" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Update Interview Status</h1>
                                        <p>Updating interview status</p>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Candidate name</label>
                                            <input type="text" disabled class="form-control" v-model="ed_i_c_name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Post Applied</label>
                                            <input type="text" disabled class="form-control" v-model="ed_i_post_title" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserLastName">Assessment name</label>
                                            <input type="text" disabled class="form-control" v-model="assesment_name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Status</label>
                                            <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                                <option value="" selected>Select</option>
                                                <option>Not scheduled</option>
                                                <option>Scheduled</option>
                                                <option>Passed</option>
                                                <option>Skip</option>
                                                <option>Failed</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Comments</label>
                                            <input type="text" v-model="ed_i_comment" class="form-control" placeholder="Comments" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" @click="schedule_interview()" class="btn btn-primary me-1">Confirm</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancle
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Update interview status Modal -->
                    <!-- Edit interview Modal -->
                    <div class="modal fade" id="editinterview" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Edit Interview Details</h1>
                                        <p>Editting interview details.</p>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Candidate Name</label>
                                            <input type="text" v-model="ed_i_c_name" class="form-control" disabled />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserLastName">Posting Title</label>
                                            <input type="text" disabled="disabled" v-model="ed_i_post_title" name="modalEditUserLastName" class="form-control" placeholder="Doe" value="Barton" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserFirstName">Assesment Name</label>
                                            <input type="text" v-model="assesment_name" text="abc" class="form-control" disabled />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Interviewer Name</label>
                                            <input type="text" v-model="ed_i_name" class="form-control" placeholder="Interviewer name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserFirstName">Online link</label>
                                            <input type="text" v-model="ed_i_link" name="modalEditUserLastName" class="form-control" placeholder="Online Link" value="Barton" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserLastName">Interview Location</label>
                                            <input type="text" v-model="ed_i_location" name="modalEditUserLastName" class="form-control" placeholder="Interview Location" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalEditUserLastName">Interview Comments</label>
                                            <input type="text" v-model="ed_i_comment" class="form-control" placeholder="Add comments" data-msg="Please enter your last name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserName">Date</label>
                                            <input type="date" v-model="ed_i_date" class="form-control" placeholder="00-00-0000" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="ed_i_date==null">{{ed_i_date_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label" for="modalEditUserEmail">From</label>
                                            <input type="time" v-model="ed_i_from" class="form-control" placeholder="11:00 am" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="ed_i_from==null">{{ed_i_time_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label" for="modalEditUserEmail">To</label>
                                            <input type="time" v-model="ed_i_to" class="form-control" placeholder="12:30 pm" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled" @click="delay()" type="submit" class="btn btn-primary me-1">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancle
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Edit interview Modal -->
                    <!-- Update hired status Modal -->
                    <div class="modal fade" id="update_int_sts" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Change status of <strong>{{this.ed_i_c_name}}</strong>'s interview</h1>
                                        <select class="form-select mb-md-0 mb-2" v-model="hire_sts">
                                            <option value="1" selected>Hired</option>
                                            <option value="0">Not hired</option>
                                        </select>
                                        
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" @click="interview_hr1()" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancle</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Update hired status Modal -->
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
                                        <h5>Do you want to hire <strong>{{this.ed_i_c_name}}</strong> for the post of <strong>{{this.ed_i_post_title}}</strong>?</h5>
                                        <div class="col-md-12" style="text-align:left; margin-bottom:15px; ">
                                            <label class="form-label">Offer salary</label>
                                            <span style="color: #DB4437; font-size:11px;">*</span>
                                            <input type="number" v-model="exp_salary" class="form-control" placeholder="Offer salary" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="exp_salary==''">{{e_exp_salary}}</span>
                                        </div>
                                        <div class="text-center" style="text-align:center">
                                            <button :disabled="disabled1" @click="delay1()" type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
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
</template>
<script>
    import Multiselect from 'vue-multiselect'
    export default {
        components: {
Multiselect
},
        data() {
            return {
            exp_salary: '',
            options:[],
            options1:["Not scheduled","Scheduled","Passed","Skip","Failed"],
            options2:[],
                e_exp_salary: '',
                srch_name: '',
                designation: '',
                location: '',
                status: '',
                srch_wrd: '',
                status1: '',
                status2: '',
                status3: '',
                s_rate: '',
                ratings: '',
                interviews: {},
                CandName: '',
                PostTile: '',
                Remarks: '',
                candidates: {},
                jobs: {},
                i_c_name: '',
                i_post_title: '',
                i_name: '',
                i_link: '',
                i_location: '',
                i_comment: '',
                i_date: '',
                i_from: '',
                i_to: '',
                cid: '',

                s0: 0,
                s1: 1,
                s2: 2,
                s3: 3,
                s4: 4,
                s5: 5,

                check: '',
                up_sts: '',
                upsts: '',
                fstInter: '',
                scInter: '',
                fnInter: '',
                which: '',

                name_error: '',
                loc_error: '',
                ast_error: '',
                date_error: '',
                time_error: '',
                iId: '',
                Cid: '',

                assesment_name: '',
                ed_i_loc_error: '',
                ed_i_ast_error: '',
                ed_i_date_error: '',
                ed_i_time_error: '',

                ed_i_c_name: '',
                ed_i_post_title: '',
                ed_i_name: '',
                ed_i_link: '',
                ed_i_location: '',
                assesment_name: '',
                ed_i_comment: '',
                com1: '',
                com2: '',
                com3: '',
                ed_i_date: '',
                ed_i_from: '',
                ed_i_to: '',
                sess: '',
                srch_error: '',

                hire_sts: '',
                Status1: '',
                Status2: '',
                Status3: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,

            }
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.schedule_interview()
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.interview_hr()
            },
            search_interview() {

                if (this.status1 == null ) {
                this.status1 = '';
            }
            else {
                this.status1 = this.status1;
            }

            if (this.status2 == null ) {
                this.status2 = '';
            }
            else {
                this.status2 = this.status2;
            }
            if (this.status3 == null ) {
                this.status3 = '';
            }
            else {
                this.status3 = this.status3;
            }
            if ( this.designation ==null) {
                this.designation = '';
            }
            else {
                this.designation = this.designation;
            }
            if (this.s_rate == null) {
                this.s_rate = '';
            }
            else {
                this.department1 = this.department;
            }
                axios.post('./searchinterviews', {
                    srch_name: this.srch_name,
                    designation: this.designation,
                    status1: this.status1,
                    status2: this.status2,
                    status3: this.status3,
                    s_rate: this.s_rate,
                }).then(data => {
                    this.interviews = data.data;
                })
                    .catch(error => this.error = error.response.data.errors)
            },
            fetch_interview_detail(id, ok) {
                this.id2 = id;
                this.which = ok;
                //start
                axios.get('fetch_interviews/' + this.id2)
                    .then(responce => {
                        this.iId = responce.data[0].InterviewID;
                        this.i_c_name = responce.data[0].CandName;
                        this.ed_i_c_name = responce.data[0].CandName;
                        this.ed_i_post_title = responce.data[0].PostTitle;
                        this.ed_i_name = responce.data[0].InterviewerName;
                        this.ed_i_location = responce.data[0].InterviewLocation;
                        this.ed_i_from = responce.data[0].StartTime;
                        this.ed_i_to = responce.data[0].EndTime;
                        this.ed_i_date = responce.data[0].DayDate;
                        this.com1 = responce.data[0].firstInterviewComments;
                        this.com2 = responce.data[0].secondInterviewComments;
                        this.com3 = responce.data[0].finalInterviewComments;

                        this.hire_sts = responce.data[0].hire_sts;
                        this.ratings = responce.data[0].rating;
                        this.Status1 = responce.data[0].firstInterviewstatus;
                        this.Status2 = responce.data[0].secondInterviewstatus;
                        this.Status3 = responce.data[0].finalInterviewstatus;

                        if (this.which == "firstns" || this.which == "firstsdld") {
                            this.assesment_name = "First interview";
                            this.ed_i_comment = responce.data[0].firstInterviewComments;
                            this.up_sts = responce.data[0].firstInterviewstatus;
                        }
                        else if (this.which == "secondns" || this.which == "secondsdld") {
                            this.assesment_name = "Second interview";
                            this.ed_i_comment = responce.data[0].secondInterviewComments;
                            this.up_sts = responce.data[0].secondInterviewstatus;
                        }
                        else if (this.which == "finalns" || this.which == "finalsdld") {
                            this.assesment_name = "Final interview";
                            this.ed_i_comment = responce.data[0].finalInterviewComments;
                            this.up_sts = responce.data[0].finalInterviewstatus;
                        }
                    })
                    .catch(error => { });
            },
            interview_hr() {
                if (this.exp_salary == '') {
                    if (this.exp_salary == '') {
                        this.e_exp_salary = "Enter salary of employee";
                    }
                    else {
                        this.e_exp_salary = "";
                    }
                    this.$toastr.e("Fill required field", "Caution!");
                }
                else {
                    this.e_exp_salary = "";
                    axios.post('./int_hire', {
                        myiId: this.iId,
                        hire_sts: this.hire_sts,
                        i_c_name: this.ed_i_c_name,
                        exp_salary: this.exp_salary,
                    })
                    this.exp_salary = "";
                    this.ed_i_c_name = "";
                    this.iId = "";
                    this.$toastr.s("Candidate hired successfully!", "Congratulations");
                    axios.get('interview_detail2')
                        .then(data => {
                            this.interviews = data.data;
                        }
                    )
                        .catch(error => { })
                }
            },
            interview_hr1() {
                axios.post('./int_hire1', {
                    myiId: this.iId,
                    hire_sts: this.hire_sts,
                })
                    .then(data => {
                        if (data.data == "Status updated") {
                            this.$toastr.s("Status updated successfully!", "Congratulations");
                            axios.get('interview_detail2')
                                .then(data => this.interviews = data.data)
                                .catch(error => { })
                        }
                        else {
                            this.$toastr.e("Status not changed", "Error!");
                        }
                    })
            },

            schedule_interview() {
                if (this.which == "firstns" || this.which == "secondns" || this.which == "finalns") {
                    if (this.ed_i_date == null || this.ed_i_from == null) {
                        if (this.ed_i_date == null) {
                            this.ed_i_date_error = "Select interview date";
                        }
                        else {
                            this.ed_i_date_error = "";
                        }
                        if (this.ed_i_from == null) {
                            this.ed_i_time_error = "Select time";
                        }
                        else {
                            this.ed_i_time_error = "";
                        }
                        this.$toastr.e("Please Type details", "Error!");
                    }
                    else {
                        axios.post('./update_interview', {
                            myiId: this.iId,
                            up_sts: this.up_sts,
                            hire_sts: this.check,
                            ed_i_c_name: this.ed_i_c_name,
                            ed_i_post_title: this.ed_i_post_title,
                            ed_i_name: this.ed_i_name,
                            ed_i_link: this.ed_i_link,
                            ed_i_location: this.ed_i_location,
                            asses: this.assesment_name,
                            which: this.which,
                            ed_i_comment: this.ed_i_comment,
                            ed_i_date: this.ed_i_date,
                            ed_i_from: this.ed_i_from,
                            ed_i_to: this.ed_i_to,
                        })
                            .then(data => {
                                if (data.data == "Interview updated successfully") {
                                    this.$toastr.s("Interview updated successfully!", "Congratulations");
                                    this.up_sts = '';
                                    this.check = '';
                                    this.ed_i_name = '';
                                    this.ed_i_link = '';
                                    this.ed_i_location = '';
                                    this.which = '';
                                    this.ed_i_comment = '';
                                    this.ed_i_date = '';
                                    this.ed_i_from = '';
                                    this.ed_i_to = '';

                                    axios.get('interview_detail2')
                                        .then(data => this.interviews = data.data)
                                        .catch(error => { })
                                }
                            })
                    }

                }
                else {
                    axios.post('./update_interview', {
                        myiId: this.iId,
                        up_sts: this.up_sts,
                        hire_sts: this.check,
                        ed_i_c_name: this.ed_i_c_name,
                        ed_i_post_title: this.ed_i_post_title,
                        ed_i_name: this.ed_i_name,
                        ed_i_link: this.ed_i_link,
                        ed_i_location: this.ed_i_location,
                        asses: this.assesment_name,
                        which: this.which,
                        ed_i_comment: this.ed_i_comment,
                        ed_i_date: this.ed_i_date,
                        ed_i_from: this.ed_i_from,
                        ed_i_to: this.ed_i_to,
                    })
                        .then(data => {
                            if (data.data == "Interview updated successfully") {
                                this.$toastr.s("Interview updated successfully!", "Congratulations");
                                this.up_sts = '';
                                this.check = '';
                                this.ed_i_name = '';
                                this.ed_i_link = '';
                                this.ed_i_location = '';
                                this.which = '';
                                this.ed_i_comment = '';
                                this.ed_i_date = '';
                                this.ed_i_from = '';
                                this.ed_i_to = '';

                                axios.get('interview_detail2')
                                    .then(data => this.interviews = data.data)
                                    .catch(error => { })
                            }
                        })
                }
            }
        },
        mounted() {

            axios.get('interview_detail2')
                .then(data => this.interviews = data.data)
                .catch(error => { });

            axios.get('candidate_detail2')
                .then(data => this.candidates = data.data)
                .catch(error => { });

            axios.get('job_detail2')
                .then(data => {
                    this.jobs = data.data
                    this.options = [];

var $this = this;
for (var i = 0; i < $this.jobs.length; i++) {
this.options.push($this.jobs[i].PostTitle);
}
                })
                .catch(error => { });

        },
    }
</script>
