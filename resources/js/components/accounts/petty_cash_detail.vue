<template>
    <div>
        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Petty Cash Details
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="row">
                                    <div class="col-md-2 col-12 mb-2">
                                        <label class="form-label">Date From</label>
                                        <input type="date" v-model="startingdate" class="form-control">
                                    </div>
                                    <div class="col-md-2 col-12 mb-3">
                                        <label class="form-label">Date To</label>
                                        <input type="date" class="form-control" v-model="closingdate">
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label class="form-label">ID / Department</label>
                                        <input type="text" placeholder="ID or Department name" class="form-control" v-model="keyword">
                                    </div>
                                    <div class="col-md-1 col-12 mb-3">
                                        <button @click="filtered_GRN()" style="margin-top: 25px" class="btn btn-secondary">Search</button>
                                    </div>
                                    <div class="col-md-1 col-12 mb-3">
                                        <button @click="startingdate='', closingdate='', filtered_GRN()" style="margin-top: 25px" class="btn btn-outline-secondary waves-effect">Clear</button>
                                    </div>
                                    <div class="col-md-1 col-12 mb-3">
                                    </div>
                                    <div class="col-md-2 col-12 mb-3">
                                        <router-link v-if="hasPermission('Accounting petty-cash create-pettycash')" to="/create_petty_cash" class="btn btn-primary" style="margin-top: 25px"><span>+ New Petty Cash</span></router-link>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">P. Cash ID</th>
                                            <th class="sticky-th-center">Date</th>
                                            <th class="sticky-th-center">Department</th>
                                            <th class="sticky-th-center">Bill Amount</th>
                                            <th class="sticky-th-center">Remaining</th>
                                            <th class="sticky-th-center">Aproval</th>
                                            <th class="sticky-th-center">Verification</th>
                                            <th class="sticky-th-center" colspan="2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="adsdata1 in adsdata.data">
                                            <td class="td-center">{{adsdata1.PettyID}}</td>
                                            <td class="td-center">{{adsdata1.PettyDate}}</td>
                                            <td class="td-center fw-bold">{{adsdata1.DeptName}}</td>
                                            <td class="td-center"> {{Number(adsdata1.TotalAmount).toLocaleString()}}</td>
                                            <td class="td-center"> {{Number(adsdata1.Remaining).toLocaleString()}}</td>
                                            <td class="td-center" >
                                                <span v-if="adsdata1.Status1=='Approved'" class="badge badge-glow bg-primary">{{adsdata1.Status1}}</span>
                                                <span @click="editgrn(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#PREQ_status" v-else-if="adsdata1.Status1=='Pending'" class="badge badge-glow bg-info">{{adsdata1.Status1}}</span>
                                            </td>
                                            <!-- <td class="td-center" v-else>
                                                <span v-if="adsdata1.Status1=='Approved'" class="badge badge-glow bg-primary">{{adsdata1.Status1}}</span>
                                                <span v-else-if="adsdata1.Status1=='Pending'" class="badge badge-glow bg-info">{{adsdata1.Status1}}</span>
                                            </td> -->
                                            <td class="td-center" >
                                                <span v-if="adsdata1.Status2=='Verified'" class="badge badge-glow bg-success">{{adsdata1.Status2}}</span>
                                                <span @click="editgrn(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#PREQ_status1" v-else-if="adsdata1.Status2=='Not Verified'" class="badge badge-glow bg-danger">{{adsdata1.Status2}}</span>
                                            </td>
                                            <!-- <td class="td-center" v-else>
                                                <span v-if="adsdata1.Status2=='Verified'" class="badge badge-glow bg-success">{{adsdata1.Status2}}</span>
                                                <span v-else-if="adsdata1.Status2=='Not Verified'" class="badge badge-glow bg-danger">{{adsdata1.Status2}}</span>
                                            </td> -->
                                            <td class="td-left">
                                                <a  v-if="hasPermission('Accounting pettycash_access actions')" class="me-25" @click="editgrn(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#PREQ_view">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a v-if="hasPermission('Accounting pettycash_access actions')" target="_blank" v-bind:href="`Accounts/petty_Letter/${adsdata1.ID}/${adsdata1.PettyID}`" class="btn btn-sm">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                                <a  class="me-25" v-if="adsdata1.Status1=='Pending'&& hasPermission('Accounting pettycash_access actions')">
                                                    <router-link :to="`/edit_pettycash/${adsdata1.ID}`">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </router-link>
                                                </a>
                                            </td>
                                            <td class="td-center">
                                                <div class="d-flex align-items-center col-actions">
                                                    <div class="btn-group">
                                                        <a v-if="hasPermission('Accounting petty-cash edit-pettycash')" data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a @click="fetch_pcashid(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#apprfinance" class="dropdown-item" v-if="adsdata1.Status1=='Approved' && adsdata1.Status2=='Verified' && adsdata1.Remaining !=0">
                                                                <i class="fa-brands fa-amazon-pay"></i>
                                                                Pay
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.PaidAmount != null" v-bind:href="`Accounts/petty_Cash_bill/${adsdata1.ID}/${adsdata1.PettyID}`" class="btn">
                                                                <i class="fa-solid fa-print"></i> Print Bill
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="filtered_GRN"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="apprfinance" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <h1 class="text-center fw-bolder">Confirmation</h1>
                            <h5 class="text-center">Do you want to pay Petty Cash to {{p_dept}} Department?</h5>
                            <input type="text" class="form-control" hidden v-model="paid_id" />
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Department</label>
                                    <input type="text" readonly class="form-control" v-model="p_dept" />
                                </div>
                                <div class="col-md-3">
                                    <label>Petty Cash Limit</label>
                                    <input type="text" readonly class="form-control"  v-model="p_limit" />
                                </div>
                                <div class="col-md-3">
                                    <label>Remaining Amount</label>
                                    <input type="text" readonly class="form-control" v-model="p_remaining" />
                                </div>
                                <div class="col-md-6">
                                    <label>Pay Amount <span style="color: #DB4437; font-size: 11px;">*</span></label>
                                    <input placeholder="Please enter amount" type="text" class="form-control" v-model="paid_amount" />
                                </div>
                            </div>
                            <br>
                            <div class="text-center" style="text-align:center">
                                <button v-if="paid_amount!='' && paid_amount <= p_remaining" type="button" :disabled="disabled3" @click="delay3()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                <button v-else type="button" :disabled="disabled3" class="btn btn-danger waves-effect waves-float waves-light">Yes</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="PREQ_status1" tabindex="-1" aria-hidden="true">
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
                                            <span class="invoice-number">{{get_grndata11.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.PettyDate}}</p>
                                        </div>

                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <hr class="invoice-spacing">
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">

                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata11.DeptName}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item #</th>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Vendor Name</th>
                                            <th class="py-1">Bill Number</th>
                                            <th class="py-1">Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.ID}}</span>
                                            </td>
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemDetail}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.VendorName}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.BillNumber}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{currency}}. {{Number(get_grndata21.Amount)}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">

                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <select v-model="up_sts1" class="form-select mb-md-0 mb-2">
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
                                <button :disabled="disabled" @click="delay1()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Close
                                </button>
                            </div>
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
                                            <span class="invoice-number">{{get_grndata11.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.PettyDate}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <hr class="invoice-spacing">
                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row invoice-spacing">
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata11.DeptName}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item #</th>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Vendor Name</th>
                                            <th class="py-1">Bill Number</th>
                                            <th class="py-1">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.ID}}</span>
                                            </td>
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemDetail}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.VendorName}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.BillNumber}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{currency}}. {{Number(get_grndata21.Amount)}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">

                                    <div class="col-6 col-md-6 order-2">
                                        <p class="card-text mb-0">
                                            <span style="width:100%" class="fw-bold">Update Status:</span>
                                        </p>
                                        <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                            <option value=""> Select Status </option>
                                            <option value="Approved">Approved</option>
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
                                            <span class="invoice-number">{{get_grndata11.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{get_grndata11.PettyDate}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:65%">Approve Status:</p>
                                            <p style="width:35%" class="invoice-date">
                                                <span v-if="get_grndata11.Status1=='Approved'" class="badge badge-glow bg-primary">{{get_grndata11.Status1}}</span>
                                                <span v-if="get_grndata11.Status1=='Pending'" class="badge badge-glow bg-info">{{get_grndata11.Status1}}</span>
                                            </p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:55%">Verify Status:</p>
                                            <p style="width:45%" class="invoice-date">
                                                <span v-if="get_grndata11.Status2=='Verified'" class="badge badge-glow bg-success">{{get_grndata11.Status2}}</span>
                                                <span v-if="get_grndata11.Status2=='Not Verified'" class="badge badge-glow bg-danger">{{get_grndata11.Status2}}</span>
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
                                    <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                        <h6 class="mb-2">Department</h6>
                                        <p class="card-text mb-25">{{get_grndata11.DeptName}}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <!-- Invoice Description starts -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="py-1">Item #</th>
                                            <th class="py-1">Item Detail</th>
                                            <th class="py-1">Vendor Name</th>
                                            <th class="py-1">Bill Number</th>
                                            <th class="py-1">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="get_grndata21 in get_grndata1">
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.ID}}</span>
                                            </td>
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{get_grndata21.ItemDetail}}</p>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.VendorName}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{get_grndata21.BillNumber}}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{currency}}. {{Number(get_grndata21.Amount)}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-8 d-flex justify-content-end order-md-2 order-1">
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper" style="max-width: 300px;">
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
    </div>
</template>
<script>
    export default {
        data() {
            return {
                keyword:'',
                adsdata: {},
                currency: '',
                companydetail: {},
                startingdate1: '',
                closingdate1: '',
                closingdate: new Date().toJSON().slice(0, 10),
                startingdate: (new Date().toJSON().slice(0, 4))-1 + new Date().toJSON().slice(4, 10),
                get_grndata: {},
                get_grndata1: {},

                up_sts: '',
                up_sts1: '',
                get_id: '',
                disabled: false,
                disabled3: false,
                timeout: null,
                paid_id: '',
                p_limit: '',
                p_dept: '',

                p_remaining: '',
                paid_amount: '',
            }
        },
        methods: {
            fetch_pcashid(id) {
                this.paid_id = id
                axios.get('accounts/get_petty_access1/' + id)
                    .then((response) => {
                        this.p_limit = Number(response.data[0].TotalAmount);
                        this.p_dept = response.data[0].DeptName;
                        this.p_remaining = Number(response.data[0].Remaining);
                    })
            },
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.submit_paid();
            },
            submit_paid() {
                if (this.paid_amount > this.p_remaining) {
                    return this.$toastr.e("Paid Amount cannot be greater then your remaining amount!", "Caution!");
                }
                if (this.paid_id == '' || this.p_remaining == '' || this.paid_amount == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post('accounts/submit_paid_cash1', {
                        id: this.paid_id,
                        limit: this.p_remaining,
                        paid_amount: this.paid_amount,
                        dept: this.p_dept
                    })
                        .then((data) => {
                            if (data.data == 'Updated') {
                                this.getResult();
                                this.$toastr.s("Paid Amount To relevent Department!", "Congratulations!");
                            } else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                        })
                    // }
                }
            },
            filtered_GRN(page = 1) {
                if (this.startingdate == '') {
                    this.startingdate1 = "00-00-0000";
                } else {
                    this.startingdate1 = this.startingdate;
                }
                if (this.closingdate == '') {
                    this.closingdate1 = "99-99-9999";
                } else {
                    this.closingdate1 = this.closingdate;
                }
                if (this.keyword == '') {
                    this.keyword1 = "All";
                } else {
                    this.keyword1 = this.keyword;
                }
                axios.get('searchpetty_cash/' + this.startingdate1 + '/' + this.closingdate1 + '/' + this.keyword1 + '?page=' + page)
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
            delay1() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_grnstatus1();
            },
            update_grnstatus1() {
                axios.get('accounts/update_pettycash_status1/' + this.get_id + '/' + this.up_sts1)
                    .then(response => {
                        if (response.data == 'Status Update') {
                            this.$toastr.s("Status Updated Succesfully", "Congratulations!");
                            this.getResult();
                        }
                        else if (response.data == 'Amount Cannot be Negative'){
                            this.$toastr.e("Amount Cannot be Negative", "Errors!");

                        }
                        else{
                            this.$toastr.e(response.data, "Errors!");
                        }
                    })
            },
            update_grnstatus() {
                axios.get('accounts/update_pettycash_status/' + this.get_id + '/' + this.up_sts)
                    .then(response => {
                        if (response.data == 'Status Update') {
                            this.$toastr.s("Status Updated Succesfully", "Congratulations!");
                            this.getResult();
                        }
                    })
            },
            editgrn(id) {
                this.get_id = id;
                axios.get('accounts/pettyitem_details/' + id)
                    .then(response => {
                        this.get_grndata = response.data;
                    })
                axios.get('accounts/pettyitem_details1/' + id)
                    .then(response => {
                        this.get_grndata1 = response.data;
                    })
            },
            getResult(page = 1) {
                axios.get('accounts/petty_cash_details/?page=' + page)
                    .then(response => {
                        this.adsdata = response.data;
                    })
                    .catch(error => { });
            }
        },
        mounted() {
            this.filtered_GRN();
            this.getResult();
            axios.get('get_currency').then((response) => {
                this.currency = response.data[0].Currency;
            })
            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
        
        }
    }

</script>
