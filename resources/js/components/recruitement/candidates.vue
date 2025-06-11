<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/recruitment/recDashboard"
                                        style="text-decoration: none;">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Candidates
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!--Search code-->
                    <div class="card border-0 top-radius bottom-radius bottom-0 m-0 p-3">
                        <div class="card-body  pt-3 pb-3">
                            <!-- <h4 class="card-title">Search & Filter</h4> -->
                            <div class="row">
                                <div class="col-md-2 ">
                                    <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">Name</label>
                                    <input type="text" @change="search_candidate()" v-model="s_name"
                                        class="form-control p-2" placeholder="Name" />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">Address</label>
                                    <input @change="search_candidate()" type="text" v-model="s_address"
                                        class="form-control p-2" placeholder="Address" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><img class="px-1" :src="images.solar_filter_linear"
                                            alt="icon">Post Applied</label>
                                    <!-- <select @change="search_candidate()" v-model="s_post" class="form-select mb-md-0 mb-2">
                                    <option value="">Any Post</option>
                                    <option v-for='p_detail1 in p_detail' :value='p_detail1.PostTitle'>{{p_detail1.PostTitle}}</option>
                                </select> -->
                                    <multiselect @input="search_candidate()" v-model="s_post" :show-labels="false"
                                        placeholder="Any Post" :options="options">
                                    </multiselect>
                                </div>

                                <div class="col-md-2 d-flex align-items-center mt-4">
                                    <!-- <div style="height:27px;"></div> -->
                                    <button @click="search_candidate()"
                                        class="dt-button add-new btn btn-primary bg-primary py-2 px-5" tabindex="0"
                                        type="button"><span>Search</span></button>
                                </div>
                                <div
                                    class="col-sm-12 col-md-3 col-lg-3 ps-xl-75 ps-0  d-flex align-items-center justify-content-end mt-4">
                                    <div v-if="hasPermission('Add new Candidates')" style="float:left;">
                                        <router-link to="" class="dt-button add-new btn btn-primary bg-primary p-2"
                                            data-bs-toggle="modal" data-bs-target="#addcandidate" tabindex="0"
                                            type="button"><span>+ Add new
                                                candidate</span></router-link>
                                    </div>
                                </div>
                                <!-- <div
                                    class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75 py-2">
                                    <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                        <div v-if="hasPermission('Add new Candidates')" style="float:left;">
                                            <router-link to="" class="dt-button add-new btn btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#addcandidate" tabindex="0"
                                                type="button"><span>+ Add new
                                                    candidate</span></router-link>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div style="margin-bottom:20px;"
                        class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                        <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                            <div v-if="hasPermission('Add new Candidates')" style="float:left;">
                                <router-link to="" class="dt-button add-new btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addcandidate" tabindex="0" type="button"><span>+ Add new
                                        candidate</span></router-link>
                            </div>
                        </div>
                    </div> -->

                    <div class="container my-4 p-0">

                        <!-- Top Headings -->
                        <div class="d-flex border-bottom mb-4 top-menu">
                            <p class="me-4 active">CANDIDATES DETAIL</p>
                            <!-- <p class="me-4">JOB DETAIL</p> -->
                            <!-- <p class="me-4">TIMELINE & NOTES</p> -->
                            <!-- <p>HIRING TEAM</p> -->
                        </div>

                        <!-- Candidate List -->
                        <div v-for='candidates1 in candidates'
                            class="card border-0 top-radius bottom-radius bottom-0 m-04 p-3 candidate-card">
                            <div class="d-flex align-items-center">
                                <img src="public/app-assets/images/portrait/small/avatar-s-9.jpg" alt="avatar"
                                    class="rounded-circle me-3" height="55" width="55" />
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ candidates1.CandName }}</h5>
                                    <small
                                        class=" text-primary btn-outline-info top-radius bottom-radius px-2 mb-2 ">84%
                                        Overall</small>
                                    <p class="mb-0 mt-2 text-muted">Applied at</p>
                                    <small class="text-muted"><strong>{{ formatDate(candidates1.CreatedOn) }}
                                            — Lahore, Pakistan</strong></small>
                                </div>
                                <div class="flex-grow-1 mt-5">
                                    <p class="mb-0 text-muted">Post Applied</p>
                                    <small class="text-muted"><strong>{{ candidates1.PostTitle }}</strong></small>
                                </div>
                                <div class="flex-grow-1 mt-5">
                                    <p class="mb-0 text-muted">Status</p>
                                    <span v-if="candidates1.stats == 'Applied'"
                                        class="badge badge-glow bg-info">Applied</span>
                                    <span v-else-if="candidates1.stats == 'Shortlisted'"
                                        class="badge badge-glow bg-success">Shortlisted</span>
                                    <span v-else-if="candidates1.stats == 'Rejected'"
                                        class="badge badge-glow bg-danger">Rejected</span>
                                    <span v-else-if="candidates1.stats == 'Pending'"
                                        class="badge badge-glow bg-secondary">Pending</span>
                                    <span v-else class="badge badge-glow bg-dark">{{ candidates1.stats }}</span>
                                </div>
                                <div class="ms-auto d-flex gap-2">
                                    <button @click="fetch_candidate_detail(candidates1.CandID, 'view_candidate')"
                                        class="btn btn-outline-primary btn-sm rounded-circle btn-circle"><i
                                            class="fa fa-eye" aria-hidden="true"></i></button>
                                    <button data-bs-toggle="offcanvas"
                                        @click="fetch_candidate_detail(candidates1.CandID, 'editcandidate')"
                                        class="btn btn-outline-secondary btn-sm rounded-circle btn-circle"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <button v-if="candidates1.stats != 'Shortlisted'" data-bs-toggle="modal"
                                        @click="fetch_candidate_detail(candidates1.CandID)" data-bs-target="#upd_sts"
                                        class="btn btn-outline-secondary btn-sm rounded-circle btn-circle"><i class="fa fa-arrows-rotate"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <a class="page-link " href="#"
                                        @click.prevent="getCandidates(pagination.current_page - 1)">Previous</a>
                                </li>

                                <li class="page-item" v-for="page in pagination.last_page" :key="page"
                                    :class="{ active: page === pagination.current_page }">
                                    <a class="page-link " href="#" @click.prevent="getCandidates(page)">{{ page }}</a>
                                </li>

                                <li class="page-item"
                                    :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <a class="page-link" href="#"
                                        @click.prevent="getCandidates(pagination.current_page + 1)">Next</a>
                                </li>
                            </ul>
                        </nav>

                        <!-- Duplicate for multiple candidates -->
                        <!-- <div class="card mb-3 p-3 candidate-card">
                            <div class="d-flex align-items-center">
                                <img src="https://randomuser.me/api/portraits/men/11.jpg" class="rounded-circle me-3"
                                    height="55" width="55" />
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Jacob Jones</h5>
                                    <span class="badge bg-primary mb-1">84% Overall</span>
                                    <p class="mb-0 text-muted">Applied at</p>
                                    <small class="text-muted">27 May, 2025 — Lahore, Pakistan</small>
                                </div>
                                <div class="ms-auto d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm"><i class="bi bi-eye"></i></button>
                                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    <button class="btn btn-outline-secondary btn-sm"><i
                                            class="bi bi-bookmark"></i></button>
                                </div>
                            </div>
                        </div> -->

                    </div>

                    <table class="user-list-table table ">

                        <thead class="table-light">
                            <tr>
                                <th class=" text-center sticky-th-center">Candidate Name</th>
                                <th class=" text-center sticky-th-center">Post applied</th>
                                <th class=" text-center sticky-th-center">Qualification</th>
                                <th class=" text-center sticky-th-center">Experiance</th>
                                <th class=" text-center sticky-th-center">Status</th>
                                <th class=" text-center sticky-th-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for='candidates1 in candidates'>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center mt-2">
                                        <div class="avatar me-75">
                                            <!-- <img :src="'/app-assets/images/portrait/small/avatar-s-9.jpg'" alt="avatar" height="40" width="40" /> -->

                                            <img src="public/app-assets/images/portrait/small/avatar-s-9.jpg"
                                                alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">{{ candidates1.CandName }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">{{ candidates1.PostTitle }}</td>
                                <td class="align-middle text-center" v-html="candidates1.Qualification"></td>
                                <td class="align-middle text-center">{{ candidates1.experience }}
                                </td>
                                <td class="align-middle text-center">
                                    <span v-if="candidates1.stats == 'Applied'"
                                        class="badge badge-glow bg-info">Applied</span>
                                    <span v-else-if="candidates1.stats == 'Shortlisted'"
                                        class="badge badge-glow bg-success">Shortlisted</span>
                                    <span v-else-if="candidates1.stats == 'Rejected'"
                                        class="badge badge-glow bg-danger">Rejected</span>
                                    <span v-else-if="candidates1.stats == 'Pending'"
                                        class="badge badge-glow bg-secondary">Pending</span>
                                    <span v-else class="badge badge-glow bg-dark">{{ candidates1.stats }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a data-bs-toggle="modal" class="dropdown-item"
                                                @click="fetch_candidate_detail(candidates1.CandID)"
                                                data-bs-target="#viewcandidate">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                </svg> View profile
                                            </a>
                                            <!-- <a class="dropdown-item"
                                                @click="fetch_candidate_detail(candidates1.CandID)">
                                                <i class="bi bi-eye"></i> View profile
                                            </a> -->

                                            <a data-bs-toggle="modal"
                                                @click="fetch_candidate_detail(candidates1.CandID)"
                                                data-bs-target="#editcandidate" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg> Edit candidate
                                            </a>
                                            <span v-if="candidates1.stats != 'Shortlisted'" data-bs-toggle="modal"
                                                @click="fetch_candidate_detail(candidates1.CandID)"
                                                data-bs-target="#upd_sts" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                                    <path fill-rule="evenodd"
                                                        d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Candidate Details</h1>
                                        <p>This is job application form</p>
                                    </div>
                                    <div class="d-flex">
                                        <img v-if="url" :src="url" id="account-upload-img"
                                            class="uploadedAvatar rounded me-50" alt="profile image"
                                            style="width:155px;height:180px">
                                        <img v-else src="public/app-assets/images/portrait/small/profile.jpg"
                                            id="account-upload-img" class="uploadedAvatar rounded me-50"
                                            alt="profile image">

                                        <div class="d-flex align-items-end mt-75 ms-1">
                                            <div>
                                                <input type="file" id="image_file" :v-model="image_file"
                                                    name="image_file" @change="onFileChange" accept="image/*"
                                                    class="input-file">
                                                <button type="button" @click="clear_image()" id="account-reset"
                                                    class="btn btn-sm btn-outline-secondary mb-75 waves-effect">Clear</button>
                                                <p class="mb-0">Add profile image(png, jpg, jpeg. ) </p>
                                            </div>
                                        </div>

                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Candidate Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="a_c_name" class="form-control"
                                                placeholder="Enter full name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_name == ''">{{
                                                name_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Father Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="a_c_father" class="form-control"
                                                placeholder="Father name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_father == ''">{{
                                                father_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Mobile Number</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <masked-input v-model="a_c_mobile" class="form-control account-number-mask"
                                                mask="0311 -1111111" placeholder="Mobile number"></masked-input>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="a_c_mobile == ''">{{
                                                mobile_error }}</span>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Email</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="a_c_email" class="form-control"
                                                placeholder="abc@xyz.com" />
                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="!validEmail(a_c_email)">{{ a_email_error }}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" v-model="a_c_address" class="form-control"
                                                placeholder="Complete address" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Designation</label>
                                            <input type="text" v-model="a_c_job_title" class="form-control"
                                                placeholder="Current designation" />
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Experiance</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <select id="modalAddressCountry" v-model="a_c_experiance"
                                                class="select2 form-select">
                                                <option value="">Select</option>
                                                <option value="None">None</option>
                                                <option value="Fresher">Fresher</option>
                                                <option value="0-1 year">0-1 year</option>
                                                <option value="1-3 years">1-3 years</option>
                                                <option value="4-5 years">4-5 years</option>
                                                <option value="5+ years">5+ years</option>
                                            </select>
                                            <multiselect style="margin-right: 10px;" v-model="a_c_experiance"
                                                :show-labels="false" placeholder="Select" :options="options1">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="a_c_experiance == ''">{{ exp_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Rating</label>
                                            <b-form-rating class="col-12 col-md-6" variant="primary"
                                                v-model="star_value" show-clear></b-form-rating>
                                            <input type="file" class="form-control" ref="a_c_pic" accept="Image/*" />
                                            <span style="color: #DB4437; font-size: 11px;"></span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Resume</label>
                                            <input type="file" class="form-control"
                                                accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Salary</label>
                                            <input type="number" v-model="a_c_crt_salary" class="form-control"
                                                placeholder="Current salary" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Position appling for</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <select v-model="a_c_post_title" class="form-select"
                                                aria-label="Default select example">
                                                <option value="adadd" selected>Select</option>
                                                <option v-for='p_detail1 in p_detail' :value='p_detail1.JobID'>
                                                    {{ p_detail1.PostTitle }}</option>
                                            </select>

                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="a_c_post_title == ''">{{ pst_error }}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Highest qualification</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <vue-editor style="height:200px;" v-model="a_c_qualification"
                                                placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="a_c_qualification == ''">{{ qual_error }}</span>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Skill set</label>
                                            <vue-editor style="height:200px;" v-model="a_c_skill"
                                                placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Expected Salary</label>
                                            <input type="number" v-model="a_c_exp_salary" class="form-control"
                                                placeholder="Expected Salary" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Applied Via</label>
                                            <input type="text" v-model="applied_via" class="form-control"
                                                placeholder="Applied Via" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled" @click="delay()" class="btn btn-primary me-1"
                                                data-bs-dismiss="modal" aria-label="Close">Add</button>
                                            <button type="reset" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
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

                    <!-- <div class="offcanvas offcanvas-end" tabindex="-1" id="view_candidate" style="width: 70%;">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">Candidate Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div class="text-center mb-2">
                                <div class="justify-content-start align-items-center mb-1">
                                    <div class="avatar mb-1">
                                        <img src="public/app-assets/images/portrait/small/avatar-s-11.jpg"
                                            alt="avatar img" height="60" width="60" />
                                    </div>
                                    <div class="profile-user-info mb-2">
                                        <h3 class="mb-0">{{ e_c_name }}</h3>
                                        <small class="text-muted">for {{ e_c_job_title }}</small>
                                    </div>
                                </div>

                                <table class="table">
                                    <tr>
                                        <td>Status:</td>
                                        <td><span class="badge bg-danger">Applied</span></td>
                                    </tr>
                                    <tr>
                                        <td>Father's Name:</td>
                                        <td>{{ e_c_father }}</td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td>{{ e_c_address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mobile:</td>
                                        <td>{{ e_c_mobile }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{ e_c_email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Qualification:</td>
                                        <td v-html="e_c_qualification"></td>
                                    </tr>
                                    <tr>
                                        <td>Skills:</td>
                                        <td v-html="e_c_skill"></td>
                                    </tr>
                                    <tr>
                                        <td>Current Salary:</td>
                                        <td>{{ e_c_crt_salary }}</td>
                                    </tr>
                                    <tr>
                                        <td>Expected Salary:</td>
                                        <td>{{ e_c_exp_salary }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rating:</td>
                                        <td>
                                            <b-form-rating readonly v-model="ed_rating"
                                                variant="primary"></b-form-rating>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Designation:</td>
                                        <td>{{ e_c_job_title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Applied Via:</td>
                                        <td>{{ applied_via }}</td>
                                    </tr>
                                </table>
                            </div>

                            <button class="btn btn-secondary w-100" data-bs-dismiss="offcanvas">Back</button>
                        </div>
                    </div> -->
                    <!-- Offcanvas Trigger Button -->
                    <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#candidateDetail">
  View Candidate
</button> -->


                    <!-- Offcanvas view candidate  -->
                    <div id="view_candidate" class="offcanvas offcanvas-end " tabindex="-1"
                        style="visibility: visible; width: 70%;">
                        <div class="offcanvas-header border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm rounded-circle">←</button>
                                <span class="text-muted">01 out of 23</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>

                        <div class="offcanvas-body">

                            <!-- Profile Section -->
                            <div class="d-flex align-items-center mb-4">
                                <img src="../../../../public/images/logo/sagroup.png" class="rounded-circle"
                                    alt="Profile" style="height: 70px; width: 70px;">
                                <div class="ms-3">

                                    <p class="mb-0 fw-bolder" style="font-size: 1.2rem;">{{ e_c_name }} <span
                                            style="font-size: 0.9rem; margin-left: 2rem;"
                                            class=" btn-outline-primary top-radius bottom-radius px-2 mb-1 "> 84%
                                            Overall</span></p>
                                    <div class="d-flex mt-2">
                                        <div>
                                            <small class="mb-0 text-muted">Applied at</small>
                                            <p class="text-muted"><strong>{{ formatDate(created_on)
                                                    }}</strong></p>
                                        </div>
                                        <div class="ms-4">
                                            <small class="mb-0 text-muted">Job Applied at</small>
                                            <p class="text-muted"><strong>{{ e_c_job_title
                                                    }}</strong></p>
                                        </div>
                                    </div>
                                    <!-- <small class="text-muted">Applied at: <p><strong>{{ formatDate(created_on) }}</strong></p> </small><br> -->
                                    <!-- <small class="text-muted">Applied for: <p><strong>{{ e_c_job_title }}</strong></p></small> -->
                                </div>
                                <div class="ms-auto d-flex align-items-center gap-2">
                                    <button class="btn btn-outline-secondary btn-lg">...</button>
                                    <button class="btn btn-primary btn-lg">Send Mail</button>
                                </div>
                            </div>

                            <!-- Simple Text Navigation -->
                            <div class="d-flex gap-4 mb-4 border-bottom pb-2">
                                <a href="#" class="text-decoration-none text-dark fw-semibold">Job Application</a>
                                <!-- <a href="#" class="text-decoration-none text-muted">Resume</a> -->
                                <!-- <a href="#" class="text-decoration-none text-muted">Form Submission</a> -->
                                <!-- <a href="#" class="text-decoration-none text-muted">Interviews</a> -->
                            </div>

                            <!-- Job Applied + Personal Info -->
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="card top-radius bottom-radius border-0 p-3">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold">Job Applied</h6>
                                            <a href="#" class="small text-primary">View Details</a>
                                        </div>
                                        <p class="mb-2 fw-semibold">{{ e_c_job_title }}</p>
                                        <div class="d-flex gap-3 mb-3">
                                            <span class="badge bg-light text-dark">Full Time</span>
                                            <span class="badge bg-light text-dark">Onsite</span>
                                            <span class="badge bg-light text-dark">Creative</span>
                                        </div>
                                        <hr>
                                        <div class="row text-muted">
                                            <div class="col-4">
                                                <small>Experience in Years</small>
                                                <p class="fw-bold">{{ e_c_experiance }}</p>
                                            </div>
                                            <div class="col-4">
                                                <small>Current Employee</small>
                                                <p class="fw-bold">{{ curr_designation }}</p>
                                            </div>
                                            <div class="col-4">
                                                <small>Current Salary</small>
                                                <p class="fw-bold">{{ e_c_crt_salary }}</p>
                                            </div>
                                            <div class="col-4">
                                                <small>Expected Salary</small>
                                                <p class="fw-bold">{{ e_c_exp_salary }}</p>
                                            </div>
                                            <div class="col-4">
                                                <small>Referral</small>
                                                <p class="fw-bold">{{ applied_via }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Candidate Score -->
                                    <div class="card p-3 mt-4 top-radius bottom-radius border-0">
                                        <h6 class="fw-bold">Candidate Score</h6>
                                        <div class="d-flex align-items-center gap-4">
                                            <div class="text-center">
                                                <h1 class="text-primary fw-bold mb-0">84%</h1>
                                                <small class="text-muted">Overall Score</small>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Applying</span><span>85%</span>
                                                </div>
                                                <div class="progress mb-2" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" style="width: 85%;"></div>
                                                </div>
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Screening</span><span>65%</span>
                                                </div>
                                                <div class="progress mb-2" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" style="width: 65%;"></div>
                                                </div>
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Interview</span><span>48%</span>
                                                </div>
                                                <div class="progress mb-2" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" style="width: 48%;"></div>
                                                </div>
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Documents</span><span>0%</span>
                                                </div>
                                                <div class="progress mb-2" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" style="width: 0%;"></div>
                                                </div>
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Onboard</span><span>0%</span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-warning" style="width: 0%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-3 mb-3 top-radius bottom-radius border-0">
                                        <h6 class="fw-bold">Personal Information</h6>
                                        <div class="text-muted small">
                                            <p>Email: <span class="text-dark fw-bold"> {{ e_c_email }}</span></p>
                                            <p>Phone: <span class="text-dark fw-bold"> {{ e_c_mobile }}</span></p>
                                            <p>Address: <span class="text-dark fw-bold"> {{ e_c_address }}</span></p>
                                            <p>DOB: <span class="text-dark fw-bold"> April 24, 1999 temp</span></p>
                                            <p>Gender: <span class="text-dark fw-bold"> Male temp</span></p>
                                        </div>
                                    </div>

                                    <div class="card p-3 top-radius bottom-radius border-0">
                                        <h6 class="fw-bold">Education Information</h6>
                                        <div class="text-muted small">
                                            <p>University: <span class="text-dark fw-bold"> Lahore University
                                                    temp</span></p>
                                            <p :key="e_c_qualification">Education: <span class="text-dark fw-bold">{{
                                                    e_c_qualification }}</span>
                                            </p>
                                            <p>Year: <span class="text-dark fw-bold"> 2022 temp</span></p>
                                            <p>Reference: <span class="text-dark fw-bold"> {{ applied_via }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="modal fade" id="viewcandidate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <div class="justify-content-start align-items-center mb-1">

                                            <div class="avatar">
                                                <img src="public/app-assets/images/portrait/small/avatar-s-11.jpg"
                                                    alt="avatar img" height="50" width="50" />
                                            </div>

                                            <div class="profile-user-info">
                                                <h3 class="mb-0">{{ e_c_name }}</h3>
                                                <small class="text-muted">
                                                    for {{ e_c_job_title }}
                                                </small>
                                            </div>
                                        </div>
                                        <center>
                                            <table>
                                                <tr>
                                                    <td class="col-md-4"><span class="fw-bolder me-25">Status:</span>
                                                    </td>
                                                    <td class="col-md-4"><span
                                                            class="badge badge-light-danger">Applied</span></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-4"><span class="fw-bolder me-25">Father's
                                                            Name:</span></td>
                                                    <td class="col-md-4"><span>{{ e_c_father }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Address:</span></td>
                                                    <td><span>{{ e_c_address }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Mobile Number:</span></td>
                                                    <td><span>{{ e_c_mobile }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">E-mail:</span></td>
                                                    <td><span>{{ e_c_email }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Qualification:</span></td>
                                                    <td><span v-html="e_c_qualification"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Skills:</span></td>
                                                    <td><span v-html="e_c_skill"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Current Salary:</span></td>
                                                    <td><span>{{ e_c_crt_salary }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Expected Salary:</span></td>
                                                    <td><span>{{ e_c_exp_salary }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Rating:</span></td>
                                                    <td><b-form-rating class="col-12 col-md-6" readonly
                                                            variant="primary" v-model="ed_rating"
                                                            show-clear></b-form-rating></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Designation:</span></td>
                                                    <td><span>{{ e_c_job_title }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="fw-bolder me-25">Applied Via:</span></td>
                                                    <td><span>{{ this.applied_via }}</span></td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / View candidate modal-->
                    <!-- offcanvs Edit candidate-->
                    <div class="offcanvas offcanvas-end" style="width: 70%;" tabindex="-1" id="editcandidate"
                        aria-labelledby="editcandidateLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="editcandidateLabel">
                                Edit <label>{{ e_c_name_h }}</label>'s details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form id="editUserForm" class="row gy-1" onsubmit="return false">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Candidate Name</label>
                                    <input type="text" v-model="e_c_name" class="form-control"
                                        placeholder="Enter full name" />
                                    <span class="text-danger small" v-if="e_c_name == ''">{{ ed_name_error }}</span>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Father Name</label>
                                    <input type="text" v-model="e_c_father" class="form-control"
                                        placeholder="Father name" />
                                    <span class="text-danger small" v-if="e_c_father == ''">{{ ed_father_error }}</span>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Mobile Number</label>
                                    <masked-input class="form-control account-number-mask" mask="0311-1111111"
                                        v-model="e_c_mobile" placeholder="Mobile number"></masked-input>
                                    <span class="text-danger small" v-if="e_c_mobile == ''">{{ ed_mobile_error }}</span>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="text" v-model="e_c_email" class="form-control"
                                        placeholder="abc@xyz.com" />
                                    <span class="text-danger small" v-if="!validEmail(e_c_email) || e_c_email == ''">{{
                                        ed_email_error }}</span>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" v-model="e_c_address" class="form-control"
                                        placeholder="Complete address" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Current Designation</label>
                                    <input type="text" v-model="curr_designation" class="form-control"
                                        placeholder="Current designation" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Experience</label>
                                    <multiselect v-model="e_c_experiance" :show-labels="false" placeholder="Select"
                                        :options="options1">
                                    </multiselect>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Rating</label>
                                    <b-form-rating class="col-12 col-md-6" variant="primary" v-model="ed_rating"
                                        show-clear></b-form-rating>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Resume</label>
                                    <input type="file" class="form-control"
                                        accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Current Salary</label>
                                    <input type="number" v-model="e_c_crt_salary" class="form-control"
                                        placeholder="Current salary" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Position Applying For</label>
                                    <select v-model="e_c_post_title" class="form-select">
                                        <option selected>Select</option>
                                        <option v-for="p_detail1 in p_detail" :value="p_detail1.JobID">
                                            {{ p_detail1.PostTitle }}
                                        </option>
                                    </select>
                                    <span class="text-danger small"
                                        v-if="e_c_post_title == '' || e_c_post_title == 'Select'">
                                        {{ ed_pst_error }}
                                    </span>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Expected Salary</label>
                                    <input type="number" v-model="e_c_exp_salary" class="form-control"
                                        placeholder="Expected salary" />
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Applied Via</label>
                                    <input type="text" v-model="applied_via" class="form-control"
                                        placeholder="Applied via" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Highest Qualification</label>
                                    <vue-editor style="height:200px;" v-model="e_c_qualification"
                                        placeholder="Add Educational Requirements"></vue-editor>
                                    <span class="text-danger small" v-if="e_c_qualification == ''">{{ qual_error
                                    }}</span>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Skill Set</label>
                                    <vue-editor style="height:200px;" v-model="e_c_skill"
                                        placeholder="Add Skills"></vue-editor>
                                </div>

                                <div class="col-12 text-center mt-2 pt-2">
                                    <button :disabled="disabled1" @click="delay1()" type="submit"
                                        class="btn btn-primary me-1" data-bs-dismiss="offcanvas">Update</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div id="editcandidate" class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h2 class="mb-1">Edit <label>{{ e_c_name_h }}</label>'s details</h2>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Candidate Name</label>
                                            <input type="text" v-model="e_c_name" class="form-control"
                                                placeholder="Enter full name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_name == ''">{{
                                                ed_name_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Father Name</label>
                                            <input type="text" v-model="e_c_father" class="form-control"
                                                placeholder="Father name" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_father == ''">{{
                                                ed_father_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Mobile Number</label>
                                            <masked-input class="form-control account-number-mask" mask="0311-1111111"
                                                v-model="e_c_mobile" placeholder="Mobile number"></masked-input>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="e_c_mobile == ''">{{
                                                ed_mobile_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="text" v-model="e_c_email" class="form-control"
                                                placeholder="abc@xyz.com" />
                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="!validEmail(e_c_email) || e_c_email == ''">{{ ed_email_error
                                                }}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" v-model="e_c_address" class="form-control"
                                                placeholder="Complete address" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Designation</label>
                                            <input type="text" v-model="e_c_job_title" class="form-control"
                                                placeholder="Current designation" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Experiance</label>
                                            <select id="modalAddressCountry" v-model="e_c_experiance"
                                                class="select2 form-select">
                                                <option value="">Select</option>
                                                <option value="Fresher">Fresher</option>
                                                <option value="0-1 year">0-1 year</option>
                                                <option value="1-3 years">1-3 years</option>
                                                <option value="4-5 years">4-5 years</option>
                                                <option value="5+ years">5+ years</option>
                                            </select>
                                            <multiselect style="margin-right: 10px;" id="modalAddressCountry"
                                                v-model="e_c_experiance" :show-labels="false" placeholder="Select"
                                                :options="options1">
                                            </multiselect>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Rating</label>
                                            <b-form-rating class="col-12 col-md-6" variant="primary" v-model="ed_rating"
                                                show-clear></b-form-rating>
                                            <input type="file" class="form-control" ref="a_c_pic" accept="Image/*" />
                                            <span style="color: #DB4437; font-size: 11px;"></span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Resume</label>
                                            <input type="file" class="form-control"
                                                accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Current Salary</label>
                                            <input type="number" v-model="e_c_crt_salary" class="form-control"
                                                placeholder="Current salary" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Position appling for</label>
                                            <select v-model="e_c_post_title" class="form-select"
                                                aria-label="Default select example">
                                                <option selected>Select</option>
                                                <option v-for='p_detail1 in p_detail' :value='p_detail1.JobID'>
                                                    {{ p_detail1.PostTitle }}</option>
                                            </select>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="e_c_post_title == '' || e_c_post_title == 'Select'">{{
                                                    ed_pst_error }}</span>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Expected Salary</label>
                                            <input type="number" v-model="e_c_exp_salary" class="form-control"
                                                placeholder="Expected Salary" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Applied Via</label>
                                            <input type="text" v-model="applied_via" class="form-control"
                                                placeholder="Applied Via" />
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Highest qualification</label>
                                            <vue-editor style="height:200px;" v-model="e_c_qualification"
                                                placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                v-if="e_c_qualification == ''">{{ qual_error }}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Skill set</label>
                                            <vue-editor style="height:200px;" v-model="e_c_skill"
                                                placeholder="Add Educational Requirements"></vue-editor>
                                            <div style="height:80px;"></div>
                                        </div>
                                        <div class="col-12 col-md-6"></div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled1" @click="delay1()" type="submit"
                                                class="btn btn-primary me-1" data-bs-dismiss="modal"
                                                aria-label="Close">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal" aria-label="Close">
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h2 class="mb-1">Do you want to edit application status of
                                            "<label>{{ e_c_name }}</label>" ?</h2>
                                        <br />
                                        <div class="col-12 text-center" style="float:right; text-align:center;">
                                            <select id="modalAddressCountry" v-model="e_c_status" class=" form-select">
                                                <option value="Applied">Applied</option>
                                                <option value="Shortlisted">Shortlisted</option>
                                                <option value="Rejected">Rejected</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                            <br />
                                            <button type="button" :disabled="disabled2" @click="delay2()"
                                                class="btn btn-primary waves-effect waves-float waves-light"
                                                data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect"
                                                data-bs-dismiss="modal" aria-label="Close">No</button>
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
            options: [],
            options1: ["None", "Fresher", "0-1 year", "1-3 years", "4-5 years", "5+ years"],
            images: {
                solar_filter_linear: "/images/solar_filter_linear.png",
                search_icon: "/images/search_icon.png",
            },
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

            // pagination: {
            //     current_page: 1,
            //     last_page: 1,
            //     per_page: 10,
            //     total: 0
            // },
        }
    },
    methods: {
        formatDate(dateStr) {
            let date = new Date(dateStr);
            let options = { day: '2-digit', month: 'long', year: 'numeric' };
            return date.toLocaleDateString('en-GB', options);
        },

        openOffcanvas(id) {
            let offcanvasEl = document.getElementById(id);
            let offcanvas = new bootstrap.Offcanvas(offcanvasEl);
            offcanvas.show();
        },
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
            console.log(this.e_c_status);
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
        fetch_candidate_detail(id, candidate) {
            this.id1 = id;
            this.canvas_id = candidate;
            console.log(this.canvas_id, "canvas id ha ");

            axios.get('fetch_candidates/' + this.id1)
                .then(responce => {
                    console.log(responce, "for");

                    this.cid = responce.data[0].CandID; //candidate id
                    this.e_c_name = responce.data[0].CandName;
                    this.e_c_name_h = responce.data[0].CandName;
                    this.e_c_father = responce.data[0].FatherHusband;
                    this.e_c_mobile = responce.data[0].Mobile;
                    this.e_c_status = responce.data[0].stats;
                    this.e_c_email = responce.data[0].Email;
                    this.e_c_post_title = responce.data[0].JobID;
                    this.e_c_exp_salary = responce.data[0].ExpectedSalary;
                    this.applied_via = responce.data[0].AppliedVia;
                    this.ed_rating = responce.data[0].Rating;
                    this.e_c_address = responce.data[0].CandAddress;
                    this.e_c_crt_salary = responce.data[0].Curr_Salary;
                    this.curr_designation = responce.data[0].Curr_Designation;
                    this.e_c_qualification = responce.data[0].Qualification;
                    // console.log(this.e_c_qualification,"qualification not get ");

                    this.e_c_experiance = responce.data[0].experience;
                    this.e_c_skill = responce.data[0].Skill;
                    this.created_on = responce.data[0].CreatedOn;
                    this.e_c_job_title = responce.data[0].PostTitle;



                    if (this.canvas_id == 'view_candidate') {
                        this.openOffcanvas('view_candidate');
                    }
                    if (this.canvas_id == 'editcandidate') {
                        this.openOffcanvas('editcandidate');
                    }


                })
                .catch(error => { });
        },
        update_status() {
            console.log(this.e_c_status, "update stats ha ye ");
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
                this.e_c_qualification = this.e_c_qualification.replace(/<\/?p[^>]*>/gi, '').trim();
                this.e_c_skill = this.e_c_skill.replace(/<\/?p[^>]*>/gi, '').trim();
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
                    applied_via: this.applied_via,
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
                            this.applied_via = '';

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
            this.a_c_qualification = this.a_c_qualification.replace(/<\/?p[^>]*>/gi, '').trim();
            this.a_c_skill = this.a_c_skill.replace(/<\/?p[^>]*>/gi, '').trim();

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
                    applied_via: this.applied_via,
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
        getCandidates(page = 1) {
            axios.get(`candidate_detail2?page=${page}`)
                .then(response => {
                    console.log(response.data, "Candidate Detail Response");
                    this.candidates = response.data.data;   // sirf data
                    this.pagination = {
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        per_page: response.data.per_page,
                        total: response.data.total
                    };
                })
                .catch(error => {
                    console.error(error);
                });
        },

    },
    mounted() {
        this.getCandidates();

        // axios.get('candidate_detail2')
        //     .then(data =>
        //         this.candidates = data.data
        //     )
        //     .catch(error => { });



        // axios.get('candidate_detail2')
        //     .then(response => {
        //         console.log(response.data, "Candidate Detail Response"); // <-- yahan console
        //         this.candidates = response.data;
        //     })
        //     .catch(error => {
        //         console.error(error);
        //     });


        axios.get('job_detail2')
            .then(data => {
                this.p_detail = data.data
                console.log(this.p_detail, "position details");

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

.btn-circle {
    width: 40px;
    height: 40px;
}
</style>
