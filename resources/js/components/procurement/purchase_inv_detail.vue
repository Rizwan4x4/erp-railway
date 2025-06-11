<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow-tem-change"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" >
                                <router-link to="/dashboards/procurement" style="text-decoration: none;">Procurement Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Services Invoice Details
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.total?.toLocaleString()}}</h3>
                                            <span>Total</span>
                                        </div>
                                        <div class="avatar bg-light-primary p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-file-invoice"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.partially?.toLocaleString()}}</h3>
                                            <span>Partially Completed</span>
                                        </div>
                                        <div class="avatar bg-light-info p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.fully?.toLocaleString()}}</h3>
                                            <span>Fully Completed</span>
                                        </div>
                                        <div class="avatar bg-light-info p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.verified?.toLocaleString()}}</h3>
                                            <span>Verified</span>
                                        </div>
                                        <div class="avatar bg-light-success p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-file-import"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2 col-12 mb-2">
                                            <label class="form-label">Date From</label>
                                            <input type="date" v-model="startingdate" class="form-control">
                                        </div>
                                        <div class="col-md-2 col-12 mb-3">
                                            <label class="form-label">Date To</label>
                                            <input type="date" class="form-control" v-model="closingdate">
                                        </div>
                                        <div class="col-md-1 col-12 mb-3">
                                            <button @click="filtered_GRN()" style="margin-top: 25px;" class="btn btn-secondary">Search</button>
                                        </div>
                                        <div class="col-md-1 col-12 mb-3">
                                            <button @click="startingdate='', closingdate='', filtered_GRN()" style="margin-top: 25px" class="btn btn-outline-secondary waves-effect">Clear</button>
                                        </div>
                                        <div class="col-md-3 col-12 mb-3">
                                            <input type="text" style="margin-top: 25px; width:100%;" v-model="keyword1" class="form-control" placeholder=" Vendor Name / Invoice ID / Po ID" />
                                        </div>
                                        <div  v-if="hasPermission('Services Invoice Create')" class="col-md-3 col-12 mb-3" style="text-align:right;">
                                            <router-link to="/purchase_invoice/create_invoice" style="margin-top: 25px" class="btn btn-primary" type="button">+ New Services Invoice</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Invoice ID<br />& Date</th>
                                            <th class="sticky-th-center">Department<br />& Project</th>
                                            <th class="sticky-th-center">Vendor Name</th>
                                            <th class="sticky-th-center">SubTotal</th>
                                            <th class="sticky-th-center">Tax</th>
                                            <th class="sticky-th-center">Delivery<br />Charges</th>
                                            <th class="sticky-th-center">Total<br />Amount</th>
                                            <th class="sticky-th-center">Status</th>
                                            <th class="sticky-th-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="adsdata1 in adsdata.data" :class="[adsdata1.Status2=='Not Verified' ? 'table-warning' : '']">
                                            <td class="td-center"><span class="fw-bold">{{adsdata1.FormID}}</span><br />{{adsdata1.Dated}}</td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column"><a class="user_name text-truncate text-body"><span class="fw-bolder">{{adsdata1.DepartmentName}}</span></a><small class="emp_post text-muted">{{adsdata1.ProjectName}}</small></div>
                                                </div>
                                            </td>
                                            <td class="td-center" style="max-width:200px;">
                                                {{adsdata1.vendorName}}
                                            </td>
                                            <td class="td-right">{{Number(adsdata1.SubTotal)?.toLocaleString()}}</td>
                                            <td class="td-right">{{Number(adsdata1.Tax)?.toLocaleString()}}</td>
                                            <td class="td-right">{{Number(adsdata1.ShippingCharges)?.toLocaleString()}}</td>
                                            <td class="td-right">{{Number(adsdata1.TotalAmount)?.toLocaleString()}}</td>
                                            <td  v-if="hasPermission('Services Invoice Statuses')" class="td-center">
                                                <span v-if="adsdata1.Status2=='Verified'" class="badge badge-glow bg-success">{{adsdata1.Status2}}</span>
                                                <span v-else-if="adsdata1.Status2=='Not Verified'" @click="editgrn(adsdata1.ReceavingOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_status2" class="badge bg-light-success">{{adsdata1.Status2}}</span>
                                            </td>
                                            <td v-else class="td-center">
                                                <span v-if="adsdata1.Status2=='Verified'" class="badge bg-light-success">{{adsdata1.Status2}}</span>
                                                <span v-else-if="adsdata1.Status2=='Not Verified'" class="badge bg-light-warning">{{adsdata1.Status2}}</span>
                                            </td>
                                            <td   class="td-center">
                                                <a v-if="hasPermission('Services Invoice Edit')" class="me-25" @click="editgrn(adsdata1.ReceavingOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_view">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a v-if="hasPermission('Services Invoice Print')" target="_blank" v-bind:href="`Accounts/pi_Letter9/${adsdata1.ReceavingOrderID}/${adsdata1.FormID}`" class="btn btn-sm"><i class="fa-solid fa-print"></i></a>
                                                <router-link v-if="adsdata1.Status2=='Not Verified'" style="float:left" :to="'/accounting/accounting_edit_si/'+adsdata1.ReceavingOrderID" >
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination v-if="pageNo==1" :limit="limit" :data="adsdata" @pagination-change-page="getResult"></pagination>
                                <pagination v-if="pageNo==3" :limit="limit" :data="adsdata" @pagination-change-page="getResults"></pagination>
                                <pagination v-else-if="pageNo==2" :limit="limit" :data="adsdata" @pagination-change-page="filtered_GRN"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="PREQ_status" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata11 in get_grndata">
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
                                            <span class="invoice-number">{{get_grndata11.FormID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_grndata11.Status2=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_grndata11.Status2=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_grndata11.Status2=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <hr class="invoice-spacing">
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-8 p-0">
                                        <h6 class="mb-2">Vendor Name:</h6>
                                        <h6 class="mb-25">{{get_grndata11.vendorName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata11.DepartmentName}}</p>
                                        <p class="card-text mb-25">{{get_grndata11.ProjectName}}</p>
                                        <p class="card-text mb-25"><span class="badge badge-glow bg-warning">{{get_grndata11.Status}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Quantity</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Est. Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.PoQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.RecvdQuantity}}</span>
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
                                            {{get_grndata11.Remarks}}
                                        </p>
                                    </div>
                                    <div>

                                    </div>
                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                            <option value=""> Select Status </option>
                                            <option value="Verified">Verified</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 pt-50">
                                <button :disabled="disabled" @click="delay()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="PREQ_view" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata11 in get_grndata">
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
                                            <span class="invoice-number">{{get_grndata11.FormID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_grndata11.Status2=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_grndata11.Status2=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_grndata11.Status2=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Service Invoice</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-7 p-0">
                                        <h6 class="mb-2">Vendor Name:</h6>
                                        <h6 class="mb-25">{{get_grndata11.vendorName}}</h6>
                                    </div>
                                    <div class="col-xl-5 p-0 mt-xl-0 mt-2">
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Department:</p>
                                            <p style="width:65%" class="invoice-date">{{get_grndata11.DepartmentName}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Project:</p>
                                            <p style="width:65%" class="invoice-date">{{get_grndata11.ProjectName}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Completion Status:</p>
                                            <p style="width:65%" class="card-text mb-25"><span class="badge badge-glow bg-warning">{{get_grndata11.Status}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Ordered qty</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Rcvd Qty</th>
                                            <th class="py-1">Cost</th>
                                            <th class="py-1">SubTotal</th>
                                            <th class="py-1">Item Expiry</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.PoQuantity)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.RecvdQuantity)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.Price)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{Number(get_grndata21.SubTotal)}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21. ItemExpiry}}</span>
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
                                            {{get_grndata11.Remarks}}
                                        </p>
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Payment Term:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{get_grndata11.PaymentTerm}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="min-width: 50%;">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> SubTotal: {{currency}}. {{Number(get_grndata11.SubTotal)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Tax: {{currency}}. {{Number(get_grndata11.Tax)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Delivery : {{currency}}. {{Number(get_grndata11.ShippingCharges)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Discount: {{currency}}. {{Number(get_grndata11.Discount)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p style="font-weight:bold" class="invoice-total-title">  Total: {{currency}}. {{Number(get_grndata11.TotalAmount)}}</p>
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
        <div class="modal fade" id="PREQ_status2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata11 in get_grndata">
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
                                            <span class="invoice-number">{{get_grndata11.FormID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_grndata11.Status2=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_grndata11.Status2=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_grndata11.Status2=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>

                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Edit Purchase Invoice</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-8 p-0">
                                        <h6 class="mb-2">Vendor Name:</h6>
                                        <h6 class="mb-25">{{get_grndata11.vendorName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata11.DepartmentName}}</p>
                                        <p class="card-text mb-25">{{get_grndata11.ProjectName}}</p>
                                        <p class="card-text mb-25"><span class="badge badge-glow bg-warning">{{get_grndata11.Status}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Ordered qty</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Rcvd Qty</th>
                                            <th class="py-1">Cost</th>
                                            <th class="py-1">SubTotal</th>
                                            <th class="py-1">Item Expiry</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemName}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.PoQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.Unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.RecvdQuantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.Price}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.SubTotal}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21. ItemExpiry}}</span>
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
                                            {{get_grndata11.Remarks}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="max-width: 300px;">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> SubTotal: {{currency}}. {{Number(get_grndata11.SubTotal)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Tax: {{currency}}. {{Number(get_grndata11.Tax)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Delivery : {{currency}}. {{Number(get_grndata11.ShippingCharges)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Discount: {{currency}}. {{Number(get_grndata11.Discount)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p style="font-weight:bold" class="invoice-total-title">  Total: {{currency}}. {{Number(get_grndata11.TotalAmount)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12  mt-2 pt-50" style="text-align:left">
                                <div class="row  mt-2 pt-50" style="margin-left:40px;text-align:left">
                                    <div class="col-6 col-md-6 ">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <input hidden type="text" v-model="get_id" />
                                        <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                            <option value="">Select Status</option>
                                            <option value="Verified">Verify</option>
                                        </select>
                                        <span style="color: #DB4437; font-size:11px;" v-if="up_sts==''">{{e_up_sts}}</span>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <button :disabled="disabled1" @click="delay1()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
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
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                pageNo: 1,
                limit: 10,
                adsdata: {},
                currency: '',
                companydetail: {},
                vendors: {},
                keyword1: '',
                vendor_name: 'All',
                status1: 'All',
                status2: 'All',

                startingdate: (new Date().toJSON().slice(0, 4)) - 1 + new Date().toJSON().slice(4, 10),
                closingdate: new Date().toJSON().slice(0, 10),
                get_grndata: {},
                get_grndata1: {},
                count_users: {},
                up_sts: '',
                get_id: '',
                disabled: false,
                timeout: null,
                up_sts: '',
                e_up_sts: '',
            }
        },
        methods: {
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_preq_status();
            },
            update_preq_status() {
                if (this.up_sts == '' || this.get_id == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.up_sts == '') {
                        this.e_up_sts = "Select status";
                    }
                }
                else {
                    axios.post('./accounts/update_v_inv', {
                        get_id: this.get_id,
                        sts: this.up_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                const updatedIndex = this.adsdata.data.findIndex(item => item.ReceavingOrderID === this.get_id);
            if (updatedIndex !== -1) {

                this.adsdata.data[updatedIndex].Status2 =  this.up_sts;

                this.get_id = "";
                                this.up_sts = "";

                // Update other properties as needed
            }

                            }
                            else{
                                this.$toastr.e(data.data, "Errors!");

                            }
                        })
                }
            },
            filtered_GRN(page = 1) {
                this.keyword1 = '';
                this.pageNo = 2;
                if (this.startingdate == '') {
                    this.startingdate = (new Date().toJSON().slice(0, 4)) - 1 + new Date().toJSON().slice(4, 10);
                }
                if (this.closingdate == '') {
                    this.closingdate = new Date().toJSON().slice(0, 10);
                }
                axios.get('./searchgrn/' + this.startingdate + '/' + this.closingdate + '?page=' + page)
                    .then(data => this.adsdata = data.data)
                    .catch(error => this.error = error.response.data.errors)
            },

        getResult(page = 1) {
       this.pageNo=1
        axios.get('accounts/grn_detail?page=' + page)
        .then(response => this.adsdata = response.data)
        .catch(error => {});
           },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_grnstatus();
            },
            update_grnstatus() {
                axios.get('accounts/update_grn/' + this.get_id + '/' + this.up_sts)
                    .then(response => {
                        this.adsdata = response.data;
                    })
            },
            editgrn(id) {
                this.get_id = id;
                axios.get('accounts/get_grn_data/' + id)
                    .then(response => {
                        this.get_grndata = response.data;
                    })

                axios.get('accounts/get_grn_data1/' + id)
                    .then(response => {
                        this.get_grndata1 = response.data;
                        this.pv_id = response.data[0].ReceavingOrderID;
                    })
            },
            getResults(page = 1) {
                this.pageNo = 3;
                this.startingdate = '';
                this.closingdate = '';
                axios.get('./accounts_grnbyVendor?page=' + page, { params: { name: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        mounted() {


            this.getResult()


            axios.get('get_currency').then((response) => {
                this.currency = response.data[0].Currency;
            })

            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)

            axios.get('./accounts/count_grn')
                .then(response => this.count_users = response.data)
                .catch(error => { });
        }
    }
</script>
