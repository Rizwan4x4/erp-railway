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
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/Inventory/Issuance" style="text-decoration: none;">Issuance
                                    Details</router-link>
                            </li>
                            <li class="breadcrumb-item active">Issuance Site to Site</li>
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
                                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0"
                                            style="margin-bottom:0px">
                                            <div v-for='companydetail1 in companydetail' style="margin-left:30px">
                                                <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                                    <h3 class="text-primary invoice-logo" style="margin-left: 0px;">
                                                        {{ companydetail1.company_name }}</h3>
                                                </div>
                                                <p class="card-text mb-25">Address: {{ companydetail1.company_address }} ,
                                                </p>
                                                <p class="card-text mb-25">City: {{ companydetail1.city }} -
                                                    {{ companydetail1.country }}</p>
                                                <p class="card-text mb-0">Phone: {{ companydetail1.phone_number }}</p>
                                            </div>
                                            <div class="invoice-number-date mt-md-0 mt-2">
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="title">Date:<span
                                                            style="color: #DB4437; font-size: 11px;">*</span></span>
                                                    <input readonly type="date" v-model="date"
                                                        class="form-control invoice-edit-input " />
                                                </div>
                                                <span style="color: #DB4437; font-size: 11px; float:right;"
                                                    v-if="date == ''">{{ e_date }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Issuance Site to
                                            Site</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="d-flex justify-content-between">
                                        <div class="card-body invoice-padding pt-0 border" style="max-width: 50%;">
                                            <div class="row-bill-to invoice-spacing" style="margin-top:0px">
                                                <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Issuance From:
                                                    </h6>
                                                    <div class="invoice-customer">
                                                        <multiselect style="margin-right: 10px;" v-model="issuance_from"
                                                            :options="options_pr" @input="issuance_change()">
                                                        </multiselect>
                                                        <span style="color: #DB4437; font-size: 11px;"
                                                            v-if="issuance_from == ''">{{ e_req }}</span>
                                                    </div>


                                                </div>
                                                <div class="col-xl-10 mb-lg-1 col-bill-to ps-0">
                                                    <div class="form-group">
                                                        <label>Department</label>
                                                        <input v-model="dept_name" readonly class="form-control" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Project Name</label>
                                                        <input v-model="project" readonly class="form-control" />
                                                        <input hidden v-model="req_id" readonly type="number"
                                                            class="form-control" />

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="card-body invoice-padding pt-0 border" style="max-width: 50%;">
                                            <h6 class="invoice-to-title" style="margin-bottom:5px">Issuance To:</h6>

                                            <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                                                <label>Project Name</label>
                                                <multiselect style="margin-right: 10px;" v-model="po_proj"
                                                    :options="optionsproj">
                                                </multiselect>
                                                <span style="color: #DB4437; font-size: 11px;"
                                                    v-if="po_proj == ''">{{ e_po_proj }}</span>

                                                <div class="form-group">
                                                    <label>Department Name</label>
                                                    <multiselect style="margin-right: 10px;" v-model="consumption_dept"
                                                        :options="optionsdept" @input="dept_change()">
                                                    </multiselect>
                                                    <span style="color: #DB4437; font-size: 11px;"
                                                        v-if="consumption_dept == ''">{{ e_consumption_dept }}</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                    <div class="card-body invoice-padding invoice-product-details">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-3" style="text-align: right;
        padding-top: 20px;">
                                                <button class="btn btn-primary" @click="sum_total()">Calculate
                                                    Total</button>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Request Qty</label>
                                                    <input class="form-control" type="text" v-model="est_value" style="" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Issued Qty</label>
                                                    <input class="form-control" type="text" v-model="total_value"
                                                        style="" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group xz_form  row animated slideInDown"
                                            v-for="get_reqdata11 in issuance_items" style="margin-top:40px">
                                            <div data-repeater-list="" class="col-lg-12">
                                                <slot class="source-item">
                                                    <div data-repeater-list="group-a">
                                                        <div class="repeater-wrapper" data-repeater-item>
                                                            <div class="row">
                                                                <div
                                                                    class="col-12 d-flex product-details-border position-relative pe-0">
                                                                    <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                        <div
                                                                            class="col-lg-5 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                            <p class="card-text col-title mb-md-50 mb-0">
                                                                                Item</p>
                                                                            <select class="form-select item-details"
                                                                                name="first[]">
                                                                                <option :value='get_reqdata11.itemId'>{{
                                                                                    get_reqdata11.ItemName }}</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Req.
                                                                                Qty</p>
                                                                            <input name="third[]" readonly
                                                                                :value='get_reqdata11.IssuanceQuantity'
                                                                                type="number" class="form-control" />
                                                                        </div>
                                                                        <div class="col-lg-3 col-12 mt-lg-0 mt-2">
                                                                            <p class="card-text col-title mb-md-50 mb-0">
                                                                                Unit</p>
                                                                            <input name="second[]"
                                                                                :value='get_reqdata11.unit' readonly
                                                                                class="form-control" />

                                                                        </div>
                                                                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                            <p class="card-text col-title mb-md-2 mb-0">
                                                                                Issued Qty</p>
                                                                            <input name="fourth[]" type="number"
                                                                                class="form-control" placeholder="0" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </slot>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Details ends -->
                                    <!-- Invoice Total starts -->
                                    <div class="card-body invoice-padding">
                                        <div class="row invoice-sales-total-wrapper">
                                            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="note" class="form-label fw-bold">Narration:</label>
                                                            <textarea v-model="narration" class="form-control" rows="4"
                                                                id="note"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">

                                            </div>
                                        </div>
                                    </div>
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
                                        <button :disabled="disabled" @click="delay()"
                                            class="btn btn-primary w-100 mb-75">Post Issuance</button>

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
import Multiselect from 'vue-multiselect'

export default {
    components: { Multiselect },
    data() {
        return {

            companydetail: {},
            disabled: false,
            timeout: null,
            proj_details: {},
            issuance_from: '',
            options_pr: [],
            issuance_items: {},
            optionsdept: [],
            departments1: {},
            consumption_dept: '',
            e_consumption_dept: '',
            date: new Date().toJSON().slice(0, 10),
            dept_name: '',
            project: '',
            req_id: '',
            narration: '',
            status: 1,
            get_project: {},
            po_proj: '',
            e_po_proj: '',
            optionsproj: [],
            req_id: '',
            e_req: '',
            issuance_id: '',
            get_reqdata1: {},
            est_value: '',
            total_value: '',
            e_date: '',


        }
    },
    methods: {
        issuance_change() {
            let x = this.issuance_from.split("__");
            this.dept_name = x[3]
            this.project = x[2]
            this.issuance_id = x[0]
            axios.get('accounts/get_issuance_items/' + x[0])
                .then(response => {
                    this.issuance_items = response.data;
                })
            let single_data = this.get_project.filter((cur) => {
                return cur.IssuanceId == x[0]
            })

            this.req_id = single_data[0].RequisitionId
            if (single_data[0].Status == 'Fully Delivered') {
                this.status = 1
            }
            else if (single_data[0].Status == 'Fully Delivered') {
                this.status = 0
            }
        },
        dept_change() {
            let x = this.issuance_from.split("__");

            this.narration = 'Issuance site to site department & project ' + x[3] + " & " + x[2] + " with " + this.consumption_dept + " & " + this.po_proj

        },
        create_site_issuance() {
            if (this.date == '' || this.issuance_from == '' || this.po_proj == '') {
                if (this.date == '') {
                    this.e_date = 'Select date';
                }
                else {
                    this.e_date = '';
                }
                if (this.issuance_from == '') {
                    this.e_req = 'Select Issuance From';
                }
                else {
                    this.e_req = '';
                }
                if (this.po_proj == '') {
                    this.e_po_proj = 'Select Project';
                }
                else {
                    this.e_po_proj = '';
                }

                this.$toastr.e("Please fill required fields!", "Caution!");
            }
            else {
                var item_name = document.getElementsByName('first[]');
                var unit = document.getElementsByName('second[]');
                var issuance_qty = document.getElementsByName('third[]');
                var qty = document.getElementsByName('fourth[]');

                var k = 'zero';
                var l = 'zero';
                var m = 0;
                var n = 0;


                for (var i = 0; i < item_name.length; i++) {
                    var a = item_name[i];
                    k = k + "|" + a.value;
                }
                for (var j = 0; j < unit.length; j++) {
                    var b = unit[j];
                    l = l + "|" + b.value;
                }
                for (var g = 0; g < issuance_qty.length; g++) {
                    var c = issuance_qty[g];
                    m = m + "|" + c.value;
                }

                for (var h = 0; h < qty.length; h++) {
                    var d = qty[h];
                    if (d.value == '') {
                        d.value = 0;
                    }
                    n = n + "|" + d.value;
                }


                axios.post('./accounts/insert_site_issuance', {
                    item_name: k,
                    unit: l,
                    est_cost: m,
                    qty: n,
                    date: this.date,
                    dept_name: this.consumption_dept,
                    project: this.po_proj,
                    narration: this.narration,
                    dept_name1: this.dept_name,
                    project1: this.project,
                    req_id: this.req_id,
                    status: this.status,

                })
                    .then(data => {

                        if (data.data == "submitted") {
                            this.$toastr.s("New Issuance added Successfully", "Congratulations!");
                            this.$router.push({ name: 'issuance_detail' })
                        }
                        else {
                            this.$toastr.e(data.data, "Cautions!");
                        }

                    })
            }
        },

        sum_total() {
            var fourth = document.getElementsByName('fourth[]');
            var m = 0;
            for (var g = 0; g < fourth.length; g++) {
                var c = fourth[g];
                m = Number(m) + Number(c.value);
            }
            this.total_value = m;

            var third = document.getElementsByName('third[]');
            var n = 0;
            for (var h = 0; h < third.length; h++) {
                var d = third[h];
                n = Number(n) + Number(d.value);
            }
            this.est_value = n;

        },

        delay() {
            this.disabled = true
            this.timeout = setTimeout(() => {
                this.disabled = false
            }, 5000)
            this.create_site_issuance()
        },

    },
    mounted() {
        axios.get("get_linkprojects").then((response) => {
            this.proj_details = response.data
            this.optionsproj = [];

            var $this = this;
            for (var i = 0; i < $this.proj_details.length; i++) {
                this.optionsproj.push($this.proj_details[i].ProjectName);
            }

        })
        axios.get('accounts/dept_data')
            .then(response => {

                this.departments1 = response.data
                this.optionsdept = [];

                var $this = this;
                for (var i = 0; i < $this.departments1.length; i++) {
                    this.optionsdept.push($this.departments1[i].COmpanyName);
                }
            })
        axios.get('fetch_companyDetail')
            .then(response => this.companydetail = response.data)
        axios.get('accounts/get_allissuance')
            .then(response => {
                this.get_project = response.data
                this.options_pr = [];

                var $this = this;
                for (var i = 0; i < $this.get_project.length; i++) {
                    this.options_pr.push($this.get_project[i].IssuanceId + '__' + $this.get_project[i].IssuanceCode + '__' + $this.get_project[i].ProjectName + "__" + $this.get_project[i].DepartmentName);
                }
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
}</style>
