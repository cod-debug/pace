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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('dashboard')->middleware('logged_in');

Route::group(['prefix' => 'office', 'as' => 'office.', 'middleware' => ['logged_in']], function () {
    Route::get('/', 'OfficeController@index')->name('list');
    Route::get('/add', 'OfficeController@add')->name('add');
    Route::post('/store', 'OfficeController@store')->name('store');
    Route::post('/update', 'OfficeController@update')->name('update');
    Route::post('/delete', 'OfficeController@delete')->name('delete');
    Route::get('/list-api', 'OfficeController@list')->name('list-api');
    Route::get('/list-all-api', 'OfficeController@listAll')->name('list-all-api'); 
});

Route::group(['prefix' => 'employee', 'as' => 'employee.', 'middleware' => ['logged_in']], function () {
    Route::get('/', 'EmployeeController@index')->name('list');
    Route::get('/add', 'EmployeeController@add')->name('add');
    Route::get('/record/{id}', 'EmployeeController@record')->name('record');
    Route::get('/list-paginated', 'EmployeeController@listPaginated')->name('list-paginated');
    Route::get('/edit/{id}', 'EmployeeController@edit')->name('edit');
});

Route::group(['prefix' => 'report', 'as' => 'report.', 'middleware' => ['logged_in']], function () {
    Route::get('/', 'ReportController@index')->name('index');
});

Route::group(['prefix' => 'agency_fee', 'as' => 'agency_fee.', 'middleware' => ['logged_in']], function () {
    Route::get('/', 'AgencyFeeController@index')->name('index');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['logged_in']], function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/add', 'UserController@create')->name('create');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['logged_in']], function () {
    Route::get('/', 'ProfileController@index')->name('index');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
