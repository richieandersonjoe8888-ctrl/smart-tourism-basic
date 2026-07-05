<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorApplicationController;

Route::get('/', function () {
    return view('welcome');
});

// Protect your admin console with both auth and your custom role middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    // The main dashboard view
    Route::get('/admin/panel', [AdminController::class, 'index'])->name('admin.panel');
    
    // Action routes for dashboard buttons
    Route::post('/admin/vendor/{user}/handle', [AdminController::class, 'handleVendorRequest'])->name('admin.vendor.handle');
    Route::post('/admin/user/{user}/ban', [AdminController::class, 'toggleUserBan'])->name('admin.user.ban');
    Route::post('/admin/tags', [AdminController::class, 'storeTag'])->name('admin.tags.store');
    Route::post('/admin/applications/{application}/handle', [AdminController::class, 'handleApplicationAction'])->name('admin.application.handle');
});

Route::middleware(['auth'])->group(function () {
    // Show the application page or waiting status screen
    Route::get('/vendor/apply', [VendorApplicationController::class, 'showForm'])->name('vendor.apply.form');
    
    // Process form submission (Throttled to max 2 attempts per 24 hours per user account)
    Route::post('/vendor/apply', [VendorApplicationController::class, 'storeApplication'])
        ->middleware('throttle:2,1440')
        ->name('vendor.apply.store');
});