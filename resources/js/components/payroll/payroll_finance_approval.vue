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
                                    Financial Approval
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
                                                <span class="fw-bold">Generated Salaries<span class="red-dot"
                                                                                              v-if="salary_state.gen === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_hr_approval" class="nav-link">
                                                <i class="fa-solid fa-address-card"></i>
                                                <span class="fw-bold">HR Approval<span class="red-dot"
                                                                                       v-if="salary_state.hr === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/payroll_finance_approval" class="nav-link active">
                                                <i class="fa-solid fa-coins"></i>
                                                <span class="fw-bold">Finance Approval<span class="red-dot"
                                                                                            v-if="salary_state.fin === true"></span></span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/distribution" class="nav-link">
                                                <i class="fa-solid fa-money-bill-wave"></i><span class="fw-bold">Distribution<span
                                                class="red-dot" v-if="salary_state.dis === true"></span></span>
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
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <h5 style="padding-left:10px;padding-top:10px">Session: {{ session_name }}</h5>
                                    </div>

                                    <div class="col-md-auto col-12 mb-2 position-relative" v-if="hasPermission('Payroll Apply Inst and Fines')  && hasPermission('Payroll Apply Arrears and Allow') ">
                                        <button v-if="toggle"  class="btn btn-primary" style="min-width: 120px;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></button>
                                        <button @click="applydeductions()" class="btn btn-primary">Apply Inst.& Fine</button>
                                        <button @click="applyarrears()" class="btn btn-primary">Apply Arrears & Allow.</button>
                                    </div>
                                    <div class="col-md-auto col-12 mb-2 position-relative" v-else>
                                        <button class="btn btn-danger">Apply Deductions</button>
                                        <button class="btn btn-danger">Apply Incentives</button>
                                    </div>
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <input type="text" v-model="keyword1" class="form-control"
                                               placeholder="Search By Name or Employee code">
                                    </div>
                                    <div class="col-md-auto col-12 mb-2 position-relative" v-if="hasPermission('Payroll Proceed for distribution') ">
                                        <button v-if="toggle"  class="btn btn-primary" style="min-width: 120px;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></button>
                                        <button v-else data-bs-toggle="modal" data-bs-target="#hireinterview" class="btn btn-primary">Proceed for distribution</button>
                                    </div>
                                    <div class="col-md-auto col-12 mb-2 position-relative" v-else>
                                        <button class="btn btn-danger">Proceed for distribution</button>
                                    </div>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="sticky-th-center">Emp. Code<br/>Status</th>
                                            <th class="sticky-th-left">Employee Detail</th>
                                            <th class="sticky-th-center">Att. Detail</th>
                                            <th class="sticky-th-center">Pending Dues</th>
                                            <th class="sticky-th-center">Arrears &<br/>Allowance</th>
                                            <th class="sticky-th-center">Payable Salary</th>
                                            <th class="sticky-th-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="all_sals1 in all_sals.data"
                                            :class="[all_sals1.FStatus=='H' ? 'table-danger' : '']">
                                            <td class="td-center fw-bold">
                                                {{ all_sals1.EmployeeCode }}<br/>
                                                {{ all_sals1.SessionName }}<br/>
                                                <span
                                                    :class="[all_sals1.FStatus=='P' ? 'text-success fw-bold' : '', all_sals1.FStatus=='H' ? 'text-danger fw-bold' : '']">{{ all_sals1.FStatus }}</span>
                                            </td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar  me-1">
                                                            <img v-if="all_sals1.Photo=='' || all_sals1.Photo==null"
                                                                 src="public/images/profile_images/pro.png" alt="Avatar"
                                                                 height="32" width="32">
                                                            <img v-else
                                                                 v-bind:src="`public/images/profile_images/${all_sals1.Photo}`"
                                                                 alt="Avatar" height="32" width="32">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body"><span
                                                            class="fw-bolder">{{ all_sals1.Name }} </span></a><small
                                                        class="emp_post text-muted">
                                                        <span
                                                            v-if="all_sals1.Department!=null">{{ all_sals1.Department }} - </span>
                                                        <span v-else></span>
                                                        <span
                                                            v-if="all_sals1.Designation!=null">{{ all_sals1.Designation }}</span>
                                                        <span v-else></span>
                                                    </small>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-left: 12%;">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            <strong>
                                                                Salary:
                                                            </strong> {{ all_sals1.Salary }}/-
                                                        </div>
                                                        <div>
                                                            <span><strong>Stipend:</strong>{{ Math.round(all_sals1.StipendAmount) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">
                                                <div class="row" style="">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            <span><strong>Overtime:</strong>  {{ Math.round(all_sals1.OAmount) }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Deduction:</strong>{{ Math.round(all_sals1.DAmount) }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Fine:</strong>  {{ all_sals1.Fine }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">
                                                <div class="row" style="">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            <span><strong>Installment:</strong>  {{ all_sals1.InstallmentAmount }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Dues:</strong> {{ all_sals1.DuesAmount }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Advance:</strong>  {{ all_sals1.AdvanceAmount }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Tax:</strong>  {{ all_sals1.TaxAmount }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">
                                                <div class="row" style="">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            <span><strong>Arrears:</strong> {{ all_sals1.ArrearsAmount }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Bonus:</strong> {{ all_sals1.BonusAmount }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Allowance:</strong> {{ all_sals1.AllowanceAmount }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Fuel Amount:</strong>{{ Math.round(all_sals1.FuelAmount) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-center">
                                                <div class="row" style="">
                                                    <div class="mt-display-flex">
                                                        <div>
                                                            <span> {{ all_sals1.PayableSalary }}/-</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Payment Type:</strong> {{ all_sals1.MethodType }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Cash Payable:</strong>{{ Math.round(all_sals1.CashPayable) }}</span>
                                                        </div>
                                                        <div>
                                                            <span><strong>Bank Payable:</strong>{{ Math.round(all_sals1.BankPayable) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td v-if="hasPermission('Payroll Update Employee Salary') ">
                                                    <a @click="fetch_emp_payroll(all_sals1.FinanceApprovalID)" data-bs-toggle="modal" data-bs-target="#update_hr_approval"><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
                                                <td v-else>
                                                    <a><i style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center; padding-top:20px">
                                    <pagination v-if="pageNo==1" :limit="limit" :data="all_sals"
                                                @pagination-change-page="getResult"></pagination>
                                    <pagination v-if="pageNo==2" :limit="limit" :data="all_sals"
                                                @pagination-change-page="getResults"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal table -->
                    <div class="modal fade" id="hireinterview" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="fw-bolder">Confirmation</h1>
                                        <h5>Do you want to move employees salaries for Distribution?</h5>
                                        <div class="text-center" style="text-align:center">
                                            <button type="button" @click="proceedtodistributionapproval()"
                                                    class="btn btn-primary waves-effect waves-float waves-light"
                                                    data-bs-dismiss="modal" aria-label="Close">Yes
                                            </button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect"
                                                    data-bs-dismiss="modal" aria-label="Close">No
                                            </button>
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
                                    <h5>Update Employee Salary</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditUserCode">Employee Code</label>
                                            <input type="text" class="form-control" v-model="m_ApprovalID" hidden/>
                                            <input type="text" readonly class="form-control" v-model="m_emp_code"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label"> Name</label>
                                            <input type="text" class="form-control" readonly v-model="m_name"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">Total Payable Salary</label>
                                            <input type="text" class="form-control" readonly v-model="m_salarypayable"/>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">
                                                Bank Payable <label
                                                v-if="Number(m_bankpayable)+Number(m_cashpayable) == this.m_salarypayable"><i
                                                class="fa-regular fa-circle-check text-success"></i></label><label
                                                v-else><i class="fa-regular fa-circle-xmark text-danger"></i></label>
                                            </label>
                                            <input type="text" class="form-control" v-model="m_bankpayable"/>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">
                                                Cash Payable <label
                                                v-if="Number(m_bankpayable)+Number(m_cashpayable) == this.m_salarypayable"><i
                                                class="fa-regular fa-circle-check text-success"></i></label><label
                                                v-else><i class="fa-regular fa-circle-xmark text-danger"></i></label>
                                            </label>
                                            <input type="text" class="form-control" v-model="m_cashpayable"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label" for="modalEditOvertime">Salary Status</label>
                                            <div class="demo-inline-spacing">
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio"
                                                           v-model="m_salary_status" name="inlineRadioOptions"
                                                           checked="checked" id="inlineRadio1" value="P">
                                                    <label class="form-check-label" for="inlineRadio1">Proceed</label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio"
                                                           v-model="m_salary_status" name="inlineRadioOptions"
                                                           id="inlineRadio2" value="H">
                                                    <label class="form-check-label">Hold</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button
                                                v-if="Number(m_bankpayable)+Number(m_cashpayable) != Number(m_salarypayable)"
                                                type="submit" @click="update_emp_payroll()"
                                                class="btn btn-primary me-1">Update
                                            </button>
                                            <button v-else type="submit" @click="update_emp_payroll()"
                                                    class="btn btn-primary me-1" data-bs-dismiss="modal"
                                                    aria-label="Close">Update
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
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
            limit: 10,
            m_salarypayable: '',
            m_bankpayable: '',
            m_cashpayable: '',

            all_sals: {},
            find_emp: {},
            designations: {},
            departments: {},
            emp_id: 'All',
            designation: 'All',
            department: 'All',
            toggle: false,
            status: 'All',
            keyword1: '',
            session_name: '',
            m_emp_id: '',
            m_name: '',
            pageNo: 1,
            m_emp_code: '',
            m_ApprovalID: '',
            m_salary_status: '',
            salary_state: {},
            user_session: {},
            user_access: {},
            user_accounts_access: {},
        }
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    methods: {
        applydeductions() {
            axios.get('chech_installments/')
                .then(data => {
                    this.getResults();
                    this.$toastr.s("Applied Installment & Fines to All Employees!", "Congratulations");
                })
                .catch(error => {
                });
        },
        applyarrears() {
            axios.get('allowance_arrears')
                .then(data => {
                    if (data.data == 'salaries updated') {
                        this.getResults();
                        this.$toastr.s("Applied Arrears & Allowance to All Salaries!", "Congratulations!");
                    } else {
                        this.$toastr.s("Salaries not updated!", "Error!");
                    }
                })
                .catch(error => {
                });
        },
        fetch_emp_payroll(id) {
            axios.get('find_payroll_emp_financeapproval/' + id)
                .then(data => {
                    this.m_emp_id = data.data[0].EmployeeID;
                    this.m_emp_code = data.data[0].EmployeeCode;
                    this.m_name = data.data[0].Name;
                    this.m_ApprovalID = data.data[0].FinanceApprovalID;
                    this.m_salary_status = data.data[0].FStatus;
                    this.m_salarypayable = data.data[0].PayableSalary;
                    this.m_bankpayable = data.data[0].BankPayable;
                    this.m_cashpayable = data.data[0].CashPayable;
                })
                .catch(error => {
                });
        },
        proceedtodistributionapproval() {
            this.toggle = true;

            Promise.all([this.applydeductions(), this.applyarrears()])
                .then(() => {
                    axios.get('./proceeddistapproval')
                        .then(response => {
                            if(response.data == 'salaries moved'){
                                this.toggle = false;
                                this.$toastr.s("Proceed Payroll to Distribution Successfully!", "Congratulations!");
                            }
                        })
                        .catch(error => {
                            this.toggle = false;
                            if (error.response.data.message == 'No Field') {
                                this.$toastr.s("Proceed Payroll to Distribution Successfully!", "Congratulations!");
                            }
                        });
                })
                .catch(error => {

                });
        },
        update_emp_payroll() {
            if (Number(this.m_bankpayable) + Number(this.m_cashpayable) != Number(this.m_salarypayable)) {
                this.$toastr.e("Payables are not matching with total payable salary!", "Error!");
            } else {
                axios.post('update_payroll_ind_status_financeapproval', {
                    m_ApprovalID: this.m_ApprovalID,
                    m_salary_status: this.m_salary_status,
                    m_name: this.m_name,
                    m_bankpayable: this.m_bankpayable,
                    m_cashpayable: this.m_cashpayable,
                })
                    .then(data => {
                        this.getResult();
                        this.$toastr.s("Updated Employee Salary Detail Successfully!", "Congratulations");
                        this.m_emp_id = '';
                        this.m_emp_code = '';
                        this.m_name = '';
                        this.m_ApprovalID = '';
                        this.m_salary_status = '';
                        this.m_salarypayable = '';
                        this.m_bankpayable = '';
                        this.m_cashpayable = '';
                    })
            }
        },
        getResults(page = 1) {
            if (this.keyword1 == null || this.keyword1 == '') {
                this.getResult()
            }
            axios.get('./search_finance_approval' + '?page=' + page, {params: {keyword1: this.keyword1}})
                .then(response => {
                    this.pageNo = 2
                    this.all_sals = response.data
                })
                .catch(error => console.log(error));

            axios.get('find_emp_id')
                .then(data => this.find_emp = data.data.data)
                .catch(error => { });

            axios.get('department_detail2')
                .then(data => this.departments = data.data)
                .catch(error => { });

            axios.get('overall_designation')
                .then(response => {this.designations = response.data})

            axios.get('session_pre_dis')
                .then(response => this.session_name = response.data)

        

         

        },
        getResult(page = 1) {
            axios.get('fetchall_finance_approval' + '?page=' + page)
                .then(response => {
                    this.pageNo = 1
                    this.all_sals = response.data.data
                })
                .catch(error => console.log(error));

            axios.get('salary_state')
                .then(data => this.salary_state = data.data)
                .catch(error => {
                });
        }
    },
    mounted() {
        this.getResults()

        axios.get('find_emp_id')
            .then(data => this.find_emp = data.data.data)
            .catch(error => {
            });

        axios.get('department_detail2')
            .then(data => this.departments = data.data)
            .catch(error => {
            });

        axios.get('overall_designation')
            .then(response => {
                this.designations = response.data
            })

        axios.get('session_pre_dis')
            .then(response => this.session_name = response.data)

        axios.get('./user_session')
            .then(response => this.user_session = response.data)

        axios.get('./fetch_user_payroll_roles')
            .then(response => this.user_access = response.data)

        axios.get('./fetch_user_accounts_roles')
            .then(response => this.user_accounts_access = response.data)
    },

}

</script>
<style scoped>
.lds-ring {
    display: inline-block;
    position: relative;
    width: 20px;
    height: 12px;
}

.lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 25px;
    height: 25px;
    border: 8px solid #fff;
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: black transparent transparent transparent;
}

.lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
}

.lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
}

.lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
}

@keyframes lds-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

</style>
