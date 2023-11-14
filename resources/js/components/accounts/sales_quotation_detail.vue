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
                                Quotations Detail
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
                                        <router-link style="float:left" to="/sales/quotation" class="btn btn-primary waves-effect">Create Quotation</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1" style="width: 40%">
                                            <div class="dataTables_filter" style="margin-top:5px;">
                                                <label>
                                                    <input style="width:120%" type="text" v-model="keyword1" class="form-control" placeholder="Search By Customer Name" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr style="text-align:center">
                                            <th>ID</th>
                                            <th style="text-align:left !important">Customer Name</th>
                                            <th>Issued Date</th>
                                            <th>Sub Total</th>
                                            <th>Tax</th>
                                            <th>Delivery</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td style="text-align: center; vertical-align: middle !important;">{{adsdata1.QuotationNumber}}</td>
                                            <td style="vertical-align: middle !important;" class="sorting_1">{{adsdata1.CustomerName}}</td>
                                            <td style="text-align: center; vertical-align: middle !important;">{{adsdata1.Dated}}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.SubTotal)}}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.Tax)}}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.ShippingCharges) }}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.Total)}}</td>
                                            <td style="text-align: center; vertical-align: middle !important;">
                                                <a class="me-25" @click="view_squot(adsdata1.QuotationID)" data-bs-toggle="modal" data-bs-target="#PREQ_view">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <router-link v-if="adsdata1.Status != 'Final'" style="color:black;" :to="{ name: 'sales_edit_quotation', params: { id: adsdata1.QuotationID }}" class="me-25">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </router-link>
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
            </div>
        </div>
        <div class="modal fade" id="PREQ_view" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata11 in squot_data">
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
                                    <div class="mt-md-0 mt-2" style="min-width:25%">
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{get_grndata11.QuotationNumber}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_grndata11.Status=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_grndata11.Status=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_grndata11.Status=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <hr class="invoice-spacing">
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-8 p-0">
                                        <h6 class="mb-2">Customer Name:</h6>
                                        <h6 class="mb-25">{{get_grndata11.CustomerName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <p class="card-text mb-25"><span class="badge badge-glow bg-warning">{{get_grndata11.Status}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Quantity</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Cost</th>
                                            <th class="py-1">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in squot_items">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.Quantity)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.Price)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.Total)}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{get_grndata11.Remarks}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="max-width: 300px;">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> SubTotal: {{currency}}. {{Number(get_grndata11.SubTotal)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Tax: {{currency}}. {{Number(get_grndata11.Tax)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Delivery : {{currency}}. {{Number(get_grndata11.ShippingCharges)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Discount: {{currency}}. {{Number(get_grndata11.Discount)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p style="font-weight:bold" class="invoice-total-title">  Total: {{currency}}. {{Number(get_grndata11.Total)}}</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
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
export default {
    data() {
        return {
            squot_data: {},
            squot_items: {},
            companydetail: {},
            adsdata: {},
            keyword1: '',
            currency: '',
        }
    },
    methods: {
        view_squot(id) {
            this.get_id = id;
            axios.get('accounts/get_quotationdetails/' + id)
                .then(response => {
                    this.squot_data = response.data;
                })
            axios.get('accounts/get_quotationdetails1/' + id)
                .then(response => {
                    this.squot_items = response.data;
                })
        },
        getResult(page = 1) {
            axios.get('accounts_salequot_detail/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults(page = 1) {
            axios.get('./accounts_squotation_byname/?page=' + page, { params: { name: this.keyword1 } })
                .then(response => this.adsdata = response.data)
                .catch(error => console.log(error));
        },
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {
    axios.get('get_currency').then((response) => {
            this.currency = response.data[0].Currency;
        })
        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)
        this.getResult();
    }
}

</script>
