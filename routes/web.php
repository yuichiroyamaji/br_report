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

//オリジナル
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

//フロント画面
Route::namespace('Front')->as('front.')->group(function() {
    Route::get('/report', 'ReportController@index')->name('report');
    Route::redirect('/report/send', 'ReportController@back');
	Route::post('/report/send', 'ReportController@send');
	Route::get('/report/complete', 'ReportController@complete');
});

//管理画面
Route::prefix('admin')->namespace('Back')->as('back.')->group(function() {
    Route::get('/shift', 'ShiftController@index')->name('shift');
});

Route::get('/test', 'testController@handle');