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
                             <li class="breadcrumb-item">
                                <router-link to="/Accounts/cash_counter" style="text-decoration: none;">Daily Counter</router-link>
                            </li>
                            <li class="breadcrumb-item active">Units Pending Adjustment
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-3 col-lg-3 ps-xl-75 ps-0">
                                   <input type="date" @change="getResult()" v-model="dated" class="form-control" />
                                <h6>Not Supervised Amount: {{Number(get_sum.cash).toLocaleString()}}</h6>

                                </div>
                                <div class="col-sm-3 col-lg-3 ps-xl-75 ps-0" style="margin-top: -23px;">
                                <select v-model="bank_type" @change="getResult()" class="invoiceto form-select">
                                    <option value='All'>Both</option>
                                     <option value='HBL'>HBL</option>
                                     <option value='DIB'>DIB</option>
                                </select>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0" v-if=" hasPermission('Units-Management units-data supervision')">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px;width:300px;margin-bottom:19px">
                                                <multiselect style="margin-right: 10px;" :show-labels="false"
                                                                 v-model="deposit_bank" :options="options">
                                                    </multiselect>
                                                    <span style="color: #DB4437; font-size:11px;" v-if="deposit_bank==''">{{e_deposit_bank}}</span>
                                            </div>
                                        </div>
                                        <div class="invoice_status ms-sm-2" >
                                            <button style="float:left;margin-bottom:20px;" @click="delay1()"  class="btn btn-primary waves-effect">Proceed</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Receipt No</th>
                                            <th>File Plot No</th>
                                            <th>Name</th>
                                            <th>Payment Type</th>
                                             <th>Type</th>
                                            <th>Module</th>
                                            <th>Plot_Type</th>
                                            <th>Block</th>
                                            <th>Amount</th>
                                           <th> <input type="checkbox" v-model="test" @change="toggle()" /></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata">
                                           <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1">{{adsdata1.DateTime}}</td>
                                            <td>{{adsdata1.ReceiptNo}}</td>
                                            <td>{{adsdata1.File_Plot_No}}</td>
                                            <td>{{adsdata1.Name}}</td>
                                            <td>{{adsdata1.PaymentType}}</td>
                                            <td>{{adsdata1.Type}}</td>
                                            <td>{{adsdata1.Module}}</td>
                                             <td>{{adsdata1.Plot_Type}}</td>
                                            <td>{{adsdata1.Block}}</td>
                                            <td>Rs. {{Number(adsdata1.Amount).toLocaleString()}}/-</td>
                                            <td>
                                                <div class="d-flex align-items-center col-actions">
                                                <input readonly name="first[]" :value="adsdata1.AdjustID" hidden  class="form-control invoice-edit-input " />
                                                  <input style="margin-top: 10px;margin-left: 5px;" class="form-check-input" type="checkbox"
                                                                   name="second[]"
                                                                   id="inlineRadio1" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import MaskedInput from 'vue-masked-input'
export default {
    data() {
        return {
            dated:new Date().toJSON().slice(0, 10),
            adsdata: {

            },
            up_sts: '',
            e_up_sts: '',
            companydetail: {},
            paymentVchrs: {},
            success: '',
            pv_id:'',
            keyword1: '',
            disabled1: false,
            timeout1: null,
            users:{},
            select_user:'All',
            get_sum:{},

            deposit_bank:'',
            options:[],
            e_deposit_bank:'',
            test:'',

            bank_type:'All',
        }
    },
   components: { Multiselect },
    methods: {
   toggle() {
            //var checkboxes = document.querySelectorAll('input[type="checkbox"]');

            var added = document.getElementsByName('second[]');
        for (var g = 0; g < added.length; g++) {
                        if (added[g] != this.test){
                        added[g].checked = this.test;
                        }


                    }

        },
        delay1() {
            this.disabled1 = true
            this.timeout1 = setTimeout(() => {
                this.disabled1 = false
            }, 5000)
            this.proced_booking();
        },
        proced_booking() {
        if(this.deposit_bank==''){
         this.$toastr.e("Select Bank Ledger", "Cautions!");
        }
        else {
        var item_name = document.getElementsByName('first[]');
       var added = document.getElementsByName('second[]');
       var k = 'zero';
         var addpurchase = 'zero';
         for (var i = 0; i < item_name.length; i++) {
                        var a = item_name[i];
                        k = k + "|" + a.value;
                    }
                for (var g = 0; g < added.length; g++) {
                        var fnn = added[g];
                        addpurchase = addpurchase + "|" + fnn.checked;
                    }
                        axios.post('./accounts/submit_unitonlinecash_adjust', {
                                id:k,
                                added:addpurchase,
                                deposit_bank:this.deposit_bank
                            })
                        .then(data => {
                          if(data.data=='submitted'){
                           this.$toastr.s("Ledger Hit Successfully", "Congratulations!");
                          this.getResult();

                          }
                        })
        }

        },



        getResult() {
            axios.get('accounts/pending_onlinecash_adjust/'+this.dated+'/'+this.bank_type)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
             axios.get('./accounts/get_counter_sum_online_adjust/'+this.dated+'/'+this.bank_type)
            .then(response => this.get_sum = response.data)
        },

    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {
     axios.get('accounts/fetch_bank_methods')
                .then(response => {
                    this.methods = response.data
                    this.options = [];

                    var $this = this;
                    for (var j = 0; j < $this.methods.length; j++) {
                        this.options.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
                    }
                })
        this.getResult();
    }
}

</script>

