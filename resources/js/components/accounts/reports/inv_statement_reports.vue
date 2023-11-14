<template>
    <div>

        <h6 class="mb-25 fw-bold">
                                <i class="fa-solid fa-warehouse" style="padding-right: 10px"></i>Inventory Statements Reports
                            </h6>
                            <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#InventoryAssetsDetail">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Assets Detail Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#ConsolidatedstockDeatilsToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Consolidated Stock Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#ConsumptionAnalysisReport">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Consumptions Analysis Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#ItemAverageRateReport">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Items Average
                                        Rate Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#ItemListToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Items Detail
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#StockAgeingReport">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Stock Aging
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#stockDeatilsToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Stock Detail
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#InventoryReceiptReport">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Summarized
                                        Material Receive/Issue Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" @click=" get_asset_list()" data-bs-target="#AssetAssignmentList">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Asset
                                        Assignment List
                                    </span>
                                </a>
                            </div>
   
 <!--Start Stock Assets Detail Report  -->
 <div class="modal fade" id="InventoryAssetsDetail" aria-labelledby="InventoryAssetsDetail" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="inventory_assets == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Stock Assets Detail Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Select</label>

                                    <multiselect :show-labels="false" v-model="inenvoty_unique_assetid" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="All" :options="optionassets">
                                    </multiselect>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="assets_detail_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width: 80%">
                            <span style="width: 80%"> Stock Assets Detail Report</span>
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="assets_detail_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Inventory_Assets_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="inventoryassetpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="    min-width: 100px;">Uique ID #</th>
                                                <th scope="col">Asset Name</th>
                                                <th scope="col">Category Name</th>

                                                <th scope="col" style="text-align:right">Qty</th>
                                                <th scope="col" style="text-align:right">Purchase Cost</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="optionassets1 in stock_asssets_list">
                                                <td>{{ optionassets1.AssetsUniqueID }}</td>

                                                <td>{{ optionassets1.Name }}</td>
                                                <td>{{ optionassets1.CategoryName }}</td>
                                                <td style="text-align:right">{{ Number(optionassets1.Qty) }}</td>
                                                <td style="text-align:right">{{ currency }}
                                                    {{ Number(optionassets1.PurchaseCost).toLocaleString() }}</td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="inventory_assets_id">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col" style="    min-width: 100px;">Uique ID #</th>
                                    <th scope="col">Asset Name</th>
                                    <th scope="col">Category Name</th>

                                    <th scope="col" style="text-align:right">Qty</th>
                                    <th scope="col" style="text-align:right">Purchase Cost</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="optionassets1 in stock_asssets_list">
                                    <td>{{ optionassets1.AssetsUniqueID }}</td>

                                    <td>{{ optionassets1.Name }}</td>
                                    <td>{{ optionassets1.CategoryName }}</td>
                                    <td style="text-align:right">{{ Number(optionassets1.Qty) }}</td>
                                    <td style="text-align:right">{{ currency }}
                                        {{ Number(optionassets1.PurchaseCost).toLocaleString() }}</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="
                                html_table_to_excel('xlsx', 'inventory_assets_id')
                                " class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateInventoryAssetsDetailsReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal" @click="assets_detail_report1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
 </div>                           
 <!--End Stock Assets Detail Report  -->
