<template>
    <div>
        <div class="app-content content ">
            <div class="noprint content-overlay"></div>
            <div class="noprint cheader-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard
                                </router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/purchase/requistion_detail" style="text-decoration: none;">Requisition
                                    Detail(s)
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit Purchase Quotation {{ this.id }}
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
                                                    <input v-model="date" readonly type="date"
                                                           class="form-control invoice-edit-input "/>
                                                    <span style="color: #DB4437; font-size: 11px;"
                                                          v-if="date==''">{{ e_date }}</span>
                                                </div>
                                                <div class="col-12 col-sm-6 mb-1">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="basicSelect">Status</label>
                                                        <label style="color: #d93025">*</label>
                                                        <div class="demo-inline-spacing">
                                                            <div class="form-check form-check-inline"
                                                                 style="margin-top:0px">
                                                                <input class="form-check-input" type="radio"
                                                                       v-model="status" name="inlineRadioOptions"
                                                                       id="inlineRadio1" value="Added" checked="">
                                                                <label class="form-check-label"
                                                                       for="inlineRadio1">Added</label>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Edit
                                            Quotation {{ this.id }}
                                        </div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">


                                            <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Vendor Name<span
                                                    style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                <div class="invoice-customer">
                                                    <select @change="get_vendor_detail()" v-model="vendor_n"
                                                            class="invoiceto form-select">
                                                        <option value="">Select Vendor</option>
                                                        <option v-for='get_vendors1 in get_vendors'
                                                                :value='get_vendors1.CompanyName'>
                                                            {{ get_vendors1.CompanyName }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                      v-if="vendor_n==''">{{ e_vendor_n }}</span>
                                                <div style="margin-top:20px"
                                                     v-for="get_single_vendor1 in get_single_vendor">
                                                    <p class="card-text mb-25" style="font-weight:bold">Vendor Name:
                                                        {{ get_single_vendor1.CompanyName }}</p>
                                                    <p class="card-text mb-25">
                                                        Address:{{ get_single_vendor1.Address }}</p>
                                                    <p class="card-text mb-25">Phone:
                                                        {{ get_single_vendor1.Mobile }}</p>
                                                    <p class="card-text mb-0">Email Id:
                                                        {{ get_single_vendor1.Email }}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 p-0 ps-xl-2 mt-xl-0 mt-2">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row">
                                            <div class="col-auto">
                                                <h6 class="invoice-to-title"
                                                    style="margin-bottom: 5px; display: inline;">Est Completion<span
                                                    style="color: #DB4437; font-size: 11px;">*</span></h6>

                                                <h6 class="invoice-to-title"
                                                    style="margin-bottom: 5px; margin-left: 120px; display: inline;">
                                                    Select Currency<span
                                                    style="color: #DB4437; font-size: 11px;">*</span></h6>

                                                <div style="display: flex; align-items: center;">
                                                    <input type="number" class="form-control" v-model="input_time"
                                                           value="0" style="margin-right: 5px;">
                                                    <select class="invoiceto form-select" style="width: 100px;"
                                                            v-model="select_duration">
                                                        <option value="">Select</option>
                                                        <option value="days">Days</option>
                                                        <option value="Hrs">Hrs</option>
                                                    </select>
                                                    <select class="invoiceto form-select" style="margin-left: 5px;"
                                                            v-model="select_currency">
                                                        <option value="">Select</option>
                                                        <option value="$">$</option>
                                                        <option value="Rs">Rs</option>
                                                        <option value="£">£</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <div class="source-item" v-for="(get_qdata11, index) in get_qdata1"
                                             style="margin-top:30px">
                                            <div data-repeater-list="group-a">
                                                <div class="repeater-wrapper" data-repeater-item>
                                                    <div class="row">
                                                        <div
                                                            class="col-12 d-flex product-details-border position-relative pe-0">
                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                <div class="col-lg-6 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">
                                                                        Item</p>
                                                                    <select
                                                                        v-if="req_type=='Goods' ||req_type=='Assets' "
                                                                        class="form-select item-details" name="first[]">
                                                                        <option :value='get_qdata11.ItemId'>
                                                                            {{ get_qdata11.ItemName }}
                                                                        </option>

                                                                        <option v-for='item_list51 in item_list5'
                                                                                :value='item_list51.ID'>
                                                                            {{ item_list51.Name }}
                                                                        </option>

                                                                    </select>
                                                                    <input hidden v-else type="text" name="first[]"
                                                                           value="empty">
                                                                    <textarea class="form-control mt-2" rows="1"
                                                                              name="fiveth[]" placeholder="Item Detail">{{get_qdata11.Detail}}</textarea>
                                                                </div>


                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Qty</p>


                                                                    <textarea @keypress="onlyNumber"
                                                                              @change="sum_total()"
                                                                              style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;"
                                                                              class="form-control mt-2" rows="1"
                                                                              name="fourth[]">{{get_qdata11.Quantity}}</textarea>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Unit
                                                                        Cost</p>
                                                                    <textarea @keypress="onlyNumber"
                                                                              @change="sum_total()" name="third[]"
                                                                              style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;"
                                                                              class="form-control mt-2" rows="1">{{get_qdata11.Price}}</textarea>


                                                                </div>
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">
                                                                        Price</p>
                                                                    <p style="margin-top: 30px;border-radius: 2px;padding-left: 10px;max-width: 100px;height: 35px;"
                                                                       :id="'demo_'+(index)"
                                                                       class="form-control card-text col-title mb-md-50 mb-0">
                                                                        {{ Number(get_qdata11.Total) }}</p>
                                                                    <div style="margin-top:50px">
                                                                        <div
                                                                           >
                                                                            <p class="card-text  mb-md-50 mb-0">
                                                                                Finalize</p>
                                                                            <input
                                                                                style="margin-top: 10px;margin-left: 5px;"
                                                                                class="form-check-input" type="checkbox"
                                                                                @change="sum_total1()"
                                                                                name="second[]"
                                                                                id="inlineRadio1"/>
                                                                        </div>
                                                                        <!-- <div v-else>
                                                                            <p style="display:none"
                                                                               class="card-text  mb-md-50 mb-0">
                                                                                Finalize</p>
                                                                            <input hidden
                                                                                   style="margin-top: 10px;margin-left: 5px;"
                                                                                   class="form-check-input"
                                                                                   type="checkbox"
                                                                                   name="second[]"
                                                                                   id="inlineRadio1"/>
                                                                        </div> -->


                                                                    </div>
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
                                                        <label>Select Tax Head </label>
                                                        <select @change="tax()" v-model="select_tax" id="tax-1-input"
                                                                class="form-select tax-select">
                                                            <option value="">Select Tax</option>
                                                            <option v-for='get_tax1 in get_tax' :value='get_tax1.TaxID'>
                                                                {{ get_tax1.TaxName }}
                                                            </option>

                                                        </select>
                                                    </div>
                                                    <div class="mb-1 col-md-12">
                                                        <label>Select Delivery Head </label>
                                                        <select @change="delivery()" v-model="select_delivery"
                                                                id="tax-1-input" class="form-select tax-select">
                                                            <option value="">Select Delivery</option>
                                                            <option v-for='get_delivery1 in get_delivery'
                                                                    :value='get_delivery1.DID'>
                                                                {{ get_delivery1.DeliveryName }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-1 col-md-12">
                                                        <label>Select Payment Term</label>s
                                                        <select v-model="select_pmterm" id="tax-1-input"
                                                                class="form-select tax-select">
                                                            <option value="">Select Payment Term</option>
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
                                                            <input v-model="tax_amount" type="number"
                                                                   class="form-control"/>
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Delivery:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="delivery_amount" type="number"
                                                                   class="form-control"/>
                                                        </p>
                                                    </div>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Discount:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="discount" type="number"
                                                                   class="form-control"/>
                                                        </p>
                                                    </div>
                                                    <hr class="my-50"/>
                                                    <div class="invoice-total-item">
                                                        <p class="invoice-total-title">Total:</p>
                                                        <p class="invoice-total-amount">
                                                            <input v-model="total" step="2" type="number"
                                                                   class="form-control" readonly/>
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
                            <div class="col-xl-3 col-md-4 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <button :disabled="disabled" @click="delay()"
                                                class="btn btn-primary w-100 mb-75">Edit Quotation
                                        </button>
                                        <input type="file" id="image_file" :v-model="image_file" name="image_file"
                                               @change="onFileChange" accept="image/*"
                                               class="btn btn-outline-primary w-100 mb-75">
                                        <div class="d-flex">
                                            <span v-for="quotations1 in quotations">
                                                <img v-if="url" :src="url" id="account-upload-img"
                                                     class="uploadedAvatar rounded me-50" alt="profile image"
                                                     style="width:100%;">
                                                <img v-else-if="quotations1.Photo!=null"
                                                     v-bind:src="`public/images/quotation_images/${quotations1.Photo}`"
                                                     id="account-upload-img" class="uploadedAvatar rounded me-50"
                                                     alt="profile image" style="width:100%">
                                                <img v-else src="public/images/quotation_images/document.jpg"
                                                     id="account-upload-img" class="uploadedAvatar rounded me-50"
                                                     alt="profile image" style="width:100%">
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-end mt-75 ms-1">
                                            <div>
                                                <button type="button" @click="clear_image()" id="account-reset"
                                                        class="btn btn-sm btn-outline-secondary mb-75 waves-effect">
                                                    Clear
                                                </button>
                                                <p class="mb-0">Attach quotation</p>
                                            </div>
                                        </div>
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
            input_time: 0,
            select_duration: '',
            select_currency: '',


            image_file: '',
            url: null,
            image: '',
            quotations: {},

            payment_term: {},
            select_pmterm: '',

            get_qdata1: {},
            id: this.$route.params.id,
            rid: this.$route.params.rid,
            counter: 1,
            companydetail: {},
            disabled: false,
            timeout: null,
            narration: '',
            date: '',
            vendor_n: '',
            subtotal: 0,
            discount: 0,
            tax_amount: 0,
            delivery_amount: 0,
            total: 0,
            status: 'Added',

            e_date: '',
            e_po: '',
            e_vendor_n: '',
            get_single_vendor: {},

            get_vendors: {},
            item_list5: {},
            get_delivery: {},
            get_tax: {},
            select_tax: '',
            select_delivery: '',
            quotationid: '',
            req_type: '',
        }
    },
    methods: {
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            const file = files[0];
            this.image = files[0];
            this.url = URL.createObjectURL(file);
        },
        clear_image() {
            this.url = null;
            this.image_file = '';
            this.image = '';
        },
        onlyNumber($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                $event.preventDefault();
            }
        },
        create_quotation() {
            if (this.vendor_n == '' || this.input_time == 0 || this.select_duration == 0 || this.select_currency == 0) {
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else if (this.subtotal == 0) {
                this.$toastr.e("Quotation Value Not Be 0!", "Caution!");
            } else {
                var item_name = document.getElementsByName('first[]');
                var est_cost = document.getElementsByName('third[]');
                var qty = document.getElementsByName('fourth[]');
                var detail = document.getElementsByName('fiveth[]');
                var added = document.getElementsByName('second[]');
                var addpurchase = 'zero';

                var k = 'zero';
                var m = 0;
                var n = 0;
                var o = 'zero';

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

                for (var f = 0; f < detail.length; f++) {
                    var fn = detail[f];
                    o = o + "|" + fn.value;
                }

                for (var g = 0; g < added.length; g++) {
                    var fnn = added[g];
                    addpurchase = addpurchase + "|" + fnn.checked;
                }
                const formData = new FormData();
                if (this.url == null) {

                } else {
                    formData.append('image_file', this.image, this.image.name);
                }
                this.discount = this.discount || 0;
                this.tax_amount = this.tax_amount || 0;
                this.delivery_amount = this.delivery_amount || 0;

                formData.append('item_name', k);
                formData.append('unit_cost', m);
                formData.append('qty', n);
                formData.append('detail', o);
                formData.append('check_purchase', addpurchase);
                formData.append('rid', this.rid);
                formData.append('qid', this.id);
                formData.append('quotationid', this.quotationid);
                formData.append('date', this.date);
                formData.append('vendor_n', this.vendor_n);
                formData.append('subtotal', this.subtotal);
                formData.append('discount', this.discount);
                formData.append('tax_amount', this.tax_amount);
                formData.append('delivery_amount', this.delivery_amount);
                formData.append('select_pmterm', this.select_pmterm);
                formData.append('total', this.total);
                formData.append('status', this.status);
                formData.append('narration', this.narration);
                formData.append('est_time', this.input_time);
                formData.append('est_time1', this.select_duration);
                formData.append('currency', this.select_currency);

                axios.post('./accounts/edit_pquotation', formData)
                    .then(data => {
                        if (data.data == "Empty field") {
                            this.$toastr.e("Some fields are empty or not fill properly", "Error!");
                        } else if (data.data == "submitted") {
                            this.adsdata = data.data;
                            this.$toastr.s("Purchase requisition Edit Successfully", "Congratulations!");
                            this.$router.push({name: 'requistion_detail'})
                        } else {
                            this.$toastr.e(data.data, "Error!");
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
                //  document.getElementsByName('fourth[g]').value=Number(c.value);
                // document.getElementsByName('third[g]').value=Number(b.value);
                var demo_id = "demo" + g;
                document.getElementById("demo_" + g).innerHTML = Number(b.value) * Number(c.value);
                m = Number(m) + (Number(b.value) * Number(c.value));


            }
            this.subtotal = m;
        },
        sum_total1() {
            var third = document.getElementsByName('third[]');
            var fourth = document.getElementsByName('fourth[]');
            var m = 0;
            var second = document.getElementsByName('second[]');

            for (var g = 0; g < fourth.length; g++) {
                var c = fourth[g];
                var b = third[g];
                var added = second[g];

                var demo_id = "demo" + g;
                document.getElementById("demo_" + g).innerHTML = Number(b.value) * Number(c.value);
                if (added.checked == true) {
                    m = Number(m) + (Number(b.value) * Number(c.value));
                }
            }
            this.subtotal = m;
        },
        get_vendor_detail() {
            axios.get('accounts/get_vendor_detail/' + this.vendor_n)
                .then(response => this.get_single_vendor = response.data)
        },
        add_xz_repeater() {
            this.counter++;


            // let itm  = document.getElementsByClassName("xz_form")[0];
            // let cln = itm.cloneNode(true);
            // cln.id = this.counter;
            // document.getElementsByClassName("container")[0].insertBefore(cln,document.getElementsByClassName("adding")[0]);
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
        fetch_items_detail() {
            axios.get('accounts/fetch_req_type/' + this.$route.params.rid)
                .then(response => {
                    this.req_type = response.data[0].RequisitionType;
                    if (response.data[0].RequisitionType == 'Goods' || response.data[0].RequisitionType == 'Assets') {
                        axios.get('accounts/get_items')
                            .then(response => {
                                this.item_list5 = response.data;
                            })
                    } else {
                        axios.get('accounts/get_services')
                            .then(response => {
                                this.item_list5 = response.data;
                            })
                    }
                })


        }
    },
    mounted() {

        axios.get('accounts/get_pmterm')
            .then(response => {
                this.payment_term = response.data;
            })

    
        axios.get('accounts/get_quotation_data/' + this.id + '/' + this.rid)
            .then(response => {
                this.quotations = response.data;
                this.date = response.data[0].QuotationDate
                this.vendor_n = response.data[0].VendorName
                this.subtotal = response.data[0].SubTotal
                this.discount = response.data[0].Discount
                this.tax_amount = response.data[0].Tax
                this.select_pmterm = response.data[0].PaymentTerm
                this.delivery_amount = response.data[0].ShippingCharges
                this.total = response.data[0].Total
                this.status = response.data[0].Status
                this.narration = response.data[0].Remarks
                this.quotationid = response.data[0].QuotationID
                this.input_time = response.data[0].Est_Completion_time
                this.select_duration = response.data[0].Est_Completion_time1
                this.select_currency = response.data[0].Currency
                axios.get('accounts/get_quotation_data1/' + response.data[0].QuotationID)
                    .then(response => {
                        this.get_qdata1 = response.data;
                    })
            })

        this.fetch_items_detail();

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

        axios.get('./accounts/get_vendor')
            .then(response => this.get_vendors = response.data)
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
