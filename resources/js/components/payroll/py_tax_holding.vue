<template>
    <div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-body">
                    <div class="content-header row">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/" style="text-decoration: none;">Payroll</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    Taxes
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-primary border-0 top-radius bottom-radius" role="alert">
                                <div class="alert-body" style="min-height: 55px;margin-bottom: 10px;">
                                    <ul class="nav nav-pills mb-2" style="float:left">
                                        <li class="nav-item">
                                            <router-link to="/payroll/dues" class="nav-link">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Dues</span>
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link to="/payroll/taxholding" class="nav-link active">
                                                <i class="fa-solid fa-file-powerpoint"></i>
                                                <span class="fw-bold">Taxes</span>
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="basic-table">
                        <div class="col-12">
                            <div class="card border-0 top-radius bottom-radius">
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <h5 style="padding-left:10px;padding-top:10px">Session Name:
                                            {{ this.session_name }}</h5>
                                    </div>
                                    <div class="col-md-4 col-12 mb-2 position-relative">
                                        <input type="text" v-model="keyword1" class="form-control p-2"
                                               placeholder="Search By Name or Employee code">
                                    </div>
                                    <div class="col-md-3 col-12 mb-2 position-relative">
                                        <button v-if="hasPermission('Payroll Appply Tax')" data-bs-toggle="modal" data-bs-target="#applytax"
                                                class="btn btn-primary bg-primary p-2">Apply Tax
                                        </button>
                                        <button  v-else
                                                class="btn btn-danger">Apply Tax
                                        </button>
                                        <button v-if="hasPermission('Payroll download excel file of Tax')" type="button" @click="html_table_to_excel('xlsx','Tax_holding_report')"
                                                class="btn btn-gradient-info p-2">Excel
                                        </button>
                                        <button  v-else type="button"
                                                class="btn btn-danger">Excel
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive" id="Tax_holding_report">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th style="font-size:10px !important;">Emp. Code</th>
                                            <th style="font-size:10px !important;">Name</th>
                                            <th style="font-size:10px !important;">Date</th>
                                            <th style="font-size:10px !important;">Salary</th>
                                            <th style="font-size:10px !important;">Start Session</th>
                                            <th style="font-size:10px !important;">Tax Type</th>
                                            <th style="font-size:10px !important;">Amount</th>
                                            <th style="font-size:10px !important;">Description</th>
                                            <th style="font-size:10px !important;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="all_sals1 in all_sals.data">
                                            <td style="text-align:center;border-right:1px solid lightgrey">
                                                {{ all_sals1.EmployeeCode }}
                                            </td>
                                            <td style="border-right:1px solid lightgrey">
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
                                            </td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">
                                                {{ all_sals1.ApplyDate }}
                                            </td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">
                                                {{ all_sals1.Salary }}
                                            </td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">
                                                {{ all_sals1.StartSession }}
                                            </td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">
                                                {{ all_sals1.TaxType }}
                                            </td>
                                            <td style="text-align:center;border-right:1px solid lightgrey">
                                                {{ all_sals1.TaxAmount }}
                                            </td>
                                            <td style="border-right:1px solid lightgrey;text-align:center;">
                                                {{ all_sals1.Descriptions }}
                                            </td>
                                            <td>
                                                <a v-if="hasPermission('Payroll update tax of employe')" @click="fetch_emp_payroll(all_sals1.TaxID)" data-bs-toggle="modal"
                                                   data-bs-target="#editpayroll"><i style="color:#d42f2f"
                                                                                    class="fa-solid fa-pencil"></i><span></span></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center;padding-top:20px">
                                    <pagination :data="all_sals" @pagination-change-page="getResult"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal table -->

                    <div class="modal fade" id="applytax" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h5>Apply Tax to Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardNumber">Session Name</label>
                                            <input v-model="session_name" type="text" readonly id="modalAddCardName"
                                                   class="form-control"/>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Apply Date</label>
                                            <input v-model="emp_date" type="date" class="form-control"/>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Employee Code</label>
                                            <multiselect style="margin-right: 10px;"
                                                         v-model="emp_emp_id"
                                                         :multiple="true"
                                                         :options="options"
                                                         :show-labels="false"
                                            >
                                            </multiselect>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Amount</label>
                                            <input v-model="emp_amount" type="number" id="modalAddCardName"
                                                   class="form-control"/>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Description</label>
                                            <input v-model="emp_description" type="text" id="modalAddCardName"
                                                   class="form-control"/>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled" @click="delay()"
                                                    class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal"
                                                    aria-label="Close">Apply Now
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1"
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
        <div class="modal fade" id="editpayroll" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h5>Update Tax of Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Session Name</label>
                                <input v-model="edit_session_name" type="text" readonly id="modalAddCardName"
                                       class="form-control"/>
                                <input hidden v-model="edit_bonus_id" type="text" readonly id="modalAddCardName"
                                       class="form-control"/>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Apply Date</label>
                                <input v-model="edit_date" type="date" class="form-control"/>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Employee Code</label>
                                <select v-model="edit_emp_id" class="form-control">
                                    <option value="">Select Employee</option>
                                    <option v-for='find_emp1 in find_emp' :value='find_emp1.EmployeeID'>
                                        {{ find_emp1.EmployeeCode }}-{{ find_emp1.Name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Amount</label>
                                <input v-model="edit_amount" type="number" id="modalAddCardName" class="form-control"/>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="modalAddCardName">Description</label>
                                <input v-model="edit_description" type="text" id="modalAddCardName"
                                       class="form-control"/>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled1" @click="delay1()"
                                        class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Update
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import axios from "axios";

export default {
    data() {
        return {
            options: [],
            all_sals: {},
            find_emp: {},
            emp_emp_id: null,
            emp_amount: '',
            emp_description: '',
            emp_date: '',
            allowance_type: '',


            keyword1: '',
            session_name: '',
            bonus_id: '',

            edit_emp_id: '',
            edit_session_name: '',
            edit_amount: '',
            edit_description: '',
            edit_bonus_id: '',
            edit_date: '',
            edit_allowance_type: '',

            disabled: false,
            timeout: null,

            disabled1: false,
            timeout1: null,

            disabled2: false,
            timeout2: null,
        }
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    components: {Multiselect},
    methods: {
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.applytaxholding()
        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.updatetax()
        },
        delay2() {
            this.disabled2 = true
            this.timeout2 = setTimeout(() => {
                this.disabled2 = false
            }, 5000)
            this.update_arrear_payroll()
        },
        updatetax() {
            axios.post('update_ind_tax', {
                edit_emp_id: this.edit_emp_id,
                edit_session_name: this.edit_session_name,
                edit_amount: this.edit_amount,
                edit_description: this.edit_description,
                edit_date: this.edit_date,
                edit_bonus_id: this.edit_bonus_id,
            })
                .then(data => {

                    this.$toastr.s("Updated Tax Successfully!", "Congratulations");
                    this.all_sals = data.data;

                })
        },
        fetch_emp_payroll(id) {
            axios.get('find_payroll_tax/' + id)
                .then(data => {
                    this.edit_emp_id = data.data[0].EmployeeID;
                    this.edit_session_name = data.data[0].StartSession;
                    this.edit_amount = data.data[0].TaxAmount;
                    this.edit_description = data.data[0].Descriptions;
                    this.edit_date = data.data[0].ApplyDate;
                    this.edit_bonus_id = data.data[0].TaxID;
                })
                .catch(error => {
                });
        },
        applytaxholding() {
            axios.post('submit_tax', {
                emp_emp_id: this.emp_emp_id,
                emp_amount: this.emp_amount,
                emp_description: this.emp_description,
                emp_date: this.emp_date,
                session_name: this.session_name,
            })
                .then(data => {
                    this.$toastr.s("Submitted Tax Successfully!", "Congratulations");
                    this.all_sals = data.data;
                    this.emp_emp_id = '',
                        this.emp_amount = '',
                        this.emp_description = '',
                        this.emp_date = '',
                        this.session_name = ''

                })
        },

        getResults() {
            axios.get('./search_payroll_tax', {params: {keyword1: this.keyword1}})
                .then(response => this.all_sals = response.data)
                .catch(error => console.log(error));

        },

        getResult(page = 1) {

            axios.get('fetch_payroll_tax?page=' + page)
                .then(response => this.all_sals = response.data)
                .catch(error => {
                });
        },
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
                worksheet: name || '',
                table: data
            };
            var link = document.createElement("a");
            link.download = tableID + ".xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        },

    },
    mounted() {
        this.getResult();
        axios.get('find_emp_id')
            .then(data => {
                this.find_emp = data.data.data;
                this.options = [];

                var $this = this;
                for (var i = 0; i < $this.find_emp.length; i++) {

                    this.options.push($this.find_emp[i].Name + '_' + $this.find_emp[i].EmployeeCode);
                }
            })
            .catch(error => {
            });

        axios.get('session_not_in_dist')
            .then(response => {
                this.session_name = response.data;
            })
    },
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.border-0 {
    border: 0;
}

.top-radius {
    border-top-left-radius: 12px !important;
    border-top-right-radius: 12px !important;
}

.bottom-radius {
    border-bottom-left-radius: 12px !important;
    border-bottom-right-radius: 12px !important;
}

.bg-custom {
    background-color: #F9F9F9 !important;
}
</style>
