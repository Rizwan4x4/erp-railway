<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Route::get('Accounts/fetch_dashboard_TopConsumedItem', 'App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_TopConsumedItem')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('Accounts/fetch_dashboard_TopItem', 'App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_TopItem')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('Accounts/fetch_dashboard_TopCategoryInventory', 'App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_TopCategoryInventory')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('Accounts/fetch_dashboard_TopAssetCategory', 'App\Http\Controllers\Accounts\AccountsController@fetch_dashboard_TopAssetCategory')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('accounts/Assets_D', 'App\Http\Controllers\Accounts\AccountsController@Assets_D')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('accounts/Assets_Detail_CategoryWi', 'App\Http\Controllers\Accounts\AccountsController@Assets_Detail_CategoryWi')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('accounts/RemainingAssets_Dashboard/{name}', 'App\Http\Controllers\Accounts\AccountsController@RemainingAssets_Dashboard');


Route::get('/accounts_vendor_detail', 'App\Http\Controllers\Accounts\AccountsController@vendor_detail')->middleware('permission:Accounting procurement-configuration vendors');   //View vendors

Route::get('accounts_fetch_vendors/{id}', 'App\Http\Controllers\Accounts\AccountsController@fetch_vendors');  //fetch vendor
Route::post('account_deposit_status', 'App\Http\Controllers\Accounts\AccountsController@submit_deposit_status');
Route::post('accounts_update_vendor', 'App\Http\Controllers\Accounts\AccountsController@update_vendor');  //update status
Route::post('accounts_add_vendor', 'App\Http\Controllers\Accounts\AccountsController@add_vendor'); //Add vendor



//Route::get('accounts/fetch_product_detail','App\Http\Controllers\Accounts\AccountsController@fetch_product_detail');
Route::get('accounts/category_detail/{id}', 'App\Http\Controllers\Accounts\AccountsController@category_detail');
Route::get('accounts/unit_data', 'App\Http\Controllers\Accounts\AccountsController@unit_data')->middleware('permission:Accounts Configurations  general');
Route::post('accounts/submit_unit', 'App\Http\Controllers\Accounts\AccountsController@submit_unit');


Route::get('/accounts_catagory_byname/', 'App\Http\Controllers\Accounts\AccountsController@accounts_catagory_byname');

Route::get('accounts_fetch_catagories/{id}', 'App\Http\Controllers\Accounts\AccountsController@fetch_catagory');  //fetch catagory to update

