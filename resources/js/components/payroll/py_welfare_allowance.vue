<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Incentives
                                </li>
                                <li class="breadcrumb-item active">
                                    Welfare Allowances
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body" style="min-height: 55px;margin-bottom: 10px;">
                                    <ul class="nav nav-pills mb-2" style="float:left">
                                        <li v-if="hasPermission('Payroll Other Allowances')" class="nav-item">
                                            <router-link to="/payroll/allowance" class="nav-link">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Other Allowances</span>
                                            </router-link>
                                        </li>
                                        <li v-if="hasPermission('Payroll Welfare Allowances')"  class="nav-item">
                                            <router-link to="/payroll/py_welfare_allowance" class="nav-link active">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Welfare Allowance</span>
                                            </router-link>
                                        </li>
                                        <li  v-if="hasPermission('Payroll Fuel Allowances')"  class="nav-item">
                                            <router-link to="/payroll/Fuelallowances" class="nav-link">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Fuel Allowance</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="basic-table">
                        <div class="col-12">
                            <div class="card">
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-5 col-12 mb-2">
                                        <h5 style="padding-left:10px;padding-top:10px">Session Name:
                                            {{ this.session_name }}</h5>
                                    </div>
                                    <div class="col-md-4 col-12 mb-2">
                                        <input type="text" v-model="keyword1" class="form-control"
                                               placeholder="Search By Emp.Name/Code">
                                    </div>
                                    <div class="col-md-3 col-12 mb-2">
                                        <button  v-if="hasPermission('Payroll Apply Welfare Allowance')" data-bs-toggle="modal" data-bs-target="#applyallowance" class="btn btn-primary">Apply Welfare Allowance</button>
                                        <button v-else class="btn btn-danger">Apply Welfare Allowance</button>

                                    </div>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="sticky-th-center">Emp. Code</th>
                                            <th class="sticky-th-center">Employee Name</th>
                                            <th class="sticky-th-center">Session &<br>Apply Date</th>
