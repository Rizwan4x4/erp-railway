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
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard
                                </router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/purchase/detail" style="text-decoration: none;">Purchase Orders
                                </router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                New Purchase Order
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="invoice-add-wrapper">
                        <div class="row invoice-add">
                            <!-- Invoice Add Left starts -->
                            <div class="col-xl-10 col-md-10 col-12">
                                <div class="card invoice-preview-card">
                                    <!-- Header starts -->
                                    <div class="card-body  pb-0">
                                        <div
                                            class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0"
                                            style="margin-bottom:0px">
                                            <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                                <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                                    <h3 class="text-primary invoice-logo" style="margin-left: 0px;">
                                                        {{ companydetail1.company_name }}</h3>
                                                </div>
                                                <p class="card-text mb-25">Address: {{ companydetail1.company_address }}
                                                    , </p>
                                                <p class="card-text mb-25">City: {{ companydetail1.city }} -
                                                    {{ companydetail1.country }}</p>
                                                <p class="card-text mb-0">Phone: {{ companydetail1.phone_number }}</p>
                                            </div>
                                            <div class="invoice-number-date mt-md-0 mt-2">
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="title">Date:</span>
                                                    <input readonly v-model="date" type="date"
                                                           class="form-control invoice-edit-input "/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">New Purchase
                                            Order
                                        </div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Against
                                                    Quotation: <span style="color: #DB4437; font-size: 11px;">*</span>
                                                </h6>
                                                <div class="invoice-customer">
                                                    <multiselect style="margin-right: 10px;" :options="options"
                                                                 @input="get_vendor_detail()" value="id" label="label"
                                                                 v-model="quotation_id"
                                                                 placeholder="Select Quotation of relevent Requisition"></multiselect>
                                                    <span style="color: #DB4437; font-size: 11px;"
                                                          v-if="quotation_id=='' || quotation_id==null">{{
                                                            e_quotation_id
                                                        }}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 mb-lg-1 col-bill-to ps-0">
                                                <div class="form-group">
                                                    <label>Vendor Name</label>
                                                    <input v-model="vendor_n" type="text" class="form-control" readonly
                                                           placeholder="Vendor name"/>
                                                </div>
                                                <input hidden v-model="reqid" type="text" class="form-control"
                                                       readonly/>
                                                <input hidden v-model="quoid" type="text" class="form-control"
                                                       readonly/>
                                            </div>
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <label class="form-label" for="basicSelect">PO Status: </label>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="status"
                                                           name="inlineRadioOptions" id="inlineRadio1" value="Full"
                                                           checked="" style="cursor:pointer">
                                                    <label class="form-check-label" for="inlineRadio1">Full</label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="status"
                                                           name="inlineRadioOptions" id="inlineRadio2" value="Partial"
                                                           style="cursor:pointer">
                                                    <label class="form-check-label" for="inlineRadio2">Partial</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <div class="source-item" v-for="(get_po_detail11, index) in get_po_detail1"
                                             style="margin-top:20px">
                                            <div data-repeater-list="group-a">
                                                <div class="repeater-wrapper" data-repeater-item>
                                                    <div class="row">
                                                        <div
                                                            class="col-12 d-flex product-details-border position-relative pe-0">
                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                <div class="col-lg-4 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0"
                                                                       v-if="type=='Goods'">{{ index + 1 }} - Item
                                                                        name</p>
                                                                    <p class="card-text col-title mb-md-50 mb-0"
                                                                       v-else-if="type=='Services'">{{ index + 1 }} -
                                                                        Service detail</p>
                                                                    <p class="card-text col-title mb-md-50 mb-0" v-else>
                                                                        {{ index + 1 }} - Asset name</p>
                                                                    <select v-if="get_po_detail11.ItemName!=null"
                                                                            class="form-select item-details"
                                                                            name="first[]">
                                                                        <option :value='get_po_detail11.ItemId'>
                                                                            {{ get_po_detail11.ItemName }}
                                                                        </option>
                                                                    </select>
                                                                    <input hidden v-else type="text" name="first[]"
                                                                           value="empty">
                                                                    <textarea class="form-control mt-2" rows="1"
                                                                              name="seventh[]" readonly
                                                                              placeholder="Item Detail">{{get_po_detail11.Detail}}</textarea>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">
                                                                        Quotation Qty</p>
                                                                    <input @change="sum_total()"
                                                                           :value='get_po_detail11.Quantity'
                                                                           type="number" readonly class="form-control"
                                                                           name="fiveth[]"/>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">PO
                                                                        Quantity <span
                                                                            style="color: #DB4437; font-size: 11px;">*</span>
                                                                    </p>
                                                                    <textarea @keypress="onlyNumber"
                                                                              @change="sum_total()"
                                                                              style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;"
                                                                              class="form-control mt-2" rows="1"
                                                                              name="fourth[]">{{get_po_detail11.Quantity}}</textarea>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Unit
                                                                        Cost</p>
                                                                    <input @change="sum_total()" name="third[]" readonly
                                                                           type="number" class="form-control"
                                                                           :value='Number(get_po_detail11.Price)'/>
                                                                </div>
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">
                                                                        Price</p>
                                                                    <p style="margin-top: 30px;border-radius: 2px;padding-left: 10px;max-width: 100px;height: 35px;"
                                                                       :id="'demo_'+(index)"
                                                                       class="form-control card-text col-title mb-md-50 mb-0">
                                                                        {{ Number(get_po_detail11.Total) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Details ends -->
                                    <!-- Invoice Total starts -->
                                    <div class="card-body invoice-padding">
                                        <div class="row invoice-sales-total-wrapper">
                                            <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                                <div class="row form-row mt-50"
                                                     style="border: 1px solid lightgrey;padding-top: 10px;padding-bottom: 10px;border-radius: 5px !important;">
                                                    <div class="mb-1 col-md-12">
                                                        <label>Payment Term</label>
                                                        <select disabled v-model="select_pmterm" id="tax-1-input"
                                                                class="form-select tax-select">
                                                            <option value="">Payment term not selected</option>
                                                            <option v-for='payment_term1 in payment_term'
                                                                    :value='payment_term1.PaymentTermName'>
                                                                {{ payment_term1.PaymentTermName }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-2">
                                                <div class="invoice-total-wrapper" style="max-width: 300px;">
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Subtotal:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="subtotal" type="number" class="form-control"
                                                                   readonly/>
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Tax:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="tax_amount" type="number" placeholder="0"
                                                                   class="form-control"/>
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Delivery:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="delivery_amount" type="number"
                                                                   placeholder="0"
                                                                   class="form-control"/>
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Discount: </p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="discount" type="number" class="form-control"
                                                                   placeholder="0"/>
                                                        </p>
                                                    </div>
                                                    <hr class="my-50"/>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Total:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="total" type="number" class="form-control"
                                                                   readonly/>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Invoice Total ends -->
                                    <hr class="invoice-spacing mt-0"/>
                                    <div class="card-body invoice-padding py-0">
                                        <!-- Invoice Note starts -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label for="note" class="form-label fw-bold">Remarks:</label>
                                                    <textarea v-model="narration" class="form-control" rows="2"
                                                              id="note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Invoice Note ends -->
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Add Left ends -->
                            <!-- Invoice Add Right starts -->
                            <div class="col-xl-2 col-md-2 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="create_po()"
                                                class="btn btn-primary w-100 mb-75">Create PO
                                        </button>
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
import Multiselect from 'vue-multiselect';

export default {
    data() {
        return {
            options: [],
            payment_term: {},
            select_pmterm: '',

            counter: 1,
            companydetail: {},
            disabled: false,
            timeout: null,

            quotation_id: '',
            e_quotation_id: '',
            type: '',
            quoid: '',
            reqid: '',
            narration: '',
            date: new Date().toJSON().slice(0, 10),
            vendor_n: '',
            subtotal: 0,
            discount: 0,
            tax_amount: 0,
            delivery_amount: 0,
            total: 0,
            status: 'Full',

            e_po: '',
            e_vendor_n: '',
            get_po_detail1: {},
            get_vendors: {},
            item_list5: {},
            get_delivery: {},
            get_tax: {},
        }
    },
    components: {Multiselect},
    methods: {
        intervalFetchData: function () {
            setInterval(() => {
                this.total = Number(this.subtotal) + Number(this.tax_amount) + Number(this.delivery_amount) - Number(this.discount);
            }, 1000);
        },
        onlyNumber($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
        },
        sum_total() {
            var third = document.getElementsByName('third[]');
            var fourth = document.getElementsByName('fourth[]');
            var m = 0;

            for (var g = 0; g < fourth.length; g++) {
                var c = fourth[g];
                var b = third[g];

                // var demo_id = "demo" + g;
                document.getElementById("demo_" + g).innerHTML = Number(b.value) * Number(c.value);
                m = Number(m) + (Number(b.value) * Number(c.value));
            }
            this.subtotal = m;
            this.total = Number(this.subtotal) + Number(this.tax_amount) + Number(this.delivery_amount) - Number(this.discount);
        },
        get_vendor_detail() {
            axios.get('accounts/get_quotation_detail/' + this.quotation_id.id)
                .then(response => {
                    this.narration = response.data[0].Remarks;
                    this.vendor_n = response.data[0].VendorName;
                    this.subtotal = response.data[0].SubTotal;
                    this.discount = response.data[0].Discount;
                    this.tax_amount = response.data[0].Tax;
                    this.select_pmterm = response.data[0].PaymentTerm;
                    this.delivery_amount = response.data[0].ShippingCharges;
                    this.total = response.data[0].Total;
                    this.quoid = response.data[0].QuotationID;
                    this.reqid = response.data[0].RequisitionID;
                    this.type = response.data[0].RequisitionType;
                })
            axios.get('accounts/get_quotation_detail1/' + this.quotation_id.id)
                .then(response => {
                    this.get_po_detail1 = response.data;
                })
        },

        create_po() {
            this.disabled = true;
            this.sum_total();
            if (!this.quotation_id) {
                this.e_quotation_id = !this.quotation_id ? 'Please select Quotation' : '';
                this.$toastr.e("Please fill required fields!", "Caution!");
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 2000)
            } else {
                this.discount = !this.discount ? 0 : this.discount;
                this.tax_amount = !this.tax_amount ? 0 : this.tax_amount;
                this.delivery_amount = !this.delivery_amount ? 0 : this.delivery_amount;

                var item_name = document.getElementsByName('first[]');
                var est_cost = document.getElementsByName('third[]');
                var qty = document.getElementsByName('fourth[]');
                var quoteqty = document.getElementsByName('fiveth[]');
                var detail = document.getElementsByName('seventh[]');

                var k = 'zero';
                var m = 0;
                var n = 0;
                var o = 0;
                var itemdetail = 'zero';

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
                for (var z = 0; z < quoteqty.length; z++) {
                    var e = quoteqty[z];
                    o = o + "|" + e.value;
                }
                for (var dw = 0; dw < detail.length; dw++) {
                    var fw = detail[dw];
                    itemdetail = itemdetail + "|" + fw.value;
                }

                axios.post('./accounts/insert_purchaseorder', {
                    item_name: k,
                    unit_cost: m,
                    orderedqty: n,
                    quoteqty: o,
                    detail: itemdetail,
                    quoid: this.quoid,
                    reqid: this.reqid,
                    narration: this.narration,
                    date: this.date,
                    vendor_n: this.vendor_n,
                    subtotal: this.subtotal,
                    discount: this.discount,
                    tax_amount: this.tax_amount,
                    delivery_amount: this.delivery_amount,
                    select_pmterm: this.select_pmterm,
                    total: this.total,
                    status: this.status,
                })
                    .then(data => {
                        if (data.data == "submitted") {
                            this.$toastr.s("Purchase Order crreated Successfully!", "Congratulations!");
                            this.$router.push({name: 'purchase_po_detail'});
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                        this.timeout = setTimeout(() => {
                            this.disabled = false
                        }, 2000)
                    })
            }
        },

        // delay() {
        //     this.disabled = true
        //     this.timeout = setTimeout(() => {
        //         this.disabled = false
        //     }, 5000)
        //     this.create_po();
        // },
    },
    mounted() {
        this.intervalFetchData();

        axios.get('accounts/get_pmterm')
            .then(response => {
                this.payment_term = response.data;
            })

        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)

        axios.get('./accounts/get_quotationdetail')
            .then(response => {
                this.get_vendors = response.data;
                this.options = [];
                this.options = this.get_vendors.map((pr) => ({
                    id: pr.QuotationID,
                    label: `${pr.RId}` + '_Q#:' + `${pr.QuotationNumber}` + ' _' + `${pr.VendorName}`,
                }));
            })
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
