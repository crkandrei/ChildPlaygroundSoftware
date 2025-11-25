<?php

use App\Http\Controllers\Landing\LandingController;
use Illuminate\Support\Facades\Route;

// Landing page routes - public access, no authentication required
// Only the root route serves the React SPA, which handles client-side routing via hash (#)
Route::get('/', [LandingController::class, 'index'])->name('landing.index');

// SEO routes
Route::get('/sitemap.xml', [App\Http\Controllers\Landing\SitemapController::class, 'index'])->name('landing.sitemap');

