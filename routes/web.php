<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OmdOrderController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\TpsRepairController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', fn () => redirect()->route('dashboard'));

    Route::get('/dashboard', function () {
        return auth()->user()->role === 'user'
            ? app(UserDashboardController::class)->index(request())
            : app(DashboardController::class)->index(request());
    })
        ->middleware('role:omd_leader,omd_member,user')
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            // TPS Tool
            Route::get('/tps', [TpsRepairController::class, 'userIndex'])
                ->name('tps.index');

            Route::get('/tps/create', [TpsRepairController::class, 'create'])
                ->name('tps.create');

            Route::post('/tps', [TpsRepairController::class, 'store'])
                ->name('tps.store');

            Route::get('/tps/{order}', [TpsRepairController::class, 'userShow'])
                ->name('tps.show');

            Route::post('/tps/{order}/confirm', [TpsRepairController::class, 'confirm'])
                ->name('tps.confirm');

            // Order Repair
            Route::get('/orders', [UserOrderController::class, 'index'])
                ->name('orders.index');

            Route::get('/orders/create', [UserOrderController::class, 'create'])
                ->name('orders.create');

            Route::post('/orders', [UserOrderController::class, 'store'])
                ->name('orders.store');

            Route::get('/orders/{order}', [UserOrderController::class, 'show'])
                ->name('orders.show');

            Route::post('/orders/{order}/confirm', [UserOrderController::class, 'confirm'])
                ->name('orders.confirm');
        });

    /*
    |--------------------------------------------------------------------------
    | OMD Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:omd_member,omd_leader')
        ->prefix('omd')
        ->name('omd.')
        ->group(function () {

            // TPS Tool
            Route::get('/tps', [TpsRepairController::class, 'omdIndex'])
                ->name('tps.index');

            Route::get('/tps/{order}', [TpsRepairController::class, 'omdShow'])
                ->name('tps.show');

            Route::post('/tps/{order}/leader-check', [TpsRepairController::class, 'leaderCheck'])
                ->name('tps.leader-check');

            Route::post('/tps/{order}/verify', [TpsRepairController::class, 'verify'])
                ->name('tps.verify');

            Route::post('/tps/{order}/schedule', [TpsRepairController::class, 'schedule'])
                ->name('tps.schedule');

            Route::post('/tps/{order}/complete', [TpsRepairController::class, 'complete'])
                ->name('tps.complete');

            // Order Repair
            Route::get('/orders', [OmdOrderController::class, 'index'])
                ->name('orders.index');

            Route::get('/orders/{order}', [OmdOrderController::class, 'show'])
                ->name('orders.show');

            Route::post('/orders/{order}/verify', [OmdOrderController::class, 'verify'])
                ->name('orders.verify');

            Route::post('/orders/{order}/start-repair', [OmdOrderController::class, 'startRepair'])
                ->name('orders.start');

            Route::post('/orders/{order}/complete', [OmdOrderController::class, 'complete'])
                ->name('orders.complete');

            // Recap
            Route::get('/recap', fn () => redirect()->route('dashboard'))
                ->name('recap');
        });
});