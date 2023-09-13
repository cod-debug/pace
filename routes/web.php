<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::group(['prefix' => 'office', 'as' => 'office.'], function () {
    Route::get('/', 'OfficeController@index')->name('list');
    Route::get('/add', 'OfficeController@add')->name('add');
    Route::post('/store', 'OfficeController@store')->name('store');
    Route::post('/update', 'OfficeController@update')->name('update');
    Route::post('/delete', 'OfficeController@delete')->name('delete');
    Route::get('/list-api', 'OfficeController@list')->name('list-api');
    Route::get('/list-all-api', 'OfficeController@listAll')->name('list-all-api'); 
});

Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
    Route::get('/', 'EmployeeController@index')->name('list');
    Route::get('/add', 'EmployeeController@add')->name('add');
});