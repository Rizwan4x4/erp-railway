<template>
    <div>
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
                                >Dashboard
                                </router-link
                                >
                            </li>
                            <li class="breadcrumb-item active">
                                Today's Attendance
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <top-bar :active="active"/>
                    <section class="app-user-view-account">
                        <div class="row">
                            <div
                                class="col-xl-9 col-lg-9 col-md-9 order-1 order-md-0"
                            >
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div
                                                class="col-md-7"
                                                style="width: 45%"
                                            >
                                                <h4>
                                                    Today's Attendance
                                                    <small>({{ today }})</small>
                                                </h4>
                                            </div>
                                            <div class="col-md-5">
                                                <input
                                                    type="text"
                                                    v-model="keyword2"
                                                    class="form-control"
                                                    placeholder="Search By Emp. Name/Code"
                                                />
                                            </div>
                                            <div
                                                class="col-md-3"
                                                style="width: 20%"
                                            >
                                                <!--<button :disabled="disabled" @click="delay()" class="btn btn-outline-primary waves-effect">Pull Attendance</button>-->
                                                <button v-if="hasPermission('HRMS Attendance Live-Attendance Sync. Attendance')"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editpayroll"
                                                    :disabled="disabled"
                                                    class="btn btn-primary waves-effect"
                                                >
                                                    Sync. Attendance
                                                </button>
                                                <button v-else 
                                                  
                                                    class="btn btn-danger waves-effect"
                                                >
                                                    Sync. Attendance
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div
                                            class="table-responsive"
                                            style="
                                                overflow-x: initial !important;
                                            "
                                        >
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Emp.Code</th>
                                                    <th>Employee Name</th>
                                                    <th>Location</th>
                                                    <th>Check In</th>
                                                    <th>Check Out</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr
                                                    class="odd"
                                                    v-for="adsdata1 in adsdata.data"
                                                >
                                                    <td>
                                                        {{
                                                            adsdata1.EmployeeCode
                                                        }}
                                                    </td>
                                                    <td class="sorting_1">
                                                        <div
                                                            class="d-flex justify-content-left align-items-center"
                                                        >
                                                            <div
                                                                class="d-flex flex-column"
                                                            >
                                                                <a
                                                                    class="user_name text-truncate text-body"
                                                                ><span
                                                                    class="fw-bolder"
                                                                >{{
                                                                        adsdata1.Name
                                                                    }}</span
                                                                ></a
                                                                ><small
                                                                class="emp_post text-muted"
                                                            >{{
                                                                    adsdata1.Department
                                                                }}-{{
                                                                    adsdata1.Designation
                                                                }}</small
                                                            >
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{
                                                            adsdata1.PostingCity
                                                        }}
                                                    </td>
                                                    <td
                                                        v-if="
                                                                adsdata1.CheckIN !=
                                                                null
                                                            "
                                                    >
                                                        {{
                                                            adsdata1.CheckIN.substring(
                                                                0,
                                                                5
                                                            )
                                                        }}
                                                    </td>
                                                    <td v-else></td>
                                                    <td
                                                        v-if="
                                                                adsdata1.CheckOut !=
                                                                null
                                                            "
                                                    >
                                                        {{
                                                            adsdata1.CheckOut.substring(
                                                                0,
                                                                5
                                                            )
                                                        }}
                                                    </td>
                                                    <td v-else></td>
                                                    <td>
                                                            <span
                                                                v-if="
                                                                    adsdata1.AttStatus ==
                                                                    'P'
                                                                "
                                                                class="badge bg-light-success"
                                                            >Present</span
                                                            >
                                                        <span
                                                            v-else-if="
                                                                    adsdata1.AttStatus ==
                                                                    'L'
                                                                "
                                                            class="badge bg-light-warning"
                                                        >Late</span
                                                        >
                                                        <span
                                                            v-else-if="
                                                                    adsdata1.AttStatus ==
                                                                    'A'
                                                                "
                                                            class="badge bg-light-danger"
                                                        >Absent</span
                                                        >
                                                        <span
                                                            v-else-if="
                                                                    adsdata1.AttStatus ==
                                                                    'H'
                                                                "
                                                            class="badge bg-light-info"
                                                        >Holiday</span
                                                        >
                                                        <!-- <span v-else-if="adsdata1.AttStatus == null" class="badge bg-light-secondary">Shift Awaiting</span> -->
                                                        <span
                                                            v-else-if="
                                                                    isShiftStarted(
                                                                        adsdata1
                                                                    )
                                                                "
                                                            class="badge bg-light-primary"
                                                        >Un-Marked</span
                                                        >
                                                        <span
                                                            v-else
                                                            class="badge bg-light-secondary"
                                                        >Shift
                                                                Awaiting</span
                                                        >
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
                                                :limit="limit"
                                                :data="adsdata"
                                                @pagination-change-page="
                                                    getResults2
                                                "
                                            ></pagination>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-xl-3 col-lg-3 col-md-3 order-1 order-md-0"
                            >
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Today's summary
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <label class="form-label"
                                        >Shift Awaiting</label
                                        >
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="secondary"
                                                :value="shiftAwaiting"
                                                :label="`${shiftAwaiting}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                        <label class="form-label"
                                        >Un-Marked</label
                                        >
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="primary"
                                                :value="UnMarked"
                                                :label="`${UnMarked}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                        <label class="form-label"
                                        >On Holiday</label
                                        >
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="info"
                                                :value="holiday"
                                                :label="`${holiday}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                        <label class="form-label"
                                        >Present</label
                                        >
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="success"
                                                :value="present + late"
                                                :label="`${present + late}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                        <label class="form-label">Late</label>
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="warning"
                                                :value="late"
                                                :label="`${late}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                        <label class="form-label"
                                        >On leave</label
                                        >
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="primary"
                                                :value="leave"
                                                :label="`${leave}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                        <label class="form-label">Absent</label>
                                        <b-progress
                                            animated
                                            show-progress
                                            :max="max"
                                            class="mb-3"
                                        >
                                            <b-progress-bar
                                                variant="danger"
                                                :value="absent"
                                                :label="`${absent}`"
                                            ></b-progress-bar>
                                        </b-progress>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
