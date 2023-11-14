<?php

use App\Http\Controllers\Procurement\Inventory\StockDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


Route::get('/roles', 'RoleController@index');
Route::get('/sub-roles', 'SubRoleController@index');
Route::get('/permissions', 'PermissionController@index');

