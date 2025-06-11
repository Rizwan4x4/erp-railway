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
                                    Fuel Allowances
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
                                        <input type="text" class="form-control" placeholder="Search By Name or Employee code">
                                    </div>
                                    <div v-if="hasPermission('Fuel assign fuel allowance')" class="col-md-3 col-12 mb-2 position-relative">
                                        <button data-bs-toggle="modal" data-bs-target="#applyallowance" class="btn btn-primary">Assign Fuel Allowance</button>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Emp. Code</th>
                                                <th>Name<br />Dept. & Designation</th>
                                                <th>Applied Date</th>
                                                <th>Fuel allowed</th>

                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in fuel_allowances.data">
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
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.CreatedOn.slice(0, 10)}}</td>
                                                <td style="text-align:center;border-right:1px solid lightgrey">{{all_sals1.FuelQuantity}} {{all_sals1.FuelUnit}}<label v-if="all_sals1.FuelQuantity > 1">s</label></td>

                                                <td style="border-right:1px solid lightgrey;text-align:center;">
                                                    <a v-if="all_sals1.Status=='Pending'" @click="fetch_arrear_id(all_sals1.AllowanceID)" data-bs-toggle="modal" data-bs-target="#hireinterview1">
                                                        <span class="badge bg-gradient-warning" style="cursor: pointer;">Pending</span>
                                                    </a>
                                                    <a v-else-if="all_sals1.Status=='Approved'">
                                                        <span class="badge bg-gradient-success" style="cursor: pointer;">Approved</span>
                                                    </a>
                                                    <a v-else>
                                                        <span class="badge bg-gradient-info" style="cursor: pointer;">Paid</span>
                                                    </a>
                                                </td>
                                                <td v-if="hasPermission('Fuel setting update actions')" @click="fetch_fuel_limit(all_sals1.AllowanceID)" data-bs-toggle="modal" data-bs-target="#updateloan">
                                                    <a><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center;padding-top:20px">
                                    <pagination :data="fuel_allowances" @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="hireinterview1" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            np
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Are you want to approve the Fuel allowance of selected employee?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" :disabled="disabled1" @click="delay1()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updateloan" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h3 class="mb-1">Update Fuel Limit</h3>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Employee name</label>
                                            <input type="text" disabled class="form-control" :value="fuel_limit && fuel_limit.length > 0 ? fuel_limit[0].EmployeeCode + '  ' + fuel_limit[0].Name : ''" />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Status</label>
                                            <input type="text" disabled class="form-control" :value="fuel_limit && fuel_limit.length > 0 ? fuel_limit[0].Status:''" />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Department</label>
                                            <input type="text" disabled class="form-control" :value="fuel_limit && fuel_limit.length > 0 ? fuel_limit[0].Department:''" />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Designation</label>
                                            <input type="text" disabled class="form-control" :value="fuel_limit && fuel_limit.length > 0 ? fuel_limit[0].Designation:''" />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Fuel Type</label>
                                            <input type="text" disabled class="form-control" :value="fuel_limit && fuel_limit.length > 0 ? fuel_limit[0].FuelType:''" />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Allowed Quantity <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <input type="number" placeholder="Btw 0 and 1000" class="form-control" v-model="emp_limit" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="emp_limit < 0 || emp_limit == '' || emp_limit > 1000">{{e_emp_limit}}</span>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">Fuel Unit</label>
                                            <input type="text" disabled class="form-control" :value="fuel_limit && fuel_limit.length > 0 ? fuel_limit[0].FuelUnit:''" />
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="button" v-if="emp_limit >= 0 && emp_limit != '' && emp_limit <= 1000" @click="delay2()" :disabled="disabled1" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button v-else type="button" @click="delay2()" :disabled="disabled1" class="btn btn-danger waves-effect waves-float waves-light">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="applyallowance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">

                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Apply Fuel Allowance to Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Employee Code</label>
                                            <multiselect style="margin-right: 10px;" v-model="emp_emp_id" :multiple="true" :options="options" :show-labels="false"> </multiselect>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Fuel in littres</label>
                                            <input v-model="fuel_quantity" type="number" id="modalAddCardName" class="form-control" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Description</label>
                                            <textarea v-model="emp_description" type="text" id="modalAddCardName" class="form-control"></textarea>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Apply</button>
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
    import Multiselect from 'vue-multiselect'
    import axios from "axios";
    export default {
        data() {
            return {
                e_emp_limit:'',
                emp_limit:'',
                fuel_limit: {},
                options: [],
                fuel_allowances: {},
                find_emp: {},
                emp_emp_id: null,
                fuel_quantity: '',
                emp_description: '',

                keyword1: '',
                session_name: '',
                allowance_id: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,
                fuelAmount:{}
            }
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        components: { Multiselect },
        methods: {
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
                this.approve_allowance();
            },
            delay2() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_limit();
            },
            approve_allowance() {
                axios.get('./approve_fuel_allowance/' + this.allowance_id)
                    .then(response => {
                        this.$toastr.s("Approved Fuel allowance Successfully!", "Congratulations");
                        this.fuel_allowances = response.data;
                        this.allowance_id = '';

                    })
                    .catch(error => console.log(error));
            },
            fetch_arrear_id(id) {
                this.allowance_id = id;
            },
            fetch_fuel_limit(id) {
                axios.get('fetch_fuel_limit/' + id)
                    .then(response => {
                        this.fuel_limit = response.data;
                        this.emp_limit = response.data[0].FuelQuantity;
                        this.allowance_id = id;
                    })
                    .catch(error => { });
            },
            applyallowance() {
                axios.post('submit_fuel_allowance', {
                    emp_emp_id: this.emp_emp_id,
                    fuel_quantity: this.fuel_quantity,
                    emp_description: this.emp_description,
                })
                    .then(data => {

                        this.$toastr.s("Submitted Fuel allowance Successfully!", "Congratulations");
                        this.fuel_allowances = data.data;
                        this.emp_emp_id = '';
                        this.fuel_quantity = '';
                        this.emp_description = '';
                    })
            },
            update_limit() {
                if (this.emp_limit < 0 || this.emp_limit == '' || this.emp_limit > 1000) {
                    this.e_emp_limit = 'Enter valid quantity!';
                    this.$toastr.e("Please enter valid fuel limit!", "Caution!");
                }
                else {
                    axios.post('./update_fuel_limit', {
                        allowance_id: this.allowance_id,
                        emp_limit: this.emp_limit,
                    })
                    .then(response => {
                        if (response.data == 'updated') {


                            const updatedIndex = this.fuel_allowances.data.findIndex(item => item.AllowanceID === this.allowance_id);
            if (updatedIndex !== -1) {

                this.fuel_allowances.data[updatedIndex].FuelQuantity = this.emp_limit;  // Adjust the properties accordingly

                this.allowance_id = '';
                this.$toastr.s("Fuel Allowance Limit Updated Successfully!", "Congratulations");
                // Update other properties as needed
            }
                        }
                        else {
                            this.$toastr.e("Fuel allowance not updated!", "Caution!");
                        }
                    })
                    .catch(error => console.log(error));
                }
            },
            getResults(page = 1) {
                axios.get('fetch_fuel_allowance/')
                    .then(response => this.fuel_allowances = response.data)
                    .catch(error => { });
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
                .catch(error => { });
            axios.get('session_pre_dis')
                .then(response => {
                    this.session_name = response.data;
                })
        },

    }

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
