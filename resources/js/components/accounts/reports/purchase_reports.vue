
<template>
    <div>
    <h6 class="mb-25 fw-bold">
                                <i class="fa-solid fa-basket-shopping" style="padding-right: 10px"></i>
                                Purchase Reports
                            </h6>
                             <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#DemandRequisitionReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
                                    <span>
                                        Demands (DR) Report
                                    </span>
                                </a>
                               <a data-bs-toggle="modal" data-bs-target="#RequisitionTrackingReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Demand (DR) Tracking Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#RequisitionReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        PR Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#RequisitionComparativeDetailReport">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Search Single PR Detail
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#QuotationComparativeToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Comparative Quotations
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#PurchaseOrderReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Purchase Order Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#PurchaseGRNReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Single PO Detail
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#OpenPosToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Open POs Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" @click="advance_po_paid()" data-bs-target="#AdvancePaid">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        POs Advance Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#PurchaseInvoiceReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Purchase Invoices Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#PurchaseReturnReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Purchase Returns Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#VendorBalanceToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Vendors Balance Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#Unpaid_Pur_InvoToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Unpaid Purchase Invoices
                                    </span>
                                </a>
                            </div>
                          

<!--Start Demand Requistion Report -->
 <div class="modal fade" id="DemandRequisitionReportToggle" aria-labelledby="DemandRequisitionReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Demand Requistion Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="demand_start_date1" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="demand_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_dept1" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Demand Requisition ID</label>
                                    <multiselect style="margin-right: 10px;" @input="getItemsdemand()" v-model="demand_rid" :options="optionsdemand1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_proj" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Item Name</label>

                                    <select v-model="req_demand_items" class="form-select">
                                        <option value="All">Select item</option>
                                        <option v-for="demand_item_list1 in demand_item_list" :value="demand_item_list1.itemId" :key="demand_item_list1">
                                            {{ demand_item_list1.ItemName }}</option>
                                    </select>
                                    <p class="text-danger">for items, first select demand requisition id</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <a target="_blank" v-bind:href="`Accounts/DemandRequisition_Letter1/${req_dept1}/${demand_rid}/${req_proj}/${req_demand_items}/${demand_start_date1}/${demand_end_date}`" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>  -->
                    <div class="modal-footer">
  <a  target="_blank" @click=generateDemandReportUrl() class="btn btn-primary">
    View Report
  </a>
  <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
</div>

                </div>
            </div>

        </div>
 <!--End Demand Requistion Report -->
       
<!--Start Demand Requisition Tracking Report -->
<div class="modal fade" id="RequisitionTrackingReportToggle" aria-labelledby="RequisitionTrackingReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Demand Requisition Tracking Reportss</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Demand Requisition ID</label>
                                    <multiselect style="margin-right: 10px;" v-model="demand_id" :options="optionsdemand1">
                                    </multiselect>
                                </div>
                                <span style="color: #db4437; font-size: 11px" v-if="demand_id == ''">{{ e_demand_id
                                    }}</span>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" class="btn btn-primary" @click="demand_report()">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
 <!--End Demand Requisition Tracking Report -->
 <!--Start Requistion Report -->
 <div class="modal fade" id="RequisitionReportToggle" aria-labelledby="RequisitionReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Requistion Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="req_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="req_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_dept2" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">RequisitionID</label>
                                    <multiselect style="margin-right: 10px;" @input="getItems()" v-model="req_rid" :options="optionsrid1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_proj1" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Item Name</label>

                                    <select v-model="req_items" class="form-select">
                                        <option value="All">Select item</option>
                                        <option v-for="items_details1 in items_details" :value="items_details1.itemId" :key="items_details1">{{ items_details1.ItemName }}</option>
                                    </select>
                                    <p class="text-danger">for products, first select requisition id</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="generatePRReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

        </div> 
 <!--End Requistion Report -->
