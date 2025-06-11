<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Designation</h4>
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
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="first-name-vertical">Designation Name</label>
                                                        <input type="text" id="first-name-vertical" class="form-control" v-model='designation_name' placeholder="Must be Unique">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button v-if="hasPermission('Add new Designantion')"  type="button" @click="submit_designation()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                                    <button  v-if="hasPermission('Reset Designantion')"  type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/ User Sidebar -->

                            <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">

                                            <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                                <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                                    <div class="me-1">
                                                        <div class="dataTables_filter" style="margin-top:5px">
                                                            <label>
                                                                <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Designation" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Designation Name</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="adsdata1 in adsdata.data">
                                                        <td>{{adsdata1.designation_name}}</td>

                                                        <td>
                                                            <span v-if="adsdata1.d_status=='Active'" class="badge bg-light-success">{{adsdata1.d_status}}</span>
                                                            <span v-else class="badge bg-light-danger">{{adsdata1.d_status}}</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a v-if="hasPermission('Designantion actions')"  class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4">
                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                        <circle cx="12" cy="5" r="1"></circle>
                                                                        <circle cx="12" cy="19" r="1"></circle>
                                                                    </svg>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <button v-if="adsdata1.d_status=='Active'" @click="deactive(adsdata1.id)" class="dropdown-item">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-small-4 me-50">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg>Suspended
                                                                    </button>
                                                                    <button v-if="adsdata1.d_status=='Not Active'" @click="active(adsdata1.id)" class="dropdown-item">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-small-4 me-50">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg>Activate
                                                                    </button>
                                                                    <a @click="fetch_designation(adsdata1.id)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editDesignation">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                        </svg> Edit
                                                                    </a>
                                                                    <a @click="delete_designation(adsdata1.id)" class="dropdown-item">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-small-4 me-50">
                                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        </svg> Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="text-align:center;padding-top:20px">
                                            <pagination :limit="limit" :data="adsdata" @pagination-change-page="getResult"></pagination>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="editDesignation" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Edit designation</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Designation Name</label>
                                            <input type="text" v-model="ed_designation_name" class="form-control" placeholder="Designation name">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" @click="update_designations()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
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
    import {overall_designation} from "../../helper/apihelper";

    export default {
        data() {
            return {
                designation_name: '',
                des_id: '',
                id1:'',
                ed_designation_name: '',
                errors: [],
                keyword1: '',
                adsdata: {},
				limit:3,
            }
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        methods: {
            delete_designation(id) {
                axios.get('delete_designation/' + id)
                    .then(data => {
                        this.$toastr.s("Designation Deleted Successfully!", "Deleted");
                        this.adsdata = data.data;
                    })
                    .catch(error => { });

            },
            update_designations() {
                axios.post('./update_designation', {
                    des_id: this.des_id,
                    ed_designation_name: this.ed_designation_name,
                })
                    .then(data => {
                        if (data.data == 'Designation matched!') {
                            this.$toastr.e("Designation Already Exists In Your Company", "Please try again");
                        }
                        else {
                            this.$toastr.s("Designation updated Successfully", "Congratulations!");
                            this.des_id = '';
                            this.ed_designation_name = '';
                            this.adsdata = data.data;
                        }
                    })
                    .catch(error => this.error = error.responce.data.errors)
            },
            fetch_designation(id) {
                this.id1 = id;
                axios.get('fetch_designations/' + this.id1)
                    .then(responce => {
                        this.des_id = responce.data[0].id;
                        this.ed_designation_name = responce.data[0].designation_name;
                    })
                    .catch(error => { });
            },
            getResults() {

                axios.get('./search_designation', { params: { keyword1: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => console.log(error));
            },
            submit_designation() {
                this.errors = [];
                if (this.designation_name == '') {
                    this.errors.push('Designation Name Required!');
                } else {
                    axios.post('./submit_designation', {
                        designation_name: this.designation_name,

                    })
                        .then(data => {
                            if (data.data == 'Designation Already Exists In Your Company') {
                                this.$toastr.e("Designation Already Exists In Your Company", "Please try again");
                            } else {
                                this.$apihelpers.overall_designation();
                                this.$toastr.s("Designation Saved Successfully", "Congratulations");
                                this.designation_name = '';

                                this.adsdata = data.data
                            }

                        })
                        .catch(error => this.error = error.response.data.errors)
                }
            },
            getResult(page = 1) {

                axios.get('designation_detail?page=' + page)
                    .then(data => this.adsdata = data.data)
                    .catch(error => { });
            },
            deactive(id) {

                axios.get('./deactivate_designation/' + id)
                    .then((response) => this.adsdata = response.data)
                    .catch(error => console.log(error));

            },
            active(id) {

                axios.get('./activate_designation/' + id)
                    .then((response) => this.adsdata = response.data)
                    .catch(error => console.log(error));

            },
        },

        mounted() {
            this.getResult();
        }
    }
</script>
