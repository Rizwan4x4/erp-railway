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
    <li class="breadcrumb-item active">General Configuration</li>
</ol>
</div>
</div>
<div class="content-body">
<section class="app-user-view-account">
<div class="row">
    <!--/ User Sidebar -->
    <div class="row">
        <div  class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
            <!-- User Card -->
            <div v-if="hasPermission( 'Accounts Configurations  general Accounts Configuration') " class="card">
                <div class="card-body">
                    <section id="accordion-with-border">
                        <div  class="row">
                            <div class="col-sm-12">
                                <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                Accounts Configuration
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="card-header">
                                                    <h6 class="card-title">Sales Prefix</h6>
                                                </div>
                                                <div class="col-12 col-sm-3 mb-1">
                                                    <label class="form-label" for="accountFirstName">Customer Invoice</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="customer_inv" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
customer_inv == '' ||
customer_inv.length > 3
">{{ customer_inv_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-3 mb-1">
                                                    <label class="form-label" for="accountFirstName">Credit Notes</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="customer_credit" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
customer_credit == '' ||
customer_credit.length > 3
">{{ customer_credit_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Receipt Voucher</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="customer_voucher" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
customer_voucher == '' ||
customer_voucher.length > 3
">{{ customer_voucher_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Customer</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="customer_pre" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
customer_pre == '' ||
customer_pre.length > 4
">{{ customer_pre_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Quotation</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="quotation" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
quotation == '' ||
quotation.length > 4
">{{ quotation_error }}</span>
                                                </div>
                                                <div class="card-header">
                                                    <h6 class="card-title">
                                                        Purchase Prefix
                                                    </h6>
                                                </div>
                                                <div class="col-12 col-sm-3 mb-1">
                                                    <label class="form-label" for="accountFirstName">Purchase Order</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="vendor_inv" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
vendor_inv == '' ||
vendor_inv.length > 3
">{{ vendor_inv_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-3 mb-1">
                                                    <label class="form-label" for="accountFirstName">Debit Notes</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="vendor_debit" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
