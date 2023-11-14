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
                            <li class="breadcrumb-item active">Debit Note(s)
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-buttons d-inline-flex mt-50">
                                        <router-link v-if="hasPermission('Accounting debit-notes create-dn')" style="float:left" to="/purchase/create_debit_notes" class="btn btn-primary waves-effect">New Debit Notes</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" style="min-width: 400px;" name="keyword1" v-model="keyword1" class="form-control"  placeholder="Search By Invoice ID/Debit Notes ID/ Vendor Name" />
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Debit Note #</th>
                                            <th>Invoice ID</th>
                                            <th>Vendor ID</th>
                                             <th>Vendor Name</th>
                                            <th>Total Debit Amount</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1">{{adsdata1.Dated}}</td>
                                            <td>{{adsdata1.DebitNotesID}}</td>
                                            <td>{{adsdata1.InvoiceID}}</td>
                                            <td>{{adsdata1.VendorID}}</td>
                                            <td>{{adsdata1.VendorName}}</td>
                                            <td>{{Number(adsdata1.TotalDebitAmount).toLocaleString()}}</td>

                                            <td><span class="badge badge-glow bg-primary" v-if="adsdata1.Status=='Approved'">{{adsdata1.Status }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center col-actions">
                                                    <a class="me-25" data-bs-toggle="modal" @click="editPV(adsdata1.ID)" data-bs-target="#viewPV">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <div class="dropdown"><a class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2 text-body">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-bind:href="`debit_note_letter/${adsdata1.ID}`" target="__blank" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download font-small-4 me-50">
                                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                                </svg>Download & Print</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
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
                                    <div class="mt-md-0 mt-2" >
                                        <h5 class="invoice-title">
                                            Debit Note ID:
                                            <span class="invoice-number">{{paymentVchrs1.DebitNotesID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper d-flex">
                                            <div class="d-flex">
                                                <p class="invoice-date-title" >Date:</p>
                                            <p  class="invoice-date mx-1">{{paymentVchrs1.Dated}}</p>
                                            </div>
                                         <div class="mx-5 d-flex">
                                            <p class="invoice-date-title" >Invoice ID:</p>
                                            <p  class="invoice-date mx-1">{{paymentVchrs1.InvoiceID}}</p>
                                         </div>
                                        </div>
                                        <div class="invoice-date-wrapper d-flex">
                                            <div class="d-flex">
                                                <p class="invoice-date-title" >Vendor ID:</p>
                                            <p  class="invoice-date mx-1">{{paymentVchrs1.VendorID}}</p>
                                            </div>
                                         <div class="mx-5 d-flex">
                                            <p class="invoice-date-title" >Vendor Name:</p>
                                            <p  class="invoice-date mx-1">{{paymentVchrs1.VendorName}}</p>
                                         </div>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                        <p class="invoice-date-title" style="width:35%">Total Debit Amount:</p>
                        <p  class="invoice-date">
                            <span  >{{Number(paymentVchrs1.TotalDebitAmount).toLocaleString()}}/-</span>
                        </p>
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
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Debit Note Detail</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Name</th>
                                            <th class="py-1">Sub Total</th>
                                            <th class="py-1">Debit Amount</th>
                                            <th class="py-1">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="paymentVchrs_items1 in paymentVchrs_items">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{paymentVchrs_items1.ItemName}}</p>

                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(paymentVchrs_items1.SubTotal).toLocaleString()}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(paymentVchrs_items1.DebitAmount)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{paymentVchrs_items1.Detail}}</p>

                                            </td>
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
                                            {{paymentVchrs1.Remarks}}
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
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
import MaskedInput from 'vue-masked-input';
export default {
    data() {
        return {
           
            adsdata: {},
            paymentVchrs: {},
            paymentVchrs_items:{},
            success: '',

            keyword1: '',







        }
    },
    components: {
        MaskedInput
    },
    methods: {


        getResult(page = 1) {
            axios.get('debit_not_detail/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults() {
            axios.get('search_debit_notes', { params: { keyword1: this.keyword1 } })
                .then(response => this.adsdata = response.data)
        },
        editPV(id) {
            axios.get('single_debit_notes/' + id)
                .then(response => {
                    this.paymentVchrs = response.data;
                })
            axios.get('single_debit_notesitems/' + id)
                .then(response => {
                    this.paymentVchrs_items = response.data;
                })
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {

     
        this.getResult();
    }
}

</script>
