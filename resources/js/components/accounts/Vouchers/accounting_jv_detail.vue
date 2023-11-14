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
                            <li class="breadcrumb-item active">Journal Voucher Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px"
                                class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-buttons d-inline-flex mt-50">
                                        <router-link v-if="hasPermission('Accounting journal_voucher create-jv')" style="float:left" to="/accounting/create_journal_voucher"
                                            class="btn btn-primary waves-effect">Create Journal Voucher</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div
                                        class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <input type="text" name="keyword1" v-model="keyword1"
                                            class="form-control" placeholder="Search By JV ID/Amount" />

                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input @change="search_byDate" type="date" v-model="datefrom"
                                                        class="form-control" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input @change="search_byDate" type="date" v-model="dateto"
                                                        class="form-control" />
                                                </label>
                                            </div>
                                        </div>

                                        <div class="invoice_status ms-sm-2"><select id="UserRole"
                                                class="form-select ms-50 text-capitalize" v-model="status1"
                                                @change="filter_byStatus()">
                                                <option value="All"> Select Status </option>
                                                <option value="Pending" class="text-capitalize">Pending</option>
                                                <option value="Approved" class="text-capitalize">Approved</option>
                                            </select></div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Issued Date</th>
                                            <th>Narration</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1"><a class="fw-bold"> {{ adsdata1.JVID }}</a></td>
                                            <td>{{ adsdata1.JVDate }}</td>
                                            <td>
                                                {{ adsdata1.Narration }}
                                            </td>
                                            <td>Rs.
                                                {{ Number(adsdata1.TransactionAmount) }}/-
                                            </td>

                                            <td >
                                                <span v-if="adsdata1.Status == 'Approved'"
                                                    class="badge badge-glow bg-primary">{{ adsdata1.Status }}</span>
                                                <span @click="editJV(adsdata1.JournalVoucherID)" data-bs-target="#viewJV2"
                                                    data-bs-toggle="modal" v-else-if="adsdata1.Status == 'Pending'"
                                                    class="badge badge-glow bg-info">{{ adsdata1.Status }}</span>
                                            </td>
                                            <!-- <td v-else>
                                                <span v-if="adsdata1.Status == 'Approved'"
                                                    class="badge badge-glow bg-primary">{{ adsdata1.Status }}</span>
                                                <span v-else-if="adsdata1.Status == 'Pending'"
                                                    class="badge badge-glow bg-info">{{ adsdata1.Status }}</span>
                                            </td> -->
                                            <td>
                                                <div class="d-flex align-items-center col-actions">

                                                    <a  class="me-25" data-bs-toggle="modal"
                                                        @click="editJV(adsdata1.JournalVoucherID)" data-bs-target="#viewJV">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <div class="dropdown"><a v-if="hasPermission('Accounting journal_voucher edit-jv')"
                                                            class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-more-vertical font-medium-2 text-body">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-bind:href="`jv_letter/${adsdata1.JournalVoucherID}/${adsdata1.JVID}`"
                                                                target="__blank" class="dropdown-item"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-download font-small-4 me-50">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
                                                                    </path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>Download & Print</a>
                                                            <router-link v-if="adsdata1.Status == 'Pending'"
                                                                style="float:left"
                                                                :to="'/accounting/accounting_edit_jv/' + adsdata1.JournalVoucherID"
                                                                class="dropdown-item"><i
                                                                    class="fa-solid fa-pen-to-square"></i>
                                                                Edit</router-link>




                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" v-if="pageNo == 1" @pagination-change-page="getResult"
                                    :limit="limit"></pagination>
                                <pagination :data="adsdata" v-if="pageNo == 2" @pagination-change-page="search_byDate"
                                    :limit="limit"></pagination>
                                <pagination :data="adsdata" v-if="pageNo == 3" @pagination-change-page="filter_byStatus"
                                    :limit="limit"></pagination>
                                <pagination :data="adsdata" v-if="pageNo == 4" @pagination-change-page="getResults"
                                    :limit="limit"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <div class="modal fade" id="viewJV" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="jurnalVchrs1 in jurnalVchrs">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">
                                                {{ companydetail1.company_name }}</h3>
                                        </div>
                                        <p class="card-text mb-25">Address: {{ companydetail1.company_address }} , </p>
                                        <p class="card-text mb-25">City: {{ companydetail1.city }} -
                                            {{ companydetail1.country }}</p>
                                        <p class="card-text mb-0">Phone: {{ companydetail1.phone_number }}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2" style="min-width:30%">
                                        <h5 class="invoice-title">
                                            JV ID:
                                            <span class="invoice-number">{{ jurnalVchrs1.JVID }}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{ jurnalVchrs1.JVDate }}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:45%">Amount:</p>
                                            <p style="width:50%" class="invoice-date">
                                                {{ Number(jurnalVchrs1.TransactionAmount) }}/-</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="jurnalVchrs1.Status == 'Approved'"
                                                    class="badge badge-glow bg-primary">Approved</span>

                                                <span v-if="jurnalVchrs1.Status == 'Pending'"
                                                    class="badge badge-glow bg-info">Pending</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Journal Voucher</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Account ID</th>
                                            <th>Account Name</th>
                                            <th>Narration</th>
                                            <th>Credit Amount</th>
                                            <th >Debit Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="jvDetails1 in jvDetails">
                                            <td>{{ jvDetails1.AccountID }}</td>
                                            <td>{{ jvDetails1.AccountName }}</td>
                                            <td>{{ jvDetails1.Narration }}</td>
                                            <td style="text-align:center">{{ Number(jvDetails1.credit_amount) }}</td>
                                            <td style="text-align:center">{{ Number(jvDetails1.debit_amount) }}</td>

                                        </tr>
                                    </tbody>
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
                                            {{ jurnalVchrs1.Narration }}
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
        <div class="modal fade" id="viewJV2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card invoice-preview-card" v-for="jurnalVchrs1 in jurnalVchrs">
                        <div class="card-body invoice-padding pb-0">
                            <!-- Header starts -->
                            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                    <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                        <h3 class="text-primary invoice-logo" style="margin-left: 0px;">
                                            {{ companydetail1.company_name }}</h3>
                                    </div>
                                    <p class="card-text mb-25">Address: {{ companydetail1.company_address }} , </p>
                                    <p class="card-text mb-25">City: {{ companydetail1.city }} -
                                        {{ companydetail1.country }}</p>
                                    <p class="card-text mb-0">Phone: {{ companydetail1.phone_number }}</p>
                                </div>
                                <div class="mt-md-0 mt-2" style="min-width:30%">
                                    <h5 class="invoice-title">
                                        JV ID:
                                        <span class="invoice-number">{{ jurnalVchrs1.JVID }}</span>
                                    </h5>
                                    <div class="invoice-date-wrapper row">
                                        <p class="invoice-date-title" style="width:30%">Date:</p>
                                        <p style="width:70%" class="invoice-date">{{ jurnalVchrs1.JVDate }}</p>
                                    </div>
                                    <div class="invoice-date-wrapper row">
                                        <p class="invoice-date-title" style="width:45%">Amount:</p>
                                        <p style="width:50%" class="invoice-date">
                                            {{ Number(jurnalVchrs1.TransactionAmount) }}/-</p>
                                    </div>
                                    <div class="invoice-date-wrapper row">
                                        <p class="invoice-date-title" style="width:35%">Status:</p>
                                        <p style="width:65%" class="invoice-date">
                                            <span v-if="jurnalVchrs1.Status == 'Approved'"
                                                class="badge badge-glow bg-primary">Approved</span>

                                            <span v-if="jurnalVchrs1.Status == 'Pending'"
                                                class="badge badge-glow bg-info">Pending</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Header ends -->
                        </div>
                        <div class="divider">
                            <div class="divider-text" style="font-size: 24px;font-weight: 900;">Journal Vouchers</div>
                        </div>
                        <!-- Address and Contact starts -->
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Account ID</th>
                                        <th>Account Name</th>
                                        <th >Narration</th>
                                        <th >Credit Amount</th>
                                        <th >Debit Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="jvDetails1 in jvDetails">
                                        <td>{{ jvDetails1.AccountID}}</td>
                                        <td>{{ jvDetails1.AccountName}}</td>
                                        <td>{{ jvDetails1.Narration}}</td>
                                        <td >{{ Number(jvDetails1.credit_amount) }}</td>
                                        <td>{{ Number(jvDetails1.debit_amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Address and Contact ends -->
                        <div class="card-body invoice-padding pb-0">
                            <div class="row invoice-sales-total-wrapper">
                                <div class="col-md-12 order-md-1 order-2 mt-md-0 mt-3">
                                    <p class="card-text mb-0">
                                        <span class="fw-bold">Narration:</span>
                                    </p>
                                    <p>
                                        {{ jurnalVchrs1.Narration }}
                                    </p>
                                </div>
                        </div>
                        <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <input hidden type="text" v-model="jv_id" />
                                        <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                            <option value=""> Select Status </option>

                                            <option value="Approved">Approved</option>

                                        </select>
                                        <span style="color: #DB4437; font-size:11px;"
                                            v-if="up_sts == ''">{{ e_up_sts }}</span>
                                    </div>

                            </div>
                            <div class="row">
                            <div class="col-md-12 d-flex justify-content-end order-md-2 order-1"
                                style="padding-right: 50px;margin-bottom: 10px;margin-top:10px">
                                <button :disabled="disabled1" @click="delay1()" type="submit"
                                    class="btn btn-primary me-1" data-bs-dismiss="modal"
                                    aria-label="Close">Update</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancle
                                </button>
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
</template>
<script>

export default {
    data() {
        return {
            adsdata: {},
            status1: 'All',
            success: '',
            up_sts: '',
            datefrom: '',
            pageNo: 1,
            dateto: '',
            e_up_sts: '',
            jv_id: '',
            keyword1: '',
            companydetail: {},
            limit: 5,
            jurnalVchrs: [],
            jvDetails: {},
            disabled1: false,
            timeout1: null,
        }
    },
    methods: {
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.update_preq_status();
        },
        update_preq_status() {
            if (this.up_sts == '' || this.jv_id == '') {
                this.$toastr.e("Please fill required fields!", "Caution!");
                if (this.up_sts == '') {
                    this.e_up_sts = "Select status";
                }
            }
            else {
                axios.post('./accounts/update_jv', {
                    jv_id: this.jv_id,
                    sts: this.up_sts,
                })
                    .then(data => {
                        if (data.data.data == "Status updated!") {
                            this.$toastr.s("Status updated successfully!", "Congratulations");
                            this.getResult();
                            this.jv_id = "";
                            this.up_sts = "";
                        }
                        else {
                            this.$toastr.e(data.data.data, "Caution!");
                        }
                    })
            }
        },
        editJV(id) {
            this.jurnalVchrs = [];
            axios.get('accounts_get_JurVchr/' + id)
                .then(response => {
                    this.jurnalVchrs.push(response.data.data);
                    this.jv_id = this.jurnalVchrs[0].JournalVoucherID;
                })
            axios.get('accounts_get_JVdetail/' + id)
                .then(response => {
                    this.jvDetails = response.data.data;
                })
        },

        getResult(page = 1) {
         this.pageNo=1
            axios.get('accounts/jv_detail/?page=' + page)
                .then(response => this.adsdata = response.data.data)
                .catch(error => { });
        },
        filter_byStatus(page = 1) {
            this.pageNo=3
            axios.get('accounts/jv_searchbyfilter/' + this.status1 + "/?page=" + page)
                .then(response => {
                    this.adsdata = response.data.data;
                    this.pageNo = 3
                })
        },
        search_byDate(page = 1) {
            this.pageNo=2
            axios.get('accounts/jv_searchdate/' + this.datefrom + '/' + this.dateto + "/?page=" + page)
                .then(response => {
                    this.adsdata = response.data.data;
                    this.pageNo = 2
                })
        },
        getResults(page=1) {
            this.pageNo=4
            axios.get('search_journals/?page='+page, { params: { keyword1: this.keyword1 } })
                .then(response => {
                    this.adsdata = response.data.data;

                })
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();

        }
    },
    mounted() {
        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)
      
        this.getResult();
    }
}

</script>
