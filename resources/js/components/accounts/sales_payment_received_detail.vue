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
<li class="breadcrumb-item active">Receipt vouchers</li>
</ol>
</div>
</div>
<div class="content-body">
<!-- users list start -->
<section class="app-user-list">
<div clas="card" style="background-color:white !important">
<div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
<div class="col-sm-5 col-lg-6 ps-xl-75 ps-0">
<div class="dt-buttons d-inline-flex mt-50">
<router-link v-if="hasPermission('Accounting Receipt-voucher create-rv')" style="float:left" to="/sales/create_received_voucher2" class="btn btn-primary waves-effect"> + New Receipt Voucher</router-link>
</div>
 <div class="dt-buttons d-inline-flex mt-50">
                                        <router-link v-if="hasPermission('Accounting Receipt-voucher pdc')" style="float:left" to="/sales/PdcReceivable" class="btn btn-primary waves-effect">Pdc Receivable Detail</router-link>
                                    </div>
</div>
<div class="col-sm-7 col-lg-6 ps-xl-75 ps-0">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 col-12 mb-2">
                                            <label class="form-label">Date From</label>
                                            <input type="date" v-model="startingdate" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <label class="form-label">Date To</label>
                                            <input type="date" class="form-control" v-model="closingdate">
                                        </div>
                                        <div class="col-md-2 col-12 mb-3">
                                            <button @click="filtered_GRN()" style="margin-top: 25px;" class="btn btn-secondary">Search</button>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3">
                                        <label>
                                            <input style="margin-top: 27px !important;" autocomplete="off"  type="text" name="keyword1" v-model="keyword1" class="form-control"  placeholder="Search By Name / Po / RVID" />
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
    <th>ID</th>
    <th>AccountID</th>
     <th>Received From</th>
    <th>Payment Method</th>
     <th>Against</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<tr class="odd" v-for="adsdata1 in adsdata.data">
    <td class=" control" tabindex="0" style="display: none;"></td>
    <td class="sorting_1">{{adsdata1.VoucherDate}}</td>
    <td>{{adsdata1.RVID}}</td>
    <td>{{adsdata1.AccountID}}</td>
     <td>
        <div class="d-flex justify-content-left align-items-center">
            <div class="d-flex flex-column">
                <h6 class="user-name text-truncate mb-0">{{adsdata1.PaymentAgainst}}</h6>
            </div>
        </div>
    </td>
    <td>{{adsdata1.MethodType}}</td>
    <td>{{adsdata1.InvoiceNumber}}</td>
   <td>Rs. {{Number(adsdata1.Amount)}}/-</td>

                                            <td >
                                                <span v-if="adsdata1.Status=='Approved'" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                <span v-else-if="adsdata1.Status=='Not Verified'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span>
                                            </td>
    <td>
        <div class="d-flex align-items-center col-actions">
                   <a class="me-25" data-bs-toggle="modal" @click="editRV(adsdata1.ReceivedVoucherID)" data-bs-target="#viewRV">
    <i class="fa-solid fa-eye"></i>
</a>
            <div class="dropdown"><a class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2 text-body">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="12" cy="5" r="1"></circle>
                        <circle cx="12" cy="19" r="1"></circle>
                    </svg></a>
                <div class="dropdown-menu dropdown-menu-end">
                <a v-bind:href="`received_letter/${adsdata1.ReceivedVoucherID}/${adsdata1.RVID}`" target="__blank" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download font-small-4 me-50">
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
<div style="text-align:center;padding-top:20px; display: flex; justify-content: center; align-items: center;">
<pagination  :limit="limit" :data="adsdata" v-if="pageNo==1" @pagination-change-page="getResult"></pagination>
<pagination :limit="limit" :data="adsdata" v-else-if="pageNo==2" @pagination-change-page="filtered_GRN"></pagination>
<pagination :limit="limit" :data="adsdata" v-else-if="pageNo==3" @pagination-change-page="getResults"></pagination>
</div>
</div>
</section>
<!-- users list ends -->
</div>
</div>
</div>
<!-- END: Content-->
<div class="modal fade" id="viewRV" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="rcVouchers1 in rcVouchers">
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
                                            <span class="invoice-number">{{rcVouchers1.RVID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{rcVouchers1.VoucherDate}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Received Voucher</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="col-md-12">
                                <table style="width:100%;">
                                    <thead style="float:left; width:100%;">
                                        <tr>
                                            <td style="width:29%"><strong>Received Against:</strong></td>
                                            <td style="width:32%">{{rcVouchers1.ReceivedAgainst}}</td>
                                            <td style="width:29%"><strong>Sales Person:</strong></td>
                                            <td style="width:32%">{{rcVouchers1.SalesPerson}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Account ID:</strong></td>
                                            <td>{{rcVouchers1.AccountID}}</td>
                                            <td><strong>Amount:</strong></td>
                                            <td>{{Number(rcVouchers1.Amount)}}/-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Method:</strong></td>
                                            <td>{{rcVouchers1.MethodType}}</td>
                                            <td><strong>Method Ac. ID:</strong></td>
                                            <td>{{rcVouchers1.MethodAccountID}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Invoice Number:</strong></td>
                                            <td>{{rcVouchers1.InvoiceNumber}}</td>
                                        </tr>
                                        <tr></tr>
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
                                            {{rcVouchers1.Naration}}
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
</template>
<script>
import MaskedInput from 'vue-masked-input'
export default {
data() {
return {
limit:5,
adsdata: {

},
 companydetail: {},
                rcVouchers: {},
success: '',
startingdate: (new Date().toJSON().slice(0, 4)) - 1 + new Date().toJSON().slice(4, 10),
                closingdate: new Date().toJSON().slice(0, 10),
keyword1: '',
pageNo:1,






}
},
components: {
MaskedInput
},
methods: {
editRV(id) {
                axios.get('accounts_get_RV/' + id)
                    .then(response => {
                        this.rcVouchers = response.data;
                    })
            },
            filtered_GRN(page = 1) {
                this.keyword1 = '';
                this.pageNo = 2;
                if (this.startingdate == '') {
                    this.startingdate = (new Date().toJSON().slice(0, 4)) - 1 + new Date().toJSON().slice(4, 10);
                }
                if (this.closingdate == '') {
                    this.closingdate = new Date().toJSON().slice(0, 10);
                }
                axios.get('search_receivedvoucher/' + this.startingdate + '/' + this.closingdate + '?page=' + page)
                    .then(data => this.adsdata = data.data)
                    .catch(error => this.error = error.response.data.errors)
            },
getResult(page = 1) {
this.pageNo=1
axios.get('accounts/received_detail/?page=' + page)
.then(response => this.adsdata = response.data)
.catch(error => {});
},
getResults(page=1) {
    this.pageNo=3
axios.get('accounts/received_vouchername/'+this.keyword1+ '?page=' + page)
.then(response =>{
    this.adsdata=response.data
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
this.getResult();
axios.get('fetch_companyDetail')
    .then(response => this.companydetail = response.data)
}
}

</script>
