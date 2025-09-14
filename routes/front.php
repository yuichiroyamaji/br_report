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
	//日報
	Route::prefix('report')->group(function() {
	    Route::get('/', 'ReportController@index');
		Route::post('/send', 'ReportController@send');
		Route::get('/complete', 'ReportController@complete');
	});
});

//管理画面
Route::prefix('admin')->namespace('Back')->as('back.')->group(function() {
	//シフト管理
	Route::prefix('shift')->group(function() {
    	Route::get('/', 'ShiftController@index')->name('shift');
    	Route::post('/confirm', 'ShiftController@confirm')->name('shift.confirm');
    	Route::get('/store', 'ShiftController@store')->name('shift.store');
    });
});

Route::get('/test', 'testController@handle');