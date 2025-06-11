<template>
    <div>
        <div class="app-content content">
            <div class="noprint content-overlay"></div>
            <div class="noprint cheader-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/sales/return" style="text-decoration: none;">Sales Return</router-link>
                            </li>
                            <li class="breadcrumb-item active">Create Sales Return</li>
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
                                            <div class="invoice-number-date col-3 mt-md-0 mt-2">
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="title">Date:<span style="color: #DB4437; font-size: 11px;">*</span></span>
                                                    <input readonly type="date" v-model="date" class="form-control invoice-edit-input " />
                                                </div>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{e_date}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Sales Return</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <div class="form-group">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Against SI:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <div class="invoice-customer">
                                                        <select v-model="sale_inv" @change="get_invoicesale()" class="invoiceto form-select">
                                                            <option value="">Select Invoice</option>
                                                            <option v-for="saleinvoice1 in saleinvoice" :value='saleinvoice1.SalesInvoiceID'>{{saleinvoice1.saleID}}_{{saleinvoice1.CustomerName}}</option>
                                                        </select>
                                                        <span style="color: #DB4437; font-size: 11px;" v-if="sale_inv==''">{{e_si}}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-top:3%;">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Invoice No:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <input type="text" v-model="invoice_no" class="form-control" placeholder='Type return invoice number' />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="invoice_no==''">{{e_invoice_no}}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 p-0 ps-xl-2 mt-xl-0 mt-2">
                                                <div class="form-group">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Customer Name:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <div class="invoice-customer">
                                                        <input type="text" v-model="customer" readonly class="form-control" placeholder='Customer Name Will Display Here' />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <slot class="source-item" v-for="(get_si_detail11, index) in get_si_detail1">
                                            <div data-repeater-list="group-a">
                                                <div class="repeater-wrapper" style="margin-top:30px" data-repeater-item>
                                                    <div class="row">
                                                        <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                <div class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Item</p>
                                                                    <select class="form-select item-details" name="first[]">
                                                                        <option :value='get_si_detail11.ItemId'>{{get_si_detail11.ItemName}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">SaleQuantity</p>
                                                                    <input style="padding-left:0px;padding-right:0px;text-align:center" readonly name="third[]" type="number" class="form-control" :value='get_si_detail11.SaleQuantity' />
                                                                </div>
                                                                <div class="col-lg-1 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Units</p>
                                                                    <input style="padding-left:0px; padding-right:0px; text-align:center" name="second[]" readonly class="form-control" :value='get_si_detail11.Unit' />
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Return Qty</p>
                                                                    <input type="number" class="form-control" style="padding-left:0px;padding-right:0px;text-align:center" name="fourth[]" @change="sum_total()" value="0" />
                                                                </div>
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Unit Cost</p>
                                                                    <input name="fiveth[]" readonly type="number" class="form-control" :value='Number(get_si_detail11.Price)' />
                                                                </div>
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Price</p>
                                                                    <p style="margin-top: 30px;border-radius: 2px;padding-left: 10px;max-width: 100px;height: 35px;" :id="'demo_'+(index)" class="form-control card-text col-title mb-md-50 mb-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </slot>
                                    </div>                           <!-- Invoice Total starts -->
                                    <div class="card-body invoice-padding">
                                        <div class="row invoice-sales-total-wrapper">
                                            <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                                <div class="row form-row mt-50" style="border:1px solid lightgrey; padding-top:10px; padding-bottom:10px; border-radius: 5px !important;">
                                                    <div class="mb-1 col-md-12">
                                                        <label>Select Tax Head </label>
                                                        <select @change="tax()" v-model="select_tax" id="tax-1-input" class="form-select tax-select">
                                                            <option value="">Select Tax</option>
                                                            <option v-for='get_tax1 in get_tax' :value='get_tax1.TaxID'>{{ get_tax1.TaxName}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-1 col-md-12">
                                                        <label>Select Delivery Head </label>
                                                        <select @change="delivery()" v-model="select_delivery" id="tax-1-input" class="form-select tax-select">
                                                            <option value="">Select Delivery</option>
                                                            <option v-for='get_delivery1 in get_delivery' :value='get_delivery1.DID'>{{ get_delivery1.DeliveryName}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-2">
                                                <div class="invoice-total-wrapper" style="max-width: 300px;">
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Subtotal:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="subtotal" type="number" class="form-control" readonly />
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Tax:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="tax_amount" type="number" class="form-control" readonly />
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Delivery:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="delivery_amount" type="number" class="form-control" readonly />
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Discount:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="discount" type="number" class="form-control" />
                                                        </p>
                                                    </div>
                                                    <hr class="my-50" />
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Total:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="total" type="number" class="form-control" readonly />
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Invoice Total ends -->
                                    <hr class="invoice-spacing mt-0" />
                                    <div class="card-body invoice-padding py-0">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label for="note" class="form-label fw-bold">Narration:</label>
                                                <textarea v-model="remarks" class="form-control" rows="2" placeholder="Type narration here" id="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Add Left ends -->
                            <!-- Invoice Add Right starts -->
                            <div class="col-xl-3 col-md-4 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Post Return</button>
                                        <a href="#" class="btn btn-outline-primary w-100 mb-75">Preview</a>
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
    import axios from 'axios';
    export default {
        data() {
            return {
                counter: 1,
                companydetail: {},
                get_delivery: {},
                saleinvoice: {},
                get_si_detail1: {},
                get_tax: {},
                item_name: '',
                item_qty: '',
                item_rqty: '',
                item_price: '',
                item_unit: '',
                date: new Date().toJSON().slice(0, 10),
                e_date: '',
                sale_inv: '',
                e_si: '',
                invoice_no: '',
                e_invoice_no: '',
                customer: '',
                e_vendor: '',
                vendor_data: [],
                poid: '',
                reqid: '',
                select_tax: '',
                select_delivery: '',
                total: '0',
                remarks: '',
                discount: '0',
                delivery_amount: '0',
                tax_amount: '0',
                subtotal: '0',
                get_vendor: [],
                index: '',
                e_status: '',
                e_vendor: '',

                disabled: false,
                timeout: null,
            };
        },
        methods: {
            delivery() {
                axios.get('accounts/select_delivery_value/' + this.select_delivery + '/' + this.subtotal)
                    .then(response => this.delivery_amount = response.data)
            },
            tax() {
                axios.get('accounts/select_tax_value/' + this.select_tax + '/' + this.subtotal)
                    .then(response => this.tax_amount = response.data)
            },
            sum_total() {
                var third = document.getElementsByName('fiveth[]');
                var fourth = document.getElementsByName('fourth[]');
                var m = 0;

                for (var g = 0; g < fourth.length; g++) {
                    var c = fourth[g];
                    var b = third[g];

                    var demo_id = "demo" + g;
                    document.getElementById("demo_" + g).innerHTML = Number(b.value) * Number(c.value);
                    m = Number(m) + (Number(b.value) * Number(c.value));
                }
                this.subtotal = m;
                this.delivery();
                this.tax();
            },
            intervalFetchData: function () {
                setInterval(() => {
                    this.total = Number(this.subtotal) + Number(this.tax_amount) + Number(this.delivery_amount) - Number(this.discount);
                }, 1000);
            },
            delay() {
                this.disabled = true;
                this.timeout = setTimeout(() => {
                    this.disabled = false;
                }, 5000);
                this.post_sales_return();
            },
            post_sales_return() {
                if (this.date == '' || this.sale_inv == '' || this.invoice_no == '') {
                    if (this.date == '') {
                        this.e_date = "Please select date";
                    }
                    else {
                        this.e_date = '';
                    }
                    if (this.sale_inv == '') {
                        this.e_si = "Please select PO";
                    }
                    else {
                        this.e_si = '';
                    }
                    if (this.invoice_no == '') {
                        this.e_invoice_no = "Please type invoice number";
                    }
                    else {
                        this.e_invoice_no = '';
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    var item_name = document.getElementsByName('first[]');
                    var saleqty = document.getElementsByName('third[]');
                    var rtnqty = document.getElementsByName('fourth[]');
                    var unit = document.getElementsByName('second[]');
                    var cost = document.getElementsByName('fiveth[]');

                    var k = 'zero';
                    var m = 0;
                    var n = 0;
                    var o = 'zero';
                    var l = 0;

                    for (var i = 0; i < item_name.length; i++) {
                        var a = item_name[i];
                        k = k + "|" + a.value;
                    }

                    for (var g = 0; g < saleqty.length; g++) {
                        var c = saleqty[g];
                        m = m + "|" + c.value;
                    }

                    for (var h = 0; h < rtnqty.length; h++) {
                        var d = rtnqty[h];
                        n = n + "|" + d.value;
                    }
                    for (var z = 0; z < unit.length; z++) {
                        var e = unit[z];
                        o = o + "|" + e.value;
                    }

                    for (var y = 0; y < cost.length; y++) {
                        var f = cost[y];
                        l = l + "|" + f.value;
                    }
                    axios.post('accounts/post_salereturn', {
                        item_name: k,
                        saleqty: m,
                        rtnqty: n,
                        unit: o,
                        cost: l,

                        date: this.date,
                        invoice_no: this.invoice_no,
                        sale_inv: this.sale_inv,
                        subtotal: this.subtotal,
                        tax_amount: this.tax_amount,
                        delivery_amount: this.delivery_amount,
                        discount: this.discount,
                        total: this.total,
                        customer: this.customer,
                        remarks: this.remarks
                    })
                        .then(data => {

                            if (data.data == "submitted") {
                                this.$toastr.s("New Sale Return added Successfully", "Congratulations!");
                                this.$router.push({ name: 'sales/return'})
                            }
                        })
                }
            },
            get_invoicesale() {
                axios.get('accounts/get_saleinvoice_detail/' + this.sale_inv)
                    .then(response => {
                        this.customer = response.data[0].CustomerName;
                    })

                axios.get('accounts/get_saleinvoice_detail1/' + this.sale_inv)
                    .then(response => {
                        this.get_si_detail1 = response.data;
                    })
            }
        },
        mounted() {
            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)

            axios.get('./accounts_get_saleinvoice')
                .then(response => {
                    this.saleinvoice = response.data;
                })
            this.intervalFetchData();
            axios.get('accounts/get_delivery2')
                .then(response => {
                    this.get_delivery = response.data;
                })
            axios.get('accounts/get_tax2')
                .then(response => {
                    this.get_tax = response.data;
                })
        },
    };
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

            .invoice-preview
            .invoice-total-wrapper
            .invoice-total-item
            .invoice-total-title,
            .invoice-edit .invoice-total-wrapper .invoice-total-item .invoice-total-title,
            .invoice-add .invoice-total-wrapper .invoice-total-item .invoice-total-title {
                margin-bottom: 0.35rem;
            }

            .invoice-preview
            .invoice-total-wrapper
            .invoice-total-item
            .invoice-total-amount,
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

        .invoice-edit
        .invoice-preview-card
        .invoice-product-details
        .product-details-border,
        .invoice-add
        .invoice-preview-card
        .invoice-product-details
        .product-details-border {
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
