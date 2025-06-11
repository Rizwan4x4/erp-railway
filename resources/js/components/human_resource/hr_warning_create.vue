<template>
    <div>
        <div class="app-content content ">
            <div class="noprint content-overlay"></div>
            <div class="noprint cheader-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/hr/dashboard" style="text-decoration: none;">Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/hr/warning_detail" style="text-decoration: none;">Warning Details
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Issue Warning
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="invoice-preview-wrapper">
                        <div class="row invoice-preview">
                            <!-- Invoice -->
                            <div class="col-xl-9 col-md-8 col-12">
                                <div id="thisid">
                                    <div class="card invoice-preview-card">
                                        <div class="card-body invoice-padding pb-0">
                                            <div
                                                class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                                <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                                    <div style="padding-top:10px" class="logo-wrapper">
                                                        <h3 class="text-primary invoice-logo">
                                                            {{ companydetail1.company_name }}</h3>
                                                    </div>
                                                    <p class="card-text mb-25">Address:
                                                        {{ companydetail1.company_address }} , </p>
                                                    <p class="card-text mb-25">City: {{ companydetail1.city }} -
                                                        {{ companydetail1.country }}</p>
                                                    <p class="card-text mb-0">Phone:
                                                        {{ companydetail1.phone_number }}</p>
                                                </div>
                                                <div class="mt-md-0 mt-2" style="padding-right:20px;padding-top:20px">

                                                    <div class="invoice-date-wrapper">
                                                        <p style="margin-bottom:5px !important"
                                                            class="invoice-date-title">
                                                            <strong>Date Issued:</strong>
                                                            <input type="date" v-model="date" />
                                                        </p>
                                                    </div>
                                                    <label style="color: #d93025" v-if="date == ''">{{ mydate }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="invoice-spacing" />
                                        <div class="card-body invoice-padding pt-0"
                                            style="margin-left:5%;margin-right:5%;">
                                            <div class="row invoice-spacing">
                                                <div class="col-xl-6 p-0">
                                                    <h6 class="mb-2">
                                                        <strong>Employee Name:</strong>
                                                        <!--<select class="" v-model="emp_code" @change="getemp_detail()" style="width:40%">
                                                            <option value="">Select Name</option>
                                                            <option v-for='empcode1 in empcode' :value='empcode1.EmployeeCode'>{{ empcode1.EmployeeCode }}</option>
                                                        </select>-->
                                                        <multiselect v-model="emp_code1" @input="getemp_detail()"
                                                            :show-labels="false"
                                                            style="margin-right: 10px; font-size: 15px;"
                                                            id="accountPhoneNumber" placeholder="Select Employee"
                                                            :options="options"></multiselect>
                                                        <label style="color: #d93025" v-if="emp_code == ''">{{ e_emp_id
                                                            }}</label>
                                                    </h6>
                                                    <h6 class="mb-2">
                                                        <strong>Name:</strong>
                                                        <input type="text" style="width:50%" v-model="emp_name"
                                                            readonly />
                                                        <label style="color: #d93025" v-if="emp_name == ''">{{
                                                            e_emp_name
                                                        }}</label>
                                                    </h6>
                                                    <h6 class="mb-25">
                                                        <strong>Department:</strong>
                                                        <input type="text" style="width:50%" v-model="department"
                                                            readonly />

                                                        <label style="color: #d93025" v-if="department == ''">{{
                                                            e_department }}</label>
                                                    </h6>
                                                    <h6 class="card-text mb-25">
                                                        <strong>Designation:</strong>
                                                        <input type="text" style="width:50%" v-model="designation"
                                                            readonly />
                                                        <label style="color: #d93025" v-if="designation == ''">{{
                                                            e_designation }}</label>
                                                    </h6>
                                                    <h6 class="card-text mb-25">
                                                        <strong>Location:</strong>
                                                        <input type="text" style="width:50%" v-model="location"
                                                            readonly />
                                                        <label style="color: #d93025" v-if="location == ''">{{
                                                            e_location
                                                        }}</label>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Address and Contact starts -->
                                        <div style="margin-left:5%;margin-right:5%;" class="card-body  pt-0">
                                            <div class="row invoice-spacing">
                                                <h6 class="card-text mb-25" style="padding-left:0px">
                                                    <strong>Subject:</strong>
                                                    <multiselect value="ID" v-model="subject" :show-labels="false"
                                                        style="margin-right: 10px; font-size: 15px;"
                                                        id="accountPhoneNumber" placeholder="Select Warning Reason"
                                                        :options="options1" @input="get_warndetail()"></multiselect>

                                                    <label style="color: #d93025" v-if="subject == ''">{{ e_subject
                                                        }}</label>
                                                </h6>
                                                <br>
                                                <div class="card-body invoice-padding">
                                                    <div class="row invoice-sales-total-wrapper">
                                                        <div class="col-md-12 order-md-1 order-2 mt-md-0 mt-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-2">
                                                                        <vue-editor
                                                                            style="height:500px; margin-bottom:50px;"
                                                                            v-model="warningContent"
                                                                            placeholder="Add Warning">
                                                                        </vue-editor>
                                                                        <label style="color: #d93025; margin-top:35px;"
                                                                            v-if="this.sliced != this.companyname">{{
                                                                                e_sliced }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="noprint card-body invoice-padding pb-0">
                                            <div class="row invoice-sales-total-wrapper">
                                            </div>
                                        </div>
                                        <hr class="noprint invoice-spacing" />
                                    </div>
                                </div>
                            </div>
                            <!-- /Invoice -->
                            <!-- Invoice Actions -->
                            <div class="noprint col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="delay()"
                                            class="btn btn-primary w-100 btn-download-invoice mb-75">Save
                                        </button>
                                        <button :disabled="disabled" @click="delay1()"
                                            class="btn btn-outline-success  w-100 mb-75">Save & Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /Invoice Actions -->
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="false" :preview-modal="true"
            :paginate-elements-by-height="5000" filename="Warning_Issued" :pdf-quality="2" :manual-pagination="false"
            pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)"
            @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="htmlempdetailPdfs">
            <div slot="pdf-content">
                <div class="content-body" v-for='warning_detail1 in warning_detail'>
                    <section class="invoice-preview-wrapper">
                        <div class="row invoice-preview">
                            <!-- Invoice -->
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="card invoice-preview-card">
                                    <div class="card-body invoice-padding pb-0">
                                        <!-- Header starts -->
                                        <div
                                            class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                            <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                                <div style="padding-top:10px" class="logo-wrapper">
                                                    <h3 class="text-primary invoice-logo">
                                                        {{ companydetail1.company_name }}</h3>
                                                </div>
                                                <p class="card-text mb-25">Address: {{ companydetail1.company_address }}
                                                    , </p>
                                                <p class="card-text mb-25">City: {{ companydetail1.city }} -
                                                    {{ companydetail1.country }}</p>
                                                <p class="card-text mb-0">Phone: {{ companydetail1.phone_number }}</p>
                                            </div>
                                            <div class="mt-md-0 mt-2" style="padding-right:20px;padding-top:20px">
                                                <h4 class="invoice-title">
                                                    Id#{{ warning_detail1.LetterID }}
                                                </h4>
                                                <div class="invoice-date-wrapper">
                                                    <p style="margin-bottom:5px !important" class="invoice-date-title">
                                                        Date Issued:{{ warning_detail1.DateIssued }}</p>
                                                </div>
                                                <div class="">
                                                    <p style="margin-bottom:5px !important" class="invoice-date-title">
                                                        Warning Type:<span style="color:red">{{
                                                            warning_detail1.WarningType }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Header ends -->
                                    </div>
                                    <hr class="invoice-spacing" />
                                    <div class="card-body invoice-padding pt-0" style="margin-left:5%;margin-right:5%;">
                                        <div class="row invoice-spacing">
                                            <div class="col-xl-8 p-0">
                                                <h6 class="mb-2">Employee Code:{{ warning_detail1.EmployeeID }}</h6>
                                                <h6 class="mb-2">Name:{{ warning_detail1.EmployeeName }}</h6>
                                                <h6 class="mb-25">Department: {{ warning_detail1.Department }}</h6>
                                                <h6 class="card-text mb-25">Designation:
                                                    {{ warning_detail1.Designation }}</h6>
                                                <h6 class="card-text mb-25">Location:{{ warning_detail1.Location }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div style="margin-left:5%;margin-right:5%;" class="card-body  pt-0">
                                        <div class="row invoice-spacing">
                                            <h6 class="card-text mb-25" style="padding-left:0px;font-weight:bold">
                                                Subject:{{ warning_detail1.ReasonSubject }}</h6>
                                            <br>
                                            <h6 class="card-text mb-25" style="padding-left:0px">Dear FirstName</h6>
                                            <br>
                                            <p style="padding-left:0px">
                                                This letter serves a written warning to you for not meeting your
                                                objectives as outlined in your Appointment Letter / Job Description /
                                                Prior performance appraisal / Goals as agreed between you and your
                                                supervisor.
                                            </p>
                                            <p style="padding-left:0px">
                                                As intimated by the management / your supervisor, we are putting you on
                                                a Corrective Action Plan commencing from < mention date>. This plan is
                                                    being introduced to bring your performance up to an acceptable
                                                    standard,
                                                    considering your capabilities and requirements of your job role.
                                            </p>
                                            <p style="padding-left:0px">
                                                Each member in our company is expected to contribute to the best of
                                                their abilities and meet the objectives laid out in their job role.
                                                Hence, we would like you to immediately improve your performance and
                                                meet expectations of your supervisor and company management.
                                            </p>
                                            <p style="padding-left:0px">
                                                Each member in our company is expected to contribute to the best of
                                                their abilities and meet the objectives laid out in their job role.
                                                Hence, we would like you to immediately improve your performance and
                                                meet expectations of your supervisor and company management.
                                            </p>
                                            <h6 class="card-text mb-25" style="padding-left:0px">Sincerely,</h6>
                                            <h6 class="card-text mb-25" style="padding-left:0px">HR Department</h6>
                                            <h6 v-for='companydetail1 in companydetail' class="card-text mb-25"
                                                style="padding-left:0px">{{ companydetail1.company_name }}</h6>
                                        </div>
                                    </div>
                                    <div class="card-body invoice-padding pb-0">
                                        <div class="row invoice-sales-total-wrapper">
                                        </div>
                                    </div>
                                    <hr class="invoice-spacing" />
                                </div>
                            </div>
                            <!-- /Invoice -->

                        </div>
                    </section>
                </div>


            </div>

        </vue-html2pdf>
    </div>
</template>
<script>
import { VueEditor } from 'vue2-editor';
import VueHtml2pdf from 'vue-html2pdf';
import Multiselect from 'vue-multiselect';

export default {
    data() {
        return {
            options: [],
            options1: [],
            companyname: '',
            sliced1: '',
            sliced: '',
            e_sliced: '',
            error: 'Please fill required fields',
            warning_content: '<p class="ql-align-justify"> This letter serves a written warning to you for</p><p class="ql-align-justify"><br></p><p class="ql-align-justify"> We are putting you on a Corrective Action Plan commencing from&nbsp;Above mentioned date. This plan is being introduced to bring your performance up to an acceptable standard, considering your capabilities and requirements of your job role.</p><p class="ql-align-justify"> Each member in our company is expected to contribute to the best of their abilities and meet the objectives laid out in their job role. Hence, we would like you to immediately improve your performance and meet expectations of your supervisor and company management.</p><p class="ql-align-justify"><br></p><h4><strong>Sincerely,</strong></h4><h4><strong>HR Department</strong></h4><h4><strong>SA Gardens</strong></h4>',
            date: new Date().toJSON().slice(0, 10),
            mydate: this.date,
            emp_code1: '',
            emp_code: '',
            emp_name: '',
            department: '',
            designation: '',
            location: '',
            subject: '',
            empcode: {},
            e_date: '',
            e_emp_id: '',
            e_department: '',
            e_designation: '',
            e_location: '',
            e_subject: '',
            e_emp_name: '',
            adsdata: {},
            reason: {},
            companydetail: {},
            warning_detail: {},
            isError: '1',
            emp_id_warn: 'null',

            disabled: false,
            timeout: null,

            disabled1: false,
            timeout1: null,

            disabled2: false,
            timeout2: null,

            disabled3: false,
            timeout3: null,
            warningContent: '',

            htmlToPdfOptions: {
                margin: 0,

                filename: `hehehe.pdf`,

                image: {
                    type: 'jpeg',
                    quality: 0.98
                },

                enableLinks: false,

                html2canvas: {
                    scale: 1,
                    useCORS: true
                },

                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                }
            },
        }
    },
    methods: {


        async overall_empcode() {
            try {
                const data = await this.$apihelpers.overall_empcode()
                this.empcode = data;
                this.options = [];

                var $this = this;
                for (var i = 0; i < $this.empcode.length; i++) {
                    this.options.push($this.empcode[i].Name + '_' + $this.empcode[i].EmployeeCode);
                }
                // Process the data or perform additional actions here
            } catch (error) {
                console.error(error);
                // Additional error handling if needed
            }
        },
        print_warning() {
            axios.get('getwarnig_emp/' + this.emp_id_warn)
                .then(data => {
                    this.warning_detail = data.data;
                })
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false;
                if (this.emp_id_warn != 'null') {
                    this.generateempdetailReport();
                }
            }, 1000)

        },
        generateempdetailReport() {
            this.$refs.htmlempdetailPdfs.generatePdf()
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.issue_warning()
        },
        get_warndetail() {

            axios.get('fetch_warningdetail/' + this.subject)
                .then(response => {
                    this.warningContent = response.data.ReasonContent;
                })

        },
        delay1() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.issue_warning();
            this.disabled3 = true
            this.timeout3 = setTimeout(() => {
                this.disabled3 = false
                this.print_warning();
            }, 2000)

            if (this.isError == "0") {

            }
        },
        issue_warning() {
            this.warning_content = this.warning_content.replace(/<h4><strong>.*?<\/strong><\/h4>\s*$/, `<h4><strong>${this.companyname}</strong></h4>`);
            this.sliced1 = this.warning_content.slice(-(this.companyname.length) - 14);
            this.sliced = this.sliced1.slice(0, this.companyname.length);

            if (this.emp_code == '' || this.department == '' || this.designation == '' || this.location == '' || this.subject == '' || this.emp_name == '' || this.sliced != this.companyname) {
                if (this.emp_code == '') {
                    this.e_emp_id = 'Select employee code!';
                } else {
                    this.e_emp_id = '';
                }
                if (this.department == '') {
                    this.e_department = 'Add department in employee profile!';
                } else {
                    this.e_department = ''
                }
                if (this.designation == '') {
                    this.e_designation = 'Add designation in employee profile!';
                } else {
                    this.e_designation = '';
                }
                if (this.location == '') {
                    this.e_location = 'Add location in employee profile!';
                } else {
                    this.e_location = '';
                }
                if (this.subject == '') {
                    this.e_subject = 'Select subject of warning!';
                } else {
                    this.e_subject = '';
                }
                if (this.emp_name == '') {
                    this.e_emp_name = 'Add name in employee profile!';
                } else {
                    9
                    this.e_emp_name = '';
                }

                // console.log('Company Name:', this.companyname);
                // console.log('Content:', this.warning_content);
                // console.log('Sliced1:', this.sliced1);
                // console.log('Sliced:', this.sliced);

                if (this.sliced != this.companyname) {
                    this.e_sliced = 'You cannot change company name in warning letter!';
                    this.error = 'You cannot change company name in warning letter!';
                } else {
                    this.e_sliced = '';
                    this.error = 'Please fill required fields!';
                }
                this.isError = "1";
                this.emp_id_warn = 'null';
                this.$toastr.e(this.error, "Error!");
            } else {
                this.isError = "0";

                axios.post('./submit_warning', {
                    dated: this.date,
                    emp_code: this.emp_code,
                    emp_name: this.emp_name,
                    department: this.department,
                    designation: this.designation,
                    warning_content: this.warningContent,
                    location: this.location,
                    subject: this.subject,
                })
                    .then(response => {
                        if (response.data == 'submitted') {
                            this.$toastr.s("Warning Letter issued Successfully", "Congratulations!");
                            this.emp_id_warn = this.emp_code;
                            this.warning_content = '';
                            this.emp_code = '';
                            this.e_subject = '';
                            this.emp_name = '';
                            this.department = '';
                            this.designation = '';
                            this.location = '';
                            this.subject = '';
                            this.$router.push({ name: 'warning_detail' });
                        } else if (response.data.message == 'Employee is already terminated') {
                            this.$toastr.i("Employee is already terminated", "Information!");
                            this.emp_id_warn = 'null';
                            this.emp_code = '';
                            this.e_subject = '';
                            this.emp_name = '';
                            this.department = '';
                            this.designation = '';
                            this.location = '';
                            this.subject = '';
                        }
                    })
            }

        },
        getemp_detail() {
            var empcode1 = this.emp_code1.split('_');
            this.emp_code = empcode1[1];
            console.log(this.emp_code, "employee code");

            axios.post('./get_emp_detail', {
                emp_id: this.emp_code,
            })
                .then(response => {
                    this.department = response.data[0].Department;
                    this.designation = response.data[0].Designation;
                    this.location = response.data[0].PostingCity;
                    this.emp_name = response.data[0].Name;

                })
                .catch(error => this.error = error.response.data.errors)

        },
    },
    components: {
        VueHtml2pdf,
        VueEditor,
        Multiselect
    },
    mounted() {

        // this.fetchRoles();
        this.overall_empcode();


        // axios.get('warning_reasons')
        //     .then(response => this.reason = response.data)

        axios.get('warning_reasons')
            .then(response => {
                this.reason = response.data
                this.options1 = [];

                var $this = this;
                for (var j = 0; j < $this.reason.length; j++) {
                    this.options1.push($this.reason[j].ReasonName);
                }
            })
            .catch(error => {
            });


        axios.get('fetch_companyDetail')
            .then(response => {
                this.companydetail = response.data;
                this.companyname = response.data[0].company_name;
                // console.log(this.companyname,"compny name    bibrfre");

            })

    }
}
</script>
