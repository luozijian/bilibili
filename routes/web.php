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

Route::get('/test', function () {
    return view('barrages.test');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}','EmailController@verify')->name('email.verify');

Route::get('barrages/polling','BarrageController@polling')->name('barrages.polling');
Route::get('barrages/socket','BarrageController@socket')->name('barrages.socket');
Route::resource('barrages','BarrageController');


