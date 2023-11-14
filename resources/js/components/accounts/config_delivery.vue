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
<li class="breadcrumb-item active">Delivery Detail</li>
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
<h4 class="card-title">Delivery Detail</h4>
<div style="text-align: right; width: 30% !important">
<a v-if="hasPermission( 'Accounting procurement-configuration create-Delivery') "  style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect" type="button">Create New</a>
<div class="" style="float: right">
    <div style="">
        <label>
            <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" @change="search_by_name()" class="form-control" style="" placeholder="Search By Name" />
        </label>
    </div>
</div>
</div>
</div>
<div class="card-body">
<div style="margin-bottom: 20px" class="
d-flex
justify-content-between
align-items-center
header-actions
mx-2
row
mt-75
">
<section id="accordion-with-border">
    <div class="row">
        <div class="col-sm-12">
            <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: initial !important">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Delivery Name</th>
                                        <th>Delivery Type</th>
                                        <th>Delivery Compute</th>
                                        <th>Value</th>
                                        <th>Status</th>
                                         <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="adsdata1 in adsdata.data">
                                        <td><span class="badge  rounded-pill badge-light-primary">{{adsdata1.DeliveryName}}</span></td>
                                        <td>{{adsdata1.DType}}</td>
                                        <td>{{adsdata1.DComputation}}</td>
                                        <td v-if="adsdata1.DComputation=='Percentage'">{{adsdata1.DAmount}}%</td>
                                        <td v-else> Rs.{{adsdata1.DAmount}}</td>
                                        <td>
                                            <span v-if="adsdata1.Status=='true'" class="badge badge-glow bg-primary">Active</span>
                                            <span v-else class="badge badge-glow bg-secondary">Disabled</span>
                                        </td>
                                        <td>
                                         <div class="btn-group">
                                                    <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                      <div class="dropdown-menu dropdown-menu-end">

                                          <a v-if="adsdata1.Status=='true'" @click="changeStatus(adsdata1.DID, '0')" class="dropdown-item">
                                              <i class="fa-brands fa-creative-commons-sa"></i>
                                              Disable
                                          </a>
                                          <a v-else @click="changeStatus(adsdata1.DID, 'true')" class="dropdown-item">
                                              <i class="fa-brands fa-creative-commons-sa"></i>
                                              Active
                                          </a>
                                      </div>
                                                </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="
text-align: center;
padding-top: 20px;
">
                            <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
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
<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-transparent">
<h3 class="text-center mb-1" id="addNewCardTitle">
Create Delivery Head
</h3>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-sm-5 mx-50 pb-5">
<form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Delivery Name</label>
<input type="text" v-model="tax_name" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="tax_name == ''">{{ tax_name_error }}</span>
</div>
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Delivery Type</label>
<select class="form-select" v-model="tax_type">
<option value="Sales">Sales</option>
<option value="Purchase">Purchase</option>
</select>
<span style="color: #db4437; font-size: 11px" v-if="tax_type == ''">{{ tax_type_error }}</span>
</div>
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Delivery Computation</label>
<select class="form-select" v-model="tax_computation">
<option value="Fixed">Fixed</option>
<option value="Percentage">Percentage of Price</option>
</select>
<span style="color: #db4437; font-size: 11px" v-if="tax_computation == ''">{{ tax_computation_error }}</span>
</div>
<div class="col-md-6 col-12" v-if="this.tax_computation == 'Fixed'">
<label class="form-label" for="modalAddCardName">Amount</label>
<input type="number" placeholder="Type Fixed Value of Delivery" v-model="tax_amount" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="Amount_error != ''">{{ Amount_error }}</span>
</div>
<div class="col-md-6 col-12" v-if="this.tax_computation == 'Percentage'">
<label class="form-label" for="modalAddCardName">Amount</label>
<input type="number" v-model="tax_amount" placeholder="Type Percentage Value of Delivery" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="Amount_error != ''">{{ Amount_error }}</span>
</div>
<div class="col-md-6 col-12">
<label style="width: 100%">Active</label>
<div style="margin-bottom: 10px; margin-top: 5px" class="form-check form-check-info form-switch">
<input style="width: 50px" type="checkbox" v-model="tax_status" class="form-check-input" id="customSwitch3" />
</div>
</div>
<div class="col-12 text-center">
<button type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1">
Submit
</button>
<button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
Cancel
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</template>
<script>
export default {
data() {
return {
 keyword1: '',
              disabled: false,
                timeout: null,

tax_name: "",
tax_type: "Sales",
tax_computation: "Fixed",
tax_amount: 0,
tax_status: "true",


tax_name_error: "",
tax_type_error: "",
tax_computation_error: "",
Amount_error: "",

adsdata: {},
};
},
 watch: {
            keyword1(after, before) {
                this.search_by_name();
            }
        },
methods: {
search_by_name(page = 1) {
                axios.get('./accounts/filter_delivery?page=' + page, { params: { name: this.keyword1 } })
                    .then(data => this.adsdata = data.data)
                    .catch(error => { });
            },
changeStatus(id, sts) {
                axios.post('./accounts/accounts_update_delivery_status', {
                    id: id,
                    status: sts,
                })
                    .then(data => {
                        if (data.data == 'Status updated!') {
                            this.$toastr.s("Status updated Successfully!", "Congratulations!");
                            this.getResult();
                        }
                    })
                    .catch(error => this.error = error.responce.data.errors)
            },
 delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.submit_taxes();
            },

submit_taxes(){

  if(this.tax_name== ""|| this.tax_amount==0){
   this.$toastr.e("Please fill required fields!", "Caution!");
   if(this.tax_name==""){
  this.tax_name_error = "Please select Tax Name";
   }
   if(this.tax_amount==0){
   this.Amount_error = "Please select Amount";
   }

  }
  else if(this.tax_computation=='Percentage' && this.tax_amount>100){
this.Amount_error = "Please Add Percentage less than 100";
   }
  else {

                  axios.post('./accounts/submit_delivery', {
                        tax_name: this.tax_name,
                        tax_type: this.tax_type,
                        tax_computation: this.tax_computation,
                        tax_amount: this.tax_amount,
                        tax_status: this.tax_status,
                    })
                    .then(data => {
                     if(data.data=="Tax added successfully"){
                          this.getResult();
                           this.$toastr.s("New Delivery Type Added Successfully", "Congratulations!");
                           this.getResult();
                             this.tax_name="";
                        this.tax_type= "Sales";
                        this.tax_computation="Fixed"
                       this.tax_amount=0
                       this.tax_status="true"
                    }else{
                        this.$toastr.e("Delivery already exists!", "Caution!");
                    }

                        })
  }
},




getResult(page = 1) {
axios
.get("accounts/delivery_detail?page=" + page)
.then((response) => (this.adsdata = response.data))
.catch((error) => {});
},
},

mounted() {
this.getResult();
},
};

</script>
