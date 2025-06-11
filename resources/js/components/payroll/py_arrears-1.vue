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
                                    Arrears
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body" style="min-height: 55px;margin-bottom: 10px;">
                                    <ul class="nav nav-pills mb-2" style="width:80%; float:left">
                                        <li class="nav-item">
                                            <router-link to="/payroll/arrears" class="nav-link active">
                                                <i class="fa-solid fa-person"></i>
                                                <span class="fw-bold">Arrears Detail</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/bonuses" class="nav-link">
                                                <i class="fa-solid fa-candy-cane"></i>
                                                <span class="fw-bold">Bonuses Detail</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/allowance" class="nav-link">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Allowance Detail</span>
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
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <h5 style="padding-left:10px;padding-top:10px">Session Name: {{this.session_name}}</h5>
                                    </div>
                                    <div class="col-md-4 col-12 mb-2 position-relative">
                                        <input type="text" v-model="keyword1" class="form-control" placeholder="Search By Name or Employee code">
                                    </div>
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <button data-bs-toggle="modal" data-bs-target="#applyarrears" class="btn btn-primary">Apply Arrears</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Emp. Code</th>
                                                <th>Name</th>
                                                <th class="text-center">Arrears</th>
                                                <th class="text-center">Session</th>
                                                <th class="text-center">Salary</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in all_sals.data" style="vertical-align: middle;">
                                                <td class="text-center">{{all_sals1.EmployeeCode}}</td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals1.Name}} </span></a><small class="emp_post text-muted">
                                                            <span v-if="all_sals1.Department!=null">{{all_sals1.Department}} - </span>
                                                            <span v-else>No Department</span>
                                                            <span v-if="all_sals1.Designation!=null">{{all_sals1.Designation}}</span>
                                                            <span v-else> - No Designation</span>
                                                        </small>
                                                    </div>
                                                </td>

                                                <td class="text-center fw-bolder">{{Math.floor(all_sals1.ArrearsAmount).toLocaleString()}}/-</td>
                                                <td class="text-center">{{all_sals1.SessionName}}<br /><small class="emp_post text-muted">{{all_sals1.ArrearDate}}</small></td>
                                                <td class="text-center">{{Math.floor(all_sals1.Salary).toLocaleString()}}/-</td>
                                                <td class="text-center">{{all_sals1.Descriptions}}</td>
                                                <td class="text-center">
                                                    <a v-if="all_sals1.Status=='Pending'" @click="fetch_arrear_id(all_sals1.ArrearsID)" data-bs-toggle="modal" data-bs-target="#hireinterview1">
                                                        <span class="badge bg-gradient-warning" style="cursor: pointer;">Pending</span>
                                                    </a>
                                                    <a v-else-if="all_sals1.Status=='Approved'">
                                                        <span class="badge bg-gradient-success" style="cursor: pointer;">Approved</span>
                                                    </a>
                                                    <a v-else>
                                                        <span class="badge bg-gradient-info" style="cursor: pointer;">Paid</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group text-center">
                                                        <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-if="all_sals1.Status=='Pending'" @click="fetch_emp_payroll(all_sals1.ArrearsID)" data-bs-toggle="modal" data-bs-target="#editpayroll"><i class="fa-solid fa-pencil-square-o"></i>Edit details</a>
                                                            <a @click="getid(all_sals1.ArrearsID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_arrear"><i class="fa-regular fa-trash-can"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center;padding-top:20px">
                                    <pagination :data="all_sals" @pagination-change-page="getResult"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete_arrear" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Do you want to delete the arrears?</h5>
                                        <div class="text-center">
                                            <button :disabled="disabled3" type="button" @click="delay3()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
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
                                        <h5>Are you want to approve the arrears of selected employee?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" :disabled="disabled" @click="delay2()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal table -->
                    <div class="modal fade" id="applyarrears" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">

                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Apply Arrears to Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardNumber">Session Name</label>
                                            <input v-model="session_name" type="text" readonly id="modalAddCardName" class="form-control" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Apply Date</label>
                                            <input v-model="emp_date" type="date" class="form-control" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Employee Code</label>
                                            <select v-model="emp_emp_id" class="form-control">
                                                <option value="">Select Employee</option>
                                                <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>{{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Amount</label>
                                            <input v-model="emp_amount" type="number" id="modalAddCardName" class="form-control" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Description</label>
                                            <input v-model="emp_description" type="text" id="modalAddCardName" class="form-control" />
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Apply Now</button>
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
                        <h5>Update Arrears of Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Session Name</label>
                                <input v-model="edit_session_name" type="text" readonly id="modalAddCardName" class="form-control" />
                                <input hidden v-model="edit_arrear_id" type="text" readonly id="modalAddCardName" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Apply Date</label>
                                <input v-model="edit_date" type="date" class="form-control" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Employee Code</label>
                                <select v-model="edit_emp_id" class="form-control">
                                    <option value="">Select Employee</option>
                                    <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>{{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Amount</label>
                                <input v-model="edit_amount" type="number" id="modalAddCardName" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Description</label>
                                <input v-model="edit_description" type="text" id="modalAddCardName" class="form-control" />
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
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
import axios from "axios";
export default {
    data() {
        return {
            d_arrear_id:'',
            all_sals: {},
            find_emp: {},
            emp_emp_id:'',
            emp_amount:'',
            emp_description:'',
            emp_date:'',

            keyword1: '',
            session_name: '',
            arrear_id:'',

            edit_emp_id:'',
            edit_session_name:'',
            edit_amount:'',
            edit_description:'',
            edit_arrear_id:'',
            edit_date:'',

            disabled: false,
            timeout: null,
            disabled1: false,
            timeout1: null,
            disabled2: false,
            timeout2: null,
            disabled3: false,
            timeout3: null,
        }
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
        methods: {
            getid(id) {
                this.d_arrear_id = id;
            },
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.delete_arrears();
            },
            delete_arrears() {
                axios.get('delete_arrears/' + this.d_arrear_id)
                    .then(data => {
                        if (data.data == 'arrears deleted') {
                            this.$toastr.s("Arrears Deleted Successfully!", "Success");
                            this.d_arrear_id = '';
                            this.getResult();
                        }
                        else {
                            this.$toastr.e("Arrears Not Deleted!", "Error");
                        }
                    })
                    .catch(error => { });
            },

        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
              this.disabled = false
            }, 5000)
            this.applyallowance()
          },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
              this.disabled1 = false
            }, 5000)
            this.updatearrears()
          },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
              this.disabled2 = false
            }, 5000)
            this.update_allowance_payroll()
          },
    updatearrears(){
    axios.post('update_ind_arrears', {
        edit_emp_id: this.edit_emp_id,
            edit_session_name: this.edit_session_name,
            edit_amount: this.edit_amount,
            edit_description: this.edit_description,
            edit_arrear_id: this.edit_arrear_id,
            edit_date: this.edit_date,
              })
                        .then(data => {

                                this.$toastr.s("Updated Arrears Successfully!", "Congratulations");
                                this.all_sals=data.data;

                        })
    },
    fetch_arrear_id(id){
    this.arrear_id=id;
    },
    update_allowance_payroll(){
     axios.get('./approve_arrears/'+this.arrear_id)
                .then(response => {
                this.all_sals = response.data
                  this.$toastr.s("Approved Arrears Successfully!", "Congratulations");

                })
                .catch(error => console.log(error));
    },
    fetch_emp_payroll(id){
     axios.get('find_payroll_arrear/' + id)
                .then(data => {
                    this.edit_emp_id = data.data[0].EmployeeID;
                    this.edit_session_name = data.data[0].SessionName;
                    this.edit_amount = data.data[0].ArrearsAmount;
                    this.edit_description = data.data[0].Descriptions;
                    this.edit_date = data.data[0].ArrearDate;
                    this.edit_arrear_id=data.data[0].ArrearsID;
                })
                .catch(error => {});
    },
        applyallowance(){
            axios.post('submit_arrears', {
            emp_emp_id: this.emp_emp_id,
            emp_amount: this.emp_amount,
            emp_description: this.emp_description,
            emp_date: this.emp_date,
            session_name:this.session_name,
                    })
                        .then(data => {

                                this.$toastr.s("Submitted Arrears Successfully!", "Congratulations");
                                this.all_sals=data.data;
                                this.emp_amount='',
                                this.emp_description='',
                                this.emp_date='',
                                this.session_name=''
                                this.emp_emp_id=''
                        })
        },
        getResults(page=1) {
            axios.get('./search_arrears', { params: { keyword1: this.keyword1 } })
                .then(response => this.all_sals = response.data)
                .catch(error => console.log(error));
        },
        getResult(page=1) {

            axios.get('fetch_payroll_arrears?page=' + page)
                .then(response => this.all_sals = response.data)
                .catch(error => {});
        },

    },
    mounted() {
        this.getResult();
        axios.get('find_emp_id')
            .then(data => this.find_emp = data.data.data)
            .catch(error => {});

        axios.get('find_session')
            .then(response => {
                this.session_name = response.data;
            })




    },

}

</script>
