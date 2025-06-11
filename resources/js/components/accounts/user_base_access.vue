<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Departments Access
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <!--/ User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Departments Access Detail</h4>
                                        <div style="text-align: right;width: 30% !important;">
                                            <a v-if="hasPermission('AccountinAccounts Configurations  allow-department-access')" style="float: left" data-bs-toggle="modal" data-bs-target="#leavetype2" class="btn btn-primary">Allow access</a>
                                            <div style="float:right">
                                                <div>
                                                    <label>
                                                        <input type="text" name="keyword1" v-model="keyword1" class="form-control" placeholder="Search By email" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive" style="overflow-x: initial !important;">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Username</th>
                                                                                    <th>Departments Access</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="odd" v-for="adsdata1 in adsdata.data">
                                                                                    <td>{{adsdata1.Email}}</td>
                                                                                    <td>
                                                                                        <span v-if="adsdata1.d1!='0'" class="badge badge-glow bg-success">{{adsdata1.d1}}</span>
                                                                                        <span v-if="adsdata1.d2!='0'" class="badge badge-glow bg-success">{{adsdata1.d2}}</span>
                                                                                        <span v-if="adsdata1.d3!='0'" class="badge badge-glow bg-success">{{adsdata1.d3}}</span>
                                                                                        <span v-if="adsdata1.d4!='0'" class="badge badge-glow bg-success">{{adsdata1.d4}}</span>
                                                                                        <span v-if="adsdata1.d5!='0'" class="badge badge-glow bg-success">{{adsdata1.d5}}</span>
                                                                                        <span v-if="adsdata1.d6!='0'" class="badge badge-glow bg-success">{{adsdata1.d6}}</span>
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leavetype2" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Update Employee Access</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Email Id</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction" :show-labels="false" v-model="email_id" :options="options8">
                                </multiselect>
                            </div>
                            <div class="invoice-customer">
                                <label class="form-label" for="modalAddCardName">Departments</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction" :show-labels="false" :multiple="true" v-model="dept_name" :options="options">
                                </multiselect>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled3" @click="delay3()" class="btn btn-primary me-1 mt-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
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
        data() {
            return {
                limit: 10,
                keyword1: '',
                dept_name: null,
                email_id: '',
                options8: [],
                options: [],
                departments: {},
                user_email: {},
                adsdata: {},
                disabled3: false,
                timeout3: null,
            }
        },
        components: {
            Multiselect
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            },
        },
        methods: {
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.submit_empdepartment();
            },
            submit_empdepartment() {
                if (this.email_id == "" || this.dept_name == null) {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post("accounts/submit_userdepartment", {
                        email_id: this.email_id,
                        dept_name: this.dept_name,
                    })
                        .then((data) => {

                            this.adsdata = data.data;
                            this.email_id = '';
                            this.dept_name = null;
                            this.$toastr.s("Updated Employee Access Successfully!", "Congratulations!");

                        })
                }
            },

            fetch_session_id(id) {
                this.fetch_sessoin_id = id;
            },
            getResults(page = 1) {
                axios.get('./search_depart_access/?page=' + page, { params: { keyword1: this.keyword1 } })
                    .then(response => { this.adsdata = response.data })
                    .catch(error => console.log(error));
            },
            submit_payment_Term() {
                axios.post('submit_payment_term', {
                    payment_name: this.payment_name,
                    payment_status: this.payment_status
                })
                    .then(data => {
                        if (data.data == "Submitted") {
                            this.$toastr.s("Payment term has been added successfully", "Congratulations");
                            this.getResult();
                        }
                        else {
                            this.$toastr.e("Payment term not created", "Error!");
                        }
                    })
            },
        },
        mounted() {
            this.getResults();

            axios.get('department_detail2')
                .then(data => {
                    this.departments = data.data
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options.push($this.departments[i].department_name);
                    }
                })
                .catch(error => { });

            axios.get('Accounts/fetch_useremail')
                .then(data => {
                    this.user_email = data.data
                    this.options8 = [];
                    var $this = this;
                    for (var i = 0; i < $this.user_email.length; i++) {
                        this.options8.push($this.user_email[i].email);
                    }
                })
                .catch(error => { });
        }
    }

</script>
