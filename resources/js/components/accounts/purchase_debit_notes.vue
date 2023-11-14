<template>
    <div >
    <div class="app-content content ">
    <div class="noprint content-overlay"></div>
    <div class="noprint cheader-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
    <div class="noprint content-header row">
      <div class="breadcrumb-wrapper">
          <ol class="breadcrumb">
             <li class="breadcrumb-item">
                                    <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                                </li>
              <li class="breadcrumb-item">
                  <router-link to="/purchase/debit_detail" style="text-decoration: none;">Debit Notes</router-link>
              </li>
              <li class="breadcrumb-item active">
                  New Debit Notes
              </li>
          </ol>
      </div>
    </div>
    <div class="content-body">
      <section class="invoice-add-wrapper">
      <div class="row invoice-add">
          <!-- Invoice Add Left starts -->
          <div class="col-xl-9 col-md-8 col-12">
              <div class="card invoice-preview-card">
                  <!-- Header starts -->
                  <div class="card-body  pb-0">
                      <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0" style="margin-bottom:0px">
                           <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                      <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                          <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail1.company_name}}</h3>
                                      </div>
                                      <p class="card-text mb-25">Address: {{companydetail1.company_address}} , </p> <p class="card-text mb-25">City: {{companydetail1.city}} - {{companydetail1.country}}</p>
                                      <p class="card-text mb-0">Phone: {{companydetail1.phone_number}}</p>
                                  </div>
                          <div class="invoice-number-date mt-md-0 mt-2">

                              <div class="d-flex flex-column align-items-center mb-1">
                                  <span class="title">Date:</span>
                                  <input type="date" class="form-control invoice-edit-input " v-model="date" />
                                   <span style="color: #db4437; font-size: 11px" v-if="date == ''">{{ e_date }}</span>
                              </div>

                          </div>
                      </div>
                  </div>
                  <!-- Header ends -->
                 <div class="divider">
                          <div class="divider-text" style="font-size: 24px;font-weight: 900;">Debit Note(s)</div>
                      </div>
                  <!-- Address and Contact starts -->
                  <div class="card-body invoice-padding pt-0">
                      <div class="row row-bill-to invoice-spacing" style="margin-top:0px">

                          <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                              <h6 class="invoice-to-title" style="margin-bottom:5px">Debit Against:</h6>
                              <div class="invoice-customer">

                                  <multiselect @input="search_balance();find_against()" style="margin-right: 10px;" v-model="vendor_name" :options="options">
                                                            </multiselect>
                                   <span style="color: #db4437; font-size: 11px" v-if="vendor_name == ''">{{ e_vendor_name }}</span>
                              </div>
                              <div class="row" style="margin-top:10px">
                              <div class="col-md-6">
                               <h6 class="invoice-to-title" style="margin-bottom:5px">Against Invoice:</h6>

                              <multiselect style="margin-right: 10px;"  v-model="against_invoice" @input="search_po_detail()"
                                                             :options="options2"> </multiselect>
                                   <span style="color: #db4437; font-size: 11px" v-if="against_invoice == ''">{{ e_against_invoice }}</span>

                              </div>
                               <div class="col-md-6">
                               <h6 class="invoice-to-title" style="margin-bottom:5px">Debit Total Amount:</h6>
                              <div class="invoice-customer">
                                   <input type="text" readonly  class="form-control ms-50" id="salesperson" placeholder="" v-model="amount" />
                                    <span style="color: #db4437; font-size: 11px" v-if="amount == ''">{{ e_amount }}</span>
                              </div>
                              </div>
                              </div>
                          </div>

                      </div>
                  </div>
                  <div class="card-body invoice-padding invoice-product-details">
                                            <slot class="source-item" v-for="(get_po_detail11, index) in get_po_detail1">
                                                <div data-repeater-list="group-a">
                                                    <div class="repeater-wrapper" style="margin-top:30px" data-repeater-item>
                                                        <div class="row">
                                                            <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                                <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                    <div class="col-lg-4 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                        <p class="card-text col-title mb-md-50 mb-0">Item</p>
                                                                        <select v-if="get_po_detail11.ItemName!=null" class="form-select item-details" name="first[]">
                                                                            <option :value='get_po_detail11.ItemId'>{{get_po_detail11.ItemName}}</option>

                                                                        </select>
                                                                        <input v-else type="text" class="form-control" name="first[]" :value="get_po_detail11.Detail" readonly />


                                                                    </div>


                                                                    <div class="col-lg-4 col-12 mt-lg-0 mt-2">
                                                                        <p class="card-text col-title mb-md-2 mb-0">Sub Total</p>
                                                                        <input name="second[]" readonly type="number" class="form-control" :value='Number(Number(get_po_detail11.SubTotal)+Number(Number(get_po_detail11.SubTotal*discount)/invoice_subtotal)).toFixed(2)' />

                                                                    </div>
                                                                    <div class="col-lg-4 col-12 mt-lg-0 mt-2">
                                                                        <p class="card-text col-title mb-md-50 mb-0">Debit Amount</p>
                                                                        <input @change="sum_total()"  name="third[]"  type="number" class="form-control" value="0" />

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </slot>
                                        </div>
                  <!-- Invoice Total ends -->
                  <hr class="invoice-spacing mt-0" style="margin-top:0px;" />
                  <div class="card-body invoice-padding py-0">
                      <!-- Invoice Note starts -->
                      <div class="row">
                          <div class="col-12">
                              <div class="mb-2">
                                  <label for="note" class="form-label fw-bold">Narration:</label>
                                  <textarea class="form-control" v-model="narration" rows="2" id="note"></textarea>
                                   <span style="color: #db4437; font-size: 11px" v-if="narration == ''">{{ e_narration }}</span>
                              </div>
                          </div>
                      </div>
                      <!-- Invoice Note ends -->
                  </div>
              </div>
          </div>

          <div class="col-xl-3 col-md-4 col-12">
              <div class="card">
                  <div class="card-body">
                      <button class="btn btn-primary w-100 mb-75" :disabled="disabled" @click="delay()">Create Debit Note</button>


                  </div>
              </div>
              <h6 class="mb-2" style="font-weight:bold">Vendor Details:</h6>
                              <table v-if="ledger_d_detail.length>0">
                                  <tbody v-for="ledger_d_detail1 in ledger_d_detail">

                                      <tr  >
                                          <td class="pe-1">Name:</td>
                                          <td>{{ledger_d_detail1.AccountName}}</td>
                                      </tr>
                                       <tr>
                                          <td class="pe-1">Total Balance:</td>
                                          <td><strong>Rs.{{Math.round(ledger_d_detail1.am).toLocaleString()}}</strong></td>
                                      </tr>


                                  </tbody>
                              </table>
                               <hr class="my-50" />
                                  <div class="invoice-total-item" v-if="inv_detail.length>0">
                                   <p class="invoice-total-title" style="font-weight:bold" >Invoice Detail:</p>
                                   <table v-for="inv_detail1 in inv_detail">
                                            <tbody>
                                                <tr>
                                                    <td class="pe-1">PaymentID:</td>
                                                    <td>{{inv_detail1.PVNO}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-1">Date:</td>
                                                    <td>{{inv_detail1.Date}}</td>
                                                </tr>


                                                <tr>
                                                    <td class="pe-1">Amount:</td>
                                                    <td>Rs. {{Math.round(inv_detail1.Amount).toLocaleString()}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-1">Remaining:</td>
                                                    <td>{{Math.round(inv_detail1.Remaining).toLocaleString()}}</td>
                                                </tr>
                                            </tbody>
                                            <hr>
                                        </table>
                                  </div>
          </div>
          <!-- Invoice Add Right ends -->
      </div>

    </section>
    </div>
    </div>
    </div>
    </div>
    </template>
    <script>
    import axios from 'axios';
    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },
    data() {
    return {
  
    counter: 1,
    companydetail: {},
    id:"",
    e_id:"",
    date:new Date().toJSON().slice(0, 10),
    e_date:"",
    invoice_number:'',
    vendor_name:"",
    e_vendor_name:"",
    against_invoice:"",
    e_against_invoice:"",
    t_val: '',
    inv_detail:{},
    discount:0,
    narration:"",
    e_narration:"",
    amount:0,
    inv_balance:{},
    invoice_subtotal:0,
    get_po_detail1:{},
    e_amount:"",
    ledger_d_detail: {},
    agnstpo:{},
    agnstpayment:{},
    options:[],
    options2:[],
    disabled: false,
    timeout: null,
    }
    },
    methods: {
        onlyNumber($event) {
                    let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                    if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                        $event.preventDefault();
                    }
                },
                intervalFetchData: function () {
                    setInterval(() => {
                        this.sum_total();
                    }, 1000);
                },
                sum_total() {
                    var third = document.getElementsByName('third[]');
                    var m=0;
                    for (var g = 0; g < third.length; g++) {
                        var b = third[g];
                        m = Number(m) + (Number(b.value));
                    }
                    this.amount = m;


                },
    submit_debitnotes(){
    if ( this.date == ''  || this.against_invoice == '' || this.vendor_name == '') {
      if (this.vendor_name == '') {
          this.e_vendor_name = "Please enter vendor name";
      }
      if (this.against_invoice == '') {
          this.e_against_invoice = "Please select invoice";
      }
      if (this.date == '') {
          this.e_date = "Select date";
      }
      this.$toastr.e("Please fill required fields!", "Caution!");
    }
    else {
                        var item_name = document.getElementsByName('first[]');
                        var SubTotal = document.getElementsByName('second[]');
                        var debit_amount = document.getElementsByName('third[]');

                        var k = 'zero';
                        var q=0;
                        var m = 0;
                        var n = 0;

                        for (var i = 0; i < item_name.length; i++) {
                            var a = item_name[i];
                            k = k + "|" + a.value;
                        }
                        for (var g = 0; g < SubTotal.length; g++) {
                            var c = SubTotal[g];
                            m = m + "|" + c.value;
                        }

                        for (var h = 0; h < debit_amount.length; h++) {
                            var d = debit_amount[h];
                            n = n + "|" + d.value;
                        }
        axios.post("submit_debit_notes",{
            vendor:this.vendor_name,
            date:this.date,
            amount:this.amount,
            narration:this.narration,
            against_invoice:this.against_invoice,
            item_name:k,
            sub_total:m,
            debit_amount:n

        }).then((response)=>{
            if(response.data=='submitted'){
                this.$toastr.s("Debit note created Successfully", "Congratulations!");
                this.$router.push({ name: 'credit_debit_detail' })
                this.vendor_name=''
                this.amount=0
                this.narration=''
                this.against_invoice=''
            }else{
      this.$toastr.e(response.data, "Caution!");

            }
        })
    }
    },

    search_po_detail() {

           if (this.vendor_name == '' || this.against_invoice == '') {
               this.$toastr.e("Please fill Against Payment and PO Number Firstly!", "Caution!");
           } else {
            axios.get("accounts/fetch_pi_taxbycode/"+this.against_invoice)
              .then((response)=>{
                this.invoice_subtotal=response.data[0].SubTotal
                this.discount=(Number(response.data[0].Tax)+Number(response.data[0].ShippingCharges))-Number(response.data[0].Discount)
                if(response.status==200){
                    axios.get("accounts/fetch_pi_itemsbycode/"+this.against_invoice)
              .then((response)=>{
                this.get_po_detail1=response.data
              })

                }
              })

               axios.get('./accounts/fetch_po_value/' + this.against_invoice + '/' + this.vendor_name)
                   .then(response => {
                       if (response.data == 'notexists') {
                           this.$toastr.e("Vendor Does Not Match with Invoice.", "Please Select Valid!");

                       } else {
                           this.inv_balance = response.data;


                           this.remaining_value = this.inv_balance.remaining_value;
                           this.t_val == this.inv_balance.total_value;
                           axios.get('./accounts/fetch_po_details/' + this.against_invoice)
                               .then(response => {
                                   this.inv_detail = response.data;
                               })
                       }
                   })


           }



       },
    find_against(){
        axios.get('accounts/fetch_pi_detail/' + this.vendor_name)
                        .then(response => {
                            this.agnstpo = response.data
                            this.options2 = [];

                            var $this = this;
                            for (var i = 0; i < $this.agnstpo.length; i++) {
                                this.options2.push($this.agnstpo[i].FormID);
                            }
                        })
    },
    search_balance() {
                axios.get('./accounts/ledger_report_balance/1/1/' + this.vendor_name)
                    .then(response => {
                        this.ledger_d_detail = response.data;
                    })
            },
    delay() {
    this.disabled = true
    this.timeout = setTimeout(() => {
      this.disabled = false
    }, 5000)
    this.submit_debitnotes()
    },
    },
    mounted() {
        axios.get('accounts/fetch_payable_head')
                .then(response => {
                    this.agnstpayment = response.data
                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.agnstpayment.length; i++) {
                        this.options.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
                    }
                })
    axios.get('fetch_companyDetail')
    .then(response => this.companydetail = response.data)
    console.log('warning')

    }
    }
    </script>
    <style scoped>
    @media print {
    .noprint {
    visibility: hidden;
    }
    }
    .invoice-preview .invoice-padding,
    .invoice-edit .invoice-padding,
    .invoice-add .invoice-padding {
    padding-left: 2.5rem;
    padding-right: 2.5rem; }

    .invoice-preview .table th:first-child,
    .invoice-preview .table td:first-child,
    .invoice-edit .table th:first-child,
    .invoice-edit .table td:first-child,
    .invoice-add .table th:first-child,
    .invoice-add .table td:first-child {
    padding-left: 2.5rem; }

    .invoice-preview .logo-wrapper,
    .invoice-edit .logo-wrapper,
    .invoice-add .logo-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 1.9rem; }

    .invoice-preview .logo-wrapper .invoice-logo,
    .invoice-edit .logo-wrapper .invoice-logo,
    .invoice-add .logo-wrapper .invoice-logo {
    font-size: 2.142rem;
    font-weight: bold;
    letter-spacing: -0.54px;
    margin-left: 1rem;
    margin-bottom: 0; }

    .invoice-preview .invoice-title,
    .invoice-edit .invoice-title,
    .invoice-add .invoice-title {
    font-size: 1.285rem;
    margin-bottom: 1rem; }

    .invoice-preview .invoice-title .invoice-number,
    .invoice-edit .invoice-title .invoice-number,
    .invoice-add .invoice-title .invoice-number {
    font-weight: 600; }

    .invoice-preview .invoice-date-wrapper,
    .invoice-edit .invoice-date-wrapper,
    .invoice-add .invoice-date-wrapper {
    display: flex;
    align-items: center; }

    .invoice-preview .invoice-date-wrapper:not(:last-of-type),
    .invoice-edit .invoice-date-wrapper:not(:last-of-type),
    .invoice-add .invoice-date-wrapper:not(:last-of-type) {
    margin-bottom: 0.5rem; }

    .invoice-preview .invoice-date-wrapper .invoice-date-title,
    .invoice-edit .invoice-date-wrapper .invoice-date-title,
    .invoice-add .invoice-date-wrapper .invoice-date-title {
    width: 7rem;
    margin-bottom: 0; }

    .invoice-preview .invoice-date-wrapper .invoice-date,
    .invoice-edit .invoice-date-wrapper .invoice-date,
    .invoice-add .invoice-date-wrapper .invoice-date {
    margin-left: 0.5rem;
    font-weight: 600;
    margin-bottom: 0; }

    .invoice-preview .invoice-spacing,
    .invoice-edit .invoice-spacing,
    .invoice-add .invoice-spacing {
    margin: 1.45rem 0; }

    .invoice-preview .invoice-number-date .title,
    .invoice-edit .invoice-number-date .title,
    .invoice-add .invoice-number-date .title {
    width: 115px; }

    .invoice-preview .invoice-total-wrapper,
    .invoice-edit .invoice-total-wrapper,
    .invoice-add .invoice-total-wrapper {
    width: 100%;
    max-width: 12rem; }

    .invoice-preview .invoice-total-wrapper .invoice-total-item,
    .invoice-edit .invoice-total-wrapper .invoice-total-item,
    .invoice-add .invoice-total-wrapper .invoice-total-item {
    display: flex;
    align-items: center;
    justify-content: space-between; }

    .invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-title,
    .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-title,
    .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-title {
    margin-bottom: 0.35rem; }

    .invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
    .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
    .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-amount {
    margin-bottom: 0.35rem;
    font-weight: 600; }

    @media (min-width: 768px) {
    .invoice-preview .invoice-title,
    .invoice-edit .invoice-title,
    .invoice-add .invoice-title {
    text-align: right;
    margin-bottom: 3rem; } }

    .invoice-edit .invoice-preview-card .invoice-title,
    .invoice-add .invoice-preview-card .invoice-title {
    text-align: left;
    margin-right: 3.5rem;
    margin-bottom: 0; }

    .invoice-edit .invoice-preview-card .invoice-edit-input,
    .invoice-edit .invoice-preview-card .invoice-edit-input-group,
    .invoice-add .invoice-preview-card .invoice-edit-input,
    .invoice-add .invoice-preview-card .invoice-edit-input-group {
    max-width: 11.21rem; }

    .invoice-edit .invoice-preview-card .invoice-product-details,
    .invoice-add .invoice-preview-card .invoice-product-details {
    background-color: #fcfcfc;
    padding: 3.75rem 3.45rem 2.3rem 3.45rem; }

    .invoice-edit .invoice-preview-card .invoice-product-details .product-details-border,
    .invoice-add .invoice-preview-card .invoice-product-details .product-details-border {
    border: 1px solid #ebe9f1;
    border-radius: 0.357rem; }

    .invoice-edit .invoice-preview-card .invoice-to-title,
    .invoice-add .invoice-preview-card .invoice-to-title {
    margin-bottom: 1.9rem; }

    .invoice-edit .invoice-preview-card .col-title,
    .invoice-add .invoice-preview-card .col-title {
    position: absolute;
    top: -1.75rem; }

    .invoice-edit .invoice-preview-card .item-options-menu,
    .invoice-add .invoice-preview-card .item-options-menu {
    min-width: 20rem; }

    .invoice-edit .invoice-preview-card .repeater-wrapper:not(:last-child),
    .invoice-add .invoice-preview-card .repeater-wrapper:not(:last-child) {
    margin-bottom: 3rem; }

    .invoice-edit .invoice-preview-card .invoice-calculations .total-amt-title,
    .invoice-add .invoice-preview-card .invoice-calculations .total-amt-title {
    width: 100px; }

    @media (max-width: 769px) {
    .invoice-edit .invoice-preview-card .invoice-title,
    .invoice-add .invoice-preview-card .invoice-title {
    margin-right: 0;
    width: 115px; }
    .invoice-edit .invoice-preview-card .invoice-edit-input,
    .invoice-add .invoice-preview-card .invoice-edit-input {
    max-width: 100%; } }

    @media (max-width: 992px) {
    .invoice-edit .col-title,
    .invoice-add .col-title {
    position: unset !important;
    top: -1.5rem !important; } }

    </style>
