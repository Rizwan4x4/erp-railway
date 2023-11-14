<template>
    <div >
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
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
                        <div class="app-calendar overflow-hidden border">
                            <div class="row g-0">
                                <div class="col position-relative">
                                    <div
                                        class="card shadow-none border-0 mb-0 rounded-0"
                                    >
                                        <div class="card-body pb-0">
                                            <div
                                                class="row"
                                                id="table-hover-row"
                                            >
                                                <div class="col-12">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div
                                                                class="col-md-8"
                                                            >
                                                                <h4>
                                                                    Employee's
                                                                    time
                                                                    adjustment
                                                                </h4>
                                                            </div>
                                                            <div
                                                                class="col-md-4"
                                                            >
                                                                <input
                                                                    autocomplete="off"
                                                                    id="keyword3"
                                                                    type="text"
                                                                    name="keyword3"
                                                                    v-model="
                                                                        keyword3
                                                                    "
                                                                    class="form-control"
                                                                    placeholder="Search By Emp. Name/Code"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div
                                                            class="table-responsive"
                                                        >
                                                            <table
                                                                class="table table-hover"
                                                            >
                                                                <thead>
                                                                    <tr>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Emp.
                                                                            Code
                                                                        </th>
                                                                        <th>
                                                                            Employee
                                                                            Name
                                                                        </th>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Date
                                                                        </th>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Adjustment
                                                                            in
                                                                        </th>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Time
                                                                        </th>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Manager<br />Status
                                                                        </th>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Hr<br />Status
                                                                        </th>
                                                                        <th
                                                                            class="text-center"
                                                                        >
                                                                            Reason
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr
                                                                        v-for="details1 in details.data"
                                                                    >
                                                                        <td
                                                                            class="text-center"
                                                                        >
                                                                            {{
                                                                                details1.Employee_Code
                                                                            }}
                                                                        </td>
                                                                        <td
                                                                            class="sorting_1"
                                                                        >
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
                                                                                            v-if="
                                                                                                details1.Photo ==
                                                                                                    '' ||
                                                                                                details1.Photo ==
                                                                                                    null
                                                                                            "
                                                                                            src="public/images/profile_images/pro.png"
                                                                                            alt="Avatar"
                                                                                            height="32"
                                                                                            width="32"
                                                                                        />
                                                                                        <img
                                                                                            v-else
                                                                                            v-bind:src="`public/images/profile_images/${details1.Photo}`"
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
                                                                                            >{{
                                                                                                details1.Name
                                                                                            }}
                                                                                        </span></a
                                                                                    ><small
                                                                                        class="emp_post text-muted"
                                                                                    >
                                                                                        <small
                                                                                            >{{
                                                                                                details1.Department
                                                                                            }}-{{
                                                                                                details1.Designation
                                                                                            }}</small
                                                                                        >
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                details1.att_date
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            {{
                                                                                details1.TimeAdjFor
                                                                            }}
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                v-if="
                                                                                    details1.Hours <
                                                                                        10 &&
                                                                                    details1.Hours >
                                                                                        0
                                                                                "
                                                                                >0</span
                                                                            >{{
                                                                                details1.Hours
                                                                            }}:<span
                                                                                v-if="
                                                                                    details1.Minutes <
                                                                                        10 &&
                                                                                    details1.Minutes >
                                                                                        0
                                                                                "
                                                                                >0</span
                                                                            >{{
                                                                                details1.Minutes
                                                                            }}
                                                                            minuts
                                                                        </td>
                                                                        <td>
                                                                            <div v-if="hasPermission('HRMS Attendance Time-Adjustment update-manager-status')">

                                                                         
                                                                            <span
                                                                                @click="
                                                                                    updatestatus(
                                                                                        details1.Name,
                                                                                        details1.Employee_Code,
                                                                                        details1.TimeAdjId,
                                                                                        details1.EmployeeID,
                                                                                        details1.TimeAdjFor,
                                                                                        details1.att_date,
                                                                                        details1.Hours,
                                                                                        details1.Minutes,
                                                                                        details1.ManagerApproval,
                                                                                        details1.HrApproval,
                                                                                        details1.Reason,
                                                                                        'man'
                                                                                    )
                                                                                "
                                                                                v-if="
                                                                                    details1.ManagerApproval ==
                                                                                    'Pending'
                                                                                "
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#updateloanstatus"
                                                                                class="badge bg-gradient-warning"
                                                                                >Pending</span
                                                                            >
                                                                            <span
                                                                                class="badge bg-gradient-success"
                                                                                v-if="
                                                                                    details1.ManagerApproval ==
                                                                                    'Approved'
                                                                                "
                                                                                >Approved</span
                                                                            >
                                                                            <span
                                                                                class="badge bg-gradient-danger"
                                                                                v-if="
                                                                                    details1.ManagerApproval ==
                                                                                    'Rejected'
                                                                                "
                                                                                >Rejected</span
                                                                            >
                                                                             </div>
                                                                        </td>
                                                                        <td
                                                                            style="
                                                                                text-align: center;
                                                                            "
                                                                        >
                                                                        <div v-if="hasPermission('HRMS Attendance Time-Adjustment update-HR-status')">
                                                                            <span
                                                                                @click="
                                                                                    updatestatus(
                                                                                        details1.Name,
                                                                                        details1.Employee_Code,
                                                                                        details1.TimeAdjId,
                                                                                        details1.EmployeeID,
                                                                                        details1.TimeAdjFor,
                                                                                        details1.att_date,
                                                                                        details1.Hours,
                                                                                        details1.Minutes,
                                                                                        details1.ManagerApproval,
                                                                                        details1.HrApproval,
                                                                                        details1.Reason,
                                                                                        'hr'
                                                                                    )
                                                                                "
                                                                                v-if="
                                                                                    details1.HrApproval ==
                                                                                    'Pending'
                                                                                "
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#updateloanstatus"
                                                                                class="badge bg-gradient-warning"
                                                                                >Pending</span
                                                                            >
                                                                            <span
                                                                                class="badge bg-gradient-success"
                                                                                v-if="
                                                                                    details1.HrApproval ==
                                                                                    'Approved'
                                                                                "
                                                                                >Approved</span
                                                                            >
                                                                            <span
                                                                                class="badge bg-gradient-danger"
                                                                                v-if="
                                                                                    details1.HrApproval ==
                                                                                    'Rejected'
                                                                                "
                                                                                >Rejected</span
                                                                            >
                                                                        </div>
                                                                        </td>
                                                                        <td
                                                                            style="
                                                                                text-align: center;
                                                                            "
                                                                        >
                                                                            {{
                                                                                details1.Reason
                                                                            }}
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
                                                                :limit="limit3"
                                                                :data="details"
                                                                @pagination-change-page="
                                                                    getAdjustment
                                                                "
                                                            ></pagination>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="body-content-overlay"></div>
                            </div>
                        </div>
                    </section>
                    <div
                        class="modal fade"
                        id="updateloanstatus"
                        tabindex="-1"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-lg modal-dialog-centered modal-edit-user"
                        >
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">
                                            Update Time Adjustment Status
                                        </h1>
                                    </div>
                                    <form
                                        id="editUserForm"
                                        class="row gy-1 pt-75"
                                        onsubmit="return false"
                                    >
                                        <div class="col-12 col-md-6">
                                            <label class="form-label"
                                                >Name</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="emp_name1"
                                            />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label"
                                                >Employee Code</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="emp_code1"
                                            />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label"
                                                >Request For</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="requestfor"
                                            />
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <label class="form-label"
                                                >Date</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="date"
                                            />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label"
                                                >Houres</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="Houres"
                                            />
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label"
                                                >Minutes</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="Minutes"
                                            />
                                        </div>
                                        <div
                                            v-if="who != 'man'"
                                            class="col-12 col-md-3"
                                        >
                                            <label class="form-label"
                                                >Manager Status</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="ManagerStatus"
                                            />
                                        </div>
                                        <div
                                            v-if="who != 'hr'"
                                            class="col-12 col-md-3"
                                        >
                                            <label class="form-label"
                                                >HR Status</label
                                            >
                                            <input
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="HRStatus"
                                            />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label"
                                                >Reason</label
                                            >
                                            <textarea
                                                type="text"
                                                disabled
                                                class="form-control"
                                                v-model="Reason"
                                            ></textarea>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label"
                                                >Update status</label
                                            >
                                            <select
                                                v-model="newstatus"
                                                class="form-select"
                                            >
                                                <option value="" selected>
                                                    Select
                                                </option>
                                                <option value="Approved">
                                                    Approve
                                                </option>
                                                <option value="Pending">
                                                    Pending
                                                </option>
                                                <option value="Rejected">
                                                    Reject
                                                </option>
                                            </select>
                                            <span
                                                style="
                                                    color: #db4437;
                                                    font-size: 11px;
                                                "
                                                v-if="newstatus == ''"
                                                >{{ newstatus_error }}</span
                                            >
                                        </div>
                                        <div
                                            class="col-12 text-center mt-2 pt-50"
                                        >
                                            <button
                                                v-if="newstatus == ''"
                                                type="button"
                                                :disabled="disabled1"
                                                @click="delay1()"
                                                class="btn btn-primary waves-effect waves-float waves-light"
                                            >
                                                Update
                                            </button>
                                            <button
                                                v-else
                                                type="button"
                                                :disabled="disabled1"
                                                @click="delay1()"
                                                class="btn btn-primary waves-effect waves-float waves-light"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            >
                                                Update
                                            </button>
                                            <button
                                                type="reset"
                                                class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"
                                            >
                                                Close
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
        <!-- END: Content-->
    </div>
