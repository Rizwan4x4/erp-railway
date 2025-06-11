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
                                <router-link to="../purchase_invoice/detail" style="text-decoration: none;">PO Invoice Detail(s)</router-link>
                            </li>
                            <li class="breadcrumb-item active">Edit Purchase Invoice</li>
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
                                                    <span class="title">Date:<span style="color: #DB4437; font-size: 11px;">*</span></span>
                                                    <input readonly type="date" v-model="date" class="form-control invoice-edit-input " />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{e_date}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Purchase Invoice</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <div class="form-group">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Against PO:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <div class="invoice-customer">

                                                        <select  disabled readonly  v-model="grn_po"  class="invoiceto form-select">
                                                            <option  v-for = 'podetails1 in podetails' :value = 'podetails1.ReceavingOrderID' >{{ podetails1.PoCode}}_{{ podetails1.VendorName}} (For {{podetails1.DepartmentName}}-{{podetails1.ProjectName}})</option>
                                                            <!-- <option v-for='get_vendors1 in get_vendors' :value='get_vendors1.PurchaseOrderID'>{{ get_vendors1.PoCode}}_{{ get_vendors1.VendorName}} (For {{get_vendors1.DepartmentName}}-{{get_vendors1.ProjectName}})</option> -->
                                                        </select>


                                                        <span style="color: #DB4437; font-size: 11px;" v-if="grn_po==''">{{e_grn_po}}</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Invoice No:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <input type="text" readonly disabled v-model="invoice_no" class="form-control" placeholder='Type Invoice Number' />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="invoice_no==''">{{e_invoice_no}}</span>
                                                </div>



                                            </div>
                                            <div class="col-xl-6 p-0 ps-xl-2 mt-xl-0 mt-2">
                                                <div class="form-group">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Vendor Name:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <div class="invoice-customer">
                                                        <input type="text" v-model="vendor" readonly class="form-control" placeholder='Type Vendor Name' style="" />

                                                        <input type="text" v-model="poid" class="form-control" hidden style="" />
                                                        <input type="text" v-model="reqid" hidden class="form-control" style="" />
                                                        <span style="color: #DB4437; font-size: 11px;" v-if="vendor==''">{{e_vendor}}</span>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Status:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <div class="invoice-customer">
                                                        <select v-model="status" class="invoiceto form-select">
                                                            <option value=''></option>
                                                            <option value="Partially Completed">Partially Completed</option>
                                                            <option value="Fully Completed">Fully Completed</option>
                                                        </select>
                                                        <span style="color: #DB4437; font-size: 11px;" v-if="status==''">{{e_status}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <slot class="source-item" v-for="(get_po_detail11, index) in get_po_detail1">
                                            <div data-repeater-list="group-a">
                                                <div class="repeater-wrapper" style="margin-top:30px" data-repeater-item>
                                                    <div class="row">
                                                        <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                <div class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Item</p>
                                                                    <select v-if="get_po_detail11.ItemName!=null" class="form-select item-details" name="first[]">
                                                                        <option :value='get_po_detail11.ItemId'>{{get_po_detail11.ItemName}}</option>

                                                                    </select>
                                                                    <input v-else type="text" class="form-control" name="first[]" :value="get_po_detail11.Detail" readonly />


                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Ordered</p>
                                                                    <input style="padding-left:0px;padding-right:0px;text-align:center" name="third[]" readonly type="number" class="form-control" :value='get_po_detail11.PoQuantity' />
                                                                </div>
                                                                <div class="col-lg-1 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Units</p>
                                                                    <input style="padding-left:0px;padding-right:0px;text-align:center" name="second[]" readonly class="form-control" :value='get_po_detail11.Unit' />
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Received Qty</p>

                                                                    <textarea @keypress="onlyNumber" @change="sum_total()" style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;" class="form-control mt-2" rows="1" name="fourth[]">{{get_po_detail11.RecvdQuantity}}</textarea>
                                                                </div>


                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Unit Cost</p>
                                                                    <input name="fiveth[]" readonly type="number" class="form-control" :value='Number(get_po_detail11.Price)' />

                                                                </div>
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Price</p>
                                                                    <p style="margin-top: 30px;border-radius: 2px;padding-left: 10px;max-width: 100px;height: 35px;" :id="'demo_'+(index)" class="form-control card-text col-title mb-md-50 mb-0">{{get_po_detail11.SubTotal}}</p>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </slot>
                                    </div>
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
                                                    <div class="mb-1 col-md-12" style="display:none">
                                                        <label>Select Delivery Head </label>
                                                        <select @change="delivery()" v-model="select_delivery" id="tax-1-input" class="form-select tax-select">
                                                            <option value="">Select Delivery</option>
                                                            <option v-for='get_delivery1 in get_delivery' :value='get_delivery1.DID'>{{ get_delivery1.DeliveryName}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-1 col-md-12">
                                                        <label>Payment Term</label>s
                                                        <select disabled v-model="select_pmterm" id="tax-1-input" class="form-select tax-select">
                                                            <option value="">Select Payment Term</option>
                                                            <option v-for='payment_term1 in payment_term' :value='payment_term1.PaymentTermName'>{{ payment_term1.PaymentTermName}}</option>
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
                                                            <input v-model="delivery_amount" type="number" class="form-control" />
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
                                                <textarea v-model="narration" class="form-control" rows="2" id="note"></textarea>
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
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Update Invoice</button>
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
                payment_term: {},
                select_pmterm: '',
                podetails:{},
                id: this.$route.params.id,

                get_vendors: {},
                companydetail: {},
                disabled: false,
                timeout: null,


                date: new Date().toJSON().slice(0, 10),
                vendor: '',
                grn_po: '',
                invoice_no: '',
                poid: '',
                reqid: '',
                status: '',
                narration: '',

                subtotal: 0,
                discount: 0,
                tax_amount: 0,
                delivery_amount: 0,
                total: 0,

                e_date: '',
                e_vendor: '',
                e_grn_po: '',
                e_invoice_no: '',
                e_status: '',
                select_tax: '',
                select_delivery: '',
                get_delivery: {},
                get_tax: {},


                get_po_detail1: {},

            }
        },
        methods: {
            onlyNumber($event) {
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }
            },
            delivery() {
                axios.get('accounts/select_delivery_value/' + this.select_delivery + '/' + this.subtotal)
                    .then(response => this.delivery_amount = response.data)

            },
            tax() {
                axios.get('accounts/select_tax_value/' + this.select_tax + '/' + this.subtotal)
                    .then(response => this.tax_amount = response.data)

            },
            intervalFetchData: function () {
                setInterval(() => {
                    this.sum_total();
                    this.total = Number(this.subtotal) + Number(this.tax_amount) + Number(this.delivery_amount) - Number(this.discount);
                }, 1000);
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


            },



            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.issue_grn()
            },
            issue_grn() {
                if (this.grn_po == '' || this.date == '' || this.vendor == '' || this.invoice_no == '' || this.status == '') {

                    if (this.date == '') {
                        this.e_date = 'Type Date';
                    }
                    if (this.vendor == '') {
                        this.e_vendor = 'Type Vendor Name';
                    }

                    if (this.invoice_no == '') {
                        this.e_invoice_no = 'Error';
                    }

                    if (this.status == '') {
                        this.e_status = 'Select Status';
                    }
                    if (this.grn_po == '') {
                        this.e_grn_po = 'Error';
                    }

                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    var item_name = document.getElementsByName('first[]');
                    var ordrqty = document.getElementsByName('third[]');
                    var qty = document.getElementsByName('fourth[]');
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

                    for (var g = 0; g < ordrqty.length; g++) {
                        var c = ordrqty[g];
                        m = m + "|" + c.value;
                    }

                    for (var h = 0; h < qty.length; h++) {
                        var d = qty[h];
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

                    axios.post('./accounts/edit_grn1', {
                        ReceavingOrderID:this.id,
                        item_name: k,
                        ordrqty: m,
                        qty: n,
                        unit: o,
                        cost: l,
                        select_tax: this.select_tax,
                        select_delivery: this.select_delivery,
                        date: this.date,
                        vendor: this.vendor,
                        invoice_no: this.invoice_no,
                        poid: this.poid,
                        reqid: this.reqid,
                        remarks: this.narration,
                        status: this.status,
                        subtotal: this.subtotal,
                        discount: this.discount,
                        tax_amount: this.tax_amount,
                        select_pmterm: this.select_pmterm,
                        delivery_amount: this.delivery_amount,
                        total: this.total,
                    })
                        .then(data => {

                            if (data.data == "submitted") {
                                this.$toastr.s("New Purchase Invoice added Successfully", "Congratulations!");
                                this.$router.push({ name: 'purchase_inv_detail' })
                            }else{
                    this.$toastr.e(data.data, "Caution!");

                            }

                        })




                }
            }
        },
        mounted() {

            axios.get('accounts/get_pmterm')
                .then(response => {
                    this.payment_term = response.data;
                })

            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
            axios.get('./accounts/get_POdetail')
                .then(response => this.get_vendors = response.data)
            this.intervalFetchData();
            axios.get('accounts/get_delivery')
                .then(response => {
                    this.get_delivery = response.data;
                })
            axios.get('accounts/get_tax')
                .then(response => {
                    this.get_tax = response.data;
                })

        axios.get('get_POdetails_by_id/' + this.id).then(response => {
                 this.podetails = response.data;
                 this.grn_po = this.podetails[0].ReceavingOrderID;
                })
                 axios.get('accounts/get_po_detail_by_PIID/' + this.id).then(response=>{
                    this.vendor =response.data[0].vendorName;
                    this.poid = response.data[0].PurchaseOrderID;
                        this.reqid = response.data[0].AgainstReq;
                        this.narration = response.data[0].Remarks;
                        this.select_pmterm = response.data[0].PaymentTerm;
                 })
                 axios.get('accounts/get_purchaseorder_detail1_by_PIID/'+this.id).then(response=>{
                    this.get_po_detail1 = response.data;
                 })
                 axios.get('get_invoice_date/'+this.id).then(response=>{
                    this.date = response.data[0].Dated;
                    this.invoice_no = response.data[0].InvoiceNo;
                    this.status=response.data[0].Status;

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
