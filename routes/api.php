<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\StatisticsController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\GameServerController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Player routes
    Route::prefix('player')->group(function () {
        Route::get('/accounts', [PlayerController::class, 'getAccounts']);
        Route::get('/characters', [PlayerController::class, 'getCharacters']);
        Route::get('/characters/{character}', [PlayerController::class, 'getCharacter']);
        Route::put('/profile', [PlayerController::class, 'updateProfile']);
        Route::post('/change-password', [PlayerController::class, 'changePassword']);
    });

    // Statistics routes
    Route::prefix('statistics')->group(function () {
        Route::get('/player', [StatisticsController::class, 'playerStats']);
        Route::get('/character/{character}', [StatisticsController::class, 'characterStats']);
    });

    // Reports
    Route::prefix('reports')->group(function () {
        Route::post('/', [ReportController::class, 'store']);
        Route::get('/my-reports', [ReportController::class, 'myReports']);
    });
});

// Public routes
Route::get('/statistics/global', [StatisticsController::class, 'globalStats']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show']);
Route::get('/servers', [GameServerController::class, 'index']);
Route::get('/servers/{server}', [GameServerController::class, 'show']);