import topBar from "./topBar.vue";

export default {
    data: function () {
        return {
            active: "live",
            shiftAwaiting: "",
            holiday: "",
            today: new Date().toJSON().slice(0, 10),
            limit: 8,
            limit2: 12,
            present: "",
            absent: "",
            late: "",
            leave: "",
            max: "",
            adsdata: {},
            adsdatas: {},
            series: [10, 20, 30],
            options: {
                chart: {
                    id: "vuechart-example",
                    height: 150,
                },
                labels: ["Sick", "Casual", "Annual"],
                responsive: [
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200,
                            },
                            legend: {
                                position: "bottom",
                            },
                        },
                    },
                ],
            },
            disabled: false,
            timeout: null,
            is_update: "No",

            att_id: "",
            emp_id: "",
            emp_code: "",
            emp_name: "",
            check_in: "08:00",
            check_out: "18:00",
            locations: {},
            designations: {},
            departments: {},
            UnMarked: "",
            keyword1: "",
            keyword2: "",

            //
            tas: "Pending",
            details: {},

            Reason: "",
            options0: [],
            find_emp: {},
            empa_code1: "",
        };
    },
    components: {
        apexchart: VueApexCharts,
        topBar,
    },
    methods: {
        getResults2(page = 1) {
            axios.get('./attendance_detail/?page=' + page, {params: {keyword2: this.keyword2}})
                .then(response => this.adsdata = response.data.data)
                .catch(error => {
                    this.$toastr.e('error Occur while getting attendence details');
                });
                    },
        isShiftStarted(adsdata1) {
            const currentTime = new Date();
            let openingTime = null;
            let closingTime = null;
            if (adsdata1.OpeningTime && adsdata1.ClosingTime) {
                const openingTimeParts = adsdata1.OpeningTime.split(":");
                const closingTimeParts = adsdata1.ClosingTime.split(":");
                openingTime = new Date();
                openingTime.setHours(parseInt(openingTimeParts[0], 10));
                openingTime.setMinutes(parseInt(openingTimeParts[1], 10));
                closingTime = new Date();
                closingTime.setHours(parseInt(closingTimeParts[0], 10));
                closingTime.setMinutes(parseInt(closingTimeParts[1], 10));
            }
            if (openingTime && closingTime) {
                return currentTime >= openingTime && currentTime <= closingTime;
            } else {
                // Handle the case where either openingTime or closingTime is null
                return false;
            }
        },
    },
    watch: {
        keyword2(after, before) {
            this.timeout = setTimeout(() => {
                this.getResults2();
            }, 1000);
        },
    },
    mounted() {
        this.getResults2();
        axios.get('./count_today_attendance')
            .then(response => {
                this.max = response.data.data.max;
                this.present = response.data.data.pres;
                this.absent = response.data.data.abse;
                this.late = response.data.data.late;
                this.leave = response.data.data.leave;
                this.shiftAwaiting = response.data.data.shiftAwaiting;
                this.UnMarked = response.data.data.UnMarked;
                this.holiday = response.data.data.holiday;
            })

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
            .catch((error) => {
            });



        axios.get('./get_count_leave')
            .then(response => {
                this.series = response.data.data;
            })
            .catch(error => {
                this.$toastr.e('error Occur while getting count leaves');
            });

        axios
            .get("overall_leaves")
            .then((response) => (this.leaves = response.data.data))
            .catch((error) => {});
    },
};
</script>
