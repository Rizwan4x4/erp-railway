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
                                    Candidates
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!--Search code-->
                    <div class="card-body border-bottom">
                        <h4 class="card-title">Search & Filter</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Name</label>
                                <input type="text" @change="search_candidate()" v-model="s_name" class="form-control" placeholder="Name" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Post Applied</label>
                                <!-- <select @change="search_candidate()" v-model="s_post" class="form-select mb-md-0 mb-2">
                                    <option value="">Any Post</option>
                                    <option v-for='p_detail1 in p_detail' :value='p_detail1.PostTitle'>{{p_detail1.PostTitle}}</option>
                                </select> -->
                                <multiselect style="margin-right: 10px;"
                                @input="search_candidate()"
                                                         v-model="s_post"
                                                         :show-labels="false"
                                                         placeholder="Any Post"
                                                         :options="options">
                                            </multiselect>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Address</label>
                                <input @change="search_candidate()" type="text" v-model="s_address" class="form-control" placeholder="Address" />
                            </div>
                            <div class="col-md-3">
                                <div style="height:27px;"></div>
                                <button @click="search_candidate()" class="dt-button add-new btn btn-primary" tabindex="0" type="button"><span>Search</span></button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                        <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                            <div  v-if="hasPermission('Add new Candidates')"  style="float:left;">
                                <router-link to="" class="dt-button add-new btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcandidate" tabindex="0" type="button"><span>+ Add new candidate</span></router-link>
                            </div>
                        </div>
                    </div>
                    <table class="user-list-table table">
                        <thead class="table-light">
                            <tr>
                                <th style="width:200px; text-align:center;">Candidate Name</th>
                                <th style="width:180px; text-align:center;">Post applied</th>
                                <th style="width:20px; text-align:center;">Qualification</th>
                                <th style="width:145px; text-align:center;">Experiance</th>
                                <th style="width:145px; text-align:center;">Status</th>
                                <th style="width:135px; text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='candidates1 in candidates'>
                                <td style="vertical-align: middle;">
                                    <div class="d-flex justify-content-start align-items-center mt-2">
                                        <div class="avatar me-75">
                                            <img src="public/app-assets/images/portrait/small/avatar-s-9.jpg" alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">{{candidates1.CandName}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td style="vertical-align: middle; text-align: center;">{{candidates1.PostTitle}}</td>
                                <td style="vertical-align: middle; text-align: center;" v-html="candidates1.Qualification"></td>
                                <td style="vertical-align: middle; text-align: center;">{{candidates1.experience}}</td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <span v-if="candidates1.stats=='Applied'" class="badge badge-glow bg-info">Applied</span>
                                    <span v-else-if="candidates1.stats=='Shortlisted'" class="badge badge-glow bg-success">Shortlisted</span>
                                    <span v-else-if="candidates1.stats=='Rejected'" class="badge badge-glow bg-danger">Rejected</span>
                                    <span v-else-if="candidates1.stats=='Pending'" class="badge badge-glow bg-secondary">Pending</span>
                                    <span v-else class="badge badge-glow bg-dark">{{candidates1.stats}}</span>
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
                                            <a data-bs-toggle="modal" class="dropdown-item" @click="fetch_candidate_detail(candidates1.CandID)" data-bs-target="#viewcandidate">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                </svg> View profile
                                            </a>
                                            <a data-bs-toggle="modal" @click="fetch_candidate_detail(candidates1.CandID)" data-bs-target="#editcandidate" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg> Edit candidate
                                            </a>
                                            <span v-if="candidates1.stats!='Shortlisted'" data-bs-toggle="modal" @click="fetch_candidate_detail(candidates1.CandID)" data-bs-target="#upd_sts" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                                </svg> Update status
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Add candidate model-->
                    <div class="modal fade" id="addcandidate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Candidate Details</h1>
                                        <p>This is job application form</p>
                                    </div>
                                    <div class="d-flex">
                                        <img v-if="url" :src="url" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image" style="width:155px;height:180px">
                                        <img v-else src="public/app-assets/images/portrait/small/profile.jpg" id="account-upload-img" class="uploadedAvatar rounded me-50" alt="profile image">
                                        <!-- upload and reset button -->
                                        <div class="d-flex align-items-end mt-75 ms-1">
                                            <div>
                                                <input type="file" id="image_file" :v-model="image_file" name="image_file" @change="onFileChange" accept="image/*" class="input-file">
                                                <button type="button" @click="clear_image()" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75 waves-effect">Clear</button>
                                                <p class="mb-0">Add profile image(png, jpg, jpeg. ) </p>
                                            </div>
                                        </div>
                                        <!--/ upload and reset button -->
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Candidate Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="a_c_name" class="form-control" placeholder="Enter full name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_name==''">{{name_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Father Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="a_c_father" class="form-control" placeholder="Father name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_father==''">{{father_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Mobile Number</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <masked-input v-model="a_c_mobile" class="form-control account-number-mask" mask="0311 -1111111" placeholder="Mobile number"></masked-input>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_mobile==''">{{mobile_error}}</span>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Email</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="a_c_email" class="form-control" placeholder="abc@xyz.com" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="!validEmail(a_c_email)">{{a_email_error}}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" v-model="a_c_address" class="form-control" placeholder="Complete address" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Designation</label>
                                            <input type="text" v-model="a_c_job_title" class="form-control" placeholder="Current designation" />
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Experiance</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <!-- <select id="modalAddressCountry" v-model="a_c_experiance" class="select2 form-select">
                                                <option value="">Select</option>
                                                <option value="None">None</option>
                                                <option value="Fresher">Fresher</option>
                                                <option value="0-1 year">0-1 year</option>
                                                <option value="1-3 years">1-3 years</option>
                                                <option value="4-5 years">4-5 years</option>
                                                <option value="5+ years">5+ years</option>
                                            </select> -->
                                            <multiselect style="margin-right: 10px;"

                                                         v-model="a_c_experiance"
                                                         :show-labels="false"
                                                         placeholder="Select"
                                                         :options="options1">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_experiance==''">{{exp_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Rating</label>
                                            <b-form-rating class="col-12 col-md-6" variant="primary" v-model="star_value" show-clear></b-form-rating>
                                            <!--<input type="file" class="form-control" ref="a_c_pic" accept="Image/*" />-->
                                            <span style="color: #DB4437; font-size: 11px;"></span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Resume</label>
                                            <input type="file" class="form-control" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Salary</label>
                                            <input type="number" v-model="a_c_crt_salary" class="form-control" placeholder="Current salary" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Position appling for</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <select v-model="a_c_post_title" class="form-select" aria-label="Default select example">
                                                <option value="adadd" selected>Select</option>
                                                <option v-for='p_detail1 in p_detail' :value='p_detail1.JobID'>{{p_detail1.PostTitle}}</option>
                                            </select>

                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_post_title==''">{{pst_error}}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Highest qualification</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <vue-editor style="height:200px;" v-model="a_c_qualification" placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_qualification==''">{{qual_error}}</span>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Skill set</label>
                                            <vue-editor style="height:200px;" v-model="a_c_skill" placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Expected Salary</label>
                                            <input type="number" v-model="a_c_exp_salary" class="form-control" placeholder="Expected Salary" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled" @click="delay()" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Add</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Add candidate model-->
                    <!-- View candidate modal-->
                    <div class="modal fade" id="viewcandidate" tabindex="-1" aria-hidden="true">
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
                                                <h3 class="mb-0">{{e_c_name}}</h3>
                                                <small class="text-muted">
                                                    for {{e_c_job_title}}
                                                </small>
                                            </div>
                                        </div>
                                        <center>
                                            <table>
                                                <tr><td class="col-md-4"><span class="fw-bolder me-25">Status:</span></td><td class="col-md-4"><span class="badge badge-light-danger">Applied</span></td></tr>
                                                <tr><td class="col-md-4"><span class="fw-bolder me-25">Father's Name:</span></td><td class="col-md-4"><span>{{e_c_father}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Address:</span></td><td><span>{{e_c_address}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Mobile Number:</span></td><td><span>{{e_c_mobile}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">E-mail:</span></td><td><span>{{e_c_email}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Qualification:</span></td><td><span v-html="e_c_qualification"></span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Skills:</span></td><td><span v-html="e_c_skill"></span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Current Salary:</span></td><td><span>{{e_c_crt_salary}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Expected Salary:</span></td><td><span>{{e_c_exp_salary}}</span></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Rating:</span></td><td><b-form-rating class="col-12 col-md-6" readonly variant="primary" v-model="ed_rating" show-clear></b-form-rating></td></tr>
                                                <tr><td><span class="fw-bolder me-25">Designation:</span></td><td><span>{{e_c_job_title}}</span></td></tr>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / View candidate modal-->
                    <!-- Edit candidate modal-->
                    <div id="editcandidate" class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h2 class="mb-1">Edit <label>{{e_c_name_h}}</label>'s details</h2>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Candidate Name</label>
                                            <input type="text" v-model="e_c_name" class="form-control" placeholder="Enter full name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_name==''">{{ed_name_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Father Name</label>
                                            <input type="text" v-model="e_c_father" class="form-control" placeholder="Father name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_father==''">{{ed_father_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Mobile Number</label>
                                            <masked-input class="form-control account-number-mask" mask="0311-1111111" v-model="e_c_mobile" placeholder="Mobile number"></masked-input>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_mobile==''">{{ed_mobile_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="text" v-model="e_c_email" class="form-control" placeholder="abc@xyz.com" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="!validEmail(e_c_email) || e_c_email==''">{{ed_email_error}}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" v-model="e_c_address" class="form-control" placeholder="Complete address" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Designation</label>
                                            <input type="text" v-model="e_c_job_title" class="form-control" placeholder="Current designation" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Experiance</label>
                                            <!-- <select id="modalAddressCountry" v-model="e_c_experiance" class="select2 form-select">
                                                <option value="">Select</option>
                                                <option value="Fresher">Fresher</option>
                                                <option value="0-1 year">0-1 year</option>
                                                <option value="1-3 years">1-3 years</option>
                                                <option value="4-5 years">4-5 years</option>
                                                <option value="5+ years">5+ years</option>
                                            </select> -->
                                            <multiselect style="margin-right: 10px;"
                                            id="modalAddressCountry"
                                                         v-model="e_c_experiance"
                                                         :show-labels="false"
                                                         placeholder="Select"
                                                         :options="options1">
                                            </multiselect>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Rating</label>
                                            <b-form-rating class="col-12 col-md-6" variant="primary" v-model="ed_rating" show-clear></b-form-rating>
                                            <!--<input type="file" class="form-control" ref="a_c_pic" accept="Image/*" />-->
                                            <span style="color: #DB4437; font-size: 11px;"></span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Resume</label>
                                            <input type="file" class="form-control" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Salary</label>
                                            <input type="number" v-model="e_c_crt_salary" class="form-control" placeholder="Current salary" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Position appling for</label>
                                            <select v-model="e_c_post_title" class="form-select" aria-label="Default select example">
                                                <option selected>Select</option>
                                                <option v-for='p_detail1 in p_detail' :value='p_detail1.JobID'>{{p_detail1.PostTitle}}</option>
                                            </select>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_post_title=='' || e_c_post_title=='Select'">{{ed_pst_error}}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Expected Salary</label>
                                            <input type="number" v-model="e_c_exp_salary" class="form-control" placeholder="Expected Salary" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Highest qualification</label>
                                            <vue-editor style="height:200px;" v-model="e_c_qualification" placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_qualification==''">{{qual_error}}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Skill set</label>
                                            <vue-editor style="height:200px;" v-model="e_c_skill" placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                        </div>
                                        <div class="col-12 col-md-6"></div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled1" @click="delay1()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancle
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Edit candidate modal-->
                    <!-- Delete candidate modal-->
                    <div class="modal fade" id="upd_sts" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h2 class="mb-1">Do you want to edit application status of "<label>{{e_c_name}}</label>" ?</h2>
                                        <br />
                                        <div class="col-12 text-center" style="float:right; text-align:center;">
                                            <select id="modalAddressCountry" v-model="e_c_status" class="select2 form-select">
                                                <option value="Applied">Applied</option>
                                                <option value="Shortlisted">Shortlisted</option>
                                                <option value="Rejected">Rejected</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                            <br />
                                            <button type="button" :disabled="disabled2" @click="delay2()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Delete candidate modal-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import MaskedInput from 'vue-masked-input'
    import Multiselect from 'vue-multiselect'
    const image = "";

    export default {
        components: {
            MaskedInput,
            Multiselect
        },
        data() {
            return {
                options:[],
                options1:["None","Fresher","0-1 year","1-3 years","4-5 years","5+ years"],
                s_post: '',
                s_name: '',
                s_address: '',
                //Edit candidate models
                e_c_name: '',
                e_c_father: '',
                e_c_mobile: '',
                e_c_email: '',
                e_c_post_title: '',
                e_c_address: '',
                e_c_exp_salary: '',
                e_c_crt_salary: '',
                ed_rating: '',
                e_c_job_title: '',
                e_c_qualification: '',
                e_c_experiance: '',
                e_c_skill: '',
                e_c_status: '',
                e_c_name_h: '',
                //Edit candidate error
                ed_name_error: '',
                ed_father_error: '',
                ed_email_error: '',
                ed_email_error: '',
                ed_mobile_error: '',
                ed_exper_error: '',
                ed_pic_error: '',
                ed_pst_error: '',
                ed_qual_error: '',

                s0: 0,
                s1: 1,
                s2: 2,
                s3: 3,
                s4: 4,
                s5: 5,
                //Add candidate models
                a_c_name: '',
                a_c_father: '',
                a_c_post_title: '',
                a_c_job_id: '',
                a_c_email: '',
                a_c_mobile: '',
                a_c_address: '',
                a_c_crt_salary: '',
                a_c_job_title: '',
                a_c_skill: '',
                a_c_experiance: '',
                a_c_qualification: '',
                a_c_exp_salary: '',
                //Add candidate error
                name_error: '',
                father_error: '',
                a_email_error: '',
                mobile_error: '',
                a_c_pic_error: '',
                pst_error: '',
                qual_error: '',
                image_file: '',
                exp_error: '',
                id2: '',
                url: null,
                image,

                p_detail: {},
                PostTitle: '',
                CandName: '',
                candidates: {},
                keyword1: '',
                value: 0,
                star_value: '',
                CandID: '',
                name: {},
                cid: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,

                disabled2: false,
                timeout2: null,
            }
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.add_cdt()
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_candidate()
            },
            delay2() {
                this.disabled2 = true
                this.timeout2 = setTimeout(() => {
                    this.disabled2 = false
                }, 5000)
                this.update_status()
            },
            search_candidate() {
                axios.post('./searchcandidates', {
                    name: this.s_name,
                    post: this.s_post,
                    address: this.s_address,

                }).then(data => {
                    this.candidates = data.data;
                })
                    .catch(error => this.error = error.response.data.errors)
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                const file = files[0];
                this.image = files[0];
                this.url = URL.createObjectURL(file);
            },
            clear_image() {
                this.url = null;
                this.image_file = '';
                this.image = '';
            },
            fetch_candidate_detail(id) {
                this.id1 = id;
                axios.get('fetch_candidates/' + this.id1)
                    .then(responce => {
                        this.cid = responce.data[0].CandID; //candidate id
                        this.e_c_name = responce.data[0].CandName;
                        this.e_c_name_h = responce.data[0].CandName;
                        this.e_c_father = responce.data[0].FatherHusband;
                        this.e_c_mobile = responce.data[0].Mobile;

                        this.e_c_status = responce.data[0].stats;

                        this.e_c_email = responce.data[0].Email;
                        this.e_c_post_title = responce.data[0].JobID;
                        this.e_c_exp_salary = responce.data[0].ExpectedSalary;
                        this.ed_rating = responce.data[0].Rating;
                        this.e_c_address = responce.data[0].CandAddress;
                        this.e_c_crt_salary = responce.data[0].Curr_Salary;
                        this.e_c_job_title = responce.data[0].Curr_Designation;
                        this.e_c_qualification = responce.data[0].Qualification;
                        this.e_c_experiance = responce.data[0].experience;
                        this.e_c_skill = responce.data[0].Skill;
                    })
                    .catch(error => { });
            },
            update_status() {

                axios.post('./update_status', {
                    mycid: this.cid,
                    e_c_status: this.e_c_status,

                })
                    .then(data => {
                        if (data.data == 'Status updated!') {
                            this.$toastr.s("Status updated!", "Congratulations!");
                            axios.get('candidate_detail2')
                                .then(data => this.candidates = data.data)
                                .catch(error => { });
                        }
                    })
                if (this.e_c_status == "Shortlisted") {
                    //start
                    axios.post('./schInterview', {
                        e_c_name: this.e_c_name,
                        i_c_id: this.cid,
                        i_rating: this.ed_rating,
                        fstInter: 'Not scheduled',
                        scInter: 'Not scheduled',
                        fnInter: 'Not scheduled',
                        fstComm: '',
                        scComm: '',
                        fnComm: '',
                    })
                    axios.get('candidate_detail2')
                        .then(data => this.candidates = data.data)
                        .catch(error => { });
                }
                //refresh interviews component
                axios.get('interview_detail2')
                    .then(data => this.interviews = data.data)
                    .catch(error => { });
            },
            update_candidate() {
                if (this.e_c_name == '' || this.e_c_father == '' || !this.validEmail(this.e_c_email) || this.e_c_mobile == '' || this.e_c_post_title == '' || this.e_c_post_title == "Select") {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.e_c_name == '') {
                        this.ed_name_error = 'Full name required.';
                    }
                    else {
                        this.ed_name_error = '';
                    }
                    if (this.e_c_father == '') {
                        this.ed_father_error = 'Father name required.';
                    }
                    else {
                        this.ed_father_error = '';
                    }

                    if (this.e_c_mobile == '') {
                        this.ed_mobile_error = 'Mobile number required.';
                    }
                    else {
                        this.ed_mobile_error = '';
                    }
                    if (this.e_c_email == '') {
                        this.ed_email_error = "Email required.";
                    }
                    else if (!this.validEmail(this.e_c_email)) {
                        this.ed_email_error = 'Enter valid e-mail address!';
                    }
                    else {
                        this.ed_email_error = '';
                    }
                    if (this.e_c_post_title == '' || this.e_c_post_title == "Select") {
                        this.ed_pst_error = 'Select post';
                    }
                    else {
                        this.ed_pst_error = '';
                    }
                    if (this.e_c_qualification == '') {
                        this.ed_qual_error = 'Please enter latest qualification.';
                    }
                    else {
                        this.ed_qual_error = '';
                    }
                }
                else {

                    axios.post('./update_candidate', {
                        mycid: this.cid,
                        e_c_name: this.e_c_name,
                        e_c_father: this.e_c_father,
                        e_c_mobile: this.e_c_mobile,
                        e_c_email: this.e_c_email,
                        e_c_post_title: this.e_c_post_title,
                        e_c_exp_salary: this.e_c_exp_salary,
                        ed_rating: this.ed_rating,
                        e_c_address: this.e_c_address,
                        e_c_crt_salary: this.e_c_crt_salary,
                        e_c_job_title: this.e_c_job_title,
                        e_c_qualification: this.e_c_qualification,
                        e_c_experiance: this.e_c_experiance,
                        e_c_skill: this.e_c_skill,
                    })
                        .then(data => {
                            if (data.data == 'Candidate editted Successfully!') {
                                this.$toastr.s("Candidate updated Successfully", "Congratulations!");

                                this.e_c_name = '';
                                this.e_c_father = '';
                                this.e_c_mobile = '';
                                this.e_c_email = '';
                                this.e_c_post_title = '';
                                this.e_c_exp_salary = '';
                                this.ed_rating = '';
                                this.e_c_address = '';
                                this.e_c_crt_salary = '';
                                this.e_c_job_title = '';
                                this.e_c_qualification = '';
                                this.e_c_experiance = '';
                                this.e_c_skill = '';

                                this.ed_name_error = '';
                                this.ed_father_error = '';
                                this.ed_mobile_error = '';
                                this.ed_email_error = '';
                                this.ed_pst_error = '';
                                this.ed_qual_error = '';

                                axios.get('candidate_detail2')
                                    .then(data => this.candidates = data.data)
                                    .catch(error => { });
                            }
                        })
                        .catch(error => this.error = error.responce.data.errors)
                }
            },
            view_detail(CandID) {
                axios.get('./get_candidate_detail/' + CandID)
                    .then((responce) => this.name = responce.data)
                    .catch(error => console.log(error));
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            add_cdt() {
                if (this.a_c_name == '' || this.a_c_father == '' || this.a_c_mobile == '' || this.a_c_email == '' || this.a_c_experiance == '' || !this.validEmail(this.a_c_email) || this.a_c_post_title == '' || this.a_c_qualification == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.a_c_name == '') {
                        this.name_error = 'Full name required.';
                    }
                    else {
                        this.name_error = '';
                    }
                    if (this.a_c_father == '') {
                        this.father_error = 'Father name required.';
                    }
                    else {
                        this.father_error = '';
                    }
                    if (this.a_c_email == '') {
                        this.a_email_error = 'Email required.';
                    }
                    else if (!this.validEmail(this.a_c_email)) {
                        this.a_email_error = 'Enter valid e-mail address!';
                    }
                    else {
                        this.a_email_error = '';
                    }

                    if (this.a_c_experiance == '') {
                        this.exp_error = 'Experiance required.';
                    }
                    else {
                        this.exp_error = '';
                    }
                    if (this.a_c_mobile == '') {
                        this.mobile_error = 'Mobile number required.';
                    }
                    else {
                        this.mobile_error = '';
                    }
                    if (this.a_c_post_title == '') {
                        this.pst_error = 'Select post to apply.';
                    }
                    else {
                        this.pst_error = '';
                    }
                    if (this.a_c_qualification == '') {
                        this.qual_error = 'Please enter latest qualification.';
                    }
                    else {
                        this.qual_error = '';
                    }
                }
                else {
                    axios.post('./candidate', {
                        a_c_name: this.a_c_name,
                        a_c_father: this.a_c_father,
                        a_c_mobile: this.a_c_mobile,
                        a_c_email: this.a_c_email,
                        a_c_address: this.a_c_address,
                        a_c_job_title: this.a_c_job_title,

                        a_c_experiance: this.a_c_experiance,
                        star_value: this.star_value,
                        a_c_crt_salary: this.a_c_crt_salary,
                        a_c_job_id: this.a_c_post_title,

                        a_c_qualification: this.a_c_qualification,
                        a_c_skill: this.a_c_skill,
                        a_c_exp_salary: this.a_c_exp_salary,
                    })
                        .then(data => {
                            if (data.data == 'Candidate added Successfully!') {
                                this.$toastr.s("Candidate added successfully!", "Congratulations!");

                                this.a_c_name = '';
                                this.a_c_father = '';
                                this.a_c_mobile = '';
                                this.a_c_email = '';
                                this.a_c_address = '';
                                this.a_c_job_title = '';
                                this.a_c_experiance = '';
                                this.star_value = '';
                                this.a_c_crt_salary = '';
                                this.a_c_post_title = '';
                                this.a_c_qualification = '';
                                this.a_c_skill = '';
                                this.a_c_exp_salary = '';

                                this.name_error = '';
                                this.father_error = '';
                                this.a_email_error = '';
                                this.exp_error = '';
                                this.mobile_error = '';
                                this.pst_error = '';
                                this.qual_error = '';

                                axios.get('candidate_detail2')
                                    .then(data => this.candidates = data.data)
                                    .catch(error => { });
                            }
                        })
                }
            },
        },
        mounted() {

            axios.get('candidate_detail2')
                .then(data => this.candidates = data.data)
                .catch(error => { });

            axios.get('job_detail2')
                .then(data => {
                    this.p_detail = data.data
                    this.options = [];

                 var $this = this;
 for (var i = 0; i < $this.p_detail.length; i++) {
 this.options.push($this.p_detail[i].PostTitle);
  }
                })
                .catch(error => { });

        },

    }
</script>
