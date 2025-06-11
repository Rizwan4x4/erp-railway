<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">Petty Cash</li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <!--/ User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Petty Cash Detail</h4>
                                        <div style="text-align: right; width: 30% !important">
                                            <a v-if="hasPermission('Accounting pettycash_access create-pettyaccess')" style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect">Create New</a>
                                            <div class="" style="float: right">
                                                <div style="">
                                                    <label>
                                                        <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" @change="search_by_name()" class="form-control" style="" placeholder="Search By Name" />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom: 20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75 ">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive" style="overflow-x: initial !important">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Code</th>
                                                        <th>Account ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Department</th>
                                                        <th>Cash Limit</th>
                                                        <th>COA ID</th>
                                                        <th>COA Name</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd" v-for="adsdata1 in adsdata.data">
                                                        <td>{{adsdata1.EmployeeCode}}</td>
                                                        <td>{{adsdata1.AccountID}}</td>
                                                        <td>{{adsdata1.Name}}</td>
                                                        <td>{{adsdata1.Department}}</td>
                                                        <td> Rs. {{Number(adsdata1.Limit)}}/-</td>
                                                        <td>{{adsdata1.COAID}}</td>
                                                        <td>{{adsdata1.COAName}}</td>

                                                        <td  v-if="adsdata1.COAID==null &&adsdata1.AccountID==null && hasPermission('Accounting pettycash_access edit-pettyaccess')">
                                                            <a @click="fetch_pcashid(adsdata1.ID, adsdata1.Name)" data-bs-toggle="modal" data-bs-target="#edit_Pcash_access" class=""><i class="fa-solid fa-edit"></i></a>
                                                        </td>
                                                        <td v-else></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                                                    </div>
                                                                    <div style="
