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
    Units Controller
    </li>
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
        <h4 class="card-title">Units Controller</h4>
       
    </div>
    <div class="card-body">
        <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
            <section id="accordion-with-border">
                <div class="row">
                    <!-- User Sidebar -->
                    <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0" v-if="hasPermission('Units-Management units-data fetch-data')">
                        <div class="card">
                            <div class="card-header">
                                <h2 style="font-size:24px" class="card-title">Transfer Booking Data</h2>
                            </div>
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <div class="table-responsive">
                                                    <table class="table table-flush-spacing">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-nowrap">
                                                                    <label class="form-label">Start Date:</label>
                                                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                                                    <input type="date" v-model="booking_start" class="form-control" />
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="booking_start==''">{{e_booking_start}}</span>
                                                                </td>x
                                                                <td class="text-nowrap">
                                                                    <label class="form-label">End Date:</label>
                                                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                                                    <input type="date" v-model="booking_end" class="form-control" />
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="booking_end==''">{{e_booking_end}}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0" v-if="hasPermission('Units-Management units-data fetch-data')">
                                <div class="card">
                                    <div class="card-header">
                                        <h2 style="font-size:24px" class="card-title">Transfer Receipt Data</h2>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-vertical">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <div class="table-responsive">
                                                            <table class="table table-flush-spacing">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-nowrap">
                                                                            <label class="form-label">Start Date:</label>
                                                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                                                            <input type="date" v-model="receipt_start" class="form-control" />
                                                                            <span style="color: #DB4437; font-size: 11px;" v-if="receipt_start==''">{{e_receipt_start}}</span>
                                                                        </td>
                                                                        <td class="text-nowrap">
                                                                            <label class="form-label">End Date:</label>
                                                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                                                            <input type="date" v-model="receipt_end" class="form-control" />
                                                                            <span style="color: #DB4437; font-size: 11px;" v-if="receipt_end==''">{{e_receipt_end}}</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                                    <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
    
       <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0" v-if="hasPermission('Units-Management units-data fetch-data')">
                        <div class="card">
                            <div class="card-header">
                                <h2 style="font-size:24px" class="card-title">Services Charges Booking</h2>
                            </div>
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <div class="table-responsive">
                                                    <table class="table table-flush-spacing">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-nowrap">
                                                                    <label class="form-label">Start Date:</label>
                                                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                                                    <input type="month" v-model="booking_services" class="form-control" />
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="booking_start==''">{{e_booking_services}}</span>
                                                                </td>
                                                               
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" :disabled="disabled8" @click="delay8()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
    
     <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0" v-if="hasPermission('Units-Management units-data fetch-data')">
                        <div class="card">
                            <div class="card-header">
                                <h2 style="font-size:24px" class="card-title">Electricity Booking</h2>
                            </div>
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <div class="table-responsive">
                                                    <table class="table table-flush-spacing">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-nowrap">
                                                                    <label class="form-label">Start Date:</label>
                                                                    <span style="color: #DB4437; font-size: 11px;">*</span>
                                                                    <input type="month" v-model="booking_electricity" class="form-control" />
                                                                    <span style="color: #DB4437; font-size: 11px;" v-if="booking_electricity==''">{{e_booking_electricity}}</span>
                                                                </td>
    
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" :disabled="disabled7" @click="delay7()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
    
    
    
    
    
    
    
    
    
    
    
                     <div class="col-md-12" v-if="hasPermission('Units-Management units-data supervision')">
                                <section class="app-user-list">
                                    <div clas="card" style="background-color: white !important">
                                        <div style="margin-bottom: 20px; padding-top: 20px" class="d-flex justify-content-between align-items-center header-actions  mx-2 row mt-75 ">
                                            <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                                <h4 class="card-title">Types Link</h4>
                                            </div>
                                            <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                                <div class=" dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" style="overflow-x: initial !important">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Type Name</th>
                                                        <th>Coa ID</th>
                                                        <th>AccountName</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="types1 in types.data">
                                                        <td>{{types1.TypeName}}</td>
                                                        <td>{{types1.CoaID}}</td>
                                                        <td>{{types1.CoaName}}</td>
                                                        <td>
                                                            <a @click=fetch_typesid(types1.ID,types1.TypeName) data-bs-toggle="modal" data-bs-target="#leavetype9" class=""><i class="fa-solid fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="text-align: center; padding-top: 20px">
                                            <pagination  :data="types"  @pagination-change-page="getResult2"></pagination>
                                        </div>
                                    </div>
                                </section>
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
      <div class="modal fade" id="leavetype9" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <h3 class="text-center mb-1" id="addNewCardTitle">Link Type with COA</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body px-sm-5 mx-50 pb-5">
                                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                                            
                                               <div class="invoice-customer" >
                                               <label class="form-label" for="modalAddCardName">Select Item Name</label>
                                                <input type="text" hidden v-model="ide"  /> 
                                                </div>
                                                <input type="text" v-model="typename" class="form-control" readonly /> 
                                                </div>
                                                <div class="invoice-customer" >
                                                <label class="form-label" for="modalAddCardName">Select Link Account</label>
                                                <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction"  :show-labels="false"  v-model="account_idname_sep" :options="options2">
                                                                </multiselect>  
                                                </div>
    
    
                                            <div class="col-12 text-center">
                                                <button type="submit" :disabled="disabled4" @click="delay4()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
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
    import Multiselect from 'vue-multiselect'
    export default {
    data() {
    return {
    types: {},
    
    
    
    booking_end: '',
    booking_start: '',
    e_booking_start: '',
    e_booking_end: '',
    disabled: false,
    timeout: null,
    
    receipt_end: '',
    receipt_start: '',
    e_receipt_start: '',
    e_receipt_end: '',
    disabled1: false,
    timeout1: null,
    
    
    disabled4: false,
    timeout4: null,
    ide:'',
    typename:'',
    agnstpayment:{},
    account_idname_sep:'',
    options2:[],
    
    
    booking_services:'',
    e_booking_services: '',
    disabled8: false,
    timeout8: null,
    
    
    disabled7: false,
    timeout7: null,
    booking_electricity:'',
    e_booking_electricity:'',
    
    }
    },
     components: {
              Multiselect,
        },
    methods: {
    fetch_typesid(id,name){
       this.ide=id;
       this.typename=name;
    },
    delay7() {
    this.disabled = true
    this.timeout = setTimeout(() => {
    this.disabled = false
    }, 5000)
    this.submit_electricity()
    },
    submit_electricity(){
       if (this.booking_electricity == '' ) {
    if (this.booking_electricity == '') {
    this.e_booking_electricity = 'Enter month';
    }
    this.$toastr.e("Please fill required fields!", "Error");
    } else {
    axios.get('Accounts/Booking_electricity_Mis_to_sa_app/' + this.booking_electricity)
    .then(response => {
    if (response.data == "Transfered Successfully") {
    this.$toastr.i("Transfered Electricity Receipt Data Successfully!", "Information");
    } else {
    this.$toastr.e(response.data, "Cautions!");
    }
    
    })
    }  
    },
    delay8() {
    this.disabled = true
    this.timeout = setTimeout(() => {
    this.disabled = false
    }, 5000)
    this.submit_services()
    },
    submit_services(){
        if (this.booking_services == '' ) {
    if (this.booking_services == '') {
    this.e_booking_services = 'Enter month';
    }
    this.$toastr.e("Please fill required fields!", "Error");
    } else {
    axios.get('Accounts/Booking_services_Mis_to_sa_app/' + this.booking_services)
    .then(response => {
    if (response.data == "Transfered Successfully") {
    this.$toastr.i("Transfered Receipt Data Successfully!", "Information");
    } else {
    this.$toastr.e(response.data, "Cautions!");
    }
    
    })
    }
    },
    
    
    delay() {
    this.disabled = true
    this.timeout = setTimeout(() => {
    this.disabled = false
    }, 5000)
    this.submit_booking()
    },
    submit_booking() {
    if (this.booking_start == '' || this.booking_end == '') {
    if (this.booking_start == '') {
    this.e_booking_start = 'Enter start date';
    }
    if (this.booking_end == '') {
    this.e_booking_end = 'Enter End date';
    }
    this.$toastr.e("Please fill required fields!", "Error");
    } else {
    axios.get('Accounts/Booking_Mis_to_sa_app/' + this.booking_start + '/' + this.booking_end)
    .then(response => {
    if (response.data == "Transfered Successfully") {
    this.$toastr.i("Transfered Receipt Data Successfully!", "Information");
    } else {
    this.$toastr.e(response.data, "Cautions!");
    }
    
    })
    }
    },
    delay4() {
    this.disabled4 = true
    this.timeout4 = setTimeout(() => {
    this.disabled4 = false
    }, 5000)
    this.submit_typename()
    },
    submit_typename(){
    
        axios.post('./Accounts/update_typename/'+this.ide+'/'+this.account_idname_sep)
        .then(response => {
        this.$toastr.s("Linked Type With COA Successfully!", "Congratulations");
        this.getResult2();
        })
    },
    delay1() {
    this.disabled1 = true
    this.timeout1 = setTimeout(() => {
    this.disabled1 = false
    }, 5000)
    this.submit_receipt()
    },
    submit_receipt() {
    if (this.receipt_start == '' || this.receipt_end == '') {
    if (this.receipt_start == '') {
    this.e_receipt_start = 'Enter start date';
    }
    if (this.receipt_end == '') {
    this.e_receipt_end = 'Enter End date';
    }
    this.$toastr.e("Please fill required fields!", "Error");
    } else {
    axios.get('Accounts/update_receipt_data/' + this.receipt_start + '/' + this.receipt_end)
    .then(response => {
    if (response.data == "Transfered Successfully") {
    this.$toastr.i("Transfered Receipt Data Successfully!", "Information");
    } else {
    this.$toastr.e(response.data, "Cautions!");
    }
    
    })
    }
    },
    
    
    getResult2(page = 1) {
                    axios.get('./accounts/fetch_typesdata/?page=' + page)
                    .then((response) => (this.types = response.data));
                },
    
    
    },
    
    mounted() {
     axios.get('accounts/fetch_all_transaction_head')
                .then(response => {
                    this.agnstpayment = response.data
                    this.options2 = [];
    
                    var $this = this;
                    for (var i = 0; i < $this.agnstpayment.length; i++) {
                        this.options2.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
                    }
                })
    this.getResult2();
    }
    }
    
    </script>
    