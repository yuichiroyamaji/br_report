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
Route::get('/report', 'ReportController@showReportPage');
Route::redirect('/report/register', '/laravel/public/report');
Route::post('/report/register', 'ReportController@registerRequest');
Route::get('/report/complete', 'ReportController@showCompletePage');

Route::get('/test', 'testController@handle');