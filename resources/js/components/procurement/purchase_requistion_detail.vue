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
                                <router-link to="/accounts" style="text-decoration: none;" >Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Inventory Requisitions Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{count_req.total}}</h3>
                                        <span>Total Requisitions</span>
                                    </div>
                                    <div class="avatar bg-light-warning p-50">
                                        <span class="avatar-content" v-popover.left="{name:'foo', enent:'hover'}" @click="inv_reqCounter('all', 'Goods')">
                                            <i class="fa-solid fa-file"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{count_req.approved}}</h3>
                                        <span>Approved</span>
                                    </div>
                                    <div class="avatar bg-light-primary p-50">
                                        <span class="avatar-content" v-popover.left="{name:'foo'}" @click="inv_reqCounter('Approved', 'Goods')">
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{count_req.pending}}</h3>
                                        <span>Pending</span>
                                    </div>
                                    <div class="avatar bg-light-info p-50">
                                        <span class="avatar-content" v-popover.left="{name:'foo'}" @click="inv_reqCounter('Pending', 'Goods')">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{count_req.rejected}}</h3>
                                        <span>Rejected</span>
                                    </div>
                                    <div class="avatar bg-light-danger p-50">
                                        <span class="avatar-content" v-popover.left="{name:'foo'}" @click="inv_reqCounter('Rejected', 'Goods')">
                                            <i class="fa-duotone fa-file-xmark"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{count_req.issued}}</h3>
                                        <span>Issued</span>
                                    </div>
                                    <div class="avatar bg-light-success p-50">
                                        <span class="avatar-content" v-popover.left="{name:'foo'}" @click="inv_reqCounter('Issued', 'Goods')">
                                            <i class="fa-solid fa-file-import"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <popover name="foo" style="width:25%;">
                        <div class="card card-developer-meetup">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-1" v-for="dept_tot_req1 in dept_tot_req">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                                            <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                        </svg>
                                        <span class="fw-bold ms-75">{{dept_tot_req1.DepartmentName}}</span>
                                    </div>
                                    <span>{{dept_tot_req1.TotalReqs}}</span>
                                </div>
                            </div>
                        </div>
                    </popover>
                    <div class="row">
                        <div class="col-md-2">
                            <div  v-if="hasPermission('Purchase Requisition Merge')" class="dt-buttons d-inline-flex mt-50">
                                <router-link  style="float:left" to="/purchase/purchase_merge_requisition" class="btn btn-primary waves-effect"><i class="fa-regular fa-object-ungroup"></i> Merge Requisitions</router-link>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <ul class="nav nav-pills mb-2" style="padding-left:20px !important">
                                <li v-if="hasPermission('Purchase Requisition View Goods')"  class="nav-item col-md-4">
                                    <router-link to="/purchase/requistion_detail" class="nav-link active">
                                        <i class="fa-solid fa-warehouse"></i>
                                        <span class="fw-bold">Goods</span>
                                    </router-link>
                                </li>
                                <li v-if="hasPermission('Purchase Requisition View Assets')"  class="nav-item col-md-4">
                                    <router-link to="/purchase/purchase_assets_requisition" class="nav-link">
                                        <i class="fa-solid fa-car"></i>
                                        <span class="fw-bold">Assets</span>
                                    </router-link>
                                </li>
                                <li v-if="hasPermission('Purchase Requisition View Services')"  class="nav-item col-md-4">
                                    <router-link to="/purchase/purchase_services_requisition" class="nav-link">
                                        <i class="fa-solid fa-briefcase"></i>
                                        <span class="fw-bold">Services</span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div class="d-flex justify-content-around align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-12 col-lg-12 ps-xl-75 ps-0">
                                    <div class="card-body">
                                        <div class="row" style="">
                                            <div class="col-md-12">
                                                <div class="row g-1">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Department Name</label>
                                                        <select v-model="dept_name1" class="form-select mb-md-0 mb-2">
                                                            <option value="All">All Departments </option>
                                                            <option v-for="departments1 in departments" :value='departments1.department_name'>{{departments1.department_name}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Project Name</label>
                                                        <select v-model="proj_name" class="form-select mb-md-0 mb-2">
                                                            <option value="All">All Projects </option>
                                                            <option v-for="projects1 in projects" :value='projects1.ProjectName'>{{projects1.ProjectName}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label class="form-label">Status</label>
                                                        <select v-model="status" class="form-select mb-md-0 mb-2">
                                                            <option value="All"> All Status </option>
                                                            <option value="merged">Merged</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Issued">Issued</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div  class="col-md-2">
                                        <label class="form-label">Date From</label>
                                        <input type="date" v-model="startingdate" class="form-control" placeholder="" required="">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date To</label>
                                        <input type="date" class="form-control" v-model="closingdate" placeholder="" required="">
                                    </div>
                                                    <div class="col-md-1">
                                                        <button @click="filter_byStatus()" style="margin-left: 10px;background: rgb(193, 193, 193); width: 80% !important; height: 33px !important; margin-bottom: 20px; margin-top: 25px;" class="btn btn-secondary">Search</button>
                                                    </div>
                                                    <div class="col-md-2 ">
                                                        <input type="text" v-model="keyword1" class="form-control" style="margin-top: 25px;" placeholder="Inventory Req ID" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Requisition ID </th>
                                            <th class="sticky-th-center">Date </th>
                                            <th class="sticky-th-center">Department & Project</th>
                                            <th class="sticky-th-center">Type</th>
                                            <th class="sticky-th-center">Status</th>
                                            <th class="sticky-th-center">Actions</th>
                                            <th class="sticky-th-center">Received Quotations</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="adsdata1 in adsdata.data" :key="adsdata1">
                                        <tr v-if="new RegExp(keyword1, 'i').test(adsdata1.RId) || new RegExp(keyword1, 'i').test(adsdata1.RId2)">
                                            <td class="td-center" colspan="6">

                                                <div class="accordion accordion-border" id="accordionBorder">
                                                    <div class="accordion-item">
                                                        <div class="accordion-header d-flex" :id="'headingBorder'+adsdata1.RequisitionId">
                                                            <div class="col-md-2  mb-3 position-relative mx-1 sorting_1">
                                                                <div class="row">
                                                                    <div class="d-flex flex-column">
                                                                        <a class="user_name text-truncate text-body"><span class="fw-bolder">{{adsdata1.RId}} </span></a>
                                                                        <small class="emp_post text-muted">{{adsdata1.RId2}}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2  mb-3 position-relative mx-1" style="text-align:center;">{{adsdata1.Dated}} </div>
                                                            <div class="col-md-3  mb-3 position-relative mx-1">
                                                                <h6 class="user-name text-truncate mb-0">{{adsdata1.DepartmentName}}</h6><small class="text-truncate text-muted">{{adsdata1.ProjectName}}</small>

                                                            </div>
                                                            <div class="col-md-1  mb-3 position-relative mx-1" style="text-align:center;">{{adsdata1.RequisitionType}} </div>
                                                            <div class="col-md-1  mb-3 position-relative mx-1"  style="text-align:center;">
                                                                <a v-if="adsdata1.Status=='Approved'">
                                                                    <span v-if="adsdata1.q1==null && adsdata1.q2==null && adsdata1.q3==null && adsdata1.q4==null && adsdata1.q5==null && adsdata1.q6==null" class="badge bg-success">{{adsdata1.Status}}</span>
                                                                    <span v-else class="badge bg-success">{{adsdata1.Status}}</span>
                                                                </a>
                                                                <span v-else-if="adsdata1.Status=='Pending'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span>
                                                                <span v-else-if="adsdata1.Status=='Rejected'" class="badge badge-glow bg-danger">{{adsdata1.Status}}</span>
                                                                <span class="badge badge-glow bg-warning" v-else>{{adsdata1.Status}}</span>
                                                                <span v-if="adsdata1.state==1" class="badge badge-glow bg-success">Fully Issued</span>
                                                            </div>
                                                            <!-- <div class="col-md-2  mb-3 position-relative mx-1" v-else style="text-align:center;">
                                                                <span v-if="adsdata1.Status=='Approved'" class="badge bg-success">{{adsdata1.Status}}</span>
                                                                <span v-else-if="adsdata1.Status=='Pending'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span>
                                                                <span v-else-if="adsdata1.Status=='Rejected'" class="badge badge-glow bg-danger">{{adsdata1.Status}}</span>
                                                                <span class="badge badge-glow bg-warning" v-else>{{adsdata1.Status}}</span>
                                                                <span v-if="adsdata1.state==1" class="badge badge-glow bg-success">Fully Issued</span>
                                                            </div> -->
                                                            <div class="col-md-1  mb-1 position-relative" style="width: 10%; margin-left:5px;">
                                                                <div class="d-flex align-items-center col-actions">
                                                                    <a style="text-decoration:none;" class="me-1" href="#" data-bs-toggle="modal" @click="editRequisition(adsdata1.RequisitionId)" data-bs-target="#viewPREQ">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                    </a>
                                                                    <a class="dropdown-item button collapsed mx-1" @click="editReq(adsdata1.RequisitionId)" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder'+adsdata1.RequisitionId" aria-expanded="false" :aria-controls="'accordionBorder'+adsdata1.RequisitionId">
                                                                        <i class="fa-solid fa-circle-plus"></i>
                                                                    </a>
                                                                    <a v-if="adsdata1.Status=='Pending'" @click="editRequisition(adsdata1.RequisitionId)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editPREQ">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div :id="'accordionBorder'+adsdata1.RequisitionId" class="accordion-collapse collapse" :aria-labelledby="'headingBorder'+adsdata1.RequisitionId" :data-bs-parent="'#accordionBorder'+adsdata1.RequisitionId">
                                                            <div class="accordion-body" style="overflow-x: initial !important;">
                                                    <table class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="sticky-th-center">Sr.#</th>
                                                                            <th class="sticky-th-left">Item Name</th>
                                                                            <th class="sticky-th-center">Detail</th>
                                                                            <th class="sticky-th-center">Quantity</th>
                                                                            <th class="sticky-th-center">Unit</th>
                                                                            <th class="sticky-th-center">Estimated<br />Cost</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(get_request, index) in get_reqdata1">
                                                                            <td class="td-center">{{index+1}}</td>
                                                                            <td class="td-left">{{get_request.ItemName}}</td>
                                                                            <td class="td-left">{{get_request.Detail}}</td>
                                                                            <td class="td-center">{{get_request.Quantity}}</td>
                                                                            <td class="td-center">{{get_request.unit}}</td>
                                                                            <td class="td-center">{{currency}}. {{Number(get_request.EstCost)}}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td v-if="adsdata1.Status=='Approved' || adsdata1.Status=='Issued'" style="vertical-align: middle !important;font-size: 20px !important; width: 30% !important;">
                                                <div >
                                                    <div v-if="adsdata1.q1=='finalize'" class="badge">
                                                        <span class="badge btn btn-sm rounded-pill badge-light-success dropdown-toggle hide-arrow" @click="checkpo(adsdata1.RequisitionId,1)" data-bs-toggle="dropdown">Quotation 1</span>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-for="pono in po_nos" target="_blank" @click="po(pono.PurchaseOrderID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewPO">
                                                                <i class="fa-brands  fa-creative-commons-sa"></i>
                                                                {{pono.PoCode}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="adsdata1.q1=='Added'" class="badge">
                                                        <router-link :to="{ name: 'edit_quotation', params: { id:1,rid:adsdata1.RequisitionId}}" class="me-50">
                                                            <span class="badge  rounded-pill badge-light-primary">Quotation 1</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-else-if="adsdata1.q1==null" class="badge">
                                                        <router-link :to="{ name: 'create_quotation', params: { id: 1,rid:adsdata1.RequisitionId }}" class="me-50">
                                                            <span class="badge  rounded-pill badge-light-danger">Quotation 1</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-if="adsdata1.q2=='finalize'" class="badge">
                                                        <span class="badge btn btn-sm rounded-pill badge-light-success dropdown-toggle hide-arrow" @click="checkpo(adsdata1.RequisitionId,2)" data-bs-toggle="dropdown">Quotation 2</span>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-for="pono in po_nos" target="_blank" @click="po(pono.PurchaseOrderID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewPO">
                                                                <i class="fa-brands  fa-creative-commons-sa"></i>
                                                                {{pono.PoCode}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="adsdata1.q2=='Added'" class="badge">
                                                        <router-link :to="{ name: 'edit_quotation', params: { id:2,rid:adsdata1.RequisitionId}}" class="me-50">
                                                            <span class="badge  rounded-pill badge-light-primary">Quotation 2</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-else-if="adsdata1.q2==null && adsdata1.q1!=null" class="badge">
                                                        <router-link :to="{ name: 'create_quotation', params: { id: 2,rid:adsdata1.RequisitionId }}" class="me-50">
                                                            <span class="badge  rounded-pill badge-light-danger">Quotation 2</span>
                                                        </router-link>
                                                    </div>

                                                    <div v-if="adsdata1.q3=='finalize'" class="badge">
                                                        <span class="badge btn btn-sm rounded-pill badge-light-success dropdown-toggle hide-arrow" @click="checkpo(adsdata1.RequisitionId,3)" data-bs-toggle="dropdown">Quotation 3</span>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-for="pono in po_nos" target="_blank" @click="po(pono.PurchaseOrderID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewPO">
                                                                <i class="fa-brands  fa-creative-commons-sa"></i>
                                                                {{pono.PoCode}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="adsdata1.q3=='Added'" class="badge">
                                                        <router-link :to="{ name: 'edit_quotation', params: { id:3,rid:adsdata1.RequisitionId}}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-primary">Quotation 3</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-else-if="adsdata1.q3==null && adsdata1.q2!=null" class="badge">
                                                        <router-link :to="{ name: 'create_quotation', params: { id: 3,rid:adsdata1.RequisitionId }}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-danger">Quotation 3</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-if="adsdata1.q4=='finalize'" class="badge">
                                                        <span class="badge btn btn-sm rounded-pill badge-light-success dropdown-toggle hide-arrow" @click="checkpo(adsdata1.RequisitionId,4)" data-bs-toggle="dropdown">Quotation 4</span>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-for="pono in po_nos" target="_blank" @click="po(pono.PurchaseOrderID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewPO">
                                                                <i class="fa-brands  fa-creative-commons-sa"></i>
                                                                {{pono.PoCode}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="adsdata1.q4=='Added'" class="badge">
                                                        <router-link :to="{ name: 'edit_quotation', params: { id:4,rid:adsdata1.RequisitionId}}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-primary">Quotation 4</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-else-if="adsdata1.q4==null && adsdata1.q3!=null" class="badge">
                                                        <router-link :to="{ name: 'create_quotation', params: { id: 4,rid:adsdata1.RequisitionId }}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-danger">Quotation 4</span>
                                                        </router-link>
                                                    </div>

                                                    <div v-if="adsdata1.q5=='finalize'" class="badge">
                                                        <span class="badge btn btn-sm rounded-pill badge-light-success dropdown-toggle hide-arrow" @click="checkpo(adsdata1.RequisitionId,5)" data-bs-toggle="dropdown">Quotation 5</span>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-for="pono in po_nos" target="_blank" @click="po(pono.PurchaseOrderID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewPO">
                                                                <i class="fa-brands  fa-creative-commons-sa"></i>
                                                                {{pono.PoCode}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="adsdata1.q5=='Added'" class="badge">
                                                        <router-link :to="{ name: 'edit_quotation', params: { id:5,rid:adsdata1.RequisitionId}}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-primary">Quotation 5</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-else-if="adsdata1.q5==null && adsdata1.q4!=null" class="badge">
                                                        <router-link :to="{ name: 'create_quotation', params: { id: 5,rid:adsdata1.RequisitionId }}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-danger">Quotation 5</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-if="adsdata1.q6=='finalize'" class="badge">
                                                        <span class="badge btn btn-sm rounded-pill badge-light-success dropdown-toggle hide-arrow" @click="checkpo(adsdata1.RequisitionId,6)" data-bs-toggle="dropdown">Quotation 6</span>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-for="pono in po_nos" target="_blank" @click="po(pono.PurchaseOrderID)" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewPO">
                                                                <i class="fa-brands  fa-creative-commons-sa"></i>
                                                                {{pono.PoCode}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="adsdata1.q6=='Added'" class="badge">
                                                        <router-link :to="{ name: 'edit_quotation', params: { id:6,rid:adsdata1.RequisitionId}}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-primary">Quotation 6</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-else-if="adsdata1.q6==null && adsdata1.q5!=null" class="badge">
                                                        <router-link :to="{ name: 'create_quotation', params: { id: 6,rid:adsdata1.RequisitionId }}" class="me-50">
                                                            <span class="badge rounded-pill badge-light-danger">Quotation 6</span>
                                                        </router-link>
                                                    </div>
                                                    <div v-if="adsdata1.q1!=null" class="btn-group" style="float: right;width: 50px;">
                                                        <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="fa-solid fa-print"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a v-if="adsdata1.q2!=null" style="text-decoration:none;" class="dropdown-item" href="#" data-bs-toggle="modal" @click="comparativeHandler(adsdata1.RequisitionId)" data-bs-target="#viewComparative">
                                                                Comparative
                                                            </a>
                                                            <a target="_blank" v-bind:href="`Accounts/Quotation/1/${adsdata1.RequisitionId}`" class="dropdown-item">
                                                                Quotation 1
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.q2!=null" v-bind:href="`Accounts/Quotation/2/${adsdata1.RequisitionId}`" class="dropdown-item">
                                                                Quotation 2
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.q3!=null" v-bind:href="`Accounts/Quotation/3/${adsdata1.RequisitionId}`" class="dropdown-item">
                                                                Quotation 3
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.q4!=null" v-bind:href="`Accounts/Quotation/4/${adsdata1.RequisitionId}`" class="dropdown-item">
                                                                Quotation 4
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.q5!=null" v-bind:href="`Accounts/Quotation/5/${adsdata1.RequisitionId}`" class="dropdown-item">
                                                                Quotation 5
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.q6!=null" v-bind:href="`Accounts/Quotation/6/${adsdata1.RequisitionId}`" class="dropdown-item">
                                                                Quotation 6
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td v-else></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px" class="d-flex">
                                <pagination :data="adsdata" @pagination-change-page="getResult" :limit="5" style="margin-top: 25px;"></pagination>
                                <div>
                                    <label class="form-label" style="margin-left: 10px;">Page Size</label>
                                    <select v-model="pageSelect" style="margin-left: 10px;" class="form-select mb-md-0 mb-2" placeholder="Select">
                                        <option value="100">100</option>
                                        <option value="250">250</option>
                                        <option value="500">500</option>
                                        <option value="All">All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewComparative" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user" style="min-width: 1200px;">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <h3><strong>Comparative Report</strong> </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Comparative_report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="comaparapdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h3><strong>Comparative Report</strong> </h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" v-html="get_comp_data">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="table-responsive" style="padding: 30px; !important">
                        <table class="table" v-html="get_comp_data">
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="generateComparativeReport()" class="btn btn-gradient-info">Pdf</button>
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
                        <div class="card invoice-preview-card" v-for="requisitions1 in requisitions">
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
                                            RequisitionID:
                                            <span class="invoice-number">{{requisitions1.RId}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{requisitions1.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Req Type:</p>
                                            <p style="width:70%" class="invoice-date">{{requisitions1.RequisitionType}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="requisitions1.Status=='Approved'" class="badge badge-glow bg-primary">Approved</span>
                                                <span v-if="requisitions1.Status=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="requisitions1.Status=='Pending'" class="badge badge-glow bg-info">Pending</span>
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
                                        <h6 class="mb-2">Department/Child Company:</h6>
                                        <h6 class="mb-25">{{requisitions1.DepartmentName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Project Name:</h6>
                                        <p class="card-text mb-25">{{requisitions1.ProjectName}}</p>
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
                                            <th class="py-1">Detail</th>
                                            <th class="py-1">Quantity</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Est. Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_reqd in get_reqdata1">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_reqd.ItemName}}</p>
                                                <p class="card-text text-nowrap">
                                                </p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_reqd.Detail}}</span>
                                            </td>

                                            <td class="py-1">
                                                <span class="fw-bold">{{get_reqd.Quantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_reqd.unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{currency}}. {{Number(get_reqd.EstCost)}}</span>
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
                                            {{requisitions1.Narration}}
                                        </p>
                                    </div>
                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                            <option value=""> Select Status </option>

                                            <option value="Approved">Approve</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                        <span style="color: #DB4437; font-size:11px;" v-if="up_sts==''">{{e_up_sts}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                            <div class="col-12 text-center mt-2 pt-50">
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
        <div class="modal fade" id="viewPREQ" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="requisit in requisitions">
                            <div class="card-body invoice-padding pb-0">
                                <!-- Header starts -->
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div v-for='companydetail11 in companydetail' style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydetail11.company_name}}</h3>
                                        </div>
                                        <p class="card-text mb-25">Address: {{companydetail11.company_address}} , </p>
                                        <p class="card-text mb-25">City: {{companydetail11.city}} - {{companydetail11.country}}</p>
                                        <p class="card-text mb-0">Phone: {{companydetail11.phone_number}}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2" style="min-width:25%">
                                        <h5 class="invoice-title">
                                            RequisitionID:
                                            <span class="invoice-number">{{requisit.RId}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{requisit.Dated}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="">Requisition Type:</p>
                                            <p style="width:70%" class="  badge badge-glow bg-info invoice-date">{{requisit.RequisitionType}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="requisit.Status=='Approved'" class="badge badge-glow bg-primary">Approved</span>
                                                <span v-if="requisit.Status=='Issued'" class="badge badge-glow bg-warning">Issued</span>
                                                <span v-if="requisit.Status=='Pending'" class="badge badge-glow bg-info">Pending</span>
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
                                        <h6 class="mb-2">Department/Child Company:</h6>
                                        <h6 class="mb-25">{{requisit.DepartmentName}}</h6>
                                    </div>
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Project Name:</h6>
                                        <p class="card-text mb-25">{{requisit.ProjectName}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item</th>
                                            <th class="py-1">Detail</th>
                                            <th class="py-1">Quantity</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Est. Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_reqda in get_reqdata1">
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_reqda.ItemName}}</p>
                                                <p class="card-text text-nowrap">
                                                </p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_reqda.Detail}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_reqda.Quantity}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_reqda.unit}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{currency}}. {{Number(get_reqda.EstCost)}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{requisit.Narration}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
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
        <div class="modal fade" id="editPREQ" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card">
                            <!-- Header starts -->
                            <div class="card-body  pb-0">
                                <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0" style="margin-bottom:0px">
                                    <div v-for='companydeta11 in companydetail' style="margin-left:30px">
                                        <div style="padding-top:10px;margin-bottom: 0px;" class="logo-wrapper">
                                            <h3 class="text-primary invoice-logo" style="margin-left: 0px;">{{companydeta11.company_name}}</h3>
                                        </div>
                                        <p class="card-text mb-25">Address: {{companydeta11.company_address}} , </p>
                                        <p class="card-text mb-25">City: {{companydeta11.city}} - {{companydeta11.country}}</p>
                                        <p class="card-text mb-0">Phone: {{companydeta11.phone_number}}</p>
                                    </div>
                                    <div class="mt-md-0 mt-2 ">
                                        <div class="row">
                                            <p class="invoice-date-title" style="width:30%">Req ID:</p>
                                            <p style="width:70%" class="invoice-date">
                                                <input type="text" readonly v-model="e_rid" class="form-control invoice-edit-input " />
                                                <input type="text" hidden readonly v-model="id" class="form-control invoice-edit-input " />
                                            </p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date"> <input type="date" readonly v-model="date" class="form-control invoice-edit-input " /></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Header ends -->
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Edit Requistion</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                    <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                        <h6 class="invoice-to-title" style="margin-bottom:5px">Department/Company Name:</h6>
                                        <div class="invoice-customer">
                                            <input type="text" v-model="dept_name" class="form-control" readonly />
                                            <span style="color: #DB4437; font-size: 11px;" v-if="dept_name==''">{{e_dept_name}}</span>
                                        </div>
                                        <label class="form-label" for="basicSelect">Requisition Type</label>
                                        <input type="text" v-model="req_type" class="form-control" readonly />

                                    </div>
                                    <div class="col-xl-6 mb-lg-1 col-bill-to ps-0">
                                        <h6 class="invoice-to-title" style="margin-bottom:5px">Project Name:</h6>
                                        <div class="invoice-customer">
                                            <input type="text" v-model="project_name" class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body invoice-padding invoice-product-details" style="margin-top:30px">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-3" style="text-align: right;padding-top: 20px;">
                                        <button class="btn btn-primary" @click="sum_total()">Calculate Total</button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Total Qty</label>
                                            <input class="form-control" type="text" v-model="total_value" style="" />
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display:none">
                                        <div class="form-group">
                                            <label>Total Estimated</label>
                                            <input class="form-control" type="text" v-model="est_value" style="" />
                                        </div>
                                    </div>
                                </div>
                                <div v-for="get_reqdat in get_reqdata1" class="source-item" style="border: 1px solid rgb(235, 233, 241);border-radius: 0.357rem;margin-top: 20px;padding-left: 20px;padding-right: 20px;">
                                    <div data-repeater-list="group-a">
                                        <div class="repeater-wrapper" data-repeater-item>
                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                <div class="col-lg-6 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                    <p class="card-text col-title mb-md-50 mb-0" style="margin-bottom:0px !important">Item</p>
                                                    <select v-if="req_type=='Goods'|| req_type=='Assets'" class="form-select item-details" name="first[]">
                                                        <option :value='get_reqdat.itemId'>{{get_reqdat.ItemName}}</option>
                                                    </select>
                                                    <input hidden v-else type="text" name="first[]" value="empty">
                                                    <textarea class="form-control mt-2" rows="1" name="fiveth[]" placeholder="Item Detail">{{get_reqdat.Detail}}</textarea>
                                                    <input hidden :value='get_reqdat.unit' type="text" name="second[]">
                                                    <input hidden type="number" class="form-control" name="third[]" value="1" />
                                                </div>
                                                <div class="col-lg-3 col-12 my-lg-0 my-2">
                                                    <p class="card-text col-title mb-md-2 mb-0" style="margin-bottom:0px !important">Qty</p>
                                                    <textarea @keypress="onlyNumber" name="fourth[]" style="min-height: 0px !important;padding: 5px !important;margin-top: 0px !important;" class="form-control mt-2" rows="1">{{get_reqdat.Quantity}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group xz_form  row animated slideInDown" v-for="count in counter" :id="count" style="margin-top:10px">
                                    <div data-repeater-list="" class="col-lg-12">
                                        <slot class="source-item">
                                            <div data-repeater-list="group-a">
                                                <div class="repeater-wrapper" data-repeater-item>
                                                    <div class="row" style="margin-left: 2px;margin-right: 2px;">
                                                        <div class="col-12 d-flex product-details-border position-relative pe-0" style="border: 1px solid #ebe9f1;border-radius: 0.357rem;">
                                                            <div class="row w-100 pe-lg-0 pe-1 py-2">
                                                                <div class="col-lg-7 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                    <p class="card-text col-title mb-md-50 mb-0">Item</p>
                                                                    <select v-if="req_type=='Goods'|| req_type=='Assets'" class="form-select item-details" name="first[]">
                                                                        <option value=''>Select Item</option>
                                                                        <option v-for='get_items1 in get_items' :value='get_items1.ID'>{{ get_items1.Name}}</option>
                                                                    </select>

                                                                    <input hidden v-else type="text" name="first[]" value="empty">
                                                                    <input hidden type="text" name="second[]" value="empty">
                                                                    <input hidden type="number" class="form-control" name="third[]" value="1" />
                                                                    <textarea class="form-control mt-2" rows="1" name="fiveth[]" placeholder="Item Detail"></textarea>
                                                                </div>
                                                                <div class="col-lg-3 col-12 my-lg-0 my-2">
                                                                    <p class="card-text col-title mb-md-2 mb-0">Qty</p>
                                                                    <input type="number" class="form-control" name="fourth[]" value="1" placeholder="1" />
                                                                </div>


                                                            </div>
                                                            <div style="margin-left:10px" class="d-flex flex-column align-items-centerjustify-content-between border-start invoice-product-actions py-50 px-25">
                                                                <div class="delete_btn" style="border-radius:14px;">
                                                                    <div data-repeater-delete="" class="" style="margin-right: 6px;" v-on:click="delete_xz_form(count)">
                                                                        <span style="padding-top: 14px;padding-left: 7px;">
                                                                            <i class="fa-solid fa-xmark"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </slot>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-12 px-0" style="margin-left: 15px;">
                                        <div data-repeater-create="" class="btn btn-primary btn-sm btn-add-new" v-on:click="add_xz_repeater();">
                                            <i data-feather="plus" class="me-25"></i>
                                            <span class="align-middle">Add Item</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Total ends -->
                            <hr class="invoice-spacing mt-0" />
                            <div class="card-body invoice-padding py-0">
                                <!-- Invoice Note starts -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label for="note" class="form-label fw-bold">Narration:</label>
                                            <textarea class="form-control" v-model="narration" rows="2" id="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Note ends -->
                                <div class="col-12 text-center mt-2 pt-50" style="margin-bottom:20px">
                                    <button :disabled="disabled" @click="delay()" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
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
        <!-- END: Content-->
        <div class="modal fade" id="viewPO" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="perorders1 in perorders">
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
                                            PO ID:
                                            <span class="invoice-number">{{perorders1.PoCode}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{perorders1.PoDate}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:35%">Status:</p>
                                            <p style="width:65%" class="invoice-date">
                                                <span v-if="perorders1.Status2=='Received'" class="badge badge-light-warning">Received</span>
                                                <span v-if="perorders1.Status2=='Issued'" class="badge badge-light-success">Issued</span>
                                                <span v-if="perorders1.Status2=='Not Delivered'" class="badge badge-light-danger">Not Delivered</span>
                                                <span v-if="perorders1.Status2=='Not Completed'" class="badge badge-light-danger">Not Completed</span>
                                                <span v-if="perorders1.Status2=='Completed'" class="badge badge-light-success">Completed</span>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Purchase Order</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-6 p-0">
                                        <h6 class="mb-2 fw-bold">Against Requistion: {{perorders1.RId}}</h6>
                                    </div>
                                    <div class="col-xl-6 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2 fw-bold">Vendor Name: {{perorders1.vendorName}}</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item Name</th>
                                            <th class="py-1">Detail</th>
                                            <th class="py-1">OrderedQty</th>
                                            <th class="py-1">Unit</th>
                                            <th class="py-1">Cost</th>
                                            <th class="py-1">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="poProducts1 in poProducts">
                                            <td>
                                                <p class="card-text fw-bold mb-25">{{poProducts1.ItemName}}</p>
                                            </td>
                                            <td>
                                                <p class="card-text fw-bold mb-25">{{poProducts1.Detail}}</p>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{poProducts1.Quantity}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{poProducts1.Unit}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{currency}}. {{Number(poProducts1.Price).toLocaleString()}}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{currency}}. {{Number(poProducts1.SubTotal).toLocaleString()}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Narration:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{perorders1.Remarks}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Payment Term:</span>
                                        </p>
                                        <p class="card-text text-nowrap">
                                            {{perorders1.PaymentTerm}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
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
    </div>
</template>
<script>
    export default {
        data() {
            return {
                dept_name1: 'All',
                proj_name: 'All',
                departments: {},
                projects: {},
                toggle: false,
                currency: '',
                count_req: {},
                companydetail: {},
                adsdata: {},
                success: '',
                counter: 0,
                keyword1: '',
                dept_tot_req: {},
                status: 'All',
                date: '',
                e_rid: '',
                id: '',
                dept_name: '',
                project_name: '',
                narration: "",
                e_project_name: '',
                e_dept_name: '',
                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,
                up_sts: '',
                e_up_sts: '',
                req_type: '',
                pageSelect: '100',
                requisitions: {},
                get_unit: {},
                get_dept: {},
                get_project: {},
                get_items: {},
                get_comp_data: {},
                total_value: '',
                est_value: '',
                get_reqdata1: {},
                po_nos: {},
                perorders: {},
                poProducts: {},
                closingdate: '',
                startingdate: '',
            }
        },
        methods: {
            onlyNumber($event) {
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }
            },
            editReq(id) {
                axios.get('accounts/get_req_data1/' + id)
                    .then(response => {
                        this.get_reqdata1 = response.data;
                    })
                this.adsdata.data.map((curEle) => {
                    return document.getElementById("accordionBorder" + curEle.RequisitionId).classList.remove("show")
                })
            },
            comparativeHandler(id) {
                axios.get('get_comparative_report/' + id)
                    .then(response => {
                        this.get_comp_data = response.data;
                    })

            },
            generateComparativeReport() {
                this.$refs.comaparapdf.generatePdf();

            },
            editRequisition(id) {
                axios.get('accounts/get_req_data/' + id)
                    .then(response => {
                        this.requisitions = response.data;
                        this.e_rid = response.data[0].RId
                        this.id = response.data[0].RequisitionId
                        this.date = response.data[0].Dated
                        this.req_type = response.data[0].RequisitionType
                        this.dept_name = response.data[0].DepartmentName
                        this.narration = response.data[0].Narration
                        this.up_sts = response.data[0].Status
                        axios.get('accounts/get_projects/' + this.dept_name)
                            .then(response => this.get_project = response.data)
                        this.project_name = response.data[0].ProjectName

                        if (response.data[0].RequisitionType == 'Goods') {
                            axios.get('accounts/get_itemss')
                                .then(response => this.get_items = response.data)
                        }
                        else {
                            axios.get('accounts/get_services')
                                .then(response => this.get_items = response.data)
                        }
                    })
                axios.get('accounts/get_req_data1/' + id)
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
                }, 5000)
                this.update_preq();
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_preq_status();
            },
            update_preq_status() {
                if (this.up_sts == '') {
                    this.e_up_sts = "Select status";
                    this.$toastr.e("Please fill required fields!", "Caution!");
                } else {
                    this.e_up_sts = "";
                    axios.post('./accounts_upd_req_sts', {
                        reqId: this.id,
                        sts: this.up_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                this.getResult();
                                this.e_rid = "";
                                this.up_sts = "";
                            } else {
                                this.$toastr.e("Status not changed", "Error!");
                            }
                        })
                }
            },
            filter_byStatus(page = 1) {
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
                if (this.pageSelect == 'All') {
                    axios.get('accounts_fetch_reqBysts/' + this.status + '/' + this.dept_name1 + '/' + this.proj_name + '/' + this.startingdate1 + '/' + this.closingdate1 + '/' + this.pageSelect + '/?page=' + page)
                        .then(response => {
                            if (response.data == "Invalid department") {
                                this.$toastr.e("You do not have access to search other departments' requisition(s)", "Caution!");
                            }
                            else {
                                this.adsdata = response;
                            }
                        })
                        .catch(error => { });
                } else {
                    axios.get('accounts_fetch_reqBysts/' + this.status + '/' + this.dept_name1 + '/' + this.proj_name + '/' + this.startingdate1 + '/' + this.closingdate1 + '/' + this.pageSelect + '/?page=' + page)
                        .then(response => {
                            if (response.data == "Invalid department") {
                                this.$toastr.e("You do not have access to search other departments' requisition(s)", "Caution!");
                            }
                            else {
                                this.adsdata = response.data;
                            }
                        })
                        .catch(error => { });
                }
            },
            update_preq() {
                if (this.date == '' || this.dept_name == '') {
                    this.$toastr.e("Please Enter date and Department!", "Caution!");
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
                        var fw = detail[f];
                        o = o + "|" + fw.value;
                    }

                    axios.post('./accounts/update_requisition', {
                        item_name: k,
                        unit: l,
                        est_cost: m,
                        qty: n,
                        detail: o,
                        e_rid: this.e_rid,
                        id: this.id,
                        date: this.date,
                        dept_name: this.dept_name,
                        project_name: this.project_name,
                        narration: this.narration,
                        req_type: this.req_type,
                    })
                        .then(data => {
                            this.adsdata = data.data;
                            this.$toastr.s("Purchase requisition updated Successfully", "Congratulations!");
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
            getResult(page = 1) {
                if (this.pageSelect == 'All') {
                    axios.get('accounts/get_requisition', { params: { pages: this.pageSelect } })
                        .then(response => this.adsdata = response)
                        .catch(error => { });
                }
                else {
                    axios.get('accounts/get_requisition/?page=' + page, { params: { pages: this.pageSelect } })
                        .then(response => this.adsdata = response.data)
                        .catch(error => { });
                }
            },
            get_projectlist() {
                axios.get('accounts/get_projects/' + this.dept_name)
                    .then(response => this.get_project = response.data)
            },
            getResults(page = 1) {
                if (this.pageSelect == 'All') {
                    axios.get('accounts/searchbyreqid/' + this.keyword1 + '/' + this.pageSelect)
                        .then(response => {
                            this.adsdata = response
                        })
                } else {
                    axios.get('accounts/searchbyreqid/' + this.keyword1 + '/' + this.pageSelect + '/?page=' + page)
                        .then(response => {
                            this.adsdata = response.data
                        })
                        .catch(error => { console.log(error); });
                }
            },
            inv_reqCounter(status, type) {
                axios.get('accounts/inv_reqCounter/' + status + '/' + type)
                    .then(response => this.dept_tot_req = response.data)
            },
            checkpo(data, no) {
                axios.get('accounts/get_no_data/' + data + '/' + no)
                    .then(response => {
                        this.po_nos = response.data;
                    })
            },
            po(id) {
                axios.get('accounts_get_po_data/' + id)
                    .then(response => {
                        //                         this.e_id = id;
                        this.perorders = response.data;

                        //                         this.ed_narration = response.data[0].Remarks;
                        //                         this.vendor_n = response.data[0].vendorName;
                        //                         this.date = response.data[0].PoDate;
                        //                         this.status = response.data[0].Status;
                        //                         this.tax_amount = response.data[0].Tax;
                        //                         this.delivery_amount = response.data[0].ShippingCharges;
                        //                         this.discount = response.data[0].Discount;
                        //                         this.total = response.data[0].Total;
                        //                         this.reqid = response.data[0].AgainstReq;
                        //                         this.quoid = response.data[0].AgainstQuo;
                        axios.get('accounts_get_poProducts/' + id)
                            .then(response => this.poProducts = response.data)
                        //                         this.project_name = response.data[0].ProjectName
                    })
                axios.get('accounts/get_req_data1/' + id)
                    .then(response => {
                        this.get_reqdata1 = response.data;
                    })
            },
        },

        watch: {
            keyword1(after, before) {
                this.getResults();
            },
            pageSelect() {
                this.getResult();
            }
        },
        mounted() {


            this.getResult();

            axios.get('get_currency').then((response) => {
                this.currency = response.data[0].Currency;
            })



            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)

            axios.get('accounts/get_dept')
                .then(response => this.get_dept = response.data)

            axios.get('accounts/get_units')
                .then(response => this.get_unit = response.data)

            axios.get('accounts/count_requisitions')
                .then(response => this.count_req = response.data)

            axios.get('./overall_department')
                .then(response => this.departments = response.data)

            axios.get('./accounts/get_coaProjects')
                .then(response => this.projects = response.data)
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
