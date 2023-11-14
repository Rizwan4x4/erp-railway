<template>
    <div >
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
                                <router-link to="/purchase/requistion_detail" style="text-decoration: none;">Requisition Detail(s)</router-link>
                            </li>

                            <li class="breadcrumb-item active">
                                Merge Requistion
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
                                                    <span class="title">Date:<span style="color: #DB4437; font-size: 11px;">*</span></span>
                                                    <input readonly type="date" v-model="date" class="form-control invoice-edit-input " />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{e_date}}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                    <div class="divider">
                                        <div class="divider-text" style="font-size: 24px;font-weight: 900;">Merge Purchase Requistion</div>
                                    </div>
                                    <!-- Address and Contact starts -->
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                         <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Primary Purchase Requisition:</h6>
                                                <div class="invoice-customer">

                                                    <multiselect style="margin-right: 10px;"
                                                     v-model="primary_pr" :options="options_pr" @input="change_pr()">
                                                   </multiselect>
                                                 <span style="color: #DB4437; font-size: 11px;" v-if="primary_pr==''">{{e_primary_pr}}</span>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Project Name:</h6>
                                                <div class="invoice-customer">
                                                 <input class="form-control" type="text" readonly v-model="project_name" style="" />

                                                    <!-- <input type="text" v-model="project_name" hidden /> -->
                                                 <span style="color: #DB4437; font-size: 11px;" v-if="project_name==''">{{e_project_name}}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Department/Company Name:</h6>
                                                <div class="invoice-customer">
                                                    <input class="form-control" type="text" readonly v-model="dept_name" style="" />
                                                    <span style="color: #DB4437; font-size: 11px;" v-if="dept_name==''">{{e_dept_name}}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body invoice-padding invoice-product-details">

<div class="source-item" v-for="(get_po_detail11, index) in get_po_detail1" >
    <div data-repeater-list="group-a">
        <div class="repeater-wrapper" data-repeater-item>
            <div class="row">
                <div class="col-12 d-flex product-details-border position-relative pe-0">
                    <div class="row w-100 pe-lg-0 pe-1 py-2">
                        <div class="col-lg-4 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                            <p class="card-text col-title mb-md-50 mb-0">Item</p>
                            <select v-if="get_po_detail11.ItemName!=null" class="form-select item-details" disabled name="first[]">
                                <option :value='get_po_detail11.itemId'>{{get_po_detail11.ItemName}}</option>
                            </select>
                            <input hidden v-else type="text" name="first[]" value="empty">
                                                <input hidden type="text" name="second[]" value="empty">
                                                <input hidden type="number" class="form-control" name="third[]" value="1"  />
                        </div>

                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Quantity</p>
                            <input  :value='get_po_detail11.Quantity' type="number" readonly class="form-control"  name="fourth[]"/>
                        </div>
                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Est. Cost</p>
                            <textarea  readonly style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;" class="form-control mt-2" rows="1" >{{get_po_detail11.EstCost}}</textarea>


                        </div>
                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Unit</p>
                            <input  :value='get_po_detail11.unit' type="text" readonly class="form-control"  />


                        </div>
                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Details</p>

                            <textarea class="form-control" rows="1" readonly placeholder="Item Detail" name="fiveth[]">{{get_po_detail11.Detail}}</textarea>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
                                    <br>
                                    <div class="card-body invoice-padding pt-0">
                                        <div class="row row-bill-to invoice-spacing" >
                                         <div class="col-xl-12 mb-lg-1 col-bill-to ps-0">
                                                <h6 class="invoice-to-title" style="margin-bottom:5px">Secondary Purchase Requisition:</h6>
                                                <div class="invoice-customer">

                                                    <multiselect
                                                     v-model="secondary_pr" :options="options_pr1" :multiple="true" @input="change_secondary()">
                                                   </multiselect>
                                                 <span style="color: #DB4437; font-size: 11px;" v-if="secondary_pr==''">{{e_secondary_pr}}</span>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <!-- Address and Contact ends -->
                                    <!-- Product Details starts -->
                                        <div class="card-body invoice-padding invoice-product-details">

