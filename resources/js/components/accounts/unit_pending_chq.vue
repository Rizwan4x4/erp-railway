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
                            <li class="breadcrumb-item">
                                <router-link to="/Accounts/cash_counter" style="text-decoration: none;">Daily Counter</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                Unit Cheques Detail
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="row" style="">
                                    <div class="col-md-12">
                                        <div class="row g-1">
                                            <div class="col-md-3 col-12 mb-2 position-relative">
                                                <label class="form-label">Type</label>
                                                <multiselect @input="filtered_GRN()" placeholder="All Types" :show-labels="false" v-model="select_type" :options="options1">
                                                </multiselect>
                                            </div>
                                            <div class="col-md-2 col-12 mb-2 position-relative">
                                                <label class="form-label">Date From</label>
                                                <input type="date" v-model="datefrom" class="form-control">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <label class="form-label">Date To</label>
                                                <input type="date" class="form-control" v-model="dateto">
                                            </div>
                                            <div class="col-md-2 col-12 mb-3 position-relative">
                                                <button @click="filtered_GRN()" style="background: rgb(193, 193, 193); width: 60% !important; height: 33px !important; margin-bottom: 20px; margin-top: 25px; margin-left: 10px" class="btn btn-common">Search</button>
                                            </div>
                                            <div class="col-md-3 col-12 mb-3 position-relative" style="text-align: right;margin-top: 30px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Date</th>
                                            <th class="sticky-th-center">Receipt No<br />Pay. Type</th>
                                            <th class="sticky-th-center">Chq/Pay Draft No</th>
                                            <th class="sticky-th-left">Name</th>
                                            <th class="sticky-th-center">Block & <br />Plot Type</th>
                                            <th class="sticky-th-center">Type &<br />Module</th>
                                            <th class="sticky-th-center">Amount</th>
                                            <th class="sticky-th-center" v-if="hasPermission('Units-Management units-data supervision')">Status</th>
                                            <th class="sticky-th-center" v-if="hasPermission('Units-Management units-data supervision')">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd" v-for="adsdata1 in adsdata">
                                            <td class="td-center sorting_1"><a class="fw-bold"> {{adsdata1.DateTime}}</a></td>
                                            <td class="td-center sorting_1"> {{adsdata1.ReceiptNo}}<br /><code class="highlighter-rouge">{{adsdata1.PaymentType}}</code></td>
                                            <td class="td-center">{{adsdata1.Ch_Pay_Draft_No}}</td>
                                            <td class="td-left">{{adsdata1.Name}}</td>
                                            <td class="td-center">{{adsdata1.Block}}<br /><code class="highlighter-rouge">{{adsdata1.Plot_Type}}</code></td>
                                            <td class="td-center">
                                                {{adsdata1.Type}}<br /><code class="highlighter-rouge">{{adsdata1.Module}}</code>
                                            </td>
                                            <td class="td-center">{{currency}}. {{Number(adsdata1.Amount).toLocaleString()}}/-</td>
                                            <td class="text-center cursor-pointer" v-if="hasPermission('Units-Management units-data supervision')">
                                                <!--<a target="_blank" v-bind:href="`http://192.168.11.138/Repository/Cheques/${adsdata1.Ch_Pay_Draft_No}_${adsdata1.Bank}_${adsdata1.Ch_Pay_Draft_Date.substr(8, 2)}_${adsdata1.Ch_Pay_Draft_Date.substr(5, 2)}_${adsdata1.Ch_Pay_Draft_Date.substr(0, 4)}.jpg`" class="btn btn-sm">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>-->
                                                <span v-if="adsdata1.Status=='Deposited'" @click="editUCD(adsdata1.ChqID)" data-bs-toggle="modal" data-bs-target="#viewUCD_sts" class="badge badge-glow bg-success">{{adsdata1.Status}}</span>
                                                <span @click="editUCD(adsdata1.ChqID)" data-bs-toggle="modal" data-bs-target="#viewUCD" v-else-if="adsdata1.Status==null" class="badge badge-glow bg-danger">Not Deposit</span>
                                                <span @click="editUCD(adsdata1.ChqID)" data-bs-toggle="modal" data-bs-target="#viewUCD" v-else-if="adsdata1.Status=='Dishonored'" class="badge badge-glow bg-warning">Dishonored</span>
                                            </td>
                                            <td class="td-center" v-if="hasPermission('Units-Management units-data supervision')">
                                                <div class="d-flex align-items-center col-actions" >
                                                    <a class="me-25" v-if="adsdata1.Status=='Deposited'" data-bs-toggle="modal" data-bs-target="#update_int_sts"
                                                       @click="clearnceget(adsdata1.ChqID);editUCD(adsdata1.ChqID)">
                                                        <span class="badge badge-glow bg-info">Mark Clear</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <div class="modal fade" id="viewUCD_sts" tabindex="-1" aria-hidden="true">
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
                                                        ID:
                                                        <span class="invoice-number">{{perorders1.ID}}</span>
                                                    </h5>
                                                    <div class="invoice-date-wrapper row">
                                                        <p class="invoice-date-title" style="width:30%">Date:</p>
                                                        <p style="width:70%" class="invoice-date">{{perorders1.DateTime}}</p>
                                                    </div>
                                                    <div class="invoice-date-wrapper row">
                                                        <p class="invoice-date-title" style="width:50%">Receipt No:</p>
                                                        <p style="width:50%" class="invoice-date">{{perorders1.ReceiptNo}}</p>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Header ends -->
                                        </div>
                                        <hr class="invoice-spacing">
                                        <!-- Address and Contact starts -->
                                        <!-- Address and Contact ends -->
                                        <!-- Invoice Description starts -->
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="py-1">Name</th>
                                                        <th class="py-1">Father Name</th>
                                                        <th class="py-1">Payment Type</th>
                                                        <th class="py-1">Bank</th>
                                                        <th class="py-1">Inst.No</th>
                                                        <th class="py-1">Inst.Date</th>
                                                        <th class="py-1">File Plot No</th>
                                                        <th class="py-1">Type</th>
                                                        <th class="py-1">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="perorders1 in perorders">
                                                        <td class="py-1">
                                                            <p class="card-text fw-bold mb-25">{{perorders1.Name}}</p>

                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Father_Name}}</span>
                                                        </td>

                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.PaymentType}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Bank}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Ch_Pay_Draft_No}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Ch_Pay_Draft_Date}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.File_Plot_No}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Type}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{currency}}. {{Number(perorders1.Amount)}}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-body invoice-padding pb-0">
                                            <div class="row invoice-sales-total-wrapper">
                                                <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                                    <p class="card-text mb-0">
                                                        <span style="width:100%" class="fw-bold">Block:</span>
                                                    </p>
                                                    <p class="card-text text-nowrap">
                                                        {{perorders1.Block}}
                                                    </p>
                                                    <p class="card-text mb-0">
                                                        <span style="width:100%" class="fw-bold">Module:</span>
                                                    </p>
                                                    <p class="card-text text-nowrap">
                                                        {{perorders1.Module}}
                                                    </p>
                                                </div>
                                                <div class="col-6 col-md-6 order-2">
                                                    <p class="card-text mb-0">
                                                        <span style="width:100%" class="fw-bold">Update status:</span>
                                                    </p>
                                                    <select class="form-control" v-model="d_status">
                                                        <option value="">Choose Reason</option>
                                                        <option value="Dishonored">Dishonored</option>

                                                    </select>
                                                    <span style="color: #DB4437; font-size:11px;" v-if="d_status==''">{{e_d_status}}</span>
                                                </div>

                                                <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">

                                                </div>
                                                <div class="col-6 col-md-6 order-2">
                                                    <p class="card-text mb-0">
                                                        <span class="fw-bold">Reason to Discart:</span>
                                                    </p>
                                                    <select class="form-control" v-model="d_reason">
                                                        <option value="">Choose Reason</option>
                                                        <option value="Funds insufficient">Funds insufficient</option>
                                                        <option value="Payment stopped by drawer">Payment stopped by drawer</option>
                                                        <option value="Cheque is postdated/undated/stale with incorrect date">Cheque is postdated/undated/stale with incorrect date</option>
                                                        <option value="Amount in words and figures differs">Amount in words and figures differs</option>
                                                        <option value="Drawer's signature required/incomplete/differs/Forged/Missing/Anuthorized">Drawer's signature required/incomplete/differs/Forged/Missing/Anuthorized</option>
                                                        <option value="Intercity/Same day/All previous clearing stamps require cancellation">Intercity/Same day/All previous clearing stamps require cancellation</option>
                                                        <option value="Alteration in date/amount in figures/amount in words/payee name requires drawer's fill signature">Alteration in date/amount in figures/amount in words/payee name requires drawer's fill signature</option>
                                                        <option value="Company's rubber stamp required">Company's rubber stamp required</option>
                                                        <option value="Not drawn on us">Not drawn on us</option>
                                                        <option value="Collecting Bank's endorsement/discharge unsigned/irregular/required/illegible">Collecting Bank's endorsement/discharge unsigned/irregular/required/illegible</option>
                                                        <option value="Clearing stamp required/irregular">Clearing stamp required/irregular</option>
                                                        <option value="Payee's discharge on revenue stamps required">Payee's discharge on revenue stamps required</option>
                                                        <option value="Unclaim Deposit">Unclaim Deposit</option>
                                                        <option value="Date is Missing">Date is Missing</option>
                                                        <option value="Fake Instrument">Fake Instrument</option>
                                                        <option value="Tempered Instrument">Tempered Instrument</option>
                                                        <option value="Incomplete Instrument">Incomplete Instrument</option>
                                                        <option value="Payment Instrument Contains extraneous Matter/conditional statments">Payment Instrument Contains extraneous Matter/conditional statments</option>
                                                        <option value="Suspious">Suspious</option>
                                                        <option value="Nonresident Account. Form A-7 required">Nonresident Account. Form A-7 required</option>
                                                        <option value="Bank special Crossing required">Bank special Crossing required</option>
                                                        <option value="Stamp Date is invalid">Stamp Date is invalid</option>
                                                        <option value="Payment Stopped on order of Legal/Court or any Law enforcement agency.">Payment Stopped on order of Legal/Court or any Law enforcement agency.</option>
                                                        <option value="Payment cannot be processed due to force majeure event">Payment cannot be processed due to force majeure event</option>
                                                        <option value="Blocked/Frozen">Blocked/Frozen</option>
                                                        <option value="Dormant Account">Dormant Account</option>
                                                        <option value="Photo Account">Photo Account</option>
                                                        <option value="System Error">System Error</option>
                                                        <option value="Closed/Inactive">Closed/Inactive</option>
                                                        <option value="Endorsement Incomplete/Forged">Endorsement Incomplete/Forged</option>
                                                        <option value="Collecting Banks endorsements/Discharged/Unsigned/Irregullar/Illegal">Collecting Banks endorsements/Discharged/Unsigned/Irregullar/Illegal</option>
                                                        <option value="Duplicate Instrument/Instrument lodge again in clearing">Duplicate Instrument/Instrument lodge again in clearing</option>
                                                        <option value="Account Limit Exceeded">Account Limit Exceeded</option>
                                                    </select>
                                                    <span style="color: #DB4437; font-size:11px;" v-if="d_reason==''">{{e_d_reason}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Invoice Description ends -->
                                        <hr class="invoice-spacing">
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled2" @click="delay2()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Cancle
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="viewUCD" tabindex="-1" aria-hidden="true">
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
                                                        ID:
                                                        <span class="invoice-number">{{perorders1.ID}}</span>
                                                    </h5>
                                                    <div class="invoice-date-wrapper row">
                                                        <p class="invoice-date-title" style="width:30%">Date:</p>
                                                        <p style="width:70%" class="invoice-date">{{perorders1.DateTime}}</p>
                                                    </div>
                                                    <div class="invoice-date-wrapper row">
                                                        <p class="invoice-date-title" style="width:50%">Receipt No:</p>
                                                        <p style="width:50%" class="invoice-date">{{perorders1.ReceiptNo}}</p>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Header ends -->
                                        </div>
                                        <hr class="invoice-spacing">
                                        <!-- Address and Contact starts -->
                                        <!-- Address and Contact ends -->
                                        <!-- Invoice Description starts -->
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="py-1">Name</th>
                                                        <th class="py-1">Father Name</th>
                                                        <th class="py-1">Payment Type</th>
                                                        <th class="py-1">Bank</th>
                                                        <th class="py-1">Inst.No</th>
                                                        <th class="py-1">Inst.Date</th>
                                                        <th class="py-1">File Plot No</th>
                                                        <th class="py-1">Type</th>
                                                        <th class="py-1">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="perorders1 in perorders">
                                                        <td class="py-1">
                                                            <p class="card-text fw-bold mb-25">{{perorders1.Name}}</p>

                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Father_Name}}</span>
                                                        </td>

                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.PaymentType}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Bank}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Ch_Pay_Draft_No}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Ch_Pay_Draft_Date}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.File_Plot_No}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Type}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{currency}}. {{Number(perorders1.Amount)}}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-body invoice-padding pb-0">
                                            <div class="row invoice-sales-total-wrapper">
                                                <div class="col-md-6 order-md-1 order-1 mt-md-0 mt-3">
                                                    <p class="card-text mb-0">
                                                        <span style="width:100%" class="fw-bold">Block:</span>
                                                    </p>
                                                    <p class="card-text text-nowrap">
                                                        {{perorders1.Block}}
                                                    </p>
                                                    <p class="card-text mb-0">
                                                        <span style="width:100%" class="fw-bold">Module:</span>
                                                    </p>
                                                    <p class="card-text text-nowrap">
                                                        {{perorders1.Module}}
                                                    </p>
                                                </div>
                                                <div class="col-6 col-md-6 order-2">
                                                    <p class="card-text mb-0">
                                                        <span style="width:100%" class="fw-bold">Deposit Ledger:</span>
                                                    </p>

                                                    <multiselect style="margin-right: 10px;" :show-labels="false"
                                                                 v-model="deposit_bank" :options="options">
                                                    </multiselect>
                                                    <span style="color: #DB4437; font-size:11px;" v-if="deposit_bank==''">{{e_deposit_bank}}</span>
                                                </div>
                                            </div>
                                            <div class="row invoice-sales-total-wrapper">

                                                <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Invoice Description ends -->
                                        <hr class="invoice-spacing">
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button :disabled="disabled1" @click="delay1()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary">
                                                Cancle
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="update_int_sts" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Do you want to clear the cheque?</h1>
                                        <h5 class="mb-1">Deposited Bank Detail</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="py-1">Account ID</th>
                                                        <th class="py-1">Account Name</th>
                                                        <th class="py-1">Deposited Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="perorders1 in perorders">
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.DepositedID}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <p class="card-text fw-bold mb-25">{{perorders1.DepositedAccount}}</p>

                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.DepositDate}}</span>
                                                        </td>


                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="py-1">Name</th>
                                                        <th class="py-1">Father Name</th>
                                                        <th class="py-1">Payment Type</th>
                                                        <th class="py-1">Bank</th>
                                                        <th class="py-1">Inst.No</th>
                                                        <th class="py-1">Inst.Date</th>
                                                        <th class="py-1">File Plot No</th>
                                                        <th class="py-1">Type</th>
                                                        <th class="py-1">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="perorders1 in perorders">
                                                        <td class="py-1">
                                                            <p class="card-text fw-bold mb-25">{{perorders1.Name}}</p>

                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Father_Name}}</span>
                                                        </td>

                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.PaymentType}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Bank}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Ch_Pay_Draft_No}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Ch_Pay_Draft_Date}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.File_Plot_No}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{perorders1.Type}}</span>
                                                        </td>
                                                        <td class="py-1">
                                                            <span class="fw-bold">{{currency}}. {{Number(perorders1.Amount)}}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>



                                        <div class="col-12 col-md-12 order-2">
                                            <p class="card-text mb-0">
                                                <span style="text-align:left;" class="fw-bold">Select Clearance date:</span>
                                            </p>
                                            <input class="form-control" type="date" v-model="cl_date" />
                                            <span style="color: #DB4437; font-size:11px;" v-if="cl_date==''">{{e_cl_date}}</span>
                                        </div>
                                        <br>
                                        <div class="text-center" style="text-align:center" v-for="clearanceId1 in clearanceId">
                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" @click="clearanceUpdate(clearanceId1.ChqID, cl_date)" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                                            <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">No</button>
                                        </div>
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
    import axios from 'axios';
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
        data() {
            return {
                trans_types: {},
                options1: [],
                select_type: '',
                select_type1: '',

                d_reason: '',
                e_d_reason: '',
                d_status: '',
                e_d_status: '',
                cl_date: '',
                e_cl_date: '',

                companydetail: {},
                adsdata: {},
                perorders: {},
                options: [],

                datefrom: '',
                dateto: '',
                deposit_bank: '',
                e_deposit_bank: '',
                currency: '',
                clearanceId: {},

                disabled: false,
                timeout: null,
                disabled1: false,
                timeout1: null,
                disabled2: false,
                timeout2: null,

                methods: {},
            }
        },
        methods: {
            filtered_GRN() {
                if (this.dateto == '' || this.datefrom == '') {
                    this.$toastr.e("Please select Both Dates!", "Caution!");
                }
                else {
                    if (this.select_type == '' || this.select_type == null) {
                        this.select_type1 = 'All';
                    }
                    else {
                        this.select_type1 = this.select_type;
                    }
                    axios.get("accounts/search_units_date/" + this.datefrom + '/' + this.dateto + '/' + this.select_type1)
                        .then(data => {
                            this.adsdata = data.data;
                        })
                        .catch(error => this.error = error.response.data.errors)
                }
            },
            searchDate() {
                this.datefrom = "";
                this.dateto = "";
                this.getResult();
            },
            editUCD(id) {
                axios.get('accounts/units_check_detail/' + id)
                    .then(response => {
                        this.perorders = response.data;
                    })
            },
            clearnceget(id) {
                axios.get("accounts/clearncedetails/" + id).then((response) => {
                    this.clearanceId = response.data
                }).catch((err) => {
                    console.log(err);
                })
            },
            delay() {
                this.disabled = true
                this.timeout = setTimeout(() => {
                    this.disabled = false
                }, 5000)
                this.update_po();
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.submit_deposit_bank();
            },
            delay2() {
                this.disabled2 = true
                this.timeout2 = setTimeout(() => {
                    this.disabled2 = false
                }, 5000)
                this.submit_discart();
            },
            clearanceUpdate(id, date) {
                if (this.cl_date == '') {
                    this.e_cl_date = 'Select Date';
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    this.e_cl_date = '';
                    axios.post("accounts/updateclearance/" + id + '/' + date).then((response) => {
                        if (response.data == 'Updated') {
                            this.$toastr.s("Clearanced Submitted Successfully", "Congratulations!");
                            this.getResult();
                        }
                        else if (response.data == 'Account Head Not Linked') {
                            this.$toastr.e("Transaction Type Not Linked with Accounts COA", "Cautions!");
                        }
                    }).catch((err) => {
                        console.log(err);
                    })
                }

            },
            submit_deposit_bank() {

                if (this.deposit_bank == '') {
                    if (this.deposit_bank == '') {
                        this.e_deposit_bank = 'Select Account ledger'
                    }

                    this.$toastr.e("Please fill required fields!", "Caution!");
                } else {
                    axios.post("submit_deposit_bankdetails", {
                        id: this.perorders[0].ID,
                        chqId: this.perorders[0].ChqID,

                        Deposit_Bank: this.deposit_bank,

                    }).then((response) => {
                        if (response.data == 'Submitted') {
                            this.perorders = {};
                            this.$toastr.s("Unit Chq Submitted Successfully", "Congratulations!");
                            this.deposit_bank = ''
                            this.getResult();
                        }
                    }).catch((err) => {
                        console.log(err);
                    })
                }
            },
            submit_discart() {
                if (this.d_reason == '' || this.d_status == '') {
                    if (this.d_reason == '') {
                        this.e_d_reason = 'Select Reason'
                    }
                    else {
                        this.e_d_reason = ''
                    }
                    if (this.d_status == '') {
                        this.e_d_status = 'Select Status'
                    }
                    else {
                        this.e_d_status = ''
                    }
                    this.$toastr.e("Please fill required fields!", "Caution!");
                }
                else {
                    axios.post("account_deposit_status", {
                        id: this.perorders[0].ID,
                        chqId: this.perorders[0].ChqID,

                        d_status: this.d_status,
                        d_reason: this.d_reason,

                    }).then((response) => {
                        if (response.data == 'Submitted') {
                            this.perorders = {};
                            this.$toastr.s("Update Status Submitted Successfully", "Congratulations!");
                            this.d_status = '';
                            this.d_reason = '';
                            this.getResult();
                        }
                        else {
                            this.$toastr.e(response.data, "Error!");
                        }
                    }).catch((err) => {
                        console.log(err);
                    })
                }
            },
            getResult(page = 1) {
                axios.get('accounts/get_units_chq_detail/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
        },
        mounted() {
            axios.get('accounts/unit_trans_type')
                .then(response => {
                    this.trans_types = response.data;

                    this.options1 = [];

                    var $this = this;
                    for (var i = 0; i < $this.trans_types.length; i++) {
                        this.options1.push($this.trans_types[i].Type);
                    }

                })
                .catch(error => { });

            axios.get('accounts/fetch_bank_methods')
                .then(response => {
                    this.methods = response.data
                    this.options = [];

                    var $this = this;
                    for (var j = 0; j < $this.methods.length; j++) {
                        this.options.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
                    }
                })
            this.getResult();
            axios.get('get_currency').then((response) => {
                this.currency = response.data[0].Currency;
            })
            axios.get('fetch_companydetail')
                .then(response => this.companydetail = response.data)

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
