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
    // Dashboard - doar pentru SUPER_ADMIN și COMPANY_ADMIN (verificarea se face în controller)
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
            Route::get('/entries', [App\Http\Controllers\DashboardApiController::class, 'entriesReport']);
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
        Route::post('/add-products', [App\Http\Controllers\ScanPageController::class, 'addProductsToSession']);
        Route::get('/active-sessions', [App\Http\Controllers\ScanPageController::class, 'getActiveSessions']);
        Route::get('/session-stats', [App\Http\Controllers\ScanPageController::class, 'getSessionStats']);
        Route::get('/recent-completed', [App\Http\Controllers\ScanPageController::class, 'recentCompletedSessions']);
        Route::get('/children-with-sessions', [App\Http\Controllers\ScanPageController::class, 'searchChildrenWithActiveSessions']);
        Route::get('/child-session/{childId}', [App\Http\Controllers\ScanPageController::class, 'lookupChildSession']);
        Route::post('/check-guardian-terms', [App\Http\Controllers\ScanPageController::class, 'checkGuardianTerms']);
        Route::post('/accept-guardian-terms', [App\Http\Controllers\ScanPageController::class, 'acceptGuardianTerms']);
        Route::post('/add-products', [App\Http\Controllers\ScanPageController::class, 'addProductsToSession']);
        Route::get('/available-products', [App\Http\Controllers\ScanPageController::class, 'getAvailableProducts']);
        Route::get('/session-products/{sessionId}', [App\Http\Controllers\ScanPageController::class, 'getSessionProducts']);
    });
    
    // Children management
    Route::get('/children/data', [App\Http\Controllers\ChildController::class, 'data'])->name('children.data');
    Route::get('/children-search', [App\Http\Controllers\ChildController::class, 'search'])->name('children.search');
    Route::resource('children', App\Http\Controllers\ChildController::class)
        ->where(['child' => '[0-9]+']);
    
    // Guardians management
    // STAFF poate vedea doar view-ul (show), nu CRUD complet (verificarea se face în controller)
    Route::get('/guardians/{guardian}', [App\Http\Controllers\GuardianController::class, 'show'])->name('guardians.show');
    Route::get('/guardians-search', [App\Http\Controllers\GuardianController::class, 'search'])->name('guardians.search');
    Route::get('/guardians', [App\Http\Controllers\GuardianController::class, 'index'])->name('guardians.index');
    Route::get('/guardians/create', [App\Http\Controllers\GuardianController::class, 'create'])->name('guardians.create');
    Route::post('/guardians', [App\Http\Controllers\GuardianController::class, 'store'])->name('guardians.store');
    Route::get('/guardians/{guardian}/edit', [App\Http\Controllers\GuardianController::class, 'edit'])->name('guardians.edit');
    Route::put('/guardians/{guardian}', [App\Http\Controllers\GuardianController::class, 'update'])->name('guardians.update');
    Route::delete('/guardians/{guardian}', [App\Http\Controllers\GuardianController::class, 'destroy'])->name('guardians.destroy');
    Route::get('/guardians-data', [App\Http\Controllers\GuardianController::class, 'data'])->name('guardians.data');
    
    // Products management - doar pentru SUPER_ADMIN și COMPANY_ADMIN (verificarea se face în controller)
    Route::resource('products', App\Http\Controllers\ProductController::class);
    
    // Legal documents (accessible without auth for parents to read)
    Route::get('/legal/terms', [App\Http\Controllers\LegalController::class, 'terms'])->name('legal.terms');
    Route::get('/legal/gdpr', [App\Http\Controllers\LegalController::class, 'gdpr'])->name('legal.gdpr');
    
    // Birthday reservations (super admin only)
    Route::get('/birthday-reservations', [App\Http\Controllers\BirthdayReservationController::class, 'index'])->name('birthday-reservations.index');
    Route::post('/birthday-reservations', [App\Http\Controllers\BirthdayReservationController::class, 'store'])->name('birthday-reservations.store');
    Route::put('/birthday-reservations/{id}', [App\Http\Controllers\BirthdayReservationController::class, 'update'])->name('birthday-reservations.update');
    Route::delete('/birthday-reservations/{id}', [App\Http\Controllers\BirthdayReservationController::class, 'destroy'])->name('birthday-reservations.destroy');
    
    // Birthday reservations API
    Route::prefix('birthday-reservations-api')->group(function () {
        Route::get('/calendar', [App\Http\Controllers\BirthdayReservationController::class, 'calendar'])->name('birthday-reservations-api.calendar');
    });
    
    // Pricing management (super admin only)
    Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing.index');
    Route::get('/pricing/weekly-rates', [App\Http\Controllers\PricingController::class, 'showWeeklyRates'])->name('pricing.weekly-rates');
    Route::post('/pricing/weekly-rates', [App\Http\Controllers\PricingController::class, 'updateWeeklyRates'])->name('pricing.weekly-rates.update');
    Route::get('/pricing/special-periods', [App\Http\Controllers\PricingController::class, 'indexSpecialPeriods'])->name('pricing.special-periods');
    Route::post('/pricing/special-periods', [App\Http\Controllers\PricingController::class, 'storeSpecialPeriod'])->name('pricing.special-periods.store');
    Route::put('/pricing/special-periods/{id}', [App\Http\Controllers\PricingController::class, 'updateSpecialPeriod'])->name('pricing.special-periods.update');
    Route::delete('/pricing/special-periods/{id}', [App\Http\Controllers\PricingController::class, 'destroySpecialPeriod'])->name('pricing.special-periods.destroy');
    
    // Fiscal receipts (super admin only)
    Route::get('/fiscal-receipts', [App\Http\Controllers\FiscalReceiptController::class, 'index'])->name('fiscal-receipts.index');
    Route::post('/fiscal-receipts/calculate-price', [App\Http\Controllers\FiscalReceiptController::class, 'calculatePrice'])->name('fiscal-receipts.calculate-price');
    Route::post('/fiscal-receipts/print', [App\Http\Controllers\FiscalReceiptController::class, 'print'])->name('fiscal-receipts.print');
});

// Legal documents accessible without authentication
Route::get('/legal/terms', [App\Http\Controllers\LegalController::class, 'terms'])->name('legal.terms.public');
Route::get('/legal/gdpr', [App\Http\Controllers\LegalController::class, 'gdpr'])->name('legal.gdpr.public');
