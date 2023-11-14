<template>
    <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    HR Approval
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body">
                                    <ul class="nav nav-pills mb-2">
                                        <li class="nav-item">
                                            <router-link to="/payroll/salary_generation" class="nav-link">
                                                <i class="fa-solid fa-cash-register"></i>
                                                <span class="fw-bold">Generated Salaries<span class="red-dot" v-if="salary_state.gen === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_hr_approval" class="nav-link active">
                                                <i class="fa-solid fa-address-card"></i>
                                                <span class="fw-bold">HR Approval<span class="red-dot" v-if="salary_state.hr === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_finance_approval" class="nav-link">
                                                <i class="fa-solid fa-coins"></i>
                                                <span class="fw-bold">Finance Approval<span class="red-dot" v-if="salary_state.fin === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/distribution" class="nav-link">
                                                <i class="fa-solid fa-money-bill-wave"></i><span class="fw-bold">Distribution<span class="red-dot" v-if="salary_state.dis === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" to="/payroll/payroll_pending_salaries">
                                                <i class="fa-solid fa-rotate-left"></i><span class="fw-bold">Pending Salaries</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="basic-table">
                        <div class="col-12">
                            <div class="card">
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-5">
                                        <h5 style="padding-left:10px;padding-top:10px">Session: {{session_name}}</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" v-model="keyword1" class="form-control" placeholder="Search By Name or Employee code">
                                    </div>
                                    <div v-if="hasPermission('Payroll Proceed to Finance Approval')" class="col-md-3">
                                        <button :disabled="disabled1" @click="delay1()" data-bs-toggle="modal" data-bs-target="#apprfinance" class="btn btn-primary">Proceed to Finance Approval</button>
                                    </div>
                                    <div v-else class="col-md-3">
                                        <button class="btn btn-primary">Proceed to Finance Approval </button>
                                    </div>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="sticky-th-center">Emp. Code<br />Status</th>
                                                <th class="sticky-th-left">Employee Name</th>
                                                <th class="sticky-th-center">Session<br />Name</th>
                                                <th class="sticky-th-center">Ded.</th>
                                                <th class="sticky-th-center">O.T</th>
                                                <th class="sticky-th-center">B. Salary</th>
                                                <th class="sticky-th-center">Ded. Amt.</th>
                                                <th class="sticky-th-center">OT Amt.</th>
                                                <th class="sticky-th-center">Total<br />Payable</th>
                                                <th class="sticky-th-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in all_sals.data" :class="[all_sals1.HrStatus=='H' ? 'table-danger' : '']">
                                                <td class="td-center">{{all_sals1.EmployeeCode}}<br /><span :class="[all_sals1.HrStatus=='P' ? 'text-success fw-bold' : '', all_sals1.HrStatus=='H' ? 'text-danger fw-bold' : '']">{{all_sals1.HrStatus}}</span></td>
                                                <td class="td-left">
                                                    <div class="d-flex justify-content-left align-items-center">
                                                        <div class="avatar-wrapper">
                                                            <div class="avatar  me-1">
                                                                <img v-if="all_sals1.Photo=='' || all_sals1.Photo==null" src="public/images/profile_images/pro.png" alt="Avatar" height="32" width="32">
                                                                <img v-else v-bind:src="`public/images/profile_images/${all_sals1.Photo}`" alt="Avatar" height="32" width="32">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals1.Name}} </span></a><small class="emp_post text-muted">
                                                                <span v-if="all_sals1.Department!=null">{{all_sals1.Department}} - </span>
                                                                <span v-else></span>
                                                                <span v-if="all_sals1.Designation!=null">{{all_sals1.Designation}}</span>
                                                                <span v-else></span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="td-center">{{all_sals1.SessionName}}</td>
                                                <td class="td-center">{{Math.abs(all_sals1.Deduction)}}</td>
                                                <td class="td-center">{{all_sals1.OverTime}}</td>
                                                <td class="td-center">{{all_sals1.Salary}}</td>
                                                <td class="td-center">{{Math.round(all_sals1.DAmount)}}</td>
                                                <td class="td-center">{{Math.round(all_sals1.OAmount)}}</td>
                                                <td class="td-center">{{all_sals1.TAmount}}</td>
                                                <td class="td-center" >
                                                    <a @click="fetch_emp_payroll(all_sals1.ApprovalID)" data-bs-toggle="modal" data-bs-target="#update_hr_approval"><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
                                                <!-- <td class="td-center" v-else>
                                                    <a><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center; padding-top:20px">
                                    <pagination :limit="limit" :data="all_sals" @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal table -->
                    <div class="modal fade" id="apprfinance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Do you want to proceed employees salaries for Finance Approval?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" @click="proceedtofinanceapproval()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="update_hr_approval" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Update Employee Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserCode">Employee Code</label>
                                            <input type="text" class="form-control" v-model="m_ApprovalID" hidden />
                                            <input type="text" readonly class="form-control" v-model="m_emp_code" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserName"> Name</label>
                                            <input type="text" class="form-control" readonly v-model="m_name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditOvertime">Salary Status</label>
                                            <div class="demo-inline-spacing">
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="m_salary_status" name="inlineRadioOptions" checked="checked" id="inlineRadio1" value="P">
                                                    <label class="form-check-label" for="inlineRadio1">Proceed</label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="m_salary_status" name="inlineRadioOptions" id="inlineRadio2" value="H">
                                                    <label class="form-check-label" for="inlineRadio2">Hold</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Discard
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
    </div>
