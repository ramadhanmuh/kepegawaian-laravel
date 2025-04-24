<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('notloggedin')->group(function () {
    Route::name('login.')->group(function () {
        Route::get('/', [AuthController::class, 'view'])->name('view'); 
        Route::post('/', [AuthController::class, 'authenticate'])->name('authenticate')
                                                                ->middleware('throttle:5,5'); 
    });

    Route::prefix('forgot-password')->group(function () {
        Route::name('forgot-password.')->group(function () {
            Route::get('/', [ForgotPasswordController::class, 'index'])->name('index');
            Route::post('/', [ForgotPasswordController::class, 'reset'])->name('reset');
        });
    });

    Route::get('reset-password', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
});

Route::middleware('haveloggedin')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->group(function () {
        Route::name('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
        });
    });
});