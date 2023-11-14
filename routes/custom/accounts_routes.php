<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


Route::post('update_accounts_configuration','App\Http\Controllers\Accounts\AccountsController@update_accounts_configuration');
Route::get('accounts/child_detail','App\Http\Controllers\Accounts\AccountsController@child_detail')->middleware('permission:Accounts Configurations  general');
Route::get('accounts/project_data','App\Http\Controllers\Accounts\AccountsController@project_data');
Route::get('accounts/fetch_company_config','App\Http\Controllers\Accounts\AccountsController@fetch_company_config')->middleware('permission:Accounts Configurations  general');
Route::post('accounts/submit_childcompany','App\Http\Controllers\Accounts\AccountsController@submit_childcompany');
Route::get('accounts/get_childcompany','App\Http\Controllers\Accounts\AccountsController@get_childcompany');
Route::get('accounts/get_childcompany1/{id}','App\Http\Controllers\Accounts\AccountsController@get_childcompany1');
Route::post('accounts/submit_project_child','App\Http\Controllers\Accounts\AccountsController@submit_project_child');
Route::post('accounts/submit_account_type','App\Http\Controllers\Accounts\AccountsController@submit_account_type');


Route::get('accounts/acc_types','App\Http\Controllers\Accounts\AccountsController@get_acc_types');
Route::get('accounts/acc_journal','App\Http\Controllers\Accounts\AccountsController@get_journal_heads')->middleware('permission:Accounts Configurations Accounts heads');
Route::post('accounts/submit_journal_head','App\Http\Controllers\Accounts\AccountsController@submit_journal_head');
Route::get('accounts/get_account_type','App\Http\Controllers\Accounts\AccountsController@get_account_type')->middleware('permission:Accounts Configurations COA,Accounts Configurations Accounts heads');
Route::get('accounts/get_coa_main_head/{account_type}','App\Http\Controllers\Accounts\AccountsController@get_coa_main_head');
Route::post('accounts/submit_chart_of_accounts','App\Http\Controllers\Accounts\AccountsController@submit_chart_of_accounts');
Route::post('accounts_submit_session','App\Http\Controllers\Accounts\AccountsController@submit_session');
Route::get('/accounts_session_detail', 'App\Http\Controllers\Accounts\AccountsController@session_detail');
Route::get('/accounts_delete_session/{id}', 'App\Http\Controllers\Accounts\AccountsController@delete_session');
Route::get('accounts/get_coa_sub_head/{main_head}','App\Http\Controllers\Accounts\AccountsController@get_coa_sub_head');
Route::get('/accounts/fetch_account_type/','App\Http\Controllers\Accounts\AccountsController@fetch_account_type')->middleware('permission:Accounts Configurations COA');
Route::get('/accounts/fetch_overall_coa/','App\Http\Controllers\Accounts\AccountsController@fetch_overall_coa');
Route::get('accounts/fetch_type_coa/{acc_type}','App\Http\Controllers\Accounts\AccountsController@fetch_type_coa');
Route::get('accounts/fetch_type_menu/{acc_type}','App\Http\Controllers\Accounts\AccountsController@fetch_type_menu');
Route::get('accounts/fetch_journal_data/{journal_id}','App\Http\Controllers\Accounts\AccountsController@fetch_journal_data');
Route::get('accounts/get_coa_sub_head2/{sub_head2}','App\Http\Controllers\Accounts\AccountsController@get_coa_sub_head2');
Route::get('accounts/get_coa_sub_head3/{sub_head3}','App\Http\Controllers\Accounts\AccountsController@get_coa_sub_head3');
Route::get('accounts/dept_data','App\Http\Controllers\Accounts\AccountsController@dept_data');
Route::get('accounts/dept_data1','App\Http\Controllers\Accounts\AccountsController@dept_data1')->middleware('permission:Accounts Configurations  general');
Route::post('accounts/submit_departments','App\Http\Controllers\Accounts\AccountsController@submit_departments');
Route::get('/accounts/filter_bank/','App\Http\Controllers\Accounts\AccountsController@filter_bank');
Route::get('/accounts/delivery_detail/', 'App\Http\Controllers\Accounts\AccountsController@delivery_detail')->middleware('permission:Accounting procurement-configuration Delivery');
Route::post('accounts/submit_delivery', 'App\Http\Controllers\Accounts\AccountsController@submit_delivery');
Route::get('/accounts/filter_delivery/','App\Http\Controllers\Accounts\AccountsController@filter_delivery');
Route::post('accounts/accounts_update_delivery_status', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_delivery_status');
Route::post('accounts/accounts_update_bank_status', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_bank_status');



Route::get('accounts/incomestatement_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@incomestatement_report');

Route::get('/accounts/sales_detail/','App\Http\Controllers\Accounts\AccountsController@sales_detail');
Route::get('accounts/balances_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@balances_report');




Route::get('get_linkprojects','App\Http\Controllers\Accounts\AccountsController@get_linkprojects');
Route::get('accounts/pr_detailreport','App\Http\Controllers\Accounts\AccountsController@pr_detailreport');

Route::get('accounts/fetch_receivable_head','App\Http\Controllers\Accounts\AccountsController@fetch_receivable_head');

Route::get('accounts/fetch_all_transaction_head','App\Http\Controllers\Accounts\AccountsController@fetch_all_transaction_head');

Route::get('accounts/payment_detail','App\Http\Controllers\Accounts\AccountsController@payment_detail');

Route::get('accounts/fetch_methods','App\Http\Controllers\Accounts\AccountsController@fetch_methods');
Route::get('accounts/get_services','App\Http\Controllers\Accounts\AccountsController@get_services');
Route::get('accounts/advance_paid_po','App\Http\Controllers\Accounts\AccountsController@advance_paid_po');
Route::get('units_ageing_blocks', 'App\Http\Controllers\Accounts\AccountsController@units_ageing_blocks');
Route::get('get_units_ageing_payables_receivables_report/{module}/{block}/{year}/{month}', 'App\Http\Controllers\Accounts\AccountsController@get_units_ageing_payables_receivables_report');



//Receipt Voucher

Route::get('filter_bank_name/{name}','App\Http\Controllers\Accounts\AccountsController@filter_bank_name')->middleware('permission:Accounting Receipt-voucher pdc');
Route::get('accounts/getsinglepdcreceivable/{id}','App\Http\Controllers\Accounts\AccountsController@getsinglepdcreceivable')->middleware('permission:Accounting Receipt-voucher pdc');
Route::post('submit_pdcreceivedclearancedetails','App\Http\Controllers\Accounts\AccountsController@submit_pdcreceivedclearancedetails')->middleware('permission:Accounting Receipt-voucher pdc');
Route::get('accounts/received_detail','App\Http\Controllers\Accounts\AccountsController@received_detail')->middleware('permission:Accounting Receipt-voucher overall-view');
Route::get('search_receivedvoucher/{datefrom}/{dateto}','App\Http\Controllers\Accounts\AccountsController@search_receivedvoucher')->middleware('permission:Accounting Receipt-voucher filter');
Route::get('accounts/received_vouchername/{name}','App\Http\Controllers\Accounts\AccountsController@received_vouchername')->middleware('permission:Accounting Receipt-voucher filter');
Route::get('/accounts_get_RV/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_rcv_vchr')->middleware('permission:Accounting Receipt-voucher overall-view');
Route::post('accounts/submit_received_voucher','App\Http\Controllers\Accounts\AccountsController@submit_received_voucher')->middleware('permission:Accounting Receipt-voucher create-rv');
Route::get('accounts/fetch_receivable_head1','App\Http\Controllers\Accounts\AccountsController@fetch_receivable_head1')->middleware('permission:Accounting Receipt-voucher overall-view');
Route::get('accounts/get_pdcreceivable_detail','App\Http\Controllers\Accounts\AccountsController@get_pdcreceivable_detail')->middleware('permission:Accounting Receipt-voucher pdc');
Route::get('accounts/fetch_pi_detail/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_pi_detail')->middleware('permission:Accounting Receipt-voucher overall-view,Accounting Payment-voucher overall-view,Accounting debit-notes overall-view');
Route::get('accounts/fetch_po_detail1/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_po_detail1')->middleware('permission:Accounting Receipt-voucher overall-view');
Route::get('accounts/fetch_po_details/{id}','App\Http\Controllers\Accounts\AccountsController@fetch_po_details')->middleware('permission:Accounting Receipt-voucher overall-view,Accounting Payment-voucher overall-view,Accounting debit-notes overall-view');
Route::get('accounts/fetch_po_details1/{id}','App\Http\Controllers\Accounts\AccountsController@fetch_po_details1')->middleware('permission:Accounting Receipt-voucher overall-view');
Route::get('accounts/fetch_po_value/{id}/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_po_value')->middleware('permission:Accounting Receipt-voucher overall-view,Accounting Payment-voucher overall-view,Accounting debit-notes overall-view');
Route::get('/accounts/ledger_method_report_balance/{start_date}/{end_date}/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_report_balance')->middleware('permission:Accounting Receipt-voucher overall-view,Accounting Payment-voucher overall-view');
//Jurnal Voucher
Route::post('accounts/insert_jv','App\Http\Controllers\Accounts\JVController@insert_jv')->middleware('permission:Accounting journal_voucher create-jv');    
Route::get('accounts/jv_detail','App\Http\Controllers\Accounts\JVController@jv_detail')->middleware('permission:Accounting journal_voucher overall-view');    
Route::get('search_journals', 'App\Http\Controllers\Accounts\JVController@search_journals')->middleware('permission:Accounting journal_voucher filter');  
Route::get('accounts/jv_searchbyfilter/{sts}', 'App\Http\Controllers\Accounts\JVController@jv_searchbyfilter')->middleware('permission:Accounting journal_voucher filter');  
Route::get('accounts/jv_searchdate/{datefrom}/{dateto}','App\Http\Controllers\Accounts\JVController@jv_searchdate')->middleware('permission:Accounting journal_voucher filter');  
Route::get('/accounts_get_JVdetail/{id}', 'App\Http\Controllers\Accounts\JVController@get_JV_detail')->middleware('permission:Accounting journal_voucher overall-view');
Route::get('/accounts_get_JurVchr/{id}', 'App\Http\Controllers\Accounts\JVController@get_jurnal_vchr')->middleware('permission:Accounting journal_voucher overall-view');
Route::post('accounts/update_jv','App\Http\Controllers\Accounts\JVController@update_jvStatus')->middleware('permission:Accounting journal_voucher edit-jv');
Route::post('accounts/edit_jv','App\Http\Controllers\Accounts\JVController@edit_jv')->middleware('permission:Accounting journal_voucher edit-jv');

//Payment Voucher
Route::middleware(['permission:Accounting Payment-voucher overall-view,Accounting debit-notes overall-view'])->group(function () {

    Route::get('accounts/fetch_payable_head','App\Http\Controllers\Accounts\AccountsController@fetch_payable_head');

});

Route::post('/accounts/update_pdc_chq_detail/','App\Http\Controllers\Accounts\AccountsController@update_pdc_chq_detail')->middleware('permission:Accounting Payment-voucher pdc');
Route::get('accounts/search_generalfilter','App\Http\Controllers\Accounts\AccountsController@search_generalfilter')->middleware('permission:Accounting Payment-voucher pdc');
Route::get('accounts/getsinglepdcpayable/{id}','App\Http\Controllers\Accounts\AccountsController@getsinglepdcpayable')->middleware('permission:Accounting Payment-voucher pdc');
Route::post('submit_pdcclearancedetails','App\Http\Controllers\Accounts\AccountsController@submit_pdcclearancedetails')->middleware('permission:Accounting Payment-voucher pdc');
Route::get('accounts/searchpdcdate/{startingdate}/{closingdate}','App\Http\Controllers\Accounts\AccountsController@searchpdcdate')->middleware('permission:Accounting Payment-voucher pdc');
Route::get('accounts/get_pdcpayable_detail','App\Http\Controllers\Accounts\AccountsController@get_pdcpayable_detail')->middleware('permission:Accounting Payment-voucher pdc');
Route::get('accounts/fetch_payable_tax_head','App\Http\Controllers\Accounts\AccountsController@fetch_payable_tax_head')->middleware('permission:Accounting Payment-voucher overall-view');
Route::get('accounts/fetch_pi_detailpv/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_pi_detailpv')->middleware('permission:Accounting Payment-voucher overall-view');
Route::get('accounts/fetch_journals_detail/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_journals_detail')->middleware('permission:Accounting Payment-voucher overall-view');
Route::get('accounts/fetch_rcvd_details/{id}','App\Http\Controllers\Accounts\AccountsController@fetch_rcvd_details')->middleware('permission:Accounting Payment-voucher overall-view');
Route::post('accounts/submit_payment_voucher','App\Http\Controllers\Accounts\AccountsController@submit_payment_voucher')->middleware('permission:Accounting Payment-voucher create-pv');
Route::get('accounts/paymentsearch_number/{against}','App\Http\Controllers\Accounts\AccountsController@paymentsearch_number')->middleware('permission:Accounting Payment-voucher filter');
Route::get('accounts/paymentsearch_name/{against}','App\Http\Controllers\Accounts\AccountsController@paymentsearch_name')->middleware('permission:Accounting Payment-voucher filter');
Route::get('accounts/search_payment_date/{from}/{to}','App\Http\Controllers\Accounts\AccountsController@search_payment_date')->middleware('permission:Accounting Payment-voucher filter');
Route::get('/accounts_get_PayVchr/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_payment_vchr')->middleware('permission:Accounting Payment-voucher overall-view');
//

//Debit Notes
Route::get('accounts/fetch_pi_taxbycode/{poid}','App\Http\Controllers\Accounts\AccountsController@fetch_pi_taxbycode')->middleware('permission:Accounting debit-notes filter');
Route::get('accounts/fetch_pi_itemsbycode/{poid}','App\Http\Controllers\Accounts\AccountsController@fetch_pi_itemsbycode')->middleware('permission:Accounting debit-notes filter');
Route::post('submit_debit_notes', 'App\Http\Controllers\Accounts\AccountsController@submit_debit_notes')->middleware('permission:Accounting debit-notes create-dn');
Route::get('debit_not_detail', 'App\Http\Controllers\Accounts\AccountsController@debit_not_detail')->middleware('permission:Accounting debit-notes overall-view');
Route::get('search_debit_notes', 'App\Http\Controllers\Accounts\AccountsController@search_debit_notes')->middleware('permission:Accounting debit-notes filter');
Route::get('single_debit_notes/{id}', 'App\Http\Controllers\Accounts\AccountsController@single_debit_notes')->middleware('permission:Accounting debit-notes filter');
Route::get('single_debit_notesitems/{id}', 'App\Http\Controllers\Accounts\AccountsController@single_debit_notesitems')->middleware('permission:Accounting debit-notes filter');

// Petty Cash Access
Route::get('accounts/fetch_pettycash_head','App\Http\Controllers\Accounts\AccountsController@fetch_pettycash_head')->middleware('permission:Accounting pettycash_access overall-view');
Route::get('/accounts/pcash_access_detail/', 'App\Http\Controllers\Accounts\AccountsController@pcash_access_detail')->middleware('permission:Accounting pettycash_access overall-view');
Route::post('accounts/submit_pettyCash', 'App\Http\Controllers\Accounts\AccountsController@submit_pettycash')->middleware('permission:Accounting pettycash_access create-pettyaccess');
Route::get('/accounts/filter_pcash_access/','App\Http\Controllers\Accounts\AccountsController@filter_pcash_access')->middleware('permission:Accounting pettycash_access filter');
Route::get('accounts_employee_name/{emp_code}','App\Http\Controllers\Accounts\AccountsController@emp_name')->middleware('permission:Accounting pettycash_access filter');
Route::post('accounts/submit_linkcoa_pcash','App\Http\Controllers\Accounts\AccountsController@submit_linkcoa_pcash')->middleware('permission:Accounting pettycash_access edit-pettyaccess');
Route::get('accounts/submit_paid_cash/{id}/{amount}','App\Http\Controllers\Accounts\AccountsController@submit_paid_cash')->middleware('permission:Accounting pettycash_access edit-pettyaccess','Petty-Cash');
Route::get('accounts/get_petty_access/{id}','App\Http\Controllers\Accounts\AccountsController@get_petty_access')->middleware('permission:Accounting pettycash_access overall-view','Petty-Cash');


//Petty Cash
Route::post('accounts/insert_pettycash','App\Http\Controllers\Accounts\AccountsController@insert_pettycash')->middleware('permission:Accounting petty-cash create-pettycash');
Route::get('accounts/pettyitem_details/{id}','App\Http\Controllers\Accounts\AccountsController@pettyitem_details')->middleware('permission:Accounting petty-cash filter');
Route::get('accounts/pettyitem_details1/{id}','App\Http\Controllers\Accounts\AccountsController@pettyitem_details1')->middleware('permission:Accounting petty-cash filter');
Route::get('accounts/update_pettycash_status/{id}/{status}','App\Http\Controllers\Accounts\AccountsController@update_pettycash_status')->middleware('permission:Accounting petty-cash edit-pettycash');
Route::get('accounts/update_pettycash_status1/{id}/{status}','App\Http\Controllers\Accounts\AccountsController@update_pettycash_status1')->middleware('permission:Accounting petty-cash edit-pettycash');
Route::get('searchpetty_cash/{startdate}/{enddate}/{keyword}','App\Http\Controllers\Accounts\AccountsController@searchpetty_cash')->middleware('permission:Accounting petty-cash filter');
Route::get('accounts/petty_cash_details','App\Http\Controllers\Accounts\AccountsController@petty_cash_details')->middleware('permission:Accounting petty-cash overall-view');
Route::post('accounts/submit_paid_cash1','App\Http\Controllers\Accounts\AccountsController@submit_paid_cash1')->middleware('permission:Accounting petty-cash create-pettycash');
Route::get('accounts/get_petty_access1/{id}','App\Http\Controllers\Accounts\AccountsController@get_petty_access1')->middleware('permission:Accounting petty-cash overall-view');
Route::get('Accounts/petty_Cash_bill/{id}/{pid}','App\Http\Controllers\Accounts\AccountsController@petty_Cash_bill')->middleware('permission:Accounting petty-cash overall-view');
Route::post('accounts/edit_pettycash','App\Http\Controllers\Accounts\AccountsController@edit_pettycash')->middleware('permission:Accounting petty-cash edit-pettycash');


Route::get('account_stock_counter','App\Http\Controllers\Accounts\AccountsController@count_stock');
Route::get('account_stock_counter1','App\Http\Controllers\Accounts\AccountsController@count_stock1');
//Route::get('account_stock_available','App\Http\Controllers\Accounts\AccountsController@count_available');
Route::get('stock_sum','App\Http\Controllers\Accounts\AccountsController@stock_sum')->middleware('permission:Accounts Dashboard overall-view');
Route::get('/accounts_AccType/','App\Http\Controllers\Accounts\AccountsController@accType_byName');
Route::get('/accounts_AJurHead/','App\Http\Controllers\Accounts\AccountsController@jurHead_byName');
Route::get('/accounts_sessionByName/','App\Http\Controllers\Accounts\AccountsController@session_byName');

Route::post('/accounts_update_purchaseorder','App\Http\Controllers\Accounts\AccountsController@update_purchaseorder');
Route::post('accounts/insert_purchase_return','App\Http\Controllers\Accounts\AccountsController@insert_purchase_return');
Route::get('/accounts_customer_byname/','App\Http\Controllers\Accounts\AccountsController@customer_byname');
Route::post('accounts_add_customer','App\Http\Controllers\Accounts\AccountsController@add_customer'); //Add customer
Route::get('/accounts_customer_detail', 'App\Http\Controllers\Accounts\AccountsController@customer_detail');  //View customer
Route::get('accounts_fetch_customer/{id}', 'App\Http\Controllers\Accounts\AccountsController@fetch_customer');  //fetch customer
Route::post('accounts_update_customer', 'App\Http\Controllers\Accounts\AccountsController@update_customer');  //update customer
Route::post('accounts_update_cusSts', 'App\Http\Controllers\Accounts\AccountsController@update_cusSts');  //update customer status
Route::post('accounts/insert_saleinvoice', 'App\Http\Controllers\Accounts\AccountsController@insert_saleinvoice');
Route::get('accounts/get_customers','App\Http\Controllers\Accounts\AccountsController@get_customers');

Route::post('accounts/submit_bank', 'App\Http\Controllers\Accounts\AccountsController@submit_bank');
Route::get('accounts/pvid', 'App\Http\Controllers\Accounts\AccountsController@pvid');

Route::get('/accounts/bank_detail/', 'App\Http\Controllers\Accounts\AccountsController@bank_detail')->middleware('permission:Accounts Configurations bank-detail'); 
Route::get('/accounts/fetch_dashboard_data/', 'App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_data');
Route::get('accounts/get_department_name', 'App\Http\Controllers\Accounts\AccountsController@get_department_name')->middleware('permission:Procurement Dashboard overall-view'); 

Route::get('accounts/get_purchaseReport_vendor', 'App\Http\Controllers\Accounts\AccountsController@get_purchaseReport_vendor')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('accounts/get_purchaseReport_ItemCategory', 'App\Http\Controllers\Accounts\AccountsController@get_purchaseReport_ItemCategory')->middleware('permission:Procurement Dashboard overall-view'); 



Route::get('/accounts/get_purchase_value_department', 'App\Http\Controllers\Accounts\AccountsController@get_purchase_value_department')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('/accounts/get_Issuance_value_project', 'App\Http\Controllers\Accounts\AccountsController@get_Issuance_value_project')->middleware('permission:Accounts Dashboard overall-view'); 



Route::get('accounts/procurement_cycle_supplier','App\Http\Controllers\Accounts\AccountsController@procurement_cycle_supplier')->middleware('permission:Procurement Dashboard overall-view'); 


Route::get('ledger_get_general/{datefrom}/{dateto}/{vendor}', 'App\Http\Controllers\Accounts\AccountsController@ledger_get_general');
Route::get('get_all_general_ledger', 'App\Http\Controllers\Accounts\AccountsController@get_all_general');
Route::post('download_excel', 'App\Http\Controllers\Accounts\AccountsController@exportExcel');

Route::get('accounts/search_assetsbyuniqueid','App\Http\Controllers\Accounts\AccountsController@search_assetsbyuniqueid');
Route::post('accounts/submit_unitsam','App\Http\Controllers\Accounts\AccountsController@submit_unitsam');
Route::get('/accounts/ledger_method_report_balance2/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_report_balance2');
//dashboard
Route::get('adddayin_date', 'App\Http\Controllers\Accounts\AccountsController@adddayin_date');
Route::get('/accounts/get_sum_accounts_data', 'App\Http\Controllers\Accounts\AccountsController@get_sum_accounts_data')->middleware('permission:Accounts Dashboard overall-view'); 







Route::get('Accounts/fetch_dashboard_customers','App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_customers')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view');
Route::get('Accounts/fetch_dashboard_vendors','App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_vendors')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view'); 
Route::get('Accounts/get_d_purchase','App\Http\Controllers\Accounts\AccountsController@get_d_purchase')->middleware('permission:Accounts Dashboard overall-view');
Route::get('Accounts/get_d_sale/','App\Http\Controllers\Accounts\AccountsController@get_d_sale')->middleware('permission:Accounts Dashboard overall-view');
Route::get('Accounts/get_d_payment/','App\Http\Controllers\Accounts\AccountsController@get_d_payment')->middleware('permission:Accounts Dashboard overall-view');
Route::get('Accounts/get_d_received/','App\Http\Controllers\Accounts\AccountsController@get_d_received')->middleware('permission:Accounts Dashboard overall-view');
Route::get('Accounts/get_d_jv/','App\Http\Controllers\Accounts\AccountsController@get_d_jv')->middleware('permission:Accounts Dashboard overall-view');
Route::get('Accounts/count_sales_d/','App\Http\Controllers\Accounts\AccountsController@count_sales_d')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view');
Route::get('Accounts/count_purchase_d','App\Http\Controllers\Accounts\AccountsController@count_purchase_d')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view'); 
Route::get('Accounts/count_revenue_d/','App\Http\Controllers\Accounts\AccountsController@count_revenue_d')->middleware('permission:Accounts Dashboard overall-view');
Route::get('Accounts/count_expense_d/','App\Http\Controllers\Accounts\AccountsController@count_expense_d')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view'); 
Route::get('Accounts/count_stock_d/','App\Http\Controllers\Accounts\AccountsController@count_stock_d');
Route::get('accounts/searchcoa_name/{name}', 'App\Http\Controllers\Accounts\AccountsController@searchcoa_name');

Route::get('accounts/count_po_amt_d','App\Http\Controllers\Accounts\AccountsController@count_po_amt_d')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view'); 

Route::get('accounts/search_invoicedata/{startingdate}/{closingdate}','App\Http\Controllers\Accounts\AccountsController@search_invoicedata');
Route::get('accounts/get_vendorinvoice/{vendor}','App\Http\Controllers\Accounts\AccountsController@get_vendorinvoice');
Route::get('accounts/get_invoicedata/{id}','App\Http\Controllers\Accounts\AccountsController@get_invoicedata');
Route::get('accounts/get_invoicedata_detail/{id}','App\Http\Controllers\Accounts\AccountsController@get_invoicedata_detail');
Route::post('accounts/post_salereturn','App\Http\Controllers\Accounts\AccountsController@post_salereturn');
Route::get('accounts_get_saleinvoice','App\Http\Controllers\Accounts\AccountsController@get_saleinvoice');
Route::get('/accounts/get_saleinvoice_detail/{siid}','App\Http\Controllers\Accounts\AccountsController@get_saleinvoice_detail');
Route::get('/accounts/get_saleinvoice_detail1/{siid}','App\Http\Controllers\Accounts\AccountsController@get_saleinvoice_detail1');
Route::get('/accounts/get_salecustomer','App\Http\Controllers\Accounts\AccountsController@get_salecustomer');
Route::get('/accounts/get_customer_detail/{name}','App\Http\Controllers\Accounts\AccountsController@get_customer_detail');
Route::get('accounts/get_quotationdetails/{id}','App\Http\Controllers\Accounts\AccountsController@get_quotationdetails');
Route::get('accounts/get_quotationdetails1/{id}','App\Http\Controllers\Accounts\AccountsController@get_quotationdetails1');
Route::post('accounts_insert_salequot', 'App\Http\Controllers\Accounts\AccountsController@insert_squotation');//insert
Route::get('/accounts_salequot_detail/','App\Http\Controllers\Accounts\AccountsController@squotation_detail');
Route::get('/accounts_squotation_byname/','App\Http\Controllers\Accounts\AccountsController@squotation_byname');
Route::get('accounts/get_sales_return','App\Http\Controllers\Accounts\AccountsController@get_sale_returns');
Route::get('/accounts_get_sr_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_sr_data');
Route::get('accounts_get_srProducts/{id}','App\Http\Controllers\Accounts\AccountsController@get_srProducts');
Route::get('accounts/fetch_asset/{id}','App\Http\Controllers\Accounts\AccountsController@fetch_asset');


//reports components


Route::get('/accounts/ledger_report_balance/{start_date}/{end_date}/{head_name}','App\Http\Controllers\Accounts\AccountsController@ledger_report_balance');
Route::get('/accounts/trail_balance_report/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@trail_balance');



//accounts
Route::get('accounts/get_PO_Grndetail','App\Http\Controllers\Accounts\AccountsController@get_PO_Grndetail');
Route::get('accounts/get_PO_servicesdetail','App\Http\Controllers\Accounts\AccountsController@get_PO_servicesdetail');
Route::get('/accounts/get_purchaseorder_detailgrn/{poid}','App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_detailgrn');
Route::get('/accounts/get_purchaseorder_detail1grn/{poid}','App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_detail1grn');

Route::get('accounts/po_data','App\Http\Controllers\Accounts\AccountsController@po_data');
Route::post('accounts/close_po','App\Http\Controllers\Accounts\AccountsController@close_po');
Route::get('get_currency','App\Http\Controllers\Accounts\AccountsController@get_currency');
Route::get('accounts/fetch_po_detail/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_po_detail');


Route::get('accounts/fetch_pi_detail9/{vendor}','App\Http\Controllers\Accounts\AccountsController@fetch_pi_detail9');

Route::post('accounts/submit_project_child1','App\Http\Controllers\Accounts\AccountsController@submit_project_child1');
Route::get('accounts/fetch_coaproject/','App\Http\Controllers\Accounts\AccountsController@fetch_coaproject')->middleware('permission:Accounts Configurations  general');
Route::get('accounts/searchcoa/{id}','App\Http\Controllers\Accounts\AccountsController@searchcoa');
Route::get('accounts/get_linkaccount/{id}','App\Http\Controllers\Accounts\AccountsController@get_linkaccount');
Route::get('accounts/fetch_expense_head','App\Http\Controllers\Accounts\AccountsController@fetch_expense_head');
Route::post('accounts/submit_linkcoaproject','App\Http\Controllers\Accounts\AccountsController@submit_linkcoaproject');



Route::get('accounts/get_departmentdetail1/{id}','App\Http\Controllers\Accounts\AccountsController@get_departmentdetail1');
Route::get('accounts/get_projects9/','App\Http\Controllers\Accounts\AccountsController@get_projects9');
Route::get('accounts/get_projects99/{id}','App\Http\Controllers\Accounts\AccountsController@get_projects99');
Route::get('accounts/get_departmentcoa/{id}','App\Http\Controllers\Accounts\AccountsController@get_departmentcoa');
//Route::get('accounts/fetch_inventorydata/','App\Http\Controllers\Accounts\AccountsController@fetch_inventorydata');





Route::get('accounts/get_itemsassets/{id}','App\Http\Controllers\Accounts\AccountsController@get_itemsassets');


// Products Routes
Route::middleware(['permission:Inventory Products create-product'])->group(function () {
Route::get('accounts/fetch_assets_head','App\Http\Controllers\Accounts\AccountsController@fetch_assets_head');
Route::post('accounts/submit_product', 'App\Http\Controllers\Accounts\AccountsController@submit_product');

});
Route::middleware(['permission:Inventory Products edit-product'])->group(function () {
    Route::post('accounts_update_product', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_product');  //update product
    Route::post('accounts_update_proSts', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_proSts');  //update product status
    Route::get('accounts_fetch_products/{id}', 'App\Http\Controllers\Accounts\AccountsController@fetch_product');  //fetch product to update
    Route::get('accounts_category_products/{id}','App\Http\Controllers\Accounts\AccountsController@accounts_category_products');
});
Route::middleware(['permission:Inventory Products inventory-link'])->group(function () {
    Route::get('accounts/fetch_itemlist','App\Http\Controllers\Accounts\AccountsController@fetch_itemlist');
    Route::post('accounts/submit_inventorylink','App\Http\Controllers\Accounts\AccountsController@submit_inventorylink');
    Route::get('accounts/get_itemsdetail1/{id}','App\Http\Controllers\Accounts\AccountsController@get_itemsdetail1');
    Route::get('/search_inv/','App\Http\Controllers\Accounts\AccountsController@search_inv');
    Route::post('accounts/submit_sepinventorylink','App\Http\Controllers\Accounts\AccountsController@submit_sepinventorylink');
});
Route::middleware(['permission:Inventory Products readOnly'])->group(function () {
    Route::get('/accounts_products_byname/', 'App\Http\Controllers\Accounts\AccountsController@accounts_products_byname');
});
Route::middleware(['permission:Inventory Products create-product,Inventory Products inventory-link'])->group(function () {
    Route::get('accounts/fetch_inventory_head','App\Http\Controllers\Accounts\AccountsController@fetch_inventory_head');
});
Route::middleware(['permission:Inventory Products asset-link'])->group(function () {
Route::get('accounts/fetch_assetlist','App\Http\Controllers\Accounts\AccountsController@fetch_assetlist');
Route::get('accounts/fetch_assetsdata/','App\Http\Controllers\Accounts\AccountsController@fetch_assetsdata');
Route::post('accounts/submit_assetslink','App\Http\Controllers\Accounts\AccountsController@submit_assetslink');
});


// Product Category
Route::middleware(['permission:Inventory Product-Categories readyOnly'])->group(function () {
Route::get('/accounts_catByName/','App\Http\Controllers\Accounts\AccountsController@catagory_byName');
Route::get('accounts/fetch_product_category', 'App\Http\Controllers\Accounts\AccountsController@fetch_product_category');
});
Route::middleware(['permission:Inventory Product-Categories create-category'])->group(function () {
    Route::post('accounts/submit_category', 'App\Http\Controllers\Accounts\AccountsController@submit_category');
});

// Assets
Route::middleware(['permission:Inventory Assets readyOnly'])->group(function () {
Route::get('accounts/assets_retirement_security/{id}', 'App\Http\Controllers\Accounts\AccountsController@assets_retirement_security');
Route::get('accounts/assets_depreciation_security/{id}', 'App\Http\Controllers\Accounts\AccountsController@assets_depreciation_security');
Route::get('accounts/getindassets/{id}','App\Http\Controllers\Accounts\AccountsController@getindassets');

});
Route::middleware(['permission:Inventory Assets actions'])->group(function () {
    Route::post('Accounts/assign_asset', 'App\Http\Controllers\Accounts\AccountsController@assign_asset');
    Route::post('Accounts/return_asset', 'App\Http\Controllers\Accounts\AccountsController@return_asset');
    Route::post('Accounts/update_asset', 'App\Http\Controllers\Accounts\AccountsController@update_asset');
});


Route::post('accounts/update_pv','App\Http\Controllers\Accounts\AccountsController@update_pv');
Route::post('submit_payment_term','App\Http\Controllers\Accounts\AccountsController@submit_payment_term');
Route::get('/account_payment_terms','App\Http\Controllers\Accounts\AccountsController@payment_terms')->middleware('permission:Accounts Configurations payment terms');
Route::get('accounts/stock_detailtotal','App\Http\Controllers\Accounts\AccountsController@stock_detailtotal');
//Route::get('Accounts/fetch_depart_access','App\Http\Controllers\Accounts\AccountsController@fetch_depart_access');
Route::get('Accounts/fetch_useremail','App\Http\Controllers\Accounts\AccountsController@fetch_useremail')->middleware('permission:Accounts Configurations  department access');
Route::post('accounts/submit_userdepartment','App\Http\Controllers\Accounts\AccountsController@submit_userdepartment');
Route::get('accounts/get_coaProjects','App\Http\Controllers\Accounts\AccountsController@get_coa_projects');





Route::get('accounts/all_acc_types','App\Http\Controllers\Accounts\AccountsController@all_acc_types');
Route::get('accounts/chartof_Accounts/{c_type}','App\Http\Controllers\Accounts\AccountsController@chartof_Accounts');


Route::get('accounts/sum_ledger/{ledger_name}/{start}/{close}','App\Http\Controllers\Accounts\AccountsController@sum_ledger');
Route::get('accounts/get_session_date','App\Http\Controllers\Accounts\AccountsController@get_session_date');

Route::middleware(['permission:Purchase Orders Create,Purchase Requisition Goods Quotation,Purchase Requisition View Assets Item Quotation'])->group(function () {

    Route::get('/accounts/get_pmterm/', 'App\Http\Controllers\Accounts\AccountsController@get_pmterm');

});






Route::get('accounts/fetch_journal_data_assets/{journal_id}','App\Http\Controllers\Accounts\AccountsController@fetch_journal_data_assets');
Route::get('accounts/fetch_journal_data_assets_unique/{journal_id}','App\Http\Controllers\Accounts\AccountsController@fetch_journal_data_assets_unique');

Route::get('accounts/fetch_bank_methods','App\Http\Controllers\Accounts\AccountsController@fetch_bank_methods');

Route::get('accounts/get_item_det/{id}','App\Http\Controllers\Accounts\AccountsController@get_item_det');


Route::middleware(['permission:Inventory StockDetail overall-view,Inventory StockDetail stock-adjustment,'])->group(function () {
Route::get('/search_item/','App\Http\Controllers\Accounts\AccountsController@search_item');
});







Route::post('accounts/insert_servicebill','App\Http\Controllers\Accounts\AccountsController@insert_servicebill');
Route::get('accounts/get_serviceBill','App\Http\Controllers\Accounts\AccountsController@get_serviceBill');

// units data fetching 
Route::middleware(['permission:Units-Management units-data fetch-data'])->group(function () {
    //test shifting data
Route::get('Accounts/update_receipt_data/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@receipt_Mis_to_sa_app');
Route::get('Accounts/Booking_Mis_to_sa_app/{start_date}/{end_date}','App\Http\Controllers\Accounts\AccountsController@Booking_Mis_to_sa_app');
Route::get('Accounts/Booking_services_Mis_to_sa_app/{start_date}','App\Http\Controllers\Accounts\AccountsController@Booking_services_Mis_to_sa_app');
    Route::get('Accounts/Booking_electricity_Mis_to_sa_app/{start_date}','App\Http\Controllers\Accounts\AccountsController@Booking_electricity_Mis_to_sa_app');
});


// units data permissions 
Route::middleware(['permission:Units-Management units-data readOnly'])->group(function () {
    Route::post('land_add_seller', 'App\Http\Controllers\Accounts\AccountsController@land_add_seller');
Route::get('accounts_seller_detail', 'App\Http\Controllers\Accounts\AccountsController@accounts_seller_detail');
Route::get('accounts_fetch_seller/{id}', 'App\Http\Controllers\Accounts\AccountsController@fetch_seller');
Route::get('/accounts/get_seller/','App\Http\Controllers\Accounts\AccountsController@get_seller');
Route::post('accounts/insert_land_information', 'App\Http\Controllers\Accounts\AccountsController@insert_land_information');
Route::get('/accounts/land_detail/','App\Http\Controllers\Accounts\AccountsController@land_detail');
Route::post('accounts/check_land_total_amount', 'App\Http\Controllers\Accounts\AccountsController@check_land_total_amount');
Route::get('accounts/get_land_installment/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_land_installment');
Route::get('accounts/get_landinformation_area_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_landinformation_area_data');
Route::get('accounts/get_landinformation_installment_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_landinformation_installment_data');
Route::get('accounts/get_landinformation_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_landinformation_data');
Route::post('accounts/update_land_information', 'App\Http\Controllers\Accounts\AccountsController@update_land_information');
Route::post('accounts/submit_paid_landpayment', 'App\Http\Controllers\Accounts\AccountsController@submit_paid_landpayment');
    Route::get('accounts/pending_services_detail','App\Http\Controllers\Accounts\AccountsController@pending_services_detail');
    Route::get('accounts/search_units_cash_date/{startingdate}/{closingdate}/{type}/{user}','App\Http\Controllers\Accounts\AccountsController@search_units_cash_date');
    Route::get('accounts/get_counter_sum_datewise/{startingdate}/{closingdate}/{type}/{id}','App\Http\Controllers\Accounts\AccountsController@get_counter_sum_datewise');
    Route::get('/accounts/get_cashcounter_user','App\Http\Controllers\Accounts\AccountsController@get_cashcounter_user');
    Route::get('search_refund_byname', 'App\Http\Controllers\Accounts\AccountsController@search_refund_byname');
    Route::get('/accounts/search_r_byname/{date}/{type}/{user}','App\Http\Controllers\Accounts\AccountsController@search_r_byname');
    Route::get('accounts/fetch_typesdata/','App\Http\Controllers\Accounts\AccountsController@fetch_typesdata');
    Route::post('paid_units_cancelled_refund','App\Http\Controllers\Accounts\AccountsController@paid_units_cancelled_refund');
Route::post('paid_units_amount_refund','App\Http\Controllers\Accounts\AccountsController@paid_units_amount_refund');
    Route::post('update_units_repurchased_amount', 'App\Http\Controllers\Accounts\AccountsController@update_units_repurchased_amount');
Route::post('paid_units_amount_repurchased','App\Http\Controllers\Accounts\AccountsController@paid_units_amount_repurchased');
Route::get('accounts/proceed_cash/{user}/{dated}/{category}/{type}','App\Http\Controllers\Accounts\AccountsController@proceed_cash');
Route::post('Accounts/update_typename/{ide}/{account_name}','App\Http\Controllers\Accounts\AccountsController@update_typename');
Route::get('accounts/pending_dealervoucher_detail/','App\Http\Controllers\Accounts\AccountsController@pending_dealervoucher_detail');
Route::get('accounts/pending_dealervoucher_sum/','App\Http\Controllers\Accounts\AccountsController@pending_dealervoucher_sum');
Route::get('/accounts/search_dealervoucher/{id}','App\Http\Controllers\Accounts\AccountsController@search_dealervoucher');
Route::get('accounts/pending_booking_detail/','App\Http\Controllers\Accounts\AccountsController@pending_booking_detail');
Route::post('accounts/submit_unitbooking','App\Http\Controllers\Accounts\AccountsController@submit_unitbooking');
Route::get('/accounts/search_booking_name/{id}','App\Http\Controllers\Accounts\AccountsController@search_booking_name');
Route::get('accounts/pending_Electricity_sum/','App\Http\Controllers\Accounts\AccountsController@pending_Electricity_sum');
Route::get('accounts/pending_booking_sum/','App\Http\Controllers\Accounts\AccountsController@pending_booking_sum');
Route::get('accounts/pending_Services_sum/','App\Http\Controllers\Accounts\AccountsController@pending_Services_sum');
Route::get('search_unitrefund_date/{from}/{to}','App\Http\Controllers\Accounts\AccountsController@search_unitrefund_date');
Route::get('units_fund_detail', 'App\Http\Controllers\Accounts\AccountsController@units_fund_detail');
Route::post('update_units_refund', 'App\Http\Controllers\Accounts\AccountsController@update_units_refund');
Route::post('update_units_refund_amount', 'App\Http\Controllers\Accounts\AccountsController@update_units_refund_amount');
Route::post('accounts/submit_dealervoucher','App\Http\Controllers\Accounts\AccountsController@submit_dealervoucher');
Route::get('accounts/fetchdealer_voucher','App\Http\Controllers\Accounts\AccountsController@fetchdealer_voucher');
Route::post('accounts/submit_unitservices','App\Http\Controllers\Accounts\AccountsController@submit_unitservices');

Route::get('accounts/pending_electricity_detail','App\Http\Controllers\Accounts\AccountsController@pending_electricity_detail');
Route::get('accounts/search_electricity_name/{id}','App\Http\Controllers\Accounts\AccountsController@search_electricity_name');
Route::get('accounts/pending_onlinecash_adjust/{dated}/{bank_type}','App\Http\Controllers\Accounts\AccountsController@pending_onlinecash_adjust');
Route::get('accounts/get_counter_sum_online_adjust/{dated}/{bank_type}','App\Http\Controllers\Accounts\AccountsController@get_counter_sum_online_adjust');
Route::get('single_units_refund/{id}', 'App\Http\Controllers\Accounts\AccountsController@single_units_refund');
Route::get('accounts/pending_debt_detail/{dated}','App\Http\Controllers\Accounts\AccountsController@pending_debt_detail');
Route::get('accounts/get_counter_sum_debt/{dated}','App\Http\Controllers\Accounts\AccountsController@get_counter_sum_debt');
Route::post('accounts/submit_unitdebt','App\Http\Controllers\Accounts\AccountsController@submit_unitdebt');
Route::get('accounts/pending_onlinecash_detail/{dated}/{bank_type}','App\Http\Controllers\Accounts\AccountsController@pending_onlinecash_detail');
Route::get('accounts/get_counter_sum_online/{dated}/{bank_type}','App\Http\Controllers\Accounts\AccountsController@get_counter_sum_online');
Route::post('accounts/submit_unitonlinecash','App\Http\Controllers\Accounts\AccountsController@submit_unitonlinecash');
Route::post('accounts/submit_unitonlinecash_adjust','App\Http\Controllers\Accounts\AccountsController@submit_unitonlinecash_adjust');
Route::get('accounts/pending_sam_voucher_detail','App\Http\Controllers\Accounts\AccountsController@pending_sam_voucher_detail');
Route::get('accounts/all_receipt_detail/{date}/{type}/{user}','App\Http\Controllers\Accounts\AccountsController@all_receipt_detail');
Route::get('accounts/get_counter_sum/{user}/{dated}/{category}/{type}','App\Http\Controllers\Accounts\AccountsController@get_counter_sum');
Route::get('accounts/get_counter_sum1/{date}/{type}/{id}','App\Http\Controllers\Accounts\AccountsController@get_counter_sum1');
Route::get('/accounts/search_r_byname_cash/{user}','App\Http\Controllers\Accounts\AccountsController@search_r_byname_cash');
Route::post('accounts/submit_unitelectricity','App\Http\Controllers\Accounts\AccountsController@submit_unitelectricity');
Route::get('accounts/search_units_cash_only/{startingdate}/{closingdate}/{category}/{user}/{type}','App\Http\Controllers\Accounts\AccountsController@search_units_cash_only');
Route::get('accounts/search_units_cash_only_counter/{startingdate}/{closingdate}/{category}/{user}/{type}','App\Http\Controllers\Accounts\AccountsController@search_units_cash_only_counter');
Route::get('/accounts/proceed_report','App\Http\Controllers\Accounts\AccountsController@proceed_report');
Route::get('accounts/pending_cash_detail/{all}/{dated}/{category}/{type}','App\Http\Controllers\Accounts\AccountsController@pending_cash_detail');
Route::post('accounts/submit_unitcash','App\Http\Controllers\Accounts\AccountsController@submit_unitcash');
Route::get('accounts/get_units_chq_detail','App\Http\Controllers\Accounts\AccountsController@get_units_chq_detail');
Route::get('accounts/units_check_detail/{id}','App\Http\Controllers\Accounts\AccountsController@units_check_detail');
Route::post('submit_deposit_bankdetails','App\Http\Controllers\Accounts\AccountsController@submit_deposit_bankdetails');
Route::get('accounts/clearncedetails/{id}','App\Http\Controllers\Accounts\AccountsController@clearncedetails');
Route::post('accounts/updateclearance/{id}/{date}','App\Http\Controllers\Accounts\AccountsController@updateclearance');
Route::get('accounts/search_units_date/{startingdate}/{closingdate}/{type}','App\Http\Controllers\Accounts\AccountsController@search_units_date');
});



Route::get('accounts_session_detail1', 'App\Http\Controllers\Accounts\AccountsController@session_detail1');

Route::post('accounts/submit_depreciassion','App\Http\Controllers\Accounts\AccountsController@submit_depreciassion');
Route::get('accounts/assets_depreciasion_detail','App\Http\Controllers\Accounts\AccountsController@assets_depreciasion_detail');
Route::get('accounts/search_depreciationbyname','App\Http\Controllers\Accounts\AccountsController@search_depreciationbyname');
Route::get('accounts/assets_category1','App\Http\Controllers\Accounts\AccountsController@assets_category1');
Route::get('depreciationmethods_detail/{id}','App\Http\Controllers\Accounts\AccountsController@depreciationmethods_detail');
Route::get('single_depreciationasset/{id}','App\Http\Controllers\Accounts\AccountsController@single_depreciationasset');
Route::post('accounts/submit_assetbook','App\Http\Controllers\Accounts\AccountsController@submit_assetbook');
Route::get('accounts/fetch_assets_depreciation','App\Http\Controllers\Accounts\AccountsController@fetch_assets_depreciation');
Route::get('accounts/depreciated_assets_bookdetails','App\Http\Controllers\Accounts\AccountsController@depreciated_assets_bookdetails');
Route::get('accounts/search_assets_bookbyname','App\Http\Controllers\Accounts\AccountsController@search_assets_bookbyname');
Route::get('accounts/search_assetsbyname','App\Http\Controllers\Accounts\AccountsController@search_assetsbyname');
Route::get('depreciationexisting_date/{id}/{catid}','App\Http\Controllers\Accounts\AccountsController@depreciationexisting_date');



Route::get('return_issu_detail_report','App\Http\Controllers\Accounts\AccountsController@return_issu_detail_report');


Route::get('accounts/procurement_cycle_days','App\Http\Controllers\Accounts\AccountsController@procurement_cycle_days')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('accounts_get_servicebill_bydate/{datefrom}/{dateto}', 'App\Http\Controllers\Accounts\AccountsController@accounts_get_servicebill_bydate');





//demand
Route::post('Accounts/update_asset', 'App\Http\Controllers\Accounts\AccountsController@update_asset');


Route::get('accounts/unit_trans_type','App\Http\Controllers\Accounts\AccountsController@unit_trans_type');


Route::get('accounts/fetch_methods1','App\Http\Controllers\Accounts\AccountsController@fetch_methods1');
Route::get('accounts/get_sam_sum/','App\Http\Controllers\Accounts\AccountsController@get_sam_sum');
Route::get('accounts/getgrndate_byasset/{id}','App\Http\Controllers\Accounts\AccountsController@getgrndate_byasset');






