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
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Warnings Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="card shadow-sm top-radius bottom-radius">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 p-2">
                                        <div class="card border-0  m-0 shadow">
                                            <div
                                                class="card-body d-flex align-items-center justify-content-between shadow-sm top-radius bottom-radius">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_users.total }}</h3>
                                                    <span>Total Warnings</span>
                                                </div>
                                                <div class="avatar bg-light-primary p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-users"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-2">
                                        <div class="card border-0  m-0 shadow">
                                            <div
                                                class="card-body d-flex align-items-center justify-content-between shadow-sm top-radius bottom-radius">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_users.first }}</h3>
                                                    <span>First Warning</span>
                                                </div>
                                                <div class="avatar bg-light-success p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-shield"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-2">
                                        <div class="card border-0  m-0 shadow">
                                            <div
                                                class="card-body d-flex align-items-center justify-content-between shadow-sm top-radius bottom-radius">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_users.second }}</h3>
                                                    <span>Second Warning</span>
                                                </div>
                                                <div class="avatar bg-light-warning p-50">
                                                    <span class="avatar-content">
                                                        <i class="fa-solid fa-user-large-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 p-2">
                                        <div class="card border-0  m-0 shadow">
                                            <div
                                                class="card-body d-flex align-items-center justify-content-between shadow-sm top-radius bottom-radius">
                                                <div>
                                                    <h3 class="fw-bolder mb-75">{{ count_users.terminate }}</h3>
                                                    <span>Terminate</span>
                                                </div>
                                                <div class="avatar bg-light-warning p-50">
                                                    <span class="avatar-content">
                                                        <i style="color:red" class="fa-solid fa-user-large-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border-0 top-radius bottom-radius">
                            <div class="card-body border-bottom">
                                <!-- <h4 class="card-title">Search & Filter</h4> -->
                                <div class="row p-3">
                                    <div class="col-md-3 user_role">
                                        <label class="form-label" for="UserRole"><img class="px-1"
                                                :src="images.solar_filter_linear" alt="icon">Designation</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                            id="UserRole" placeholder="All Designations" v-model="designation"
                                            :options="options">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-3 user_plan">
                                        <label class="form-label" for="UserPlan"><img class="px-1"
                                                :src="images.solar_filter_linear" alt="icon">Location</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                            id="UserPlan" placeholder="All Locations" v-model="location"
                                            :options="options1">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-3 user_status">
                                        <label class="form-label" for="FilterTransaction"><img class="px-1"
                                                :src="images.solar_filter_linear" alt="icon">Department</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 12px;"
                                            id="FilterTransaction" placeholder="All Departments" v-model="department"
                                            :options="options2">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-3 user_status d-flex align-items-center mt-4">
                                        <button @click="getbyfilter()" class="btn btn-secondary py-2 px-4">Search
                                        </button>
                                        <label style="color: #d93025"
                                            v-if="designation == '' && location == '' && department == ''">{{ e_search
                                            }}</label>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;"
                                class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                    <div
                                        class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter mt-50" style="margin-right: 3px;">
                                                <label>
                                                    <input autocomplete="off" id="keyword1" type="text" name="keyword1"
                                                        v-model="keyword1" class="form-control p-2" style=""
                                                        placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <router-link v-if="hasPermission('HRMS warning_detail create_warning')"
                                                to="/hr/create_warning" class="dt-button add-new btn btn-primary bg-primary p-2"
                                                tabindex="0" type="button"><span>Issue Warning
                                                    Letter</span></router-link>
                                            <router-link v-else class="dt-button add-new btn btn-danger" tabindex="0"
                                                type="button"><span>Issue Warning Letter</span></router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Emp.<br />Code</th>
                                            <th class="sticky-th-center">Employe Name</th>
                                            <th class="sticky-th-center">Location</th>
                                            <th class="sticky-th-center">Warning Date</th>
                                            <th class="sticky-th-center">Status</th>
                                            <th class="sticky-th-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class="td-center">{{ adsdata1.EmployeeCode }}</td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column"><a
                                                            class="user_name text-truncate text-body"><span
                                                                class="fw-bolder">{{ adsdata1.Name }}</span></a><small
                                                            class="emp_post text-muted">{{ adsdata1.Department }} -
                                                            {{ adsdata1.Designation }}</small></div>
                                                </div>
                                            </td>
                                            <td class="td-center">{{ adsdata1.PostingCity }}</td>
                                            <td class="td-center">{{ adsdata1.DateIssued }}</td>
                                            <td class="td-center">
                                                <span v-if="adsdata1.WarningType == 'First'"
                                                    class="badge bg-light-primary">{{ adsdata1.WarningType }}</span>
                                                <span v-else-if="adsdata1.WarningType == 'Second'"
                                                    class="badge bg-light-warning">{{ adsdata1.WarningType }}</span>
                                                <span v-else class="badge bg-light-danger">{{ adsdata1.WarningType
                                                    }}</span>
                                            </td>
                                            <td class="td-center">
                                                <div class="btn-group">
                                                    <router-link v-if="hasPermission('HRMS warning_detail actions')"
                                                        :to="{ name: 'warning_view', params: { id: adsdata1.LetterID } }"
                                                        class="me-25">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </router-link>
                                                    <router-link v-if="hasPermission('HRMS warning_detail actions')"
                                                        class="me-25">
                                                        <i class="fa-solid fa-eye" style="color: red;"></i>

                                                    </router-link>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>

