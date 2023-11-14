<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


Route::get('/forgot_password',function(){return view('forgot_password');});
Route::get('/verify_email',function(){return view('verify_email');});
Route::get('/reset_password',function(){return view('reset_password');});

Route::get('view_cities/','App\Http\Controllers\clientAdminController@view_cities')->middleware('permission:Work Location overall-view');
Route::post('submit_c','App\Http\Controllers\clientAdminController@submit_c')->middleware('permission:Add new city');
Route::get('fetch_locations/{id}', 'App\Http\Controllers\clientAdminController@fetch_locations');  //fetch location to update
Route::get('fetch_department/{id}', 'App\Http\Controllers\clientAdminController@fetch_department');  //fetch departmrnt to update
Route::get('fetch_designations/{id}', 'App\Http\Controllers\clientAdminController@fetch_designations');  //fetch designations to update
Route::post('update_location', 'App\Http\Controllers\clientAdminController@update_location');  //update location
Route::post('update_designation', 'App\Http\Controllers\clientAdminController@update_designation');  //update designation
Route::post('update_department', 'App\Http\Controllers\clientAdminController@update_department');  //update department
Route::get('/delete_city/{id}', 'App\Http\Controllers\clientAdminController@delete_city')->middleware('permission:Delete city');
Route::get('/delete_department/{id}', 'App\Http\Controllers\clientAdminController@delete_department');
Route::get('/delete_designation/{id}', 'App\Http\Controllers\clientAdminController@delete_designation');
Route::get('/delete_location/{id}', 'App\Http\Controllers\clientAdminController@delete_location');
Route::get('/getuser_detail/{id}', 'App\Http\Controllers\clientAdminController@getuser_detail' );
Route::get('/location_detail', 'App\Http\Controllers\clientAdminController@location_detail')->middleware('permission:Work Location overall-view');
Route::post('submit_location','App\Http\Controllers\clientAdminController@submit_location')->middleware('permission:Add new Location');
Route::get('/deactivate_location/{id}','App\Http\Controllers\clientAdminController@deactivate_location');
Route::get('/activate_location/{id}','App\Http\Controllers\clientAdminController@activate_location');
Route::get('/search_location/','App\Http\Controllers\clientAdminController@search_location');
Route::post('submit_designation','App\Http\Controllers\clientAdminController@submit_designation')->middleware('permission:Add new Designantion');
Route::get('/designation_detail', 'App\Http\Controllers\clientAdminController@designation_detail')->middleware('permission:Designantion overall-view');

Route::get('/deactivate_designation/{id}','App\Http\Controllers\clientAdminController@deactivate_designation');
Route::get('/activate_designation/{id}','App\Http\Controllers\clientAdminController@activate_designation');
Route::get('/search_designation/','App\Http\Controllers\clientAdminController@search_designation');
Route::get('/search_department/','App\Http\Controllers\clientAdminController@search_department');
Route::post('submit_department','App\Http\Controllers\clientAdminController@submit_department')->middleware('permission:AC Department Add new Department');
Route::get('/deactivate_department/{id}','App\Http\Controllers\clientAdminController@deactivate_department');
Route::get('/activate_department/{id}','App\Http\Controllers\clientAdminController@activate_department');
Route::get('/overall_users','App\Http\Controllers\clientAdminController@overall_users');
Route::get('/overall_empcode','App\Http\Controllers\clientAdminController@overall_empcode');
Route::get('/registered_empcode','App\Http\Controllers\ClientAdmin\ClientAdminController@registered_empcode');

Route::get('/overall_location','App\Http\Controllers\HRMS\EmployeDetails\EmployeDetailsController@overall_location');
Route::get('/overall_designation','App\Http\Controllers\HRMS\EmployeDetails\EmployeDetailsController@overall_designation');
Route::get('/overall_department','App\Http\Controllers\clientAdminController@overall_department');
Route::post('create_user', 'App\Http\Controllers\clientAdminController@create_user');
Route::post('update_user/{id}', 'App\Http\Controllers\clientAdminController@update_user');

Route::get('/search_users/','App\Http\Controllers\clientAdminController@search_users')->middleware('permission:User Details oervall-view');

Route::get('/registered_empcode1','App\Http\Controllers\ClientAdminController@registered_empcode1');

Route::post('get_statuswise_users', 'App\Http\Controllers\clientAdminController@get_statuswise_users');
Route::post('get_designationwise_users', 'App\Http\Controllers\clientAdminController@get_designationwise_users');
Route::post('get_locationwise_users', 'App\Http\Controllers\clientAdminController@get_locationwise_users');
Route::get('/deactivate_user/{id}','App\Http\Controllers\clientAdminController@deactivate_user');
Route::get('/activate_user/{id}','App\Http\Controllers\clientAdminController@activate_user');
Route::post('submit_user_roles','App\Http\Controllers\clientAdminController@submit_user_roles');
Route::get('/fetch_user_roles/{email}','App\Http\Controllers\clientAdminController@fetch_user_roles');
Route::get('/count_users','App\Http\Controllers\clientAdminController@count_users');
Route::get('/fetch_image', 'App\Http\Controllers\clientAdminController@fetch_image');
// Route::get('/registered_empcode','App\Http\Controllers\clientAdminController@registered_empcode');
Route::post('confirm_oldPass','App\Http\Controllers\clientAdminController@confirm_oldPass');  //Submit old pass
Route::post('change_Pass','App\Http\Controllers\clientAdminController@change_Pass');  //Change pass
Route::get('/is_cleared/', 'App\Http\Controllers\clientAdminController@is_cleared' );
Route::post('cache_cleared','App\Http\Controllers\clientAdminController@cache_cleared');  //Change pass
Route::post('send_update','App\Http\Controllers\clientAdminController@send_update');  //Change pass


Route::get('/get_permissions/', 'App\Http\Controllers\clientAdminController@get_permissions' );
