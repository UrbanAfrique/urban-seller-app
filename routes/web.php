<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('webhooks')->group(function () {
    require __DIR__ . "/webhook.php";
});
Route::prefix('app')->as('app.')->group(function () {
    //installation Routes
    Route::get('', [HomeController::class, 'index'])->name('home');
    Route::get('/install', [HomeController::class, 'install'])->name('install');
    Route::get('/token', [HomeController::class, 'token'])->name('token');

    
    Route::post('product/status/{id}', [ProductController::class, 'changeStatus'])
    ->name('product.status')->middleware('cors');
    Route::get('withdraws', [BalanceController::class, 'withdraws'])->name('withdraws');
    Route::resource('vendors', 'VendorController');
    Route::resource('settings', 'SettingController');
    Route::resource('sellers', 'SellerController');
    require __DIR__ . "/global.php";
});

Route::prefix('proxy')->middleware(['cors', 'proxy.auth'])->as('proxy.')
->group(function () {
    Route::resource('balance', 'BalanceController');
    Route::any('/', [VendorController::class, 'proxyDashboard'])->name('dashboard');
    Route::any('add_payout', [BalanceController::class, 'addPayout'])->name('add_payout');
    Route::any('reset_payout', [BalanceController::class, 'resetPayout'])->name('payout.reset');
        require __DIR__ . "/account.php";
        require __DIR__ . "/global.php";
    });
Route::prefix('approve')->middleware('cors')->as('approve.')->group(function () {
    Route::post('vendor',   [ApprovalController::class, 'vendorApproval'])->name('vendor');
    Route::post('withdraw', [ApprovalController::class, 'withdrawApproval'])->name('withdraw');
    Route::post('product',  [ApprovalController::class, 'productApproval'])->name('product');
});
