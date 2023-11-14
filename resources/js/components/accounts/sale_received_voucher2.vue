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
                                <router-link to="../sales/received_voucher_detail" style="text-decoration: none;">
                                    Receipt vouchers
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Create receipt voucher
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
                                                <div class="d-flex flex-column align-items-center mb-1">
                                                    <span class="title">Date:</span>
                                                    <input readonly type="date" v-model="date"
                                                           class="form-control invoice-edit-input "/>
                                                    <span style="color: #db4437; font-size: 11px"
                                                          v-if="date == ''">{{ e_date }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Receipt
                                            Voucher
                                        </div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing"
                                             style="margin-top:0px;margin-bottom:0px">
                                            <div class="row" style="margin-top:10px">
                                                <div class="col-md-6">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Received
                                                        From:</h6>
                                                    <div class="invoice-customer">
                                                        <multiselect @input="search_balance();find_against()"
                                                                     style="margin-right: 10px;" v-model="vendor_name"
                                                                     :options="options">
                                                        </multiselect>
                                                        <span style="color: #db4437; font-size: 11px"
                                                              v-if="vendor_name == ''">{{ e_vendor_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Method
                                                        Type:</h6>
                                                    <div class="invoice-customer">
                                                        <multiselect @input="find_methodtype()"
                                                                     style="margin-right: 10px;" v-model="method_type"
                                                                     :options="options2"></multiselect>
                                                        <span style="color: #db4437; font-size: 11px"
                                                              v-if="method_type== ''">{{ e_method_type }}</span>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" v-if="this.filterby[0]!='101001001001'">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Instrument
                                                        Date:</h6>
                                                    <div class="invoice-customer">
                                                        <input type="date" v-model="chq_date" class='form-control'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" v-if="this.filterby[0]!='101001001001'">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Instrument
                                                        Number:</h6>
                                                    <div class="invoice-customer">
                                                        <input type="text" v-model="chq_number" class='form-control'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" v-if="this.filterby[0]!='101001001001'">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Method
                                                        Type:</h6>
                                                    <div class="invoice-customer">
                                                        <select class="form-control" v-model="method">
                                                            <option value="Cheque">Cheque</option>
                                                            <option value="Bank Draft">Bank Draft</option>
                                                            <option value="Payorder">Payorder</option>
                                                            <option value="Online_PayOrder">Online_PayOrder</option>
                                                            <option value="Online_Cash">Online_Cash</option>
                                                            <option value="Online_Cheque">Online_Cheque</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" v-if="this.filterby[0]!='101001001001'">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Bank
                                                        Instrument:</h6>
                                                    <div class="invoice-customer">
                                                        <select class="form-control" v-model="Bank_name">
                                                            <option value="">Choose..</option>
                                                            <option value="Online_Cash">Online_Cash</option>
                                                            <option value="Al Baraka Bank">Al Baraka Bank</option>
                                                            <option value="Allied Bank">Allied Bank</option>
                                                            <option value="Apna Microfinance Bank">Apna Microfinance
                                                                Bank
                                                            </option>
                                                            <option value="Askari Bank">Askari Bank</option>
                                                            <option value="Bank Al Habib">Bank Al Habib</option>
                                                            <option value="Bank Alfalah">Bank Alfalah</option>
                                                            <option value="Bank Islami">Bank Islami</option>
                                                            <option value="Bank of Punjab">Bank of Punjab</option>
                                                            <option value="Barclays">Barclays</option>
                                                            <option value="Burj Bank">Burj Bank</option>
                                                            <option value="Citibank N.A.">Citibank N.A.</option>
                                                            <option value="Dubai Islamic Bank">Dubai Islamic Bank
                                                            </option>
                                                            <option value="FINCA Microfinance Bank">FINCA Microfinance
                                                                Bank
                                                            </option>
                                                            <option value="Faysal Bank">Faysal Bank</option>
                                                            <option value="First Women Bank Limited">First Women Bank
                                                                Limited
                                                            </option>
                                                            <option value="First Microfinance Bank">First Microfinance
                                                                Bank
                                                            </option>
                                                            <option value="Habib Bank">Habib Bank</option>
                                                            <option value="Habib Metropolitan Bank">Habib Metropolitan
                                                                Bank
                                                            </option>
                                                            <option value="ICBC">ICBC</option>
                                                            <option value="JS Bank">JS Bank</option>
                                                            <option value="KASB Bank Limited">KASB Bank Limited</option>
                                                            <option value="MCB">MCB</option>
                                                            <option value="MIB">MIB</option>
                                                            <option value="Meezan Bank Limited">Meezan Bank Limited
                                                            </option>
                                                            <option value="Mobilink Microfinance Bank LTD">Mobilink
                                                                Microfinance Bank LTD
                                                            </option>
                                                            <option value="NIB">NIB</option>
                                                            <option value="National Bank of Pakistan">National Bank of
                                                                Pakistan
                                                            </option>
                                                            <option value="Standard Chartered">Standard Chartered
                                                            </option>
                                                            <option value="Samba Bank">Samba Bank</option>
                                                            <option value="Silk Bank">Silk Bank</option>
                                                            <option value="Sindh Bank">Sindh Bank</option>
                                                            <option value="Soneri Bank">Soneri Bank</option>
                                                            <option value="Summit Bank">Summit Bank</option>
                                                            <option value="Tameer Bank">Tameer Bank</option>
                                                            <option value="U Microfinance Bank">U Microfinance Bank
                                                            </option>
                                                            <option value="United Bank">United Bank</option>
                                                            <option value="UnCategorized">UnCategorized</option>
                                                        </select>
                                                        <span style="color: #db4437; font-size: 11px"
                                                              v-if="Bank_name == ''">{{ e_Bankname }}</span>
                                                    </div>

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="basicSelect">Payment
                                                            Against</label>
                                                        <label style="color: #d93025">*</label>
                                                        <div class="row demo-inline-spacing">
                                                            <div class="col-md-4 form-check form-check-inline"
                                                                 style="margin-top:0px">
                                                                <input @change="others()" class="form-check-input"
                                                                       type="radio" v-model="p_agnst"
                                                                       name="inlineRadioOptions" id="inlineRadio1"
                                                                       value="mis">
                                                                <label class="form-check-label" for="inlineRadio1">Others</label>
                                                            </div>

                                                            <div class="col-md-3 form-check form-check-inline"
                                                                 style="margin-top:0px">
                                                                <input class="form-check-input" type="radio"
                                                                       v-model="p_agnst" @change="find_against();pi()"
                                                                       name="inlineRadioOptions" id="inlineRadio2"
                                                                       value="po_">
                                                                <label class="form-check-label" for="inlineRadio2">Purchase
                                                                    Order</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="p_agnst!='mis'"
                                                     class="form-group xz_form  row animated slideInDown"
                                                     v-for="count in counter" :id="count" style="margin-top:10px">
                                                    <div data-repeater-list="" class="col-lg-12">
                                                        <slot class="source-item">
                                                            <div data-repeater-list="group-a">
                                                                <div class="repeater-wrapper" data-repeater-item>
                                                                    <div class="row">
                                                                        <div
                                                                            class="col-12 d-flex product-details-border position-relative pe-0">
                                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">

                                                                                <div
                                                                                    class="col-xl-4 mb-lg-1 col-bill-to ps-0"
                                                                                    v-if="p_agnst=='pi_'">
                                                                                    <multiselect
                                                                                        style="margin-right: 10px;"
                                                                                        @input="search_po_detail(first[count],[count])"
                                                                                        v-model="first[count]"
                                                                                        :options="options9"></multiselect>
                                                                                </div>
                                                                                <div
                                                                                    class="col-xl-4 mb-lg-1 col-bill-to ps-0"
                                                                                    v-if="p_agnst=='po_'">

                                                                                    <multiselect
                                                                                        @input="search_po_detail(first[count],[count])"
                                                                                        style="margin-right: 10px;"
                                                                                        v-model="first[count]"
                                                                                        :options="options8"></multiselect>

                                                                                </div>
                                                                                <div
                                                                                    class="col-xl-4 mb-lg-1 col-bill-to ps-0">
                                                                                    <input type="number" name="fourth[]"
                                                                                           class="form-control ms-50"
                                                                                           readonly
                                                                                           :id="'demo_'+(count)"
                                                                                           placeholder="Remaining Amount"/>
                                                                                </div>
                                                                                <div
                                                                                    class="col-xl-4 mb-lg-1 col-bill-to ps-0">
                                                                                    <input type="number" name="third[]"
                                                                                           class="form-control ms-50"
                                                                                           id="salesperson"
                                                                                           placeholder="Received Amount"/>
                                                                                </div>
                                                                            </div>
                                                                            <div style="margin-left:10px"
                                                                                 class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">
                                                                                <div class="delete_btn"
                                                                                     style="border-radius:14px;">
                                                                                    <div data-repeater-delete=""
                                                                                         class=""
                                                                                         style="margin-right: 6px;"
                                                                                         v-on:click="delete_xz_form(count)">
                                                                                        <span
                                                                                            style="padding-top: 14px;padding-left: 7px;">
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
                                                <div v-if="p_agnst!='mis'" class="row mt-1">
                                                    <div class="col-12 px-0">
                                                        <div data-repeater-create=""
                                                             class="btn btn-primary btn-sm btn-add-new"
                                                             v-on:click="add_xz_repeater();">
                                                            <i data-feather="plus" class="me-25"></i>
                                                            <span class="align-middle">Add Item</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="invoice-total-item">
                                                        <label for="salesperson" class="form-label">Total
                                                            Amount:</label>
                                                        <p class="invoice-total-amount">
                                                            <input type="number" v-model="amount"
                                                                   class="form-control ms-50" id="salesperson"
                                                                   placeholder=""/>
                                                            <span style="color: #db4437; font-size: 11px"
                                                                  v-if="amount == ''">{{ e_amount }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" v-if="p_agnst=='mis'">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Against
                                                        Invoice:</h6>
                                                    <div class="invoice-customer">
                                                        <input v-model="against_invoice" class='form-control'>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Received
                                                        From</h6>
                                                    <div class="invoice-customer">
                                                        <input type="text" v-model="salesperson" class='form-control'>
                                                        <span style="color: #db4437; font-size: 11px"
                                                              v-if="salesperson == ''">{{ e_salesperson }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="invoice-spacing mt-0"/>
                                    <div class="card-body invoice-padding py-0">
                                        <!-- Invoice Note starts -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-2">
                                                    <label for="note" class="form-label fw-bold">Narration: {{narration.length}}</label>
                                                    <textarea class="form-control" v-model="narration" rows="2"
                                                              id="note"></textarea>
                                                    <span style="color: #db4437; font-size: 11px"
                                                          v-if="narration == ''">{{ e_narration }}</span>
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
                                        <button class="btn btn-primary w-100 mb-75" :disabled="disabled"
                                                @click="delay()">Post Voucher
                                        </button>
                                        <input type="file" id="image_file" :v-model="image_file" name="image_file"
                                               @change="onFileChange" accept="image/*"
                                               class="btn btn-outline-primary w-100 mb-75">
                                        <div class="d-flex">
                                            <span>
                                                <img v-if="url" :src="url" id="account-upload-img"
                                                     class="uploadedAvatar rounded me-50" alt="profile image"
                                                     style="width:100%;">
                                                <img v-else src="public/images/quotation_images/document.jpg"
                                                     id="account-upload-img" class="uploadedAvatar rounded me-50"
                                                     alt="profile image" style="width:100%;">
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-end mt-75 ms-1">
                                            <div>
                                                <button type="button" @click="clear_image()" id="account-reset"
                                                        class="btn btn-sm btn-outline-secondary mb-75 waves-effect">
                                                    Clear
                                                </button>
                                                <p class="mb-0">Attach image</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table v-if="ledger_d_detail.length>0">
                                    <h6 class="mb-2" style="font-weight:bold">Vendor Details:</h6>
                                    <tbody v-for="ledger_d_detail1 in ledger_d_detail">
                                    <tr>
                                        <td class="pe-1">Name:</td>
                                        <td>{{ ledger_d_detail1.AccountName }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-1">Total Balance:</td>
                                        <td><strong>Rs.{{ Number(ledger_d_detail1.am).toLocaleString() }}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table v-if="ledger_method_detail.length>0">
                                    <h6 class="mb-2" style="font-weight:bold">Method Details:</h6>
                                    <tbody v-for="ledger_method_detail1 in ledger_method_detail">
                                    <tr>
                                        <td class="pe-1">Name:</td>
                                        <td>{{ ledger_method_detail1.AccountName }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-1">Total Balance:</td>
                                        <td><strong>Rs.{{ Number(ledger_method_detail1.am).toLocaleString() }}</strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr v-if="ledger_d_detail.length>0">
                                <table v-if="inv_balance.total_value>0">
                                    <h6 class="mb-2" style="font-weight:bold">Invoice Details:</h6>
                                    <tbody>
                                    <tr>
                                        <td class="pe-1">Total Amount:</td>
                                        <td>Rs. {{ Number(inv_balance.total_value).toLocaleString() }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-1">Remaining Balance:</td>
                                        <td>
                                            <strong>Rs.{{
                                                    Number(inv_balance.remaining_value).toLocaleString()
                                                }}</strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr v-if="inv_detail.length>0">
                                <div v-if="inv_detail.length>0">
                                    <h6 class="mb-2" style="font-weight:bold">Payment Details:</h6>
                                    <table v-for="inv_detail1 in inv_detail">
                                        <tbody>
                                        <tr>
                                            <td class="pe-1">PaymentID:</td>
                                            <td>{{ inv_detail1.PVNO }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-1">Date:</td>
                                            <td>{{ inv_detail1.Date }}</td>
                                        </tr>

                                        <tr>
                                            <td class="pe-1">Amount:</td>
                                            <td>Rs. {{ Number(inv_detail1.Amount).toLocaleString() }}</td>
                                        </tr>
                                        </tbody>
                                        <hr>
                                    </table>
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
import Multiselect from 'vue-multiselect'

export default {
    data() {
        return {
            image_file: '',
            url: null,
            image: '',

            counter: 1,
            first: [],
            options: [],
            options2: [],
            companydetail: {},
            id: "",
            e_id: "",
            p_agnst: 'mis',
            date: new Date().toJSON().slice(0, 10),
            vendor_name: "",
            against_invoice: "",
            method_type: "",

            amount: "",
            narration: "",
            chq_number: '',
            e_date: "",
            e_vendor_name: "",
            e_against_invoice: "",

            e_method_type: "",


            e_amount: "",

            e_narration: "",
            disabled: false,
            timeout: null,
            agnstpayment: {},
            methods: {},
            chq_date: '',
            options8: [],
            options9: [],

            agnstpo: {},
            ledger_d_detail: {},

            t_val: '',
            inv_detail: {},
            inv_balance: {},
            total_value: 0,
            remaining_value: '',
            amount_readonly: '',
            filterby: '',
            first_dlt: [],
            var: 1,
            ledger_method_detail: {},
            method_detail_bal: '',
            test_remaining: '',
            e_salesperson: "",
            salesperson: '',
            Bank_name: '',
            e_Bankname: '',
            method: 'Cheque',
        }
    },

    components: {Multiselect},

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
        issue_pv() {
            // alert(this.Bank_name);


            this.filterby = this.method_type.split("_");
            if (this.test_remaining == 1 || this.date == '' || this.amount == '' || this.narration == ''  || this.vendor_name == '' || this.method_type == '') {
                if (this.vendor_name == '') {
                    this.e_vendor_name = "Please enter vendor name";
                }
                if (this.amount == '') {
                    this.e_amount = "Please enter amount";
                }
                if (this.narration == '') {
                    this.e_narration = "Please enter narration";
                }

                if (this.date == '') {
                    this.e_date = "Select date";
                }
                if (this.method_type == '') {
                    this.e_method_type = "Please select method type";
                }
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                var amount = document.getElementsByName('third[]');
                var remaining = document.getElementsByName('fourth[]');

                var k = 'zero';
                var m = 0;
                var n = 0;

                loop: for (var i = 1; i < this.first.length; i++) {
                    for (var j = 1; j < this.first_dlt.length; j++) {
                        if ((i) == this.first_dlt[j]) {
                            continue loop;
                        }
                    }
                    if (this.first[i] == '' || this.first[i] == null) {
                        var j = i;
                        this.$toastr.e("Please select Po at index " + j + "!", "Error!");
                        return;
                    }
                    var a = this.first[i];
                    k = k + "|" + a;
                }
                for (var g = 0; g < amount.length; g++) {
                    var c = amount[g];
                    m = m + "|" + c.value;
                }

                for (var h = 0; h < remaining.length; h++) {
                    var d = remaining[h];
                    n = n + "|" + d.value;
                }

                const formData = new FormData();
                if (this.url == null) {

                } else {
                    formData.append('image_file', this.image, this.image.name);
                }

                formData.append('method', this.method);
                formData.append('date', this.date);
                formData.append('vendor_name', this.vendor_name);
                formData.append('method_type', this.method_type);
                formData.append('amount', this.amount);
                formData.append('narration', this.narration);
                formData.append('chq_date', this.chq_date);

                formData.append('chq_number', this.chq_number);
                formData.append('p_agnst', this.p_agnst);
                formData.append('invoices', k);
                formData.append('invoice_amount', m);
                formData.append('remaining_amount', n);
                formData.append('against_invoice', this.against_invoice);
                formData.append('salesperson', this.salesperson);
                formData.append('Bank_name', this.Bank_name);

                axios.post('./accounts/submit_received_voucher', formData)
                    .then(data => {
                        if (data.data == "submitted") {
                            this.$toastr.s("Receipt Voucher added Successfully!", "Congratulations!");
                            this.$router.push({name: 'sales_received_voucher_detail'})
                        } else {
                            this.$toastr.e(data.data, "Error!");
                        }
                    })
                    .catch(error => {
                        if (error.response.data.message == 'Receipt Voucher Already Exists.') {
                            this.$toastr.e(error.response.data.message, "Error!");
                        }
                    });
            }
        },

        sum_total() {
            if (this.p_agnst != 'mis') {
                var third = document.getElementsByName('third[]');
                var n = 0;
                for (var h = 0; h < third.length; h++) {
                    var d = third[h];
                    n = Number(n) + Number(d.value);
                }
                this.amount = n;
            }
        },
        intervalFetchData: function () {
            setInterval(() => {
                this.sum_total();
            }, 1000);
        },
        add_xz_repeater() {
            this.counter++;


        },
        delete_xz_form(id) {
            const r = confirm("Are you sure?");
            if (r == true) {
                let node = document.getElementById(id);
                node.remove();
                this.first_dlt[this.var] = id;
                this.var++;
                this.sum_total();
            }
        },

        find_methodtype() {
            this.filterby = this.method_type.split("_");
            axios.get('./accounts/ledger_method_report_balance/1/1/' + this.method_type)
                .then(response => {
                    this.ledger_method_detail = response.data;
                    this.method_detail_bal = response.data[0].am
                })
        },

        search_po_detail(id, position) {

            if (this.vendor_name == '' || id == '') {
                this.$toastr.e("Please fill Against Payment and PO Number Firstly!", "Caution!");
            } else {
                axios.get('./accounts/fetch_po_value/' + id + '/' + this.vendor_name)
                    .then(response => {
                        if (response.data == 'notexists') {
                            this.$toastr.e("Vendor Does Not Match with Invoice.", "Please Select Valid!");
                            this.amount_readonly = '';
                        } else {
                            this.inv_balance = response.data;
                            axios.get('./accounts/fetch_po_details1/' + id)
                                .then(response => {
                            document.getElementById("demo_" + position).value = Number(response.data.Amount);
                            this.remaining_value = Number(response.data.Remaining);
                                })

                            this.t_val == this.inv_balance.total_value;
                            axios.get('./accounts/fetch_po_details/' + id)
                                .then(response => {
                                    this.inv_detail = response.data;
                                })
                            this.amount_readonly = 1;
                        }
                    })

            }


        },
        others() {
            this.amount_readonly = 1;
            this.remaining_value = 1000000;
            this.agnstpo = {};
            this.inv_detail = {};
            this.inv_balance = {};
        },
        pi() {
            this.amount_readonly = '';
            this.remaining_value = '';
        },
        search_balance() {
            axios.get('./accounts/ledger_report_balance/1/1/' + this.vendor_name)
                .then(response => {
                    this.ledger_d_detail = response.data;
                })
        },


        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.issue_pv()
        },
        find_against() {
            if (this.p_agnst == 'pi_') {
                this.agnstpo = {};
                axios.get('accounts/fetch_pi_detail/' + this.vendor_name)
                    .then(response => {
                        this.agnstpo = response.data
                        this.options9 = [];

                        var $this = this;
                        for (var i = 0; i < $this.agnstpo.length; i++) {
                            this.options9.push($this.agnstpo[i].FormID);
                        }
                    })
            } else if (this.p_agnst == 'po_') {
                this.agnstpo = {};
                this.inv_detail = {};
                this.inv_balance = {};
                axios.get('accounts/fetch_po_detail1/' + this.vendor_name)
                    .then(response => {
                        this.agnstpo = response.data
                        this.options8 = [];

                        var $this = this;
                        for (var i = 0; i < $this.agnstpo.length; i++) {
                            this.options8.push($this.agnstpo[i].PoCode);
                        }
                    })
            } else if (this.p_agnst == 'mis') {
                this.amount_readonly = 1;
            }

        },
    },
    mounted() {
        axios.get('accounts/fetch_pi_detail/' + this.vendor_name)
            .then(response => {
                this.agnstpo = response.data
                this.options9 = [];

                var $this = this;
                for (var i = 0; i < $this.agnstpo.length; i++) {
                    this.options9.push($this.agnstpo[i].FormID);
                }
            })

        axios.get('accounts/fetch_receivable_head1')
            .then(response => {
                this.agnstpayment = response.data
                this.options = [];

                var $this = this;
                for (var i = 0; i < $this.agnstpayment.length; i++) {
                    this.options.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
                }
            })


        axios.get('accounts/fetch_methods')
            .then(response => {
                this.methods = response.data
                this.options2 = [];

                var $this = this;
                for (var j = 0; j < $this.methods.length; j++) {
                    this.options2.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
                }
            })
        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)

        this.intervalFetchData();
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
