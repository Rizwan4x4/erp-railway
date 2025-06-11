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
    <li class="breadcrumb-item active">Land Payment Module</li>
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
    <h4 class="card-title">Land Detail</h4>
    <div style="text-align: right; width: 50% !important">
        <router-link style="float: left"  to="/accounts/seller_detail" class="btn btn-outline-primary waves-effect" v-if="hasPermission('Units-Management units-data supervision')" type="button">Seller Detail</router-link>
        <router-link to="/accounts/add_land_record" style="float: left;margin-left:20px !important" v-if="hasPermission('Units-Management units-data supervision')"  class="btn btn-outline-primary waves-effect" type="button">Add Land Record</router-link>
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
    <div style="margin-bottom: 20px" class="d-flex justify-content-between align-items-center header-action smx-2 row mt-75">
        <section id="accordion-with-border">
            <div class="row">
                <div class="col-sm-12">
                    <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" style="overflow-x: initial !important">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr >

                                                <th class="reports-th-center d-flex">
                                                    <div  class="col-md-1  mb-3  mx-1">Deal No. </div>
                                                    <div  class="col-md-2  mb-3  mx-1">Seller Name</div>
                                                    <div  class="col-md-2  mb-3  mx-1">Area Bought </div>

                                                    <div  class="col-md-2  mb-3  mx-1">Total Amount </div>
                                                    <div  class="col-md-2  mb-3  mx-1">Additional<br/>Charges</div>
                                                    <div  class="col-md-1  mb-3  mx-1">Status</div>
                                                    <div  class="col-md-1  mb-3  mx-1" v-if="hasPermission('Units-Management units-data supervision')">Action </div>
                                                </th>



                                            </tr>
                                        </thead>
                                        <tbody v-for="adsdata1 in adsdata.data"  >

                                            <td  class="td-center"  >
                                                <div class="accordion accordion-border" id="accordionBorder">
                                                  <div class="accordion-item" style="border:none !important">
                                                    <div class="accordion-header  d-flex" :id="'headingBorder'+adsdata1.ID">

                                                <div class="col-md-1  mb-3 position-relative mx-1 sorting_1"><a class="fw-bold"> {{adsdata1.DealNo}}</a> </div>
                                                    <div class="col-md-2  mb-3 position-relative mx-1">{{adsdata1.SellerName}} </div>
                                                    <div class="col-md-2  mb-3 position-relative mx-1">{{Number(adsdata1.TotalArea).toLocaleString()}} </div>
                                                    <div class="col-md-2  mb-3 position-relative mx-1">
                                                        <h6 class="user-name text-truncate mb-0">{{Number(adsdata1.TotalPrice).toLocaleString()}}</h6><small class="text-truncate text-muted">{{Number(adsdata1.AcrePrice).toLocaleString()}}</small>

                                                    </div>
                                                    <div class="col-md-2  mb-3 position-relative mx-1">{{Number(adsdata1.AdditionalCharges).toLocaleString()}} </div>
                                                    <div class="col-md-1  mb-3 position-relative mx-1">

                                                    <span v-if="adsdata1.Status=='Verified'" class="badge bg-light-success">{{adsdata1.Status}}</span>
                                                    <span v-else-if="adsdata1.Status=='Pending'" @click="editgrn2(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#PREQ_status2" class="badge bg-light-primary">{{adsdata1.Status}}</span>


                                                     </div>
                                                       <a v-if="adsdata1.Status=='Verified'" target="_blank" v-bind:href="`Accounts/land_paymentdetail_letter/${adsdata1.ID}`" class="btn btn-sm">
                                                        <i class="fa-solid fa-print"></i>
                                                        </a>
                                                     <div class="col-md-1  mb-3 position-relative mx-1">
                                                     <a  class=" collapsed mx-1" @click="editReq(adsdata1.ID)" style="border: none;margin-top:5px"  type="button" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder'+adsdata1.ID" aria-expanded="false" :aria-controls="'accordionBorder'+adsdata1.ID">
                                                        <i class="fa-solid fa-circle-plus"></i>
                                                    </a>


                                                        <div class="btn-group" v-if="hasPermission('Units-Management units-data supervision')">
                                                            <a v-if="adsdata1.Status=='Verified'" data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4 mb-2"><circle cx="12" cy="12" r="1"></circle> <circle cx="12" cy="5" r="1"></circle> <circle cx="12" cy="19" r="1"></circle></svg></a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a  @click="fetch_pcashid(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#apprfinance" class="dropdown-item" v-if="adsdata1.Status=='Verified' && adsdata1.Remaining !=0">
                                                                    <i class="fa-brands fa-amazon-pay"></i>
                                                                    Pay
                                                                </a>
                                                                <a target="_blank" v-if="adsdata1.PaidAmount !=0" v-bind:href="`Accounts/landpayment_pvletter/${adsdata1.ID}`" class="btn ">
                                                                 <i class="fa-solid fa-print"></i> Print Bill
                                                                </a>

                                                            </div>
                                                        </div>

                                                      </div>


                                               </div>
                                               <div  :id="'accordionBorder'+adsdata1.ID" class="accordion-collapse collapse" :aria-labelledby="'headingBorder'+adsdata1.ID" :data-bs-parent="'#accordionBorder'+adsdata1.ID">

                                            <div class="accordion-body">
                                            <table class="table">
                                            <thead>
                                            <tr>
                                            <th  class="td-center py-1">Installment Date</th>
                                            <th  class="td-center py-1">Installment Amount</th>
                                            <th  class="td-center py-1">Installment Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                <tr v-for="get_regqdata11 in get_reqdata1">
                                                <td  class="td-center py-1">
                                                <p class="card-text fw-bold mb-25">{{get_regqdata11.InstallmentDate}}</p>
                                                <p class="card-text text-nowrap">
                                                </p>
                                                </td>
                                                <td  class="td-center py-1">
                                                 <span class="fw-bold">{{Number(get_regqdata11.InstallmentAmount).toLocaleString()}}</span>
                                                </td>
                                                <td  class="td-center py-1">
                                                    <span v-if="get_regqdata11.istatus=='paid'" class="badge bg-light-success">{{get_regqdata11.istatus}}</span>
                                                    <span v-else-if="get_regqdata11.istatus=='partial'" class="badge bg-light-info">{{get_regqdata11.istatus}}</span>
                                                    <span v-else-if="get_regqdata11.istatus=='Pending'" class="badge bg-light-primary">{{get_regqdata11.istatus}}</span>

                                                </td>

                                                </tr>
                                                </tbody>
                                                </table>
                                                </div>
                                    </div>
                                </div>
                            </div>
                                            </td>

                                            <!--  -->
                                        </tbody>



                                    </table>
                                </div>
                                <div style="text-align: center;padding-top: 20px;">
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


     <div class="modal fade" id="PREQ_status2" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="col-xl-12 col-md-12 col-12">
                            <div class="card invoice-preview-card" v-for="get_grndata8111 in get_grndata81">
                                <div class="card-body invoice-padding pb-0">
                                    <!-- Header starts -->
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">

                                        <div class="mt-md-0 mt-2" style="min-width:25%">

                                            <div class="invoice-date-wrapper row">
                                                <p class="invoice-date-title" style="width:30%">Date:</p>
                                                <p style="width:70%" class="invoice-date">{{get_grndata8111.DocDate}}</p>
                                            </div>
                                            <div class="invoice-date-wrapper row">
                                                <p class="invoice-date-title" style="width:35%">Status:</p>
                                                <p style="width:65%" class="invoice-date">

                                                    <span v-if="get_grndata8111.Status=='Pending'" class="badge badge-glow bg-warning">Pending</span>
                                                    <span v-else class="badge badge-glow bg-success">Verified</span>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                </div>

                                <div class="divider">
                                    <div class="divider-text" style="font-size: 24px;font-weight: 900;">Update Land Information Status</div>
                                </div>
                                <!-- Address and Contact starts -->
                                <div class="card-body invoice-padding pt-0">
                                    <div class="row invoice-spacing">
                                        <div class="col-xl-8 p-0">
                                            <h6 class="mb-2">Seller Name:</h6>
                                            <h6 class="mb-25">{{get_grndata8111.SellerName}}</h6>
                                        </div>
                                        <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                            <h6 class="mb-2">Moza No:</h6>
                                            <p class="card-text mb-25">{{get_grndata8111.MozaNo}}</p>
                                            <h6 class="mb-2">Maraba No:</h6>
                                            <p class="card-text mb-25">{{get_grndata8111.MarabaNo}}</p>

                                            <h6 class="mb-2">Khasra No:</h6>
                                            <p class="card-text mb-25">{{get_grndata8111.KhasraNo}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address and Contact ends -->
                                <!-- Invoice Description starts -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="py-1">Acre</th>
                                                <th class="py-1">Kanal</th>
                                                <th class="py-1">Marla</th>
                                                <th class="py-1">SqFt</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="get_grndata811 in get_grndata8">
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25">{{get_grndata811.Acre}}</p>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">{{get_grndata811.Kanal}}</span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">{{get_grndata811.Marla}}</span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">{{get_grndata811.SQFT}}</span>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                 <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="py-1">Installment Date</th>
                                                <th class="py-1">Installment Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="get_grndata711 in get_grndata7">
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25">{{get_grndata711.InstallmentDate}}</p>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">{{get_grndata711.InstallmentAmount}}</span>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <div class="card-body invoice-padding pb-0">
                                    <div class="row invoice-sales-total-wrapper">
                                        <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Litigation:</span>
                                            </p>
                                            <p class="card-text text-nowrap">
                                                {{get_grndata8111.AnyLitigation}}
                                            </p>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Remarks:</span>
                                            </p>
                                            <p class="card-text text-nowrap">
                                                {{get_grndata8111.Remarks}}
                                            </p>

                                        </div>


                                    </div>
                                    <div class="row">
                                     <div class="col-md-12 d-flex justify-content-end order-md-2 order-1">
                                            <p class="card-text mb-0" style="width:100%">
                                                <span style="width:100%" class="fw-bold">Additional Charges: {{Number(get_grndata8111.AdditionalCharges).toLocaleString()}}</span>
                                            </p>

                                            <br>
                                            <p class="card-text mb-0" style="width:100%">
                                                <span style="width:100%" class="fw-bold">Per Acre: {{Number(get_grndata8111.AcrePrice).toLocaleString()}}</span>
                                            </p>

                                            <br>
                                            <p class="card-text mb-0" style="width:100%">
                                                <span  class="fw-bold">Total Amount:  {{Number(get_grndata8111.TotalPrice).toLocaleString()}}</span>
                                            </p>

    <br>
                                        </div></div>
                                </div>
                                <!-- Invoice Description ends -->
                                <hr class="invoice-spacing">
                                <div class="col-12  mt-2 pt-50" style="text-align:left">
                                    <div class="row  mt-2 pt-50" style="margin-left:40px;text-align:left">
                                        <div class="col-6 col-md-6 ">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Update Status:</span>
                                            </p>
                                            <input hidden type="text" v-model="eget_id" />
                                            <select v-model="eup_sts" class="form-select mb-md-0 mb-2">
                                                <option value=""> Select Status </option>
                                                <option value="Verified">Verified</option>
                                            </select>
                                            <span style="color: #DB4437; font-size:11px;" v-if="eup_sts==''">{{eup_sts}}</span>
                                        </div>
                                        <div class="col-6 col-md-6">
                                            <button :disabled="disabled8" @click="delay8()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            <h5 class="text-center">Do you want to Paid Land Payment to Relevent Seller Name?</h5>
                                            <input type="text" class="form-control" hidden v-model="eget_id" />
                                            <div class="row">
                                            <div class="col-md-6">

                                                        <h6 class="invoice-to-title" style="margin-bottom:5px">Method Type:</h6>
                                                        <div class="invoice-customer">
                                                            <multiselect  style="margin-right: 10px;" v-model="method_type" :options="options2"> </multiselect>
                                                            <span style="color: #db4437; font-size: 11px" v-if="method_type== ''">{{ e_method_type }}</span>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                        <div class="invoice-customer">
                                                            <label class="form-label" for="modalAddCardNumber">Chq Date</label>
                                                            <input v-model="chq_date" type="date"  id="modalAddCardName" class="form-control" />
                                                        </div>
                                                        <div>
                                                        </div>
                                            </div>
                                                     <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                        <div class="invoice-customer">
                                                           <label class="form-label" for="modalAddCardNumber">Chq Number</label><input v-model="chq_number" type="number" id="modalAddCardName" class="form-control" />
                                                        </div>
                                                        <div>

                                            </div>
                                            </div>
                                        <div class="col-md-6">
                                            <label>Petty Cash Limit</label>
                                                <input type="text" readonly class="form-control"  v-model="p_limit" />
                                            </div>
                                             <div class="col-md-6">
                                             <label>Seller Name</label>
                                              <input type="text" readonly class="form-control" v-model="p_seller" />
                                            </div>

                                             <div class="col-md-6" >
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
    keyword1: '',
    disabled: false,
    timeout: null,

    tax_name: "",
    tax_type: "Sales",
    tax_computation: "Fixed",
    tax_amount: 0,
    tax_status: "true",
    get_reqdata1:{},

    tax_name_error: "",
    tax_type_error: "",
    tax_computation_error: "",
    Amount_error: "",

    adsdata: {},
    eget_id:'',
    get_grndata8:{},
    get_grndata81:{},
    pv_id:'',
    get_grndata7:{},
     disabled8: false,
                    timeout8: null,
                    eup_sts:'',


                    disabled3: false,
                    timeout3: null,
                    p_limit:'',
                    p_seller:'',
                    p_accountid:'',
                    p_remaining:'',
                    paid_amount:'',
                     method_type:'101001001001_Cash in Hand',
                      chq_date:'',
                chq_number:'',
                methods:{},
                options2:[],

    }
    },
    watch: {
    keyword1(after, before) {
    this.search_by_name();
    }
    },
    components: {
            Multiselect
        },
    methods: {

    fetch_pcashid(id){
               this.eget_id = id;
                axios.get('accounts/get_landinformation_data/' + id)
                        .then(response => {
                            this.get_grndata81 = response.data;
                             this.p_limit=Number(response.data[0].TotalPrice);
                             this.p_seller=response.data[0].SellerName;
                             this.p_remaining=Number(response.data[0].Remaining);
                        })
            },
                delay3() {
                    this.disabled3 = true
                    this.timeout3 = setTimeout(() => {
                        this.disabled3 = false
                    }, 5000)
                    this.submit_paid();
                },
                submit_paid(){

                    if(this.paid_amount>this.p_remaining){
                   return this.$toastr.e("Paid Amount cannot be greater then your remaining amount!", "Caution!");
                 }
                if(this.eget_id=='' || this.p_remaining=='' || this.paid_amount==''||this.method_type=='' ){
                 this.$toastr.e("Please fill required fields!", "Caution!");

                }
                else {

                    axios.post('accounts/submit_paid_landpayment',{
                        id:this.eget_id,
                        limit:this.p_remaining,
                        paid_amount:this.paid_amount,
                        dept:this.p_seller,
                        method:this.method_type,
                            chq_date:this.chq_date,
                            chq_number:this.chq_number,

                    })
                  .then((data) => {

                              if(data.data=='Updated'){
                              this.getResult();

                              this.editReq(this.eget_id);
                               this.$toastr.s("Paid Amount To relevent Department", "Congratulations");
                              }else{
                                this.$toastr.e(data.data, "Caution!");
                              }
                            })



                }

                },






       delay8() {
                    this.disabled8 = true
                    this.timeout8 = setTimeout(() => {
                        this.disabled8 = false
                    }, 5000)
                    this.update_preq_status();
                },
                update_preq_status() {
                    if (this.eup_sts == '' || this.eget_id == '') {
                        this.$toastr.e("Please fill required fields!", "Caution!");
                        if (this.eup_sts == '') {
                            this.eup_sts = "Select status";
                        }
                    }
                    else {
                        axios.post('./accounts/update_land_information', {
                            get_id: this.eget_id,
                            sts: this.eup_sts,
                        })
                            .then(data => {
                                if (data.data == "Status updated!") {
                                    this.$toastr.s("Status updated successfully!", "Congratulations");
                                    this.getResult();
                                    this.eget_id = "";
                                    this.eup_sts = "";
                                }
                                else {
                                this.$toastr.e(data.data, "error");
                                }
                            })
                    }

                },





    search_by_name(page = 1) {
    axios.get('./accounts/filter_tax/?page=' + page, { params: { name: this.keyword1 } })
    .then(data => this.adsdata = data.data)
    .catch(error => {});
    },
    editReq(id) {
                    axios.get('accounts/get_land_installment/' + id)
                        .then(response => {

                            this.get_reqdata1 = response.data;
                        })
                        this.adsdata.data.map((curEle)=>{

                            return document.getElementById("accordionBorder"+curEle.ID).classList.remove("show")
                        })

                },

    getResult(page = 1) {
    axios
    .get("accounts/land_detail/?page=" + page)
    .then((response) => (this.adsdata = response.data))
    .catch((error) => {});
    },

                editgrn2(id) {
                    this.eget_id = id;
                    axios.get('accounts/get_landinformation_area_data/' + id)
                        .then(response => {
                            this.get_grndata8 = response.data;
                        })
                        axios.get('accounts/get_landinformation_installment_data/' + id)
                        .then(response => {
                            this.get_grndata7 = response.data;
                        })

                        axios.get('accounts/get_landinformation_data/' + id)
                        .then(response => {
                            this.get_grndata81 = response.data;
                            this.pv_id = response.data[0].ID;
                        })
                },
    },

    mounted() {
    this.getResult();
    axios.get('accounts/fetch_methods')
                .then(response => {
                    this.methods = response.data
                    this.options2 = [];
                    var $this = this;
                    for (var j = 0; j < $this.methods.length; j++) {
                        this.options2.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
                    }
                })
    },
    };

    </script>

  <style>

  .td-center {
        z-index: 1;
        text-align: center;
        vertical-align: middle !important;
    }

.reports-th-center {
        z-index: 1;
        position: sticky;
        top: 190px;
        text-align: center;
        vertical-align: middle !important;
    }







</style>
