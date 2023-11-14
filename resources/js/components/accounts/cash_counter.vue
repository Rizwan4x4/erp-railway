<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Units Cash Counter
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="card">
                            <div class="col-sm-12 col-lg-12" style="margin:5px;">
                                <div class="dt-buttons d-inline-flex mt-50">
                                    <router-link style="float:left" to="/Accounts/units_cash" class="btn btn-primary waves-effect waves-float waves-light">Cash Supervision</router-link>
                                </div>
                                <div class="dt-buttons d-inline-flex mt-50">
                                    <router-link style="float:left" to="/Accounts/units_chq" class="btn btn-secondary waves-effect waves-float waves-light">Cheque Supervision</router-link>
                                </div>

                                <div class="dt-buttons d-inline-flex mt-50">
                                    <router-link style="float:left" to="/Accounts/pending_debit_credit" class="btn btn-success waves-effect waves-float waves-light">Credit/Debit Supervision</router-link>
                                </div>
                                <div class="dt-buttons d-inline-flex mt-50">
                                    <router-link style="float:left" to="/Accounts/pending_online" class="btn btn-danger waves-effect waves-float waves-light">Online Cash</router-link>
                                </div>

                                <div class="dt-buttons d-inline-flex mt-50">
                                    <router-link style="float:left" to="/Accounts/pending_adjust" class="btn btn-warning waves-effect waves-float waves-light">Suspend Entries</router-link>
                                </div>
                                <div class="dt-buttons d-inline-flex mt-50" style="float: right;margin-right: 10px">
                                    <router-link style="float:left" to="/Accounts/Sam_Voucher" class="btn btn-primary waves-effect waves-float waves-light">SAM Vouchers</router-link>
                                </div>
                            </div>

                            <div class="row" style="margin-left:5px;">
                                <div class="col-md-2 col-12">
                                    <label class="form-label">Date from <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="date" v-model="datefrom" class="form-control">
                                </div>
                                <div class="col-md-2 col-12">
                                    <label class="form-label">Date to <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input type="date" class="form-control" v-model="dateto">
                                </div>
                                <div class="col-md-1 col-12 mb-3 position-relative">
                                    <button @click="filtered_GRN()" style="margin-top: 25px;" class="btn btn-secondary">Search</button>
                                </div>
                                <div class="col-md-3 col-12 mb-3 position-relative" style="margin-top: 35px;">
                                    <h6>Today's Recovery: {{Number(get_sum.total).toLocaleString()}}</h6>
                                </div>
                                <div class="col-md-2 col-12 mb-3 position-relative" style="margin-top: 35px;">
                                    <h6>Cash Amount: {{Number(get_sum.cash).toLocaleString()}}</h6>
                                </div>
                                <div class="col-md-2 col-12 mb-3 position-relative" style="margin-top: 35px;">
                                    <h6>Other's Amount: {{Number(get_sum.chq).toLocaleString()}}</h6>
                                </div>
                            </div>
                            <div class="row" style="margin-left: 5px;" v-if=" hasPermission('Units-Management units-data supervision')">
                                <div class="col-sm-12 col-md-2">
                                    <input type="date" @change="searchuser()" v-model="select_date" class="form-control" style="float: left;margin-right:10px" />
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <select id="UserRole" @change="searchuser()" v-model="select_status" class="form-select ms-50 " style="float: left;margin-right:10px">
                                        <option value="Both">Cash & Cheque</option>
                                        <option value="Cash">Cash only</option>
                                        <option value="Cheque">Cheque only</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <select id="UserRole" @change="searchuser()" v-model="select_user" class="form-select ms-50 " style="float: left;margin-right:10px">
                                        <option value="All">All users</option>
                                        <option v-for='users1 in users' :value='users1.UserID'>{{users1.Name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <button style="float:left" :disabled="disabled1" @click="proceed_report()" class="btn btn-primary waves-effect waves-float waves-light">Proceed</button>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important; margin-top:10px;">
                                <table class="table table-hover" style="font-size:10px !important">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Sr.No</th>
                                            <th class="sticky-th-center">Date</th>
                                            <th class="sticky-th-center">Receipt No<br />& Pay. Type</th>
                                            <th class="sticky-th-center">File/Plot No</th>
                                            <th class="sticky-th-left">Name</th>
                                            <th class="sticky-th-center">Type</th>
                                            <th class="sticky-th-center">Module</th>
                                            <th class="sticky-th-center">Block &<br />Plot Type</th>
                                            <th class="sticky-th-center">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="(adsdata1,index) in adsdata">
                                            <td class="td-center" tabindex="0">{{sumStats1(index,1) }}</td>
                                            <td class="td-center">{{adsdata1.DateTime}}</td>
                                            <td class="td-center">{{adsdata1.ReceiptNo}}<br />{{adsdata1.PaymentType}}</td>
                                            <td class="td-center">{{adsdata1.File_Plot_No}}</td>
                                            <td class="td-left">{{adsdata1.Name}}</td>
                                            <td class="td-center">{{adsdata1.Type}}</td>
                                            <td class="td-center">{{adsdata1.Module}}</td>
                                            <td class="td-center">{{adsdata1.Block}}<br />{{adsdata1.Plot_Type}}</td>
                                            <td class="td-center">Rs. {{Number(adsdata1.Amount).toLocaleString()}}/-</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import MaskedInput from 'vue-masked-input'
    export default {
        data() {
            return {
                adsdata: {},
                companydetail: {},
                paymentVchrs: {},
                keyword1: '',
                disabled1: false,
                timeout1: null,
                get_sum: {},
                users: {},
                select_user: 'All',
                select_status: 'Both',
                select_date: new Date().toJSON().slice(0, 10),
                datefrom: '',
                dateto: '',
            }
        },
        components: {
            MaskedInput
        },
        methods: {
            sumStats1(num1, num2) {
                return parseInt(num1) + parseInt(num2);
            },
            filtered_GRN() {
                this.select_date = '';
                this.select_status = 'Both';
                this.select_user = 'All';

                this.disabled1 = true;
                if (this.dateto == '' || this.datefrom == '') {
                    this.$toastr.e("Please select Both Dates!", "Caution!");
                }
                else {
                    axios.get("accounts/search_units_cash_date/" + this.datefrom + "/" + this.dateto + '/' + this.select_status + '/' + this.select_user)
                        .then(data => {
                            this.adsdata = data.data;
                            this.disabled1 = false;
                        })
                        .catch(error => this.error = error.response.data.errors)
                    axios.get('./accounts/get_counter_sum_datewise/' + this.datefrom + "/" + this.dateto + '/' + this.select_status + '/' + this.select_user)
                        .then(response => this.get_sum = response.data)
                }
            },
            getResult() {
                axios.get('accounts/all_receipt_detail/' + this.select_date + '/' + this.select_status + '/' + this.select_user)
                    .then(response => {
                        this.adsdata = response.data;
                    })
                    .catch(error => { });
                axios.get('./accounts/get_cashcounter_user')
                    .then(response => this.users = response.data)
            },
            searchuser() {
                this.datefrom = '';
                this.dateto = '';
                if (this.select_date == '') {
                    this.select_date = new Date().toJSON().slice(0, 10);
                }
                this.disabled1 = true;
                axios.get('accounts/search_r_byname/' + this.select_date + '/' + this.select_status + '/' + this.select_user)
                    .then(response => {
                        this.adsdata = response.data;
                        this.disabled1 = false;
                    })
                    .catch(error => console.log(error));
                axios.get('./accounts/get_counter_sum1/' + this.select_date + '/' + this.select_status + '/' + this.select_user)
                    .then(response => this.get_sum = response.data)

            },
            proceed_report() {
                this.disabled1 = true;
                axios.get('./accounts/proceed_report')
                    .then(data => {
                        if (data.data == "Status updated!") {
                            this.$toastr.s("Cash and cheque successfully transfered for supervision!", "Congratulations!");
                            this.getResult();
                            this.disabled1 = false;
                        }
                    })
            },
            getResults() {
                this.disabled1 = true;
                axios.get('accounts/paymentsearch_name/' + this.keyword1)
                    .then(response => {
                        this.adsdata = response.data;
                        this.disabled1 = false;
                    })
                    .catch(error => console.log(error));
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        mounted() {
            axios.get('./accounts/get_counter_sum1/' + this.select_date + '/' + this.select_status + '/' + this.select_user)
                .then(response => this.get_sum = response.data)
            this.getResult();
        }
    }

</script>
