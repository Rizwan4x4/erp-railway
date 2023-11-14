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
                                Units Cash Receivables
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-list">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-md-12 row">
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
                                            <button @click="filtered_GRN()" style="margin-top: 25px;" class="btn btn-secondary waves-effect waves-float waves-light">Search</button>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3 position-relative">
                                            <h5 style="margin-top:30px;">Net Cash Amount: {{Math.floor(get_sum.cash).toLocaleString()}}</h5>
                                        </div>
                                        <div class="col-md-3 col-12 mb-3 position-relative">
                                            <h5 style="margin-top:30px;">Selected: {{Math.floor(get_sum_total).toLocaleString()}}</h5>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3 position-relative">
                                            <h5 style="margin-top:30px;">Net Proceeded Amount: {{Math.floor(get_proceed.cash).toLocaleString()}}</h5>
                                        </div>
                                        <div class="col-md-4 col-12 mb-3 position-relative">
                                            <h5 style="margin-top:30px;">Proceeded Entries Count: {{get_proceed.count}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 row" v-if=" this.$helpers.hasPermission('Units-Management units-data supervision')">
                                    <div class="col-md-3">
                                        <label class="form-label">Users</label>
                                        <select @change="getResult()" v-model="select_user" class="form-select">
                                            <option value="All">All Users</option>
                                            <option v-for='users1 in users' :value='users1.UserID'>{{users1.Name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date</label>
                                        <input type="date" @change="getResult()" v-model="dated" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Type</label>
                                        <multiselect @input="getResult()" placeholder="All Types" :show-labels="false" v-model="select_type" :options="options">
                                        </multiselect>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Company</label>
                                        <select @change="getResult()" v-model="select_category" class="form-select ms-50 ">
                                            <option value="Both">Both (SAM & SA Gardens)</option>
                                            <option value="SAM">SAM</option>
                                            <option value="SAGardens">SA Gardens</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label"> </label>
                                        <button :disabled="disabled1" style="float:left" @click="delay1()" class="btn btn-primary waves-effect">Proceed</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Sr.No</th>
                                            <th class="sticky-th-center">Date</th>
                                            <th class="sticky-th-left">Receipt No</th>
                                            <th class="sticky-th-left">File Plot No</th>
                                            <th class="sticky-th-left">Name</th>
                                            <th class="sticky-th-left">Type</th>
                                            <th class="sticky-th-left">Module</th>
                                            <th class="sticky-th-center">Block &<br />Plot Type</th>
                                            <th class="sticky-th-center">Amount</th>
                                            <th class="sticky-th-center"><br /> <input :disabled="disabled" type="checkbox" v-model="test" @change="toggling()" id="maincheck" /></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="(adsdata1,index) in adsdata">
                                            <td class=" control" tabindex="0">{{sumStats1(index,1) }}</td>
                                            <td class="sorting_1">{{adsdata1.DateTime}}</td>
                                            <td>{{adsdata1.ReceiptNo}}<br />{{adsdata1.PaymentType}}</td>
                                            <td>{{adsdata1.File_Plot_No}}</td>
                                            <td>{{adsdata1.Name}}</td>
                                            <td>{{adsdata1.Type}}</td>
                                            <td>{{adsdata1.Module}}</td>
                                            <td>{{adsdata1.Block}}<br />{{adsdata1.Plot_Type}}</td>
                                            <td>Rs. {{Number(adsdata1.Amount).toLocaleString()}}/-</td>
                                            <td>
                                                <div class="d-flex align-items-center col-actions">
                                                    <input readonly name="first[]" :value="adsdata1.CashID" hidden class="form-control invoice-edit-input " />
                                                    <input readonly name="third[]" hidden :value="adsdata1.Amount" class="form-control invoice-edit-input " />
                                                    <input style="margin-top: 10px;margin-left: 5px;" class="form-check-input" type="checkbox" v-if="toggle" @change="sum_total(adsdata1.Amount,adsdata1.CashID)"
                                                           name="second[]"
                                                           :id="('inlineRadio1'+adsdata1.CashID)" checked />
                                                    <input style="margin-top: 10px;margin-left: 5px;" v-else class="form-check-input" type="checkbox" @change="sum_total(adsdata1.Amount,adsdata1.CashID)"
                                                           name="second[]"
                                                           :id="('inlineRadio1'+adsdata1.CashID)" />
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
    export default {
        data() {
            return {
                get_proceed:{},
                trans_types: {},
                options: [],
                select_type: 'All',
                select_type1: 'All',

                dated: new Date().toJSON().slice(0, 10),
                adsdata: {},
                get_sum_total: 0,
                toggle: false,
                keyword1: '',
                disabled: false,
                disabled1: false,

                users: {},
                select_user: 'All',
                get_sum: {},
                test: '',
                select_category: 'Both',
                datefrom: '',
                dateto: '',
            }
        },
        components: {
            Multiselect
        },
        methods: {
            filtered_GRN() {
                if (this.dateto == '' || this.datefrom == '') {
                    this.$toastr.e("Please select Both Dates!", "Caution!");
                }
                else {
                    this.disabled1 = true;
                    this.disabled = true;
                    if (this.select_type == '' || this.select_type == null) {
                        this.select_type1 = 'All';
                    }
                    else {
                        this.select_type1 = this.select_type;
                    }

                    axios.get("accounts/search_units_cash_only/" + this.datefrom + "/" + this.dateto + '/' + this.select_category + '/' + this.select_user + '/' + this.select_type1)
                        .then(data => {
                            this.adsdata = data.data;
                            this.disabled1 = false;
                            this.disabled = false;
                        })
                        .catch(error => this.error = error.response.data.errors)

                    axios.get('./accounts/search_units_cash_only_counter/' + this.datefrom + "/" + this.dateto + '/' + this.select_category + '/' + this.select_user + '/' + this.select_type1)
                        .then(response => {
                            this.get_sum = response.data;
                        })
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
            sumStats1(num1, num2) {
                return parseInt(num1) + parseInt(num2);
            },
            toggling() {
                this.toggle = !this.toggle;
                var added = document.getElementsByName('second[]');
                for (var g = 0; g < added.length; g++) {
                    if (added[g] != this.test) {
                        added[g].checked = this.test;

                    }
                    if (added[g].checked) {
                        this.get_sum_total = this.get_sum.cash
                    }
                    if (!added[g].checked) {
                        this.get_sum_total = 0
                    }
                }
            },
            searchuser() {
                axios.get('accounts/search_r_byname_cash/' + this.select_user)
                    .then(response => {
                        this.adsdata = response.data
                    })
                    .catch(error => console.log(error));
                axios.get('./accounts/get_counter_sum/' + this.select_user)
                    .then(response => this.get_sum = response.data)
            },
            delay1() {
                this.disabled1 = true
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
                axios.post('./accounts/submit_unitcash', {
                    id: k,
                    added: addpurchase,
                    
                })
                    .then(data => {
                        if (data.data == 'submitted') {
                            this.$toastr.s("Ledger Hit Successfully", "Congratulations!");
                            var added = document.getElementsByName('second[]');
                            for (var g = 0; g < added.length; g++) {
                                added[g].checked = false

                            }
                            var maincheck = document.getElementById('maincheck');
                            maincheck.checked = false
                            this.get_sum_total = 0
                            this.getResult();
                            this.disabled1 = false;
                        }
                        else if (data.data == 'Account Head Not Linked') {
                            this.$toastr.e("Transaction Type Not Linked with Accounts COA", "Cautions!");
                            this.disabled1 = false;
                        }
                    })
            },
            getResult() {
                this.disabled1 = true;
                this.disabled = true;
                if (this.select_type == '' || this.select_type == null) {
                    this.select_type1 = 'All';
                }
                else {
                    this.select_type1 = this.select_type;
                }
                axios.get('accounts/pending_cash_detail/' + this.select_user + '/' + this.dated + '/' + this.select_category + '/' + this.select_type1)
                    .then(response => {
                        this.adsdata = response.data;
                        this.disabled1 = false;
                        this.disabled = false;
                        let liaS = response.data.map((curEle) => {
                            return curEle.Amount
                        }).reduce((accu, curr) => {
                            return Number(accu) + Number(curr)
                        }, 0)
                        this.get_sum1 = liaS
                    })
                    .catch(error => { });

                axios.get('./accounts/get_counter_sum/' + this.select_user + '/' + this.dated + '/' + this.select_category + '/' + this.select_type1)
                    .then(response => this.get_sum = response.data)
                    axios.get('./accounts/proceed_cash/' + this.select_user + '/' + this.dated + '/' + this.select_category + '/' + this.select_type1)
                    .then(response => this.get_proceed = response.data)
            },
            getResults() {
                axios.get('accounts/search_booking_name/' + this.keyword1)
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
            axios.get('./accounts/get_cashcounter_user')
                .then(response => this.users = response.data)

            axios.get('accounts/unit_trans_type')
                .then(response => {
                    this.trans_types = response.data;

                    this.options = [];

                    var $this = this;
                    for (var i = 0; i < $this.trans_types.length; i++) {
                        this.options.push($this.trans_types[i].Type);
                    }
                })
                .catch(error => { });
        }
    }
</script>
