<?php

use App\Http\Controllers\Landing\LandingController;
use Illuminate\Support\Facades\Route;

// Landing page routes - public access, no authentication required
// Only the root route serves the React SPA, which handles client-side routing via hash (#)
Route::get('/', [LandingController::class, 'index'])->name('landing.index');

// SEO dedicated pages - server-side rendered for optimal Google indexing
Route::get('/loc-de-joaca-vaslui', [LandingController::class, 'locDeJoaca'])->name('landing.loc-de-joaca');
Route::get('/petreceri-copii-vaslui', [LandingController::class, 'petreceriCopii'])->name('landing.petreceri');
Route::get('/serbari-copii-vaslui', [LandingController::class, 'serbariCopii'])->name('landing.serbari');

// SEO routes
Route::get('/sitemap.xml', [App\Http\Controllers\Landing\SitemapController::class, 'index'])->name('landing.sitemap');