</template>
<script>
import topBar from "./topBar.vue";
import VueApexCharts from "vue-apexcharts";
export default {
    components: {
        apexchart: VueApexCharts,
        topBar,
    },
    data: function () {
        return {
            active: "time_adjustment",
            limit3: 12,
            keyword3: "",
            tas: "Pending",
            details: {},

            emp_name1: "",
            emp_code1: "",
            who: "",
            requestfor: "",
            date: "",
            Candidateid: "",
            tm_id: "",
            Houres: "",
            Minutes: "",
            ManagerStatus: "",
            HRStatus: "",
            Reason: "",
            newstatus: "",
            newstatus_error: "",
            //
            disabled1: false,
            timeout1: null,
        };
    },
    methods: {
        updatestatus(
            emp_name1,
            emp_code1,
            tm_id,
            EmployeeID,
            TimeAdjFor,
            date,
            Houres,
            Minutes,
            ManagerStatus,
            HRStatus,
            Reason,
            who
        ) {
            (this.emp_name1 = emp_name1),
                (this.emp_code1 = emp_code1),
                (this.tm_id = tm_id),
                (this.Candidateid = EmployeeID),
                (this.requestfor = TimeAdjFor),
                (this.date = date),
                (this.Houres = Houres),
                (this.Minutes = Minutes),
                (this.ManagerStatus = ManagerStatus),
                (this.HRStatus = HRStatus),
                (this.Reason = Reason),
                (this.who = who);
        },
        delay1() {
            this.disabled1 = true;
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false;
            }, 5000);
            this.updatestatus1();
        },
        updatestatus1() {
            if (this.newstatus == "") {
                this.newstatus_error = "Select status to change";
                this.$toastr.e("Select status to change!", "Caution!");
            } else {
                this.newstatus_error = "";
                axios
                    .post("./update_TM_sts", {
                        tmid: this.tm_id,
                        newstatus: this.newstatus,
                        who: this.who,
                        emp_id: this.Candidateid,
                        date: this.date,
                        hours: this.Houres,
                        minuts: this.Minutes,
                    })
                    .then((data) => {
                        if (data.data == "Status updated!") {
                            this.$toastr.s(
                                "Time adjustment status changed successfully!",
                                "Congratulations"
                            );
                            this.tm_id = "";
                            this.newstatus = "";
                            this.who = "";
                            this.getAdjustment();
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                    });
            }
        },
        getAdjustment(page = 1) {
            axios
                .get("TimeAdjustment_detail/?page=" + page, {
                    params: { keyword: this.keyword3 },
                })
                .then((response) => (this.details = response.data))
                .catch((error) => {});
        },
    },
    watch: {
        keyword3(after, before) {
            this.getAdjustment();
        },
    },
    mounted() {
        this.getAdjustment();

       
    },
};
</script>
