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
                            <li class="breadcrumb-item active">Units Electricity
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-5 col-lg-5 ps-xl-75 ps-0 d-flex">
                                        <div class="col-md-6 col-12 mb-3 position-relative ">
                                            <h5 style="margin-top:30px;">Net Booking Amount: {{Math.floor(get_sum).toLocaleString()}}</h5>
                                        </div>
                                        <div class="col-md-5 col-12 mb-3 position-relative mx-4">
                                            <h5 style="margin-top:30px;">Selected: {{Math.floor(get_sum_total).toLocaleString()}}</h5>
                                        </div>

                                </div>
                                <div class="col-sm-7 col-lg-7 ps-xl-75 ps-0" v-if="hasPermission('Units-Management units-data supervision')">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invoice_status ms-sm-2" >

                                            <button :disabled="disabled1" style="float:left" @click="delay1()"  class="btn btn-primary waves-effect">Proceed</button>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Plot Type</th>
                                            <th>Block Name</th>
                                            <th>Booking Amount</th>
                                            <th><input type="checkbox" v-model="test" @change="toggling()" id="maincheck" /></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1">{{adsdata1.Dated}}</td>
                                            <td>{{adsdata1.Plot_Type}}</td>
                                            <td>{{adsdata1.Block}}</td>
                                            <td>Rs. {{Number(adsdata1.Total).toLocaleString()}}/-</td>
                                            <td>
                                                <div class="d-flex align-items-center col-actions">
                                                <input readonly name="first[]" :value="adsdata1.EID" hidden class="form-control invoice-edit-input " />
                                                <input style="margin-top: 10px;margin-left: 5px;" class="form-check-input" type="checkbox" v-if="toggle" @change="sum_total(adsdata1.Total,adsdata1.EID)"
                                                           name="second[]"
                                                           :id="('inlineRadio1'+adsdata1.EID)" checked />
                                                    <input style="margin-top: 10px;margin-left: 5px;" v-else class="form-check-input" type="checkbox" @change="sum_total(adsdata1.Total,adsdata1.EID)"
                                                           name="second[]"
                                                           :id="('inlineRadio1'+adsdata1.EID)" />
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
import MaskedInput from 'vue-masked-input'
export default {
    data() {
        return {
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
            toggle: false,
            get_sum_total :0,
            get_sum:0,

        }
    },

    methods: {
        toggling() {
        this.toggle = !this.toggle;
            var added = document.getElementsByName('second[]');
        for (var g = 0; g < added.length; g++) {
                        if (added[g] != this.test){
                        added[g].checked = this.test;
                        }
                        if (added[g].checked) {
                        this.get_sum_total = this.get_sum
                    }
                    if (!added[g].checked) {
                        this.get_sum_total = 0
                    }
                    }
        },
        sum_total(Amount, id) {
                let inlineRadio1 = document.getElementById("inlineRadio1" + id)
                var added = document.getElementsByName('second[]');
                for (var g = 0; g < added.length; g++) {
                    if (!added[g].checked) {
                        var maincheck = document.getElementById('maincheck');
                        maincheck.checked = false
                    }
                }
                if (inlineRadio1.checked) {
                    this.get_sum_total = Number(this.get_sum_total) + Number(Amount)

                } else {
                    this.get_sum_total = Number(this.get_sum_total) - Number(Amount)
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
						axios.post('./accounts/submit_unitelectricity', {
								id:k,
								added:addpurchase,
							})
                        .then(data => {

                          if(data.data=='submitted'){
                           this.$toastr.s("Ledger Hit Successfully", "Congratulations!");
                          this.getResult();
                          var added = document.getElementsByName('second[]');
                            for (var g = 0; g < added.length; g++) {
                                added[g].checked = false

                            }
                            var maincheck = document.getElementById('maincheck');
                            maincheck.checked = false
                            this.get_sum_total = 0
                          }
                          else if(data.data=='Amount Cannot be Negative'){
                           this.$toastr.e("Amount Cannot be Negative", "Error!");
                          this.getResult();
                          }
                          else if(data.data=='Select Data'){
                           this.$toastr.e("Please select data to proceed", "Error!");
                          this.getResult();
                          }
                        })
        },



        getResult(page = 1) {
            axios.get('accounts/pending_electricity_detail/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
                axios.get('accounts/pending_Electricity_sum')
                .then(response => this.get_sum = response.data)
        },
        getResults() {
            axios.get('accounts/search_electricity_name/' + this.keyword1)
                .then(response => {

                    this.adsdata = response.data
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
    }
}

</script>
