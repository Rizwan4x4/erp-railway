<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


Route::get('accounts/trial_balance_report/{start_date}/{end_date}','App\Http\Controllers\ReportsController@trial_balance_report');






Route::get('Accounts/Requisition_Letter/{id}/{rid}','App\Http\Controllers\ReportsController@req_letter');

// inventory statements reports 
Route::middleware(['permission:Inventory Account-Reports overall,Inventory Account-Reports inventory-statements'])->group(function () {
    Route::get('accounts/consumptionanalysis_report/{start_date}/{end_date}/{item}/{dept}/{proj}','App\Http\Controllers\ReportsController@consumptionanalysis_report');
    Route::get('accounts/item_averagecost_value/{item}','App\Http\Controllers\ReportsController@item_averagecost_value');
    Route::get('accounts/itemlist_report/{c_type}','App\Http\Controllers\Accounts\AccountsController@itemlist_report');
    Route::get('accounts/item_ageing_report/{start_date}/{end_date}/{item}','App\Http\Controllers\ReportsController@item_ageing_report');
    Route::get('accounts/issuance_receipt/{id}/{name}','App\Http\Controllers\Accounts\AccountsController@issuance_receipt');
    Route::get('accounts/received_receipt/{id}/{name}','App\Http\Controllers\Accounts\AccountsController@received_receipt');
    Route::get('accounts/asset_assignment_list','App\Http\Controllers\Accounts\AccountsController@asset_assignment_list');
    Route::get('accounts/fetch_product_category1','App\Http\Controllers\ReportsController@fetch_product_category1');
    Route::get('accounts/inventory_receipt_report/{startingdate}/{closingdate}/{dept}/{proj}','App\Http\Controllers\Accounts\AccountsController@inventory_receipt_report');
});
// inventory reports
Route::middleware(['permission:Inventory Account-Reports overall,Inventory Account-Reports inventory'])->group(function () {
    Route::get('Accounts/GRN_letter1/{vendor}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@grn_letter1');
    Route::get('getitems_issuance/{id}', 'App\Http\Controllers\Accounts\AccountsController@getitems_issuance');
    Route::get('getitems_issuanceReturn/{id}','App\Http\Controllers\Accounts\AccountsController@getitems_issuanceReturn');
    Route::get('Accounts/Issuance_return_report1/{dept}/{rid}/{proj}/{item}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@Issuance_return_report1');
    Route::get('Accounts/Issuance_report1/{dept}/{rid}/{proj}/{item}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@Issuance_report1');
    Route::get('accounts/Receiving_Data_report/{start_date}/{end_date}/{Dep_Name?}/{Pro_Name?}', 'App\Http\Controllers\Accounts\AccountsController@Receiving_Data_report');
    Route::get('accounts/Issuance_Data_report/{start_date}/{end_date}/{Dep_Name?}/{Pro_Name?}', 'App\Http\Controllers\Accounts\AccountsController@Issuance_Data_report');
    Route::get('vendor_report_detail', 'App\Http\Controllers\Accounts\AccountsController@vendor_report_detail');  //View vendors
    Route::get('issu_detail_report', 'App\Http\Controllers\Accounts\AccountsController@issu_detail_report');
}); 

