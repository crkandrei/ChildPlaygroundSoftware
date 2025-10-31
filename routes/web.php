<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index']);

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [WebController::class, 'dashboard'])->name('dashboard');
        Route::get('/rapoarte', [App\Http\Controllers\ReportsController::class, 'index'])->name('reports.index');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    
    // Scan page
    Route::get('/scan', [App\Http\Controllers\ScanPageController::class, 'index'])->name('scan');

    // Sessions page (read-only)
    Route::get('/sessions', [App\Http\Controllers\SessionsController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/data', [App\Http\Controllers\SessionsController::class, 'data'])->name('sessions.data');
    Route::get('/sessions/{id}/show', [App\Http\Controllers\SessionsController::class, 'show'])->name('sessions.show');
    Route::get('/sessions/{id}/receipt', [App\Http\Controllers\SessionsController::class, 'receipt'])->name('sessions.receipt');

    // Dashboard API (session-auth via web guard)
    Route::prefix('dashboard-api')->group(function () {
        Route::get('/stats', [App\Http\Controllers\DashboardApiController::class, 'stats']);
            Route::get('/active-sessions', [App\Http\Controllers\ScanPageController::class, 'getActiveSessions']);
        Route::post('/sessions/{id}/stop', [App\Http\Controllers\ScanPageController::class, 'stopSession']);
        Route::post('/sessions/{id}/pause', [App\Http\Controllers\ScanPageController::class, 'pauseSession']);
        Route::post('/sessions/{id}/resume', [App\Http\Controllers\ScanPageController::class, 'resumeSession']);
    });

        // Reports API (moved from dashboard)
        Route::prefix('reports-api')->group(function () {
            Route::get('/activity', [App\Http\Controllers\DashboardApiController::class, 'recentActivity']);
            Route::get('/reports', [App\Http\Controllers\DashboardApiController::class, 'reports']);
        });

    // Scan API (session-auth via web guard)
    Route::prefix('scan-api')->group(function () {
        Route::post('/generate', [App\Http\Controllers\ScanPageController::class, 'generateCode']);
        Route::post('/lookup', [App\Http\Controllers\ScanPageController::class, 'lookupBracelet']);
        Route::post('/assign', [App\Http\Controllers\ScanPageController::class, 'assignBracelet']);
        Route::post('/create-child', [App\Http\Controllers\ScanPageController::class, 'createChild']);
        Route::post('/start-session', [App\Http\Controllers\ScanPageController::class, 'startSession']);
        Route::post('/stop-session/{id}', [App\Http\Controllers\ScanPageController::class, 'stopSession']);
        Route::post('/pause-session/{id}', [App\Http\Controllers\ScanPageController::class, 'pauseSession']);
        Route::post('/resume-session/{id}', [App\Http\Controllers\ScanPageController::class, 'resumeSession']);
        Route::get('/active-sessions', [App\Http\Controllers\ScanPageController::class, 'getActiveSessions']);
        Route::get('/session-stats', [App\Http\Controllers\ScanPageController::class, 'getSessionStats']);
        Route::get('/recent-completed', [App\Http\Controllers\ScanPageController::class, 'recentCompletedSessions']);
        Route::get('/children-with-sessions', [App\Http\Controllers\ScanPageController::class, 'searchChildrenWithActiveSessions']);
        Route::get('/child-session/{childId}', [App\Http\Controllers\ScanPageController::class, 'lookupChildSession']);
    });
    
    // Children management
    Route::get('/children/data', [App\Http\Controllers\ChildController::class, 'data'])->name('children.data');
    Route::get('/children-search', [App\Http\Controllers\ChildController::class, 'search'])->name('children.search');
    Route::resource('children', App\Http\Controllers\ChildController::class)
        ->where(['child' => '[0-9]+']);
    
    // Guardians management
    Route::resource('guardians', App\Http\Controllers\GuardianController::class);
    Route::get('/guardians-search', [App\Http\Controllers\GuardianController::class, 'search'])->name('guardians.search');
    Route::get('/guardians-data', [App\Http\Controllers\GuardianController::class, 'data'])->name('guardians.data');
    
    // Bracelets management
    Route::resource('bracelets', App\Http\Controllers\BraceletController::class);
    Route::post('/bracelets/{bracelet}/unassign', [App\Http\Controllers\BraceletController::class, 'unassign'])->name('bracelets.unassign');
});
