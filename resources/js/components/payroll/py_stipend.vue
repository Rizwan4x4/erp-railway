<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Stipend
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row" id="basic-table">
                        <div class="col-12">
                            <div class="card">
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <h5 style="padding-left:10px;padding-top:10px">Session Name: {{this.session_name}}</h5>
                                    </div>
                                    <div class="col-md-4 col-12 mb-2 position-relative">
                                        <input type="text" v-model="keyword1" class="form-control" placeholder="Search By Name or Employee code">
                                    </div>
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <button v-if="hasPermission('Payroll apply Stipend')" data-bs-toggle="modal" data-bs-target="#applystipend" class="btn btn-primary">Apply Stipend</button>
                                        <button v-else   class="btn btn-danger">Apply Stipend</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="font-size:10px !important;">Emp. Code</th>
                                                <th style="font-size:10px !important;">Name</th>
                                                <th style="font-size:10px !important;">Apply Date</th>
                                                <th style="font-size:10px !important;">Salary</th>
                                                <th style="font-size:10px !important;">Stipend</th>
                                                <th style="font-size:10px !important;">For duration</th>
                                                <th style="font-size:10px !important;">Description</th>
                                                <th style="font-size:10px !important;">Status</th>
                                                <th style="font-size:10px !important;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in all_stipends.data">
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.EmployeeCode}}</td>
                                                <td style="border-right:1px solid lightgrey">
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals1.Name}} </span></a><small class="emp_post text-muted">
                                                            <span v-if="all_sals1.Department!=null">{{all_sals1.Department}} - </span>
                                                            <span v-else></span>
                                                            <span v-if="all_sals1.Designation!=null">{{all_sals1.Designation}}</span>
                                                            <span v-else></span>
                                                        </small>
                                                    </div>
                                                </td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.CreatedOn | formatDate1}}</td>
                                                <td v-if="all_sals1.Salary>0" style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.Salary}}</td>
                                                <td v-else style="text-align:center;border-right:1px solid lightgrey">0</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{Math.floor(all_sals1.StipendAmount).toLocaleString()}}</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">
                                                    {{all_sals1.StartSession}} to<br />
                                                    <label v-if="all_sals1.EndSession!='' && all_sals1.EndSession!=null">{{all_sals1.EndSession}}</label>
                                                    <label v-else>Onwards</label>
                                                </td>
                                                <td style="border-right:1px solid lightgrey;text-align:center;">{{all_sals1.Description}}</td>
                                                <td style="border-right:1px solid lightgrey;text-align:center;">
                                                    <a v-if="hasPermission('Payroll active or disabel Stipend status') && all_sals1.Status=='Active'" @click="fetch_stipend_detail(all_sals1)" data-bs-toggle="modal" data-bs-target="#hireinterview1">
                                                        <span class="badge bg-gradient-success" style="cursor: pointer;">{{all_sals1.Status}}</span>
                                                    </a>
                                                    <a v-else-if="hasPermission('Payroll active or disabel Stipend status') && all_sals1.Status=='Disabled'" @click="fetch_stipend_detail(all_sals1)" data-bs-toggle="modal" data-bs-target="#hireinterview1">
                                                        <span class="badge bg-gradient-warning" style="cursor: pointer;">{{all_sals1.Status}}</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a v-if="hasPermission('Payroll update Stipend')" @click="fetch_stipend_detail(all_sals1)" data-bs-toggle="modal" data-bs-target="#editpayroll"><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center;padding-top:20px">
                                    <pagination :data="all_stipends" @pagination-change-page="getResult"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="hireinterview1" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Are you sure you want to <label v-if="status=='Active'">disable</label><label v-if="status=='Disabled'">active</label> the stipend of selected employee?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" :disabled="disabled" @click="delay2()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="applystipend" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">

                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Apply Stipend to Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Apply Date</label>
                                            <input v-model="emp_date" type="date" class="form-control" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Employee Code</label>
                                            <multiselect style="margin-right: 10px;" v-model="emp_emp_id" :multiple="true" :options="emp_codes" :show-labels="false">
                                            </multiselect>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="emp_emp_id==''">{{e_emp_id}}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Amount</label>
                                            <input v-model="emp_amount" type="number" class="form-control" placeholder="Enter amount" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="emp_amount==''">{{e_emp_amount}}</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardNumber">Start session</label>
                                            <input v-model="session_name" type="text" readonly class="form-control" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Description</label>
                                            <input v-model="emp_description" type="text" class="form-control" placeholder="Enter description" />
                                        </div>
                                        <div class="col-12 text-center">
                                            <button v-if="emp_emp_id=='' || emp_amount==''" type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1">Apply Now</button>
                                            <button v-else type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Apply Now</button>
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
        <div class="modal fade" id="editpayroll" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h5>Update Stipend of Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Employee Name</label>
                                <input v-model="edit_emp_name" type="text" readonly class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Apply Date</label>
                                <input disabled v-model="edit_date" type="date" class="form-control" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Employee Code</label>
                                <input disabled v-model="edit_emp_id" type="text" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Amount</label>
                                <input v-model="edit_amount" type="number" class="form-control" :placeholder="'Stipend of '+edit_emp_name" />
                                <label style="color: #d93025" v-if="edit_amount==''">{{e_edit_amount}}</label>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Start session</label>
                                <input v-model="edit_session_name" type="text" readonly class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Description</label>
                                <textarea v-model="edit_description" type="text" class="form-control" placeholder="Enter description"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button v-if="edit_emp_id=='' || edit_amount==''" type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1">Update</button>
                                <button v-else type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
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
</template>
<script>
    import Multiselect from 'vue-multiselect';
    import moment from 'moment';
    Vue.filter('formatDate1', function (value) {
        if (value) {
            return moment(String(value)).format('YYYY-MM-DD')
        }
    });
    export default {
        data() {
            return {
                e_emp_amount: '',
                e_emp_id: '',
                e_stipend_id: '',
                e_edit_amount: '',
                status: '',
                emp_codes: [],
                all_stipends: {},
                find_emp: {},
                emp_emp_id: '',
                emp_amount: '',
                emp_description: '',
                emp_date: '',

                keyword1: '',
                session_name: '',
                stipend_id: '',

                edit_emp_id: '',
                edit_emp_name: '',
                edit_session_name: '',
                edit_amount: '',
                edit_description: '',
                edit_arrear_id: '',
                edit_date: '',
                edit_end_session: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,

                disabled2: false,
                timeout2: null,
            }
        },
        components: {
            Multiselect,

        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.applystipend()
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.updatestipend()
            },
            delay2() {
                this.disabled2 = true
                this.timeout2 = setTimeout(() => {
                    this.disabled2 = false
                }, 5000)
                this.update_stipend_status()
            },
            updatestipend() {
                if (this.stipend_id == '' || this.edit_amount == '') {
                    if (this.stipend_id == '') {
                        this.e_stipend_id = 'Select Employee';
                    }
                    else {
                        this.e_stipend_id = '';
                    }
                    if (this.edit_amount == '') {
                        this.e_edit_amount = 'Please enter stipend amount';
                    }
                    else {
                        this.e_edit_amount = '';
                    }
                    this.$toastr.e("Stipend not updated!", "Congratulations");
                }
                else {
                    axios.post('update_stipend', {
                        stipend_id: this.stipend_id,
                        edit_amount: this.edit_amount,
                        edit_description: this.edit_description,
                    })
                        .then(data => {
                            this.$toastr.s("Updated Stipend Successfully!", "Congratulations");
                            this.all_stipends = data.data;
                            this.stipend_id = '';
                            this.status = '';
                            this.edit_session_name = '';
                            this.edit_date = '';
                            this.edit_emp_id = '';
                            this.edit_emp_name = '';
                            this.edit_amount = '';
                            this.edit_description = '';
                        })
                }
            },
            fetch_stipend_detail(stipend) {
                this.stipend_id = stipend.StipendID;
                this.status = stipend.Status;
                this.edit_session_name = stipend.StartSession;
                this.edit_date = stipend.CreatedOn.slice(0, 10);
                this.edit_emp_id = stipend.EmployeeCode;
                this.edit_emp_name = stipend.Name;
                this.edit_amount = stipend.StipendAmount;
                this.edit_description = stipend.Description;
            },
            update_stipend_status() {
                axios.get('./update_stipend_status/' + this.stipend_id + '/' + this.status)
                    .then(response => {
                        this.all_stipends = response.data
                        this.$toastr.s("Stipend Updated Successfully!", "Congratulations");
                        this.stipend_id = '';
                        this.status = '';
                    })
                    .catch(error => console.log(error));
            },
            applystipend() {
                if (this.emp_emp_id == '' || this.emp_amount == '') {
                    if (this.emp_emp_id == '') {
                        this.e_emp_id = 'Select employee';
                    }
                    else {
                        this.e_emp_id = '';
                    }
                    if (this.emp_amount == '') {
                        this.e_emp_amount = 'Enter stipend amount';
                    }
                    else {
                        this.e_emp_amount = '';
                    }
                    this.$toastr.e("please fill required fields!", "Caution");
                }
                else {
                    axios.post('submit_stipend', {
                        emp_emp_id: this.emp_emp_id,
                        emp_amount: this.emp_amount,
                        emp_description: this.emp_description,
                        emp_date: this.emp_date,
                        session_name: this.session_name,
                    })
                        .then(data => {
                            if (data.data.message == 'submit') {
                                this.$toastr.s("Submitted Stipend Successfully!", "Congratulations");
                            }
                            else {
                                this.$toastr.e(data.data, "Error");
                            }
                        })
                }
            },
            getResults(page = 1) {
                axios.get('./search_stipend', { params: { keyword1: this.keyword1 } })
                    .then(response => this.all_stipends = response.data)
                    .catch(error => console.log(error));
            },
            getResult(page = 1) {
                axios.get('fetch_payroll_stipend?page=' + page)
                    .then(response => this.all_stipends = response.data)
                    .catch(error => { });
            },
        },
        mounted() {
            axios.get('registered_empcode')
                .then((response) => {
                    this.code_arr = response.data
                    this.emp_codes = [];
                    var $this = this;
                    for (var i = 0; i < $this.code_arr.length; i++) {
                        this.emp_codes.push($this.code_arr[i].Name + '_' + $this.code_arr[i].EmployeeCode);
                    }
                })
                .catch((error) => { });
            this.getResult();
            axios.get('find_emp_id')
                .then(data => this.find_emp = data.data.data)
                .catch(error => { });

            axios.get('find_session')
                .then(response => {
                    this.session_name = response.data;
                })
        },
    }
</script>