<!--Start Consolidated Stock Detail Repor -->
<div class="modal fade" id="ConsolidatedstockDeatilsToggle" aria-labelledby="ConsolidatedstockDeatilsToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="consolidate_stock_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Consolidated Stock Detail Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Select</label>

                                    <multiselect :show-labels="false" v-model="category_filter" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="All" :options="optioncategory">
                                    </multiselect>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="consolidatestockDetails_Summary()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width: 80%">
                            <span style="width: 80%">Consolidated Stock Detail Report</span>
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="consolidatestockDetails_Summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Consolidate_Stock_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="consolidatepdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="    min-width: 100px;">Item #</th>

                                                <th scope="col">Category Name</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col" style="text-align:right">Qty</th>
                                                <th scope="col" style="text-align:right">Purchase Cost</th>
                                                <th scope="col" style="text-align:right">Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="itemlist1 in itemcategory_list">
                                                <td>{{ itemlist1.ItemCode }}</td>

                                                <td>{{ itemlist1.CategoryName }}</td>
                                                <td>{{ itemlist1.Name }}</td>
                                                <td style="text-align:right">{{ Number(itemlist1.Qty) }}</td>
                                                <td style="text-align:right">{{ currency }} {{ Number(itemlist1.CostUnit) }}
                                                </td>
                                                <td style="text-align:right">{{ currency }}
                                                    {{ parseInt(itemlist1.CostUnit * itemlist1.Qty).toLocaleString() }}</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="consoldatestockListToggle">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col" style="    min-width: 100px;">Item #</th>

                                    <th scope="col">Category Name</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col" style="text-align:right">Qty</th>
                                    <th scope="col" style="text-align:right">Purchase Cost</th>
                                    <th scope="col" style="text-align:right">Price</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="itemlist1 in itemcategory_list">
                                    <td>{{ itemlist1.ItemCode }}</td>

                                    <td>{{ itemlist1.CategoryName }}</td>
                                    <td>{{ itemlist1.Name }}</td>
                                    <td style="text-align:right">{{ Number(itemlist1.Qty) }}</td>
                                    <td style="text-align:right">{{ currency }} {{ Number(itemlist1.CostUnit) }}</td>
                                    <td style="text-align:right">{{ currency }}
                                        {{ parseInt(itemlist1.CostUnit * itemlist1.Qty).toLocaleString() }}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="
                                html_table_to_excel('xlsx', 'consoldatestockListToggle')
                                " class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateConsolidateStockDetailsReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal" @click="consolidatestockDetails_Summary1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
