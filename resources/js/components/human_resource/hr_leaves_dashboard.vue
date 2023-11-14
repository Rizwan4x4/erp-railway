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
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Leaves Management
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
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-7">
                                    <div class="demo-inline-spacing">
                                        <button  type="button" data-bs-toggle="modal" data-bs-target="#emp_leave_model" class="btn btn-primary waves-effect">Assign Leaves</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="demo-inline-spacing">
                                        <input autocomplete="off" type="text" @change="getbyId()" id="emp_name_code"
                                               v-model="emp_name_code" name="emp_name_code" class="form-control"
                                               placeholder="Search By Emp. Name / Code">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="card-title">Search & Filter</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 user_role">
                                        <label class="form-label" for="UserRole">Leave Type<span
                                            style="color:red">*</span></label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     id="UserRole" placeholder="All Types"
                                                     v-model="leave" :options="options"></multiselect>
                                    </div>
                                    <div class="col-md-3 user_status">
                                        <label class="form-label" for="FilterTransaction">Department</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                                     id="FilterTransaction" placeholder="All Departments"
                                                     v-model="department" :options="options3"></multiselect>
                                    </div>
                                    <div class="col-md-3 user_role">
                                        <label class="form-label" for="UserRole">Designation</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     id="UserRole" placeholder="All Designations"
                                                     v-model="designation" :options="options1"></multiselect>
                                    </div>
                                    <div class="col-md-2 user_plan">
                                        <label class="form-label" for="UserPlan">Location</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     id="UserPlan" placeholder="All Locations" v-model="location"
                                                     :options="options2"></multiselect>
                                    </div>
                                    <div class="col-md-2 user_status">
                                        <button @click="getbyfilter()"
                                                style="background:#c1c1c1;width:100%;height: 35px !important;margin-top: 25px;margin-bottom:20px;"
                                                class="btn btn-common">Search
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th rowspan="2" class="sticky-th-center">Emp Code</th>
                                            <th rowspan="2" class="sticky-th-center">Emp Name</th>
                                            <th colspan="2" scope="colgroup" class="sticky-th-center">Sick</th>
                                            <th colspan="2" scope="colgroup" class="sticky-th-center">Casual</th>
                                            <th colspan="2" scope="colgroup" class="sticky-th-center">Annual</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Tot.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Rem.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Tot.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Rem.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Tot.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Rem.
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="adsdata1 in adsdata.data">
                                            <td class="td-center">{{ adsdata1.employeecode }}</td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar  me-1">
                                                            <img
                                                                v-bind:src="`public/images/profile_images/${adsdata1.Photo}`"
                                                                alt="Avatar" height="32" width="32">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"><a
                                                        class="user_name text-truncate text-body"><span
                                                        class="fw-bolder"> </span>{{ adsdata1.Name }}</a><small
                                                        class="emp_post text-muted">{{
                                                            adsdata1.department
                                                        }}-{{ adsdata1.Designation }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">{{ adsdata1.sicktotal }}</td>
                                            <td class="td-center">{{ adsdata1.sickremaining }}</td>
                                            <td class="td-center">{{ adsdata1.casualtotal }}</td>
                                            <td class="td-center">{{ adsdata1.casualremaining }}</td>
                                            <td class="td-center">{{ adsdata1.Annualtotal }}</td>
                                            <td class="td-center">{{ adsdata1.Annualremaining }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="sticky-th-center">Emp Code</th>
                                            <th rowspan="2" class="sticky-th-center">Emp Name</th>
                                            <th colspan="2" scope="colgroup" class="sticky-th-center">Sick</th>
                                            <th colspan="2" scope="colgroup" class="sticky-th-center">Casual</th>
                                            <th colspan="2" scope="colgroup" class="sticky-th-center">Annual</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Tot.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Rem.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Tot.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Rem.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Tot.
                                            </th>
                                            <th scope="col" class="sticky-th-center" style="top:132px !important">Rem.
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="adsdata1 in adsdata">
                                            <td class="td-center">{{ adsdata1.employeecode }}</td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar  me-1">
                                                            <img v-bind:src="`public/images/profile_images/${adsdata1.Photo}`" alt="Avatar" height="32" width="32">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column"><a
                                                        class="user_name text-truncate text-body"><span
                                                        class="fw-bolder"> </span>{{ adsdata1.Name }}</a><small
                                                        class="emp_post text-muted">{{ adsdata1.department }}-{{ adsdata1.Designation }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">{{ adsdata1.sicktotal }}</td>
                                            <td class="td-center">{{ adsdata1.sickremaining }}</td>
                                            <td class="td-center">{{ adsdata1.casualtotal }}</td>
                                            <td class="td-center">{{ adsdata1.casualremaining }}</td>
                                            <td class="td-center">{{ adsdata1.Annualtotal }}</td>
                                            <td class="td-center">{{ adsdata1.Annualremaining }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div> -->
                                <div style="text-align:center; padding-top:20px;">
                                    <pagination v-if="byfilter == 1" :limit="limit" :data="adsdata"
                                                @pagination-change-page="getbyfilter"></pagination>
                                    <pagination v-else-if="byname == 1" :limit="limit" :data="adsdata"
                                                @pagination-change-page="getbyId"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Add emp leave model-->
        <div class="modal fade" id="emp_leave_model" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Assign leaves to Employee</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label">Employee Id</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>
                                <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                             placeholder="Select Employee" value="id" label="label" v-model="lv_emp_id"
                                             :options="options4"></multiselect>

                                <span style="color: #DB4437; font-size: 11px;"
                                      v-if="lv_emp_id.id==''">{{ e_lv_emp_id }}</span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Leave Type</label>
                                <span style="color: #DB4437; font-size: 11px;">*</span>

                                <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                             placeholder="Select Leave Type"
                                             v-model="lv_type" :options="options5">
                                </multiselect>
                                <span style="color: #DB4437; font-size: 11px;" v-if="lv_type==''">{{ e_lv_type }}</span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Number of leaves</label>
                                <input v-model="lv_nmbr" type="number" placeholder="Number of leaves"
                                       class="form-control"/>
                                <span style="color: #DB4437; font-size: 11px;" v-if="lv_nmbr==''">{{ e_lv_nmbr }}</span>
                            </div>
                            <div class="col-12 text-center">
                                <button  data-bs-dismiss="modal"  aria-label="Close" type="submit" :disabled="disabled1" @click="delay1()"
                                        class="btn btn-primary me-1 mt-1">Submit
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Add emp leave model-->
    </div>

</template>
<script>
import Multiselect from 'vue-multiselect';

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            byname: 0,
            byfilter: 1,

            limit: 10,
            lv_type: '',
            lv_emp_id: '',
            lv_nmbr: '',
            e_lv_type: '',
            e_lv_emp_id: '',
            e_lv_nmbr: '',
            options: [],
            options1: [],
            options2: [],
            options3: [],
            options4: [],
            options5: [],
            department: 'All',
            location: 'All',
            designation: 'All',
            designations: {},
            locations: {},
            departments: {},
            adsdata: {},
            leaves: {},
            leavesblnc: {},
            leave: 'All',
            days: 'One Day',
            emp_leave: '',
            emp_date_from: '',
            emp_date_to: '',
            emp_reason: '',
            emp_emp_id: '',
            emp_name_code: '',
            find_emp: {},
            l_types: {},
            get_leavedata1: {},

            emp_emp_id_error: '',

            disabled: false,
            timeout: null,

            disabled1: false,
            timeout1: null,
        }
    },

    watch: {
        emp_name_code(after, before) {
            this.getbyId();
        }
    },
    methods: {

        async fetchDepartment() {
            try {
                this.departments = await this.$helpers.checkLocal('department_detail');
                var $this = this;
                for (var i = 0; i < $this.departments.length; i++) {
                    this.options3.push($this.departments[i].Department);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        async fetchDesignation() {
            try {
                this.designations = await this.$helpers.checkLocal('overall_designation');
                this.options1 = [];
                var $this = this;
                for (var i = 0; i < $this.designations.length; i++) {
                    this.options1.push($this.designations[i].designation_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        async fetchLocations() {
            try {
                const data = await this.$apihelpers.overall_location()
                this.locations = data
                this.options2 = [];

                var $this = this;
                for (var i = 0; i < $this.locations.length; i++) {
                    this.options2.push($this.locations[i].location_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.submit_emp_leave()
        },

        submit_emp_leave() {
    if (this.lv_emp_id.id == '' || this.lv_type == '' || this.lv_nmbr == '') {
                     if (this.lv_emp_id.id == '') {
                        this.e_lv_emp_id = "Select employee";
                    }
                    else {
                        this.e_lv_emp_id = "";
                    }
                    if (this.lv_type == '') {
                        this.e_lv_type = "Select leave type";
                    }
                    else {
                        this.e_lv_type = "";
                    }
                    if (this.lv_nmbr == '') {
                        this.e_lv_nmbr = "Enter number of leave";
                    }
                    else {
                        this.e_lv_nmbr = "";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
    } else {
        const requestData = {
            lv_emp_id: this.lv_emp_id.id,
            lv_type: this.lv_type,
            lv_nmbr: this.lv_nmbr,
        };

        axios.post('submit_emp_leaves', requestData)
            .then(data => {
                if (data.data === 'Employee leave added' || data.data === 'Employee leave updated') {
                    this.$toastr.s('leave assigned to the employee');
                

                    // Assuming you have a newLeaveObject with the updated leave details
                    let newLeaveObject = {
                        EmployeeID: this.lv_emp_id.id,
                        leaveType: this.lv_type.toLowerCase(), // Adjust as needed
                        lv_nmbr:this.lv_nmbr
                    };
console.log(newLeaveObject);
                    // Find the index of the employee in adsdata array
  // Assuming 'employeeIndex' is the correct variable
const employeeIndex = this.adsdata.data.findIndex(employee => employee.EmployeeID === newLeaveObject.EmployeeID);

if (employeeIndex !== -1) {
    // Get the current remaining and total values
    const leaveTypeLower = newLeaveObject.leaveType.toLowerCase();
    const currentRemaining = parseFloat(this.adsdata.data[employeeIndex][`${leaveTypeLower}remaining`]);
    const currentTotal = parseFloat(this.adsdata.data[employeeIndex][`${leaveTypeLower}total`]);

    console.log("Current Remaining:", currentRemaining);
    console.log("Current Total:", currentTotal);

    // Check if the current values are numbers
    const isNumeric = (value) => !isNaN(parseInt(value)) && isFinite(value);

    if (isNumeric(currentRemaining) && isNumeric(currentTotal)) {
        // Convert lv_nmbr to a number
        const lvNumber = parseInt(newLeaveObject.lv_nmbr);
        console.log("lv_nmbr:", newLeaveObject.lv_nmbr, "lvNumber:", lvNumber);

        // Add the lv_nmbr to the current values
        const newRemaining = currentRemaining + lvNumber;
        const newTotal = currentTotal + lvNumber;

        console.log("New Remaining:", newRemaining);
        console.log("New Total:", newTotal);

        // Update the leave numbers for the specified leave type
        this.adsdata.data[employeeIndex][`${leaveTypeLower}remaining`] = newRemaining;
        this.adsdata.data[employeeIndex][`${leaveTypeLower}total`] = newTotal;

        // Now, 'employee' contains the updated data of the employee
        const employee = this.adsdata.data[employeeIndex];
        console.log("Updated Employee:", employee);

        // Clear the form fields
        this.lv_emp_id = "";
        this.lv_type = "";
        this.lv_nmbr = "";
        const modal = new bootstrap.Modal(document.getElementById('emp_leave_model'));
        modal.hide();

    } else {
        console.error("Current remaining and total values are not valid numeric values");
    }
} else {
    console.log("Employee not found in adsdata.data");
}

                    
                    // Clear the form fields
                    // this.lv_emp_id = "";
                    // this.lv_type = "";
                    // this.lv_nmbr = "";
                    // this.$toastr.s("Employee leave added/updated!", "Success");
                }
            })
            .catch(error => {
                this.$toastr.e('Error submitting employee leave');
            });
    }
},

        // submit_emp_leave() {
        //         if (this.lv_emp_id.id == '' || this.lv_type == '' || this.lv_nmbr == '') {
        //             if (this.lv_emp_id.id == '') {
        //                 this.e_lv_emp_id = "Select employee";
        //             }
        //             else {
        //                 this.e_lv_emp_id = "";
        //             }
        //             if (this.lv_type == '') {
        //                 this.e_lv_type = "Select leave type";
        //             }
        //             else {
        //                 this.e_lv_type = "";
        //             }
        //             if (this.lv_nmbr == '') {
        //                 this.e_lv_nmbr = "Enter number of leave";
        //             }
        //             else {
        //                 this.e_lv_nmbr = "";
        //             }
        //             this.$toastr.e("Please fill required fields!", "Caution!");
        //         }
        //         else {
        //             axios.post('submit_emp_leaves', {
        //                 lv_emp_id: this.lv_emp_id.id,
        //                 lv_type: this.lv_type,
        //                 lv_nmbr: this.lv_nmbr,
        //             })
        //                 .then(data => {
        //                     if (data.data == 'Employee leave added') {
        //                         this.$toastr.s("Employee leave added!", "Success");
        //                         this.lv_emp_id = "";
        //                         this.lv_type = "";
        //                         this.lv_nmbr = "";

        //                         this.getbyfilter();
        //                     }
        //                     else if (data.data == 'Employee leave updated') {
        //                         this.$toastr.s("Employee leaves updates!", "Success");
        //                         this.lv_emp_id = "";
        //                         this.lv_type = "";
        //                         this.lv_nmbr = "";

        //                         this.getbyfilter();
        //                     }
        //                 })
        //         }
        //     },
        getbyId(page = 1) {
            this.leave = 'All';
            this.department = 'All';
            this.location = 'All';
            this.designation = 'All';

            axios.get('./filter_leaves_byId?page=' + page, {params: {emp_name_code: this.emp_name_code}})
                .then(data => {
                    this.byfilter = 0;
                    this.byname = 1;
                    this.adsdata = data.data;
                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting leaves by id of employee');
                });
        },
        // submit_emp_leave() {
        //         if (this.lv_emp_id.id == '' || this.lv_type == '' || this.lv_nmbr == '') {
        //             if (this.lv_emp_id.id == '') {
        //                 this.e_lv_emp_id = "Select employee";
        //             }
        //             else {
        //                 this.e_lv_emp_id = "";
        //             }
        //             if (this.lv_type == '') {
        //                 this.e_lv_type = "Select leave type";
        //             }
        //             else {
        //                 this.e_lv_type = "";
        //             }
        //             if (this.lv_nmbr == '') {
        //                 this.e_lv_nmbr = "Enter number of leave";
        //             }
        //             else {
        //                 this.e_lv_nmbr = "";
        //             }
        //             this.$toastr.e("Please fill required fields!", "Caution!");
        //         }
        //         else {
        //             axios.post('submit_emp_leaves', {
        //                 lv_emp_id: this.lv_emp_id.id,
        //                 lv_type: this.lv_type,
        //                 lv_nmbr: this.lv_nmbr,
        //             })
        //                 .then(data => {
        //                     if (data.data == 'Employee leave added') {
        //                         this.$toastr.s("Employee leave added!", "Success");
        //                         this.lv_emp_id = "";
        //                         this.lv_type = "";
        //                         this.lv_nmbr = "";
        //                         this.getbyfilter();
        //                     }
        //                     else if (data.data == 'Employee leave updated') {
        //                         this.$toastr.s("Employee leaves updates!", "Success");
        //                         this.lv_emp_id = "";
        //                         this.lv_type = "";
        //                         this.lv_nmbr = "";
        //                         this.getbyfilter();
        //                     }
        //                 })
        //         }
        //     },
        getbyfilter(page = 1) {
            this.emp_name_code = '';
            if ( this.location == null) {
                this.location = 'All';
            }
            else {
                this.location = this.location;
            }
            if (this.designation ==null) {
                this.designation = 'All';
            }
            else {
                this.designation = this.designation;
            }
            if ( this.department == null) {
                this.department = 'All';
            }
            else {
                this.department = this.department;
            }
            if (this.leave == null) {
                this.leave = 'All';
            }
            else {
                this.leave = this.leave;
            }
            axios.get('./filter_leaves/' + this.leave + '/' + this.department + '/' + this.location + '/' + this.designation + '?page=' + page)
                .then(data => {
                    this.byfilter = 1;
                    this.byname = 0;
                    this.adsdata = data.data.data;
                    console.log(this.adsdata);
                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting filter leaves');
                });
        },
        overallleaves(){
            axios.get('overall_leaves')
            .then(response => {
                this.leaves = response.data.data
                this.options = [];

                var $this = this;
                for (var i = 0; i < $this.leaves.length; i++) {
                    this.options.push($this.leaves[i].LeaveType);
                }
            })
            .catch(error => {
                this.$toastr.e('error Occur while getting  overall leaves');
            });

        },
        registeredemployee(){
            axios.get('registered_empcode')
            .then(data => {
                this.find_emp = data.data;
                this.options4 = [];
                this.options4 = this.find_emp.map((obj) => ({
                    id: obj.EmployeeID,
                    label: `${obj.EmployeeCode}` + ' _ ' + `${obj.Name}`,
                }));
            })
            .catch(error => {
            });
        }
    },

    mounted() {
        this.getbyfilter();
        this.fetchDepartment();
        // this.fetchRoles();
        this.fetchDesignation();
        this.fetchLocations();

        this.overallleaves();
     this.registeredemployee();
        axios.get('view_leave_type/')
            .then(response => {
                this.l_types = response.data.data
                this.options5 = [];

                var $this = this;
                for (var i = 0; i < $this.l_types.length; i++) {
                    this.options5.push($this.l_types[i].LeaveType);
                }
            })
            .catch(error => {
            });

       

   


      
    }

}

</script>
