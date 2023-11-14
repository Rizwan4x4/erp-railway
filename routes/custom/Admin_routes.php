<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClubManagement\ClubController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Roles\RolesController;

//ClubManagement
Route::post('create_new_club','App\Http\Controllers\Admin\ClubManagement\ClubController@create_new_club')->middleware('permission:Admin Club Management Create Club AddNewClub');

Route::get('get_club_data','App\Http\Controllers\Admin\ClubManagement\ClubController@get_club_data')->middleware('permission:Admin Club Management View Register Member Tab');
//Route::get('get_club_data','App\Http\Controllers\Admin\ClubManagement\ClubController@get_club_data');
Route::post('update_club/{id}','App\Http\Controllers\Admin\ClubManagement\ClubController@update_club')->middleware('permission:Admin Club Management Create Club EditClubDetails');

Route::post('del_club','App\Http\Controllers\Admin\ClubManagement\ClubController@del_club')->middleware('permission:Admin Club Management Create Club DeleteClub');

//MemberManagement
Route::post('create_new_member','App\Http\Controllers\Admin\ClubManagement\MemberController@create_new_member')->middleware('permission:Admin Club Management Register Member AddNewMember');
Route::get('get_member_data/{id}','App\Http\Controllers\Admin\ClubManagement\MemberController@get_member_data')->middleware('permission:Admin Club Management View Register Member Tab');
Route::get('get_member_DetailById/{id}','App\Http\Controllers\Admin\ClubManagement\MemberController@get_member_DetailById');
Route::post('create_Member_Receipt','App\Http\Controllers\Admin\ClubManagement\MemberController@create_Member_Receipt')->middleware('permission:Admin Club Management Club Member Fees AddReceipts');
Route::get('get_fees',[\App\Http\Controllers\Admin\ClubManagement\MemberController::class, 'get_members_fees'])->middleware('permission:Admin Club Management View Member Fees Tab');
Route::get('get_Totalfees',[\App\Http\Controllers\Admin\ClubManagement\MemberController::class, 'get_members_Totalfees']);

Route::get('get_receipt_data/{id}','App\Http\Controllers\Admin\ClubManagement\MemberController@get_receipt_data');
Route::post('searchClubmember','App\Http\Controllers\Admin\ClubManagement\MemberController@searchClubmember');
Route::Post('search_MemberFees','App\Http\Controllers\Admin\ClubManagement\MemberController@search_MemberFees');


//Roles and permission routes 
Route::get('/all-roles-and-permissions', [RolesController::class, 'allRolesAndPermissions']);
Route::post('/addrole', [RolesController::class, 'addRole'])->middleware('permission:Admin Add Role');
Route::delete('/delete-role/{role}', [RolesController::class, 'deleteRole'])->middleware('permission:Admin Created Roles Delete');
Route::get('/getsinglerolepermission/{roleId}', [RolesController::class, 'getSingleRolePermission']);
Route::put('/update-role/{role}', [RolesController::class, 'updateRole'])->middleware('permission:Admin Created Roles Update');
Route::get('/showuserrole', [RolesController::class, 'showUserRole']);
Route::post('/assignrole', [RolesController::class, 'assignRole']);
Route::get('/user-roles/{id}', [RolesController::class, 'getUserRoles']);
Route::delete('/users/{user}/roles/{role}', [RolesController::class, 'removeRole']);







