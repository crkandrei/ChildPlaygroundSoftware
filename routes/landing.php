<?php

use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Landing\ContactController;
use App\Http\Controllers\Landing\ReservationController;
use Illuminate\Support\Facades\Route;

// Landing page routes - public access, no authentication required
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/despre', [LandingController::class, 'about'])->name('landing.about');
Route::get('/servicii', [LandingController::class, 'services'])->name('landing.services');
Route::get('/preturi', [LandingController::class, 'pricing'])->name('landing.pricing');
Route::get('/galerie', [LandingController::class, 'gallery'])->name('landing.gallery');

// Contact form
Route::get('/contact', [ContactController::class, 'show'])->name('landing.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('landing.contact.store');

// Reservation form
Route::get('/rezervare', [ReservationController::class, 'show'])->name('landing.reservation');
Route::post('/rezervare', [ReservationController::class, 'store'])->name('landing.reservation.store');

// SEO routes
Route::get('/sitemap.xml', [App\Http\Controllers\Landing\SitemapController::class, 'index'])->name('landing.sitemap');

