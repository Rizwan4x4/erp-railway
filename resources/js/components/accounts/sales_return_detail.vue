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
                            <li class="breadcrumb-item active">
                                Sales Return
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-buttons d-inline-flex mt-50">
                                        <router-link style="float:left" to="/sales-return/create" class="btn btn-primary waves-effect">Create Return</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invoice_status ms-sm-2">
                                            <select id="UserRole" class="form-select ms-50 text-capitalize">
                                                <option value=""> Select Status </option>
                                                <option value="Downloaded" class="text-capitalize">Downloaded</option>
                                                <option value="Draft" class="text-capitalize">Draft</option>
                                                <option value="Paid" class="text-capitalize">Paid</option>
                                                <option value="Partial Payment" class="text-capitalize">Partial Payment</option>
                                                <option value="Past Due" class="text-capitalize">Past Due</option>
                                                <option value="Sent" class="text-capitalize">Sent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>SubTotal</th>
                                            <th>TAx</th>
                                            <th>Delivery</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td class=" control" tabindex="0" style="display: none;"></td>
                                            <td class="sorting_1"><a class="fw-bold" href="app-invoice-preview.html">{{adsdata1.SRtnID}}</a></td>
                                            <td>{{adsdata1.Dated}}</td>
                                            <td>{{adsdata1.customerName}}</td>
                                            <td>{{currency}}. {{Number(adsdata1.SubTotal)}}</td>
                                            <td>{{currency}}. {{Number(adsdata1.Tax)}}</td>
                                            <td>{{currency}}. {{Number(adsdata1.ShippingCharges)}}</td>
                                            <td>{{currency}}. {{Number(adsdata1.TotalAmount)}}</td>
                                            <td>
                                                <div class="d-flex align-items-center col-actions">
                                                    <a class="me-25" data-bs-toggle="modal" @click="editSaleInvoice(adsdata1.SaleReturnID)" data-bs-target="#viewsalereturn">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item">
                                                                <i class="fa-solid fa-print"></i>
                                                                Print Sale Return
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <!-- users list ends -->
        <div class="modal fade" id="editsalereturn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card">
                            <!-- Header starts -->
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0" style="margin-bottom: 0px">
                                    <div v-for="companydetail1 in companydetail" style="margin-left: 30px">
                                        <div style="padding-top: 10px; margin-bottom: 0px" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px">
                                                {{ companydetail1.company_name }}
                                            </h3>
                                        </div>
                                        <p class="card-text mb-25">
                                            Address: {{ companydetail1.company_address }} ,
                                        </p>
                                        <p class="card-text mb-25">
                                            City: {{ companydetail1.city }} -
                                            {{ companydetail1.country }}
                                        </p>
                                        <p class="card-text mb-0">
                                            Phone: {{ companydetail1.phone_number }}
                                        </p>
                                    </div>
                                    <div class="invoice-number-date mt-md-0 mt-2">
                                        <div class="d-flex align-items-center mb-1">
                                            <span style="width:35%" class="title">Date:</span>
                                            <input v-model="date" type="date" class="form-control invoice-edit-input " />
                                        </div>
                                        <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{e_date}}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Header ends -->
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px; font-weight: 900">
                                    Sales Return
                                </div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row row-bill-to invoice-spacing" style="margin-top: 0px">
                                    <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                        <h6 class="invoice-to-title" style="margin-bottom: 5px">
                                            Return To:
                                        </h6>
                                        <div class="invoice-customer">
                                            <select class="invoiceto form-select" v-model="returnTo">
                                                <option selected value="">Select</option>
                                                <option value="shelby">Shelby Company Limited</option>
                                                <option value="hunters">Hunters Corp</option>
                                            </select>
                                            <span style="color: #db4437; font-size: 11px" v-if="returnTo == ''">{{ returnTo_error }}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 p-0 ps-xl-2 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Payment Details:</h6>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="pe-1">Total Due:</td>
                                                    <td><strong>$12,110.55</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-1">Bank name:</td>
                                                    <td>American Bank</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-1">Country:</td>
                                                    <td>United States</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-1">IBAN:</td>
                                                    <td>ETD95476213874685</td>
                                                </tr>
                                                <tr>
                                                    <td class="pe-1">SWIFT code:</td>
                                                    <td>BR91905</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Product Details starts -->
                            <div class="card-body invoice-padding invoice-product-details">
                                <div class="form-group xz_form row animated slideInDown" v-for="count in counter" :key="count" style="margin-top: 40px">
                                    <div data-repeater-list="" class="col-lg-12">
                                        <slot class="source-item">
                                            <div data-repeater-list="group-a">
                                                <div class="repeater-wrapper" data-repeater-item>
                                                    <div class="row">
                                                        <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                <div class="col-lg-5 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">
                                                                        Item
                                                                    </p>
                                                                    <select class="form-select item-details" name="first[]">
                                                                        <option selected value="">Select</option>
                                                                        <option value="App Design">App Design</option>
                                                                        <option value="App Customization">App Customization</option>
                                                                        <option value="ABC Template">ABC Template</option>
                                                                        <option value="App Development">App Development</option>
                                                                    </select>
                                                                    <textarea name="second[]" class="form-control mt-2" rows="1" placeholder="Customization"></textarea>
                                                                </div>
                                                                <div class="col-lg-3 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">
                                                                        Cost
                                                                    </p>
                                                                    <input name="third[]" type="number" class="form-control" placeholder="Item cost" />
                                                                    <div class="mt-2">
                                                                        <div class="row form-row mt-50">
                                                                            <div class="mb-1 col-md-12">
                                                                                <select name="fourth[]" id="tax-1-input" class="form-select tax-select">
                                                                                    <option selected value="">Select Tax</option>
                                                                                    <option value="0%">0%</option>
                                                                                    <option value="1%">1%</option>
                                                                                    <option value="10%">10%</option>
                                                                                    <option value="18%">18%</option>
                                                                                    <option value="40%">40%</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">
                                                                        Qty
                                                                    </p>
                                                                    <input type="number" class="form-control" name="fourth[]" value="1" placeholder="Qty" />
                                                                </div>
                                                                <div class="col-lg-2 col-12 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">
                                                                        Price
                                                                    </p>
                                                                    <input name="fiveth[]" type="number" readonly class="form-control" placeholder="Price" />
                                                                </div>
                                                            </div>
                                                            <div style="margin-left: 10px" class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">
                                                                <div class="delete_btn" style="border-radius: 14px">
                                                                    <div data-repeater-delete="" class="" style="margin-right: 6px" v-on:click="delete_xz_form(count)">
                                                                        <span style="padding-top: 14px; padding-left: 7px;">
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
                                        <div data-repeater-create="" class="btn btn-primary btn-sm btn-add-new" v-on:click="add_xz_repeater()">
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
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <div class="d-flex flex-column align-items-left mb-1">
                                            <label for="Salesperson" class="form-label">Salesperson:</label>
                                            <input type="text" class="form-control ms-50" id="Salesperson" placeholder="Edward Crowley" v-model="Salesperson" />
                                            <span style="color: #db4437; font-size: 11px" v-if="Salesperson == ''">{{ Salesperson_error }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                       <div class="invoice-total-wrapper" style="max-width: 300px;">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> SubTotal: {{currency}}. {{Number(salereturn1.SubTotal)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Tax: {{currency}}. {{Number(salereturn1.Tax)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Delivery : {{currency}}. {{Number(salereturn1.ShippingCharges)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Discount: {{currency}}. {{Number(salereturn1.Discount)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p style="font-weight:bold" class="invoice-total-title">  Total: {{currency}}. {{Number(salereturn1.TotalAmount)}}</p>
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
                                            <label for="note" class="form-label fw-bold">Note:</label>
                                            <textarea v-model="note" placeholder="Note" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-2 pt-50">
                                    <button :disabled="disabled" @click="delay()" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewsalereturn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12" v-for="salereturn1 in salereturn">
                        <div class="card invoice-preview-card">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail1.company_name}}</h3>
                                        </div>
                                        <p class="card-text mb-25">Address: {{companydetail1.company_address}} , </p>
                                        <p class="card-text mb-25">City: {{companydetail1.city}} - {{companydetail1.country}}</p>
                                        <p class="card-text mb-0">Phone: {{companydetail1.phone_number}}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2" style="min-width:25%">
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{salereturn1.SRtnID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{salereturn1.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span class="badge badge-glow bg-success">Not defined</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Sales Return</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-8 p-0">
                                        <h6 class="mb-2">Customer Name:</h6>
                                        <h6 class="mb-25">{{salereturn1.customerName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Sales Invoice</h6>
                                        <p class="card-text mb-25">{{salereturn1.saleID}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Name</th>
                                            <th class="py-1">Sale qty</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Return Qty</th>
                                            <th class="py-1">Unit Cost</th>
                                            <th class="py-1">SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="srProducts1 in srProducts">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{srProducts1.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{srProducts1.PoQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{srProducts1.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{srProducts1.ReturnQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(srProducts1.Price)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(srProducts1.SubTotal)}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{salereturn1.Remarks}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="max-width: 300px;">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> SubTotal: {{Number(salereturn1.SubTotal)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Tax: {{Number(salereturn1.Tax)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Delivery : {{Number(salereturn1.ShippingCharges)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Discount: {{Number(salereturn1.Discount)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p style="font-weight:bold" class="invoice-total-title"> Total: {{Number(salereturn1.TotalAmount)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import MaskedInput from 'vue-masked-input';
export default {
    data() {
        return {
        currency: '',
            companydetail: {},
          
            adsdata: {},
            keyword1: '',
            disabled: false,
            timeout: null,
            counter: 1,
            date: '',
            e_date: '',
            returnTo: '',
            returnTo_error: '',
            Salesperson: '',
            Salesperson_error: '',
            note: '',

            sr_items: {},
            salereturn: {},
            srProducts: {},

        }
    },
    methods: {
        editSaleInvoice(id) {
            axios.get('accounts_get_sr_data/' + id)
                .then(response => {
                    this.salereturn = response.data;
                    /*
                    this.e_id = id;
                    this.ed_narration = response.data[0].Remarks;
                    this.vendor_n = response.data[0].vendorName;
                    this.date = response.data[0].PoDate;
                    this.status = response.data[0].Status;
                    this.tax_amount = response.data[0].Tax;
                    this.delivery_amount = response.data[0].ShippingCharges;
                    this.discount = response.data[0].Discount;
                    this.total = response.data[0].Total;
                    this.reqid = response.data[0].AgainstReq;
                    this.quoid = response.data[0].AgainstQuo;
                    */
                    axios.get('accounts_get_srProducts/' + id)
                        .then(response => this.srProducts = response.data)
                })
        },
        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.update_sales_return();
        },
        update_sales_return() {
            if (this.date == '' || this.returnTo == '' || this.Salesperson == '') {
                if (this.date == '') {
                    this.e_date = "Please select date";
                }
                if (this.returnTo == '') {
                    this.returnTo_error = "Please select company";
                }
                if (this.Salesperson == '') {
                    this.Salesperson_error = "Please enter Salesperson field";
                }
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                this.$toastr.s("Sales return updated Successfully", "Congratulations!");
            }
        },
        getResult(page = 1) {
            axios.get('accounts/get_sales_return/?page=' + page)
                .then(response => this.adsdata = response.data)
                .catch(error => {});
        },
        getResults() {

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
    },
    components: {
        MaskedInput
    },
    watch: {
        keyword1(after, before) {
            this.getResults();
        }
    },
    mounted() {
     axios.get('get_currency').then((response) => {
            this.currency = response.data[0].Currency;
        })
        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)
  
        this.getResult();
    }
}

</script>
<style scoped>
.card-title {
    margin-bottom: 8px !important;
    margin-top: 15px !important;
}

</style>
