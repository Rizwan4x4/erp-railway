<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link
                                    to="/hr/dashboard"
                                    style="text-decoration: none"
                                >Dashboard
                                </router-link
                                >
                            </li>
                            <li class="breadcrumb-item">
                                <router-link
                                    to="/hr/attendance/dashboard"
                                    style="text-decoration: none"
                                >Attendance Detail
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Grace Period(s)
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <topBar :active="active"/>
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div
                                class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0"
                            >
                                <div class="card">
                                    <div class="card-header">
                                        <h2 style="32px" class="card-title">
                                            Grace Period(s) Detail
                                        </h2>
                                        <div
                                            class="dt-buttons d-inline-flex mt-50"
                                        >
                                            <a v-if="hasPermission('HRMS Attendance Grace-periods update-Overall grace-periods')"
                                                data-bs-toggle="modal"
                                                data-bs-target="#overall_grace"
                                                class="dt-button add-new btn btn-primary"
                                                tabindex="0"
                                                type="button"
                                            ><span
                                            >Update Overall GP</span
                                            ></a

                                            >

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            Search &amp; Filter
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-3 user_role">
                                                <label
                                                    class="form-label"
                                                    for="UserRole"
                                                >Designation</label
                                                >
                                                <multiselect
                                                    :show-labels="false"
                                                    style="
                                                        margin-right: 10px;
                                                        font-size: 15px;
                                                    "
                                                    id="UserRole"
                                                    placeholder="All Designations"
                                                    v-model="designation"
                                                    :options="options"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="col-md-3 user_plan">
                                                <label
                                                    class="form-label"
                                                    for="UserPlan"
                                                >Location</label
                                                >
                                                <multiselect
                                                    :show-labels="false"
                                                    style="
                                                        margin-right: 10px;
                                                        font-size: 15px;
                                                    "
                                                    id="UserPlan"
                                                    placeholder="All Locations"
                                                    v-model="location"
                                                    :options="options1"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="col-md-3 user_status">
                                                <label
                                                    class="form-label"
                                                    for="FilterTransaction"
                                                >Department</label
                                                >
                                                <multiselect
                                                    :show-labels="false"
                                                    style="
                                                        margin-right: 10px;
                                                        font-size: 12px;
                                                    "
                                                    id="FilterTransaction"
                                                    placeholder="All Departments"
                                                    v-model="department"
                                                    :options="options2"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="col-md-3 user_status">
                                                <button
                                                    @click="getbyfilter()"
                                                    style="
                                                        background: #c1c1c1;
                                                        width: 100%;
                                                        height: 35px !important;
                                                        margin-top: 25px;
                                                        margin-bottom: 20px;
                                                        width: 60% !important;
                                                    "
                                                    class="btn btn-common"
                                                >
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                        <br/>
                                        <div
                                            class="table-responsive"
                                            style="
                                                overflow-x: initial !important;
                                            "
                                        >
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Emp Code</th>
                                                    <th>Emp Name</th>
                                                    <th>Department</th>
                                                    <th>Location</th>
                                                    <th>Total GP</th>
                                                    <th>Used GP</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr
                                                    v-for="adsdata1 in adsdata.data"
                                                >
                                                    <td></td>
                                                    <td>
                                                        {{
                                                            adsdata1.EmployeeCode
                                                        }}
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="d-flex justify-content-left align-items-center"
                                                        >
                                                            <div
                                                                class="avatar-wrapper"
                                                            >
                                                                <div
                                                                    class="avatar me-1"
                                                                >
                                                                    <img
                                                                        v-bind:src="`public/images/profile_images/${adsdata1.Photo}`"
                                                                        alt="Avatar"
                                                                        height="32"
                                                                        width="32"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="d-flex flex-column"
                                                            >
                                                                <a
                                                                    class="user_name text-truncate text-body"
                                                                ><span
                                                                    class="fw-bolder"
                                                                >
                                                                        </span
                                                                        >{{
                                                                        adsdata1.Name
                                                                    }}</a
                                                                ><small
                                                                class="emp_post text-muted"
                                                            >{{
                                                                    adsdata1.Designation
                                                                }}</small
                                                            >
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{
                                                            adsdata1.Department
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            adsdata1.PostingCity
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            adsdata1.TotalGP
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            adsdata1.UsedGP
                                                        }}
                                                    </td>
                                                    <td>
                                                        <a
                                                            @click="
                                                                    savegrace_id(
                                                                        adsdata1.EmpGraceID,
                                                                        adsdata1.EmployeeCode,
                                                                        adsdata1.Name,
                                                                        adsdata1.TotalGP
                                                                    )
                                                                "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#employeehire1"
                                                        ><i
                                                            class="fa-solid fa-eye"
                                                        ></i
                                                        ></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            style="
                                                text-align: center;
                                                padding-top: 20px;
                                            "
                                        >
                                            <pagination
                                                :data="adsdata"
                                                :limit="limit"

                                                @pagination-change-page="
                                                    getResult
                                                "
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- Modal 1-->
        <div
            class="modal fade"
            id="employeehire1"
            aria-labelledby="employeehire1Label"
            tabindex="-1"
            style="display: none"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">
                            Update Employee Grace Period
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="cleargrace_id()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <p
                            class="alert alert-info"
                            style="color: #000 !important"
                        >
                            Updated Grace period will be used from current
                            session
                        </p>
                        <!-- form -->
                        <div
                            id="addNewCardValidation"
                            class="row gy-1 gx-2 mt-75"
                            onsubmit="return false"
                        >
                            <div class="row">
                                <div class="col-md-6">
                                    <label
                                        class="form-label"
                                        for="modalAddCardName"
                                    >Employee Code</label
                                    >
                                    <input
                                        readonly
                                        type="text"
                                        v-model="emp_code"
                                        class="form-control"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label"
                                        for="modalAddCardName"
                                    >Employee Name</label
                                    >
                                    <input
                                        type="text"
                                        readonly
                                        v-model="emp_name"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label
                                        class="form-label"
                                        for="modalAddCardName"
                                    >Add Extra Grace Period (In
                                        Minutes)</label
                                    >
                                    <input
                                        type="number"
                                        v-model="emp_totalgp"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-primary"
                            @click="update_ind()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Save
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="cleargrace_id()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="overall_grace"
            aria-labelledby="overall_grace"
            tabindex="-1"
            style="display: none"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">
                            Update Overall Grace Period
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="cleargrace_id()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <p
                            class="alert alert-info"
                            style="color: #000 !important"
                        >
                            Updated Grace period will be used from current
                            session
                        </p>
                        <!-- form -->
                        <div
                            id="addNewCardValidation"
                            class="row gy-1 gx-2 mt-75"
                            onsubmit="return false"
                        >
                            <div class="row">
                                <div class="col-md-6">
                                    <label
                                        class="form-label"
                                        for="modalAddCardName"
                                    >Search By</label
                                    >
                                    <!-- <select @change="search_by1()" class="form-select" v-model="search_by">
                                      <option value="">Search By</option>
                                       <option value="Designation">Designation</option>
                                      <option value="Department">Department</option>
                                      <option value="Location">Location</option>

                                      </select> -->
                                    <multiselect
                                        :show-labels="false"
                                        @input="search_by1()"
                                        style="
                                            margin-right: 10px;
                                            font-size: 15px;
                                        "
                                        id="UserRole"
                                        placeholder="Search By"
                                        v-model="search_by"
                                        :options="options3"
                                    >
                                    </multiselect>
                                    <span
                                        style="color: #d93025"
                                        v-if="search_by == ''"
                                    >{{ e_search_by }}</span
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label"
                                        for="modalAddCardName"
                                    >Employee Name</label
                                    >
                                    <!-- <select  class="form-select" v-model="search_name">
                                     <option value="">Search Name</option>
                                     <option v-for='searchname1 in searchname' :value='searchname1.num'>{{ searchname1.num }}</option>

                                     </select> -->
                                    <multiselect
                                        :show-labels="false"
                                        style="
                                            margin-right: 10px;
                                            font-size: 15px;
                                        "
                                        id="modalAddCardName"
                                        placeholder="Search Name"
                                        v-model="search_name"
                                        :options="options4"
                                    >
                                    </multiselect>
                                    <span
                                        style="color: #d93025"
                                        v-if="search_name == ''"
                                    >{{ e_search_name }}</span
                                    >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label
                                        class="form-label"
                                        for="modalAddCardName"
                                    >Updated Grace Period (In
                                        Minutes)</label
                                    >
                                    <input
                                        type="number"
                                        v-model="overall_totalgp"
                                        class="form-control"
                                    />
                                    <span
                                        style="color: #d93025"
                                        v-if="overall_totalgp == ''"
                                    >{{ e_overall_totalgp }}</span
                                    >
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-primary"
                            @click="update_overall()"
                        >
                            Update
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="cleargrace_id()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import topBar from "./topBar.vue";

