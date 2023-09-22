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
    Route::get('getOne/{id}', 'EmployeeController@singleEmployee');
    Route::post('save-record', 'EmployeeController@storeRecord');
    Route::get('get-record/{id}', 'EmployeeController@getRecord');
});

Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
    Route::post('generate', 'ReportController@generateReportApi');
});