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
});

Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
    Route::get('/', 'EmployeeController@index')->name('list');
    Route::get('/add', 'EmployeeController@add')->name('add');
});