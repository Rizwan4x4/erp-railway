<template>
    <div>
<h6 class="mb-25 fw-bold">
    <i class="fa-solid fa-shop" style="padding-right: 10px"></i>
    Sales Reports
</h6>
<div class="ng-star-inserted">
    <a data-bs-toggle="modal" data-bs-target="#CashPyhReport">
        <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
        <span>Cash Supervision Report</span>
    </a>
    <a data-bs-toggle="modal" data-bs-target="#ChqSuperwisedetail">
        <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
        <span>Cheque Supervision Report</span>
    </a>
    <a data-bs-toggle="modal" data-bs-target="#DebitCreditSuperwiseReport">
        <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
        <span>Debit/Credit Supervisions</span>
    </a>
    <a data-bs-toggle="modal" data-bs-target="#CashGetSuperwiseDetail">
        <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
        <span>Online Cash Supervisions</span>
    </a>
    <a data-bs-toggle="modal" data-bs-target="#UnitsBookingReport">
        <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
        <span>Units Booking Report</span>
    </a>
    <a data-bs-toggle="modal" data-bs-target="#UnitsAgeingPayablesReport">
        <i class="fa-solid fa-star" style="font-size: 16px !important; padding-right: 6px"></i>
        <span>Ageing Payable / Receivables Report</span>
    </a>
</div>


<!--Ageing Payable / Receivables Report -->
<div class="modal fade" id="UnitsAgeingPayablesReport" aria-labelledby="UnitsAgeingPayablesReport" tabindex="-1" style="display: none" aria-hidden="true">
                <div v-if="units_ageing_payables==''" class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Filter Ageing Payable / Receivables Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- form -->
                            <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Module</label>
                                        <multiselect @input="module_change()" :show-labels="false" v-model="pr_module" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="Select Module" :options="moduleoption">
                                    </multiselect>
                                    <span style="color: #db4437; font-size: 11px" v-if="pr_module == null">{{
                                        e_pr_module }}</span>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Block</label>
                                        <multiselect :show-labels="false" v-model="pr_block" style="margin-right: 10px; font-size: 15px;" id="modalAddCardName" placeholder="Select Block" :options="blockoption">
                                    </multiselect>
                                    <span style="color: #db4437; font-size: 11px" v-if="pr_block == null">{{
                                        e_pr_block }}</span><br/>
                                    <span style="color: #db4437; font-size: 11px">For Block, Select Module First</span>

                                    </div>
                                    <div class="col-md-12">
                                    <label class="form-label">Year</label>
                                    <select id="yearSelect" @change="yearChange()" v-model="pr_year" class="invoiceto form-select">
                                          <option value="">Select a year</option>
                                         <option v-for="year in years" :value="year">{{ year }}</option>
                                         </select>
                                      </div>
                                    <div class="col-md-12" v-if="toggle_ageing">
                                    <label class="form-label">Month</label>
                                    <select id="yearSelect"  v-model="pr_month" class="invoiceto form-select">
                                        <option value="">Select a month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                         </select>
                                      </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" @click="ageing_payables()">
                                View Report
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
                <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1350px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel16">Ageing Payable / Receivables Report</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="ageing_payables1()"></button>
                        </div>
                        <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Units_Ageing_Payables_Receivables" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="ageingpdf">
                            <div slot="pdf-content">
                                <div class="modal-body" id="Datewise_Trail_Detail">
                                    <div style="margin-top: 20px;margin-bottom: 20px;">
                                       <h4>Ageing Payable / Receivables Report</h4>
                                        <h6 ><strong>Year:</strong> {{pr_year}} <strong>Month:</strong> {{pr_month}}</h6>

                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>

                                                    <th scope="col">Name</th>
                                                    <th scope="col">Plot No</th>
                                                    <th scope="col">Block Name</th>
                                                    <th scope="col">Module</th>
                                                    <th scope="col">Balance Amount</th>
                                                    <th scope="col">Outstanding Amount</th>
                                                    <th scope="col">Receivable Amount</th>
                                                    <th scope="col">Received Amount</th>
                                                    <th scope="col">Total Amount</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="online_cash_list1 in get_all_ageing" >
                                                    <td>{{online_cash_list1.Name}}</td>
                                                    <td>{{online_cash_list1.Plot_NO}}</td>
                                                    <td>{{online_cash_list1.Block_Name}}</td>
                                                    <td>{{online_cash_list1.Module}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Balance_Amount).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Outstanding_Amount).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Receivable).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Received_Amount).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Total_Amount).toLocaleString()}}</td>

                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </vue-html2pdf>

                        <div class="modal-body" >
                            <div style="margin-top: 20px;margin-bottom: 20px;">
                                <h6 ><strong>Year:</strong> {{pr_year}} <strong> Month:</strong> {{pr_month}}</h6>

                            </div>
                            <div class="table-responsive" id="ageing__receivables_Report" >
                                <table class="table">
                                            <thead>
                                                <tr>

                                                    <th scope="col">Name</th>
                                                    <th scope="col">Plot No</th>
                                                    <th scope="col">Block Name</th>
                                                    <th scope="col">Module</th>
                                                    <th scope="col">Balance Amount</th>
                                                    <th scope="col">Outstanding Amount</th>
                                                    <th scope="col">Receivable Amount</th>
                                                    <th scope="col">Received Amount</th>
                                                    <th scope="col">Total Amount</th>


                                                </tr>
                                            </thead>
                                            <div v-if="ageingtoggle" class="row">
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
                                                <tr v-for="online_cash_list1 in get_all_ageing" >
                                                    <td>{{online_cash_list1.Name}}</td>
                                                    <td>{{online_cash_list1.Plot_NO}}</td>
                                                    <td>{{online_cash_list1.Block_Name}}</td>
                                                    <td>{{online_cash_list1.Module}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Balance_Amount).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Outstanding_Amount).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Receivable).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Received_Amount).toLocaleString()}}</td>
                                                    <td >{{currency}}. {{Number(online_cash_list1.Total_Amount).toLocaleString()}}</td>

                                                </tr>

                                            </tbody>
                                        </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'ageing__receivables_Report')" class="btn btn-gradient-info">Excel</button>

                            <button type="button" @click="generateAgeingReport()" class="btn btn-gradient-info">Pdf</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="ageing_payables1()">close</button>
                        </div>
                    </div>
                </div>
            </div>