// purchase reports 
Route::middleware(['permission:Inventory Account-Reports overall,Inventory Account-Reports purchase'])->group(function () {
    Route::get('Accounts/DemandRequisition_Letter1/{dept}/{rid}/{proj}/{item}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@DemandRequisition_Letter1');
    Route::get('Accounts/Requisition_Letter1/{dept}/{rid}/{proj}/{item}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@Requisition_Letter1');
    Route::get('Accounts/QuotationComparative_report1/{rid}/{item}/{vendor}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@QuotationComparative_report1');
    Route::get('Accounts/PO_letter1/{po_type}/{vendor}/{proj}/{dept}/{created_by}/{check}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@po_letter1');
    Route::get('Accounts/Pi_letter1/{vendor}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@pi_letter1');
    Route::get('Accounts/PR_letter1/{vendor}/{startingdate}/{enddate}','App\Http\Controllers\ReportsController@pr_letter1');
    Route::get('getitems_demandrequisition/{id}', 'App\Http\Controllers\Accounts\AccountsController@getitems_demandrequisition');
    Route::get('accounts/get_DemandReqTrackingReport/{RequisitionId}', 'App\Http\Controllers\Accounts\AccountsController@DemandReqTrackingReport');
    Route::get('getitems_requisition/{id}', 'App\Http\Controllers\Accounts\AccountsController@getitems_requisition');
    Route::get('/accounts/get_req_data3/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_req_data3');  //
    Route::get('/accounts/get_req_data_count/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_req_data_count');  //
Route::get('/accounts/get_req_data2/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_req_data2');
Route::get('getitems_quotation/{id}', 'App\Http\Controllers\Accounts\AccountsController@getitems_quotation');
Route::get('accounts/get_po_grn_detailreport/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_po_grn_detailreport');
Route::get('accounts_get_poProducts_count/{id}','App\Http\Controllers\Accounts\AccountsController@accounts_get_poProducts_count');
Route::get('accounts_get_poProducts1/{id}','App\Http\Controllers\Accounts\AccountsController@get_poProducts1');
Route::get('accounts/OpenPos_Data_report/{start_date}/{end_date}/{Dep_Name?}/{Pro_Name?}', 'App\Http\Controllers\Accounts\AccountsController@OpenPos_Data_report');
Route::get('accounts/advance_paid_po','App\Http\Controllers\Accounts\AccountsController@advance_paid_po');
Route::get('accounts/vendor_balance_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@vendor_balance_report');
Route::get('accounts/GIGBPP_Data_report/{start_date}/{end_date}/{Dep_Name?}/{Pro_Name?}','App\Http\Controllers\Accounts\AccountsController@GIGBPP_Data_report');
Route::get('accounts/get_requisition1', 'App\Http\Controllers\Accounts\AccountsController@get_requisition1');
Route::get('accounts/get_purchaseorder_createdlist','App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_createdlist');
Route::get('accounts/get_purchaseorder_id','App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_id');
});
// Sales Reports 
Route::middleware(['permission:Inventory Account-Reports overall,Inventory Account-Reports sales'])->group(function () {
    Route::get('accounts/cash_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@cash_report');
    Route::get('accounts/chq_superwise_detail/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@chq_superwise_detail');
    Route::get('accounts/debit_credit_superwisedetail/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@debit_credit_superwisedetail');
    Route::get('accounts/online_cash_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@online_cash_report');
    Route::get('units_booking_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@units_booking_report');
});
//  Accounting Reports 
Route::middleware(['permission:Inventory Account-Reports overall,Inventory Account-Reports accounting'])->group(function () {
    // Balance Sheet Report
Route::get('accounts/BalanceSheet_CurrentAssets/{start_date}/{end_date}','App\Http\Controllers\ReportsController@BalanceSheet_CurrentAssets');
Route::get('accounts/BalanceSheet_NonCurrentAssets/{start_date}/{end_date}','App\Http\Controllers\ReportsController@BalanceSheet_NonCurrentAssets');
Route::get('accounts/BalanceSheet_ShareCapitalandReserves/{start_date}/{end_date}','App\Http\Controllers\ReportsController@BalanceSheet_ShareCapitalandReserves');
Route::get('accounts/Balancesheet_TotalProfit/{start_date}/{end_date}','App\Http\Controllers\ReportsController@Balancesheet_TotalProfit');
Route::get('accounts/BalanceSheet_NonCurrentLiabiities/{start_date}/{end_date}','App\Http\Controllers\ReportsController@BalanceSheet_NonCurrentLiabiities');
Route::get('accounts/BalanceSheet_CurrentLiabiities/{start_date}/{end_date}','App\Http\Controllers\ReportsController@BalanceSheet_CurrentLiabiities');
Route::get('Accounts/deliverydetails_report/{tax}','App\Http\Controllers\Accounts\AccountsController@deliverydetails_report');

// ledger report 
Route::get('/accounts/ledger_report/{start_date}/{end_date}/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_report');
Route::get('/accounts/ledger_method_report_openingbalance/{start_date}/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_method_report_openingbalance');
// income state report 
Route::get('accounts/cost_orland_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@cost_orland_report');
Route::get('accounts/operatingland_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@operatingland_report');
Route::get('accounts/IncomeStatment_GrossProfit/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@IncomeStatment_GrossProfit');
Route::get('accounts/IncomeStatment_Taxation/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@IncomeStatment_Taxation');
// tax detail report 
Route::get('Accounts/taxdetails_report/{tax}','App\Http\Controllers\Accounts\AccountsController@taxdetails_report');

// trail balance 
Route::get('/accounts/trail_balance_report_sum/','App\Http\Controllers\Accounts\AccountsController@trail_balance_sum');
// ledger balance 
Route::get('/accounts/ledger_report_balance1/{start_date}/{end_date}/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_report_balance1');
Route::get('/accounts/ledger_report1/{start_date}/{end_date}/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_report1');
});




