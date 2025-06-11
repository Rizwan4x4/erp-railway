<template>
 <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/payroll" style="text-decoration: none;">
                                        Payroll Dashboard
                                    </router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    HR Salary Generation
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary" style="padding-top:0px;padding-bottom:0px" role="alert">
                                <div class="alert-body">
                                    <ul class="nav nav-pills mb-2">
                                        <li  class="nav-item">
                                            <router-link to="/payroll/salary_generation" class="nav-link active">
                                                <i class="fa-solid fa-cash-register"></i>
                                                <span class="fw-bold">Generated Salaries<span class="red-dot" v-if="salary_state.gen === true"></span></span>

                                            </router-link>
                                        </li>
                                        <span title="You are online" class="avatar-status-online"></span>
                                        <li v-if="hasPermission('Payroll HR Approval')" class="nav-item">
                                            <router-link to="/payroll/payroll_hr_approval" class="nav-link">
                                                <i class="fa-solid fa-address-card"></i>
                                                <span class="fw-bold">HR Approval<span  v-if="salary_state.hr === true" class="red-dot"></span></span>
                                            </router-link>
                                        </li>
                                        <li  v-if="hasPermission('Payroll Finance Approval')"  class="nav-item">
                                            <router-link to="/payroll/payroll_finance_approval" class="nav-link">
                                                <i class="fa-solid fa-coins"></i>
                                                <span class="fw-bold">Finance Approval<span  v-if="salary_state.fin === true" class="red-dot"></span></span>
                                            </router-link>
                                        </li>
                                        <li  v-if="hasPermission('Payroll Salary Distribution')" class="nav-item">
                                            <router-link to="/payroll/distribution" class="nav-link">
                                                <i class="fa-solid fa-money-bill-wave"></i><span class="fw-bold">Distribution<span v-if="salary_state.dis === true" class="red-dot"></span></span>
                                            </router-link>
                                        </li>
                                        <li v-if="hasPermission('Payroll Pending Salaries')"  class="nav-item">
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
                                        <input type="text" v-model="keyword1" class="form-control" placeholder="Search By Emp. Name / Code">
                                    </div>
                                    <div v-if="hasPermission('Payroll Proceed to HR approval')  " class="col-md-3">
                                        <button :disabled="disabled1" @click="delay1()" data-bs-toggle="modal" data-bs-target="#hireinterview" class="btn btn-primary">Proceed for HR Approval </button>
                                    </div>
                                    <div  v-else class="col-md-3">
                                        <button disabled class="btn btn-danger">Proceed for HR Approval</button>
                                    </div>
