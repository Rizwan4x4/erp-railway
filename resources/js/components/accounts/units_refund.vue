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
                                Units Refund
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="content-body">
                    <!-- users list start -->
                    <section class="app-user-list">
                        <div clas="card" style="background-color:white !important">
                            <div class="col-md-12 row" style="margin:10px;">
                                <div class="col-md-3 col-12">
                                    <label class="form-label">Date From</label>
                                    <input type="date" v-model="datefrom" class="form-control">
                                </div>
                                <div class="col-md-3 col-12">
                                    <label class="form-label">Date To</label>
                                    <input type="date" class="form-control" v-model="dateto">
                                </div>
                                <div class="col-md-1 col-12">
                                    <button @click="filtered_GRN()" style="margin-top: 25px;" class="btn btn-secondary">Search</button>
                                </div>
                                <div class="col-md-3 col-12">
                                    <input style="margin-top: 25px;" type="text" v-model="keyword1" class="form-control" placeholder="Owner name / Unit number / Receipt No" />
                                </div>
                            </div>
                            <div class="table-responsive" style="overflow-x: initial !important;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sticky-th-center">Date</th>
                                            <th class="sticky-th-center">Receipt No<br />& Type</th>
                                            <th class="sticky-th-left">Name &<br />Father Name</th>
                                            <th class="sticky-th-center">Type &<br />Block</th>
                                            <th class="sticky-th-center">File Plot No</th>
                                            <th class="sticky-th-center">Total<br />Amount</th>
                                            <th class="sticky-th-center">Received<br />Amount</th>
                                            <th class="sticky-th-center">Deduction</th>
                                            <th class="sticky-th-center" v-if="hasPermission('Units-Management units-data supervision')">Status</th>
                                            <th class="sticky-th-center" v-if="hasPermission('Units-Management units-data supervision')">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="adsdata1 in adsdata.data">
                                            <td class="td-center">{{adsdata1.DateTime.split(' ')[0]}}</td>
                                            <td class="td-center">{{adsdata1.ReceiptNo}}<br />{{adsdata1.Receipt_Type}}</td>
                                            <td class="td-left">
                                                <div class="d-flex flex-column">
                                                    <a class="user_name text-truncate text-body"><span class="fw-bolder">{{adsdata1.Name}}</span></a> <small class="emp_post text-muted">{{adsdata1.Father_Name}}</small>
                                                </div>
                                            </td>
                                            <td class="td-center">{{adsdata1.Plot_Type}}<br />{{adsdata1.Block}}</td>
                                            <td class="td-center">{{adsdata1.File_Plot_Number}}</td>
                                            <td class="td-right">{{Math.round(adsdata1.Plot_Total_Amount).toLocaleString()}}/-</td>
                                            <td class="td-right">{{Math.round(adsdata1.Amount).toLocaleString()}}/-</td>
                                            <td class="td-right">{{Math.round(adsdata1.Deduction_Amt).toLocaleString()}}/-</td>
                                            <td class="td-center" v-if="adsdata1.Receipt_Type=='Cancelled' && hasPermission('Units-Management units-data supervision')">
                                                <span v-if="adsdata1.Status=='Proceed'" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                <span @click="editPV(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#viewPV2" v-else-if="adsdata1.Status=='Not Cleared'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span><br />
                                                <a v-if="adsdata1.Status=='Proceed' && adsdata1.Receipt_Type=='Cancelled' " target="_blank" v-bind:href="`Accounts/unit_refunds_letter/${adsdata1.ID}`" class="btn btn-sm">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                            </td>
                                            <td class="td-center" v-else-if="(adsdata1.Receipt_Type=='Amount Refund' || adsdata1.Receipt_Type=='Extra Amount Refund') && hasPermission('Units-Management units-data supervision')">
                                                <span v-if="adsdata1.Status=='Proceed'" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                <span @click="editPV(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#viewrefundPV2" v-else-if="adsdata1.Status=='Not Cleared'" class="badge badge-glow bg-info">{{adsdata1.Status}}</span><br />
                                                <a target="_blank" v-if="adsdata1.Status=='Proceed' && adsdata1.Receipt_Type=='Amount Refund' || adsdata1.Receipt_Type=='Extra Amount Refund'" v-bind:href="`Accounts/unit_refunds_amount_letter/${adsdata1.ID}`" class="btn btn-sm">
                                                    <i class="fa-solid fa-print"></i>
                                                </a><br />
                                            </td>
                                            <td class="td-center" v-else>
                                                <span v-if="adsdata1.Status=='Proceed' && hasPermission('Units-Management units-data supervision')" class="badge badge-glow bg-primary">{{adsdata1.Status}}</span>
                                                <span @click="editPV(adsdata1.ID)" data-bs-toggle="modal" data-bs-target="#viewrefundPV3" v-else-if="adsdata1.Status=='Not Cleared' && hasPermission('Units-Management units-data supervision')" class="badge badge-glow bg-info">{{adsdata1.Status}}</span><br />
                                                <a target="_blank" v-if="adsdata1.Status=='Proceed' && adsdata1.Receipt_Type=='Repurchased' && hasPermission('Units-Management units-data supervision') " v-bind:href="`Accounts/unit_repurchased_amount_letter/${adsdata1.ID}`" class="btn btn-sm">
                                                    <i class="fa-solid fa-print"></i>
                                                </a><br />
                                            </td>
                                            <td class="td-center" v-if="hasPermission('Units-Management units-data supervision')">
                                                <div class="d-flex align-items-center col-actions">
                                                    <div class="btn-group">
                                                        <a data-bs-toggle="dropdown" class="btn btn-sm dropdown-toggle hide-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-small-4"><circle cx="12" cy="12" r="1"></circle> <circle cx="12" cy="5" r="1"></circle> <circle cx="12" cy="19" r="1"></circle></svg></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a @click="Cancelled_paid(adsdata1.ID,adsdata1.RemainingAmount)" data-bs-toggle="modal" data-bs-target="#apprfinance" class="dropdown-item" v-if="adsdata1.Status=='Proceed' && adsdata1.RemainingAmount !==0 && adsdata1.Receipt_Type=='Cancelled' && adsdata1.RemainingAmount>0">
                                                                <i class="fa-brands fa-amazon-pay"></i>
                                                                Pay
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.PaidAmount >0 && adsdata1.Receipt_Type=='Cancelled'" v-bind:href="`Accounts/Cancelled_receipt_bill/${adsdata1.ID}`" class="btn btn-sm">
                                                                <i class="fa-solid fa-print"></i>Print Bill
                                                            </a>
                                                            <a @click="Cancelled_paid(adsdata1.ID,adsdata1.RemainingAmount)" data-bs-toggle="modal" data-bs-target="#apprfinance1" class="dropdown-item" v-if="adsdata1.Status=='Proceed'  && (adsdata1.Receipt_Type=='Amount Refund' || adsdata1.Receipt_Type=='Extra Amount Refund') && adsdata1.RemainingAmount>0">
                                                                <i class="fa-brands fa-amazon-pay"></i>
                                                                Pay
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.PaidAmount >0 && (adsdata1.Receipt_Type=='Amount Refund' || adsdata1.Receipt_Type=='Extra Amount Refund')" v-bind:href="`Accounts/Amount_refund_receipt_bill/${adsdata1.ID}`" class="btn btn-sm">
                                                                <i class="fa-solid fa-print"></i>Print Bill
                                                            </a>
                                                            <a @click="Cancelled_paid(adsdata1.ID,adsdata1.RemainingAmount)" data-bs-toggle="modal" data-bs-target="#apprfinance2" class="dropdown-item" v-if="adsdata1.Status=='Proceed'  && adsdata1.Receipt_Type=='Repurchased' && adsdata1.RemainingAmount>0">
                                                                <i class="fa-brands fa-amazon-pay"></i>
                                                                Pay
                                                            </a>
                                                            <a target="_blank" v-if="adsdata1.PaidAmount >0 && adsdata1.Receipt_Type=='Repurchased'" v-bind:href="`Accounts/Amount_repurchased_receipt_bill/${adsdata1.ID}`" class="btn btn-sm">
                                                                <i class="fa-solid fa-print"></i>Print Bill
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
                                <pagination v-if="pageN==1" :data="adsdata" :limit="limit" @pagination-change-page="getResults"></pagination>
                                <pagination v-else-if="pageN==2" :data="adsdata" :limit="limit" @pagination-change-page="filtered_GRN"></pagination>
                            </div>
                            <!--
                            <div class="col-md-12" style="text-align:center;padding-top:20px">
                                <pagination v-if="pageN==1" :data="adsdata" :limit="limit" @pagination-change-page="getResult"></pagination>
                                <pagination v-else-if="pageN==3" :data="adsdata" :limit="limit" @pagination-change-page="getResults1"></pagination>
                                <pagination v-else-if="pageN==4" :data="adsdata" :limit="limit" @pagination-change-page="getbyfilter"></pagination>
                            </div>
                                -->
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="apprfinance" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                np
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <h1 class="text-center fw-bolder">Confirmation</h1>
                            <h5 class="text-center">Do you want to Pay Cancelled Units Refund?</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Remaining Amount</label>
                                    <input type="text" readonly class="form-control" v-model="remaining_amount" />
                                </div>
                                <div class="col-md-6">
                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Method Type:</h6>
                                    <div class="invoice-customer">
                                        <multiselect style="margin-right: 10px;" v-model="method_type" :options="options2"> </multiselect>
                                        <span style="color: #db4437; font-size: 11px" v-if="method_type== ''">{{ e_method_type }}</span>
                                    </div>
                                    <div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                    <div class="invoice-customer">
                                                        <label class="form-label" for="modalAddCardNumber">Chq Date</label>
                                                        <input v-model="chq_date" type="date"  id="modalAddCardName" class="form-control" />
                                                    </div>
                                                    <div>
                                                    </div>
                                        </div>
                                        <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                    <div class="invoice-customer">
                                                       <label class="form-label" for="modalAddCardNumber">Chq Number</label><input v-model="chq_number" type="number" id="modalAddCardName" class="form-control" />
                                                    </div>
                                                    <div>
                                                    </div>
                                        </div>
                                <div class="col-md-12">
                                    <label>Paid Amount</label>
                                    <input type="text" class="form-control" v-model="paid_amount" />
                                </div>
                            </div>
                            <br>
                            <div class="text-center" style="text-align:center">
                                <button type="button" :disabled="disabled3" @click="delay3()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="apprfinance1" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                np
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <h1 class="text-center fw-bolder">Confirmation</h1>
                            <h5 class="text-center">Do you want to Paid Amount Refund?</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Remaining Amount</label>
                                    <input type="text" readonly class="form-control" v-model="remaining_amount" />
                                </div>
                                <div class="col-md-6">
                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Method Type:</h6>
                                    <div class="invoice-customer">
                                        <multiselect style="margin-right: 10px;" v-model="method_type" :options="options2"> </multiselect>
                                        <span style="color: #db4437; font-size: 11px" v-if="method_type== ''">{{ e_method_type }}</span>
                                    </div>
                                    <div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                    <div class="invoice-customer">
                                                        <label class="form-label" for="modalAddCardNumber">Chq Date</label>
                                                        <input v-model="chq_date" type="date"  id="modalAddCardName" class="form-control" />
                                                    </div>
                                                    <div>
                                                    </div>
                                        </div>
                                        <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                    <div class="invoice-customer">
                                                       <label class="form-label" for="modalAddCardNumber">Chq Number</label><input v-model="chq_number" type="number" id="modalAddCardName" class="form-control" />
                                                    </div>
                                                    <div>
                                                    </div>
                                        </div>
                                <div class="col-md-12">
                                    <label>Paid Amount</label>
                                    <input type="text" class="form-control" v-model="paid_amount" />
                                </div>
                            </div>
                            <br>
                            <div class="text-center" style="text-align:center">
                                <button type="button" :disabled="disabled4" @click="delay4()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="apprfinance2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                np
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="mb-2">
                            <h1 class="text-center fw-bolder">Confirmation</h1>
                            <h5 class="text-center">Do you want to Paid Repurchased Amount ?</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Remaining Amount</label>
                                    <input type="text" readonly class="form-control" v-model="remaining_amount" />
                                </div>
                                <div class="col-md-6">
                                    <h6 class="invoice-to-title" style="margin-bottom:5px">Method Type:</h6>
                                    <div class="invoice-customer">
                                        <multiselect style="margin-right: 10px;" v-model="method_type" :options="options2"> </multiselect>
                                        <span style="color: #db4437; font-size: 11px" v-if="method_type== ''">{{ e_method_type }}</span>
                                    </div>
                                    <div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                    <div class="invoice-customer">
                                                        <label class="form-label" for="modalAddCardNumber">Chq Date</label>
                                                        <input v-model="chq_date" type="date"  id="modalAddCardName" class="form-control" />
                                                    </div>
                                                    <div>
                                                    </div>
                                        </div>
                                        <div class="col-md-6" v-if="this.method_type!='101001001001_Cash in Hand'">

                                                    <div class="invoice-customer">
                                                       <label class="form-label" for="modalAddCardNumber">Chq Number</label><input v-model="chq_number" type="number" id="modalAddCardName" class="form-control" />
                                                    </div>
                                                    <div>
                                                    </div>
                                        </div>
                                <div class="col-md-12">
                                    <label>Paid Amount</label>
                                    <input type="text" class="form-control" v-model="paid_amount" />
                                </div>
                            </div>
                            <br>
                            <div class="text-center" style="text-align:center">
                                <button type="button" :disabled="disabled9" @click="delay9()" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal" aria-label="Close">Submit</button>
                                <button type="submit" class="btn btn-outline-primary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
        <div class="modal fade" id="viewPV2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="paymentVchrs1 in paymentVchrs">
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
                                    <div class="mt-md-0 mt-2" style="min-width:30%">
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{paymentVchrs1.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{paymentVchrs1.DateTime.split(' ')[0]}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p>Block: {{paymentVchrs1.Block}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Unit Cancellation</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="divider">
                                <div class="divider-text" style="font-size: 14px;font-weight: 900;">Debit Account</div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3" v-if="paymentVchrs1.Block == 'SA Premium Homes' || paymentVchrs1.Block == 'Premium Homes' || paymentVchrs1.Block == 'Ayaan Center' || paymentVchrs1.Block == 'Faisal Height'">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{ paymentVchrs1.Block }} Sales</p>
                                </div>
                                <div class="col-md-3" v-else>
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{ paymentVchrs1.Block }} Block {{ paymentVchrs1.Plot_Type }} Sales</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Cancellation of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file cancel due to not payment with {{Number(paymentVchrs1.Deduction)}} % deduction</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(paymentVchrs1.Plot_Total_Amount)}}
                                    </p>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 14px;font-weight: 900;">Credit Account</div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Sale return - payables</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Cancellation of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file cancel due to not payment with {{Number(paymentVchrs1.Deduction)}} % deduction</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(sumStats(paymentVchrs1.Amount,paymentVchrs1.Deduction_Amt))}}
                                    </p>
                                </div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Cancellation Charges</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Cancellation of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file cancel due to not payment with {{Number(paymentVchrs1.Deduction)}} % deduction</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(paymentVchrs1.Deduction_Amt)}}
                                    </p>
                                </div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3" v-if="paymentVchrs1.Block == 'SA Premium Homes' || paymentVchrs1.Block == 'Premium Homes' || paymentVchrs1.Block == 'Ayaan Center' || paymentVchrs1.Block == 'Faisal Height'">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{ paymentVchrs1.Block }} Receivables</p>
                                </div>
                                <div class="col-md-3" v-else>
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{ paymentVchrs1.Block }} Block {{ paymentVchrs1.Plot_Type }} Receivables</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Cancellation of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file cancel due to not payment with {{Number(paymentVchrs1.Deduction)}} % deduction</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(sumStats1(paymentVchrs1.Plot_Total_Amount,paymentVchrs1.Amount))}}
                                    </p>
                                </div>
                            </div>
                            <!-- Address and Contact ends -->
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="col-6 col-md-6 order-2">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Update Status:</span>
                                            </p>
                                            <input hidden type="text" v-model="pv_id" />
                                            <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                                <option value=""> Select Status </option>
                                                <option value="Proceed">Proceed</option>
                                            </select>
                                            <span style="color: #DB4437; font-size:11px;" v-if="up_sts==''">{{e_up_sts}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end order-md-2 order-1" style="padding-right: 50px;margin-bottom: 10px;margin-top:10px">
                                    <button :disabled="disabled1" @click="delay1()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                        Cancle
                                    </button>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewrefundPV2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="paymentVchrs1 in paymentVchrs">
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
                                    <div class="mt-md-0 mt-2" style="min-width:30%">
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{paymentVchrs1.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{paymentVchrs1.DateTime.split(' ')[0]}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p>Block: {{paymentVchrs1.Block}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Unit Refund</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="divider">
                                <div class="divider-text" style="font-size: 14px;font-weight: 900;">Credit Account</div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Excess recovered refund - payables </p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Refund of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file refund due to Exceed Amount</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(paymentVchrs1.Amount)}}
                                    </p>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 14px;font-weight: 900;">Debit Account</div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3" v-if="paymentVchrs1.Plot_Type=='Apartment'">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{paymentVchrs1.Project}} Receivables</p>
                                </div>
                                <div class="col-md-3" v-else-if="paymentVchrs1.Block=='Main G.T Road'">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Main GT road Block {{ paymentVchrs1.Plot_Type }} Receivables</p>
                                </div>
                                <div class="col-md-3" v-else>
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{ paymentVchrs1.Block }} Block {{ paymentVchrs1.Plot_Type }} Receivables</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Refund of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file refund due to Exceed Amount</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(paymentVchrs1.Amount)}}
                                    </p>
                                </div>
                            </div>


                            <!-- Address and Contact ends -->
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="col-6 col-md-6 order-2">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Update Status:</span>
                                            </p>
                                            <input hidden type="text" v-model="pv_id" />
                                            <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                                <option value=""> Select Status </option>
                                                <option value="Proceed">Proceed</option>
                                            </select>
                                            <span style="color: #DB4437; font-size:11px;" v-if="up_sts==''">{{e_up_sts}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end order-md-2 order-1" style="padding-right: 50px;margin-bottom: 10px;margin-top:10px">
                                    <button :disabled="disabled2" @click="delay2()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                        Cancle
                                    </button>
                                </div>
                            </div>
                            <!-- Invoice Description ends -->
                            <hr class="invoice-spacing">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewrefundPV3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-preview-card" v-for="paymentVchrs1 in paymentVchrs">
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
                                    <div class="mt-md-0 mt-2" style="min-width:30%">
                                        <h5 class="invoice-title">
                                            ID:
                                            <span class="invoice-number">{{paymentVchrs1.ID}}</span>
                                        </h5>
                                        <div class="invoice-date-wrapper row">
                                            <p class="invoice-date-title" style="width:30%">Date:</p>
                                            <p style="width:70%" class="invoice-date">{{paymentVchrs1.DateTime.split(' ')[0]}}</p>
                                        </div>
                                        <div class="invoice-date-wrapper row">
                                            <p>Block: {{paymentVchrs1.Block}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Header ends -->
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 24px;font-weight: 900;">Unit Repurchased</div>
                            </div>
                            <!-- Address and Contact starts -->
                            <div class="divider">
                                <div class="divider-text" style="font-size: 14px;font-weight: 900;">Debit Account</div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{paymentVchrs1.Plot_Type}} Plot Repurchased </p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Repurchased of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file  Repurchased</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(paymentVchrs1.Repurchased_Amt)}}
                                    </p>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text" style="font-size: 14px;font-weight: 900;">Credit Account</div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Repurchased Payable</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Repurchased of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file refund due to Exceed Amount</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(sumStats5(paymentVchrs1.Repurchased_Amt,paymentVchrs1.Plot_Total_Amount,paymentVchrs1.Discount_Amount,paymentVchrs1.Amount))}}
                                    </p>
                                </div>
                            </div>
                            <div class="row" v-for="paymentVchrs1 in paymentVchrs" style="padding-left:5%;padding-right:5%;margin-bottom:10px">
                                <div class="col-md-3" v-if="paymentVchrs1.Plot_Type == 'Apartment'">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">{{ paymentVchrs1.Project}} Receivables</p>
                                </div>
                                <div class="col-md-3" v-else-if="paymentVchrs1.Block == 'Main G.T Road'">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Main G.T Road Block {{ paymentVchrs1.Plot_Type }} Receivables</p>
                                </div>
                                <div class="col-md-3" v-else>
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">Block {{ paymentVchrs1.Plot_Type }} Receivables</p>
                                </div>
                                <div class="col-md-6">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;">Units Repurchased of Plot No:{{paymentVchrs1.File_Plot_Number}} Block No:{{paymentVchrs1.Block}} file refund due to Exceed Amount</p>

                                </div>
                                <div class="col-md-3">
                                    <p style="border-radius: 3px !important;border: 1px solid lightgray;padding: 5px;min-height: 75px;">
                                        {{Math.round(sumStatsRepurchased1(paymentVchrs1.Plot_Total_Amount,paymentVchrs1.Discount_Amount,paymentVchrs1.Amount))}}
                                    </p>
                                </div>
                            </div>


                            <!-- Address and Contact ends -->
                            <div class="card-body invoice-padding pb-0">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="col-6 col-md-6 order-2">
                                            <p class="card-text mb-0">
                                                <span style="width:100%" class="fw-bold">Update Status:</span>
                                            </p>
                                            <input hidden type="text" v-model="pv_id" />
                                            <select v-model="up_sts" class="form-select mb-md-0 mb-2">
                                                <option value="">Select Status</option>
                                                <option value="Proceed">Proceed</option>
                                            </select>
                                            <span style="color: #DB4437; font-size:11px;" v-if="up_sts==''">{{e_up_sts}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end order-md-2 order-1" style="padding-right: 50px;margin-bottom: 10px;margin-top:10px">
                                    <button :disabled="disabled2" @click="delay8()" type="submit" class="btn btn-primary me-1" data-bs-dismiss="modal" aria-label="Close">Update</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                        Cancle
                                    </button>
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
    import MaskedInput from 'vue-masked-input'
    import Multiselect from 'vue-multiselect'
    export default {
        data() {
            return {
                limit: 10,
                pageN: 1,

                adsdata: {},
                up_sts: '',
                paid_amount: 0,
                method_type: '101001001001_Cash in Hand',
                e_method_type: '',
                e_up_sts: '',
                companydetail: {},
                paymentVchrs: {},
                success: '',
                pv_id: '',
                keyword1: '',
                methods: {},
                options2: [],
                disabled1: false,
                disabled3: false,
                disabled4: false,
                timeout1: null,
                pv_id1: '',
                datefrom: '',
                dateto: '',
                remaining_amount: 0,
                disabled2: false,
                timeout2: null,
                chq_date:'',
            chq_number:'',
            disabled9: false,
                timeout9: null,
            }
        },
        components: {
            MaskedInput,
            Multiselect
        },
        methods: {
         sumStats(num1, num2) {
              let $total=num1-num2
               return Number($total)
            },
            sumStats1(num0, num1) {
                let total1=num0-num1
                return total1
            },
            sumStatsRepurchased1(num0, discount,num1) {
                if(discount ==null){
                    discount=0
                }
                let total1=(num0-discount)-num1
                return total1
            },
            sumStats5(num0,num1,discount, num2){
                if(discount==null){
                    discount=0
                }
                let recvd_amount=(num1-discount)-num2;
                let payable=num0-recvd_amount;
                return payable
            },
            filtered_GRN(page = 1) {
                if (this.datefrom == '' || this.dateto == '') {
                    this.$toastr.e("Please select Both Dates!", "Caution!");
                }
                else {
                    axios.get("search_unitrefund_date/" + this.datefrom + "/" + this.dateto + '/?page=' + page)
                        .then(data => {
                            this.adsdata = data.data;
                            this.pageN = 2;
                        })
                        .catch(error => this.error = error.response.data.errors)
                }
            },
            Cancelled_paid(id, remaining) {
                this.pv_id1 = id;
                this.remaining_amount = Number(remaining);
            },
            delay1() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_preq_status();
            },
            delay3() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.paid_cancelled_refund();
            },
            delay4() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.paid_amount_refund();
            },
            delay9() {
                this.disabled9 = true
                this.timeout9 = setTimeout(() => {
                    this.disabled9 = false
                }, 5000)
                this.paid_amount_repurchased();
            },
            paid_amount_repurchased() {
                if (this.method_type == '') {
                    this.e_method_type = 'Select Method Type'
                    this.$toastr.e("Select Compulsory Fields!", "Caution!");

                } else {
                    axios.post('paid_units_amount_repurchased', {
                        pv_id: this.pv_id1,
                        remaining: this.remaining_amount,
                        amount: this.paid_amount,
                        method: this.method_type,
                         chq_date:this.chq_date,
                        chq_number:this.chq_number,
                    })
                        .then(data => {
                            if (data.data == "submitted") {
                                this.$toastr.s("Units Repurchased Amount Paid successfully!", "Congratulations");
                                this.getResults();
                                this.pv_id1 = "";
                                this.method_type = "";
                                this.remaining_amount = 0;
                                this.paid_amount = 0;
                                this.chq_date= "";
                            this.chq_number= "";
                            }
                            else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                        })
                }
            },
            paid_amount_refund() {
                if (this.method_type == '') {
                    this.e_method_type = 'Select Method Type'
                    this.$toastr.e("Select Compulsory Fields!", "Caution!");

                } else {
                    axios.post('paid_units_amount_refund', {
                        pv_id: this.pv_id1,
                        remaining: this.remaining_amount,
                        amount: this.paid_amount,
                        method: this.method_type,
                         chq_date:this.chq_date,
                        chq_number:this.chq_number,
                    })
                        .then(data => {
                            if (data.data == "submitted") {
                                this.$toastr.s(" Units Refund Amount Paid successfully!", "Congratulations");
                                this.getResults();
                                this.pv_id1 = "";
                                this.method_type = "";
                                this.remaining_amount = 0;
                                this.paid_amount = 0;
                                this.chq_date= "";
                            this.chq_number= "";
                            }
                            else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                        })
                }
            },


            paid_cancelled_refund() {
                if (this.method_type == '') {
                    this.e_method_type = 'Select Method Type'
                    this.$toastr.e("Select Compulsory Fields!", "Caution!");
                }
                else {
                    axios.post('paid_units_cancelled_refund', {
                        pv_id: this.pv_id1,
                        remaining: this.remaining_amount,
                        amount: this.paid_amount,
                        method: this.method_type,
                         chq_date:this.chq_date,
                        chq_number:this.chq_number,
                    })
                        .then(data => {
                            if (data.data == "submitted") {
                                this.$toastr.s("Cancelled Units Refund Paid successfully!", "Congratulations");
                                this.getResults();
                                this.pv_id1 = "";
                                this.method_type = "";
                                this.remaining_amount = 0;
                                this.paid_amount = 0;
                                this.chq_date= "";
                            this.chq_number= "";
                            } else {
                                this.$toastr.e(data.data, "Caution!");
                            }
                        })
                }
            },
            delay2() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_refud_status();
            },
            update_preq_status() {
                if (this.up_sts == '' || this.pv_id == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.up_sts == '') {
                        this.e_up_sts = "Select status";
                    }
                }
                else {
                    axios.post('update_units_refund', {
                        pv_id: this.pv_id,
                        sts: this.up_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                this.getResults();
                                this.pv_id = "";
                                this.up_sts = "";
                            }
                        })
                }
            },
            update_refud_status() {
                if (this.up_sts == '' || this.pv_id == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.up_sts == '') {
                        this.e_up_sts = "Select status";
                    }
                } else {
                    axios.post('update_units_refund_amount', {
                        pv_id: this.pv_id,
                        sts: this.up_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                this.getResults();
                                this.pv_id = "";
                                this.up_sts = "";
                            }
                        })
                }
            },
            editPV(id) {
                axios.get('single_units_refund/' + id)
                    .then(response => {
                        this.paymentVchrs = response.data;
                        this.pv_id = response.data[0].ID;
                    })
            },
            getResult(page = 1) {
                axios.get('units_fund_detail/?page=' + page)
                    .then(response => this.adsdata = response.data)
                    .catch(error => { });
            },
            getResults(page = 1) {
                this.datefrom = '';
                this.dateto = '';
                axios.get('search_refund_byname/?page=' + page, { params: { keyword1: this.keyword1 } })
                    .then(response => {
                        this.adsdata = response.data;
                        this.pageN = 1;
                    })
                    .catch(error => console.log(error));
            },
            delay8() {
                this.disabled1 = true
                this.timeout1 = setTimeout(() => {
                    this.disabled1 = false
                }, 5000)
                this.update_repurchased_status();
            },
            update_repurchased_status(){
                if (this.up_sts == '' || this.pv_id == '') {
                    this.$toastr.e("Please fill required fields!", "Caution!");
                    if (this.up_sts == '') {
                        this.e_up_sts = "Select status";
                    }
                } else {
                    axios.post('update_units_repurchased_amount', {
                        pv_id: this.pv_id,
                        sts: this.up_sts,
                    })
                        .then(data => {
                            if (data.data == "Status updated!") {
                                this.$toastr.s("Status updated successfully!", "Congratulations");
                                this.getResults();
                                this.pv_id = "";
                                this.up_sts = "";
                            }
                        })
                }
            }
        },
        watch: {
            keyword1(after, before) {
                this.getResults();
            }
        },
        mounted() {
            axios.get('accounts/fetch_methods')
                .then(response => {
                    this.methods = response.data
                    this.options2 = [];
                    var $this = this;
                    for (var j = 0; j < $this.methods.length; j++) {
                        this.options2.push($this.methods[j].ID + '_' + $this.methods[j].AccountName);
                    }
                })
         
            axios.get('fetch_companyDetail')
                .then(response => this.companydetail = response.data)
            this.getResults();
        }
    }

</script>
