<template>
    <div>
        <div class="app-content content ">
            <div class="noprint content-overlay"></div>
            <div class="noprint cheader-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/sales/quotation_detail" style="text-decoration: none;">Quotations Detail</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                New Quotation
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
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="title">Date:</span>
                                                    <input readonly v-model="date" type="date" class="form-control invoice-edit-input " />
                                                </div>
                                                <span style="color: #DB4437; font-size: 11px; float:right;" v-if="date==''">{{e_date}}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Sales Quotation</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Customer Name<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                <div class="invoice-customer">
                                                    <select @change="get_vendor_detail()" v-model="customer_name" class="invoiceto form-select">
                                                        <option value="">Select Customer</option>
                                                        <option v-for='customers1 in customers' :value='customers1.CustomerName'>{{ customers1.CustomerName}}</option>
                                                    </select>
                                                </div>
                                                <span style="color: #DB4437; font-size: 11px;" v-if="customer_name==''">{{e_customer_name}}</span>
                                                <div style="margin-top:20px" v-for="get_single_vendor1 in get_single_vendor">
                                                    <p class="card-text mb-25" style="font-weight:bold">Customer Name: {{get_single_vendor1.CustomerName}}</p>
                                                    <p class="card-text mb-25">CNIC:{{get_single_vendor1.CNIC}}</p>
                                                    <p class="card-text mb-25">Phone: {{get_single_vendor1.Mobile}}</p>
                                                    <p class="card-text mb-0">Email Id: {{get_single_vendor1.Email}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 p-0 ps-xl-2 mt-xl-0 mt-2 " style="border:1px solid lightgrey;border-radius:4px !important; height: 100px;">
                                                <h6 class="mb-2">Payment Details:</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <div class="form-group xz_form  row animated slideInDown" v-for="count in counter" :id="count" style="margin-top:40px">
                                            <div data-repeater-list="" class="col-lg-12">
                                                <slot class="source-item">
                                                    <div data-repeater-list="group-a">
                                                        <div class="repeater-wrapper" data-repeater-item>
                                                            <div class="row">
                                                                <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                                    <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                        <div class="col-lg-5 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                            <p class="card-text col-title mb-md-50 mb-0">Item</p>
                                                                            <select class="form-select item-details" name="first[]">
                                                                                <option value="">Select Item</option>
                                                                                <option v-for='item_list51 in item_list' :value='item_list51.ID'>{{ item_list51.Name }}</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Quantity</p>
                                                                            <input @change="sum_total()" type="number" class="form-control" name="fourth[]" value="1" />
                                                                        </div>
                                                                        <div class="col-lg-3 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Unit Cost</p>
                                                                            <input @change="sum_total()" name="third[]" type="number" class="form-control" value="0" />
                                                                        </div>
                                                                        <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                            <p class="card-text col-title mb-md-50 mb-0">Price</p>
                                                                            <p style="margin-top: 30px; border-radius: 2px; padding-left: 10px; max-width: 100px; height:35px; " :id="'demo_'+(count-1)" class="form-control card-text col-title mb-md-50 mb-0"></p>
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
                                    <div class="card-body invoice-padding">
                                        <div class="row invoice-sales-total-wrapper">
                                            <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                                <div class="row form-row mt-50" style="border: 1px solid lightgrey;padding-top: 10px;padding-bottom: 10px;border-radius: 5px !important;">
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
                                                            <input v-model="total" step="2" type="number" class="form-control" readonly />
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Invoice Total ends -->
                                    <hr class="invoice-spacing mt-0" />
                                    <div class="card-body invoice-padding py-0">
                                        <!-- Invoice Note starts -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label for="note" class="form-label fw-bold">Remarks:</label>
                                                    <textarea v-model="narration" class="form-control" rows="2" id="note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Invoice Note ends -->
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Add Left ends -->
                            <!-- Invoice Add Right starts -->
                            <div class="col-xl-3 col-md-4 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Add Quotation</button>
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

    export default {
        data() {
            return {
                get_single_vendor: {},
                companydetail: {},
                get_delivery: {},
                item_list: {},
                customers: {},
                get_tax: {},
                counter: 1,
                disabled: false,
                timeout: null,

                narration: '',
                date: '',
                customer_name: '',
                subtotal: 0,
                discount: 0,
                tax_amount: 0,
                delivery_amount: 0,
                total: 0,

                e_date: '',
                e_customer_name: '',
                select_tax: '',
                select_delivery: '',
            }
        },
        methods: {
            create_quotation() {
                if (this.date == '' || this.customer_name == '') {
                    if (this.date == '') {
                        this.e_date = "Please Select Date";
                    }
                    if (this.customer_name == '') {
                        this.e_customer_name = "Please Select Customer";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    var item_name = document.getElementsByName('first[]');
                    var est_cost = document.getElementsByName('third[]');
                    var qty = document.getElementsByName('fourth[]');
                    var k = 'zero';
                    var m = 0;
                    var n = 0;

                    for (var i = 0; i < item_name.length; i++) {
                        var a = item_name[i];
                        k = k + "|" + a.value;
                    }

                    for (var g = 0; g < est_cost.length; g++) {
                        var c = est_cost[g];
                        m = m + "|" + c.value;
                    }

                    for (var h = 0; h < qty.length; h++) {
                        var d = qty[h];
                        n = n + "|" + d.value;
                    }
                    axios.post('./accounts_insert_salequot', {
                        date: this.date,
                        customer_name: this.customer_name,
                        item_name: k,
                        unit_cost: m,
                        qty: n,

                        subtotal: this.subtotal,
                        discount: this.discount,
                        tax_amount: this.tax_amount,
                        delivery_amount: this.delivery_amount,
                        total: this.total,
                        narration: this.narration,
                    })
                        .then(data => {

                            if (data.data == "Empty field") {
                                this.$toastr.e("Some fields are empty or not fill properly", "Error!");
                            }
                            else {
                                this.adsdata = data.data;
                                this.$toastr.s("Purchase requisition added Successfully", "Congratulations!");
                                 this.$router.push({ name: 'sales_quotation_detail'})
                            }
                        })
                }
            },
            intervalFetchData: function () {
                setInterval(() => {
                    this.total = Number(this.subtotal) + Number(this.delivery_amount) + Number(this.tax_amount) - Number(this.discount);
                }, 1000);
            },
            delivery() {
                axios.get('accounts/select_delivery_value/' + this.select_delivery + '/' + this.subtotal)
                    .then(response => this.delivery_amount = response.data)
            },
            tax() {
                axios.get('accounts/select_tax_value/' + this.select_tax + '/' + this.subtotal)
                    .then(response => this.tax_amount = response.data)

            },
            sum_total() {
                var third = document.getElementsByName('third[]');
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
            },
            get_vendor_detail() {
                axios.get('accounts/get_customer_detail/' + this.customer_name)
                    .then(response => { this.get_single_vendor = response.data })
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
                this.create_quotation();
            },
        },
        mounted() {
            axios.get('accounts/get_delivery')
                .then(response => {
                    this.get_delivery = response.data;
                })
            axios.get('accounts/get_tax')
                .then(response => {
                    this.get_tax = response.data;
                })
            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)

            axios.get('accounts/get_salecustomer')
                .then(response => this.customers = response.data)

            axios.get('accounts/get_itemss')
                .then(response => {
                    this.item_list = response.data;
                })

            this.intervalFetchData();
        },

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
