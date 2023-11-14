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
                                <router-link to="/petty_cash/detail" style="text-decoration: none;">Petty Cash Detail(s)</router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                New Petty Cash
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
                                            <div v-for='companydetail1 in companydetail' style="margin-left:30px" >
                                                <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                                    <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail1.company_name}}</h3>
                                                </div>
                                                <p class="card-text mb-25">Address: {{companydetail1.company_address}} , </p> <p class="card-text mb-25">City: {{companydetail1.city}} - {{companydetail1.country}}</p>
                                                <p class="card-text mb-0">Phone: {{companydetail1.phone_number}}</p>
                                            </div>
                                            <div class="invoice-number-date mt-md-0 mt-2">

                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="title">Date:<span style="color: #DB4437; font-size: 11px;">*</span></span>
                                                    <input readonly type="date" v-model="date" class="form-control invoice-edit-input " />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{e_date}}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Create Petty Cash</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Department/Company Name:</h6>
                                                <div class="invoice-customer">
                                                <input readonly v-model="dept_name"  class="form-control" />

                                                    <span style="color: #DB4437; font-size: 11px;" v-if="dept_name==''">{{e_dept_name}}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- <br> -->
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                   <div class="row">
                                  <div class="col-md-7"></div>
                                 <div class="col-md-3" style="text-align: right;
                                padding-top: 20px;">
                                <button class="btn btn-primary" @click="sum_total()">Calculate Total</button>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                <label>Total Amount</label>
                                <input class="form-control" type="text" v-model="total_value" style="" />
                                </div>
                                </div>

                                    </div>
            <div class="form-group xz_form  row animated slideInDown" v-for="count in counter" :id="count" :key="count" style="margin-top:40px">
                <div data-repeater-list="" class="col-lg-12">
                    <slot class="source-item">
                        <div data-repeater-list="group-a">
                            <div class="repeater-wrapper" data-repeater-item>
                                <div class="row">
                                    <div class="col-12 d-flex product-details-border position-relative pe-0">
                                        <div class="row w-100 pe-lg-0 pe-1 py-2">
                                            <div class="col-lg-6 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                <p class="card-text col-title mb-md-50 mb-0">Vendor Name</p>
                                                <input class="form-control" type="text" name="first[]" style="" placeholder="vendor name..." />

                                                 <textarea class="form-control mt-2" rows="1" name="fourth[]" placeholder="Item Detail"></textarea>
                                            </div>

                                            <div class="col-lg-4 col-12 my-lg-0 my-2">
                                                <p class="card-text col-title mb-md-2 mb-0">Bill No</p>
                                                <input type="text" class="form-control"  placeholder="bill no..." name="second[]" />
                                            </div>

                                            <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                <p class="card-text col-title mb-md-2 mb-0">Amount</p>
                                                <input type="number" class="form-control" name="third[]"  />
                                            </div>
                                        </div>
                                        <div style="margin-left:10px" class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">

                                            <div class="delete_btn" style="border-radius:14px;">
                                                <div data-repeater-delete="" class="" style="margin-right: 6px;" v-on:click="delete_xz_form(count)">
                                                    <span style="padding-top: 14px;padding-left: 7px;">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </slot>
                </div>
            </div>

                                        <div class="row mt-1">
                                            <div class="col-12 px-0">
                                                <div data-repeater-create="" class="btn btn-primary btn-sm btn-add-new" v-on:click="add_xz_repeater();">
                                                    <i data-feather="plus" class="me-25"></i>
                                                    <span class="align-middle">Add Item</span>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <!-- Product Details ends -->
                                    <!-- Invoice Total starts -->

                                    <!-- Invoice Total ends -->
                                    <hr class="invoice-spacing mt-0" />
                                    <div class="card-body invoice-padding py-0">
                                        <!-- Invoice Note starts -->
                                        <!-- Invoice Note ends -->
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Add Left ends -->
                            <!-- Invoice Add Right starts -->
                            <div class="col-xl-3 col-md-4 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Post </button>
                                        <!-- <a href="#" class="btn btn-outline-primary w-100 mb-75"> Post & Preview</a> -->

                                    </div>
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

    export default {
        data() {
            return {
                counter: 1,
                companydetail: {},
                date: new Date().toJSON().slice(0, 10),
                dept_name: '',
                e_date: '',
                e_dept_name: '',

                disabled: false,
                timeout: null,

                user_access: {},



                get_unit:{},
                get_dept:{},
                get_project:{},
                get_items:{},
                total_value:'',

            }
        },
        methods: {
        sum_total() {


             var third = document.getElementsByName('third[]');
            var n = 0;
            for (var h = 0; h < third.length; h++) {
                var d = third[h];
                n = Number(n) + Number(d.value);
            }
            this.total_value = n;

        },
        intervalFetchData: function() {
            setInterval(() => {
               this.sum_total();
            }, 1000);
        },
            create_pc() {
                if (this.date == '' || this.dept_name == '' || this.project_name=='') {

                    if (this.date == '') {
                        this.e_date = "Please Select Date";
                    }

                    if (this.dept_name == '') {
                        this.e_dept_name = "Please enter department name";
                    }

                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {

var vendor_name = document.getElementsByName('first[]');
var bill_no = document.getElementsByName('second[]');
var amount = document.getElementsByName('third[]');
var item_detail = document.getElementsByName('fourth[]');



var k = 'zero';
var l = 'zero';
var m = 0;
var n = 'zero';


for (var i = 0; i < vendor_name.length; i++) {
var a = vendor_name[i];
k = k + "|" + a.value;
}

for (var g = 0; g < amount.length; g++) {
var c = amount[g];
m = m + "|" + c.value;
}

for (var h = 0; h < item_detail.length; h++) {
var d = item_detail[h];
n = n + "|" + d.value;
}

for (var g = 0; g < amount.length; g++) {
var c = amount[g];

m = m + "|" + c.value;
}
for (var j = 0; j < bill_no.length; j++) {

var b = bill_no[j];
l = l + "|" + b.value;
}

axios.post('accounts/insert_pettycash', {
vendor_name: k,
bill_no: l,
amount: m,
item_detail: n,
date: this.date,
dept_name: this.dept_name,
total:this.total_value
})
.then(data => {

if(data.data=="submitted"){
   this.$toastr.s("Petty Cash submitted Successfully", "Congratulations!");
    this.$router.push({ name: 'petty_cash_detail'})
}else if (data.data == "Empty field") {
                                this.$toastr.e("Some fields are empty or not fill properly", "Error!");
                            }
                            else if (data.data == "Access not allowed") {
                                this.$toastr.e("Access not allowed", "Error!");
                            }
                            else if (data.data == "Amount Cannot be Negative") {
                                this.$toastr.e("Amount Cannot be Negative", "Error!");
                            }

})





                }
            },
            add_xz_repeater() {
                this.counter++;

            },
            delete_xz_form(id) {

                const r = confirm("Are you sure?");
                if (r == true) {
                    let node = document.getElementById(id);
                    node.remove();

                }
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.create_pc()
            },
            get_projectlist(){
             axios.get('accounts/get_projects/'+this.dept_name)
                .then(response => this.get_project = response.data)
            },
            find_services(){

            if(this.status=='Goods'){

             axios.get('accounts/get_items/'+this.status)
                .then(response => this.get_items = response.data)
            }
            else if(this.status=='Assets')
            {

             axios.get('accounts/get_items/'+this.status)
                .then(response => this.get_items = response.data)
            }
            else
             {

             axios.get('accounts/get_services')
                .then(response => this.get_items = response.data)
            }

            }
        },
        mounted() {
        this.intervalFetchData();
            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
            axios.get('accounts/get_dept')
                .then(response => this.get_dept = response.data)

          axios.get('accounts/get_items/'+this.status)
                .then(response => this.get_items = response.data)

            axios.get('accounts/get_units')
                .then(response => this.get_unit = response.data)
                axios.get('./fetch_user_accounts_roles')
                .then(response => {
                this.user_access = response.data;
                this.dept_name=this.user_access.dept;
                })
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
        padding-right: 2.5rem;
    }

    .invoice-preview .table th:first-child,
    .invoice-preview .table td:first-child,
    .invoice-edit .table th:first-child,
    .invoice-edit .table td:first-child,
    .invoice-add .table th:first-child,
    .invoice-add .table td:first-child {
        padding-left: 2.5rem;
    }

    .invoice-preview .logo-wrapper,
    .invoice-edit .logo-wrapper,
    .invoice-add .logo-wrapper {
        display: flex;
        align-items: center;
        margin-bottom: 1.9rem;
    }

        .invoice-preview .logo-wrapper .invoice-logo,
        .invoice-edit .logo-wrapper .invoice-logo,
        .invoice-add .logo-wrapper .invoice-logo {
            font-size: 2.142rem;
            font-weight: bold;
            letter-spacing: -0.54px;
            margin-left: 1rem;
            margin-bottom: 0;
        }

    .invoice-preview .invoice-title,
    .invoice-edit .invoice-title,
    .invoice-add .invoice-title {
        font-size: 1.285rem;
        margin-bottom: 1rem;
    }

        .invoice-preview .invoice-title .invoice-number,
        .invoice-edit .invoice-title .invoice-number,
        .invoice-add .invoice-title .invoice-number {
            font-weight: 600;
        }

    .invoice-preview .invoice-date-wrapper,
    .invoice-edit .invoice-date-wrapper,
    .invoice-add .invoice-date-wrapper {
        display: flex;
        align-items: center;
    }

        .invoice-preview .invoice-date-wrapper:not(:last-of-type),
        .invoice-edit .invoice-date-wrapper:not(:last-of-type),
        .invoice-add .invoice-date-wrapper:not(:last-of-type) {
            margin-bottom: 0.5rem;
        }

        .invoice-preview .invoice-date-wrapper .invoice-date-title,
        .invoice-edit .invoice-date-wrapper .invoice-date-title,
        .invoice-add .invoice-date-wrapper .invoice-date-title {
            width: 7rem;
            margin-bottom: 0;
        }

        .invoice-preview .invoice-date-wrapper .invoice-date,
        .invoice-edit .invoice-date-wrapper .invoice-date,
        .invoice-add .invoice-date-wrapper .invoice-date {
            margin-left: 0.5rem;
            font-weight: 600;
            margin-bottom: 0;
        }

    .invoice-preview .invoice-spacing,
    .invoice-edit .invoice-spacing,
    .invoice-add .invoice-spacing {
        margin: 1.45rem 0;
    }

    .invoice-preview .invoice-number-date .title,
    .invoice-edit .invoice-number-date .title,
    .invoice-add .invoice-number-date .title {
        width: 115px;
    }

    .invoice-preview .invoice-total-wrapper,
    .invoice-edit .invoice-total-wrapper,
    .invoice-add .invoice-total-wrapper {
        width: 100%;
        max-width: 12rem;
    }

        .invoice-preview .invoice-total-wrapper .invoice-total-item,
        .invoice-edit .invoice-total-wrapper .invoice-total-item,
        .invoice-add .invoice-total-wrapper .invoice-total-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

            .invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-title,
            .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-title,
            .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-title {
                margin-bottom: 0.35rem;
            }

            .invoice-preview .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
            .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-amount,
            .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-amount {
                margin-bottom: 0.35rem;
                font-weight: 600;
            }

    @media (min-width: 768px) {
        .invoice-preview .invoice-title,
        .invoice-edit .invoice-title,
        .invoice-add .invoice-title {
            text-align: right;
            margin-bottom: 3rem;
        }
    }

    .invoice-edit .invoice-preview-card .invoice-title,
    .invoice-add .invoice-preview-card .invoice-title {
        text-align: left;
        margin-right: 3.5rem;
        margin-bottom: 0;
    }

    .invoice-edit .invoice-preview-card .invoice-edit-input,
    .invoice-edit .invoice-preview-card .invoice-edit-input-group,
    .invoice-add .invoice-preview-card .invoice-edit-input,
    .invoice-add .invoice-preview-card .invoice-edit-input-group {
        max-width: 11.21rem;
    }

    .invoice-edit .invoice-preview-card .invoice-product-details,
    .invoice-add .invoice-preview-card .invoice-product-details {
        background-color: #fcfcfc;
        padding: 3.75rem 3.45rem 2.3rem 3.45rem;
    }

        .invoice-edit .invoice-preview-card .invoice-product-details .product-details-border,
        .invoice-add .invoice-preview-card .invoice-product-details .product-details-border {
            border: 1px solid #ebe9f1;
            border-radius: 0.357rem;
        }

    .invoice-edit .invoice-preview-card .invoice-to-title,
    .invoice-add .invoice-preview-card .invoice-to-title {
        margin-bottom: 1.9rem;
    }

    .invoice-edit .invoice-preview-card .col-title,
    .invoice-add .invoice-preview-card .col-title {
        position: absolute;
        top: -1.75rem;
    }

    .invoice-edit .invoice-preview-card .item-options-menu,
    .invoice-add .invoice-preview-card .item-options-menu {
        min-width: 20rem;
    }

    .invoice-edit .invoice-preview-card .repeater-wrapper:not(:last-child),
    .invoice-add .invoice-preview-card .repeater-wrapper:not(:last-child) {
        margin-bottom: 3rem;
    }

    .invoice-edit .invoice-preview-card .invoice-calculations .total-amt-title,
    .invoice-add .invoice-preview-card .invoice-calculations .total-amt-title {
        width: 100px;
    }

    @media (max-width: 769px) {
        .invoice-edit .invoice-preview-card .invoice-title,
        .invoice-add .invoice-preview-card .invoice-title {
            margin-right: 0;
            width: 115px;
        }

        .invoice-edit .invoice-preview-card .invoice-edit-input,
        .invoice-add .invoice-preview-card .invoice-edit-input {
            max-width: 100%;
        }
    }

    @media (max-width: 992px) {
        .invoice-edit .col-title,
        .invoice-add .col-title {
            position: unset !important;
            top: -1.5rem !important;
        }
    }
</style>
