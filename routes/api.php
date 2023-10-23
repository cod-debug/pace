<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
    Route::post('store', 'EmployeeController@store');
    Route::post('storeUpdate', 'EmployeeController@storeUpdate');
    Route::get('getOne/{id}', 'EmployeeController@singleEmployee');
    Route::post('save-record', 'EmployeeController@storeRecord');
    Route::post('update-record/{id}', 'EmployeeController@updateRecord');
    Route::get('get-record/{id}', 'EmployeeController@getRecord');
    Route::get('trash/{id}', 'EmployeeController@trashEmployee');
});

Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
    Route::post('generate', 'ReportController@generateReportApi');
});


Route::group(['prefix' => 'agency_fee', 'as' => 'agency_fee.'], function () {
    Route::post('store', 'AgencyFeeController@storeAgencyFee');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('check', 'CheckAuth@checkAuth');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['logged_in']], function () {
    Route::post('/store', 'UserController@store');
    Route::get('/get-list', 'UserController@getPaginatedList');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['logged_in']], function () {
    Route::post('/update', 'ProfileController@saveUpdate');
    Route::post('/change-password', 'ProfileController@changePassword');
});