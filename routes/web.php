<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/report', 'ReportController@index')->name('report');
Route::get('/shift', 'ShiftController@index')->name('shift');
Route::redirect('/report/send', 'ReportController@back');
Route::post('/report/send', 'ReportController@send');
Route::get('/report/complete', 'ReportController@complete');

Route::get('/test', 'testController@handle');