
<template>
    <div>
        <h6 class="mb-25 fw-bold">
                                <i class="fa-solid fa-basket-shopping" style="padding-right: 10px"></i>
                                Inventory Reports
                            </h6>
                            <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#GRNReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        GRN Details Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#IssuanceReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Issuances Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#IssuanceReturnReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Issuance Return Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#ReceivingDataToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Receiving Data Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#IssuanceDataToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Issuance Data Report
                                    </span>
                                </a>
                            </div>


  <!--Start GRN Detail Report -->
  <div class="modal fade" id="GRNReportToggle" aria-labelledby="GRNReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">GRN Detail Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="grn_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="grn_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Vendor Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="grn_vendor_name" :options="options1">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="generateGRNDetailReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

</div>                          
  <!--End GRN Detail Report -->
<!-- Start Issuance Detail Report -->
  <div class="modal fade" id="IssuanceReportToggle" aria-labelledby="IssuanceReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Issuance Detail Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="iss_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="iss_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="iss_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Issuance Id</label>
                                    <multiselect style="margin-right: 10px;" @input="getItems1()" v-model="iss_rid" :options="optionsissu">
                                    </multiselect>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="iss_proj" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Item Name</label>

                                    <select v-model="iss_items" class="form-select">
                                        <option value="All">Select item</option>
                                        <option v-for="items_details1 in items_details_items" :value="items_details1.itemId" :key="items_details1">
                                            {{ items_details1.ItemName }}</option>
                                    </select>
                                    <p class="text-danger">for items, first select Issuance id</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click="generateIssuancesReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

        </div>
<!-- End Issuance Detail Report -->

<!-- Start Issuance Return Detail Report -->
<div class="modal fade" id="IssuanceReturnReportToggle" aria-labelledby="IssuanceReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Issuance Return Detail Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="iss_start_date" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="iss_end_date" type="date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="iss_dept1" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Issuance Return Id</label>
                                    <multiselect style="margin-right: 10px;" @input="getItems_RIssu()" v-model="iss_return_rid" :options="optionsRissu">
                                    </multiselect>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="iss_proj1" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Item Name</label>

                                    <select v-model="iss_return_items" class="form-select">
                                        <option value="All">Select item</option>
                                        <option v-for="items_details1 in items_details_return_items" :value="items_details1.ItemId" :key="items_details1">
                                            {{ items_details1.ItemName }}</option>
                                    </select>
                                    <p class="text-danger">for items, first select Return Issuance id</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" @click=" generateIssuancesReturnReportUrl()" class="btn btn-primary">
                            View Report
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>

        </div>
