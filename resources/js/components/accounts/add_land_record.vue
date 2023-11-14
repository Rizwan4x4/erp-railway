<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content">
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
                                <router-link to="/accounts/land_payment_detail" style="text-decoration: none;">Land
                                    Module</router-link>
                            </li>
                            <li class="breadcrumb-item active">Add New Record</li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <section class="app-user-view-account">
                        <div class="row">
                            <!-- User Sidebar -->
                            <!--/ User Sidebar -->
                            <div class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add New Record</h4>

                                    </div>
                                    <div class="card-body">
                                        <div style="margin-bottom: 20px"
                                            class="d-flex justify-content-between align-items-center header-action smx-2 row mt-75">
                                            <section id="accordion-with-border">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div id="accordionWrapa50" role="tablist"
                                                            aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row row-bill-to invoice-spacing"
                                                                        style="margin-top:0px">
                                                                        <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                                            <div class="form-group">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Select
                                                                                    Seller:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <div class="invoice-customer">
                                                                                    <select v-model="seller_id"
                                                                                        class="invoiceto form-select">
                                                                                        <option value=''>Select Seller
                                                                                        </option>
                                                                                        <option
                                                                                            v-for='get_vendors1 in get_vendors'
                                                                                            :value='get_vendors1.SellerName'>
                                                                                            {{ get_vendors1.SellerName }}
                                                                                        </option>
                                                                                    </select>
                                                                                    <span
                                                                                        style="color: #DB4437; font-size: 11px;"
                                                                                        v-if="seller_id == ''">{{
                                                                                            e_seller_id }}</span>
                                                                                </div>
                                                                            </div>


                                                                        </div>

                                                                        <div class="col-xl-6 p-0 ps-xl-2 mt-xl-0 mt-2">


                                                                        </div>
                                                                    </div>
                                                                    <div class="divider">
                                                                        <div class="divider-text"
                                                                            style="font-size: 24px;font-weight: 900;">Record
                                                                            Information</div>
                                                                    </div>

                                                                    <div class="row row-bill-to invoice-spacing">
                                                                        <div class="col-xl-4 mb-lg-1 col-bill-to ps-0">
                                                                            <div class="form-group">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Moza No.:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <div class="invoice-customer">
                                                                                    <input type="text" v-model="moza_no"
                                                                                        class="form-control"
                                                                                        placeholder='Type Moza No.'
                                                                                        style="" />

                                                                                    <span
                                                                                        style="color: #DB4437; font-size: 11px;"
                                                                                        v-if="moza_no == ''">{{ e_moza_no
                                                                                        }}</span>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="col-xl-4 mb-lg-1 col-bill-to ps-0">

                                                                            <div class="form-group">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Maraba
                                                                                    No:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <input type="text" v-model="maraba_no"
                                                                                    class="form-control"
                                                                                    placeholder='Type Maraba Number' />
                                                                                <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="maraba_no == ''">{{ e_maraba_no
                                                                                    }}</span>
                                                                            </div>

                                                                        </div>

                                                                        <div class="col-xl-4 mb-lg-1 col-bill-to ps-0">

                                                                            <div class="form-group">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Khasra
                                                                                    No:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <input type="text" v-model="khasra_no"
                                                                                    class="form-control"
                                                                                    placeholder='Type Khasra Number' />
                                                                                <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="khasra_no == ''">{{ e_khasra_no
                                                                                    }}</span>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-4 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">
                                                                                Khewat</p>
                                                                            <input type="text" class="form-control"
                                                                                name="khewatt" />
                                                                        </div>

                                                                        <div class="col-lg-4 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">
                                                                                Khatoni</p>
                                                                            <input type="text" class="form-control"
                                                                                name="khotonii" />
                                                                        </div>






                                                                    </div>

                                                                    <div
                                                                        class="card-body invoice-padding invoice-product-details">
                                                                        <div>
                                                                            <h3>Area Bought</h3>
                                                                        </div>
                                                                        <div class="form-group xz_form  row animated slideInDown"
                                                                            v-for="count in counter" :id="count"
                                                                            :key="count" style="margin-top:20px">
                                                                            <div data-repeater-list="" class="col-lg-12">
                                                                                <slot class="source-item">
                                                                                    <div data-repeater-list="group-a">
                                                                                        <div class="repeater-wrapper"
                                                                                            data-repeater-item>
                                                                                            <div class="row">
                                                                                                <div
                                                                                                    class="col-12 d-flex product-details-border position-relative pe-0">
                                                                                                    <div
                                                                                                        class="row w-100 pe-lg-0 pe-1 py-2">
                                                                                                        <div
                                                                                                            class="col-lg-2 col-12 my-lg-0 my-2">
                                                                                                            <p
                                                                                                                class="card-text col-title mb-md-2 mb-0">
                                                                                                                Acre</p>
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                @change="check_total()"
                                                                                                                class="form-control"
                                                                                                                name="fourth[]"
                                                                                                                value="0"
                                                                                                                v-on:focus="handleFocus($event)"
                                                                                                                v-on:focusout="handleFocusOut($event)" />
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                                                            <p
                                                                                                                class="card-text col-title mb-md-2 mb-0">
                                                                                                                Kanal</p>
                                                                                                            <input
                                                                                                                @change="check_total()"
                                                                                                                class="form-control"
                                                                                                                type="number"
                                                                                                                name="first[]"
                                                                                                                style=""
                                                                                                                placeholder=""
                                                                                                                value="0"
                                                                                                                v-on:focus="handleFocus1($event)"
                                                                                                                v-on:focusout="handleFocusOut1($event)" />

                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-3 col-12 my-lg-0 my-2">
                                                                                                            <p
                                                                                                                class="card-text col-title mb-md-2 mb-0">
                                                                                                                Marla</p>
                                                                                                            <input
                                                                                                                type="number"
                                                                                                                @change="check_total()"
                                                                                                                class="form-control"
                                                                                                                placeholder=""
                                                                                                                name="second[]"
                                                                                                                value="0"
                                                                                                                v-on:focus="handleFocus2($event)"
                                                                                                                v-on:focusout="handleFocusOut2($event)" />
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-lg-2 col-12 my-lg-0 my-2">
                                                                                                            <p
                                                                                                                class="card-text col-title mb-md-2 mb-0">
                                                                                                                SQFT</p>
                                                                                                            <input
                                                                                                                @change="check_total()"
                                                                                                                type="number"
                                                                                                                class="form-control"
                                                                                                                name="third[]"
                                                                                                                value="0"
                                                                                                                v-on:focus="handleFocus3($event)"
                                                                                                                v-on:focusout="handleFocusOut3($event)" />
                                                                                                        </div>




                                                                                                    </div>
                                                                                                    <div style="margin-left:10px"
                                                                                                        class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">
                                                                                                        <div class="delete_btn"
                                                                                                            style="border-radius:14px;">
                                                                                                            <div data-repeater-delete=""
                                                                                                                class=""
                                                                                                                style="margin-right: 6px;"
                                                                                                                v-on:click="delete_xz_form(count); check_total()">
                                                                                                                <span
                                                                                                                    style="padding-top: 14px;padding-left: 7px;">
                                                                                                                    <i
                                                                                                                        class="fa-solid fa-xmark"></i>
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
                                                                            <div class="col-12 ">
                                                                                <div data-repeater-create=""
                                                                                    class="btn btn-primary btn-sm btn-add-new"
                                                                                    v-on:click="add_xz_repeater();">
                                                                                    <!-- <i data-feather="plus"
                                                                                        class="me-25"></i> -->
                                                                                    <span class="align-middle">+ Add More</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider">
                                                                        <div class="divider-text"
                                                                            style="font-size: 24px;font-weight: 900;">
                                                                            Payment Structure</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-12 my-lg-0 my-2">
                                                                            <h5 style="color:green">Total Area: {{ tot_area
                                                                            }}
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 my-lg-0 my-2">
                                                                            <h5 style="color:green">Price Per Acre:
                                                                                {{ acre_price.toLocaleString() }}</h5>
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 my-lg-0 my-2">
                                                                            <h5 style="color:green">Total Price:
                                                                                {{ Number(tot_amount).toLocaleString() }}
                                                                            </h5>
                                                                        </div>



                                                                    </div>
                                                                    <div class="row row-bill-to invoice-spacing"
                                                                        style="margin-top:0px">
                                                                        <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                                            <div class="form-group"
                                                                                style="margin-bottom:10px">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Purchase
                                                                                    Price/Acre:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <input @change="check_total()" type="number"
                                                                                    v-model="acre_price"
                                                                                    class="form-control"
                                                                                    placeholder='Type Acre Price'
                                                                                    v-on:focus="handleFocus4($event)"
                                                                                    v-on:focusout="handleFocusOut4($event)"
                                                                                    />
                                                                                <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="acre_price == ''">{{ e_acre_price
                                                                                    }}</span>
                                                                            </div>
                                                                            <div class="form-group"
                                                                                style="margin-bottom:10px">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Additional
                                                                                    Charges:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <input @change="check_total()" value="0"
                                                                                    type="number" v-model="additional_price"
                                                                                    class="form-control"
                                                                                    placeholder='Type Additinal Price'
                                                                                    v-on:focus="handleFocus5($event)"
                                                                                                                v-on:focusout="handleFocusOut5($event)" />
                                                                                <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="additional_price == ''">{{ e_additional_price
                                                                                    }}</span>
                                                                            </div>

                                                                            <div class="form-group"
                                                                                style="margin-bottom:10px">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Possession
                                                                                    Status:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <input type="text" v-model="p_status"
                                                                                    class="form-control"
                                                                                    placeholder='Type Status' />
                                                                                <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="p_status == ''">{{ e_p_status
                                                                                    }}</span>
                                                                            </div>
                                                                            <div class="form-group"
                                                                                style="margin-bottom:10px">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Any
                                                                                    Litigation:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <textarea v-model="litigation"
                                                                                    class="form-control" />
                                                                                    <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="litigation == ''">{{ e_litigation
                                                                                    }}</span>

                                                                            </div>
                                                                            <div class="form-group"
                                                                                style="margin-bottom:10px">
                                                                                <h6 class="invoice-to-title"
                                                                                    style="margin-bottom:5px">Remarks:<span
                                                                                        style="color: #DB4437; font-size: 11px;">*</span>
                                                                                </h6>
                                                                                <textarea v-model="remarks"
                                                                                    class="form-control" />
                                                                                    <span
                                                                                    style="color: #DB4437; font-size: 11px;"
                                                                                    v-if="remarks == ''">{{ e_remarks
                                                                                    }}</span>
                                                                            </div>


                                                                        </div>
                                                                        <div class="col-xl-6 mb-lg-1 col-bill-to ps-0"
                                                                            style="border:1px solid lightgrey;border-radius:4px;">
                                                                            <div class="row">

                                                                                <div class="col-md-6"
                                                                                    style="padding-top: 20px;padding-left:20px">
                                                                                    <button class="btn btn-primary"
                                                                                        @click="sum_total()">Calculate
                                                                                        Total</button>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Total Installment Amount</label>
                                                                                        <input readonly class="form-control"
                                                                                            type="text"
                                                                                            v-model="total_value"
                                                                                            style="" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group xz_form  row animated slideInDown"
                                                                                v-for="count2 in counter2" :id="count2"
                                                                                :key="count2"
                                                                                style="margin-top:20px;margin-left: 20px;margin-right:20px">
                                                                                <div data-repeater-list=""
                                                                                    class="col-lg-12">
                                                                                    <slot class="source-item">
                                                                                        <div data-repeater-list="group-a">
                                                                                            <div class="repeater-wrapper"
                                                                                                data-repeater-item>
                                                                                                <div class="row">
                                                                                                    <div
                                                                                                        class="col-12 d-flex product-details-border position-relative pe-0">

                                                                                                        <div
                                                                                                            class="row w-100 pe-lg-0 pe-1 py-2">

                                                                                                            <div
                                                                                                                class="col-lg-6 col-12 my-lg-0 my-2">
                                                                                                                <p
                                                                                                                    class="card-text col-title mb-md-2 mb-0">
                                                                                                                    Installment Date
                                                                                                                </p>
                                                                                                                <input
                                                                                                                    type="date"
                                                                                                                    class="form-control"
                                                                                                                    name="inst_date[]" />
                                                                                                            </div>

                                                                                                            <div
                                                                                                                class="col-lg-6 col-12 my-lg-0 my-2">
                                                                                                                <p
                                                                                                                    class="card-text col-title mb-md-2 mb-0">
                                                                                                                    Installment
                                                                                                                    Amount
                                                                                                                </p>
                                                                                                                <input
                                                                                                                    type="number"
                                                                                                                    class="form-control"
                                                                                                                    name="inst_amount[]" />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div style="margin-left:10px"
                                                                                                            class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">
                                                                                                            <div class="delete_btn2"
                                                                                                                style="border-radius:14px;">
                                                                                                                <div data-repeater-delete2=""
                                                                                                                    class=""
                                                                                                                    style="margin-right: 6px;"
                                                                                                                    v-on:click="delete_xz_form2(count2)">
                                                                                                                    <span
                                                                                                                        style="padding-top: 14px;padding-left: 7px;">
                                                                                                                        <i
                                                                                                                            class="fa-solid fa-xmark"></i>
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
                                                                            <div class="row mt-1"
                                                                                style="margin-left: 20px;margin-right:20px">
                                                                                <div class="col-12 px-0">
                                                                                    <div data-repeater-create=""
                                                                                        class="btn btn-primary btn-sm btn-add-new"
                                                                                        v-on:click="add_xz_repeater2();">
                                                                                        <!-- <i data-feather="plus"
                                                                                            class="me-25"></i> -->
                                                                                        <span class="align-middle">+ Add
                                                                                            More</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12" style="text-align:center">
                                                                        <button :disabled="disabled" @click="delay()"
                                                                            type="button"
                                                                            class="btn btn-primary mt-1 me-1 waves-effect waves-float waves-light">Save
                                                                            Land Information</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <!-- /User Card -->
                            </div>
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

            disabled: false,
            timeout: null,
            get_vendors: {},

            counter: 1,
            counter2: 1,

            seller_id: '',

            moza_no: '',
            maraba_no: '',
            khasra_no: '',
            acre_price: 0,
            p_status: '',
            litigation: '',
            remarks: '',
            khewatt: '',
            khotonii: '',
            additional_price: 0,

            e_seller_id: '',
            e_moza_no: '',
            e_maraba_no: '',
            e_khasra_no: '',
            e_acre_price: '',
            e_additional_price:'',
            e_p_status:'',
            e_litigation:'',
            e_remarks:'',
            e_installment_date:'',
            e_installment_amount:'',
            adsdata: {},
            tot_amount: 0,
            tot_area: 0,
            total_value: 0
        };
    },

    methods: {
        sum_total() {
            var fourth = document.getElementsByName('inst_amount[]');
            var m = 0;
            for (var g = 0; g < fourth.length; g++) {
                var c = fourth[g];
                m = Number(m) + Number(c.value);
            }
            this.total_value = m;
        },

        handleFocus(event) {
            event.target.value = '';

        },
        handleFocusOut(event) {
            if (event.target.value === '') {
                event.target.value = 0;
            }
        },

        handleFocus1(event) {
            event.target.value = '';

        },
        handleFocusOut1(event) {
            if (event.target.value === '') {
                event.target.value = 0;
            }
        },

        handleFocus2(event) {
            event.target.value = '';

        },
        handleFocusOut2(event) {
            if (event.target.value === '') {
                event.target.value = 0;
            }
        },

        handleFocus3(event) {
            event.target.value = '';

        },
        handleFocusOut3(event) {
            if (event.target.value === '') {
                event.target.value = 0;
            }
        },
        handleFocus4(event) {
            event.target.value = '';

        },
        handleFocusOut4(event) {
            if (event.target.value === '') {
                event.target.value = 0;
            }
        },

        handleFocus5(event) {
            event.target.value = '';

        },
        handleFocusOut5(event) {
            if (event.target.value === '') {
                event.target.value = 0;
            }
        },
        check_total() {
            var kanal = document.getElementsByName('first[]');
            var marla = document.getElementsByName('second[]');
            var sqft = document.getElementsByName('third[]');
            var khewat = document.getElementsByName('fourth[]');
            var kanaltemp = 0;
            var marlatemp = 0;
            var sqfttemp = 0;
            var khewattemp = 0;

            for (var i = 0; i < kanal.length; i++) {
                var a = kanal[i];
                kanaltemp = kanaltemp + "|" + a.value;
            }

            for (var g = 0; g < marla.length; g++) {
                var c = marla[g];
                marlatemp = marlatemp + "|" + c.value;
            }

            for (var h = 0; h < sqft.length; h++) {
                var d = sqft[h];
                sqfttemp = sqfttemp + "|" + d.value;
            }

            for (var f = 0; f < khewat.length; f++) {
                var fn = khewat[f];
                khewattemp = khewattemp + "|" + fn.value;
            }

            axios.post('accounts/check_land_total_amount', {
                kanaltemp: kanaltemp,
                marlatemp: marlatemp,
                sqfttemp: sqfttemp,
                khewattemp: khewattemp,
                acre_price: this.acre_price,
                additional_price: this.additional_price,
            })
                .then(data => {
                    this.tot_area = data.data.tot_area;
                    this.tot_amount = data.data.tot_amount;
                })




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

        add_xz_repeater2() {
            this.counter2++;
            // let itm  = document.getElementsByClassName("xz_form")[0];
            // let cln = itm.cloneNode(true);
            // cln.id = this.counter;
            // document.getElementsByClassName("container")[0].insertBefore(cln,document.getElementsByClassName("adding")[0]);

        },
        delete_xz_form2(id) {

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
            this.create_land_info();
        },
        create_land_info() {
            var installment_date = document.getElementsByName('inst_date[]');
            var installment_amount = document.getElementsByName('inst_amount[]');
            var installment_datetemp = 'zero';
            var installment_amounttemp = 0;
var e1='',e2='';
                for (var xx = 0; xx < installment_date.length; xx++) {
                if(installment_date[xx].value==''){
                    e1=e1+(xx+1)+', ';
                    }
                var dat = installment_date[xx];
                    installment_datetemp = installment_datetemp + "|" + dat.value;
                }
                if(e1!='')
                    {  this.e_installment_date='Please fill due date of installment no# '+e1;
                     this.$toastr.e(this.e_installment_date, "Caution!");

                }
                for (var yy = 0; yy < installment_amount.length; yy++) {
                    if(installment_amount[yy].value==''){
                        e2=e2+(yy+1)+', ';
                    }
                    var amo = installment_amount[yy];
                    installment_amounttemp = installment_amounttemp + "|" + amo.value;
                }
                if(e2!='')
                    {  this.e_installment_amount='Please fill Amount of installment no# '+e2;
                     this.$toastr.e(this.e_installment_amount, "Caution!");

                }

            if (this.seller_id == '' || this.moza_no == '' || this.maraba_no == '' || this.khasra_no == '' || this.acre_price == '' || this.p_status == '' || this.litigation == '' || this.remarks == ''||this.e_installment_date!=''||this.e_installment_amount!='') {

            if(this.seller_id== ''){

                this.e_seller_id="Select Seller";
            }
            if(this.moza_no== ''){
                this.e_moza_no='Enter Moza No';
            }
            if(this.maraba_no== ''){
                this.e_maraba_no= 'Enter Maraba No';
            }
            if(this.khasra_no== ''){
                this.e_khasra_no= 'Enter Khasra No';
            }
            if(this.acre_price== ''){
                this.e_acre_price= 'Enter Price';
            }
            if(this.additional_price==''){
                this.e_additional_price='Enter Additional Charge';
            }
            if(this.p_status==''){
                this.e_p_status='Enter Possession Status';
            }
            if(this.litigation==''){
                this.e_litigation='Enter any litigation';
            }
            if(this.remarks==''){
                this.e_remarks='Enter Remarks';
            }


                this.$toastr.e("Please fill *  fields!", "Caution!");
            }

            else {
                var kanal = document.getElementsByName('first[]');
                var marla = document.getElementsByName('second[]');
                var sqft = document.getElementsByName('third[]');
                var khewat = document.getElementsByName('fourth[]');


                var kanaltemp = 0;
                var marlatemp = 0;
                var sqfttemp = 0;
                var khewattemp = 0;



                for (var i = 0; i < kanal.length; i++) {
                    var a = kanal[i];
                    kanaltemp = kanaltemp + "|" + a.value;
                }

                for (var g = 0; g < marla.length; g++) {
                    var c = marla[g];
                    marlatemp = marlatemp + "|" + c.value;
                }

                for (var h = 0; h < sqft.length; h++) {
                    var d = sqft[h];
                    sqfttemp = sqfttemp + "|" + d.value;
                }

                for (var f = 0; f < khewat.length; f++) {
                    var fn = khewat[f];
                    khewattemp = khewattemp + "|" + fn.value;
                }
                axios.post('accounts/insert_land_information', {
                    kanaltemp: kanaltemp,
                    marlatemp: marlatemp,
                    sqfttemp: sqfttemp,
                    khewattemp: khewattemp,

                    seller_name: this.seller_id,
                    deal_no: this.deal_no,
                    moza_no: this.moza_no,
                    maraba_no: this.maraba_no,
                    khasra_no: this.khasra_no,
                    acre_price: this.acre_price,
                    p_status: this.p_status,
                    litigation: this.litigation,
                    remarks: this.remarks,
                    khewatnew: this.khewatt,
                    khotoninew: this.khotonii,
                    installment_datetemp: installment_datetemp,
                    installment_amounttemp: installment_amounttemp,
                    additional_price: this.additional_price,
                })
                    .then(data => {

                        if (data.data == "submitted") {
                            this.$toastr.s("Land Information submitted Successfully", "Congratulations!");
                            this.$router.push({ name: 'land_payment_detail' })
                        }
                        else if (data.data == "Empty field") {
                            this.$toastr.e("To ensure that the installment amount is equal to the total amount", "Error!");
                        }


                    })
            }












        },

    },

    mounted() {

        axios.get('./accounts/get_seller')
            .then(response => this.get_vendors = response.data)
    },
};

</script>