export default {
    components: {
        Multiselect,
        topBar,
    },
    data() {
        return {
            active: "attendance_grace_periods",
            department: "",
            location: "",
            designation: "",
            designations: {},
            limit: 10,
            locations: {},
            departments: {},
            adsdata: {},
            emp_code: "",
            emp_name: "",
            emp_totalgp: "",
            grace_id: "",
            options: [],
            options1: [],
            options2: [],
            options3: ["Designation", "Department", "Location"],
            options4: [],
            e_search_by: "",
            e_search_name: "",
            e_overall_totalgp: "",

            search_by: "",
            search_name: "",
            overall_totalgp: "",
            searchname: {},
        };
    },

    methods: {
        update_overall() {
            if (
                this.search_by == "" ||
                this.search_name == "" ||
                this.overall_totalgp == ""
            ) {
                if (this.search_by == "") {
                    this.e_search_by = "Select Search By Field!";
                } else {
                    this.e_search_by = "";
                }

                if (this.search_name == "") {
                    this.e_search_name = "Select Search Name Field!";
                } else {
                    this.e_search_name = "";
                }
                if (this.overall_totalgp == "") {
                    this.e_overall_totalgp = "Update Grace Period Value";
                } else {
                    this.e_overall_totalgp = "";
                }
            } else {
                axios
                    .post("./update_overall_grace", {
                        search_by: this.search_by,
                        search_name: this.search_name,
                        overall_totalgp: this.overall_totalgp,
                    })
                    .then((data) => {
                        this.$toastr.s(
                            "Updated Selected Employees Successfully",
                            "Congratulations"
                        );
                        this.adsdata = data.data;
                        this.overall_totalgp = "";
                        this.search_by = "";
                        this.search_name = "";
                    });
            }
        },
        update_ind() {
            axios
                .post("./update_ind_grace", {
                    grace_ids: this.grace_id,
                    em_code: this.emp_code,
                    em_name: this.emp_name,
                    em_totalgp: this.emp_totalgp,
                })
                .then((data) => {
                    this.$toastr.s(
                        "Updated Individual Employee Successfully",
                        "Congratulations"
                    );
                    this.adsdata = data.data;
                    this.emp_totalgp = "";
                });
        },
        savegrace_id(graceid, employee_code, employee_name, totalgp) {
            this.grace_id = graceid;
            this.emp_code = employee_code;
            this.emp_name = employee_name;
        },
        search_by1() {
            if (this.search_by == "") {
                this.$toastr.e(
                    "Please Select Search By Field First",
                    "Compulsory Field!"
                );
            } else {
                axios
                    .get("./search_by_grace_period/" + this.search_by)
                    .then((response) => {
                        this.searchname = response.data;
                        this.options4 = [];

                        var $this = this;
                        for (var i = 0; i < $this.searchname.length; i++) {
                            this.options4.push($this.searchname[i].num);
                        }
                    })
                    .catch((error) => {
                    });
            }
        },
        cleargrace_id() {
            this.grace_id = "";
            this.emp_code = "";
            this.emp_name = "";
            this.emp_totalgp = "";
        },
        getResult(page = 1) {
            axios
                .get("./overall_grace_period?page=" + page)
                .then((response) => (this.adsdata = response.data))
                .catch((error) => {
                });
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
    },

    mounted() {
        axios
            .get("department_detail2")
            .then((data) => {
                this.departments = data.data;
                this.options2 = [];

                var $this = this;
                for (var i = 0; i < $this.departments.length; i++) {
                    this.options2.push($this.departments[i].department_name);
                }
            })
            .catch((error) => {});
        this.fetchDesignation()
        this.fetchLocations()
        this.getResult();
    },
};
</script>