<!--Start Filter Cash Supervise Report -->
<div class="modal fade" id="CashPyhReport" aria-labelledby="CashPyhReport" tabindex="-1" style="display: none" aria-hidden="true">
                <div v-if="phy_cash_report==''" class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Filter Cash Supervise Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- form -->
                            <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Range From</label>
                                        <input type="date" v-model="cash_start_date" class="form-control" />
                                        <span style="color: #db4437; font-size: 11px" v-if="cash_start_date == ''">{{ e_cash_start_date}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Range To</label>
                                        <input v-model="cash_end_date" type="date" class="form-control" />
                                        <span style="color: #db4437; font-size: 11px" v-if="cash_end_date == ''">{{ e_cash_end_date}}</span>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" @click="cash_report()">
                                View Report
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
                <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1350px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel16">Cash Supervise Detail Report</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cash_report1()"></button>
                        </div>
                        <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Cash_superwise_report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="cashpdf">
                            <div slot="pdf-content">
                                <div class="modal-body" id="Datewise_Trail_Detail">
                                    <div style="margin-top: 20px;margin-bottom: 20px;">
                                        <h6><strong>Date:</strong> {{this.cash_start_date}} To {{this.cash_end_date}}</h6>

                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>

                                                    <th scope="col">Date</th>
                                                    <th scope="col">ReceiptNo</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Father Name</th>
                                                    <th scope="col">Payment Type</th>
                                                    <th scope="col">Transaction Id</th>
                                                    <th scope="col">Plot Type</th>
                                                    <th scope="col">File Plot No</th>
                                                    <th scope="col">Block</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Amount</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="online_cash_list1 in cash_list" >
                                                    <td>{{online_cash_list1.DateTime}}</td>
                                                    <td>{{online_cash_list1.ReceiptNo}}</td>
                                                    <td>{{online_cash_list1.Name}}</td>
                                                    <td>{{online_cash_list1.Father_Name}}</td>
                                                    <td>{{online_cash_list1.PaymentType}}</td>
                                                    <td>{{online_cash_list1.Transaction_Id}}</td>
                                                    <td>{{online_cash_list1.Plot_Type}}</td>
                                                    <td>{{online_cash_list1.File_Plot_Number}}</td>
                                                    <td>{{online_cash_list1.Block}}</td>
                                                    <td style='max-width:40px'>{{online_cash_list1.Text}}</td>
                                                    <td style="text-align:left;">{{currency}}. {{Number(online_cash_list1.Amount).toLocaleString()}}/-</td>

                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </vue-html2pdf>
                        <div class="modal-body" id="cash_id">
                            <div style="margin-top: 20px;margin-bottom: 20px;">
                                <h6><strong>Date:</strong> {{this.cash_start_date}} To {{this.cash_end_date}}</h6>

                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th scope="col">Datess</th>
                                            <th scope="col">ReceiptNo</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Father Name</th>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Transaction Id</th>
                                            <th scope="col">Plot Type</th>
                                            <th scope="col">File Plot No</th>
                                            <th scope="col">Block</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Amount</th>
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
                                        <tr v-for="online_cash_list1 in cash_list" v-if="toggle_cash_supr==false">
                                            <td>{{online_cash_list1.DateTime}}</td>
                                            <td>{{online_cash_list1.ReceiptNo}}</td>
                                            <td>{{online_cash_list1.Name}}</td>
                                            <td>{{online_cash_list1.Father_Name}}</td>
                                            <td>{{online_cash_list1.PaymentType}}</td>
                                            <td>{{online_cash_list1.Transaction_Id}}</td>
                                            <td>{{online_cash_list1.Plot_Type}}</td>
                                            <td>{{online_cash_list1.File_Plot_Number}}</td>
                                            <td>{{online_cash_list1.Block}}</td>
                                            <td style='max-width:40px'>{{online_cash_list1.Text}}</td>
                                            <td>{{currency}}. {{Number(online_cash_list1.Amount).toLocaleString()}}/-</td>

                                        </tr>
                                        <tr v-if="toggle_cash_supr==true">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="loadingio-spinner-bars-0opevbvvjcw">
                                                    <div class="ldio-qxxhsg5wen">
                                                        <div></div><div></div><div></div><div></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row mx-3 mb-2 ">

                        <div class="col-12" >
                            <div style="text-align:center;padding-top:20px">
                                <pagination class="float-end" :data="paginantion" @pagination-change-page="changePage" :limit="5"></pagination>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="html_table_to_excels('xlsx','cash_id')" class="btn btn-gradient-info">Excel</button>
                            <button type="button" @click="generateCashReport()" class="btn btn-gradient-info">Pdf</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="cash_report1()">close</button>
                        </div>
                    </div>
                </div>
            </div>
<!--End Filter Cash Supervise Report -->

<!--Start Filter Cheque Supervise Report  -->
    <div class="modal fade" id="ChqSuperwisedetail" aria-labelledby="ChqSuperwisedetail" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="chq_superwise_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Cheque Supervise Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="chq_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="chq_start_date == ''">{{
                                            e_chq_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="chq_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="chq_end_date == ''">{{
                                            e_chq_end_date }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="chq_super_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1250px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Cheque Supervise Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="chq_super_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Chq_superwise_report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="Chqsuperwisepdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.chq_start_date }} To {{ this.chq_end_date }}</h6>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="min-width: 100px;">Date</th>
                                                <th scope="col">ReceiptNo</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Father Name</th>
                                                <th scope="col">Module</th>
                                                <th scope="col">Plot Type</th>
                                                <th scope="col">File Plot No</th>
                                                <th scope="col">Block</th>
                                                <th scope="col">Deposit Account</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="trail_d1 in chq_list">
                                                <td>{{ trail_d1.DateTime }}</td>
                                                <td>{{ trail_d1.ReceiptNo }}</td>
                                                <td>{{ trail_d1.Name }}</td>
                                                <td>{{ trail_d1.Father_Name }}</td>
                                                <td>{{ trail_d1.Module }}</td>
                                                <td>{{ trail_d1.Plot_Type }}</td>
                                                <td>{{ trail_d1.File_Plot_Number }}</td>
                                                <td>{{ trail_d1.Block }}</td>
                                                <td>{{ trail_d1.DepositedAccount }}</td>
                                                <td>{{ currency }}. {{ Number(trail_d1.Amount).toLocaleString() }}/-</td>
                                                <td>{{ trail_d1.Status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="Chq_superwise_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.chq_start_date }} To {{ this.chq_end_date }}</h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="min-width: 100px;">Date</th>
                                        <th scope="col">ReceiptNo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father Name</th>
                                        <th scope="col">Module</th>
                                        <th scope="col">Plot Type</th>
                                        <th scope="col">File Plot No</th>
                                        <th scope="col">Block</th>
                                        <th scope="col">Deposit Account</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
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
                                    <tr v-for="trail_d1 in chq_list" v-if="toggle_chqsuperwise == false">
                                        <td>{{ trail_d1.DateTime }}</td>
                                        <td>{{ trail_d1.ReceiptNo }}</td>
                                        <td>{{ trail_d1.Name }}</td>
                                        <td>{{ trail_d1.Father_Name }}</td>
                                        <td>{{ trail_d1.Module }}</td>
                                        <td>{{ trail_d1.Plot_Type }}</td>
                                        <td>{{ trail_d1.File_Plot_Number }}</td>
                                        <td>{{ trail_d1.Block }}</td>
                                        <td>{{ trail_d1.DepositedAccount }}</td>
                                        <td>{{ currency }}. {{ Number(trail_d1.Amount).toLocaleString() }}/-</td>
                                        <td>{{ trail_d1.Status }}</td>
                                    </tr>
                                    <tr v-if="toggle_chqsuperwise == true">
                                        <td></td>
                                        <td></td>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'Chq_superwise_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateChqSuperwiseReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="chq_super_report1()">close</button>
                    </div>
                </div>
            </div>
    </div>
<!--End Filter Cheque Supervise Report  -->
<!--Start Filter Debit Credit Supervise Report -->
<div class="modal fade" id="DebitCreditSuperwiseReport" aria-labelledby="DebitCreditSuperwiseReport" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="debit_creditsupr_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Debit Credit Supervise Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="debit_credit_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="debit_credit_start_date == ''">{{ e_debit_credit_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="debit_credit_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="debit_credit_end_date == ''">{{
                                            e_debit_credit_end_date }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="debit_credit_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1250px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Debit Credit Supervise Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="debit_credit_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Cash_superwise_report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="debitcreditpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.debit_credit_start_date }} To
                                        {{ this.debit_credit_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col">Date</th>
                                                <th scope="col">ReceiptNo</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Father Name</th>
                                                <th scope="col">Payment Type</th>
                                                <th scope="col">Transaction Id</th>
                                                <th scope="col">Plot Type</th>
                                                <th scope="col">File Plot No</th>
                                                <th scope="col">Block</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="online_cash_list1 in debit_credit_list">
                                                <td>{{ online_cash_list1.DateTime }}</td>
                                                <td>{{ online_cash_list1.ReceiptNo }}</td>
                                                <td>{{ online_cash_list1.Name }}</td>
                                                <td>{{ online_cash_list1.Father_Name }}</td>
                                                <td>{{ online_cash_list1.PaymentType }}</td>
                                                <td>{{ online_cash_list1.Transaction_Id }}</td>
                                                <td>{{ online_cash_list1.Plot_Type }}</td>
                                                <td>{{ online_cash_list1.File_Plot_Number }}</td>
                                                <td>{{ online_cash_list1.Block }}</td>
                                                <td>{{ online_cash_list1.Text }}</td>
                                                <td>{{ currency }}.
                                                    {{ Number(online_cash_list1.Amount).toLocaleString() }}/-</td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="cash_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.debit_credit_start_date }} To
                                {{ this.debit_credit_end_date }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th scope="col">Date</th>
                                        <th scope="col">ReceiptNo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father Name</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Transaction Id</th>
                                        <th scope="col">Plot Type</th>
                                        <th scope="col">File Plot No</th>
                                        <th scope="col">Block</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>

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
                                    <tr v-for="online_cash_list1 in debit_credit_list" v-if="toggle_creditdebit == false">
                                        <td>{{ online_cash_list1.DateTime }}</td>
                                        <td>{{ online_cash_list1.ReceiptNo }}</td>
                                        <td>{{ online_cash_list1.Name }}</td>
                                        <td>{{ online_cash_list1.Father_Name }}</td>
                                        <td>{{ online_cash_list1.PaymentType }}</td>
                                        <td>{{ online_cash_list1.Transaction_Id }}</td>
                                        <td>{{ online_cash_list1.Plot_Type }}</td>
                                        <td>{{ online_cash_list1.File_Plot_Number }}</td>
                                        <td>{{ online_cash_list1.Block }}</td>
                                        <td>{{ online_cash_list1.Text }}</td>
                                        <td>{{ currency }}. {{ Number(online_cash_list1.Amount).toLocaleString() }}/-</td>

                                    </tr>
                                    <tr v-if="toggle_creditdebit == true">
                                        <td></td>
                                        <td></td>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'cash_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateDebitCreditReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="debit_credit_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!--End Filter Debit Credit Supervise Report -->

<!-- Start Filter Online Cash Supervise Report -->
<div class="modal fade" id="CashGetSuperwiseDetail" aria-labelledby="CashGetSuperwiseDetail" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="online_cash_report_get == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Online Cash Supervise Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="online_cash_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="online_cash_start_date == ''">{{
                                            e_online_cash_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="online_cash_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="online_cash_end_date == ''">{{
                                            e_online_cash_end_date }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="online_cash_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1250px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Online Cash Supervise Detail Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="online_cash_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="online_cash_report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="onlinecashpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.online_cash_start_date }} To
                                        {{ this.online_cash_end_date }}</h6>
                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">ReceiptNo</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Father Name</th>
                                                <th scope="col">Payment Type</th>
                                                <th scope="col">Transaction Id</th>
                                                <th scope="col">Plot Type</th>
                                                <th scope="col">File Plot No</th>
                                                <th scope="col">Block</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="online_cash_list1 in online_cash_list">
                                                <td>{{ online_cash_list1.DateTime }}</td>
                                                <td>{{ online_cash_list1.ReceiptNo }}</td>
                                                <td>{{ online_cash_list1.Name }}</td>
                                                <td>{{ online_cash_list1.Father_Name }}</td>
                                                <td>{{ online_cash_list1.PaymentType }}</td>
                                                <td>{{ online_cash_list1.Transaction_Id }}</td>
                                                <td>{{ online_cash_list1.Plot_Type }}</td>
                                                <td>{{ online_cash_list1.File_Plot_Number }}</td>
                                                <td>{{ online_cash_list1.Block }}</td>
                                                <td>{{ online_cash_list1.Text }}</td>
                                                <td>{{ currency }}.
                                                    {{ Number(online_cash_list1.Amount).toLocaleString() }}/-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="online_cash_id">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.online_cash_start_date }} To {{ this.online_cash_end_date }}
                            </h6>
                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">ReceiptNo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Father Name</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Transaction Id</th>
                                        <th scope="col">Plot Type</th>
                                        <th scope="col">File Plot No</th>
                                        <th scope="col">Block</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Amount</th>
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
                                    <tr v-for="online_cash_list1 in online_cash_list" v-if="toggle_onlinecash == false">
                                        <td>{{ online_cash_list1.DateTime }}</td>
                                        <td>{{ online_cash_list1.ReceiptNo }}</td>
                                        <td>{{ online_cash_list1.Name }}</td>
                                        <td>{{ online_cash_list1.Father_Name }}</td>
                                        <td>{{ online_cash_list1.PaymentType }}</td>
                                        <td>{{ online_cash_list1.Transaction_Id }}</td>
                                        <td>{{ online_cash_list1.Plot_Type }}</td>
                                        <td>{{ online_cash_list1.File_Plot_Number }}</td>
                                        <td>{{ online_cash_list1.Block }}</td>
                                        <td>{{ online_cash_list1.Text }}</td>
                                        <td>{{ currency }}. {{ Number(online_cash_list1.Amount).toLocaleString() }}/-</td>
                                    </tr>
                                    <tr v-if="toggle_onlinecash == true">
                                        <td></td>
                                        <td></td>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'online_cash_id')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateOnlineCashReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="online_cash_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- End Filter Online Cash Supervise Report -->
<!-- Start Filter Units Booking Report -->
<div class="modal fade" id="UnitsBookingReport" aria-labelledby="UnitsBookingReport" tabindex="-1" style="display: none" aria-hidden="true">
            <div v-if="units_booking_report == ''" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalToggleLabel">Filter Units Booking Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- form -->
                        <div id="addNewCardValidation" class="row gy-1 gx-2 mt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Range From</label>
                                    <input type="date" v-model="units_booking_start_date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="units_booking_start_date == ''">{{ e_units_booking_start_date }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Range To</label>
                                    <input v-model="units_booking_end_date" type="date" class="form-control" />
                                    <span style="color: #db4437; font-size: 11px" v-if="units_booking_end_date == ''">{{
                                            e_units_booking_end_date }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" @click="unitbook_report()">
                            View Report
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
            <div v-else class="modal-dialog modal-dialog-centered modal-lg" style="min-width: 1250px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">Units Booking Report</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="unitbook_report1()"></button>
                    </div>
                    <vue-html2pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="false" :paginate-elements-by-height="5000" filename="Units_Booking_Report" :pdf-quality="2" :manual-pagination="false" pdf-format="a4" pdf-orientation="landscape" pdf-content-width="1100px" @progress="onProgress($event)" @hasStartedGeneration="hasStartedGeneration()" @hasGenerated="hasGenerated($event)" ref="unitsbookingpdf">
                        <div slot="pdf-content">
                            <div class="modal-body">
                                <div style="margin-top: 20px;margin-bottom: 20px;">
                                    <h6><strong>Date:</strong> {{ this.units_booking_start_date }} To
                                        {{ this.units_booking_end_date }}</h6>

                                </div>
                                <div class="table-responsive" style="overflow-x: initial !important;">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th scope="col">Date</th>
                                                <th scope="col">Owner Name</th>
                                                <th scope="col">File Plot Number</th>
                                                <th scope="col">Plot Type</th>
                                                <th scope="col">Block No</th>
                                                <th scope="col">Unit Module</th>
                                                <th scope="col">Supervise By</th>

                                                <th scope="col">Booking Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="units_booking_list1 in units_booking_list">
                                                <td>{{ units_booking_list1.Dated }}</td>
                                                <td>{{ units_booking_list1.OwnerName }}</td>
                                                <td>{{ units_booking_list1.file_plot_number }}</td>
                                                <td>{{ units_booking_list1.Type }}</td>
                                                <td>{{ units_booking_list1.Block_Name }}</td>
                                                <td>{{ units_booking_list1.UnitModule }}</td>
                                                <td>{{ units_booking_list1.Supervision }}</td>
                                                <td>{{ currency }}
                                                    {{ Number(units_booking_list1.BookingAmount).toLocaleString() }}/-
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </vue-html2pdf>
                    <div class="modal-body" id="units_booking_report">
                        <div style="margin-top: 20px;margin-bottom: 20px;">
                            <h6><strong>Date:</strong> {{ this.units_booking_start_date }} To
                                {{ this.units_booking_end_date }}</h6>

                        </div>
                        <div class="table-responsive" style="overflow-x: initial !important;">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th scope="col">Date</th>
                                        <th scope="col">Owner Name</th>
                                        <th scope="col">File Plot Number</th>
                                        <th scope="col">Plot Type</th>
                                        <th scope="col">Block No</th>
                                        <th scope="col">Unit Module</th>
                                        <th scope="col">Supervise By</th>

                                        <th scope="col">Booking Amount</th>

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
                                    <tr v-for="units_booking_list1 in units_booking_list" v-if="toggle_unitsbooking == false">
                                        <td>{{ units_booking_list1.Dated }}</td>
                                        <td>{{ units_booking_list1.OwnerName }}</td>
                                        <td>{{ units_booking_list1.file_plot_number }}</td>
                                        <td>{{ units_booking_list1.Type }}</td>
                                        <td>{{ units_booking_list1.Block_Name }}</td>
                                        <td>{{ units_booking_list1.UnitModule }}</td>
                                        <td>{{ units_booking_list1.Supervision }}</td>
                                        <td>{{ currency }}
                                            {{ Number(units_booking_list1.BookingAmount).toLocaleString() }}/-</td>

                                    </tr>
                                    <tr v-if="toggle_unitsbooking == true">
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
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="html_table_to_excel('xlsx', 'units_booking_report')" class="btn btn-gradient-info">Excel</button>
                        <button type="button" @click="generateUnitsBookingReport()" class="btn btn-gradient-info">Pdf</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="unitbook_report1()">close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- End Filter Units Booking Report -->

</div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
import Multiselect from 'vue-multiselect'
import LaravelVuePagination from 'laravel-vue-pagination';
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
            online_cash_start_date: '',
            chq_superwise_report: '',
            chq_start_date: '',
            e_chq_start_date: '',
            chq_end_date: '',
            e_chq_end_date: '',
            e_online_cash_start_date: '',
            online_cash_end_date: '',
            e_online_cash_end_date: '',
            online_cash_list: {},
            online_cash_report_get: '',
            currency: '',
            phy_cash_report: '',
            cash_start_date: '',
            e_cash_start_date: '',
            cash_end_date: "",
            e_cash_end_date: '',
            debit_creditsupr_report: '',
            debit_credit_start_date: '',
            toggle_chqsuperwise: true,
            e_debit_credit_start_date: '',
            debit_credit_end_date: "",
            e_debit_credit_end_date: "",
            debit_credit_list: {},
            cash_list: {},
            chq_list: {},
            ledherloader: false,
            excelLoader: false,
            ageingtoggle:false,
            // ageing
            blockoption:[],
            chartdata:{},
            pr_block:null,
            pr_module:null,
            e_pr_module:'',
            e_pr_block:'',
            moduleoption:["FileManagement","PlotManagement","Commercial"],
            units_ageing_payables:'',
            pr_year:null,
            years: [],
            toggle_ageing:false,
            pr_month:null,
            get_all_ageing:{},
            units_booking_report: '',
            units_booking_start_date: '',
            e_units_booking_start_date: '',
            units_booking_end_date: '',
            e_units_booking_end_date: '',
            toggle_unitsbooking: true,
            units_booking_list: {},

            toggle_onlinecash: true,

            toggle_cash_supr: true,

            toggle_creditdebit: true,
            paginantion:'',


        }
    },
    watch: {
        start_date(after, before) {
            this.newdata();
        },

    },
    methods: {
        cash_report() {
            const validation = this.$helpers.validateDateRange(this.cash_start_date, this.cash_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");
      if (this.cash_start_date == '') {
                        this.e_cash_start_date = "Please Select Start Date";
                    }
                    if (this.cash_end_date == '') {
                        this.e_cash_end_date = "Please Select End Date";
                    }
    }


                else {
                    this.ledherloader = true;
                    axios.get(`accounts/cash_report/${this.cash_start_date}/${this.cash_end_date}?page=${this.currentPage}`)
            .then(response => {
                this.cash_list = response.data.data;
                this.paginantion=response.data;
  this.totalItems = response.data.total;
                this.toggle_cash_supr = false;
                this.ledherloader = false;
            })
            .catch(error => {
                console.error(error);
                // Handle error
                this.ledherloader = false;
            });
        this.phy_cash_report = 1;
                }
            },
            changePage(pageNumber) {
      this.currentPage = pageNumber;
      this.cash_report(); // Call cash_report method with updated page number
    },
        cash_report1() {
            this.phy_cash_report = ''
            this.cash_start_date = ''
            this.cash_end_date = ''
            this.toggle_cash_supr = true
        },
        // html_table_to_excel(type, tableID) {
        //     var uri = 'data:application/vnd.ms-excel;base64,',
        //         template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table border="1">{table}</table></body></html>',
        //         base64 = function (s) {
        //             return window.btoa(unescape(encodeURIComponent(s)))
        //         },
        //         format = function (s, c) {
        //             return s.replace(/{(\w+)}/g, function (m, p) {
        //                 return c[p];
        //             })
        //         }
        //     var data = document.getElementById(tableID).innerHTML;

        //     var ctx = {
        //         worksheet: name || '',
        //         table: data
        //     };
        //     var link = document.createElement("a");
        //     link.download = tableID + ".xls";
        //     link.href = uri + base64(format(template, ctx))
        //     link.click();
        // },
        html_table_to_excel(type, tableID) {
            this.ledherloader = true;
  this.excelLoader = true;
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
            this.ledherloader = false;
      this.excelLoader = false;
        },

html_table_to_excels(type, tableID) {
  var uri = 'data:application/vnd.ms-excel;base64,';
  var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table border="1">{table}</table></body></html>';
  var base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)));
  };
  var format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
      return c[p];
    });
  };
  this.ledherloader = true;
  this.excelLoader = true;
  // Make an API request to fetch the data
  axios.get(`accounts/cash_report/${this.cash_start_date}/${this.cash_end_date}?exportAll=true`)
    .then(response => {
      var data = response.data; // Access the data within the response object
      this.ledherloader = false;
      this.excelLoader = false;

      // Convert the object data into an HTML table
      var tableHTML = '<tr>' +
        Object.keys(data[0]).map(key => '<th>' + key + '</th>').join('') +
        '</tr>' +
        data.map(row =>
          '<tr>' +
          Object.values(row).map(value => '<td>' + value + '</td>').join('') +
          '</tr>'
        ).join('');

      var ctx = {
        worksheet: name || '',
        table: tableHTML
      };

      var link = document.createElement("a");
      link.download = tableID + ".xls";
      link.href = uri + base64(format(template, ctx));
      link.click();
    })
    .catch(error => {
      console.error(error);
      this.ledherloader = false;
      this.excelLoader = false;
    });
},



        generateCashReport() {
            this.$refs.cashpdf.generatePdf();
        },

        chq_super_report() {
            const validation = this.$helpers.validateDateRange(this.chq_start_date, this.chq_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");

                if (this.chq_start_date == '') {
                    this.e_chq_start_date = "Please Select Start Date";
                }
                if (this.chq_end_date == '') {
                    this.e_chq_end_date = "Please Select End Date";
                }

            } else {
                this.ledherloader = true;
                this.chq_superwise_report = 1
                axios.get("accounts/chq_superwise_detail/" + this.chq_start_date + '/' + this.chq_end_date)
                    .then((response) => {
                        this.toggle_chqsuperwise = false
                        this.chq_list = response.data
                        this.ledherloader = false;
                    })
                    .catch(error => {
      console.error(error);
      this.ledherloader = false;

    });
            }
        },
        chq_super_report1() {
            this.chq_superwise_report = ''
            this.chq_list = {}
            this.toggle_chqsuperwise = true
        },

        generateChqSuperwiseReport() {
            this.$refs.Chqsuperwisepdf.generatePdf();
        },

        debit_credit_report() {
            const validation = this.$helpers.validateDateRange(this.debit_credit_start_date, this.debit_credit_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");

                if (this.debit_credit_start_date == '') {
                    this.e_debit_credit_start_date = "Please Select Start Date";
                }
                if (this.debit_credit_end_date == '') {
                    this.e_debit_credit_end_date = "Please Select End Date";
                }
            } else {
                this.debit_creditsupr_report = 1
                this.ledherloader = true;
                axios.get("accounts/debit_credit_superwisedetail/" + this.debit_credit_start_date + '/' + this.debit_credit_end_date)
                    .then((response) => {
                        this.toggle_creditdebit = false
                        this.debit_credit_list = response.data
                        this.ledherloader = false;
                    })
            }
        },
        debit_credit_report1() {
            this.debit_creditsupr_report = ''
            this.toggle_creditdebit = true
        },
        generateDebitCreditReport() {
            this.$refs.debitcreditpdf.generatePdf();

        },
        online_cash_report() {
            const validation = this.$helpers.validateDateRange(this.online_cash_start_date, this.online_cash_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");

                if (this.online_cash_start_date == '') {
                    this.e_online_cash_start_date = "Please Select Start Date";
                }
                if (this.online_cash_end_date == '') {
                    this.e_online_cash_end_date = "Please Select End Date";
                }
            } else {
                this.ledherloader = true;
                axios.get('accounts/online_cash_report/' + this.online_cash_start_date + '/' + this.online_cash_end_date)
                    .then(response => {
                        this.online_cash_list = response.data;
                        this.toggle_onlinecash = false
                         this.ledherloader = false;
                    })
                this.online_cash_report_get = 1
            }
        },
        generateAgeingReport() {
            this.$refs.ageingpdf.generatePdf();
        },
        module_change(){
            if(this.pr_module =="Commercial"){

        this.blockoption=["Faisal Heights","Ayan Center","SA Premium Homes"]
            }else{
                axios.get("units_ageing_blocks").then((response) => {
            this.chartdata = response.data;
            this.blockoption = [];

            var $this = this;
            for (var i = 0; i < $this.chartdata.length; i++) {

                this.blockoption.push($this.chartdata[i].Block_Name);
            }
        })
            }

        },
        yearChange(){
           this.toggle_ageing=true;
        },
        ageing_payables(){
            if(this.pr_module==null || this.pr_block==null){
      this.$toastr.e("Select Required Fields", "Caution!");
            if(this.pr_module==null){
                this.e_pr_module="Select Module"
            }
            if(this.pr_block==null){
                this.e_pr_block="Select Block"

            }
            }else{
                this.units_ageing_payables=1;
            this.toggle_ageing=false;
            this.ageingtoggle=true;
            axios.get(`get_units_ageing_payables_receivables_report/${this.pr_module}/${this.pr_block}/${this.pr_year}/${this.pr_month}`)
            .then((response)=>{
             this.get_all_ageing=response.data
             this.pr_module=null;
             this.pr_block=null
            this.pr_year=null
            this.pr_month=null
            this.ageingtoggle=false;

            }).catch((err)=>{
            this.ageingtoggle=false;

            })
            }


        },
        ageing_payables1(){
            this.units_ageing_payables=""
        },
        online_cash_report1() {
            this.online_cash_report_get = ''
            this.online_cash_list = {}
            this.online_cash_start_date = ''
            this.online_cash_end_date = ''
            this.toggle_onlinecash = true
        },
        generateOnlineCashReport() {
            this.$refs.onlinecashpdf.generatePdf();
        },
        unitbook_report1() {
            this.units_booking_report = ''
            this.toggle_unitsbooking = true
        },
        unitbook_report() {
            const validation = this.$helpers.validateDateRange(this.units_booking_start_date, this.units_booking_end_date);
            if (!validation.isValid) {
      this.$toastr.e(validation.error, "Caution!");

                if (this.units_booking_start_date == '') {
                    this.e_units_booking_start_date = "Please Select Start Date";
                }
                if (this.units_booking_end_date == '') {
                    this.e_units_booking_end_date = "Please Select End Date";
                }

            } else {
                this.ledherloader = true;
                this.units_booking_report = 1
                axios.get("units_booking_report/" + this.units_booking_start_date + '/' + this.units_booking_end_date)
                    .then((response) => {
                        this.toggle_unitsbooking = false
                        this.units_booking_list = response.data
                        this.ledherloader = false;
                    })
            }
        },

        generateUnitsBookingReport() {
            this.$refs.unitsbookingpdf.generatePdf();
        },
        newdata(){
            this.cash_start_date= this.start_date;
            this.cash_end_date=this.end_date;
            this.chq_start_date= this.start_date;
            this.chq_end_date=this.end_date;
            this.debit_credit_start_date= this.start_date;
            this.debit_credit_end_date=this.end_date;
            this.online_cash_start_date= this.start_date;
            this.online_cash_end_date=this.end_date;
            this.units_booking_start_date= this.start_date;
            this.units_booking_end_date=this.end_date;
        }

},
    mounted() {
        this.newdata();
        axios.get('get_currency').then((response) => {
            this.currency = response.data[0].Currency;
        })
        for (let year = 2015; year <= 2099; year++) {
                    this.years.push(year);
                }
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
