<template>
    <div>
        <div class="app-content content ">
            <div class="noprint content-overlay"></div>
            <div class="noprint c-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="noprint content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link to="/Inventory/Issuance" style="text-decoration: none;">Issuances</router-link>
                            </li>
                            <li class="breadcrumb-item active">New Issuance</li>
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
                                                    <input readonly type="date" v-model="date" class="form-control invoice-edit-input " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">New Issuance</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                            <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Select Requsition: <span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                <div class="invoice-customer">
                                                    <multiselect style="margin-right: 10px;" :options="options" @input="get_req_items()" value="id" label="label" v-model="req" placeholder="Select Demand Requisition"></multiselect>
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="req=='' || req==null">{{e_req}}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <label>Department</label>
                                                <input v-model="dept_name" readonly class="form-control" />
                                            </div>
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <label>Project Name</label>
                                                <input v-model="project" readonly class="form-control" />
                                                <input hidden v-model="req_id" readonly type="number" class="form-control" />
                                            </div>
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <label class="form-label" for="basicSelect">Status: </label>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="status" name="inlineRadioOptions" id="inlineRadio1" value="0" checked="" style="cursor:pointer;">
                                                    <label class="form-check-label" for="inlineRadio1">Partially Delivered</label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-top:0px">
                                                    <input class="form-check-input" type="radio" v-model="status" name="inlineRadioOptions" id="inlineRadio2" value="1" style="cursor:pointer;">
                                                    <label class="form-check-label" for="inlineRadio2">Fully Delivered</label>
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
                                            <div class="col-md-3" style="text-align: right; padding-top: 20px;">
                                                <button class="btn btn-primary" @click="sum_total()">Calculate Total</button>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Requesition Quantity</label>
                                                    <input class="form-control" type="text" v-model="est_value" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Qty Issuing</label>
                                                    <input class="form-control" type="text" v-model="total_value" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group xz_form  row animated slideInDown" v-for="(get_reqdata11, index) in get_reqdata1" style="margin-top:40px">
                                            <div data-repeater-list="" class="col-lg-12">
                                                <slot class="source-item">
                                                    <div data-repeater-list="group-a">
                                                        <div class="repeater-wrapper" data-repeater-item>
                                                            <div class="row">
                                                                <div class="col-12 d-flex product-details-border position-relative pe-0">
                                                                    <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                        <div class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2" style="width: 31%;">
                                                                            <p class="card-text col-title mb-md-50 mb-0">{{index+1}} - Item name</p>
                                                                            <select class="form-select item-details" name="first[]">
                                                                                <option :value='get_reqdata11.itemId'>{{ get_reqdata11.ItemName}}</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-2 col-12 my-lg-0 my-2" style="width: 13%;">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Req. Qty</p>
                                                                            <input name="third[]" readonly :value='get_reqdata11.Quantity' type="number" class="form-control" />
                                                                        </div>
                                                                        <div class="col-lg-1 col-12 mt-lg-0 mt-2" style="width: 13%;">
                                                                            <p class="card-text col-title mb-md-50 mb-0">Unit</p>
                                                                            <input name="second[]" :value='get_reqdata11.unit' readonly class="form-control" />
                                                                        </div>

                                                                        <div class="col-lg-1 col-12 my-lg-0 my-2" style="width: 12%;">
                                                                            <p class="card-text col-title mb-md-2 mb-0">Qty Issuing <span style="color: #DB4437; font-size: 11px;">*</span></p>
                                                                            <input type="number" class="form-control" style="padding-left:0px;padding-right:0px;text-align:center" name="fourth[]" @change="sum_total1()" placeholder="0" />
                                                                        </div>
                                                                        <div class="col-lg-1 col-12 mt-lg-0 mt-2" style="width: 15%;">
                                                                            <p class="card-text col-title mb-md-50 mb-0">Unit Price</p>

                                                                            <input name="fifth[]" readonly class="form-control" :value='Number(get_reqdata11.CostUnit)' />
                                                                        </div>
                                                                        <div class="col-lg-1 col-12 my-lg-0 my-2" style="margin-left: 2px; width: 15%;">
                                                                            <p class="card-text col-title mb-md-2 mb-0">SubTotal </p>
                                                                            <p style="margin-top: 30px;border-radius: 2px;padding-left: 10px;max-width: 100px;height: 35px;" :id="'demo_'+(index)" class="form-control card-text col-title mb-md-50 mb-0">{{get_reqdata11.Total}}</p>
                                                                        </div>
                                                                        <div v-if="get_reqdata11.PStatus==0" class="col-lg-10 col-12 mt-lg-0 mt-2">
                                                                            <p class="card-text mt-3">
                                                                                Proceed To PR      <input class="form-check-input " type="checkbox" name="six[]" id="inlineRadio1" style=" margin-left: 5px;" />
                                                                            </p>
                                                                        </div>
                                                                        <div v-else class="col-lg-10 col-12 mt-lg-0 mt-2" style="text-align: right;display:none;">
                                                                            <p class="card-text mt-3">
                                                                                Proceed To PR      <input class="form-check-input " type="checkbox" name="six[]" id="inlineRadio1" style=" margin-left: 5px;" />
                                                                            </p>
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
                                            <div class="col-md-12 order-md-1 order-2 mt-md-0 mt-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="note" class="form-label fw-bold">Narration:</label>
                                                            <textarea v-model="narration" class="form-control" rows="2" id="note"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
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
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Post Issuance</button>

                                    </div>
                                </div>
                                <div v-if="reqItemdetail.length > 0">
                                    <h6 class="mb-5" style="font-weight:bold">Inventory Stock:</h6>
                                    <table class="table table-bordered table-hover" style="overflow-x: initial !important;">
                                        <thead>
                                            <tr>
                                                <th class="sticky-th-center">Sr.#</th>
                                                <th class="sticky-th-center">Item Name</th>
                                                <th class="sticky-th-center">In stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(reqItemdetail1, index) in reqItemdetail">
                                                <td class="td-center">{{ index+1 }}</td>
                                                <td class="td-left">{{ reqItemdetail1.Name }}</td>
                                                <td class="td-right"><strong>{{ reqItemdetail1.Remaining }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="itemIss.length > 0">
                                    <h6 class="mb-3" style="font-weight:bold">Issuance Details:</h6>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="table-warning">
                                                <th class="sticky-th-center">Sr.#</th>
                                                <th class="sticky-th-center">Item Name</th>
                                                <th class="sticky-th-center">Issued</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(itemIss1, index)  in itemIss" class="table-warning">
                                                <td class="td-center">{{ index+1 }}</td>
                                                <td class="td-left">{{ itemIss1.ItemName }}</td>
                                                <td class="td-right"><strong>{{ itemIss1.Issuedquantity }}</strong></td>
                                            </tr>
                                        </tbody>
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

    import Multiselect from 'vue-multiselect';
    export default {
        data() {
            return {
                get_reqn: {},

                companydetail: {},
                disabled: false,
                timeout: null,

                date: new Date().toJSON().slice(0, 10),
                dept_name: '',
                project: '',
                req_id: '',
                narration: '',
                status: 1,
                req: '',
                e_req: '',
                options: [],
                get_reqdata1: {},
                est_value: '',
                total_value: '',
                reqItemdetail: {},
                itemIss: {},
                subtotal: 0,
                total: 0
            }
        },

        components: { Multiselect },
        methods: {
            intervalFetchData: function () {
                setInterval(() => {
                    this.total = Number(this.subtotal)
                }, 1000);
            },
            create_issuance() {
                if (this.req == '' || this.req == null) {
                    this.e_req = 'Select demand requisition';
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    var item_name = document.getElementsByName('first[]');
                    var unit = document.getElementsByName('second[]');
                    var est_cost = document.getElementsByName('third[]');
                    var qty = document.getElementsByName('fourth[]');
                    var added = document.getElementsByName('six[]');
                    var Uprice = document.getElementsByName('fifth[]');
                    var k = 'zero';
                    var l = 'zero';
                    var m = 0;
                    var n = 0;
                    var p = 0;
                    var addpurchase = 'zero';
                    for (var i = 0; i < item_name.length; i++) {
                        var a = item_name[i];
                        k = k + "|" + a.value;
                    }
                    for (var j = 0; j < unit.length; j++) {
                        var b = unit[j];
                        l = l + "|" + b.value;
                    }
                    for (var g = 0; g < est_cost.length; g++) {
                        var c = est_cost[g];
                        m = m + "|" + c.value;
                    }
                    for (var q = 0; q < Uprice.length; q++) {
                        var g = Uprice[q];
                        p = p + "|" + g.value;
                    }
                    for (var h = 0; h < qty.length; h++) {
                        var d = qty[h];
                        if (d.value == '') {
                            d.value = 0;
                        }
                        n = n + "|" + d.value;
                    }
                    for (var q = 0; q < added.length; q++) {
                        var fnn = added[q];
                        addpurchase = addpurchase + "|" + fnn.checked;
                    }
                    axios.post('./accounts/insert_issuance', {
                        item_name: k,
                        unit: l,
                        est_cost: m,
                        qty: n,
                        check_purchase: addpurchase,
                        date: this.date,
                        dept_name: this.dept_name,
                        project: this.project,
                        narration: this.narration,
                        req_id: this.req_id,
                        status: this.status,
                        UnitPrice: p,
                        Total: this.total,
                    }).then(data => {
                            if (data.data == "submitted") {
                                this.$toastr.s("New Issuance added Successfully", "Congratulations!");
                                this.$router.push({ name: 'issuance_detail' })
                            }
                            else {
                                this.$toastr.e(data.data, "Cautions!");
                            }
                        }).catch(error => {
                           if(error.response.data.message=='Issuance Already Exists.'){
                            this.$toastr.e(error.response.data.message, "Error!");
                           }
                           });
                }
            },
            get_req_items() {
                axios.get('accounts/get_re_iss/' + this.req)
                    .then(response => {
                        this.dept_name = response.data[0].DepartmentName;
                        this.project = response.data[0].ProjectName;
                        this.req_id = response.data[0].RequisitionId;
                    })
                axios.get('accounts/get_req_iss/' + this.req)
                    .then(response => {
                        this.get_reqdata1 = response.data;
                    })
            },
            sum_total() {
                var fourth = document.getElementsByName('fourth[]');
                var m = 0;
                for (var g = 0; g < fourth.length; g++) {
                    var c = fourth[g];
                    m = Number(m) + Number(c.value);
                }
            },
            sum_total1() {

                var third = document.getElementsByName('fifth[]');
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
            get_req_items() {
                axios.get('accounts/Get_req_Details/' + this.req.id)
                    .then(response => {
                        this.reqItemdetail = response.data;
                    })
                axios.get('accounts/get_itemIssDetail/' + this.req.id)
                    .then(response => {
                        this.itemIss = response.data;
                    })

                axios.get('accounts/get_re_iss/' + this.req.id)
                    .then(response => {
                        this.dept_name = response.data[0].DepartmentName;
                        this.project = response.data[0].ProjectName;
                        this.req_id = response.data[0].RequisitionId;
                    })
                axios.get('accounts/get_req_iss/' + this.req.id)
                    .then(response => {
                        this.get_reqdata1 = response.data;
                    })
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
                }, 1000)
                this.create_issuance()
            },
        },
        mounted() {
            this.intervalFetchData();

            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)

            axios.get('accounts_get_reqns1')
                .then(response => {
                    this.get_reqn = response.data;

                    this.options = [];
                    this.options = this.get_reqn.map((pr) => ({
                        id: pr.RequisitionId,
                        label: `${pr.RId}` + '-' + `${pr.DepartmentName}` + '- ' + `${pr.ProjectName}`,
                    }));
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
