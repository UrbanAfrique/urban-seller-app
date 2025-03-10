<?php

use App\Http\Controllers\FulfillmentController;
use Illuminate\Support\Facades\Route;

Route::resource('products', 'ProductController')->except('update');
Route::post('products/{id}', 'ProductController@update')->name('products.update');
Route::resource('orders', 'OrderController');
Route::get('fulfillment/{id}/create', [FulfillmentController::class, 'create'])
    ->name('fulfillment.create');
Route::post('fulfillment/{id}/store', [FulfillmentController::class, 'store'])
    ->name('fulfillment.store');