<!--Start Requisition Detail Report  -->
 <div class="modal fade" id="RequisitionComparativeDetailReport" aria-labelledby="RequisitionComparativeDetailReport" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="requ_detail_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Requisition Detail Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Select Requisition</label>

                                    <multiselect style="margin-right: 10px;" v-model="req__det_iq" :options="options_r_iss">
                                    </multiselect>
                                    <span style="color: #DB4437; font-size:11px;" v-if="req__det_iq == ''">{{ e_req__det_iq }}</span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="req_detail_summary()">
                            View Report
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg req_modal_toggle" style="min-width: 1200px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Requisition Detail Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="req_detail_summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="requisition_detail_report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="reqdpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h4 class="modal-title" id="myModalLabel16">Requisition Detail Report</h4>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Req.
                                                    Id</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Department Name</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Project Name</th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Est. Cost</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <tr v-for="get_reqdata11 in get_reqdata" :key="get_reqdata11">
                                                <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.Dated }}</td>
                                                <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.RId }}</td>
                                                <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.DepartmentName }}</td>
                                                <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.ProjectName }}</td>
                                            </tr>
                                            <tr v-for="get_reqdata22 in get_reqdata1" :key="get_reqdata22">
                                                <td style="border-style: none !important;">{{ get_reqdata22.ItemCode }}
                                                </td>
                                                <td style="border-style: none !important;">{{ get_reqdata22.ItemName }}
                                                </td>
                                                <td style="border-style: none !important;">
                                                    {{ Number(get_reqdata22.Quantity) }}</td>
                                                <td style="border-style: none !important;">{{ get_reqdata22.unit }}</td>
                                                <td style="border-style: none !important;">
                                                    {{ Number(get_reqdata22.EstCost) }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Issuance Id</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Department Name</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Project Name</th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Req. Quantity</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Issuance Qty</th>
                                            </tr>

                                        </thead>
                                        <tbody v-html="get_issudata"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body " id="req_det_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">

                        </div>
                        <div class="table-responsive ">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Req. Id</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Department
                                            Name</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Project Name
                                        </th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Est. Cost</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="get_reqdata11 in get_reqdata" :key="get_reqdata11">
                                        <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.Dated }}</td>
                                        <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.RId }}</td>
                                        <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.DepartmentName }}</td>
                                        <td :rowspan="get_reqdata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.ProjectName }}</td>
                                    </tr>
                                    <tr v-for="get_reqdata22 in get_reqdata1" :key="get_reqdata22">
                                        <td style="border-style: none !important;">{{ get_reqdata22.ItemCode }}</td>
                                        <td style="border-style: none !important;">{{ get_reqdata22.ItemName }}</td>
                                        <td style="border-style: none !important;">{{ Number(get_reqdata22.Quantity) }}
                                        </td>
                                        <td style="border-style: none !important;">{{ get_reqdata22.unit }}</td>
                                        <td style="border-style: none !important;">{{ Number(get_reqdata22.EstCost) }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Issuance Id
                                        </th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Department
                                            Name</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Project Name
                                        </th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Req. Quantity</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Issuance Qty</th>
                                    </tr>

                                </thead>
                                <tbody v-html="get_issudata"></tbody>

                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'req_det_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateReqDetReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="req_detail_summary1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!--End Requisition Detail Report  -->
<!--Start Quotation Comparative Report -->
<div class="modal fade" id="QuotationComparativeToggle" aria-labelledby="QuotationComparativeToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Quotation Comparative Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="qc_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="qc_end_date" type="date" class="form-control" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">RequisitionID</label>
                                    <multiselect style="margin-right: 10px;" @input="getItems2()" v-model="qc_rid" :options="optionsrid1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Venor Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="qc_vendor" :options="optionsqc">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Item Name</label>

                                    <select v-model="qc_items" class="form-select">
                                        <option value="All">Select item</option>
                                        <option v-for="items_details1 in items_details_qc" :value="items_details1.ItemId" :key="items_details1">
                                            {{ items_details1.ItemName }}</option>
                                    </select>
                                    <p class="text-danger">for products, first select requisition id</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="generateCompartiveQutationReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

        </div>
<!--End Quotation Comparative Report -->

<!-- Start Purchase Order Report -->
<div class="modal fade" id="PurchaseOrderReportToggle" aria-labelledby="PurchaseOrderReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Purchase Order Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="po_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="po_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Vendor Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="po_vendor_name" :options="options1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_dept3" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="po_proj" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">GRN Check</label>
                                    <multiselect style="margin-right: 10px;" v-model="po_grn_check" :options="optionsgrn">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">PO Created By</label>
                                    <multiselect style="margin-right: 10px;" v-model="po_create_by" :options="optionspocreated">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">PO Type</label>
                                    <multiselect style="margin-right: 10px;" v-model="po_type" :options="optionspotype">
                                    </multiselect>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="  generatePurchaseOrderReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

        </div>
<!-- End Purchase Order Report -->

<!-- Start Purchase Order Detail Report -->
<div class="modal fade" id="PurchaseGRNReportToggle" aria-labelledby="PurchaseGRNReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="po_grn_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Purchase Order Detail Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Select Purchase Order Id</label>

                                    <multiselect style="margin-right: 10px;" v-model="po_grn_id" :options="options_po_grn">
                                    </multiselect>
                                    <span style="color: #DB4437; font-size:11px;" v-if="po_grn_id == ''">{{ e_po_grn_id }}</span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="po_grn_summary()">
                            View Report
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg req_modal_toggle" style="min-width: 1200px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Purchase Order Detail Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="po_grn_summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="requisition_detail_report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="pogrnpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h4 class="modal-title" id="myModalLabel16">Purchase Order Detail Report</h4>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important; text-align: center;">Date</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">PO. Id
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Vendor
                                                    Name</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Amount
                                                </th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Quote Quantity</th>
                                                <th scope="col">PO Qty</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Cost</th>
                                                <th scope="col">SubTotal</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <tr v-for="get_reqdata11 in get_podata" :key="get_reqdata11">
                                                <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.PoDate }}</td>
                                                <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.PoCode }}</td>
                                                <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ get_reqdata11.vendorName }}</td>
                                                <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                                    {{ Number(get_reqdata11.TotalAmount) }}</td>
                                            </tr>
                                            <tr v-for="get_reqdata22 in get_podata1" :key="get_reqdata22">
                                                <td style="border-style: none !important;">{{ get_reqdata22.ItemCode }}
                                                </td>
                                                <td style="border-style: none !important;">{{ get_reqdata22.ItemName }}
                                                </td>
                                                <td style="border-style: none !important;">
                                                    {{ Number(get_reqdata22.QuoteQuantity) }}</td>
                                                <td style="border-style: none !important;">
                                                    {{ Number(get_reqdata22.Quantity) }}</td>
                                                <td style="border-style: none !important;">{{ get_reqdata22.Unit }}</td>
                                                <td style="border-style: none !important;">
                                                    {{ Number(get_reqdata22.Price) }}</td>
                                                <td style="border-style: none !important;">
                                                    {{ Number(get_reqdata22.SubTotal) }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">GRN Id
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Status
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Verify
                                                    Status</th>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Po. Quantity</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Recvd Qty</th>
                                                <th scope="col">Price</th>
                                            </tr>

                                        </thead>
                                        <tbody v-html="get_grn_data"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body " id="po_grn_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">

                        </div>
                        <div class="table-responsive ">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">PO. Id</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Vendor Name
                                        </th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Amount</th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Quote Quantity</th>
                                        <th scope="col">PO Qty</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">SubTotal</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="get_reqdata11 in get_podata" :key="get_reqdata11">
                                        <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.PoDate }}</td>
                                        <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.PoCode }}</td>
                                        <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ get_reqdata11.vendorName }}</td>
                                        <td :rowspan="get_podata_count + 1" style="border-style: none !important; min-width: 100px !important;">
                                            {{ Number(get_reqdata11.TotalAmount) }}</td>
                                    </tr>
                                    <tr v-for="get_reqdata22 in get_podata1" :key="get_reqdata22">
                                        <td style="border-style: none !important;">{{ get_reqdata22.ItemCode }}</td>
                                        <td style="border-style: none !important;">{{ get_reqdata22.ItemName }}</td>
                                        <td style="border-style: none !important;">
                                            {{ Number(get_reqdata22.QuoteQuantity) }}</td>
                                        <td style="border-style: none !important;">{{ Number(get_reqdata22.Quantity) }}
                                        </td>
                                        <td style="border-style: none !important;">{{ get_reqdata22.Unit }}</td>
                                        <td style="border-style: none !important;">{{ Number(get_reqdata22.Price) }}</td>
                                        <td style="border-style: none !important;">{{ Number(get_reqdata22.SubTotal) }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important; text-align: center;">Date</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">GRN Id</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Status</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Verify Status
                                        </th>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Po. Quantity</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Recvd Qty</th>
                                        <th scope="col">Price</th>
                                    </tr>

                                </thead>
                                <tbody v-html="get_grn_data"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'po_grn_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generatePOGRNDetReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="po_grn_summary1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- Start Purchase Order Detail Report -->

 <!-- Open pos Report -->
 <div class="modal fade" id="OpenPosToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="OpenPos1_Data_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Open POs Data Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="OpenPos_Data_report1()"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="OpenPos_Data_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="OpenPos_Data_start_date == ''">{{ e_OpenPos_Data_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="OpenPos_Data_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="OpenPos_Data_end_date == ''">{{
                                            e_OpenPos_Data_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" @input="OpenPos_dept_projects()" v-model="OpenPos_Data_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="OpenPos_Data_project" :options="OpenPos_projects">
                                    </multiselect>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="OpenPos_Data_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" @click="OpenPos_Data_report1()">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width:1300px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Open POs Data Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="OpenPos_Data_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true"  @hasDownloaded="pdfL1=false" :preview-modal="false" :paginate-elements-by-height="5000" filename="OpenPos_Data__Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1000px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="OpenPos">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date1:</strong> {{ this.OpenPos_Data_start_date }} To
                                        {{ this.OpenPos_Data_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th class="reports-th-center" scope="col">ItemCode</th>
                                                <th class="reports-th-center" scope="col">Description</th>
                                                <th class="reports-th-center" scope="col">UOM</th>
                                                <th class="reports-th-center" scope="col">Quant Qty</th>
                                                <th class="reports-th-center" scope="col">Department</th>
                                                <th class="reports-th-center" scope="col">Type</th>
                                                <th class="reports-th-center" scope="col">PO #</th>
                                                <th class="reports-th-center" scope="col">PO Qty</th>
                                                <th class="reports-th-center" scope="col">PO Date</th>
                                                <th class="reports-th-center" scope="col">Unit Price</th>
                                                <th class="reports-th-center" scope="col">Amount</th>
                                                <th class="reports-th-center" scope="col">Status</th>
                                                <th class="reports-th-center" scope="col">Project Name</th>
                                                <th class="reports-th-center" scope="col">Vendor Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="trail_d1 in OpenPos_Data_dorb_d">
                                                <td class="td-center">{{ trail_d1.ItemCode }}</td>
                                                <td class="td-center">{{ trail_d1.Description }}</td>
                                                <td class="td-center">{{ trail_d1.Uom }}</td>
                                                <td class="td-center">{{ Number(trail_d1.Q_Qty).toLocaleString() }}</td>
                                                <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                                <td class="td-center">{{ trail_d1.Type }}</td>
                                                <td class="td-center">{{ trail_d1.PoCode }}</td>
                                                <td class="td-center">{{ Number(trail_d1.PO_Qty).toLocaleString() }}</td>
                                                <td class="td-center">{{ trail_d1.PODate }}</td>
                                                <td class="td-center">{{ Number(trail_d1.UnitPrice).toLocaleString() }}</td>
                                                <td class="td-center">{{ Number(trail_d1.Amount).toLocaleString() }}</td>
                                                <td class="td-center">{{ trail_d1.Status }}</td>
                                                <td class="td-center">{{ trail_d1.Project }}</td>
                                                <td class="td-center">{{ trail_d1.VendorName }}</td>

                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="OpenPos_Data_Report">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.OpenPos_Data_start_date }} To
                                {{ this.OpenPos_Data_end_date }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th class="reports-th-center" scope="col">ItemCode</th>
                                        <th class="reports-th-center" scope="col">Description</th>
                                        <th class="reports-th-center" scope="col">UOM</th>
                                        <th class="reports-th-center" scope="col">Quant Qty</th>
                                        <th class="reports-th-center" scope="col">Department</th>
                                        <th class="reports-th-center" scope="col">Type</th>
                                        <th class="reports-th-center" scope="col">PO #</th>
                                        <th class="reports-th-center" scope="col">PO Qty</th>
                                        <th class="reports-th-center" scope="col">PO Date</th>
                                        <th class="reports-th-center" scope="col">Unit Price</th>
                                        <th class="reports-th-center" scope="col">Amount</th>
                                        <th class="reports-th-center" scope="col">Status</th>
                                        <th class="reports-th-center" scope="col">Project Name</th>
                                        <th class="reports-th-center" scope="col">Vendor Name</th>
                                    </tr>
                                </thead>
                                <div v-if="Loader1" class="row">
                                     <div class="col-12 d-flex justify-content-center position-absolute">
                                         <div class="d-flex align-items-center">
                                             <div class="spinner-border text-secondary me-2" role="status">
                                             </div>
                                             <span class="loader-message">{{ Loader1 ? 'Processing data.This may take a few minutes...' : 'Please wait...' }}</span>
                                         </div>
                                     </div>
                                </div>
                                <tbody>
                                    <tr v-for="trail_d1 in OpenPos_Data_dorb_d">
                                        <td class="td-center">{{ trail_d1.ItemCode }}</td>
                                        <td class="td-center">{{ trail_d1.Description }}</td>
                                        <td class="td-center">{{ trail_d1.Uom }}</td>
                                        <td class="td-center">{{ Number(trail_d1.Q_Qty).toLocaleString() }}</td>
                                        <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                        <td class="td-center">{{ trail_d1.Type }}</td>
                                        <td class="td-center">{{ trail_d1.PoCode }}</td>
                                        <td class="td-center">{{ Number(trail_d1.PO_Qty).toLocaleString() }}</td>
                                        <td class="td-center">{{ trail_d1.PODate }}</td>
                                        <td class="td-center">{{ Number(trail_d1.UnitPrice).toLocaleString() }}</td>
                                        <td class="td-center">{{ Number(trail_d1.Amount).toLocaleString() }}</td>
                                        <td class="td-center">{{ trail_d1.Status }}</td>
                                        <td class="td-center">{{ trail_d1.Project }}</td>
                                        <td class="td-center">{{ trail_d1.VendorName }}</td>

                                    </tr>
                                </tbody>
                                <div v-if="OpenPos_Data_dorb_d.length==0" class="row">
                                     <div class="col-12 d-flex justify-content-center position-absolute">
                                         <div class="d-flex align-items-center">
                                             <h3> No Data... </h3>
                                         </div>
                                     </div>
                                </div>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'OpenPos_Data_Report')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateOpenPosReport()" class="btn btn-gradient-info">
                            <i v-if="pdfL1" class="spinner-border spinner-border-sm"></i>
                            Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="OpenPos_Data_report1()">close</button>
                    </div>
                </div>
            </div>
 </div>
 <!--end Open pos Report -->
<!-- Start Advance Paid Against PO -->
 <div class="modal fade" id="AdvancePaid" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered modal-lg" style="min-width:1300px">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel16">Advance Paid Against PO</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Advance_Paid_po" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="advancepopdf">
            <div slot="pdf-content">
                <div class="modal-body">
                    <div style="margin-top: 20px;margin-bottom: 20px;">

                    </div>
                 
                    <div  class="table-responsive" style="overflow-x: initial !important;">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col" style="    min-width: 100px;">PO ID #</th>
                                    <th scope="col">Payment Voucher ID</th>
                                    <th scope="col">Payment Received By</th>
                                    <th scope="col">Voucher Date</th>
                                    <th scope="col">Vendor Name</th>
                                    <th scope="col">PO Status</th>
                                    <th scope="col">PO Amount</th>
                                    <th scope="col">Paid Amount</th>
                                </tr>
                            </thead>
                           
                            <tbody >
                                <tr  v-for="advancepo_list in advancepo_list">
                                    <td>{{ advancepo_list.PoCode }}</td>
                                    <td>{{ advancepo_list.PVNO }}</td>
                                    <td>{{ advancepo_list.SalesPerson }}</td>
                                    <td>{{ advancepo_list.Date }}</td>
                                    <td>{{ advancepo_list.vendorName }}</td>
                                    <td>{{ advancepo_list.Status2 }}</td>

                                    <td>{{ Number(advancepo_list.TotalAmount).toLocaleString() }}</td>
                                    <td>{{ Number(advancepo_list.Amount).toLocaleString() }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </vue-html2pdf>
        <div class="modal-body" id="advance_po">
            <div style="margin-top: 20px;margin-bottom: 20px;">
            </div>
            <div class="table-responsive" style="overflow-x: initial !important;">
                <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col" style="    min-width: 100px;">PO ID #</th>
                                    <th scope="col">Payment Voucher ID</th>
                                    <th scope="col">Payment Received By</th>
                                    <th scope="col">Voucher Date</th>
                                    <th scope="col">Vendor Name</th>
                                    <th scope="col">PO Status</th>
                                    <th scope="col">PO Amount</th>
                                    <th scope="col">Paid Amount</th>
                                </tr>
                            </thead>
                            
                            <div v-if="po_advance_toggle" class="row">
                                <div class="col-12 d-flex justify-content-center position-absolute">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-border text-secondary me-2" role="status">
                                            <span class="loader"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <tbody v-else>
                                <tr v-for="advancepo_list in advancepo_list">
                                    <td>{{ advancepo_list.PoCode }}</td>
                                    <td>{{ advancepo_list.PVNO }}</td>
                                    <td>{{ advancepo_list.SalesPerson }}</td>
                                    <td>{{ advancepo_list.Date }}</td>
                                    <td>{{ advancepo_list.vendorName }}</td>
                                    <td>{{ advancepo_list.Status2 }}</td>

                                    <td>{{ Number(advancepo_list.TotalAmount).toLocaleString() }}</td>
                                    <td>{{ Number(advancepo_list.Amount).toLocaleString() }}</td>
                                </tr>
                            </tbody>
                        </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" @click="html_table_to_excel('xlsx', 'advance_po')" class="btn btn-gradient-info">Excel</button>
            <button type="button" @click="generateAdvancePaidReport()" class="btn btn-gradient-info">Pdf</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">close</button>
        </div>
    </div>
</div>
</div>
<!-- End Advance Paid Against PO -->

<!--Start Purchase Invoice Report -->
 <div class="modal fade" id="PurchaseInvoiceReportToggle" aria-labelledby="PurchaseInvoiceReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Purchase Invoice Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="pi_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="pi_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Vendor Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="pi_vendor_name" :options="options1">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="generatePurchaseInvoiceReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

 </div>
<!-- End Purchase Invoice Report -->

<!-- Start Purchase Return Report -->
<div class="modal fade" id="PurchaseReturnReportToggle" aria-labelledby="PurchaseReturnReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Purchase Return Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="pr_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="pr_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Vendor Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="pr_vendor_name" :options="options1">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="  generatePurchaseReturnReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

</div>
<!-- End Purchase Return Report -->

<!--Start Vendor Balance Report -->
<div class="modal fade" id="VendorBalanceToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="vendor_balance_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Vendor Balance Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="ven_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="ven_start_date == ''">{{
                                            e_ven_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="ven_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="ven_end_date == ''">{{
                                            e_ven_end_date }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="ven_bal_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Vendor Balance Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="ven_bal_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Vendor_Balance_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="vbpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.ven_start_date }} To {{ this.ven_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="    min-width: 100px;">AccountID</th>
                                                <th scope="col">Account Name</th>
                                                <th scope="col">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="trail_d1 in vendorb_d">
                                                <td>{{ trail_d1.AccountID }}</td>
                                                <td>{{ trail_d1.AccountName }}</td>
                                                <td>{{ currency }}. {{ Number(trail_d1.Balance).toLocaleString() }}/-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="ven_Sreport">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.ven_start_date }} To {{ this.ven_end_date }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">AccountID</th>
                                        <th scope="col">Account Name</th>
                                        <th scope="col">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="trail_d1 in vendorb_d">
                                        <td>{{ trail_d1.AccountID }}</td>
                                        <td>{{ trail_d1.AccountName }}</td>
                                        <td>{{ currency }}. {{ Number(trail_d1.Balance).toLocaleString() }}/-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'ven_Sreport')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateVendorBalanceSReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="ven_bal_report1()">close</button>
                    </div>
                </div>
            </div>
</div>
<!--End Vendor Balance Report -->

 <!-- Unpaid Purchase Invoices (GRN & Invoice Generated but Payment Pending) Report -->
 <div class="modal fade" id="Unpaid_Pur_InvoToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="Unpaid_Pur_Invo1_Data_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Unpaid Purchase Invoices Data Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="Unpaid_Pur_Invo_Data_report1()"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="Unpaid_Pur_Invo_Data_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="Unpaid_Pur_Invo_Data_start_date == ''">{{ e_Unpaid_Pur_Invo_Data_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="Unpaid_Pur_Invo_Data_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="Unpaid_Pur_Invo_Data_end_date == ''">{{
                                            e_Unpaid_Pur_Invo_Data_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" @input="Unpaid_Pur_Invo_dept_projects()" v-model="Unpaid_Pur_Invo_Data_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="Unpaid_Pur_Invo_Data_project" :options="Unpaid_Pur_Invo_projects">
                                    </multiselect>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="Unpaid_Pur_Invo_Data_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" @click="Unpaid_Pur_Invo_Data_report1()">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width:1300px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Unpaid Purchase Invoices</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="Unpaid_Pur_Invo_Data_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" @hasDownloaded="pdfL2=false" :preview-modal="false" :paginate-elements-by-height="5000" filename="Unpaid_Pur_Invo_Data__Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1000px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="Unpaid_Purchase_Invoices">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date1:</strong> {{ this.Unpaid_Pur_Invo_Data_start_date }} To
                                        {{ this.Unpaid_Pur_Invo_Data_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th class="reports-th-center" scope="col">PO No</th>
                                                <th class="reports-th-center" scope="col">PO Date</th>
                                                <th class="reports-th-center" scope="col">GRN No</th>
                                                <th class="reports-th-center" scope="col">GRN Date</th>
                                                <th class="reports-th-center" scope="col">Department</th>
                                                <th class="reports-th-center" scope="col">GRN Amount</th>
                                                <th class="reports-th-center" scope="col">Paid Amount</th>
                                                <th class="reports-th-center" scope="col">Vendor Name</th>
                                                <th class="reports-th-center" scope="col">Project Name</th>
                                                <th class="reports-th-center" scope="col">Status</th>
                                                <th class="reports-th-center" scope="col">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="trail_d1 in Unpaid_Pur_Invo_Data_dorb_d">
                                                <td class="td-center">{{ trail_d1.PONo }}</td>
                                                <td class="td-center">{{ trail_d1.PODate }}</td>
                                                <td class="td-center">{{ trail_d1.GRNNo }}</td>
                                                <td class="td-center">{{ trail_d1.GRNDate }}</td>
                                                <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                                <td class="td-center">{{ Number(trail_d1.PayableAmount).toLocaleString() }}</td>
                                                <td class="td-center" v-if="trail_d1.AmountStatus =='Verified'">{{ Number(trail_d1.PayableAmount).toLocaleString() }}</td>
                                                <td class="td-center" v-else> </td>
                                                <td class="td-center">{{ trail_d1.VendorName }}</td>
                                                <td class="td-center">{{ trail_d1.Project }}</td>
                                                <td class="td-center">{{ trail_d1.Status }}</td>
                                                <td class="td-center">{{ trail_d1.Type }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Unpaid_Pur_Invo_Data_Report">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.Unpaid_Pur_Invo_Data_start_date }} To
                                {{ this.Unpaid_Pur_Invo_Data_end_date }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th class="reports-th-center" scope="col">PO No</th>
                                        <th class="reports-th-center" scope="col">PO Date</th>
                                        <th class="reports-th-center" scope="col">GRN No</th>
                                        <th class="reports-th-center" scope="col">GRN Date</th>
                                        <th class="reports-th-center" scope="col">Department</th>
                                        <th class="reports-th-center" scope="col">GRN Amount</th>
                                        <th class="reports-th-center" scope="col">Paid Amount</th>
                                        <th class="reports-th-center" scope="col">Vendor Name</th>
                                        <th class="reports-th-center" scope="col">Project Name</th>
                                        <th class="reports-th-center" scope="col">Status</th>
                                        <th class="reports-th-center" scope="col">Type</th>
                                    </tr>
                                </thead>
                                <div v-if="Loader2" class="row">
                                     <div class="col-12 d-flex justify-content-center position-absolute">
                                         <div class="d-flex align-items-center">
                                             <div class="spinner-border text-secondary me-2" role="status">
                                             </div>
                                             <span class="loader-message">{{ Loader2 ? 'Processing data.This may take a few minutes...' : 'Please wait...' }}</span>
                                         </div>
                                     </div>
                                </div>
                                <tbody>
                                    <tr v-for="trail_d1 in Unpaid_Pur_Invo_Data_dorb_d">
                                        <td class="td-center">{{ trail_d1.PONo }}</td>
                                        <td class="td-center">{{ trail_d1.PODate }}</td>
                                        <td class="td-center">{{ trail_d1.GRNNo }}</td>
                                        <td class="td-center">{{ trail_d1.GRNDate }}</td>
                                        <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                        <td class="td-center">{{ Number(trail_d1.PayableAmount).toLocaleString() }}</td>
                                        <td class="td-center" v-if="trail_d1.AmountStatus =='Verified'">{{ Number(trail_d1.PayableAmount).toLocaleString() }}</td>
                                        <td class="td-center" v-else> </td>
                                        <td class="td-center">{{ trail_d1.VendorName }}</td>
                                        <td class="td-center">{{ trail_d1.Project }}</td>
                                        <td class="td-center">{{ trail_d1.Status }}</td>
                                        <td class="td-center">{{ trail_d1.Type }}</td>

                                    </tr>
                                </tbody>
                                <div v-if="Unpaid_Pur_Invo_Data_dorb_d.length==0" class="row">
                                     <div class="col-12 d-flex justify-content-center position-absolute">
                                         <div class="d-flex align-items-center">
                                             <h3> No Data... </h3>
                                         </div>
                                     </div>
                                </div>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'Unpaid_Pur_Invo_Data_Report')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateUnpaid_Pur_InvoReport()" class="btn btn-gradient-info">
                            <i v-if="pdfL2" class="spinner-border spinner-border-sm"></i>
                            Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="Unpaid_Pur_Invo_Data_report1()">close</button>
                    </div>
                </div>
            </div>
 </div>
 <!--end Unpaid Purchase Invoices(GRN & Invoice Generated but Payment Pending) Report -->
    </div>
</template>


<script>
import VueHtml2pdf from 'vue-html2pdf'
import Multiselect from 'vue-multiselect'
export default{
    props: {
    optionsdept1: {
      type: Array,
//   required: true
    },

    optionsdemand1:{
        type:Array,
//   required: true
    },
    optionsrid1:{
        type:Array,
//   required: true
    },
    start_date:{
    Type:String,
    //   required: true
    },
    end_date:{
    Type:String,
    //   required: true
    },
  },
  components: {
        Multiselect,VueHtml2pdf
      
    },
    name: "reported",

      data() {
        return {
        
            po_list: {},
            req_start_date: '00-00-0000',
            req_end_date: '99-99-9999',
            req_dept3: 'All',
            req_dept2: 'All',
            req_dept1: 'All',
            req_rid: 'All',
            req_proj: 'All',
            req_proj1: 'All',
            req_items: 'All',
            items_details: {},
            optionsproj: [],
            options_po_grn: [],
            proj_details: {},
            items_details_qc: {},
            qc_start_date: '00-00-0000',
            qc_vendor: 'All',
            optionsqc: [],
            qc_end_date: '99-99-9999',
            qc_rid: 'All',
            qc_items: 'All',
            po_proj: 'All',
            po_vendor_name: 'All',
            pi_vendor_name: 'All',
            pr_start_date: '00-00-0000',
            pr_end_date: '99-99-9999',
            pr_vendor_name: 'All',
            po_start_date: '00-00-0000',
            po_end_date: '99-99-9999',
            po_type: 'All',
            optionspotype: ['All', 'Services', 'Goods', 'Assets'],
            advancepo_list: {},
            demand_item_list: {},
            demand_rid: 'All',
            demand_start_date1:null,
            demand_end_date: null,
            req_demand_items: 'All',
            options1: [],
            departments1: {},
            pi_start_date: '00-00-0000',
            pi_end_date: '99-99-9999',
            vendor_balance_report: '',
            ven_start_date: '',
            get_podata1: {},
            get_podata: {},
            e_ven_start_date: '',
            ven_end_date: '',
            e_ven_end_date: '',
            vendorb_d: {},
            requ_detail_report: '',
            quot_list: {},
            po_grn_report: '',
            po_grn_id: '',
            e_po_grn_id: '',
            po_grn_list: {},
            optionsgrn: ['All', 'GRN Generated', 'GRN Not Generated'],
            po_grn_check: 'All',
            po_create_by: 'All',
            optionspocreated: [],
            po_grn_createlist: {},
            options_r_iss: [],
            demand_id: '',
            po_advance_toggle:false,
            e_demand_id: '',
            get_reqdata1: {},
            get_reqdata: {},
            req__det_iq: '',
            e_req__det_iq: '',
            OpenPos1_Data_report: '',
            OpenPos_Data_start_date: '',
            OpenPos_Data_end_date: '',
            e_OpenPos_Data_start_date: '',
            e_OpenPos_Data_end_date: '',
            OpenPos_Data_dept: 'All',
            OpenPos_Data_project: '',
            OpenPos_projects: [],
            OpenPos_Data_dorb_d: {},
            Unpaid_Pur_Invo1_Data_report: '',
            Unpaid_Pur_Invo_Data_start_date: '',
            Unpaid_Pur_Invo_Data_end_date: '',
            e_Unpaid_Pur_Invo_Data_start_date: '',
            e_Unpaid_Pur_Invo_Data_end_date: '',
            Unpaid_Pur_Invo_Data_dept: 'All',
            Unpaid_Pur_Invo_Data_project: '',
            Unpaid_Pur_Invo_projects: [],
            Unpaid_Pur_Invo_Data_dorb_d: {},
            pdfL1:false,
            pdfL2:false,
            Loader1:false,
            Loader2:false,
           

        }
    },
    watch: {
        start_date(after, before) {
            this.newdata(); 
        },

    },
    methods: {
  

  generateDemandReportUrl() {
    const validation = this.$helpers.validateDateRange(this.demand_start_date1, this.demand_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
        window.open(`Accounts/DemandRequisition_Letter1/${this.req_dept1}/${this.demand_rid}/${this.req_proj}/${this.req_demand_items}/${this.demand_start_date1}/${this.demand_end_date}`);
    } 
  },
  generatePRReportUrl() {
    const validation = this.$helpers.validateDateRange(this.req_start_date, this.req_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(`Accounts/Requisition_Letter1/${this.req_dept2}/${this.req_rid}/${this.req_proj1}/${this.req_items}/${this.req_start_date}/${this.req_end_date}`);
    } 
  },
  generateCompartiveQutationReportUrl() {
    const validation = this.$helpers.validateDateRange(this.qc_start_date, this.qc_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(`Accounts/QuotationComparative_report1/${this.qc_rid}/${this.qc_items}/${this.qc_vendor}/${this.qc_start_date}/${this.qc_end_date}`);
    } 
  },
  generatePurchaseOrderReportUrl() {
    const validation = this.$helpers.validateDateRange(this.po_start_date, this.po_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(`Accounts/PO_letter1/${this.po_type}/${this.po_vendor_name}/${this.po_proj}/${this.req_dept3}/${this.po_create_by}/${this.po_grn_check}/${this.po_start_date}/${this.po_end_date}`);
    } 
  },
  generatePurchaseInvoiceReportUrl() {
    const validation = this.$helpers.validateDateRange(this.pi_start_date, this.pi_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(`Accounts/Pi_letter1/${this.pi_vendor_name}/${this.pi_start_date}/${this.pi_end_date}`);
    } 
  },
  generatePurchaseReturnReportUrl() {
    const validation = this.$helpers.validateDateRange(this.pr_start_date, this.pr_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open( `Accounts/PR_letter1/${this.pr_vendor_name}/${this.pr_start_date}/${this.pr_end_date}`);
    } 
  },
 
        getItemsdemand() {
            axios.get('getitems_demandrequisition/' + this.demand_rid)
                .then(response => {
                    this.demand_item_list = response.data;
                })
        },

        demand_report() {
            if (this.demand_id == '') {
                this.$toastr.e("Please Select Compulsory Field", "Caution!");
                this.e_demand_id = 'Select Demand ID'
            } else {
                window.open("./accounts/get_DemandReqTrackingReport/" + this.demand_id, '_blank');

            }
        },
        getItems() {
            axios.get('getitems_requisition/' + this.req_rid)
                .then(response => {
                    this.items_details = response.data;
                })
        },
        req_detail_summary() {
            if (this.req__det_iq == '') {
                this.e_req__det_iq = 'Select Requisition id';
                this.$toastr.e("Select compulsory field", "Caution!");

            } else {

                this.requ_detail_report = 1;
                axios.get('accounts/get_req_data3/' + this.req__det_iq)
                    .then(response => {
                        this.get_reqdata = response.data;
                    })

                axios.get('accounts/get_req_data2/' + this.req__det_iq)
                    .then(response => {
                        this.get_reqdata1 = response.data;
                    })
                axios.get('accounts/get_req_data_count/' + this.req__det_iq)
                    .then(response => {
                        this.get_reqdata_count = response.data
                    })
                axios.get('get_datad/' + this.req__det_iq)
                    .then(response => {
                        this.get_issudata = response.data;
                    })
            }
        },
        req_detail_summary1() {
            this.requ_detail_report = '',
                this.req__det_iq = '',
                this.get_reqdata = {},
                this.get_reqdata1 = {},
                this.get_issudata = {}
        },
        html_table_to_excel(type, tableID) {
            var uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table border="1">{table}</table></body></html>',
                base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function (s, c) {
                    return s.replace(/{(\w+)}/g, function (m, p) {
                        return c[p];
                    })
                }
            var data = document.getElementById(tableID).innerHTML;

            var ctx = {
                worksheet: name || '',
                table: data
            };
            var link = document.createElement("a");
            link.download = tableID + ".xls";
            link.href = uri + base64(format(template, ctx))
            link.click();
        },
        generateReqDetReport() {
            this.$refs.reqdpdf.generatePdf();
        },
        
        getItems2() {
            axios.get('getitems_quotation/' + this.qc_rid)
                .then(response => {
                    this.items_details_qc = response.data;
                })
        },
        po_grn_summary() {
            if (this.po_grn_id == '') {

                this.e_po_grn_id = 'Select po id';
                this.$toastr.e("Select compulsory field", "Caution!");
            } else {
                this.po_grn_report = 1
                axios.get('accounts_get_po_data2/' + this.po_grn_id)
                    .then(response => {
                        this.get_podata = response.data;
                    })
                axios.get('accounts_get_poProducts1/' + this.po_grn_id)
                    .then(response => {
                        this.get_podata1 = response.data;
                    })
                axios.get('accounts_get_poProducts_count/' + this.po_grn_id)
                    .then(response => {
                        this.get_podata_count = response.data;
                    })
                axios.get('accounts/get_po_grn_detailreport/' + this.po_grn_id)
                    .then(response => {
                        this.get_grn_data = response.data;
                    })
            }

        },
        generatePOGRNDetReport() {
            this.$refs.pogrnpdf.generatePdf();
        },
        
        OpenPos_Data_report1() {
                this.OpenPos_Data_start_date =this.start_date,
                this.OpenPos_Data_end_date =this.end_date,
                this.e_OpenPos_Data_start_date = '',
                this.e_OpenPos_Data_end_date = ''
                this.OpenPos_Data_dept = 'All',
                this.OpenPos_Data_project = '',
                this.OpenPos_projects = this.optionsproj,
                this.OpenPos_Data_dorb_d = {},
                this.OpenPos1_Data_report = '';

        },
        OpenPos_dept_projects() {
            if (this.OpenPos_Data_dept == 'All') {
                this.OpenPos_projects = this.optionsproj;
            } else {
                axios.get('accounts/get_projects/' + this.OpenPos_Data_dept)
                    .then(response => {
                        this.OpenPos_projects = [];
                        for (var i = 0; i < response.data.length; i++) {
                            this.OpenPos_projects.push(response.data[i].ProjectName);
                        }
                    })
            }
        },

        OpenPos_Data_report() {

            if (this.OpenPos_Data_start_date == '' || this.OpenPos_Data_end_date == '') {
                this.$toastr.e("Please Select Compulsory Field", "Caution!");
                if (this.OpenPos_Data_start_date == '') {
                    this.e_OpenPos_Data_start_date = "Please Select Start Date";
                }
                if (this.OpenPos_Data_end_date == '') {
                    this.e_OpenPos_Data_end_date = "Please Select End Date";
                }
            } else {
                this.Loader1=true;
                this.OpenPos1_Data_report = 1;
                if (this.OpenPos_Data_dept == null) {
                    this.OpenPos_Data_dept = 'All';
                }
                axios.get('accounts/OpenPos_Data_report/' + this.OpenPos_Data_start_date + '/' + this.OpenPos_Data_end_date + '/' + this.OpenPos_Data_dept + '/' + this.OpenPos_Data_project)
                    .then(response => {
                        let OpenPos_Data = response.data.sort((a, b) => {
                            let left = a.AccountID
                            let right = b.AccountID
                            return left === right ? 0 : left > right ? 1 : -1;
                        })
                        this.OpenPos_Data_dorb_d = OpenPos_Data
                        this.Loader1=false;
                    })
            }
        },
        po_grn_summary1() {
            this.po_grn_report = '',
                this.po_grn_id = '',
                this.get_podata = {},
                this.get_podata1 = {},
                this.get_podata_count = '',
                this.get_grn_data = {}
        },
     generateVendorBalanceSReport() {
            this.$refs.vbpdf.generatePdf();
        },
     generateOpenPosReport() {
        this.pdfL1=true;        
                setTimeout(()=>{
                    this.$refs.OpenPos.generatePdf();
                })
        },
     generateUnpaid_Pur_InvoReport() {
        this.pdfL2=true;        
                setTimeout(()=>{
                    this.$refs.Unpaid_Purchase_Invoices.generatePdf();
                })
        },
        advance_po_paid() {
            this.po_advance_toggle = true;
            axios.get("accounts/advance_paid_po")
                .then((response) => {
                    this.po_advance_toggle = false;
                    this.advancepo_list = response.data
                }).catch((err)=>{
                    this.po_advance_toggle = false;
                })

        },
        generateAdvancePaidReport() {
            this.$refs.advancepopdf.generatePdf();
        },
        ven_bal_report() {
          
            const validation = this.$helpers.validateDateRange(this.ven_start_date, this.ven_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");     
                if (this.ven_start_date == '') {
                    this.e_ven_start_date = "Please Select Start Date";
                }
                if (this.ven_end_date == '') {
                    this.e_ven_end_date = "Please Select End Date";
                }
            } else {
                this.vendor_balance_report = 1
                axios.get('accounts/vendor_balance_report/' + this.ven_start_date + '/' + this.ven_end_date)
                    .then(response => {
              
                        let trialData = response.data.sort((a, b) => {
                            let left = a.AccountID
                            let right = b.AccountID
                            return left === right ? 0 : left > right ? 1 : -1;
                        })
                        this.vendorb_d = trialData
                    })
            }
        },
        ven_bal_report1() {
            this.vendor_balance_report = '',
                this.ven_start_date = '',
                this.ven_end_date = '',
                this.e_ven_start_date = '',
                this.e_ven_end_date = ''
            this.vendorb_d = {}
        },

        Unpaid_Pur_Invo_Data_report1() {
            this.Unpaid_Pur_Invo_Data_start_date=this.start_date,
     this.Unpaid_Pur_Invo_Data_end_date=  this.end_date    ,
                this.e_Unpaid_Pur_Invo_Data_start_date = '',
                this.e_Unpaid_Pur_Invo_Data_end_date = ''
            this.Unpaid_Pur_Invo_Data_dept = 'All',
                this.Unpaid_Pur_Invo_Data_project = '',
                this.Unpaid_Pur_Invo_projects = this.optionsproj,
                this.Unpaid_Pur_Invo_Data_dorb_d = {},
                this.Unpaid_Pur_Invo1_Data_report = '';

        },
        Unpaid_Pur_Invo_dept_projects() {
            if (this.Unpaid_Pur_Invo_Data_dept == 'All') {
                this.Unpaid_Pur_Invo_projects = this.optionsproj;
            } else {
                axios.get('accounts/get_projects/' + this.Unpaid_Pur_Invo_Data_dept)
                    .then(response => {
                        this.Unpaid_Pur_Invo_projects = [];
                        for (var i = 0; i < response.data.length; i++) {
                            this.Unpaid_Pur_Invo_projects.push(response.data[i].ProjectName);
                        }
                    })
            }
        },

        Unpaid_Pur_Invo_Data_report() {
            const validation = this.$helpers.validateDateRange(this.Unpaid_Pur_Invo_Data_start_date, this.Unpaid_Pur_Invo_Data_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");  
         
                if (this.Unpaid_Pur_Invo_Data_start_date == '') {
                    this.e_Unpaid_Pur_Invo_Data_start_date = "Please Select Start Date";
                }
                if (this.Unpaid_Pur_Invo_Data_end_date == '') {
                    this.e_Unpaid_Pur_Invo_Data_end_date = "Please Select End Date";
                }
            } else {
                this.Loader2=true;
                this.Unpaid_Pur_Invo1_Data_report = 1;
                if (this.Unpaid_Pur_Invo_Data_dept == null) {
                    this.Unpaid_Pur_Invo_Data_dept = 'All';
                }
                axios.get('accounts/GIGBPP_Data_report/' + this.Unpaid_Pur_Invo_Data_start_date + '/' + this.Unpaid_Pur_Invo_Data_end_date + '/' + this.Unpaid_Pur_Invo_Data_dept + '/' + this.Unpaid_Pur_Invo_Data_project)
                    .then(response => {
                        let Unpaid_Pur_Invo_Data = response.data.sort((a, b) => {
                            let left = a.AccountID
                            let right = b.AccountID
                            return left === right ? 0 : left > right ? 1 : -1;
                        })
                        this.Unpaid_Pur_Invo_Data_dorb_d = Unpaid_Pur_Invo_Data;
                        this.Loader2=false;

                    })
            }
        },

        newdata(){
            this.demand_start_date1=this.start_date;
     this.demand_end_date=this.end_date;
     this.req_start_date=this.start_date;
     this.req_end_date=  this.end_date;
     this.qc_start_date=this.start_date;
     this.qc_end_date=  this.end_date;
     this.po_start_date=this.start_date;
     this.po_end_date=  this.end_date;
      this.OpenPos_Data_start_date =this.start_date;
    this.OpenPos_Data_end_date =this.end_date;
    this.pi_start_date=this.start_date;
     this.pi_end_date=  this.end_date    ;
    this.pr_start_date=this.start_date;
     this.pr_end_date=  this.end_date    ;  
    this.ven_start_date=this.start_date;
     this.ven_end_date=  this.end_date    ;
    this.Unpaid_Pur_Invo_Data_start_date=this.start_date;
     this.Unpaid_Pur_Invo_Data_end_date=  this.end_date    ;

     
    }
},
    mounted() {
    this.newdata();


    axios.get("accounts/get_requisition1").then((response) => {
       
       this.quot_list = response.data;
       this.options_r_iss = [];

       var $this = this;
       for (var i = 0; i < $this.quot_list.length; i++) {
           this.options_r_iss.push($this.quot_list[i].RequisitionId + '_' + $this.quot_list[i].RId);
       }

   }).catch((err) => {
       console.log(err);
   })

   axios.get('./accounts/get_vendor')
            .then(response => {
                this.get_vendors = response.data
                this.optionsqc = [];

                var $this = this;
                for (var i = 0; i < $this.get_vendors.length; i++) {
                    this.optionsqc.push($this.get_vendors[i].CompanyName);
                }
            })
            axios.get("vendor_report_detail").then((response) => {
            this.po_list = response.data;
    
            this.options1 = [];

            var $this = this;
            for (var i = 0; i < $this.po_list.length; i++) {
                this.options1.push($this.po_list[i].CompanyName);
            }
        }).catch((err) => {
            console.log(err);
        })

        axios.get("accounts/get_purchaseorder_createdlist").then((response) => {
          
          this.po_grn_createlist = response.data;
          this.optionspocreated = [];
          var $this = this;
          for (var i = 0; i < $this.po_grn_createlist.length; i++) {
              this.optionspocreated.push($this.po_grn_createlist[i].CreatedBy);
          }
      })

      axios.get("accounts/get_purchaseorder_id").then((response) => {
       
       this.po_grn_list = response.data;
       this.options_po_grn = [];
       this.popaid_option = [];

       var $this = this;
       for (var i = 0; i < $this.po_grn_list.length; i++) {
           this.options_po_grn.push($this.po_grn_list[i].PurchaseOrderID + '_' + $this.po_grn_list[i].PoCode);
           this.popaid_option.push($this.po_grn_list[i].PoCode);
       }
   })
   axios.get("get_linkprojects").then((response) => {
            this.proj_details = response.data
            this.optionsproj = [];

            var $this = this;
            for (var i = 0; i < $this.proj_details.length; i++) {
                this.optionsproj.push($this.proj_details[i].ProjectName);
            }
            this.Unpaid_Pur_Invo_dept_projects();
             this.OpenPos_dept_projects();
        })
        axios.get('get_currency').then((response) => {
            this.currency = response.data[0].Currency;
        })
    }
    

}
</script>

<style scoped>

.ng-star-inserted>a {
    cursor: pointer;
    border-bottom: 1px dashed #ccc;
    padding-top: 5px;
    padding-bottom: 5px;
    display: block;
    max-width: 250px;
    margin-left: 20px;
    color: #2485e8;
    text-decoration: none;
}
.td-center {
    z-index: 1;
    text-align: center;
    vertical-align: middle !important;
}

.reports-th-center {
    z-index: 1;
    position: sticky;
    top: 0px;
    text-align: center;
    vertical-align: middle !important;
}
.loader {
    width: 48px;
    height: 48px;
    border: 5px solid #FFF;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 
</style><style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