text-align: center;
padding-top: 20px;
">
                                                                        <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit_Pcash_access" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">Edit Petty Cash</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Employee Name</label>
                                <input type="text" :value='edit_name' readonly class="form-control">
                            </div>
                            <div class="invoice-customer">
                                <label class="form-label" for="modalAddCardName">Account ID</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" v-model="account_id" :options="options" id="FilterTransaction" :show-labels="false">
                                </multiselect>
                                <span style="color: #db4437; font-size: 11px" v-if="account_id == ''">{{ e_account_id }}</span>
                            </div>
                            <div class="invoice-customer">
                                <label class="form-label" for="modalAddCardName">Link COA ID</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" v-model="coa_id" :options="options2">
                                </multiselect>
                                <span style="color: #db4437; font-size: 11px" v-if="coa_id == ''">{{ e_coa_id }}</span>
                                <label hidden v-if="edit_name!='' && account_id != '' && coa_id !=''">{{close_model1='modal'}}</label>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1" :data-bs-dismiss='close_model1' aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3 class="text-center mb-1" id="addNewCardTitle">
                            Create Petty Cash User
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 mx-50 pb-5">
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Employee Name</label>
                                <input type="text" readonly v-model="emp_name" placeholder="Please select employee code to get name" class="form-control" style="" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Employee Code<span style="color: red;">*</span></label>
                                <multiselect @input="get_name()" style="margin-right: 10px;" v-model="emp_code" :options="emp_codes"></multiselect>
                                <span style="color: #db4437; font-size: 11px" v-if="emp_code == '' || emp_name ==''">{{ e_emp_code }}</span>
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="modalAddCardName">Petty Cash Limit<span style="color: red;">*</span></label>
                                <input type="number" placeholder="Type Patty Cash Limit" v-model="pcash_amount" class="form-control" style="" />
                                <span style="color: #db4437; font-size: 11px" v-if="pcash_amount==''">{{ Amount_error }}</span>
                                <label hidden v-if="pcash_amount!='' && emp_code != '' && emp_name !=''">{{close_model='modal'}}</label>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1" :data-bs-dismiss='close_model'>
                                    Create
                                </button>
                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

          <div class="modal fade" id="apprfinance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            np
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="mb-2">
                                        <h1 class="text-center fw-bolder">Confirmation</h1>
                                        <h5 class="text-center">Do you want to Paid PettyCash to Relevent Department?</h5>
                                        <input type="text" class="form-control" hidden v-model="paid_id" />
                                        <div class="row">
                                        <div class="col-md-6">
                                        <label>Petty Cash Limit</label>
                                            <input type="text" readonly class="form-control" readonly v-model="p_limit" />
                                        </div>
                                         <div class="col-md-6">
                                         <label>Department</label>
                                          <input type="text" readonly class="form-control" v-model="p_dept" />
                                        </div>
                                        <div class="col-md-6">
                                        <label>Account ID</label>
                                            <input type="text" readonly class="form-control" readonly v-model="p_accountid" />
                                        </div>
                                         <div class="col-md-6">
                                         <label>Remaining Amount</label>
                                          <input type="text" readonly class="form-control" v-model="p_remaining" />
                                        </div>
                                         <div class="col-md-12">
                                         <label>Paid Amount</label>
                                          <input type="text" class="form-control" v-model="paid_amount" />
                                        </div>
                                        </div>
                                        <br>


                                        <div class="text-center" style="text-align:center">
                                            <button type="button" :disabled="disabled3" @click="delay3()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    export default {
        data() {
            return {
                emp_code: '',
                emp_name: '',
                emp_codes: [],
                code_arr: {},
                e_emp_code: '',
                pcash_amount: '',
                Amount_error: '',
                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,
                disabled3: false,
                timeout3: null,
                adsdata: {},
                edit_name: '',
                edit_id: '',

                options: [],
                options2: [],
                accountID: {},
                LinkID: {},
                account_id: '',
                coa_id: '',
                e_account_id: '',
                e_coa_id: '',
                keyword1: '',

                close_model: '',
                close_model1: '',
                paid_id:'',
                p_limit:'',
                p_dept:'',
                p_accountid:'',
                p_remaining:'',
                paid_amount:'',
                arr:{},
            };
        },

        components: { Multiselect },
        watch: {
            keyword1(after, before) {
                this.search_by_name();
            }
        },
        methods: {
        editp(id){
        this.paid_id=id;
         axios.get('./accounts/get_petty_access/'+this.paid_id)
              .then((data) => {
                    this.arr=data.data;
                        this.p_limit=Number(this.arr.limit);
                         this.p_dept=this.arr.dept;
                         this.p_accountid=this.arr.accountid;
                         this.p_remaining=Number(this.arr.remaining);
                        })

        },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.submit_patty_user();
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.link_coaPcash();
            },
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.submit_paid();
            },
            submit_paid(){

            if(this.paid_id=='' || this.p_limit=='' ||this.p_dept=='' || this.p_accountid=='' || this.p_remaining=='' || this.paid_amount=='' ){
             this.$toastr.e("Please fill required fields!", "Caution!");
            }
            else {
                if(this.p_remaining<this.paid_amount){
                this.$toastr.e("Paid Amount is greater than your remaining amount!", "Caution!");
                }
                else
                {
                axios.get('./accounts/submit_paid_cash/'+this.paid_id+'/'+this.paid_amount)
              .then((data) => {

                          if(data.data=='Status Update'){
                          this.getResult();
                           this.$toastr.s("Paid Amount To relevent Department", "Congratulations");
                          }
                        })
                }


            }

            },
            fetch_pcashid(id, name) {
                this.edit_name = name;
                this.edit_id = id;
            },
            link_coaPcash() {
                if (this.account_id == '' || this.coa_id == '') {
                    if (this.account_id == '') {
                        this.e_account_id = "Please select Account ID";
                    }
                    if (this.coa_id == '') {
                        this.e_coa_id = "Please select Chard Of Account ID";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");

                }
                else {
                    axios.post('accounts/submit_linkcoa_pcash', {
                        pcash_id: this.edit_id,
                        account_id: this.account_id,
                        coa_id: this.coa_id,
                    })
                        .then((data) => {
                            if (data.data == "PettyCAsh Linked") {
                                this.$toastr.s("Petty Cash Successfully Linked With Accounts!", "Congratulations!");
                                this.getResult();
                                this.edit_id = '';
                                this.account_id = '';
                                this.coa_id = '';
                                this.e_account_id = '';
                                this.e_coa_id = '';
                                this.close_model1 = '';
                            }
                            else {
                                this.$toastr.e("Petty Cash Did Not Linked With Accounts!", "Error!");
                            }
                        })
                }
            },
            get_name() {
                axios.get('./accounts_employee_name/' + this.emp_code)
                    .then(data => {
                        this.emp_name = data.data
                        if (this.emp_name == "") {
                            this.e_emp_code = "Employee name does not exist"
                        }
                    })
            },
            search_by_name(page = 1) {
                axios.get('./accounts/filter_pcash_access/?page=' + page, { params: { name: this.keyword1 } })
                    .then(data => this.adsdata = data.data)
                    .catch(error => { });
            },
            submit_patty_user() {
                if (this.emp_code == '' || this.pcash_amount == '' || this.emp_name == '') {
                    if (this.pcash_amount == '') {
                        this.Amount_error = "Please enter Petty Cash amount";
                    }
                    if (this.emp_code == '') {
                        this.e_emp_code = "Please select employee code";
                    }
                    if (this.emp_name == '') {
                        this.$toastr.e("Employee name does not exist, Select a different employee or update the profile!", "Caution!");
                    }
                    else {
                        this.$toastr.e("Please fill required fields!", "Caution!");
                    }
                }
                else {
                    axios.post('./accounts/submit_pettyCash', {
                        emp_name: this.emp_name,
                        emp_code: this.emp_code,
                        pcash_amount: this.pcash_amount,
                    })
                        .then(data => {
                            if (data.data == "PettyCAsh Added") {
                                this.$toastr.s("Petty Cash Added Successfully", "Congratulations!");
                                this.getResult();
                                this.emp_code = '';
                                this.emp_name = '';
                                this.pcash_amount = '';
                                this.close_model = '';
                            }
                            else {
                                this.$toastr.e("Already Exists Employee Code In PettyCash Access", "Error!");
                            }
                        })
                }
            },
            getResult(page = 1) {
                axios
                    .get("accounts/pcash_access_detail/?page=" + page)
                    .then((response) => (this.adsdata = response.data))
                    .catch((error) => { });
            },
        },

        mounted() {
            this.getResult();
            axios.get('accounts/fetch_pettycash_head')
                .then(response => {
                    this.accountID = response.data
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.accountID.length; i++) {
                        this.options.push($this.accountID[i].ID+'_'+$this.accountID[i].AccountName);
                    }
                })
                .catch(error => { });
axios.get('accounts/fetch_expense_head')
                .then(response => {
                    this.LinkID = response.data
                    this.options2 = [];

                    var $this = this;
                    for (var i = 0; i < $this.LinkID.length; i++) {
                        this.options2.push($this.LinkID[i].ID+'_'+$this.LinkID[i].AccountName);
                    }
                })
                .catch(error => { });
            axios.get('registered_empcode1')
                .then((response) => {
                    this.code_arr = response.data
                    this.emp_codes = [];

                    var $this = this;
                    for (var i = 0; i < $this.code_arr.length; i++) {
                        this.emp_codes.push($this.code_arr[i].EmployeeCode);
                    }
                })
                .catch((error) => { });
        },
    };

</script>
