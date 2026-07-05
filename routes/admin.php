<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CharacterController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\GameBalanceController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\PlayerReportController;

Route::middleware(['auth:sanctum', 'role:admin|super_admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Account Management
    Route::resource('accounts', AccountController::class);
    Route::post('/accounts/{account}/ban', [AccountController::class, 'ban']);
    Route::post('/accounts/{account}/unban', [AccountController::class, 'unban']);

    // Character Management
    Route::resource('characters', CharacterController::class);
    Route::post('/characters/{character}/add-currency', [CharacterController::class, 'addCurrency']);
    Route::post('/characters/{character}/reset-level', [CharacterController::class, 'resetLevel']);

    // Item Management
    Route::resource('items', ItemController::class);
    Route::post('/items/distribute', [ItemController::class, 'distribute']);

    // Game Balance
    Route::resource('game-balance', GameBalanceController::class);

    // Announcements
    Route::resource('announcements', AnnouncementController::class);
    Route::post('/announcements/{announcement}/publish', [AnnouncementController::class, 'publish']);

    // Player Reports
    Route::resource('reports', PlayerReportController::class);
});
