<template>
    <div >
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Attendance Devices
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body">
                                    <ul class="nav nav-pills mb-2" style="padding-left:10px !important" role="tablist">
                                        <li class="nav-item active">
                                            <a class="nav-link active" id="homeIcon-tab" data-bs-toggle="tab" href="#homeIcon" aria-controls="home" role="tab" aria-selected="true">
                                                <i class="fa-solid fa-users"></i>
                                                <span class="fw-bold">Machine Users</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profileIcon-tab" data-bs-toggle="tab" href="#profileIcon" aria-controls="profile" role="tab" aria-selected="false">
                                                <i class="fa-solid fa-users"></i>
                                                <span class="fw-bold">Machine Users</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="aboutIcon-tab" data-bs-toggle="tab" href="#aboutIcon" aria-controls="about" role="tab" aria-selected="false">
                                                <i class="fa-solid fa-users"></i>
                                                <span class="fw-bold">Machine Users</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <div class="card">
                                    <div class="card-body border-bottom">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Machine</label>
                                                <multiselect :options="options0" style="margin-right: 10px; font-size: 12px;" value="id" label="label" v-model="machine_id"></multiselect>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Department</label>
                                                <multiselect :options="options1" style="margin-right: 10px; font-size: 12px;" v-model="department"></multiselect>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Designation</label>
                                                <multiselect :options="options2" style="margin-right: 10px; font-size: 12px;" v-model="designation"></multiselect>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Employee Name</label>
                                                <input type="text" v-model="search_name" class="form-control" placeholder="Employee Name" />
                                            </div>
                                            <div class="col-md-1">
                                                <div style="height:27px;"></div>
                                                <button @click="get_users()" class="dt-button add-new btn btn-primary" tabindex="0" type="button">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="overflow-x: initial !important;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sticky-th-center">Emp. Code</th>
                                                    <th class="sticky-th-center">Employee Name</th>
                                                    <th class="sticky-th-center">Work Location</th>
                                                    <th class="sticky-th-center">Job Status</th>
                                                    <th class="sticky-th-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr :class="[users1.Status=='Terminated' ? 'table-danger' : '', users1.Status=='Resigned' ? 'table-danger' : '', users1.Status=='Suspended' ? 'table-warning' : '']" v-for="users1 in users">
                                                    <td class="td-center">{{users1.EmployeeCode}}</td>
                                                    <td class="td-left">
                                                        <div class="d-flex justify-content-left align-items-center">
                                                            <div class="avatar-wrapper">
                                                                <div class="avatar  me-1">
                                                                    <img v-if="users1.Photo=='' || users1.Photo==null" src="public/images/profile_images/pro.png" alt="Avatar" height="32" width="32">
                                                                    <img v-else v-bind:src="`public/images/profile_images/${users1.Photo}`" alt="Avatar" height="32" width="32">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column">
                                                                <a class="user_name text-truncate text-body"><span class="fw-bolder">{{users1.Name}} </span></a>
                                                                <small class="emp_post text-muted">
                                                                    <small>{{users1.Department}}-{{users1.Designation}}</small>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="td-center">{{users1.PostingCity}}</td>
                                                    <td class="td-center">{{users1.Status}}</td>
                                                    <td class="td-center">
                                                        <div class="btn-group">
                                                            <a data-bs-toggle="dropdown">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </a>
                                                            <div v-if="users1.Status == 'Terminated' || users1.Status == 'Resigned'" class="dropdown-menu dropdown-menu-end">
                                                                <a data-bs-toggle="modal" data-bs-target="#delete_setl" class="dropdown-item">
                                                                    <i class="fa-solid fa-trash-can"></i>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profileIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                            B
                        </div>
                        <div class="tab-pane" id="aboutIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                            C
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    import VueApexCharts from 'vue-apexcharts';
    export default {
        data: function () {
            return {
                search_name1: '',
                search_name: '',
                department: 'All',
                department1: '',
                designation: 'All',
                designation1: '',
                machine_id: {id: '', label: 'All'},
                machine_id1: '',

                users: {},

                Connected1: false,

                machines: {},
                shiftAwaiting: '',
                holiday: '',

                today: new Date().toJSON().slice(0, 10),
                limit: 8,
                limit2: 12,
                present: '',
                absent: '',
                late: '',
                leave: '',
                max: '',
                adsdata: {},
                adsdatas: {},
                series: [10, 20, 30],
                disabled: false,
                timeout: null,
                is_update: 'No',

                att_id: '',
                emp_id: '',
                emp_code: '',
                check_in: '08:00',
                check_out: '18:00',
                locations: {},
                designations: {},
                departments: {},

                keyword2: '',

                options0: [],
                options1: [],
                options2: [],
                options3: [],
                find_emp: {},
            }
        },
        components: {
            Multiselect,
            apexchart: VueApexCharts,
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.pull_attendance();
            },
            pull_attendance() {
                axios.get('pull_attendance', {
                })
                    .then(data => {
                        if (data.data == 'attendance updated') {
                            this.$toastr.s('Attendance has been updated!', "Congratulations!");
                            this.getResult();
                            this.is_update = 'Yes';
                        }
                        else {
                            if (this.is_update == 'No') {
                                this.$toastr.e('Attendance has not been updated!', "Caution!");
                            }
                        }
                    })
            },
            getResults2(page = 1) {
                axios.get('./attendance_detail/?page=' + page, { params: { keyword2: this.keyword2 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => console.log(error));

                    axios.get('./count_today_attendance')
                .then(response => {
                    this.max = response.data.max;
                    this.present = response.data.pres;
                    this.absent = response.data.abse;
                    this.late = response.data.late;
                    this.leave = response.data.leave;
                    this.shiftAwaiting = response.data.shiftAwaiting;
                    this.holiday = response.data.holiday;
                })
                .catch(error => { });
            },
            get_users() {
                //
                if (this.department == '' || this.department == null) {
                    this.department1 = 'All';
                }
                else {
                    this.department1 = this.department;
                }
                if (this.designation == '' || this.designation == null) {
                    this.designation1 = 'All';
                }
                else {
                    this.designation1 = this.designation;
                }

                if (this.machine_id.id == '' || this.machine_id == null) {
                    this.machine_id1 = 0;
                }
                else {
                    this.machine_id1 = this.machine_id.id;
                }

                if (this.search_name == '' || this.search_name == null) {
                    this.search_name1 = 'All';
                }
                else {
                    this.search_name1 = this.search_name;
                }

                axios.get('./get_machine_users/' + this.department1 + '/' + this.designation1 + '/' + this.machine_id1 + '/' + this.search_name1)
                    .then(response => {
                        this.users = response.data;
                    })
                    .catch(error => { });
            },
            async fetchDesignation() {
                try {
                    this.designations = await this.$helpers.checkLocal('overall_designation');
                    this.options2 = [];
                    var $this = this;
                    for (var i = 0; i < $this.designations.length; i++) {
                        this.options2.push($this.designations[i].designation_name);
                    }
                    // Process the data or perform additional actions here
                } catch (error) {
                    console.error(error);
                    // Additional error handling if needed
                }
            },

        },
        watch: {
            keyword2(after, before) {
                this.timeout = setTimeout(() => {
                    this.getResults2();
                }, 1000)
            },
        },
        mounted() {
            this.fetchDesignation();
            this.getResults2();


            this.get_users();




            axios.get('./get_machines')
                .then(response => {
                    this.machines = response.data;
                    this.options0 = [];
                    this.options0 = this.machines.map((obj) => ({
                        id: obj.Id,
                        label: `${obj.DeviceName}`,
                    }));
                })


            axios.get('department_detail2')
                .then(data => {
                    this.departments = data.data
                    this.options1 = [];

                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options1.push($this.departments[i].department_name);
                    }
                })
                .catch(error => { });
        }
    }
</script>