export default {
    data() {
        return {
            images: {
                solar_filter_linear: "/images/solar_filter_linear.png",
                search_icon: "/images/search_icon.png",
            },
            adsdata: {},
            success: '',

            keyword1: '',
            options: [],
            options1: [],
            options2: [],
            department: '',
            location: '',
            designation: '',
            designations: {},
            departments: {},
            locations: {},
            id: '',
            e_search: '',
            email: '',
            count_users: {},
        }
    },
    methods: {



        async fetchDepartment() {
            try {
                this.departments = await this.$helpers.checkLocal('department_detail');
                var $this = this;
                // this.options2 = [];

                for (var i = 0; i < $this.departments.length; i++) {
                    this.options2.push($this.departments[i].Department);
                }

            } catch (error) {
                console.error('Error fetching department:', error); // 🔍 Error check
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


        getbyfilter(page = 1) {
            this.keyword1 = '';
            if (this.location == '' || this.location == null) {
                this.location1 = 'All';
            } else {
                this.location1 = this.location;
            }
            if (this.designation == '' || this.designation == null) {
                this.designation1 = 'All';
            } else {
                this.designation1 = this.designation;
            }
            if (this.department == '' || this.department == null) {
                this.department1 = 'All';
            } else {
                this.department1 = this.department;
            }
            axios.get('./filter_warnings/' + this.location1 + '/' + this.designation1 + '/' + this.department1 + '/?page=' + page)
                .then(data => {
                    // console.log(data, "filter warning");

                    this.adsdata = {};
                    this.adsdata = data.data.data;
                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting warnings');
                });
        },
        getResults(page = 1) {
            axios.get('./search_warnings/?page=' + page, { params: { keyword1: this.keyword1 } })
                .then(response => {
                    // console.log(response, "search warning");

                    this.adsdata = response.data.data;
                    this.location1 = 'All';
                    this.designation1 = 'All';
                    this.department1 = 'All';
                })
                .catch(error => {
                    this.$toastr.e('error Occur while getting  employee warning');
                });
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {
        this.getResults();
        this.fetchDepartment();
        // this.fetchRoles();
        this.fetchDesignation();
        this.fetchLocations();

        axios.get('./count_warnings')
            .then(response => {
                // console.log("kjndjdsbjvbdsjhv sdjh vjd vj");
                // console.log(response,"Count ----user");
                this.count_users = response.data.data;


            })
            .catch(error => {
                this.$toastr.e('error Occur while getting count warning');
            });

    }
}

</script>

<style scoped>
.border-0 {
    border: 0;
}

.top-radius {
    border-top-left-radius: 12px !important;
    border-top-right-radius: 12px !important;
}

.bottom-radius {
    border-bottom-left-radius: 12px !important;
    border-bottom-right-radius: 12px !important;
}

.bg-custom {
    background-color: #F9F9F9 !important;
}
</style>