<!--EndConsolidated Stock Detail Repor -->
<!--Start Filter Consumption Analysis Report -->
<div class="modal fade" id="ConsumptionAnalysisReport" aria-labelledby="ConsumptionAnalysisReport" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="consumption_analysis == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Consumption Analysis Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="consumption_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="consumption_start_date == ''">{{
                                            e_consumption_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="consumption_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="consumption_end_date == ''">{{
                                            e_consumption_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Item Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="consumption_item" :options="optionsageing">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="consumption_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="consumption_proj" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="consumption_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Consumption Analysis Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="consumption_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Stock_Ageing" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="consumptionpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.consumption_start_date }} To
                                        {{ this.consumption_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Issuance Date</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Project</th>
                                                <th scope="col">Issuance Qty</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ledger_d1 in consumption_list">
                                                <td>{{ ledger_d1.IssuanceDate }}</td>
                                                <td>{{ ledger_d1.ItemName }}</td>
                                                <td>{{ ledger_d1.DepartmentName }}</td>
                                                <td>{{ ledger_d1.ProjectName }}</td>
                                                <td>{{ Number(ledger_d1.IssuanceQuantity) }}</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="consumption_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.consumption_start_date }} To {{ this.consumption_end_date }}
                            </h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Issuance Date</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Issuance Qty</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ledger_d1 in consumption_list">
                                        <td>{{ ledger_d1.IssuanceDate }}</td>
                                        <td>{{ ledger_d1.ItemName }}</td>
                                        <td>{{ ledger_d1.DepartmentName }}</td>
                                        <td>{{ ledger_d1.ProjectName }}</td>
                                        <td>{{ Number(ledger_d1.IssuanceQuantity) }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'consumption_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateConsumptionAnalysisReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="consumption_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!--End Filter Consumption Analysis Report -->
<!-- Start Filter Average Rate Report -->
<div class="modal fade" id="ItemAverageRateReport" aria-labelledby="ItemAverageRateReport" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="average_rate_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Average Rate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Item Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="average_item" :options="optionsageing">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="averagerate_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Average Rate Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="averagerate_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Average_Rate_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="averagepdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Item Name:</strong> {{ this.average_item }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Item Code</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Average Cost</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ledger_d1 in average_list">
                                                <td>{{ ledger_d1.ItemCode }}</td>
                                                <td>{{ ledger_d1.Name }}</td>
                                                <td>{{ Number(ledger_d1.AVG).toLocaleString() }}</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="averagerate_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Item Name:</strong> {{ this.average_item }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Item Code</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Average Cost</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ledger_d1 in average_list">
                                        <td>{{ ledger_d1.ItemCode }}</td>
                                        <td>{{ ledger_d1.Name }}</td>
                                        <td>{{ Number(ledger_d1.AVG).toLocaleString() }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'averagerate_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateAverageRateReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="averagerate_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- Start Filter Average Rate Report -->

<!--Start Item List Report -->
<div class="modal fade" id="ItemListToggle" aria-labelledby="ItemListToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="item_list_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Item List Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Select</label>

                                    <multiselect :show-labels="false" v-model="item_check" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="All" :options="optionsitem">
                                    </multiselect>
                                    <span style="color: #DB4437; font-size: 11px;" v-if="item_check == ''">{{ e_item_check }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="itemList_Summary()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width: 80%">
                            <span style="width: 80%">Item List Report</span>
                        </h4>
                        <span>Session Name: {{ this.session_name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="itemList_Summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Ledger_Detail_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="itemListpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Item Category:</strong> {{ item_check }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="    min-width: 100px;">Item #</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col" style="text-align:right">Category Name</th>
                                                <th scope="col" style="text-align:right">Sale Cost</th>
                                                <th scope="col" style="text-align:right">Purchase Cost</th>
                                                <th scope="col" style="text-align:right">Unit</th>
                                                <th scope="col" style="text-align:right">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="itemlist1 in itemlist">
                                                <td>{{ itemlist1.ItemCode }}</td>
                                                <td>{{ itemlist1.Name }}</td>
                                                <td style="text-align:right">{{ itemlist1.CategoryName }}</td>
                                                <td style="text-align:right">{{ currency }}.
                                                    {{ Number(itemlist1.SaleCost).toLocaleString() }}/-</td>
                                                <td style="text-align:right">{{ currency }}.
                                                    {{ Number(itemlist1.PurchaseCost).toLocaleString() }}/-</td>
                                                <td style="text-align:right">{{ itemlist1.unit }}</td>
                                                <td style="text-align:right">{{ itemlist1.Status }}</td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="itemListToggle">
                        <h6><strong>Item Category:</strong> {{ item_check }}</h6>
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col" style="    min-width: 100px;">Item #</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col" style="text-align:right">Category Name</th>
                                    <th scope="col" style="text-align:right">Sale Cost</th>
                                    <th scope="col" style="text-align:right">Purchase Cost</th>
                                    <th scope="col" style="text-align:right">Unit</th>
                                    <th scope="col" style="text-align:right">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="itemlist1 in itemlist">
                                    <td>{{ itemlist1.ItemCode }}</td>
                                    <td>{{ itemlist1.Name }}</td>
                                    <td style="text-align:right">{{ itemlist1.CategoryName }}</td>
                                    <td style="text-align:right">{{ currency }}.
                                        {{ Number(itemlist1.SaleCost).toLocaleString() }}/-</td>
                                    <td style="text-align:right">{{ currency }}.
                                        {{ Number(itemlist1.PurchaseCost).toLocaleString() }}/-</td>
                                    <td style="text-align:right">{{ itemlist1.unit }}</td>
                                    <td style="text-align:right">{{ itemlist1.Status }}</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="
                                html_table_to_excel('xlsx', 'itemListToggle')
                                " class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateItemListReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal" @click="itemList_Summary1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
</div>
<!--End Item List Report -->
<!-- Start Filter Item Ageing Report -->
<div class="modal fade" id="StockAgeingReport" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="stock_ageingreport == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Item Ageing Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="ageing_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="ageing_start_date == ''">{{
                                            e_ageing_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="ageing_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="ageing_end_date == ''">{{
                                            e_ageing_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Item Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="ageing_item" :options="optionsageing">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="ageing_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Stock Ageing Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="ageing_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Stock_Ageing" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="Ageingpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.ageing_start_date }} To {{ this.ageing_end_date }}
                                    </h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Entry Date</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col">Requisition ID</th>
                                                <th scope="col">Issuance Date</th>
                                                <th scope="col">Total Days</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ledger_d1 in ageingitem_list">
                                                <td>{{ ledger_d1.EntryDate }}</td>
                                                <td>{{ ledger_d1.ItemName }}</td>
                                                <td>{{ ledger_d1.RId }}</td>
                                                <td>{{ ledger_d1.Issuance_Date }}</td>
                                                <td>{{ ledger_d1.Total_Days }}</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Stock_ageing_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.ageing_start_date }} To {{ this.ageing_end_date }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Entry Date</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Requisition ID</th>
                                        <th scope="col">Issuance Date</th>
                                        <th scope="col">Total Days</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ledger_d1 in ageingitem_list">
                                        <td>{{ ledger_d1.EntryDate }}</td>
                                        <td>{{ ledger_d1.ItemName }}</td>
                                        <td>{{ ledger_d1.RId }}</td>
                                        <td>{{ ledger_d1.Issuance_Date }}</td>
                                        <td>{{ ledger_d1.Total_Days }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'Stock_ageing_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateStockAgeingReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="ageing_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- Start Filter Item Ageing Report -->

    <!--Start Inventory Stock Detail Report -->
    <div class="modal fade" id="stockDeatilsToggle" aria-labelledby="stockDeatilsToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="stock_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Inventory Stock Detail Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Select Item</label>

                                    <multiselect :show-labels="false" v-model="item_filter" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="All" :options="optionstock">
                                    </multiselect>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="stockDetails_Summary()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width: 80%">
                            <span style="width: 80%">Inventory Stock Detail Report</span>
                        </h4>
                        <span>Session Name: {{ this.session_name }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="stockDetails_Summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Ledger_Detail_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="stockpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="    min-width: 100px;">Item #</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col" style="text-align:right">Category Name</th>
                                                <th scope="col" style="text-align:right">Qty</th>
                                                <th scope="col" style="text-align:right">Avg Value</th>
                                                <th scope="col" style="text-align:right">Face Value</th>
                                                <th scope="col" style="text-align:right">Avg Price</th>
                                                <th scope="col" style="text-align:right">Face Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="itemlist1 in stocklist">
                                                <td>{{ itemlist1.ItemCode }}</td>
                                                <td>{{ itemlist1.Name }}</td>
                                                <td style="text-align:right">{{ itemlist1.CategoryName }}</td>
                                                <td style="text-align:right">{{ Number(itemlist1.Qty) }}</td>
                                                <td style="text-align:right">{{ currency }}
                                                    {{ Number(itemlist1.CostUnit).toLocaleString() }}</td>
                                                    <td style="text-align:right">  {{ Number(itemlist1.FaceValue).toLocaleString() }}</td>
                                                <td style="text-align:right">{{ currency }}
                                                    {{ parseInt(itemlist1.CostUnit * itemlist1.Qty).toLocaleString() }}</td>
                                                    <td style="text-align:right"> {{ parseInt(itemlist1.FaceValue * itemlist1.Qty).toLocaleString() }}</td>

                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="stockListToggle">
                        <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="    min-width: 100px;">Item #</th>
                                                <th scope="col">Item Name</th>
                                                <th scope="col" style="text-align:right">Category Name</th>
                                                <th scope="col" style="text-align:right">Qty</th>
                                                <th scope="col" style="text-align:right">Avg Value</th>
                                                <th scope="col" style="text-align:right">Face Value</th>
                                                <th scope="col" style="text-align:right">Avg Price</th>
                                                <th scope="col" style="text-align:right">Face Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="itemlist1 in stocklist">
                                                <td>{{ itemlist1.ItemCode }}</td>
                                                <td>{{ itemlist1.Name }}</td>
                                                <td style="text-align:right">{{ itemlist1.CategoryName }}</td>
                                                <td style="text-align:right">{{ Number(itemlist1.Qty) }}</td>
                                                <td style="text-align:right">{{ currency }}
                                                    {{ Number(itemlist1.CostUnit).toLocaleString() }}</td>
                                                    <td style="text-align:right">  {{ Number(itemlist1.FaceValue).toLocaleString() }}</td>
                                                <td style="text-align:right">{{ currency }}
                                                    {{ parseInt(itemlist1.CostUnit * itemlist1.Qty).toLocaleString() }}</td>
                                                    <td style="text-align:right"> {{ parseInt(itemlist1.FaceValue * itemlist1.Qty).toLocaleString() }}</td>

                                            </tr>

                                        </tbody>
                                    </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="
                                html_table_to_excel('xlsx', 'stockListToggle')
                                " class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateStockDetailsReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal" @click="stockDetails_Summary1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <!--End Inventory Stock Detail Report -->
<!--Start Inventory Receipt Report  -->
    <div class="modal fade" id="InventoryReceiptReport" aria-labelledby="InventoryReceiptReport" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="inventory_receipt_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Inventory Receipt Report
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range From</label>
                                    <input type="date" v-model="receipt_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="receipt_start_date == ''">{{
                                            e_receipt_start_date }}</span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="modalAddCardName">Range To</label>
                                    <input v-model="receipt_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="receipt_end_date == ''">{{
                                            e_receipt_end_date }}</span>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Department Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_dept" :options="optionsdept1">
                                    </multiselect>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="modalAddCardName">Project Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="req_proj" :options="optionsproj">
                                    </multiselect>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="receipt_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h4 class="modal-title" style="width: 80%">
                            <span style="width: 80%">Inventory Receipt Report</span>
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="receipt_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="receipt_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="receiptpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col" style="min-width: 90px;">Date</th>
                                                <th scope="col" style="min-width: 90px;">Requisition ID</th>
                                                <th scope="col" style="min-width: 170px;">Item Name</th>
                                                <th scope="col" style="min-width: 150px;">Project</th>
                                                <th scope="col" style="min-width: 170px;">Department</th>
                                                <th scope="col">Received Qty</th>
                                                <th scope="col">Issued Qty</th>
                                                <th scope="col">Avg. Cost</th>
                                                <th scope="col">Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr colspan="8" v-for="receipt_inventory_list1 in receipt_inventory_list">

                                                <td>{{ receipt_inventory_list1.Dated }}</td>
                                                <td>{{ receipt_inventory_list1.RId }}</td>
                                                <td>{{ receipt_inventory_list1.ItemName }} </td>
                                                <td>{{ receipt_inventory_list1.ProjectName }} </td>
                                                <td>{{ receipt_inventory_list1.DepartmentName }} </td>
                                                <td>{{ Number(receipt_inventory_list1.RecvdQuantity) }} </td>
                                                <td>{{ Number(receipt_inventory_list1.IssuanceQuantity) }} </td>
                                                <td>{{ currency }} {{ Number(receipt_inventory_list1.Price) }} </td>
                                                <td>{{ currency }} {{ Number(receipt_inventory_list1.Costvalue) }} </td>

                                            </tr>

                                            <tr>
                                                <td style="font-weight:bold">Total:</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right;font-weight:bold">{{ currency }}
                                                    {{ Number(receipt_sum).toLocaleString() }}/-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="receipt_id">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col" style="min-width: 90px;">Date</th>
                                    <th scope="col" style="min-width: 90px;">Requisition ID</th>
                                    <th scope="col" style="min-width: 170px;">Item Name</th>
                                    <th scope="col" style="min-width: 150px;">Project</th>
                                    <th scope="col" style="min-width: 170px;">Department</th>
                                    <th scope="col">Received Qty</th>
                                    <th scope="col">Issued Qty</th>
                                    <th scope="col">Avg. Cost</th>
                                    <th scope="col">Price</th>

                                </tr>
                            </thead>
                            <tbody>
                                <td colspan="9">
                                    <div class="accordion accordion-border" id="accordionBorder">
                                        <div class="accordion-item" style="border:none !important" v-for="(receipt_inventory_list1, index) in receipt_inventory_list">
                                            <div class="d-flex">
                                                <div class="col-md-1  mb-3 position-relative mx-1">
                                                    {{ receipt_inventory_list1.Dated }} <br /><a class="collapsed mx-5" @click="editReceipt(receipt_inventory_list1.ReqID, receipt_inventory_list1.ItemId)" style="border: none;margin-top:5px" data-bs-toggle="collapse" :data-bs-target="'#accordionBorder' + index" aria-expanded="false" :aria-controls="'accordionBorder' + index">
                                                        <i class="fa-solid fa-circle-plus"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-1  mb-3 position-relative mx-1">
                                                    {{ receipt_inventory_list1.RId }} </div>
                                                <div class="col-md-2  mb-3 position-relative mx-1">
                                                    {{ receipt_inventory_list1.ItemName }} </div>
                                                <div class="col-md-1  mb-3 position-relative mx-1">
                                                    {{ receipt_inventory_list1.ProjectName }} </div>
                                                <div class="col-md-2  mb-3 position-relative mx-1">
                                                    {{ receipt_inventory_list1.DepartmentName }} </div>
                                                <div class="col-md-1  mb-3 position-relative mx-1">
                                                    {{ Number(receipt_inventory_list1.RecvdQuantity) }} </div>
                                                <div class="col-md-1  mb-3 position-relative mx-1">
                                                    {{ Number(receipt_inventory_list1.IssuanceQuantity) }} </div>
                                                <div class="col-md-1  mb-3 position-relative mx-1">{{ currency }}
                                                    {{ Number(receipt_inventory_list1.Price) }} </div>
                                                <div class="col-md-2  mb-3 position-relative mx-1">{{ currency }}
                                                    {{ Number(receipt_inventory_list1.Costvalue) }} </div>
                                            </div>
                                            <div :id="'accordionBorder' + index" class="accordion-collapse collapse" :aria-labelledby="'headingBorder' + index" :data-bs-parent="'#accordionBorder' + index">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="py-1">Issuance Date</th>
                                                                <th class="py-1">Item Name</th>
                                                                <th class="py-1">Issuance Quantity</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="issuance_receipt_list1 in issuance_receipt_list">
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ issuance_receipt_list1.IssuanceDate }}</span>
                                                                </td>
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ issuance_receipt_list1.ItemName }}</span>
                                                                </td>
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ Number(issuance_receipt_list1.IssuanceQuantity) }}</span>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="py-1">GRN Date</th>
                                                                <th class="py-1">Item Name</th>
                                                                <th class="py-1">Received Quantity</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="received_receipt_list1 in received_receipt_list">
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ received_receipt_list1.Dated }}</span>
                                                                </td>
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ received_receipt_list1.ItemName }}</span>
                                                                </td>
                                                                <td class="py-1">
                                                                    <span class="fw-bold">{{ Number(received_receipt_list1.RecvdQuantity) }}</span>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>

                                <tr>
                                    <td style="font-weight:bold">Total:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align:right;font-weight:bold">{{ currency }}
                                        {{ Number(receipt_sum).toLocaleString() }}/-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="
                                html_table_to_excel('xlsx', 'receipt_id')
                                " class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateInventoryReceiptReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal" @click="receipt_report1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
