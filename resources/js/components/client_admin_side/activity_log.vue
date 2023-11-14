<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link class="d-flex align-items-center" to="/">
                                        Dashboard
                                    </router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Activity log
                                </li>
                            </ol>
                        </div>
                        <div clas="card" style="background-color:white !important">
                            <div class="card-body border-bottom">
                                <h4 class="card-title">Search & Filter</h4>
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <label class="form-label" for="fromDate">From Date</label>
                                    </div>
                                    <div class="col-md-3 ">
                                        <label class="form-label" for="toDate">To Date</label>
                                    </div>
                                    <div class="col-md-3 user_status">
                                        <label class="form-label" for="FilterTransaction">Users</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <input type="date" class="form-control account-number-mask" v-model="fromDate">
                                    </div>
                                    <div class="col-md-3 ">
                                        <input type="date" class="form-control account-number-mask" v-model="toDate">
                                    </div>
                                    <div class="col-md-3 user_status">
                                        <multiselect style="margin-right: 10px;" :options="options" value="id" label="label" v-model="users" placeholder="Select Employee"></multiselect>
                                    </div>
                                    <div class="col-md-1" style="text-align:center">
                                        <button type="button" @click="getResult()" class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Search</button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="dt-buttons d-inline-flex mt-50">
                                            <button type="button" @click="html_table_to_excel('xlsx','Activity_log')" class="btn btn-gradient-info"> Excel</button>
                                            <button style="margin-left: 20px" type="button" @click="htmllogsreport()" class="btn btn-gradient-info"> Pdf</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table" id="Activity_log">
                                    <thead>
                                        <tr>
                                            <th>DateTime</th>

                                            <th>User Id</th>
                                            <th>Activity Type</th>
                                            <th>Activity Detail</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="adsdata1 in adsdata">
                                            <td>
                                                {{adsdata1.ActivityTime}}
                                            </td>

                                            <td>
                                                {{adsdata1.UserEmail}}
                                            </td>
                                            <td>
                                                {{adsdata1.EventStatus}}
                                            </td>
                                            <td>
                                                {{adsdata1.Description}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                    <vue-html2pdf :show-layout="false"
                                  :float-layout="true"
                                  :enable-download="false"
                                  :preview-modal="true"
                                  :paginate-elements-by-height="5000"
                                  filename="Employee_Hiring_Report"
                                  :pdf-quality="2"
                                  :manual-pagination="false"
                                  pdf-format="a4"
                                  pdf-orientation="landscape"
                                  pdf-content-width="1100px"
                                  @progress="onProgress($event)"
                                  @hasStartedGeneration="hasStartedGeneration()"
                                  @hasGenerated="hasGenerated($event)"
                                  ref="htmllogsPdf">
                        <div slot="pdf-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h4 class="modal-title" style="width:80%"><span style="width:80%">Activity logs</span> </h4>
                                <h2>From: {{fromDate}} to {{toDate}}</h2>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive EmployeeHireReport">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>DateTime</th>
                                                <th>User Id</th>
                                                <th>Activity Type</th>
                                                <th>Activity Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="adsdata1 in adsdata">
                                                <td>
                                                    {{adsdata1.ActivityTime}}
                                                </td>

                                                <td>
                                                    {{adsdata1.UserEmail}}
                                                </td>
                                                <td>
                                                    {{adsdata1.EventStatus}}
                                                </td>
                                                <td>
                                                    {{adsdata1.Description}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->

    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data() {
            return {
                adsdata: {},
                fromDate: new Date().toJSON().slice(0, 10),
                toDate: new Date().toJSON().slice(0, 10),
                users: '',
                user_detail: {},
                options:[],
                e_fromDate: '',
                e_toDate: '',
                users1: '',
                pdfStatus: '0',
            }
        },
        methods: {
            html_table_to_excel(type, tableID) {
                var uri = 'data:application/vnd.ms-excel;base64,',
                    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table border="1">{table}</table></body></html>',
                    base64 = function (s) {
                        return window.btoa(unescape(encodeURIComponent(s)))
                    },
                    format = function (s, c) {
                        return s.replace(/{(\w+)}/g, function (m, p) {
                            return c[p];
                        })
                    }
                var data = document.getElementById(tableID).innerHTML;
                var ctx = {
                    worksheet: name || '', table: data
                };
                var link = document.createElement("a");
                link.download = tableID + ".xls";
                link.href = uri + base64(format(template, ctx))
                link.click();
            },
            htmllogsreport() {
                if (this.pdfStatus == "1") {
                    this.$refs.htmllogsPdf.generatePdf()
                }
            },
            getResult() {
                if (this.fromDate == '' || this.toDate == '' || this.users == '' || this.users == null) {
                    if (this.fromDate == '') {
                        this.fromDate = new Date().toJSON().slice(0, 10);
                    }
                    if (this.toDate == '') {
                        this.toDat = new Date().toJSON().slice(0, 10);
                    }
                    if (this.users == '' || this.users == null) {
                        this.users1 = 'All'
                    }
                    else {
                        this.users1 = this.users.id;
                    }
                }
                else {
                    //Submit search form
                    axios.post('filter_activity', {
                        users: this.users1,
                        fromDate: this.fromDate,
                        toDate: this.toDate,
                    })
                        .then(data => {
                            this.adsdata = data.data;
                            this.pdfStatus = "1";

                        })
                }
            }
        },

        components: { Multiselect },
        mounted() {
            this.getResult();

            let pdfJS = document.createElement('script')

            pdfJS.setAttribute('src', 'https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js')
            document.head.appendChild(pdfJS)

            axios.get('overall_users')
                .then(response => {
                    this.user_detail = response.data;
                    this.options = [];
                    this.options = this.user_detail.map((obj) => ({
                        id: obj.email,
                        label: `${obj.EmployeeCode}` + ' _ ' + `${obj.Name}`,
                    }));
                })
        }
    }
</script>
