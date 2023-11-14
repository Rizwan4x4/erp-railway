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
    Accounts Session
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
    <h4 class="card-title">Accounts Session(s) Detail</h4>
    <div style="text-align: right;width: 30% !important;">
    <a v-if="hasPermission('Accounts Configurations  session create new')" style="float:left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect" type="button">Create New</a>
    <div class="" style="float:right">
    <div style="">
        <label>
            <input autocomplete="off" id="name" type="text" name="name" v-model="name" class="form-control" @change="getByName()" placeholder="Search By Name" />
        </label>
    </div>
    </div>
    </div>
    </div>
    <div class="card-body">
    <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
    <section id="accordion-with-border">
    <div class="row">
        <div class="col-sm-12">
            <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Session Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="adsdata1 in adsdata.data">
                                        <td>{{adsdata1.SessionName}}</td>
                                        <td>{{adsdata1.StartDate}}</td>
                                        <td>{{adsdata1.EndDate}}</td>
                                        <td >
                                            <span class="badge bg-gradient-success" v-if="adsdata1.CurrentSession==1">Running</span>
                                            <span v-if="hasPermission('Accounts Configurations  session close/open')">
                                                <a v-if="adsdata1.Status=='1'" @click="fetch_session_id(adsdata1.SessionID)" data-bs-toggle="modal" data-bs-target="#hireinterview">
                                                    <span class="badge bg-gradient-info" style="cursor: pointer;">Open</span>
                                                </a>
                                                <a v-else>
                                                    <span class="badge bg-gradient-warning" style="cursor: pointer;">Closed</span>
                                                </a>
                                            </span>
                                            <span v-else>
                                                <a v-if="adsdata1.Status=='1'">
                                                    <span class="badge bg-gradient-info" style="cursor: pointer;">Open</span>
                                                </a>
                                                <a v-else>
                                                    <span class="badge bg-gradient-warning" style="cursor: pointer;">Closed</span>
                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <a  v-if="hasPermission('Accounts Configurations  session delete')" @click="delete_session(adsdata1.SessionID)" class="me-25">
                                                <i style="color:#d42f2f" class="fa-solid fa-trash"></i>
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
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0" v-if="hasPermission('Units-Management units-data fetch-data')">
    <div  class="card">
    <div class="card-header">
        <h2 style="font-size:24px" class="card-title">Transfer Receipt Data</h2>
    </div>
    <div class="card-body">
     <form class="form form-vertical" v-if="hasPermission('Accounts Configurations  session transfer receipt data')">
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
                    <button type="button" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                </div>
            </div>
        </form>
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
    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header bg-transparent">
    <h3 class="text-center mb-1" id="addNewCardTitle">Create Session</h3>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body px-sm-5 mx-50 pb-5">
    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
    <div class="col-12">
    <label class="form-label" for="modalAddCardName">Start From</label>
    <input type="date" v-model="session_start" class="form-control" style="" />
    <span style="color: #DB4437; font-size: 11px;" v-if="session_start==''">{{e_session_start}}</span>
    </div>
    <div class="col-12">
    <label class="form-label" for="modalAddCardName">Start End</label>
    <input type="date" v-model="session_end" class="form-control" style="" />
    <span style="color: #DB4437; font-size: 11px;" v-if="session_end==''">{{e_session_end}}</span>
    </div>
    <div>
    <label style="width:100%">Current</label>
    <div style="margin-bottom:10px" class="form-check form-check-info form-switch">
    <input style="width: 50px;" type="checkbox" v-model="c_session" class="form-check-input" id="customSwitch3">
    </div>
    </div>
    <div class="col-12 text-center">
    <button type="submit" @click="submit_session()" class="btn btn-primary me-1 mt-1">Submit</button>
    <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
    Cancel
    </button>
    </div>
    </form>
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
   
    session_start: '',
    session_end: '',
    c_session: false,
    this_session: '',
    adsdata: {},
    e_session_start: '',
    e_session_end: '',
    name: '',
    receipt_end:'',
    receipt_start:'',
    e_receipt_start:'',
    e_receipt_end:'',
    disabled: false,
    timeout: null,
    }
    },
    methods: {
    delay() {
    this.disabled = true
    this.timeout = setTimeout(() => {
    this.disabled = false
    }, 5000)
    this.submit_receipt()
    },
    submit_receipt(){
      if (this.receipt_start == '' || this.receipt_end == '') {
    if (this.receipt_start == '') {
    this.e_receipt_start = 'Enter start date';
    }
    if (this.receipt_end == '') {
    this.e_receipt_end = 'Enter End date';
    } 
    this.$toastr.e("Please fill required fields!", "Error");
    }
    else {
       axios.get('Accounts/update_receipt_data/'+this.receipt_start+'/'+this.receipt_end)
    .then(response => {
    if(response.data=="Transfered Successfully"){
      this.$toastr.i("Transfered Receipt Data Successfully!", "Information");  
    }
    else {
        this.$toastr.e(response.data, "Cautions!"); 
    }
    }) 
    }  
    },
    getByName(page = 1) {
    axios.get('./accounts_sessionByName/?page=' + page, { params: { name: this.name } })
    .then(response => this.adsdata = response.data)
    .catch(error => {});
    },
    fetch_session_id(id) {
    this.fetch_sessoin_id = id;
    },
    update_session_payroll() {
    /*
    axios.get('update_payroll_status/' + this.fetch_sessoin_id)
    .then(response => {
    this.$toastr.s("Attendance Closed and proceed in Payroll Section!", "Information");
    })
    this.$router.go(0);
    */
    },
    delete_session(id) {
    axios.get('accounts_delete_session/' + id)
    .then(response => {
    this.$toastr.s("Delete Record Successfully!", "Deleted");
    this.adsdata = response.data
    })
    .catch(error => {});
    },
    submit_session() {
    if (this.session_start == '' || this.session_end == '') {
    if (this.session_start == '') {
    this.e_session_start = 'Enter start date';
    } else {
    this.e_session_start = '';
    }
    if (this.session_end == '') {
    this.e_session_end = 'Enter start date';
    } else {
    this.e_session_end = '';
    }
    this.$toastr.e("Please fill required fields!", "Error");
    } else {
    if (this.c_session == true) {
    this.this_session = "1";
    } else if (this.c_session == false) {
    this.this_session = "0";
    }
    axios.post('accounts_submit_session', {
    session_start: this.session_start,
    session_end: this.session_end,
    c_session: this.this_session,
    })
    .then(data => {
    if (data.data == 'Submitted') {
    this.$toastr.s("Session Created Successfully!", "Congratulations");
    this.getResult();
    }
    })
    .catch(error => {});
    }
    },
    getResult(page = 1) {
    axios.get('accounts_session_detail/?page=' + page)
    .then(response => this.adsdata = response.data)
    .catch(error => {});
    },
    },
    watch: {
    name(after, before) {
    this.getByName();
    }
    },
    mounted() {
 
    this.getResult();
    }
    }
    </script>
    