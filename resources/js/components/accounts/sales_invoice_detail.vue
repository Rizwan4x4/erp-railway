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
                                Sale Invoice Details
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div class="card-body border-bottom">
                                <h4 class="card-title">Search & Filter</h4>
                                <div class="row" style="">
                                    <div class="col-md-12">
                                        <div class="row g-1">
                                            <div class="col-md-2 col-12 mb-2 position-relative">
                                                <label class="form-label">Date From</label>
                                                <input type="date" v-model="startingdate" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <label class="form-label">Date To</label>
                                                <input type="date" class="form-control" v-model="closingdate">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <button @click="filtered_GRN()" style="background: rgb(193, 193, 193); width: 60% !important; height: 33px !important; margin-bottom: 20px; margin-top: 25px; margin-left: 10px" class="btn btn-common">Search</button>
                                            </div>
                                            <div class="col-md-6 col-12 mb-3 position-relative" style="text-align: right;margin-top: 30px;">
                                                <div class="dataTables_filter" style="margin-top:5px">
                                                    <label>
                                                        <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Vendor Name" />
                                                    </label>
                                                    <router-link to="/sales/invoice" class="dt-button add-new btn btn-primary" tabindex="0" type="button"><span>New Sale Invoice</span></router-link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; vertical-align:middle !important;">INV ID</th>
                                            <th style="text-align:center; vertical-align:middle !important;">Date</th>
                                            <th style="">Customer Name</th>
                                            <th style="text-align:center;">SubTotal</th>
                                            <th style="text-align:center;">Tax</th>
                                            <th style="text-align:center;">Delivery</th>
                                            <th style="text-align:center;">Total</th>
                                            <th style="text-align:center; vertical-align:middle !important;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td style="text-align: center; vertical-align: middle !important;">{{adsdata1.saleID}}</td>
                                            <td style="text-align: center; vertical-align: middle !important;">{{adsdata1.Dated}}</td>
                                            <td style="vertical-align: middle !important;" class="sorting_1">
                                                {{adsdata1.CustomerName}}
                                            </td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.SubTotal)}}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.Tax)}}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.ShippingCharges) }}</td>
                                            <td style="text-align:center;">{{currency}}. {{Number(adsdata1.TotalAmount)}}</td>
                                            <td style="text-align: center; vertical-align: middle !important;">
                                                <a class="me-25" @click="editgrn(adsdata1.SalesInvoiceID)" data-bs-toggle="modal" data-bs-target="#PREQ_view">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
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
        <!-- END: Content-->
        <div class="modal fade" id="PREQ_status" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata11 in get_grndata">
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
                                            <span class="invoice-number">{{get_invoice1.saleID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_grndata11.Status2=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_grndata11.Status2=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_grndata11.Status2=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
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
                                        <h6 class="mb-2">Vendor Name:</h6>
                                        <h6 class="mb-25">{{get_grndata11.vendorName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata11.DepartmentName}}</p>
                                        <p class="card-text mb-25">{{get_grndata11.ProjectName}}</p>
                                        <p class="card-text mb-25">class="badge badge-glow bg-warning">{{get_grndata11.Status}}</span></p>
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
                                            <th class="py-1">Est. Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.PoQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.RecvdQuantity}}</span>
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
                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                            <option value=""> Select Status </option>
                                            <option value="Verified">Verified</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 pt-50">
                                <button :disabled="disabled" @click="delay()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
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
                        <div class="card invoice-preview-card">
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
                                    <div class="mt-md-0 mt-2" style="min-width:25%" v-for="get_invoice1 in get_invoice" :key="get_invoice1">
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{get_invoice1.SalesInvoiceID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_invoice1.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_invoice1.Status2=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_invoice1.Status2=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_invoice1.Status2=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <hr class="invoice-spacing">
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing" v-for="get_invoice1 in get_invoice" :key="get_invoice1">
                                    <div class="col-xl-8 p-0">
                                        <h6 class="mb-2">Customer Name:</h6>
                                        <h6 class="mb-25">{{get_invoice1.CustomerName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <!-- <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">get_grndata11.DepartmentName</p>
                                        <p class="card-text mb-25">get_grndata11.ProjectName</p> -->
                                        <p class="card-text mb-25"><span class="badge badge-glow bg-warning">{{get_invoice1.Status}}</span></p>
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
                                            <th class="py-1">Ordered qty</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Rcvd Qty</th>
                                            <th class="py-1">Cost</th>
                                            <th class="py-1">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_invoice_detail1 in get_invoice_detail">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_invoice_detail1.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_invoice_detail1.SaleQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_invoice_detail1.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_invoice_detail1.SaleQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_invoice_detail1.Price}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_invoice_detail1.SubTotal}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper" v-for="get_invoice1 in get_invoice" :key="get_invoice1">
                                    <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            <!-- {{get_grndata11.Remarks}} -->
                                            {{get_invoice1.Remarks}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="max-width: 300px;">
                        <div class="invoice-total-item">
                            <p class="invoice-total-title"> SubTotal: {{currency}}. {{Number(get_invoice1.SubTotal)}}</p>
                             </div>
                                    <div class="invoice-total-item">
                            <p class="invoice-total-title">  Tax: {{currency}}. {{Number(get_invoice1.Tax)}}</p>
                             </div>
                             <div class="invoice-total-item">
                            <p class="invoice-total-title">  Delivery : {{currency}}. {{Number(get_invoice1.SaleQuantity)}}</p>
                             </div>
                             <div class="invoice-total-item">
                            <p class="invoice-total-title"> Discount: {{currency}}. {{Number(get_invoice1.Discount)}}</p>
                             </div>
                             <div class="invoice-total-item">
                            <p style="font-weight:bold" class="invoice-total-title">  Total: {{currency}}. {{Number(get_invoice1.TotalAmount)}}</p>
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
    </div>
</template>
<script>
export default {
    data() {
        return {

            adsdata: {

            },
            currency: '',
            companydetail: {},
            vendors: {},
            keyword1: '',
            vendor_name: 'All',
            status1: 'All',
            status2: 'All',
            startingdate1: '',
            closingdate1: '',
            closingdate: '',
            startingdate: '',
            get_grndata: {},
            get_grndata1: {},

            count_users: {},

            up_sts: '',
            get_id: '',
            disabled: false,
            timeout: null,
            get_invoice: {},
            get_invoice_detail: {},
        }
    },
    methods: {
        filtered_GRN() {
            this.keyword1 = '';
            if (this.startingdate == '') {
                this.startingdate1 = "00-00-0000";
            } else {
                this.startingdate1 = this.startingdate;
            }
            if (this.closingdate == '') {
                this.closingdate1 = "99-99-9999";
            } else {
                this.closingdate1 = this.closingdate;
            }


            axios.get("accounts/search_invoicedata/" + this.startingdate1 + "/" + this.closingdate1)
                .then(data => {

                    this.adsdata = data.data
                })
                .catch(error => this.error = error.response.data.errors)
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.update_grnstatus();
        },
        update_grnstatus() {

            axios.get('accounts/update_grn/' + this.get_id + '/' + this.up_sts)
                .then(response => {
                    this.adsdata = response.data;
                })
        },
        editgrn(id) {
            this.get_id = id;
            axios.get('accounts/get_invoicedata/' + id)
                .then(response => {
                    this.get_invoice = response.data;
                })
            axios.get('accounts/get_invoicedata_detail/' + id)
                .then(response => {
                    this.get_invoice_detail = response.data;
                })

        },

        getResult(page = 1) {

            axios.get('accounts/sales_detail/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults() {

            axios.get('accounts/get_vendorinvoice/' + this.keyword1)
                .then(response => {

                    this.adsdata = response.data
                })
                .catch(error => {});
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
        axios.get('./accounts/count_grn')
            .then(response => this.count_users = response.data)
            .catch(error => {});

        this.getResult();
    }
}

</script>