<!--                                            <th class="sticky-th-center">Salary</th>-->
                                            <th class="sticky-th-center">Allowance Type</th>
                                            <th class="sticky-th-center">Amount</th>
                                            <th class="sticky-th-center">Description</th>
                                            <th class="sticky-th-center" colspan="2">Status & Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in all_sals.data">
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
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.ApplyDate}}</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{Math.floor(all_sals1.Salary).toLocaleString()}}</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.Session}}</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.AllowanceType}}</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{Math.floor(all_sals1.AllowanceAmount).toLocaleString()}}</td>
                                                <td style="border-right:1px solid lightgrey;text-align:center; max-width:200px !important">{{all_sals1.Descriptions}}</td>
                                                <td style="border-right:1px solid lightgrey;text-align:center;">
                                                    <a v-if="hasPermission('Payroll Allowance slip action') && all_sals1.Status=='Pending' " @click="fetch_arrear_id(all_sals1.AllowanceID)" data-bs-toggle="modal" data-bs-target="#hireinterview1">
                                                        <span class="badge bg-gradient-warning" style="cursor: pointer;">Pending</span>
                                                    </a>
                                                    <a v-else-if="hasPermission('Payroll Allowance slip action') && all_sals1.Status=='Pending' ">
                                                        <span class="badge bg-gradient-warning" style="cursor: pointer;">Pending</span>
                                                    </a>
                                                    <a v-else-if="hasPermission('Payroll Allowance slip action') && all_sals1.Status=='Approved'"><span class="badge bg-gradient-success" style="cursor: pointer;">Approved</span></a>
                                                    <a v-else><span class="badge bg-gradient-info" style="cursor: pointer;">Paid</span></a>
                                                </td>
                                                <td v-if="hasPermission('Payroll Allowance slip action') ">
                                                    <div class="btn-group">
                                                        <a data-bs-toggle="dropdown" class="btn btn-sm">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                    </div>

                                            </td>
                                            <td class="td-center" v-else></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center;padding-top:20px">
                                    <pagination :limit="limit" :data="all_sals"
                                                @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="hireinterview1" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Do you want to approve the welfare allowance of selected employee?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" :disabled="disabled2" @click="delay2()"
                                                    class="btn btn-primary waves-effect waves-float waves-light"
                                                    data-bs-dismiss="modal" aria-label="Close">Yes
                                            </button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect"
                                                    data-bs-dismiss="modal" aria-label="Close">No
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteAllowance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation!</h1>
                                        <h5>Do you want to delete the allowance?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" :disabled="disabled4" @click="delayDelete()"
                                                    class="btn btn-primary waves-effect waves-float waves-light"
                                                    data-bs-dismiss="modal" aria-label="Close">Yes
                                            </button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect"
                                                    data-bs-dismiss="modal" aria-label="Close">No
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal table -->
                    <div class="modal fade" id="payloan" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <center>
                                            <div class="col-md-12">
                                                <table style="width:100%;">
                                                    <thead style="float:left; width:100%;"
                                                           v-for="emp_loan1 in emp_loan">
                                                    <h2 style="text-align:center;"> Details of Allowance</h2>
                                                    <tr>
                                                        <th style="width:18%;">Employee Code:</th>
                                                        <td style="width:25%;">{{ emp_loan1.EmployeeCode }}</td>
                                                        <th style="width:25%;">Name:</th>
                                                        <td style="width:32%;">{{ emp_loan1.Name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Department:</th>
                                                        <td>{{ emp_loan1.Department }}</td>
                                                        <th>Salary:</th>
                                                        <td>{{ Number(emp_loan1.Salary).toLocaleString() }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Allowance Amount:</th>
                                                        <td>
                                                            {{ Math.floor(emp_loan1.AllowanceAmount).toLocaleString() }}/-
                                                        </td>
                                                        <th>Session:</th>
                                                        <td> {{ emp_loan1.Session }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description:</th>
                                                        <td> {{ emp_loan1.LoanDescription }}</td>
                                                    </tr>
                                                    <tr>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Received by: </strong><span
                                                                style="color: #DB4437; font-size: 11px;">*</span>
                                                                <input type="text" class="form-control" v-model="rcvBy"
                                                                       placeholder="Paid Through"/>
                                                                <span style="color: #DB4437; font-size: 11px;"
                                                                      v-if="rcvBy==''">{{ rcvBy_error }}</span>
                                                            </div>
                                                        </td>
                                                        <td colspan="2">
                                                            <div class="col-md-10">
                                                                <strong>Paid Date: </strong>
                                                                <input type="date" class="form-control" readonly
                                                                       v-model="paid_date" placeholder="Date"/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <div class="col-12 text-center">
                                                <button v-if="rcvBy == ''" type="submit" :disabled="disabled3"
                                                        @click="delay3()" class="btn btn-primary me-1 mt-2">Pay
                                                    Allowance Amount
                                                </button>
                                                <button v-else type="submit" :disabled="disabled3" @click="delay3()"
                                                        class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal"
                                                        aria-label="Close">Pay Loan Amount
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary mt-2"
                                                        data-bs-dismiss="modal" aria-label="Close">
                                                    Cancel
                                                </button>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="applyallowance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Apply Welfare Allowance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-md-6">
                                            <div class="col-12">
                                                <label class="form-label" for="modalAddCardNumber">Session Name <span
                                                    style="color: #DB4437; font-size: 11px;">*</span></label>
                                                <input v-model="dist_session" type="text" readonly id="modalAddCardName"
                                                       class="form-control"/>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="dist_session==''">{{ e_dist_session }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="modalAddCardName">Apply Date</label>
                                            <input v-model="emp_date" type="date" readonly class="form-control"/>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Employee Name _ Code <span
                                                style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <multiselect style="margin-right: 10px;" v-model="emp_emp_id"
                                                         :options="options" :show-labels="false"></multiselect>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                  v-if="emp_emp_id==''">{{ e_emp_emp_id }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Allowance Type <span
                                                style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <select v-model="allowance_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="Welfare">Welfare</option>
                                                <option value="Funeral">Funeral</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                  v-if="allowance_type==''">{{ e_allowance_type }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Amount <span
                                                style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <input v-model="emp_amount" type="number" id="modalAddCardName"
                                                   class="form-control" placeholder="Enter amount"/>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                  v-if="emp_amount==''">{{ e_emp_amount }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Description</label>
                                            <input v-model="emp_description" type="text" id="modalAddCardName"
                                                   class="form-control" placeholder="Enter description"/>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button
                                                v-if="allowance_type=='' || emp_emp_id == '' || emp_amount == '' || dist_session == ''"
                                                type="submit" :disabled="disabled" @click="delay()"
                                                class="btn btn-danger">Apply Now
                                            </button>
                                            <button v-else type="submit" :disabled="disabled" @click="delay()"
                                                    class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal"
                                                    aria-label="Close">Apply Now
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1"
                                                    data-bs-dismiss="modal" aria-label="Close">
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
import Multiselect from 'vue-multiselect'
import axios from "axios";

export default {
    data() {
        return {
            allowance_id:'',
            limit: 10,
            emp_emp_id: '',
            e_emp_emp_id: '',
            emp_amount: '',
            e_emp_amount: '',
            emp_description: '',
            allowance_type: '',
            e_allowance_type: '',
            rcvBy: '',
            rcvBy_error: '',
            keyword1: '',
            session_name: '',
            bonus_id: '',
            dist_session: '',
            e_dist_session: '',

            emp_date: new Date().toJSON().slice(0, 10),
            paid_date: new Date().toJSON().slice(0, 10),
            options: [],
            all_sals: {},
            find_emp: {},
            dist_session_list: {},
            emp_loan: {},

            disabled: false,
            timeout: null,
            disabled2: false,
            timeout2: null,
            disabled3: false,
            timeout3: null,
            disabled4: false,
            timeout4: null,
        }
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    components: {Multiselect},
    methods: {
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.applybonus();
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
            this.update_arrear_payroll()
        },
        delay3() {
            this.disabled3 = true
            this.timeout3 = setTimeout(() => {
                this.disabled3 = false
            }, 5000)
            this.applywelfare();
        },
        delayDelete() {
            this.disabled4 = true
            this.timeout3 = setTimeout(() => {
                this.disabled4 = false
            }, 5000);
            this.delete_allowance();
        },
        get_id(id){
            this.allowance_id = id;
        },
        delete_allowance(){
            axios.get("delete_allowance/" + this.allowance_id)
                .then((response) => {
                    if(response.data=='allowance deleted'){
                        this.$toastr.s("Allowance has been deleted!", "Success!");
                        this.getResults();
                    }
                    else{
                        this.$toastr.e("Allowance not deleted!", "Caution!");
                    }
                    this.allowance_id = '';
                })
        },
        single_welfarepayroll(id) {
            this.allowance_id = id;
            axios.get("single_welfarepayroll/" + id)
                .then((response) => {
                    this.emp_loan = response.data;
                })
        },
        applywelfare() {
            if (this.rcvBy == '') {
                this.rcvBy_error = 'Enter'
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                axios.post("pay_welfareallowance", {
                        paid_through: this.rcvBy,
                        date: this.paid_date,
                        id: this.allowance_id
                    }
                )
                    .then((response) => {
                        if (response.data == 'Paid') {
                            this.$toastr.s("Allowance Paid Successfully!", "Congratulations");
                            this.getResults();
                        } else {
                            this.$toastr.e(response.data, "Caution!");
                        }
                        this.allowance_id = '';
                    })
            }
        },
        fetch_arrear_id(id) {
            this.bonus_id = id;
        },
        update_arrear_payroll() {
            axios.get('./approve_welfareallowance/' + this.bonus_id)
                .then(response => {
                    if (response.data = 'Updated') {
                        this.$toastr.s("Allowance Approved Successfully!", "Congratulations");
                        this.getResults();
                    }
                })
                .catch(error => console.log(error));
        },

        applybonus() {
            if (this.allowance_type == '' || this.emp_emp_id == '' || this.emp_amount == '' || this.dist_session == '') {
                if (this.dist_session == '') {
                    this.e_dist_session = 'Refresh page to get session';
                } else {
                    this.e_dist_session = '';
                }
                if (this.emp_emp_id == '') {
                    this.e_emp_emp_id = 'Select employee';
                } else {
                    this.e_emp_emp_id = '';
                }
                if (this.allowance_type == '') {
                    this.e_allowance_type = 'Select type';
                } else {
                    this.e_allowance_type = '';
                }
                if (this.emp_amount == '') {
                    this.e_emp_amount = 'Enter amount';
                } else {
                    this.e_emp_amount = '';
                }
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                this.e_allowance_type = '';
                this.e_emp_emp_id = '';
                this.e_dist_session = '';
                this.e_emp_amount = '';
                axios.post('submit_welfareallowance', {
                    emp_emp_id: this.emp_emp_id,
                    emp_amount: this.emp_amount,
                    emp_description: this.emp_description,
                    emp_date: this.emp_date,
                    session_name: this.dist_session,
                    allowance_type: this.allowance_type,
                })
                    .then(data => {
                        if (data.data == 'Allowance Applied!') {
                            this.$toastr.s("Submitted Welfare Allowance Successfully!", "Congratulations");
                            this.getResults();
                            this.all_sals = data.data;
                            this.emp_emp_id = '';
                            this.emp_amount = '';
                            this.emp_description = '';
                            this.allowance_type = '';
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                    })
            }
        },
        getResults(page = 1) {
            axios.get('./search_welfarepayroll?page=' + page, {params: {keyword1: this.keyword1}})
                .then(response => this.all_sals = response.data)
                .catch(error => console.log(error));
        },
    },
    mounted() {
        this.getResults();


        axios.get('find_emp_id')
            .then(data => {
                this.find_emp = data.data.data;
                this.options = [];
                var $this = this;
                for (var i = 0; i < $this.find_emp.length; i++) {
                    this.options.push($this.find_emp[i].Name + '_' + $this.find_emp[i].EmployeeCode);
                }
            })
            .catch(error => {
            });

        axios.get('find_session')
            .then(response => {
                this.session_name = response.data;
                this.dist_session = response.data
            })
    },
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
