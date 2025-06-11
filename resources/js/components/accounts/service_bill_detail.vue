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
                            <li class="breadcrumb-item">
                                <router-link to="/accounts" style="text-decoration: none;">Accounts Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Service Bills
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
                                        <span>Total Bills</span>
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
                                        <h3 class="fw-bolder mb-75">{{count_req.notdelivered}}</h3>
                                        <span>Not Delivered</span>
                                    </div>
                                    <div class="avatar bg-light-danger p-50">
                                        <span class="avatar-content">
                                            <i class="bi bi-file-earmark-excel-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="fw-bolder mb-75">{{count_req.received}}</h3>
                                        <span>Received Bills</span>
                                    </div>
                                    <div class="avatar bg-light-warning p-50">
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
                                        <h3 class="fw-bolder mb-75">{{count_req.issued}}</h3>
                                        <span>Issued Bills</span>
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
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div style="margin-bottom:20px;padding-top:20px" class="d-flex justify-content-between align-items-center header-actions mx-2 row mt-75">
                                <div class="col-sm-6 col-lg-3 ps-xl-75 ps-0">
                                    <div class="dt-buttons d-inline-flex mt-50">
                                        <router-link style="float:left" to="/ServiceBill/Create" class="btn btn-primary waves-effect">Create Bill</router-link>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-9 ps-xl-75 ps-0">
                                    <div class="dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap">
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input @change="search_byDate(datefrom, dateto)" type="date" v-model="datefrom" class="form-control" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input @change="search_byDate(datefrom, dateto)" type="date" v-model="dateto" class="form-control" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-lg-1 ps-xl-75 ps-0">
                                            <div class="dt-buttons d-inline-flex mt-50">
                                                <a @click="clear()" style="float:left" class="btn btn-outline-secondary waves-effect">Clear</a>
                                            </div>
                                        </div>
                                        <div class="me-1">
                                            <div class="dataTables_filter" style="margin-top:5px">
                                                <label>
                                                    <input autocomplete="off" type="text" name="keyword1" v-model="keyword1" class="form-control" @change="getResults()" placeholder="Search By Name" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invoice_status ms-sm-2">
                                            <select id="UserRole" @change="filter_byStatus(status)" v-model="status" class="form-select ms-50 text-capitalize">
                                                <option value="All">Select Status</option>
                                                <option value="Not Delivered">Not Delivered</option>
                                                <option value="Received">Received Order</option>
                                                <option value="Issued">Issued Order </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">ID</th>
                                            <th style="text-align:center;">Date</th>
                                            <th>Contractor Name</th>
                                            <th style="text-align:center;">Workdone Amount</th>
                                            <th style="text-align:center;">Bill Amount</th>
                                            <th style="text-align:center;">Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata.data">
                                            <td style="text-align:center;" class="sorting_1"><a class="fw-bold"> {{adsdata1.ServiceBillId}}</a></td>
                                            <td style="text-align:center;">{{adsdata1.Dated}}</td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="user-name text-truncate mb-0">{{adsdata1.ContractorName}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align:center;">{{currency}}. {{Math.floor(adsdata1.WorkdoneAmount)}}</td>
                                            <td style="text-align:center;">{{currency}}. {{Math.floor(adsdata1.BillAmount)}}</td>
                                            <td style="text-align:center;">{{adsdata1.Status }}</td>
                                            <td style="text-align:center;">
                                                <div class="d-flex align-items-center col-actions">
                                                    <a class="me-25" data-bs-toggle="modal" @click="editPurOrder(adsdata1.PurchaseOrderID)" data-bs-target="#viewPO">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a target="_blank" v-bind:href="`Accounts/serviceBill/${adsdata1.ServiceBillId}`" class="dropdown-item">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Print PO
                                                        </a>
                                                        <a class="dropdown-item" v-if="adsdata1.RequisitionType=='Services'" target="_blank" v-bind:href="`Accounts/wordorder_letter/${adsdata1.PurchaseOrderID}/${adsdata1.PoCode}`">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            Print WorkOrder
                                                        </a>
                                                        <a class="dropdown-item" v-if="adsdata1.Status2=='Not Delivered'" @click="fetch_poid(adsdata1.PurchaseOrderID)" data-bs-toggle="modal" data-bs-target="#payloan1">
                                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                                            PO Reverse
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="text-align:center;padding-top:20px">
                                <pagination :data="adsdata" @pagination-change-page="getResult"></pagination>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                    <div class="modal fade" id="editPO" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user" style="min-width:65%">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="card invoice-preview-card" v-for="perorders1 in perorders">
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
                                                        PO ID:
                                                        <span class="invoice-number">{{perorders1.PoCode}}</span>
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
                                            <div class="divider-text" style="font-size: 24px;font-weight: 900;">Edit Purchase Order</div>
                                        </div>
                                        <!-- Address and Contact starts -->
                                        <div class="card-body invoice-padding pt-0">
                                            <div class="row row-bill-to invoice-spacing" style="margin-top:0px">
                                                <div class="col-xl-6 mb-lg-1 col-bill-to ps-0" style="margin:5px;">
                                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Against Requistion & Quotation<span style="color: #DB4437; font-size: 11px;">*</span></h6>
                                                    <div class="invoice-customer">
                                                        <select v-model="vendor_n" class="invoiceto form-select" disabled>
                                                            <option value="">Select Quotation</option>
                                                            <option v-for='requisitions1 in requisitions' :value='requisitions1.VendorName'>{{ requisitions1.RId}}_{{requisitions1.VendorName}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Vendor Name</label>
                                                        <input v-model="vendor_n" type="text" class="form-control" readonly />
                                                    </div>
                                                    <input hidden v-model="reqid" type="text" class="form-control" readonly />
                                                    <input hidden v-model="quoid" type="text" class="form-control" readonly />
                                                    <div class="mb-1">
                                                        <label class="form-label" for="basicSelect">Ordered Status</label>
                                                        <label style="color: #d93025">*</label>
                                                        <div class="demo-inline-spacing">
                                                            <div class="form-check form-check-inline" style="margin-top:0px">
                                                                <input class="form-check-input" type="radio" v-model="status" name="inlineRadioOptions" id="inlineRadio1" value="Full" checked="">
                                                                <label class="form-check-label" for="inlineRadio1">Full</label>
                                                            </div>
                                                            <div class="form-check form-check-inline" style="margin-top:0px">
                                                                <input class="form-check-input" type="radio" v-model="status" name="inlineRadioOptions" id="inlineRadio2" value="Partial">
                                                                <label class="form-check-label" for="inlineRadio2">Partial</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 p-0 ps-xl-2 mt-xl-0 mt-2" style="border:1px solid lightgrey;border-radius:4px !important">
                                                    <h6 class="mb-2">Payment Details:</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Address and Contact ends -->
                                        <!-- Product Details starts -->
                                        <div class="card-body invoice-padding invoice-product-details">
                                            <div v-for="(get_po_detail11,index) in poProducts" class="source-item" style="border: 1px solid rgb(235, 233, 241); border-radius: 0.357rem;margin-top: 20px; padding-left: 20px; padding-right: 20px;">
                                                <div data-repeater-list="group-a">
                                                    <div class="repeater-wrapper" data-repeater-item>
                                                        <div class="row w-100 pe-lg-0 pe-1 py-2" style="min-width:103%">
                                                            <div class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                <p class="card-text col-title mb-md-2 mb-0">Item</p>
                                                                <select class="form-select" name="first[]" disabled>
                                                                    <option :value='get_po_detail11.ItemId'>{{get_po_detail11.ItemName}}</option>
                                                                </select>
                                                                <textarea class="form-control mt-2" rows="1" name="seventh[]" readonly placeholder="Item Detail">{{get_po_detail11.Detail}}</textarea>
                                                            </div>


                                                            <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                <p class="card-text col-title mb-md-2 mb-0">Quote</p>
                                                                <input :value='get_po_detail11.QuoteQuantity' type="number" readonly class="form-control" name="fiveth[]" />
                                                            </div>
                                                            <div class="col-lg-2 col-12 my-lg-0 my-2" style="max-width:13%;">
                                                                <p class="card-text col-title mb-md-2 mb-0">Ordered Qty</p>
                                                                <input @change="sum_total()" type="number" class="form-control" name="fourth[]" />
                                                            </div>
                                                            <div class="col-lg-1 col-12 my-lg-0 my-2" style="min-width:13%">
                                                                <p class="card-text col-title mb-md-2 mb-0">Unit Cost</p>
                                                                <input name="third[]" readonly type="number" class="form-control" :value='Number(get_po_detail11.Price)' />
                                                            </div>
                                                            <div class="col-lg-2 col-12 my-lg-0 my-2" style="max-width:15%;">
                                                                <p class="card-text col-title mb-md-2 mb-0">Unit</p>
                                                                <input name="sixth[]" readonly type="text" class="form-control" :value='get_po_detail11.Unit' />
                                                            </div>
                                                            <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                <p class="card-text col-title mb-md-2 mb-0">Price</p>
                                                                <p readonly name="second[]" :id="'demo_'+(index)" class="form-control card-text col-title mb-md-50 mb-0" style="padding-left: 10px; max-width: 100px; height: 35px;"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Product Details ends -->
                                        <!-- Invoice Total starts -->
                                        <div class="card-body invoice-padding">
                                            <div class="row invoice-sales-total-wrapper">
                                                <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                                </div>
                                                <div class="col-md-6 d-flex justify-content-end order-md-2 order-2">
                                                    <div class="invoice-total-wrapper">
                                                        <div class="invoice-total-item label">
                                                            <p class="invoice-total-title">Subtotal:</p>
                                                        </div>
                                                        <div class="invoice-total-item label">
                                                            <p class="invoice-total-title">Tax:</p>
                                                        </div>
                                                        <div class="invoice-total-item label">
                                                            <p class="invoice-total-title">Delivery:</p>
                                                        </div>
                                                        <div class="invoice-total-item label">
                                                            <p class="invoice-total-title">Discount:</p>
                                                        </div>
                                                        <div class="invoice-total-item label" style="margin-top:25px !important">
                                                            <p class="invoice-total-title">Total:</p>
                                                        </div>
                                                    </div>
                                                    <div class="invoice-total-wrapper">
                                                        <div class="invoice-total-item">
                                                            <p class="invoice-total-amount">
                                                                <input v-model="subtotal" type="number" class="form-control" readonly />
                                                            </p>
                                                        </div>
                                                        <div class="invoice-total-item">
                                                            <p class="invoice-total-amount">
                                                                <input v-model="tax_amount" type="number" class="form-control" readonly />
                                                            </p>
                                                        </div>
                                                        <div class="invoice-total-item">
                                                            <p class="invoice-total-amount">
                                                                <input v-model="delivery_amount" type="number" class="form-control" readonly />
                                                            </p>
                                                        </div>
                                                        <div class="invoice-total-item">
                                                            <p class="invoice-total-amount">
                                                                <input @change="sum_total()" v-model="discount" type="number" class="form-control" />
                                                            </p>
                                                        </div>
                                                        <hr class="my-50" />
                                                        <div class="invoice-total-item">
                                                            <p class="invoice-total-amount">
                                                                <input v-model="total" type="number" class="form-control" readonly />
                                                            </p>
                                                        </div>
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
                                                        <textarea class="form-control" v-model="ed_narration" rows="2" id="note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Invoice Note ends -->
                                            <div class="col-12 text-center mt-2 pt-50">
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
                                                        <span class="invoice-number">{{perorders1.PurchaseOrderID}}</span>
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
                                                <div class="col-xl-8 p-0">
                                                    <h6 class="mb-2">Against Requistion & Quotation:</h6>
                                                    <h6 class="mb-25">{{perorders1.AgainstReq}}</h6>
                                                </div>
                                                <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                                    <h6 class="mb-2">Vendor Name:</h6>
                                                    <p class="card-text mb-25">{{perorders1.vendorName}}</p>
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
                                                        <th class="py-1">OrderedQty</th>
                                                        <th class="py-1">Unit</th>
                                                        <th class="py-1">Cost</th>
                                                        <th class="py-1">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="poProducts1 in poProducts">
                                                        <td class="py-1">
                                                            <p class="card-text fw-bold mb-25">{{poProducts1.ItemName}}</p>
                                                            <p class="card-text text-nowrap">
                                                            </p>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{poProducts1.Quantity}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{poProducts1.Unit}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{currency}}. {{Math.floor(poProducts1.Price)}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{currency}}. {{Math.floor(poProducts1.SubTotal)}}</span>
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
            </div>
        </div>
        <!-- END: Content-->
        <!-- Pay loan Modal -->
        <div class="modal fade" id="payloan1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <center>
                                <div class="col-md-12">
                                    <h6>Are You Sure To Reverse The PO?</h6>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" :disabled="disabled3" @click="delay3()" class="btn btn-primary me-1 mt-2" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                                        No
                                    </button>
                                </div>
                            </center>
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
                status: 'All',
                poProducts: {},
                perorders: {},
                count_req: {},
                companydetail: {},
                adsdata: {},
                success: '',
                keyword1: '',
                datefrom: '',
                dateto: '',

                datef1rom1: '',
                dateto1: '',
                currency: '',

                po: '',
                e_po: '',

                date: '',
                vendor_n: '',
                e_date: '',
                e_vendor_n: '',
                ed_narration: '',

                subtotal: '',
                tax_amount: '',
                delivery_amount: '',
                discount: '',
                total: '',
                quoid: '',
                reqid: '',
                e_id: '',

                test: 0,
                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,
                requisitions: {},

                po_id: '',
                disabled3: false,
                timeout3: null,
            }
        },
        methods: {
            delay3() {
                this.disabled3 = true
                this.timeout3 = setTimeout(() => {
                    this.disabled3 = false
                }, 5000)
                this.submit_reverse()

            },
            submit_reverse() {
                axios.get('Accounts/reverse_po/' + this.po_id)
                    .then(response => {
                        if (response.data == 'submitted') {
                            this.$toastr.s("Reverse PO Successfully", "Congratulations!");
                            this.getResult();
                            this.po_id = '';
                        }

                    })

            },
            fetch_poid(id) {
                this.po_id = id;
            },
            sum_total() {
                var third = document.getElementsByName('third[]');
                var fourth = document.getElementsByName('fourth[]');
                var m = 0;

                for (var g = 0; g < fourth.length; g++) {
                    var c = fourth[g];
                    var b = third[g];

                    var demo_id = "demo" + g;
                    document.getElementById("demo_" + g).innerHTML = Number(b.value) * Number(c.value);
                    m = Number(m) + (Number(b.value) * Number(c.value));
                }
                this.subtotal = m;
            },
            clear() {
                this.datefrom = "";
                this.dateto = "";
                this.getResult();
            },
            filter_byStatus(sts, page = 1) {
                this.keyword1 = "";
                this.datefrom = "";
                this.dateto = "";
                axios.get('accounts_fetch_PObySts/' + sts + '/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
            editPurOrder(id) {
                axios.get('accounts_get_po_data/' + id)
                    .then(response => {

                        this.e_id = id;
                        this.perorders = response.data;
                        this.ed_narration = response.data[0].Remarks;
                        this.vendor_n = response.data[0].vendorName;
                        this.date = response.data[0].PoDate;
                        this.status = response.data[0].Status;
                        this.tax_amount = response.data[0].Tax;
                        this.delivery_amount = response.data[0].ShippingCharges;
                        this.discount = response.data[0].Discount;
                        this.total = response.data[0].Total;
                        this.reqid = response.data[0].AgainstReq;
                        this.quoid = response.data[0].AgainstQuo;
                        axios.get('accounts_get_poProducts/' + id)
                            .then(response => this.poProducts = response.data)
                        this.project_name = response.data[0].ProjectName
                    })
                axios.get('accounts/get_req_data1/' + id)
                    .then(response => {
                        this.get_reqdata1 = response.data;
                    })
            },
            clear_array() {
                this.poProducts.length = 0;
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_po();
            },
            update_po() {
                if (this.date == '' || this.vendor_n == '') {

                    if (this.date == '') {
                        this.e_date = "Error";
                    }
                    else {
                        this.e_date = "";
                    }
                    if (this.vendor_n == '') {
                        this.e_vendor_n = "Error";
                    }
                    else {
                        this.e_vendor_n = "";

                    }

                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    var item_name = document.getElementsByName('first[]');
                    var item_price = document.getElementsByName('second[]');
                    var est_cost = document.getElementsByName('third[]');
                    var qty = document.getElementsByName('fourth[]');
                    var quoteqty = document.getElementsByName('fiveth[]');
                    var pro_unit = document.getElementsByName('sixth[]');
                    var detail = document.getElementsByName('seventh[]');
                    var k = 'zero';
                    var l = 0;
                    var m = 0;
                    var n = 0;
                    var o = 0;
                    var u = 0;
                    var itemdetail = 'zero';
                    for (var f = 0; f < pro_unit.length; f++) {
                        var w = pro_unit[f];
                        u = u + "|" + w.value;
                    }
                    for (var i = 0; i < item_name.length; i++) {
                        var a = item_name[i];
                        k = k + "|" + a.value;
                    }

                    for (var j = 0; j < item_price.length; j++) {
                        var p = item_price[j];
                        l = l + "|" + p.value;
                    }

                    for (var g = 0; g < est_cost.length; g++) {
                        var c = est_cost[g];
                        m = m + "|" + c.value;
                    }

                    for (var h = 0; h < qty.length; h++) {
                        var d = qty[h];
                        n = n + "|" + d.value;
                    }
                    for (var z = 0; z < quoteqty.length; z++) {
                        var e = quoteqty[z];
                        o = o + "|" + e.value;
                    }
                    for (var dw = 0; dw < detail.length; dw++) {
                        var fw = detail[dw];
                        itemdetail = itemdetail + "|" + fw.value;
                    }
                    axios.post('./accounts_update_purchaseorder', {
                        e_id: this.e_id,
                        item_name: k,
                        price: l,
                        unit_cost: m,
                        orderedqty: n,
                        quoteqty: o,
                        pro_unit: u,
                        detail: itemdetail,
                        quoid: this.quoid,
                        reqid: this.reqid,
                        ed_narration: this.ed_narration,
                        date: this.date,
                        vendor_n: this.vendor_n,
                        subtotal: this.subtotal,
                        discount: this.discount,
                        tax_amount: this.tax_amount,
                        delivery_amount: this.delivery_amount,
                        total: this.total,
                        status: this.status,
                    })
                        .then(data => {
                            if (data.data == "PO updated") {
                                this.$toastr.s("Purchase Order Updated Successfully", "Congratulations!");
                                this.getResult();
                                this.clear_array();
                            }

                            else if (data.data == "Empty field") {
                                this.$toastr.e("Please enter ordered quantity", "Caution!");
                            }
                            else if (data.data == "Quantity error") {
                                this.$toastr.e("Invalid ordered quantity", "Error!");
                            }
                        })
                }
            },
            getResult(page = 1) {
                axios.get('accounts/get_serviceBill/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
            getResults(page = 1) {
                this.status = "All";
                this.datefrom = "";
                this.dateto = "";
                axios.get('./accounts_PObyName/?page=' + page, { params: { name: this.keyword1 } })
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
             search_byDate(datefrom, dateto, page = 1) {
                this.keyword1 = "";
                this.status = "All";
                if (datefrom == '') {
                    this.datefrom1 = 'All';
                } else {
                    this.datefrom1 = datefrom;
                }
                if (dateto == '') {
                    this.dateto1 = 'All';
                } else {
                    this.dateto1 = dateto;
                }
                axios.get('accounts_get_servicebill_bydate/' + this.datefrom1 + '/' + this.dateto1 + '/?page=' + page)
                    .then(response => {
                        this.adsdata = response.data;
                    })
            },
            intervalFetchData: function () {
                setInterval(() => {
                    this.total = Number(this.subtotal) + Number(this.delivery_amount) + Number(this.tax_amount) - Number(this.discount);
                }, 1000);
            },
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        mounted() {
            axios.get('get_currency').then((response) => {
                this.currency = response.data[0].Currency;
            })
            this.getResult();
            axios.get('./accounts/get_quotationdetaill')
                .then(response => this.requisitions = response.data)
            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
            axios.get('accounts/count_purchase')
                .then(response => this.count_req = response.data)
            this.intervalFetchData();
            this.sum_total();
        }
    }

</script>
<style scoped>
    .card-title {
        margin-bottom: 8px !important;
        margin-top: 15px !important;
    }

    .label {
        height: 32px;
        vertical-align: middle;
        margin-top: 8px;
        margin-right: 12px;
        margin-bottom: 15px;
    }
</style>
