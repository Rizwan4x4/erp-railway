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
                                    >Dashboard</router-link
                                >
                            </li>
                            <li class="breadcrumb-item active">
                                Attendance Details
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <topBar :active="active" />
                    <section class="app-user-view-account">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div
                                        class="row"
                                        style="margin-bottom: 10px"
                                    >
                                        <div class="col-md-12">
                                            <div class="row g-1">
                                                <div class="col-md-9">
                                                    <h4>Search & filter</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="row"
                                        style="margin-bottom: 10px"
                                    >
                                        <div class="col-md-2">
                                            <label
                                                class="form-label"
                                                for="FilterTransaction"
                                                >Employee Name _ Code</label
                                            >
                                            <multiselect
                                                style="margin-right: 10px"
                                                v-model="emp_name"
                                                :options="options0"
                                                :show-labels="false"
                                            ></multiselect>
                                        </div>
                                        <div
                                            class="col-md-2"

                                        >
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
                                                v-model="att_department"
                                                :options="options2"
                                            >
                                            </multiselect>
                                        </div>
                                        <div class="col-md-2">
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
                                                v-model="att_designation"
                                                :options="options"
                                            ></multiselect>
                                        </div>
                                        <div class="col-md-1">
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
                                                v-model="att_location"
                                                :options="options1"
                                            >
                                            </multiselect>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label"
                                                >Date From</label
                                            >
                                            <input
                                                type="date"
                                                v-model="att_startingdate"
                                                class="form-control"
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label"
                                                >Date To</label
                                            >
                                            <input
                                                type="date"
                                                class="form-control"
                                                v-model="att_closingdate"
                                            />
                                        </div>
                                        <div class="col-md-1">
                                            <button
                                                @click="daily_attendance()"
                                                style="margin-top: 25px"
                                                class="btn btn-secondary"
                                            >
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="table-responsive"
                                        style="overflow-x: initial !important"
                                    >
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Emp. Code
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Employee Name
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Designation
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Department
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Date
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Check In
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Check Out
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Status
                                                    </th>
                                                    <th
                                                        class="sticky-th-center"
                                                    >
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody  v-if="att_report && att_report.length > 0">
                                                <tr
                                                    v-for="att_report1 in att_report"
                                                >
                                                    <td class="td-center">
                                                        {{
                                                            att_report1.EmployeeCode
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{ att_report1.Name }}
                                                    </td>
                                                    <td class="td-center">
                                                        {{
                                                            att_report1.Designation
                                                        }}
                                                    </td>
                                                    <td class="td-center">
                                                        {{
                                                            att_report1.Department
                                                        }}
                                                    </td>
                                                    <td class="td-center">
                                                        {{
                                                            att_report1.ATTDate
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td-center"
                                                        v-if="
                                                            att_report1.CheckIN !=
                                                            null
                                                        "
                                                    >
                                                        {{
                                                            att_report1.CheckIN.substring(
                                                                0,
                                                                5
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td-center"
                                                        v-else
                                                    ></td>
                                                    <td
                                                        class="td-center"
                                                        v-if="
                                                            att_report1.CheckOut !=
                                                            null
                                                        "
                                                    >
                                                        {{
                                                            att_report1.CheckOut.substring(
                                                                0,
                                                                5
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td-center"
                                                        v-else
                                                    ></td>
                                                    <td class="td-center">
                                                        {{
                                                            att_report1.AttStatus
                                                        }}
                                                    </td>
                                                    <td
                                                        class="td-center"

                                                    >
                                                        <a
                                                            @click="
                                                                saveatt_id(
                                                                    att_report1.OpeningTime,
                                                                    att_report1.ClosingTime,
                                                                    att_report1.AttDataID,
                                                                    att_report1.EmpID,
                                                                    att_report1.EmployeeCode,
                                                                    att_report1.Name,
                                                                    att_report1.CheckIN.substring(
                                                                        0,
                                                                        5
                                                                    ),
                                                                    att_report1.CheckOut.substring(
                                                                        0,
                                                                        5
                                                                    )
                                                                )
                                                            "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#employeehire1"
                                                        >
                                                            <i
                                                                class="fa-solid fa-edit"
                                                            ></i>
                                                        </a>
                                                    </td>
                                                    <!-- <td
                                                        class="td-center"
                                                        v-else
                                                    >
                                                        <a
                                                            @click="
                                                                saveatt_id(
                                                                    att_report1.OpeningTime,
                                                                    att_report1.ClosingTime,
                                                                    att_report1.AttDataID,
                                                                    att_report1.EmpID,
                                                                    att_report1.EmployeeCode,
                                                                    att_report1.Name,
                                                                    att_report1.CheckIN,
                                                                    att_report1.CheckOut
                                                                )
                                                            "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#employeehire1"
                                                            ><i
                                                                class="fa-solid fa-edit"
                                                            ></i
                                                        ></a>
                                                    </td> -->
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
    <tr>
        <h3  class='text-center justify-content-center' colspan="5">No data to show</h3>
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
                                            :limit="limit2"
                                            :data="att_report"
                                            @pagination-change-page="
                                                daily_attendance
                                            "
                                        ></pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- END: Content-->
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
                <div class="modal-content pb-5">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">
                            Update Employee Attendance
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
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"
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
                                    <label class="form-label"
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
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Check In
                                        <span
                                            style="
                                                color: #db4437;
                                                font-size: 11px;
                                            "
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="time"
                                        v-model="check_in"
                                        class="form-control"
                                    />
                                    <span
                                        style="color: #db4437; font-size: 11px"
                                        v-if="
                                            check_in == '' || check_in == null
                                        "
                                        >{{ e_check_in }}</span
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Check Out</label>
                                    <input
                                        type="time"
                                        v-model="check_out"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <br />
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button
                            v-if="check_in != '' && check_in != null"
                            class="btn btn-primary"
                            @click="update_att()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Update Attendance
                        </button>
                        <button
                            v-else
                            class="btn btn-danger"
                            @click="update_att()"
                        >
                            Update Attendance
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            @click="cleargrace_id()"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import topBar from "./topBar.vue";
import Multiselect from "vue-multiselect";
export default {
    components: {
        Multiselect,
        topBar,
    },
    data: function () {
        return {
            active: "all",
            e_check_in: "",
            options0: [],
            limit2: 12,
            att_startingdate1: "",
            att_closingdate1: "",
            empa_code1: "",
            att_id: "",
            emp_id: "",
            emp_code: "",
            emp_name: "",
            check_in: "",
            check_out: "",
            locations: {},
            designations: {},
            departments: {},
            options: [],
            options1: [],
            options2: [],
            att_department: "All",
            att_startingdate: new Date().toJSON().slice(0, 10),
            att_closingdate: new Date().toJSON().slice(0, 10),
            att_designation: "All",
            att_location: "All",
            att_report: {},
        };
    },
    methods: {

        async fetchDepartment() {
            try {
                this.departments = await this.$helpers.checkLocal('department_detail');;

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
        update_att() {
            if (this.check_in == "" || this.check_in == null) {
                this.e_check_in = "Select check in time";
            } else {
                this.e_check_in = "";
                axios
                    .post("./update_ind_att", {
                        att_id: this.att_id,
                        check_in: this.check_in,
                        check_out: this.check_out,
                    })
                        .then(data => {
                            if (data.data.data == '1') {
                                this.$toastr.s("Updated  Employee Attendance Successfully!", "Congratulations");
                                this.check_in = '';
                                this.check_out = '';
                                this.daily_attendance();
                            }
                            else {
                                this.$toastr.e(data.data, "Error!");
                            }
                        })
                        .catch(error => {
                    this.$toastr.e('error Occur while updating attendence details');
                });
                }

            },
            saveatt_id(o_time, c_time, attid, empid, empcode, employeename, checkin, checkout) {
                if (checkin == '' || checkin == null) {
                    this.check_in = o_time;
                }
                else {
                    this.check_in = checkin;
                }
                if (checkout == '' || checkout == null) {
                    this.check_out = c_time;
                }
                else {
                    this.check_out = checkout;
                }

                this.att_id = attid;
                this.emp_id = empid;
                this.emp_code = empcode;
                this.emp_name = employeename;
            },
            daily_attendance(page = 1) {
                if (this.att_startingdate == '') {
                    this.att_startingdate1 = '2000-12-10';
                }
                else {
                    this.att_startingdate1 = this.att_startingdate;
                }
                if (this.att_closingdate == '') {
                    this.att_closingdate1 = '9999-01-10';
                }
                else {
                    this.att_closingdate1 = this.att_closingdate;
                }
                if (this.emp_name != '') {
                    var s_url = this.emp_name.split('_');
                    this.empa_code1 = s_url[1];
                }
                else {
                    this.empa_code1 = '-';
                }

                axios.get('./getattendance/' + this.att_department + '/' + this.att_location + '/' + this.att_designation + '/' + this.att_startingdate1 + '/' + this.att_closingdate1 + '/' + this.empa_code1 + '/?page=' + page)
                    .then(response => {
                        if (response.data.data && response.data.data.data.length > 0) {
            this.att_report = response.data.data.data;
        } else {
            this.$toastr.w('No Attendence data to show ');
        }

                    })
                    .catch(error => {
                    this.$toastr.e('error Occur while getting attendence details');
                });
            },
            cleargrace_id() {
                this.att_id = '';
                this.emp_id = '';
                this.emp_code = '';
                this.emp_name = '';
                this.check_in = '08:00';
                this.check_out = '18:00';
            },

        saveatt_id(
            o_time,
            c_time,
            attid,
            empid,
            empcode,
            employeename,
            checkin,
            checkout
        ) {
            if (checkin == "" || checkin == null) {
                this.check_in = o_time;
            } else {
                this.check_in = checkin;
            }
            if (checkout == "" || checkout == null) {
                this.check_out = c_time;
            } else {
                this.check_out = checkout;
            }

            this.att_id = attid;
            this.emp_id = empid;
            this.emp_code = empcode;
            this.emp_name = employeename;
        },

    },
    mounted() {
        this.fetchDepartment();
        this.fetchRoles();
        this.fetchDesignation();
        this.fetchLocations();


        this.daily_attendance();

        axios
            .get("find_emp_id")
            .then((data) => {
                this.find_emp = data.data.data;
                this.options0 = [];
                var $this = this;
                for (var i = 0; i < $this.find_emp.length; i++) {
                    this.options0.push(
                        $this.find_emp[i].Name +
                            "_" +
                            $this.find_emp[i].EmployeeCode
                    );
                }
            })
            .catch((error) => {});

        axios
            .get("overall_leaves")
            .then((response) => (this.leaves = response.data.data))
            .catch((error) => {});
    },
};
</script>
