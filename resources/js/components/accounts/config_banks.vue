<template>
<div>
<!-- BEGIN: Content-->
<div class="app-content content">
<div class="content-overlay"></div>
<div class="header-navbar-shadow-tem-change"></div>
<div class="content-wrapper container-xxl p-0">
<div class="content-header row">
<div class="breadcrumb-wrapper">
<ol class="breadcrumb">
<li class="breadcrumb-item">
<router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
</li>
<li class="breadcrumb-item active">Banks Detail</li>
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
      <h4 class="card-title">Banks Detail</h4>
      <div style="text-align: right; width: 30% !important">
          <a v-if="hasPermission('Accounts Configurations  create-bank')" style="float: left" data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect" type="button">Create New</a>
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
                                                  <th>Account Name</th>
                                                  <th>Account Number</th>
                                                  <th>Bank Name</th>
                                                  <th>Branch Name</th>
                                                  <th>Account Type</th>
                                                  <th>AccountID</th>
                                                  <th>AccountName</th>
                                                  <th>Status</th>
                                                  <th></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr class="odd" v-for="adsdata1 in adsdata.data">
                                                  <td><span class="badge  rounded-pill badge-light-primary">{{adsdata1.AccountTitle}}</span></td>
                                                  <td>{{adsdata1.AccountNumber}}</td>
                                                  <td>{{adsdata1.BankName}}</td>
                                                  <td>{{adsdata1.BankBranch}}</td>
                                                  <td>{{adsdata1.AccountType}}</td>
                                                  <td>{{adsdata1.AccountID}}</td>
                                                  <td>{{adsdata1.AccountName}}</td>
                                                  <td>{{adsdata1.Status}}</td>
                                                  <td>
                                                      <div class="btn-group">
                                                          <a v-if="hasPermission('Accounts Configurations  bank-details actions')" class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                              <i class="fa-solid fa-ellipsis-vertical"></i>
                                                          </a>
                                                          <div class="dropdown-menu dropdown-menu-end">
                                                              <a v-if="adsdata1.Status=='true'" @click="changeStatus(adsdata1.BankID, '0')" class="dropdown-item">
                                                                  <i class="fa-brands fa-creative-commons-sa"></i>
                                                                  Disable
                                                              </a>
                                                              <a v-else @click="changeStatus(adsdata1.BankID, 'true')" class="dropdown-item">
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
Create New Bank
</h3>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-sm-5 mx-50 pb-5">
<form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Bank Name</label>
<input type="text" v-model="bank_name" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="bank_name == ''">{{ bank_name_error }}</span>
</div>
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Account Type</label>
<select class="form-select" v-model="bank_type">
  <option value="">Select Bank Type</option>
  <option value="Current">Current</option>
  <option value="Saving">Saving</option>
</select>
<span style="color: #db4437; font-size: 11px" v-if="bank_type == ''">{{ bank_type_error }}</span>
</div>
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Bank Branch</label>
<input type="text" placeholder="" v-model="bank_branch" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="bank_branch== ''">{{ bank_branch_error }}</span>
</div>
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Account Title</label>
<input type="text" placeholder="" v-model="account_name" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="account_name== ''">{{ account_name_error }}</span>
</div>
<div class="col-md-6 col-12">
<label class="form-label" for="modalAddCardName">Account Number</label>
<input type="text" v-model="account_number" placeholder="" class="form-control" style="" />
<span style="color: #db4437; font-size: 11px" v-if="account_number== ''">{{ account_number_error }}</span>

<div  class="invoice-customer">
                                <label class="form-label" for="modalAddCardName">Select Link Account</label>
                                <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction" :show-labels="false" v-model="p_account_idname" :options="options2">
                                </multiselect>
                                </div>

                                <span style="color: #db4437; font-size: 11px" v-if="p_account_idname== ''">{{ p_account_idname_error }}</span>
</div>

<div class="col-md-6 col-12">
<label style="width: 100%">Active</label>
<div style="margin-bottom: 10px; margin-top: 5px" class="form-check form-check-info form-switch">
  <input style="width: 50px" type="checkbox" v-model="bank_status" class="form-check-input" id="customSwitch3" />
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
import Multiselect from 'vue-multiselect'
export default {
data() {
return {
p_account_idname:'',
p_account_idname_error:'',
keyword1: '',
disabled: false,
timeout: null,
bank_name: "",
bank_type: "",
account_name: "",
account_number: "",
bank_status: "true",
bank_branch: '',
bank_branch_error: '',

bank_name_error: "",
bank_type_error: "",
account_name_error: "",
account_number_error: "",
options2:[],
adsdata: {},
agnstpayment:{},
};
},
 components: {
        Multiselect,
    },
watch: {
keyword1(after, before) {
this.search_by_name();
}
},
methods: {
search_by_name(page = 1) {
axios.get('./accounts/filter_bank/?page=' + page, { params: { name: this.keyword1 } })
.then(data => this.adsdata = data.data)
.catch(error => {});
},
changeStatus(id, sts) {
axios.post('./accounts/accounts_update_bank_status', {
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
this.submit_bank();
},

submit_bank() {

if (this.bank_name == "" || this.bank_type == '' || this.account_name == '' || this.account_number == '' || this.bank_branch == ''||this.p_account_idname=='') {
this.$toastr.e("Please fill required fields!", "Caution!");
if (this.bank_name == "") {
this.bank_name_error = "Please select Bank Name";
}
if (this.account_name == '') {
this.account_name_error = "Please select Account Name";
}
if (this.account_number == '') {
this.account_number_error = "Please select Account Number";
}
if (this.bank_type == '') {
this.bank_type_error = "Please select Bank Type";
}
if (this.bank_branch == '') {
this.bank_branch_error = "Please select Bank Branch";
}
if(this.p_account_idname==''){
  this.p_account_idname_error = "Please select COA";
}
} else {

axios.post('./accounts/submit_bank', {
bank_name: this.bank_name,
bank_type: this.bank_type,
bank_branch: this.bank_branch,
account_name: this.account_name,
account_number: this.account_number,
bank_status: this.bank_status,
p_account_idname:this.p_account_idname,
})
.then(data => {
this.adsdata = data.data;
this.$toastr.s("New Bank Added Successfully", "Congratulations!");

this.bank_name = "";
this.bank_type = "";
this.bank_branch = "";
this.account_name = "";
this.account_number = "";
})
}





},




getResult(page = 1) {
axios
.get("accounts/bank_detail/?page=" + page)
.then((response) => (this.adsdata = response.data))
.catch((error) => {});
},
},

mounted() {
this.getResult();
axios.get('accounts/fetch_bank_methods')
            .then(response => {
                this.agnstpayment = response.data
                this.options2 = [];

                var $this = this;
                for (var i = 0; i < $this.agnstpayment.length; i++) {
                    this.options2.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
                }
            })
},
};

</script>