</template>
<script>
    import axios from "axios";
    export default {
        data() {
            return {
                limit:10,
                salary_state: {},
                all_sals: {},
                find_emp: {},
                designations: {},
                departments: {},
                emp_id: 'All',
                designation: 'All',
                department: 'All',
                status: 'All',
                keyword1: '',
                session_name: '',
                m_emp_id: '',
                m_name: '',

                m_emp_code: '',
                m_ApprovalID: '',
                m_salary_status: '',

                disabled: false,
                timeout: null,

                disabled1: false,
                timeout1: null,
            }
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        methods: {
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_emp_payroll()
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)

            },
            fetch_emp_payroll(id) {
                axios.get('find_payroll_emp_hrapproval/' + id)
                    .then(data => {
                        this.m_emp_id = data.data[0].EmployeeID;
                        this.m_emp_code = data.data[0].EmployeeCode;
                        this.m_name = data.data[0].Name;
                        this.m_ApprovalID = data.data[0].ApprovalID
                        this.m_salary_status = data.data[0].HrStatus
                    })
                    .catch(error => { });
            },
            proceedtofinanceapproval() {
                axios.get('./proceedfinanceapproval')
                    .then(response => {
                        this.getResults();
                        this.$toastr.s("Proceed Payroll to HR Approval Successfully!", "Congratulations");
                    })
                    .catch(error => console.log(error));
            },
            update_emp_payroll() {
                axios.post('update_payroll_ind_status_hrapproval', {
                    m_ApprovalID: this.m_ApprovalID,
                    m_salary_status: this.m_salary_status,
                    m_name: this.m_name,
                })
                    .then(data => {
                        if (data.data == 'Status updated') {
                            this.getResults();
                            this.$toastr.s("Employee Salary Detail Updated Successfully!", "Congratulations!");
                        }
                        else {
                            this.$toastr.e("Employee Salary Detail Not Updated!", "Caution!");
                        }
                    })
            },
            getResults(page = 1) {
                axios.get('./search_hr_approval' + '?page=' + page, { params: { keyword1: this.keyword1 } })
                    .then(response => this.all_sals = response.data)
                    .catch(error => console.log(error));

                axios.get('salary_state')
                    .then(data => this.salary_state = data.data)
                    .catch(error => { });
            },
        },
        mounted() {
            this.getResults();

            axios.get('find_emp_id')
                .then(data => this.find_emp = data.data.data)
                .catch(error => { });

            axios.get('department_detail2')
                .then(data => this.departments = data.data)
                .catch(error => { });

            axios.get('overall_designation')
                .then(response => {
                    this.designations = response.data;
                })

            axios.get('session_pre_dis')
                .then(response => {
                    this.session_name = response.data;
                })

          

        },

    }

</script>
