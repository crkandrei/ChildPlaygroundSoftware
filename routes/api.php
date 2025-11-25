<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rute pentru scanare brățară (temporar fără middleware pentru test)
Route::prefix('scan')->group(function () {
    Route::post('/generate', [App\Http\Controllers\ScanPageController::class, 'generateCode']);
    Route::post('/lookup', [App\Http\Controllers\ScanPageController::class, 'lookupBracelet']);
    Route::post('/assign', [App\Http\Controllers\ScanPageController::class, 'assignBracelet']);
    Route::post('/create-child', [App\Http\Controllers\ScanPageController::class, 'createChild']);
    Route::post('/start-session', [App\Http\Controllers\ScanPageController::class, 'startSession']);
    Route::post('/stop-session/{id}', [App\Http\Controllers\ScanPageController::class, 'stopSession']);
    Route::post('/pause-session/{id}', [App\Http\Controllers\ScanPageController::class, 'pauseSession']);
    Route::post('/resume-session/{id}', [App\Http\Controllers\ScanPageController::class, 'resumeSession']);
    Route::post('/add-products', [App\Http\Controllers\ScanPageController::class, 'addProductsToSession']);
    Route::get('/available-products', [App\Http\Controllers\ScanPageController::class, 'getAvailableProducts']);
    Route::get('/session-products/{sessionId}', [App\Http\Controllers\ScanPageController::class, 'getSessionProducts']);
    Route::get('/active-sessions', [App\Http\Controllers\ScanPageController::class, 'getActiveSessions']);
    Route::get('/session-stats', [App\Http\Controllers\ScanPageController::class, 'getSessionStats']);
    Route::post('/validate', [ScanController::class, 'validateCode']);
    Route::get('/recent', [ScanController::class, 'getRecentScans']);
    Route::get('/stats', [ScanController::class, 'getStats']);
    Route::post('/cleanup', [ScanController::class, 'cleanupExpiredCodes']);
});

// Landing page API routes (public)
Route::prefix('landing')->group(function () {
    Route::post('/contact', [App\Http\Controllers\Api\LandingApiController::class, 'contact']);
    Route::post('/reservation', [App\Http\Controllers\Api\LandingApiController::class, 'reservation']);
});

// Rute protejate cu autentificare web
Route::middleware('auth')->group(function () {

    // Rute pentru dashboard
    Route::get('/dashboard/stats', [App\Http\Controllers\DashboardApiController::class, 'stats']);

    // Rute pentru sesiuni
    Route::get('/sessions/active', [App\Http\Controllers\ScanPageController::class, 'getActiveSessions']);
    Route::post('/sessions/start', [App\Http\Controllers\ScanPageController::class, 'startSession']);
    Route::post('/sessions/{id}/stop', [App\Http\Controllers\ScanPageController::class, 'stopSession']);
    Route::get('/sessions/stats', [App\Http\Controllers\ScanPageController::class, 'getSessionStats']);

    // Rute pentru activitate
    Route::get('/activity/recent', [App\Http\Controllers\DashboardApiController::class, 'recentActivity']);
});