<div class="source-item" v-for="(get_po_detail11, index) in get_po_detail2" >
    <div data-repeater-list="group-a">
        <div class="repeater-wrapper" data-repeater-item>
            <div class="row">
                <div class="col-12 d-flex product-details-border position-relative pe-0">
                    <div class="row w-100 pe-lg-0 pe-1 py-2">
                        <div class="col-lg-4 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                            <p class="card-text col-title mb-md-50 mb-0">Item</p>
                            <select v-if="get_po_detail11.ItemName!=null" class="form-select item-details"  name="first[]">
                                <option :value='get_po_detail11.itemId'>{{get_po_detail11.ItemName}}</option>
                            </select>
                            <input hidden v-else type="text" name="first[]" value="empty">
                                                <input hidden type="text" name="second[]" value="empty">
                                                <input hidden type="number" class="form-control" name="third[]" value="1"  />
                        </div>

                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Quantity</p>
                            <input  :value='get_po_detail11.Quantity' name="fourth[]" type="number" readonly class="form-control"  />
                        </div>
                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Est. Cost</p>
                            <textarea  readonly style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;" class="form-control mt-2" rows="1" >{{get_po_detail11.EstCost}}</textarea>


                        </div>
                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Unit</p>
                            <input  :value='get_po_detail11.unit' type="text" readonly class="form-control"  />


                        </div>
                        <div class="col-lg-2 col-12 my-lg-0 my-2">
                            <p class="card-text col-title mb-md-2 mb-0">Details</p>

                            <textarea class="form-control" rows="1" readonly placeholder="Item Detail" name="fiveth[]">{{get_po_detail11.Detail}}</textarea>

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
                                            <div class="col-md-8 order-md-1 order-2 mt-md-0 mt-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-2">
                                                            <label for="note" class="form-label fw-bold">Narration:</label>
                                                            <textarea v-model="narration" class="form-control" rows="4" id="note"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex justify-content-end order-md-2 order-1">

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
                                        <button :disabled="disabled" @click="delay()" class="btn btn-primary w-100 mb-75">Post </button>
                                        <a href="#" class="btn btn-outline-primary w-100 mb-75"> Post & Preview</a>

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
        data() {
            return {
                counter: 1,
                companydetail: {},
                date: new Date().toJSON().slice(0, 10),
                dept_name: '',
                project_name:'',
                narration:"",
                status:'Goods',
                e_date: '',
                e_project_name: '',
                e_dept_name: '',
                sec_pr:'',
                primary_pr:'',
                e_primary_pr:'',
                secondary_pr:'',
                e_secondary_pr:'',
                merge_status:"Approved",
                disabled: false,
                timeout: null,
project_id:'',



get_po_detail1: {},
get_po_detail2: {},
                get_unit:{},
                get_dept:{},
                get_project:{},
                get_items:{},
                total_value:'',
                est_value:'',
                item_unit:'',
                item_coded:'',
                options_pr:[],
                options_pr1:[],
                sec_req_list:{},
                fetch_arry:{},
            }
        },
        components: { Multiselect },
        methods: {


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
        change_secondary(){

            var q = 'zero';
            var g=this.primary_pr.split("__")[0]
            var t = 'with';
            for(let y=0;y<this.secondary_pr.length;y++){
                let z=this.secondary_pr[y].split("__")
                q = q + "|" + z[0];
               g=g+"|"+z[0]

            };
          this.sec_pr=g;
            let r=q.split("|");
            r.shift();
            for(let yz=0;yz<r.length;yz++){
                t = t + " | " + r[yz];

            };
            this.narration=`Merging Purchase Requisition ${this.primary_pr.split("__")[0]} ${t}`

            axios.get('accounts/get_requisition_multipleitems',{ params: { id: q } })
                    .then(response => {
                        this.get_po_detail2 = response.data;
                    })

        },
        change_pr(){
       let x=this.primary_pr.split("__");

      this.project_name=x[1]
      this.dept_name=x[2]

      axios.get('accounts/get_requisition_items/' + x[0])
                    .then(response => {
                        this.get_po_detail1 = response.data;
                    })
                    axios.get('accounts/get_allrequisition1/'+x[0])
                .then(response => {
                    this.sec_req_list = response.data
                    this.options_pr1 = [];

var $this = this;
for (var i = 0; i < $this.sec_req_list.length; i++) {
    this.options_pr1.push($this.sec_req_list[i].RId + '__' + $this.sec_req_list[i].ProjectName+"__"+ $this.sec_req_list[i].DepartmentName);
}
                })
        },
            create_pr() {
                if (this.date == '' || this.dept_name == '' || this.project_name=='') {

                    if (this.date == '') {
                        this.e_date = "Please Select Date";
                    }

                    if (this.dept_name == '') {
                        this.e_dept_name = "Error";
                    }
                   if (this.project_name == '') {
                        this.e_project_name = "Error";
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {

var item_name = document.getElementsByName('first[]');
var unit = document.getElementsByName('second[]');
var est_cost = document.getElementsByName('third[]');
var qty = document.getElementsByName('fourth[]');

var detail = document.getElementsByName('fiveth[]');


var k = 'zero';
var l = 'zero';
var m = 0;
var n = 0;

var o = 'zero';

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

for (var h = 0; h < qty.length; h++) {
var d = qty[h];
n = n + "|" + d.value;
}

for (var f = 0; f < detail.length; f++) {
var fn = detail[f];
o = o + "|" + fn.value;
}

axios.post('./accounts/insert_mergerequisition', {
item_name: k,
unit: l,
est_cost: m,
qty: n,
detail:o,
date: this.date,
dept_name: this.dept_name,
project_name: this.project_name,
narration: this.narration,
status:this.merge_status,
primary_pr:this.primary_pr.split("__")[0],
secondary_pr:this.sec_pr
})
.then(data => {

    if(data.data=="submitted"){
    this.$toastr.s("Purchase requisition added Successfully", "Congratulations!");
        this.$router.push({ name: 'requistion_detail'})
    }
    else if (data.data == "Empty field") {
        this.$toastr.e("Some fields are empty or not fill properly", "Error!");
    }
    else{
        this.$toastr.e(data.data, "Caution!");
    }
})

                }
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
                this.create_pr()
            },
            get_projectlist(){
            axios.get('accounts/get_projects99/'+this.project_id)
                .then(response => this.project_name = response.data[0].ProjectName)
             axios.get('accounts/get_departmentcoa/'+this.project_id)
                .then(response => this.get_dept = response.data)
            },
            find_services(){

            if(this.status=='Goods'){

             axios.get('accounts/get_items/'+this.status)
                .then(response => this.get_items = response.data)
            }
            else if(this.status=='Assets')
            {

             axios.get('accounts/get_itemsassets/'+this.status)
                .then(response => this.get_items = response.data)
            }


            }
        },
        mounted() {

             axios.get('accounts/get_allrequisition')
                .then(response => {
                    this.get_project = response.data
                    this.options_pr = [];

var $this = this;
for (var i = 0; i < $this.get_project.length; i++) {
    this.options_pr.push($this.get_project[i].RId + '__' + $this.get_project[i].ProjectName+"__"+ $this.get_project[i].DepartmentName);
}
                })

            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)


          axios.get('accounts/get_items/'+this.status)
                .then(response => this.get_items = response.data)

            axios.get('accounts/get_units')
                .then(response => this.get_unit = response.data)
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
