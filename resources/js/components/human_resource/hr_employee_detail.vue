<!-- All employee details where we can add new employee -->
<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link style="text-decoration: none;" to="/hr/dashboard">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Employees Detail
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="app-user-list">
                    <div class="row">
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ count_users.all_users }}</h3>
                                        <span>Total Emp.</span>
                                    </div>
                                    <div class="avatar bg-light-success p-50">
                                        <span class="avatar-content">
                                            <i class="fa-solid fa-users"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ count_users.active_users }}</h3>
                                        <span>Registered</span>
                                    </div>
                                    <div class="avatar bg-light-primary p-50">
                                        <span class="avatar-content">
                                            <i class="fa-solid fa-user-shield"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ count_users.contractual_users }}</h3>
                                        <span>Contractual</span>
                                    </div>
                                    <div class="avatar bg-light-primary p-50">
                                        <span class="avatar-content">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ count_users.suspended_users }}</h3>
                                        <span>Suspended</span>
                                    </div>
                                    <div class="avatar bg-light-warning p-50">
                                        <span class="avatar-content">
                                            <i class="fa-solid fa-user-large-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ count_users.terminated_users }}</h3>
                                        <span>Terminated</span>
                                    </div>
                                    <div class="avatar bg-light-danger p-50">
                                        <span class="avatar-content">
                                            <i class="fa-solid fa-user-large-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{ count_users.inactive_users }}</h3>
                                        <span>Resigned</span>
                                    </div>
                                    <div class="avatar bg-light-secondary p-50">
                                        <span class="avatar-content">
                                            <i class="fa-solid fa-user-large-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body border-bottom">
                            <div class="row">
                                <div class="col-md-2 user_status">
                                    <label class="form-label">Department</label>
                                    <multiselect id="FilterTransaction" v-model="department" :options="options2"
                                        :show-labels="false" placeholder="All Departments"
                                        style="margin-right: 10px; font-size: 12px;">
                                    </multiselect>
                                </div>
                                <div class="col-md-3 user_role">
                                    <label class="form-label">Designation</label>
                                    <multiselect id="UserRole" v-model="designation" :options="options"
                                        :show-labels="false" placeholder="All Designations"
                                        style="margin-right: 10px; font-size: 15px;">
                                    </multiselect>
                                </div>
                                <div class="col-md-2 user_plan">
                                    <label class="form-label">Location</label>
                                    <multiselect id="UserPlan" v-model="location" :options="options1"
                                        :show-labels="false" placeholder="All Locations"
                                        style="margin-right: 10px; font-size: 15px;">
                                    </multiselect>
                                </div>
                                <div class="col-md-2 user_status">
                                    <label class="form-label">Status</label>
                                    <multiselect id="accountPhoneNumber" v-model="emp_status" :options="options3"
                                        :show-labels="false" placeholder="Employee Status"
                                        style="margin-right: 10px; font-size: 15px;">
                                    </multiselect>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary"
                                        style="height: 40px !important; margin-top: 26px; width:100%"
                                        @click="getbyfilter()">Search
                                    </button>

                                </div>
                                <div class="col-md-1">
                                    <a v-b-toggle.my-collapse title="Click to see extra search filters">
                                        <i aria-hidden="true" class="fa-solid fa-up-right-and-down-left-from-center"
                                            style="margin-top:30px"></i>
                                    </a>
                                </div>
                            </div>
                            <b-collapse id="my-collapse">
                                <div class="advanced" style="min-height: 80px;">
                                    <div class="container">
                                        <div class="row" style=" display: block; padding-top:10px;padding-bottom:10px">
                                            <div class="col-md-2" style="float:left">
                                                <label class="form-label">Job Status</label>
                                                <multiselect id="accountPhoneNumber" v-model="status"
                                                    :options="options4" :show-labels="false"
                                                    placeholder="All Job Status"
                                                    style="margin-right: 10px; font-size: 15px;">
                                                </multiselect>
                                            </div>
                                            <div class="col-md-2" style="float:left">
                                                <label class="form-label">Minimum salary</label>
                                                <b-form-input id="inline-form-input-name" v-model="min_price"
                                                    class="mb-2 mr-sm-2 mb-sm-0" min="0" placeholder="Min Salary"
                                                    style="height: 40px !important;border-radius: 5px !important;"
                                                    type="number"></b-form-input>
                                            </div>
                                            <div class="col-md-2" style="float:left">
                                                <label class="form-label">Maximum salary</label>
                                                <b-form-input id="inline-form-input-name" v-model="max_price"
                                                    class="mb-2 mr-sm-2 mb-sm-0" min="0" placeholder="Max Salary"
                                                    style="height: 40px !important;border-radius: 5px !important;"
                                                    type="number"></b-form-input>
                                                <label v-if="min_price != '' && max_price != '' && max_price <= min_price"
                                                    style="color: #d93025; font-size:11px; text-align:justify;">Maximum
                                                    salary must be greater then minimum salary!</label>
                                            </div>
                                            <div class="col-md-2" style="float:left">
                                                <label class="form-label">CNIC</label>
                                                <masked-input id="inline-form-input-name" v-model="cnic"
                                                    class="form-control account-number-mask" mask="11111-1111111-1"
                                                    placeholder="CNIC"
                                                    style="height: 40px !important;border-radius: 5px !important;" />
                                            </div>
                                            <div class="col-md-2" style="float:left">
                                                <label class="form-label">Gender</label>
                                                <multiselect id="accountPhoneNumber" v-model="gender"
                                                    :options="options5" :show-labels="false" placeholder="All Ganders"
                                                    style="margin-right: 10px; font-size: 15px;">
                                                </multiselect>
                                            </div>
                                            <div class="col-md-2" style="float:left">
                                                <label class="form-label">Employee Code</label>
                                                <b-form-input id="inline-form-input-name" v-model="emp_id"
                                                    class="mb-2 mr-sm-2 mb-sm-0" placeholder="Employee Code"
                                                    style="height: 40px !important;border-radius: 5px !important;"
                                                    type="number"></b-form-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </b-collapse>
                        </div>
                        <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"
                            style="margin-bottom:3px;">
                            <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                <div
                                    class="dt-action-buttons justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <router-link class="dt-button add-new btn btn-primary" tabindex="0"
                                                to="/hr/create_employee" type="button"><span>+ Add New
                                                    Employee</span></router-link>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-5">
                                            <input id="keyword2" v-model="keyword2" class="form-control" name="keyword2"
                                                placeholder="Search By Employee Name / Code / CNIC / Mobile number"
                                                type="text" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="sticky-th-center">Sr. #</th>
                                        <th class="sticky-th-center">Emp.Code</th>
                                        <th class="sticky-th-center">Employee Name<br />Departmrnt & Designation</th>
                                        <th class="sticky-th-center">Build Profile</th>
                                        <th class="sticky-th-center">Joining Date<br />& Salary</th>
                                        <th class="sticky-th-center">Status</th>
                                        <th class="sticky-th-center" style="max-width: 50px;">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(adsdata1, index) in adsdata.data" class="odd">
                                        <td class="td-center">{{ index + 1 + (15 * (page - 1)) }}</td>
                                        <td class="td-center">{{ adsdata1.EmployeeCode }}</td>
                                        <td class="td-left">
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar  me-1">
                                                        <img v-if="adsdata1.Photo == '' || adsdata1.Photo == null"
                                                            alt="Avatar" height="32"
                                                            src="public/images/profile_images/pro.png" width="32">
                                                        <img v-else alt="Avatar" height="32"
                                                            v-bind:src="`public/images/profile_images/${adsdata1.Photo}`"
                                                            width="32">
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span
                                                            class="fw-bolder">{{ adsdata1.Name }} </span></a>
                                                    <small class="emp_post text-muted">
                                                        {{ adsdata1.Department }} - {{ adsdata1.Designation }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle !important;">
                                            <router-link
                                                :to="{ name: 'update_employee_profile', params: { id: adsdata1.EmployeeID } }">
                                                <span v-if="adsdata1.Name == null || adsdata1.Name == ''"
                                                    class="badge  rounded-pill badge-light-danger">Personal</span>
                                                <span v-else
                                                    class="badge  rounded-pill badge-light-primary">Personal</span>
                                            </router-link>

                                            <router-link
                                                v-if="hasPermission('HRMS employees_detail update employee_employeement')"
                                                :to="{ name: 'create_employee_employeement', params: { id: adsdata1.EmployeeID } }">
                                                <span v-if="adsdata1.Status == null || adsdata1.Status == ''"
                                                    class="badge rounded-pill badge-light-danger">Employement</span>
                                                <span v-else
                                                    class="badge rounded-pill badge-light-primary">Employement</span>
                                            </router-link>

                                            <router-link
                                                v-if="hasPermission('HRMS employees_detail update employee_education') && adsdata1.EduStatus !== 'Added' && adsdata1.EduStatus !== 'skip'"
                                                :to="{ name: 'create_employee_education', params: { id: adsdata1.EmployeeID } }">
                                                <span v-if="adsdata1.EduStatus == null || adsdata1.EduStatus == ''"
                                                    class="badge  rounded-pill badge-light-danger">Education</span>
                                                <span v-else
                                                    class="badge  rounded-pill badge-light-primary">Education</span>
                                            </router-link>
                                            <router-link
                                                v-else-if="hasPermission('HRMS employees_detail update employee_education') && adsdata1.EduStatus == 'Added' || adsdata1.EduStatus == 'skip'"
                                                :to="{ name: 'update_education_profile', params: { id: adsdata1.EmployeeID } }">

                                                <span class="badge  rounded-pill badge-light-primary">Education</span>
                                            </router-link>
                                            <router-link
                                                v-if="hasPermission('HRMS employees_detail update employee_experience') && adsdata1.ExpStatus !== 'skip' && adsdata1.ExpStatus !== 'Added'"
                                                :to="{ name: 'create_employee_experience', params: { id: adsdata1.EmployeeID } }">
                                                <span v-if="adsdata1.ExpStatus == null || adsdata1.ExpStatus == ''"
                                                    class="badge  rounded-pill badge-light-danger">Experience</span>
                                                <span v-else
                                                    class="badge  rounded-pill badge-light-primary">Experience</span>
                                            </router-link>
                                            <router-link
                                                v-else-if="hasPermission('HRMS employees_detail update employee_experience') && adsdata1.ExpStatus == 'skip' || adsdata1.ExpStatus == 'Added'"
                                                :to="{ name: 'update_experience_profile', params: { id: adsdata1.EmployeeID } }">

                                                <span class="badge  rounded-pill badge-light-primary">Experience</span>
                                            </router-link>

                                            <router-link v-if="hasPermission('HRMS employees_detail  add_documents')"
                                                :to="{ name: 'create_documents', params: { id: adsdata1.EmployeeID } }">

                                                <span v-if="adsdata1.DocStatus == null || adsdata1.DocStatus == ''"
                                                    class="badge rounded-pill badge-light-danger">Documents</span>
                                                <span v-else
                                                    class="badge rounded-pill badge-light-primary">Documents</span>
                                            </router-link>
                                        </td>
                                        <td class="td-center">
                                            {{ adsdata1.JoiningDate }}<br />{{ Number(adsdata1.Salary).toLocaleString()
                                            }}
                                        </td>
                                        <td style="vertical-align: middle !important; text-align: center;">
                                            <div v-if="hasPermission('HRMS employees_detail update-Employee-status')">


                                                <span v-if="adsdata1.Status == 'Registered'"
                                                    class="badge badge-glow bg-success">{{ adsdata1.Status }}</span>
                                                <span v-else-if="adsdata1.Status == 'Suspended'"
                                                    class="badge badge-glow bg-warning">{{ adsdata1.Status }}</span>
                                                <span v-else-if="adsdata1.Status == 'Terminated'"
                                                    class="badge badge-glow bg-danger">{{ adsdata1.Status }}</span>
                                                <span v-else-if="adsdata1.Status == 'Resigned'"
                                                    class="badge badge-glow bg-secondary">{{ adsdata1.Status }}</span>
                                                <span v-else class="badge badge-glow bg-secondary">{{ adsdata1.Status
                                                    }}</span>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle !important;">
                                            <router-link
                                                v-if="hasPermission('HRMS employees_detail view employee profile')"
                                                :to="{ name: 'employee_detail', params: { id: adsdata1.EmployeeID } }"
                                                style="text-decoration:none;">
                                                <i class="fa-solid fa-eye"></i></router-link>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="col-md-12" style="text-align:center;padding-top:20px">
                                <pagination v-if="pageN == 3" :data="adsdata" :limit="limit"
                                    @pagination-change-page="getResults1"></pagination>
                                <pagination v-else-if="pageN == 4" :data="adsdata" :limit="limit"
                                    @pagination-change-page="getbyfilter"></pagination>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
import MaskedInput from 'vue-masked-input'
import Multiselect from 'vue-multiselect'
import { overall_location } from "../../helper/apihelper";

export default {
    data() {
        return {
            pageN: '',
            page: '',
            limit: 10,
            adsdata: {},
            success: '',

            gender: 'All',
            status: 'All',
            min_price: '',
            max_price: '',
            cnic: '',
            department: 'All',
            location: 'All',
            designation: 'All',
            emp_status: 'All',

            min_price_s: '',
            max_price_s: '',
            cnic_s: '',
            emp_id_s: '',

            designations: {},
            locations: {},
            departments: {},
            options: [],
            options1: [],
            options2: [],
            options3: ["Suspended", "Terminate", "Resigned", "Registered"],
            options4: ["All", "Probation", "Contract", "Permanent"],
            options5: ["All", "Male", "Female"],

            emp_id: '',

            count_users: {},
            keyword2: '',
        }
    },
    components: {
        MaskedInput,
        Multiselect
    },
    watch: {
        keyword2(after, before) {
            this.getResults1();
        }
    },
    methods: {

        async fetchDepartment() {
            try {
                this.departments = await this.$helpers.checkLocal('department_detail');
                this.options2 = [];
                var $this = this;
                for (var i = 0; i < $this.departments.length; i++) {
                    this.options2.push($this.departments[i].Department);
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
                this.options = [];
                var $this = this;
                for (var i = 0; i < $this.designations.length; i++) {
                    this.options.push($this.designations[i].designation_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        async fetchLocations() {
            try {
                this.locations = await this.$helpers.checkLocal('overall_location');
                this.options1 = [];

                var $this = this;
                for (var i = 0; i < $this.locations.length; i++) {
                    this.options1.push($this.locations[i].location_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        getResults1(page = 1) {
            axios.get('search_Employee_bynamecnic?page=' + page, { params: { keyword1: this.keyword2 } })
                .then(response => {
                    this.adsdata = response.data.data;
                    console.log(this.adsdata);
                    this.page = page;
                })
                .catch(error => console.log(error));
            this.pageN = 3;

        },
        getbyfilter(page = 1) {
            this.min_price_s = !this.min_price ? 'All' : this.min_price;
            this.max_price_s = !this.max_price ? 'All' : this.max_price;
            this.cnic_s = !this.cnic ? 'All' : this.cnic;
            this.emp_id_s = !this.emp_id ? 'All' : this.emp_id;
            this.department = !this.department ? 'All' : this.department;
            this.location = !this.location ? 'All' : this.location;
            this.designation = !this.designation ? 'All' : this.designation;
            this.emp_status = !this.emp_status ? 'All' : this.emp_status;
            this.status = !this.status ? 'All' : this.status;

            axios.get('./searchemployee/' + this.department + '/' + this.location + '/' + this.designation + '/' + this.gender + '/' + this.status + '/' + this.min_price_s + '/' + this.max_price_s + '/' + this.cnic_s + '/' + this.emp_id_s + '/' + this.emp_status + '?page=' + page)
                .then(data => {
                    this.adsdata = data.data.data;
                    this.page = page;
                })
                .catch(error => this.error = error.response.data.errors)
            this.keyword2 = '';
            this.pageN = 4;

        },
        async fetchAllFilters() {
            const fetchPromises = [
                this.fetchDepartment(),
                this.fetchDesignation(),
                this.fetchLocations()
            ];

            // Await all the Promises to complete
            await Promise.all(fetchPromises);
        }
    },
    async mounted() {
        await this.fetchAllFilters();
        this.getResults1();
        // this.fetchRoles();

        axios.get('./count_employees')
            .then(response => this.count_users = response.data.data)
            .catch(error => {
                this.$toastr.e('error Occur while get count employee');
            });



    }
}

</script>
