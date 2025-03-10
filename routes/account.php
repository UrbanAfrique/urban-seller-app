<?php

use App\Http\Controllers\VendorController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function () {
    Route::any('/', [VendorController::class, 'createByProxy'])->name('account');
    Route::post('/store', [VendorController::class, 'storeByProxy'])->name('account.store');
});
Route::prefix('profile')->group(function () {
    Route::get('/', [VendorController::class, 'editByProxy'])->name('account.edit');
    Route::post('/update/{id}', [VendorController::class, 'updateByProxy'])->name('account.update');
});

Route::prefix('plan')->group(function () {
     Route::any('/payout-create', [PlanController::class, 'createByProxy'])->name('payout.create');
     Route::post('/payout-store', [PlanController::class, 'storeByProxy'])->name('payout.store');
      Route::get('/subscriptions', [PlanController::class, 'subscriptions'])->name('payout.subscriptions');
});