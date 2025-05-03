<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SuperAdmin\ApplicationController;
use App\Http\Controllers\SuperAdmin\ChangePasswordController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\DeleteAccountController;
use App\Http\Controllers\SuperAdmin\DesignationController;
use App\Http\Controllers\SuperAdmin\EmployeeController;
use App\Http\Controllers\SuperAdmin\EmployeeEducationController;
use App\Http\Controllers\SuperAdmin\ProfileController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('accept-cookies', [HomeController::class, 'acceptCookie'])->name('accept-cookie');

Route::middleware('cookieconsent')->group(function () {
    Route::middleware('notloggedin')->group(function () {
        Route::prefix('login')->group(function () {
            Route::name('login.')->group(function () {
                Route::get('/', [AuthController::class, 'view'])->name('view'); 
                Route::post('/', [AuthController::class, 'authenticate'])->name('authenticate')
                                                                        ->middleware('throttle:5,5'); 
            });
        });
    
        Route::prefix('forgot-password')->group(function () {
            Route::name('forgot-password.')->group(function () {
                Route::get('/', [ForgotPasswordController::class, 'index'])->name('index');
                Route::post('/', [ForgotPasswordController::class, 'reset'])->name('reset')->middleware('throttle:5,5');
            });
        });
    
        Route::prefix('reset-password')->group(function () {
            Route::name('reset-password.')->group(function () {
                Route::get('/', [ResetPasswordController::class, 'index'])->name('index');
                Route::post('/', [ResetPasswordController::class, 'update'])->name('update');
            });
        });
    });
    
    Route::middleware('haveloggedin')->group(function () {
    
        Route::prefix('super-admin')->group(function () {
            Route::middleware('can:access-super-admin-menu')->group(function () {
                Route::name('super-admin.')->group(function () {
    
                    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        
                    Route::prefix('dashboard')->group(function () {
                        Route::name('dashboard.')->group(function () {
                            Route::get('/', [DashboardController::class, 'index'])->name('index');
                        });
                    });
    
    
                    Route::prefix('profil')->group(function () {
                        Route::name('profile.')->group(function () {
                            Route::get('/', [ProfileController::class, 'index'])->name('index');
                            Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
                            Route::put('edit', [ProfileController::class, 'update'])->name('update');
                        });
                    });
    
                    Route::prefix('change-password')->group(function () {
                        Route::name('change-password.')->group(function () {
                            Route::get('/', [ChangePasswordController::class, 'edit'])->name('edit');
                            Route::put('', [ChangePasswordController::class, 'update'])->name('update');
                        });
                    });
    
                    Route::post('delete-account', [DeleteAccountController::class, 'destroy'])->name('delete-account');

                    Route::prefix('application')->group(function () {
                        Route::name('application.')->group(function () {
                            Route::get('/', [ApplicationController::class, 'index'])->name('index');
                            Route::get('edit', [ApplicationController::class, 'edit'])->name('edit');
                            Route::put('edit', [ApplicationController::class, 'update'])->name('update');
                        });
                    });

                    Route::get('users/list', [UserController::class, 'list'])->name('users.list');
                    Route::resource('users', UserController::class);

                    Route::get('designations/list', [DesignationController::class, 'list'])->name('designations.list');
                    Route::resource('designations', DesignationController::class)->except([
                        'show'
                    ]);

                    Route::get('employees/list', [EmployeeController::class, 'list'])->name('employees.list');
                    Route::resource('employees', EmployeeController::class);

                    Route::get('employee-education/list', [EmployeeEducationController::class, 'list'])->name('employee-education.list');
                    Route::resource('employee-education', EmployeeEducationController::class);
                    
                });
            });
        });
    
        Route::prefix('admin')->group(function () {
            Route::middleware('can:access-admin-menu')->group(function () {
                Route::name('admin.')->group(function () {
    
                    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
                    Route::prefix('dashboard')->group(function () {
                        Route::name('dashboard.')->group(function () {
                            Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
                        });
                    });
    
                });
            });
        });
    
    });
});