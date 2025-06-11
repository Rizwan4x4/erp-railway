
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
                                <router-link to="/dashboards/procurement" style="text-decoration: none;">Procurement Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Goods Received Notes
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
                                            <h3 class="fw-bolder mb-75">{{count_users.total}}</h3>
                                            <span>Total GRNs</span>
                                        </div>
                                        <div class="avatar bg-light-primary p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-users"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.fully}}</h3>
                                            <span>Fully Completed</span>
                                        </div>
                                        <div class="avatar bg-light-success p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-user-shield"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.partially}}</h3>
                                            <span>Partially Completed</span>
                                        </div>
                                        <div class="avatar bg-light-warning p-50">
                                            <span class="avatar-content">
                                                <i class="fa-solid fa-user-large-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div>
                                            <h3 class="fw-bolder mb-75">{{count_users.verified}}</h3>
                                            <span>Checked</span>
                                        </div>
                                        <div class="avatar bg-light-warning p-50">
                                            <span class="avatar-content">
                                                <i style="color:red" class="fa-solid fa-user-large-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div clas="card" style="background-color:white !important">
                            <div class="card-body border-bottom">
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="row g-1">

                                            <div class="col-md-2 user_plan">
                                                <label class="form-label">Status</label>
                                                <select v-model="status1" class="form-select mb-md-0 mb-2">
                                                    <option value="All">All Status</option>
                                                    <option value="Partially Completed">Partially Completed</option>
                                                    <option value="Fully Completed">Fully Completed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 user_status">
                                                <label class="form-label">Checked Status</label>
                                                <select v-model="status2" class="form-select text-capitalize mb-md-0 mb-2xx">
                                                    <option value="All">All Status</option>
                                                    <option value="Verified">Verified</option>
                                                    <option value="Not Verified">Not Verified</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-12 mb-2 position-relative">
                                                <label class="form-label">Date From</label>
                                                <input type="date" v-model="startingdate" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <label class="form-label">Date To</label>
                                                <input type="date" class="form-control" v-model="closingdate">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <button @click="filtered_GRN()" style="background: rgb(193, 193, 193); width: 60% !important; height: 33px !important; margin-bottom: 20px; margin-top: 25px; margin-left: 10px" class="btn btn-common">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="col-md-2 me-1">
                                            <router-link

                                            v-if="hasPermission('Inventory Grn create-grn') "
                                            to="/Inventory/create_grn" class="dt-button add-new btn btn-primary" tabindex="0" type="button"><span>+ Create GRN</span></router-link>
                                        </div>
                                        <div class="col-md-6 me-1"></div>
                                        <div class="col-md-4 me-1">
                                            <input type="text" v-model="keyword1" class="form-control" placeholder="Search by Vendor name / GRN / INV / PO id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">GRN ID & Date</th>
                                            <th class="sticky-th-left">Vendor Name</th>
                                            <th class="sticky-th-left">Department & Project</th>
                                            <th class="sticky-th-center">Type</th>
                                            <th class="sticky-th-center">GRN<br />Status</th>
                                            <th class="sticky-th-center">Actions</th>
                                            <th class="sticky-th-center" colspan="2">Accounts Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="adsdata1 in adsdata.data">
                                            <td class="td-center">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body">
                                                            <span>{{adsdata1.GrnID}}</span>
                                                        </a>
                                                        <small class="emp_post text-muted">{{adsdata1.Dated}}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-left">
                                                {{adsdata1.vendorName}}
                                            </td>
                                            <td class="td-left">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column"><a class="user_name text-truncate text-body"><span class="fw-bolder">{{adsdata1.DepartmentName}}</span></a><small class="emp_post text-muted">{{adsdata1.ProjectName}}</small></div>
                                                </div>
                                            </td>
                                            <td class="td-center">
                                                <span v-if="adsdata1.Status=='Fully Completed'" class="badge bg-light-info">Full</span>
                                                <span class="badge bg-light-primary" v-else-if="adsdata1.Status=='Partially Completed'">Partial</span>
                                            </td>
                                            <td class="td-center">
                                                <a @click="editgrn(adsdata1.GrnOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_status" v-if="adsdata1.Status2=='Not Verified'">
                                                    <span class="badge badge-glow bg-warning">{{adsdata1.Status2}}</span>
                                                </a>
                                                <span v-else-if="adsdata1.Status2=='Verified'" class="badge bg-success">{{adsdata1.Status2}}</span>
                                            </td>
                                            <td class="td-center">
                                                <div class="btn-group">
                                                    <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" @click="editgrn(adsdata1.GrnOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_view">
                                                            <i class="fa-solid fa-eye"></i>
                                                            View GRN
                                                        </a>
                                                        <a v-if="adsdata1.Status2 == 'Not Verified'"  class="dropdown-item" @click="editgrn(adsdata1.GrnOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_viewDelete">
                                                            <i class="fa-solid fa-trash"></i>
                                                            Delete GRN
                                                        </a>

                                                        <a class="dropdown-item" target="_blank" v-bind:href="`Accounts/Grn_letter/${adsdata1.GrnOrderID}/${adsdata1.GrnID}`">
                                                            <i class="fa-solid fa-print"></i>
                                                            Print GRN
                                                        </a>
                                                        <a class="dropdown-item" target="_blank" v-bind:href="`Accounts/pi_Letter/${adsdata1.ReceavingOrderID}/${adsdata1.FormID}`">
                                                            <i class="fa-solid fa-print"></i>
                                                            Print Invoice
                                                        </a>

                                                    </div>
                                                </div>
                                            </td>
                                            <!--
    <td class="td-center">
        <a class="me-25" @click="editgrn(adsdata1.GrnOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_view">
            <i class="fa-solid fa-eye"></i>
        </a>
        <a target="_blank" v-bind:href="`Accounts/Grn_letter/${adsdata1.GrnOrderID}/${adsdata1.GrnID}`" class="btn btn-sm">
            <i class="fa-solid fa-print"></i>
        </a>
    </td>-->
                                            <td  class="td-center">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body">
                                                            <span>{{adsdata1.FormID}}</span>
                                                        </a>
                                                        <span v-if="adsdata1.status8=='Verified'" class="badge bg-success">{{adsdata1.status8}}</span>
                                                        <span v-else-if="adsdata1.Status2=='Verified' && adsdata1.status8=='Not Verified'" @click="editgrn2(adsdata1.ReceavingOrderID)" data-bs-toggle="modal" data-bs-target="#PREQ_status2" class="badge badge-glow bg-warning">{{adsdata1.status8}}</span>
                                                        <span v-else class="badge bg-light-warning">{{adsdata1.status8}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- <td v-else class="td-center">
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <a class="user_name text-truncate text-body">
                                                            <span>{{adsdata1.FormID}}</span>
                                                        </a>
                                                        <span v-if="adsdata1.Status2=='Verified'" class="badge badge-glow bg-success">{{adsdata1.Status2}}</span>
                                                        <span v-else-if="adsdata1.Status2=='Not Verified'" class="badge bg-light-info">{{adsdata1.Status2}}</span>
                                                    </div>
                                                </div>
                                            </td> -->
                                            <!--
    <td>
        <a target="_blank" v-bind:href="`Accounts/pi_Letter/${adsdata1.ReceavingOrderID}/${adsdata1.FormID}`" class="btn btn-sm">
            <i class="fa-solid fa-print"></i>
        </a>
    </td>-->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center; padding-top:20px">
                                <pagination :limit="limit" :data="adsdata" v-if="pageNo==2" @pagination-change-page="getResults"></pagination>
                                <pagination :limit="limit" :data="adsdata" v-if="pageNo==1" @pagination-change-page="getResult"></pagination>
                                <pagination :limit="limit" :data="adsdata" v-if="pageNo==3" @pagination-change-page="filtered_GRN"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="PREQ_status2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata811 in get_grndata8">
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
                                            <span class="invoice-number">{{get_grndata811.FormID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata811.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="get_grndata811.Status2=='Verified'" class="badge badge-glow bg-success">Verified</span>
                                                <span v-if="get_grndata811.Status2=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="get_grndata811.Status2=='Not Verified'" class="badge badge-glow bg-info">Not Verified</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Update Invoice Status</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-6 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2 fw-bold">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata811.DepartmentName}}</p>
                                    </div>
                                    <div class="col-xl-6 p-0">
                                        <h6 class="mb-2 fw-bold">Project Name:</h6>
                                        <p class="card-text mb-25">{{get_grndata811.ProjectName}}</p>
                                    </div>
                                    <div class="col-xl-6 p-0">
                                        <h6 class="mb-2 fw-bold">Vendor Name:</h6>
                                        <h6 class="mb-25">{{get_grndata811.vendorName}}</h6>
                                    </div>
                                    <div class="col-xl-6 p-0">
                                        <h6 class="mb-2 fw-bold">Completion status:</h6>
                                        <p class="card-text mb-25"><span class="badge badge-glow bg-warning">{{get_grndata811.Status}}</span></p>
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
                                        <tr v-for="get_grndata21 in get_grndata81">
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
                                                <span class="fw-bold">{{Math.floor(get_grndata21.SubTotal).toLocaleString()}}</span>
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
                                    <div class="col-md-8 order-md-1 order-1 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{get_grndata811.Remarks}}
                                        </p>
                                        <p class="card-text text-nowrap">
                                            <div class="col-12  mt-2 pt-50 row">
                                                <div class="col-md-1" style="margin-top:21px">

                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <p class="card-text mb-0"><span style="width:100%" class="fw-bold">Update Status:</span></p>
                                                    <select v-model="eup_sts" class="form-select mb-md-0 mb-2">
                                                        <option value="">Select Status</option>
                                                        <option value="Verified">Verified</option>
                                                    </select>
                                                    <span style="color: #DB4437; font-size:11px;" v-if="eup_sts==''">{{e_up_sts}}</span>
                                                </div>
                                                <div class="col-md-5" style="margin-top:21px">
                                                    <button :disabled="disabled8" @click="delay8()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                        Cancle
                                                    </button>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="min-width: 200px;">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> SubTotal: {{currency}}. {{Number(get_grndata811.SubTotal)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Tax: {{currency}}. {{Number(get_grndata811.Tax)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">  Delivery : {{currency}}. {{Number(get_grndata811.ShippingCharges)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title"> Discount: {{currency}}. {{Number(get_grndata811.Discount)}}</p>
                                            </div>
                                            <div class="invoice-total-item">
                                                <p style="font-weight:bold" class="invoice-total-title">  Total: {{currency}}. {{Number(get_grndata811.TotalAmount)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                            <span class="invoice-number">{{get_grndata11.GrnID}}</span>
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
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Update GRN Status</div>
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
                                        <p class="card-text mb-25">class="badge badge-glow bg-warning">{{get_grndata11.Status}}</span></p>
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
                                            <th class="py-1">PoQuantity</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Received Quantity</th>
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
                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0"><span style="width:100%" class="fw-bold">Update Status:</span></p>
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
        <div class="modal fade" id="PREQ_viewDelete" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        np
                        <div class="modal-content">
                            <div class="modal-header bg-transparent">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-sm-5 pt-50">
                                <div class="text-center mb-2">
                                    <h1 class="fw-bolder">Confirmation</h1>
                                    <h5>Do you want to delete the GRN ?</h5>
                                    <div class="text-center">
                                        <button type="button"  @click="delete_GRN(get_id) " class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                        <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
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
                            <div class="card-body invoice-padding mx-2 pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div v-for='companydetail1 in companydetail'>
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
                                            <span class="invoice-number">{{get_grndata11.GrnID}}</span>
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
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Goods Received Note</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding mx-3 pt-0">
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
                            <div class="table-responsive mx-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Ordered qty</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Rcvd Qty</th>
                                            <th class="py-1">Item Expiry</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1"><p class="card-text fw-bold mb-25">{{get_grndata21.ItemName}}</p></td>
                                            <td class="py-1"><span class="fw-bold">{{get_grndata21.PoQuantity}}</span></td>
                                            <td class="py-1"><span class="fw-bold">{{get_grndata21.Unit}}</span></td>
                                            <td class="py-1"><span class="fw-bold">{{get_grndata21.RecvdQuantity}}</span></td>
                                            <td class="py-1"><span class="fw-bold">{{get_grndata21. ItemExpiry}}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding mx-3 pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                        <p class="card-text mb-0"><span style="width:100%" class="fw-bold">Narration:</span></p>
                                        <p class="card-text text-nowrap">{{get_grndata11.Remarks}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 mx-3 pb-2 pt-50">
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="PREQ_edit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="get_grndata1 in get_grndata">
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
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{get_grndata1.GrnID}}</span>
                                        </h5>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="title">Date:</span>
                                            <input v-model="date" type="date" class="form-control invoice-edit-input " />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="date==''">{{e_date}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Header ends -->
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Update GRN Status</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                    <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                        <div class="form-group">
                                            <h6 class="invoice-to-title" style="margin-bottom:5px">Against PO:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                            <div class="invoice-customer">
                                                <select v-model="grn_po" class="invoiceto form-select" disabled>
                                                    <option value="">Select PO</option>
                                                    <option v-for='get_vendors1 in get_vendors' :value='get_vendors1.PurchaseOrderID'>{{ get_vendors1.PoCode}}_{{ get_vendors1.VendorName}} (For {{get_vendors1.DepartmentName}}-{{get_vendors1.ProjectName}})</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h6 class="invoice-to-title" style="margin-bottom:5px">Invoice No:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                            <input type="text" v-model="invoice_no" class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-xl-6 p-0 ps-xl-2 mt-xl-0 mt-2">
                                        <div class="form-group">
                                            <h6 class="invoice-to-title" style="margin-bottom:5px">Vendor Name:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                            <div class="invoice-customer">
                                                <input type="text" v-model="vendor" readonly class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <h6 class="invoice-to-title" style="margin-bottom:5px">Status:<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                            <div class="invoice-customer">
                                                <input type="text" v-model="status" class="form-control" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Product Details starts -->
                            <div class="card-body invoice-padding invoice-product-details">
                                <div v-for="(get_po_detail11,index) in get_grnitems" class="source-item" style="border: 1px solid rgb(235, 233, 241); border-radius: 0.357rem;margin-top: 20px; padding-left: 20px; padding-right: 20px;">
                                    <div data-repeater-list="group-a">
                                        <div class="repeater-wrapper" data-repeater-item>
                                            <div class="row w-100 pe-lg-0 pe-1 py-2" style="min-width:103%">
                                                <div class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                    <p class="card-text col-title mb-md-2 mb-0">Item</p>
                                                    <select class="form-select" name="first[]" disabled>
                                                        <option :value='get_po_detail11.ItemId'>{{get_po_detail11.ItemName}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                    <p class="card-text col-title mb-md-2 mb-0">Ordered Qty</p>
                                                    <input :value='get_po_detail11.PoQuantity' type="number" readonly class="form-control" name="second[]" />
                                                </div>
                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                    <p class="card-text col-title mb-md-2 mb-0">Unit</p>
                                                    <input name="third[]" readonly :value='get_po_detail11.Unit' type="text" class="form-control" />
                                                </div>
                                                <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                    <p class="card-text col-title mb-md-2 mb-0">Received Qty</p>
                                                    <input name="fourth[]" type="number" class="form-control" /> <!--:value='get_po_detail11.RecvdQuantity'-->
                                                </div>
                                                <div class="col-lg-3 col-12 my-lg-0 my-2">
                                                    <p class="card-text col-title mb-md-2 mb-0">Date Expiry</p>
                                                    <input name="fifth[]" type="date" class="form-control" /> <!--:value='get_po_detail11.ItemExpiry'-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Details ends -->
                            <hr class="invoice-spacing mt-0" />
                            <div class="card-body invoice-padding py-0">
                                <!-- Invoice Note starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label for="note" class="form-label fw-bold">Narration:</label>
                                            <textarea class="form-control" v-model="ed_narration" rows="2" id="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Note ends -->
                                <div class="col-12 text-center mt-2 pt-50">
                                    <button :disabled="disabled1" @click="delay1()" class="btn btn-primary me-1">Update GRN</button>
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
</template>
<script>
    export default {
        data() {
            return {
                limit: 10,
                currency: 'Rs',
                e_up_sts: '',
                adsdata: {},
                companydetail: {},
                vendors: {},
                keyword1: '',
                vendor_name: 'All',
                status1: 'All',
                status2: 'All',
                startingdate1: '',
                closingdate1: '',
                closingdate: '',
                startingdate: '',
                get_grndata: {},
                get_grndata1: {},

                count_users: {},
                up_sts: '',
                get_id: '',
                disabled: false,
                timeout: null,
                pageNo:1,
                get_vendors: {},
                get_grnitems: {},
                date: '',
                e_date: '',
                grn_po: '',
                invoice_no: '',
                vendor: '',
                status: '',
                ed_narration: '',

                disabled1: false,
                timeout1: null,
                eget_id: '',
                eup_sts: '',
                disabled8: false,
                timeout8: null,
                get_grndata81: {},
                get_grndata8: {},
            }
        },
        methods: {
            delete_GRN(id) {
                axios.get('delete_GRN/' + id)
                    .then(data => {
                        if (data.data == 'GRN deleted') {
                            this.$toastr.s("GRN Deleted Successfully!", "Success");

                            this.getResult();
                        }
                        else {
                            this.$toastr.e("GRN Not Deleted!", "Error");
                        }
                    })
                    .catch(error => { });
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_grn();
            },
            update_grn() {
                if (this.date == '') {
                    this.e_date = "Enter date";
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    this.e_date = "";

                    var item_name = document.getElementsByName('first[]');
                    var orderedqty = document.getElementsByName('second[]');
                    var pro_unit = document.getElementsByName('third[]');
                    var rcvdqty = document.getElementsByName('fourth[]');
                    var expdate = document.getElementsByName('fifth[]');

                    var k = 'zero';
                    var n = 0;
                    var u = 0;
                    var o = 0;
                    var l = 0;

                    for (var i = 0; i < item_name.length; i++) {
                        var a = item_name[i];
                        k = k + "|" + a.value;
                    }
                    for (var h = 0; h < orderedqty.length; h++) {
                        var d = orderedqty[h];
                        n = n + "|" + d.value;
                    }
                    for (var f = 0; f < pro_unit.length; f++) {
                        var w = pro_unit[f];
                        u = u + "|" + w.value;
                    }
                    for (var z = 0; z < rcvdqty.length; z++) {
                        var e = rcvdqty[z];
                        o = o + "|" + e.value;
                    }
                    for (var j = 0; j < expdate.length; j++) {
                        var p = expdate[j];
                        l = l + "|" + p.value;
                    }

                    axios.post('./accounts_update_grn', {
                        item_name: k,
                        orderedqty: n,
                        pro_unit: u,
                        rcvdqty: o,
                        expdate: l,

                        get_id: this.get_id,
                        date: this.date,
                        grn_po: this.grn_po,
                        invoice_no: this.invoice_no,
                        vendor: this.vendor,
                        status: this.status,
                        ed_narration: this.ed_narration,
                    })
                        .then(data => {
                            if (data.data == "GRN updated") {
                                this.$toastr.s("GRN Updated Successfully", "Congratulations!");
                                this.getResult();
                                this.poProducts.length = 0;
                            }
                            else if (data.data == "Quantity error") {
                                this.$toastr.e("Invalid Received quantity", "Error!");
                            }
                            else if (data.data == "Select date") {
                                this.$toastr.e("Select Expiry Date", "Error!");
                            }
                            else {
                                this.$toastr.e("GRN Not Updated", "Error!");
                            }
                        })
                }
            },
            filtered_GRN(page = 1) {
             this.pageNo=3

                this.keyword1 = '';
                if (this.startingdate == '') {
                    this.startingdate1 = "00-00-0000";
                }
                else {
                    this.startingdate1 = this.startingdate;
                }
                if (this.closingdate == '') {
                    this.closingdate1 = "99-99-9999";
                }
                else {
                    this.closingdate1 = this.closingdate;
                }
                axios.get('./searchgrn9/' + this.status1 + '/' + this.status2 + '/' + this.startingdate1 + '/' + this.closingdate1 + '?page=' + page)
                    .then(data => this.adsdata = data.data)
                    .catch(error => this.error = error.response.data.errors)
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_grnstatus();
            },
            update_grnstatus() {
                axios.get('accounts/update_grn9/' + this.get_id + '/' + this.up_sts)
                    .then(response => {
                        if(response.data == "Total Amount cannot be negative"){
                            this.$toastr.e("Amount can not be Negative", "Errors!");
                        }
                        else if(response.data == "Status Updated"){
                        this.$toastr.s("Verified GRN Successfully", "Congratulations!");
                        const updatedIndex = this.adsdata.data.findIndex(item => item.GrnOrderID === this.get_id);
            if (updatedIndex !== -1) {

                this.adsdata.data[updatedIndex].Status2 =  this.up_sts;

                this.get_id = "";
                                this.up_sts = "";

                // Update other properties as needed
            }
                        }

                    })
            },
            editgrn(id) {
                this.get_id = id;
                axios.get('accounts/get_grn_data9/' + id)
                    .then(response => {
                        this.get_grndata = response.data;
                        this.date = response.data[0].Dated;
                        this.grn_po = response.data[0].POID;
                        this.invoice_no = response.data[0].InvoiceNo;
                        this.vendor = response.data[0].vendorName;
                        this.status = response.data[0].Status;
                        this.ed_narration = response.data[0].Remarks;
                    })
                axios.get('accounts/get_grn_data19/' + id)
                    .then(response => {
                        this.get_grnitems = response.data;
                        this.get_grndata1 = response.data;
                    })
            },
            editgrn2(id) {
                this.eget_id = id;
                axios.get('accounts/get_grn_data/' + id)
                    .then(response => {
                        this.get_grndata8 = response.data;
                    })

                axios.get('accounts/get_grn_data1/' + id)
                    .then(response => {
                        this.get_grndata81 = response.data;
                        this.pv_id = response.data[0].ReceavingOrderID;
                    })
            },

            delay8() {
                this.disabled8 = true
                this.timeout8 = setTimeout(() => {
                    this.disabled8 = false
                }, 5000)
                this.update_preq_status();
            },
            update_preq_status() {
                if (this.eup_sts == '' || this.eget_id == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.eup_sts == '') {
                        this.e_up_sts = "Select status";
                    }
                }
                else {
                    axios.post('./accounts/update_v_inv_grn', {
                        get_id: this.eget_id,
                        sts: this.eup_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                const updatedIndex = this.adsdata.data.findIndex(item => item.ReceavingOrderID === this.eget_id);
            if (updatedIndex !== -1) {

                this.adsdata.data[updatedIndex].status8 =  this.eup_sts;

                this.eget_id = "";
                                this.eup_sts = "";

                // Update other properties as needed
            }

                            }
                            else{
                                this.$toastr.e(data.data, "Caution!");
                                this.getResult();
                                this.eget_id = "";
                                this.eup_sts = "";
                            }
                        })
                }
            },

            getResult(page = 1) {
             this.pageNo=1
                axios.get('accounts/grn_detail9?page=' + page)
                    .then(response => this.adsdata = response.data)

            },

            getResults(page = 1) {
             this.pageNo=2
                this.vendor_name = 'All';
                this.status1 = 'All';
                this.status2 = 'All';
                this.startingdate = '';
                this.closingdate = '';
                axios.get('./accounts_grnbyVendor9?page=' + page, { params: { name: this.keyword1 } })
                    .then(response => {
                        this.adsdata = response.data})
                    .catch(error => { });
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            },
        },
        mounted() {
            this.getResult();
            axios.get('./accounts/get_vendor')
                .then(response => this.vendors = response.data)



            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
            axios.get('./accounts/count_grn9')
                .then(response => this.count_users = response.data)
                .catch(error => { });
            axios.get('./accounts/get_POdetail')
                .then(response => {
                    this.get_vendors = response.data})
        }
    }

</script>
