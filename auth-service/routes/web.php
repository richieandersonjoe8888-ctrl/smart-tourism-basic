<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
});