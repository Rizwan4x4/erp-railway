<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Payment Vouchers
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-9 col-lg-9 ps-xl-75 ps-0">
                                    <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2 col-12">
                                                    <label class="form-label">Date From <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                                    <input style="width: 115%;" type="date" v-model="datefrom" class="form-control">
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <label class="form-label">Date To <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                                    <input style="width: 115%;" type="date" class="form-control" v-model="dateto">
                                                </div>
                                                <div class="col-md-1 col-12" style="padding-top: 27px;">
                                                    <button @click="filtered_GRN()" class="btn btn-secondary">Search</button>
                                                </div>
                                                <div class="col-md-3 col-12" style="padding-top: 27px;">
                                                    <input v-model="keyword1" class="form-control" placeholder="Search By Payee Name" />
                                                </div>
                                                <div class="col-md-4 col-12" style="padding-top: 27px;">
                                                    <input v-model="keyword2" class="form-control" placeholder="PO, Invoice or JV No or PVID." />
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3 ps-xl-75 ps-0">
                                            <div class="dt-buttons d-inline-flex mt-50">
                                                <router-link v-if="hasPermission('Accounting Payment-voucher pdc')" to="/accounting/PdcPayable" class="btn btn-primary waves-effect">PDC Payables</router-link>
                                            </div>
                                            <div class="dt-buttons d-inline-flex mt-50">
                                                <router-link v-if="hasPermission('Accounting Payment-voucher create-pv')" to="/purchase/create_payment_voucher" class="btn btn-primary waves-effect">+ New P. Voucher</router-link>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="overflow-x: initial !important;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="sticky-th-center col-md-2">Date</th>
                                                    <th class="sticky-th-center col-md-2">ID</th>
                                                    <th class="sticky-th-center col-md-2">AccountID</th>
                                                    <th class="sticky-th-center col-md-2">Payee Name</th>
                                                    <th class="sticky-th-center col-md-2">Payment Method</th>
                                                    <th class="sticky-th-center col-md-2">Against</th>
                                                    <th class="sticky-th-center col-md-2">Amount</th>
                                                    <th class="sticky-th-center col-md-2">Status</th>
                                                    <th class="sticky-th-center col-md-2">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="adsdata1 in adsdata.data">
                                                    <td class="td-center">{{adsdata1.VoucherDate}}</td>
                                                    <td class="td-center">{{adsdata1.PVID}}</td>
                                                    <td class="td-center">{{adsdata1.AccountID}}</td>
                                                    <td class="td-center">
                                                        <div class="d-flex justify-content-left align-items-center">
                                                            <div class="d-flex flex-column">
                                                                <h6 style="max-width: 298px;" class="user-name text-truncate mb-0">{{adsdata1.PaymentAgainst}}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="td-center">{{adsdata1.MethodType}}</td>
                                                    <td class="td-center">{{adsdata1.InvoiceNumber}}</td>
                                                    <td class="td-center">Rs. {{Number(adsdata1.Amount)}}/-</td>
                                                    <td class="td-center">
                                                        <span v-if="adsdata1.Status=='Approved'" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                        <span @click="editPV(adsdata1.PaymentVoucherID)" data-bs-toggle="modal" data-bs-target="#viewPV2" v-else-if="adsdata1.Status=='Pending'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span>
                                                    </td>
                                                    <!-- <td class="td-center" v-else>
                                                        <span v-if="adsdata1.Status=='Approved'" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                        <span v-else-if="adsdata1.Status=='Pending'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span>
                                                    </td> -->
                                                    <td class="td-center">
                                                        <div class="d-flex align-items-center col-actions">
                                                            <a class="me-25" data-bs-toggle="modal" @click="editPV(adsdata1.PaymentVoucherID)" data-bs-target="#viewPV">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                            <div class="dropdown">
                                                                <a v-if="hasPermission('Accounting Payment-voucher actions')" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2 text-body">
                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                        <circle cx="12" cy="5" r="1"></circle>
                                                                        <circle cx="12" cy="19" r="1"></circle>
                                                                    </svg>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a v-bind:href="`payment_letter/${adsdata1.PaymentVoucherID}/${adsdata1.PVID}`" target="__blank" class="dropdown-item">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download font-small-4 me-50">
                                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                        </svg>Download & Print
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="text-align:center;padding-top:20px">
                                        <pagination :limit="limit" :data="adsdata" v-if="pageN == 1" @pagination-change-page="filtered_GRN"></pagination>
                                        <pagination :limit="limit" :data="adsdata" v-else-if="pageN == 2" @pagination-change-page="getResults"></pagination>
                                        <pagination :limit="limit" :data="adsdata" v-else-if="pageN == 3" @pagination-change-page="getResults1"></pagination>
                                    </div>
                                </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="viewPV" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="paymentVchrs1 in paymentVchrs">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail1.company_name}}</h3>
                                        </div>
                                        <p class="card-text mb-25">Address: {{companydetail1.company_address}} , </p>
                                        <p class="card-text mb-25">City: {{companydetail1.city}} - {{companydetail1.country}}</p>
                                        <p class="card-text mb-0">Phone: {{companydetail1.phone_number}}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2" style="min-width:30%">
                                        <h5 class="invoice-title">
                                            Payment Voucher ID:
                                            <span class="invoice-number">{{paymentVchrs1.PVID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{paymentVchrs1.VoucherDate}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="paymentVchrs1.Status=='Approved'" class="badge badge-glow bg-primary">Approved</span>

                                                <span v-if="paymentVchrs1.Status=='Pending'" class="badge badge-glow bg-info">Pending</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Payment Voucher</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <thead style="float:left; width:100%;">
                                        <tr>
                                            <td style="width:29%"><strong>Payment Against:</strong></td>
                                            <td style="width:32%">{{paymentVchrs1.PaymentAgainst}}</td>
                                            <td style="width:29%"><strong>Sales Person:</strong></td>
                                            <td style="width:32%">{{paymentVchrs1.SalesPerson}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Account ID:</strong></td>
                                            <td>{{paymentVchrs1.AccountID}}</td>
                                            <td><strong>Amount:</strong></td>
                                            <td>{{Number(paymentVchrs1.Amount)}}/-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Method:</strong></td>
                                            <td>{{paymentVchrs1.MethodType}}</td>
                                            <td><strong>Method Ac. ID:</strong></td>
                                            <td>{{paymentVchrs1.MethodAccountID}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Invoice Number:</strong></td>
                                            <td>{{paymentVchrs1.InvoiceNumber}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chq Number Number:</strong></td>
                                            <td>{{paymentVchrs1.ChqNumber}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chq Date</strong></td>
                                            <td>{{paymentVchrs1.ChqDate}}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Address and Contact ends -->
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{paymentVchrs1.Naration}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewPV2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="paymentVchrs1 in paymentVchrs">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail1.company_name}}</h3>
                                        </div>
                                        <p class="card-text mb-25">Address: {{companydetail1.company_address}} , </p>
                                        <p class="card-text mb-25">City: {{companydetail1.city}} - {{companydetail1.country}}</p>
                                        <p class="card-text mb-0">Phone: {{companydetail1.phone_number}}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2" style="min-width:30%">
                                        <h5 class="invoice-title">
                                            Rcvd Voucher ID:
                                            <span class="invoice-number">{{paymentVchrs1.PVID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{paymentVchrs1.VoucherDate}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="paymentVchrs1.Status=='Approved'" class="badge badge-glow bg-primary">Approved</span>

                                                <span v-if="paymentVchrs1.Status=='Pending'" class="badge badge-glow bg-info">Pending</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Payment Voucher</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <thead style="float:left; width:100%;">
                                        <tr>
                                            <td style="width:29%"><strong>Payment Against:</strong></td>
                                            <td style="width:32%">{{paymentVchrs1.PaymentAgainst}}</td>
                                            <td style="width:29%"><strong>Sales Person:</strong></td>
                                            <td style="width:32%">{{paymentVchrs1.SalesPerson}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Account ID:</strong></td>
                                            <td>{{paymentVchrs1.AccountID}}</td>
                                            <td><strong>Amount:</strong></td>
                                            <td>{{Number(paymentVchrs1.Amount)}}/-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Method:</strong></td>
                                            <td>{{paymentVchrs1.MethodType}}</td>
                                            <td><strong>Method Ac. ID:</strong></td>
                                            <td>{{paymentVchrs1.MethodAccountID}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Invoice Number:</strong></td>
                                            <td>{{paymentVchrs1.InvoiceNumber}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chq Number Number:</strong></td>
                                            <td>{{paymentVchrs1.ChqNumber}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chq Date</strong></td>
                                            <td>{{paymentVchrs1.ChqDate}}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Address and Contact ends -->
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{paymentVchrs1.Naration}}
                                        </p>

                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="col-6 col-md-6 order-2">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Update Status:</span>
                                            </p>
                                            <input hidden type="text" v-model="pv_id" />
                                            <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                                <option value=""> Select Status </option>

                                                <option value="Approved">Approved</option>

                                            </select>
                                            <span style="color: #DB4437; font-size:11px;" v-if="up_sts==''">{{e_up_sts}}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end order-md-2 order-1" style="padding-right: 50px;margin-bottom: 10px;margin-top:10px">
                                    <button :disabled="disabled1" @click="delay1()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                        Cancle
                                    </button>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">

                        </div>
                    </div>
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
                pageN: 1,
                limit: 10,
                adsdata: {},
                up_sts: '',
                e_up_sts: '',
                companydetail: {},
                paymentVchrs: {},
                success: '',
                pv_id: '',
                keyword1: '',
                keyword2: '',
                disabled1: false,
                timeout1: null,

                datefrom: new Date().toJSON().slice(0, 10),
                dateto: new Date().toJSON().slice(0, 10),
            }
        },
        components: {
            MaskedInput
        },
        methods: {
            filtered_GRN(page = 1) {
                this.pageN = 1;
                this.keyword1 = '';
                this.keyword2 = '';
                if (this.datefrom == '' || this.dateto == '') {
                    this.$toastr.e("Please select Both Dates!", "Caution!");
                }
                else {
                    axios.get("accounts/search_payment_date/" + this.datefrom + "/" + this.dateto + '/?page=' + page)
                        .then(data => {
                            this.adsdata = data.data;
                        })
                        .catch(error => this.error = error.response.data.errors)
                }
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_preq_status();
            },
            update_preq_status() {
                if (this.up_sts == '' || this.pv_id == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.up_sts == '') {
                        this.e_up_sts = "Select status";
                    }
                }
                else {
                    axios.post('./accounts/update_pv', {
                        pv_id: this.pv_id,
                        sts: this.up_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                this.filtered_GRN();
                                this.pv_id = "";
                                this.up_sts = "";
                            }
                        })
                }
            },
            editPV(id) {
                axios.get('accounts_get_PayVchr/' + id)
                    .then(response => {
                        this.paymentVchrs = response.data;
                        this.pv_id = response.data[0].PaymentVoucherID;
                    })
            },
            getResults(page = 1) {
                this.keyword2 = '';
                this.dateto = new Date().toJSON().slice(0, 10);
                this.datefrom = '2022-01-01';
                axios.get('accounts/paymentsearch_name/' + this.keyword1 + '/?page=' + page)
                    .then(response => {
                        this.adsdata = response.data;
                        this.pageN = 2;
                    })
                    .catch(error => console.log(error));
            },
            getResults1(page = 1) {
                this.keyword1 = '';
                this.dateto = new Date().toJSON().slice(0, 10);
                this.datefrom = '2022-01-01';
                axios.get('accounts/paymentsearch_number/' + this.keyword2 + '/?page=' + page)
                    .then(response => {
                        this.adsdata = response.data;
                        this.pageN = 3;
                    })
                    .catch(error => console.log(error));
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            },
            keyword2(after, before) {
                this.getResults1();
            }
        },
        mounted() {
            this.filtered_GRN();



            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
        }
    }

</script>
