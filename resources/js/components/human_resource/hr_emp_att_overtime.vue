 n<template>
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
                                Employees Overtimes
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <topBar :active="active" />
                    <section class="app-user-view-account">
                        <div class="row">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label"
                                            >Department Name
                                            <span
                                                style="
                                                    color: #db4437;
                                                    font-size: 11px;
                                                "
                                                >*</span
                                            ></label
                                        >
                                        <multiselect
                                            placeholder="No department selected"
                                            :show-labels="false"
                                            v-model="department"
                                            :options="options2"
                                        ></multiselect>
                                        <span
                                            style="
                                                color: #db4437;
                                                font-size: 11px;
                                            "
                                            v-if="
                                                department == '' ||
                                                department == null
                                            "
                                            >{{ e_department }}</span
                                        >
                                    </div>
                                    <div class="col-md-2">
                                        <button
                                            @click="get_result()"
                                            style="margin-top: 30px"
                                            class="btn btn-secondary"
                                        >
                                            Search
                                        </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2">
                                        <button v-if="hasPermission('HRMS Attendance Employees-Overtime Approve overtime')"
                                            @click="delay()"
                                            style="margin-top: 30px"
                                            class="btn btn-primary"
                                        >
                                            Approve Overtime
                                        </button>
                                        <button v-else 
                                     
                                            style="margin-top: 30px"
                                            class="btn btn-danger"
                                        >
                                            Approve Overtime
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="table-responsive"
                                    style="overflow-x: initial !important"
                                >
                                    <table class="table table-hover">
                                        <thead class="grid-header">
                                            <tr class="mat-header-row">
                                                <th class="sticky-th-center">
                                                    Employee Name
                                                </th>
                                                <th class="sticky-th-center">
                                                    Department
                                                </th>
                                                <th class="sticky-th-center">
                                                    Check
                                                </th>
                                                <th
                                                    class="sticky-th-center"
                                                    v-for="attandance_header1 in attandance_header"
                                                >
                                                    {{
                                                        attandance_header1.DT.substring(
                                                            8,
                                                            10
                                                        )
                                                    }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-html="get_comp_data"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- END: Content-->
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
            active: "overtime",
            adsdatas: {},
            options2: [],
            department: "",
            e_department: "",
            get_comp_data: {},
            attandance_header: {},
        };
    },
    methods: {
     
        async fetchDepartment() {
            try {
                this.departments = await this.$apihelpers.fetchDepartment();
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
        proced_overtime() {
            var item_name = document.getElementsByName("first[]");
            var added = document.getElementsByName("selected[]");
            var k = "zero";
            var addpurchase = "zero";
            for (var i = 0; i < item_name.length; i++) {
                var a = item_name[i];
                k = k + "|" + a.value;
            }
            for (var g = 0; g < added.length; g++) {
                var fnn = added[g];
                addpurchase = addpurchase + "|" + fnn.checked;
            }
            axios
                .post("submit_Att_Approval", {
                    EmpID: k,
                    added: addpurchase,
                })
                .then((data) => {
                    if (data.data == "submitted") {
                        this.$toastr.s(
                            "Overtimes has been approved successfully!",
                            "Congratulations!"
                        );
                        this.getResult();
                    }
                });
        },
        get_result() {
            if (this.department == "" || this.department == null) {
                this.e_department = "Select department";
                this.$toastr.e("Please select department!", "Congratulations!");
            } else {
                this.e_department = "";
                axios
                    .get("users_overtime/" + this.department)
                    .then((response) => {
                        this.get_comp_data = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        delay() {
            this.disabled1 = true;
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false;
            }, 5000);
            this.proced_overtime();
        },
        delay1() {
            this.timeout1 = setTimeout(() => {
                this.get_result();
            }, 1000);
        },
    },
    mounted() {
        this.fetchDepartment();
        this.fetchRoles();

        axios.get("./get_column_name").then((response) => {
            this.attandance_header = response.data;
        });

        axios
            .get("./session_check")
            .then((response) => {
                this.department = response.data.dept;
            })
            .catch((error) => console.log(error));

        this.delay1();
    },
};
</script>
