
<template>
    <div>
                            <h6 class="mb-25 fw-bold">
                                <i class="fa-solid fa-receipt" style="padding-right: 10px"></i>
                                Accounts Reports
                            </h6>
                            <div class="ng-star-inserted">
                                <a data-bs-toggle="modal" data-bs-target="#balancesheet1">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Balance Sheet
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#CashFlowForTheYearEnded">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Cash Flow
                                        Statements
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#ChartofAccountsToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Chart of
                                        Accounts Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#DeliveryReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Delivery
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" @click="openGenLed()" >
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        General Ledger
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#profitorlossstatement">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Income
                                        Statement
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#TaxReportToggle">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Taxes
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#trailbalance">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Trial Balance
                                        Report
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#vendoroverallbalance">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Vendors Overall Balances
                                    </span>
                                </a>
                                <a data-bs-toggle="modal" @click="bankLedgerOpen" data-bs-target="#ledreport">
                                    <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>
                                        Bank Book Ledger
                                    </span>
                                </a>
                                <!-- <a data-bs-toggle="modal" data-bs-target="#balancesheet"><i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i><span>Balance Sheet</span></a> -->

                            </div>


<!-- Start Filter Balance Sheet -->
 <div class="modal fade" id="balancesheet1" aria-labelledby="balancesheet1" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="balancesheet_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Balance Sheet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="bs_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="bs_start_date == ''">{{
                                            e_bs_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="bs_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="bs_end_date == ''">{{
                                            e_bs_end_date }}</span>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="bsheet_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="bsheet_report1()"></button>
                    </div>

                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" @hasDownloaded="pdfL1=false" :preview-modal="false" :paginate-elements-by-height="5000" filename="Balance_Sheet_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="balancespdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h4 class="modal-title">SA Gardens (Pvt) Ltd</h4>
                                    <h4 class="modal-title">Statement of Financial Position</h4>
                                    <h4 class="modal-title">As at {{ this.session_end_date }}</h4>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Assets</th>
                                                <th scope="col" style="min-width: 100px;">Notes</th>
                                                <th scope="col">Rupees</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-danger" style="font-weight: bold;border-style: none !important; padding-bottom: 0px !important;">
                                                    Non Current Assets</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                            </tr>
                                            <tr v-for="curNonAssets_list1 in curNonAssets_list" :key="curNonAssets_list1">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ curNonAssets_list1.AccountName }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ Number(curNonAssets_list1.Amount).toLocaleString() }}</td>
                                            </tr>

                                            <tr>
                                                <td class="text-danger" style="font-weight: bold;border-style: none !important; border-style: none !important;">
                                                    Current Assets</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                            </tr>
                                            <tr v-for="curAssets_list1 in curAssets_list" :key="curAssets_list1">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ curAssets_list1.AccountName }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ currency }} {{ Number(curAssets_list1.Amount).toLocaleString() }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td style="font-weight:bold">Total:</td>

                                                <td style="font-weight:bold">{{ Number(this.asset_sum).toLocaleString() }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">EQUITY AND LIABILITIES</th>
                                                <th scope="col">Notes</th>
                                                <th scope="col">Rupees</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-danger" style="font-weight: bold;border-style: none !important; border-style: none !important;">
                                                    Share capital and reserves</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                            </tr>

                                            <tr v-for="shareCapital_list1 in shareCapital_list" :key="shareCapital_list1">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ shareCapital_list1.AccountName }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ Number(shareCapital_list1.Amount).toLocaleString() }}</td>
                                            </tr>

                                            <tr v-for="totalprofit_list1 in totalprofit_list" :key="totalprofit_list1">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ totalprofit_list1.AccountName }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ Number(totalprofit_list1.Amount).toLocaleString() }}</td>
                                            </tr>

                                            <tr>
                                                <td class="text-danger" style="font-weight: bold;padding-bottom: 0px !important; border-style: none !important;">
                                                    Non Current Liabilities</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                            </tr>

                                            <tr v-for="nonCurLiab_list1 in nonCurLiab_list" :key="nonCurLiab_list1">
                                                <td style="border-style: none !important; ">
                                                    {{ nonCurLiab_list1.AccountName }}</td>
                                                <td style="border-style: none !important; "></td>
                                                <td style="border-style: none !important; ">
                                                    {{ Number(nonCurLiab_list1.Amount).toLocaleString() }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-danger" style="font-weight: bold; padding-bottom: 0px !important; border-style: none !important;">
                                                    Current liabilities</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                            </tr>
                                            <tr v-for="CurLiab_list1 in CurLiab_list" :key="CurLiab_list1">
                                                <td style="border-style: none !important; ">
                                                    {{ CurLiab_list1.AccountName }}</td>
                                                <td style="border-style: none !important; "></td>
                                                <td style="border-style: none !important; ">
                                                    {{ Number(CurLiab_list1.Amount).toLocaleString() }}</td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td style="font-weight:bold">Total:</td>

                                                <td style="font-weight:bold">
                                                    {{ Number(this.liab_totalsum).toLocaleString() }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Balance_wise_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h4 class="modal-title">SA Gardens (Pvt) Ltd</h4>
                            <h4 class="modal-title">Statement of Financial Position</h4>
                            <h4 class="modal-title">As at {{ this.session_end_date }}</h4>

                        </div>

                        <div class="table-responsive" style="overflow-x: initial !important;">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Assets</th>
                                        <th scope="col" style="min-width: 100px;">Notes</th>
                                        <th scope="col">Rupees</th>
                                    </tr>
                                </thead>
                                <div v-if="Loader1" class="row">
                                     <div class="col-12 d-flex justify-content-center position-absolute">
                                         <div class="d-flex align-items-center">
                                             <div class="spinner-border text-secondary me-2" role="status">
                                             </div>
                                             <span class="loader-message">{{ Loader2 ? 'Processing data.This may take a few minutes...' : 'Please wait...' }}</span>
                                         </div>
                                     </div>
                                </div>
                                <tbody>
                                    <tr>
                                        <td class="text-danger" style="font-weight: bold;border-style: none !important; padding-bottom: 0px !important;">
                                            Non Current Assets</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                    </tr>
                                    <tr v-for="curNonAssets_list1 in curNonAssets_list" :key="curNonAssets_list1" v-if="toggle_balancesheet == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ curNonAssets_list1.AccountName }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ Number(curNonAssets_list1.Amount).toLocaleString() }}</td>
                                    </tr>

                                    <tr>
                                        <td class="text-danger" style="font-weight: bold;border-style: none !important; border-style: none !important;">
                                            Current Assets</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                    </tr>
                                    <tr v-for="curAssets_list1 in curAssets_list" :key="curAssets_list1" v-if="toggle_balancesheet == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ curAssets_list1.AccountName }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ Number(curAssets_list1.Amount).toLocaleString() }}</td>
                                    </tr>

                                    <tr v-if="toggle_balancesheet == false">
                                        <td></td>
                                        <td style="font-weight:bold">Total:</td>

                                        <td style="font-weight:bold">{{ Number(this.asset_sum).toLocaleString() }}</td>
                                    </tr>
                                    <tr v-if="toggle_balancesheet == true">
                                        <td></td>
                                        <td>
                                            <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                <div class="ldio-qxxhsg5wen">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">EQUITY AND LIABILITIES</th>
                                        <th scope="col">Notes</th>
                                        <th scope="col">Rupees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-danger" style="font-weight: bold;border-style: none !important; border-style: none !important;">
                                            Share capital and reserves</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                    </tr>

                                    <tr v-for="shareCapital_list1 in shareCapital_list" :key="shareCapital_list1" v-if="toggle_balancesheet == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ shareCapital_list1.AccountName }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ Number(shareCapital_list1.Amount).toLocaleString() }}</td>
                                    </tr>
                                    <tr v-for="totalprofit_list1 in totalprofit_list" :key="totalprofit_list1" v-if="toggle_balancesheet == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ totalprofit_list1.AccountName }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            {{ Number(totalprofit_list1.Amount).toLocaleString() }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger" style="font-weight: bold;padding-bottom: 0px !important; border-style: none !important;">
                                            Non Current Liabilities</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                    </tr>

                                    <tr v-for="nonCurLiab_list1 in nonCurLiab_list" :key="nonCurLiab_list1" v-if="toggle_balancesheet == false">
                                        <td style="border-style: none !important; ">{{ nonCurLiab_list1.AccountName }}
                                        </td>
                                        <td style="border-style: none !important; "></td>
                                        <td style="border-style: none !important; ">
                                            {{ Number(nonCurLiab_list1.Amount).toLocaleString() }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-danger" style="font-weight: bold; padding-bottom: 0px !important; border-style: none !important;">
                                            Current liabilities</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                    </tr>
                                    <tr v-for="CurLiab_list1 in CurLiab_list" :key="CurLiab_list1" v-if="toggle_balancesheet == false">
                                        <td style="border-style: none !important; ">{{ CurLiab_list1.AccountName }}</td>
                                        <td style="border-style: none !important; "></td>
                                        <td style="border-style: none !important; ">
                                            {{ Number(CurLiab_list1.Amount).toLocaleString() }}</td>
                                    </tr>

                                    <tr v-if="toggle_balancesheet == false">
                                        <td></td>
                                        <td style="font-weight:bold">Total:</td>

                                        <td style="font-weight:bold">{{ Number(this.liab_totalsum).toLocaleString() }}
                                        </td>
                                    </tr>
                                    <tr v-if="toggle_balancesheet == true">
                                        <td></td>
                                        <td>
                                            <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                <div class="ldio-qxxhsg5wen">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'Balance_wise_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateBalanceSReport()" class="btn btn-gradient-info">
                            <i v-if="pdfL1" class="spinner-border spinner-border-sm"></i>

                            Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="bsheet_report1()">close</button>
                    </div>
                </div>
            </div>
</div>
<!-- End Filter Balance Sheet -->

 <!--Start CashFlowForTheYearEnded-->
 <div class="modal fade" id="CashFlowForTheYearEnded" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="CashFlow_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Cash Flow Statements</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="cashF_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="cashF_start_date == ''">{{ e_cashF_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="cashF_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="cashF_end_date == ''">{{ e_cashF_end_date }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="CashF_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cash Flow For The Year Ended</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="CashF_report1()"></button>
                    </div>

                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Profit_Loss_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="CashFlowForTheEndedYearpdf">
                        <div slot="pdf-content">
                            <div class="modal-body" id="Datewise_CashFlowStatement_Detail">
                                <div style="margin-top: 20px;margin-bottom: 20px;  color:#0000ff">
                                    <h5 class="modal-title" style=" color:#0000ff; font-weight: bold;">
                                        SA Gardens
                                        (Pvt) Ltd
                                    </h5>
                                    <h5 class="modal-title" style=" color:#0000ff">STATEMENT OF CASH FLOWS</h5>
                                    <h5 class="modal-title" style=" color:#0000ff">
                                        FOR THE YEAR ENDED DECEMBER
                                        31,2022
                                    </h5>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="no-spacing" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col" style="padding-left: 30px">Notes</th>
                                                <th scope="col" style="padding-left: 70px">Amount</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold; color:#0000ff;border-style: none !important;">
                                                    Cash Flow From operating activities
                                                </td>

                                            </tr>
                                            <tr style="height: 0;">
                                                <td style=" border-style: none !important; padding-top: 0px;">
                                                    Cash
                                                    generated from operations
                                                </td>
                                            </tr>
                                            <tr style="height: 0;">
                                                <td style=" border-style: none !important; display: block;">
                                                    Decrease
                                                    in long terms-net
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important; display: block;">
                                                    Advance
                                                    tax payables
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">Dealers security</td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    Advance tax payables
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">Commission Payables</td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    Increase/decrease in
                                                    customer security deposits- interset free
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    Adnaces,deposits,prepayments and other receivables
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">Stores and spares</td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    Workers profit
                                                    participation fund paid
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">Income taxes paid </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">
                                                    Net
                                                    cash generated from opertaing activities
                                                </td>

                                            </tr>
                                            <tr>
                                                <td style="height: 30px"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color:#0000ff;border-style: none !important;">
                                                    Cash Flow From Investigating activities
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    Fixed Capital
                                                    expenditure
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    Sales proceeds from
                                                    disposal of property,plant and equipment
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">
                                                    Net
                                                    cash used in investing activities
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height: 30px"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color:#0000ff;border-style: none !important;">
                                                    Cash Flow From Financing activities
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">Fixed cost paid </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    long term finances-net
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-style: none !important;">
                                                    lease liabilities-net
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" border-style: none !important;">
                                                    short term borrowings
                                                    -net
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-style: none !important;">Dividend paid</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">
                                                    Net
                                                    cash used in financing activities
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height: 30px"></td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">
                                                    Net
                                                    increase/deacrase in cash and cash equivalent
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">
                                                    cash
                                                    and cash equivalent at beginning of the year
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">
                                                    cash
                                                    and cash equivalent at end of the year
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Datewise_CashFlowStatement_Detail">
                        <div style="margin-top: 20px;margin-bottom: 20px;  color:#0000ff">
                            <h5 class="modal-title" style=" color:#0000ff; font-weight: bold;">
                                SA Gardens
                                (Pvt) Ltd
                            </h5>
                            <h5 class="modal-title" style=" color:#0000ff">STATEMENT OF CASH FLOWS</h5>
                            <h5 class="modal-title" style=" color:#0000ff">
                                FOR THE YEAR ENDED DECEMBER 31,2022
                            </h5>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="no-spacing" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col" style="padding-left: 30px">Notes</th>
                                        <th scope="col" style="padding-left: 70px">Amount</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold; color:#0000ff;border-style: none !important;">
                                            Cash Flow From operating activities
                                        </td>

                                    </tr>
                                    <tr style="height: 0;">
                                        <td style=" border-style: none !important; padding-top: 0px;">
                                            Cash
                                            generated from operations
                                        </td>
                                    </tr>
                                    <tr style="height: 0;">
                                        <td style=" border-style: none !important; display: block;">
                                            Decrease
                                            in long terms-net
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important; display: block;">
                                            Advance
                                            tax payables
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">Dealers security</td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            Advance tax payables
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">Commission Payables</td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            Increase/decrease in
                                            customer security deposits- interset free
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            Adnaces,deposits,prepayments and other receivables
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">Stores and spares</td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            Workers profit
                                            participation fund paid
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">Income taxes paid </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">
                                            Net
                                            cash generated from opertaing activities
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="height: 30px"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color:#0000ff;border-style: none !important;">
                                            Cash Flow From Investigating activities
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            Fixed Capital
                                            expenditure
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            Sales proceeds from
                                            disposal of property,plant and equipment
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">
                                            Net
                                            cash used in investing activities
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 30px"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; color:#0000ff;border-style: none !important;">
                                            Cash Flow From Financing activities
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">Fixed cost paid </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            long term finances-net
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-style: none !important;">
                                            lease liabilities-net
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border-style: none !important;">
                                            short term borrowings
                                            -net
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-style: none !important;">Dividend paid</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">
                                            Net
                                            cash used in financing activities
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 30px"></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">
                                            Net
                                            increase/deacrase in cash and cash equivalent
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">
                                            cash
                                            and cash equivalent at beginning of the year
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">
                                            cash
                                            and cash equivalent at end of the year
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'Datewise_CashFlowStatement_Detail')" class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateCashflowstatementReport()" class="btn btn-gradient-info">
                            Pdf
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">close</button>
                    </div>
                </div>
            </div>
 </div>
 <!--End CashFlowForTheYearEnded-->

  <!-- Start Chart of Accounts -->
  <div class="modal fade" id="ChartofAccountsToggle" aria-labelledby="ChartofAccountsToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="chart_Account_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Search Chart of Accounts
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Select</label>

                                    <multiselect :show-labels="false" v-model="chart_check" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="All" :options="chartoption">
                                    </multiselect>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="chartofAccounts_Summary()">
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
                            <span style="width: 80%">Chart of Accounts Report</span>
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="chartofAccounts_Summary1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" @hasDownloaded="pdfL2=false" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Ledger_Detail_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="accountspdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Account Type:</strong> {{ chart_check }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="    min-width: 100px;">Account ID</th>
                                                <th scope="col">Account Name</th>
                                                <th scope="col">Account Code</th>
                                                <th scope="col">Account Head</th>
                                                <th scope="col">Coa Type</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="itemlist1 in account_list">
                                                <td>{{ itemlist1.ID }}</td>
                                                <td>{{ itemlist1.AccountName }}</td>
                                                <td>{{ itemlist1.AccountCode }}</td>
                                                <td>{{ itemlist1.AccountHead }}</td>
                                                <td>{{ itemlist1.CoaType }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="AccountsListToggle">
                        <h6><strong>Account Type:</strong> {{ chart_check }}</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="    min-width: 100px;">Account ID</th>
                                    <th scope="col">Account Name</th>
                                    <th scope="col">Account Code</th>
                                    <th scope="col">Account Head</th>
                                    <th scope="col">Coa Type</th>
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
                                <tr v-for="itemlist1 in account_list" v-if="toggle_accountshead == false">
                                    <td>{{ itemlist1.ID }}</td>
                                    <td>{{ itemlist1.AccountName }}</td>
                                    <td>{{ itemlist1.AccountCode }}</td>
                                    <td>{{ itemlist1.AccountHead }}</td>
                                    <td>{{ itemlist1.CoaType }}</td>
                                </tr>
                                <tr v-if="toggle_accountshead == true">
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="
                                html_table_to_excel('xlsx', 'AccountsListToggle')
                                " class="btn btn-gradient-info">
                            Excel
                        </button>
                        <button type="button" @click="generateChartofAccountsReport()" class="btn btn-gradient-info">
                            <i v-if="pdfL2" class="spinner-border spinner-border-sm"></i>
                            Pdf
                        </button>
                        <button type="button" class="btn btn-gradient-primary" data-bs-dismiss="modal" @click="chartofAccounts_Summary1()">
                            close
                        </button>
                    </div>
                </div>
            </div>
 </div>
 <!--End Chart of Accounts -->
 <!-- Start Delivery Detail Report -->
 <div class="modal fade" id="DeliveryReportToggle" aria-labelledby="DeliveryReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="delivery_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delivery Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Select</label>
                                    <multiselect style="margin-right: 10px;" v-model="delivery" :options="optionsdelivery">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="deliverydetails_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Delivery Detail Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="deliverydetails_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" @hasDownloaded="pdfL3=false" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Delivery_Detail_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="deliverypdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Delivery Type:</strong> {{ delivery }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="    min-width: 100px;">Delivery Name</th>
                                                <th scope="col">Delivery Type</th>
                                                <th scope="col">ReferenceAccount</th>
                                                <th scope="col">Delivery Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="tax_list1 in delivery_list">
                                                <td>{{ tax_list1.DeliveryName }}</td>
                                                <td>{{ tax_list1.DeliveryType }}</td>
                                                <td>{{ tax_list1.ReferenceAccount }}</td>
                                                <td>{{ currency }}.
                                                    {{ Number(tax_list1.DeliveryAmount).toLocaleString() }}/-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="delivery_details">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Delivery Type:</strong> {{ delivery }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="    min-width: 100px;">Delivery Name</th>
                                        <th scope="col">Delivery Type</th>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Delivery Amount</th>
                                    </tr>
                                </thead>
                                <div v-if="Loader3" class="row">
                                     <div class="col-12 d-flex justify-content-center position-absolute">
                                         <div class="d-flex align-items-center">
                                             <div class="spinner-border text-secondary me-2" role="status">
                                             </div>
                                             <span class="loader-message">{{ Loader3 ? 'Processing data.This may take a few minutes...' : 'Please wait...' }}</span>
                                         </div>
                                     </div>
                                </div>
                                <tbody>
                                    <tr v-for="tax_list1 in delivery_list" :key="tax_list1" v-if="toggle_delivery == false">
                                        <td>{{ tax_list1.DeliveryName }}</td>
                                        <td>{{ tax_list1.DeliveryType }}</td>
                                        <td>{{ tax_list1.ReferenceAccount }}</td>
                                        <td>{{ currency }}. {{ Number(tax_list1.DeliveryAmount).toLocaleString() }}/-</td>
                                    </tr>
                                    <tr v-if="toggle_delivery == true">
                                        <td></td>
                                        <td>
                                            <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                <div class="ldio-qxxhsg5wen">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <div v-if="delivery_list.length==0" class="row">
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
                        <button type="button" @click="html_table_to_excel('xlsx', 'delivery_details')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateDeliverydetailReport()" class="btn btn-gradient-info">
                            <i v-if="pdfL3" class="spinner-border spinner-border-sm"></i>
                            Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="deliverydetails_report1()">close</button>
                    </div>
                </div>
            </div>
 </div>
<!-- End Delivery Detail Report -->

        <!--Start General Ledger Report -->
        <div class="modal fade" id="ledreport" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="ledger_detail == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ bankledger ? 'Filter Bank Book Report' : 'Filter General Ledger Report' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="l_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="l_start_date == ''">{{e_l_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="l_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="l_end_date == ''">{{e_l_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div v-if="bankledger">
                                        <label class="form-label">Bank Name</label>
                                        <multiselect style="margin-right: 10px;" v-model="l_vendor_name" :multiple="true" :options="bankBoook" group-values="banks" group-label="select" :group-select="true">

                                        </multiselect>
                                    </div>
                                    <div v-else>
                                        <label class="form-label">Transaction Head Name</label>
                                        <multiselect style="margin-right: 10px;" v-model="l_vendor_name"  :options="options1">
                                        </multiselect>
                                    </div>


                                    <span style="color: #db4437; font-size: 11px" v-if="l_vendor_name == ''">{{e_l_vendor_name }}</span>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="bankledger ? BankledgerFun() : ledger_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">{{ bankledger ? 'Filter Bank Book Report' : 'Filter General Ledger Report' }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="ledger_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Ledger_Detail_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="Ledgerpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col" style="    min-width: 100px;">Delivery Name</th>
                                            <th scope="col">Delivery Type</th>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Delivery Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="tax_list1 in delivery_list" :key="tax_list1" v-if="toggle_delivery == false">
                                            <td>{{ tax_list1.DeliveryName }}</td>
                                            <td>{{ tax_list1.DeliveryType }}</td>
                                            <td>{{ tax_list1.ReferenceAccount }}</td>
                                            <td>{{ currency }}. {{ Number(tax_list1.DeliveryAmount).toLocaleString() }}/-</td>
                                        </tr>
                                        <!--                                    <tr v-if="toggle_delivery == true">-->
                                        <!--                                        <td></td>-->
                                        <!--                                        <td>-->
                                        <!--                                            <div class="loadingio-spinner-bars-0opevbvvjcw">-->
                                        <!--                                                <div class="ldio-qxxhsg5wen">-->
                                        <!--                                                    <div></div>-->
                                        <!--                                                    <div></div>-->
                                        <!--                                                    <div></div>-->
                                        <!--                                                    <div></div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </td>-->
                                        <!--                                        <td></td>-->
                                        <!--                                        <td></td>-->
                                        <!--                                    </tr>-->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th scope="col" style="    min-width: 100px;">Date</th>
                                            <th>Ref.No</th>
                                            <th scope="col">Description</th>
                                            <th scope="col" style="text-align:right">Debit</th>
                                            <th scope="col" style="text-align:right">Credit</th>
                                            <th scope="col" style="text-align:right">Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="ledger_d.length >0"  v-for="ledger_d1 in ledger_d">
                                            <td>{{ ledger_d1.RowNumber }}</td>
                                            <td>{{ ledger_d1.TransactionDate }}</td>
                                            <td>{{ ledger_d1.DocumentNo }}</td>
                                            <td>{{ ledger_d1.Description }}</td>
                                            <td style="text-align:right">{{ Number(ledger_d1.Debit).toLocaleString() }}
                                            </td>
                                            <td style="text-align:right">{{ Number(ledger_d1.Credit).toLocaleString() }}
                                            </td>
                                            <td style="text-align:right">{{ Number(ledger_d1.balance).toLocaleString() }}
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <h2>No data</h2>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="table-responsive position-relative p-3" id="ledgerReport"  style="overflow-x: initial !important;">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <div v-if="bankledger" >
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Account ID</th>
                                        <th scope="col">Account Name</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Opening Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="ledger_d_detail1 in ledger_d_detail">
                                        <td>{{ledger_d_detail1.AccountID}}</td>
                                        <td>{{ledger_d_detail1.AccountName}}</td>
                                        <td>{{ ledger_d_detail1.am.toLocaleString() }}</td>
                                        <td><strong>Opening Balance: </strong> {{currency}} {{Number(opening_balance).toLocaleString()}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <h6><strong>Date:</strong> {{this.l_start_date}} To {{this.l_end_date}}</h6>
                                <div v-for="ledger_d_detail1 in ledger_d_detail">
                                    <h6><strong>Account ID:</strong> {{ledger_d_detail1.AccountID}}</h6>
                                    <h6><strong>Account Name:</strong> {{ledger_d_detail1.AccountName}}</h6>
                                    <h6><strong>Balance: </strong>{{currency}}. {{ledger_d_detail1.am.toLocaleString()}}</h6>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <h6><strong>Opening Balance: </strong> {{currency}} {{Number(opening_balance).toLocaleString()}}</h6>
                                </div>
                            </div>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th scope="col" style="min-width: 100px;">Date</th>
                                <th>Ref.No</th>
                                <th scope="col">Description</th>
                                <th scope="col" style="text-align:right">Debit</th>
                                <th scope="col" style="text-align:right">Credit</th>
                                <th scope="col" style="text-align:right">Balance</th>
                            </tr>
                            </thead>
                            <div v-if="ledherloader" class="row">
                                <div class="col-12 d-flex justify-content-center position-absolute">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-border text-secondary me-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="loader-message">{{ excelLoader ? 'Processing data.This may take a few minutes...' : 'Please wait...' }}</span>
                                    </div>
                                </div>
                            </div>
                            <tbody v-else>
                            <tr v-for="(ledger_d1, index) in ledger_d" >
                                <td>{{bankledger ? index+1 : ledger_d1.RowNumber}}</td>
                                <td>{{ledger_d1.TransactionDate}}</td>
                                <td>{{ledger_d1.DocumentNo}}</td>
                                <td>{{ledger_d1.Description}}</td>
                                <td style="text-align:right">{{Number(ledger_d1.Debit).toLocaleString()}}</td>
                                <td style="text-align:right">{{Number(ledger_d1.Credit).toLocaleString()}}</td>
                                <td style="text-align:right">{{Number(ledger_d1.balance).toLocaleString()}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <!--                        <table class="table">-->
                        <!--                            <thead>-->
                        <!--                            <tr>-->
                        <!--                                <th>S.no</th>-->
                        <!--                                <th scope="col" style="min-width: 100px;">Date</th>-->
                        <!--                                <th>Ref.No</th>-->
                        <!--                                <th scope="col">Description</th>-->
                        <!--                                <th scope="col" style="text-align:right">Debit</th>-->
                        <!--                                <th scope="col" style="text-align:right">Credit</th>-->
                        <!--                                <th scope="col" style="text-align:right">Balance</th>-->
                        <!--                            </tr>-->
                        <!--                            <div v-if="ledherloader" class="row ">-->
                        <!--                                <div class="col-12 d-flex justify-content-center position-absolute">-->
                        <!--                                    <div class="spinner-border text-secondary d-flex justify-content-center loader mt-5" role="status">-->
                        <!--                                        <span class="visually-hidden">Loading...</span>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                            <tbody v-else>-->
                        <!--                                <tr v-for="ledger_d1 in ledger_d" >-->
                        <!--                                    <td>{{ledger_d1.RowNumber}}</td>-->
                        <!--                                    <td>{{ledger_d1.TransactionDate}}</td>-->
                        <!--                                    <td>{{ledger_d1.DocumentNo}}</td>-->
                        <!--                                    <td>{{ledger_d1.Description}}</td>-->
                        <!--                                    <td style="text-align:right">{{Number(ledger_d1.Debit).toLocaleString()}}</td>-->
                        <!--                                    <td style="text-align:right">{{Number(ledger_d1.Credit).toLocaleString()}}</td>-->
                        <!--                                    <td style="text-align:right">{{Number(ledger_d1.balance).toLocaleString()}}</td>-->
                        <!--                                </tr>-->
                        <!--                            </tbody>-->
                        <!--                            </thead>-->
                        <!--                        </table>-->
                        <!--                    </table>-->
                    </div>
                    <div class="row mx-3 mb-2 d-flex justify-content-between">
                        <div class="col-2">
                            <div v-if="!bankledger" class="form-inline mt-2">
                                <label for="perPage">Items Per Page:</label>
                                <select id="perPage" class="form-control ml-2" v-model="pag_len" @change="changePageLen">
                                    <option value=500>500</option>
                                    <option value=1000>1000</option>
                                    <option value=2000>2000</option>
                                    <option value=3000>3000</option>
                                    <option value=4000>4000</option>
                                    <option value=6000>6000</option>
                                    <!--                                        <option value="all">All</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-4" v-if="!ledherloader">
                            <div style="text-align:center;padding-top:20px">
                                <pagination class="float-end" :data="pagination" @pagination-change-page="changePage" :limit="5"></pagination>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="!ledherloader">

                        <button v-if="bankledger" type="button" @click="html_table_to_excel('xlsx', 'ledgerReport')" class="btn btn-gradient-info">
                            <div v-if="genPdfLoader">
                                <div class="spinner-border text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div v-else>
                                <span>Excel</span>
                            </div>
                        </button>

                        <button v-else type="button" @click="genPdfLoader ? '' : downloadExcel()" class="btn btn-gradient-info">
                            <div v-if="genPdfLoader">
                                <div class="spinner-border text-secondary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div v-else>
                                <span>Excel</span>
                            </div>
                        </button>

                        <a target="_blank" v-bind:href="`ledger_get_general/${l_start_date}/${l_end_date}/${l_vendor_name}`" class="btn btn-gradient-info">
                            Pdf
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="ledger_report1()">close</button>
                    </div>

                </div>

                <div class="modal-body d-none" id="Datewise_Ledger_Detail">
                    <div style="margin-top: 20px;margin-bottom: 20px;">
                        <h6><strong>Date:</strong> {{this.l_start_date}} To {{this.l_end_date}}</h6>
                        <div v-for="ledger_d_detail1 in ledger_d_detail">
                            <h6><strong>Account ID:</strong> {{ledger_d_detail1.AccountID}}</h6>
                            <h6><strong>Account Name:</strong> {{ledger_d_detail1.AccountName}}</h6>
                            <h6><strong>Balance: </strong>{{currency}}. {{ledger_d_detail1.am.toLocaleString()}}</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <h6><strong>Opening Balance: </strong> {{currency}} {{Number(opening_balance).toLocaleString()}}</h6>
                    </div>
                    <div class="table-responsive position-relative" style="overflow-x: initial !important;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th scope="col" style="min-width: 100px;">Date</th>
                                <th>Ref.No</th>
                                <th scope="col">Description</th>
                                <th scope="col" style="text-align:right">Debit</th>
                                <th scope="col" style="text-align:right">Credit</th>
                                <th scope="col" style="text-align:right">Balance</th>
                            </tr>
                            <tr v-for="ledger_d1 in allLedger">
                                <td>{{ledger_d1.RowNumber}}</td>
                                <td>{{ledger_d1.TransactionDate}}</td>
                                <td>{{ledger_d1.DocumentNo}}</td>
                                <td>{{ledger_d1.Description}}</td>
                                <td style="text-align:right">{{Number(ledger_d1.Debit).toLocaleString()}}</td>
                                <td style="text-align:right">{{Number(ledger_d1.Credit).toLocaleString()}}</td>
                                <td style="text-align:right">{{Number(ledger_d1.balance).toLocaleString()}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--            </div>-->
                    <!--                    <div class="modal-footer">-->

                    <!--                        <button type="button" @click="genPdfLoader ? '' : html_table_to_excel('xlsx','Datewise_Ledger_Detail')" class="btn btn-gradient-info">-->
                    <!--                            <div v-if="genPdfLoader" class="row">-->
                    <!--                                    <div class="spinner-border text-secondary d-flex justify-content-center loader mt-5" role="status">-->
                    <!--                                        <span class="visually-hidden">Loading...</span>-->
                    <!--                                    </div>-->
                    <!--                            </div>-->
                    <!--                            <div v-else>-->
                    <!--                                <span>Excel</span>-->
                    <!--                            </div>-->
                    <!--                        </button>-->
                    <!--                        <buuton class="btn btn-primary" @click="downloadExcel">-->
                    <!--                            download excel-->
                    <!--                        </buuton>-->

                    <!--                        <a target="_blank" v-bind:href="`ledger_get_general/${l_start_date}/${l_end_date}/${l_vendor_name}`"-->
                    <!--                            class="btn btn-gradient-info">-->
                    <!--                            Pdf-->
                    <!--                        </a>-->
                    <!--                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"-->
                    <!--                            @click="ledger_report1()">close</button>-->
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!--End General Ledger Report -->

   <!-- Start Income Statement -->
 <div class="modal fade" id="profitorlossstatement" aria-labelledby="profitorlossstatement" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="profit_loss_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Income Statement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="ploss_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="ploss_start_date == ''">{{
                                            e_ploss_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="ploss_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="ploss_end_date == ''">{{
                                            e_ploss_end_date }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="ploss_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="ploss_report1()"></button>
                    </div>

                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Profit_Loss_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="plosspdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h4 class="modal-title">SA Gardens (Pvt) Ltd</h4>
                                    <h4 class="modal-title">Statement of Profit or Loss</h4>
                                    <h4 class="modal-title">As at {{ this.session_end_date }}</h4>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Notes</th>
                                                <th scope="col">Rupees</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    Revenue</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                            </tr>

                                            <tr v-for="cost_ofland_list1 in cost_ofland_list" :key="cost_ofland_list1">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ cost_ofland_list1.AccountHead }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ Number(cost_ofland_list1.Amount).toLocaleString() }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">Gross
                                                    Profit.</td>
                                                <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                                    Total:</td>
                                                <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                                    {{ Number(cost_ofland_sum).toLocaleString() }}</td>
                                            </tr>
                                            <tr>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                            </tr>
                                            <tr v-for="operating_list1 in operating_list" :key="operating_list1">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ operating_list1.AccountHead }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ Number(operating_list1.Amount).toLocaleString() }}</td>
                                            </tr>

                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">Operating
                                                    profit</td>
                                                <td style="text-align: right;font-weight: bold; border-style: none !important;">
                                                    Total:</td>
                                                <td style="text-align: right;font-weight: bold; border-style: none !important;">
                                                    {{ Number(operating_prof_sum).toLocaleString() }}/-</td>
                                            </tr>

                                            <tr>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                            </tr>
                                            <tr v-for="gross_profit_list1 in gross_profit_list">
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ gross_profit_list1.AccountHead }}</td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                </td>
                                                <td style="border-style: none !important; padding-bottom: 0px !important;">
                                                    {{ Number(gross_profit_list1.Amount).toLocaleString() }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;"></td>
                                                <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                                    Total:</td>
                                                <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                                    {{ Number(grossprofit_sum).toLocaleString() }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">Profit
                                                    before taxation</td>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                            </tr>
                                            <tr>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                            </tr>

                                            <tr>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;"></td>
                                            </tr>
                                            <tr v-for="is_taxation_list1 in is_taxation_list" :key="is_taxation_list1">
                                                <td style="border-style: none !important;">{{
                                                        is_taxation_list1.AccountHead }}</td>
                                                <td style="border-style: none !important;"></td>
                                                <td style="border-style: none !important;">{{
                                                        Number(is_taxation_list1.Amount).toLocaleString() }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; border-style: none !important;">Profit
                                                    after taxation</td>
                                                <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                                    Total:</td>
                                                <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                                    {{ Number(incometaxation_sum).toLocaleString() }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="profit_loss_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h4 class="modal-title">SA Gardens (Pvt) Ltd</h4>
                            <h4 class="modal-title">Statement of Profit or Loss</h4>
                            <h4 class="modal-title">As at {{ this.session_end_date }}</h4>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Notes</th>
                                        <th scope="col">Rupees</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">
                                            Revenue</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                    </tr>

                                    <tr v-for="cost_ofland_list1 in cost_ofland_list" :key="cost_ofland_list1" v-if="toggle_profitloss == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">{{
                                                cost_ofland_list1.AccountHead }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">{{
                                                Number(cost_ofland_list1.Amount).toLocaleString() }}</td>
                                    </tr>
                                    <tr v-if="toggle_profitloss == false">
                                        <td style="font-weight: bold; border-style: none !important;">Gross Profit.</td>
                                        <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                            Total:</td>
                                        <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                            {{ Number(cost_ofland_sum).toLocaleString() }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                    </tr>
                                    <tr v-for="operating_list1 in operating_list" :key="operating_list1" v-if="toggle_profitloss == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">{{
                                                operating_list1.AccountHead }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">{{
                                                Number(operating_list1.Amount).toLocaleString() }}</td>
                                    </tr>

                                    <tr v-if="toggle_profitloss == false">
                                        <td style="font-weight: bold; border-style: none !important;">Operating profit
                                        </td>
                                        <td style="text-align: right;font-weight: bold; border-style: none !important;">
                                            Total:</td>
                                        <td style="text-align: right;font-weight: bold; border-style: none !important;">
                                            {{ Number(operating_prof_sum).toLocaleString() }}</td>
                                    </tr>

                                    <tr>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                    </tr>
                                    <tr v-for="gross_profit_list1 in gross_profit_list" v-if="toggle_profitloss == false">
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">{{
                                                gross_profit_list1.AccountHead }}</td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;"></td>
                                        <td style="border-style: none !important; padding-bottom: 0px !important;">{{
                                                Number(gross_profit_list1.Amount).toLocaleString() }}</td>
                                    </tr>
                                    <tr v-if="toggle_profitloss == false">
                                        <td style="font-weight: bold; border-style: none !important;"></td>
                                        <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                            Total:</td>
                                        <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                            {{ Number(grossprofit_sum).toLocaleString() }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; border-style: none !important;">Profit before
                                            taxation</td>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                    </tr>
                                    <tr>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                    </tr>

                                    <tr>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;"></td>
                                    </tr>
                                    <tr v-for="is_taxation_list1 in is_taxation_list" :key="is_taxation_list1" v-if="toggle_profitloss == false">
                                        <td style="border-style: none !important;">{{ is_taxation_list1.AccountHead }}
                                        </td>
                                        <td style="border-style: none !important;"></td>
                                        <td style="border-style: none !important;">{{
                                                Number(is_taxation_list1.Amount).toLocaleString() }}</td>
                                    </tr>
                                    <tr v-if="toggle_profitloss == false">
                                        <td style="font-weight: bold; border-style: none !important;">Profit after
                                            taxation</td>
                                        <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                            Total:</td>
                                        <td style="text-align: right;font-weight: bold;border-style: none !important;">
                                            {{ Number(incometaxation_sum).toLocaleString() }}</td>
                                    </tr>
                                    <tr v-if="toggle_profitloss == true">
                                        <td></td>
                                        <td>
                                            <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                <div class="ldio-qxxhsg5wen">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'profit_loss_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateProfitLossReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="ploss_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
   <!--End Income Statement -->

 <!--Start Tax Detail Report -->
 <div class="modal fade" id="TaxReportToggle" aria-labelledby="TaxReportToggle" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="tax_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Taxes Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Select</label>
                                    <multiselect style="margin-right: 10px;" v-model="tax" :options="optionstax">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <a target="_blank" v-bind:href="`Accounts/tax_letter1/${tax}`" class="btn btn-primary">
                                View Report
                            </a> -->
                        <button class="btn btn-primary" @click="taxdetails_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Taxes Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="taxdetails_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Tax_Detail_Report" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="taxpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Tax Type:</strong> {{ tax }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="    min-width: 100px;">Tax Name</th>
                                                <th scope="col">Tax Type</th>
                                                <th scope="col">Reference Account</th>
                                                <th scope="col">Tax Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="tax_list1 in tax_list" :key="tax_list1">
                                                <td>{{ tax_list1.TaxName }}</td>
                                                <td>{{ tax_list1.TaxType }}</td>
                                                <td>{{ tax_list1.ReferenceAccount }}</td>
                                                <td>{{ currency }}. {{ Number(tax_list1.TaxAmount).toLocaleString() }}/-
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="tax_detail">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Tax Type:</strong> {{ tax }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="    min-width: 100px;">Tax Name</th>
                                        <th scope="col">Tax Type</th>
                                        <th scope="col">Reference Account</th>
                                        <th scope="col">Tax Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="tax_list1 in tax_list" :key="tax_list1">
                                        <td>{{ tax_list1.TaxName }}</td>
                                        <td>{{ tax_list1.TaxType }}</td>
                                        <td>{{ tax_list1.ReferenceAccount }}</td>
                                        <td>{{ currency }}. {{ Number(tax_list1.TaxAmount).toLocaleString() }}/-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'tax_detail')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateTaxdetailReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="taxdetails_report1()">close</button>
                    </div>
                </div>
            </div>
 </div>
 <!--End Tax Detail Report -->
<!--Start Trial Balance Reports -->
 <div class="modal fade" id="trailbalance" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
        <div v-if="trail_detail == ''" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Trial Balance Reports</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form -->
                    <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Range From</label>
                                <input type="date" v-model="t_start_date" class="form-control" />
                                <span style="color: #db4437; font-size: 11px" v-if="t_start_date == ''">{{
                                        e_t_start_date }}</span>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Range To</label>
                                <input v-model="t_end_date" type="date" class="form-control" />
                                <span style="color: #db4437; font-size: 11px" v-if="t_end_date == ''">{{
                                        e_t_end_date }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" @click="trail_report()">
                        View Report
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
        <div v-else class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Trial Balance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="trail_report1()"></button>
                </div>
                <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Trail_Detail_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="TrailBalancepdf">
                    <div slot="pdf-content">
                        <div class="modal-body" id="Datewise_Trail_Detail">
                            <div style="margin-top: 20px;margin-bottom: 20px;">
                                <!--<h6><strong>Date:</strong> {{this.t_start_date}} To {{this.t_end_date}}</h6>-->
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="    min-width: 100px;">Account ID</th>
                                            <th scope="col">Account Name</th>
                                            <th scope="col" style="text-align:right">Debit</th>
                                            <th scope="col" style="text-align:right">Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="trail_d1 in trail_d">
                                            <td>{{ trail_d1.AccountID }}</td>
                                            <td>{{ trail_d1.AccountName }}</td>
                                            <td style="text-align:right">{{ Number(trail_d1.Debit).toLocaleString() }}
                                            </td>
                                            <td style="text-align:right">{{ Number(trail_d1.Credit).toLocaleString() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold">Total:</td>
                                            <td></td>
                                            <td style="text-align:right;font-weight:bold">
                                                {{ parseInt(this.debitSum).toLocaleString() }}</td>
                                            <td style="text-align:right;font-weight:bold">
                                                {{ parseInt(this.creditSum).toLocaleString() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </vue-html2pdf>
                <div class="modal-body" id="Datewise_Trailbalance_Detail">
                    <div style="margin-top: 20px;margin-bottom: 20px;">
                        <h6><strong>Date:</strong> {{ this.t_start_date }} To {{ this.t_end_date }}</h6>
                    </div>
                    <div class="table-responsive" style="overflow-x: initial !important;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="    min-width: 100px;">Account ID</th>
                                    <th scope="col">Account Name</th>
                                    <th scope="col" style="text-align:right">Debit</th>
                                    <th scope="col" style="text-align:right">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="trail_d1 in trail_d" v-if="toggle_trialbalance == false">
                                    <td>{{ trail_d1.AccountID }}</td>
                                    <td>{{ trail_d1.AccountName }}</td>
                                    <td style="text-align:right"> {{ Number(trail_d1.Debit).toLocaleString() }}</td>
                                    <td style="text-align:right"> {{ Number(trail_d1.Credit).toLocaleString() }}</td>
                                </tr>
                                <tr v-if="toggle_trialbalance == false">
                                    <td style="font-weight:bold">Total:</td>
                                    <td></td>
                                    <td style="text-align:right;font-weight:bold">
                                        {{ parseInt(this.debitSum).toLocaleString() }}</td>
                                    <td style="text-align:right;font-weight:bold">
                                        {{ parseInt(this.creditSum).toLocaleString() }}</td>
                                </tr>
                                <tr v-if="toggle_trialbalance == true">
                                    <td></td>
                                    <td>
                                        <div class="loadingio-spinner-bars-0opevbvvjcw">
                                            <div class="ldio-qxxhsg5wen">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="html_table_to_excel('xlsx', 'Datewise_Trailbalance_Detail')" class="btn btn-gradient-info">Excel</button>
                    <a target="_blank" v-bind:href="`accounts/trial_balance_report/${t_start_date}/${t_end_date}`" class="btn btn-gradient-info">
                        Pdf
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="trail_report1()">close</button>
                </div>
            </div>
        </div>
    </div>
<!--End Trial Balance Reports  -->
<!-- Start Filter Vendor Overall Balance Reports -->
<div class="modal fade" id="vendoroverallbalance" aria-labelledby="vendoroverallbalance" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="vendor_overall_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Vendor Overall Balance Reports</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="vob_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="vob_start_date == ''">{{
                                            e_vob_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="vob_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="vob_end_date == ''">{{
                                            e_vob_end_date }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Transaction Head Name</label>
                                    <multiselect style="margin-right: 10px;" v-model="vob_vendor_name" :options="options1">
                                    </multiselect>
                                    <span style="color: #db4437; font-size: 11px" v-if="vob_vendor_name == ''">{{
                                            e_vob_vendor_name }}</span>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="vob_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width:1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Vendor Overall Balance Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="vob_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Vendor_Overall_Balance" :pdf-quality="3" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="venolpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.vob_start_date }} To {{ this.vob_end_date }}</h6>
                                    <div v-for="vendor_vol_list1 in vendor_vol_list">
                                        <h6><strong>Account ID:</strong> {{ vendor_vol_list1.AccountID }}</h6>
                                        <h6><strong>Account Name:</strong> {{ vendor_vol_list1.AccountName }}</h6>
                                        <h6><strong>Actual Balance: </strong> {{ currency }}. {{ vendor_vol_list1.am }}</h6>
                                        <h6><strong>Pdc Balance: </strong> {{ currency }}. {{ temp_sum }}</h6>
                                        <h6><strong>Overall Balance: </strong> {{ currency }}.
                                            {{ temp_sum * vendor_vol_list1.am }}</h6>
                                    </div>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.no</th>
                                                <th scope="col" style="    min-width: 100px;">Date</th>
                                                <th>Ref.No</th>
                                                <th scope="col">Description</th>
                                                <th scope="col" style="text-align:right">Debit</th>
                                                <th scope="col" style="text-align:right">Credit</th>
                                                <th scope="col" style="text-align:right">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ven_account_list1 in ven_account_list">
                                                <td>{{ ven_account_list1.RowNumber }}</td>
                                                <td>{{ ven_account_list1.TransactionDate }}</td>
                                                <td>{{ ven_account_list1.DocumentNo }}</td>
                                                <td>{{ ven_account_list1.Description }}</td>
                                                <td style="text-align:right">
                                                    {{ Number(ven_account_list1.Debit).toLocaleString() }}/-</td>
                                                <td style="text-align:right">
                                                    {{ Number(ven_account_list1.Credit).toLocaleString() }}/-</td>
                                                <td style="text-align:right">
                                                    {{ Number(ven_account_list1.balance).toLocaleString() }}/-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Chq Date</th>
                                                <th scope="col" style="    min-width: 100px;">Vendor Id</th>
                                                <th>Vendor Name</th>
                                                <th scope="col">Chq Number</th>
                                                <th scope="col" style="text-align:right">Chq Amount</th>
                                                <th scope="col" style="text-align:right">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="ven_account_list11 in vendor_vol_list2">
                                                <td>{{ ven_account_list11.ChqDate }}</td>
                                                <td>{{ ven_account_list11.VendorId }}</td>
                                                <td>{{ ven_account_list11.VendorName }}</td>
                                                <td>{{ ven_account_list11.ChqNo }}</td>
                                                <td>{{ Number(ven_account_list11.ChqAmount).toLocaleString() }}/-</td>
                                                <td>{{ ven_account_list11.Status }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Datewise_Ledger_Detail">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.vob_start_date }} To {{ this.vob_end_date }}</h6>
                            <div v-for="vendor_vol_list1 in vendor_vol_list">
                                <h6><strong>Account ID:</strong> {{ vendor_vol_list1.AccountID }}</h6>
                                <h6><strong>Account Name:</strong> {{ vendor_vol_list1.AccountName }}</h6>
                                <h6><strong>Actual Balance: </strong> {{ currency }}.
                                    {{ Number(vendor_vol_list1.am).toLocaleString() }}/-</h6>
                                <h6><strong>Pdc Balance: </strong> {{ currency }}. {{ Number(temp_sum).toLocaleString() }}/-
                                </h6>
                                <h6><strong>Overall Balance: </strong> {{ currency }}.
                                    {{ Number(temp_sum * vendor_vol_list1.am).toLocaleString() }}/-</h6>
                            </div>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th scope="col" style="    min-width: 100px;">Date</th>
                                        <th>Ref.No</th>
                                        <th scope="col">Description</th>
                                        <th scope="col" style="text-align:right">Debit</th>
                                        <th scope="col" style="text-align:right">Credit</th>
                                        <th scope="col" style="text-align:right">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="ven_account_list1 in ven_account_list">
                                        <td>{{ ven_account_list1.RowNumber }}</td>
                                        <td>{{ ven_account_list1.TransactionDate }}</td>
                                        <td>{{ ven_account_list1.DocumentNo }}</td>
                                        <td>{{ ven_account_list1.Description }}</td>
                                        <td style="text-align:right">
                                            {{ Number(ven_account_list1.Debit).toLocaleString() }}/-</td>
                                        <td style="text-align:right">
                                            {{ Number(ven_account_list1.Credit).toLocaleString() }}/-</td>
                                        <td style="text-align:right">
                                            {{ Number(ven_account_list1.balance).toLocaleString() }}/-</td>
                                    </tr>
                                    <tr v-if="toggle_overallbalance == true">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                <div class="ldio-qxxhsg5wen">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 class="modal-title  my-5" id="myModalLabel16">Vendor Pending Cheques</h4>
                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>Chq Date</th>
                                        <th scope="col">Vendor Id</th>
                                        <th>Vendor Name</th>
                                        <th scope="col">Chq Number</th>
                                        <th scope="col" style="text-align:right">Chq Amount</th>
                                        <th scope="col" style="text-align:right">Status</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="ven_account_list11 in vendor_vol_list2">
                                        <td>{{ ven_account_list11.ChqDate }}</td>
                                        <td>{{ ven_account_list11.VendorId }}</td>
                                        <td>{{ ven_account_list11.VendorName }}</td>
                                        <td>{{ ven_account_list11.ChqNo }}</td>
                                        <td>{{ Number(ven_account_list11.ChqAmount).toLocaleString() }}/-</td>
                                        <td>{{ ven_account_list11.Status }}</td>
                                    </tr>
                                    <tr v-if="toggle_overallbalance == true">
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                <div class="ldio-qxxhsg5wen">
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                    <div></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'Datewise_Ledger_Detail')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateOverallBalanceReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="vob_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- End Filter Vendor Overall Balance Reports -->



</div>
</template>


<script>
import VueHtml2pdf from 'vue-html2pdf'
import Multiselect from 'vue-multiselect'
import axios from "axios";
export default{
    props: {

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
            pag_len: 500,
            toggle_overallbalance: true,
            genPdfLoader: false,
            creditSum: '',
            debitSum: '',
            currency: '',
            toggle_delivery: true,
            ledger_detail: '',
            l_start_date: '',
            l_end_date: '',
            balancesheet_report: '',
            opening_balance: 0,
            session_end_date: '',
            toggle_trialbalance: true,
            CurLiab_list: {},
            e_l_start_date: '',
            e_l_end_date: '',
            e_l_vendor_name: '',
            l_vendor_name: '',
            is_taxation_list: {},
            operating_list: {},
            cost_ofland_list: {},
            ledger_d: {},
            shareCapital_list: {},
            ledger_d_detail: {},
            options1: [],
            curAssets_list: {},
            chart_Account_report: '',
            toggle_profitloss: true,
            chart_check: '',
            gross_profit_list: 0,
            chartoption: [],
            account_list: {},
            trail_detail: '',
            t_start_date: '',
            t_end_date: '',
            e_t_start_date: '',
            e_t_end_date: '',
            nonCurLiab_list: {},
            totalprofit_list: {},
            toggle_balancesheet: true,
            vob_start_date: '',
            vob_end_date: '',
            e_vob_start_date: '',
            e_vob_end_date: '',
            vob_vendor_name: '',
            e_vob_vendor_name: '',
            vendor_overall_report: '',
            vendor_vol_list: {},
            vendor_vol_list2: {},
            temp_sum: 0,
            ven_account_list: {},
            curNonAssets_list: {},
            bs_start_date: '',
            e_bs_start_date: '',
            e_bs_end_date: '',
            bs_end_date: '',
            trail_d: {},
            sum: {},
            tax: 'All',
            delivery: 'All',
            optionstax: ["Sales", "Purchase"],
            optionsdelivery: ["Sales", "Purchase"],
            delivery_report: '',
            profit_loss_report: '',
            tax_report: '',
            tax_list: {},
            delivery_list: {},
            CashFlow_report: '',
            cashF_start_date: '',
            cashF_end_date: '',
            e_cashF_start_date: '',
            e_cashF_end_date: '',
            ploss_start_date: '',
            e_ploss_start_date: '',
            ploss_end_date: '',
            e_ploss_end_date: '',
            newReq: '',
            ledherloader: false,
            pagination: '',
            allLedger: '',
            allBanks: [],
            methods: [],
            options2: [],
            bank_id: '',
            excelLoader: false,
            pdfL1:false,
            pdfL2:false,
            pdfL3:false,
            Loader1:false,
            Loader2:false,
            Loader3:false,
            bankledger: false,
            bankBoook: [],

        }
    },
    watch: {
        start_date(after, before) {
            this.newdata();
        },
    },
    methods: {
        openGenLed(){
            $("#ledreport").modal("show");
            this.bankledger = false;
        },
        BankledgerFun(){
            this.excelLoader = false;
            const validation = this.$helpers.validateDateRange(this.l_start_date, this.l_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");



                if (this.l_vendor_name == '') {
                    this.e_l_vendor_name = "Please Select Transaction HeadName";
                }

            }
            else{
                this.ledger_detail = 1;
                this.newReq = true;
                this.get_ledger();
            }

        },
        fetchBank() {
            axios.get('accounts/fetch_methods1')
                .then(response => {
                    this.methods = response.data
                    this.options2 = [];

                    var $this = this;
                    for (var j = 0; j < $this.methods.length; j++) {
                        this.options2.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
                    }
                    this.bankBoook = [{
                        'select' : "All Banks",
                        'banks': this.options2
                    }]
                })
            },
        bankLedgerOpen(){
            this.bankledger = true;
            this.fetchBank()

        },
        bsheet_report() {

            const validation = this.$helpers.validateDateRange(this.bs_start_date, this.bs_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
    } else {
            this.Loader1=true;
                this.balancesheet_report = 1;
                this.get_balancesheet();
            }
        },

        get_balancesheet() {
            axios.get('accounts/BalanceSheet_CurrentAssets/' + this.bs_start_date + '/' + this.bs_end_date)
                .then(response => {
                    this.toggle_balancesheet = false
                    this.curAssets_list = response.data
                    this.assetsSum = this.curAssets_list.map((curEle) => {
                        return curEle.Amount
                    }).reduce((accu, curr) => {
                        return Number(accu) + Number(curr)
                    }, 0)

                    axios.get('accounts/BalanceSheet_NonCurrentAssets/' + this.bs_start_date + '/' + this.bs_end_date)
                        .then(response => {
                            this.curNonAssets_list = response.data
                            this.NotassetSum = this.curNonAssets_list.map((curEle) => {
                                return curEle.Amount
                            }).reduce((accu, curr) => {
                                return Number(accu) + Number(curr)
                            }, 0)

                            this.asset_sum = this.assetsSum + this.NotassetSum;
                        })
                })
            axios.get('accounts/Balancesheet_TotalProfit/' + this.bs_start_date + '/' + this.bs_end_date)
                .then(response => {
                    this.totalprofit_list = response.data
                    this.toptalprofitbsSum = this.totalprofit_list.map((curEle) => {
                        return curEle.Amount
                    }).reduce((accu, curr) => {
                        return Number(accu) + Number(curr)
                    }, 0)
                    axios.get('accounts/BalanceSheet_ShareCapitalandReserves/' + this.bs_start_date + '/' + this.bs_end_date)
                        .then(response => {
                            this.shareCapital_list = response.data
                            this.ShareCapitalSum = this.shareCapital_list.map((curEle) => {
                                return curEle.Amount
                            }).reduce((accu, curr) => {
                                return Number(accu) + Number(curr)
                            }, 0)

                            axios.get('accounts/BalanceSheet_NonCurrentLiabiities/' + this.bs_start_date + '/' + this.bs_end_date)
                                .then(response => {
                                    this.nonCurLiab_list = response.data
                                    this.NonCurrLiabSum = this.nonCurLiab_list.map((curEle) => {
                                        return curEle.Amount
                                    }).reduce((accu, curr) => {
                                        return Number(accu) + Number(curr)
                                    }, 0)

                                    axios.get('accounts/BalanceSheet_CurrentLiabiities/' + this.bs_start_date + '/' + this.bs_end_date)
                                        .then(response => {
                                            this.CurLiab_list = response.data
                                            this.CurrLiabSum = this.CurLiab_list.map((curEle) => {
                                                return curEle.Amount
                                            }).reduce((accu, curr) => {
                                                return Number(accu) + Number(curr)

                                            }, 0)

                                            this.liab_totalsum = this.ShareCapitalSum + this.NonCurrLiabSum + this.CurrLiabSum + this.toptalprofitbsSum
                                        this.Loader1=false;

                                        })
                                })
                        })
                })

        },
        bsheet_report1() {
this.toggle_balancesheet = true
this.balancesheet_report = '';
this.bs_start_date=this.start_date;
this.bs_end_date=this.end_date;
this.e_bs_start_date = '';
this.e_bs_end_date = '';
this.balance_d = {};
this.liab_d = {}
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
        generateBalanceSReport() {
            this.pdfL1=true;
                setTimeout(()=>{
                    this.$refs.balancespdf.generatePdf();
                })
        },
        CashF_report() {
            const validation = this.$helpers.validateDateRange(this.cashF_start_date, this.cashF_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");

            } else {
                this.CashFlow_report = 1;

            }
        },
        CashF_report1() {
            this.CashFlow_report = '';
            this.cashF_start_date=this.start_date;
            this.cashF_end_date=this.end_date;
        },
        generateCashflowstatementReport() {
            this.$refs.CashFlowForTheEndedYearpdf.generatePdf();
        },
        chartofAccounts_Summary() {
            if (this.chart_check == '') {
                this.chart_check = 'All'
            }
this.Loader2=true;
            this.chart_Account_report = 1;
            axios.get("accounts/chartof_Accounts/" + this.chart_check).then((response) => {
                this.account_list = response.data
                this.toggle_accountshead = false
this.Loader2=false;
            }).catch((error) => {
                console.log(error);
            })
        },
        chartofAccounts_Summary1() {
            this.chart_Account_report = '';
            this.pdfL2=false;
            this.toggle_accountshead = true;
        },
        generateChartofAccountsReport() {
            this.pdfL2=true;
                setTimeout(()=>{
                    this.$refs.stockpdf.generatePdf();
                })
        },
        deliverydetails_report() {
            this.delivery_report = 1;
            this.Loader3=true;
            axios.get("Accounts/deliverydetails_report/" + this.delivery).then((response) => {
                this.delivery_list = response.data;
                this.toggle_delivery = false;
                this.Loader3=false;
            })
        },
        deliverydetails_report1() {
            this.delivery_report = '';
            this.toggle_delivery = true
        },
        generateDeliverydetailReport() {
            this.pdfL3=true;
                setTimeout(()=>{
                    this.$refs.deliverypdf.generatePdf();
                })
        },
        ledger_report() {
            const validation = this.$helpers.validateDateRange(this.bs_start_date, this.bs_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
      if (this.l_start_date == '') {
                    this.e_l_start_date = "Please Select Start Date";
                }
                if (this.l_end_date == '') {
                    this.e_l_end_date = "Please Select End Date";
                }

                if (this.l_vendor_name == '') {
                    this.e_l_vendor_name = "Please Select Transaction HeadName";
                    this.$toastr.e('Please Select Transaction HeadName', "Caution!");
                }
    }
           else {
                this.ledger_detail = 1;
                this.newReq = true;
                this.get_ledger();
            }
        },
        ledger_report1() {
            this.ledger_detail = '';
            this.e_l_start_date =this.start_date;
            this.e_l_end_date =this.end_date;
            this.e_l_vendor_name = '';
            this.l_vendor_name = '';
            this.toggle_ledger = true
            this.ledger_d = {};
            this.ledger_d_detail = {};
        },
        changePageLen() {
            if (this.pag_len == 'all') {
                this.pagination.per_page = 999999
                this.all = true;
                this.changePage(1);
            } else {
                this.all = false
                this.pagination.per_page = this.pag_len
                this.changePage(1);
            }

        },
        changePage(page) {
            this.newReq = false;
            this.get_ledger(page);
        },
        get_ledger(page = 1) {
            this.ledherloader = true;

            axios.get('./accounts/ledger_report/' + this.l_start_date + '/' + this.l_end_date + '/' + this.l_vendor_name + '?per_page=' + this.pag_len + '&page=' + page + '&new=' + this.newReq)
                .then(response => {
                    this.ledger_d = response.data;
                    if (this.newReq) {
                        setTimeout(() => {
                            // this.fetchAllGenLed()
                        }, 1000)
                    }
                    this.ledherloader = false
                    this.ledger_d = response.data.data.data;
                    this.pagination = response.data.data

                    this.toggle_ledger = false
                })
                .catch(err => {
                    this.$toastr.e(err.response.data.message);
                    this.ledherloader = false;

                    this.opening_balance = arr1.balance
                    // this.opening_balance = arr1.balance
                })
            if (this.newReq) {
                axios.get('./accounts/ledger_report_balance/' + this.l_start_date + '/' + this.l_end_date + '/' + this.l_vendor_name)
                    .then(response => {
                        this.ledger_d_detail = response.data;
                    })
                axios.get('accounts/ledger_method_report_openingbalance/' + this.l_start_date + '/' + this.l_vendor_name)
                    .then(response => {
                        let arr1 = response.data[response.data.length - 1];

                        this.opening_balance = arr1.balance
                    })
            }
        },
        downloadExcel() {
            this.ledherloader = true;
            this.genPdfLoader = true;
            this.excelLoader = true;
            this.ledger_d_detail[0].start_data = this.l_start_date
            this.ledger_d_detail[0].end_date = this.l_end_date
            this.ledger_d_detail[0].opening_balance = this.opening_balance

            axios.post("download_excel", this.ledger_d_detail, {
                    responseType: 'blob'
                })
                .then((response) => {


                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Datewise_Ledger_Detail.xls');
                    document.body.appendChild(link);
                    link.click();
                    this.genPdfLoader = false;
                    this.excelLoader = false;
                    this.ledherloader = false;
                    // this.allLedger = response.data.data
                    // this.genPdfLoader = false
                })
                .catch(err => {
                    this.genPdfLoader = false
                    this.excelLoader = false;
                    this.ledherloader = false;
                    this.$toastr.e(err.response.data.message);

                })
        },
        ploss_report() {
            const validation = this.$helpers.validateDateRange(this.ploss_start_date, this.ploss_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");


} else {
    this.profit_loss_report = 1;
    axios.get('accounts/cost_orland_report/' + this.ploss_start_date + '/' + this.ploss_end_date)
        .then(response => {
            this.toggle_profitloss = false
            this.cost_ofland_list = response.data;
            let liaS = this.cost_ofland_list.map((curEle) => {
                return curEle.Amount
            }).reduce((accu, curr) => {
                return Number(accu) + Number(curr)
            }, 0)
            this.cost_ofland_sum = liaS
        })
    axios.get('accounts/operatingland_report/' + this.ploss_start_date + '/' + this.ploss_end_date)
        .then(response => {
            this.operating_list = response.data;
            let liaS = this.operating_list.map((curEle) => {
                return curEle.Amount
            }).reduce((accu, curr) => {
                return Number(accu) + Number(curr)
            }, 0)
            this.operating_prof_sum = liaS
        })
    axios.get('accounts/IncomeStatment_GrossProfit/' + this.ploss_start_date + '/' + this.ploss_end_date)
        .then(response => {
            this.gross_profit_list = response.data;
            let liaS = this.gross_profit_list.map((curEle) => {
                return curEle.Amount
            }).reduce((accu, curr) => {
                return Number(accu) + Number(curr)
            }, 0)
            this.grossprofit_sum = liaS
        })
    axios.get('accounts/IncomeStatment_Taxation/' + this.ploss_start_date + '/' + this.ploss_end_date)
        .then(response => {
            this.is_taxation_list = response.data;
            let liaS = this.is_taxation_list.map((curEle) => {
                return curEle.Amount
            }).reduce((accu, curr) => {
                return Number(accu) + Number(curr)
            }, 0)
            this.incometaxation_sum = liaS
        })
}
},
ploss_report1() {
            this.profit_loss_report = ''
            this.toggle_profitloss = true
        },
        generateProfitLossReport() {
            this.$refs.plosspdf.generatePdf();
        },

        taxdetails_report() {
            this.tax_report = 1;
            axios.get("Accounts/taxdetails_report/" + this.tax).then((response) => {
                this.tax_list = response.data;
            }).catch((err) => {
                console.log(err);
            })
        },
        taxdetails_report1() {
            this.tax_report = '';
        },
        generateTaxdetailReport() {
            this.$refs.taxpdf.generatePdf();
        },
        trail_report() {
            const validation = this.$helpers.validateDateRange(this.t_start_date, this.t_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");


            } else {
                this.trail_detail = 1;
                this.get_trail();
            }
        },
        get_trail() {
            axios.get('./accounts/trail_balance_report/' + this.t_start_date + '/' + this.t_end_date)
                .then(response => {
                    this.toggle_trialbalance = false
                    let trialData = response.data.sort((a, b) => {
                        let left = a.AccountID
                        let right = b.AccountID
                        return left === right ? 0 : left > right ? 1 : -1;
                    })
                    this.trail_d = trialData
                    let inS = trialData.map((curEle) => {
                        return curEle.Credit
                    }).reduce((accu, curr) => {
                        return Number(accu) + Number(curr)
                    }, 0)
                    let inS1 = trialData.map((curEle) => {
                        return curEle.Debit
                    }).reduce((accu, curr) => {
                        return Number(accu) + Number(curr)
                    }, 0)
                    this.creditSum = inS;
                    this.debitSum = inS1;
                })
            axios.get('./accounts/trail_balance_report_sum/' + this.t_start_date + '/' + this.t_end_date)
                .then(response => {
                    this.sum = response.data;
                })
        },
        trail_report1() {
            this.trail_detail = '';
            this.e_t_start_date = '';
            this.e_t_end_date = '';
            this.trail_d = {};
            this.toggle_trialbalance = true
        },
        vob_report() {
            const validation = this.$helpers.validateDateRange(this.vob_start_date, this.vob_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
      if (this.vob_start_date == '') {
                    this.e_vob_start_date = "Please Select Start Date";
                }
                if (this.vob_end_date == '') {
                    this.e_vob_end_date = "Please Select End Date";
                }


    }
    if (this.vob_vendor_name == '') {
                    this.e_vob_vendor_name = "Please Select Transaction HeadName";
                    this.$toastr.e('please select Transaction HeadName', "Caution!");
                }
           else {
                 this.vendor_overall_report = 1
                axios.get('./accounts/ledger_report_balance/' + this.vob_start_date + '/' + this.vob_end_date + '/' + this.vob_vendor_name)
                    .then(response => {
                        this.vendor_vol_list = response.data;
                        this.toggle_overallbalance = false
                    })
                axios.get('./accounts/ledger_report_balance1/' + this.vob_start_date + '/' + this.vob_end_date + '/' + this.vob_vendor_name)
                    .then(response => {
                        this.vendor_vol_list2 = response.data;
                        let liaS = this.vendor_vol_list2.map((curEle) => {
                            return curEle.ChqAmount
                        }).reduce((accu, curr) => {
                            return Number(accu) + Number(curr)
                        }, 0)
                        this.temp_sum = liaS
                    })
                axios.get('./accounts/ledger_report1/' + this.vob_start_date + '/' + this.vob_end_date + '/' + this.vob_vendor_name)
                    .then(response => {
                        this.ven_account_list = response.data;
                    })


            }
        },
        vob_report1() {
            this.vendor_overall_report = '',
                this.toggle_overallbalance = true
            this.e_vob_vendor_name = '',
                this.vob_vendor_name = '',
                this.e_vob_start_date = ''
        },

        generateOverallBalanceReport() {
            this.$refs.venolpdf.generatePdf();
        },
        newdata(){
            this.session_end_date=this.end_date;
            this.cashF_start_date=this.start_date;
            this.cashF_end_date=this.end_date;
            this.l_start_date=this.start_date;
            this.l_end_date=this.end_date;
            this.ploss_start_date=this.start_date;
            this.ploss_end_date=this.end_date;
            this.t_start_date=this.start_date;
            this.t_end_date=this.end_date;
            this.vob_start_date=this.start_date;
            this.vob_end_date=this.end_date;
            this.bs_start_date=this.start_date
            this.bs_end_date=this.end_date;
        }

},
    mounted() {
        this.newdata();
        axios.get("accounts/all_acc_types").then((response) => {
            this.chartdata = response.data;
            this.chartoption = [];

            var $this = this;
            for (var i = 0; i < $this.chartdata.length; i++) {

                this.chartoption.push($this.chartdata[i].HeadName);
            }
        }).catch((error) => {
            console.log(error);
        })
        axios.get('accounts/fetch_all_transaction_head')
            .then(response => {
                this.agnstpayment = response.data
                this.options1 = [];

                var $this = this;
                for (var i = 0; i < $this.agnstpayment.length; i++) {
                    this.options1.push($this.agnstpayment[i].ID + '_' + $this.agnstpayment[i].AccountName);
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
