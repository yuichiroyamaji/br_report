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

//管理画面
Route::domain('admin.com')->group(function () {
	Route::namespace('Back')->as('back.')->group(function() {
		//シフト管理
		Route::prefix('shift')->group(function() {
	    	Route::get('/', 'ShiftController@index')->name('shift');
	    });
	});
});