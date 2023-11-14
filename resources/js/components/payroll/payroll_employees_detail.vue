<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Employees Salary Details
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <section class="app-user-view-account">
                <div class="row">
                    <!-- User Sidebar -->
                    <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Employee Name<span style="color:red"></span></label>
                                        <multiselect style="margin-right: 10px;" :options="options_emp" value="id" label="label" v-model="emp_code" placeholder="Select Employee"></multiselect>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Department</label>
                                        <multiselect placeholder="All Departments" :show-labels="false" v-model="department" :options="options2"></multiselect>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Designation</label>
                                        <multiselect :show-labels="false" v-model="designation" :options="options"></multiselect>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Location</label>
                                        <multiselect placeholder="All Locations" :show-labels="false" v-model="location" :options="options1"></multiselect>
                                    </div>
                                    <div class="col-md-1">
                                        <button @click="getbyfilter()" style="height: 35px !important;margin-top: 25px;" class="btn btn-secondary">Search</button>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead style="">
                                            <tr>
                                                <th class="sticky-th-center">Emp. Code</th>
                                                <th class="sticky-th-left">Employee Name</th>
                                                <th class="sticky-th-center">Department<br />& Location</th>
                                                <th class="sticky-th-center">Updated Salary</th>
                                                <th class="sticky-th-center">Updated On</th>
                                                <th class="sticky-th-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="adsdata1 in adsdata.data">
                                                <td class="td-center">{{adsdata1.EmployeeCode}}</td>
                                                <td class="td-left">
                                                    <div class="d-flex justify-content-left align-items-center">
                                                        <div class="avatar-wrapper">
                                                            <div class="avatar  me-1">
                                                                <img v-bind:src="`public/images/profile_images/${adsdata1.Photo}`" alt="Avatar" height="32" width="32">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column"><a class="user_name text-truncate text-body"><span class="fw-bolder"> </span>{{adsdata1.Name}}</a><small class="emp_post text-muted">{{adsdata1.Designation}}</small></div>
                                                    </div>
                                                </td>
                                                <td class="td-center">
                                                    <div class="d-flex flex-column"><a class="user_name text-truncate text-body"><span class="fw-bolder"> </span>{{adsdata1.Department}}</a><small class="emp_post text-muted">{{adsdata1.PostingCity}}</small></div>
                                                </td>
                                                <td class="td-center">
                                                    <div class="d-flex flex-column"><span class="fw-bolder">{{Math.floor(adsdata1.UpdatedSalary).toLocaleString()}}/-</span><small class="emp_post text-muted">{{Number(adsdata1.UpdatedPerDay).toLocaleString()}} Per day  |  {{Number(adsdata1.UpdatedPerHours).toLocaleString()}} Per hour</small></div>
                                                </td>
                                                <td class="td-center">
                                                    {{adsdata1.UpdatedDate}}
                                                </td>
                                                <td class="td-center">
                                                    <a v-if="hasPermission('Payroll Indvisual employee Salary Details')" data-bs-toggle="modal" @click="fetchdata(adsdata1.EmployeeID)" data-bs-target="#viewstatus"><i class="fa-solid fa-eye"></i></a>
                                                    <a v-if="hasPermission('Payroll Update Indvisual employee Salary')" data-bs-toggle="modal" @click="fetchdata(adsdata1.EmployeeID)" data-bs-target="#updatestatus"><i class="fa-solid fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center; padding-top:20px">
                                    <pagination :limit="limit" :data="adsdata" @pagination-change-page="getbyfilter"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade" id="updatestatus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" @click="update_salary_detail1()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h4 class="mb-1">Updating {{p_name}}'s Salary</h4>
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Employee Code</label>
                                <input type="text" readonly class="form-control" v-model="p_emp_code" />
                                <input type="text" hidden readonly class="form-control" v-model="p_emp_id" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Employee name</label>
                                <input type="text" readonly class="form-control" v-model="p_name" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Designation</label>
                                <input type="text" readonly class="form-control" v-model="p_designation" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="modalEditUserLastName">Department</label>
                                <input type="text" readonly class="form-control" v-model="p_department" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="modalEditUserLastName">Posting City</label>
                                <input type="text" readonly class="form-control" v-model="p_postingcity" />
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Last Date</label>
                                <input type="text" readonly class="form-control" v-model="p_last_date" />
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Last Salary</label>
                                <input type="text" readonly class="form-control" v-model="p_last_salary" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Last Increment Amount</label>
                                <input type="text" readonly class="form-control" v-model="p_last_increment" />
                            </div>
                            <div class="col-12 col-md-8">
                                <label class="form-label" for="modalEditUserLastName">Last Remarks</label>
                                <input type="text" readonly v-model="p_last_remarks" class="form-control" placeholder="Comments" />
                            </div>
                            <hr style="margin-top:20px">
                            <div class="col-12 col-md-4">
                                <label class="form-label">New Salary</label>
                                <input type="number" @change="calculator()" class="form-control" v-model="p_current_salary" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Per Day</label>
                                <input readonly type="number" class="form-control" v-model="p_current_day" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Per Hour</label>
                                <input readonly type="number" class="form-control" v-model="p_current_hour" />
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="modalEditUserLastName">Remarks</label>
                                <input type="text" v-model="p_current_remarks" class="form-control" />
                            </div>

                            <div class="col-12 text-center mt-2 pt-50">
                                <button :disabled="disabled" @click="delay()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                <button type="reset" @click="update_salary_detail1()" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Cancle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewstatus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" @click="update_salary_detail1()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h4 class="mb-1">{{p_name}}'s Salary Details</h4>
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                            <div class="col-12 col-md-3">
                                <label class="form-label">Employee Code</label>
                                <input type="text" readonly class="form-control" v-model="p_emp_code" />
                                <input type="text" hidden readonly class="form-control" v-model="p_emp_id" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Employee name</label>
                                <input type="text" readonly class="form-control" v-model="p_name" />
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="form-label" for="modalEditUserLastName">Department</label>
                                <input type="text" readonly class="form-control" v-model="p_department" />
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="form-label">Designation</label>
                                <input type="text" readonly class="form-control" v-model="p_designation" />
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Salary</label>
                                <input type="text" readonly class="form-control" v-model="p_last_salary" />
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Updated on</label>
                                <input type="text" readonly class="form-control" v-model="p_last_date" />
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Last Increment Amount</label>
                                <input type="text" readonly class="form-control" v-model="p_last_increment" placeholder="Not available" />
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="modalEditUserLastName">Posting City</label>
                                <input type="text" readonly class="form-control" v-model="p_postingcity" />
                            </div>
                            <div class="col-12 col-md-8">
                                <label class="form-label" for="modalEditUserLastName">Remarks</label>
                                <input type="text" readonly v-model="p_last_remarks" class="form-control" placeholder="No remarks" />
                            </div>
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
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
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
        data() {
            return {
                limit:10,
                department: 'All',
                location: 'All',
                designation: 'All',
                designations: {},
                locations: {},
                departments: {},
                adsdata: {},
                find_emp: {},
                emp_code: { id: 'All', label:'All Employees' },
                options_emp: [],
                options: [],
                options1: [],
                options2: [],
                p_emp_code: '',
                p_emp_id: '',
                p_name: '',
                p_designation: '',
                p_department: '',
                p_postingcity: '',
                p_last_date: '',
                p_last_increment: '',
                p_last_salary: '',
                p_last_remarks: '',
                p_current_salary: '',
                p_current_day: '',
                p_current_hour: '',
                p_current_remarks: '',

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
                this.update_salary_detail()
            },
            calculator() {
                this.p_current_day = this.p_current_salary / 30;
                this.p_current_hour = this.p_current_day / 8;
            },
            update_salary_detail1() {
                this.p_emp_code = '';
                this.p_emp_id = '';
                this.p_name = '';
                this.p_designation = '';
                this.p_department = '';
                this.p_postingcity = '';
                this.p_last_date = '';
                this.p_last_increment = '';
                this.p_last_salary = '';
                this.p_last_remarks = '';
                this.p_current_salary = '';
                this.p_current_day = '';
                this.p_current_hour = '';
                this.p_current_remarks = '';
            },
            update_salary_detail() {
                axios.post('submit_payroll_detail', {
                    p_emp_id: this.p_emp_id,
                    p_last_salary: this.p_last_salary,
                    p_current_salary: this.p_current_salary,
                    p_current_day: this.p_current_day,
                    p_current_hour: this.p_current_hour,
                    p_current_remarks: this.p_current_remarks,
                })
                    .then(data => {
                     
                        this.$toastr.s("Employee Salary Detail Updated Successfully!", "Congratulations!");
                        this.adsdata=data.data
                        this.p_emp_id = '';
                        this.p_last_salary = '';
                        this.p_current_salary = '';
                        this.p_current_day = '';
                        this.p_current_hour = '';
                        this.p_current_remarks = '';
                    })
            },
            fetchdata(id) {
                axios.get('./fetch_emp_detail/' + id)
                    .then(data => {
                        this.p_emp_code = data.data[0].EmployeeCode;
                        this.p_name = data.data[0].Name;
                        this.p_designation = data.data[0].Designation;
                        this.p_department = data.data[0].Department;
                        this.p_postingcity = data.data[0].PostingCity;
                        this.p_last_date = data.data[0].UpdatedDate;
                        this.p_last_increment = data.data[0].LastIncrement;
                        this.p_last_salary = Number(data.data[0].UpdatedSalary);
                        this.p_last_remarks = data.data[0].Remarks;
                        this.p_emp_id = data.data[0].EmployeeID;
                    })
                    .catch(error => { });
            },

            getbyfilter(page = 1) {
                if (this.emp_code==null || this.emp_code=='') {
                    this.emp_code = { id: 'All', label:'All Employees' };
                    this.emp_code.id = 'All';
                }
                axios.get('./filter_employees/' + this.emp_code.id + '/' + this.department + '/' + this.location + '/' + this.designation + '?page=' + page)
                    .then(data => this.adsdata = data.data)
                    .catch(error => { });
            },
        },

        mounted() {
            this.getbyfilter();

            axios.get('find_emp_id')
                .then(data => this.find_emp = data.data.data)
                .catch(error => { });

            axios.get('department_detail2')
                .then(data => {
                    this.departments = data.data
                    this.options2 = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options2.push($this.departments[i].department_name);
                    }
                })
                .catch(error => { });

            axios.get('overall_designation')
                .then(response => {
                    this.designations = response.data
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.designations.length; i++) {
                        this.options.push($this.designations[i].designation_name);
                    }
                })
                .catch(error => { });

            axios.get('overall_location')
                .then(response => {
                    this.locations = response.data
                    this.options1 = [];

                    var $this = this;
                    for (var i = 0; i < $this.locations.length; i++) {
                        this.options1.push($this.locations[i].location_name);
                    }
                })
                .catch(error => { });

            axios.get('find_emp_id')
                .then(data => {
                    this.find_emp = data.data.data;
                    this.options_emp = [];
                    this.options_emp = this.find_emp.map((emp) => ({
                        id: emp.EmployeeID,
                        label: `${emp.EmployeeCode}` + ' ' + `${emp.Name}`,
                    }));
                })
                .catch(error => { });
        }
    }

</script>
