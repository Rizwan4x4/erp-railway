<template>
<div>
<div class="app-content content">
<div class="content-overlay"></div>
<div class="header-navbar-shadow-tem-change"></div>
<div class="content-wrapper container-xxl p-0">
<div class="content-header row"></div>
<div class="content-body">
<!-- Basic Tables start -->
<div class="row" id="basic-table">
<div class="col-12">
<div class="card">
<div class="card-header">
<h4 class="card-title">Registered Companies</h4>
<router-link to="/create_company" class="btn btn-primary waves-effect waves-float waves-light">Add New Company</router-link>
</div>
<div class="table-responsive" style="overflow-x: initial !important">
<table class="table">
<thead>
<tr>
<th>Client Name</th>
<th>License Id</th>
<th>Phone Number</th>
<th>Email Id</th>
<th>City</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<tr v-for="adsdata1 in adsdata.data" :key="adsdata1.id">
<td>
<img v-bind:src="`public/images/${adsdata1.company_logo}`" class="me-75" height="20" width="20" alt="Angular" />
<span class="fw-bold">{{
adsdata1.company_name
}}</span>
</td>
<td>{{ adsdata1.license_id }}</td>
<td>{{ adsdata1.phone_number }}</td>
<td>{{ adsdata1.company_email }}</td>
<td>
{{ adsdata1.city }}
</td>
<td>
<span v-if="adsdata1.c_status == 'Active'" class="badge rounded-pill badge-light-primary me-1">{{ adsdata1.c_status }}</span>
<span v-if="adsdata1.c_status == 'Not Active'" class="badge rounded-pill badge-light-danger me-1">{{ adsdata1.c_status }}</span>
</td>
<td style="padding-top: 5px !important">
<div class="d-flex align-items-center col-actions">
<a @click="
savecompany_id(
adsdata1.company_id,
adsdata1.company_name
);
" v-b-modal.modal-lg style="padding-right: 5px"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
feather feather-send
font-medium-2
text-body
">
    <line x1="22" y1="2" x2="11" y2="13"></line>
    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
</svg></a>

<router-link :to="{
name: 'company_detail',
params: { id: adsdata1.company_id },
}" class="me-25">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
feather feather-eye
font-medium-2
text-body
">
    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
    <circle cx="12" cy="12" r="3"></circle>
</svg>
</router-link>
<div class="dropdown">
<a class="
btn btn-sm btn-icon
dropdown-toggle
hide-arrow
" data-bs-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
feather feather-more-vertical
font-medium-2
text-body
">
        <circle cx="12" cy="12" r="1"></circle>
        <circle cx="12" cy="5" r="1"></circle>
        <circle cx="12" cy="19" r="1"></circle>
    </svg></a>
<div class="dropdown-menu dropdown-menu-end">
    <router-link :to="{
name: 'company_edit',
params: { id: adsdata1.company_id },
}" class="dropdown-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
feather feather-edit
font-small-4
me-50
">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>Edit</router-link>
    <button v-if="adsdata1.c_status == 'Active'" @click="deactive(adsdata1.company_id)" class="dropdown-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
feather feather-trash
font-small-4
me-50
">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>Suspended
    </button>
    <button v-if="adsdata1.c_status == 'Not Active'" @click="active(adsdata1.company_id)" class="dropdown-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="
feather feather-trash
font-small-4
me-50
">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>Activate
    </button>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: center; padding-top: 20px">
<pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- END: Content-->
<b-modal id="modal-lg" size="lg" title="Role Permissions To Company" ok-only>
<div class="col-12">
    <input type="text" hidden v-model="company_id" />
    <input type="text" hidden v-model="company_name" />
    <div v-if="success == 'Updated Status Successfully'" style="margin-top: 5px; margin-bottom: 5px">
        <p class="alert alert-info" style="padding-left: 10px;padding-right: 10px;padding-top: 5px;padding-bottom: 5px;">
            {{ success }}
        </p>
    </div>
    <div class="table-responsive">
        <table class="table table-flush-spacing">
            <tbody>
                        <tr>
                    <td class="text-nowrap fw-bolder">
                     Inventory Manangement System
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                            <i data-feather="info"></i>
                        </span>
                    </td>
                    <td>
                        <div class="form-check" style="margin-lef: ">

                            <b-form-checkbox v-model="store_permission" value="true" style="30px" @change="allowstore($event,'store')">
                                Allow</b-form-checkbox>
                        </div>
                    </td>
                </tr>
            <tr>
                    <td class="text-nowrap fw-bolder">
                     Accounts Manangement System
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                            <i data-feather="info"></i>
                        </span>
                    </td>
                    <td>
                        <div class="form-check" style="margin-lef: ">

                            <b-form-checkbox v-model="accounts_permission" value="true" style="30px" @change="allowaccounts($event,'accounts')">
                                Allow</b-form-checkbox>
                        </div>
                    </td>
                </tr>
             <tr>
                    <td class="text-nowrap fw-bolder">
                     Payroll Manangement System
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                            <i data-feather="info"></i>
                        </span>
                    </td>
                    <td>
                        <div class="form-check" style="margin-lef: ">

                            <b-form-checkbox v-model="payroll_permission" value="true" style="30px" @change="allowpayroll($event,'payroll')">
                                Allow</b-form-checkbox>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap fw-bolder">
                        HR Management System
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                            <i data-feather="info"></i>
                        </span>
                    </td>
                    <td>
                        <div class="form-check" style="margin-lef: ">
                            <b-form-checkbox v-model="hr_permisson" value="true" style="30px" @change="allowcheck($event,'hr')">
                                Allow</b-form-checkbox>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        <section class="col-12" v-if="hr_permisson=='true'">
            <div class="card">
                <div class="card-body">
                    <!-- custom options with permissions -->
                    <center>
                        <div class="col-10">
                            <div>
                                <div class="card-body">
                                    <div class="row custom-options-checkable g-1">
                                        <div class="col-md-3" style="margin-left: 65px">
                                            <input @change="check($event, 'hr')" v-model="hr_plans" class="custom-option-item-check" type="radio" name="customOptionsCheckableRadiosWithIcon" id="customOptionsCheckableRadiosWithIcon1" checked value="starter" />
                                            <label class="custom-option-item text-center p-1" for="customOptionsCheckableRadiosWithIcon1">
                                                <i class="fa-solid fa-play font-large-1 mb-55"></i>
                                                <span class="custom-option-item-title h4 d-block">Starter</span>
                                                <small>Rs 100,000</small>
                                            </label>
                                        </div>
                                        <div class="col-md-3" style="margin-left: 10px">
                                            <input @change="check($event, 'hr')" v-model="hr_plans" class="custom-option-item-check" type="radio" name="customOptionsCheckableRadiosWithIcon" id="customOptionsCheckableRadiosWithIcon2" value="business" />
                                            <label class="custom-option-item text-center text-center p-1" for="customOptionsCheckableRadiosWithIcon2">
                                                <!-- <i data-feather="user" class="font-large-1 mb-75"></i> -->
                                                <i class="fa-solid fa-user font-large-1 mb-55"></i>
                                                <span class="custom-option-item-title h4 d-block">Business</span>
                                                <small>Rs 150,000</small>
                                            </label>
                                        </div>
                                        <div class="col-md-3" style="margin-left: 10px">
                                            <input @change="check($event, 'hr')" v-model="hr_plans" class="custom-option-item-check" type="radio" name="customOptionsCheckableRadiosWithIcon" id="customOptionsCheckableRadiosWithIcon3" value="premium" />
                                            <label class="custom-option-item text-center p-1" for="customOptionsCheckableRadiosWithIcon3">
                                                <i class="fa-solid fa-coins font-large-1 mb-55"></i>
                                                <span class="custom-option-item-title h4 d-block">Premium</span>
                                                <small>300,000</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                    <!-- / custom options with permissions -->
                    <!-- table -->
                    <div class="table-responsive mb-1">
                        <table class="table table-bordered text-nowrap text-center">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">STARTER</th>
                                    <th scope="col">
                                        BUISNESS
                                    </th>
                                    <th scope="col">PREMIUM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Number of Employees
                                    </th>
                                    <td>Upto 50</td>
                                    <td>Upto 500</td>
                                    <td>Upto 5000</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Organisation Structure Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-check"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-check"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Employee Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Employee Self-Service
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Digital Document Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Payroll automation and payslips
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>Single</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Provident funds and Benefits
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>Single</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Leave Management System
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>Single</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Loans and Advances Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>Single</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Attendance Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Approval Workflows
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>Single</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Performance Appraisal Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-check"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Bio-metric and Facial Devices Integration
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Task Management
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Email & SMS Alerts
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        3rd Party Integrations
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        Reporting Anaytics
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-start">
                                        24/7 Team Support
                                    </th>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-x"></i>
                                    </td>
                                    <td><i class="fa-solid fa-check"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- / table -->
                </div>
            </div>
        </section>
    </div>
    <!-- Permission table -->
