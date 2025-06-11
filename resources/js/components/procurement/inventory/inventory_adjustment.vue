<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Stock Adjustment
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" style="" placeholder="Search By Item Name" />
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr style="position: sticky; top: 95px;">
                                            <th class="text-center">Item Code</th>
                                            <th>Item Name</th>
                                            <th>Item Category</th>
                                            <th class="text-center">Availabe Qty</th>
                                            <th class="text-center">Avg Value</th>
                                            <th class="text-center">Face Value</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata">
                                            <td class="text-center">{{adsdata1.ItemCode}}</td>
                                            <td>{{adsdata1.Name}}</td>
                                            <td>{{adsdata1.CategoryName}}</td>
                                            <td class="text-center">{{adsdata1.Qty}}</td>
                                            <td class="text-center">{{adsdata1.AVG}}</td>
                                            <td class="text-center">{{adsdata1.FaceValue}}</td>
                                            <td class="text-center">
                                                <a @click="fetchStockItem(adsdata1)" data-bs-toggle="modal" data-bs-target="#editstock"><i class="fa-solid fa-pen-to-square"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
                <div class="modal fade" id="editstock" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalToggleLabel">Adjust stock</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- form -->
                                <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                    <form class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                        <div class="col-md-12">
                                            <label class="form-label">Product name</label>
                                            <input type="text" readonly class="form-control" v-model="product_name" />
                                            <input type="text" readonly class="form-control" hidden v-model="product_id" />
                                            <input type="text" readonly class="form-control" hidden v-model="unit" />
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Action</label>
                                            <select v-model="action" class="form-control">
                                                <option value="">Select</option>
                                                <option value="3">Add Quantity</option>
                                                <option value="4">Subtract Quantity</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12" v-if="this.action==3">
                                            <label class="form-label">Enter quantity to add</label>
                                            <input v-model="quantity" type="number" placeholder="Add quantity" class="form-control" />
                                            <span style="color: #db4437; font-size: 11px" v-if="quantity == ''">{{ e_addQuantity }}</span>
                                        </div>
                                        <div class="col-md-12" v-else-if="this.action==4">
                                            <label class="form-label">Enter quantity to subract</label>
                                            <input v-model="quantity" type="number" placeholder="Subtract quantity" class="form-control" />
                                            <span style="color: #db4437; font-size: 11px" v-if="quantity == ''">{{ e_subQuantity }}</span>
                                        </div>
                                        <div class="col-md-12" >
                                            <label class="form-label">Enter Cost Unit</label>
                                            <input v-model="cost_unit" type="number" placeholder="Cost Unit" class="form-control" />
                                       </div>
                                        <div class="col-md-12 text-center">
                                            <button v-if="quantity==''" class="btn btn-danger" @click="update_stock()">Update Stock</button>
                                            <button v-else class="btn btn-primary" @click="update_stock()" data-bs-dismiss="modal" aria-label="Close">Update Stock</button>
                                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
</template>
<script>
    export default {
        data() {
            return {
                adsdata: {},
                product_qty: '',
                keyword1: '',
                action: '',
                product_name: '',
                product_id: '',
                quantity: '',
                cost_unit:0,
                unit: '',
                e_addQuantity: '',
                e_subQuantity: '',
            }
        },
        methods: {
            fetchStockItem(index) {
                this.product_id = index.ItemID;
                this.product_qty = index.Qty;
                if(index.FaceValue !=null){
                    this.cost_unit=index.FaceValue
                }
                axios.get('accounts/fetch_item_name/' + this.product_id)
                    .then(response => {
                        this.product_name = response.data[0].Name;
                        this.unit = response.data[0].unit;
                    })
            },
            update_stock() {
                if (this.quantity == '') {
                    this.e_addQuantity = "Enter quantity to Add";
                    this.e_subQuantity = "Enter quantity to subtract";
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    if (this.action == 4 && (this.quantity > this.product_qty)) {
                        this.$toastr.e("You cannot subtruct this quantity!", "Caution!");
                    }
                    else {
                        axios.post("accounts/submit_stock_adj", {
                            type: this.action,
                            product_name: this.product_name,
                            product_id: this.product_id,
                            quantity: this.quantity,
                            unit: this.unit,
                            cost_unit:this.cost_unit
                        })
                            .then((data) => {
                                this.getResult();
                                this.e_addQuantity = "";
                                this.e_subQuantity = "";
                                this.$toastr.s("Stock Updated Successfully!", "Congratulations!");
                            })
                    }
                }
            },
            getResult() {
                axios.get('accounts/stock_detail')
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
            getResults() {
                axios.get('./search_item', { params: { keyword1: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => console.log(error));
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        mounted() {
            this.getResult();
        }
    }
</script>
