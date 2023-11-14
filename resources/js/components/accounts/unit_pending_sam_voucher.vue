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
                            <li class="breadcrumb-item">
                                <router-link to="/Accounts/cash_counter" style="text-decoration: none;">Daily Counter</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                SAM Payment Vouchers
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center header-actions row mt-75" style="margin:10px;">
                                <div class="col-md-12 row">
                                    <div class="col-md-1 col-12">
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <h5>Total Amount: {{Math.floor(get_sum).toLocaleString()}}</h5>
                                    </div>
                                    <div class="col-md-1 col-12">
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <h5>Selected Amount: {{Math.floor(get_sum_total).toLocaleString()}}</h5>
                                    </div>
                                    <div class="col-md-1 col-12">
                                        <button :disabled="disabled1" @click="proced_booking()" class="btn btn-primary waves-effect">Proceed</button>
                                    </div>
                                    <div class="col-md-1 col-12">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Date</th>
                                            <th class="sticky-th-center">Receipt No</th>
                                            <th class="sticky-th-center">File/Plot<br />Number</th>
                                            <th class="sticky-th-left">Name</th>
                                            <th class="sticky-th-center">Payment<br />Type</th>
                                            <th class="sticky-th-center">Type</th>
                                            <th class="sticky-th-center">Module</th>
                                            <th class="sticky-th-center">Plot Type</th>
                                            <th class="sticky-th-center">Block</th>
                                            <th class="sticky-th-center">Amount</th>
                                            <th class="sticky-th-center" style="min-width:100px;">{{Math.floor(get_sum_total).toLocaleString()}}<br /> <input :disabled="disabled" type="checkbox" v-model="test" @change="toggling()" id="maincheck" /></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr :class="'demo_'+(index)" v-for="(adsdata1, index) in adsdata" :id="'demo_'+(index)">
                                            <td class="td-center">{{adsdata1.DateTime}}</td>
                                            <td class="td-center">{{adsdata1.ReceiptNo}}</td>
                                            <td class="td-center">{{adsdata1.File_Plot_No}}</td>
                                            <td class="td-left">{{adsdata1.Name}}</td>
                                            <td class="td-center">{{adsdata1.PaymentType}}</td>
                                            <td class="td-center">{{adsdata1.Type}}</td>
                                            <td class="td-center">{{adsdata1.Module}}</td>
                                            <td class="td-center">{{adsdata1.Plot_Type}}</td>
                                            <td class="td-center">{{adsdata1.Block}}</td>
                                            <td class="td-center">Rs. {{Number(adsdata1.Amount).toLocaleString()}}/-</td>
                                            <td class="td-center" v-if="adsdata1.PaymentType=='Cash'">
                                                <input readonly name="first[]" :value="adsdata1.ID" hidden class="form-control invoice-edit-input " />
                                                <input @change="sum_total(adsdata1.Amount, adsdata1.ID)" class="form-check-input" type="checkbox" name="second[]" :id="('inlineRadio1'+adsdata1.ID)" />
                                            </td>
                                            <td class="td-center" v-else></td>
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
    export default {
        data() {
            return {
                tclass: 'table-primary',
                get_sum_total: 0,
                test: '',
                get_sum: {},
                adsdata: {},
                toggle: false,
                disabled: false,
                disabled1: false,
            }
        },
        methods: {
            sum_total(Amount, id) {
                let inlineRadio1 = document.getElementById("inlineRadio1" + id)
                var added = document.getElementsByName('second[]');
                for (var g = 0; g < added.length; g++) {
                    if (!added[g].checked) {
                        var maincheck = document.getElementById('maincheck');
                        maincheck.checked = false;
                        document.getElementById("demo_" + g).className = 'table-default';
                    }
                    else {
                        document.getElementById("demo_" + g).className = 'table-active';
                    }
                }
                if (inlineRadio1.checked) {
                    this.get_sum_total = Number(this.get_sum_total) + Number(Amount);
                }
                else {
                    this.get_sum_total = Number(this.get_sum_total) - Number(Amount)
                }
            },
            toggling() {
                this.toggle = !this.toggle;
                var added = document.getElementsByName('second[]');
                for (var g = 0; g < added.length; g++) {
                    if (added[g] != this.test) {
                        added[g].checked = this.test;
                        document.getElementById("demo_" + g).className = 'table-active';
                    }
                    if (added[g].checked) {
                        this.get_sum_total = this.get_sum;
                    }
                    if (!added[g].checked) {
                        this.get_sum_total = 0;
                        document.getElementById("demo_" + g).className = 'table-default';
                    }
                }
            },
            proced_booking() {
                this.disabled1 = true;
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
                axios.post('./accounts/submit_unitsam', {
                    id: k,
                    added: addpurchase,
                })
                    .then(data => {
                        if (data.data == 'submitted') {
                            var maincheck = document.getElementById('maincheck');
                            maincheck.checked = false;
                            var added = document.getElementsByName('second[]');
                            for (var g = 0; g < added.length; g++) {
                                added[g].checked = false;
                            }
                            this.$toastr.s("Ledger has been affected successfully!", "Congratulations!");
                            this.getResult();
                            this.disabled1 = false;
                        }
                    })
            },
            getResult(page = 1) {
                axios.get('accounts/pending_sam_voucher_detail/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });

                axios.get('accounts/get_sam_sum')
                    .then(response => this.get_sum = response.data)
            },
        },
        mounted() {
            this.getResult();
        }
    }
</script>
