<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('home');
Route::get('/install', [HomeController::class, 'install'])->name('install');
Route::get('/token', [HomeController::class, 'token'])->name('token');
