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

Route::get('/', 'HomeController@index')
    ->name('home');
    
Route::get('/detail/{slug}', 'DetailController@index')
    ->name('detail');

Route::post('/checkout/{id}', 'CheckoutController@process')
    ->name('checkout_process')
    ->middleware(['auth', 'verified']);

Route::get('/my-order', 'HomeController@myOrder')
    ->name('my-order')
    ->middleware(['auth', 'verified']);

Route::get('/checkout/{id}', 'CheckoutController@index')
    ->name('checkout')
    ->middleware(['auth', 'verified']);

Route::get('/checkout/{transaction}/cancel', 'CheckoutController@cancelTransaction')
    ->name('checkout.cancel')
    ->middleware(['auth', 'verified']);

Route::post('/checkout/create/{detail_id}', 'CheckoutController@create')
    ->name('checkout-create')
    ->middleware(['auth', 'verified']);

Route::get('/checkout/remove/{detail_id}', 'CheckoutController@remove')
    ->name('checkout-remove')
    ->middleware(['auth', 'verified']);

Route::post('/checkout/confirm/{id}', 'CheckoutController@success')
    ->name('checkout-success')
    ->middleware(['auth', 'verified']);

Route::get('/my-order/{transaction}/rate', 'RatingController@create')
    ->name('my-order.rate')
    ->middleware(['auth', 'verified']);

Route::post('/my-order/{transaction}/rate', 'RatingController@store')
    ->middleware(['auth', 'verified']);

Route::get('rating','RatingController@index')
    ->name('rating.index')->prefix('admin')->middleware(['auth', 'admin']);

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/','DashboardController@index')
            ->name('dashboard');
        Route::resource('health-package', 'HealthPackageController');
        Route::resource('gallery', 'GalleryController');
        Route::resource('worker', 'WorkerController');
        Route::get('/transaction/{trx}/confirm', 'TransactionController@confirmPayment')->name("transaction.confirm");
        Route::get('/transaction/{trx}/reject', 'TransactionController@rejectPayment')->name("transaction.reject");
        Route::get('/transaction/week', 'TransactionController@weekTransaction')->name("transaction.week");
        Route::get('/transaction/month', 'TransactionController@monthTransaction')->name("transaction.month");
        Route::get('/transaction/year', 'TransactionController@yearTransaction')->name("transaction.year");
        Route::get('/transaction/today', 'TransactionController@todayTransaction')->name("transaction.today");
        Route::get('/transaction/cancel-request', 'TransactionController@cancelRequest')->name("transaction.cancel-request");
        Route::get('/transaction/cancel-request/{transaction}/refund', 'TransactionController@cancelRequestCompleted')->name("transaction.cancel-request.refund");
        Route::get('/transaction/cancel-request/{transaction}', 'TransactionController@cancelRequestDetail')->name("transaction.cancel-request.show");
        Route::get('/transaction/today/{item}/assign', 'TransactionController@selectWorkerView')->name("transaction.assign-worker");
        Route::put('/transaction/today/{item}/assign', 'TransactionController@assignWorker');
        Route::resource('transaction', 'TransactionController');
        
    });
Auth::routes(['verify' => true]);