</div>
</b-modal>
</div>
</template>
<script>
export default {
data() {
return {
adsdata: {},
company_id: "",
company_name: "",
hr_permisson: "",
success: "",
module_name: "",
hr_plans: "",


payroll_permission:'',
payroll_module_name:'',

accounts_permission:'',
accounts_module_name:'',

store_module_name:'',
store_permission:'',
};
},
methods: {


getResult(page = 1) {
axios
.get("companies_detail/?page=" + page)
.then((response) => (this.adsdata = response.data))
.catch((error) => {});
},
savecompany_id(id, comp_name) {
this.company_id = id;
this.company_name = comp_name;
axios
.get("fetch_company_roles/" + this.company_id)
.then((response) => {
var g = response.data[0].module_status.split("_");
this.hr_permisson=g[0];
this.hr_plans=g[1];
})
.catch((error) => {});

axios
.get("fetch_company_roles_payroll/" + this.company_id)
.then((response) => {
this.payroll_permission=response.data[0].module_status;
})
axios
.get("fetch_company_roles_accounts/" + this.company_id)
.then((response) => {
this.accounts_permission=response.data[0].module_status;
})




},

allowpayroll:function(e,pay_name){

this.payroll_module_name = pay_name;
if (e == false) {
axios.post("submit_company_payroll", {
payroll_status: e,
company_id: this.company_id,
payroll_module_name: this.payroll_module_name,

})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}
else {
axios.post("submit_company_payroll1", {
payroll_status: e,
company_id: this.company_id,
payroll_module_name: this.payroll_module_name,
company_name: this.company_name,


})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}



},


allowaccounts:function(e,mod_name){
 this.accounts_module_name = mod_name;
if (e == false) {
axios.post("submit_company_accounts", {
accounts_status: e,
company_id: this.company_id,
accounts_module_name: this.accounts_module_name,

})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}
else {
axios.post("submit_company_accounts1", {
accounts_status: e,
company_id: this.company_id,
accounts_module_name: this.accounts_module_name,
company_name: this.company_name,


})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}
},



allowcheck: function(e, mod_name) {
this.module_name = mod_name;

if (e == false) {
axios.post("submit_company_roles1", {
hr_status: e,
company_id: this.company_id,
module_name: this.module_name,
})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}
},
check: function(e, mod_name) {
this.module_name = mod_name;


axios
.post("submit_company_roles", {
company_id: this.company_id,
hr_permisson: this.hr_permisson,
company_name: this.company_name,
module_name: this.module_name,
hr_plans: this.hr_plans,

})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
.catch((error) => {});
},

deactive(id) {
axios
.get("./deactivate_company1/" + id)
.then((response) => (this.adsdata = response.data))
.catch((error) => console.log(error));
},
active(id) {
axios
.get("./activate_company1/" + id)
.then((response) => (this.adsdata = response.data))
.catch((error) => console.log(error));
},


allowstore:function(e,mod_name){
 this.store_module_name = mod_name;
if (e == false) {
axios.post("submit_company_store", {
store_status: e,
company_id: this.company_id,
store_module_name: this.store_module_name,

})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}
else {
axios.post("submit_company_store1", {
store_status: e,
company_id: this.company_id,
store_module_name: this.store_module_name,
company_name: this.company_name,


})
.then((data) => {
if (data.data == "Updated Status Successfully") {
this.$toastr.s("Updated Status Successfully", "Congratulations");
}
})
}
},
},
mounted() {
this.getResult();
},
};

</script>
