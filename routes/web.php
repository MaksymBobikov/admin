<?php

use Maksb\Admin\Http\Controllers\Auth\AuthController;
use Maksb\Admin\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'loginPage'])->name('maksb/admin::admin.login');
    Route::get('register', [AuthController::class, 'registerPage'])->name('admin.registerPage');

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('admin.loginPost');
        Route::get('check', [AuthController::class, 'check']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware(['admin_auth:admin'])->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::prefix('auth')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
        });

        Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify.api');
        Route::post('/email/verification-notification', [AuthController::class, 'sendVerifyNotification'])->middleware(['throttle:6,1'])->name('verification.send');
    });

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});