<!--End Inventory Receipt Report  -->
<!-- Start Asset Assignment Report -->
<div class="modal fade" id="AssetAssignmentList" aria-labelledby="AssetAssignmentToggle" tabindex="-1" style="display:none" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg req_modal_toggle" style="min-width: 1250px !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asset Assignment Report (With Historical Movement of Current Assets)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Asset_Assignment_report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="assetassignpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">

                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important; text-align: center;">Item Code
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Asset
                                                    Unique ID</th>
                                                    <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Assigned To</th>
                                                    <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                   Project</th>
                                                   <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                  Location</th>
                                                  <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                 Emp Code</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Reference</th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date
                                                </th>
                                                <th scope="col" :rowspan="1" style="min-width: 100px !important;">
                                                    Quantity</th>

                                            </tr>

                                        </thead>
                                        <tbody>
                                            <tr v-for="asset_assign in asset_assign">
                                                <td>{{ asset_assign.ItemCode }}</td>
                                                <td>{{ asset_assign.AssetsUniqueID }}</td>
                                                <td>{{ asset_assign.AssignedTo }}</td>
                                                <td>{{ asset_assign.Project }}</td>
                                                <td>{{ asset_assign.Location}}</td>
                                                <td>{{ asset_assign.EmployeeCode}}</td>
                                                <td>{{ asset_assign.Reference }}</td>
                                                <td>{{ asset_assign.Dated }}</td>
                                                <td>{{ Number(asset_assign.Quantity).toLocaleString() }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="asset_list">

                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important; text-align: center;">Item Code</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Asset Unique
                                            ID</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Asset Name</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Assigned To</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Emp Code</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Project</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Location</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Reference</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Date</th>
                                        <th scope="col" :rowspan="1" style="min-width: 100px !important;">Quantity</th>

                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="asset_assign in asset_assign">
                                        <td>{{ asset_assign.ItemCode }}</td>
                                        <td>{{ asset_assign.AssetsUniqueID }}</td>
                                        <td>{{ asset_assign.Name }}</td>
                                        <td>{{ asset_assign.AssignedTo }}</td>
                                        <td>{{ asset_assign.EmployeeCode }}</td>
                                        <td>{{ asset_assign.Project}}</td>
                                        <td>{{ asset_assign.Location}}</td>
                                        <td>{{ asset_assign.Reference }}</td>
                                        <td>{{ asset_assign.Dated }}</td>
                                        <td>{{ Number(asset_assign.Quantity).toLocaleString() }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'asset_list')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateAssetAssignList()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- Start Asset Assignment Report -->
  

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

            req_dept: 'All',
            req_proj: 'All',
            optionsitem: [],
            item_filter: 'All',
            optionsproj: [],
            itemcategory_list: {},
            item_list_report: '',
            item_check: '',
            itemlist: {},
            stock_report: '',
            stocklist: {},
            ageingitem_list: {},
            optionstock: [],
            optionsitem: ["Goods", "Assets"],
            category_filter: 'All',
            consolidate_stock_report: '',
            stock_ageingreport: '',
            ageing_start_date: "",
            e_ageing_start_date: '',
            ageing_end_date: '',
            e_ageing_end_date: '',
            ageing_item: 'All',
            optionsageing: [],
            optioncategory: [],
            inenvoty_unique_assetid: 'All',
            optionassets: [],
            inventory_receipt_report: '',
            receipt_start_date: '',
            e_receipt_start_date: '',
            e_receipt_end_date: '',
            receipt_end_date: '',
            receipt_inventory_list: {},
            issuance_receipt_list: {},
            received_receipt_list: {},
            stock_asssets_list: {},
            average_rate_report: '',
            average_item: 'All',
            average_list: {},
            inventory_assets: '',
            consumption_analysis: '',
            consumption_start_date: '',
            e_consumption_start_date: '',
            consumption_end_date: '',
            e_consumption_end_date: '',
            consumption_item: 'All',
            consumption_dept: 'All',
            consumption_proj: 'All',
            consumption_list: {},
            e_item_check: '',
            asset_assign: {},
        }
    },
    watch: {
        start_date(after, before) {
            this.newdata(); 
        },

    },
    methods: {
        assets_detail_report() {
            this.inventory_assets = 1
            axios.get("accounts/assets_detail").then((response) => {

                let filter_items_stock = response.data.filter((curEle) => {
                    return curEle.Name == this.inenvoty_unique_assetid
                })
                if (this.inenvoty_unique_assetid === 'All') {
                    this.stock_asssets_list = response.data
                } else {
                    this.stock_asssets_list = filter_items_stock
                }
            })
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
        assets_detail_report1() {
            this.inventory_assets = ''
            this.inenvoty_unique_assetid = 'All'
        },
        
        generateInventoryAssetsDetailsReport() {
            this.$refs.inventoryassetpdf.generatePdf();
        },
        consolidatestockDetails_Summary() {
            this.consolidate_stock_report = 1;
            axios.get("accounts/stock_detail").then((response) => {

                let filter_items_stock = response.data.filter((curEle) => {
                    return curEle.CategoryName == this.category_filter
                })
                if (this.category_filter === 'All') {
                    this.itemcategory_list = response.data
                } else {
                    this.itemcategory_list = filter_items_stock
                }

            })
        },
        consolidatestockDetails_Summary1() {

this.consolidate_stock_report = ''
this.category_filter = 'All'
},
generateConsolidateStockDetailsReport() {
            this.$refs.consolidatepdf.generatePdf();
        },
 
        consumption_report() {
            const validation = this.$helpers.validateDateRange(this.consumption_start_date, this.consumption_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
      
                if (this.consumption_start_date == '') {
                    this.e_consumption_start_date = "Please Select Start Date";
                }
                if (this.consumption_end_date == '') {
                    this.e_consumption_end_date = "Please Select End Date";
                }

            } else {
                this.consumption_analysis = 1
                axios.get('accounts/consumptionanalysis_report/' + this.consumption_start_date + '/' + this.consumption_end_date + '/' + this.consumption_item + '/' + this.consumption_dept + '/' + this.consumption_proj)
                    .then(response => {
                        this.consumption_list = response.data
                    })
            }
        },
        consumption_report1() {
            this.consumption_analysis = '',
                this.consumption_item = 'All'
            this.consumption_dept = 'All'
            this.consumption_proj = 'All'
        },
        generateConsumptionAnalysisReport() {
            this.$refs.consumptionpdf.generatePdf();
        },
        averagerate_report() {
            this.average_rate_report = 1;
            axios.get("accounts/item_averagecost_value/" + this.average_item)
                .then((response) => {
                    this.average_list = response.data

                })
        },
        
        averagerate_report1() {
            this.average_rate_report = '',
                this.average_item = 'All'
        },
           
        generateAverageRateReport() {
            this.$refs.averagepdf.generatePdf();
        },
        itemList_Summary() {
            if (this.item_check == '') {
                this.e_item_check = 'Please select category type'
                this.$toastr.e("Please fill required fields!", "Caution!");
            } else {
                this.item_list_report = 1;
                axios.get("accounts/itemlist_report/" + this.item_check).then((response) => {
                    this.itemlist = response.data;
                }).catch((error) => {
                    console.log(error);
                })
            }
        },
        itemList_Summary1() {
            this.item_list_report = '';
        },
        generateItemListReport() {
            this.$refs.itemListpdf.generatePdf();
        },
        ageing_report() {
            const validation = this.$helpers.validateDateRange(this.ageing_start_date, this.ageing_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
      
                if (this.ageing_start_date == '') {
                    this.e_ageing_start_date = "Please Select Start Date";
                }
                if (this.ageing_end_date == '') {
                    this.e_ageing_end_date = "Please Select End Date";
                }
            } else {
                this.stock_ageingreport = 1
                axios.get("accounts/item_ageing_report/" + this.ageing_start_date + '/' + this.ageing_end_date + '/' + this.ageing_item)
                    .then((response) => {
                        this.ageingitem_list = response.data
                    })
            }
        },
        ageing_report1() {
            this.stock_ageingreport = '',
                this.ageing_item = 'All'
        },
        generateStockAgeingReport() {
            this.$refs.Ageingpdf.generatePdf();
        },
        stockDetails_Summary() {
            this.stock_report = 1;
            axios.get("accounts/stock_detail").then((response) => {

                let filter_items_stock = response.data.filter((curEle) => {
                    return curEle.Name == this.item_filter
                })
                if (this.item_filter === 'All') {
                    this.stocklist = response.data
                } else {
                    this.stocklist = filter_items_stock
                }
            })
        },
        stockDetails_Summary1() {
            this.stock_report = '';
        },
        generateStockDetailsReport() {
            this.$refs.stockpdf.generatePdf();
        },
        receipt_report() {
            const validation = this.$helpers.validateDateRange(this.receipt_start_date, this.receipt_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
       
                if (this.receipt_start_date == '') {
                    this.e_receipt_start_date = "Please Select Start Date";
                }
                if (this.receipt_end_date == '') {
                    this.e_receipt_end_date = "Please Select End Date";
                }

            } else {
                this.inventory_receipt_report = 1
                axios.get("accounts/inventory_receipt_report/" + this.receipt_start_date + '/' + this.receipt_end_date + '/' + this.req_dept + '/' + this.req_proj)
                    .then((response) => {
                        this.receipt_inventory_list = response.data
                        let ESum = response.data.map((curEle) => {
                            return curEle.Costvalue
                        }).reduce((accu, curr) => {
                            return Number(accu) + Number(curr)
                        }, 0)
                        this.receipt_sum = ESum
                    })
            }
        },
        receipt_report1() {
            this.req_dept = 'All'
            this.req_proj = 'All'
            this.inventory_receipt_report = ''
        },
        editReceipt(id, name) {

axios.get('accounts/issuance_receipt/' + id + '/' + name)
    .then(response => {
        this.issuance_receipt_list = response.data
    })
axios.get('accounts/received_receipt/' + id + '/' + name)
    .then(response => {
        this.received_receipt_list = response.data
    })
this.receipt_inventory_list.map((curEle, index) => {
    return document.getElementById("accordionBorder" + index).classList.remove("show")
})
},

generateInventoryReceiptReport() {
            this.$refs.receiptpdf.generatePdf();
        },
        get_asset_list() {
            axios.get("accounts/asset_assignment_list")
                .then((response) => {
                    this.asset_assign = response.data
                })
        },
        newdata(){
            this.consumption_start_date= this.start_date;
            this.consumption_end_date=this.end_date;
            this.ageing_start_date= this.start_date;
            this.ageing_end_date=this.end_date;
            this.receipt_start_date= this.start_date;
            this.receipt_end_date=this.end_date;

        }

},
    mounted() {
        this.newdata();
        axios.get("accounts/assets_detail").then((response) => {
            let unique_assets = response.data.map((cur) => {
                return cur.Name
            })
            let newasset = [...new Set(unique_assets)]
            this.asset_stock_list = newasset
            this.optionassets = []
            var $this = this;
            for (var i = 0; i < $this.asset_stock_list.length; i++) {
                this.optionassets.push($this.asset_stock_list[i]);
            }
        })
        axios.get("accounts/fetch_product_category1").then((response) => {
            this.category_list = response.data
            this.optioncategory = [];

            var $this = this;
            for (var i = 0; i < $this.category_list.length; i++) {
                this.optioncategory.push($this.category_list[i].CategoryName);
            }

        })
        axios.get("accounts/stock_detail").then((response) => {
            this.item_stock_list = response.data
            this.optionstock = [];
            this.optionsageing = []
            var $this = this;
            for (var i = 0; i < $this.item_stock_list.length; i++) {
                this.optionstock.push($this.item_stock_list[i].Name);
                this.optionsageing.push($this.item_stock_list[i].Name);
            }
        })
        axios.get("get_linkprojects").then((response) => {
            this.proj_details = response.data
            this.optionsproj = [];

            var $this = this;
            for (var i = 0; i < $this.proj_details.length; i++) {
                this.optionsproj.push($this.proj_details[i].ProjectName);
            }
          
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
</style><style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
