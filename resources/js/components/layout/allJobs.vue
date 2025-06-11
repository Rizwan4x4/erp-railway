<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body" style="border-radius:10px; margin:08%; background: white; opacity: 90%;">
                    <h1 style="text-align:center; ">Current Vacancies</h1>
                    <div style="margin:1%;" class="card-body border-bottom">
                        <div class="row">
                            <div class="col-md-6 user_role">
                                <input v-model="keyword" style="height:55px;" type="text" class="form-control mb-md-0 mb-2" placeholder="Keyword" />
                            </div>
                            <div class="col-md-6 user_role">
                                <input v-model="location" style="height:55px;" type="text" id="UserRole" class="form-control mb-md-0 mb-2" placeholder="Location" />
                            </div>
                            <div class="d-grid col-lg-12 col-md-12 mb-1 mb-lg-0">
                                <button @click="view_jobs()" style="border-radius:2px; margin-top:1%; height:90%;" type="button" class="btn btn-primary waves-effect waves-float waves-light">Search jobs</button>
                            </div>
                            <div class="demo-inline-spacing">
                                <div class="form-check form-check-primary">
                                    <input @change="view_jobs()" v-model="fresh" type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label"> Fresh</label>
                                </div>
                                <div class="form-check form-check-primary">
                                    <input @change="view_jobs()" v-model="experianced" type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label"> Experianced</label>
                                </div>
                                <div class="form-check form-check-primary">
                                    <input @change="view_jobs()" v-model="internship" type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label"> Internship</label>
                                </div>
                                <div class="form-check form-check-primary">
                                    <input @change="view_jobs()" v-model="partTime" type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label"> Part Time</label>
                                </div>
                                <div class="form-check form-check-primary">
                                    <input @change="view_jobs()" v-model="fullTime" type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label"> Full Time</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section id="responsive-datatable">
                        <div style="margin: 1%;" class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-datatable">
                                        <table class="dt-responsive table">
                                            <thead>
                                                <tr>
                                                    <th style="width:14%">Post title</th>
                                                    <th style="width:14%">Department</th>
                                                    <th style="width:25%">Qualification</th>
                                                    <th>Experiance</th>
                                                    <th>Last date</th>
                                                    <th>Positions</th>
                                                    <th style="width:8%">Action</th>
                                                </tr>
                                            </thead>

                                        </table>
                                        <div class="scrool" style="max-height: 300px; overflow-x: hidden; overflow-y: scroll; -ms-overflow-style: none;">
                                            <table class="dt-responsive table">

                                                <tbody>
                                                    <tr v-if="!this.job_detail.length" style="cursor:pointer;">
                                                        There are no listings matching your search.
                                                    </tr>
                                                    <tr v-else style="cursor:pointer;" v-for="job_detail1 in job_detail">
                                                        <td style="width:14%">{{job_detail1.PostTitle}}</td>
                                                        <td style="width:14%">{{job_detail1.Department}}</td>
                                                        <td style="text-align: justify; width: 25%;" v-html="job_detail1.Education"></td>
                                                        <td>{{job_detail1.Experience}}</td>
                                                        <td>{{job_detail1.EndDate}}</td>
                                                        <td>{{job_detail1.JobNumber}}</td>
                                                        <td style="width:10%">
                                                            <button @click="fetch_job(job_detail1.JobID)" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcandidate">
                                                                Apply
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>
                </div>
            </div>
            <!-- Add candidate model-->
            <div class="modal fade" id="addcandidate" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pb-5 px-sm-5 pt-50">
                            <div class="text-center mb-2">
                                <h1 class="mb-1">Appling for job</h1>
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
                                    <input type="text" v-model="a_c_mobile" class="form-control account-number-mask" mask="0311 -1111111" placeholder="Mobile number" />
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
        <select v-model="a_c_experiance" class="form-select" aria-label="Default select example">
            <option value="">Select</option>
            <option value="None">None</option>
            <option value="Fresher">Fresher</option>
            <option value="0-1 year">0-1 year</option>
            <option value="1-3 years">1-3 years</option>
            <option value="4-5 years">4-5 years</option>
            <option value="5+ years">5+ years</option>
        </select>
          <select class="select2 form-select" id="select2-basic">
                <option value="">Select</option>
            <option value="None">None</option>
            <option value="Fresher">Fresher</option>
            <option value="0-1 year">0-1 year</option>
            <option value="1-3 years">1-3 years</option>
            <option value="4-5 years">4-5 years</option>
            <option value="5+ years">5+ years</option>
         </select>
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
                                    <select disabled v-model="a_c_post_title" class="form-select" aria-label="Default select example">
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
                                    <button :disabled="disabled" @click="delay()" class="btn btn-primary me-1">Add</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                        Cancle
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Add candidate model-->
        </div>
    </div>
</template>
<style scoped>
    .scrool::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .scrool {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
</style>

<script>
    const image = "";
    import axios from "axios"
    import MaskedInput from 'vue-masked-input';
    export default {
        data() {
            return {
                url0: window.location.href,
                url: '',
                url1: '',
                url2: '',
                job_detail: {},
                keyword: '',
                keyword1: '',
                location: '',
                location1: '',
                fresh: true,
                experianced: true,

                internship: true,
                partTime: true,
                fullTime: true,

                a_c_name: '',
                a_c_father: '',
                a_c_mobile: '',
                a_c_email: '',
                a_c_address: '',
                a_c_job_title: '',
                a_c_experiance: '',
                star_value: '',
                a_c_crt_salary: '',
                a_c_post_title: '',
                a_c_qualification: '',
                a_c_skill: '',
                a_c_exp_salary: '',

                name_error: '',
                father_error: '',
                a_email_error: '',
                exp_error: '',
                mobile_error: '',
                pst_error: '',
                qual_error: '',

                image_file: '',
                p_detail: {},
                disabled: false,
                timeout: null,
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
                    axios.post('../candidate_public', {
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

                        a_c_companyID: this.url2,
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

                            }
                        })
                }
            },

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                const file = files[0];
                this.image = files[0];
                this.url = URL.createObjectURL(file);
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            get_id() {
                var s_url = this.url0.split('/');
                this.url1 = s_url[5];
                this.url2 = this.url1.slice(0, -1);
            },
            view_jobs() {

                if (this.keyword == '') {
                    this.keyword1 = "All";
                }
                else {
                    this.keyword1 = this.keyword;
                }
                if (this.location == '') {
                    this.location1 = "All";
                }
                else {
                    this.location1 = this.location;
                }
                axios.get('../all_jobs_test/' + this.url2 + '/' + this.keyword1 + '/' + this.location1 + '/' + this.fresh + '/' + this.experianced + '/' + this.internship + '/' + this.partTime + '/' + this.fullTime)
                    .then(data => this.job_detail = data.data)
                    .catch(error => { });

            },
            clear_image() {
                this.url = null;
                this.image_file = '';
                this.image = '';
            },
            fetch_job(jobid) {
                axios.get('../job_detail21/' + this.url2 + '/' + jobid)
                    .then(data => {
                        this.p_detail = data.data;
                        this.a_c_post_title = data.data[0].JobID;
                    }
                    )
                    .catch(error => { });
            }
        },
        mounted() {
            this.get_id();
            this.view_jobs();
            this.fetch_job();


        },

    }
</script>
