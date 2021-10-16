<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
Auth::routes();

/* Route::get('/index', function()
{
    return
}); */

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function ()
{
    // entry point of site
    Route::get('/home', 'HomeController@index')->name('home');

    // create user_order and orders
    Route::post('/createOrder','OrderController@createOrder')->name('create.order');

    // get data for view data of the order on modal
    Route::post('/infoOrder','OrderController@getOrderById')->name('info.order');

    // delete order
    Route::post('/deleteOrder','OrderController@deleteOrder')->name('info.order');

    // validate create order form
    Route::post('/validateCreateOrder','OrderController@store')->name('validate.order');

    // search name for info about user
    Route::post('/searchLive','UserOrderController@searchUser')->name('search.user');

    // get user information
    Route::post('/getUser','UserOrderController@getUser')->name('user.info');

    // view settings of order
    Route::post('/settings','OrderController@changeOrder')->name('settings.order');

    // update order and user information
    Route::post('/updateOrder','OrderController@updateOrder')->name('update.order');

    // get notify of change
    Route::post('/notify','OrderController@notifyOrder')->name('notify');

    // get total pasta
    Route::post('/totalPasta','StatisticController@totalPasta')->name('total.pasta');

    // save total pasta
    Route::post('/saveTotalPasta','StatisticController@saveTotalPasta')->name('save.total');

});

