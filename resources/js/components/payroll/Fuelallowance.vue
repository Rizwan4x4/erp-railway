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
                                    Fuel Allowances
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body" style="min-height: 55px;margin-bottom: 10px;">
                                    <ul class="nav nav-pills mb-2" style="float:left">
                                        <li v-if="hasPermission('Payroll Other Allowances')"  class="nav-item">
                                            <router-link to="/payroll/allowance" class="nav-link">
                                                <i class="fa-solid fa-calendar-plus"></i>
                                                <span class="fw-bold">Monthly Allowances</span>
                                            </router-link>
                                        </li>
                                        <li v-if="hasPermission('Payroll Welfare Allowances')" class="nav-item">
                                            <router-link to="/payroll/py_welfare_allowance" class="nav-link">
                                                <i class="fa-solid fa-magnifying-glass-dollar"></i>
                                                <span class="fw-bold">Welfare Allowances</span>
                                            </router-link>
                                        </li>
                                        <li v-if="hasPermission('Payroll Fuel Allowances')" class="nav-item">
                                            <router-link to="/payroll/Fuelallowances" class="nav-link active">
                                                <i class="fa-solid fa-gas-pump"></i>
                                                <span class="fw-bold">Fuel Allowances</span>
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
                                <div class="row" style="margin-top: 20px">
                                    <!-- Petrol, Diesel, and HOBC input fields together -->
                                    <div class="col-md-6 col-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-3 col-4 position-relative">
                                                <input type="text" class="form-control" readonly
                                                       :value="'Petrol: ' + PetrolCurrentRate">
                                            </div>
                                            <div class="col-md-3 col-4 position-relative">
                                                <input type="text" class="form-control" readonly
                                                       :value="'Diesel: ' + DieselCurrentRate">
                                            </div>
                                            <div class="col-md-3 col-4 position-relative">
                                                <input type="text" class="form-control" readonly
                                                       :value="'HOBC: ' + HOBCCurrentRate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-auto col-10 mb-2">
                                        <input type="text" v-model="keyword1" class="form-control"
                                               placeholder="Emp Name or code">
                                    </div>

                                    <!-- Update Rate button and Add Employee button together -->
                                    <div class="col-md-auto col-10 mb-2">
                                        <button  v-if="hasPermission('Payroll Update Fuel Rates')"  data-bs-toggle="modal" data-bs-target="#updaterate"
                                                class="btn btn-primary" title="Update Fuel Average Rate">Update fuel
                                            Rates
                                        </button>
                                        <button  v-else 
                                                class="btn btn-primary" title="Update Fuel Average Rate">Update fuel
                                            Rates
                                        </button>
                                        <button v-if="hasPermission('Payroll Add Fuel Allowance')"  data-bs-toggle="modal" data-bs-target="#applyEmpFuelAllowance"
                                                class="btn btn-primary">Add Employee Allowance
                                        </button>
                                        <button v-else
                                                class="btn btn-primary">Add Employee Allowance
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="sticky-th-center">Sr. No</th>
                                            <th class="sticky-th-center">Emp. Code</th>
                                            <th class="sticky-th-left">Name</th>
                                            <th class="sticky-th-center">Salary</th>
                                            <th class="sticky-th-center">Fuel Type</th>
                                            <th class="sticky-th-center">Fuel Limit</th>
                                            <th class="sticky-th-center">Fuel Amount</th>
                                            <th class="sticky-th-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(all_sals1, index) in all_sals.data">
                                            <td class="td-center">{{ index + 1 + (15 * (page - 1)) }}</td>

                                            <td class="td-center">{{ all_sals1.EmployeeCode }}</td>
                                            <td class="td-left">
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span
                                                        class="fw-bolder">{{ all_sals1.Name }} </span></a><small
                                                    class="emp_post text-muted">
                                                    <span v-if="all_sals1.Department!=null">{{ all_sals1.Department }} -{{ all_sals1.Designation }} </span>
                                                    <span v-else></span>
                                                </small>
                                                </div>
                                            </td>
                                            <td class="td-center">{{ all_sals1.Salary }}</td>
                                            <td class="td-center">{{ all_sals1.FuelType }}</td>
                                            <td class="td-center">{{
                                                    Math.round(all_sals1.FuelQuantity.toLocaleString())
                                                }}<span> Literes</span></td>
                                            <td v-if="all_sals1.FuelType == 'Petrol'" class="td-center">{{
                                                    Math.round(PetrolCurrentRate * all_sals1.FuelQuantity).toLocaleString()
                                                }}
                                            </td>

                                            <td v-if="all_sals1.FuelType == 'Diesel'" class="td-center">{{
                                                    Math.round(DieselCurrentRate * all_sals1.FuelQuantity).toLocaleString()
                                                }}
                                            </td>

                                            <td v-if="all_sals1.FuelType == 'HOBC'" class="td-center">{{
                                                    Math.round(HOBCCurrentRate * all_sals1.FuelQuantity).toLocaleString()
                                                }}
                                            </td>
                                            <td class="td-center">
                                                <div  v-if="hasPermission('Payroll Fuel Allowance Action')" class="btn-group">
                                                    <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round"
                                                             class="feather feather-more-vertical font-small-4">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="12" cy="5" r="1"></circle>
                                                            <circle cx="12" cy="19" r="1"></circle>
                                                        </svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                           @click="fetch_emp_FuelAllowance(all_sals1.EmployeeID)"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#editEmpFuelAllowance">
                                                            <i class="fa-solid fa-pencil-square-o"></i>Edit details
                                                        </a>
                                                        <a class="dropdown-item" @click="getid(all_sals1.EmployeeID)"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#delete_EmpFuelAllowance">
                                                            <i class="fa-solid fa-regular fa-trash-can"></i>
                                                            Delete
                                                        </a>
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

                    <!-- modal table -->
                    <div class="modal fade" id="delete_EmpFuelAllowance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Do you want to delete the Fuel Allowance?</h5>
                                        <div class="text-center">
                                            <button :disabled="disabled3" type="button" @click="delay3()"
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
                    <div class="modal fade" id="update_FuelRate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Do you want to update the Fuel Rate?</h5>
                                        <div class="text-center">
                                            <button :disabled="disabled3" type="button"
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
                    <div class="modal fade" id="editEmpFuelAllowance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Update Fuel Allowance of Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">


                                        <div class="col-12">
                                            <label class="form-label">Employee Name & Code</label>
                                            <select v-model="edit_emp_id" class="form-control" readonly>
                                                <option value="">Select Employee</option>
                                                <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                                    {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Fuel Type</label>
                                            <select v-model="edit_emp_FuelType" class="form-control">
                                                <option value="Petrol">Petrol</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="HOBC">HOBC</option>
                                            </select>

                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Fuel Limit</label>
                                            <input v-model="edit_amount" type="number" class="form-control"/>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled1" @click="delay1()"
                                                    class="btn btn-primary me-1 mt-1">Update
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
                    <div class="modal fade" id="updaterate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">

                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Update Fuel Rate</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">

                                        <div class="col-md-10">
                                            <label class="form-label" for="modalAddCardName">Fuel Rate History</label>
                                            <div style="max-height: 300px; overflow: auto; "
                                                 class="d-flex justify-content-center">
                                                <table class="table table-responsive">
                                                    <thead>
                                                    <tr>

                                                        <th>User</th>
                                                        <th>Petrol</th>
                                                        <th>Diesel</th>
                                                        <th>HOBC</th>
                                                        <th>Date</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="FuelRate1 in FuelRate">
                                                        <td>
                                                            {{ FuelRate1.CreatedBy }}
                                                        </td>
                                                        <td>
                                                            {{ Number(FuelRate1.PetrolRate.toLocaleString()) }}
                                                        </td>
                                                        <td>
                                                            {{ Number(FuelRate1.DieselRate.toLocaleString()) }}
                                                        </td>
                                                        <td>
                                                            {{ Number(FuelRate1.HOBCRate.toLocaleString()) }}
                                                        </td>
                                                        <td>
                                                            {{ formatDate(FuelRate1.CreatedOn) }}
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h6><span style="color: #d93025">* </span> Please Enter <strong>Average
                                                Rates</strong> For {{ session_name }}</h6>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="modalAddCardName">Petrol</label>
                                                    <input v-model="Update_PetrolRate" type="number"
                                                           id="modalAddCardName" class="form-control"
                                                           placeholder="252.45"/>
                                                    <span style="color: #DB4437; font-size: 11px;"
                                                          v-if="Update_PetrolRate==''">{{ e_Update_PetrolRate }}</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="modalAddCardName">Diesel</label>
                                                    <input v-model="Update_DieselRate" type="number"
                                                           id="modalAddCardName" class="form-control"
                                                           placeholder="252.45"/>
                                                    <span style="color: #DB4437; font-size: 11px;"
                                                          v-if="Update_DieselRate==''">{{ e_Update_DieselRate }}</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="modalAddCardName">HOBC</label>
                                                    <input v-model="Update_HOBCRate" type="number" id="modalAddCardName"
                                                           class="form-control" placeholder="252.45"/>
                                                    <span style="color: #DB4437; font-size: 11px;"
                                                          v-if="Update_HOBCRate==''">{{ e_Update_HOBCRate }}</span>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled6" @click="delay4()"
                                                    class="btn btn-primary me-1 mt-1">Update
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
                    <div class="modal fade" id="applyEmpFuelAllowance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">

                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Add Employee Fuel Allowance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">


                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Employee Name &
                                                Code</label>
                                            <multiselect :show-labels="false"
                                                         style="margin-right: 10px; font-size: 12px;"
                                                         placeholder="Select Employee"
                                                         v-model="emp_emp_id" :options="options"></multiselect>

                                            <span style="color: #DB4437; font-size: 11px;"
                                                  v-if="emp_emp_id=='' || emp_emp_id==null">{{ e_emp_emp_id }}</span>
                                        </div>


                                        <div class="col-md-12">
                                            <label class="form-label">Fuel Type</label>
                                            <select v-model="emp_FuelType" class="form-control">
                                                <option value="Petrol">Petrol</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="HOBC">HOBC</option>
                                            </select>

                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Add Fuel Amount</label>
                                            <input v-model="emp_amount" type="number" id="modalAddCardName"
                                                   class="form-control"/>
                                            <span style="color: #DB4437; font-size: 11px;"
                                                  v-if="emp_amount==''">{{ e_emp_amount }}</span>
                                        </div>


                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled" @click="delay()"
                                                    class="btn btn-primary me-1 mt-1">Add Employee
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
            pageN: '',
            page: '',
            options: [],
            FuelRate: {},
            all_sals: {},
            find_emp: {},
            emp_emp_id: '',
            e_emp_session: '',
            emp_amount: '',
            emp_FuelType: 'Petrol',

            edit_emp_FuelType: '',
            session_name: '',
            edit_emp_id: '',
            edit_amount: '',
            edit_description: '',
            edit_bonus_id: '',
            emp_Fuelid: '',
            disabled: false,
            timeout: null,
            disabled1: false,
            timeout1: null,
            disabled2: false,
            timeout2: null,
            disabled6: false,
            keyword1: '',
            e_emp_emp_id: '',
            e_emp_session: '',
            e_emp_amount: '',
            disabled3: false,
            Update_emp_amount: '',
            Update_e_emp_emp_id: '',
            PetrolCurrentRate: '',
            DieselCurrentRate: '',
            HOBCCurrentRate: '',
            e_Update_PetrolRate: '',
            e_Update_DieselRate: '',
            e_Update_HOBCRate: '',
            Update_DieselRate: '',
            Update_PetrolRate: '',
            Update_HOBCRate: '',


        }
    },

    components: {Multiselect},
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toISOString().slice(0, 10); // Extracts YYYY-MM-DD part
        },
        getResults() {
            axios.get('./search_EmpFuelAllowance', {params: {keyword1: this.keyword1}})
                .then(response => this.all_sals = response.data)
                .catch(error => console.log(error));

        },
        delay4() {
            this.disabled6 = true
            this.timeout = setTimeout(() => {
                this.disabled6 = false
            }, 5000)
            this.updateFuelRate();
            this.fetchFuelRate();

        },
        fetchFuelRate() {
            axios.get('fetch_FuelRate/')
                .then(response => {
                    this.FuelRate = response.data;
                    this.PetrolCurrentRate = Number(response.data[0].PetrolRate).toLocaleString();
                    this.DieselCurrentRate = Number(response.data[0].DieselRate).toLocaleString();
                    this.HOBCCurrentRate = Number(response.data[0].HOBCRate).toLocaleString();
                })
                .catch(error => {
                });
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.applyEmpFuelAllowance()
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.updateEmpFuelAllowance()

        },
        getid(id) {
            this.emp_Fuelid = id;
        },

        updateFuelRate() {
            if (this.Update_PetrolRate == '' || this.Update_DieselRate == '' || this.Update_HOBCRate == '') {
                if (this.Update_PetrolRate == '' || this.Update_PetrolRate == null) {
                    this.e_Update_PetrolRate = 'Petrol*';
                } else {
                    this.e_Update_PetrolRate = '';
                }
                if (this.Update_DieselRate == '' || this.Update_DieselRate == null) {
                    this.e_Update_DieselRate = 'Diesel*';
                } else {
                    this.e_Update_PetrolRate = '';
                }
                if (this.Update_HOBCRate == '' || this.Update_HOBCRate == null) {
                    this.e_Update_HOBCRate = 'HOBC*';
                } else {
                    this.e_Update_HOBCRate = '';
                }
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                axios.post('update_FuelRate', {
                    edit_PetrolRate: this.Update_PetrolRate,
                    edit_DieselRate: this.Update_DieselRate,
                    edit_HOBCRate: this.Update_HOBCRate,
                })
                    .then(data => {
                        this.errorsBackEnd = [];
                        if (data.status === 200) {
                            this.$toastr.s("Fuel Rate Updated Successfully!", "Congratulations");
                            this.edit_FuelRateamount = '';
                            this.fetchFuelRate();
                        }
                    })
                    .catch(err => {
                        this.errorsBackEnd = err.response.data.errors;
                        this.$toastr.e(err.response.data.message, "errors");

                    })

            }
        },

        updateEmpFuelAllowance() {
            if (this.edit_emp_id == '' || this.edit_amount == '') {

                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                axios.post('update_EmpFuelAllowance', {
                    edit_emp_id: this.edit_emp_id,
                    edit_amount: this.edit_amount,
                    edit_emp_FuelType: this.edit_emp_FuelType
                })
                    .then(data => {
                        this.disabled = false;
                        this.errorsBackEnd = [];
                        if (data.status === 200) {
                            this.$toastr.s("Updated Emp Fuel Allowance Successfully!", "Congratulations");
                            this.all_sals = data.data;
                            this.getResult();
                        }
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.errorsBackEnd = err.response.data.errors;
                        this.$toastr.e(err.response.data.message, "errors");

                    })

            }


        },


        fetch_emp_FuelAllowance(id) {
            axios.get('find_EmpFuelAllowance/' + id)
                .then(data => {
                    this.edit_emp_id = data.data[0].EmployeeID;
                    this.edit_amount = data.data[0].FuelQuantity;
                    this.edit_emp_FuelType = data.data[0].FuelType;
                })
                .catch(error => {
                });
        },
        applyEmpFuelAllowance() {
            if (this.emp_amount == '' || this.emp_emp_id == '') {


                if (this.emp_amount == '') {
                    this.e_emp_amount = 'Enter Fuel Allowance amount';
                } else {
                    this.e_emp_amount = '';
                }
                if (this.emp_emp_id == '') {
                    this.e_emp_emp_id = 'Please Select Employee';
                } else {
                    this.e_emp_emp_id = '';
                }


                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                this.e_emp_emp_id = '';
                this.e_emp_amount = '';

                axios.post('submit_EmpFuelAllowance', {
                    emp_emp_id: this.emp_emp_id,
                    emp_amount: this.emp_amount,
                    emp_FuelType: this.emp_FuelType,
                })
                    .then(data => {
                        this.errorsBackEnd = [];
                        if (data.status === 200) {
                            this.$toastr.s("Submitted Employee Fuel Allowance Successfully!", "Congratulations");
                            this.emp_emp_id = '';
                            this.emp_amount = '';
                            this.session_name = '';
                            this.getResult();
                        }
                    })
                    .catch(err => {
                        this.errorsBackEnd = err.response.data.errors;
                        this.$toastr.e(err.response.data.message, "errors");

                    })
            }

        },


        getResult(page = 1) {

            axios.get('fetch_EmpFuelAllowance?page=' + page)
                .then(response => {
                    this.all_sals = response.data
                    this.page = page;
                })
                .catch(error => {
                });
            this.pageN = 1;
        },
        delay3() {
            this.disabled3 = true
            this.timeout3 = setTimeout(() => {
                this.disabled3 = false
            }, 5000)
            this.delete_EmpFuelAllowance();
        },
        delete_EmpFuelAllowance() {
            axios.get('delete_EmpFuelAllowance/' + this.emp_Fuelid)
                .then(data => {
                    if (data.data == 'Fuel Allowance deleted') {
                        this.$toastr.s("Fuel Allowance deleted Successfully!", "Success");
                        this.emp_Fuelid = '';
                        this.getResult();
                    } else {
                        this.$toastr.e("Fuel Allowance  Not Deleted!", "Error");
                    }
                })
                .catch(error => {
                });
        },

    },
    mounted() {
        this.fetchFuelRate();
        this.getResult();
        axios.get('find_emp_id')
            .then(data => {
                this.find_emp = data.data.data
                this.options = [];
                var $this = this;
                for (var i = 0; i < $this.find_emp.length; i++) {

                    this.options.push($this.find_emp[i].Name + '_' + $this.find_emp[i].EmployeeCode);
                }
            })
            .catch(error => {
            });
        axios.get('session_not_in_dist')
            .then(response => {
                this.session_name = response.data;
                // this.session_name='';
            })
    },
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
