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
    Pdc Payable
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
                                                <input type="date" v-model="datefrom" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <label class="form-label">Date To</label>
                                                <input type="date" class="form-control" v-model="dateto">
                                            </div>
                                            <div class="col-md-1 col-12 mb-3 position-relative">
                                                <button @click="filtered_GRN()" style="background: rgb(193, 193, 193); width: 60% !important; height: 33px !important; margin-bottom: 20px; margin-top: 25px; margin-left: 10px" class="btn btn-common">Search</button>
                                            </div>
                                            <div class="col-md-3">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Select Bank:</h6>
                                                    <div class="invoice-customer">
                                                        <multiselect @input = "filter_by_bank()" style="margin-right: 10px;" v-model="method_type" :options="options2">
                                                         </multiselect>
                                                    </div>
                                                </div>
                                            <div class="col-md-4 col-12 mb-3 position-relative" style="text-align: right;margin-top: 30px;">
                                                <input v-model="keyword1" class="form-control" placeholder="PV ID / Ref Type / Chq Date / Chq No" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

    <div class="table-responsive" style="overflow-x: initial !important;">
    <table class="table">
    <thead>
    <tr>
        <th style="text-align:center;">ID</th>
        <th style="text-align:center;">PV ID</th>
        <th style="text-align:center;">Vendor Name</th>
        <th style="text-align:center;">Ref Type</th>
        <th style="text-align:center;">ChqNo</th>
        <th style="text-align:center;">ChqDate</th>

        <th style="text-align:center;">Clearance AccountID</th>
        <th style="text-align:center;">Clearance AccountName</th>
        <th style="text-align:center;">ChqAmount</th>
        <th style="text-align:center;">Status</th>

    </tr>
    </thead>
    <tbody>
    <tr class="odd" v-for="adsdata1 in adsdata.data">
        <td style="text-align:center;" class="sorting_1"><a class="fw-bold"> {{adsdata1.ID}}</a></td>
        <td style="text-align:center;">{{adsdata1.PVID}}</td>
        <td style="text-align:center;">{{adsdata1.VendorName}}</td>
        <td style="text-align:center;">{{adsdata1.RefType}}</td>
        <td style="text-align:center;">{{adsdata1.ChqNo}}</td>
         <td style="text-align:center;">{{adsdata1.ChqDate}}</td>

        <td style="text-align:center;"> {{adsdata1.ClearanceAccountID }}</td>
        <td style="text-align:center;" >{{adsdata1.ClearanceAccountName}}</td>

        <td style="text-align:center;">{{currency}}. {{Number(adsdata1.ChqAmount)}}</td>

        <td style="text-align:center;">
            <div class="d-flex align-items-center col-actions">
                <a class="me-25" v-if="adsdata1.Status=='Chq Paid'" data-bs-toggle="modal" data-bs-target="#viewUCD" @click="clearnceget(adsdata1.ID)">
                    <span class="badge badge-glow bg-danger">Not Cleared</span>
                </a>
                 <a class="me-25" v-if="adsdata1.Status=='Dishonered'" data-bs-toggle="modal" data-bs-target="#viewUCD" @click="clearnceget(adsdata1.ID)">
                    <span class="badge badge-glow bg-warning">Dishonered</span>
                </a>


                  <a    @click="clearnceget(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#editpayroll"><i    style="color:#d42f2f" class="fa-solid fa-pencil"></i><span></span></a>

            </div>
        </td>
    </tr>
    </tbody>
    </table>
    </div>
    <!-- <div style="display:flex; justify-content:center; padding-top:20px">
    <pagination :limit='limit' v-if='pageNo==1' :data="adsdata" @pagination-change-page="filter_by_bank"></pagination>

    </div> -->
    <div style="text-align:center;padding-top:20px">
    <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
    </div>
    </div>
    </section>


                        <div class="modal fade" id="viewUCD" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="perorders1 in perorders">
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
                                            <span class="invoice-number">{{perorders1.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{perorders1.ChqDate}}</p>
                                        </div>


                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <hr class="invoice-spacing">
                            <!-- Address and Contact starts -->

                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table style="width:100%;">
                                    <thead style="float:left; width:100%;">
                                        <tr>
                                            <td style="width:29%"><strong>PVID:</strong></td>
                                            <td style="width:32%">{{perorders1.PVID}}</td>
                                            <td style="width:29%"><strong>VendorId:</strong></td>
                                            <td style="width:32%">{{perorders1.VendorId}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Vendor Name:</strong></td>
                                            <td>{{perorders1.VendorName}}</td>
                                            <td><strong>ChqNo:</strong></td>
                                            <td>{{perorders1.ChqNo}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Clearance AccountID:</strong></td>
                                            <td>{{perorders1.ClearanceAccountID}}</td>
                                            <td><strong>Clearance AccountName:</strong></td>
                                            <td>{{perorders1.ClearanceAccountName}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Chq Amount:</strong></td>
                                            <td>{{currency}}. {{Number(perorders1.ChqAmount)}}</td>
                                        </tr>

                                    </thead>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">

                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Select Bank:</span>
                                        </p>
                                         <select v-model="deposit_bank" class="form-select mb-md-0 mb-2">
                                            <option value=""> Select Status </option>
                                            <option value="Clearanced">Clearanced</option>
                                            <option value="Dishonered">Dishonered</option>
                                        </select>
                                       <!-- <multiselect style="margin-right: 10px;" :show-labels="false"
                                     v-model="deposit_bank" :options="options">
                                    </multiselect>
                                    -->
                                        <span style="color: #DB4437; font-size:11px;" v-if="deposit_bank==''">{{e_deposit_bank}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 pt-50">
                                <button :disabled="disabled1" @click="delay1()" type="submit" class="btn btn-primary me-1"  data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Cancle
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>



                    <div class="modal fade" id="editpayroll" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">

                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                <h5>Update Cheque Detail</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Chq Date</label>
                                 <input v-model="pdc_id" type="text" hidden id="modalAddCardName" class="form-control" />
                                 <input v-model="chq_date" type="date"  id="modalAddCardName" class="form-control" />
                                </div>

                                 <div class="col-12">
                                <label class="form-label" for="modalAddCardNumber">Chq Number</label>
                                 <input v-model="chq_number" type="number" id="modalAddCardName" class="form-control" />

                                </div>


                            <div class="col-12 text-center">
                                <button type="submit" :disabled="disabled9" @click="delay9()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
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
import axios from 'axios';
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
    data() {
    return {
    companydetail: {},
    method_type:'',
    adsdata: {},
    perorders:{},
    options:[],
    success: '',
    keyword1: '',
    datefrom: '',
    dateto: '',
    deposit_bank:'',
    e_deposit_bank:'',
    datef1rom1: '',
    dateto1: '',
    currency: '',




    date: '',
    e_date: '',
    status: '',
    clearance_list:{},

    test:0,
    disabled: false,
    timeout: null,
    disabled1: false,
    timeout1: null,

    disabled9: false,
    timeout9: null,

    pdc_id:'',
    chq_date:'',
    chq_number:'',
    options2: [],

    pageNo: 1,

    }
    },
    methods: {
        filter_by_bank(page =1){
            if(this.method_type  == null){
                this.getResult();
    }else{
             axios.get('filter_bank_name/' + this.method_type + '/?page=' + page)
                .then(response => {
                    this.adsdata = response.data;
                     this.pageNo = 1;

                }) .catch(error => { console.log(error);});
            }

        },


            delay9() {
                this.disabled9 = true
                this.timeout9 = setTimeout(() => {
                    this.disabled9 = false
                }, 5000)
                this.update_chq_detail();
            },
            update_chq_detail(){
                axios.post("./accounts/update_pdc_chq_detail", {
                pdc_id:this.pdc_id,
                chq_date:this.chq_date,
                chq_number:this.chq_number,
                })
                .then((data) => {
                if(data.data=='updated'){
                this.$toastr.s("Updated Record Successfully!", "Congratulations!");
                    this.getResult();
                }

                            })

            },



        filtered_GRN() {
            this.keyword1 = '';
            if (this.datefrom == '') {
                this.datef1rom1 = "00-00-0000";
            } else {
                this.datef1rom1 = this.datefrom;
            }
            if (this.dateto == '') {
                this.dateto1 = "99-99-9999";
            } else {
                this.dateto1 = this.dateto;
            }


            axios.get("accounts/searchpdcdate/" + this.datef1rom1 + "/" + this.dateto1)
                .then(data => {

                    this.adsdata = data.data
                })
                .catch(error => this.error = error.response.data.errors)
        },
    searchDate() {
    this.datefrom = "";
    this.dateto = "";
    this.getResult();
    },

                clearnceget(id){
                 axios.get("accounts/getsinglepdcpayable/"+id).then((response)=>{
                    this.perorders=response.data;
                    this.pdc_id=response.data[0].ID;
                    this.chq_date=response.data[0].ChqDate;
                    this.chq_number=response.data[0].ChqNo;

                 }).catch((err)=>{
                    console.log(err);
                 })
                },
    delay() {
                    this.disabled = true
                    this.timeout = setTimeout(() => {
                        this.disabled = false
                    }, 5000)
                    this.update_po();
                },
                delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.submit_deposit_bank();
            },

            submit_deposit_bank(){
        if(this.deposit_bank==''){
            this.e_deposit_bank='Select Status'
            this.$toastr.e("Please fill required fields!", "Caution!");
        }else{
            axios.post("submit_pdcclearancedetails",{
                 id:this.perorders[0].ID,

                 Deposit_Bank:this.deposit_bank,

            }).then((response)=>{
               if(response.data=='Clearance'){
   this.$toastr.s("Clearance Submitted Successfully", "Congratulations!");
   this.deposit_bank=''
   this.getResult();
                } else if(response.data=='Dishonered'){
                    this.$toastr.s("Dishonered Submitted Successfully", "Congratulations!");
   this.deposit_bank=''
   this.getResult();
                }
                else{
            this.$toastr.e(response.data, "Caution!");

                }
            }).catch((err)=>{
                this.$toastr.e(err?.response.data.message, "Caution!");
            })
        }
            },

    getResult(page = 1) {
    axios.get('accounts/get_pdcpayable_detail/?page=' + page)
    .then(response => this.adsdata = response.data)
    },
    getResults(){
        axios.get('accounts/search_generalfilter',{ params: { keyword1: this.keyword1 } })
    .then(response => this.adsdata = response.data)
    }
    },
    watch: {
    keyword1(after, before) {
    this.getResults();
    }
    },
    mounted() {
       axios.get('accounts/fetch_methods1')
     .then(response => {
this.methods = response.data
 this.options2 = [];

    var $this = this;
    for (var j = 0; j < $this.methods.length; j++) {
        this.options2.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
    }
})


        this.getResult();
    axios.get('get_currency').then((response) => {
                this.currency = response.data[0].Currency;
            })
    axios.get('fetch_companyDetail')
    .then(response => this.companydetail = response.data)
    axios.get("accounts/fetchclearance_datetime").then((response)=>{
        this.clearance_list=response.data
    }).catch((error)=>{
        console.log(error);
    })

axios.get('accounts/fetch_bank_methods')
.then(response => {
this.methods = response.data
 this.options = [];

    var $this = this;
    for (var j = 0; j < $this.methods.length; j++) {
        this.options.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
    }
})
    }
    }

    </script>
    <style scoped>
    .card-title {
    margin-bottom: 8px !important;
    margin-top: 15px !important;
    }
    .label {
            height:32px;
            vertical-align: middle;
            margin-top: 8px;
            margin-right: 12px;
            margin-bottom: 15px;
        }
    </style>
