<template>
    <div >
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/hr/employees_detail" style="text-decoration: none;">Employees Detail
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Employement details 1
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                <div class="row"
                                     style="border: 1px solid lightgrey;padding-top:20px;padding-bottom:10px">
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label" for="accountEmail">Employee Code</label>
                                        <input type="text" class="form-control" id="accountEmail" readonly=""
                                               v-model="emp_code" placeholder="">
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label" for="accountEmail">Salary</label>
                                        <input v-if="!this.emp_salary9 || this.emp_salary9==0" type="number"
                                               class="form-control" v-model="emp_salary">
                                        <input v-else readonly type="number" class="form-control" v-model="emp_salary">
                                    </div>

                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Reporting To <label
                                            style="color: #d93025">*</label></label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     placeholder="Select Employee" v-model="reporting_to" value="id"
                                                     label="label"
                                                     :options="options7"></multiselect>
                                        <label style="color: #d93025"
                                               v-if="!reporting_to">{{ e_reporting_to }}</label>
                                        <label class="text-danger"
                                               v-if="reporting_to && reporting_to == second_reporting">Please Select
                                            Different Reporting Persons</label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Secondary Reporting</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     value="id" label="label"
                                                     placeholder="Select Employee" v-model="second_reporting"
                                                     :options="options7"></multiselect>
                                    </div>

                                    <div class="col-md-4 col-sm-4 mb-1">
                                        <label class="form-label">Currency <label
                                            style="color: #d93025">*</label></label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     placeholder="Select Currency" v-model="selectedCurrency"
                                                     :options="currencyNames"></multiselect>
                                        <label style="color: #d93025"
                                               v-if="!selectedCurrency">{{ e_selectedCurrency }}</label>
                                        <!-- <label style="color: red" v-if="selectedCurrency && selectedCurrency === secondReporting">Please select a different currency</label> -->
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Job Shift</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     id="accountPhoneNumber" placeholder="Select Shift"
                                                     v-model="job_shift" :options="options4"></multiselect>
                                        <label style="color: #d93025" v-if="!job_shift">{{ e_job_shift }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Work Location</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px;"
                                                     placeholder="Select Location" v-model="work_location"
                                                     :options="options1"></multiselect>
                                        <label style="color: #d93025"
                                               v-if="!work_location">{{ e_work_location }}</label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Company Email Id</label>
                                        <input type="email" class="form-control" v-model="company_email_id"
                                               placeholder="Provided by company">
                                        <span style="color: #d93025"
                                              v-if="company_email_id && !validEmail(company_email_id)">{{
                                                e_company_email_id
                                            }}</span>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label">Employee Status <label
                                            style="color: #d93025">*</label></label>
                                        <select class="form-select" v-model="emp_status">
                                            <option value=''>Select Status</option>
                                            <option value='Registered'>Registered</option>
                                            <option value='Resigned'>Resigned</option>
                                            <option value='Suspended'>Suspended</option>
                                            <option value='Terminated'>Terminated</option>
                                        </select>
                                        <label style="color: #d93025" v-if="!emp_status">{{ e_emp_status }}</label>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label">Attendance machine<label
                                            style="color: #d93025">*</label></label>
                                        <select class="form-select" v-model="emp_att_machine">
                                            <option value=''>Select Machine</option>
                                            <option v-for="attendanceMachine in attendanceMachines" :value='attendanceMachine.Id'>
                                                {{ attendanceMachine.DeviceName }}</option>
                                        </select>
                                        <label style="color: #d93025"
                                               v-if="!emp_job_status">{{ e_emp_job_status }}</label>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label">Job Status <label
                                            style="color: #d93025">*</label></label>
                                        <select class="form-select" v-model="emp_job_status">
                                            <option value=''>Select Status</option>
                                            <option value='Permanent'>Permanent</option>
                                            <option value='Probation'>Probation</option>
                                            <option value='Contract'>Contract</option>
                                        </select>
                                        <label style="color: #d93025"
                                               v-if="!emp_job_status">{{ e_emp_job_status }}</label>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label" for="accountEmail">Date Of Joining <label
                                            style="color: #d93025">*</label></label>
                                        <input type="date" class="form-control" id="accountEmail" v-model="doj">
                                        <label style="color: #d93025" v-if="!doj">{{ e_doj }}</label>
                                    </div>
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <label class="form-label">Probation Days <label style="color: #d93025"
                                                                                        v-if="emp_job_status == 'Probation'">*</label></label>
                                        <input type="number" class="form-control account-number-mask"
                                               v-model="emp_pro_days" placeholder="Enter number of days"
                                               v-if="emp_job_status=='Probation'">
                                        <input type="number" disabled class="form-control account-number-mask"
                                               v-model="emp_pro_days" placeholder="No probation days" v-else>
                                        <label style="color: #d93025"
                                               v-if="!emp_pro_days">{{ e_emp_pro_days }}</label>
                                    </div>
                                    <div class="col-md-2 col-sm-12 mb-1">
                                        <div class="mb-1">
                                            <label class="form-label">Salary Method</label>
                                            <div class="demo-inline-spacing">
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="methodtype"
                                                           name="inlineRadioOptions" id="inlineRadio1" value="Cash"
                                                           checked="">
                                                    <label class="form-check-label" for="inlineRadio1">Cash</label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="methodtype"
                                                           name="inlineRadioOptions" id="inlineRadio2"
                                                           value="Bank Transfer">
                                                    <label class="form-check-label" for="inlineRadio2">Bank
                                                        Transfer</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-12 mb-1 row" v-if="methodtype=='Bank Transfer'">
                                        <div class="col-md-4 col-sm-12 mb-1">
                                            <label class="form-label">Bank Name <label style="color: #d93025">*</label></label>
                                            <input type="text" placeholder="Bank name" class="form-control"
                                                   v-model="bankname"/>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-1">
                                            <label class="form-label">Account Number <label
                                                style="color: #d93025">*</label></label>
                                            <input type="text" placeholder="Bank account number" class="form-control"
                                                   v-model="bankaccount"/>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-1">
                                            <label class="form-label">Account Name <label
                                                style="color: #d93025">*</label></label>
                                            <input type="text" placeholder="Account name" class="form-control"
                                                   v-model="accountname"/>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-12 mb-1" v-else>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-1">
                                        <label class="form-label">Job Description</label>
                                        <label style="color: #d93025">*</label>
                                        <vue-editor style="height:200px;" v-model="job_description"
                                                    placeholder="Add Job Description"></vue-editor>
                                        <div style="height:80px;"></div>
                                        <label style="color: #d93025"
                                               v-if="!job_description">{{ e_job_description }}</label>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-1">
                                        <label class="form-label">Remarks</label>
                                        <vue-editor style="height:200px;" v-model="remarks"
                                                    placeholder="Add Remarks"></vue-editor>
                                        <div style="height:80px;"></div>
                                    </div>
                                </div>
                                <div class="row"
                                     style="border: 1px solid lightgrey;margin-top:20px;padding-top:20px;padding-bottom:20px">
                                    <div class=" col-12 col-sm-12 mb-1card-header"><h4 class="card-title">Department &
                                        Designation</h4></div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Child Company <span
                                            style="color: #d93025">*</span></label>
                                        <multiselect :show-labels="false" @input="get_dept_bycomp()"
                                                     style="margin-right: 10px; font-size: 15px;"
                                                     placeholder="Child Company" v-model="child_company"
                                                     :options="options_child">
                                        </multiselect>
                                        <span style="color: #DB4437; font-size: 11px;"
                                              v-if="!child_company">{{ e_child_company }}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Department</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     id="accountPhoneNumber" placeholder="Select Department"
                                                     v-model="emp_department" :options="options6"></multiselect>
                                        <label style="color: #d93025"
                                               v-if="!emp_department">{{ e_emp_department }}</label><br/>
                                        <label style="color: RED" v-if="!child_company">First
                                            Select Child Company</label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-1">
                                        <label class="form-label">Designation</label>
                                        <multiselect :show-labels="false" style="margin-right: 10px; font-size: 15px;"
                                                     id="accountPhoneNumber" placeholder="Select Designation"
                                                     v-model="emp_designation" :options="options5"></multiselect>
                                        <label style="color: #d93025"
                                               v-if="!emp_designation">{{ e_emp_designation }}</label>
                                    </div>
                                </div>
                                <div class="row"
                                     style="border: 1px solid lightgrey;margin-top:20px;padding-top:20px;padding-bottom:20px">
                                    <table style="margin-left:9px;">
                                        <tr>
                                            <td style="width:130px;">
                                                <label class="form-label" style="font-size:14px;padding-right:20px">Notifications:</label>
                                            </td>
                                            <td>
                                                <input disabled class="form-check-input" type="checkbox"
                                                       v-model="hr_notifications" id="inlineCheckbox2">
                                                <label class="form-check-label" for="inlineCheckbox2">Send email and SMS
                                                    notifications of HR Activities</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="form-label" style="font-size:14px;padding-right:20px">Permissions:</label>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" v-model="att_check"
                                                       id="inlineCheckbox1">
                                                <label class="form-check-label" for="inlineCheckbox1">Allow to other
                                                    employees Punch In & Out from Application</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div v-if="att_check==true" class="row">
                                                    <div class="col-md-12 col-sm-12 mb-1">
                                                        <multiselect :show-labels="false" style="margin-right: 10px;"
                                                                     v-model="selected" :multiple="true"
                                                                     :options="options"></multiselect>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="form-label" style="font-size:14px;padding-right:20px">Portal
                                                    Access:</label>
                                            </td>
                                            <td>
                                                <input class="form-check-input" type="checkbox" v-model="login_check"
                                                       id="inlineCheckbox3" v-bind:disabled="isCheckboxDisabled">
                                                <label class="form-check-label" for="inlineCheckbox3">Login to the
                                                    Application, Employee can login with their eMail and Password to the
                                                    Application</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="col-md-12 col-sm-6 mb-1">
                                                    <div v-if="login_check==true" class="row">
                                                        <div class="col-md-4 col-sm-6 mb-1">
                                                            <label class="form-label" for="accountEmail">User
                                                                Email</label>
                                                            <input type="email" class="form-control" id="accountEmail"
                                                                   v-model="user_email" placeholder="abc@gmail.com">
                                                            <label style="color: #d93025"
                                                                   v-if="!validEmail(user_email)">{{
                                                                    e_user_email
                                                                }}</label>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6 mb-1">
                                                            <label class="form-label">User Password</label>
                                                            <input type="password" class="form-control" id="password"
                                                                   v-model="user_password">
                                                            <label style="color: #d93025"
                                                                   v-if="!user_password">{{
                                                                    e_user_password
                                                                }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <label style="color: #d93025"
                                           v-if="hr_notifications != true && att_check != true && login_check!=true">{{
                                            e_check
                                        }}</label>
                                    <div class="col-12" style="text-align:center">
                                        <button :disabled="disabled" @click="delay()" type="button"
                                                class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">
                                            Update Employee Profile
                                        </button>
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
import axios from 'axios'
import Multiselect from 'vue-multiselect'

export default {
    data() {
        return {
            attendanceMachines:{},
            emp_att_machine:'',
            e_emp_att_machine:'',
            id: this.$route.params.id,
            report1: '',
            report2: '',
            att_emp: {},
            check_reporting: false,
            selected: null,
            designations: {},
            options: [],
            options1: [],
            options4: [],
            options5: [],
            options6: [],
            options7: [],
            emp_data: {},
            employees_detail5: {},
            locations: {},
            employees_detail: {},
            departments: {},
            emp_code: '',
            company_email_id: '',
            e_company_email_id: '',
            doj: '',
            e_doj: '',

            login_check: '',
            m_status: '',
            e_selectedCurrency: '',
            reporting_to: {},
            e_reporting_to: '',

            second_reporting: {},
            job_shift: '',
            e_job_shift: '',

            work_location: '',
            e_work_location: '',

            options_child: [],
            child_company: '',
            e_child_company: '',
            emp_salary: '',
            emp_stipend: '',
            emp_status: '',
            e_emp_status: '',

            emp_job_status: '',
            e_emp_job_status: '',

            emp_pro_days: '',
            e_emp_pro_days: '',

            job_description: '',
            e_job_description: '',

            remarks: '',
            currencyNames: [],
            selectedCurrency: '',
            emp_department: '',
            e_emp_department: '',

            emp_designation: '',
            e_emp_designation: '',

            hr_notifications: '',
            att_check: '',
            e_check: '',

            user_email: '',
            e_user_email: '',

            user_password: '',
            e_user_password: '',
            rosters: {},
            emp_salary9: '',
            methodtype: 'Cash',
            bankaccount: '',
            bankname: '',
            accountname: '',
            child_comlist: {},
            disabled: false,
            timeout: null,
            isCheckboxDisabled: true,

            reporting1Id: '',
            reporting2Id: '',
        }
    },
    components: {Multiselect},
    methods: {
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.submit_employment()
        },
        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        get_dept_bycomp() {
            axios.get("get_dept_bycompany/" + this.child_company)
                .then((response) => {
                    this.departments = response.data
                    this.options6 = [];
                    var $this = this;
                    for (var i = 0; i < $this.departments.length; i++) {
                        this.options6.push($this.departments[i].Department);
                    }
                })
        },
        submit_employment() {
            var isReportingValid = true;
            if (this.second_reporting) {
                isReportingValid = this.second_reporting && this.reporting_to.id !== this.second_reporting.id;
            }
            if(this.emp_job_status == 'Probation') {
                if (this.emp_pro_days > 0) {
                    var isEmpProDaysValid = true;
                } else {
                    var isEmpProDaysValid = false;
                }
            }
            else{
                var isEmpProDaysValid = true;
            }

            let isEmailValid = !(this.company_email_id && !this.validEmail(this.company_email_id));
            if (!this.reporting_to || !isEmpProDaysValid || !isReportingValid || !this.job_shift || !this.work_location || !this.doj || !this.emp_status || !this.emp_code || !this.emp_job_status || !this.job_description || !this.emp_department || !this.emp_att_machine || !this.emp_designation || !this.child_company || !isEmailValid) {
                this.e_child_company = !this.child_company ? 'Select Child Company' : '';
                this.e_company_email_id = !isEmailValid ? 'Enter valid email' : '';
                this.e_reporting_to = !this.reporting_to ? 'Select Reporting Employee' : '';
                this.e_job_shift = !this.job_shift ? 'Select job shift' : '';
                this.e_work_location = !this.work_location ? 'Select work location' : '';
                this.e_doj = !this.doj ? 'Select date of joining' : '';
                this.e_selectedCurrency = !this.selectedCurrency ? 'Select the currency' : '';
                this.e_emp_status = !this.emp_status ? 'Select employee status' : '';
                this.e_emp_job_status = !this.emp_job_status ? 'Select job status' : '';
                this.e_job_description = !this.job_description ? 'Enter job description' : '';
                this.e_emp_department = !this.emp_department ? 'Select department' : '';
                this.e_emp_designation = !this.emp_designation ? 'Select designation' : '';
                this.e_emp_att_machine = !this.emp_att_machine ? 'Select attendance machine' : '';
                this.e_emp_pro_days = this.emp_job_status === 'Probation' && !this.emp_pro_days ? 'Enter probation days' : '';
                this.check_reporting = this.reporting_to === this.second_reporting && this.reporting_to !== null;
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                if (this.second_reporting != null) {
                    var second_reporting = this.second_reporting.id;
                } else {
                    var second_reporting = '';
                }
                this.emp_pro_days = this.emp_job_status !== 'Probation' ? 0 : this.emp_pro_days;

                axios.post('./update_employment', {
                    selected: this.selected,
                    id: this.id,
                    doj: this.doj,
                    login_check: this.login_check,
                    reporting_to: this.reporting_to.id,
                    second_reporting: second_reporting,
                    job_shift: this.job_shift,
                    work_location: this.work_location,
                    emp_salary: this.emp_salary,
                    emp_currency: this.selectedCurrency,
                    emp_stipend: this.emp_stipend,
                    emp_status: this.emp_status,
                    emp_job_status: this.emp_job_status,
                    emp_pro_days: this.emp_pro_days,
                    job_description: this.job_description,
                    remarks: this.remarks,
                    child_company: this.child_company,
                    emp_department: this.emp_department,
                    emp_designation: this.emp_designation,
                    hr_notifications: this.hr_notifications,
                    att_check: this.att_check,
                    user_email: this.user_email,
                    user_password: this.user_password,
                    emp_code: this.emp_code,
                    company_email_id: this.company_email_id,
                    methodtype: this.methodtype,
                    emp_att_machine: this.emp_att_machine,
                    bankaccount: this.bankaccount,
                    bankname: this.bankname,
                    accountname: this.accountname,
                })
                    .then(data => {
                        if (data.data == "Update Employee Record Successfully") {
                            this.$toastr.s("Update Employee Record Successfully", "Congratulations");
                        } else if (data.data == 'empty_username') {
                            this.$toastr.e("Please Type Username && Password", "Error!");
                        } else if (data.data == 'invalid email id') {
                            this.$toastr.e("Please Type Valid User Email Id of Username", "Error!");
                        } else if (data.data == 'Email Id Already Exists') {
                            this.$toastr.e("User Email Id Already Exists", "Error!");
                        } else if (data.data == 'Please Select Employees Attendace List') {
                            this.$toastr.e("Please Select Employees Attendace List", "Error!");
                        } else if (data.data == 'Child Company') {
                            this.$toastr.e("Please Select Child Company", "Error!");
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                    })
                    .catch(error => this.error = error.response.data.errors)
            }
        },
        async fetchDesignation() {
            try {
                this.designations = await this.$helpers.checkLocal('overall_designation');
                this.options5 = [];
                var $this = this;
                for (var i = 0; i < $this.designations.length; i++) {
                    this.options5.push($this.designations[i].designation_name);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
    },
    mounted() {
        this.fetchDesignation();



        axios.get('overall_child_companies_emp')
            .then(response => {
                this.child_comlist = response.data
                this.options_child = [];

                var $this = this;
                for (var i = 0; i < $this.child_comlist.length; i++) {
                    this.options_child.push($this.child_comlist[i].Company);
                }
            })

        axios.get('overall_location')
            .then(response => {
                this.locations = response.data
                this.options1 = [];

                var $this = this;
                for (var i = 0; i < $this.locations.length; i++) {
                    this.options1.push($this.locations[i].location_name);
                }
            })
            .catch(error => {
            });

        axios.get('get_com_employee')
            .then(response => {
                this.employees_detail5 = response.data;
                this.options = [];
                var $this = this;
                for (var i = 0; i < $this.employees_detail5.length; i++) {
                    this.options.push($this.employees_detail5[i].Name + '_' + $this.employees_detail5[i].EmployeeCode);
                }
            })

        axios.get('get_machines')
            .then(data => {
                this.attendanceMachines = data.data.data;
            })

        axios.get('roster_detail1')
            .then(data => {
                this.rosters = data.data
                this.options4 = [];
                var $this = this;
                for (var i = 0; i < $this.rosters.length; i++) {
                    this.options4.push($this.rosters[i].RosterName);
                }
            })

        axios.get('getemployment_att_detail/' + this.id)
            .then(response => {
                this.att_emp = response.data;
                this.selected = [];
                var $this = this;
                for (var j = 0; j < $this.att_emp.length; j++) {
                    this.selected.push($this.att_emp[j].Name + '_' + $this.att_emp[j].EmployeeCode);
                }
            })

        axios.get('currency_detail')
            .then(response => {
                this.currencyNames = response.data.map(currency => currency.name);
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('getemployment_detail/' + this.id)
            .then(data => {
                this.emp_data = data.data;
                this.login_check = false; //used false as no need now

                this.reporting1Id = data.data[0].ReportingTo;
                this.reporting2Id = data.data[0].ReportingTo2;

                this.job_shift = data.data[0].RosterName;
                this.work_location = data.data[0].PostingCity;
                this.emp_salary = data.data[0].Salary;
                this.emp_salary9 = data.data[0].Salary;
                this.emp_status = data.data[0].Status;
                this.emp_job_status = data.data[0].JobStatus;
                this.selectedCurrency = data.data[0].Salary_Currency || "Pakistani Rupee";
                this.doj = data.data[0].JoiningDate;
                // this.emp_pro_days = data.data[0].ProbationEnd;

                const dateOfJoining = new Date(this.doj);
                const probationEndDate = new Date(data.data[0].ProbationEnd);
                const differenceInMilliseconds = probationEndDate - dateOfJoining;
                this.emp_pro_days = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));

                this.job_description = data.data[0].JobDescription;
                this.remarks = data.data[0].remarks;
                this.child_company = data.data[0].CompanyName;
                this.emp_department = data.data[0].Department;
                this.emp_designation = data.data[0].Designation;
                this.methodtype = data.data[0].MethodType;
                this.bankaccount = data.data[0].BankAccount;
                this.bankname = data.data[0].bank_name;
                this.accountname = data.data[0].account_name;
                this.emp_att_machine = data.data[0].AttendanceMachine;

                this.hr_notifications = false; //false as no need
                var attt = data.data[0].AllowEmployeesAttendance;
                if (attt == 0) {
                    this.att_check = false;
                } else {
                    this.att_check = true;
                }
                this.emp_code = data.data[0].EmployeeCode;
                this.company_email_id = data.data[0].CompanyEmail;
            })

        axios.get('overall_employees')
            .then(response => {
                this.employees_detail = response.data;
                this.options7 = [];
                this.options7 = this.employees_detail.map((emp) => ({
                    id: emp.EmployeeID,
                    label: `${emp.EmployeeCode}, ${emp.Name}`,
                }));
                this.reporting_to = this.options7.find(option => option.id === Number(this.reporting1Id));
                this.second_reporting = this.options7.find(option => option.id === Number(this.reporting2Id));
            })
    }
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
