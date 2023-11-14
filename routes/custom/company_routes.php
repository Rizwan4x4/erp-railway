<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


//Live Chat
Route::get('fetch_only_company_name','App\Http\Controllers\companyController@fetch_only_company_name')->middleware('permission:Accounts Configurations COA'); 
Route::get('/chat_allusers','App\Http\Controllers\companyController@chat_allusers') ;
Route::get('/userlivesearch','App\Http\Controllers\companyController@userlivesearch') ;
Route::post('conv_messages','App\Http\Controllers\companyController@conv_messages');
Route::post('conv_messages2','App\Http\Controllers\companyController@conv_messages2');
Route::post('get_userdetail','App\Http\Controllers\companyController@get_userdetail');
Route::get('/fetch_user_session','App\Http\Controllers\companyController@fetch_user_session') ;
Route::post('submit_messages','App\Http\Controllers\companyController@submit_messages');

//Events
Route::get('/fetch_event', 'App\Http\Controllers\companyController@all_events');  //view event detail
Route::get('/fetch_event_thisweek', 'App\Http\Controllers\companyController@fetch_event_thisweek')->middleware('permission:Human Resource Dashboard overall-view');  //view event detail
Route::post('add_event','App\Http\Controllers\companyController@add_event');  //Post event
Route::get('/get_com_users/','App\Http\Controllers\companyController@get_com_users');
Route::get('fetch_this_event/{id}', 'App\Http\Controllers\companyController@fetch_this_event');  //Fetch rel
//

Route::get('fetch_companyDetail','App\Http\Controllers\companyController@fetch_companydetail');
Route::post('submit_company_roles1','App\Http\Controllers\companyController@submit_company_roles1');
Route::post('submit_company_roles','App\Http\Controllers\companyController@submit_company_roles');
Route::post('submit_company_payroll','App\Http\Controllers\companyController@submit_company_payroll');
Route::post('submit_company_payroll1','App\Http\Controllers\companyController@submit_company_payroll1');
Route::post('submit_company_accounts','App\Http\Controllers\companyController@submit_company_accounts');
Route::post('submit_company_accounts1','App\Http\Controllers\companyController@submit_company_accounts1');
Route::post('submit_company_store','App\Http\Controllers\companyController@submit_company_store');
Route::post('submit_company_store1','App\Http\Controllers\companyController@submit_company_store1');
Route::get('/check_company_id','App\Http\Controllers\companyController@check_company_id') ;
Route::get('/logout','App\Http\Controllers\companyController@logout') ;
Auth::routes();
Route::get('getcompanydetail','App\Http\Controllers\companyController@getcompanydetail');
Route::get('/session_check2/', 'App\Http\Controllers\companyController@session_check2' );
Route::get('/get_company_roles/', 'App\Http\Controllers\companyController@get_company_roles');
Route::get('/session_check/', 'App\Http\Controllers\companyController@session_check' );
Route::post('create_company', 'App\Http\Controllers\companyController@create_company');
Route::post('submit_company_roles','App\Http\Controllers\companyController@submit_company_roles');
Route::get('/companies_detail', 'App\Http\Controllers\companyController@companies_detail' );
Route::get('/getcompany_detail/{id}', 'App\Http\Controllers\companyController@getcompany_detail');

Route::get('getcompany_modules/{id}','App\Http\Controllers\companyController@getcompany_modules');
Route::post('update_company','App\Http\Controllers\companyController@update_company');
Route::get('/deactivate_company/{id}','App\Http\Controllers\companyController@deactivate_company');
Route::get('/activate_company/{id}','App\Http\Controllers\companyController@activate_company');
Route::get('/deactivate_company1/{id}','App\Http\Controllers\companyController@deactivate_company1');
Route::get('/activate_company1/{id}','App\Http\Controllers\companyController@activate_company1');
Route::get('/fetch_user_hr_roles','App\Http\Controllers\companyController@fetch_user_hr_roles');
Route::get('/fetch_user_payroll_roles','App\Http\Controllers\companyController@fetch_user_payroll_roles');
Route::get('/fetch_emp_code','App\Http\Controllers\companyController@fetch_emp_code');
Route::get('/fetch_company_roles/{company_id}','App\Http\Controllers\companyController@fetch_company_roles');
Route::get('/fetch_company_roles_payroll/{company_id}','App\Http\Controllers\companyController@fetch_company_roles_payroll');
Route::get('/fetch_company_roles_accounts/{company_id}','App\Http\Controllers\companyController@fetch_company_roles_accounts');
Route::post('/updatepic', 'App\Http\Controllers\companyController@updatepic');
Route::get('/user_session/', 'App\Http\Controllers\companyController@user_session' );
Route::get('/fetch_tour_status', 'App\Http\Controllers\companyController@fetch_tour_status');
Route::get('/update_tour_status', 'App\Http\Controllers\companyController@update_tour_status');
Route::get('get_faqs/{catagory}','App\Http\Controllers\companyController@get_faqs');
Route::get('/get_faqs_cat','App\Http\Controllers\companyController@get_faqs_cat');
Route::get('/fetch_user_accounts_roles','App\Http\Controllers\companyController@fetch_user_accounts_roles');
Route::get('/is_online/', 'App\Http\Controllers\companyController@online_fn');
Route::get('find_usertype/','App\Http\Controllers\companyController@find_usertype');
Route::get('/fetch_user_audit_roles','App\Http\Controllers\companyController@fetch_user_audit_roles');

Route::post('/login_success/', 'App\Http\Controllers\companyController@login_success' );

//Route::middleware(['auth:sanctum'])->post('/login_success', 'App\Http\Controllers\Auth\LoginController@login_success');