Route::get('Accounts/petty_Letter/{id}/{pid}','App\Http\Controllers\ReportsController@petty_Letter');

Route::get('Accounts/Quotation/{id}/{rid}','App\Http\Controllers\ReportsController@quotation_letter');

Route::middleware(['permission:Purchase Orders Actions'])->group(function () {

    Route::get('Accounts/PO_letter/{id}/{poid}', 'App\Http\Controllers\ReportsController@po_letter');
});

Route::get('Accounts/wordorder_letter/{id}/{poid}','App\Http\Controllers\ReportsController@wordorder_letter');
// Remember These routes also used in reports

//Services Invoice View


Route::middleware(['permission:GRN Actions'])->group(function () {

    Route::get('Accounts/Grn_letter/{id}/{grid}', 'App\Http\Controllers\ReportsController@grn_letter');
    Route::get('Accounts/pi_Letter/{id}/{roid}','App\Http\Controllers\ReportsController@pi_letter');

});
// this middleware used also in somewhere else
Route::middleware(['permission:Services Invoice Print'])->group(function () {
    Route::get('Accounts/pi_Letter9/{id}/{roid}', 'App\Http\Controllers\ReportsController@pi_letter9');
});
Route::get('Accounts/asset_assignletter/{id}','App\Http\Controllers\ReportsController@asset_assignletter');
Route::get('jv_letter/{jid}/{jvid}','App\Http\Controllers\ReportsController@jv_letter');
Route::get('payment_letter/{pid}/{pvid}','App\Http\Controllers\ReportsController@payment_letter1');
Route::get('received_letter/{rid}/{rvid}','App\Http\Controllers\ReportsController@received_letter');
Route::get('comparative_letter/{id}','App\Http\Controllers\ReportsController@comparative_letter');
Route::get('Accounts/issuance_letter/{id}/{grid}','App\Http\Controllers\ReportsController@issuance_letter');
Route::get('Accounts/serviceBill/{id}','App\Http\Controllers\ReportsController@service_bill');
Route::get('pettycash_access/{id}', 'App\Http\Controllers\ReportsController@pettycash_access');


Route::get('Accounts/unit_refunds_letter/{id}','App\Http\Controllers\ReportsController@unit_refunds_letter');
Route::get('Accounts/unit_refunds_amount_letter/{id}','App\Http\Controllers\ReportsController@unit_refunds_amount_letter');
Route::get('Accounts/issuance_return_letter/{id}/{grid}','App\Http\Controllers\ReportsController@issuance_return_letter');
//
Route::get('salary_detail_report','App\Http\Controllers\ReportsController@salary_detail_report');


Route::middleware(['permission:HRMS HR-Reports  Salary-&-Stipend-Reports'])->group(function () {
    Route::get('salary_detail_report1','App\Http\Controllers\ReportsController@salary_detail_report1');
    Route::get('salary_detail_deptreport','App\Http\Controllers\ReportsController@salary_detail_deptreport');
    Route::get('employee_stipend_report','App\Http\Controllers\ReportsController@employee_stipend_report');
    Route::get('salary_detail_deptsalaryreport','App\Http\Controllers\ReportsController@salary_detail_deptsalaryreport');
    Route::get('employee_stipend','App\Http\Controllers\ReportsController@employee_stipend');

});


Route::get('dept_salary_report','App\Http\Controllers\ReportsController@dept_salary_report');
Route::get('debit_note_letter/{id}','App\Http\Controllers\ReportsController@debit_note_letter');
Route::get('Accounts/land_paymentdetail_letter/{id}','App\Http\Controllers\ReportsController@land_paymentdetail_letter');
Route::get('Accounts/landpayment_pvletter/{id}','App\Http\Controllers\ReportsController@landpayment_pvletter');
Route::get('Accounts/Amount_repurchased_receipt_bill/{id}','App\Http\Controllers\ReportsController@Amount_repurchased_receipt_bill');
Route::get('Accounts/Cancelled_receipt_bill/{id}','App\Http\Controllers\ReportsController@Cancelled_receipt_bill');
Route::get('Accounts/Amount_refund_receipt_bill/{id}','App\Http\Controllers\ReportsController@Amount_refund_receipt_bill');
Route::get('Accounts/unit_repurchased_amount_letter/{id}','App\Http\Controllers\ReportsController@unit_repurchased_amount_letter');

