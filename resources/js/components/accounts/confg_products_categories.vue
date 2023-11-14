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
<li class="breadcrumb-item active">Product Categories</li>
</ol>
</div>
</div>
<div class="content-body">
<section class="app-user-view-account">
<div class="row">
<!-- User Sidebar -->
<div  v-if="hasPermission('Inventory Product-Categories create-category') " class="col-xl-5 col-lg-5 col-md-5 order-1 col-12 order-md-0">
<!-- User Card -->
<div  class="card">
<div class="card-header">
<h4 class="card-title">Add Category</h4>
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
                        <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Category Name</label>
                                <input autocomplete="off" v-model="cateogory_name" class="form-control" style="" placeholder="Type Category Name Here" />
                                <span style="color: #db4437; font-size: 11px" v-if="cateogory_name == ''">{{ category_name_error }}</span>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Category Code</label>
                                <input autocomplete="off" v-model="shortcode" class="form-control" style="" placeholder="Type Short Code Here i.e AE" />
                                <span style="color: #db4437; font-size: 11px" v-if="shortcode == ''">{{ shortcode_error }}</span>
                            </div>
                            <div class="col-12">
                                    <label class="form-label" for="modalAddCardName">Opening Date</label>
                                    <input autocomplete="off" type="date" v-model="opening_date" class="form-control" style="" placeholder="Opening Date Here" />
                                    <span style="color: #db4437; font-size: 11px" v-if="opening_date == ''">{{ e_opening_date }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="modalAddCardName">Closing Date</label>
                                    <input autocomplete="off" type="month" v-model="closing_date" class="form-control" style="" placeholder="Closing Date Here" />
                                    <span style="color: #db4437; font-size: 11px" v-if="closing_date == ''">{{ e_closing_date }}</span>
                                </div>
                            <div class="col-12">
                                <label class="form-label" for="modalAddCardName">Description</label>
                                <textarea class="form-control" v-model="Description" placeholder="Type Product Description Here"></textarea>
                                <span style="color: #db4437; font-size: 11px" v-if="Description == ''">{{ Description_error }}</span>
                            </div>
                            <div class="col-12">
                            <div class="mb-1">
    <label class="form-label" for="basicSelect">Category Type</label>
    <label style="color: #d93025">*</label>
    <div class="demo-inline-spacing">
        <div class="form-check form-check-inline" style="margin-top:0px">
            <input class="form-check-input" type="radio" v-model="c_type" name="inlineRadioOptions" id="inlineRadio1" value="Goods" >
            <label class="form-check-label" for="inlineRadio1">Goods</label>
        </div>
        <div class="form-check form-check-inline" style="margin-top:0px">
            <input class="form-check-input" type="radio" v-model="c_type" name="inlineRadioOptions" id="inlineRadio2" value="Assets">
            <label class="form-check-label" for="inlineRadio2">Assets</label>
        </div>
    </div>
</div>
                            </div>
                            <div>
                                <label style="width: 100%">Status</label>
                                <div style="margin-bottom: 10px" class="form-check form-check-info form-switch
">
                                    <input style="width: 50px" type="checkbox" v-model="category_status" class="form-check-input" id="customSwitch3" />
                                </div>
                            </div>
                            <div  class="col-12 text-center">
                                <button  type="submit" :disabled="disabled" @click="delay()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">
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
</section>
</div>
</div>
</div>
<!-- /User Card -->
</div>
<!--/ User Sidebar -->
<div class="col-xl-7 col-lg-7 col-md-7 order-1 col-12 order-md-0">
<!-- User Card -->
<div class="card">
<div class="card-header">
<h4 class="card-title">Categories Detail</h4>
<div style="text-align: right">
<div class="" style="float: right">
    <div style="">
        <label>
           <input autocomplete="off" id="name" type="text" name="name" v-model="name" class="form-control" @change="getByName()" placeholder="Search By Name" />
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
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="adsdata1 in adsdata.data">
                                        <td>{{adsdata1.CategoryName}}</td>
                                        <td>{{adsdata1.ShortCode}}</td>
                                        <td>{{adsdata1.CategoryType}}</td>
                                        <td>
                                           {{adsdata1.Description}}
                                        </td>
                                        <td>
                                             <span v-if="adsdata1.Status=='true'" class="badge badge-glow bg-primary">Active</span>
                                               <span v-else class="badge badge-glow bg-secondary">Disabled</span>
                                        </td>
                                        <td>
                                            <div class="dropdown chart-dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
                                                  feather feather-more-vertical
                                                  font-medium-3
                                                  cursor-pointer
                                                " data-bs-toggle="dropdown" aria-expanded="false">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="5" r="1"></circle>
                                                    <circle cx="12" cy="19" r="1"></circle>
                                                </svg>
                                                <div class="
                                                dropdown-menu
                                                dropdown-menu-end
                                              " style="">
                                                    <a class="dropdown-item">Edit</a>
                                                    <a class="dropdown-item">Change Status</a>
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
                            <pagination :data="adsdata" @pagination-change-page="getResult3"></pagination>
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
cateogory_name: "",
Description: "",
category_name_error: "",
opening_date:new Date().toJSON().slice(0, 10),
closing_date:'',
Description_error: "",
category_status: "true",
name:'',
c_type:'Goods',
shortcode:'',
shortcode_error:'',
adsdata: {},
}
},

methods: {
delay() {
this.disabled = true
this.timeout = setTimeout(() => {
  this.disabled = false
}, 5000)
this.submit_category()
},
submit_category(){
if(this.cateogory_name==''||this.Description==''||this.shortcode==''){
this.$toastr.e("Please fill required fields!", "Caution!");
if(this.cateogory_name==''){
this.cateogory_name_error = "Please Type Category Name Here";
}
if(this.Description==''){
this.Description_error = "Please Type Description Here";
}
if(this.shortcode==''){
    this.shortcode_error = "Please Type ShortCode Here";
}
}
else {
axios.post("./accounts/submit_category", {
cateogory_name: this.cateogory_name,
Description: this.Description,
c_type:this.c_type,
shortcode:this.shortcode,
category_status:this.category_status,
opeining_date:this.opening_date,
    closing_date:this.closing_date
})
.then((data) => {
                            if (data.data == "Already exist") {
                                this.$toastr.e("Catagory already exist!", "Caution!");
                            }
                            else {
                                this.adsdata = data.data
                                this.cateogory_name = '';
                                this.Description = "";
                                this.$toastr.s("Updated Record Successfully!", "Congratulations!");
                            }
                        })
}
},
getResult3(page = 1) {

  axios.get('accounts/fetch_product_category/?page=' + page)
  .then(response => this.adsdata = response.data)
  .catch(error => { });
},
getByName(page = 1) {
                axios.get('./accounts_catByName/?page=' + page, { params: { name: this.name } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
},
watch: {
            name(after, before) {
                this.getByName();
            }
             },
mounted() {
this.getResult3();
}
}

</script>
<style>
</style>
