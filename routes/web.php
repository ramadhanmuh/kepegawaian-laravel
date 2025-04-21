<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::name('login.')->group(function () {
        Route::get('/', [AuthController::class, 'view'])->name('view'); 
        Route::post('/', [AuthController::class, 'authenticate'])->name('authenticate')
                                                                ->middleware('throttle:5,5'); 
    });
});

Route::middleware('auth')->group(function () {
    Route::name('dashboard.')->group(function () {
        // Route::get('/')
    });
});