<!--                                    <div class="col-md-2">-->
<!--                                        <router-link style="margin-left: 10px;" to="/payroll/employees_detail" class="btn btn-primary waves-effect" type="button">Salaries Detail</router-link>-->
<!--                                    </div>-->
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="sticky-th-center">Emp. Code<br />Status</th>
                                                <th class="sticky-th-left">Employee Name</th>
                                                <th class="sticky-th-center">Session</th>
                                                <th class="sticky-th-center">T. Days</th>
                                                <th class="sticky-th-center"> P </th>
                                                <th class="sticky-th-center"> A </th>
                                                <th class="sticky-th-center">Att. <br/>Ded.</th>
                                                <th class="sticky-th-center">OT</th>
                                                <th class="sticky-th-center">B. Salary</th>
                                                <th class="sticky-th-center">Ded.<br />Amt.</th>
                                                <th class="sticky-th-center">OT<br />Amt.</th>
                                                <th class="sticky-th-center">Total<br /> Payable</th>
                                                <th class="sticky-th-center" title='This deduction will be take place at "Finance Approval" step.'>Loan<br>Advance</th>
                                                <th class="sticky-th-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="all_sals1 in all_sals.data" :class="[all_sals1.DStatus=='H' ? 'table-danger' : '']">
                                                <td class="td-center">{{all_sals1.EmployeeCode}}<br /><span :class="[all_sals1.DStatus=='P' ? 'text-success fw-bold' : '', all_sals1.DStatus=='H' ? 'text-danger fw-bold' : '']">{{all_sals1.DStatus}}</span></td>
                                                <td class="td_left">
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{all_sals1.Name}} </span></a><small class="emp_post text-muted">
                                                            {{all_sals1.Department}}-{{all_sals1.Designation}}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td class="td-center">{{all_sals1.SessionName}}</td>
                                                <td class="td-center">{{all_sals1.Totaldays}}</td>
                                                <td class="td-center">{{all_sals1.TotalPeresnt}}</td>
                                                <td class="td-center">{{all_sals1.TotalAbsent}}</td>
                                                <td class="td-center">{{Math.floor(all_sals1.Deduction).toLocaleString()}}</td>
                                                <td class="td-center">{{all_sals1.OverTime}}</td>
                                                <td class="td-center">{{Math.floor(all_sals1.Salary).toLocaleString()}}</td>
                                                <td class="td-center">{{Math.floor(all_sals1.DAmount).toLocaleString()}}</td>
                                                <td class="td-center">{{Math.floor(all_sals1.OAmount).toLocaleString()}}</td>
                                                <td class="td-center">{{Math.floor(all_sals1.TAmount).toLocaleString()}}</td>
                                                <td title='This deduction will be take place at "Finance Approval" step.' class="td-center">
                                                    {{Math.floor(all_sals1.loanAmount).toLocaleString()}}<br>
                                                    {{Math.floor(all_sals1.advanceAmount).toLocaleString()}}
                                                </td>
                                                <td class="td-center" v-if="hasPermission('Payroll Add deduction and overtime') ">
                                                    <a @click="fetch_emp_payroll(all_sals1.SessionReportID)" data-bs-toggle="modal" data-bs-target="#editpayroll"><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
                                                <td class="td-center" v-else>
                                                    <a><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
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
                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editpayroll" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h4 class="mb-1">Add deduction and overtime in {{m_name}}'s salary</h4>
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserCode">Employee Code</label>
                                            <input type="text" class="form-control" v-model="m_session_reportID" hidden />
                                            <input type="text" readonly class="form-control" v-model="m_emp_code" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserName">Employee Name</label>
                                            <input type="text" class="form-control" readonly v-model="m_name" />
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditDeduction">Deduction (Days) <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <input v-if="m_salary_status=='P'" type="number" class="form-control" v-model="m_deduction" placeholder="In Days" />
                                            <input v-else readonly type="number" class="form-control" v-model="m_deduction" placeholder="In Days" />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="m_deduction==''">{{e_m_deduction}}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="modalEditOvertime">Overtime (Minuts)</label>
                                            <input type="number" class="form-control " v-model="m_overtime" placeholder="In minuts" readonly />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="modalEditOvertime">Overtime (Hours) <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                            <input v-if="m_salary_status=='P'" type="number" class="form-control " v-model="h_overtime" placeholder="In hours" />
                                            <input v-else readonly type="number" class="form-control" v-model="h_overtime"/>
                                            <span style="color: #DB4437; font-size: 11px;" v-if="!h_overtime || h_overtime < 0">{{e_m_overtime}}</span>
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
                                            <button v-if="!m_deduction || !h_overtime || h_overtime < 0 " :disabled="disabled" @click="delay()" class="btn btn-danger">Update</button>
                                            <button v-else type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Edit User Modal -->
                    <div class="modal fade" id="hireinterview" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            np
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation!</h1>
                                        <h5>Do you want to move employees salaries for HR Approval?</h5>
                                        <div class="text-center">
                                            <button type="button" @click="proceedtohrapproval()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
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
                h_overtime: '',
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
                m_deduction: '',
                e_m_deduction: '',
                m_overtime: '',
                e_m_overtime: '',
                m_emp_code: '',
                m_session_reportID: '',
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
            },
            h_overtime(after, before) {
                this.get_m_overtime();
            }
        },
        methods: {

            myCustomMethod() {
      // Access the hasPermission function from this.$helpers
      const hasPermission = this.$helpers.hasPermission('Payroll Salary Processsing');

      // Use the hasPermission result in your method logic
      if (hasPermission) {
        // Perform actions when the user has the permission
        console.log('User has permission to apply inst and fines');
      } else {
        // Handle actions when the user doesn't have the permission
        console.log('User does not have permission to apply inst and fines');
      }
    },
            get_m_overtime() {
                this.m_overtime = Number(this.h_overtime) * 60;
            },
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
            proceedtohrapproval() {
                axios.get('./proceedhrapproval')
                    .then(response => {
                        if(response.data=='Salaries proceded'){
                            //this.all_sals = response.data;
                            this.$toastr.s("Salaries proceded for HR Approval Successfully!", "Congratulations");
                            //this.$router.go(0);
                            this.getResults();

                            axios.get('salary_state')
                                .then(data => this.salary_state = data.data)
                                .catch(error => { });
                        }
                    })
                    .catch(error => console.log(error));
            },
            update_emp_payroll() {
                if (!this.m_deduction || !this.h_overtime || this.h_overtime < 0) {
                    this.e_m_deduction = !this.m_deduction ? 'Please enter deduction days' : '';
                    this.e_m_overtime = !this.h_overtime ? 'Please enter OT hours' : this.h_overtime < 0 ? 'OT could not be negative' : '';

                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    this.e_m_deduction = '';
                    this.e_m_overtime = '';
                    axios.post('update_payroll_ind_status', {
                        m_session_reportID: this.m_session_reportID,
                        m_deduction: this.m_deduction,
                        m_overtime: this.m_overtime,
                        m_salary_status: this.m_salary_status,
                    })
                        .then(response => {
                            const existingRecordIndex = this.all_sals.data.findIndex(record => record.SessionReportID === this.m_session_reportID);
console.log(existingRecordIndex)
                            if (existingRecordIndex !== -1) {
        // If the record exists, update the specific values
        this.all_sals.data[existingRecordIndex].Deduction = this.m_deduction;
        this.all_sals.data[existingRecordIndex].OverTime = this.m_overtime;
        this.all_sals.data[existingRecordIndex].DStatus = this.m_salary_status;
    } else {
        // If the record doesn't exist, add the new record to the array
        // this.all_sals.data.push(response.data);
    }
                            this.$toastr.s("Employee Salary Details Updated Successfully!", "Congratulations!");
                            // this.getResults();

                            axios.get('salary_state')
                                .then(data => this.salary_state = data.data)
                                .catch(error => { });

                        })
                }
            },
            getResults(page = 1) {
                axios.get('./search_payroll' + '?page=' + page, { params: { keyword1: this.keyword1 } })
                    .then(response => {
                        this.all_sals = response.data;
                    })
                    .catch(error => console.log(error));
            },
            fetch_emp_payroll(id) {
                axios.get('find_payroll_emp/' + id)
                    .then(data => {
                        this.m_emp_id = data.data[0].EmployeeID;
                        this.m_emp_code = data.data[0].EmployeeCode;
                        this.m_name = data.data[0].Name;
                        this.m_deduction = (Number(data.data[0].Deduction)).toString();
                        this.m_overtime = data.data[0].OverTime;
                        this.h_overtime = (Number(this.m_overtime) / 60).toString();
                        this.m_session_reportID = data.data[0].SessionReportID
                        this.m_salary_status = data.data[0].DStatus
                    })
                    .catch(error => { });
            },
        },
        mounted() {
            this.myCustomMethod();
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

<style>
.red-dot {
    position: absolute;
    top: 20px;
    width: 5px;
    height: 5px;
    background-color: red;
    border-radius: 50%;
}
</style>