<!-- End Issuance Return Detail Report -->

        <!-- Receiving Data Report -->
        <div class="modal fade" id="ReceivingDataToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="Recv_Data_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Receiving Data Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="Receiving_Data_report1()"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="Recv_Data_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="Recv_Data_start_date == ''">{{
                                            e_Recv_Data_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="Recv_Data_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="Recv_Data_end_date == ''">{{
                                            e_Recv_Data_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" @input="Receiving_dept_projects()" v-model="Recv_Data_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="Recv_Data_project" :options="dept_projects">
                                    </multiselect>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="Receiving_Data_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" @click="Receiving_Data_report1()">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width:1300px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Receiving Data Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="Receiving_Data_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false"     @hasDownloaded="pdfRL=false"     @beforeDownload="pdfRL=true" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Receiving_Data__Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1000px"  @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="ReceivingDatavbpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                         
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="reports-th-center" scope="col">Item Code</th>
                                                <th class="reports-th-center" scope="col">Description</th>
                                                <th class="reports-th-center" scope="col">UOM</th>
                                                <th class="reports-th-center" scope="col">Type</th>
                                                <th class="reports-th-center" scope="col">Department</th>
                                                <th class="reports-th-center" scope="col">Received Qty</th>
                                                <th class="reports-th-center" scope="col">Unit Price</th>
                                                <th class="reports-th-center" scope="col">Total Amount</th>
                                                <th class="reports-th-center" scope="col">GRN No</th>
                                                <th class="reports-th-center" scope="col">GRN Date</th>
                                                <th class="reports-th-center" scope="col">Status</th>
                                                <th class="reports-th-center" scope="col">Project Name</th>
                                                <th class="reports-th-center" scope="col">Vendor Name</th>
                                            </tr>
                                        </thead>
                      
                                        <tbody>
                                            <tr v-for="trail_d1 in Recv_Data_dorb_d">
                                                <td class="td-center">{{ trail_d1.ItemCode }}</td>
                                                <td class="td-center">{{ trail_d1.Name }}</td>
                                                <td class="td-center">{{ trail_d1.UOM }}</td>
                                                <td class="td-center">{{ trail_d1.Type }}</td>
                                                <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                                <td class="td-center">{{ Number(trail_d1.ReceivedQty).toLocaleString() }}</td>
                                                <td class="td-center">{{ Number(trail_d1.UnitPrice).toLocaleString() }}</td>
                                                <td class="td-center">{{ Number(trail_d1.ReceivedQty*trail_d1.UnitPrice).toLocaleString() }}</td>
                                                <td class="td-center">{{ trail_d1.GRNNo }}</td>
                                                <td class="td-center">{{ trail_d1.GRNDate }}</td>
                                                <td class="td-center">{{ trail_d1.Status }}</td>
                                                <td class="td-center">{{ trail_d1.ProjectName }}</td>
                                                <td class="td-center">{{ trail_d1.VendorName }}</td>

                                            </tr>
                                        </tbody>
                          
                                    </table>

                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Receiving_Data_Report">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.Recv_Data_start_date }} To {{ this.Recv_Data_end_date }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="reports-th-center" scope="col">Item Code</th>
                                        <th class="reports-th-center" scope="col">Description</th>
                                        <th class="reports-th-center" scope="col">UOM</th>
                                        <th class="reports-th-center" scope="col">Type</th>
                                        <th class="reports-th-center" scope="col">Department</th>
                                        <th class="reports-th-center" scope="col">Received Qty</th>
                                        <th class="reports-th-center" scope="col">Unit Price</th>
                                        <th class="reports-th-center" scope="col">Total Amount</th>
                                        <th class="reports-th-center" scope="col">GRN No</th>
                                        <th class="reports-th-center" scope="col">GRN Date</th>
                                        <th class="reports-th-center" scope="col">Status</th>
                                        <th class="reports-th-center" scope="col">Project Name</th>
                                        <th class="reports-th-center" scope="col">Vendor Name</th>
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
                                    <tr v-for="trail_d1 in Recv_Data_dorb_d">
                                        <td class="td-center">{{ trail_d1.ItemCode }}</td>
                                        <td class="td-center">{{ trail_d1.Name }}</td>
                                        <td class="td-center">{{ trail_d1.UOM }}</td>
                                        <td class="td-center">{{ trail_d1.Type }}</td>
                                        <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                        <td class="td-center">{{ Number(trail_d1.ReceivedQty).toLocaleString() }}</td>
                                        <td class="td-center">{{ Number(trail_d1.UnitPrice).toLocaleString() }}</td>
                                        <td class="td-center">{{ Number(trail_d1.ReceivedQty*trail_d1.UnitPrice).toLocaleString() }}</td>

                                        <td class="td-center">{{ trail_d1.GRNNo }}</td>
                                        <td class="td-center">{{ trail_d1.GRNDate }}</td>
                                        <td class="td-center">{{ trail_d1.Status }}</td>
                                        <td class="td-center">{{ trail_d1.ProjectName }}</td>
                                        <td class="td-center">{{ trail_d1.VendorName }}</td>
                                    </tr>
                                </tbody>
                                <div v-if="Recv_Data_dorb_d.length==0" class="row">
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
                        <button type="button" @click="html_table_to_excel('xlsx', 'Receiving_Data_Report')" class="btn btn-gradient-info"><i v-if="LRE==true" class="spinner-border spinner-border-sm"></i>Excel</button>
                        <button type="button" @click="generateReceivingDataReport()"  class="btn btn-gradient-info">
                            <i v-if="pdfRL" class="spinner-border spinner-border-sm"></i>
                            Pdf
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="Receiving_Data_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end Receiving Data Report -->

        
        <!-- Issuance Data Report -->
        <div class="modal fade" id="IssuanceDataToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="Issuance1_Data_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Issuance Data Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="Issuance_Data_report1()"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="Issuance_Data_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="Issuance_Data_start_date == ''">{{ e_Issuance_Data_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="Issuance_Data_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="Issuance_Data_end_date == ''">{{
                                            e_Issuance_Data_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Department Name</label>
                                    <multiselect style="margin-right: 10px;" @input="Issuance_dept_projects()" v-model="Issuance_Data_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="Issuance_Data_project" :options="Issuance_projects">
                                    </multiselect>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="Issuance_Data_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close" @click="Issuance_Data_report1()">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width:1300px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Issuance Data Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="Issuance_Data_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" @hasDownloaded="pdfL1=false" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Issuance_Data__Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1000px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="vbpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date1:</strong> {{ this.Issuance_Data_start_date }} To
                                        {{ this.Issuance_Data_end_date }}</h6>

                                </div>
                                
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th class="reports-th-center" scope="col">ItemCode</th>
                                                <th class="reports-th-center" scope="col">Description</th>
                                                <th class="reports-th-center" scope="col">UOM</th>
                                                <th class="reports-th-center" scope="col">Type</th>
                                                <th class="reports-th-center" scope="col">Department</th>
                                                <th class="reports-th-center" scope="col">Issued<br />Quantity</th>
                                                <th class="reports-th-center" scope="col">UnitPrice</th>
                                                <th class="reports-th-center" scope="col">Amount</th>
                                                <th class="reports-th-center" scope="col">Issuance<br/>No</th>
                                                <th class="reports-th-center" scope="col">Issuance<br/>Date</th>
                                                <th class="reports-th-center" scope="col">Status</th>
                                                <th class="reports-th-center" scope="col">Project<br/>Name</th>
                                                <th class="reports-th-center" scope="col">Vendor<br/>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="trail_d1 in Issuance_Data_dorb_d">
                                                <td class="td-center">{{ trail_d1.ItemCode }}</td>
                                                <td class="td-center">{{ trail_d1.Name }}</td>
                                                <td class="td-center">{{ trail_d1.UOM }}</td>
                                                <td class="td-center">{{ trail_d1.Type }}</td>
                                                <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                                <td class="td-center">{{ Number(trail_d1.IssuedQuantity).toLocaleString() }}</td>
                                                <td class="td-center">{{ Number(trail_d1.Price).toLocaleString() }}</td>
                                        <td class="td-center">{{ Number(trail_d1.SubTotal).toLocaleString() }}</td>
                                                <td class="td-center">{{ trail_d1.IssuanceNo }}</td>
                                                <td class="td-center">{{ trail_d1.IssuanceDate }}</td>
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
                    <div class="modal-body" id="Issuance_Data_Report">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.Issuance_Data_start_date }} To
                                {{ this.Issuance_Data_end_date }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="reports-th-center" scope="col">ItemCode</th>
                                        <th class="reports-th-center" scope="col">Description</th>
                                        <th class="reports-th-center" scope="col">UOM</th>
                                        <th class="reports-th-center" scope="col">Type</th>
                                        <th class="reports-th-center" scope="col">Department</th>
                                        <th class="reports-th-center" scope="col">Issued<br/>Quantity</th>
                                        <th class="reports-th-center" scope="col">Unit Price</th>
                                        <th class="reports-th-center" scope="col">Amount</th>
                                        <th class="reports-th-center" scope="col">Issuance No</th>
                                        <th class="reports-th-center" scope="col">Issuance<br/>Date</th>
                                        <th class="reports-th-center" scope="col">Status</th>
                                        <th class="reports-th-center" scope="col">Project<br/>Name</th>
                                        <th class="reports-th-center" scope="col">Vendor<br/>Name</th>
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
                                    <tr v-for="trail_d1 in Issuance_Data_dorb_d">
                                        <td class="td-center">{{ trail_d1.ItemCode }}</td>
                                        <td class="td-center">{{ trail_d1.Name }}</td>
                                        <td class="td-center">{{ trail_d1.UOM }}</td>
                                        <td class="td-center">{{ trail_d1.Type }}</td>
                                        <td class="td-center">{{ trail_d1.DepartmentName }}</td>
                                        <td class="td-center">{{ Number(trail_d1.IssuedQuantity).toLocaleString() }}</td>
                                        <td class="td-center">{{ Number(trail_d1.Price).toLocaleString() }}</td>
                                        <td class="td-center">{{ Number(trail_d1.SubTotal).toLocaleString() }}</td>
                                        <td class="td-center">{{ trail_d1.IssuanceNo }}</td>
                                        <td class="td-center">{{ trail_d1.IssuanceDate }}</td>
                                        <td class="td-center">{{ trail_d1.Status }}</td>
                                        <td class="td-center">{{ trail_d1.Project }}</td>
                                        <td class="td-center">{{ trail_d1.VendorName }}</td>
                                    </tr>
                                </tbody>
                                <div v-if="Issuance_Data_dorb_d.length==0" class="row">
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
                        <button type="button" @click="html_table_to_excel('xlsx', 'Issuance_Data_Report')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateIssuanceDataReport()" class="btn btn-gradient-info">
                            <i v-if="pdfL1" class="spinner-border spinner-border-sm"></i>

                            Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="Issuance_Data_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end Issuance Data Report -->
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
         optionsissu: [],
           optionsproj: [],    
            iss_dept: 'All',       
            iss_dept1: 'All',       
            items_details_items: {},
            iss_start_date: '00-00-0000',
            iss_end_date: '99-99-9999',
            iss_proj: 'All',
            iss_proj1: 'All',
            iss_items: 'All',
            iss_return_items: 'All',
            iss_rid: 'All',
            iss_return_rid: 'All',
            grn_vendor_name: 'All',
            grn_start_date: '00-00-0000',
            grn_end_date: '99-99-9999',    
            items_details_return_items: {},      
            optionsRissu: [], 
            options1: [],
            Recv_Data_report: '',
            Recv_Data_start_date: '',
            Recv_Data_end_date: '',
            e_Recv_Data_start_date: '',
            e_Recv_Data_end_date: '',
            Recv_Data_dept: 'All',
            Recv_Data_project: '',
            dept_projects: [],
            Recv_Data_dorb_d: {},
            Issuance1_Data_report: '',
            Issuance_Data_start_date: '',
            Issuance_Data_end_date: '',
            e_Issuance_Data_start_date: '',
            e_Issuance_Data_end_date: '',
            Issuance_Data_dept: 'All',
            Issuance_Data_project: '',
            Issuance_projects: [],
            Issuance_Data_dorb_d: {},
            LRE:false,
            pdfRL:false,
            pdfL1:false,
            Loader1:false,
            Loader2:false

        }
    },
    watch: {
        start_date(after, before) {
            this.newdata(); 
        },

    },
    methods: {


        generateGRNDetailReportUrl() {
    const validation = this.$helpers.validateDateRange(this.grn_start_date, this.grn_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(`Accounts/GRN_letter1/${this.grn_vendor_name}/${this.grn_start_date}/${this.grn_end_date}`);
    } 
  },
  
  generateIssuancesReturnReportUrl() {
    const validation = this.$helpers.validateDateRange(this.iss_start_date, this.iss_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(  `Accounts/Issuance_return_report1/${this.iss_dept1}/${this.iss_return_rid}/${this.iss_proj1}/${this.iss_return_items}/${this.iss_start_date}/${this.iss_end_date}`
);
    } 
  },
  generateIssuancesReportUrl() {
    const validation = this.$helpers.validateDateRange(this.iss_start_date, this.iss_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    
            }
    else {
       
        window.open(  `Accounts/Issuance_report1/${this.iss_dept}/${this.iss_rid}/${this.iss_proj}/${this.iss_items}/${this.iss_start_date}/${this.iss_end_date}`
);
    } 
  },

        getItems1() {
            axios.get('getitems_issuance/' + this.iss_rid)
                .then(response => {
                    this.items_details_items = response.data;
                })
        },
        getItems_RIssu() {
            axios.get('getitems_issuanceReturn/' + this.iss_return_rid)
                .then(response => {
                    this.items_details_return_items = response.data;

                })
        },
        
        Receiving_Data_report1() {
            this.Recv_Data_report = '',
            this.Recv_Data_start_date=this.start_date;
            this.Recv_Data_end_date=this.end_date;  
                this.e_Recv_Data_start_date = '',
                this.e_Recv_Data_end_date = ''
            this.Recv_Data_dept = 'All',
                this.Recv_Data_project = '',
                this.dept_projects = this.optionsproj,
                this.Recv_Data_dorb_d = {}
        },

        Receiving_dept_projects() {

           
            if (this.Recv_Data_dept == 'All') {
                this.dept_projects = this.optionsproj;
            } else {
                axios.get('accounts/get_projects/' + this.Recv_Data_dept)
                    .then(response => {
                        this.dept_projects = [];
                        for (var i = 0; i < response.data.length; i++) {
                            this.dept_projects.push(response.data[i].ProjectName);
                        }
                    })
            }
        },

        Receiving_Data_report() {
            const validation = this.$helpers.validateDateRange(this.Recv_Data_start_date, this.Recv_Data_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");

    if (this.Recv_Data_start_date == '') {
        this.e_Recv_Data_start_date = "Please Select Start Date";
    }
    if (this.Recv_Data_end_date == '') {
        this.e_Recv_Data_end_date = "Please Select End Date";
    }
} else {
    this.Loader2=true;

    this.Recv_Data_report = 1;
    if (this.Recv_Data_dept == null) {
        this.Recv_Data_dept = 'All';
    }
    axios.get('accounts/Receiving_Data_report/' + this.Recv_Data_start_date + '/' + this.Recv_Data_end_date + '/' + this.Recv_Data_dept + '/' + this.Recv_Data_project)
        .then(response => {
        
            let Recv_Data = response.data.sort((a, b) => {
                let left = a.AccountID
                let right = b.AccountID
                return left === right ? 0 : left > right ? 1 : -1;
            })
            this.Recv_Data_dorb_d = Recv_Data;
            this.Loader2=false;

        })
}
},
html_table_to_excel(type, tableID) {
    this.LRE=true ;
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
            this.LRE=false;
        },
        generateReceivingDataReport() {
            this.pdfRL=true;        
                setTimeout(()=>{
                    this.$refs.ReceivingDatavbpdf.generatePdf();
                })
        },
        Issuance_Data_report1() {
            this.Issuance1_Data_report = '',
            this.Issuance_Data_start_date=this.start_date;
            this.Issuance_Data_end_date=this.end_date;
                this.e_Issuance_Data_start_date = '',
                this.e_Issuance_Data_end_date = ''
            this.Issuance_Data_dept = 'All',
                this.Issuance_Data_project = '',
                this.dept_projects = this.optionsproj,
                this.Issuance_Data_dorb_d = {}
        },
        Issuance_dept_projects() {
            if (this.Issuance_Data_dept == 'All') {
                this.Issuance_projects = this.optionsproj;
            } else {
                axios.get('accounts/get_projects/' + this.Issuance_Data_dept)
                    .then(response => {
                        this.Issuance_projects = [];
                        for (var i = 0; i < response.data.length; i++) {
                            this.Issuance_projects.push(response.data[i].ProjectName);
                        }
                    })
            }
        },

        Issuance_Data_report() {
            const validation = this.$helpers.validateDateRange(this.Issuance_Data_start_date, this.Issuance_Data_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
     
                if (this.Issuance_Data_start_date == '') {
                    this.e_Issuance_Data_start_date = "Please Select Start Date";
                }
                if (this.Issuance_Data_end_date == '') {
                    this.e_Issuance_Data_end_date = "Please Select End Date";
                }
            } else {              
                this.Loader1=true;
                this.Issuance1_Data_report = 1;
                if (this.Issuance_Data_dept == null) {
                    this.Issuance_Data_dept = 'All';
                }
                axios.get('accounts/Issuance_Data_report/' + this.Issuance_Data_start_date + '/' + this.Issuance_Data_end_date + '/' + this.Issuance_Data_dept + '/' + this.Issuance_Data_project)
                    .then(response => {
                 
                        let Issuance_Data = response.data.sort((a, b) => {
                            let left = a.AccountID
                            let right = b.AccountID
                            return left === right ? 0 : left > right ? 1 : -1;
                        })
                        this.Issuance_Data_dorb_d = Issuance_Data;
                        this.Loader1=false;
                    })
            }
        },
        
        generateIssuanceDataReport() {
           
            this.pdfL1=true;        
                setTimeout(()=>{
                    this.$refs.vbpdf.generatePdf();
                })
        },
        
        newdata(){
            this.grn_start_date=this.start_date;
            this.grn_end_date=this.end_date;
            this.iss_start_date=this.start_date;
            this.iss_end_date=this.end_date;
            this.Recv_Data_start_date=this.start_date;
            this.Recv_Data_end_date=this.end_date;  
            this.Issuance_Data_start_date=this.start_date;
            this.Issuance_Data_end_date=this.end_date;
            
            
        }

},
    mounted() {
        this.newdata();
        axios.get("vendor_report_detail").then((response) => {
            this.po_list = response.data
            this.options1 = [];

            var $this = this;
            for (var i = 0; i < $this.po_list.length; i++) {
                this.options1.push($this.po_list[i].CompanyName);
            }
        }).catch((err) => {
            console.log(err);
        })

        axios.get("issu_detail_report").then((response) => {
            this.req_details11 = response.data
            this.optionsissu = [];

            var $this = this;
            for (var i = 0; i < $this.req_details11.length; i++) {
                this.optionsissu.push($this.req_details11[i].IssuanceCode);
            }

        })

        axios.get("get_linkprojects").then((response) => {
            this.proj_details = response.data
            this.optionsproj = [];

            var $this = this;
            for (var i = 0; i < $this.proj_details.length; i++) {
                this.optionsproj.push($this.proj_details[i].ProjectName);
            }
   
            this.Issuance_dept_projects();
            this.Receiving_dept_projects();

        })
        axios.get("return_issu_detail_report").then((response) => {
            this.req_details_re = response.data
            this.optionsRissu = [];

            var $this = this;
            for (var i = 0; i < $this.req_details_re.length; i++) {
                this.optionsRissu.push($this.req_details_re[i].IRtnID);
            }

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

</style><style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
