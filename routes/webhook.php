<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::any('create', [ProductController::class, 'createWebhook']);
    Route::any('update', [ProductController::class, 'updateWebhook']);
    Route::any('delete', [ProductController::class, 'deleteWebhook']);
});
Route::prefix('orders')->group(function () {
    Route::any('create', [OrderController::class, 'createWebhook']);
    Route::any('updated', [OrderController::class, 'updateWebhook']);
});
Route::prefix('collections')->group(function () {
    Route::any('create', [CollectionController::class, 'createWebhook']);
    Route::any('update', [CollectionController::class, 'updateWebhook']);
    Route::any('delete', [CollectionController::class, 'deleteWebhook']);
});
Route::prefix('customers')->group(function () {
    Route::any('create', [CustomerController::class, 'createWebHook']);
    Route::any('update', [CustomerController::class, 'updateWebHook']);
    Route::any('delete', [CustomerController::class, 'deleteWebHook']);
});
Route::prefix('fulfillments')->group(function () {
    Route::any('create', [OrderController::class, 'applyFulfillmentWebhook'])->name('webhook-fulfillments-create');
});