vendor_debit == '' ||
vendor_debit.length > 3
">{{ vendor_debit_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Vendor</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="vendor_voucher" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
vendor_voucher == '' ||
vendor_voucher.length > 3
">{{ vendor_voucher_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Payment Voucher</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="vendor_pre" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="
vendor_pre == '' ||
vendor_pre.length > 4
">{{ vendor_pre_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Requistion</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="requistion" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="requistion == '' ||requistion.length > 4">{{ requistion_error }}</span>
                                                </div>
                                                <div class="card-header">
                                                    <h6 class="card-title">
                                                        Accounting Prefix
                                                    </h6>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Journal Voucher</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="journal_voucher" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="journal_voucher == '' ||journal_voucher.length > 4">{{ journal_voucher_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">Curriences</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="currency" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="currency == '' ">{{ currency_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-2 mb-1">
                                                    <label class="form-label" for="accountFirstName">GRN</label>
                                                    <label style="color: #d93025">*</label>
                                                    <input class="form-control" v-model="grn" placeholder="" />
                                                    <span style="color: #db4437; font-size: 11px" v-if="grn == '' ">{{ grn_error }}</span>
                                                </div>
                                                <div class="col-12 col-sm-4 mb-1"></div>
                                                <div class="col-12 col-sm-3 mb-1" style="padding-top: 25px">
                                                    <button type="submit" :disabled="disabled" @click="delay()" style="width: 100%" class="btn btn-primary me-1 mt-1">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- /User Card -->
            <section class="app-user-view-account">
                <div class="row">
                    <!-- User Sidebar -->
                    <div  v-if="hasPermission( 'Accounts Configurations  general Child Companies') " class="col-xl-7 col-lg-7 col-md-7 order-1 order-md-0">
                        <div class="card">
                            <div class="card-body">
                                <section id="accordion-with-border">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Child Companies</h4>
                                                        <a data-bs-toggle="modal" data-bs-target="#addNewCard" class="btn btn-outline-primary waves-effect">Create New</a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Company Name</th>
                                                                        <th>Phone No</th>
                                                                        <th>Email Id</th>
                                                                        <th>Address</th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="company_data1 in company_data.data">
                                                                        <td>{{company_data1.COmpanyName}}</td>
                                                                        <td>{{company_data1.CompanyPhone}}</td>
                                                                        <td>{{company_data1.CompanyEmail}}</td>
                                                                        <td>{{company_data1.CompanyAddress}}
                                                                        </td>
                                                                        <td>{{company_data1.Status}}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div style="text-align:center;padding-top:20px">
                                                            <pagination :data="company_data" @pagination-change-page="getResult2"></pagination>
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
                    <!--/ User Sidebar -->
                    <!-- User Sidebar -->
                    <div  v-if="hasPermission( 'Accounts Configurations  general Departments') " class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                        <div class="card">
                            <div class="card-body">
                                <section id="accordion-with-border">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Departments</h4>
                                                        <a data-bs-toggle="modal" data-bs-target="#departments" class="btn btn-outline-primary waves-effect">Create New</a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Department Name</th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="dept_data1 in dept_data.data">
                                                                        <td>{{dept_data1.COmpanyName}}</td>
                                                                        <td>{{dept_data1.Status}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div style="text-align:center;padding-top:20px">
                                                            <pagination :data="dept_data" @pagination-change-page="getResult6"></pagination>
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
                    <div  v-if="hasPermission( 'Accounts Configurations  general Units') " class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                        <div class="card">
                            <div class="card-body">
                                <section id="accordion-with-border">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Units</h4>
                                                        <a data-bs-toggle="modal" data-bs-target="#units" class="btn btn-outline-primary waves-effect">Create New</a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Unit Name</th>
                                                                        <th>Status</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="unit_data1 in unit_data.data">
                                                                        <td>{{unit_data1.UnitName}}</td>
                                                                        <td>{{unit_data1.Status}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div style="text-align:center;padding-top:20px">
                                                            <pagination :data="unit_data" @pagination-change-page="getResult7"></pagination>
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
                    <!--/ User Sidebar -->
                    <div  v-if="hasPermission( 'Accounts Configurations  general Purchase Orders') " class="col-xl-6 col-lg-6 col-md-6 order-1 order-md-0">
                        <div class="card">
                            <div class="card-body">
                                <section id="accordion-with-border">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Purchase Orders</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive" style="overflow-x: initial !important;">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>PO Code</th>
                                                                        <th>Dated</th>
                                                                        <th>Vendor</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="p_orders1 in p_orders.data">
                                                                        <td>{{p_orders1.PoCode}}</td>
                                                                        <td>{{p_orders1.PoDate}}</td>
                                                                        <td>{{p_orders1.PoDate}}</td>
                                                                        <td v-if="p_orders1.state=='0' && p_orders1.pinv_state=='0'">
                                                                            <span @click="confirm_close_po(p_orders1)" data-bs-toggle="modal" data-bs-target="#po_close" style="cursor:pointer;" class="badge  rounded-pill badge-light-danger">Open</span>
                                                                        </td>
                                                                        <td v-else>
                                                                            <span style="cursor:context-menu;" class="badge  rounded-pill badge-light-success">Working</span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div style="text-align:center;padding-top:20px">
                                                            <pagination :data="p_orders" @pagination-change-page="getResult8" :limit="limit1"></pagination>
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
                    <!-- Add holiday model-->
                    <div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Create Child Company</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Company Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="company_name" class="form-control" placeholder="Child Company Name">
                                            <span style="color: #db4437; font-size: 11px" v-if="company_name == ''">{{ company_name_error }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Phone No.</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input v-model="phone_no" type="number" id="modalAddCardName" class="form-control" placeholder="Please type phone number" />
                                            <span style="color: #db4437; font-size: 11px" v-if="phone_no == ''">{{ phone_no_error }}</span>
                                        </div>
                                        <div class="col-12 col-sm-12 mb-1">
                                            <label class="form-label" for="basicSelect">Email Address</label>
                                            <input v-model="company_email" type="email" id="modalAddCardName" class="form-control" placeholder="Enter Email Address" />
                                            <span style="color: #db4437; font-size: 11px" v-if="company_email == ''">{{ company_email_error }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="modalAddCardName">Address</label>
                                            <input v-model="company_address" type="text" id="modalAddCardName" class="form-control" placeholder="Please type Address"/>
                                            <span style="color: #db4437; font-size: 11px" v-if="company_address == ''">{{ company_address_error }}</span>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1 mt-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"  aria-label="Close">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="po_close" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel18">Confirm closing of Purchase Order</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Do you want to close purchase order <label>{{this.pocode}}</label>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" @click="close_po(p_orders1)" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal">Yes</button>
                                    <button type="button" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="leavetype" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Add New Project</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Project Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="project_name" class="form-control" placeholder="Project Names">
                                            <span style="color: #db4437; font-size: 11px" v-if="project_name == ''">{{ project_name_error }}</span>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled2" @click="delay2()" class="btn btn-primary me-1 mt-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="leavetype2" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <h3 class="text-center mb-1" id="addNewCardTitle">Link New Project</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body px-sm-5 mx-50 pb-5">
                                    <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
                                        <div class="col-12">
                                            <label class="form-label" for="modalAddCardName">Project Name</label>
                                            <span style="color: #DB4437; font-size: 11px;">*</span>
                                            <input type="text" v-model="project_name1" readonly class="form-control" placeholder="Project Names">
                                            <span style="color: #db4437; font-size: 11px" v-if="project_name == ''">{{ project_name_error }}</span>
                                        </div>
                                           <div class="invoice-customer" >
                                            <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction"  :show-labels="false" :multiple="true" v-model="dept_name" :options="options">
                                                            </multiselect>
                                            </div>
                                            <div class="invoice-customer" >
                                            <multiselect style="margin-right: 10px; font-size: 12px;" id="FilterTransaction"  :show-labels="false"  v-model="account_idname" :options="options2">
                                                            </multiselect>
                                            </div>


                                        <div class="col-12 text-center">
                                            <button type="submit" :disabled="disabled3" @click="delay3()" class="btn btn-primary me-1 mt-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                                                Close
                                            </button>
                                        </div>
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
</section>
</div>
</div>
<div class="row">

<div v-if="hasPermission( 'Accounts Configurations  general Link COA & Department') " class="col-xl-12 col-lg-12 col-md-12 order-1 order-md-0">
    <!-- User Card -->
    <div class="card">
        <div class="card-body">
            <section id="accordion-with-border">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="accordionWrapa50" role="tablist" aria-multiselectable="true">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Link COA & Department</h4>
                                    <div class="me-1">
                <div class="dataTables_filter" style="margin-top: 5px">
                    <label>
                        <input autocomplete="off" class="form-control" v-model="keyword1"  style="" placeholder="Search By Name" />
                    </label>

                </div>
            </div>
                                    <a data-bs-toggle="modal" data-bs-target="#leavetype" class="btn btn-outline-primary waves-effect">Add Project</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" style="overflow-x: initial !important; min-height:271px">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th>Id</th>
                                                    <th>Project Name</th>
                                                    <th>COA AccountID</th>
                                                    <th>Account Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="project_data1 in project_data.data">
                                                    <td>{{project_data1.ID}}</td>
                                                    <td>{{project_data1.ProjectName}}</td>
                                                    <td>{{project_data1.CoaID}}</td>
                                                    <td>{{project_data1.CoaName}}</td>
                                                    <td><a @click=fetch_projectid(project_data1.ID) data-bs-toggle="modal" data-bs-target="#leavetype2" class=""><i class="fa-solid fa-edit"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="text-align:center;padding-top:20px">
                                        <pagination :limit="limit1" :data="project_data" @pagination-change-page="getResult3"></pagination>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- /User Card -->
</div>
</div>
</div>

<div class="modal fade" id="departments" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-transparent">
<h3 class="text-center mb-1" id="addNewCardTitle">Create New Department</h3>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-sm-5 mx-50 pb-5">
<div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
    <div class="col-12">
        <label class="form-label" for="modalAddCardName">Company Name</label>
        <span style="color: #DB4437; font-size: 11px;">*</span>
        <input type="text" v-model="department" class="form-control" placeholder="Department Name">
        <span style="color: #db4437; font-size: 11px" v-if="department == ''">{{ department_name_error }}</span>
    </div>
    <div class="col-12 text-center">
        <button type="submit" :disabled="disabled6" @click="delay6()" class="btn btn-primary me-1 mt-1">Submit</button>
        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
            Close
        </button>
    </div>
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="units" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-transparent">
<h3 class="text-center mb-1" id="addNewCardTitle">Create New Unit</h3>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-sm-5 mx-50 pb-5">
<div id="addNewCardValidation" class="row gy-1 gx-2 mt-75">
    <div class="col-12">
        <label class="form-label" for="modalAddCardName">Unit Name</label>
        <span style="color: #DB4437; font-size: 11px;">*</span>
        <input type="text" v-model="unit_name" class="form-control" placeholder="Unit Name Here">
        <span style="color: #db4437; font-size: 11px" v-if="unit_name == ''">{{ unit_name_error }}</span>
    </div>
    <div class="col-12 text-center">
        <button type="submit" :disabled="disabled6" @click="delay7()" class="btn btn-primary me-1 mt-1">Submit</button>
        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
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
import Multiselect from 'vue-multiselect'
export default {
data() {
return {
keyword1:'',
project_name1:'',
account_idname:'',
dept_name:null,

 options2: [],
 options: [],
 departments:{},

dept_data: {},
disabled6: false,
timeout6: null,
department: '',
department_name_error: '',
limit:5,
limit1:3,
unit_name_error: '',
unit_data: {},
unit_name: '',
disabled7: false,
timeout7: null,
parent: '',
parent_error: '',
disabled2: false,
timeout2: null,
company_settings: "individual",
counter: 1,
disabled: false,
disabled1: false,
timeout1: null,
timeout: null,
customer_inv: "",
customer_inv_error: "",
customer_credit: "",
customer_credit_error: "",
customer_pre: "",
customer_pre_error: "",
customer_voucher: "",
customer_voucher_error: "",
quotation: "",
quotation_error: "",
vendor_debit: "",
vendor_debit_error: "",
vendor_inv: "",
vendor_inv_error: "",
vendor_pre: "",
vendor_pre_error: "",
vendor_voucher: "",
vendor_voucher_error: "",
requistion: "",
requistion_error: "",
journal_voucher: "",
journal_voucher_error: "",
grn: '',
grn_error: '',
agnstpayment:{},
fetchdep:{},
company_name: "",
company_email: "",
company_address: "",
phone_no: "",

project_name: '',
child_company: '',
child_company: {},
currency: '',
currency_error: '',

company_data: {},
project_data: {},

company_name_error: "",
company_email_error: "",
company_address_error: "",
phone_no_error: "",

project_name_error: "",
child_company_error: "",
get_child_data: {},

p_orders: {},
close_poid: '',
pocode: '',

disabled3: false,
timeout3: null,
}
},
components: {
             Multiselect
        },
watch: {
keyword1(after, before) {
this.getResults();
}
},
methods: {
delay3() {
this.disabled3 = true
this.timeout3 = setTimeout(() => {
this.disabled3 = false
}, 5000)
this.submit_coalinkdept()
},
submit_coalinkdept(){
    if (this.project_name1 == "" || this.account_idname==''||this.dept_name==null) {
this.$toastr.e("Please fill required fields!", "Caution!");

} else {
axios.post("accounts/submit_linkcoaproject", {
project_id:this.project_id,
project_name1:this.project_name1,
dept_name:this.dept_name,
account_idname:this.account_idname,
})
.then((data) => {
    if(data.data=='error'){
this.$toastr.e("Error!", "Cautions!");

    }
    else {
     this.project_data = data.data;
     this.project_id='';
    this.project_name1 = '';
    this.dept_name=null;
    this.dept_name='',
    this.$toastr.s("Project Link Accounts Successfully!", "Congratulations!");
    }


})
}
},


fetch_projectid(id){
    this.project_id=id;
    axios.get('accounts/get_linkaccount/' + this.project_id)
.then(response => {
this.account_idname=response.data[0].CoaID+'_'+response.data[0].CoaName;
this.project_name1=response.data[0].ProjectName;
})
    axios.get('accounts/fetch_expense_head')
.then(response => {
this.agnstpayment = response.data
 this.options2 = [];

    var $this = this;
    for (var i = 0; i < $this.agnstpayment.length; i++) {
        this.options2.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
    }
})

    axios.get('accounts/get_departmentdetail1/' + this.project_id)
.then(response => {
this.fetchdep=response.data;
this.dept_name = [];
 var $this = this;
  for (var j = 0; j < $this.fetchdep.length; j++) {
  this.dept_name.push($this.fetchdep[j].DepartmentName);
}
})
},
getResults(){
  axios.get('accounts/searchcoa/'+this.keyword1)
.then(response => this.project_data = response.data)
.catch(error => {console.log(error)})
},
confirm_close_po(po) {
this.close_poid = po.PurchaseOrderID;
this.pocode = po.PoCode;
},
close_po() {
axios.post("accounts/close_po", {
po_id: this.close_poid,
})
.then((data) => {
if (data.data == 'Purchase order not closed') {
this.$toastr.e(data.data, "Caution!");
} else {
this.p_orders = data.data;
this.$toastr.s("Purchase order closed successfully!", "Congratulations!");
}
})
},
getResult8(page = 1) {
axios.get('accounts/po_data?page=' + page)
.then(response => this.p_orders = response.data)
.catch(error => {});
},
delay7() {
this.disabled7 = true
this.timeout7 = setTimeout(() => {
this.disabled7 = false
}, 5000)
this.submit_unit()
},
submit_unit() {
if (this.unit_name == "") {
this.$toastr.e("Please fill required fields!", "Caution!");
this.unit_name_error = "please type department";
} else {
axios.post("accounts/submit_unit", {
unit_name: this.unit_name,
})
.then((data) => {
if (data.data == "Unit already exists") {
    this.$toastr.e("Unit already exists!", "Caution!");
} else {
    this.unit_data = data.data;
    this.unit_name = '';
    this.$toastr.s("Created Unit Successfully!", "Congratulations!");
}
})
}
},
find_child() {
axios.get('accounts/get_childcompany1/' + this.parent)
.then(response => {
this.get_child_data = response.data;
})
},







delay6() {
this.disabled6 = true
this.timeout6 = setTimeout(() => {
this.disabled6 = false
}, 5000)
this.submit_department()
},
submit_department() {
if (this.department == "") {
this.$toastr.e("Please fill required fields!", "Caution!");
this.department_name_error = "please type department";
} else {
axios.post("accounts/submit_departments", {
department: this.department,
})
.then((data) => {
if (data.data == "Company already exists") {
    this.$toastr.e("Department already exists!", "Caution!");
} else {
    this.dept_data = data.data;
    this.department = '';
    this.$toastr.s("Updated Department Successfully!", "Congratulations!");

}

})
}
},



delay() {
this.disabled = true
this.timeout = setTimeout(() => {
this.disabled = false
}, 5000)
this.submit_configuration()
},
submit_configuration() {

if (
this.customer_inv == "" ||
this.customer_credit == "" ||
this.customer_pre == "" ||
this.customer_voucher == "" ||
this.quotation == "" ||
this.vendor_debit == "" ||
this.vendor_inv == "" ||
this.vendor_pre == "" ||
this.vendor_voucher == "" ||
this.requistion == "" ||
this.journal_voucher == "" ||
this.currency == "" ||
this.grn == ""
) {
this.$toastr.e("Please fill required fields!", "Caution!");
if (this.customer_inv.length < 3) {
this.customer_inv_error = "maximum 3 chracters required";
}
if (this.customer_credit.length < 3) {
this.customer_credit_error = "maximum 3 chracters required";
}
if (this.customer_pre.length < 4) {
this.customer_pre_error = "maximum 4 chracters required";
}
if (this.customer_voucher.length < 3) {
this.customer_voucher_error = "maximum 3 chracters required";
}
if (this.quotation.length < 4) {
this.quotation_error = "maximum 4 chracters required";
}
if (this.vendor_debit.length < 3) {
this.vendor_debit_error = "maximum 3 chracters required";
}
if (this.vendor_inv.length < 3) {
this.vendor_inv_error = "maximum 3 chracters required";
}
if (this.vendor_pre.length < 4) {
this.vendor_pre_error = "maximum 4 chracters required";
}
if (this.vendor_voucher.length < 3) {
this.vendor_voucher_error = "maximum 3 chracters required";
}
if (this.requistion.length < 3) {
this.requistion_error = "maximum 4 chracters required";
}
if (this.journal_voucher.length < 4) {
this.journal_voucher_error = "maximum 4 chracters required";
}
if (this.currency == "") {
this.currency_error = "Please type currency";
}
if (this.grn == "") {
this.grn_error = "Please type currency";
}
} else {
axios.post("update_accounts_configuration", {
customer_inv: this.customer_inv,
customer_credit: this.customer_credit,
customer_pre: this.customer_pre,
customer_voucher: this.customer_voucher,
quotation: this.quotation,
vendor_debit: this.vendor_debit,
vendor_inv: this.vendor_inv,
vendor_pre: this.vendor_pre,
vendor_voucher: this.vendor_voucher,
requistion: this.requistion,
journal_voucher: this.journal_voucher,
currency: this.currency,
grn: this.grn,
})
.then((data) => {
this.$toastr.s("Updated Record Successfully!", "Congratulations!");
})
.catch((error) => console.log(error));
}
},

delay1() {
this.disabled1 = true
this.timeout1 = setTimeout(() => {
this.disabled1 = false
}, 5000)
this.submit_company_record()
},
delay2() {
this.disabled2 = true
this.timeout2 = setTimeout(() => {
this.disabled2 = false
}, 5000)
this.submit_project_record()
},
submit_company_record() {
if (this.company_name == "" || this.company_email == "" || this.company_address == "" || this.phone_no == "") {
this.$toastr.e("Please fill required fields!", "Caution!");
if (this.company_name == "") {
this.company_name_error = "Please enter name";
}
if (this.company_address == "") {
this.company_address_error = "Please enter address";
}
if (this.company_email == "") {
this.company_email_error = "Please enter email";
}
if (this.phone_no == "") {
this.phone_no_error = "Please enter phone number";
}
} else {
axios.post("./accounts/submit_childcompany", {
company_name: this.company_name,
company_address: this.company_address,
company_email: this.company_email,
phone_no: this.phone_no,

})
.then((data) => {
if (data.data == "Company name already exists") {
    this.$toastr.e("Company name already exists!", "Caution!");

} else if (data.data == "Company email already exists") {
    this.$toastr.e("Company email already exists!", "Caution!");
} else {
    this.company_data = data.data
    this.company_name = "";
    this.company_address = "";
    this.company_email = "";
    this.phone_no = "";

    this.$toastr.s("Added New Child Company!", "Successfully!");

}

})
}
},
submit_project_record() {
if (this.project_name == "") {
this.$toastr.e("Please fill required fields!", "Caution!");
if (this.project_name == "") {
this.project_name_error = "Please enter project name";
}

} else {
axios.post("./accounts/submit_project_child1", {
project_name: this.project_name,

})
.then((data) => {
if (data.data == "Project name already exists") {
    this.$toastr.e("Project name already exists!", "Caution!");

} else {
    this.$toastr.s("Added New Project in child company!", "Successfully!");

    this.project_data = data.data
    this.project_name = "";

}
})
}

},
getResult2(page = 1) {

axios.get('accounts/child_detail?page=' + page)
.then(response => this.company_data = response.data)
.catch(error => {});
},
getResult3(page = 1) {

axios.get('accounts/fetch_coaproject?page=' + page)
.then(response => this.project_data = response.data)
.catch(error => {});
},
getResult6(page = 1) {
axios.get('accounts/dept_data1?page='+page)
.then(response => {
    this.dept_data = response.data})
.catch(error => {});
},
getResult7(page = 1) {
axios.get('accounts/unit_data?page=' + page)
.then(response => this.unit_data = response.data)
.catch(error => {});
}
},

mounted() {
            axios.get('department_detail2')
                .then(data => {
                    this.departments = data.data
                    this.options = [];

                 var $this = this;
                  for (var i = 0; i < $this.departments.length; i++) {
                  this.options.push($this.departments[i].department_name);
                   }
                })
                .catch(error => { });
this.getResult2();
this.getResult3();
this.getResult6();
this.getResult7();
this.getResult8();
axios.get('accounts/fetch_company_config')
.then(response => {
this.customer_inv = response.data[0].CustomerInvoice;
this.customer_credit = response.data[0].CreditNote;
this.customer_pre = response.data[0].Customer;
this.customer_voucher = response.data[0].ReceivedVoucher;
this.quotation = response.data[0].Quotation;
this.vendor_debit = response.data[0].DebitNote;
this.vendor_inv = response.data[0].PurchaseOrder;
this.vendor_pre = response.data[0].Vendor;
this.vendor_voucher = response.data[0].PaymentVoucher;
this.requistion = response.data[0].Requisition;
this.journal_voucher = response.data[0].JournalVocvher;
this.currency = response.data[0].Currency;
this.grn = response.data[0].GoodReceivedNote;

})
.catch(error => {});

},
}

</script>
<style scoped>
.multiselect__tags{
    max-height: auto !important;
}
</style>