Route::post('accounts_update_catagory', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_catagory');  //update catagory


Route::post('accounts_update_catSts', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_catSts');  //update catagory status

Route::post('accounts_update_venSts', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_venSts');  //update vendor status
Route::get('/accounts_vendor_byname/', 'App\Http\Controllers\Accounts\AccountsController@accounts_vendor_byname');
Route::get('/accounts/get_no_data/{id}/{no}', 'App\Http\Controllers\Accounts\AccountsController@get_no_data');
Route::get('/accounts/taxes_detail/', 'App\Http\Controllers\Accounts\AccountsController@taxes_detail')->middleware('permission:Accounts Configurations  taxes');
Route::post('accounts/submit_tax', 'App\Http\Controllers\Accounts\AccountsController@submit_tax');
Route::post('accounts/accounts_update_taxes_status', 'App\Http\Controllers\Accounts\AccountsController@accounts_update_taxes_status');
Route::get('/accounts/filter_tax/', 'App\Http\Controllers\Accounts\AccountsController@filter_tax');
Route::get('accounts/get_quotation_data/{id}/{rid}', 'App\Http\Controllers\Accounts\AccountsController@get_quotation_data');
Route::get('accounts/get_quotation_data1/{qid}', 'App\Http\Controllers\Accounts\AccountsController@get_quotation_data1');
Route::post('accounts/edit_pquotation', 'App\Http\Controllers\Accounts\AccountsController@edit_pquotation');


Route::middleware(['permission:Purchase Orders Create'])->group(function () {

    Route::get('/accounts/get_quotationdetail', 'App\Http\Controllers\Accounts\AccountsController@get_quotationdetail');
    Route::get('/accounts/get_quotation_detail/{qid}', 'App\Http\Controllers\Accounts\AccountsController@get_quotation_detail');
    Route::get('/accounts/get_quotation_detail1/{qid}', 'App\Http\Controllers\Accounts\AccountsController@get_quotation_detail1');


    Route::post('/accounts/insert_purchaseorder', 'App\Http\Controllers\Accounts\AccountsController@insert_purchaseorder');

});

Route::get('/accounts/get_quotationdetaill', 'App\Http\Controllers\Accounts\AccountsController@get_quotationdetaill');


Route::middleware(['permission:Purchase Orders View'])->group(function () {

    Route::get('accounts/get_po_detail', 'App\Http\Controllers\Accounts\AccountsController@get_po_detail');
    Route::get('accounts_get_po_bydate/{datefrom}/{dateto}', 'App\Http\Controllers\Accounts\AccountsController@po_by_date');
    Route::get('/accounts_PObyName/', 'App\Http\Controllers\Accounts\AccountsController@PO_By_Name');
    Route::get('accounts_fetch_PObySts/{sts}', 'App\Http\Controllers\Accounts\AccountsController@fetch_po_byStatus');  //fetch requisitiion
    Route::get('accounts/count_purchase', 'App\Http\Controllers\Accounts\AccountsController@count_purchase');

});
Route::middleware(['permission:Services Invoice Edit,Services Invoice Create'])->group(function () {

    Route::get('accounts/get_POdetail', 'App\Http\Controllers\Accounts\AccountsController@get_POdetail');
});




// Purchase Returns

Route::middleware(['permission:Purchase Returns View'])->group(function () {

    Route::get('/accounts/purreturn_detail/', 'App\Http\Controllers\Accounts\AccountsController@purreturn_detail');
    Route::get('search_purchasereturn/{date1}/{date2}', 'App\Http\Controllers\Accounts\AccountsController@search_purchasereturn');

});
Route::get('Accounts/pr_Letter/{id}/{prid}', 'App\Http\Controllers\ReportsController@pr_Letter')->middleware('permission:Purchase Returns Print');

Route::middleware(['permission:GRN Detail Create,Services Invoice Edit,Services Invoice Create,Purchase Requisition Goods Quotation,Purchase Requisition Assets Item Quotation'])->group(function () {

    Route::get('/accounts/get_delivery/', 'App\Http\Controllers\Accounts\AccountsController@get_delivery');
    Route::get('/accounts/get_tax/', 'App\Http\Controllers\Accounts\AccountsController@get_tax');

});

//->middleware('permission:Purchase Returns Edit');

Route::get('accounts/get_POreturn', 'App\Http\Controllers\Accounts\AccountsController@get_POreturn');
Route::get('/accounts/get_purchaseinvoice_detail/{poid}', 'App\Http\Controllers\Accounts\AccountsController@get_purchaseinvoice_detail');
Route::get('/accounts/get_purchaseinvoice_detail1/{poid}', 'App\Http\Controllers\Accounts\AccountsController@get_purchaseinvoice_detail1');
//

Route::get('accounts_fetch_demandreqBysts/{sts}/{dept}/{proj}/{startdate}/{closedate}/{page}', 'App\Http\Controllers\Accounts\AccountsController@accounts_fetch_demandreqBysts'); //fetch requisitiion
Route::post('accounts/update_demandrequisition', 'App\Http\Controllers\Accounts\AccountsController@update_demandrequisition');

Route::middleware(['permission:Demand Requisition Inventory View'])->group(function () {
    Route::get('accounts/get_demandrequisition', 'App\Http\Controllers\Accounts\AccountsController@get_demandrequisition');
    Route::get('accounts/searchbydemandreqid/{id}/{page}', 'App\Http\Controllers\Accounts\AccountsController@searchbydemandreqid');
//    Route::get('accounts/get_projects/{child}', 'App\Http\Controllers\Accounts\AccountsController@get_projects');

});

Route::middleware(['permission:Demand Requisition Assets View'])->group(function () {

    Route::get('accounts_fetch_demandreqBysts_assets/{sts}/{dept}/{proj}/{startdate}/{closedate}/{page}', 'App\Http\Controllers\Accounts\AccountsController@accounts_fetch_demandreqBysts_assets');
    Route::get('accounts/searchbydemandreqid_assets/{id}/{page}', 'App\Http\Controllers\Accounts\AccountsController@searchbydemandreqid_assets');

});

Route::middleware(['permission:Demand Requisition Service View'])->group(function () {

    Route::get('accounts/get_demandrequisition_services', 'App\Http\Controllers\Accounts\AccountsController@get_demandrequisition_services');
    Route::get('accounts/searchbydemandreqid_services/{id}/{page}', 'App\Http\Controllers\Accounts\AccountsController@searchbydemandreqid_services');

});


// get Single Items detail
Route::middleware(['permission:Demand Requisition Inventory View,Demand Requisition Assets View,Demand Requisition Service View'])->group(function () {

    Route::get('/accounts/get_demandreq_data1/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_demandreq_data1');
    Route::get('/accounts/get_demandreq_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_demandreq_data');  //

});

// Create Demand Requisition
Route::post('accounts/insert_requisition', 'App\Http\Controllers\Accounts\AccountsController@insert_requisition')->middleware('permission:Demand Requisition Create');














//Purchase Returns Print

//Demand Requisition Inventory Change Statuses
Route::middleware(['permission:Demand Requisition Inventory Change Statuses,Demand Requisition Asset Change Statuses,Demand Requisition Service Change Statuses'])->group(function () {
    Route::post('accounts_upd_demandreq_sts', 'App\Http\Controllers\Accounts\AccountsController@accounts_upd_demandreq_sts');
});


Route::middleware(['permission:Services Invoice View'])->group(function () {

    Route::get('accounts/count_grn', 'App\Http\Controllers\Accounts\Grn@count_grn');
    Route::get('/accounts/grn_detail/', 'App\Http\Controllers\Accounts\Grn@grn_detail');
    Route::get('searchgrn/{date1}/{date2}', 'App\Http\Controllers\Accounts\Grn@searchgrn');

});

Route::middleware(['permission:Services Invoice Statuses'])->group(function () {

    Route::post('accounts/update_v_inv', 'App\Http\Controllers\Accounts\Grn@update_v_inv');

});

Route::middleware(['permission:Services Invoice View,Purchase Returns View'])->group(function () {

    Route::get('/accounts_grnbyVendor/', 'App\Http\Controllers\Accounts\Grn@grn_byname');
    Route::post('accounts/edit_grn1', 'App\Http\Controllers\Accounts\Grn@edit_grn1');

});

Route::middleware(['permission:Services Invoice View,Purchase Returns View,Services Invoice Edit'])->group(function () {

    Route::get('/get_POdetails_by_id/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_POdetails_by_id');
    Route::get('/accounts/get_po_detail_by_PIID/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_po_detail_by_PIID');
    Route::get('/accounts/get_purchaseorder_detail1_by_PIID/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_detail1_by_PIID');
    Route::get('/get_invoice_date/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_invoice_date');
});
Route::middleware(['permission:Purchase Orders Item View'])->group(function () {

    Route::get('/accounts_get_po_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_po_data');
    Route::get('/accounts_get_po_data2/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_po_data2');
    Route::get('accounts_get_poProducts/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_poProducts');

});

Route::middleware(['permission:Purchase Orders Actions'])->group(function () {

    Route::get('Accounts/reverse_po/{id}', 'App\Http\Controllers\Accounts\AccountsController@reverse_po');

});
Route::post('accounts/insert_grn', 'App\Http\Controllers\Accounts\Grn@insert_grn')->middleware('permission:Services Invoice Create');

//Purchase Requisition View Goods
Route::middleware(['permission:Purchase Requisition View Goods'])->group(function () {

    Route::get('accounts/get_requisition', 'App\Http\Controllers\Accounts\AccountsController@get_requisition');
    Route::get('accounts/count_requisitions', 'App\Http\Controllers\Accounts\AccountsController@count_requisitions');
    Route::get('accounts_fetch_reqBysts/{sts}/{dept}/{proj}/{startdate}/{closedate}/{page}', 'App\Http\Controllers\Accounts\AccountsController@fetch_req_byStatus'); //fetch requisitiion
    Route::get('accounts/searchbyreqid/{id}/{page}', 'App\Http\Controllers\Accounts\AccountsController@searchbyreqid');  //

});

Route::middleware(['permission:Purchase Requisition Goods Edit'])->group(function () {

    Route::get('/accounts/get_req_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_req_data');  //
    Route::get('accounts/get_projects/{child}', 'App\Http\Controllers\Accounts\AccountsController@get_projects');


});

Route::middleware(['permission:Purchase Requisition Goods Edit,Purchase Orders Item View,Purchase Requisition Goods Quotation,Purchase Requisition Assets Item Detail'])->group(function () {

    Route::get('/accounts/get_req_data1/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_req_data1');

});

//These routes also used somewhere else
Route::middleware(['permission:Purchase Requisition Goods Edit'])->group(function () {

    Route::get('accounts/get_itemss', 'App\Http\Controllers\Accounts\AccountsController@get_itemss');
    Route::post('accounts/update_requisition', 'App\Http\Controllers\Accounts\AccountsController@update_requisition');

});

Route::middleware(['permission:Purchase Requisition Goods Quotation'])->group(function () {
    Route::get('/accounts/get_vendor_detail/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_vendor_detail');

});

Route::middleware(['permission:Purchase Requisition Goods Quotation,Purchase Requisition Assets Quotation'])->group(function () {

    Route::post('accounts/insert_pquotation', 'App\Http\Controllers\Accounts\AccountsController@insert_pquotation');

});
Route::middleware(['permission:Purchase Requisition Goods Quotation'])->group(function () {
    Route::get('/accounts/get_vendor_detail/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_vendor_detail');

});


Route::middleware(['permission:Purchase Requisition Goods Quotation,Purchase Requisition Assets Item Quotation'])->group(function () {

    Route::get('accounts/fetch_req_type/{id}', 'App\Http\Controllers\Accounts\AccountsController@fetch_req_type');

});
Route::middleware(['permission:Purchase Requisition Merge'])->group(function () {

    Route::get('accounts/get_allrequisition', 'App\Http\Controllers\Accounts\AccountsController@get_allrequisition');
    Route::get('accounts/get_units', 'App\Http\Controllers\Accounts\AccountsController@get_units');
    Route::get('accounts/get_items/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_items');
    Route::get('accounts/get_requisition_items/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_requisition_items');
    Route::get('accounts/get_allrequisition1/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_allrequisition1');
    Route::get('accounts/get_requisition_multipleitems', 'App\Http\Controllers\Accounts\AccountsController@get_requisition_multipleitems');
    Route::post('accounts/insert_mergerequisition', 'App\Http\Controllers\Accounts\AccountsController@insert_mergerequisition');

});
Route::middleware(['permission:Purchase Requisition View Assets'])->group(function () {

    Route::get('accounts/get_requisition_assets', 'App\Http\Controllers\Accounts\AccountsController@get_requisition_assets');
    Route::get('accounts_fetch_reqBysts_assets/{sts}/{dept}/{proj}/{startdate}/{closedate}/{page}', 'App\Http\Controllers\Accounts\AccountsController@accounts_fetch_reqBysts_assets');
    Route::get('accounts/searchbyreqid_assets/{id}/{page}', 'App\Http\Controllers\Accounts\AccountsController@searchbyreqid_assets');  //


});

Route::middleware(['permission:Purchase Requisition Assets Item Quotation'])->group(function () {
    Route::get('/accounts/get_vendor/', 'App\Http\Controllers\Accounts\AccountsController@get_vendor');

});

Route::middleware(['permission:Purchase Requisition Assets Item Quotation,Purchase Requisition View Services'])->group(function () {

    Route::get('accounts/get_requisition_services', 'App\Http\Controllers\Accounts\AccountsController@get_requisition_services');
    Route::get('accounts/searchbyreqid_services/{id}/{page}', 'App\Http\Controllers\Accounts\AccountsController@searchbyreqid_services');  //

});
Route::middleware(['permission:Purchase Requisition View Services'])->group(function () {

    Route::get('accounts_fetch_reqBysts_services/{sts}/{dept}/{proj}/{startdate}/{closedate}/{page}', 'App\Http\Controllers\Accounts\AccountsController@accounts_fetch_reqBysts_services'); //fetch requisitiion
});
Route::get('accounts/count_demandrequisitions', 'App\Http\Controllers\Accounts\AccountsController@count_demandrequisitions');
Route::get('accounts/count_demandrequisitions1', 'App\Http\Controllers\Accounts\AccountsController@count_demandrequisitions1')->middleware('permission:Procurement Dashboard overall-view'); 
Route::get('accounts/grn_vs_pr', 'App\Http\Controllers\Accounts\AccountsController@grn_vs_pr')->middleware('permission:Procurement Dashboard overall-view');




Route::get('accounts/get_demandrequisition_assets', 'App\Http\Controllers\Accounts\AccountsController@get_demandrequisition_assets');
Route::get('accounts/count_demandrequisitions_assets', 'App\Http\Controllers\Accounts\AccountsController@count_demandrequisitions_assets');
Route::get('accounts_fetch_demandreqBysts_services/{sts}/{dept}/{proj}/{startdate}/{closedate}/{page}', 'App\Http\Controllers\Accounts\AccountsController@accounts_fetch_demandreqBysts_services'); //fetch requisitiion


Route::get('accounts/count_demandrequisitions_services', 'App\Http\Controllers\Accounts\AccountsController@count_demandrequisitions_services');
Route::get('accounts_fetch_demandreqBysts', 'App\Http\Controllers\Accounts\AccountsController@accounts_fetch_demandreqBysts');


Route::get('accounts/get_dept', 'App\Http\Controllers\Accounts\AccountsController@get_dept');

Route::get('/accounts/get_delivery2/', 'App\Http\Controllers\Accounts\AccountsController@get_delivery2');
Route::get('/accounts/get_tax2', 'App\Http\Controllers\Accounts\AccountsController@get_tax2');
Route::get('/accounts/select_tax_value/{tax_value}/{subtotal}', 'App\Http\Controllers\Accounts\AccountsController@select_tax_value');
Route::get('/accounts/select_delivery_value/{delivery_value}/{subtotal}', 'App\Http\Controllers\Accounts\AccountsController@select_delivery_value');
Route::get('/accounts_requisition_byDept/', 'App\Http\Controllers\Accounts\AccountsController@accounts_requisition_byDept');
Route::get('accounts_get_reqns', 'App\Http\Controllers\Accounts\AccountsController@get_reqns');

Route::post('accounts_upd_req_sts', 'App\Http\Controllers\Accounts\AccountsController@req_status_update');
Route::post('accounts/insert_issuanceledger', 'App\Http\Controllers\Accounts\AccountsController@insert_issuanceledger');

//Route::get('accounts/get_issuance_detail','App\Http\Controllers\Accounts\AccountsController@get_issuance_detail');

Route::get('requisition_detail_report', 'App\Http\Controllers\Accounts\AccountsController@requisition_detail_report');


Route::post('accounts_upd_req_sts_completion', 'App\Http\Controllers\Accounts\AccountsController@accounts_upd_req_sts_completion');

Route::get('accounts/count_req_amt_d/', 'App\Http\Controllers\Accounts\AccountsController@count_req_amt_d')->middleware('permission:Accounts Dashboard overall-view,Procurement Dashboard overall-view'); 

Route::get('get_datad/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_datad');


Route::get('accounts/inv_reqCounter/{sts}/{type}', 'App\Http\Controllers\Accounts\AccountsController@inv_reqCounter');
Route::get('accounts/count_requisitions_services', 'App\Http\Controllers\Accounts\AccountsController@count_requisitions_services');
Route::get('accounts/count_requisitions_assets', 'App\Http\Controllers\Accounts\AccountsController@count_requisitions_assets');

Route::get('accounts/demand_requisition_all', 'App\Http\Controllers\Accounts\AccountsController@demand_requisition_all');
Route::get('/accounts/get_demandreq_services/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_demandreq_services');
Route::get('accounts/count_requisitions_services', 'App\Http\Controllers\Accounts\AccountsController@count_requisitions_services');
Route::get('get_comparative_report/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_comparative_report');


Route::get('accounts_fetch_PObySts/{sts}', 'App\Http\Controllers\Accounts\AccountsController@fetch_po_byStatus');  //fetch requisitiion
Route::get('/accounts_PObyName/','App\Http\Controllers\Accounts\AccountsController@PO_By_Name');
Route::get('/accounts_get_po_data/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_po_data');
Route::get('/accounts_get_po_data2/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_po_data2');
Route::get('accounts_get_poProducts/{id}','App\Http\Controllers\Accounts\AccountsController@get_poProducts');
Route::get('accounts/po_detailreport','App\Http\Controllers\Accounts\AccountsController@po_detailreport');
Route::get('accounts_get_po_bydate/{datefrom}/{dateto}', 'App\Http\Controllers\Accounts\AccountsController@po_by_date');






Route::get('/accounts/grn_detail/','App\Http\Controllers\Accounts\Grn@grn_detail');




// Stock Detail & Adjustment 
Route::middleware(['permission:Inventory StockDetail overall-view,Inventory StockDetail stock-adjustment,Inventory Account-Reports inventory'])->group(function () {
Route::get('accounts/stock_detail','App\Http\Controllers\Accounts\AccountsController@stock_detail');
});
Route::middleware(['permission:Inventory StockDetail overall-view'])->group(function () {
    Route::get('accounts/getindtotalstock/{id}','App\Http\Controllers\Accounts\AccountsController@getindtotalstock');
    Route::get('accounts/getindstock/{id}','App\Http\Controllers\Accounts\AccountsController@getindstock');
});
Route::middleware(['permission:Inventory StockDetail stock-adjustment'])->group(function () {
    Route::post('accounts/submit_stock_adj', 'App\Http\Controllers\Accounts\AccountsController@submit_stock_adj');
    Route::get('accounts/fetch_item_name/{id}','App\Http\Controllers\Accounts\AccountsController@fetch_item_name');
});



Route::get('accounts/assets_detail','App\Http\Controllers\Accounts\AccountsController@assets_detail');




Route::get('accounts/get_allprojects','App\Http\Controllers\Accounts\AccountsController@get_all_projects');





//Grn Order and Invoice
// Grn Order 
Route::middleware(['permission:Inventory Grn overall-view ,GRN View'])->group(function () {
    Route::get('accounts/get_POdetail9','App\Http\Controllers\Accounts\AccountsController@get_POdetail9');
    Route::get('/accounts_grnbyVendor9/','App\Http\Controllers\Accounts\Grn@grn_byname9');
    Route::get('/accounts/grn_detail9/','App\Http\Controllers\Accounts\Grn@grn_detail9');
    Route::get('/accounts/get_grn_data9/{id}','App\Http\Controllers\Accounts\Grn@get_grn_data9');
    Route::get('accounts/get_grn_data19/{id}','App\Http\Controllers\Accounts\Grn@get_grn_data19');
    Route::get('accounts/count_grn9','App\Http\Controllers\Accounts\Grn@count_grn9');
    });
Route::middleware(['permission:Inventory Grn overall-view,Inventory purchase-invoice overall-view,Services Invoice Create'])->group(function () {
    Route::get('/accounts/get_purchaseorder_detail1/{poid}','App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_detail1');
    Route::get('/accounts/get_purchaseorder_detail/{poid}','App\Http\Controllers\Accounts\AccountsController@get_purchaseorder_detail');
    });
Route::middleware(['permission:Inventory Grn create-grn'])->group(function () {
    Route::post('accounts/insert_grn9', 'App\Http\Controllers\Accounts\Grn@insert_grn9');
    });
Route::middleware(['permission:Inventory Grn filter'])->group(function () {
Route::get('searchgrn9/{sts1}/{sts2}/{date1}/{date2}','App\Http\Controllers\Accounts\Grn@searchgrn9');
    });
Route::middleware(['permission:Inventory Grn delete'])->group(function () {
    Route::get('/delete_GRN/{id}', 'App\Http\Controllers\Accounts\Grn@delete_grn');
    });
Route::middleware(['permission:Inventory Grn status'])->group(function () {
    Route::post('accounts/update_v_inv_grn','App\Http\Controllers\Accounts\Grn@update_v_inv_grn');
    Route::get('accounts/update_grn9/{id}/{status}','App\Http\Controllers\Accounts\Grn@update_grn9');
Route::post('/accounts_update_grn','App\Http\Controllers\Accounts\Grn@edit_grn');
    });



//using in grn order & service invoice
Route::get('accounts/get_grn_data1/{id}','App\Http\Controllers\Accounts\Grn@get_grn_data1');
Route::get('/accounts/get_grn_data/{id}','App\Http\Controllers\Accounts\Grn@get_grn_data');


Route::get('accounts/update_grn/{id}/{status}','App\Http\Controllers\Accounts\Grn@update_grn');
Route::get('accounts/count_grn','App\Http\Controllers\Accounts\Grn@count_grn');



// Issuance 
Route::middleware(['permission:Inventory Issuance overall-view'])->group(function () {
Route::get('accounts_get_reqns1', 'App\Http\Controllers\Accounts\AccountsController@get_reqns1');
Route::get('accounts/get_req_iss/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_req_iss');
Route::get('accounts/get_re_iss/{id}', 'App\Http\Controllers\Accounts\AccountsController@get_re_iss');
Route::get('accounts/get_itemIssDetail/{id}','App\Http\Controllers\Accounts\AccountsController@get_itemIssDetail');
Route::get('accounts/Get_req_Details/{id}', 'App\Http\Controllers\Accounts\AccountsController@Get_req_Detail');
Route::get('searchissuance/{department}/{project}/{date1}/{date2}','App\Http\Controllers\Accounts\AccountsController@searchissuance');
Route::get('/accounts_issuanceByDepartment/','App\Http\Controllers\Accounts\AccountsController@issuance_bydept');
Route::get('accounts/get_issuance_data/{id}','App\Http\Controllers\Accounts\AccountsController@get_issuancebyid');
Route::get('accounts/get_issuance_items/{id}','App\Http\Controllers\Accounts\AccountsController@get_issuanceitem');
Route::get('accounts/get_allissuance','App\Http\Controllers\Accounts\AccountsController@get_allissuance');
});


Route::middleware(['permission:Inventory Issuance create-issuance'])->group(function () {
    Route::post('accounts/insert_issuance', 'App\Http\Controllers\Accounts\AccountsController@insert_issuance');
});
Route::middleware(['permission:Inventory Issuance create-issuance-site'])->group(function () {
    Route::post('accounts/insert_site_issuance', 'App\Http\Controllers\Accounts\AccountsController@insert_site_issuance');
});


// Issuance Return
Route::middleware(['permission:Inventory Issuance-return overall-view'])->group(function () {
Route::get('accounts_get_issuances','App\Http\Controllers\Accounts\AccountsController@get_isssuances');
Route::get('accounts/get_iss_items/{id}','App\Http\Controllers\Accounts\AccountsController@get_iss_item');
Route::get('accounts/get_iss_detail/{id}','App\Http\Controllers\Accounts\AccountsController@get_iss_detail');
Route::get('accounts/issuance_returns','App\Http\Controllers\Accounts\AccountsController@get_issuance_return');
Route::get('/accounts_issRtnByDepartment/','App\Http\Controllers\Accounts\AccountsController@issuanceRtn_bydept');
Route::get('accounts/get_issuancereturn/{id}','App\Http\Controllers\Accounts\AccountsController@get_issuancereturn');
Route::get('accounts/get_issuancereturn1/{id}','App\Http\Controllers\Accounts\AccountsController@get_issuancereturn1');
Route::get('searchissuanceRtn/{department}/{project}/{date1}/{date2}','App\Http\Controllers\Accounts\AccountsController@searchissuance_rtn');
});

Route::middleware(['permission:Inventory Issuance-return create-issuance-return'])->group(function () {
    Route::post('accounts/insert_issuance_return', 'App\Http\Controllers\Accounts\AccountsController@insert_issuanceReturn');
});



Route::get('/accounts_grnbyVendor/','App\Http\Controllers\Accounts\Grn@grn_byname');
Route::get('searchgrn/{date1}/{date2}','App\Http\Controllers\Accounts\Grn@searchgrn');
Route::post('accounts/update_v_inv','App\Http\Controllers\Accounts\Grn@update_v_inv');
Route::post('insert_services_invoice', 'App\Http\Controllers\Accounts\Grn@insert_services_invoice');
Route::post('accounts/edit_pinvoice', 'App\Http\Controllers\Accounts\Grn@update_pinvoice');
Route::post('accounts/edit_grn1', 'App\Http\Controllers\Accounts\Grn@edit_grn1');

