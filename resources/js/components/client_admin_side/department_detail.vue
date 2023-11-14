<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Department</h4>
                                    </div>
                                    <div class="card-body">
                                        <p v-if="errors.length">
                                            <b>Please correct the following error(s):</b>
                                            <ul>
                                                <li v-for="error in errors" style="color:red;">{{ error }}</li>
                                            </ul>
                                        </p>
                                        <form class="form form-vertical">
                                            <div class="row">
                                                <div class="col-7">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="first-name-vertical">Department Name</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" v-model='department_name' placeholder="Must be Unique">
                                                    </div>
                                                </div>
                                                <div class="col-5" style="margin-top:28px;">
                                                    <button type="button" @click="submit_department()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                                    <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ User Sidebar -->

                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div style="margin-bottom:10px;">
                                            <div class="col-md-7">
                                                <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" placeholder="Search By Department name" />
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Department Name</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="adsdata1 in adsdata.data">
                                                        <td>{{adsdata1.department_name}}</td>
                                                        <td>
                                                            <span v-if="adsdata1.dd_status=='Active'" class="badge bg-light-success">{{adsdata1.dd_status}}</span>
                                                            <span v-else class="badge bg-light-danger">{{adsdata1.dd_status}}</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                        <circle cx="12" cy="5" r="1"></circle>
                                                                        <circle cx="12" cy="19" r="1"></circle>
                                                                    </svg>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <button v-if="adsdata1.dd_status=='Active'" @click="deactive(adsdata1.id)" class="dropdown-item">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-small-4 me-50">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg>Suspended
                                                                    </button>
                                                                    <button v-if="adsdata1.dd_status=='Not Active'" @click="active(adsdata1.id)" class="dropdown-item">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-small-4 me-50">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg>Activate
                                                                    </button>
                                                                    <a @click="fetch_department(adsdata1.id)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editDepartment">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                                    </a>
                                                                    <a @click="delete_department(adsdata1.id)" class="dropdown-item">
                                                                        <i class="fa-solid fa-trash-can"></i> Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="text-align:center;padding-top:20px">
                                            <pagination :limit="limit" :data="adsdata" @pagination-change-page="getResults"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="editDepartment" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Edit department</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Location Name</label>
                                            <input type="text" v-model="ed_department_name" class="form-control" placeholder="Department name">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" @click="update_department()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
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
    export default {
        data() {
            return {
                limit: 10,
                errors: [],
                department_name: '',
                ed_department_name: '',
                dep_id: '',
                keyword1: '',
                adsdata: {},
            }
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        methods: {
            delete_department(id) {
                axios.get('delete_department/' + id)
                    .then(data => {
                        this.$toastr.s("Department Deleted Successfully!", "Deleted");
                        this.adsdata = data.data;
                    })
                    .catch(error => { });

            },
            update_department() {
                axios.post('./update_department', {
                    dep_id: this.dep_id,
                    ed_department_name: this.ed_department_name,
                })
                    .then(data => {
                        if (data.data == 'Department matched!') {
                            this.$toastr.e("Department Already Exists!", "Error!");
                        }
                        else {
                            this.$toastr.s("Department updated Successfully!", "Congratulations!");
                            this.dep_id = '';
                            this.ed_department_name = '';
                            this.adsdata = data.data;
                        }
                    })
                    .catch(error => this.error = error.responce.data.errors)
            },
            fetch_department(id) {
                axios.get('fetch_department/' + id)
                    .then(responce => {
                        this.dep_id = responce.data[0].id;
                        this.ed_department_name = responce.data[0].department_name;
                    })
                    .catch(error => { });
            },
            getResults(page = 1) {

                axios.get('./search_department/?page=' + page, { params: { keyword1: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => console.log(error));
            },
            submit_department() {
                this.errors = [];
                if (this.department_name == '') {
                    this.errors.push('Department Name Required!');
                } else {

                    axios.post('./submit_department', {
                        department_name: this.department_name,

                    })
                        .then(data => {
                            if (data.data == 'Department Already Exists In Your Company') {
                                this.$toastr.e("Designation Already Exists In Your Company", "Please try again");
                            } else {
                                this.$toastr.s("Department Saved Successfully", "Congratulations");
                                this.department_name = '';

                                this.adsdata = data.data;
                            }

                        })
                        .catch(error => this.error = error.response.data.errors)
                }
            },
            deactive(id) {
                axios.get('./deactivate_department/' + id)
                    .then((response) => this.adsdata = response.data)
                    .catch(error => console.log(error));
            },
            active(id) {
                axios.get('./activate_department/' + id)
                    .then((response) => this.adsdata = response.data)
                    .catch(error => console.log(error));
            },
        },
        mounted() {
            this.getResults();
        }
    }
</script>
